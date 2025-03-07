<?php

namespace App\Http\Controllers\guest_controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PromoGuest extends Controller
{
	public $session_data;
	// function __construct()
	// {
	// 	parent::__construct();
	// 	// $this->load->model(['Event', 'Course', 'Ebook', 'Checkout', 'Promo']);
	// }

	// PROMO CONTROLLER
	public function index()
	{
        $data['title'] = 'Promo';
        $data['promo'] = DB::select("
            SELECT
                promo.*
            FROM
                promo
            LEFT JOIN
                claimed_promo
            ON
                promo.ID_PROMO = claimed_promo.ID_PROMO
            WHERE
                claimed_promo.ID_PROMO IS NULL
            AND
                promo.KUOTA > 0
            AND
                promo.CATEGORY_USER = 0
        ");


        // dd($data['promo']);

        return
            view('template.header', $data).
            view('template_guest.promo', $data).
            view('template.footer', $data);
	}
    public function claimedVoucher(Request $req){
        $data = [
            'ID_USER' => session('user')[0]->get('ID_USER'),
            'ID_PROMO' => $req->input('id_promo'),
            'STATUS' => $req->input('status')
        ];
        $claimed_promo = DB::select("
            SELECT
                ID_USER, ID_PROMO
            FROM
                claimed_promo
            WHERE
                ID_USER = ? AND ID_PROMO = ?
        ", [$data['ID_USER'], $data['ID_PROMO']]);

        if ($claimed_promo){
            return redirect('vouchers')->with('err_msg', 'Voucher sudah di klaim');
        }
        // dd($data, $claimed_promo);
        DB::table('claimed_promo')->insert($data);
        DB::update('UPDATE promo SET KUOTA = KUOTA -1 where ID_PROMO = "'.$data['ID_PROMO'].'" AND KUOTA > 0');
        return redirect('vouchers')->with('succ_msg','Successfully Claim Voucher');
    }
}
