<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FinalExam extends Model
{
    protected $table = 'tb_final_exam';
    protected $primaryKey = 'ID_FINAL_EXAM';
    public $incrementing = false;
    public $timestamps = false;

    public function get_final_exam($id_activity)
    {
        $sql = DB::selectOne('
        SELECT
            activity.*,
            course.ID_COURSE,
            course.ALIAS
        FROM
            activity
        LEFT JOIN
            course ON course.ID_ACTIVITY = activity.ID_ACTIVITY
        WHERE
            course.ID_ACTIVITY = "' . $id_activity . '"
            AND activity.TYPE_ACTIVITY = 3
        ');
        return $sql;
    }
    public function get_nilai_for_sertif($id_activity, $id_user){
        $sql = DB::selectOne('
            SELECT
           	tnfe.NILAI
        FROM
            tb_final_exam tfe
        LEFT JOIN
            activity a ON a.ID_ACTIVITY = tfe.ID_ACTIVITY
        LEFT JOIN
        	tb_nilai_final_exam tnfe ON tnfe.ID_ACTIVITY = tfe.ID_ACTIVITY
        WHERE
            a.ID_ACTIVITY = "'.$id_activity.'"
        AND
        	a.TYPE_ACTIVITY = 3
       	AND
       		tfe.ID_USER = "'.$id_user.'"
        ');
        return $sql;
    }
    public function get_remidi_for_exam($id_activity){
        $sql = DB::select('
            SELECT
                REMEDIAL
            FROM
                activity
            WHERE
                ID_ACTIVITY = "'.$id_activity.'"
        ');
        return $sql;
    }
}
