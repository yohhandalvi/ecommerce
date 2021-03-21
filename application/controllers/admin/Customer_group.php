<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_group extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_group_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Customer_group_model->count_all_customer_groups($filters);
		$data['pagination'] = pagination(site_url('customer-group/listing'), $data['count'], ROWS_PER_LISTING);

		$data['tab'] = 'customer_groups';
		$data['title'] = 'Customer Group Listing';
		$data['_view'] = 'admin/customer-group/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function add()
	{
		$this->authenticate(current_url());

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Customer_group_model->add($data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Customer group added successfully');
				redirect('customer-group/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the customer group');
				redirect('customer-group/listing');
				exit;
			}
		}
		else
		{
			$data['tab'] = 'customer_groups';
			$data['title'] = 'Add Customer Group';
			$data['_view'] = 'admin/customer-group/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer_group'] = $this->Customer_group_model->get_customer_group_by_id($id);

		if(empty($data['customer_group']))
		{
			$this->session->set_flashdata('error_message', 'Customer group not found');
			redirect('customer-group/listing');
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Customer_group_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Customer group updated successfully');
				redirect('customer-group/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the customer group');
				redirect('customer-group/listing');
				exit;
			}
		}
		else
		{
			$data['tab'] = 'customer_groups';
			$data['title'] = 'Edit Customer Group';
			$data['_view'] = 'admin/customer-group/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['customer_group'] = $this->Customer_group_model->get_customer_group_by_id($id);

		if(empty($data['customer_group']))
		{
			$this->session->set_flashdata('error_message', 'Customer group not found');
			redirect('customer-group/listing');
			exit;
		}

		$result = $this->Customer_group_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Customer group deleted successfully');
			redirect('customer-group/listing');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the customer group');
			redirect('customer-group/listing');
			exit;
		}
	}
}
