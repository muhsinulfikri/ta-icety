<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

    }

    public function admin_index()
    {
        $data['title'] = 'Dashboard';
        if (session('user')[0]->get('ID_ROLE') == 1) {
            $data['total_revenue'] = DB::select("
                SELECT
                    SUM(t.TOT_BAYAR) AS TOTAL
                FROM
                    transaction t
            ");

            $data['total_course'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 1
            ");

            $data['total_event'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
            ");

            $data['total_user'] = DB::select("
                SELECT
                    COUNT(u.ID_USER) AS TOTAL
                FROM
                    user u
            ");
        } else {
            $data['total_revenue'] = DB::select("
                SELECT
                    SUM(t.TOT_bayar) AS TOTAL
                FROM
                    transaction t
                WHERE
                    t.ID_USER = '".session('user')[0]->get('ID_USER')."'
                
            ");

            $data['total_course'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 1
                    AND a.ID_USER = '".session('user')[0]->get('ID_USER')."'
            ");

            $data['total_event'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.ID_USER = '".session('user')[0]->get('ID_USER')."'
            ");
        }
        

        return
            view('template_main.admin_side.etc.header', $data).
            view('template_main.admin_side.etc.sidebar', $data).
            view('template_main.admin_side.dashboard', $data).
            view('template_main.admin_side.etc.footer', $data);
    }
}
