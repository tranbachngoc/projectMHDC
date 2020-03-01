<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Manufacturer_model extends CI_Model
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
		$query = $this->db->get("tbtt_manufacturer");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "man_id", $by = "DESC", $start = -1, $limit = 0)
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
			$this->db->where($where, NULL, FALSE);
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
		$query = $this->db->get("tbtt_manufacturer");
		$result = $query->result();
		$query->free_result();
		
		return $result;
	}
	
	
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "men_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
		$query = $this->db->get("tbtt_manufacturer");
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
		return $this->db->insert("tbtt_manufacturer", $data);
	}

	function update($data,$where = "")
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
		return $this->db->update("tbtt_manufacturer", $data);
	}

	function delete($value, $field = "man_id", $in = true)
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
		return $this->db->delete("tbtt_manufacturer");
    }
}