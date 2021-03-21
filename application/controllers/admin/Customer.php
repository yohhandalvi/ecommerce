<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cart_model');
		$this->load->model('Order_model');
		$this->load->model('Email_model');
		$this->load->model('Wallet_model');
		$this->load->model('Customer_model');
		$this->load->model('Customer_group_model');
		$this->load->model('Customer_address_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['customers'] = $this->Customer_model->get_all_customers(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Customer_model->count_all_customers($filters);
		$data['total'] = $this->Customer_model->count_all_customers();
		$data['inactive'] = $this->Customer_model->count_all_customers(['inactive' => 1]);
		$data['pagination'] = pagination(site_url('customer/listing'), $data['count'], ROWS_PER_LISTING);

		$data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();

		$data['tab'] = 'customers';
		$data['title'] = 'Customer Listing';
		$data['_view'] = 'admin/customer/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function add()
	{
		$this->authenticate(current_url());

		$this->form_validation->set_rules('first_name', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|check_field[customers,email,deleted|0]|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'check_field[customers,mobile,deleted|0]|xss_clean');
		$this->form_validation->set_rules('date_of_birth', 'Date of birth', 'xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'xss_clean');
		$this->form_validation->set_rules('customer_group_id', 'Group', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is invalid');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$random_password = random_string('alnum', 12);

			$data = $this->input->post();
			$data['full_name'] = $data['first_name'] . " " . $data['last_name'];
			$data['password'] = md5($random_password);
			$result = $this->Customer_model->add($data);

			if($result)
			{
				$this->Email_model->send_registration_email($data['full_name'], $data['email'], $random_password);

				$this->session->set_flashdata('success_message', 'Customer added successfully');
				redirect('customer/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the customer');
				redirect('customer/listing');
				exit;
			}
		}
		else
		{
			$data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();

			$data['tab'] = 'customers';
			$data['title'] = 'Add Customer';
			$data['_view'] = 'admin/customer/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$this->form_validation->set_rules('first_name', 'First name', 'required|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|check_field[customers,email,deleted|0&id !=|'.$id.']|xss_clean');
		$this->form_validation->set_rules('mobile', 'Mobile', 'check_field[customers,mobile,deleted|0&id !=|'.$id.']|xss_clean');
		$this->form_validation->set_rules('date_of_birth', 'Date of birth', 'xss_clean');
		$this->form_validation->set_rules('gender', 'Gender', 'xss_clean');
		$this->form_validation->set_rules('customer_group_id', 'Group', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is invalid');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$data['full_name'] = $data['first_name'] . " " . $data['last_name'];
			$result = $this->Customer_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Customer updated successfully');
				redirect('customer/view/'.$id);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the customer');
				redirect('customer/view/'.$id);
				exit;
			}
		}
		else
		{
			$data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();

			$data['tab'] = 'customers';
			$data['title'] = 'Edit Customer';
			$data['_view'] = 'admin/customer/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function orders($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$data['orders'] = $this->Order_model->get_all_orders(null, null, ['customer_id' => $id]);

		$data['tab'] = 'customers';
		$data['title'] = 'View Customer Orders';
		$data['_view'] = 'admin/customer/orders';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function reviews($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$data['product_reviews'] = $this->Product_model->get_product_reviews(null, null, ['customer_id' => $id]);

		$data['tab'] = 'customers';
		$data['title'] = 'View Customer Reviews';
		$data['_view'] = 'admin/customer/reviews';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function wishlist($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$data['wishlist_products'] = $this->Product_model->get_all_products(null, null, ['wishlist' => $id, 'inactive' => 0]);

		$data['tab'] = 'customers';
		$data['title'] = 'Check Customer Wishlist';
		$data['_view'] = 'admin/customer/wishlist';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function view($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$data['total_cart_products'] = $this->Cart_model->count_all_cart_products(['customer_id' => $id]);
		$data['total_orders'] = $this->Order_model->count_all_orders(['customer_id' => $id]);

		$data['cart_products'] = $this->Cart_model->get_all_cart_products(null, null, ['customer_id' => $id]);
		$data['orders'] = $this->Order_model->get_all_orders(null, null, ['customer_id' => $id]);

		$data['billing_address'] = $this->Customer_address_model->get_customer_address_by_params(['customer_id' => $id, 'type' => 'billing', 'is_default' => 1]);
		$data['shipping_address'] = $this->Customer_address_model->get_customer_address_by_params(['customer_id' => $id, 'type' => 'shipping', 'is_default' => 1]);

		$data['wallet'] = $this->Wallet_model->get_customer_balance($id);
        $data['wallet_transactions'] = $this->Wallet_model->get_customer_transactions($id);

		$data['tab'] = 'customers';
		$data['title'] = 'View Customer';
		$data['_view'] = 'admin/customer/view';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function wallet($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$data['wallet'] = $this->Wallet_model->get_customer_balance($id);
        $data['wallet_transactions'] = $this->Wallet_model->get_customer_transactions($id);

		$data['tab'] = 'customers';
		$data['title'] = 'View Customer Wallet Transactions';
		$data['_view'] = 'admin/customer/wallet';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$result = $this->Customer_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Customer deleted successfully');
			redirect('customer/listing');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the customer');
			redirect('customer/listing');
			exit;
		}
	}
}
