<?php

class Friend_model extends CI_Model
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
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_user_friend");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getwhere($select = "*", $where = "", $join = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}

		if($join && $join != "") {
			$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_user_friend.user_id');
			$this->db->limit(5,0);
		}
		#Query
		$query = $this->db->get("tbtt_user_friend");
		if($join && $join != "") {
			$result = $query->result();
			$query->free_result();
		}else {
			$result = $query->row_array();
		}
		
		// $query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_user_friend", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_user_friend", $data);
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
		return $this->db->delete("tbtt_user_friend");
    }

    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get("tbtt_user_friend");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}

		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_user_friend.user_id', 'LEFT');
		
		if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
		{
            $this->db->order_by($order, $by);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_user_friend");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function is_your_friend($user_id1 = 0, $user_id2 = 0)
	{
		$this->db->cache_off();
		$this->db->select('*', false);
		$this->db->where("(user_id = $user_id1 AND add_friend_by = $user_id2) OR (add_friend_by = $user_id1 AND user_id = $user_id2)");
		$this->db->where('accept', 1);
        $query = $this->db->get("tbtt_user_friend");
        $result = $query->row();
        $query->free_result();
        return $result;
	}
}