<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #

# * @Copyright: 2008 - 2009              #
#****************************************#
class Page_business extends MY_Controller
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

        $config = [
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
            ),'asset/home/checkout.min.js').'"></script>';
        $this->load->vars($data);
    }

    function _exist_username() 
    {
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function _exist_username_use_phone()
    {
        $post_phone_num = trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis'))));
        if (substr($post_phone_num, 0, 1) == 0) 
        {
            $phone_num = substr($post_phone_num, 1);
        } 
        else 
        {
            $phone_num = '0' . $post_phone_num;
        }

        $where = "use_mobile = '" . $post_phone_num . "' OR use_username = '" . $post_phone_num . "'";
        $where .= " OR use_mobile = '" . $phone_num . "' OR use_username = '" . $phone_num . "'";
        $where .= " OR use_mobile = '" . $phone_num . "' OR use_username = '" . $phone_num . "'";
        $where .= " OR use_phone = '" . $post_phone_num . "' OR use_phone = '" . $phone_num . "'";
        


        if (count($this->user_model->get("use_id", $where)) > 0) {
            return false;
        }
        return true;
    }

    function _exist_email()
    {
        if (count($this->user_model->get("use_id", "use_email = '" . trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function _is_phone() 
    {
        if(preg_match('/[^0-9]/i', $phone))
        {
            return false;
        }
        return true;
    }

    function check_bran($data) {
        $curent_user_id = (int) $this->session->userdata('sessionUser');
        $result_data = $data;
        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) 
        {
            $user_id = $curent_user_id;
            $result_data['shop'] = $this->shop_model->get("*", "sho_user = " . $curent_user_id);
        }
        else if ($this->session->userdata('sessionGroup') == StaffStoreUser) 
        {
            $data['parent_invited'] = $curent_user_id;
            // phân quyền nhân viên giang hàng
            $get_parent_id = $this->user_model->get('*', "use_status = 1 AND use_id = " . $curent_user_id);

            if (!empty($get_parent_id->parent_id)) 
            {
                $result_data['shop'] = $this->user_model->get('*', " use_group = 3 AND use_status = 1 AND use_id = " . $get_parent_id->parent_id );
                if (!empty($result_data['shop'])) 
                {
                    $user_id = $result_data['shop']->use_id;
                }
            }
        } 
        
        if ($user_id) 
        {
            // get info 
            $result_data['user'] = $this->user_model->get('*', "use_id = " . $curent_user_id);
            $result_data['active_bran'] = false;

            // check branch
            $result = $this->package_user_model->getPackageCreateBranch($user_id);

            if ($result) 
            {
                $result_data['list_bran'] = $this->user_model->get_list_user("use_id, use_group, use_username, use_fullname, use_slug, avatar, sho_id, sho_name, sho_logo, sho_dir_logo, domain, sho_link", "use_group = 14 AND use_status = 1 AND parent_id = ". $user_id, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
                
                $total_bran = count($result_data['list_bran']);
                $total_limit = 0;
                foreach ($result as $key => $value) {
                    $total_limit += $value->limited;
                }
                //Nếu GH mua gói DV mở CN
                if ($total_bran < $total_limit) 
                {
                    $result_data['active_bran'] = true;
                } 
            }
        } else {
           $result_data = []; 
        }
        return $result_data;
    }

    function check_permisstion($id_user_shop, $is_shop = false) 
    {
        $curent_user_id = (int) $this->session->userdata('sessionUser');
        $get_shop = $this->user_model->get('*', "use_status = 1 AND use_id = " . (int) $id_user_shop);

        if ($is_shop && $get_shop->use_group != 3) 
        {
            return false;
        }
        
        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) 
        {
            if ($id_user_shop == $curent_user_id) 
            {
                return true;
            } 
            else 
            {
                $get_branch = $this->user_model->get('*', "use_group = 14 AND use_status = 1 AND parent_id = " . $curent_user_id . " AND use_id = " . $id_user_shop );
                if (!empty($get_branch)) 
                {
                    return true;
                }
            }
           
        }
        else if ($this->session->userdata('sessionGroup') == BranchUser) 
        {
            if ($id_user_shop == $curent_user_id) 
            {
                return true;
            }
            return false; 
        }
        else if ($this->session->userdata('sessionGroup') == StaffStoreUser) 
        {
            
            $get_parent_id = $this->user_model->get('*', "use_status = 1 AND use_id = " . $curent_user_id);

            if (!empty($get_parent_id->parent_id) && $get_parent_id->parent_id == $id_user_shop) 
            {
                return true;
            }

            $check_parent = $this->user_model->get('*', "use_status = 1 AND use_id = " . $get_parent_id->parent_id);

            if (!empty($check_parent) && $check_parent->use_group == AffiliateStoreUser) 
            {
                $get_branch = $this->user_model->get('*', "use_group = 14 AND use_status = 1 AND parent_id = " . $get_parent_id->parent_id . " AND use_id = " . $id_user_shop );
                if (!empty($get_branch)) 
                {
                    return true;
                }
            } 

        } 
        return false;
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


    function add_branch() {
        $msg_result = array(
            'error_validate' => [],
            'error_system' => true
        );

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username_regis', 'Tài khoản', 'trim|required|min_length[6]|max_length[35]|callback__exist_username');
        // $this->form_validation->set_rules('email_regis', 'Email', 'trim|required|valid_email|callback__exist_email');
        $this->form_validation->set_rules('password_regis', 'Mật khẩu', 'trim|required|min_length[6]|max_length[35]');
        $this->form_validation->set_rules('mobile_regis', 'Số điện thoại', 'trim|callback__is_phone|callback__exist_username_use_phone');
        $this->form_validation->set_rules('sho_name_regis', 'Tên chi nhánh', 'trim|required');
        $this->form_validation->set_rules('fullname_regis', 'Họ và tên', 'trim|required');

        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
        $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
        $this->form_validation->set_message('_exist_username', '%s đã tồn tại!');
        // $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
        // $this->form_validation->set_message('_exist_email', '%s đã tồn tại!');
        $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
        $this->form_validation->set_message('_exist_username_use_phone', '%s đã tồn tại!');

        if ($this->form_validation->run() != false)
        {
            $data_bran = $this->check_bran([]);
            if (!empty($data_bran) && $data_bran['active_bran'] == true) 
            {    
                $parentID = $data_bran['user']->use_id;
                $group = 14;
                $active = 1;
                $parent_shop = $data_bran['user']->use_id;
                $key = $this->hash->create($this->input->post('username_regis'), $this->input->post('email_regis'), 'sha256md5');
                $salt = $this->hash->key(8);
                
                $dataRegister = array(
                        'use_username' => trim(strtolower($this->input->post('username_regis'))),
                        'use_password' => $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                        'use_salt' => $salt,
                        'use_email' => trim(strtolower($this->input->post('email_regis'))),
                        'use_fullname' => trim($this->input->post('fullname_regis')),
                        'use_birthday' => NULL,
                        'use_sex' => 0,
                        'use_address' => '',
                        'use_province' => 0,
                        'user_district' => '',
                        'use_phone' => '',
                        'use_mobile' => trim($this->input->post('mobile_regis')),
                        'id_card' => 0,
                        'tax_type' => 0,
                        'use_group' => $group,
                        'use_status' => $active,
                        'use_regisdate' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                        'use_enddate' => 0,
                        'use_key' => $key,
                        'active_code' => '',
                        'parent_id' => $parentID,
                        'parent_shop' => $parentID,
                        'parent_invited' => !empty($data_bran['parent_invited']) ? $data_bran['parent_invited'] : 0,
                );

                if ($this->user_model->add($dataRegister)) 
                {
                    $cur_shop_id = (int)mysql_insert_id();
                    $dataShopRegister = array(
                        'sho_name' => trim($this->input->post('sho_name_regis')),
                        'sho_descr' => $data_bran['shop']->sho_descr,
                        'sho_address' => '',
                        'sho_link' => trim(strtolower($this->input->post('username_regis'))),
                        'sho_logo' => 'default-logo.png',
                        'sho_dir_logo' => 'defaults',
                        'sho_banner' => 'default-banner.jpg',
                        'sho_dir_banner' => 'defaults',
                        'sho_province' => NULL,
                        'sho_district' => NULL,
                        'sho_category' => $data_bran['shop']->sho_category,
                        'sho_phone' => trim($this->input->post('mobile_regis')),
                        'sho_mobile' => trim($this->input->post('mobile_regis')),
                        'sho_user' => $cur_shop_id,
                        'sho_begindate' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                        'sho_enddate' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                        'sho_view' => 1,
                        'sho_status' => 1,
                        'sho_style' => 'default',
                        'sho_email' => trim(strtolower($this->input->post('email_regis'))),
                        'shop_type' => 2
                    );

                    if ($this->shop_model->add($dataShopRegister)) 
                    {
                        $msg_result['error_system'] = false;
                        $msg_result['data_new_branch'] = ['id_branch' =>$cur_shop_id, 'name_branch' => trim($this->input->post('sho_name_regis'))];
                    }
                }
            } 
        }
        else
        {    
            $msg_result['error_validate'] = $this->form_validation->error_array();
        }

        echo json_encode($msg_result); 
        exit();
    }


    function config_branch($id_branch) 
    {
        $get_branch = $this->user_model->get('*', "use_group = 14 AND use_id = " . $id_branch );

        if (empty($get_branch)) 
        {
            echo json_encode(['error' => true, 'msm_error' => 'Chi nhánh không tồn tại!']);
            exit();
        }

        $curent_user_id = (int) $this->session->userdata('sessionUser');
        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) 
        {
            $user_id = $curent_user_id;
        }
        else if ($this->session->userdata('sessionGroup') == StaffStoreUser) 
        {
            $get_parent_id = $this->user_model->get('*', "use_status = 1 AND use_id = " . $curent_user_id);
            if (!empty($get_parent_id->parent_id)) 
            {
                $result_data = $this->user_model->get('*', " use_group = 3 AND use_status = 1 AND use_id = " . $get_parent_id->parent_id );
                if (!empty($result_data)) 
                {
                    $user_id = $result_data->use_id;
                }
            }
        } 
        
        if ($user_id == $get_branch->parent_id) 
        {
            $this->load->model('branch_model');
            $shop_rule = $this->branch_model->getConfig("*", "bran_id = " . (int) $id_branch);

            $this->load->model('shop_model');
            $shop = $this->shop_model->get("*", "sho_user = " . (int) $user_id . " AND sho_status = 1");

            $selectedrule = implode(",", $this->input->post('shop_rule'));
            if (count($shop_rule) != 1) 
            {
                $dataAdd = array(
                    'shop_id' => $shop->sho_id,
                    'bran_id' => (int) $id_branch,
                    'parent_id' => (int) $user_id,
                    'config_rule' => $selectedrule,
                    'createdate' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                );
                $this->branch_model->addConfig($dataAdd);
            }
            else 
            {                       
                $dataUpdate = array('config_rule' => $selectedrule);
                $this->branch_model->updateConfig($dataUpdate, "bran_id = " . (int)$id_branch);
            }

            if (!in_array(51,$this->input->post('shop_rule'))) 
            {
                $dataUpdate = array(
                    'sho_kho_address' => trim($this->input->post('address_kho_shop')),
                    'sho_kho_province' => (int) $this->input->post('province_kho_shop'),
                    'sho_kho_district' => $this->input->post('district_kho_shop'),
                );
                $this->shop_model->update($dataUpdate, "sho_user = " . (int) $id_branch);
            }

            if (!in_array(50,$this->input->post('shop_rule'))) 
            {
                $dataUpdate = array(
                    "bank_name" => trim($this->input->post("namebank_regis")),
                    "bank_add" => trim($this->input->post("addbank_regis")),
                    "account_name" => trim($this->input->post("accountname_regis")),
                    "num_account" => trim($this->input->post("accountnum_regis"))
                );
                $this->user_model->update($dataUpdate, "use_id = " . $id_branch);
            }
            echo json_encode(['error' => false, 'msm_error' => 'Cấu hình chi nhánh thành công!']);
            exit();
        }
        else
        {
            echo json_encode(['error' => true, 'msm_error' => 'Bạn không có quyền!']);
            exit();
        }
    }

    public function manager($id_user_shop) 
    {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $data['user'] = $this->user_model->get('*', "use_id = " . (int) $this->session->userdata('sessionUser'));
            $data['user_shop'] = $this->user_model->get('*', "use_id = " . (int) $id_user_shop);

            $aListPackgeU = $this->check_buy_package(43, $id_user_shop, 1);
            if(!empty($aListPackgeU)) {
                $data['is_systema'] = 1;
            }
            // INCLUDE API
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $temp1 = Api_affiliate::check_list_config_service($id_user_shop);

            $data = array_merge($temp1, $data);

            $this->load->view('home/page_business/manager', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function config_service($type, $id_user_shop)
    {
        if ($this->check_permisstion($id_user_shop) && $id_user_shop > 0) {
            $this->get_data_user_shop($id_user_shop);
            // INCLUDE API
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $temp1 = Api_affiliate::check_list_config_service($id_user_shop);
            switch ($type) {
                case 'transport':
                    $temp2 = Api_affiliate::get_user_config_ghn($id_user_shop);
                    $data = array_merge($temp1, $temp2);
                    $this->load->view('home/page_business/page_config_ghn', $data, FALSE);
                    break;
                case 'payment_nl':
                    $temp2 = Api_affiliate::get_user_config_nganluong($id_user_shop);
                    $data = array_merge($temp1, $temp2);
                    $this->load->view('home/page_business/page_config_payment_nl', $data, FALSE);
                    break;
                default:
                    redirect(base_url(), 'location');
                    die();
                    break;
            }
        } else {
            redirect(base_url(), 'location');
            die();
        }
    }

    
    public function news($id_user_shop) 
    {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $user_group = $this->user_model->get('use_group', "use_id = " . (int) $id_user_shop)->use_group;
            $type = $user_group > 0 ? ($user_group == AffiliateStoreUser ? "shop" : ($user_group == BranchUser ? "branch" : "")) : "";

            $user_id = $id_user_shop;
            $title = isset($_REQUEST['news_title']) ? $_REQUEST['news_title'] : '';
            $cate = isset($_REQUEST['news_cate']) ? $_REQUEST['news_cate'] : '';

            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::branch_get_list_content($user_id, $type, $page, $title, $cate);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // dd($data);die;
            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/news', $data);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function send_news_branch() {
        $id_user_shop = $this->input->post('user_shop');
        $list_post_branch = $this->input->post('list_bran');
        $post_not_id = $this->input->post('not_id');
        $result = ['error' => true, 'sms' => 'Chia sẻ bài viết cho chi nhánh thất bại!'];
        if ($this->check_permisstion($id_user_shop) && !empty($post_not_id)) 
        {
            $list_branch = $this->user_model->get_list_user("use_id, use_group, sho_id", "use_group = 14 AND use_status = 1 AND parent_id = ". (int) $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
            if (!empty($list_branch)) 
            {
                $a_branch = [];
                foreach ($list_branch as $key => $value) 
                {
                   $a_branch[] = $value->use_id;
                }

                $this->db->delete('tbtt_send_news', array('not_id' => (int) $post_not_id)); 

                if (!empty($list_post_branch)) 
                {
                    foreach ($list_post_branch as $k => $v) 
                    {
                        if (in_array($v, $a_branch)) 
                        {
                            $data = array(                
                                    'not_id' => (int) $post_not_id,
                                    'user_shop_id' => $v,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                            );
                            $this->db->insert("tbtt_send_news", $data); 
                        }
                    }
                }
                $result = ['error' => false, 'sms' => 'Chia sẻ bài viết cho chi nhánh thành công!'];
            }
        }
        echo json_encode($result);
        exit();
    }


    function get_cate_shop($id_user_shop, $cate_type = 0) {
        // get list category user
        $category_user = [];

        if (is_array($id_user_shop) && !empty($id_user_shop)) {
            $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE pro_status = 1 and pro_user IN ('. implode(',', $id_user_shop) .') AND pro_type ='. $cate_type; 
        } else {
           $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE pro_status = 1 and pro_user = '. $id_user_shop .' AND pro_type ='. $cate_type;  
        }

        
        $result = $this->db->query($cat_pro_aff);
        $arrylist = $result->result();

        if (count($arrylist) > 0) 
        {
          $catid = array();
          foreach ($arrylist as $k => $item) 
          {
              if ($item->pro_category > 0) 
              {
                  array_push($catid, $item->pro_category);
              }
          }
          $catarr = implode(',', $catid);
          if ($catarr != '') 
          {
              $sql = 'SELECT cat_id, cat_name, cate_type FROM tbtt_category
                      WHERE cat_id IN ('. $catarr .') ORDER BY cat_name ASC ';
              $query = $this->db->query($sql);
              $category_user = $query->result();
          }
        }
        return $category_user;
    }

    public function products($id_user_shop, $page = 1) 
    {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $type_pro = 0;
            $data['user'] = $this->get_profile_user($id_user_shop);
            $type =  $data['user']['use_group'] == 3 ? "shop" : "branch";
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = array_merge($data, Api_affiliate::get_products_post_by_self($id_user_shop, $type_pro, $type = "shop", $page));
            $data['type_pro'] = $type_pro;
            $data['type'] = $type;

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/products', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function coupons($id_user_shop, $page = 1)
    {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $type_pro = 2;
            $data['user'] = $this->get_profile_user($id_user_shop);
            $type =  $data['user']['use_group'] == 3 ? "shop" : "branch";
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = array_merge($data, Api_affiliate::get_products_post_by_self($id_user_shop, $type_pro, $type = "shop", $page));
            $data['type_pro'] = $type_pro;
            $data['type'] = $type;

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/products', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function send_product_branch() {
        $id_user_shop = $this->input->post('user_shop');
        $list_post_branch = $this->input->post('list_bran');
        $post_pro_id = (int) $this->input->post('pro_id');
        $result = ['error' => true, 'sms' => 'Chia sẻ sản phẩm cho chi nhánh thất bại!'];

        $check_pro = $this->product_model->get('*', 'pro_id = '. $post_pro_id .' AND pro_user = "'. (int) $id_user_shop .'"');

        if ($this->check_permisstion($id_user_shop) && !empty($post_pro_id) && !empty($list_post_branch) && !empty($check_pro)) 
        {
            $list_branch = $this->user_model->get_list_user("use_id, use_group, sho_id", "use_group = 14 AND use_status = 1 AND parent_id = ". (int) $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
            if (!empty($list_branch)) 
            {
                $a_branch = [];
                foreach ($list_branch as $key => $value) 
                {
                   $a_branch[] = $value->use_id;
                }

                foreach ($list_post_branch as $k_post_branch => $v_post_branch) 
                {
                    $pro_is_branch = $this->db->query("SELECT pro_user FROM tbtt_product WHERE pro_of_shop = $post_pro_id AND pro_user = ?", (int) $v_post_branch)->row();

                    if (empty($pro_is_branch) && in_array($v_post_branch, $a_branch)) 
                    {
                        $dataPost = array(
                            'pro_name' => $check_pro->pro_name,
                            'pro_sku' => $check_pro->pro_sku,
                            'pro_descr' => $check_pro->pro_descr,
                            'pro_keyword' => $check_pro->pro_keyword,
                            'pro_cost' => $check_pro->pro_cost,
                            'pro_currency' => $check_pro->pro_currency,
                            'pro_hondle' => $check_pro->pro_hondle,
                            'pro_province' => $check_pro->pro_province,
                            'pro_category' => $check_pro->pro_category,
                            'pro_begindate' =>$check_pro->pro_begindate,
                            'pro_enddate' => $check_pro->pro_enddate,
                            'pro_detail' => $check_pro->pro_detail,
                            'pro_image' => $check_pro->pro_image,
                            'pro_dir' => $check_pro->pro_dir,
                            'pro_user' => (int) $v_post_branch, //ID chi nhánh
                            'pro_post_by' => 'web', 
                            'pro_user_up' => $check_pro->pro_user_up,
                            'pro_poster' => $check_pro->pro_poster,
                            'pro_address' => $check_pro->pro_address,
                            'pro_phone' => $check_pro->pro_phone,
                            'pro_mobile' => $check_pro->pro_mobile,
                            'pro_email' => $check_pro->pro_email,
                            'pro_yahoo' => $check_pro->pro_yahoo,
                            'pro_skype' => $check_pro->pro_skype,
                            'pro_status' => $check_pro->pro_status,
                            'pro_view' => 0,
                            'pro_buy' => 0,
                            'pro_comment' => 0, 
                            'pro_vote_cost' => 0, 
                            'pro_vote_quanlity' => 0, 
                            'pro_vote_model' => 0, 
                            'pro_vote_service' => 0, 
                            'pro_vote_total' => 0, 
                            'pro_vote' => 0, 
                            'pro_reliable' => $check_pro->pro_reliable,
                            'pro_saleoff' => $check_pro->pro_saleoff,
                            'pro_saleoff_value' => $check_pro->pro_saleoff_value,
                            'pro_type_saleoff' => $check_pro->pro_type_saleoff,
                            'begin_date_sale' => $check_pro->begin_date_sale,
                            'end_date_sale' =>$check_pro->end_date_sale,
                            'pro_hot' => $check_pro->pro_hot,
                            'is_product_affiliate' => $check_pro->is_product_affiliate,
                            'af_amt' => $check_pro->af_amt,
                            'af_rate' => $check_pro->af_rate,
                            'af_dc_amt' => $check_pro->af_dc_amt,
                            'af_dc_rate' => $check_pro->af_dc_rate,
                            'pro_show' => $check_pro->pro_show,
                            'pro_manufacturer_id' => $check_pro->pro_manufacturer_id,
                            'pro_manufacturer' => $check_pro->pro_manufacturer, 
                            'pro_instock' => $check_pro->pro_instock,
                            'pro_unit' => $check_pro->pro_unit,
                            'pro_weight' => $check_pro->pro_weight,
                            'pro_length' => 0, 
                            'pro_width' => 0, 
                            'pro_height' =>  0, 
                            'pro_minsale' => $check_pro->pro_minsale, 
                            'pro_vat' => $check_pro->pro_vat, 
                            'pro_quality' => $check_pro->pro_quality, 
                            'pro_made_from' => $check_pro->pro_made_from, 
                            'pro_warranty_period' => $check_pro->pro_warranty_period, 
                            'pro_video' => $check_pro->pro_video, 
                            'created_date' => date("Y-m-d"), 
                            'pro_type' => $check_pro->pro_type, 
                            'pro_brand' => $check_pro->pro_brand, 
                            'pro_protection'    => $check_pro->pro_protection, 
                            'pro_specification' => $check_pro->pro_specification, 
                            'pro_attach'        => $check_pro->pro_attach, 
                            'pro_made_in'       => $check_pro->pro_made_in, 
                            'pro_of_shop' => $check_pro->pro_id // id product clone
                        );

                        if ($id = $this->product_model->add($dataPost)) 
                        {
                            $pro_id = (int) mysql_insert_id();
                            
                            $this->load->model('cate_galleries_model');
                            $this->load->model('galleries_model');
                            $this->load->model('product_promotion_model');
                            $this->load->model('detail_product_model');
                            

                            // add category galleries
                            $cate_galleries = $this->cate_galleries_model->get('*', 'pro_id = '. $post_pro_id);

                            if ($cate_galleries) {
                                foreach ($cate_galleries as $k_cate_gallery => $v_cate_gallery) 
                                {
                                    $dataInsert = array(
                                        'user_id' => (int) $v_post_branch,
                                        'pro_id'  => $pro_id,
                                        'name'    => $v_cate_gallery->content
                                    );
                                    $this->cate_galleries_model->add($dataInsert);
                                }
                            }

                            // add galleries
                            $galleries =$this->galleries_model->get('*', 'pro_id = '. $post_pro_id);
                            if ($galleries) {
                                foreach ($galleries as $k_gallery => $v_gallery) 
                                {
                                    $arr_promo_pro = array(
                                        'gallery_id' => $v_gallery->gallery_id, 
                                        'pro_id' => $pro_id, 
                                        'caption' => $v_gallery->gallery_id->caption,
                                    );
                                    $this->product_promotion_model->addPromo($arr_promo_pro);
                                }
                            }

                            // Add promotion                       
                            $get_promo_pro = $this->product_promotion_model->fetch('*', 'pro_id = '. $post_pro_id);
                            if ($get_promo_pro) {
                                foreach ($get_promo_pro as $k_promo => $v_promo) 
                                {
                                    $arr_promo_pro = array(
                                        'pro_id' => $pro_id,
                                        'limit_from' => $v_promo->limit_from,
                                        'limit_to' => $v_promo->limit_to,
                                        'limit_type' => $v_promo->limit_type,
                                        'dc_rate' => $v_promo->dc_rate,
                                        'dc_amt' => $v_promo->dc_amt
                                    );
                                    $this->product_promotion_model->addPromo($arr_promo_pro);
                                }
                            }

                            // add detail product                  
                            $get_detail_pro = $this->detail_product_model->fetch('*', 'dp_pro_id = '. $post_pro_id);
                            if ($get_detail_pro) 
                            {
                                foreach ($get_detail_pro as $k_dp => $v_dp) 
                                {
                                    $arr_detail_pro = array(
                                        'dp_pro_id' => $pro_id,
                                        'dp_images' => $v_dp->dp_images,
                                        'dp_size' => $v_dp->dp_size,
                                        'dp_color' => $v_dp->dp_color,
                                        'dp_material' => $v_dp->dp_material,
                                        'dp_cost' => $v_dp->dp_cost,
                                        'dp_instock' => $v_dp->dp_instock,
                                        'dp_createdate' => date('Y-m-d')
                                    );
                                    $this->detail_product_model->add($arr_detail_pro);
                                }
                            }

                            $result = ['error' => false, 'sms' => 'Chia sẻ sản phẩm cho chi nhánh thành công!'];
                        }
                    }
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function choose_product_branch() 
    {
        $id_user_shop = $this->input->post('id_user_shop');
        $pro_type = (int) $this->input->post('pro_type');
        $post_pro_id = (int) $this->input->post('pro_id');
        $result = ['error' => true, 'sms' => 'Lấy sản phẩm thất bại!'];

        $check_pro = $this->product_model->get('*', 'pro_id = '. $post_pro_id .' AND pro_type =' . $pro_type);

        if ($this->check_permisstion($id_user_shop, true) && !empty($check_pro)) 
        {

            $list_branch = $this->user_model->get_list_user("use_id, use_group, sho_id", "use_group = 14 AND use_status = 1 AND parent_id = ". (int) $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');

            if (!empty($list_branch)) 
            {

                $a_branch = [];
                foreach ($list_branch as $key => $value) 
                {
                   $a_branch[] = $value->use_id;
                }

                $check_choose = $this->db->query("SELECT pro_user FROM tbtt_product WHERE pro_of_shop = $post_pro_id AND pro_user = ?", (int) $id_user_shop)->row();
                
                if (empty($check_choose) && in_array($check_pro->pro_user, $a_branch)) 
                {
                    $dataPost = array(
                        'pro_name' => $check_pro->pro_name,
                        'pro_sku' => $check_pro->pro_sku,
                        'pro_descr' => $check_pro->pro_descr,
                        'pro_keyword' => $check_pro->pro_keyword,
                        'pro_cost' => $check_pro->pro_cost,
                        'pro_currency' => $check_pro->pro_currency,
                        'pro_hondle' => $check_pro->pro_hondle,
                        'pro_province' => $check_pro->pro_province,
                        'pro_category' => $check_pro->pro_category,
                        'pro_begindate' =>$check_pro->pro_begindate,
                        'pro_enddate' => $check_pro->pro_enddate,
                        'pro_detail' => $check_pro->pro_detail,
                        'pro_image' => $check_pro->pro_image,
                        'pro_dir' => $check_pro->pro_dir,
                        'pro_user' => (int) $id_user_shop, //ID chi nhánh
                        'pro_post_by' => 'web', 
                        'pro_user_up' => $check_pro->pro_user_up,
                        'pro_poster' => $check_pro->pro_poster,
                        'pro_address' => $check_pro->pro_address,
                        'pro_phone' => $check_pro->pro_phone,
                        'pro_mobile' => $check_pro->pro_mobile,
                        'pro_email' => $check_pro->pro_email,
                        'pro_yahoo' => $check_pro->pro_yahoo,
                        'pro_skype' => $check_pro->pro_skype,
                        'pro_status' => $check_pro->pro_status,
                        'pro_view' => 0,
                        'pro_buy' => 0,
                        'pro_comment' => 0, 
                        'pro_vote_cost' => 0, 
                        'pro_vote_quanlity' => 0, 
                        'pro_vote_model' => 0, 
                        'pro_vote_service' => 0, 
                        'pro_vote_total' => 0, 
                        'pro_vote' => 0, 
                        'pro_reliable' => $check_pro->pro_reliable,
                        'pro_saleoff' => $check_pro->pro_saleoff,
                        'pro_saleoff_value' => $check_pro->pro_saleoff_value,
                        'pro_type_saleoff' => $check_pro->pro_type_saleoff,
                        'begin_date_sale' => $check_pro->begin_date_sale,
                        'end_date_sale' =>$check_pro->end_date_sale,
                        'pro_hot' => $check_pro->pro_hot,
                        'is_product_affiliate' => $check_pro->is_product_affiliate,
                        'af_amt' => $check_pro->af_amt,
                        'af_rate' => $check_pro->af_rate,
                        'af_dc_amt' => $check_pro->af_dc_amt,
                        'af_dc_rate' => $check_pro->af_dc_rate,
                        'pro_show' => $check_pro->pro_show,
                        'pro_manufacturer_id' => $check_pro->pro_manufacturer_id,
                        'pro_manufacturer' => $check_pro->pro_manufacturer, 
                        'pro_instock' => $check_pro->pro_instock,
                        'pro_unit' => $check_pro->pro_unit,
                        'pro_weight' => $check_pro->pro_weight,
                        'pro_length' => 0, 
                        'pro_width' => 0, 
                        'pro_height' =>  0, 
                        'pro_minsale' => $check_pro->pro_minsale, 
                        'pro_vat' => $check_pro->pro_vat, 
                        'pro_quality' => $check_pro->pro_quality, 
                        'pro_made_from' => $check_pro->pro_made_from, 
                        'pro_warranty_period' => $check_pro->pro_warranty_period, 
                        'pro_video' => $check_pro->pro_video, 
                        'created_date' => date("Y-m-d"), 
                        'pro_type' => $check_pro->pro_type, 
                        'pro_brand' => $check_pro->pro_brand, 
                        'pro_protection'    => $check_pro->pro_protection, 
                        'pro_specification' => $check_pro->pro_specification, 
                        'pro_attach'        => $check_pro->pro_attach, 
                        'pro_made_in'       => $check_pro->pro_made_in, 
                        'pro_of_shop' => $check_pro->pro_id // id product clone
                    );

                    if ($id = $this->product_model->add($dataPost)) 
                    {
                        $pro_id = (int) mysql_insert_id();
                        
                        $this->load->model('cate_galleries_model');
                        $this->load->model('galleries_model');
                        $this->load->model('product_promotion_model');
                        $this->load->model('detail_product_model');
                        

                        // add category galleries
                        $cate_galleries = $this->cate_galleries_model->get('*', 'pro_id = '. $post_pro_id);

                        if ($cate_galleries) {
                            foreach ($cate_galleries as $k_cate_gallery => $v_cate_gallery) 
                            {
                                $dataInsert = array(
                                    'user_id' => (int) $id_user_shop,
                                    'pro_id'  => $pro_id,
                                    'name'    => $v_cate_gallery->content
                                );
                                $this->cate_galleries_model->add($dataInsert);
                            }
                        }

                        // add galleries
                        $galleries =$this->galleries_model->get('*', 'pro_id = '. $post_pro_id);
                        if ($galleries) {
                            foreach ($galleries as $k_gallery => $v_gallery) 
                            {
                                $arr_promo_pro = array(
                                    'gallery_id' => $v_gallery->gallery_id, 
                                    'pro_id' => $pro_id, 
                                    'caption' => $v_gallery->gallery_id->caption,
                                );
                                $this->product_promotion_model->addPromo($arr_promo_pro);
                            }
                        }

                        // Add promotion                       
                        $get_promo_pro = $this->product_promotion_model->fetch('*', 'pro_id = '. $post_pro_id);
                        if ($get_promo_pro) {
                            foreach ($get_promo_pro as $k_promo => $v_promo) 
                            {
                                $arr_promo_pro = array(
                                    'pro_id' => $pro_id,
                                    'limit_from' => $v_promo->limit_from,
                                    'limit_to' => $v_promo->limit_to,
                                    'limit_type' => $v_promo->limit_type,
                                    'dc_rate' => $v_promo->dc_rate,
                                    'dc_amt' => $v_promo->dc_amt
                                );
                                $this->product_promotion_model->addPromo($arr_promo_pro);
                            }
                        }

                        // add detail product                  
                        $get_detail_pro = $this->detail_product_model->fetch('*', 'dp_pro_id = '. $post_pro_id);
                        if ($get_detail_pro) 
                        {
                            foreach ($get_detail_pro as $k_dp => $v_dp) 
                            {
                                $arr_detail_pro = array(
                                    'dp_pro_id' => $pro_id,
                                    'dp_images' => $v_dp->dp_images,
                                    'dp_size' => $v_dp->dp_size,
                                    'dp_color' => $v_dp->dp_color,
                                    'dp_material' => $v_dp->dp_material,
                                    'dp_cost' => $v_dp->dp_cost,
                                    'dp_instock' => $v_dp->dp_instock,
                                    'dp_createdate' => date('Y-m-d')
                                );
                                $this->detail_product_model->add($arr_detail_pro);
                            }
                        }
                        $result = ['error' => false, 'sms' => 'Lấy sản phẩm thành công!'];
                    }
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function choose_content_branch() {
        $id_user_shop = $this->input->post('id_user_shop');
        $not_id = (int) $this->input->post('not_id');
        $result = ['error' => true, 'sms' => 'Lấy tin tức thất bại!'];

        $content = $this->content_model->get('*', 'not_id =' . $not_id );
        if ($this->check_permisstion($id_user_shop, true) && !empty($content)) 
        {
            $list_branch = $this->user_model->get_list_user("use_id, use_group, sho_id", "use_group = 14 AND use_status = 1 AND parent_id = ". (int) $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');

            if (!empty($list_branch)) 
            {
                $a_branch = [];
                foreach ($list_branch as $key => $value) 
                {
                   $a_branch[] = $value->sho_id;
                }

                if (in_array($content->sho_id, $a_branch)) 
                {
                    $data = array(                
                            'not_id' => (int) $content->not_id,
                            'user_shop_id' => $id_user_shop,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->db->insert("tbtt_send_news", $data)) {
                        $result = ['error' => false, 'sms' => 'Lấy tin tức thành công!'];
                    }
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function pro_status() {

        $pro_id = (int) $this->input->post('pro_id');
        $pro_status = (int) $this->input->post('pro_status');
        $pro_type = (int) $this->input->post('pro_type');
        $id_user_shop = (int) $this->input->post('id_user_shop');
        $result = ['error' => true, 'sms' => 'Thay đổi trạng thái thất bại!'];
        if ($this->check_permisstion($id_user_shop)) 
        {
            $check_pro = $this->product_model->get('pro_id', 'pro_id = '. $pro_id .' AND pro_user = "'. (int) $id_user_shop .'" AND pro_type =' . $pro_type);
            if (!empty($check_pro)) 
            {
                if ($this->product_model->update(array('pro_status' => $pro_status), "pro_id = " . $pro_id))
                {
                    $result = ['error' => true, 'sms' => 'Thay đổi trạng thái thành công!'];
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function news_status() {
        $not_id = (int) $this->input->post('not_id');
        $not_status = (int) $this->input->post('not_status');
        $id_user_shop = (int) $this->input->post('id_user_shop');
        $result = ['error' => true, 'sms' => 'Thay đổi trạng thái thất bại!'];
        if ($this->check_permisstion($id_user_shop)) 
        {
            $shop = $this->shop_model->get("*", "sho_user = " . (int) $id_user_shop . " AND sho_status = 1");
            if (!empty($shop)) 
            {   
                $this->load->model('content_model');
                $content = $this->content_model->get('*', 'not_id =' . $not_id .' AND sho_id ='. $shop->sho_id);
                if (!empty($content)) 
                {
                    if ($this->content_model->update(array('not_status' => $not_status), array('not_id' => $not_id)))
                    {
                        $result = ['error' => false, 'sms' => 'Thay đổi trạng thái thành công!'];
                    }
                }
            }
        }
        echo json_encode($result);
        exit();
    }


    public function list_branch($id_user_shop, $page = 1) {
        
        if ($this->check_permisstion($id_user_shop)) 
        {

            $data['list_bran'] = $this->user_model->get_list_user("use_id, use_group, use_username, use_fullname, use_slug, avatar, sho_id, sho_name, sho_logo, sho_email, sho_mobile, sho_dir_logo, parent_invited, domain, sho_link", "use_group = 14 AND use_status = 1 AND parent_id = ". $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');

            if (!empty($data['list_bran'])) 
            {
                foreach ($data['list_bran'] as $key => $value) 
                {
                    $data['list_bran'][$key]->total_ctv = count($this->user_model->get_list_user("use_id", "use_status = 1 AND parent_id = ". $value->use_id));

                    if ($value->parent_invited != 0) {
                        $parent_invited = $this->user_model->get('*', "use_id = " . (int) $value->parent_invited);
                        if (!empty($parent_invited->use_fullname)) {
                            $data['list_bran'][$key]->create_by = $parent_invited->use_fullname;
                        }
                    }
                }
            }

            $this->load->model('master_shop_rule_model');
            $this->load->model('province_model');
            $data['master_rule'] = $this->master_shop_rule_model->fetch("*", "type = 7", "order_by", "ASC");
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
        }
        $this->get_data_user_shop($id_user_shop);
        $this->load->view('home/page_business/list_branch', $data);
    }

    public function list_news_branch($id_user_shop, $page = 1) {

        $suffix_str = '?' . $_SERVER["QUERY_STRING"];
        if ($this->check_permisstion($id_user_shop, true)) 
        {
            $user_shop = $this->user_model->getDetail("use_id, use_group, use_username, use_fullname, use_slug, avatar, sho_id, sho_name, sho_logo, sho_dir_logo", "LEFT", "tbtt_shop", "tbtt_shop.sho_user = tbtt_user.use_id", "use_id = " . (int) $id_user_shop);
            $data['user_shop'] = $user_shop[0];
            $data['list_bran'] = $this->user_model->get_list_user("use_id, use_group, use_username, use_fullname, use_slug, avatar, sho_id, sho_name, sho_logo, sho_dir_logo", "use_group = 14 AND use_status = 1 AND parent_id = ". $id_user_shop, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');

            $data['list_cate'] = $this->db->query("SELECT cat_id, cat_name FROM tbtt_category WHERE cat_level = 0 AND cate_type = 0 AND cat_status = 1")->result();
            $list_id_branch = [];
            if (!empty($data['list_bran'])) 
            {
                foreach ($data['list_bran'] as $key => $value) 
                {
                    $list_id_branch[] = $value->sho_id;
                }

                $get_branch = implode(',', $list_id_branch);
                $select = 'c.not_id, c.sho_id, c.not_title, c.not_user, c.not_dir_image, c.not_begindate, c.not_view, c.not_status, c.not_image, c.not_image1, c.not_pro_cat_id, u.use_fullname, s.sho_name';
                $from = 'tbtt_content as c';
                $where = "c.sho_id IN (" . $get_branch .')';
                $join = " LEFT JOIN tbtt_user as u ON c.not_user = u.use_id ";
                $join .= " LEFT JOIN tbtt_shop as s ON s.sho_id = c.sho_id ";
                $order = "not_id";
                $by = "DESC";
                $limit = 20;
                $start = ($page - 1) * $limit;

                $check_choose = $send_branch = $this->db->query("SELECT not_id FROM tbtt_send_news WHERE user_shop_id = $id_user_shop")->result();

                if (!empty($check_choose)) {
                    $not_in = [];
                    foreach ($check_choose as $key => $value) 
                    {
                        $not_in[] = $value->not_id;
                    }
                    $not_in = implode(',', $not_in);
                    $where .= " AND not_id NOT IN (" . $not_in . ')';
                }
                 
                if ($_REQUEST['search_name']) 
                {
                    $where .= " AND not_title LIKE ?";
                }

                if ($_REQUEST['search_branch']) 
                {
                    $where .= " AND c.sho_id =" . (int) $_REQUEST['search_branch'];
                }

                if ($_REQUEST['search_category']) 
                {
                    $where .= " AND not_pro_cat_id =" . (int) $_REQUEST['search_category'];
                }

                $data['total'] = $this->db->query("SELECT $select FROM $from $join WHERE $where ORDER BY $order $by",['%'.$_REQUEST['pro_title'].'%'])->num_rows();
            
                $config = $this->_config;
                // Set base_url for every links
                $config["base_url"] = azibai_url() . "/page-business/list-news-branch/". $id_user_shop;
                $config["total_rows"] = $data['total'];
                $config["per_page"] = $limit;
                $config['use_page_numbers'] = true;
                $config['num_links'] = 3;
                $config['uri_segment'] = 4;
                if ($this->uri->segment(4) != 1 && $this->uri->segment(4) != 0 && $this->uri->segment(4) != false) {
                    $config['first_url'] = 1 . rtrim($suffix_str, '&');
                }
                $config['suffix'] = rtrim($suffix_str, '&');
                $this->load->library('pagination', $config);
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                
                $list_news = $this->db->query("SELECT $select FROM $from $join WHERE $where  ORDER BY $order $by LIMIT $limit OFFSET $start", ['%'.$_REQUEST['search_name'].'%'])->result();

                foreach ($list_news as $key => $item) {
                    $list_news[$key]->name_cate = '';
                    if ($item->not_pro_cat_id > 0) 
                    {
                        $name_cate = $this->db->query("SELECT cat_name FROM tbtt_category WHERE cat_id = $item->not_pro_cat_id AND cat_status = 1")->row();
                        $list_news[$key]->name_cate = $name_cate->cat_name;
                    }
                }
                $data['list_news'] = $list_news;
            }            
            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/list_news_branch', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function list_product_branch($id_user_shop, $page = 1) {
        if ($this->check_permisstion($id_user_shop, true))
        {
            $type_pro = 0;
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::shop_get_list_product_branch($id_user_shop, $type_pro, $page);

            $data['type_pro'] = $type_pro;
            $data['user'] = MY_Loader::$static_data['hook_user'];

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/list_product_branch', $data);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function list_coupon_branch($id_user_shop, $page = 1) {
        if ($this->check_permisstion($id_user_shop, true))
        {
            $type_pro = 2;
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::shop_get_list_product_branch($id_user_shop, $type_pro, $page);

            $data['type_pro'] = $type_pro;
            $data['user'] = MY_Loader::$static_data['hook_user'];

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/list_product_branch', $data);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function get_setting_branch() {
        $id_branch = (int) $this->input->post('id_branch');
        $result = ['error' => true, 'response' => []];

        if ($this->check_permisstion($id_branch)) 
        {
            $get_branch = $this->user_model->get('*', "use_group = 14 AND use_status = 1 AND use_id = " . $id_branch);
            $get_branch_shop = $this->shop_model->get("*", "sho_user = " . $id_branch);

            if (!empty($get_branch) && !empty($get_branch_shop)) 
            {
                $result['error'] = false;
                $result['response'] = array(
                    'sho_name'         => $get_branch_shop->sho_name,
                    'address_kho_shop' => $get_branch_shop->sho_kho_address,
                    'sho_kho_province' => $get_branch_shop->sho_kho_province,
                    'sho_kho_district' => $get_branch_shop->sho_kho_district,
                    'namebank_regis'   => $get_branch->bank_name,
                    'addbank_regis'    => $get_branch->bank_add,
                    'accountname_regis'=> $get_branch->account_name,
                    'accountnum_regis' => $get_branch->num_account,
                    'list_district'    => [],
                    'rule'             => [] 
                );

                $this->load->model('branch_model');
                $shop_rule = $this->branch_model->getConfig("*", "bran_id = " . (int) $id_branch);           
                if (!empty($shop_rule)) 
                {  
                    if (!empty($shop_rule->config_rule)) 
                    {
                        $result['response']['rule'] = explode(',', $shop_rule->config_rule);
                    }
                }

                if (!empty($result['response']['sho_kho_province'])) 
                {
                    $this->load->model('district_model');
                    $district = $this->district_model->find_by(array('pre_status' => 1, 'ProvinceCode' => $result['response']['sho_kho_province']), 'id, DistrictName, DistrictCode');
                    $result['response']['list_district'] = $district;
                }
            }
        }
        echo json_encode($result);
        exit();
    }


    public function list_news($id_user_shop, $page = 1) {

        if ($this->check_permisstion($id_user_shop)) 
        {
            $user_group = $this->user_model->get('use_group', "use_id = " . (int) $id_user_shop)->use_group;
            $type = $user_group > 0 ? ($user_group == AffiliateStoreUser ? "shop" : ($user_group == BranchUser ? "branch" : "")) : "";

            $user_id = $id_user_shop;
            $title = isset($_REQUEST['news_title']) ? $_REQUEST['news_title'] : '';
            $cate = isset($_REQUEST['news_cate']) ? $_REQUEST['news_cate'] : '';
            $branch = isset($_REQUEST['search_branch']) ? $_REQUEST['search_branch'] : '';

            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 20;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::branch_get_content_has_shared($user_id, $type, $page, $title, $cate, $branch);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            // dd($data);die;
            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/list_news', $data);
        }
        else 
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function active_content_branch() {
        $id_user_shop = (int) $this->input->post('id_user_shop');
        $not_id = (int) $this->input->post('not_id');
        $result = ['error' => true, 'sms' => ['Cập nhật trạng thái thất bại']];
        if ($this->check_permisstion($id_user_shop)) 
        { 
            $status_share = $this->db->query("SELECT id, status FROM tbtt_send_news WHERE not_id = $not_id AND user_shop_id = $id_user_shop")->row();
            if (!empty($status_share)) 
            {
                $this->db->where(['id' => $status_share->id]);
                if ($this->db->update("tbtt_send_news", ['status'=> abs($status_share->status - 1)])) 
                {
                    $result = ['error' => false, 'sms' => 'Cập nhật trạng thái thành công'];
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function remove_content_branch() {
        $id_user_shop = (int) $this->input->post('id_user_shop');
        $not_id = (int) $this->input->post('not_id');
        $result = ['error' => true, 'sms' => 'Xóa thất bại'];

        if ($this->check_permisstion($id_user_shop, true)) 
        { 
            $status_share = $this->db->query("SELECT id, status FROM tbtt_send_news WHERE not_id = $not_id AND user_shop_id = $id_user_shop")->row();

            if (!empty($status_share)) 
            {
                $this->db->where(['id' => $status_share->id]);
                if ($this->db->delete("tbtt_send_news")) 
                {
                    $result = ['error' => false, 'sms' => 'Xóa thành công'];
                }
            }
        }
        echo json_encode($result);
        exit();
    }

    public function list_product($id_user_shop, $page = 1) {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $type_pro = 0;
            $data['user'] = $this->get_profile_user($id_user_shop);
            $type =  $data['user']['use_group'] == 3 ? "shop" : "branch";
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = array_merge($data, Api_affiliate::get_product_has_shared($id_user_shop, $type_pro, $type = "shop"));
            $data['type_pro'] = $type_pro;
            $data['type'] = $type;

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/product_share', $data, FALSE);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function list_coupon($id_user_shop, $page = 1) {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $type_pro = 2;
            $data['user'] = $this->get_profile_user($id_user_shop);
            $type =  $data['user']['use_group'] == 3 ? "shop" : "branch";
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = array_merge($data, Api_affiliate::get_product_has_shared($id_user_shop, $type_pro, $type = "shop"));
            $data['type_pro'] = $type_pro;
            $data['type'] = $type;

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/product_share', $data, FALSE);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function list_order($id_user_shop)
    {
        if ($this->check_permisstion($id_user_shop)) 
        {
            $user_id = $id_user_shop;
            $pro_type = isset($_REQUEST['pro_type']) && in_array($_REQUEST['pro_type'], [0,2,3]) ? $_REQUEST['pro_type'] : '';
            $start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
            $end_date = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';
            $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
            $customer_name = isset($_REQUEST['customer_name']) ? $_REQUEST['customer_name'] : '';
            $pro_name = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';
            $transporters = isset($_REQUEST['transporters']) ? $_REQUEST['transporters'] : '';
            $order_status = isset($_REQUEST['order_status']) ? $_REQUEST['order_status'] : '';

            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::branch_get_list_order($user_id, $pro_type, $start_date, $end_date, $order_id, $customer_name, $pro_name, $transporters, $order_status, $page);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }
            !empty($start_date) ? $params['start_date'] = $start_date : '';
            !empty($end_date) ? $params['end_date'] = $end_date : '';

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['total'];
            $config['base_url'] = $page_url;
            $config['per_page'] = $limit;
            $config['num_links'] = 3;

            $config['uri_segment'] = 2;

            $config['enable_query_strings'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['use_page_numbers'] = TRUE;
            $config['query_string_segment'] = 'page';

            // To initialize "$config" array and set to pagination library.
            $this->load->library('pagination', $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->get_data_user_shop($id_user_shop);
            $data['list_status'] = $this->db->query("SELECT * FROM tbtt_status WHERE published = 1")->result_array();
            $this->load->view('home/page_business/list_order', $data, FALSE);
        }
        else
        {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function list_order_item($id_user_shop, $order_id = 0)
    {
        if ($this->check_permisstion($id_user_shop) && $order_id > 0) {
            $user_id = $id_user_shop;
            $type = isset($_REQUEST['pro_type']) && in_array($_REQUEST['pro_type'], [0,2,3]) ? $_REQUEST['pro_type'] : '';
            // INCLUDE API
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::branch_get_order_detail($user_id, $order_id, $type);

            $this->get_data_user_shop($id_user_shop);
            $this->load->view('home/page_business/list_order_item', $data, FALSE);
        } else {
            redirect(base_url(), 'location');
            die();
        }
    }

    public function user_list_order()
    {
        $pro_type = isset($_REQUEST['pro_type']) && in_array($_REQUEST['pro_type'], [0,2,3]) ? $_REQUEST['pro_type'] : '';
        $start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
        $end_date = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';
        $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
        $customer_name = isset($_REQUEST['customer_name']) ? $_REQUEST['customer_name'] : '';
        $pro_name = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';
        $transporters = isset($_REQUEST['transporters']) ? $_REQUEST['transporters'] : '';
        $order_status = isset($_REQUEST['order_status']) ? $_REQUEST['order_status'] : '';

        $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $limit = 10;

        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $data = Api_affiliate::user_get_list_order($pro_type, $start_date, $end_date, $order_id, $customer_name, $pro_name, $transporters, $order_status, $page);

        //pagination
        $url_full = get_current_full_url();
        $process_url = parse_url($url_full);
        parse_str($process_url['query'], $params);
        if(isset($params['page'])) {
            unset($params['page']);
        }
        !empty($start_date) ? $params['start_date'] = $start_date : '';
        !empty($end_date) ? $params['end_date'] = $end_date : '';

        $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

        $config = $this->_config;
        $config['total_rows'] = $data['total'];
        $config['base_url'] = $page_url;
        $config['per_page'] = $limit;
        $config['num_links'] = 3;

        $config['uri_segment'] = 2;

        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';

        // To initialize "$config" array and set to pagination library.
        $this->load->library('pagination', $config);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['list_status'] = $this->db->query("SELECT * FROM tbtt_status WHERE published = 1")->result_array();
        $this->load->view('home/page_business/list_order_user_buy', $data, FALSE);

    }

    public function user_list_order_item($order_id = 0)
    {
        if ($order_id > 0) {
            $type = isset($_REQUEST['pro_type']) && in_array($_REQUEST['pro_type'], [0,2,3]) ? $_REQUEST['pro_type'] : '';
            // INCLUDE API
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data = Api_affiliate::user_get_order_detail($order_id, $type);

            $this->load->view('home/page_business/list_order_user_buy_item', $data, FALSE);
        } else {
            redirect(base_url(), 'location');
            die();
        }
    }
    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Ajax Get List Affiliate parent
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: array
     *
     ***************************************************************************
    */

    public function getAffilateUser ($id_user_shop = 0) {
        
        /**
         * 0: thành viên mới
         * 1: nhà phân phối
         * 2: tổng đại lý
         * 3: đại lý
        */
        $value_request = [0,1,2,3,'all'];
        
        $aListId = array();
        // $iUserId = (int)$this->session->userdata('sessionUser');
        $iUserId = $id_user_shop;

        $this->get_data_user_shop($iUserId);

        if(!isset($_REQUEST['affiliate']) || !in_array($_REQUEST['affiliate'], $value_request)) {
            redirect(azibai_url("/page-business/{$iUserId}"),'refresh');
            exit();
        }
        $iAff = $_REQUEST['affiliate'] != 'all' ? $_REQUEST['affiliate'] : null;

        $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $limit = 10;

        $user_type = $_REQUEST['user_type'] ? $_REQUEST['user_type'] : null;
        $search = $_REQUEST['search_aff'] ? $_REQUEST['search_aff'] : '';

        $data_return = [];
        $rent_header = null;

        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data list user affiliate
        $url = $this->config->item('api_aff_list_user_data');
        $url = str_replace(['{$user_id}','{$level}','{$page}','{$limit}','{$user_type}','{$search}','{$type_affiliate}','{$parent_id}'], [$iUserId, $iAff, $page, $limit, $user_type, $search,2,$iUserId], $url);
        $params = null;
        $make_call = $this->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'users' => $make_call['data'],
                'user_total' => $make_call['total'],
                'total' => [
                    'all'=>$make_call['iTotal'] ? $make_call['iTotal'] : 0,
                    'lv1'=>$make_call['iTotalLv1'] ? $make_call['iTotalLv1'] : 0,
                    'lv2'=>$make_call['iTotalLv2'] ? $make_call['iTotalLv2'] : 0,
                    'lv3'=>$make_call['iTotalLv3'] ? $make_call['iTotalLv3'] : 0,
                    'user_new'=>$make_call['iUserNew'] ? $make_call['iUserNew'] : 0,
                    'user_buy'=>$make_call['iUserBuy'] ? $make_call['iUserBuy'] : 0,
                ],
            ];
        }

        $data['data_aff'] = $data_return;
        $data['search'] = $search;
        
        //pagination
        $url_full = get_current_full_url();
        $process_url = parse_url($url_full);
        parse_str($process_url['query'], $params);
        if(isset($params['page'])) {
            unset($params['page']);
        }
        if($search != '') {
            $params['search_aff'] = $search;
        }
        $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

        $config = $this->_config;
        $config['total_rows'] = $data['data_aff']['user_total'];
        $config['base_url'] = $page_url;
        $config['per_page'] = $limit;
        $config['num_links'] = 3;

        $config['uri_segment'] = 2;

        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';

        // To initialize "$config" array and set to pagination library.
        $this->load->library('pagination', $config);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('home/page_business/list_affiliate', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Invite Affilate User
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: array
     *
     ***************************************************************************
    */

    public function inviteAffilateUser ($id_user_shop = 0) {
        $this->load->model('friend_model');
        $iUserId = $id_user_shop;
        if($iUserId == 0) {
            redirect(azibai_url(),'refresh');
            exit();
        } 
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $url = $this->config->item('api_aff_user_invite');
        $url = str_replace(['{$type_affiliate}','{$parent_id}'], [2,(int) $iUserId], $url);

        $params = null;
        $make_call = $this->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] == 1) {
            $data['sUrl']   = $make_call['data']['sUrl'];
            $data['sImage'] = $make_call['data']['sImage'];
        }

        $data['aListFriend'] = array();
        $search = $_POST['search'] ? $_POST['search'] : '';
        $page = $_POST['page'] ? $_POST['page'] : 1;
        $limit = 20;
        $url = $this->config->item('api_aff_listfriend');
        $url = str_replace(['{$page}','{$limit}','{$search}'], [$page,$limit,$search], $url);
        if(empty($search)) {
            $url = str_replace('&search=', '', $url);
        }
        $url .= "&parent_id=$iUserId&type_affiliate=2";

        $make_call = $this->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] == 1) {
            $data['aListFriend'] = $make_call['data']['data'];
        }

        if($this->input->is_ajax_request()) {
            $html = '';
            if(!empty($data['aListFriend'])) {
                foreach ($data['aListFriend'] as $key => $value) {
                    $html .= $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-invite-user', ['oFriend'=>$value], true);
                }
            } else {
                $html = "<li>Không tìm thấy dữ liệu</li>";
            }
            echo $html; die;
        } else {
            $this->load->view('home/page_business/affiliate_invite', $data);
        }
    }

    public function backend_create_voucher($uid)
    {
        if(empty($this->session->userData('sessionUser'))){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $data['user_id'] = $uid;
        $user_id = $uid;
        switch ($_REQUEST["step"]) {
            case 1:
                // $user_id = $this->session->userData('sessionUser');
                $page = 1;
                $limit = 20;
                if($this->input->is_ajax_request()) {
                    $page = $_POST['page'];
                    $checking_all = $_POST['checking_all'];
                    $product_type = $_POST['product_type'];
                    $list_product = $_POST['list_product'];
                    $search = $_POST['search'] !== '' ? $_POST['search'] : null;

                    $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                    $list_product_voucher = Api_affiliate::get_voucher_product_list($user_id, $page, $limit, $search);
                    $html = '';
                    foreach ($list_product_voucher['items'] as $key => $item) {
                        $html .= $this->load->view('home/page_business/backend-doanhnghiep/html/item-page-1', ['item'=>$item, 'checking_all'=>$checking_all, 'product_type'=>$product_type, 'list_product'=>$list_product], TRUE);
                    }
                    echo $html; die;
                } else {
                    // include api
                    $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                    $data['list_product_voucher'] = Api_affiliate::get_voucher_product_list($user_id, $page, $limit, $search);

                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step1', $data);
                    break;
                }
            case 2:
                if($this->check_request_step_2()) {
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step2', $data);
                } else {
                    $_REQUEST['step'] = 1;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            case 3:
                if($this->check_request_step_3() || $_REQUEST['skip'] == 1) {
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step3', $data);
                } else {
                    $_REQUEST['step'] = 2;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            case 4:
                if($this->check_request_step_4() || $_REQUEST['skip'] == 1) {
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step4', $data);
                } else {
                    $_REQUEST['step'] = 3;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            case 5:
                if($this->check_request_step_5() || $_REQUEST['skip'] == 1) {
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step5', $data);
                } else {
                    $_REQUEST['step'] = 4;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            case 6:
                if($this->check_request_step_6() || $_REQUEST['skip'] == 1) {
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step6', $data);
                } else {
                    $_REQUEST['step'] = 5;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            case 7:
                if($this->check_request_step_7() || $_REQUEST['skip'] == 1) {
                    if($this->check_request_step_2() && $this->check_request_step_3() && $this->check_request_step_4() && $this->check_request_step_5() && $this->check_request_step_6() && $this->check_request_step_7()) {
                        $data['show_submit'] = true;
                    }
                    $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                    $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step7', $data);
                } else {
                    $_REQUEST['step'] = 6;
                    $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
                    redirect($back_link, 'location');
                    exit();
                }
                break;
            default:
                if($_REQUEST['view'] > 0) {
                    // include api
                    $voucher_id = $_REQUEST['view'];
                    if($_REQUEST['prolist'] == 1) { // xem sản phẩm áp dụng voucher
                        $page = 1;
                        $limit = 20;
                        $search = '';
                        if($this->input->is_ajax_request()) {
                            $page = $_POST['page'];
                            $search = $_POST['search'];
                            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $user_id, $page, $limit, $search);
                            $html = '';
                            foreach ($data['list_product']['data'] as $key => $item) {
                                $html .= $this->load->view('home/page_business/backend-doanhnghiep/html/item-create-step-review-listitem', ['item'=>$item], TRUE);
                            }
                            echo $html;die;
                        } else {
                            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $user_id, $page, $limit, $search);
                            $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                            $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-step-review-listitem', $data);
                        }
                    } else {
                        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                        $data['voucher_data'] = Api_affiliate::detail_voucher($voucher_id);
                        // dd($data['voucher_data']);die;
                        $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
                        $this->load->view('home/page_business/backend-doanhnghiep/page/page-create-voucher-step-review', $data);
                    }

                } else {
                    redirect(base_url() . 'page-not-found', 'location');
                    exit();
                }
                break;
        }
    }

    public function backend_list_voucher($uid)
    {
        if(empty($this->session->userData('sessionUser'))){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $data['user_id'] = $uid;
        $page = 1;
        $limit = 20;

        if($this->input->is_ajax_request()) {
            $page = $_POST['page'];
            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_voucher'] = Api_affiliate::list_voucher($uid, $page, $limit);
            $html = '';
            foreach ($data['list_voucher']['data'] as $key => $item) {
                $html .= $this->load->view('home/page_business/backend-doanhnghiep/html/item-show-list-voucher', ['item'=>$item], TRUE);
            }
            echo $html;die;
        } else {
            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_voucher'] = Api_affiliate::list_voucher($uid, $page, $limit);
            $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
            $this->load->view('home/page_business/backend-doanhnghiep/page/page-show-list-voucher', $data);
        }

        // dd($data['list_voucher']);die;
    }

    // kiểm tra chọn tất cả hoặc nhiều sản phẩm
    private function check_request_step_2()
    {
        $flag = false;
        if(isset($_REQUEST['product_type'])) {
            // chọn tất cả sản phẩm
            if($_REQUEST['product_type'] == 1 && isset($_REQUEST['price_rank']) && $_REQUEST['price_rank'] != '') {
                $flag = true;
            }
            if($_REQUEST['product_type'] == 1 && isset($_REQUEST['list_product']) && $_REQUEST['list_product'] == '') {
                $flag = true;
            }
            // chọn nhiều sản phẩm
            if(($_REQUEST['product_type'] == 1 || $_REQUEST['product_type'] == 2) && isset($_REQUEST['list_product']) && $_REQUEST['list_product'] != '') {
                $temp = explode(',', $_REQUEST['list_product']);
                if(count($temp) > 0 && $temp) {
                    foreach ($temp as $key => $num) {
                        is_numeric($num) ? $flag = true : $flag = false;
                        if($flag === false) {
                            break;
                        }
                    }
                }
            }
        }

        return $flag;
    }

    // kiểm tra giảm theo % hay tiền
    private function check_request_step_3()
    {
        $flag = false;
        if(isset($_REQUEST['voucher_type']) && isset($_REQUEST['value']) && $_REQUEST['value'] != '') {
            // giảm theo phần trăm
            if($_REQUEST['voucher_type'] == 1 && $_REQUEST['value'] > 0 && $_REQUEST['value'] <= 100) {
                $flag = true;
            }
            // giảm theo giá tiền
            if($_REQUEST['voucher_type'] == 2 && $_REQUEST['value'] > 0) {
                $flag = true;
            }
        }

        return $flag;
    }

    private function check_request_step_4()
    {
        $flag = false;
        if(isset($_REQUEST['quantily']) && $_REQUEST['quantily'] != '' && $_REQUEST['quantily'] > 0) {
            $flag = true;
        }
        return $flag;
    }

    private function check_request_step_5()
    {
        function validateDate($date, $format = 'H:i d-m-Y')
        {
            if (DateTime::createFromFormat($format, $date) !== FALSE) {
                return true;
            } else {
                return false;
            }
        }
        $flag = false;
        if(isset($_REQUEST['time_start']) && $_REQUEST['time_start'] != '' && isset($_REQUEST['time_end']) && $_REQUEST['time_end'] != '') {
            if(validateDate($_REQUEST['time_start']) && validateDate($_REQUEST['time_end'])) {
                $flag = true;
            }
        }
        return $flag;
    }

    private function check_request_step_6()
    {
        $flag = false;
        if(isset($_REQUEST['apply']) && $_REQUEST['apply'] != '' && in_array($_REQUEST['apply'], [1,2,3])) {
            $flag = true;
        }
        return $flag;
    }

    private function check_request_step_7()
    {
        $flag = false;
        $price_compare = 0;
        $_REQUEST['discount_type'] == 1 ? $price_compare = $_REQUEST['price'] - ($_REQUEST['price'] * $_REQUEST['price_percent'])/100 : ($_REQUEST['discount_type'] == 2 ? $price_compare = $_REQUEST['price'] - $_REQUEST['price_discount'] : 0);
        if(isset($_REQUEST['price']) && $_REQUEST['price'] > 0
        && isset($_REQUEST['discount_type']) && in_array($_REQUEST['discount_type'], [1,2])
        && isset($_REQUEST['affiliate_type']) && in_array($_REQUEST['affiliate_type'], [1,2])
        ) {
            if( (($_REQUEST['discount_type'] == 1 && $_REQUEST['price_percent'] >= 0 && $_REQUEST['price_percent'] <= 100) || ($_REQUEST['discount_type'] == 2 && $_REQUEST['price_discount'] >= 0 && $_REQUEST['price_discount'] <= $_REQUEST['price']))
            && ( ($_REQUEST['affiliate_type'] == 1 
                    && $_REQUEST['affiliate_value_1'] <= 100 
                    && $_REQUEST['affiliate_value_2'] <= 100 
                    && $_REQUEST['affiliate_value_3'] <= 100) 
                || ($_REQUEST['affiliate_type'] == 2 
                    && $_REQUEST['affiliate_value_1'] <= $price_compare 
                    && $_REQUEST['affiliate_value_2'] <= $_REQUEST['affiliate_value_1'] 
                    && $_REQUEST['affiliate_value_3'] <= $_REQUEST['affiliate_value_2']) 
                )
            && ( $_REQUEST['affiliate_value_1'] >= 0 && $_REQUEST['affiliate_value_2'] >= 0 && $_REQUEST['affiliate_value_3'] >= 0 && $_REQUEST['affiliate_value_1'] !== null && $_REQUEST['affiliate_value_2'] !== null && $_REQUEST['affiliate_value_3'] !== null && $_REQUEST['affiliate_value_1'] !== 'null' && $_REQUEST['affiliate_value_2'] !== 'null' && $_REQUEST['affiliate_value_3'] !== 'null')
            ) {
                $flag = true;
            }
        }
        return $flag;
    }

    private function get_data_user_shop($id_user_shop)
    {
        if(empty($id_user_shop)) {
            $id_user_shop = (int) $this->session->userdata('sessionUser');
        }
        if ($this->check_permisstion($id_user_shop))
        {
            $data['user_shop'] = $this->user_model->get('*', "use_id = " . (int) $id_user_shop);
            $this->load->model('package_user_model');

            $aListPackge = array(40,41,42,43);
            $sql = '';
            foreach ($aListPackge as $iKey => $iPackge) {
                if($iKey != 0) {
                    $sql .= ' OR package_id = '.$iPackge;
                }else {
                    $sql .= 'package_id = '.$iPackge;
                }
            }

            $aListPackgeU = $this->check_buy_package(43, $id_user_shop, 1);
            if(!empty($aListPackgeU)) {
                $data['is_systema'] = 1;
            }

            $this->load->vars($data);
            return true;
        }
        else 
        {
            return false;
        }
    }

    private function check_buy_package($package_id = 41, $user_id = 0, $payment_status = 1) {
        $this->load->model('package_user_model');
        $package = $this->package_user_model->getwhere("*", "package_id = {$package_id} AND user_id = {$user_id} AND payment_status = {$payment_status}");
        return $package;
    }

}

