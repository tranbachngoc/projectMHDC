<?php

class Order_nhanhvn_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = 'tbtt_order_nhanhvn';
		$this->select = '*';
	}

	function add($data) {
		$this->db->cache_off();
		$this->db->insert('tbtt_order_nhanhvn', $data);
	}
	
	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_order_nhanhvn");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
}