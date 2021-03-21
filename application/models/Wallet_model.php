<?php

class Wallet_model extends CI_Model {

	public function add($data)
	{
		return $this->db->insert('wallet', $data);
	}

	public function get_customer_balance($customer_id)
	{
		$this->db->select('SUM(w.amount) as balance');
		$this->db->from('wallet w');
		$this->db->where('w.customer_id', $customer_id);
		$wallet = $this->db->get()->row_array();
		return $wallet['balance'];
	}

	public function get_customer_transactions($customer_id)
	{
		$this->db->select('*');
		$this->db->from('wallet w');
		$this->db->where('w.customer_id', $customer_id);
		$this->db->order_by('w.id', 'desc');
		return $this->db->get()->result_array();
	}
}