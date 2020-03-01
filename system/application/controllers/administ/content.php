<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Content extends CI_Controller
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
		$this->lang->load('admin/content');
		#Load model
		$this->load->model('content_model');
	}

	function index()
	{
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->content_model->delete($this->input->post('checkone'), "not_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = 'cat_type = 0';
		$sort = 'not_id';
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
				    $where .= " AND not_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND not_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND not_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND not_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND not_status = 0";
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
		$data['sortUrl'] = base_url().'administ/content'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/content'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->content_model->update(array('not_status'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->content_model->update(array('not_status'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		$this->load->library('pagination');
		$totalRecord = count($this->content_model->fetch("not_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/content'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;		
		$select = "*";			
		$limit = settingOtherAdmin;
		$data['content'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
		$this->load->view('admin/content/defaults', $data);		
	}
	
	function tintuc()
	{
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->content_model->delete($this->input->post('checkone'), "not_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'paid', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = 'cat_type = 1';
		$sort = 'not_id';
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
				    $where .= " AND not_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND not_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND not_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND not_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND not_status = 0";
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
		$data['keyword'] = $keyword;
		$data['sortUrl'] = base_url().'administ/tintuc'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/tintuc'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->content_model->update(array('not_status'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->content_model->update(array('not_status'=>0), "not_id = ".(int)$getVar['id']);
					break;
				case 'publish':
				    $this->content_model->update(array('not_publish'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'unpublish':
				    $this->content_model->update(array('not_publish'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			
			redirect($data['statusUrl'], 'location');
		}
		
		if($getVar['paid'] != FALSE && trim($getVar['paid']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			
			switch(strtolower($getVar['paid']))
			{
				case 'active':
				    $this->content_model->update(array('not_paid_news'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->content_model->update(array('not_paid_news'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->content_model->fetch("not_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/tintuc'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;		
		$select = "*";			
		$limit = settingOtherAdmin;
		$data['content'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
		$this->load->view('admin/content/tintuc', $data);	
	}

	function cohoi()
	{
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->content_model->delete($this->input->post('checkone'), "not_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = 'cat_type = 2';
		$sort = '';
		$by = 'ASC';
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
				    $where .= " AND not_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND not_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND not_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND not_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND not_status = 0";
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
		$data['keyword'] = $keyword;
		$data['sortUrl'] = base_url().'administ/cohoi'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/cohoi'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->content_model->update(array('not_status'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->content_model->update(array('not_status'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->content_model->fetch("not_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/cohoi'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;		
		$select = "*";			
		$limit = settingOtherAdmin;
		$data['content'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
		$this->load->view('admin/content/cohoi', $data);	
	}

	function doc()
	{
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->content_model->delete($this->input->post('checkone'), "not_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = 'cat_type = 3';
		$sort = 'not_id';
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
				    $where .= " AND not_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND not_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND not_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND not_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND not_status = 0";
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
				 case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "group_docs";
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
		$data['keyword'] = $keyword;
		$data['sortUrl'] = base_url().'administ/doc'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/doc'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->content_model->update(array('not_status'=>1), "not_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->content_model->update(array('not_status'=>0), "not_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->content_model->fetch("not_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/doc'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;		
		$select = "*";			
		$limit = settingOtherAdmin;
		$data['content'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
		$this->load->view('admin/content/doc', $data);	
	}




	function ajax_category_content()
	{
		$this->load->model('content_category_model');
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->content_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
		if(isset($cat_level)){
			foreach($cat_level as $key=>$item){
				$cat_level_next = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level[$key]->child_count = count($cat_level_next);
			}
		}
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}

	function add()
	{
		$this->load->model('content_category_model');
	 	$cat_level_0 = $this->content_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND cat_type = 0 ", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder+1;						
		$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex+1;		
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_add'))
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
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('title_content', 'lang:title_label_add', 'trim|required');//|callback__exist_title
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_add', 'trim|required');           
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			//$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}	
				$dataAdd = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_begindate'     =>      mktime(),
				                    'not_enddate'      	=>      0,								   
	                                'not_status'      	=>      $active_content
									);
				if($this->content_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/content/add', 'location');
			}
			else
	        {
				$data['title_content'] = $this->input->post('title_content');
				$data['txtContent'] = $this->input->post('txtContent');
				$data['active_content'] = $this->input->post('active_content');
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/add', $data);
	}
	function addtintuc()
	{
        #BEGIN: CHECK PERMISSION
		$this->load->model('content_category_model');	
	 	$cat_level_0 = $this->content_category_model->fetch("*","cat_status = 1 AND cat_type = 1 ", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder+1;						
		$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex+1;
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_add'))
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
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('title_content', 'lang:title_label_add', 'trim|required');//|callback__exist_title
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_add', 'trim|required');           
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			//$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/tintuc/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}				
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}	
				 if($this->input->post('active_content') == '1')
				{
					$publish_content = 1;
				}
				else
				{
					$publish_content = 0;
				}	
				
				$dataAdd = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_begindate'     =>      mktime(),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      1,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content,
	                                'not_publish'      	=>      $publish_content
									);
				if($this->content_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/tintuc/add', 'location');
			}
			else
	        {
				$data['title_content'] = $this->input->post('title_content');
				$data['txtContent'] = $this->input->post('txtContent');
				$data['active_content'] = $this->input->post('active_content');
				$data['publish_content'] = $this->input->post('publish_content');
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/add_tintuc', $data);
	}
	function addcohoi()
	{
        #BEGIN: CHECK PERMISSION
		$this->load->model('content_category_model');	
	 	$cat_level_0 = $this->content_category_model->fetch("*","cat_status = 1 AND cat_type = 2 ", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder+1;						
		$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex+1;
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_add'))
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
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('title_content', 'lang:title_label_add', 'trim|required');//|callback__exist_title
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_add', 'trim|required');           
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			//$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/cohoi/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}				
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}				
				$dataAdd = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_begindate'     =>      mktime(),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      2,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content
									);
				if($this->content_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/cohoi/add', 'location');
			}
			else
	        {
				$data['title_content'] = $this->input->post('title_content');
				$data['txtContent'] = $this->input->post('txtContent');
				$data['active_content'] = $this->input->post('active_content');
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/add_cohoi', $data);
	}
	
	function adddoc()
	{
        #BEGIN: CHECK PERMISSION
		$this->load->model('content_category_model');	
	 	$cat_level_0 = $this->content_category_model->fetch("*","cat_status = 1 AND cat_type = 3 ", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder+1;						
		$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex+1;
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_add'))
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
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('title_content', 'lang:title_label_add', 'trim|required');//|callback__exist_title
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_add', 'trim|required');           
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			//$this->form_validation->set_message('_exist_title', $this->lang->line('_exist_title_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/doc/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}				
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}				
				$dataAdd = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      trim($this->filter->injection_html($this->input->post('group_docs'))),
				                   // 'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_begindate'     =>      mktime(),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      3,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content,
	                                'group_docs'      	=>      $this->input->post('group_docs')
									);
				if($this->content_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/doc/', 'location');
			}
			else
	        {
				$data['title_content'] = $this->input->post('title_content');
				$data['txtContent'] = $this->input->post('txtContent');
				$data['active_content'] = $this->input->post('active_content');
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/add_doc', $data);
	}

	/**/	
	function edit($id)
	{
       $this->load->model('content_category_model');
					 $cat_level_0 = $this->content_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND cat_type = 0", "cat_order, cat_id", "ASC");
						if(isset($cat_level_0)){
							foreach($cat_level_0 as $key=>$item){
								$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
								$cat_level_0[$key]->child_count = count($cat_level_1);
							}
						}
						$data['catlevel0']=$cat_level_0;
						$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
						$data['next_order'] = (int)$maxorder->maxorder+1;						
						$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
						$data['next_index'] = (int)$maxindex->maxindex+1;	
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}		
        if($this->session->flashdata('sessionSuccessEdit'))
		{
            $data['successEdit'] = true;
		}
		else
		{
            $data['successEdit'] = false;          
            $content = $this->content_model->get("*", "not_id = ".(int)$id);
            if(count($content) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/content', 'location');
				die();
			}
			$this->load->library('form_validation');
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_edit', 'trim|required');
            if($content->not_title != trim($this->filter->injection_html($this->input->post('title_content'))))
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required');
            }
			if($this->form_validation->run() != FALSE)
			{
				$role_content = '0,1,2,3';		
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}
				$dataEdit = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_enddate'      	=>      0,
	                                'not_status'      	=>      $active_content
									);
				if($this->content_model->update($dataEdit, "not_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/content', 'location');
			}
			else
	        {
				$data['title_content'] = $content->not_title;
				$data['txtContent'] = $content->not_detail;			
				$data['active_content'] = $content->not_status;
				$data['category_shop'] = $content->id_category;
				$cat_parent = $this->content_category_model->get("*", "cat_id = ".(int)$content->id_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->content_category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);
							$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
							$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->content_category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
							$data['cat_level_1'] = $cat_lavel_1_temp;							
						}
						else
						{							
							if($cat_parent->cat_level==0)
							{
								$data['cat_getcategory0']=1;
								$data['cat_getcategory0_temp']=1;
							}
							else
							{
								$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								$data['cat_level_1'] = $cat_lavel_1_temp;				
								$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);
								$data['cat_parent_parent_0']=$cat_parent;
							}					
						}						
	        }
        }
	    #Load view
	    $folder=folderWeb;
	    $dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
	    if ($opendir = opendir($dir)) {
		$images = array();
		while (($file = readdir($opendir)) !== FALSE) {
		if ($file != "." && $file != "..") {
		    $pathinfo = pathinfo($file);
		    if (isset($pathinfo['extension'])) {
			$ext = strtolower($pathinfo['extension']);
		    } else {
			$ext = '';
		    }
		    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
			$images["$file"] = $file;
		    }
		}
	    }
	}
	$data['images'] = $images;
		$this->load->view('admin/content/edit', $data);
	}
	function edittintuc($id)
	{
       $this->load->model('content_category_model');
					 $cat_level_0 = $this->content_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND  cat_type = 1", "cat_order, cat_id", "ASC");
						if(isset($cat_level_0)){
							foreach($cat_level_0 as $key=>$item){
								$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
								$cat_level_0[$key]->child_count = count($cat_level_1);
							}
						}
						$data['catlevel0']=$cat_level_0;
						$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
						$data['next_order'] = (int)$maxorder->maxorder+1;						
						$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
						$data['next_index'] = (int)$maxindex->maxindex+1;	
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}		
        if($this->session->flashdata('sessionSuccessEdit'))
		{
            $data['successEdit'] = true;
		}
		else
		{
            $data['successEdit'] = false;          
            $content = $this->content_model->get("*", "not_id = ".(int)$id);
            if(count($content) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/tintuc/edit/'.$id, 'location');
				die();
			}
			$this->load->library('form_validation');
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_edit', 'trim|required');
            if($content->not_title != trim($this->filter->injection_html($this->input->post('title_content'))))
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required');
            }
			if($this->form_validation->run() != FALSE)
			{
					$role_content = '0,1,2,3';	 				
					#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/tintuc/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}	
					if(trim($image)!="")
					{
						$image=$image;
						$dir_image=$dir_image;
					}
					else
					{
						$image=$content->not_image ;
						$dir_image=$content->not_dir_image;	
					}
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}
				if($this->input->post('publish_content') == '1')
				{
	                $publish_content = 1;
				}
				else
				{
	                $publish_content = 0;
				}
				$dataEdit = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      1,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content,
	                                'not_publish'      	=>      $publish_content
									);
				if($this->content_model->update($dataEdit, "not_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/tintuc', 'location');
			}
			else
	        {
				$data['title_content'] = $content->not_title;
				$data['txtContent'] = $content->not_detail;			
				$data['active_content'] = $content->not_status;
				$data['publish_content'] = $content->not_publish;
				$data['category_shop'] = $content->id_category;
				$data['not_image'] = $content->not_image;
				$data['not_dir_image'] = $content->not_dir_image;
				$cat_parent = $this->content_category_model->get("*", "cat_id = ".(int)$content->id_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->content_category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);
							$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
							$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->content_category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
							$data['cat_level_1'] = $cat_lavel_1_temp;							
						}
						else
						{							
							if($cat_parent->cat_level==0)
							{
								$data['cat_getcategory0']=1;
								$data['cat_getcategory0_temp']=1;
							}
							else
							{
								$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								$data['cat_level_1'] = $cat_lavel_1_temp;				
								$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);
								$data['cat_parent_parent_0']=$cat_parent;
							}					
						}						
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/edit_tintuc', $data);
	}
	/**/
	function editcohoi($id)
	{
       $this->load->model('content_category_model');
					 $cat_level_0 = $this->content_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND  cat_type = 2", "cat_order, cat_id", "ASC");
						if(isset($cat_level_0)){
							foreach($cat_level_0 as $key=>$item){
								$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
								$cat_level_0[$key]->child_count = count($cat_level_1);
							}
						}
						$data['catlevel0']=$cat_level_0;
						$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
						$data['next_order'] = (int)$maxorder->maxorder+1;						
						$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
						$data['next_index'] = (int)$maxindex->maxindex+1;	
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}		
        if($this->session->flashdata('sessionSuccessEdit'))
		{
            $data['successEdit'] = true;
		}
		else
		{
            $data['successEdit'] = false;          
            $content = $this->content_model->get("*", "not_id = ".(int)$id);
            if(count($content) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/cohoi', 'location');
				die();
			}
			$this->load->library('form_validation');
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_edit', 'trim|required');
            if($content->not_title != trim($this->filter->injection_html($this->input->post('title_content'))))
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required');
            }
			if($this->form_validation->run() != FALSE)
			{
					$role_content = '0,1,2,3';	 				
					#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/cohoi/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}	
					if(trim($image)!="")
					{
						$image=$image;
						$dir_image=$dir_image;
					}
					else
					{
						$image=$content->not_image ;
						$dir_image=$content->not_dir_image;	
					}
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}
				$dataEdit = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      2,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content
									);
				if($this->content_model->update($dataEdit, "not_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/cohoi/edit/'.$id, 'location');
			}
			else
	        {
				$data['title_content'] = $content->not_title;
				$data['txtContent'] = $content->not_detail;			
				$data['active_content'] = $content->not_status;
				$data['category_shop'] = $content->id_category;
				$data['not_image'] = $content->not_image;
				$data['not_dir_image'] = $content->not_dir_image;
				$cat_parent = $this->content_category_model->get("*", "cat_id = ".(int)$content->id_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->content_category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);
							$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
							$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->content_category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
							$data['cat_level_1'] = $cat_lavel_1_temp;							
						}
						else
						{							
							if($cat_parent->cat_level==0)
							{
								$data['cat_getcategory0']=1;
								$data['cat_getcategory0_temp']=1;
							}
							else
							{
								$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								$data['cat_level_1'] = $cat_lavel_1_temp;				
								$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);
								$data['cat_parent_parent_0']=$cat_parent;
							}					
						}						
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/edit_cohoi', $data);
	}
	/**/
	function editdoc($id)
	{
        $this->load->model('content_category_model');
	    $cat_level_0 = $this->content_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND  cat_type = 3", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->content_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder+1;						
		$maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex+1;	
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'content_edit'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}		
        if($this->session->flashdata('sessionSuccessEdit'))
		{
            $data['successEdit'] = true;
		}
		else
		{
            $data['successEdit'] = false;          
            $content = $this->content_model->get("*", "not_id = ".(int)$id);
            if(count($content) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/doc', 'location');
				die();
			}
			$this->load->library('form_validation');
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_edit', 'trim|required');
            if($content->not_title != trim($this->filter->injection_html($this->input->post('title_content'))))
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required|callback__exist_title');
            }
            else
            {
                $this->form_validation->set_rules('title_content', 'lang:title_label_edit', 'trim|required');
            }
			if($this->form_validation->run() != FALSE)
			{
					$role_content = '0,1,2,3';	 				
					#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/doc/";
					#Create folder
					$dir_image = date('dmY');
					$image = '';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';				
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}	
					if(trim($image)!="")
					{
						$image=$image;
						$dir_image=$dir_image;
					}
					else
					{
						$image=$content->not_image ;
						$dir_image=$content->not_dir_image;	
					}
                if($this->input->post('active_content') == '1')
				{
	                $active_content = 1;
				}
				else
				{
	                $active_content = 0;
				}
				$dataEdit = array(
				                    'not_title'      	=>      trim($this->filter->injection_html($this->input->post('title_content'))),
				                    'not_group'      	=>      trim($this->filter->injection_html($this->input->post('group_docs'))),
				                  //  'not_group'      	=>      $this->filter->injection($role_content),
									'id_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'not_degree'		=>      1,
				                    'not_detail'        =>      trim($this->filter->injection_html($this->input->post('txtContent'))),
				                    'not_enddate'      	=>      0,
									'cat_type'      	=>      3,
								   	'not_image'     	=>      $image,
									'not_dir_image'     =>      $dir_image,
	                                'not_status'      	=>      $active_content,
	                                'group_docs'      	=>      $this->input->post('group_docs')
									);
				if($this->content_model->update($dataEdit, "not_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/doc', 'location');
				//redirect(base_url().'administ/doc/edit/'.$id, 'location');
			}
			else
	        {
				$data['title_content'] = $content->not_title;
				$data['txtContent'] = $content->not_detail;			
				$data['active_content'] = $content->not_status;
				$data['category_shop'] = $content->id_category;
				$data['not_image'] = $content->not_image;
				$data['not_dir_image'] = $content->not_dir_image;
				$data['group_docs'] = $content->group_docs;

				$cat_parent = $this->content_category_model->get("*", "cat_id = ".(int)$content->id_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->content_category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);
							$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
							$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->content_category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
							$data['cat_level_1'] = $cat_lavel_1_temp;							
						}
						else
						{							
							if($cat_parent->cat_level==0)
							{
								$data['cat_getcategory0']=1;
								$data['cat_getcategory0_temp']=1;
							}
							else
							{
								$cat_lavel_1_temp=$this->content_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								$data['cat_level_1'] = $cat_lavel_1_temp;				
								$get_category_leve1=$this->content_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);
								$data['cat_parent_parent_0']=$cat_parent;
							}					
						}						
	        }
        }
		#Load view
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images";
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		$this->load->view('admin/content/edit_doc', $data);
	}
	/**/
	function _exist_title()
	{
		if(count($this->content_model->get("not_id", "not_title = '".trim($this->filter->injection_html($this->input->post('title_content')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_content'), (int)$this->input->post('endday_content'), (int)$this->input->post('endyear_content'));
		if($this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}
}