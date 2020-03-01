<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Field extends CI_Controller
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
		$this->lang->load('admin/field');
		#Load model
		$this->load->model('field_model');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'field_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('job_model');
			$this->load->model('job_favorite_model');
			$this->load->model('job_bad_model');
			$this->load->model('employ_model');
			$this->load->model('employ_favorite_model');
			$this->load->model('employ_bad_model');
			$idField = $this->input->post('checkone');
			$listIdField = implode(',', $idField);
			#Get id job
			$job = $this->job_model->fetch("job_id", "job_field IN($listIdField)", "", "");
			$idJob = array();
			foreach($job as $jobArray)
			{
				$idJob[] = $jobArray->job_id;
			}
			#Get id employ
			$employ = $this->employ_model->fetch("emp_id", "emp_field IN($listIdField)", "", "");
			$idEmploy = array();
			foreach($employ as $employArray)
			{
				$idEmploy[] = $employArray->emp_id;
			}
			#Delete job
			if(count($idJob) > 0)
			{
                $this->job_favorite_model->delete($idJob, "jof_job");
                $this->job_bad_model->delete($idJob, "jba_job");
			}
			$this->job_model->delete($idField, "job_field");
			#Delete employ
			if(count($idEmploy) > 0)
			{
                $this->employ_favorite_model->delete($idEmploy, "emf_employ");
                $this->employ_bad_model->delete($idEmploy, "emb_employ");
			}
			$this->employ_model->delete($idField, "emp_field");
			#Delete field
			$this->field_model->delete($idField, "fie_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'field_view'))
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
				    $where .= "fie_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "fie_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "fie_status = 0";
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
				    $sort .= "fie_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "fie_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "fie_id";
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
		$data['sortUrl'] = base_url().'administ/field'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/field'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'field_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->field_model->update(array('fie_status'=>1), "fie_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->field_model->update(array('fie_status'=>0), "fie_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->field_model->fetch("fie_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/field'.$pageUrl.'/page/';
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
		if($this->uri->segment(2)=='field' && $this->uri->segment(3)==''){
			$this->db->order_by("fie_order", "ASC"); 
		}
		$data['field'] = $this->field_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/field/defaults', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'field_add'))
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
            #BEGIN: Load image field
            $this->load->library('file');
			$imageField = $this->field_model->fetch("fie_image", "", "", "");
			$usedImage = array();
			foreach($imageField as $imageFieldArray)
			{
				$usedImage[] = $imageFieldArray->fie_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = $this->file->load('templates/home/images/field', $usedImage);
            #END Load image field
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_field', 'lang:name_label_add', 'trim|required|callback__exist_field');
            //$this->form_validation->set_rules('descr_field', 'lang:descr_label_add', 'trim|required');
            //$this->form_validation->set_rules('image_field', 'lang:image_label_add', 'required');
            $this->form_validation->set_rules('order_field', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_field', $this->lang->line('_exist_field_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_field') == '1')
				{
	                $active_field = 1;
				}
				else
				{
	                $active_field = 0;
				}
				$dataAdd = array(
				                    'fie_name'      	=>      trim($this->filter->injection_html($this->input->post('name_field'))),
				                    'fie_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_field')))),
				                    'fie_image'			=>      $this->filter->injection($this->input->post('image_field')),
				                    'fie_order'         =>      (int)$this->input->post('order_field'),
	                                'fie_status'      	=>      $active_field,
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag')
									);
				if($this->field_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/field/add', 'location');
			}
			else
	        {
				$data['name_field'] = $this->input->post('name_field');
				$data['descr_field'] = $this->input->post('descr_field');
				$data['image_field'] = $this->input->post('image_field');
				$data['order_field'] = $this->input->post('order_field');
				$data['active_field'] = $this->input->post('active_field');
				$data['keyword'] = $this->input->post('keyword');
				$data['h1tag'] = $this->input->post('h1tag');
	        }
        }
		#Load view
		$this->load->view('admin/field/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'field_edit'))
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
            #BEGIN: Get field by $id
			$field = $this->field_model->get("*", "fie_id = ".(int)$id);
			if(count($field) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/field', 'location');
				die();
			}
			#END Get field by $id
            #BEGIN: Load image field
            $this->load->library('file');
			$imageField = $this->field_model->fetch("fie_image", "", "", "");
			$usedImage = array();
			foreach($imageField as $imageFieldArray)
			{
				$usedImage[] = $imageFieldArray->fie_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = array_merge($this->file->load('templates/home/images/field', $usedImage), array($field->fie_image));
            #END Load image field
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_field', 'lang:descr_label_edit', 'trim|required');
           // $this->form_validation->set_rules('image_field', 'lang:image_label_edit', 'required');
            //$this->form_validation->set_rules('order_field', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($field->fie_name != trim($this->filter->injection_html($this->input->post('name_field'))))
            {
                $this->form_validation->set_rules('name_field', 'lang:name_label_edit', 'trim|required|callback__exist_field');
            }
            else
            {
                $this->form_validation->set_rules('name_field', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_field', $this->lang->line('_exist_field_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_field') == '1')
				{
	                $active_field = 1;
				}
				else
				{
	                $active_field = 0;
				}
				$dataEdit = array(
				                    'fie_name'      	=>      trim($this->filter->injection_html($this->input->post('name_field'))),
				                    'fie_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_field')))),
				                    'fie_image'			=>      $this->filter->injection($this->input->post('image_field')),
				                    'fie_order'         =>      (int)$this->input->post('order_field'),
	                                'fie_status'      	=>      $active_field,
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag')
									);
				if($this->field_model->update($dataEdit, "fie_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/field/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_field'] = $field->fie_name;
				$data['descr_field'] = $field->fie_descr;
				$data['image_field'] = $field->fie_image;
				$data['order_field'] = $field->fie_order;
				$data['active_field'] = $field->fie_status;
				$data['keyword'] = $field->keyword;
				$data['h1tag'] = $field->h1tag;
	        }
        }
		#Load view
		$this->load->view('admin/field/edit', $data);
	}
	
	function _exist_field()
	{
        if(count($this->field_model->get("fie_id", "fie_name = '".trim($this->filter->injection_html($this->input->post('name_field')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
}