<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Product_stock_model');
    }

    public function index()
    {
        $this->form_validation->set_rules('items[]', 'Items', 'required|xss_clean');

        if($this->form_validation->run())
        {
            if($this->input->post('discount_code'))
            {
                $discount_code = $this->input->post('discount_code');
                $valid = $this->Discount_model->validate_discount($discount_code);

                if($valid) {
                    $_SESSION['shopping_cart_discount_code'] = $discount_code;
                    $this->session->set_flashdata('success_message', 'Coupon code applied successfully!');
                } else {
                    $this->session->set_flashdata('error_message', 'Invalid coupon code!');
                }
            }

            $_SESSION['shopping_cart'] = [];

            if(!empty($this->input->post('items')))
            {
                foreach ($this->input->post('items') as $product_id => $quantity)
                {
                    for($i = 0; $i < $quantity; $i++)
                    {
                        @$_SESSION['shopping_cart'][] = (int) $product_id;
                    }
                }
            }

            @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->expiry_time);

            redirect('cart');
            exit;
        }
        else
        {
            $cart = $this->shopping_cart->get_cart();
            $data['check_stock'] = $this->Product_stock_model->check_stock($cart['items']);

            $data['title'] = 'My Cart';
            $data['_view'] = 'front/cart/index';
            $this->load->view('front/layout/basetemplate', $data);
        }
    }

    public function remove_discount()
    {
        if(isset($_SESSION['shopping_cart_discount_code']))
            unset($_SESSION['shopping_cart_discount_code']);

        redirect('cart');
        exit;
    }

    public function manage()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->shopping_cart->manage();
    }


    public function remove()
    {
        $redirect = ($this->input->get('back-to')) ? $this->input->get('back-to') : $_SERVER['HTTP_REFERER'];
        $this->shopping_cart->remove();
        $this->session->set_flashdata('success', 'Product removed from cart!');
        redirect($redirect);
    }

    public function clear()
    {
        $this->shopping_cart->clear();
    }
}