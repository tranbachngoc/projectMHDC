<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Follow extends MY_Controller
{
    private $mainURL;
    private $subURL;
    private $shop_url = '';
    private $shop_current = '';

    function __construct()
    {
        parent::__construct();

        #Load model
        $this->load->model('user_model');
        // $this->load->model('shop_model');
        $this->load->model('follow_model');


        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }

        $this->load->helper('cookie');
        #Load language
        $this->lang->load('home/common');
        
        
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
    

        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }
    
    public function ajax_follow_user()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {   
            $getFriend = $this->friend_model->get('*', ['user_id' => (int)$idUser, 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
            $getIsFriend = $this->friend_model->get('*', ['add_friend_by' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);
            if (empty($getIsFriend))
            {
                if (empty($getFriend))
                {
                    $dataInsert = [
                        'user_id' => (int)$idUser,
                        'add_friend_by' => $this->session->userdata('sessionUser')
                    ];
                    if ($this->friend_model->add($dataInsert)) {
                        $this->callAPI('GET', API_UPDATE_USER.'?user_id='.(int)$idUser.'&user_id_add='.(int)$this->session->userdata('sessionUser'));
                        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
                        if (!empty($getFollow))
                        {
                            if($this->follow_model->update(['hasFollow' => 1],'id = '.(int)$getFollow[0]->id)){
                                $result = ['error' => false, 'addFriend' => true, 'user'=> true];
                            }else{
                                $result = ['error' => false, 'addFriend' => false, 'user'=> true];
                            }
                        }else{
                            $dataFollow = [
                                'user_id' => (int)$idUser,
                                'follower' => $this->session->userdata('sessionUser'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'created_at' => date('Y-m-d H:i:s')
                            ];
                            if ($this->follow_model->add($dataFollow)) {
                                $result = ['error' => false, 'addFriend' => true, 'user'=> true];
                            }
                        }
                    }
                }
            }else
            {
               $result = ['error' => false, 'addFriend' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'addFriend' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();
    }

    public function ajax_confirmfollow_user()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {
            $getIsFriend = $this->friend_model->get('id', ['add_friend_by' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser'), 'accept' => 0]);
            if (!empty($getIsFriend))
            {
                $dataUpdate = ['accept' => 1];
                if ($this->friend_model->update($dataUpdate,'id = '.(int)$getIsFriend[0]->id)) {
                    $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
                    if (!empty($getFollow))
                    {
                        if($this->follow_model->update(['hasFollow' => 1],'id = '.(int)$getFollow[0]->id))
                        {
                            $result = ['error' => false, 'confirmFriend' => true, 'follow' => true, 'user'=> true];
                        }else{
                            $result = ['error' => false, 'confirmFriend' => true, 'follow' => false, 'user'=> true];
                        }
                    }else{
                        $dataInsert = [
                            'user_id' => (int)$idUser,
                            'follower' => $this->session->userdata('sessionUser'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        if ($this->follow_model->add($dataInsert)) {
                            $result = ['error' => false, 'confirmFriend' => true, 'follow' => true, 'user'=> true];
                        }
                        else
                        {
                           $result = ['error' => false, 'confirmFriend' => true, 'follow' => false, 'user'=> true];
                        }
                    }
                }
                else
                {
                   $result = ['error' => false, 'confirmFriend' => false, 'user'=> true];
                }
            }
        }
        else{
            $result = ['error' => true, 'confirmFriend' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_cancelfollow_user()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {
            $getAddFriend = $this->friend_model->get('id', ['user_id' => (int)$idUser, 'add_friend_by' => (int)$this->session->userdata('sessionUser'), 'accept' => 1]);
            $getFriend = $this->friend_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$idUser, 'accept' => 1]);
            if (!empty($getAddFriend) || !empty($getFriend)){

                $getFollow = $this->follow_model->get('id', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
                $getIsFollow = $this->follow_model->get('id', ['follower' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);

                if (!empty($getFollow) || !empty($getIsFollow)){
                    if(
                        $this->follow_model->delete(['id' => (int)$getFollow[0]->id]) 
                        && 
                        $this->follow_model->delete(['id' => (int)$getIsFollow[0]->id])
                    )
                    {
                        if (!empty($getAddFriend)){
                            $this->friend_model->delete(['id' => (int)$getAddFriend[0]->id]);
                            $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$idUser.'&user_id_add='.(int)$this->session->userdata('sessionUser'));
                        }
                        else{
                            $this->friend_model->delete(['id' => (int)$getFriend[0]->id]);
                            $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$this->session->userdata('sessionUser').'&user_id_add='.(int)$idUser);
                        }
                        $result = ['error' => false, 'cancelFriend' => true, 'user'=> true];
                    }
                }
            }
        }
        else{
            $result = ['error' => true, 'cancelFriend' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    //Xóa yêu cầu
    public function ajax_deletefollow_user()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {
            $getFriend = $this->friend_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$idUser]);
            if (!empty($getFriend)){

                // $getIsFollow = $this->follow_model->get('id', ['follower' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);

                // if (!empty($getIsFollow)){
                    // if($this->follow_model->delete(['id' => (int)$getIsFollow[0]->id]))
                    // {
                    if($this->friend_model->delete(['id' => (int)$getFriend[0]->id])){
                        $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$this->session->userdata('sessionUser').'&user_id_add='.(int)$idUser);
                        $result = ['error' => false, 'deleteFollow' => true, 'user'=> true];
                    }
                    // }
                // }
            }
        }
        else{
            $result = ['error' => true, 'deleteFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    //Xóa lời mời
    public function ajax_removefollow_user()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {

            $getaddFriend = $this->friend_model->get('id', ['user_id' => (int)$idUser, 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getaddFriend)){
                $getFollow = $this->follow_model->get('id', ['follower' => (int)$this->session->userdata('sessionUser'), 'user_id' => (int)$idUser]);
                if (!empty($getFollow)){
                    if($this->follow_model->delete(['id' => (int)$getFollow[0]->id]))
                    {
                        if($this->friend_model->delete(['id' => (int)$getaddFriend[0]->id])){
                            $this->callAPI('GET', API_DELETE_USER.'?add_friend_by='.(int)$this->session->userdata('sessionUser').'&user_id='.(int)$idUser);
                            $result = ['error' => false, 'deleteFollow' => true, 'user'=> true];
                        }
                    }
                }
            }
        }
        else{
            $result = ['error' => true, 'deleteFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_follow_user_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        $this->load->model('friend_model');
        if($this->session->userdata('sessionUser'))
        {
            $add = false;
            $getFollow = $this->friend_model->get('*', ['user_id' => (int)$idUser, 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->friend_model->delete(['id' => (int)$getFollow[0]->id])){
                    $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$idUser.'&user_id_add='.(int)$this->session->userdata('sessionUser'));
                    $add = true;
                }else{
                    $add = false;
                }
            }else{
                $getIsFollow = $this->friend_model->get('*', ['add_friend_by' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getIsFollow))
                {
                    if($this->friend_model->delete(['id' => (int)$getIsFollow[0]->id])){
                        $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$this->session->userdata('sessionUser').'&user_id_add='.(int)$idUser);
                        $add = true;
                    }else{
                        $add = false;
                    }
                }else{
                    $add = true;
                }
            }
            if($add == true){
                $dataInsert = [
                    'user_id' => (int)$idUser,
                    'add_friend_by' => $this->session->userdata('sessionUser')
                ];
                if ($this->friend_model->add($dataInsert)) {
                    $this->callAPI('GET', API_UPDATE_USER.'?user_id='.(int)$idUser.'&user_id_add='.(int)$this->session->userdata('sessionUser'));
                    $dataInsert = [
                        'user_id' => (int)$idUser,
                        'follower' => $this->session->userdata('sessionUser'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($this->follow_model->add($dataInsert)) {
                        $result = ['error' => false, 'addFriend' => true, 'user'=> true];
                    }
                }
            }else{
                $result = ['error' => true, 'addFriend' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'addFriend' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_follow_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {

            $add = true;
            $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_model->update(['hasFollow' => 1],'id = '.(int)$getFollow[0]->id)){
                    $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                }
            }else{
                $dataInsert = [
                        'user_id' => (int)$idUser,
                        'follower' => $this->session->userdata('sessionUser'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($this->follow_model->add($dataInsert)) {
                        $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                    }
                    else
                    {
                       $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                    }
                /*$getIsFollow = $this->follow_model->get('*', ['follower' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getIsFollow))
                {
                    if($this->follow_model->update(['hasFollow' => 1],'id = '.(int)$getIsFollow[0]->id)){
                        $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                    }else{
                        $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                    }
                }else{
                    $dataInsert = [
                        'user_id' => (int)$idUser,
                        'follower' => $this->session->userdata('sessionUser'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    if ($this->follow_model->add($dataInsert)) {
                        $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                    }
                    else
                    {
                       $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                    }
                }*/
            }
        }
        else{
            $result = ['error' => true, 'isFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_cancel_follow_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $add = true;
            $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_model->update(['hasFollow' => 0],'id = '.(int)$getFollow[0]->id)){
                    $result = ['error' => false, 'cancelFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'cancelFollow' => false, 'user'=> true];
                }
            }else{
                $getIsFollow = $this->follow_model->get('*', ['follower' => (int)$idUser, 'user_id' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getIsFollow))
                {
                    if($this->follow_model->update(['hasFollow' => 0],'id = '.(int)$getIsFollow[0]->id)){
                        $result = ['error' => false, 'cancelFollow' => true, 'user'=> true];
                    }else{
                        $result = ['error' => true, 'cancelFollow' => false, 'user'=> true];
                    }
                }
            }
        }
        else{
            $result = ['error' => true, 'cancelFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_priofollow_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $add = true;
            $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_model->update(['priority' => 1],'id = '.(int)$getFollow[0]->id . ' AND hasFollow = 1')){
                    $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                }
            }else{
                $result = ['error' => true, 'isFollow' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'isFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }

    public function ajax_cancel_priofollow_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $add = true;
            $getFollow = $this->follow_model->get('*', ['user_id' => (int)$idUser, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_model->update(['priority' => 0],'id = '.(int)$getFollow[0]->id . ' AND hasFollow = 1')){
                    $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                }
            }else{
                $result = ['error' => true, 'isFollow' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'isFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();
    }

    //Chan
    public function ajax_blockfriend_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $this->load->model('blockuser_model');
            $getBlock = $this->blockuser_model->get('*', ['user_id' => (int)$idUser, 'blocked_by' => (int)$this->session->userdata('sessionUser')]);
            if (empty($getBlock))
            {
                $dataInsert = [
                    'user_id' => $idUser,
                    'blocked_by' => $this->session->userdata('sessionUser')
                ];
                
                if ($this->blockuser_model->add($dataInsert)) {
                    $this->load->model('friend_model');
                    $this->load->model('follow_model');
                    $this->friend_model->delete('','(user_id = '.(int)$idUser.' AND add_friend_by = '.(int)$this->session->userdata('sessionUser').') OR (add_friend_by = '.(int)$idUser.' AND user_id = '.(int)$this->session->userdata('sessionUser').') AND user_id NOT ');
                    $this->follow_model->delete('', '(user_id = '.(int)$idUser.' AND follower = '.(int)$this->session->userdata('sessionUser').') OR (follower = '.(int)$idUser.' AND user_id = '.(int)$this->session->userdata('sessionUser').') AND user_id NOT ');
                    $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$idUser.'&user_id_add='.(int)$this->session->userdata('sessionUser'));
                    $this->callAPI('GET', API_DELETE_USER.'?user_id='.(int)$this->session->userdata('sessionUser').'&user_id_add='.(int)$idUser);
                    $result = ['error' => false, 'isBlock' => true, 'user'=> true];
                }
            }else{
                $result = ['error' => true, 'isBlock' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'isBlock' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();
    }

    public function ajax_cancel_blockfriend_profile()
    {
        $idUser = (int)$this->input->post('id_user');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $this->load->model('blockuser_model');
            $getBlock = $this->blockuser_model->get('*', ['user_id' => (int)$idUser, 'blocked_by' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getBlock))
            {
                if ($this->blockuser_model->delete(['id' => (int)$getBlock[0]->id])) {
                    $result = ['error' => false, 'cancelBlock' => true, 'user'=> true];
                }
            }else{
                $result = ['error' => true, 'cancelBlock' => false, 'user'=> true];
            }
        }
        else{
            $result = ['error' => true, 'cancelBlock' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();
    }

    //Follow shop
    public function ajax_follow_shop()
    {
        $this->load->model('follow_shop_model');
        $sho_id = (int)$this->input->post('sho_id');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {

            $add = true;
            $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_shop_model->update(['hasFollow' => 1],'id = '.(int)$getFollow[0]->id)){
                    $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                }
            }else{
                $dataInsert = [
                    'shop_id' => $sho_id,
                    'follower' => $this->session->userdata('sessionUser'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if ($this->follow_shop_model->add($dataInsert)) {
                    $result = ['error' => false, 'isFollow' => true, 'user'=> true];
                }
                else
                {
                   $result = ['error' => true, 'isFollow' => false, 'user'=> true];
                }
            }
        }
        else{
            $result = ['error' => true, 'isFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();
    }

    public function ajax_cancel_follow_shop()
    {
        $this->load->model('follow_shop_model');
        $sho_id = (int)$this->input->post('sho_id');
        $result = ['error' => true];
        if($this->session->userdata('sessionUser'))
        {
            $add = true;
            $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFollow))
            {
                if($this->follow_shop_model->update(['hasFollow' => 0],'id = '.(int)$getFollow[0]->id)){
                    $result = ['error' => false, 'cancelFollow' => true, 'user'=> true];
                }else{
                    $result = ['error' => true, 'cancelFollow' => false, 'user'=> true];
                }
            }else{
                $getIsFollow = $this->follow_shop_model->get('*', ['follower' => (int)$sho_id, 'shop_id' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getIsFollow))
                {
                    if($this->follow_shop_model->update(['hasFollow' => 0],'id = '.(int)$getIsFollow[0]->id)){
                        $result = ['error' => false, 'cancelFollow' => true, 'user'=> true];
                    }else{
                        $result = ['error' => true, 'cancelFollow' => false, 'user'=> true];
                    }
                }
            }
        }
        else{
            $result = ['error' => true, 'cancelFollow' => false, 'user'=> false];
        }
        echo json_encode($result);
        die();   
    }
}