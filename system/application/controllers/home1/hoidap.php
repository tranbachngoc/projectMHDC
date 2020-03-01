<?php
#****************************************#
# * @Author: tuanflour                   #
# * @Email: tuannguyen@icsc.vn           #
# * @Website: http://www.icsc.vn  #
# * @Copyright: 2006 - 2012              #
#****************************************#
class Hoidap extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#CHECK SETTING
		if((int)settingStopSite == 1)
		{
            $this->lang->load('home/common');
			show_error($this->lang->line('stop_site_main'));
			die();
		}
		#END CHECK SETTING
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/hoidap');
		#Load model
		$this->load->model('hds_model');
		$this->load->model('answers_model');
		$this->load->model('hd_category_model');
		$this->load->model('shop_model');
		$this->load->model('product_model');
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN Eye
		if($this->session->userdata('sessionUser')>0){
			$this->load->model('eye_model');			
			$data['listeyeproduct']=$this->eye_model->geteyetype('product',$this->session->userdata('sessionUser'));		
			$data['listeyeraovat']=$this->eye_model->geteyetype('raovat',$this->session->userdata('sessionUser'));
			$data['listeyehoidap']=$this->eye_model->geteyetype('hoidap',$this->session->userdata('sessionUser'));
						
		}else{
			array_values($this->session->userdata['arrayEyeSanpham']);
			array_values($this->session->userdata['arrayEyeRaovat']);
			array_values($this->session->userdata['arrayEyeHoidap']);
			$this->load->model('eye_model');
			$data['listeyeproduct']=$this->eye_model->geteyetypenologin('product');			
			$data['listeyeraovat']=$this->eye_model->geteyetypenologin('raovat');
			$data['listeyehoidap']=$this->eye_model->geteyetypenologin('hoidap');
		}
		#END Eye
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('ads_model');
		$this->load->model('notify_model');
		$this->load->model('category_model');
		$data['menuType'] = 'hoidap';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
		#BEGIN: Notify
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "not_id, not_title, not_detail, not_degree";
		$this->db->limit(settingNotify);
		$this->db->order_by("not_id", "DESC"); 
		$data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
		#END Notify
		$this->load->helper('time');	
		$this->load->helper('text');
		
		$this->load->vars($data);
		
		#END Ads & Notify Taskbar
	}

	function loadCategory($parent, $level)
	{
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   //$link = anchor('hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => ''));
			   $link = '<a href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
			   if($key == 0){
			   		$retArray .= "<li class='menu_item_top dc-mega-li'>".$link;
			   }else if($key == count($category)-1){
			   		$retArray .= "<li class='menu_item_last dc-mega-li'>".$link;
			   }else{
			   		$retArray .= "<li class='dc-mega-li'>".$link;
			   }
			   $retArray .=$this->loadSubCategory($row->cat_id, $level+1);
			   $retArray .= "</li>";
		   }
		     $retArray .= "</ul>";
	   }
	   return $retArray;
	}
	function hoi_dap_xau()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$id_hds = $this->input->post('id_hds');
		$id_user = (int)$this->input->post('id_user');	
	
		$this->load->model('hds_bad_model');
		
				$dataFailAdd = array(									
										'adb_ads'   	=>      $id_hds,
										'adb_user_id'   =>      $id_user,
										'adb_date'      =>      $currentDate
										);
				if($this->hds_bad_model->add($dataFailAdd))
				{
					echo "Báo cáo thành công";
				}
				
				
	}
	function tra_loi_xau()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$id_hds = $this->input->post('id_hds');
		$id_user = (int)$this->input->post('id_user');	
	
		$this->load->model('hds_re_bad_model');
		
				$dataFailAdd = array(									
										'adb_ads'   	=>      $id_hds,
										'adb_user_id'   =>      $id_user,
										'adb_date'      =>      $currentDate
										);
				if($this->hds_re_bad_model->add($dataFailAdd))
				{
					echo "Báo cáo thành công";
				}
				
				
	}
	function loadSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega' style='padding-top:0;'>";
			$retArray .= "<ul class='sub'>";
