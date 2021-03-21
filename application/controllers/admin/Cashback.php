<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashback extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cashback_model');
        $this->load->model('Wallet_model');
        $this->load->model('Product_model');
        $this->load->model('Customer_model');
        $this->load->model('Customer_group_model');
    }

    public function listing($page = 0)
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['cashbacks'] = $this->Cashback_model->get_all_cashbacks(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Cashback_model->count_all_cashbacks($filters);
        $data['total'] = $this->Cashback_model->count_all_cashbacks();
        $data['pagination'] = pagination(site_url('cashback/listing'), $data['count'], ROWS_PER_LISTING);

        $data['tab'] = 'cashbacks';
        $data['title'] = 'Cashback Listing';
        $data['_view'] = 'admin/cashback/listing';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function add() 
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('limit_to', 'Limit To', 'required');

        if($this->input->post('limit_to') == 'user_group')
            $this->form_validation->set_rules('limit_to_customer_group_id', 'Limit To User Group', 'required');

        if($this->input->post('limit_to') == 'custom')
            $this->form_validation->set_rules('limit_to_customers[]', 'Limit To Customers', 'required');

        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('apply_cashback_to', 'Apply Cashback To', 'required');
        $this->form_validation->set_rules('valid_from_date', 'From Date', 'required');
        $this->form_validation->set_rules('valid_to_date', 'To Date', 'required');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $active = TRUE;

        if($_POST)
        {
            $active = $this->Cashback_model->get_active_dated_cashback($this->input->post());
        }

        if($this->form_validation->run() && $active == FALSE)
        {
            $data = $this->input->post();
            $result = $this->Cashback_model->add($data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Cashback added successfully');
                redirect('cashback/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while adding the cashback');
                redirect('cashback/listing');
                exit;
            }
        }
        else
        {
            if($_POST && $active)
            {
                $data['message'] = "An active cashback already exists intersecting with the dates / products.";
            }
            else
            {
                $data['message'] = "";
            }

            $data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();
            $data['customers'] = $this->Customer_model->get_all_customers();
            $data['products'] = $this->Product_model->get_all_products();

            $data['tab'] = 'cashbacks';
            $data['title'] = 'Add Cashback';
            $data['_view'] = 'admin/cashback/add';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }


    public function wallet() 
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|is_numeric');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Wallet_model->add($data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Amount added to wallet successfully');
                redirect('cashback/for');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while adding the amount to the wallet');
                redirect('cashback/for');
                exit;
            }
        }
        else
        {
            $data['customers'] = $this->Customer_model->get_all_customers();

            $data['tab'] = 'cashbacks';
            $data['title'] = 'Add Wallet';
            $data['_view'] = 'admin/cashback/wallet';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function for() 
    {
        $this->authenticate(current_url());

        $data['tab'] = 'cashbacks';
        $data['title'] = 'Cashback For';
        $data['_view'] = 'admin/cashback/for';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function edit($id = 0)
    {
        $this->authenticate(current_url());

        $data['cashback'] = $this->Cashback_model->get_cashback_by_id($id);

        if(empty($data['cashback']))
        {
            $this->session->set_flashdata('error_message', 'Cashback not found');
            redirect('cashback/listing');
            exit;
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('limit_to', 'Limit To', 'required');

        if($this->input->post('limit_to') == 'user_group')
            $this->form_validation->set_rules('limit_to_customer_group_id', 'Limit To User Group', 'required');

        if($this->input->post('limit_to') == 'custom')
            $this->form_validation->set_rules('limit_to_customers[]', 'Limit To Customers', 'required');

        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('apply_cashback_to', 'Apply Cashback To', 'required');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        $active = TRUE;

        if($_POST)
        {
            $active = $this->Cashback_model->get_active_dated_cashback($this->input->post(), $id);
        }

        if($this->form_validation->run() && $active == FALSE)
        {
            $data = $this->input->post();
            $result = $this->Cashback_model->update($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Cashback updated successfully');
                redirect('cashback/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the cashback');
                redirect('cashback/listing');
                exit;
            }
        }
        else
        {
            if($_POST && $active)
            {
                $data['message'] = "An active cashback already exists intersecting with the dates / products.";
            }
            else
            {
                $data['message'] = "";
            }

            $data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();
            $data['customers'] = $this->Customer_model->get_all_customers();
            $data['products'] = $this->Product_model->get_all_products();

            $data['tab'] = 'cashbacks';
            $data['title'] = 'Edit Cashback';
            $data['_view'] = 'admin/cashback/edit';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete($id = 0)
    {
        $this->authenticate(current_url());

        $data['cashback'] = $this->Cashback_model->get_cashback_by_id($id);

        if(empty($data['cashback']))
        {
            $this->session->set_flashdata('error_message', 'Cashback not found');
            redirect('cashback/listing');
            exit;
        }

        $result = $this->Cashback_model->update_keys($id, array('deleted' => 1));

        if($result)
        {
            $this->session->set_flashdata('success_message', 'Cashback deleted successfully');
            redirect('cashback/listing');
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the cashback');
            redirect('cashback/listing');
            exit;
        }
    }
}