<?php

class Product_model extends CI_Model {

	public function add($data)
	{
		$this->db->insert('products', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('products', $data, array('id' => $id));
	}

	public function update_batch($data, $col) 
	{
		return $this->db->update_batch('products', $data, $col);
	}

	public function add_product_prices($data) 
	{
		return $this->db->insert_batch('product_prices', $data);
	}

	public function delete_product_prices($id) 
	{
		return $this->db->delete('product_prices', ['product_id' => $id]);
	}

	public function get_all_product_prices($id) 
	{
		$this->db->where('product_id', $id);
		return $this->db->get_where('product_prices')->result_array();
	}

	public function get_all_products($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		$this->_set_filters($params);

		if(!empty($params['select']))
			$this->db->select($params['select']);
		else
			$this->db->select('p.*, pp.price as old_price, CASE WHEN p.has_discount = 1 AND p.discount_type = "percent" THEN round((pp.price - (pp.price * p.discount_value/100)), 2) WHEN p.has_discount = 1 AND p.discount_type = "amount" THEN round(pp.price - p.discount_value, 2) ELSE pp.price END as price, c.name as category, MIN(pi.sort) as image_sort, pi.image, (SELECT IFNULL(SUM(ps.quantity), 0) FROM product_stock ps WHERE ps.product_id = p.id) as total_stock, ca.id as cashback_id, ca.type as cashback_type, ca.value as cashback_value');
		$this->db->from('products p');
		$this->db->join('product_images pi', 'p.id = pi.product_id', 'left');
		$this->db->join('product_prices pp', 'p.id = pp.product_id AND pp.currency_id = '.$this->currency_id, 'left');
		$this->db->join('categories c', 'c.id = p.category_id', 'left');
		$this->db->join('customer_wishlist cw', 'p.id = cw.product_id', 'left');
		$this->db->join('cashbacks ca', 'p.id = ca.product_id AND ca.inactive = 0 AND ca.deleted = 0 AND (ca.valid_to_date >= "'.date('Y-m-d').'" OR ca.valid_to_date = "0000-00-00") AND (ca.valid_from_date <= "'.date('Y-m-d').'" OR ca.valid_from_date = "0000-00-00")', 'left');
		$this->db->group_by('p.id');
		$this->db->where('p.deleted', 0);

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'p.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'p.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('p.id', 'DESC');
        }
		return $this->db->get()->result_array();
	}

