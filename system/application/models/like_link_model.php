<?php

class Like_link_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_like_link");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getwhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_like_link");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_like_link", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_like_link", $data);
	}

	function delete($value, $field = "id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_like_link");
    }

    function fetch_join($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}

		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_like_link.user_id', 'LEFT');
		
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_like_link");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
}