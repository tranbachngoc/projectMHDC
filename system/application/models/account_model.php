<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/17/2015
 * Time: 8:31 AM
 */
class Account_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        if ( $this->uri->segment(2) == 'income' &&  $this->uri->segment(3) == 'user'){
            $this->pagination_per_page = 100;
        }else{
            $this->pagination_per_page = 10;
        }
        $this->pagination_num_links = 5;
        $this->pager = '';
        $this->filter = array();
        $this->num = 0;
    }

    function setPagination_page($page)
    {
        $this->pagination_per_page = $page;
    }

    function setpaginationNum($num)
    {
        $this->pagination_num_links = $num;
    }

    function setCurLink($link)
    {
        $this->_curLink = $link;
    }

    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getPaymentStatus(){
        return array(
            '0'=>'Đang có',
            '1'=>'Yêu cầu chuyển khoản',
            '2'=>'Đã chuyển tiền',
            '3'=>'Khiếu nại',
            '6'=>'Xử lí khiếu nại',
            '4'=>'Người dùng hoàn tất',
            '5'=>'Hệ thống hoàn tất',
            '8'=> 'Hoàn tất chuyển khoản',
            '9'=> 'Hủy bỏ',
        );
    }

    function getFilterType(){
        return array(
            '1'=> 'Mã thành viên',
            '2'=>'Tài khoản',
            '3'=>'Tên thành viên'
        );
    }

    function getAccounts($filter = array())
    {

        $this->db->cache_off();

        $this->db->select($filter['select'], false);
        $this->db->from('tbtt_money');
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['like'])){
            foreach($filter['like'] as $key=>$val){
                $this->db->like($key, $val);
            }
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }

        if(isset($filter['join'])){
            $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
        }

        if(isset($filter['order_by'])){
            $this->db->order_by($filter['order_by']);
        }
        if ($this->pagination_enabled == TRUE) {
            $this->db->limit($this->pagination_per_page, $filter['page']);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();
        $temp_result = $query->result_array();
        $query->free_result();


        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $this->db->select('COUNT(*) AS total');
            $this->db->from('tbtt_money');
            if(isset($filter['where'])){
                $this->db->where($filter['where']);
            }
            if(isset($filter['like'])){
                foreach($filter['like'] as $key=>$val){
                    $this->db->like($key, $val);
                }
            }
            if(isset($filter['where_in'])){
                foreach($filter['where_in'] as $key=>$val){
                    $this->db->where_in($key, $val);
                }
            }
            if(isset($filter['join'])){
                $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
            }
            $query = $this->db->get();
            $total = $query->row_array();

            $config = array();
            $config['cur_page'] = $filter['page'];
            $config['total_rows'] = $total['total'];
            $config['base_url'] = $filter['link'];
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $filter['sufix'];
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
        }


        return $temp_result;
    }

    function getLits($filter = array())
    {

        $this->db->cache_off();

        $this->db->select($filter['select'], false);
        $this->db->from('tbtt_money');
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['like'])){
            foreach($filter['like'] as $key=>$val){
                $this->db->like($key, $val);
            }
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }
        if(isset($filter['where_not_in'])){
            foreach($filter['where_not_in'] as $key=>$val){
                $this->db->where_not_in($key, $val);
            }
        }
        if(isset($filter['join'])){
            $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
        }

        if(isset($filter['group_by'])){
            $this->db->group_by($filter['group_by']);
        }


        if(isset($filter['order_by'])){
            $this->db->order_by($filter['order_by']);
        }
        if ($this->pagination_enabled == TRUE) {
            $this->db->limit($this->pagination_per_page, $filter['page']);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();
        $temp_result = $query->result_array();
        //print_r($temp_result);
        $query->free_result();


        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $this->db->select('COUNT(*) AS total');
            $this->db->from('tbtt_money');
            if(isset($filter['where'])){
                $this->db->where($filter['where']);
            }
            if(isset($filter['like'])){
                foreach($filter['like'] as $key=>$val){
                    $this->db->like($key, $val);
                }
            }
            if(isset($filter['where_in'])){
                foreach($filter['where_in'] as $key=>$val){
                    $this->db->where_in($key, $val);
                }
            }
            if(isset($filter['where_not_in'])){
                foreach($filter['where_not_in'] as $key=>$val){
                    $this->db->where_not_in($key, $val);
                }
            }
            if(isset($filter['join'])){
                $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
            }

            if(isset($filter['group_by'])){
                $this->db->group_by($filter['group_by']);
            }

            $query = $this->db->get();
            $total = $query->num_rows();
            $config = array();
            $config['cur_page'] = $filter['page'];
            $config['total_rows'] = $total;
            $config['base_url'] = $filter['link'];
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $filter['sufix'];
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
        }


        return $temp_result;
    }

    function updatePayment($id, $status, $uid = 0){
        $return = array();
        switch($status){
            /*case 1:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where('status', 0);
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=>$status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 0 => 1'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;*/
            case 2:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where('status', 1);
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=>$status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 1 => 2'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
            case 3:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where('status', 2);
                if($uid > 0){
                    $this->db->where('user_id', $uid);
                }
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=>$status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 2 => 3'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
            case 4:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => 8
                );
                $this->db->where('id', $id);
                $this->db->where('status', 2);
                if($uid > 0){
                    $this->db->where('user_id', $uid);
                }
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array();
                    $data[] = array(
                        'money_id'=>$id,
                        'status'=>4,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 2 => 4'
                    );
                    $data[] = array(
                        'money_id'=>$id,
                        'status'=>8,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 4 => 8'
                    );
                    $this->db->insert_batch('tbtt_money_logs', $data);

                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
            case 6:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where('status', 3);
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=>$status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ 3 => 6'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
            case 8:
                // Chuyen tu da co => yeu cau chuyen khoan

                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where_in('status', array(5, 6));
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=>$status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ ? => 8'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
            case 9:
                // Chuyen tu da co => yeu cau chuyen khoan
                $data = array(
                    'status' => $status
                );
                $this->db->where('id', $id);
                $this->db->where_in('status', array(1, 6));
                $this->db->update('tbtt_money',$data);
                if ($this->db->affected_rows() == '1') {
                    // Insert into logs
                    $data = array(
                        'money_id'=>$id,
                        'status'=> $status,
                        'created_date'=> date('Y-m-d H:i:s'),
                        'note'=>'Chuyển từ ? => 9'
                    );
                    $this->db->insert('tbtt_money_logs', $data);
                    $return['error']= false;
                    $return['message'] = 'Thành công';
                }else{
                    $return['error']= true;
                    $return['message'] = 'Yêu cầu không hợp lệ';
                }
                break;
        }
        return $return;
    }

    function getAdminSort($parrams= array())
    {
        $sortField = array('group', 'amount', 'created_date');
        $data = array();
        foreach ($sortField as $item) {
            $data[$item]['asc'] = '?' .implode( '&', array_merge($parrams, array('sort=' . $item, 'dir=asc')));
            $data[$item]['desc'] = '?' .implode( '&', array_merge($parrams, array('sort=' . $item, 'dir=desc')));
        }
        return $data;
    }

    function getUserGroup(){
        $this->db->cache_off();
        $this->db->select('gro_id, gro_name');
        $this->db->from('tbtt_group');
        $this->db->where(array('gro_status'=>1));
        $this->db->order_by('gro_id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCommissionType(){
        $this->db->cache_off();
        $this->db->select('id, text');
        $this->db->from('tbtt_commission_type');
        $this->db->order_by('id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getHistory($id){
        $this->db->cache_off();
        $this->db->select('*, DATE_FORMAT(created_date, \'%d/%m/%Y %h:%i\') AS created_date', false);
        $this->db->from('tbtt_money_logs');
        $this->db->where(array('money_id'=>$id));
        $this->db->order_by('created_date', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getUserInfo($id){
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from('tbtt_user');
        $this->db->where(array('use_id'=>$id));
        $query = $this->db->get();
        return $query->row_array();
    }

    function getAccountAmount($filter){
        $this->db->cache_off();
        $this->db->select(' SUM(amount) as amount');
        $this->db->from('tbtt_money');
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }
        if(isset($filter['where_not_in'])){
            foreach($filter['where_not_in'] as $key=>$val){
                $this->db->where_not_in($key, $val);
            }
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->row_array();
        if(!empty($data)){
            return $data['amount'];
        }
        return 0;
    }

    function requestPaymnent($uid, $request){
        $this->db->cache_off();
        $this->db->select(' SUM(amount) as amount');
        $this->db->from('tbtt_money');
        $this->db->where('user_id', $uid);
        $this->db->where_not_in('status', array(9));
        $query = $this->db->get();
        $amount = $query->row_array();

        if($amount['amount'] > $request){
            // Get user information
            $this->db->select('use_group,parent_id');
            $this->db->from('tbtt_user');
            $this->db->where('use_id', $uid);
            $query = $this->db->get();
            $info = $query->row_array();
            // Add Request
            $data = array();
            $data['user_id'] = $uid;
            $data['group_id'] = $info['use_group'];
            $data['parent_id'] = $info['parent_id'];
            $data['amount'] = 0 - $request;
            $data['type'] = '09';
            $data['description'] = 'YCCK';
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['month_year'] = date('m-Y');
            $data['status'] = '1';
            $this->db->insert('tbtt_money', $data);
            if($this->db->affected_rows() > 0){
                return array('error'=>false, 'amount'=>$amount['amount'] - $request, 'amount_text'=>number_format($amount['amount'] - $request).' VNĐ', 'message'=>'Thành công');
            }
        }
        return array('error'=>true, 'message'=>'Yêu cầu không hợp lệ');
    }
	
	function add($data)
	{
		return $this->db->insert("tbtt_money", $data);
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
        $query = $this->db->get("tbtt_money");
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
        $query = $this->db->get("tbtt_money");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function requestBanking($minAmount, $groups){
        $this->db->cache_off();
        $pay_weekly = 0;

        $this->db->select('  SUM(amount) AS having_amount,
                             FLOOR((SUM(amount) - 0)) AS request_amount,
                          user_id,
                          group_id,
                          parent_id ', false);
        $this->db->from('tbtt_money');
        $this->db->where_not_in('status', array(9));
        $this->db->where_in('group_id', $groups);
        $this->db->group_by('user_id');
        $this->db->having(array('having_amount >= ' => $minAmount, 'FLOOR(having_amount - '. $minAmount .') > '=> 0));
        $query = $this->db->get();
        $result = $query->result_array(); 
        if(!empty($result)){
            foreach($result as $item){
                // Add Request
                $m_amout = 0 - $item['request_amount'];
                $data = array();
                $data['user_id'] = $item['user_id'];
                $data['group_id'] = $item['group_id'];
                $data['parent_id'] = $item['parent_id'];
                $data['amount'] = 0 - $item['request_amount'];
                $data['type'] = '00';
                $data['description'] = 'YCCK';
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['month_year'] = date('m-Y');
                //$data['month_year'] = '10-2016'; // thiet lap thang tra tien cho thanh vien
                $data['status'] = '1';
                $data['pay_weekly'] = $pay_weekly;
                $this->db->insert('tbtt_money', $data);
                log_message("debug","Yêu cầu chuyển khoản - UserID:".$item['user_id'].",Số tiền:".$m_amout." đ,Tháng:".date('m-Y'));
            }
        }
    }
    
    function request_banking(){
        //$groups = array(AffiliateUser, AffiliateStoreUser, Developer2User, Developer1User, Partner2User, Partner1User, CoreMemberUser, CoreAdminUser);
        $AffGroups = array(AffiliateUser);
        //$StoreGroups = array(AffiliateStoreUser);
        $OtherGroups = array(Developer2User,Developer1User,Partner2User, Partner1User, CoreMemberUser, CoreAdminUser);
        $this->requestBanking(MinAmountAff, $AffGroups);
        //$this->requestBanking(MinAmountStore, $StoreGroups);
        $this->requestBanking(MinAmountOther, $OtherGroups);
        echo "Complete!";
        exit();
    }


}
