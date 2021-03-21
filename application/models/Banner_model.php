<?php

class Banner_model extends CI_Model {

	public function update_banner($id, $data)
	{
		return $this->db->update('banners', $data, array('id' => $id));
	}

	public function add_banner_image($data)
	{
		$this->db->insert('banner_images', $data);
		return $this->db->insert_id();
	}

	public function update_banner_image($id, $data)
	{
		return $this->db->update('banner_images', $data, array('id' => $id));
	}

	public function update($id, $data)
	{
		return $this->db->update('banners', $data, array('id' => $id));
	}

	public function get_all_banners($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('b.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('b.id', $params['search'], 'both');
			$this->db->or_where('b.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('b.inactive', $params['inactive']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('b.*');

		$this->db->from('banners b');
		$this->db->where('b.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'b.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'b.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('b.id', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_banner_by_id($id)
	{
		$this->db->select('b.*');
		$this->db->from('banners b');
		$this->db->where('b.deleted', 0);
		$this->db->where('b.id', $id);
		return $this->db->get()->row_array();
	}

	public function count_all_banners($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('b.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('b.id', $params['search'], 'both');
			$this->db->or_where('b.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('b.inactive', $params['inactive']);

		$this->db->where('b.deleted', 0);
		return $this->db->count_all_results('banners b');
	}

	public function get_all_banner_images($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('bi.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('bi.id', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('bi.inactive', $params['inactive']);

		if(isset($params['banner_id']) && is_numeric($params['banner_id']))
			$this->db->where('bi.banner_id', $params['banner_id']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('bi.*, CASE WHEN bi.product_id = 0 AND bi.category_id = 0 THEN "-- No Link --" WHEN bi.product_id = 0 THEN CONCAT("Category: ", " ", c.name) ELSE CONCAT("Product: ", " ", p.name) END as linked');

		$this->db->from('banner_images bi');
		$this->db->join('categories c', 'c.id = bi.category_id', 'left');
		$this->db->join('products p', 'p.id = bi.product_id', 'left');
		$this->db->where('bi.deleted', 0);
		$this->db->group_by('bi.id');

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'bi.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'bi.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('bi.sort', 'ASC');
        }
		return $this->db->get()->result_array();
	}

	public function get_banner_image_by_id($id)
	{
		$this->db->select('bi.*');
		$this->db->from('banner_images bi');
		$this->db->where('bi.deleted', 0);
		$this->db->where('bi.id', $id);
		return $this->db->get()->row_array();
	}

	public function count_all_banner_images($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('bi.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('bi.id', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('bi.inactive', $params['inactive']);

		$this->db->where('bi.deleted', 0);
		return $this->db->count_all_results('banner_images bi');
	}

}