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
	function __construct()
	{
		$this->eventModel = new Event();
		$this->courseModel = new Course();
		$this->checkoutModel = new Checkout();
		$this->certificateModel = new Certificate();
		$this->ebookModel = new Ebook();
		$this->promoModel = new Promo();
		$this->serverKeyMidtrans = base64_encode("Mid-server-bc8oy07HC8V92YMl3oKmgL9K");
		$this->clientKeyMidtrans = 'Mid-client-SmG8P47WnRFRNOIt';
		// Durianpay::setApiKey('dp_live_HPkbQyQ29oUrgWL9');
		// Durianpay::setApiKey('dp_test_aubDzC4Ddmpac05n');
		// error_reporting(0);
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
        // dd($data['promo']);
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

		$data['ScriptMidtrans'] = '<script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="' . $this->clientKeyMidtrans . '"></script>';
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
				// $this->checkoutModel->update_order($data_order, $id_activity, session('user')[0]->get('ID_USER'));
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
				// $this->checkoutModel->insert_order($data_order);
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
					// $this->checkoutModel->update_order($data_order, $id_activity, session('user')[0]->get('ID_USER'));
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
					// $this->checkoutModel->insert_order($data_order);
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

		$data_trans = DB::select("
		SELECT
		u.NAME ,
		u.EMAIL ,
				u.TELP
			FROM
				user u
			WHERE
				u.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
		")[0];

		$checking_trans = $this->checkoutModel->get_trans(session('user')[0]->get('ID_USER'));
		$ID_PAY = $this->GenerateUniqIDPay('LARA10-checkout-' . date('Y-m-d H:i:s'));
		if (empty($checking_trans)) {
			$data_res = [
				"transaction_details" => [
					"order_id" => $ID_PAY,
					"gross_amount" => (int) $PRICE
				],
				"customer_details" => [
					"first_name" => $data_trans->NAME,
					"email" => $data_trans->EMAIL,
					"phone" => $data_trans->TELP,
					"billing_address" => [
						"first_name" => $data_trans->NAME,
						"email" => $data_trans->EMAIL,
						"phone" => $data_trans->TELP
					]
				],
				"item_details" => []
			];
			foreach ($_POST['id_order'] as $item) {
				$_response = $this->checkoutModel->get_detail_order($item, "")[0];

				$charLimit = 25;
				$_response->TITLE_ACTIVITY = mb_substr($_response->TITLE_ACTIVITY, 0, $charLimit);
				if (strlen($_response->TITLE_ACTIVITY) >= $charLimit) {
					$_response->TITLE_ACTIVITY .= '...';
				}

				$name = "";
				if (!empty($_response->JUDUL)) {
					$name = $_response->JUDUL;
				} else if (!empty($_response->TITLE_ACTIVITY)) {
					$name = $_response->TITLE_ACTIVITY;
				}

				array_push(
					$data_res['item_details'],
					array(
						'id' => $_response->ID_PRODUCT,
						'quantity' => 1,
						'price' => (int) $PRICE,
						"name" => $name,
						"brand" => "TBH Academy",
						"category" => "Course",
						"merchant_name" => "PT. DBI",
						"url" => ""
					)
				);

				$data_order = array(
					"ID_PAY" => $ID_PAY,
					"LOG_TIME" => date("Y-m-d H:i:s")
				);
				DB::table('order')
					->where('ID_PRODUCT', $_response->ID_PRODUCT)
					->where('ID_USER', session('user')[0]['ID_USER'])
					->update($data_order);
			}

			$url = 'https://app.midtrans.com/snap/v1/transactions';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_res));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'accept: application/json',
				'authorization: Basic ' . $this->serverKeyMidtrans,
				'content-type: application/json',
			));

			$response = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($response, true);
			$data_payment = array(
				"ID_PAY" => $ID_PAY,
				"TOKEN" => $data['token'],
				"KODE_USER" => session('user')[0]->get('ID_USER'),
				"DATE_CREATED" => date("Y-m-d H:i:s")
			);
			DB::table("payment")->insert($data_payment);

			$data_payment = array(
				"ID_PAY" => $ID_PAY,
				"GROSS_AMMOUNT" => $_POST['TotPrice'],
				"STATUS" => 'pending'
			);
			// $this->checkoutModel->insert_payment_method($data_payment);
			DB::table('payment_method')->insert($data_payment);
			echo json_encode([
				'status' => 200,
				'token' => $data['token']
			]);
		} else {
			echo json_encode([
				'status' => 200,
				'token' => $checking_trans[0]->TOKEN
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
            if ((int)$_POST['tot_bayar'] != 0) {
                $checking_trans = $this->checkoutModel->get_trans(session('user')[0]->get('ID_USER'));
                $id_pay = $checking_trans[0]->ID_PAY;
                $url = 'https://api.midtrans.com/v2/' . $id_pay . '/status';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'accept: application/json',
                    'authorization: Basic ' . $this->serverKeyMidtrans,
                    'content-type: application/json',
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                header('Content-Type: application/json');
                $data = json_decode($response, true);

                if (!empty($data['transaction_status'])) {
                    if ($data['transaction_status'] == 'pending') {
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
                                icon: 'warning',
                                title: 'Purchase pending complete the transaction'
                            })
                            </script>
                        ");

                        $data_payment_method = array(
                            "TRANSACTION_ID" => $data['transaction_id'],
                            "PAY_METHOD" => $data['payment_type'],
                            "EXP_DATE" => $data['expiry_time']
                        );
                        // $this->checkoutModel->update_payment_method($data_payment_method, $id_pay_method);
                        DB::table('payment_method')
                            ->where('ID_PAY', $id_pay)
                            ->update($data_payment_method);

                        DB::commit();
                    } else if ($data['transaction_status'] == 'settlement' || $data['transaction_status'] == 'capture') {
                        $data_payment_method = array(
                            "TRANSACTION_ID" => $data['transaction_id'],
                            "PAY_METHOD" => $data['payment_type'],
                            "EXP_DATE" => $data['expiry_time'],
                            "STATUS" => 'success'
                        );
                        // $this->checkoutModel->update_payment_method($data_payment_method, $id_pay_method);
                        DB::table('payment_method')
                            ->where('ID_PAY', $id_pay)
                            ->update($data_payment_method);

                        $data_payment = array(
                            "DATE_PAY" => date('Y-m-d H:i:s')
                        );
                        // $this->checkoutModel->update_payment($data_payment, $id_trans);
                        DB::table('payment')
                            ->where('ID_PAY', $id_pay)
                            ->update($data_payment);
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
                                pm.STATUS = 'success'
                            AND
                                p.KODE_USER = '".session('user')[0]->get('ID_USER')."'
                            AND
                                pm.ID_PAY = '".$id_pay."'
                        ");

                        if($check_use_promo->pay_count == 1){
                            DB::table('claimed_promo')->where(['ID_CLAIM' => $check_use_promo->ID_CLAIM])->update(['STATUS' => 2]);
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
                    } else if ($data['transaction'] == 'expire') {
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
                                icon: 'warning',
                                title: 'Purchase Failed, transaction was expire'
                            })
                            </script>
                        ");
                        // $this->checkoutModel->delete_transaction($id_trans, $id_order);
                        DB::table('order')
                            ->where('PRICE_ORDER', '<>', 0)
                            ->whereIn('ID_ORDER', $id_order)
                            ->update(['ID_PAY' => null]);

                        //delete in tb payment
                        DB::table('payment')
                            ->where('ID_PAY', $id_pay)
                            ->delete();

                        //delete in tb payment_method
                        DB::table('payment_method')
                            ->where('ID_PAY', $id_pay)
                            ->delete();

                        DB::commit();
                    } else {
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
                                icon: 'warning',
                                title: 'Purchase Failed'
                            })
                            </script>
                        ");
                        // $this->checkoutModel->delete_transaction($id_trans, $id_order);
                        DB::table('order')
                            ->where('PRICE_ORDER', '<>', 0)
                            ->whereIn('ID_ORDER', $id_order)
                            ->update(['ID_PAY' => null]);

                        //delete in tb payment
                        DB::table('payment')
                            ->where('ID_PAY', $id_pay)
                            ->delete();


                        //delete in tb payment_method
                        DB::table('payment_method')
                            ->where('ID_PAY', $id_pay)
                            ->delete();

                        DB::commit();
                    }
                }
                return redirect('checkouts');
            } else if ((int)$_POST['tot_bayar'] == 0) {
                $ID_PAY = $this->GenerateUniqIDPay('CI3-checkout-' . date('Y-m-d H:i:s'));
                $data_payment = array(
                    "ID_PAY" => $ID_PAY,
                    "TOKEN" => NULL,
                    "KODE_USER" => session('user')[0]->get('ID_USER'),
                    "DATE_CREATED" => date("Y-m-d H:i:s"),
                    "DATE_PAY" => date("Y-m-d H:i:s")
                );
                // $this->checkoutModel->insert_payment($data_payment);
                DB::table("payment")->insert($data_payment);

                foreach ($id_item as $item) {
                    $data_order = array(
                        "ID_PAY" => $ID_PAY,
                        "LOG_TIME" => date("Y-m-d H:i:s")
                    );
                    // $this->checkoutModel->update_order($data_order, $item, session('user')[0]->get('ID_USER'));
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
		return "PAY_" . $uniqid . substr(md5(time()), 0, 3);
	}
}
