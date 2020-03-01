<?php
class Test extends CI_Controller
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
		$this->lang->load('admin/menu');
	}
	
	function index()
	{
		#Load view
		if($this->uri->segment(4) == 'service'){
			$sql =  'UPDATE tbtt_package_user SET status = 1';
			$data['type'] = 'Thiết lập dữ liệu test hoa hồng Giải pháp thành công!';
			$this->db->query($sql);
			
		}
		if($this->uri->segment(4) == 'order'){
			$sql =  "UPDATE tbtt_showcart SET shc_status = '98', shc_change_status_date = ".time();
			$data['type'] = 'Thiết lập dữ liệu test hoa hồng Bán sản phẩm thành công!';
			$this->db->query($sql);			
		}
		if($this->uri->segment(4) == 'truncate'){
			
			$sql1 =  "TRUNCATE tbtt_commission";			
			$this->db->query($sql1);	
			$sql2 =  "TRUNCATE tbtt_revenue";			
			$this->db->query($sql2);	
			$sql3 =  "TRUNCATE tbtt_revenue_store_category";
			$this->db->query($sql3);		
			$sql4 =  "TRUNCATE tbtt_commission_empty_position";	
			$this->db->query($sql4);

			$sql5 =  "TRUNCATE tbtt_money";
			$this->db->query($sql5);

			$sql6 =  "TRUNCATE tbtt_money_logs";
			$this->db->query($sql6);

			$data['type'] = 'Đã xóa dữ liệu tính hoa hồng!';
		}
		$this->load->view('admin/test/default',$data);
	}
	
	function update_status_package_user(){
		$sql =  'UPDATE tbtt_package_user SET status = 1';
		$this->db->query($sql);
		return;
	}
}
?>