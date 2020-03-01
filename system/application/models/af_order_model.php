<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/30/2015
 * Time: 15:59 PM
 */

class Af_order_model extends CI_Model{
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 20;
        $this->pagination_num_links = 5;
        $this->pager = '';

        $this->filter = array('status'=>'', 'df'=>'', 'dt'=>'');

        $this->_link = '';

        /**
         *    bool $this->raw_data
         *    Used to decide what data should the SQL queries retrieve if tables are joined
         *     - TRUE:  just the field names of the items table
         *     - FALSE: related fields are replaced with the forign tables values
         *    Triggered to TRUE in the controller/edit method
         */

    }
    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }
    function getSort(){
        return array(
            array('id'=>1, 'text'=>'Ngày đặt hàng: cũ->mới', 'link'=>$this->buildLink(array('sort=date', 'dir=asc'))),
            array('id'=>1, 'text'=>'Ngày đặt hàng: mới->cũ', 'link'=>$this->buildLink(array('sort=date', 'dir=desc'))),
            array('id'=>1, 'text'=>'Giá: từ cao tới thấp', 'link'=>$this->buildLink(array('sort=price', 'dir=desc'))),
            array('id'=>2, 'text'=>'Giá: từ thấp tới cao', 'link'=>$this->buildLink(array('sort=price', 'dir=asc')))
        );
    }
    function setLink($link){
        $this->_link = $link;
    }
    function buildLink($parrams){
        if(@$this->filter['pf'] > 0 || @$this->filter['pt'] > 0){
            array_unshift($parrams, 'price=' . $this->filter['pf'].'-'.$this->filter['pt']);
        }
        if(@$this->filter['df'] > 0 ){
            array_unshift($parrams, 'df=' . $this->filter['df']);
        }
        if(@$this->filter['dt'] > 0 ){
            array_unshift($parrams, 'dt=' . $this->filter['dt']);
        }
        if(@$this->filter['cat'] > 0) {
            array_unshift($parrams, 'cat=' . $this->filter['cat']);
        }
        if(@$this->filter['q'] != ''){
            array_unshift($parrams, 'q='.$this->filter['q']);
        }
        return '?'.implode('&', $parrams);
    }

    function getRoute($var){
        return $this->_link[$var];
    }

    function getFilter(){
        return $this->filter;
    }

    function getAfList($where = array(), $page = FALSE){
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        
        // Filter date
        $this->filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
        $this->filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';

        if($this->filter['df'] != FALSE && $this->filter['df'] != '' && $this->filter['dt'] != FALSE &&  $this->filter['dt'] != ''){
            $where['tbtt_showcart.`pro_price` >= '] = $this->filter['df'];
            $where['tbtt_showcart.`pro_price` <= '] = $this->filter['dt'];
        }
        elseif($this->filter['df'] != '' && $this->filter['dt'] == ''){
            $where['tbtt_showcart.`pro_price` >= '] = $this->filter['df'];
        }
        elseif($this->filter['df'] == '' && $this->filter['dt'] != ''){
            $where['tbtt_showcart.`pro_price` <= '] = $this->filter['dt'];
        }else{}

        //Filter price       
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
        $month_fitter = isset($_REQUEST['month_fitter']) ? $_REQUEST['month_fitter'] : '';
        $year_fitter = isset($_REQUEST['year_fitter']) ? $_REQUEST['year_fitter'] : 'Y';
        if($status != ''){
           $this->filter['status'] = $status;
           $where['tbtt_showcart.shc_status'] = $status;
        }
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(5, $action);

        if($month_fitter != ''){
            $this->filter['month_fitter'] = $month_fitter;
            $this->filter['year_fitter'] = $year_fitter;
            $startMonth = mktime(0, 0, 0, $month_fitter, 1, date($year_fitter));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $month_fitter, date($year_fitter));
            $endMonth = mktime(23, 59, 59, $month_fitter, $numberDayOnMonth, date($year_fitter));

            $where['tbtt_showcart.shc_change_status_date >= '] = $startMonth;
            $where['tbtt_showcart.shc_change_status_date <= '] = $endMonth;

        }elseif($getVar['filter'] == ''){
            $startMonth = mktime(0, 0, 0, date('n'), 1, date('Y'));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date('Y'));
            $endMonth = mktime(23, 59, 59, date('n'), $numberDayOnMonth, date('Y'));
            $where['tbtt_showcart.shc_change_status_date >= '] = $startMonth;
            $where['tbtt_showcart.shc_change_status_date <= '] = $endMonth;

        }else{
            $date = strtolower($getVar['key']);
            $monthChoosen = date('n', $date);
            $startMonth = mktime(0, 0, 0, $monthChoosen, 1, date('Y'));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $monthChoosen, date('Y'));
            $endMonth = mktime(23, 59, 59, $monthChoosen, $numberDayOnMonth, date('Y'));
            $where['tbtt_showcart.shc_change_status_date >= '] = $startMonth;
            $where['tbtt_showcart.shc_change_status_date <= '] = $endMonth;
        }  
        
        $parrams = $this->uri->segment(3);
        if($parrams != FALSE && $parrams == 'statistics'){
            $val = $this->uri->segment(4);
        }else{
            $val = $this->session->userdata('sessionUser');
        }

        $where['tbtt_showcart.af_id = '] = $val;        
        
        if($getVar['frkey'] != FALSE && $getVar['frkey'] != '' && $getVar['tokey'] != FALSE && $getVar['tokey'] != ''){
            $where .= ' AND tbtt_showcart.`shc_change_status_date` >= '.(int)$getVar['frkey'].' AND tbtt_showcart.`shc_change_status_date` <= '.(int)$getVar['tokey'];
        }
       
        switch($sort){
            case 'id':
                $this->db->order_by("tbtt_showcart.shc_orderid", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;            
            case 'price':
                $this->db->order_by("tbtt_showcart.`pro_price`", $dir);
                break;
        }
       
        $select = '   tbtt_showcart.`shc_orderid` AS id,shc_change_status_date,
                      tbtt_showcart.`shc_product` as pro_id,
                      tbtt_product.`pro_name` AS pName,
                      tbtt_product.`pro_type`,
                      CONCAT(tbtt_product.`pro_category`,"/",tbtt_product.`pro_id`,"/") as pLink,
                      tbtt_showcart.`pro_price`, tbtt_showcart.`af_amt` as af_amt_original,
                      (tbtt_showcart.`af_amt` + tbtt_showcart.`af_rate` * tbtt_showcart.`pro_price` / 100) * tbtt_showcart.`shc_quantity` as af_amt,
                      tbtt_showcart.`af_rate`,
                      tbtt_showcart.`shc_quantity` as qty,
                      tbtt_showcart.`shc_status` AS pStatus,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_buyer`) AS use_username,
                      tbtt_showcart.`shc_buyer`,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_saler`) AS saler,
                      tbtt_showcart.`shc_saler`,
                      tbtt_showcart.`shc_total`,
                      tbtt_showcart.`em_discount`,
                      tbtt_showcart.`af_amt`,
                      tbtt_shop.`sho_link`,
                      tbtt_shop.`domain`,
                      (SELECT
                        `text`
                      FROM
                        `tbtt_status`
                      WHERE `status_id` = tbtt_showcart.shc_status) AS pState
                  ';       

        $this->db->select($select, false);
        $this->db->from('tbtt_showcart');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product');

        $this->db->join("tbtt_shop", "tbtt_shop.sho_user = tbtt_showcart.`shc_saler`",'LEFT');
        
        if($where != ''){
            $this->db->where($where); 
        }               
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results(); 
            $config['base_url'] = base_url().$this->_link . '/page/';
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            //$config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        $this->db->order_by('id','desc');
        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();		 
        $temp_result = $query->result_array();
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }

    function getAfListV2($where, $start,$limit){
//        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;

        // Filter date
        $this->filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
        $this->filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';

        if($this->filter['df'] != FALSE && $this->filter['df'] != '' && $this->filter['dt'] != FALSE &&  $this->filter['dt'] != ''){
            $where.=' AND tbtt_showcart.`pro_price` >= ' .$this->filter['df'].' AND tbtt_showcart.`pro_price` <= '.$this->filter['dt'];
        }
        elseif($this->filter['df'] != '' && $this->filter['dt'] == ''){
            $where.=' AND tbtt_showcart.`pro_price` >= '.$this->filter['df'];
        }
        elseif($this->filter['df'] == '' && $this->filter['dt'] != ''){
            $where.=' AND tbtt_showcart.`pro_price` <= '.$this->filter['dt'];
        }else{}

        //Filter price
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
        $month_fitter = isset($_REQUEST['month_fitter']) ? $_REQUEST['month_fitter'] : '';
        if($status != ''){
            $this->filter['status'] = $status;
            $where.=' AND tbtt_showcart.shc_status = '. $status;
        }

        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        $month_fitter = isset($_REQUEST['month_fitter']) ? $_REQUEST['month_fitter'] : '';
        $year_fitter = isset($_REQUEST['year_fitter']) ? $_REQUEST['year_fitter'] : 'Y';
        
        if($month_fitter != ''){
            $this->filter['month_fitter'] = $month_fitter;
            $this->filter['year_fitter'] = $year_fitter;
            $startMonth = mktime(0, 0, 0, $month_fitter, 1, date($year_fitter));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $month_fitter, date($year_fitter));
            $endMonth = mktime(23, 59, 59, $month_fitter, $numberDayOnMonth, date($year_fitter));

            $where.= ' AND tbtt_showcart.shc_change_status_date >= '.$startMonth;
            $where.=' AND tbtt_showcart.shc_change_status_date <= '.$endMonth;

        }elseif($getVar['filter'] == ''){
            $startMonth = mktime(0, 0, 0, date('n'), 1, date($year_fitter));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date($year_fitter));
            $endMonth = mktime(23, 59, 59, date('n'), $numberDayOnMonth, date($year_fitter));
            $where.=' AND tbtt_showcart.shc_change_status_date >= '. $startMonth;
            $where.=' AND tbtt_showcart.shc_change_status_date <= '. $endMonth;

        }else{
            $date = strtolower($getVar['key']);
            $monthChoosen = date('n', $date);
            $startMonth = mktime(0, 0, 0, $monthChoosen, 1, date($year_fitter));
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $monthChoosen, date($year_fitter));
            $endMonth = mktime(23, 59, 59, $monthChoosen, $numberDayOnMonth, date($year_fitter));
            $where.='tbtt_showcart.shc_change_status_date >= '. $startMonth;
            $where.='tbtt_showcart.shc_change_status_date <= '. $endMonth;
        }

        $parrams = $this->uri->segment(3);
        if($parrams != FALSE && $parrams == 'statistics'){
            $val = $this->uri->segment(4);
        }else{
            $val = $this->session->userdata('sessionUser');
        }

