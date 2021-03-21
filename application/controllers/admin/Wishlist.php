<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Wishlist_model');
	}

	public function index()
	{
		$this->authenticate(current_url());

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['customers'] = $this->Wishlist_model->get_all_wishlist_customers(ROWS_PER_LISTING, $offset, ['product_id' => (int) $this->input->get('product_id')]);
		$data['count'] = $this->Wishlist_model->count_all_wishlist_customers(['product_id' => (int) $this->input->get('product_id')]);
		$data['pagination'] = pagination(site_url('admin/wishlist'), $data['count'], ROWS_PER_LISTING);

		$data['products'] = $this->Product_model->get_all_products();

		$data['tab'] = 'wishlist';
		$data['title'] = 'Wishlist';
		$data['_view'] = 'admin/wishlist/index';
		$this->load->view('admin/layout/basetemplate', $data);
	}
}
