<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Eye_model extends CI_Model
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
		$query = $this->db->get("tbtt_eye");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
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
		
		$query = $this->db->get("tbtt_eye");
		$result = $query->result();
		$query->free_result();
		
		return $result;
	}
	
	
	function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
		$query = $this->db->get("tbtt_eye");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
	
	function geteyetype($type,$userid){
	  	$this->db->cache_off();
		if($type=='product'){
			$sql	=	"SELECT id,pro_id,pro_category,pro_name,pro_cost,pro_dir,pro_image,sho_name,sho_link ".DISCOUNT_QUERY." FROM tbtt_eye 
			INNER JOIN tbtt_product	ON tbtt_eye.idview = tbtt_product.pro_id 
			INNER JOIN tbtt_shop ON tbtt_shop.sho_user=tbtt_product.pro_user 
			WHERE userid=$userid AND typeview=1 
			ORDER BY id DESC";
		}
		
		if($type=='raovat'){
			$sql	=	"SELECT id, ads_id,ads_category,ads_title,ads_user,avatar,use_id,use_username,pre_name FROM tbtt_eye 
			INNER JOIN tbtt_ads	ON tbtt_eye.idview=tbtt_ads.ads_id 
			INNER JOIN tbtt_user ON tbtt_user.use_id=tbtt_ads.ads_user 
			INNER JOIN tbtt_province ON tbtt_ads.ads_province=tbtt_province.pre_id  
			WHERE userid=$userid AND typeview=2
			ORDER BY id DESC";
		}
		
		if($type=='hoidap'){
			$sql	=	"SELECT id, hds_id,hds_category,hds_title,up_date,avatar,cat_name FROM tbtt_eye 
			INNER JOIN tbtt_hds	ON tbtt_eye.idview=tbtt_hds.hds_id
			INNER JOIN tbtt_user ON tbtt_user.use_id=tbtt_hds.hds_user 
			INNER JOIN tbtt_hd_category ON tbtt_hds.hds_category=tbtt_hd_category.cat_id
			WHERE userid=$userid AND typeview=3
			ORDER BY id DESC";
		}
	
		$query = $this->db->query($sql);	
		$result = $query->result();
		$query->free_result();
		return $result;	
	}
	
	function geteyetypenologin($type){
		if($type=='product'){
			if($this->session->userdata('arrayEyeSanpham') && count($this->session->userdata('arrayEyeSanpham'))){
				$sql	=	"SELECT pro_id,pro_category,pro_name,pro_cost,pro_dir,pro_image,sho_name,sho_link ".DISCOUNT_QUERY." FROM tbtt_product 
				LEFT JOIN tbtt_shop ON tbtt_shop.sho_user=tbtt_product.pro_user 
				WHERE pro_id IN(".implode(",", $this->session->userdata('arrayEyeSanpham')) .")";
				$query = $this->db->query($sql);	
				$result = $query->result();
				$query->free_result();
				return $result;
			}
		}
		
		if($type=='raovat'){
			if($this->session->userdata('arrayEyeRaovat') && count($this->session->userdata('arrayEyeRaovat'))){
			$sql	=	"SELECT ads_id,ads_category,ads_title,ads_user,avatar,use_id,use_username,pre_name FROM tbtt_ads 
			INNER JOIN tbtt_user ON tbtt_user.use_id=tbtt_ads.ads_user 
			INNER JOIN tbtt_province ON tbtt_ads.ads_province=tbtt_province.pre_id  
			WHERE ads_id IN(".implode(",", $this->session->userdata('arrayEyeRaovat')) .")";
			$query = $this->db->query($sql);	
			$result = $query->result();
			$query->free_result();
			return $result;	
			}			
		}
		
		if($type=='hoidap'){
			if($this->session->userdata('arrayEyeHoidap') && count($this->session->userdata('arrayEyeHoidap'))>0){
			$sql	=	"SELECT hds_id,hds_category,hds_title,up_date,avatar,cat_name FROM tbtt_hds 
			INNER JOIN tbtt_user ON tbtt_user.use_id=tbtt_hds.hds_user 
			INNER JOIN tbtt_hd_category ON tbtt_hds.hds_category=tbtt_hd_category.cat_id
			WHERE hds_id IN(".implode(",", $this->session->userdata('arrayEyeHoidap')) .")";
			$query = $this->db->query($sql);	
			$result = $query->result();
			$query->free_result();
			return $result;		
			}
		}
	}
	
	function add($data)
	{
		return $this->db->insert("tbtt_eye", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_eye", $data);
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
		return $this->db->delete("tbtt_eye");
    }
}