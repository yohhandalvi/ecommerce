<?php

class Cart_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('cart', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('cart', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('cart', $data, $col);
	}

	public function update_by_params($params, $data)
	{
		return $this->db->update('cart', $data, $params);
	}

	public function get_all_cart_products($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(isset($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*, p.name, p.price as old_price, CASE WHEN p.has_discount = 1 AND p.discount_type = "percent" THEN round((p.price - (p.price * p.discount_value/100)), 2) WHEN p.has_discount = 1 AND p.discount_type = "amount" THEN round(p.price - p.discount_value, 2) ELSE p.price END as price, ca.name as category');

		if(isset($params['customer_id']))
			$this->db->where('c.customer_id', $params['customer_id']);

		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('p.name', $params['search'], 'both');
			$this->db->or_like('ca.name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->from('cart c');
		$this->db->join('products p', 'p.id = c.product_id', 'left');
		$this->db->join('categories ca', 'ca.id = p.category_id', 'left');
		$this->db->where('p.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'c.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'c.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('c.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function count_all_cart_products($params = null)
	{
		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('p.name', $params['search'], 'both');
			$this->db->or_like('ca.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['customer_id']))
			$this->db->where('c.customer_id', $params['customer_id']);

		$this->db->join('products p', 'p.id = c.product_id', 'left');
		$this->db->join('categories ca', 'ca.id = p.category_id', 'left');
		$this->db->where('p.deleted', 0);
		return $this->db->count_all_results('cart c');
	}

}