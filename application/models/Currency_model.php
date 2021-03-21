<?php

class Currency_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('currencies', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('currencies', $data, array('id' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete('currencies', array('id' => $id));
	}

	public function add_currency_countries($data) 
	{
		return $this->db->insert_batch('currency_countries', $data);
	}

	public function delete_currency_countries($id) 
	{
		return $this->db->delete('currency_countries', ['currency_id' => $id]);
	}

	public function get_all_currency_countries($id) 
	{
		$this->db->where('currency_id', $id);
		return $this->db->get_where('currency_countries')->result_array();
	}

	public function get_all_currencies($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('b.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->where('c.id', $params['search'], 'both');
			$this->db->or_where('c.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*, GROUP_CONCAT(co.name) as countries');

		$this->db->from('currencies c');
		$this->db->join('currency_countries cc', 'c.id = cc.currency_id', 'left');
		$this->db->join('countries co', 'co.id = cc.country_id', 'left');
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
			$this->db->order_by('c.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_currency_by_id($id)
	{
		$this->db->select('c.*');
		$this->db->from('currencies c');
		$this->db->where('c.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_currency_by_country_code($country_code)
	{
		$this->db->select('c.*');
		$this->db->from('currencies c');
		$this->db->join('currency_countries cc', 'cc.currency_id = c.id');
		$this->db->join('countries co', 'co.id = cc.country_id');
		$this->db->where('co.code', $country_code);
		return $this->db->get()->row_array();
	}

	public function count_all_currencies($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('b.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->where('c.id', $params['search'], 'both');
			$this->db->or_where('c.name', $params['search'], 'both');
			$this->db->group_end();
		}

		return $this->db->count_all_results('currencies c');
	}
}