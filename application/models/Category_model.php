<?php

class Category_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('categories', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('categories', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('categories', $data, $col);
	}

	public function get_all_categories($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('c.id', $params['exclude_ids']);

		if(!empty($params['exclude_sub_ids'])) {
			$this->db->where_not_in('c.id', $params['exclude_sub_ids']);
			$this->db->where_not_in('c.parent', $params['exclude_sub_ids']);
		}

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('c.id', $params['search'], 'both');
			$this->db->or_like('c.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('c.inactive', $params['inactive']);

		if(!empty($params['parent']))
			$this->db->where('c.parent', $params['parent']);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('c.*, c1.name as parent, COUNT(DISTINCT p.id) as total_products');

		$this->db->from('categories c');
		$this->db->join('categories c1', 'c1.id = c.parent', 'left');
		$this->db->join('products p', 'p.category_id = c.id', 'left');
		$this->db->group_by('c.id');
		$this->db->where('c.deleted', 0);

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

	public function get_category_by_id($id)
	{
		$this->db->select('c.*');
		$this->db->from('categories c');
		$this->db->where('c.deleted', 0);
		$this->db->where('c.id', $id);
		return $this->db->get()->row_array();
	}

	public function count_all_categories($params = null)
	{
		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('c.id', $params['exclude_ids']);

		if(!empty($params['exclude_sub_ids'])) {
			$this->db->where_not_in('c.id', $params['exclude_sub_ids']);
			$this->db->where_not_in('c.parent', $params['exclude_sub_ids']);
		}

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('c.id', $params['search'], 'both');
			$this->db->or_like('c.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('c.inactive', $params['inactive']);

		if(!empty($params['parent']))
			$this->db->where('c.parent', $params['parent']);

		$this->db->where('c.deleted', 0);
		return $this->db->count_all_results('categories c');
	}

	public function get_nav_categories()
	{
		$this->db->select('c.*');
		$this->db->from('categories c');
		$this->db->join('categories c1', 'c1.id = c.parent', 'left');
		$this->db->where('c.inactive', 0);
		$this->db->where('c.deleted', 0);
		$this->db->order_by('c.id', 'ASC');
		$categories = $this->db->get()->result_array();

		$return_categories = [];

		if(!empty($categories))
		{
			foreach ($categories as $key => $category)
			{
				$category['children'] = [];
				$return_categories[$category['id']] = $category;
			}
		}

		// echo '<pre>';
		// print_r($return_categories);
		// exit;

		return $return_categories;
	}

}