<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PromoGuest extends Controller
{
	public $session_data;
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Event', 'Course', 'Ebook', 'Checkout', 'Promo']);
	}

	// PROMO CONTROLLER
	public function index()
	{
		$data['title'] = 'Promo';
		$data['checkout'] = $this->Checkout->get_all_order($this->session->userdata('ID_USER'));
		$this->load->view('template/header', $data);
		$this->load->view('guest/promo');
		$this->load->view('template/footer');
	}
}