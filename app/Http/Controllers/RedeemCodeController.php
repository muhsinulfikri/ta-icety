<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
                trc.TOTAL_CODE,
                trc.CAT,
                trc.ID_CATEGORY_USER
            FROM
                activity a
            RIGHT JOIN
                (
                    SELECT
                        trc.ID_ACTIVITY ,
                        trc.ID_CATEGORY_USER,
                        MAX(mcu.NAME_CATEGORY_USER) AS CAT ,
                        COUNT(trc.ID_REDEEM) AS TOTAL_CODE ,
                        MAX(trc.EXPIRED_DATE) AS EXPIRED_DATE ,
                        GROUP_CONCAT(trc.ID_REDEEM SEPARATOR ';') AS ID_REDEEM ,
                        GROUP_CONCAT(trc.KODE SEPARATOR ', ') AS LIST_KODE
                    FROM
                        tb_redeem_code trc
                    LEFT JOIN md_category_user mcu ON
                        mcu.ID_CATEGORY_USER = trc.ID_CATEGORY_USER
                    GROUP BY
                        trc.ID_ACTIVITY ,
                        trc.ID_CATEGORY_USER,
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

    public function delete_code(Request $req){
        $id_redeem_list = explode(';', $req->id_redeem);
        if (empty($id_redeem_list)) {
            return redirect('redeem-code')->with(['err_msg' => 'No redeem codes provided']);
        }
        DB::table('tb_redeem_code')
        ->where('ID_ACTIVITY', $req->id_activity)
        ->where('ID_CATEGORY_USER', $req->id_category_user)
        ->whereIn('ID_REDEEM', $id_redeem_list)
        ->delete();
        return redirect('redeem-code')->with(['succ_msg' => 'Successfully Delete Code', 'location' => 'redeem-code']);
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

    public function gen_excell($data)
    {
        $id_activity = explode(';', base64_decode($data))[0];
        $cat = explode(';', base64_decode($data))[1];
        $redeemCode = DB::select("
            SELECT
                a.TITLE_ACTIVITY ,
                trc.KODE ,
                trc.EXPIRED_DATE ,
                mcu.NAME_CATEGORY_USER ,
                u.NAME ,
                trc.TGL_REDEEM
            FROM
                tb_redeem_code trc
            LEFT JOIN md_category_user mcu ON
                mcu.ID_CATEGORY_USER = trc.ID_CATEGORY_USER
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = trc.ID_ACTIVITY
            LEFT JOIN `user` u ON
                u.ID_USER = trc.ID_USER
            WHERE
                trc.ID_ACTIVITY = '$id_activity'
                AND
                mcu.NAME_CATEGORY_USER = '$cat'
            ORDER BY
                trc.ID_CATEGORY_USER ASC
        ");

        $spreadsheet = new Spreadsheet();

        $ObjSheet = $spreadsheet->getActiveSheet();
        $ObjSheet->setTitle("Sheet 1");

        foreach (range('B', 'H') as $col) {
            $ObjSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $ObjSheet->mergeCells('B2:H2')->setCellValue('B2', "List Kode Trial Course")->getStyle('B2:H2')->applyFromArray($this->styling_title_template('ff948a54', 'ffffffff'))->getFont()->setSize(14)->setUnderline(\PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE);

        // Header row
        $headers = ['No', 'Course', 'Kode', 'Tipe Kode', 'Expired', 'Digunakan', 'Digunakan'];
        $colIndex = 'B';
        foreach ($headers as $header) {
            $ObjSheet->setCellValue($colIndex . '3', $header)
                ->getStyle($colIndex . '3')
                ->applyFromArray($this->styling_title_template('FFFFD966', 'FF000000'));
            $colIndex++;
        }

        $rowStart = 4;
        foreach ($redeemCode as $key => $item) {
            $ObjSheet->setCellValue('B' . $rowStart, ($key + 1))->getStyle('B' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'center'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('C' . $rowStart, $item->TITLE_ACTIVITY)->getStyle('C' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('D' . $rowStart, $item->KODE)->getStyle('D' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('E' . $rowStart, $item->NAME_CATEGORY_USER)->getStyle('E' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('F' . $rowStart, $item->EXPIRED_DATE)->getStyle('F' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('G' . $rowStart, $item->NAME ?? '-')->getStyle('G' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);
            $ObjSheet->setCellValue('H' . $rowStart, $item->TGL_REDEEM ?? '-')->getStyle('H' . $rowStart)->applyFromArray($this->styling_content_template('00FFFFFF', '00000000', 'center', 'left'))->getAlignment()->setWrapText(false);

            $rowStart++;
        }

        $ObjSheet->setAutoFilter('B3:H' . $rowStart);

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

    public function redeem_course_using_code(Request $req)
    {
        $trialCode = $req->input('trial_code');
        $dataCode = DB::selectOne("
            SELECT
                trc.ID_REDEEM ,
                trc.ID_ACTIVITY ,
                trc.ID_CATEGORY_USER ,
                trc.EXPIRED_DATE ,
                trc.KODE ,
                trc.IS_REDEEM ,
                a.TITLE_ACTIVITY ,
                a.PRICE_ACTIVITY ,
                COALESCE(c.DURATION, 0) AS DURATION
            FROM
                tb_redeem_code trc
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = trc.ID_ACTIVITY
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY
            WHERE
                trc.KODE = '" . $trialCode . "'
        ");

        $userData = DB::selectOne("
            SELECT
                u.ID_CATEGORY_USER
            FROM
                user u
            WHERE
                u.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
        ");

        if (empty($dataCode)) {
            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: Code not found'
            ], 200);
        }

        if ($dataCode->ID_CATEGORY_USER !== 1 && $userData->ID_CATEGORY_USER !== $dataCode->ID_CATEGORY_USER) {
            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: Code cannot used in your category'
            ], 200);
        }

        if (!empty($dataCode) && $dataCode->IS_REDEEM === 1) {
            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: Code has been used'
            ], 200);
        }

        if (!empty($dataCode) && strtotime($dataCode->EXPIRED_DATE . ' 00:00:00') < strtotime(date('Y-m-d H:i:s'))) {
            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: Code has been expired'
            ], 200);
        }

        $dataOrd = DB::selectOne("
            SELECT
                o.ID_PRODUCT ,
                o.ID_PAY ,
                o.EXPIRED_DATE
            FROM
                `order` o
            WHERE
                o.ID_PRODUCT = '" . $dataCode->ID_ACTIVITY . "'
                AND
                o.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
                AND
                o.ID_PAY IS NOT NULL
        ");

        $dataAct = DB::selectOne("
            SELECT
                a.*
            FROM
                `activity` a
            WHERE
                a.ID_ACTIVITY = '" . $dataCode->ID_ACTIVITY . "'
        ");

        if (empty($dataAct)) {
            return response([
                'status' => false,
                'msg' => 'Course atau aktivitas tidak ditemukan, pastikan course atau aktivitas masih berlaku!'
            ], 200);
        }

        if (!empty($dataOrd) && strtotime($dataOrd->EXPIRED_DATE . ' 00:00:00') > strtotime(date('Y-m-d H:i:s'))) {
            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: You already have claim course "' . $dataCode->TITLE_ACTIVITY . '", which expired on ' . $dataOrd->EXPIRED_DATE
            ], 200);
        }

        try {
            // Insert to Payment
            $data_payment = array(
                "ID_PAY" => $dataCode->ID_REDEEM,
                "XENDIT_ID" => NULL,
                "KODE_USER" => session('user')[0]->get('ID_USER'),
                "DATE_CREATED" => date("Y-m-d H:i:s"),
                "DATE_PAY" => date("Y-m-d H:i:s")
            );
            DB::beginTransaction();
            DB::table("payment")->insert($data_payment);
            DB::commit();

            // Check Order Exist or Not, If Exist it will update, If Not it will Insert
            $data_order = array(
                "ID_ORDER" => 'ORD_' . $dataCode->KODE,
                "ID_PRODUCT" => $dataCode->ID_ACTIVITY,
                "ID_PAY" => $dataCode->ID_REDEEM,
                "ID_USER" => session('user')[0]->get('ID_USER'),
                "PRICE_ORDER" => $dataCode->PRICE_ACTIVITY,
                "EXPIRED_DATE"  => date('Y-m-d H:i:s', strtotime('+' . $dataCode->DURATION . ' month')),
                "LOG_TIME" => date("Y-m-d H:i:s")
            );
            $data_where = [
                'ID_ORDER' => 'ORD_' . $dataCode->KODE,
                'ID_PRODUCT' => $dataCode->ID_ACTIVITY,
                'ID_USER' => session('user')[0]->get('ID_USER')
            ];
            DB::beginTransaction();
            DB::table("order")->updateOrInsert($data_where, $data_order);
            DB::commit();

            // Insert to mapping course
            $this->InsertDataMapping($dataCode->ID_ACTIVITY);

            // Update status redeem code to used
            $data_order = array(
                "ID_USER" => session('user')[0]->get('ID_USER'),
                "IS_REDEEM" => 1,
                "TGL_REDEEM" => date("Y-m-d H:i:s")
            );
            $data_where = [
                'ID_REDEEM' => $dataCode->ID_REDEEM
            ];
            DB::beginTransaction();
            DB::table("tb_redeem_code")->where($data_where)->update($data_order);
            DB::commit();

            return response([
                'status' => true,
                'msg' => 'Successfully used trial code'
            ], 200);
        } catch (Exception $err) {
            DB::rollBack();

            return response([
                'status' => false,
                'msg' => 'Failed to use code, error: ' . $err->getMessage()
            ], 200);
        }
    }

    public function InsertDataMapping($item)
    {
        $courseModel = new Course();
        $data_course = $courseModel->get_course($item);
        $condition = "item_course.ID_COURSE = '" . $data_course->ID_COURSE . "'";
        $data_itemCourse = $courseModel->get_item_course($condition);
        for ($i = 0; $i < count($data_itemCourse); $i++) {
            if ($i == 0) {
                $data_mapping = array(
                    "ID_USER" => session('user')[0]->get('ID_USER'),
                    "ID_ACTIVITY" => $item,
                    "ID_ITEM" => $data_itemCourse[$i]->ID_ITEM,
                    "STATUS" => 1
                );
            } else {
                $data_mapping = array(
                    "ID_USER" => session('user')[0]->get('ID_USER'),
                    "ID_ACTIVITY" => $item,
                    "ID_ITEM" => $data_itemCourse[$i]->ID_ITEM,
                    "STATUS" => 0
                );
            }

            DB::table('mapping_course')->insert($data_mapping);
        }
    }
}
