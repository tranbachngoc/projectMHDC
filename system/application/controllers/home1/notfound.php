<?php
###BUILD BY PHUC NGUYEN
class Notfound extends CI_Controller
{
	function __construct()
	{
            parent::__construct();
	           
	    $this->lang->load('home/common');
	    $this->load->model('category_model');
	    $this->load->model('package_user_model');
	    $this->load->model('shop_model');	    
	    $this->load->model('user_model');
	
	    $this->load->library('Mobile_Detect');
	    $detect = new Mobile_Detect();

	    $data['isMobile'] = 0;
	    if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
		$data['isMobile'] = 1;
	    }
	    
	    if($this->session->userdata('sessionUser')){
		$data['currentuser'] = $this->user_model->get("use_id,use_username,avatar","use_id = " . $this->session->userdata('sessionUser'));

		if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2){
		    $shop = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
		} elseif($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15 ) { 
		    $parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
		    $shop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
		}

		if($shop){
		    if($shop->domain){
			$linktoshop = "//".$shop->domain;
		    }else{
			$linktoshop = "//".$shop->sho_link .'.'. domain_site;
		    }
		    $data['linktoshop'] =  $linktoshop;
		}            
	    }
	    
	    $this->load->vars($data);
	}
        
        function index(){
            $this->load->view('home/page_not_found/index', $data);
        }
}