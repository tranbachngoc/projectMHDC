<?php
class User_receive_model extends CI_Model
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
		$query = $this->db->get("tbtt_user_receive");
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	function add($data){
		return $this->db->insert("tbtt_user_receive", $data);
	}
	/*
		ham nay chua su dung
	*/
	function insert_row($data){
		//$query	=	"INSERT INTO tbtt_user_receive VALUES (".$id.",'',NULL,".$method.")";
		$key = array('ord_saddress','ord_semail','ord_sfax','ord_sgender','ord_smobile','ord_sname','ord_sotherinfo','ord_sphone','order_id','use_id');		
		foreach($data as $k=>$v){
			if(!in_array($k,$key))unset($data[$k]);
		}
		ksort ($data);
		// print_r($data);die();
		$query = $this->db->_insert('tbtt_user_receive',$key,$data);
		$this->db->query($query);
		return 1;	
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_user_receive", $data);
	}	
}

?>