<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Product extends CI_Controller
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
		$this->lang->load('admin/product');
		#Load model
		$this->load->model('product_model');
		#BEGIN: Delete
		if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0)
		{
            #BEGIN: CHECK PERMISSION
			if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_delete'))
			{
				show_error($this->lang->line('unallowed_use_permission'));
				die();
			}
			#END CHECK PERMISSION
			$this->load->model('product_favorite_model');
			$this->load->model('product_comment_model');
			$this->load->model('product_bad_model');
			$this->load->model('showcart_model');
			$idProduct = $this->input->post('checkone');
			$this->product_favorite_model->delete($idProduct, "prf_product");
			$this->product_comment_model->delete($idProduct, "prc_product");
			$this->product_bad_model->delete($idProduct, "prb_product");
			$this->showcart_model->delete($idProduct, "shc_product");
			#Remove image
			$this->load->library('file');
			$listIdProduct = implode(',', $idProduct);
			$product = $this->product_model->fetch("pro_image, pro_dir", "pro_id IN($listIdProduct)", "", "");
			foreach($product as $productArray)
			{
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
			$this->product_model->delete($idProduct, "pro_id");
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#END Delete
	}
	
	function index()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		#BEGIN: Search & Filter
		$where = '';
		$sort = 'pro_begindate';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = ''; 
		$pro_type = $this->uri->segment(2);

		//$data['pro_type'] = "";
		if ($pro_type == 'product'){
            $getVar = $this->uri->uri_to_assoc(3, $action);
			$where .='pro_type = 0';
            $pageUrl .= '/product';
            $sortUrl .= '/product';
		}elseif ($pro_type == 'service'){
            $getVar = $this->uri->uri_to_assoc(4, $action);
			$where .='pro_type = 1';
            $pageUrl .= '/service/product';
            $sortUrl .= '/service/product';
		}elseif ($pro_type == 'coupon'){
            $getVar = $this->uri->uri_to_assoc(4, $action);
			$where .='pro_type = 2';
            $pageUrl .= '/coupon/product';
            $sortUrl .= '/coupon/product';
		}	


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
                case 'cost':
				    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $where .= " AND pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
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
                case 'begindate':
				    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $where .= " AND pro_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND pro_enddate = ".(float)$getVar['key'];
				    break;
				case 'affiliate':
				    $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
				    $where .= " AND is_product_affiliate = 1";
				    break;
                case 'admin':
                    $sortUrl .= '/filter/admin/key/'.$getVar['key'];
                    $pageUrl .= '/filter/admin/key/'.$getVar['key'];
                    $where .= " AND is_asigned_by_admin = 1";
                    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND pro_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND pro_status = 0";
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
		$data['sortUrl'] = base_url().'administ'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ'.$statusUrl;
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


        if($getVar['admin'] != FALSE && trim($getVar['admin']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0)
        {

            #BEGIN: CHECK PERMISSION
            if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
            {
                show_error($this->lang->line('unallowed_use_permission'));

                die();
            }

            #END CHECK PERMISSION
            switch(strtolower($getVar['admin']))
            {
                case 'active':
                    $this->product_model->update(array('is_asigned_by_admin'=>1), "pro_id = ".(int)$getVar['id']);
                    break;
                case 'deactive':
                    $this->product_model->update(array('is_asigned_by_admin'=>0), "pro_id = ".(int)$getVar['id']);
                    break;
            }

            redirect($data['statusUrl'], 'location');
        }
        #END Status
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ'.$pageUrl.'/page/';
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
		$this->load->model('shop_category_model');
		$cat_level_0 = $this->shop_category_model->fetch("cat_id, cat_name", "parent_id = 0 AND cat_status = 1", "cat_name", "ASC");
		if (isset($cat_level_0)) {
			foreach ($cat_level_0 as $key => $item) {
				$cat_level_1 = $this->shop_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
				$data['cat_level_1'] = $cat_level_1;
				//$cat_level_0[$key]->child_count = count($cat_level_1);
			}
		}
		$data['shop_name'] = $cat_level_0;
		$select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, af_rate, af_amt, af_dc_rate, af_dc_amt, pro_begindate, pro_enddate, , is_product_affiliate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email,pro_vip, is_asigned_by_admin,id_shop_cat";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='product' && $this->uri->segment(3)==''){
			$this->db->order_by("pro_id", "DESC"); 
		}
		$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view

		$this->load->view('admin/product/defaults', $data);
	}
	function anhang(){
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		$this->load->model('product_model');
		$id_pro = $this->input->post('id');
		$active = $this->input->post('active');
		$id_cat = $this->input->post('id_cat');
		if($active == 1){
			$this->product_model->update(array('is_asigned_by_admin'=>1, 'id_shop_cat'=>(int)$id_cat), "pro_id = ".(int)$id_pro);
			echo '1';
		}elseif($active == 0){
			$this->product_model->update(array('is_asigned_by_admin'=>0,'id_shop_cat' =>0), "pro_id = ".(int)$id_pro);
			echo '2';
		}else{
			echo '0';
		}
		exit();
	}
	function end()
	{
            
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Update status = deactive
		if(!isset($_COOKIE['_cookieSetStatus']) || (isset($_COOKIE['_cookieSetStatus']) && !stristr(strtolower($_COOKIE['_cookieSetStatus']), 'product')))
		{
            $this->product_model->update(array('pro_status'=>0), "pro_enddate < $currentDate");
            if(isset($_COOKIE['_cookieSetStatus']))
            {
                setcookie('_cookieSetStatus', $_COOKIE['_cookieSetStatus'].'-product');
            }
            else
            {
                setcookie('_cookieSetStatus', 'product');
            }
		}
		#END Update status = deactive
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = "pro_enddate < $currentDate";
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
				    $where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'cost':
				    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $where .= " AND pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
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
                case 'begindate':
				    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $where .= " AND pro_begindate = ".(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " AND pro_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= " AND pro_status = 1";
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= " AND pro_status = 0";
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
		$data['sortUrl'] = base_url().'administ/product/end'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
        $config['base_url'] = base_url().'administ/product/end'.$pageUrl.'/page/';
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
		$select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='product' && $this->uri->segment(3)=='end' && $this->uri->segment(4)==''){
			$this->db->order_by("pro_id", "DESC"); 
		}
		$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('admin/product/end', $data);
	}
	
	function bad()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('product_bad_model');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'detail');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
			#BEGIN: Delete product bad
			if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
			{
				$this->product_bad_model->delete((int)$this->input->post('idBad'), "prb_id", false);
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete product bad
            #If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
			}
			else
			{
				$start = 0;
			}
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->product_bad_model->fetch("prb_id", "prb_product = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/product/bad/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['product'] = $this->product_bad_model->fetch("*", "prb_product = ".(int)$getVar['detail'], "prb_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/product/bad_detail', $data);
		}
		else
		{
			#BEGIN: Fetch product bad
			$productBad = $this->product_bad_model->fetch("prb_product", "prb_price_out = 0", "", "", "prb_product");
			$idProductBad = array();
			foreach($productBad as $productBadArray)
			{
				$idProductBad[] = $productBadArray->prb_product;
			}
			#END Fetch product bad
			if(count($idProductBad) > 0)
			{
                $data['haveProductBad'] = true;
                $idProductBad = implode(',', $idProductBad);
                #BEGIN: Search & Filter
				$where = "pro_id IN($idProductBad) ";
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
						    $where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
		                case 'cost':
						    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
						    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
						    $where .= " AND pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
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
		                case 'begindate':
						    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
						    $where .= " AND pro_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND pro_enddate = ".(float)$getVar['key'];
						    break;
							
						case 'affiliate':
						    $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
						    $where .= " AND is_product_affiliate = 1";
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND pro_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND pro_status = 0";
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
				$data['sortUrl'] = base_url().'administ/product/bad'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/product/bad'.$statusUrl;
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
				#END Status
				#BEGIN: Pagination
				$this->load->library('pagination');
				#Count total record
				$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
		        $config['base_url'] = base_url().'administ/product/bad'.$pageUrl.'/page/';
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
				$select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, is_product_affiliate, cat_id, cat_name, use_id, use_username, use_email,prb_user_id,prb_date,pro_province,prb_title,prb_detail";
				$limit = settingOtherAdmin;
				if($this->uri->segment(2)=='product' && $this->uri->segment(3)=='bad' && $this->uri->segment(4)==''){
					$this->db->order_by("prb_date", "DESC"); 
				}
				$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_product_bad", "tbtt_product.pro_id = tbtt_product_bad.prb_product", $where, $sort, $by, $start, $limit,true);
			}
			else
			{
				$data['haveProductBad'] = false;
			}
			#Load view
			$this->load->view('admin/product/bad', $data);
		}
	}
	
	function hethang()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
		$this->load->model('product_bad_model');
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id', 'detail');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		if($getVar['detail'] != FALSE && (int)$getVar['detail'] > 0)
		{
			#BEGIN: Delete product bad
			if($this->input->post('idBad') && $this->check->is_id($this->input->post('idBad')))
			{
				$this->product_bad_model->delete((int)$this->input->post('idBad'), "prb_id AND prb_price_out = 1 ", false);
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			#END Delete product bad
            #If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
			}
			else
			{
				$start = 0;
			}
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->product_bad_model->fetch("prb_id", "prb_product = ".(int)$getVar['detail'], "", ""));
   			$config['base_url'] = base_url().'administ/product/bad/detail/'.$getVar['detail'].'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = 1;
			$config['num_links'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['product'] = $this->product_bad_model->fetch("*", "prb_product = ".(int)$getVar['detail'], "prb_date", "ASC", "", $start, 1);
			#Load view
			$this->load->view('admin/product/bad_detail', $data);
		}
		else
		{
			#BEGIN: Fetch product bad
			$productBad = $this->product_bad_model->fetch("prb_product", "prb_price_out = 1", "", "", "prb_product");
			$idProductBad = array();
			foreach($productBad as $productBadArray)
			{
				$idProductBad[] = $productBadArray->prb_product;
			}
			#END Fetch product bad
			if(count($idProductBad) > 0)
			{
                $data['haveProductBad'] = true;
                $idProductBad = implode(',', $idProductBad);
                #BEGIN: Search & Filter
				$where = "pro_id IN($idProductBad) ";
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
						    $where .= " AND pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
		                case 'cost':
						    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
						    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
						    $where .= " AND pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
						    break;
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
		                case 'begindate':
						    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
						    $where .= " AND pro_begindate = ".(float)$getVar['key'];
						    break;
						case 'enddate':
						    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
						    $where .= " AND pro_enddate = ".(float)$getVar['key'];
						    break;							
							
						case 'affiliate':
						    $sortUrl .= '/filter/affiliate/key/'.$getVar['key'];
						    $pageUrl .= '/filter/affiliate/key/'.$getVar['key'];
						    $where .= " AND is_product_affiliate = 1";
						    break;
		                case 'active':
						    $sortUrl .= '/filter/active/key/'.$getVar['key'];
						    $pageUrl .= '/filter/active/key/'.$getVar['key'];
						    $where .= " AND pro_status = 1";
						    break;
		                case 'deactive':
						    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
						    $where .= " AND pro_status = 0";
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
				$data['sortUrl'] = base_url().'administ/product/bad'.$sortUrl.'/sort/';
				$data['pageSort'] = $pageSort;
				#END Create link sort
				#BEGIN: Status
				$statusUrl = $pageUrl.$pageSort;
				$data['statusUrl'] = base_url().'administ/product/bad'.$statusUrl;
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
				#END Status
				#BEGIN: Pagination
				$this->load->library('pagination');
				#Count total record
				$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, "", ""));
		        $config['base_url'] = base_url().'administ/product/bad'.$pageUrl.'/page/';
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
				$select = "pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, is_product_affiliate, cat_id, cat_name, use_id, use_username, use_email,prb_user_id,prb_date,pro_province,prb_title,prb_detail";
				$limit = settingOtherAdmin;
				if($this->uri->segment(2)=='product' && $this->uri->segment(3)=='hethang' && $this->uri->segment(4)==''){
					$this->db->order_by("prb_date", "DESC"); 
				}
				$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_product_bad", "tbtt_product.pro_id = tbtt_product_bad.prb_product", $where, $sort, $by, $start, $limit,true);
			}
			else
			{
				$data['haveProductBad'] = false;
			}
			#Load view
			$this->load->view('admin/product/hethang', $data);
		}
	}
	
	function affiliate()
	{
        #BEGIN: CHECK PERMISSION
		if(!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_view'))
		{
			show_error($this->lang->line('unallowed_use_permission'));
			die();
		}
		#END CHECK PERMISSION
        #Define url for $getVar
		$action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: Search & Filter
		$where = 'tbtt_product.is_product_affiliate = 1 ';
		$sort = 'tbtt_product.pro_begindate';
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
				    $where .= "pro_name LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'cost':
				    $sortUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/cost/keyword/'.$getVar['keyword'];
				    $where .= "pro_cost LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
                case 'username':
				    $sortUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $pageUrl .= '/search/username/keyword/'.$getVar['keyword'];
				    $where .= "use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%'";
				    break;
			}
		}
		#If filter
		elseif($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '')
		{
			switch(strtolower($getVar['filter']))
			{
				case 'product_f':
				    $sortUrl .= '/filter/product_f/key/'.$getVar['key'];
				    $pageUrl .= '/filter/product_f/key/'.$getVar['key'];
				    $where .= ' AND pro_type = 0';
				    break;				    
				case 'service_f':
				    $sortUrl .= '/filter/service_f/key/'.$getVar['key'];
				    $pageUrl .= '/filter/service_f/key/'.$getVar['key'];
				    $where .= ' AND pro_type = 1';
				    break;
				case 'coupon_f':
				    $sortUrl .= '/filter/coupon_f/key/'.$getVar['key'];
				    $pageUrl .= '/filter/coupon_f/key/'.$getVar['key'];
				    $where .= ' AND pro_type = 2';
				    break;

                case 'begindate':
				    $sortUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/begindate/key/'.$getVar['key'];
				    $where .= ' AND pro_begindate = '.(float)$getVar['key'];
				    break;
				case 'enddate':
				    $sortUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $pageUrl .= '/filter/enddate/key/'.$getVar['key'];
				    $where .= " and pro_enddate = ".(float)$getVar['key'];
				    break;
                case 'active':
				    $sortUrl .= '/filter/active/key/'.$getVar['key'];
				    $pageUrl .= '/filter/active/key/'.$getVar['key'];
				    $where .= ' and pro_status = 1';
				    break;
                case 'deactive':
				    $sortUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $pageUrl .= '/filter/deactive/key/'.$getVar['key'];
				    $where .= 'and pro_status = 0';
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
                case 'af_rate':
                                    $pageUrl .= '/sort/af_rate';
				    $sort .= "af_rate";
                                    break;
                case 'af_amt':
                                    $pageUrl .= '/sort/af_amt';
				    $sort .= "af_amt";
                                    break;
                case 'af_cost':
				    $pageUrl .= '/sort/af_cost';
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
		$data['sortUrl'] = base_url().'administ/product/affiliate'.$sortUrl.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Status
		$statusUrl = $pageUrl.$pageSort;
		$data['statusUrl'] = base_url().'administ/product/affiliate'.$statusUrl;
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
        $config['base_url'] = base_url().'administ/product/affiliate'.$pageUrl.'/page/';
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
		$select = "is_product_affiliate, af_amt, af_rate, af_dc_amt, af_dc_rate, pro_id, pro_name, pro_category, pro_cost, pro_currency, pro_view, pro_status, pro_begindate, pro_enddate, pre_id, pre_name, cat_id, cat_name, use_id, use_username, use_email,pro_vip";
		$limit = settingOtherAdmin;
		if($this->uri->segment(2)=='product' && $this->uri->segment(3)==''){
			$this->db->order_by("pro_id", "DESC"); 
		}
		$data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product.pro_user = tbtt_user.use_id", "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", "LEFT", "tbtt_province", "tbtt_product.pro_province = tbtt_province.pre_id", $where, $sort, $by, $start, $limit);

                
		#Load view
		$this->load->view('admin/product/affiliate', $data);
	}
    
    function ajax()
    {
        if($this->input->post('id') && $this->check->is_id($this->input->post('id')) && $this->input->post('enddate'))
        {
            if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'product_edit'))
            {
                $id = (int)$this->input->post('id');
                $endDate = explode('-', $this->input->post('enddate'));
                if(isset($endDate[0]) && isset($endDate[1]) && isset($endDate[2]))
                {
                    $endDate = mktime(0, 0, 0, $endDate[1], $endDate[0], $endDate[2]);
                }
                else
                {
                    $endDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                }
                $product = $this->product_model->get("pro_id", "pro_id = $id");
                if(count($product) == 1)
                {
                    $this->product_model->update(array('pro_enddate'=>(int)$endDate), "pro_id = $id");
                }
            }
            else
            {
                echo $this->lang->line('unallowed_use_set_enddate_permission');
            }
        }
        else
        {
            show_404();
        }
    }
}