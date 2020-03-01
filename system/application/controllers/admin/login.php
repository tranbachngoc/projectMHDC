<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller
{
    public $info_public = [];
    

    function __construct()
    {
        parent::__construct();
        #END CHECK LOGIN
        $this->load->model('user_model');
        $this->load->library('Mobile_Detect');
        
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
        }

        $this->load->vars($data);
    }

    //
    public function index() 
    {

        if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
        {

            $data['errorLogin'] = false;
            if($this->session->flashdata('sessionErrorLoginAdmin'))
            {
                $data['errorLogin'] = true;
            }
            
            if($this->input->post('usernameLogin') && trim($this->input->post('usernameLogin')) != '' && $this->input->post('passwordLogin') && trim($this->input->post('passwordLogin')) != '')
            {
                $user = $this->user_model->get("use_id, use_password, use_salt, use_group, use_status, use_username", "use_username = '".$this->filter->injection_html($this->input->post('usernameLogin'))."'");
                
                if(count($user) == 1)
                {
                    $this->load->library('hash');
                    
                    $password = $this->hash->create($this->input->post('passwordLogin'), $user->use_salt, 'md5sha512');
                    
                    if($user->use_password === $password && $user->use_status == 1 && (int)$user->use_group >= 4)
                    {
                        
                        $this->load->model('group_model');
                        $group = $this->group_model->get("gro_permission", "gro_id = ".$user->use_group);
                        $sessionLogin = array(
                                                'sessionUserAdmin'          =>      (int)$user->use_id,
                                                'sessionGroupAdmin'         =>      (int)$user->use_group,
                                                'sessionPermissionAdmin'    =>      $this->filter->injection($group->gro_permission)
                                                );
                        // Lấy token lưu vào session
                        $aDataLogin = array(
                            'username'      => $user->use_username, 
                            'password'      => $this->input->post('passwordLogin'),
                            'deviceToken'   => 6632,
                            'deviceId'      => 12333
                        );
                        
                        $jData = curl_data(link_get_token.'login', $aDataLogin,'','','POST');

                        if($jData != '') {
                            $aData =  json_decode($jData);
                            if(!empty($aData) && $aData->status == 1) {
                                $aData = $aData->data;
                                $this->session->set_userdata('token',$aData->token);
                            }
                        }
                        $this->session->set_userdata($sessionLogin);
                        $this->user_model->update(array('use_lastest_login'=>time()), "use_id = ".(int)$user->use_id);
                        redirect(base_url().'azi-admin/notifications/business-news', 'location');
                    }
                    else
                    {
                        $this->session->set_flashdata('sessionErrorLoginAdmin', 1);
                    }
                }
                else
                {
                    $this->session->set_flashdata('sessionErrorLoginAdmin', 1);
                }
                redirect(base_url().'azi-admin', 'location');
            }
            
            $this->load->view('azi-admin/login/index', $data);
        }
        else 
        {
            redirect(base_url().'azi-admin/notifications/business-news', 'location');
        }
        
    }
}

