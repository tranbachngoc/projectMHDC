<?php
#****************************************#
# * @Author: icsc                   #
# * @Email: info@icsc.vn          #
# * @Website: http://www.icsc.vn  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Newsletter extends MY_Controller
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
		$langguage = $this->session->userdata('langguage');
		if(!isset($langguage) || $langguage ==''){
			$langguage = 'vietnamese';
		}
		$this->lang->load('home/common',$langguage);

		#Load model
		$this->load->model('newsletter_model');	
		$this->load->helper('text');	
		//$this->load->vars($data);
	}
	
	
	function index()
	{
        $currentDate = time();	
        $id = (int)$this->uri->segment(2);
       
	}
	
	function ajax(){
		$currentDate = time();	
		$email = trim($this->filter->injection_html($this->input->post('email')));
		$this->session->set_userdata('sessionEmailnewsletter', $email);
		$dataPost = array(
			'new_email'      		=>      $email,
			'new_created_date'      =>      $currentDate,
			'new_status'   			=>      1
		);
		$where = "new_email = '".$email."'";
		$totalRecord = count($this->newsletter_model->fetch("new_id", $where));	
		if($totalRecord >= 1){
			echo "2";
			exit();
		}		
		if($this->newsletter_model->add($dataPost)){
			echo "1";
		}else{
			echo "0";
		}	
		
		exit();
	}
}