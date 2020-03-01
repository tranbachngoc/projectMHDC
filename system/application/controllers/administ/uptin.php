<?
class Uptin extends CI_Controller
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
		#Load model
		$this->load->model('user_model');
		$this->load->model('uptin_model');
		#Load language
		$this->lang->load('admin/common');
		$this->load->helper('form');
	
	}
	function xoagiaodich(){
		$id=$_POST['id'];
		
		if($this->db->delete('tbtt_account_thongkegiaodich', array('id' => $id))){
			echo "1";
		}else{
			echo "0";
		}
		exit();			
		
	}
	
	function xoathongkedondatnaptien(){
		
		
		$id=$_POST['id'];
		
		if($this->db->delete('tbtt_sohapaygateway', array('soh_id' => $id))){
			echo "1";
		}else{
			echo "0";
		}
		exit();			
		
	}
	
	function naptientudondat(){
		$this->load->model('nap_tien_model');
		if($this->uri->segment(4) != ''){
			$return = $this->uptin_model->insertWallet(trim($this->uri->segment(4)), (int)$this->uri->segment(5)/10000, "Nạp tiền từ đơn đặt hàng  DD".$this->uri->segment(6));
			if($return  == 1){
				$this->nap_tien_model->update(array('soh_status'=>1), "soh_id = ".(int)$this->uri->segment(6));
				
				redirect(base_url().'administ/uptin/thongkedondatnaptien', 'location');
			}
		
			$this->load->view('admin/uptin/naptien', $data);
		}
		
		$this->load->view('admin/uptin/naptien', $data);
		
	}
	
	
	function giaup(){
		$this->load->model('uptin_model');
		
		$data['price_up']=$this->uptin_model->GetGiaTienUpTin();	
		if(trim($this->input->post('submit_form'))=='1')
		{
			$this->uptin_model->SotienUptintrenlan($this->input->post('money'));
			$data['price_up']=$this->uptin_model->GetGiaTienUpTin();
			$data["capnhatthanhcong"] = 1;	
		}
		$this->load->view('admin/uptin/giaup', $data);
		
	}
	
	
	
	function naptien(){
	
		if($this->input->post('submit_form') == '1'){
			$return = $this->uptin_model->insertWallet(trim($this->input->post('username')), (float)$this->input->post('money'), $this->input->post('description'));
			if($return  == 1){
				redirect(base_url().'administ/uptin/thongke', 'location');
			}
		
			$this->load->view('admin/uptin/naptien', $data);
		}
		
		$this->load->view('admin/uptin/naptien', $data);
		
	}
	
	function thongkedondatnaptien(){		
		$action = array('keyword', 'type', 'day','month', 'year', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);	
		#BEGIN: Search & Filter
		$where = '';
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		$type = '';
		$day = '';
		$month = '';
		$year = '';
		$sortUrl .= 'administ/uptin/thongkedondatnaptien';
		$pageUrl .= 'administ/uptin/thongkedondatnaptien';
		if($getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{		
			$keyword = $getVar['keyword'];				 
			$sortUrl .= '/keyword/'.$getVar['keyword'];
			$pageUrl .= '/keyword/'.$getVar['keyword'];
			$where .= "soh_username LIKE '%".$this->filter->injection($getVar['keyword'])."%' ";
		
		}
		if($getVar['type'] != FALSE && trim($getVar['type']) != '')
		{
			$type = $getVar['type'];
			$sortUrl .= '/type/'.$getVar['type'];
			$pageUrl .= '/type/'.$getVar['type'];			
			$data['selType'] = $type;
			//$where .= "and g.type = '".$this->filter->injection($getVar['type'])."' ";
		
		}
		$date = "";
		if($getVar['year'] != FALSE && trim($getVar['year']) != '')
		{
			$year = $getVar['year'];
			
			$sortUrl .= '/year/'.$year ;
			$pageUrl .= '/year/'.$year ;
			//$date .= "$year";
		}
	
		if($getVar['month'] != FALSE && trim($getVar['month']) != '')
		{
			$month = $getVar['month'];
			
			$sortUrl .= '/month/'.$month ;
			$pageUrl .= '/month/'.$month ;
			//$date .= "-$month";
		}
		
		if($getVar['day'] != FALSE && trim($getVar['day']) != '')
		{
			$day = $getVar['day'];
			
			$sortUrl .= '/day/'.$day ;
			$pageUrl .= '/day/'.$day ;
			//$date .= "-$day";
		}
		if($date != ""){
			//$where .= "and date_time LIKE '%$date%' ";
		}
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		
		
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
		
		}
		else
		{
			$start = 0;
		}
		
		$this->load->library('pagination');
		$this->load->model('nap_tien_model');

        $config['base_url'] = base_url().$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;
		$limit = settingOtherAdmin;		
		$data["giaodich"] = $this->nap_tien_model->fetch("*",$where,"soh_id", "DESC",$start,$limit);	
		$this->load->view('admin/uptin/thongkenaptien', $data);
		
	}
	
	function suanaptien()
	{	
		if($this->input->post('submit_form') == '1'){
			
			$user=$this->user_model->getUserByUsername(trim($this->input->post('username')));
			
			if(count($user)>0){
				$data['giaodich']=$this->uptin_model->getgiaodich("g.*","and g.type = 3 and g.user_id=".$user->use_id,"g.date_time","DESC");
			}
			
			$this->load->view('admin/uptin/suanaptien', $data);
			return;
			
		}
		
		$this->load->view('admin/uptin/suanaptien', $data);
	}
	
	
	function thongke(){
		$action = array('keyword', 'type', 'day','month', 'year', 'sort', 'by', 'page', 'status', 'id');
		$getVar = $this->uri->uri_to_assoc(4, $action);
	
		#BEGIN: Search & Filter
		$where = '';
		$sort = '';
		$by = '';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$keyword = '';
		$type = '';
		$day = '';
		$month = '';
		$year = '';
		$sortUrl .= 'administ/uptin/thongke';
		$pageUrl .= 'administ/uptin/thongke';
		if($getVar['keyword'] != FALSE && trim($getVar['keyword']) != '')
		{
		
			$keyword = $getVar['keyword'];		
			$sortUrl .= '/keyword/'.$getVar['keyword'];
			$pageUrl .= '/keyword/'.$getVar['keyword'];
			$where .= "and use_username LIKE '%".$this->filter->injection($getVar['keyword'])."%' ";
		
		}
		if($getVar['type'] != FALSE && trim($getVar['type']) != '')
		{
			$type = $getVar['type'];
			$sortUrl .= '/type/'.$getVar['type'];
			$pageUrl .= '/type/'.$getVar['type'];
			
			$data['selType'] = $type;
			$where .= "and g.type = '".$this->filter->injection($getVar['type'])."' ";
		
		}
		$date = "";
		if($getVar['year'] != FALSE && trim($getVar['year']) != '')
		{
			$year = $getVar['year'];
			
			$sortUrl .= '/year/'.$year ;
			$pageUrl .= '/year/'.$year ;
			$date .= "$year";
		}
	
		if($getVar['month'] != FALSE && trim($getVar['month']) != '')
		{
			$month = $getVar['month'];
			
			$sortUrl .= '/month/'.$month ;
			$pageUrl .= '/month/'.$month ;
			$date .= "-$month";
		}
		
		if($getVar['day'] != FALSE && trim($getVar['day']) != '')
		{
			$day = $getVar['day'];
			
			$sortUrl .= '/day/'.$day ;
			$pageUrl .= '/day/'.$day ;
			$date .= "-$day";
		}
		if($date != ""){
			$where .= "and date_time LIKE '%$date%' ";
		}
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
			$pageSort .= '/page/'.$start;
		}
		else
		{
			$start = 0;
		}
		
		$data["giaodich"] = $this->uptin_model->getgiaodich("g . * , u.use_username, t.type",$where,"g.date_time", "DESC");	
		#If have page
		if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
		{
			$start = (int)$getVar['page'];
		
		}
		else
		{
			$start = 0;
		}
		#BEGIN: Pagination
		$this->load->library('pagination');
		#Count total record
		$totalRecord = count($data["giaodich"]);
        $config['base_url'] = base_url().$pageUrl.'/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAdmin;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();		
		$data['sTT'] = $start + 1;
		$limit = settingOtherAdmin;				
		$data["giaodich"] = $this->uptin_model->getgiaodich("g . * , u.use_username, t.type",$where,"g.date_time", "DESC",$start,$limit);	
		$data["loaigiaodich"] = $this->uptin_model->getgiaodichtype("*","");
		$this->load->view('admin/uptin/thongke', $data);
	}
	function index(){
		echo "index";	
			$this->load->view('admin/uptin/index', $data);
	}
	function check_username(){
		$username = $this->uri->segment(4);		
		$count=count($this->user_model->getUserByUsername($username));	
		if($count==0) echo "0";
		else echo "1";
		exit();
	}
	
	function ajax_update_naptien(){
										
		if((int)$_POST['value']>0 && (int)$_POST['id']>0){
			$query	=	"UPDATE tbtt_account_thongkegiaodich set amount = ".$_POST['value']." where id = ".$_POST['id'];
			if($this->db->query($query)){
				echo "1";
			}else{
				echo "0";
			}		
			
		}else{
			echo "0";
		}
	}
	
}
?>