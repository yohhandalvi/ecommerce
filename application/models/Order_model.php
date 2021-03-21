<?php

class Order_model extends CI_Model {

	public function add($data, $cart)
    {
        $last_order = $this->db->query('SELECT MAX(order_id) as order_id FROM orders')->row_array();

        if ($last_order['order_id'] == 0)
            $new_order_id = STARTING_ORDER_ID;
        else
        	$new_order_id = $last_order['order_id'];

        $order_id = $new_order_id + 1;

        if(isset($data['wallet_paid_amount']) && $data['wallet_paid_amount'] > 0)
        {
        	$cart['total'] -= $data['wallet_paid_amount'];
        }

        $order_data = [
            'order_id' => $order_id,
            'customer_id' => $data['customer_id'],
            'shipping_customer_address_id' => $data['shipping_customer_address_id'],
            'billing_customer_address_id' => $data['billing_customer_address_id'],
            'referrer' => @$data['referrer'],
            'status' => 'pending',
            'payment' => $data['payment'],
            'currency' => $this->currency_code,
            'tax' => $this->currency_tax,
            'discount_id' => @$data['discount_id'],
            'discount_code' => @$data['discount_code'],
            'discount_amount' => (@$data['discount_amount']) ? @$data['discount_amount'] : 0,
            'shipping_amount' => ($cart['shipping_amount']) ? $cart['shipping_amount'] : 0,
            'subtotal' => ($cart['subtotal']) ? $cart['subtotal'] : 0,
            'total' => ($cart['total']) ? $cart['total'] : 0,
            'instructions' => $data['instructions'],
            'wallet_paid_amount' => (@$data['wallet_paid_amount']) ? @$data['wallet_paid_amount'] : 0,
            'cashback_amount' => (@$cart['cashback_amount']) ? @$cart['cashback_amount'] : 0,
            'placed_from' => @$data['placed_from']
        ];

        $result = $this->db->insert('orders', $order_data);

        if($result)
        {
	        $order_id = $this->db->insert_id();

	        if(!empty($cart['cashbacks_applied']))
	        {
	        	foreach ($cart['cashbacks_applied'] as $key => $cashback_id)
	        	{
		        	$order_cashbacks[] = [
		        		'order_id' => $order_id,
		        		'customer_id' => $data['customer_id'],
		        		'cashback_id' => $cashback_id
		        	];
		        }

	        	$this->db->insert_batch('order_cashbacks', $order_cashbacks);
	        }

        	if(isset($data['wallet_paid_amount']) && $data['wallet_paid_amount'] > 0)
	        {
	        	$wallet = [
	        		'customer_id' => $data['customer_id'],
	        		'amount' => -$data['wallet_paid_amount'],
	        	];

	        	$this->db->insert('wallet', $wallet);
	        }

	        if(isset($cart['cashback_amount']) && $cart['cashback_amount'] > 0)
	        {
	        	$wallet = [
	        		'customer_id' => $data['customer_id'],
	        		'amount' => $cart['cashback_amount'],
	        	];

	        	$this->db->insert('wallet', $wallet);
	        }

	        if(!empty($cart['items']))
	        {
	            $order_items = [];
	            $product_stock = [];

	            foreach ($cart['items'] as $item)
	            {
	                $order_items[] = [
	                    'order_id' => $order_id,
	                    'product_id' => $item['id'],
	                    'quantity' => $item['quantity'],
	                    'price' => $item['price'],
	                    'tax_amount' => @$item['tax_amount'],
	                    'shipping_amount' => @$item['shipping_amount'],
	                    'total' => $item['total']
	                ];

	                $product_stock[] = [
	                    'product_id' => $item['id'],
	                    'quantity' => -$item['quantity'],
	                    'action_by' => PRODUCT_STOCK_ACTION_BY_ORDER,
	                    'action_by_id' => $order_id
	                ];
	            }

	            $this->db->insert_batch('order_items', $order_items);
	            $this->db->insert_batch('product_stock', $product_stock);
	        }

	        return $order_id;
	    }
	    else
	    {
	    	return FALSE;
	    }
    }

