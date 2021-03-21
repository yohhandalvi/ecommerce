<?php

class Product_stock_model extends CI_Model {

	public function get_total_product_stock($product_id)
	{
		$this->db->select('IFNULL(SUM(ps.quantity), 0) as total_stock');
		$this->db->where('ps.product_id', $product_id);
		$this->db->group_by('ps.product_id');
		$data = $this->db->get('product_stock ps')->row_array();
		return isset($data['total_stock']) ? $data['total_stock'] : 0;
	}

	public function get_all_product_stock($product_id)
	{
		$this->db->order_by('ps.id', 'DESC');
		$this->db->where('ps.product_id', $product_id);
		return $this->db->get('product_stock ps')->result_array();
	}

	public function add($data)
	{
		$this->db->insert('product_stock', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		return $this->db->update('product_stock', $data, array('id' => $id));
	}

	public function update_batch($data, $col)
	{
		return $this->db->update_batch('product_stock', $data, $col);
	}

	public function check_stock($products)
	{
		$valid = TRUE;

		if(!empty($products))
		{
			foreach ($products as $key => $product)
			{
				if($product['quantity'] > $this->get_total_product_stock($product['id']))
				{
					$valid = FALSE;
					break;
				}
			}
		}

		return $valid;
	}
}