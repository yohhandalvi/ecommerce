<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Email_model');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Customer_model');
        $this->load->model('Customer_address_model');
        $this->load->model('Wallet_model');
    }

    public function account()
    {
        if($this->customer['id'])
        {
            redirect('my-account');
            exit;
        }

        if(strtolower($this->input->post('type')) == 'register')
        {
            $this->form_validation->set_rules('r_first_name', 'First name', 'required|xss_clean');
            $this->form_validation->set_rules('r_last_name', 'Last name', 'required|xss_clean');
            $this->form_validation->set_rules('r_email', 'Email', 'required|valid_email|check_field[customers,email,deleted|0]|xss_clean');
            $this->form_validation->set_rules('r_password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('r_retype_password', 'Retype password', 'required|min_length[6]|matches[r_password]');
            $this->form_validation->set_rules('r_mobile', 'Mobile', 'check_field[customers,mobile,deleted|0]|xss_clean');
            $this->form_validation->set_rules('r_date_of_birth', 'Date of birth', 'xss_clean');
            $this->form_validation->set_rules('r_gender', 'Gender', 'xss_clean');
        }
        else
        {
            $this->form_validation->set_rules('l_email', 'Email', 'required|valid_email|xss_clean');
            $this->form_validation->set_rules('l_password', 'Password', 'required|md5');
        }

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('valid_email', '%s is invalid');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            if(strtolower($this->input->post('type')) == 'register')
            {
                $data = [
                    'first_name' => $this->input->post('r_first_name'),
                    'last_name' => $this->input->post('r_last_name'),
                    'full_name' => $this->input->post('r_first_name') . ' ' . $this->input->post('r_last_name'),
                    'email' => $this->input->post('r_email'),
                    'password' => md5($this->input->post('r_password')),
                    'mobile' => $this->input->post('r_mobile'),
                    'gender' => $this->input->post('r_gender'),
                    'date_of_birth' => $this->input->post('r_date_of_birth'),
                    'customer_group_id' => 1,
                    'newsletter' => $this->input->post('r_newsletter')
                ];

                $result = $this->Customer_model->add($data);

                if($result)
                {
                    $this->Email_model->send_registration_email($data['full_name'], $data['email']);
                    $this->Customer_model->set_user_session(['customer_id' => $result, 'customer_email' => $data['email']]);
                    redirect();
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while registering the account');
                    redirect('account');
                    exit;
                }
            }
            else
            {
                $result = $this->Customer_model->login($this->input->post('l_email'), $this->input->post('l_password'));

                if($result)
                {
                    if($this->input->get('redirect_to'))
                        redirect($this->input->get('redirect_to'));
                    else
                        redirect();

                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Invalid login credentials');
                    redirect('account');
                    exit;
                }
            }
        }
        else
        {
            $data['title'] = 'Account';
            $data['_view'] = 'front/customer/account';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function my_account()
    {
        $this->authenticate(current_url());

        $this->form_validation->set_rules('r_first_name', 'First name', 'required|xss_clean');
        $this->form_validation->set_rules('r_last_name', 'Last name', 'required|xss_clean');
        $this->form_validation->set_rules('r_mobile', 'Mobile', 'check_field[customers,mobile,deleted|0&id !=|'.$this->customer['id'].']|xss_clean');
        $this->form_validation->set_rules('r_date_of_birth', 'Date of birth', 'xss_clean');
        $this->form_validation->set_rules('r_gender', 'Gender', 'xss_clean');

        if(trim($this->input->post('r_password')) !== "" || trim($this->input->post('r_retype_password')) !== "")
        {
            $this->form_validation->set_rules('r_password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('r_retype_password', 'Retype password', 'required|min_length[6]|matches[r_password]');
        }

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('valid_email', '%s is invalid');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run())
        {
            $data = [
                'first_name' => $this->input->post('r_first_name'),
                'last_name' => $this->input->post('r_last_name'),
                'full_name' => $this->input->post('r_first_name') . ' ' . $this->input->post('r_last_name'),
                'mobile' => $this->input->post('r_mobile'),
                'gender' => $this->input->post('r_gender'),
                'date_of_birth' => $this->input->post('r_date_of_birth'),
                'newsletter' => $this->input->post('r_newsletter')
            ];

            if(trim($this->input->post('r_password')) !== "" || trim($this->input->post('r_retype_password')) !== "")
            {
                $data['password'] = md5($this->input->post('r_password'));
            }

            $result = $this->Customer_model->update($this->customer['id'], $data);

            if($result)
            {
                $this->session->set_flashdata('success_message', 'Account details updated successfully');
                redirect('my-account');
                exit;
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some error occured while updating the account details');
                redirect('my-account');
                exit;
            }
        }
        else
        {
            $data['customer'] = $this->Customer_model->get_customer_by_id($this->customer['id']);
            $data['orders'] = $this->Order_model->get_all_orders(null, null, ['customer_id' => $this->customer['id']]);
            $data['wishlist_products'] = $this->Product_model->get_all_products(null, null, ['wishlist' => $this->customer['id'], 'inactive' => 0]);
            $data['addresses'] = $this->Customer_address_model->get_all_customer_addresses(null, null, ['customer_id' => $this->customer['id']]);
            $data['wallet'] = $this->Wallet_model->get_customer_balance($this->customer['id']);
            $data['wallet_transactions'] = $this->Wallet_model->get_customer_transactions($this->customer['id']);

            $data['title'] = 'My Account';
            $data['_view'] = 'front/customer/my-account';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect();
        exit;
    }

    public function forgot_password()
    {
        if($this->customer['id'])
        {
            redirect('my-account');
            exit;
        }

        $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');

        $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

        if($this->form_validation->run())
        {
            $customer = $this->Customer_model->get_customer_by_params(['email' => $this->input->post('email')]);

            if(!empty($customer))
            {
                $forgot_password_key = random_string('alnum', 16);
                $this->Email_model->send_forgot_password_link($customer['full_name'], $customer['email'], $forgot_password_key);

                $data = [
                    'forgot_password_key' => $forgot_password_key
                ];

                $result = $this->Customer_model->update($customer['id'], $data);

                if($result)
                {
                    $this->session->set_flashdata('success_message', 'Reset password mail has been sent to your email');
                    redirect('forgot-password');
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while sending the reset password mail');
                    redirect('forgot-password');
                    exit;
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', 'This email is not registered with us');
                redirect('forgot-password');
                exit;
            }
        }
        else
        {
            $data['title'] = 'Forgot Password';
            $data['_view'] = 'front/customer/forgot-password';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function reset_password()
    {
        if($this->customer['id'])
        {
            redirect('my-account');
            exit;
        }

        $customer = $this->Customer_model->get_customer_by_params(['forgot_password_key' => $this->input->post('key')]);

        if(!empty($customer))
        {
            $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
            $this->form_validation->set_rules('retype_password', 'confirm password', 'required|min_length[6]|matches[password]');

            $this->form_validation->set_error_delimiters('<div class="text-danger p-2">', '</div>');

            if($this->form_validation->run())
            {
                $data = [
                    'forgot_password_key' => null,
                    'password' => md5($this->input->post('password'))
                ];

                $result = $this->Customer_model->update($customer['id'], $data);

                if($result)
                {
                    $this->session->set_flashdata('success_message', 'Password has been updated successfully');
                    redirect('account');
                    exit;
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while resetting the password');
                    redirect('forgot-password');
                    exit;
                }
            }
            else
            {
                $data['title'] = 'Reset Password';
                $data['_view'] = 'front/customer/reset-password';
                $this->load->view('front/layout/basetemplate', $data);
            }
        }
        else
        {
            redirect();
            exit;
        }
    }
}