<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Group extends CI_Controller
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
		$this->lang->load('admin/group');
		#Load model
		$this->load->model('group_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'group_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$idGroup = $this->input->post('checkone');
			foreach($idGroup as $idGroupArray)
			{
				if($idGroupArray == 1 || $idGroupArray == 2 || $idGroupArray == 3 || $idGroupArray == 4)
				{
					redirect(base_url().trim(uri_string(), '/'), 'refresh');
					die();
				}
			}
			$this->load->model('user_model');
			$listIdGroup = implode(',', $idGroup);
			#Get id user
			$user = $this->user_model->fetch("use_id", "use_group IN($listIdGroup)");
			$idUser = array();
			foreach($user as $userArray)
			{
				$idUser[] = $userArray->use_id;
			}
			if(count($idUser) > 0)
			{
				#Delete user
				$this->user_model->delete($idUser, "use_id");
			}
			#Delete group
			$this->group_model->delete($idGroup, "gro_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'group_view'))
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
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= "gro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "gro_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "gro_status = 0";
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
				    $sort .= "gro_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "gro_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "gro_id";
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
		$data['sortUrl'] = base_url().'administ/group'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/group'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'group_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->group_model->update(array('gro_status'=>1), "gro_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->group_model->update(array('gro_status'=>0), "gro_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->group_model->fetch("gro_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/group'.$pageUrl.'/page/';
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
		$select = "gro_id, gro_name, gro_descr, gro_permission, gro_order, gro_status";
		$limit = settingOtherAdmin;
		$data['group'] = $this->group_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/group/defaults', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'group_add'))
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
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_group', 'lang:name_label_add', 'trim|required|callback__exist_group');
            $this->form_validation->set_rules('descr_group', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('order_group', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_group', $this->lang->line('_exist_group_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				if(is_array($this->input->post('permission_group')))
				{
                    $permission_group = implode(',', $this->input->post('permission_group'));
				}
				else
				{
                    $permission_group = 'none';
				}
                if($this->input->post('active_group') == '1')
				{
	                $active_group = 1;
				}
				else
				{
	                $active_group = 0;
				}
				$dataAdd = array(
				                    'gro_name'      	=>      trim($this->filter->injection_html($this->input->post('name_group'))),
				                    'gro_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_group')))),
				                    'gro_permission'	=>      trim($permission_group),
				                    'gro_order'      	=>      (int)$this->input->post('order_group'),
	                                'gro_status'      	=>      $active_group
									);
				if($this->group_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/group/add', 'location');
			}
			else
	        {
				$data['name_group'] = $this->input->post('name_group');
				$data['descr_group'] = $this->input->post('descr_group');
				$data['order_group'] = $this->input->post('order_group');
				if(is_array($this->input->post('permission_group')))
				{
                    $data['permission_group'] = implode(',', $this->input->post('permission_group'));
				}
				else
				{
                    $data['permission_group'] = '';
				}
				$data['active_group'] = $this->input->post('active_group');
	        }
        }
		#Load view
		$this->load->view('admin/group/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'group_edit'))
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
            if((int)$id == 1 || (int)$id == 2 || (int)$id == 3 || (int)$id == 4)
			{
				redirect(base_url().'administ/group', 'refresh');
				die();
			}
            #BEGIN: Get group by $id
			$group = $this->group_model->get("*", "gro_id = ".(int)$id);
			if(count($group) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/group', 'location');
				die();
			}
			#END Get group by $id
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_group', 'lang:descr_label_edit', 'trim|required');
            $this->form_validation->set_rules('order_group', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($group->gro_name != trim($this->filter->injection_html($this->input->post('name_group'))))
            {
                $this->form_validation->set_rules('name_group', 'lang:name_label_edit', 'trim|required|callback__exist_group');
            }
            else
            {
                $this->form_validation->set_rules('name_group', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_group', $this->lang->line('_exist_group_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				if(is_array($this->input->post('permission_group')))
				{
                    $permission_group = implode(',', $this->input->post('permission_group'));
				}
				else
				{
                    $permission_group = 'none';
				}
                if($this->input->post('active_group') == '1')
				{
	                $active_group = 1;
				}
				else
				{
	                $active_group = 0;
				}
				$dataEdit = array(
				                    'gro_name'      	=>      trim($this->filter->injection_html($this->input->post('name_group'))),
				                    'gro_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_group')))),
				                    'gro_permission'	=>      trim($permission_group),
				                    'gro_order'      	=>      (int)$this->input->post('order_group'),
	                                'gro_status'      	=>      $active_group
									);
				if($this->group_model->update($dataEdit, "gro_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/group/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_group'] = $group->gro_name;
				$data['descr_group'] = $group->gro_descr;
				$data['order_group'] = $group->gro_order;
				$data['permission_group'] = $group->gro_permission;
				$data['active_group'] = $group->gro_status;
	        }
        }
		#Load view
		$this->load->view('admin/group/edit', $data);
	}
	
	function _exist_group()
	{
        if(count($this->group_model->get("gro_id", "gro_name = '".trim($this->filter->injection_html($this->input->post('name_group')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
}