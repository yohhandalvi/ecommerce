<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends SiteController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cashback_model');
		$this->load->model('Category_model');
		$this->load->model('Product_model');
		$this->load->model('Product_stock_model');
	}

	public function index($id = 0)
	{
		$data['product'] = $this->Product_model->get_product_by_id($id);

		if(empty($data['product']))
		{
			$this->session->set_flashdata('error_message', 'Product not found');
			redirect('shop');
			exit;
		}

		$this->form_validation->set_rules('rating', 'Rating', 'required|xss_clean');
		$this->form_validation->set_rules('review', 'Review', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$data['product_id'] = $id;
			$data['customer_id'] = $this->customer['id'];
			$data['inactive'] = 1;
			$result = $this->Product_model->add_review($data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Thank you for submitting the review!');
				redirect('product/'.$id.'#');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while submitting the review');
				redirect('product/'.$id.'#');
				exit;
			}
		}
		else
		{
			$data['product_images'] = $this->Product_model->get_product_images($id);
			$data['total_stock'] = $this->Product_stock_model->get_total_product_stock($id);
			$data['related_products'] = $this->Product_model->get_all_products(10, 0, ['category_id' => $data['product']['category_id'], 'exclude_ids' => [$id]]);
			$data['product_reviews'] = $this->Product_model->get_product_reviews(null, null, ['product_id' => $id, 'inactive' => 0]);
			$data['product']['cashback'] = $this->Cashback_model->get_valid_cashback($id);

			$data['tab'] = 'shop';
			$data['title'] = $data['product']['name'];
			$data['_view'] = 'front/product/index';
			$this->load->view('front/layout/basetemplate', $data);
		}
	}

	public function wishlist()
    {
        $response = array(
            'success' => false,
            'message' => ''
        );

        if($this->customer['id'])
        {
            $state = $this->Product_model->wishlist($this->customer['id'], $this->input->get('id'));

	        $response['success'] = true;

	        if($state) 
	            $response['message'] = 'Product added to wishlist!';
	        else
	            $response['message'] = 'Product removed from wishlist!';

	        $response['state'] = $state;
        }
        else
        {
        	$response['message'] = 'Please login / register to add the product to wishlist!';
        }

        echo json_encode($response);
        exit;
    }
}
