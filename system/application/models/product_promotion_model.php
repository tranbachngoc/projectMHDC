<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 15:21 PM
 */
class Product_promotion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    function add($data)
    {
        return $this->db->insert_batch("tbtt_product_promotion", $data);
    }

    function addPromo($data)
    {
        return $this->db->insert("tbtt_product_promotion", $data);
    }

    function deleteRow($data)
    {
        $this->db->delete('tbtt_product_promotion', $data);
    }

    function getPromotion($data){
        $this->db->cache_off();
        $this->db->select('*, IF(dc_rate > 0, dc_rate, dc_amt) AS dc_amount, IF(dc_rate > 0, \'%\', \'Số tiền\') AS dc_type', false);
        $this->db->from('tbtt_product_promotion');
        $this->db->order_by('limit_from', 'asc');
        $this->db->where($data);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function getProductPromotion($data){

        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from('tbtt_product_promotion');
        $this->db->where('pro_id', $data['pro_id']);
        $this->db->where('CASE
                            WHEN limit_type = 1
                            THEN (
                              (
                                limit_from <= '.$data['qty'].'
                                OR limit_from = 0
                              )
                              AND (limit_to >= '.$data['qty'].'
                                OR limit_to = 0)
                            )
                            WHEN limit_type = 2
                            THEN (
                              (
                                limit_from <= '.$data['total'].'
                                OR limit_from = 0
                              )
                              AND (
                                limit_to >= '.$data['total'].'
                                OR limit_to = 0
                              )
                            )
                          END', null, false);
        $this->db->order_by('limit_from', 'desc');
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

   function fetch($select = "*", $where = "", $order = "", $by = "", $start = -1, $limit = 0)
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
        $query = $this->db->get("tbtt_product_promotion");
        $result = $query->result();
        $query->free_result();
        return $result;
    }



}