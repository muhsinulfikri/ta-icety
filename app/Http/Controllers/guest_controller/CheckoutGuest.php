<?php

namespace App\Http\Controllers\guest_controller;

use App\Models\Ebook;
use App\Models\Event;
use App\Models\Promo;
use App\Models\Course;
use App\Models\Checkout;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Services\XenditService;
use Illuminate\Support\Facades\Redirect;

class CheckoutGuest extends Controller
{
	public $session_data;
	public $serverKeyMidtrans = '';
	public $clientKeyMidtrans = '';
	protected $eventModel;
	protected $courseModel;
	protected $checkoutModel;
	protected $categoryModel;
	protected $certificateModel;
	protected $ebookModel;
	protected $promoModel;
	protected $xenditService;

	function __construct()
	{
		$this->eventModel = new Event();
		$this->courseModel = new Course();
		$this->checkoutModel = new Checkout();
		$this->certificateModel = new Certificate();
		$this->ebookModel = new Ebook();
		$this->promoModel = new Promo();
		$this->xenditService = new XenditService();
	}

	// PAYMENT CONTROLLER
	public function index()
	{
		if (session('user') == null) {
			return redirect('login');
		}
		$data['title'] = 'Checkout';

		$data['checking_trans'] = $this->checkoutModel->get_trans(session('user')[0]->get('ID_USER'));
		$data['checkout'] = $this->checkoutModel->get_all_order(session('user')[0]->get('ID_USER'));
		$data['list_promo'] = $this->promoModel->getPromo(session('user')[0]->get('ID_USER'));

		$data['promo'] = DB::Select("
			SELECT
				cp.*
			FROM
				claimed_promo cp
			LEFT JOIN promo p ON
				cp.ID_PROMO = p.ID_PROMO
			WHERE
				cp.ID_USER = '".session('user')[0]->get('ID_USER')."'
		");
		return view('template.header', $data) .
			view('template_guest.checkout', $data) .
			view('template.footer', $data);
	}
	public function purchase()
	{
		(session('user')[0] == null) ? redirect('login') : "";
		$data['title'] = 'Purchase';
		$data['id_trans'] = $this->GenerateUniqID_Transaction(time());

		$checking_trans = $this->checkoutModel->get_trans(session('user')[0]->get('ID_USER'));
		(empty($_POST['id_order_purchase']) && empty($checking_trans)) ? redirect('checkout') : "";

		$data['checking_trans'] = $checking_trans;
		$data['order'] = array();
		if (!empty($_POST['id_order_purchase']) && empty($checking_trans)) {
			array_push($data['order'], $this->checkoutModel->get_detail_order($_POST['id_order_purchase'], ""));

			$id_product = $data['order'][0][0]->ID_PRODUCT;
			if (substr($id_product, 0, 3) == "EBK") {
                $data['promo'] = DB::Select("
                    SELECT
                        p.*
                    FROM
                        promo p
                    LEFT JOIN claimed_promo cp ON
                        cp.ID_PROMO = p.ID_PROMO
                    WHERE
                        cp.ID_USER IS NULL
                    OR
                        p.PROMO_FOR = '0'
                    AND
                        p.PROMO_FOR = '3'
                ");
			} else {
				$cek = DB::SelectOne("
					SELECT
						TYPE_ACTIVITY
					FROM
						activity
					WHERE
						ID_ACTIVITY = '" . $id_product . "'
				");

				$data['promo'] = DB::Select("
					SELECT
						cp.*, p.AMMOUNT, p.UNIT, p.PROMO_NAME
					FROM
						claimed_promo cp
					LEFT JOIN promo p ON
				        cp.ID_PROMO = p.ID_PROMO
					WHERE
				        cp.ID_USER = '".session('user')[0]->get('ID_USER')."'
					AND
						p.PROMO_FOR = '0'
					OR
						p.PROMO_FOR = '" . $cek->TYPE_ACTIVITY . "'
				");
			}
		} else {
			foreach ($checking_trans as $item) {
				$data['id_trans'] = $item->ID_PAY;
				array_push($data['order'], $this->checkoutModel->get_detail_order($item->ID_ORDER, ""));
			}

			$data['promo'] = DB::Select("
				SELECT
						cp.*, p.AMMOUNT, p.UNIT, p.PROMO_NAME
					FROM
						claimed_promo cp
					LEFT JOIN promo p ON
				        cp.ID_PROMO = p.ID_PROMO
					WHERE
				        cp.ID_USER = '".session('user')[0]->get('ID_USER')."'
			");
		}
		return 	view('template.header', $data) .
			view('template_guest.purchase', $data) .
			view('template.footer', $data);
	}
	public function addOrder()
	{
		$id_activity = $_GET['id_activity'];
		$type = $_GET['type'];

		$checking_order = $this->checkoutModel->get_detail_order("", $id_activity);

		$msg = "";

		if (substr($id_activity, 0, 3) == "EBK") {
			$ebook = $this->ebookModel->get_book_by_id($id_activity);
			if (!empty($checking_order)) {
				$data_order = array(
					"ID_ORDER" => $checking_order->ID_ORDER,
					"ID_PRODUCT" => $id_activity,
					"ID_USER" => session('user')[0]->get('ID_USER'),
					"PRICE_ORDER" => $ebook->PRICE,
					"LOG_TIME" => date("Y-m-d H:i:s")
				);
				DB::table("order")
					->where('ID_PRODUCT', $id_activity)
					->where('ID_USER', session('user')[0]->get('ID_USER'))
					->update($data_order);
				$msg = "Your Course is Already in Cart!";
			} else {
				$data_order = array(
					"ID_ORDER" => $this->GenerateUniqID_Order(time()),
					"ID_PRODUCT" => $id_activity,
					"ID_USER" => session('user')[0]->get('ID_USER'),
					"PRICE_ORDER" => $ebook->PRICE,
					"LOG_TIME" => date("Y-m-d H:i:s")
				);
				DB::table("order")->insert($data_order);
				$msg = "Successfully Added Course to Cart!";
			}
		} else {
			if (!empty($id_activity) && !empty(session('user')[0]->get('ID_USER')) && $type == 1) { //COURSE
				$course = $this->courseModel->get_course($id_activity);
				if (!empty($checking_order)) {
					$data_order = array(
						"ID_ORDER" => $checking_order->ID_ORDER,
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => session('user')[0]->get('ID_USER'),
						"PRICE_ORDER" => $course->PRICE_ACTIVITY,
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					DB::table("order")
						->where('ID_PRODUCT', $id_activity)
						->where('ID_USER', session('user')[0]->get('ID_USER'))
						->update($data_order);

					$msg = "Your Course is Already in Cart!";
				} else {
					$data_order = array(
						"ID_ORDER" => $this->GenerateUniqID_Order(time()),
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => session('user')[0]->get('ID_USER'),
						"PRICE_ORDER" => $course->PRICE_ACTIVITY,
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					DB::table("order")->insert($data_order);
					$msg = "Successfully Added Course to Cart!";
				}
			} else if (!empty($id_activity) && !empty(session('user')[0]->get('ID_USER')) && $type == 2) { //EVENT
				$event = $this->eventModel->get_event($id_activity);
				if (!empty($checking_order)) {
					$data_order = array(
						"ID_ORDER" => $checking_order->ID_ORDER,
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => session('user')[0]->get('ID_USER'),
						"PRICE_ORDER" => $event->PRICE_ACTIVITY,
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					// $this->checkoutModel->update_order($data_order, $id_activity, session('user')[0]->get('ID_USER'));
					DB::table("order")
						->where('ID_PRODUCT', $id_activity)
						->where('ID_USER', session('user')[0]->get('ID_USER'))
						->update($data_order);
					$msg = "Your Product is Already in Cart!";
				} else {
					$data_order = array(
						"ID_ORDER" => $this->GenerateUniqID_Order(time()),
						"ID_PRODUCT" => $id_activity,
						"ID_USER" => session('user')[0]->get('ID_USER'),
						"PRICE_ORDER" => $event->PRICE_ACTIVITY,
						"LOG_TIME" => date("Y-m-d H:i:s")
					);
					// $this->checkoutModel->insert_order($data_order);
					DB::table("order")->insert($data_order);
					$msg = "Successfully Added Product to Cart!";
				}
			}
		}

		echo json_encode(array(
			'IdOrder' => (!empty($data_order['ID_ORDER']) ? $data_order['ID_ORDER'] : ""),
			'Status' => (!empty($id_activity) && !empty(session('user')[0]->get('ID_USER'))),
			'Message' => (!empty(session('user')[0]->get('ID_USER'))) ? $msg : 'Please login first!'
		));
	}
	public function deleteOrder()
	{
		try {
			$id_order = $_GET['id_order'];
			DB::table('order')->where('ID_ORDER', $id_order)->delete();

			return response([
				'status_code'       => 200,
				'status_message'    => 'Order Deleted',
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status_code'       => 500,
				'status_message'    => 'Order Not Deleted',
			], 500);
		}
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
	public function get_order_id(Request $request)
	{
		$ID_DISCOUNT = $_POST['Diskon'];
		$PRICE = (int)$_POST['TotPrice'];
		$check_discount = DB::SelectOne("
			SELECT
				p.*
			FROM
				promo p
			WHERE
				ID_PROMO = '" . $ID_DISCOUNT . "'
		");

		if ($ID_DISCOUNT != 0 && $check_discount->UNIT === 'nominal') {
			$PRICE = $PRICE - $check_discount->AMMOUNT;
		}
		if ($ID_DISCOUNT != 0 && $check_discount->UNIT === 'persen') {
			$PRICE = $PRICE - ($PRICE * ($check_discount->AMMOUNT / 100));
		}

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

		$checking_trans = $this->checkoutModel->get_trans(session('user')[0]->get('ID_USER'));
		$ID_PAY = $this->GenerateUniqIDPay('ICETY-XENDIT-checkout-' . date('Y-m-d H:i:s'));
		if (empty($checking_trans)) {
			$invoice = $this->xenditService->createInvoice([
				'external_id' => $ID_PAY,
				'payer_email' => $data_trans->EMAIL,
				'amount' => (int) $PRICE,
				'invoice_duration' => 7200,
				"success_redirect_url" => url('check_payment_status/payment?id_pay='.$ID_PAY.''),
				"failure_redirect_url" => url('purchase'),
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

			foreach ($_POST['id_order'] as $item) {
				$_response = $this->checkoutModel->get_detail_order($item, "")[0];

				$data_order = [
					"ID_PAY" => $ID_PAY,
					"LOG_TIME" => date("Y-m-d H:i:s")
				];
				DB::table('order')
					->where('ID_PRODUCT', $_response->ID_PRODUCT)
					->where('ID_USER', session('user')[0]['ID_USER'])
					->update($data_order);
			}

			return response([
				'status_code'       => 200,
				'invoice'           => $invoice,
			], 200);
		} else {
			echo json_encode([
				'status' => 200,
				'xendit_id' => $checking_trans[0]->XENDIT_ID
			]);
		}
	}
	public function check_status(Request $req)
	{
		(session('user')[0]->get('ID_USER') == null) ? redirect('login') : "";
		$id_item = $_POST['id_activity'];
		$id_order = $_POST['id_order_whenPay'];
		$id_trans = $_POST['id_trans'];
		$id_pay_method = $_POST['id_pay_method'];
		$id_promo_code = $_POST['id_promo_code'];
		$type_acticity = DB::selectOne("
			SELECT
				TYPE_ACTIVITY
			FROM
				activity
			WHERE
				ID_ACTIVITY IN ('" . implode("', '", $id_item) . "')
		");

        DB::beginTransaction();

        try {
            if ((int)$_POST['tot_bayar'] == 0) {
                $ID_PAY = $this->GenerateUniqIDPay('CI3-checkout-' . date('Y-m-d H:i:s'));
                $data_payment = array(
                    "ID_PAY" => $ID_PAY,
                    "XENDIT_ID" => NULL,
                    "KODE_USER" => session('user')[0]->get('ID_USER'),
                    "DATE_CREATED" => date("Y-m-d H:i:s"),
                    "DATE_PAY" => date("Y-m-d H:i:s")
                );
                DB::table("payment")->insert($data_payment);

                foreach ($id_item as $item) {
                    $data_order = array(
                        "ID_PAY" => $ID_PAY,
                        "LOG_TIME" => date("Y-m-d H:i:s")
                    );
                    DB::table("order")
                        ->where('ID_PRODUCT', $item)
                        ->where('ID_USER', session('user')[0]->get('ID_USER'))
                        ->update($data_order);
                    $id_item = DB::selectOne("
                        SELECT
                            TYPE_ACTIVITY
                        FROM
                            activity
                        WHERE
                            ID_ACTIVITY = '" . $item . "'
                    ");
                    if (!empty($id_item) && $id_item->TYPE_ACTIVITY == 1) {
                        $this->InsertDataMapping($item);
                    }
                }

                session()->flash('msg', "<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: 'Purchase Success'
                    })
                    </script>
                ");

                DB::commit();
                return redirect('checkouts');
            }
        } catch (Exception $e){
            DB::rollBack();
        	dd($e);
        }
	}

	public function check_payment_status(Request $req) {
		$id_item = [];
		$data_trans = DB::selectOne("
			SELECT
				p.XENDIT_ID as xendit_id,
				o.ID_PRODUCT as id_product
			FROM
				payment p
			LEFT JOIN `order` o ON
				o.ID_PAY = p.ID_PAY
			WHERE
				p.ID_PAY = '".$req->id_pay."'
		");
		$id_item[] = $data_trans->id_product;
		$type_acticity = DB::selectOne("
			SELECT
				TYPE_ACTIVITY
			FROM
				activity
			WHERE
				ID_ACTIVITY IN ('" . implode("', '", $id_item) . "')
		");
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

		if (!empty($type_acticity) && $type_acticity->TYPE_ACTIVITY == 1) {
			foreach ($id_item as $item) {
				$this->InsertDataMapping($item);
			}
		}

		$check_use_promo = DB::selectOne("
			SELECT
				count(p.ID_PAY) as pay_count,
				cp.ID_CLAIM
			FROM
				payment p
			LEFT JOIN payment_method pm ON
				pm.ID_PAY = p.ID_PAY
			LEFT JOIN claimed_promo cp ON
				p.KODE_USER = cp.ID_USER
			WHERE
				pm.STATUS = 'SETTLED'
			AND
				p.KODE_USER = '".session('user')[0]->get('ID_USER')."'
			AND
				pm.ID_PAY = '".$req->id_pay."'
		");

		if($check_use_promo->pay_count == 1){
			DB::table('claimed_promo')->where(['ID_CLAIM' => $check_use_promo->ID_CLAIM])->update(['STATUS' => 2]);
		}

		return redirect('checkouts');
	}

	public function DeleteTrans(Request $req)
	{
		$id_trans = $_POST['id_trans'];
		$id_order = $_POST['id_order'];
		//delete in tb order
		DB::table('order')
			->where('PRICE_ORDER', '<>', 0)
			->whereIn('ID_ORDER', $id_order)
			->update(['ID_PAY' => null]);

		//delete in tb payment
		DB::table('payment')
			->where('ID_PAY', $id_trans)
			->delete();


		//delete in tb payment_method
		DB::table('payment_method')
			->where('ID_PAY', $id_trans)
			->delete();

		return redirect('checkouts');
	}
	public function InsertDataMapping($item)
	{
		$data_course = $this->courseModel->get_course($item);
		$condition = "item_course.ID_COURSE = '" . $data_course->ID_COURSE . "'";
		$data_itemCourse = $this->courseModel->get_item_course($condition);
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
			// $this->checkoutModel->insert_mapping($data_mapping);
			DB::table('mapping_course')->insert($data_mapping);
		}
	}
	public function GenerateUniqID_Order($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "ORD_" . $uniqid . substr(md5(time()), 0, 6);
	}
	public function GenerateUniqID_Transaction($var)
	{
		$string = preg_replace('/[^a-z]/i', '', $var);
		$vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
		$scrap  = str_replace($vocal, "", $string);
		$begin  = substr($scrap, 0, 6);
		$uniqid = strtoupper($begin);
		return "TRAN_" . $uniqid . substr(md5(time()), 0, 6);
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
