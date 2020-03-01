<?php
#****************************************#
# * @Author: baotran                   #
# * @Email: tranbaothe@gmail.com          #
# * @Website: http://tranthebao.wordpress.com
# * @Copyright: 2017 - 2018              #
#****************************************#
class Sub_company_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }


    /** *********************************************************** **/

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "sho_id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "sho_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

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
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    function fetch_join1($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "sho_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
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

            $this->db->group_by('shc_saler');
        }

        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        };
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function add($data)
    {
        return $this->db->insert("tbtt_shop", $data);
    }

    function update($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_shop", $data);
    }

    function delete($value, $field = "sho_id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_shop");
    }
    function deleted($value, $field = "sho_user", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_shop");
    }

    function getShopPackage($shopId)
    {
        $this->db->cache_off();
        $select = "(SELECT
                    tbtt_package.info_id
                  FROM
                    tbtt_package
                  WHERE tbtt_package.id = tbtt_package_user.package_id ) AS package ";
        $this->db->select($select, false);
        $this->db->from('tbtt_package_user');
        $where = array('tbtt_package_user.user_id' => $shopId, 'tbtt_package_user.status' => 1, 'tbtt_package_user.payment_status' => 1);
        $this->db->where($where);
        $this->db->where('NOW() >= tbtt_package_user.begined_date', null);
        $this->db->where('NOW() <= tbtt_package_user.ended_date', null);
        $this->db->order_by('tbtt_package_user.id', 'DESC');
        $this->db->limit(1, 0);
        $query = $this->db->get("tbtt_shop");
        $result = $query->row_array();
        $query->free_result();

        return $result['package'];
    }

    function getShopPackage1($shopId)
    {
        $this->db->select("tbtt_service.*");
        $this->db->from("tbtt_package_user");
        $this->db->join('tbtt_package','tbtt_package.id = tbtt_package_user.package_id', 'INNER');
        $this->db->join('tbtt_package_service','tbtt_package_service.package_id = tbtt_package.info_id', 'INNER');
        $this->db->join('tbtt_service','tbtt_service.id = tbtt_package_service.service_id', 'INNER');        
        $this->db->where('tbtt_package_user.user_id', $shopId);       
        $this->db->where('tbtt_service.name LIKE ', 'Dịch vụ Gian hàng bảo đảm');
        $this->db->order_by('tbtt_package_user.id', 'DESC');
        $this->db->limit(1, 0);

        $query = $this->db->get();
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    public function find_by($where = FALSE, $select = "*", $is_single_result = FALSE, $order_by = NULL, $limit = NULL, $offset = NULL)
    {
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
                $query = $this->db->get($this->table_name);
            } else {
                $query = $this->db->get_where($this->table_name, $where);
            }
        } else {
            $query = $this->db->get($this->table_name);
        }
        return $is_single_result ? $query->row() : $query->result();
    }

    public function updateFreePackage($sho_user)
    {
        $sql = "UPDATE {$this->table_name} SET sho_package = '1', sho_package_start = NULL, sho_package_end = NULL WHERE sho_user= '{$sho_user}'";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }
    
    public function getLisShops($where=NULL,$order=NULL,$limit=NULL,$offset=NULL,$total = NULL) {

            $this->db->select('tbl.*,usr.use_group');
            $this->db->from($this->table_name.' AS tbl');
            $this->db->join('tbtt_user AS usr','usr.use_id = tbl.sho_user');
            if(isset($where['sho_province']) && $where['sho_province']){
                $like_province = ",".$where['sho_province'].",";
                $where_like_province = "(sho_province = ".$where['sho_province']." OR sho_provinces LIKE '%".$like_province."%')";
                $this->db->where($where_like_province);
                
            }
            if(isset($where['shop_type']) && $where['shop_type'] == 1){
                $where_shoptype = "(shop_type = 1 OR shop_type = 2)";
                $this->db->where($where_shoptype);
            }
            if(isset($where['use_group']) && $where['use_group']){
                $this->db->where('usr.use_group',$where['use_group']);
            }
            if(isset($where['sho_name']) && $where['sho_name']){
                $where_like_shopname = "(sho_name LIKE '%".trim($where['sho_name'])."%' OR sho_link LIKE '%".trim($where['sho_name'])."%')";
                $this->db->where($where_like_shopname);
            }

            if($order){
                $this->db->order_by($order['key'],$order['value']);
            }

        if ($offset) {
            $this->db->limit($limit, $offset);
        } else if ($limit) {
            $this->db->limit($limit);
        }

        $query = $this->db->get();
        if ($total) {
            return $query->num_rows();
        }

        /*echo $this->db->last_query();

        print_r($where);
        print_r($query->result());
        die;*/

        return $query->result();
    }
    function getShop( $filter = array())
    {
        $this->db->cache_off();
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
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->result_array();
        $query->free_result();
        //echo $this->db->last_query();
        return $result;
    }
    function getShopInfo( $filter = array())
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select'], false);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }
        #Query
        $query = $this->db->get("tbtt_shop");
        $result = $query->row_array();
        $query->free_result();
        //echo $this->db->last_query();
        return $result;
    }

}