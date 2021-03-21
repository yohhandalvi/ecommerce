<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Shopping Cart class for manage products
 */

class Shopping_cart
{

    protected $ci;
    // public $sumValues;
    /*
     * 1 month expire time
     */
    private $expiry_time = 2678400;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('Product_model');
        $this->ci->load->model('Discount_model');
        $this->ci->load->model('Cashback_model');
        $this->ci->load->model('Shipping_rate_model');
    }

    public function manage()
    {
        if($this->ci->input->post('action') == 'add')
        {
            $quantity = ($this->ci->input->post('quantity')) ? (int) $this->ci->input->post('quantity') : 1;

            if(!isset($_SESSION['shopping_cart']))
            {
                $_SESSION['shopping_cart'] = [];
            }

            for($i = 0; $i < $quantity; $i++)
            {
                @$_SESSION['shopping_cart'][] = (int) $this->ci->input->post('product_id');
            }
        }

        if($this->ci->input->post('action') == 'remove')
        {
            if(($key = array_search($this->ci->input->post('product_id'), $_SESSION['shopping_cart'])) !== false)
            {
                $_SESSION['shopping_cart'] = array_diff($_SESSION['shopping_cart'], [$this->ci->input->post('product_id')]);
            }
        }

        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->expiry_time);

        $result = null;

        if (!empty($_SESSION['shopping_cart']))
        {
            $result = $this->get_cart();
        }

        echo json_encode($result);
    }

    public function remove()
    {
        $i = 1;
        $count = count(array_keys($_SESSION['shopping_cart'], $_GET['delete-product']));

        do {
            if (($key = array_search($this->input->get('delete-product'), $_SESSION['shopping_cart'])) !== false) {
                unset($_SESSION['shopping_cart'][$key]);
            }
            $i++;
        } while ($i <= $count);

        @set_cookie('shopping_cart', serialize($_SESSION['shopping_cart']), $this->expiry_time);
    }

    public function get_cart()
    {
        if((!isset($_SESSION['shopping_cart']) || empty($_SESSION['shopping_cart'])) && get_cookie('shopping_cart') != NULL)
        {
            $_SESSION['shopping_cart'] = unserialize(get_cookie('shopping_cart'));
        } 
        else if(!isset($_SESSION['shopping_cart']) || !is_array($_SESSION['shopping_cart']))
        {
            return 0;
        }

        $result['items'] = $this->ci->Product_model->get_all_products(null, null, ['include_ids' => array_unique($_SESSION['shopping_cart'])]);

        if(empty($result['items']))
        {
            unset($_SESSION['shopping_cart']);
            @delete_cookie('shopping_cart');
            return 0;
        }

        // check for discount
        $discount_code = null;
        $discount_amount = 0;

        if(isset($_SESSION['shopping_cart_discount_code']))
        {
            $discount_code = $_SESSION['shopping_cart_discount_code'];
        }

        $count = array_count_values($_SESSION['shopping_cart']);

        $subtotal = 0;
        $shipping_amount = 0;
        $cashback_amount = 0;

        $cashbacks_applied = [];

        foreach ($result['items'] as &$item)
        {
            $cashback = $this->ci->Cashback_model->get_valid_cashback($item['id']);

            $item['quantity'] = $count[$item['id']];
            $item['price'] = $item['price'] == '' ? 0 : $item['price'];
            $item['price_excl_tax'] = $item['price_excl_tax'] == '' ? 0 : $item['price_excl_tax'];
            $item['gst_rate'] = $item['gst_rate'] == '' ? 0 : $item['gst_rate'];
            $item['shipping_amount'] = $item['additional_shipping_cost'] == '' ? 0 : $item['additional_shipping_cost'];
            $item['total'] = $item['price'] * $count[$item['id']];
            $item['total_cashback'] = 0;

            if(!empty($cashback))
            {
                if($cashback['type'] == 'amount')
                {
                    $item['total_cashback'] = $cashback['value'] * $count[$item['id']];
                }
                else
                {
                    $cashback_percent_value = ($item['price'] * $cashback['value']) / 100;
                    $item['total_cashback'] = $cashback_percent_value * $count[$item['id']];
                }

                $item['total_cashback'] = ($cashback['max_value'] > 0 && $cashback['max_value_on_total_order'] == 0 && $item['total_cashback'] > $cashback['max_value']) ? $cashback['max_value'] : $item['total_cashback'];

                $cashbacks_applied[] = $cashback['id'];
            }

            $subtotal = $subtotal + $item['total'];
            $shipping_amount = $shipping_amount + $item['shipping_amount'];
            $cashback_amount = $cashback_amount + $item['total_cashback'];
        }

        $cashback_amount = ($cashback['max_value'] > 0 && $cashback['max_value_on_total_order'] == 1 && $cashback_amount > $cashback['max_value']) ? $cashback['max_value'] : $cashback_amount;

        $shipping_amount += $this->ci->Shipping_rate_model->get_cart_shipping_rate($subtotal);
        $result['discount_code'] = $discount_code;
        $result['subtotal'] = $subtotal;
        $result['shipping_amount'] = $shipping_amount;
        $result['cashback_amount'] = $cashback_amount;
        $result['cashbacks_applied'] = array_unique($cashbacks_applied);
        $result['discount_amount'] = 0;

        if($discount_code)
        {
            $discount = $this->ci->Discount_model->get_discount_by_params(['code' => $discount_code]);

            if(!empty($discount))
            {
                $result['discount_amount'] = $this->ci->Discount_model->calculate_discount_amount($discount, $result);
            }
        }

        $result['total'] = $subtotal + $shipping_amount - $result['discount_amount'];
        $result['total_with_currency'] = show_price($result['total']);
        $result['total_items'] = count($result['items']);

        return $result;
    }

    public function clear()
    {
        unset($_SESSION['shopping_cart']);
        @delete_cookie('shopping_cart');
    }
}