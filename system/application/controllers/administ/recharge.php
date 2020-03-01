<?php
class Recharge extends CI_Controller
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
        $this->load->model('walletlog_model');
        $this->load->model('wallet_model');
	}

    public function index() {

        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'wallet_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }

        // #BEGIN: Search & Filter
        $where = '';
        $sort = 'tbtt_walletlog.id';
        $by = 'DESC';
        // $sortUrl = '';
        // $pageSort = '';
        // $pageUrl = '';
        // $keyword = '';
        //$q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';

        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        $q = '';

        if($getVar['keyword'] != FALSE && trim($getVar['keyword']) != ''){
            $id = (int)$getVar['keyword'];
            $q .= $id;
            $where .= 'tbtt_walletlog.id = '.$id;
        }

        #END CHECK PERMISSION
        $params = array(
            'order_by'      => array('key'=>'tbtt_walletlog.status_id','value'=>'DESC'),
            'is_count'      => false,
            'id'      =>  $q
        );

        $data['walletlog1'] = $this->walletlog_model->listWalletLog($params);

        //$getVar = $this->uri->uri_to_assoc(3, $action);

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

        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($data['walletlog1']);
        $config['base_url'] = base_url().'administ/recharge'.$pageUrl.'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination

        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $select = "tbtt_walletlog.*,tbtt_wallet.id_walletlog, tbtt_wallet.update_by_admin, tbtt_wallet.status_apply, tbtt_user.*";
//        $select = " tbtt_walletlog.*, tbtt_wallet.* , tbtt_user.*";
        $limit = settingOtherAdmin;
        $data['walletlog'] = $this->walletlog_model->fetch($select, $where, $sort, $by, $start, $limit);

        $data['page'] = array(
            'title' => 'Danh sách nạp tiền',
            'status' => '06',
            'next_status' => FALSE,
            'next_status_title' => 'nạp tiền'
        );
        #Load view
        $this->load->view('admin/recharge/default', $data);
    }
    
//    public function updateStatus(){
//        if($this->input->server('REQUEST_METHOD')=='POST'){
//            $this->load->model('user_model');
//            if($this->input->post('id')){
//                $update = $this->walletlog_model->update(array('status_id' => '1'),'id = '.$this->input->post('id'));
//                if($update){
//                    $walletlog = $this->walletlog_model->get('user_id,amount','id = '.$this->input->post('id'));
//                    $user_info = $this->user_model->get('use_id,use_group,parent_id','use_id = '.$walletlog->user_id);
//
//                    $wallet = array(
//                        'user_id'               =>      $user_info->use_id,
//                        'group_id'              =>      $user_info->use_group,
//                        'parent_id'             =>      $user_info->parent_id,
//                        'amount'                =>      $walletlog->amount,
//                        'type'                  =>      '1',
//                        'description'           =>      'Nạp tiền - Banking',
//                        'created_date'          =>      date("Y-m-d H:i:s"),
//                        'month_year'            =>      date("m-Y"),
//                        'status'                =>      '0'
//                    );
//                    $wallet_id = $this->wallet_model->add($wallet);
//                    if($wallet_id){
//                        die("1");
//                    } else {
//                        die("0");
//                    }
//                } else {
//                    die("0");
//                }
//            } else {
//                die("0");
//            }
//        }
//    }
    public function updateStatus(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model('user_model');
            if($this->input->post('id')){
              $update = $this->walletlog_model->update(array('status_id' => '1', 'update_by_accountant'=>time()),'id = '.$this->input->post('id'));
                if($update){
                    die("1");
                } else {
                    die("0");
                }
            } else {
                die("0");
            }
        }
    }
     public function updateAmount(){
            if($this->input->server('REQUEST_METHOD')=='POST'){
                $this->load->model('user_model');
                if($this->input->post('id') && $this->input->post('amount')){
                  $update = $this->walletlog_model->update(array('amount' => $this->input->post('amount')),'id = '.$this->input->post('id'));
                  $update1 =  $this->wallet_model->update(array('amount' => $this->input->post('amount'), 'update_by_admin'=>time()),'id_walletlog = '.$this->input->post('id'));
                    if($update && $update1){
                        die("1");
                    } else {
                        die("0");
                    }
                } else {
                    die("0");
                }
            }
     }
     public function Checkpass(){
         $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
         $this->load->model('user_model');
       //  $user = $this->user_model->get("use_id, use_password, use_salt,use_username, use_group, use_status, use_enddate", "use_id = '" . (int)$this->session->userdata('sessionUserAdmin'). "'");
         $user = $this->user_model->get("use_id, use_password, use_salt,use_username, use_group, use_status, use_enddate,use_fullname,use_email", "use_id = '" . (int)$this->session->userdata('sessionUserAdmin'). "'");
         if (count($user) == 1) {
             $this->load->library('hash');
             $password = $this->hash->create($this->input->post('pass_put'), $user->use_salt, 'md5sha512');
             if ($user->use_password === $password && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 14) {
                 $this->user_model->update(array('use_lastest_login' => time()), "use_id = " . $user->use_id);
                 echo '1';
                 exit();
              }
         }
     }

    public function AdminActive(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model('user_model');
            if($this->input->post('id')){
                    $walletlog = $this->walletlog_model->get('user_id,amount','id = '.$this->input->post('id'));
                    $user_info = $this->user_model->get('use_id,use_group,parent_id','use_id = '.$walletlog->user_id);
                    $wallet = array(
                        'id_walletlog'          =>      $this->input->post('id'),
                        'user_id'               =>      $user_info->use_id,
                        'group_id'              =>      $user_info->use_group,
                        'parent_id'             =>      $user_info->parent_id,
                        'amount'                =>      $walletlog->amount,
                        'type'                  =>      '1',
                        'description'           =>      'Nạp tiền - Banking',
                        'created_date'          =>      date("Y-m-d H:i:s"),
                        'update_by_admin'       =>      time(),
                        'month_year'            =>      date("m-Y"),
                        'status'                =>      '0',
                        'status_apply'          =>      '1'
                    );
                    $wallet_id = $this->wallet_model->add($wallet);
                if($wallet_id){
                    $this->walletlog_model->update(array('active' => 1),'id = '.$this->input->post('id'));
                        die("1");
                    } else {
                        die("0");
                    }
            } else {
                die("0");
            }
        }
    }
    public function AdminDelete(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->model('walletlog_model');
            if($this->input->post('id')){
               $delete = $this->walletlog_model->delete($this->input->post('id'),'id');
                if ($delete){
                    die("1");
                } else{
                    die("0");
                }

            } else {
                die("0");
                }
        } else {
                die("0");
        }
    }
}
?>