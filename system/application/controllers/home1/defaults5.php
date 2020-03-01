<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Defaults extends Controller
{
	function __construct()
	{
		parent::Controller();
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
		
		$data['menuType'] = 'product';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
		
		#BEGIN: Notify
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "not_id, not_title, not_detail, not_degree";
		$this->db->limit(settingNotify);
		$this->db->order_by("not_id", "DESC"); 
		$data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_enddate  >= $currentDate", "not_degree", "DESC");
		#END Notify
		$data['globalProduct']=1;
		$this->load->vars($data);
		#END Ads & Notify Taskbar
		
	
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
	       $this->loadMenu($row->men_category, $level+1,&$retArray);
	
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
			   $link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
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
			if(count($category) == 2){$rowwidth = 380;}
			if(count($category) >= 3){$rowwidth = 570;}
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
					$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
					$retArray .= "<li>".$link."</li>";
					
				}
					$retArray.= "<li ><a class='xemtatca_menu' href='product/xemtatca/".$parent."' > Xem tất cả </a></li>";
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	function index()
	{
        
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: Menu
		$data['menuSelected'] = 0;
		
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'home';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
		#BEGIN: Top product saleoff right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		$start = 0;
  		$limit = (int)settingProductSaleoff_Top;
		$data['topSaleoffProduct'] = $this->product_model->fetch($select, "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top product saleoff right
		#BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#BEGIN: Tab product category (4 tab)
		if((int)date('j') > 10)
		{
			$tabStart = 0;
		}
		else
		{
            $tabStart = (int)date('j') - 1;
		}
		$tabProductCategory = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_id", "ASC", $tabStart, 4);
		$tabIs = 1;
		foreach($tabProductCategory as $tabProductCategoryArray)
		{
			$data['tabIDCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_id;
			$data['tabNameCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_name;
			$tabIs++;
		}
		#END Tab product category (4 tab)
		#BEGIN: Favorite product
  		$select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total";
  		$start = 0;
  		$limit = 8;
  		$data['favoriteProduct'] = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_vote", "DESC", $start, $limit);
		#END Favorite product
		
		#BEGIN: Top lastest ads right
		$select = "ads_id, ads_title, ads_descr, ads_category";
		$start = 0;
  		$limit = (int)settingAdsNew_Top;
		$data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
		#END Top lastest ads right
		
		#BEGIN: Get random category
		$this->load->model('category_model');	
		$select = "cat_id";
  		$randomCategory= $this->category_model->fetch($select, "parent_id = 0 AND cat_status = 1",'cat_id', 'rand()');
		
		$arrayCat=array();
		for($i=0;$i<count($randomCategory);$i++){
			$arrayCat[]=$randomCategory[$i]->cat_id;
		}
		
		$rand_keys = array_rand($arrayCat, 3);
		
		// first category name 
		$select = "*";
  		$data['firstCatName'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[0]);
		
		// second category name 
		$select = "*";
  		$data['secondCatName'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[1]);
		
		#BEGIN: Frirst Category in Homepage
  		$select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total,pro_saleoff_value, pro_type_saleoff,pro_cost,pro_view,sho_name,sho_begindate,pre_name";
  		$start = 0;
  		$limit = 6;
  		$data['firstCat'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = ".$rand_keys[0]."  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
		#END  Frirst Category in Homepage
		
		
		#BEGIN: Second Category in Homepage
  		$select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total,pro_saleoff_value, pro_type_saleoff,pro_cost,pro_view,sho_name,sho_begindate,pre_name";
  		$start = 0;
  		$limit = 6;
  		$data['secondCat'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = ".$rand_keys[1]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
		#END  Second Category in Homepage
		
		#BEGIN Feature shop		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "sho_descr, sho_logo, sho_dir_logo, sho_link, sho_name";
		$start = 0;
		$limit = (int)settingShopInterest;
		$data['shopFeatured'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		
		#END Feature shop			
		
		#BEGIN Vote
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "pro_id, pro_name, pro_descr, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category,pro_view,sho_name,sho_begindate,pre_name";
		$start = 0;
		$limit = (int)settingProductVote;
		$data['productVote'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_status = 1 AND pro_enddate >= $currentDate", "pro_vote", "DESC", $start, $limit);
	
		#BEGIN: Featured Products
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$select = "pro_id, pro_name, pro_descr, pro_cost,pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category, pro_vip, pro_view,sho_name,sho_begindate,pre_name";
		$this->db->order_by("pro_vip", "random"); 
		$this->db->order_by("pro_id", "random"); 
		$this->db->limit(settingProductReliable_Home);
		$data['productFeatured'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "","pro_image != 'none.gif' AND pro_reliable = 1  AND pro_status = 1 AND pro_enddate >= $currentDate");	
	
		#END: Featured Products
						
		/*$this->load->model('content_model');		
		$contentFooter = $this->content_model->fetch("*", "not_id = ".contentFooter." AND not_status = 1", "not_id", "DESC");
		$yahooChatFooter = $this->content_model->fetch("*", "not_id = ".yahooChatFooter." AND not_status = 1", "not_id", "DESC");
		$fastLink = $this->content_model->fetch("*", "not_id = ".fastLink." AND not_status = 1", "not_id", "DESC");
		$this->load->library('session');
		$this->session->set_userdata('contentFooter', $contentFooter);
		$this->session->set_userdata('yahooChatFooter', $yahooChatFooter);
		$this->session->set_userdata('fastLink', $fastLink);*/		
		
		$this->load->helper('text');		
		#Load view
		$this->load->view('home/defaults/defaults', $data);
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
					$product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryProduct AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
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
					$product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_reliable = 1  AND pro_status = 1 AND pro_enddate >= $currentDate", $start, $limit); //AND pro_cost > 0 AND pro_reliable = 1 , order: "pro_vip", "DESC", \
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
		
				}
				else{ if($type=="product"){
					
					if (!$q) return;
					$this->load->model('product_model');
					$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					#BEGIN: autocomplete
					$select = "pro_name";
					$this->db->like('pro_name', $q); 
					$allProduct = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_name", "DESC");	
							
					foreach ($allProduct as $item) {			
							echo "$item->pro_name|$item->pro_name\n";	
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
		$allProduct = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_id", "DESC");	
		
		$now = date("D, d M Y H:i:s T");

		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <rss version=\"2.0\">
                <channel>
                    <title>Sản phẩm mới nhất</title>
                    <link>http://www.azibai.com/rss</link>
                    <description>20 sản phẩm cập nhật gần đây nhất</description>
                    <language>vi-vn</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <docs></docs>
                    <managingEditor>nganly@lkvsolutions.vn</managingEditor>
                    <webMaster>nganly@lkvsolutions.vn</webMaster>
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
}