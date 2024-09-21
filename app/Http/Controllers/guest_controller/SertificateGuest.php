<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Aws\S3\S3Client;

class SertificateGuest extends Middleware
{
	public $session_data;
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Checkout']);
        $this->load->library('pdfgenerator');
        $this->load->library('S3Upload', NULL, 'S3');
		// error_reporting(0);
	}

    public function generate($namaUser, $activity_name, $sertificate_no)
    {
        $file_pdf = $namaUser . "_SERTIFIKAT.pdf";

        $paper = 'A4';
        $orientation = 'landscape';

        $path = base_url('assets/images/certificate_template.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $getImage = file_get_contents($path);
        $data['IMAGE'] = 'data:image/' . $type . ';base64,' . base64_encode($getImage); 

        $data['NO_SERTIF'] = $namaUser;
        $data['NAME'] = $namaUser;
        $data['ACTIVITY'] = $namaUser;

        $html = $this->load->view("pdf_template/sertifikat", $data, true);

        $resPdf = $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

        $new_path = $this->S3->UploadFileBlob($file_pdf, $resPdf, 'certificate');

        echo $new_path;
    }
}