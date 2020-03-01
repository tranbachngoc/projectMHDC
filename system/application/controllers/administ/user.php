<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class User extends CI_Controller
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
		$this->lang->load('admin/user');
		#Load model
		
		$this->load->model('user_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_delete'))
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
			$this->load->model('job_model');
			$this->load->model('job_favorite_model');
			$this->load->model('job_bad_model');
			$this->load->model('employ_model');
			$this->load->model('employ_favorite_model');
			$this->load->model('employ_bad_model');
			$this->load->model('shop_model');
			$this->load->model('contact_model');
			$this->load->model('showcart_model');
			$idUser = $this->input->post('checkone');
			$listIdUser = implode(',', $idUser);
			#Get id product
			$product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_user IN($listIdUser)", "", "");
			$idProduct = array();
			foreach($product as $productArray)
			{
				$idProduct[] = $productArray->pro_id;
				#Remove image
				if($productArray->pro_image != 'none.gif')
				{
					$imageArray = explode(',', $productArray->pro_image);
                    foreach($imageArray as $imageArrays)
                    {
					   if(trim($imageArrays) != '' && file_exists('media/images/product/'.$productArray->pro_dir.'/'.$imageArrays))
    				    {
    						@unlink('media/images/product/'.$productArray->pro_dir.'/'.$imageArrays);
  						}
                    }
                    for($i = 1; $i <= 3; $i++)
                    {
                        if(file_exists('media/images/product/'.$productArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]))
                        {
                            @unlink('media/images/product/'.$productArray->pro_dir.'/thumbnail_'.$i.'_'.$imageArray[0]);
                        }
                    }
					if(trim($productArray->pro_dir) != '' && is_dir('media/images/product/'.$productArray->pro_dir) && count($this->file->load('media/images/product/'.$productArray->pro_dir, 'index.html')) == 0)
					{
						if(file_exists('media/images/product/'.$productArray->pro_dir.'/index.html'))
						{
							@unlink('media/images/product/'.$productArray->pro_dir.'/index.html');
						}
						@rmdir('media/images/product/'.$productArray->pro_dir);
					}
				}
			}
			#Get id ads
			$ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_user IN($listIdUser)", "", "");
			$idAds = array();
			foreach($ads as $adsArray)
			{
				$idAds[] = $adsArray->ads_id;
				#Remove image
				if($adsArray->ads_image != 'none.gif')
				{
					if(trim($adsArray->ads_image) != '' && file_exists('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image))
					{
						@unlink('media/images/ads/'.$adsArray->ads_dir.'/'.$adsArray->ads_image);
                        if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image))
                        {
                            @unlink('media/images/ads/'.$adsArray->ads_dir.'/thumbnail_3_'.$adsArray->ads_image);
                        }
					}
					if(trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/'.$adsArray->ads_dir) && count($this->file->load('media/images/ads/'.$adsArray->ads_dir, 'index.html')) == 0)
					{
						if(file_exists('media/images/ads/'.$adsArray->ads_dir.'/index.html'))
						{
							@unlink('media/images/ads/'.$adsArray->ads_dir.'/index.html');
						}
						@rmdir('media/images/ads/'.$adsArray->ads_dir);
					}
				}
			}
			#Get id job
			$job = $this->job_model->fetch("job_id", "job_user IN($listIdUser)", "", "");
			$idJob = array();
			foreach($job as $jobArray)
			{
				$idJob[] = $jobArray->job_id;
			}
			#Get id employ
			$employ = $this->employ_model->fetch("emp_id", "emp_user IN($listIdUser)", "", "");
			$idEmploy = array();
			foreach($employ as $employArray)
			{
				$idEmploy[] = $employArray->emp_id;
			}
			#Delete product
			if(count($idProduct) > 0)
			{
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
			}
			$this->product_favorite_model->delete($idUser, "prf_user");
			$this->product_comment_model->delete($idUser, "prc_user");
			$this->product_model->delete($idUser, "pro_user");
			#Delete ads
			if(count($idAds) > 0)
			{
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
			}
			$this->ads_favorite_model->delete($idUser, "adf_user");
			$this->ads_comment_model->delete($idUser, "adc_user");
			$this->ads_model->delete($idUser, "ads_user");
			#Delete job
			if(count($idJob) > 0)
			{
                $this->job_favorite_model->delete($idJob, "jof_job");
                $this->job_bad_model->delete($idJob, "jba_job");
			}
			$this->job_favorite_model->delete($idUser, "jof_user");
			$this->job_model->delete($idUser, "job_user");
			#Delete employ
			if(count($idEmploy) > 0)
			{
                $this->employ_favorite_model->delete($idEmploy, "emf_employ");
                $this->employ_bad_model->delete($idEmploy, "emb_employ");
			}
			$this->employ_favorite_model->delete($idUser, "emf_user");
			$this->employ_model->delete($idUser, "emp_user");
			#Delete shop
			#Remove image
			$shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_user IN($listIdUser)", "", "");
			foreach($shop as $shopArray)
			{
				if(trim($shopArray->sho_logo) != '' && file_exists('media/shop/logos/'.$shopArray->sho_dir_logo.'/'.$shopArray->sho_logo))
				{
					@unlink('media/shop/logos/'.$shopArray->sho_dir_logo.'/'.$shopArray->sho_logo);
				}
				if(trim($shopArray->sho_dir_logo) != '' && is_dir('media/shop/logos/'.$shopArray->sho_dir_logo) && count($this->file->load('media/shop/logos/'.$shopArray->sho_dir_logo, 'index.html')) == 0)
				{
					if(file_exists('media/shop/logos/'.$shopArray->sho_dir_logo.'/index.html'))
					{
						@unlink('media/shop/logos/'.$shopArray->sho_dir_logo.'/index.html');
					}
					@rmdir('media/shop/logos/'.$shopArray->sho_dir_logo);
				}
				if(trim($shopArray->sho_banner) != '' && file_exists('media/shop/banners/'.$shopArray->sho_dir_banner.'/'.$shopArray->sho_banner))
				{
					@unlink('media/shop/banners/'.$shopArray->sho_dir_banner.'/'.$shopArray->sho_banner);
				}
				if(trim($shopArray->sho_dir_banner) != '' && is_dir('media/shop/banners/'.$shopArray->sho_dir_banner) && count($this->file->load('media/shop/banners/'.$shopArray->sho_dir_banner, 'index.html')) == 0)
				{
					if(file_exists('media/shop/banners/'.$shopArray->sho_dir_banner.'/index.html'))
					{
						@unlink('media/shop/banners/'.$shopArray->sho_dir_banner.'/index.html');
					}
					@rmdir('media/shop/banners/'.$shopArray->sho_dir_banner);
				}
			}
			$this->shop_model->delete($idUser, "sho_user");
			#Delete contact
			$this->contact_model->delete($idUser, "con_user");
			#Delete showcart
			if(count($idProduct) > 0)
			{
				$this->showcart_model->delete($idProduct, "shc_product");
			}
			$this->showcart_model->delete($idUser, "shc_saler");
			$this->showcart_model->delete($idUser, "shc_buyer");
			#Delete user
			$this->user_model->delete($idUser, "use_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function ajax()
	{
		$q = $_REQUEST["q"];
		if (!$q) return;
		$this->load->model('user_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		#BEGIN: autocomplete Users
		$select = "use_username";
		$this->db->like('use_username', $q); 
		$allUsers = $this->user_model->fetch($select, "use_status = 1 AND (use_enddate >= $currentDate OR use_enddate = 0)", "use_username", "DESC");
		#END autocomplete Users
									
		foreach ($allUsers as $item) {			
				echo "$item->use_username|$item->use_username\n";	
		}	
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter

		$where = ' use_group = 1';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%' ";				    
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= " AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    //$where .= " AND use_regisdate = ".(float)$getVar['key'];
				    $d = (float)$getVar['key'];				    
				    $date =mktime(23,59,59,date('m',$d), date('d',$d), date('Y',$d));
				    $where .= " AND use_regisdate >= ".(float)$getVar['key']." AND use_regisdate <= ".$date;				   
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status

		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);	

		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/defaults', $data);
	}
	
	function shopfree()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		} 
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter

		$where = 'tbtt_user.use_group = 3 AND ( ';
		$aaa = $this->user_model->get_list_shop_fee();
		foreach ($aaa as $key) {			
			$where .= 'tbtt_user.use_id != '.$key->user_id .' AND ';
		}		
		$where .= ' 1 ) ';
		
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= " AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/shopfree'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/shopfree'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record

		//$totalRecord = count($this->user_model->fetch("use_id", $where, "", "","",""));		
        $totalRecord = count($this->user_model->fetch_join('DISTINCT tbtt_user.use_id', "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, "", "", "", "",true));

        $config['base_url'] = base_url().'administ/user/shopfree'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, use_status, use_regisdate, use_enddate, parent_id, sho_link, sho_name";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
			$this->db->order_by("use_id", "DESC");
		}
		
		$distinct = true;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit,$distinct);
		


		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/shopfree', $data);
	}
	
	function affiliate()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = 'use_group = 2 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= " AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";

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
		$data['sortUrl'] = base_url().'administ/user/affiliate'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/affiliate'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/affiliate'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, use_status, use_regisdate, use_enddate, parent_id, sho_link, sho_name";
		$limit = settingOtherAdmin;

		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC");
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit);
		$parentList = array();
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/affiliate', $data);
	}

	function alluser()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'tokey');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter

		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= " use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			
				case 'cmnd':
				    $sortUrl .= '/search/cmnd/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/cmnd/keyword/'.$getVar['keyword'];
				    $where .= " id_card LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				   
				    break;
				case 'phone':
				    $sortUrl .= '/search/phone/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/phone/keyword/'.$getVar['keyword'];
				    $where .= " use_phone LIKE '%".$this->filter->injection($getVar['keyword'])."%' OR use_mobile LIKE '%".$this->filter->injection($getVar['keyword'])."%'";				    
				    break;	
				}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $d = (float)$getVar['key'];				    
				    $date =mktime(23,59,59,date('m',$d), date('d',$d), date('Y',$d));
				    $where .= " use_regisdate >= ".(float)$getVar['key']." AND use_regisdate <= ".$date;
				    break;
				case 'group':
				    $sortUrl .= '/filter/group/key/'.$getVar['key'];
				    $pageUrl .= '/filter/group/key/'.$getVar['key'];
				    $where .= " use_group = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " use_group = 1";
					break;	
				case 'store':
				    $sortUrl .= '/filter/store/key/'.$getVar['key'];
				    $pageUrl .= '/filter/store/key/'.$getVar['key'];
				    $where .= " use_group = 3";
				    break;
				case 'logindate':
				    $sortUrl .= '/filter/logindate/key/'.$getVar['key'].'/tokey/'.$getVar['tokey'];
				    $pageUrl .= '/filter/logindate/key/'.$getVar['key'].'/tokey/'.$getVar['tokey'];
				    $where .= " use_lastest_login >= ".(float)$getVar['key']." AND use_lastest_login <= ".(float)$getVar['tokey'];
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort = "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort = "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort = "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort = "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort = "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort = "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "use_id";
			}
			
			if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
			{
                $pageUrl .= '/by/desc';
				$by = "DESC";
			}
			else
			{
                $pageUrl .= '/by/asc';
				$by = "ASC";
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
		$data['sortUrl'] = base_url().'administ/user/alluser'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/alluser'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/alluser'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, use_lastest_login, parent_id, id_card";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3) == '' && $this->uri->segment(2) == 'user'){
			$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/alluser', $data);
	}
	
	function shoppremium()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		
		$where = '(';
		$sort = ' tbtt_shop.sho_id ';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';

		$aaa = $this->user_model->get_list_shop_fee();
		foreach ($aaa as $key) {			
			$where .= ' tbtt_shop.sho_user = '.$key->user_id .' OR ';
		}		
		$where .= ' 0 )';

		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    //die('Tran The boa test choi');
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= " AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/shoppremium'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/shoppremium'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch_join("use_id", "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, "", ""));
        //$this->user_model->fetch_join($select, "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit);

        $config['base_url'] = base_url().'administ/user/shoppremium'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, use_status, use_regisdate, use_enddate, parent_id, sho_name, sho_link";
		
		// $select .= ", (SELECT
		// 					  tbtt_package_info.name
		// 				FROM
		// 					  tbtt_package_user  
		// 					  LEFT JOIN tbtt_package
		// 						ON tbtt_package_user.package_id = tbtt_package.id

		// 					  LEFT JOIN tbtt_package_info 
		// 					    ON tbtt_package.info_id = tbtt_package_info.id

		// 				WHERE tbtt_package_user.user_id = use_id
		// 					  AND
		// 					  (
		// 					  	(	tbtt_package_user.begined_date <= NOW()
		// 					  		AND tbtt_package_user.ended_date >= NOW()
		// 					  		AND tbtt_package.info_id >= 2
		// 							AND tbtt_package.info_id <= 7
		// 							AND tbtt_package_user.status = 1
		// 						) 
		// 					  	OR 
		// 					  	(
		// 							tbtt_package.info_id = 1
		// 						)
		// 					  )
		// 				ORDER BY tbtt_package_user.amount DESC LIMIT 0, 1) as pack_name";
		$select .= ", (SELECT
							  tbtt_package_info.name
						FROM
							  tbtt_package_user  
							  LEFT JOIN tbtt_package
								ON tbtt_package_user.package_id = tbtt_package.id

							  LEFT JOIN tbtt_package_info 
							    ON tbtt_package.info_id = tbtt_package_info.id

						WHERE tbtt_package_user.user_id = use_id
							  AND
							  (
							  	(	
							  		tbtt_package.info_id >= 2
									AND tbtt_package.info_id <= 7
									AND tbtt_package_user.status = 1
								) 
							  	OR 
							  	(
									tbtt_package.info_id = 1
								)
							  )
						ORDER BY tbtt_package_user.amount DESC LIMIT 0, 1) as pack_name";

									
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}		
		
		$data['user'] = $this->user_model->fetch_join($select, "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/shoppremium', $data);
	}
	
	function developer2()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 6 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/developer2'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/developer2'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/developer2'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
                
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/developer2', $data);
	}
	
	function developer1()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 7 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/developer1'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/developer1'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/developer1'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/developer1', $data);
	}
	
	function partner2()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 8 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/partner2'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/partner2'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/partner2'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/partner2', $data);
	}
	
	function partner1()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 9 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/partner1'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/partner1'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/partner1'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
			$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		#Load view
		$this->load->view('admin/user/partner1', $data);
	}
	
	function coremember()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 10 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/coremember'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/coremember'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/coremember'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		
		#Load view
		$this->load->view('admin/user/coremember', $data);
	}
	
	function coreadmin()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = ' use_group = 12 AND use_status = 1 ';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/coreadmin'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/coreadmin'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/coreadmin'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_mobile, use_yahoo, gro_name, use_status, use_regisdate, use_enddate, parent_id";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		
		#Load view
		$this->load->view('admin/user/coreadmin', $data);
	}
	
	function admin()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = 'use_group = 4';
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= "AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'email':
				    $sortUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/email/keyword/'.$getVar['keyword'];
				    $where .= "AND use_email LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= "AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= "AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= "AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= "AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= "AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
					
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
		$data['sortUrl'] = base_url().'administ/user/admin'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/admin'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/admin'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate";
		$limit = settingOtherAdmin;
		
		if($this->uri->segment(3)=='' && $this->uri->segment(2)=='user'){
		$this->db->order_by("use_id", "DESC"); 
		}
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		//print_r($data['user']);
		#Load view
		$this->load->view('admin/user/admin', $data);
	}
	function checkLocked($user_name){
			
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'user')))
		{
            //$this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-user');
            }
            else
            {
                setcookie('_cookieSetStatus', 'user');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_enddate < $currentDate";
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";

				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_address, use_phone, use_yahoo, gro_name, use_status, use_regisdate, use_enddate";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/end', $data);
	}
	
	function inactive()
	{
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
            {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
            }
            #END CHECK PERMISSION
            #Set userLogined = sessionUser
            $data['userLogined'] = $this->session->userdata('sessionUserAdmin');
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $lockAccount = settingLockAccount * 3600 * 24;
            #Define url for $getVar
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            #BEGIN: Search & Filter
            $where = "$currentDate - use_lastest_login > $lockAccount";
            $sort = 'use_id';
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
                        case 'regisdate':
                            $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
                            $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
                            $where .= " AND use_regisdate = ".(float)$getVar['key'];
                            break;
                        case 'enddate':
                            $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
                            $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
                            $where .= " AND use_enddate = ".(float)$getVar['key'];
                            break;
                        case 'lastestlogin':
                                            $sortUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
                                            $where .= " AND use_lastest_login = ".(float)$getVar['key'];
                                            break;
                        case 'active':
                                            $sortUrl .= '/filter/active/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/active/key/'.$getVar['key'];
                                            $where .= " AND use_status = 1";
                                            break;
                        case 'deactive':
                                            $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
                                            $where .= " AND use_status = 0";
                                            break;
                        case 'admin':
                                            $sortUrl .= '/filter/admin/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/admin/key/'.$getVar['key'];
                                            $where .= " AND use_group = 4";
                                            break;
                        case 'saler':
                                            $sortUrl .= '/filter/saler/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/saler/key/'.$getVar['key'];
                                            $where .= " AND use_group = 3";
                                            break;
                        case 'vip':
                                            $sortUrl .= '/filter/vip/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/vip/key/'.$getVar['key'];
                                            $where .= " AND use_group = 2";
                                            break;
                        case 'normal':
                                            $sortUrl .= '/filter/normal/key/'.$getVar['key'];
                                            $pageUrl .= '/filter/normal/key/'.$getVar['key'];
                                            $where .= " AND use_group = 1";
                                            break;
                    }
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
                    switch(strtolower($getVar['sort']))
                    {
                        case 'username':
                            $pageUrl .= '/sort/username';
                            $sort .= "use_username";
                            break;
                        case 'fullname':
                            $pageUrl .= '/sort/fullname';
                            $sort .= "use_fullname";
                            break;
                        case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                        case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                        case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                        case 'enddate':
                                $pageUrl .= '/sort/enddate';
                                $sort .= "use_enddate";
                                break;
                        default:
                            $pageUrl .= '/sort/id';
                            $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/inactive'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/inactive'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/inactive'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		if($this->uri->segment(3)=='inactive' && $this->uri->segment(4)==''){
			$this->db->order_by("use_id", "DESC"); 
		}
		#Fetch record
		$select = "use_id, use_username, use_email, use_group, gro_name, use_status, use_regisdate, use_enddate, use_lastest_login";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/inactive', $data);
	}
	
	function noactive()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}

		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$lockAccount = settingLockAccount * 3600 * 24;
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		
		$where = " use_status = 0 AND (use_group = ".Developer2User." OR use_group = ".Developer1User." OR use_group = ".Partner2User." OR use_group = ".Partner1User." OR use_group = ".CoreMemberUser." OR use_group = ".CoreAdminUser.")";
		$sort = 'use_id';
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
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'lastestlogin':
				    $sortUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $where .= " AND use_lastest_login = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
				case 'developer2':
				    $sortUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer2User;
				    break;
				case 'developer1':
				    $sortUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer1User;
				    break;
				case 'partner2':
				    $sortUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner2User;
				    break;
				case 'partner1':
				    $sortUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner1User;
				    break;
				case 'coremember':
				    $sortUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $where .= " AND use_group = ".CoreMemberUser;
				    break;
				case 'coreadmin':
				    $sortUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				    $where .= " AND use_group = ".CoreAdminUser;
				    break;	
					
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/noactive'. $sortUrl .'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/noactive'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':					
					$this->load->model('user_tree_model');
					$userObject = $this->user_model->get("*", "use_id = ".(int)$getVar['id']);
					if($this->existInTree((int)$getVar['id'])){
						$title = 'Chào bạn '.$userObject->use_fullname.' ! Yêu cầu tạo thành viên từ cấp trên.';
						$message = '<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
            <div id=":n8" class="a3s" style="overflow: hidden;">
                <div class="adM">  </div>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:20px 0">
                                <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                            </td>
                        </tr>
                        <tr><td></td></tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="height:9px" valign="top"></td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                                            <div style="line-height:18px;color:#333">
                                                <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                                                    <h1 style="font-size:20px;font-weight:bold;color:#666">
                                                       Yêu cầu tạo thành viên
                                                    </h1>
                                                    <span style="display:block;padding:10px 0">Chào bạn: <strong>' . $userObject->use_username . '</strong>,
                                                    <br/>
                                                     Tài khoản của bạn đã được kích hoạt!
                                                      <br/>
                                                     Bạn hãy click <a href="'. base_url().'login">vào đây</a> để đăng nhập vào azibai.com !
                                                      <br/>
                                                      Cảm ơn bạn!
                                                    </span>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800">
                                    <tbody>
                                        <tr></tr>
                                        <tr>
                                            <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" width="55%">
                                                                <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                                            </td>
                                                            <td align="right">
                                                                <div style="padding-top:10px;margin-right:5px">
                                                                    <img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div class="yj6qo">
        </div>
    </div>';
						$this->load->library('email');
						$config['useragent'] = $this->lang->line('useragen_mail_detail');
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						#Email
						$folder = folderWeb;
						$this->load->model('shop_mail_model');
						require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
						require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
						$return_email = $this->shop_mail_model->smtpmailer($userObject->use_email, $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", $title, $message);
						if ($return_email) {
							$this->user_model->update(array('use_status' => 1,'active_date' => date("Y-m-d",time())), "use_id = ". (int)$getVar['id']);
						}else{
							show_error("Thành viên này đã tồn tại trên Cây hệ thống. <a href='".base_url()."administ/user/noactive'>Quay lại</a>");
						}									
					}else{
						if($userObject->use_id > 0){

							$lastChild = $this->findChildWithNoChildNode($userObject->parent_id);

							if($this->existInTree($userObject->parent_id)){
								$dataUserTree = array(						    
									'user_id' => (int)$getVar['id'],
									'group_id' => $userObject->use_group,								
									'level'   => 0,
									'parent'  => $userObject->parent_id,
									'child'   => 0,
									'next'    => 0		
								);

								$lastChild = $this->findChildWithNoChildNode($userObject->parent_id);
								
								if($lastChild->user_id > 0){
									if($lastChild->user_id == $userObject->parent_id){
										$this->updateChildNode($lastChild->user_id, (int)$getVar['id']);
									} else {
										$this->updateNextNode($lastChild->user_id, (int)$getVar['id']);
									}
								}
														
								$this->user_tree_model->add($dataUserTree);
								$this->user_model->update(array('use_status' => 1,'active_date' => date("Y-m-d",time())), "use_id = ". (int)$getVar['id']);	
							} else {							
								show_error("Thành viên này có người giới thiệu không tồn tại trên Cây hệ thống. <a href='".base_url()."administ/user/noactive'>Quay lại</a>");		
							}
						} else {
							show_error("Thành viên này không tồn tại. <a href='".base_url()."administ/user/noactive'>Quay lại</a>");	
						}						
					}
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status' => 0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/noactive'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		if($this->uri->segment(3)=='noactive' && $this->uri->segment(4)==''){
			$this->db->order_by("use_id", "DESC"); 
		}
		#Fetch record
		$select = "use_id, use_username, use_fullname, use_email, use_group, gro_name, use_status, use_phone,use_mobile, use_regisdate, use_enddate, use_lastest_login, parent_id";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		
		#Load view
		$this->load->view('admin/user/noactive', $data);
	}
	function uprated()
	{
		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}

		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$lockAccount = settingLockAccount * 3600 * 24;
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$sort = 'use_id';
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
				case 'username':
					$sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
					$pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
					$where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					break;
			}
		}
