<?php
class Delivery_comments_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_delivery_comments";
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
        $query = $this->db->get($this->table_name);
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
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    
    function add($data)
    {
            $this->db->insert($this->table_name, $data);
            return $this->db->insert_id();
    }

    function update($data, $where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update($this->table_name, $data);
    }
    
    function delete($where)
    {
        return $this->db->delete($this->table_name, $where);
    }
    
    public function getAllCommentByOrder($where,$order=NULL){
        $this->db->cache_off();
        $this->db->select('tbl.content,tbl.lastupdated,tbl.status_changedelivery,tbl.status_comment,tbl.user_id,tbl.bill,tbl.id_request');
        $this->db->from('tbtt_delivery_comments AS tbl');
        $this->db->join('tbtt_changedelivery AS chr','chr.id = tbl.id_request','RIGHT');
        
        if(isset($where['order_id']) && $where['order_id']){
            $this->db->where('chr.order_id',$where['order_id']);
        }
        
        if($order){
            $this->db->order_by($order['key'],$order['value']);
        }

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result();
    }

}