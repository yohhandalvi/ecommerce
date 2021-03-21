<?php

class Wishlist_model extends CI_Model {

	public function get_all_wishlist_customers($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*');
		$this->db->from('customers c');
		$this->db->join('customer_wishlist cw', 'c.id = cw.customer_id', 'left');
		$this->db->join('products p', 'p.id = cw.product_id', 'left');
		$this->db->where('cw.product_id', $params['product_id']);
		$this->db->group_by('c.id');

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'cw.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'cw.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('cw.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function count_all_wishlist_customers($params = null)
	{
		$this->db->where('cw.product_id', $params['product_id']);
		return $this->db->count_all_results('customer_wishlist cw');
	}
}