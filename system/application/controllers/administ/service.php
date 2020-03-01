<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends CI_Controller
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
        $this->lang->load('admin/service');
        $this->load->helper('language');
    }

    function index($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service');
        $data['data'] = $this->package_user_model->lister(array(), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }
    function request($page = 0)
    {
		
        $this->load->model('package_user_model');
		
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/request');
        $data['data'] = $this->package_user_model->lister(array('os'=> '01'), $page);
		
		
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = base_url() . 'administ/service/register';
		$this->db->flush_cache();
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }
	function getParent($id){
		$this->db->flush_cache();
		$this->load->model('user_model');
		if($id > 0){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$id);
			return $parentObject;
		}
		
	}
    function paymented($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/paymented');
        $data['data'] = $this->package_user_model->lister(array('os'=> '02'), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }
    function using($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/using');
        $data['data'] = $this->package_user_model->lister(array('os'=> '03'), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
        $parentList = array(); 
        foreach ($data['data'] as $userObject){
            if($userObject['parent_id'] > 0){
                $parentObject = $this->getParent($userObject['parent_id']);
                $parentList[] = $parentObject;
            }else{
                $parentList[] = new StdClass();
            }
        }
        $data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);


    }
    function expiring($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/expiring');
        $data['data'] = $this->package_user_model->lister(array('os'=> '04'), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }
    function expired($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/expired');
        $data['data'] = $this->package_user_model->lister(array('os'=> '05'), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }
    function cancel($page = 0)
    {
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/cancel');
        $data['data'] = $this->package_user_model->lister(array('os'=> '06'), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['packages'] = $this->package_user_model->getPackage();
        $data['filter'] = $this->package_user_model->getFilter();
        $data['period'] = $this->package_user_model->getPeriod();
        $data['sortDate'] = $this->package_user_model->getSortDate();
        $data['serviceStatus'] = $this->package_user_model->getServiceStatus();
        $data['link'] = $this->package_user_model->getLink();
        $data['add'] = $data['link'].'/register';
		$parentList = array(); 
		foreach ($data['data'] as $userObject){
			if($userObject['parent_id'] > 0){
				$parentObject = $this->getParent($userObject['parent_id']);
				$parentList[] = $parentObject;
			}else{
				$parentList[] = new StdClass();
			}
		}
		$data['parentList'] = $parentList;
        $this->load->view('admin/service/defaults', $data);
    }

    function subService($id){
        $this->load->model('package_user_model');
        $data['data'] = $this->package_user_model->getSubservice($id);
        $data['id'] = $id;
        $this->load->view('admin/service/subservice', $data);
    }
    function registerService($page = 0){
        $this->load->model('package_user_model');
        $this->package_user_model->pagination(TRUE);
        $this->package_user_model->setLink(base_url() . 'administ/service/register');
        $data['data'] = $this->package_user_model->getUserList(array(), $page);
        $data['pager'] = $this->package_user_model->pager;
        $data['filter'] = $this->package_user_model->getFilter();
        $data['num'] = $this->package_user_model->num;
        $data['sort'] = $this->package_user_model->getAdminSort();
        $data['link'] = base_url() . 'administ/service/register';
        $data['packages'] = $this->package_user_model->getPackageList();
        $this->load->view('admin/service/register', $data);
    }
    function addPackage(){
        $package = $this->input->post('package', 0);
        $uid = $this->input->post('uid', 0);
        $this->load->model('package_user_model');
        $return = $this->package_user_model->addPackage($uid, $package);
        echo json_encode($return);
        exit();
    }
    function updateUserService(){
        $order_id = (int)$this->input->post('order_id');
        $service_id = (int)$this->input->post('service_id');
        $status = (int)$this->input->post('status');
        $note = trim($this->filter->injection_html($this->input->post('note')));
        $data = array('order_id'=>$order_id, 'service_id'=>$service_id, 'status'=>$status, 'note'=>$note, 'modified_date'=>date('Y-m-d H:i:s'));
        $this->load->model('package_user_model');
        $where = array();
        $where['order_id'] = $order_id;
        $where['service_id'] = $service_id;
        if($status == 1){
            $where['status'] = 0;
        }
        $result = $this->package_user_model->updateUserService($data, $where);
        if ($result > 0 ) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function completePayment()
    {
        $orderId = $this->input->post('order', 0);
        $this->load->model('package_user_model');
        $result = $this->package_user_model->completePayment($orderId);

        if ($result > 0) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function cancelOrder()
    {
        $orderId = $this->input->post('order', 0);
        $this->load->model('package_user_model');
        $result = $this->package_user_model->cancelOrder($orderId);

        if ($result > 0) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function startService()
    {
        $orderId = $this->input->post('order', 0);
        $this->load->model('package_user_model');
        $result = $this->package_user_model->startService($orderId);

        if ($result > 0) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function package($page = 0)
    {
        $curlink = 'administ/service/package';
        $this->load->model('service_model');
        $this->service_model->pagination(true);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getPackage(array('pType'=>'package','published'=>'1'), $page);
        $body['sort'] = $this->service_model->getAdminSort();
        $body['pager'] = $this->service_model->pager;
        $body['filter'] = $this->service_model->getFilter();
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink.'/edit/0';
        $this->load->view('admin/service/package', $body);

    }
    function simple($page = 0)
    {       
        $curlink = 'administ/service/simple';
        $this->load->model('service_model');
        $this->service_model->pagination(true);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getPackage(array('pType'=>'simple'), $page, 'tbtt_package_info.*, (SELECT `month_price` FROM `tbtt_package` WHERE `info_id` = `tbtt_package_info`.id LIMIT 0, 1) as month_price');
        $body['sort'] = $this->service_model->getAdminSort();
        $body['pager'] = $this->service_model->pager;
        $body['filter'] = $this->service_model->getFilter();
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink .'/edit/0';
        $body['num'] = $page;
        $this->load->view('admin/service/simple', $body);
    }

    function daily_service($page = 0)
    {
        $curlink = 'administ/service/daily_service';
        $this->load->model('package_daily_model');
        $body = array();
        $body['list'] = $this->package_daily_model->get_list(array('select'=> '*'));
        $body['packageType'] = array(
            array('code'=>'01', 'text'=>'Tường chung'),
            array('code'=>'02', 'text'=>'Tường riêng'),
            array('code'=>'03', 'text'=>'Tin tức'),
            array('code'=>'04', 'text'=>'Ăn gì'),
            array('code'=>'05', 'text'=>'Chơi gì'),
            array('code'=>'06', 'text'=>'Mua gì'),
            array('code'=>'07', 'text'=>'Ở đâu'),
            array('code'=>'08', 'text'=>'Ấn hàng'),
            array('code'=>'09', 'text'=>'Kệ hàng'),
        );
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink.'/edit/0';
        $body['num'] = $page;
        $this->load->view('admin/service/daily_service', $body);
    }

    function simpleAdd(){
        $this->load->model('service_model');
        $this->load->library('form_validation');
        $data['aListGService'] =  $this->service_model->getServiceGroupList(array('type' => 'simple'));
        #BEGIN: Set rules
        $this->form_validation->set_rules('limit', 'lang:ser_require', 'trim|required');
        //$this->form_validation->set_rules('max_email', 'lang:ser_require', 'trim|required');
        #END Set rules
        #BEGIN: Set message
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        #END Set message

        if ($this->form_validation->run() != FALSE) {
            $published = ($this->input->post('published') == '1') ? 1 : 0;
            $install = ($this->input->post('install') == '1') ? 1 : 0;
            $price = (int)$this->input->post('month_price');
            $dataEdit = array(
                'limit' => (int)$this->input->post('limit'),
                'unit' => $this->input->post('unit'),
                'group'=> (int)$this->input->post('group'),
                'name' => $this->input->post('name'),
                'desc' => trim($this->filter->injection_html($this->input->post('desc'))),
                'note' => trim($this->filter->injection_html($this->input->post('note'))),
                'published' => $published,
                'install' => $install
            );

            $id = $this->service_model->addSimpleService($dataEdit, $price);
            redirect(base_url() .'administ/service/simple', 'location');
        }
        $this->load->view('admin/service/simple_add', $data);
    }
    
    function simpleEdit($id){
        $data = array();
        $link = 'administ/service/simple/edit';
        $cancel = 'administ/service/simple';
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        $this->load->model('affiliate_level_model');
        $data['affiliatelevel'] = $this->affiliate_level_model->get();
        if(isset($data['affiliatelevel']) && !empty($data['affiliatelevel'])) {
            $this->load->model('affiliate_price_model');
            foreach ($data['affiliatelevel'] as $iK => $Aff) {
                $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$id.' && user_set = 0 && id_level = '.$Aff->id);
                if(!empty($aAffPrice)) {
                    $data['affiliatelevel'][$iK]->price =  $aAffPrice['discount_price'];
                    $data['affiliatelevel'][$iK]->percen =  $aAffPrice['discount_value'];
                }else {
                    $data['affiliatelevel'][$iK]->price = 0;
                    $data['affiliatelevel'][$iK]->percen = 0;
                }
            }
        }
        $this->load->model('service_model');
        $package = new stdClass();
        $this->load->library('form_validation');
        $data['service'] = $this->service_model->getSimpleGroup();

        if((int)$id > 0){
            $package = $this->service_model->getSimplePackageInfo($id);
            if (count($package) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/simple', 'location');
                die();
            }
        }else{
            $package->name = '';
            $package->published = 1;
            $package->desc = '';
            $package->id = 0;
            $package->image = '';
        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;

            #END Get province by $id

            #END Get province by $id

            #BEGIN: Set rules
            $this->form_validation->set_rules('limit', 'lang:ser_require', 'trim|required');
            //$this->form_validation->set_rules('max_email', 'lang:ser_require', 'trim|required');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                $published = ($this->input->post('published') == '1') ? 1 : 0;
                $install = ($this->input->post('install') == '1') ? 1 : 0;
                $price = (int)$this->input->post('month_price');
                $dataEdit = array(
                    'limit' => (int)$this->input->post('limit'),
                    'unit' => $this->input->post('unit'),
                    'group' => (int)$this->input->post('group_servi'),
                    'desc' => trim($this->filter->injection_html($this->input->post('desc'))),
                    'note' => trim($this->filter->injection_html($this->input->post('note'))),
                    'published' => $published,
                    'install' => $install
                );
                
                foreach($data['service'] as $item){
                    if($item['group'] == $dataEdit['group']){
                        $dataEdit['name'] = $item['text'];
                        break;
                    }
                }

                if((int)$id > 0){
                    // Create FTP
                    $this->load->library('ftp');
                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port']     = PORT_CLOUDSERVER;                
                    $config['debug']    = FALSE;
                    $this->ftp->connect($config);
                    $this->load->library('upload');

                    #Create folder
                    $path = '/public_html/media/service_azibai/';
            
                    // Up hình crop
                    if(isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['type'] != ''){
                        $fImage     = $_FILES['image'];
                        $sType = checkExtensionImage($fImage['type']);

                        $sImageName = uniqid().time().uniqid().$sType;
                
                        $this->ftp->upload($fImage['tmp_name'],$path.$sImageName,0755);
                        $dataEdit['image'] = $sImageName;
                    }

                    if ($this->service_model->updateSimpleService($dataEdit, array('id'=> $id, 'price'=>$price))) {
                        if(isset($data['affiliatelevel']) && !empty($data['affiliatelevel'])) {
                            $this->load->model('affiliate_price_model');
                            foreach ($data['affiliatelevel'] as $iK => $Aff) {
                                
                                $iAffPrice  = $this->input->post('price_aff_'.$Aff->id);
                                $iAffPercen = $this->input->post('percen_aff_'.$Aff->id);
                                $aAffPrice  = array(
                                    'service_id'        => $id,
                                    'cost'              => (int) $this->input->post('month_price'),
                                    'discount_price'    => (int) $iAffPrice,
                                    'discount_value'   => $iAffPercen,
                                    'user_set'          => 0,
                                    'user_app'          => 0,
                                    'id_level'          => $Aff->id
                                );

                                $aListAffPrice =  $this->affiliate_price_model->get('*','service_id = '.$id.' && user_set = 0 && id_level = '.$Aff->id);
                                if(isset($aListAffPrice[0]) && !empty($aListAffPrice[0]) && $iAffPrice != 0) {
                                    $this->affiliate_price_model->update($aAffPrice, 'id = ' . $aListAffPrice[0]->id);
                                    if($aListAffPrice[0]->discount_price != $iAffPrice) {
                                        // Sau này khi dữ liệu lớn thì gắn vào cron job
                                        $aListAffOld =  $this->affiliate_price_model->get('*','service_id = '.$id.' && id_level = '.$Aff->id);
                                        if(!empty($aListAffOld)) {
                                            foreach ($aListAffOld as $oPrice) {
                                                $this->affiliate_price_model->update(array('discount_price' => $iAffPrice,
                                                    'cost'          => (int) $this->input->post('month_price')), 'id = ' . $oPrice->id);
                                            }
                                        }
                                    }
                                }else if($iAffPrice != 0) {
                                    $iAffLevel = $this->affiliate_price_model->add($aAffPrice);
                                }
                            }
                        }
                        //$this->db->cache_off();
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                } else{

                    $id = $this->service_model->addSimpleService($dataEdit, $price);
                    if ($id > 0) {
                        //$this->db->cache_off();
                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }
                //$this->session->set_flashdata('sessionSuccessEdit', 1);
                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        // Get service info
        foreach ($package as $key => $val){
            $data[$key] = $val;
        }        
        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;

        $this->load->view('admin/service/simple_edit', $data);
    }

    function dailyEdit($id){
        $data = array();
        $link = 'administ/service/daily_service/edit';
        $cancel = 'administ/service/daily_service';
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        $this->load->model('package_daily_model');
        $package_daily = new stdClass();
        $this->load->library('form_validation');
        $data['packageType'] = array(
            array('code'=>'01', 'text'=>'Tường chung'),
            array('code'=>'02', 'text'=>'Tường riêng'),
            array('code'=>'03', 'text'=>'Tin tức'),
            array('code'=>'04', 'text'=>'Ăn gì'),
            array('code'=>'05', 'text'=>'Chơi gì'),
            array('code'=>'06', 'text'=>'Mua gì'),
            array('code'=>'07', 'text'=>'Ở đâu'),
            array('code'=>'08', 'text'=>'Ấn hàng'),
            array('code'=>'09', 'text'=>'Kệ hàng'),
        );

        if((int)$id > 0){
            $package_daily = $this->package_daily_model->get_one(array('select'=>'*', 'where'=>array('id'=>$id)));
            if (empty($package_daily) || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/daily_service', 'location');
                die();
            }

        }else{
            $package_daily->name ='';
            $package_daily->p_type = '01';
            $package_daily->desc= '';
            $package_daily->id = 0;
        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;
            #END Set message
            if (!empty($_POST)) {
                $dataEdit = array(

                    'p_name' => $this->input->post('p_name'),
                    'p_type' => $this->input->post('p_type'),
                    'pos_num' => $this->input->post('pos_num'),
                    'price_min' => $this->input->post('price_min'),
                    'price_max' => $this->input->post('price_max'),
                    'unit' => $this->input->post('unit')

                );

                if((int) $id > 0){
                    unset($dataEdit['p_type']);
                    if ($this->package_daily_model->update($dataEdit, array('id'=> $id))) {

                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                }else{

                    $id = $this->package_daily_model->add($dataEdit);

                    if ($id > 0) {

                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }
                //$this->session->set_flashdata('sessionSuccessEdit', 1);
                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        // Get service info

        foreach ($package_daily as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;
        $this->load->view('admin/service/daily_edit', $data);
    }
    function simpleStatus($status = '', $id = 0)
    {

        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->updateSimpleServiceStatus(array('published' => $published), $id);
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/simple', 'location');

    }
    function packageStatus($status = '', $id = 0)
    {
        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->packageInfoUpdate(array('published' => $published), $id);
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/package', 'location');

    }

    function packageEdit($id = 0)
    {
        $data = array();
        $link = 'administ/service/package/edit';
        $cancel = 'administ/service/package';
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        $this->load->model('service_model');
        $package = new stdClass();
        $this->load->library('form_validation');
        if((int)$id > 0){
            $package = $this->service_model->getPackageInfo("*", "id = " . (int)$id);

            if (count($package) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/package', 'location');
                die();
            }
        }else{
            $package->name ='';
            $package->published = 1;
            $package->desc= '';
            $package->id = 0;
            $package->image ='';
        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;


            #END Get province by $id

            #BEGIN: Set rules
            $this->form_validation->set_rules('package_name', 'lang:ser_name', 'trim|required');
            //$this->form_validation->set_rules('order_province', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                $published = ($this->input->post('package_published') == '1') ? 1 : 0;
                if((int) $id > 0){
                    $dataEdit = array(
                        'name' => trim($this->filter->injection_html($this->input->post('package_name'))),
                        'desc' => trim($this->filter->injection_html($this->input->post('package_desc'))),
                        'published' => $published
                    );

                     // Create FTP
                    $this->load->library('ftp');
                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port']     = PORT_CLOUDSERVER;                
                    $config['debug']    = FALSE;
                    $this->ftp->connect($config);
                    $this->load->library('upload');

                    #Create folder
                    $path = '/public_html/media/service_azibai/';
            
                    // Up hình crop
                    if(isset($_FILES['image']) && !empty($_FILES['image'])){
                        $fImage     = $_FILES['image'];
                        $sType = checkExtensionImage($fImage['type']);
                        $sImageName = uniqid().time().uniqid().$sType;
                
                        $this->ftp->upload($fImage['tmp_name'],$path.$sImageName,0755);
                        $dataEdit['image'] = $sImageName;
                    }

                    $parrams = array('info_id' => $id);
                    if ($this->service_model->updatePackageInfo($dataEdit, "id = " . (int)$id, $parrams)) {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                }else{
                    $dataAdd = array(
                        'name' => trim($this->filter->injection_html($this->input->post('package_name'))),
                        'desc' => trim($this->filter->injection_html($this->input->post('package_desc'))),
                        'published' => $published
                    );
                    $id = $this->service_model->addPackageInfo($dataAdd);
                    if ($id > 0) {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }

                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        foreach ($package as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;
        $this->load->view('admin/service/package_edit', $data);
    }

    function servicelist($id = 0, $page = 0)
    {
        if ($id == 0) {
            redirect(base_url() . 'administ/service/package', 'location');
            die();
        }
        $curlink = 'administ/service/servicelist/' . $id;
        $this->load->model('service_model');
        $this->service_model->pagination(FALSE);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getServiceList(array('tbtt_package_service.package_id' => $id), $page);
        $body['sort'] = $this->service_model->getAdminSort();

        $body['filter'] = $this->service_model->getFilter();
        $body['link'] = base_url() . $curlink;
        $body['pid'] = $id;
        $body['services'] = $this->service_model->getServiceData('`id`,`group`, `name`,`limit`,`unit`');
        $body['infoText'] = $this->service_model->getPackageInfo('name', array('id'=>$id));
        $this->load->view('admin/service/servicelist', $body);
    }
    function servicelistStatus($pid = 0, $status = '', $id = 0)
    {
        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->updateServiceInfo(array('published' => $published), 'id = '.$id);
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/package/servicelist/'.$pid, 'location');

    }

    function pricelist($id, $page = 0)
    {
        if ($id == 0) {
            redirect(base_url() . 'administ/service/package', 'location');
            die();
        }
        $curlink = 'administ/service/package/pricelist/' . $id;
        $this->load->model('service_model');
        $this->service_model->pagination(true);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getPriceList(array('tbtt_package.info_id' => $id), $page);
        $body['sort'] = $this->service_model->getAdminSort();
        $body['filter'] = $this->service_model->getFilter();
        $body['pager'] = $this->service_model->pager;
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink.'/edit/0';
        $body['infoText'] = $this->service_model->getPackageInfo('name', array('id'=>$id));
        $this->load->view('admin/service/pricelist', $body);
    }
    function listService( $page = 0)
    {
        $curlink = 'administ/service/list';
        $this->load->model('service_model');
        $this->service_model->pagination(true);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getService(array('published'=>1), $page);
        $body['sort'] = $this->service_model->getAdminSort();
        $body['filter'] = $this->service_model->getFilter();
        $body['pager'] = $this->service_model->pager;
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink.'/edit/0';
        $this->load->view('admin/service/service', $body);
    }
    function pricelistStatus($pid = 0, $status = '', $id = 0)
    {
        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->updatePriceList(array('published' => $published), 'id = '.$id);
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/package/pricelist/'.$pid, 'location');

    }

    function pricelistEdit($pid = 0, $id = 0)
    {
        if ($pid == 0) {
            redirect(base_url() . 'administ/service/package', 'location');
            die();
        }
        $data = array();
        $link = 'administ/service/package/pricelist/'.$pid.'/edit';
        $cancel = 'administ/service/package/pricelist/'.$pid;
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        $this->load->model('service_model');
        $priceList = new stdClass();
        $this->load->library('form_validation');
        if((int)$id > 0){
            $priceList = $this->service_model->getPriceListInfo("*", array('id'=>(int)$id, 'info_id'=>$pid));

            if (count($priceList) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/package/pricelist/'.$pid, 'location');
                die();
            }
        }else{
            $priceList->info_id = $pid;
            $priceList->period = -1;
            $priceList->month_price= 0;
            $priceList->discount_rate= 0;
            $priceList->published = 1;
            $priceList->id = 0;
        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;


            #END Get province by $id

            #BEGIN: Set rules
            $this->form_validation->set_rules('month_price', 'lang:ser_require', 'trim|required');
            $this->form_validation->set_rules('discount_rate', 'lang:ser_require', 'trim|required');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                $published = ($this->input->post('published') == '1') ? 1 : 0;
                $dataEdit = array(
                    'info_id'=>$pid,
                    'period' => (int)$this->input->post('period'),
                    'month_price' => (int)$this->input->post('month_price'),
                    'discount_rate' => (int)$this->input->post('discount_rate'),
                    'point' => (int)$this->input->post('point'),
                    'published' => $published
                );
                if((int) $id > 0){

                    if ($this->service_model->updatePriceListInfo($dataEdit, "id = " . (int)$id)) {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                }else{

                    $id = $this->service_model->addPriceListInfo($dataEdit);
                    if ($id > 0) {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }

                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        foreach ($priceList as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;
        $data['infoText'] = $this->service_model->getPackageInfo('name', array('id'=>$pid));
        $data['periodList'] = $this->service_model->getPricePeriod();
        $this->load->view('admin/service/pricelist_edit', $data);
    }

    function changePackageService(){
        $package_id = (int)$this->input->post('package_id');
        $service_id = (int)$this->input->post('service_id');
        $oldsid = (int)$this->input->post('oldsid');
        $ordering = (int)$this->input->post('ordering');
        $data = array('package_id'=>$package_id, 'service_id'=>$service_id, 'ordering'=>$ordering);
        $this->load->model('service_model');
        if($oldsid > 0){
            $result = $this->service_model->updatePackageService($data, array('package_id'=>$package_id, 'service_id'=>$oldsid));
        }else{
            $result = $this->service_model->addPackageService($data);
        }

        if ($result) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function deletePackageService(){
        $package_id = (int)$this->input->post('package_id');
        $service_id = (int)$this->input->post('service_id');
        $data = array('package_id'=>$package_id, 'service_id'=>$service_id);
        $this->load->model('service_model');
        $result = $this->service_model->deletePackageService($data);
        if ($result) {
            $return = array('error' => false, 'message' => 'Thành công');
        } else {
            $return = array('error' => true, 'message' => 'Có lỗi');
        }
        echo json_encode($return);
        exit();
    }

    function serviceStatus($status = '', $id = 0)
    {
        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->updateService(array('published' => $published), array('id'=>$id));
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/list', 'location');

    }

    function serviceGroupStatus($status = '', $id = 0)
    {
        if ($id > 0) {
            $published = 0;
            switch ($status) {
                case 'deactive':
                    $published = 0;
                    break;
                case 'active':
                    $published = 1;
                    break;
            }
            $this->load->model('service_model');
            $this->service_model->updateServiceGroup(array('published' => $published), array('id'=>$id));
        }
        $this->load->helper('url');
        redirect(base_url() . 'administ/service/group', 'location');
    }

    function editService( $id = 0)
    {
        if($id <= 0){
            redirect(base_url() . 'administ/service/list', 'location');
        }
        $data = array();
        $link = 'administ/service/list/edit';
        $cancel = 'administ/service/list';
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        
        $this->load->model('service_model');
        $serviceList = new stdClass();
        $this->load->library('form_validation');
        $data['service'] = $this->service_model->getServiceGroup();
        if((int)$id > 0){
            $serviceList = $this->service_model->getServiceInfo("*", array('id'=>(int)$id));
            
            $aPS = $this->service_model->getPackageService('*','service_id = '. $id);

            $oPack =  $this->service_model->getPriceListInfo('*','id = '.$aPS->package_id);
            if(!empty($oPack)) {
                $serviceList->month_price = $oPack->month_price;
            }else {
                $serviceList->month_price = 0;
            }

            if (count($serviceList) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/list', 'location');
                die();
            }
            $this->load->model('affiliate_level_model');
            $data['affiliatelevel'] = $this->affiliate_level_model->get();
            if(isset($data['affiliatelevel']) && !empty($data['affiliatelevel'])) {
                $this->load->model('affiliate_price_model');
                foreach ($data['affiliatelevel'] as $iK => $Aff) {
                    $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$oPack->info_id.' && user_set = 0 && id_level = '.$Aff->id);
                    if(!empty($aAffPrice)) {
                        $data['affiliatelevel'][$iK]->price =  $aAffPrice['discount_price'];
                        $data['affiliatelevel'][$iK]->percen =  $aAffPrice['discount_value'];
                    }else {
                        $data['affiliatelevel'][$iK]->price = 0;
                        $data['affiliatelevel'][$iK]->percen = 0;
                    }
                }
            }

        }else{
            $serviceList->limit = 0;
            $serviceList->unit= '';
            $serviceList->desc= '';
            $serviceList->note= '';
            $serviceList->published = 1;
            $serviceList->id = 0;
            $serviceList->group = '01';
            $serviceList->install = 0;
            $serviceList->month_price = 0;
        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;


            #END Get province by $id

            #BEGIN: Set rules
            $this->form_validation->set_rules('limit', 'lang:ser_require', 'trim|required');
            //$this->form_validation->set_rules('max_email', 'lang:ser_require', 'trim|required');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                $published = ($this->input->post('published') == '1') ? 1 : 0;
                $install = ($this->input->post('install') == '1') ? 1 : 0;
                $dataEdit = array(
                    'name' => $this->input->post('name'),
                    'limit' => (int)$this->input->post('limit'),
                    'unit' => $this->input->post('unit'),
                    'group' => $this->input->post('group'),
                    'desc' => trim($this->filter->injection_html($this->input->post('desc'))),
                    'note' => trim($this->filter->injection_html($this->input->post('note'))),
                    'published' => $published,
                    'install' => $install
                );
                if((int) $id > 0){
                    if ($this->service_model->updateService($dataEdit, array('id'=> $id))) {
                        $dataUpdate = array(
                            'published'     => $published,
                        );
                        $this->service_model->updatePriceListInfo(
                            $dataUpdate,'id = '.$oPack->id
                        );
                        //$this->db->cache_off();
                        //$this->session->set_flashdata('sessionSuccessEdit', 1);

                        if(isset($aPS->package_id) && $aPS->package_id != 0) {
                            $aDataP['month_price'] = $this->input->post('month_price');
                            $iPackS = $this->service_model->updatePriceList($aDataP,'id = '.$aPS->package_id);
                        }

                        if(isset($iPackS) && $iPackS == 1 ) {
                            if(isset($oPack->info_id) && $oPack->info_id != 0) {
                                $oPackInfo =  $this->service_model->getPackageInfo('*','id = '.$oPack->info_id);
                                if(!empty($oPackInfo)) {
                                    $aDataPInfo = array(
                                        'name'  => $dataEdit['name']
                                    );
                                    $this->service_model->updatePackageInfo($aDataPInfo, 'id = '.$oPack->info_id);
                                }
                            }

                        }

                        if(isset($data['affiliatelevel']) && !empty($data['affiliatelevel'])) {

                            $this->load->model('affiliate_price_model');
                            foreach ($data['affiliatelevel'] as $iK => $Aff) {
                                
                                $iAffPrice  = $this->input->post('price_aff_'.$Aff->id);
                                $iAffPercen = $this->input->post('percen_aff_'.$Aff->id);
                                $aAffPrice  = array(
                                    'service_id'        => $oPack->info_id,
                                    'cost'              => (int) $this->input->post('month_price'),
                                    'discount_price'    => (int) $iAffPrice,
                                    'discount_value'   => $iAffPercen,
                                    'user_set'          => 0,
                                    'user_app'          => 0,
                                    'id_level'          => $Aff->id
                                );

                                $aListAffPrice =  $this->affiliate_price_model->get('*','service_id = '.$oPack->info_id.' && user_set = 0 && id_level = '.$Aff->id);
                                if(isset($aListAffPrice[0]) && !empty($aListAffPrice[0]) && $iAffPrice != 0) {
                                    $this->affiliate_price_model->update($aAffPrice, 'id = ' . $aListAffPrice[0]->id);
                                    if($aListAffPrice[0]->discount_price != $iAffPrice) {
                                        // Sau này khi dữ liệu lớn thì gắn vào cron job
                                        $aListAffOld =  $this->affiliate_price_model->get('*','service_id = '.$id.' && id_level = '.$Aff->id);
                                        if(!empty($aListAffOld)) {
                                            foreach ($aListAffOld as $oPrice) {
                                                $this->affiliate_price_model->update(array('discount_price' => $iAffPrice,
                                                    'cost'          => (int) $this->input->post('month_price')), 'id = ' . $oPrice->id);
                                            }
                                        }
                                    }
                                }else if($iAffPrice != 0) {
                                    $iAffLevel = $this->affiliate_price_model->add($aAffPrice);
                                }
                            }
                        }
                    }
                }else{

                    $id = $this->service_model->addService($dataEdit);
                    if ($id > 0) {
                        //$this->db->cache_off();
                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }
                //$this->session->set_flashdata('sessionSuccessEdit', 1);
                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        foreach ($serviceList as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;

        $data['periodList'] = $this->service_model->getPricePeriod();
        $this->load->view('admin/service/service_edit', $data);
    }

    function addService() {
        $data = array();
        $link = 'administ/service/addService';
        $cancel = 'administ/service/list';
        
        #BEGIN: Get province by $id
        $this->load->model('service_model');
        $serviceList = new stdClass();
        $this->load->library('form_validation');
        $data['service'] = $this->service_model->getServiceGroup();

        #END Get province by $id

        #BEGIN: Set rules
        $this->form_validation->set_rules('limit', 'lang:ser_require', 'trim|required');
        //$this->form_validation->set_rules('max_email', 'lang:ser_require', 'trim|required');
        #END Set rules
        #BEGIN: Set message
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        #END Set message
        if ($this->form_validation->run() != FALSE) {
            $published = ($this->input->post('published') == '1') ? 1 : 0;
            $install = ($this->input->post('install') == '1') ? 1 : 0;
            $dataEdit = array(
                'name'  => $this->input->post('name'),
                'limit' => (int)$this->input->post('limit'),
                'unit' => $this->input->post('unit'),
                'group' => $this->input->post('group'),
                'desc' => trim($this->filter->injection_html($this->input->post('desc'))),
                'note' => trim($this->filter->injection_html($this->input->post('note'))),
                'published' => $published,
                'install' => $install
            );
            $id = $this->service_model->addService($dataEdit);
            if ($id > 0) {
                //$this->db->cache_off();
                $this->session->set_flashdata('sessionSuccessEdit', 1);

            }
            
            redirect(base_url() . 'administ/service/list', 'location');
        }
        foreach ($serviceList as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;

        $this->load->view('admin/service/service_add', $data);
    }

    function serviceGroup($page){
        $curlink = 'administ/service/group';
        $this->load->model('service_model');
        $this->service_model->pagination(true);
        $this->service_model->setCurLink($curlink);
        $body = array();
        $body['list'] = $this->service_model->getServiceGroupList(array(), $page);

        $body['sort'] = $this->service_model->getAdminSort();
        $body['filter'] = $this->service_model->getFilter();
        $body['pager'] = $this->service_model->pager;
        $body['link'] = base_url() . $curlink;
        $body['add'] = base_url() . $curlink.'/edit/0';
        $body['num'] = $page;

        $this->load->view('admin/service/service_group', $body);
    }

    function editServiceGroup( $id = 0)
    {

        $data = array();
        $link = 'administ/service/group/edit';
        $cancel = 'administ/service/group';
        #BEGIN: CHECK PERMISSION
        /*if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
        {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }*/
        #END CHECK PERMISSION
        #BEGIN: Get province by $id
        $this->load->model('service_model');
        $serviceGroup = new stdClass();
        $this->load->library('form_validation');
        if((int)$id > 0){
            $serviceGroup = $this->service_model->getServiceGroupInfo("*", array('id'=>(int)$id));

            if (count($serviceGroup) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/service/group', 'location');
                die();
            }
        }else{
            $serviceGroup->id = 0;
            $serviceGroup->text= '';
            $serviceGroup->published = 1;
            $serviceGroup->content_id = 0;

        }
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;


            #END Get province by $id

            #BEGIN: Set rules
            $this->form_validation->set_rules('text', 'lang:ser_require', 'trim|required');
            //$this->form_validation->set_rules('max_email', 'lang:ser_require', 'trim|required');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {


                $dataEdit = array(
                    'text' => $this->input->post('text'),
                    'content_id' => $this->input->post('content_id')
                );

                if((int) $id > 0){

                    if ($this->service_model->updateServiceGroup($dataEdit, array('id'=> $id))) {
                        //$this->db->cache_off();
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                    }
                }else{
                    $dataEdit['published'] = 1;
                    $dataEdit['type'] = $this->input->post('type');
                    $id = $this->service_model->addServiceGroup($dataEdit);
                    if ($id > 0) {
                        //$this->db->cache_off();
                        $this->session->set_flashdata('sessionSuccessEdit', 1);

                    }
                }
                //$this->session->set_flashdata('sessionSuccessEdit', 1);
                redirect(base_url() . $link . '/' . $id, 'location');
            }

        }
        foreach ($serviceGroup as $key => $val) {

            $data[$key] = $val;
        }

        #Load view
        $data['link'] = base_url() . $link;
        $data['cancel'] = base_url() . $cancel;


        $this->load->view('admin/service/service_group_edit', $data);
    }
}