	public function update($id, $data)
	{
		return $this->db->update('orders', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('orders', $data, $col);
	}

	public function get_all_orders($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('o.id', $params['exclude_ids']);

		if(!empty($params['customer_id']))
			$this->db->where_in('o.customer_id', $params['customer_id']);

		if(!empty($params['status']))
			$this->db->where_in('o.status', $params['status']);

		if(!empty($params['payment']))
			$this->db->where_in('o.payment', $params['payment']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('o.*, c.full_name as customer_full_name, c.mobile as customer_mobile, c.email as customer_email');

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('o.id', $params['search'], 'both');
			$this->db->or_like('o.order_id', $params['search'], 'both');
			$this->db->or_like('c.mobile', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->from('orders o');
		$this->db->join('customers c', 'c.id = o.customer_id', 'left');

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'o.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'o.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('o.id', 'DESC');
        }
		return $this->db->get()->result_array();
	}

	public function get_order_by_id($id)
	{
		$this->db->select('o.*, c.full_name as customer_full_name, c.mobile as customer_mobile, c.email as customer_email, cas.name as shipping_address_name, cas.address_line_1 as shipping_address_line_1, cas.address_line_2 as shipping_address_line_2, cas.landmark as shipping_landmark, cas.city as shipping_city, cass.name as shipping_state, casc.name as shipping_country, cas.pin_code as shipping_pin_code , cab.name as billing_address_name, cab.address_line_1 as billing_address_line_1, cab.address_line_2 as billing_address_line_2, cab.landmark as billing_landmark, cab.city as billing_city, cabs.name as billing_state, cabc.name as billing_country, cab.pin_code as billing_pin_code');
		$this->db->from('orders o');
		$this->db->join('customers c', 'c.id = o.customer_id', 'left');
		$this->db->join('customer_addresses cas', 'cas.id = o.shipping_customer_address_id', 'left');
		$this->db->join('states cass', 'cass.id = cas.state_id', 'left');
		$this->db->join('countries casc', 'casc.id = cas.country_id', 'left');
		$this->db->join('customer_addresses cab', 'cab.id = o.billing_customer_address_id', 'left');
		$this->db->join('states cabs', 'cabs.id = cab.state_id', 'left');
		$this->db->join('countries cabc', 'cabc.id = cab.country_id', 'left');
		$this->db->where('o.id', $id);
		$this->db->group_by('o.id');
		return $this->db->get()->row_array();
	}

	public function get_order_items($id)
	{
		$this->db->select('oi.*, p.name, MIN(pi.sort) as image_sort, pi.image');
		$this->db->from('order_items oi');
		$this->db->join('products p', 'p.id = oi.product_id', 'left');
		$this->db->join('product_images pi', 'p.id = pi.product_id', 'left');
		$this->db->where('oi.order_id', $id);
		$this->db->group_by('oi.id');
		return $this->db->get()->result_array();
	}

	public function get_order_by_params($params)
	{
		if(isset($params['order_id']))
			$this->db->where('o.order_id', $params['order_id']);

		if(isset($params['status']))
			$this->db->where('o.status', $params['status']);

		$this->db->select('o.*');
		$this->db->from('orders o');
		$this->db->join('customers c', 'c.id = o.customer_id', 'left');
		return $this->db->get()->row_array();
	}

	public function count_all_orders($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('o.id', $params['exclude_ids']);

		if(!empty($params['customer_id']))
			$this->db->where_in('o.customer_id', $params['customer_id']);

		if(!empty($params['status']))
			$this->db->where_in('o.status', $params['status']);

		if(!empty($params['payment']))
			$this->db->where_in('o.payment', $params['payment']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('o.id', $params['search'], 'both');
			$this->db->or_like('o.order_id', $params['search'], 'both');
			$this->db->or_like('c.mobile', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->join('customers c', 'c.id = o.customer_id', 'left');
		return $this->db->count_all_results('orders o');
	}

}