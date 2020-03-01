<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Province_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
        $this->table = "tbtt_province";
        $this->select = '*';
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
		$query = $this->db->get("tbtt_province");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "pre_id", $by = "DESC", $start = -1, $limit = 0)
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
		$query = $this->db->get("tbtt_province");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_province", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_province", $data);
	}

	function delete($value, $field = "pre_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_province");
    }
	function getProvince( $filter = array())
	{
		$this->db->cache_off();
		if(isset($filter['select'])){
			$this->db->select($filter['select']);
		}
		if(isset($filter['where'])){
			$this->db->where($filter['where']);
		}
		if(isset($filter['where_in'])){
			foreach($filter['where_in'] as $key=>$val){
				$this->db->where_in($key, $val);
			}
		}
		if(isset($filter['order_by'])){
			$this->db->order_by($filter['order_by']);
		}
		#Query
		$query = $this->db->get("tbtt_province");
		$result = $query->result_array();
		$query->free_result();
		//echo $this->db->last_query();
		return $result;
	}
}