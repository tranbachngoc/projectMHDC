<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Showcart_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_showcart";
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
        $query = $this->db->get("tbtt_showcart");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $group_by = 0, $order = "shc_id", $by = "ASC", $start = -1, $limit = 0)
    {
        $this->db->select($select);
        if($where && $where != "")
        {
            $this->db->where($where, NULL, FALSE);
        }

        if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
        {
            $this->db->order_by($order, $by);
        }
        if((int)$start >= 0 && $limit && (int)$limit > 0)
        {
            $this->db->limit($limit, $start);
        }

        if($group_by == 1)
        {
            $this->db->group_by('pro_category');
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_showcart.pro_category');
        }

        #Query
        $query = $this->db->get("tbtt_showcart");        
        $result = $query->result();
        $query->free_result();		        
        return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "shc_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = "")
    {
        $this->db->cache_off();
        $this->db->select($select,false);
        if($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "")
        {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "")
        {
            $this->db->join($table_2, $on_2, $join_2);
        }
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
        if($distinct && $distinct == true)
        {
            $this->db->distinct();
        }
        if($group_by && $group_by != ""){
            $this->db->group_by($group_by);
        }
        #Query
        $query = $this->db->get("tbtt_showcart");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function getDetail($orderid){
        $this->db->select("tbtt_showcart.shc_quantity, tbtt_showcart.pro_price, tbtt_showcart.shc_buydate, tbtt_showcart.shc_status, tbtt_user.use_id, tbtt_user.use_username, tbtt_shop.sho_name, tbtt_shop.sho_link,  tbtt_product.pro_id, tbtt_product.pro_name, tbtt_product.pro_category ,tbtt_product.pro_sku,tbtt_showcart.shc_total");
        $this->db->where("shc_orderid",(int)$orderid);
        $this->db->order_by("shc_saler", "DESC"); 
        $this->db->join('tbtt_user', 'tbtt_showcart.shc_buyer = tbtt_user.use_id', 'left');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'inner');
        $this->db->join('tbtt_shop', 'tbtt_showcart.shc_saler = tbtt_shop.sho_user', 'inner');
        #Query
        $query = $this->db->get("tbtt_showcart");
        $result = $query->result();
        $query->free_result();
        return $result;	
    }

    function get_customers ($params) {

        // $select = "shc_saler, count(shc_buyer) AS 'count_order',use_id, use_username, use_email, use_address, use_fullname, use_mobile";
        $select = $params['select'];
        $from_view = '( SELECT tbtt_order.order_user, COUNT(tbtt_order.id) '
            .' FROM tbtt_order '
            .' INNER JOIN tbtt_showcart ON tbtt_showcart.shc_orderid = tbtt_order.id '
            .' WHERE tbtt_showcart.shc_saler = '.$params['shc_saler']
            .' GROUP BY tbtt_order.id ) AS from_view';

        $this->db->select($select);
        $this->db->from('tbtt_order');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_order.order_user', 'inner');
        $this->db->join('tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'inner');
        $this->db->where($params['where']);
        $this->db->group_by('tbtt_order.order_user');
        if($params['group_by']!=''){
            $this->db->group_by($params['group_by']);
        }

        if (!empty($params['use_username'])) {
            $this->db->like('use_username', $params['use_username']);
        }
            
        if (!empty($params['use_fullname'])) {
            $this->db->like('use_fullname', $params['use_fullname']);
        }
            
        if (!empty($params['mobile'])) {
             $this->db->like('use_mobile', $params['mobile']);
        }
                
        #Query		
        if ($params['is_count']) {
            $query = $this->db->get();
            $result = $query->result();    
            return count($result);

        } else {
            if (!empty($params['sort'])) {
                $this->db->order_by($params['sort'], $params['by']); 
            }
            if (!empty($params['user'])) {
                $this->db->order_by($params['sort'], $params['by']); 
            }
            if (!empty($params['date'])) {
                 $this->db->order_by($params['sort'], $params['by']); 
            }
            if(!empty($params['limit'])) {
                $this->db->limit($params['limit'], $params['start']);
                    
            } 
            $query = $this->db->get();
            $result = $query->result(); 
                
            $query->free_result();
        }

        return $result;
    }
    
    public function get_orders_by_user($params) {
        $select = "tbtt_showcart.*,shc_buydate";
        $this->db->select($select);
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product', 'inner');
        $this->db->group_by('tbtt_showcart.shc_orderid');
            
        if (!empty($params['shc_saler'])) {
//            $this->db->where('tbtt_showcart.shc_saler', $params['shc_saler']);
        }if (!empty($params['where'])) {
            $this->db->where($params['where']);
        }
            
        if (!empty($params['shc_buyer'])) {
            $this->db->where('tbtt_showcart.shc_buyer', $params['shc_buyer']);
        }


        $query = $this->db->get('tbtt_showcart');
        $result = $query->result();
        $query->free_result();
             
        /*$list_orders = array();
        if (!empty($result)) {
            foreach ($result as $item) {
                $list_orders[$item->shc_orderid] = $this->get_products_by_order($item->shc_orderid, $params['shc_saler']);
            }
        }
        return $list_orders;*/

        return $result;
    }

    private function get_products_by_order($order_id, $shc_saler) {
        $select = 'tbtt_showcart.*, tbtt_product.pro_name';
        $this->db->select($select);
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product', 'inner');
        $this->db->where('shc_orderid', $order_id);
        $this->db->where('shc_saler', $shc_saler);
        $this->db->order_by('pro_name', 'ASC'); 
        $query = $this->db->get('tbtt_showcart');
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function get_products_by_order_user($order_id, $user_id, $detailp = null) {
            
        $select = 'tbtt_showcart.*, tbtt_product.*, tbtt_shop.sho_name, tbtt_shop.sho_link';
        if($detailp != null){
            $select .= ',tbtt_detail_product.*';
        }
        $this->db->select($select);
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product', 'inner');
        $this->db->join('tbtt_shop', 'tbtt_shop.sho_user= tbtt_showcart.shc_saler', 'inner');
        if($detailp != null){
            $this->db->join("tbtt_detail_product", "tbtt_detail_product.id = shc_dp_pro_id", "left");
        }
        $this->db->where('shc_orderid', $order_id);
        // $this->db->where('shc_buyer', $user_id);
        $this->db->order_by('sho_name', 'ASC'); 
        $query = $this->db->get('tbtt_showcart');
            
        $result = $query->result();
        $query->free_result();
        return $result;
    }
        
    function add($data)
    {
        $this->db->insert("tbtt_showcart", $data);
    // Insert log
        $log = array('detail_id'=>$this->db->insert_id(), 'createdDate'=>date('Y-m-d H:i:s'), 'status'=>$data['shc_status'], 'note'=>'System auto add');
        $this->db->insert("tbtt_order_logs", $log);
        return true;

    }

    function update($data, $where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_showcart", $data);
    }

    function delete($value_1, $field_1 = "shc_id", $value_2 = "", $field_2 = "", $in = true)
    {
        if($in == true)
        {
            $this->db->where_in($field_1, $value_1);
        }
        else
        {
            $this->db->where($field_1, $value_1);
        }
        if($value_2 && $value_2 != "" && $field_2 && $field_2 != "")
        {
            $this->db->where($field_2, $value_2);
        }
        return $this->db->delete("tbtt_showcart");
    }
    
    function update_order_progress($data) {
        if (!empty($data['ids'])) {
            foreach ($data['ids'] as $ids) {
                //0: shc_orderid
                //1: shc_buyer
                //2: shc_saler
                $list_ids = explode(',', $ids);
                $data = array(
                    'shc_status' => $data['next_status'],
					'shc_change_status_date' => time()
                );
                $this->db->where('shc_orderid', $list_ids[0]);
                $this->db->where('shc_buyer', $list_ids[1]);
                $this->db->where('shc_saler', $list_ids[2]);
                $this->db->update('tbtt_showcart', $data); 
            }
        }
    }
    
    //by phuc nguyen
    public function getDetailOrders($where=NULL,$order=NULL,$limit=NULL,$offset=NULL,$total = NULL) {
        $this->db->cache_off();
        $this->db->select("tbl.*,product.*,rev.*,shop.*,ord.*, tdp.dp_images");
        $this->db->from('tbtt_showcart AS tbl');
        $this->db->join('tbtt_user_receive AS rev','rev.order_id = tbl.shc_orderid');
        $this->db->join("tbtt_product AS product", "product.pro_id = tbl.shc_product");
        $this->db->join("tbtt_shop AS shop", "shop.sho_user = tbl.shc_saler");
        $this->db->join("tbtt_order AS ord", "ord.id = tbl.shc_orderid");
        $this->db->join("tbtt_detail_product AS tdp", "tdp.id = tbl.shc_dp_pro_id", "left");
        
        if(isset($where['shc_saler'])){
            $this->db->where('tbl.shc_saler', $where['shc_saler']);
        }
        
        if(isset($where['order_code'])){
            $this->db->where('ord.order_code', $where['order_code']);
        }
        
        if(isset($where['order_id'])){
            $this->db->where('ord.id', $where['order_id']);
        }
        
        if(isset($where['id'])){
            $this->db->where('ord.id', $where['id']);
        }
        
        if(isset($where['order_status'])){
            $this->db->where('ord.order_status', $where['order_status']);
        }
        
        if(isset($where['order_token'])){
            $this->db->where('ord.order_token', $where['order_token']);
        }

        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);   
        }

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($total){
            return $query->num_rows();
        }
        return $query->result();
    }
    public function getDetailOrders_($where=NULL,$order=NULL,$limit=NULL,$offset=NULL,$total = NULL) {
        $this->db->cache_off();
        $this->db->select("tbl.*,product.*,rev.*,shop.*,ord.*,tdp.*");
        $this->db->from('tbtt_showcart AS tbl');
        $this->db->join('tbtt_user_receive AS rev','rev.order_id = tbl.shc_orderid');
        $this->db->join("tbtt_product AS product", "product.pro_id = tbl.shc_product");
        $this->db->join("tbtt_shop AS shop", "shop.sho_user = tbl.shc_saler");
        $this->db->join("tbtt_order AS ord", "ord.id = tbl.shc_orderid");
        $this->db->join("tbtt_detail_product AS tdp", "tdp.id = tbl.shc_dp_pro_id", "left");

        if(isset($where['shc_saler'])){
            $this->db->where('tbl.shc_saler', $where['shc_saler']);
        }

        if(isset($where['order_code'])){
            $this->db->where('ord.order_code', $where['order_code']);
        }

        if(isset($where['order_id'])){
            $this->db->where('ord.id', $where['order_id']);
        }

        if(isset($where['id'])){
            $this->db->where('ord.id', $where['id']);
        }

        if(isset($where['order_status'])){
            $this->db->where('ord.order_status', $where['order_status']);
        }

        if(isset($where['order_token'])){
            $this->db->where('ord.order_token', $where['order_token']);
        }

        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($total){
            return $query->num_rows();
        }
        return $query->result();
    }

    public function getOrderInformation($id){
        $return = array();
        $this->db->cache_off();
        $this->db->select('tbtt_order.*, tbtt_user_receive.ord_sname,tbtt_user_receive.ord_semail,tbtt_user_receive.ord_smobile, tbtt_shop.sho_link, tbtt_shop.sho_name, tbtt_shop.domain,
        CONCAT_WS(
              \', \',
              tbtt_user_receive.ord_saddress,
              (SELECT
                CONCAT_WS(
                  \', \',
                  DistrictName,
                  ProvinceName
                )
              FROM
                tbtt_district
              WHERE DistrictCode = tbtt_user_receive.ord_district
              LIMIT 0, 1)
            ) AS ord_saddress
        ',false);
        $this->db->from('tbtt_order');
        $this->db->join('tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', 'left');
        $this->db->join('tbtt_shop', 'tbtt_shop.sho_user = tbtt_order.order_saler', 'left');

        $this->db->where('tbtt_order.id', $id);
        $query = $this->db->get();
        $return['order_info'] = $query->row();
        //echo $this->db->last_query();exit;
        if(!empty($return['order_info'])){
            $this->db->cache_off();
            $this->db->select('tbtt_showcart.*, tbtt_product.pro_name, tbtt_product.pro_image, tbtt_product.pro_dir, tbtt_product.pro_sku, tbtt_product.pro_id, tbtt_product.pro_type, tbtt_detail_product.*');
            $this->db->from('tbtt_showcart');
            $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product', 'left');
            $this->db->join('tbtt_detail_product', 'tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id', 'left');
            $this->db->where('tbtt_showcart.shc_orderid', $id);
            $query = $this->db->get();
            $return['order_detail'] = $query->result();
        }

        return $return;
    }
    
    public function getCart(){
        $cart = $this->session->userdata('cart');
        $list = array();
        if(!empty($cart)){
            foreach ($cart as &$cItems) {

                if (!empty($cItems)) {
                    foreach ($cItems as $k => $cp) {
                        // Build product price
                        $productInfo = array();
                        $productInfo['qty'] = $cp['qty'];
                        $productInfo['image'] = $cp['image'];
                        $productInfo['pro_name'] = $cp['pro_name'];
                        $productInfo['pro_price'] = $cp['pro_price'];
                        $productInfo['hoahong'] = $cp['hoahong'];
                        $productInfo['af_id'] = $cp['af_id'];
                        $productInfo['af_key'] = $cp['af_key'];
                        $productInfo['link'] = $cp['link'];
                        $productInfo['dp_id'] = $cp['dp_id'];
                        array_push($list, $productInfo);
                    }
                }
            }
        }

        $cart = $this->session->userdata('cart_coupon');
        if(!empty($cart)){
            foreach ($cart as &$cItems) {
                if (!empty($cItems)) {
                    foreach ($cItems as $k => $cp) {
                        // Build product price
                        $productInfo = array();
                        $productInfo['qty'] = $cp['qty'];
                        $productInfo['image'] = $cp['image'];
                        $productInfo['pro_name'] = $cp['pro_name'];
                        $productInfo['pro_price'] = $cp['pro_price'];
                        $productInfo['hoahong'] = $cp['hoahong'];
                        $productInfo['af_id'] = $cp['af_id'];
                        $productInfo['af_key'] = $cp['af_key'];
                        $productInfo['link'] = $cp['link'];
                        $productInfo['dp_id'] = $cp['dp_id'];
                        array_push($list, $productInfo);
                    }
                }
            }
        }
        
        return $list;
    }
    
    public function getStatusOrders($where){
        $this->db->select("tbl.*");
        $this->db->from('tbtt_status AS tbl');

        if(isset($where['shc_status'])){
            $this->db->where('tbl.status_id',$where['shc_status']);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
}