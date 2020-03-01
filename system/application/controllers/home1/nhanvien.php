<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Nhanvien extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        #END CHECK SETTING
        #BEGIN: CHECK LOGIN
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateStoreUser
                || $group_id == BranchUser
                || $group_id == AffiliateUser
                || $group_id == Developer2User
                || $group_id == Developer1User
                || $group_id == Partner2User
                || $group_id == Partner1User
                || $group_id == CoreMemberUser
                || $group_id == CoreAdminUser
                || $group_id == StaffStoreUser
                || $group_id == StaffUser) {
            } else {
                redirect(base_url() . 'account', 'location');
                die();
            }
        }
        #END CHECK LOGIN
        #Load library
        $this->load->library('hash');
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/register');
        #Load model
        $this->load->model('user_model');
        $this->load->model('category_model');
        $this->load->model('package_user_model');
        $this->load->model('shop_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('content_model');
        $this->load->model('wallet_model');
        $this->load->model('order_model');

        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        
        if ($this->session->userdata('sessionUser') > 0) {
            # Check user actived
            $cur_user =  $this->user_model->get('use_id,use_username,avatar,af_key', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
		$data['af_id'] = $cur_user->af_key;
	    } else {
		$parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
	    }
	    $data['myshop'] = $myshop;
	    $data['currentuser'] = $cur_user;
            $data['menuType'] = 'account';	    
	    
            if($cur_user && count($cur_user) === 1 && (int)$cur_user->use_id > 0){
		/**/		
            } else {
                redirect(base_url() . 'logout', 'location'); die;
            }
        }
        
        // $css = loadCss(array('home/css/bootstrap.css', 'home/css/font-awesome.min.css', 'home/css/style-azibai.css'), 'asset/home/nhanvien.min.css');
        $css = loadCss(array('home/css/libraries.css', 'home/css/style-azibai.css'), 'asset/home/nhanvien.min.css');
        $data['css'] = '<style>' . $css . '</style>';
        $this->load->vars($data);

    }

    function invited_ctv($uid = 0)
    {
        if ($uid > 0 && $this->input->post('mobile_regis') && $this->input->post('mobile_regis') != '') {

            $this->load->library('form_validation');
            //start validate
            $this->form_validation->set_rules('fullname_regis', 'lang:fullname_regis_label_defaults', 'trim|required');
            $this->form_validation->set_rules('mobile_regis', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone|callback__exist_username_use_phone');
            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
            $this->form_validation->set_rules('email_regis', 'lang:email_regis_label_defaults', 'trim|required|valid_email|callback__exist_email');
            $this->form_validation->set_rules('idcard_regis', '', 'trim|required');
            $this->form_validation->set_rules('province_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_province');
            $this->form_validation->set_rules('district_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_district');
            //end validate
            //set mess error
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
            $this->form_validation->set_message('matches', $this->lang->line('matches_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
            $this->form_validation->set_message('_exist_username_use_phone', $this->lang->line('_exist_username_message_defaults'));
            $this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_defaults'));
            $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
            $this->form_validation->set_message('_exist_district', $this->lang->line('_exist_district_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            //end set mess
            if ($this->form_validation->run() != false) {
                //xử lý data            
                $salt = $this->hash->key(8);
                $key = $this->hash->create(trim($this->filter->injection_html($this->input->post('mobile_regis'))), null, 'sha256md5');
                $active = 1;
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $group = AffiliateUser;
                $mobile = trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis'))));
                $password = $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512');
                $email = trim(strtolower($this->filter->injection_html($this->input->post('email_regis'))));
                $fullname = trim($this->filter->injection_html($this->input->post('fullname_regis')));
                $id_card = trim($this->filter->injection_html($this->input->post('idcard_regis')));
                $province = $this->input->post('province_regis');
                $district = $this->input->post('district_regis');
                $parent_id = $this->user_model->get("parent_id", "use_id = $uid")->parent_id;
                $parent_group = $this->user_model->get("use_group", "use_id = $parent_id")->use_group;
                if($parent_group == AffiliateStoreUser) {
                    $parent_shop = 0;
                }else{
                    $parent_shop = $this->user_model->get("parent_id", "use_id = $parent_id")->parent_id;
                }
                $parent_shop;
                $dataRegister = array(
                    'use_username' => $mobile,
                    'use_password' => $password,
                    'use_salt' => $salt,
                    'use_email' => $email,
                    'use_fullname' => $fullname,
                    'use_mobile' => $mobile,
                    'id_card' => $id_card,
                    'use_group' => $group,
                    'use_status' => $active,
                    'use_regisdate' => $currentDate,
                    'use_enddate' => 0,
                    'use_key' => $key,
                    'use_lastest_login' => $currentDate,
                    'parent_id' => $parent_id,
                    'parent_shop' => $parent_shop,
                    'parent_invited' => $uid,
                    'active_date' => date('Y-m-d'),
                    'use_province' => $province,
                    'user_district' => $district
                );
                //success
                if ($this->user_model->add($dataRegister)) {
                    $sho_user = $this->user_model->get('use_id', $dataRegister)->use_id;
                    $dataShopAF = array(
                        'sho_name' => 'Cộng tác viên online',
                        'sho_descr' => 'Chưa cập nhật',
                        'sho_link' => $mobile,
                        'sho_logo' => 'default-logo.png',
                        'sho_dir_logo' => 'defaults',
                        'sho_banner' => 'default-banner.jpg',
                        'sho_dir_banner' => 'defaults',
                        'sho_province' => $province,
                        'sho_district' => $district,
                        'sho_category' => 1,
                        'sho_phone' => $mobile,
                        'sho_mobile' => $mobile,
                        'sho_user' => $sho_user,
                        'sho_begindate' => $currentDate,
                        'sho_enddate' => 0,
                        'sho_view' => 1,
                        'sho_status' => $active,
                        'sho_style' => 'default',
                        'sho_email' => $email
                    );
                    $this->shop_model->add($dataShopAF);
                    $data['successRegister'] = true;
                    $this->load->view('home/nhanvien/emp-ctv', $data);
                } else {
                    $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1" . $where_province, "pre_order", "ASC");
                    if ($this->input->post('district_regis')) {
                        $filterDistrict = array(
                            'select' => 'DistrictCode, DistrictName',
                            'where' => array('ProvinceCode' => $this->input->post('province_regis'))
                        );
                        $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
                    }
                    $data['successRegister'] = false;
                    $this->load->view('home/nhanvien/emp-ctv', $data);
                }
            } else {
                redirect('home', 'location');
                die();
            }
        } else {
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1" . $where_province, "pre_order", "ASC");
            if ($this->input->post('district_regis')) {
                $filterDistrict = array(
                    'select' => 'DistrictCode, DistrictName',
                    'where' => array('ProvinceCode' => $this->input->post('province_regis'))
                );
                $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
            }
            $data['successRegister'] = false;
            $this->load->view('home/nhanvien/emp-ctv', $data);
        }
    }

    function invited_branch()
    {
        if ($this->input->post('mobile_regis') && $this->input->post('mobile_regis') != '') {
            $this->load->library('form_validation');
            //start validate
            $this->form_validation->set_rules('fullname_regis', 'lang:fullname_regis_label_defaults', 'trim|required');
            $this->form_validation->set_rules('mobile_regis', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone|callback__exist_username_use_phone');
            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
            $this->form_validation->set_rules('email_regis', 'lang:email_regis_label_defaults', 'trim|required|valid_email|callback__exist_email');
            $this->form_validation->set_rules('idcard_regis', '', 'trim|required');
            $this->form_validation->set_rules('province_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_province');
            $this->form_validation->set_rules('district_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_district');
            //end validate
            //set mess error
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
            $this->form_validation->set_message('matches', $this->lang->line('matches_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
            $this->form_validation->set_message('_exist_username_use_phone', $this->lang->line('_exist_username_message_defaults'));
            $this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_defaults'));
            $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
            $this->form_validation->set_message('_exist_district', $this->lang->line('_exist_district_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            //end set mess
            if ($this->form_validation->run() != false) {
                //xử lý data            
                $salt = $this->hash->key(8);
                $key = $this->hash->create(trim($this->filter->injection_html($this->input->post('mobile_regis'))), null, 'sha256md5');
                $active = 1;
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $group = BranchUser;
                $mobile = trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis'))));
                $password = $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512');
                $email = trim(strtolower($this->filter->injection_html($this->input->post('email_regis'))));
                $fullname = trim($this->filter->injection_html($this->input->post('fullname_regis')));
                $id_card = trim($this->filter->injection_html($this->input->post('idcard_regis')));
                $province = $this->input->post('province_regis');
                $district = $this->input->post('district_regis');
                $uid = $this->session->userdata('sessionUser');
                $parent_id = $this->user_model->get("parent_id", "use_id = $uid")->parent_id;
                $messager = trim($this->filter->injection_html($this->input->post('message_regis')));
                $tax_type = $this->input->post('taxtype_regis');
                $tax_code = $this->input->post('tax_code');
                $dataRegister = array(
                    'use_username' => $mobile,
                    'use_password' => $password,
                    'use_salt' => $salt,
                    'use_email' => $email,
                    'use_fullname' => $fullname,
                    'use_mobile' => $mobile,
                    'id_card' => $id_card,
                    'use_group' => $group,
                    'use_status' => $active,
                    'use_regisdate' => $currentDate,
                    'use_enddate' => 0,
                    'use_key' => $key,
                    'use_lastest_login' => $currentDate,
                    'parent_id' => $parent_id,
                    'parent_shop' => $parent_id,
                    'parent_invited' => $uid,
                    'active_date' => date('Y-m-d'),
                    'use_province' => $province,
                    'user_district' => $district,
                    'tax_type' => $tax_type,
                    'tax_code' => $tax_code,
                    'use_message' => $messager,
                );
                //success
                if ($this->user_model->add($dataRegister)) {
                    $sho_user = $this->user_model->get('use_id', $dataRegister)->use_id;
                    $dataShop = array(
                        'sho_name' => 'Cộng tác viên online',
                        'sho_descr' => 'Chưa cập nhật',
                        'sho_link' => $mobile,
                        'sho_logo' => 'default-logo.png',
                        'sho_dir_logo' => 'defaults',
                        'sho_banner' => 'default-banner.jpg',
                        'sho_dir_banner' => 'defaults',
                        'sho_province' => $province,
                        'sho_district' => $district,
                        'sho_category' => 1,
                        'sho_phone' => $mobile,
                        'sho_mobile' => $mobile,
                        'sho_user' => $sho_user,
                        'sho_begindate' => $currentDate,
                        'sho_enddate' => 0,
                        'sho_view' => 1,
                        'sho_status' => $active,
                        'sho_style' => 'default',
                        'sho_email' => $email,
                        'sho_facebook' => $messager,
                    );
                    $this->shop_model->add($dataShop);
                    $data['successRegister'] = true;
                    $this->load->view('home/nhanvien/emp-branch', $data);
                } else {
                    $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1" . $where_province, "pre_order", "ASC");
                    if ($this->input->post('district_regis')) {
                        $filterDistrict = array(
                            'select' => 'DistrictCode, DistrictName',
                            'where' => array('ProvinceCode' => $this->input->post('province_regis'))
                        );
                        $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
                    }
                    $data['successRegister'] = false;
                    $this->load->view('home/nhanvien/emp-branch', $data);
                }
            } else {
                redirect('account/emp-addbranch', 'location');
                die();
            }
        } else {
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1" . $where_province, "pre_order", "ASC");
            if ($this->input->post('district_regis')) {
                $filterDistrict = array(
                    'select' => 'DistrictCode, DistrictName',
                    'where' => array('ProvinceCode' => $this->input->post('province_regis'))
                );
                $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
            }
            $data['successRegister'] = false;
            $this->load->view('home/nhanvien/emp-branch', $data);
        }
    }

    function list_affiliate_invited()
    {
        $limit = settingOtherAccount;
        $offset = 0;
        $page_num = empty($this->uri->segment(4)) ? 1 : $this->uri->segment(4);
        if ($page_num > 1) {
            $offset = ($page_num - 1) * settingOtherAccount;
        }
        $uid = $this->session->userdata('sessionUser');
        $group = $this->session->userdata('sessionGroup');

        $dataRaws = $this->db->select('tbtt_user.use_username, tbtt_user.use_email, tbtt_user.use_mobile, tbtt_shop.sho_link, tbtt_shop.domain')
            ->from('tbtt_user')
            ->where('tbtt_user.use_group = 2 and tbtt_user.parent_invited = ' . $uid)
            ->join('tbtt_shop', 'tbtt_user.use_id = tbtt_shop.sho_user', 'left')
            ->order_by('tbtt_user.use_id', 'DESC')
            ->get()
            ->result();
        $data['totalRecord'] = count($dataRaws);

        $dataRaws = array_slice($dataRaws, $offset, $limit);
        foreach ($dataRaws as $key => $value) {
            $linkSubDomain = $this->buildLinkAF($value->sho_link, $value->domain);
            $dataRaws[$key]->sho_link = $linkSubDomain;
            $dataRaws[$key]->stt = $offset + 1;
            $offset++;
        }
        $data['dataCTVs'] = $dataRaws;
        ///////////////paging//////////////////////////
        $this->load->library('pagination');
        $config['total_rows'] = $data['totalRecord'];
        $config['base_url'] = getAliasDomain() . 'account/emp-listaffiliate/page/';
        $config['first_url'] = '1';
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = true;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $this->load->view('home/nhanvien/emp-ctv-total-invited', $data);
    }

    function list_branch_invited()
    {
        $limit = settingOtherAccount;
        $offset = 0;
        $page_num = empty($this->uri->segment(4)) ? 1 : $this->uri->segment(4);
        if ($page_num > 1) {
            $offset = ($page_num - 1) * settingOtherAccount;
        }
        $uid = $this->session->userdata('sessionUser');
        $group = $this->session->userdata('sessionGroup');

        $dataRaws = $this->db->select('tbtt_user.use_username, tbtt_user.use_email, tbtt_user.use_mobile, tbtt_shop.sho_link, tbtt_shop.domain')
            ->from('tbtt_user')
            ->where('tbtt_user.use_group = 14 and tbtt_user.parent_invited = ' . $uid)
            ->join('tbtt_shop', 'tbtt_user.use_id = tbtt_shop.sho_user', 'left')
            ->order_by('tbtt_user.use_id', 'DESC')
            ->get()
            ->result();
        $data['totalRecord'] = count($dataRaws);

        $dataRaws = array_slice($dataRaws, $offset, $limit);
        foreach ($dataRaws as $key => $value) {
            $linkSubDomain = $this->buildLinkAF($value->sho_link, $value->domain);
            $dataRaws[$key]->sho_link = $linkSubDomain;
            $dataRaws[$key]->stt = $offset + 1;
            $offset++;
        }
        $data['dataBranchs'] = $dataRaws;
        ///////////////paging//////////////////////////
        $this->load->library('pagination');
        $config['total_rows'] = $data['totalRecord'];
        $config['base_url'] = getAliasDomain() . 'account/emp-listbranch/page/';
        $config['first_url'] = '1';
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = true;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $this->load->view('home/nhanvien/emp-branch-total-invited', $data);
    }

    function comment_processing()
    {
        $limit = settingOtherAccount;
        $offset = 0;
        $page_num = empty($this->uri->segment(4)) ? 1 : $this->uri->segment(4);
        if ($page_num > 1) {
            $offset = ($page_num - 1) * settingOtherAccount;
        }
        $uid = $this->session->userdata('sessionUser');
        $group = $this->session->userdata('sessionGroup');
        $parent_id = $this->user_model->get("parent_id", "use_id = $uid")->parent_id;

        $dataRaws = $this->order_model->getListComplaintsOrders(array('status_id_delivery' => true, 'user_id' => $parent_id), array('key' => 'id', 'value' => 'DESC'));
        $data['totalRecord'] = count($dataRaws);
        $data['listComplaintsOrders'] = array_slice($dataRaws, $offset, $limit);
        foreach ($dataRaws as $key => $value) {
            $dataRaws[$key]->stt = $offset + 1;
            $offset++;
            switch ($value->status_id) {
                case '1':
                    $dataRaws[$key]->status_mean = 'Yêu cầu khiếu nại Mới';
                    $dataRaws[$key]->type_mean = '';
                    break;
                case '2':
                    $dataRaws[$key]->status_mean = 'Chờ thành viên gởi mẫu vận chuyển';
                    $dataRaws[$key]->type_mean = '';
                    break;
                case '3':
                    if ($value->type_id == 1) {
                        $dataRaws[$key]->status_mean = 'Xác nhận và tạo đơn hàng mới cho thành viên';
                        $dataRaws[$key]->type_mean = 'Đổi hàng';
                    } else {
                        $dataRaws[$key]->status_mean = 'Xác nhận và hoàn tiền cho thành viên';
                        $dataRaws[$key]->type_mean = 'Trả hàng';
                    }
                    break;
                default:
                    $dataRaws[$key]->status_mean = 'Đơn hàng lỗi';
                    $dataRaws[$key]->type_mean = '';
                    break;
            }
        }
        
        /////////////////paging/////////////////////////
        $this->load->library('pagination');
        $config['total_rows'] = $data['totalRecord'];
        $config['base_url'] = getAliasDomain() . 'account/emp-complaintsOrders/page/';
        $config['first_url'] = '1';
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = true;
        $config['uri_segment'] = 4;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        ////////////////end///////////////////////////////

        $this->load->view('home/nhanvien/emp-comment-processing', $data);
    }

    function listProductCouponPostByNV()
    {
        $limit = settingOtherAccount;
        $offset = 0;
        $pro_type = 0;
        $data['url2'] = $url2 = $this->uri->segment(2);

        if ($url2 == 'emp-product') {
            $pro_type = 0;
            $viewload = 'home/nhanvien/emp-list-pro-post-by-nv';
        } elseif ($url2 == 'emp-coupon') {
            $pro_type = 2;
            $viewload = 'home/nhanvien/emp-list-cou-post-by-nv';
        }

        if (($this->uri->segment(3) == 'search' && $this->uri->segment(4) != 'all') || !empty($this->input->post('keyword_account'))) {
            $data['search_key'] = $search_key = $this->input->post('keyword_account');
            if (empty($search_key)) {
                $data['search_key'] = $search_key = $this->uri->segment(4);
            }
            $where .= "pro_name LIKE '%" . $search_key . "%' AND ";
            $data['page_num'] = $page_num = empty($this->uri->segment(9)) ? 1 : $this->uri->segment(9);
            if ($page_num > 1) {
                $offset = ($page_num - 1) * settingOtherAccount;
            }
            $data['sortField'] = $sortField = $this->uri->segment(6);
            switch ($sortField) {
                case 'name':
                    $sort = 'pro_name';
                    break;
                case 'category':
                    $sort = 'cat_name';
                default:
                    $sort = 'pro_id';
                    $data['sortField'] = $sortField = 'all';
                    break;
            }
            $data['sortAtt'] = $sortAtt = $this->uri->segment(7);
            switch ($sortAtt) {
                case 'asc':
                    $by = 'ASC';
                    break;

                default:
                    $by = 'DESC';
                    $data['sortAtt'] = $sortAtt = strtolower($by);
                    break;
            }
            $config_baseurl = getAliasDomain() . "account/$url2/search/$search_key/sort/$sortField/$sortAtt/page/";
            $config_uri_segment = 9;
        } else {
            if(($this->uri->segment(3) == 'search' && $this->uri->segment(4) == 'all') ) {
                $sort = 'pro_id';
                $data['sortField'] = $sortField = $this->uri->segment(6);
                switch ($sortField) {
                    case 'name':
                        $sort = 'pro_name';
                        break;
                    case 'category':
                        $sort = 'cat_name';
                    default:
                        $sort = 'pro_id';
                        $data['sortField'] = $sortField = 'all';
                        break;
                }
                $data['sortAtt'] = $sortAtt = $this->uri->segment(7);
                switch ($sortAtt) {
                    case 'asc':
                        $by = 'ASC';
                        break;

                    default:
                        $by = 'DESC';
                        $data['sortAtt'] = $sortAtt = strtolower($by);
                        break;
                }
                $data['sortAtt'] = $sortAtt = strtolower($by);
            } else {
                $sort = 'pro_id';
                $data['sortField'] = $sortField = 'all';
                $by = 'DESC';
                $data['sortAtt'] = $sortAtt = strtolower($by);
            }
            $data['search_key'] = $search_key = 'all';
            // $sort = 'pro_id';
            // $data['sortField'] = $sortField = 'all';
            // $by = 'DESC';
            // $data['sortAtt'] = $sortAtt = strtolower($by);
            $data['page_num'] = $page_num = empty($this->uri->segment(9)) ? 1 : $this->uri->segment(9);
            if ($page_num > 1) {
                $offset = ($page_num - 1) * settingOtherAccount;
            }
            $config_baseurl = getAliasDomain() . "account/$url2/search/$search_key/sort/$sortField/$sortAtt/page/";
            $config_uri_segment = 9;
        }

        $uid = $this->session->userdata('sessionUser');
        $parent_id = $this->user_model->get("parent_id", "use_id = $uid")->parent_id;
        $select = "pro_id, pro_name, pro_user_up, pro_user_modified, pro_order, up_date, pro_dir, pro_image, pro_begindate, pro_enddate, pro_status, is_product_affiliate, pro_view, pro_cost, pro_instock, pro_saleoff_value, pro_type_saleoff, pro_order, cat_name";
        $where .= "pro_user = $parent_id AND pro_type = $pro_type AND pro_of_shop = 0";
        $join_1 = 'LEFT';
        $table_1 = 'tbtt_category';
        $on_1 = 'tbtt_product.pro_category = tbtt_category.cat_id';
        // $by = 'DESC';
        // $sort = 'pro_id';

        $domain = $this->shop_model->get("sho_link, domain", "sho_user = $parent_id");
        $domain = $this->buildLinkAF($domain->sho_link, $domain->domain);

        $data['product'] = $this->product_model->fetch_join($select, $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, "", "", "", $where, $sort, $by, $start, $limit_data);
        $data['totalRecord'] = count($data['product']);
        $data['product'] = array_slice($data['product'], $offset, $limit);
        foreach ($data['product'] as $key => $item) {
            if ($item->pro_user_up > 0) {
                $data['product'][$key]->pro_user_up_by = $this->user_model->get('use_fullname', 'use_id = ' . $item->pro_user_up)->use_fullname;
            } else {
                $data['product'][$key]->pro_user_up_by = 'Shop tự đăng';
            }
            if ($item->pro_user_modified > 0) {
                $data['product'][$key]->pro_user_modified = $this->user_model->get('use_fullname', 'use_id = ' . $item->pro_user_modified)->use_fullname;
            }
            $data['product'][$key]->src_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/' . explode(',', $item->pro_image)[0];
            $data['product'][$key]->link_GH = $domain;

            $data['product'][$key]->stt = $offset + 1;
            $offset++;
        }

        /////////////////paging/////////////////////////
        $this->load->library('pagination');
        $config['total_rows'] = $data['totalRecord'];
        $config['base_url'] = $config_baseurl;
        $config['first_url'] = '1';
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = true;
        $config['uri_segment'] = $config_uri_segment;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $data['flash_msg_error'] = $this->session->flashdata('checkConfigBranch');

        $this->load->view($viewload, $data);
    }

/////////////////Fuction use validate/////////////////
    function _is_phone($str)
    {
        if ($this->check->is_phone($str)) {
            return true;
        }
        return false;
    }

    function _exist_username_use_phone()
    {
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }
    function _exist_province($str)
    {
        if (count($this->province_model->get("pre_id", "pre_id != 1 AND pre_status = 1 AND pre_id = " . (int)$str)) == 1) {
            return true;
        }
        return false;
    }
    function _exist_district($str)
    {
        if (count($this->district_model->find_by(array('DistrictCode' => $str), 'DistrictCode'))) {
            return true;
        }
        return false;
    }
//////////////////////////////////////////////////////////////
////////////Fuction Process Data/////////////////////////////
    function buildLinkAF($subDomain, $domain)
    {
        $result = '';
        if (!empty($domain)) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $result = $protocol . $domain;
        } else {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $result = $protocol . $subDomain . '.' . $_SERVER['HTTP_HOST'];
        }
        return $result;
    }
}
?>