<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Product_favorite_model extends CI_Model
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
		$query = $this->db->get("tbtt_product_favorite");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function fetch_join($select = "*", $join, $table, $on, $where = "", $order = "prf_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
		$query = $this->db->get("tbtt_product_favorite");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_product_favorite", $data);
	}

	function delete($value_1, $field_1 = "prf_id", $value_2 = "", $field_2 = "", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field_1, $value_1);
		}
		else
		{
            $this->db->where($field_1, $value_1);
		}
		if($value_2 && $value_2 != "" && $field_2 && $field_2 != "")
		{
            $this->db->where($field_2, $value_2);
		}
		return $this->db->delete("tbtt_product_favorite");
    }
    public function getProducts($filter = array())
    {
        $this->db->cache_off();
    	# code...
    	if(isset($filter['select'])){
    		$this->db->select($filter['select'], false);
    	}
    	if(isset($filter['where'])){
    		$this->db->where($filter['where']);
    	}
    	if(isset($filter['limit'])){
    		$this->db->limit($filter['limit'], 0);
    	}
    	$this->db->from('tbtt_product_favorite');
    	$this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_favorite.prf_product', 'left');
    	$query = $this->db->get();
    	$result = $query->result();
		$query->free_result();
		return $result;
    }
}