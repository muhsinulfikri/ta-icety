<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Category;
use App\Models\Certificate;
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

	public function __construct()
	{

		$this->eventModel = new Event();
		$this->courseModel = new Course();
		$this->checkoutModel = new Checkout();
		$this->categoryModel = new Category();
		$this->certificateModel = new Certificate();
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
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE ."'".
			" AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";
		$this->courseModel->updateMappingIndex($data['course']->ID_COURSE, $data['id_activity']);
		$data['item_course'] = $this->courseModel->get_item_course($condition);
		// $data['last_item'] = $this->courseModel->get_last_item_course($data['id_activity']);
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

		$condition_all_mapping =
			"ID_USER = '" . session('user')[0]->get('ID_USER') .
			"'AND ID_ACTIVITY = '" . $data['id_activity'] . "'";
		// $data['data_all_mapping'] = $this->courseModel->get_all_mapping($condition_all_mapping);
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
				AND ID_QUIZ = ".$data['last_item'][0]->ID_ITEM."
			");

		$cek_quiz = DB::select("
			SELECT
				*
			FROM
				item_course
			WHERE
				TYPE = 2
				AND ID_COURSE = '".$data['course']->ID_COURSE."'
			");

		if (count($data['last_item']) == count($data['data_all_mapping']) && (!empty($cek_nilai->NILAI) ? $cek_nilai->NILAI == 100 : false)) {
			$data['tot_proggress'] = 100;
			DB::table('order')->where('ID_USER', session('user')[0]->get('ID_USER'))->where('ID_PRODUCT', $data['id_activity'])->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping'])]);
		}

		if (count($data['last_item']) == count($data['data_all_mapping']) && empty($cek_quiz)) {
			$data['tot_proggress'] = 100;
			DB::table('order')->where('ID_USER', session('user')[0]->get('ID_USER'))->where('ID_PRODUCT', $data['id_activity'])->update(['COURSE_COMPLETED' => 1, 'MAPPING_COUNT' => count($data['data_all_mapping'])]);
		}

		// $sertifCheck = $this->certificateModel->getCertificate($con);
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
			$sertif_number = $data['course']->ID_COURSE . '/' . (($data['course']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/TBH/' . $bln[(date('m', strtotime($data['course']->DATE_START)) - 1)] . '/' . date('Y');
			$sertif_path = $this->certificateModel->generate(session('user')[0]->get('NAME'), $data['course']->TITLE_ACTIVITY, $sertif_number, $data['course']->SERTIF_IMAGE);
			$data_sertif = array(
				"ID_USER" => session('user')[0]->get('ID_USER'),
				"ID_ACTIVITY" => $data['id_activity'],
				"NO_SERTIFIKAT" => $sertif_number,
				"JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
				"FILE_SERTIFIKAT" => $sertif_path,
				"LOG_TIME" => date('Y-m-d H:i:s')
			);
			// $this->certificateModel->createCertificate($data_sertif);
			DB::table('sertifikat_activity')->insert($data_sertif);

			// $data['sertif'] = $this->certificateModel->getCertificate($data_sertif);
			$data['sertif'] = (object) $data_sertif;
		} else {
			$data['sertif'] = $sertifCheck;
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
			// $this->courseModel->DeleteQuizPenilaian(['ID_QUIZ' => $data['id_item'], 'ID_USER' => session('user')[0]->get('ID_USER')]);
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
		// $data['data_all_mapping'] = $this->courseModel->get_all_mapping($condition_all_mapping);
		$data['data_all_mapping'] = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				" . implode('AND ', $condition_all_mapping) . "
		");
		if ($data['status'] == 2) {
			$data_all_mapping = $this->courseModel->get_counttask($_POST['id_activity']);
			$data_mapping = ['STATUS' => 1];
			$count = ['MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT)+1];
			// $this->courseModel->UpdateMapping($data_mapping, $condition_update_mapping);
			//UPDATE STATUS MAPPING LAST ITEM COURSE
			DB::table("mapping_course")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_ACTIVITY', $_POST['id_activity'])
				->where('ID_ITEM', $data['data_all_mapping'][0]->ID_ITEM)
				->update($data_mapping);
			DB::table("order")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $_POST['id_activity'])
				->update($count);
		}
		// $data['last_item'] = $this->courseModel->get_last_item_course($_POST['id_activity'])[0];
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
		// $data['detail_item_course'] = $this->courseModel->get_detail_item_course($condition, $data['type']);
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
				".implode('AND ', $condition)."
			ORDER BY RAND()
			";
			$data['detail_item_course'] = DB::select($sql);
		}
		// $data['quiz_grade'] = $this->courseModel->get_quiz_grade($data['id_item']);
		// GET NILAI QUIZ
		$data['quiz_grade'] = DB::selectOne('
			SELECT
				NILAI
			FROM
				nilai_quiz
			WHERE
				ID_USER = "' . session('user')[0]->get('ID_USER') . '"
				AND ID_QUIZ = ' . $data['id_item'] . '
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
		$condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE. "'";
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
		$nilai = ($jml_jwbn_benar / count($id_detail)) * 100;

		// $this->courseModel->save_quiz_grade($id_quiz, $nilai);
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
			DB::table('nilai_quiz')
				->where('ID_QUIZ', $id_quiz)
				->where('ID_USER', "'" . $id_user . "'")
				->update($data_quiz);
		} else {
			DB::table('nilai_quiz')->insert($data_quiz);
		}

		$dataActivity = DB::selectOne("
			SELECT
				c.ID_ACTIVITY
			FROM
				item_course ic
			LEFT JOIN course c ON
				c.ID_COURSE = ic.ID_COURSE
			WHERE
				ic.ID_ITEM = $id_quiz
		");

		$max_id_item = DB::selectOne("
			SELECT
				MAX(ID_ITEM) AS MAX_ID
			FROM
				mapping_course
			WHERE
				ID_USER = '" . $id_user . "'
				AND ID_ACTIVITY = '" . $dataActivity->ID_ACTIVITY . "'"
		);

		$data_all_mapping = $this->courseModel->get_counttask($dataActivity->ID_ACTIVITY);
		$count = ['MAPPING_COUNT' => ((int) $data_all_mapping[0]->MAPPING_COUNT) + 1];
		if ($nilai >= 75 && $max_id_item->MAX_ID == $id_quiz) {
			DB::table("order")
				->where('ID_USER', session('user')[0]->get('ID_USER'))
				->where('ID_PRODUCT', $dataActivity->ID_ACTIVITY)
				->update($count);
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
		// $condition = (!empty($_POST['category'])) ? "WHERE activity.TYPE_ACTIVITY = 1 AND course.KATEGORI = '" . $_POST['category'] . "'" : "WHERE activity.TYPE_ACTIVITY = 1";
		$condition = (!empty($_POST['category'])) ? "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.KATEGORI = '" . $_POST['category'] . "'" : "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1";
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

			$data_ids = array_map(function($item) {
				return $item->ID_ACTIVITY;
			}, $data_id);
			$placeholders = "'". implode("','", $data_ids) . "'";
			$condition = "WHERE activity.TYPE_ACTIVITY = 1 AND activity.ID_ACTIVITY IN (".$placeholders.")";
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
				'.$condition.'
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
	// END COURSE CONTROLLER
}
