<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Category_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
        $this->table = "tbtt_category";
        $this->select = "*";
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
		$query = $this->db->get("tbtt_category");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "cat_order", $by = "ASC", $start = -1, $limit = 0, $join = "")
	{
            if(strtolower(trim($this->uri->segment(1))) == 'administ')
		{
			$this->db->cache_off();
		}
		else
		{
			$this->db->cache_off();
		}
		$this->db->select($select);

		if($join != '')
		{
			$this->db->join('tbtt_category AS a', 'tbtt_category.cat_id = a.parent_id', 'LEFT');
			$this->db->group_by('tbtt_category.cat_id');
		}
		
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
		$query = $this->db->get("tbtt_category");
		$result = $query->result();
		$query->free_result();
        //echo $this->db->last_query();die;
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
		$query = $this->db->get("tbtt_category");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	// quang
	function fetch_mannufacturer($select = "*", $where = "", $order = "man_id", $by = "DESC", $start = -1, $limit = 0)
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

//end quang

	function add($data)
	{
        $this->db->cache_delete_all();
		if(!file_exists('system/cache/index.html'))
		{
			$this->load->helper('file');
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		return $this->db->insert("tbtt_category", $data);
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
		return $this->db->update("tbtt_category", $data);
	}

	function delete($value, $field = "cat_id", $in = true)
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
		return $this->db->delete("tbtt_category");
    }

    function loadCategoryRoot($parent, $level = 0){
        $select = "*";
        $whereTmp = "cat_status = 1 and parent_id = '$parent'";
        $categoryRoot = $this->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
	}

	public function get_category_shop()
	{
		$where = "cat_status = 1 AND cat_level = 0 AND parent_id = 0 AND cate_type = 0";
		$param = array(
			'select'  	=> 'cat_id, cat_name',
			'table'   	=> 'tbtt_category',
			'type'    	=> 'array',
			'list'    	=> true,
			'orderby' 	=> 'cat_order ASC',
			'limit' 	=> 0,
			'start' 	=> 0
		);
		$category = $this->gets_where($where, $param);
		return $category;
	}
}