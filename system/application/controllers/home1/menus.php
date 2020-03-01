<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Menus extends MY_Controller
{
    function __construct()
    {
        parent::__construct();      
        $this->lang->load('home/common');
        $this->load->model('category_model');
        $this->load->model('package_user_model');
        $this->load->model('shop_model');
    }
   
    function index()
    {        
        
        if($this->session->userdata('sessionUser')){
            if( $this->session->userdata('sessionGroup')==15 || $this->session->userdata('sessionGroup')==11 ){
                $userCurent = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
                $sho_user = $userCurent->parent_id;            
            } else {
                $sho_user = $this->session->userdata('sessionUser');
            }
            
            $shop = $this->shop_model->get("*","sho_user = ".$sho_user);            
            if($shop){
                if($shop->domain){
                    $linktoshop = "//".$shop->domain;
                }else{
                    $linktoshop = "//".$shop->sho_link .'.'. domain_site;
                }
                $data['linktoshop'] =  $linktoshop;
                $data['shop'] =  $shop;
                $data['sho_package'] = $this->package_user_model->getCurrentPackage($sho_user);
            }
        
        }
        if ($this->session->userdata('sessionGroup') == 14) {
            $UserID = (int)$this->session->userdata('sessionUser');
            $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
            $u_pa1 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $u_pa->parent_id . " AND use_status = 1");
            if ($u_pa) {
                $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
                if($u_pa1->use_group == StaffStoreUser){
                    $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa1->parent_id);
                }
            }
        }        
        $data['productCategoryRoot'] = $this->category_model->fetch("cat_id,cat_name","cat_status = 1 AND cate_type = 0 AND parent_id = 0");
        
        
        
        $this->load->view('home/menus/defaults',$data);
    }   
   
}
