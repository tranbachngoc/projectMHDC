<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Showcart extends CI_Controller
{
    function __construct()
    {
            parent::__construct();
            #BEGIN: CHECK LOGIN
            if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
            {
                    redirect(base_url().'administ', 'location');
                    die();
            }
            #END CHECK LOGIN
            #Load language
            $this->lang->load('admin/common');
            $this->lang->load('admin/showcart');
            #Load model
            $this->load->model('showcart_model');
            $this->load->model('order_model');
            #BEGIN: Delete
            if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
            {
        #BEGIN: CHECK PERMISSION
                    if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_delete'))
                    {
                            show_error($this->lang->line('unallowed_use_permission'));
                            die();
                    }
                    #END CHECK PERMISSION
                    $this->showcart_model->delete($this->input->post('checkone'), "shc_id");
                    redirect(base_url().trim(uri_string(), '/'), 'location');
            }
            #END Delete
    }

    function index()
    {
    #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
            {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
    #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(3, $action);

            #BEGIN: Search & Filter
            $where = 'date';
            $sort = 'DESC';
            $by = '';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
            {
        $keyword = $getVar['keyword'];
                    switch(strtolower($getVar['search']))
                    {
                            case 'name':
                                $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'cost':
                                $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'buyer':
                                $sortUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
                    }
            }
            #If filter
            elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
            {
                    switch(strtolower($getVar['filter']))
                    {
            case 'buydate':
                                $sortUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $where .= "shc_buydate = ".(float)$getVar['key'];
                                break;
            case 'process':
                                $sortUrl .= '/filter/process/key/'.$getVar['key'];
                                $pageUrl .= '/filter/process/key/'.$getVar['key'];
                                $where .= "shc_process = 1";
                                break;
            case 'notprocess':
                                $sortUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $pageUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $where .= "shc_process = 0";
                                break;
                    }
            }
            #If sort
            if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
            {
                    switch(strtolower($getVar['sort']))
                    {
                            case 'name':
                                $pageUrl .= '/sort/name';
                                $sort .= "pro_name";
                                break;
            case 'cost':
                                $pageUrl .= '/sort/cost';
                                $sort .= "pro_cost";
                                break;
            case 'buyer':
                                $pageUrl .= '/sort/buyer';
                                $sort .= "use_username";
                                break;
            case 'quantity':
                                $pageUrl .= '/sort/quantity';
                                $sort .= "shc_quantity";
                                break;
            case 'buydate':
                                $pageUrl .= '/sort/buydate';
                                $sort .= "shc_buydate";
                                break;
                            default:
                                $pageUrl .= '/sort/id';
                                $sort .= "shc_id";
                    }
                    if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
                    {
            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    }
                    else
                    {
            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
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
            #END Search & Filter
            #Keyword
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url().'administ/showcart'.$sortUrl.'/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->showcart_model->fetch_join("shc_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, "", ""));
    $config['base_url'] = base_url().'administ/showcart'.$pageUrl.'/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $select = "shc_id, shc_buydate, shc_process, shc_quantity, pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, use_id, use_username, use_email, pro_saleoff, pro_saleoff_value, pro_type_saleoff";
            $limit = settingOtherAdmin;
            $data['showcart'] = $this->showcart_model->fetch_join($select, "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_user", "tbtt_showcart.shc_buyer = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
            #Load view

            $this->load->view('admin/showcart/defaults', $data);
    }

    private function sendEmail($to, $from, $body ,$attachment='' ,$from_name="Azibai.com", $subject=""){
            $this->load->model('shop_mail_model');
            $this->load->library('email');
            $config['useragent'] = $this->lang->line('useragen_mail_detail');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.phpmailer.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.pop3.php');
            return $this->shop_mail_model->smtpmailer($to, $from, $from_name, $subject, $body,$attachment);
    }

    function allorder() {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
            {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
    #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');		
            $getVar = $this->uri->uri_to_assoc(5, $action);			

            if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
                    $start_date = (float)$getVar['key'];
                    $_day = date('d',$start_date); 
                    $_month = date('m',$start_date);
                    $_year = date('Y',$start_date);
                    $end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
            }			
            #BEGIN: Search & Filter
            $where = '';
            $sort = 'date';
            $by = 'DESC';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
            {
        $keyword = $getVar['keyword'];
                    switch(strtolower($getVar['search']))
                    {
                            case 'name':
                                $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%' AND ";
                                break;
            case 'cost':
                                $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%' AND ";
                                break;
            case 'buyer':
                                $sortUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%' AND ";
                                break;
                            case 'orderid':
                                $sortUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $where .= "id = " . (int)$this->filter->injection($getVar['keyword']) . " AND ";
                                break;					
                    }
            }
            #If filter
            elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')  
            {
                    switch(strtolower($getVar['filter']))
                    {
            case 'buydate':
                                $sortUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/buydate/key/'.$getVar['key'];				    
                                $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."' AND ";			    
                                break;
                            case 'affiliate':
                                $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id > 0 ";
                                break;
                            case 'noaffiliate':
                                $sortUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id = 0 " ;
                                break;					
            case 'process':
                                $sortUrl .= '/filter/process/key/'.$getVar['key'];
                                $pageUrl .= '/filter/process/key/'.$getVar['key'];
                                $where .= "shc_process = 1";
                                break;
            case 'notprocess':
                                $sortUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $pageUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $where .= "shc_process = 0";
                                break;
                    }
            }
            #If sort
            if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
            {
                    switch(strtolower($getVar['sort']))
                    {
                            case 'name':
                                $pageUrl .= '/sort/name';
                                $sort .= "pro_name";
                                break;
            case 'cost':
                                $pageUrl .= '/sort/cost';
                                $sort .= "pro_cost";
                                break;
            case 'buyer':
                                $pageUrl .= '/sort/buyer';
                                $sort .= "use_username";
                                break;
            case 'quantity':
                                $pageUrl .= '/sort/quantity';
                                $sort .= "shc_quantity";
                                break;
            case 'buydate':
                                $pageUrl .= '/sort/buydate';
                                $sort .= "shc_buydate";
                                break;
                            case 'orderid':
                                $pageUrl .= '/sort/orderid';
                                $sort .= "id";
                                break;					
                            case 'date':
                                $pageUrl .= '/sort/date';
                                $sort .= "date";
                                break;										
                            default:
                                $pageUrl .= '/sort/id';
                                $sort .= "shc_id";
                    }
                    if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
                    {
            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    }
                    else
                    {
            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
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
            #END Search & Filter
            #Keyword
            $protype = $this->uri->segment(4);
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url().'administ/showcart/allorder/'.$protype.$sortUrl.'/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');

            switch ($protype){
                    case 'product': $where .= 'pro_type = 0';
                            break;
                    case 'service': $where .= 'pro_type = 1';
                            break;
                    case 'coupon':  $where .= 'pro_type = 2';
                            break;
            }
            #Count total record
            $totalRecord = count($this->order_model->fetch_join4("id", "LEFT", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", "INNER", "tbtt_product", "tbtt_product.pro_id = tbtt_showcart.shc_product", $where, "", ""));		

    $config['base_url'] = base_url().'administ/showcart/allorder/'.$protype.$pageUrl.'/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record

            $select = "id, date, payment_method, shipping_method, order_user, tbtt_order.af_id, use_id, use_username, use_fullname, count(shc_orderid) as quantity, sum(pro_price) as total";
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid'); 
            $data['showcart'] = $this->order_model->fetch_join4($select, "LEFT", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", "INNER", "tbtt_product", "tbtt_product.pro_id = tbtt_showcart.shc_product", $where, $sort, $by, $start, $limit);

            #Load view
            $this->load->view('admin/showcart/allorder', $data);
    }

    function normalorder() {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
            {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
    #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

            $getVar = $this->uri->uri_to_assoc(4, $action);

            #BEGIN: Search & Filter
            $where = 'tbtt_order.af_id = 0';
            $sort = '';
            $by = '';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
            {
        $keyword = $getVar['keyword'];
                    switch(strtolower($getVar['search']))
                    {
                            case 'name':
                                $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'cost':
                                $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'buyer':
                                $sortUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
                            case 'orderid':
                                $sortUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $where .= "id = ".$this->filter->injection($getVar['keyword']);
                                break;

                    }
            }
            #If filter
            elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
            {
                    switch(strtolower($getVar['filter']))
                    {
            case 'buydate':
                                $sortUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $where .= "date = ".$getVar['key'];
                                break;
                            case 'affiliate':
                                $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id > 0 " ;
                                break;
                            case 'noaffiliate':
                                $sortUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id = 0 " ;
                                break;					
            case 'process':
                                $sortUrl .= '/filter/process/key/'.$getVar['key'];
                                $pageUrl .= '/filter/process/key/'.$getVar['key'];
                                $where .= "shc_process = 1";
                                break;
            case 'notprocess':
                                $sortUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $pageUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $where .= "shc_process = 0";
                                break;
                    }
            }
            #If sort
            if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
            {
                    switch(strtolower($getVar['sort']))
                    {
                            case 'name':
                                $pageUrl .= '/sort/name';
                                $sort .= "pro_name";
                                break;
            case 'cost':
                                $pageUrl .= '/sort/cost';
                                $sort .= "pro_cost";
                                break;
            case 'buyer':
                                $pageUrl .= '/sort/buyer';
                                $sort .= "use_username";
                                break;
            case 'quantity':
                                $pageUrl .= '/sort/quantity';
                                $sort .= "shc_quantity";
                                break;
            case 'buydate':
                                $pageUrl .= '/sort/buydate';
                                $sort .= "shc_buydate";
                                break;
                            case 'orderid':
                                $pageUrl .= '/sort/orderid';
                                $sort .= "id";
                                break;					
                            case 'date':
                                $pageUrl .= '/sort/date';
                                $sort .= "date";
                                break;										
                            default:
                                $pageUrl .= '/sort/id';

                                $sort .= "shc_id";
                    }
                    if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
                    {
            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    }
                    else
                    {
            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
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
            #END Search & Filter
            #Keyword
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url().'administ/showcart/normalorder'.$sortUrl.'/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->order_model->fetch_join3("id", "INNER", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", $where, "", ""));
    $config['base_url'] = base_url().'administ/showcart/normalorder'.$pageUrl.'/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $select = "id, date, payment_method, shipping_method, order_user, tbtt_order.af_id, use_id, use_username, use_fullname, count(shc_orderid) as quantity, sum(pro_price) as total";
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid'); 
            $data['showcart'] = $this->order_model->fetch_join3($select, "INNER", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", $where, $sort, $by, $start, $limit);
            #Load view
            $this->load->view('admin/showcart/normalorder', $data);	
    }

    function affiliateorder() {
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
            {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
    #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & Filter
            $where = 'tbtt_order.af_id >0 ';
            $sort = '';
            $by = '';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
            {
        $keyword = $getVar['keyword'];
                    switch(strtolower($getVar['search']))
                    {
                            case 'name':
                                $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
                                $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'cost':
                                $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
                                $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
            case 'buyer':
                                $sortUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/buyer/keyword/'.$getVar['keyword'];
                                $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                                break;
                            case 'orderid':
                                $sortUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $pageUrl .= '/search/orderid/keyword/'.$getVar['keyword'];
                                $where .= "id = ".$this->filter->injection($getVar['keyword']);
                                break;

                    }
            }
            #If filter
            elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
            {
                    switch(strtolower($getVar['filter']))
                    {
            case 'buydate':
                                $sortUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/buydate/key/'.$getVar['key'];
                                $where .= "date = ".$getVar['key'];
                                break;
                            case 'affiliate':
                                $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id > 0 " ;
                                break;
                            case 'noaffiliate':
                                $sortUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $pageUrl .= '/filter/noaffiliate/key/'.$getVar['key'];
                                $where .= "tbtt_order.af_id = 0 " ;
                                break;					
            case 'process':
                                $sortUrl .= '/filter/process/key/'.$getVar['key'];
                                $pageUrl .= '/filter/process/key/'.$getVar['key'];
                                $where .= "shc_process = 1";
                                break;
            case 'notprocess':
                                $sortUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $pageUrl .= '/filter/notprocess/key/'.$getVar['key'];
                                $where .= "shc_process = 0";
                                break;
                    }
            }
            #If sort
            if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
            {
                    switch(strtolower($getVar['sort']))
                    {
                            case 'name':
                                $pageUrl .= '/sort/name';
                                $sort .= "pro_name";
                                break;
            case 'cost':
                                $pageUrl .= '/sort/cost';
                                $sort .= "pro_cost";
                                break;
            case 'buyer':
                                $pageUrl .= '/sort/buyer';
                                $sort .= "use_username";
                                break;
            case 'quantity':
                                $pageUrl .= '/sort/quantity';
                                $sort .= "shc_quantity";
                                break;
            case 'buydate':
                                $pageUrl .= '/sort/buydate';
                                $sort .= "shc_buydate";
                                break;
                            case 'orderid':
                                $pageUrl .= '/sort/orderid';
                                $sort .= "id";
                                break;					
                            case 'date':
                                $pageUrl .= '/sort/date';
                                $sort .= "date";
                                break;										
                            default:
                                $pageUrl .= '/sort/id';

                                $sort .= "shc_id";
                    }
                    if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
                    {
            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    }
                    else
                    {
            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
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
            #END Search & Filter
            #Keyword
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url().'administ/showcart/affiliateorder'.$sortUrl.'/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->order_model->fetch_join3("id", "INNER", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", $where, "", ""));
    $config['base_url'] = base_url().'administ/showcart/affiliateorder'.$pageUrl.'/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $select = "id, date, payment_method, shipping_method, order_user, tbtt_order.af_id, use_id, use_username, use_fullname, count(shc_orderid) as quantity, sum(pro_price) as total";
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid'); 
            $data['showcart'] = $this->order_model->fetch_join3($select, "INNER", "tbtt_user", "tbtt_order.order_user = tbtt_user.use_id", "LEFT", "tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", $where, $sort, $by, $start, $limit);
            #Load view
            $this->load->view('admin/showcart/affiliateorder', $data);	
    }

    function detail($orderid){
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}				
		$data['detail'] = $this->showcart_model->getDetail($orderid);
                
                $data['users']  = array(
                    'order' => $this->order_model->get_user_order_info($orderid),
                    'receive' => $this->order_model->get_user_receive_info($orderid),
                );
                $this->load->model('user_model');
                $data['statuses'] = $this->user_model->get_list_statuses();
		#Load view
		$this->load->view('admin/showcart/detail', $data);	
	}
        
    function confirm_order_saler() {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar = $this->uri->uri_to_assoc(4, $action);

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "date = " . $getVar['key'];
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/confirm_order_saler' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record

        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'shc_status' => '03'
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);
            
        }
        //END UPDATE ORDER STATUS
        
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/confirm_order_saler' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Xác nhận giao hàng',
            'status' => '03',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/confirm_order_saler', $data);
    }
    
    function news_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar = $this->uri->uri_to_assoc(5, $action);
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
            $start_date = (float)$getVar['key'];
            $_day = date('d',$start_date); 
            $_month = date('m',$start_date);
            $_year = date('Y',$start_date);
            $end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
        }

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
	    $pro_type = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/news_order_saler/'.$pro_type. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        switch ($pro_type){
            case 'product': $protype  = 0;
                break;
            case 'service': $protype  = 1;
                break;
            case 'coupon': $protype  = 2;
                break;
        }

        $params = array(
            'is_count' => TRUE,
            'start' => $start,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'order_status' => '01',
            'pro_type' => $protype,
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);            
        }
        //END UPDATE ORDER STATUS        
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/news_order_saler/'.$pro_type.$pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);

        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng mới',
            'status' => '01',
            'next_status' => FALSE,
        );
        #Load view
        $this->load->view('admin/showcart/news_order_saler', $data);
    }

    function confirm_order_checkout() {

            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(5, $action);
            #BEGIN: Search & Filter
            $where = '';
             $sort = 'date';
            $by = 'DESC';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
                    $keyword = $getVar['keyword'];
                    switch (strtolower($getVar['search'])) {
                            case 'name':
                                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'cost':
                                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'buyer':
                                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'orderid':
                                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                                    break;
                    }
            }
            #If filter
            elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
                    switch (strtolower($getVar['filter'])) {
                            case 'buydate':
                                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $where .= "date = " . $getVar['key'];
                                    break;
                            case 'affiliate':
                                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id > 0 ";
                                    break;
                            case 'noaffiliate':
                                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id = 0 ";
                                    break;
                            case 'process':
                                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                                    $where .= "shc_process = 1";
                                    break;
                            case 'notprocess':
                                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $where .= "shc_process = 0";
                                    break;
                    }
            }
            #If sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {

                    switch (strtolower($getVar['sort'])) {
                            case 'name':
                                    $pageUrl .= '/sort/name';
                                    $sort .= "pro_name";
                                    break;
                            case 'cost':
                                    $pageUrl .= '/sort/cost';
                                    $sort .= "pro_cost";
                                    break;
                            case 'buyer':
                                    $pageUrl .= '/sort/buyer';
                                    $sort .= "use_username";
                                    break;
                            case 'quantity':
                                    $pageUrl .= '/sort/quantity';
                                    $sort .= "shc_quantity";
                                    break;
                            case 'buydate':
                                    $pageUrl .= '/sort/buydate';
                                    $sort .= "shc_buydate";
                                    break;
                            case 'orderid':
                                    $pageUrl .= '/sort/orderid';
                                    $sort .= "shc_orderid";
                                    break;
                            case 'shopname':
                                    $pageUrl .= '/sort/shopname';
                                    $sort .= "sho_name";
                                    break;
                            case 'date':
                                    $pageUrl .= '/sort/date';
                                    $sort .= "date";
                                    break;
                            default:
                                    $pageUrl .= '/sort/id';
                                    $sort .= "shc_id";
                    }
                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    } else {
                            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
            #If have page
            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                    $start = (int) $getVar['page'];
                    $pageSort .= '/page/' . $start;
            } else {
                    $start = 0;
            }
            #END Search & Filter
            #Keyword
            $pro_type = $this->uri->segment(4);
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'administ/showcart/confirm_order_checkout/'.$pro_type. $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            switch ($pro_type){
                    case 'service': $protype  = 1; $title_type = 'Dịch vụ';
                            break;
                    case 'coupon': $protype  = 2; $title_type = 'Coupon';
                            break;
            }
            $params = array(
                    'is_count' => TRUE,
                    'limit' => settingOtherAdmin,
                    'sort' => $sort,
                    'by' => $by,
                    'search' => $getVar['search'],
                    'keyword' => $getVar['keyword'],
                    'start' => $start,
                    'order_status' => '02',
                    'pro_type' => $protype
            );

            //UPDATE ORDER STATUS
            $this->load->model('order_model');
            $this->load->model('user_receive_model');
            $this->load->model('user_model');
            $this->load->model('district_model');
            $this->load->model('showcart_model');
            $apply = $this->uri->segment(5);
            $orderid = $this->uri->segment(6);
            if (isset($apply) && $apply != '' && (int)$orderid > 0) {
                    $ordersaler = $this->order_model->get('*', 'id = ' . $orderid);
                    $shw_saler = $ordersaler->order_saler;
                    $user_buyer = $this->user_receive_model->get('*','order_id = '.$orderid);
                    $buyer_info = $this->district_model->get('*','DistrictCode = "'.$user_buyer->ord_district.'"');
                    $user_saler = $this->user_model->get('*','use_id = '.$shw_saler);
            }else{
                    $shw_saler = 0;
            }

            if (isset($apply) && $apply == 'cancel') {
        $orderupdate =  $this->order_model->updateOrderCode('','99',$shw_saler,$orderid,'',time());
        if ($orderupdate){
            redirect(base_url() . 'administ/showcart/confirm_order_checkout/' . $pro_type, 'location');
        }
    }
            if (isset($apply) && $apply == 'apply') {
                    $orderupdate = $this->order_model->updateOrderCode('','98', $shw_saler, $orderid);
                    //$this->showcart_model->update(array('shc_payment_stutus'=> '02'), 'shc_orderid = ' . $orderid);
                    $this->order_model->update(array('payment_status'=>1), 'id = ' . $orderid);
                    // Insert order
                    if (isset($pro_type) && $pro_type == 'coupon') {
                            $isExist = true;
                            do {
                                    $mcode = $this->order_model->makeOrderCouponCode();
                                    $order = $this->order_model->get("*", "order_coupon_code ='" . $mcode . "'");
                                    if (count($order) > 0) {
                                            $isExist = true;
                                    } else {
                                            $isExist = false;
                                    }
                            } while ($isExist);
                            if (isset($mcode) && $mcode != '') {
                                    $this->order_model->update(array('order_coupon_code' => $mcode), 'id = ' . $orderid);
                $ordercode_get = $this->order_model->get('*', 'id = ' . $orderid);
                            }
                    }
                    if ($orderupdate) {
                            if ($pro_type == 'service'){
                                    $ordercode = $orderid;
                            }elseif ($pro_type == 'coupon'){
                                    $ordercode = $ordercode_get->order_coupon_code;
                            }
                            // Noi dung email gui nguoi ban
                            $subjectuse_saler = 'Đơn hàng đã xác nhận';
                            $bodyusersaler = '';
                                    $bodyusersaler .= '<p><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></p>';
                                    $bodyusersaler .= '<p> Đơn hàng '.$title_type.' có mã số: <b>'.$ordercode.'</b> đã được xác nhận</p>';
                                    $bodyusersaler .= '<hr/>';
                                    $bodyusersaler .= '<h4> Thông tin người mua hàng</h4>';
                                    $bodyusersaler .= '<p>Họ và tên: '.$user_buyer->ord_sname.'</p>';
                                    $bodyusersaler .= '<p>Số điện thoại: '.$user_buyer->ord_smobile.'</p>';
                                    $bodyusersaler .= '<p>Email: '.$user_buyer->ord_semail.'</p>';
                                    $bodyusersaler .= '<p>Địa chỉ: '.$user_buyer->ord_saddress.', '.$buyer_info->DistrictName.', '.$buyer_info->ProvinceName.'</p>';
                                    $bodyusersaler .= '<hr/>';
                                    $bodyusersaler .= '<p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a></p>';
                                    $bodyusersaler .= '<img alt="Banking" src="http://azibai.com/templates/home/images/dichvuthanhtoan.jpg" />';
                            // Noi dung email gui nguoi mua
                            $subjectuse_buyer = 'Đơn hàng đã xác nhận';
                            $bodyuserbuyer = '';
                                    $bodyuserbuyer .= '<p><img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd"></p>';
                                    $bodyuserbuyer .= '<p> Chúc mừng quý khách, đơn hàng của quý khách đã hoàn thành!</p>';
                                    $bodyuserbuyer .= '<p> Đơn hàng '.$title_type.' có mã số: <b>'.$ordercode.'</b> đã được xác nhận</p>';
                                    $bodyuserbuyer .= '<p> Quý khách lưu ý bảo mật mã số: <b>'.$ordercode.'</b>. Đây là mã số dùng để giao dịch tại cửa hàng của chúng tôi!</p>';
                                    $bodyuserbuyer .= '<hr/>';
                                    $bodyuserbuyer .= '<h4> Thông tin của quý khách</h4>';
                                    $bodyuserbuyer .= '<p>Họ và tên: '.$user_buyer->ord_sname.'</p>';
                                    $bodyuserbuyer .= '<p>Số điện thoại: '.$user_buyer->ord_smobile.'</p>';
                                    $bodyuserbuyer .= '<p>Email: '.$user_buyer->ord_semail.'</p>';
                                    $bodyuserbuyer .= '<p>Cảm ơn quý khách đã mua sản phẩm của chúng tôi!</p>';
                                    $bodyuserbuyer .= '<hr/>';
                                    $bodyuserbuyer .= '<p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a></p>';
                                    $bodyuserbuyer .= '<img alt="Banking" src="http://azibai.com/templates/home/images/dichvuthanhtoan.jpg" />';
                            // $user_buyer->ord_semail
                            $this->sendEmail($user_buyer->ord_semail, GUSER, $bodyuserbuyer, $attachment = '', $from_name = "Azibai.com", $subjectuse_buyer);//to from body
                            $this->sendEmail($user_saler->use_email, GUSER, $bodyusersaler, $attachment = '', $from_name = "Azibai.com", $subjectuse_saler);//to from body
                            redirect(base_url() . 'administ/showcart/confirm_order_checkout/' . $pro_type, 'location');
                    }
            }
            //END UPDATE ORDER STATUS
            $totalRecord = $this->order_model->list_orders_progress($params);
            $config['base_url'] = base_url() . 'administ/showcart/confirm_order_checkout/'.$pro_type.$pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid');

            $params['is_count'] = FALSE;
            $data['showcart'] = $this->order_model->list_orders_progress($params);

            $data['params'] = $params;
            $data['page'] = array(
                    'title' => 'Xác nhận đơn hàng đã thanh toán',
                    'status' => '01',
                    'next_status' => FALSE,
            );
            #Load view
            $this->load->view('admin/showcart/order_checkout', $data);
    }

    function pay_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
		}

        #BEGIN: Search & Filter
        $where = '';
        $sort = '';
        $by = '';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/pay_order_saler/'.$protype.$sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record

		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}
        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'payment_status' => '1',
            'pro_type' => $pro_type,
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where
        );
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);
        }
        //END UPDATE ORDER STATUS
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/pay_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');
        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng đã thanh toán',
            'status' => '01',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/pay_order_saler', $data);
    }

    function notpay_order_saler() {

            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(5, $action);
            if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
                    $start_date = (float)$getVar['key'];
                    $_day = date('d',$start_date); 
                    $_month = date('m',$start_date);
                    $_year = date('Y',$start_date);
                    $end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
            }
            #BEGIN: Search & Filter
            $where = '';
            $sort = 'date';
            $by = 'DESC';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
                    $keyword = $getVar['keyword'];
                    switch (strtolower($getVar['search'])) {
                            case 'name':
                                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'cost':
                                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'buyer':
                                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'orderid':
                                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                                    break;
                    }
            }
            #If filter
            elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
                    switch (strtolower($getVar['filter'])) {
                            case 'buydate':
                                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                                    break;
                            case 'affiliate':
                                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id > 0 ";
                                    break;
                            case 'noaffiliate':
                                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id = 0 ";
                                    break;
                            case 'process':
                                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                                    $where .= "shc_process = 1";
                                    break;
                            case 'notprocess':
                                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $where .= "shc_process = 0";
                                    break;
                    }
            }
            #If sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {

                    switch (strtolower($getVar['sort'])) {
                            case 'name':
                                    $pageUrl .= '/sort/name';
                                    $sort .= "pro_name";
                                    break;
                            case 'cost':
                                    $pageUrl .= '/sort/cost';
                                    $sort .= "pro_cost";
                                    break;
                            case 'buyer':
                                    $pageUrl .= '/sort/buyer';
                                    $sort .= "use_username";
                                    break;
                            case 'quantity':
                                    $pageUrl .= '/sort/quantity';
                                    $sort .= "shc_quantity";
                                    break;
                            case 'buydate':
                                    $pageUrl .= '/sort/buydate';
                                    $sort .= "shc_buydate";
                                    break;
                            case 'orderid':
                                    $pageUrl .= '/sort/orderid';
                                    $sort .= "shc_orderid";
                                    break;
                            case 'shopname':
                                    $pageUrl .= '/sort/shopname';
                                    $sort .= "sho_name";
                                    break;
                            case 'date':
                                    $pageUrl .= '/sort/date';
                                    $sort .= "date";
                                    break;
                            default:
                                    $pageUrl .= '/sort/id';
                                    $sort .= "shc_id";
                    }
                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    } else {
                            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
            #If have page
            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                    $start = (int) $getVar['page'];
                    $pageSort .= '/page/' . $start;
            } else {
                    $start = 0;
            }
            #END Search & Filter
            #Keyword
            $protype = $this->uri->segment(4);
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'administ/showcart/notpay_order_saler/'.$protype. $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            switch ($protype){
                    case 'product': $pro_type  = 0;
                            break;
                    case 'service': $pro_type  = 1;
                            break;
                    case 'coupon': $pro_type  = 2;
                            break;
            }
            #Count total record
            $params = array(
                    'is_count' => TRUE,
                    'limit' => settingOtherAdmin,
                    'sort' => $sort,
                    'by' => $by,
                    'search' => $getVar['search'],
                    'keyword' => $getVar['keyword'],
                    'payment_status' =>  0,
                    'pro_type' =>  $pro_type,
                    'filter' => $getVar['filter'],
                    'key' => $getVar['key'],
                    'where' => $where,
         'start'=>$start
            );
            //UPDATE ORDER STATUS
            if ($this->input->post('orders_id') > 0) {
                    $shc_update = array(
                            'ids' => $this->input->post('orders_id'),
                            'next_status' => '04'
                    );
                    $this->showcart_model->update_order_progress($shc_update);

            }
            //END UPDATE ORDER STATUS
            $totalRecord = $this->order_model->list_orders_progress($params);
            $config['base_url'] = base_url() . 'administ/showcart/notpay_order_saler/'.$protype. $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid');
            $params['is_count'] = FALSE;
            $data['showcart'] = $this->order_model->list_orders_progress($params);
            $data['params'] = $params;
            $data['page'] = array(
                    'title' => 'Đơn hàng chưa thanh toán',
                    'status' => '01',
                    'next_status' => FALSE,
                    'next_status_title' => 'Giao hàng'
            );
            #Load view
            $this->load->view('admin/showcart/notpay_order_saler', $data);
    }

    function inprogress_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
		}

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }

        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/inprogress_order_saler/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}

        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'start' => $start,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'order_status' => '02',
            'pro_type' => $pro_type,
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '05'
            );
            $this->showcart_model->update_order_progress($shc_update);
            
        }
        //END UPDATE ORDER STATUS      
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/inprogress_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng đang vận chuyển',
            'status' => '04',
            'next_status' => FALSE,
            'next_status_title' => 'Đã giao'
        );
        #Load view
        $this->load->view('admin/showcart/inprogress_order_saler', $data);
    }
    
    function success_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar = $this->uri->uri_to_assoc(5, $action);

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "date = " . $getVar['key'];
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/success_order_saler/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}
        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'order_status' => '03',
            'pro_type' => $pro_type
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);
            
        }
        //END UPDATE ORDER STATUS
        
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/success_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng đã giao hàng',
            'status' => '01',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/success_order_saler', $data);
    }

    function re_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');        
        $getVar = $this->uri->uri_to_assoc(5, $action);
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
		}

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
		$protype = $this->uri->segment(4);
        $data['sortUrl'] = base_url() . 'administ/showcart/re_order_saler/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}
        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'order_status' => '06',
            'pro_type' => $pro_type,
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);
            
        }
        //END UPDATE ORDER STATUS        
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/re_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng đã nhận lại hàng',
            'status' => '01',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/re_order_saler', $data);
    }
    
    function cancel_order_saler() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar = $this->uri->uri_to_assoc(5, $action);        
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
		}

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/re_order_saler/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}

        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'pro_type' =>$pro_type,
            'order_status' => '99',
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where,
            'start' => $start
        );
        
        //UPDATE ORDER STATUS
        if ($this->input->post('orders_id') > 0) {
            $shc_update = array(
                'ids' => $this->input->post('orders_id'),
                'next_status' => '04'
            );
            $this->showcart_model->update_order_progress($shc_update);
            
        }
        //END UPDATE ORDER STATUS
        
                
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/cancel_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng bị hủy',
            'status' => '01',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/cancel_order_saler', $data);
    }

    function complain_order_saler($order_id=NULL) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

            $getVar = $this->uri->uri_to_assoc(5, $action);
            if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
                                    $start_date = (float)$getVar['key'];
                                    $_day = date('d',$start_date); 
                                    $_month = date('m',$start_date);
                                    $_year = date('Y',$start_date);
                                    $end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
                            }

            #BEGIN: Search & Filter
            $where = '';
            $sort = 'date';
            $by = 'DESC';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
                $keyword = $getVar['keyword'];
                switch (strtolower($getVar['search'])) {
                    case 'name':
                        $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                        $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                        $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                        break;
                    case 'cost':
                        $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                        $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                        $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                        break;
                    case 'buyer':
                        $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                        $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                        $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                        break;
                    case 'orderid':
                        $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                        $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                        $where .= "id = " . $this->filter->injection($getVar['keyword']);
                        break;
                }
            }
            #If filter
            elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
                switch (strtolower($getVar['filter'])) {
                    case 'buydate':
                        $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                        $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                        $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                        break;
                    case 'affiliate':
                        $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                        $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                        $where .= "tbtt_order.af_id > 0 ";
                        break;
                    case 'noaffiliate':
                        $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                        $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                        $where .= "tbtt_order.af_id = 0 ";
                        break;
                    case 'process':
                        $sortUrl .= '/filter/process/key/' . $getVar['key'];
                        $pageUrl .= '/filter/process/key/' . $getVar['key'];
                        $where .= "shc_process = 1";
                        break;
                    case 'notprocess':
                        $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                        $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                        $where .= "shc_process = 0";
                        break;
                }
            }
            #If sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {

                switch (strtolower($getVar['sort'])) {
                    case 'name':
                        $pageUrl .= '/sort/name';
                        $sort .= "pro_name";
                        break;
                    case 'cost':
                        $pageUrl .= '/sort/cost';
                        $sort .= "pro_cost";
                        break;
                    case 'buyer':
                        $pageUrl .= '/sort/buyer';
                        $sort .= "use_username";
                        break;
                    case 'quantity':
                        $pageUrl .= '/sort/quantity';
                        $sort .= "shc_quantity";
                        break;
                    case 'buydate':
                        $pageUrl .= '/sort/buydate';
                        $sort .= "shc_buydate";
                        break;
                    case 'orderid':
                        $pageUrl .= '/sort/orderid';
                        $sort .= "shc_orderid";
                        break;
                    case 'shopname':
                        $pageUrl .= '/sort/shopname';
                        $sort .= "sho_name";
                        break;
                    case 'date':
                        $pageUrl .= '/sort/date';
                        $sort .= "date";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort .= "shc_id";
                }
                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                    $pageUrl .= '/by/desc';
                    $by .= "DESC";
                } else {
                    $pageUrl .= '/by/asc';
                    $by .= "ASC";
                }
            }
            #If have page
            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                $start = (int) $getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }
            #END Search & Filter
            #Keyword
                            $protype = $this->uri->segment(4);
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'administ/showcart/refundOrders/'.$protype. $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record

                            switch ($protype){
                                    case 'product': $pro_type = 0;
                                            break;
                                    case 'service': $pro_type = 1;
                                            break;
                                    case 'coupon': $pro_type = 2;
                                            break;
                            }
            $params = array(
                'is_count' => TRUE,
                'limit' => settingOtherAdmin,
                'sort' => $sort,
                'by' => $by,
                'search' => $getVar['search'],
                'keyword' => $getVar['keyword'],
                'pro_type' => $pro_type,
                'order_status' => '05',
                'filter' => $getVar['filter'],
                'key' => $getVar['key'],
                'where' => $where
            );
            $totalRecord = $this->order_model->list_orders_progress($params);
            $config['base_url'] = base_url() . 'administ/showcart/refundOrders/'.$protype. $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid');

            $params['is_count'] = FALSE;
            $data['showcart'] = $this->order_model->list_orders_progress($params);
            $data['params'] = $params;
            $data['page'] = array(
                'title' => 'Đơn hàng đang khiếu nại',
                'status' => '05',
                'next_status' => FALSE,
                'next_status_title' => 'Khiếu nại'
            );
                            $order_id = (int)$this->uri->segment(5);
            $data['order_id']   =   $order_id;
            if($order_id && $order_id > 0){
                $data['page'] = array(
                    'title' => 'Chi tiết khiếu nại đơn hàng #'.$order_id
                );
                $this->load->model('delivery_comments_model');
                $this->load->model('delivery_model');
                $this->load->model('user_model');
                $this->load->model('shop_model');

                $data['delivery']           = $this->delivery_model->get('*','order_id = '.$order_id); 
                $data['delivery_comments']  = $this->delivery_comments_model->getAllCommentByOrder(array('order_id'=>$order_id));
                foreach($data['delivery_comments'] as $key => $vals){
                    if(in_array($vals->status_changedelivery, array("01","03"))){
                        $thumb_user = 'thumbnail_d2ee8c3adc99e19e7a300355aaf9fab8.png';
                        if($vals->user_id > 0){
                            $user       = $this->user_model->get('use_fullname,avatar','use_id = '.$vals->user_id);
                            if($user->avatar){
                                $thumb_user = $user->avatar;
                            }
                        } else {
                            $thumb_user = 'thumbnail_d2ee8c3adc99e19e7a300355aaf9fab8.png';
                        }
                        $data['_thumb'][$key] = array(
                            'name'              =>      $user->use_fullname, 
                            'logo'              =>      base_url().'media/images/avatar/'.$thumb_user,
                            'link'              =>      ""
                        );

                        if($vals->bill){
                            $data['_thumb'][$key]['bill']       =   base_url().'media/images/mauvandon/'.$vals->bill;
                        }

                    } else {
                        $shop = $this->shop_model->get('sho_logo,sho_dir_logo,sho_link,sho_name','sho_user = '.$vals->user_id);
                        $data['_thumb'][$key] = array(
                            'name'             =>      $shop->sho_name,
                            'logo'             =>      base_url().'media/shop/logos/'.$shop->sho_dir_logo.'/'.$shop->sho_logo,
                            'link'             =>      base_url().$shop->sho_link,
                            'bill'             =>      ""
                        );
                    }

                }

            }

            $this->load->model('province_model');
            $this->load->model('district_model');
            $this->load->model('user_receive_model');
            $this->load->model('refund_orders_model');
            //$this->load->model('delivery_model');

            #Load view
            $this->load->view('admin/showcart/complain_order_saler', $data);
    }

    function notsuccess_order_saler() {

            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(5, $action);
            if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
                    $start_date = (float)$getVar['key'];
                    $_day = date('d',$start_date); 
                    $_month = date('m',$start_date);
                    $_year = date('Y',$start_date);
                    $end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
            }

            #BEGIN: Search & Filter
            $where = '';
            $sort = 'date';
            $by = 'DESC';
            $sortUrl = '';
            $pageSort = '';
            $pageUrl = '';
            $keyword = '';
            #If search
            if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
                    $keyword = $getVar['keyword'];
                    switch (strtolower($getVar['search'])) {
                            case 'name':
                                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'cost':
                                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'buyer':
                                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                                    break;
                            case 'orderid':
                                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                                    break;
                    }
            }
            #If filter
            elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
                    switch (strtolower($getVar['filter'])) {
                            case 'buydate':
                                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                                    break;
                            case 'affiliate':
                                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id > 0 ";
                                    break;
                            case 'noaffiliate':
                                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                                    $where .= "tbtt_order.af_id = 0 ";
                                    break;
                            case 'process':
                                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                                    $where .= "shc_process = 1";
                                    break;
                            case 'notprocess':
                                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                                    $where .= "shc_process = 0";
                                    break;
                    }
            }
            #If sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {

                    switch (strtolower($getVar['sort'])) {
                            case 'name':
                                    $pageUrl .= '/sort/name';
                                    $sort .= "pro_name";
                                    break;
                            case 'cost':
                                    $pageUrl .= '/sort/cost';
                                    $sort .= "pro_cost";
                                    break;
                            case 'buyer':
                                    $pageUrl .= '/sort/buyer';
                                    $sort .= "use_username";
                                    break;
                            case 'quantity':
                                    $pageUrl .= '/sort/quantity';
                                    $sort .= "shc_quantity";
                                    break;
                            case 'buydate':
                                    $pageUrl .= '/sort/buydate';
                                    $sort .= "shc_buydate";
                                    break;
                            case 'orderid':
                                    $pageUrl .= '/sort/orderid';
                                    $sort .= "shc_orderid";
                                    break;
                            case 'shopname':
                                    $pageUrl .= '/sort/shopname';
                                    $sort .= "sho_name";
                                    break;
                            case 'date':
                                    $pageUrl .= '/sort/date';
                                    $sort .= "date";
                                    break;
                            default:
                                    $pageUrl .= '/sort/id';
                                    $sort .= "shc_id";
                    }
                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                            $pageUrl .= '/by/desc';
                            $by .= "DESC";
                    } else {
                            $pageUrl .= '/by/asc';
                            $by .= "ASC";
                    }
            }
            #If have page
            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                    $start = (int) $getVar['page'];
                    $pageSort .= '/page/' . $start;
            } else {
                    $start = 0;
            }
            #END Search & Filter
            #Keyword
            $protype = $this->uri->segment(4);
            $data['keyword'] = $keyword;
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'administ/showcart/notsuccess_order_saler/'.$protype. $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            switch ($protype){
                    case 'product': $pro_type = 0;
                            break;
                    case 'service': $pro_type = 1;
                            break;
                    case 'coupon': $pro_type = 2;
                            break;
            }
            $params = array(
                    'is_count' => TRUE,
                    'limit' => settingOtherAdmin,
                    'sort' => $sort,
                    'by' => $by,
                    'search' => $getVar['search'],
                    'keyword' => $getVar['keyword'],
                    'pro_type' => $pro_type,
                    'order_status' => '04',
                    'filter' => $getVar['filter'],
                    'key' => $getVar['key'],
                    'where' => $where,
        'start'=>$start
            );

            //UPDATE ORDER STATUS
            if ($this->input->post('orders_id') > 0) {
                    $shc_update = array(
                            'ids' => $this->input->post('orders_id'),
                            'next_status' => '05'
                    );
                    $this->showcart_model->update_order_progress($shc_update);

            }
            //END UPDATE ORDER STATUS


            $totalRecord = $this->order_model->list_orders_progress($params);
            $config['base_url'] = base_url() . 'administ/showcart/notsuccess_order_saler/'.$protype. $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAdmin;
            $config['num_links'] = 5;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            #END Pagination
            #sTT - So thu tu
            $data['sTT'] = $start + 1;
            #Fetch record
            $limit = settingOtherAdmin;
            $this->db->group_by('shc_orderid');

            $params['is_count'] = FALSE;
            $data['showcart'] = $this->order_model->list_orders_progress($params);
            $data['params'] = $params;
            $data['page'] = array(
                    'title' => 'Đơn hàng giao hàng không thành công',
                    'status' => '01',
                    'next_status' => FALSE,
                    'next_status_title' => 'Giao hàng'
            );
            #Load view
            $this->load->view('admin/showcart/notsuccess_order_saler', $data);
    }

    function done_order_saler() {

        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar1 = $this->uri->uri_to_assoc(4, $action);
		// sửa lôi phân trang
        $getVar = $this->uri->uri_to_assoc(3, $action);
        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);
		}
        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search


        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
					$where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort = "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort = "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort = "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort = "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort = "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/done_order_saler/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}
        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar1['search'],
            'keyword' => $getVar1['keyword'],
            'pro_type' => $pro_type,
            'order_status' => '98',
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where,
            'start' => $start
        );
        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/done_order_saler/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');
        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng đã hoàn thành',
            'status' => '01',
            'next_status' => FALSE,
            'next_status_title' => 'Giao hàng'
        );
        #Load view
        $this->load->view('admin/showcart/done_order_saler', $data);
    }    
    
    function refundOrders() {
            
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');

        $getVar = $this->uri->uri_to_assoc(5, $action);        

        if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'buydate'){	
			$start_date = (float)$getVar['key'];
			$_day = date('d',$start_date); 
			$_month = date('m',$start_date);
			$_year = date('Y',$start_date);
			$end_date = mktime(23, 59, 59,  $_month, $_day, $_year);			
		}	

        #BEGIN: Search & Filter
        $where = '';
        $sort = 'date';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'cost':
                    $sortUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/cost/keyword/' . $getVar['keyword'];
                    $where .= "pro_cost LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'buyer':
                    $sortUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/buyer/keyword/' . $getVar['keyword'];
                    $where .= "use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'orderid':
                    $sortUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/orderid/keyword/' . $getVar['keyword'];
                    $where .= "id = " . $this->filter->injection($getVar['keyword']);
                    break;
            }
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'buydate':
                    $sortUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/buydate/key/' . $getVar['key'];
                    $where .= "tbtt_order.date >= '".$start_date."' AND  tbtt_order.date <= '".$end_date."'";                    
                    break;
                case 'affiliate':
                    $sortUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/affiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id > 0 ";
                    break;
                case 'noaffiliate':
                    $sortUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $pageUrl .= '/filter/noaffiliate/key/' . $getVar['key'];
                    $where .= "tbtt_order.af_id = 0 ";
                    break;
                case 'process':
                    $sortUrl .= '/filter/process/key/' . $getVar['key'];
                    $pageUrl .= '/filter/process/key/' . $getVar['key'];
                    $where .= "shc_process = 1";
                    break;
                case 'notprocess':
                    $sortUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $pageUrl .= '/filter/notprocess/key/' . $getVar['key'];
                    $where .= "shc_process = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort .= "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort .= "pro_cost";
                    break;
                case 'buyer':
                    $pageUrl .= '/sort/buyer';
                    $sort .= "use_username";
                    break;
                case 'quantity':
                    $pageUrl .= '/sort/quantity';
                    $sort .= "shc_quantity";
                    break;
                case 'buydate':
                    $pageUrl .= '/sort/buydate';
                    $sort .= "shc_buydate";
                    break;
                case 'orderid':
                    $pageUrl .= '/sort/orderid';
                    $sort .= "shc_orderid";
                    break;
                case 'shopname':
                    $pageUrl .= '/sort/shopname';
                    $sort .= "sho_name";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort .= "date";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort .= "shc_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by .= "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by .= "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
		$protype = $this->uri->segment(4);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/showcart/refundOrders/'.$protype. $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
		switch ($protype){
			case 'product': $pro_type = 0;
				break;
			case 'service': $pro_type = 1;
				break;
			case 'coupon': $pro_type = 2;
				break;
		}
        $params = array(
            'is_count' => TRUE,
            'limit' => settingOtherAdmin,
            'sort' => $sort,
            'by' => $by,
            'search' => $getVar['search'],
            'keyword' => $getVar['keyword'],
            'pro_type' => $pro_type,
            'order_status' => '06',
            'filter' => $getVar['filter'],
            'key' => $getVar['key'],
            'where' => $where
        );

        $totalRecord = $this->order_model->list_orders_progress($params);
        $config['base_url'] = base_url() . 'administ/showcart/refundOrders/'.$protype. $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $limit = settingOtherAdmin;
        $this->db->group_by('shc_orderid');

        $params['is_count'] = FALSE;
        $data['showcart'] = $this->order_model->list_orders_progress($params);
        $data['params'] = $params;
        $data['page'] = array(
            'title' => 'Đơn hàng cần hoàn tiền',
            'status' => '06',
            'next_status' => FALSE,
            'next_status_title' => 'Hoàn tiền'
        );
        
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('user_receive_model');
        $this->load->model('refund_orders_model');
        #Load view
        $this->load->view('admin/showcart/refundOrders', $data);
    }
    
    public function updateStatusRefund(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
                $this->load->model('refund_orders_model');                
                if($this->input->post('id')){
                        $refund = array(
                            'order_id'              =>      $this->input->post('id'),
                            'refundDate'            =>      date("Y-m-d H:i:s",time()),
                            'refund_status'         =>      1
                        );
                        
                        $refund_id = $this->refund_orders_model->add($refund);
                        if($refund_id){
                            die("1");
                        } else {
                            die("0");
                        }
                } else {
                    die("0");
                }
        }
    }
    
}