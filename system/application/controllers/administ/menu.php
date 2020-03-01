<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Menu extends CI_Controller
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
		$this->lang->load('admin/menu');
	}
	
	function index()
	{
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'menu_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->menu_model->delete($this->input->post('checkone'), "men_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'menu_view'))
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
				    $where .= "men_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
	
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "men_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "men_status = 0";
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
				    $sort .= "men_name";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "men_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "men_id";
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
		$data['sortUrl'] = base_url().'administ/menu'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/menu'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'menu_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $menuCat = $this->menu_model->get("men_category", "men_id = ".(int)$getVar['id']);
				    if(count($menuCat) == 1 && $this->check->is_id($getVar['id']))
				    {
                        $this->load->model('category_model');
                        if($this->category_model->update(array('cat_status'=>1), "cat_id = ".(int)$menuCat->men_category))
                        {
					    	$this->menu_model->update(array('men_status'=>1), "men_id = ".(int)$getVar['id']);
					    }
				    }
					break;
				case 'deactive':
				    $this->menu_model->update(array('men_status'=>0), "men_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->menu_model->fetch_join("men_id", "LEFT", "tbtt_category", "tbtt_menu.men_category = tbtt_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/menu'.$pageUrl.'/page/';
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
		$select = "men_id, men_name, men_descr, men_image, men_category, men_order, men_status, cat_id, cat_name";
		$limit = settingOtherAdmin;
		$data['menu'] = $this->menu_model->fetch_join($select, "LEFT", "tbtt_category", "tbtt_menu.men_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/menu/defaults', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'menu_add'))
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
            #BEGIN: Load image menu
            $this->load->library('file');
			$imageMenu = $this->menu_model->fetch("men_image", "", "", "");
			$usedImage = array();
			foreach($imageMenu as $imageMenuArray)
			{
				$usedImage[] = $imageMenuArray->men_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = $this->file->load('templates/home/images/menu', $usedImage);
            #END Load image menu
            #BEGIN: Load category
            $this->load->model('category_model');
            $categoryMenu = $this->menu_model->fetch("men_category", "", "", "");
            $idCategory = array();
            foreach($categoryMenu as $categoryMenuArray)
            {
				$idCategory[] = $categoryMenuArray->men_category;
            }
            if(count($idCategory) > 0)
            {
                $idCategory = implode(',', $idCategory);
                $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_id NOT IN($idCategory)", "cat_order", "ASC");
            }
            else
            {
                $data['category'] = $this->category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            }
            #END Load category
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_menu', 'lang:name_label_add', 'trim|required|callback__exist_menu');
            $this->form_validation->set_rules('descr_menu', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('category_menu', 'lang:category_label_add', 'required|callback__exist_category');
            //$this->form_validation->set_rules('image_menu', 'lang:image_label_add', 'required');
            $this->form_validation->set_rules('order_menu', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_menu', $this->lang->line('_exist_menu_message_add'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_menu') == '1')
				{
	                $active_menu = 1;
				}
				else
				{
	                $active_menu = 0;
				}
				$dataAdd = array(
				                    'men_name'      	=>      trim($this->filter->injection_html($this->input->post('name_menu'))),
				                    'men_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_menu')))),
				                    'men_image'			=>      $this->filter->injection($this->input->post('image_menu')),
				                    'men_category'     	=>      (int)$this->input->post('category_menu'),
				                    'men_order'         =>      (int)$this->input->post('order_menu'),
	                                'men_status'      	=>      $active_menu
									);
				if($this->menu_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/menu/add', 'location');
			}
			else
	        {
				$data['name_menu'] = $this->input->post('name_menu');
				$data['descr_menu'] = $this->input->post('descr_menu');
				$data['image_menu'] = $this->input->post('image_menu');
				$data['category_menu'] = $this->input->post('category_menu');
				$data['order_menu'] = $this->input->post('order_menu');
				$data['active_menu'] = $this->input->post('active_menu');
	        }
        }
		#Load view
		$this->load->view('admin/menu/add', $data);
	}
	
	function edit($id)
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'menu_edit'))
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
            #BEGIN: Get menu by $id
			$menu = $this->menu_model->get("*", "men_id = ".(int)$id);
			if(count($menu) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/menu', 'location');
				die();
			}
			#END Get menu by $id
            #BEGIN: Load image menu
            $this->load->library('file');
			$imageMenu = $this->menu_model->fetch("men_image", "", "", "");
			$usedImage = array();
			foreach($imageMenu as $imageMenuArray)
			{
				$usedImage[] = $imageMenuArray->men_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = array_merge($this->file->load('templates/home/images/menu', $usedImage), array($menu->men_image));
            #END Load image menu
            #BEGIN: Load category
            $this->load->model('category_model');
            $thisCategoryMenu = $menu->men_category;
            $categoryMenu = $this->menu_model->fetch("men_category", "men_category != $thisCategoryMenu", "", "");
            $idCategory = array();
            foreach($categoryMenu as $categoryMenuArray)
            {
				$idCategory[] = $categoryMenuArray->men_category;
            }
            if(count($idCategory) > 0)
            {
                $idCategory = implode(',', $idCategory);
                $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_id NOT IN($idCategory)", "cat_order", "ASC");
            }
            else
            {
                $data['category'] = $this->category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            }
            #END Load category
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('descr_menu', 'lang:descr_label_edit', 'trim|required');
            //$this->form_validation->set_rules('image_menu', 'lang:image_label_edit', 'required');
            $this->form_validation->set_rules('order_menu', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($menu->men_name != trim($this->filter->injection_html($this->input->post('name_menu'))))
            {
                $this->form_validation->set_rules('name_menu', 'lang:name_label_edit', 'trim|required|callback__exist_menu');
            }
            else
            {
                $this->form_validation->set_rules('name_menu', 'lang:name_label_edit', 'trim|required');
            }
            if($menu->men_category != (int)$this->input->post('category_menu'))
            {
                $this->form_validation->set_rules('category_menu', 'lang:category_label_edit', 'required|callback__exist_category');
            }
            else
            {
                $this->form_validation->set_rules('category_menu', 'lang:category_label_edit', 'required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_menu', $this->lang->line('_exist_menu_message_edit'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_menu') == '1')
				{
	                $active_menu = 1;
				}
				else
				{
	                $active_menu = 0;
				}
				$dataEdit = array(
				                    'men_name'      	=>      trim($this->filter->injection_html($this->input->post('name_menu'))),
				                    'men_descr'      	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_menu')))),
				                    'men_image'			=>      $this->filter->injection($this->input->post('image_menu')),
				                    'men_category'     	=>      (int)$this->input->post('category_menu'),
				                    'men_order'         =>      (int)$this->input->post('order_menu'),
	                                'men_status'      	=>      $active_menu
									);
				if($this->menu_model->update($dataEdit, "men_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/menu/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_menu'] = $menu->men_name;
				$data['descr_menu'] = $menu->men_descr;
				$data['image_menu'] = $menu->men_image;
				$data['category_menu'] = $menu->men_category;
				$data['order_menu'] = $menu->men_order;
				$data['active_menu'] = $menu->men_status;
	        }
        }
		#Load view
		$this->load->view('admin/menu/edit', $data);
	}
	
	function _exist_menu()
	{
        if(count($this->menu_model->get("men_id", "men_name = '".trim($this->filter->injection_html($this->input->post('name_menu')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_category()
	{
        if(count($this->menu_model->get("men_id", "men_category = '".(int)$this->input->post('category_menu')."'")) > 0)
		{
			return false;
		}
		return true;
	}
}