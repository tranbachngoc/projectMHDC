<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Advertise extends CI_Controller
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
		$this->lang->load('admin/advertise');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			#Remove image
			$this->load->library('file');
			$listIdAdvertise = implode(',', $this->input->post('checkone'));
			$advertise = $this->advertise_model->fetch("adv_banner, adv_dir", "adv_id IN($listIdAdvertise)", "", "");
			foreach($advertise as $advertiseArray)
			{
				if(trim($advertiseArray->adv_banner) != '' && file_exists('media/banners/'.$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner))
				{
					@unlink('media/banners/'.$advertiseArray->adv_dir.'/'.$advertiseArray->adv_banner);
				}
				if(trim($advertiseArray->adv_dir) != '' && is_dir('media/banners/'.$advertiseArray->adv_dir) && count($this->file->load('media/banners/'.$advertiseArray->adv_dir, 'index.html')) == 0)
				{
					if(file_exists('media/banners/'.$advertiseArray->adv_dir.'/index.html'))
					{
						@unlink('media/banners/'.$advertiseArray->adv_dir.'/index.html');
					}
					@rmdir('media/banners/'.$advertiseArray->adv_dir);
				}
			}
			$this->advertise_model->delete($this->input->post('checkone'), "adv_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}

		#END CHECK PERMISSION
		$this->load->helper('file');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'adv_id';
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
				case 'title':
				    $sortUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/title/keyword/'.$getVar['keyword'];
				    $where .= "adv_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= "adv_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'advertiser':
				    $sortUrl .= '/search/advertiser/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/advertiser/keyword/'.$getVar['keyword'];
				    $where .= "adv_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "adv_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "adv_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "adv_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "adv_status = 0";
				    break;
                case 'header':
				    $sortUrl .= '/filter/header/key/'.$getVar['key'];
				    $pageUrl .= '/filter/header/key/'.$getVar['key'];
				    $where .= "adv_position = 1";
				    break;
                case 'footer':
				    $sortUrl .= '/filter/footer/key/'.$getVar['key'];
				    $pageUrl .= '/filter/footer/key/'.$getVar['key'];
				    $where .= "adv_position = 2";
				    break;
                case 'left':
				    $sortUrl .= '/filter/left/key/'.$getVar['key'];
				    $pageUrl .= '/filter/left/key/'.$getVar['key'];
				    $where .= "adv_position = 3";
				    break;
                case 'right':
				    $sortUrl .= '/filter/right/key/'.$getVar['key'];
				    $pageUrl .= '/filter/right/key/'.$getVar['key'];
				    $where .= "adv_position = 4";
				    break;
                case 'top':
				    $sortUrl .= '/filter/top/key/'.$getVar['key'];
				    $pageUrl .= '/filter/top/key/'.$getVar['key'];
				    $where .= "adv_position = 5";
				    break;
                case 'bottom':
				    $sortUrl .= '/filter/bottom/key/'.$getVar['key'];
				    $pageUrl .= '/filter/bottom/key/'.$getVar['key'];
				    $where .= "adv_position = 6";
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
				    $sort .= "adv_title";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "adv_link";
				    break;
                case 'advertiser':
				    $pageUrl .= '/sort/advertiser';
				    $sort .= "adv_fullname";
				    break;
                case 'position':
				    $pageUrl .= '/sort/position';
				    $sort .= "adv_position";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "adv_order";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "adv_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "adv_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "adv_id";
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
		$data['sortUrl'] = base_url().'administ/advertise'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/advertise'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->advertise_model->update(array('adv_status'=>1), "adv_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->advertise_model->update(array('adv_status'=>0), "adv_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->advertise_model->fetch("adv_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/advertise'.$pageUrl.'/page/';
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
		$data['advertise'] = $this->advertise_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/advertise/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'advertise')))
		{
            $this->advertise_model->update(array('adv_status'=>0), "adv_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-advertise');
            }
            else
            {
                setcookie('_cookieSetStatus', 'advertise');
            }
		}
		#END Update status = deactive
		$this->load->helper('file');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "adv_enddate < $currentDate";
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
				    $where .= " AND adv_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND adv_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'advertiser':
				    $sortUrl .= '/search/advertiser/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/advertiser/keyword/'.$getVar['keyword'];
				    $where .= " AND adv_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND adv_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND adv_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND adv_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND adv_status = 0";
				    break;
                case 'header':
				    $sortUrl .= '/filter/header/key/'.$getVar['key'];
				    $pageUrl .= '/filter/header/key/'.$getVar['key'];
				    $where .= " AND adv_position = 1";
				    break;
                case 'footer':
				    $sortUrl .= '/filter/footer/key/'.$getVar['key'];
				    $pageUrl .= '/filter/footer/key/'.$getVar['key'];
				    $where .= " AND adv_position = 2";
				    break;
                case 'left':
				    $sortUrl .= '/filter/left/key/'.$getVar['key'];
				    $pageUrl .= '/filter/left/key/'.$getVar['key'];
				    $where .= " AND adv_position = 3";
				    break;
                case 'right':
				    $sortUrl .= '/filter/right/key/'.$getVar['key'];
				    $pageUrl .= '/filter/right/key/'.$getVar['key'];
				    $where .= " AND adv_position = 4";
				    break;
                case 'top':
				    $sortUrl .= '/filter/top/key/'.$getVar['key'];
				    $pageUrl .= '/filter/top/key/'.$getVar['key'];
				    $where .= " AND adv_position = 5";
				    break;
                case 'bottom':
				    $sortUrl .= '/filter/bottom/key/'.$getVar['key'];
				    $pageUrl .= '/filter/bottom/key/'.$getVar['key'];
				    $where .= " AND adv_position = 6";
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
				    $sort .= "adv_title";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "adv_link";
				    break;
                case 'advertiser':
				    $pageUrl .= '/sort/advertiser';
				    $sort .= "adv_fullname";
				    break;
                case 'position':
				    $pageUrl .= '/sort/position';
				    $sort .= "adv_position";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "adv_order";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "adv_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "adv_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "adv_id";
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
		$data['sortUrl'] = base_url().'administ/advertise/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->advertise_model->fetch("adv_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/advertise/end'.$pageUrl.'/page/';
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
		$select = "tbtt_advertise.*, tbtt_user.use_username, tbtt_user.use_id, tbtt_user.use_mobile, tbtt_user.email, tbtt_category.cat_name, tbtt_category.cat_id, tbtt_province.pre_name, tbtt_province.pre_id";
		$limit = settingOtherAdmin;
		$data['advertise'] = $this->advertise_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/advertise/end', $data);
	}
	
	function add()
	{
		$this->load->model('category_model');
		$category = $this->category_model->fetch("*","parent_id=0");
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_add'))
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
            $this->form_validation->set_rules('title_adv', 'lang:title_label_add', 'trim|required|callback__exist_title');
            $this->form_validation->set_rules('link_adv', 'lang:link_label_add', 'trim|required');
            $this->form_validation->set_rules('order_adv', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('name_adv', 'lang:name_label_add', 'trim|required');
            $this->form_validation->set_rules('address_adv', 'lang:address_label_add', 'trim|required');
            $this->form_validation->set_rules('phone_adv', 'lang:phone_label_add', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_adv', 'lang:mobile_label_add', 'trim|callback__is_phone');
            $this->form_validation->set_rules('email_adv', 'lang:email_label_add', 'trim|required|valid_email');
            $this->form_validation->set_rules('endday_adv', 'lang:enddate_label_add', 'callback__valid_enddate');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				
                $pathMain = "media/banners/";
				#Create folder
				$dir_adv = date('dmY');
				if(!is_dir($pathMain.$dir_adv))
				{
					@mkdir($pathMain.$dir_adv);
					$this->load->helper('file');
					@write_file($pathMain.$dir_adv.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				#BEGIN: Upload image
				$config['upload_path'] = $pathMain.$dir_adv.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf|html';
				$config['max_size']	= 2048;
				$config['max_width']  = 1024;
				$config['max_height']  = 1024;
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('banner_adv'))
				{
					$uploadData = $this->upload->data();
					$banner_adv = $uploadData['file_name'];
     				$isUploaded = true;
				}
				else
				{
                    $isUploaded = false;
				}
				
                if($this->input->post('active_adv') == '1')
				{
	                $active_adv = 1;
				}
				else
				{
	                $active_adv = 0;
				}
				if(is_array($this->input->post('page_adv')))
				{
                    $page_adv = implode(',', $this->input->post('page_adv'));
				}
				else
				{
                    $page_adv = 'home';
				}
				if($banner_adv=="")
				{
					$banner_adv="none";
				}
				$ifame_ban ="";
				if($this->input->post('ub_format')=="2")
				{
					$ifame_ban = "1";
				}
				$dataAdd = array(
				                    'adv_title'      	=>      trim($this->filter->injection_html($this->input->post('title_adv'))),
				                    'adv_banner'      	=>      $banner_adv,
				                    'adv_dir'			=>      $dir_adv,
				                    'adv_link'         	=>      trim($this->input->post('link_adv')),
				                    'cat_id'         	=>      trim($this->input->post('cat_id')),
	                                'adv_fullname'      =>      trim($this->filter->injection_html($this->input->post('name_adv'))),
	                                'adv_address'      	=>      trim($this->filter->injection_html($this->input->post('address_adv'))),
				                    'adv_email'      	=>      trim($this->filter->injection_html($this->input->post('email_adv'))),
				                    'adv_phone'			=>      trim($this->filter->injection_html($this->input->post('phone_adv'))),
				                    'adv_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_adv'))),
				                    'adv_begindate'     =>      mktime(0, 0, 0, date('m'), date('d'), date('Y')),
				                    'adv_enddate'      	=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_adv'), (int)$this->input->post('endday_adv'), (int)$this->input->post('endyear_adv')),
				                    'adv_status'		=>      $active_adv,
				                    'adv_position'      =>      (int)$this->input->post('position_adv'),
				                    'adv_page'         	=>      trim($this->filter->injection($page_adv)),
									 'adv_iframe'       =>    $ifame_ban,
	                                'adv_order'      	=>      (int)$this->input->post('order_adv')
									);
				if($this->advertise_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				
				redirect(base_url().'administ/advertise/add', 'location');
			}
			else
	        {
				$data['title_adv'] = $this->input->post('title_adv');
				$data['link_adv'] = $this->input->post('link_adv');
				$data['position_adv'] = $this->input->post('position_adv');
				if($this->input->post('page_adv') && is_array($this->input->post('page_adv')))
				{
                    $data['page_adv'] = implode(',', $this->input->post('page_adv'));
				}
				else
				{
                    $data['page_adv'] = 'home';
				}
				$data['order_adv'] = $this->input->post('order_adv');
				$data['name_adv'] = $this->input->post('name_adv');
				$data['address_adv'] = $this->input->post('address_adv');
				$data['phone_adv'] = $this->input->post('phone_adv');
				$data['mobile_adv'] = $this->input->post('mobile_adv');
				$data['email_adv'] = $this->input->post('email_adv');
				$data['endday_adv'] = $this->input->post('endday_adv');
				$data['endmonth_adv'] = $this->input->post('endmonth_adv');
				$data['endyear_adv'] = $this->input->post('endyear_adv');
				$data['active_adv'] = $this->input->post('active_adv');
	        }
        }
        $data['category']=$category;
		#Load view
		$this->load->view('admin/advertise/add', $data);
	}
	
	function edit($id)
	{
		$this->load->model('category_model');
		$category = $this->category_model->fetch("*","parent_id=0");
		//print_r($advertise)	;exit();
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_edit'))
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
            #BEGIN: Get advertise by $id
			$advertise = $this->advertise_model->get("*", "adv_id = ".(int)$id);
			if(count($advertise) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/advertise', 'location');
				die();
			}
			#END Get advertise by $id
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
            $this->form_validation->set_rules('link_adv', 'lang:link_label_edit', 'trim|required');
            $this->form_validation->set_rules('order_adv', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            $this->form_validation->set_rules('name_adv', 'lang:name_label_edit', 'trim|required');
            $this->form_validation->set_rules('address_adv', 'lang:address_label_edit', 'trim|required');
            $this->form_validation->set_rules('phone_adv', 'lang:phone_label_edit', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_adv', 'lang:mobile_label_edit', 'trim|callback__is_phone');
            $this->form_validation->set_rules('email_adv', 'lang:email_label_edit', 'trim|required|valid_email');
            $this->form_validation->set_rules('endday_adv', 'lang:enddate_label_edit', 'callback__valid_enddate');
            #Expand
            if($advertise->adv_title != trim($this->filter->injection_html($this->input->post('title_adv'))))
            {
                $this->form_validation->set_rules('title_adv', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_adv', 'lang:title_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_edit'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
	
			if($this->form_validation->run() != FALSE)
			{
						//echo $_POST['title_adv'];die();
                $pathMain = "media/banners/";
				#Create folder
				$dir_adv = $advertise->adv_dir;
				if(!is_dir($pathMain.$dir_adv))
				{
					@mkdir($pathMain.$dir_adv);
					$this->load->helper('file');
					@write_file($pathMain.$dir_adv.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				#BEGIN: Upload image
				$config['upload_path'] = $pathMain.$dir_adv.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf|html';
				$config['max_size']	= 2048;
				//$config['max_width']  = 1024;
				//$config['max_height']  = 1024;
				$config['encrypt_name'] = true;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('banner_adv'))
				{
                    if(trim($advertise->adv_banner) != '' && file_exists($pathMain.$dir_adv.'/'.$advertise->adv_banner))
                    {
						@unlink($pathMain.$dir_adv.'/'.$advertise->adv_banner);
                    }
					$uploadData = $this->upload->data();
					$banner_adv = $uploadData['file_name'];
     				$isUploaded = true;
				}
				else
				{
					if(trim($advertise->adv_banner) != '' && file_exists($pathMain.$dir_adv.'/'.$advertise->adv_banner))
					{
                        $banner_adv = $advertise->adv_banner;
                        $isUploaded = true;
					}
					else
					{
                        $isUploaded = false;
					}
				}
				
                if($this->input->post('active_adv') == '1')
				{
	                $active_adv = 1;
				}
				else
				{
	                $active_adv = 0;
				}
				if(is_array($this->input->post('page_adv')))
				{
                    $page_adv = implode(',', $this->input->post('page_adv'));
				}
				else
				{
                    $page_adv = 'home';
				}
				//echo $this->input->post('ub_format_0');die();
				$flag_ifreme = "";
				if($this->input->post('ub_format_0')=="2")
				{
					$flag_ifreme ="1";
					
				}
								
				$dataEdit = array(
				                    'adv_title'      	=>      trim($this->filter->injection_html($this->input->post('title_adv'))),
				                    'adv_banner'      	=>      $banner_adv,
				                    'adv_dir'			=>      $dir_adv,
				                    'adv_link'         	=>      trim($this->input->post('link_adv')),
				                    'cat_id'         	=>      trim($this->input->post('cat_id')),
	                                'adv_fullname'      =>      trim($this->filter->injection_html($this->input->post('name_adv'))),
	                                'adv_address'      	=>      trim($this->filter->injection_html($this->input->post('address_adv'))),
				                    'adv_email'      	=>      trim($this->filter->injection_html($this->input->post('email_adv'))),
				                    'adv_phone'			=>      trim($this->filter->injection_html($this->input->post('phone_adv'))),
				                    'adv_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_adv'))),
				                    'adv_enddate'      	=>      mktime(0, 0, 0, (int)$this->input->post('endmonth_adv'), (int)$this->input->post('endday_adv'), (int)$this->input->post('endyear_adv')),
				                    'adv_status'		=>      $active_adv,
				                    'adv_position'      =>      (int)$this->input->post('position_adv'),
									'adv_iframe'      =>   $flag_ifreme  ,
				                    'adv_page'         	=>      trim($this->filter->injection($page_adv)),
	                                'adv_order'      	=>      (int)$this->input->post('order_adv')
									);
				if($this->advertise_model->update($dataEdit, "adv_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/advertise/edit/'.$id, 'location');
			}
			else
	        {
				$data['title_adv'] = $advertise->adv_title;
				$data['link_adv'] = $advertise->adv_link;
				$data['position_adv'] = $advertise->adv_position;
    			$data['page_adv'] = $advertise->adv_page;
				$data['order_adv'] = $advertise->adv_order;
				$data['name_adv'] = $advertise->adv_fullname;
				$data['address_adv'] = $advertise->adv_address;
				$data['phone_adv'] = $advertise->adv_phone;
				$data['mobile_adv'] = $advertise->adv_mobile;
				$data['email_adv'] = $advertise->adv_email;
				$data['endday_adv'] = date('d', $advertise->adv_enddate);
				$data['endmonth_adv'] = date('m', $advertise->adv_enddate);
				$data['endyear_adv'] = date('Y', $advertise->adv_enddate);
				$data['active_adv'] = $advertise->adv_status;
				$data['image_adv'] = $advertise->adv_banner;
				$data['image_dir_adv'] = $advertise->adv_dir;
				$data['adv_iframe'] = $advertise->adv_iframe;
				$data['cat_id'] = $advertise->cat_id;
	        }
        }
        //print_r($data);exit();
        $data['category']=$category;
		#Load view
		$this->load->view('admin/advertise/edit', $data);
	}
	
//	ADVS Config

	function addConfig()
	{
		$this->load->model('advertise_config_model');
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_add'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		if($this->session->flashdata('sessionSuccessAdd')){
			$data['successAdd'] = true;
		} else {
			$data['successAdd'] = false;
			$this->load->library('form_validation');
			#BEGIN: Set rules
			$this->form_validation->set_rules('title_adv', 'tiêu đề', 'trim|required');
			$this->form_validation->set_rules('price_adv', 'giá', 'trim|required');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			#END Set message
			if($this->form_validation->run() != FALSE){
				$dataAdd = array(
					'adv_title'      	=>      trim($this->filter->injection_html($this->input->post('title_adv'))),
					'adv_price'			=>      trim($this->input->post('price_adv')),
					'adv_type'			=>      trim($this->input->post('type_adv')),
					'status'         	=>      trim($this->input->post('status')),
					'adv_pos'       	=>      (int)$this->input->post('title_adv')
				);
				if($this->advertise_config_model->add($dataAdd)){
					$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/advertiseconfig/add', 'location');
			}else{
				$data['title_adv'] = $this->input->post('title_adv');
				$data['price_adv'] = $this->input->post('price_adv');
				$data['type_adv'] = $this->input->post('type_adv');
			}
		}
		$data['listadv'] = $this->advertise_config_model->fetch('*','','','',0,15);
		#Load view
		$this->load->view('admin/advertise/addposition', $data);
	}
	function editConfig($id)
	{
		$this->load->model('advertise_config_model');
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_edit'))
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
			#BEGIN: Get advertise by $id
			$advertise = $this->advertise_config_model->get("*", "adv_pos = ".(int)$id);
			$data['advertise '] = $advertise;
			if(count($advertise) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/advertiseconfig', 'location');
				die();
			}
			#END Get advertise by $id
			$this->load->library('form_validation');
			#BEGIN: Set rules
			$this->form_validation->set_rules('title_adv', 'tiêu đề', 'trim|required');
			$this->form_validation->set_rules('price_adv', 'giá', 'trim|required');
			#Expand
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message

			if($this->form_validation->run() != FALSE)
			{
				$dataEdit = array(
					'adv_title'      	=>      trim($this->filter->injection_html($this->input->post('title_adv'))),
					'adv_price'      	=>      trim($this->input->post('price_adv')),
					'adv_type'      	=>      trim($this->input->post('type_adv')),
					'status'         	=>      trim($this->input->post('status')),
				);
				if($this->advertise_config_model->update($dataEdit, "adv_pos = ".(int)$id))
				{
					$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/advertiseconfig', 'location');
			}
			else
			{
				$data['title_adv'] = $advertise->adv_title;
				$data['price_adv'] = $advertise->adv_price;
				$data['type_adv'] = $advertise->adv_type;
				$data['status'] = $advertise->status;
			}
		}
		#Load view
		$this->load->view('admin/advertise/editposition', $data);
	}
	
	function listPosition(){
		$this->load->model('advertise_config_model');
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';

		#If search
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
					$pageUrl .= '/sort/title';
					$sort .= "adv_title";
					break;
				case 'pirce':
					$pageUrl .= '/sort/link';
					$sort .= "adv_price";
					break;
				case 'status':
					$pageUrl .= '/sort/advertiser';
					$sort .= "status";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "adv_pos";
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
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/advertiseconfig'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/advertiseconfig'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'advertise_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
					$this->advertise_config_model->update(array('status'=>1), "adv_pos = ".(int)$getVar['id']);
					break;
				case 'deactive':
					$this->advertise_config_model->update(array('status'=>0), "adv_pos = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		$limit = 15;
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->advertise_config_model->fetch('*'));
		$config['base_url'] = base_url().'administ/advertiseconfig'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$data['listposition'] =  $this->advertise_config_model->fetch('*','',$sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/advertise/listposition', $data);
	}
	function advStatistics(){
		$this->load->model('advertise_config_model');
		$this->load->model('advertise_click_model');
		$this->load->model('advertise_model');
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter		
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';

		#If search
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
					$pageUrl .= '/sort/title';
					$sort .= "adv_title";
					break;
				case 'pirce':
					$pageUrl .= '/sort/link';
					$sort .= "adv_price";
					break;
				case 'status':
					$pageUrl .= '/sort/advertiser';
					$sort .= "status";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "adv_pos";
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
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/advertise-statistics'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		$limit = 15;
		$slt = 'sum(number_click) as total, tbtt_advertise_click.*, tbtt_advertise.adv_id, tbtt_advertise.adv_title, tbtt_advertise.user_id, tbtt_advertise.adv_position,  tbtt_advertise.adv_page, tbtt_advertise.adv_dir, tbtt_advertise.adv_banner, tbtt_advertise.adv_link, tbtt_advertise_config.adv_title as title, tbtt_user.use_id, tbtt_user.use_username, tbtt_user.use_fullname, tbtt_user.use_fullname, tbtt_user.use_phone,tbtt_user.use_email, tbtt_province.pre_name, tbtt_category.cat_name, tbtt_category.cat_id';
		$join1 = 'INNER';
		$join2 = 'INNER';
		$join3 = 'LEFT';
		$join4 = 'INNER';
		$join5 = 'INNER';
		$tbl1 = 'tbtt_advertise';
		$tbl2 = 'tbtt_advertise_config';
		$tbl3 = 'tbtt_user';
		$tbl4 = 'tbtt_category';
		$tbl5 = 'tbtt_province';
		$on1 = 'tbtt_advertise_click.adv_id = tbtt_advertise.adv_id';
		$on2 = 'tbtt_advertise_config.adv_pos = tbtt_advertise.adv_position';
		$on3 = 'tbtt_advertise_click.user_adv = tbtt_user.use_id';
		$on4 = 'tbtt_advertise.cat_id = tbtt_category.cat_id';
		$on5 = 'tbtt_advertise.adv_province = tbtt_province.pre_id';

		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->advertise_click_model->fetch_join($slt, $join1, $tbl1, $on1, $join2, $tbl2, $on2, $join3, $tbl3, $on3, $join4, $tbl4, $on4, $join5, $tbl5, $on5, 'tbtt_advertise.adv_status = 1'));
		$config['base_url'] = base_url().'administ/advertise-statistics'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$result = $this->advertise_click_model->fetch_join($slt, $join1, $tbl1, $on1, $join2, $tbl2, $on2, $join3, $tbl3, $on3, $join4, $tbl4, $on4, $join5, $tbl5, $on5, 'tbtt_advertise.adv_status = 1', $sort, $by, $start, $limit, false, true);
		$data['listposition'] =  $result;
		#Load view
		$this->load->view('admin/advertise/listclick', $data);
	}

	function _exist_title()
	{
        if(count($this->advertise_model->get("adv_id", "adv_title = '".trim($this->filter->injection_html($this->input->post('title_adv')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _is_phone($str)
	{
		if($this->check->is_phone($str))
		{
			return true;
		}
		return false;
	}
	
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_adv'), (int)$this->input->post('endday_adv'), (int)$this->input->post('endyear_adv'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}
}