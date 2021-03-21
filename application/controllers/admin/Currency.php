<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends AdminController {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Currency_model');
		$this->load->model('Country_model');
	}

	public function listing()
	{
		$this->authenticate(current_url());

		$filters = $this->input->get();
		$data['currencies'] = $this->Currency_model->get_all_currencies(null, null, $filters);
		$data['count'] = $this->Currency_model->count_all_currencies($filters);
		$data['total'] = $this->Currency_model->count_all_currencies();

		$data['tab'] = 'currencies';
		$data['title'] = 'Currency Listing';
		$data['_view'] = 'admin/currency/listing';
		$this->load->view('admin/layout/basetemplate', $data);
	}

	public function add()
	{
		$this->authenticate(current_url());

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('symbol', 'Symbol', 'required|xss_clean');
		$this->form_validation->set_rules('tax', 'Tax', 'required|xss_clean');
		$this->form_validation->set_rules('countries[]', 'Countries', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();
			$countries = $data['countries'];
			unset($data['countries']);
			$result = $this->Currency_model->add($data);

			if($result)
			{
				$currency_countries = [];

				foreach ($countries as $country_id)
				{
					$currency_countries[] = [
						'country_id' => $country_id,
						'currency_id' => $result
					];
				}

				$this->Currency_model->add_currency_countries($currency_countries);
				$this->session->set_flashdata('success_message', 'Currency added successfully');
				redirect('currency/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while adding the currency');
				redirect('currency/listing');
				exit;
			}
		}
		else
		{
			$data['countries'] = $this->Country_model->get_all_currency_countries();

			$data['tab'] = 'currencies';
			$data['title'] = 'Add Currency';
			$data['_view'] = 'admin/currency/add';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function edit($id = 0)
	{
		$this->authenticate(current_url());

		$data['currency'] = $this->Currency_model->get_currency_by_id($id);

		if(empty($data['currency']))
		{
			$this->session->set_flashdata('error_message', 'Currency not found');
			redirect('currency/listing');
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('symbol', 'Symbol', 'required|xss_clean');
		$this->form_validation->set_rules('tax', 'Tax', 'required|xss_clean');

		if($id > 1)
			$this->form_validation->set_rules('countries[]', 'Countries', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if($this->form_validation->run())
		{
			$data = $this->input->post();

			if($id > 1)
			{
				$countries = $data['countries'];
				unset($data['countries']);
			}

			$result = $this->Currency_model->update($id, $data);

			if($result)
			{
				if($id > 1)
				{
					$this->Currency_model->delete_currency_countries($id);

					$currency_countries = [];

					foreach ($countries as $country_id)
					{
						$currency_countries[] = [
							'country_id' => $country_id,
							'currency_id' => $id
						];
					}

					$this->Currency_model->add_currency_countries($currency_countries);
				}

				$this->session->set_flashdata('success_message', 'Currency updated successfully');
				redirect('currency/listing');
				exit;
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Some error occured while updating the currency');
				redirect('currency/listing');
				exit;
			}
		}
		else
		{
			$data['countries'] = $this->Country_model->get_all_currency_countries();
			$currency_countries = $this->Currency_model->get_all_currency_countries($id);
			$selected_countries = [];

			if(!empty($currency_countries))
			{
				foreach ($currency_countries as $currency_country)
				{
					$selected_countries[] = $currency_country['country_id'];
				}
			}

			$data['selected_countries'] = $selected_countries;

			$data['tab'] = 'currencies';
			$data['title'] = 'Edit Currency';
			$data['_view'] = 'admin/currency/edit';
			$this->load->view('admin/layout/basetemplate', $data);
		}
	}

	public function delete($id = 0)
	{
		$this->authenticate(current_url());

		$data['currency'] = $this->Currency_model->get_currency_by_id($id);

		if(empty($data['currency']) || $id <= 1)
		{
			$this->session->set_flashdata('error_message', 'Currency not found');
			redirect('currency/listing');
			exit;
		}

		$result = $this->Currency_model->delete($id);

		if($result)
		{
			$this->session->set_flashdata('success_message', 'Currency deleted successfully');
			redirect('currency/listing');
			exit;
		}
		else
		{
			$this->session->set_flashdata('error_message', 'Some error occured while deleting the currency');
			redirect('currency/listing');
			exit;
		}
	}
}