//        $where.=' AND tbtt_showcart.af_id IN('.$val.')';

        if($getVar['frkey'] != FALSE && $getVar['frkey'] != '' && $getVar['tokey'] != FALSE && $getVar['tokey'] != ''){
            $where .= ' AND tbtt_showcart.`shc_change_status_date` >= '.(int)$getVar['frkey'].' AND tbtt_showcart.`shc_change_status_date` <= '.(int)$getVar['tokey'];
        }

        switch($sort){
            case 'id':
                $this->db->order_by("tbtt_showcart.shc_orderid", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_showcart.`pro_price`", $dir);
                break;
        }

        $select = '   tbtt_showcart.`shc_orderid` AS id,shc_change_status_date,
                      tbtt_showcart.`shc_product` as pro_id,
                      tbtt_product.`pro_name` AS pName,
                      tbtt_product.`pro_type`,
                      CONCAT(tbtt_product.`pro_category`,"/",tbtt_product.`pro_id`,"/") as pLink,
                      tbtt_showcart.`pro_price`, tbtt_showcart.`af_amt` as af_amt_original,
                      (tbtt_showcart.`af_amt` + tbtt_showcart.`af_rate` * tbtt_showcart.`pro_price` / 100) * tbtt_showcart.`shc_quantity` as af_amt,
                      tbtt_showcart.`af_rate`,
                      tbtt_showcart.`shc_quantity` as qty,
                      tbtt_showcart.`shc_status` AS pStatus,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_buyer`) AS use_username,
                      tbtt_showcart.`shc_buyer`,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_saler`) AS saler,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `af_id`) AS user_af, 
                      (SELECT `use_id` FROM `tbtt_user` WHERE `use_id` = `af_id`) AS afId,
                      tbtt_showcart.`shc_saler`,
                      tbtt_showcart.`shc_total`,
                      tbtt_showcart.`em_discount`,
                      tbtt_showcart.`af_amt`,
                      (SELECT
                        `text`
                      FROM
                        `tbtt_status`
                      WHERE `status_id` = tbtt_showcart.shc_status) AS pState
                  ';

        $this->db->select($select, false);
        $this->db->from('tbtt_showcart');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product');

        if($where != ''){
            $this->db->where($where);
        }
        if($limit > 0){
            $this->db->limit($limit,$start);
        }
        $this->db->order_by('id','desc');
        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();
        $temp_result = $query->result_array();
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }

    function getAfList_Admin($uid = '', $page = FALSE){
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $where = '';

        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(5, $action);

        if($getVar['frkey'] != FALSE && $getVar['frkey'] != '' && $getVar['tokey'] != FALSE && $getVar['tokey'] != ''){
            $where .= 'tbtt_showcart.`shc_change_status_date` >= '.(int)$getVar['frkey'].' AND tbtt_showcart.`shc_change_status_date` <= '.(int)$getVar['tokey'] . ' AND ';
        }
       
        switch($sort){
            case 'id':
                $this->db->order_by("tbtt_showcart.shc_orderid", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;            
            case 'price':
                $this->db->order_by("tbtt_showcart.`pro_price`", $dir);
                break;
        }
       
        $select = '   tbtt_showcart.`shc_orderid` AS id,
                      tbtt_showcart.`shc_product` as pro_id,
                      tbtt_product.`pro_name` AS pName,
                      CONCAT(tbtt_product.`pro_category`,"/",tbtt_product.`pro_id`,"/") as pLink,
                      tbtt_showcart.`pro_price`, tbtt_showcart.`af_amt` as af_amt_original,
                      (tbtt_showcart.`af_amt` + tbtt_showcart.`af_rate` * tbtt_showcart.`pro_price` / 100) * tbtt_showcart.`shc_quantity` as af_amt,
                      tbtt_showcart.`af_rate`,
                      tbtt_showcart.`shc_quantity` as qty,
                      tbtt_showcart.`shc_status` AS pStatus,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_buyer`) AS use_username,
                      tbtt_showcart.`shc_buyer`,
                      (SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = `shc_saler`) AS saler,
                      tbtt_showcart.`shc_saler`,
                      (SELECT
                        `text`
                      FROM
                        `tbtt_status`
                      WHERE `status_id` = tbtt_showcart.shc_status) AS pState
                  ';       

        $this->db->select($select, false);
        $this->db->from('tbtt_showcart');        
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product');
                
        $where .= 'tbtt_showcart.`af_id` = '. $uid;
        $this->db->where($where);       

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results(); 
            $config['base_url'] = base_url().$this->_link . '/page/';
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;            
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();      
        $temp_result = $query->result_array();
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }

    function getStatus(){
        $where = array();
        //$where['cat_level'] = 0;
        $where['published'] = 1;
        $this->db->start_cache();
        $this->db->select('status_id, text');
        $this->db->from('tbtt_status');
        $this->db->where($where);
        $this->db->order_by("status_id", "asc");
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result =$query->result_array();
        $this->db->flush_cache();
        return $temp_result;
    }
    function getAdminSort(){
        $sortField = array('id', 'name', 'price', 'rate', 'shop', 'cat', 'amt');
        $data = array();
        foreach($sortField as $item){
            $data[$item]['asc'] = $this->buildLink(array('sort='.$item, 'dir=asc'));
            $data[$item]['desc'] = $this->buildLink(array('sort='.$item, 'dir=desc'));
        }
        return $data;
    }
    function getUserInfo($uid){
        $this->db->start_cache();
        $select_statement =  '`use_username`,`use_fullname`';
        $this->db->select($select_statement);
        $this->db->where('use_id', $uid);
        $this->db->from('tbtt_user');

        $data = $this->db->get()->row_array();
        //echo $this->db->last_query();
        $this->db->flush_cache();
        return $data;
    }
}