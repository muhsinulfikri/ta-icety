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
use App\Models\User;
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
    protected $userModel;

	public function __construct()
	{

		$this->eventModel = new Event();
		$this->courseModel = new Course();
		$this->checkoutModel = new Checkout();
		$this->categoryModel = new Category();
		$this->certificateModel = new Certificate();
        $this->activityModel = new Activity();
        $this->finalExamModel = new FinalExam();
        $this->userModel = new User();
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
        // dd($data);
		return
			view('landing_page.header', $data) .
			view('template_guest.course.course', $data) .
			view('landing_page.footer', $data);
	}
	public function detailCourse()
    {
        if (session('user') == null) {
            return redirect('login');
        }

        $data = $this->initializeCourseData();
        $this->updateCourseProgress($data);
        $this->handleCourseCompletion($data);
        // $this->handleCertificateGeneration($data);
        $this->handleFinalExamLogic($data);
        $this->handleRemedialLogic($data);
        $this->loadAdditionalData($data);
        // dd($data);
        return $this->renderCourseView($data);
    }

    private function initializeCourseData()
    {
        $data = [
            'title' => 'Course',
            'id_activity' => $_GET['id_activity'],
        ];

        $data['course'] = $this->courseModel->get_course($data['id_activity']);

        $finalExamModel = new FinalExam();
        $summary_sertif = $this->activityModel->get_summary_sert_activity($data['id_activity']);

        $condition = "item_course.ID_COURSE = '" . $data['course']->ID_COURSE . "'" .
            " AND mapping_course.ID_USER = '" . session('user')[0]->get('ID_USER') . "'";

        $data_category_user = $this->userModel->get_user(session('user')[0]->get('ID_USER'));

        $this->courseModel->updateMappingIndex($data['course']->ID_COURSE, $data['id_activity']);

        $data['item_course'] = $this->courseModel->get_item_course($condition);
        $data['testimoni'] = $this->courseModel->getTesti($data['id_activity'], session('user')[0]->get('ID_USER'));
        $this->loadPaymentData($data);
        return $data;
    }

    private function updateCourseProgress(&$data)
    {
        // $data['date_sertif_course'] = DB::select("
        //     SELECT o.DATE_COMPLETED
        //     FROM `order` o
        //     LEFT JOIN activity a ON a.ID_ACTIVITY = o.ID_PRODUCT
        //     LEFT JOIN user u ON u.ID_USER = o.ID_USER
        //     WHERE a.ID_ACTIVITY = '{$data['id_activity']}'
        //     AND u.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
        // ");

        $completed_course = $this->courseModel->get_completed_course(session('user')[0]->get('ID_USER'), $data['id_activity']);

        $data['last_item'] = DB::select('
            SELECT *
            FROM mapping_course
            WHERE ID_USER = "' . session('user')[0]->get('ID_USER') . '"
            AND ID_ACTIVITY = "' . $data['id_activity'] . '"
            AND STATUS = 1
            ORDER BY ID_ITEM DESC
        ');

        $condition_all_mapping = "ID_USER = '" . session('user')[0]->get('ID_USER') . "'AND ID_ACTIVITY = '" . $data['id_activity'] . "'";

        $data['data_all_mapping'] = DB::select("
            SELECT *
            FROM mapping_course
            WHERE $condition_all_mapping
        ");

        $data_all_mapping = $this->courseModel->get_counttask($data['id_activity']);
        $data['tot_proggress'] = (!empty($data['last_item'])) ? (((int) $data_all_mapping[0]->MAPPING_COUNT) / count($data['data_all_mapping'])) * 100 : 0;
    }

    private function handleCourseCompletion(&$data)
    {
        $cek_nilai = DB::selectOne("
            SELECT *
            FROM nilai_quiz
            WHERE ID_USER = '" . session('user')[0]->get('ID_USER') . "'
            AND ID_QUIZ = " . $data['last_item'][0]->ID_ITEM . "
        ");

        $cek_quiz = DB::select("
            SELECT *
            FROM item_course
            WHERE TYPE = 2
            AND ID_COURSE = '" . $data['course']->ID_COURSE . "'
        ");

        $cek_item_course = DB::selectOne("
            SELECT *
            FROM item_course
            WHERE ID_ITEM = " . $data['last_item'][0]->ID_ITEM . "
        ");

        $finalExamModel = new FinalExam();
        $data['get_data_final_exam'] = $finalExamModel->get_final_exam($data['course']->FINAL_EXAM);

        $check_history_final_exam = DB::selectOne("
            SELECT *
            FROM tb_final_exam
            WHERE ID_USER = '" . session('user')[0]->get('ID_USER') . "'
            AND ID_ACTIVITY = '" . $data['course']->FINAL_EXAM . "'"
        );

        // Check if course is completed with quiz
        if (count($data['last_item']) == count($data['data_all_mapping']) &&
            (!empty($cek_nilai->NILAI) ? $cek_nilai->NILAI >= $cek_item_course->MIN_NILAI : false)) {
            $this->markCourseAsCompleted($data, $check_history_final_exam);
        }

        // Check if course is completed without quiz
        if (count($data['last_item']) == count($data['data_all_mapping']) && ($cek_item_course->TYPE == 1)) {
            $this->markCourseAsCompleted($data, $check_history_final_exam);
        }
    }

    private function markCourseAsCompleted(&$data, $check_history_final_exam)
    {
        $data['tot_proggress'] = 100;

        DB::table('order')
            ->where('ID_USER', session('user')[0]->get('ID_USER'))
            ->where('ID_PRODUCT', $data['id_activity'])
            ->update([
                'COURSE_COMPLETED' => 1,
                'MAPPING_COUNT' => count($data['data_all_mapping']),
                'DATE_COMPLETED' => date('Y-m-d H:i:s')
            ]);

        if ($check_history_final_exam == null &&
            $data['course']->FINAL_EXAM != null &&
            $data['get_data_final_exam']->INCLUDE_COURSE == 1) {

            $this->createFinalExamEntry($data['course']->FINAL_EXAM);
        }
    }

    private function createFinalExamEntry($finalExamId)
    {
        $data_final_exam = [
            "ID_ACTIVITY" => $finalExamId,
            "ID_USER" => session('user')[0]->get('ID_USER'),
            "CODE_EXAM" => $this->GenerateCodeExam($finalExamId . date('Y-m-d H:i:s')),
            "IS_USED" => 0,
            "CREATED_AT" => date("Y-m-d H:i:s")
        ];

        DB::table('tb_final_exam')->insert($data_final_exam);
    }

    public function handleCertificateGeneration(Request $request)
    {
        $id_activity = $request->input('id_activity');
        $userId = session('user')[0]->get('ID_USER');

        $data = [
            'id_activity' => $id_activity,
            'course' => $this->courseModel->get_course($id_activity),
        ];

        // Ambil progress
        $condition_all_mapping = "ID_USER = '$userId' AND ID_ACTIVITY = '$id_activity'";
        $data['data_all_mapping'] = DB::select("SELECT * FROM mapping_course WHERE $condition_all_mapping");
        $data['last_item'] = DB::select("SELECT * FROM mapping_course WHERE $condition_all_mapping AND STATUS = 1 ORDER BY ID_ITEM DESC");
        $data['tot_proggress'] = (count($data['last_item']) == count($data['data_all_mapping'])) ? 100 : 0;
        $this->loadPaymentData($data);
        if ($data['tot_proggress'] == 100) {
            // cek sertif sudah ada atau belum
            $sertifCheck = DB::selectOne("
                SELECT ID_SERTIFIKAT, FILE_SERTIFIKAT
                FROM sertifikat_activity
                WHERE $condition_all_mapping
            ");

            if (!empty($sertifCheck) && !empty($sertifCheck->FILE_SERTIFIKAT)) {
                DB::table('payment_sertif')
                    ->where('ID_USER', $userId)
                    ->where('ID_ACTIVITY', $id_activity)
                    ->update([
                        'ID_SERTIFIKAT' => $sertifCheck->ID_SERTIFIKAT,
                ]);
                return response()->json([
                    'status' => 'exists',
                    'file'   => url($sertifCheck->FILE_SERTIFIKAT)
                ]);
            }
            $this->generateCourseCertificate($data, $sertifCheck);
            return response()->json([
                'status' => 'generated',
                'file'   => url($data['sertif_course']->FILE_SERTIFIKAT)
            ]);
        }
        return response()->json(['status' => 'failed', 'message' => 'Progress belum 100%']);

    }

    private function generateCourseCertificate(&$data, $sertifCheck)
    {
        $institusi_name = $this->userModel->get_intitusi_name(session('user')[0]->get('ID_USER'));
        $completed_course = $this->courseModel->get_completed_course(session('user')[0]->get('ID_USER'), $data['id_activity']);
        $summary_sertif = $this->activityModel->get_summary_sert_activity($data['id_activity']);

        if ($completed_course == 0) {
            return 1;
        }

        $sertif_number_course = $this->generateCertificateNumber($data);
        $data_category_user = $this->userModel->get_user(session('user')[0]->get('ID_USER'));

        if ($data_category_user[0]->ID_CATEGORY_USER == 5) {
            $this->handleSchoolCertificate($data, $sertifCheck, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif);
        } else {
            $this->handleRegularCertificate($data, $sertifCheck, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif);
        }

        $data['id_sertif'] = DB::selectOne("
            SELECT ID_SERTIFIKAT
            FROM sertifikat_activity
            WHERE ID_ACTIVITY = '{$data['id_activity']}'
            AND ID_USER = '" . session('user')[0]->get('ID_USER') . "'
        ")->ID_SERTIFIKAT;
    }

    private function generateCertificateNumber($data)
    {
        $bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $countSertifCourse = DB::table('sertifikat_activity')
            ->where('ID_ACTIVITY', $data['id_activity'])
            ->count() + 1;

        return $countSertifCourse . '/' .
            (($data['course']->TYPE_ACTIVITY == 1) ? 'CRS' : 'EVT') . '/' .
            $data['course']->ALIAS . '/ICETy/' .
            $bln[(date('m', strtotime($data['course']->DATE_START)) - 1)] . '/' .
            date('Y');
    }

    private function handleSchoolCertificate(&$data, $sertifCheck, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif)
    {
        if (!empty($sertifCheck) && !empty($sertifCheck->ID_SERTIFIKAT)) {
            $this->updateExistingCertificate($data, $sertifCheck->ID_SERTIFIKAT, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif);
        } else {
            $this->createNewCertificate($data, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif);
        }
    }

    private function handleRegularCertificate(&$data, $sertifCheck, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif)
    {
        // Same logic as school certificate for now
        $this->handleSchoolCertificate($data, $sertifCheck, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif);
    }

    private function updateExistingCertificate(&$data, $id_sertif, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif)
    {
        if (!empty($data['date_sertif_course'])) {
            $dateCompleted = $data['date_sertif_course'][0]->DATE_COMPLETED;
        } else {
            $dateCompleted = now(); // fallback default tanggal hari ini
        }
        $sertif_path_course = $this->certificateModel->generateCourseSekolah(
            session('user')[0]->get('NAME'),
            $data['course']->TITLE_CERTIFICATE,
            $sertif_number_course,
            $data['course']->SERTIF_IMAGE,
            $summary_sertif[0]->SUMMARY_CERTIFICATE,
            $summary_sertif[0]->MODULE_CERTIFICATE,
            $completed_course[0]->days_difference,
            date('d F Y', strtotime($dateCompleted)),
            $id_sertif,
            $institusi_name[0]->UNIV
        );

        $data_sertif_course = [
            "FILE_SERTIFIKAT" => $sertif_path_course,
            "LOG_TIME" => date('Y-m-d H:i:s')
        ];

        DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif)->update($data_sertif_course);
        $data['sertif_course'] = (object) $data_sertif_course;
    }

    private function createNewCertificate(&$data, $sertif_number_course, $institusi_name, $completed_course, $summary_sertif)
    {
        if (!empty($data['date_sertif_course'])) {
            $dateCompleted = $data['date_sertif_course'][0]->DATE_COMPLETED;
        } else {
            $dateCompleted = now(); // fallback default tanggal hari ini
        }

        $data_sertif_course = [
            "ID_USER" => session('user')[0]->get('ID_USER'),
            "ID_ACTIVITY" => $data['id_activity'],
            "NO_SERTIFIKAT" => $sertif_number_course,
            "JENIS_SERTIFIKAT" => $data['course']->TYPE_ACTIVITY,
            "FILE_SERTIFIKAT" => null,
            "INTITUSI_NAME" => $institusi_name[0]->UNIV,
            "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
            "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
            "DURATION" => $completed_course[0]->days_difference,
            "DATE_COMPLETED" => date('d F Y', strtotime($dateCompleted)),
            "LOG_TIME" => date('Y-m-d H:i:s')
        ];

        $id_sertif = DB::table('sertifikat_activity')->insertGetId($data_sertif_course);

        $sertif_path_course = $this->certificateModel->generateCourseSekolah(
            session('user')[0]->get('NAME'),
            $data['course']->TITLE_CERTIFICATE,
            $sertif_number_course,
            $data['course']->SERTIF_IMAGE,
            $summary_sertif[0]->SUMMARY_CERTIFICATE,
            $summary_sertif[0]->MODULE_CERTIFICATE,
            $completed_course[0]->days_difference,
            $dateCompleted,
            $id_sertif,
            $institusi_name[0]->UNIV
        );

        $data_sertif_course["FILE_SERTIFIKAT"] = $sertif_path_course;
        DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif)->update($data_sertif_course);
        $data['sertif_course'] = (object) $data_sertif_course;
    }

    private function loadPaymentData(&$data)
    {
        $data['id_payment_sertif'] = DB::table('payment_sertif')
            ->where('ID_USER', session('user')[0]->get('ID_USER'))
            ->where('ID_ACTIVITY', $data['id_activity'])
            ->value('ID_PAYMENT_SERTIF');

        $data['id_sertif_is_paid'] = $this->certificateModel->getSertifIsPaid($data['id_payment_sertif']);

        $data['is_paid'] = DB::table('payment_sertif')
            ->where('ID_ACTIVITY', $data['id_activity'])
            ->where('ID_USER', session('user')[0]->get('ID_USER'))
            ->value('IS_PAY');
    }

    private function handleFinalExamLogic(&$data)
    {
        $finalExamModel = new FinalExam();

        if ($data['course']->FINAL_EXAM != null) {
            $this->loadFinalExamData($data, $finalExamModel);
            // $this->handleFinalExamCertificate($data, $finalExamModel);
        } else {
            $this->setDefaultFinalExamData($data);
        }
    }

    private function loadFinalExamData(&$data, $finalExamModel)
    {
        $data['final_exam'] = DB::selectOne("
            SELECT CODE_EXAM
            FROM tb_final_exam
            WHERE ID_ACTIVITY = ? AND ID_USER = ? AND IS_USED = 0
        ", [$data['course']->FINAL_EXAM, session('user')[0]->get('ID_USER')]);

        $data['final_min_nilai'] = DB::selectOne("
            SELECT COALESCE(ic.MIN_NILAI, '80') AS MIN_NILAI
            FROM item_course ic
            LEFT JOIN course c ON c.ID_COURSE = ic.ID_COURSE
            WHERE c.ID_ACTIVITY = ?
        ", [$data['course']->FINAL_EXAM]);

        $data['nilai_final_exam'] = DB::selectOne("
            SELECT NILAI, created_at
            FROM tb_nilai_final_exam
            WHERE ID_USER = ? AND ID_ACTIVITY = ?
            ORDER BY NILAI DESC
        ", [session('user')[0]->get('ID_USER'), $data['course']->FINAL_EXAM]);

        $data['history_nilai_final_exam'] = DB::select("
            SELECT NILAI, created_at
            FROM tb_nilai_final_exam
            WHERE ID_USER = ? AND ID_ACTIVITY = ?
            ORDER BY created_at ASC
        ", [session('user')[0]->get('ID_USER'), $data['course']->FINAL_EXAM]);

        $data['data_final_exam'] = $finalExamModel->get_final_exam($data['course']->FINAL_EXAM);
        $data['nilai_final_exam'] = $data['nilai_final_exam'] ?? (object) ['NILAI' => 0];
    }

    private function setDefaultFinalExamData(&$data)
    {
        $data['final_exam'] = null;
        $data['final_min_nilai'] = (object) ['MIN_NILAI' => 0];
        $data['history_nilai_final_exam'] = null;
        $data['nilai_final_exam'] = (object) ['NILAI' => 0];
        $data['data_final_exam'] = (object) ['TITLE_ACTIVITY' => 0, 'PRICE_ACTIVITY' => 0];
    }

    public function handleFinalExamCertificate(Request $request){
        $id_activity = $request->input('id_activity');
        $userId = session('user')[0]->get('ID_USER');

        $data = [
            'id_activity' => $id_activity,
            'final_exam' => $this->finalExamModel->get_final_exam($id_activity),
        ];

        // ambil nilai ujian akhir
        $exam = DB::selectOne("
            SELECT * FROM tb_nilai_final_exam
            WHERE ID_USER = '$userId' AND ID_ACTIVITY = '".$data['final_exam']->ID_ACTIVITY."'
            ORDER BY CREATED_AT DESC
            LIMIT 1
        ");
        if ($exam && $exam->NILAI >= 70) { // misal syarat lulus >= 70
            $sertifCheck = DB::selectOne("
                SELECT ID_SERTIFIKAT, FILE_SERTIFIKAT
                FROM sertifikat_activity
                WHERE ID_USER = '$userId' AND ID_ACTIVITY = '".$data['final_exam']->ID_ACTIVITY."'
            ");
            if (!empty($sertifCheck) || !empty($sertifCheck->FILE_SERTIFIKAT)) {
                return response()->json([
                    'status' => 'exists',
                    'file'   => url($sertifCheck->FILE_SERTIFIKAT)
                ]);
            }
            $this->generateFinalExamCertificate($data);
            return response()->json([
                'status' => 'generated',
                'file'   => url($data['sertif_exam']->FILE_SERTIFIKAT)
            ]);
        }

        return response()->json(['status' => 'failed', 'message' => 'Ujian akhir belum lulus']);
    }

    private function generateFinalExamCertificate(&$data)
    {
        $id_course_completed = DB::selectOne("
            SELECT ID_ACTIVITY
            FROM course
            WHERE FINAL_EXAM = '".$data['id_activity']."'
        ");
        $completed_course = $this->courseModel->get_completed_course(session('user')[0]->get('ID_USER'), $id_course_completed->ID_ACTIVITY);
        $summary_sertif = $this->activityModel->get_summary_sert_activity($id_course_completed->ID_ACTIVITY);
        $nilai = $this->finalExamModel->get_nilai_for_sertif($data['id_activity'], session('user')[0]->get('ID_USER'));
        if ($completed_course == 0) {
            return 1;
        }
        // dd($summary_sertif);
        $data['exam'] = $this->finalExamModel->get_final_exam($data['id_activity']);
        $bln = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $countSertifExam = DB::table('sertifikat_activity')
            ->where('ID_ACTIVITY', $data['id_activity'])
            ->count() + 1;

        $sertif_number_exam = $countSertifExam . '/' . 'FINAL-EXAM' . '/' . $data['final_exam']->ALIAS . '/ICETy/' .
                            $bln[(date('m', strtotime($data['final_exam']->DATE_START)) - 1)] . '/' . date('Y');

        $data_sertif_exam = [
            "ID_USER" => session('user')[0]->get('ID_USER'),
            "ID_ACTIVITY" => $data['id_activity'],
            "NO_SERTIFIKAT" => $sertif_number_exam,
            "JENIS_SERTIFIKAT" => $data['final_exam']->TYPE_ACTIVITY,
            "FILE_SERTIFIKAT" => null,
            "SUMMARY_CERTIFICATE" => $summary_sertif[0]->SUMMARY_CERTIFICATE,
            "INFO_CERTIFICATE" => $summary_sertif[0]->MODULE_CERTIFICATE,
            "DURATION" => $completed_course[0]->days_difference,
            "DATE_COMPLETED" => date('d F Y', strtotime($nilai->created_at)),
            "LOG_TIME" => date('Y-m-d H:i:s')
        ];

        $id_sertif_exam = DB::table('sertifikat_activity')->insertGetId($data_sertif_exam);

        $sertif_path_exam = $this->certificateModel->generateSertifExam(
            session('user')[0]->get('NAME'),
            $summary_sertif[0]->TITLE_CERTIFICATE,
            $sertif_number_exam,
            $data['exam']->SERTIF_IMAGE,
            $summary_sertif[0]->SUMMARY_CERTIFICATE,
            $summary_sertif[0]->MODULE_CERTIFICATE,
            $completed_course[0]->days_difference,
            $nilai->created_at,
            $id_sertif_exam
        );

        $data_sertif_exam["FILE_SERTIFIKAT"] = $sertif_path_exam;
        DB::table('sertifikat_activity')->where('ID_SERTIFIKAT', $id_sertif_exam)->update($data_sertif_exam);
        $data['sertif_exam'] = (object) $data_sertif_exam;
    }

    private function handleRemedialLogic(&$data)
    {
        $data['remedial'] = $this->finalExamModel->get_remidi_for_exam($data['course']->FINAL_EXAM);

        if ($data['course']->FINAL_EXAM != null) {
            $this->processRemedialLogic($data);
        }
    }

    private function processRemedialLogic(&$data)
    {
        $userId = session('user')[0]->get('ID_USER');
        $activityId = $data['course']->FINAL_EXAM;

        $remedial_user = DB::table('tb_remedial_user')
            ->where('ID_USER', $userId)
            ->where('ID_ACTIVITY', $activityId)
            ->first();

        if (!$remedial_user && $data['remedial'][0]->REMEDIAL > 0) {
            $this->createRemedialUser($userId, $activityId, $data['remedial'][0]->REMEDIAL);
        }

        $this->handleRemedialCodeGeneration($data, $userId, $activityId, $remedial_user);
    }

    private function createRemedialUser($userId, $activityId, $remedialCount)
    {
        $remedialUserId = DB::table('tb_remedial_user')->insertGetId([
            'ID_USER' => $userId,
            'ID_ACTIVITY' => $activityId,
            'REMEDIAL' => $remedialCount,
            'LOG_TIME' => date('Y-m-d H:i:s')
        ]);

        DB::table('user_remedial_log')->insert([
            'ID_REMEDIAL' => $remedialUserId,
            'LOG_REMEDIAL' => $remedialCount,
            'LOG_TIME' => now()
        ]);
    }

    private function handleRemedialCodeGeneration(&$data, $userId, $activityId, $remedial_user)
    {
        $cek_kode_final_exam = DB::table('tb_final_exam')
            ->where('ID_ACTIVITY', $activityId)
            ->where('ID_USER', $userId)
            ->where('IS_USED', 0)
            ->first();

        if ($cek_kode_final_exam) {
            $data['codeFinalExam'] = $cek_kode_final_exam->CODE_EXAM;
            $data['isRemedialCode'] = false;
        } else {
            // Check if remedial is still available
            if ($remedial_user && $remedial_user->REMEDIAL > 0) {
                // Generate new exam code
                $newCode = $this->GenerateCodeExam($activityId . date('Y-m-d H:i:s'));

                DB::table('tb_final_exam')->insert([
                    'ID_ACTIVITY' => $activityId,
                    'ID_USER' => $userId,
                    'CODE_EXAM' => $newCode,
                    'IS_USED' => 0,
                    'CREATED_AT' => date('Y-m-d H:i:s')
                ]);

                // Reduce remedial count
                DB::table('tb_remedial_user')
                    ->where('ID_USER', $userId)
                    ->where('ID_ACTIVITY', $activityId)
                    ->decrement('REMEDIAL');

                // Log it
                DB::table('user_remedial_log')->insert([
                    'ID_REMEDIAL' => $remedial_user->ID_REMEDIAL,
                    'LOG_REMEDIAL' => $remedial_user->REMEDIAL - 1,
                    'LOG_TIME' => now()
                ]);

                $data['codeFinalExam'] = $newCode;
                $data['isRemedialCode'] = true;
            } else {
                $data['codeFinalExam'] = null;
                $data['isRemedialCode'] = false;
            }
        }
    }

    private function loadAdditionalData(&$data)
    {
        $data['nilai'] = DB::selectOne("
            SELECT NILAI
            FROM nilai_quiz
            WHERE ID_USER = '" . session('user')[0]->get('ID_USER') . "'
        ");

        $data['komentar'] = DB::select("
            SELECT tk.komentar, u.NAME, u.FOTO_PROFILE, tk.LOG_TIME
            FROM tb_komentar tk
            LEFT JOIN user u ON u.ID_USER = tk.ID_USER
            WHERE tk.ID_ACTIVITY = '" . $data['id_activity'] . "'
        ");

        $data['checkout'] = $this->checkoutModel->get_all_order(session('user')[0]->get('ID_USER'));
    }

    private function renderCourseView($data)
    {
        $orderData = Checkout::where([
            "ID_PRODUCT" => $data['id_activity'],
            "ID_USER" => session('user')[0]->get('ID_USER')
        ])->orderBy('LOG_TIME', 'DESC')->first();

        $not_yet_pay = DB::select("
            SELECT ID_PAY, DATE_PAY FROM payment WHERE ID_PAY = '".$orderData->ID_PAY."'
        ");
        // dd($orderData->ID_PAY, $not_yet_pay[0]->DATE_PAY);
        if (strtotime($orderData->EXPIRED_DATE) < strtotime(date('Y-m-d H:i:s')) || $not_yet_pay[0]->DATE_PAY == NULL) {
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

    public function buyCertificateCode(Request $request){
        $idActivity = $request->input('id_activity');
        $idPayment = $request->input('id_sertif_pay');
        $userId = session('user')[0]->get('ID_USER');

        $course = $this->courseModel->get_course($request->input('id_activity'));

            if ($course->IS_SERTIF_PAID == 1) {
                // $dataPaySertif = [
                //     'ID_PAYMENT_SERTIF' => $idPayment,
                //     'ID_SERTIFIKAT' => null,
                //     'ID_USER' => $userId,
                //     'ID_PAY' => null,
                //     'IS_PAY' => 0,
                //     'ID_ACTIVITY' => $idActivity,
                //     'TITLE_ACTIVITY' => $course->TITLE_ACTIVITY
                // ];

                // if (!DB::table('payment_sertif')->where('ID_PAYMENT_SERTIF', $idPayment)->exists()) {
                //     DB::table('payment_sertif')->insert($dataPaySertif);
                // }
            }
            return response()->noContent();
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
        $data['cek_course_user'] = DB::select("
            SELECT
                o.ID_USER,
                o.ID_PRODUCT,
                o.ID_PAY,
                p.DATE_PAY
            FROM
                `order` o
            LEFT JOIN payment p ON o.ID_PAY = p.ID_PAY
            WHERE
                o.ID_USER = '".$data_user."'
            AND
                o.ID_PRODUCT = '".$id_activity."'
            AND
                o.ID_PAY IS NOT NULL
            AND
                p.ID_PAY IS NOT NULL
        ");
        // dd($data['cek_course_user'], $data['course']);
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
        $data['prepare_career'] = DB::select("
            SELECT CAREER, POINT, SALARY, JOB_OPENING FROM prepare_career WHERE ID_ACTIVITY = '".$id_activity."'
        ");

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

        $get_final_exam = DB::selectOne("
            SELECT
                INCLUDE_COURSE
            FROM
                activity
            WHERE
                ID_ACTIVITY = '".$id_final_exam->FINAL_EXAM."'
            AND
                TYPE_ACTIVITY = 3
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
			if ($check_history_final_exam == null && $id_final_exam->FINAL_EXAM != null && $get_final_exam->INCLUDE_COURSE == 1) {
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
		$condition = (!empty($_POST['category'])) ? "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.KATEGORI = '" . $_POST['category'] . "' AND course.ID_COURSE NOT LIKE 'FNL_%' AND activity.IS_DELETED IS NULL AND activity.STATUS = 1" : "WHERE activity.TYPE_ACTIVITY = 1 AND activity.IS_PUBLIC = 1 AND course.ID_COURSE NOT LIKE 'FNL_%' AND activity.IS_DELETED IS NULL AND activity.STATUS = 1";
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
					) AS PROGRESS,
                    tbr.RATE,
                    tbr.TOTAL
				FROM
					activity
				LEFT JOIN course ON
					course.ID_ACTIVITY = activity.ID_ACTIVITY
                LEFT JOIN (
                    SELECT
                        r.ID_ACTIVITY,
                        ROUND(AVG(r.RATE), 1) AS RATE,
                        (SELECT COUNT(*) FROM tb_rate_review WHERE ID_ACTIVITY = r.ID_ACTIVITY) AS TOTAL
                    FROM
                        tb_rate_review r
                    GROUP BY
                        r.ID_ACTIVITY
                    ) tbr ON tbr.ID_ACTIVITY = activity.ID_ACTIVITY
				' . $condition . '
				');
		} else {
			$data['course'] = DB::select('
				SELECT
					activity.*,
					course.DESKRIPSI_COURSE,
                    tbr.RATE,
                    tbr.TOTAL
				FROM
					activity
				LEFT JOIN
					course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
                LEFT JOIN (
                    SELECT
                        r.ID_ACTIVITY,
                        ROUND(AVG(r.RATE), 1) AS RATE,
                        (SELECT COUNT(*) FROM tb_rate_review WHERE ID_ACTIVITY = r.ID_ACTIVITY) AS TOTAL
                    FROM
                        tb_rate_review r
                    GROUP BY
                        r.ID_ACTIVITY
                    ) tbr ON tbr.ID_ACTIVITY = activity.ID_ACTIVITY
					' . $condition . '
				');
		}
        // $data['testimoni'] = $this->courseModel->get_testimoni_course();
        // dd($data['course']);

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
		try {
			$data['title'] = 'Final Exam';
			$data['id_activity'] = $request->id;
			$data['code'] = $request->code;
			$data['id_activity_parent'] = $request->activity_asal;
			$data['id_user'] = $request->id_user;
			$id_activity_parent = $request->activity_asal;

			$is_code_verif = $this->isCodeVerif($data['code']);
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
		} catch (\Throwable $e) {
			return redirect('course/detail/courses?id_activity=' . $id_activity_parent)->with('err_msg', $e->getMessage());
		}
	}

	public function FinalExamEvaliation(Request $request)
	{
		$id_quiz = $_POST['id_quiz'];
		$id_detail = $_POST['id_detail'];
		$pilih_jwbn = $_POST['pilih_jwbn'];
		$id_user = $request->id_user;
		$code_exam = $request->code_exam;
		$min_nilai = $request->min_nilai;
		$id_activity_parent = $request->activity_asal;

		$is_code_verif = $this->isCodeVerif($code_exam);
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

        $data_jawaban = [
            'ID_ACTIVITY'   => $_POST['id_activity'],
            'ID_USER'       => $id_user,
            'ID_QUIZ'       => $id_quiz,
            'ID_DETAIL'     => implode(';', $id_detail),
            'JAWABAN'       => implode(';', $pilih_jwbn)
        ];

		$data_nilai = [
			"ID_ACTIVITY" 	=> $_POST['id_activity'],
			"ID_QUIZ" 		=> $id_quiz,
			"ID_USER" 		=> $id_user,
			"CODE_EXAM" 	=> $_POST['code_exam'],
			"NILAI" 		=> $nilai,
			"created_at" 	=> date('Y-m-d H:i:s'),
		];

		DB::table('tb_final_exam')->where('CODE_EXAM', $_POST['code_exam'])->update(['IS_USED' => 1]);
		DB::table('tb_nilai_final_exam')->insert($data_nilai);
        DB::table('tb_jawaban')->insert($data_jawaban);

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
    public function addRateTestimoni(Request $request){
        $data = [
            'ID_ACTIVITY'   => $request->input('id_activity'),
            'ID_USER'       => $request->input('id_user'),
            'RATE'          => $request->input('rating'),
            'REVIEW'        => $request->input('review'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];
        DB::table('tb_rate_review')->insert($data);
		return redirect()->back();
    }

    function payment_jmkp($id){
        // $data['course'] = $this->courseModel->get_course($id);
        $data['course'] = DB::select("
            SELECT
                activity.ID_ACTIVITY,
                activity.TITLE_ACTIVITY,
                course.ID_COURSE,
                course.ID_ACTIVITY,
                course.FINAL_JMKP,
                course.PRICE_JMKP
            FROM
                activity
            LEFT JOIN
                course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
            WHERE
                course.ID_COURSE = '". $id ."'
        ")[0] ?? null;
        $payment = DB::table('payment_final_jmkp')
            ->where('ID_USER', session('user')[0]['ID_USER'])
            ->where('ID_COURSE', $id)
            ->where('type', 'jmkp')
            ->orderBy('created_at', 'desc')
            ->first();

        $data['payment'] = $payment;
        // dd($data['course'], $id);
        return view('template_guest.course.ajax.payment_jmkp', $data);
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
    public function GenerateUniqIDPay($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "PAY_SERTIF_" . $uniqid . substr(md5(microtime()), 0, 7);
    }
}
