<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Employ extends CI_Controller
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
		$this->lang->load('admin/employ');
		#Load model
		$this->load->model('employ_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('employ_favorite_model');
			$this->load->model('employ_bad_model');
			$idEmploy = $this->input->post('checkone');
			$this->employ_favorite_model->delete($idEmploy, "emf_employ");
			$this->employ_bad_model->delete($idEmploy, "emb_employ");
			$this->employ_model->delete($idEmploy, "emp_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'ed');
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
				    $where .= "emp_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'salary':
				    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $where .= "emp_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "emp_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "emp_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "emp_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "emp_status = 0";
				    break;
                case 'reliable':
				    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $where .= "emp_reliable = 1";
				    break;
                case 'notreliable':
				    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $where .= "emp_reliable = 0";
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
				    $sort .= "emp_title";
				    break;
                case 'field':
				    $pageUrl .= '/sort/field';
				    $sort .= "fie_name";
				    break;
                case 'province':
				    $pageUrl .= '/sort/province';
				    $sort .= "pre_name";
				    break;
                case 'salary':
				    $pageUrl .= '/sort/salary';
				    $sort .= "emp_salary";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "emp_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "emp_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "emp_id";
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
		$data['sortUrl'] = base_url().'administ/employ'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/employ'.$statusUrl;
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
		$data['reliableUrl'] = base_url().'administ/employ'.$reliableUrl;
		if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['ed'] != FALSE && (int)$getVar['ed'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['reliable']))
			{
				case 'active':
				    $this->employ_model->update(array('emp_reliable'=>1), "emp_id = ".(int)$getVar['ed']);
					break;
				case 'deactive':
				    $this->employ_model->update(array('emp_reliable'=>0), "emp_id = ".(int)$getVar['ed']);
					break;
			}
			redirect($data['reliableUrl'], 'location');
		}
		#END Reliable
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/employ'.$pageUrl.'/page/';
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
		$select = "emp_id, emp_title, emp_field, emp_salary, emp_view, emp_reliable, emp_status, emp_begindate, emp_enddate, fie_id, fie_name, pre_id, pre_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='employ' && $this->uri->segment(3)==''){
			$this->db->order_by("emp_id", "DESC"); 
		}
		$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/employ/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'employ')))
		{
            $this->employ_model->update(array('emp_status'=>0), "emp_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-employ');
            }
            else
            {
                setcookie('_cookieSetStatus', 'employ');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'reliable', 'ed');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "emp_enddate < $currentDate";
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
				    $where .= " AND emp_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'salary':
				    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $where .= " AND emp_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $sort .= "emp_title";
				    break;
                case 'field':
				    $pageUrl .= '/sort/field';
				    $sort .= "fie_name";
				    break;
                case 'province':
				    $pageUrl .= '/sort/province';
				    $sort .= "pre_name";
				    break;
                case 'salary':
				    $pageUrl .= '/sort/salary';
				    $sort .= "emp_salary";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "emp_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "emp_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "emp_id";
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
		$data['sortUrl'] = base_url().'administ/employ/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Reliable
		$reliableUrl = $pageUrl.$pageSort;
		$data['reliableUrl'] = base_url().'administ/employ/end'.$reliableUrl;
		if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['ed'] != FALSE && (int)$getVar['ed'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['reliable']))
			{
				case 'active':
				    $this->employ_model->update(array('emp_reliable'=>1), "emp_id = ".(int)$getVar['ed']);
					break;
				case 'deactive':
				    $this->employ_model->update(array('emp_reliable'=>0), "emp_id = ".(int)$getVar['ed']);
					break;
			}
			redirect($data['reliableUrl'], 'location');
		}
		#END Reliable
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/employ/end'.$pageUrl.'/page/';
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
		$select = "emp_id, emp_title, emp_field, emp_salary, emp_view, emp_reliable, emp_status, emp_begindate, emp_enddate, fie_id, fie_name, pre_id, pre_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='employ' && $this->uri->segment(3)=='end' && $this->uri->segment(4)==''){
			$this->db->order_by("emp_enddate", "DESC"); 
		}
		$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/employ/end', $data);
	}
	
	function bad()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('employ_bad_model');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'ed', 'detail');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
            #BEGIN: Delete employ bad
			if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
			{
				$this->employ_bad_model->delete((int)$this->input->post('idBad'), "emb_id", false);
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
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
			$totalRecord = count($this->employ_bad_model->fetch("emb_id", "emb_employ = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/employ/bad/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['employ'] = $this->employ_bad_model->fetch("*", "emb_employ = ".(int)$getVar['detail'], "emb_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/employ/bad_detail', $data);
		}
		else
		{
            #BEGIN: Fetch employ bad
			$employBad = $this->employ_bad_model->fetch("emb_employ", "", "", "", "emb_employ");
			$idEmployBad = array();
			foreach($employBad as $employBadArray)
			{
				$idEmployBad[] = $employBadArray->emb_employ;
			}
			#END Fetch employ bad
			if(count($idEmployBad) > 0)
			{
                $data['haveEmployBad'] = true;
                $idEmployBad = implode(',', $idEmployBad);
				#BEGIN: Search & Filter
				$where = "emp_id IN($idEmployBad)";
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
						    $where .= " AND emp_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
		                case 'salary':
						    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
						    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
						    $where .= " AND emp_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
						    $sort .= "emp_title";
						    break;
		                case 'field':
						    $pageUrl .= '/sort/field';
						    $sort .= "fie_name";
						    break;
		                case 'province':
						    $pageUrl .= '/sort/province';
						    $sort .= "pre_name";
						    break;
		                case 'salary':
						    $pageUrl .= '/sort/salary';
						    $sort .= "emp_salary";
						    break;
		                case 'user':
						    $pageUrl .= '/sort/user';
						    $sort .= "use_username";
						    break;
		                case 'begindate':
						    $pageUrl .= '/sort/begindate';
						    $sort .= "emp_begindate";
						    break;
		                case 'enddate':
						    $pageUrl .= '/sort/enddate';
						    $sort .= "emp_enddate";
						    break;
						default:
						    $pageUrl .= '/sort/id';
						    $sort .= "emp_id";
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
				$data['sortUrl'] = base_url().'administ/employ/bad'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/employ/bad'.$statusUrl;
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
				$data['reliableUrl'] = base_url().'administ/employ/bad'.$reliableUrl;
				if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['ed'] != FALSE && (int)$getVar['ed'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['reliable']))
					{
						case 'active':
						    $this->employ_model->update(array('emp_reliable'=>1), "emp_id = ".(int)$getVar['ed']);
							break;
						case 'deactive':
						    $this->employ_model->update(array('emp_reliable'=>0), "emp_id = ".(int)$getVar['ed']);
							break;
					}
					redirect($data['reliableUrl'], 'location');
				}
				#END Reliable
				#BEGIN: Pagination
				$this->load->library('pagination');
				#Count total record
				$totalRecord = count($this->employ_model->fetch_join("emp_id", "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_employ.emp_province = tbtt_province.pre_id", $where, "", ""));
		        $config['base_url'] = base_url().'administ/employ/bad'.$pageUrl.'/page/';
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
				$select = "emp_id, emp_title, emp_field, emp_salary, emp_view, emp_reliable, emp_status, emp_begindate, emp_enddate, fie_id, fie_name, use_id, use_username, use_email,emb_detail,emb_title,emb_date,emb_id_user,emp_province ";
				$limit = settingOtherAdmin;
				if($this->uri->segment(2)=='employ' && $this->uri->segment(3)=='bad' && $this->uri->segment(4)==''){
					$this->db->order_by("emb_date", "DESC"); 
				}
				$data['employ'] = $this->employ_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_employ.emp_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_employ.emp_field = tbtt_field.fie_id", "LEFT", "tbtt_employ_bad", "tbtt_employ.emp_id = tbtt_employ_bad.emb_employ", $where, $sort, $by, $start, $limit,true);
			}
			else
			{
                $data['haveEmployBad'] = false;
			}
			#Load view
			$this->load->view('admin/employ/bad', $data);
		}
	}
    
    function ajax()
    {
        if($this->input->post('id') && $this->check->is_id($this->input->post('id')) && $this->input->post('enddate'))
        {
            if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'employ_edit'))
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
                $employ = $this->employ_model->get("emp_id", "emp_id = $id");
                if(count($employ) == 1)
                {
                    $this->employ_model->update(array('emp_enddate'=>(int)$endDate), "emp_id = $id");
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