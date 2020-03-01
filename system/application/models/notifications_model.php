<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Notifications_model extends CI_Model
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
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_notifications");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
		$this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
		$this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_notifications");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
	    $this->db->cache_off();
	    $this->db->select($select);
	    $this->db->from("tbtt_notifications AS a");
	    if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
	    {
		    $this->db->join($table, $on, $join);
	    }
	    if($where && $where != "")
	    {
		    $this->db->where($where);
	    }
	    if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
	    {
		    $this->db->order_by($order, $by);
	    }
	    if((int)$start >= 0 && $limit && (int)$limit > 0)
	    {
		    $this->db->limit($limit, $start);
	    }
	    if($distinct && $distinct == true)
	    {
		    $this->db->distinct();
	    }
	    #Query
	    $query = $this->db->get();
	    $result = $query->result();
	    $query->free_result();
	    return $result;
	}
	
	function add($data)
	{
	    return $this->db->insert("tbtt_notifications", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_notifications", $data);
	}

	function delete($value, $field = "not_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_notifications");
    }
}