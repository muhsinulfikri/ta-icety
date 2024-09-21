<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        $data['title'] = "Category";

        $data["category"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");       

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.category', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req)
    {
        $data = [
            'KATEGORI'  => $req->input('kategori')
        ];

        DB::table('kategori')->INSERT($data);

        return redirect('category')->with(['succ_msg' => 'Successfully Add Category', 'location' => 'category']);
    }

    public function update(Request $req)
    {
        $data = [
            'KATEGORI'  => $req->input('up_kategori')
        ];

        DB::table('kategori')->WHERE(['ID_KATEGORI' => $req->input('up_id_kategori')])->update($data);

        return redirect('category')->with(['succ_msg' => 'Successfully Update Category', 'location' => 'category']);
    }

    public function delete(Request $req)
    {
        DB::table('kategori')->WHERE(['ID_KATEGORI' => $req->input('del_id_kategori')])->delete();

        return redirect('category')->with(['succ_msg' => 'Successfully Delete Category', 'location' => 'category']);
    }
}
