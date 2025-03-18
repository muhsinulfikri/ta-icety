<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Course;
use App\Models\FinalExam;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Ebook;
use Carbon\Traits\ToStringFormat;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CourseGuest extends Controller
{
	public $session_data;
	protected $eventModel;
	protected $courseModel;
	protected $checkoutModel;
	protected $categoryModel;
	protected $certificateModel;
    protected $activityModel;
    protected $finalExamModel;

	public function __construct()
	{

		$this->eventModel = new Event();
		$this->courseModel = new Course();
		$this->checkoutModel = new Checkout();
		$this->categoryModel = new Category();
		$this->certificateModel = new Certificate();
        $this->activityModel = new Activity();
        $this->finalExamModel = new FinalExam();
	}

	public function index()
	{
		$data['title'] = 'Course';
		// Access models using $this-> prefix
		$data['kategori'] = $this->categoryModel->get_all_category();
		$data_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);
		$data['is_invited'] = DB::select("
		SELECT
			id_invited
		FROM
			tb_invited
		WHERE
			ID_USER = '" . $data_user . "'
		");
		return
			view('template.header', $data) .
			view('template_guest.course.course', $data) .
			view('template.footer', $data);
	}

	public function detailCourse()
	{
		if (session('user') == null) {
			return redirect('login');
		}
		$data['title'] = 'Course';

		$data['id_activity'] = $_GET['id_activity'];
		$data['course'] = $this->courseModel->get_course($data['id_activity']);
        $summary_sertif = $this->activityModel->get_summary_sert_activity($data['id_activity']);
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE . "'" .
			" AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";

		$this->courseModel->updateMappingIndex($data['course']->ID_COURSE, $data['id_activity']);

		$data['item_course'] = $this->courseModel->get_item_course($condition);

        $data['date_sertif_course'] = DB::select("
            SELECT
                o.DATE_COMPLETED
            FROM
                `order` o
            LEFT JOIN
                activity a ON a.ID_ACTIVITY = o.ID_PRODUCT
            LEFT JOIN
                user u ON u.ID_USER = o.ID_USER
            WHERE
                a.ID_ACTIVITY = '".$data['id_activity']."'
            AND
                u.ID_USER = '".session('user')[0]->get('ID_USER')."'
        ");

        $completed_course = $this->courseModel->get_completed_course(session('user')[0]->get('ID_USER'), $data['id_activity']);
		$data['last_item'] = DB::select('
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND ID_ACTIVITY = "' . $data['id_activity'] . '"
				AND STATUS = 1
			ORDER BY ID_ITEM DESC
		');

		$condition_all_mapping = "
			ID_USER = '" . session('user')[0]->get('ID_USER') .
			"'AND ID_ACTIVITY = '" . $data['id_activity'] . "'
		";
		
		$data['data_all_mapping'] = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				$condition_all_mapping
		");
		$data_all_mapping = $this->courseModel->get_counttask($data['id_activity']);
		$data['tot_proggress'] = (!empty($data['last_item'])) ? (((int) $data_all_mapping[0]->MAPPING_COUNT) / count($data['data_all_mapping'])) * 100 : 0;

		$cek_nilai = DB::selectOne("
			SELECT
				*
			FROM
				nilai_quiz
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND ID_QUIZ = " . $data['last_item'][0]->ID_ITEM . "
		");

		$cek_quiz = DB::select("
			SELECT
				*
			FROM
				item_course
			WHERE
				TYPE = 2
				AND ID_COURSE = '" . $data['course']->ID_COURSE . "'
		");

		$cek_item_course = DB::selectOne("
			SELECT
				*
			FROM
				item_course
			WHERE
				ID_ITEM = " . $data['last_item'][0]->ID_ITEM . "
		");

		$check_history_final_exam = DB::selectOne("
			SELECT
				*
			FROM
				tb_final_exam
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND ID_ACTIVITY = '" . $data['course']->FINAL_EXAM . "'"
		);

		if (count($data['last_item']) == count($data['data_all_mapping']) && (!empty($cek_nilai->NILAI) ? $cek_nilai->NILAI >= $cek_item_course->MIN_NILAI : false)) {
			$data['tot_proggress'] = 100;
			DB::table('order')
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $data['id_activity'])
				->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping']), 'DATE_COMPLETED' => date('Y-m-d H:i:s')]);

			if ($check_history_final_exam == null && $data['course']->FINAL_EXAM != null) {
				$data_final_exam = [
					"ID_ACTIVITY"	=> $data['course']->FINAL_EXAM,
					"ID_USER"		=> session('user')[0]->get('ID_USER'),
					"CODE_EXAM"		=> $this->GenerateCodeExam($data['course']->FINAL_EXAM . date('Y-m-d H:i:s')),
					"IS_USED"		=> 0,
					"CREATED_AT"	=> date("Y-m-d H:i:s")
				];
				DB::table('tb_final_exam')->insert($data_final_exam);
			}
		}
		if (count($data['last_item']) == count($data['data_all_mapping']) && ($cek_item_course->TYPE == 1)) {
			$data['tot_proggress'] = 100;
			DB::table('order')
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $data['id_activity'])
				->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping']), 'DATE_COMPLETED' => date('Y-m-d H:i:s')]);

			if ($check_history_final_exam == null && $data['course']->FINAL_EXAM != null) {
				$data_final_exam = [
					"ID_ACTIVITY"	=> $data['course']->FINAL_EXAM,
					"ID_USER"		=> session('user')[0]->get('ID_USER'),
					"CODE_EXAM"		=> $this->GenerateCodeExam($data['course']->FINAL_EXAM . date('Y-m-d H:i:s')),
					"IS_USED"		=> 0,
					"CREATED_AT"	=> date("Y-m-d H:i:s")
				];
				DB::table('tb_final_exam')->insert($data_final_exam);
			}
		}

		$sertifCheck = DB::selectOne("
			SELECT
				ID_SERTIFIKAT,
				FILE_SERTIFIKAT
			FROM
				sertifikat_activity
			WHERE
				$condition_all_mapping
		");
		if ($data['tot_proggress'] == 100 && empty($sertifCheck)) {
            $bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
			$countSertifCourse = DB::table('sertifikat_activity')
            ->where('ID_ACTIVITY', $data['id_activity'])
            ->count() + 1;
			$sertif_number_course = $countSertifCourse . '/' . (($data['course']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/' . $data['course']->ALIAS . '/ICETy/' . $bln[(date('m', strtotime($data['course']->DATE_START)) - 1)] . '/' . date('Y');
            $data_sertif_course = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $data['id_activity'],
				"NO_SERTIFIKAT" => $sertif_number_course,
				"JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => null,
                "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
                "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
                "DURATION" => $completed_course[0]->days_difference,
                "DATE_COMPLETED" => date('d F Y', strtotime($data['date_sertif_course'][0]->DATE_COMPLETED)),
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
            $id_sertif = DB::table('sertifikat_activity')->insertGetId($data_sertif_course);
			$sertif_path_course = $this->certificateModel->generate(session('user')[0]->get('NAME'), $data['course']->TITLE_ACTIVITY, $sertif_number_course, $data['course']->SERTIF_IMAGE, $summary_sertif[0]->SUMMARY_CERTIFICATE, $summary_sertif[0]->MODULE_CERTIFICATE, $completed_course[0]->days_difference, $data['date_sertif_course'][0]->DATE_COMPLETED, $id_sertif);
			$data_sertif_course = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $data['id_activity'],
				"NO_SERTIFIKAT" => $sertif_number_course,
				"JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => $sertif_path_course,
                "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
                "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
                "DURATION" => $completed_course[0]->days_difference,
                "DATE_COMPLETED" => date('d F Y', strtotime($data['date_sertif_course'][0]->DATE_COMPLETED)),
				"LOG_TIME" => date('Y-m-d H:i:s')
			);

			DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif)->update($data_sertif_course);
			$data['sertif_course'] = (object) $data_sertif_course;
		} else {
			$data['sertif_course'] = $sertifCheck;
		}

		//get nilai
		$data['nilai'] = DB::selectOne("
			SELECT
				NILAI
			FROM
				nilai_quiz
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
		");

		// KOMENTAR
		$data['komentar'] = DB::select("
			SELECT
				tk.komentar,
				u.NAME,
				u.FOTO_PROFILE,
				tk.LOG_TIME
			FROM
				tb_komentar tk
			LEFT JOIN user u ON
				u.ID_USER = tk.ID_USER
			WHERE
				tk.ID_ACTIVITY = '" . $data['id_activity'] . "'
		");
		$data['checkout'] = $this->checkoutModel->get_all_order(session('user')[0]->get('ID_USER'));

		$orderData = Checkout::where(["ID_PRODUCT" => $data['id_activity'], "ID_USER" => session('user')[0]->get('ID_USER')])
			->orderBy('LOG_TIME', 'DESC')
			->first();

		//Final Exam
		if ($data['course']->FINAL_EXAM != null) {
			$data['final_exam'] = DB::selectOne("
				SELECT
					CODE_EXAM
				FROM
					tb_final_exam
				WHERE
					ID_ACTIVITY = ?
					AND ID_USER = ?
					AND IS_USED = 0
			", [$data['course']->FINAL_EXAM, session('user')[0]->get('ID_USER')]);

			$data['final_min_nilai'] = DB::selectOne("
				SELECT
					COALESCE(ic.MIN_NILAI, '80') AS MIN_NILAI
				FROM
					item_course ic
				LEFT JOIN course c ON
					c.ID_COURSE = ic.ID_COURSE
				WHERE
					c.ID_ACTIVITY =	?
			", [$data['course']->FINAL_EXAM]);

			$data['nilai_final_exam'] = DB::selectOne("
				SELECT
					NILAI,
                    created_at
				FROM
					tb_nilai_final_exam
				WHERE
					ID_USER = ?
					AND ID_ACTIVITY = ?
				ORDER BY
					NILAI DESC
			", [session('user')[0]->get('ID_USER'), $data['course']->FINAL_EXAM]);

			$data['history_nilai_final_exam'] = DB::select("
				SELECT
					NILAI,
					created_at
				FROM
					tb_nilai_final_exam
				WHERE
					ID_USER = ?
					AND ID_ACTIVITY = ?
				ORDER BY
					created_at ASC
			", [session('user')[0]->get('ID_USER'), $data['course']->FINAL_EXAM]);
			$finalExamModel = new FinalExam();
			$data['data_final_exam'] = $finalExamModel->get_final_exam($data['course']->FINAL_EXAM);
			$data['nilai_final_exam'] = $data['nilai_final_exam'] !== null ? $data['nilai_final_exam'] : (object) [
				'NILAI' => 0
			];

			if(($data['nilai_final_exam']->NILAI > $data['final_min_nilai']->MIN_NILAI) || ($data['nilai_final_exam']->NILAI == 100 && empty($sertifCheck))){
                $data['exam'] = $finalExamModel->get_final_exam($data['course']->FINAL_EXAM);
                $bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                $countSertifExam = DB::table('sertifikat_activity')
                    ->where('ID_ACTIVITY', $data['course']->FINAL_EXAM)
                    ->count() + 1;
                $sertif_number_exam = $countSertifExam . '/' . 'FINAL-EXAM' . '/' . $data['course']->ALIAS . '/ICETy/' . $bln[(date('m', strtotime($data['course']->DATE_START)) - 1)] . '/' . date('Y');
                $data_sertif_exam = array(
                    "ID_USER" => session('user')[0]->get('ID_USER'),
                    "ID_ACTIVITY" => $data['course']->FINAL_EXAM,
                    "NO_SERTIFIKAT" => $sertif_number_exam,
                    "JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
                    "FILE_SERTIFIKAT" => null,
                    "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
                    "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
                    "DURATION" => $completed_course[0]->days_difference,
                    "DATE_COMPLETED" => date('d F Y', strtotime($data['nilai_final_exam']->created_at)),
                    "LOG_TIME" => date('Y-m-d H:i:s')
                );
                $id_sertif_exam = DB::table('sertifikat_activity')->insertGetId($data_sertif_exam);
                $sertif_path_exam = $this->certificateModel->generateSertifExam(session('user')[0]->get('NAME'), $data['exam']->TITLE_ACTIVITY, $sertif_number_exam, $data['exam']->SERTIF_IMAGE, $summary_sertif[0]->SUMMARY_CERTIFICATE, $summary_sertif[0]->MODULE_CERTIFICATE, $completed_course[0]->days_difference, $data['nilai_final_exam']->created_at, $id_sertif_exam);
                $data_sertif_exam = array(
                    "ID_USER" => session('user')[0]->get('ID_USER'),
                    "ID_ACTIVITY" => $data['course']->FINAL_EXAM,
                    "NO_SERTIFIKAT" => $sertif_number_exam,
                    "JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
                    "FILE_SERTIFIKAT" => $sertif_path_exam,
                    "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
                    "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
                    "DURATION" => $completed_course[0]->days_difference,
                    "DATE_COMPLETED" => date('d F Y', strtotime($data['nilai_final_exam']->created_at)),
                    "LOG_TIME" => date('Y-m-d H:i:s')
                );
                DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif_exam)->update($data_sertif_exam);
			    $data['sertif_exam'] = (object) $data_sertif_exam;
            }
            else {
                $data['sertif_exam'] = $sertifCheck;
            }
		} else {
			$data['final_exam'] = null;
			$data['final_min_nilai'] = null;
			$data['history_nilai_final_exam'] = null;
			$data['nilai_final_exam'] = null;
			$data['data_final_exam'] = null;

			$data['data_final_exam'] = $data['data_final_exam'] !== null ? $data['data_final_exam'] : (object) [
				'TITLE_ACTIVITY' => 0,
				'PRICE_ACTIVITY' => 0
			];

			$data['nilai_final_exam'] = $data['nilai_final_exam'] !== null ? $data['nilai_final_exam'] : (object) [
				'NILAI' => 0
			];

			$data['final_min_nilai'] = $data['final_min_nilai'] !== null ? $data['final_min_nilai'] : (object) [
				'MIN_NILAI' => 0
			];
		}

		if (strtotime($orderData->EXPIRED_DATE) < strtotime(date('Y-m-d H:i:s'))) {
			return view('template.header', $data) .
				view('template_guest.course.course_detail_expired', $data) .
				view('template.footer', $data);
		}

		return view('template.header', $data) .
			view('template_guest.course.course_detail', $data) .
			view('template.footer', $data);
	}

	public function getDetailItemCourse()
	{
		$data['id_item'] = $_POST['id_item'];
		$data['type'] = $_POST['type'];
		$data['status'] = $_POST['status'];
		$data['id_activity'] = $_POST['type'] . '/' . $_POST['id_activity'];
		if ($data['type'] == 3) {
			$data['type'] = 2;
			//DELETE NILAI YANG ADA
			DB::table('nilai_quiz')->where('ID_QUIZ', $data['id_item'])->where('ID_USER', session('user')[0]->get('ID_USER'))->delete();
		} else {
			$data['type'] = $_POST['type'];
		}

		$condition_all_mapping = array(
			"ID_USER = '" . session('user')[0]->get('ID_USER') . "'",
			"ID_ACTIVITY = '" . $_POST['id_activity'] . "'",
			"STATUS <> 1"
		);
		$data['data_all_mapping'] = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				" . implode('AND ', $condition_all_mapping) . "
		");

		$max_id_item = DB::selectOne(
			"
			SELECT
				MAX(ID_ITEM) AS MAX_ID
			FROM
				mapping_course
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND ID_ACTIVITY = '" . $_POST['id_activity'] . "'"
		);
		$data['max_id_item'] = $max_id_item->MAX_ID;

		$data_all_mapping = $this->courseModel->get_counttask($_POST['id_activity']);
		$count = ['MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT) + 1];
		if ($data['status'] == 2) {
			DB::table("mapping_course")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_ACTIVITY', $_POST['id_activity'])
				->where('ID_ITEM', $data['data_all_mapping'][0]->ID_ITEM)
				->update(['STATUS' => 1]);

			if ($max_id_item->MAX_ID != $data['data_all_mapping'][0]->ID_ITEM) {
				DB::table("order")
					->where('ID_USER', session('user')[0]->get('ID_USER'))
					->where('ID_PRODUCT', $_POST['id_activity'])
					->update($count);
			}

			if ($data['type'] == 2) {
				$data['next_quiz_grade'] = DB::selectOne('
					SELECT
						NILAI
					FROM
						nilai_quiz
					WHERE
						ID_USER = "' . session('user')[0]->get('ID_USER') . '"
						AND
						ID_QUIZ = ' . $data['data_all_mapping'][0]->ID_ITEM . '
				');
			}
		}
		// GET ID_ITEM DARI LAST ITEM YANG DI TELAH DIBUKA
		$data['last_item'] = DB::select('
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND ID_ACTIVITY = "' . $_POST['id_activity'] . '"
				AND STATUS = 1
			ORDER BY ID_ITEM DESC
		');
		$limit_question = empty($data['last_item'][0]->LIMIT_QUESTION) ? 0 : $data['last_item'][0]->LIMIT_QUESTION;
		$condition = ['tc.ID_ITEM = ' . $data['id_item']];
		// GET DATA UNTUK MATERI, ELSE QUIZ
		$sql = "
			SELECT
				*
			FROM
				item_course tc
			WHERE
				" . implode('AND ', $condition) . "
			";
		$data['detail_item_course'] = DB::select($sql)[0];
		if ($data['type'] != 1) {
			$sql = "
			SELECT
				tc.ID_ITEM,
				tc.TITLE ,
				tc.FILE ,
				tc.LINK_YT ,
				tc.DESKRIPSI ,
				tc.`TYPE` ,
				tc.MIN_NILAI ,
				dq.ID_DETAIL,
				dq.ID_QUIZ ,
				dq.SOAL ,
				dq.PIL_JWB ,
				dq.ORDER_LIST ,
				dq.KUNCI
			FROM
				item_course tc
			LEFT JOIN detail_quiz dq ON
				dq.ID_QUIZ = tc.ID_ITEM
			WHERE
				" . implode('AND ', $condition) . "
			ORDER BY RAND()
			";
			$data['detail_item_course'] = DB::select($sql);
		}
		// GET NILAI QUIZ
		$data['quiz_grade'] = DB::selectOne('
			SELECT
				nq.NILAI,
				ic.MIN_NILAI
			FROM
				nilai_quiz nq
			LEFT JOIN detail_quiz dq ON
				dq.ID_QUIZ = nq.ID_QUIZ
			LEFT JOIN item_course ic ON
				ic.ID_ITEM = dq.ID_QUIZ
			WHERE
				nq.ID_USER = "' . session('user')[0]->get('ID_USER') . '"
			AND
				nq.ID_QUIZ = ' . $data['id_item'] . '
		');
		return view('template_guest.course.ajax.detail_item', $data);
	}

	public function getMappingCourse()
	{
		$condition_all_mapping = "ID_USER = '" . session('user')[0]->get('ID_USER') . "' AND ID_ACTIVITY = '" . $_POST['id_activity'] . "'";
		// $data_all_mapping = $this->courseModel->get_all_mapping($condition_all_mapping);
		$data_all_mapping = DB::select('
			SELECT
				*
			FROM
				mapping_course
			WHERE
				' . $condition_all_mapping . '
		');
		echo json_encode($data_all_mapping);
	}

	public function infoCourse()
	{
		$data['title'] = 'Course';
		$data_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');

		DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
		$id_activity = $_GET['id_activity'];
		$data['checking_trans'] = $this->checkoutModel->get_trans($data_user);
		$data['course'] = $this->courseModel->get_course($id_activity);
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE . "'";
		$data_itemCourse = $this->courseModel->get_item_course($condition);
		$data['item_course'] = array();
		$data['total_item'] = array(
			'materi' => 0,
			'quiz' => 0
		);
		foreach ($data_itemCourse as $item) {
			if ($item->TYPE == 1) {
				array_push(
					$data['item_course'],
					$item
				);
				$data['total_item']['materi']++;
			} else {
				$data['total_item']['quiz']++;
			}
		}

		// dd($data['course']);

		// KOMENTAR
		$data['komentar'] = DB::select("
			SELECT
				tk.komentar,
				u.NAME,
				u.FOTO_PROFILE,
				tk.LOG_TIME
			FROM
				tb_komentar tk
			LEFT JOIN user u ON
				u.ID_USER = tk.ID_USER
			WHERE
				tk.ID_ACTIVITY = '" . $id_activity . "'
		");

		$data['checkout'] = $this->checkoutModel->get_all_order($data_user);

		$courseModel = new Course();
		$data['courses'] = $courseModel->get_courses(["activity.ID_ACTIVITY != '" . $id_activity . "'"]);
		$ebookModel = new Ebook();
		$data['ebooks'] = $ebookModel->get_all_book_home();

		return
			view('template.header', $data) .
			view('template_guest.course.course_info', $data) .
			view('template.footer', $data);
	}

	public function QuizEvaluation()
	{
		$id_quiz = $_POST['id_quiz'];
		$id_detail = $_POST['id_detail'];
		$pilih_jwbn = $_POST['pilih_jwbn'];
		$id_user = session('user')[0]->get('ID_USER');
		$jml_jwbn_benar = 0;
		for ($i = 0; $i < count($id_detail); $i++) {
			// $jml_jwbn_benar += $this->courseModel->get_correct_answer_item_course($id_detail[$i], $pilih_jwbn[$i]);
			$data_sum = DB::selectOne("
			SELECT
				COUNT(ID_DETAIL) AS TOT
			FROM
				detail_quiz
			WHERE
				ID_DETAIL = " . $id_detail[$i] . "
				AND KUNCI = '" . $pilih_jwbn[$i] . "'
			");
			$jml_jwbn_benar += $data_sum->TOT;
		}
		$nilai = round(($jml_jwbn_benar / count($id_detail)) * 100);

		$data['total_data'] = DB::select("
			SELECT
				ID_QUIZ
			FROM
				nilai_quiz
			WHERE
				ID_QUIZ = " . $id_quiz . "
				AND ID_USER = '" . $id_user . "'
		");

		$data_quiz = [
			"ID_QUIZ" => $id_quiz,
			"ID_USER" => $id_user,
			"NILAI" => $nilai
		];

		if (!empty($data['total_data'])) {
			$data_nilai = [
				'NILAI'	=> $nilai
			];

			DB::table('nilai_quiz')->where('ID_QUIZ', $id_quiz)->where('ID_USER', $id_user)->update($data_nilai);
		} else {
			DB::table('nilai_quiz')->insert($data_quiz);
		}

		$dataActivity = DB::selectOne("
			SELECT
				c.ID_ACTIVITY,
				ic.MIN_NILAI
			FROM
				item_course ic
			LEFT JOIN course c ON
				c.ID_COURSE = ic.ID_COURSE
			WHERE
				ic.ID_ITEM = $id_quiz
		");

		$max_id_item = DB::selectOne(
			"
			SELECT
				MAX(ID_ITEM) AS MAX_ID
			FROM
				mapping_course
			WHERE
				ID_USER = '" . $id_user . "'
				AND ID_ACTIVITY = '" . $dataActivity->ID_ACTIVITY . "'"
		);

		$id_final_exam = DB::selectOne("
			SELECT
				FINAL_EXAM
			FROM
				course
			WHERE
				ID_ACTIVITY = '" . $dataActivity->ID_ACTIVITY . "'
		");

		$check_history_final_exam = DB::selectOne("
			SELECT
				*
			FROM
				tb_final_exam
			WHERE
				ID_USER = '" . $id_user . "'
				AND ID_ACTIVITY = '" . $id_final_exam->FINAL_EXAM . "'"
		);

		$data_all_mapping = $this->courseModel->get_counttask($dataActivity->ID_ACTIVITY);
		$count = [
			'MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT) + 1,
			'COURSE_COMPLETED' => 1,
			'DATE_COMPLETED' => date('Y-m-d H:i:s')
		];
		if ($nilai >= $dataActivity->MIN_NILAI && $max_id_item->MAX_ID == $id_quiz) {
			DB::table("order")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $dataActivity->ID_ACTIVITY)
				->update($count);

			if ($check_history_final_exam == null && $id_final_exam->FINAL_EXAM != null) {
				$data_final_exam = [
					"ID_ACTIVITY"	=> $id_final_exam->FINAL_EXAM,
					"ID_USER"		=> session('user')[0]->get('ID_USER'),
					"CODE_EXAM"		=> $this->GenerateCodeExam($id_final_exam->FINAL_EXAM . date('Y-m-d H:i:s')),
					"IS_USED"		=> 0,
					"CREATED_AT"	=> date("Y-m-d H:i:s")
				];
				DB::table('tb_final_exam')->insert($data_final_exam);
			}
		}

		echo $nilai;
	}

	public function searchCourse()
	{
		$keyword = $_GET['keyword'];
		$data['data_search'] = $this->courseModel->get_course_by_id($keyword, 1);
		return
			view('template_guest.course.ajax.item_search', $data);
	}

	public function getFilterByKat(Request $req)
	{
		$condition = (!empty($_POST['category'])) ? "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.KATEGORI = '" . $_POST['category'] . "' AND course.ID_COURSE NOT LIKE 'FNL_%' AND activity.IS_DELETED IS NULL" : "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.ID_COURSE NOT LIKE 'FNL_%' AND activity.IS_DELETED IS NULL";
		$id_user = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		if ($_POST['category'] == 999) {
			$data_id = DB::select("
				SELECT
					ID_ACTIVITY
				FROM
					tb_invited
				WHERE
					ID_USER = '" . $id_user . "'
			");

			$data_ids = array_map(function ($item) {
				return $item->ID_ACTIVITY;
			}, $data_id);
			$placeholders = "'" . implode("','", $data_ids) . "'";
			$condition = "WHERE activity.TYPE_ACTIVITY = 1 AND activity.ID_ACTIVITY IN (" . $placeholders . ") AND activity.IS_DELETED IS NULL";
		}
		if ($id_user != null) {
			$data['course'] = DB::select('
				SELECT
					activity.*,
					course.DESKRIPSI_COURSE,
					(
						SELECT
							COUNT(*)
						FROM
							payment p
						LEFT JOIN `order` o ON
							o.ID_PAY = p.ID_PAY
						WHERE
							o.ID_USER = "' . $id_user . '"
							AND o.ID_PRODUCT = activity.ID_ACTIVITY
							AND p.DATE_PAY IS NOT NULL
					) AS DATA_CHECKING,
					(
						CEIL(
							(
								SELECT
									MAX(o.MAPPING_COUNT)
								FROM
									`order` o
								WHERE
									o.ID_USER = "' . $id_user . '"
									AND o.ID_PRODUCT = activity.ID_ACTIVITY
							) /
							(
								SELECT
									COUNT(*)
								FROM
									mapping_course
								WHERE
									mapping_course.ID_USER = "' . $id_user . '"
									AND mapping_course.ID_ACTIVITY = activity.ID_ACTIVITY
							) * 100
						)
					) AS PROGRESS
				FROM
					activity
				LEFT JOIN course ON
					course.ID_ACTIVITY = activity.ID_ACTIVITY
				' . $condition . '
				');
		} else {
			$data['course'] = DB::select('
				SELECT
					activity.*,
					course.DESKRIPSI_COURSE
				FROM
					activity
				LEFT JOIN
					course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
					' . $condition . '
				');
		}

		return
			view('template_guest.course.ajax.course_by_category', $data);
	}

	public function addKomen(Request $request)
	{
		$data = [
			'ID_USER' => $request->input('id_user'),
			'ID_ACTIVITY' => $request->input('id_activity'),
			'komentar' => $request->input('komentar'),
			'LOG_TIME' => date('Y-m-d H:i:s'),
		];
		DB::table('tb_komentar')->insert($data);
		return redirect()->back();
	}

	public function buyBack(Request $req)
	{
		$idAct = $req->input('id_activity');

		$dataOrder = DB::selectOne("
			SELECT
				o.* ,
				a.TITLE_ACTIVITY ,
				a.PRICE_ACTIVITY
			FROM
				`order` o
			LEFT JOIN activity a ON
				a.ID_ACTIVITY = o.ID_PRODUCT
			WHERE
				o.ID_PRODUCT = ?
				AND
				o.ID_USER = ?
			ORDER BY
				o.LOG_TIME DESC
		", [$idAct, Session::get('user')[0]->get('ID_USER')]);

		$slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $dataOrder->TITLE_ACTIVITY));
		try {
			$data_order = array(
				"ID_ORDER" => $this->GenerateUniqChild('ORD', uniqid()),
				"ID_PRODUCT" => $dataOrder->ID_PRODUCT,
				"ID_USER" => $dataOrder->ID_USER,
				"ID_PAY" => NULL,
				"PRICE_ORDER" => $dataOrder->PRICE_ACTIVITY,
				"MAPPING_COUNT" => $dataOrder->MAPPING_COUNT,
				"COURSE_COMPLETED" => $dataOrder->COURSE_COMPLETED,
				"LOG_TIME" => date("Y-m-d H:i:s"),
				"EXPIRED_DATE" => NULL
			);
			DB::beginTransaction();
			DB::table("order")->insert($data_order);
			DB::commit();

			return redirect('course/detail/' . $slug . '?id_activity=' . $idAct)->with('succ_msg', 'Successfully create buy back transaction');
		} catch (Exception $err) {
			DB::rollBack();
			return redirect('course/detail/' . $slug . '?id_activity=' . $idAct)->with('err_msg', 'Failed to buy back, error: ' . $err->getMessage());
		}
	}
	// END COURSE CONTROLLER

	public function GenerateUniqChild($first, $val)
	{
		$input = $val;
		$hash = md5($input);
		$sixDigitID = strtoupper(substr($hash, 0, 6));
		$generatedID = $first . '_' . $sixDigitID;
		return $generatedID;
	}

	public function finalExam(Request $request) {
		$data['title'] = 'Final Exam';
		$data['id_activity'] = $request->id;
		$data['code'] = $request->code;

		$is_code_verif = $this->isCodeVerif($data['code']);
		$id_activity_parent = DB::selectOne("
			SELECT
				ID_ACTIVITY
			FROM
				course
			WHERE
				FINAL_EXAM = ?;
		", [$data['id_activity']])->ID_ACTIVITY;
		$data['id_activity_parent'] = $id_activity_parent;
		if ($is_code_verif == false) {
			return redirect('course/detail/courses?id_activity=' . $id_activity_parent)->with('err_msg', 'Code not valid');
		}

		$data['id_course'] = DB::selectOne("
			SELECT
				ID_COURSE
			FROM
				course
			WHERE
				ID_ACTIVITY = ?
		", [$request->id])->ID_COURSE;
		$idItems = DB::select("
			SELECT
				ID_ITEM
			FROM
				item_course
			WHERE
				ID_COURSE = ?
		", [$data['id_course']]);

		$data['nilai_final_exam'] = DB::selectOne("
			SELECT
				NILAI
			FROM
				tb_nilai_final_exam
			WHERE
				ID_USER = ?
				AND ID_ACTIVITY = ?
				AND CODE_EXAM = ?
			ORDER BY
				created_at DESC
		", [session('user')[0]->get('ID_USER'), $request->id, $data['code']]);

		$idItemArray = array_map(fn($item) => $item->ID_ITEM, $idItems);
		if (empty($idItemArray)) {
			$data['data'] = [];
		} else {
			$idItemString = implode(',', array_map('intval', $idItemArray));
			$data['data'] = DB::select("
				SELECT
					tc.ID_ITEM,
					tc.TITLE,
					tc.FILE,
					tc.LINK_YT,
					tc.DESKRIPSI,
					tc.`TYPE`,
					tc.MIN_NILAI,
					dq.ID_DETAIL,
					dq.ID_QUIZ,
					dq.SOAL,
					dq.PIL_JWB,
					dq.ORDER_LIST,
					dq.KUNCI
				FROM
					item_course tc
				LEFT JOIN detail_quiz dq ON
					dq.ID_QUIZ = tc.ID_ITEM
				WHERE
					tc.ID_ITEM IN ($idItemString)
				ORDER BY RAND()
			");
		}

		$data['quiz_grade'] = null;

		return view('template.header', $data) .
			view('template_guest.course.final_exam', $data) .
			view('template.footer', $data);
	}

	public function FinalExamEvaliation(Request $request)
	{
		$id_quiz = $_POST['id_quiz'];
		$id_detail = $_POST['id_detail'];
		$pilih_jwbn = $_POST['pilih_jwbn'];
		$id_user = session('user')[0]->get('ID_USER');
		$code_exam = $request->code_exam;
		$min_nilai = $request->min_nilai;

		$is_code_verif = $this->isCodeVerif($code_exam);
		$id_activity_parent = DB::selectOne("
			SELECT
				ID_ACTIVITY
			FROM
				course
			WHERE
				FINAL_EXAM = ?;
		", [$request->id_activity])->ID_ACTIVITY;
		if ($is_code_verif == false) {
			return response()->json([
				'status' => 'error',
				'message' => 'Code not valid',
				'url' => 'course/detail/courses?id_activity=' . $id_activity_parent
			]);
		}

		$jml_jwbn_benar = 0;
		for ($i = 0; $i < count($id_detail); $i++) {
			$data_sum = DB::selectOne("
			SELECT
				COUNT(ID_DETAIL) AS TOT
			FROM
				detail_quiz
			WHERE
				ID_DETAIL = " . $id_detail[$i] . "
				AND KUNCI = '" . $pilih_jwbn[$i] . "'
			");
			$jml_jwbn_benar += $data_sum->TOT;
		}
		$nilai = round(($jml_jwbn_benar / count($id_detail)) * 100);

		$data_nilai = [
			"ID_ACTIVITY" 	=> $_POST['id_activity'],
			"ID_QUIZ" 		=> $id_quiz,
			"ID_USER" 		=> $id_user,
			"CODE_EXAM" 	=> $_POST['code_exam'],
			"NILAI" 		=> $nilai,
			"created_at" 	=> date('Y-m-d H:i:s'),
		];

		$id_activity_parent = DB::selectOne("
			SELECT
				ID_ACTIVITY
			FROM
				course
			WHERE
				FINAL_EXAM = ?;
		", [$_POST['id_activity']])->ID_ACTIVITY;

		DB::table('tb_final_exam')->where('CODE_EXAM', $_POST['code_exam'])->update(['IS_USED' => 1]);
		DB::table('tb_nilai_final_exam')->insert($data_nilai);

		$gambar = 'https://img.freepik.com/free-vector/completed-concept-illustration_114360-3891.jpg';
		if($min_nilai > $nilai) {
			$gambar = 'https://tbh-v2.is3.cloudhost.id/IMAGE_ACTIVITY/Image-Activity-1741074077-1741074078.png';
		}

		return response()->json([
			'status' => 'success',
			'nilai' => $nilai,
			'id_activity_parent' => $id_activity_parent,
			'gambar' => $gambar
		]);
	}

	public function ValidasiCode(Request $request) {
		$code = $request->code;
		$id_activity = $request->id_activity;

		$finalExamCode = DB::selectOne("
			SELECT
				ID_FINAL_EXAM
			FROM
				tb_final_exam
			WHERE
				CODE_EXAM = ?
				AND IS_USED = 0
		", [$code]);
		if (empty($finalExamCode)) {
			return response()->json([
				'status' => 'error',
				'message' => 'Code not found'
			]);
		}

		return response()->json([
			'status' => 'success',
			'message' => 'Code Valid'
		]);
	}

	public function GenerateCodeExam($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$scrap  = str_ireplace(["a", "e", "i", "o", "u"], "", $string);
		$begin  = strtoupper(substr($scrap, 0, 3));
		do {
			$code = $begin . strtoupper(substr(md5(microtime()), 0, 3));
			$code_check = DB::selectOne("
				SELECT
					CODE_EXAM
				FROM
					tb_final_exam
				WHERE
					CODE_EXAM = ?
				", [$code]
			);
		} while (!empty($code_check));

		return $code;
	}

	public function isCodeVerif($code)
	{
		$finalExamCode = DB::selectOne("
			SELECT
				ID_FINAL_EXAM
			FROM
				tb_final_exam
			WHERE
				CODE_EXAM = ?
				AND IS_USED = 0
		", [$code]);
		if (empty($finalExamCode)) {
			return false;
		}

		return true;

	}
}
