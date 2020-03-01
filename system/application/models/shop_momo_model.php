<?php

class Shop_momo_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table = 'tbtt_shop_momo';
		$this->select = '*';
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
		$query = $this->db->get("tbtt_shop_momo");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
}