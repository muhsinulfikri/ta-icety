<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    function __construct()
    {
        parent::__construct();
        DB::statement("SET foreign_key_checks = 0;");
    }

    // QUERY GET DATA
    public function get_home_course_all()
    {
        $data = DB::select("
            SELECT
                activity.*,
                course.DESKRIPSI_COURSE,
                kategori.KATEGORI
            FROM
                activity
                LEFT JOIN course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
                LEFT JOIN kategori ON kategori.ID_KATEGORI = course.KATEGORI
            WHERE
                activity.TYPE_ACTIVITY = 1
                AND activity.IS_PUBLIC = 1
                AND course.ID_COURSE NOT LIKE 'FNL_%'
                AND activity.IS_DELETED IS NULL
            ORDER BY
                activity.LOG_TIME DESC
                LIMIT 4");
        return $data;
    }
    public function get_courses($condition)
    {
        $data = DB::select("
            SELECT
                activity.*,
                course.DESKRIPSI_COURSE,
                kategori.KATEGORI
            FROM
                activity
                LEFT JOIN course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
                LEFT JOIN kategori ON kategori.ID_KATEGORI = course.KATEGORI
            WHERE
                activity.TYPE_ACTIVITY = 1 AND
                " . implode(' AND ', $condition) . "
            ORDER BY
                activity.LOG_TIME DESC
                LIMIT 4");
        return $data;
    }
    public function get_home_course($id_category)
    {
        $data = DB::select("
            SELECT
                activity.*, course.DESKRIPSI_COURSE
            FROM
                activity
            LEFT JOIN course ON
                course.ID_ACTIVITY = activity.ID_ACTIVITY
            WHERE
                " . implode(' AND ', $id_category) . "
            ORDER BY activity.LOG_TIME DESC
            LIMIT 4");
        return $data;
    }
    public function get_all_course()
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->result_array();
    }
    public function get_all_course_in($id)
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 1, 'ID_USER' => $id])->result_array();
    }
    public function get_course_pagination($start = "", $limit = "", $condition)
    {
        $id_user = session()->get('ID_USER');
        if (!empty($id_user)) {
            $data = DB::select('
            SELECT
            activity.*,
            course.DESKRIPSI_COURSE,
            (
                SELECT COUNT(*)
                FROM payment p
                LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY
                WHERE o.ID_USER = "' . $id_user . '"
                    AND o.ID_PRODUCT = activity.ID_ACTIVITY
                    AND p.DATE_PAY IS NOT NULL
            ) as DATA_CHECKING,
            (
                CEIL((
                    SELECT COUNT(*)
                    FROM `mapping_course`
                    WHERE `mapping_course`.ID_USER = "' . $id_user . '"
                        AND `mapping_course`.ID_ACTIVITY = activity.ID_ACTIVITY
                ) / (
                    SELECT COUNT(*)
                    FROM `mapping_course`
                    WHERE `mapping_course`.ID_USER = "' . $id_user . '"
                        AND `mapping_course`.ID_ACTIVITY = activity.ID_ACTIVITY
                ) * 100)
            ) as PROGRESS
        FROM
            activity
        LEFT JOIN
            course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
            ');

            return $data;
        } else {
            $data = DB::select('
            SELECT
                activity.*,
                course.DESKRIPSI_COURSE
            FROM
                activity
            LEFT JOIN
                course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
            WHERE
                <your_condition>
            LIMIT
                $start, $limit;
            ');
            return $data;
        }
    }
    public function get_course($id_activity)
    {
        $sql = DB::selectOne('
        SELECT
        activity.*,
        course.ID_COURSE,
        course.REQUIREMENT,
        (
            SELECT
                a.TITLE_ACTIVITY
            FROM
                course c
            LEFT JOIN activity a ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                c.ID_ACTIVITY = course.REQUIREMENT
        ) AS REQ_NAME,
        (
            SELECT
                count(a.TITLE_ACTIVITY)
            FROM
                `order` o
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = o.ID_PRODUCT
            AND
                o.ID_PRODUCT = course.REQUIREMENT
            AND
                o.COURSE_COMPLETED = 1
        ) AS REQ,
        course.PENGUMUMAN,
        course.ALIAS,
        course.DESKRIPSI_COURSE,
        course.DESKRIPSI_COURSE_ITEM,
        course.SUMMARY,
        course.DURATION,
        course.HOURS,
        course.FINAL_EXAM,
        user.NAME,
        user.FOTO_PROFILE,
        kategori.KATEGORI,
        (
            SELECT COUNT(p.ID_PAY)
            FROM payment p
            LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY
            AND
            o.ID_PRODUCT = `activity`.ID_ACTIVITY
            AND
            p.DATE_PAY IS NOT NULL ) as DATA_CHECKING
        FROM
            activity
        LEFT JOIN
            course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
        LEFT JOIN
            kategori ON kategori.ID_KATEGORI = course.KATEGORI
        LEFT JOIN
            user ON user.ID_USER = activity.ID_USER
        WHERE
            course.ID_ACTIVITY = "' . $id_activity . '"
            AND activity.TYPE_ACTIVITY = 1;
        ');
        return $sql;
    }
    public function get_title_materi($id_course){
        $data = DB::select("
            SELECT
                TITLE
            FROM
                item_course
            WHERE
                ID_COURSE = '".$id_course."'
            AND
                TYPE = 1
            LIMIT 5
        ");
        return $data;
    }
    public function get_completed_course($id_user, $id_activity){
        $data = DB::select('
            SELECT
                o.ID_ORDER ,
                u.ID_USER ,
                a.ID_ACTIVITY ,
                o.LOG_TIME ,
                o.DATE_COMPLETED ,
                DATEDIFF(o.DATE_COMPLETED , o.LOG_TIME ) AS days_difference
            FROM `order` o
            JOIN `user` u ON o.ID_USER  = u.ID_USER
            JOIN `activity` a ON o.ID_PRODUCT  = a.ID_ACTIVITY
            WHERE
                o.ID_USER = "'. $id_user .'"
            AND
                o.ID_PRODUCT = "'. $id_activity .'"
            AND
                o.DATE_COMPLETED  IS NOT NULL
        ');
        return $data;
    }
    public function get_course_by_id($keyword, $type)
    {
        $query = DB::table('activity AS act')
            ->select('act.*')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('order AS o')
                    ->leftJoin('transaction AS t', 't.ID_USER', '=', 'o.ID_USER')
                    ->where('o.ID_USER', session()->get('ID_USER'))
                    ->whereColumn('o.ID_PRODUCT', 'act.ID_ACTIVITY')
                    ->where('t.STAT_BAYAR', 3);
            }, 'DATA_CHECKING')
            ->where('act.TYPE_ACTIVITY', $type);

        if (!empty($keyword)) {
            $query->where('act.TITLE_ACTIVITY', 'LIKE', "%$keyword%");
        }
        return $query->get();
    }
    public function get_item_course($condition)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data = DB::select('
        SELECT
            item_course.*,
            detail_quiz.SOAL,
            detail_quiz.PIL_JWB,
            detail_quiz.KUNCI,
            detail_quiz.ORDER_LIST as SOAL_ORDER,
            mapping_course.STATUS
        FROM
            item_course
        LEFT JOIN
            detail_quiz ON detail_quiz.ID_QUIZ = item_course.ID_ITEM
        LEFT JOIN
            mapping_course ON mapping_course.ID_ITEM = item_course.ID_ITEM
        WHERE
            ' . $condition . '
        GROUP BY
            item_course.ID_ITEM
        ORDER BY
            item_course.ORDER_LIST ASC
        ');
        return $data;
    }
    public function get_detail_item_course($condition, $type)
    {
        if ($type == 1) {
            $this->db->where($condition);
            return $this->db->get('item_course')->row_array();
        } else {
            $this->db->join('detail_quiz', 'detail_quiz.ID_QUIZ = item_course.ID_ITEM', 'left');
            $this->db->where($condition);
            return $this->db->get('item_course')->result_array();
        }
    }
    public function get_quiz_grade($id_quiz)
    {
        $id_user = session('user')[0]->get('ID_USER');

        $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
        $this->db->where('nilai_quiz.ID_USER', $id_user);
        return $this->db->get('nilai_quiz')->row_array();
    }
    public function get_correct_answer_item_course($id_detail, $pilih_jwbn)
    {
        $this->db->select('detail_quiz.ID_DETAIL');
        $this->db->where('detail_quiz.ID_DETAIL', $id_detail);
        $this->db->where('detail_quiz.KUNCI', $pilih_jwbn);
        return $this->db->count_all_results('detail_quiz');
    }
    public function get_last_item_course($id_activity)
    {
        $this->db->order_by('ID_ITEM', 'desc');
        return $this->db->get_where('mapping_course', ['ID_USER' => session('user')[0]->get('ID_USER'), 'ID_ACTIVITY' => $id_activity, 'STATUS' => 1])->result_array();
    }
    public function save_quiz_grade($id_quiz, $nilai)
    {
        $id_user = session('user')[0]->get('ID_USER');

        $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
        $this->db->where('nilai_quiz.ID_USER', $id_user);
        $total_data = $this->db->count_all_results('nilai_quiz');

        if ($total_data > 0) {
            $data_quiz = array(
                "ID_QUIZ" => $id_quiz,
                "ID_USER" => $id_user,
                "NILAI" => $nilai
            );
            $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
            $this->db->where('nilai_quiz.ID_USER', $id_user);
            $this->db->update('nilai_quiz', $data_quiz);
        } else {
            $data_quiz = array(
                "ID_QUIZ" => $id_quiz,
                "ID_USER" => $id_user,
                "NILAI" => $nilai
            );
            return $this->db->insert('nilai_quiz', $data_quiz);
        }
    }
    public function get_all_materi($id_course)
    {
        return $this->db->get_where('item_course', ['ID_COURSE' => $id_course])->result_array();
    }
    public function get_all_question($id_quiz)
    {
        return $this->db->get_where('detail_quiz', ['ID_QUIZ' => $id_quiz])->result_array();
    }
    public function get_all_mapping($condtion)
    {
        return $this->db->get_where('mapping_course', $condtion)->result_array();
    }
    public function get_all_quiz($id_course)
    {
        return $this->db->get_where('quiz', ['ID_COURSE' => $id_course])->result_array();
    }
    public function get_all_quizDetail($id_materi)
    {
        return $this->db->get_where('detail_quiz', ['ID_COURSE' => $id_materi])->result_array();
    }

    // QUERY INSERT DATA
    public function InsertActivity($data)
    {
        $this->db->insert('activity', $data);
        return $this->db->affected_rows();
    }
    public function InsertCourse($data)
    {
        $this->db->insert('course', $data);
        return $this->db->affected_rows();
    }
    public function InsertItem($data)
    {
        $this->db->insert('item_course', $data);
        return $this->db->insert_id();
    }
    public function InsertQuiz($data)
    {
        $this->db->insert('quiz', $data);
        return $this->db->affected_rows();
    }
    public function InsertDetailQuiz($data)
    {
        $this->db->insert('detail_quiz', $data);
        return $this->db->affected_rows();
    }
    public function InsertQuizDetail($data)
    {
        $this->db->insert('detail_quiz', $data);
        return $this->db->affected_rows();
    }


    // QUERY UPDATE DATA
    public function updateMappingIndex($id_course, $id_activity)
    {

        $dataOldMapping = DB::select("
			SELECT
				*
			FROM
				mapping_course
			WHERE
				ID_USER = '" . session('user')[0]->get('ID_USER') . "'
				AND
				ID_ACTIVITY = '" . $id_activity . "'
            ORDER BY 
                ID_ITEM ASC
		");

        $dataNewMapping = DB::select('
			SELECT
				ic.ID_ITEM
			FROM
				course c
			LEFT JOIN item_course ic ON
				ic.ID_COURSE = c.ID_COURSE
			WHERE
				c.ID_ACTIVITY = "' . $id_activity . '"
            ORDER BY
                ic.ID_ITEM ASC
		');

        if ($dataOldMapping != null) {
            if ($dataNewMapping[0]->ID_ITEM != $dataOldMapping[0]->ID_ITEM) {
                $oldIDMapping = [];
                foreach ($dataNewMapping as $key => $newItem) {
                    if (!empty($dataOldMapping[$key])) {
                        $oldIDMapping[] = $dataOldMapping[$key]->ID_MAPPING;
                        $oldData = $dataOldMapping[$key];
                        $newDataMapping = [
                            'ID_USER' => session('user')[0]->get('ID_USER'),
                            'ID_ACTIVITY' => $oldData->ID_ACTIVITY,
                            'STATUS' => $oldData->STATUS,
                            'ID_ITEM' => $newItem->ID_ITEM
                        ];
                    } else {
                        $newDataMapping = [
                            'ID_USER' => session('user')[0]->get('ID_USER'),
                            'ID_ACTIVITY' => $oldData->ID_ACTIVITY,
                            'STATUS' => 0,
                            'ID_ITEM' => $newItem->ID_ITEM
                        ];
                    }
                    DB::table('mapping_course')->insert($newDataMapping);
                }

                DB::table('mapping_course')->whereIn('ID_MAPPING', $oldIDMapping)->delete();
            }
        }

        // $mapping = $this->db->get_where('mapping_course', ['ID_USER' => session('user')[0]->get('ID_USER'), 'ID_ACTIVITY' => $id_activity])->result_array();
        $mapping = DB::select('
            SELECT
                *
            FROM
                mapping_course
            WHERE
                ID_USER = "' . session('user')[0]->get('ID_USER') . '"
                AND ID_ACTIVITY = "' . $id_activity . '"
            ORDER BY ID_ITEM ASC
        ');

        // $new_item = $this->db->get_where('item_course', ['ID_COURSE' => $id_course])->result_array();
        $new_item = DB::select('
            SELECT
                *
            FROM
                item_course
            WHERE
                ID_COURSE = "' . $id_course . '"
            ORDER BY
                ORDER_LIST ASC
        ');

        if (count($mapping) < count($new_item)) {
            for ($i = 0; $i < count($new_item); $i++) {
                if (!empty($mapping[$i]->ID_ITEM)) {
                    DB::table('mapping_course')
                        ->where('ID_MAPPING', $mapping[$i]->ID_MAPPING)
                        ->update(['ID_ITEM' => $new_item[$i]->ID_ITEM]);
                } else {
                    if ($i == 0) {
                        $data_mapping = array(
                            "ID_USER" => session('user')[0]->get('ID_USER'),
                            "ID_ACTIVITY" => $id_activity,
                            "ID_ITEM" => $new_item[$i]->ID_ITEM,
                            "STATUS" => 1
                        );
                    } else {
                        $data_mapping = array(
                            "ID_USER" => session('user')[0]->get('ID_USER'),
                            "ID_ACTIVITY" => $id_activity,
                            "ID_ITEM" => $new_item[$i]->ID_ITEM,
                            "STATUS" => 0
                        );
                    }
                    DB::table('mapping_course')->insert($data_mapping);
                }
            }
        } else {
            for ($i = 0; $i < count($mapping); $i++) {
                if (empty($new_item[$i]->ID_ITEM)) {
                    DB::table('mapping_course')->where('ID_MAPPING', $mapping[$i]->ID_MAPPING)->delete();
                } else {
                    DB::table('mapping_course')->where('ID_MAPPING', $mapping[$i]->ID_ITEM)->update(['ID_ITEM' => $new_item[$i]->ID_ITEM]);
                }
            }
        }
    }
    // public function UpdateActivity($data, $id_activity)
    // {
    //     $this->db->where('ID_ACTIVITY', $id_activity);
    //     $this->db->update('activity', $data);
    //     return $this->db->query("SET foreign_key_checks = 1;");
    // }
    // public function UpdateCourse($data, $id_activity)
    // {
    //     $this->db->where('ID_ACTIVITY', $id_activity);
    //     $this->db->update('course', $data);
    //     return $this->db->query("SET foreign_key_checks = 1;");
    // }
    // public function UpdateMapping($data, $condtion)
    // {
    //     $this->db->where($condtion);
    //     $this->db->update('mapping_course', $data);
    // }

    // QUERY DELETE DATA
    public function DeleteItem($id_course)
    {
        $this->db->where('item_course.ID_COURSE', $id_course);
        $this->db->delete('item_course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteActivity($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('activity');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteEvent($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteQuiz($id_course)
    {
        $this->db->where('quiz.ID_COURSE', $id_course);
        $this->db->delete('quiz');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteMateri($id_course)
    {
        $this->db->where('course.ID_COURSE', $id_course);
        $this->db->delete('course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteDetailQuiz($id_course)
    {
        $this->db->where('detail_quiz.ID_COURSE', $id_course);
        $this->db->delete('detail_quiz');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteQuizPenilaian($condtion)
    {
        $this->db->where($condtion);
        $this->db->delete('nilai_quiz');
    }
    public function get_counttask($condition)
    {
        $data = DB::select("
            SELECT
                o.MAPPING_COUNT ,
                o.COURSE_COMPLETED
            FROM
                `order` o
            WHERE
                o.ID_PRODUCT = '$condition'
                AND
                o.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
        ");
        return $data;
    }
}
