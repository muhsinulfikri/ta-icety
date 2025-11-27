<?php

namespace App\Http\Controllers\guest_controller;

use Exception;
use Illuminate\Http\Request;
use App\Services\XenditService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use DateTime;
use DateTimeZone;

class PaymentCertificate extends Controller
{
    protected $xenditService;
    protected $sertifPayModel;
    function __construct()
	{
		$this->xenditService = new XenditService();
        $this->sertifPayModel = new Certificate();
	}
    public function get_payment(Request $request)
	{
		try {
			$invoice = $this->xenditService->retrieveInvoiceById($request->xendit_id);
			return $invoice;
		} catch (\Xendit\XenditSdkException $e) {
			echo 'Exception when calling InvoiceApi->getInvoiceById: ', $e->getMessage(), PHP_EOL;
			echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
		}
	}

	// Access payment gateway
	public function get_pay_sertif_id(Request $request)
	{
		// $PRICE = (int)$_POST['TotPrice'];
        // $id_sertif_pay = $this->sertifPayModel->getSertifIsPaid($_POST['id_sertif_pay']);
        dd($request);
        $PRICE = (int) $request->input['TotPrice'];
        $id_sertif_pay = $this->sertifPayModel->getSertifIsPaid($request->input['id_sertif_pay']);

		$data_trans = DB::selectOne("
			SELECT
				u.NAME ,
				u.EMAIL ,
				u.TELP
			FROM
				user u
			WHERE
				u.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
		");

		$checking_trans = DB::selectOne("
            SELECT
                ps.*
            FROM
                payment_sertif ps
            WHERE
                ps.ID_PAYMENT_SERTIF  = '" . ((!empty($id_sertif_pay) && !empty($id_sertif_pay->ID_PAYMENT_SERTIF)) ? $id_sertif_pay->ID_PAYMENT_SERTIF : '') . "'
            AND
                ps.IS_PAY = 1
        ");
		$ID_PAY = $this->GenerateUniqIDPay('ICETY-XENDIT-checkout-' . date('Y-m-d H:i:s'));
		if (empty($checking_trans)) {
            $url_success = url('check_payment_sertif/payment?id_pay=' . $ID_PAY);
            $url_failed = url('purchase');
			$invoice = $this->xenditService->createInvoice([
				'external_id' => $ID_PAY,
				'payer_email' => $data_trans->EMAIL,
				'amount' => (int) $PRICE,
				'invoice_duration' => 7200,
				"success_redirect_url" => $url_success,
				"failure_redirect_url" => $url_failed,
			]);

			$data_payment = [
				"ID_PAY" => $ID_PAY,
				"KODE_USER" => session('user')[0]->get('ID_USER'),
				"ID_DISCOUNT" => $ID_DISCOUNT ?? null,
				"XENDIT_ID" => $invoice['id'],
				"DATE_CREATED" => date("Y-m-d H:i:s")
			];
			DB::table("payment")->insert($data_payment);

			$data_payment_method = [
				"ID_PAY" => $ID_PAY,
				"GROSS_AMMOUNT" => (int) $PRICE,
				"STATUS" => $invoice['status'],
				"PAY_METHOD" => $invoice['payment_method'],
				"EXP_DATE" => $invoice['expiry_date'],
			];
			DB::table('payment_method')->insert($data_payment_method);

            if (empty($id_sertif_pay)) {
                DB::table('payment_sertif')->insert([
                    "ID_PAYMENT_SERTIF" => $ID_PAY . 'sertif',
                    "ID_USER"           => session('user')[0]->get('ID_USER'),
                    "ID_ACTIVITY"       => $request->idActivity,
                    "TITLE_ACTIVITY"    => $request->titleActivity,
                    "ID_PAY"            => $ID_PAY,
                    "IS_PAY"            => 0,
                ]);
            } else {
                // Kalau sudah ada → update ID_PAY saja
                DB::table('payment_sertif')
                    ->where('ID_PAYMENT_SERTIF', $id_sertif_pay->ID_PAYMENT_SERTIF)
                    ->update(["ID_PAY" => $ID_PAY]);
            }
			return response()->json([
                'status_code' => 200,
                'invoice'     => $invoice,
            ]);
		} else {
			$invoice['id'] = $checking_trans->XENDIT_ID;
			return response()->json([
                'status_code' => 200,
                'invoice'     => ['id' => $checking_trans->XENDIT_ID]
            ]);
		}
	}

	public function check_payment_status(Request $req)
	{
		try {
			DB::beginTransaction();

			$data_trans = DB::selectOne("
				SELECT
					p.XENDIT_ID as xendit_id,
					ps.ID_PAYMENT_SERTIF,
					ps.ID_SERTIFIKAT as id_product,
                    ps.ID_ACTIVITY,
                    ps.TITLE_ACTIVITY
				FROM
					payment p
				LEFT JOIN payment_sertif ps ON
					ps.ID_PAY = p.ID_PAY
				WHERE
					p.ID_PAY = '" . $req->input('id_pay') . "'
			");
            // dd($req, $data_trans);
			$check_xendit = $this->xenditService->retrieveInvoiceById($data_trans->xendit_id);

			$data_payment = [
				"DATE_PAY" => $check_xendit['updated'],
			];
			DB::table("payment")->where('ID_PAY', $req->id_pay)->update($data_payment);

			$data_payment_method = [
				"STATUS" => $check_xendit['status'],
				"PAY_METHOD" => $check_xendit['payment_method'],
				"EXP_DATE" => $check_xendit['expiry_date'],
			];
			DB::table('payment_method')->where('ID_PAY', $req->id_pay)->update($data_payment_method);

            if (!$data_trans || !$data_trans->ID_PAYMENT_SERTIF) {
                $newIdPaymentSertif = $this->GenerateUniqIDPay('ICETY-XENDIT-checkout-' . date('Y-m-d H:i:s'));

                DB::table('payment_sertif')->insert([
                    "ID_PAYMENT_SERTIF" => $newIdPaymentSertif . 'sertif',
                    "ID_SERTIFIKAT"     => null,
                    "ID_USER"           => session('user')[0]['ID_USER'],
                    "IS_PAY"            => 1,
                    "ID_PAY"            => $req->id_pay,
                    "ID_ACTIVITY"       => $req->input('id_activity') ?? null,
                    "TITLE_ACTIVITY"    => $req->input('title_activity') ?? null,
                ]);
            } else {
                // Kalau sudah ada → update IS_PAY
                DB::table('payment_sertif')
                    ->where('ID_PAYMENT_SERTIF', $data_trans->ID_PAYMENT_SERTIF)
                    ->where('ID_PAY', $req->id_pay)
                    ->where('ID_USER', session('user')[0]['ID_USER'])
                    ->update(['IS_PAY' => 1]);
            }

            DB::commit();

			return redirect('course/detail/' . preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $data_trans->TITLE_ACTIVITY)) . '?id_activity=' . $data_trans->ID_ACTIVITY);
		} catch (\Throwable $th) {
			DB::rollBack();
			dd($th);
		}

	}

    public function check_payment_status_ajax($idPayRaw)
	{
		try {
			DB::beginTransaction();

			$data_trans = DB::selectOne("
				SELECT
					p.XENDIT_ID as xendit_id,
                    p.ID_PAY,
					ps.ID_PAYMENT_SERTIF,
					ps.ID_SERTIFIKAT as id_product,
                    ps.ID_ACTIVITY,
                    ps.TITLE_ACTIVITY
				FROM
					payment p
				LEFT JOIN payment_sertif ps ON
					ps.ID_PAY = p.ID_PAY
				WHERE
				    ps.ID_PAYMENT_SERTIF = '" . $idPayRaw . "'
			");

            $id_pay = $data_trans->ID_PAY;
			$check_xendit = $this->xenditService->retrieveInvoiceById($data_trans->xendit_id);
            $dateTime = new DateTime("2025-05-23 07:39:15.126", new DateTimeZone("UTC"));
            $data_payment = [
				"DATE_PAY" => $dateTime->format('Y-m-d H:i:s'),
			];
			DB::table("payment")->where('ID_PAY', $id_pay)->update($data_payment);

			$data_payment_method = [
				"STATUS" => $check_xendit['status'],
				"PAY_METHOD" => $check_xendit['payment_method'],
				"EXP_DATE" => $check_xendit['expiry_date'],
			];
			DB::table('payment_method')->where('ID_PAY', $id_pay)->update($data_payment_method);

            DB::table('payment_sertif')
                ->where('ID_PAYMENT_SERTIF', $data_trans->ID_PAYMENT_SERTIF)
                ->where('ID_PAY', $id_pay)
                ->where('ID_USER', session('user')[0]['ID_USER'])
                ->update(['IS_PAY' => 1]);

            DB::commit();

			return response([
                'status' => 200,
                'msg' => 'Payment successfully update'
            ], 200);
		} catch (Exception $th) {
			DB::rollBack();
			return response([
                'status' => 500,
                'msg' => 'System get error, error: ' . $th->getMessage()
            ], 200);
		}

	}

    public function GenerateUniqIDPay($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 4);
		$uniqid = strtoupper($begin);
		return "PAY_ICETY_" . $uniqid . substr(md5(microtime()), 0, 7);
	}
}
