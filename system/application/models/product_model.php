<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Product_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_product";
        $this->select = '*';
        $this->filter = array();
        $this->where = array();
        $this->total = 0;
    }

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($where && $where != "") {
            $this->db->where($where, NULL, false);
        }
        #Query
        $query = $this->db->get("tbtt_product");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    //Load product and detail product, not use differen case, by Bao Tran
    function getProAndDetail($select="*", $where="", $pro_id=0, $color="", $size="", $material="")
    {
        $this->db->cache_off();

        $clause = ''; 

        if ($color && $color != "") {
            $clause .= ' AND dp_color LIKE "%'. $color .'%"';
        }
        if ($size && $size != "") {
            $clause .= ' AND dp_size LIKE "%'. $size .'%"';
        }
        if ($material && $material != "") {
            $clause .= ' AND dp_material LIKE "%'. $material .'%"';
        }

        $sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE dp_pro_id = '. $pro_id .' '. $clause .' ORDER BY id ASC LIMIT 1) AS T2';
        //$sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE dp_pro_id = '. $pro_id .' '. $clause .' ORDER BY id DESC) AS T2';

        $this->db->select($select, false); 
        $this->db->from('tbtt_product');       
        $this->db->join($sql_select_join, 'T2.`dp_pro_id` = tbtt_product.`pro_id`', 'LEFT');
        $this->db->where($where, NULL, false);
        #Query
        $query = $this->db->get();
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function getProAndDetail0($select="*", $where="", $pro_id=0, $color="", $size="", $material="")
    {
        $this->db->cache_off();

        $clause = '';

        if ($color && $color != "") {
            $clause .= ' AND dp_color LIKE "%'. $color .'%"';
        }
        if ($size && $size != "") {
            $clause .= ' AND dp_size LIKE "%'. $size .'%"';
        }
        if ($material && $material != "") {
            $clause .= ' AND dp_material LIKE "%'. $material .'%"';
        }

//        $sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE dp_pro_id = '. $pro_id .' '. $clause .' ORDER BY id DESC LIMIT 1) AS T2';
        $sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE dp_pro_id = '. $pro_id .' '. $clause .' ORDER BY id DESC) AS T2';

        $this->db->select($select, false);
