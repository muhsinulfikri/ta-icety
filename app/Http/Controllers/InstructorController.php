<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InstructorController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        $data['title'] = "Instructor";

        $data["instructor"] = DB::select("
        SELECT 
            u.NAME ,
            ud.* ,
            ir.STATUS
        FROM 
            instructor_req ir 
        LEFT JOIN user_data ud ON
            ud.ID_USER = ir.ID_USER 
        LEFT JOIN user u ON 
            u.ID_USER = ir.ID_USER
        ORDER BY
            ir.STATUS ASC
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.instructor', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function apply_instructor(){
        if (empty(Session::get('user'))) {
            redirect('logout');
        }
        $data = [
            'ID_USER' => Session::get('user')[0]['ID_USER'],
            'STATUS' => 0
        ];
        DB::table('instructor_req')->updateOrInsert(['ID_USER' => Session::get('user')[0]['ID_USER']], $data);
        return redirect('profile')->with(['succ_msg' => 'Successfully Apply Instructor Waiting for Admin to Confirm', 'location' => 'profile']);
    }

    public function accept(Request $req)
    {
        $accept = [
            'STATUS' => 1
        ];

        DB::table('instructor_req')->WHERE(['ID_USER' => $req->input('acc_id_instructor')])->update($accept);
        DB::table('user')->WHERE(['ID_USER' => $req->input('acc_id_instructor')])->update(['ID_ROLE' => 2]);
        return redirect('instructor')->with(['succ_msg' => 'Successfully Update Data', 'location' => 'instructor']);
    }

    public function decline(Request $req)
    {
        $decline = [
            'STATUS' => 2
        ];

        DB::table('instructor_req')->WHERE(['ID_USER' => $req->input('dec_id_instructor')])->update($decline);

        return redirect('instructor')->with(['succ_msg' => 'Successfully Update Data', 'location' => 'instructor']);
    }
}
