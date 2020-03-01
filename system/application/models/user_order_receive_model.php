<?php
class User_order_receive_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		
		if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }

        if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get("tbtt_user_order_receive");
		$result = $query->result();
		$query->free_result();
		return $result; 
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
		$query = $this->db->get("tbtt_user_order_receive");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function add($data){
		return $this->db->insert("tbtt_user_order_receive", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_user_order_receive", $data);
	}

	function delete($where)
    {
		if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->delete("tbtt_user_order_receive");
    }
		
}

?>