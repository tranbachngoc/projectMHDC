<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Guide extends MY_Controller
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
		$this->lang->load('home/guide');
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
		$data['menuType'] = 'product';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
		
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
			   //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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
			$retArray .= "<ul class='sub'>";
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 380;}
			if(count($category) >= 3){$rowwidth = 570;}
			foreach ($category as $key=>$row)
			{
				//$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
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
					//$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	function index()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'guide';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#Load view
		$this->load->view('home/guide/defaults', $data);
	}
}