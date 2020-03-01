<?php
class Statistics_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
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
    
    public function getSumPackageUserStatistics($begin_date=NULL,$end_date=NULL,$options="day"){
        
        $this->db->cache_off();
        
        $this->db->select("SUM(real_amount) AS real_amount");
        $this->db->from('tbtt_package_user');
        
        if($options == "day"){
            $this->db->select("DATE(created_date) AS created_at");
            $this->db->where("created_date <= '".$end_date."' AND created_date >= '".$begin_date."'");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y-%m-%d')");
            $this->db->_protect_identifiers = TRUE;
        }

        if($options == "month"){
            $this->db->select("MONTH(created_date) AS created_at");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y-%m')");
            $this->db->_protect_identifiers = TRUE;
        }

        if($options == "year"){
            $this->db->select("YEAR(created_date) AS created_at");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y')");
            $this->db->_protect_identifiers = TRUE;
        }
        
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->created_at] = $vals->real_amount;
            }
        }
        return $lists;
    }
    
    public function getSumPackageDailyUserStatistics($begin_date=NULL,$end_date=NULL,$options="day"){
        
        $this->db->cache_off();
        
        $this->db->select("SUM(real_amount) AS real_amount");
        $this->db->from('tbtt_package_daily_user');
        
        if($options == "day"){
            $this->db->select("DATE(created_date) AS created_at");
            $this->db->where("created_date <= '".$end_date."' AND created_date >= '".$begin_date."'");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y-%m-%d')");
            $this->db->_protect_identifiers = TRUE;
        }
        if($options == "month"){
            $this->db->select("MONTH(created_date) AS created_at");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y-%m')");
            $this->db->_protect_identifiers = TRUE;
        }
        if($options == "year"){
            $this->db->select("YEAR(created_date) AS created_at");
            $this->db->_protect_identifiers = FALSE;
            $this->db->group_by("DATE_FORMAT(created_date,'%Y')");
            $this->db->_protect_identifiers = TRUE;
        }
        
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->created_at] = $vals->real_amount;
            }
        }
        return $lists;       
    }
    
    public function getOrdersStatistics($begin_date=NULL,$end_date=NULL,$options="day",$user_id=array()){
        
        $this->db->cache_off();
        $this->db->select("SUM(order_total_no_shipping_fee) AS order_total");
        $this->db->from('tbtt_order');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where_in('order_status',array('01','02','03','98'));
        
        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`))");
        } else if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`))");
        } else if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`))");
        } else {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
        }
        
        if($user_id){
            if($this->session->userdata('sessionGroup') == 2){
                $this->db->join('tbtt_showcart','tbtt_showcart.shc_orderid = tbtt_order.id');
                $this->db->where_in('tbtt_showcart.af_id', $user_id);
            } else {
                $this->db->where_in('order_saler', $user_id);
            }
        }
        
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->updated_date] = $vals->order_total;
            }
        }
        return $lists;
    }

    public function getOrders($begin_date=NULL,$end_date=NULL,$options="day",$where=NULL){

        $this->db->cache_off();
        $this->db->select("id, shc_orderid, shc_total,tbtt_showcart.af_amt,tbtt_showcart.af_rate, shc_quantity, em_discount");
        $this->db->from('tbtt_order');
        $this->db->join('tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where_in('order_status',array('01','02','03','98'));

        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`)),id");
        } else if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`)),id");
        } else if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`)),id");
        } else {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
        }

        /*if($user_id){
            if($this->session->userdata('sessionGroup') == 2){
                $this->db->join('tbtt_showcart','tbtt_showcart.shc_orderid = tbtt_order.id');
                $this->db->where_in('tbtt_showcart.af_id', $user_id);
            } else {
                $this->db->where_in('order_saler', $user_id);
            }
        }*/
        if($where!=NULL) {
            $this->db->where($where);
        }
        $query      =   $this->db->get();
//        echo $this->db->last_query();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists['order_total'] = $vals->shc_total;
                $lists[$vals->updated_date] = $vals->order_total;
            }
        }
//        return $lists;
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function getOrders_shopAff($begin_date=NULL,$end_date=NULL,$options="day",$where=NULL){

        $this->db->cache_off();
        $this->db->select("id,shc_total");
        $this->db->from('tbtt_order');
        $this->db->join('tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where_in('order_status',array('01','02','03','98'));

        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`)),id");
        } else if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`)),id");
        } else if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
