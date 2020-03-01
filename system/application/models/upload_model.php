<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Upload_model extends CI_Model
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
		$query = $this->db->get("tbtt_files");

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
		$query = $this->db->get("tbtt_files");
		$result = $query->result();
		$query->free_result();
		return $result;

	}
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
		$query = $this->db->get("tbtt_content");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_files", $data);
	}

	function update($data, $where = "")
	{
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		return $this->db->update("tbtt_files", $data);
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
		return $this->db->delete("tbtt_files");
	}
}