<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Naptien extends MY_Controller
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
		#BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url().'login', 'location');
			die();
		}
		#END CHECK LOGIN
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/account');
		
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
	function process(){
		$type = $this->input->post('pay_method');
		switch($type){
			case "card" :
				$this->naptien_sohapay();
				break;
			default:
				$url = base_url()."account/naptien";
				redirect($url);
		}
	}
	function naptien_sohapay(){		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		$data['menuType'] = 'account';
		$data['menuSelected'] = 'naptien';
		$this->load->view('home/account/naptien/naptien', $data);
	}
	function submit_sohapay(){
		
		$this->load->model('sohapay_model');
		
		$this->load->model('uptin_model');
		$order_id = 'pay'.time();
		$this->session->set_flashdata('order_id',$order_id);
		$total_amount = $this->input->post('total_amount');		
		$order_description = $this->lang->line("Nap tien qua sohapay");
		$url_success = base_url()."naptien/verifyresponse/";
		$url_cancel = base_url()."naptien/fail_transaction/";
		$url_detail = "";
		$this->load->model('user_model');
		$user = $this->user_model->get("*", "use_id = ".$this->session->userdata('sessionUser'));

		$url = $this->sohapay_model->buildCheckoutUrl($url_success, $order_description, $order_id, $total_amount, $user->use_email, $user->use_mobile);
		redirect($url);
	}
	function verifyresponse(){
		$this->load->model('sohapay_model');
		$this->load->model('uptin_model');				
		$error_text=$_GET["error_text"];
		$check = $this->sohapay_model->verifyReturnUrl();
		if($check && $error_text==''){
			$net_amount = round($_GET['price'] /10000);	
			$transaction_id = $_GET['order_code'];					
			//Mot so thong tin khach hang khac
			$customer_email = $_GET['order_email'];
			$username = $this->session->userdata('sessionUsername');
//			echo "<pre>".$net_amount." va ";print_r($username);echo "</pre>";die();
			$exist = $this->uptin_model->getOrderId($transaction_id);
			if($exist->order_id) redirect(base_url()."naptien/fail_transaction/"); 
			else
				$return = $this->uptin_model->insertWallet($username, (int)$net_amount, $this->lang->line('NAPTIENSHP'),$transaction_id);			
			
			if($return)
				redirect(base_url()."naptien/success/");
			else redirect(base_url()."naptien/fail_transaction/"); 		
		}else redirect(base_url()."naptien/fail_transaction/"); 
	}
	function success(){
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");	
		$data['menuType'] = 'account';
		$data['menuSelected'] = 'naptien';
		$this->load->view('home/account/naptien/success', $data);	
	}
	function fail_transaction(){
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");	
		$data['menuType'] = 'account';
		$data['menuSelected'] = 'naptien';
		$this->load->view('home/account/naptien/fail', $data);
	}	
	
}