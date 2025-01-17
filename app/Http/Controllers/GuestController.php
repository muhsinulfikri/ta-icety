<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Checkout;
use App\Models\Ebook;
use App\Models\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GuestController extends Controller
{
	// public $session_data;
	// function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->model(['Event', 'Course', 'Category', 'Checkout']);
	// 	// error_reporting(0);
	// }

	public function index()
	{
		$data['title'] = 'ICETy';

		$data['kategori'] = DB::select('
			SELECT
				*
			FROM
				kategori
		');

		$data['carousel'] = DB::select('
			SELECT
				*
			FROM
				tb_carousel
		');

		$courseModel = new Course();
		$data['course'] = $courseModel->get_home_course_all();
		$ebookModel = new Ebook();
		$data['ebook'] = $ebookModel->get_all_book_home();

		$data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
		$checkoutModel = new Checkout();
		$data['checkout'] = $checkoutModel->get_all_order($data_user);
		$eventModel = new Event();
		$data['event'] = $eventModel->get_home_event();
		// dd($data);
		return
			view('template.header', $data) .
			view('template_guest.home', $data) .
			view('template.footer', $data);
	}

	public function about()
	{
		$data['title'] = 'About | ICETy';

		return
			view('template.header', $data) .
			view('template_guest.about', $data) .
			view('template.footer', $data);
	}

	public function blog()
	{
		$data['title'] = 'Blog | ICETy ';

		$data['blog'] = DB::select("
			SELECT
				*
			FROM
				blog
		");
		return
			view('template.header', $data) .
			view('template_guest.blog', $data) .
			view('template.footer', $data);
	}

	public function store()
	{
		$data['title'] = 'Store | ICETy';

		$courseModel = new Course();
		$data['course'] = $courseModel->get_home_course_all();
		$ebookModel = new Ebook();
		$data['ebook'] = $ebookModel->get_all_book_home();
        $eventModel = new Event();
		$data['event'] = $eventModel->get_home_event();
        // dd($data['event']);
		return
			view('template.header', $data) .
			view('template_guest.store', $data) .
			view('template.footer', $data);
	}

	public function courseCategories(Request $req)
	{
		$category = $req->input('category');
		$condition = $category ? ['activity.TYPE_ACTIVITY = 1', 'course.KATEGORI = ' . $category] : ['activity.TYPE_ACTIVITY = 1'];
		$courseModel = new Course();
		$data['course'] = $courseModel->get_home_course($condition);
		return view('template_guest.home_course', $data);
	}
}
