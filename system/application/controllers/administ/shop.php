<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Shop extends CI_Controller
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
		$this->lang->load('admin/shop');
		#Load model
		$this->load->model('shop_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
         
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			#Remove image
			$this->load->library('file');
			$listIdShop = implode(',', $this->input->post('checkone'));
			$shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_id IN($listIdShop)", "", "");
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
			$this->shop_model->delete($this->input->post('checkone'), "sho_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Search & Filter
		$where = 'use_group = 3 AND sho_status = 1';
		$sort = 'sho_id';		
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
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
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
				    $where .= " AND sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 0";
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
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";
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
		$data['sortUrl'] = base_url().'administ/shop'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop'.$statusUrl;
	
				
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
		
			#END CHECK PERMISSION
			//var_dump($this->uri->segment(7));die();
			switch(strtolower($getVar['status']))
			{
				case 'active':					
				    $this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);	
					$this->load->model('user_model');
					$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$this->uri->segment(7));				
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
		
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: gurantee
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop'.$statusUrl;
		if($getVar['guarantee'] != FALSE && trim($getVar['guarantee']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['guarantee']))
			{
				case 'active':
				    $this->shop_model->update(array('sho_guarantee'=>1), "sho_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_guarantee'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
			
				
			redirect($data['statusUrl'], 'location');
		}
		#END gurantee
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop'.$pageUrl.'/page/';
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
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,use_id, use_username, use_email, tbtt_user.parent_id, cat_id, cat_name, sho_user";
		$limit = settingOtherAdmin;			
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$parentList = array(); 
		$this->load->model('user_model');
		foreach ($data['shop'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		$this->load->view('admin/shop/defaults', $data);
	}
	function list_shop()
	{

        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}		
		$proid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : 0;
		if ($proid > 0){
			$this->load->model('product_model');
			$select = 'tbtt_product.*, tbtt_category.cat_name';
			$product = $this->product_model->fetch_join($select,'INNER', 'tbtt_category', 'tbtt_product.pro_category = tbtt_category.cat_id',"","","","","","", 'pro_status = 1 and pro_user = '.$proid,'','','','', false, null);
			$data['product'] = $product;
			$this->load->view('admin/shop/product_shop', $data);
		}else{
			#END CHECK PERMISSION
			#Define url for $getVar
			$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id','tokey');
			$getVar = $this->uri->uri_to_assoc(4, $action);
			#BEGIN: Search & Filter
			$where = 'use_group = 3 AND sho_status = 1';
			$sort = '';
//			$sort = 'sho_id';
			$by = 'DESC'; 
			$sortUrl = '';
			$pageSort = '';
			$pageUrl = '';
			$keyword = '';
            $startMonth =$this->uri->segment('7');
            $endMonth = $this->uri->segment('9');

            $data['daypost'] = date('d',$startMonth);
            $data['monthpost'] = date('m',$startMonth);
            $data['yearpost'] = date('y',$startMonth);

            $data['tdaypost'] = date('d',$endMonth);
            $data['tmonthpost'] = date('m',$endMonth);
            $data['tyearpost'] = date('y',$endMonth);

            #If search
            if($startMonth !='')
            {
                $getVar['filter']='begindate';
            }

            if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
			{
				$keyword = $getVar['keyword'];
				switch(strtolower($getVar['search']))
				{
					case 'name':
						$sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
						$pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
						$where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						break;
					case 'link':
						$sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
						$pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
						$where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						break;
					case 'saler':
						$sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
						$pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
						$where .= " AND use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						break;
				}
			}

			#If filter
			elseif($getVar['filter'] != '' && $this->uri->segment(7)!= 'asc' && $this->uri->segment(7)!= 'desc')

			{
				switch(strtolower($getVar['filter']))
				{
					case 'begindate':
						$sortUrl .= '/filter/begindate/key/'.$getVar['key'];
						$pageUrl .= '/filter/begindate/key/'.$getVar['key'];
                        $where .= " AND shc_change_status_date >= ".(float)$startMonth." AND shc_change_status_date <= ".(float)$endMonth;
						break;
					case 'enddate':
						$sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						$pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						$where .= " AND sho_enddate = ".(float)$getVar['key'];
						break;
					case 'active':
						$sortUrl .= '/filter/active/key/'.$getVar['key'];
						$pageUrl .= '/filter/active/key/'.$getVar['key'];
						$where .= " AND sho_status = 1";
						break;
					case 'deactive':
						$sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						$pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						$where .= " AND sho_status = 0";
						break;
					case 'saleoff':
						$sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
						$pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
						$where .= " AND sho_saleoff = 1";
						break;
					case 'notsaleoff':
						$sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
						$pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
						$where .= " AND sho_saleoff = 0";
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
					case 'group_list':
						$pageUrl .= '/sort/category';
						$sort .= "cat_name";
						break;
					case 'begindate':
						$pageUrl .= '/sort/begindate';
						$sort .= "sho_begindate";
						break;
					case 'enddate':
                        $pageUrl .= '/sort/enddate';
                        $sort .= "sho_enddate";
                    break;
                    case 'group':
                        $pageUrl .= '/sort/group';
                        $sort .= "showcarttotal";
                        break;
					default:
						$pageUrl .= '/sort/id';
						$sort .= "sho_id";
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
			$data['sortUrl'] = base_url().'administ/shop/statistical'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Status
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'administ/shop/statistical'.$statusUrl;
			if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				#BEGIN: CHECK PERMISSION
				if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
				{
					show_error($this->lang->line('unallowed_use_permission'));
					die();
				}

				#END CHECK PERMISSION
				//var_dump($this->uri->segment(7));die();
				switch(strtolower($getVar['status']))
				{
					case 'active':
						$this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);
						$this->load->model('user_model');
						$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$this->uri->segment(7));
						break;
					case 'deactive':
						$this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END Status
			#BEGIN: gurantee
			$statusUrl = $pageUrl.$pageSort;
			$data['statusUrl'] = base_url().'administ/shop'.$statusUrl;
			if($getVar['guarantee'] != FALSE && trim($getVar['guarantee']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
			{
				#BEGIN: CHECK PERMISSION
				if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
				{
					show_error($this->lang->line('unallowed_use_permission'));
					die();
				}
				#END CHECK PERMISSION
				switch(strtolower($getVar['guarantee']))
				{
					case 'active':
						$this->shop_model->update(array('sho_guarantee'=>1), "sho_id = ".(int)$getVar['id']);
						break;
					case 'deactive':
						$this->shop_model->update(array('sho_guarantee'=>0), "sho_id = ".(int)$getVar['id']);
						break;
				}
				redirect($data['statusUrl'], 'location');
			}
			#END gurantee
			#BEGIN: Pagination
            // Nu bo sung them
            $where .=" and shc_status=98";
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->shop_model->fetch_join1("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", "LEFT", "tbtt_showcart", "tbtt_shop.sho_user = tbtt_showcart.shc_saler",  $where, "", ""));
			$config['base_url'] = base_url().'administ/shop/statistical'.$pageUrl.'/page/';
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
			$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,tbtt_user.*, cat_id, cat_name, sho_user,tbtt_showcart.shc_change_status_date ,SUM(tbtt_showcart.shc_total) As showcarttotal ,";
			$limit = settingOtherAdmin;

                $data['shop'] = $this->shop_model->fetch_join1($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", "LEFT", "tbtt_showcart", "tbtt_shop.sho_user = tbtt_showcart.shc_saler", $where, $sort, $by, $start, $limit);

                #Load view
			$parentList = array();
			$this->load->model('user_model');
			foreach ($data['shop'] as $userObject){
				$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
				$parentList[] = $parentObject;
			}
			$data['parent'] = $parentList;
			$this->load->view('admin/shop/order_shop', $data);
		}

	}
	function statistical_shop() {
		#BEGIN: CHECK PERMISSION
		if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'showcart_view')) {
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		$sort = '';		
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		#If have page
		if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
			$start = (int) $getVar['page'];
			$pageSort .= '/page/' . $start;
		} else {
			$start = 0;
		}
		#END Search & Filter
		#Keyword
		$uid = $this->uri->segment(4);
		$this->load->model('user_model');
		$user_oder = $this->user_model->get("use_id, use_username", "use_id = ".$uid);
		$ordertype = $this->uri->segment(11);
		if ($this->uri->segment('8') > 0 && $this->uri->segment('10') > 0){
            $startMonth =$this->uri->segment('8');
            $endMonth = $this->uri->segment('10');
		}
		else{
			$startMonth = mktime(0, 0, 0, date('n'), 1,1,2016);
			$numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date('Y'));
			$endMonth = mktime(23, 59, 59, date('n'), $numberDayOnMonth, date('Y'));
		}
        $data['daypost'] = date('d',$startMonth);
        $data['monthpost'] = date('m',$startMonth);
        $data['yearpost'] = date('y',$startMonth);

        $data['tdaypost'] = date('d',$endMonth);
        $data['tmonthpost'] = date('m',$endMonth);
        $data['tyearpost'] = date('y',$endMonth);


		$data['pro_type'] =  $this->input->post('pro_type');
		$order_type = '';
		if (isset($ordertype) && $ordertype =='product'){
			$order_type = 0;
		}elseif (isset($ordertype) && $ordertype =='service'){
			$order_type = 1;
		}elseif (isset($ordertype) && $ordertype =='coupon'){
			$order_type = 2;
		}
		$data['keyword'] = $keyword;
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url() . 'administ/shop/statistics/'.$uid. $sortUrl . '/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$params = array(
			'is_count' => TRUE,
			'limit' => settingOtherAdmin,
			'sort' => $sort,
			'by' => $by,
			'search' => $getVar['search'],
			'keyword' => $getVar['keyword'],
			'user_saler'=>$uid,
			'order_type'=> $order_type,
			'startMonth'=> $startMonth,
			'endMonth'=> $endMonth,
            'start'=>$start,
		);

		$this->load->model('order_model');
		$totalRecord = $this->order_model->list_orders_progress($params);
		$config['base_url'] = base_url() . 'administ/shop/statistics/'.$uid.$pageUrl . '/page/';
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
		$this->db->group_by('shc_orderid');

		$params['is_count'] = FALSE;
		$data['showcart'] = $this->order_model->list_orders_progress($params);
		$data['params'] = $params;
		$data['page'] = array(
			'title' => 'Danh đơn hàng của '.$user_oder->use_username,
			'status' => '01',
			'next_status' => FALSE,
		);
		// Thong ke phi danh muc
		$this->load->model('showcart_model');
		$this->db->select('tbtt_category.* , SUM(shc_total) as total');
		$this->db->join('tbtt_category', 'tbtt_showcart.pro_category = tbtt_category.cat_id');
		$this->db->where('shc_saler', $uid);
		$this->db->where('shc_status', '98');
		$this->db->where('shc_change_status_date >= ', $startMonth);
		$this->db->where('shc_change_status_date <= ', $endMonth);
		if (isset($order_type) && $order_type != ''){
			$this->db->where('cate_type', $order_type);
		}
		$this->db->group_by('tbtt_showcart.pro_category');
		$this->db->order_by('total', 'desc');
		$sql = $this->db->get('tbtt_showcart');
		$catlist = $sql->result();
		//	 Tinh hoa hong af
		// neu la  % thi shc_total * af_amt/ 100
		// neu la  VND thi lay cot af_amt * sl
		// Thong ke hoa hong
		$this->load->model('showcart_model');
		$this->db->select('use_id, use_username,tbtt_showcart.*,tbtt_product.pro_name, tbtt_product.pro_cost');
		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_showcart.af_id');
		$this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product');
		$this->db->where('shc_saler', $uid);
		$this->db->where('shc_status', '98');
		$this->db->where('shc_change_status_date >= ', $startMonth);
		$this->db->where('shc_change_status_date <= ', $endMonth);
		if (isset($order_type) && $order_type != ''){
			$this->db->where('pro_type', $order_type);
		}
		$sql = $this->db->get('tbtt_showcart');
		$listaf = $sql->result();
		//	 Tinh hoa hong af
		// neu la  % thi shc_total * af_amt/ 100
		// neu la  VND thi lay cot af_amt * sl


		$arrcat = array();
		foreach ($catlist as $catid){
			$cat_free = $this->findParentByID($catid->cat_id);
			array_push($arrcat, $cat_free);
		}
		$data['cat_fee'] = $arrcat;
		$data['list_cat'] = $catlist;
		$data['list_af'] = $listaf;
		#Load view
		$this->load->view('admin/shop/statistical_shop', $data);
	}
	function findParentByID($catid){
		$this->load->model('category_model');
		$calv = $this->category_model->get('*','cat_id = '.$catid);
		if ($calv && $calv->cat_level == 4){
			$catlv3 = $this->category_model->get('*','cat_level = 3 AND cat_id = '.$calv->parent_id);
			$catlv2 = $this->category_model->get('*','cat_level = 2 AND cat_id = '.$catlv3->parent_id);
			$catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$catlv2->parent_id);
			return $catlv1;
		}elseif ($calv && $calv->cat_level == 3){
			$catlv2 = $this->category_model->get('*','cat_level = 2 AND cat_id = '.$calv->parent_id);
			$catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$catlv2->parent_id);
			return $catlv1;
		}elseif ($calv && $calv->cat_level == 2){
			$catlv1 = $this->category_model->get('*','cat_level = 1 AND cat_id = '.$calv->parent_id);
			return $catlv1;
		}
		return $calv;
	}

	function dambao()
	{
		$pieces = explode("-", $this->uri->segment(5));
		$enddate_shop = mktime(0, 0, 0, (int)$pieces[1], (int)$pieces[0], (int)$pieces[2]);		
		$this->shop_model->update(array('sho_guarantee'=>1,'sho_enddate'=>$enddate_shop), "sho_id = ".(int)$this->uri->segment(4));
		redirect(base_url()."administ/shop", 'location');
	}
	function kiem_tra_link_shop()
	{
		
		$tenlink = $this->input->post('tenlink');
		$idUser = (int)$this->input->post('idUser');	
		$this->load->model('shop_model');
		$shop = $this->shop_model->get("*", "sho_user <> ".$idUser." AND sho_link = '".$tenlink."'"); 	
		echo $shop->sho_link;
		
	}
	
	
	function danhsachsanpham($id_shop)
	{
		$this->load->model('product_model');	
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		if (isset($id_shop) && $id_shop > 0){
			$where = 'pro_user ='.(int)$id_shop;
		}
		$sort = 'pro_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		if($this->uri->segment(5)=="delete")
		{
			$this->product_model->delete((int)$this->uri->segment(6), "pro_id");
		}
		//die();
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
            $keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
				    $where .= "pro_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= "pro_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= "pro_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= "pro_status = 0";
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
				    $sort .= "pro_name";
				    break;
                case 'cost':
				    $pageUrl .= '/sort/cost';
				    $sort .= "pro_cost";
				    break;
                case 'province':
				    $pageUrl .= '/sort/province';
				    $sort .= "pre_name";
				    break;
                case 'user':
				    $pageUrl .= '/sort/user';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "pro_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "pro_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "pro_id";
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
		$data['sortUrl'] = base_url().'administ/shop/danhsachsanpham/'.$id_shop.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop/danhsachsanpham/'.$id_shop.$statusUrl;
		//echo $getVar['status']."ssss";
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));

				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
				    $this->product_model->update(array('pro_status'=>1), "pro_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->product_model->update(array('pro_status'=>0), "pro_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}		
		if($getVar['vip'] != FALSE && trim($getVar['vip']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));

				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['vip']))
			{
				case 'active':
				    $this->product_model->update(array('pro_vip'=>1), "pro_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->product_model->update(array('pro_vip'=>0), "pro_id = ".(int)$getVar['id']);
					break;
			}			
			redirect($data['statusUrl'], 'location');
		}
			
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record		
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop/danhsachsanpham/'.$id_shop.$pageUrl.'/page/';
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
		$select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email,pro_vip";
		$limit = settingOtherAdmin;
		$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view		
		$this->load->view('admin/shop/danhsachsanpham', $data);
	}
	function danhsachsanphamaf($id_shop)
	{
		$this->load->model('product_model');
		$this->load->model('product_affiliate_user_model');

		#BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		#Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Search & Filter
		if (isset($id_shop) && $id_shop > 0){
			$where = 'tbtt_product_affiliate_user.use_id = '.(int)$id_shop;
		}
		$sort = 'pro_begindate';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		if($this->uri->segment(5)=="delete")
		{
			$this->product_model->delete((int)$this->uri->segment(6), "pro_id");
		}
		//die();
		#If search
		if($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
			$keyword = $getVar['keyword'];
			switch(strtolower($getVar['search']))
			{
				case 'name':
					$sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
					$pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
					$where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
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
					$where .= "pro_begindate = ".(float)$getVar['key'];
					break;
				case 'enddate':
					$sortUrl .= '/filter/enddate/key/'.$getVar['key'];
					$pageUrl .= '/filter/enddate/key/'.$getVar['key'];
					$where .= "pro_enddate = ".(float)$getVar['key'];
					break;
				case 'active':
					$sortUrl .= '/filter/active/key/'.$getVar['key'];
					$pageUrl .= '/filter/active/key/'.$getVar['key'];
					$where .= "pro_status = 1";
					break;
				case 'deactive':
					$sortUrl .= '/filter/deactive/key/'.$getVar['key'];
					$pageUrl .= '/filter/deactive/key/'.$getVar['key'];
					$where .= "pro_status = 0";
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
					$sort .= "pro_name";
					break;
				case 'cost':
					$pageUrl .= '/sort/cost';
					$sort .= "pro_cost";
					break;
				case 'province':
					$pageUrl .= '/sort/province';
					$sort .= "pre_name";
					break;
				case 'user':
					$pageUrl .= '/sort/user';
					$sort .= "use_username";
					break;
				case 'category':
					$pageUrl .= '/sort/category';
					$sort .= "cat_name";
					break;
				case 'begindate':
					$pageUrl .= '/sort/begindate';
					$sort .= "pro_begindate";
					break;
				case 'enddate':
					$pageUrl .= '/sort/enddate';
					$sort .= "pro_enddate";
					break;
				default:
					$pageUrl .= '/sort/id';
					$sort .= "pro_id";
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
		$data['sortUrl'] = base_url().'administ/shop/danhsachsanphamaf/'.$id_shop.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop/danhsachsanphamaf/'.$id_shop.$statusUrl;
		//echo $getVar['status']."ssss";
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));

				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':
					$this->product_model->update(array('pro_status'=>1), "pro_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
					$this->product_model->update(array('pro_status'=>0), "pro_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
		if($getVar['vip'] != FALSE && trim($getVar['vip']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			#BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));

				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['vip']))
			{
				case 'active':
					$this->product_model->update(array('pro_vip'=>1), "pro_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
					$this->product_model->update(array('pro_vip'=>0), "pro_id = ".(int)$getVar['id']);
					break;
			}
			redirect($data['statusUrl'], 'location');
		}

		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->product_affiliate_user_model->fetch_join("",   "INNER", "tbtt_product", "tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id", "", "", "", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", $where, "", ""));
		$config['base_url'] = base_url().'administ/shop/danhsachsanphamaf/'.$id_shop.$pageUrl.'/page/';
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
		$select = '';
		$select = "tbtt_product.pro_id, tbtt_product.pro_name, pro_view, pro_category, pro_cost, pro_begindate ,pro_status, af_amt, af_rate, af_dc_amt, af_dc_rate, tbtt_category.cat_id, tbtt_category.cat_name";
		$limit = settingOtherAdmin;
		$data['product'] = $this->product_affiliate_user_model->fetch_join($select, "INNER", "tbtt_product", "tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view

		//echo $this->db->last_query();
		$this->load->view('admin/shop/danhsachsanphamaf', $data);
	}
	
	function end()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'shop')))
		{
            $this->shop_model->update(array('sho_status'=>0), "sho_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-shop');
            }
            else
            {
                setcookie('_cookieSetStatus', 'shop');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "sho_enddate < $currentDate AND use_group = 3";
		$sort = 'sho_id';
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
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
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
				    $where .= " AND sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 0";
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
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";
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
		$data['sortUrl'] = base_url().'administ/shop/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop/end'.$pageUrl.'/page/';
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
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, use_id, use_username, use_email, cat_id, cat_name";
		$limit = settingOtherAdmin;
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/shop/end', $data);
	}
	
	function noactive()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = 'use_group = 3 AND sho_status = 0';
		$sort = 'sho_id';
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
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
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
				    $where .= " AND sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 0";
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
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";
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
		$data['sortUrl'] = base_url().'administ/shop/noactive'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop/noactive'.$statusUrl;
	
				
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
		
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':					
				    $this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);	
					$this->load->model('user_model');
					$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$this->uri->segment(8));				
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
		
			redirect($data['statusUrl'], 'location');
		}
		#END Status
		#BEGIN: gurantee
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop/noactive'.$statusUrl;
		if($getVar['guarantee'] != FALSE && trim($getVar['guarantee']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['guarantee']))
			{
				case 'active':
				    $this->shop_model->update(array('sho_guarantee'=>1), "sho_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_guarantee'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
			
				
			redirect($data['statusUrl'], 'location');
		}
		#END gurantee
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop/noactive'.$pageUrl.'/page/';
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
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,use_id, use_username, use_email, tbtt_user.parent_id, cat_id, cat_name, sho_user";
		$limit = settingOtherAdmin;			
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view
		$parentList = array(); 
		$this->load->model('user_model');
		foreach ($data['shop'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
			
		}
		$data['parent'] = $parentList;
		$this->load->view('admin/shop/noactive', $data);
	}
	
	function all()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'shipping');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		$getallaf = $this->uri->segment(3);

		#BEGIN: Search & Filter
		if ($getallaf == 'af'){
			$where = 'use_group = 2 AND sho_status = 1 AND sho_id > 0';
		}else{
			//$where = 'use_group = 3 AND ( sho_status = 0 OR sho_status = 1 ) ';
			$where = 'use_group = 3';
		}

		$this->load->model('user_model');

		if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'shopfee'){			

			$aaa = $this->user_model->get_list_shop_fee();
			$where .= ' AND ';
			foreach ($aaa as $key) {			
				$where .= 'tbtt_shop.sho_user = '.$key->user_id .' OR ';
			}		
			$where .= ' 0 ';
		}

		if($getVar['filter'] != FALSE && trim($getVar['filter']) == 'package'){	

			$aaa = $this->user_model->get_shop_by_package((float)$getVar['key']);
			$where .= ' AND ';
			foreach ($aaa as $key) {			
				$where .= 'tbtt_shop.sho_user = '.$key->user_id .' OR ';
			}		
			$where .= ' 0 ';
		}

		$sort = 'sho_id';
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
				case 'name':
				    $sortUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/name/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'link':
				    $sortUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/link/keyword/'.$getVar['keyword'];
				    $where .= " AND sho_link LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'saler':
				    $sortUrl .= '/search/saler/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/saler/keyword/'.$getVar['keyword'];
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
				    $where .= " AND sho_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND sho_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND sho_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND sho_status = 0";
				    break;
                case 'saleoff':
				    $sortUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/saleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 1";
				    break;
                case 'notsaleoff':
				    $sortUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $pageUrl .= '/filter/notsaleoff/key/'.$getVar['key'];
				    $where .= " AND sho_saleoff = 0";
				    break;
                case 'shopfee':
                    $sortUrl .= '/filter/shopfee/key/'.$getVar['key'];
                    $pageUrl .= '/filter/shopfee/key/'.$getVar['key'];
                    $where .= '';
                    break;
                case 'shopfree':
                    $sortUrl .= '/filter/shopfree/key/'.$getVar['key'];
                    $pageUrl .= '/filter/shopfree/key/'.$getVar['key'];
                    $where .= '';
                    break;
                case 'package':
                    $sortUrl .= '/filter/package/key/'.$getVar['key'];
                    $pageUrl .= '/filter/package/key/'.$getVar['key'];
                    $where .= '';
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
				    $sort .= "sho_name";
				    break;
                case 'link':
				    $pageUrl .= '/sort/link';
				    $sort .= "sho_link";
				    break;
                case 'saler':
				    $pageUrl .= '/sort/saler';
				    $sort .= "use_username";
				    break;
                case 'category':
				    $pageUrl .= '/sort/category';
				    $sort .= "cat_name";
				    break;
                case 'begindate':
				    $pageUrl .= '/sort/begindate';
				    $sort .= "sho_begindate";
				    break;
                case 'enddate':
				    $pageUrl .= '/sort/enddate';
				    $sort .= "sho_enddate";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort .= "sho_id";

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
		if ($getallaf == 'af'){
			$data['sortUrl'] = base_url().'administ/shop/af'.$sortUrl.'/sort/';
		}else{
			$data['sortUrl'] = base_url().'administ/shop/all'.$sortUrl.'/sort/';
		}
		$data['pageSort'] = $pageSort;
		#END Create link sort

		#BEGIN: Update Status for Shop
		$statusUrl = $pageUrl.$pageSort;
		if ($getallaf == 'af') {
			$data['statusUrl'] = base_url() . 'administ/shop/af' . $statusUrl;
			$data['getallaf'] = 'af';
		}else{
			$data['statusUrl'] = base_url() . 'administ/shop/all' . $statusUrl;
			$data['getallaf'] = 'all';
		}
		
		if($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
		
			#END CHECK PERMISSION
			switch(strtolower($getVar['status']))
			{
				case 'active':					
				    $this->shop_model->update(array('sho_status'=>1), "sho_id = ".(int)$getVar['id']);	
					$this->load->model('user_model');
					$this->user_model->update(array('use_status'=>1), "use_id = ".(int)$this->uri->segment(8));				
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_status'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
		
			redirect($data['statusUrl'], 'location');
		}
		#END: Update Status for Shop

		#BEGIN: Config Own Shipping for Shop
		if($getVar['shipping'] != FALSE && trim($getVar['shipping']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
			
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}		
			#END CHECK PERMISSION
			switch(strtolower($getVar['shipping']))
			{
				case 'active':					
				    $this->shop_model->update(array('sho_shipping' => 1), "sho_id = ".(int)$getVar['id']);	
					$this->load->model('user_model');							
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_shipping' => 0), "sho_id = ".(int)$getVar['id']);
					break;
			}		
			redirect($data['statusUrl'], 'location');
		}
		#END: Config Own Shipping for Shop

		#BEGIN: gurantee
		$statusUrl = $pageUrl.$pageSort;

		if ($getallaf == 'af') {
			$data['statusUrl'] = base_url() . 'administ/shop/af' . $statusUrl;
		}else{
			$data['statusUrl'] = base_url() . 'administ/shop/all' . $statusUrl;
		}
		if($getVar['guarantee'] != FALSE && trim($getVar['guarantee']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			switch(strtolower($getVar['guarantee']))
			{
				case 'active':
				    $this->shop_model->update(array('sho_guarantee'=>1), "sho_id = ".(int)$getVar['id']);
					break;
				case 'deactive':
				    $this->shop_model->update(array('sho_guarantee'=>0), "sho_id = ".(int)$getVar['id']);
					break;
			}
			
				
			redirect($data['statusUrl'], 'location');
		}
		#END gurantee
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_shop_category", "tbtt_shop.sho_category = tbtt_shop_category.cat_id", $where, "", ""));
		if ($getallaf == 'af') {
			$config['base_url'] = base_url() . 'administ/shop/af' . $pageUrl . '/page/';
		}else{
			$config['base_url'] = base_url().'administ/shop/all'.$pageUrl.'/page/';
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
		$select = "sho_id, sho_name, sho_view, sho_saleoff, sho_link, sho_address, sho_phone, sho_email, sho_status, sho_begindate, sho_enddate, sho_guarantee ,use_id, use_username, use_email, tbtt_user.parent_id, cat_id, cat_name, sho_user, sho_discount_rate, sho_shipping";
		$limit = settingOtherAdmin;			
		$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_shop.sho_category = tbtt_category.cat_id", $where, $sort, $by, $start, $limit);
		#Load view

		$parentList = array(); 
		$this->load->model('user_model');
		foreach ($data['shop'] as $userObject){
			$parentObject = $this->user_model->get("use_id, use_username", "use_id = ".$userObject->parent_id);
			$parentList[] = $parentObject;
		}
		$data['parent'] = $parentList;
		
		$this->load->view('admin/shop/all', $data);
	}
	
	function add()
	{
        #BEGIN: CHECK PERMISSION		
		$this->load->model('shop_category_model');	
		$cat_level_0 = $this->shop_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
			foreach($cat_level_0 as $key=>$item){
				$cat_level_1 = $this->shop_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}

		$data['catlevel0']=$cat_level_0;
		$maxorder = $this->shop_category_model->get("max(cat_order) as maxorder");
		$data['next_order'] = (int)$maxorder->maxorder + 1;						
		$maxindex = $this->shop_category_model->get("max(cat_index) as maxindex");
		$data['next_index'] = (int)$maxindex->maxindex + 1;						
	
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_add'))
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
            #BEGIN: Fetch user is saler
            $this->load->model('user_model');
            $userShop = $this->shop_model->fetch("sho_user", "", "", "");
            $userUsed = array();
            foreach($userShop as $userShopArray)
            {
				$userUsed[] = $userShopArray->sho_user;
            }
			
            if(count($userUsed) > 0)
            {
                $userUsed = implode(',', $userUsed);
            	$data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1 AND use_id NOT IN($userUsed)", "use_username", "ASC");
            }
            else
            {
                $data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1", "use_username", "ASC");
            }
            #END Fetch user is saler
            #BEGIN: Fetch category
            $this->load->model('shop_category_model');
            $data['category'] = $this->shop_category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            #END Fetch category
            #BEGIN: Fetch province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            #END Fetch province
            #BEGIN: Load style
            $this->load->library('folder');
			$data['style'] = $this->folder->load('templates/shop');
            #END Load style
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
            $this->form_validation->set_rules('link_shop', 'lang:link_label_add', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__exist_link|callback__valid_link');
            $this->form_validation->set_rules('username_shop', 'lang:username_label_add', 'required|callback__exist_username');
            $this->form_validation->set_rules('name_shop', 'lang:name_label_add', 'trim|required|callback__exist_shop');       
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_exist_link', $this->lang->line('_exist_link_message_add'));
			$this->form_validation->set_message('_valid_link', $this->lang->line('_valid_link_message_add'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_add'));
			$this->form_validation->set_message('_exist_shop', $this->lang->line('_exist_shop_message_add'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message_add'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                $this->load->library('upload');
                #BEGIN: Upload logo
                $pathLogo = "media/shop/logos/";
				#Create folder
				$dir_logo = date('dmY');
				if(!is_dir($pathLogo.$dir_logo))
				{
					@mkdir($pathLogo.$dir_logo);
					$this->load->helper('file');
					@write_file($pathLogo.$dir_logo.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathLogo.$dir_logo.'/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= 100000;
				$config['max_width']  = 5000;
				$config['max_height']  = 5000;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('logo_shop'))
				{
					$uploadLogo = $this->upload->data();
					$logo_shop = $uploadLogo['file_name'];               
                    $this->load->library('image_lib');
                    if(file_exists($pathLogo.$dir_logo.'/'.$logo_shop))
                    {
                        $sizeLogo = size_thumbnail($pathLogo.$dir_logo.'/'.$logo_shop);
                        $configLogo['source_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['new_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['maintain_ratio'] = TRUE;
                        $configLogo['width'] = $sizeLogo['width'];
                        $configLogo['height'] = $sizeLogo['height'];
                        $this->image_lib->initialize($configLogo); 
                        $this->image_lib->resize();
                    }
                    #END Resize logo
     				$isLogoUploaded = true;
				}
				else
				{
                    $isLogoUploaded = false;
				}
				unset($config);
			
                $pathBanner = "media/shop/banners/";
				#Create folder
				$dir_banner = date('dmY');
				if(!is_dir($pathBanner.$dir_banner))
				{
					@mkdir($pathBanner.$dir_banner);
					$this->load->helper('file');
					@write_file($pathBanner.$dir_banner.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathBanner.$dir_banner.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf';
				$config['max_size']	= 100000;
				$config['max_width']  = 5000;
				$config['max_height']  = 5000;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('banner_shop'))
				{
					$uploadBanner = $this->upload->data();
					$banner_shop = $uploadBanner['file_name'];
     				$isBannerUploaded = true;
				}
				else
				{
                    $isBannerUploaded = false;
				}
				#END Upload banner
				if($isLogoUploaded == false || $isBannerUploaded == false)
				{
                    redirect(base_url().'administ/shop/add', 'location');
                    die();
				}
                if($this->input->post('active_shop') == '1')
				{
	                $active_shop = 1;
				}
				else
				{
	                $active_shop = 0;
				}
				if($this->input->post('saleoff_shop') == '1')
				{
	                $saleoff_shop = 1;
				}
				else
				{
	                $saleoff_shop = 0;
				}
				
				$enddate_shop = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
				$dataAdd = array(
				                    'sho_name'      		=>      trim($this->filter->injection_html($this->input->post('name_shop'))),
				                    'sho_descr'      		=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_shop')))),
				                    'sho_link'				=>      trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))),
				                    'sho_logo'         		=>      $logo_shop,
	                                'sho_dir_logo'      	=>      $dir_logo,
	                                'sho_banner'      		=>      $banner_shop,
				                    'sho_dir_banner'      	=>      $dir_banner,
				                    'sho_address'			=>      trim($this->filter->injection_html($this->input->post('address_shop'))),
				                    'sho_category'      	=>      (int)$this->input->post('hd_category_id'),
				                    'sho_province'     		=>      (int)$this->input->post('province_shop'),
									'shop_fax '     		=>      $this->input->post('fax_shop'),
				                    'sho_phone'      		=>      trim($this->filter->injection_html($this->input->post('phone_shop'))),
				                    'sho_mobile'			=>      trim($this->filter->injection_html($this->input->post('mobile_shop'))),
				                    'sho_email'      		=>      trim($this->filter->injection_html($this->input->post('email_shop'))),
				                    'sho_yahoo'         	=>      trim($this->filter->injection_html($this->input->post('yahoo_shop'))),
	                                'sho_skype'      		=>      trim($this->filter->injection_html($this->input->post('skype_shop'))),
	                                'sho_website'      		=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_shop')))),
	                                'sho_style'      		=>      trim($this->filter->injection_html($this->input->post('style_shop'))),
	                                'sho_saleoff'      		=>      $saleoff_shop,
	                                'sho_status'      		=>      $active_shop,
	                                'sho_user'      		=>      (int)$this->input->post('username_shop'),
	                                'sho_view'      		=>      1,
	                                'sho_begindate'      	=>      mktime(0, 0, 0, date('m'), date('d'), date('Y')),
	                                'sho_enddate'      		=>      $enddate_shop
									);
									
									
				if($this->shop_model->add($dataAdd))
				{
					#BEGIN: Update enddate user
					$this->user_model->update(array('use_enddate'=>$enddate_shop,'use_group'=>3), "use_id = ".(int)$this->input->post('username_shop'));
					#END Update enddate user
         			$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/shop/add', 'location');
			}
			else
	        {
				$data['link_shop'] = $this->input->post('link_shop');
				$data['username_shop'] = $this->input->post('username_shop');
				$data['name_shop'] = $this->input->post('name_shop');
				$data['descr_shop'] = $this->input->post('descr_shop');
				$data['address_shop'] = $this->input->post('address_shop');
				$data['category_shop'] = $this->input->post('category_shop');
				$data['province_shop'] = $this->input->post('province_shop');
				$data['phone_shop'] = $this->input->post('phone_shop');
				$data['mobile_shop'] = $this->input->post('mobile_shop');
				$data['email_shop'] = $this->input->post('email_shop');
				$data['yahoo_shop'] = $this->input->post('yahoo_shop');
				$data['skype_shop'] = $this->input->post('skype_shop');
				$data['website_shop'] = $this->input->post('website_shop');
				$data['style_shop'] = $this->input->post('style_shop');
				$data['saleoff_shop'] = $this->input->post('saleoff_shop');
				$data['endday_shop'] = $this->input->post('endday_shop');
				$data['endmonth_shop'] = $this->input->post('endmonth_shop');
				$data['endyear_shop'] = $this->input->post('endyear_shop');
				$data['active_shop'] = $this->input->post('active_shop');
	        }
        }
		#Load view
		$this->load->view('admin/shop/add', $data);
	}
	function delete_img(){
		$this->load->model('shop_model');
		$shop = $this->shop_model->get("*", "sho_id = ".(int)$id);
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
						
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
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
            #BEGIN: Get shop by $id
            $shop = $this->shop_model->get("*", "sho_id = ".(int)$id);
            if(count($shop) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/shop', 'location');
				die();
			}
            #END Get shop by $id
            #BEGIN: Fetch user is saler
            $this->load->model('user_model');
            $thisUserShop = $shop->sho_user;
            $userShop = $this->shop_model->fetch("sho_user", "sho_user != $thisUserShop", "", "");
           
		   
		   $userUsed = array();
            foreach($userShop as $userShopArray)
            {
				$userUsed[] = $userShopArray->sho_user;
            }
            if(count($userUsed) > 0)
            {
                $userUsed = implode(',', $userUsed);
            	$data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1 AND use_id NOT IN($userUsed)", "use_username", "ASC");
            }
            else
            {
                $data['user'] = $this->user_model->fetch("use_id, use_username, use_email", "use_group = 3 AND use_status = 1", "use_username", "ASC");
            }
			
            #END Fetch user is saler
            #BEGIN: Fetch category
            $this->load->model('shop_category_model');
            $data['category'] = $this->shop_category_model->fetch("cat_id, cat_name", "", "cat_order", "ASC");
            #END Fetch category
            #BEGIN: Fetch province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            #END Fetch province
            #BEGIN: Load style
            $this->load->library('folder');
			$data['style'] = $this->folder->load('templates/shop');
            #END Load style
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
			
            if($shop->sho_link != trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))))
            {
                $this->form_validation->set_rules('link_shop', 'lang:link_label_edit', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__exist_link|callback__valid_link');
            }
            else
            {
               $this->form_validation->set_rules('link_shop', 'lang:link_label_edit', 'trim|required|alpha_dash|min_length[5]|max_length[50]|callback__valid_link');
            }
            if($shop->sho_user != (int)$this->input->post('username_shop'))
            {
               // $this->form_validation->set_rules('username_shop', 'lang:username_label_edit', 'required|callback__exist_username');
            }
            else
            {
                //$this->form_validation->set_rules('username_shop', 'lang:username_label_edit', 'required');
            }
            if($shop->sho_name != trim($this->filter->injection_html($this->input->post('name_shop'))))
            {
               // $this->form_validation->set_rules('name_shop', 'lang:name_label_edit', 'trim|required|callback__exist_shop');
            }
            else
            {
               // $this->form_validation->set_rules('name_shop', 'lang:name_label_edit', 'trim|required');
            }
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_exist_link', $this->lang->line('_exist_link_message_edit'));
			$this->form_validation->set_message('_valid_link', $this->lang->line('_valid_link_message_edit'));
			$this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_edit'));
			$this->form_validation->set_message('_exist_shop', $this->lang->line('_exist_shop_message_edit'));
			$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
			$this->form_validation->set_message('_valid_website', $this->lang->line('_valid_website_message_edit'));
			$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
            $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
                $this->load->library('upload');
                #BEGIN: Upload logo
                $pathLogo = "media/shop/logos/";
				#Create folder
				$dir_logo = $shop->sho_dir_logo;
				if(!is_dir($pathLogo.$dir_logo))
				{
					@mkdir($pathLogo.$dir_logo);
					$this->load->helper('file');
					@write_file($pathLogo.$dir_logo.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathLogo.$dir_logo.'/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size']	= 10000;
				$config['max_width']  = 5000;
				$config['max_height']  = 5000;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('logo_shop'))
				{
					if($shop->sho_logo != '' && file_exists($pathLogo.$dir_logo.'/'.$shop->sho_logo))
					{
						@unlink($pathLogo.$dir_logo.'/'.$shop->sho_logo);
					}
					$uploadLogo = $this->upload->data();
					$logo_shop = $uploadLogo['file_name'];
                    #BEGIN: Resize logo
                    $this->load->library('image_lib');
                    if(file_exists($pathLogo.$dir_logo.'/'.$logo_shop))
                    {
                        $sizeLogo = size_thumbnail($pathLogo.$dir_logo.'/'.$logo_shop);
                        $configLogo['source_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['new_image'] = $pathLogo.$dir_logo.'/'.$logo_shop;
                        $configLogo['maintain_ratio'] = TRUE;
                        $configLogo['width'] = $sizeLogo['width'];
                        $configLogo['height'] = $sizeLogo['height'];
                        $this->image_lib->initialize($configLogo); 
                        $this->image_lib->resize();
                    }
                    #END Resize logo
     				$isLogoUploaded = true;
				}
				else
				{
					if($shop->sho_logo != '' && file_exists($pathLogo.$dir_logo.'/'.$shop->sho_logo))
					{
						$logo_shop = $shop->sho_logo;
						$isLogoUploaded = true;
					}
                    else
                    {
                        $isLogoUploaded = false;
                    }
				}
				unset($config);
				#END Upload logo
				#BEGIN: Upload banner
                $pathBanner = "media/shop/banners/";
				#Create folder
				$dir_banner = $shop->sho_dir_banner;
				if(!is_dir($pathBanner.$dir_banner))
				{
					@mkdir($pathBanner.$dir_banner);
					$this->load->helper('file');
					@write_file($pathBanner.$dir_banner.'/index.html', '<p>Directory access is forbidden.</p>');
				}
				$config['upload_path'] = $pathBanner.$dir_banner.'/';
				$config['allowed_types'] = 'gif|jpg|png|swf';
				$config['max_size']	= 10000;
				$config['max_width']  = 5000;
				$config['max_height']  = 5000;
				$config['encrypt_name'] = true;
				$this->upload->initialize($config);
				if($this->upload->do_upload('banner_shop'))
				{
                    if($shop->sho_banner != '' && file_exists($pathBanner.$dir_banner.'/'.$shop->sho_banner))
					{
						@unlink($pathBanner.$dir_banner.'/'.$shop->sho_banner);
					}
					$uploadBanner = $this->upload->data();
					$banner_shop = $uploadBanner['file_name'];
     				$isBannerUploaded = true;
				}
				else
				{
                    if($shop->sho_banner != '' && file_exists($pathBanner.$dir_banner.'/'.$shop->sho_banner))
					{
						$banner_shop = $shop->sho_banner;
						$isBannerUploaded = true;
					}
                    else
                    {
                        $isBannerUploaded = false;
                    }
				}
				#END Upload banner
				if($isLogoUploaded == false || $isBannerUploaded == false)
				{
                    redirect(base_url().'administ/shop/edit/'.$id, 'location');
                    die();
				}
                if($this->input->post('active_shop') == '1')
				{
	                $active_shop = 1;
				}
				else
				{
	                $active_shop = 0;
				}
				if($this->input->post('saleoff_shop') == '1')
				{
	                $saleoff_shop = 1;
				}
				else
				{
	                $saleoff_shop = 0;
				}
				if($this->input->post('hd_category_id')!="")
				{
					$category_shop = $this->input->post('hd_category_id');
				}
				else
				{
					$category_shop = $shop->sho_category;
				}
				 $enddate_shop = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
				//echo $enddate_shop ;die();
				$enddate_shop = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
				$dataEdit = array(
				                    'sho_name'      		=>      trim($this->filter->injection_html($this->input->post('name_shop'))),
				                    'sho_descr'      		=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_shop')))),
				                    'sho_link'				=>      trim(strtolower($this->filter->injection_html($this->input->post('link_shop')))),
				                    'sho_logo'         		=>      $logo_shop,
	                                'sho_dir_logo'      	=>      $dir_logo,
	                                'sho_banner'      		=>      $banner_shop,
				                    'sho_dir_banner'      	=>      $dir_banner,
				                    'sho_address'			=>      trim($this->filter->injection_html($this->input->post('address_shop'))),
				                    'sho_category'     		 =>      	(int)$category_shop,
				                    'sho_province'     		=>      (int)$this->input->post('province_shop'),
									'shop_fax '     		=>      $this->input->post('fax_shop'),
				                    'sho_phone'      		=>      trim($this->filter->injection_html($this->input->post('phone_shop'))),
				                    'sho_mobile'			=>      trim($this->filter->injection_html($this->input->post('mobile_shop'))),
				                    'sho_email'      		=>      trim($this->filter->injection_html($this->input->post('email_shop'))),
				                    'sho_yahoo'         	=>      trim($this->filter->injection_html($this->input->post('yahoo_shop'))),
	                                'sho_skype'      		=>      trim($this->filter->injection_html($this->input->post('skype_shop'))),
	                                'sho_website'      		=>      trim($this->filter->injection_html($this->filter->link($this->input->post('website_shop')))),
	                                'sho_style'      		=>      trim($this->filter->injection_html($this->input->post('style_shop'))),
	                                'sho_saleoff'      		=>      $saleoff_shop,
	                                'sho_status'      		=>      $active_shop,
	                               // 'sho_user'      		=>      (int)$this->input->post('username_shop'),
	                                'sho_enddate'      		=>      $enddate_shop
									);
				if($this->shop_model->update($dataEdit, "sho_id = ".(int)$id))
				{
					#BEGIN: Update enddate user
					//$this->user_model->update(array('use_enddate'=>$enddate_shop), "use_id = ".(int)$this->input->post('username_shop'));
					#END Update enddate user
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/shop/edit/'.$id, 'location');
			}
			else
	        {
				$data['sho_id'] = $shop->sho_id;
				$data['link_shop'] = $shop->sho_link;
				$data['username_shop'] = $shop->sho_user;
				$data['name_shop'] = $shop->sho_name;
				$data['descr_shop'] = $shop->sho_descr;
				$data['address_shop'] = $shop->sho_address;
				$data['category_shop'] = $shop->sho_category;
				$data['province_shop'] = $shop->sho_province;
				$data['phone_shop'] = $shop->sho_phone;
				$data['mobile_shop'] = $shop->sho_mobile;
				$data['email_shop'] = $shop->sho_email;
				$data['yahoo_shop'] = $shop->sho_yahoo;
				$data['skype_shop'] = $shop->sho_skype;
				$data['website_shop'] = $shop->sho_website;
				$data['style_shop'] = $shop->sho_style;
				$data['saleoff_shop'] = $shop->sho_saleoff;
				$data['endday_shop'] = date('d', $shop->sho_enddate);
				$data['endmonth_shop'] = date('m', $shop->sho_enddate);
				$data['endyear_shop'] = date('Y', $shop->sho_enddate);
				$data['active_shop'] = $shop->sho_status;
				$data['dir_logo_shop'] = $shop->sho_dir_logo;
				$data['logo_shop'] = $shop->sho_logo;
				$data['dir_banner_shop'] = $shop->dir_banner_shop;
				$data['dir_banner_shop'] = $shop->sho_dir_banner;
				$data['banner_shop'] = $shop->sho_banner;	
				$data['shop_fax'] = $shop->shop_fax;		
				$cat_parent = $this->shop_category_model->get("*", "cat_id = ".(int)$shop->sho_category);					
						if($cat_parent->cat_level==2)
						{
							$cat_lavel_2_temp=$this->shop_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
							
							$data['cat_level_2'] = $cat_lavel_2_temp;
							$data['cat_parent_parent']=$this->shop_category_model->get("*","parent_id = ".(int)$cat_parent->parent_id);
										
							$get_category_leve1=$this->shop_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
										
							$cat_lavel_1_temp=$this->shop_category_model->fetch("*","parent_id = ".(int)$get_category_leve1->parent_id);
							$data['cat_parent_parent_0']=$this->shop_category_model->get("*","parent_id = ".(int)$get_category_leve1->parent_id);			
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
								$cat_lavel_1_temp=$this->shop_category_model->fetch("*","parent_id = ".(int)$cat_parent->parent_id);
								
								$data['cat_level_1'] = $cat_lavel_1_temp;					
								
								$get_category_leve1=$this->shop_category_model->get("*","cat_id = ".(int)$cat_parent->parent_id);	
								
								$data['cat_parent_parent_0']=$cat_parent;
								
							}
							
							
						}
						
	        }
        }
		#Load view
		$this->load->view('admin/shop/edit', $data);
	}
	
	function ajax_category_shop(){
	
		$this->load->model('shop_category_model');
		$parent_id = (int)$this->input->post('parent_id');

		$cat_level = $this->shop_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");

		if(isset($cat_level)){

			foreach($cat_level as $key=>$item){

				$cat_level_next = $this->shop_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");

				$cat_level[$key]->child_count = count($cat_level_next);

			}

		}

		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();

	}
	
	function _exist_shop()
	{
        if(count($this->shop_model->get("sho_id", "sho_name = '".trim($this->filter->injection_html($this->input->post('name_shop')))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	
	function edit_danhmuc($id)
	{
        #BEGIN: CHECK PERMISSION
		$this->load->model('shop_category_model');
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
			$category = $this->shop_category_model->get("*", "cat_id = ".(int)$id);
			if(count($category) != 1 || !$this->check->is_id($id))
			{
				redirect(base_url().'administ/shop/danhmuc', 'location');
				die();
			}
			
			#Begin: Category danh muc cua hang
			$cat_parent = $this->shop_category_model->get("*", "cat_id = ".(int)$category->parent_id);
			if(isset($cat_parent)){
				if($cat_parent->parent_id == 0)
				{
					$data['parent_id_0'] = $category->parent_id;
				}
				else
				{
					$data['parent_id_0'] = $cat_parent->parent_id;
					$data['parent_id_1'] = $category->parent_id;
					$cat_level_1 = $this->shop_category_model->fetch("*","parent_id = ".$cat_parent->parent_id." AND cat_status = 1 AND cat_id != ".$id, "cat_order, cat_id", "ASC");
					$data['catlevel1']=$cat_level_1;
				}
			}
			$cat_level_0 = $this->shop_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->shop_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			$maxindex = $this->shop_category_model->get("max(cat_index) as maxindex");
			$data['next_index'] = (int)$maxindex->maxindex+1;
			#End
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
				         
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
	                                'cat_status'      	=>      $active_category,
									 'cat_index'         =>      (int)$this->input->post('cat_index'),
									 'cat_level'         =>      (int)$this->input->post('cat_level'),
									 'parent_id'      	=>      $this->input->post('parent_id'),
									 'keyword'      	=>      $this->input->post('keyword'),
									 'h1tag'      	=>      $this->input->post('h1tag')
									);
				if($this->shop_category_model->update($dataEdit, "cat_id = ".(int)$id))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				if($category->cat_level==0 && (int)$this->input->post('cat_level')==1)
				{
					$this->shop_category_model->update(array('cat_level' => 2), "parent_id  = ".(int)$id);
				}
				
				redirect(base_url().'administ/shop-danhmuc/edit/'.$id, 'location');
			}
			else
	        {
				$data['name_category'] = $category->cat_name;
				$data['descr_category'] = $category->cat_descr;	
				$data['order_category'] = $category->cat_order;
				$data['active_category'] = $category->cat_status;
				$data['parent_id'] = $category->parent_id;
				$data['cat_level'] = $category->cat_level;
				$data['cat_index'] = $category->cat_index;
				$data['keyword'] = $category->keyword;
				$data['h1tag'] = $category->h1tag;
	        }
        }
		$retArray = array();
		 $this->display_child(0, 0,$retArray);
		
		$data['parents']  = $retArray;
		
		#Load view
		$this->load->view('admin/shop/edit_category', $data);
	}
	
	
	function _exist_username()
	{
        if(count($this->shop_model->get("sho_id", "sho_user = '".(int)$this->input->post('username_shop')."'")) > 0)
		{
			return false;
		}
		return true;
	}
	// danh muc gian hang 
	function add_danhmuc()
	{
		$this->load->model('shop_category_model');
		
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
      
			#Begin: Category hoi dap
			$cat_level_0 = $this->shop_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->shop_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
				
			$data['catlevel0']=$cat_level_0;
			$maxorder = $this->shop_category_model->get("max(cat_order) as maxorder");
			$data['next_order'] = (int)$maxorder->maxorder+1;
			$maxindex = $this->shop_category_model->get("max(cat_index) as maxindex");
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
				                    'cat_order'         =>      (int)$this->input->post('order_category'),
									 'parent_id'         =>      (int)$this->input->post('parent_id'),
									 'cat_index'         =>      (int)$this->input->post('cat_index'),
									 'cat_level'         =>      (int)$this->input->post('cat_level'),
	                                'cat_status'      	=>      $active_category,
									'keyword'      	=>      $this->input->post('keyword'),
									'h1tag'      	=>      $this->input->post('h1tag')
									);
				if($this->shop_category_model->add($dataAdd))
				{
     				$this->session->set_flashdata('sessionSuccessAdd', 1);
				}
				redirect(base_url().'administ/shop/danhmuc/add', 'location');
			}
			else
	        {
				$data['name_category'] = $this->input->post('name_category');
				$data['descr_category'] = $this->input->post('descr_category');			
				$data['order_category'] = $this->input->post('order_category');
				$data['active_category'] = $this->input->post('active_category');
				$data['keyword'] = $this->input->post('keyword');
				$data['h1tag'] = $this->input->post('h1tag');
	        }
        }
		$retArray = array();
		 $this->display_child(0, 0,$retArray);
		
		$data['parents']  = $retArray;
	
		#Load view
		$this->load->view('admin/shop/add_category', $data);
	}
	//end 
	
	function display_child($parent, $level,&$retArray)
	{
	    
		$sql = "SELECT * from `tbtt_shop_category` WHERE parent_id='$parent' order by cat_order";
		
	   $query = $this->db->query($sql);
	


	   foreach ($query->result_array() as $row)
	   {
		     
		   $object = new StdClass;
		   $object->cat_id = $row['cat_id'];
		   $object->cat_name =str_repeat('-',$level)." ".$row['cat_name'];
	
		   $retArray[] = $object;
	       $this->display_child($row['cat_id'], $level+1,$retArray); 
		   // edit by nganly
	
	   }   
	}
	
	function ajax(){
		$this->load->model('shop_category_model');
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->shop_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}
	
	function danh_muc_san_pham()
	{
        #BEGIN: Delete
		$this->load->model('shop_category_model');
		//var_dump($this->input->post('checkone')) ;die();
	
		if($this->uri->segment(4)=="delete")
		{
           
		   
		   
			$this->shop_category_model->delete((int)$this->uri->segment(5), "cat_id");
			redirect(''.base_url().'administ/shop/danhmuc/', 'location');
			
				
		
		}
		
		
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'cat_order';
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
			switch(strtolower($getVar['sort']))
			{
				case 'name':
				    $pageUrl .= '/sort/name';
				    $sort = "cat_name";
				    break;
				case 'order':
				    $pageUrl .= '/sort/order';
				    $sort = "cat_order";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "cat_id";
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
		$data['sortUrl'] = base_url().'administ/shop/danhmuc'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/shop/danhmuc'.$statusUrl;
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
				    $this->shop_category_model->update(array('cat_status'=>1), "cat_id = ".(int)$getVar['id']);
				  
					break;
				case 'deactive':
				    $this->shop_category_model->update(array('cat_status'=>0), "cat_id = ".(int)$getVar['id']);
	
					break;
			}
			redirect($data['statusUrl'], 'location');
		}
	
		#END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->shop_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/shop/danhmuc'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#sTT - So thu tu
			
		#Fetch record	
		$limit = settingOtherAdmin;
		$retArray = array();	
		
		$this->loadCategory2(0,0,$retArray, $where, $sort, $by);
		$data['category'] = $retArray;		
		$this->load->view('admin/shop/defaults_category', $data);
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
		$category  = $this->shop_category_model->fetch($select, $whereTmp);
	
	   foreach ($category as $row)
	   {
		  
		   $row->cat_name = $row->cat_name;
		   $retArray[] = $row;
	       $this->loadCategory2($row->cat_id, $level+1,$retArray);
		   //edit by nganly
				
	   }

		
	}
	
	
	function _exist_link()
	{
        if(count($this->shop_model->get("sho_id", "sho_link = '".trim(strtolower($this->filter->injection_html($this->input->post('link_shop'))))."'")) > 0)
		{
			return false;
		}
		return true;
	}
	
	function _valid_link($str)
	{
		$reject = array('home', 'product', 'ads', 'job', 'employ', 'defaults', 'shop', 'notify', 'guide', 'add', 'activation', 'post', 'delete', 'edit', 'view', 'register', 'login', 'showcart', 'forgot', 'status', 'sort', 'by', 'contact', 'search', 'account', 'logout', 'adm', 'admi', 'admin', 'admini', 'adminis', 'administ', 'administr', 'administra', 'administrat', 'administrato', 'administrator', 'quantri', 'system', 'media', 'templates', 'index', 'robots', '.htaccess', 'application', 'language', 'vietnamese', 'english', 'model', 'database', 'view', 'js', 'images', 'banners', 'logos');
        foreach($reject as $rejectArray)
        {
			if(trim(strtolower($str)) == $rejectArray)
			{
				return false;
			}
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
	
	function _valid_website($str)
	{
        if(preg_match('/[^0-9a-z_.-]/i', $str))
		{
			return false;
		}
		return true;
	}

	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('endmonth_shop'), (int)$this->input->post('endday_shop'), (int)$this->input->post('endyear_shop'));
		if($this->check->is_more($currentDate, $endDate))
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

    //by BaoTran, Config discount for each shop
    function configdiscount_rate($userId){

        #BEGIN: CHECK PERMISSION
        if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'shop_edit'))
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

            #Load model
            $this->load->model('shop_model');

            $shopedit = $this->shop_model->fetch_join("use_username, use_fullname, sho_discount_rate, sho_id, sho_user ", "LEFT", "tbtt_user", "tbtt_shop.sho_user = tbtt_user.use_id", "", "", "", "tbtt_user.use_id = " . (int)$userId, "" , "" , 0, 0, false);

            #BEGIN: Get shop by $userId
			if(count($shopedit) != 1 || !$this->check->is_id($userId))
			{
				redirect(base_url().'administ/shop/all', 'location');
				die();
			}
			#END Get shop by $userId
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('num_discount', 'lang:order_label_edit', 'trim|required');
			$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));

			if($this->form_validation->run() != FALSE)
			{   
				$dataEdit = array('sho_discount_rate' => (int)$this->input->post('num_discount'));
				if($this->shop_model->update($dataEdit, "sho_user = ".(int)$userId))
				{
     				$this->session->set_flashdata('sessionSuccessEdit', 1);
				}
				redirect(base_url().'administ/shop/all', 'location');
			}
			else
	        {		        				
				$data['discountshop'] =  $shopedit[0]->use_username;
				$data['percent_discount'] = $shopedit[0]->sho_discount_rate;
	        }
        }

        #Load view
        $this->load->view('admin/shop/configdiscountrate', $data);
    }
}