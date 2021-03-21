<?php

class Discount_model extends CI_Model {
 
	public function add($data)
	{
		$discount = [
       		'name' => $data['name'],
        	'code' => trim($data['code']),
            'description' => trim($data['description']),
            'limit_to' => $data['limit_to'],
            'limit_to_customer_group_id' => (isset($data['limit_to_customer_group_id']) && $data['limit_to'] == 'user_group') ? @$data['limit_to_customer_group_id'] : 0,
            'valid_from_date' => $data['valid_from_date'],
            'valid_to_date' => $data['valid_to_date'],
            'min_cart_value' => @$data['min_cart_value'],
            'cart_amount_exclude_tax' => isset($data['cart_amount_exclude_tax']) ? @$data['cart_amount_exclude_tax'] : 0,
            'cart_amount_exclude_shipping' => isset($data['cart_amount_exclude_shipping']) ? @$data['cart_amount_exclude_shipping'] : 0,
            'available' => @$data['available'],
            'available_for_single_user' => @$data['available_for_single_user'],
            'type' => $data['type'],
            'value' => @$data['value'],
            'discount_tax_excluded' => isset($data['discount_tax_excluded']) ? @$data['discount_tax_excluded'] : 0,
            'discount_shipping_excluded' => isset($data['discount_shipping_excluded']) ? @$data['discount_shipping_excluded'] : 0,
            'apply_discount_to' => @$data['apply_discount_to'],
            'inactive' => @$data['inactive']
        ];

		$this->db->insert('discounts', $discount); 
		$discount_id = $this->db->insert_id();

		if(isset($data['limit_to']) && $data['limit_to'] == 'custom' && !empty($data['limit_to_customers'])) {
            $this->db->delete('discount_for_customers', array('discount_id' => $discount_id));
            foreach ($data['limit_to_customers'] as $key => $limit_to_customer) {
                $this->db->insert('discount_for_customers', array(
                    'discount_id' => $discount_id,
                    'customer_id' => $limit_to_customer
                ));
            }
        }

        if(isset($data['apply_discount_to']) && $data['apply_discount_to'] == 'custom' && !empty($data['apply_to_products'])) {
            $this->db->delete('discount_for_products', array('discount_id' => $discount_id));
            foreach ($data['apply_to_products'] as $key => $apply_to_product) {
                $this->db->insert('discount_for_products', array(
                    'discount_id' => $discount_id,
                    'product_id' => $apply_to_product
                ));
            }
        }

        return $discount_id;
	}

	public function update($id, $data)
	{
		$discount = [
       		'name' => $data['name'],
        	'code' => trim($data['code']),
            'description' => trim($data['description']),
            'limit_to' => $data['limit_to'],
            'limit_to_customer_group_id' => (isset($data['limit_to_customer_group_id']) && $data['limit_to'] == 'user_group') ? @$data['limit_to_customer_group_id'] : 0,
            'valid_from_date' => $data['valid_from_date'],
            'valid_to_date' => $data['valid_to_date'],
            'min_cart_value' => @$data['min_cart_value'],
            'cart_amount_exclude_tax' => isset($data['cart_amount_exclude_tax']) ? @$data['cart_amount_exclude_tax'] : 0,
            'cart_amount_exclude_shipping' => isset($data['cart_amount_exclude_shipping']) ? @$data['cart_amount_exclude_shipping'] : 0,
            'available' => @$data['available'],
            'available_for_single_user' => @$data['available_for_single_user'],
            'type' => $data['type'],
            'value' => @$data['value'],
            'discount_tax_excluded' => isset($data['discount_tax_excluded']) ? @$data['discount_tax_excluded'] : 0,
            'discount_shipping_excluded' => isset($data['discount_shipping_excluded']) ? @$data['discount_shipping_excluded'] : 0,
            'apply_discount_to' => @$data['apply_discount_to'],
            'inactive' => @$data['inactive']
        ];

        $this->db->where('id', $id);
		$result = $this->db->update('discounts', $discount);

		if(isset($data['limit_to']) && $data['limit_to'] == 'custom' && !empty($data['limit_to_customers'])) {
            $this->db->delete('discount_for_customers', array('discount_id' => $id));
            foreach ($data['limit_to_customers'] as $key => $limit_to_customer) {
                $this->db->insert('discount_for_customers', array(
                    'discount_id' => $id,
                    'customer_id' => $limit_to_customer
                ));
            }
        }

        if(isset($data['apply_discount_to']) && $data['apply_discount_to'] == 'custom' && !empty($data['apply_to_products'])) {
            $this->db->delete('discount_for_products', array('discount_id' => $id));
            foreach ($data['apply_to_products'] as $key => $apply_to_product) {
                $this->db->insert('discount_for_products', array(
                    'discount_id' => $id,
                    'product_id' => $apply_to_product
                ));
            }
        }

        return $result;
	}

