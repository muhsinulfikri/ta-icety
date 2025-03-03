<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;

    // Definisikan kolom-kolom yang dapat diisi secara massal
    protected $fillable = ['EMAIL', 'TELP','NAME','JK'];    
    protected $table = 'user';
    protected $primaryKey = 'ID_USER';    
    public $timestamps = false;
    public function get_user($id_user)
    {
        $sql = DB::select("
            SELECT 
                *
            FROM 
                user
            WHERE 
                ID_USER = '$id_user'
        ");
        return $sql;
    }
    public function get_my_product(){
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $sql = DB::select('
        SELECT 
            activity.*, 
            kategori.KATEGORI, 
            course.DESKRIPSI_COURSE, 
            (
                SELECT
                    CASE
                        WHEN MAX(tnfe.NILAI) > ic.MIN_NILAI THEN "Lulus"
                        WHEN MAX(tnfe.NILAI) < ic.MIN_NILAI THEN "Belum Lulus"
                        ELSE ""
                    END AS STATUS_FINAL_EXAM
                FROM 
                    tb_nilai_final_exam tnfe
                LEFT JOIN activity a2 ON 
                    course.FINAL_EXAM = a2.ID_ACTIVITY
                LEFT JOIN course c2 ON
                    c2.ID_ACTIVITY = a2.ID_ACTIVITY
                LEFT JOIN item_course ic ON 
                    ic.ID_COURSE = c2.ID_COURSE
                WHERE 
                    tnfe.ID_ACTIVITY = course.FINAL_EXAM
                    AND tnfe.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                    AND ic.ID_COURSE = c2.ID_COURSE
            )AS STATUS_FINAL_EXAM,
            (
                SELECT 
                    COUNT(*) 
                FROM 
                    payment p 
                    LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY 
                WHERE 
                    o.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                    AND o.ID_PRODUCT = `activity`.ID_ACTIVITY 
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
                                o.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                                AND o.ID_PRODUCT = activity.ID_ACTIVITY
                    ) / 
                    (
                            SELECT
                            COUNT(*)
                        FROM
                            mapping_course
                        WHERE
                            mapping_course.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                            AND mapping_course.ID_ACTIVITY = activity.ID_ACTIVITY
                    ) * 100
                )
            ) AS PROGRESS
        FROM 
            activity
            LEFT JOIN course ON course.ID_ACTIVITY = activity.ID_ACTIVITY 
            LEFT JOIN kategori ON kategori.ID_KATEGORI = course.KATEGORI 
        WHERE 
            activity.TYPE_ACTIVITY = 1
        ');
        return $sql;
    }
    public function get_my_product2(){
        $sql = DB::select("
        SELECT `activity`.*, `kategori`.`KATEGORI`, `course`.`DESKRIPSI_COURSE`, ( SELECT COUNT(*) 
        FROM payment p LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY 
        WHERE o.ID_USER = '" . session('user')[0]['ID_USER'] . "' AND o.ID_PRODUCT = `activity`.ID_ACTIVITY AND p.DATE_PAY IS NOT NULL ) as DATA_CHECKING, ( CEIL(( SELECT COUNT(*) 
        FROM `mapping_course` WHERE `mapping_course`.ID_USER = '" . session('user')[0]['ID_USER'] . "' AND `mapping_course`.ID_ACTIVITY = `activity`.ID_ACTIVITY AND `mapping_course`.STATUS = 1) / ( SELECT COUNT(*) FROM `mapping_course` WHERE `mapping_course`.ID_USER = '" . session('user')[0]['ID_USER'] . "' AND `mapping_course`.ID_ACTIVITY = `activity`.ID_ACTIVITY ) * 100)) as PROGRESS FROM `activity` LEFT JOIN `course` ON `course`.`ID_ACTIVITY` = `activity`.`ID_ACTIVITY` LEFT JOIN `kategori` ON `kategori`.`ID_KATEGORI` = `course`.`KATEGORI` WHERE `activity`.`TYPE_ACTIVITY` = 2
        ");
        return $sql;
    }
    
    public function get_my_ebook(){
        $sql = DB::select('
        SELECT 
            `ebook`.*,
            (
                SELECT 
                    COUNT(*) 
                FROM 
                    payment p 
                    LEFT JOIN `order` o ON o.ID_PAY = p.ID_PAY 
                WHERE 
                    o.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                    AND o.ID_PRODUCT = `ebook`.ID_BUKU
                    AND p.DATE_PAY IS NOT NULL
            ) AS DATA_CHECKING
        FROM 
            `ebook`
        ');
        return $sql;
    }
    // public static function update_profile($data1, $data2,$data3,$data4)
    public static function update_profile(array $data)
    {
        // Temukan pengguna berdasarkan ID
        $user = self::find(session('user')[0]['ID_USER']);
        // dd($data[0]['EMAIL']);
        if ($user) {
            // Perbarui kolom yang diinginkan
            if (!empty($data[0]['FOTO_PROFILE'])) {
                $user->FOTO_PROFILE = $data[0]['FOTO_PROFILE'];
            }
            $user->EMAIL = $data[0]['EMAIL'];
            $user->NAME = $data[0]['NAME'];
            $user->TELP = $data[0]['TELP'];
            $user->JK = $data[0]['JK'];
            return $user->save(); // Simpan perubahan ke database
        }

        return false; // Pengguna tidak ditemukan
    }
    public static function updateTableById(array $data)
    {
        // Temukan pengguna berdasarkan ID
        
        return DB::table('user_data')->where('ID_USER', session('user')[0]['ID_USER'])->update($data);
    }
    
}
