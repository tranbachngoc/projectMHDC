<?php
/*******************************
 * Created by Sublimetext.
 * User: BaoTran
 * Date: 17/04/2017
 * Time: 11:00 AM
 *******************************/
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends MY_Controller
{
    function __construct()
    {
        parent::__construct();        
        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        #END CHECK SETTING
        #BEGIN: CHECK LOGIN
        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        #END CHECK LOGIN       
        #Load language
        $this->load->helper( 'form' );
        $this->load->helper('language');
		$this->lang->load('home/common');
        $this->lang->load('home/account');
        $this->load->helper( 'url' );
        $this->load->model('common_model');
        $this->load->model('landing_page_model');
        $this->load->model('user_model');
        $this->load->model('content_model');                
        $this->load->model('package_user_model');
        $this->load->model('wallet_model');
                

        $data = $this->common_model->getPackageAccount();
               
		$this->load->library('Mobile_Detect');
		$detect = new Mobile_Detect();
		$data['isMobile'] = 0;
		if($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()){
			$data['isMobile'] = 1;
		}
        $this->load->model('shop_model');
        $shop = $this->shop_model->get("sho_link,sho_package", "sho_user = " . (int)$this->session->userdata('sessionUser'));
        $data['shoplink'] = $shop->sho_link;
		$this->load->model('category_model');
		$data['productCategoryRoot'] = $this->loadCategoryRoot(0,0);
		$data['productCategoryHot'] = $this->loadCategoryHot(0,0);
        
        if($this->session->userdata('sessionGroup') == BranchUser){
            $UserID = (int)$this->session->userdata('sessionUser');
            $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
            if($u_pa){
                $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
            }            
        }

        $data['wallet_info'] = $this->wallet_model->getSumWallet(array('user_id'=>(int)$this->session->userdata('sessionUser')),1);
        $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
        $data['currentuser'] = $cur_user;
	if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2){
	    $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
	} else {
	    $parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
	    $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
	}
        $data['mainURL'] = $this->getMainDomain();
        $this->load->vars($data);
    }

    /**************************************************************************/
    function configforbranch($user_id)
    {   
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if($group_id == AffiliateStoreUser || $group_id == StaffStoreUser){
            }else{
                redirect(base_url()."account", 'location');
                die();
            }
            #BEGIN: Menu
	        $data['menuPanelGroup'] = 4;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'chinhanh';             
            #END Menu

            #BEGIN: CHECK GROUP            
            $data['successEditShopAccount'] = false;
            #BEGIN: Get shop
            $this->load->model('shop_model');
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $data['shopid'] = $shop->sho_id;
            #END: CHECK GROUP  
            #BEGIN: Unlink captcha
            $this->load->helper('unlink');
            unlink_captcha($this->session->flashdata('sessionPathCaptchaEditShopIntroAccount'));
            #END Unlink captcha

            if ($this->session->flashdata('sessionSuccessEditShopRuleAccount')) {
                $data['successEditShopRuleAccount'] = true;
            } else {
                $this->load->model('shop_model');
                $this->load->model('shop_rule_model');
                $this->load->model('branch_model');
                $this->load->model('master_shop_rule_model');
                $this->load->model('province_model');
                $this->load->model('district_model');
                
                $getshop = $this->shop_model->get("*", "sho_user = " . (int)$user_id);
                $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
                $data['kho_district'] = $this->district_model->find_by(array('ProvinceCode' => $getshop->sho_kho_province));
        
                
                $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser') . " AND sho_status = 1");
                $data['successEditShopRuleAccount'] = false;
                $shop_rule = $this->branch_model->getConfig("*", "bran_id = " . (int)$user_id);
                $master_rule = $this->master_shop_rule_model->fetch("*", "type = 7", "", "ASC");

                //Add, update 
                if ($this->input->post('isEditBranRule')) {              
                    $selectedrule = implode(",", $this->input->post('shop_rule'));
                    if (count($shop_rule) != 1) {
                        $dataAdd = array(
                            'shop_id' => $shop->sho_id,
                            'bran_id' => (int)$user_id,
                            'parent_id' => (int)$this->session->userdata('sessionUser'),
                            'config_rule' => $selectedrule,
                            'createdate' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                            );
                        if ($this->branch_model->addConfig($dataAdd)) {
                            $this->session->set_flashdata('sessionSuccessEditShopRuleAccount', 1);
                        }
                    } else {                       
                        $dataEdit = array('config_rule' => $selectedrule);
                        if ($this->branch_model->updateConfig($dataEdit, "bran_id = " . (int)$user_id)) {
                            $this->session->set_flashdata('sessionSuccessEditShopRuleAccount', 1);
                        }
                    }
                    if(!in_array(51,$this->input->post('shop_rule'))){
                        $dataUpdate = array(
                            'sho_kho_address' => trim($this->filter->injection_html($this->input->post('address_kho_shop'))),
                            'sho_kho_province' => (int)$this->input->post('province_kho_shop'),
                            'sho_kho_district' => $this->input->post('district_kho_shop'),
                        );
                        $this->shop_model->update($dataUpdate, "sho_user = " . (int)$user_id);
                    }
                    
                    $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                } else {
                    //Show edit
                    $data['shop_rule'] = $rule = explode(",", $shop_rule->config_rule);
                    $data['master_rule'] = $master_rule;
                    
                    $data['address_kho_shop'] = $getshop->sho_kho_address;
                    $data['province_kho_shop'] = $getshop->sho_kho_province;
                    $data['district_kho_shop'] = $getshop->sho_kho_district;
                }                
            }
            
            //Load view
            $this->load->view('home/account/branch/configbranch', $data);
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function prowaitingapprove()
    { 
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if($group_id == StaffStoreUser) {
                $user_id = $this->user_model->get("parent_id", "use_id = " . $this->session->userdata('sessionUser'))->parent_id;
                $user_group = $this->user_model->get("use_group", "use_id = " . $user_id)->use_group;
            } else {
                $user_id = $this->session->userdata('sessionUser');
                $user_group = $this->session->userdata('sessionGroup');
            }
            if($group_id == AffiliateStoreUser|| ($group_id == StaffStoreUser && $user_group == AffiliateStoreUser)){
            }else{
                redirect(base_url()."account", 'location');
                die();
            }

            

            $body = array();
            #BEGIN: MENU
            $body['menuPanelGroup'] = 4;
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'chinhanh';
            #END: MENU
            #BEGIN: MODEL
            $this->load->model('branch_model'); 
            $this->load->model('shop_model');
            $this->load->model('product_model');
            $this->load->library('pagination');
            #END: MODEL            
            $shop = $this->shop_model->get("*", "sho_user = " . $user_id);
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;
            //        get list id nvgh
            // $tree = array();
            // $get_idnvgh = $this->user_model->fetch('use_id','parent_id ='.$this->session->userdata('sessionUser').' and use_group = '. StaffStoreUser,"","","","");
            // $tree[] = $this->session->userdata('sessionUser');
            // foreach($get_idnvgh as $key=>$value){
            //     $tree[] = $value->use_id;
            // }
            // $parent_bran = implode($tree,',');
            
            $parent_bran = $user_id;
            // if ($group_id == StaffStoreUser) {
            //    $get_idnvgh = $this->user_model->fetch_join('tbtt_user.parent_id, p.use_group as p_use_group', "LEFT", "tbtt_user as p", "p.use_id = tbtt_user.parent_id", 'tbtt_user.use_id =' . $this->session->userdata('sessionUser') . ' AND p.use_group= 3',"");

            //    if(!empty($get_idnvgh)) {
            //         $parent_bran = $get_idnvgh[0]->parent_id;
            //    }else{
            //         redirect(base_url() . "account", 'location');
            //         die();
            //    }
            // } 
            
            $select = 'pro_id, pro_image, pro_name, pro_instock, pro_cost, cat_name, is_product_affiliate, pro_user, pro_category, pro_dir, use_username, use_id, pro_status, created_date';
            $where = 'tbtt_user.parent_id = '. $parent_bran . ' AND tbtt_user.use_group = 14 AND pro_status = 0';
            $sort = 'tbtt_product.pro_id';
            $by = 'DESC'; 
            $sortUrl = '';
            $pageUrl = '';
            $pageSort = '';
           
            $action = array('status','detail', 'search', 'keyword', 'sort', 'by','id', 'page');
            $getVar = $this->uri->uri_to_assoc(3, $action);
            #If have sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                switch (strtolower($getVar['sort'])){
                    case 'doanhso':
                        $pageUrl .= '/sort/doanhso';
                        $sort .= "sho_name";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort .= "use_id";
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
            if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                $start = (int)$getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }
            #END Search & sort

            #BEGIN: ACTIVE PRODUCT
            if ($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0) {
                switch (strtolower($getVar['status'])) {
                    case 'active':
                        $this->product_model->update(array('pro_status' => 1), "pro_id = " . (int)$getVar['id']);
                            break; 
                    case 'deactive':
                        $this->product_model->update(array('pro_status' => 0), "pro_id = " . (int)$getVar['id']);
                        break;
                }
                redirect(base_url() . 'branch/prowaitingapprove', 'location');
            }
            #END: ACTIVE PRODUCT

            #BEGIN: Create link sort
            $body['sortUrl'] = base_url() . 'branch/prowaitingapprove' . $sortUrl . '/sort/';
            $body['pageSort'] = $pageSort;
            #END Create link sort     

            #BEGIN: Pagination 
            $totalRecord = count($this->branch_model->fetch_join2("tbtt_product.pro_id", "INNER", "tbtt_category", "tbtt_category.cat_id = tbtt_product.pro_category", "INNER","tbtt_user", "tbtt_user.use_id = tbtt_product.pro_user", $where, $sort, $by,$start, $limit));

            $config['base_url'] = base_url() . 'branch/prowaitingapprove' . $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAccount;
            $config['num_links'] = 1;
            $config['uri_segment'] = 4;
            $limmit = -1;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $body['linkPage'] = $this->pagination->create_links();
            $body['sTT'] = $start + 1;
            #END Pagination 
            $body['productBranch'] = $this->branch_model->fetch_join2($select, "INNER", "tbtt_category", "tbtt_category.cat_id = tbtt_product.pro_category", "INNER","tbtt_user", "tbtt_user.use_id = tbtt_product.pro_user",  $where, $sort, $by,$start, $limit);

            //Load view
            $this->load->view('home/account/branch/prowaitingapprove', $body);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function flyerwaitapprove()
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if($group_id == AffiliateStoreUser || $group_id == StaffStoreUser){
            }else{
                redirect(base_url()."account", 'location');
                die();
            }

            $userId = (int)$this->session->userdata('sessionUser');
	        $data['menuPanelGroup'] = 4;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'chinhanh'; 
            $lList = array();
            $lListName = array();
            $tree = array();
            $get_idnvgh = $this->user_model->fetch('use_id','parent_id ='.$userId.' and use_group = '. StaffStoreUser,"","","","");
            $tree[] = $this->session->userdata('sessionUser');
            foreach($get_idnvgh as $key=>$value){
                $tree[] = $value->use_id;
            }
            $parent_bran = implode($tree,',');

            $select = 'u.use_id, u.use_username, tbtt_landing_page.*';
            $where = 'u.parent_id IN('. $parent_bran . ') AND tbtt_landing_page.status = 0 AND u.use_group = ' . BranchUser;
            $sort = '';
            $by = 'DESC'; 
            $sortUrl = '';
            $pageUrl = '';
            $pageSort = '';

            $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            #If have sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                switch (strtolower($getVar['sort'])) {                
                    case 'doanhso':
                        $pageUrl .= '/sort/doanhso';
                        $sort = "sho_name";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort = "use_id";
                }

                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc'){$pageUrl .= '/by/desc';
                    $by = "DESC";
                } else {
                    $pageUrl .= '/by/asc';
                    $by = "ASC";
                }
            }

            #If have page
            if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                $start = (int)$getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }
            #END Search & sort

            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'branch/flyerwaitapprove' . $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort  
            
            $email = $this->user_model->get("use_id, use_email", "use_id = {$userId}");
            $emailShop = $email->use_email;
            $sublists = $this->getSubList($emailShop);

            if(!empty($sublists)){
                foreach($sublists as $item){
                        $lList[] = $item['id'];
                        $lListName[] = $item['name'];
                }
            }           
            $data["lListName"] = $lListName;
            $data["lList"] = $lList;
            
            //Update status for landing page
            $status = $_REQUEST['active'] ? $_REQUEST['active'] : 0;
            $id_lan = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
            if ($id_lan > 0){
                $this->landing_page_model->update(array('status' => $status), 'id = '.$id_lan);
                redirect(base_url() . 'branch/flyerwaitapprove', 'location');
            }

            #BEGIN: Pagination
            $this->load->library('pagination');
            $this->load->model('branch_model');
            #Count total record
            $totalRecord = count($this->branch_model->fetch_join1("u.use_id","INNER","tbtt_landing_page", "tbtt_landing_page.user_id = u.use_id", $where, $sort, $by));

            $config['base_url'] = base_url() . 'branch/flyerwaitapprove' . $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAccount;
            $config['num_links'] = 1;
            $config['uri_segment'] = 4;
            $limmit = -1;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            $data['sTT'] = $start + 1;
            #END Pagination

            $data["listpage"] = $this->branch_model->fetch_join1($select, "INNER", "tbtt_landing_page", "tbtt_landing_page.user_id = u.use_id", $where, $order, $by, $start, $limit);

            //Load view
            $this->load->view('home/account/branch/flyerwaitapprove', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function newswaitapprove()
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            $iUserId = (int)$this->session->userdata('sessionUser');
            $iShopId = (int)$this->session->userdata('sessionUser');
          
            if($group_id == StaffStoreUser) {
                $oUser = $this->user_model->get("*","use_id = " . $iUserId  . ' AND use_status = 1');
                $iUserId = $oUser->parent_id;
                $iShopId = $oUser->parent_shop;
                
                if(!empty($oUser)) {
                    $oShop = $this->user_model->get("*","use_id = " . $oUser->parent_id  . ' AND use_status = 1');
                    if(!empty($oShop) && $oShop->use_group == 3) {
                        // Tự động active khi nhân viên của gian hàng
                        $data['PermissionStoreUser'] = true;
                        $iUserId = $oUser->parent_id;
                        $iShopId = $oUser->parent_id;
                    }
                }   
            }

            if($group_id != AffiliateStoreUser && !isset($data['PermissionStoreUser'])){
                redirect(base_url()."account", 'location');
                die();
            }
            
	        $data['menuPanelGroup'] = 4;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'chinhanh'; 
            $lList = array();
            $lListName = array();
            $userId = (int)$this->session->userdata('sessionUser');

            $select = 'u.use_id, u.use_username, tbtt_content.*';

            // get list id parent bran
            // $tree = array();
            // $get_idnvgh = $this->user_model->fetch('use_id','parent_id ='.$this->session->userdata('sessionUser').' and use_group = '. StaffStoreUser,"","","","");
            // $tree[] = $this->session->userdata('sessionUser');
            // foreach($get_idnvgh as $key=>$value){
            //     $tree[] = $value->use_id;
            // }
            // $parent_bran = implode($tree,',');
            $parent_bran = $this->session->userdata('sessionUser');
            if ($group_id == StaffStoreUser) {
               $get_idnvgh = $this->user_model->fetch_join('tbtt_user.parent_id, p.use_group as p_use_group', "LEFT", "tbtt_user as p", "p.use_id = tbtt_user.parent_id", 'tbtt_user.use_id =' . $this->session->userdata('sessionUser') . ' AND p.use_group= 3',"");

               if(!empty($get_idnvgh)) {
                    $parent_bran = $get_idnvgh[0]->parent_id;
               }else{
                    redirect(base_url() . "account", 'location');
                    die();
               }
            }
            $where = 'u.parent_id = '. $parent_bran . ' AND tbtt_content.not_status = 0 AND u.use_group = ' . BranchUser;
            $sort = '';
            $by = 'DESC'; 
            $sortUrl = '';
            $pageUrl = '';
            $pageSort = '';

            $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            #If have sort
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                switch (strtolower($getVar['sort'])) {                
                    case 'doanhso':
                        $pageUrl .= '/sort/doanhso';
                        $sort = "sho_name";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort = "use_id";
                }

                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc'){$pageUrl .= '/by/desc';
                    $by = "DESC";
                } else {
                    $pageUrl .= '/by/asc';
                    $by = "ASC";
                }
            }

            #If have page
            if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                $start = (int)$getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }
            #END Search & sort

            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'branch/newswaitapprove' . $sortUrl . '/sort/';
            $data['pageSort'] = $pageSort;
            #END Create link sort  
            
            //Update status for landing page
            $status = $_REQUEST['active'] ? $_REQUEST['active'] : 0;
            $id_lan = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
            if ($id_lan > 0){
                $this->content_model->update(array('not_status' => $status), 'not_id = '.$id_lan);
                redirect(base_url() . 'branch/newswaitapprove', 'location');
            }

            #BEGIN: Pagination
            $this->load->library('pagination');
            $this->load->model('branch_model');
            #Count total record
            $totalRecord = count($this->branch_model->fetch_join1("u.use_id","INNER","tbtt_content", "tbtt_content.not_user = u.use_id", $where, $sort, $by));

            $config['base_url'] = base_url() . 'branch/newswaitapprove' . $pageUrl . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = settingOtherAccount;
            $config['num_links'] = 1;
            $config['uri_segment'] = 4;
            $limmit = -1;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
            $data['sTT'] = $start + 1;
            #END Pagination

            $data["listcontent"] = $this->branch_model->fetch_join1($select, "INNER", "tbtt_content", "tbtt_content.not_user = u.use_id", $where, $order, $by, $start, $limit);

            //Load view
            $this->load->view('home/account/branch/newswaitapprove', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function deleteflyer($id){
        $this->load->model("landing_page_model");
        $data['userId'] = (int)$this->session->userdata('sessionUser');
        $isAuthor = $this->landing_page_model->isAuthor($data['userId'],$id );
        if($isAuthor){
            $this->landing_page_model->deleteLandingPage($id);
        }
        redirect(base_url().'branch/flyerwaitapprove');
    }

    function deletenews($id){
        $this->load->model("content_model");
        $data['userId'] = (int)$this->session->userdata('sessionUser');
        $isAuthor = $this->content_model->isAuthor($data['userId'],$id );
        if($isAuthor){
            $this->content_model->delete($id);
        }
        redirect(base_url().'branch/newswaitapprove');
    }

    function deletebranch($userId)
    {   
        #BEGIN: Check session user
        if ($this->session->userdata('sessionUser') > 0) {
            #BEGIN: Check session group
            $group_id = $this->session->userdata('sessionGroup');
            if($group_id == AffiliateStoreUser){
            }else{
                redirect(base_url()."account", 'location');
                die();
            }
            #END: Check session group            
            $this->load->model('user_model');
            $this->load->model('shop_model');

            //Check user
            $user_delete = $this->user_model->get("use_id, use_username, use_group", "use_id = ".
                (int)$userId);
            //Check sub user
            $sub_user = $this->user_model->get("use_id, use_username", "parent_id = ".(int)$userId); 

            if($sub_user == null && $user_delete->use_group == 14)
            {                
                #Check shop
                $shop = $this->shop_model->get();
                if($shop != null){
                     $this->shop_model->deleted((int)$userId);
                }
                $this->user_model->delete((int)$userId); 
            }
            redirect(base_url() . 'account/listbranch');

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function getSubList($email){
        $conn = new mysqli(email_hostname, email_username, email_password,email_database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query = "SELECT l.list_uid as id, l.name as name FROM `mw_list` as l
                    join mw_customer as c
                    on c.customer_id = l.customer_id
                    where c.email = '".$email."'";
        $result = $conn->query($query);
        $value = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $value[] = $row;
            }
        }
        return $value;
    }
    
    /**************************************************************************/
    function index()
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $body = array();
	    $body['menuPanelGroup'] = 4;
			$body['menuType'] = 'account';
			$body['menuSelected'] = 'chinhanh';            

            $this->load->view('home/account/branch/listbranch', $body);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }
  
    function ajaxAddProduct()
    {
        $this->load->model('package_daily_user_model');
        $this->load->model('product_model');
        $ids = $this->input->post('ids');
        $status = $this->input->post('status', 0);
        $userId = (int)$this->session->userdata('sessionUser');
        $totalAfCate = $this->package_daily_user_model->getTotalAfCate($userId);
       //$number_cat = 1 + (int)$totalAfCate[0]['total']; // lay so luong cat o day tu dich vu Ke hang
		$number_cat = 30 + (int)$totalAfCate[0]['total'];
       //$product_allow_af = product_allow_af;
        $cat_id = $this->product_model->get('pro_category','pro_id = '.$ids[0]);
       //$product_allow_af = 3;
		$product_allow_af = 32;
        $product_allow_aftotal = 0;
        $query	= "SELECT pro.pro_id,pro.pro_category, COUNT(pro.pro_id) as total_pro FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = ".$userId;
        $return = $this->db->query($query);
        $cat = $return->result();
        foreach ($cat as $item){
           // if ($cat_id->pro_category == $item->pro_category && $item->total_pro == $product_allow_af){
			if ($item->total_pro == $product_allow_af){	
			$product_allow_aftotal = 1;
            }
        }
        // truong hop 1 product
        $total = $this->getTotalCategories($userId,$ids);
        if ($userId <= 0) {
            $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');
        } else {
            $this->load->model('product_affiliate_user_model');
            if($status == 1 && $total > $number_cat){
                $return = array('error' => true, 'message' => 'Bạn chỉ có thể gắp hàng tối đa '.$number_cat.' danh mục. Để có thể gắp thêm vui lòng mua <a class="link_popup" href="'.base_url().'account/service">Dịch vụ kệ hàng</a>');
            }else{
                foreach($ids as $k=> $id){
                    if ($status == 0 ) { //&& $total['error'] == false  && $total < $number_cat && $total >= 0
                        $this->product_affiliate_user_model->delete(array('use_id' => $userId, 'pro_id' => $id));
                        $return = array('error' => false, 'message' => 'Thành công', 'total' => $total);
                    } elseif (($status == 1) && $product_allow_aftotal == 0) { // && $total <= $number_cat
                        $return = array('error' => false, 'message' => 'Thành công', 'total' => $total);
                        $this->product_affiliate_user_model->insert(array('use_id' => $userId, 'pro_id' => $id, 'date_added' => time() ));
                    }
                    elseif(($status == 1) && $product_allow_aftotal == 1){
                        $return = array('error' => true, 'message' => 'Bạn chỉ có thể gắp hàng tối đa '.$product_allow_af.' sản phẩm trong một danh mục!');
                    }
                }
            }
        }
        echo json_encode($return);
        exit();
    }

    function getTotalCategories($userId,$ids){
        $this->load->model('product_model');
        $this->load->model('user_model');
        $user_detail = $this->user_model->get('*','use_id = '.$userId.' AND use_status = 1');
        $shop_parent = 0;
        $return = 0;
        if($user_detail->parent_id > 0){
            $user_parent = $this->user_model->get('*','use_id = '.$user_detail->parent_id.' AND use_status = 1');
            if($user_parent->use_group == 3){
                $shop_parent = $user_parent->use_id;
            }elseif($user_parent->use_group != 3 && $user_detail->parent_shop > 0){
                $shop_parent = $user_detail->parent_shop;
            }
        }
        if(count($ids) == 1){
            $product = $this->product_model->get("pro_category, pro_user","pro_id = ".$ids[0]);
            if($shop_parent == $product->pro_user){ // neu gap san pham cua shop cha thi luon cho gap
                $return = 0;
            }
        }elseif(count($ids) == 2 && $ids[0] == 1){
            $product = $this->product_model->get("pro_category, pro_user","pro_id = ".$ids[1]);
            if($shop_parent == $product->pro_user){ // neu gap san pham cua shop cha thi luon cho gap
                $return = 0;
            }
        }
        $this->load->model('product_affiliate_user_model');
        $total = $this->product_affiliate_user_model->getTotalCategoriesByAff($userId);
        if(count($total) > 0){
            // xu ly nhieu row
            if(count($ids) >= 2 && $ids[0] > 1){
                $counter = 0;
                $restCat = 0;
                foreach($ids as $id){
                    $product1 = $this->product_model->get("pro_category, pro_user","pro_id = ".$id);
                    $this->db->flush_cache();
                    foreach ($total as $total_item) {
                        if ($product1->pro_category == $total_item->pro_category) {
                            $counter ++;
                        }
                    }
                }
                $restCat = count($ids) - $counter;
                $return = count($total) + $restCat;
            }
        }

        if(count($ids) == 1){
            $inList = 0;
            if(count($total) > 0) {
                foreach ($total as $total_item) {
                    if ($product->pro_category == $total_item->pro_category) {
                        $inList = 1;
                        break;
                    }
                }
            }
            if ($inList == 1) {
                $return = count($total);
            } else {
                $return = count($total) + 1;
            }

        }elseif(count($ids) == 2 && $ids[0] == 1){
            $inList = 0;
            if(count($total) > 0) {
                foreach ($total as $total_item) {
                    if ($product->pro_category == $total_item->pro_category) {
                        $inList = 1;
                        break;
                    }
                }
            }
            if ($inList == 1) {
                $return = count($total);
            } else {
                $return = count($total) + 1;
            }
        }
        return $return;
    }
   
	function loadCategoryHot($parent, $level)
	{
	   $retArray = '';
	   
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent' and cat_hot = 1 ";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   
	   $retArray .= '<div class="row hotcat">';
	   foreach ($category as $key=>$row)
	   {
		   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
		   $images = '<img class="img-responsive" src="'.base_url().'templates/home/images/category/'.$row->cat_image.'"/><br/>';
		   $retArray .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">'.$images.'<strong>'.$link.'</strong>';
		   $retArray .= $this->loadSupCategoryHot($row->cat_id, $level+1);
		   $retArray .= "</div>";
	   }
	   $retArray .= '</div>';
	   return $retArray;
	}
	
	function loadSupCategoryHot($parent, $level)
	{
	   $retArray = '';	   
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'  and cat_hot = 1 ";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   
	   $retArray .= '<ul class="supcat">';
	   foreach ($category as $key=>$row)
	   {
		   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
		   $retArray .= '<li> - '.$link.'</li>';
		   
	   }
	   $retArray .= '</ul>';
	   return $retArray;
	}
	
	function loadCategoryRoot($parent, $level)
	{
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $categoryRoot  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   return $categoryRoot;
	}        
        
    public function getMainDomain()
    {
        $result = base_url();
        $sub = $this->getShopLink();
        if ($sub != '') {
            $result = str_replace('//' . $sub . '.', '//', $result);
        }
        return $result;
    }

    public function getShopLink()
    {
        $result = '';
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[0];
        }
        return $result;
    }
}
