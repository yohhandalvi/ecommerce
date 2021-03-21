<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         Zephyr Sales
 * @category        BaseController
 * @author          Yohhan Dalvi
 */
class BaseController extends CI_Controller {

	public $currency_id = 1;
	public $currency_code = null;
	public $currency_tax = null;
    public $country = null;

    public function __construct()
	{
		// main constructor
		parent::__construct();

		$this->load->model('Currency_model');
		$currency = $this->Currency_model->get_currency_by_id($this->currency_id);

		if(!empty($currency))
		{
			$this->currency_code = $currency['symbol'];
			$this->currency_tax = $currency['tax'];
		}
	}

}


require('AdminController.php');
require('SiteController.php');