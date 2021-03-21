<?php

class State_model extends CI_Model {

	public function get_all_states()
	{
		$this->db->where('country_id', 105);
		return $this->db->get('states')->result_array();
	}
}