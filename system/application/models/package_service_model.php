<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/8/2015
 * Time: 11:01 AM
 */
class Package_service_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_unit($filter) {

        $select = 'tbtt_package_service.*, tbtt_service.unit';
        $this->db->select($select);
        
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        $this->db->order_by("ordering", "asc");
        $this->db->join('tbtt_service', 'tbtt_service.id = tbtt_package_service.service_id');
        #Query
        $query = $this->db->get("tbtt_package_service");

        $result = $query->row_array();
        $query->free_result();
        return $result;
    }

}