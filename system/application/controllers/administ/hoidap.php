<?php

class Hoidap extends CI_Controller
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
		
		$this->lang->load('admin/common');
		$this->lang->load('admin/hds');
		#Load model
		$this->load->model('hds_model');
		$this->load->model('hd_category_model');
		$this->load->model('answers_model');
	}
	
	function bad()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
		{
			$this->hds_bad_model->delete((int)$this->input->post('idBad'), "hds_id", false);
			
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END CHECK PERMISSION
		$this->load->model('hds_bad_model');	
		if($this->uri->segment(3)=="delete")
		{
			$this->hds_bad_model->delete((int)$this->uri->segment(4), "adb_id", false);
			$this->hds_model->delete((int)$this->uri->segment(5), "hds_id", false);
			redirect(base_url()."administ/hoidapvipham", 'location');
		}
		
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'ed', 'detail');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
            #BEGIN: Delete employ bad
			
			#END Delete employ bad
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
			$totalRecord = count($this->hds_bad_model->fetch("emb_id", "emb_employ = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/hoidapvipham/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['employ'] = $this->hds_bad_model->fetch("*", "emb_employ = ".(int)$getVar['detail'], "emb_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/employ/bad_detail', $data);
		}
		else
		{
            #BEGIN: Fetch employ bad
			$employBad = $this->hds_bad_model->fetch("adb_id ");
			
			$idEmployBad = array();
			foreach($employBad as $employBadArray)
			{
				$idEmployBad[] = $employBadArray->adb_id;
			}
			#END Fetch employ bad
			if(count($idEmployBad) > 0)
			{
                $data['haveEmployBad'] = true;
                $idEmployBad = implode(',', $idEmployBad);
				#BEGIN: Search & Filter
				$where ="";
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
						    $where .= " AND hds_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
						    $where .= " AND emp_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND emp_enddate = ".(float)$getVar['key'];
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND emp_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND emp_status = 0";
						    break;
		                case 'reliable':
						    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $where .= " AND emp_reliable = 1";
						    break;
		                case 'notreliable':
						    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $where .= " AND emp_reliable = 0";
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
						    $sort .= "hds_title";
						    break;
		                case 'field':
						    $pageUrl .= '/sort/field';
						    $sort .= "hds_category";
						    break;              
		           
		                case 'begindate':
						    $pageUrl .= '/sort/begindate';
						    $sort .= "up_date";
						    break;		        
						default:
						    $pageUrl .= '/sort/id';
						    $sort .= "hds_id";
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
				$data['sortUrl'] = base_url().'administ/hoidapvipham'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/hoidapvipham'.$statusUrl;
				if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['status']))
					{
						case 'active':
						    $this->employ_model->update(array('emp_status'=>1), "emp_id = ".(int)$getVar['id']);
							break;
						case 'deactive':
						    $this->employ_model->update(array('emp_status'=>0), "emp_id = ".(int)$getVar['id']);
							break;
					}
					redirect($data['statusUrl'], 'location');
				}
			
				#END Status
				#BEGIN: Reliable
				$reliableUrl = $pageUrl.$pageSort;
				$data['reliableUrl'] = base_url().'administ/hoidapvipham'.$reliableUrl;
				
				#END Reliable
				#BEGIN: Pagination
				$this->load->library('pagination');					
				#Count total record
				

				$totalRecord = count($this->hds_model->fetch_join("hds_id", "LEFT","tbtt_hds_bad", "tbtt_hds.hds_id = tbtt_hds_bad.adb_ads","LEFT", "tbtt_hd_category", "tbtt_hds.hds_category = tbtt_hd_category.cat_id", "", "", "","tbtt_hds.hds_id = tbtt_hds_bad.adb_ads".$where, "", "", "", "",true));
					
		        $config['base_url'] = base_url().'administ/hoidapvipham'.$pageUrl.'/page/';
				$config['total_rows'] = $totalRecord;
				$config['per_page'] = settingOtherAdmin;
				$config['num_links'] = 5;
				$data['haveAdsBad']=true;								
				$config['cur_page'] = $start;
				$this->pagination->initialize($config);
				$data['linkPage'] = $this->pagination->create_links();
				#END Pagination
				#sTT - So thu tu
				$data['sTT'] = $start + 1;				
				$select = "hds_id,hds_title,hds_category,up_date,adb_user_id,adb_id,cat_name,hds_user,adb_date";
				$limit = settingOtherAdmin;
				
				$data['ads'] = $this->hds_model->fetch_join($select, "LEFT","tbtt_hds_bad", "tbtt_hds.hds_id = tbtt_hds_bad.adb_ads","LEFT", "tbtt_hd_category", "tbtt_hds.hds_category = tbtt_hd_category.cat_id", "", "", "","tbtt_hds.hds_id = tbtt_hds_bad.adb_ads".$where, $sort, $by, $start, $limit,true);
			}
			else
			{
                $data['haveEmployBad'] = false;
			}
			
			#Load view
			$this->load->view('admin/hds/bad', $data);
		}
	}
	
	function traloibad()
	{
         #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
		{
			$this->hds_bad_model->delete((int)$this->input->post('idBad'), "hds_id", false);
			
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END CHECK PERMISSION
		$this->load->model('hds_re_bad_model');	
		$this->load->model('answers_model');	
		if($this->uri->segment(3)=="delete")
		{
			$this->hds_re_bad_model->delete((int)$this->uri->segment(4), "adb_id", false);
			$this->answers_model->delete((int)$this->uri->segment(5), "answers_id", false);
			redirect(base_url()."administ/traloivipham", 'location');
		}
		
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'ed', 'detail');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
		}
		else
		{
            #BEGIN: Fetch employ bad
			$employBad = $this->hds_re_bad_model->fetch("adb_id");
			
			$idEmployBad = array();
			foreach($employBad as $employBadArray)
			{
				$idEmployBad[] = $employBadArray->adb_id;
			}
			#END Fetch employ bad
			if(count($idEmployBad) > 0)
			{
                $data['haveEmployBad'] = true;
                $idEmployBad = implode(',', $idEmployBad);
				#BEGIN: Search & Filter
				$where ="";
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
						    $where .= " AND hds_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
						    $where .= " AND emp_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND emp_enddate = ".(float)$getVar['key'];
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND emp_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND emp_status = 0";
						    break;
		                case 'reliable':
						    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $where .= " AND emp_reliable = 1";
						    break;
		                case 'notreliable':
						    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $where .= " AND emp_reliable = 0";
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
						    $sort .= "hds_title";
						    break;
		                case 'field':
						    $pageUrl .= '/sort/field';
						    $sort .= "hds_category";
						    break;              
		           
		                case 'begindate':
						    $pageUrl .= '/sort/begindate';
						    $sort .= "adb_date";
						    break;		        
						default:
						    $pageUrl .= '/sort/id';
						    $sort .= "hds_id";
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
				$data['sortUrl'] = base_url().'administ/traloivipham'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/traloivipham'.$statusUrl;
				if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['status']))
					{
						case 'active':
						    $this->employ_model->update(array('emp_status'=>1), "emp_id = ".(int)$getVar['id']);
							break;
						case 'deactive':
						    $this->employ_model->update(array('emp_status'=>0), "emp_id = ".(int)$getVar['id']);
							break;
					}
					redirect($data['statusUrl'], 'location');
				}
			
				#END Status
				#BEGIN: Reliable
				$reliableUrl = $pageUrl.$pageSort;
				$data['reliableUrl'] = base_url().'administ/traloivipham'.$reliableUrl;
				
				#END Reliable
				#BEGIN: Pagination
				$this->load->library('pagination');					
				#Count total record
				

				$totalRecord = count($this->hds_model->fetch_join("hds_id", "LEFT","tbtt_hds_bad", "tbtt_hds.hds_id = tbtt_hds_bad.adb_ads","LEFT", "tbtt_hd_category", "tbtt_hds.hds_category = tbtt_hd_category.cat_id", "", "", "","tbtt_hds.hds_id = tbtt_hds_bad.adb_ads".$where, "", "", "", "",true));
					
		        $config['base_url'] = base_url().'administ/traloivipham'.$pageUrl.'/page/';
				$config['total_rows'] = $totalRecord;
				$config['per_page'] = settingOtherAdmin;
				$config['num_links'] = 5;
				$data['haveAdsBad']=true;								
				$config['cur_page'] = $start;
				$this->pagination->initialize($config);
				$data['linkPage'] = $this->pagination->create_links();
				#END Pagination
				#sTT - So thu tu
				$data['sTT'] = $start + 1;				
				$select = "*";
				$limit = settingOtherAdmin;
				
				$data['ads'] = $this->answers_model->fetch_join($select, "LEFT","tbtt_hds_re_bad", "tbtt_answers.answers_id = tbtt_hds_re_bad.adb_ads","LEFT", "tbtt_hds", "tbtt_hds.hds_id = tbtt_answers.hds_id", "", "", "","tbtt_answers.answers_id = tbtt_hds_re_bad.adb_ads".$where, $sort, $by, $start, $limit);
			}
			else
			{
                $data['haveEmployBad'] = false;
			}
			
			#Load view
			$this->load->view('admin/hds/traloibad', $data);
		}
		
	}
	
	
	
	
	
	// hoi dap theo doi 
	function index()
	{
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			
			if($this->input->post('type_action') =='hoidap'){
				$idHds = $this->input->post('checkone');
				$this->answers_model->delete($idHds, "hds_id");
				$this->hds_model->delete($idHds, "hds_id");
			}
			if($this->input->post('type_action') =='category'){
				$idCategory = $this->input->post('checkone');
				$listIdCategory = implode(',', $idCategory);
				#Get id hds
				$hds = $this->hds_model->fetch("*", "hds_category IN($listIdCategory)", "", "");
				$idHds = array();
				foreach($hds as $hdsArray)
				{
					$idHds[] = $hdsArray->hds_id;
				}
				#Get id answers
				$ans = $this->answers_model->fetch("*", "hds_id IN($listIdCategory)", "", "");
				$idAns = array();
				foreach($ans as $ansArray)
				{
					$idAns[] = $ansArray->answers_id;
				}
				# Delete hds
				$this->hds_model->delete($idHds, "hds_id");
				# Delete answers
				$this->answers_model->delete($idAns, "answers_id");
				# Delete Category
				$this->hd_category_model->delete($listIdCategory, "cat_id");
			}
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		
		
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
				    $where .= "hds_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
                case 'up_date':
				    $sortUrl .= '/filter/update/key/'.$getVar['key'];
				    $pageUrl .= '/filter/update/key/'.$getVar['key'];
				    $where .= "up_date = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "hds_status = 0";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "hds_status = 1";
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
				    $sort .= "hds_title";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "hds_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'up_date':
				    $pageUrl .= '/sort/up_date';
				    $sort .= "up_date";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "hds_id";
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
		$data['sortUrl'] = base_url().'administ/hoidap'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/hoidap'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->hds_model->update(array('hds_status'=>0), "hds_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->hds_model->update(array('hds_status'=>1), "hds_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}	
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch_join("hds_id", "LEFT", "tbtt_user", "tbtt_hds.hds_user = tbtt_user.use_id", "LEFT", "tbtt_hd_category", "tbtt_hds.hds_category = tbtt_hd_category.cat_id", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'administ/hoidap'.$pageUrl.'/page/';
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
		$select = "*,cat_name,use_fullname";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(2)=='hoidap' && $this->uri->segment(3)==''){
			$this->db->order_by("hds_id", "DESC"); 
		}
		
		$data['hds'] = $this->hds_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_hds.hds_user = tbtt_user.use_id", "LEFT", "tbtt_hd_category", "tbtt_hds.hds_category = tbtt_hd_category.cat_id", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/hds/defaults', $data);
	}
	
	
	function theodoi()
	{
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			
			if($this->input->post('type_action') =='hoidap'){
				$idHds = $this->input->post('checkone');
				$this->answers_model->delete($idHds, "hds_id");
				$this->hds_model->delete($idHds, "hds_id");
			}
			if($this->input->post('type_action') =='category'){
				$idCategory = $this->input->post('checkone');
				$listIdCategory = implode(',', $idCategory);
				#Get id hds
				$hds = $this->hds_model->fetch("*", "hds_category IN($listIdCategory)", "", "");
				$idHds = array();
				foreach($hds as $hdsArray)
				{
					$idHds[] = $hdsArray->hds_id;
				}
				#Get id answers
				$ans = $this->answers_model->fetch("*", "hds_id IN($listIdCategory)", "", "");
				$idAns = array();
				foreach($ans as $ansArray)
				{
					$idAns[] = $ansArray->answers_id;
				}
				# Delete hds
				$this->hds_model->delete($idHds, "hds_id");
				# Delete answers
				$this->answers_model->delete($idAns, "answers_id");
				# Delete Category
				$this->hd_category_model->delete($listIdCategory, "cat_id");
			}
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		
		
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "hds_theo_doi like '%,%,%'";
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
				    $where .= " AND hds_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'up_date':
				    $sortUrl .= '/filter/update/key/'.$getVar['key'];
				    $pageUrl .= '/filter/update/key/'.$getVar['key'];
				    $where .= "up_date = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "hds_status = 0";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "hds_status = 1";
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
				    $sort .= "hds_title";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "hds_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'up_date':
				    $pageUrl .= '/sort/up_date';
				    $sort .= "up_date";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "hds_id";
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
		$data['sortUrl'] = base_url().'administ/hoidap/theodoi'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/hoidap/theodoi'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->hds_model->update(array('hds_status'=>0), "hds_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->hds_model->update(array('hds_status'=>1), "hds_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}	
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		$this->load->model('hds_model');
		#Count total record
		$totalRecord = count($this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype,up_date,hds_theo_doi","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit));
        $config['base_url'] = base_url().'administ/hoidap/theodoi'.$pageUrl.'/page/';
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
		$select = "*,cat_name,use_fullname";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='hoidap' && $this->uri->segment(3)=='theodoi' && $this->uri->segment(4)==''){
			$this->db->order_by("hds_id", "DESC"); 
		}
		$data['hds'] =$this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype,up_date","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/hds/hoidaptheodoi', $data);
	}
	
	//ednd theo doi doi dap
	
	
	function traloi()
	{
		
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			
            
			
				$idHds = $this->input->post('checkone');
				$this->answers_model->delete($idHds, "answers_id");				
				
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		
		
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "";
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
				    $where .= "hds_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'up_date':
				    $sortUrl .= '/filter/update/key/'.$getVar['key'];
				    $pageUrl .= '/filter/update/key/'.$getVar['key'];
				    $where .= "up_date = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "hds_status = 0";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "hds_status = 1";
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
				    $sort .= "hds_title";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "hds_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'up_date':
				    $pageUrl .= '/sort/up_date';
				    $sort .= "up_date";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "hds_id";
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
		$data['sortUrl'] = base_url().'administ/hoidap/traloi'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/hoidap/traloi'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'hds_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->answers_model->update(array('hds_status'=>0), "hds_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->answers_model->update(array('hds_status'=>1), "hds_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}	
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		$this->load->model('hds_model');
		#Count total record
		$totalRecord = count($this->hds_model->fetch_join("*,tbtt_user.use_username","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","RIGHT", "tbtt_answers", "tbtt_answers.hds_id = tbtt_hds.hds_id", $where, $sort, $by, $start, $limit));
        $config['base_url'] = base_url().'administ/hoidap/theodoi'.$pageUrl.'/page/';
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
		$select = "*,cat_name,use_fullname";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='hoidap' && $this->uri->segment(3)=='traloi' && $this->uri->segment(4)==''){
			$this->db->order_by("answers_id", "DESC"); 
		}		
		$data['hds'] =$this->hds_model->fetch_join("*,tbtt_user.use_username","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","RIGHT", "tbtt_answers", "tbtt_answers.hds_id = tbtt_hds.hds_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/hds/traloi', $data);
	}
	
	
	
	function category(){
		#BEGIN: CHECK PERMISSION
		
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
	
	
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
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
				
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= "cat_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					
				    break;
			}
			
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
				
			switch(strtolower($getVar['filter']))
			{
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "cat_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "cat_status = 0";
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
				    $sort .= "cat_name";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "cat_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "cat_id";
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
		
			
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/hoidap/category'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/hoidap/category'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('menu_model');
			
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->hd_category_model->update(array('cat_status'=>1), "cat_id = ".(int)$getVar['id']);
				    $this->menu_model->update(array('men_status'=>1), "men_category = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->hd_category_model->update(array('cat_status'=>0), "cat_id = ".(int)$getVar['id']);
				    $this->menu_model->update(array('men_status'=>0), "men_category = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
	
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hd_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/hoidap/category'.$pageUrl.'/page/';
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

			$retArray = array();
		$this->loadCategory2(0,0,$retArray, $where, "cat_order", "ASC");
		$data['category'] = $retArray;
		
		#Load view
		$this->load->view('admin/hds/category', $data);
	}
	
	function loadCategory2($parent, $level,&$retArray, $where, $sort, $by)
	{
		$select = "*";
		$whereTmp = "";
		if(strlen($where)>0){
			$whereTmp .= $where;
		}else{
			$whereTmp .= $where."parent_id='$parent'";
		}
		$this->load->model('hd_category_model');
		$category  = $this->hd_category_model->fetch($select, $whereTmp);
		
	   foreach ($category as $row)
	   {
		     	
		   $row->cat_name = $row->cat_name;
		   $retArray[] = $row;
		
	       $this->loadCategory2($row->cat_id, $level+1,$retArray);
		   //edit by nganly
	
	   }
	 
	}
	
	function categoryadd()
	{
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add'))
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
            #BEGIN: Load image category
            $this->load->library('file');
			$imageCategory = $this->hd_category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = $this->file->load('templates/home/images/category', $usedImage);
			#Begin: Category hoi dap
			$cat_level_0 = $this->hd_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->hd_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			$maxorder = $this->hd_category_model->get("max(cat_order) as maxorder");
			$data['next_order'] = (int)$maxorder->maxorder+1;
			
			$maxindex = $this->hd_category_model->get("max(cat_index) as maxindex");
			$data['next_index'] = (int)$maxindex->maxindex+1;
			
            #END Load image category
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required|callback__exist_category');
           // $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', '');
            $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_category') == '1')
				{
	                $active_category = 1;
				}
				else
				{
	                $active_category = 0;
				}
				$dataAdd = array(
				                    'cat_name'      	=>      trim($this->filter->injection_html($this->input->post('name_category'))),
				                    'cat_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
				                    'cat_image'			=>      $this->filter->injection($this->input->post('image_category')),
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
									 'parent_id'         =>      (int)$this->input->post('parent_id'),
									 'cat_index'         =>      (int)$this->input->post('cat_index'),
									 'cat_level'         =>      (int)$this->input->post('cat_level'),
	                                'cat_status'      	=>      $active_category,
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag')
									);
				if($this->hd_category_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/hoidap/cat/add', 'location');
			}
			else
	        {
				$data['name_category'] = $this->input->post('name_category');
				$data['descr_category'] = $this->input->post('descr_category');
				$data['image_category'] = $this->input->post('image_category');
				$data['order_category'] = $this->input->post('order_category');
				$data['active_category'] = $this->input->post('active_category');
				$data['keyword'] = $this->input->post('keyword');
				$data['h1tag'] = $this->input->post('h1tag');
	        }
        }
		//$retArray = array();
		// $this->display_child(0, 0,$retArray);
		
		//$data['parents']  = $retArray;
		
		#Load view
		$this->load->view('admin/hds/add', $data);
	}
	function categoryedit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit'))
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
            #BEGIN: Get category by $id
			$category = $this->hd_category_model->get("*", "cat_id = ".(int)$id);
			if(count($category) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/hoidap/cat', 'location');
				die();
			}
			#END Get category by $id
			#BEGIN: Load image category
            $this->load->library('file');
			$imageCategory = $this->hd_category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = array_merge($this->file->load('templates/home/images/category', $usedImage), array($category->cat_image));
            #END Load image category
			#Begin: Category hoi dap
			$cat_parent = $this->hd_category_model->get("*", "cat_id = ".(int)$category->parent_id);
			if(isset($cat_parent)){
				if($cat_parent->parent_id == 0)
				{
					$data['parent_id_0'] = $category->parent_id;
				}
				else
				{
					$data['parent_id_0'] = $cat_parent->parent_id;
					$data['parent_id_1'] = $category->parent_id;
					$cat_level_1 = $this->hd_category_model->fetch("*","parent_id = ".$cat_parent->parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
					$data['catlevel1']=$cat_level_1;
				}
			}
			$cat_level_0 = $this->hd_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND cat_id != ".$id, "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->hd_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			$maxindex = $this->hd_category_model->get("max(cat_index) as maxindex");
			$data['next_index'] = (int)$maxindex->maxindex+1;
			
			$this->load->library('form_validation');
			#BEGIN: Set rules
            //$this->form_validation->set_rules('descr_category', 'lang:descr_label_edit', 'trim|required');
            //$this->form_validation->set_rules('image_category', 'lang:image_label_edit', 'required');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category'))))
            {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            }
            else
            {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_category') == '1')
				{
	                $active_category = 1;
				}
				else
				{
	                $active_category = 0;
				}
				$dataEdit = array(
				                    'cat_name'      	=>      trim($this->filter->injection_html($this->input->post('name_category'))),
				                    'cat_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
				                    'cat_image'			=>      $this->filter->injection($this->input->post('image_category')),
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
	                                'cat_status'      	=>      $active_category,
									 'parent_id'      	=>      $this->input->post('parent_id'),
									 'cat_index'      	=>      $this->input->post('cat_index'),
									 'cat_level'      	=>      $this->input->post('cat_level'),
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag')   
									);
				if($this->hd_category_model->update($dataEdit, "cat_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				
				if($category->cat_level==0 && (int)$this->input->post('cat_level')==1)
				{
					$this->hd_category_model->update(array('cat_level' => 2), "parent_id  = ".(int)$id);
				}
				
				redirect(base_url().'administ/hoidap/cat/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_category'] = $category->cat_name;
				$data['descr_category'] = $category->cat_descr;
				$data['image_category'] = $category->cat_image;
				$data['order_category'] = $category->cat_order;
				$data['active_category'] = $category->cat_status;
				$data['parent_id'] = $category->parent_id;
				$data['cat_index'] = $category->cat_index;
				$data['cat_level'] = $category->cat_level;
				$data['keyword'] = $category->keyword;
				$data['h1tag'] = $category->h1tag;
	        }
        }
		
		#Load view
		$this->load->view('admin/hds/edit', $data);
	}

	function loadCategory($parent, $level,&$retArray, $where, $sort, $by, $start, $limit)
	{
		$select = "*";
		$whereTmp = "";
		if(strlen($where)>0){
			$whereTmp .= $where." and parent_id='$parent' ";
		}else{
			$whereTmp .= $where."parent_id='$parent'";
		}
		$category  = $this->hd_category_model->fetch($select, $whereTmp, $sort, $by, $start, $limit);
	   foreach ($category as $row)
	   { 
		   $row->cat_name = str_repeat('-',$level)." ".$row->cat_name;
		   $retArray[] = $row;
	       $this->loadCategory($row->cat_id, $level+1,$retArray, $where, $sort, $by, $start, $limit);
		   //edit by nganly
	   }
	}
	function ajax(){
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->hd_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}
}