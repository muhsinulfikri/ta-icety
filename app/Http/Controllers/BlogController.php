<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $data['title'] = "Blog";

        $data["blog"] = DB::select("
            SELECT
                b.*
            FROM
                blog b
        ");

        return
            view('template_main.admin_side.etc.header', $data) .
            view('template_main.admin_side.etc.sidebar', $data) .
            view('template_main.admin_side.blog', $data) .
            view('template_main.admin_side.etc.footer');
    }

    public function store(Request $req){
        $data = [
            'TITLE_BLOG'          => $req->input('title_blog'),
            'CATEGORY_BLOG'       => $req->input('category_blog'),
            'IMAGE_BLOG'          => FileUpload::S3($req->file('image_blog'), 'IMAGE_BLOG', 'Image-Blog-' . strtotime(now())),
            'TEXT_BLOG'           => $req->input('text_blog'),
            'DATE_UPLOAD'         => date('Y-m-d H:i:s')
        ];

        DB::table('blog')->insert($data);

        return redirect('blogs')->with('succ_msg','Successfully Add New Blog');
    }

    public function update(Request $req){
        $data = [
            'TITLE_BLOG'          => $req->input('up_title_blog'),
            'CATEGORY_BLOG'       => $req->input('up_category_blog'),
            'TEXT_BLOG'           => $req->input('up_text_blog'),
            'DATE_UPLOAD'         => date('Y-m-d H:i:s')
        ];

        if ($req->hasFile('up_image_blog')) {
            $data['IMAGE_BLOG'] = FileUpload::S3($req->file('up_image_blog'), 'IMAGE_BLOG', 'Image-Blog-' . strtotime(now()));
        }

        DB::table('blog')->WHERE('ID_BLOG', '=', $req->input('up_id_blog'))->update($data);

        return redirect('blogs')->with('succ_msg','Successfully Update blog');
    }

    public function delete(Request $req){
        DB::table('blog')->WHERE('ID_BLOG', '=', $req->input('del_id_blog'))->delete();

        return redirect('blogs')->with('succ_msg','Successfully Delete Blog');
    }
}
