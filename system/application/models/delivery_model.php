<?php
class Delivery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_changedelivery";
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
    
    public function cron24hDelivery() {
        $this->db->cache_off();
        $this->db->select('tbl.*,ord.order_saler,ord.order_clientCode');
        $this->db->from($this->table_name.' AS tbl');
        $this->db->join('tbtt_order AS ord','tbl.order_id = ord.id');
        
        $this->db->where('tbl.status_id = "03"');
        $this->db->where('tbl.lastupdated <= now() - INTERVAL 1 DAY');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        return $query->result();
    }
    
     public function cronDelivery($where=NULL) {
        $this->db->cache_off();
        $this->db->select('tbl.*,ord.order_saler,ord.order_clientCode');
        $this->db->from($this->table_name.' AS tbl');
        $this->db->join('tbtt_order AS ord','tbl.order_id = ord.id');
        
        if(isset($where['status_id']) && $where['status_id']){
            $this->db->where('tbl.status_id = "'.$where['status_id'].'"');
        }
        
        //$this->db->where('tbl.lastupdated <= now() - INTERVAL '.timeCronDelivery.' HOUR');
        $query = $this->db->get();
        // echo $this->db->last_query(); exit;
        return $query->result();
    }

}