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
}
