<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/26/2015
 * Time: 9:15 AM
 */
class Product_affiliate_user_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function check($data){
        $this->db->where('use_id', $data['use_id']);
        $this->db->where('pro_id', $data['pro_id']);
        $num_rows = $this->db->count_all_results('tbtt_product_affiliate_user');
        return $num_rows > 0 ? TRUE : FALSE;
    }

    function fetch($select = "*", $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
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
        $query = $this->db->get("tbtt_product_affiliate_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);
        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);
        }
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }
        #Query
        $query = $this->db->get("tbtt_product_affiliate_user");
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
        return $this->db->update("tbtt_product_affiliate_user", $data);
    }

    function add($data)
    {
        return $this->db->insert("tbtt_product_affiliate_user", $data);
    }

    function add_all($data)
    {
        return $this->db->insert_batch("tbtt_product_affiliate_user", $data);
    }

    function delete($data)
    {
        foreach($data as $k=>$v){
            $this->db->where($k, $v);
        }
        return $this->db->delete("tbtt_product_affiliate_user");
    }

    function insert($data){
        if($this->check($data) == FALSE){
            return $this->add($data);
        }else{
            return TRUE;
        }
    }

    function getTotalCategoriesByAff($userId){
        //$this->db->cache_off();
        if($userId > 0){
            $this->load->model('user_model');
            $user_detail = $this->user_model->get('*','use_id = '.$userId.' AND use_status = 1');
            if($user_detail->parent_id > 0){
                $user_parent = $this->user_model->get('*','use_id = '.$user_detail->parent_id.' AND use_status = 1');
                if($user_parent->use_group == 3){
                    $query	=	"SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = ".$userId . " and pro.pro_user <> ".$user_parent->use_id." GROUP BY pro.pro_category";
                }elseif($user_parent->use_group != 3 && $user_detail->parent_shop > 0){
                    $query	=	"SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = ".$userId." and pro.pro_user <> ".$user_detail->parent_shop." GROUP by pro.pro_category";
                }elseif($user_parent->use_group != 3 && $user_detail->parent_shop == 0){
                    $query	=	"SELECT au.use_id,pro.pro_id,pro.pro_category FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = ".$userId . " GROUP BY pro.pro_category";
                }
            }

            $return = $this->db->query($query);
            return $return->result();
        }
    }
    
}
