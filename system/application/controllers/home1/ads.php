<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Ads extends MY_Controller
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
		$this->lang->load('home/ads');
		#Load model
		$this->load->model('ads_model');
		$this->load->model('category_model');
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
		$this->load->model('notify_model');
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
		
		$this->load->vars($data);
		#END Ads & Notify Taskbar
		
	}
	function loadCategory($parent, $level)
	{
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   $link = anchor('ads/category/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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
	function loadSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega'>";
			$retArray .= "<ul class='sub'>";
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 380;}
			if(count($category) >= 3){$rowwidth = 570;}
			foreach ($category as $key=>$row)
			{
				$link = '<a class="mega-hdr-a" alt="'.$row->cat_name.'" href="'.base_url().'ads/category/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				if($key % 3 == 0){
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
				}
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
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					$link = anchor('ads/category/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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
		$data['menuSelected'] = 0;
		$data['menuType'] = 'ads';
			
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_index';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_shop_ads,top_view_ads';
        #BEGIN: Top shop ads right
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsShop_Top;
		$data['topShopAds'] = $this->ads_model->fetch($select, "ads_is_shop = 1 AND ads_status = 1 AND ads_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop ads right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#Define url for $getVar
		$action = array('rSort', 'rBy', 'rPage', 'nSort', 'nBy', 'nPage');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		#BEGIN: rSort
		$rWhere = "ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate";
		$rSort = 'rand()';
		$rBy = 'DESC';
		$rPageSort = '';
		$rPageUrl = '';
		if($getVar['rSort'] != FALSE && trim($getVar['rSort']) != '')
		{
			switch(strtolower($getVar['rSort']))
			{
				case 'title':
				    $rPageUrl .= '/rSort/title';
				    $rSort = "ads_title";
				    break;
                case 'date':
				    $rPageUrl .= '/rSort/date';
				    $rSort = "ads_begindate";
				    break;
                case 'place':
				    $rPageUrl .= '/rSort/place';
				    $rSort = "pre_name";
				    break;
                case 'view':
				    $rPageUrl .= '/rSort/view';
				    $rSort = "ads_view";
				    break;
				default:
				    $rPageUrl .= '/rSort/id';
				    $rSort = "ads_id";
			}
			if($getVar['rBy'] != FALSE && strtolower($getVar['rBy']) == 'desc')
			{
                $rPageUrl .= '/rBy/desc';
				$rBy = "DESC";
			}
			else
			{
                $rPageUrl .= '/rBy/asc';
				$rBy = "ASC";
			}
		}
		#If have page
		if($getVar['rPage'] != FALSE && (int)$getVar['rPage'] > 0)
		{
			$rStart = (int)$getVar['rPage'];
			$rPageSort .= '/rPage/'.$rStart;
		}
		else
		{
			$rStart = 0;
		}
		#END rSort
		#BEGIN: Create link rSort
		$data['rSortUrl'] = base_url().'ads/rSort/';
		$data['rPageSort'] = $rPageSort;
		#END Create link rSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'ads'.$rPageUrl.'/rPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsReliable_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $rStart;
		$this->pagination->initialize($config);
		$data['rLinkPage'] = $this->pagination->create_links();
		unset($config);
		#END Pagination
		#Fetch record
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$rLimit = settingAdsReliable_Category;
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, $rSort, $rBy, $rStart, $rLimit);
		#BEGIN: nSort
		$nWhere = "ads_status = 1 AND ads_enddate >= $currentDate";
		$nSort = 'ads_id';
		$nBy = 'DESC';
		$nPageSort = '';
		$nPageUrl = '';
		if($getVar['nSort'] != FALSE && trim($getVar['nSort']) != '')
		{
			switch(strtolower($getVar['nSort']))
			{
				case 'title':
				    $nPageUrl .= '/nSort/title';
				    $nSort = "ads_title";
				    break;
                case 'date':
				    $nPageUrl .= '/nSort/date';
				    $nSort = "ads_begindate";
				    break;
                case 'place':
				    $nPageUrl .= '/nSort/place';
				    $nSort = "pre_name";
				    break;
                case 'view':
				    $nPageUrl .= '/nSort/view';
				    $nSort = "ads_view";
				    break;
				default:
				    $nPageUrl .= '/nSort/id';
				    $nSort = "ads_id";
			}
			if($getVar['nBy'] != FALSE && strtolower($getVar['nBy']) == 'desc')
			{
                $nPageUrl .= '/nBy/desc';
				$nBy = "DESC";
			}
			else
			{
                $nPageUrl .= '/nBy/asc';
				$nBy = "ASC";
			}
		}
		#If have page
		if($getVar['nPage'] != FALSE && (int)$getVar['nPage'] > 0)
		{
			$nStart = (int)$getVar['nPage'];
			$nPageSort .= '/nPage/'.$nStart;
		}
		else
		{
			$nStart = 0;
		}
		#END nSort
		#BEGIN: Create link nSort
		$data['nSortUrl'] = base_url().'ads/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
        $config['base_url'] = base_url().'ads'.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$nLimit = settingAdsNew_Category;
		$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, $nSort, $nBy, $nStart, $nLimit);
		#Load view
		$this->load->view('home/ads/defaults', $data);
	}
	
	function category($categoryID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
		$category = $this->category_model->get("cat_id", "cat_id = ".(int)$categoryID." AND cat_status = 1");
		if(count($category) != 1 || !$this->check->is_id($categoryID))
		{
			redirect(base_url(), 'location');
			die();
		}
		
		#END Check exist category by $categoryID
		$categoryIDQuery = (int)$categoryID;
		#BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
		$data['menuType'] = 'ads';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_shop_ads,top_view_ads';
        #BEGIN: Top shop ads right
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsShop_Top;
		$data['topShopAds'] = $this->ads_model->fetch($select, "ads_is_shop = 1 AND ads_status = 1 AND ads_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop ads right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#Define url for $getVar
		$action = array('rSort', 'rBy', 'rPage', 'nSort', 'nBy', 'nPage');
		$getVar = $this->uri->uri_to_assoc(4, $action);
		#BEGIN: rSort
		$rWhere = "ads_category = $categoryIDQuery AND ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate";
		$rSort = '';
		$rBy = 'DESC';
		$rPageSort = '';
		$rPageUrl = '';
		if($getVar['rSort'] != FALSE && trim($getVar['rSort']) != '')
		{
			switch(strtolower($getVar['rSort']))
			{
				case 'title':
				    $rPageUrl .= '/rSort/title';
				    $rSort = "ads_title";
				    break;
                case 'date':
				    $rPageUrl .= '/rSort/date';
				    $rSort = "ads_begindate";
				    break;
                case 'place':
				    $rPageUrl .= '/rSort/place';
				    $rSort = "pre_name";
				    break;
                case 'view':
				    $rPageUrl .= '/rSort/view';
				    $rSort = "ads_view";
				    break;
				default:
				    $rPageUrl .= '/rSort/id';
				    $rSort = "ads_id";
			}
			if($getVar['rBy'] != FALSE && strtolower($getVar['rBy']) == 'desc')
			{
                $rPageUrl .= '/rBy/desc';
				$rBy = "DESC";
			}
			else
			{
                $rPageUrl .= '/rBy/asc';
				$rBy = "ASC";
			}
		}
		#If have page
		if($getVar['rPage'] != FALSE && (int)$getVar['rPage'] > 0)
		{
			$rStart = (int)$getVar['rPage'];
			$rPageSort .= '/rPage/'.$rStart;
		}
		else
		{
			$rStart = 0;
		}
		#END rSort
		#BEGIN: Create link rSort
		$data['rSortUrl'] = base_url().'ads/category/'.$categoryID.'/rSort/';
		$data['rPageSort'] = $rPageSort;
		#END Create link rSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'ads/category/'.$categoryID.$rPageUrl.'/rPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsReliable_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $rStart;
		$this->pagination->initialize($config);
		$data['rLinkPage'] = $this->pagination->create_links();
		unset($config);
		#END Pagination
		#Fetch record
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$rLimit = settingAdsReliable_Category;
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, $rSort, $rBy, $rStart, $rLimit);
		#BEGIN: nSort
		$nWhere = "ads_category = $categoryIDQuery AND ads_status = 1 AND ads_enddate >= $currentDate";
		$nSort = 'ads_id';
		$nBy = 'DESC';
		$nPageSort = '';
		$nPageUrl = '';
		if($getVar['nSort'] != FALSE && trim($getVar['nSort']) != '')
		{
			switch(strtolower($getVar['nSort']))
			{
				case 'title':
				    $nPageUrl .= '/nSort/title';
				    $nSort = "ads_title";
				    break;
                case 'date':
				    $nPageUrl .= '/nSort/date';
				    $nSort = "ads_begindate";
				    break;
                case 'place':
				    $nPageUrl .= '/nSort/place';
				    $nSort = "pre_name";
				    break;
                case 'view':
				    $nPageUrl .= '/nSort/view';
				    $nSort = "ads_view";
				    break;
				default:
				    $nPageUrl .= '/nSort/id';
				    $nSort = "ads_id";
			}
			if($getVar['nBy'] != FALSE && strtolower($getVar['nBy']) == 'desc')
			{
                $nPageUrl .= '/nBy/desc';
				$nBy = "DESC";
			}
			else
			{
                $nPageUrl .= '/nBy/asc';
				$nBy = "ASC";
			}
		}
		#If have page
		if($getVar['nPage'] != FALSE && (int)$getVar['nPage'] > 0)
		{
			$nStart = (int)$getVar['nPage'];
			$nPageSort .= '/nPage/'.$nStart;
		}
		else
		{
			$nStart = 0;
		}
		#END nSort
		#BEGIN: Create link nSort
		$data['nSortUrl'] = base_url().'ads/category/'.$categoryID.'/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
        $config['base_url'] = base_url().'ads/category/'.$categoryID.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$nLimit = settingAdsNew_Category;
		$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, $nSort, $nBy, $nStart, $nLimit);
		#Load view
		$this->load->view('home/ads/category', $data);
	}
	
	function shop()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'ads';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_lastest_ads,top_view_ads';
        #BEGIN: Top lastest ads right
		$select = "ads_id, ads_title, ads_descr, ads_category";
		$start = 0;
  		$limit = (int)settingAdsNew_Top;
		$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_id", "DESC", $start, $limit);
		#END Top lastest ads right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#Define url for $getVar
		$action = array('sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "ads_is_shop = 1 AND ads_status = 1 AND ads_enddate >= $currentDate";
		$sort = 'ads_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "ads_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "ads_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "ads_view";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "ads_id";
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
		#END Sort
		#BEGIN: Create link Sort
		$data['sortUrl'] = base_url().'ads/shop/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'ads/shop'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsShop;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$limit = settingAdsShop;
		$data['shopAds'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#Load view
		$this->load->view('home/ads/shop', $data);
	}
	
	function detail($categoryID, $adsID)
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
		$category = $this->category_model->get("cat_id", "cat_id = ".(int)$categoryID." AND cat_status = 1");
		if(count($category) != 1 || !$this->check->is_id($categoryID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist category by $categoryID
		$categoryIDQuery = (int)$categoryID;
		#BEGIN: Check exist ads by $adsID
		$ads = $this->ads_model->get("*", "ads_id = ".(int)$adsID." AND ads_category = $categoryIDQuery AND ads_status = 1 AND ads_enddate >= $currentDate");
		if(count($ads) != 1 || !$this->check->is_id($adsID))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END Check exist ads by $adsID
		$adsIDQuery = (int)$adsID;
		#BEGIN: Update view
		if(!$this->session->userdata('sessionViewAds_'.$adsIDQuery))
		{
            $this->ads_model->update(array('ads_view' => (int)$ads->ads_view + 1), "ads_id = ".$adsIDQuery);
            $this->session->set_userdata('sessionViewAds_'.$adsIDQuery, 1);
		}
		#END Update view
		$this->load->library('bbcode');
		$this->load->library('captcha');
		$this->load->library('form_validation');
        $this->load->helper('unlink');
		#BEGIN: Send friend & send fail
		$data['successSendFriendAds'] = false;
        $data['successSendFailAds'] = false;
		if($this->session->flashdata('sessionSuccessSendFriendAds'))
 		{
  			$data['successSendFriendAds'] = true;
 		}
 		elseif($this->session->flashdata('sessionSuccessSendFailAds'))
 		{
  			$data['successSendFailAds'] = true;
 		}
		#BEGIN: Send link for friend
		if($this->input->post('captcha_sendlink') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendlink', 'lang:sender_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('receiver_sendlink', 'lang:receiver_sendlink_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendlink', 'lang:title_sendlink_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendlink', 'lang:content_sendlink_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendlink', 'lang:captcha_sendlink_label_detail', 'required|callback__valid_captcha_send_friend');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_friend', $this->lang->line('_valid_captcha_send_friend_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('email');
				$config['useragent'] = $this->lang->line('useragen_mail_detail');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->input->post('sender_sendlink'));
				$this->email->to($this->input->post('receiver_sendlink'));
				$this->email->subject($this->input->post('title_sendlink'));
				$this->email->message($this->lang->line('content_default_send_friend_detail').base_url().trim(uri_string(), '/').'">'.base_url().trim(uri_string(), '/').'</a> '.$this->lang->line('next_content_default_send_friend_detail').$this->filter->html($this->input->post('content_sendlink')));
				if($this->email->send())
				{
					$this->session->set_flashdata('sessionSuccessSendFriendAds', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendlink'] = $this->input->post('sender_sendlink');
				$data['receiver_sendlink'] = $this->input->post('receiver_sendlink');
				$data['title_sendlink'] = $this->input->post('title_sendlink');
				$data['content_sendlink'] = $this->input->post('content_sendlink');
				$data['isSendFriend'] = true;
			}
		}
		#END Send link for friend
		#BEGIN: Send link fail ads
		elseif($this->input->post('captcha_sendfail') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost && !$this->session->userdata('sessionSendFailedAds_'.$adsIDQuery))
		{
			#BEGIN: Set rules
			$this->form_validation->set_rules('sender_sendfail', 'lang:sender_sendfail_label_detail', 'trim|required|valid_email');
			$this->form_validation->set_rules('title_sendfail', 'lang:title_sendfail_label_detail', 'trim|required');
			$this->form_validation->set_rules('content_sendfail', 'lang:content_sendfail_label_detail', 'trim|required|min_length[10]|max_length[400]');
			$this->form_validation->set_rules('captcha_sendfail', 'lang:captcha_sendfail_label_detail', 'required|callback__valid_captcha_send_fail');
			#END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			$this->form_validation->set_message('_valid_captcha_send_fail', $this->lang->line('_valid_captcha_send_fail_message_detail'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->model('ads_bad_model');
				$dataFailAdd = array(
										'adb_title'     =>      trim($this->filter->injection_html($this->input->post('title_sendfail'))),
										'adb_detail'    =>      trim($this->filter->injection_html($this->input->post('content_sendfail'))),
										'adb_email'     =>      trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
										'adb_ads'   	=>      (int)$ads->ads_id,
										'adb_date'      =>      $currentDate
										);
				if($this->ads_bad_model->add($dataFailAdd))
				{
					$this->session->set_flashdata('sessionSuccessSendFailAds', 1);
					$this->session->set_userdata('sessionSendFailedAds_'.$adsIDQuery, 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
			}
			else
			{
				$data['sender_sendfail'] = $this->input->post('sender_sendfail');
				$data['title_sendfail'] = $this->input->post('title_sendfail');
				$data['content_sendfail'] = $this->input->post('content_sendfail');
				$data['isSendFail'] = true;
			}
		}
		#END Send link fail ads
        #BEGIN: Create captcha send friend
		unlink_captcha($this->session->flashdata('sessionPathCaptchaSendFriendAds'));
		$codeCaptcha = $this->captcha->code(6);
		$this->session->set_flashdata('sessionCaptchaSendFriendAds', $codeCaptcha);
		$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(1, 10000).'fa.jpg';
		$this->session->set_flashdata('sessionPathCaptchaSendFriendAds', $imageCaptcha);
		$this->captcha->create($codeCaptcha, $imageCaptcha);
		if(file_exists($imageCaptcha))
		{
			$data['imageCaptchaSendFriendAds'] = $imageCaptcha;
		}
		#END Create captcha send friend
		#BEGIN: Create captcha send fail
		unlink_captcha($this->session->flashdata('sessionPathCaptchaSendFailAds'));
		$data['isSendedOneFail'] = false;
		if($this->session->userdata('sessionSendFailedAds_'.$adsIDQuery))
		{
			$data['isSendedOneFail'] = true;
		}
		else
		{
			$codeCaptcha = $this->captcha->code(6);
			$this->session->set_flashdata('sessionCaptchaSendFailAds', $codeCaptcha);
			$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.rand(10000, 100000).'ba.jpg';
			$this->session->set_flashdata('sessionPathCaptchaSendFailAds', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaSendFailAds'] = $imageCaptcha;
			}
		}
		#END Create captcha send fail
		#END Send friend & send fail
		$this->load->model('ads_comment_model');
		#BEGIN: Add favorite and submit forms
        $data['successFavoriteAds'] = false;
        $data['successReplyAds'] = false;
        $data['isLogined'] = false;
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['isLogined'] = true;
            if($this->session->flashdata('sessionSuccessFavoriteAds'))
        	{
				$data['successFavoriteAds'] = true;
        	}
        	elseif($this->session->flashdata('sessionSuccessReplyAds'))
        	{
				$data['successReplyAds'] = true;
        	}
            #BEGIN: Favorite
        	if($this->input->post('checkone') && $this->check->is_id($this->input->post('checkone')) && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
        	{
				$this->load->model('ads_favorite_model');
    			$adsOne = $this->ads_model->get("ads_user", "ads_id = ".(int)$this->input->post('checkone'));
    			$adsFavorite = $this->ads_favorite_model->get("adf_id", "adf_ads = ".(int)$this->input->post('checkone')." AND adf_user = ".(int)$this->session->userdata('sessionUser'));
				if(count($adsOne) == 1 && count($adsFavorite) == 0 && $adsOne->ads_user != $this->session->userdata('sessionUser'))
				{
				    $dataAdd = array(
									    'adf_ads'       =>      (int)$this->input->post('checkone'),
									    'adf_user'      =>      (int)$this->session->userdata('sessionUser'),
									    'adf_date'      =>      $currentDate
											);
					if($this->ads_favorite_model->add($dataAdd))
					{
	    				$this->session->set_flashdata('sessionSuccessFavoriteAds', 1);
					}
				}
				unset($adsOne);
				unset($adsFavorite);
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
        	}
        	#END Favorite
        	#BEGIN: Reply (Comment)
			elseif($this->input->post('captcha_reply') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
			{
				#BEGIN: Set rules
	            $this->form_validation->set_rules('title_reply', 'lang:title_reply_label_detail', 'trim|required');
	            $this->form_validation->set_rules('content_reply', 'lang:content_reply_label_detail', 'trim|required|min_length[10]|max_length[400]');
	            $this->form_validation->set_rules('captcha_reply', 'lang:captcha_reply_label_detail', 'required|callback__valid_captcha_reply');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_valid_captcha_reply', $this->lang->line('_valid_captcha_reply_message_detail'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					$dataAddReply = array(
					                        'adc_title'     =>      trim($this->filter->injection_html($this->input->post('title_reply'))),
					                        'adc_comment'   =>      trim($this->filter->injection_html($this->input->post('content_reply'))),
					                        'adc_ads'   	=>      (int)$ads->ads_id,
					                        'adc_user'      =>      (int)$this->session->userdata('sessionUser'),
					                        'adc_date'      =>      mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y'))
											);
					if($this->ads_comment_model->add($dataAddReply))
					{
						$this->ads_model->update(array('ads_comment' => (int)$ads->ads_comment + 1), "ads_id = ".$adsIDQuery);
						$this->session->set_flashdata('sessionSuccessReplyAds', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_reply'] = $this->input->post('title_reply');
					$data['content_reply'] = $this->input->post('content_reply');
					$data['isReply'] = true;
				}
			}
            #BEGIN: Create captcha reply
        	unlink_captcha($this->session->flashdata('sessionPathCaptchaReplyAds'));
        	$codeCaptcha = $this->captcha->code(6);
        	$this->session->set_flashdata('sessionCaptchaReplyAds', $codeCaptcha);
        	$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'ra.jpg';
        	$this->session->set_flashdata('sessionPathCaptchaReplyAds', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaReplyAds'] = $imageCaptcha;
			}
			#END Create captcha reply
            #END Reply (Comment)
		}
        #END Add favorite and submit forms
		#Assign title and description for site
		$data['titleSiteGlobal'] = $ads->ads_title;
		$data['descrSiteGlobal'] = $ads->ads_descr;
		#BEGIN: Get ads by $adsID and relate info
		$data['ads'] = $ads;
		$this->load->model('shop_model');
		$shop = $this->shop_model->get("sho_name, sho_descr, sho_link", "sho_user = ".(int)$ads->ads_user);
		if(count($shop) == 1)
		{
            $data['shop'] = $shop;
            $data['placeSaleIsShop'] =  true;
		}
		else
		{
			$this->load->model('province_model');
			$data['province'] = $this->province_model->get("pre_name", "pre_id = ".(int)$ads->ads_province);
			$data['placeSaleIsShop'] = false;
		}
		#END Get ads by $adsID and relate info
		#BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
		$data['menuType'] = 'ads';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		//$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'ads_detail';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_shop_ads,top_view_ads';
        #BEGIN: Top shop ads right
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsShop_Top;
		$data['topShopAds'] = $this->ads_model->fetch($select, "ads_is_shop = 1 AND ads_status = 1 AND ads_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop ads right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#Define url for $getVar
		$action = array('sort', 'by', 'page', 'cPage');
		$getVar = $this->uri->uri_to_assoc(6, $action);
		#BEGIN: Comment
		#Check open tab comment
		$data['isViewComment'] = false;
		if(trim(uri_string()) != '' && stristr(uri_string(), 'cPage'))
		{
            $data['isViewComment'] = true;
		}
		if($getVar['cPage'] != FALSE && (int)$getVar['cPage'] > 0)
		{
			$start = (int)$getVar['cPage'];
		}
		else
		{
			$start = 0;
		}
		$this->load->library('pagination');
		$totalRecord = count($this->ads_comment_model->fetch_join("adc_id", "LEFT", "tbtt_user", "tbtt_ads_comment.adc_user = tbtt_user.use_id", "adc_ads = $adsIDQuery", "", ""));
        $config['base_url'] = base_url().'ads/category/'.$categoryID.'/detail/'.$adsID.'/cPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = 5;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['cLinkPage'] = $this->pagination->create_links();
		$select = "adc_title, adc_comment, adc_date, use_fullname, use_email";
  		$limit = 5;
		$data['comment'] = $this->ads_comment_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_ads_comment.adc_user = tbtt_user.use_id", "adc_ads = $adsIDQuery", "adc_id", "DESC", $start, $limit);
		unset($start);
		unset($config);
		#END Comment
		#BEGIN: Relate user
		#BEGIN: Sort
		$where = "ads_user = ".(int)$ads->ads_user." AND ads_id != $adsIDQuery AND ads_status = 1 AND ads_enddate >= $currentDate";
		$sort = 'ads_id';
		$by = 'DESC';
		$pageSort = '';
		$pageUrl = '';
		if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
		{
			switch(strtolower($getVar['sort']))
			{
				case 'title':
				    $pageUrl .= '/sort/title';
				    $sort = "ads_title";
				    break;
                case 'date':
				    $pageUrl .= '/sort/date';
				    $sort = "ads_begindate";
				    break;
                case 'place':
				    $pageUrl .= '/sort/place';
				    $sort = "pre_name";
				    break;
                case 'view':
				    $pageUrl .= '/sort/view';
				    $sort = "ads_view";
				    break;
				default:
				    $pageUrl .= '/sort/id';
				    $sort = "ads_id";
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
		#END Sort
		#BEGIN: Create link sort
		$data['sortUrl'] = base_url().'ads/category/'.$categoryID.'/detail/'.$adsID.'/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link sort
		#BEGIN: Pagination
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'ads/category/'.$categoryID.'/detail/'.$adsID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsUser;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$limit = settingAdsUser;
		$data['userAds'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $sort, $by, $start, $limit);
		#END Relate user
		#BEGIN: Relate category
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name";
		$start = 0;
  		$limit = (int)settingAdsCategory;
		$data['categoryAds'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", "ads_category = ".(int)$ads->ads_category." AND ads_id != $adsIDQuery AND ads_status = 1 AND ads_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Relate category
		#Load view
		$this->load->view('home/ads/detail', $data);
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
		/* ltngan */
		$select="ads_id";
		$currentUser=$this->session->userdata('sessionUser');
		$listAds = $this->ads_model->fetch($select, "ads_user = $currentUser", "ads_id", "DESC");
		
		$this->load->model('user_model');
		$user = $this->user_model->get("member_type, active_code", "use_id = ".(int)$this->session->userdata('sessionUser'));
		
		if($user->member_type==1){
			$typememberlimit=(int)limitPost36MAds;
		}
						
		if($user->member_type==0){
			$typememberlimit=(int)limitPostFreeAds;
		}
				
		if(count($listAds)>=$typememberlimit){
    	 	echo "<script>alert('Bạn đã hết lượng đăng tin Rao vặt, gói đăng ký của bạn chỉ cho phép đăng ".$typememberlimit." tin Rao vặt, để đăng thêm bạn cần nâng cấp tài khoản.'); window.location = '".base_url()."account"."';</script>";
		}
		
		/* /ltngan */
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'post';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostAds'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessPostAds'))
		{
            $data['successPostAds'] = true;
		}
		else
		{
			$this->load->library('form_validation');
            $data['successPostAds'] = false;
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
            #BEGIN: Province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
            #END Province
            #BEGIN: Category
            $data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
            #END Category
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
			if($this->input->post('captcha_ads') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
			{
				#BEGIN: Set rules
//				$this->form_validation->set_rules('title_ads', 'lang:title_ads_label_post', 'trim|required');
//				$this->form_validation->set_rules('descr_ads', 'lang:descr_ads_label_post', 'trim|required');
//				$this->form_validation->set_rules('province_ads', 'lang:province_ads_label_post', 'required|callback__exist_province');
//				$this->form_validation->set_rules('category_ads', 'lang:category_ads_label_post', 'required|callback__exist_category');
//				$this->form_validation->set_rules('day_ads', 'lang:day_ads_label_post', 'required|callback__valid_enddate');
//				$this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_post', 'trim|required|min_length[10]|max_length[10000]');
//				$this->form_validation->set_rules('fullname_ads', 'lang:fullname_ads_label_post', 'trim|required');
//				$this->form_validation->set_rules('address_ads', 'lang:address_ads_label_post', 'trim|required');
//				$this->form_validation->set_rules('phone_ads', 'lang:phone_ads_label_post', 'trim|required|callback__is_phone');
//				$this->form_validation->set_rules('mobile_ads', 'lang:mobile_ads_label_post', 'trim|callback__is_phone');
//				$this->form_validation->set_rules('email_ads', 'lang:email_ads_label_post', 'trim|required|valid_email');
//				$this->form_validation->set_rules('yahoo_ads', 'lang:yahoo_ads_label_post', 'trim|callback__valid_nick');
//				$this->form_validation->set_rules('skype_ads', 'lang:skype_ads_label_post', 'trim|callback__valid_nick');
//				$this->form_validation->set_rules('captcha_ads', 'lang:captcha_ads_label_post', 'required|callback__valid_captcha_post');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
				$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message'));
				$this->form_validation->set_message('_valid_enddate', $this->lang->line('_valid_enddate_message'));
				$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
				$this->form_validation->set_message('_valid_captcha_post', $this->lang->line('_valid_captcha_post_message_post'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE  || $this->input->post('isPostAds'))
				{
					#BEGIN: Upload image
					$this->load->library('upload');
	                $pathImage = "media/images/ads/";
					#Create folder
					$dir_image = date('dmY');
					$image = 'none.gif';
					if(!is_dir($pathImage.$dir_image))
					{
						@mkdir($pathImage.$dir_image);
						$this->load->helper('file');
						@write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
					}
					$config['upload_path'] = $pathImage.$dir_image.'/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']	= 1024;#KB
					$config['max_width']  = 1024;#px
					$config['max_height']  = 1024;#px
					$config['encrypt_name'] = true;
					$this->upload->initialize($config);
					if($this->upload->do_upload('image_ads'))
					{
	                    $uploadData = $this->upload->data();
	                    if($uploadData['is_image'] == TRUE)
	                    {
							$image = $uploadData['file_name'];
                            #BEGIN: Create thumbnail
                            $this->load->library('image_lib');
                            if(file_exists($pathImage.$dir_image.'/'.$image))
                            {
                                $maxWidth = 200;#px
                                $maxHeight = 200;#px
                                $sizeImage = size_thumbnail($pathImage.$dir_image.'/'.$image, $maxWidth, $maxHeight);
                                $configImage['source_image'] = $pathImage.$dir_image.'/'.$image;
                                $configImage['new_image'] = $pathImage.$dir_image.'/thumbnail_3_'.$image;
                                $configImage['maintain_ratio'] = TRUE;
                                $configImage['width'] = $sizeImage['width'];
                                $configImage['height'] = $sizeImage['height'];
                                $this->image_lib->initialize($configImage);
                                $this->image_lib->resize();
                            }
                            #END Create thumbnail
	     				}
	     				elseif(file_exists($pathImage.$dir_image.'/'.$uploadData['file_name']))
	     				{
							@unlink($pathImage.$dir_image.'/'.$uploadData['file_name']);
	     				}
					}
					if($image == 'none.gif')
					{
                        #Remove dir
                        $this->load->library('file');
                        if(trim($dir_image) != '' && trim($dir_image) != 'default' && is_dir('media/images/ads/'.$dir_image) && count($this->file->load('media/images/ads/'.$dir_image, 'index.html')) == 0)
                        {
							if(file_exists('media/images/ads/'.$dir_image.'/index.html'))
							{
								@unlink('media/images/ads/'.$dir_image.'/index.html');
							}
							@rmdir('media/images/ads/'.$dir_image);
                        }
                        $dir_image = 'default';
					}
					#END Upload image
					if((int)$this->session->userdata('sessionGroup') == 2 || (int)$this->session->userdata('sessionGroup') == 3)
					{
						$reliable = 1;
					}
					else
					{
                        $reliable = 0;
					}
					#IF is shop
					$this->load->model('shop_model');
					$shop = $this->shop_model->get("sho_id", "sho_status = 1 AND sho_enddate >= $currentDate AND sho_user = ".(int)$this->session->userdata('sessionUser'));
					if(count($shop) == 1)
					{
						$is_shop = 1;
					}
					else
					{
                        $is_shop = 0;
					}
					$dataPost = array(
					                    'ads_title'      	=>      trim($this->filter->injection_html($this->input->post('title_ads'))),
					                    'ads_descr'     	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_ads')))),
					                    'ads_province'  	=>      (int)$this->input->post('province_ads'),
					                    'ads_category'  	=>      (int)$this->input->post('category_ads'),
					                    'ads_begindate' 	=>      $currentDate,
					                    'ads_enddate'   	=>      mktime(0, 0, 0, (int)$this->input->post('month_ads'), (int)$this->input->post('day_ads'), (int)$this->input->post('year_ads')),
					                    'ads_detail'    	=>      trim($this->filter->injection_html($this->input->post('txtContent'))),
					                    'ads_image'     	=>      $image,
					                    'ads_dir'       	=>      $dir_image,
					                    'ads_user'      	=>      (int)$this->session->userdata('sessionUser'),
					                    'ads_poster'    	=>      trim($this->filter->injection_html($this->input->post('fullname_ads'))),
					                    'ads_address'   	=>      trim($this->filter->injection_html($this->input->post('address_ads'))),
					                    'ads_phone'     	=>      trim($this->filter->injection_html($this->input->post('phone_ads'))),
					                    'ads_mobile'    	=>      trim($this->filter->injection_html($this->input->post('mobile_ads'))),
					                    'ads_email'     	=>      trim($this->filter->injection_html($this->input->post('email_ads'))),
					                    'ads_yahoo'     	=>      trim($this->filter->injection_html($this->input->post('yahoo_ads'))),
					                    'ads_skype'     	=>      trim($this->filter->injection_html($this->input->post('skype_ads'))),
					                    'ads_status'    	=>      1,
					                    'ads_view'      	=>      0,
					                    'ads_comment'   	=>      0,
                                        'ads_reliable'      =>      $reliable,
                                        'ads_is_shop'       =>      $is_shop
										);
					if($this->ads_model->add($dataPost))
					{
						$this->session->set_flashdata('sessionSuccessPostAds', 1);
					}
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				}
				else
				{
					$data['title_ads'] = $this->input->post('title_ads');
					$data['descr_ads'] = $this->input->post('descr_ads');
					$data['province_ads'] = $this->input->post('province_ads');
					$data['category_ads'] = $this->input->post('category_ads');
					$data['day_ads'] = $this->input->post('day_ads');
					$data['month_ads'] = $this->input->post('month_ads');
					$data['year_ads'] = $this->input->post('year_ads');
					$data['txtContent'] = $this->input->post('txtContent');
     				$data['fullname_ads'] = $this->input->post('fullname_ads');
					$data['address_ads'] = $this->input->post('address_ads');
     				$data['phone_ads'] = $this->input->post('phone_ads');
     				$data['mobile_ads'] = $this->input->post('mobile_ads');
                    $data['email_ads'] = $this->input->post('email_ads');
                    $data['yahoo_ads'] = $this->input->post('yahoo_ads');
                    $data['skype_ads'] = $this->input->post('skype_ads');
				}
			}
            #BEGIN: Create captcha post ads
            $aCaptcha = $this->createCaptcha(md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'posa.jpg');
            if(!empty($aCaptcha)) {
                $data['captcha']                = $aCaptcha['captcha']; 
                $data['imageCaptchaPostAds']    = $aCaptcha['imageCaptchaContact'];

                $this->session->set_userdata('sessionCaptchaPostAds', $data['captcha']);
                $this->session->set_userdata('sessionPathCaptchaPostAds', $data['imageCaptchaContact']); 
            }

			#END Create captcha post ads
		}
		$data['menuType'] = 'ads';
			
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		#Load view
		$this->load->view('home/ads/post', $data);
	}
	
	function _valid_captcha_reply($str)
	{
		if($this->session->flashdata('sessionCaptchaReplyAds') && $this->session->flashdata('sessionCaptchaReplyAds') === $str)
		{
			return true;
		}
		return false;
	}

	function _valid_captcha_send_friend($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFriendAds') && $this->session->flashdata('sessionCaptchaSendFriendAds') === $str)
		{
			return true;
		}
		return false;
	}

	function _valid_captcha_send_fail($str)
	{
		if($this->session->flashdata('sessionCaptchaSendFailAds') && $this->session->flashdata('sessionCaptchaSendFailAds') === $str)
		{
			return true;
		}
		return false;
	}
	
	function _is_phone($str)
	{
		if($this->check->is_phone($str))
		{
			return true;
		}
		return false;
	}

	function _exist_province($str)
	{
		$this->load->model('province_model');
		if(count($this->province_model->get("pre_id", "pre_status = 1 AND pre_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}

	function _exist_category($str)
	{
		if(count($this->category_model->get("cat_id", "cat_status = 1 AND cat_id = ".(int)$str)) == 1)
		{
			return true;
		}
		return false;
	}

	function _valid_enddate()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$endDate = mktime(0, 0, 0, (int)$this->input->post('month_ads'), (int)$this->input->post('day_ads'), (int)$this->input->post('year_ads'));
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

	function _valid_captcha_post($str)
	{
		if($this->session->flashdata('sessionCaptchaPostAds') && $this->session->flashdata('sessionCaptchaPostAds') === $str)
		{
			return true;
		}
		return false;
	}
}