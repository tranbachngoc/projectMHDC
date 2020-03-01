<?php
#****************************************#
# * @Author: Steve Tran                  #
# * @Email: stevetran.bao@gmail.com      #
# * @Website: https://gocnhinsteve.wordpress.com #
# * @Copyright: 2018 - 2020              #
#****************************************#
class Permission_menu_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'permission_menu';
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
		$query = $this->db->get($this->table_name);
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "pm_id", $by = "DESC", $start = -1, $limit = 0)
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
		$query = $this->db->get($this->table_name);
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function fetch_join1($select = "*", $join, $table, $on, $where = "", $order = "pm_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
        $this->db->cache_off();
		$this->db->select($select, false);
		if($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "")
		{
			$this->db->join($table, $on, $join);
		}
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
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
			$this->db->group_by();
		}		

		#Query
		$query = $this->db->get($this->table_name);
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function fetch_join2($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $wherestore = "", $order = "pm_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();

        }
        if ($group_by && $group_by!= NULL) {
            $this->db->group_by($group_by);
        } else {
            $this->db->group_by();
        }
		#Query
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join3($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $wherestore = "", $order = "pm_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);

        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by();
        } else {
            if ($group && $group != NULL) {
                $this->db->group_by($group);
            }
        }
        #Query
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }

	function add($data)
	{
		return $this->db->insert($this->table_name, $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update($this->table_name, $data);
	}

	function delete($value, $field = "pm_id", $in = true)
    {
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