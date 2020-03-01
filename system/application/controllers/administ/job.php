<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Job extends CI_Controller
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
		$this->lang->load('admin/job');
		#Load model
		$this->load->model('job_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('job_favorite_model');
			$this->load->model('job_bad_model');
			$idJob = $this->input->post('checkone');
			$this->job_favorite_model->delete($idJob, "jof_job");
			$this->job_bad_model->delete($idJob, "jba_job");
			$this->job_model->delete($idJob, "job_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'jd');
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
				    $where .= "job_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'salary':
				    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $where .= "job_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "job_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "job_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "job_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "job_status = 0";
				    break;
                case 'reliable':
				    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $where .= "job_reliable = 1";
				    break;
                case 'notreliable':
				    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $where .= "job_reliable = 0";
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
				    $sort .= "job_title";
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
				    $sort .= "job_salary";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "job_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "job_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "job_id";
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
		$data['sortUrl'] = base_url().'administ/job'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/job'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->job_model->update(array('job_status'=>1), "job_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->job_model->update(array('job_status'=>0), "job_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Reliable
		$reliableUrl = $pageUrl.$pageSort;
		$data['reliableUrl'] = base_url().'administ/job'.$reliableUrl;
		if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['jd'] != FALSE && (int)$getVar['jd'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['reliable']))
			{
				case 'active':
				    $this->job_model->update(array('job_reliable'=>1), "job_id = ".(int)$getVar['jd']);
					break;
				case 'deactive':
				    $this->job_model->update(array('job_reliable'=>0), "job_id = ".(int)$getVar['jd']);
					break;
			}
			redirect($data['reliableUrl'], 'location');
		}
		#END Reliable
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/job'.$pageUrl.'/page/';
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
		$select = "job_id, job_title, job_field, job_salary, job_view, job_reliable, job_status, job_begindate, job_enddate, fie_id, fie_name, pre_id, pre_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='job' && $this->uri->segment(3)==''){
			$this->db->order_by("job_id", "DESC"); 
		}
		$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/job/defaults', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'job')))
		{
            $this->job_model->update(array('job_status'=>0), "job_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-job');
            }
            else
            {
                setcookie('_cookieSetStatus', 'job');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'reliable', 'jd');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "job_enddate < $currentDate";
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
				    $where .= " AND job_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'salary':
				    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
				    $where .= " AND job_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= " AND job_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND job_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND job_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND job_status = 0";
				    break;
                case 'reliable':
				    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
				    $where .= " AND job_reliable = 1";
				    break;
                case 'notreliable':
				    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
				    $where .= " AND job_reliable = 0";
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
				    $sort .= "job_title";
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
				    $sort .= "job_salary";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "job_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "job_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "job_id";
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
		$data['sortUrl'] = base_url().'administ/job/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Reliable
		$reliableUrl = $pageUrl.$pageSort;
		$data['reliableUrl'] = base_url().'administ/job/end'.$reliableUrl;
		if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['jd'] != FALSE && (int)$getVar['jd'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['reliable']))
			{
				case 'active':
				    $this->job_model->update(array('job_reliable'=>1), "job_id = ".(int)$getVar['jd']);
					break;
				case 'deactive':
				    $this->job_model->update(array('job_reliable'=>0), "job_id = ".(int)$getVar['jd']);
					break;
			}
			redirect($data['reliableUrl'], 'location');
		}
		#END Reliable
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/job/end'.$pageUrl.'/page/';
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
		$select = "job_id, job_title, job_field, job_salary, job_view, job_reliable, job_status, job_begindate, job_enddate, fie_id, fie_name, pre_id, pre_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='job' && $this->uri->segment(3)=='end' && $this->uri->segment(4)==''){
			$this->db->order_by("job_enddate", "DESC"); 
		}
		$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/job/end', $data);
	}
	
	function bad()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('job_bad_model');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'reliable', 'jd', 'detail');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
			#BEGIN: Delete job bad
			if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
			{
				$this->job_bad_model->delete((int)$this->input->post('idBad'), "jba_id", false);
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete job bad
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
			$totalRecord = count($this->job_bad_model->fetch("jba_id", "jba_job = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/job/bad/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['job'] = $this->job_bad_model->fetch("*", "jba_job = ".(int)$getVar['detail'], "jba_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/job/bad_detail', $data);
		}
		else
		{
            #BEGIN: Fetch job bad
			$jobBad = $this->job_bad_model->fetch("jba_job", "", "", "", "jba_job");
			$idJobBad = array();
			foreach($jobBad as $jobBadArray)
			{
				$idJobBad[] = $jobBadArray->jba_job;
			}
			#END Fetch job bad
			if(count($idJobBad) > 0)
			{
                $data['haveJobBad'] = true;
                $idJobBad = implode(',', $idJobBad);
				#BEGIN: Search & Filter
				$where = "job_id IN($idJobBad)";
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
						    $where .= " AND job_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
		                case 'salary':
						    $sortUrl .= '/search/salary/keyword/'.$getVar['keyword'];
						    $pageUrl .= '/search/salary/keyword/'.$getVar['keyword'];
						    $where .= " AND job_salary LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
						    $where .= " AND job_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND job_enddate = ".(float)$getVar['key'];
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND job_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND job_status = 0";
						    break;
		                case 'reliable':
						    $sortUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/reliable/key/'.$getVar['key'];
						    $where .= " AND job_reliable = 1";
						    break;
		                case 'notreliable':
						    $sortUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $pageUrl .= '/filter/notreliable/key/'.$getVar['key'];
						    $where .= " AND job_reliable = 0";
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
						    $sort .= "job_title";
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
						    $sort .= "job_salary";
						    break;
		                case 'user':
						    $pageUrl .= '/sort/user';
						    $sort .= "use_username";
						    break;
		                case 'begindate':
						    $pageUrl .= '/sort/begindate';
						    $sort .= "job_begindate";
						    break;
		                case 'enddate':
						    $pageUrl .= '/sort/enddate';
						    $sort .= "job_enddate";
						    break;
						default:
						    $pageUrl .= '/sort/id';
						    $sort .= "job_id";
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
				$data['sortUrl'] = base_url().'administ/job/bad'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/job/bad'.$statusUrl;
				if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['status']))
					{
						case 'active':
						    $this->job_model->update(array('job_status'=>1), "job_id = ".(int)$getVar['id']);
							break;
						case 'deactive':
						    $this->job_model->update(array('job_status'=>0), "job_id = ".(int)$getVar['id']);
							break;
					}
					redirect($data['statusUrl'], 'location');
				}
				#END Status
				#BEGIN: Reliable
				$reliableUrl = $pageUrl.$pageSort;
				$data['reliableUrl'] = base_url().'administ/job/bad'.$reliableUrl;
				if($getVar['reliable'] != FALSE && trim($getVar['reliable']) != '' && $getVar['jd'] != FALSE && (int)$getVar['jd'] > 0)
				{
                    #BEGIN: CHECK PERMISSION
					if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
					{
						show_error($this->lang->line('unallowed_use_permission'));
						die();
					}
					#END CHECK PERMISSION
					switch(strtolower($getVar['reliable']))
					{
						case 'active':
						    $this->job_model->update(array('job_reliable'=>1), "job_id = ".(int)$getVar['jd']);
							break;
						case 'deactive':
						    $this->job_model->update(array('job_reliable'=>0), "job_id = ".(int)$getVar['jd']);
							break;
					}
					redirect($data['reliableUrl'], 'location');
				}
				#END Reliable
				#BEGIN: Pagination
				$this->load->library('pagination');
				#Count total record
				$totalRecord = count($this->job_model->fetch_join("job_id", "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_province", "tbtt_job.job_province = tbtt_province.pre_id", $where, "", ""));
		        $config['base_url'] = base_url().'administ/job/bad'.$pageUrl.'/page/';
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
				$select = "job_id, job_title, job_field, job_salary, job_view, job_reliable, job_status, job_begindate, job_enddate, fie_id, fie_name, use_id, use_username, use_email , jba_title , jba_detail , jba_id_user ,jba_date ,job_province ";
				$limit = settingOtherAdmin;
				if($this->uri->segment(2)=='job' && $this->uri->segment(3)=='bad' && $this->uri->segment(4)==''){
					$this->db->order_by("jba_date", "DESC"); 
				}
				$data['job'] = $this->job_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_job.job_user = tbtt_user.use_id", "LEFT", "tbtt_field", "tbtt_job.job_field = tbtt_field.fie_id", "LEFT", "tbtt_job_bad", "tbtt_job.job_id  = tbtt_job_bad.jba_job", $where, $sort, $by, $start, $limit);
			}
			else
			{
                $data['haveJobBad'] = false;
			}
			#Load view
			$this->load->view('admin/job/bad', $data);
		}
	}
    
    function ajax()
    {
        if($this->input->post('id') && $this->check->is_id($this->input->post('id')) && $this->input->post('enddate'))
        {
            if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'job_edit'))
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
                $job = $this->job_model->get("job_id", "job_id = $id");
                if(count($job) == 1)
                {
                    $this->job_model->update(array('job_enddate'=>(int)$endDate), "job_id = $id");
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