//            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`)),id");
        } else {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
        }

        /*if($user_id){
            if($this->session->userdata('sessionGroup') == 2){
                $this->db->join('tbtt_showcart','tbtt_showcart.shc_orderid = tbtt_order.id');
                $this->db->where_in('tbtt_showcart.af_id', $user_id);
            } else {
                $this->db->where_in('order_saler', $user_id);
            }
        }*/
        if($where!=NULL) {
            $this->db->where($where);
        }
        $query      =   $this->db->get();
//        echo $this->db->last_query();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists['order_total'] = $vals->shc_total;
                $lists[$vals->updated_date] = $vals->order_total;
            }
        }
//        return $lists;
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function getQuantityOrder($begin_date=NULL,$end_date=NULL,$options="day",$where=NULL){

        $this->db->cache_off();
        $this->db->select("count(Distinct id) as shc_total");
        $this->db->from('tbtt_order');
        $this->db->join('tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");

        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`))");
        }
        if($where!=NULL) {
//            $this->db->join('tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id');
            $this->db->where($where);
        }

        $query      =   $this->db->get();
//        $rs      =   $query->num_row();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->updated_date] = $vals->order_total_no_shipping_fee;
            }
        }
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    
    public function getQuantityOrderStatistics($begin_date=NULL,$end_date=NULL,$options="day",$user_id=array()){
        
        $this->db->cache_off();
        $this->db->select("COUNT(id) AS count");
        $this->db->from('tbtt_order');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        
        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`))");
        }
        if($user_id){
            if($this->session->userdata('sessionGroup') == 2){
                $this->db->join('tbtt_showcart','tbtt_showcart.shc_orderid = tbtt_order.id');
                $user_id = array_map('intval', $user_id);
                $this->db->where_in('tbtt_showcart.af_id', $user_id);
            } else {
                $user_id = array_map('intval', $user_id);
                $this->db->where_in('order_saler', $user_id);
            }
            
        }
        
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->updated_date] = $vals->count;
            }
        }
        return $lists;
    }

    public function getTamtinh($begin_date = NULL, $end_date = NULL, $options = "day", $where = '')
    {

        $this->db->cache_off();
        if($this->session->userdata('sessionGroup') == AffiliateUser){
            $this->db->select('id,tbtt_category.cat_id,shc_total,tbtt_showcart.af_id,  tbtt_showcart.af_amt, tbtt_showcart.af_rate,((shc_total +em_discount)*tbtt_showcart.af_rate)/100 AS HoahongPT, tbtt_showcart.af_amt*shc_quantity as HoahongTien');
        } else {
            $this->db->select('shc_orderid,id,tbtt_category.cat_id, shc_total, tbtt_showcart.af_id, tbtt_showcart.af_amt, tbtt_showcart.af_rate, 
            shc_total - (shc_total+em_discount) * tbtt_showcart.af_rate/100 as HoahongPT, 
            shc_total - (tbtt_showcart.af_amt*shc_quantity) as HoahongTien, em_discount
            ');

            //      test lại      SELECT id,order_total_no_shipping_fee, tbtt_showcart.af_id, tbtt_showcart.af_amt, tbtt_showcart.af_rate, order_total_no_shipping_fee -(order_total_no_shipping_fee*(tbtt_showcart.af_rate/100)*shc_quantity) AS HoahongPT, order_total_no_shipping_fee-(tbtt_showcart.af_amt*shc_quantity) as HoahongTien,em_discount,shc_total - (shc_total+em_discount)*tbtt_showcart.af_rate/100 as giasi
        }

        $this->db->from('tbtt_showcart');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user');
        $this->db->join('tbtt_order', 'tbtt_showcart.shc_orderid = tbtt_order.id');
        $this->db->join('tbtt_category', 'tbtt_showcart.pro_category = tbtt_category.cat_id', 'left');
        if ($where != '') {
            $this->db->where($where);
        }
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where_in('tbtt_showcart.shc_status',array('01','02','03','98'));

        if ($options == "day") {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            // $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`)),id,shc_quantity");
        } else if ($options == "month") {
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            // $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`)),id,shc_quantity");
        } else if ($options == "year") {
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            if($this->session->userdata('sessionGroup')==AffiliateStoreUser){
            // $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`)),id,shc_quantity");
            }
        } else {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
        }
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function getSumAffiliateStatistics($begin_date=NULL,$end_date=NULL,$group_type=2){
        
        $this->db->cache_off();
        $this->db->select("COUNT(use_id) AS count");
        $this->db->from('tbtt_user');
        $this->db->where("use_regisdate <= '".$end_date."' AND use_regisdate >= '".$begin_date."' ");
		$this->db->where('use_group',$group_type);
        $this->db->select('MONTH(FROM_UNIXTIME(`use_regisdate`)) AS register_date');
        $this->db->group_by("MONTH(FROM_UNIXTIME(`use_regisdate`))");
		
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->register_date] = $vals->count;
            }
        }
        return $lists;
    }
    public function getCurrentEarningsStatistics($detail='public',$month_year=NULL,$user_id=array(),$options="day"){
        $this->db->cache_off();
        if($detail == "public"){
            $this->db->select("SUM(amount) AS amount,month_year,LEFT(`month_year`, 2) AS monthx");
        } else {
            $this->db->select("amount,month_year,created_date");
        }
        $this->db->from('tbtt_money');

        if($date){
            $this->db->where('month_year',$month_year);
        }

        $this->db->where('amount >',0);

        if($user_id){
            $user_id = array_map('intval', $user_id);
            $this->db->where_in('user_id', $user_id);
        }

        if($options == "month"){
            $this->db->group_by("month_year");
        }
        $query = $this->db->get();
        return $query->result();
    }

   public function getCurrentEarningsStatistics1($detail='public',$month_year=NULL,$user_id=array(),$options="day"){

       $this->db->cache_off();
       if($detail == "public"){         
           $this->db->select("SUM(amount) AS amount,month_year,LEFT(`month_year`, 2) AS monthx , RIGHT(`month_year`, 4) AS years");
       } else {
           $this->db->select("amount,month_year,created_date");
       }
       $this->db->from('tbtt_money');

       if($date){
           $this->db->where('month_year',$month_year);
       }

       $this->db->where('amount >',0);
       $this->db->where( 'RIGHT(`month_year`, 4) =', date('Y'));

       if($user_id){
           $user_id = array_map('intval', $user_id);
           $this->db->where_in('user_id', $user_id);
       }

       if($options == "month"){
           $this->db->group_by("month_year");
       }
       $query = $this->db->get();
       return $query->result();
   }
    //By Nu Thong ke theo thang
    public function getQuantityOrderStatisticsMonth($begin_date=NULL,$end_date=NULL,$options="day",$type=0){

        $this->db->cache_off();
        $this->db->select("COUNT(id) AS count");
        $this->db->from('tbtt_order');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where('order_status',98);
        $this->db->where('product_type',$type);
        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`))");
        }
        if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`))");
        }
        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->updated_date] = $vals->count;
            }
        }
        return $lists;
    }
    public function getOrdersStatisticsMonth($begin_date=NULL,$end_date=NULL,$options="day",$type=0){

        $this->db->cache_off();
        $this->db->select("SUM(order_total_no_shipping_fee) AS order_total");
        $this->db->from('tbtt_order');
        $this->db->where("change_status_date <= '".$end_date."' AND change_status_date >= '".$begin_date."'");
        $this->db->where('order_status','98');
        $this->db->where('product_type',$type);
        if($options == "day"){
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("DATE(FROM_UNIXTIME(`change_status_date`))");
        } else if($options == "month"){
            $this->db->select('MONTH(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("MONTH(FROM_UNIXTIME(`change_status_date`))");
        } else if($options == "year"){
            $this->db->select('YEAR(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
            $this->db->group_by("YEAR(FROM_UNIXTIME(`change_status_date`))");
        } else {
            $this->db->select('DATE(FROM_UNIXTIME(`change_status_date`)) AS updated_date');
        }


        $query      =   $this->db->get();
        $lists      =   array();
        if($query->result()){
            foreach($query->result() as $vals){
                $lists[$vals->updated_date] = $vals->order_total;
            }
        }
        return $lists;
    }
}