//		#If filter
//		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
//		{
//			switch(strtolower($getVar['filter']))
//			{
//				case 'regisdate':
//					$sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
//					$pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
//					$where .= " AND use_regisdate = ".(float)$getVar['key'];
//					break;
//				case 'enddate':
//					$sortUrl .= '/filter/enddate/key/'.$getVar['key'];
//					$pageUrl .= '/filter/enddate/key/'.$getVar['key'];
//					$where .= " AND use_enddate = ".(float)$getVar['key'];
//					break;
//				case 'lastestlogin':
//					$sortUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
//					$pageUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
//					$where .= " AND use_lastest_login = ".(float)$getVar['key'];
//					break;
//				case 'active':
//					$sortUrl .= '/filter/active/key/'.$getVar['key'];
//					$pageUrl .= '/filter/active/key/'.$getVar['key'];
//					$where .= " AND use_status = 1";
//					break;
//				case 'deactive':
//					$sortUrl .= '/filter/deactive/key/'.$getVar['key'];
//					$pageUrl .= '/filter/deactive/key/'.$getVar['key'];
//					$where .= " AND use_status = 0";
//					break;
//				case 'developer2':
//					$sortUrl .= '/filter/developer2/key/'.$getVar['key'];
//					$pageUrl .= '/filter/developer2/key/'.$getVar['key'];
//					$where .= " AND use_group = ".Developer2User;
//					break;
//				case 'developer1':
//					$sortUrl .= '/filter/developer1/key/'.$getVar['key'];
//					$pageUrl .= '/filter/developer1/key/'.$getVar['key'];
//					$where .= " AND use_group = ".Developer1User;
//					break;
//				case 'partner2':
//					$sortUrl .= '/filter/partner2/key/'.$getVar['key'];
//					$pageUrl .= '/filter/partner2/key/'.$getVar['key'];
//					$where .= " AND use_group = ".Partner2User;
//					break;
//				case 'partner1':
//					$sortUrl .= '/filter/partner1/key/'.$getVar['key'];
//					$pageUrl .= '/filter/partner1/key/'.$getVar['key'];
//					$where .= " AND use_group = ".Partner1User;
//					break;
//				case 'coremember':
//					$sortUrl .= '/filter/coremember/key/'.$getVar['key'];
//					$pageUrl .= '/filter/coremember/key/'.$getVar['key'];
//					$where .= " AND use_group = ".CoreMemberUser;
//					break;
//				case 'coreadmin':
//					$sortUrl .= '/filter/coreadmin/key/'.$getVar['key'];
//					$pageUrl .= '/filter/coreadmin/key/'.$getVar['key'];
//					$where .= " AND use_group = ".CoreAdminUser;
//					break;
//
//				case 'admin':
//					$sortUrl .= '/filter/admin/key/'.$getVar['key'];
//					$pageUrl .= '/filter/admin/key/'.$getVar['key'];
//					$where .= " AND use_group = 4";
//					break;
//				case 'saler':
//					$sortUrl .= '/filter/saler/key/'.$getVar['key'];
//					$pageUrl .= '/filter/saler/key/'.$getVar['key'];
//					$where .= " AND use_group = 3";
//					break;
//				case 'vip':
//					$sortUrl .= '/filter/vip/key/'.$getVar['key'];
//					$pageUrl .= '/filter/vip/key/'.$getVar['key'];
//					$where .= " AND use_group = 2";
//					break;
//				case 'normal':
//					$sortUrl .= '/filter/normal/key/'.$getVar['key'];
//					$pageUrl .= '/filter/normal/key/'.$getVar['key'];
//					$where .= " AND use_group = 1";
//					break;
//			}
//		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
					$pageUrl .= '/sort/username';
					$sort .= "use_username";
					break;
				case 'fullname':
					$pageUrl .= '/sort/fullname';
					$sort .= "use_fullname";
					break;
				case 'email':
					$pageUrl .= '/sort/email';
					$sort .= "use_email";
					break;
				case 'group':
					$pageUrl .= '/sort/group';
					$sort .= "use_group";
					break;
				case 'regisdate':
					$pageUrl .= '/sort/regisdate';
					$sort .= "use_regisdate";
					break;
				case 'enddate':
					$pageUrl .= '/sort/enddate';
					$sort .= "use_enddate";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "use_id";
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
		$this->load->model('uprated_model');
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'administ/user/uprated'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/uprated'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
					$this->load->model('user_tree_model');
					break;
				case 'deactive':
					$this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
				case 'noaply':
					$this->uprated_model->update(array('status'=>0), "user_allow_uprated = ".(int)$getVar['id']);
					break;
				case 'aply':
					$this->uprated_model->update(array('status'=>1), "user_allow_uprated = ".(int)$getVar['id']);
					break;
			}

			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination

		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->uprated_model->fetch("*", "status", $where, $sort, $by, 0, -1));
		$config['base_url'] = base_url().'administ/user/noactive'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		if($this->uri->segment(3)=='noactive' && $this->uri->segment(4)==''){
			$this->db->order_by("use_id", "DESC");
		}
		#Fetch record
		$limit = settingOtherAdmin;
		$select = '*';
		$table = 'tbtt_require_uprated';
		$onjoin = 'INNER';
		$on = 'tbtt_user.use_id = tbtt_require_uprated.user_allow_uprated';
		//$data['user'] = $this->uprated_model->fetch("*", "status = 0", "", "", "", "");
		$data['user'] = $this->user_model->fetch_join($select,$onjoin, $table, $on,'',"","","","");
		#Load view
		$this->load->view('admin/user/userupdarated', $data);
	}

	function getChild($userid){
		$this->load->model('user_tree_model');	
		if($userid > 0){
			$userObject = $this->user_tree_model->get("*", "user_id = ".$userid);	
			return $userObject->child;		
		}else{
			return 0;	
		}		
	}
	
	function getNextList($child,&$list_next = array()){
		$this->load->model('user_tree_model');	
		$userObject = $this->user_tree_model->get("*", "user_id = ".$child);
		if($userObject->next > 0){
			$list_next[] =  $userObject->next;
		}
		if($userObject->next > 0){
			$this->getNextList($userObject->next, $list_next);
		}else{
			return $list_next;
		}
	}
	
	function getListChildTree($userid,&$list_child = array()){
		$child = $this->getChild($userid);
		if($child > 0){
			$list_child[] = $child;
			$this->getNextList($child,$list_child);
		}else{
			return 0;
		}
	}
	
	function getTreeInList($userid, &$allChild){		
		$listChild = array();
		$this->getListChildTree($userid,$listChild);
		foreach($listChild as $child){			
			if($child > 0){
				$allChild[] = $child;
				$this->getTreeInList($child,$allChild);
			}		
		}
						
	}
	
	function usertreetree($userid){
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$root_user = $this->uri->segment(4);
		
		 
		if($root_user > 0){
			$rootUser = $this->user_model->get("use_id, use_username", "use_id = ".$root_user);	
			$data['rootUser'] = $rootUser;
		}
		$html = '';
		$htmlTree = $this->getHTMLTree($root_user,$html);
		$data['htmlTree'] = $html; 
		
		#Load view
		$this->load->view('admin/user/usertreetree', $data);
	}
