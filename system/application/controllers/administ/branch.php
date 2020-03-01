<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends CI_Controller
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

        $data = array();
        $this->load->model('shop_model');
        $this->lang->load('admin/common');
        $this->load->helper('language');
    }

    function index($page = 0)
    {  
    	$this->load->view('admin/affiliate/dashboard', $data);
    }

    function all()
    {
    	//die('Show taat ca gian hang o day!');
        #sTT - So thu tu
        $sort = 'sho_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        
        $start = 0;
        $where = 'use_group = 14';
        
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'shipping');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        #If search
        if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
        {
            $keyword = $getVar['keyword'];
            switch(strtolower($getVar['search']))
            {
                case 'name':
                    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                case 'link':
                    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
                    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                case 'saler':
                    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                }
            $data['search'] = $getVar['search'];
        }

        #If sort
        if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
        {
            switch(strtolower($getVar['sort']))
            {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "sho_name";
                    break;
                case 'link':
                    $pageUrl .= '/sort/link';
                    $sort = "sho_link";
                    break;
                case 'saler':
                    $pageUrl .= '/sort/saler';
                    $sort = "use_username";
                    break;
                case 'category':
                    $pageUrl .= '/sort/category';
                    $sort = "cat_name";
                    break;
                case 'begindate':
                    $pageUrl .= '/sort/begindate';
                    $sort = "sho_begindate";
                    break;
                case 'enddate':
                    $pageUrl .= '/sort/enddate';
                    $sort = "sho_enddate";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
            {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            }
            else
            {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        
        #If filter
        elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
        {
            switch(strtolower($getVar['filter']))
            {
                case 'begindate':
                    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
                    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
                    $where .= " AND sho_begindate = ".(float)$getVar['key'];
                    break;
                case 'enddate':
                    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
                    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
                    $where .= " AND sho_enddate = ".(float)$getVar['key'];
                    break;
                case 'active':
                    $sortUrl .= '/filter/active/key/'.$getVar['key'];
                    $pageUrl .= '/filter/active/key/'.$getVar['key'];
                    $where .= " AND sho_status = 1";
                    break;
                case 'deactive':
                    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
                    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
                    $where .= " AND sho_status = 0";
                    break;
            }
            $data['filter'] = $getVar['filter'];
        }
        
        $data['statusUrl'] = base_url() . 'administ/branch/all' . $pageUrl.$pageSort;
        
        if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
        {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'branch_edit'))
            {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }

            #END CHECK PERMISSION
            switch(strtolower($getVar['status']))
            {
                case 'active':					
                    $this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);	
                    $this->load->model('user_model');
                    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$this->uri->segment(8));				
                    break;
                case 'deactive':
                    $this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
                    break;
            }
            redirect($data['statusUrl'], 'location');
        }
        #END: Update Status for Shop
        
        #BEGIN: Config Own Shipping for Shop
        if($getVar['shipping'] != FALSE && trim($getVar['shipping']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
        {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'branch_edit'))
            {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }		
            #END CHECK PERMISSION
            switch(strtolower($getVar['shipping']))
            {
                case 'active':					
                    $this->shop_model->update(array('sho_shipping' => 1), "sho_id = ".(int)$getVar['id']);	
                    $this->load->model('user_model');							
                    break;
                case 'deactive':
                    $this->shop_model->update(array('sho_shipping' => 0), "sho_id = ".(int)$getVar['id']);
                    break;
            }		
            redirect($data['statusUrl'], 'location');
        }
        #END: Config Own Shipping for Shop
        
        #If have page
        if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
        {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/'.$start;
        }
        else
        {
            $start = 0;
        }
        
        $data['sortUrl'] = base_url().'administ/branch/all'.$sortUrl.'/sort/';
        $data['sTT'] = $start + 1;
        
        #Fetch record
        $select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,use_id, use_username, use_email, tbtt_user.parent_id, cat_id, cat_name, sho_user, sho_discount_rate, sho_shipping";
        $limit = settingOtherAdmin;			
        $data['branch'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/branch/all'.$pageUrl.'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination

        
        //get ng gioi thieu
        $parentList = array(); 
        $this->load->model('user_model');
        foreach ($data['branch'] as $userObject){
            $parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
            $parentList[] = $parentObject;
        }
        $data['parent'] = $parentList;
        #Load view
    	$this->load->view('admin/branch/all', $data);
    }
    
    function configdiscount_rate($userId)
    {

        #BEGIN: CHECK PERMISSION
        if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }

        #END CHECK PERMISSION
        if($this->session->flashdata('sessionSuccessEdit'))
        {
            $data['successEdit'] = true;
        }
        else
        {
            $data['successEdit'] = false;

            #Load model
            $this->load->model('shop_model');

            $shopedit = $this->shop_model->fetch_join("use_username, use_fullname, sho_discount_rate, sho_id, sho_user ", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "", "", "", "tbtt_user.use_id = " . (int)$userId, "" , "" , 0, 0, false);

            #BEGIN: Get shop by $userId
            if(count($shopedit) != 1 || !$this->check->is_id($userId))
            {
                redirect(base_url().'administ/branch/all', 'location');
                die();
            }
            #END Get shop by $userId

            $this->load->library('form_validation');

            $this->form_validation->set_rules('num_discount', 'lang:order_label_edit', 'trim|required');
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));

            if($this->form_validation->run() != FALSE)
            {   
                $dataEdit = array('sho_discount_rate' => (int)$this->input->post('num_discount'));
                if($this->shop_model->update($dataEdit, "sho_user = ".(int)$userId))
                {
                $this->session->set_flashdata('sessionSuccessEdit', 1);
                }
                redirect(base_url().'administ/branch/all', 'location');
            }
            else
            {		        				
                $data['discountshop'] =  $shopedit[0]->use_username;
                $data['percent_discount'] = $shopedit[0]->sho_discount_rate;
            }
        }

        #Load view
        $this->load->view('admin/shop/configdiscountrate', $data);
    }
    
    function statistics($page = 0)
    {
        if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }		
        $proid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : 0;
        if ($proid > 0){
            $this->load->model('product_model');
            $select = 'tbtt_product.*, tbtt_category.cat_name';
            $product = $this->product_model->fetch_join($select,'INNER', 'tbtt_category', 'tbtt_product.pro_category = tbtt_category.cat_id',"","","","","","", 'pro_status = 1 and pro_user = '.$proid,'','','','', false, null);
            $data['product'] = $product;
            $this->load->view('admin/shop/product_shop', $data);
        }else{
            #END CHECK PERMISSION
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id','tokey');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            $where = 'use_group = 14 AND sho_status = 1';
            $sort = '';
    //			$sort = 'sho_id';
            $by = 'DESC'; 
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            
            $startMonth =$this->uri->segment('7');
            $endMonth = $this->uri->segment('9');

            $data['daypost'] = date('d',$startMonth);
            $data['monthpost'] = date('m',$startMonth);
            $data['yearpost'] = date('y',$startMonth);

            $data['tdaypost'] = date('d',$endMonth);
            $data['tmonthpost'] = date('m',$endMonth);
            $data['tyearpost'] = date('y',$endMonth);

            #If search
            if($startMonth !='')
            {
                $getVar['filter']='begindate';
            }
            
            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
            {
                $keyword = $getVar['keyword'];
                switch(strtolower($getVar['search']))
                {
                    case 'name':
                        $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                        $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                        $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                        break;
                    case 'link':
                        $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
                        $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
                        $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                        break;
                    case 'saler':
                        $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                        $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                        $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                        break;
                }
                $data['search'] = $getVar['search'];
            }

            #If filter
            elseif($getVar['filter'] != '' && $this->uri->segment(7)!= 'asc' && $this->uri->segment(7)!= 'desc')
            {
                switch(strtolower($getVar['filter']))
                {
                    case 'begindate':
                        $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
                        $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
                        $where .= " AND shc_change_status_date >= ".(float)$startMonth." AND shc_change_status_date <= ".(float)$endMonth;
                        break;
                    case 'enddate':
                        $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
                        $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
                        $where .= " AND sho_enddate = ".(float)$getVar['key'];
                        break;
                    case 'active':
                        $sortUrl .= '/filter/active/key/'.$getVar['key'];
                        $pageUrl .= '/filter/active/key/'.$getVar['key'];
                        $where .= " AND sho_status = 1";
                        break;
                    case 'deactive':
                        $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
                        $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
                        $where .= " AND sho_status = 0";
                        break;
                    case 'saleoff':
                        $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
                        $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
                        $where .= " AND sho_saleoff = 1";
                        break;
                    case 'notsaleoff':
                        $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
                        $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
                        $where .= " AND sho_saleoff = 0";
                        break;
                }
                $data['filter'] = $getVar['filter'];
            }
            #If sort
            if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
            {
                switch(strtolower($getVar['sort']))
                {
                    case 'name':
                        $pageUrl .= '/sort/name';
                        $sort = "use_username";
                        break;
                    case 'fullname':
                        $pageUrl .= '/sort/fullname';
                        $sort = "use_fullname";
                        break;
                    case 'email':
                        $pageUrl .= '/sort/email';
                        $sort = "use_email";
                        break;
                    case 'group_list':
                        $pageUrl .= '/sort/category';
                        $sort = "cat_name";
                        break;
                    case 'begindate':
                        $pageUrl .= '/sort/begindate';
                        $sort = "sho_begindate";
                        break;
                    case 'enddate':
                        $pageUrl .= '/sort/enddate';
                        $sort = "sho_enddate";
                        break;
                    case 'group':
                        $pageUrl .= '/sort/group';
                        $sort = "showcarttotal";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort = "sho_id";
                        break;
                }
                if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
                {
                    $pageUrl .= '/by/desc';
                    $by = "DESC";
                }
                else
                {
                    $pageUrl .= '/by/asc';
                    $by = "ASC";
                }
            }
            #Keyword
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url().'administ/branch/statistical'.$sortUrl.'/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            
            #If have page
            if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
            {
                $start = (int)$getVar['page'];
                $pageSort .= '/page/'.$start;
            }
            else
            {
                $start = 0;
            }

            $data['sortUrl'] = base_url().'administ/branch/statistical'.$sortUrl.'/sort/';
            $data['sTT'] = $start + 1;
            
            $select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,tbtt_user.*, cat_id, cat_name, sho_user,tbtt_showcart.shc_change_status_date ,SUM(tbtt_showcart.shc_total) As showcarttotal ,";
            $limit = settingOtherAdmin;
            $data['shop'] = $this->shop_model->fetch_join1($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", "LEFT", "tbtt_showcart", "tbtt_shop.sho_user = tbtt_showcart.shc_saler", $where, $sort, $by, $start, $limit);
            
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->shop_model->fetch_join1($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", "LEFT", "tbtt_showcart", "tbtt_shop.sho_user = tbtt_showcart.shc_saler", $where));
            $config['base_url'] = base_url().'administ/branch/statistics'.$pageUrl.'/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            
            #Load view
            $parentList = array();
            $this->load->model('user_model');
            foreach ($data['shop'] as $userObject){
                $parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
                $parentList[] = $parentObject;
            }
            $data['parent'] = $parentList;
            $this->load->view('admin/branch/statistics', $data);
        }
    }
    
    function statistics_detail($page = 0)
    {
    	//die('Show Thoong Ke Doanh So O Day!');        
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Search & Filter
        $sort = '';		
        $by = '';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        
        $order_type = '';
        if (isset($ordertype) && $ordertype =='product'){
            $order_type = 0;
        }elseif (isset($ordertype) && $ordertype =='service'){
            $order_type = 1;
        }elseif (isset($ordertype) && $ordertype =='coupon'){
            $order_type = 2;
        }
        $uid = $this->uri->segment(4);
        
        if ($this->uri->segment(8) > 0 && $this->uri->segment(10) > 0){
            $startMonth =$this->uri->segment(8);
            $endMonth = $this->uri->segment(10);
        }
        else{
            $startMonth = mktime(0, 0, 0, date('n'), 1,1,2016);
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date('Y'));
            $endMonth = mktime(23, 59, 59, date('n'), $numberDayOnMonth, date('Y'));
        }
        $data['daypost'] = date('d',$startMonth);
        $data['monthpost'] = date('m',$startMonth);
        $data['yearpost'] = date('y',$startMonth);

        $data['tdaypost'] = date('d',$endMonth);
        $data['tmonthpost'] = date('m',$endMonth);
        $data['tyearpost'] = date('y',$endMonth);
        
        $where = 'order_saler = ' . $uid;
        #Keyword
        if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
        {
            $keyword = $getVar['keyword'];
            switch(strtolower($getVar['search']))
            {
                case 'name':
                    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                case 'link':
                    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
                    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                case 'saler':
                    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
                    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
            }
            $data['keyword'] = $keyword;
        }
        if($getVar['status'] != FALSE && trim($getVar['status']) != '')
        {
            $keyword = $getVar['status'];
            $sortUrl .= '/status/'.$getVar['status'];
            $pageUrl .= '/status/'.$getVar['status'];
            $where .= " AND order_status = " . $getVar['status'];
        }
        
        #If filter
        elseif($getVar['filter'] != '')
        {
            $sorttime = " AND shc_change_status_date >= ".(float)$startMonth." AND shc_change_status_date <= ".(float)$endMonth;
            switch(strtolower($getVar['filter']))
            {
                case 'product':
                    $sortUrl .= '/filter/product/key/'.$getVar['key'];
                    $pageUrl .= '/filter/product/key/'.$getVar['key'];
                    $where .= " AND pro_type = 0" . $sorttime;
                    break;
                case 'service':
                    $sortUrl .= '/filter/service/key/'.$getVar['key'];
                    $pageUrl .= '/filter/service/key/'.$getVar['key'];
                    $where .= " AND pro_type = 1" . $sorttime;
                    break;
                case 'coupon':
                    $sortUrl .= '/filter/coupon/key/'.$getVar['key'];
                    $pageUrl .= '/filter/coupon/key/'.$getVar['key'];
                    $where .= " AND pro_type = 2" . $sorttime;
                    break;
                case 'statisticaldate':
                    $sortUrl .= '/filter/statisticaldate/key/'.$getVar['key'];
                    $pageUrl .= '/filter/statisticaldate/key/'.$getVar['key'];
                    $where .= " AND order_total_no_shipping_fee > 0" . $sorttime;
                    break;
            }
        }

        #If sort
        if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
        {
            switch(strtolower($getVar['sort']))
            {
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort = "sho_name";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort = "tbtt_order.id";
                    break;
                case 'status':
                    $pageUrl .= '/sort/status';
                    $sort = "tbtt_order.order_status";
                    break;
            }
            if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
            {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            }
            else
            {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        
        $params = array(
            'is_count' => TRUE,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'filter'=> true,
            'where'=> $where,
            'order_type'=> $order_type,
            'startMonth'=> $startMonth,
            'endMonth'=> $endMonth,
            'start'=>$start,
        );
        $data['sTT'] = $start + 1;
        $data['sortUrl'] = base_url() . 'administ/branch/statistics/'.$uid. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        
        $params['is_count'] = FALSE;
        
        $limit = settingOtherAdmin;
        
        $this->load->model('order_model');
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->order_model->list_orders_progress($params));
        $config['base_url'] = base_url() . 'administ/branch/statistics/'.$uid.$pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 1;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        
        $this->db->group_by('shc_orderid');
        $params['limit'] = $limit;
        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        
        $this->load->model('user_model');
        $user_oder = $this->user_model->get("use_id, use_username", "use_id = ".$uid);
        $data['page'] = array(
            'title' => 'Danh đơn hàng của '.$user_oder->use_username,
            'status' => '01',
            'next_status' => FALSE,
        );
        
        // Thong ke phi danh muc
        $this->load->model('showcart_model');
        $this->db->select('tbtt_category.* , SUM(shc_total) as total');
        $this->db->join('tbtt_category', 'tbtt_showcart.pro_category = tbtt_category.cat_id');
        $this->db->where('shc_saler', $uid);
        $this->db->where('shc_status', '98');
        $this->db->where('shc_change_status_date >= ', $startMonth);
        $this->db->where('shc_change_status_date <= ', $endMonth);
        if (isset($order_type) && $order_type != ''){
            $this->db->where('cate_type', $order_type);
        }
        $this->db->group_by('tbtt_showcart.pro_category');
        $this->db->order_by('total', 'desc');
        $sql = $this->db->get('tbtt_showcart');
        $catlist = $sql->result();
        
        // Thong ke hoa hong
        $this->load->model('showcart_model');
        $this->db->select('use_id, use_username,tbtt_showcart.*,tbtt_product.pro_name, tbtt_product.pro_cost');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_showcart.af_id');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product');
        $this->db->where('shc_saler', $uid);
        $this->db->where('shc_status', '98');
        $this->db->where('shc_change_status_date >= ', $startMonth);
        $this->db->where('shc_change_status_date <= ', $endMonth);
        if (isset($order_type) && $order_type != ''){
            $this->db->where('pro_type', $order_type);
        }
        $sql = $this->db->get('tbtt_showcart');
        $listaf = $sql->result();

        $arrcat = array();
        foreach ($catlist as $catid){
            $cat_free = $this->findParentByID($catid->cat_id);
            array_push($arrcat, $cat_free);
        }
        
        $data['cat_fee'] = $arrcat;
        $data['list_cat'] = $catlist;
        $data['list_af'] = $listaf;
        $this->load->view('admin/branch/statistics_detail', $data);
    }
    
    function findParentByID($catid)
    {
        $this->load->model('category_model');
        $calv = $this->category_model->get('*','cat_id = '.$catid);
        if ($calv && $calv->cat_level == 4){
            $catlv3 = $this->category_model->get('*','cat_level = 3 AND cat_id = '.$calv->parent_id);
            $catlv2 = $this->category_model->get('*','cat_level = 2 AND cat_id = '.$catlv3->parent_id);
            $catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$catlv2->parent_id);
            return $catlv1;
        }elseif ($calv && $calv->cat_level == 3){
            $catlv2 = $this->category_model->get('*','cat_level = 2 AND cat_id = '.$calv->parent_id);
            $catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$catlv2->parent_id);
            return $catlv1;
        }elseif ($calv && $calv->cat_level == 2){
            $catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$calv->parent_id);
            return $catlv1;
        }
        return $calv;
    }
    
    function danhsachsanpham($id_shop)
    {
        $this->load->model('product_model');	
        #BEGIN: CHECK PERMISSION
        if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        
        $id_branch = $getVar['danhsachsanpham'];
        
        #BEGIN: Search & Filter
        if (isset($id_branch) && $id_branch > 0){
            $where = 'pro_user ='.(int)$id_branch;
        }
        $sort = 'pro_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #END Status
        
        #If search
        if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
        {
            $keyword = $getVar['keyword'];
            $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
            $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
            $where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
            $data['search'] = $getVar['search'];
        }
        $data['keyword'] = $keyword;

        #If sort
        if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
        {
            switch(strtolower($getVar['sort']))
            {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'category':
                    $pageUrl .= '/sort/category';
                    $sort = "cat_name";
                    break;
                case 'begindate':
                    $pageUrl .= '/sort/begindate';
                    $sort = "pro_begindate";
                    break;
                case 'enddate':
                    $pageUrl .= '/sort/enddate';
                    $sort = "sho_enddate";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
            {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            }
            else
            {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        
        #If filter
        elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
        {
            switch(strtolower($getVar['filter']))
            {
                case 'begindate':
                    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
                    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
                    $where .= " AND sho_begindate = ".(float)$getVar['key'];
                    break;
                case 'enddate':
                    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
                    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
                    $where .= " AND sho_enddate = ".(float)$getVar['key'];
                    break;
                case 'active':
                    $sortUrl .= '/filter/active/key/'.$getVar['key'];
                    $pageUrl .= '/filter/active/key/'.$getVar['key'];
                    $where .= " AND sho_status = 1";
                    break;
                case 'deactive':
                    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
                    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
                    $where .= " AND sho_status = 0";
                    break;
            }
            $data['filter'] = $getVar['filter'];
        }
        
        $data['statusUrl'] = base_url().'administ/branch/danhsachsanpham/'.$id_branch . $pageUrl . $pageSort;
        
        if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
        {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'branch_edit'))
            {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            
            #END CHECK PERMISSION
            switch(strtolower($getVar['status']))
            {
                case 'active':					
                    $this->product_model->update(array('pro_status' => 1), "pro_id = " . (int)$getVar['id']);			
                    break;
                case 'deactive':
                    $this->product_model->update(array('pro_status' => 0), "pro_id = " . (int)$getVar['id']);
                    break;
            }
            redirect($data['statusUrl'], 'location');
        }
        #END: Update Status for Shop
        
        #If have page
        if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
        {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/'.$start;
        }
        else
        {
            $start = 0;
        }

        #BEGIN: Create link sort
        $data['sortUrl'] = base_url().'administ/branch/danhsachsanpham/'.$id_branch.$sortUrl.'/sort/';
        $data['pageSort'] = $pageSort;
        
        #Fetch record
        $select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email,pro_vip";
        $limit = settingOtherAdmin;
        $data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record		
        $totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/branch/danhsachsanpham/'.$id_shop.$pageUrl.'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);		
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu		
        $data['sTT'] = $start + 1;
        
        #Load view		
        $this->load->view('admin/branch/danhsachsanpham', $data);
    }
}
