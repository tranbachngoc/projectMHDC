<?php
//Develop by Phuc Nguyen
//nguyenvanphuc06262gmail.com
class District_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_district";
        $this->select = '*';
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
            $query = $this->db->get("tbtt_district");
            $result = $query->row();
            $query->free_result();
            return $result;
    }
    
    function add($data)
    {
            return $this->db->insert("tbtt_district", $data);
    }
    
    function delete($value, $field = "pre_id", $in = true)
    {
        if($in == true)
        {
                $this->db->where_in($field, $value);
        }
        else
        {
                $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_district");
    }

    public function find_by($where = FALSE, $select = "*", $is_single_result = FALSE, $order_by = NULL, $limit = NULL, $offset = NULL)
    {
        $this->db->cache_on();
        $this->db->select($select);
        if ($order_by != NULL) {
            $query = $this->db->order_by($order_by['key'], $order_by['value']);
        }

        if ($offset) {
            $this->db->limit($limit, $offset);
        } else if ($limit) {
            $this->db->limit($limit);
        }

        if ($where != FALSE) {
            $where_values = array_values($where);
            $where_key = array_keys($where);
            if (is_array($where_values[0])) {
                $this->db->where_in($where_key[0], $where_values[0]);
                $query = $this->db->get($this->table);
            } else {
                $query = $this->db->get_where($this->table, $where);
            }
        } else {
            $query = $this->db->get($this->table);
        }
        return $is_single_result ? $query->row() : $query->result();
    }

    function getDistrict( $filter = array())
    {
        $this->db->cache_off();
        $this->db->distinct();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }
        if(isset($filter['order_by'])){
            $this->db->order_by($filter['order_by']);
        }
        
        $this->db->where('pre_status',1);
        
        #Query
        $query = $this->db->get("tbtt_district");
        $result = $query->result_array();
        $query->free_result();
        //echo $this->db->last_query();
        return $result;
    }
    
    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if($where && $where != "")
        {
            $this->db->where($where, NULL, false);
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
        $query = $this->db->get("tbtt_district");
        //echo $this->db->last_query();exit;
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    
    function update($data, $where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_district", $data);
    }
    
}