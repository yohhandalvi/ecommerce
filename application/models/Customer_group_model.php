<?php

class Customer_group_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('customer_groups', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('customer_groups', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('customer_groups', $data, $col);
	}

	public function get_all_customer_groups($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(isset($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('cg.*');

		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('cg.id', $params['search'], 'both');
			$this->db->or_like('cg.name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->from('customer_groups cg');
		$this->db->where('cg.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'cg.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'cg.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('cg.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_customer_group_by_id($id)
	{
		$this->db->select('cg.*');
		$this->db->from('customer_groups cg');
		$this->db->where('cg.deleted', 0);
		$this->db->where('cg.id', $id);
		return $this->db->get()->row_array();
	}

	public function count_all_customer_groups($params = null)
	{
		if(isset($params['search'])) {
			$this->db->group_start();
			$this->db->like('cg.id', $params['search'], 'both');
			$this->db->or_like('cg.name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->where('cg.deleted', 0);
		return $this->db->count_all_results('customer_groups cg');
	}

}