<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class List_permission_menu_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'list_permission_menu';
	}

	function get($select = "*", $where = "")
	{
		$this->db->cache_off();		
		$this->db->select($select);
		if($where && $where != "") {
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get($this->table_name);
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "lpm_id", $by = "ASC", $start = -1, $limit = 0)
	{
     	$this->db->cache_off();		
		$this->db->select($select);
		if($where && $where != "") {
			$this->db->where($where, NULL, FALSE);
		}
	
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0) {
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get($this->table_name);
		$result = $query->result();
		$query->free_result();        
		return $result;
	}

	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "lpm_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
		$this->db->cache_off();
		$this->db->select($select);
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
		$query = $this->db->get($this->table_name);
		$result = $query->result();
		$query->free_result();
		return $result;
	}	

	function add($data)
	{
        $this->db->cache_delete_all();		
		return $this->db->insert($this->table_name, $data);
	}

	function update($data, $where = "")
	{
        $this->db->cache_delete_all();		
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update($this->table_name, $data);
	}

	function delete($value, $field = "lpm_id", $in = true)
    {
        $this->db->cache_delete_all();		
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete($this->table_name);
    }
}