<?php
class Package_daily_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_one($filter)
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        #Query
        $query = $this->db->get("tbtt_package_daily");
        $result = $query->row_array();
        $query->free_result();
        return $result;
    }
    function get_package_detail($filter)
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }
        $this->db->from("tbtt_package_daily");
        $this->db->join("tbtt_package_daily_price", "tbtt_package_daily_price.pack_id = tbtt_package_daily.id", "left");
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        #Query
        $query = $this->db->get();

        $result = $query->row_array();
        //echo $this->db->last_query();
        $query->free_result();
        return $result;
    }
    function get_list($filter,$sho_style=array())
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
            if(!empty($sho_style)){
                $this->db->where_not_in('p_type',$sho_style);
            }
        }
        if(isset($filter['where_in'])){
            foreach ($filter['where_in'] as $key=>$val){
                $this->db->where_in($key,$val);
            }
        }


        $this->db->order_by("p_type", "asc");
        #Query

        $query = $this->db->get("tbtt_package_daily");

        $result = $query->result_array();

        $query->free_result();

        return $result;
    }
    function update($data, $where){
        foreach($where as $k=>$item){
            $this->db->where($k, $item);
        }
        $this->db->update('tbtt_package_daily', $data);
    }
    function add($data){
        $this->db->insert('tbtt_package_daily', $data);
    }
    function addContent($data){
        $this->db->insert('tbtt_package_daily_content', $data);
        $return = $this->db->insert_id();
        return $return;
    }
    function deleteContent($id,$order_id){
        $query = "DELETE FROM `tbtt_package_daily_content` WHERE content_id =".$id.' AND order_id='.$order_id;
        $return = $this->db->query($query);
        return $return;
    }
    function getContent($id){
        $query = "SELECT DISTINCT content_id FROM `tbtt_package_daily_content` WHERE order_id = ".$id;
        $return = $this->db->query($query);
        return $return->result_array();
    }
}