	public function get_product_by_id($id)
	{
		$this->db->select('p.*, pp.price as old_price, CASE WHEN p.has_discount = 1 AND p.discount_type = "percent" THEN round((pp.price - (pp.price * p.discount_value/100)), 2) WHEN p.has_discount = 1 AND p.discount_type = "amount" THEN round(pp.price - p.discount_value, 2) ELSE pp.price END as price, c.name as category, MIN(pi.sort) as image_sort, pi.image, IFNULL(SUM(ps.quantity), 0) as total_stock, ca.id as cashback_id, ca.type as cashback_type, ca.value as cashback_value');
		$this->db->from('products p');
		$this->db->join('product_images pi', 'p.id = pi.product_id', 'left');
		$this->db->join('product_prices pp', 'p.id = pp.product_id AND pp.currency_id = '.$this->currency_id, 'left');
		$this->db->join('product_stock ps', 'p.id = ps.product_id', 'left');
		$this->db->join('categories c', 'c.id = p.category_id', 'left');
		$this->db->join('cashbacks ca', 'p.id = ca.product_id AND ca.inactive = 0 AND ca.deleted = 0 AND (ca.valid_to_date >= "'.date('Y-m-d').'" OR ca.valid_to_date = "0000-00-00") AND (ca.valid_from_date <= "'.date('Y-m-d').'" OR ca.valid_from_date = "0000-00-00")', 'left');
		$this->db->where('p.deleted', 0);
		$this->db->group_by('p.id');
		$this->db->where('p.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_product_images($id)
	{
		$this->db->select('pi.*');
		$this->db->from('product_images pi');
		$this->db->where('pi.deleted', 0);
		$this->db->where('pi.product_id', $id);
		$this->db->order_by('pi.sort');
		return $this->db->get()->result_array();
	}

	public function get_product_by_params($params)
	{
		$this->db->select('p.*, p.price as old_price, CASE WHEN p.has_discount = 1 AND p.discount_type = "percent" THEN round((p.price - (p.price * p.discount_value/100)), 2) WHEN p.has_discount = 1 AND p.discount_type = "amount" THEN round(p.price - p.discount_value, 2) ELSE p.price END as price, c.name as category');
		$this->db->from('products p');
		$this->db->join('categories c', 'c.id = p.category_id', 'left');
		$this->db->where('p.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function add_review($data)
	{
		return $this->db->insert('product_reviews', $data);
	}

	public function update_review($id, $data)
	{
		return $this->db->update('product_reviews', $data, ['id' => $id]);
	}

	public function get_product_review_by_id($id)
	{
		$this->db->select('pr.*, p.name as product, c.full_name as customer');
		$this->db->from('product_reviews pr');
		$this->db->join('products p', 'p.id = pr.product_id', 'left');
		$this->db->join('customers c', 'c.id = pr.customer_id', 'left');
		$this->db->where('pr.id', $id);
		$this->db->where('pr.deleted', 0);
		$this->db->order_by('pr.created_on', 'desc');
		return $this->db->get()->row_array();
	}

	public function get_product_reviews($limit = 0, $offset = 0, $params = null)
	{
		if($limit)
			$this->db->limit($limit, $offset);

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('pr.inactive', $params['inactive']);

		if(isset($params['product_id']))
			$this->db->where('pr.product_id', $params['product_id']);

		if(isset($params['customer_id']))
			$this->db->where('pr.customer_id', $params['customer_id']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('pr.id', $params['search'], 'both');
			$this->db->or_like('pr.rating', $params['search'], 'both');
			$this->db->or_like('pr.review', $params['search'], 'both');
			$this->db->or_like('p.name', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(isset($params['sort'])) {
            $ord_data = explode(',', $params['sort']);
            if(count($ord_data) == 1) {
                $ord = explode('=', $ord_data[0]);
                if (isset($ord[0]) && isset($ord[1])) {
                    $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'pr.'.$ord[0];
                    $this->db->order_by($ord0, $ord[1]);
                }
            } else {
                foreach ($ord_data as $key => $value) {
                    $ord = explode('=', $value);
                    if (isset($ord[0]) && isset($ord[1])) {
                        $ord0 = (strpos($ord[0], ".") !== false) ? $ord[0] : 'pr.'.$ord[0];
                        $this->db->order_by($ord0, $ord[1]);
                    }
                }
            }
        } else {
			$this->db->order_by('pr.id', 'DESC');
        }

		$this->db->select('pr.*, p.name as product, c.full_name as customer');
		$this->db->from('product_reviews pr');
		$this->db->join('products p', 'p.id = pr.product_id', 'left');
		$this->db->join('customers c', 'c.id = pr.customer_id', 'left');
		$this->db->where('pr.deleted', 0);
		$this->db->order_by('pr.created_on', 'desc');
		return $this->db->get()->result_array();
	}

	public function count_all_products($params = null)
	{
		$this->_set_filters($params);

		$this->db->where('p.deleted', 0);
		return $this->db->count_all_results('products p');
	}

	public function count_all_product_reviews($params = null)
	{
		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('pr.inactive', $params['inactive']);

		if(isset($params['product_id']))
			$this->db->where('pr.product_id', $params['product_id']);

		if(isset($params['customer_id']))
			$this->db->where('pr.customer_id', $params['customer_id']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('pr.id', $params['search'], 'both');
			$this->db->or_like('pr.rating', $params['search'], 'both');
			$this->db->or_like('pr.review', $params['search'], 'both');
			$this->db->or_like('p.name', $params['search'], 'both');
			$this->db->or_like('c.full_name', $params['search'], 'both');
			$this->db->group_end();
		}

		$this->db->where('pr.deleted', 0);
		$this->db->join('products p', 'p.id = pr.product_id', 'left');
		$this->db->join('customers c', 'c.id = pr.customer_id', 'left');
		return $this->db->count_all_results('product_reviews pr');
	}

	public function get_min_price_from_products($params = null)
	{
		$this->_set_filters($params);

		$this->db->select('IFNULL(MIN(p.price), 0) as price');
		$this->db->from('products p');
		$this->db->where('p.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function get_max_price_from_products($params = null)
	{
		$this->_set_filters($params);

		$this->db->select('IFNULL(MAX(p.price), 0) as price');
		$this->db->from('products p');
		$this->db->where('p.deleted', 0);
		return $this->db->get()->row_array();
	}

	public function wishlist($customer_id, $product_id)
	{
		$this->db->where('product_id', $product_id);
		$this->db->where('customer_id', $customer_id);
		$wishlist = $this->db->get_where('customer_wishlist')->row_array();

		if($wishlist) {
			$this->db->delete('customer_wishlist', array('id' => $wishlist['id']));
			$state = 0;
		} else {
			$this->db->insert('customer_wishlist', array('customer_id' => $customer_id, 'product_id' => $product_id));
			$state = 1;
		}

		return $state;
	}

	public function check_if_wishlist($customer_id, $product_id)
	{
		$this->db->where('product_id', $product_id);
		$this->db->where('customer_id', $customer_id);
		$wishlist = $this->db->get_where('customer_wishlist')->row_array();

		if($wishlist)
			return true;
		else
			return false;
	}

	private function _set_filters($params = null)
	{
		if(isset($params['include_ids'])) {
			if(!empty($params['include_ids']))
				$this->db->where_in('p.id', $params['include_ids']);
			else
				$this->db->where_in('p.id', [0]);
		}

		if(!empty($params['exclude_ids']))
			$this->db->where_not_in('p.id', $params['exclude_ids']);

		if(!empty($params['search'])) {
			$this->db->group_start();
			$this->db->like('p.id', $params['search'], 'both');
			$this->db->or_like('p.name', $params['search'], 'both');
			$this->db->group_end();
		}

		if(!empty($params['category_id']))
			$this->db->where('p.category_id', $params['category_id']);

		if(isset($params['inactive']) && is_numeric($params['inactive']))
			$this->db->where('p.inactive', $params['inactive']);

		if(isset($params['featured']) && is_numeric($params['featured']))
			$this->db->where('p.featured', $params['featured']);

		if(!empty($params['wishlist']))
			$this->db->where('cw.customer_id', $params['wishlist']);

		if(!empty($params['from_price']))
			$this->db->where('p.price >=', $params['from_price']);

		if(!empty($params['to_price']))
			$this->db->where('p.price <=', $params['to_price']);
	}
}