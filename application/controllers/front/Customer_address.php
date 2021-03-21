<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_address extends SiteController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('State_model');
		$this->load->model('Country_model');
		$this->load->model('Customer_model');
		$this->load->model('Customer_address_model');
	}

	public function add()
	{
		$this->authenticate(current_url());

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
			$data['customer_id'] = $this->customer['id'];
			$addresses = $data['address'];
			unset($data['address']);

			foreach ($addresses as $address)
			{
				$data['type'] = $address;

				if($this->Customer_address_model->count_all_customer_addresses(['customer_id' => $this->customer['id'], 'type' => $address]) == 0)
				{
					$data['is_default'] = 1;
				}
				else
				{
					if(!empty($data['is_default']))
					{
						$this->Customer_address_model->update_by_params(['customer_id' => $this->customer['id'], 'type' => $address], ['is_default' => 0]);
					}
				}

				$result = $this->Customer_address_model->add($data);
			}

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Address added successfully');
				redirect('my-account');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the address');
				redirect('my-account');
				exit;
			}
		}
		else
		{
			$data['states'] = $this->State_model->get_all_states();
			$data['countries'] = $this->Country_model->get_all_countries();
			$data['customers'] = $this->Customer_model->get_all_customers(null, null, ['select' => 'c.id, c.full_name']);

			$data['title'] = 'Add Address';
            $data['_view'] = 'front/customer-address/add';
            $this->load->view('front/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['address'] = $this->Customer_address_model->get_customer_address_by_id($id);

		if(empty($data['address']) || $data['address']['customer_id'] != $this->customer['id'])
		{
			$this->session->set_flashdata('error_message', 'Address not found');
			redirect('my-account');
			exit;
		}

		$customer_id = $this->customer['id'];

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
				$this->session->set_flashdata('success_message', 'Address updated successfully');
				redirect('my-account');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the address');
				redirect('my-account');
				exit;
			}
		}
		else
		{
			$data['states'] = $this->State_model->get_all_states();
			$data['countries'] = $this->Country_model->get_all_countries();
			$data['customers'] = $this->Customer_model->get_all_customers(null, null, ['select' => 'c.id, c.full_name']);
			$data['count'] = $this->Customer_address_model->count_all_customer_addresses(['customer_id' => $customer_id]);

			$data['title'] = 'Edit Address';
            $data['_view'] = 'front/customer-address/edit';
            $this->load->view('front/layout/basetemplate', $data);
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['address'] = $this->Customer_address_model->get_customer_address_by_id($id);

		if(empty($data['address']) || $data['address']['customer_id'] != $this->customer['id'])
		{
			$this->session->set_flashdata('error_message', 'Address not found');
			redirect('my-account');
			exit;
		}

		$result = $this->Customer_address_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Address deleted successfully');
			redirect('my-account');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the address');
			redirect('my-account');
			exit;
		}
	}
}
