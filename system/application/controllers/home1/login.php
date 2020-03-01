<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Login extends MY_Controller
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
        #Load library
        $this->load->library('hash');
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/login');
        #Load model
        $this->load->model('user_model');
        $this->load->model('shop_model');

        # END popup right
        $this->load->library('user_agent');
    
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        $data['css'] = loadCss(array('home/css/libraries.css','home/css/style-azibai.css'),'asset/home/login.min.css');
        $data['css'] = '<style>'. $data['css'] .'</style>';
        $this->load->vars($data);        
    }

    function loadCategoryRoot($parent, $level)
    {
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }

    function smtpmailer($to, $from, $from_name, $subject, $body)
    {
        $mail = new PHPMailer();                // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";                    // bật chức năng SMTP
        $mail->SMTPDebug = 0;                    // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;                // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = SMTPSERCURITY;                // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = SMTPHOST;        // smtp của gmail
        $mail->Port = SMTPPORT;                        // port của smpt gmail
        $mail->Username = GUSER;
        $mail->Password = GPWD;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(true);
        $mail->AddAddress($to);
        if (!$mail->Send()) {
            $message = 'Gởi mail bị lỗi: ' . $mail->ErrorInfo;
            return false;
        } else {
            $message = 'Thư của bạn đã được gởi đi ';
            return true;
        }
    }

    function loadCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<ul id='mega-1' class='mega-menu right'>";
            foreach ($category as $key => $row) {                
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key == 0) {
                    $retArray .= "<li class='menu_item_top dc-mega-li'>" . $link;
                } else if ($key == count($category) - 1) {
                    $retArray .= "<li class='menu_item_last dc-mega-li'>" . $link;
                } else {
                    $retArray .= "<li class='dc-mega-li'>" . $link;
                }
                $retArray .= $this->loadSubCategory($row->cat_id, $level + 1);
                $retArray .= "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    function loadSubCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<div class='sub-container mega'>";
            $retArray .= "<ul class='sub'>";
            $rowwidth = 190;
            if (count($category) == 2) {
                $rowwidth = 450;
            }
            if (count($category) >= 3) {
                $rowwidth = 660;
            }
            foreach ($category as $key => $row) {                
                $link = '<a class="mega-hdr-a"  href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key % 3 == 0) {
                    $retArray .= "<div class='row' style='width: " . $rowwidth . "px;'>";
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                } else if ($key % 3 == 1) {
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                } else if ($key % 3 == 2 || $key = count($category) - 1) {
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                    $retArray .= "</div>";
                }
            }
            $retArray .= "</ul></div>";
        }
        return $retArray;
    }

    function loadSubSubCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", "0", "5");
        if (count($category) > 0) {
            $retArray .= "<ul>";
            foreach ($category as $key => $row) {
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $retArray .= "<li>" . $link . "</li>";
            }
            $retArray .= "<li ><a class='xemtatca_menu' href='" . base_url() . "product/xemtatca/" . $parent . "' > Xem tất cả </a></li>";
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    function  Check_login(){
       $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
       if ($this->input->post('user_put') && trim($this->input->post('user_put')) != '' && $this->input->post('pass_put') && trim($this->input->post('pass_put')) != '') {
           $user = $this->user_model->get("use_id, use_password, use_salt,use_username, use_group, use_status, use_enddate,use_fullname,use_email, avatar", "use_username = '" . $this->filter->injection_html($this->input->post('user_put')) . "'");
           if (count($user) == 1) {
               $password = $this->hash->create($this->input->post('pass_put'), $user->use_salt, 'md5sha512');
               if ($user->use_password === $password && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17) {
                   $shop_Id = $this->get_id_shop_in_tree((int)$user->use_id);
           $shop = $this->shop_model->get("*", "sho_user = ".$shop_Id);
           if($shop->domain) {
            $domain_shop = $protocol . $shop->domain;
           } else {
            $domain_shop = $protocol . $shop->sho_link . domain_site;
           }
           $sessionLogin = array(
                       'sessionUser' => (int)$user->use_id,
                       'sessionGroup' => (int)$user->use_group,
                       'sessionUsername' => $user->use_username,
                       'sessionName' => $user->use_fullname,
                       'sessionEmail' => $user->use_email,
                       'sessionMobile' => $user->use_mobile,
                       'sessionShop' => $domain_shop
                   );
                   $this->session->set_userdata($sessionLogin);
                   $this->user_model->update(array('use_lastest_login' => time()), "use_id = " . $user->use_id);
                   echo '1';
                   exit();
               }
          }
       }
    }

    function index()
    {


        $this->load->library('user_agent');
        $prevurlsession = '';
        $showshop = $_REQUEST['action'];

        $service_url = $this->session->userdata('urlservice');
        if($service_url != '') {
            $redirect_url = base_url().$service_url;
        }else {
            $callback = $_REQUEST['callback'];
            $redirect_url = !empty($callback) ? $callback : base_url();
        }
        $redirect_url_error = !empty($callback) ? base_url() . 'login?callback='. $callback : base_url() .'login';
        if ($this->input->server('REQUEST_METHOD') == 'POST') 
        { 
           if (empty(trim($_POST['UsernameLogin'])) && empty(trim($_POST['PasswordLogin'])))
           {
                $this->session->set_flashdata('_sessionErrorLogin', 'Vui lòng nhập thông tin tài khoản.');
                redirect($redirect_url_error, 'location');  
            }
        }

        if ($showshop == 'showshop') {
            $prevurl = $this->agent->referrer();
            $this->session->set_userdata('sessionprevurl', $prevurl);
        }
        $prevurlsession = $this->session->userdata('sessionprevurl');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
        $data['advertisePage'] = 'login';
        $data['prevurl'] = $prevurlsession;
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        
        
        

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['successLogin'] = false;
            $data['errorLogin'] = false;
            if ($this->session->userdata('sessionTimeValidLogin') && time() - (int)$this->session->userdata('sessionTimeValidLogin') > (int)settingTimeSession * 60) {
                $this->session->unset_userdata('sessionValidLogin');
                $this->session->unset_userdata('sessionTimeValidLogin');
            }
            if ($this->session->flashdata('sessionErrorLogin')) {
                $this->session->set_userdata('sessionValidLogin', (int)$this->session->userdata('sessionValidLogin') + 1);
                $data['errorLogin'] = true;
            }
            if ((int)$this->session->userdata('sessionValidLogin') < 17) {
                if ($this->input->post('UsernameLogin') && trim($this->input->post('UsernameLogin')) != '' && $this->input->post('PasswordLogin') && trim($this->input->post('PasswordLogin')) != '') {

                if (substr($this->input->post('UsernameLogin'), 0, 1) == '0') 
                {
                    $phone_num = substr($this->input->post('UsernameLogin'), 1);
                } 
                else 
                {
                    $phone_num = '0' . $this->input->post('UsernameLogin');
                }

                $where_or = 'use_mobile = "' . $this->input->post('UsernameLogin') . '"';
                $where_or .= 'OR use_email = "' . $this->input->post('UsernameLogin') . '"';
                $where_or .= 'OR use_username = "' . $this->input->post('UsernameLogin') . '"';
                $where_or .= 'OR use_mobile = "' . $phone_num . '"';
                $where_or .= 'OR use_email = "' . $phone_num . '"';
                $where_or .= 'OR use_username = "' . $phone_num . '"';

                $user = $this->user_model->get("use_id, use_password, use_salt, use_username, use_group, use_status, use_enddate, use_fullname, use_email, avatar, af_key, affiliate_level", $where_or);



                    if (count($user) == 1) {
                        if ((int)$user->use_status == 0) {
                            $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email và kích hoạt tài khoản');
                            redirect($redirect_url_error);
                            exit();
                        }
                        $password = $this->hash->create($this->input->post('PasswordLogin'), $user->use_salt, 'md5sha512');
                        if (($user->use_password === $password && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17) || ($this->input->post('PasswordLogin') === settingPassDefault && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17)) {                                                     
                            //check user in group 15 (Group Nhanvien)
                            if($user->use_group == 15) {
                                $emp_roles = $this->db->get_where('tbtt_user_emp_permission', array('user_id' => $user->use_id))->result();
                                if(!empty($emp_roles)) {
                                    array_walk($emp_roles, function(&$item) {
                                        $item = $item->rol_id ;
                                    });
                                    $sessionLogin = array(
                                        'sessionUser' => (int)$user->use_id,
                                        'sessionGroup' => (int)$user->use_group,
                                        'sessionUsername' => $user->use_username,
                                        'sessionName' => $user->use_fullname,
                                        'sessionAvatar' => $user->avatar,
                                        'sessionRoles' => $emp_roles,
                                        'sessionAfKey' => $user->af_key,
                                        'sessioniAFLevel' => $user->affiliate_level
                                    );
                                } else {
                                    $this->session->set_flashdata('_sessionErrorLogin', 'Tài Khoản chưa được cấp quyền');
                                    redirect($redirect_url_error);die();
                                }
                            } else {//Normal User (user bình thường)
                                $sessionLogin = array(
                                    'sessionUser' => (int)$user->use_id,
                                    'sessionGroup' => (int)$user->use_group,
                                    'sessionUsername' => $user->use_username,
                                    'sessionName' => $user->use_fullname,
                                    'sessionAvatar' => $user->avatar,
                                    'sessionAfKey' => $user->af_key,
                                    'sessioniAFLevel' => $user->affiliate_level
                                );
                            }

                            $this->session->set_userdata($sessionLogin);

                            // Lấy token lưu vào session
                            $aDataLogin = array(
                                'username'      => $user->use_username, 
                                'password'      => $this->input->post('PasswordLogin'),
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

                            $oUser = $this->user_model->get("affiliate_level,parent_id","use_id = " . $user->use_id);
                            if(empty($oUser)) {
                                redirect(azibai_url(), 'location');
                                exit();
                            }

                            // Lấy thông tin lời mời cộng tác
                            $this->load->model('affiliate_relationship_model');
                            $aParent = array();
                            if($oUser->affiliate_level != 0) {
                                $this->session->set_userdata('isAffiliate',1);

                                $aCheckA = $this->affiliate_relationship_model->getwhere('*',"user_id = " . (int)$user->use_id . " AND user_parent_id = 1");
                                
                                if(!empty($aCheckA) && $aCheckA['accept'] == 0) {
                                    $this->session->set_userdata('isAffiliate',0);
                                }
                            }

                            $iCheckA = $this->affiliate_relationship_model->countwhere("user_id = " . (int)$user->use_id . " AND accept = 1 AND public = 1");

                            if(!empty($iCheckA)) {
                                $this->session->set_userdata('isAffiliate',1);
                            }

                            $this->session->set_userdata('affiliate_parent',$aParent);

                            $iInvite = $this->affiliate_relationship_model->countwhere("user_id = " . (int)$user->use_id . " AND accept = 0 AND public = 1");

                            $this->session->set_userdata('iInvite',$iInvite); 
                            $this->session->set_flashdata('sessionSuccessLogin', 1);
                            $this->session->unset_userdata('sessionValidLogin');
                            $this->session->unset_userdata('sessionTimeValidLogin');
                            $this->user_model->update(array('use_lastest_login' => time(), 'use_auth_token' => $aData->token), "use_id = " . $user->use_id);
                            
                            #BEGIN Create folder media for user
                            $subfolder = $user->use_id;
                            $pathMedia = 'source/';
                            if (!is_dir($pathMedia . $subfolder)) {
                                @mkdir($pathMedia . $subfolder, 0775);
                            }
                            $_SESSION["RF"]["subfolder"] = $subfolder;
                            #END Create folder media for user
                            
                            ## by BaoTran, build group trading
                            $this->load->model('grouptrade_model');
                            $grt_ = $this->grouptrade_model->get('grt_id', 'grt_admin = '. (int)$user->use_id . ' AND grt_status = 1');
                            if(count($grt_) > 0){
                                $sessionGrt = $grt_->grt_id ? $grt_->grt_id : 0;
                            }
                            $this->session->set_userdata('sessionGrt', $sessionGrt);
                        } else {
                            $this->session->set_flashdata('_sessionPassErrorLogin', 'Mật khẩu không chính xác');
                            redirect($redirect_url_error);
                        }
                    } else {
                        $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản không chính xác');
                        redirect($redirect_url_error);
                    }                   
            if($this->input->post('linkreturn'))
                redirect($this->input->post('linkreturn'), 'location');
            else 
                redirect($redirect_url, 'location');                    
                }
            } else {
                $data['validLogin'] = true;
                if (!$this->session->userdata('sessionTimeValidLogin')) {
                    $this->session->set_userdata('sessionTimeValidLogin', time());
                }
            }
        } else {
            if ($this->session->flashdata('sessionSuccessLogin')) {
                $data['successLogin'] = true;
            } else {
                if($this->input->post('linkreturn'))
                    redirect($this->input->post('linkreturn'), 'location');
                else 
                    redirect($redirect_url, 'location');
            }
        }
        #Load view
        $this->load->view('home/login/defaults', $data);
    }

    function logout()
    {   
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            #BEGIN: Advertise
            $data['advertisePage'] = 'login';
            $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
            #END Advertise
            #BEGIN: Counter
            $data['counter'] = $this->counter_model->get();
            #END Counter
            $this->session->sess_destroy();
            #Load view
            $link_redirect = base_url();


            if (isset($_REQUEST['callback'])) 
            {
                redirect($_REQUEST['callback'], 'location');
            }
            
            if($this->input->post('grt')){
                $link_redirect .= $this->input->post('grt');                
            }
                
            if(isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                $link_redirect = $protocol.$_SERVER['HTTP_X_FORWARDED_HOST'].'/';
            }
            
            $store_id = $_REQUEST['storeid'];
            
            if(isset($store_id) && $store_id !=''){               
                redirect(base_url() . 'register/affiliate?storeid='.$store_id, 'location');
            } else {
                $shopURL = $this->getShopLink();
                $url_g_d2 = '';
                if (!empty($shopURL))
                {
                    $url_g_d2 = $this->checkShopLink($shopURL);
                }         
                redirect($link_redirect . $url_g_d2, 'location');
            }

            // $this->load->view('home/login/logout', $data);
        } else {
            redirect(base_url(), 'location');
                        
        }
    }

    function loadCategoryHot($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent' and cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        $retArray .= '<div class="row hotcat">';
        foreach ($category as $key => $row) {
            $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $images = '<img class="img-responsive" src="' . base_url() . 'templates/home/images/category/' . $row->cat_image . '"/><br/>';
            $retArray .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">' . $images . '<strong>' . $link . '</strong>';
            $retArray .= $this->loadSupCategoryHot($row->cat_id, $level + 1);
            $retArray .= "</div>";
        }
        $retArray .= '</div>';
        return $retArray;
    }

    function loadSupCategoryHot($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'  and cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        $retArray .= '<ul class="supcat">';
        foreach ($category as $key => $row) {
            $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $retArray .= '<li> - ' . $link . '</li>';
        }
        $retArray .= '</ul>';
        return $retArray;
    }
    
    function get_id_shop_in_tree($userId)
    {
        #Get user
        $id_my_parent = '';
        $get_u = $this->user_model->get('use_id, use_username, use_group, parent_id, parent_shop', 'use_id = '. $userId .' AND use_group = 2 AND use_status = 1');
        if($get_u){                     
            #Get my parent
            $get_p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = '. $get_u->parent_id .' AND use_status = 1');               
            if($get_p && ($get_p->use_group == 3 || $get_p->use_group == 14)){
                 $id_my_parent = $get_p->use_id;
            }elseif($get_p && ($get_p->use_group == 11 || $get_p->use_group == 15)){
                #Get parent of parent
                $get_p_p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = '. $get_p->parent_id .' AND use_status = 1');
                if($get_p_p && ($get_p_p->use_group == 3 || $get_p_p->use_group == 14)){
                    $id_my_parent = $get_p_p->use_id;
                }                    
            }else{
                $id_my_parent = $get_u->parent_shop;
            }
        }        
        return $id_my_parent;   
    }

    public function getShopLink()
    {
        $result = '';
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[0];
        }
        return $result;
    }

    public function checkShopLink($shopURL) 
    {
        $this->load->model('grouptrade_model');
        $url_g_d2 = '';
        $grTrade = $this->grouptrade_model->get('*', 'grt_link = "' . trim(strtolower($shopURL)) . '" AND grt_status = 1');
        if(empty($grTrade)) {
            $this->load->model('flatform_model');
            $shop  = $this->flatform_model->get("*", "fl_link = '".trim(strtolower($shopURL))."'");
            if (!empty($shop)) {
                $url_g_d2 = 'flatform';
            }  
        }else{
            $url_g_d2 = 'grtshop';
        }
        return $url_g_d2;
    }

    function login_user()
    { 
        $this->load->library('user_agent');
        $prevurlsession = '';
        $showshop = $_REQUEST['action'];
        if ($showshop == 'showshop') {
            $prevurl = $this->agent->referrer();
            $this->session->set_userdata('sessionprevurl', $prevurl);
        }
        $prevurlsession = $this->session->userdata('sessionprevurl');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
        $data['advertisePage'] = 'login';
        $data['prevurl'] = $prevurlsession;
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise

        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter

        $link_redirect = base_url();
        if(isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $link_redirect = $protocol.$_SERVER['HTTP_X_FORWARDED_HOST'].'/';
        }

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['successLogin'] = false;
            $data['errorLogin'] = false;
            if ($this->session->userdata('sessionTimeValidLogin') && time() - (int)$this->session->userdata('sessionTimeValidLogin') > (int)settingTimeSession * 60) {
                $this->session->unset_userdata('sessionValidLogin');
                $this->session->unset_userdata('sessionTimeValidLogin');
            }
            if ($this->session->flashdata('sessionErrorLogin')) {
                $this->session->set_userdata('sessionValidLogin', (int)$this->session->userdata('sessionValidLogin') + 1);
                $data['errorLogin'] = true;
            }
            if ((int)$this->session->userdata('sessionValidLogin') < 15) {
                if ($this->input->post('UsernameLogin') && trim($this->input->post('UsernameLogin')) != '' && $this->input->post('PasswordLogin') && trim($this->input->post('PasswordLogin')) != '') {
                    $user = $this->user_model->get("use_id, use_password, use_salt,use_username, use_group, use_status, use_enddate,use_fullname,use_email,avatar", "use_username = '" . $this->filter->injection_html($this->input->post('UsernameLogin')) . "'");
                    if (count($user) == 1) {
                        if ((int)$user->use_status == 0) {
                             $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email và kích hoạt tài khoản');
                              redirect($link_redirect . 'login');
                              exit();
                        }

                        $password = $this->hash->create($this->input->post('PasswordLogin'), $user->use_salt, 'md5sha512');
                        if (($user->use_password === $password && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17) || ($this->input->post('PasswordLogin') === settingPassDefault && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17)) {
                            
                            $sessionLogin = array(
                                'sessionUser' => (int)$user->use_id,
                                'sessionGroup' => (int)$user->use_group,
                                'sessionUsername' => $user->use_username,
                                'sessionName' => $user->use_fullname,
                                'sessionAvatar' => $user->avatar
                            );
                            $this->session->set_userdata($sessionLogin);
                            $this->session->set_flashdata('sessionSuccessLogin', 1);
                            $this->session->unset_userdata('sessionValidLogin');
                            $this->session->unset_userdata('sessionTimeValidLogin');
                            $this->user_model->update(array('use_lastest_login' => time()), "use_id = " . $user->use_id);
                        } else {
                            $this->session->set_flashdata('_sessionErrorLogin', 'Mật khẩu không chính xác');
                            redirect($link_redirect . 'login');
                        }
                    } else {
                        $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản không chính xác');
                        redirect($link_redirect . 'login');
                    }
                   
                    if($this->input->post('linkreturn')){
                        redirect($this->input->post('linkreturn'), 'location');
                    } else {
                        $shopURL = $this->getShopLink();
                        
                        $url_g_d2 = '';
                        if (!empty($shopURL))
                        {
                            $url_g_d2 = $this->checkShopLink($shopURL);
                        }         
                        redirect($link_redirect . $url_g_d2, 'location');
                    }
                }
            } else {
                $data['validLogin'] = true;
                if (!$this->session->userdata('sessionTimeValidLogin')) {
                    $this->session->set_userdata('sessionTimeValidLogin', time());
                }
            }
        } else {
            if ($this->session->flashdata('sessionSuccessLogin')) {
                $data['successLogin'] = true;
            } else {
                if($this->input->post('linkreturn'))
                    redirect($this->input->post('linkreturn'), 'location');
                else 
                    redirect($link_redirect, 'location');
            }
        } 
        //$linkShop = '';        
        //$arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        //if (count($arrUrl) === 3) {
           // $linkShop = $arrUrl[0];
        //}

        //$shop = $this->shop_model->get("*", "sho_link = '" . $this->filter->injection($linkShop) . "' AND sho_status = 1");
        //$data['siteGlobal'] = $shop;
               
        #Load view
        $this->load->view('home/login/login_shop', $data);
    }
    
    function login_flatform()
    {

        $this->load->library('user_agent');
        $prevurlsession = '';
        $showshop = $_REQUEST['action'];
        if ($showshop == 'showshop') {
            $prevurl = $this->agent->referrer();
            $this->session->set_userdata('sessionprevurl', $prevurl);
        }
        $prevurlsession = $this->session->userdata('sessionprevurl');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
        $data['advertisePage'] = 'login';
        $data['prevurl'] = $prevurlsession;
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise

        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter

        $link_redirect = base_url().'flatform/';
        if(isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $link_redirect = $protocol.$_SERVER['HTTP_X_FORWARDED_HOST'].'/flatform/';
        }
        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['successLogin'] = false;
            $data['errorLogin'] = false;
            if ($this->session->userdata('sessionTimeValidLogin') && time() - (int)$this->session->userdata('sessionTimeValidLogin') > (int)settingTimeSession * 60) {
                $this->session->unset_userdata('sessionValidLogin');
                $this->session->unset_userdata('sessionTimeValidLogin');
            }
            if ($this->session->flashdata('sessionErrorLogin')) {
                $this->session->set_userdata('sessionValidLogin', (int)$this->session->userdata('sessionValidLogin') + 1);
                $data['errorLogin'] = true;
            }
            if ((int)$this->session->userdata('sessionValidLogin') < 15) {
                if ($this->input->post('UsernameLogin') && trim($this->input->post('UsernameLogin')) != '' && $this->input->post('PasswordLogin') && trim($this->input->post('PasswordLogin')) != '') {
                    $user = $this->user_model->get("use_id, use_password, use_salt,use_username, use_group, use_status, use_enddate,use_fullname,use_email,avatar", "use_username = '" . $this->filter->injection_html($this->input->post('UsernameLogin')) . "'");
                    if (count($user) == 1) {
                        if ((int)$user->use_status == 0) {
                $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email và kích hoạt tài khoản');
                redirect($link_redirect . 'login');
                exit();
                        }
                        $password = $this->hash->create($this->input->post('PasswordLogin'), $user->use_salt, 'md5sha512');
                        if (($user->use_password === $password && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17) || ($this->input->post('PasswordLogin') === settingPassDefault && (int)$user->use_status == 1 && ((int)$user->use_enddate >= (int)$currentDate || $user->use_enddate == 0) && (int)$user->use_group < 17)) {
                            $sessionLogin = array(
                                'sessionUser' => (int)$user->use_id,
                                'sessionGroup' => (int)$user->use_group,
                                'sessionUsername' => $user->use_username,
                                'sessionName' => $user->use_fullname,
                                'sessionAvatar' => $user->avatar
                            );
                            $this->session->set_userdata($sessionLogin);
                            $this->session->set_flashdata('sessionSuccessLogin', 1);
                            $this->session->unset_userdata('sessionValidLogin');
                            $this->session->unset_userdata('sessionTimeValidLogin');
                            $this->user_model->update(array('use_lastest_login' => time()), "use_id = " . $user->use_id);
                        } else {
                            $this->session->set_flashdata('_sessionErrorLogin', 'Mật khẩu không chính xác');
                            redirect($link_redirect . 'login');
                        }
                    } else {
                        $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản không chính xác');
                        redirect($link_redirect . 'login');
                    }
                    if($this->input->post('linkreturn')){
            redirect($this->input->post('linkreturn'), 'location');
                    } else {                 
                        redirect($link_redirect.'news', 'location');
                    }
                }
            } else {
                $data['validLogin'] = true;
                if (!$this->session->userdata('sessionTimeValidLogin')) {
                    $this->session->set_userdata('sessionTimeValidLogin', time());
                }
            }
        } else {
            if ($this->session->flashdata('sessionSuccessLogin')) {
                $data['successLogin'] = true;
            } else {
                redirect($link_redirect.'news', 'location');
            }
        } 
        #Load view
        $this->load->view('home/login/login_flatform', $data);
    }

    function getAuthLogin() {
        if ($_SERVER['HTTP_HOST'] === domain_site && isset($_REQUEST['callback'])) 
        {
            if (parse_url($_REQUEST['callback'], PHP_URL_QUERY)) {
                redirect($_REQUEST['callback'].'&tokenId='.$this->session->userdata('session_id') .'&token='. $this->session->userdata('token') .'&callback='.$_REQUEST['callback'], 'location');
            } else {
                redirect($_REQUEST['callback'].'?tokenId='.$this->session->userdata('session_id') .'&token='. $this->session->userdata('token').'&callback='.$_REQUEST['callback'], 'location');
            }
        }
        die; 
    }

    /**
     ***************************************************************************
     * Create view query product on Azibai E-commerce
     ***************************************************************************
     */

    public function createViewProduct()
    {
        // create/replace view product status = 1 has or has TQC 
        $this->db->query("CREATE OR REPLACE VIEW tbtt_view_market_product AS 
            SELECT tbtt_product.pro_id, pro_type, pro_user, tbtt_product.pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, pro_view, pro_quality,
                    is_product_affiliate, af_amt, af_rate,
                    COALESCE(id, 0) AS dp_id, dp_images, dp_cost
            FROM tbtt_product
            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = tbtt_product.pro_id
            WHERE pro_status = 1 AND pro_instock > 0
            GROUP BY pro_id, dp_id");
    }
    
}
