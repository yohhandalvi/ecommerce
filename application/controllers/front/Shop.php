<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Cashback_model');
    }

    public function index()
    {
        $filters = $this->input->get();

        $filters['inactive'] = 0;

        if(!$this->input->get('sort') || trim($this->input->get('sort')) == "")
        {
            $filters['sort'] = 'sort=asc';
        }

        if($this->input->get('price') && trim($this->input->get('price')) != "")
        {
            $price_filter = $filters['price'];
            unset($filters['price']);

            $price_data = explode(" - ", $price_filter);

            if(!empty($price_data) && count($price_data) == 2)
            {
                $filters['from_price'] = trim($price_data[0], CURRENCY_CODE." ");
                $filters['to_price'] = trim($price_data[1], CURRENCY_CODE." ");
            }
        }

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['products'] = $this->Product_model->get_all_products(SHOP_LISTING, $offset, $filters);
        $data['count'] = $this->Product_model->count_all_products($filters);
        $data['pagination'] = pagination(site_url('shop'), $data['count'], SHOP_LISTING, 'front');

        if(!empty($data['products']))
        {
            foreach ($data['products'] as $key => $product)
            {
                $data['products'][$key]['cashback'] = $this->Cashback_model->get_valid_cashback($product['id']);
            }
        }

        $data['categories'] = $this->Category_model->get_all_categories(null, null);
        $data['min'] = $this->Product_model->get_min_price_from_products();
        $data['max'] = $this->Product_model->get_max_price_from_products();

        $data['tab'] = 'shop';
        $data['title'] = 'Shop';
        $data['_view'] = 'front/shop/index';
        $this->load->view('front/layout/basetemplate', $data);
    }

    public function ajax()
    {
        $filters = $this->input->get();

        $filter['inactive'] = 1;

        if($this->input->get('price') && trim($this->input->get('price')) != "")
        {
            $price_data = explode("-", $this->input->get('price'));
            $filter['price_from'] = (isset($price_data[0]) && is_numeric($price_data[0])) ? $price_data[0] : null;
            $filter['price_to'] = (isset($price_data[1]) && is_numeric($price_data[1])) ? $price_data[1] : null;
        }

        $offset = ($this->input->get('page')) ? $this->input->get('page') : 0;
        $data['products'] = $this->Product_model->get_all_products(SHOP_LISTING, $offset, $filters);
        $data['count'] = $this->Product_model->count_all_products($filters);
        $response['html'] = $this->load->view('front/shop/_products', $data, true);

        $next = $this->Product_model->get_all_products(1, $offset + count($data['products']), $filters);
        $response['more'] = empty($next) ? false : true;
        echo json_encode($response);exit;
    }
}