<?php
class Refund_orders_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_refundOrders";
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

}