<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Manufacturer extends CI_Controller
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
		$this->lang->load('admin/manufacturer');
		#Load model
		$this->load->model('manufacturer_model');
	}
	
	function index()
	{
			
        #BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'manufacturer_delete'))
			{
    			show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
		
			#END CHECK PERMISSION
			$this->load->library('file');
			$this->load->model('product_model');
			$this->load->model('product_favorite_model');
			$this->load->model('product_comment_model');
			$this->load->model('product_bad_model');
			$this->load->model('ads_model');
			$this->load->model('ads_favorite_model');
			$this->load->model('ads_comment_model');
			$this->load->model('ads_bad_model');
			$this->load->model('shop_model');
			$this->load->model('showcart_model');
			$this->load->model('menu_model');
			$idManufacturer = $this->input->post('checkone');
			$listIdManufacturer = implode(',', $idManufacturer);
			
			$this->manufacturer_model->delete($idManufacturer, "man_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
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
				    $where .= "man_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					
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
				    $where .= "man_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "man_status = 0";
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
				    $sort .= "man_name";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "man_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort .= "man_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "man_id";
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
		$data['sortUrl'] = base_url().'administ/manufacturer'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/manufacturer'.$statusUrl;
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
				    $menuCat = $this->manufacturer_model->get("man_id_category", "man_id = ".(int)$getVar['id']);
				    if(count($menuCat) == 1 && $this->check->is_id($getVar['id']))
				    {
                        $this->load->model('manufacturer_model');
                        if($this->manufacturer_model->update(array('man_status'=>1), "man_id = ".(int)$menuCat->man_id_category))
                        {
					    	$this->manufacturer_model->update(array('man_status'=>1), "man_id = ".(int)$getVar['id']);
					    }
				    }
					break;
				case 'deactive':
				    $this->manufacturer_model->update(array('man_status'=>0), "man_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->manufacturer_model->fetch_join($select, "LEFT", "tbtt_category", "tbtt_manufacturer.man_id_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit));
        $config['base_url'] = base_url().'administ/manufacturer'.$pageUrl.'/page/';
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
		$select = "man_id,man_name,man_descr,man_order,man_status,man_id_category,cat_name";
		$limit = settingOtherAdmin;
		//var_dump($where);die();	
		$data['category_man'] =  $this->manufacturer_model->fetch_join($select, "LEFT", "tbtt_category", "tbtt_manufacturer.man_id_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);	
		
		$this->load->view('admin/manufacturer/defaults', $data);
	}
	
	function loadManuFacTuRer($parent, $level,&$retArray, $where, $sort, $by, $start, $limit)
	{
		$select = "man_id,man_name,man_descr,man_order,man_status,man_id_category";
		$whereTmp = "";		
		$category  = $this->manufacturer_model->fetch_join($select, $whereTmp, $sort, $by, $start, $limit,"");
	
	}
	
	
	
	
	function loadCategory($parent, $level,&$retArray, $where, $sort, $by, $start, $limit)
	{
		$select = "*";
		$whereTmp = "";
		if(strlen($where)>0){
			$whereTmp .= $where." and man_id_category ='$parent' ";
		}else{
			$whereTmp .= $where."man_id_category ='$parent'";
		}
		$category  = $this->manufacturer_model->fetch($select, $whereTmp, $sort, $by, $start, $limit);
	

	   foreach ($category as $row)
	   {
		     
		   $row->man_name = str_repeat('-',$level)." ".$row->man_name;
		   $retArray[] = $row;
	       $this->loadCategory($row->man_id, $level+1,$retArray, $where, $sort, $by, $start, $limit); // edit by nganly &
	
	   }
	
	   
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
				
		$this->load->model('category_model');	
					 $cat_level_0 = $this->category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
						if(isset($cat_level_0)){
							foreach($cat_level_0 as $key=>$item){
								$cat_level_1 = $this->category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
								$cat_level_0[$key]->child_count = count($cat_level_1);
							}
						}
						$data['catlevel0']=$cat_level_0;
						$maxorder = $this->category_model->get("max(cat_order) as maxorder");
						$data['next_order'] = (int)$maxorder->maxorder+1;						
						$maxindex = $this->category_model->get("max(cat_index) as maxindex");
						$data['next_index'] = (int)$maxindex->maxindex+1;
						
						
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
			
			
              $this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_manufacturer', 'lang:name_label_add', 'trim|required|callback__exist_category');
            //$this->form_validation->set_rules('descr_manufacturer', 'lang:descr_label_add', 'trim|required');       
            $this->form_validation->set_rules('order_manufacturer', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                if($this->input->post('active_manufacturer') == '1')
				{
	                $active_manufacturer = 1;
				}
				else
				{
	                $active_manufacturer = 0;
				}				
				$dataAdd = array(
				                    'man_name'      	=>      $this->input->post('name_manufacturer'),
				                    'man_descr'      	=>    $this->input->post('descr_manufacturer'),				                   
				                    'man_order'         =>      (int)$this->input->post('order_manufacturer'),						
	                                'man_status'      	=> (int)$active_manufacturer,
									'man_id_category'      	=>    (int)$this->input->post('hd_category_id')
									);
									
				if($this->manufacturer_model->add($dataAdd))
				{
					
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/manufacturer/add', 'location');
			}
			else
	        {
				$data['name_manufacturer'] = $this->input->post('name_manufacturer');
				$data['descr_manufacturer'] = $this->input->post('descr_manufacturer');
				$data['order_manufacturer'] = $this->input->post('order_manufacturer');
				$data['active_manufacturer'] = $this->input->post('active_manufacturer');				
	        }
        }
		$retArray = array();
		 $this->display_child(0, 0,$retArray);
		
		$data['parents']  = $retArray;
		
		#Load view
		$this->load->view('admin/manufacturer/add', $data);
	}
	
	function edit($id)
	{
		
		$this->load->model('category_model');	
					 $cat_level_0 = $this->category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
						if(isset($cat_level_0)){
							foreach($cat_level_0 as $key=>$item){
								$cat_level_1 = $this->category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
								$cat_level_0[$key]->child_count = count($cat_level_1);
							}
						}
						$data['catlevel0']=$cat_level_0;
						$maxorder = $this->category_model->get("max(cat_order) as maxorder");
						$data['next_order'] = (int)$maxorder->maxorder+1;						
						$maxindex = $this->category_model->get("max(cat_index) as maxindex");
						$data['next_index'] = (int)$maxindex->maxindex+1;
						
		$this->load->model('ads_model');
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
			$category = $this->manufacturer_model->get("*", "man_id = ".(int)$id);
			if(count($category) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/manufacturer', 'location');
				die();
			}
			#END Get category by $id
			#BEGIN: Load image category
            $this->load->library('file');
			
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('name_manufacturer', 'lang:descr_label_edit', 'trim|required');         
            $this->form_validation->set_rules('order_manufacturer', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if($category->man_name != trim($this->filter->injection_html($this->input->post('name_manufacturer'))))
            {
                $this->form_validation->set_rules('name_manufacturer', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            }
            else
            {
                $this->form_validation->set_rules('name_manufacturer', 'lang:name_label_edit', 'trim|required');
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
                if($this->input->post('active_manufacturer') == '1')
				{
	                $active_manufacturer = 1;
				}
				else
				{
	                $active_manufacturer = 0;
				}
				$dataEdit = array(
				                    'man_name'      	=>      $this->input->post('name_manufacturer'),
				                    'man_descr'      	=>    $this->input->post('descr_manufacturer'),				                   
				                    'man_order'         =>      (int)$this->input->post('order_manufacturer'),						
	                                'man_status'      	=>     (int)$active_manufacturer,
									'man_id_category'      	=>    (int)$this->input->post('hd_category_id') 
									);
				if($this->manufacturer_model->update($dataEdit, "man_id = ".(int)$id))
				{
					
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}				
				redirect(base_url().'administ/manufacturer', 'location');
			}
			else
	        {
				$data['name_manufacturer'] = $category->man_name;
				$data['descr_manufacturer'] = $category->man_descr;			
				$data['order_manufacturer'] = $category->man_order;
				$data['active_manufacturer'] = $category->man_status;
				$data['parent_id'] = $category->man_id_category;
					$cat_parent = $this->category_model->get("*", "cat_id = ".(int)$category->man_id_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);										
							$get_category_leve1=$this->category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);										
							$cat_lavel_1_temp=$this->category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
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
								$cat_lavel_1_temp=$this->category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								
								$data['cat_level_1'] = $cat_lavel_1_temp;					
								
								$get_category_leve1=$this->category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
								
								$data['cat_parent_parent_0']=$cat_parent;
								
							}
							
							
						}
						
	        }
        }
		$retArray = array();
		 $this->display_child(0, 0,$retArray); 		
		$data['parents']  = $retArray;		
		$this->load->view('admin/manufacturer/edit', $data);
		
	}
	
	function ajax_category_shop(){
	
		$this->load->model('category_model');
		$parent_id = (int)$this->input->post('parent_id');

		$cat_level = $this->category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");

		if(isset($cat_level)){

			foreach($cat_level as $key=>$item){

				$cat_level_next = $this->category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");

				$cat_level[$key]->child_count = count($cat_level_next);

			}

		}

		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();

	}
	
	
	function _exist_category()
	{
        if(count($this->manufacturer_model->get("man_id", "man_name = '".trim($this->filter->injection_html($this->input->post('name_category')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	function display_child($parent, $level,&$retArray)
	{
	   $sql = "SELECT * from `tbtt_category` WHERE parent_id='$parent' order by cat_order";
		
	   $query = $this->db->query($sql);
	


	   foreach ($query->result_array() as $row)
	   {
		     
		   $object = new StdClass;
		   $object->cat_id = $row['cat_id'];
		   $object->cat_name =str_repeat('-',$level)." ".$row['cat_name'];
	
		   $retArray[] = $object;
	       $this->display_child($row['cat_id'], $level+1,$retArray);
		   //edit by nganly
	
	   }
	
	   
	}
}