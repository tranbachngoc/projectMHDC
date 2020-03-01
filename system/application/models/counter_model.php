<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Counter_model extends CI_Model
{
    function __construct()
	{
		parent::__construct();
	}
	
	function get()
	{
        $this->db->cache_off();
		$sql = "SELECT cou_counter FROM tbtt_counter";
		#Query
		$query = $this->db->query($sql);
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function update()
    {
		$sql = "UPDATE tbtt_counter";
		$sql .= " SET cou_counter = cou_counter + 1";
		#Query
		$query = $this->db->query($sql);
    }
	function getArticle($id){
		  if($id>0){
		   $sql = "SELECT * FROM tbtt_content WHERE not_id=".$id;
		   #Query
		   $query = $this->db->query($sql);
		   $result = $query->row();
		   $query->free_result();
		   return $result;
		  }
	 }
	 
	 function getNameCategoryContent($userId)
	{
		
		$sql = "SELECT cat_name FROM tbtt_content_category WHERE cat_id = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->cat_name ;
		
	}
	  function topBuyProducts($limit = '10')
    {
        $sql = 'SELECT * FROM tbtt_product WHERE pro_status = 1 AND pro_buy > 0 ORDER BY pro_buy DESC LIMIT 0,' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
	 function topSaleoffProduct($limit = '10')
    {
        $sql = 'SELECT * FROM tbtt_product WHERE pro_status = 1 AND pro_saleoff = 1 ORDER BY pro_id DESC LIMIT 0,' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
	 function latestProducts($limit = '10')
    {
        $sql = 'SELECT * FROM tbtt_product WHERE pro_status = 1 ORDER BY pro_id DESC LIMIT 0,' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
	 function countNumberNotify($idUser){
		 
	   $now=time();		 		  
	   $sql = "SELECT * FROM tbtt_notify WHERE not_status =1 AND not_enddate >= ".$now." AND (not_group like '%0%' OR not_group like '%1%' OR not_group like '%3%' or not_user = ".(int)$idUser." ) and not_view NOT LIKE '%".$idUser."%'  ";
	   #Query
	   $query = $this->db->query($sql);
	   return $query->num_rows();
	   	    
	 }
	 
	 function getBalance($user_id){
		 
		$sql = "SELECT SUM(amount) as plus FROM tbtt_account_thongkegiaodich WHERE prefix='+' AND user_id=".$user_id;
		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		
		$sql = "SELECT SUM(amount) as minus FROM tbtt_account_thongkegiaodich WHERE prefix='-' AND user_id=".$user_id;
		$query = $this->db->query($sql);	
		$minus = $query->result();

		return $plus[0]->plus - $minus[0]->minus;
		
	}
	
	function loadUpdateDateAnsers($hds_id)
	{
		
		$sql = "SELECT tbtt_answers.up_date  FROM tbtt_hds,tbtt_answers WHERE tbtt_hds.hds_id = tbtt_answers.hds_id AND tbtt_answers.hds_id =".(int)$hds_id." ORDER BY tbtt_answers.up_date DESC LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->up_date;
		
		
	}
	
	function getUSerIdNameToID($userId)
	{
		
		$sql = "SELECT use_username  FROM tbtt_user WHERE  use_id = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->use_username;
		
	}
	function GetProvinceToID($userId)
	{
		
		$sql = "SELECT pre_name  FROM tbtt_province WHERE  pre_id = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->pre_name;
		
	}
	
	function GetNhaSanXuatToID($userId)
	{
		
		$sql = "SELECT man_name  FROM tbtt_manufacturer WHERE  man_id = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->man_name;
		
	}
	
	function getUSerShopNameToID($userId)
	{
		
		$sql = "SELECT sho_name   FROM tbtt_shop WHERE  sho_user = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->sho_name ;
		
	}
	
	function getUSerIdNameNgayThamGia($userId)
	{
		$sql = "SELECT use_regisdate  FROM tbtt_user WHERE  use_id = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->use_regisdate;		
	}
	
	function countUserBussinesAll($userId,$table,$field)
	{
		
		$sql = "SELECT COUNT(*) AS dem  FROM ".$table." WHERE  ".$field." = ".(int)$userId."  LIMIT 0,1";		
		$query = $this->db->query($sql);	
		$plus = $query->result();		
		return $plus[0]->dem;		
	}
	
	
}