<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class District extends CI_Controller
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
		$this->lang->load('admin/district');
		#Load model
		$this->load->model('district_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'district_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->district_model->delete($this->input->post('checkone'), "id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'district_view'))
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
				    $where .= "DistrictName LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $sort .= "DistrictName";
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
		$data['sortUrl'] = base_url().'administ/district'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort

		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/district'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'district_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->district_model->update(array('pre_status'=>1), "id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->district_model->update(array('pre_status'=>0), "id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->district_model->fetch("id", $where, "", ""));
        $config['base_url'] = base_url().'administ/district'.$pageUrl.'/page/';
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
		$data['district'] = $this->district_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/district/defaults', $data);
	}
	
	function add()
	{
                #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'district_add'))
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
                        $this->load->model('province_model');
                        $data['province_list'] = $this->province_model->fetch('pre_id,pre_name', '', '');
                        $data['successAdd'] = false;
			$this->load->library('form_validation');
			#BEGIN: Set rules
                        $this->form_validation->set_rules('name_district', 'lang:name_label_add', 'trim|required|callback__exist_district');
                        //$this->form_validation->set_rules('order_district', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_district', $this->lang->line('_exist_district_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() == TRUE)
			{
                                if($this->input->post('active_district') == '1')
				{
                                    $active_district = 1;
				}
				else
				{
                                    $active_district = 0;
				}
                                $this->load->model('province_model');
                                $province_name = $this->province_model->get('pre_name','pre_id = '.$this->input->post('province'));
				$dataAdd = array(
                                        'DistrictName'      	=>      trim($this->filter->injection_html($this->input->post('name_district'))),
                                        'DistrictCode'          =>      $this->input->post('districtCode'),
                                        'ProvinceCode'          =>      $this->input->post('province'),
                                        'ProvinceName'          =>      $province_name->pre_name,
                                        'Type'                  =>      1,
                                        'SupportType'           =>      3,
	                                'pre_status'      	=>      $active_district
									);
				if($this->district_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/district/add', 'location');
			}
			else
                        {
                                        $data['name_district'] = $this->input->post('name_district');
                                        $data['order_district'] = $this->input->post('order_district');
                                        $data['active_district'] = $this->input->post('active_district');
                        }
                }
		#Load view
		$this->load->view('admin/district/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'district_edit'))
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
            #BEGIN: Get district by $id
                $district = $this->district_model->get("*", "id = ".(int)$id);
                if(count($district) != 1 || !$this->check->is_id($id))
                {
                        redirect(base_url().'administ/district', 'location');
                        die();
                }
                
			#END Get district by $id
                $this->load->library('form_validation');
			#BEGIN: Set rules
                if($district->DistrictName != trim($this->filter->injection_html($this->input->post('name_district'))))
                {
                    $this->form_validation->set_rules('name_district', 'lang:name_label_edit', 'trim|required|callback__exist_district');
                }
                else
                {
                    $this->form_validation->set_rules('name_district', 'lang:name_label_edit', 'trim|required');
                }
                
                #END Set rules
                #BEGIN: Set message
                $this->form_validation->set_message('required', $this->lang->line('required_message'));
                //$this->form_validation->set_message('_exist_district', $this->lang->line('_exist_district_message_edit'));
                $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
                #END Set message

                if($this->form_validation->run() != FALSE)
                {
                        if($this->input->post('active_district') == '1')
                        {
                            $active_district = 1;
                        }
                        else
                        {
                            $active_district = 0;
                        }
                        
                        $dataEdit = array(
                                'DistrictName'      	=>      trim($this->filter->injection_html($this->input->post('name_district'))),
                                'pre_status'      	=>      $active_district
                                                                );
                        if($this->district_model->update($dataEdit, "id = ".(int)$id))
                        {
                        $this->session->set_flashdata('sessionSuccessEdit', 1);
                        }
                        redirect(base_url().'administ/district/edit/'.$id, 'location');
                }
                else
	        {
				$data['name_district'] = $district->DistrictName;
				$data['order_district'] = $district->pre_order;
				$data['active_district'] = $district->pre_status;
	        }
        }
		#Load view
		$this->load->view('admin/district/edit', $data);
	}
	
	function _exist_district()
	{
                if(count($this->district_model->get("id", "DistrictName = '".trim($this->filter->injection_html($this->input->post('name_district')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
}