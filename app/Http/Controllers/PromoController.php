<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PromoController extends Controller
{
    public function index()
    {
        $data['title'] = "Promo";

        $data["promo"] = DB::select("
            SELECT
                p.*
            FROM
                promo p
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.promo', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req){
        $data = [
            'PROMO_NAME'    => $req->input('promo_name'),
            'AMMOUNT'       => $req->input('discount'),
            'UNIT'          => $req->input('unit'),
            'PROMO_FOR'     => $req->input('promo_for'),
            'EXP_DATE'      => $req->input('exp_date'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];

        DB::table('promo')->insert($data);

        return redirect('promo')->with('succ_msg','Successfully Add New Promo');
    }

    public function update(Request $req){
        $data = [
            'PROMO_NAME'    => $req->input('up_promo_name'),
            'AMMOUNT'       => $req->input('up_discount'),
            'UNIT'          => $req->input('up_unit'),
            'PROMO_FOR'     => $req->input('up_promo_for'),
            'EXP_DATE'      => $req->input('up_exp_date'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];

        DB::table('promo')->WHERE('ID_PROMO', '=', $req->input('up_id_promo'))->update($data);

        return redirect('promo')->with('succ_msg','Successfully Update Promo');
    }

    public function delete(Request $req){
        DB::table('promo')->WHERE('ID_PROMO', '=', $req->input('id_promo'))->delete();

        return redirect('promo')->with('succ_msg','Successfully Delete Promo');
    }
}
