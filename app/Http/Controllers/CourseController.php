<?php

namespace App\Http\Controllers;

use DateTime;
use Throwable;
use App\Models\Course;
use App\Models\Laporan;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Exception;

use function PHPUnit\Framework\isEmpty;

use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    protected $courseModel;
    private $id_detailCourse = 0;
    public function __construct()
    {
        $this->courseModel = new Course();
    }
    public function index()
    {
        $data['title'] = "Kursus";

        if (session('user')[0]->get('ID_ROLE') == 1) {
            $data["activity"] = DB::select("
            SELECT
                c.*,
                cr.FINAL_EXAM
            FROM
                activity c
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = c.ID_ACTIVITY
            LEFT JOIN
                course cr ON cr.ID_ACTIVITY = c.ID_ACTIVITY
            WHERE
                (a.TYPE_ACTIVITY = 1
            OR
                a.TYPE_ACTIVITY = 3)
            AND
                a.IS_DELETED IS NULL
            ");
        } elseif (session('user')[0]->get('ID_ROLE') == 2){
            $data["activity"] = DB::select("
            SELECT
                a.*,
                c.FINAL_EXAM
            FROM
                activity a
            LEFT JOIN
                course c ON a.ID_ACTIVITY = c.ID_ACTIVITY
            WHERE
                (a.TYPE_ACTIVITY = 1
            OR
                a.TYPE_ACTIVITY = 3)
            AND
                a.ID_USER = '". session('user')[0]->get('ID_USER') ."'
            AND
                a.IS_DELETED IS NULL
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
        // dd($data['activity']);
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

        if (session('user')[0]->get('ID_ROLE') == 1){
            $data['final_exam'] = DB::Select("
                SELECT
                    a.ID_ACTIVITY,
                    a.TITLE_ACTIVITY,
                    a.ID_USER
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 3
                    AND a.ID_ACTIVITY NOT IN (
                        SELECT FINAL_EXAM FROM course WHERE FINAL_EXAM IS NOT NULL
                    )
            ");
        } elseif(session('user')[0]->get('ID_ROLE') == 2){
            $data['final_exam'] = DB::Select("
                SELECT
                    a.ID_ACTIVITY,
                    a.TITLE_ACTIVITY,
                    a.ID_USER
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 3
                AND a.ID_ACTIVITY NOT IN (
                    SELECT FINAL_EXAM FROM course WHERE FINAL_EXAM IS NOT NULL
                )
                AND a.IS_DELETED IS NULL
                AND a.ID_USER = '".session('user')[0]->get('ID_USER')."'
            ");
        }

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.course.add_course', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req)
    {
        DB::beginTransaction();
        try {
            $activity = [
                'ID_ACTIVITY'           => $this->GenerateUniqID('ACT', $req->input('title_activity')),
                'TITLE_ACTIVITY'        => $req->input('title_activity'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'PRICE_ACTIVITY'        => $req->input('price_course'),
                'INSTRUCTOR_NAME'       => $req->input('instructor_activity'),
                'DESC_INSTRUCTOR'       => $req->input('desc_instructor'),
                'IMAGE_ACTIVITY'        => FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
                'TYPE_ACTIVITY'         => 1,
                'SUMMARY_CERTIFICATE'   => $req->input('summary_certificate'),
                'MODULE_CERTIFICATE'    => $req->input('modules_certificate'),
                'TITLE_CERTIFICATE'     => $req->input('title_certificate'),
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'DATE_DOWNLOAD_SERTIF'  => $req->input('date_download_sertif'),
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
                'DURATION'              => $req->input('duration_month'),
                'HOURS'                 => $req->input('duration_hour')
            ];

            if($req->input('price_sertif') != 0){
                $course['PRICE_SERTIF']  = $req->input('price_sertif');
                $course['IS_SERTIF_PAID']  = 1;
            }

            if ($req->input('req')) {
                $course['REQUIREMENT']  = $req->input('req');
            }
            if ($req->input('final_exam')) {
                $course['FINAL_EXAM']  = $req->input('final_exam');
            }
            $point = strip_tags(html_entity_decode($req->input('point_career')),
    '<p><br><ul><ol><li><b><i><strong><em>');
            $prepare_career = [
                'ID_ACTIVITY'   => $activity['ID_ACTIVITY'],
                'CAREER'        => $req->input('prospek'),
                'POINT'         => $point,
                'SALARY'        => $req->input('salary'),
                'JOB_OPENING'   => $req->input('job_opening')
            ];
            // dd($activity, $course, $prepare_career);
            DB::table('activity')->insert($activity);
            DB::table('course')->insert($course);
            DB::table('prepare_career')->insert($prepare_career);

            $data['ID_COURSE'] = $course['ID_COURSE'];
            $this->item_materi($data, $req);
            DB::commit();
            return redirect('courses')->with(['succ_msg' => 'Successfully Add New Course', 'location' => 'courses']);
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            Log::error(message: $e->getMessage());
            return redirect()->back()->with('err_msg', 'Terjadi kesalahan, mohon coba lagi nanti.' . $e->getMessage());
        }
    }

    public function copyCourse($id_activity, Request $req)
    {
        DB::beginTransaction();
        try {
            $existingCourse = DB::table('course')->where('ID_ACTIVITY', $id_activity)->first();
            if (!$existingCourse) {
                return redirect()->back()->with('err_msg', 'Course tidak ditemukan untuk activity ini.');
            }

            $existingActivity = DB::table('activity')->where('ID_ACTIVITY', $id_activity)->first();
            if (!$existingActivity) {
                return redirect()->back()->with('err_msg', 'Activity tidak ditemukan.');
            }

            $newActivityID = $this->GenerateUniqID('ACT', $existingActivity->TITLE_ACTIVITY);
            $newCourseID = $this->GenerateUniqID('ACT', $existingCourse->PENGUMUMAN);

            $newActivity = [
                'ID_ACTIVITY'           => $newActivityID,
                'TITLE_ACTIVITY'        => $req->input('title_copy'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'PRICE_ACTIVITY'        => $existingActivity->PRICE_ACTIVITY,
                'IMAGE_ACTIVITY'        => $existingActivity->IMAGE_ACTIVITY,
                'TYPE_ACTIVITY'         => $existingActivity->TYPE_ACTIVITY,
                'SUMMARY_CERTIFICATE'   => $existingActivity->SUMMARY_CERTIFICATE,
                'MODULE_CERTIFICATE'    => $existingActivity->MODULE_CERTIFICATE,
                'DATE_START'            => $existingActivity->DATE_START,
                'DATE_END'              => $existingActivity->DATE_END,
                'IS_PUBLIC'             => $existingActivity->IS_PUBLIC,
                'LOG_TIME'              => date('Y-m-d H:i:s'),
                'SERTIF_IMAGE'          => $existingActivity->SERTIF_IMAGE,
                'STATUS'                => $existingActivity->STATUS
            ];

            $newCourse = [
                'ID_COURSE'             => $newCourseID,
                'ID_ACTIVITY'           => $newActivityID,
                'ALIAS'                 => $req->input('alias_copy'),
                'PENGUMUMAN'            => $existingCourse->PENGUMUMAN,
                'DESKRIPSI_COURSE'      => $existingCourse->DESKRIPSI_COURSE,
                'DESKRIPSI_COURSE_ITEM' => $existingCourse->DESKRIPSI_COURSE_ITEM,
                'KATEGORI'              => $existingCourse->KATEGORI,
                'DURATION'              => $existingCourse->DURATION,
                'HOURS'                 => $existingCourse->HOURS,
                'REQUIREMENT'           => $existingCourse->REQUIREMENT ?? null,
                'FINAL_EXAM'            => $existingCourse->FINAL_EXAM ?? null
            ];

            DB::table('activity')->insert($newActivity);
            DB::table('course')->insert($newCourse);
            $existingItems = DB::table('item_course')->where('ID_COURSE', $existingCourse->ID_COURSE)->get();
            $materi = [
                'order_list'     => $existingItems->pluck('ORDER_LIST')->toArray(),
                'type'           => $existingItems->pluck('TYPE')->toArray(),
                'materi_title'   => $existingItems->pluck('TITLE')->toArray(),
                'desc_materi'    => $existingItems->pluck('DESKRIPSI')->toArray(),
                'materi_file'    => $existingItems->pluck('FILE')->toArray(),
                'materi_link'    => $existingItems->pluck('LINK_MATERI')->toArray(),
                'materi_link_yt' => $existingItems->pluck('LINK_YT')->toArray(),

            ];

            $data = [
                'ID_COURSE' => $newCourseID
            ];
            $this->item_materi_copy($data, $materi, $id_activity);

            DB::commit();
            return redirect('courses')->with(['succ_msg' => 'Successfully Copied Course', 'location' => 'courses']);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->with('err_msg', 'Terjadi kesalahan saat menyalin course. ' . $e->getMessage());
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

        if(session('user')[0]->get('ID_ROLE') == 1){
            $data['final_exam'] = DB::Select("
                SELECT
                    a.ID_ACTIVITY,
                    a.TITLE_ACTIVITY
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 3
            ");
        } elseif(session('user')[0]->get('ID_ROLE') == 2){
            $data['final_exam'] = DB::Select("
                SELECT
                    a.ID_ACTIVITY,
                    a.TITLE_ACTIVITY,
                    a.ID_USER
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 3
                AND a.IS_DELETED IS NULL
                AND
                    a.ID_USER = '".session('user')[0]->get('ID_USER')."'
            ");
        }

        $data_course = DB::Select("
            SELECT
                a.ID_ACTIVITY ,
                a.IMAGE_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                a.PRICE_ACTIVITY ,
                a.DATE_START ,
                a.DATE_END ,
                a.DATE_DOWNLOAD_SERTIF ,
                a.STATUS ,
                a.IS_PUBLIC ,
                a.TITLE_CERTIFICATE,
                a.SERTIF_IMAGE ,
                a.SUMMARY_CERTIFICATE,
                a.MODULE_CERTIFICATE,
                a.INSTRUCTOR_NAME,
                a.DESC_INSTRUCTOR,
                c.ID_COURSE,
                c.DURATION ,
                c.HOURS,
                c.ALIAS,
                c.REQUIREMENT ,
                c.PENGUMUMAN ,
                c.DESKRIPSI_COURSE ,
                c.DESKRIPSI_COURSE_ITEM ,
                c.FINAL_EXAM ,
                k.ID_KATEGORI,
                pc.CAREER,
                pc.POINT,
                pc.SALARY,
                pc.JOB_OPENING
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN prepare_career pc ON
                pc.ID_ACTIVITY = a.ID_ACTIVITY
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
                    'ID_COURSE' => $item_data->ID_COURSE,
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

                $data['ID_ITEM'] = null;
                $data['MIN_NILAI'] = null;

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
                    if (!isset($data['quiz'][$quiz->ID_QUIZ])) {
                        $data['quiz'][$quiz->ID_QUIZ] = [];
                    }

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
                // 'ID_USER'               => session('user')[0]['ID_USER'],
                'TITLE_CERTIFICATE'     => $req->input('title_certificate'),
                'INSTRUCTOR_NAME'       => $req->input('instructor_activity'),
                'DESC_INSTRUCTOR'       => $req->input('desc_instructor'),
                'SUMMARY_CERTIFICATE'   => $req->input('summary_certificate'),
                'MODULE_CERTIFICATE'    => $req->input('modules_certificate'),
                'PRICE_ACTIVITY'        => $req->input('price'),
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'DATE_DOWNLOAD_SERTIF'  => $req->input('date_download_sertif'),
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
                'KATEGORI'              => $req->input('category'),
                'DURATION'              => $req->input('duration_months'),
                'HOURS'                 => $req->input('duration_hours')
            ];
            $point = strip_tags(html_entity_decode($req->input('point_career')),
    '<p><br><ul><ol><li><b><i><strong><em>');
            $prepare_career = [
                'ID_ACTIVITY'   => $req->input('ID_ACTIVITY'),
                'CAREER'        => $req->input('prospek'),
                'POINT'         => $point,
                'SALARY'        => $req->input('salary'),
                'JOB_OPENING'   => $req->input('job_opening')
            ];

            if ($req->input('req')) {
                $course['REQUIREMENT']  = $req->input('req');
            }
            if ($req->input('final_exam')) {
                $course['FINAL_EXAM']  = $req->input('final_exam');
            }

            DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($activity);
            DB::table('course')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($course);
            // DB::table('prepare_career')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($prepare_career);
            $exists = DB::table('prepare_career')
                ->where('ID_ACTIVITY', $req->input('ID_ACTIVITY'))
                ->exists();

            if ($exists) {
                DB::table('prepare_career')
                    ->where('ID_ACTIVITY', $req->input('ID_ACTIVITY'))
                    ->update($prepare_career);
            } else {
                DB::table('prepare_career')
                    ->insert($prepare_career);
            }

            // $this->update_item_materi($req);
            DB::commit();
            return redirect('/courses/edit?id_activity=' . $req->input('ID_ACTIVITY'))->with(['succ_msg' => 'Berhasi Memperbarui Kursus', 'location' => 'courses']);
        } catch (ValidationException $e) {
            DB::rollBack();
            log::error($e->getMessage(), $e->errors(), $e->getLine());
            return response()->json([
                'status' => 'failure',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function approve_course(Request $request){
        try{
            DB::beginTransaction();
            DB::table('activity')
                ->whereIn('ID_ACTIVITY', [
                    $request->input('id_activity'),
                    $request->input('final_exam')
                ])
                ->update(['STATUS' => 1]);
            DB::commit();
            return redirect('courses')->with(['succ_msg' => 'Successfully Approve Course', 'location' => 'courses']);
        }catch(Throwable $e){
            DB::rollBack();
            dd($e);
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
        $find_id_final = DB::select("
            SELECT
                ID_ACTIVITY
            FROM
                tb_final_exam
        ");

        $checkedCourses = $this->courseModel->get_check_activity();

        $id_act = array_map(function ($item) {
            return $item->ID_PRODUCT;
        }, $checkedCourses);

        $id_final = array_map(function ($item) {
            return $item->ID_ACTIVITY;
        }, $find_id_final);

        if (in_array($find_id_course->ID_ACTIVITY, $id_act)) {
            return back()->with('err_msg', 'Course tidak dapat dihapus karena sudah ada transaksi.');
        }

        if (in_array($find_id_course->ID_ACTIVITY, $id_final)) {
            return back()->with('err_msg', 'Course tidak dapat dihapus karena sudah ada transaksi.');
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('activity')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->update(['IS_DELETED' => date('Y-m-d H:i:s')]);
        // DB::table('course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        // DB::table('item_course')->WHERE(['ID_COURSE' => $find_id_course->ID_COURSE])->delete();
        // DB::table('mapping_course')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        // DB::table('detail_quiz')->where('ID_COURSE', $find_id_course->ID_COURSE)->whereNotNull('ID_COURSE')->delete();
        // DB::table('tb_invited')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        // DB::table('tb_redeem_code')->WHERE(['ID_ACTIVITY' => $find_id_course->ID_ACTIVITY])->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');

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
                        'MIN_NILAI'     => $req->input('min_nilai_' . $nomor),
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

    public function item_materi_copy($data, $req, $id)
    {
        set_time_limit(120);
        $existingCourse = DB::table('course')->where('ID_ACTIVITY', $id)->first();

        $orderList          = $req['order_list'];
        $categoryList       = $req['type'];
        $materiTitleList    = $req['materi_title'];
        $descMateriList     = $req['desc_materi'];
        $file               = $req['materi_file'];
        $linkMateri         = $req['materi_link'];
        $linkYT             = $req['materi_link_yt'];
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
                        'MIN_NILAI'     => $req['min_nilai_' . $nomor] ?? null,
                    ];
                    $minNilaiKey = 'min_nilai_' . $nomor;
                    $data_item['MIN_NILAI'] = array_key_exists($minNilaiKey, $req) ? $req[$minNilaiKey] : null;
                    $idQuiz[] = DB::table('item_course')->insertGetId($data_item);
                }
            }
        }
        $existingQuiz = DB::table('detail_quiz')->where('ID_COURSE', $existingCourse->ID_COURSE)->get();
        $quiz = [
            'jawaban_a' => $existingQuiz->pluck('PIL_JWB')->toArray(),
            'jawaban_b' => $existingQuiz->pluck('PIL_JWB')->toArray(),
            'jawaban_c' => $existingQuiz->pluck('PIL_JWB')->toArray(),
            'jawaban_d' => $existingQuiz->pluck('PIL_JWB')->toArray(),
            'order_list_question' => $existingQuiz->pluck('ORDER_LIST')->toArray(),
            'question' => $existingQuiz->pluck('SOAL')->toArray(),
            'kunci_soal' => $existingQuiz->pluck('KUNCI')->toArray(),
        ];
        if (!empty($quiz['question'])) {
            $data['data_item'] = $data_item;
            $this->item_quiz_copy($data, $quiz, $idQuiz);
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
            $reindexedQuestions = array_combine(range(1, count($questions)), array_values($questions));
            $reindexed_kunci_soal[$i] = array_combine(range(1, count($kunci_soal[$i])), array_values($kunci_soal[$i]));
            $id_quiz = $lastIdQuiz[$tmpNo];
            for ($j = 1; $j <= count($reindexedQuestions); $j++) {
                $quiz = [
                    'ID_QUIZ'       => $id_quiz,
                    'ID_COURSE'     => $data['ID_COURSE'],
                    'SOAL'          => $reindexedQuestions[$j],
                    'PIL_JWB'       => implode(';', [
                        $jawaban_a[($j-1)], $jawaban_b[($j-1)], $jawaban_c[($j-1)], $jawaban_d[($j-1)]]),
                    'KUNCI'         => $reindexed_kunci_soal[$i][$j],
                    'ORDER_LIST'    => $order_list_quiz[$tmpNo]
                ];
                DB::table('detail_quiz')->insert($quiz);
            }
            $tmpNo++;
        }
    }

    public function item_quiz_copy($data, $req, $lastIdQuiz)
    {
        if (!isset($req['question']) || !is_array($req['question'])) {
            dd("Error: 'question' tidak ditemukan atau bukan array", $req['question'] ?? null);
        }

        $jawaban_a       = $req['jawaban_a'];
        $jawaban_b       = $req['jawaban_b'];
        $jawaban_c       = $req['jawaban_c'];
        $jawaban_d       = $req['jawaban_d'];
        $order_list_quiz = $req['order_list_question'];
        $kunci_soal      = $req['kunci_soal'];
        $question        = $req['question'];

        $tmpNo = 0;

        foreach ($question as $i => $questions) {
            $id_quiz = $lastIdQuiz[$tmpNo] ?? $lastIdQuiz[0];
            if (!$id_quiz) {
                dd("Error: lastIdQuiz tidak memiliki indeks yang sesuai", $lastIdQuiz);
            }

            if (!isset($jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo])) {
                dd("Error: Salah satu jawaban tidak ditemukan untuk indeks $tmpNo", compact('jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d'));
            }

            if (!isset($kunci_soal[$i])) {
                dd("Error: kunci soal tidak ditemukan untuk indeks $i", $kunci_soal);
            }

            if (!isset($order_list_quiz[$tmpNo])) {
                dd("Error: order list quiz tidak ditemukan untuk indeks $tmpNo", $order_list_quiz);
            }

            $quiz = [
                'ID_QUIZ'   => $id_quiz,
                'ID_COURSE' => $data['ID_COURSE'],
                'SOAL'      => $questions,
                'PIL_JWB'   => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
                'KUNCI'     => $kunci_soal[$i],
                'ORDER_LIST' => $order_list_quiz[$tmpNo]
            ];
            try {
                DB::table('detail_quiz')->insert($quiz);
            } catch (\Exception $e) {
                dd($e->getMessage());
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
        try {
            DB::beginTransaction();
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
                $data['course'] = DB::SelectOne("
                    SELECT
                        a.* ,
                        c.*
                    FROM
                        activity a
                    LEFT JOIN course c ON
                        c.ID_ACTIVITY = a.ID_ACTIVITY
                    WHERE
                        a.TYPE_ACTIVITY = 1
                        AND a.ID_ACTIVITY = '" . $id_activity . "'
                ");
                $duration = $data['course']->DURATION ?? 2;
                $order = [
                    'ID_ORDER'      => $this->GenerateUniqID_Order($data['course']->TITLE_ACTIVITY),
                    'ID_USER'       => $id_user,
                    'ID_PRODUCT'    => $id_activity,
                    'ID_PAY'        => $this->GenerateUniqIDPay($data['course']->TITLE_ACTIVITY),
                    'PRICE_ORDER'   => 0,
                    'MAPPING_COUNT' => 0,
                    'DATE_COMPLETED' => null,
                    'EXPIRED_DATE'  => (new DateTime())->modify('+' . $duration . ' months')->format('Y-m-d H:i:s'),
                    'LOG_TIME'      => date('Y-m-d H:i:s')
                ];
                DB::table('order')->insert($order);
                $data_payment = [
                    'ID_PAY'        => $order['ID_PAY'],
                    'KODE_USER'     => $id_user,
                    'DATE_PAY'      => date('Y-m-d H:i:s'),
                    'DATE_CREATED'  => date('Y-m-d H:i:s'),
                ];
                DB::table('payment')->insert($data_payment);
                DB::commit();
                return redirect('courses/invite?id_activity=' . $id_activity)->with(['succ_msg' => 'Successfully Invite User', 'courses/invite?id_activity=' . $id_activity]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
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

        $data['course'] = DB::SelectOne("
            SELECT
                a.* ,
                c.*
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 1
                AND a.ID_ACTIVITY = '" . $id_activity . "'
        ");

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

                $order = [
                    'ID_ORDER'      => $this->GenerateUniqID_Order($data['course']->TITLE_ACTIVITY),
                    'ID_USER'       => $id_user,
                    'ID_PRODUCT'    => $id_activity,
                    'ID_PAY'        => $this->GenerateUniqIDPay($data['course']->TITLE_ACTIVITY),
                    'PRICE_ORDER'   => 0,
                    'MAPPING_COUNT' => 0,
                    'DATE_COMPLETED' => null,
                    'EXPIRED_DATE'  => date('Y-m-d H:i:s', strtotime('+' . $data['course']->DURATION . ' month')),
                    'LOG_TIME'      => date('Y-m-d H:i:s')
                ];
                DB::table('order')->insert($order);

                $data_payment = [
                    'ID_PAY'        => $order['ID_PAY'],
                    'KODE_USER'     => $id_user,
                    'DATE_PAY'      => date('Y-m-d H:i:s'),
                    'DATE_CREATED'  => date('Y-m-d H:i:s'),
                ];
                DB::table('payment')->insert($data_payment);
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

        do {
            $code = $prefix . "_" . $uniqid . substr(md5(microtime()), 0, 3);
            $code_check = DB::selectOne("
				SELECT
					activity.ID_ACTIVITY
				FROM
					activity
                LEFT JOIN course ON
                    course.ID_ACTIVITY = activity.ID_ACTIVITY
				WHERE
					activity.ID_ACTIVITY = ?
                    OR course.ID_COURSE = ?
            ", [$code, $code]);
        } while (!empty($code_check));

        return $code;
    }

    public function GenerateUniqID_Order($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 6);
        $uniqid = strtoupper($begin);
        return "ORD_" . $uniqid . substr(md5(microtime()), 0, 6);
    }

    public function GenerateUniqIDPay($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "INV_PAY_ICETY_" . $uniqid . substr(md5(microtime()), 0, 7);
    }

    public function GenerateCodeExam($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $scrap  = str_ireplace(["a", "e", "i", "o", "u"], "", $string);
        $begin  = strtoupper(substr($scrap, 0, 3));
        do {
            $code = $begin . strtoupper(substr(md5(microtime()), 0, 3));
            $code_check = DB::selectOne(
                "
				SELECT
					CODE_EXAM
				FROM
					tb_final_exam
				WHERE
					CODE_EXAM = ?
				",
                [$code]
            );
        } while (!empty($code_check));

        return $code;
    }

    public function index_lihat_peserta(Request $req)
    {
        $data['title'] = "Peserta Kursus";

        $data['list_peserta'] = $this->get_progress($req->input('ID_ACTIVITY'));

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
        $data = $this->get_progress($req->input('ID_ACTIVITY'));

        app(Laporan::class)->laporan_course($data);
    }

    public function update_item_materi(Request $req)
    {
        $dataIDCourse = $req->input('ID_COURSE');

        $categoryList       = $req->input('type');
        $materiTitleList    = $req->input('materi_title');
        $descMateriList     = $req->input('desc_materi');
        $linkYT             = $req->input('materi_link_yt');
        $linkMateri         = $req->input('materi_link');

        $idItem             = $req->input('ID_ITEM');
        $isDelete           = $req->input('DELETED');


        $data = [
            'ID_COURSE' => $dataIDCourse,
            'TITLE' => $materiTitleList,
            'DESKRIPSI' => $descMateriList,
            'LINK_YT' => $linkYT,
            'LINK_MATERI' => $linkMateri,
        ];

        $materiFile = $req->input('default_file');

        if (!empty($materiFile)) {
            if ($req->hasFile('materi_file')) {
                $uploadedFile = $req->file('materi_file');
                $data['FILE'] = FileUpload::S3($uploadedFile, 'MATERI_FILE', 'Materi-' . strtotime(now()));
            } else {
                $data['FILE'] = $materiFile;
            }
        } else {
            $data['FILE'] = null;
        }
        try {
            DB::table('item_course')
            ->where([
                'ID_ITEM' => $idItem,
                'ID_COURSE' => $dataIDCourse
            ])
            ->update($data);
            return response()->json(['status' => 'success', 'succ_msg' => 'Berhasil Memperbarui Materi']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'err_msg' => $e]);
        }

        // $idQuiz = [];
        // $orderList = 0;
        // if (!empty($idItem)) {
        //     for ($i = 0; $i < count($idItem); $i++) {
        //         $nomor++;
        //         if ($categoryList[$i] == 1) {
        //             if ($isDelete[$i]) {
        //                 DB::table('item_course')->where(['ID_ITEM' => $idItem[$i]])->delete();
        //             } else {
        //                 $orderList++;
        //                 $data_item = [
        //                     'ID_COURSE'     => $dataIDCourse,
        //                     'TITLE'         => $materiTitleList[$i],
        //                     'LINK_YT'       => $linkYT[$i],
        //                     'DESKRIPSI'     => $descMateriList[$i],
        //                     'ORDER_LIST'    => $orderList,
        //                     'TYPE'          => $categoryList[$i],
        //                     'LINK_MATERI'   => !empty($linkMateri[$i]) ? $linkMateri[$i] : null
        //                 ];

        //                 $materiFile = $req->input('default_file');
        //                 if (!empty($materiFile)) {
        //                     $file = (!empty($req->file('materi_file') && !empty($req->file('materi_file')[$i])) ? $req->file('materi_file')[$i] : '');
        //                     $data_item['FILE'] = !empty($file) ? FileUpload::S3($file, 'MATERI_FILE', 'Materi-' . strtotime(now())) :  $materiFile[$i];
        //                 } else {
        //                     $data_item['FILE'] = NULL;
        //                 }

        //                 DB::table('item_course')->updateOrInsert(['ID_ITEM' => $idItem[$i]], $data_item);
        //             }
        //         } else {
        //             if ($isDelete[$i]) {
        //                 DB::table('item_course')->where(['ID_ITEM' => $idItem[$i]])->delete();
        //             } else {
        //                 $orderList++;
        //                 $data_kuis = [
        //                     'ID_COURSE'     => $dataIDCourse,
        //                     'TITLE'         => null,
        //                     'FILE'          => null,
        //                     'LINK_YT'       => null,
        //                     'DESKRIPSI'     => null,
        //                     'ORDER_LIST'    => $orderList,
        //                     'TYPE'          => $categoryList[$i],
        //                     'LINK_MATERI'   => null,
        //                     'MIN_NILAI'     => $req->input('min_nilai_' . $nomor),
        //                 ];

        //                 $existingItem = DB::table('item_course')->where('ID_ITEM', $idItem[$i])->first();
        //                 if ($existingItem) {
        //                     DB::table('item_course')->where('ID_ITEM', $idItem[$i])->update($data_kuis);
        //                     $id = $existingItem->ID_ITEM;
        //                 } else {
        //                     DB::table('item_course')->insert($data_kuis);
        //                     $id = DB::getPdo()->lastInsertId();
        //                 }
        //                 $idQuiz[] = $id;
        //             }
        //         }
        //     }
        // }

        // if (!empty($req->input('question'))) {
        //     $data['data_item'] = $data_kuis;
        //     $data['ID_COURSE'] = $dataIDCourse;
        //     $this->update_item_quiz($data, $req, $idQuiz);
        // }
    }

    public function update_item_quiz(Request $req)
    {
        $data = [
            'ID_DETAIL' => $req->input('ID_DETAIL'),
            'ID_QUIZ'   => $req->input('ID_QUIZ'),
            'ID_COURSE' => $req->input('ID_COURSE'),
            'SOAL' => $req->input('SOAL'),
            'PIL_JWB' => $req->input('PIL_JWB'),
            'KUNCI' => $req->input('KUNCI'),
        ];
        try{
            DB::table('detail_quiz')->where(['ID_DETAIL' => $data['ID_DETAIL'], 'ID_QUIZ' => $data['ID_QUIZ'], 'ID_COURSE' => $data['ID_COURSE']])->update($data);
            return response()->json(['status' => 'success']);
        } catch(Exception $e){
            return response()->json(['status' => 'error', 'err_msg' => $e]);
        }

        // $id_quiz_old = '';
        // if (!empty($req->input('ID_QUIZ'))) {
        //     $id_quiz_in = implode(',', $req->input('ID_QUIZ'));
        //     DB::statement("DELETE FROM detail_quiz WHERE ID_QUIZ IN (" . $id_quiz_in . ")");

        //     $id_quiz_old = DB::select("
        //         SELECT
        //             ID_QUIZ
        //         FROM
        //             nilai_quiz
        //         WHERE
        //             ID_QUIZ IN (" . $id_quiz_in . ")
        //     ");
        // }

        // $jawaban_a          = $req->input('jawaban_a');
        // $jawaban_b          = $req->input('jawaban_b');
        // $jawaban_c          = $req->input('jawaban_c');
        // $jawaban_d          = $req->input('jawaban_d');
        // $order_list_quiz    = $req->input('order_list_question');
        // $question           = $req->input('question');
        // $kunci_soal         = $req->input('kunci_soal');
        // dd($question);
        // $tmpNo = 0;
        // $tmpNoQuiz = 0;
        // foreach ($question as $i => $questions) {
        //     $id_quiz = $lastIdQuiz[$tmpNoQuiz];
        //     $maxIndex = max(array_keys($questions));
        //     for ($j = 1; $j <= $maxIndex; $j++) {
        //         if (array_key_exists($j, $questions)) {
        //             $quiz = [
        //                 'ID_QUIZ'       => $id_quiz,
        //                 'ID_COURSE'     => $data['ID_COURSE'],
        //                 'SOAL'          => $questions[$j],
        //                 'PIL_JWB'       => implode(';', [$jawaban_a[$tmpNo], $jawaban_b[$tmpNo], $jawaban_c[$tmpNo], $jawaban_d[$tmpNo]]),
        //                 'KUNCI'         => $kunci_soal[$i][$j],
        //                 'ORDER_LIST'    => $order_list_quiz[$tmpNo]
        //             ];
        //             DB::table('detail_quiz')->insert($quiz);
        //             $tmpNo++;
        //         }
        //     }
        //     if (!empty($id_quiz_old) || $id_quiz_old != null) {
        //         DB::table('nilai_quiz')->WHERE(['ID_QUIZ' => $id_quiz_old[$tmpNoQuiz]->ID_QUIZ])->update(['ID_QUIZ' => $id_quiz]);
        //     }
        //     $tmpNoQuiz++;
        // }
    }

    public function get_alias(Request $req)
    {
        $alias = $req->query('alias');

        $exists = DB::table('course')->where('ALIAS', $alias)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function get_progress($id_activity)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data = DB::select("
            SELECT
                u.EMAIL,
                u.ID_USER,
                u.NAME,
                u.TELP,
                u.JK ,
                u.ALAMAT ,
                o.LOG_TIME,
                a.TITLE_ACTIVITY,
                (CASE
                    WHEN tnfe.NILAI >= ic.MIN_NILAI THEN 'Lulus'
                    ELSE 'Belum Lulus'
                END) AS STATUS_FINAL_EXAM ,
                COALESCE(
                    tnfe_group.NILAI_SEMUA, 'Belum remidi'
                ) AS NILAI_REMIDI,
                COALESCE(tnfe.NILAI, 'Belum Mengerjakan') AS NILAI_TERTINGGI_FINAL_EXAM ,
                nq.NILAI AS NILAI_RATA ,
                CEIL((o.MAPPING_COUNT / mc.TOTAL) * 100) AS PROGRESS
            FROM
                user u
            LEFT JOIN user_data ud ON
                ud.ID_USER = u.ID_USER
            LEFT JOIN `order` o ON
                o.ID_USER = u.ID_USER
            LEFT JOIN activity a  ON
                o.ID_PRODUCT  = a.ID_ACTIVITY
            LEFT JOIN course c  ON
                c.ID_ACTIVITY  = a.ID_ACTIVITY
            LEFT JOIN course c2 ON
                c2.ID_ACTIVITY = c.FINAL_EXAM
            LEFT JOIN item_course ic ON
                ic.ID_COURSE = c2.ID_COURSE
            LEFT JOIN (
                SELECT
                        MAX(tnfe.NILAI) AS NILAI,
                        tnfe.ID_USER ,
                        tnfe.ID_ACTIVITY
                    FROM
                        tb_nilai_final_exam tnfe
                    GROUP BY
                        tnfe.ID_USER ,
                        tnfe.ID_ACTIVITY
                ) tnfe ON
                tnfe.ID_USER = u.ID_USER
                AND
                tnfe.ID_ACTIVITY = c.FINAL_EXAM
            LEFT JOIN (
                SELECT
                    CEIL(SUM(nq.NILAI) / COUNT(nq.NILAI)) AS NILAI,
                    nq.ID_USER,
                    c.ID_ACTIVITY
                FROM
                    nilai_quiz nq
                LEFT JOIN item_course ic ON
                    ic.ID_ITEM = nq.ID_QUIZ
                LEFT JOIN course c ON
                    c.ID_COURSE = ic.ID_COURSE
                GROUP BY
                    nq.ID_USER, c.ID_ACTIVITY
                ) nq ON
                nq.ID_USER = u.ID_USER
                AND nq.ID_ACTIVITY = c.ID_ACTIVITY
            LEFT JOIN (
                SELECT
                    mc.ID_USER ,
                    mc.ID_ACTIVITY ,
                    COUNT(*) AS TOTAL
                FROM
                    mapping_course mc
                GROUP BY
                    mc.ID_USER ,
                    mc.ID_ACTIVITY
                ) mc ON
                mc.ID_USER = u.ID_USER
                AND mc.ID_ACTIVITY = c.ID_ACTIVITY
            LEFT JOIN (
                SELECT
                    tnfe_group.ID_USER,
                    tnfe_group.ID_ACTIVITY,
                    SUBSTRING_INDEX(
                        GROUP_CONCAT(tnfe_group.NILAI ORDER BY tnfe_group.created_at ASC),
                        ',',
                        - (COUNT(tnfe_group.NILAI) - 1)
                    ) AS NILAI_SEMUA
                FROM
                    tb_nilai_final_exam tnfe_group
                GROUP BY
                    tnfe_group.ID_USER,
                    tnfe_group.ID_ACTIVITY
                ) AS tnfe_group ON
                tnfe_group.ID_ACTIVITY = c.FINAL_EXAM
                AND tnfe_group.ID_USER = u.ID_USER
            WHERE
                o.ID_PRODUCT = '".$id_activity."'
            GROUP BY
                u.ID_USER ,
                o.ID_PRODUCT
        ");
        return $data;
    }
}
