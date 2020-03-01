<?php

class User_maritals_model extends CI_Model
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
		$query = $this->db->get("tbtt_user_maritals");
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
		$query = $this->db->get("tbtt_user_maritals");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_user_maritals", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_user_maritals", $data);
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
		return $this->db->delete("tbtt_user_maritals");
    }

    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get("tbtt_user_maritals");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $where = "", $join, $table, $on, $order = "id", $by = "DESC", $group='', $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select, false);
		if($where && $where != "")
		{
			$this->db->where($where);
		}

		if ($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "") {
            $this->db->join($table, $on, $join);
        }
		
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if($group && $group != "")
		{
            $this->db->group_by($group);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_user_maritals");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

    function fetch_join2($select = "*", $where = "", $join, $table, $on, $join2, $table2, $on2, $order = "id", $by = "DESC", $group, $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select, false);
		if($where && $where != "")
		{
			$this->db->where($where);
		}

		if ($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "") {
            $this->db->join($table, $on, $join);
        }
		
		if ($join2 && ($join2 == "INNER" || $join2 == "LEFT" || $join2 == "RIGHT") && $table2 && $table2 != "" && $on2 && $on2 != "") {
            $this->db->join($table2, $on2, $join2);
        }
		
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if($group && $group != "")
		{
            $this->db->group_by($group);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_user_maritals");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
}