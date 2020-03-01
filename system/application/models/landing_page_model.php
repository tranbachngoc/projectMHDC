<?php
class Landing_page_model extends CI_Model
{
    private $_table = 'tbtt_landing_page';
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
		$query = $this->db->get("tbtt_landing_page");
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
		$query = $this->db->get("tbtt_landing_page");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function fetch_join($select = "*", $join_1, $table_1, $on_1,  $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "")
		{
			$this->db->join($table_1, $on_1, $join_1);
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
		$query = $this->db->get("tbtt_landing_page");
                
		$result = $query->result();
		$query->free_result();
		return $result;
	}	
	
	function fetch_join3($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
		$query = $this->db->get("tbtt_landing_page");
		$result = $query->result();
		$query->free_result();
		return $result;
	}
    function getLandingByID($id){
        $query	=	"SELECT * FROM `tbtt_landing_page` WHERE `id` = ".$id;
        $return = $this->db->query($query);
        return $return;
    }

    function getHTMLTemplateByID($id){
        $query	=	"SELECT content FROM `tbtt_html_template` WHERE `id` = ".$id;
        $return = $this->db->query($query);
        return $return;
    }
    
    function getLandingByUserId($userId, $where=NULL){
        $query	=	"SELECT * FROM `tbtt_landing_page` WHERE `user_id` IN( ".$userId.') '.$where;
        $return = $this->db->query($query);
        return $return->result();
    }

    function getLandingByUserId1($where){
        $query	=	"SELECT * FROM `tbtt_landing_page` WHERE ".$where;
        $return = $this->db->query($query);
        return $return->result();
    }

    function getLangOfSub($id = array()){
        $query	=	"SELECT * FROM `tbtt_landing_page` WHERE `user_id` IN (" . $id . ")";
        $return = $this->db->query($query);
        return $return->result();
    }


    function isAuthor($userId,$landingId){
        $query	=	"SELECT count(*) as total FROM `tbtt_landing_page` WHERE user_id = ".$userId . " AND id = ".$landingId;
        $return = $this->db->query($query);
        if($return->num_rows > 0 ){
            return true;
        }else {
            return false;
        }
    }
    function createLandingPage($name = "",$templateId,$content="",$html ="",$userId,$list_id="",$list_name=""){
        $data = array(
                'name' => $name,
                'template_id' => $templateId,
                'content' => $content,
                'html' => $html,
                'created_date' => date("Y-m-d H:i:s"),
                'user_id' => $userId,
                'list_id'=>$list_id,
                'list_name'=>$list_name
            );
            $this->db->insert($this->_table, $data);
            return $this->db->insert_id();

            //$query = "INSERT IGNORE INTO tbtt_order VALUES (".$id.",NULL,'".$payment_method."','".$shipping_method."',".$order_saler.",".$order_user.")";
       
    }
    function updateLandingPage($id,$templateId = "",$content,$html = "",$userId){
        $data = array();
        if($content != ""){
            $data['content'] = $content;
        }
        if($templateId != ""){
            $data['template_id'] = $templateId;
        }

        if($userId != ""){
            $data['user_id'] = $userId;
        }
        if($html != ""){
            $data['html'] = $html;        	
        }
        
        $where['id'] = $id;
        $this->db->where($where);
        $return = $this->db->update('tbtt_landing_page',$data);
        return $return;
    }
    function update($data, $where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_landing_page", $data);
    }
    function deleteLandingPage($id){
        $query = "DELETE FROM `tbtt_landing_page` WHERE id =".$id;
        $return = $this->db->query($query);
        return $return;
    }
}