<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Hds_bad_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch($select = "*", $where = "", $order = "adb_id", $by = "DESC", $groupBy = "", $start = -1, $limit = 0)
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
		if($groupBy && $groupBy != "")
		{
			$this->db->group_by($groupBy);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_hds_bad");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_hds_bad", $data);
	}

	function delete($value, $field = "adb_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_hds_bad");
    }
	function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "adb_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "")
		{
			$this->db->join($table_1, $on_1, $join_1);
		}
		if($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "")
		{
			$this->db->join($table_2, $on_2, $join_2);
		}
		if($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "")
		{
			$this->db->join($table_3, $on_3, $join_3);
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
		$query = $this->db->get("tbtt_hds_bad");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
}