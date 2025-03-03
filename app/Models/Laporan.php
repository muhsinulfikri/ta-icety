<?php

namespace App\Models;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    public function styling_title_template($ColorFill, $ColorText)
    {
        $styleTitle['font']['bold']                         = true;
        $styleTitle['font']['size']                         = 11;
        $styleTitle['font']['color']['argb']                = $ColorText;
        $styleTitle['fill']['fillType']                     = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
        $styleTitle['fill']['color']['argb']                = $ColorFill;
        $styleTitle['alignment']['horizontal']              = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;
        $styleTitle['alignment']['vertical']                = \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER;

        return $styleTitle;
    }

    public function styling_content_template($ColorFill, $ColorText, $a_vertical, $a_horizontal)
    {
        $align_vertical = ($a_vertical == 'center') ?
            \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER : (
                ($a_vertical == 'bottom') ?
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM :
                \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
            );

        $align_horizontal = ($a_horizontal == 'center') ?
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER : (
                ($a_horizontal == 'left') ?
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT :
                \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            );

        $styleContent['font']['size'] = 10;
        $styleContent['font']['color']['argb'] = $ColorText;
        $styleContent['fill']['fillType'] = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
        $styleContent['fill']['color']['argb'] = $ColorFill;
        $styleContent['borders']['outline']['borderStyle'] = \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;
        $styleContent['alignment']['horizontal'] = $align_horizontal;
        $styleContent['alignment']['vertical'] = $align_vertical;

        return $styleContent;
    }
    
    public function laporan_event($data) {

        $date    = date('j F Y');

        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("REPORTING USER");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setAutoSize(true);
        $ObjSheet->getColumnDimension('D')->setAutoSize(true);
        $ObjSheet->getColumnDimension('E')->setAutoSize(true);
        $ObjSheet->getColumnDimension('F')->setAutoSize(true);
        $ObjSheet->getColumnDimension('G')->setAutoSize(true);
        $ObjSheet->getColumnDimension('H')->setAutoSize(true);

        $ObjSheet->mergeCells('B2:H2')->setCellValue('B2', "DATA PESERTA WEBINAR")->getStyle('B2:H2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);
        $ObjSheet->mergeCells('B3:H3')->setCellValue('B3', $data[0]->TITLE_ACTIVITY)->getStyle('B3:H3')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'));

        $ObjSheet->setCellValue('B7', 'No')->getStyle('B7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C7', 'Nama Peserta')->getStyle('C7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D7', 'Email')->getStyle('D7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E7', 'Nomor Telp')->getStyle('E7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F7', 'Jenis Kelamin')->getStyle('F7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G7', 'Alamat')->getStyle('G7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H7', 'Tanggal Ambil')->getStyle('H7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 8;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NAME)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->EMAIL)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, $item->TELP)->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, $item->JK)->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, $item->ALAMAT)->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, $item->LOG_TIME)->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta Webinar '.$data[0]->TITLE_ACTIVITY;
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function laporan_course($data) {

        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("REPORTING USER");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setAutoSize(true);
        $ObjSheet->getColumnDimension('D')->setAutoSize(true);
        $ObjSheet->getColumnDimension('E')->setAutoSize(true);
        $ObjSheet->getColumnDimension('F')->setAutoSize(true);
        $ObjSheet->getColumnDimension('G')->setAutoSize(true);
        $ObjSheet->getColumnDimension('H')->setAutoSize(true);
        $ObjSheet->getColumnDimension('I')->setAutoSize(true);
        $ObjSheet->getColumnDimension('J')->setAutoSize(true);
        $ObjSheet->getColumnDimension('K')->setAutoSize(true);
        $ObjSheet->getColumnDimension('L')->setAutoSize(true);
        
        $ObjSheet->mergeCells('B2:J2')->setCellValue('B2', "DATA PESERTA KURSUS")->getStyle('B2:J2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);
        $ObjSheet->mergeCells('B3:J3')->setCellValue('B3', $data[0]->TITLE_ACTIVITY)->getStyle('B3:J3')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'));

        $ObjSheet->setCellValue('B7', 'No')->getStyle('B7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C7', 'Nama Peserta')->getStyle('C7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D7', 'Email')->getStyle('D7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E7', 'Nomor Telp')->getStyle('E7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F7', 'Jenis Kelamin')->getStyle('F7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('G7', 'Alamat')->getStyle('G7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('H7', 'Tanggal Ambil')->getStyle('H7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('I7', 'Status Kursus')->getStyle('I7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('J7', 'Nilai')->getStyle('J7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('K7', 'Status Final Exam')->getStyle('K7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('L7', 'Nilai Tertinggi Final Exam')->getStyle('L7')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 8;
        foreach ($data as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->NAME)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->EMAIL)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, (empty($item->TELP) ? "Belum Mengisi" : $item->TELP))->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, (empty($item->JK) ? "Belum Mengisi" : $item->JK))->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, (empty($item->ALAMAT) ? "Belum Mengisi" : $item->ALAMAT))->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, $item->LOG_TIME)->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('I' . $rowStart, ($item->PROGRESS == 100 ? "Selesai" : $item->PROGRESS."%"))->getStyle('I' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('J' . $rowStart, (empty($item->Rata_Nilai) ? "Belum Mengerjakan" : $item->Rata_Nilai))->getStyle('J' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('K' . $rowStart, ($item->STATUS_FINAL_EXAM))->getStyle('K' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('L' . $rowStart, (empty($item->NILAI_TERTINGGI_FINAL_EXAM) ? "Belum Mengerjakan" : $item->NILAI_TERTINGGI_FINAL_EXAM))->getStyle('L' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Laporan Peserta Kursus '.$data[0]->TITLE_ACTIVITY;
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
