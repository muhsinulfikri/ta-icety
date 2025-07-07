<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
                u.NAME,
                ud.UNIV,
                ud.DEGREE,
                ud.STUDY
            FROM
                user u
            LEFT JOIN
                user_data ud ON u.ID_USER = ud.ID_USER
            WHERE
            u.ID_ROLE = 2
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.instructor', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function add_instructor(Request $request){
        try{
            DB::beginTransaction();
            DB::table('user')->WHERE(['ID_USER' => $request->input('add_id_user')])->update(['ID_ROLE' => 2]);
            DB::commit();
            return redirect('user')->with(['succ_msg' => 'Successfully Add New Instructor', 'location' => 'user']);
        }catch(Throwable $e){
            DB::rollBack();
            dd($e);
        }
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
