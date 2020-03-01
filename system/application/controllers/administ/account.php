<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->
        session->userdata('sessionGroupAdmin'))
        ) {
            redirect(base_url() . 'administ', 'location');
            die();
        }
        $this->lang->load('admin/common');
        $this->load->helper('language');
        $data['css'] = loadCss(array('home/css/bootstrap.css','home/css/font-awesome.css','home/css/style-azibai.css','home/css/layout.css'),'administ/login.min.css');
        $data['css'] = '<style>'.$data['css'].'</style>';
    }

    function index($page = 0)
    {
        $linkParrams = array();
        $this->load->model('account_model');
        $isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
        $this->account_model->pagination($isPaging);
        $body = array();
        $filter = array();
        $requesP = $_REQUEST;
        $filter['where'] = array();
        $filter['page'] = $page;
        $filter['where']['status'] = (int)$this->input->get_post('status', 0);
        $linkParrams[] = 'status=' . $filter['where']['status'];
        $filter['select'] = 'tbtt_money.*, (SELECT gro_name FROM tbtt_group WHERE gro_id = tbtt_money.group_id) AS gro_name';
        $group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : '';
        if ($group_id != '') {
            $filter['where']['group_id'] = $group_id;
            $linkParrams[] = 'group_id=' . $filter['where']['group_id'];
        }
        $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        if ($q != '') {
            $qt = isset($_REQUEST['qt']) ? $_REQUEST['qt'] : '';
            switch ($qt) {
                case 1:
                    $filter['like'] = array('user_id' => $q);
                    $filter['select'] .= ', DATE_FORMAT(created_date, \'%d/%m/%Y %h:%i\') AS created_date,(SELECT use_fullname FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_fullname';
                    break;
                case 2:
                    $filter['like'] = array('tbtt_user.use_username' => $q);
                    $filter['join'] = array('0' => 'tbtt_user', '1' => 'tbtt_user.use_id = tbtt_money.user_id', 'inner');
                    $filter['select'] .= ', tbtt_user.use_fullname';
                    break;
                case 3:
                    $filter['like'] = array('tbtt_user.use_fullname' => $q);
                    $filter['join'] = array('0' => 'tbtt_user', '1' => 'tbtt_user.use_id = tbtt_money.user_id', '2' => 'inner');
                    $filter['select'] .= ', created_date , tbtt_user.use_fullname';
                    break;
                default:
                    $filter['select'] .= ',(SELECT use_fullname FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_fullname';
            }
        } else {
            $filter['select'] .= ', created_date,(SELECT use_fullname FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_fullname';
        }
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $requesP['sort'] = $sort;
        $requesP['dir'] = $dir;
        switch ($sort) {
            case 'group':
                $filter['order_by'] = "group_id $dir , id desc";
                break;
            case 'amount':
                $filter['order_by'] = "amount $dir , id desc";
                break;
            case 'created_date':
                $filter['order_by'] = "created_date $dir , id desc";
                break;
            default:
                $filter['order_by'] = "id desc";
        }
        $filter['sufix'] = '?' . implode('&', array_merge($linkParrams, array('sort=' . $sort, 'dir=' . $dir)));
        $filter['link'] = base_url() . 'administ/account';
        $body['accounts'] = $this->account_model->getAccounts($filter);
        if ($isPaging == FALSE) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=export.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $this->_excel($body['accounts']);
            exit();
        }
        $body['status'] = $this->account_model->getPaymentStatus();
        $body['pager'] = $this->account_model->pager;
        $body['num'] = $page;
        $body['sort'] = $this->account_model->getAdminSort($linkParrams);
        $body['groups'] = $this->account_model->getUserGroup();
        $body['types'] = $this->account_model->getFilterType();
        $body['link'] = base_url() . 'administ/account';
        $body['filter'] = $requesP;

        $this->load->view('admin/account/default', $body);
    }
    
    function getWednesDayOfMonth($month){
        // $month is int
        $timestamp  = time();
        $monthNo0 = $month;
        $year = date("Y",$timestamp);
        if($month <= 9){
            $monthHave0 = "0".$month;
        }else{
            $monthHave0 = $month;
        }

        $num_day = cal_days_in_month(CAL_GREGORIAN,$monthNo0,$year);
        $wesday_arr = array();
        for($i = $num_day; $i >= 1; $i--){
            if($i <= 9){
                $day_str = $year."-".$monthHave0."-"."0".$i;
            }else{
                $day_str = $year."-".$monthHave0."-".$i;
            }
            $dayofweek = date("l",strtotime($day_str));
            if($dayofweek == 'Wednesday'){
                $wesday_arr[] = $day_str;
            }

        }
        return $wesday_arr;
    }

    function isWed($date)
    {
        $isWed = date('D', $date);
        if ($isWed == 'Wed') {
            return $date;
        } else {
            return "";
        }
    }
    function mainboard($page = 0)
    {
        $linkParrams = array();
        $this->load->model('account_model');
        $isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
        $this->account_model->pagination($isPaging);
        $body = array();
        $filter = array();
        $requesP = $_REQUEST;

        $filter['where'] = array();
        $filter['page'] = $page;

        $status = $requesP['status'];
        if($requesP['status'] != ''){
            $status = $requesP['status'];
        }else{
            $status = 1;
            $requesP['status'] = 1;
        }
        $keymonth = date("m",time());

        switch ($status) {
            case 0:
                $filter['where_not_in'] = array('tbtt_money.status' => array(9));
                break;
            default:
                $filter['where']['status'] = $status;
        }
        $group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : '';
        if($_REQUEST['month'] != '' && $group_id !=''){
            if ($_REQUEST['dayofweek'] =='') {
                $last = strtotime('last day of this month ' . date('Y') . '-' . $_REQUEST['month']);
                if ($_REQUEST['month'] == date('m')) {
                    $isWed = date('D', time());
                } else {
                    $isWed = date('D', $last);
                }
                if ($isWed == 'Wed') {
                    if ($_REQUEST['month'] == date('m')) {
                        $firstday = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                        $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                        $filter['where']['created_date >= '] = date('Y-m-d H:s:i',$firstday);
                        $filter['where']['created_date <= '] = date('Y-m-d H:s:i',$currentday);
                    } else {
                        $firstday = mktime(0, 0, 0, date("m", $last), date("d", $last), date("Y"));
                        $currentday = mktime(23, 59, 59, date("m", $last), date("d", $last), date("Y"));
                        $filter['where']['created_date >= '] = date('Y-m-d H:s:i',$firstday);
                        $filter['where']['created_date <= '] = date('Y-m-d H:s:i',$currentday);
                    }
                } else {
                    if ($_REQUEST['month'] == date('m')) {
                        $startday = strtotime("-1 week");
                    } else {
                        $startday = strtotime(date('Y-m-d', $last) . "-1 week");
                    }
                    for ($i = $startday; $i <= time(); $i += 86400) {
                        if ($this->isWed($i)) {
                            $firstday = mktime(0, 0, 0, date("m", $i), date("d", $i), date("Y", $i));
                            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                            $filter['where']['created_date >= '] = date('Y-m-d H:s:i',$firstday);
                            $filter['where']['created_date <= '] = date('Y-m-d H:s:i',$currentday);
                            break;
                        }
                    }
                }
            }
            $filter['where']['month_year'] = $_REQUEST['month']."-".date("Y",time());
        }else{
            $_REQUEST['month'] = $keymonth;
            $filter['where']['month_year'] = $keymonth."-".date("Y",time());
        }

        if($_REQUEST['dayofweek'] !=''){
            $filter['where']['created_date >= '] = $_REQUEST['dayofweek']." 00:00:00";
            $filter['where']['created_date <= '] = $_REQUEST['dayofweek']." 23:59:59";
        }

        $linkParrams[] = 'status=' . $filter['where']['status'];
        $linkParrams[] = 'month=' . $_REQUEST['month'];
        
        $filter['select'] = 'tbtt_money.*, SUM(tbtt_money.amount) as amount,(SELECT gro_name FROM tbtt_group WHERE gro_id = tbtt_money.group_id) AS gro_name';

        if ($group_id != '') {
            $filter['where']['group_id'] = $group_id;
            $linkParrams[] = 'group_id=' . $filter['where']['group_id'];
            if($group_id == 3){
                $filter['where_in'] = array('tbtt_money.pay_weekly' => array(1));
            }
        }else{
            $filter['where_not_in'] =  array('tbtt_money.pay_weekly' => array(1));
        }
        $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        if ($q != '') {
            $qt = isset($_REQUEST['qt']) ? $_REQUEST['qt'] : '';
            switch ($qt) {
                case 1:
                    $filter['like'] = array('user_id' => $q);
                    $filter['select'] .= ', created_date,(SELECT CONCAT(     \'bank_name:\',     bank_name,     \'||bank_add:\',     bank_add,     \'||account_name:\',     account_name,     \'||num_account:\',     num_account,     \'||use_fullname:\',     use_fullname,     \'||use_username:\',     use_username,  \'||use_email:\', use_email,  \'||use_address:\', use_address,  \'||use_mobile:\', use_mobile  ) AS use_info  FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_info';
                    break;
                case 2:
                    $filter['like'] = array('tbtt_user.use_username' => $q);
                    $filter['join'] = array('0' => 'tbtt_user', '1' => 'tbtt_user.use_id = tbtt_money.user_id', 'inner');
                    $filter['select'] .= ', tbtt_user.use_fullname, tbtt_user.use_username, tbtt_user.use_email, tbtt_user.use_address, tbtt_user.use_mobile, tbtt_user.bank_name, tbtt_user.bank_add, tbtt_user.account_name, tbtt_user.num_account';
                    break;
                case 3:
                    $filter['like'] = array('tbtt_user.use_fullname' => $q);
                    $filter['join'] = array('0' => 'tbtt_user', '1' => 'tbtt_user.use_id = tbtt_money.user_id', '2' => 'inner');
                    $filter['select'] .= ', tbtt_user.use_fullname, tbtt_user.use_username, tbtt_user.use_email, tbtt_user.use_address, tbtt_user.use_mobile, tbtt_user.bank_name, tbtt_user.bank_add, tbtt_user.account_name, tbtt_user.num_account';
                    break;
                default:
                    $filter['select'] .= ', created_date,(SELECT CONCAT(     \'bank_name:\',     bank_name,     \'||bank_add:\',     bank_add,     \'||account_name:\',     account_name,     \'||num_account:\',     num_account,     \'||use_fullname:\',     use_fullname ,     \'||use_username:\',     use_username,     \'||use_email:\',     	use_email,  \'||use_address:\', use_address,  \'||use_mobile:\', use_mobile    ) AS use_info  FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_info';
            }
        } else {
            $filter['select'] .= ', created_date,(SELECT CONCAT(     \'bank_name:\',     bank_name,     \'||bank_add:\',     bank_add,     \'||account_name:\',     account_name,     \'||num_account:\',     num_account,     \'||use_fullname:\',     use_fullname ,     \'||use_username:\',     use_username,     \'||use_email:\',     	use_email,  \'||use_address:\', use_address,  \'||use_mobile:\', use_mobile   ) AS use_info  FROM tbtt_user WHERE use_id = tbtt_money.user_id) AS use_info';
        }

        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $requesP['sort'] = $sort;
        $requesP['dir'] = $dir;
        switch ($sort) {
            case 'group':
                $filter['order_by'] = "group_id $dir , id desc";
                break;
            case 'amount':
                $filter['order_by'] = "amount $dir , id desc";
                break;
            case 'created_date':
                $filter['order_by'] = "created_date $dir , id desc";
                break;
            default:
                $filter['order_by'] = "id desc";
        }
        $filter['sufix'] = '?' . implode('&', array_merge($linkParrams, array('sort=' . $sort, 'dir=' . $dir)));
        $filter['group_by'] = array('tbtt_money.user_id');
        $filter['link'] = base_url() . 'administ/account';
        $body['accounts'] = $this->account_model->getLits($filter);
        //echo $this->db->last_query();

        if ($isPaging == FALSE) {
            $this->_excel($body['accounts']);
            exit();
        }
        //echo $filter['select'];
        $body['status'] = $this->account_model->getPaymentStatus();
        $body['pager'] = $this->account_model->pager;
        $body['num'] = $page;
        $body['sort'] = $this->account_model->getAdminSort($linkParrams);
        $body['groups'] = $this->account_model->getUserGroup();
        $body['types'] = $this->account_model->getFilterType();
        $body['link'] = base_url() . 'administ/account';
        $body['filter'] = $requesP;

        if($_REQUEST['month'] == date("m",time())){
            $arrWedDay = $this->getWednesDayOfMonth(date("n",time()));
        }else{
            $themonth = (int) $_REQUEST['month'];
            $arrWedDay = $this->getWednesDayOfMonth($themonth);
        }
        $body['arrWedDay'] = $arrWedDay;
        $this->load->view('admin/account/mainboard', $body);

    }
    function detail($id, $page = 0)
    {
        $linkParrams = array();
        $this->load->model('account_model');
        $isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
        $this->account_model->pagination($isPaging);
        $body = array();
        $filter = array();
        $requesP = $_REQUEST;
        $filter['where'] = array();
        $filter['page'] = $page;
        $filter['where']['user_id'] = (int)$id;
        $filter['where']['status'] = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
        $linkParrams[] = 'status=' . $filter['where']['status'];
        $ctype = isset($_REQUEST['ctype']) ? $_REQUEST['ctype'] : '';
        if ($ctype != '') {
            $filter['where']['type'] = $ctype;
            $linkParrams[] = 'ctype=' . $ctype;
        }
        $filter['select'] = 'tbtt_money.*, (SELECT gro_name FROM tbtt_group WHERE gro_id = tbtt_money.group_id) AS gro_name';
        $group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : '';
        if ($group_id != '') {
            $filter['where']['group_id'] = $group_id;
            $linkParrams[] = 'group_id=' . $filter['where']['group_id'];
        }
        $filter['select'] .= ', created_date , DATE_FORMAT(created_date, \'%d/%m/%Y %h:%i\') AS created';
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $requesP['sort'] = $sort;
        $requesP['dir'] = $dir;
        switch ($sort) {
            case 'group':
                $filter['order_by'] = "group_id $dir , id desc";
                break;
            case 'amount':
                $filter['order_by'] = "amount $dir , id desc";
                break;
            case 'created_date':
                $filter['order_by'] = "created_date $dir , id desc";
                break;
            default:
                $filter['order_by'] = "id desc";
        }
        $filter['sufix'] = '?' . implode('&', array_merge($linkParrams, array('sort=' . $sort, 'dir=' . $dir)));
        $filter['link'] = base_url() . 'administ/account/detail/' . $id;
        $body['status'] = $this->account_model->getPaymentStatus();
        $body['user'] = $this->account_model->getUserInfo($id);
        $body['accounts'] = $this->account_model->getAccounts($filter);
        if ($isPaging == FALSE) {
            foreach ($body['accounts'] as &$item) {
                $item['use_fullname'] = $body['user']['use_fullname'];
                $item['bank_name'] = $body['user']['bank_name'];
                $item['bank_add'] = $body['user']['bank_add'];
                $item['num_account'] = $body['user']['num_account'];
            }
            $this->_excel($body['accounts'], true);
            exit();
        }
        $body['pager'] = $this->account_model->pager;
        $body['num'] = $page;
        $body['id'] = $id;
        $body['sort'] = $this->account_model->getAdminSort($linkParrams);
        $body['groups'] = $this->account_model->getUserGroup();
        $body['types'] = $this->account_model->getFilterType();
        $body['ctypes'] = $this->account_model->getCommissionType();
        $body['link'] = base_url() . 'administ/account/detail/' . $id;
        $body['filter'] = $requesP;
        $amountFilter = array(
            'where' => array(
                'user_id' => $id
            ),
            'where_not_in' => array(
                'status' => array(9)
            )
        );
        $body['user']['havingAmount'] = $this->account_model->getAccountAmount($amountFilter);
        $bankingFilter = array(
            'where' => array(
                'user_id' => $id,
                'status' => 1
            )
        );
        $body['user']['bankingAmount'] = $this->account_model->getAccountAmount($bankingFilter);
        $this->load->view('admin/account/detail', $body);
    }
    private function  _excel($data, $showID = false)
    {
        require_once(APPPATH . 'libraries/xlsxwriter.class.php');
        $filename = "report.xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $header = array(
            'ID' => 'integer',
            'Thành viên' => 'string',
            'Nhóm' => 'string',
            'Ngân hàng' => 'string',
            'Tên tài khoản' => 'string',
            'Số tài khoản' => 'string',
            'Số tiền' => '#,##0',
            'Ghi chú' => 'string',
            'Ngày tạo' => 'datetime',
            'ID' => 'integer',
            'Trạng thái' => 'string'
        );
        $status = $this->account_model->getPaymentStatus();
        $excel = array();
        foreach ($data as $item) {
            $row = array();
            $item['bank_name'] = '';
            $item['bank_add'] = '';
            $item['account_name'] = '';
            $item['num_account'] = '';
            if (isset($item['use_info'])) {
                $tmp = explode('||', $item['use_info']);
                foreach ($tmp as $info) {
                    $tmp1 = explode(':', $info);
                    $item[trim($tmp1[0])] = $tmp1[1];
                }
            }
            if ($showID) {
                array_push($row, $item['id']);
            } else {
                array_push($row, $item['user_id']);
            }
            array_push($row, $item['use_fullname']);
            array_push($row, $item['gro_name']);
            array_push($row, $item['bank_name']);
            array_push($row, $item['account_name']);
            array_push($row, $item['num_account']);
            array_push($row, abs($item['amount']));
            array_push($row, $item['description']);
            array_push($row, $item['created_date']);
            $statusTex = '';
            foreach ($status as $key => $val) {
                if ($key == $item['status']) {
                    $statusTex = $val;
                    break;
                }
            }
            array_push($row, $statusTex);
            array_push($excel, $row);
        }
        $writer = new XLSXWriter();
        $writer->setAuthor('Lê Văn Sơn');
        $writer->writeSheet($excel, 'Sheet1', $header);
        $writer->writeToStdOut();
    }
    function update()
    {
        $id = $this->input->post('id', 0);
        $status = $this->input->post('status', 0);
        $return = array('error' => true, 'message' => 'Yêu cầu không hợp lệ');
        if ($id > 0 && $status > 0) {
            $this->load->model('account_model');
            $return = $this->account_model->updatePayment($id, $status);
        }
        echo json_encode($return);
        exit();
    }
    function requestPayment()
    {
        $uid = $this->input->post('uid', 0);
        $amount = $this->input->post('amount', 0);
        $return = array('error' => true, 'message' => 'Yêu cầu không hợp lệ');
        if ($uid > 0 && $amount > 0) {
            $this->load->model('account_model');
            $return = $this->account_model->requestPaymnent($uid, $amount);
        }
        echo json_encode($return);
        exit();
    }
    function history($id)
    {
        $this->load->model('account_model');
        $body = array();
        if ($id > 0) {
            $body['rows'] = $this->account_model->getHistory($id);
            $body['status'] = $this->account_model->getPaymentStatus();
        }
        $this->load->view('admin/account/history', $body);
    }
    function affiliateShop($page)
    {
        $link = 'administ/affiliate/shop';
        $this->load->model('af_product_model');
        $this->af_product_model->pagination(TRUE);
        $body = array();
        $body['menuType'] = 'account';
        $body['menuSelected'] = 'affiliate';
        $this->af_product_model->setCurLink($link);
        $body['shop'] = $this->af_product_model->affiliateShop(array(), $page);
        $body['pager'] = $this->af_product_model->pager;
        $body['sort'] = $this->af_product_model->getAdminSort();
        $body['searchBox'] = $this->af_product_model->getSearchBox();
        $body['statusBox'] = $this->af_product_model->getStatusBox();
        $body['filter'] = $this->af_product_model->getFilter();
        $body['filterType'] = $this->af_product_model->getFilterTypes();
        $body['category'] = $this->af_product_model->getCategory();
        $body['link'] = base_url() . $link;
        $body['num'] = $page;
        $this->load->view('admin/affiliate/affiliate_shop', $body);
    }

    function statistics($uid, $page)
    {
        $link = 'administ/affiliate/statistics/' . $uid;
        $this->load->model('af_order_model');
        $this->af_order_model->pagination(TRUE);
        $body = array();
        $this->af_order_model->setLink($link);
        $body['order'] = $this->af_order_model->getAfList(array('tbtt_showcart.af_id' => $uid, 'showPayment' => true), $page);
        $body['pager'] = $this->af_order_model->pager;
        $body['user'] = $this->af_order_model->getUserInfo($uid);
        $body['num'] = $page;
        $this->load->view('admin/affiliate/affiliate_amount', $body);
    }
    
    function test()
    {
        $this->load->model('account_model');
        $this->account_model->request_banking();
        echo 'Complete!';
    }
    
}