//        $this->db->from('tbtt_product');
        $this->db->join($sql_select_join, 'T2.`dp_pro_id` = tbtt_product.`pro_id`', 'LEFT');
        $this->db->where($where, NULL, false);
        #Query
        $query = $this->db->get("tbtt_product");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function getProAndDetailForCheckout($select="*", $where="", $dp_id=0)
    {
        $this->db->cache_off();
        $sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE id = '. $dp_id .') AS T2';
        $this->db->select($select, false); 
        $this->db->from('tbtt_product');       
        $this->db->join($sql_select_join, 'T2.`dp_pro_id` = tbtt_product.`pro_id`', 'LEFT');
        $this->db->where($where, NULL, false);
        #Query
        $query = $this->db->get();
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
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
        $query = $this->db->get("tbtt_product");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function getAzibaiProduct($select = "*", $user_like)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        $this->db->where('tbtt_product_press_af.begin_date = CURDATE()', null, false);
        $this->db->where('tbtt_product_press_af.user_id_af LIKE "%' . $user_like . '%"', null, false);
        $this->db->where('tbtt_product.pro_status', 1);
        $this->db->from('tbtt_product_press_af');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_press_af.pro_id', 'left');
        $this->db->limit(8, 0);
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join1($select = "*", $join, $table, $on, $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($join && ($join == "INNER" || $join == "LEFT" || $join == "RIGHT") && $table && $table != "" && $on && $on != "") {
            $this->db->join($table, $on, $join);
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
        $query = $this->db->get("tbtt_product");
        $result = $query->result();        
        $query->free_result();
        return $result;
    }

    function fetch_join3($select, $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $groupby = '')
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
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
            //$this->db->group_by('af_id ');
            
        }
        if($groupby && $groupby != ''){
            $this->db->group_by($groupby);
        }else{
            $this->db->group_by('tbtt_product.pro_id');
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by('tbtt_product.pro_id');
        }
        #Query
        $query = $this->db->get("tbtt_product");
        $result = array();
        $result['data'] = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL, $return = 'array')
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
        $query = $this->db->get("tbtt_product");

        if(empty($return) || $return == 'array'){
            $result = $query->result();
        }

        if($return == 'row'){
            $result = $query->row();
        }

        $query->free_result();
        return $result;
    }

    function fetch_join4($select, $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $wherestore = "", $order = "use_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $groupby = '')
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
        if ($join_4 && ($join_4 == "INNER" || $join_4 == "LEFT" || $join_4 == "RIGHT") && $table_4 && $table_4 != "" && $on_4 && $on_4 != "") {
            $this->db->join($table_4, $on_4, $join_4);
        }
        if ($wherestore && $wherestore != "") {
            $this->db->where($wherestore);
        }
        if($groupby && $groupby != ''){
            $this->db->group_by($groupby);
        }else{
            $this->db->group_by('tbtt_product.pro_id');
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by('tbtt_product.pro_id');
        }
        #Query
        $query = $this->db->get("tbtt_product");
        $result = array();
        $result['data'] = $query->result();
        $query->free_result();
        return $result;
    }

    function add($data)
    {
        $aData = array(
            'pro_vip'  =>  0,
            'is_asigned_by_admin'  => 0,
            'id_shop_cat'  =>  0,
            'pro_of_shop'  =>  0,
        );
        $data = array_merge($aData,$data);

        $this->db->set('up_date', 'NOW()', false);
        $this->db->set($data);
        $this->db->insert("tbtt_product");
        return $this->db->insert_id();
    }

    function update($data, $where = "")
    {

        // $aData = array(
        //     'pro_vip'  =>  0,
        //     'is_asigned_by_admin'  => 0,
        //     'id_shop_cat'  =>  0,
        //     'pro_of_shop'  =>  0,
        //     'pro_saleoff_value' => 0,
        // );
        // $data = array_merge($aData,$data);

        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_product", $data);
    }

    function delete($value, $field = "pro_id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete("tbtt_product");
    }

    function fetchAF($select = "*", $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0, $group = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id');
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if($group!=NULL){
            $this->db->group_by($group);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }

        #Query
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetchAF_pro($select = "*", $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0, $group = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id');
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if($group!=NULL){
            $this->db->group_by($group);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }

        #Query
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function getAFProductsByCat($uid, $parent_id)
    {
        $this->db->cache_off();
        $sql = 'SELECT
				  pro_info.*
				FROM
				  (SELECT
					@rn :=
					CASE
					  WHEN @var_pro_category = pro_category
					  THEN @rn + 1
					  ELSE 1
					END AS rn,
					@var_pro_category := pro_category AS cat,
					info.*
				  FROM
					(SELECT
					  tbtt_product.pro_id,
					  tbtt_product.pro_name,
					  tbtt_product.pro_descr,
					  tbtt_product.pro_cost,
					  tbtt_product.pro_currency,
					  tbtt_product.pro_category,
					  tbtt_product.pro_image,
					  tbtt_product.pro_dir,
					  tbtt_product.pro_user,
					  tbtt_product.pro_view,
					  tbtt_product.pro_buy,
					  tbtt_product.pro_comment
					  ' . DISCOUNT_QUERY . '
					FROM
					  (tbtt_product_affiliate_user)
					  JOIN tbtt_product
						ON tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id
					WHERE pro_status = 1 AND pro_user <> ' . $parent_id . '
					  AND tbtt_product_affiliate_user.homepage = 1 AND tbtt_product_affiliate_user.use_id = ' . $uid . ' ORDER BY pro_category) AS info) AS pro_info
				WHERE pro_info.rn <= 4 ';
        // Reset count number
        $this->db->query("SET @rn :=0");
        $query = $this->db->query($sql);
        /*echo "\n";
        echo $this->db->last_query();
        echo "\n";*/
        return $query->result();
    }

    function getProductsByCat($uid)
    {
        $this->db->cache_off();
        $sql = 'SELECT
				  pro_info.*
				FROM
				  (SELECT
					@rn :=
					CASE
					  WHEN @var_pro_category = pro_category
					  THEN @rn + 1
					  ELSE 1
					END AS rn,
					@var_pro_category := pro_category AS cat,
					info.*
				  FROM
					(SELECT
					  tbtt_product.pro_id,
					  tbtt_product.pro_name,
					  tbtt_product.pro_descr,
					  tbtt_product.pro_cost,
					  tbtt_product.pro_currency,
					  tbtt_product.pro_category,
					  tbtt_product.pro_image,
					  tbtt_product.pro_dir,
					  tbtt_product.pro_user,
					  tbtt_product.pro_view,
					  tbtt_product.pro_buy,
					  tbtt_product.pro_comment
					  ' . DISCOUNT_QUERY . '
					FROM
					  tbtt_product
					WHERE pro_status = 1 AND pro_user  = ' . $uid . ' ORDER BY pro_category) AS info) AS pro_info
				WHERE pro_info.rn <= 4 ';
        // Reset count number
        $this->db->query("SET @rn :=0");
        $query = $this->db->query($sql);
        //echo "\n";
        //echo $this->db->last_query();
        //echo "\n";
        return $query->result();
    }

    function getCategoryInfo($cats)
    {
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from('tbtt_category');
        $this->db->where_in('cat_id', $cats);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getAfProducts($select = "*", $where = "", $order = "tbtt_product.pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->join('tbtt_province', 'tbtt_province.pre_id = tbtt_shop.sho_province');

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
        if ($group != NULL) {
            $this->db->group_by($group);
        }
        #Query
        $query = $this->db->get();
        $result = array();
        $result['data'] = $query->result();
        $query->free_result();
        // Get total product


        $this->db->select('count(*) as total', false);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id', 'left');
        if ($where && $where != "") {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $result['total'] = $query->row();

        $query->free_result();

        return $result;
    }

    function getAfProducts1($select = "*", $where = "", $order = "tbtt_product.pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        $this->db->from('tbtt_product');        
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_product.pro_category');

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
        if ($group != NULL) {
            $this->db->group_by($group);
        }
        #Query
        $query = $this->db->get();       
        $result = $query->result();        
        $query->free_result();
        return $result;
    }

    //  khong cho AFF chon sp GH
    function getAfProductsnew($select = "*", $where = "", $order = "tbtt_product.pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group=NULL)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_product_affiliate_user', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->join('tbtt_province', 'tbtt_province.pre_id = tbtt_shop.sho_province');

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
        if ($group != NULL) {
            $this->db->group_by($group);
        }
        #Query
        $query = $this->db->get();
        $result = array();
        $result['data'] = $query->result();
        $query->free_result();
        // Get total product


        $this->db->select('count(*) as total', false);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id', 'left');
        if ($where && $where != "") {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $result['total'] = $query->row();

        $query->free_result();

        return $result;
    }

    function updateBuyNum($pro_id)
    {
        $this->db->set('pro_buy', 'pro_buy + 1', FALSE);
        $this->db->where('pro_id', $pro_id);
        return $this->db->update("tbtt_product");
    }

    function updateProBuy($pro_id, $num)
    {
        $this->db->set('pro_buy', 'pro_buy + ' + $num, FALSE);
        $this->db->where('pro_id', $pro_id);
        return $this->db->update("tbtt_product");
    }

    function getAFLink($shop)
    {
        $this->db->cache_off();
        $this->db->select('CONCAT("?af_id=", af_key) AS aflink', false);
        $this->db->from('tbtt_user');
        $this->db->where('use_id', $shop);
        $query = $this->db->get();
        $afLink = $query->row_array();
        if (!empty($afLink)) {
            return $afLink['aflink'];
        } else {
            return '';
        }
    }

    function fetchCategory($select = "*", $filter = array(), $_provinces = NULL, $total = FALSE)
    {
        $this->db->cache_off();
        $where = array();

        $this->filter['pro_name'] = isset($_REQUEST['pro_name']) ? trim($_REQUEST['pro_name']) : '';
        if ($this->filter['pro_name'] != '') {
            $this->db->like('tbtt_product.pro_name', $this->filter['pro_name']);
        }
        //Filter price
        $priceFrom = isset($_REQUEST['pf']) ? (int)$_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
            $where['tbtt_product.pro_cost >= '] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? (int)$_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
            $where['tbtt_product.pro_cost <= '] = $priceTo;
        }

        $this->filter['sort'] = isset($_REQUEST['sort']) ? trim($_REQUEST['sort']) : 'product';

        $where['tbtt_product.pro_image <> '] = 'none.gif';
        $where['tbtt_product.pro_cost > '] = 0;
        $where['tbtt_product.pro_status'] = 1;
        //$where['tbtt_product.pro_category IN ('] = $pro_cat.')' ;

        $this->filter['sort'] = isset($_REQUEST['sort']) ? trim($_REQUEST['sort']) : 'product';
        switch ($this->filter['sort']) {
            case 'product':
                $this->db->order_by("rand()");
                break;
            // case 'guarantee':
            //     $this->db->order_by("rand()");
            //     break;
            // case 'discount':
            //     $where['tbtt_product.pro_saleoff'] = 1;
            //     $this->db->order_by("rand()");
            //     break;
            case 'seller':
                $this->db->order_by("tbtt_product.pro_buy", "desc");
                break;
        }

        $this->db->select($select, false);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'left');
        $this->db->join('tbtt_province', 'tbtt_province.pre_id = tbtt_shop.sho_province', 'left');
        $this->db->join('tbtt_detail_product', 'tbtt_product.pro_id = tbtt_detail_product.dp_pro_id', 'left');

        if ($_provinces) {
            $this->db->where('(tbtt_shop.sho_province = ' . $_provinces . ' OR tbtt_shop.sho_provinces LIKE "%,' . $_provinces . ',%")');
        }


        if ($filter['subcat1']) {
            $this->db->where('tbtt_product.pro_category IN (' . $filter['subcat1'] . ')');
            //  $where['tbtt_product.pro_category'] = $filter['subcat1'] ;
        }
        $this->db->where($where);

        $this->filter['type'] = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
        if ($this->filter['type'] == 'discount') {
            $this->db->where("tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))");
        }

        if ($this->filter['sort'] == 'guarantee') {
            $this->db->where('EXISTS (SELECT
							  tbtt_package_user.id
							FROM
							  tbtt_package_user
							  LEFT JOIN tbtt_package
								ON tbtt_package_user.package_id = tbtt_package.id
							WHERE NOW() >= tbtt_package_user.begined_date
							  AND NOW() <= tbtt_package_user.ended_date
							  AND tbtt_package_user.status = 1
							  AND tbtt_package_user.payment_status = 1
							  AND tbtt_package.info_id >= 2
							  AND tbtt_package_user.user_id = tbtt_shop.sho_user)', null, false);
        }


        if ($filter['limit'] || $filter['start']) {
            if ($filter['start']) {
                $main_limit = ' LIMIT ' . $filter['start'] . ',' . $filter['limit'];
            } else {
                $main_limit = ' LIMIT ' . $filter['limit'];
            }

        }

        //sub query
        $query = $this->db->get();
        $result = $query->result();
        $subquery = $this->db->last_query();

        //main query
        if ($total) {
            $sql = "select * from ( {$subquery} ) AS subquery group by subquery.sho_user";
            $mainquery = $this->db->query($sql);
            return $mainquery->num_rows();
        } else {
            $sql = "select * from ( {$subquery} ) AS subquery group by subquery.sho_user" . $main_limit;
            $mainquery = $this->db->query($sql);
            $mainresult = $mainquery->result();
            return $mainresult;
        }
    }

    private function fetchCategoryTotal($filter)
    {
        $this->db->cache_off();
        $where = array();
        if ($this->filter['pro_name'] != '') {
            $this->db->like('tbtt_product.pro_name', $this->filter['pro_name']);
        }
        //Filter price
        if ($this->filter['pf'] > 0) {
            $where['tbtt_product.pro_cost >= '] = $this->filter['pf'];
        }
        if ($this->filter['pt'] > 0) {
            $where['tbtt_product.pro_cost <= '] = $this->filter['pt'];
        }

        $this->filter['sort'] = isset($_REQUEST['sort']) ? trim($_REQUEST['sort']) : 'product';


        $where['tbtt_product.pro_image <> '] = 'none.gif';
        $where['tbtt_product.pro_cost > '] = 0;
        $where['tbtt_product.pro_status'] = 1;
        //$where['pro_cost > '] = 0 ;

        $this->db->select('COUNT(*) AS total', false);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'left');
        $this->db->join('tbtt_province', 'tbtt_province.pre_id = tbtt_shop.sho_province', 'left');
        $this->db->where($where);
        if (!empty($filter['subcat'])) {
            $this->db->where_in('tbtt_product.pro_category', $filter['subcat']);
        }

        if ($this->filter['sort'] == 'guarantee') {
            $this->db->where('EXISTS (SELECT
							  tbtt_package_user.id
							FROM
							  tbtt_package_user
							  LEFT JOIN tbtt_package
								ON tbtt_package_user.package_id = tbtt_package.id
							WHERE NOW() >= tbtt_package_user.begined_date
							  AND NOW() <= tbtt_package_user.ended_date
							  AND tbtt_package_user.status = 1
							  AND tbtt_package_user.payment_status = 1
							  AND tbtt_package.info_id >= 3
							  AND tbtt_package_user.user_id = tbtt_shop.sho_user)', null, false);
        }


        $query = $this->db->get();
        $result = $query->row_array();
        $query->free_result();

        $this->total = $result['total'];
    }

    function buildLink()
    {
        $parrams = array();
        foreach ($this->filter as $key => $val) {
            if ($val != '') {
                array_unshift($parrams, $key . '=' . $val);
            }
        }
        return '?' . implode('&', $parrams);
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function  getFilter()
    {
        return $this->filter;
    }

    function getProducts($filter)
    {
        $this->db->cache_off();
        if (isset($filter['select'])) {
            $this->db->select($filter['select'], false);
        }
        $this->db->from('tbtt_product');
        if (isset($filter['where'])) {
            $this->db->where($filter['where']);
        }
        if (isset($filter['where_sub'])) {
            $this->db->where($filter['where_sub'], NULL, FALSE);
        }
        if (isset($filter['group_by'])) {
            $this->db->group_by($filter['group_by']);
        }
        if (isset($filter['limit'])) {
            $this->db->limit($filter['limit']);
        }
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        //echo $this->db->last_query();
        return $result;

    }

    public function play_box($where_position = "")
    {
        $this->db->cache_off();
        $sql = "SELECT
				  pro_user,
				  pro_id,
				  pro_name,
				  pro_cost,
				  pro_image,
				  pro_dir,
				  pro_category " . DISCOUNT_QUERY . "
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_product
					ON tbtt_product.pro_id = tbtt_package_daily_content.content_id
                                  LEFT JOIN tbtt_package_daily_user
					ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '05'
				  AND tbtt_package_daily_user.content_type = 'product'
				  AND tbtt_product.pro_id IS NOT NULL " . $where_position . "
				  ORDER BY RAND() LIMIT 0, 10";
        $query = $this->db->query($sql);
        return $query->result();

    }

    public function eat_box($where_position = "")
    {
        $this->db->cache_off();
        $sql = "SELECT
				  pro_user,
				  pro_id,
				  pro_name,
				  pro_cost,
				  pro_image,
				  pro_dir,
				  pro_category " . DISCOUNT_QUERY . "
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_product
					ON tbtt_product.pro_id = tbtt_package_daily_content.content_id
                                  LEFT JOIN tbtt_package_daily_user
					ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '04'
				  AND tbtt_package_daily_user.content_type = 'product'
				  AND tbtt_product.pro_id IS NOT NULL " . $where_position . "
				  ORDER BY RAND() LIMIT 0, 10";
        $query = $this->db->query($sql);
        return $query->result();

    }

    public function buy_box($where_position = "")
    {
        $this->db->cache_off();
        $sql = "SELECT
				  pro_user,
				  pro_id,
				  pro_name,
				  pro_cost,
				  pro_image,
				  pro_dir,
				  pro_category " . DISCOUNT_QUERY . "
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_product
					ON tbtt_product.pro_id = tbtt_package_daily_content.content_id
                                  LEFT JOIN tbtt_package_daily_user
					ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '06'
				  AND tbtt_package_daily_user.content_type = 'product'
				  AND tbtt_product.pro_id IS NOT NULL " . $where_position . "
				  ORDER BY RAND() LIMIT 0, 10";
        $query = $this->db->query($sql);
        return $query->result();

    }

    public function place_box($where_position = "")
    {
        $this->db->cache_off();
        $sql = "SELECT
				  pro_user,
				  pro_id,
				  pro_name,
				  pro_cost,
				  pro_image,
				  pro_dir,
				  pro_category " . DISCOUNT_QUERY . "
				FROM
				  tbtt_package_daily_content
				  LEFT JOIN tbtt_product
					ON tbtt_product.pro_id = tbtt_package_daily_content.content_id
                                  LEFT JOIN tbtt_package_daily_user
					ON tbtt_package_daily_user.id = tbtt_package_daily_content.order_id
				WHERE tbtt_package_daily_content.begin_date = CURDATE()
				  AND tbtt_package_daily_content.p_type = '07'
				  AND tbtt_package_daily_user.content_type = 'product'
				  AND tbtt_product.pro_id IS NOT NULL " . $where_position . "
				  ORDER BY RAND() LIMIT 0, 10";
        $query = $this->db->query($sql);
        return $query->result();

    }

    public function news_box()
    {
        $sql = "SELECT
            not_id,
            not_title,
            not_image,
            not_dir_image,
            not_begindate
          FROM
            tbtt_package_daily_content
            LEFT JOIN tbtt_content
                  ON tbtt_content.not_id = tbtt_package_daily_content.content_id
          WHERE tbtt_package_daily_content.begin_date = CURDATE()
            AND tbtt_package_daily_content.p_type = '03'
            AND content_type = 'news'
            AND tbtt_content.not_id IS NOT NULL
            ORDER BY RAND() LIMIT 0, 10";
        $query = $this->db->query($sql);
        return $query->result();

    }

    //build by Phuc Nguyen
    public function getListProducts($where = NULL, $order = NULL, $limit = NULL, $offset = NULL, $total = NULL)
    {
        $this->db->select("sho.sho_name,pro.pro_id,pro.pro_name,pro.pro_descr,pro.pro_province,pro.pro_cost,pro.pro_currency,pro.pro_image,pro.pro_dir,pro.pro_category,pro.pro_saleoff_value,pro.pro_type_saleoff,pro.pro_saleoff,pro.pro_view,pro_vote_total,pro.pro_vote,pro.pro_user,pro.pro_type");
        $this->db->from('tbtt_shop AS sho');
        $this->db->join('tbtt_product AS pro', 'pro.pro_user = sho.sho_user', 'inner');
        if (isset($where['pro_name']) && $where['pro_name']) {
            $this->db->like('pro.pro_name', $where['pro_name']);
        }
        if (isset($where['pro_type']) && $where['pro_type']){
            $this->db->where('pro.pro_type', $where['pro_type']);
        }
        if (isset($where['province']) && $where['province']) {
            $this->db->where('sho.sho_province', $where['province']);
        }

        if (isset($where['pro_user']) && $where['pro_user']) {
            $this->db->where('pro_user', $where['pro_user']);
        }

        if (isset($where['pro_status']) && $where['pro_status']) {
            $this->db->where('pro.pro_status', $where['pro_status']);
        }

        if (isset($where['low_price']) && $where['low_price']) {
            $this->db->where('pro.pro_cost >= ' . $where['low_price']);
        }

        if (isset($where['high_price']) && $where['high_price']) {
            $this->db->where('pro.pro_cost <= ' . $where['high_price']);
        }

        if (isset($where['sale_off']) && $where['sale_off']) {
            $this->db->where('pro.pro_saleoff', $where['sale_off']);
        }

        if ($order) {
            $this->db->order_by($order['key'], $order['value']);
        }

        if ($offset) {
            $this->db->limit($limit, $offset);
        } else if ($limit) {

            $this->db->limit($limit);
        }

        $query = $this->db->get();
//            echo $this->db->last_query();exit;
        if ($total) {
            return $query->num_rows();
        }
        return $query->result();
    }

    public function getListProductsSearch($where = NULL)
    {
        $this->db->select("pro.pro_name");
        $this->db->from('tbtt_shop AS sho');
        $this->db->join('tbtt_product AS pro', 'pro.pro_user = sho.sho_user', 'inner');

        if (isset($where['pro_name']) && $where['pro_name']) {
            $this->db->like('pro.pro_name', $where['pro_name']);
        }

        if (isset($where['province']) && $where['province']) {
            $this->db->where('sho.sho_province', $where['province']);
        }

        if (isset($where['pro_status']) && $where['pro_status']) {
            $this->db->where('pro.pro_status', $where['pro_status']);
        }

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result();
    }

    public function GetPackageValue($shop_userid)
    {
        $query = "SELECT  p.info_id, s.*, pu.begined_date,pu.ended_date FROM `tbtt_package_user` as pu JOIN `tbtt_package` as p ON p.id = pu.package_id JOIN `tbtt_package_service` as psv on psv.package_id = p.info_id JOIN `tbtt_service` as s on psv.service_id = s.id where  s.`group` = '01' AND pu.user_id = " . $shop_userid;
        $return = $this->db->query($query);
        return $return->result();
    }

    public function  GetLimitOfShopPackage($packageId)
    {
        $query = "select s.limit from tbtt_package_service as psv JOIN `tbtt_service` as s on psv.service_id = s.id where s.`group` = '01' AND psv.package_id = " . $packageId;
        $return = $this->db->query($query);
        return $return->result();
    }

    public function countProductPackage($where = NULL, $select = '*', $total = NULL)
    {
        $this->db->select($select);
        $this->db->from('tbtt_product');

        if (isset($where['pro_user']) && $where['pro_user']) {
            $this->db->like('pro_user', $where['pro_user']);
        }

        if (isset($where['pro_type'])) {
            $this->db->like('pro_type', $where['pro_type']);
        }

        if (isset($where['pro_status']) && $where['pro_status']) {
            $this->db->like('pro_status', $where['pro_status']);
        }

        $query = $this->db->get();
        if ($total) {
            return $query->num_rows();
        }
        return $query->result();
    }

    public function getProductOfSub($where = '', $select = '*', $total = NULL)
    {
        $this->db->select($select);
        $this->db->from('tbtt_product');
        
        if ($where && $where != "") {
            $this->db->where($where);
        }

        $query = $this->db->get();
        if ($total) {
            return $query->num_rows();
        }
        return $query->result();
    }

    function updateProBuyInstock($params)
    {
        if ($params['pro_buy'] > 0) {
            $this->db->set('pro_buy', 'pro_buy + ' . $params['shc_quantity'], FALSE);
        }
        if ($params['pro_instock'] > 0) {
            $this->db->set('pro_instock', 'pro_instock - ' . $params['shc_quantity'], FALSE);
        }
        $this->db->where('pro_id', $params['id']);
        return $this->db->update("tbtt_product");
    }

    function cancelProBuyInstock($params)
    {
        if ($params['pro_buy'] > 0) {
            $this->db->set('pro_buy', 'pro_buy - ' . $params['shc_quantity'], FALSE);
        }
        if ($params['pro_instock'] > 0) {
            $this->db->set('pro_instock', 'pro_instock + ' . $params['shc_quantity'], FALSE);
        }
        $this->db->where('pro_id', $params['id']);
        return $this->db->update("tbtt_product");
    }

    public function getProductEveryDay($where = NULL)
    {
        $this->db->select('pro_id');
        $this->db->from('tbtt_product');


        if (isset($where['created_date']) && $where['created_date']) {
            $this->db->where('created_date', $where['created_date']);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    function fetchPickupProduct($select = "*", $where = array(), $order = "pro_id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from('tbtt_package_daily_content');
        $this->db->join('tbtt_package_daily_user', 'tbtt_package_daily_user.id = tbtt_package_daily_content.order_id');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_package_daily_content.content_id');
        if(!empty($where)){
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
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function products_gallery($users_shop, $pro_type = PRODUCT_TYPE, $limit = 0, $start = 0, $count = false)
    {
    //tại sao ko tính % CTV ở trang shop ?
        $where  = "pro_status = 1 AND pro_user IN (". $users_shop . ") AND pro_type IN (" . $pro_type .") ";
        return $this->gets([
            'select'        => 'pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type',
            'param'         => $where,
            'orderby'       => 'pro_id DESC',
            'limit'         => $limit,
            'start'         => $start,
            'count'         => (boolean)$count
        ]);
    }

    function fetch_join_query($select = "*", $join, $table, $on, $join2, $table2, $on2, $where = "", $order = "pro_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL, $join3, $table3, $on3)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($join && $join != "" && $table && $table != "" && $on && $on != "") {
            $this->db->join($table, $on, $join);
        }        
        if ($join2 && $join2 != "" && $table2 && $table2 != "" && $on2 && $on2 != "") {
            $this->db->join($table2, $on2, $join2);
        }        
        if ($join3 && $join3 != "" && $table3 && $table3 != "" && $on3 && $on3 != "") {
            $this->db->join($table3, $on3, $join3);
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
        $query = $this->db->get("tbtt_product");
        $result = $query->result();        
        $query->free_result();
        return $result;
    }
}
