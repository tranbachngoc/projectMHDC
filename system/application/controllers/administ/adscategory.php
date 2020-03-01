<?php
#****************************************#
# * @Author: tuannguyen                  #
# * @Email: tuannguyen@icsc.vn           #
# * @Website: http://www.icsc.vn         #
# * @Copyright: 2008 - 2012              #
#****************************************#
class Adscategory extends CI_Controller
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
		$this->lang->load('admin/category');
		#Load model
		$this->load->model('ads_category_model');
	}
	function index(){
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view'))
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
		$sort = 'cat_index';
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
		$data['sortUrl'] = base_url().'administ/adscategory'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/adscategory'.$statusUrl;
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
				    $this->ads_category_model->update(array('cat_status'=>1), "cat_id = ".(int)$getVar['id']);
				    //$this->menu_model->update(array('men_status'=>1), "men_category = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->ads_category_model->update(array('cat_status'=>0), "cat_id = ".(int)$getVar['id']);
				    //$this->menu_model->update(array('men_status'=>0), "men_category = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/adscategory'.$pageUrl.'/page/';
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
		//$limit = settingOtherAdmin;
		$retArray = array();
		$this->loadCategory2(0,0,$retArray, $where, "cat_order","ASC");
		
		$data['category'] = $retArray;		
		//print_r($retArray);die();	
		#Load view
		$this->load->view('admin/ads/category', $data);
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
		$category  = $this->ads_category_model->fetch($select, $whereTmp);
		
	   foreach ($category as $row)
	   {
		     	
		   $row->cat_name = $row->cat_name;
		   $retArray[] = $row;
		
	       $this->loadCategory2($row->cat_id, $level+1,$retArray);
		   //edit by nganly
	
	   }
	 
	   
	}
	
	
	
	function add()
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
			$imageCategory = $this->ads_category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = $this->file->load('templates/home/images/category', $usedImage);
			#Begin: Category hoi dap
			$cat_level_0 = $this->ads_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->ads_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			$maxorder = $this->ads_category_model->get("max(cat_order) as maxorder");
			$data['next_order'] = (int)$maxorder->maxorder+1;
			
			$maxindex = $this->ads_category_model->get("max(cat_index) as maxindex");
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
				if($this->ads_category_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/adscategory/add', 'location');
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
		$this->load->view('admin/ads/add', $data);
	}
	function edit($id)
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
			$category = $this->ads_category_model->get("*", "cat_id = ".(int)$id);
			if(count($category) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/hoidap/cat', 'location');
				die();
			}
			#END Get category by $id
			#BEGIN: Load image category
            $this->load->library('file');
			$imageCategory = $this->ads_category_model->fetch("cat_image", "", "", "");
			$usedImage = array();
			foreach($imageCategory as $imageCategoryArray)
			{
				$usedImage[] = $imageCategoryArray->cat_image;
			}
			$usedImage = array_merge($usedImage, array('index.html'));
			$data['image'] = array_merge($this->file->load('templates/home/images/category', $usedImage), array($category->cat_image));
            #END Load image category
			#Begin: Category hoi dap
			$cat_parent = $this->ads_category_model->get("*", "cat_id = ".(int)$category->parent_id);
			if(isset($cat_parent)){
				if($cat_parent->parent_id == 0)
				{
					$data['parent_id_0'] = $category->parent_id;
				}
				else
				{
					$data['parent_id_0'] = $cat_parent->parent_id;
					$data['parent_id_1'] = $category->parent_id;
					$cat_level_1 = $this->ads_category_model->fetch("*","parent_id = ".$cat_parent->parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
					$data['catlevel1']=$cat_level_1;
				}
			}
			$cat_level_0 = $this->ads_category_model->fetch("*","parent_id = 0 AND cat_status = 1 AND cat_id != ".$id, "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->ads_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			$maxindex = $this->ads_category_model->get("max(cat_index) as maxindex");
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
									 'cat_level'      	=>      $this->input->post('cat_level')  ,
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag') 
									);
				if($this->ads_category_model->update($dataEdit, "cat_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				
				if($category->cat_level==0 && (int)$this->input->post('cat_level')==1)
				{
					$this->ads_category_model->update(array('cat_level' => 2), "parent_id  = ".(int)$id);
				}

				redirect(base_url().'administ/adscategory/edit/'.$id, 'location');
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
		$this->load->view('admin/ads/edit', $data);
	}
	function ajax(){
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->ads_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}
}