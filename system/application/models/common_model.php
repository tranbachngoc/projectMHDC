<?php
class Common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function getPackageAccount(){
        // Create default 
        $data['sho_star'] = 0;

        $this->load->model('package_user_model');
        $this->load->model('wallet_model');
        $this->load->model('shop_model');

        $sho_package  = $this->package_user_model->getCurrentPackage((int)$this->session->userdata('sessionUser'));
        $shop_star = $this->shop_model->getShopPackage1((int)$this->session->userdata('sessionUser'));

        $data['sho_package']    = $sho_package;
        if(isset($shop_star->limit)) {
            $data['sho_star']       = $shop_star->limit;
        }
        
        $data['wallet_info']    = $this->wallet_model->getSumWallet(array('user_id'=>(int)$this->session->userdata('sessionUser')),1);        
        return $data;
    }

}