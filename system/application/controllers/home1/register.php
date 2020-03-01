<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Register extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        #CHECK SETTING
        define( 'DS', DIRECTORY_SEPARATOR );

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
        $this->load->model('user_emp_role_model');

        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        if($this->session->userdata('sessionUser')){
            $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            $data['currentuser'] = $cur_user;

            if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2){
            $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
            } else {
            $parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
            $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
            }
        }
        $css = loadCss(array('home/css/libraries.css', 'home/css/style-azibai.css','home/js/jAlert-master/jAlert-v3.css'), 'asset/home/register.min.css');
        $data['css'] = '<style>' . $css . '</style>';
        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }

    function loadSubdata()
    {        
        #BEGIN Eye
        // if ($this->session->userdata('sessionUser') > 0) {
        //     $this->load->model('eye_model');
        //     $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
        //     $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
        //     $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));
        // } else {
        //     array_values($this->session->userdata['arrayEyeSanpham']);
        //     array_values($this->session->userdata['arrayEyeRaovat']);
        //     array_values($this->session->userdata['arrayEyeHoidap']);
        //     $this->load->model('eye_model');
        //     $data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');
        //     $data['listeyeraovat'] = $this->eye_model->geteyetypenologin('raovat');
        //     $data['listeyehoidap'] = $this->eye_model->geteyetypenologin('hoidap');
        // }
        #END Eye
        #BEGIN: Ads & Notify Taskbar
        $this->load->model('ads_model');
        $this->load->model('notify_model');
        $data['menuType'] = 'product';
        $retArray = $this->loadCategory(0, 0);
        $data['menu'] = $retArray;
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;
        // $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        //fix tam
        $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;
        // $data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
        // $data['productCategoryHot'] = $this->loadCategoryHot(0, 0);
        # BEGIN popup right
        # Tin tức

        $select = "not_id, not_title, not_image,not_dir_image, not_begindate";
        $data['listNews'] = $this->content_model->fetch($select, "not_status = 1 AND cat_type = 1", "not_id", "DESC", 0, 10);
        $this->load->model('product_favorite_model');
        # Hàng yêu thích
        $select = 'prf_id, prf_product, prf_user, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost ';
        $join = 'INNER';
        $table = 'tbtt_product';
        $on = 'tbtt_product_favorite.prf_product = tbtt_product.pro_id';
        // $where = 'prf_user = ' . $this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0;
        $where = '';
        $data['favoritePro'] = $this->product_favorite_model->fetch_join($select, $join, $table, $on, $where, 0, 10);
        # Hàng gợi ý
        $select = "pro_id, pro_name, pro_cost, pro_image, pro_dir,pro_category, ";
        $whereTmp = "pro_status = 1  and is_asigned_by_admin = 1";
        $products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC", 0, 10);
        $data['products'] = $products;
        # END popup right
        #BEGIN:GET PACKAGE
        $data['sho_package'] = $this->package_user_model->getCurrentPackage($this->session->userdata('sessionUser'));
        #END:GET PACKAGE
        #BEGIN:GET WALLET

        $data['wallet_info'] = $this->wallet_model->getSumWallet(array('user_id' => $this->session->userdata('sessionUser')), 1);
        #END:GET WALLET
    
        #Load menu cho Chi nhanh theo GH cha cua no, Quan Ly Nhan Vien
        // if ($this->session->userdata('sessionGroup') == BranchUser) {
        //     $UserID = (int)$this->session->userdata('sessionUser');
        //     $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
        //     $u_pa1 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $u_pa->parent_id . " AND use_status = 1");
        //     if ($u_pa) {
        //         $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
        //         if ($u_pa1->use_group == StaffStoreUser) {
        //             $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa1->parent_id);
        //         }
        //     }
        // }

        $cur_user = $this->user_model->get('use_id, use_username, avatar', 'use_id = ' . (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
        $data['currentuser'] = $cur_user;
        $data['mainURL'] = $this->getMainDomain();
        return $data;
    }

    function discovery()
    {
        #Load view
        $this->load->view('home/register/discovery', $data);
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
                //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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
                //$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
                $link = '<a class="mega-hdr-a" alt="' . $row->cat_name . '" href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
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
                //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $retArray .= "<li>" . $link . "</li>";
            }
            $retArray .= "<li ><a class='xemtatca_menu' href='" . base_url() . "product/xemtatca/" . $parent . "' > Xem tất cả </a></li>";
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    function ajax_category_shop()
    {
        $this->load->model('shop_category_model');
        $parent_id = (int)$this->input->post('parent_id');
        $cat_level = $this->shop_category_model->fetch("*", "parent_id = " . $parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
        if (isset($cat_level)) {
            foreach ($cat_level as $key => $item) {
                $cat_level_next = $this->shop_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                $cat_level[$key]->child_count = count($cat_level_next);
            }
        }
        echo "[" . json_encode($cat_level) . "," . count($cat_level) . "]";
        exit();
    }

    function index()
    {
        // Get param
        $iGroup     = $this->session->userdata('sessionGroup');
        $sAction    =  $this->uri->segment(2);

        $aGroup1 = array(
                    StaffStoreUser,
                    AffiliateStoreUser,
                    Developer2User,
                    Developer1User,
                    Partner2User,
                    Partner1User,
                    CoreMemberUser,
                    CoreAdminUser
                );

        $data = $this->loadSubdata();
        $user = $this->uri->segment(4);
        $data['idAf'] = $this->uri->segment(4);
        $currentDate_Pre = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->uri->segment(1) == 'register' && $this->session->userdata('sessionUser') > 0 && $this->uri->segment(2) != 'affiliate' && $this->uri->segment(2) != 'estore') {
            redirect(base_url() . "account", 'location'); die;
        }

        $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser') . ' AND sho_status = 1');
        if ((count($shop) > 0 && $shop->sho_name != '' && $shop->sho_address != ''
            && $shop->sho_kho_address != '' && $shop->sho_kho_district != ''
            && $shop->sho_kho_province != '' && (in_array($this->uri->segment(2), array('estore', 'staffs', 'addbranch')))) || $user != '') {
        } else {
            $this->session->set_flashdata('flash_message', 'Bạn phải cập nhật đầy đủ thông tin cần thiết của gian hàng ( được đánh dấu * ) để thực hiện những chức năng khác');
            redirect(base_url() . "account/shop", 'location'); die;
        }
        
        //Kiem tra link dang ky Aff tư link GH
        if ($user > 0) {
            //TH GH khong con hoat dong, status = 0
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$user . ' AND sho_status = 1');
            if (count($shop) == 0) {
                $data['shopactive'] = 1;
            }
        }
        
        // gioi thieu thanh vien gian hang affiliate
        if ($this->uri->segment(2) == 'estore') {
            if ($this->session->userdata('sessionUser') > 0) {
                redirect(base_url() . "account", 'location');
            }
        }

        // yeu cau tao nhan vien
        if ($this->uri->segment(2) == 'staffs') {
            if ($this->session->userdata('sessionUser') <= 0) {
                redirect(base_url() . "login", 'location'); die;
            } else {
                $data['sho_package'] = $this->package_user_model->getCurrentPackage((int)$this->session->userdata('sessionUser'));
                if ($this->session->userdata('sessionGroup') == StaffStoreUser ||
                    $this->session->userdata('sessionGroup') == AffiliateStoreUser ||
                    $this->session->userdata('sessionGroup') == Developer2User ||
                    $this->session->userdata('sessionGroup') == Developer1User ||
                    $this->session->userdata('sessionGroup') == Partner2User ||
                    $this->session->userdata('sessionGroup') == Partner1User ||
                    $this->session->userdata('sessionGroup') == CoreMemberUser ||
                    $this->session->userdata('sessionGroup') == CoreAdminUser ||
                    $this->session->userdata('sessionGroup') == BranchUser) {
                } else {
                    redirect(base_url() . "account", 'location'); die;
                }
            }
        }

        //Yêu cầu tạo Chi Nhánh
        if ($sAction == 'addbranch') {
            if ($this->session->userdata('sessionUser') <= 0) {
                redirect(base_url() . "login", 'location'); die;
            } else {                
                if (in_array ($iGroup, $aGroup1)) {                  
                    //Kiểm tra GH có sử dụng gói DV mở CN hay không?
                    $shop_id = (int)$this->session->userdata('sessionUser');
                    if ($this->session->userdata('sessionGroup') == StaffStoreUser) {
                        $get_parent_id = $this->user_model->get_list_user("parent_id", "use_status = 1 AND use_id = '" . (int)$this->session->userdata('sessionUser') . "'");
                        $shop_id = $get_parent_id[0]->parent_id;
                    }
                    
                    $result = $this->package_user_model->getPackageCreateBranch($shop_id);
                    if ($result) {
                        //Lấy tổng số CN hiện có của GH
                        $bran_gh = $this->user_model->get_list_user("use_id", "use_group = 14 AND use_status = 1 AND parent_id = '" . $shop_id . "'");
                        $nvgh = $this->user_model->get_list_user("use_id", "use_group = 15 AND use_status = 1 AND parent_id = '" . $shop_id . "'");
                        $dembranNVGH = 0;
                        $id_nvgh = array();
                        if (!empty($nvgh)) {
                            for ($i = 0; $i < count($nvgh); $i++) {
                                array_push($id_nvgh, $nvgh[$i]->use_id);
                            }
                            $bran_nvgh = $this->user_model->get_list_user("use_id", "use_group = 14 AND use_status = 1 AND parent_id In(" . implode($id_nvgh, ',') . ")");
                            $dembranNVGH = count($bran_nvgh);
                        }
                        $total_bran = count($bran_gh) + $dembranNVGH;
                        $tong_cn = 0;
                        if ($total_bran) {
                            $tong_cn = $total_bran;
                        }
                        $total_limit = 0;
                        foreach ($result as $key => $value) {
                            $total_limit += $value->limited;
                        }
                        //Nếu GH mua gói DV mở CN
                        if ($tong_cn < $total_limit) {
                        } else {
                            $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ mở được tối đa ' . $total_limit . ' Chi nhánh.');
                            redirect(base_url() . 'account/listbranch', 'location'); die;
                        }
                    } else {
                        //Nếu không có, thông báo không cho mở, và tạo link mua gói DV này
                        $this->session->set_flashdata('flash_message_error', 'Gian hàng của bạn hiện không sử dụng dịch vụ mở Chi nhánh. Hãy click <a href="' . base_url() . 'account/service">vào đây</a> để mua!');
                        redirect(base_url() . 'account/listbranch', 'location'); die;
                    }

                } else {
                    redirect(base_url() . "account", 'location'); die;
                }
            }
        }

        // yeu cau tao thanh vien
        if ($this->uri->segment(2) == 'tree') {
            if ($this->session->userdata('sessionUser') <= 0) {
                redirect(base_url() . "login", 'location'); die;
            } else {
                if ($this->session->userdata('sessionGroup') == Developer2User ||
                    $this->session->userdata('sessionGroup') == Developer1User ||
                    $this->session->userdata('sessionGroup') == Partner2User ||
                    $this->session->userdata('sessionGroup') == Partner1User ||
                    $this->session->userdata('sessionGroup') == CoreMemberUser ||
                    $this->session->userdata('sessionGroup') == CoreAdminUser) {
                } else {
                    redirect(base_url() . "account", 'location'); die;
                }
            }
        }

        // Yeu cau tao nhan vien Gian Hang
        if ($this->uri->segment(2) == 'addstaffstore') {
            if ($this->session->userdata('sessionUser') <= 0) {
                redirect(base_url() . "login", 'location'); die;
            } else {
                if ($this->session->userdata('sessionGroup') == AffiliateStoreUser ||
                    $this->session->userdata('sessionGroup') == Developer2User ||
                    $this->session->userdata('sessionGroup') == Developer1User ||
                    $this->session->userdata('sessionGroup') == Partner2User ||
                    $this->session->userdata('sessionGroup') == Partner1User ||
                    $this->session->userdata('sessionGroup') == CoreMemberUser ||
                    $this->session->userdata('sessionGroup') == CoreAdminUser) {
                } else {
                    redirect(base_url() . "account", 'location'); die;
                }
            }
        }

        $page = $this->uri->segment(2);
        $disableMail = 0;
        $data['menuPanelGroup'] = 4;
        if ($page == 'staffs') {
            $disableMail = 1;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'task';
        }

        if ($page == 'tree') {
            $disableMail = 1;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'tree';
        }

        if ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request' && $this->uri->segment(4) == 'member') {
            $disableMail = 0;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'tree';
        }

        if ($this->uri->segment(2) == 'addbranch') {
            $disableMail = 0;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'chinhanh';
        }

        if ($this->uri->segment(2) == 'addstaffstore') {
            $disableMail = 0;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'staffstore';
        }

        if ($this->uri->segment(2) == 'addsubadmin') {
            $disableMail = 1;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'hanhchinh';
        }

        // luu ma nguoi gioi thieu 30 ngay
        if ($this->uri->segment(3) == 'pid') {
            setcookie("pid", $this->uri->segment(4), time() + (86400 * 30), '/'); // 86400 = 1 day
        }

        $this->load->helper('cookie');
        if ($this->uri->segment(2) == 'estore' || $this->uri->segment(2) == 'affiliate' || (int)$this->input->cookie('pid') > 0) {
            $data['register_estore'] = 0;
        } else {
            $data['register_estore'] = 0;
        }

        if ($this->uri->segment(2) == 'afstore') {
            $data['register_estore'] = 0;
        }

        $pid = 0;
        if ((int)$this->uri->segment(4) > 0) {
            $select = "*";
            $parentuser = $this->user_model->get($select, "use_id = " . $user);
            $parent_staff = $this->shop_model->get($select, "sho_user = " . $parentuser->parent_id);
            $categoryy = $this->shop_model->get($select, "sho_user = " . $user);
            if ($categoryy->sho_status == 1 && $this->uri->segment(2) == 'affiliate' || $parentuser->use_group == 11 && $parent_staff->sho_status == 1) {
                $pid = $this->uri->segment(4);
            }
        } else {
            $pid = (int)$this->input->cookie('pid');
        }

        // tạo nhân viên        
        $store_id = (int)$this->input->post('storeid');
        if ($pid > 0) {
            $p_user = $this->user_model->get('use_id', 'use_status = 1 AND use_id = ' . $pid);
            if (count($p_user) <= 0) {
                $pid = 0;
            }
        }

        if (isset($store_id) && $store_id > 0) {
            $data['users'] = $this->user_model->get("*", "use_id = " . $store_id);
            if ($data['users']->user_district && count($data['users']->user_district) > 0) {
                $data['district'] = $this->district_model->find_by("DistrictCode = " . $data['users']->user_district);
            } else {
                redirect(base_url(), 'location'); die;
            }
        }

        #BEGIN: Advertise
        $data['advertisePage'] = 'register';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position, adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise

        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter

        $this->load->model('shop_category_model');
        $cat_level_0 = $this->shop_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
        if (isset($cat_level_0)) {
            foreach ($cat_level_0 as $key => $item) {
                $cat_level_1 = $this->shop_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                $cat_level_0[$key]->child_count = count($cat_level_1);
            }
        }

        $data['catlevel0'] = $cat_level_0;
        $maxorder = $this->shop_category_model->get("max(cat_order) as maxorder");
        $data['next_order'] = (int)$maxorder->maxorder + 1;
        $maxindex = $this->shop_category_model->get("max(cat_index) as maxindex");
        $data['next_index'] = (int)$maxindex->maxindex + 1;

        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaRegister'));
        #END Unlink captcha

        if ((int)settingStopRegister == 1) {
            $data['stopRegister'] = true;
        } else {
            $data['stopRegister'] = false;
            $data['stopRegisterVip'] = false;
            $data['stopRegisterShop'] = false;
            $data['isActivation'] = false;
            $data['successSendActivation'] = false;
            if ((int)settingActiveAccount == 1) {
                $data['isActivation'] = true;
                if ($this->session->flashdata('sessionSuccessSendActivation')) {
                    $data['successSendActivation'] = true;
                }
            }
            if ($this->session->flashdata('sessionSuccessRegister')) {
                $data['successRegister'] = true;
            } else {
                $data['successRegister'] = false;
                if ((int)settingStopRegisterVip == 1) {
                    $data['stopRegisterVip'] = true;
                }
                if ((int)settingStopRegisterShop == 1) {
                    $data['stopRegisterShop'] = true;
                }
                #BEGIN: Fetch data                
                $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
                #END Fetch data
                $this->load->library('form_validation');
                // if ($this->input->post('captcha_regis')) {
                    $url1 = $this->uri->segment(1);
                    $url_affiliate = $this->uri->segment(2);
                    $url_afstore = $this->uri->segment(2);
                    $url_estore = $this->uri->segment(2);
                    $url_tree = $this->uri->segment(2);
                    $url_staff_add = $this->uri->segment(3);
                    $url_branch = $this->uri->segment(2);
                    $url_staffstore = $this->uri->segment(2);
                    if ($url1 != 'register' && $url1 != 'account' && $url_affiliate != 'staffs' && $url_staff_add != 'add' && $url_affiliate != 'affiliate' && $url_afstore != 'afstore' && $url_estore != 'estore' && $url_tree != 'tree' && $url_branch != 'addbranch' && $url_staffstore != 'addstaffstore') {
                        if ($this->uri->segment(2) != 'addsubadmin') {
                            $this->form_validation->set_rules('reemail_regis', 'lang:reemail_regis_label_defaults', 'trim|required|matches[email_regis]');
                        }
                        $this->form_validation->set_rules('fullname_regis', 'lang:fullname_regis_label_defaults', 'trim|required');
                        $this->form_validation->set_rules('address_regis', 'lang:address_regis_label_defaults', 'trim|required');
                    } else if ($url_afstore == 'afstore') {
                        $this->form_validation->set_rules('province_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_province');
                        $this->form_validation->set_rules('district_regis', 'lang:province_regis_label_defaults', 'required|callback__exist_district');
                    }
                    if ($url_affiliate == 'affiliate') {
                        $this->form_validation->set_rules('reemail_regis', 'lang:reemail_regis_label_defaults', 'trim|required|matches[email_regis]');
                    }
                    #BEGIN: Set rules
                    $this->form_validation->set_rules('username_regis', 'lang:username_regis_label_defaults', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
                    $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
                    if ($this->uri->segment(2) != 'addsubadmin') {
                        $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
                    }
                    $this->form_validation->set_rules('email_regis', 'lang:email_regis_label_defaults', 'trim|required|valid_email|callback__exist_email');
                    //$this->form_validation->set_rules('phone_regis', 'lang:phone_regis_label_defaults', 'trim|required|callback__is_phone');
                    $this->form_validation->set_rules('mobile_regis', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone');
                    //  $this->form_validation->set_rules('yahoo_regis', 'lang:yahoo_regis_label_defaults', 'trim|callback__valid_nick');
                    //  $this->form_validation->set_rules('skype_regis', 'lang:skype_regis_label_defaults', 'trim|callback__valid_nick');
                    // $this->form_validation->set_rules('captcha_regis', 'lang:captcha_regis_label_defaults', 'callback__valid_captcha');
                    #END Set rules
                    #BEGIN: Set message
                    $this->form_validation->set_message('required', $this->lang->line('required_message'));
                    $this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
                    $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                    $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                    $this->form_validation->set_message('matches', $this->lang->line('matches_message'));
                    $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
                    $this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_defaults'));
                    $this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_defaults'));
                    $this->form_validation->set_message('_exist_province', $this->lang->line('_exist_province_message'));
                    $this->form_validation->set_message('_exist_district', $this->lang->line('_exist_district_message'));
                    $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
                    $this->form_validation->set_message('_valid_nick', $this->lang->line('_valid_nick_message'));
                    // $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
                    $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
                    
                    #END Set message
                    if ($this->form_validation->run() != false) {
                        #BEGIN: Upload image
                        $this->load->library('upload');
                        $pathImage = "media/images/avatar/";
                        #Create folder
                        $image = '';
                        if (!is_dir($pathImage)) {
                            @mkdir($pathImage);
                            $this->load->helper('file');
                            @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                        }
                        $config['upload_path'] = $pathImage;
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['max_size'] = 2024;#KB
                        $config['max_width'] = 2024;#px
                        $config['max_height'] = 2024;#px
                        $config['encrypt_name'] = true;
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('avatar')) {
                            $uploadData = $this->upload->data();
                            if ($uploadData['is_image'] == true) {
                                $image = $uploadData['file_name'];
                                #BEGIN: Create thumbnail
                                $this->load->library('image_lib');
                                if (file_exists($pathImage . $image)) {
                                    $maxWidth = 120;#px
                                    $maxHeight = 120;#px
                                    $sizeImage = size_thumbnail($pathImage . $image, $maxWidth, $maxHeight);
                                    $configImage['source_image'] = $pathImage . $image;
                                    $configImage['new_image'] = $pathImage . 'thumbnail_' . $image;
                                    $configImage['maintain_ratio'] = true;
                                    $configImage['width'] = $sizeImage['width'];
                                    $configImage['height'] = $sizeImage['height'];
                                    $this->image_lib->initialize($configImage);
                                    $this->image_lib->resize();
                                }
                                #END Create thumbnail
                            } elseif (file_exists($pathImage . $uploadData['file_name'])) {
                                @unlink($pathImage . $uploadData['file_name']);
                            }
                        }
                        #END Upload image

                        $salt = $this->hash->key(8);
                        if ((int)$this->input->post('vip_regis') == 1) {
                            $group = 2;
                            $active = 0;
                            $enddate = 0;
                        } elseif ((int)$this->input->post('shop_regis') == 1) {
                            $group = 3;
                            $active = 0;
                            $enddate = 0;
                        } else {
                            $group = 1;
                            $active = 0;
                            if ((int)date('Y') < 2030) {
                                $enddate = 0;
                            } else {
                                $enddate = 0;
                            }
                        }
                        if ((int)settingActiveAccount == 1) {
                            $active = 0;
                        }
                        if ((int)$this->input->post('sex_regis') == 1) {
                            $sex_regis = 1;
                        } else {
                            $sex_regis = 0;
                        }

                        //thanh vien he thong tao thanh vien cap duoi
                        $parentID = 0;
                        if ((int)$this->input->post('group_regis') > 0 && ($this->session->userdata('sessionGroup') == Developer2User
                            || $this->session->userdata('sessionGroup') == Developer1User
                            || $this->session->userdata('sessionGroup') == Partner2User
                            || $this->session->userdata('sessionGroup') == Partner1User
                            || $this->session->userdata('sessionGroup') == CoreMemberUser
                            || $this->session->userdata('sessionGroup') == CoreAdminUser)) {
                            $group = $this->input->post('group_regis');
                            $parentID = $this->session->userdata('sessionUser');
                            $active = 0;
                        }

                        //Đăng ký Nhân Viên
                        if ($this->uri->segment(2) == 'staffs') {
                            $group = 11;
                            $parentID = $this->session->userdata('sessionUser');
                            if ($this->input->post("checkopenCN")) {
                                $group = 15;
                            }
                            $active = 1;
                        }

                        

                        //Đăng ký Chi Nhánh
                        if ($this->uri->segment(2) == 'addbranch') {
                            $parentID = $this->session->userdata('sessionUser');
                            $group = 14;
                            $active = 1;
                        }

                        //Lay User by ID
                        if ($this->uri->segment(4) != '' && $this->uri->segment(4) != 'member') {
                            $p_userddd = $this->user_model->get('use_id, use_group, parent_id, use_status', 'use_status = 1 AND use_id = ' . $this->uri->segment(4));
                        }

                        // dang ky gian hang từ link giới thiệu
                        if ($this->uri->segment(2) == 'estore') {
                            $pid = $this->uri->segment(4);
                            if ($pid > 0 && $p_userddd->use_group > 3) {
                                $parentID = $pid;
                                $group = 3;
                                $active = 0;
                            } else {
                                $parentID = 0;
                                $group = 3;
                                $active = 0;
                            }
                        }

                        if ($this->uri->segment(2) == 'tree' && $this->uri->segment(3) == 'request' && $this->uri->segment(4) == 'member') {
                            if ($this->input->post('treegroup') == Partner1User) {
                                $group = Partner1User;
                            } else if ($this->input->post('treegroup') == Partner2User) {
                                $group = Partner2User;
                            } else if ($this->input->post('treegroup') == Developer1User) {
                                $group = Developer1User;
                            } else if ($this->input->post('treegroup') == Developer1User) {
                                $group = Developer1User;
                            } else if ($this->input->post('treegroup') == Developer2User) {
                                $group = Developer2User;
                            } elseif ($this->input->post('treegroup') == CoreMemberUser) {
                                $group = CoreMemberUser;
                            }
                            $parentID = $this->session->userdata('sessionUser');
                        }

                        // dang ky affiliate
                        if ($this->uri->segment(2) == 'affiliate') {
                            $pid_af = (int)$this->uri->segment(4);
                            if ($pid_af != false && $pid_af != '' && !empty($p_userddd) && $p_userddd->use_status == 1) {
                                if ($p_userddd->use_group == AffiliateStoreUser || $p_userddd->use_group == BranchUser || $p_userddd->use_group == StaffStoreUser || $p_userddd->use_group == StaffUser) {
                                    $userID = $p_userddd->use_id;

                                    //==> Get ra ID của Công ty.
                                    switch ($p_userddd->use_group) {
                                        case StaffUser:
                                            $user_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $p_userddd->parent_id);
                                            $userID = $user_p->use_id;
                                            if ($user_p->use_group == BranchUser) {
                                                $user_p_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p->parent_id);
                                                $userID = $user_p_p->use_id;
                                                if ($user_p_p->use_group == StaffStoreUser) {
                                                    $user_p_p_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p_p->parent_id);
                                                    $userID = $user_p_p_p->use_id;
                                                }
                                            }

                                            break;

                                        case BranchUser:
                                            $user_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $p_userddd->parent_id);
                                            $userID = $user_p->use_id;
                                            if ($user_p->use_group == StaffStoreUser) {
                                                $user_p_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p->parent_id);
                                                $userID = $user_p_p->use_id;
                                            }

                                            break;

                                        case StaffStoreUser:
                                            $user_p = $this->user_model->get("use_id, use_group, parent_id", "use_status = 1 AND use_id = " . $p_userddd->parent_id);
                                            $userID = $user_p->use_id;

                                            break;

                                        default:
                                            break;
                                    }                                    
                                    //Get danh sách con trực tiếp của Công ty
                                    $li_sub1 = $this->user_model->fetch("use_id, use_username, use_group", "parent_id = " . $userID . " AND use_status = 1 AND use_group IN ('" . StaffUser . "','" . BranchUser . "','" . StaffStoreUser . "')");
                                    $tree = array();
                                    $li_tree = '0';
                                    if ($li_sub1) {
                                        foreach ($li_sub1 as $k1 => $liItem1) {
                                            $tree[] = $liItem1->use_id;
                                            if ($liItem1->use_group == BranchUser || $liItem1->use_group == StaffStoreUser) {
                                                $li_sub2 = $this->user_model->fetch("use_id, use_username, use_group", "parent_id = " . $liItem1->use_id . " AND use_status = 1 AND use_group IN ('" . StaffUser . "','" . BranchUser . "')");
                                                if ($li_sub2) {
                                                    foreach ($li_sub2 as $k2 => $liItem2) {
                                                        $tree[] = $liItem2->use_id;
                                                        if ($liItem2->use_group == BranchUser) {
                                                            $li_sub3 = $this->user_model->fetch("use_id, use_username, use_group", "parent_id = " . $liItem2->use_id . " AND use_status = 1 AND use_group = '" . StaffUser . "'");
                                                            if ($li_sub3) {
                                                                foreach ($li_sub3 as $k3 => $liItem3) {
                                                                    $tree[] = $liItem3->use_id;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                    #BEGIN:: Get Tổng số aff của toàn công ty
                                    $li_tree = implode(',', $tree);
                                    $total_aff_sub = 0;
                                    if ($tree && $li_tree != '') {
                                        //Lấy danh sách tổng aff của các chi nhánh con GH
                                        $total_aff_sub = count($this->user_model->fetch("use_id", "parent_id IN (" . $li_tree . ") AND use_group = 2 AND use_status = 1"));
                                        $total_aff_sub = $total_aff_sub ? $total_aff_sub : 0;
                                    }                                   
                                    //Lấy danh sách tổng aff của GH
                                    $total_aff_shop = count($this->user_model->fetch("use_id", "parent_id = " . $userID . " AND use_group = 2 AND use_status = 1"));
                                    $total_aff_shop = $total_aff_shop ? $total_aff_shop : 0;
                                    $total = $total_aff_shop + $total_aff_sub;
                                    #END:: Get Tổng số aff của toàn công ty

                                    #BEGIN:: Lấy Gói DV mà GH đang sử dụng
                                    $sho_package = $this->package_user_model->GetPackageValueshop($userID);
                                    #END:: Lấy Gói DV mà GH đang sử dụng
                                    #BEGIN:: Lấy Gói DV mà GH Mua thêm mở Cộng Tác Viên Online
                                    $sho_pack_ctv = $this->package_user_model->getPackageCreateCTVOnline($userID);
                                    $limit_pack_ctv = $sho_pack_ctv ? $sho_pack_ctv[0]->limit : 0;
                                    #END:: Lấy Gói DV mà GH Mua thêm mở Cộng Tác Viên Online                                   
                                    $total_limit = $sho_package->limit + $limit_pack_ctv;
                                    //Không giới hạn số Aff
                                    if ($sho_package->limit < 0 || $total_limit > $total) {
                                        $parentID = $pid_af;
                                    } else {
                                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn giới thiệu được ' . $total_limit . ' cộng tác viên Online. Click <a href="' . base_url() . 'account/service">vào đây</a> để mua.');
                                        redirect(base_url() . 'register/affiliate/pid/' . $pid_af, 'location');
                                    }
                                } else {
                                    $parentID = $pid_af;
                                }
                            }
                            $group = 2;
                            $active = 1;
                        }

                        // dang ky gian hang
                        if ($this->uri->segment(2) == 'afstore') {
                            $sponsorAF = $this->user_model->get("*", "use_username = '" . $this->filter->injection_html($this->input->post('sponsor')) . "' OR use_email = '" . $this->filter->injection_html($this->input->post('sponsor')) . "'");
                            $group = 3;
                            $active = 0;
                            if ($this->input->post('sponsor') != '' && $sponsorAF->use_group > 3 && $sponsorAF->use_status) {
                                $sponsorObject = $this->user_model->get("use_id, use_group, use_email", "use_username = '" . $this->filter->injection_html($this->input->post('sponsor')) . "' OR use_email = '" . $this->filter->injection_html($this->input->post('sponsor')) . "'");
                                if ($sponsorObject->use_id > 0) {
                                    $parentID = $sponsorObject->use_id;
                                }
                            } else {
                                $parentID = 0;
                            }
                        }

                        if ($this->uri->segment(2) == 'estore' || $this->uri->segment(2) == 'affiliate' || $this->uri->segment(2) == 'afstore') {
                            if ($this->input->post('idcard_regis') != '') {
                                $sponsorObject = $this->user_model->get("use_id, use_group, use_email, parent_id", "id_card = '" . $this->input->post('idcard_regis') . "' ");
                                if ($sponsorObject->parent_id > 0 && $p_userddd->use_group != 2) {
                                    $parentID = $sponsorObject->parent_id;
                                }
                            }
                        }

                        // get random parent id
                        // if ($parentID == 0 && $segment2 != '') {
                        if ($parentID == 0) {
                            $province_regis = $this->input->post('province_regis');
                            $district_regis = $this->input->post('district_regis');
                            $this->db->order_by('use_group', 'RANDOM');
                            $this->db->order_by('use_id', 'RANDOM');
                            $treeObject = $this->user_model->fetch("use_id, use_username, use_email", "use_status = 1 AND use_group IN (6,7,8,9,10) AND use_province = " . $province_regis . " AND user_district = '" . $district_regis . "'");
                            if ($treeObject[0]->use_id > 0) {
                                $parentID = $treeObject[0]->use_id;
                            } else {
                                if ($province_regis > 0) {
                                    $this->db->order_by('use_group', 'RANDOM');
                                    $this->db->order_by('use_id', 'RANDOM');
                                    $treeObject2 = $this->user_model->fetch("use_id, use_username, use_email", "use_status = 1 AND use_group IN (6,7,8,9,10) AND use_province = " . $province_regis . "");
                                    if ($treeObject2[0]->use_id > 0) {
                                        $parentID = $treeObject2[0]->use_id;
                                    } else {
                                        $this->db->order_by('use_group', 'RANDOM');
                                        $this->db->order_by('use_id', 'RANDOM');
                                        $treeObject3 = $this->user_model->fetch("use_id, use_username, use_email", "use_status = 1 AND use_group IN (6,7,8,9,10)");
                                        if ($treeObject3[0]->use_id > 0) {
                                            $parentID = $treeObject3[0]->use_id;
                                        }
                                    }
                                }
                            }
                        }

                        $parent_shop = 0;
                        if ($p_userddd->use_group == StaffUser || $p_userddd->use_group == BranchUser || $p_userddd->use_group == StaffStoreUser) {
                            $get_p = $this->user_model->get('use_id, use_group, parent_id, use_status', 'use_status = 1 AND use_id = ' . $p_userddd->parent_id);
                            $parent_shop = $get_p->use_id;
                        } else {
                            if($this->uri->segment(2) == "addbranch" ) {
                                $parent_shop = $parentID;
                            }
                        }

                        $key = $this->hash->create($this->input->post('username_regis'), $this->input->post('email_regis'), 'sha256md5');

                        $dataRegister = array(
                            'use_username' => trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))),
                            'use_password' => $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                            'use_salt' => $salt,
                            'use_email' => trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))),
                            'use_fullname' => trim($this->filter->injection_html($this->input->post('fullname_regis'))),
                            'use_birthday' => date('Y-m-d', mktime(0, 0, 0, (int)$this->input->post('month_regis'), (int)$this->input->post('day_regis'), (int)$this->input->post('year_regis'))),
                            'use_sex' => $sex_regis,
                            'use_address' => trim($this->filter->injection_html($this->input->post('address_regis'))),
                            'use_province' => $this->input->post('province_regis'),
                            'user_district' => $this->input->post('district_regis'),
                            'use_phone' => trim($this->filter->injection_html($this->input->post('phone_regis'))),
                            'use_mobile' => trim($this->filter->injection_html($this->input->post('mobile_regis'))),
                            'id_card' => trim($this->filter->injection_html($this->input->post('idcard_regis'))),
                            'tax_code' => trim($this->filter->injection_html($this->input->post('taxcode_regis'))),
                            'tax_type' => $this->input->post('taxtype_regis'),
                            'bank_name' => trim($this->filter->injection_html($this->input->post('namebank_regis'))),
                            'bank_add' => trim($this->filter->injection_html($this->input->post('addbank_regis'))),
                            'account_name' => trim($this->filter->injection_html($this->input->post('accountname_regis'))),
                            'num_account' => $this->input->post('accountnum_regis'),
                            'style_id' => trim($this->filter->injection_html($this->input->post('style_id'))),
                            'use_yahoo' => trim($this->filter->injection_html($this->input->post('yahoo_regis'))),
                            'use_skype' => trim($this->filter->injection_html($this->input->post('skype_regis'))),
                            'use_message' => trim($this->filter->injection_html($this->input->post('message_regis'))),
                            'use_group' => $group,
                            'use_status' => $active,
                            'use_regisdate' => $currentDate,
                            'use_enddate' => $enddate,
                            'use_key' => $key,
                            'use_lastest_login' => $currentDate,
                            'member_type' => $this->input->post('member_type'),
                            'active_code' => trim($this->input->post('active_code')),
                            'avatar' => $image,
                            'parent_id' => $parentID,
                            'parent_shop' => $parent_shop
                        );

                        if ($this->user_model->add($dataRegister)) {

                            if ($this->uri->segment(2) == 'affiliate' || $this->uri->segment(2) == 'addbranch') {
                                $cur_shop_id = (int)mysql_insert_id();
                                $parenUser = $this->user_model->get("use_group", "use_id = " . $parentID . "");
                                $parentID = ($parentID > 0 && $parenUser->use_group != 2) ? (int)$parentID : 0;
                                $parentShop = $this->shop_model->get("sho_id, sho_descr, sho_category", "sho_user = " . $parentID . "");

                                if ($this->uri->segment(2) == 'affiliate') {
                                    $shopName = 'Cộng Tác Viên Online';
                                    $shopDesc = "Gian hàng Cộng Tác Viên Online azibai";
                                    $shopType = 0;
                                    $title_Notifications = $body_Notifications = 'Bạn vừa có thêm Cộng Tác Viên Online mới';
                                    $actionType_Notifications = 'key_new_affiliate_user';
                                } elseif ($this->uri->segment(2) == 'addbranch') {
                                    $shopName = 'Chi nhánh Gian hàng';
                                    $shopDesc = "Gian hàng Chi nhánh azibai";
                                    //$shopType = 3;
                                    $shopType = 2;
                                    $title_Notifications = $body_Notifications = 'Bạn vừa có thêm Chi Nhánh mới';
                                    $actionType_Notifications = 'key_new_branch_user';
                                }

                                if ($parentShop->sho_id > 0) {
                                    $shopCat = $parentShop->sho_category;
                                    $shopDesc = $parentShop->sho_descr;
                                } else {
                                    $shopCat = 1;
                                }

                                $dataShopRegister = array(
                                    'sho_name' => $shopName,
                                    'sho_descr' => $shopDesc,
                                    'sho_address' => '',
                                    'sho_link' => trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))),
                                    'sho_logo' => 'default-logo.png',
                                    'sho_dir_logo' => 'defaults',
                                    'sho_banner' => 'default-banner.jpg',
                                    'sho_dir_banner' => 'defaults',
                                    'sho_province' => (int)$this->input->post('province_regis'),
                                    'sho_district' => $this->input->post('district_regis'),
                                    'sho_category' => $shopCat,
                                    'sho_phone' => trim($this->filter->injection_html($this->input->post('mobile_regis'))),
                                    'sho_mobile' => trim($this->filter->injection_html($this->input->post('mobile_regis'))),
                                    'sho_user' => $cur_shop_id,
                                    'sho_begindate' => $currentDate,
                                    'sho_enddate' => $currentDate_Pre,
                                    'sho_view' => 1,
                                    'sho_status' => 1,
                                    'sho_style' => 'default',
                                    'sho_email' => trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))),
                                    'shop_type' => $shopType
                                );

                                $this->shop_model->add($dataShopRegister);
                                //  add notifications
                                $this->load->model('notifications_model');
                                $dataNotifications = array(
                                    '`read`' => 0,
                                    'userId' => $parentID,
                                    'actionType' => $actionType_Notifications,
                                    'actionId' => $cur_shop_id,
                                    'title' => $title_Notifications,
                                    'body' => $body_Notifications,
                                    'meta' => null,
                                    'updatedAt' => time(),
                                    'createdAt' => time()
                                );
                                $this->notifications_model->add($dataNotifications);
                                // end add notifications
                            }
                            if ((int)settingActiveAccount == 1 && $disableMail == 0) {
                                #Create key activation
                                $token = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))), $key, "sha512md5");
                                $key = base_url() . 'activation/user/' . trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))) . '/key/' . $key . '/token/' . $token;
                                #Mail
                                $this->load->library('email');
                                $config['useragent'] = $this->lang->line('useragent_defaults');
                                $config['mailtype'] = 'html';
                                $this->email->initialize($config);
                                if ($this->uri->segment(2) == 'afstore' || $this->uri->segment(2) == 'estore') {
                                    $title = "Chào bạn " . $this->input->post('fullname_regis') . " ! " . $this->lang->line('subject_send_mail_defaults');
                                    $message = '<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
            <div id=":n8" class="a3s" style="overflow: hidden;">
                <div class="adM">  </div>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:20px 0">
                                <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                            </td>
                        </tr>   
                        <tr><td></td></tr> 
                    </tbody>
                </table> 
                <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="height:9px" valign="top"></td> 
                                        </tr> 
                                        <tr>
                                            <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                                            <div style="line-height:18px;color:#333">
                                                <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                                                    <h1 style="font-size:20px;font-weight:bold;color:#666">
                                                        Đăng ký Gian hàng miễn phí
                                                    </h1> 
                                                    <span style="display:block;padding:10px 0">Xin chào: <strong>' . $this->input->post('username_regis') . '</strong>,<br/>
                                                        <br/>
                                                            Bạn đã đăng ký thành công tài khoản trên azibai.com
                                                         <br/><br/>
                                                            <strong>Bạn đang muốn tăng doanh thu nhanh, tăng lợi nhuận?</strong>
                                                            <br/><strong>Bạn có muốn tuyển được ngay đội ngũ Cộng tác viên bán hàng chuyên nghiệp?</strong>
                                                            <br/> Hãy tham gia Cộng Đồng Doanh Nghiệp Kinh Doanh Online Azibai để cùng chia sẻ các kinh nghiệm kinh doanh hiệu quả.
                                                            <br/> <a href="https://www.facebook.com/groups/1233843429961548/" target="_blank" >Click vào đây để tham gia Miễn phí....</a>
                                                        <br/><br/><br/>
                                                        <a href="' . $key . '">Click vào đây</a> để xác nhận tài khoản đã đăng ký trên azibai.com
                                                         <br/><br/><br/>
                                                        <a href="' . base_url() . 'content/391">Qui định đối với người bán</a>
                                                        <br/>
                                                        <a href="' . base_url() . 'account' . '">Link quản trị tài khoản</a>
                                                    </span>
                                                </div>
                                            </div>
                                            </td> 
                                        </tr> 
                                    </tbody>
                                </table> 
                            </td> 
                        </tr> 
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> 
                                    <tbody>
                                        <tr></tr>        
                                        <tr>
                                            <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" width="55%">  
                                                                <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                                            </td> 
                                                            <td align="right">
                                                                <div style="padding-top:10px;margin-right:5px">
                                                                    <img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg">
                                                                </div>
                                                            </td> 
                                                        </tr> 
                                                    </tbody>
                                                </table> 
                                            </td>
                                        </tr>  
                                    </tbody>
                                </table> 
                            </td> 
                        </tr> 
                    </tbody>
                </table>
            </div>
        <div class="yj6qo"> 
        </div>
    </div>';
                                } elseif ($this->uri->segment(2) == 'affiliate') {
                                    $title = "Chào bạn " . $this->input->post('fullname_regis') . " ! " . $this->lang->line('subject_send_mail_defaults');
                                    $message = '<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
            <div id=":n8" class="a3s" style="overflow: hidden;">
                <div class="adM">  </div>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:20px 0">
                                <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                            </td>
                        </tr>
                        <tr><td></td></tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="height:9px" valign="top"></td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                                            <div style="line-height:18px;color:#333">
                                                <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                                                    <h1 style="font-size:20px;font-weight:bold;color:#666">
                                                       Đăng ký Tài khoản Cộng Tác Viên Online miễn phí
                                                    </h1>
                                                    <p>
                                                        <span style="display:block;padding:10px 0">Chào bạn: <strong>' . $this->input->post('username_regis') . '</strong>,<br/>
                                                            Bạn đã đăng ký thành công tài khoản trên azibai.com 
                                                        </span>
                                                    </p>
                                                    <p><strong>I.</strong> Tài khoản Cộng Tác Viên Online trên azibai.com của bạn đã được khởi tạo thành công. Ngay bây giờ, bạn có thể sử dụng tài khoản đã đăng ký và tham gia bán hàng trên azibai.<br/><br/></p>
                                                    <p><strong>II.</strong> Bạn có muốn được trang bị thêm các kỹ năng chuyên nghiệp giúp bán được hàng ngay không?
                                                        <br/> Hãy tham gia Diễn đàn chia sẻ các kỹ năng bán hàng chuyên nghiệp dành cho Cộng Tác Viên Online của Azibai.
                                                        <br/> <a href="https://www.facebook.com/groups/300797756941319/" target="_blank" >Tham gia Miễn phí ngay bây giờ...</a>
                                                    </p><br/>                                                   
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800">
                                    <tbody>
                                        <tr></tr>
                                        <tr>
                                            <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" width="55%">
                                                                <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                                            </td>
                                                            <td align="right">
                                                                <div style="padding-top:10px;margin-right:5px">
                                                                    <img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div class="yj6qo">
        </div>
    </div>';
                                } 
                                /*$this->email->from($this->lang->line('EMAIL_MEMBER_TT24H'));
                                $this->email->to(trim($this->input->post('email_regis')));
                                $this->email->subject($this->lang->line('subject_send_mail_defaults'));
                                $this->email->message($message);*/
                                $folder = folderWeb;
                                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
                                $return_email = $this->smtpmailer(trim($this->input->post('email_regis')), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", $title, $message);
                                if ($return_email) {
                                    $this->session->set_flashdata('sessionSuccessSendActivation', 1);
                                    $_SESSION['usernameRegister'] = $this->input->post('username_regis');
                                }
                            }
                            $this->session->set_flashdata('sessionSuccessRegister', 1);
                        }
                        $this->session->set_userdata('sessionTimePosted', time());

                        redirect(base_url() . trim(uri_string(), '/'), 'location'); die;

                    } else {
                        $data['username_regis'] = $this->input->post('username_regis');
                        $data['email_regis'] = $this->input->post('email_regis');
                        $data['reemail_regis'] = $this->input->post('reemail_regis');
                        $data['fullname_regis'] = $this->input->post('fullname_regis');
                        $data['day_regis'] = $this->input->post('day_regis');
                        $data['month_regis'] = $this->input->post('month_regis');
                        $data['year_regis'] = $this->input->post('year_regis');
                        $data['sex_regis'] = $this->input->post('sex_regis');
                        $data['address_regis'] = $this->input->post('address_regis');
                        $data['province_regis'] = $this->input->post('province_regis');
                        $data['district_regis'] = $this->input->post('district_regis');
                        $data['phone_regis'] = $this->input->post('phone_regis');
                        $data['idcard_regis'] = $this->input->post('idcard_regis');
                        $data['mobile_regis'] = $this->input->post('mobile_regis');
                        $data['taxcode_regis'] = $this->input->post('taxcode_regis');
                        $data['taxtype_regis'] = $this->input->post('taxtype_regis');
                        $data['options_name'] = $this->input->post('options_name');
                        $data['company_name'] = $this->input->post('company_name');
                        $data['company_agent'] = $this->input->post('company_agent');
                        $data['company_position'] = $this->input->post('company_position');
                        $data['namebank_regis'] = $this->input->post('namebank_regis');
                        $data['addbank_regis'] = $this->input->post('addbank_regis');
                        $data['accountname_regis'] = $this->input->post('accountname_regis');
                        $data['accountnum_regis'] = $this->input->post('accountnum_regis');
                        $data['yahoo_regis'] = $this->input->post('yahoo_regis');
                        $data['skype_regis'] = $this->input->post('skype_regis');
                        $data['message_regis'] = $this->input->post('message_regis');
                        $data['vip_regis'] = $this->input->post('vip_regis');
                        $data['shop_regis'] = $this->input->post('shop_regis');
                    }
                }
                #BEGIN: Create captcha register
                // $this->load->library('captcha');
                // $codeCaptcha = $this->captcha->code(6);
                // $this->session->set_userdata('sessionCaptchaRegister', $codeCaptcha);
                // $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . rand(500, 50000) . 'reg.jpg';
                // $this->session->set_userdata('sessionPathCaptchaRegister', $imageCaptcha);
                // $this->captcha->create($codeCaptcha, $imageCaptcha);
                // if (file_exists($imageCaptcha)) {
                //     $data['imageCaptchaRegister'] = $imageCaptcha;
                // }
                #END Create captcha register
            // }
        }
        $data['userId'] = $this->session->userdata('sessionUser');
        $data['userGroup'] = $this->session->userdata('sessionGroup');
        //province && district       
        $where_province = "";
        if ($this->uri->segment(2) == "affiliate") {
            $where_province = $this->getAffByUser();
        }
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1" . $where_province, "pre_order", "ASC");
        if ($this->input->post('district_regis')) {
            $filterDistrict = array(
                'select' => 'DistrictCode, DistrictName',
                'where' => array('ProvinceCode' => $this->input->post('province_regis'))
            );
            $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
        }

        #Load view
        $this->load->view('home/register/defaults', $data);
    }

    function registerEmployee()
    {
        $data = $this->loadSubdata();
        $data['menuType'] = 'account';        
        if ($this->input->post('mobile_regis') && $this->input->post('mobile_regis') != '') {

            $this->load->library('form_validation');
            //start validate
            $this->form_validation->set_rules('fullname_regis', 'lang:fullname_regis_label_defaults', 'trim|required');
            $this->form_validation->set_rules('mobile_regis', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone|callback__exist_username_use_phone');
            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
            $this->form_validation->set_rules('email_regis', 'lang:email_regis_label_defaults', 'trim|required|valid_email|callback__exist_email');
            $this->form_validation->set_rules('idcard_regis', '', 'trim|required');
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
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            //end set mess
            if ($this->form_validation->run() != false) {
                //xử lý data 
                $parent_shop = $this->session->userdata('sessionUser');        
                if($this->session->userdata('sessionGroup') == BranchUser){
                    $parent_shop = $this->user_model->get("parent_id", "use_id = " . $this->session->userdata('sessionUser'))->parent_id;
                }
                $salt = $this->hash->key(8);
                $key = $this->hash->create(trim($this->filter->injection_html($this->input->post('mobile_regis'))), null, 'sha256md5');
                $active = 1;
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $group = 15;
                $mobile = trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis'))));
                $password = $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512');
                $email = trim(strtolower($this->filter->injection_html($this->input->post('email_regis'))));
                $fullname = trim($this->filter->injection_html($this->input->post('fullname_regis')));
                $id_card = trim($this->filter->injection_html($this->input->post('idcard_regis')));
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
                    'parent_id' => $this->session->userdata('sessionUser'),
                    'parent_shop' => $parent_shop,
                    'parent_invited' => 0,
                    'active_date' => date('Y-m-d')
                );

                //đăng ký nhân viên
                if($this->user_model->add($dataRegister)){
                    //đăng ký role cho nhân viên vừa tạo
                    $list_rol = $this->input->post('role_regis');
                    if(!empty($list_rol)) {
                        $select = 'use_id';
                        $where = array('use_username' => $mobile) ;
                        $emp = $this->user_model->get($select,$where);
                        foreach ($list_rol as $key => $value) {
                            $dataUserRole = array(
                                'user_id' => $emp->use_id,
                                'rol_id' => $value
                            );
                            $this->db->insert('tbtt_user_emp_permission', $dataUserRole);
                        }
                    }
                    //return success
                    $data['successRegister'] = true;
                } else {
                    // echo "Error message = ".mysql_error();
                    echo "Error message = connection fail!!!";
                    die;
                }
                $this->load->view('home/register/nhanvien', $data);    
            } else {  
                redirect('account/staffs/add','location');die();    
            }
        } else {
            //lấy data list role
            $select = '*'; $where = 'status = 1'; $order = 'id'; $by = 'ASC'; $distinct = false;
            if($this->session->userdata('sessionGroup') == BranchUser) {
                $where .= ' AND id != 2';
            }
            //chia array thành nhiều array có 4 value
            $data['list_role'] = array_chunk($this->user_emp_role_model->fetch($select,$where,$order,$by,'','',$distinct), 4);
            $data['successRegister'] = false;

            $this->load->view('home/register/nhanvien', $data); 
        }
    }

    function updateRoleEmployee()
    {
        // $list_new_role = $_REQUEST['role_regis'];
        $list_new_role = $this->input->post('role_regis');
        $uid = (int)$this->input->post('userid');
        if($uid > 0 && !empty($list_new_role)){
            $this->db->delete('tbtt_user_emp_permission', array('user_id' => $uid));
            foreach ($list_new_role as $key => $value) {
                $dataUserRole = array(
                    'user_id' => $uid,
                    'rol_id' => $value
                );
               $this->db->insert('tbtt_user_emp_permission', $dataUserRole);
            }
            echo '1'; exit();
        } elseif($uid > 0 && empty($list_new_role)) {
            $this->db->delete('tbtt_user_emp_permission', array('user_id' => $uid));
            echo '1'; exit();
        } 
        echo '0'; exit();        
    }

    function menuEmpRedirect($id = 0)
    {
        $id = (int)$id;
        switch ($id) {
            case 111://gioi thieu mo ctv
                redirect('account/tree/inviteaf','location');die();                    
                break;
            case 112://ctv online da gioi thieu
                redirect('account/emp-listaffiliate','location');die();                    
                break;
            case 113://ctv online thuoc he thong
                redirect('account/allaffiliateunder','location');die();                    
                break;
            case 114://them chi nhanh
                redirect('account/emp-addbranch','location');die();                    
                break;
            case 115://danh sach chi nhanh
                redirect('account/emp-listbranch','location');die();                    
                break;
            case 116://phan cong tu gian hang
                redirect('account/viewtasks/month/'. date('m'),'location');die();                    
                break;
            case 117://don hang chi nhanh
                redirect('account/listbran_order','location');die();                    
                break;
            case 118://don hang ctv
                redirect('account/affiliate/orders','location');die();                    
                break;
            case 134://don hang san pham moi
                redirect('account/order/product','location');die();                    
                break;
            case 135://don hang coupon moi
                redirect('account/order/coupon','location');die();                    
                break;
            case 119://yeu cau khieu nai
                redirect('account/emp-complaintsOrders','location');die();                    
                break;  
            case 120://khieu nai da giai quyet
                redirect('account/solvedOrders','location');die();                    
                break;
            case 121://thong ke chung
                redirect('account/statistic','location');die();                    
                break;
            case 122://thong ke chi nhanh
                redirect('account/statisticlistbran','location');die();
                break;
            case 123://thong ke ctv
                redirect('account/statisticlistaffiliate','location');die();                    
                break;  
            case 124://thong ke theo san pham
                redirect('account/statisticproduct','location');die();                    
                break;
            case 137://thong ke CTV cua chi nhanh
                redirect('account/statisticlistaffiliatebran','location');die();                    
                break;
            case 138://thong ke chung
                redirect('account/statisticIncome','location');die();  
                break;
            case 107://thoat
                redirect('logout','location');die();                    
                break;  
            case 126://dang san pham
                redirect('account/product/product/post','location');die();                    
                break;   
            case 127://show list san pham da dang
                redirect('account/emp-product','location');die();
                break;
            case 128://dang coupon
                redirect('account/product/coupon/post','location');die();  
                break;
            case 129://show list coupon da dang
                redirect('account/emp-coupon','location');die();  
                break;
            case 139://duyet san pham
                redirect('branch/prowaitingapprove','location');die();  
                break;
            case 131:// add news
                redirect('account/news/add','location');die();  
                break;
            case 132:// List news
                redirect('account/news','location');die();  
                break;
            case 133:// News Comment
                redirect('account/comments','location');die();  
                break;
            case 136:// News Comment
                redirect('branch/newswaitapprove','location');die();  
                break;
            default:
                redirect('account','location');die();  
                break;
        }
    }

    // Get code verify connect to VHT
    function verifyCode()
    {
        if ($this->session->userdata('sessionUser')) {
            redirect(base_url() . 'account', 'location');            
        }
        if($_REQUEST['reg_pa']) {
            $reg_pa = $_REQUEST['reg_pa'];
        }elseif($this->session->userdata('urlservice')) {
            $aUrl = explode('af_id=',$this->session->userdata('urlservice'));
            if(isset($aUrl[1])) {
                $oAffUser = $this->user_model->get('use_id','af_key = "' . $aUrl[1].'"');
                $reg_pa = $oAffUser->use_id;
            }
        }

        if ($this->input->post('phone_num') && $this->input->post('phone_num') != '') {
            $qr = (isset($reg_pa) && $reg_pa != '') ? '?reg_pa='.$reg_pa : '';
            
            if (isset($_REQUEST['type_affiliate']) && $_REQUEST['type_affiliate'] != '') {
                $qr = $qr.'&type_affiliate='.$_REQUEST['type_affiliate'];
            }

            if($_REQUEST['parent_id']) {
                $qr .= '&parent_id='.$_REQUEST['parent_id'];
            }

            // Check number phone

            if (is_numeric($this->input->post('phone_num'))) 
            {
                if (substr($this->input->post('phone_num'), 0, 1) == 0) 
                {
                    $phone_num = substr($this->input->post('phone_num'), 1);
                } 
                else 
                {
                    $phone_num = '0' . $this->input->post('phone_num');
                }

                $where_or = 'use_mobile = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_phone = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_username = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_mobile = "' . $phone_num . '"';
                $where_or .= 'OR use_phone = "' . $phone_num . '"';
                $where_or .= 'OR use_username = "' . $phone_num . '"';

                $user = $this->user_model->get('use_id', $where_or);
                if ($user && $user->use_id > 0) 
                {
                    $this->session->set_flashdata('_sessionErrorLogin', 'Số điện thoại này đã có người sử dụng. Vui lòng kiểm tra lại và nhập số khác!');

                    $this->session->set_flashdata('_sessionPhoneOld', $this->input->post('phone_num'));
                    
                    redirect(base_url() . 'register/verifycode'.$qr, 'location');                
                } 
            } 
            else
            {
                $this->session->set_flashdata('_sessionErrorLogin', 'Số điện thoại này không hợp lệ. Vui lòng kiểm tra lại và nhập số khác!');
                $this->session->set_flashdata('_sessionPhoneOld', $this->input->post('phone_num'));
                redirect(base_url() . 'register/verifycode'.$qr, 'location');
            }

            
             
            // Init Curl to VHT API
            $this->load->model('authorized_code_model');
            $mobile = trim($this->filter->injection_html($this->input->post('phone_num')));
            $chars = '0123456789';
            $key = '';
            for ($i = 0; $i < 6; $i++) {
                $key = $key . substr($chars, rand(0, strlen($chars) - 1), 1);
            }

            $dataAdd = array(
                'code' => $key,
                'mobile' => $mobile,
                'during' => 600,
                'create_date' => date('Y-m-d H:i:s'),
                'active' => 0
            );

            if ($this->authorized_code_model->add($dataAdd)) {
                $keyVht = 'Mncvcskh';
                $secretVht = 'Mdhadjhdladvbmnsdha';
                $text = "Ma kich hoat cua so dien thoai " . $mobile . " la " . $key;

                $data = [
                    'submission' => [
                        'api_key' => 'Mncvcskh',
                        'api_secret' => 'Mdhadjhdladvbmnsdha',
                        'sms' => [
                            [
                                'id' => 0,
                                'brandname' => 'azibai.com',
                                'text' => 'Ma xac thuc tai khoan azibai.com cua ban ' . $key,
                                'to' => $mobile,
                            ],
                        ],
                    ],
                ];
                $dataString = json_encode($data);
                $ch = curl_init('http://sms3.vht.com.vn/ccsms/Sms/SMSService.svc/ccsms/json');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($dataString)
                    )
                );
                $respon = curl_exec($ch);
                $result = json_decode($respon);   
                // echo '<pre>';
                // print_r($result); die;

                if ((int)$result->response->submission->sms[0]->status === 0) {
                    $this->session->set_userdata('phone_num', $mobile);

                    if (isset($reg_pa) && $reg_pa != '') {
                        $this->session->set_userdata('reg_pa',(int)$reg_pa);
                        redirect(base_url().'register/account'.$qr, 'location');
                    }
                    redirect(base_url().'register/account', 'location');                       
                } else {
                    $msg = '';
                    switch ((int)$result->response->submission->sms[0]->status) {
                        case 7:
                            $msg = 'Thuê bao quý khách từ chối nhận tin. Vui lòng cài đặt lại!';
                            break;
                        case 10:
                            $msg = 'Không phải thuê bao di dộng. Vui lòng kiểm tra lại!';
                            break;
                        case 31:
                            $msg = 'Đầu số sim của bạn hiện ngừng sử dụng. Vui lòng kiểm tra lại!';
                            break;
                        default:
                            $msg = 'Hệ thống lỗi. Vui lòng thử lại!';
                            break;
                    }
                    $this->session->set_flashdata('_sessionErrorLogin', $result->response->submission->sms[0]->status . ' - ' . $msg);
                    $this->session->set_flashdata('_sessionPhoneOld', $this->input->post('phone_num'));
                    if($_REQUEST['parent_id']) {
                        $qr .= '&parent_id='.$_REQUEST['parent_id'];
                    }
                    redirect(base_url() . 'register/verifycode'.$qr, 'location');
                }
            }
        }
        if(isset($reg_pa)){
            $shop = $this->shop_model->get('*', 'sho_user = '. $reg_pa);
            $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
            $this->load->model('share_metatag_model');

            $type_share = TYPESHARE_SHOP_RECRUITMENT;
            $get_avtShare = $this->share_metatag_model->get('*','use_id = '.(int) $shop->sho_user.' AND type = '.$type_share);
            if(count($get_avtShare)){
                $ogimage = $get_avtShare[0]->image;
            }
            
            $data['sho_user'] = $shop->sho_user;
            $data['type_share'] = $type_share;
            $data['ogimage'] = $ogimage;
            
            $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
            $data['keywordsSiteGlobal'] = $shop->sho_keywords;

            $data['ogurl']              = base_url().'register/verifycode?reg_pa='.$reg_pa;

            if($_REQUEST['type_affiliate']) {
                $data['ogurl'] = $data['ogurl'].'&type_affiliate='.$_REQUEST['type_affiliate'];
            }

            $data['ogdescription']      = 'Trang tuyển dụng của '.$shop->sho_name;
            $data['ogtype']             = 'website';
            $data['ogtitle']            = $shop->sho_name;
        }
        #Load view
        $this->load->view('home/register/verifycode', $data);
    }

    

    

    function checkAuth() {
        
        $socialData = array();
        $socialData['providerId'] = $_REQUEST['providerId'];
        $socialData['providerUserId'] = $_REQUEST['uid'];
        $socialData['accessToken'] = $_REQUEST['token'];        
        $socialData['avatar'] = $_REQUEST['avatar'];
        $socialData['name'] = $_REQUEST['name'];
        $socialData['reg_pa'] = (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') ? '&reg_pa='.$_REQUEST['reg_pa'] : '';

        $mb = $_REQUEST['mb'];
        $this->load->model('social_model');

        if ($this->input->post('sms_code') && $this->input->post('sms_code') != '') {
            $sms_code = trim(strtolower($this->filter->injection_html($this->input->post('sms_code'))));
            $this->load->model('authorized_code_model');
            $autho = $this->authorized_code_model->get('*', 'code = "'.$sms_code.'" AND active = 0 AND mobile = "'.$mb.'"');

            if (count($autho) < 1) {
                $this->session->set_flashdata('_sessionErrorLogin', 'Sai mã kích hoạt! Vui lòng kiểm tra lại.');

                if(!empty($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                   redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');
                }
            }
            else if ((count($autho) >= 1 && (strtotime($autho->create_date) + $autho->during <= strtotime(date('Y-m-d H:i:s'))))) {  
                $this->session->set_flashdata('_sessionErrorLogin', 'Mã kích hoạt đã hết thời hạn! Vui lòng gửi yêu cầu để nhận mã mới.');
                
                redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');

            if ($this->form_validation->run() === false) {
                
                $this->session->set_flashdata('_sessionErrorLogin', 'Vui lòng kiểm tra lại mật khẩu.');

                if(!empty($_SERVER['HTTP_REFERER'])){
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                   redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');
                }
            }

            $newUser = array();
            $salt = $this->hash->key(8);
            $key = $this->hash->create($mb, null, 'sha256md5');

            $parent_id = 1336;

            if (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') 
            {   
                $p_user = $this->user_model->get("use_id, use_group, parent_id","use_id = $parent_id");
                if ($p_user && $p_user->use_id > 0) {
                    $parent_id = (int) $_REQUEST['reg_pa'];
                    if($p_user->use_group == AffiliateStoreUser) 
                    {
                        $parent_shop = 0;
                    }

                    if($p_user->use_group == BranchUser) 
                    {
                        $parent_shop = $p_user->parent_id;
                    }
                }
            }

            if ($socialData['providerId'] == 'facebook') {
                require_once(APPPATH.'libraries'.DS.'facebook'.DS.'facebook.php');
                $facebook = new Facebook(array(
                    'appId' => FACEBOOK_ID,
                    'secret' => FACEBOOK_SERECT,
                    'cookie' => true
                ));
                // See if there is a user from a cookie
                $facebook->setAccessToken($socialData['accessToken']);
                $user = $facebook->getUser(); 
                
                if ($user) {
                    try {
                        $user_profile = $facebook->api('/me?fields=' . FACEBOOK_FIELD);
                        foreach ($user_profile as $k => $val) {
                            $socialData[$k] = $val;
                        }


                        // Tao nguoi dung moi
                        $newUser = array(
                            'use_username'      =>      $socialData['providerUserId'],
                            'use_password'      =>      $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                            'use_salt'          =>      $salt,
                            'use_email'         =>      $socialData['email'],
                            'use_fullname'      =>      $socialData['name'],
                            'use_birthday'      =>      NULL,
                            'use_sex'           =>      0,
                            'use_address'       =>      '',
                            'use_province'      =>      0,
                            'use_phone'         =>      '',
                            'use_mobile'        =>      $mb,
                            'id_card'           =>      '0',
                            'tax_type'          =>      0,
                            'use_yahoo'         =>      '',
                            'use_skype'         =>      '',
                            'use_group'         =>      3,
                            'use_status'        =>      1,
                            'use_regisdate'     =>      time(),
                            'use_enddate'       =>      0,
                            'use_key'           =>      $key,
                            'use_lastest_login' =>      time(),
                            'member_type'       =>      0,
                            'active_code'       =>      '',
                            'avatar'            =>      '',
                            'parent_id'         =>     $parent_id
                        );


                    } catch (FacebookApiException $e) {
                        
                    }
                }
            } 
            else if ($socialData['providerId'] == 'google') {

                require_once(APPPATH.'libraries'.DS.'google'.DS.'autoload.php'); 
                $client  = new Google_Client();
                $client->setApplicationName("Azibai"); // Set Application name
                $client->setClientId(GG_APP_ID); // Set Client ID
                $client->setClientSecret(GG_APP_SERET); //Set client Secret
                $client->setAccessType('offline'); // Access method online|offline
                $client->setScopes(GOOGLE_SCOPE);
                $client->setRedirectUri('postmessage'); 
                $objOAuthService = new Google_Service_Oauth2($client);
                
                
                if(!empty($socialData['accessToken'])){
                    $client->authenticate($socialData['accessToken']);
                    $client->getAccessToken();
                    $gpUserProfile = $objOAuthService->userinfo->get();
                    if (!empty($gpUserProfile->email))
                    {
                        
                        $socialData['providerUserId'] = $gpUserProfile->id;
                        $socialData['email'] = $gpUserProfile->email;
                        
                        // Tao nguoi dung moi
                        $newUser = array(
                            'use_username'      =>      $socialData['providerUserId'],
                            'use_password'      =>      $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                            'use_salt'          =>      $salt,
                            'use_email'         =>      $socialData['email'],
                            'use_fullname'      =>      $gpUserProfile->name,
                            'use_birthday'      =>      NULL,
                            'use_sex'           =>      0,
                            'use_address'       =>      '',
                            'use_province'      =>      0,
                            'use_phone'         =>      '',
                            'use_mobile'        =>      $mb,
                            'id_card'           =>      '0',
                            'tax_type'          =>      0,
                            'use_yahoo'         =>      '',
                            'use_skype'         =>      '',
                            'use_group'         =>      3,
                            'use_status'        =>      1,
                            'use_regisdate'     =>      time(),
                            'use_enddate'       =>      0,
                            'use_key'           =>      $key,
                            'use_lastest_login' =>      time(),
                            'member_type'       =>      0,
                            'active_code'       =>      '',
                            'avatar'            =>      '',
                            'parent_id'         =>      $parent_id
                        );                   
                    }
                }
            }
            
            if (!empty($newUser)) {

                

                $newUser['use_id'] = $this->social_model->createdUser($newUser);
                if (!empty($newUser['use_id'])) {

                    if(!empty($socialData['avatar'])) {
                        $pathUpload = "media/images/avatar/";

                        $chars = '0123456789abcdefghijklmnopqrstuvxyw';
                        $nameImage = ''; 
                        for ($i = 0; $i < 32; $i++) {
                            $nameImage = $nameImage.substr($chars, rand(0, strlen($chars) - 1), 1);
                        } 
                        $dirUpload = $nameImage;

                        if (!is_dir($pathUpload .'/'. $dirUpload)) {
                            @mkdir($pathUpload .'/'. $dirUpload, 0775, true);
                            $this->load->helper('file');
                            @write_file($pathUpload .'/'. $dirUpload .'/index.html', '<p>Directory access is forbidden.</p>');
                        }

                        $content = file_get_contents($socialData['avatar']);
                        $imgName = $pathUpload."/".$dirUpload."/".$nameImage.".jpg";
                        $fp = fopen($imgName, "w+");
                        fwrite($fp, $content);
                        fclose($fp);                             

                        $this->load->library('ftp');                
                        $configftp['hostname'] = IP_CLOUDSERVER;
                        $configftp['username'] = USER_CLOUDSERVER;
                        $configftp['password'] = PASS_CLOUDSERVER;
                        $configftp['port'] = PORT_CLOUDSERVER;
                        $configftp['debug'] = TRUE;
                        $this->ftp->connect($configftp);     
                        $pathTarget = '/public_html/media/images/avatar/' . $newUser['use_id'];

                        $listdir = $this->ftp->list_files($pathTarget);
                        if(empty($listdir)){
                            $this->ftp->mkdir($pathTarget , 0775);
                        }

                        /* Upload this image to cloud server */
                        $source_path = $imgName;
                        $target_path = $pathTarget.'/'.$nameImage.".jpg";
                        if($this->ftp->upload($source_path, $target_path, 'auto', 0775)) {
                            /* Delete file amd folder upload */
                            if (file_exists($pathUpload . '/' . $dirUpload . '/index.html')) {
                                @unlink($pathUpload . '/' . $dirUpload . '/index.html');
                            }
                            array_map('unlink', glob($pathUpload .'/' . $dirUpload . '/*'));
                            @rmdir($pathUpload . '/' . $dirUpload);
                        }
                        /* Close connect ftp */
                        $this->ftp->close(); 
                        $newUser['avatar'] = $nameImage.".jpg";
                        $this->user_model->update(array('avatar'=>$newUser['avatar']), "use_id = ".(int)$newUser['use_id']);
                    }

                    // update user search
                    curl_data(LINK_UPDATE_USER.$newUser['use_id'], array() ,'','','GET');

                    if($newUser['parent_id'] > 0) {
                        $this->product_affiliate($newUser['parent_id'], $newUser['use_id']);
                    }

                    $this->user_model->update(array('use_slug'=>$newUser['use_id']), "use_id = ".(int)$newUser['use_id']); 
                    $this->social_model->updateSocial(['providerId' => $socialData['providerId'], 'providerUserId' => $socialData['providerUserId'], 'use_id' => $newUser['use_id']]);

                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $dataShopRegister = array(
                        'sho_name' => !empty($newUser['use_fullname']) ? trim($newUser['use_fullname']) . ' Shop' : 'Gian hàng trên Azibai',
                        'sho_descr' => '',
                        'sho_address' => '',
                        'sho_link' => $newUser['use_username'],
                        'sho_logo' => 'default-logo.png',
                        'sho_dir_logo' => 'defaults',
                        'sho_banner' => 'default-banner.jpg',
                        'sho_dir_banner' => 'defaults',
                        'sho_province' => 0,
                        'sho_district' => '',
                        'sho_category' => 0,
                        'sho_phone' => $mb,
                        'sho_mobile' => $mb,
                        'sho_user' => $newUser['use_id'],
                        'sho_view' => 1,
                        'sho_status' => 1,
                        'sho_style' => 2,
                        'sho_email' => $newUser['use_email'],
                        'shop_type' => 2,
                        'sho_begindate' => $currentDate
                    );
                    if ($this->shop_model->add($dataShopRegister)) 
                    {
                        $new_shop_id = (int)mysql_insert_id();
                        // update shop search
                        curl_data(LINK_UPDATE_SHOP.$new_shop_id, array() ,'','','GET');
                    }

                    $this->social_model->login($newUser);
                    $this->authorized_code_model->update(array('active'=>1), 'id = '.$autho->id);
                    redirect(base_url().'profile/'.$newUser['use_id'], 'location');                    
                }
            }
            // Update sms code actived
            // $this->authorized_code_model->update(array('active'=>1), 'id = '.$autho->id);

            // redirect(base_url().'account/edit', 'location');
        }

        $data['mb'] = $mb;
        #Load view
        $this->load->view('home/register/checkauth', $data);
    }

    function register_by_social_facebook() {
        // echo json_encode(array('error'=>false, 'redirect'=>base_url().'account1'));
        // exit(); 

        $this->load->model('social_model');

        $socialData = array();
        $socialData['providerId'] = $this->input->post('social');
        $socialData['providerUserId'] = $this->input->post('id');
        $socialData['accessToken'] = $this->input->post('accessToken');        
        $avatar = $this->input->post('avatar');
        // Update social login
        $this->social_model->updateLogin($socialData);

        if($this->input->post('social') == 'facebook'){
            require_once(APPPATH.'libraries'.DS.'facebook'.DS.'facebook.php');
            $facebook = new Facebook(array(
                'appId' => FACEBOOK_ID,
                'secret' => FACEBOOK_SERECT,
                'cookie' => true
            ));
            // See if there is a user from a cookie
            $facebook->setAccessToken($this->input->post('accessToken'));
            $user = $facebook->getUser(); 
            
            if ($user) {
                try {
                    $user_profile = $facebook->api('/me?fields=' . FACEBOOK_FIELD);
                    //print_r($user_profile);
                    foreach ($user_profile as $k => $val) {
                        $socialData[$k] = $val;
                    }                     

                    if ($socialData['email'] != '') {
                        $userInfo = $this->social_model->checkExistUser($socialData);
                        if (!empty($userInfo)) {
                            $this->social_model->login($userInfo);                            
                            echo json_encode(array('error'=>false, 'redirect'=>base_url().'account','user'=>$user));
                        } else {
                            // Tao nguoi dung moi
                            $newUser = array(
                                'use_username'      =>      $socialData['providerUserId'],
                                'use_password'      =>      '',
                                'use_salt'          =>      '',
                                'use_email'         =>      $socialData['email'],
                                'use_fullname'      =>      $socialData['name'],
                                'use_birthday'      =>      NULL,
                                'use_sex'           =>      0,
                                'use_address'       =>      '',
                                'use_province'      =>      0,
                                'use_phone'         =>      '',
                                'use_mobile'        =>      '',
                                'id_card'           =>      '0',
                                'tax_type'          =>      0,
                                'use_yahoo'         =>      '',
                                'use_skype'         =>      '',
                                'use_group'         =>      3,
                                'use_status'        =>      1,
                                'use_regisdate'     =>      time(),
                                'use_enddate'       =>      0,
                                'use_key'           =>      '',
                                'use_lastest_login' =>      time(),
                                'member_type'       =>      0,
                                'active_code'       =>      '',
                                'avatar'            =>      '',
                                'parent_id'         =>      0
                            );

                            $newUser['use_id'] = $this->social_model->createdUser($newUser);

                            if ($avatar && $avatar != '') {
                                // Lay avatar facebook
                                $pathUpload = "media/images/avatar";
                                $dirUpload = $newUser['use_id'];
                                if (!is_dir($pathUpload .'/'. $dirUpload)) {
                                    @mkdir($pathUpload .'/'. $dirUpload, 0775, true);
                                    $this->load->helper('file');
                                    @write_file($pathUpload .'/'. $dirUpload .'/index.html', '<p>Directory access is forbidden.</p>');
                                }

                                $chars = '0123456789abcdefghijklmnopqrstuvxyw';
                                $nameImage = ''; 
                                for ($i = 0; $i < 32; $i++) {
                                    $nameImage = $nameImage.substr($chars, rand(0, strlen($chars) - 1), 1);
                                } 

                                $content = file_get_contents($avatar);
                                $imgName = $pathUpload."/".$dirUpload."/".$nameImage.".jpg";
                                $fp = fopen($imgName, "w+");
                                fwrite($fp, $content);
                                fclose($fp);                             

                                $this->load->library('ftp');                
                                $configftp['hostname'] = IP_CLOUDSERVER;
                                $configftp['username'] = USER_CLOUDSERVER;
                                $configftp['password'] = PASS_CLOUDSERVER;
                                $configftp['port'] = PORT_CLOUDSERVER;
                                $configftp['debug'] = TRUE;
                                $this->ftp->connect($configftp);     
                                $pathTarget = '/public_html/media/images/avatar';
                                /* Upload this image to cloud server */
                                $source_path = $pathUpload.'/'.$dirUpload.'/'.$imgName;
                                $target_path = $pathTarget.'/'.$imgName;

                                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                                // echo json_encode(array('error'=>false, 'redirect'=>base_url().'account','user'=>$user.' - '.$imgName.' - '.$target_path ));
                                // exit();

                                /* Delete file amd folder upload */
                                if (file_exists($pathUpload . '/' . $dirUpload . '/index.html')) {
                                    @unlink($pathUpload . '/' . $dirUpload . '/index.html');
                                }
                                array_map('unlink', glob($pathUpload .'/' . $dirUpload . '/*'));
                                @rmdir($pathUpload . '/' . $dirUpload);
                                /* Close connect ftp */
                                $this->ftp->close(); 
                                $this->user_model->update(array('avatar'=>$imgName), 'use_id = '.$newUser['use_id']);
                            }
        
                            $this->social_model->login($newUser);
                            echo json_encode(array('error'=>false, 'redirect'=>base_url().'register/inputmobile?uid='.$newUser['use_id'],'user'=>$user));
                           
                            //echo json_encode(array('error'=>true, 'message'=>'Khong tim thay nguoi dung'));
                        }
                    }
                } catch (FacebookApiException $e) {
                    echo json_encode(array('error'=>true,'message'=>'Lỗi kết nối với facebook','user'=>$user));
                }
            }
        }
   
        exit();
    }
    

    function register_by_social() {
        $result = json_encode(array('error'=>true,'message'=>'Lỗi kết nối với facebook'));

        $socialData = array();
        $socialData['providerId'] = $this->input->post('social');
        $socialData['providerUserId'] = $this->input->post('id');
        $socialData['accessToken'] = $this->input->post('accessToken');        
        $socialData['avatar'] = $this->input->post('avatar');
        $socialData['name'] = $this->input->post('name');
        $socialData['reg_pa'] = (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') ? '&reg_pa='.$_REQUEST['reg_pa'] : '';
       
        $this->load->model('social_model');
        
        $userInfo = $this->social_model->getUser($socialData);
       
        if (!empty($userInfo)) 
        {
                        
            $sessionLogin = array(
                'sessionUser' => (int)$userInfo->use_id,
                'sessionGroup' => (int)$userInfo->use_group,
                'sessionUsername' => $userInfo->use_username,
                'sessionName' => $userInfo->use_fullname,
                'sessionAvatar' => $userInfo->avatar
            );
            $this->session->set_userdata($sessionLogin);
                                        
            $result = json_encode(array('error'=>false, 'redirect'=>base_url()));
        } 
        else if ( ($socialData['providerId'] == 'facebook' || $socialData['providerId'] == 'google') && !empty($socialData['providerUserId'])) 
        {
            $this->social_model->addSocial(['providerId' =>$socialData['providerId'], 'providerUserId' => $socialData['providerUserId']]);
            // $this->session->set_userdata['register_user'] = $socialData;
            $result = json_encode(array('error'=>false, 'redirect'=>base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$this->input->post('social') .'&token='. $this->input->post('accessToken') .'&name='.$this->input->post('name') .'&avatar='.$this->input->post('avatar').$socialData['reg_pa']));
        }
        echo $result;
        exit();
    }

    function inputMobile() {
        $socialData = array();
        $socialData['providerId'] = $_REQUEST['providerId'];
        $socialData['providerUserId'] = $_REQUEST['uid'];
        $socialData['accessToken'] = $_REQUEST['token'];        
        $socialData['avatar'] = $_REQUEST['avatar'];
        $socialData['name'] = $_REQUEST['name'];
        $socialData['reg_pa'] = (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') ? '&reg_pa='.$_REQUEST['reg_pa'] : '';

        if ($this->input->post('phone_num') && $this->input->post('phone_num') != '') {
            // Check mobile has existed
            $mobile = trim($this->filter->injection_html($this->input->post('phone_num')));
           
            if (is_numeric($this->input->post('phone_num'))) 
            {
                if (substr($this->input->post('phone_num'), 0, 1) == 0) 
                {
                    $phone_num = substr($this->input->post('phone_num'), 1);
                } 
                else 
                {
                    $phone_num = '0' . $this->input->post('phone_num');
                }

                $where_or = 'use_mobile = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_phone = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_username = "' . $this->input->post('phone_num') . '"';
                $where_or .= 'OR use_mobile = "' . $phone_num . '"';
                $where_or .= 'OR use_phone = "' . $phone_num . '"';
                $where_or .= 'OR use_username = "' . $phone_num . '"';

                $user = $this->user_model->get('use_id', $where_or);
                if ($user && $user->use_id > 0) 
                {
                    $this->session->set_flashdata('sessionErrorInput', 'Số điện thoại này đã có người sử dụng. Vui lòng kiểm tra lại và nhập số khác!');
                    redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');               
                } 
            } 
            else
            {
                $this->session->set_flashdata('sessionErrorInput', 'Số điện thoại này không hợp lệ. Vui lòng kiểm tra lại và nhập số khác!');
                redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');
            }

            // Create code to verify SMS
            // Init Curl to VHT API
            $this->load->model('authorized_code_model');            
            $chars = '0123456789';
            $key = '';
            for ($i = 0; $i < 6; $i++) {
                $key = $key . substr($chars, rand(0, strlen($chars) - 1), 1);
            }

            $dataAdd = array(
                'code' => $key,
                'mobile' => $mobile,
                'during' => 600,
                'create_date' => date('Y-m-d H:i:s'),
                'active' => 0
            );

            if ($this->authorized_code_model->add($dataAdd)) {
                $keyVht = 'Mncvcskh';
                $secretVht = 'Mdhadjhdladvbmnsdha';
                $text = "Ma kich hoat cua so dien thoai " . $mobile . " la " . $key;

                $data = [
                    'submission' => [
                        'api_key' => 'Mncvcskh',
                        'api_secret' => 'Mdhadjhdladvbmnsdha',
                        'sms' => [
                            [
                                'id' => 0,
                                'brandname' => 'azibai.com',
                                'text' => 'Ma xac thuc tai khoan azibai.com cua ban ' . $key,
                                'to' => $mobile,
                            ],
                        ],
                    ],
                ];
                $dataString = json_encode($data);
                $ch = curl_init('http://sms3.vht.com.vn/ccsms/Sms/SMSService.svc/ccsms/json');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($dataString)
                    )
                );
                $respon = curl_exec($ch);
                $result = json_decode($respon); 

                if ((int)$result->response->submission->sms[0]->status === 0) { 
                    redirect(base_url().'register/checkauth?key='.$key.'&mb='.$mobile .'&uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'].$socialData['reg_pa'], 'location');
                } else {
                    $msg = '';
                    switch ((int)$result->response->submission->sms[0]->status) {
                        case 7:
                            $msg = 'Thuê bao quý khách từ chối nhận tin. Vui lòng cài đặt lại!';
                            break;
                        case 10:
                            $msg = 'Không phải thuê bao di dộng. Vui lòng kiểm tra lại!';
                            break;
                        case 31:
                            $msg = 'Đầu số sim của bạn hiện ngừng sử dụng. Vui lòng kiểm tra lại!';
                            break;
                        default:
                            $msg = 'Hệ thống lỗi. Vui lòng thử lại!';
                            break;
                    }
                    $this->session->set_flashdata('_sessionErrorLogin', $result->response->submission->sms[0]->status . ' - ' . $msg);                    
                }
            }

            error_reporting(E_ALL);
            // Has error
            // redirect(base_url().'register/inputmobile?uid='.$socialData['providerUserId'].'&providerId='.$socialData['providerId'] .'&token='.$socialData['accessToken'] .'&name='.$socialData['name'] .'&avatar='.$socialData['avatar'], 'location');          
        }
        #Load view
        $this->load->view('home/register/conti_regis');
    }    

    function getCodeAuthenFace() {
        $data['mobile']  = $this->session->userdata('phone_num');
        $userId = $_REQUEST['userId'] ? (int)$_REQUEST['userId'] : 0;
        $data['userId'] = $userId;
        $data['auth_success'] = false;
        if ($this->input->post('verify_regis') && $this->input->post('verify_regis') != '') {
            $vcode = trim(strtolower($this->filter->injection_html($this->input->post('verify_regis'))));
            $this->load->model('authorized_code_model');
            $autho = $this->authorized_code_model->get('*', 'code = "' . $vcode . '" AND active = 0 AND mobile = "'.$this->session->userdata('phone_num').'"');

            if (count($autho) < 1) {
                $this->session->unset_userdata('phone_num');
                $this->session->set_flashdata('_sessionErrorLogin', 'Mã kích hoạt không đúng! Vui lòng nhập lại.');               
                redirect(base_url() . 'home/register/getCodeAuthenFace', 'location');
                die;
            } else if (count($autho) >= 1 && (strtotime($autho->create_date) + $autho->during <= strtotime(date('Y-m-d H:i:s')))) {
                $this->session->set_flashdata('_sessionErrorLogin', 'Mã kích hoạt đã hết thời hạn! Vui lòng gửi yêu cầu để nhận mã mới.');
                $this->session->unset_userdata('phone_num');
                redirect(base_url() . 'register/verifycode', 'location');
                die;
            } 

            $userId = (int)$this->input->post('userId');
            $this->user_model->update(array('use_username'=>$this->session->userdata('phone_num'), 'use_phone'=>$this->session->userdata('phone_num'), 'use_mobile'=>$this->session->userdata('phone_num')), 'use_id = '.$userId);
            $user = $this->user_model->get('*', 'use_id = '.$userId.' AND use_status = 1');
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $dataShopRegister = array(
                'sho_name' => 'Gian hàng trên Azibai',
                'sho_descr' => '',
                'sho_address' => '',
                'sho_link' => $user->use_username,
                'sho_logo' => 'default-logo.png',
                'sho_dir_logo' => 'defaults',
                'sho_banner' => 'default-banner.jpg',
                'sho_dir_banner' => 'defaults',
                'sho_province' => '',
                'sho_district' => '',
                'sho_category' => '',
                'sho_phone' => $this->session->userdata('phone_num'),
                'sho_mobile' => $this->session->userdata('phone_num'),
                'sho_user' => $userId,
                'sho_view' => 1,
                'sho_status' => 1,
                'sho_style' => 2,
                'sho_email' => $user->use_email,
                'shop_type' => 2,
                'sho_begindate' => $currentDate
            );
            $this->shop_model->add($dataShopRegister);

            $this->authorized_code_model->update(array('active'=>1), 'code = "' . $vcode . '" AND active = 0 AND mobile = "'.$this->session->userdata('phone_num').'"');
            $data['auth_success'] = true;

            // Login
            $sessionLogin = array(
                'sessionUser' => (int)$user->use_id,
                'sessionGroup' => (int)$user->use_group,
                'sessionUsername' => $user->use_username,
                'sessionName' => $user->use_fullname,
                'sessionAvatar' => $user->avatar
            );
            $this->session->set_userdata($sessionLogin);
            // redirect(base_url().'account', 'location');
            // die;
        }
        #Load view
        $this->load->view('home/register/signup_success_face', $data);
    }

    function register_by_social_google() { 
        // echo json_encode(array('error'=>false, 'redirect'=>base_url().'account1'));
        // exit();         
        
        $this->load->model('social_model');

        if ($this->input->post('social') == 'google') {

            require_once(APPPATH.'libraries'.DS.'google'.DS.'autoload.php'); 
            $client  = new Google_Client();
            $client->setApplicationName("Azibai"); // Set Application name
            $client->setClientId(GG_APP_ID); // Set Client ID
            $client->setClientSecret(GG_APP_SERET); //Set client Secret
            $client->setAccessType('offline'); // Access method online|offline
            $client->setScopes(GOOGLE_SCOPE);
            $client->setRedirectUri('postmessage'); // Enter your file path (Redirect Uri) that you have set to get client ID in API 
            $objOAuthService = new Google_Service_Oauth2($client);
            // 
            
            // error_reporting(E_ALL);
            
            if(!empty($this->input->post('code'))){
                $client->authenticate($this->input->post('code'));
                $client->getAccessToken();
                $gpUserProfile = $objOAuthService->userinfo->get();
                
                if (!empty($gpUserProfile->email))
                {
                    $socialData = array();
                    $socialData['providerId'] = $this->input->post('social');
                    $socialData['providerUserId'] = $gpUserProfile->id;
                    $socialData['email'] = $gpUserProfile->email;
                    $userInfo = $this->social_model->checkExistUser($socialData);

                    if (!empty($userInfo)) {
                        $this->social_model->login($userInfo);
                        echo json_encode(array('error'=>false, 'redirect'=>base_url().'account'));
                    } else {
                        // Tao nguoi dung moi
                        $newUser = array(
                            'use_username'      =>      $socialData['providerUserId'],
                            'use_password'      =>      '',
                            'use_salt'          =>      '',
                            'use_email'         =>      $socialData['email'],
                            'use_fullname'      =>      $gpUserProfile->name,
                            'use_birthday'      =>      NULL,
                            'use_sex'           =>      0,
                            'use_address'       =>      '',
                            'use_province'      =>      0,
                            'use_phone'         =>      '',
                            'use_mobile'        =>      '',
                            'id_card'           =>      '0',
                            'tax_type'          =>      0,
                            'use_yahoo'         =>      '',
                            'use_skype'         =>      '',
                            'use_group'         =>      3,
                            'use_status'        =>      1,
                            'use_regisdate'     =>      time(),
                            'use_enddate'       =>      0,
                            'use_key'           =>      '',
                            'use_lastest_login' =>      time(),
                            'member_type'       =>      0,
                            'active_code'       =>      '',
                            'avatar'            =>      '',
                            'parent_id'         =>      0
                        );

                        $newUser['use_id'] = $this->social_model->createdUser($newUser);
                        $this->social_model->login($newUser);
                        echo json_encode(array('error'=>false, 'redirect'=>base_url().'register/inputmobile?uid='.$newUser['use_id']));
                    } 
                }
            }
        }
        exit();
    }    

    // Register account simple
    function register_account()
    {
        if($_REQUEST['reg_pa']) {
            $reg_pa = $_REQUEST['reg_pa'];
        }elseif($this->session->userdata('urlservice')) {
            $aUrl = explode('af_id=',$this->session->userdata('urlservice'));
            if(isset($aUrl[1])) {
                $oAffUser = $this->user_model->get('use_id','af_key = "' . $aUrl[1].'"');
                $reg_pa = $oAffUser->use_id;
            }
        }
        $qr = (isset($reg_pa) && $reg_pa != '') ? '?reg_pa='.$reg_pa : '';

        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->uri->segment(1) != 'register' && $this->uri->segment(2) != 'account') {
            redirect(base_url() . 'account'.$qr, 'location');
            die;
        }

        if ($this->session->flashdata('sessionSuccessRegister')) {
            $data['successRegister'] = true;
        } else {
            $data['successRegister'] = false;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
            

            if ($this->form_validation->run() != false) {
                $mobile_num = $this->session->userdata('phone_num');
                $disableMail = 0;
                $salt = $this->hash->key(8);
                $group = 3;
                $active = 1;
                $enddate = 0;
                $key = $this->hash->create($this->session->userdata('phone_num'), null, 'sha256md5');
                // $uid = $this->session->userdata('uid') ? $this->session->userdata('uid') : 0;
                $parentID = 1336;
                $parent_shop = 0;
                $iAffiliateLevel = 0;
                if (empty($uid)) 
                {   
                    $type_affiliate = $_REQUEST['type_affiliate'];
                    if (isset($_REQUEST['reg_pa']) && $_REQUEST['reg_pa'] != '') 
                    {   
                        $parentID = (int) $_REQUEST['reg_pa'];
                        $p_user = $this->user_model->get("use_id, use_group, parent_id, affiliate_level","use_id = $parentID");
            
                        if ($p_user && $p_user->use_id > 0) {
                            if($p_user->use_group == AffiliateStoreUser) 
                            {
                                $parent_shop = 0;
                            }

                            if($p_user->use_group == BranchUser) 
                            {
                                $parent_shop = $p_user->parent_id;
                            }

                            if($p_user->affiliate_level != 0 && $type_affiliate != 2) {
                                $iAffiliateLevel = 3;
                            }

                            $this->session->unset_userdata('reg_pa');
                        }

                    }
                } else {
                    $p_user = $this->user_model->get("use_id, use_group, parent_id, affiliate_level","use_id = $uid");
                    if ($p_user && $p_user->use_id > 0) {
                        $parentID = $p_user->use_id;
                        if($p_user->use_group == AffiliateStoreUser) {
                            $parent_shop = 0;
                        }

                        if($p_user->use_group == BranchUser) {
                        $parent_shop = $p_user->parent_id;
                        }
                    }
                }

                $vcode = trim(strtolower($this->filter->injection_html($this->input->post('verify_regis'))));
                $this->load->model('authorized_code_model');
                $autho = $this->authorized_code_model->get('*', 'code = "' . $vcode . '" AND active = 0 AND mobile = "' . $this->session->userdata('phone_num') . '"');

                if (count($autho) < 1) {
                    
                    if(empty($uid)){
                        $this->session->set_flashdata('_sessionErrorCode', 'Sai mã kích hoạt. Vui lòng kiểm tra lại và nhập lại mã khác!');
                        $this->session->set_flashdata('_sessionPostOld', $_POST);
                        redirect(base_url() . 'register/account'.$qr, 'location');    
                    } else {
                        $this->session->unset_userdata('phone_num');
                        redirect(base_url() . 'register/affiliate/user/'.$uid, 'location');
                    }                    
                } else if (count($autho) >= 1 && (strtotime($autho->create_date) + $autho->during <= strtotime(date('Y-m-d H:i:s')))) {
                    $this->session->set_flashdata('_sessionErrorLogin', 'Mã kích hoạt đã hết thời hạn! Vui lòng gửi yêu cầu để nhận mã mới.');
                    $this->session->set_flashdata('_sessionPostOld', $_POST);
                    $this->session->unset_userdata('phone_num');                    
                    if(empty($uid)){
                        redirect(base_url() . 'register/verifycode'.$qr, 'location');    
                    } else {
                        redirect(base_url() . 'register/affiliate/user/'.$uid, 'location');
                    }                   
                }


                // $user_email = $this->user_model->get('use_id', 'use_email = "'. $this->input->post('email') . '"');
                // if (($user_email && $user_email->use_id > 0)) {
                //     $this->session->set_flashdata('_sessionErrorEmail', 'Email này đã tồn tại trong hệ thống. Vui lòng nhấp vào <a class="js-forgot-pass" data-email="'.$this->input->post('email').'" target="_blank" style="margin-top:0px; color: blue;"> lấy lại mã xác thực </a> để khôi phục tài khoản!');
                //     redirect(base_url() . 'register/account'.$qr, 'location');                
                // } 


                // Get mobile phone or email
                $mail = '';
                $fullname = $this->input->post('full_name');
                $mobile = $autho->mobile;
                $str_email = '';
                
                // Người giới thiệu
                $iParentInvited = 0;
                if($this->session->userdata('parent_invited') != 0) {
                    $iParentInvited = (int) $this->session->userdata('parent_invited');
                    // Nếu link giới thiệu từ link mua hàng thì nó thuộc về azibai
                    $parentID = 1336;
                    $iAffiliateLevel = 0;
                }
                
                $dataRegister = array(
                    'use_fullname' => $fullname,
                    'use_username' => $this->session->userdata('phone_num'),
                    'use_password' => $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                    'use_salt' => $salt,
                    'use_email' => $mail,
                    'use_mobile' => $mobile,
                    'use_group' => $group,
                    'use_status' => $active,
                    'use_regisdate' => $currentDate,
                    'use_enddate' => $enddate,
                    'active_date' => date('Y-m-d'),
                    'use_key' => $key,
                    'use_lastest_login' => $currentDate,
                    'parent_id' => $parentID,
                    'parent_shop' => $parent_shop,
                    'affiliate_level' => $iAffiliateLevel,
                    'parent_invited'  => $iParentInvited
                );
                $new_user_id = $this->user_model->add($dataRegister);
                if ($new_user_id) {
                    if($_REQUEST['type_affiliate'] && $_REQUEST['parent_id'] && $_REQUEST['reg_pa']) 
                    {

                        // Lấy token lưu vào session
                        $aDataLogin = array(
                            'username'      => $this->session->userdata('phone_num'), 
                            'password'      => $this->input->post('password_regis'),
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

                        $data_return = [];
                        $rent_header = null;
                        if($this->session->userdata('token')) {
                            $token = $this->session->userdata('token');
                            $rent_header[] = "Authorization: Bearer $token" ;
                            $rent_header[] = "Content-Type: multipart/form-data";
                        }
                        
                        // data statistic affiliate order
                        $url = $this->config->item('api_aff_user_invitere');
                        $url = str_replace(['{$type_affiliate}','{$parent_id}'], [$_REQUEST['type_affiliate'], $_REQUEST['parent_id']], $url);
                        $params = [
                            'user_id' =>  $_REQUEST['reg_pa']
                        ];
                        
                        $make_call = $this->callAPI('POST', $url, $params, $rent_header);
                        $make_call = json_decode($make_call, true);

                        // $this->load->model('affiliate_relationship_model');
                        // $iAR = $this->affiliate_relationship_model->add(array(
                        //     'user_id'        => $new_user_id,
                        //     'parent_id'      => $_REQUEST['reg_pa'],
                        //     'user_parent_id' => $_REQUEST['parent_id'],
                        //     'affiliate_level'=> 3,
                        //     'accept'         => 1,
                        //     'list_user'      => '',
                        // ));

                    }

                    $this->session->unset_userdata('parent_invited');
                    // update user search
                    curl_data(LINK_UPDATE_USER.$new_user_id, array() ,'','','GET');

                    $this->user_model->update(array('use_slug'=>$new_user_id), "use_id = ".(int)$new_user_id);
                    $sessionLogin = array(
                        'sessionUser' => (int)$new_user_id,
                        'sessionGroup' => (int)$dataRegister['use_group'],
                        'sessionUsername' => $dataRegister['use_username'],
                        'sessionName' => $dataRegister['use_fullname'],
                        'affiliate_level'   => $iAffiliateLevel,
                        'sessionAvatar' => ''
                    );
                    $this->session->set_userdata($sessionLogin);
                    // if($parentID > 0) {
                    //     $this->product_affiliate($parentID, $new_user_id);
                    // }

                    if($new_user_id > 0){
                        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                        $dataShopRegister = array(
                            'sho_name' => !empty($fullname) ? trim($fullname) . ' Shop' : 'Gian hàng trên Azibai',
                            'sho_descr' => '',
                            'sho_address' => '',
                            'sho_link' => $dataRegister['use_username'],
                            'sho_logo' => 'default-logo.png',
                            'sho_dir_logo' => 'defaults',
                            'sho_banner' => 'default-banner.jpg',
                            'sho_dir_banner' => 'defaults',
                            'sho_province' => 0,
                            'sho_district' => '',
                            'sho_category' => 0,
                            'sho_phone' => $mobile,
                            'sho_mobile' => $mobile,
                            'sho_user' => $new_user_id,
                            'sho_view' => 1,
                            'sho_status' => 1,
                            'sho_style' => 2,
                            'sho_email' => $mail,
                            'shop_type' => 2,
                            'sho_begindate' => $currentDate
                        );
                        if ($this->shop_model->add($dataShopRegister)) 
                        {
                            $new_shop_id = (int)mysql_insert_id();
                            // update shop search
                            curl_data(LINK_UPDATE_SHOP.$new_shop_id, array() ,'','','GET');
                        }
                        $iTypeAffiliate = $_REQUEST['type_affiliate'];
                        if($iTypeAffiliate && $iTypeAffiliate == 2) {
                            $sToken = '';
                            // Lấy token lưu vào session 
                            $aDataLogin = array(
                                'username'      => $dataRegister['use_username'], 
                                'password'      => $this->input->post('password_regis'),
                                'deviceToken'   => 6632,
                                'deviceId'      => 12333
                            );
                            
                            $jData = curl_data(link_get_token.'login', $aDataLogin,'','','POST');

                            if($jData != '') {
                                $aData =  json_decode($jData);
                                if(!empty($aData) && $aData->status == 1) {
                                    $aData = $aData->data;
                                    $sToken = $aData->token;
                                }
                            }

                            if($sToken != '') {
                                $data_return = [];
                                $rent_header = null;

                                $rent_header[] = "Authorization: Bearer $sToken" ;
                                $rent_header[] = "Content-Type: multipart/form-data";
                                
                                // data statistic affiliate order
                                $url = $this->config->item('api_aff_user_invite');
                                $url = str_replace(['{$type_affiliate}'], [2], $url);

                                $params = [
                                    'user_id' =>  $new_user_id
                                ];
                                
                                $make_call = $this->callAPI('POST', $url, $params, $rent_header);
                                $make_call = json_decode($make_call, true);
                                if($make_call['status'] == 0) {
                                    $this->session->set_flashdata('_sessionErrorCode', 'Thêm vào hệ thống A bị lỗi vui lòng liên hệ để thử lại!');
                                }
                            }

                            
                        }
                    }
                    if ($this->form_validation->valid_email($str_email)) {
                        if ((int)settingActiveAccount == 1 && $disableMail == 0) {
                            #Create key activation
                            $token = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))), $key, "sha512md5");
                            $key = base_url() . 'activation/user/' . $mobile_num . '/key/' . $key . '/token/' . $token;
                            #Mail
                            $this->load->library('email');
                            $config['useragent'] = $this->lang->line('useragent_defaults');
                            $config['mailtype'] = 'html';
                            $this->email->initialize($config);

                            $title = "Chào bạn $mobile_num ! ".$this->lang->line('subject_send_mail_defaults');
                            $message = '
<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
    <div id=":n8" class="a3s" style="overflow: hidden;">
        <div class="adM"></div>
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
            <tbody>
                <tr>
                    <td align="center" style="padding:20px 0">
                        <img src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                    </td>
                </tr>   
                <tr>
                    <td></td>
                </tr> 
            </tbody>
        </table> 
        
        <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
                            <tbody>
                                <tr>
                                    <td align="center" style="height:9px" valign="top"></td> 
                                </tr> 
                                <tr>
                                    <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                                        <div style="line-height:18px;color:#333">
                                            <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                                                <h1 style="font-size:20px;font-weight:bold;color:#666">
                                                            Đăng ký Gian hàng miễn phí
                                                </h1> 
                                                <span style="display:block;padding:10px 0">Xin chào: <strong>' . $mobile_num . '</strong>,<br/>
                                                    <br/>Bạn đã đăng ký thành công tài khoản trên azibai.com
                                                    <br/><br/>
                                                    <strong>Bạn đang muốn tăng doanh thu nhanh, tăng lợi nhuận?</strong>
                                                    <br/><strong>Bạn có muốn tuyển được ngay đội ngũ Cộng tác viên bán hàng chuyên nghiệp?</strong>
                                                    <br/> Hãy tham gia Cộng Đồng Doanh Nghiệp Kinh Doanh Online Azibai để cùng chia sẻ các kinh nghiệm kinh doanh hiệu quả.
                                                    <br/> <a href="https://www.facebook.com/groups/1233843429961548/" target="_blank" >Click vào đây để tham gia Miễn phí....</a>
                                                    <br/><br/><br/>
                                                    <a href="' . $key . '">Click vào đây</a> để xác nhận tài khoản đã đăng ký trên azibai.com
                                                    <br/><br/><br/>
                                                    <a href="' . base_url() . 'content/391">Qui định đối với người bán</a>
                                                    <br/>
                                                    <a href="' . base_url() . 'account' . '">Link quản trị tài khoản</a>
                                                </span>
                                            </div>
                                        </div>
                                    </td> 
                                </tr> 
                            </tbody>
                        </table> 
                    </td> 
                </tr> 
            </tbody>
        </table>

        <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
            <tbody>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800"> 
                            <tbody>
                                <tr></tr>        
                                <tr>
                                    <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                                        <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                                            <tbody>
                                                <tr>
                                                    <td align="left" valign="top" width="55%">  
                                                        <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                                    </td> 
                                                    <td align="right">
                                                        <div style="padding-top:10px;margin-right:5px">
                                                            <img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg">
                                                        </div>
                                                    </td> 
                                                </tr> 
                                            </tbody>
                                        </table> 
                                    </td>
                                </tr>  
                            </tbody>
                        </table> 
                    </td> 
                </tr> 
            </tbody>
        </table>
    </div>
    <div class="yj6qo"></div>
</div>';
                        }

                        $folder = folderWeb;
                        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                        require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
                        $return_email = $this->smtpmailer(trim($this->input->post('email_regis')), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", $title, $message);
                        if ($return_email) {
                            $this->session->set_flashdata('sessionSuccessSendActivation', 1);
                            $_SESSION['usernameRegister'] = $mobile_num;
                        }
                    }

                    // Cập nhật lại mã kích hoạt đã sử dụng
                    $this->authorized_code_model->update(array('active' => 1), 'code = "' . $vcode . '" AND mobile = "' . $this->session->userdata('phone_num') . '"');

                    $this->session->set_flashdata('sessionSuccessRegister', 1);
                    $this->session->unset_userdata('phone_num'); // Hủy session phone
                    // redirect(base_url() . 'register/signupdone?newacc=' . $mobile_num . '&newid=' . $new_user_id, 'location');
                    if($this->session->userdata('urlservice')) {
                        redirect(base_url().$this->session->userdata('urlservice'), 'location');
                    }else {
                        redirect(base_url().'profile/'.$new_user_id, 'location');
                    }
                         
                }
            }
        }

        #Load view
        $this->load->view('home/register/regaccount', $data);
    }

    function signupdone()
    {
        if ($this->uri->segment(1) != 'register' && $this->uri->segment(2) != 'signupdone') {
            redirect(base_url() . 'account', 'location');
        }
        $newacc = $_REQUEST['newacc'];
        $newid = (int)$_REQUEST['newid'];

        $user = $this->user_model->get("use_id, use_username, use_group, use_status, use_enddate, use_fullname, use_email, use_mobile, avatar", "use_username = '" . $newacc . "' AND use_id = $newid");

        if (count($user) == 1) {
            if ((int)$user->use_status == 0) {
                $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email và kích hoạt tài khoản');
                redirect(base_url() . 'login');
            }

            $sessionLogin = array(
                'sessionUser' => (int)$user->use_id,
                'sessionGroup' => (int)$user->use_group,
                'sessionUsername' => $user->use_username,
                'sessionName' => $user->use_fullname,
                'sessionAvatar' => $user->avatar
            );
            $this->session->set_userdata($sessionLogin);
            $data['sessionSuccessLogin'] = true;
            $data['user'] = $user;

            $this->user_model->update(array('use_lastest_login' => time()), "use_id = " . $user->use_id);
            $this->load->model('grouptrade_model');
            $grt_ = $this->grouptrade_model->get('grt_id', 'grt_admin = ' . (int)$user->use_id . ' AND grt_status = 1');
            if (count($grt_) > 0) {
                $sessionGrt = $grt_->grt_id ? $grt_->grt_id : 0;
            }
            $this->session->set_userdata('sessionGrt', $sessionGrt);
        } else {
            $this->session->set_flashdata('_sessionErrorLogin', 'Tài khoản chưa tồn tại. Vui lòng tạo tài khoản mới.');
            redirect(base_url() . 'register/account', 'location');
        }
      
        #Load view
        $this->load->view('home/register/signupdone', $data);
    }

    function signup_continue()
    {
        if ($this->session->userdata('sessionUser') < 0) {
            redirect(base_url() . 'login', 'location');
        }

        if ($this->input->post('fullname_res') && $this->input->post('fullname_res') != '') {
            $email = '';
            $mobile = '';
            $user = $this->user_model->get('use_id, use_username, use_email, use_mobile', 'use_id = ' . $this->session->userdata('sessionUser'));
            if ($user) {
                if ($user->use_email != '') {
                    $email = $user->use_email;
                    $mobile = trim(strtolower($this->filter->injection_html($this->input->post('mobile_res'))));
                } else {
                    $email = trim(strtolower($this->filter->injection_html($this->input->post('email_res'))));
                    $mobile = $user->use_mobile;
                }
            } else {
                redirect(base_url() . 'login', 'location');
            }

            if (($_FILES['avatar_res'] && $_FILES['avatar_res']['name'] != '') || ($_FILES['cover_res'] && $_FILES['cover_res']['name'] != '')) {
                #BEGIN: Upload image
                $this->load->library('ftp');
                $configftp['hostname'] = IP_CLOUDSERVER;
                $configftp['username'] = USER_CLOUDSERVER;
                $configftp['password'] = PASS_CLOUDSERVER;
                $configftp['port'] = PORT_CLOUDSERVER;
                $configftp['debug'] = true;
                $this->ftp->connect($configftp);

                # Load libraries upload
                $this->load->library('upload');
                $this->load->library('image_lib');
                $dirUpload = $this->session->userdata('sessionUser');

                if ($_FILES['avatar_res'] && $_FILES['avatar_res']['name'] != '') {
                    $pathAvatar = "media/images/avatar";
                    if (!is_dir($pathAvatar . '/' . $dirUpload)) {
                        @mkdir($pathAvatar . '/' . $dirUpload, 0777, true);
                        $this->load->helper('file');
                        @write_file($pathAvatar . '/' . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
                    }

                    $config['upload_path'] = $pathAvatar . '/' . $dirUpload . '/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['encrypt_name'] = true;
                    $config['max_size'] = '10240'; // 10Mb
                    $this->upload->initialize($config);

                    // Crop avatar
                    if ($this->upload->do_upload('avatar_res')) {
                        $uploadData = $this->upload->data();
                        if ($uploadData['is_image'] == true) {
                            $image = $uploadData['file_name'];
                            /* Create thumbnail 1:1 */
                            $configCrop['source_image'] = $pathAvatar . '/' . $dirUpload . '/' . $image;
                            $configCrop['new_image'] = $pathAvatar . '/' . $dirUpload . '/' . $image;
                            $configCrop['maintain_ratio'] = false;

                            if ($uploadData['image_width'] > $uploadData['image_height']) {
                                $configCrop['width'] = $uploadData['image_height'];
                                $configCrop['height'] = $uploadData['image_height'];
                                $configCrop['x_axis'] = ($uploadData['image_width'] / 2) - ($uploadData['image_height'] / 2);
                                $configCrop['y_axis'] = 0;
                            }

                            if ($uploadData['image_width'] < $uploadData['image_height']) {
                                $configCrop['width'] = $uploadData['image_width'];
                                $configCrop['height'] = $uploadData['image_width'];
                                $configCrop['y_axis'] = ($uploadData['image_height'] / 2) - ($uploadData['image_width'] / 2);
                                $configCrop['x_axis'] = 0;
                            }

                            if ($uploadData['image_width'] == $uploadData['image_height']) {
                                $configCrop['width'] = $uploadData['image_width'];
                                $configCrop['height'] = $uploadData['image_height'];
                                $configCrop['x_axis'] = 0;
                                $configCrop['y_axis'] = 0;
                            }

                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();

                            $configResize['source_image'] = $pathAvatar . '/' . $dirUpload . '/' . $image;
                            $configResize['new_image'] = $pathAvatar . '/' . $dirUpload . '/' . $image;
                            $configResize['maintain_ratio'] = true;
                            $configResize['width'] = 120;
                            $configResize['height'] = 120;
                            $this->image_lib->initialize($configResize);
                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        }
                        /* Upload this image to cloud server */
                        $pathTargetA = '/public_html/media/images/avatar';
                        $source_path = $pathAvatar . '/' . $dirUpload . '/' . $image;
                        $target_path = $pathTargetA . '/' . $image;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                        /* Delete file amd folder upload */
                        if (file_exists($pathAvatar . '/' . $dirUpload . '/index.html')) {
                            @unlink($pathAvatar . '/' . $dirUpload . '/index.html');
                        }
                        array_map('unlink', glob($pathAvatar . '/' . $dirUpload . '/*'));
                        @rmdir($pathAvatar . '/' . $dirUpload);
                    }
                }

                if ($_FILES['cover_res'] && $_FILES['cover_res']['name'] != '') {
                    $pathCover = "media/images/cover";
                    if (!is_dir($pathCover . '/' . $dirUpload)) {
                        @mkdir($pathCover . '/' . $dirUpload, 0777, true);
                        $this->load->helper('file');
                        @write_file($pathCover . '/' . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
                    }

                    $config['upload_path'] = $pathCover . '/' . $dirUpload . '/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['encrypt_name'] = true;
                    $config['max_size'] = '10240'; // 10Mb
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('cover_res')) {
                        $uploadData = $this->upload->data();
                        if ($uploadData['is_image'] == true) {
                            $image_co = $uploadData['file_name'];
                        }
                    }

                    /* Upload this image_co to cloud server */
                    $pathTargetC = '/public_html/media/images/cover';
                    $source_path = $pathCover . '/' . $dirUpload . '/' . $image_co;
                    $target_path = $pathTargetC . '/' . $image_co;
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                    /* Delete file amd folder upload */
                    if (file_exists($pathCover . '/' . $dirUpload . '/index.html')) {
                        @unlink($pathCover . '/' . $dirUpload . '/index.html');
                    }
                    array_map('unlink', glob($pathCover . '/' . $dirUpload . '/*'));
                    @rmdir($pathCover . '/' . $dirUpload);
                }
                
                /* Close connect ftp */
                $this->ftp->close();
            }
            // echo DOMAIN_CLOUDSERVER .'media/images/avatar/thumbnail_'. $img;

            $dataUpdate = array(
                'use_fullname' => $this->filter->injection_html($this->input->post('fullname_res')),
                'use_email' => $email,
                'use_mobile' => $mobile,
                'avatar' => $image,
                'use_cover' => $image_co
            );

            if ($this->user_model->update($dataUpdate, 'use_id = ' . $this->session->userdata('sessionUser'))) {
                $data['signupsuccess'] = true;
            }
            $data['user'] = $user;
            $data['fullname'] = $this->filter->injection_html($this->input->post('fullname_res'));
        }

        #Load view
        $this->load->view('home/register/signupsuccess', $data);
    }

    function limitCTV()
    {
        $chinhanh = $this->input->post('chinhanh');
        $sho_limit_ctv = $this->shop_model->get("sho_limit_ctv", "sho_user = " . $chinhanh);

        $branchs = $this->user_model->fetch('use_id, use_group', "use_status = 1 and use_group = 11 AND parent_id = " . $chinhanh);

        $result = array();
        $result['error'] = false;
        $tree = array();
        $tree[] = $chinhanh;
        if (!empty($branchs)) {
            foreach ($branchs as $item) {
                $tree[] = $item->use_id;
            }
        }
        $idp = implode(',', $tree);
        if ($idp != '') {
            $congtv = $this->user_model->fetch('use_id, use_group', "use_status = 1 and use_group=2 AND parent_id IN(".$idp.")");
            if ($sho_limit_ctv->sho_limit_ctv <= count($congtv)) {
                $result['notification'] = 'Tài khoản đã đạt giới hạn tạo cộng tác viên';
            } else {
                $result['notification'] = '';
            }
            echo json_encode($result);
        }
    }

    function Check_register()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->session->userdata('sessionUser') > 0) {
            redirect(current_url(), 'location'); die;
        }
        $disableMail = 0;
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaRegister'));
        #END Unlink captcha
        if ((int)settingStopRegister == 1) {
            $data['stopRegister'] = true;
        } else {
            $this->load->library('form_validation');
            $this->load->library('hash');
            #END Set messag
            $salt = $this->hash->key(8);
            $key = $this->hash->create($this->input->post('username_regis'), $this->input->post('email_regis'), 'sha256md5');
            $dataRegister = array(
                'use_username' => trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))),
                'use_password' => $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512'),
                'use_salt' => $salt,
                'use_email' => trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))),
                'use_province' => $this->input->post('province_regis'),
                'use_group' => 1,
                'user_district' => $this->input->post('district_regis'),
                'use_mobile' => trim($this->filter->injection_html($this->input->post('mobile_regis'))),
            );
            $user_id = $this->user_model->add($dataRegister);
            if ($user_id) {
                if ((int)settingActiveAccount == 1 && $disableMail == 0) {
                    #Create key activation
                    $token = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))), $key, "sha512md5");
                    $key = base_url() . 'activation/user/' . trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))) . '/key/' . $key . '/token/' . $token;
                    #Mail
                    $this->load->library('email');
                    $config['useragent'] = $this->lang->line('useragent_defaults');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $title = "Chào bạn " . $this->input->post('username_regis') . " ! " . $this->lang->line('subject_send_mail_defaults');
                    $message = '<div id=":p8" class="ii gt m153a68f7aadeb171 adP adO">
            <div id=":n8" class="a3s" style="overflow: hidden;">
                <div class="adM">  </div>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="padding:20px 0">
                                <img alt="" src="http://azibai.com/images/logo-azibai.png" class="CToWUd">
                            </td>
                        </tr>
                        <tr><td></td></tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" style="background:#ffffff" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" style="width:650px;border-top:1px dotted #cccccc">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="height:9px" valign="top"></td>
                                        </tr>
                                        <tr>
                                            <td align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#333333;background:#fff" valign="top">
                                            <div style="line-height:18px;color:#333">
                                                <div style="background:#fff;padding:10px;width:100%;margin-top:10px">
                                                    <h1 style="font-size:20px;font-weight:bold;color:#666">
                                                       Đăng ký thành viên miễn phí
                                                    </h1>
                                                    <span style="display:block;padding:10px 0">Chào bạn: <strong>' . $this->input->post('username_regis') . '</strong>,<br/>
                                                        <br/>' . $this->lang->line('welcome_site_defaults') . 'Bạn hãy click vào linh này để kích hoạt tài khoản: ' . '
                                                        <a href="' . $key . '">Link kích hoạt tài khoản</a>
                                                    </span>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;font-family:arial,sans-serif;font-size:12px;color:#000;text-align:left;line-height:24px;background-color:#f5f5f5" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;border:1px solid #ececec;background-color:#fff" width="800">
                                    <tbody>
                                        <tr></tr>
                                        <tr>
                                            <td style="border-top:1px solid #ececec;padding:30px 0;color:#666">
                                                <table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto" width="700">
                                                    <tbody>
                                                        <tr>
                                                            <td align="left" valign="top" width="55%">
                                                                <p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a> </p>
                                                            </td>
                                                            <td align="right">
                                                                <div style="padding-top:10px;margin-right:5px">
                                                                    <img alt="Banking" src="' . base_url() . 'templates/home/images/dichvuthanhtoan.jpg">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div class="yj6qo">
        </div>
    </div>';
                    $folder = folderWeb;
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
                    $return_email = $this->smtpmailer(trim($this->input->post('email_regis')), $this->lang->line('EMAIL_MEMBER_TT24H'), "Azibai.com", $title, $message);
                    if ($return_email) {
                        $this->session->set_flashdata('sessionSuccessSendActivation', 1);
                        $_SESSION['usernameRegister'] = $this->input->post('username_regis');
                    }
                }
                $this->session->set_flashdata('sessionSuccessRegister', 1);
                $sessionLogin = array(
                    'sessionName' => $this->input->post('username_regis'),
                    'sessionUser' => (int)$user_id,
                    'sessionEmail' => $this->input->post('email_regis'),
                    'sessionMobile' => $this->input->post('mobile_regis'),
                );
                $this->session->set_userdata($sessionLogin);
                $this->session->set_userdata('sessionTimePosted', time());
                echo '1';
                exit();
            }
        }
    }

    private function getAffByUser()
    {
        if ($this->uri->segment(4) != '') {
            $shop = $this->shop_model->get('sho_province', 'sho_user = ' . $this->uri->segment(4));
            $sho_package = $this->package_user_model->getCurrentPackage($this->uri->segment(4));
        }
        switch ($sho_package['id']) {
            case 1:
                return "";
                break;
            case 2:
                //goi blue
                return " AND pre_id = " . $shop->sho_province;
                break;
            case 3:
                //goi silver
                $_province = $this->province_model->get('pre_area', "pre_status = 1 AND pre_id = " . $shop->sho_province);
                $_area = $this->province_model->fetch('pre_id,pre_name', "pre_status = 1 AND pre_area = " . $_province->pre_area, '');
                if ($_area) {
                    $string_province = array();
                    foreach ($_area as $vals) {
                        $string_province[] = $vals->pre_id;
                    }
                    return ' AND pre_id IN (' . implode(",", $string_province) . ')';
                } else {
                    return "";
                }
                break;
            case 4:
                //goi gold
                $_province = $this->province_model->get('pre_area', "pre_status = 1 AND pre_id = " . $shop->sho_province);
                switch ($_province->pre_area) {
                    case 1:
                        $_province_area = "(1,2)";
                        break;
                    case 2:
                        $_province_area = "(1,2)";
                        break;
                    case 3:
                        $_province_area = "(3,4)";
                        break;
                    case 4:
                        $_province_area = "(3,4)";
                        break;
                    case 5:
                        $_province_area = "(5,6)";
                        break;
                    case 6:
                        $_province_area = "(5,6)";
                        break;
                }
                $_area = $this->province_model->fetch('pre_id', "pre_status = 1 AND pre_area IN " . $_province_area);
                if ($_area) {
                    $string_province = array();
                    foreach ($_area as $vals) {
                        $string_province[] = $vals->pre_id;
                    }
                    return ' AND pre_id IN (' . implode(",", $string_province) . ')';
                } else {
                    return "";
                }
                break;
            case 5:
                //goi Platinum
                $_province = $this->province_model->get('pre_region', "pre_status = 1 AND pre_id = " . $shop->sho_province);
                $_area = $this->province_model->fetch('pre_id,pre_name', "pre_status = 1 AND pre_region = " . $_province->pre_region, '');
                if ($_area) {
                    $string_province = array();
                    foreach ($_area as $vals) {
                        $string_province[] = $vals->pre_id;
                    }
                    return ' AND pre_id IN (' . implode(",", $string_province) . ')';
                } else {
                    return "";
                }
                break;
            case 6:
                return "";
                break;
            case 7:
                return "";
                break;
        }
    }

    function activation($username, $key, $token)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
        $data['advertisePage'] = 'register';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        $user = $this->user_model->get("use_id, use_group, use_email, use_key, use_status, style_id", "use_username = '" . $this->filter->injection_html($username) . "'");
        if (count($user) == 1 && trim($username) != '' && trim($key) != '' && trim($token) != '') {
            $data['user'] = $user;
            if ($key === $user->use_key && $token === $this->hash->create($user->use_email, $key, "sha512md5")) {
                if ($this->user_model->update(array('use_status' => 1), "use_id = " . $user->use_id)) {
                    $this->user_model->update(array('use_key' => $this->hash->create($user->use_key, microtime(), 'md5sha256'), 'active_date' => date("Y-m-d", time())), "use_id = " . $user->use_id);
                    $data['successActivation'] = true;
                } else {
                    $data['successActivation'] = false;
                }
            } else {
                if ($user->use_status == 1) {
                    $data['successActivation'] = true;
                } else {
                    $data['successActivation'] = false;
                }
            }
        } else {
            $data['successActivation'] = false;
        }
        #Load view
        $this->load->view('home/register/activation', $data);
    }

    function user_check_phone_number()
    {
        $mo = $this->input->post('mobile');
        if ($mo && $mo != '') {
            $user = $this->user_model->get('use_id', 'use_mobile = "' . $mo . '"');
            if ($user && $user->use_id > 0) {
                echo '1';
                exit();
            }
        }
        echo '0';
        exit();
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

    function _exist_username()
    {
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function _exist_username_use_phone()
    {
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('mobile_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function exist_usename_email()
    {
        $email = $this->input->post('email');
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($email))) . "' OR use_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' OR use_mobile = '" . trim(strtolower($this->filter->injection_html($email))) . "'")) > 0) {
            echo "1";
            exit();
        }
        echo "0";
        exit();
    }

    function exist_usename_idcard()
    {
        $grop = $this->uri->segment(4);
        $idcard = $this->input->post('idcard');
        if ($grop == 'affiliate') {
            $grop_id2_list = $this->user_model->fetch("use_id, use_group, id_card", "(use_group = 2 OR use_group > 3) AND id_card = '" . $idcard . "'");
            $grop_id2 = count($grop_id2_list);
            if ($grop_id2 > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        } elseif ($grop == 'afstore' || $grop == 'estore') {
            $grop_id2_list = $this->user_model->fetch("use_id, use_group, id_card", "(use_group = 2 OR use_group > 3) AND id_card = '" . $idcard . "'");
            $grop_id2 = count($grop_id2_list);
            $grop_id3_list = $this->user_model->fetch("use_id, use_group, id_card", "use_group >= 3 AND id_card = '" . $idcard . "'");
            $grop_id3 = count($grop_id3_list);
            if ($grop_id3 > 0 && $grop_id2 >= 0) {
                echo "1";
                exit();
            } elseif ($grop_id2 > 0 && $grop_id3 == 0) {
                echo "2";
            } else {
                echo "0";
            }
            exit();
        } elseif ($grop == 'all' || $grop == 'staffs' || $grop == 'tree') {
            $grop_all_list = $this->user_model->fetch("use_id, use_group, id_card", "id_card = '" . $idcard . "'");
            $grop_all = count($grop_all_list);
            if ($grop_all > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        }
        exit();
    }

    function exist_usename_taxcode()
    {
        $grop = $this->uri->segment(4);
        $taxcode = $this->input->post('taxcode');
        if ($grop == 'affiliate') {
            $grop_id2_list = $this->user_model->fetch("use_id, use_group, tax_code", "(use_group = 2 OR use_group > 3) AND tax_code = '" . $taxcode . "'");
            $grop_id2 = count($grop_id2_list);
            if ($grop_id2 > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        } elseif ($grop == 'afstore' || $grop == 'efstore') {
            $grop_id3_list = $this->user_model->fetch("use_id, use_group, tax_code", "use_group >= 3 AND tax_code = '" . $taxcode . "'");
            $grop_id3 = count($grop_id3_list);
            if ($grop_id3 > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        } elseif ($grop == 'all' || $grop == 'staffs' || $grop == 'tree') {
            $grop_all_list = $this->user_model->fetch("use_id, use_group, tax_code", "tax_code = '" . $taxcode . "'");
            $grop_all = count($grop_all_list);
            if ($grop_all > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        }
        exit();
    }

    function exist_usename_mobile()
    {
        $grop = $this->uri->segment(4);
        $mobile = $this->input->post('mobile');
        if ($grop == 'affiliate') {
            $grop_id2_list = $this->user_model->fetch("use_id, use_group, use_mobile", "(use_group = 2 OR use_group > 3) AND use_mobile = '" . $mobile . "'");
            $grop_id2 = count($grop_id2_list);
            if ($grop_id2 > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        } elseif ($grop == 'afstore' || $grop == 'efstore') {
            $grop_id3_list = $this->user_model->fetch("use_id, use_group, tax_code", "use_group >= 3 AND use_mobile = '" . $mobile . "'");
            $grop_id3 = count($grop_id3_list);
            if ($grop_id3 > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        } elseif ($grop == 'all' || $grop == 'staffs' || $grop == 'tree') {
            $grop_all_list = $this->user_model->fetch("use_id, use_group, use_mobile", "use_mobile = '" . $mobile . "'");
            $grop_all = count($grop_all_list);
            if ($grop_all > 0) {
                echo "1";
                exit();
            }
            echo "0";
            exit();
        }
        exit();
    }

    function exist_usename()
    {
        $username = $this->input->post('username');
        if (count($this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($username))) . "'")) > 0) {
            echo "1";
            exit();
        }
        echo "0";
        exit();
    }

    function _exist_email()
    {
        if (count($this->user_model->get("use_id", "use_email = '" . trim(strtolower($this->filter->injection_html($this->input->post('email_regis')))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function _is_phone($str)
    {
        if ($this->check->is_phone($str)) {
            return true;
        }
        return false;
    }

    function _valid_nick($str)
    {
        if (preg_match('/[^0-9a-z._-]/i', $str)) {
            return false;
        }
        return true;
    }

    function _valid_captcha($str)
    {
        if ($this->session->userdata('sessionCaptchaRegister') && $this->session->userdata('sessionCaptchaRegister') === strtoupper($str)) {
            $this->session->unset_userdata('sessionCaptchaRegister');
            return true;
        }
        return false;
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

    function loadCategoryRoot($parent, $level)
    {
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }

    //Check by Ajax, addBranch from Shop <by Bao Tran, not use>
    function checkAziBranch()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = $this->package_user_model->getPackageAziBranch((int)$this->session->userdata('sessionUser'));
            if ($result) {
                //Lấy Address của GH, ProvinceCode
                $provinceUser = $this->user_model->get('use_province', 'use_id = ' . (int)$this->session->userdata('sessionUser'));
                if ($result->unit == 'Trong tỉnh' && $result->limit == -1 && $provinceUser->use_province != $this->input->post('user_province_put')) {
                    echo '1';
                    exit();
                } else {
                    echo '2';
                    exit;
                }
            } else {
                die("");
            }
        } else {
            redirect(base_url()); die;
        }
    }

    public function getMainDomain()
    {
        $result = base_url();
        $sub = $this->getShopLink();
        if ($sub != '') {
            $result = str_replace('//' . $sub . '.', '//', $result);
        }
        return $result;
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

    public function addsubadmin()
    {
        $data['menuPanelGroup'] = 4;
        $data['menuSelected'] = 'hanhchinh';
        $data['menuType'] = 'account';
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->session->userdata('sessionUser') < 0) {
            redirect(base_url() . "account", 'location');
        }
        if ($this->input->post('addsubadmin') == 1) {
            $this->load->helper('form');
            $this->load->library('form_validation');
                /*set_rules*/
            $this->form_validation->set_rules('use_fullname', 'Họ và Tên', 'required');
            $this->form_validation->set_rules('use_email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('username_regis', 'Tên đăng nhập', 'trim|required|alpha_dash|min_length[6]|max_length[35]|callback__exist_username');
            $this->form_validation->set_rules('use_password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[35]');
            $this->form_validation->set_rules('use_mobile', 'Số di động', 'trim|required|callback__is_phone');
            $this->form_validation->set_rules('use_district', 'Quận/Huyện', 'required');
            $this->form_validation->set_rules('use_province', 'Tỉnh/Thành', 'required');
            $this->form_validation->set_rules('use_address', 'Địa chỉ', 'required');
            $this->form_validation->set_rules('use_birthday', 'Ngày sinh', 'required');
            $this->form_validation->set_rules('use_sex', 'Giới tính', 'required');
                /*set_message*/
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
            $this->form_validation->set_message('_exist_username', $this->lang->line('_exist_username_message_defaults'));
            $this->form_validation->set_message('_exist_email', $this->lang->line('_exist_email_message_defaults'));
            $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');


            if ($this->form_validation->run() != false) {
                $salt = $this->hash->key(8);
                $birthday = $this->input->post('use_birthday');
                $datapost = array(
                    'use_fullname' => $this->input->post('use_fullname'),
                    'use_email' => $this->input->post('use_email'),
                    'use_username' => trim(strtolower($this->filter->injection_html($this->input->post('username_regis')))),
                    'use_password' => $this->hash->create($this->input->post('use_password'), $salt, 'md5sha512'),
                    'use_salt' => $salt,
                    'use_key' => $this->hash->create($this->input->post('username_regis'), $this->input->post('use_email'), 'sha256md5'),
                    'use_mobile' => $this->input->post('use_mobile'),
                    'use_province' => $this->input->post('use_province'),
                    'user_district' => $this->input->post('use_district'),
                    'use_address' => $this->input->post('use_address'),
                    'use_birthday' => mktime(0, 0, 0, date('m', strtotime($birthday)), date('d', strtotime($birthday)), date('Y', strtotime($birthday))),
                    'use_sex' => $this->input->post('use_sex'),
                    'parent_id' => $this->session->userdata('sessionUser'),
                    'use_group' => 16,
                    'use_status' => 1,
                    'use_regisdate' => $currentDate
                );
                if ($this->db->insert("tbtt_user", $datapost)) {
                    $usid = mysql_insert_id();
                    $this->load->model('permission_menu_model');
                    $datapost = array('pm_listmenu' => '', 'pm_userid' => $usid, 'pm_parentuser' => $this->session->userdata('sessionUser'));
                    $this->permission_menu_model->add($datapost);
                }
                $this->db->trans_complete();
                if ($this->db->trans_status() === false) {
                    $data['insertsuccess'] = 0;
                } else {
                    $data['insertsuccess'] = 1;
                }
            } else {
                $datapost = array(
                    'use_fullname' => $this->input->post('use_fullname'),
                    'use_email' => $this->input->post('use_email'),
                    'use_username' => $this->input->post('username_regis'),
                    'use_password' => $this->input->post('use_password'),
                    'use_mobile' => $this->input->post('use_mobile'),
                    'use_province' => $this->input->post('use_province'),
                    'user_district' => $this->input->post('use_district'),
                    'use_address' => $this->input->post('use_address'),
                    'use_birthday' => $this->input->post('use_birthday'),
                    'use_sex' => $this->input->post('use_sex')
                );
                $data['datapost'] = $datapost;
                $data['insertsuccess'] = 0;
            }
        }
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");

        $this->load->view('home/account/staffsubadmin/addsubadmin', $data);
    }

    public function editsubadmin($userid)
    {
        $data['menuPanelGroup'] = 4;
        $data['menuSelected'] = 'hanhchinh';
        $data['menuType'] = 'account';
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->session->userdata('sessionUser') < 0) {
            redirect(base_url() . "account", 'location');
        }
        if ($this->input->post('updatesubadmin') == 1) {
            $this->load->helper('form');
            $this->load->library('form_validation');
                /*set_rules*/
            $this->form_validation->set_rules('use_fullname', 'Họ và Tên', 'required');
            $this->form_validation->set_rules('use_district', 'Quận/Huyện', 'required');
            $this->form_validation->set_rules('use_province', 'Tỉnh/Thành', 'required');
            $this->form_validation->set_rules('use_address', 'Địa chỉ', 'required');
            $this->form_validation->set_rules('use_birthday', 'Ngày sinh', 'required');
            $this->form_validation->set_rules('use_sex', 'Giới tính', 'required');
                /*set_message*/
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');

            if ($this->form_validation->run() != false) {
                $salt = $this->hash->key(8);
                $birthday = $this->input->post('use_birthday');
                $datapost = array(
                    'use_fullname' => $this->input->post('use_fullname'),
                    'use_province' => $this->input->post('use_province'),
                    'user_district' => $this->input->post('use_district'),
                    'use_address' => $this->input->post('use_address'),
                    'use_birthday' => mktime(0, 0, 0, date('m', strtotime($birthday)), date('d', strtotime($birthday)), date('Y', strtotime($birthday))),
                    'use_sex' => $this->input->post('use_sex')
                );
                $this->db->where('use_id', $userid);
                $this->db->update("tbtt_user", $datapost);
                $this->db->trans_complete();
                if ($this->db->trans_status() === false) {
                    $data['updatesuccess'] = 0;
                } else {
                    $data['updatesuccess'] = 1;
                }

            } else {
                $data['updatesuccess'] = 0;
            }
        }

        $data['supadmin'] = $this->user_model->get("use_fullname,use_email,use_username,use_mobile,use_province,user_district,use_address,use_birthday,use_sex", "use_id = '$userid'");
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => $data['supadmin']->use_province));

        $this->load->view('home/register/editsubadmin', $data);
    }
    //dang ky tai khoan affiliate
    public function affiliate($uid){
        if ($this->session->userdata('sessionUser')) {
            redirect(base_url() . 'account', 'location');
            die;
        }
        $data['uid'] = $uid;
        if ($this->input->post('phone_num') && $this->input->post('phone_num') != '') {
            // Check number phone
            $user = $this->user_model->get('use_id', 'use_mobile = "' . $this->input->post('phone_num') . '"');
            $user2 = $this->user_model->get('use_id', 'use_phone = "'    . $this->input->post('phone_num') . '"');
            if (($user && $user->use_id > 0) ||  ($user2 && $user2->use_id > 0)) {
                $this->session->set_flashdata('_sessionErrorLogin', 'Số điện thoại này đã có người sử dụng. Vui lòng kiểm tra lại và nhập số khác!');
                redirect(base_url() . 'register/affiliate/user/'.$uid, 'location');
                die;
            } 
            // Init Curl to VHT API
            $this->load->model('authorized_code_model');
            $mobile = trim($this->filter->injection_html($this->input->post('phone_num')));
            $chars = '0123456789';
            $key = '';
            for ($i = 0; $i < 6; $i++) {
                $key = $key . substr($chars, rand(0, strlen($chars) - 1), 1);
            }

            $dataAdd = array(
                'code' => $key,
                'mobile' => $mobile,
                'during' => 600,
                'create_date' => date('Y-m-d H:i:s'),
                'active' => 0
            );

            if ($this->authorized_code_model->add($dataAdd)) {
                $keyVht = 'Mncvcskh';
                $secretVht = 'Mdhadjhdladvbmnsdha';
                $text = "Ma kich hoat cua so dien thoai " . $mobile . " la " . $key;

                $data = [
                    'submission' => [
                        'api_key' => 'Mncvcskh',
                        'api_secret' => 'Mdhadjhdladvbmnsdha',
                        'sms' => [
                            [
                                'id' => 0,
                                'brandname' => 'azibai.com',
                                'text' => 'Ma xac thuc tai khoan azibai.com cua ban ' . $key,
                                'to' => $mobile,
                            ],
                        ],
                    ],
                ];
                $dataString = json_encode($data);
                $ch = curl_init('http://sms3.vht.com.vn/ccsms/Sms/SMSService.svc/ccsms/json');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($dataString)
                    )
                );
                $respon = curl_exec($ch);
                $result = json_decode($respon);   
                // echo '<pre>';
                // print_r($result); die;

                if ((int)$result->response->submission->sms[0]->status === 0) {
                    $this->session->set_userdata('phone_num', $mobile);
                    $this->session->set_userdata('uid', $uid);
                    redirect(base_url() . 'register/account', 'location');
                    die;
                } else {
                    $msg = '';
                    switch ((int)$result->response->submission->sms[0]->status) {
                        case 7:
                            $msg = 'Thuê bao quý khách từ chối nhận tin. Vui lòng cài đặt lại!';
                            break;
                        case 10:
                            $msg = 'Không phải thuê bao di dộng. Vui lòng kiểm tra lại!';
                            break;
                        default:
                            $msg = 'Hệ thống lỗi. Vui lòng thử lại!';
                            break;
                    }
                    $this->session->set_flashdata('_sessionErrorLogin', $result->response->submission->sms[0]->status . ' - ' . $msg);
                    redirect(base_url() . 'register/affiliate', 'location');
                    die;
                }
            }
        }    
        #Load view
        $this->load->view('home/register/affiliate', $data);
    }



    function product_affiliate($parentID, $userId) {
        $this->load->model('product_affiliate_user_model');
        $product = $this->product_model->getProducts(['select' => 'pro_id', 'where' => 'pro_user = '.$parentID.' AND   pro_of_shop = 0 AND is_product_affiliate = 1' ]);

        if (!empty($product)) {
            $dataInsert = array();
            foreach ($product as $key => $value) {
                $dataInsert[] = array('use_id' => $userId, 'pro_id' => $value->pro_id, 'homepage' => 1, 'date_added' => time(), 'kind_of_aff' => 1);
            }
            if (!empty($dataInsert)) {
                $this->product_affiliate_user_model->add_all($dataInsert);
            }
        }
    }  
    

}