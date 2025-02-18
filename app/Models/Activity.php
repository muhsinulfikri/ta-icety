<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'ID_ACTIVITY';
    public $timestamps = false;

    public function get_summary_sert_activity($id){
        $data = DB::select("
            SELECT
                SUMMARY_CERTIFICATE
            FROM
                activity
            WHERE
                ID_ACTIVITY = '". $id ."'
            ");
        return $data;
    }
}