//	function ListChildStore($parent, &$arry){
//		$this->load->model('user_model');
//		$data = $this->user_model->fetch("*", "parent_id = ".$parent);
//		foreach ($data as $item){
//			if ($item->parent_id == $parent){
//				$obj = new stdClass();
//				$obj->use_id = $item->use_id ;
//				$obj->use_username = $item->use_username ;
//				$obj->use_fullname = $item->use_fullname ;
//				$obj->use_mobile = $item->use_mobile ;
//				$obj->use_email = $item->use_email ;
//				$obj->use_group = $item->use_group ;
//				$obj->use_status = $item->use_status ;
//				$obj->use_regisdate = $item->use_regisdate ;
//				$arry[] = $obj;
//				$this->ListChildStore($item->use_id, $arry);
//			}
//		}
//		return $arry;
//	}
	function liststore($userid){
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$root_user = $this->uri->segment(4);

		$sort = 'use_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		$search = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
			$keyword = $getVar['keyword'];
			$sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
			$pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
			$search .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
					$pageUrl .= '/sort/username';
					$sort .= "use_username";
					break;
				case 'fullname':
					$pageUrl .= '/sort/fullname';
					$sort .= "use_fullname";
					break;
				case 'email':
					$pageUrl .= '/sort/email';
					$sort .= "use_email";
					break;
				case 'group':
					$pageUrl .= '/sort/group';
					$sort .= "use_group";
					break;
				case 'regisdate':
					$pageUrl .= '/sort/regisdate';
					$sort .= "use_regisdate";
					break;
				case 'enddate':
					$pageUrl .= '/sort/enddate';
					$sort .= "use_enddate";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "use_id";
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
		$limit = 15;
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		if($root_user  > 0){
			$data['sortUrl'] = base_url().'administ/user/liststore/'.$root_user.$sortUrl.'/sort/';
		}
		$data['pageSort'] = $pageSort;
		#END Create link sort
		$userid = $this->uri->segment(4);
		if($userid > 0){
			$listChild = array();
			$this->getTreeInList($userid,$listChild);
		}
		$strUserId = implode($listChild,",");
		$where = '';
		$whereroot = '';
		if ($strUserId != ''){
			$where = 'use_group = '.AffiliateStoreUser.' AND parent_id IN ('.$strUserId.') OR ';
			$whereroot = 'use_id IN ('.$strUserId.') OR ';
		}
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("*", $where.'use_group = '.AffiliateStoreUser.' AND parent_id = '.$userid.$search.' AND use_status = 1'));
		$config['base_url'] = base_url().'administ/user/liststore/'.$root_user.'/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$data['rootUser'] = $this->user_model->fetch('use_id, use_username', $whereroot.'use_id = '.$userid.' AND use_status = 1');
		$data['Liststore'] = $this->user_model->fetch("*", $where.'use_group = '.AffiliateStoreUser.' AND parent_id = '.$userid.$search.' AND use_status = 1',$sort,$by,$start,$limit);
		#Load view
		$this->load->view('admin/user/liststore', $data);
	}
	function listaf($userid){
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$root_user = $this->uri->segment(4);

		$sort = 'use_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		$search = '';
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
			$keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'username':
					$sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
					$pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
					$search .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
					break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
					$pageUrl .= '/sort/username';
					$sort .= "use_username";
					break;
				case 'fullname':
					$pageUrl .= '/sort/fullname';
					$sort .= "use_fullname";
					break;
				case 'email':
					$pageUrl .= '/sort/email';
					$sort .= "use_email";
					break;
				case 'group':
					$pageUrl .= '/sort/group';
					$sort .= "use_group";
					break;
				case 'regisdate':
					$pageUrl .= '/sort/regisdate';
					$sort .= "use_regisdate";
					break;
				case 'enddate':
					$pageUrl .= '/sort/enddate';
					$sort .= "use_enddate";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "use_id";
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
		$limit = 15;
		#END Search & Filter
		#Keyword
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		if($root_user  > 0){
			$data['sortUrl'] = base_url().'administ/user/listaf/'.$root_user.$sortUrl.'/sort/';
		}else{
			$data['sortUrl'] = base_url().'administ/user/listaf'.$sortUrl.'/sort/';
		}
		$data['pageSort'] = $pageSort;
		#END Create link sort
		$userid = $this->uri->segment(4);
		if($userid > 0){
			$listChild = array();
			$this->getTreeInList($userid,$listChild);
		}
		$strUserId = implode($listChild,",");
		$where = '';
		$whereroot = '';
		if ($strUserId != ''){
			$where = 'use_group = '.AffiliateUser.' AND parent_id IN ('.$strUserId.') OR ';
			$whereroot = 'use_id IN ('.$strUserId.') OR ';
		}
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("*", $where.'use_group = '.AffiliateUser.' AND parent_id = '.$userid.$search.' AND use_status = 1'));
		$config['base_url'] = base_url().'administ/user/listaf/'.$root_user.'/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = $limit;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		$data['rootUser'] = $this->user_model->fetch('use_id, use_username', $whereroot.'use_id = '.$userid.' AND use_status = 1');
		$data['Listaf'] = $this->user_model->fetch("*", $where.'use_group = '.AffiliateUser.' AND parent_id = '.$userid.$search.' AND use_status = 1',$sort,$by,$start,$limit);
		#Load view
		$this->load->view('admin/user/listaf', $data);
	}

	function getHTMLTree($userid, &$htmlTree){
		$listChild = array();
		$this->getListChildTree($userid,$listChild);
		
		$listUser = array();
		foreach($listChild as $child){			
			if($child > 0){
				$userObject = $this->user_model->get("use_id, use_username, use_fullname","use_id = ".$child);
				$listUser[] = $userObject;
			}			
		}	
		if(count($listUser) > 0){
			$htmlTree .= 
			'<ul>';
			foreach ($listUser as $child){
				if($child->use_id > 0){
					$htmlTree .= '
				  <li> <span><i class="icon-folder-open"></i>'.$child->use_username.'</span> <a href="'.base_url().'administ/user/usertreetree/'.$child->use_id.'" title="Xem danh sách tuyến dưới của '.$child->use_fullname.'">'.$child->use_fullname.'</a>'.'   <a href="'.base_url().'administ/user/edit/'.$child->use_id.'"  target="_blank"><img width="20" src="'.base_url().'templates/admin/images/edit.png"  border="0" title="Sửa thông tin '.$child->use_username.'" /></a>';
					$htmlTree .= $this->getHTMLTree($child->use_id, $htmlTree);
					$htmlTree .= '</li>
				  ';
				}

			}  		  
			$htmlTree .= '</ul>';
		}
				
	}
	
	function usertree($userid){
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$root_user = $this->uri->segment(4);
		
		 
		if($root_user > 0){
			$rootUser = $this->user_model->get("use_id, use_username", "use_id = ".$root_user);	
			$data['rootUser'] = $rootUser;
		}
		
		$listChild = array();
		$this->getTreeInList($root_user,$listChild);		
		$strUserId = implode($listChild,",");
				
		$where = '';
		if($strUserId !=''){
			$where = " use_id IN (".$strUserId.") AND use_status = 1 AND (use_group = ".Developer2User." OR use_group = ".Developer1User." OR use_group = ".Partner2User." OR use_group = ".Partner1User." OR use_group = ".CoreMemberUser." OR use_group = ".CoreAdminUser.") ";
		}else{
			$where = '0 > 1';
		}

		$sort = 'use_id';
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
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				
				case 'developer2':
				    $sortUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer2User;
				    break;
				case 'developer1':
				    $sortUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer1User;
				    break;
				case 'partner2':
				    $sortUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner2User;
				    break;
				case 'partner1':
				    $sortUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner1User;
				    break;
				case 'coremember':
				    $sortUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $where .= " AND use_group = ".CoreMemberUser;
				    break;
				case 'coreadmin':
				    $sortUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				    $where .= " AND use_group = ".CoreAdminUser;
				    break;
				
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		if($root_user  > 0){
			$data['sortUrl'] = base_url().'administ/user/usertree/'.$root_user.$sortUrl.'/sort/';
		}else{
			$data['sortUrl'] = base_url().'administ/user/usertree'.$sortUrl.'/sort/';
		}
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		if($root_user  > 0){
			$data['statusUrl'] = base_url().'administ/user/usertree/'.$root_user.$statusUrl;
		}		
		else{
			$data['statusUrl'] = base_url().'administ/user/usertree'.$statusUrl;
		}
		
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':					
					$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
		if($root_user  > 0){
			$config['base_url'] = base_url().'administ/user/usertree/'.$root_user.$pageUrl.'/page/';
		}else{
			$config['base_url'] = base_url().'administ/user/usertree'.$pageUrl.'/page/';	
		}        
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
		$select = "use_id, use_username, use_fullname, use_email, use_group, use_mobile, gro_name, use_status, use_regisdate, use_enddate, use_lastest_login, parent_id";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		
		#Load view
		$this->load->view('admin/user/usertree', $data);
	}
	
	function allusertree()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$lockAccount = settingLockAccount * 3600 * 24;
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		
		$where = " use_status = 1 AND (use_group = ".Developer2User." OR use_group = ".Developer1User." OR use_group = ".Partner2User." OR use_group = ".Partner1User." OR use_group = ".CoreMemberUser." OR use_group = ".CoreAdminUser.")";
		$sort = 'use_id';
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
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'lastestlogin':
				    $sortUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/lastestlogin/key/'.$getVar['key'];
				    $where .= " AND use_lastest_login = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
				case 'developer2':
				    $sortUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer2User;
				    break;
				case 'developer1':
				    $sortUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/developer1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Developer1User;
				    break;
				case 'partner2':
				    $sortUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner2/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner2User;
				    break;
				case 'partner1':
				    $sortUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $pageUrl .= '/filter/partner1/key/'.$getVar['key'];
				    $where .= " AND use_group = ".Partner1User;
				    break;
				case 'coremember':
				    $sortUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coremember/key/'.$getVar['key'];
				    $where .= " AND use_group = ".CoreMemberUser;
				    break;
					
				case 'coreadmin':
				$sortUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				$pageUrl .= '/filter/coreadmin/key/'.$getVar['key'];
				$where .= " AND use_group = ".CoreAdminUser;
				break;
					
					
                case 'admin':
				    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
				    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
				    $where .= " AND use_group = 4";
				    break;
                case 'saler':
				    $sortUrl .= '/filter/saler/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saler/key/'.$getVar['key'];
				    $where .= " AND use_group = 3";
				    break;
                case 'vip':
				    $sortUrl .= '/filter/vip/key/'.$getVar['key'];
				    $pageUrl .= '/filter/vip/key/'.$getVar['key'];
				    $where .= " AND use_group = 2";
				    break;
                case 'normal':
				    $sortUrl .= '/filter/normal/key/'.$getVar['key'];
				    $pageUrl .= '/filter/normal/key/'.$getVar['key'];
				    $where .= " AND use_group = 1";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'group':
				    $pageUrl .= '/sort/group';
				    $sort .= "use_group";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/allusertree'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/allusertree'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':					
					$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/allusertree'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
		$data['sTT'] = $start + 1;
		if($this->uri->segment(3)=='allusertree' && $this->uri->segment(4)==''){
			$this->db->order_by("use_id", "DESC"); 
		}
		#Fetch record
		$select = "use_id, use_username, use_fullname, use_email, use_group, gro_name, use_status, use_regisdate, use_enddate, use_lastest_login, parent_id, use_mobile, use_phone";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_group", "tbtt_user.use_group = tbtt_group.gro_id", $where, $sort, $by, $start, $limit);
		
		$parentList = array(); 
		foreach ($data['user'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		
		#Load view
		$this->load->view('admin/user/allusertree', $data);
	}
	
	function existInTree($user_id) {
		$this->load->model('user_tree_model');
		if($user_id > 0){
			if(count($this->user_tree_model->get("*", "user_id = ". $user_id)) > 0)
			{
				return true;
			}			
		}else{
			return false;
		}
		return false;
	}
	
	function vip()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 2";
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'setenddate':
				    $sortUrl .= '/filter/setenddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/setenddate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate < use_enddate";
				    break;
                case 'notsetenddate':
				    $sortUrl .= '/filter/notsetenddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsetenddate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = use_enddate";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/vip'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/vip'.$statusUrl;
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->user_model->update(array('use_status'=>1), "use_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->user_model->update(array('use_status'=>0), "use_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/vip'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/vip', $data);
	}
	
	function endvip()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'vip')))
		{
            //$this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-vip');
            }
            else
            {
                setcookie('_cookieSetStatus', 'vip');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 2 AND use_regisdate < use_enddate AND use_enddate < $currentDate";
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/vip/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch("use_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/user/vip/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch($select, $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/endvip', $data);
	}
	
	function saler()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 3 AND sho_status = 0";
		$sort = 'use_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If search
		if($this->uri->segment(4)=="khongduyet")
		{
		
			$this->load->model('user_model');
			$this->user_model->update(array('use_group'=>1), "use_id = ".(int)$this->uri->segment(5));	
			redirect(base_url()."administ/user/saler", 'location');
		}
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'shop':
				    $sortUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
                case 'haveshop':
				    $sortUrl .= '/filter/haveshop/key/'.$getVar['key'];
				    $pageUrl .= '/filter/haveshop/key/'.$getVar['key'];
				    $where .= " AND sho_name != ''";
				    break;
                case 'notshop':
				    $sortUrl .= '/filter/notshop/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notshop/key/'.$getVar['key'];
				    $where .= " AND sho_name is null";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
                case 'shop':
				    $pageUrl .= '/sort/shop';
				    $sort .= "sho_name";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/saler'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/user/saler'.$statusUrl;
		
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
				$this->load->model('shop_model');
			switch(strtolower($getVar['status']))
			{
				case 'active':			
				  $this->shop_model->update(array('sho_status'=>1), "sho_user = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_status'=>0), "sho_user = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		$this->load->model('shop_model');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, $sort, $by, $start, $limit));
        $config['base_url'] = base_url().'administ/user/saler'.$pageUrl.'/page/';
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
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,use_id, use_username, use_email, cat_id, cat_name ,sho_user,use_fullname";
		$limit = settingOtherAdmin;
		if($this->uri->segment(3)=='saler' && $this->uri->segment(4)==''){
			$this->db->order_by("sho_begindate", "DESC"); 
		}
		$data['user'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/user/saler', $data);
	}
	
	function endsaler()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Set userLogined = sessionUser
		$data['userLogined'] = $this->session->userdata('sessionUserAdmin');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'saler')))
		{
            //$this->user_model->update(array('use_status'=>0), "use_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-saler');
            }
            else
            {
                setcookie('_cookieSetStatus', 'saler');
            }
		}
		#END Update status = deactive
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$where = "use_group = 3 AND use_regisdate < use_enddate AND use_enddate < $currentDate";
		$sort = 'use_id';
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
				case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
				case 'fullname':
				    $sortUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/fullname/keyword/'.$getVar['keyword'];
				    $where .= " AND use_fullname LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'shop':
				    $sortUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/shop/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'regisdate':
				    $sortUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/regisdate/key/'.$getVar['key'];
				    $where .= " AND use_regisdate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND use_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND use_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND use_status = 0";
				    break;
			}
		}
		#If sort
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'username':
				    $pageUrl .= '/sort/username';
				    $sort .= "use_username";
				    break;
				case 'fullname':
				    $pageUrl .= '/sort/fullname';
				    $sort .= "use_fullname";
				    break;
                case 'email':
				    $pageUrl .= '/sort/email';
				    $sort .= "use_email";
				    break;
                case 'regisdate':
				    $pageUrl .= '/sort/regisdate';
				    $sort .= "use_regisdate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "use_enddate";
				    break;
                case 'shop':
				    $pageUrl .= '/sort/shop';
				    $sort .= "sho_name";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "use_id";
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
		$data['sortUrl'] = base_url().'administ/user/saler/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->user_model->fetch_join("use_id", "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, "", "", -1, 0, true));
        $config['base_url'] = base_url().'administ/user/saler/end'.$pageUrl.'/page/';
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
		$select = "use_id, use_username, use_fullname, use_email, use_address, use_phone, use_yahoo, use_status, use_regisdate, use_enddate, sho_name, sho_link";
		$limit = settingOtherAdmin;
		$data['user'] = $this->user_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", $where, $sort, $by, $start, $limit, true);
		#Load view
		$this->load->view('admin/user/endsaler', $data);
	}
