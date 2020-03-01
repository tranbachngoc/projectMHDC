<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Order extends MY_Controller
{
    private $_config = [];

    function __construct()
    {
        parent::__construct();
        #CHECK SETTINGstatisticlistshopinvite_tree
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        #END CHECK SETTING
        #BEGIN: CHECK LOGIN
        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        #END CHECK LOGIN
        #Load language
        $this->load->library('hash');
        $this->lang->load('home/common');
        $this->lang->load('home/account');
        $this->load->model('user_model');
        $this->load->model('category_model');
        $this->load->model('showcart_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('shop_model');
        $this->load->model('package_user_model');
        $this->load->model('order_model');
        $this->load->model('common_model');
        $this->load->model('af_order_model');
        $this->load->model('product_promotion_model');
        $this->load->model('detail_product_model');
        $this->load->model('user_emp_role_model');
        $this->load->model('product_model');
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;

        
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }

        /*$config = [
            'full_tag_open' => '<nav class="nav-pagination mt30"><ul class="pagination pagination-style">',
            'full_tag_close' => '</ul></nav>',

            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'next_link' => '<i class="fa fa-chevron-right"></i>',

            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'prev_link' => '<i class="fa fa-chevron-left"></i>',

            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="page-item">',
            'num_tag_clos' => '</li>',

            'anchor_class' => 'class="page-link" ',

            'first_link' => false,
            'last_link' => false,
        ];

        $this->_config = $config;

        $data['js'] = '<script type="text/javascript" defer src="'.loadJs(array(
            'home/js/jquery-migrate-1.2.1.js',
            'home/js/bootstrap.min.js',
            'home/js/select2.full.min.js',
            'home/js/general.js',
            'home/js/jAlert-master/jAlert-v3.min.js',
            'home/js/jAlert-master/jAlert-functions.min.js',
            'home/js/bootbox.min.js',
            'home/js/js-azibai-tung.js',
            'home/js/jquery.validate.js',
            ),'asset/home/checkout.min.js').'"></script>';*/
        $this->load->vars($data);
    }

    function index() 
    {

        $data = $this->check_bran([]);

        if (empty($data)) {
            redirect(base_url(), 'location');
            die();
        }

        $this->load->model('master_shop_rule_model');
        $this->load->model('province_model');
        $data['master_rule'] = $this->master_shop_rule_model->fetch("*", "type = 7", "order_by", "ASC");
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
        
        $this->load->view('home/page_business/index', $data);
    }

    public function manager() 
    {
        /*if ($this->check_permisstion($id_user_shop)) 
        {
            $data['user'] = $this->user_model->get('*', "use_id = " . (int) $this->session->userdata('sessionUser'));
            $data['user_shop'] = $this->user_model->get('*', "use_id = " . (int) $id_user_shop);
            
            $this->load->view('home/order/manager', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();$data
        }*/
        $this->load->view('home/order/manager', []);
    }
}

