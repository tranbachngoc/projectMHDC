<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#****************************************#
# * @Author: hthanhbmt                   #
# * @Email: hthanhbmt@gmail.com          #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Collection extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('collection_model');
        $this->load->model('user_model');
        $this->load->model('shop_model');
    }

    //get collection của user hoặc shop
    public function my_collections()
    {
        if($this->isLogin() && $this->input->is_ajax_request()){
            $shops         = [];
            $group_id      = $this->session->userdata('sessionGroup');
            $user_id       = $this->session->userdata('sessionUser');
            if($this->input->post('is_owner') === 'shop'){
                $shops      = $this->shop_model->get_shop_by_user($user_id, $group_id);
                $shops      = array_to_array_keys($shops, 'sho_id');
                $user_id    = 0;
            }
            $my_collections = $this->collection_model->my_collections($user_id, $shops);
            echo general_group_option_collection($my_collections);
        }
        die();
    }

}

?>