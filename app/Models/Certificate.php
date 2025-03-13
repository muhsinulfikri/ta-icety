<?php
namespace App\Models;

use Exception;
use App\Models\FileUpload;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function getCertificate($con)
    {
        $query = DB::table('sertifikat_activity');

        foreach ($con as $column => $value) {
            $query->where($column, $value);
        }

        $results = $query->get();
        return $results;
    }
    public function createCertificate($data)
    {
        $this->db->insert('sertifikat_activity', $data);
        return $this->db->affected_rows();
    }

    public function generate($namaUser, $activity_name, $sertificate_no, $template_link, $summary, $info_sertif, $duration, $date, $id_sertif)
    {
        set_time_limit(120);
        try {
            $encryptedId = Crypt::encryptString($id_sertif);
            $file_pdf = strtoupper($namaUser . "_CERTIFICATE_" . $activity_name) . ".pdf";
            $paper = 'A4';
            $orientation = 'landscape';

            $path = 'assets/images/certificate_template.jpg';
            if ($template_link != null) {
                $path = $template_link;
            }

            $type = pathinfo($path, PATHINFO_EXTENSION);
            $getImage = file_get_contents($path);
            $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);
            $data['NO_SERTIF'] = $sertificate_no;
            $data['NAME'] = $namaUser;
            $data['ACTIVITY'] = $activity_name;
            $data['TYPE'] = explode("/", $sertificate_no)[1];
            $data['SUMMARY'] = $summary;
            $data['INFO_SERTIF'] = $info_sertif;
            $data['DURATION'] = $duration;
            // $data['TOTAL_MATERI'] = $total_materi;
            $data['DATE'] = $date;
            $data['QR'] = base64_encode(QrCode::format("svg")->size(516)->generate(URL::to('/').'/verifikasi/'.$encryptedId));

            $html = view('pdf_template.sertifikat_new', $data)->render();
            $resPdf = PDFGenerator::generate($html, $file_pdf, $paper, $orientation);
            $new_path = FileUpload::UploadFileBlob($file_pdf, $resPdf, 'certificate');

            return $new_path;
        } catch (Exception $e){
            dd($e->getMessage());
        }
    }

    public function generateSertifExam($namaUser, $activity_name, $sertificate_no, $template_link, $summary, $info_sertif, $duration, $date, $id_sertif)
    {
        set_time_limit(120);
        try {
            $encryptedId = Crypt::encryptString($id_sertif);
            $file_pdf = strtoupper($namaUser . "_CERTIFICATE_" . $activity_name) . ".pdf";
            $paper = 'A4';
            $orientation = 'landscape';

            $path = 'assets/images/certificate_template.jpg';
            if ($template_link != null) {
                $path = $template_link;
            }

            $type = pathinfo($path, PATHINFO_EXTENSION);
            $getImage = file_get_contents($path);
            $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);
            $data['NO_SERTIF'] = $sertificate_no;
            $data['NAME'] = $namaUser;
            $data['ACTIVITY'] = $activity_name;
            $data['TYPE'] = explode("/", $sertificate_no)[1];
            $data['SUMMARY'] = $summary;
            $data['INFO_SERTIF'] = $info_sertif;
            $data['DURATION'] = $duration;
            $data['DATE'] = $date;
            $data['QR'] = base64_encode(QrCode::format("svg")->size(516)->generate(URL::to('/').'/verifikasi/'.$encryptedId));

            $html = view('pdf_template.sertifikat_new', $data)->render();
            $resPdf = PDFGenerator::generate($html, $file_pdf, $paper, $orientation);
            $new_path = FileUpload::UploadFileBlob($file_pdf, $resPdf, 'certificate');

            return $new_path;
        } catch (Exception $e){
            dd($e);
        }
    }
}
