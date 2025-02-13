<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RedeemCodeController extends Controller
{
    public function index()
    {
        $data['title'] = "Promo";

        $data["redeem"] = DB::select("
            SELECT 
                a.ID_ACTIVITY ,
                a.TITLE_ACTIVITY ,
                trc.ID_REDEEM ,
                trc.EXPIRED_DATE ,
                trc.LIST_KODE ,
                trc.TOTAL_CODE
            FROM 
                activity a
            RIGHT JOIN 
                (
                    SELECT 
                        trc.ID_ACTIVITY ,
                        COUNT(trc.ID_REDEEM) AS TOTAL_CODE ,
                        MAX(trc.EXPIRED_DATE) AS EXPIRED_DATE ,
                        GROUP_CONCAT(trc.ID_REDEEM SEPARATOR ';') AS ID_REDEEM ,
                        GROUP_CONCAT(trc.KODE SEPARATOR ', ') AS LIST_KODE
                    FROM 
                        tb_redeem_code trc 
                    GROUP BY 
                        trc.ID_ACTIVITY ,
			            trc.LOG_TIME
                ) trc ON 
                    trc.ID_ACTIVITY = a.ID_ACTIVITY
        ");

        $data['trial_for'] = DB::select("
            SELECT 
                mcu.*
            FROM 
                md_category_user mcu 
        ");

        $data['activity'] = DB::select("
            SELECT 
                a.ID_ACTIVITY ,
                a.TITLE_ACTIVITY 
            FROM 
                activity a 
            WHERE 
                a.STATUS = 1
                AND
                a.TYPE_ACTIVITY = 1
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.redeem_code', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function submit(Request $req)
    {
        $id_course = $req->input("id_course");
        $trial_for = $req->input("trial_for");
        $total_code = $req->input("total_code");
        $exp_date = $req->input("exp_date");

        try {
            $data = [];
            for ($i = 0; $i < $total_code; $i++) {
                $genKode = $this->GenerateUniqChild('PAY', $id_course . '' . uniqid());
                $kode = explode('_', $genKode)[1];
                $data[] = [
                    "ID_REDEEM" => $genKode,
                    "ID_ACTIVITY" => $id_course,
                    "ID_CATEGORY_USER" => $trial_for,
                    "KODE" => $kode,
                    "IS_REDEEM" => 0,
                    "EXPIRED_DATE" => $exp_date,
                    "LOG_TIME" => date('Y-m-d H:i:s')
                ];
            }

            DB::beginTransaction();
            DB::table('tb_redeem_code')->insert($data);
            DB::commit();

            return redirect('redeem-code')->with('succ_msg', 'Successfully Add New Code');
        } catch (Exception $err) {
            DB::rollBack();

            return redirect('redeem-code')->with('err_msg', 'Failed Add New Code');
        }
    }

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

    public function gen_excell($id_activity)
    {
        $id_activity = base64_decode($id_activity);
        $redeemCode = DB::select("
            SELECT 
                a.TITLE_ACTIVITY ,
                trc.KODE ,
                trc.EXPIRED_DATE ,
                mcu.NAME_CATEGORY_USER 
            FROM 
                tb_redeem_code trc 
            LEFT JOIN md_category_user mcu ON 
                mcu.ID_CATEGORY_USER = trc.ID_CATEGORY_USER 
            LEFT JOIN activity a ON 
                a.ID_ACTIVITY = trc.ID_ACTIVITY 
            WHERE 
                trc.ID_ACTIVITY = '$id_activity'
            ORDER BY 
                trc.ID_CATEGORY_USER ASC
        ");
        
        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("Sheet 1");

        $ObjSheet->getColumnDimension('B')->setAutoSize(true);
        $ObjSheet->getColumnDimension('C')->setAutoSize(true);
        $ObjSheet->getColumnDimension('D')->setAutoSize(true);
        $ObjSheet->getColumnDimension('E')->setAutoSize(true);
        $ObjSheet->getColumnDimension('F')->setAutoSize(true);
        $ObjSheet->getColumnDimension('G')->setAutoSize(true);
        $ObjSheet->getColumnDimension('H')->setAutoSize(true);

        $ObjSheet->mergeCells('B2:F2')->setCellValue('B2', "List Kode Trial Course")->getStyle('B2:F2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);

        $ObjSheet->setCellValue('B3', 'No')->getStyle('B3')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('C3', 'Course')->getStyle('C3')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('D3', 'Kode')->getStyle('D3')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('E3', 'Tipe Kode')->getStyle('E3')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
        $ObjSheet->setCellValue('F3', 'Expired')->getStyle('F3')->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));

        $rowStart = 4;
        foreach ($redeemCode as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->TITLE_ACTIVITY)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->KODE)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, $item->NAME_CATEGORY_USER)->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, $item->EXPIRED_DATE)->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            
            $rowStart++;
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'Kode Trial Course';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function GenerateUniqChild($first, $val)
    {
        $input = $val;
        $hash = md5($input);
        $sixDigitID = strtoupper(substr($hash, 0, 6));
        $generatedID = $first . '_' . $sixDigitID;
        return $generatedID;
    }
}
