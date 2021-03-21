<?php

class Shipping_rate_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('shipping_rates', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('shipping_rates', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('shipping_rates', $data, $col);
	}

	public function get_all_shipping_rates($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('sr.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('sr.id', $params['search'], 'both');
			$this->db->or_where('sr.shipping_fee', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('sr.inactive', $params['inactive']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('sr.*');

		$this->db->from('shipping_rates sr');
		$this->db->where('sr.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'sr.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'sr.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('sr.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_shipping_rate_by_id($id)
	{
		$this->db->select('sr.*');
		$this->db->from('shipping_rates sr');
		$this->db->where('sr.deleted', 0);
		$this->db->where('sr.id', $id);
		return $this->db->get()->row_array();
	}

	public function count_all_shipping_rates($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('sr.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('sr.id', $params['search'], 'both');
			$this->db->or_where('sr.shipping_fee', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('sr.inactive', $params['inactive']);

		$this->db->where('sr.deleted', 0);
		return $this->db->count_all_results('shipping_rates sr');
	}

	public function get_highest_shipping_rate()
    {
        $this->db->select_max('amount_to');
        $this->db->where('deleted', 0);
        return $this->db->get('shipping_rates')->row_array();
    }

    public function get_cart_shipping_rate($amount)
    {
        $this->db->where('deleted', 0);
        $shipping_rates = $this->db->get_where('shipping_rates', ['deleted' => 0, 'inactive' => 0])->result_array();

        $shipping_fee = 0;
        $amount = round($amount, 2);

        if(!empty($shipping_rates)) {
            foreach ($shipping_rates as $key => $shipping_rate) {
                if($shipping_rate['amount_to'] > 0) {
                    if($amount >= $shipping_rate['amount_from'] && $amount <= $shipping_rate['amount_to']) {
                        $shipping_fee = $shipping_rate['shipping_fee'];
                    }
                } else {
                    if($amount >= $shipping_rate['amount_from']) {
                        $shipping_fee = $shipping_rate['shipping_fee'];
                    }
                }
                if($shipping_fee > 0) {
                    break;
                }
            }
        }

        return $shipping_fee;
    }

}