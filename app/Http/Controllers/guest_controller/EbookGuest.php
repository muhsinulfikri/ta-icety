<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Ebook;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class EbookGuest extends Controller
{
    protected $ebookModel;
    protected $checkoutModel;
    public function __construct()
    {
        $this->ebookModel = new Ebook();
        $this->checkoutModel = new Checkout();
    }

    public function index()
    {
        $data['title'] = "Ebook";

        $ID_USER = (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');

        $data['ebook'] = DB::table('ebook')
            ->selectRaw('ebook.*,
								(SELECT
                                    COUNT(*)
                                FROM
                                    payment p
                                LEFT JOIN `order` o ON
                                    o.ID_PAY  = p.ID_PAY
                                LEFT JOIN ebook e ON
                                    e.ID_BUKU = o.ID_PRODUCT
                                WHERE
                                    o.ID_USER = ?
                                AND
                                    p.DATE_PAY IS NOT NULL) AS DATA_CHECKING', [$ID_USER])
            ->paginate(12);
        return
            view('template.header', $data) .
            view('template_guest.ebook.ebook_index', $data) .
            view('template.footer', $data);
    }

    public function detailEbook()
    {
        $data['title'] = 'Ebook';
        $data_user =  (session('user') == null) ? null : Session::get('user')[0]->get('ID_USER');
        $id_buku = $_GET['id_book'];
        $data['detail'] = DB::Selectone("
            SELECT
                e.*
            FROM
                ebook e
            WHERE
                e.ID_BUKU = '" . $id_buku . "'
        ");

        if ($data_user != null) {
            $data['checking_data'] = DB::SelectOne("
                SELECT
                    count(e.ID_BUKU) AS DATA_CHECKING
                FROM
                    ebook e
                LEFT JOIN `order` o ON
                    o.ID_PRODUCT = e.ID_BUKU
                LEFT JOIN payment p ON
                    p.ID_PAY = o.ID_PAY
                WHERE
                    e.ID_BUKU = '" . $id_buku . "'
                AND
                    o.ID_USER = '" . Session::get('user')[0]->get('ID_USER') . "'
                AND
                    p.DATE_PAY IS NOT NULL
            ");
        }

        $data['other_ebook'] = DB::Select("
            SELECT
                ebook.*
            FROM
                ebook
            ORDER BY RAND()
            LIMIT 4
        ");

        $data['checkout'] = $this->checkoutModel->get_all_order($data_user);
        return
            view('template.header', $data) .
            view('template_guest.ebook.ebook_detail', $data) .
            view('template.footer', $data);
    }

    public function view_my_book()
    {
        $data['title'] = 'Ebook';
        $id_buku = $_GET['id_book'];

        $data['checking_data'] = DB::SelectOne("
            SELECT
                count(e.ID_BUKU) AS DATA_CHECKING
            FROM
                ebook e
            LEFT JOIN `order` o ON
                o.ID_PRODUCT = e.ID_BUKU
            LEFT JOIN payment p ON
                p.ID_PAY = o.ID_PAY
            WHERE
                o.ID_PRODUCT = '" . $id_buku . "'
            AND
                o.ID_USER = '" . Session::get('user')[0]->get('ID_USER') . "'
            AND
                p.DATE_PAY IS NOT NULL
        ");

        // dd($data['checking_data']);
        if ($data['checking_data']->DATA_CHECKING == 0) {
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
							title: 'You dont have access to this book'
						})
						</script>
					");
            return redirect()->back();
        }

        $data['detail'] = DB::Selectone("
            SELECT
                e.*
            FROM
                ebook e
            WHERE
                e.ID_BUKU = '" . $id_buku . "'
        ");

        return
            view('template.header', $data) .
            view('template_guest.ebook.ebook_view', $data) .
            view('template.footer', $data);
    }
}
