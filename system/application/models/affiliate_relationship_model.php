<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Affiliate_relationship_model extends CI_Model
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
		$query = $this->db->get("tbtt_affiliate_relationship");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getwhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_affiliate_relationship");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

	function getswhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_affiliate_relationship.user_parent_id');
		#Query
		$query = $this->db->get("tbtt_affiliate_relationship");
		$result = $query->result();
		$query->free_result();
		// $query->free_result();
		return $result;
	}

	function countwhere($where = ""){
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->from("tbtt_affiliate_relationship");
		$result = $query->count_all_results();
		// $query->free_result();
		return $result;
	}

	function add($data){

		$this->db->insert("tbtt_affiliate_relationship", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}
}