/*			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 380;}
			if(count($category) >= 3){$rowwidth = 570;}*/
			foreach ($category as $key=>$row)
			{
				$link = '<a class="mega-sub-link" href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				/*if($key % 3 == 0){
					$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 2 || $key = count($category)-1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
					$retArray .= "</div>";
				}*/
				$retArray .= "<li class='sub_menu'>".$link."</li>";
			}
			$retArray .= "</ul></div>";
	   }
	   return $retArray;
	}
	function loadSubSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor('hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	function index()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['titleSiteGlobal'] = settingTitleHoidap;
		$data['descrSiteGlobal'] = settingDescrHoidap;
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#Begin: Load base on type hoidap
		$start = 0;
		$limit = 5;
		$shop_logo_dir = 'media/shop/logos/';
		$topNews = $this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id  = tbtt_hds.hds_user","", "", "","hds_status = 0","hds_id","DESC",$start,$limit);
		
		$data['topNews'] = $topNews;
		$topNotAnswers = $this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id","LEFT", "tbtt_user","tbtt_user.use_id = tbtt_hds.hds_user", "", "", "","hds_status = 0 AND hds_answers = 0","hds_id","DESC",$start,$limit);
		
		$data['topNotAnswers'] = $topNotAnswers;
		$topAnswers = $this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id","LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user", "", "", "","hds_status = 0 ","hds_answers","DESC",$start,$limit);
		
		$data['topAnswers'] = $topAnswers;
		$topViews = $this->hds_model->fetch_join("*,cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id","LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user", "", "", "","hds_status = 0 ","hds_view","DESC",$start,$limit);
		
		$data['topViews'] = $topViews;
		$topLikes = $this->hds_model->fetch_join("*,cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id","LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user", "", "", "","hds_status = 0 ","hds_like","DESC",$start,$limit);
		
		$data['topLikes'] = $topLikes;
		#End
		#Load view
		$this->load->view('home/hoidap/defaults', $data);
	}
	function latest()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0";
		$sort = 'hds_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/moinhat/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/moinhat/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$newHoidap = $this->hds_model->fetch_join("*, cat_name,avatar","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		$data['newHoidap'] = $newHoidap;
				
		$this->load->view('home/hoidap/latest', $data);
		
	}
	function notanswers()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0 AND hds_answers = 0";
		$sort = 'hds_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/chuatraloi/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/chuatraloi/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$notAnswer = $this->hds_model->fetch_join("*, cat_name,avatar","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		
		$data['notAnswer'] = $notAnswer;
		$this->load->view('home/hoidap/notanswers', $data);
	}
	function topanswers()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0";
		$sort = 'hds_answers';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		
		$data['sortUrl'] = base_url().'hoidap/traloinhieunhat/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/traloinhieunhat/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$topAnswer = $this->hds_model->fetch_join("*, cat_name,avatar","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		
		$data['topAnswer'] = $topAnswer;
		$this->load->view('home/hoidap/topanswers', $data);
	}
	function topviews()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0";
		$sort = 'hds_view';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/xemnhieunhat/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/xemnhieunhat/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$topView = $this->hds_model->fetch_join("*, cat_name,avatar","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		
		$data['topView'] = $topView;
		$this->load->view('home/hoidap/topviews', $data);		
	}
	function toplikes()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0";
		$sort = 'hds_like';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/coichnhat/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/coichnhat/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$topLike = $this->hds_model->fetch_join("*, cat_name,avatar","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		
		$data['topLike'] = $topLike;
		$this->load->view('home/hoidap/toplikes', $data);
	}
	function category($categoryID)
	{
		$this->load->model('hd_category_model');
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		$linkDetail = $this->uri->segment(2);		 
		
		$siteGlobal = $this->hd_category_model->get("*", "cat_id = '".$linkDetail."'");
		$data['siteGlobal'] = $siteGlobal;		  	
		$data['shop_glonal_conten']=$this->loadSubSubCategory($linkDetail);			
		$CategoryPro = $this->hd_category_model->get("*", "cat_id = '".$siteGlobal->parent_id."'");
		$data['CategorysiteGlobal'] = $CategoryPro;
		$data['CategorysiteGlobalConten']=$this->loadSubSubCategory($CategoryPro->cat_id);		  
		
		$CategoryRoot = $this->hd_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		$data['CategorysiteGlobalRoot'] = $CategoryRoot;			 
		$data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryRoot->cat_id);
		
		$CategoryRoot = $this->hd_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		$data['CategorysiteGlobalRoot'] = $CategoryRoot;
		
		$data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryRoot->cat_id);			 
		  
		#BEGIN: Check exist category by $categoryID
		$category = $this->hd_category_model->get("cat_id,cat_name,cat_level,cat_descr, keyword, h1tag", "cat_id = ".(int)$categoryID." AND cat_status = 1");
		if(count($category) != 1 || !$this->check->is_id($categoryID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist category by $categoryID
		#BEGIN get sub cat
		$listcat = '';
		if($category->cat_level == 0){
			// get sub category level 1
			$catlevel1 = $this->hd_category_model->fetch("cat_id,cat_name","cat_level = 1 AND parent_id = ".(int)$category->cat_id);
			if(isset($catlevel1) && count($catlevel1) > 0){
				foreach($catlevel1 as $key=>$item){
					// get sub category level 2
					$catitemlv2 = $this->hd_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$item->cat_id);
					$catlevel1[$key]->cat_level2 = $catitemlv2;
					if(count($catitemlv2) >0){
						foreach($catitemlv2 as $itemlv2){
							if($listcat ==''){
								$listcat .=$itemlv2->cat_id;
							}else{
								$listcat .=','.$itemlv2->cat_id;
							}
						}
					}else{
						if($listcat ==''){
							$listcat .=$item->cat_id;
						}else{
							$listcat .=','.$item->cat_id;
						}
					}
				}
			}else{
				$listcat = (int)$category->cat_id;
			}
			$data['categorylv1'] = $catlevel1;
		}
		if($category->cat_level == 1){
			$catlevel2 = $this->hd_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$category->cat_id);
			$data['categorylv2'] = $catlevel2;
			if(count($catlevel2) >0){
				foreach($catlevel2 as $itemlv2){
					if($listcat ==''){
						$listcat .=$itemlv2->cat_id;
					}else{
						$listcat .=','.$itemlv2->cat_id;
					}
				}
			}else{
				$listcat = (int)$category->cat_id;
			}
		}
		if($category->cat_level == 2){
			$listcat = (int)$categoryID;
		}
		#END
		$categoryIDQuery = (int)$categoryID;
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
			
		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Sort
		$where = "hds_status = 0 AND hds_category IN(".$listcat.")";
		$sort = 'hds_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingProductNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 2;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingProductNew_Category;
		$cate = $this->hds_model->fetch_join("*, cat_name,avatar,use_fullname,use_id,use_username,use_email,use_sex,use_phone,use_yahoo,use_skype,up_date","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);		
		$data['cat'] = $cate;
		$data['cat_name'] = $category->cat_name;		
		if($category->h1tag!=''){
			$data['titleSiteGlobal'] = str_replace(",", "|", $category->h1tag);
		}else{
			$data['titleSiteGlobal'] = $category->cat_name;
		}
		$data['keywordSiteGlobal'] = $category->keyword;
		$data['h1tagSiteGlobal'] = $category->h1tag;
		$this->load->helper('text');
		$data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)),255);		
		$this->load->view('home/hoidap/category', $data);
	}
	function detail($categoryID, $hdsID)
	{
		if($this->session->userdata('sessionUser')>0){
		
			$this->load->model('eye_model');
			
			$dataEye = array(
				'idview'      =>     $hdsID ,
				'userid'      =>     $this->session->userdata('sessionUser') ,
				'typeview'      =>     3,
				'timeview'          =>     1							
			);
			
			$checkEye = $this->eye_model->fetch("*","idview = ".$hdsID." AND userid= ".$this->session->userdata('sessionUser')." AND typeview = 3 ", "id",'DESC');
			if(count($checkEye)==0)
			$this->eye_model->add($dataEye);
					
		}else{
			$check=0;
			
			foreach($this->session->userdata('arrayEyeHoidap') as $pitem){
				if($pitem==$hdsID)	
					$check=1;		
			}
			
			if($check==0){
				$this->session->userdata['arrayEyeHoidap'][] = $hdsID;
				$this->session->sess_write();	
			}	
		}	
		
		#BEGIN Eye
		if($this->session->userdata('sessionUser')>0){
			$this->load->model('eye_model');			
			$data['listeyeproduct']=$this->eye_model->geteyetype('product',$this->session->userdata('sessionUser'));		
			$data['listeyeraovat']=$this->eye_model->geteyetype('raovat',$this->session->userdata('sessionUser'));
			$data['listeyehoidap']=$this->eye_model->geteyetype('hoidap',$this->session->userdata('sessionUser'));
						
		}else{
			array_values($this->session->userdata['arrayEyeSanpham']);
			array_values($this->session->userdata['arrayEyeRaovat']);
			array_values($this->session->userdata['arrayEyeHoidap']);
			$this->load->model('eye_model');
			$data['listeyeproduct']=$this->eye_model->geteyetypenologin('product');			
			$data['listeyeraovat']=$this->eye_model->geteyetypenologin('raovat');
			$data['listeyehoidap']=$this->eye_model->geteyetypenologin('hoidap');
		}
		#END Eye
			
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 'index';
		$data['menuType'] = 'hoidap';
		$data["raovat_sub"]=$this->loadSubSubCategory(0);
		
		$this->load->model('category_model');
		$this->load->model('hd_category_model');
		
		$data['relatedQuestion'] = $this->hds_model->fetch("*","hds_category = ".$categoryID." AND hds_id <> ".$hdsID);
		
		  $linkDetail = $this->uri->segment(2);
		  $shop = $this->hd_category_model->get("*", "cat_id = '".$linkDetail."'");
		  
		  $data['siteGlobal'] = $shop;
		  
		  $data['shop_glonal_conten']=$this->loadSubSubCategory($shop->cat_id);
		  	
		    $CategoryPro = $this->hd_category_model->get("*", "cat_id = '".$shop->parent_id."'");
		    $data['CategorysiteGlobal'] = $CategoryPro;
			$data['CategorysiteGlobalConten']=$this->loadSubSubCategory($CategoryPro->cat_id);
			 $CategoryProRoot = $this->hd_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		    $data['CategorysiteGlobalRoot'] = $CategoryProRoot;
			 $data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryProRoot->cat_id);
			 
			
			
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		$data['module'] = 'top_saleoff_shop,top_view_ads,top_buyest_product';
		#BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Check exist category by $categoryID
		$category = $this->hd_category_model->get("cat_id", "cat_id = ".(int)$categoryID." AND cat_status = 1");
		if(count($category) != 1 || !$this->check->is_id($categoryID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist category by $categoryID
		$categoryIDQuery = (int)$categoryID;
		#BEGIN: Check exist ads by $adsID
		$hdsa = $this->hds_model->fetch_join("*, cat_name,sho_dir_logo,sho_logo,use_fullname","LEFT", "tbtt_shop", "tbtt_shop.sho_user = tbtt_hds.hds_user","LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_hds.hds_user","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "hds_id = ".(int)$hdsID." AND hds_category = ".$categoryIDQuery." AND hds_status = 0");
		$hds = $hdsa[0];
		if(count($hds) != 1 || !$this->check->is_id($hdsID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist ads by $hdsID
		$hdsIDQuery = (int)$hdsID;
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewHds_'.$hdsIDQuery))
		{
            $this->hds_model->update(array('hds_view' => (int)$hds->hds_view + 1), "hds_id = ".$hdsIDQuery);
            $this->session->set_userdata('sessionViewHds_'.$hdsIDQuery, 1);
		}
		#END Update view
		#Assign title and description for site
		$data['titleSiteGlobal'] = $hds->hds_title." | ".$shop->cat_name;
		$this->load->helper('text');		
		$data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($hds->hds_content)),255);
		
		$data['h1tagSiteGlobal'] = $hds->hds_title;
		#BEGIN: Get ads by $adsID and relate info
		$hds->hds_content = htmlspecialchars_decode(html_entity_decode($hds->hds_content));
		$shop_logo_dir = 'media/shop/logos/';		
		if(!file_exists($shop_logo_dir.$hds->sho_dir_logo.'/'.$hds->sho_logo)){
			$hds->sho_logo = 'icon_noAvatar.png';
		}
		$data['hds'] = $hds;		
		#BEGIN: Sort
		$where = "hds_id =".(int)$hds->hds_id;
		$sort = 'answers_id';
		$by = 'ASC';
		$pageSort = '';
		$pageUrl = '';
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'hoidap/category/detail/'.$categoryIDQuery.'/'.$hdsIDQuery.'/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->answers_model->fetch("answers_id", $where, "", ""));
        $config['base_url'] = base_url().'hoidap/category/detail/'.$categoryIDQuery.'/'.$hdsIDQuery.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsCategory;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$limit = settingAdsCategory;
		$hds_answers = $this->answers_model->fetch_join("*, sho_dir_logo,sho_logo,use_fullname,avatar","LEFT", "tbtt_shop", "tbtt_shop.sho_user = tbtt_answers.answers_user","LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_answers.answers_user","", "", "", $where, $sort, $by, $start, $limit);
		$shop_logo_dir = 'media/shop/logos/';		
		for($i=0;$i<count($hds_answers); $i++){
			if(!file_exists($shop_logo_dir.$hds_answers[$i]->sho_dir_logo.'/'.$hds_answers[$i]->sho_logo)){
				$hds_answers[$i]->sho_logo = 'icon_noAvatar.png';
			}
			$hds_answers[$i]->answers_content = htmlspecialchars_decode(html_entity_decode($hds_answers[$i]->answers_content));
		}
		$data['hds_answers'] = $hds_answers;
		$data['totalRecord'] = $totalRecord;
		#BEGIN: User
        $this->load->model('user_model');
		$user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = ".(int)$this->session->userdata('sessionUser'));
		$data['user_id']= (int)$this->session->userdata('sessionUser');
        #END User
		#BEGIN: Create captcha post ads
			$aCaptcha = $this->createCaptcha(md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'posa.jpg');
	        if(!empty($aCaptcha)) {
	            $data['captcha']                = $aCaptcha['captcha']; 
	            $data['imageCaptchaPostHdsReply']    = $aCaptcha['imageCaptchaContact'];

	            $this->session->set_userdata('sessionCaptchaPostHdsReply', $data['captcha']);
	            $this->session->set_userdata('sessionPathCaptchaPostHdsReply', $data['imageCaptchaContact']); 
	        }
		#END Create captcha post ads
		if($this->input->post('isPostHdsReply'))
		{
				$dataPost = array(
					                    'hds_id'      	=>      $hds->hds_id,
					                    'answers_content'     	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'answers_user'  	=>      (int)$this->session->userdata('sessionUser'),
					                    'answers_username'  	=>      $user->use_fullname,
					                    'answers_like' 	=>      0,
					                    'answers_unlike'   	=>      0
								);
				if($this->answers_model->add($dataPost))
				{
					$this->hds_model->update(array('hds_answers' => (int)$hds->hds_answers + 1),"hds_id =".(int)$hds->hds_id);
					$this->session->set_flashdata('sessionSuccessPostHdsReply', 1);
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');	
		}
		if($this->input->post('isEditHdsReply'))
		{
			$this->answers_model->update(array('answers_content' => trim($this->filter->injection_html($this->input->post('txtContent')))),"answers_id =".(int)$this->input->post('editAnswerId'));
			redirect(base_url().trim(uri_string(), '/'), 'location');
		}
		#Load view
		$this->load->view('home/hoidap/detail', $data);
	}
	function post()
	{
        #BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url().'login', 'location');
			die();
		}
		#END CHECK LOGIN
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter		
		#BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostHds'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessPostHds'))
		{
            $data['successPostHds'] = true;
		}
		else
		{
			$data['successPostHds'] = false;
			#BEGIN: User
            $this->load->model('user_model');
			$user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = ".(int)$this->session->userdata('sessionUser'));
			$data['fullname_ads'] = $user->use_fullname;
			$data['address_ads'] = $user->use_address;
			$data['phone_ads'] = $user->use_phone;
			$data['mobile_ads'] = $user->use_mobile;
			$data['email_ads'] = $user->use_email;
			$data['yahoo_ads'] = $user->use_yahoo;
			$data['skype_ads'] = $user->use_skype;
            #END User
			#Begin: Category hoi dap
			$cat_level_0 = $this->hd_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
			if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->hd_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
			$data['catlevel0']=$cat_level_0;
			#End category
			if($this->input->post('isPostHds'))
			{
				$dataPost = array(
					                    'hds_title'      	=>      trim($this->filter->injection_html($this->input->post('title_hds'))),
					                    'hds_content'     	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'hds_category'  	=>      (int)$this->input->post('hd_category_id'),
					                    'hds_user'  	=>      (int)$this->session->userdata('sessionUser'),
					                    'hds_username' 	=>      trim($this->filter->injection_html($this->input->post('username_hds'))),
					                    'hds_email'   	=>      trim($this->filter->injection_html($this->input->post('user_email_hds'))),
					                    'hds_yahoo'    	=>      trim($this->filter->injection_html($this->input->post('user_yahoo_hds'))),
					                    'hds_skype'     	=>   trim($this->filter->injection_html($this->input->post('user_skype_hds'))),
					                    'hds_status'       	=>    0,
					                    'hds_view'      	=>     0,
					                    'hds_like'    	=>      0,
					                    'hds_unlike'   	=>      0
								);
				if($this->hds_model->add($dataPost))
				{
					$this->session->set_flashdata('sessionSuccessPostHds', 1);
				}
				redirect(base_url().trim(uri_string(), '/'), 'location');	
			}
		}
		#BEGIN: Create captcha post ads
		
			$aCaptcha = $this->createCaptcha(md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'posa.jpg');
	        if(!empty($aCaptcha)) {
	            $data['captcha']                = $aCaptcha['captcha']; 
	            $data['imageCaptchaPostHds']    = $aCaptcha['imageCaptchaContact'];

	            $this->session->set_userdata('sessionCaptchaPostHds', $data['captcha']);
	            $this->session->set_userdata('sessionPathCaptchaPostHds', $data['imageCaptchaContact']); 
	        }
            
			#END Create captcha post ads
		#Load view
		$data['menuType'] = 'account';
		$this->load->view('home/hoidap/post', $data);
	}
	function ajax(){
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->hd_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order, cat_id", "ASC");
		if(isset($cat_level)){
			foreach($cat_level as $key=>$item){
				$cat_level_next = $this->hd_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level[$key]->child_count = count($cat_level_next);
			}
		}
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}
	function ajaxvote(){
		$hdsid = (int)$this->input->post('hdsid');
		$type = $this->input->post('type');
		$hds = $this->hds_model->get("*","hds_id = ".$hdsid);
		if($type =='up'){
			$this->hds_model->update(array('hds_like' => (int)$hds->hds_like + 1),"hds_id = ".$hdsid);
			echo (int)$hds->hds_like + 1;
		}else{
			$this->hds_model->update(array('hds_unlike' => (int)$hds->hds_like + 1),"hds_id = ".$hdsid);
			echo (int)$hds->hds_unlike + 1;
		}
	}
	function ajaxvoteans(){
		$answersid = (int)$this->input->post('answersid');
		$type = $this->input->post('type');
		$ans = $this->answers_model->get("*","answers_id = ".$answersid);
		if($type =='up'){
			$this->answers_model->update(array('answers_like' => (int)$ans->answers_like + 1),"answers_id = ".$answersid);
			echo (int)$ans->answers_like + 1;
		}else{
			$this->answers_model->update(array('answers_unlike' => (int)$ans->answers_unlike + 1),"answers_id = ".$answersid);
			echo (int)$ans->answers_unlike + 1;
		}
	}
	function ajaxdeleteans()
	{
		$answersid = (int)$this->input->post('answersid');
		$hdsid = (int)$this->input->post('hdsid');
		$hds = $this->hds_model->get("*","hds_id = ".$hdsid);
		if($this->answers_model->delete($answersid,"answers_id")){
			$this->hds_model->update(array('hds_answers' => (int)$hds->hds_answers -1),"hds_id = ".$hdsid);
			echo '1';
		}
	}
	//Code added by KACH
	
	//End code added by KACH
}










