<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class FinalExamController extends Controller
{
    public function index()
    {
        $data['title'] = "Final Exam Baru";

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
            view('template_main.admin_side.final_exam.add_course', $data) .
            view('template_main.admin_side.etc.footer');
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

    public function store(Request $req)
    {
        DB::beginTransaction();
        try{
            $activity = [
                'ID_ACTIVITY'           => $this->GenerateUniqID('ACT', $req->input('title_activity')),
                'TITLE_ACTIVITY'        => $req->input('title_activity'),
                'ID_USER'               => session('user')[0]['ID_USER'],
                'PRICE_ACTIVITY'        => $req->input('price_course'),
                'REMEDIAL'              => $req->input('remedial'),
                'IMAGE_ACTIVITY'        => null,
                'TYPE_ACTIVITY'         => 3,
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

            if ($req->input('setYesNo') == 'on') {
                $activity['INCLUDE_COURSE'] = 1;
            } else {
                $activity['INCLUDE_COURSE'] = 0;
            }

            $course = [
                'ID_COURSE'             => $this->GenerateUniqID('FNL', $req->input('announcement')),
                'ID_ACTIVITY'           => $activity['ID_ACTIVITY'],
                'ALIAS'                 => $req->input('alias_course'),
                'PENGUMUMAN'            => "-",
                'DESKRIPSI_COURSE'      => "-",
                'DESKRIPSI_COURSE_ITEM' => "-",
                'KATEGORI'              => 2
            ];

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
            $data_course = DB::Select("
                SELECT
                    a.ID_ACTIVITY ,
                    a.IMAGE_ACTIVITY ,
                    a.TITLE_ACTIVITY ,
                    a.PRICE_ACTIVITY ,
                    a.REMEDIAL,
                    a.DATE_START ,
                    a.DATE_END ,
                    a.STATUS ,
                    a.IS_PUBLIC ,
                    a.SERTIF_IMAGE ,
                    a.INCLUDE_COURSE,
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
        } elseif(session('user')[0]->get('ID_ROLE') == 2){
            $data_course = DB::Select("
                SELECT
                    a.ID_ACTIVITY ,
                    a.IMAGE_ACTIVITY ,
                    a.TITLE_ACTIVITY ,
                    a.PRICE_ACTIVITY ,
                    a.REMEDIAL,
                    a.DATE_START ,
                    a.DATE_END ,
                    a.IS_PUBLIC ,
                    a.SERTIF_IMAGE ,
                    a.INCLUDE_COURSE,
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
        }

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
            view('template_main.admin_side.final_exam.update_course', compact('data', 'jsonData')) .
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
                'DATE_START'            => $req->input('date_start'),
                'DATE_END'              => $req->input('date_end'),
                'LOG_TIME'              => date('Y-m-d H:i:s'),
                'REMEDIAL'              => $req->input('remedial')
            ];

            if (!empty($req->file('image_activity'))) {
                $activity['IMAGE_ACTIVITY'] = FileUpload::S3($req->file('image_activity'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
            }

            if (!empty($req->file('sertif_image'))) {
                $activity['SERTIF_IMAGE'] = FileUpload::S3($req->file('sertif_image'), 'SERTIF_IMAGE', 'Sertificate-Template-' . strtotime(now()));
            }

            if ($req->input('setYesNo') == 'on') {
                $activity['INCLUDE_COURSE'] = 1;
            } else {
                $activity['INCLUDE_COURSE'] = 0;
            }

            if ($req->input('status') == 'on') {
                $activity['STATUS'] = 1;
            } else {
                $activity['STATUS'] = 0;
            }

            $course = [
                'ID_ACTIVITY'           => $req->input('ID_ACTIVITY'),
                'ALIAS'                 => $req->input('alias_course')
            ];

            if ($req->input('req')) {
                $course['REQUIREMENT']  = $req->input('req');
            }

            DB::table('activity')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($activity);
            DB::table('course')->WHERE(['ID_ACTIVITY' => $req->input('ID_ACTIVITY')])->update($course);

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

    public function update_item_materi($data, $req)
    {
        DB::table('item_course')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();

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

    public function update_item_quiz($data, $req, $lastIdQuiz)
    {
        DB::table('detail_quiz')->WHERE(['ID_COURSE' => $req->input('ID_COURSE')])->delete();

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

    public function index_lihat_peserta(Request $req)
    {
        $data['title'] = "Peserta Final Exam";

        $data['list_peserta'] = $this->get_progress($req->input('ID_ACTIVITY'));

        $data['exam'] = DB::selectOne("
            SELECT
                a.* ,
                c.*
            FROM
                activity a
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                a.TYPE_ACTIVITY = 3
                AND a.ID_ACTIVITY = '" . $req->input('ID_ACTIVITY') . "'
        ");
        // dd($data['list_peserta']);
        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.final_exam.lihat_peserta_final', $data);
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

    public function get_progress($id_activity)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data = DB::select("
            SELECT
                u.EMAIL,
                u.NAME,
                u.TELP,
                u.ALAMAT,
                (
                    SELECT
                        CASE
                            WHEN MAX(tnfe.NILAI) >= ic.MIN_NILAI THEN 'Lulus'
                            ELSE 'Belum Lulus'
                        END
                    FROM
                        tb_nilai_final_exam tnfe
                    LEFT JOIN activity a2 ON tnfe.ID_ACTIVITY = a2.ID_ACTIVITY
                    LEFT JOIN course c2 ON c2.ID_ACTIVITY = a2.ID_ACTIVITY
                    LEFT JOIN item_course ic ON ic.ID_COURSE = c2.ID_COURSE
                    WHERE
                        tnfe.ID_ACTIVITY = tfe.ID_ACTIVITY
                        AND tnfe.ID_USER = u.ID_USER
                ) AS STATUS_FINAL_EXAM,
                (
                    SELECT
                        MAX(tnfe.NILAI)
                    FROM
                        tb_nilai_final_exam tnfe
                    WHERE
                        tnfe.ID_ACTIVITY = tfe.ID_ACTIVITY
                        AND tnfe.ID_USER = u.ID_USER
                ) AS NILAI_TERTINGGI_FINAL_EXAM
            FROM
                tb_final_exam tfe
            LEFT JOIN user u ON u.ID_USER = tfe.ID_USER
            LEFT JOIN user_data ud ON ud.ID_USER = u.ID_USER
            LEFT JOIN activity a ON tfe.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN course c ON c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                tfe.ID_ACTIVITY = '". $id_activity ."'
            GROUP BY
                u.EMAIL, u.NAME, u.TELP, u.ALAMAT, tfe.ID_ACTIVITY, u.ID_USER
        ");

        return $data;
    }
}
