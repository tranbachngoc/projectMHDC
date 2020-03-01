<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Raovat extends MY_Controller
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
		$this->lang->load('home/raovat');
		#Load model
		$this->load->model('ads_model');
		$this->load->model('category_model');
		$this->load->model('ads_category_model');
		$data['menuType'] = 'raovat';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
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
		
		#BEGIN: Top lastest ads right
		$select = "ads_id, ads_title, ads_descr, ads_category";
		$start = 0;
		$limit = (int)settingAdsNew_Top;
		$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
		#END Top lastest ads right
		
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
	
	function rao_vat_xau()
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$id_hds = $this->input->post('id_hds');
		$id_user = (int)$this->input->post('id_user');	
	
		$this->load->model('ads_bad_model');
				$dataFailAdd = array(									
										'adb_ads'   	=>      $id_hds,
										'adb_user_id'   =>      $id_user,
										'adb_date'      =>      $currentDate
										);
				if($this->ads_bad_model->add($dataFailAdd))
				{
					echo "Báo cáo thành công";
				}
				
				
	}
	
	function loadCategory($parent, $level)
	{
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->ads_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   //$link = anchor('raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => ''));
			   $link = '<a href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
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
	   $category  = $this->ads_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega' style='padding-top:0;'>";
			$retArray .= "<ul class='sub'>";
			foreach ($category as $key=>$row)
			{
				$link = '<a class="mega-sub-link" href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
/*				if($key % 3 == 0){
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
	   $category  = $this->ads_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor('raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	 
	function index()
	{
		
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$data['titleSiteGlobal'] = settingTitleRaovat;
		$data['descrSiteGlobal'] = settingDescrRaovat;
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		#END Menu
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
		$rWhere = "ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 0";
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
				case 'rsplace':
				$rPageUrl .= '/rSort/rsplace';		
				$rsplace = $this->uri->segment(3);												
				$id_place = $this->uri->segment(4);
				$data['selectPlaceTruth'] = (int)$id_place;
				if($id_place>0 && $rsplace=='rsplace')
				$rWhere .= " AND ads_province =".$id_place; 
				
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
		$data['rSortUrl'] = base_url().'raovat/rSort/';
		$data['rPageSort'] = $rPageSort;
		#END Create link rSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'raovat'.$rPageUrl.'/rPage/';
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
	
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,pre_id";
		
		$rLimit = settingAdsReliable_Category;
				
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $rWhere, $rSort, $rBy, $rStart, $rLimit);
		
		#BEGIN: nSort
		$nWhere = "ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 0 ";
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
				case 'splace':
				    $nPageUrl .= '/nSort/splace';
					$splace = $this->uri->segment(3);			
					$id_place = $this->uri->segment(4);					
					$data['selectPlace'] = (int)$id_place;
					if($id_place>0 && $splace=='splace')
					$nWhere .= " AND ads_province =".$id_place; 
					
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
		$data['nSortUrl'] = base_url().'raovat/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
      
		$config['base_url'] = base_url().'raovat'.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		
			
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_sex,use_phone,use_username,use_fullname,pre_id";
		$nLimit = settingAdsNew_Category;
		$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $nWhere, $nSort, $nBy, $nStart, $nLimit);
		//var_dump($nWhere);die();
		#Load view
		
		#BEGIN: Fetch province
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		#END Fetch province
		
		$this->load->helper('text');
		$this->load->view('home/raovat/defaults', $data);
	}
	
	/// rao vat tin mua
	
	function tinmua()
	{
		
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		#END Menu
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
		$getVar = $this->uri->uri_to_assoc(3, $action);
		
		#BEGIN: rSort
		$rWhere = "ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 1";
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
				case 'rsplace':
				$rPageUrl .= '/rSort/rsplace';		
				$rsplace = $this->uri->segment(4);												
				$id_place = $this->uri->segment(5);
				$data['selectPlaceTruth'] = (int)$id_place;
				if($id_place>0 && $rsplace=='rsplace')
				$rWhere .= " AND ads_province =".$id_place; 
				
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
		$data['rSortUrl'] = base_url().'raovat/tin-mua/rSort/';
		$data['rPageSort'] = $rPageSort;
		#END Create link rSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'raovat/tin-mua'.$rPageUrl.'/rPage/';
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
		
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,pre_id";
		
		$rLimit = settingAdsReliable_Category;				
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $rWhere, $rSort, $rBy, $rStart, $rLimit);		
		#BEGIN: nSort
		$nWhere = "ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 1";
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
				case 'splace':
				    $nPageUrl .= '/nSort/splace';
					$splace = $this->uri->segment(4);			
					$id_place = $this->uri->segment(5);					
					$data['selectPlace'] = (int)$id_place;
					if($id_place>0 && $splace=='splace')
					$nWhere .= " AND ads_province =".$id_place; 
					
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
		$data['nSortUrl'] = base_url().'raovat/tin-mua/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
      
		$config['base_url'] = base_url().'raovat/tin-mua'.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 4;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		
			
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_sex,use_phone,use_username,use_fullname,pre_id";
		$nLimit = settingAdsNew_Category;
		$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $nWhere, $nSort, $nBy, $nStart, $nLimit);
		//var_dump($nWhere);die();
		#Load view
		
		#BEGIN: Fetch province
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		#END Fetch province
		
		$this->load->helper('text');
		$this->load->view('home/raovat/tinmua', $data);
	}
	
	// rao vat tin mua
	
	function category($categoryID)
	{
		$this->load->model('ads_category_model');
		
		$linkDetail = $this->uri->segment(2);
		$data['raovat_sub_rum']=$this->loadSubSubCategory(0);		  
		  
		$siteGlobal = $this->ads_category_model->get("*", "cat_id = '".$linkDetail."'");
		$data['siteGlobal'] = $siteGlobal;		  	
		$data['shop_glonal_conten']=$this->loadSubSubCategory($linkDetail);			
		$CategoryPro = $this->ads_category_model->get("*", "cat_id = '".$siteGlobal->parent_id."'");
		$data['CategorysiteGlobal'] = $CategoryPro;
		$data['CategorysiteGlobalConten']=$this->loadSubSubCategory($CategoryPro->cat_id);		  
		
		$CategoryRoot = $this->ads_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		$data['CategorysiteGlobalRoot'] = $CategoryRoot;			 
		$data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryRoot->cat_id);
		
		$CategoryRoot = $this->ads_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		$data['CategorysiteGlobalRoot'] = $CategoryRoot;
		
		$data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryRoot->cat_id);
			 
			
			 
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
		$category = $this->ads_category_model->get("cat_id,cat_name,cat_level,cat_descr, keyword, h1tag", "cat_id = ".(int)$categoryID." AND cat_status = 1");
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
			$catlevel1 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 1 AND parent_id = ".(int)$category->cat_id);
			if(isset($catlevel1) && count($catlevel1) > 0){
				foreach($catlevel1 as $key=>$item){
					// get sub category level 2
					$catitemlv2 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$item->cat_id);
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
			$catlevel2 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$category->cat_id);
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
		#BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
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
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: rSort
		$rWhere = "ads_category IN(".$listcat.") AND ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 0";
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
				case 'rsplace':
					$rPageUrl .= '/rSort/rsplace';		
					$rsplace = $this->uri->segment(4);												
					$id_place = $this->uri->segment(5);
					$data['rcatidRaovat']=$id_place ;
									
					$data['selectPlaceTruth'] = (int)$id_place;
					if($id_place>0 && $rsplace=='rsplace')
					$rWhere .= " AND ads_province =".$id_place; 
				
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
		$data['rSortUrl'] = base_url().'raovat/'.$categoryID.'/rSort/';
		$data['rPageSort'] = $rPageSort;
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'raovat/'.$categoryID.$rPageUrl.'/rPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsReliable_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $rStart;
		$this->pagination->initialize($config);
		$data['rLinkPage'] = $this->pagination->create_links();
		unset($config);		
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,use_phone,pre_id";
		$rLimit = settingAdsReliable_Category;
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $rWhere, $rSort, $rBy, $rStart, $rLimit);
		#BEGIN: nSort
		$nWhere = "ads_category IN(".$listcat.") AND ads_status = 1 AND ads_enddate >= $currentDate";
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
				case 'splace':
					$rPageUrl .= '/nSort/splace';		
					$rsplace = $this->uri->segment(4);												
					$id_place = $this->uri->segment(5);
					$data['ncatidRaovat']=$id_place ;										
					$data['selectPlace'] = (int)$id_place;
					if($id_place>0 && $rsplace=='splace')
					$nWhere .= " AND ads_province =".$id_place; 
				
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
		$data['nSortUrl'] = base_url().'raovat/'.$categoryID.'/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
        $config['base_url'] = base_url().'raovat/'.$categoryID.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,pre_id,use_fullname";
		$nLimit = settingAdsNew_Category;		
		$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $nWhere, $nSort, $nBy, $nStart, $nLimit);
		#Load view		
		#BEGIN: Fetch province
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		
		if($category->h1tag!=''){
			$data['titleSiteGlobal'] = str_replace(",", "|", $category->h1tag);
		}else{
			$data['titleSiteGlobal'] = $category->cat_name;
		}
		$data['keywordSiteGlobal'] = $category->keyword;
		$data['h1tagSiteGlobal'] = $category->h1tag;
		$this->load->helper('text');
		$data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)),255);
		
		#END Fetch province		
		$this->load->helper('text');
		$this->load->view('home/raovat/category', $data);
	}
	
	function raovatxemnhieunhat()
	{
		$this->load->model('ads_category_model');
		
		$linkDetail = $this->uri->segment(2);
		$data['raovat_sub_rum']=$this->loadSubSubCategory(0);		  
		
			 
			
			 
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
      
		$listcat = '';
		if($category->cat_level == 0){
			// get sub category level 1
			$catlevel1 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 1 AND parent_id = ".(int)$category->cat_id);
			if(isset($catlevel1) && count($catlevel1) > 0){
				foreach($catlevel1 as $key=>$item){
					// get sub category level 2
					$catitemlv2 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$item->cat_id);
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
			$catlevel2 = $this->ads_category_model->fetch("cat_id,cat_name","cat_level = 2 AND parent_id = ".(int)$category->cat_id);
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
		#BEGIN: Menu
		$data['menuSelected'] = (int)$categoryID;
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
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: rSort
		$rWhere = "ads_reliable = 1 AND ads_status = 1 AND ads_enddate >= $currentDate AND ads_loaitin = 0";
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
				case 'rsplace':
					$rPageUrl .= '/rSort/rsplace';		
					$rsplace = $this->uri->segment(4);												
					$id_place = $this->uri->segment(5);
					$data['rcatidRaovat']=$id_place ;
									
					$data['selectPlaceTruth'] = (int)$id_place;
					if($id_place>0 && $rsplace=='rsplace')
					$rWhere .= " AND ads_province =".$id_place; 
				
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
		$data['rSortUrl'] = base_url().'raovat/'.$categoryID.'/rSort/';
		$data['rPageSort'] = $rPageSort;
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $rWhere, "", ""));
        $config['base_url'] = base_url().'raovat/'.$categoryID.$rPageUrl.'/rPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsReliable_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $rStart;
		$this->pagination->initialize($config);
		$data['rLinkPage'] = $this->pagination->create_links();
		unset($config);		
		$rSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,use_phone,pre_id";
		$rLimit = settingAdsReliable_Category;
		$data['reliableAds'] = $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $rWhere, "ads_view", "DESC", 0, 30);
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
				case 'splace':
					$rPageUrl .= '/nSort/splace';		
					$rsplace = $this->uri->segment(4);												
					$id_place = $this->uri->segment(5);
					$data['ncatidRaovat']=$id_place ;										
					$data['selectPlace'] = (int)$id_place;
					if($id_place>0 && $rsplace=='splace')
					$nWhere .= " AND ads_province =".$id_place; 
				
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
		$data['nSortUrl'] = base_url().'raovat/'.$categoryID.'/nSort/';
		$data['nPageSort'] = $nPageSort;
		#END Create link nSort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $nWhere, "", ""));
        $config['base_url'] = base_url().'raovat/'.$categoryID.$nPageUrl.'/nPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsNew_Category;
		$config['num_links'] = 1;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $nStart;
		$this->pagination->initialize($config);
		$data['nLinkPage'] = $this->pagination->create_links();
		#END Pagination
		#Fetch record
		$nSelect = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,pre_id,use_fullname";
		$nLimit = settingAdsNew_Category;		
		//$data['newAds'] = $this->ads_model->fetch_join($nSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $nWhere, "ads_view", "DESC", $nStart, $nLimit);
		#Load view		
		#BEGIN: Fetch province
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		
		if($category->h1tag!=''){
			$data['titleSiteGlobal'] = str_replace(",", "|", $category->h1tag);
		}else{
			$data['titleSiteGlobal'] = $category->cat_name;
		}
		$data['keywordSiteGlobal'] = $category->keyword;
		$data['h1tagSiteGlobal'] = $category->h1tag;
		$this->load->helper('text');
		$data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)),255);
		
		#END Fetch province		
		$this->load->helper('text');
		$this->load->view('home/raovat/raovatxemnhieunhat', $data);
	}
	
	
	
	
	function smtpmailer($to, $from, $from_name, $subject, $body)
	{
		
		$mail = new PHPMailer();  				// tạo một đối tượng mới từ class PHPMailer
		$mail->IsSMTP(); 	
		$mail->CharSet="utf-8";					// bật chức năng SMTP
		$mail->SMTPDebug = 0;  					// kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
		$mail->SMTPAuth = true;  				// bật chức năng đăng nhập vào SMTP này
		$mail->SMTPSecure = SMTPSERCURITY; 				// sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
		$mail->Host = SMTPHOST; 		// smtp của gmail
		$mail->Port = SMTPPORT; 						// port của smpt gmail
		$mail->Username = GUSER;  
		$mail->Password = GPWD;           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->isHTML(true);
		$mail->AddAddress($to);
		
		if(!$mail->Send())
		{
			$message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
			return false;
		} else {
			$message = 'Thư của bạn đã được gởi đi ';
			return true;
		}
		
	}

	
	function shop()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'raovat';
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
		$data['sortUrl'] = base_url().'raovat/shop/sort/';
		$data['pageSort'] = $pageSort;
		#END Create link Sort
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'raovat/shop'.$pageUrl.'/page/';
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
		$this->load->view('home/raovat/shop', $data);
	}
	
	function detail($categoryID, $adsID)
	{
		if($this->session->userdata('sessionUser')>0){
						
			$this->load->model('eye_model');
			
			$dataEye = array(
				'idview'      =>     $adsID ,
				'userid'      =>     $this->session->userdata('sessionUser') ,
				'typeview'      =>     2,
				'timeview'          =>     1							
			);
			
			$checkEye = $this->eye_model->fetch("*","idview = ".$adsID."  AND userid= ".$this->session->userdata('sessionUser')." AND typeview = 2 ", "id",'DESC');
			if(count($checkEye)==0)
			$this->eye_model->add($dataEye);
		}else{
			$check=0;			
			
			foreach($this->session->userdata('arrayEyeRaovat') as $pitem){
				if($pitem==$adsID)	
					$check=1;		
			}
				
			if($check==0){
				$this->session->userdata['arrayEyeRaovat'][] = $adsID;
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
		
		$this->load->model('ads_category_model');	

		$data['raovat_sub_rum']=$this->loadSubSubCategory(0);	
		
		$linkDetail = $this->uri->segment(2);
		$shop = $this->ads_category_model->get("*", "cat_id = '".$linkDetail."'");
		$data['siteGlobal'] = $shop;		  
		$data['shop_glonal_conten']=$this->loadSubSubCategory($shop->cat_id);		  	
		$CategoryPro = $this->ads_category_model->get("*", "cat_id = '".$shop->parent_id."'");
		$data['CategorysiteGlobal'] = $CategoryPro;
		$data['CategorysiteGlobalConten']=$this->loadSubSubCategory($CategoryPro->cat_id);
		$CategoryProRoot = $this->ads_category_model->get("*", "cat_id = '".$CategoryPro->parent_id."'");
		$data['CategorysiteGlobalRoot'] = $CategoryProRoot;
		$data['CategorysiteRootConten']=$this->loadSubSubCategory($CategoryProRoot->cat_id);		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
		$category = $this->ads_category_model->get("cat_id,cat_name", "cat_id = ".(int)$categoryID." AND cat_status = 1");
	
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
			//$this->form_validation->set_rules('captcha_sendlink', 'lang:captcha_sendlink_label_detail', 'required|callback__valid_captcha_send_friend');
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
				
				#Email
				$folder=folderWeb;		
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.phpmailer.php'); 
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.pop3.php');								
				
				$return_email=$this->smtpmailer($this->input->post('receiver_sendlink'), $this->input->post('sender_sendlink'), "azibai.com", $this->input->post('title_sendlink'), $this->lang->line('content_default_send_friend_detail').base_url().trim(uri_string(), '/').'">'.base_url().trim(uri_string(), '/').'</a> '.$this->lang->line('next_content_default_send_friend_detail').$this->filter->html($this->input->post('content_sendlink')) );
				
				if($return_email)
				{
					$this->session->set_flashdata('sessionSuccessSendFriendAds', 1);
				}
				
				/*if($this->email->send())
				{
					$this->session->set_flashdata('sessionSuccessSendFriendAds', 1);
				}*/
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
			//$this->form_validation->set_rules('sender_sendfail', 'lang:sender_sendfail_label_detail', 'trim|required|valid_email');
			//$this->form_validation->set_rules('title_sendfail', 'lang:title_sendfail_label_detail', 'trim|required');
			////$this->form_validation->set_rules('content_sendfail', 'lang:content_sendfail_label_detail', 'trim|required|min_length[10]|max_length[400]');
			//$this->form_validation->set_rules('captcha_sendfail', 'lang:captcha_sendfail_label_detail', 'required|callback__valid_captcha_send_fail');
			#END Set rules
			#BEGIN: Set message
		//	$this->form_validation->set_message('required', $this->lang->line('required_message'));
			//$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			//$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
			///$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
			//$this->form_validation->set_message('_valid_captcha_send_fail', $this->lang->line('_valid_captcha_send_fail_message_detail'));
			//$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set messagebao_cao_sai_gia
			if($this->input->post('bao_cao_sai_gia')=="1")
			{
				$this->load->model('ads_bad_model');
				$dataFailAdd = array(
										'adb_title'     =>      trim($this->filter->injection_html($this->input->post('title_sendfail'))),
										'adb_detail'    =>      trim($this->filter->injection_html($this->input->post('content_sendfail'))),
										'adb_email'     =>      trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
										'adb_ads'   	=>      (int)$ads->ads_id,
										'adb_user_id'   =>      (int)$this->session->userdata('sessionUser'),
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
          
		}
        #END Add favorite and submit forms
		#Assign title and description for site
		$data['titleSiteGlobal'] = $ads->ads_title." | ".$category->cat_name;
		
		$this->load->helper('text');		
		$data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($ads->ads_detail)),255);
		$data['h1tagSiteGlobal'] = $ads->ads_title;
		
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
		$getVar = $this->uri->uri_to_assoc(4, $action);
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
        $config['base_url'] = base_url().'raovat/'.$categoryID.'/'.$adsID.'/cPage/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = 5;
		$config['num_links'] = 1;
		$config['uri_segment'] = 2;
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
		$data['sortUrl'] = base_url().'raovat/'.$categoryID.'/'.$adsID.'/sort/';
		$data['pageSort'] = $pageSort;
		$totalRecord = count($this->ads_model->fetch_join("ads_id", "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, "", ""));
        $config['base_url'] = base_url().'raovat/'.$categoryID.'/'.$adsID.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingAdsUser;
		$config['num_links'] = 1;
		$config['uri_segment'] = 2;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,pre_id";
		$limit = settingAdsUser;
	
		if($this->uri->segment(5) != "" && $this->uri->segment(6)=="thanhvien" )
		{
				
			$where.=" AND ads_province =	".$this->uri->segment(5);
			$id_place = $this->uri->segment(5);					
					$data['selectPlaceTruth'] = (int)$id_place;
		}

		$data['userAds'] =  $this->ads_model->fetch_join($rSelect, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $where, $sort, $by, $start, $limit);		
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, pre_name,ads_detail,use_id,use_username,avatar,use_email,use_fullname,pre_id";
		$start = 0;
  		$limit = (int)settingAdsCategory;
		$whereCate="ads_category = ".(int)$ads->ads_category." AND ads_id != $adsIDQuery AND ads_status = 1 AND ads_enddate >= $currentDate";
		if($this->uri->segment(5) != "" && $this->uri->segment(6)=="danhmuc" )
		{
				
			$whereCate.=" AND ads_province =	".$this->uri->segment(5);
			$id_place = $this->uri->segment(5);					
					$data['selectPlace'] = (int)$id_place;
		}
		
		$data['categoryAds'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "INNER", "tbtt_user", "tbtt_ads.ads_user = tbtt_user.use_id", "", "", "", $whereCate, "rand()", "DESC", $start, $limit);
		//$data['categoryAds'] = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "",$whereCate, "rand()", "DESC", $start, $limit);
		#END Relate category
		#Load view
		     $this->load->model('province_model');
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		$data['provinceads'] = $this->province_model->get("pre_name", "pre_id = ".(int)$ads->ads_province);
			unlink_captcha($this->session->flashdata('sessionCaptchaReplyAds'));
		
	
        	$codeCaptcha = $this->captcha->code(6);	
			$data['cacha']=$codeCaptcha;
        	$this->session->set_flashdata('sessionCaptchaReplyAds', $codeCaptcha);
        	$imageCaptcha = 'templates/captcha/'.md5(microtime()).'.'.(int)$this->session->userdata('sessionUser').'ra.jpg';
        	$this->session->set_flashdata('sessionPathCaptchaReplyAds', $imageCaptcha);
			$this->captcha->create($codeCaptcha, $imageCaptcha);
			if(file_exists($imageCaptcha))
			{
				$data['imageCaptchaReplyAds'] = $imageCaptcha;
			}
			//print_r($data['province']);die();
		$this->load->view('home/raovat/detail', $data);
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
		$this->load->model('ads_category_model');
		$cat_level_0 = $this->ads_category_model->fetch("*","parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
		if(isset($cat_level_0)){
				foreach($cat_level_0 as $key=>$item){
					$cat_level_1 = $this->ads_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
					$cat_level_0[$key]->child_count = count($cat_level_1);
				}
			}
		$data['catlevel0']=$cat_level_0;
			
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
            $data['category'] = $this->ads_category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
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
	                $pathImage = "media/images/raovat/";
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
                        if(trim($dir_image) != '' && trim($dir_image) != 'default' && is_dir('media/images/raovat/'.$dir_image) && count($this->file->load('media/images/raovat/'.$dir_image, 'index.html')) == 0)
                        {
							if(file_exists('media/images/raovat/'.$dir_image.'/index.html'))
							{
								@unlink('media/images/raovat/'.$dir_image.'/index.html');
							}
							@rmdir('media/images/raovat/'.$dir_image);
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
					
					$ngaykeythuc = explode("-", $this->input->post('ngay_ket_thuc'));
					$dataPost = array(
					                    'ads_title'      	=>      trim($this->filter->injection_html($this->input->post('title_ads'))),
					                    'ads_descr'     	=>      trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_ads')))),
					                    'ads_province'  	=>      (int)$this->input->post('province_ads'),
					                    'ads_category'  	=>      (int)$this->input->post('hd_category_id'),
										 'ads_loaitin'  	=>      (int)$this->input->post('loai_tin'),
					                    'ads_begindate' 	=>      $currentDate,
					                    'ads_enddate'   	=>      mktime(0, 0, 0, (int)$ngaykeythuc[1], (int)$ngaykeythuc[0], (int)$ngaykeythuc[2]),
					                    'ads_detail'    	=>       trim($this->filter->injection_html(str_replace("&curren;","#",$this->input->post('txtContent')))),
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

		#Load view
		$data['menuType'] = 'account';
	
		$this->load->view('home/raovat/post', $data);
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
		if(count($this->ads_category_model->get("cat_id", "cat_status = 1 AND cat_id = ".(int)$str)) == 1)
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
	function ajax(){
		$this->load->model('ads_category_model');
		$parent_id = (int)$this->input->post('parent_id');
		$cat_level = $this->ads_category_model->fetch("*","parent_id = ".$parent_id." AND cat_status = 1", "cat_order", "DESC");
		if(isset($cat_level)){
			foreach($cat_level as $key=>$item){
				$cat_level_next = $this->ads_category_model->fetch("*","parent_id = ".(int)$item->cat_id." AND cat_status = 1");
				$cat_level[$key]->child_count = count($cat_level_next);
			}
		}
		echo "[".json_encode($cat_level).",".count($cat_level)."]";
		exit();
	}
	
	
	// Quang
	function loadCategory_two()
	{
		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;		
		$data['menuType'] = 'raovat';		
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;		
		$data['advertisePage'] = 'product_sub';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");	
		$data['counter'] = $this->counter_model->get();		
        $data['module'] = 'top_saleoff_product,top_buyest_product';  	
		$retArray = array();
				$this->display_child_showcategory_page(0, 0,$retArray);
				$data['categoryViewPage']  = $retArray; 				
				
	   $this->load->view('home/raovat/view_category', $data);
	}
	
	function display_child_showcategory_page($parent, $level,&$retArray)
	{	    
		$sql = "SELECT * from `tbtt_ads_category` WHERE parent_id='$parent' and cat_status = 1 order by cat_order";		
	   $query = $this->db->query($sql);	
		$i=0;
	   foreach ($query->result_array() as $row)
	   {
		   
		   $object = new StdClass;
		   $object->cat_id = $row['cat_id'];
		   $object->cat_name =$row['cat_name'];
		    $object->levelQ=$level;			   
		   $retArray[] = $object;
	       $this->display_child_showcategory_page($row['cat_id'], $level+1,$retArray);
		   //edit by nganly de qui
		   $i=$i+1;
	
	   }
	
	}
	
	
	
}