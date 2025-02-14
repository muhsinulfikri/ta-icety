<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Laporan;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

class CourseController extends Controller
{
    private $id_detailCourse = 0;
    public function __construct()
    {
        //
    }
    public function index()
    {
        $data['title'] = "Kursus";

        if (session('user')[0]->get('ID_ROLE') == 1) {
            $data["activity"] = DB::select("
            SELECT
                c.*
            FROM
                activity c
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = c.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 1
            ");
        } else {
            $data['course'] = DB::select("
                SELECT
                    c.*
                FROM
                    course c
                LEFT JOIN activity a ON
                    a.ID_ACTIVITY = c.ID_ACTIVITY
                WHERE
                    a.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
                    AND a.TYPE_ACTIVITY = 1
            ");

            $data["activity"] = DB::select("
            SELECT
                c.*
            FROM
                activity c
            WHERE
                c.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
            ");
        }

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function add_course()
    {
        $data['title'] = "Kursus Baru";

        $data["kategori"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        $data['requirement'] = DB::Select("
            SELECT
                a.ID_ACTIVITY,
                a.TITLE_ACTIVITY
            FROM
                activity a
            WHERE
                a.TYPE_ACTIVITY = 1
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.add_course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try{
            $activity = [
                'ID_ACTIVITY'           => $this->GenerateUniqID('ACT', $req->input('title_activity')),
                'TITLE_ACTIVITY'        => $req->input('title_activity'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'PRICE_ACTIVITY'        => $req->input('price_course'),
                'IMAGE_ACTIVITY'        => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
                'TYPE_ACTIVITY'         => 1,
                'SERTIF_CODE'           => $req->input('certif_code'),
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'IS_PUBLIC'             => $req->input('is_public'),
                'LOG_TIME'              => date('Y-m-d H:i:s'),
                'SERTIF_IMAGE'          => $req->hasFile('sertif_image') ? FileUpload::S3($req->file('sertif_image'), 'SERTIF_IMAGE', 'Template-Certifiace-' . strtotime(now())) : null
            ];

            if ($req->input('status') == 'on') {
                $activity['STATUS'] = 1;
            } else {
                $activity['STATUS'] = 0;
            }

            $course = [
                'ID_COURSE'             => $this->GenerateUniqID('ACT', $req->input('announcement')),
                'ID_ACTIVITY'           => $activity['ID_ACTIVITY'],
                'ALIAS'                 => $req->input('alias_course'),
                'PENGUMUMAN'            => $req->input('announcement'),
                'DESKRIPSI_COURSE'      => $req->input('desc_course'),
                'DESKRIPSI_COURSE_ITEM' => $req->input('desc_what_to_learn'),
                'KATEGORI'              => $req->input('category'),
            ];

            if ($req->input('req')) {
                $course['REQUIREMENT']  = $req->input('req');
            }

            DB::table('activity')->insert($activity);
            DB::table('course')->insert($course);

            $data['ID_COURSE'] = $course['ID_COURSE'];
            $this->item_materi($data, $req);
            DB::commit();
            return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
        }catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Log::error($e->getMessage());
            return redirect()->back()->with('err_msg', 'Terjadi kesalahan, mohon coba lagi nanti.' . $e->getMessage());
        }
    }

    public function deskripsi_get($id)
    {
        $desc = DB::selectOne("
            SELECT
                c.PENGUMUMAN,
                c.DESKRIPSI_COURSE ,
                c.DESKRIPSI_COURSE_ITEM
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.ID_ACTIVITY = '$id'
        ");

        return response([
            'status_code'       => 200,
            'status_message'    => 'Data diterima',
            $desc
        ], 200);
    }

    public function add_materi($i)
    {
        $id_detailCourse = $i + 1;
        $data['no'] = $id_detailCourse;

        return
            view('template_main.admin_side.course.item_materi', $data);
    }

    public function add_quiz($j, $id_quiz)
    {
        $id_detailCourse = $j + 1;
        $data['no'] = $id_detailCourse;
        $data['id_quiz'] = $id_quiz;

        return
            view('template_main.admin_side.course.item_quiz', $data);
    }

    public function add_question($id, $index)
    {
        $id_detailQuiz_Question = $id;
        $data['no'] = $id_detailQuiz_Question;
        $data['index'] = $index;

        return
            view('template_main.admin_side.course.item_question', $data);
    }

    public function update_course(Request $req)
    {
        $data['title'] = "Edit Kursus";

        $data['kategori'] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");

        $data['requirement'] = DB::Select("
            SELECT
                a.ID_ACTIVITY,
                a.TITLE_ACTIVITY
            FROM
                activity a
            WHERE
                a.TYPE_ACTIVITY = 1
        ");

        $data_course = DB::Select("
            SELECT
                a.ID_ACTIVITY ,
                a.IMAGE_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                a.PRICE_ACTIVITY ,
                a.DATE_START ,
                a.DATE_END ,
                a.STATUS ,
                a.SERTIF_IMAGE ,
                c.ID_COURSE ,
                c.ALIAS,
                c.REQUIREMENT ,
                c.PENGUMUMAN ,
                c.DESKRIPSI_COURSE ,
                c.DESKRIPSI_COURSE_ITEM ,
                a.SERTIF_CODE ,
                k.ID_KATEGORI
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN kategori k ON
                k.ID_KATEGORI = c.KATEGORI
            WHERE
                a.ID_ACTIVITY = '" . $req->input('id_activity') . "'
        ")[0];

        $data['items'] = DB::Selectone("
            SELECT
                COUNT(ic.ID_COURSE) AS tot_item ,
                max(ic.ID_ITEM) AS last_id
            FROM
                item_course ic
            LEFT JOIN course c ON
                c.ID_COURSE = ic.ID_COURSE
            WHERE
                c.ID_ACTIVITY = '" . $data_course->ID_ACTIVITY . "'
        ");

        $jsonData = json_encode($data_course);
        $data['item'] = json_encode($data['items']->tot_item);
        $data['last_id'] = json_encode($data['items']->last_id);

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.update_course', compact('data', 'jsonData')) .
            view('template_main.admin_side.etc.footer');
    }

    public function get_course_item($id_course)
    {
        $data['data_materi'] = DB::select("
            SELECT
                *
            FROM
                item_course
            WHERE
                ID_COURSE = '" . $id_course . "'
            ORDER BY
                ORDER_LIST ASC
        ");

        $data['items'] = [];
        $data['quiz'] = [];
        $allView = "";

        foreach ($data['data_materi'] as $key => $item_data) {
            $data['no'] = $key + 1;
            if ($item_data->TYPE == 1) {
                $data['item'] = [
                    'ID_ITEM'   => $item_data->ID_ITEM,
                    'FILE'      => $item_data->FILE,
                    'TITLE'     => $item_data->TITLE,
                    'LINK_YT'   => $item_data->LINK_YT,
                    'DESKRIPSI' => $item_data->DESKRIPSI,
                    'ORDER_LIST' => $item_data->ORDER_LIST,
                    'LINK_MATERI' => $item_data->LINK_MATERI
                ];
                $allView .= view('template_main.admin_side.course.update_materi', $data)->render();
            } else {
                $data['id_quiz'] = $item_data->ID_ITEM;
                $dataquiz = DB::select("
                    SELECT
                        dq.*,
                        ic.MIN_NILAI
                    FROM
                        detail_quiz dq
                    LEFT JOIN item_course ic ON
                        ic.ID_ITEM = dq.ID_QUIZ
                    WHERE
                        ID_QUIZ = '" . $item_data->ID_ITEM . "'
                ");
                $data['quiz'] = [];
                $data['no_index'] = 0;

                foreach ($dataquiz as $quiz) {
                    list($quiz->PIL_A, $quiz->PIL_B, $quiz->PIL_C, $quiz->PIL_D) = explode(";", $quiz->PIL_JWB);
                    $data['quiz'][$quiz->ID_QUIZ][] = [
                        'ID_DETAIL'  => $quiz->ID_DETAIL,
                        'ID_QUIZ'    => $quiz->ID_QUIZ,
                        'ID_COURSE'  => $quiz->ID_COURSE,
                        'SOAL'       => $quiz->SOAL,
                        'PIL_A'      => $quiz->PIL_A,
                        'PIL_B'      => $quiz->PIL_B,
                        'PIL_C'      => $quiz->PIL_C,
                        'PIL_D'      => $quiz->PIL_D,
                        'KUNCI'      => $quiz->KUNCI,
                        'MIN_NILAI'   => $quiz->MIN_NILAI,
                        'ORDER_LIST' => $quiz->ORDER_LIST,
                        'NO'         => $data['no_index']
                    ];

                    foreach ($data['quiz'][$quiz->ID_QUIZ] as $ID_ITEM) {
                        $data['ID_ITEM'] = $ID_ITEM['ID_QUIZ'];
                        $data['MIN_NILAI'] = $quiz->MIN_NILAI;
                    }
                    $data['no_index']++;
                }
                $allView .= view('template_main.admin_side.course.update_quiz', $data)->render();
            }
        }
        return $allView;
    }

    public function send_question(Request $request)
    {
        $quizData = $request->input('quizData');
        $no_index = 1;
        $no = $request->input('no');
        $html = '';

        foreach ($quizData as $question) {
            $html .= view('template_main.admin_side.course.update_question', ['item' => $question, 'no' => $no, 'index' => $no_index])->render();
            $no_index++;
        }

        return response()->json([
            'success' => true,
            'message' => 'Data received successfully!',
            'html' => $html
        ]);
    }

    public function update(Request $req)
    {
        try {
            DB::beginTransaction();
            $activity = [
                'TITLE_ACTIVITY'        => $req->input('title_activity'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'PRICE_ACTIVITY'        => $req->input('price'),
                'SERTIF_CODE'           => $req->input('certif_code'),
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'IS_PUBLIC'             => $req->input('is_public'),
                'LOG_TIME'              => date('Y-m-d H:i:s')
            ];

            if (!empty($req->file('image_activity'))) {
                $activity['IMAGE_ACTIVITY'] = FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
            }

            if (!empty($req->file('sertif_image'))) {
                $activity['SERTIF_IMAGE'] = FileUpload::S3($req->file('sertif_image'), 'SERTIF_IMAGE', 'Sertificate-Template-' . strtotime(now()));
            }

            if ($req->input('status') == 'on') {
                $activity['STATUS'] = 1;
            } else {
                $activity['STATUS'] = 0;
            }

            $course = [
                'ID_ACTIVITY'           => $req->input('ID_ACTIVITY'),
                'ALIAS'                 => $req->input('alias_course'),
                'PENGUMUMAN'            => $req->input('announcement'),
                'DESKRIPSI_COURSE'      => $req->input('desc'),
                'DESKRIPSI_COURSE_ITEM' => $req->input('desc_item'),
                'KATEGORI'              => $req->input('category')
            ];

            if ($req->input('req')) {
                $course['REQUIREMENT']  = $req->input('req');
            }

            DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($activity);
            DB::table('course')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($course);

            DB::table('item_course')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();
            DB::table('detail_quiz')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();

            $data['ID_COURSE'] = $req->input('ID_COURSE');
            $this->update_item_materi($data, $req);
            DB::commit();
            return redirect('courses')->with(['succ_msg' => 'Berhasi Memperbarui Kursus', 'location' => 'courses']);
        } catch (ValidationException $e) {
            DB::rollBack();
            log::error($e->getMessage(), $e->errors(), $e->getLine());
            return response()->json([
                'status' => 'failure',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function delete(Request $req)
    {
        $find_id_course = DB::selectOne("
            SELECT
                *
            FROM
                course
            WHERE
                ID_ACTIVITY = '" . $req->id_activity . "'
        ");

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::table('course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('item_course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        DB::table('mapping_course')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::table('detail_quiz')->where('ID_COURSE', $find_id_course->ID_COURSE)->whereNotNull('ID_COURSE')->delete();
        DB::table('tb_invited')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect('courses')->with(['succ_msg' => 'Successfully Delete Course', 'location' => 'courses']);
    }

    public function item_materi($data, $req)
    {
        set_time_limit(120);
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $file               = $req->file('materi_file');
        $linkMateri         = $req->input('materi_link');
        $linkYT             = $req->input('materi_link_yt');
        $idQuiz             = [];
        $nomor = 0;

        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                $nomor++;
                if ($categoryList[$i] == 1) {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'FILE'          => !empty($file[$i]) ? FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . strtotime(now())) : null,
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i],
                        'LINK_MATERI'   => !empty($linkMateri[$i]) ? $linkMateri[$i] : null
                    ];
                    DB::table('item_course')->insert($data_item);
                } else {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i],
                        'LINK_MATERI'   => null,
                        'MIN_NILAI'     => $req->input('min_nilai_'.$nomor),
                    ];
                    $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
                }
            }
        }
        if (!empty($req->input('question'))) {
            $data['data_item'] = $data_item;
            $this->item_quiz($data, $req, $idQuiz);
        }
    }

    public function item_quiz($data, $req, $lastIdQuiz)
    {
        $jawaban_a              = $req->input('jawaban_a');
        $jawaban_b              = $req->input('jawaban_b');
        $jawaban_c              = $req->input('jawaban_c');
        $jawaban_d              = $req->input('jawaban_d');
        $order_list_quiz        = $req->input('order_list_question');
        $question               = $req->input('question');
        $kunci_soal             = $req->input('kunci_soal');

        $tmpNo = 0;
        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNo];
            for ($j = 1; $j <= count($questions); $j++) {
                $quiz = [
                    'ID_QUIZ'       => $id_quiz,
                    'ID_COURSE'     => $data['ID_COURSE'],
                    'SOAL'          => $questions[$j],
                    'PIL_JWB'       => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
                    'KUNCI'         => $kunci_soal[$i][$j],
                    'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                ];
                DB::table('detail_quiz')->insert($quiz);
            }
            $tmpNo++;
        }
    }

    public function invite(Request $req)
    {
        $data['title']  = "Undang User";

        $data['users']   = DB::select("
            SELECT
                u.*,
                (SELECT
                    COUNT(*)
                FROM
                    tb_invited i
                WHERE
                    i.ID_USER = u.ID_USER
                AND
                    i.ID_ACTIVITY = '" . $req->input('id_activity') . "') AS is_invited
            FROM
                user u
            WHERE
                u.IS_DELETE = 0
            AND
                ID_ROLE <> 1
        ");

        $data['activity'] = DB::Select("
            SELECT
                a.*
            FROM
                activity a
            WHERE
                a.ID_ACTIVITY = '" . $req->input('id_activity') . "'
        ")[0];

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.invite_user', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function invite_individu(Request $req)
    {
        $id_user = $req->input('id_user');
        $id_activity = $req->input('id_activity');

        $cek_data = DB::SelectOne("
            SELECT
                *
            FROM
                tb_invited
            WHERE
                ID_USER = '" . $id_user . "'
            AND
                ID_ACTIVITY = '" . $id_activity . "'
        ");

        if (!empty($cek_data)) {
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'User Already Invited', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        } else {
            $invited = [
                'ID_USER'       => $id_user,
                'ID_ACTIVITY'   => $id_activity
            ];
            DB::table('tb_invited')->insert($invited);
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Successfully Invite User', 'courses/invite?id_activity=' . $id_activity]);
        }
    }

    public function invite_batch(Request $req)
    {
        $id_users = $req->input('id_user');
        $id_activity = $req->input('id_act');

        // Memastikan $id_logins adalah array
        if (!is_array($id_users)) {
            // Jika $id_logins bukan array, kita coba untuk mengonversinya
            if (is_string($id_users)) {
                // Jika $id_logins adalah string, kita pecah string tersebut menjadi array
                $id_users = explode(',', $id_users);
            } else {
                $id_users = [];
            }
        }

        if (empty($id_users)) {
            return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Choose at least one user', 'location' => 'courses/invite?id_activity=' . $id_activity]);
        }

        foreach ($id_users as $id_user) {
            $cek_data = DB::SelectOne("
                SELECT
                    *
                FROM
                    tb_invited
                WHERE
                    ID_USER = '" . $id_user . "'
                AND
                    ID_ACTIVITY = '" . $id_activity . "'
            ");

            if (!empty($cek_data)) {
                return redirect('courses/invite?id_activity=' . $id_activity)->with(['err_msg' => 'Choose at least one user', 'location' => 'courses/invite?id_activity=' . $id_activity]);
            } else {
                $invited = [
                    'ID_USER'       => $id_user,
                    'ID_ACTIVITY'   => $id_activity
                ];
                DB::table('tb_invited')->insert($invited);
            }
        }
        return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Successfully Invite User', 'courses/invite?id_activity=' . $id_activity]);
    }

    public function GenerateUniqID($prefix, $var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return $prefix . "_" . $uniqid . substr(md5(time()), 0, 3);
    }

    public function index_lihat_peserta(Request $req)
    {
        $data['title'] = "Peserta Kursus";

        $data['list_peserta'] = DB::select("
            SELECT
                u.*
            FROM
                user u
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER
            WHERE
                ID_PRODUCT = '" . $req->input('ID_ACTIVITY') . "'
        ");

        $data['kursus'] = DB::selectOne("
            SELECT
                a.* ,
                c.*
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 1
                AND a.ID_ACTIVITY = '" . $req->input('ID_ACTIVITY') . "'
        ");
        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.lihat_peserta_course', $data);
    }

    public function laporan_course(Request $req)
    {
        $event = DB::select("
            SELECT
                u.EMAIL,
                u.ID_USER ,
                u.NAME,
                u.TELP,
                u.JK ,
                u.ALAMAT,
                o.LOG_TIME,
                a.TITLE_ACTIVITY,
                (
                    CEIL(
                        (
                            SELECT
                                MAX(o.MAPPING_COUNT)
                            FROM
                                `order` o
                            WHERE
                                o.ID_USER  = u.ID_USER
                                AND o.ID_PRODUCT = a.ID_ACTIVITY
                        ) /
                        (
                            SELECT
                                COUNT(*)
                            FROM
                                mapping_course
                            WHERE
                                mapping_course.ID_USER = u.ID_USER
                                AND mapping_course.ID_ACTIVITY = a.ID_ACTIVITY
                        ) * 100
                    )
                ) AS PROGRESS,
                (
                    CEIL
                    (
                    (
                        SELECT
                            SUM(nq.NILAI)
                        FROM
                            nilai_quiz nq
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT
                    ) / (
                        SELECT
                            COUNT(nq2.NILAI)
                        FROM
                            nilai_quiz nq2
                        LEFT JOIN detail_quiz dq ON
                            dq.ID_QUIZ = nq2.ID_QUIZ
                        LEFT JOIN course c ON
                            c.ID_COURSE = dq.ID_COURSE
                        WHERE
                            nq2.ID_USER = u.ID_USER
                            AND c.ID_ACTIVITY = o.ID_PRODUCT
                    )
                    )
                ) AS Rata_Nilai
            FROM
                user u
            LEFT JOIN user_data ud ON
                ud.ID_USER = u.ID_USER
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER
            LEFT JOIN activity a  ON
                o.ID_PRODUCT  = a.ID_ACTIVITY
            WHERE
                o.ID_PRODUCT  = '" . $req->input('ID_ACTIVITY') . "'
        ");

        app(Laporan::class)->laporan_course($event);
    }

    public function update_item_quiz($data, $req, $lastIdQuiz)
    {
        if (!empty($req->input('ID_QUIZ'))) {
            $id_quiz_in = implode(',', $req->input('ID_QUIZ'));

            $id_quiz_old = DB::select("
                SELECT
                    ID_QUIZ
                FROM
                    nilai_quiz
                WHERE
                    ID_QUIZ IN (" . $id_quiz_in . ")
            ");
        }

        $jawaban_a          = $req->input('jawaban_a');
        $jawaban_b          = $req->input('jawaban_b');
        $jawaban_c          = $req->input('jawaban_c');
        $jawaban_d          = $req->input('jawaban_d');
        $order_list_quiz    = $req->input('order_list_question');
        $question           = $req->input('question');
        $kunci_soal         = $req->input('kunci_soal');

        $tmpNo = 0;
        $tmpNoQuiz = 0;
        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNoQuiz];
            $maxIndex = max(array_keys($questions));
            for ($j = 1; $j <= $maxIndex; $j++) {
                if (array_key_exists($j, $questions)) {
                    $quiz = [
                        'ID_QUIZ'       => $id_quiz,
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'SOAL'          => $questions[$j],
                        'PIL_JWB'       => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
                        'KUNCI'         => $kunci_soal[$i][$j],
                        'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                    ];
                    DB::table('detail_quiz')->insert($quiz);
                    $tmpNo++;
                }
            }
            if (!empty($id_quiz_old)) {
                DB::table('nilai_quiz')->WHERE(['ID_QUIZ' => $id_quiz_old[$tmpNoQuiz]->ID_QUIZ])->update(['ID_QUIZ' => $id_quiz]);
            }
            $tmpNoQuiz++;
        }
    }
    public function update_item_materi($data, $req)
    {
        $orderList          = $req->input('order_list');
        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $linkYT             = $req->input('materi_link_yt');
        $file               = $req->file('materi_file');
        $materiFile         = $req->input('default_file');
        $linkMateri         = $req->input('materi_link');
        $nomor = 0;

        $idQuiz = [];
        if (!empty($orderList)) {
            for ($i = 0; $i < count($orderList); $i++) {
                $nomor++;
                if ($categoryList[$i] == 1) {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => $materiTitleList[$i],
                        'LINK_YT'       => $linkYT[$i],
                        'DESKRIPSI'     => $descMateriList[$i],
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i],
                        'LINK_MATERI'   => !empty($linkMateri[$i]) ? $linkMateri[$i] : null
                    ];
                    if(empty($linkMateri[$i])){
                        $data_item['FILE'] = !empty($file[$i]) ? FileUpload::S3($file[$i], 'MATERI_FILE', 'Materi-' . strtotime(now())) :  $materiFile[$i];
                    }

                    DB::table('item_course')->insert($data_item);
                } else {
                    $data_item = [
                        'ID_COURSE'     => $data['ID_COURSE'],
                        'TITLE'         => null,
                        'FILE'          => null,
                        'LINK_YT'       => null,
                        'DESKRIPSI'     => null,
                        'ORDER_LIST'    => $orderList[$i],
                        'TYPE'          => $categoryList[$i],
                        'LINK_MATERI'   => null,
                        'MIN_NILAI'     => $req->input('min_nilai_'.$nomor),
                    ];

                    $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
                }
            }
        }
        if (!empty($req->input('question'))) {
            $data['data_item'] = $data_item;
            $this->update_item_quiz($data, $req, $idQuiz);
        }
    }
}
