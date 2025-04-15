<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendEmailController extends Controller
{
    public function index(){
        $data['title'] = "Verification Account";
        $data['user'] = DB::select("
            SELECT
                u.ID_USER,
                u.EMAIL,
                u.NAME,
                u.STATUS,
                u.IS_DELETE
            FROM
                user u
            WHERE
                u.STATUS = 0
            AND
           		u.IS_DELETE = 0
        ");
        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.send_email_verif', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function verif_email(Request $request){
        try {
            DB::table('user')
                        ->where('ID_USER', $request->input('id_user'))
                        ->update(['STATUS' => 1]);

            return redirect('send-email-verification')->with(['succ_msg' => 'Successfully verification users', 'location' => 'verif-account-admin']);
        } catch (Exception $e) {
            return dd($e);
        }
    }

}
