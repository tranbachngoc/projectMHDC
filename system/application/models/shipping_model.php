<?php
class Shipping_model extends CI_Model
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
		$query = $this->db->get("tbtt_shipping");		
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	function add($data){
//		if()
		$this->db->select("count(*) AS row");
		$this->db->where('id_user',$data['id_user']);
		$query = $this->db->get('tbtt_shipping');
		$result = $query->row();
		if($result->row){
			$this->db->where('id_user',$data['id_user']);	
			unset($data['id_user']);	
		   return $this->db->update("tbtt_shipping", $data);
		}
		else
			return $this->db->insert("tbtt_shipping", $data);
	}
}

?>