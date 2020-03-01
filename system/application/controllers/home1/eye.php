<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Eye extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#BEGIN Eye
		if($this->session->userdata('sessionUser')>0){
			$this->load->model('eye_model');			
			$data['listeyeproduct']=$this->eye_model->geteyetype('product',$this->session->userdata('sessionUser'));		
			$data['listeyeraovat']=$this->eye_model->geteyetype('raovat',$this->session->userdata('sessionUser'));
			$data['listeyehoidap']=$this->eye_model->geteyetype('hoidap',$this->session->userdata('sessionUser'));
						
		}else{
			array_values($this->session->userdata['arrayEyeSanpham']);
			array_values($this->session->userdata['arrayEyeRaovat']);
			array_values($this->session->userdata['arrayEyeHoidap']);
			$this->load->model('eye_model');
			$data['listeyeproduct']=$this->eye_model->geteyetypenologin('product');			
			$data['listeyeraovat']=$this->eye_model->geteyetypenologin('raovat');
			$data['listeyehoidap']=$this->eye_model->geteyetypenologin('hoidap');
		}
		#END Eye
		#Load language
		$this->lang->load('admin/common');
		$this->lang->load('admin/notify');
		#Load model
		$this->load->model('notify_model');
	}
	
	function delete_eye(){
		$id = $_POST['id'];
		if($this->db->delete('tbtt_eye', array('idview' => $id))){
			echo "1";
		}else{
			echo "0";
		}
		exit();			
	}
	
	function delete_eye_no_login(){
		//print_r($this->session->userdata['arrayEyeSanpham']);
		$id = $_POST['id'];
		$type = $_POST['type'];
		if($type == 'product'){
			$check = 0;
			for($i=0; $i<count($this->session->userdata['arrayEyeSanpham']); $i++){
				if($this->session->userdata['arrayEyeSanpham'][$i]== $id){
					$check = 1;
					$eyeSanpham = $this->session->userdata('arrayEyeSanpham');
					unset($eyeSanpham[$i]);
					$eyeSanphamR = array_merge($eyeSanpham);
					$this->session->set_userdata('arrayEyeSanpham',$eyeSanphamR);
				}
			}
			if($check==1){
				echo "1" ;
			}
			else {
				echo "0";
			}

		}
		if($type=='raovat'){
			$check=0;
			
			for($i=0; $i<count($this->session->userdata['arrayEyeRaovat']); $i++){
				if($this->session->userdata['arrayEyeRaovat'][$i]==$_POST['id']){
					$check=1;
					$eyeRaovat = $this->session->userdata('arrayEyeRaovat');
					unset($eyeRaovat[$i]);
					$this->session->set_userdata('arrayEyeRaovat',$eyeRaovat);					
					
				}
			}
			if($check==1) echo "1" ;
			else echo "0";
		}
		if($type=='hoidap'){
			$check=0;
			
			for($i=0; $i<count($this->session->userdata['arrayEyeHoidap']); $i++){
				if($this->session->userdata['arrayEyeHoidap'][$i]==$_POST['id']){
					$check=1;
					$eyeHoidap = $this->session->userdata('arrayEyeHoidap');
					unset($eyeHoidap[$i]);
					$this->session->set_userdata('arrayEyeHoidap',$eyeHoidap);
				}
			}
			if($check==1) echo "1" ;
			else echo "0";

		}
			
		exit();
	}
	
	function delete_all(){
		//$type = $_POST['type'];
		if($this->db->delete('tbtt_eye', array('typeview' => 1, 'userid' =>(int)$this->session->userdata('sessionUser')))){
			echo "1";
		}else{
			echo "0";
		}
		exit();			
	}
	
	function delete_all_no_login(){
						
		$type = $_POST['type'];
				
		if($type==1){
			$this->session->unset_userdata('arrayEyeSanpham');
			echo "1";
		}
		if($type==2){
			$this->session->unset_userdata('arrayEyeRaovat');
			echo "1";
		}
		if($type==3){
			$this->session->unset_userdata('arrayEyeHoidap');
			echo "1";
		}
		
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'notify_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->notify_model->delete($this->input->post('checkone'), "not_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'notify_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
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
				case 'title':
				    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $where .= "not_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
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
				    $where .= "not_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "not_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "not_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "not_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort .= "not_title";
				    break;
				case 'degree':
				    $pageUrl .= '/sort/degree';
				    $sort .= "not_degree";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "not_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "not_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "not_id";
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
		$data['sortUrl'] = base_url().'administ/notify'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/notify'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'notify_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->notify_model->update(array('not_status'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->notify_model->update(array('not_status'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->notify_model->fetch("not_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/notify'.$pageUrl.'/page/';
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
		$select = "*";
		$limit = settingOtherAdmin;
		$data['listEye'] = $this->eye_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/eye/eye', $data);
		
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'notify_add'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        if($this->session->flashdata('sessionSuccessAdd'))
		{
            $data['successAdd'] = true;
		}
		else
		{
            $data['successAdd'] = false;
            #BEGIN: Set date
			if((int)date('m') < 12)
			{
				$data['nextMonth'] = (int)date('m') + 1;
				$data['nextYear'] = (int)date('Y');
			}
			else
			{
	            $data['nextMonth'] = 1;
				$data['nextYear'] = (int)date('Y') + 1;
			}
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('title_notify', 'lang:title_label_add', 'trim|required|callback__exist_title');
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_add', 'trim|required');
            $this->form_validation->set_rules('endday_notify', 'lang:enddate_label_add', 'callback__valid_enddate');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				if(is_array($this->input->post('role_notify')))
				{
                    $role_notify = implode(',', $this->input->post('role_notify'));
                    if($role_notify == '0' || (trim($role_notify) != '' && stristr($role_notify, '0')))
                    {
                        $role_notify = '0,1,2,3';
                    }
				}
				else
				{
                    $role_notify = '0,1,2,3';
				}
                if($this->input->post('active_notify') == '1')
				{
	                $active_notify = 1;
				}
				else
				{
	                $active_notify = 0;
				}
				$dataAdd = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_notify'))),
				                    'not_group'      	=>      $this->filter->injection($role_notify),
				                    'not_degree'		=>      (int)$this->input->post('degree_notify'),
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_begindate'     =>      mktime(0, 0, 0, date('m'), date('d'), date('Y')),
				                    'not_enddate'      	=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_notify'), (int)$this->input->post('endday_notify'), (int)$this->input->post('endyear_notify')),
	                                'not_status'      	=>      $active_notify
									);
				if($this->notify_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/notify/add', 'location');
			}
			else
	        {
				$data['title_notify'] = $this->input->post('title_notify');
				if(is_array($this->input->post('role_notify')))
				{
                    $data['role_notify'] = implode(',', $this->input->post('role_notify'));
				}
				else
				{
                    $data['role_notify'] = '0,1,2,3';
				}
				$data['degree_notify'] = $this->input->post('degree_notify');
				$data['txtContent'] = $this->input->post('txtContent');
				$data['endday_notify'] = $this->input->post('endday_notify');
				$data['endmonth_notify'] = $this->input->post('endmonth_notify');
				$data['endyear_notify'] = $this->input->post('endyear_notify');
				$data['active_notify'] = $this->input->post('active_notify');
	        }
        }
		#Load view
		$this->load->view('admin/notify/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'notify_edit'))
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
            #BEGIN: Get notify by $id
            $notify = $this->notify_model->get("*", "not_id = ".(int)$id);
            if(count($notify) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/notify', 'location');
				die();
			}
			#END Get notify by $id
            #BEGIN: Set date
			if((int)date('m') < 12)
			{
				$data['nextMonth'] = (int)date('m') + 1;
				$data['nextYear'] = (int)date('Y');
			}
			else
			{
	            $data['nextMonth'] = 1;
				$data['nextYear'] = (int)date('Y') + 1;
			}
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_edit', 'trim|required');
            $this->form_validation->set_rules('endday_notify', 'lang:enddate_label_edit', 'callback__valid_enddate');
            if($notify->not_title != trim($this->filter->injection_html($this->input->post('title_notify'))))
            {
                $this->form_validation->set_rules('title_notify', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_notify', 'lang:title_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_edit'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				if(is_array($this->input->post('role_notify')))
				{
                    $role_notify = implode(',', $this->input->post('role_notify'));
                    if($role_notify == '0' || (trim($role_notify) != '' && stristr($role_notify, '0')))
                    {
                        $role_notify = '0,1,2,3';
                    }
				}
				else
				{
                    $role_notify = '0,1,2,3';
				}
                if($this->input->post('active_notify') == '1')
				{
	                $active_notify = 1;
				}
				else
				{
	                $active_notify = 0;
				}
				$dataEdit = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_notify'))),
				                    'not_group'      	=>      $this->filter->injection($role_notify),
				                    'not_degree'		=>      (int)$this->input->post('degree_notify'),
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_enddate'      	=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_notify'), (int)$this->input->post('endday_notify'), (int)$this->input->post('endyear_notify')),
	                                'not_status'      	=>      $active_notify
									);
				if($this->notify_model->update($dataEdit, "not_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/notify/edit/'.$id, 'location');
			}
			else
	        {
				$data['title_notify'] = $notify->not_title;
    			$data['role_notify'] = $notify->not_group;
				$data['degree_notify'] = $notify->not_degree;
				$data['txtContent'] = $notify->not_detail;
				$data['endday_notify'] = date('d', $notify->not_enddate);
				$data['endmonth_notify'] = date('m', $notify->not_enddate);
				$data['endyear_notify'] = date('Y', $notify->not_enddate);
				$data['active_notify'] = $notify->not_status;
	        }
        }
		#Load view
		$this->load->view('admin/notify/edit', $data);
	}
	
	function _exist_title()
	{
		if(count($this->notify_model->get("not_id", "not_title = '".trim($this->filter->injection_html($this->input->post('title_notify')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_notify'), (int)$this->input->post('endday_notify'), (int)$this->input->post('endyear_notify'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}
}