<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_address extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('State_model');
		$this->load->model('Country_model');
		$this->load->model('Customer_model');
		$this->load->model('Customer_address_model');
	}

	public function listing($customer_id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($customer_id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}

		$filters = $this->input->get();
		$filters['customer_id'] = $customer_id;

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['customer_addresses'] = $this->Customer_address_model->get_all_customer_addresses(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Customer_address_model->count_all_customer_addresses($filters);
		$data['pagination'] = pagination(site_url('customer-address/listing/'.$customer_id), $data['count'], ROWS_PER_LISTING);

		$data['tab'] = 'customers';
		$data['title'] = 'Customer Address Listing';
		$data['_view'] = 'admin/customer-address/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function add($customer_id = 0)
	{
		$this->authenticate(current_url());

		$data['customer'] = $this->Customer_model->get_customer_by_id($customer_id);

		if(empty($data['customer']))
		{
			$this->session->set_flashdata('error_message', 'Customer not found');
			redirect('customer/listing');
			exit;
		}


		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_1', 'Address line 1', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_2', 'Address line 1', 'xss_clean');
		$this->form_validation->set_rules('landmark', 'Landmark', 'xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('pin_code', 'Pin code', 'required|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('address[]', 'Address', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$data['customer_id'] = $customer_id;
			$addresses = $data['address'];
			unset($data['address']);

			foreach ($addresses as $address)
			{
				$data['type'] = $address;

				if($this->Customer_address_model->count_all_customer_addresses(['customer_id' => $customer_id, 'type' => $address]) == 0)
				{
					$data['is_default'] = 1;
				}
				else
				{
					if(!empty($data['is_default']))
					{
						$this->Customer_address_model->update_by_params(['customer_id' => $customer_id, 'type' => $address], ['is_default' => 0]);
					}
				}

				$result = $this->Customer_address_model->add($data);
			}

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Customer address added successfully');
				redirect('customer-address/listing/'.$customer_id);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the customer address');
				redirect('customer-address/listing/'.$customer_id);
				exit;
			}
		}
		else
		{
			$data['states'] = $this->State_model->get_all_states();
			$data['countries'] = $this->Country_model->get_all_countries();
			$data['customers'] = $this->Customer_model->get_all_customers(null, null, ['select' => 'c.id, c.full_name']);
			$data['count'] = $this->Customer_address_model->count_all_customer_addresses(['customer_id' => $customer_id]);

			$data['tab'] = 'customers';
			$data['title'] = 'Add Customer Address';
			$data['_view'] = 'admin/customer-address/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer_address'] = $this->Customer_address_model->get_customer_address_by_id($id);

		if(empty($data['customer_address']))
		{
			$this->session->set_flashdata('error_message', 'Customer address not found');
			redirect('customer-address/listing');
			exit;
		}

		$customer_id = $data['customer_address']['customer_id'];

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_1', 'Address line 1', 'required|xss_clean');
		$this->form_validation->set_rules('address_line_2', 'Address line 1', 'xss_clean');
		$this->form_validation->set_rules('landmark', 'Landmark', 'xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('pin_code', 'Pin code', 'required|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is invalid');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();

			if(empty($data['is_default']))
				$data['is_default'] = 0;

			$result = $this->Customer_address_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Customer address updated successfully');
				redirect('customer-address/listing/'.$customer_id);
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the customer address');
				redirect('customer-address/listing/'.$customer_id);
				exit;
			}
		}
		else
		{
			$data['states'] = $this->State_model->get_all_states();
			$data['countries'] = $this->Country_model->get_all_countries();
			$data['customers'] = $this->Customer_model->get_all_customers(null, null, ['select' => 'c.id, c.full_name']);
			$data['count'] = $this->Customer_address_model->count_all_customer_addresses(['customer_id' => $customer_id]);

			$data['tab'] = 'customers';
			$data['title'] = 'Edit Customer Address';
			$data['_view'] = 'admin/customer-address/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer_address'] = $this->Customer_address_model->get_customer_address_by_id($id);

		if(empty($data['customer_address']))
		{
			$this->session->set_flashdata('error_message', 'Customer address not found');
			redirect('customer-address/listing');
			exit;
		}

		$result = $this->Customer_address_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Customer address deleted successfully');
			redirect('customer-address/listing/'.$data['customer_address']['customer_id']);
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the customer address');
			redirect('customer-address/listing/'.$data['customer_address']['customer_id']);
			exit;
		}
	}
}
