<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
/**
 * @property  pagination
 */
class Commission extends CI_Controller
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
		#Load model
		$this->load->model('revenue_model');
		$this->load->model('commission_model');
	}
	function index()
	{
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view'))
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
		$sort = 'id';
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
				    $where .= "con_title LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $sort .= "con_title";
				    break;
                case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'position':
				    $pageUrl .= '/sort/position';
				    $sort .= "con_position";
				    break;
                case 'datecontact':
				    $pageUrl .= '/sort/datecontact';
				    $sort .= "con_date_contact";
				    break;
                case 'datereply':
				    $pageUrl .= '/sort/datereply';
				    $sort .= "con_date_reply";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "con_id";
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
		$data['sortUrl'] = base_url().'administ/contact'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/contact'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->contact_model->update(array('con_status'=>1), "con_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->contact_model->update(array('con_status'=>0), "con_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->contact_model->fetch_join("con_id", "LEFT", "tbtt_user", "tbtt_contact.con_user = tbtt_user.use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/contact'.$pageUrl.'/page/';
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
		$select = "con_id, con_title, con_position, con_date_contact, con_date_reply, con_view, con_reply, con_status, use_id, use_username, use_fullname, use_email";
		$limit = settingOtherAdmin;
		$data['contact'] = $this->contact_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_contact.con_user = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/commisson/defaults', $data);
	}
	function revenue()
	{
		#BEGIN: CHECK PERMISSION
		$this->load->model('revenue_model');
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
        $getVar2 = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'created_date';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
        if($getVar['filter'] == ''){
            $dateNoFilter = date('m-Y', strtotime("-1 months"));
            if($getVar2['key'] != ''){
                $date = strtolower($getVar2['key']);
                $daten = date('n', $date);
                $data['monthn'] = $daten;
                $data['yearn'] = date('Y', $date);
                $date = date('m-Y', $date);
                $where .= "tbtt_revenue.revenue_month_year = '".$date."' ";
            }else{
                $where .= "tbtt_revenue.revenue_month_year = '".$dateNoFilter."'";
                $data['monthn'] = date('n', strtotime("-1 months"));
                $data['yearn'] = date('Y', strtotime("-1 months"));
            }
        }

        if($getVar['key'] !=''){
            $data['key'] = $getVar['key'];
        }else{
            $data['key'] = mktime(0,0,0,$data['monthn'],1,$data['yearn']);
        }


//		$user_name = strtolower($this->uri->segment(4));
//		if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
//			$where .= "use_username = '".$user_name."'";
//		}else{
//			if($getVar['filter'] == ''){
//				$dateNoFilter = date('m-Y', strtotime("-1 months"));
//				$where .= "tbtt_revenue.revenue_month_year = '".$dateNoFilter."'";
//				$data['monthn'] = date('n', strtotime("-1 months"));
//				$data['yearn'] = date('Y', strtotime("-1 months"));
//			}
//		}
        $user_name = strtolower($this->uri->segment(3));

        if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
            $where .= " AND use_username = '".$user_name."'";
            $data['user_name'] = $user_name;
        }
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
			$keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'username':
					$sortUrl .= '/search/username/keyword/'.$getVar['keyword'].'/filter/doanhsothang/key/'.$getVar['key'];
					$pageUrl .= '/search/username/keyword/'.$getVar['keyword'].'/filter/doanhsothang/key/'.$getVar['key'];
					$where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					break;
				case 'fullname':
					$sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
					$pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
					$where .= "use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					break;
			}
            $sortUrl .= '/filter/doanhsothang/key/'.$getVar['key'];
            $pageUrl .= '/filter/doanhsothang/key/'.$getVar['key'];
            $date = strtolower($getVar['key']);
            $daten = date('n', $date);
            $data['monthn'] = $daten;
            $data['yearn'] = date('Y', $date);
            $date = date('m-Y', $date);
            $where .= "AND tbtt_revenue.revenue_month_year = '".$date."'";
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			$sortUrl .= '/filter/doanhsothang/key/'.$getVar['key'];
			$pageUrl .= '/filter/doanhsothang/key/'.$getVar['key'];
			$date = strtolower($getVar['key']);
			$daten = date('n', $date);
			$data['monthn'] = $daten;
			$data['yearn'] = date('Y', $date);
			$date = date('m-Y', $date);
			$where .= "tbtt_revenue.revenue_month_year = '".$date."'";
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'ground':
					$pageUrl .= '/sort/ground';
					$sort .= "gro_name";
					break;
				case 'username':
					$pageUrl .= '/sort/username';
					$sort .= "use_username";
					break;
				case 'fullname':
					$pageUrl .= '/sort/fullname';
					$sort .= "use_fullname";
					break;
				case 'parentuse':
					$pageUrl .= '/sort/parentuse';
					$sort .= "use_username_parent";
					break;
				case 'total':
					$pageUrl .= '/sort/total';
					$sort .= "total";
					break;
				case 'status':
					$pageUrl .= '/sort/status';
					$sort .= "status";
					break;
				case 'type':
					$pageUrl .= '/sort/type';
					$sort .= "text";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "id";
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
		$data['sortUrl'] = base_url().'administ/revenue/'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/revenue/'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
					$this->contact_model->update(array('con_status'=>1), "con_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
					$this->contact_model->update(array('con_status'=>0), "con_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "tbtt_revenue.id, tbtt_revenue.user_id, tbtt_revenue.group_id, tbtt_revenue.parent_id, tbtt_revenue.created_date, tbtt_revenue.revenue_month_year, tbtt_revenue.total, tbtt_revenue.private_profit, tbtt_revenue.type, tbtt_revenue.status, tbtt_user.use_id, tbtt_user.use_username, tbtt_user.use_fullname, tbtt_group.gro_name, tbtt_commission_type.text, (SELECT tbtt_user.use_username  FROM tbtt_user WHERE tbtt_user.use_id = tbtt_revenue.parent_id) as use_username_parent, (SELECT tbtt_user.use_id  FROM tbtt_user WHERE tbtt_user.use_id = tbtt_revenue.parent_id) as id_username_parent";
		$table1 = "tbtt_user";
		$jon1 = "INNER";
		$on1 = "tbtt_user.use_id = tbtt_revenue.user_id";
		$table2 = "tbtt_commission_type";
		$jon2 = "INNER";
		$on2 = "tbtt_commission_type.id = tbtt_revenue.type";
		$table3 = "tbtt_group";
		$jon3 = "INNER";
		$on3 = "tbtt_group.gro_id = tbtt_revenue.group_id";
		//$limit = settingOtherAdmin;
		$limit = 20;
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->revenue_model->fetch_join($select, $jon1 , $table1, $on1, $jon2, $table2, $on2, $jon3, $table3, $on3, $where, '', ''));
		$config['base_url'] = base_url().'administ/revenue'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$data['revenue'] = $this->revenue_model->fetch_join($select, $jon1 , $table1, $on1, $jon2, $table2, $on2, $jon3, $table3, $on3, $where, $sort, $by, $start, $limit);
        //echo $this->db->last_query();
		#Load view
		$this->load->view('admin/commission/revenue', $data);
	}
	function commiss()
	{
		#BEGIN: CHECK PERMISSION
		
		$this->load->model('commission_model');
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
        $getVar2 = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'user_id';
		$by = 'ASC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
        if($getVar['filter'] == ''){
            $dateNoFilter = date('m-Y', strtotime("-1 months"));
            if($getVar2['key'] != ''){
                $date = strtolower($getVar2['key']);
                $daten = date('n', $date);
                $data['monthn'] = $daten;
                $data['yearn'] = date('Y', $date);
                $date = date('m-Y', $date);
                $where .= "tbtt_commission.commission_month = '".$date."' ";
            }else{
                $where .= "tbtt_commission.commission_month = '".$dateNoFilter."'";
                $data['monthn'] = date('n', strtotime("-1 months"));
                $data['yearn'] = date('Y', strtotime("-1 months"));
            }
        }
        if($getVar['key'] !=''){
            $data['key'] = $getVar['key'];
        }else{
            $data['key'] = mktime(0,0,0,$data['monthn'],1,$data['yearn']);
        }
//		$user_name = strtolower($this->uri->segment(4));
//		if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
//			$where .= "use_username = '".$user_name."'";
//		}else{
//			if($getVar['filter'] == ''){
//				$dateNoFilter = date('m-Y', strtotime("-1 months"));
//				$where .= "tbtt_revenue.revenue_month_year = '".$dateNoFilter."'";
//				$data['monthn'] = date('n', strtotime("-1 months"));
//				$data['yearn'] = date('Y', strtotime("-1 months"));
//			}
//		}
        $user_name = strtolower($this->uri->segment(3));
        if ($user_name !=FALSE && $user_name !="" && in_array($user_name, $action) == 0) {
            $where .= " AND use_username = '".$user_name."'";
            $data['user_name'] = $user_name;
        }

        #If search
        if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
        {
            $keyword = $getVar['keyword'];
            switch(strtolower($getVar['search']))
            {
                case 'username':
                    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'].'/filter/hoahongthang/key/'.$getVar['key'];
                    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'].'/filter/hoahongthang/key/'.$getVar['key'];
                    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
                case 'fullname':
                    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
                    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
                    $where .= "use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
                    break;
            }
            $sortUrl .= '/filter/hoahongthang/key/'.$getVar['key'];
            $pageUrl .= '/filter/hoahongthang/key/'.$getVar['key'];
            $date = strtolower($getVar['key']);
            $daten = date('n', $date);
            $data['monthn'] = $daten;
            $data['yearn'] = date('Y', $date);
            $date = date('m-Y', $date);
            $where .= "AND tbtt_commission.commission_month = '".$date."'";
        }
        #If filter
        elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
        {
            $sortUrl.= '/filter/hoahongthang/key/'.$getVar['key'];
            $pageUrl.= '/filter/hoahongthang/key/'.$getVar['key'];
            $date = strtolower($getVar['key']);
            $daten = date('n', $date);
            $data['monthn'] = $daten;
            $data['yearn'] = date('Y', $date);
            $date = date('m-Y', $date);
            $where .= "tbtt_commission.commission_month = '".$date."'";
        }

		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'ground':
					$pageUrl .= '/sort/ground';
					$sort .= "gro_name";
					break;
				case 'username':
					$pageUrl .= '/sort/username';
					$sort .= "use_username";
					break;
				case 'fullname':
					$pageUrl .= '/sort/fullname';
					$sort .= "use_fullname";
					break;
				case 'parentuse':
					$pageUrl .= '/sort/parentuse';
					$sort .= "use_username_parent";
					break;
				case 'commission':
					$pageUrl .= '/sort/commission';
					$sort .= "commission";
					break;
				case 'status':
					$pageUrl .= '/sort/status';
					$sort .= "payment_status";
					break;
				case 'date':
					$pageUrl .= '/sort/date';
					$sort .= "created_date";
					break;

				default:
					$pageUrl .= '/sort/id';
					$sort .= "id";
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
		$data['sortUrl'] = base_url().'administ/commission/'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/commission/'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
					$this->contact_model->update(array('con_status'=>1), "con_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
					$this->contact_model->update(array('con_status'=>0), "con_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		#Fetch record
		$select = "tbtt_commission.id, tbtt_commission.user_id, tbtt_commission.group_id, tbtt_commission.parent_id, tbtt_commission.created_date, tbtt_commission.commission, tbtt_commission.description, tbtt_commission.commission_month, tbtt_commission.payment_status, tbtt_commission.payment_date, tbtt_commission.type, tbtt_commission.status, tbtt_user.use_id, tbtt_user.use_username, tbtt_user.use_fullname, tbtt_group.gro_name, tbtt_commission_type.text, (SELECT tbtt_user.use_username  FROM tbtt_user WHERE tbtt_user.use_id = tbtt_commission.parent_id) as use_username_parent, (SELECT tbtt_user.use_id  FROM tbtt_user WHERE tbtt_user.use_id = tbtt_commission.parent_id) as id_username_parent";
		$table1 = "tbtt_user";
		$jon1 = "INNER";
		$on1 = "tbtt_user.use_id = tbtt_commission.user_id";
		$table2 = "tbtt_commission_type";
		$jon2 = "INNER";
		$on2 = "tbtt_commission_type.id = tbtt_commission.type";
		$table3 = "tbtt_group";
		$jon3 = "INNER";
		$on3 = "tbtt_group.gro_id = tbtt_commission.group_id";
		//$limit = settingOtherAdmin;
		$limit = 20;
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->commission_model->fetch_join($select, $jon1 , $table1, $on1, $jon2, $table2, $on2, $jon3, $table3, $on3, $where, '', ''));
		$config['base_url'] = base_url().'administ/commission'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$data['commission'] = $this->commission_model->fetch_join($select, $jon1 , $table1, $on1, $jon2, $table2, $on2, $jon3, $table3, $on3, $where, $sort, $by, $start, $limit);
		//print_r($this->db->last_query());
		#Load view
		$this->load->view('admin/commission/commission', $data);
	}
}