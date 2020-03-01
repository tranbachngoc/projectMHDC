<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Tintuc extends MY_Controller
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
		#Load library
		$this->load->library('hash');
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/defaults');
		#Load model
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->model('ads_model');
		$this->load->model('job_model');
		$this->load->model('shop_model');
	
		#BEGIN: Update counter
		if(!$this->session->userdata('sessionUpdateCounter'))
		{
			$this->counter_model->update();
			$this->session->set_userdata('sessionUpdateCounter', 1);
		}
		#END Update counter
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('notify_model');
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
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
				
		$data['menuType'] = 'tintuc';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "not_id, not_title, not_detail, not_degree";
		$this->db->limit(settingNotify);
		$this->db->order_by("not_id", "DESC"); 
		$data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_enddate  >= $currentDate", "not_degree", "DESC");
		#END Notify
	
		$subCatThesim = array();			
		$subCatThesim = $this->loadCategoryLevel1(4,1);		
		$data['subCatThesim'] = $subCatThesim;	
		
		$subCatPhanmem = array();			
		$subCatPhanmem = $this->loadCategoryLevel1(1,1);		
		$data['subCatPhanmem'] = $subCatPhanmem;
		
		$subCatThietbiso = array();			
		$subCatThietbiso = $this->loadCategoryLevel1(3,1);		
		$data['subCatThietbiso'] = $subCatThietbiso;	
		
		$subCatDichvukhac = array();			
		$subCatDichvukhac = $this->loadCategoryLevel1(753,1);		
		$data['subCatDichvukhac'] = $subCatDichvukhac;	
		$this->load->vars($data);
		#END Ads & Notify Taskbar
		
	
	}
	function loadCategoryLevel1($parent, $level)
	{
		$select = "*";
		$this->load->model('category_model');
		$where = "parent_id='$parent' AND cat_level=$level";
		$category  = $this->category_model->fetch($select, $where);
		return $category;		
	}
	function cronuptin(){
		$this->load->model('uptin_model');
		$thu = date('N')+1;
		$gio = date('G:i');
		
		$lichUp = $this->uptin_model->getLichUp($thu,$gio);

		foreach($lichUp as $row){ 
			 $this->uptin_model->uptin($row->tin_id,$row->type);
			
		 	$this->uptin_model->minusLichUp($row->id);				
		}

		
	}
	function loadMenu($parent, $level,&$retArray)
	{
		$select = "men_name, men_descr, men_image, men_category";
		$whereTmp = "men_status = 1";
		if(strlen($where)>0){
			$whereTmp .= $where." and parent_id='$parent' ";
		}else{
			$whereTmp .= $where."parent_id='$parent'";
		}
		$menu  =  $this->menu_model->fetch($select , $whereTmp, "men_order", "ASC");
	

	   foreach ($category as $row)
	   {
		     
		   $row->cat_name = str_repeat('-',$level)." ".$row->cat_name;
		   $retArray[] = $row;
	       $this->loadMenu($row->men_category, $level+1,$retArray);
		    //edit by nganly de qui
	
	   }
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
			   //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
			   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
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
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 450;}
			if(count($category) >= 3){$rowwidth = 660;}
			$retArray .= "<ul class='sub row' style='width: ".$rowwidth."px;'>";			
			foreach ($category as $key=>$row)
			{
				//$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
				$link = '<a class="mega-hdr-a"  href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				if($key % 3 == 0){
					//$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
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
					//$retArray .= "</div>";
				}
				/*if(($key % 3 == 0)&&(!$category[$key+1]))
				{
					$retArray .= "</div>";
				}else if(($key % 3 == 1)&&(!$category[$key+1])){
					$retArray .= "</div>";
				}*/
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
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC" ,"0" ,"5");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
					$link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
					
				}
					$retArray.= "<li ><a class='xemtatca_menu' href='product/xemtatca/".$parent."' > Xem tất cả </a></li>";
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	 
	function my_array_random($arr, $num = 1) {
		shuffle($arr);
	   
		$r = array();
		for ($i = 0; $i < $num; $i++) {
			$r[] = $arr[$i];
		}
		return $num == 1 ? $r[0] : $r;
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
	
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
		#BEGIN: Top product saleoff right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		$start = 0;
  		$limit = (int)settingProductSaleoff_Top;
	
		if((int)date('j') > 10)
		{
			$tabStart = 0;
		}
		else
		{
            $tabStart = (int)date('j') - 1;
		}
		#BEGIN: Get random category
		$this->load->model('category_model');
		$this->load->model('content_model');	
		/*$select = "cat_id";
  		$randomCategory= $this->product_model->fetch($select, "parent_id = 0 AND cat_status = 1",'cat_id', 'rand()');*/
		$tin_tuc_top = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "cat_type = 1 AND not_status = 1", "rand()", "DESC",0,4);
		$data['tin_tuc_top']=$tin_tuc_top;	
		$tin_khuyen_mai = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "id_category = 11 AND not_status = 1", "not_id", "DESC",0,4);
		$data['tin_khuyen_mai']=$tin_khuyen_mai;	
		$tin_congnghe = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "id_category = 8 AND not_status = 1", "not_id", "DESC",0,4);
		$data['tin_congnghe']=$tin_congnghe;
		$tin_tuvan = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "id_category = 13 AND not_status = 1", "not_id", "DESC",0,4);		
		$tin_vanhoa = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "id_category = 12 AND not_status = 1", "not_id", "DESC",0,4);
		$data['tin_vanhoa']=$tin_vanhoa;		
		$data['tin_tuvan']=$tin_tuvan;
		$tin_xem_nhieu_nhat = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "not_status = 1", "not_id", "DESC",0,15);
		$data['tin_xem_nhieu_nhat']=$tin_xem_nhieu_nhat;				
		$this->db->distinct('pro_category');  		  			
		$this->load->model('shop_model');  		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));	
	   	$data['isHome']	= 1;	
		$this->load->helper('text');	
		$data['module'] = 'relatedthesim';	
		$retArrayTintuc = array();			
		$this->loadCategoryPhanMem(13,0,$retArrayTintuc);		
		$retArraySanPhamCongNghe = array();			
		$this->loadCategoryPhanMem(15,0,$retArraySanPhamCongNghe);	
		$data['retArraySanPhamCongNghe'] = $retArraySanPhamCongNghe;
		
		$retArrayCateTuVan = array();			
		$this->loadCategoryPhanMem(16,0,$retArrayCateTuVan);	
		$data['retArrayCateTuVan'] = $retArrayCateTuVan;
							
		$data['category_view_right'] = $this->content_category_model->fetch("*","cat_type = 1");		
		$this->load->view('home/tintuc/defaults', $data);
	}
	
	function detail($id_detail)
	{
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 0;
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'home';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		$this->load->model('category_model');
		$this->load->model('content_model');		
		$detail_content = $this->content_model->get("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image,id_category", "not_status = 1 and not_id = ".$id_detail."");			
		$data['detail_content'] = $detail_content;
		$top10 = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, id_category", "not_status = 1 ", "not_id", "DESC",0,10);
		$data['top10']=$top10;
		$tin_xem_nhieu_nhat = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image", "not_status = 1 AND id_category = ".$detail_content->id_category." ", "not_id", "DESC",0,15);
		$data['tin_xem_nhieu_nhat']=$tin_xem_nhieu_nhat;				
		$this->db->distinct('pro_category');  		  			
		$this->load->model('shop_model');  		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));	
	   	$data['isHome']	= 1;	
		$this->load->helper('text');	
		$data['module'] = 'detail_tintuc';	
		$retArrayTintuc = array();				
		$this->loadCategoryPhanMem(13,0,$retArrayTintuc);		
		$data['category_view_right'] = $this->content_category_model->fetch("*","cat_type = 1");
		$this->load->view('home/tintuc/detail', $data);
	}
	
	function danhmuc($id_category)
	{
        
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 0;		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'home';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#BEGIN: Get random category
		$this->load->model('category_model');
		$this->load->model('content_model');	
		#If have page
		$getVar = $this->uri->uri_to_assoc();
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		$limit = 5;
		$this->load->library('pagination');	
		$totalRecord = count($this->content_model->fetch("not_id", "not_status = 1 and id_category = ".$id_category.""));
        $config['base_url'] = base_url().'tintuc/'.$id_category.'/'.$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = 5;
//		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		$retArrayTintuc = array();				
		$this->loadCategoryPhanMem($id_category,0,$retArrayTintuc);	
		$where="";
		if(count($retArrayTintuc)>0)
		{
			foreach($retArrayTintuc as $item)
			{
				$where.=$item->cat_id.",";
			}
			$where.=$id_category;
		}
		else
		{
			$where=$id_category;
		}
		$detail_content = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view", "not_status = 1 and id_category = ".$where,"not_id","DESC",$start, $limit);
		$data['detail_content']=$detail_content;

		$top10 = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, id_category", "not_status = 1 ", "not_id", "DESC",0,10);
		$data['top10']=$top10;

		$tin_xem_nhieu_nhat = $this->content_model->fetch("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, id_category", "not_status = 1 AND  id_category = ".$id_category."", "not_id", "DESC",0,15);
		$data['tin_xem_nhieu_nhat']=$tin_xem_nhieu_nhat;

		$this->db->distinct('pro_category');
		$this->load->model('shop_model');  		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));	
	   	$data['isHome']	= 1;	
		$this->load->helper('text');	
		$data['module'] = 'danhmuc_tintuc';
		$this->load->model('content_category_model');
		$title_category = $this->content_category_model->get("", "cat_id = ".$id_category."");			
		$data['title_category']=$title_category;		
		$retArrayTintuc = array();				
		$this->loadCategoryPhanMem(13,0,$retArrayTintuc);		
		$data['category_view_right'] = $this->content_category_model->fetch("*","cat_type = 1");	
		$this->load->view('home/cohoi/category', $data);
	}
	
	function loadCategoryPhanMem($parent, $level,&$retArray, $where)
	{
			$this->load->model('content_category_model'); 
		$select = "*";
		$whereTmp = "";
		if(strlen($where)>0){
			$whereTmp .= $where;
		}else{
			$whereTmp .= $where."parent_id='$parent'";
		} 
		$category  = $this->content_category_model->fetch($select, $whereTmp);
	
	   foreach ($category as $row)
	   {
		   $row->cat_name = $row->cat_name;
		   $retArray[] = $row;		   	 
	       $this->loadCategoryPhanMem($row->cat_id, $level+1,$retArray);
		    //edit by nganly de qui
				
	   }

	}
	
	function ajax_category(){

		$ret = $this->loadCategory4Search(0,0);
		echo $ret ;exit();
		
	}
	function long_polling(){
		if($this->session->userdata('sessionUser')>0){
			$query	=	"SELECT * FROM tbtt_session WHERE ip_address <> '".$_SERVER['REMOTE_ADDR']."' AND user_data like '%".$this->session->userdata('sessionUsername')."%'";
			$tempresult=$this->db->query($query); 
			$result=$tempresult->result();
			if(count($result)>=2){
				echo json_encode("1");
			}else{
				echo json_encode("0");
			}		
		}
		exit();		
	}
	
	function long_polling_cancel(){
		$sessionLogin1 = array('sessionLongPollingCancel' => 1);
		$this->session->set_userdata($sessionLogin1);	
		echo $this->session->userdata('sessionLongPollingCancel');
		exit();
	}
	
	function loadCategory4Search($parent, $level)
	{
		$this->load->model('category_model');
		$retArray = '';
	   $select = "*";
	   $selCat = $this->input->post('selCate');
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		 
		   foreach ($category as $key=>$row)
		   {
			   $selected = "";
			   if($selCat==$row->cat_id){
				    $selected = "selected='selected'";
			   }
			   $retArray .= "<option  value='$row->cat_id' $selected>$row->cat_name</option>";
		   }
		 
	   }
	   return $retArray;
	}
	
	function ajax_required_guarantee(){
		$shop_id=$_POST['shop_id'];
		$user_id=$this->session->userdata('sessionUser');
		$query	=	"SELECT * FROM tbtt_shop WHERE sho_users_required LIKE '%,".$user_id."%'";
		$tempresult=$this->db->query($query); 
		$result=$tempresult->result();
		if(count($result)>0){
			echo "1";
		}else{
			$query	=	"SELECT * FROM tbtt_shop WHERE sho_user=".$shop_id;
			$tempresult1=$this->db->query($query); 
			$result1=$tempresult1->result();
			if(count($result1)>0){
				$query	=	"UPDATE tbtt_shop SET sho_users_required = concat(sho_users_required,',".$user_id."') WHERE sho_user=".$shop_id;
				$this->db->query($query); 
			}			
			echo "0";
		}
		exit();
	}
	
	function ajax()
	{	
		if(isset($_POST['code'])){
			$localhost=settingLocalhost;
			$username=settingUsername;
			$password=settingPassword;
			$dbname=settingDatabase;
			$link = mysql_connect($localhost, $username, $password);
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($dbname, $link);
			
			//check for existence of active code
			$query="select * from jos_comprofiler where active_code='".$_POST['code']."' limit 1";
	
			$result=mysql_query($query);
			$row = mysql_fetch_assoc($result);
			$quantity=mysql_num_rows($result);
			mysql_close($link);
			// check for existence of active code in 
			$select="use_id";
			$this->load->model('user_model');
			if($_POST['code']!=""){
				$userHaveActiveCode = $this->user_model->fetch($select, "active_code = '".$_POST['code']."'", "use_id", "DESC");
			}
			if(count($userHaveActiveCode)>0){
				echo "2";
			}else{
				
				if($quantity > 0 && $_POST['code']!=""){
					echo "1";
				}else{
					echo "0";	
				}
				
			}
		
		
		}else{
			if($this->input->post('token') && $this->input->user_agent() != FALSE && $this->input->post('token') == $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5') && $this->input->post('object'))
			{
				if($this->input->post('type') && (int)$this->input->post('object') == 1)
				{
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$categoryProduct = (int)$this->input->post('type');
					$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category";
					$start = 0;
					$limit = (int)settingProductNew_Home;
					$product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryProduct AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
					echo "[".json_encode($product).",".count($product)."]";
				}
				elseif((int)$this->input->post('object') == 2)
				{
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$select = "pro_id, pro_name, pro_descr, pro_cost,pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category,pro_vip";
					$start = 0;
					$limit = (int)settingProductReliable_Home;
					$this->db->order_by("pro_vip", "random"); 
					$this->db->order_by("pro_id", "random"); 
					$product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_reliable = 1  AND pro_status = 1 ", $start, $limit); //AND pro_cost > 0 AND pro_reliable = 1 , order: "pro_vip", "DESC", \
					for($i=0;$i<settingProductReliable_Home; $i++){
						
						if($product[$i]->pro_saleoff==1){
							if($product[$i]->pro_saleoff_value>0){
								if($product[$i]->pro_type_saleoff==1){
									$product[$i]->pro_cost=$product[$i]->pro_cost - round(($product[$i]->pro_cost * $product[$i]->pro_saleoff_value)/100);	
								}else{
									$product[$i]->pro_cost=$product[$i]->pro_cost - $product[$i]->pro_saleoff_value;
								}
							}
							
						}
						
					}
					echo "[".json_encode($product).",".settingProductReliable_Home."]";
				}
				elseif((int)$this->input->post('object') == 3)
				{
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$select = "sho_descr, sho_logo, sho_dir_logo, sho_link";
					$start = 0;
					$limit = (int)settingShopInterest;
					$shop = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
					echo "[".json_encode($shop).",".count($shop)."]";
				}
				elseif($this->input->post('type') && (int)$this->input->post('object') == 4)
				{
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$where = "ads_status = 1 AND ads_enddate >= $currentDate";
					//$sort = "ads_id";
					$this->db->order_by("ads_vip", "desc"); 
					$this->db->order_by("ads_id", "desc"); 
					//$by = "DESC";
					switch((int)$this->input->post('type'))
					{
						case 1:
							$sort = "ads_view";
							break;
						case 2:
							break;
						default:
							$where .= " AND ads_reliable = 1 "; 
							//$sort = "ads_vip";
					}
					$select = "ads_id, ads_category, ads_title, ads_descr,FROM_UNIXTIME(ads_begindate) as ads_begindates, pre_name, ads_vip";
					$start = 0;
					$limit = (int)settingAdsNew_Home;
					$ads = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $start, $limit); //$sort, $by,
					echo "[".json_encode($ads).",".count($ads)."]";
				}
				elseif((int)$this->input->post('object') == 5)
				{
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$where = "job_status = 1 AND job_enddate >= $currentDate";
					$sort = "rand()";
					$by = "DESC";
					$select = "job_id, job_title, job_field, job_jober";
					$start = 0;
					$limit = (int)settingAdsNew_Home;
					$job = $this->job_model->fetch($select, $where, $sort, $by, $start, $limit);
					echo "[".json_encode($job).",".count($job)."]";
				}
			}
			else
			{
				show_404();
				die();
			}
			}
	}
	
	// quang 
	function ajax_mancatego(){
		
		$categoryId = $_POST['selCate'];
		$ret = $this->loadMancategory4Search($categoryId);
		echo $ret;
		exit();
		
	}
	
	function loadMancategory4Search($categoryId)
	{
		$this->load->model('category_model');
		$retArray = '';
	   $select = "*";	 
	   
	   $whereTmp = "man_status = 1 AND man_id_category = ".$categoryId;	
	   $category  = $this->category_model->fetch_mannufacturer($select, $whereTmp, "man_order", "ASC");
	   if( count($category)>0){
		 
		   foreach ($category as $key=>$row)
		   {
			   $selected = "";
			   if($selCat==$row->cat_id){
				    $selected = "selected='selected'";
			   }
			   $retArray .= "<option  value='$row->man_id' $selected>$row->man_name</option>";
		   }
		 
	   }
	   return $retArray;
	}
	
	//edn quang
	
	function autocompleteads(){
		$q = $_REQUEST["q"];
		if (!$q) return;
		$this->load->model('ads_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: autocomplete Ads
		$select = "ads_title";
		$this->db->like('ads_title', $q); 
		$allAds = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_title", "DESC");
		#END autocomplete Ads
				
		foreach ($allAds as $item) {			
				echo "$item->ads_title|$item->ads_title\n";	
		}
		
	}
	// Quang	
	function autocompleteshop(){
		$q = $_REQUEST["q"];
		if (!$q) return;
		$this->load->model('shop_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: autocomplete Ads
		$select = "sho_name";
		$this->db->like('sho_name', $q); 
		$allAds = $this->ads_model->fetch($select, "sho_status = 1 AND 	sho_enddate >= $currentDate", "sho_name", "DESC");
		#END autocomplete Ads
				
		foreach ($allAds as $item) {			
				echo "$item->sho_name|$item->sho_name\n";	
		}
		
	}	
	
	//end Quang
	function autocomplete(){
		$q = $_REQUEST["q"];	
		$type = $this->uri->segment(3);	
		if($type=="hoidap")
		{
			if (!$q) return;
					$this->load->model('hds_model');					
					$select = "hds_title";
					$this->db->like('hds_title', $q); 
					$allAds = $this->hds_model->fetch($select);
					#END autocomplete Ads
												
					foreach ($allAds as $item) {			
							echo "$item->hds_title|$item->hds_title\n";	
					}						
		}
		else
		{
			if($type=="raovat")
			{
				if (!$q) return;
					$this->load->model('ads_model');
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					#BEGIN: autocomplete Ads
					$select = "ads_title";
					$this->db->like('ads_title', $q); 
					$allAds = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_title", "DESC");
					#END autocomplete Ads
												
					foreach ($allAds as $item) {			
							echo "$item->ads_title|$item->ads_title\n";	
					}	
			}
			else
			{
				if($type=="shop")
				{
					
					if (!$q) return;
					$this->load->model('shop_model');
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					#BEGIN: autocomplete Ads
					$select = "sho_name";
					$this->db->like('sho_name', $q); 
					$allAds = $this->shop_model->fetch($select, "sho_status = 1 AND 	sho_enddate >= $currentDate", "sho_name", "DESC");
					#END autocomplete Ads
							
					foreach ($allAds as $item) {			
							echo "$item->sho_name|$item->sho_name\n";	
					}
		
				}else{
					if($type=="timviec")
					{
						
						if (!$q) return;
						$this->load->model('employ_model');
						$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
						#BEGIN: autocomplete Ads
						$select = "emp_title";
						$this->db->like('emp_title', $q); 
						$allAds = $this->employ_model->fetch($select, "emp_status = 1 AND 	emp_enddate >= $currentDate", "emp_title", "DESC");
						#END autocomplete Ads
								
						foreach ($allAds as $item) {			
								echo "$item->emp_title|$item->emp_title\n";	
						}
			
					}else{
							if($type=="tuyendung")
							{
								
								if (!$q) return;
								$this->load->model('job_model');
								$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
								#BEGIN: autocomplete Ads
								$select = "job_title";
								$this->db->like('job_title', $q); 
								$allAds = $this->job_model->fetch($select, "job_status = 1 AND 	job_enddate >= $currentDate", "job_title", "DESC");
								#END autocomplete Ads
										
								foreach ($allAds as $item) {			
										echo "$item->job_title|$item->job_title\n";	
								}
					
							}else{ 
								if($type=="product"){					
									if (!$q) return;
									$this->load->model('product_model');
									$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
									#BEGIN: autocomplete
									$select = "pro_name";
									$this->db->like('pro_name', $q); 
									$allProduct = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "", "", "", "", "", "", "pro_status = 1  AND sho_status = 1 ", "pro_name", "DESC");

									//$allProduct = $this->product_model->fetch($select, "pro_status = 1 ", "pro_name", "DESC");	
											
									foreach ($allProduct as $item) {			
											echo "$item->pro_name|$item->pro_name\n";	
									}
							   }
						 }
						
					}
				
				}
				
			}
		}
		
	}
	function rss(){
		
		$this->load->model('product_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: autocomplete
		$select = "pro_id,pro_name,pro_descr,pro_detail,pro_category,pro_dir,pro_image,pro_begindate";
		//$this->db->like('pro_id', $q); 
		$this->db->limit(20);
		$allProduct = $this->product_model->fetch($select, "pro_status = 1 ", "pro_id", "DESC");	
		
		$now = date("D, d M Y H:i:s T");

		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <rss version=\"2.0\">
                <channel>
                    <title>Sản phẩm mới nhất</title>
                    <link>http://vnbuy.com/rss</link>
                    <description>20 sản phẩm cập nhật gần đây nhất</description>
                    <language>vi-vn</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <docs></docs>
                    <managingEditor>tiennham@icsc.vn</managingEditor>
                    <webMaster>tiennham@icsc.vn</webMaster>
            ";
            
		for($i=0;$i < count($allProduct);$i++)
		{
			$line = $allProduct[$i];
		
			$output .= "<item><title>".$line->pro_name."</title>
			
							<link>".base_url().$line->pro_category."/".$line->pro_id."/".removeSign($line->pro_name)."</link>                    
		<description><![CDATA[ <a href=\"".base_url().$line->pro_category."/".$line->pro_id."/".removeSign($line->pro_name)."\"><img src=\"".base_url()."media/images/product/".$line->pro_dir."/".show_thumbnail($line->pro_dir, $line->pro_image, 2)."\"/></a> <br/> ".$line->pro_descr." ]]></description>
		<pubDate>".date('d / m / Y H:i',$line->pro_begindate)."</pubDate>
						</item>";
		}
		
		$output .= "</channel></rss>";
		header("Content-Type: application/rss+xml");
		echo $output;
	}
	
	function ajaxdomain(){
		$domain = $_POST['domainname'];
		
		$domaintohtmlid =str_replace(".", "_", $domain);
		// Kiem tra su ton tai cua ten mien
		if(file_get_contents("http://www.pavietnam.vn/vn/whois.php?domain=$domain")=='0')
		{
			echo "$domaintohtmlid----1";
		}
		else
		{
			echo "$domaintohtmlid----0";
		}	
		exit();
	}
	
}