	public function update_keys($id, $data)
	{
		return $this->db->update('discounts', $data, array('id' => $id));
	}

	public function get_all_discounts($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('d.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('d.id', $params['search'], 'both');
			$this->db->or_like('d.name', $params['search'], 'both');
			$this->db->or_like('d.code', $params['search'], 'both');
			$this->db->group_end();
		}

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('d.*');

		$this->db->from('discounts d');
		$this->db->where('d.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'd.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'd.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('d.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

    public function get_discount_by_id($id)
    {
        $this->db->select('d.*, GROUP_CONCAT(dfc.customer_id) as limit_to_customers, GROUP_CONCAT(dfr.product_id) as apply_to_products');
        $this->db->from('discounts d');
        $this->db->join('discount_for_customers dfc', 'dfc.discount_id = d.id', 'left');
        $this->db->join('discount_for_products dfr', 'dfr.discount_id = d.id', 'left');
        $this->db->where('d.deleted', 0);
        $this->db->where('d.id', $id);
        return $this->db->get()->row_array();
    }

	public function get_discount_by_params($params = null)
	{
        if(!empty($params['code']))
            $this->db->where('d.code', $params['code']);

		$this->db->select('d.*, GROUP_CONCAT(dfc.customer_id) as limit_to_customers, GROUP_CONCAT(dfr.product_id) as apply_to_products');
		$this->db->from('discounts d');
		$this->db->join('discount_for_customers dfc', 'dfc.discount_id = d.id', 'left');
        $this->db->join('discount_for_products dfr', 'dfr.discount_id = d.id', 'left');
		$this->db->where('d.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function count_all_discounts($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('d.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('d.id', $params['search'], 'both');
			$this->db->or_like('d.name', $params['search'], 'both');
			$this->db->or_like('d.code', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->where('d.deleted', 0);
		return $this->db->count_all_results('discounts d');
	}

    public function get_used_discount_codes($id)
    {
        $this->db->where('discount_id', $id);
        return $this->db->count_all_results('orders');
    }

    public function get_customer_used_discount_codes($customer_id, $id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('discount_id', $id);
        return $this->db->count_all_results('orders');
    }

    public function calculate_discount_amount($discount, $cart)
    {
        $price = 0;
        $discount_amount = 0;
        $shipping_amount = 0;

        if($discount['discount_tax_excluded'] == 0) {
            $price_column = 'price';
        } else {
            $price_column = 'price_excl_tax';
        }

        if($discount['apply_discount_to'] == 'total_order') {
            if(!empty($cart['items'])) {
                foreach ($cart['items'] as $key => $item) {
                    $price += $item[$price_column] * $item['quantity'];
                }
            }
            if($discount['discount_shipping_excluded'] == 0) {
                $price += $shipping_amount;
                if(!empty($cart['items'])) {
                    foreach ($cart['items'] as $key => $item) {
                        $price += $item['additional_shipping_cost'];
                    }
                }
            }
        } else if($discount['apply_discount_to'] == 'cheapest_product') {
            if(!empty($cart['items'])) {
                $lowest_price = 0;
                $shipping_amount = 0;
                foreach ($cart['items'] as $key => $item) {
                    if($lowest_price == 0) {
                        $lowest_price = $item[$price_column];
                        $shipping_amount = $item['additional_shipping_cost'];
                    }
                    if($item[$price_column] < $lowest_price) {
                        $lowest_price = $item[$price_column];
                        $shipping_amount = $item['additional_shipping_cost'];
                    }
                }
                $price = $lowest_price * $item['quantity'];
                if($discount['discount_shipping_excluded'] == 0) {
                    $price += $shipping_amount;
                }
            }
        } else if($discount['apply_discount_to'] == 'custom' && !empty($discount['apply_to_products'])) {
            if(!empty($cart['items'])) {
                $highest_price = 0;
                $shipping_amount = 0;
                foreach ($cart['items'] as $key => $item) {
                    if(in_array($item['id'], explode(",", $discount['apply_to_products']))) {
                        if($highest_price == 0) {
                            $highest_price = $item[$price_column];
                            $shipping_amount = $item['additional_shipping_cost'];
                        }
                        if($item[$price_column] > $highest_price) {
                            $highest_price = $item[$price_column];
                            $shipping_amount = $item['additional_shipping_cost'];
                        }
                    }
                }
                $price = $highest_price * $item['quantity'];
                if($discount['discount_shipping_excluded'] == 0) {
                    $price += $shipping_amount;
                }
            }
        }

        if($discount['value'] > 0) {
            if($discount['type'] == 'percent') {
                $discount_amount = round(($price * $discount['value']) / 100, 2);
            } else if ($discount['type'] == 'amount') {
                $discount_amount = $discount['value'];
            }
        }

        return $discount_amount;
    }

    public function validate_discount($discount_code)
    {
        $valid = false;
        $discount = $this->get_discount_by_params(['code' => $discount_code]);
        $cart = $this->shopping_cart->get_cart();

        $valid = $this->check_if_valid_date($discount);
        $valid = ($valid && $this->check_if_valid_limitation($discount));
        $valid = ($valid && $this->check_if_valid_cart_value($discount, $cart));
        $valid = ($valid && $this->check_if_valid_availability($discount));
        $valid = ($valid && $this->check_if_valid_restriction($discount));
        return $valid;
    }

    private function check_if_valid_date($discount)
    {
        $time = strtotime(date('Y-m-d'));

        if($time >= strtotime($discount['valid_from_date']) && $time <= strtotime($discount['valid_to_date'])) {
            return true;
        }

        return false;
    } 

    private function check_if_valid_limitation($discount)
    {
        $return = false;

        if($discount['limit_to'] == "all") {
            $return = true;
        } else {
            if($this->customer['id']) {
                $this->load->model('Customer_model');
                $customer = $this->Customer_model->get_customer_by_id($this->customer['id']);
                if($discount['limit_to'] == "user_group" && $customer['customer_group_id'] >= $discount['limit_to_customer_group_id']) {
                    $return = true;
                } else if($discount['limit_to'] == "custom" && in_array($customer['id'], explode(",", $discount['limit_to_customers']))) {
                    $return = true;
                }
            } else {
                $return = true;
            }
        }

        return $return;
    }

    private function check_if_valid_cart_value($discount, $cart)
    {
        $return = true;

        if($discount['min_cart_value'] > 0) {

            $price = 0;
            $shipping_amount = 0;

            if($discount['cart_amount_exclude_tax'] == 0) {
                $price_column = 'price';
            } else {
                $price_column = 'price_excl_tax';
            }

            if(!empty($cart['items'])) {
                foreach ($cart['items'] as $key => $cart_item) {
                    $price += $cart_item[$price_column] * $cart_item['quantity'];
                }
            }

            if($discount['cart_amount_exclude_shipping'] == 0) {
                $price += $shipping_amount;
                if(!empty($cart['items'])) {
                    foreach ($cart['items'] as $key => $cart_item) {
                        $price += $cart_item['additional_shipping_cost'];
                    }
                }
            }

            if($price < $discount['min_cart_value']) {
                $return = false;
            }
        }

        return $return;
    }

    private function check_if_valid_availability($discount)
    {
        $return = true;

        $used_discount_codes = $this->get_used_discount_codes($discount['id']);

        if($discount['available'] > 0) {
            $used_discount_codes = $this->get_used_discount_codes($discount['id']);
            if($used_discount_codes >= $discount['available']) {
                $return = false;
            }
        }

        if($discount['available_for_single_user'] > 0 && $this->customer['id']) {
            $customer_used_discount_codes = $this->get_customer_used_discount_codes($this->customer['id'], $discount['id']);
            if($customer_used_discount_codes >= $discount['available_for_single_user']) {
                $return = false;
            }
        }

        return $return;
    }

    private function check_if_valid_restriction($discount)
    {
        $return = true;

        if($discount['restricted_to_app_only'] == 1) {
            $return = false;
        }

        return $return;
    }

}