<?php

class Customer_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('customers', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('customers', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('customers', $data, $col);
	}

	public function get_all_customers($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['customer_group_id']))
			$this->db->where('c.customer_group_id', $params['customer_group_id']);

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('c.inactive', $params['inactive']);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('c.id', $params['exclude_ids']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*, cg.name as group, SUM(w.amount) as wallet');

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('c.full_name', $params['search'], 'both');
			$this->db->or_like('c.email', $params['search'], 'both');
			$this->db->or_like('c.id', $params['search'], 'both');
			$this->db->or_like('c.mobile', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->from('customers c');
		$this->db->join('customer_groups cg', 'cg.id = c.customer_group_id', 'left');
		$this->db->join('wallet w', 'c.id = w.customer_id', 'left');
		$this->db->where('c.deleted', 0);
		$this->db->group_by('c.id');

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
			$this->db->order_by('c.id', 'DESC');
        }
		return $this->db->get()->result_array();
	}

	public function get_customer_by_id($id)
	{
		$this->db->select('c.*, cg.name as group, COUNT(DISTINCT o.id) as total_orders, COUNT(DISTINCT oi.product_id) as total_bought_products');
		$this->db->from('customers c');
		$this->db->join('customer_groups cg', 'cg.id = c.customer_group_id', 'left');
		$this->db->join('orders o', 'c.id = o.customer_id', 'left');
		$this->db->join('order_items oi', 'o.id = oi.order_id', 'left');
		$this->db->where('c.deleted', 0);
		$this->db->where('c.id', $id);
		$this->db->group_by('c.id');
		return $this->db->get()->row_array();
	}

	public function get_customer_by_params($params)
	{
		if(isset($params['customer_group_id']))
			$this->db->where('c.customer_group_id', $params['customer_group_id']);

		if(isset($params['forgot_password_key']))
			$this->db->where('c.forgot_password_key', $params['forgot_password_key']);

		if(isset($params['email']))
			$this->db->where('c.email', $params['email']);

		$this->db->select('c.*, cg.name as group');
		$this->db->from('customers c');
		$this->db->join('customer_groups cg', 'cg.id = c.customer_group_id', 'left');
		$this->db->where('c.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function count_all_customers($params = null)
	{
		if(!empty($params['customer_group_id']))
			$this->db->where('c.customer_group_id', $params['customer_group_id']);

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('c.inactive', $params['inactive']);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('c.id', $params['exclude_ids']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*, cg.name as group');

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('c.full_name', $params['search'], 'both');
			$this->db->or_like('c.email', $params['search'], 'both');
			$this->db->or_like('c.id', $params['search'], 'both');
			$this->db->or_like('c.mobile', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->join('customer_groups cg', 'cg.id = c.customer_group_id', 'left');
		$this->db->where('c.deleted', 0);
		return $this->db->count_all_results('customers c');
	}

	public function login($email, $password)
	{
		$this->db->select('id, email');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$customer = $this->db->get('customers')->row_array();

		if(!empty($customer))
		{
			$this->set_user_session(['customer_id' => $customer['id'], 'customer_email' => $customer['email']]);
			return true;
		}
		else
		{
			return false;
		}
	}

	public function set_user_session($user_data)
	{
		if(!empty($user_data))
		{
			foreach ($user_data as $key => $value)
			{
				$this->session->set_userdata($key, $value);
			}
		}
	}

}