//	public function getDistrict()
//	{
//		if ($this->input->server('REQUEST_METHOD') == 'POST') {
//			$result = $this->district_model->find_by(array('ProvinceCode' => $this->input->post('user_province_put')), 'DistrictCode,DistrictName');
//			if ($result) {
//				foreach ($result as $vals) {
//					$district[$vals->DistrictCode] = $vals->DistrictName;
//				}
//				echo json_encode($district);
//				exit;
//			} else {
//				die("");
//			}
//		} else {
//			redirect(base_url());
//		}
//	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_add'))
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
			#BEGIN: Fetch data
			$this->load->model('province_model');
			$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
			$this->load->model('group_model');
			$data['group'] = $this->group_model->fetch("gro_id, gro_name", "gro_status = 1", "gro_order", "ASC");
			#END Fetch data
			#BEGIN: Set date
			if((int)date('m') < 12)
			{
				$data['nextMonth'] = (int)date('m') + 1;
				$data['nextYear'] = (int)date('Y');
			}
			else
			{
	            $data['nextMonth'] = 1;
				$data['nextYear'] = (int)date('Y') + 1;
			}
			#END: Set date
			$this->load->library('form_validation');
			#BEGIN: Set rules
            $this->form_validation->set_rules('username_user', 'lang:username_label_add', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
            $this->form_validation->set_rules('password_user', 'lang:password_label_add', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_user', 'lang:repassword_label_add', 'trim|required|matches[password_user]');
            $this->form_validation->set_rules('email_user', 'lang:email_label_add', 'trim|required|valid_email|callback__exist_email');
            $this->form_validation->set_rules('reemail_user', 'lang:reemail_label_add', 'trim|required|matches[email_user]');
            $this->form_validation->set_rules('fullname_user', 'lang:fullname_label_add', 'trim|required');
            $this->form_validation->set_rules('address_user', 'lang:address_label_add', 'trim|required');
            //$this->form_validation->set_rules('phone_user', 'lang:phone_label_add', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('mobile_user', 'lang:mobile_label_add', 'trim|callback__is_phone');
            $this->form_validation->set_rules('yahoo_user', 'lang:yahoo_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('skype_user', 'lang:skype_label_add', 'trim|callback__valid_nick');
            $this->form_validation->set_rules('endday_user', 'lang:endday_label_add', 'callback__valid_enddate');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_add'));
			$this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_add'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('hash');
                $salt = $this->hash->key(8);
				if($this->input->post('active_user') == '1')
				{
	                $active_user = 1;
				}
				else
				{
	                $active_user = 0;
				}
				$regisdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				if($this->input->post('role_user') == '4')
				{
	                //$enddate = mktime(0, 0, 0, date('m'), date('d'), 2035);
					$enddate=0;
				}
				elseif($this->input->post('role_user') == '3')
				{
					//$enddate = $regisdate;
					$enddate=0;
				}
				elseif($this->input->post('role_user') == '2')
				{
					//$enddate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
					$enddate=0;
				}
				else
				{
					//$enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+10);
					$enddate=0;
				}
				$parent_id = 0;
				if($this->input->post('role_user') == 6
				|| $this->input->post('role_user') == 7
				|| $this->input->post('role_user') == 8
				|| $this->input->post('role_user') == 9
				|| $this->input->post('role_user') == 10
				){
					$active_user = 0;
				}
				if($this->input->post('role_user') == 12){
					$active_user = 0;
					$parent_id = 624;
				}
				if($this->input->post('sponser_user') != ''){
					$sponser = $this->user_model->get("*","use_username = '".$this->input->post('sponser_user')."'");
					if($sponser->use_id > 0){
						$parent_id = $sponser->use_id;
					}
				}
				
				$lastest_login = $regisdate;
				$dataAdd = array(
				                    'use_username'      =>      trim(strtolower($this->filter->injection_html($this->input->post('username_user')))),
				                    'use_password'      =>      $this->hash->create($this->input->post('password_user'), $salt, 'md5sha512'),
				                    'use_salt'          =>      $salt,
				                    'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_user')))),
				                    'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_user'))),
	                                'use_birthday'      =>      mktime(0, 0, 0, (int)$this->input->post('month_user'), (int)$this->input->post('day_user'), (int)$this->input->post('year_user')),
	                                'use_sex'           =>      (int)$this->input->post('sex_user'),
	                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_user'))),
	                                'use_province'      =>      (int)$this->input->post('province_user'),
	                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_user'))),
	                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_user'))),
	                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_user'))),
	                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_user'))),
                                    
                                    'user_district'      =>      (int)$this->input->post('district_user'),
                                    'id_card'      =>      (int)$this->input->post('idcard_regis'),
                                    'tax_code'      =>      (int)$this->input->post('taxcode_regis'),
                                    
                                    
	                                'use_group'         =>      (int)$this->input->post('role_user'),
	                                'use_status'        =>      $active_user,
	                                'use_regisdate'     =>      $regisdate,
	                                'use_enddate'       =>      $enddate,
	                                'use_key'           =>      $this->hash->create($this->input->post('username_user'), $this->input->post('email_user'), 'sha256md5'),
	                                'use_lastest_login' =>      $lastest_login,
									'parent_id' =>      $parent_id
									);
				if($this->user_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/user/add', 'location');
			}
			else
	        {
				$data['username_user'] = $this->input->post('username_user');
				$data['email_user'] = $this->input->post('email_user');
				$data['reemail_user'] = $this->input->post('reemail_user');
				$data['fullname_user'] = $this->input->post('fullname_user');
				$data['day_user'] = $this->input->post('day_user');
				$data['month_user'] = $this->input->post('month_user');
				$data['year_user'] = $this->input->post('year_user');
				$data['sex_user'] = $this->input->post('sex_user');
				$data['address_user'] = $this->input->post('address_user');
				$data['province_user'] = $this->input->post('province_user');
				$data['phone_user'] = $this->input->post('phone_user');
				$data['mobile_user'] = $this->input->post('mobile_user');
				$data['yahoo_user'] = $this->input->post('yahoo_user');
				$data['skype_user'] = $this->input->post('skype_user');
				$data['role_user'] = $this->input->post('role_user');
				$data['endday_user'] = $this->input->post('endday_user');
				$data['endmonth_user'] = $this->input->post('endmonth_user');
				$data['endyear_user'] = $this->input->post('endyear_user');
				$data['active_user'] = $this->input->post('active_user');
	        }
        }
		#Load view
		$this->load->view('admin/user/add', $data);
	}

	function delete($id)
    {   
    	$this->load->model('user_model');
        $this->load->model('shop_model');
        $user_delete = $this->user_model->get("*", "use_id = ".(int)$id);
        if($user_delete->use_group == 2 || $user_delete->use_group == 1)
        {
            $this->user_model->delete((int)$id);
            $this->shop_model->deleted((int)$id);
            redirect(base_url().'administ/user/alluser','location');
        }
        else{
        	redirect(base_url() . 'administ/user/alluser','location');
        }
    }

	function edit($id)
	{
            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'user_edit'))
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
                #BEGIN: Fetch data
                $this->load->model('district_model');
                $this->load->model('province_model');
                $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
                $this->load->model('group_model');
                $data['group'] = $this->group_model->fetch("gro_id, gro_name", "gro_status = 1", "gro_order", "ASC");
                #END Fetch data
                #BEGIN: Get user by $id
                $user = $this->user_model->get("*", "use_id = ".(int)$id);
                $core = $this->user_model->fetch("use_id, use_username, use_group", "use_group IN(12,10,9,8,7,6) AND use_status = 1", "use_group",'DESC');
                $data['coremember'] = $core;
                if($user->parent_id >0){
                	$UserParent = $this->user_model->get_user_id($user->parent_id);
                	if(!empty($UserParent)) {
                		$data['UserParent'] = array(
                			'use_fullname'	=> $UserParent->use_fullname,
                			'use_id'		=> $UserParent->use_id
                		);
                	}
                        $arrGroup = array();
                        $this->db->cache_off();
                        $userParent = $this->user_model->get("*", "use_id = ".(int)$user->parent_id);
                        if(($user->use_group < $userParent->use_group) && ($userParent->use_group >= 8)){

                                for($i = $user->use_group; $i < $userParent->use_group; $i++ ){
                                        $arrGroup[] = $i;
                                }
                        }
                        $data['arrGroup'] = $arrGroup;
                }

                $data['district'] = $this->district_model->fetch("*");
                $data['userObject'] = $user;
                $this->load->model('affiliate_level_model');
                $data['affiliatelevel'] = $this->affiliate_level_model->get();
             
                if(count($user) != 1 || !$this->check->is_id($id))
                {
                        redirect(base_url().'administ/user', 'location');
                        die();
                }
                #END Get user by $id
                #Set sessionUser
                if($this->session->userdata('sessionUserAdmin') == $user->use_id)
                {
                        $data['userLogined'] = true;
                }
                else
                {
                    $data['userLogined'] = false;
                }
                    #BEGIN: Set date
                    if((int)date('m') < 12)
                    {
                            $data['nextMonth'] = (int)date('m') + 1;
                            $data['nextYear'] = (int)date('Y');
                    }
                    else
                    {
                        $data['nextMonth'] = 1;
                            $data['nextYear'] = (int)date('Y') + 1;
                    }
                    #END: Set date
                    $this->load->library('form_validation');
                    #BEGIN: Set rules
                    //$this->form_validation->set_rules('reemail_user', 'lang:reemail_label_edit', 'trim|required|matches[email_user]');
                    $this->form_validation->set_rules('fullname_user', 'lang:fullname_label_edit', 'trim|required');
                    $this->form_validation->set_rules('address_user', 'lang:address_label_edit', 'trim|required');
                    //$this->form_validation->set_rules('phone_user', 'lang:phone_label_edit', 'trim|required|callback__is_phone');
                    // $this->form_validation->set_rules('mobile_user', 'lang:mobile_label_edit', 'trim|callback__is_phone');
                    //$this->form_validation->set_rules('yahoo_user', 'lang:yahoo_label_edit', 'trim|callback__valid_nick');
                    //$this->form_validation->set_rules('skype_user', 'lang:skype_label_edit', 'trim|callback__valid_nick');
                    //$this->form_validation->set_rules('endday_user', 'lang:endday_label_edit', 'callback__valid_enddate');
                    #Expand
                    if($user->use_username != trim(strtolower($this->filter->injection_html($this->input->post('username_user')))))
                    {
                        $this->form_validation->set_rules('username_user', 'lang:username_label_edit', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
                    }
                    else
                    {
                        $this->form_validation->set_rules('username_user', 'lang:username_label_edit', 'trim|required|alpha_dash|min_length[6]|max_length[35]');
                    }
                    if($this->input->post('password_user') && trim($this->input->post('password_user')) != '')
                    {
                        $this->form_validation->set_rules('password_user', 'lang:password_label_edit', 'trim|required|min_length[6]|max_length[35]');
                        $this->form_validation->set_rules('repassword_user', 'lang:repassword_label_edit', 'trim|required|matches[password_user]');
                            $changedPassword = true;
                    }
                    if($user->use_email != trim(strtolower($this->filter->injection_html($this->input->post('email_user')))))
                    {
                        $this->form_validation->set_rules('email_user', 'lang:email_label_edit', 'trim|required|valid_email|callback__exist_email');
                    }

                    #END Set rules
                    #BEGIN: Set message
                    $this->form_validation->set_message('required', $this->lang->line('required_message'));
                    $this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
                    $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                    $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                    $this->form_validation->set_message('matches', $this->lang->line('matches_message'));
                    $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
                    $this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_edit'));
                    $this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_edit'));
                    $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
                    $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
                    $this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
                    $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
                    #END Set message

                    if($this->form_validation->run() === TRUE)
                    {

                        $this->load->library('hash');
                            if($changedPassword == true)
                            {
                                $salt = $this->hash->key(8);
                                $password_user = $this->hash->create($this->input->post('password_user'), $salt, 'md5sha512');
                            }
                            else
                            {
                                $salt = $user->use_salt;
                                $password_user = $user->use_password;
                            }
                            if($this->input->post('active_user') == '1')
                            {
                                $active_user = 1;
                            }
                            else
                            {
                                $active_user = 0;
                            }
                            if($this->session->userdata('sessionUserAdmin') == $user->use_id)
                            {
                                $active_user = 1;
                            }
                            $role_user = (int)$this->input->post('role_user');
                            if($this->session->userdata('sessionUserAdmin') == $user->use_id)
                            {
                                $role_user = $user->use_group;
                            }							

                            if($this->input->post('role_user') == '4')
                            {
                                //$enddate = mktime(0, 0, 0, date('m'), date('d'), 2035);
                                //$enddate=mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                $enddate=mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                if($enddate<time()) $enddate=0;					
                            }
                            elseif($this->input->post('role_user') == '3')
                            {
                                    //$enddate = $user->use_regisdate;
                                    //$enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+20);
                                    $enddate=mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                    if($enddate<time()) $enddate=0;

                            }
                            elseif($this->input->post('role_user') == '2')
                            {
                                    //$enddate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                    $enddate=mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                    if($enddate<time()) $enddate=0;
                            }
                            else
                            {
                                    //$enddate = mktime(0, 0, 0, date('m'), date('d'), (int)date('Y')+20);
                                    $enddate=mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
                                    if($enddate<time()) $enddate=0; 
                            }
                            if($this->session->userdata('sessionUserAdmin') == $user->use_id)
                            {
                                $enddate = $user->use_enddate;
                            }

                            $dataEdit = array(
                                'use_username'      =>      trim(strtolower($this->filter->injection_html($this->input->post('username_user')))),
                                'use_password'      =>      $password_user,
                                'use_salt'          =>      $salt,
                                'use_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_user')))),
                                'use_fullname'      =>      trim($this->filter->injection_html($this->input->post('fullname_user'))),
                                'use_birthday'      =>      date('Y-m-d', mktime(0, 0, 0, (int)$this->input->post('month_user'), (int)$this->input->post('day_user'), (int)$this->input->post('year_user'))),
                                'use_sex'           =>      (int)$this->input->post('sex_user'),
                                'use_address'       =>      trim($this->filter->injection_html($this->input->post('address_user'))),
                                'use_province'      =>      (int)$this->input->post('province_user'),
                                'user_district'     =>      $this->input->post('user_district'),
                                'use_phone'         =>      trim($this->filter->injection_html($this->input->post('phone_user'))),
                                'use_mobile'        =>      trim($this->filter->injection_html($this->input->post('mobile_user'))),
                                'use_yahoo'         =>      trim($this->filter->injection_html($this->input->post('yahoo_user'))),
                                'use_skype'         =>      trim($this->filter->injection_html($this->input->post('skype_user'))),
                                'use_group'         =>      $role_user,
                                'use_status'        =>      $active_user,
                                'use_enddate'       =>      $enddate,
                                'bank_name'         =>      $this->input->post('bank_name'),
                                'bank_add'          =>      $this->input->post('bank_add'),
                                'account_name'      =>      $this->input->post('account_name'),
                                'num_account'       =>      $this->input->post('num_account'), 
                                'tax_type'          =>      $this->input->post('taxtype_regis'),
                                'id_card'           =>      $this->input->post('id_card'),
                                'tax_code'          =>      $this->input->post('tax_code'),
                                // 'parent_id'          =>      $this->input->post('parent_id'),
                                'company_name'      =>      trim($this->filter->injection_html($this->input->post('company_name'))),
                                'company_agent'     =>      trim($this->filter->injection_html($this->input->post('company_agent'))),
                                'company_position'  =>      trim($this->filter->injection_html($this->input->post('company_position'))),
                                'affiliate_level'	=> trim($this->filter->injection_html($this->input->post('affiliate_level'))),
                            );									
                            $this->load->model('shop_model');
                            $temp_link=trim(strtolower($this->filter->injection_html($this->input->post('username_user'))));
                            if($temp_link != $user->use_username){
                                    $this->shop_model->update(array('sho_link'=>$temp_link), 'sho_user = '.$id);
                            }
                            if($this->user_model->update($dataEdit, "use_id = ".(int)$id))
                            {
                                if((int)$this->input->post('role_user')==1 && (int)$user->use_group != 1 )
                                {
                                    $this->load->model('product_model');
                                    $this->load->model('notify_model');
                                    $this->product_model->delete((int)$id,"pro_user");			
                                    $this->shop_model->delete((int)$id, "sho_user");
                                    $title_notice="Thông báo hạ cấp từ gian hàng  xuống thành viên thường cho user ".$this->filter->injection_html($this->input->post('username_user'));
                                    $content_notice="Gian hàng đã hạ cấp xuống thành viên thường vào ngày ".date('d')."/".date('m')."/".date('Y');
                                    $dataAddNoitice = array(
                                        'not_title'      	=>      $title_notice,
                                        'not_detail'		=>      $content_notice,
                                        'not_begindate'     =>      mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                                        'not_enddate'      	=>      mktime(0, 0, 0, date('m'), date('d')+1, date('Y')),
                                        'not_user'      	=>      $id,
                                        'not_status'      	=>      1
                                                                );
                                    $this->notify_model->add($dataAddNoitice);						
                                }
                                if($this->input->post('role_user') != $user->use_group){
                                    $this->load->model('user_tree_model');
                                    $dataTreeEdit = array(
                                        'group_id'  => (int)$this->input->post('role_user')
                                    );
                                    $this->user_tree_model->update($dataTreeEdit, "user_id = ".(int)$id);

                                //Add shop khi nang cap thanh vien thuong len gian hang
	                            if($user->use_group == 1 && $this->input->post('role_user') == 3){
	                                $dataShopRegister = array(
	                                'sho_name' => 'Gian hàng trên azibai',
	                                'sho_descr' => 'Gian hàng được nâng cấp trên azibai',
	                                'sho_address' => '',
	                                'sho_link' => 'azistore'.$user->use_id.time(),
	                                'sho_logo' => 'default-logo.png',
	                                'sho_dir_logo' => 'defaults',
	                                'sho_banner' => 'default-banner.jpg',
	                                'sho_dir_banner' => 'defaults',
	                                'sho_province' => (int)$user->use_province,
	                                'sho_district' => $user->user_district,
	                                'sho_category' => 1,
	                                'sho_phone' => $user->use_phone,
	                                'sho_mobile' => $user->use_mobile,
	                                'sho_user' => $user->use_id,
	                                'sho_begindate' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
	                                'sho_enddate' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
	                                'sho_view' => 1,
	                                'sho_status' => 1,
	                                'sho_style' => 'default',
	                                'sho_email' => $user->use_email,
	                                'shop_type' => 2
	                            	);
	                            	$this->shop_model->add($dataShopRegister);
	                            }
                                }

                                $this->session->set_flashdata('sessionSuccessEdit', 1);
                            }
                            redirect(base_url().'administ/user/edit/'.$id, 'location');
                    }
                    else
                    {
                            $data['username_user'] = $user->use_username;
                            $data['email_user'] = $user->use_email;
                            $data['reemail_user'] = $user->use_email;
                            $data['fullname_user'] = $user->use_fullname;
                            $data['day_user'] = date('d', strtotime($user->use_birthday));
                            $data['month_user'] = date('m', strtotime($user->use_birthday));
                            $data['year_user'] = date('Y', strtotime($user->use_birthday));
                            $data['sex_user'] = $user->use_sex;
                            $data['address_user'] = $user->use_address;
                            $data['province_user'] = $user->use_province;
                            $data['user_district'] = $user->user_district;
                            $data['phone_user'] = $user->use_phone;
                            $data['mobile_user'] = $user->use_mobile;
                            $data['id_card'] = $user->id_card;
                            $data['tax_code'] = $user->tax_code;
                            $data['tax_type'] = $user->tax_type;
                            $data['bank_name'] = $user->bank_name;
                            $data['bank_add'] = $user->bank_add;
                            $data['account_name'] = $user->account_name;
                            $data['num_account'] = $user->num_account;
                            $data['yahoo_user'] = $user->use_yahoo;
                            $data['skype_user'] = $user->use_skype;
                            $data['role_user'] = $user->use_group;
                            $data['parent_id'] = $user->parent_id;
                            $data['endday_user'] = date('d', $user->use_enddate);
                            $data['endmonth_user'] = date('m', $user->use_enddate);
                            $data['endyear_user'] = date('Y', $user->use_enddate);
                            $data['active_user'] = $user->use_status;
                            $data['company_position'] = $user->company_position;
                            $data['company_agent'] = $user->company_agent;
                            $data['company_name'] = $user->company_name;
                    }
            }
            #Load view
            $this->load->view('admin/user/edit', $data);
	}
		
	function findChildWithNoChildNode($parent_id){
		$this->load->model('user_tree_model');
		if($parent_id > 0){
			$parentUser = $this->user_tree_model->get("*", "user_id = ".$parent_id);
			if($parentUser->child == 0){
				return $parentUser;
			}else{				
				$lastChild = $this->user_tree_model->get("*","parent = ".$parent_id." AND next = 0");
				return $lastChild;
			}
		}
	}
	
	function updateChildNode($parent_id, $user_id){
		$this->user_tree_model->update(array('child' => $user_id), "user_id = ".$parent_id);
	}
	
	function updateNextNode($parent_id, $user_id){
		$this->user_tree_model->update(array('next' => $user_id), "user_id = ".$parent_id);
	}
	
	function _exist_username()
	{
		if(count($this->user_model->get("use_id", "use_username = '".trim(strtolower($this->filter->injection_html($this->input->post('username_user'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _exist_email()
	{
        if(count($this->user_model->get("use_id", "use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_user'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _is_phone($str)
	{
		if($this->check->is_phone($str))
		{
			return true;
		}
		return false;
	}
	
	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_user'), (int)$this->input->post('endday_user'), (int)$this->input->post('endyear_user'));
		if($this->input->post('role_user') == '2' && $this->check->is_more($currentDate, $endDate))
		{
		    return false;
		}
		return true;
	}
    
    function _valid_nick($str)
    {
        if(preg_match('/[^0-9a-z._-]/i', $str))
		{
			return false;
		}
		return true;
    }
}