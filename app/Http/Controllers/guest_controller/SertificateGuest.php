<?php
namespace App\Http\Controllers\guest_controller;
use App\Http\Controllers\Controller;
use App\Models\PDFGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Crypt;

class SertificateGuest extends Controller
{
    public function generate()
    {
        $data['QR'] = base64_encode(QrCode::format("svg")->size(516)->generate(URL::to('/').'/verifikasi/sertifikat?ID_SERTIFIKAT=100'));

        $file_pdf = strtoupper("Tamarin Hamaji" . "_CERTIFICATE_" . "Fotografi Dalam 5 Menit") . ".pdf";
        $paper = 'A4';
        $orientation = 'landscape';

        $path = 'assets/images/certificate_template.jpg';

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $getImage = file_get_contents($path);
        $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage);

        // Set certificate details
        $data['NAME'] = "Tamarin Hamaji";
        $data['ROLES'] = "PESERTA"; //PESERTA
        $data['JUDUL'] = "Fotografi Dalam 5 Menit"; //Fotografi Dalam 5 Menit
        $data['TGL_ACARA'] = "25 Oktober 2024"; //25 Oktober 2024
        $data['TGL_TTD'] = "25 OKTOBER 2024"; //MALANG, 25 OKTOBER 2024

        // Render the HTML template for the certificate
        $html = view('pdf_template.sertifikat', $data)->render();

        // Generate the PDF
        $resPdf = PDFGenerator::generate($html, $file_pdf, $paper, $orientation);
        $new_path = FileUpload::UploadFileBlob($file_pdf, $resPdf, 'certificate');
        return $new_path;
        // Stream the PDF inline in the browser
        // return Response::stream(
        //     function () use ($resPdf) {
        //         echo $resPdf;
        //     },
        //     200,
        //     [
        //         'Content-Type' => 'application/pdf',
        //         'Content-Disposition' => 'inline; filename="' . $file_pdf . '"'
        //     ]
        // );
    }

    public function verifSertif(Request $request) {
        $data['title'] = 'Verifikasi Sertifikat';
        $data['id'] = Crypt::decryptString($request->id);
        $data['all_sertif'] = DB::select("
            SELECT
                a.TITLE_ACTIVITY
            FROM
                `sertifikat_activity` sa
            LEFT JOIN
                activity a
            ON
                sa.ID_ACTIVITY = a.ID_ACTIVITY
            LEFT JOIN
                user u
            ON
                sa.ID_USER = u.ID_USER
            WHERE
                sa.ID_USER = '".$request->id."'
            ORDER BY
                sa.DATE_COMPLETED DESC
            LIMIT 5
        ");

        $data['sertifikat'] = DB::selectOne("
            SELECT
                sa.ID_SERTIFIKAT,
                sa.FILE_SERTIFIKAT,
                sa.DATE_COMPLETED,
                u.NAME,
                a.TITLE_ACTIVITY
            FROM
                sertifikat_activity sa
            LEFT JOIN user u ON
                sa.ID_USER = u.ID_USER
            LEFT JOIN activity a ON
                sa.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                ID_SERTIFIKAT = '".$data['id']."'
            ");

        if ($data['sertifikat'] == null) {
            return redirect('/')->with('error', 'Sertifikat tidak ditemukan');
        }

        return
        view('template.header', $data) .
        view('template_guest.validasi_sertifikat', $data) .
        view('template.footer', $data);
    }

}
