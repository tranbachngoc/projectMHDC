<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Advertise_click_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get($select = "*", $where = "")
	{
		if(strtolower(trim($this->uri->segment(1))) == 'administ')
		{
			$this->db->cache_off();
		}
		else
		{
            $this->db->cache_on();
		}
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_advertise_click");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
        if(strtolower(trim($this->uri->segment(1))) == 'administ')
		{
			$this->db->cache_off();
		}
		else
		{
            $this->db->cache_on();
		}
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
		$query = $this->db->get("tbtt_advertise_click");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $join_5, $table_5, $on_5, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $groupby = false)
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
		if($join_4 && ($join_4 == "INNER" || $join_4 == "LEFT" || $join_4 == "RIGHT") && $table_4 && $table_4 != "" && $on_3 && $on_4 != "")
		{
			$this->db->join($table_4, $on_4, $join_4);
		}
		if($join_5 && ($join_5 == "INNER" || $join_5 == "LEFT" || $join_5 == "RIGHT") && $table_5 && $table_5 != "" && $on_5 && $on_5 != "")
		{
			$this->db->join($table_5, $on_5, $join_5);
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
		if($groupby && $groupby == true)
		{
			$this->db->group_by();
		}
		#Query
		$query = $this->db->get("tbtt_advertise_click");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	function add($data)
	{
		$this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		return $this->db->insert("tbtt_advertise_click", $data);
	}

	function update($data, $where = "")
	{
        $this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_advertise_click", $data);
	}

	function delete($value, $field = "adv_id", $in = true)
    {
        $this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_advertise_click");
    }
}