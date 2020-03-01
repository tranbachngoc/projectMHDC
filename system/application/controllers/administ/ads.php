<?php

class Ads extends CI_Controller
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
		$this->lang->load('admin/ads');
		#Load model
		$this->load->model('ads_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('ads_favorite_model');
			$this->load->model('ads_comment_model');
			$this->load->model('ads_bad_model');
			$idAds = $this->input->post('checkone');
			$this->ads_favorite_model->delete($idAds, "adf_ads");
			$this->ads_comment_model->delete($idAds, "adc_ads");
			$this->ads_bad_model->delete($idAds, "adb_ads");
			#Remove image
			$this->load->library('file');
			$listIdAds = implode(',', $idAds);
			$ads = $this->ads_model->fetch("ads_image, ads_dir", "ads_id IN($listIdAds)", "", "");
			foreach($ads as $adsArray)
			{
				if($adsArray->ads_image != 'none.gif')
				{
					if(trim($adsArray->ads_image) != '' && file_exists('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image))
					{
						@unlink('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image);
                        if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image))
                        {
                            @unlink('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image);
                        }
					}
					if(trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/'.$adsArray->ads_dir) && count($this->file->load('media/images/ads/'.$adsArray->ads_dir, 'index.html')) == 0)
					{
						if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/index.html'))
						{
							@unlink('media/images/ads/'.$adsArray->ads_dir.'/index.html');
						}
						@rmdir('media/images/ads/'.$adsArray->ads_dir);
					}
				}
			}
			$this->ads_model->delete($idAds, "ads_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_view'))
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
				    $where .= "ads_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "ads_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "ads_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "ads_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "ads_status = 0";
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
				    $sort .= "ads_title";
				    break;
                case 'province':
				    $pageUrl .= '/sort/province';
				    $sort .= "pre_name";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "ads_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "ads_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "ads_id";
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
		$data['sortUrl'] = base_url().'administ/ads'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/ads'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->ads_model->update(array('ads_status'=>1), "ads_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->ads_model->update(array('ads_status'=>0), "ads_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		
		if($getVar['vip'] != FALSE && trim($getVar['vip']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['vip']))
			{
				case 'active':
				    $this->ads_model->update(array('ads_vip'=>1), "ads_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->ads_model->update(array('ads_vip'=>0), "ads_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/ads'.$pageUrl.'/page/';
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
		$select = "ads_id, ads_title, ads_category, ads_view, ads_status, ads_begindate, ads_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email,ads_vip";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='ads' && $this->uri->segment(3)==''){
			$this->db->order_by("ads_id", "DESC"); 
		}
		$data['ads'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/ads/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'ads')))
		{
            $this->ads_model->update(array('ads_status'=>0), "ads_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-ads');
            }
            else
            {
                setcookie('_cookieSetStatus', 'ads');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "ads_enddate < $currentDate";
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
				    $where .= " AND ads_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND ads_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND ads_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND ads_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND ads_status = 0";
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
				    $sort .= "ads_title";
				    break;
                case 'province':
				    $pageUrl .= '/sort/province';
				    $sort .= "pre_name";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "ads_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "ads_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "ads_id";
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
		$data['sortUrl'] = base_url().'administ/ads/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/ads/end'.$pageUrl.'/page/';
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
		$select = "ads_id, ads_title, ads_category, ads_view, ads_status, ads_begindate, ads_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='ads' && $this->uri->segment(3)=='end' && $this->uri->segment(4)==''){
			$this->db->order_by("ads_enddate", "DESC"); 
		}
		$data['ads'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/ads/end', $data);
	}
	
	function bad()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('ads_bad_model');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'detail');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
            #BEGIN: Delete ads bad
			if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
			{
				$this->ads_bad_model->delete((int)$this->input->post('idBad'), "adb_id", false);
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete ads bad
            #If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
			}
			else
			{
				$start = 0;
			}
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->ads_bad_model->fetch("adb_id", "adb_ads = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/ads/bad/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['ads'] = $this->ads_bad_model->fetch("*", "adb_ads = ".(int)$getVar['detail'], "adb_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/ads/bad_detail', $data);
		}
		else
		{
            #BEGIN: Fetch ads bad
			$adsBad = $this->ads_bad_model->fetch("adb_ads", "", "", "", "adb_ads");
			$idAdsBad = array();
			foreach($adsBad as $adsBadArray)
			{
				$idAdsBad[] = $adsBadArray->adb_ads;
			}
			#END Fetch ads bad
			if(count($idAdsBad) > 0)
			{
                $data['haveAdsBad'] = true;
                $idAdsBad = implode(',', $idAdsBad);
				#BEGIN: Search & Filter
				$where = "ads_id IN($idAdsBad)";
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
						    $where .= " AND ads_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
                        case 'username':
        				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
        				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
        				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
						    $where .= " AND ads_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND ads_enddate = ".(float)$getVar['key'];
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND ads_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND ads_status = 0";
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
						    $sort .= "ads_title";
						    break;
		                case 'province':
						    $pageUrl .= '/sort/province';
						    $sort .= "pre_name";
						    break;
		                case 'user':
						    $pageUrl .= '/sort/user';
						    $sort .= "use_username";
						    break;
		                case 'category':
						    $pageUrl .= '/sort/category';
						    $sort .= "cat_name";
						    break;
		                case 'begindate':
						    $pageUrl .= '/sort/begindate';
						    $sort .= "ads_begindate";
						    break;
		                case 'enddate':
						    $pageUrl .= '/sort/enddate';
						    $sort .= "ads_enddate";
						    break;
						default:
						    $pageUrl .= '/sort/id';
						    $sort .= "ads_id";
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
				$data['sortUrl'] = base_url().'administ/ads/bad'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/ads/bad'.$statusUrl;
				if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['status']))
					{
						case 'active':
						    $this->ads_model->update(array('ads_status'=>1), "ads_id = ".(int)$getVar['id']);
							break;
						case 'deactive':
						    $this->ads_model->update(array('ads_status'=>0), "ads_id = ".(int)$getVar['id']);
							break;
					}
					redirect($data['statusUrl'], 'location');
				}
				#END Status
				#BEGIN: Pagination
				$this->load->library('pagination');
				#Count total record
				$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_ads.ads_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", $where, "", ""));
		        $config['base_url'] = base_url().'administ/ads/bad'.$pageUrl.'/page/';
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
				$select = "ads_id, ads_title, ads_category, ads_view, ads_status, ads_begindate, ads_enddate,cat_id, cat_name, use_id, use_username, use_email,adb_title,adb_detail,adb_date,adb_user_id,ads_province";
				$limit = settingOtherAdmin;
				if($this->uri->segment(2)=='ads' && $this->uri->segment(3)=='bad' && $this->uri->segment(4)==''){
					$this->db->order_by("adb_date", "DESC"); 
				}
				$data['ads'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "LEFT", "tbtt_ads_category", "tbtt_ads.ads_category = tbtt_ads_category.cat_id", "LEFT", "tbtt_ads_bad", "tbtt_ads.ads_id = tbtt_ads_bad.adb_ads", $where, $sort, $by, $start, $limit,true);
			}
			else
			{
                $data['haveAdsBad'] = false;
			}
			#Load view
			$this->load->view('admin/ads/bad', $data);
		}
	}
    
    function ajax()
    {
        if($this->input->post('id') && $this->check->is_id($this->input->post('id')) && $this->input->post('enddate'))
        {
            if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'ads_edit'))
            {
                $id = (int)$this->input->post('id');
                $endDate = explode('-', $this->input->post('enddate'));
                if(isset($endDate[0]) && isset($endDate[1]) && isset($endDate[2]))
                {
                    $endDate = mktime(0, 0, 0, $endDate[1], $endDate[0], $endDate[2]);
                }
                else
                {
                    $endDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                }
                $ads = $this->ads_model->get("ads_id", "ads_id = $id");
                if(count($ads) == 1)
                {
                    $this->ads_model->update(array('ads_enddate'=>(int)$endDate), "ads_id = $id");
                }
            }
            else
            {
                echo $this->lang->line('unallowed_use_set_enddate_permission');
            }
        }
        else
        {
            show_404();
        }
    }
}