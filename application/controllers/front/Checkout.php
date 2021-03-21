<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Email_model');
        $this->load->model('Order_model');
        $this->load->model('State_model');
        $this->load->model('Wallet_model');
        $this->load->model('Country_model');
        $this->load->model('Customer_model');
        $this->load->model('Product_stock_model');
        $this->load->model('Customer_address_model');
    }

    public function index()
    {
        if(isset($_POST['apply']))
        {
            $discount_code = $this->input->post('discount_code');
            $valid = $this->Discount_model->validate_discount($discount_code);

            if($valid) {
                $_SESSION['shopping_cart_discount_code'] = $discount_code;
                $this->session->set_flashdata('success_message', 'Coupon code applied successfully!');
            } else {
                $this->session->set_flashdata('error_message', 'Invalid coupon code!');
            }

            redirect('checkout');
            exit;
        }
        else
        {
            if($this->customer['id'])
            {
                $this->form_validation->set_rules('billing_customer_address_id', 'Billing address', 'required');
                $this->form_validation->set_rules('shipping_customer_address_id', 'Shipping address', 'required');
            }
            else
            {
                $this->form_validation->set_rules('first_name', 'First name', 'required');
                $this->form_validation->set_rules('last_name', 'Last name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[customers.email]');
                $this->form_validation->set_rules('billing[name]', 'Address name', 'required');
                $this->form_validation->set_rules('billing[pin_code]', 'Pin code', 'required');
                $this->form_validation->set_rules('billing[address_line_1]', 'Address line 1', 'required');
                $this->form_validation->set_rules('billing[city]', 'City', 'required');
                $this->form_validation->set_rules('billing[state_id]', 'State', 'required');
                $this->form_validation->set_rules('billing[country_id]', 'Country', 'required');

                if($this->input->post('different_shipping'))
                {
                    $this->form_validation->set_rules('shipping[name]', 'Address name', 'required');
                    $this->form_validation->set_rules('shipping[pin_code]', 'Pin code', 'required');
                    $this->form_validation->set_rules('shipping[address_line_1]', 'Address line 1', 'required');
                    $this->form_validation->set_rules('shipping[city]', 'City', 'required');
                    $this->form_validation->set_rules('shipping[state_id]', 'State', 'required');
                    $this->form_validation->set_rules('shipping[country_id]', 'Country', 'required');
                }
            }
        }

        $this->form_validation->set_rules('terms', 'Terms & conditions', 'required');
        $this->form_validation->set_rules('payment', 'Payment', 'required');
        $this->form_validation->set_rules('use_wallet_balance', 'Use Wallet Balance', 'trim');

        $this->form_validation->set_message('required', '%s is required');
        $this->form_validation->set_message('valid_email', '%s is invalid');
        $this->form_validation->set_error_delimiters('<div class="text-danger d-block">', '</div>');

        $this->form_validation->set_message('is_unique', 'This email is already registered with us, please login to continue.');

        if($this->form_validation->run())
        {
            $cart = $this->shopping_cart->get_cart();
            $check_stock = $this->Product_stock_model->check_stock($cart['items']);

            if($check_stock)
            { 
                $data = $this->input->post();

                if($this->customer['id'])
                {
                    $data['customer_id'] = $this->customer['id'];
                }
                else
                {
                    $random_password = random_string('alnum', 12);

                    $customer = [
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'full_name' => $data['first_name'] . " " . $data['last_name'],
                        'email' => $data['email'],
                        'password' => md5($random_password),
                        'mobile' => $data['mobile'],
                        'customer_group_id' => 1
                    ];

                    $data['customer_id'] = $this->Customer_model->add($customer);

                    $this->Email_model->send_registration_email($customer['full_name'], $customer['email'], $random_password);

                    $billing_address = $this->input->post('billing');

                    $billing_address['is_default'] = 1;
                    $billing_address['customer_id'] = $data['customer_id'];
                    $billing_address['type'] = 'billing';

                    $data['billing_customer_address_id'] = $this->Customer_address_model->add($billing_address);

                    if($this->input->post('different_shipping'))
                    {
                        $shipping_address = $this->input->post('shipping');

                        $shipping_address['is_default'] = 1;
                        $shipping_address['customer_id'] = $data['customer_id'];
                        $shipping_address['type'] = 'shipping';

                        $data['shipping_customer_address_id'] = $this->Customer_address_model->add($shipping_address);
                    }
                    else
                    {
                        $data['shipping_customer_address_id'] = $data['billing_customer_address_id'];
                    }
                }

                if(isset($_SESSION['shopping_cart_discount_code']))
                {
                    $discount_code = $_SESSION['shopping_cart_discount_code'];
                    $valid = $this->Discount_model->validate_discount($discount_code);

                    if($valid)
                    {
                        $discount = $this->Discount_model->get_discount_by_params(['code' => $discount_code]);
                        $data['discount_id'] = $discount['id'];
                        $data['discount_code'] = $ddiscount_code;
                        $data['discount_amount'] = $this->Discount_model->calculate_discount_amount($discount, $cart);
                        unset($_SESSION['shopping_cart_discount_code']);
                    }
                }

                $data['wallet_paid_amount'] = 0;

                if($this->customer['id'] && $this->input->post('wallet') && $this->input->post('wallet') == 1)
                {
                    $wallet_balance = $this->Wallet_model->get_customer_balance($this->customer['id']);

                    if($wallet_balance)
                    {
                        if(isset($cart['total']) && $cart['total'] < $wallet_balance)
                        {
                            $data['wallet_paid_amount'] = $cart['total'];
                        }
                        else
                        {
                            $data['wallet_paid_amount'] = $wallet_balance;
                        }
                    }
                }

                $order_id = $this->Order_model->add($data, $cart);
                    
                if($order_id)
                {
                    $this->shopping_cart->clear();
                    $this->payment($order_id);
                }
                else
                {
                    $this->session->set_flashdata('error_message', 'Some error occured while placing your order');
                    redirect('checkout/error');
                    exit;
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', 'Some of the products are not available as per your selection, please revise the cart and proceed.');
                redirect('cart');
                exit;
            }
        }
        else
        {
            if($this->customer['id'])
            {
                $data['billing_addresses'] = $this->Customer_address_model->get_all_customer_addresses(null, null, ['customer_id' => $this->customer['id'], 'type' => 'billing']);
                $data['shipping_addresses'] = $this->Customer_address_model->get_all_customer_addresses(null, null, ['customer_id' => $this->customer['id'], 'type' => 'shipping']);
                $data['wallet_balance'] = $this->Wallet_model->get_customer_balance($this->customer['id']);
            }
            else
            {
                $data['states'] = $this->State_model->get_all_states();
                $data['countries'] = $this->Country_model->get_all_countries();
                $data['wallet_balance'] = 0;
            }

            $data['title'] = 'Checkout';
            $data['_view'] = 'front/checkout/index';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function payment($order_id)
    {
        $order = $this->Order_model->get_order_by_id($order_id);
        $customer = $this->Customer_model->get_customer_by_id($order['customer_id']);

        switch ($order['payment'])
        {
            case 'cod':
                $this->Email_model->send_order_email($order_id, 'placed');
                $this->session->set_userdata('order_id', $order_id);
                $data['status'] = 'placed';
                $this->Order_model->update($order_id, $data);
                redirect('checkout/confirm');
                exit;
                break;

            default:
                $this->session->set_flashdata('error_message', 'Error occured while processing your payment!');
                redirect('checkout/error');
                exit;
                break;
        }
    }

    public function error()
    {
        $data['title'] = 'Checkout - Order Error';
        $data['_view'] = 'front/checkout/error';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function confirm()
    {
        if($this->session->userdata('order_id'))
        {
            $order_id = $this->session->userdata('order_id');

            $data['order'] = $this->Order_model->get_order_by_id($order_id);

            if(empty($data['order']))
            {
                $this->session->set_flashdata('error_message', 'Order not found!');
                redirect('checkout/error');
                exit;
            }

            $data['order_items'] = $this->Order_model->get_order_items($order_id);

            $data['title'] = 'Checkout - Order Confirm';
            $data['_view'] = 'front/checkout/confirm';
            $this->load->view('front/layout/basetemplate', $data);
        }
        else
        {
            $this->session->set_flashdata('error_message', 'Order not found!');
            redirect('checkout/error');
            exit;
        }
    }
}