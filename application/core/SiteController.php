<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         WeddingSutra
 * @subpackage      Site
 * @category        SiteController
 * @author          Yohhan Dalvi
 */
class SiteController extends BaseController {

	public $customer;

	public function __construct()
	{
		// main constructor
		parent::__construct();

		if($this->session->userdata('customer_id'))
			$this->customer['id'] = $this->session->userdata('customer_id');

		if($this->session->userdata('customer_email'))
			$this->customer['email'] = $this->session->userdata('customer_email');

		if (is_null(get_cookie('user_country')))
		{
            $this->country = ip_visitor_country();

            $cookie = array(
                'name'   => 'user_country',
                'value'  => $this->country,
                'expire' => time()+31557600
            );
            set_cookie($cookie);
        }
        else
        {
            $this->country = get_cookie('user_country');
        }

        $currency = $this->Currency_model->get_currency_by_country_code($this->country);

        if(!empty($currency))
        {
        	$this->currency_id = $currency['id'];
        	$this->currency_code = $currency['symbol'];
			$this->currency_tax = $currency['tax'];
        }

		$this->set_vars();
	}

	public function set_vars()
	{
		$this->load->model('Category_model');
		$vars['nav_categories'] = $this->Category_model->get_nav_categories();
		$vars['cart'] = $this->shopping_cart->get_cart();
		$this->load->vars($vars);
	}

	public function authenticate($redirect_to = null, $check_permission = true)
	{
		if($this->customer['id']) {
			return TRUE;
		} else {
			if(is_null($redirect_to)) {
				$url = site_url();
			} else {
				$url = site_url('account?redirect_to='.urlencode($redirect_to));
			}
			redirect($url);
		}
	}

}