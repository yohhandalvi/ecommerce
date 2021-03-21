<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Category_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();

		$offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
		$data['categories'] = $this->Category_model->get_all_categories(ROWS_PER_LISTING, $offset, $filters);
		$data['count'] = $this->Category_model->count_all_categories($filters);
		$data['total'] = $this->Category_model->count_all_categories();
		$data['inactive'] = $this->Category_model->count_all_categories(['inactive' => 1]);
		$data['pagination'] = pagination(site_url('category/listing'), $data['count'], ROWS_PER_LISTING);

		$data['filter_categories'] = $this->Category_model->get_all_categories(null, null, ['select' => 'c.id, c.name, c.parent']);

		$data['tab'] = 'categories';
		$data['title'] = 'Category Listing';
		$data['_view'] = 'admin/category/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function add()
	{
		$this->authenticate(current_url());

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('parent', 'Parent', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Category_model->add($data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Category added successfully');
				redirect('category/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the category');
				redirect('category/listing');
				exit;
			}
		}
		else
		{
			$data['categories'] = $this->Category_model->get_all_categories(null, null, ['parent' => 0, 'select' => 'c.id, c.name, c.parent']);

			$data['tab'] = 'categories';
			$data['title'] = 'Add Category';
			$data['_view'] = 'admin/category/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['category'] = $this->Category_model->get_category_by_id($id);

		if(empty($data['category']))
		{
			$this->session->set_flashdata('error_message', 'Category not found');
			redirect('category/listing');
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('parent', 'Parent', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$result = $this->Category_model->update($id, $data);

			if($result)
			{
				$this->session->set_flashdata('success_message', 'Category updated successfully');
				redirect('category/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the category');
				redirect('category/listing');
				exit;
			}
		}
		else
		{
			$data['categories'] = $this->Category_model->get_all_categories(null, null, ['select' => 'c.id, c.name, c.parent', 'exclude_sub_ids' => [$id]]);

			$data['tab'] = 'categories';
			$data['title'] = 'Edit Category';
			$data['_view'] = 'admin/category/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['category'] = $this->Category_model->get_category_by_id($id);

		if(empty($data['category']))
		{
			$this->session->set_flashdata('error_message', 'Category not found');
			redirect('category/listing');
			exit;
		}

		$result = $this->Category_model->update($id, array('deleted' => 1));

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Category deleted successfully');
			redirect('category/listing');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the category');
			redirect('category/listing');
			exit;
		}
	}
}
