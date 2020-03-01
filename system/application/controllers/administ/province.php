<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Province extends CI_Controller
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
		$this->lang->load('admin/province');
		#Load model
		$this->load->model('province_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->province_model->delete($this->input->post('checkone'), "pre_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_view'))
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
				    $where .= "pre_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "pre_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "pre_status = 0";
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
				    $sort .= "pre_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "pre_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "pre_id";
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
		$data['sortUrl'] = base_url().'administ/province'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort

		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/province'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->province_model->update(array('pre_status'=>1), "pre_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->province_model->update(array('pre_status'=>0), "pre_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->province_model->fetch("pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/province'.$pageUrl.'/page/';
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
		$data['province'] = $this->province_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/province/defaults', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_add'))
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
            $this->form_validation->set_rules('name_province', 'lang:name_label_add', 'trim|required|callback__exist_province');
            $this->form_validation->set_rules('order_province', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_province') == '1')
				{
	                $active_province = 1;
				}
				else
				{
	                $active_province = 0;
				}
				$dataAdd = array(
				                    'pre_name'      	=>      trim($this->filter->injection_html($this->input->post('name_province'))),
				                    'pre_order'         =>      (int)$this->input->post('order_province'),
	                                'pre_status'      	=>      $active_province
									);
				if($this->province_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/province/add', 'location');
			}
			else
	        {
				$data['name_province'] = $this->input->post('name_province');
				$data['order_province'] = $this->input->post('order_province');
				$data['active_province'] = $this->input->post('active_province');
	        }
        }
		#Load view
		$this->load->view('admin/province/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'province_edit'))
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
            #BEGIN: Get province by $id
			$province = $this->province_model->get("*", "pre_id = ".(int)$id);
			if(count($province) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/province', 'location');
				die();
			}
			#END Get province by $id
			$this->load->library('form_validation');
			#BEGIN: Set rules
            if($province->pre_name != trim($this->filter->injection_html($this->input->post('name_province'))))
            {
                $this->form_validation->set_rules('name_province', 'lang:name_label_edit', 'trim|required|callback__exist_province');
            }
            else
            {
                $this->form_validation->set_rules('name_province', 'lang:name_label_edit', 'trim|required');
            }
            $this->form_validation->set_rules('order_province', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_province') == '1')
				{
	                $active_province = 1;
				}
				else
				{
	                $active_province = 0;
				}
				$dataEdit = array(
				                    'pre_name'      	=>      trim($this->filter->injection_html($this->input->post('name_province'))),
				                    'pre_order'         =>      (int)$this->input->post('order_province'),
	                                'pre_status'      	=>      $active_province
									);
				if($this->province_model->update($dataEdit, "pre_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/province/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_province'] = $province->pre_name;
				$data['order_province'] = $province->pre_order;
				$data['active_province'] = $province->pre_status;
	        }
        }
		#Load view
		$this->load->view('admin/province/edit', $data);
	}
	
	function _exist_province()
	{
        if(count($this->province_model->get("pre_id", "pre_name = '".trim($this->filter->injection_html($this->input->post('name_province')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
}