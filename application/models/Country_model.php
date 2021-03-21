<?php

class Country_model extends CI_Model {

	public function get_all_countries()
	{
		$this->db->where('allowed', 1);
		return $this->db->get('countries')->result_array();
	}

	public function get_all_currency_countries()
	{
		return $this->db->get('countries')->result_array();
	}
}