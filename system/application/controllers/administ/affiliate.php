<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Affiliate extends CI_Controller
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
    }

    function index($page = 0)
    {
        $this->load->model('af_product_model');
        $this->af_product_model->pagination(TRUE);
        $body = array();

        $body['menuType'] = 'account';
        $body['menuSelected'] = 'affiliate';        

        $st = isset($_REQUEST['st']) ? $_REQUEST['st'] : '0';
        $uid = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : '0';
        $this->af_product_model->setCurLink('administ/affiliate');
        if ($st == 0 && $uid > 0) {
            $body['products'] = $this->af_product_model->lister(array('use_id' => $uid), $page);
        } elseif ($uid > 0) {
            $body['products'] = $this->af_product_model->myProduct(array('use_id' => $uid), $page);
            $body['user'] = $this->af_product_model->getUserInfo($uid);
        } elseif ($uid == 0) {
            $body['products'] = array();
            $body['message'] = "Vui lòng nhập mã thành viên!";
        }

        $body['pager'] = $this->af_product_model->pager;
        $body['sort'] = $this->af_product_model->getAdminSort();
        $body['filter'] = $this->af_product_model->getFilter();
        $body['filterType'] = $this->af_product_model->getFilterTypes();
        $body['category'] = $this->af_product_model->getCategory();
        $body['link'] = base_url() . 'administ/affiliate';
        $body['productLink'] = $body['link'];
        $body['num'] = $page;
        $body['myproductsLink'] = base_url() . $this->af_product_model->getRoute('myproducts');

        $this->load->view('admin/affiliate/dashboard', $body);
    }

    function ajaxAddProduct()
    {
        $proId = $this->input->post('pro_id', 0);
        $uid = $this->input->post('uid', 0);
        $status = $this->input->post('status', 0);
        if ($uid > 0) {
            $this->load->model('product_affiliate_user_model');
            if ($status == 0) {
                $result = $this->product_affiliate_user_model->delete(array('use_id' => $uid, 'pro_id' => $proId));
            } elseif ($status == 1) {
                $result = $this->product_affiliate_user_model->insert(array('use_id' => $uid, 'pro_id' => $proId));
            }
            if ($result == TRUE) {
                $return = array('error' => false, 'message' => 'Thành công');
            } else {
                $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');
            }
        }
        echo json_encode($return);
        exit();
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

        //Save filter date
        $getVar = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';

        $fday = isset($_REQUEST['day']) ? $_REQUEST['day'] : '0';        
        $fmonth = isset($_REQUEST['month']) ? $_REQUEST['month'] : '0';
        $fyear = isset($_REQUEST['year']) ? $_REQUEST['year'] : '0';
        $tday = isset($_REQUEST['tday']) ? $_REQUEST['tday'] : '0';
        $tmonth = isset($_REQUEST['tmonth']) ? $_REQUEST['tmonth'] : '0';
        $tyear = isset($_REQUEST['tyear']) ? $_REQUEST['tyear'] : '0';       
        $key = mktime(0, 0, 0, $fmonth, $fday, $fyear);
        $tokey = mktime(23, 59, 59, $tmonth, $tday, $tyear);

        $frdate = isset($_REQUEST['key']) ? (int)$_REQUEST['key'] : 0;        
        $tdate = isset($_REQUEST['tokey']) ? (int)$_REQUEST['tokey'] : 0;
        
        if($getVar == 'logindate'){
            if($page != ''){
                $body['frdate'] = $frdate;
                $body['tdate'] = $tdate;
            }
            else{
                $body['frdate'] = $key;                
                $body['tdate'] = $tokey;               
            }           
        }

        $this->load->view('admin/affiliate/affiliate_shop', $body);
    }

    function statistics($uid, $page)
    {         
        $link = 'administ/affiliate/statistics/' . $uid;
        
        $this->load->model('af_order_model');
        $this->af_order_model->pagination(TRUE);
        $body = array();           

        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(5, $action); 
        
        if($getVar['page'] != false && $getVar['page'] != ''){
            $start = $getVar['page'];
        }else{
            $start = 0;
        }
        
        $page = $getVar['page'];

        if($getVar['frkey'] != false && $getVar['frkey'] != '' && $getVar['tokey'] != false && $getVar['tokey'] != ''){
            $body['frdate'] = $getVar['frkey'] ? $getVar['frkey'] : 0;            
            $body['todate'] = $getVar['tokey'] ? $getVar['tokey'] : 0;
            $link .= '/frkey/' . $getVar['frkey'] . '/tokey/' .  $getVar['tokey'];
        }

        $this->af_order_model->setLink($link);
        if($getVar['filter'] == ''){
            $body['monthn'] = date('n');
        }
        else{
            $date = strtolower($getVar['key']);
            $body['monthn'] = $monthChoosen = date('n', $date);
        }
       
        $body['order'] = $this->af_order_model->getAfList_Admin((int)$uid,  $page);          
        $body['pager'] = $this->af_order_model->pager;
        $body['user'] = $this->af_order_model->getUserInfo($uid);
        $body['num'] = $start; 
        $body['link'] = $link; 

        $this->load->view('admin/affiliate/affiliate_amount', $body);
    }
}
