<?php

class Customer_address_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('customer_addresses', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('customer_addresses', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('customer_addresses', $data, $col);
	}

	public function update_by_params($params, $data)
	{
		return $this->db->update('customer_addresses', $data, $params);
	}

	public function get_all_customer_addresses($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(isset($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('ca.*, c.full_name as customer, s.name as state, co.name as country');

		if(isset($params['customer_id']))
			$this->db->where('ca.customer_id', $params['customer_id']);

		if(isset($params['type']))
			$this->db->where('ca.type', $params['type']);

		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('ca.type', $params['search'], 'both');
			$this->db->or_like('ca.landmark', $params['search'], 'both');
			$this->db->or_like('ca.city', $params['search'], 'both');
			$this->db->or_like('s.name', $params['search'], 'both');
			$this->db->or_like('co.name', $params['search'], 'both');
			$this->db->or_like('ca.pin_code', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->from('customer_addresses ca');
		$this->db->join('customers c', 'c.id = ca.customer_id', 'left');
		$this->db->join('states s', 's.id = ca.state_id', 'left');
		$this->db->join('countries co', 'co.id = ca.country_id', 'left');
		$this->db->where('ca.deleted', 0);
		$this->db->where('c.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'ca.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'ca.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('ca.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_customer_address_by_id($id)
	{
		$this->db->select('ca.*, s.name as state, co.name as country');
		$this->db->from('customer_addresses ca');
		$this->db->join('states s', 's.id = ca.state_id', 'left');
		$this->db->join('countries co', 'co.id = ca.country_id', 'left');
		$this->db->where('ca.deleted', 0);
		$this->db->where('ca.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_customer_address_by_params($params = null)
	{
		if(isset($params['customer_id']))
			$this->db->where('ca.customer_id', $params['customer_id']);

		if(isset($params['type']))
			$this->db->where('ca.type', $params['type']);

		if(isset($params['is_default']))
			$this->db->where('ca.is_default', $params['is_default']);

		$this->db->select('ca.*, s.name as state, co.name as country');
		$this->db->from('customer_addresses ca');
		$this->db->join('states s', 's.id = ca.state_id', 'left');
		$this->db->join('countries co', 'co.id = ca.country_id', 'left');
		$this->db->where('ca.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function count_all_customer_addresses($params = null)
	{
		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('ca.type', $params['search'], 'both');
			$this->db->or_like('ca.landmark', $params['search'], 'both');
			$this->db->or_like('ca.city', $params['search'], 'both');
			$this->db->or_like('s.name', $params['search'], 'both');
			$this->db->or_like('co.name', $params['search'], 'both');
			$this->db->or_like('ca.pin_code', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['customer_id']))
			$this->db->where('ca.customer_id', $params['customer_id']);

		$this->db->join('customers c', 'c.id = ca.customer_id', 'left');
		$this->db->join('states s', 's.id = ca.state_id', 'left');
		$this->db->join('countries co', 'co.id = ca.country_id', 'left');
		$this->db->where('ca.deleted', 0);
		return $this->db->count_all_results('customer_addresses ca');
	}

}