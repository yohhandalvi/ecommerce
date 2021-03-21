<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Discount_model');
        $this->load->model('Product_model');
        $this->load->model('Customer_model');
        $this->load->model('Customer_group_model');
    }

    public function listing($page = 0)
    {
        $this->authenticate(current_url());

        $filters = $this->input->get();

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['discounts'] = $this->Discount_model->get_all_discounts(ROWS_PER_LISTING, $offset, $filters);
        $data['count'] = $this->Discount_model->count_all_discounts($filters);
        $data['total'] = $this->Discount_model->count_all_discounts();
        $data['pagination'] = pagination(site_url('discount/listing'), $data['count'], ROWS_PER_LISTING);

        $data['tab'] = 'discounts';
        $data['title'] = 'Discount Listing';
        $data['_view'] = 'admin/discount/listing';
        $this->load->view('admin/layout/basetemplate', $data);
    }

    public function add() 
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required');
        $this->form_validation->set_rules('limit_to', 'Limit To', 'required');

        if($this->input->post('limit_to') == 'user_group')
            $this->form_validation->set_rules('limit_to_customer_group_id', 'Limit To User Group', 'required');

        if($this->input->post('limit_to') == 'custom')
            $this->form_validation->set_rules('limit_to_customers[]', 'Limit To Customers', 'required');

        $this->form_validation->set_rules('valid_from_date', 'From Date', 'required');
        $this->form_validation->set_rules('valid_to_date', 'To Date', 'required');
        $this->form_validation->set_rules('min_cart_value', 'Minimum Cart Value', 'required');
        $this->form_validation->set_rules('cart_amount_exclude_tax', 'Exclude Tax', 'required');
        $this->form_validation->set_rules('cart_amount_exclude_shipping', 'Exclude Shipping', 'required');
        $this->form_validation->set_rules('available', 'Total Available', 'required');
        $this->form_validation->set_rules('available_for_single_user', 'Total Available for 1 User', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('discount_tax_excluded', 'Exclude Tax', 'required');
        $this->form_validation->set_rules('discount_shipping_excluded', 'Exclude Shipping', 'required');
        $this->form_validation->set_rules('apply_discount_to', 'Apply Discount To', 'required');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Discount_model->add($data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Discount added successfully');
                redirect('discount/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while adding the discount');
                redirect('discount/listing');
                exit;
            }
        }
        else
        {
            $data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();
            $data['customers'] = $this->Customer_model->get_all_customers();
            $data['products'] = $this->Product_model->get_all_products();

            $data['tab'] = 'discounts';
            $data['title'] = 'Add Discount';
            $data['_view'] = 'admin/discount/add';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function edit($id = 0)
    {
        $this->authenticate(current_url());

        $data['discount'] = $this->Discount_model->get_discount_by_id($id);

        if(empty($data['discount']))
        {
            $this->session->set_flashdata('error_message', 'Discount not found');
            redirect('discount/listing');
            exit;
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required');
        $this->form_validation->set_rules('limit_to', 'Limit To', 'required');

        if($this->input->post('limit_to') == 'user_group')
            $this->form_validation->set_rules('limit_to_customer_group_id', 'Limit To User Group', 'required');

        if($this->input->post('limit_to') == 'custom')
            $this->form_validation->set_rules('limit_to_customers[]', 'Limit To Customers', 'required');

        $this->form_validation->set_rules('valid_from_date', 'From Date', 'required');
        $this->form_validation->set_rules('valid_to_date', 'To Date', 'required');
        $this->form_validation->set_rules('min_cart_value', 'Minimum Cart Value', 'required');
        $this->form_validation->set_rules('cart_amount_exclude_tax', 'Exclude Tax', 'required');
        $this->form_validation->set_rules('cart_amount_exclude_shipping', 'Exclude Shipping', 'required');
        $this->form_validation->set_rules('available', 'Total Available', 'required');
        $this->form_validation->set_rules('available_for_single_user', 'Total Available for 1 User', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');
        $this->form_validation->set_rules('discount_tax_excluded', 'Exclude Tax', 'required');
        $this->form_validation->set_rules('discount_shipping_excluded', 'Exclude Shipping', 'required');
        $this->form_validation->set_rules('apply_discount_to', 'Apply Discount To', 'required');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = $this->input->post();
            $result = $this->Discount_model->update($id, $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Discount updated successfully');
                redirect('discount/listing');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the discount');
                redirect('discount/listing');
                exit;
            }
        }
        else
        {
            $data['customer_groups'] = $this->Customer_group_model->get_all_customer_groups();
            $data['customers'] = $this->Customer_model->get_all_customers();
            $data['products'] = $this->Product_model->get_all_products();

            $data['tab'] = 'discounts';
            $data['title'] = 'Edit Discount';
            $data['_view'] = 'admin/discount/edit';
            $this->load->view('admin/layout/basetemplate', $data);
        }
    }

    public function delete($id = 0)
    {
        $this->authenticate(current_url());

        $data['discount'] = $this->Discount_model->get_discount_by_id($id);

        if(empty($data['discount']))
        {
            $this->session->set_flashdata('error_message', 'Discount not found');
            redirect('discount/listing');
            exit;
        }

        $result = $this->Discount_model->update_keys($id, array('deleted' => 1));

        if($result)
        {
            $this->session->set_flashdata('success_message', 'Discount deleted successfully');
            redirect('discount/listing');
            exit;
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Some error occured while deleting the discount');
            redirect('discount/listing');
            exit;
        }
    }
}