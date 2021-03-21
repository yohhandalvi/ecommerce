<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_rate extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Shipping_rate_model');
    }

    public function listing($page = 0)
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['shipping_rates'] = $this->Shipping_rate_model->get_all_shipping_rates(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Shipping_rate_model->count_all_shipping_rates($filters);
        $data['total'] = $this->Shipping_rate_model->count_all_shipping_rates();
        $data['pagination'] = pagination(site_url('shipping-rate/listing'), $data['count'], ROWS_PER_LISTING);

        $data['tab'] = 'shipping_rates';
        $data['title'] = 'Shipping Rate Listing';
        $data['_view'] = 'admin/shipping-rate/listing';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function add()
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('amount_from', 'Amount from', 'required|is_numeric');
        $this->form_validation->set_rules('amount_to', 'Amount to', 'is_numeric|greater_than['.$this->input->post('amount_from').']');
        $this->form_validation->set_rules('shipping_fee', 'Shipping fee', 'is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Shipping_rate_model->add($data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Shipping rate added successfully');
                redirect('shipping-rate/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while adding the shipping rate');
                redirect('shipping-rate/listing');
                exit;
            }
        }
        else
        {
            $highest_shipping_rate = $this->Shipping_rate_model->get_highest_shipping_rate();
            $data['min_shipping_rate_amount'] = ($highest_shipping_rate['amount_to']) ? $highest_shipping_rate['amount_to'] + 1 : 0;

            $data['tab'] = 'shipping_rates';
            $data['title'] = 'Add Shipping Rate';
            $data['_view'] = 'admin/shipping-rate/add';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function edit($id = 0)
    {
        $this->authenticate(current_url());

        $data['shipping_rate'] = $this->Shipping_rate_model->get_shipping_rate_by_id($id);

        if(empty($data['shipping_rate']))
        {
            $this->session->set_flashdata('error_message', 'Shipping rate not found');
            redirect('shipping-rate/listing');
            exit;
        }

        $this->form_validation->set_rules('amount_from', 'Amount from', 'required|is_numeric');
        $this->form_validation->set_rules('amount_to', 'Amount to', 'is_numeric|greater_than['.$this->input->post('amount_from').']');
        $this->form_validation->set_rules('shipping_fee', 'Shipping fee', 'is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Shipping_rate_model->update($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Shipping rate updated successfully');
                redirect('shipping-rate/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the shipping rate');
                redirect('shipping-rate/listing');
                exit;
            }
        }
        else
        {
            $highest_shipping_rate = $this->Shipping_rate_model->get_highest_shipping_rate();

            if(empty($highest_shipping_rate))
                $data['min_shipping_rate_amount'] = 0;
            else
                $data['min_shipping_rate_amount'] = $highest_shipping_rate['amount_to'] + 1;

            $data['tab'] = 'shipping_rates';
            $data['title'] = 'Edit Shipping Rate';
            $data['_view'] = 'admin/shipping-rate/edit';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete($id = 0)
    {
        $this->authenticate(current_url());

        $data['shipping_rate'] = $this->Shipping_rate_model->get_shipping_rate_by_id($id);

        if(empty($data['shipping_rate']))
        {
            $this->session->set_flashdata('error_message', 'Shipping rate not found');
            redirect('shipping-rate/listing');
            exit;
        }

        $result = $this->Shipping_rate_model->update($id, array('deleted' => 1));

        if($result)
        {
            $this->session->set_flashdata('success_message', 'Shipping rate deleted successfully');
            redirect('shipping-rate/listing');
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the shipping rate');
            redirect('shipping-rate/listing');
            exit;
        }
    }
}