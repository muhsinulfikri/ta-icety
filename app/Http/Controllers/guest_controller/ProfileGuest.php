<?php

namespace App\Http\Controllers\guest_controller;

use App\Models\User;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileGuest extends Controller
{
    protected $user;

    public function __construct(User $genericModel)
    {
        // $this->genericModel = $genericModel;
    }

    public function profile()
    {
        $data['title'] = "Personal Data";
        $user = new User();
        // $data['data_personal'] = $user->get_user(session('user')[0]['ID_USER']);
        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");
        return
            view('template.header', $data) .
            view('template_guest/profile/personal', $data) .
            view('template.footer', $data);
    }
    public function ebook()
    {
        $data['title'] = "My Books";
        $user = new User();
        $data['mybook'] = [];
        $mybook = $user->get_my_ebook();
        foreach ($mybook as $item) {
            if ($item->DATA_CHECKING == 1) {
                array_push($data['mybook'], $item);
            }
        }

        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/myebook',$data) .
            view('template.footer', $data);
    }
    public function academic()
    {
        $data['title'] = "Academic Data";
        $data['academic'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user_data u
            WHERE
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/academic', $data) .
            view('template.footer', $data);

    }
    public function document()
    {
        $data['title'] = "Supporting Documents";
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/document', $data) .
            view('template.footer', $data);
    }
    public function overview()
    {
        $data['title'] = "Supporting Documents";
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/overview', $data) .
            view('template.footer', $data);
    }
    public function myevents()
    {
        $data['title'] = "My Event";
        $user = new User();
        $data['event'] = [];
        $mycourse = $user->get_my_product2();
        foreach ($mycourse as $item) {
            if ($item->DATA_CHECKING == 1) {
                array_push($data['event'], $item);
            }
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';
        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/myevents', $data) .
            view('template.footer', $data);
    }
    public function mycourses()
    {
        $data['title'] = "My Courses";
        $user = new User();
        // dd($data);
        $data['course'] = [];
        $mycourse = $user->get_my_product();
        foreach ($mycourse as $item) {
            if ($item->DATA_CHECKING >= 1) {
                array_push($data['course'], $item);
            }
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");
        // dd($data['course']);
        return
            view('template.header', $data) .
            view('template_guest/profile/mycourses', $data) .
            view('template.footer', $data);
    }

    public function vouchers(){
        $data['title'] = 'My Voucher';
        $data['vouchers'] = DB::select("
            SELECT
                claimed_promo.ID_PROMO, PROMO_NAME, EXP_DATE, STATUS
            FROM
                claimed_promo
            LEFT JOIN
                promo
            ON
                claimed_promo.ID_PROMO = promo.ID_PROMO
        ");
        $data['document'] = DB::selectOne("
            SELECT
                STATUS
            FROM
                claimed_promo
        ");
        // dd($data);
        return
            view('template.header', $data).
            view('template_guest/profile/myvoucher', $data).
            view('template.footer', $data);
    }
    public function update_profile(request $request)
    {
        $data = array(
            [
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'TELP' => $request->input('no_hp'),
                'JK' => $request->input('jk'),
            ]
        );
        if (!empty($request->file('foto_profile'))) {
            $data[0]['FOTO_PROFILE'] = FileUpload::S3($request->file('foto_profile'), 'FOTO_PROFILE', 'Foto-Profile-' . strtotime(now()));
        }
        $updateStatus = User::update_profile($data);
        if ($updateStatus) {
            $user_data = collect([
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'ID_USER' => session('user')[0]['ID_USER'],
                'ID_ROLE' => session('user')[0]['ID_ROLE'],
                'LOGGED_IN' => TRUE
            ]);
            Session::flush();
            Session::push('user', $user_data);
        }
        return redirect('/profile');
    }
    public function academic_change(request $request)
    {
        $userId = session('user')[0]['ID_USER'];
        $data = [
            'ID_USER' => $userId,
            'UNIV' => $request->input('univ'),
            'NIM' => $request->input('nim'),
            'STUDY' => $request->input('study'),
            'DEGREE' => $request->input('degree'),
            'SEMESTER' => empty($request->input('sem')) ? 0 : $request->input('sem'),
            'IS_GRADUATED' => empty($request->input('sem')) ? 1 : 0
        ];
        $user = DB::table('user_data')->where('ID_USER', $userId)->first();
        if ($user) {
            $updated = DB::table('user_data')->where('ID_USER', $userId)->update($data);
        } else {
            $updated = DB::table('user_data')->insert($data);
        }
        // $updateStatus = User::updateTableById($data);
        return redirect('/profile/academic');
    }
    public function doc_up(request $request)
    {
        $userId = session('user')[0]['ID_USER'];
        $data = [];
        if (!empty($request->file('file_cv'))) {
            $data['CV'] = FileUpload::S3_PDF($request->file('file_cv'), 'Instructor_CV', 'Curriculum-Vitae-' . strtotime(now()));
        }
        if (!empty($request->file('file_porto'))) {
            $data['PORTOFOLIO'] = FileUpload::S3_PDF($request->file('file_porto'), 'Instructor_PORTOFOLIO', 'Portfolio-' . strtotime(now()));
        }
        if (!empty($request->file('file_cert'))) { // Remove the [] from 'file_cert'
            $data['SERTIFIKAT'] = FileUpload::S3_PDF($request->file('file_cert'), 'Instructor_CERT', 'Certificates-' . strtotime(now()));
        }
        if (!empty($request->file('file_recom'))) {
            $data['SURAT_RECOM'] = FileUpload::S3_PDF($request->file('file_recom'), 'Instructor_RECOM', 'Recommendation-Letter-' . strtotime(now()));
        }
        $user = DB::table('user_data')->where('ID_USER', $userId)->first();
        $updated = DB::table('user_data')->updateOrInsert(['ID_USER' => $userId], $data);
        // $updateStatus = User::updateTableById($data);
        return redirect('/profile/document');
    }

    public function update_sertif(request $request)
    {
        $data = [
            'IS_DOWNLOADED' => 1
        ];
        DB::table('sertifikat_activity')->where('ID_ACTIVITY', $request->id_activity)->where('ID_USER', session('user')[0]['ID_USER'])->update($data);
        return response()->json(['status' => 'success']);
    }

    public function mysertificate()
    {
        $data['title'] = "Sertifikat Ku";

        $data['sertif'] = DB::select("
            SELECT
                s.ID_SERTIFIKAT,
                s.FILE_SERTIFIKAT,
                a.TITLE_ACTIVITY,
                a.TYPE_ACTIVITY
            FROM
                sertifikat_activity s
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = s.ID_ACTIVITY
            WHERE
                s.ID_USER = '" . session('user')[0]['ID_USER'] . "'
                AND s.IS_DOWNLOADED = 1
            ");

            $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");
        if(!empty($data['sertif'])){
            $data['id'] = Crypt::encryptString($data['sertif'][0]->ID_SERTIFIKAT);
        }
        return
            view('template.header', $data) .
            view('template_guest/profile/mysertificate', $data) .
            view('template.footer', $data);
    }
}
