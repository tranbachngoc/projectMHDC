<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Shop extends MY_Controller
{
    private $mainURL;
    private $subURL;
    private $shop_url = '';
    private $shop_current = '';
    private $has_af_key = false;
    private $list_bran = '';

    public $_config = [
        'full_tag_open' => '<nav class="nav-pagination pagination-style mt-3"><ul class="pagination">',
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

    function __construct()
    {
        parent::__construct();
        $this->config->load('config_api');

        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }

        $this->load->helper('cookie');
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/shop');
        #Load model
        $this->load->model('shop_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->model('product_favorite_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('detail_product_model');
        $this->load->model('package_user_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('content_model');
        $this->load->model('banner_model');
        $this->load->model('share_model');
        $this->load->model('comment_model');
        $this->load->model('shop_rule_model');
        $this->load->model('master_shop_rule_model');
        $this->load->model('ads_model');
        $this->load->model('notify_model');
        $this->load->model('reports_model');
        $this->load->model('eye_model');
        $this->load->model('package_daily_user_model');
        $this->load->model('advertise_model');
        $this->load->model('product_promotion_model');
        $this->load->model('images_model');
        $this->load->library('pagination');
        $this->load->model('collection_model');
        $this->load->model('customlink_model');
        $this->load->model('album_model');

        /////SETTING PATH
        $this->mainURL = $this->getMainDomain();
        $this->subURL = base_url();
        /////

        //check has af_key
        if (!empty($_REQUEST['af_id'])) {
            $af_key = $_REQUEST['af_id'];
            $check = $this->user_model->get("af_key", "af_key = '$af_key'");
            if(!empty($check)){
                $check = $check->af_key;
            }
            $check != '' ? $this->has_af_key = true : $this->has_af_key = false;
        };
        $data['has_af_key'] = $this->has_af_key;

        $this->shop_current = $shop = MY_Loader::$static_data['hook_shop'];
        if($this->session->userdata('sessionUser') > 0 && $this->shop_current->sho_id > 0) {
            $login_user = $this->session->userdata('sessionUser');
            $shop_id_1 = $this->shop_current->sho_id;
            $sql = "SELECT *
            FROM tbtt_shop_follow, (SELECT sho_id AS shop_id_2 FROM tbtt_shop WHERE sho_user = $login_user) temp
            WHERE (shop_id = $shop_id_1 AND follower = temp.shop_id_2) OR (shop_id = temp.shop_id_2 AND follower = $shop_id_1)";
            $is_follow_shop = $this->db->query($sql)->row_array();
            $this->shop_current->is_follow_shop = $is_follow_shop ? true : false;
        }
        $this->shop_url = !empty($this->shop_current) ? $this->shop_current->shop_url : getAliasDomain();
        $data['shop_current'] = $this->shop_current;
        $data['mainURL'] = $this->mainURL;
        $data['shop_url'] = $this->shop_url;

        //check visit from azibai => for get header shop
        $data['visited_azibai'] = $this->session->userdata('visited_azibai');

        #BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }
        #END Update counter
        #BEGIN Eye
        if ($this->session->userdata('sessionUser') > 0) {
            $cur_user = $this->user_model->get('use_id,use_username,avatar,af_key', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $data['af_id'] = $cur_user->af_key;
            }
            $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
            $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
            $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));
        } else {
            $data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');
            $data['listeyeraovat'] = $this->eye_model->geteyetypenologin('raovat');
            $data['listeyehoidap'] = $this->eye_model->geteyetypenologin('hoidap');
        }
        #END Eye
        #BEGIN: Ads & Notify Taskbar
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;
        $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;

        #BEGIN: Top lastest ads right
        $select = "ads_id, ads_title, ads_descr, ads_category";
        $start = 0;
        $limit = (int)settingAdsNew_Top;
        $data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
        #END Top lastest ads right
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Notify
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_enddate  >= $currentDate", "not_degree", "DESC");
        #END Notify
        $data['menuType'] = 'shop';
        $retArray = $this->loadCategory(0, 0);
        $data['menu'] = $retArray;
        // $data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
        // $data['productCategoryHot'] = $this->loadCategoryHot(0, 0);
        # BEGIN popup right
        # Tin tức
        $select = "not_id, not_title, not_image,not_dir_image, not_begindate";
        $data['listNews'] = $this->content_model->fetch($select, "not_status = 1 AND cat_type = 1 AND not_publish = 1", "not_id", "DESC", 0, 10);
        # Hàng yêu thích
        $select = 'prf_id, prf_product, prf_user, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost ';
        $join = 'INNER';
        $table = 'tbtt_product';
        $on = 'tbtt_product_favorite.prf_product = tbtt_product.pro_id';
        $where = 'prf_user = ' . (int)$this->session->userdata('sessionUser');
        $data['favoritePro'] = $this->product_favorite_model->fetch_join($select, $join, $table, $on, $where, 0, 10);
        # Hàng gợi ý
        $select = "pro_id, pro_name, pro_cost, pro_image, pro_dir, pro_category, ";
        $whereTmp = "pro_status = 1  and is_asigned_by_admin = 1";
        $products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC", 0, 10);
        $data['products'] = $products;
        # END popup right

        $idpro_get = $this->uri->segment(segmentThird);
        $idnews_get = $this->uri->segment(segmentSecond);
        if ((int)$idpro_get > 0) {
            $itempro = $this->product_model->get('pro_name, pro_dir, pro_image, pro_descr', 'pro_status = 1 AND pro_id = '. (int)$idpro_get);
            $img_pro = explode(',', $itempro->pro_image);
            $data['ogtitle'] = $itempro->pro_name;
            $check_http = explode(':', $img_pro[0])[0];
            if($check_http == 'http' || $check_http == 'https'){
                $og_image = $img_pro[0];
            }else{
                $og_image = DOMAIN_CLOUDSERVER .'media/images/product/'. $itempro->pro_dir .'/thumbnail_2_'. $img_pro[0];
            }
            $data['ogimage'] = $og_image;
            $data['ogdescription'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($itempro->pro_descr)), 255);
        }

        $data['sho_package'] = $this->getConditionsShareNews($this->session->userdata('sessionGroup'), $this->session->userdata('sessionUser'));
        $data['permission'] = $this->db->query('SELECT * FROM `tbtt_permission`')->result();

        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
        }

        if (!empty($this->shop_current->sho_user)) 
        {
            $this->list_bran = $this->user_model->get_list_user("use_id, use_group, use_username, use_fullname, use_slug, avatar, sho_id, sho_name, sho_logo, sho_dir_logo, sho_mobile, sho_address, sho_district, sho_provinces, sho_dir_banner, sho_banner, sho_link, domain", "use_group = 14 AND use_status = 1 AND parent_id = ". $this->shop_current->sho_user, 'LEFT', 'tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
            $data['list_bran'] = $this->list_bran;
        }

        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }

    function loadCategory($parent, $level)
    {
        $this->load->model('shop_category_model');
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->shop_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<ul id='mega-1' class='mega-menu right'>";
            foreach ($category as $key => $row) {
                $link = '<a href="' . $this->mainURL . 'gianhang/' . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
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
        $this->load->model('shop_category_model');
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->shop_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
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
                $link = '<a class="mega-hdr-a"  href="' . $this->mainURL . 'gianhang/' . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
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
        $this->load->model('shop_category_model');
        $category = $this->shop_category_model->fetch($select, $whereTmp, "cat_name", "ASC", "0", "5");
        if (count($category) > 0) {
            $retArray .= "<ul>";
            foreach ($category as $key => $row) {
                $link = '<a href="' . $this->mainURL . 'gianhang/' . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $retArray .= "<li>" . $link . "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
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

    function index()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'shop_index';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right

        $select = "sho_name, sho_link, sho_descr, sho_begindate";
        $start = 0;
        $limit = (int)settingShopSaleoff_Top;
        $data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
        #END Top shop saleoff right
        #BEGIN: Top productest right
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopProductest_Top;
        $data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
        #END Top productest right
        #BEGIN: Interest shop
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopInterest;
        $data['interestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_view", "DESC", $start, $limit);
        #END Interest shop
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(segmentFirst, $action);
        #BEGIN: Sort
        $where = "sho_status = 1 AND sho_enddate >= $currentDate";
        $sort = 'sho_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "sho_name";
                    break;
                case 'address':
                    $pageUrl .= '/sort/address';
                    $sort = "sho_address";
                    break;
                case 'product':
                    $pageUrl .= '/sort/product';
                    $sort = "sho_quantity_product";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "sho_view";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = $this->mainURL . 'gianhang/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = $this->mainURL . 'gianhang' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingShopNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
        $limit = settingShopNew_Category;
        #Load view
        $this->load->view('home/shop/defaults', $data);
    }

    function category($categoryID)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
        $category = $this->shop_category_model->get("cat_id, cat_name, cat_descr, keyword, h1tag, cate_type", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect($this->mainURL, 'location'); die();
        }

        #END Check exist category by $categoryID
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'shop_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
        $select = "sho_name, sho_link, sho_descr, sho_begindate";
        $start = 0;
        $limit = (int)settingShopSaleoff_Top;
        $data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
        #END Top shop saleoff right
        #BEGIN: Top productest right
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopProductest_Top;
        $data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
        #END Top productest right
        #BEGIN: Interest shop
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopInterest_Category;
        $data['interestShop'] = $this->shop_model->fetch($select, "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate", "sho_view", "DESC", $start, $limit);
        #END Interest shop
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(segmentThird, $action);
        #BEGIN: Sort
        $where = "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate";
        $sort = 'sho_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "sho_name";
                    break;
                case 'address':
                    $pageUrl .= '/sort/address';
                    $sort = "sho_address";
                    break;
                case 'product':
                    $pageUrl .= '/sort/product';
                    $sort = "sho_quantity_product";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "sho_view";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = $this->mainURL . 'gianhang/' . $categoryID . '/' . RemoveSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = $this->mainURL . 'shop/category/' . $categoryID . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingShopNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
        $limit = settingShopNew_Category;

        if ($category->h1tag != '') {
            $data['titleSiteGlobal'] = str_replace(",", "|", $category->h1tag);
        } else {
            $data['titleSiteGlobal'] = $category->cat_name;
        }
        $data['keywordSiteGlobal'] = $category->keyword;
        $data['h1tagSiteGlobal'] = $category->h1tag;
        $this->load->helper('text');
        $data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)), 255);
        #Load view
        $this->load->view('home/shop/category', $data);
    }

    function category_gianhang($categoryID)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
        $category = $this->category_model->get("cat_id, cat_name, cat_descr, cate_type", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect($this->mainURL, 'location');
            die();
        }

        #END Check exist category by $categoryID
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'shop_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
        $select = "sho_name, sho_link, sho_descr, sho_begindate";
        $start = 0;
        $limit = (int)settingShopSaleoff_Top;
        $data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
        #END Top shop saleoff right
        #BEGIN: Top productest right
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopProductest_Top;
        $data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
        #END Top productest right
        #BEGIN: Interest shop
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopInterest_Category;
        $data['interestShop'] = $this->shop_model->fetch($select, "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate", "sho_view", "DESC", $start, $limit);
        #END Interest shop
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(segmentThird, $action);
        #BEGIN: Sort
        $where = "sho_category = $categoryIDQuery AND sho_status = 1 AND sho_enddate >= $currentDate";
        $sort = 'sho_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "sho_name";
                    break;
                case 'address':
                    $pageUrl .= '/sort/address';
                    $sort = "sho_address";
                    break;
                case 'product':
                    $pageUrl .= '/sort/product';
                    $sort = "sho_quantity_product";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "sho_view";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = $this->mainURL . 'gianhang/' . $categoryID . '/' . RemoveSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = $this->mainURL . 'shop/category/' . $categoryID . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingShopNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
        $limit = settingShopNew_Category;
        //$data['shop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, $sort, $by, $start, $limit);
        #Load view

        $data['titleSiteGlobal'] = $category->cat_name;
        $this->load->helper('text');
        $data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)), 255);

        $this->load->view('home/shop/category_gianhang', $data);
    }

    function saleoff()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'shop_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_lastest_shop,top_productest_shop';
        #BEGIN: Top lastest shop right
        $select = "sho_name, sho_link, sho_descr";
        $start = 0;
        $limit = (int)settingShopNew_Top;
        $data['topLastestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_id", "DESC", $start, $limit);
        #END Top lastest shop right
        #BEGIN: Top productest right
        $select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
        $start = 0;
        $limit = (int)settingShopProductest_Top;
        $data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
        #END Top productest right
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(segmentSecond, $action);
        #BEGIN: Sort
        $where = "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate";
        $sort = 'sho_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "sho_name";
                    break;
                case 'address':
                    $pageUrl .= '/sort/address';
                    $sort = "sho_address";
                    break;
                case 'product':
                    $pageUrl .= '/sort/product';
                    $sort = "sho_quantity_product";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "sho_view";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "sho_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = $this->mainURL . 'shop/saleoff/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->shop_model->fetch_join("sho_id", "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, "", ""));
        $config['base_url'] = $this->mainURL . 'shop/saleoff' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingShopSaleoff;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, pre_name";
        $limit = settingShopSaleoff;
        $data['saleoffShop'] = $this->shop_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_shop.sho_province = tbtt_province.pre_id", "", "", "", $where, $sort, $by, $start, $limit);
        #Load view
        $this->load->view('home/shop/saleoff', $data);
    }

    ############## Part domainshop.azibai.com ######################


    /******************************************************************************
     *******************************************************************************/
    /**
     *   Newest  :   domainshop.azibai.com
     *   by      :   Bao Tran edit
     *   date    :   11/08/2017
     **/

    /**
     *   CI_Controller   : domainshop.azibai.com/shop & domainshop.azibai.com/news
     *   by              : Bao Tran edit
     *   date(format)    : 14/08/2017
     **/

    function myshop_design1()
    {
        $linkShop = $this->getShopLink(); // ==> sho_link in tbtt_shop
        $param1   = $this->uri->segment(segmentFirst); // ==> get string "shop" is pass
        $this->load->model('images_model');
        $this->load->model('videos_model');
        $this->load->model('customlink_model');
        $this->load->model('product_affiliate_user_model');

        if (!isset($param1) && empty($param1) && ($param1 !== 'shop' || $param1 !== 'news')) {
            redirect($this->mainURL, 'location');
            die;
        }

        $shop_ = $this->shop_current;
        $data['aliasDomain']        = $shop_->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        
        $data['descrSiteGlobal']    = ($shop_->sho_description != '') ? $shop_->sho_description : settingDescr;
        $data['keywordSiteGlobal']  = $shop_->sho_keywords;
        $data['ogurl']              = $linktoshop;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop_->sho_name;
        $data['ogdescription']      = $shop_->sho_descr;
        $data['linktoshop']         = $linktoshop;
        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];
        $ogimage            = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop_->sho_dir_banner . '/' . $shop_->sho_banner;

        $group_id = (int)$this->session->userdata('sessionGroup');
        $sessionUser = $user_id  = (int)$this->session->userdata('sessionUser');

        if ($sessionUser) {
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite,use_fullname", "use_id = " . $sessionUser);
            if (in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true))) {
                $myshop = $this->shop_model->get("sho_link, domain", "sho_user = " . $sessionUser);
                //Get AF Login
                // $data['af_id'] = $data['currentuser']->af_key;
            } elseif ($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15) {
                $parentUser = $this->user_model->get("parent_id", "use_id = " . $sessionUser);
                $myshop = $this->shop_model->get("sho_link, domain", "sho_user = " . $parentUser->parent_id);
            }
            $data['myshop'] = $myshop;
        }

        $currentDate          = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data['menuSelected'] = 'home';

        #BEGIN: Get shop by $linkShop
        $shop               = $this->shop_model->get('*', 'sho_link = "' . $this->filter->injection($linkShop) . '" AND sho_status = 1');
        if (empty($shop)) {
            redirect($this->mainURL . 'page-not-found');
            die;
        }

        if (count($shop) != 1 || strlen(trim($linkShop)) < 5 || strlen(trim($linkShop)) > 100) {
            redirect($this->mainURL, 'location');
            die;
        }

        $shop->sho_district = $shop->sho_district ? $this->district_model->get('DistrictName', 'DistrictCode = "' . $shop->sho_district . '"')->DistrictName : '';
        $shop->sho_province = $shop->sho_province ? $this->province_model->get('pre_name', 'pre_id = ' . (int)$shop->sho_province)->pre_name : '';

        if ($shop->sho_user > 0) {
            // $query = $this->db->query("SELECT use_id, use_email, af_key, use_group, use_username, use_fullname, avatar, parent_id FROM tbtt_user WHERE use_id = " . (int)$shop->sho_user);
            // $row = $query->row();
            $row               = $this->user_model->get('use_id, use_email, af_key, use_group, use_username, use_fullname, avatar, parent_id', 'use_id = ' . (int)$shop->sho_user);
            $shop->sho_email   = $row->use_email;
            $shop->af_key      = $row->af_key;
            $shop->isAffiliate = $row->use_group == 2 ? TRUE : FALSE;
            $shop->isBranch    = $row->use_group == 14 ? TRUE : FALSE;
            $shop->parent      = $row->parent_id;
        }

        ##BEGIN:: protocal & domainName
        $protocol           = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName         = $_SERVER['HTTP_HOST'];
        $data['protocol']   = $protocol;
        $data['domainName'] = $domainName;
        ##END:: protocal & domainName

        $idUser              = (int)$shop->sho_user;
        $data['siteGlobal']  = $shop;
        $data['isAffiliate'] = $shop->isAffiliate;
        $data['isBranch']    = $shop->isBranch;
        $data['URLRoot']     = $this->subURL;
        $data['mainURL']     = $this->mainURL;
        $data['shopId']      = (int)$shop->sho_user;
        $data['aliasDomain'] = $shop->shop_url;
        $linktoshop          = substr($data['aliasDomain'], 0, -1);

        #BEGIN: Update view
        if (!$this->session->userdata('sessionViewShopDetail_' . $shop->sho_id)) {
            $this->shop_model->update(array('sho_view' => (int)$shop->sho_view + 1), 'sho_id = ' . $shop->sho_id);
            $this->session->set_userdata('sessionViewShopDetail_' . $shop->sho_id, 1);
        }
        #END Update view
        #BEGIN: Exist af_key, for product detail
        $af_id = '';
        if(isset($_REQUEST['af_id'])){
            $af_id = $_REQUEST['af_id'];
        }
        if ($af_id != '') {
            $userObject = $this->user_model->get('*', 'af_key = "' . $af_id . '"');
            if (!empty($userObject) && $userObject->use_id > 0) {
                $this->session->set_userdata('af_id', $af_id);
                //setcookie('af_id', $af_id, time() + (86400 * 7), '/'); // 86400 = 1 day
            }
        }
        $getUser           = $this->user_model->get('use_group, parent_id', 'use_id = ' . $idUser);
        $data['UserGroup'] = $getUser->use_group;
        #END: Exist af_key, for product detail
        #BEGIN: Load category
        $listCategory = array();
        if ($shop->isAffiliate) {
            /**
             *  Step1: Affiliate is get Shop or Bran nearest
             *  Step2: Get product their
             *  Step3: Get my product selected
             **/

            // Step1:: Get SHOP_ID or CHINHANH_ID gần nhất trong cây
            $shop_Id = $this->get_id_shop_in_tree((int)$shop->sho_user);

            // Step2:: Get product their
            $list_pro_aff  = $this->product_affiliate_user_model->fetch('pro_id', 'use_id = ' . (int)$shop->sho_user . ' AND homepage = 1');
            $li_pro_af     = array();
            $li_pro_af_str = '0';
            if ($list_pro_aff) {
                foreach ($list_pro_aff as $k => $v) {
                    $li_pro_af[] = $v->pro_id;
                }
                $li_pro_af_str = implode(',', $li_pro_af);
            }

            $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE (pro_user = ' . $shop_Id . ' OR pro_id IN (' . $li_pro_af_str . ')) AND pro_status = 1 AND is_product_affiliate = 1';
            $result      = $this->db->query($cat_pro_aff);
            $arrylist    = $result->result();

            if (count($arrylist) > 0) {
                $catid = array();
                foreach ($arrylist as $k => $item) {
                    if ($item->pro_category > 0) {
                        array_push($catid, $item->pro_category);
                    }
                }
                $catarr = implode(',', $catid);
                if ($catarr != '') {
                    $sql = 'SELECT cat_id, cat_name, cate_type FROM tbtt_category
                            WHERE cat_id IN (' . $catarr . ') ORDER BY cat_name ASC ';
                    $query                = $this->db->query($sql);
                    $data['listCategory'] = $query->result();
                }
            }

            $Pa_Shop_Global         = $this->shop_model->get('*', 'sho_user = ' . $shop_Id);
            $data['Pa_Shop_Global'] = $Pa_Shop_Global;
            $data['shopId']         = $shop_Id; // Redefine Shop ID
            $data['li_pro_id']      = $li_pro_af_str; // Get list product id selected
            $data['af_id']          = $row->af_key;
            $data['tlink']          = 'afproduct';
            $data['afLink']         = 'afcoupon';

            if ($Pa_Shop_Global->domain) {
                $domain_parent = $protocol . $Pa_Shop_Global->domain;
            } else {
                $domain_parent = $protocol . $Pa_Shop_Global->sho_link . '.' . domain_site;
            }
        } else {
            // ==> Gian hang va Chi nhanh dung chung
            $cat_pro_shop = 'SELECT DISTINCT(pro_category) FROM `tbtt_product` WHERE `pro_user` = ' . (int)$shop->sho_user . ' AND pro_status = 1';
            $result       = $this->db->query($cat_pro_shop);
            $arrylist     = $result->result();
            $catid        = array();
            if (count($arrylist) > 0) {
                foreach ($arrylist as $k => $item) {
                    if ($item->pro_category > 0) {
                        array_push($catid, $item->pro_category);
                    }
                }
                $catarr = implode(',', $catid);
                if (isset($catarr) && $catarr != '') {
                    $sql = 'SELECT `cat_id`,`cat_name`,`parent_id` AS parents, `cate_type`
                            FROM `tbtt_category` WHERE `cat_id` IN (' . $catarr . ') ORDER BY tbtt_category.cat_name ASC ';
                    $query                = $this->db->query($sql);
                    $data['listCategory'] = $query->result();
                }
            }
            $data['tlink']  = 'product';
            $data['afLink'] = 'coupon';

            ##BEGIN: Get id_key when ctv login
            if (isset($user_id) && !empty($user_id) && $group_id == AffiliateUser) {
                $af_id         = $this->user_model->get('af_key', 'use_id = ' . $user_id)->af_key;
                $data['af_id'] = $af_id;
            }
            ##END: Get id_key when ctv login
        }
        #END: Load category
        #BEGIN: Create button register CTV
        //Menu bar visible on mobile, register CTV online
        // Case login:: Pack free hide, Fee show
        $user_login = $user_id;
        $packId1    = false;
        if ($user_id && $group_id == BranchUser) {
            $user_login = $this->get_my_shop($user_id);
        }

        $check_pack1 = $this->package_user_model->getCurrentPackage($user_login);
        if ($check_pack1 && $check_pack1['id'] > 1) {
            $packId1 = true;
        }
        $data['packId1'] = $packId1;

        // Case not login:: current shop using pack have Free (show), Free (hide)
        $user_sho_link = (int)$shop->sho_user;
        $packId2       = false;
        if (!empty($row) && (int)$row->use_group != AffiliateStoreUser) {
            $user_sho_link = $this->get_my_shop((int)$shop->sho_user);
        }
        $check_pack2 = $this->package_user_model->getCurrentPackage($user_sho_link);
        if ($check_pack2 && $check_pack2['id'] > 1) {
            $packId2 = true;
        }
        $data['packId2'] = $packId2;
        #END: Create button register CTV

        $bannertops            = $this->banner_model->fetch('*', 'sho_id = ' . (int)$shop->sho_id . ' AND banner_position = 1 AND published = 1', 'order_num, id', 'ASC');
        $bannerlefts           = $this->banner_model->fetch('*', 'sho_id = ' . (int)$shop->sho_id . ' AND banner_position = 2 AND published = 1', 'order_num, id', 'ASC');
        $bannerrights          = $this->banner_model->fetch("*", "sho_id = " . (int)$shop->sho_id . " AND banner_position = 3 AND published = 1", "order_num, id", "ASC");
        $bannerbottoms         = $this->banner_model->fetch("*", "sho_id = " . (int)$shop->sho_id . " AND banner_position = 4 AND published = 1", "order_num, id", "ASC");
        $data['bannertops']    = $bannertops;
        $data['bannerlefts']   = $bannerlefts;
        $data['bannerrights']  = $bannerrights;
        $data['bannerbottoms'] = $bannerbottoms;

        $data['is_owns'] = $shop->sho_user == $user_login;
        $owns_id = 0;

        if($data['is_owns']){
            $owns_id = $shop->sho_user;
        }

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_staff->use_id;
            }
        }

        #END Globale site

        if (isset($param1) && $param1 === 'shop') {
            $param2 = $this->uri->segment(segmentSecond); // ==> get params2
            switch (strtolower($param2)) {
                case 'san-pham-tu-gian-hang':

                case 'dich-vu-tu-gian-hang':

                case 'coupon-tu-gian-hang':
                    #BEGIN: Add favorite
                    $data['successFavoriteProduct'] = false;
                    $data['isLogined']              = false;
                    #END Add favorite
                    $pageSort = '';
                    $pageUrl  = '';
                    $limit    = settingShoppingNew_List;
                    #BEGIN: Menu 2  & Module
                    $data['menuSelected'] = 'product';

                    $data['module'] = 'top_lastest_ads';
                    #END Menu 2
                    $action = array('cat', 'sort', 'by', 'page');
                    $getVar = $this->uri->uri_to_assoc(5, $action);

                    $where = "pro_status = 1 AND is_product_affiliate = 1 AND pro_user = " . $shop_Id;

                    $url = $this->uri->segment(segmentSecond);
                    if ($url == 'san-pham-tu-gian-hang') {
                        $protype            = 0;
                        $data['title_page'] = 'SẢN PHẨM TỪ GIAN HÀNG';
                    } elseif ($url == 'dich-vu-tu-gian-hang') {
                        $protype            = 1;
                        $data['title_page'] = 'DỊCH VỤ TỪ GIAN HÀNG';
                    } elseif ($url == 'coupon-tu-gian-hang') {
                        $protype            = 2;
                        $data['title_page'] = 'COUPON TỪ GIAN HÀNG';
                    }
                    $where .= " AND pro_type = " . $protype;

                    $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : 'id';
                    $getVar['by']   = $getVar['by'] != '' ? $getVar['by'] : 'desc';
                    switch (strtolower($getVar['sort'])) {
                        case 'name':
                            $pageUrl .= '/sort/name';
                            $sort    = "pro_name";
                            break;
                        case 'cost':
                            $pageUrl .= '/sort/cost';
                            $sort    = "pro_cost";
                            break;
                        case 'buy':
                            $pageUrl .= '/sort/buy';
                            $sort    = "pro_buy";
                            break;
                        case 'view':
                            $pageUrl .= '/sort/view';
                            $sort    = "pro_view";
                            break;
                        case 'date':
                            $pageUrl .= '/sort/date';
                            $sort    = "pro_begindate";
                            break;
                        default:
                            $pageUrl .= '/sort/id';
                            $sort    = "pro_id";
                    }

                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                        $pageUrl .= '/by/desc';
                        $by      = "DESC";
                    } else {
                        $pageUrl .= '/by/asc';
                        $by      = "ASC";
                    }

                    #If have page
                    if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                        $start    = (int)$getVar['page'];
                        $pageSort .= '/page/' . $start;
                    } else {
                        $start = 0;
                    }

                    $data['default_sort'] = $getVar['sort'] . '_' . $getVar['by'];
                    #BEGIN: Create link sort
                    if (!isset($getVar['cat']) || $getVar['cat'] == '' || $getVar['cat'] == 0 || empty($getVar['cat'])) {
                        $data['sortUrl'] = '/shop/' . $url . '/cat/0/sort/';
                        $getVar['cat']   = 0;
                    } else {
                        $data['sortUrl'] = '/shop/' . $url . '/cat/' . $getVar['cat'] . '/sort/';
                    }

                    #END Sort
                    #BEGIN: Create link sort
                    $data['pageSort'] = $pageSort;
                    #END Create link sort
                    #BEGIN: Pagination
                    $totalRecord           = count($this->product_model->fetch("pro_id", $where, "", ""));
                    $config['base_url']    = '/shop/' . $url . '/cat/' . $getVar['cat'] . $pageUrl . '/page/';
                    $config['total_rows']  = $totalRecord;
                    $config['per_page']    = $limit;
                    $config['num_links']   = 1;
                    $config['uri_segment'] = 5;
                    $config['cur_page']    = $start;
                    $this->pagination->initialize($config);
                    $data['linkPage'] = $this->pagination->create_links();
                    #END Pagination

                    $af_products_parent = $this->product_model->fetch('tbtt_product.*' . DISCOUNT_QUERY, $where, $sort, $by, $start, $limit);

                    $data['product'] = $af_products_parent;
                    #Start:: SEO meta tag
                    $data['descrSiteGlobal']    = $shop->sho_description;
                    $data['keywordsSiteGlobal'] = $shop->sho_keywords;
                    $data['ogurl']              = $linktoshop . '/shop/san-pham-tu-gian-hang/';
                    $data['ogtype']             = "website";
                    $data['ogtitle']            = $data['title_page'];
                    //$data['ogimage'] = '';
                    $data['ogdescription'] = $shop->sho_description;
                    #END:: SEO meta tag

                    #Load view
                    $this->load->view('shop/product/cat_af', $data);
                    break;
                #BEGIN:: Introduct
                case 'introduct':
                    $type_share = TYPESHARE_SHOP_INTRODUCT;
                    $this->load->model('share_metatag_model');

                    $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop_->sho_user.' AND type = '.$type_share);
                    if(!empty($get_avtShare)){
                        $ogimage = $get_avtShare[0]->image;
                    }
                    
                    $data['sho_user'] = $shop_->sho_user;
                    $data['type_share'] = $type_share;
                    $data['ogimage'] = $ogimage;
                    //$linktoshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link . '.' . domain_site;
                    if ($this->session->userdata('sessionGroup') == 2) {
                        $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                    } else {
                        $af = '';
                    }
                    #Start:: SEO meta tag
                    //$data['descrSiteGlobal']    = $shop->sho_description;
                    $data['keywordsSiteGlobal'] = $shop->sho_keywords;
                    $data['ogurl']              = base_url() . 'shop/introduct' . $af;
                    $data['ogtype']             = "article";
                    $data['ogtitle']            = 'Giới thiệu gian hàng';
                    //$data['ogimage'] = '';
                    //$data['ogdescription'] = $shop->sho_description;
                    #END:: SEO meta tag

                    #BEGIN: Menu
                    $data['menuSelected']    = 'introduct';
                    $data['introduction']    = htmlspecialchars_decode(html_entity_decode($shop->sho_introduction));
                    $data['company_profile'] = htmlspecialchars_decode(html_entity_decode($shop->sho_company_profile));
                    $data['certificate']     = htmlspecialchars_decode(html_entity_decode($shop->sho_certificate));
                    $data['trade_capacity']  = htmlspecialchars_decode(html_entity_decode($shop->sho_trade_capacity));
                    #Load view
                    $this->load->view('shop/defaults/intro', $data);
                    break;
                #END:: Introduct
                #BEGIN:: Contact
                case 'contact':
                    $type_share = TYPESHARE_SHOP_CONTACT;
                    
                    $this->load->model('share_metatag_model');

                    $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop_->sho_user.' AND type = '.$type_share);
                    if(!empty($get_avtShare)){
                        $ogimage = $get_avtShare[0]->image;
                    }
                    
                    $data['sho_user'] = $shop_->sho_user;
                    $data['type_share'] = $type_share;
                    $data['ogimage'] = $ogimage;
                    #BEGIN: Menu 3
                    $data['menuSelected'] = 'contact';
                    #END Menu 3
                    //$linktoshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link . '.' . domain_site;
                    if ($this->session->userdata('sessionGroup') == 2) {
                        $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                    } else {
                        $af = '';
                    }
                    #Start:: SEO meta tag
                    $address = '';
                    if($shop->sho_address != ''){
                        $address .= $shop->sho_address;
                    }
                    if($shop->sho_district != ''){
                        $address .= ','. $shop->sho_district;
                    }
                    if($shop->sho_province != ''){
                        $address .= ','. $shop->sho_province;
                    }

                    if($address == ''){
                        $address = 'Chưa cập nhật';
                    }
                    
                    //$data['descrSiteGlobal']    = $shop->sho_description;
                    $data['keywordsSiteGlobal'] = $shop->sho_keywords;
                    $data['ogurl']              = base_url() . 'shop/contact' . $af;
                    $data['ogtype']             = "website";
                    $data['ogtitle']            = 'Liên hệ gian hàng';
                    $data['ogdescription']      = 'Địa chỉ: '.$address.' | Sđt: '.$shop->sho_mobile;
                    //$data['ogimage'] = '';
                    #END:: SEO meta tag

                    $data['module'] = 'top_lastest_product';
                    #BEGIN: Top lastest product right
                    $select                    = "pro_id, pro_name, pro_descr, pro_image, pro_dir";
                    $start                     = 0;
                    $limit                     = (int)settingShoppingProductNew_Top;
                    $data['topLastestProduct'] = $this->product_model->fetch($select, "pro_user = $idUser AND pro_status = 1", "pro_id", "DESC", $start, $limit);
                    #END Top lastest product right

                    #BEGIN: Unlink captcha
                    $this->load->helper('unlink');
                    unlink_captcha($this->session->flashdata('sessionPathCaptchaContactShopDetail'));
                    #END Unlink captcha

                    if ($this->session->flashdata('sessionSuccessContactShopDetail')) {
                        $data['successContactShopDetail'] = true;
                    } else {
                        $this->load->library('form_validation');
                        $data['successContactShopDetail'] = false;
                        if ($this->input->post('captcha_contact') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                            #BEGIN: Set rules
                            $this->form_validation->set_rules('name_contact', 'lang:name_contact_label_detail_contact', 'trim|required');
                            $this->form_validation->set_rules('email_contact', 'lang:email_contact_label_detail_contact', 'trim|required|valid_email');
                            $this->form_validation->set_rules('address_contact', 'lang:address_contact_label_detail_contact', 'trim|required');
                            $this->form_validation->set_rules('phone_contact', 'lang:phone_contact_label_detail_contact', 'trim|required');
                            $this->form_validation->set_rules('title_contact', 'lang:title_contact_label_detail_contact', 'trim|required');
                            $this->form_validation->set_rules('content_contact', 'lang:content_contact_label_detail_contact', 'trim|required|min_length[10]|max_length[1000]');
                            #END Set rules
                            #BEGIN: Set message
                            $this->form_validation->set_message('required', $this->lang->line('required_message'));
                            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
                            $this->form_validation->set_message('_valid_captcha_contact', $this->lang->line('_valid_captcha_contact_message_detail_contact'));
                            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
                            #END Set message
                            if ($this->form_validation->run() != FALSE) {
                                $this->load->library('email');
                                $config['useragent'] = $this->lang->line('useragen_mail_detail_contact');
                                $config['mailtype']  = 'html';
                                $this->email->initialize($config);
                                $messageContact = $this->lang->line('info_title_sender_detail_contact')
                                    . $this->lang->line('fullname_sender_detail_contact')
                                    . $this->input->post('name_contact') . '<br/>'
                                    . $this->lang->line('address_sender_detail_contact')
                                    . $this->input->post('address_contact') . '<br/>'
                                    . $this->lang->line('phone_sender_detail_contact')
                                    . $this->input->post('phone_contact') . '<br/>'
                                    . $this->lang->line('content_sender_detail_contact')
                                    . nl2br($this->filter->html($this->input->post('content_contact')));
                                $this->email->from($this->input->post('email_contact'));
                                if (trim($shop->sho_email) != '') {
                                    $emailContact = $shop->sho_email;
                                } else {
                                    $emailContact = settingEmail_1;
                                }
                                $this->email->to($emailContact);
                                $this->email->subject($this->input->post('title_contact'));
                                $this->email->message($messageContact);

                                $folder = folderWeb;

                                //$folder='';
                                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');

                                $return_email = $this->smtpmailer($emailContact, $this->lang->line('EMAIL_MEMBER_TT24H'), $this->input->post('title_contact'), "Thư liên hệ tại " . $domainName, $messageContact);
                                if ($return_email) {
                                    $this->session->set_flashdata('sessionSuccessContactShopDetail', 1);
                                }
                                $this->session->set_userdata('sessionTimePosted', time());
                                redirect('/shop/contact', 'location');
                            } else {
                                $data['name_contact']    = $this->input->post('name_contact');
                                $data['email_contact']   = $this->input->post('email_contact');
                                $data['address_contact'] = $this->input->post('address_contact');
                                $data['phone_contact']   = $this->input->post('phone_contact');
                                $data['title_contact']   = $this->input->post('title_contact');
                                $data['content_contact'] = $this->input->post('content_contact');
                            }
                        }
                        #BEGIN: Create captcha

                        $aCaptcha = $this->createCaptcha(md5(microtime()) . '.' . rand(10, 10000) . 'cons.jpg');
                        if (!empty($aCaptcha)) {
                            $data['captcha']                       = $aCaptcha['captcha'];
                            $data['imageCaptchaContactShopDetail'] = $aCaptcha['imageCaptchaContact'];

                            $this->session->set_userdata('sessionCaptchaContactShopDetail', $aCaptcha['captcha']);
                            $this->session->set_userdata('sessionPathCaptchaContactShopDetail', $aCaptcha['imageCaptchaContact']);
                        }

                        #END Create captcha
                    }

                    $this->load->library('GMap');
                    $this->gmap->GoogleMapAPI();
                    // valid types are hybrid, satellite, terrain, map
                    $this->gmap->setMapType('map');
                    $this->gmap->setWidth('100%');
                    $this->gmap->setHeight('300px');
                    // you can also use addMarkerByCoords($long,$lat)
                    // both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
                    $address = $shop->sho_address . ', ' . $shop->sho_district . ', ' . $shop->sho_province;

                    $this->gmap->addMarkerByAddress($address, $shop->sho_name, '<div style="color: #1155CC; font-size:120%;font-weight: bold;">' . $shop->sho_name . '</div><div style="color: #f01929;">' . $address . '</div><div style="color: #f01929;">' . $shop->sho_descr . '</div><div style="text-align:left; font-weight:bold;color: #f01929;">Điện Thoại:' . $shop->sho_phone . ' - ' . $shop->sho_mobile . '</div>');

                    $data['headerjs']  = $this->gmap->getHeaderJS();
                    $data['headermap'] = $this->gmap->getMapJS();
                    $data['onload']    = $this->gmap->printOnLoad();
                    $data['map']       = $this->gmap->printMap();
                    $data['sidebar']   = $this->gmap->printSidebar();
                    #Load view
                    $this->load->view('shop/contact/defaults', $data);
                    break;
                #BEGIN:: Contact
                #BEGIN:: Warranty
                case 'warranty':
                    $type_share = TYPESHARE_SHOP_WARRANTY;
                    
                    $this->load->model('share_metatag_model');

                    $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop_->sho_user.' AND type = '.$type_share);
                    if(!empty($get_avtShare)){
                        $ogimage = $get_avtShare[0]->image;
                    }
                    
                    $data['sho_user'] = $shop_->sho_user;
                    $data['type_share'] = $type_share;
                    $data['ogimage'] = $ogimage;
                    #BEGIN: Menu
                    $data['menuSelected'] = 'warranty';
                    $shop_rule            = $this->shop_rule_model->get("*", "sho_id = " . (int)$shop->sho_id);
                    $shoprules            = explode(",", $shop_rule->shop_rule_ids);
                    $master_rule_where    = "";
                    if (isset($shoprules)) {
                        $master_rule_where = "id IN (";
                        foreach ($shoprules as $key => $item) {
                            if ($key == 0) {
                                $master_rule_where .= "'" . $item . "'";
                            } else {
                                $master_rule_where .= ",'" . $item . "'";
                            }
                        }
                        $master_rule_where .= ")";
                    }
                    $master_rule                = $this->master_shop_rule_model->fetch("*", $master_rule_where, "id", "ASC");
                    $data['chinhsach_baohanh']  = htmlspecialchars_decode(html_entity_decode($shop->sho_warranty));
                    $data['chinhsach_gianhang'] = $master_rule;
                    $this->load->view('shop/defaults/warranty', $data);
                    break;
                #END:: Warranty
                #BEGIN:: For AFF
                case 'afproduct':

                case 'afservices':

                case 'afcoupon':
                    #BEGIN: Add favorite
                    $data['successFavoriteProduct'] = false;
                    $data['isLogined']              = false;
                    #END Add favorite
                    #BEGIN: Menu 2
                    $data['menuSelected'] = 'product';
                    #END Menu 2
                    #Module
                    $data['module'] = 'top_lastest_ads';
                    #Define url for $getVar
                    $getVar = $this->uri->uri_to_assoc(3);
                    #BEGIN: Sort
                    $cat = $getVar['cat'] != '' ? (int)$getVar['cat'] : 0;

                    //$linktoshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link . '.' . domain_site;
                    if ($this->session->userdata('sessionGroup') == 2) {
                        $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                    } else {
                        $af = '';
                    }
                    $category = $this->category_model->get("*", "cat_id = " . $cat);
                    #Start:: SEO meta tag
                    $data['descrSiteGlobal']    = $category->cat_descr ? $category->cat_descr : $shop->sho_description;
                    $data['keywordsSiteGlobal'] = $category->keyword ? $category->keyword : $shop->sho_keywords;
                    $data['ogurl']              = $linktoshop . '/shop/product/cat/' . $category->cat_id . '/' . RemoveSign($category->cat_name) . $af;
                    $data['ogtype']             = "website";
                    $data['ogtitle']            = $category->cat_name;
                    //$data['ogimage'] = '';
                    $data['ogdescription'] = $category->cat_descr ? $category->cat_descr : $shop->sho_description;
                    #END:: SEO meta tag

                    $data['category'] = $category;

                    $type = strtolower($this->uri->segment(segmentSecond));
                    if ($type != "" && $type == "afproduct") {
                        $pro_type = 0;
                    } elseif ($type != "" && $type == "afservices") {
                        $pro_type = 1;
                    } elseif ($type != "" && $type == "afcoupon") {
                        $pro_type = 2;
                    }

                    #Get product selected sales
                    $pro_id_select   = array();
                    $select_list     = $this->product_affiliate_user_model->fetch('*', 'use_id = ' . (int)$shop->sho_user);
                    $pro_id_selected = '1';
                    if ($select_list) {
                        foreach ($select_list as $k => $v) {
                            $pro_id_select[] = $v->pro_id;
                        }
                        $pro_id_selected = implode(',', $pro_id_select);
                    }
                    $where = "is_product_affiliate = 1 AND pro_status = 1 AND pro_type = " . $pro_type . " AND (pro_user = " . $shop_Id . " OR tbtt_product.pro_id IN (" . $pro_id_selected . "))";

                    if ($cat > 0) {
                        $where .= ' AND pro_category = ' . $cat;
                    }

                    $data['query_str'] = $this->input->server('QUERY_STRING');
                    parse_str($data['query_str'], $parrams);
                    if ($parrams['q'] != '') {
                        $where .= ' AND pro_name  like ' . $this->db->escape('%' . $parrams['q'] . '%');
                    }
                    if ($parrams['price'] != '') {
                        $where .= ' AND pro_cost  >= ' . (int)$parrams['price'];
                    }
                    if ($parrams['price_to'] != '') {
                        $where .= ' AND pro_cost  <= ' . (int)$parrams['price_to'];
                    }
                    $data['parrams'] = $parrams;

                    $pageSort = '';
                    $pageUrl  = '';

                    $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : 'id';
                    $getVar['by']   = $getVar['by'] != '' ? $getVar['by'] : 'desc';
                    switch (strtolower($getVar['sort'])) {
                        case 'name':
                            $pageUrl .= '/sort/name';
                            $sort    = "pro_name";
                            break;
                        case 'cost':
                            $pageUrl .= '/sort/cost';
                            $sort    = "pro_cost";
                            break;
                        case 'buy':
                            $pageUrl .= '/sort/buy';
                            $sort    = "pro_buy";
                            break;
                        case 'view':
                            $pageUrl .= '/sort/view';
                            $sort    = "pro_view";
                            break;
                        case 'date':
                            $pageUrl .= '/sort/date';
                            $sort    = "pro_begindate";
                            break;
                        default:
                            $pageUrl .= '/sort/id';
                            $sort    = "pro_id";
                    }
                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                        $pageUrl .= '/by/desc';
                        $by      = "DESC";
                    } else {
                        $pageUrl .= '/by/asc';
                        $by      = "ASC";
                    }
                    #If have page
                    if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                        $start    = (int)$getVar['page'];
                        $pageSort .= '/page/' . $start;
                    } else {
                        $start = 0;
                    }
                    #END Sort
                    $data['default_sort'] = $getVar['sort'] . '_' . $getVar['by'];
                    #BEGIN: Create link sort
                    $data['pageSort'] = $pageSort;
                    #END Create link sort

                    if (!isset($getVar['pro_type']) || $getVar['pro_type'] == '' || $getVar['pro_type'] == 2 || empty($getVar['pro_type'])) {
                        $data['sortUrl']    = '/shop/' . $type . '/pro_type/' . $pro_type . '/sort/';
                        $getVar['pro_type'] = $pro_type;
                    } else {
                        $data['sortUrl'] = '/shop/' . $type . '/pro_type/' . $getVar['pro_type'] . '/sort/';
                    }

                    $select = "tbtt_product.pro_id, pro_name, pro_category, pro_detail, pro_category, pro_descr, pro_cost, pro_user, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_saleoff_value, pro_type_saleoff, pro_view, pro_type, sho_name, sho_begindate";
                    $limit  = settingShoppingNew_List;

                    $products        = $this->product_model->getAfProducts1($select . DISCOUNT_QUERY, $where, $sort, $by, $start, $limit);
                    $data['product'] = $products;

                    #BEGIN: Update quantity product
                    if (!$this->session->userdata('sessionQuantityProductShopDetail_' . $shop->sho_id)) {
                        $this->shop_model->update(array('sho_quantity_product' => $totalRecord), "sho_id = " . $shop->sho_id);
                        $this->session->set_userdata('sessionQuantityProductShopDetail_' . $shop->sho_id, 1);
                    }

                    $totalRow = count($this->product_model->getAfProducts1($select . DISCOUNT_QUERY, $where, $sort, $by));
                    #END Update quantity product
                    $config['base_url']    = '/shop/' . $type . '/pro_type/2/' . $pageUrl . '/page/';
                    $config['total_rows']  = $totalRow;
                    $config['per_page']    = $limit;
                    $config['num_links']   = 1;
                    $config['uri_segment'] = 5;
                    $config['cur_page']    = $start;
                    $this->pagination->initialize($config);
                    $data['linkPage'] = $this->pagination->create_links();
                    #END Pagination
                    #Load view
                    $action                = array('cat', 'sort', 'by', 'page');
                    $getVar                = $this->uri->uri_to_assoc(3, $action);
                    $data['getVar']        = $getVar;
                    $data['category_name'] = $this->category_model->get("cat_name", "cat_id = " . (int)$getVar['cat']);
                    $arr                   = explode('.', $_SERVER['HTTP_HOST']);
                    $Aff                   = $arr[0];
                    $shop                  = $this->user_model->fetch_join('use_username,use_id, parent_id, use_group, sho_link, domain', 'LEFT', 'tbtt_shop', 'sho_user = use_id', 'sho_link ="' . $Aff . '" OR domain = "' . $Aff . '"');
                    $data['UserGroup']     = $shop[0]->use_group;
                    $this->load->view('shop/product/cat_af', $data);
                    break;
                #END:: For AFF
                #BEGIN:: Home SHOP, Home BRAN, Home AFF
                default:
                    //da chuyen qua  $route['shop'] = 'home/shop/myshop_builded'; // Home page product
                    die('error is move');
            }
        } elseif (isset($param1) && ($param1 === 'news' || $param1 == '')) {
            //move shop_home
        } elseif (isset($param1) && ($param1 === 'customer')) {
            redirect($this->mainURL, 'location');
            die;
        } else {
            redirect($this->mainURL, 'location');
            die;
        }
    }

    ## Get parent_id shop/branch
    function get_id_shop_in_tree($uid = 0)
    {
        // Get parent user
        $id_my_parent = 0;
        $get_p = $this->user_model->get('parent_id', 'use_id = '. $uid .' AND use_status = 1');
        if ($get_p) {
            $id_my_parent = (int)$get_p->parent_id;
        }
        return $id_my_parent;
    }

    // get id root (GH)
    function get_shop_in_tree($uid)
    {
        $parent = 0;
        $user = $this->user_model->get("use_id, parent_id", "use_id = ". $uid); //lấy nó
        $u_pa_1 = $this->user_model->get("use_id, use_group, parent_id, parent_shop", "use_id = ". (int)$user->parent_id); // lấy cho nó
        if (!empty($u_pa_1)) {
            $parent = $u_pa_1->parent_shop > 0 ? $u_pa_1->parent_shop : $u_pa_1->parent_id;
        }

        // if($u_pa_1 && $u_pa_1->use_group == 3){
        //     $parent = $u_pa_1->use_id;
        // } elseif ($u_pa_1 && $u_pa_1->use_group == 14) {
        //     $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
        //     if($u_pa_2 && $u_pa_2->use_group == 3){
        //         $parent = $u_pa_2->use_id;
        //     } else {
        //         $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_2->parent_id);
        //         if($u_pa_3 && $u_pa_3->use_group == 3) {
        //             $parent = $u_pa_3->use_id;
        //         }
        //     }
        // } elseif ($u_pa_1 && $u_pa_1->use_group == 15) {
        //     $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
        //     if($u_pa_2 && $u_pa_2->use_group == 3){
        //         $parent = $u_pa_2->use_id;
        //     }
        // } elseif ($u_pa_1 && $u_pa_1->use_group == 11) {
        //     $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
        //     if($u_pa_2 && $u_pa_2->use_group == 3){
        //         $parent = $u_pa_2->use_id;
        //     } elseif ($u_pa_2 && $u_pa_2->use_group == 14) {
        //         $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_2->parent_id);
        //         if($u_pa_3 && $u_pa_3->use_group == 3) {
        //             $parent = $u_pa_3->use_id;
        //         } else {
        //             $u_pa_4 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_3->parent_id);
        //             if($u_pa_4 && $u_pa_4->use_group == 3) {
        //                 $parent = $u_pa_4->use_id;
        //             }
        //         }
        //     }
        // }
        return $parent;
    }

    ## Get my company or my Branch, I am CTV online
    function get_shop_nearest($userId)
    {
        #Get user
        $id_my_parent = '';
        $get_u = $this->user_model->get('use_id, use_username, use_group, parent_id, parent_shop', 'use_id = ' . $userId . ' AND use_group = 2 AND use_status = 1');
        if ($get_u) {
            #Get my parent
            $get_p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $get_u->parent_id . ' AND use_status = 1');
            if ($get_p && ($get_p->use_group == 3 || $get_p->use_group == 14)) {
                $id_my_parent = $get_p->use_id;
            } elseif ($get_p && ($get_p->use_group == 11 || $get_p->use_group == 15)) {
                #Get parent of parent
                $get_p_p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $get_p->parent_id . ' AND use_status = 1');
                if ($get_p_p && ($get_p_p->use_group == 3 || $get_p_p->use_group == 14)) {
                    $id_my_parent = $get_p_p->use_id;
                }
            } else {
                $id_my_parent = $get_u->parent_shop;
            }
        }
        return $id_my_parent;
    }

    ##Get my company, I am Branch or Staff or StaffStore
    function get_my_shop($userId)
    {
        $p_userddd = $this->user_model->get('use_id, use_group, parent_id, use_status', 'use_status = 1 AND use_id = ' . $userId);
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
        return $userID;
    }

    function load_product_style()
    {
        $id = (int)$this->input->post('id');
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $material = $this->input->post('material');
        $result = array();
        $result['error'] = FALSE;
        if (isset($id) && $id > 0) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, $size, $material);

            $result['pro_dir'] = $product->pro_dir;
            $result['pro_id'] = $product->id;
            $result['pro_images'] = $product->dp_images;
            $result['pro_prices'] = $product->dp_cost;
            $result['off_amount'] = $product->off_amount;
            $result['af_off'] = $product->af_off;
            $result['message'] = 'Susseccc!!';

        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function ajax()
    {
        $this->load->library('hash');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Get shop by $linkShop
        $shop = $this->shop_model->get("sho_user", "sho_link = '" . $this->filter->injection($this->input->post('link')) . "' AND sho_status = 1 AND sho_enddate >= $currentDate");
        #END Get shop by $linkShop
        if ($this->input->post('token') && $this->input->user_agent() != FALSE && $this->input->post('token') == $this->hash->create($this->input->post('link'), $this->input->user_agent(), 'sha256md5') && $this->input->post('type') && count($shop) == 1 && strlen(trim($this->input->post('link'))) >= 5 && strlen(trim($this->input->post('link'))) <= 50) {
            $idUser = (int)$shop->sho_user;
            $where = "pro_image != 'none.gif' AND pro_user = $idUser AND pro_status = 1";
            //AND pro_cost > 0
            $sort = "rand()";
            $by = "DESC";
            $limit = (int)settingShoppingInterest_Home;
            switch ((int)$this->input->post('type')) {
                case 1:
                    $sort = "pro_view";
                    break;
                case 2:
                    $sort = "pro_id";
                    $limit = (int)settingShoppingNew_Home;
                    break;
                case 3:
                    $where .= " AND pro_saleoff = 1";
                    $limit = (int)settingShoppingSaleoff_Home;
                    break;
            }
            $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff,pro_saleoff_value,pro_type_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote";
            $start = 0;
            $product = $this->product_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
            $product_img_dir = 'media/images/product/';
            if (count($product) > 0) {
                for ($i = 0; $i < $limit; $i++) {
                    $product[$i]->pro_name_url = RemoveSign($product[$i]->pro_name);
                    $product_img_dir_item = $product_img_dir . $product[$i]->pro_dir;
                    $pro_images = explode(",", $product[$i]->pro_image);
                    if (!file_exists($product_img_dir_item . '/' . $pro_images[0])) {
                        $product[$i]->pro_image = 'no_image.png';
                    }
                    if ($product[$i]->pro_saleoff == 1) {
                        if ($product[$i]->pro_saleoff_value > 0) {
                            if ($product[$i]->pro_type_saleoff == 1) {
                                $product[$i]->pro_cost = $product[$i]->pro_cost - round(($product[$i]->pro_cost * $product[$i]->pro_saleoff_value) / 100);
                            } else {
                                $product[$i]->pro_cost = $product[$i]->pro_cost - $product[$i]->pro_saleoff_value;
                            }
                        }
                    }
                    $product[$i]->sho_danhgia = "";
                    for ($vote = 0; $vote < (int)$product[$i]->pro_vote_total; $vote++) {
                        $product[$i]->sho_danhgia .= '<img src="' . $this->mainURL . 'templates/home/images/star1.gif" border="0" alt="" />';
                    }
                    for ($vote = 0; $vote < 10 - (int)$product[$i]->pro_vote_total; $vote++) {
                        $product[$i]->sho_danhgia .= '<img src="' . $this->mainURL . 'templates/home/images/star0.gif" border="0" alt="" />';
                    }
                    $product[$i]->sho_danhgia .= '<b>[' . $product[$i]->pro_vote . ']</b>';
                    $product[$i]->sho_begindate = date('d/m/Y', $product[$i]->sho_begindate);
                }
                echo "[" . json_encode($product) . "," . count($product) . "]";
            }

        } else {
            show_404();
            die();
        }
    }

    function _valid_captcha_contact($str)
    {
        if ($this->session->flashdata('sessionCaptchaContactShopDetail') && $this->session->flashdata('sessionCaptchaContactShopDetail') === $str) {
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
            $link = '<a href="' . $this->mainURL . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $images = '<img class="img-responsive" src="' . $this->mainURL . 'templates/home/images/category/' . $row->cat_image . '"/><br/>';
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
            $link = '<a href="' . $this->mainURL . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
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

    function removeSignText($cs, $tolower = false)
    {
        $marTViet = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
            "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề",
            "ế", "ệ", "ể", "ễ",
            "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ",
            "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă",
            "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", " ");

        $marKoDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
            "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
            "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
            "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", " ");

        if ($tolower) {
            return strtolower(str_replace($marTViet, $marKoDau, $cs));
        }
        return str_replace(",", "", str_replace($marTViet, $marKoDau, $cs));
    }

    public function add_view_af_share($productID)
    {
        //add info view af share
        if (isset($_REQUEST['share'])) {
            $user_key = $_REQUEST['share'];
            //kiem tra user key co ton tai khong
            $this->load->model('user_model');
            $af_user = $this->user_model->get_user_key($user_key);
            if ($af_user != false) {
                $this->load->library('user_agent');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_robot()) {
                    $agent = $this->agent->robot();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                } else {
                    $agent = 'Unidentified User Agent';
                }
                $this->load->model('af_share_model');
                $data_view['pro_id'] = $productID;
                $data_view['af_key'] = $_REQUEST['share'];
                $data_view['agent_view'] = $agent;
                $data_view['time_view'] = date('Y-m-d H:i:s');
                $kq = $this->af_share_model->add($data_view);
            }

        }
    }

    public function domain()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'shop_index';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise

        $this->load->view('shop/defaults/domain', $data);
    }

    public function danhsachchon($not_id)
    {
        $linkShop = $this->getShopLink();
        $shop = $this->shop_model->get("*", "sho_link = '" . $this->filter->injection($linkShop) . "' AND sho_status = 1");
        $shop->sho_district = $shop->sho_district ? $this->district_model->get("DistrictName", "DistrictCode = '" . $shop->sho_district . "'")->DistrictName : "";
        $shop->sho_province = $shop->sho_province ? $this->province_model->get("pre_name", "pre_id = " . (int)$shop->sho_province)->pre_name : "";
        $data['siteGlobal'] = $shop;



        $query = 'SELECT a.`sho_name`, a.`sho_user`, a.`sho_link`, a.`sho_logo`, a.`sho_dir_logo`, a.`domain` '
            . 'FROM tbtt_shop AS a '
            . 'LEFT JOIN tbtt_chontin AS b ON a.`sho_user` = b.`sho_user_1` '
            . 'WHERE b.`not_id` = ' . $not_id;

        $data['listselect'] = $this->db->query($query)->result();



        //Danh sach tin chon ve
        $data['ds_tin_chon'] = $this->content_model->fetch_join_2(
            "a.not_id, a.not_title, a.not_image, a.not_dir_image, s.sho_link, s.domain",
            "LEFT", "tbtt_chontin AS c", "c.not_id = a.not_id",
            "LEFT", "tbtt_shop AS s", "s.sho_user = a.not_user",
            "a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND c.sho_user_1 = " . $shop->sho_user,
            "a.not_id",
            "DESC",
            -1, 0, true
        );
        //Danh sach tin duoc chon
        $data['ds_duoc_chon'] = $this->content_model->fetch_join_2(
            "a.not_id, a.not_title, a.not_image, a.not_dir_image, s.sho_link, s.domain",
            "LEFT", "tbtt_chontin AS c", "c.not_id = a.not_id",
            "LEFT", "tbtt_shop AS s", "s.sho_user = a.not_user",
            "a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND c.sho_user_2 = " . $shop->sho_user,
            "a.not_id",
            "DESC",
            -1, 0, true
        );

        $this->load->view('shop/news/danhsachchon', $data);
    }

    public function getConditionsShareNews($sessionGroup, $sessionUser)
    {
        $sho_package = '';
        switch ($sessionGroup) {
            case 3:
                $sho_package = $this->package_user_model->getCurrentPackage($sessionUser);
                break;
            case 14:
                $userCurent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $sessionUser);
                $userParent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userCurent->parent_id);
                if ($userParent->use_group == 3) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);
                } else { //=15
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
                }
                break;
            case 2:
                $userCurent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $sessionUser);
                $userParent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userCurent->parent_id);
                if ($userParent->use_group == 3) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);
                }
                if ($userParent->use_group == 15) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
                }
                if ($userParent->use_group == 14) {
                    $userParent2 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent->parent_id);
                    if ($userParent2->use_group == 3) {
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);
                    } else { //=15
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->parent_id);
                    }
                }
                if ($userParent->use_group == 11) {
                    $userParent2 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent->parent_id);
                    if ($userParent2->use_group == 3) {
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);
                    } else { //=14
                        $userParent3 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent2->parent_id);
                        if ($userParent3->use_group == 3) {
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent3->use_id);
                        } else {//=15
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent3->parent_id);
                        }
                    }
                }
                break;
        }

        return $sho_package;
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

    public function getAliasDomain()
    {
        $result = "";
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $result = $protocol . $_SERVER['HTTP_X_FORWARDED_HOST'] . '/';
        }

        return $result;
    }

    public function get_youtube_id_from_url($url)
    {
        if (stristr($url, 'youtu.be/')) {
            @preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
            return $final_ID[4];
        } else {
            @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
            return $IDD[5];
        }
    }

    function comment()
    {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('noc_name', 'lang:tên', 'trim|required');
        $this->form_validation->set_rules('noc_comment', 'lang:nội dung', 'trim|required');
        $this->form_validation->set_rules('noc_content', 'lang:bài viết', 'trim|required');
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            $comment = array();
            $comment['noc_comment'] = $this->input->post('noc_comment');
            $comment['noc_content'] = $this->input->post('noc_content');
            $comment['noc_reply'] = $this->input->post('noc_reply');
            $comment['noc_date'] = date('Y-m-d H:i:s');
            $userID = (int)$this->input->post('noc_user');
            $user = $this->user_model->get("use_id, use_fullname, use_email, use_phone, avatar", "use_id = " . $userID);
            $comment['noc_name'] = $user->use_fullname;
            $comment['noc_email'] = $user->use_email;
            $comment['noc_user'] = $user->use_id;
            $comment['noc_phone'] = $user->use_phone;
            $comment['noc_avatar'] = $user->avatar;

            $this->comment_model->add($comment);
            $result = array('error' => false, 'comment' => $comment);
        } else {
            $validator = &_get_validation_object();
            $error_messages = $validator->_error_array;
            $result = array('error' => true, 'error' => $error_messages);
        }
        echo json_encode($result);
        exit();
    }

    function affiliate_shop()
    {

        $linkShop = $this->getShopLink();
        $shop = $this->shop_model->get('sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province', 'sho_link = "'. $this->filter->injection($linkShop) .'" AND sho_status = 1');

        $get_shop = $this->product_affiliate_user_model->fetch('pro_id', 'use_id = '. (int)$shop->sho_user);

        $user = $this->user_model->get('use_id, avatar, use_cover, use_mobile, use_phone, use_email, af_key', 'use_status = 1 AND (use_group = 3 OR use_group = 14) AND use_id = '. (int)$shop->sho_user);

        // Kiểm tra sự tồn tại của shop và user đã active hay chưa
        if (empty($shop) || count($shop) != 1 || empty($user) || count($user) != 1 || $user->use_id <= 0) {
            redirect(base_url(), 'location'); die();
        }

        if (count($get_shop) > 0) {
            $listshop = array();
            foreach ($get_shop as $items){
                $listshop[] = $items->pro_id;
            }
            $liststore = implode(',', $listshop);
        }

        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page','key','cat', 'detail');
        $getVar = $this->uri->uri_to_assoc(3, $action);

        $data = array();
        $shop->avatar = $user->avatar;
        $shop->user_af_key = $user->af_key;
        $data['shop'] = $shop;
        //Phan action
        if($liststore != ''){
            //Get category at header
            $cat = array();
            $getcat = $this->product_model->fetch_join1('pro_category', 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN ('. $liststore .')');
            foreach ($getcat as $item) {
                $cat[] = $item->pro_category;
            }
            $strcat = implode(',',$cat);
            if ($strcat != '') {
                $category = $this->category_model->fetch('cat_id, cat_name, cate_type', 'cat_id IN('. $strcat .')');
                $data['category_list'] = $category;
            }
        }
        //End get category
        //FOOTER
        $province_district = $this->district_model->get('DistrictName, ProvinceName', array('DistrictCode' => $shop->sho_district, 'ProvinceCode' => $shop->sho_province));
        $data['sho_address'] = $shop->sho_address .', '. $province_district->DistrictName.', '.$province_district->ProvinceName;

        $linkweb = $shop->sho_link . domain_site;
        if($shop->domain != ''){
            $linkweb = $shop->domain;
        }
        $data['linkweb'] = $linkweb;

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $data['protocol'] = $protocol;
        $data['domainName'] = $domainName;
        //END FOOTER

        $linktab = '';
        switch ($getVar) {
            case $getVar['detail'] != '':
                $this->affiliate_detail();
                break;

            case $getVar['cat'] != '':

            default:
                if($liststore != ''){

                    $segment = $this->uri->segment(2);

                    switch ($segment) {
                        case 'product':

                        case 'coupon':
                            $actionForm = '';
                            $urlpage = '';
                            $pageSort = '';
                            $pageUrl = '';
                            $sort = '';
                            $by = '';
                            #If have page
                            if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                                $start = (int)$getVar['page'];
                                $pageSort .= '/page/' . $start;
                            } else {
                                $start = 0;
                            }
                            #SORT
                            if($getVar['sort'] != ''){
                                $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : '';
                                $getVar['by'] = $getVar['by'] != '' ? $getVar['by'] : '';
                                switch (strtolower($getVar['sort'])) {
                                    case 'price':
                                        $pageUrl .= '/sort/price';
                                        $sort = "pro_cost";
                                        break;
                                    default:
                                        $pageUrl .= '/sort/id';
                                        $sort = "pro_id";
                                }

                                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                                    $pageUrl .= '/by/desc';
                                    $by = "DESC";
                                } else {
                                    $pageUrl .= '/by/asc';
                                    $by = "ASC";
                                }
                            }
                            #END Sort
                            // ENd
                            $limit = settingOtherAccount;
                            $type = 0;
                            $txttype = 'product';
                            if($segment == 'coupon'){
                                $type = 2;
                                $txttype = 'coupon';
                            }
                            $data['segment'] = $segment;
                            $data['linktab'] = $linktab;
                            $where = 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN ('. $liststore .') AND pro_type = '. (int)$type;
                            if ($getVar['cat'] != '') {
                                $category = $this->category_model->get("cat_name", "cat_id = " . (int)explode('-',$getVar['cat'])[0] . ' AND cat_status = 1');
                                $data['category'] = $category;
                                $where .= ' AND pro_category = ' . explode('-',$getVar['cat'])[0];
                                $linktab = 'cat/' . $getVar['cat'];
                                $pageUrl = $segment .'/'. $linktab . $pageUrl;
                                $urlpage = $segment .'/'. $linktab . $pageSort;
                                $actionForm = $segment .'/'. $linktab;
                            } else {
                                $pageUrl = $segment . $pageUrl;
                                $urlpage = $segment . $pageSort;
                                $actionForm = $segment;
                            }
                            $data['catid_header'] = explode('-',$getVar['cat'])[0];
                            $data['actionForm'] = $actionForm;
                            $data['linktab'] = $linktab;
                            $search = '';
                            $this->load->library('form_validation');
                            if ($this->input->post('search')) {
                                $data['name'] = $name = $this->input->post('name');
                                $data['price_form'] = $price_form = $this->input->post('price_form');
                                $data['price_to'] = $price_to = $this->input->post('price_to');
                                $data['saleoff'] = $saleoff = $this->input->post('saleoff');
                                $data['baohanh'] = $baohanh = $this->input->post('baohanh');
                                if($getVar['cat'] != ''){
                                    $pagecur = 'cat/'.$getVar['cat'];
                                }
                                $data['pagecur'] = $segment . '/' . $pagecur;
                                if($name != ''){
                                    $where .= ' AND pro_name like "%'. $name .'%"';
                                    $search .= '<span>'. $name .'</span>';
                                }
                                if ($price_form != '' && $price_to != '') {
                                    $where .= ' AND (pro_cost >= '.$price_form.' AND pro_cost <= '.$price_to.')';
                                    $search .= '<span>Giá: từ '.$price_form.' đến '.$price_to.'</span>';
                                } else {
                                    if($price_form != ''){
                                        $where .= ' AND pro_cost >= '.$price_form;
                                        $search .= '<span>Giá: '.$price_form.'</span>';
                                    }
                                    if($price_to != ''){
                                        $where .= ' AND pro_cost <= '.$price_to;
                                        $search .= '<span>Giá: '.$price_to.'</span>';
                                    }
                                }

                                if ($saleoff != '') {
                                    if ($saleoff == 1) {
                                        $search .= '<span>Khuyến mãi</span>';
                                        $where .= " AND pro_saleoff = 1 AND ((".strtotime(date('Y/m/d', time())).">= tbtt_product.begin_date_sale AND ".strtotime(date('Y/m/d', time()))." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))";
                                    } else {
                                        $where .= " AND ( pro_saleoff = 0)";
                                        $search .= '<span>Không khuyến mãi</span>';
                                    }
                                }

                                if ($baohanh != '') {
                                    $search .= '<span>Thời gian bảo hành: ';
                                    if($baohanh == 0){
                                        $where .= ' AND pro_warranty_period = 0';
                                        $search .= 'Không bảo hành';
                                    }
                                    if($baohanh == 1){
                                        $where .= ' AND (pro_warranty_period BETWEEN 1 AND 3)';
                                        $search .= 'từ 1 đến 3 tháng';
                                    }
                                    if($baohanh == 2){
                                        $where .= ' AND (pro_warranty_period BETWEEN 4 AND 6)';
                                        $search .= 'từ 4 đến 6 tháng';
                                    }
                                    if($baohanh == 3){
                                        $where .= ' AND (pro_warranty_period BETWEEN 7 AND 9)';
                                        $search .= 'từ 7 đến 9 tháng';
                                    }
                                    if($baohanh == 4){
                                        $where .= ' AND (pro_warranty_period BETWEEN 10 AND 12)';
                                        $search .= 'từ 10 đến 12 tháng';
                                    }
                                    $search .= '</span>';
                                }
                            }
                            $data['search'] = $search;
                            //SORT
                            $data['urlSort'] = $urlpage;
                            //END SORT
                            $select = 'pro_id, pro_name, pro_dir, pro_image, pro_cost, af_amt, af_rate, sho_name, sho_link, domain'
                                .", IF( tbtt_product.pro_saleoff = 1"
                                . " AND ((".strtotime(date('Y/m/d', time())).">= tbtt_product.begin_date_sale AND ".strtotime(date('Y/m/d', time()))." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))"
                                . ", CASE WHEN tbtt_product.pro_type_saleoff = 2 THEN tbtt_product.pro_saleoff_value WHEN tbtt_product.pro_type_saleoff = 1 THEN CAST( tbtt_product.pro_saleoff_value AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100 END, 0 ) AS off_amount"
                                . ", IF( tbtt_product.af_dc_amt > 0, CAST( tbtt_product.af_dc_amt AS DECIMAL (15, 5) ), IF( tbtt_product.af_dc_rate > 0, CAST( tbtt_product.af_dc_rate AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100, 0 ) ) AS af_off";
                            $data['products'] = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where, $sort, $by, $start, $limit);
                            if($this->input->post('search')){
                                $countsearch = count($data['products']);
                                $data['countsr'] = 'Có ' . $countsearch . ' kết quả được tim thấy';
                            }
                            //#BEGIN: Pagination
                            $this->load->library('pagination');
                            $totalRecord = count($this->product_model->fetch_join1($select,'INNER','tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user',$where));
                            $config['base_url'] = base_url() . 'affiliate/' . $pageUrl . '/page/';
                            $config['total_rows'] = $totalRecord;
                            $config['per_page'] = $limit;
                            $config['num_links'] = 5;
                            $config['uri_segment'] = 3;
                            $config['cur_page'] = $start;
                            $this->pagination->initialize($config);
                            $data['linkPage'] = $this->pagination->create_links();
                            #Load view
                            $this->load->view('shop/affiliate/default', $data);
                            break;

                        case 'checkout':
                            $cart = $this->session->userdata('cart');
                            $cart_coupon = $this->session->userdata('cart_coupon');
                            // echo "<pre>"; print_r($cart); echo "</pre>"; die;
                            $group_id = $this->session->userdata('sessionGroup');
                            if ($group_id == Developer2User
                                || $group_id == Developer1User
                                || $group_id == Partner2User
                                || $group_id == Partner1User
                                || $group_id == CoreMemberUser
                                || $group_id == CoreAdminUser
                            ) {
                                $data['noAccesss'] = 1;
                            } else {
                                $data['noAccesss'] = 0;
                            }

                            // Remove shop order product if exists
                            if ($this->session->userdata('sessionUser') > 0) {
                                $updateCart = false;
                                // Check if login user is saler shop
                                $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                                $wholesale = $shopInfo->shop_type > 0 ? true : false;
                                foreach ($cart as &$cItems) {
                                    if (!empty($cItems)) {
                                        foreach ($cItems as $k => $cp) {
                                            if ($cp['pro_user'] == $this->session->userdata('sessionUser')) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            }
                                            //
                                            if ($wholesale && $cp['store_type'] == 0) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            } elseif ($wholesale && $cp['qty'] < $cp['qty_min']) {
                                                $cp['qty'] = $cp['qty_min'];
                                                $updateCart = true;
                                            }
                                        }
                                    }
                                }

                                foreach ($cart_coupon as &$cItems) {
                                    if (!empty($cItems)) {
                                        foreach ($cItems as $k => $cp) {
                                            if ($cp['pro_user'] == $this->session->userdata('sessionUser')) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            }
                                            //
                                            if ($wholesale && $cp['store_type'] == 0) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            } elseif ($wholesale && $cp['qty'] < $cp['qty_min']) {
                                                $cp['qty'] = $cp['qty_min'];
                                                $updateCart = true;
                                            }
                                        }
                                    }
                                }

                                if ($updateCart == true) {
                                    $this->session->set_userdata('cart', $cart);
                                    $this->session->set_userdata('cart', $cart_coupon);
                                }
                            }

                            $listProduct = array();
                            foreach ($cart as $cartItem) {
                                if (! empty($cartItem)) {
                                    foreach ($cartItem as $pItem) {
                                        array_push($listProduct, $pItem['pro_id']);
                                    }
                                }
                            }

                            if (! empty($listProduct)) {
                                $where = 'pro_id IN ('. implode(',', $listProduct) .') AND pro_status = 1';
                                $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                                $products = $this->product_model->fetch($select, $where, 'pro_id', 'ASC');
                                $this->load->model('product_promotion_model');
                                $productList = array();
                                // $couponList = array();
                                // $serviceList = array();
                                $jsCart = array();
                                foreach ($products as $pro) {
                                    foreach ($cart as $key => $cartItems) {
                                        if (! isset($jsCart[$key])) {
                                            $jsCart[$key] = array('shop' => $key, 'products' => array());
                                        }
                                        if (! empty($cartItems)) {
                                            foreach ($cartItems as $cItem) {
                                                if ($cItem['pro_id'] == $pro->pro_id) {
                                                    $pItem = clone $pro;
                                                    $afSelect = false;
                                                    if ($cItem['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                                                        $afSelect = true;
                                                    }

                                                    $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                                                    ## Get price for variant product, by BaoTran
                                                    if ($cItem['dp_id'] > 0) {
                                                        $dp_where = 'pro_id = '. $pro->pro_id .' AND pro_status = 1';
                                                        $dp_select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) AS pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                                                        $dp_product = $this->product_model->getProAndDetailForCheckout($dp_select, $dp_where, (int)$cItem['dp_id']);
                                                        $discount = lkvUtil::buildPrice($dp_product, $this->session->userdata('sessionGroup'), $afSelect);
                                                    }

                                                    // Make discount for member
                                                    $pItem->em_discount = 0;
                                                    if ($pro->pro_user != (int)$this->session->userdata('sessionUser')) {
                                                        $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cItem['qty'], 'total' => ($discount['salePrice'] * $cItem['qty'])));
                                                        if (! empty($promotion)) {
                                                            if ($promotion['dc_rate'] > 0) {
                                                                $pItem->em_discount = $discount['salePrice'] * $cItem['qty'] * $promotion['dc_rate'] / 100;
                                                            } else {
                                                                $pItem->em_discount = $promotion['dc_amt'];
                                                            }
                                                        }
                                                    }

                                                    $pItem->pro_cost = $discount['salePrice'];
                                                    $pItem->key = $cItem['key'];
                                                    $pItem->qty = $cItem['qty'];
                                                    $pItem->pro_type = $cItem['pro_type'];
                                                    $pItem->shipping_fee = 0;
                                                    $pItem->sho_link = $cItem['sho_link'];
                                                    $pItem->qty_min = $cItem['qty_min'];
                                                    $pItem->qty_max = $cItem['qty_max'];
                                                    $pItem->store_type = $cItem['store_type'];
                                                    $pItem->dp_id = $cItem['dp_id'] > 0 ? $cItem['dp_id'] : 0;
                                                    $pItem->dp_image = $cItem['dp_id'] > 0 ? $dp_product->dp_images : '';
                                                    $pItem->dp_color = $cItem['dp_id'] > 0 ? $dp_product->dp_color : '';
                                                    $pItem->dp_size = $cItem['dp_id'] > 0 ? $dp_product->dp_size : '';
                                                    $pItem->dp_material = $cItem['dp_id'] > 0 ? $dp_product->dp_material : '';
                                                    $pItem->dp_instock = $cItem['dp_id'] > 0 ? $dp_product->dp_instock : 0;
                                                    $pItem->gr_id = $cItem['gr_id'];
                                                    $pItem->gr_user = $cItem['gr_user'];

                                                    if ($pItem->pro_type == 0) {
                                                        if (!isset($productList[$key])) {
                                                            $productList[$key] = array();
                                                        }
                                                        array_push($productList[$key], $pItem);
                                                    }
                                                    // if ($pItem->pro_type == 2) {
                                                    //     if (!isset($couponList[$key])) {
                                                    //         $couponList[$key] = array();
                                                    //     }
                                                    //     array_push($couponList[$key], $pItem);
                                                    // }
                                                    // if ($pItem->pro_type == 1) {
                                                    //     if (!isset($serviceList[$key])) {
                                                    //         $serviceList[$key] = array();
                                                    //     }
                                                    //     array_push($serviceList[$key], $pItem);
                                                    // }
                                                    $productItem = array('pro_id' => $pItem->pro_id, 'key' => $pItem->key, 'qty' => $pItem->qty, 'pro_cost' => $pItem->pro_cost, 'em_discount' => $pItem->em_discount, 'shipping_fee' => $cp['shipping_fee'], 'dp_id' => $cp['dp_id']);
                                                    array_push($jsCart[$key]['products'], $productItem);
                                                }
                                            }
                                        }
                                    }
                                }
                                $this->session->set_userdata('cart', $cart);
                            }

                            $listProduct = array();
                            $couponList = array();
                            $jsCouponCart = array();
                            foreach ($cart_coupon as $cartItem) {
                                if (!empty($cartItem)) {
                                    foreach ($cartItem as $pItem) {
                                        array_push($listProduct, $pItem['pro_id']);
                                    }
                                }
                            }

                            if (!empty($listProduct)) {
                                $where = 'pro_id IN ('. implode(',', $listProduct) .') AND pro_status = 1';
                                $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                                $products = $this->product_model->fetch($select, $where, 'pro_id', 'ASC');
                                $this->load->model('product_promotion_model');

                                foreach ($products as $pro) {
                                    foreach ($cart_coupon as $key => $cartItems) {
                                        if (!isset($jsCouponCart[$key])) {
                                            $jsCouponCart[$key] = array('shop' => $key, 'products' => array());
                                        }
                                        if (!empty($cartItems)) {
                                            foreach ($cartItems as $cItem) {
                                                if ($cItem['pro_id'] == $pro->pro_id) {
                                                    $pItem = clone $pro;
                                                    $afSelect = false;
                                                    if ($cItem['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                                                        $afSelect = true;
                                                    }

                                                    $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                                                    ## Get price for Trường Quy Cách SP, by Bao Tran
                                                    if ($cItem['dp_id'] > 0) {
                                                        $dp_where = 'pro_id = '. $pro->pro_id .' AND pro_status = 1';
                                                        $dp_select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) AS pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                                                        $dp_product = $this->product_model->getProAndDetailForCheckout($dp_select, $dp_where, (int)$cItem['dp_id']);
                                                        $discount = lkvUtil::buildPrice($dp_product, $this->session->userdata('sessionGroup'), $afSelect);
                                                    }

                                                    // Make discount for member
                                                    $pItem->em_discount = 0;
                                                    if ($pro->pro_user != (int)$this->session->userdata('sessionUser')) {
                                                        $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cItem['qty'], 'total' => ($discount['salePrice'] * $cItem['qty'])));
                                                        if (!empty($promotion)) {
                                                            if ($promotion['dc_rate'] > 0) {
                                                                $pItem->em_discount = $discount['salePrice'] * $cItem['qty'] * $promotion['dc_rate'] / 100;
                                                            } else {
                                                                $pItem->em_discount = $promotion['dc_amt'];
                                                            }
                                                        }
                                                    }

                                                    $pItem->pro_cost = $discount['salePrice'];
                                                    $pItem->key = $cItem['key'];
                                                    $pItem->qty = $cItem['qty'];
                                                    $pItem->pro_type = $cItem['pro_type'];
                                                    $pItem->shipping_fee = 0;
                                                    $pItem->sho_link = $cItem['sho_link'];
                                                    $pItem->qty_min = $cItem['qty_min'];
                                                    $pItem->qty_max = $cItem['qty_max'];
                                                    $pItem->store_type = $cItem['store_type'];
                                                    $pItem->dp_id = $cItem['dp_id'] > 0 ? $cItem['dp_id'] : 0;
                                                    $pItem->dp_image = $cItem['dp_id'] > 0 ? $dp_product->dp_images : '';
                                                    $pItem->dp_color = $cItem['dp_id'] > 0 ? $dp_product->dp_color : '';
                                                    $pItem->dp_size = $cItem['dp_id'] > 0 ? $dp_product->dp_size : '';
                                                    $pItem->dp_material = $cItem['dp_id'] > 0 ? $dp_product->dp_material : '';
                                                    $pItem->dp_instock = $cItem['dp_id'] > 0 ? $dp_product->dp_instock : 0;
                                                    $pItem->gr_id = $cItem['gr_id'];
                                                    $pItem->gr_user = $cItem['gr_user'];

                                                    if ($pItem->pro_type == 2) {
                                                        if (!isset($couponList[$key])) {
                                                            $couponList[$key] = array();
                                                        }
                                                        array_push($couponList[$key], $pItem);
                                                    }

                                                    $productItem = array('pro_id' => $pItem->pro_id, 'key' => $pItem->key, 'qty' => $pItem->qty, 'pro_cost' => $pItem->pro_cost, 'em_discount' => $pItem->em_discount, 'shipping_fee' => $cp['shipping_fee'], 'dp_id' => $cp['dp_id']);
                                                    array_push($jsCouponCart[$key]['products'], $productItem);
                                                }
                                            }
                                        }
                                    }
                                }
                                $this->session->set_userdata('cart_coupon', $cart_coupon);
                            }

                            $data['cart'] = $productList;
                            $data['coupon'] = $couponList;
                            $data['service'] = $serviceList;
                            $data['jsCart'] = $jsCart;
                            $data['jsCouponCart'] = $jsCouponCart;
                            $data['shops'] = array();
                            if (array_keys($cart)) {
                                $shopFilter = array(
                                    'select' => 'sho_name, sho_link, sho_id, sho_user, domain',
                                    'where_in' => array(
                                        'sho_user' => array_keys($cart)
                                    )
                                );
                                $shops = $this->shop_model->getShop($shopFilter);
                                foreach ($shops as $shop) {
                                    if (!isset($data['shops'][$shop['sho_user']])) {
                                        $data['shops'][$shop['sho_user']] = array();
                                    }
                                    $data['shops'][$shop['sho_user']] = $shop;
                                }
                            }

                            if (array_keys($cart_coupon)) {
                                $shopFilter = array(
                                    'select' => 'sho_name, sho_link, sho_id, sho_user, domain',
                                    'where_in' => array(
                                        'sho_user' => array_keys($cart_coupon)
                                    )
                                );
                                $shops = $this->shop_model->getShop($shopFilter);
                                foreach ($shops as $shop) {
                                    if (!isset($data['shops'][$shop['sho_user']])) {
                                        $data['shops'][$shop['sho_user']] = array();
                                    }
                                    $data['shops'][$shop['sho_user']] = $shop;
                                }
                            }
                            #Load view
                            $this->load->view('shop/affiliate/checkout', $data);
                            break;

                        case 'orderv0':
                            $shop_id = (int)$this->uri->segment(3);
                            $cart = $this->session->userdata('cart');
                            if (empty($cart)) {
                                redirect(base_url() .'affiliate/checkout', 'location'); die();
                            }
                            // echo '<pre>'; print_r($cart); echo '</pre>'; die;
                            $updateCart = false;
                            $jsCart = array();
                            $productList = array();

                            if ($this->session->userdata('sessionUser') > 0) {
                                // Check if login user is saler shop
                                $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                                $wholesale = $shopInfo->shop_type > 0 ? true : false;
                                foreach ($cart as &$cItems) {
                                    if (!empty($cItems)) {
                                        foreach ($cItems as $k => $cp) {
                                            if ($cp['pro_user'] == $this->session->userdata('sessionUser')) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            }
                                            //
                                            if ($wholesale && $cp['store_type'] == 0) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            } elseif ($wholesale && $cp['qty'] < $cp['qty_min']) {
                                                $cp['qty'] = $cp['qty_min'];
                                                $updateCart = true;
                                            }
                                        }
                                    }
                                }
                            }
                            $this->load->model('product_promotion_model');
                            foreach ($cart as $key => $cItems) {
                                if ($shop_id == $key && !empty($cItems)) {
                                    $jsCart[$key] = array('shop' => $key, 'products' => array());
                                    foreach ($cItems as $k => $cp) {
                                        // Build product price
                                        $select = 'pro_user, pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_type, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                                        $pro = $this->product_model->get($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0');
                                        ## Get price for variant product, by BaoTran
                                        if ($cp['dp_id'] > 0) {
                                            $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) as pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                                            $pro = $this->product_model->getProAndDetailForCheckout($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0', (int)$cp['dp_id']);
                                        }

                                        if (empty($pro)) {
                                            unset($cItems[$k]);
                                            $updateCart = true;
                                            continue;
                                        }

                                        $afSelect = false;
                                        $cItems[$k]['af_user'] = $cp['af_id'];
                                        if ($cp['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                                            $afSelect = true;
                                        }

                                        $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                                        // Make discount for member
                                        $pro->em_discount = 0;
                                        if ($pro->pro_user != (int)$this->session->userdata('sessionUser')) {
                                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cp['qty'], 'total' => ($discount['salePrice'] * $cp['qty'])));
                                            if (! empty($promotion)) {
                                                if ($promotion['dc_rate'] > 0) {
                                                    $pro->em_discount = $discount['salePrice'] * $cp['qty'] * $promotion['dc_rate'] / 100;
                                                } else {
                                                    $pro->em_discount = $promotion['dc_amt'];
                                                }
                                            }
                                        }

                                        $pro->pro_cost = $discount['salePrice'];
                                        $pro->key = $cp['key'];
                                        $pro->qty = $cp['qty'];
                                        $pro->shipping_fee = 0;
                                        $pro->pro_type = $cp['pro_type'];
                                        $pro->sho_link = $cp['sho_link'];
                                        $pro->qty_min = $cp['qty_min'] > 0 ? $cp['qty_min'] : 1;
                                        $pro->qty_max = $cp['qty_max'];
                                        $pro->store_type = $cp['store_type'];
                                        $pro->dp_id = $cp['dp_id'] > 0 ? $cp['dp_id'] : 0;
                                        $pro->dp_image = $cp['dp_id'] > 0 ? $pro->dp_images : '';
                                        $pro->dp_color = $cp['dp_id'] > 0 ? $pro->dp_color : '';
                                        $pro->dp_size = $cp['dp_id'] > 0 ? $pro->dp_size : '';
                                        $pro->dp_material = $cp['dp_id'] > 0 ? $pro->dp_material : '';
                                        $pro->dp_instock = $cp['dp_id'] > 0 ? $pro->dp_instock : 0;
                                        $pro->gr_id = $cp['gr_id'];
                                        $pro->gr_user = $cp['gr_user'];

                                        array_push($productList, $pro);
                                        $productItem = array('pro_id' => $pro->pro_id, 'key' => $pro->key, 'qty' => $pro->qty, 'pro_cost' => $pro->pro_cost, 'em_discount' => $pro->em_discount, 'dp_id' => $pro->dp_id);
                                        array_push($jsCart[$key]['products'], $productItem);
                                    }
                                }
                            }

                            if ($updateCart == true) {
                                $this->session->set_userdata('cart', $cart);
                            }

                            $data['cart'] = $productList;
                            $data['jsCart'] = $jsCart;
                            $shopFilter = array(
                                'select' => 'sho_name, sho_link, sho_id, sho_user, sho_shipping, IF(sho_kho_district <> \'\', sho_kho_district, sho_district) AS district, IF((sho_kho_province <> 0) AND (sho_kho_district <> \'\' OR sho_kho_district <> 0), sho_kho_province, sho_province) AS province',
                                'where' => array('sho_user' => $shop_id)
                            );
                            // Add shop to seesion
                            $data['_shop'] = $this->shop_model->getShopInfo($shopFilter);
                            $this->session->set_userdata('shop', $data['_shop']);
                            $filterProvice = array(
                                'select' => 'pre_id AS id, pre_name AS val',
                                'order_by' => 'pre_order ASC'
                            );
                            $data['province'] = $this->province_model->getProvince($filterProvice);
                            $data['district'] = array();
                            $this->load->model('payment_model');
                            $data['infoPayment'] = $this->payment_model->get('*', 'id_user = '. (int)PAYMENT_USER_ID);
                            // get user information
                            $data['_user'] = array();
                            if ($this->session->userdata('sessionUser') > 0) {
                                $filterUser = array(
                                    'select' => 'use_fullname, use_address, use_province, user_district, use_email, IF(use_mobile <> \'\', use_mobile, use_phone) AS mobile',
                                    'where' => array(
                                        'use_id' => $this->session->userdata('sessionUser')
                                    )
                                );
                                $data['_user'] = $this->user_model->getUserInfo($filterUser);
                                if ($data['_user']['user_district'] != '' && $data['_user']['use_province']) {
                                    $filterDistrict = array(
                                        'select' => 'DistrictCode AS id, DistrictName AS val',
                                        'order_by' => 'DistrictName ASC',
                                        'where' => array('ProvinceCode' => $data['user']['use_province'])
                                    );
                                    $data['district'] = $this->district_model->getDistrict($filterDistrict);
                                }
                            }

                            #Load view
                            $this->load->view('shop/affiliate/order', $data);
                            break;

                        case 'orderv2':
                            $shop_id = (int)$this->uri->segment(3);
                            $cart = $this->session->userdata('cart_coupon');
                            if (empty($cart)) {
                                redirect(base_url() .'affiliate/checkout', 'location'); die();
                            }
                            $updateCart = false;
                            $jsCart = array();
                            $productList = array();
                            if ($this->session->userdata('sessionUser') > 0) {
                                // Check if login user is saler shop
                                $shopInfo = $this->shop_model->get("shop_type", "sho_user = " . $this->session->userdata('sessionUser'));
                                $wholesale = $shopInfo->shop_type > 0 ? true : false;
                                foreach ($cart as &$cItems) {
                                    if (!empty($cItems)) {
                                        foreach ($cItems as $k => $cp) {
                                            if ($cp['pro_user'] == $this->session->userdata('sessionUser')) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            }
                                            //
                                            if ($wholesale && $cp['store_type'] == 0) {
                                                unset($cItems[$k]);
                                                $updateCart = true;
                                                continue;
                                            } elseif ($wholesale && $cp['qty'] < $cp['qty_min']) {
                                                $cp['qty'] = $cp['qty_min'];
                                                $updateCart = true;
                                            }
                                        }
                                    }
                                }
                            }
                            $this->load->model('product_promotion_model');
                            foreach ($cart as $key => $cItems) {
                                if ($shop_id == $key && !empty($cItems)) {
                                    $jsCart[$key] = array('shop' => $key, 'products' => array());
                                    foreach ($cItems as $k => $cp) {
                                        // Build product price
                                        $select = 'pro_user, pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image,pro_type, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                                        $pro = $this->product_model->get($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type > 0');

                                        ## Get price for Trường Quy Cách SP, by Bao Tran
                                        if ($cp['dp_id'] > 0) {
                                            $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) as pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                                            $pro = $this->product_model->getProAndDetailForCheckout($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type > 0', (int)$cp['dp_id']);
                                        }

                                        if (empty($pro)) {
                                            unset($cItems[$k]);
                                            $updateCart = true;
                                            continue;
                                        }

                                        $afSelect = false;
                                        $cItems[$k]['af_user'] = $cp['af_id'];
                                        if ($cp['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                                            $afSelect = true;
                                        }
                                        $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                                        // Make discount for member
                                        $pro->em_discount = 0;
                                        if ($pro->pro_user != $this->session->userdata('sessionUser')) {
                                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cp['qty'], 'total' => ($discount['salePrice'] * $cp['qty'])));
                                            if (!empty($promotion)) {
                                                if ($promotion['dc_rate'] > 0) {
                                                    $pro->em_discount = $discount['salePrice'] * $cp['qty'] * $promotion['dc_rate'] / 100;
                                                } else {
                                                    $pro->em_discount = $promotion['dc_amt'];
                                                }
                                            }
                                        }

                                        $pro->pro_cost = $discount['salePrice'];
                                        $pro->key = $cp['key'];
                                        $pro->qty = $cp['qty'];
                                        $pro->shipping_fee = 0;
                                        $pro->pro_type = $cp['pro_type'];
                                        $pro->sho_link = $cp['sho_link'];
                                        $pro->qty_min = $cp['qty_min'] > 0 ? $cp['qty_min'] : 1;
                                        $pro->qty_max = $cp['qty_max'];
                                        $pro->store_type = $cp['store_type'];
                                        $pro->dp_id = $cp['dp_id'] > 0 ? $cp['dp_id'] : 0;
                                        $pro->dp_image = $cp['dp_id'] > 0 ? $pro->dp_images : '';
                                        $pro->dp_color = $cp['dp_id'] > 0 ? $pro->dp_color : '';
                                        $pro->dp_size = $cp['dp_id'] > 0 ? $pro->dp_size : '';
                                        $pro->dp_material = $cp['dp_id'] > 0 ? $pro->dp_material : '';
                                        $pro->dp_instock = $cp['dp_id'] > 0 ? $pro->dp_instock : 0;
                                        $pro->gr_id = $cp['gr_id'];
                                        $pro->gr_user = $cp['gr_user'];

                                        array_push($productList, $pro);
                                        $productItem = array('pro_id' => $pro->pro_id, 'key' => $pro->key, 'qty' => $pro->qty, 'pro_cost' => $pro->pro_cost, 'em_discount' => $pro->em_discount, 'dp_id' => $pro->dp_id);
                                        array_push($jsCart[$key]['products'], $productItem);
                                    }
                                }
                            }

                            if ($updateCart == true) {
                                $this->session->set_userdata('cart_coupon', $cart);
                            }

                            $data['cart'] = $productList;
                            $data['jsCart'] = $jsCart;
                            $shopFilter = array(
                                'select' => 'sho_name, sho_link, sho_id, sho_user, IF(sho_kho_district <> \'\', sho_kho_district, sho_district) AS district',
                                'where' => array('sho_user' => $shop_id)
                            );
                            // Add shop to seesion
                            $data['_shop'] = $this->shop_model->getShopInfo($shopFilter);
                            $this->session->set_userdata('shop', $data['_shop']);

                            $this->load->model('payment_model');
                            $data['infoPayment'] = $this->payment_model->get('*', "id_user = " . (int)PAYMENT_USER_ID);
                            // get user information
                            $data['_user'] = array();
                            if ($this->session->userdata('sessionUser') > 0) {
                                $filterUser = array(
                                    'select' => 'use_fullname, use_address, use_province, user_district, use_email, IF(use_mobile <> \'\', use_mobile, use_phone) AS mobile',
                                    'where' => array(
                                        'use_id' => $this->session->userdata('sessionUser')
                                    )
                                );

                                $data['_user'] = $this->user_model->getUserInfo($filterUser);
                            }

                            $data['pro_type'] = $this->uri->segment(4);

                            #Load view
                            $this->load->view('shop/affiliate/orderv2', $data);
                            break;

                        case 'news':
                            $data['protocol'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

                            //Get top sản phẩm, top coupon
                            $select = 'Distinct pro_id, pro_name, pro_dir, pro_image, pro_cost, af_amt, af_rate, sho_name, sho_link, domain, IF( tbtt_product.pro_saleoff = 1 AND (('.strtotime(date('Y/m/d', time())).' >= tbtt_product.begin_date_sale AND '.strtotime(date('Y/m/d', time())).' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )), CASE WHEN tbtt_product.pro_type_saleoff = 2 THEN tbtt_product.pro_saleoff_value WHEN tbtt_product.pro_type_saleoff = 1 THEN CAST( tbtt_product.pro_saleoff_value AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100 END, 0 ) AS off_amount, IF( tbtt_product.af_dc_amt > 0, CAST( tbtt_product.af_dc_amt AS DECIMAL (15, 5) ), IF( tbtt_product.af_dc_rate > 0, CAST( tbtt_product.af_dc_rate AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100, 0 ) ) AS af_off';
                            $where = 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN ('. $liststore .')';
                            $data['products'] = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where . ' AND pro_type = 0', 'pro_id', 'DESC');
                            $data['coupons'] = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where . ' AND pro_type = 2', 'pro_id', 'DESC');
                            //End get sp, coupon

                            //Tin chon cua shop khac
                            $getVar = $this->uri->uri_to_assoc(3);

                            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                                $start = (int) $getVar['page'];
                                $pageSort .= '/page/' . $start;
                            } else {
                                $start = 0;
                            }
                            $limit = 100;

                            $select = 'a.not_id, a.not_title, a.not_description, a.not_begindate, a.not_image, '
                                . 'a.not_image1, a.not_image2, a.not_image3, a.not_image4, a.not_image5, a.not_image6, a.not_image7, a.not_image8, a.not_image9, a.not_image10, '
                                . 'a.imglink1, a.imglink2, a.imglink3, a.imglink4, a.imglink5, a.imglink6, a.imglink7, a.imglink8, a.imglink9, a.imglink10, '
                                . 'a.not_dir_image, a.not_view, a.not_news_sale, a.not_news_hot, '
                                . 's.sho_name, s.sho_user, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_phone, s.sho_mobile, s.sho_facebook, s.domain';
                            $where = 'a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16';

                            $all = 'SELECT a.not_id FROM tbtt_content AS a JOIN tbtt_chontin AS c ON a.not_id = c.not_id LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user WHERE '. $where .' AND a.not_id = c.not_id AND c.sho_user_1 = '. (int)$shop->sho_user
                                .' ORDER BY `not_id` DESC';
                            $query = $this->db->query($all);
                            $total = $query->result();
                            $totalRecord = count($total);
                            $data['totalRecord'] = $totalRecord;
                            $config['base_url'] = base_url() . 'affiliate/news/page/';
                            $config['total_rows'] = $totalRecord;
                            $config['per_page'] = $limit;
                            $config['num_links'] = 5;
                            $config['cur_page'] = $start;
                            $this->pagination->initialize($config);
                            $data['linkPage'] = $this->pagination->create_links();

                            $page = 'SELECT '. $select .' FROM tbtt_content AS a JOIN tbtt_chontin AS c ON a.not_id = c.not_id LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user WHERE '. $where .' AND a.not_id = c.not_id AND c.sho_user_1 = '. (int)$shop->sho_user .' ORDER BY `not_id` DESC LIMIT '. $start .','. $limit;
                            $query = $this->db->query($page);
                            $ds_tin_chon = $query->result();
                            foreach ($ds_tin_chon as $key => $value) {
                                //Dem so lan chon tin
                                $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $value->not_id);
                                $result = $query->result();
                                if (count($result)) {
                                    $value->solanchon = count($result);
                                } else {
                                    $value->solanchon = 0;
                                }

                                //Dem binh luan
                                $query = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $value->not_id);
                                $result = $query->result();
                                if (count($result)) {
                                    $value->comments = count($result);
                                } else {
                                    $value->comments = 0;
                                }

                                /*get list product */
                                $array_id = $value->imglink1 . ',' . $value->imglink2 . ',' . $value->imglink4 . ',' . $value->imglink5 . ',' . $value->imglink6 . ',' . $value->imglink7 . ',' . $value->imglink8 . ',' . $value->imglink9 . ',' .  $value->imglink10;
                                $value->list_product = $this->product_model->fetch_join1("pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, sho_link, domain", "LEFT", "tbtt_shop", "sho_user = pro_user", "pro_id IN (" . $array_id . ")");


                            }
                            $data['ds_tin_chon'] = $ds_tin_chon;

                            // GET news hot
                            $sqlhot = 'SELECT '. $select .' FROM tbtt_content AS a JOIN tbtt_chontin AS c ON c.not_id = a.not_id LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user WHERE '. $where .' AND a.not_news_hot = 1 AND a.not_id = c.not_id AND c.sho_user_1 = '. (int)$shop->sho_user .' ORDER BY `not_id` DESC LIMIT 0, 10';
                            $query = $this->db->query($sqlhot);
                            $data['news_hot'] = $query->result();

                            // GET news sale
                            $sqlsale = 'SELECT '. $select .' FROM tbtt_content AS a JOIN tbtt_chontin AS c ON a.not_id = c.not_id LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user WHERE '. $where .' AND a.not_news_sale = 1 AND a.not_id = c.not_id AND c.sho_user_1 = '. (int)$shop->sho_user .' ORDER BY `not_id` DESC LIMIT  0, 10';
                            $query = $this->db->query($sqlsale);
                            $data['news_sale'] = $query->result();
                            // Load view
                            $this->load->view('shop/affiliate/news', $data);
                            break;

                        default:
                            // code...
                            break;
                    }
                } else {
                    $this->load->view('shop/affiliate/default', $data);
                }
                break;
        }
    }

    function affiliate_detail()
    {
        $action = array('detail');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        $proid = $getVar['detail'];
        if($proid > 0){
            //BÁO CÁO SP
            $this->load->model('reports_model');
            $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rp_id', 'ASC');
            $data['listreports'] = $listreports;
            //END BÁO CÁO SP
        }

        $product = $this->product_model->get('*,' . DISCOUNT_QUERY, 'pro_status = 1 AND pro_id = ' . $proid);
        $category = $this->category_model->get("*", "cat_id = " . $product->pro_category);
        $data['category'] = $category;

        $linkShop = $this->getShopLink();
        $shop = $this->shop_model->get("sho_user,sho_logo,sho_dir_logo,sho_user, domain, sho_link, sho_name", "sho_link = '" . $this->filter->injection($linkShop) . "' AND sho_status = 1");
        $user = $this->user_model->get('avatar', 'use_status = 1 AND use_group = 3 AND use_id = '. (int)$shop->sho_user);
        $shop->avatar = $user->avatar;
        $data['shop'] = $shop;
        //Get trường quy cách nếu có
        $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . $proid);
        if ($list_style && count($list_style) > 0) {
            $product = $this->product_model->getProAndDetail('*,' . DISCOUNT_QUERY . ", (af_rate) AS aff_rate, T2.*", 'pro_status = 1 AND pro_id = ' . $proid, $proid);
            $data['list_style'] = $list_style;
            $ar_color = array();
            $ar_size = array();
            $ar_material = array();
            foreach ($list_style as $k => $v) {
                if ($v->dp_color != '') {
                    $ar_color[] = $v->dp_color;
                }

                if ($v->dp_size != '') {
                    $ar_size[] = $v->dp_size;
                }

                if ($v->dp_material != '') {
                    $ar_material[] = $v->dp_material;
                }
            }

            $data['ar_color'] = array_unique($ar_color);
            $data['ar_size'] = array_unique($ar_size);
            $data['ar_material'] = array_unique($ar_material);

            $first_c = current($data['ar_color']);
            $first_s = current($data['ar_size']);
            $color_arr = array();
            $size_arr = array();
            $material_arr = array();
            $dp_color = '';
            if (!empty($data['ar_color'])) {
                if ($first_c) {
                    $dp_color = " AND dp_color LIKE '%" . $first_c . "%'";
                }
            }

            $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$product->pro_id . $dp_color);
            if ($li_size) {
                foreach ($li_size as $ks => $vs) {
                    $size_arr[] = $vs->dp_size;
                }
            }
            $data['ar_size'] = array_unique($size_arr);
            $dp_size = '';
            if (!empty($data['ar_size'])) {
                if ($first_s) {
                    $dp_size = " AND dp_size LIKE '%" . $first_s . "%'";
                }
            }
            $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$product->pro_id . $dp_color . $dp_size);
            if ($li_material) {
                foreach ($li_material as $km => $vm) {
                    $material_arr[] = $vm->dp_material;
                }
                $data['ar_material'] = array_unique($material_arr);
            }
        }
        // Get product promotion
        if ($product->pro_user != $this->session->userdata('sessionUser')) {
            $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));
        }
        $data['product'] = $product;
        //lay shop type cua sp
        $shopofpro = $this->shop_model->get("shop_type", "sho_user = '" . $product->pro_user . "' AND sho_status = 1");
        $data['shop_type'] = $shopofpro;
        //end shop type

        //End
        //Share fb, zl, gg
        $segment = $this->uri->segment(2);
        $linktoshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link . '.' . domain_site;
        $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
        $data['ogurl'] = $linktoshop . '/affiliate/'.$segment.'/detail/' . $data['product']->pro_id . '/' . RemoveSign($data['product']->pro_name) . $af;
        //End share

        $get_shop = $this->product_affiliate_user_model->fetch('pro_id','use_id = ' . (int)$shop->sho_user);
        if(count($get_shop) > 0){
            $listshop = array();
            foreach ($get_shop as $items){
                $listshop[] = $items->pro_id;
            }
            $liststore = implode(',', $listshop);
        }
        //pro cat
        if($liststore != ''){
            //Get category at header
            $cat = array();
            $getcat = $this->product_model->fetch_join1('pro_category', 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN (' . $liststore . ')');
            foreach($getcat as $item){
                $cat[] = $item->pro_category;
            }
            $strcat = implode(',',$cat);
            if($strcat != ''){
                $category = $this->category_model->fetch("cat_id, cat_name, cate_type", "cat_id IN(" . $strcat.")");
                $data['category_list'] = $category;
            }

            $segment = $this->uri->segment(2);
            $type = 0;
            $txttype = 'product';
            if($segment=='coupon'){
                $type = 2;
                $txttype = 'coupon';
            }
            $data['segment'] = $segment;

            $limit = 16;
            $action_page = array('page');
            $getPage = $this->uri->uri_to_assoc(6, $action_page);
            if ($getPage['page'] != FALSE && (int)$getPage['page'] > 0) {
                $start = (int)$getPage['page'];
            } else {
                $start = 0;
            }

            $select_ = 'id, pro_id, pro_name, pro_dir, pro_image, pro_cost, af_amt, af_rate, sho_name, sho_link, domain';
            $where = 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN (' . $liststore . ') AND pro_type = ' . (int)$type
                .' AND pro_id != ' . $proid . ' AND pro_category = ' . $data['product']->pro_category;
            $data['product_cat'] = $this->product_model->fetch_join($select_ . DISCOUNT_QUERY, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'LEFT', 'tbtt_detail_product', 'tbtt_product.pro_id = tbtt_detail_product.dp_pro_id', '', '', '', $where . ' GROUP BY pro_id', 'pro_id', 'desc', $start, $limit);

            //#BEGIN: Pagination
            $this->load->library('pagination');
            $totalRecord = count($this->product_model->fetch_join($select_ . DISCOUNT_QUERY, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'LEFT', 'tbtt_detail_product', 'tbtt_product.pro_id = tbtt_detail_product.dp_pro_id', '', '', '', $where . ' GROUP BY pro_id', 'pro_id', 'desc', $start, ''));
            $config['base_url'] = base_url() . 'affiliate/product/detail/' . $proid .'/'.RemoveSign($product->pro_name) . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['uri_segment'] = 7;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            $data['linkPage'] = $this->pagination->create_links();
        }
        #Load view
        //FOOTER
        $footer = $this->user_model->fetch_join('sho_name,sho_link,domain,sho_descr,sho_address,sho_district,sho_province,use_mobile,use_phone,use_email','INNER','tbtt_shop','tbtt_shop.sho_user = use_id','sho_status = 1 and use_status = 1 and sho_user = ' . (int)$shop->sho_user);
        $linkweb = $footer[0]->sho_link.domain_site;
        if($footer[0]->domain != ''){
            $linkweb = $footer[0]->domain;
        }
        $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('DistrictCode' => $footer[0]->sho_district,'ProvinceCode' => $footer[0]->sho_province));
        $data['sho_address'] = $footer[0]->sho_address.','.$tinhThanh->DistrictName.','.$tinhThanh->ProvinceName;
        $data['linkweb'] = $linkweb;
        $data['footer'] = $footer[0];
        //END FOOTER
        $this->load->view('shop/affiliate/detail', $data);
    }

    /*----------------process image shop-----------------*/

    private function _allow_upload_shop()
    {
        if(!$this->isLogin()){
            return false;
        }

        if(empty($this->shop_current) || $this->shop_current->sho_status != 1){
            return false;
        }

        $group_id = $this->session->userdata('sessionGroup');
        $user_id = $this->session->userdata('sessionUser');

        if($this->shop_current->sho_user == $user_id){
            return true;
        }

        if($group_id == StaffStoreUser){
            $user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $this->shop_current->sho_user], ['select' => 'use_id']);
            if(empty($user_staff)){
                return false;
            }
        }

        return true;
    }

    //upload folder temp
    public function upload_banner()
    {
        if ($this->input->is_ajax_request() && $this->_allow_upload_shop()){
            $this->load->config('config_upload');
            $config = $this->config->item('banner_shop_config');
            $this->_upload_temp('banner_res', $config);
        }
        die('error');
    }

    //apply process crop image
    public function process_banner()
    {
        $this->load->config('config_upload');
        $config = $this->config->item('banner_shop_config');

        if ($this->input->is_ajax_request() && $this->_allow_upload_shop()  && ($image_name = $this->session->userdata('shop_banner_res'))){
            if (file_exists($config['upload_path_temp'] . '/' . $image_name)) {
                $this->load->library(['ftp', 'upload' , 'image_lib']);
                $config_crop    = $this->_get_crop_image($this->input->post('points'), $config['upload_path_temp'] . '/' . $image_name);
                $shop           = $this->shop_current;
                if ($shop->sho_dir_banner) {
                    $dir_image = $dirBanner = $shop->sho_dir_banner;
                } else {
                    $dirBanner = $dir_image = $this->session->userdata('sessionUser');
                }

                $config['upload_path'] = $config['upload_path'] . '/' . $dir_image;

                if($config_crop !== false) {
                    $this->upload->exist_create_dir($config['upload_path']);
                    $this->image_lib->initialize($config_crop);
                    if (!$this->image_lib->crop()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die();
                    }
                    $this->image_lib->clear();

                    $config_resize                   = array();
                    $config_resize['image_library']  = 'gd2';
                    $config_resize['source_image']   = $config['upload_path_temp'] . '/' . $image_name;
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['quality']        = 100;
                    $config_resize['width']          = $config['fit_width'];
                    $config_resize['height']         = $config['fit_height'];

                    $this->image_lib->initialize($config_resize);
                    if (!$this->image_lib->resize()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die();
                    }
                    $this->image_lib->clear();
                }

                //copy to folder cover, upload fpt, process crop
                $this->upload->exist_create_dir($config['upload_path']);
                copy($config['upload_path_temp'] . '/' . $image_name, $config['upload_path'] . '/' . $image_name);
                @unlink($config['upload_path_temp'] . '/' . $image_name);
                // upload server cdn
                $this->ftp->connect($this->config->item('configftp'));
                $pathBanner = $this->config->item('cloud_banner_shop_config')['upload_path'];

                $listdir = $this->ftp->list_files($pathBanner . $dirBanner);
                if(empty($listdir)){
                    $this->ftp->mkdir($pathBanner . $dirBanner, 0775);
                }

                /* Upload this image_co to cloud server */
                $pathTargetC = $this->config->item('cloud_banner_shop_config')['upload_path'];
                $source_path = $config['upload_path'] . '/' . $image_name;
                $target_path = $pathTargetC . '/' . $dirBanner . '/' . $image_name;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                $this->ftp->close();

                //upload model user
                $this->shop_model->update_where(['sho_banner' => $image_name, 'sho_dir_banner' => $dirBanner], ['sho_id' => $shop->sho_id]);

                //remove cover old
                if($shop->sho_banner) {
                    @unlink($config['upload_path'] . '/' . $shop->sho_dir_banner . '/' . $shop->sho_banner);
                }
                $this->session->unset_userdata('shop_banner_res');

                echo json_encode([
                    'status' => true,
                    'dir'    => $config['upload_path'],
                    'name'   => $image_name,
                    'sho_dir_banner'   => $dirBanner,
                    'cloud_server_show_path'   => $config['cloud_server_show_path'],
                ]);
            }
        }else{
            echo json_encode([
                'status'    => false,
                'message'   => $this->lang->line('error_crop_iamge')
            ]);
        }
        die();
    }

    //upload folder temp
    public function upload_logo()
    {
        if ($this->input->is_ajax_request() && $this->_allow_upload_shop()){
            $this->load->config('config_upload');
            $config = $this->config->item('avatar_user_config');
            $this->_upload_temp('logo_res', $config);
        }
        die('error');
    }

    //apply process crop image
    public function process_logo()
    {
        $this->load->config('config_upload');
        $config = $this->config->item('avatar_user_config');
        if ($this->input->is_ajax_request() && $this->_allow_upload_shop() && ($dir_upload = $this->session->userdata('sessionUser')) && ($image_name = $this->session->userdata('shop_logo_res'))){
            if (file_exists($config['upload_path_temp'] . '/' . $image_name)) {
                $shop = $this->shop_current;
                $this->load->library(['ftp', 'upload' , 'image_lib']);
                $config_rotate  = $this->_get_rotate_image($this->input->post('orientation'), $config['upload_path_temp'] . '/' . $image_name);
                $config_crop    = $this->_get_crop_image($this->input->post('points'), $config['upload_path_temp'] . '/' . $image_name);
                $process_image  = false;

                if($config_rotate !== false){
                    //copy to folder cover, upload fpt, process crop
                    $config['upload_path'] = $config['upload_path'] . '/' . $dir_upload;
                    $this->upload->exist_create_dir($config['upload_path']);

                    $this->image_lib->initialize($config_rotate);
                    if (!$this->image_lib->rotate()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die();
                    }
                    $this->image_lib->clear();
                    $process_image = true;
                }

                if($config_crop !== false) {
                    //copy to folder cover, upload fpt, process crop
                    $config['upload_path'] = $config['upload_path'] . '/' . $dir_upload;
                    $this->upload->exist_create_dir($config['upload_path']);

                    $this->image_lib->initialize($config_crop);
                    if (!$this->image_lib->crop()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die();
                    }
                    $this->image_lib->clear();

                    $config_resize                   = array();
                    $config_resize['image_library']  = 'gd2';
                    $config_resize['source_image']   = $config['upload_path_temp'] . '/' . $image_name;
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['width']          = $config['min_width'];
                    $config_resize['height']         = $config['min_height'];

                    $this->image_lib->initialize($config_resize);
                    if (!$this->image_lib->resize()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die();
                    }
                    $this->image_lib->clear();
                    $process_image = true;
                }

                if ($process_image) {
                    copy($config['upload_path_temp'] . '/' . $image_name, $config['upload_path'] . '/' . $image_name);
                    @unlink($config['upload_path_temp'] . '/' . $image_name);

                    // upload server cdn
                    $this->ftp->connect($this->config->item('configftp'));
                    $pathLogo = $this->config->item('cloud_logo_shop_config')['upload_path'];

                    if ($shop->sho_dir_logo) {
                        $dirLogo = $shop->sho_dir_logo;
                    } else {
                        $dirLogo = date('dmY');
                    }

                    $listdir = $this->ftp->list_files($pathLogo . $dirLogo);
                    if(empty($listdir)){
                        $this->ftp->mkdir($pathLogo . $dirLogo, 0775);
                    }

                    $path_target_c = $pathLogo;
                    $source_path   = $config['upload_path'] . '/' . $image_name;
                    $target_path   = $path_target_c . '/' . $dirLogo . '/' . $image_name;
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                    $this->ftp->close();

                    //upload model shop
                    $this->shop_model->update_where(['sho_logo' => $image_name, 'sho_dir_logo' => $dirLogo], ['sho_id' => $shop->sho_id]);

                    //remove cover old
                    if($shop->sho_logo && file_exists($config['upload_path'] . '/' . $shop->sho_logo)) {
                        @unlink($config['upload_path'] . '/' . $shop->sho_logo);
                    }
                    $this->session->unset_userdata('shop_logo_res');
                    echo json_encode([
                        'status' => true,
                        'image'  => $config['upload_path'] . '/' . $image_name
                    ]);

                } else{
                    echo json_encode([
                        'status'    => false,
                        'message'   => $this->image_lib->display_errors()
                    ]);
                    die();
                }
            }

        }else{
            echo json_encode([
                'status'    => false,
                'message'   => $this->lang->line('error_crop_iamge')
            ]);
        }
        die();
    }

    /**
     * @param $orientation
     * @param $image_path
     * @return array|bool
     * get config rotate image
     */
    private function _get_rotate_image($orientation, $image_path)
    {
        if (!$image_path || empty($orientation) || (int)$orientation === 1)
            return false;

        //Exif Orientation Tag (Feb 17 2002)
        $config = [];
        if($orientation == 6){
            $config['rotation_angle'] = '270';
        }

        if($orientation == 3){
            $config['rotation_angle'] = '180';
        }

        if($orientation == 8){
            $config['rotation_angle'] = '90';
        }

        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;

        return $config;
    }

    /**
     * @param $points
     * @param $image_path
     * @return mixed
     * check and get config crop for gd2
     */
    private function _get_crop_image($points, $image_path)
    {
        if (!$image_path || empty($points) || sizeof($points) !== 4)
            return false;

        $left   = (int)$points[0];
        $top_x  = (int)$points[1];
        $right  = (int)$points[2];
        $bottom = (int)$points[3];

        $cropped_width  = $right - $left;
        $cropped_height = $bottom - $top_x;
        $image_info     = $this->image_lib->get_image_properties($image_path, true);

        if($image_info['width'] < $cropped_width)
            return false;

        if($image_info['height'] < $cropped_height)
            return false;

        $configCrop['quality']        = 100;
        $configCrop['maintain_ratio'] = false;
        $configCrop['source_image']   = $image_path;
        $configCrop['width']          = $cropped_width;
        $configCrop['height']         = $cropped_height;
        $configCrop['x_axis']         = $left;
        $configCrop['y_axis']         = $top_x;
        return $configCrop;
    }

    /**
     * @param $name_input_file
     * @param $config
     * validate and upload image to temp dir
     */

    private function _upload_temp($name_input_file, $config)
    {
        $this->load->library('upload');
        $this->load->config('config_upload');

        if (!is_dir($config['upload_path_temp'])) {
            @mkdir($config['upload_path_temp'], 0777, true);
            $this->load->helper('file');
            @write_file($config['upload_path_temp'] . '/index.html', '<p>Directory access is forbidden.</p>');
        }
        $config['upload_path'] = $config['upload_path_temp'];
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name_input_file) && ($uploadData = $this->upload->data())) {

            $image_co        = $uploadData['file_name'];
            $type            = pathinfo($uploadData['full_path'], PATHINFO_EXTENSION);
            $data            = file_get_contents($uploadData['full_path']);
            $photo_dest_crop = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $this->session->set_userdata('shop_'.$name_input_file, $image_co);

            echo json_encode([
                'image'      => $photo_dest_crop,
                'name'       => $image_co,
                'message'    => 'success',
                'status'     => true,
            ]);

            unset($uploadData);
            die();
        }else {
            echo json_encode([
                'status'    => false,
                'message'   => $this->upload->display_errors('', '')
            ]);
        }
        die();
    }

    public function getListProduct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        if (!$this->isLogin()){
            //chưa đăng nhập
            die();
        }

        $sessionUser    = (int)$this->session->userdata('sessionUser');
        $sessionGroup   = (int)$this->session->userdata('sessionGroup');

        if(!in_array($sessionGroup, json_decode(MEMBERS_STORE, true))){
            //không phải nhân viên của store or branch
            die();
        }

        $sessionUser    = $this->user_model->get_own_shop_or_branch($sessionUser);
        $list_user      = $this->user_model->get_all_user_shop_of_branch($sessionUser, 'string');
        $products       = $this->product_model->fetch("pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type", "pro_type IN (0,2) AND pro_status = 1 AND pro_user IN (" . $list_user . ")" , "pro_type", "ASC", 0, 15);

        echo json_encode($products);
        die();
    }

    /**
     * route domain_shop/product || /coupon
     */
    public function slash_product($type = 'product')
    {
        $types = ['product', 'coupon'];
        if (!in_array($type, $types)) {
            die();
        }
        $data['menuSelected'] = $type;
        $linkShop             = get_shop_link(); // ==> sho_link or domain in tbtt_shop
        $this->load->model('images_model');
        $this->load->model('product_affiliate_user_model');

        $group_id = (int)$this->session->userdata('sessionGroup');
        $user_id  = (int)$this->session->userdata('sessionUser');

        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        #BEGIN: Get shop by $linkShop
        $shop = $this->shop_model->get('*', '(sho_link = "' . $linkShop . '" OR domain = "' . $linkShop . '" ) AND sho_status = 1');

        if (empty($shop)) {
            redirect($this->mainURL . 'page-not-found');
            die;
        }

        $shop->sho_district = $shop->sho_district ? $this->district_model->get('DistrictName', 'DistrictCode = "' . $shop->sho_district . '"')->DistrictName : '';
        $shop->sho_province = $shop->sho_province ? $this->province_model->get('pre_name', 'pre_id = ' . (int)$shop->sho_province)->pre_name : '';
        // Get youtube id from url
        if ($shop->shop_video) {
            $shop->shop_video = theme_get_youtube_id_from_url($shop->shop_video);
        }

        if ($shop->sho_user) {
            $row               = $this->user_model->get('use_id, use_email, af_key, use_group, use_username, use_fullname, avatar, parent_id', 'use_id = ' . (int)$shop->sho_user);
            $shop->sho_email   = $row->use_email;
            $shop->af_key      = $row->af_key;
            $shop->isAffiliate = $row->use_group == AffiliateUser;
            $shop->isBranch    = $row->use_group == BranchUser;
            $shop->parent      = $row->parent_id;
            $shop->user        = $row;
        }

        #Begin Shop
        $data['dataShop'] = $shop;
        #End Shop

        //chủ shop
        if (!empty($user_login)) {
            $data['is_owns'] = $shop->sho_user == $user_login;
        }

        ##BEGIN:: protocal & domainName
        $protocol           = get_server_protocol();
        $domainName         = $_SERVER['HTTP_HOST'];
        $data['protocol']   = $protocol;
        $data['domainName'] = $domainName;
        ##END:: protocal & domainName

        $idUser              = (int)$shop->sho_user;
        $data['siteGlobal']  = $shop;
        $data['isAffiliate'] = $shop->isAffiliate;
        $data['isBranch']    = $shop->isBranch;
        $data['URLRoot']     = $this->subURL;
        $data['mainURL']     = $this->mainURL;
        $data['shopId']      = (int)$shop->sho_user;
        $data['aliasDomain'] = $shop->shop_url;
        $linktoshop          = substr($data['aliasDomain'], 0, -1);

        #BEGIN: Update view
        if (!$this->session->userdata('sessionViewShopDetail_' . $shop->sho_id)) {
            $this->shop_model->update(array('sho_view' => (int)$shop->sho_view + 1), 'sho_id = ' . $shop->sho_id);
            $this->session->set_userdata('sessionViewShopDetail_' . $shop->sho_id, 1);
        }
        #END Update view
        #BEGIN: Exist af_key, for product detail
        $af_id = $_REQUEST['af_id'];
        if ($af_id != '') {
            $userObject = $this->user_model->get('*', 'af_key = "' . $af_id . '"');
            if ($userObject->use_id > 0) {
                $this->session->set_userdata('af_id', $af_id);
            }
        }
        $getUser           = $this->user_model->get('use_group, parent_id', 'use_id = ' . $idUser);
        $data['UserGroup'] = $getUser->use_group;
        #END: Exist af_key, for product detail
        #BEGIN: Load category
        $listCategory = array();
        if ($shop->isAffiliate) {
            /**
             *  Step1: Affiliate is get Shop or Bran nearest
             *  Step2: Get product their
             *  Step3: Get my product selected
             **/

            // Step1:: Get SHOP_ID or CHINHANH_ID gần nhất trong cây
            $shop_Id = $this->get_id_shop_in_tree((int)$shop->sho_user);

            // Step2:: Get product their
            $list_pro_aff  = $this->product_affiliate_user_model->fetch('pro_id', 'use_id = ' . (int)$shop->sho_user . ' AND homepage = 1');
            $li_pro_af     = array();
            $li_pro_af_str = '0';
            if ($list_pro_aff) {
                foreach ($list_pro_aff as $k => $v) {
                    $li_pro_af[] = $v->pro_id;
                }
                $li_pro_af_str = implode(',', $li_pro_af);
            }

            $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE (pro_user = ' . $shop_Id . ' OR pro_id IN (' . $li_pro_af_str . ')) AND pro_status = 1 AND is_product_affiliate = 1';
            $result      = $this->db->query($cat_pro_aff);
            $arrylist    = $result->result();

            if (count($arrylist) > 0) {
                $catid = array();
                foreach ($arrylist as $k => $item) {
                    if ($item->pro_category > 0) {
                        array_push($catid, $item->pro_category);
                    }
                }
                $catarr = implode(',', $catid);
                if ($catarr != '') {
                    $sql
                                          = 'SELECT cat_id, cat_name, cate_type FROM tbtt_category
                            WHERE cat_id IN (' . $catarr . ') ORDER BY cat_name ASC ';
                    $query                = $this->db->query($sql);
                    $data['listCategory'] = $query->result();
                }
            }

            $Pa_Shop_Global         = $this->shop_model->get('*', 'sho_user = ' . $shop_Id);
            $data['Pa_Shop_Global'] = $Pa_Shop_Global;
            $data['shopId']         = $shop_Id; // Redefine Shop ID
            $data['li_pro_id']      = $li_pro_af_str; // Get list product id selected
            $data['af_id']          = $row->af_key;
            $data['tlink']          = 'afproduct';
            $data['afLink']         = 'afcoupon';

            if ($Pa_Shop_Global->domain) {
                $domain_parent = $protocol . $Pa_Shop_Global->domain;
            } else {
                $domain_parent = $protocol . $Pa_Shop_Global->sho_link . '.' . domain_site;
            }
        } else {
            // ==> Gian hang va Chi nhanh dung chung
            $cat_pro_shop = 'SELECT DISTINCT(pro_category) FROM `tbtt_product` WHERE `pro_user` = ' . (int)$shop->sho_user . ' AND pro_status = 1';
            $result       = $this->db->query($cat_pro_shop);
            $arrylist     = $result->result();
            $catid        = array();
            if (count($arrylist) > 0) {
                foreach ($arrylist as $k => $item) {
                    if ($item->pro_category > 0) {
                        array_push($catid, $item->pro_category);
                    }
                }
                $catarr = implode(',', $catid);
                if (isset($catarr) && $catarr != '') {
                    $sql = 'SELECT `cat_id`,`cat_name`,`parent_id` AS parents, `cate_type`
                            FROM `tbtt_category` WHERE `cat_id` IN (' . $catarr . ') ORDER BY tbtt_category.cat_name ASC ';
                    $query                = $this->db->query($sql);
                    $data['listCategory'] = $query->result();
                }
            }
            $data['tlink']  = 'product';
            $data['afLink'] = 'coupon';

            ##BEGIN: Get id_key when ctv login
            if (isset($user_id) && !empty($user_id) && $group_id == AffiliateUser) {
                $af_id         = $this->user_model->get('af_key', 'use_id = ' . $user_id)->af_key;
                $data['af_id'] = $af_id;
            }
            ##END: Get id_key when ctv login
        }
        #END: Load category

        $data['bannertops']    = $this->banner_model->fetch('*', 'sho_id = ' . (int)$shop->sho_id . ' AND banner_position = 1 AND published = 1', 'order_num, id', 'ASC');
        $data['bannerlefts']   = $this->banner_model->fetch('*', 'sho_id = ' . (int)$shop->sho_id . ' AND banner_position = 2 AND published = 1', 'order_num, id', 'ASC');
        $data['bannerrights']  = $this->banner_model->fetch("*", "sho_id = " . (int)$shop->sho_id . " AND banner_position = 3 AND published = 1", "order_num, id", "ASC");
        $data['bannerbottoms'] = $this->banner_model->fetch("*", "sho_id = " . (int)$shop->sho_id . " AND banner_position = 4 AND published = 1", "order_num, id", "ASC");

        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined']              = false;
        if ($this->check->is_logined($user_id, $group_id, 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $isAdded = false;

                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne      = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray . " AND pro_user = $idUser");
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . $user_id);
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $user_id && $this->check->is_id($checkOneArray)) {
                        $dataAdd = array(
                            'prf_product' => (int)$checkOneArray,
                            'prf_user' => (int)$this->session->userdata('sessionUser'),
                            'prf_date' => $currentDate
                        );
                        if ($this->product_favorite_model->add($dataAdd)) {
                            $isAdded = true;
                        }
                    }
                }
                unset($productOne);
                unset($productFavorite);
                if ($isAdded == true) {
                    $this->session->set_flashdata('sessionSuccessFavoriteProduct', 1);
                }
                $this->session->set_userdata('sessionTimePosted', time());
                redirect($this->mainURL . trim(uri_string(), '/'), 'location');
            }
        }

        #END Add favorite
        switch (strtolower($this->uri->segment(segmentThird))) {
            case 'cat':

            case '': // ==> Categories product or cp or sv

                $select   = '';
                $where    = '';
                $sort     = 'pro_id';
                $by       = 'DESC';
                $pageSort = '';
                $pageUrl  = '';

                $action = array('cat', 'sort', 'by', 'page');
                $getVar = $this->uri->uri_to_assoc(3, $action);
                $cat_id = $getVar['cat'] != '' ? (int)$getVar['cat'] : 0;

                if ($this->session->userdata('sessionGroup') == AffiliateUser) {
                    $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                } else {
                    $af = '';
                }
                $category = $this->category_model->get("*", "cat_id = " . $cat_id);
                #Start:: SEO meta tag
                $data['descrSiteGlobal']    = $category->cat_descr ? $category->cat_descr : $shop->sho_description;
                $data['keywordsSiteGlobal'] = $category->keyword ? $category->keyword : $shop->sho_keywords;
                $data['ogurl']              = $linktoshop . '/shop/product/cat/' . $category->cat_id . '/' . RemoveSign($category->cat_name) . $af;
                $data['ogtype']             = "website";
                $data['ogtitle']            = $category->cat_name;
                $data['ogdescription'] = $category->cat_descr ? $category->cat_descr : $shop->sho_description;
                #END:: SEO meta tag

                $data['category'] = $category;

                $url = $this->uri->segment(segmentSecond);

                $protype = 0;
                if ($url == 'product') {
                    $protype = 0;
                } elseif ($url == 'coupon') {
                    $protype = 2;
                }

                $where .= 'pro_status = 1 AND pro_user = ' . $idUser . ' AND pro_type = ' . $protype;
                if ($cat_id > 0) {
                    $where .= ' AND pro_category = ' . $cat_id;
                }

                $data['query_str'] = $this->input->server('QUERY_STRING');
                parse_str($data['query_str'], $parrams);
                if ($parrams['q'] != '') {
                    $where .= ' AND pro_name  like ' . $this->db->escape('%' . $parrams['q'] . '%');
                }
                if ($parrams['price'] != '') {
                    $where .= ' AND pro_cost  >= ' . (int)$parrams['price'];
                }
                if ($parrams['price_to'] != '') {
                    $where .= ' AND pro_cost  <= ' . (int)$parrams['price_to'];
                }
                $data['parrams'] = $parrams;
                #BEGIN: Sort
                $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : 'id';
                $getVar['by']   = $getVar['by'] != '' ? $getVar['by'] : 'desc';
                switch (strtolower($getVar['sort'])) {
                    case 'name':
                        $pageUrl .= '/sort/name';
                        $sort    = "pro_name";
                        break;
                    case 'cost':
                        $pageUrl .= '/sort/cost';
                        $sort    = "pro_cost";
                        break;
                    case 'buy':
                        $pageUrl .= '/sort/buy';
                        $sort    = "pro_buy";
                        break;
                    case 'view':
                        $pageUrl .= '/sort/view';
                        $sort    = "pro_view";
                        break;
                    case 'date':
                        $pageUrl .= '/sort/date';
                        $sort    = "pro_begindate";
                        break;
                    default:
                        $pageUrl .= '/sort/id';
                        $sort    = "pro_id";
                }

                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                    $pageUrl .= '/by/desc';
                    $by      = "DESC";
                } else {
                    $pageUrl .= '/by/asc';
                    $by      = "ASC";
                }

                #If have page
                if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                    $start    = (int)$getVar['page'];
                    $pageSort .= '/page/' . $start;
                } else {
                    $start = 1;
                }

                if($start < 0){
                    $start = 1;
                }

                $start = ($start -1)* settingShoppingNew_List;

                $data['default_sort'] = $getVar['sort'] . '_' . $getVar['by'];
                #BEGIN: Create link sort
                if (!isset($getVar['cat']) || $getVar['cat'] == '' || $getVar['cat'] == 0 || empty($getVar['cat'])) {
                    $data['sortUrl'] = '/shop/' . $url . '/cat/0/sort/';
                    $getVar['cat']   = 0;
                } else {
                    $data['sortUrl'] = '/shop/' . $url . '/cat/' . $getVar['cat'] . '/sort/';
                }

                #END Sort
                #BEGIN: Create link sort
                $data['pageSort'] = $pageSort;
                #END Create link sort
                #BEGIN: Pagination
                $this->load->config('config_pagination');
                $config = $this->config->item('pagination_shop_product');
                $totalRecord           = $this->product_model->fetch_join('count(distinct pro_id) AS total', "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", 'tbtt_detail_product', 'tbtt_detail_product.dp_pro_id = pro_id', $where, '', '', '', '', '', '', 'row');
                $config['base_url']    = '/shop/' . $url . '/cat/' . $getVar['cat'] . $pageUrl . '/page/';
                $config['total_rows']  = $totalRecord;
                $config['per_page']    = settingShoppingNew_List;
                $config['num_links']   = 1;
                $config['uri_segment'] = 10;
                $config['cur_page']    = $start;
                $this->pagination->initialize($config);
                $data['linkPage'] = $this->pagination->create_links();
                #END Pagination
                #Fetch record
                $select                .= "id, id as dp_id, pro_id, pro_name, pro_category, pro_detail, pro_descr, pro_keyword, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_saleoff_value, pro_hondle, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, pro_type";
                $limit                 = settingShoppingNew_List;
                $data['product']       = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", 'tbtt_detail_product', 'tbtt_detail_product.dp_pro_id = pro_id', $where . ' GROUP BY pro_id', $sort, $by, $start, $limit);
                $data['product_count'] = $totalRecord;
                $data['body_class']    = ' trangcuahang-sanpham ';
                #Load view
                $this->load->view('shop/product/cat', $data);
                break;

            case 'detail':
                #Define url for $getVar
                $action = array('detail');
                $getVar = $this->uri->uri_to_assoc(3, $action);
                if ($this->session->userdata('sessionUser') > 0) {
                    $dataEye = array(
                        'idview' => (int)$getVar['detail'],
                        'userid' => $this->session->userdata('sessionUser'),
                        'typeview' => 1,
                        'timeview' => 1
                    );

                    $checkEye = $this->eye_model->fetch("*", "idview = " . (int)$getVar['detail'] . "  AND userid= " . $user_id . " AND typeview = 1 ", "id", 'DESC');
                    if (count($checkEye) == 0)
                        $this->eye_model->add($dataEye);
                }

                if ($getVar['detail'] != FALSE) {

                    //BÁO CÁO SP
                    $this->load->model('reports_model');

                    $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rp_id', 'ASC');

                    $data['listreports'] = $listreports;
                    //END BÁO CÁO SP

                    #BEGIN: Check exist product by id
                    $product = $this->product_model->get("* , (af_rate) AS aff_rate" . DISCOUNT_QUERY . ", count(*) as dem", "pro_id = " . (int)$getVar['detail'] . " AND pro_user = $idUser AND pro_status = 1");

                    $shop_id_user      = $this->shop_model->get("shop_type", "sho_user = " . $product->pro_user . " AND sho_status = 1 ");
                    $data['shop_type'] = $shop_id_user;
                    if ($product && $product->pro_id <= 0) {
                        redirect($this->subURL, 'location');
                        die();
                    }
                    ##BEGIN::Check product have TRƯỜNG QUI CÁCH
                    // Add by Bao Tran
                    $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$product->pro_id);
                    ##BEGIN::Check product have TRƯỜNG QUI CÁCH
                    //Nếu có TQC
                    if ($list_style) {
                        $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . (int)$getVar['detail'] . " AND pro_user = $idUser AND pro_status = 1", (int)$getVar['detail']);
                    }

                    #END Check exist product by id
                    $this->load->library('bbcode');
                    #BEGIN: Update view
                    if (!$this->session->userdata('sessionViewProduct_' . (int)$getVar['detail'])) {
                        $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = " . (int)$getVar['detail']);
                        $this->session->set_userdata('sessionViewProduct_' . (int)$getVar['detail'], 1);

                        //dem so luong click link cho af
                        $this->add_view_af_share((int)$getVar['detail']);
                    }
                    #END Update view
                    #Begin:: SEO keyword meta tag
                    $this->load->helper('text');
                    $data['descrSiteGlobal']    = cut_string_unicodeutf8(strip_tags(html_entity_decode($product->pro_descr)), 255);
                    $data['keywordsSiteGlobal'] = $product->pro_keyword;
                    $img_pro                    = explode(',', $product->pro_image);
                    //$linktoshop = $shop->domain ? $protocol . $shop->domain : $protocol . $shop->sho_link . '.' . domain_site;

                    $check_http = explode(':', $img_pro[0])[0];
                    if($check_http == 'http' || $check_http == 'https'){
                        $og_image = $img_pro[0];
                    }else{
                        $og_image = DOMAIN_CLOUDSERVER .'media/images/product/'. $itempro->pro_dir .'/thumbnail_2_'. $img_pro[0];
                    }
                    $af                    = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
                    $data['ogurl']         = $linktoshop . '/shop/product/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $af;
                    $data['ogtype']        = "product";
                    $data['ogtitle']       = $product->pro_name;
                    $data['ogimage']       = $og_image;
                    $data['ogdescription'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product->pro_descr)), 255);

                    #END:: SEO keyword meta tag
                    #BEGIN: Get product by id and relate info
                    $data['product'] = $product;
                    //Check in_stock
                    if ($product->pro_instock < 1) {
                        $data['product']->status = array(
                            'val' => TRUE,//Has message
                            'pro_instock' => FALSE,//No products
                            'message' => 'Sản phẩm hết hàng'
                        );
                    }

                    $data['category'] = $this->category_model->get("cat_id, cat_name, cat_descr, cat_status, cate_type", "cat_id = " . (int)$product->pro_category);
                    #END Get product by id and relate info
                    //Get shop of product, by BaoTran
                    $data['shop_pro'] = $this->shop_model->get("sho_link, domain, sho_user, sho_id", "sho_user = " . (int)$product->pro_user);

                    //Get trường quy cách nếu có

                    if ($list_style && count($list_style) > 0) {
                        $data['list_style'] = $list_style;
                        $ar_color           = array();
                        $ar_size            = array();
                        $ar_material        = array();
                        foreach ($list_style as $k => $v) {
                            if ($v->dp_color != '') {
                                $ar_color[] = $v->dp_color;
                            }

                            if ($v->dp_size != '') {
                                $ar_size[] = $v->dp_size;
                            }

                            if ($v->dp_material != '') {
                                $ar_material[] = $v->dp_material;
                            }
                        }

                        $data['ar_color']    = array_unique($ar_color);
                        $data['ar_size']     = array_unique($ar_size);
                        $data['ar_material'] = array_unique($ar_material);

                        $first_c      = current($data['ar_color']);
                        $first_s      = current($data['ar_size']);
                        $color_arr    = array();
                        $size_arr     = array();
                        $material_arr = array();
                        $dp_color     = '';
                        if (!empty($data['ar_color'])) {
                            if ($first_c) {
                                $dp_color = " AND dp_color LIKE '%" . $first_c . "%'";
                            }
                        }

                        $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$product->pro_id . $dp_color);
                        if ($li_size) {
                            foreach ($li_size as $ks => $vs) {
                                $size_arr[] = $vs->dp_size;
                            }
                        }
                        $data['ar_size'] = array_unique($size_arr);
                        $dp_size         = '';
                        if (!empty($data['ar_size'])) {
                            if ($first_s) {
                                $dp_size = " AND dp_size LIKE '%" . $first_s . "%'";
                            }
                        }
                        $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$product->pro_id . $dp_color . $dp_size);
                        if ($li_material) {
                            foreach ($li_material as $km => $vm) {
                                $material_arr[] = $vm->dp_material;
                            }
                            $data['ar_material'] = array_unique($material_arr);
                        }
                    }

                    // Get product promotion
                    if ($product->pro_user != $this->session->userdata('sessionUser')) {
                        $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));
                    }

                    //get thông báo chọn bán hay chưa
                    if ($this->session->userdata('sessionUser')) {
                        $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $product->pro_id));
                        if ($selected_sale) {
                            $data['selected_sale'] = $selected_sale;
                        }
                    }

                    //Check chon ban khi gian hang đang nhap
                    $GHchonban = 0;
                    if ($this->session->userdata('sessionGroup') == 3 && $product->is_product_affiliate == 1 && $shop->sho_user != $this->session->userdata('sessionUser')) {
                        $GHchonban = 1;
                    }
                    $data['GHchonban'] = $GHchonban;
                    #Load view
                    $this->load->view('shop/product/detail', $data);
                } else {
                    redirect($this->subURL, 'location');
                    die();
                }
                break;

            default: // ==> All product or coupon or services
                $action = array('sort', 'by', 'page');
                $getVar = $this->uri->uri_to_assoc(segmentSecond, $action);
                #BEGIN: Sort
                $where    = "pro_user = $idUser AND pro_status = 1";
                $sort     = 'pro_id';
                $by       = 'DESC';
                $pageSort = '';
                $pageUrl  = '';
                if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                    switch (strtolower($getVar['sort'])) {
                        case 'name':
                            $pageUrl .= '/sort/name';
                            $sort    = "pro_name";
                            break;
                        case 'cost':
                            $pageUrl .= '/sort/cost';
                            $sort    = "pro_cost";
                            break;
                        case 'buy':
                            $pageUrl .= '/sort/buy';
                            $sort    = "pro_buy";
                            break;
                        case 'view':
                            $pageUrl .= '/sort/view';
                            $sort    = "pro_view";
                            break;
                        case 'date':
                            $pageUrl .= '/sort/date';
                            $sort    = "pro_begindate";
                            break;
                        default:
                            $pageUrl .= '/sort/id';
                            $sort    = "pro_id";
                    }
                    if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                        $pageUrl .= '/by/desc';
                        $by      = "DESC";
                    } else {
                        $pageUrl .= '/by/asc';
                        $by      = "ASC";
                    }
                }
                #If have page
                if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                    $start    = (int)$getVar['page'];
                    $pageSort .= '/page/' . $start;
                } else {
                    $start = 0;
                }
                #END Sort
                #BEGIN: Create link sort
                $data['sortUrl']  = $this->mainURL . 'product/sort/';
                $data['pageSort'] = $pageSort;
                #END Create link sort
                #BEGIN: Pagination
                $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
                #BEGIN: Update quantity product
                if (!$this->session->userdata('sessionQuantityProductShopDetail_' . $shop->sho_id)) {
                    $this->shop_model->update(array('sho_quantity_product' => $totalRecord), "sho_id = " . $shop->sho_id);
                    $this->session->set_userdata('sessionQuantityProductShopDetail_' . $shop->sho_id, 1);
                }
                #END Update quantity product
                $config['base_url']    = $this->mainURL . 'product' . $pageUrl . '/page/';
                $config['total_rows']  = $totalRecord;
                $config['per_page']    = settingShoppingNew_List;
                $config['num_links']   = 1;
                $config['uri_segment'] = 4;
                $config['cur_page']    = $start;
                $this->pagination->initialize($config);
                $data['linkPage'] = $this->pagination->create_links();
                #END Pagination
                #Fetch record
                $select          = "pro_id, pro_category, pro_name,pro_detail, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_saleoff_value,pro_type_saleoff,pro_view,sho_name,sho_begindate,pre_name, pro_type";
                $limit           = settingShoppingNew_List;
                $data['product'] = $this->product_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
                #Load view

                $this->load->view('shop/product/defaults', $data);
        }
    }

    public function media_images($news_id = null, $image_id = null)
    {
        $this->_exist_shop();
        $this->set_layout('shop/media/media-layout');
        $data['view_type']          = $this->_view_type();
        $shop                       = $data['siteGlobal'] = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;
        $data['follow']             = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']           = $shop->sho_id;
        $data['page_view']          = 'image-page';
        $user_id                    = (int)$this->session->userdata('sessionUser');
        $group_id                   = $this->session->userdata('sessionGroup');
        $news_id                    = $news_id ? (int)$news_id : null;
        $image_id                   = $image_id ? (int)$image_id : null;
        $arr_relation               = [];
        $data['is_owns']            = $shop->sho_user == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owns']){
            $owns_id = $user_id;
        }

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_id;
            }
        }

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');

        if ($page < 1) {
            $page = 1;
        }

        // Số record trên một trang
        $limit = 10;

        // Tìm start
        $start = ($limit * $page) - $limit;

        $image = $this->content_model->shop_news_list_image($shop->sho_id, $limit, $start, $owns_id, false, $arr_relation, 0, $shop->sho_user);
        $imageContents = $this->content_model->shop_news_list_image_type($shop->sho_id, $limit, $start, $owns_id, false, $arr_relation, 0, $shop->sho_user, IMAGE_UP_DETECT_CONTENT);
        $imageUploads = $this->content_model->shop_news_list_image_type($shop->sho_id, $limit, $start, $owns_id, false, $arr_relation, 0, $shop->sho_user, IMAGE_UP_DETECT_LIBRARY);
        $data['imageContents'] = $imageContents;
        $data['imageUploads'] = $imageUploads;
        // dd($shop->sho_id);die;
        // dd($image);die;
        $this->load->model('like_image_model');

        foreach ($image as $index => $item) {
            if($this->session->userdata('sessionUser')){
                //active user like
                $is_like = $this->like_image_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'image_id' => (int) $item->id]);
                $image[$index]->is_like = count($is_like);
            }
            //get total like
            $list_likes = $this->like_image_model->get('id', ['image_id' => (int) $item->id]);
            $image[$index]->likes = count($list_likes);

            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_IMAGE.'/'.$item->id, []));
            $image[$index]->total_share = $jData->data->total_share;
        }
        $data['images'] = $image;
        $data['start'] = $start;
        $permission = PERMISSION_SOCIAL_PUBLIC;
        if($data['is_owns'] == true) {
            $permission = PERMISSION_SOCIAL_ME;
        }
        $data['albums'] = $this->album_model->get_album_with_total($this->shop_current->sho_user, $this->shop_current->sho_id, ALBUM_IMAGE, $permission);

        $this->load->model('reports_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'asc');
        $data['listreports'] = $listreports;

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        if(!empty($image) && $image[0]->name != ''){
            $check_http = explode(':', $image[0]->name)[0];
            if($check_http == 'http' || $check_http == 'https'){
                $ogimage = $image[0]->name;
            }else{
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $image[0]->not_dir_image . '/' . $image[0]->name;
            }
        }

        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.TYPESHARE_SHOP_LIBIMAGE);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user']         = $shop->sho_user;
        $data['type_share']         = TYPESHARE_SHOP_LIBIMAGE;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop . '/library/images';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = 'Thư viện ảnh của '.$this->shop_current->sho_name;
        
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];
        
        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/image-items', $data, true);
            die();
        }else{
            $this->load->view('shop/media/pages/media-image', $data);
        }
    }

    public function media_videos($response_type = 'videos')
    {
        //check exist shop
        $this->_exist_shop();
        $this->set_layout('shop/media/media-layout');
        if(!$response_type)
            $response_type = 'videos';

        $data['view_type'] = $this->_view_type();
        $data['page_view'] = 'video-page';
        $shop              = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id           = (int)$this->session->userdata('sessionUser');
        $group_id          = $this->session->userdata('sessionGroup');

        $data['is_owns'] = $shop->sho_user == $user_id;
        $owns_id         = false;

        if($data['is_owns']){
            $owns_id = $user_id;
        }

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_id;
            }
        }

        if($this->input->is_ajax_request()){
            $start = (int)$this->input->post('start');
        }

        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }
        // Số record trên một trang
        $limit = 10;

        if(!empty($start)){
            $limit = 5;
        }else{
            $start = ($limit * $page) - $limit;
        }

        $videos = $this->content_model->shop_news_list_videos($shop->sho_id, $limit, $start, $owns_id, false, $shop->sho_user);

        $this->load->model('like_video_model');
        foreach ($videos as $index => $video) {
            if($video->not_video_url1){
                if($this->session->userdata('sessionUser')){
                    //active user like
                    $is_like = $this->like_video_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'video_id' => (int) $video->not_video_url1]);
                    $videos[$index]->is_like = count($is_like);
                }
                //get total like
                $list_likes = $this->like_video_model->get('id', ['video_id' => (int) $video->not_video_url1]);
                $videos[$index]->likes = count($list_likes);

                //Dem share
                $jData = json_decode($this->callAPI('GET', API_LISTSHARE_VIDEO.'/'.$video->not_video_url1, []));
                $videos[$index]->total_share = $jData->data->total_share;
            }
        }
        $data['videos'] = $videos;
        $data['start']  = $start;
        $permission = PERMISSION_SOCIAL_PUBLIC;
        if($data['is_owns'] == true) {
            $permission = PERMISSION_SOCIAL_ME;
        }

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        if(!empty($videos) && $videos[0]->thumbnail != ''){
            $check_http = explode(':', $videos[0]->thumbnail)[0];
            if($check_http == 'http' || $check_http == 'https'){
                $ogimage = $videos[0]->thumbnail;
            }else{
                $ogimage = DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $videos[0]->thumbnail;
            }
        }

        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.TYPESHARE_SHOP_LIBVIDEO);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user']         = $shop->sho_user;
        $data['type_share']         = TYPESHARE_SHOP_LIBVIDEO;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop.'/library/videos';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = 'Thư viện video của '.$this->shop_current->sho_name;
        
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];
        
        if($this->input->is_ajax_request()){
            if($response_type == 'videos'){
                echo $this->load->view('shop/media/elements/video-items', $data, true);
            }

            if($response_type == 'news'){
                echo $this->load->view('shop/news/elements/news_video_slider_items', $data, true);
            }
            die();
        }else{
            $this->load->view('shop/media/pages/media-video', $data);
        }
    }

    /**
     * home library links v2 page
     */
    public function media_links()
    {
        //check exist shop
        $this->_exist_shop();
        $this->set_layout('shop/media/custom-link-layout');
        $this->load->model('collection_model');
        $this->load->model('bookmark_model');
        $this->load->model('category_link_model');
        $this->load->model('link_model');
        $this->load->model('follow_model');
        $this->load->model('share_metatag_model');

        $shop                = $data['siteGlobal'] = $this->shop_current;
        $data['view_type']   = $this->_view_type();
        $data['user_login']  = MY_Loader::$static_data['hook_user'];
        $data['azibai_url']  = azibai_url();
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $data['url_item']    = $shop->shop_url;
        $data['aliasDomain'] = $shop->shop_url;
        $data['linktoshop']  = $linktoshop = substr($data['aliasDomain'], 0, -1);
        $data['categories']  = [];
        $data['follow']      = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']      = $shop->sho_id;
        $user_id             = (int)$this->session->userdata('sessionUser');
        $group_id            = (int)$this->session->userdata('sessionGroup');
        $owns_id             = $this->user_model->is_owner_shop($shop->sho_user);
        $data['is_owns']     = (boolean)$owns_id;

        $cat_ids = $this->link_model->get_category_ids_by_shop($shop->sho_id, $data['is_owns']);
        if(($cat_ids = array_to_array_keys($cat_ids, 'cate_link_id'))){
            $cat_parent = $this->category_link_model->get_category_parent_by_cat_ids($cat_ids);
            $cat_parent = array_unique(array_merge(array_to_array_keys($cat_parent, 'parent_id'), $cat_ids));
            $data['categories_parent'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0 AND id IN ('.implode( $cat_parent, ",").')',
                'orderby'   => 'id ASC',
                'type'      => 'array',
            ]);
            $data['categories_parent'] = $this->_get_bg_color($data['categories_parent']);
        }

        if($this->input->is_ajax_request()){
            $page   = (int)$this->input->post('page');
            $page   = $page < 2 ? 2 : $page;
            $index  = $page - 1;
            if(isset($data['categories_parent'][$index])){
                $cat_id = $data['categories_parent'][$index]['id'];
            }else{
                //het page
                die();
            }
        }

        if(!isset($page)){
            if(isset($data['categories_parent'][0]['id'])){
                $cat_id = $data['categories_parent'][0]['id'];
            }else{
                $cat_id = 1;
            }
        }

        if(!empty($data['categories_parent'])){
            $data['categories_parent'] = array_to_key_arrays($data['categories_parent'], 'id');
        }

        $data['links'] = $this->link_model->links_unique($shop->sho_id, 0, $cat_id, $data['is_owns']);
        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/library-links/shop-library-block-link', $data, true);
            die();
        }

        $data['links_new'] = $this->link_model->shop_gallery_list_link($shop->sho_id, 0, 0, 21, 0, $owns_id);
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        if(!empty($data['links_new']) && $data['links_new'][0]['image'] != ''){
            $ogimage = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data['links_new'][0]['image'];
        }

        //chu shop
        if($data['is_owns']){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
            $data['bookmarks']   = $this->bookmark_model->my_bookmarks($user_id);
        }

        //khach hang login
        if(!$data['is_owns'] && !empty($data['user_login'])){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
        }

        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.TYPESHARE_SHOP_LIBLINK);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user']           = $shop->sho_user;
        $data['type_share']         = TYPESHARE_SHOP_LIBLINK;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop . '/library/links';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = 'Thư viện liên kết của ' . $shop->sho_name;
        $data['ogimage']            = $ogimage;
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = $data['ogurl'];

        $this->load->view('shop/media/pages/library-link', $data);
    }

    /**
     * Show links by category
     *
     * @param string $slug
     */
    public function media_link_category($slug)
    {
        $slug = strip_tags(trim($slug));
        if(!$slug){
            exit();
        }
        $this->_exist_shop();
        $this->set_layout('shop/media/custom-link-layout');
        $this->load->model('collection_model');
        $this->load->model('bookmark_model');
        $this->load->model('category_link_model');
        $this->load->model('library_link_model');

        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $shop               = $data['siteGlobal'] = $this->shop_current;

        if($slug !== 'moi-nhat' && !($category_current = $this->category_link_model->get_category_by_slug($slug))){
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        $data['azibai_url']         = azibai_url();
        $data['server_media']       = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $data['slug']               = $slug;
        $user_id                    = (int)$this->session->userdata('sessionUser');
        $group_id                   = (int)$this->session->userdata('sessionGroup');
        $data['view_type']          = $this->_view_type();
        $data['aliasDomain']        = $shop->shop_url;
        $data['url_item']           = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;
        $owns_id                    = $this->user_model->is_owner_shop($shop->sho_user);
        $data['is_owns']            = (boolean)$owns_id;
        $data['follow']             = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']             = $shop->sho_id;
        $data['categories']         = [];
        $data['category_parent']    = [];
        $data['category_gb_color']  = '';
        $cat_ids                    = [];

        //slug != moi-nhat
        if(!empty($category_current)) {
            $data['category_current'] = $category_current;

            if ($category_current['parent_id']) {
                $data['category_child_selected'] = $category_current['id'];
                $data['category_parent']         = [
                    'id'   => $category_current['parent_id'],
                    'name' => $category_current['parent_name'],
                    'slug' => $category_current['parent_slug'],
                ];
            } else {
                $data['category_parent'] = $category_current;
            }

            $data['create_category_selected_default'] = $category_current['id'];
            $data['category_parent_selected']         = $data['category_parent']['id'];
        }

        //load menu
        $this->_get_menu_item_v2($data, $shop, $owns_id);

        if(!empty($category_current)){
            //nếu current category là parent thì lấy child, get item link => selected "danh mục tất cả"
            if((int)$data['category_current']['parent_id'] === 0 && !empty($data['categories_child'])){
                $cat_ids = array_to_array_keys($data['categories_child'], 'id');
            }
            $cat_ids[] = $data['category_current']['id'];
        }

        $data['items'] = $this->_get_library_links($shop->sho_id, $cat_ids, $owns_id);

        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/library-links/library-items', $data, true);
            die();
        }
        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        if(!empty($data['category_parent']) && !empty($data['categories'])){
            $data['category_parent']['class_bg_color'] = $this->_get_bg_color($data['categories'], $data['category_parent']['id']);
        }

        //chu shop
        if($data['is_owns']){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
        }

        //khach hang login
        if(!$data['is_owns'] && !empty($data['user_login'])){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
        }

        if($data['is_owns'] && $user_id){
            $data['bookmarks'] = $this->bookmark_model->my_bookmarks($user_id);
        }

        if($data['items'][0]['image']) {
            $ogimage = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data['items'][0]['image'];
        }else{
            $ogimage = $data['items'][0]['link_image'];
        }

        $type_share = TYPESHARE_SHOP_LIBLINKTAB;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $shop->shop_url .'library/links/'.$slug;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = 'Thư viện liên kết của '.$shop->sho_name;
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = 'library/links/' . ($slug === 'moi-nhat' ? 'moi-nhat' : $category_current['slug']);

        $this->load->view('shop/media/pages/media-category-link-v2', $data);
    }

    /**
     * Show detail link
     * @param $id
     * @param $type
     */
    public function library_link_detail($id, $type)
    {
        $this->_exist_shop();
        $this->set_layout('shop/media/custom-link-layout');
        $this->load->library('link_library');
        $this->load->model('category_link_model');
        $this->load->model('collection_model');

        $shop = $data['siteGlobal'] = $this->shop_current;
        $id = (int)$id;
        if(!$id || !$type || !($data['link'] = $this->link_library->exist_link($id, $type)) || $data['link']['sho_id'] != $shop->sho_id){
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $data['url_item']   = $shop->shop_url;
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $owns_id            = $this->user_model->is_owner_shop($shop->sho_user);
        $data['is_owns']    = (boolean)$owns_id;
        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']     = $shop->sho_id;
        $data['sho_user']   = $shop->sho_user;
        $data['page_current'] = 'detail';
        $user_id            = (int)$this->session->userdata('sessionUser');
        $group_id           = (int)$this->session->userdata('sessionGroup');

        if ($data['link']['cate_link_id']) {
            $category_current         = $this->category_link_model->get_category_by_id($data['link']['cate_link_id']);
            $data['link']['category_current'] = $category_current;
            if ($category_current['parent_id']) {
                $data['link']['category_parent'] = [
                    'id'   => $category_current['parent_id'],
                    'name' => $category_current['parent_name'],
                    'slug' => $category_current['parent_slug'],
                ];
            } else {
                $data['link']['category_parent'] = $category_current;
            }
        }

        //liên kết cùng bộ sưu tập
        $data['link']['links_collection'] = $this->link_library->links_same_collection($data['link']['id'], $type, $data['link']['sho_id'], $data['link']['user_id'], $data['is_owns']);

        //liên kết cùng danh mục
        $data['link']['links_category']   = $this->link_library->link_same_category($data['link']['cate_link_id'], $type, $data['link']['sho_id'], 0, $data['link']['id'], $data['is_owns']);

        //liên kết cùng tin
        if(!empty($data['link']['content_id'])){
            $data['link']['links_news']   = $this->link_library->link_of_news($data['link']['content_id'], '', $data['link']['sho_id'], 0, $data['link']['id'], $data['is_owns']);
        }

        if($data['is_owns']){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
        }

        if(!$data['is_owns'] && !empty($data['user_login'])){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
        }

        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        $ogimage = $data['link']['image'] ? $data['link']['image_url'] : $data['link']['link_image'];

        switch ($type) {
            case 'image-link':
                $type_share = TYPESHARE_DETAIL_SHOPLINK_IMG;
                $type_url = 'tbtt_content_image_links';
                break;
            
            case 'content-link':
                $type_share = TYPESHARE_DETAIL_SHOPLINK_CONTENT;
                $type_url = 'tbtt_content_links';
                break;
            
            case 'library-link':
                $type_share = TYPESHARE_DETAIL_SHOPLIBLINK;
                $type_url = 'tbtt_lib_links';
                break;
            
            default:
                $type_share = '';
                $type_url = '';
                break;
        }

        $this->load->model('like_link_model');
        $list_likes = $this->like_link_model->get('id', ['link_id' => (int) $data['link']['id'], 'tbl' => '"'.$type_url.'"']);
        $data['link']['likes'] = count($list_likes);

        $is_like = $this->like_link_model->get('id', ['user_id' => $user_id, 'link_id' => (int) $data['link']['id'], 'tbl' => '"'.$type_url.'"']);
        $data['link']['is_like'] = count($is_like);
        
        //Dem share
        $jData = json_decode($this->callAPI('GET', API_LISTSHARE_LINK.'/'.$data['link']['id'], []));
        $data['link']['total_share'] = $jData->data->total_share;
        
        if($type_share != ''){
            $this->load->model('share_metatag_model');
            $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
            if(!empty($get_avtShare)){
                $ogimage = $get_avtShare[0]->image;
            }
            $data['type_share'] = $type_share;
            $data['itemid_shr'] = $data['link']['id'];
        }
        $data['sho_user'] = $shop->sho_user;
        $data['ogimage'] = $ogimage;
        
        $data['type_link']  = $type;
        $data['avatar_owner_link']  = $shop->logo;
        $data['name_owner_link']    = $shop->sho_name;
        $data['aliasDomain']        = $shop->shop_url;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $shop->shop_url . $data['link']['short_url'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = str_replace('"', '', $data['link']['link_title']);
        $data['ogdescription']      = $data['link']['description'];
        $data['linktoshop']         = $shop->shop_url;
        $data['url_owner_link']     = $data['linktoshop'];
        $data['share_url']          = $data['ogurl'];
        $data['share_name']         = convert_percent_encoding($data['link']['link_title']);
        $data['color_icon']         = 'black';

        $this->load->view('shop/media/pages/media-link-detail-v2', $data);
    }

    /**
     * Get background color category parent
     *
     * @param $categories_parent
     * @return mixed
     */
    private function _get_bg_color($categories_parent, $specify_id = 0)
    {
        if(!empty($categories_parent)){
            foreach ($categories_parent as $key =>  $category) {
                if($key % 3 === 0){
                    $categories_parent[$key]['class_bg_color'] = 'bg-white';
                }
                if($key % 3 === 1){
                    $categories_parent[$key]['class_bg_color'] = 'bg-purple';
                }
                if($key % 3 === 2){
                    $categories_parent[$key]['class_bg_color'] = '';
                }
                if($specify_id && $category['id'] == $specify_id){
                    return $categories_parent[$key]['class_bg_color'];
                }
            }

        }
        return $categories_parent;
    }

    /**
     * @param $data
     * @param $shop
     * load menu item for shop
     * chỉ load những category có link trong đó
     */
    private function _get_menu_item_v2(&$data, $shop, $owner_id = 0)
    {
        $this->load->model('link_model');
        $cat_menu_ids = $this->link_model->get_category_ids_by_shop($shop->sho_id, 0, $owner_id);
        $cat_menu_ids = array_to_array_keys($cat_menu_ids, 'cate_link_id');

        if(!empty($cat_menu_ids)){

            $cat_parent = $this->category_link_model->get_category_parent_by_cat_ids($cat_menu_ids);

            if(!empty($cat_parent)){
                foreach ($cat_parent as $item) {
                    if(!in_array($item['parent_id'], $cat_menu_ids)){
                        $cat_menu_ids[] = $item['parent_id'];
                    }
                }
            }

            $data['categories'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0 AND id IN ('.implode($cat_menu_ids, ",").')',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        if(!empty($data['category_parent']) && !empty($cat_menu_ids)){
            $data['categories_child'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = '. $data['category_parent']['id'].' AND id IN ('.implode($cat_menu_ids, ",").')',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }
    }

    /**
     * @param $sho_id
     * @param $cat_ids
     * @param int $owner_id
     * @param array $options
     * @return array
     */
    private function _get_library_links($sho_id, $cat_ids, $owner_id = 0, $options = [])
    {
        if(empty($sho_id) && empty($cat_ids))
            return [];

        $this->load->model('link_model');
        $params = ['limit', 'page', 'start'];
        if(!empty($options)){
            foreach ($params as $param) {
                if(isset($options[$param])){
                    ${$param} = $options[$param];
                }
            }
        }

        if(!isset($page))
            $page = $this->input->post('page');

        if ($page < 1)
            $page = 1;

        if(!isset($limit))
            $limit = 10;

        $page = (int)$page;

        if(!isset($start))
            $start = ($limit * (int)$page) - $limit;

        return $this->link_model->shop_gallery_list_link($sho_id, 0, $cat_ids, $limit, $start, $owner_id);
    }

    /**
     * @param int $product_type
     * get product or coupon view gallery
     */
    public function media_products($product_type = PRODUCT_TYPE)
    {
        //check exist shop
        $this->_exist_shop();
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');

        if ($page < 1) {
            $page = 1;
        }

        // Số record trên một trang
        $limit = 10;

        $start = ($limit * $page) - $limit;

        // $users_shop = $this->user_model->get_all_user_shop_of_branch($shop->sho_user, 'string');
        $users_shop = $this->user_model->get_list_user_shop_and_branch($this->shop_current->sho_user, 'string');

        $data['products'] = $products = $this->product_model->products_gallery($users_shop, $product_type, $limit, $start);
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        if(!empty($products) && $products[0]->pro_name != ''){
            $imgurl = explode(',',$products[0]->pro_image)[0];
            $check_http = explode(':', $imgurl)[0];
            if($check_http == 'http' || $check_http == 'https'){
                $ogimage = $imgurl;
            }else{
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/product/' . $products[0]->pro_dir . '/' . $imgurl;
            }
        }

        $this->load->model('share_metatag_model');

        if($product_type == PRODUCT_TYPE){
            $type_share = TYPESHARE_SHOP_LIBPRODUCT;
        }else{
            $type_share = TYPESHARE_SHOP_LIBCOUPON;
        }
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        if($product_type == 0){
            $data['ogurl']              = $linktoshop.'/library/products';
            $data['ogdescription']      = 'Sản phẩm được bán trên '.$this->shop_current->sho_name;
        }else{
            $data['ogurl']              = $linktoshop.'/library/coupons';
            $data['ogdescription']      = 'Phiếu mua hàng được bán trên '.$this->shop_current->sho_name;
        }
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];
        
        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/product-items', $data, true);
            die();
        }else{
            $this->load->view('shop/media/pages/media-product', $data);
        }
    }

    public function media_vouchers()
    {
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;
        $data['top_loadding'] = true;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $page = 1;
        $limit = 20;
        $type = 0;
        $search = $product_type = $voucher_type = $price_from = $price_to = $time_start = $time_end = "";

        $temp = Api_affiliate::list_service_shop_get($page, $limit, $shop->sho_user, $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);

        // dd($temp['params']);die;
        $data = array_merge($data, $temp);

        $this->load->view('shop/media/pages/media-voucher', $data);
    }

    public function media_vouchers_type($type)
    {
        if(!in_array($type,[0,1])) {
            redirect(base_url(), 'location');
        }
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;
        $data['top_loadding'] = true;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $page = 1;
        if(@$_REQUEST["page"] > 1) {
            $page = $_REQUEST["page"];
        }
        $limit = 20;
        $type_params = $type === 0||$type === "0" ? "" : $type;
        $search = $product_type = $voucher_type = $price_from = $price_to = $time_start = $time_end = "";

        $temp = Api_affiliate::list_service_shop_get($page, $limit, $shop->sho_user, $type_params, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);

        //pagination
        $url_full = get_current_full_url();
        $process_url = parse_url($url_full);
        parse_str($process_url['query'], $params);
        if(isset($params['page'])) {
            unset($params['page']);
        }
        $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

        $config = $this->_config;
        $config['total_rows'] = $temp["pagination"]["total"];
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
        $data['pagination_html'] = $this->pagination->create_links();

        $data = array_merge($data, $temp);

        $this->load->view('shop/media/pages/media-voucher-type', $data);
    }

    public function media_vouchers_search()
    {
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;
        $data['top_loadding'] = true;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $page = 1;
        if(@$_REQUEST["page"] > 1) {
            $page = $_REQUEST["page"];
        }
        $limit = 20;
        $type = "";
        $search = @$_REQUEST["search"] ? $_REQUEST["search"] : "";
        $product_type = @$_REQUEST["product_type"] ? $_REQUEST["product_type"] : "";
        $voucher_type = @$_REQUEST["voucher_type"] ? $_REQUEST["voucher_type"] : "";
        $price_from = @$_REQUEST["price_from"] ? $_REQUEST["price_from"] : "";
        $price_to = @$_REQUEST["price_to"] ? $_REQUEST["price_to"] : "";
        $time_start = @$_REQUEST["time_start"] ? $_REQUEST["time_start"] : "";
        $time_end = @$_REQUEST["time_end"] ? $_REQUEST["time_end"] : "";

        $temp = Api_affiliate::list_service_shop_get($page, $limit, $shop->sho_user, $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);

        //pagination
        $url_full = get_current_full_url();
        $process_url = parse_url($url_full);
        parse_str($process_url['query'], $params);
        if(isset($params['page'])) {
            unset($params['page']);
        }
        $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

        $config = $this->_config;
        $config['total_rows'] = $temp["pagination"]["total"];
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
        $data['pagination_html'] = $this->pagination->create_links();

        $data = array_merge($data, $temp);

        $this->load->view('shop/media/pages/media-voucher-search', $data);
    }

    public function media_vouchers_show_product($voucher_id)
    {
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $data['follow']     = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id'] = $shop->sho_id;

        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;
        $data['top_loadding'] = true;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        $page = 1;
        $limit = 20;
        $search = '';
        if($this->input->is_ajax_request()) {
            $page = $_REQUEST['page'];
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $user_id, $page, $limit, $search);
            $html = '';
            foreach ($data['list_product']['data'] as $key => $item) {
                $html .= $this->load->view('shop/media/elements/voucher-item-show-product', ['item'=>$item], TRUE);
            }
            echo $html;die;
        } else {
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $shop->sho_user, $page, $limit, $search);
        }

        $this->load->view('shop/media/pages/media-voucher-show-product', $data);
    }

    /**
     * @param int $type_view
     * get product || coupon || link || video view gallery
     * @param int $node_id
     * get id node will be selected and showed on view
     */
    public function media_view_node($type_view = LINK_TYPE, $node_id = 0)
    {
        if($node_id < 1) {
            redirect(base_url(), 'location');
            die();
        }

        //check exist shop
        $this->_exist_shop();
        // $data['view_type'] = $this->_view_type();
        $shop = $data['siteGlobal'] = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        // $product_type = (int)$product_type;
        $data['is_owns'] = $shop->sho_user == $user_id;

        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }
        $data['type_view'] = $type_view;

        switch ($type_view) {
            case CUSTOMLINK_CONTENT :
                $node_view = $this->customlink_model->find_where(["type" => CUSTOMLINK_CONTENT, 'tbtt_custom_link.id' => $node_id], [
                    'select'        => 'tbtt_custom_link.*, tbtt_content.not_title, tbtt_content.not_id',
                    'limit' => 1,
                    'joins'         => [
                        [
                            'table'     => 'tbtt_content',
                            'where'     => 'tbtt_custom_link.type_id = tbtt_content.not_id AND tbtt_custom_link.type = "'.CUSTOMLINK_CONTENT.'"',
                            'type_join' => 'LEFT'
                        ],
                    ],
                    'orderby'       => 'tbtt_custom_link.id DESC',
                ], 'object');
                $data['node_view'] = $node_view;
                if(!empty($node_view)){
                    $data['list_node_views'] = $this->customlink_model->get('*',"type = 'content' AND type_id = $node_view->type_id AND id != $node_id");
                }
                $this->load->view('shop/media/viewnode-media-layout', $data);
                break;

            case PRODUCT_TYPE :
                # code...
                break;

            case COUPON_TYPE :
                # code...
                break;
            default:
                redirect(base_url(), 'location');
                break;
        }
    }

    public function create_album_media()
    {
        $a = $this->session->all_userdata();

        $srcImg = $this->input->post('srcImg');
        $album_name = $this->input->post('album_name');

        $filepath = '/public_html/media/images/album/';
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port'] = PORT_CLOUDSERVER;
        $config['debug'] = false;
        $this->ftp->connect($config);

        #Create folder
        $pathImage = 'media/images/album/';
        $path = '/public_html/media/images/album';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir = date('dmY');

        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);

        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (!in_array($dir, $ldir)) {
            $this->ftp->mkdir($path . '/' . $dir, 0775);
        }

        if (!is_dir($pathImage . $dir_image)) {
            @mkdir($pathImage . $dir_image, 0775);
            $this->load->helper('file');
            @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
        }

        $sCustomerImageName = uniqid() . time() . uniqid();
        $type_image = $this->convertStringToImageFtp($sCustomerImageName,'media/images/album/'.$dir_image.'/',$srcImg);

        $cus_avatar = $sCustomerImageName.'.'.$type_image;

        if (file_exists($pathImage . $dir_image . '/' . $cus_avatar)) {
            if($this->ftp->upload($pathImage . $dir_image . '/' . $cus_avatar, $path . '/' . $dir .'/' . IMAGE_1X1 . $cus_avatar, 'auto', 0775)){
                // $data = array(
                //     'name' => $nameCollection,
                //     'user_id' => $this->session->userdata('sessionUser'),
                //     'avatar' => DOMAIN_CLOUDSERVER . 'media/images/content/' . $dir .'/'. IMAGE_1X1 . $cus_avatar,
                //     'status' => 1,
                //     'isPublic' => $isPublic, // 1: public 0: private
                //     'type'  => $type,
                // );
                // $this->collection_model->add_c($data);
                echo "1";die;
            } else {
                echo "0";die;
            }
        } else {
            echo "0";die;
        }
    }

    private function _exist_shop($data_check = '')
    {
        $shop = @$this->shop_current;
        if($data_check){
            //domain or sho_link
            if(is_string($data_check)){
                $shop = $this->shop_model->get('*', '(sho_link = "' . $data_check. '" OR domain = "' . $data_check. '") AND sho_status = 1 ');
            }
            //id
            if(is_numeric($data_check)){
                $shop = $this->shop_model->get('*', 'sho_id = "' . $data_check. '" AND sho_status = 1"');
            }
        }

        if (empty($shop) || !$shop->sho_status) {
            redirect($this->mainURL . 'page-not-found');
            die;
        }
    }

    /**
     * @param string $view_default
     * @return mixed|string
     * replace $_GET // $_GET is turn off
     */
    private function _view_type($view_default = 'grid')
    {
        $list_view = [
            'grid'      => 'grid',
            'list'      => 'list',
            'line'      => 'line',
        ];
        $view1 = !empty($_REQUEST['view']) ? $_REQUEST['view'] : $view_default;
        $view1 = trim(strip_tags($view1));
        if(in_array($view1, $list_view)){
            return $view1;
        }
        return false;
    }

    // Build new Sub-domain/shop
    public function myshop_builded($type = 'shop')
    {

        $types = ['shop', 'product', 'coupon', 'affiliate-shop', 'voucher'];
        if(!in_array($type,$types)){
            redirect(base_url(), 'location');
            die();
        }
        $detect_process = $type;
        $data['detect_process'] = $detect_process;
        if($this->session->userdata('sessionUser') > 0){
            $data['myshop'] = $this->shop_model->get("sho_user, sho_name, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_link, domain", "sho_user = " . $this->session->userdata('sessionUser'));
        }
        $shop = $this->shop_current;
        $this->load->model('share_metatag_model');

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = $shop->sho_descr;
        $data['linktoshop']         = $linktoshop;

        $follow = 0;
        $this->load->model('follow_shop_model');
        $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$shop->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFollow))
        {
            if($getFollow[0]->hasFollow == 1){
                $follow = 1;
            }
        }
        $data['follow'] = $follow;
        $data['sho_id'] = $shop->sho_id;
        //view + process data loaded
        $ogurl              = $linktoshop;
        switch ($detect_process) {
            //shop
            case 'shop':
                $type_share = TYPESHARE_SHOP_PAGESHOP;
                $ogurl              = $linktoshop.'/shop';
                $this->__process_shop($detect_process);
                break;

            case 'product':
            case 'coupon':
                if($detect_process == 'product')
                    $type_share = TYPESHARE_SHOP_ALLPRODUCT;
                else{
                    $type_share = TYPESHARE_SHOP_ALLCOUPON;
                }
                // echo 'This feature will be coming soon!!!';die;
                $ogurl              = $linktoshop.'/shop/'.$detect_process;
                $this->__process_shop_slash($detect_process);
                break;
            //affiliate
            case 'affiliate-shop':
                // echo 'This feature will be coming soon!!!';die;
                $ogurl              = $linktoshop.'/shop/'.$detect_process;
                $this->__process_shop($detect_process);
                break;
            case 'voucher':
                $type_share = TYPESHARE_SHOP_ALLPRODUCT;
                $ogurl              = $linktoshop.'/shop/'.$detect_process;
                // $this->__process_shop_voucher();
                die('1');
        }

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }

        $data['sho_user']         = $shop->sho_user;
        $data['type_share']         = $type_share;
        $data['ogimage']            = $ogimage;

        $data['ogurl'] = $ogurl;
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];

        $this->load->view('shop/shop/main-layout',$data);
    }

    public function __process_shop($typeShop)
    {

        $data['is_owner'] = false;
        $user_id = $this->session->userData('sessionUser');
        if($user_id > 0){
            $data['is_owner'] = $this->shop_current->sho_user == $user_id ? true : false;
            $data['user_detail'] = $this->user_model->generalInfo($user_id);
        }

        if($this->shop_current->group_user == AffiliateStoreUser) {
            $list_user = $this->user_model->get_list_user_shop_and_branch($this->shop_current->sho_user, 'string');
        } else if($this->shop_current->group_user == BranchUser) {
            $parent_user_id = $this->user_model->get("*","use_id = {$this->shop_current->sho_user}")->parent_id;
            $list_user = $this->shop_current->sho_user .",".$parent_user_id;
        }
        $pro_ids_shared = $this->db->query("SELECT pro_id FROM tbtt_send_product WHERE user_shop_id IN ({$list_user}) AND status = 1")->result();
        $temp = [];
        foreach ($pro_ids_shared as $key => $value) {
            array_push($temp, $value->pro_id);
        }
        $pro_ids_shared = implode(',', $temp);

        $select = ['tbtt_product.pro_id','pro_category','pro_name','pro_descr','pro_cost','pro_currency','pro_image','pro_dir','pro_saleoff','pro_saleoff_value','pro_type_saleoff', 'begin_date_sale', 'end_date_sale','pro_minsale','pro_user',
            'is_product_affiliate', 'af_amt', 'af_rate', 'af_dc_amt', 'af_dc_rate',
            'dp.id as dp_id', 'dp.dp_images','dp.dp_cost', 'apply', 
        'tbtt_shop.sho_logo', 'tbtt_shop.sho_dir_logo'];
        $where_mix1 = "pro_user IN ({$this->shop_current->sho_user})";
        if(!empty($pro_ids_shared)) {
            $where_mix1 = "(pro_user IN ({$this->shop_current->sho_user}) OR pro_id IN ({$pro_ids_shared}))";
        }
        $where = [
            //logic của Tính
            'product_new'   => $where_mix1 . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 0 OR ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() < begin_date_sale OR UNIX_TIMESTAMP() > end_date_sale) ) )',
            'product_sale'  => $where_mix1 . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale) )',
            'coupon_new'    => $where_mix1 . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 0 OR ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() < begin_date_sale OR UNIX_TIMESTAMP() > end_date_sale) ) )',
            'coupon_sale'   => $where_mix1 . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale) )',
        ];
        $join = 'LEFT';
        $table = '(SELECT MIN(id) as id, dp_images, dp_cost, dp_pro_id
                    FROM tbtt_detail_product
                    GROUP BY dp_pro_id) dp';
        $on = 'dp.dp_pro_id = pro_id';

        // Affiliate shop - lấy tất cả sản phẩm cho cộng tác viên bán
        if($typeShop != 'shop' && $typeShop == 'affiliate-shop'){
            $join2 = 'INNER';
            $table2 = 'tbtt_product_affiliate_user pro_af';
            $on2 = 'pro_af.pro_id = tbtt_product.pro_id';
            foreach ($where as $key => $value) {
                $where[$key] .= ' AND is_product_affiliate = 1';
            }
            $data['for_shop_af'] = true;
        }

        $limit = 20;
        $start = 0;
        $order = 'created_date, pro_id';
        $by = 'DESC';
        $distinct = false;
        $group_by = NULL;

        $join3 = 'LEFT';
        $table3 = 'tbtt_shop';
        $on3 = 'tbtt_shop.sho_user = tbtt_product.pro_user';

        //product
        $product_new = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_new'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
        $product_sale = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_sale'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
        //coupon
        $coupon_new = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_new'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
        $coupon_sale = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_sale'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
        // get all
        // $data['shop_new_items'] = $this->product_model->fetch($select, $where['shop_new_items'], $order, $by, $start, $limit);
        // $data['shop_fs_items'] = $this->product_model->fetch($select, $where['shop_fs_items'], $order, $by, $start, $limit);
        // detail category

        $data_walk = ['product_new'=>$product_new,
            'product_sale'=>$product_sale,
            'coupon_new'=>$coupon_new,
            'coupon_sale'=>$coupon_sale
        ];
        array_walk($data_walk, function($value, $key){
            array_walk($value, function($v, $k){
                if($v->dp_id > 0){
                    $v->pro_cost = $v->dp_cost;
                    $v->pro_image = $v->dp_images;
                }
            });
        });

        // if($this->session->userdata('sessionUser')){
            $this->load->model('like_product_model');
            if(count($data_walk['product_new']) > 0){
                foreach ($data_walk['product_new'] as $key => $value) {
                    if($this->session->userdata('sessionUser')){
                        $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                        $value->is_like = count($is_like);
                    }
                    $dataHH = $this->dataGetHH($value);
                    $value->hoahong = $this->checkHH($dataHH);
                    $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                }
            }
            if(count($data_walk['product_sale']) > 0){
                foreach ($data_walk['product_sale'] as $key => $value) {
                    if($this->session->userdata('sessionUser')){
                        $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                        $value->is_like = count($is_like);
                    }
                    $dataHH = $this->dataGetHH($value);
                    $value->hoahong = $this->checkHH($dataHH);
                    $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                }
            }
            if(count($data_walk['coupon_new']) > 0){
                foreach ($data_walk['coupon_new'] as $key => $value) {
                    if($this->session->userdata('sessionUser')){
                        $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                        $value->is_like = count($is_like);
                    }
                    $dataHH = $this->dataGetHH($value);
                    $value->hoahong = $this->checkHH($dataHH);
                    $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                }
            }
            if(count($data_walk['coupon_sale']) > 0){
                foreach ($data_walk['coupon_sale'] as $key => $value) {
                    if($this->session->userdata('sessionUser')){
                        $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                        $value->is_like = count($is_like);
                    }
                    $dataHH = $this->dataGetHH($value);
                    $value->hoahong = $this->checkHH($dataHH);
                    $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                }
            }
        // }

        // load collection
        $collection_product = $this->collection_model->fetch_c('*', "user_id = " . $this->shop_current->sho_user. " AND status = 1 AND isPublic = 1 AND `type` = ".COLLECTION_PRODUCT , 'created_at', 'DESC', '', '', '');
        $collection_coupon = $this->collection_model->fetch_c('*', "user_id = " . $this->shop_current->sho_user. " AND status = 1 AND isPublic = 1 AND `type` = ".COLLECTION_COUPON , 'created_at', 'DESC', '', '', '');

        $data['collection_product'] = $collection_product;
        $data['collection_coupon'] = $collection_coupon;
        $data['product_new'] = $data_walk['product_new'];
        $data['product_sale'] = $data_walk['product_sale'];
        $data['coupon_new'] = $data_walk['coupon_new'];
        $data['coupon_sale'] = $data_walk['coupon_sale'];
        $data['detail_cateShop'] = $this->category_model->get("*", "cat_id = " . $this->shop_current->sho_category);
        // dd($data);
        // dd($this->shop_current);
        // dd($this->mainURL);
        // dd($this->shop_url);
        // die;

        $this->load->vars($data);
    }

    public function __process_shop_slash($detect_process)
    {
        $data['is_owner'] = false;
        $user_id = $this->session->userData('sessionUser');
        if($user_id > 0){
            $data['is_owner'] = $this->shop_current->sho_user == $user_id ? true : false;
            $data['user_detail'] = $this->user_model->generalInfo($user_id);
        }

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $select = ['tbtt_product.pro_id','pro_type','pro_category','pro_name','pro_descr','pro_cost','pro_currency','pro_image','pro_dir','pro_saleoff','pro_saleoff_value','pro_type_saleoff','end_date_sale','pro_minsale','pro_user',
            'is_product_affiliate', 'af_amt', 'af_rate', 'af_dc_amt', 'af_dc_rate',
            'dp.id as dp_id', 'dp.dp_images','dp.dp_cost',
        'tbtt_shop.sho_logo', 'tbtt_shop.sho_dir_logo, apply'];

        if($this->shop_current->group_user == AffiliateStoreUser) {
            $list_user = $this->user_model->get_list_user_shop_and_branch($this->shop_current->sho_user, 'string');
        } else if($this->shop_current->group_user == BranchUser) {
            $parent_user_id = $this->user_model->get("*","use_id = {$this->shop_current->sho_user}")->parent_id;
            $list_user = $this->shop_current->sho_user .",".$parent_user_id;
        }
        $pro_ids_shared = $this->db->query("SELECT pro_id FROM tbtt_send_product WHERE user_shop_id IN ({$list_user}) AND status = 1")->result();
        $temp = [];
        foreach ($pro_ids_shared as $key => $value) {
            array_push($temp, $value->pro_id);
        }
        $pro_ids_shared = implode(',', $temp);

        $where_mix1 = "pro_user IN ({$this->shop_current->sho_user})";
        if(!empty($pro_ids_shared)) {
            $where_mix1 = "(pro_user IN ({$this->shop_current->sho_user}) OR pro_id IN ({$pro_ids_shared}))";
        }
        $where = [
            // 'product_items'   => 'pro_user IN ('. $list_user . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 0 OR (pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)) )',
            // 'coupon_items'    => 'pro_user IN ('. $list_user . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 0 OR (pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)) )',
            'product_items'   => $where_mix1 . ' AND pro_status = 1 AND pro_type = 0',
            'coupon_items'    => $where_mix1 . ' AND pro_status = 1 AND pro_type = 2',
        ];
        $join = 'LEFT';
        $table = '(SELECT MIN(id) as id, dp_images, dp_cost, dp_pro_id
                    FROM tbtt_detail_product
                    GROUP BY dp_pro_id) dp';
        $on = 'dp.dp_pro_id = pro_id';

        // Affiliate shop - lấy tất cả sản phẩm cho cộng tác viên bán
        if($this->uri->segment(1) != 'shop' && $this->uri->segment(1) == 'affiliate-shop'){
            $join2 = 'INNER';
            $table2 = 'tbtt_product_affiliate_user pro_af';
            $on2 = 'pro_af.pro_id = tbtt_product.pro_id';
            foreach ($where as $key => $value) {
                $where[$key] .= ' AND is_product_affiliate = 1';
            }
        }
        $limit = 10;
        $start = ($page - 1) * $limit;
        $order = 'created_date';
        $by = 'DESC';
        $distinct = false;
        $group_by = NULL;

        $join3 = 'LEFT';
        $table3 = 'tbtt_shop';
        $on3 = 'tbtt_shop.sho_user = tbtt_product.pro_user';

        //lấy giá điều kiện filter từ ajax post
        $filter = $this->input->post('filter');
        $this->input->post('filter') === "true" ? $filter = true : $filter = false;
        $this->input->post('filter') === "false" ? $filter = false : $filter = true;

        $filter_sort = $this->input->post('sort');
        switch ($filter_sort) {
            case 'sort-new':
                $order = 'created_date';
                $by = 'DESC';
                break;
            case 'sort-old':
                $order = 'created_date';
                $by = 'ASC';
                break;
            case 'sort-asc':
                $order = 'created_date';
                $by = 'ASC';
                break;
            case 'sort-desc':
                $order = 'created_date';
                $by = 'DESC';
                break;
            case 'sort-az':
                $order = 'pro_name';
                $by = 'ASC';
                break;
            case 'sort-za':
                $order = 'pro_name';
                $by = 'DESC';
                break;
        }

        //filter config
        if($this->input->is_ajax_request() && $filter == true) {

            $decreased = $this->input->post('decreased');
            $price_from = $this->input->post('price_from');
            $price_to = $this->input->post('price_to');
            if($detect_process == 'product'){
                $type_sp = 0;
            }
            if($detect_process == 'coupon'){
                $type_sp = 2;
            }

            //create/replace view product status = 1 has or not TQC
            $query_string = "(SELECT tbtt_product.pro_id, pro_type, pro_user, pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, COALESCE(id, 0) AS dp_id, dp_images, dp_cost
                            FROM tbtt_product
                            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = pro_id
                            WHERE pro_status = 1 AND pro_user = ". $this->shop_current->sho_user ."
                            GROUP BY pro_id, dp_pro_id
                            ORDER BY created_date DESC) pro_filter";

            //Query string
            $select_filter = 'pro_id, pro_category, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, end_date_sale, pro_minsale,
                                    dp_id, dp_images, dp_cost,
                                    IF(pro_type_saleoff = 1, pro_saleoff_value, round((pro_saleoff_value/pro_cost *100)) ) as percentage,
                                    IF(dp_id = 0, pro_cost, dp_cost ) as price_filter';
            $from_filter = $query_string;
            $where_filter = 'pro_type = '.$type_sp;
            $having_filter = 'percentage >= ' . $decreased;

            // sản phẩm có giảm giá -> filter giảm theo %
            if($decreased > 0) {
                $where_filter .= ' AND pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)';
            }
            if($decreased == 0){
                //tất cả sản phẩm + sản phẩm sale
                // $where_filter .= ' AND ( pro_saleoff = 0 OR (pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)) )';
            }

            // sản phẩm có giá trong khoản
            if($price_from == 0 && $price_to > 0) {// từ 0 -> price
                $having_filter .= " AND ( price_filter BETWEEN $price_from AND $price_to )";
            }
            if($price_from > 0 && $price_to > 0) {// từ from -> to
                $having_filter .= " AND ( price_filter BETWEEN $price_from AND $price_to )";
            }
            if($price_from > 0 && $price_to == 0) {// từ from -> infinity
                $having_filter .= " AND ( price_filter >= $price_from )";
            }
            if($price_from == 0 && $price_to == 0) {// all
                // tất cả giá
            }

            // ajax item to view
            $items = $this->db->query("SELECT $select_filter FROM $from_filter WHERE $where_filter HAVING $having_filter ORDER BY $order $by LIMIT $limit OFFSET $start")->result();
            foreach ($items as $k => $v) {
                if($v->end_date_sale > 0 && strtotime('now') < $v->end_date_sale && $v->pro_saleoff){
                    $items[$k]->is_selling = true;
                }else{
                    $items[$k]->is_selling = false;
                }
            }
            $total = count($this->db->query("SELECT $select_filter FROM $from_filter WHERE $where_filter HAVING $having_filter ORDER BY $order $by")->result());

            $html = "";
            foreach ($items as $key => $value) {
                $dataHH = $this->dataGetHH($value);
                $value->hoahong = $this->checkHH($dataHH);
                $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                $html .= $this->load->view('shop/shop/ajax_html/item-shop-slash-pro-coup', ['item'=>$value,'index_item'=>($start+$key)], true);
            }

            echo json_encode(["html" => $html, "total" => $total]);
            die();
        }

        // chỉ chạy trong lần đầu tiên load view + load more item bằng ajax(chưa lần nào filter)
        //process get data
        switch ($detect_process) {
            case 'product':
                $items = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_items'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
                foreach ($items as $k => $v) {
                    if($v->dp_id > 0){
                        $items[$k]->pro_cost = $v->dp_cost;
                        $items[$k]->pro_image = $v->dp_images;
                    }
                    if($v->end_date_sale > 0 && strtotime('now') < $v->end_date_sale && $v->pro_saleoff){
                        $items[$k]->is_selling = true;
                    }else{
                        $items[$k]->is_selling = false;
                    }
                    $items[$k]->index_item = $start+$k;

                    $dataHH = $this->dataGetHH($v);
                    $v->hoahong = $this->checkHH($dataHH);
                    $v->Shopname = $this->get_InfoShop($v->pro_user, 'sho_name')->sho_name;
                }
                $total = count($this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_items'], $order, $by, $start = -1, $limit, $distinct, $group_by, $join3, $table3, $on3));
                if($this->session->userdata('sessionUser')){
                    $this->load->model('like_product_model');
                    if(count($items) > 0){
                        foreach ($items as $key => $value) {
                            $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                            $value->is_like = count($is_like);
                        }
                    }
                }

                break;
            case 'coupon':
                $items = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_items'], $order, $by, $start, $limit, $distinct, $group_by, $join3, $table3, $on3);
                foreach ($items as $k => $v) {
                    if($v->dp_id > 0){
                        $items[$k]->pro_cost = $v->dp_cost;
                        $items[$k]->pro_image = $v->dp_images;
                    }
                    if($v->end_date_sale > 0 && strtotime('now') < $v->end_date_sale && $v->pro_saleoff){
                        $items[$k]->is_selling = true;
                    }else{
                        $items[$k]->is_selling = false;
                    }
                    $items[$k]->index_item = $start+$k;

                    $dataHH = $this->dataGetHH($v);
                    $v->hoahong = $this->checkHH($dataHH);
                    $v->Shopname = $this->get_InfoShop($v->pro_user, 'sho_name')->sho_name;
                }
                $total = count($this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_items'], $order, $by, $start = -1, $limit, $distinct, $group_by, $join3, $table3, $on3));
                if($this->session->userdata('sessionUser')){
                    $this->load->model('like_product_model');
                    if(count($items) > 0){
                        foreach ($items as $key => $value) {
                            $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                            $value->is_like = count($is_like);
                        }
                    }
                }
                break;
        }
        // END lần chạy trong lần đầu tiên load view + load more item bằng ajax

        // show more
        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($items as $key => $value) {
                $dataHH = $this->dataGetHH($value);
                $value->hoahong = $this->checkHH($dataHH);
                $value->Shopname = $this->get_InfoShop($value->pro_user, 'sho_name')->sho_name;
                $html .= $this->load->view('shop/shop/ajax_html/item-shop-slash-pro-coup', ['item'=>$value,'index_item'=>($start+$key)], true);
            }
            echo $html;
            die();
        } else { // load data to view
            $data['items'] = $items;
            $data['total'] = $total;
            $this->load->vars($data);
        }
    }

    // ------------------------------------------------------------------------
    // ------------------------------------------------------------------------
    // -------------********************************************---------------
    // -------------********************************************---------------
    // -------------*****************COLLECTION*****************---------------
    // -------------********************************************---------------
    // -------------********************************************---------------
    // ------------------------------------------------------------------------
    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    // version 2
    // ------------------------------------------------------------------------
    public function collection_link_v2()
    {
        // include api
        $this->load->file(APPPATH.'controllers/home/api_collection.php', false);
        // end

        //check exist shop
        $this->_exist_shop();
        $shop                       = $data['siteGlobal'] = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;
        $data['follow']             = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']           = $shop->sho_id;
        $data['page_view']          = 'image-page';
        $user_id                    = (int)$this->session->userdata('sessionUser');
        $group_id                   = $this->session->userdata('sessionGroup');
        $data['is_owns']            = $shop->sho_user == $user_id;
        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }
        $data['sho_user']           = $shop->sho_user;

        // get data category collection link
        $url = $this->config->item('api_category_link_get');
        $link_categories = json_decode($this->callAPI('GET', $url, '', $rent_header), true)['data'];
        $temp = $temp_parent = $temp_child = array();
        foreach ($link_categories as $key => $value) {
            $temp[$value['id']] = $value;
            if($value['parent_id'] == 0) {
                $temp_parent[$value['id']] = $value;
            } else {
                $temp_child[$value['id']] = $value;
            }
        }
        $data['link_categories'] = $temp;
        $data['link_categories_p'] = $temp_parent;
        $data['link_categories_ch'] = $temp_child;

        if($this->input->is_ajax_request()) {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Credentials: true");
            header('Content-Type: application/json; charset=utf-8');
            header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
            header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
            // get data
            $last_id = $this->input->post('last_id') ? $this->input->post('last_id') : 0;
            $make_call = Api_collection::get_data_collection_link($shop->sho_user, $last_id);
            $make_call = json_decode($make_call, true);

            $items = $make_call['data']['data'];

            $html = '';
            foreach ($items as $key => $item) {
                $html .= $this->load->view('shop/collection-ver2/element/item-collection-link', ['item' => $item, 'link_categories' => $data['link_categories']], TRUE);
            }
            $last_id = end($items)['id'];
            echo json_encode(['html'=>$html, 'last_id'=>$last_id]);
            die;
        } else {
            $make_call = Api_collection::get_data_collection_link($shop->sho_user, 0);
            $make_call = json_decode($make_call, true);

            $data['items'] = $make_call['data']['data'];
            $data['is_next'] = $make_call['data']['next'];

            $this->set_layout('shop/collection-ver2/collection-layout');
            $this->load->view('shop/collection-ver2/page/page-collection-link', $data, FALSE);
        }
    }

    public function collection_link_detail_v2($collection_id)
    {
        // include api
        $this->load->file(APPPATH.'controllers/home/api_collection.php', false);
        // end

        //check exist shop
        $this->_exist_shop();
        $shop                       = $data['siteGlobal'] = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;
        $data['follow']             = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']           = $shop->sho_id;
        $data['page_view']          = 'image-page';
        $user_id                    = (int)$this->session->userdata('sessionUser');
        $group_id                   = $this->session->userdata('sessionGroup');
        $data['is_owns']            = $shop->sho_user == $user_id;
        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }
        $data['sho_user']           = $shop->sho_user;

        if($this->input->is_ajax_request()) {
            // // get data
            $last_created_at = $this->input->post('last_created_at') ? $this->input->post('last_created_at') : 0;
            $make_call = Api_collection::get_data_detail_collection_link($shop->sho_user, $collection_id, $last_created_at);
            $make_call = json_decode($make_call, true);

            $items = $make_call['data']['data'];

            $html = '';
            foreach ($items as $key => $item) {
                $html .= $this->load->view('shop/collection-ver2/element/item-collection-link-detail', ['item' => $item], TRUE);
            }
            $last_created_at = end($items)['created_at'];
            echo json_encode(['html'=>$html, 'last_created_at'=>$last_created_at]);
            die;
        } else {
            // get data category collection link
            $url = $this->config->item('api_category_link_get');
            $link_categories = json_decode($this->callAPI('GET', $url, '', $rent_header), true)['data'];
            $temp = $temp_parent = $temp_child = array();
            foreach ($link_categories as $key => $value) {
                $temp[$value['id']] = $value;
                if($value['parent_id'] == 0) {
                    $temp_parent[$value['id']] = $value;
                } else {
                    $temp_child[$value['id']] = $value;
                }
            }
            $data['link_categories'] = $temp;
            $data['link_categories_p'] = $temp_parent;
            $data['link_categories_ch'] = $temp_child;

            // get data detail collection link
            $make_call = Api_collection::get_data_detail_collection_link($shop->sho_user, $collection_id);

            $data['items'] = $make_call['links'];
            $data['collection'] = $make_call['collection'];
            $data['popup_list_collection'] = Api_collection::get_data_mini_collection_link();
            // dd($data['popup_list_collection']);die;
            $data['collection']['total'] = $make_call['total'] ? $make_call['total'] : 0;
            $data['like'] = $make_call['liked'] ? $make_call['liked'] : 0;
            $data['share'] = $make_call['count_shares'] ? $make_call['count_shares'] : 0;
            $data['comment'] = $make_call['count_comments'] ? $make_call['count_comments'] : 0;
            $data['is_next'] = $make_call['next'];
            $data['has_black_version'] = true;

            $this->set_layout('shop/collection-ver2/collection-layout');
            $this->load->view('shop/collection-ver2/page/page-collection-link-detail.php', $data, FALSE);
        }
    }







    

    public function showCollectionAll()
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        $select = 'cc_coll_id, b.name, a.not_id, a.not_title, a.not_image, a.not_dir_image';
        $from = 'tbtt_collection_content';
        $where = "cc_user_id = $uid";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_content a', 'on' => 'a.not_id = cc_not_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cc_coll_id', 'option' => 'left')
        );
        $order = 'cc_coll_id';
        $by = 'DESC';
        $start = -1;
        $limit = 10;
        $distinct = false;
        $collection_content = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        $data['collection_content'] = $collection_content;
        //processing data
        $process_data = array();
        foreach ($data['collection_content'] as $key => $value) {
            $temp = (array)$value;
            foreach ($data['collection_content'] as $k => $v) {
                if ($v->not_id == $value->not_id && $key != $k) {
                    $temp = array_merge_recursive($temp, (array)$v);
                }

            }
            if (count($temp['not_id']) > 1) {
                $temp['not_id'] = implode(',', array_unique($temp['not_id']));
                $temp['not_title'] = implode(',', array_unique($temp['not_title']));
                $temp['not_image'] = implode(',', array_unique($temp['not_image']));
                $temp['not_dir_image'] = implode(',', array_unique($temp['not_dir_image']));
            }
            $process_data[$value->not_id] = (object)$temp;
        }

        //End processed data
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($collection_content)){
            $ogimage = $collection_content[0]->avatar;
            $ogtitle = $collection_content[0]->name;
        }
        
        $data['ogdescription'] = 'Tất cả bộ sưu tập của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogimage']            = $ogimage;
        $data['ogurl']              = base_url().'shop/collection/all';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection_content'] = $process_data;
        $data['total'] = count($data['collection_content']);
        $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid'] = $uid;
        # Load view
        $this->load->view('shop/collection/collection', $data);
    }

    public function showCollection()
    {
        $data['siteGlobal'] = $shop = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;

        $follow = 0;
        $this->load->model('follow_shop_model');
        $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$shop->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFollow))
        {
            if($getFollow[0]->hasFollow == 1){
                $follow = 1;
            }
        }
        $data['follow'] = $follow;
        $data['sho_id'] = $shop->sho_id;
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------
        $user_id = $uid;
        $select = 'cc_coll_id, b.name, a.not_id, a.not_title, a.not_image, a.not_dir_image';
        $from = 'tbtt_collection_content';
        $where = "cc_user_id = $user_id";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join     = array(
            array('table' => 'tbtt_content a', 'on' => 'a.not_id = cc_not_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cc_coll_id', 'option' => 'left')
        );
        $order    = 'a.not_id';
        $by       = 'DESC';
        $start    = -1;
        $limit    = 4;
        $distinct = false;
        $collection_content = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        // ------------------------------------------------------------------------
        $where = "user_id = $user_id AND type = 1";
        if ($is_owner == false) {
            $where .= ' AND status = 1 AND isPublic = 1';
        }
        $collection = $this->collection_model->fetch_c('*', $where, 'created_at', 'DESC', '', '', '');
        // ------------------------------------------------------------------------
        // -process data-----------------------------------------------------------

        foreach ($collection as $key => $value) {
            foreach ($collection_content as $k => $v) {
                if (count($collection[$key]->content) < 4 && $value->id == $v->cc_coll_id) {
                    if (filter_var($v->not_image, FILTER_VALIDATE_URL)) { 
                        $v->image = $v->not_image;
                    } else {
                        $v->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $v->not_dir_image . '/'. IMAGE_1X1 . $v->not_image;
                    }

                    $collection[$key]->content[] = $v;
                }
            }
            $collection[$key]->total = $this->collection_model->get_cc('count("*") as total', 'cc_coll_id = ' . $value->id)->total;

            // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

            // } else {
            //     $collection[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
            // }

        }
        // - end process data-------------------------------------------------------

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($collection)){
            $ogimage = $collection[0]->avatar;
            $ogtitle = $collection[0]->name;
        }
        
        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_SHOP_COLLECTNEWS;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogdescription'] = 'Bộ sưu tập tin của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogurl']              = base_url().'shop/collection';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection']  = $collection;
        $data['is_owns']     = $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid']         = $uid;
        $data['sl_tab']      = 'content';

        $this->load->view('shop/collection/collection_list', $data);
    }

    public function BAK__showCollectionLink()
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $data['siteGlobal'] = $shop = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        $user_id = $uid;
        $select = 'cl_coll_id, b.name, 
            COALESCE(a.user_id, a2.user_id) as user_id,
            COALESCE(a.image, a2.image) as image,
            COALESCE(a.description, a2.description) as description,
            COALESCE(a.save_link, a2.save_link) as save_link';
        $from = 'tbtt_collection_link';
        $where = "cl_user_id = $user_id";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_custom_link a', 'on' => 'a.id = cl_customLink_id', 'option' => 'left'),
            array('table' => 'tbtt_library_links a2', 'on' => 'a2.id = library_link_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cl_coll_id', 'option' => 'left')
        );
        $order = 'a.create';
        $by = 'DESC';
        $start = -1;
        $limit = 4;
        $distinct = false;
        $collection_link = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        // dd($collection_link);die;
        // ------------------------------------------------------------------------
        $where = "user_id = $user_id AND type = 3";
        if ($is_owner == false) {
            $where .= ' AND status = 1 AND isPublic = 1';
        }
        $collection = $this->collection_model->fetch_c('*', $where, 'created_at', 'DESC', '', '', '');
        // dd($collection);die;
        // ------------------------------------------------------------------------
        // -process data-----------------------------------------------------------

        foreach ($collection as $key => $value) {
            foreach ($collection_link as $k => $v) {
                if (count($collection[$key]->link) < 4 && $value->id == $v->cl_coll_id) {
                    $collection[$key]->link[] = $v;
                }
            }
            $collection[$key]->total = $this->collection_model->get_cl('count("*") as total', 'cl_coll_id = ' . $value->id)->total;

            if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

            } else {
                $collection[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
            }
        }
        // - end process data-------------------------------------------------------

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($collection)){
            $ogimage = $collection[0]->avatar;
            $ogtitle = $collection[0]->name;
        }
        
        $data['ogdescription'] = 'Bộ sưu tập liên kết của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogimage']            = $ogimage;
        $data['ogurl']              = base_url().'shop/collection-link';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection']  = $collection;
        $data['is_owns']     = $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid']         = $uid;
        $data['sl_tab']      = 'link';
        #load view
        $this->load->view('shop/collection/collection_link', $data);
    }

    public function showCollectionLink()
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $data['siteGlobal'] = $shop = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        $user_id = $uid;
        $this->load->model('link_model');
        $collections = $this->link_model->shop_get_all_link_all_collection_has_link($shop->sho_id, $is_owner);
        // ------------------------------------------------------------------------
        // -process data-----------------------------------------------------------
        $temp = [];
        foreach ($collections as $key => $collection) {
            $temp[$collection['c_id']][] = $collection;
        }
        $key_collection = array_keys($temp);
        count($key_collection) ? $key_collection : $key_collection = [0];
        $where = 'sho_id = '. $shop->sho_id . ' AND type = 3 AND id NOT IN('. implode(',',$key_collection) . ')';
        if ($is_owner == false) {
            $where .= ' AND status = 1 AND isPublic = 1';
        }
        $collection_empty = $this->collection_model->fetch_c('*', $where, 'created_at', 'DESC', '', '', '');
        $collections = $temp;

        // add data
        foreach ($collection_empty as $key => $value) {
            $__data = array(
                'id'                => 0,
                'type_tbl'          => '',
                'user_id'           => $value->user_id,
                'sho_id'            => $value->sho_id,
                'image'             => '',
                'video'             => '',
                'c_id'              => $value->id,
                'c_name'            => $value->name,
                'c_avatar'          => $value->avatar_path_full,
                'c_created_at'      => $value->created_at,
                'c_isPublic'        => $value->isPublic,
                'count_1'           => 0,
                'count_2'           => 0,
                'count_3'           => 0,
                'link_title'        => '',
                'link_description'  => '',
                'link_image'        => '',
                'link'              => '',
                'host'              => ''
            );
            $collections[$value->id][] = $__data;
        }
        krsort($collections);

        $og_data_collection = array_slice($collections, 0)[0][0];
        // - end process data-------------------------------------------------------
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($og_data_collection)){
            $ogimage = $og_data_collection['c_avatar'];
            $ogtitle = $og_data_collection['c_name'];
        }

        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_SHOP_COLLECTLINK;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['ogdescription'] = 'Bộ sưu tập liên kết của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogurl']              = base_url().'shop/collection-link';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collections']  = $collections;
        $data['is_owns']     = $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid']         = $uid;
        $data['sl_tab']      = 'link';
        #load view
        $this->load->view('shop/collection/collection_link', $data);
    }

    public function showCollectionProduct()
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $data['siteGlobal'] = $shop = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        $user_id = $uid;
        $select = 'cp_coll_id, b.name, a.pro_id, a.pro_dir, a.pro_image';
        $from = 'tbtt_collection_product';
        $where = "cp_user_id = $user_id AND a.pro_status = 1 AND a.pro_type = 0";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_product a', 'on' => 'a.pro_id = cp_pro_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cp_coll_id', 'option' => 'left')
        );
        $order = 'a.created_date';
        $by = 'DESC';
        $start = -1;
        $limit = 4;
        $distinct = false;
        $collection_product = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        // dd($collection_product);
        // ------------------------------------------------------------------------
        $where = "user_id = $user_id AND type = ".COLLECTION_PRODUCT;
        if ($is_owner == false) {
            $where .= ' AND status = 1 AND isPublic = 1';
        }
        $collection = $this->collection_model->fetch_c('*', $where, 'created_at', 'DESC', '', '', '');
        // dd($collection);
        // ------------------------------------------------------------------------
        // -process data-----------------------------------------------------------

        foreach ($collection as $key => $value) {
            foreach ($collection_product as $k => $v) {
                if (count($collection[$key]->product) < 4 && $value->id == $v->cp_coll_id) {
                    $collection[$key]->product[] = $v;
                }
            }
            $collection[$key]->total = $this->collection_model->get_cp('count("*") as total', 'cp_coll_id = ' . $value->id)->total;

            // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

            // } else {
            //     $collection[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
            // }
        }
        // - end process data-------------------------------------------------------
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($collection)){
            $ogimage = $collection[0]->avatar;
            $ogtitle = $collection[0]->name;
        }

        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_SHOP_COLLECTPRODUCT;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['ogdescription'] = 'Bộ sưu tập sản phẩm của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogurl']              = base_url().'shop/collection-product';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection']  = $collection;
        $data['is_owns']     = $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid']         = $uid;
        $data['sl_tab']      = 'product';
        $this->load->view('shop/collection/collection_product', $data);
    }

    public function showCollectionCoupon()
    {
        // die('Updating');
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $shop = $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        $user_id = $uid;
        $select = 'cp_coll_id, b.name, a.pro_id, a.pro_dir, a.pro_image';
        $from = 'tbtt_collection_product';
        $where = "cp_user_id = $user_id AND a.pro_status = 1 AND a.pro_type = 2";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_product a', 'on' => 'a.pro_id = cp_pro_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cp_coll_id', 'option' => 'left')
        );
        $order = 'a.created_date';
        $by = 'DESC';
        $start = -1;
        $limit = 4;
        $distinct = false;
        $collection_product = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        // dd($collection_product);
        // ------------------------------------------------------------------------
        $where = "user_id = $user_id AND type = ".COLLECTION_COUPON;
        if ($is_owner == false) {
            $where .= ' AND status = 1 AND isPublic = 1';
        }
        $collection = $this->collection_model->fetch_c('*', $where, 'created_at', 'DESC', '', '', '');
        // dd($collection);
        // ------------------------------------------------------------------------
        // -process data-----------------------------------------------------------

        foreach ($collection as $key => $value) {
            foreach ($collection_product as $k => $v) {
                if (count($collection[$key]->product) < 4 && $value->id == $v->cp_coll_id) {
                    $collection[$key]->product[] = $v;
                }
            }
            $collection[$key]->total = $this->collection_model->get_cp('count("*") as total', 'cp_coll_id = ' . $value->id)->total;

            if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

            } else {
                $collection[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/product/' .$value->avatar;
            }
        }
        // - end process data-------------------------------------------------------

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($collection)){
            $ogimage = $collection[0]->avatar;
            $ogtitle = $collection[0]->name;
        }

        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_SHOP_COLLECTCOUPON;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['ogdescription'] = 'Bộ sưu tập phiếu mua hàng của '.$this->shop_current->sho_name;
        $data['ogtitle']            = $ogtitle;
        $data['ogurl']              = base_url().'shop/collection-coupon';
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection']  = $collection;
        $data['is_owns']     = $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['uid']         = $uid;
        $data['sl_tab']      = 'coupon';
        $this->load->view('shop/collection/collection_product', $data);
    }

    public function detailCollection($cc_coll_id = 0)
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $shop = $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        // ------------------------------------------------------------------------
        $coll_selected = $this->collection_model->get_c('*',"id = $cc_coll_id");
        if(empty($coll_selected)){
            redirect(base_url() . 'shop/collection', 'location');
            die();
        }
        // if (strpos('x'.$coll_selected->avatar, 'https://') !== false || strpos('x'.$coll_selected->avatar, 'http://') !== false) {

        // } else {
        //     $coll_selected->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$coll_selected->avatar;
        // }
        // dd($coll_selected);die;
        // ------------------------------------------------------------------------

        //Option
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $user_id = $uid;
        $select = 'cc_coll_id, b.name, a.not_id, a.not_title, a.not_image, a.not_dir_image';
        $from = 'tbtt_collection_content';
        $where = "cc_user_id = $user_id AND cc_coll_id = $cc_coll_id";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_content a', 'on' => 'a.not_id = cc_not_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cc_coll_id', 'option' => 'left')
        );
        $order = 'a.not_id';
        $by = 'DESC';
        $limit = 10;
        $start = ($page - 1) * $limit;
        $distinct = false;
        $collection_content = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);

        foreach ($collection_content as $key => $value) {
            // if (strpos('x'.$value->image, 'https://') !== false || strpos('x'.$value->image, 'http://') !== false) {

            // } else {
            //     $collection_content[$key]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/'. IMAGE_1X1 . $value->not_image;
            // }
            if (filter_var($value->not_image, FILTER_VALIDATE_URL)) { 
                $collection_content[$key]->image = $value->not_image;
            } else {
                $collection_content[$key]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/'. IMAGE_1X1 . $value->not_image;
            }
        }
        // ------------------------------------------------------------------------

        $coll_selected->total = $this->collection_model->get_cc('count(*) as total', 'cc_coll_id = '.$cc_coll_id)->total;


        // data meta_facebook
        //ogtitle,ogimage,ogdescription
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($coll_selected)){
            $ogimage = $coll_selected->avatar_path_full;
            $ogtitle = $coll_selected->name;
        }
        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_DETAIL_SHOPCOLLNEWS;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['ogdescription'] = 'Bộ sưu tập tin '.$coll_selected->name;
        $data['ogtitle']            = $ogtitle;
        $data['ogimage']            = $ogimage;
        $data['ogurl']              = base_url().'shop/collection/select/'.$coll_selected->id;
        $data['ogtype']             = 'website';

        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection_content'] = $collection_content;
        $data['coll_selected']      = $coll_selected;
        $data['is_owns']            = $data['is_owner'] = $is_owner;
        $data['info_public']        = $info_public;
        $data['uid']                = $uid;
        $data['sl_tab']             = 'content';
        // dd($data);die;
        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($collection_content as $key => $value) {
                $html .= $this->load->view('shop/collection/common/item_content', ['item'=>$value, 'is_owner'=>$is_owner], true);
            }
            echo $html;
            die();
        }else{
            $this->load->view('shop/collection/collection_list_item', $data);
        }
    }

    public function Back_up_detailCollectionLink($cl_coll_id = 0)
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        // ------------------------------------------------------------------------
        $coll_selected = $this->collection_model->get_c('*',"id = $cl_coll_id");
        if(empty($coll_selected)){
            redirect(base_url() . 'shop/collection-link', 'location');
            die();
        }
        // if (strpos('x'.$coll_selected->avatar, 'https://') !== false || strpos('x'.$coll_selected->avatar, 'http://') !== false) {

        // } else {
        //     $coll_selected->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$coll_selected->avatar;
        // }
        // dd($coll_selected);die;
        // ------------------------------------------------------------------------

        //Option
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $user_id = $uid;
        $select = 'cl_coll_id, b.name, a.title, a.image, a.description, a.save_link, a.id as cus_link_id, a.host, a.detail';
        $from = 'tbtt_collection_link';
        $where = "cl_user_id = $user_id AND cl_coll_id = $cl_coll_id";
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_custom_link a', 'on' => 'a.id = cl_customLink_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cl_coll_id', 'option' => 'left')
        );
        $order = 'a.create';
        $by = 'DESC';
        $limit = 10;
        $start = ($page - 1) * $limit;
        $distinct = false;
        $collection_link = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);
        foreach ($collection_link as $key => $value) {
            if (strpos('x'.$value->image, 'https://') !== false || strpos('x'.$value->image, 'http://') !== false) {

            } else {
                $collection_link[$key]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->image;
            }
        }
        // dd($collection_link);die;
        $coll_selected->total = $this->collection_model->get_cl('count(*) as total', 'cl_coll_id = '.$cl_coll_id)->total;
        // ------------------------------------------------------------------------
        // data meta_facebook
        //ogtitle,ogimage,ogdescription
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($coll_selected)){
            $ogimage = $coll_selected->avatar_path_full;
            $ogtitle = $coll_selected->name;
        }
        
        $data['ogdescription'] = 'Bộ sưu tập liên kết '.$coll_selected->name;
        $data['ogurl']              = base_url().'shop/collection-link/select/'.$coll_selected->id;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogimage']            = $ogimage;
        
        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection_link'] = $collection_link;
        $data['coll_selected']   = $coll_selected;
        $data['is_owns']         = $data['is_owner'] = $is_owner;
        $data['info_public']     = $info_public;
        $data['uid']             = $uid;
        $data['sl_tab']          = 'link';

        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($collection_link as $key => $value) {
                $html .= $this->load->view('shop/collection/common/item_link', ['item'=>$value , 'is_owner'=>$is_owner], true);
            }
            echo $html;
            die();
        }else{
            $this->load->view('shop/collection/collection_link_item', $data);
        }
    }

    public function detailCollectionLink($cl_coll_id = 0)
    {
        $this->load->model('link_model');
        
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $shop = $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        // ------------------------------------------------------------------------
        $coll_selected = $this->collection_model->get_c('*',"id = $cl_coll_id");
        if(empty($coll_selected)){
            redirect(base_url() . 'shop/collection-link', 'location');
            die();
        }
        // if (strpos('x'.$coll_selected->avatar, 'https://') !== false || strpos('x'.$coll_selected->avatar, 'http://') !== false) {

        // } else {
        //     $coll_selected->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$coll_selected->avatar;
        // }
        // dd($coll_selected);die;
        // ------------------------------------------------------------------------

        //Option
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $limit = 10;
        $start = ($page - 1) * $limit;

        $collection_link = $this->link_model->shop_get_link_collection($this->shop_current->sho_id, $cl_coll_id, $limit, $start, 'DESC');

        $coll_selected->total = count($this->link_model->shop_get_link_collection($this->shop_current->sho_id, $cl_coll_id, $limit, -1, 'DESC'));

        // ------------------------------------------------------------------------
        // data meta_facebook
        //ogtitle,ogimage,ogdescription
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($coll_selected)){
            $ogimage = $coll_selected->avatar_path_full;
            $ogtitle = $coll_selected->name;
        }
        
        $this->load->model('share_metatag_model');

        $type_share = TYPESHARE_DETAIL_SHOPCOLLLINK;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['ogdescription'] = 'Bộ sưu tập liên kết '.$coll_selected->name;
        $data['ogurl']              = base_url().'shop/collection-link/select/'.$coll_selected->id;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        
        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection_link'] = $collection_link;
        $data['coll_selected']   = $coll_selected;
        $data['is_owns']         = $data['is_owner'] = $is_owner;
        $data['info_public']     = $info_public;
        $data['uid']             = $uid;
        $data['sl_tab']          = 'link';

        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($collection_link as $key => $value) {
                $html .= $this->load->view('shop/collection/common/item_link', ['item'=>$value , 'is_owner'=>$is_owner], true);
            }
            echo $html;
            die();
        }else{
            $this->load->view('shop/collection/collection_link_item', $data);
        }
    }

    public function detailCollectionProduct($cp_coll_id = 0)
    {
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        $shop = $data['siteGlobal'] = $this->shop_current;

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        // ------------------------------------------------------------------------
        $coll_selected = $this->collection_model->get_c('*',"id = $cp_coll_id");
        if(empty($coll_selected)){
            redirect(base_url() . 'shop/collection', 'location');
            die();
        }
        // if (strpos('x'.$coll_selected->avatar, 'https://') !== false || strpos('x'.$coll_selected->avatar, 'http://') !== false) {

        // } else {
        //     $coll_selected->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$coll_selected->avatar;
        // }
        // dd($coll_selected);die;
        // ------------------------------------------------------------------------

        //Option
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $user_id = $uid;
        $select = 'cp_coll_id, b.name, a.pro_id, a.pro_name, a.pro_category, a.pro_dir, a.pro_image';
        $from = 'tbtt_collection_product';
        $text = '';
        if($coll_selected->type == COLLECTION_PRODUCT) {
            $where = "cp_user_id = $user_id AND cp_coll_id = $cp_coll_id AND a.pro_status = 1 AND a.pro_type = 0";
            $sl_tab = 'product';
            $text = ' sản phẩm ';
            $type_share = TYPESHARE_DETAIL_SHOPCOLLPRODUCT;
        } else if($coll_selected->type == COLLECTION_COUPON) {
            $where = "cp_user_id = $user_id AND cp_coll_id = $cp_coll_id AND a.pro_status = 1 AND a.pro_type = 2";
            $sl_tab = 'coupon';
            $text = ' phiếu mua hàng ';
            $type_share = TYPESHARE_DETAIL_SHOPCOLLCOUPON;
        } else {
            redirect(base_url() . 'shop/collection', 'location');
            die();
        }
        if ($is_owner == false) {
            $where .= ' AND b.status = 1 AND b.isPublic = 1';
        }
        $join = array(
            array('table' => 'tbtt_product a', 'on' => 'a.pro_id = cp_pro_id', 'option' => 'left'),
            array('table' => 'tbtt_collection b', 'on' => 'b.id = cp_coll_id', 'option' => 'left')
        );
        $order = 'cp_id';
        $by = 'DESC';
        $limit = 10;
        $start = ($page - 1) * $limit;
        $distinct = false;
        $collection_product = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start, $limit);

        foreach ($collection_product as $key => $value) {
            $value->pro_image = array_shift(explode(',',$value->pro_image));
            $collection_product[$key]->image = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $value->pro_image;
        }
        // ------------------------------------------------------------------------

        $coll_selected->total = $this->collection_model->get_cp('count(*) as total', 'cp_coll_id = '.$cp_coll_id)->total;
        // dd($coll_selected);
        // dd($collection_product);die;

        // data meta_facebook
        //ogtitle,ogimage,ogdescription
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $ogtitle = $this->shop_current->sho_name;
        if(!empty($coll_selected)){
            $ogimage = $coll_selected->avatar_path_full;
            $ogtitle = $coll_selected->name;
        }
        
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['sho_user'] = $shop->sho_user;
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $param2 = explode('/', $_SERVER['REQUEST_URI'])[2];
        $data['param2'] = $param2;
        $data['ogdescription'] = 'Bộ sưu tập'.$text.$coll_selected->name;
        $data['ogtitle']            = $ogtitle;
        $data['ogurl']              = base_url().'shop/'.$param2.'/select/'.$coll_selected->id;
        $data['ogtype']             = 'website';
        
        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = $data['ogdescription'];

        $data['collection_product'] = $collection_product;
        $data['coll_selected']      = $coll_selected;
        $data['is_owns']            = $data['is_owner'] = $is_owner;
        $data['info_public']        = $info_public;
        $data['uid']                = $uid;
        $data['sl_tab']             = $sl_tab;
        // dd($data);die;
        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($collection_product as $key => $value) {
                $html .= $this->load->view('shop/collection/common/item_product', ['item'=>$value, 'is_owner'=>$is_owner], true);
            }
            echo $html; die();
        }else{
            $this->load->view('shop/collection/collection_product_item', $data);
        }
    }

    public function viewNodeCollectionLink($bst_id = 0, $cus_link_id = 0)
    {
        if($bst_id < 1 || $cus_link_id < 1){
            redirect(base_url(), 'location');
            die();
        }
        if(empty($this->collection_model->get_cl('*',"cl_customLink_id = $cus_link_id AND cl_coll_id = $bst_id"))){
            redirect(base_url(), 'location');
            die();
        }
        // ------------------------------------------------------------------------
        $is_owner = false;
        $uid = $this->getShopUser();
        if ($uid == 0) {
            redirect(base_url(), 'location');
            die();
        }

        $info_public = $this->user_model->generalInfo($uid);
        if (!($info_public = $this->user_model->generalInfo($uid)) || !in_array($info_public['use_group'], json_decode(ListGroupAff, true))) {
            redirect(base_url() . 'page-not-found', 'location');
            die();
        }

        if ($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')) {
            $is_owner = true;
        }

        // ------------------------------------------------------------------------
        // Load data header collection
        $this->loadDataHeader_Collection($uid);
        // ------------------------------------------------------------------------

        // $bst_id = 0; $cus_link_id = 0;
        $node_collection = $this->collection_model->get_c('*',"id = $bst_id");
        $node_custom_link = array_shift($this->customlink_model->get('*',"id = $cus_link_id"));

        //Option
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }

        $select = "s.* , a.cl_coll_id";
        $from = 'tbtt_custom_link s';
        $join = array(
            array('table' => 'tbtt_collection_link a', 'on' => 'a.cl_customLink_id = id', 'option' => 'left')
        );
        // $where = "s.type = 'collection' AND a.cl_coll_id = $bst_id AND s.id != $cus_link_id";
        $where = "a.cl_coll_id = $bst_id AND s.id != $cus_link_id";
        $order = "s.create";
        $by = 'DESC';
        $limit = 10;
        $start = ($page - 1) * $limit;
        $arr_more_node_cl = $this->customlink_model->fetch_join($select,$from,$where,$join,$order,$by,$start,$limit);
        // ------------------------------------------------------------------------

        // data meta_facebook
        //ogtitle,ogimage,ogdescription
        $data['ogtitle'] = $node_custom_link->title;
        $data['ogdescription'] = $node_custom_link->description;
        $data['ogimage'] = $node_custom_link->image;
        // dd($coll_selected);die;

        $data['node_collection'] = $node_collection;
        $data['node_custom_link'] = $node_custom_link;
        $data['arr_more_node_cl'] = $arr_more_node_cl;
        // $data['coll_selected'] = $coll_selected;
        // $data['is_owner'] = $is_owner;
        // $data['info_public'] = $info_public;
        // $data['uid'] = $uid;

        // dd($data);die;

        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($arr_more_node_cl as $key => $value) {
                $html .= $this->load->view('shop/collection/common/item_link_view', ['item'=>$value], true);
            }
            echo $html;
            die();
        }else{
            $this->load->view('shop/collection/collection_link_item_view', $data);
        }
    }

    //load bo suu tap trong trang Shop
    public function ajax_loadCollection($nid, $type, $link_from)
    {
        if (!$this->check->is_logined((int)$this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if($type == COLLECTION_CONTENT) { // collection content item
            $user_id = $this->session->userdata('sessionUser');
            $select = 'id';
            $from = 'tbtt_collection';
            $where = "user_id = $user_id AND a.cc_not_id = $nid AND id = a.cc_coll_id AND type = $type";
            $join = array(
                array('table' => 'tbtt_collection_content a', 'on' => 'a.cc_user_id = user_id', 'option' => 'left')
            );
            $order = '';
            $by = '';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $array_c = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start);
            foreach ($array_c as $key => $value) {
                $array_c[$key] = $value->id;
            }

            $select = '*';
            $where = "user_id = $user_id AND type = $type";
            $order = 'created_at';
            $by = 'DESC';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $result = $this->collection_model->fetch_c($select, $where, $order, $by, $start, $limit, $distinct);
            foreach ($result as $key => $value) {
                if (in_array($value->id, $array_c)) {
                    $result[$key]->checked = true;
                } else {
                    $result[$key]->checked = false;
                }

                // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

                // } else {
                //     $result[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
                // }
            }

            $showCreate = $this->content_model->get('not_id as id ,not_dir_image as dir, not_image as image', 'not_id = ' . $nid);

            // $html = $this->load->view('shop/collection/collection_item', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
            $html = $this->load->view('shop/collection/html/item-popup-pin-node-to-other-collection', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
        }
        else if($type == COLLECTION_PRODUCT || $type == COLLECTION_COUPON) { // collection product item
            $user_id = $this->session->userdata('sessionUser');
            $select = 'id';
            $from = 'tbtt_collection';
            $where = "user_id = $user_id AND a.cp_pro_id = $nid AND id = a.cp_coll_id AND type = $type";
            $join = array(
                array('table' => 'tbtt_collection_product a', 'on' => 'a.cp_user_id = user_id', 'option' => 'left')
            );
            $order = '';
            $by = '';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $array_c = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start);
            foreach ($array_c as $key => $value) {
                $array_c[$key] = $value->id;
            }

            $select = '*';
            $where = "user_id = $user_id AND type = $type";
            $order = 'created_at';
            $by = 'DESC';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $result = $this->collection_model->fetch_c($select, $where, $order, $by, $start, $limit, $distinct);
            foreach ($result as $key => $value) {
                if (in_array($value->id, $array_c)) {
                    $result[$key]->checked = true;
                } else {
                    $result[$key]->checked = false;
                }

                // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

                // } else {
                //     $result[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
                // }
            }

            $showCreate = $this->product_model->get('pro_id as id ,pro_dir as dir, pro_image as image', 'pro_id = ' . $nid);
            $showCreate->image = array_shift(explode(',',$showCreate->image));

            // $html = $this->load->view('shop/collection/collection_item', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
            $html = $this->load->view('shop/collection/html/item-popup-pin-node-to-other-collection', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
        }
        else if($type == COLLECTION_CUSTOMLINK) { // collection link item
            $user_id = $this->session->userdata('sessionUser');
            $select = 'id';
            $from = 'tbtt_collection';
            if($link_from == 'cus_link') {
                $where = "user_id = $user_id AND a.cl_customLink_id = $nid AND id = a.cl_coll_id AND type = $type";
            }else if($link_from == 'lib_link') {
                $where = "user_id = $user_id AND a.library_link_id = $nid AND id = a.cl_coll_id AND type = $type";
            } else {
                echo 0;die;
            }
            $join = array(
                array('table' => 'tbtt_collection_link a', 'on' => 'a.cl_user_id = user_id', 'option' => 'left')
            );
            $order = '';
            $by = '';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $array_c = $this->collection_model->fetch_join($select, $from, $where, $join, $order, $by, $start);
            foreach ($array_c as $key => $value) {
                $array_c[$key] = $value->id;
            }

            $select = '*';
            $where = "user_id = $user_id AND type = $type";
            $order = 'created_at';
            $by = 'DESC';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $result = $this->collection_model->fetch_c($select, $where, $order, $by, $start, $limit, $distinct);
            foreach ($result as $key => $value) {
                if (in_array($value->id, $array_c)) {
                    $result[$key]->checked = true;
                } else {
                    $result[$key]->checked = false;
                }

                // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

                // } else {
                //     $result[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
                // }
            }

            if($link_from == 'cus_link') {
                $custom_link_node = array_shift($this->db->query('SELECT * FROM tbtt_custom_link WHERE id = '.$nid)->result());
            }else if($link_from == 'lib_link') {
                $custom_link_node = array_shift($this->db->query('SELECT * FROM tbtt_library_links WHERE id = '.$nid)->result());
            } else {
                echo 0;die;
            }
            $showCreate = (object)[
                'id' => $custom_link_node->id,
                'dir' => 0,
                'image' => $custom_link_node->image
            ];
            // dd($showCreate);die;

            // $html = $this->load->view('shop/collection/collection_item', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
            $html = $this->load->view('shop/collection/html/item-popup-pin-node-to-other-collection', array("data" => $result, "showCreate" => $showCreate, "type" => $type), true);
        }


        echo $html;
        die;
    }

    //tao bo suu tap trang chủ và trang shop
    public function ajax_createCollection()
    {
        $x=1;
        if (!$this->check->is_logined((int)$this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        $user_id = $this->session->userdata('sessionUser');
        $avatar = $this->input->post('avatar');
        $avatar_path = $this->input->post('avatar_path');
        $dir = $this->input->post('dir');
        $typeReturn = $this->input->post('typeReturn'); //0: xài ở trang chủ, 1: xài ở chi tiết bộ sưu tập
        $typeCollection = $this->input->post('typeCollection');
        $date = new DateTime();

        if($typeCollection == COLLECTION_CONTENT){
            $data = array(
                'name' => $this->input->post('name_col'),
                'avatar_path_full' => $avatar,
                'avatar_path' => $avatar_path,
                'user_id' => $user_id,
                'status' => 1,
                'isPublic' => $this->input->post('name_notpublic') == 'check' ? 0 : 1, // 1: public 0: private
                'type' => $typeCollection, // 1: content 2: product 3: link
            );
            $link = $avatar;
        }
        else if($typeCollection == COLLECTION_PRODUCT || $typeCollection == COLLECTION_COUPON){
            $data = array(
                'name' => $this->input->post('name_col'),
                'avatar_path_full' => DOMAIN_CLOUDSERVER . 'media/images/product/' . $dir . '/' . $avatar,
                'avatar_path' => $dir . '/' . $avatar,
                'user_id' => $user_id,
                'status' => 1,
                'isPublic' => $this->input->post('name_notpublic') == 'check' ? 0 : 1, // 1: public 0: private
                'type' => $typeCollection, // 1: content 2: product 3: link
            );
            $link = $data['avatar_path_full'];
        }
        else if($typeCollection == COLLECTION_CUSTOMLINK){
            $data = array(
                'name' => $this->input->post('name_col'),
                'avatar_path_full' => urldecode($avatar),
                'avatar_path' => '',
                'user_id' => $user_id,
                'status' => 1,
                'isPublic' => $this->input->post('name_notpublic') == 'check' ? 0 : 1, // 1: public 0: private
                'type' => $typeCollection, // 1: content 2: product 3: link
            );
            $link = $avatar;
        }

        if ($this->collection_model->add_c($data)) {
            $data['id'] = $this->db->insert_id();
            if ($typeReturn == 0) { // xài ở trang chủ
                $new_collection = '<li><div class="photo"><img src="' . $link . '" alt=""><label class="checkbox-style"><input type="checkbox" name="collection[]" value="' . $data['id'] . '"><span></span></label></div><div class="name">' . $this->input->post('name_col') . '</div></li>';
            } elseif ($typeReturn == 1) { // xài trong bộ sưu tập tin tức
                // $new_collection = '<li><label class="checkbox-style"><input type="checkbox" name="collection[]" value="' . $data['id'] . '"><span></span><div class="photo"><img src="' . $link . '" alt=""></div><div class="name">' . $this->input->post('name_col') . '</div></label></li>';
                $new_collection = '';
                $new_collection .= '<div class="bosuutap-popup-danhsach-hientai-item">';
                $new_collection .= '<div class="photo">';
                $new_collection .= '<img src="'.$link.'" alt="">';
                $new_collection .= '<label class="checkbox-style">';
                $new_collection .= '<input type="checkbox" name="collection[]" value="'.$data['id'].'"><span></span>';
                $new_collection .= '</label>';
                $new_collection .= '</div>';
                $new_collection .= '<div class="name">'.$this->input->post('name_col').'</div>';
                $new_collection .= '</div>';
            }

            echo $new_collection;
            die;
        } else {
            echo 0;
            die;
        }
    }

    //tao noi dung bo suu tap trang chủ và trang shop
    public function ajax_createCollectionContent($node_id, $typeCollection)
    {
        if (!$this->check->is_logined((int)$this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'account', 'location');
            die();
        }
        if($typeCollection == COLLECTION_CONTENT){
            $content_id = $node_id;
            $this->collection_model->delete_cc($content_id, 'cc_not_id', false);
            $user_id = $this->session->userdata('sessionUser');
            $list_selected = $this->input->post('collection');
            if (count($list_selected) == 1 && $list_selected[0] == "off") {
                echo 0;
                die;
            }
            array_shift($list_selected);
            foreach ($list_selected as $key => $value) {
                $data[] = array(
                    'cc_coll_id' => $value,
                    'cc_user_id' => $user_id,
                    'cc_not_id' => $content_id,
                );
            }

            if ($this->db->insert_batch('tbtt_collection_content', $data)) {
                echo $this->db->insert_id();
                die;
            } else {
                echo 'error';
                die;
            }
        }
        else if($typeCollection == COLLECTION_PRODUCT || $typeCollection == COLLECTION_COUPON){
            $pro_id = $node_id;
            $this->collection_model->delete_cp($pro_id, 'cp_pro_id', false);
            $user_id = $this->session->userdata('sessionUser');
            $list_selected = $this->input->post('collection');
            if (count($list_selected) == 1 && $list_selected[0] == "off") {
                echo 0;
                die;
            }
            array_shift($list_selected);
            foreach ($list_selected as $key => $value) {
                $data[] = array(
                    'cp_coll_id' => $value,
                    'cp_user_id' => $user_id,
                    'cp_pro_id' => $pro_id,
                );
            }

            if ($this->db->insert_batch('tbtt_collection_product', $data)) {
                echo $this->db->insert_id();
                die;
            } else {
                echo 'error';
                die;
            }
        }
        else if($typeCollection == COLLECTION_CUSTOMLINK){
            if($this->input->post('linkfrom') == 'cus_link') {
                $customLink_id = $node_id;
                $this->collection_model->delete_cl($customLink_id, 'cl_customLink_id', false);
                $user_id = $this->session->userdata('sessionUser');
                $list_selected = $this->input->post('collection');
                if (count($list_selected) == 1 && $list_selected[0] == "off") {
                    echo 0;
                    die;
                }
                array_shift($list_selected);
                foreach ($list_selected as $key => $value) {
                    $data[] = array(
                        'cl_coll_id' => $value,
                        'cl_user_id' => $user_id,
                        'cl_customLink_id' => $customLink_id,
                    );
                }

                if ($this->db->insert_batch('tbtt_collection_link', $data)) {
                    echo $this->db->insert_id();
                    die;
                } else {
                    echo 'error';
                    die;
                }
            }else if($this->input->post('linkfrom') == 'lib_link') {
                $libraryLink_id = $node_id;
                $this->collection_model->delete_cl($libraryLink_id, 'library_link_id', false);
                $user_id = $this->session->userdata('sessionUser');
                $list_selected = $this->input->post('collection');
                if (count($list_selected) == 1 && $list_selected[0] == "off") {
                    echo 0;
                    die;
                }
                array_shift($list_selected);
                foreach ($list_selected as $key => $value) {
                    $data[] = array(
                        'cl_coll_id' => $value,
                        'cl_user_id' => $user_id,
                        'library_link_id' => $libraryLink_id,
                    );
                }

                if ($this->db->insert_batch('tbtt_collection_link', $data)) {
                    echo $this->db->insert_id();
                    die;
                } else {
                    echo 'error';
                    die;
                }
            } else {
                echo 0;die;
            }
        }
    }

    // tạo bộ sưu tập trong shop/collection
    public function ajax_createCollection_choose()
    {
        $this->load->library(['ftp', 'upload']);

        $imgSrc         = $this->input->post('srcImg');
        $nameCollection = $this->input->post('nameCollection');
        $type           = $this->input->post('type');
        $isPublic       = $this->input->post('isPublic');
        $sho_id         = (int)$this->input->post('sho_id');
        $user_id        = $this->session->userdata('sessionUser');
        $group_id       = $this->session->userdata('sessionGroup');

        //check has shop id
        if ($this->input->post('is_owner') === 'shop' && $sho_id) {
            $my_shop = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $my_shop = array_to_array_keys($my_shop, 'sho_id');
            if (empty($my_shop) || !in_array($sho_id, $my_shop)) {
                $sho_id = 0;
            }
        }else{
            $sho_id = 0;
        }

        $filepath = '/public_html/media/images/content/';
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port'] = PORT_CLOUDSERVER;
        $config['debug'] = false;
        $this->ftp->connect($config);


        #Create folder
        // $pathImage = 'media/images/content/';
        // $path = '/public_html/media/images/content';
        // $dir_image = $this->session->userdata('sessionUsername');
        // $dir = date('dmY');

        $pathImage = 'media/images/collection/';
        $path = '/public_html/media/images/collection';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir = date('Y').'/'.date('m').'/'.date('d');

        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (!in_array(date('Y'), $ldir)) {
            $this->ftp->mkdir($path . '/' . date('Y'), 0775, true);
        }
        $ldir = $this->ftp->list_files($path . '/' . date('Y'));
        if (!in_array(date('m'), $ldir)) {
            $this->ftp->mkdir($path . '/' . date('Y') . '/' . date('m'), 0775, true);
        }
        $ldir = $this->ftp->list_files($path . '/' . date('Y') . '/' . date('m'));
        if (!in_array(date('d'), $ldir)) {
            $this->ftp->mkdir($path . '/' . date('Y') . '/' . date('m') . '/' . date('d'), 0775, true);
        }

        if (!is_dir($pathImage . $dir_image)) {
            @mkdir($pathImage . $dir_image, 0775);
            $this->load->helper('file');
            @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
        }

        $sCustomerImageName = uniqid() . time() . uniqid();
        $type_image = $this->convertStringToImageFtp($sCustomerImageName,'media/images/collection/'.$dir_image.'/',$imgSrc);

        $cus_avatar = $sCustomerImageName.'.'.$type_image;

        if (file_exists($pathImage . $dir_image . '/' . $cus_avatar)) {
            if($this->ftp->upload($pathImage . $dir_image . '/' . $cus_avatar, $path . '/' . $dir .'/' . $cus_avatar, 'auto', 0775)){
                $data = array(
                    'name'          => $nameCollection,
                    'user_id'       => $user_id,
                    'sho_id'        => $sho_id,
                    'avatar_path_full'        => DOMAIN_CLOUDSERVER . 'media/images/collection/' . $dir .'/' . $cus_avatar,
                    'avatar_path'   => $dir .'/' . $cus_avatar,
                    'status'        => 1,
                    'isPublic'      => $isPublic, // 1: public 0: private
                    'type'          => $type,
                );
                $this->collection_model->add_c($data);
                echo "1";die;
            } else {
                echo "0";die;
            }
        } else {
            echo "0";die;
        }
    }

    // chỉnh sữa bộ sưu tập trong shop/collection
    public function ajax_updateCollection_choose()
    {
        // echo '1';die;
        // $this->load->library(['ftp', 'upload']);

        $key = $this->input->post('key');
        $imgSrc = $this->input->post('srcImg');
        $nameCollection = $this->input->post('nameCollection');
        $type = $this->input->post('type');
        $isPublic = $this->input->post('isPublic');
        $has_newImg = $this->input->post('has_newImg');

        if($has_newImg == 1) {

            $filepath = '/public_html/media/images/content/';
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);


            #Create folder
            $pathImage = 'media/images/collection/';
            $path = '/public_html/media/images/collection';
            $dir_image = $this->session->userdata('sessionUsername');
            $dir = date('Y').'/'.date('m').'/'.date('d');

            // Upload to other server cloud
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (!in_array(date('Y'), $ldir)) {
                $this->ftp->mkdir($path . '/' . date('Y'), 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/' . date('Y'));
            if (!in_array(date('m'), $ldir)) {
                $this->ftp->mkdir($path . '/' . date('Y') . '/' . date('m'), 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/' . date('Y') . '/' . date('m'));
            if (!in_array(date('d'), $ldir)) {
                $this->ftp->mkdir($path . '/' . date('Y') . '/' . date('m') . '/' . date('d'), 0775, true);
            }

            if (!is_dir($pathImage . $dir_image)) {
                @mkdir($pathImage . $dir_image, 0775);
                $this->load->helper('file');
                @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            // $data = explode(',', $imgSrc);
            // $content = base64_decode($data[1]);
            $sCustomerImageName = uniqid() . time() . uniqid();
            $type_image = $this->convertStringToImageFtp($sCustomerImageName,'media/images/collection/'.$dir_image.'/',$imgSrc);

            $cus_avatar = $sCustomerImageName.'.'.$type_image;
            // $x=1;
            // die;
            if (file_exists($pathImage . $dir_image . '/' . $cus_avatar)) {
                if($this->ftp->upload($pathImage . $dir_image . '/' . $cus_avatar, $path . '/' . $dir .'/' . $cus_avatar, 'auto', 0775)){
                    $collection_update = $this->collection_model->get_c('*', "id = $key");
                    $collection_update->name = $nameCollection;
                    $collection_update->isPublic = $isPublic;
                    $collection_update->type = $type;
                    $collection_update->avatar_path_full = DOMAIN_CLOUDSERVER . 'media/images/collection/' . $dir .'/' . $cus_avatar;
                    $collection_update->avatar_path = $dir .'/' . $cus_avatar;

                    $this->collection_model->update_c($collection_update,"id = $key");
                    echo "1";die;
                } else {
                    echo "0";die;
                }
            } else {
                echo "0";die;
            }

        } else {
            $collection_update = $this->collection_model->get_c('*', "id = $key");
            $collection_update->name = $nameCollection;
            $collection_update->isPublic = $isPublic;
            $collection_update->type = $type;
            if($this->collection_model->update_c($collection_update,"id = $key")){
                echo "1";die;
            } else {
                echo "0";die;
            }
        }

    }

    // xóa bộ sưu tập trong shop/collection
    public function ajax_deleteCollection_choose()
    {
        $id = $this->input->post('key');
        $type = $this->input->post('type');
        if($type == COLLECTION_CONTENT) {
            if($this->collection_model->delete_c($id, 'id')){
                $this->collection_model->delete_cc($id, 'cc_coll_id');
                echo '1';die;
            } else {
                echo '0';die;
            }
        }
        else if($type == COLLECTION_PRODUCT || $type == COLLECTION_COUPON) {
            if($this->collection_model->delete_c($id, 'id')){
                $this->collection_model->delete_cp($id, 'cp_coll_id');
                echo '1';die;
            } else {
                echo '0';die;
            }
        }
        else if($type == COLLECTION_CUSTOMLINK) {
            $x=1;
            $sql = "DELETE tbtt_collection_lib_links, tbtt_collection
                    FROM tbtt_collection_lib_links
                    LEFT JOIN tbtt_collection
                        ON tbtt_collection.id = tbtt_collection_lib_links.collection_id
                    WHERE tbtt_collection.id = $id
                    AND tbtt_collection.sho_id = ".$this->shop_current->sho_id."
                    AND tbtt_collection.type = $type";
            $this->db->query($sql);
            if($this->db->affected_rows()) {
                echo '1';die;
            } else {
                echo '0';die;
            }
            // if($this->collection_model->delete_c($id, 'id')){
            //     $this->collection_model->delete_cl($id, 'cl_coll_id');
            //     echo '1';die;
            // } else {
            //     echo '0';die;
            // }
        }
    }

    // tạo bộ sưu tập trong shop/collection
    public function ajax_Save_CustomLink_Collection()
    {
        $this->load->model('link_model');
        $this->load->model('lib_link_model');
        $this->load->model('collection_lib_link_model');
        $link_insert = [
            'link' => $this->input->post('save_link'),
        ];
        $data_insert = [
            'created_at' => date('Y-m-d H:i:s')
        ];

        $claw_data      = $this->_get_claw_data($this->input->post('save_link'));
        //check exist link
        $link_id = 0;
        if(($link = $this->link_model->find_where(['link' => $link_insert['link']]))){
            $link_id = $link['id'];
        }else{
            $link_insert['added_at'] = date('Y-m-d H:i:s');
            $link_insert = array_merge($link_insert, $claw_data);
            if($this->link_model->add_new($link_insert)){
                $link_id = $this->db->insert_id();
            }
        }

        if($link_id){
            $collection_ids              = [$this->input->post('type_id')];
            $user_id                     = $this->session->userdata('sessionUser');
            $data_insert['user_id']      = $user_id;
            $data_insert['is_public']    = 1;
            $data_insert['link_id']      = $link_id;
            $data_insert['cate_link_id'] = 0;
            $data_insert['sho_id']       = (int)$this->shop_current->sho_id;
            $data_insert['image']        = $this->input->post('image');
            $data_insert['video']        = $this->input->post('video');

            if(($description = $this->input->post('detail', true))){
                $data_insert['description'] = $description;
            }

            if($data_insert['image']){
                //get info image
                $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_insert['image']);
                $data_insert['image'] = date('Y/m/d\/') . $data_insert['image'];
                if(!empty($info_image)){
                    $data_insert['img_width']   = $info_image[0];
                    $data_insert['img_height']  = $info_image[1];
                    $data_insert['mime']        = $info_image['mime'];
                }
            }else{
                $data_insert['image'] = '';
            }

            if($data_insert['video']){
                $data_insert['video'] = date('Y/m/d\/') . $data_insert['video'];
            }else{
                $data_insert['video'] = '';
            }

            if ($this->lib_link_model->add_new($data_insert)) {
                if (!empty($collection_ids)) {
                    $temp    = [];
                    $link_id = $this->db->insert_id();
                    foreach ($collection_ids as $index => $collection_id) {
                        $temp[$index] = [
                            'collection_id' => $collection_id,
                            'lib_link_id'   => $link_id,
                        ];
                    }
                    $this->collection_lib_link_model->adds($temp);
                }

                //remove image temp sau khi insert
                if (!empty($data_insert['image'])) {
                    @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['image']));
                }
                //remove video temp sau khi insert
                if (!empty($data_insert['video'])) {
                    @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['video']));
                }

                echo 1;
                die();
            }
        } else {
            echo '0';die;
        }
    }

    /**
     * @param $url
     * @return array
     * claw data from url
     */
    private function _get_claw_data($url)
    {
        $result = [];
        if (!$url) {
            return $result;
        }
        $data_crawl = getUrlMeta($url);
        if (!empty($data_crawl)) {
            //nếu có image up thì lấy image size của image up
            if (!empty($data_crawl['image'])) {
                $result['image'] = $data_crawl['image'];
                list($width, $height) = @getimagesize($data_crawl['image']);
                $result['img_width']  = $width;
                $result['img_height'] = $height;
            }
            if (!empty($data_crawl['title'])) {
                $result['title'] = strip_tags(trim($data_crawl['title']));
            }
            if (!empty($data_crawl['description'])) {
                $result['description'] = strip_tags(trim($data_crawl['description']));
            }
            $urlData        = parse_url($url);
            $result['host'] = str_replace('www.', '', $urlData['host']);
        }
        return $result;
    }

    public function exist_link($id, $type)
    {
        if (!$id || !$type) {
            return false;
        }

        if($type == 'library-link' && !($link = $this->lib_link_model->find_link_by_id($id, true))){
            return false;
        }

        if($type == 'content-link' && !($link = $this->content_link_model->find_link_by_id($id, true))){
            return false;
        }

        if($type == 'image-link' && !($link = $this->content_image_link_model->find_link_by_id($id, true))){
            return false;
        }

        //nếu library link là của shop thì check user đó có sở hữu shop hoặc là nhân viên của shop đó không ?
        if ($link['sho_id']) {
            if(!$this->user_owner_shop($link['sho_id'])){
                return false;
            }
        }else{
            //nếu là link cá nhân
            if($link['user_id'] != $this->session->userdata('sessionUser')){
                return false;
            }
        }
        return $link;
    }

    public function user_owner_shop($sho_id = 0, $user_id = 0, $group_id = 0)
    {
        if ($this->input->post('is_owner') === 'shop' || $sho_id) {

            if (!$sho_id)
                $sho_id = (int)$this->input->post('sho_id');

            if (!$user_id)
                $user_id = (int)$this->session->userdata('sessionUser');

            if (!$group_id)
                $group_id = (int)$this->session->userdata('sessionGroup');

            if (!$sho_id || !$user_id || !$group_id) {
                return false;
            }

            $my_shops = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $my_shops = array_to_array_keys($my_shops, 'sho_id');
            if (empty($my_shops) || !in_array($sho_id, $my_shops)) {
                return false;
            }
        }
        return true;
    }

    // update bộ sưu tập trong shop/collection
    public function ajax_Update_CustomLink_Collection()
    {
        $this->load->model('lib_link_model');
        $this->load->model('content_link_model');
        $this->load->model('content_image_link_model');
        $this->load->model('collection_lib_link_model');
        $this->load->model('collection_content_link_model');
        $this->load->model('collection_content_image_link_model');

        $link_id            = $this->input->post('id');
        $tbl                = $this->input->post('tbl');
        $detail             = $this->input->post('detail');
        $image              = $this->input->post('image');
        $video              = $this->input->post('video');

        if(!$tbl){
            return false;
        }
        if (!$link_id || !($link = $this->exist_link($link_id, $tbl))) {
            echo 0;
            die();
        }

        $user_id                        = (int)$this->session->userdata('sessionUser');
        $collection_ids                 = [$this->input->post('type_id')];
        $data_update['sho_id']          = (int)$this->input->post('sho_id');
        $data_update['sho_id']          = (int)$this->shop_current->sho_id;
        $data_update['is_public']       = 1;
        $data_update['updated_at']      = date('Y-m-d H:i:s');
        $data_update['image']           = $this->input->post('image');
        $data_update['video']           = $this->input->post('video');
        $data_update['description']     = $this->input->post('detail', true);

        if (!empty($data_update['image'])) {
            //get info image
            $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_update['image']);
            $data_update['image'] = date('Y/m/d\/') . $data_update['image'];
            if(!empty($info_image)){
                $data_update['img_width']   = $info_image[0];
                $data_update['img_height']  = $info_image[1];
                $data_update['mime']        = $info_image['mime'];
            }
        }

        if (!empty($data_update['video'])) {
            $data_update['video'] = date('Y/m/d\/') . $data_update['video'];
        }

        if(!$data_update['image']){
            unset($data_update['image']);
        }

        if(!$data_update['description']){
            unset($data_update['description']);
        }

        if(!$data_update['video']){
            unset($data_update['video']);
        }

        //dua theo tbl de update dung
        $flag_update = false;
        if($link['type_tbl'] == 'tbtt_lib_links'){
            if ($this->lib_link_model->update_where($data_update, ['id' => $link_id])) {
                $flag_update = true;
                //chỉ delete link collection cá nhân hoặc shop.
                $this->collection_lib_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                if (!empty($collection_ids)) {
                    $temp = [];
                    foreach ($collection_ids as $index => $collection_id) {
                        $temp[$index] = [
                            'collection_id' => $collection_id,
                            'lib_link_id'   => $link_id,
                        ];
                    }
                    $this->collection_lib_link_model->adds($temp);
                }
            }

        }

        if($link['type_tbl'] == 'tbtt_content_links'){
            if ($this->content_link_model->update_where($data_update, ['id' => $link_id])) {
                //chỉ delete link collection cá nhân hoặc shop.
                $this->collection_content_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                if (!empty($collection_ids)) {
                    $temp = [];
                    foreach ($collection_ids as $index => $collection_id) {
                        $temp[$index] = [
                            'collection_id'   => $collection_id,
                            'content_link_id' => $link_id,
                        ];
                    }
                    $this->collection_content_link_model->adds($temp);
                }
            }
        }

        if($link['type_tbl'] == 'tbtt_content_image_links'){
            if ($this->content_image_link_model->update_where($data_update, ['id' => $link_id])) {
                //chỉ delete link collection cá nhân hoặc shop.
                $this->collection_content_image_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                if (!empty($collection_ids)) {
                    $temp = [];
                    foreach ($collection_ids as $index => $collection_id) {
                        $temp[$index] = [
                            'collection_id'         => $collection_id,
                            'content_image_link_id' => $link_id,
                        ];
                    }
                    $this->collection_content_image_link_model->adds($temp);
                }
            }
        }

        if ($flag_update) {
            //remove image temp sau khi insert
            if (!empty($data_update['image'])) {
                @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['image']));
            }

            //remove video temp sau khi insert
            if (!empty($data_update['video'])) {
                @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['video']));
            }

            $cloud_path = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
            $response   = $this->exist_link($link_id, $type);

            echo 1;die;
        }else{
            echo 0; die;
        }

        echo 0;die;
    }

    //Load all collection link by customlink_id
    public function ajax_loadAll_Collection_CheckExist_Node($nid, $typeCollection)
    {
        $x=1;
        $select = '*';
        $where = 'user_id = ' . $this->session->userdata('sessionUser') . ' AND type = ' . $typeCollection;
        $distinct = false;
        $collection = $this->collection_model->fetch_c($select,$where,'name','ASC','','','');
        // ------------------------------------------------------------------------
        if($typeCollection == COLLECTION_CUSTOMLINK) {
            $select = 'cl_coll_id';
            $where = 'cl_customLink_id = ' . $nid;
            $node_in_arr = $this->collection_model->fetch_cl($select,$where,'','','','','');
            foreach ($node_in_arr as $key => $value) {
                $node_in_arr[$key] = $value->cl_coll_id;
            }

            foreach ($collection as $key => $value) {
                if(in_array($value->id, $node_in_arr)){
                    $collection[$key]->checked = true;
                }else{
                    $collection[$key]->checked = false;
                }

                if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

                } else {
                    $collection[$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar;
                }
            }

            $custom_link = array_shift($this->customlink_model->get('*',"id = $nid"));

            // ------------------------------------------------------------------------
            $data['collection'] = $collection;
            $data['custom_link'] = $custom_link;


            $html = $this->load->view('home/tintuc/html/html-popup-frm-add-link', $data, true);

        }

        // ------------------------------------------------------------------------
        echo $html;die;
    }

    // ------------------------------------------------------------------------
    // Function
    public function loadDataHeader_Collection($uid)
    {
        $sessionUser = $this->session->userdata('sessionUser');
        if ($sessionUser) {
            $data['currentuser'] = $this->user_model->get("use_id, use_username, avatar, af_key, use_invite, use_fullname", "use_id = " . $sessionUser);
            if (in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true))) {
                $myshop = $this->shop_model->get("sho_user, sho_name, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_link, domain", "sho_user = " . $sessionUser);
                //Get AF Login
                $data['af_id'] = $data['currentuser']->af_key;
            } elseif ($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15) {
                $parentUser = $this->user_model->get("parent_id", "use_id = " . $sessionUser);
                $myshop = $this->shop_model->get("sho_user, sho_name, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_link, domain", "sho_user = " . $parentUser->parent_id);
            }
            $data['shop_view'] = $data['myshop'] = $myshop;
            $info_public['avatar'] = $data['currentuser']->avatar;
            if ($sessionUser != $uid) {
                $view_user = $this->user_model->get("use_id, use_username, avatar, af_key, use_invite, use_fullname", "use_id = " . $uid);
                $info_public['avatar'] = $view_user->avatar;
                $data['shop_view'] = $this->shop_model->get("sho_user, sho_name, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_link, domain", "sho_user = " . $uid);
            }
        } else {
            $sessionUser = $uid;
            $data['currentuser'] = $this->user_model->get("use_id, use_username, avatar, af_key, use_invite, use_fullname", "use_id = " . $sessionUser);
            $info_public['avatar'] = $data['currentuser']->avatar;
            $data['shop_view'] = $this->shop_model->get("sho_user, sho_name, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_link, domain", "sho_user = " . $sessionUser);
            unset($data['currentuser']);
        }
        $this->load->vars($data);
    }
    // ------------------------------------------------------------------------
    /**
     ***************************************************************************
     * Created: 19/12/2018
     * Get id user from shop link
     ***************************************************************************
     * @author: BaoTran<tranbaothe@gmail.com>
     * @return: int
     *
     ***************************************************************************
     */
    public function getShopUser()
    {
        $uid = 0;
        $linkShop = '';
        $linkShop = $this->getShopLink();

        $shop = $this->shop_model->get('sho_user', 'sho_link = "' . $this->filter->injection($linkShop) . '" AND sho_status = 1');

        if (empty($shop)) {
            $shop = $this->shop_model->get('sho_user', 'domain = "' . $_SERVER['HTTP_HOST'] . '" AND sho_status = 1');
            if(empty($shop)){
                redirect(base_url() . 'page-not-found', 'location');
                die();
            }

        }

        $uid = $shop->sho_user;

        return $uid;
    }

    public function info_s()
    {
        echo '<pre>';
        print_r($_SERVER);
        echo '</pre>';
        echo '<br>';
        die('debug');
    }

    public function profile($userid)
    {

        $this->load->model('category_link_model');
        $this->set_layout('home/personal/profile-layout');
        $is_owner           = false;
        $info_public        = (array) $this->user_model->get('*', 'use_id = ' . $userid);
        
        $data['sho_user'] = $info_public['use_id'];
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = $info_public['use_fullname'];
        $data['keywordsSiteGlobal'] = $info_public['use_fullname'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogdescription']      = $ogdesc;
        $data['ogurl'] = $ogurl;
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];
        $data['info_public'] = $info_public;

        $this->load->view('home/personal/pages/profile-home', $data);
    }

    public function check_domain() {
        $this->load->model('domains_model');

        $domain = $this->domains_model->get('*','domain = "'.$_SERVER['HTTP_HOST'].'"');
        if(count( (array) $domain ) > 0) {
            $user  = $this->user_model->get('*', 'use_id = ' . $domain->userid);
            $this->profile($domain->userid);
        }else {
            $this->home_page();
        }
    }

    public function home_page()
    {
        $this->_exist_shop();
        $this->load->library('link_library');
        $this->load->model('like_content_model');
        $this->load->model('videos_model');
        $this->load->model('category_link_model');
        
        $shop                = $this->shop_current;
        $linktoshop          = $shop->shop_url;
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $data['siteGlobal']  = $shop;
        $data['protocol']    = get_server_protocol();
        $data['listreports'] = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'ASC');
        $data['linktoshop']  = $linktoshop;
        $data['follow']      = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']      = $shop->sho_id;
        $idUser              = (int)$shop->sho_user;
        $user                = $this->user_model->get('*', 'use_id = ' . $idUser);
        $sessionUser         = (int)$this->session->userdata('sessionUser');
        $sessionGroup        = (int)$this->session->userdata('sessionGroup');
        $data['sho_user']    = $idUser;
        if (empty($user)) {
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        $data['user_login']  = MY_Loader::$static_data['hook_user'];
        // $list_user           = $this->user_model->get_all_user_shop_of_branch($shop->sho_user, 'string');
        $list_user           = $this->user_model->get_list_user_shop_and_branch($shop->sho_user, 'string');

        if ($sessionUser) {
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite,use_fullname", "use_id = " . $sessionUser);
            if (in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true))) {
                $myshop = $this->shop_model->get("sho_link, domain", "sho_user = " . $sessionUser);
                //Get AF Login
            } elseif ($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15) {
                $parentUser = $this->user_model->get("parent_id", "use_id = " . $sessionUser);
                $myshop     = $this->shop_model->get("sho_link, domain", "sho_user = " . $parentUser->parent_id);
            }
            $data['myshop'] = $myshop;
        }

        $data['is_owns'] = $shop->sho_user == $sessionUser;
        $owns_id = 0;

        if($data['is_owns']){
            $owns_id = $shop->sho_user;
            /*chủ shop và là store thì mới get branch*/
            if($sessionGroup == AffiliateStoreUser){
                $data['list_branches'] = $this->shop_model->branch_of_user($shop->sho_user);
                if(!empty($data['list_branches'])){
                    foreach ($data['list_branches'] as $key_branch => $branch) {
                        $data['list_branches'][$key_branch]['logo_shop'] = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $branch['sho_dir_logo'] . '/' . $branch['sho_logo'];
                    }
                }
            }
        }

        if($sessionGroup == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $sessionUser, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_staff->use_id;
            }
        }

        //news
        $this->load->model('detail_product_model');
        $data['list_news'] = $this->_getListShop($shop->sho_id, $data['is_owns'], $shop->sho_user);
        //ajax load more
        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/news/elements/news_items', $data, true);
            die();
        }

        $this->load->model('collection_model');
        $this->load->model('link_model');
        $this->load->model('share_metatag_model');

        //block san pham tu shop cha
        $data['list_products']      = $this->product_model->fetch_join1("pro_category, pro_id, pro_category, pro_name, pro_descr, pro_image, pro_dir, pro_type, sho_link, domain", "LEFT", "tbtt_shop", "sho_user = pro_user", "pro_status = 1 AND pro_type = ".PRODUCT_TYPE." AND pro_user IN ($list_user)", "IF(pro_order > 0, pro_order, pro_id)", "DESC", 0, 10);
        $data['product_total']      = $this->db->query('SELECT count(pro_id) as total FROM (tbtt_product) LEFT JOIN tbtt_shop ON sho_user = pro_user WHERE `pro_status` = 1 AND pro_type = '.PRODUCT_TYPE.' AND pro_user IN ('.$list_user.')')->row_array();
        //block coupon tu shop cha
        $data['coupons']            = $this->product_model->fetch_join1("pro_category, pro_id, pro_category, pro_name, pro_descr, pro_image, pro_dir, pro_type, sho_link, domain", "LEFT", "tbtt_shop", "sho_user = pro_user", "pro_status = 1 AND pro_type = " . COUPON_TYPE . " AND pro_user IN ($list_user)", "IF(pro_order > 0, pro_order, pro_id)", "DESC", 0, 4);
        $data['coupon_total']       = $this->db->query('SELECT count(pro_id) as total FROM (tbtt_product) LEFT JOIN tbtt_shop ON sho_user = pro_user WHERE `pro_status` = 1 AND pro_type = '.COUPON_TYPE.' AND pro_user IN ('.$list_user.')')->row_array();
        //block video tu bai viet
        $data['list_videos']        = $this->content_model->shop_news_list_videos($shop->sho_id, 5, 0, $owns_id, false, $shop->sho_user);
        $data['videos_news_total']  = $this->content_model->shop_news_list_videos($shop->sho_id, 0, 0, $owns_id, true, $shop->sho_user);
        //block images
        $data['images_total']       = $this->content_model->shop_news_list_image($shop->sho_id, 0, 0, $owns_id, true, [], 0, $shop->sho_user);
        $data['images']             = $this->content_model->shop_news_list_image($shop->sho_id, 4, 0, $owns_id, false, [], 0, $shop->sho_user);
        //block bộ sưu tập
        $data['collections']        = $this->collection_model->get_collection_by_user($shop->sho_user, $data['is_owns'], 'get');
        $data['collection_total']   = $this->collection_model->get_collection_by_user($shop->sho_user, $data['is_owns'], 'count');
        //block custom link đổi thành tbtt_links
        $data['customlinks']      = $this->link_model->shop_gallery_list_link($shop->sho_id, 0, 0, 4, 0, $owns_id);
        $data['customlink_total'] = $this->link_model->shop_gallery_list_link($shop->sho_id, 0, 0, 0, 0, $owns_id, 'DESC', true);

        if(!empty($data['user_login'])){
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        //Danh sach tin chon ve
        $data['ds_tin_chon'] = $this->content_model->fetch_join_2(
            "a.not_id, a.not_title, a.not_image, a.not_dir_image, s.sho_link, s.domain",
            "LEFT", "tbtt_chontin AS c", "c.not_id = a.not_id",
            "LEFT", "tbtt_shop AS s", "s.sho_user = a.not_user",
            "a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND c.sho_user_1 = " . $idUser,
            "a.not_id",
            "DESC", -1, 0, true
        );

        //Danh sach tin duoc chon
        $data['ds_duoc_chon'] = $this->content_model->fetch_join_2(
            "a.not_id, a.not_title, a.not_image, a.not_dir_image, s.sho_link, s.domain",
            "LEFT", "tbtt_chontin AS c", "c.not_id = a.not_id",
            "LEFT", "tbtt_shop AS s", "s.sho_user = a.not_user",
            "a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND c.sho_user_2 = " . $idUser,
            "a.not_id",
            "DESC", -1, 0, true
        );
        $data['oloadding'] = true;

        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$idUser.' AND type = '.TYPESHARE_SHOP_HOME);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }

        $data['collection']      = false;
        if(($user_id = $this->session->userdata('sessionUser'))) {
            $select = '*';
            $where = "user_id = $user_id AND type = 1 AND status = 1";
            $order = 'created_at';
            $by = 'DESC';
            $start = -1;
            $limit = 10;
            $distinct = false;
            $data['collection'] = $this->collection_model->fetch_c($select, $where, $order, $by, $start, $limit, $distinct);
            if(count($data['collection']) == 0) {
                $data['collection'] = true;
            } else {
                $list_c = array();
                foreach ($data['collection'] as $key => $value) {
                    array_push($list_c,$value->id);
                    if (!strpos('x'.$value->avatar_path_full, 'https://') !== false || strpos('x'.$value->avatar_path_full, 'http://') !== false) {
                        $data['collection'][$key]->avatar_path_full = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar_path_full;
                    }
                }

                $list_cc = array();
                foreach ($list_c as $key => $value) {
                    $list_cc[$value] = $this->collection_model->fetch_cc('cc_not_id', 'cc_user_id = '. $user_id .' AND cc_coll_id = '. $value, '','','','','' );
                    foreach ($list_cc[$value] as $k => $v) {
                        $list_cc[$value][$k] = $v->cc_not_id;
                    }
                }
                $data['collection_content'] = $list_cc;
            }
        }

        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        //SEO
        $data['type_share']         = TYPESHARE_SHOP_HOME;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingTitle;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = $shop->sho_descr;
        $data['share_url']          = $data['ogurl'];
        $data['share_name']         = $data['ogdescription'];
        $data['page_name']         = 'home_shop';

        $this->load->view('shop/news/defaults', $data);
    }

    public function introduct(){
        $this->_exist_shop();
        $this->set_layout('shop/introduct/page-layout');

        $data['view_type'] = $this->_view_type();
        $shop              = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['linktoshop']         = $linktoshop;
        $data['siteGlobal'] = $shop;
        $follow = 0;
        $this->load->model('follow_shop_model');
        $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$shop->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFollow))
        {
            if($getFollow[0]->hasFollow == 1){
                $follow = 1;
            }
        }
        $data['follow'] = $follow;

        $data['sho_id'] = $shop->sho_id;
        $data['sho_user'] = $shop->sho_user;
        
        $data['province'] = $this->province_model->fetch();
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => $shop->sho_province));
        $data['district_kho'] = $this->district_model->find_by(array('ProvinceCode' => $shop->sho_kho_province));

        // $data['page_view'] = 'image-page';
        $user_id           = (int)$this->session->userdata('sessionUser');
        $group_id          = $this->session->userdata('sessionGroup');
        if($this->session->userdata('sessionUser')){
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite,use_fullname", "use_id = " . $user_id);
        }
        // $this->load->model('timework_model');
        // $data['page_view'] = 'image-page';
        // $get_timework = $this->timework_model->get('*','shop_id = '.$shop->sho_id);
        $data['user_id'] = $user_id;
        $data['shop'] = $shop;
        // $data['get_timework'] = $get_timework[0];

        //Doi ngu cong ty
        $this->load->model('company_team_model');
        $company_team = $this->company_team_model->fetch('*','team_shop = '.$shop->sho_id);
        $data['company_team'] = $company_team;

        $this->load->model('shop_certify_model');
        $certify = $this->shop_certify_model->fetch('*','certify_shop = '.$shop->sho_id);
        $data['certify'] = $certify;


        $this->load->model('shop_customer_model');
        $customer = $this->shop_customer_model->fetch('*','customer_shop = '.$shop->sho_id);
        $data['customer'] = $customer;
        
        $this->load->model('shop_active_model');
        $active_year = $this->shop_active_model->fetch('distinct active_year','active_shop = '.$shop->sho_id, 'active_year');
        $active = $this->shop_active_model->fetch('*, year(active_date) as active_year','active_shop = '.$shop->sho_id . ' AND active_year = '.(int)$active_year[0]->active_year);
        $data['active'] = $active;
        $data['active_year'] = $active_year;
        $data['time_work'] = json_decode($shop->time_work);
        
        // $news_id           = $news_id ? (int)$news_id : null;
        // $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['is_owns'] = $shop->sho_user == $user_id;

        if($data['is_owns']){
            $owns_id = $user_id;
        }
        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_id;
            }
        }
        $data['images'] = '';
        $data['start'] = '';
        $data['page_view'] = 'image-page';
        $ogimage = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$shop->sho_user.' AND type = '.TYPESHARE_SHOP_INTRODUCT);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }

        $data['type_share']             = TYPESHARE_SHOP_INTRODUCT;
        $data['ogurl']              = base_url().'shop/introduct';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = $shop->sho_descr;
        $data['ogimage']            = $ogimage;
        $data['share_url'] = $data['ogurl'];
        $data['share_name'] = 'Trang giới thiệu của '.$shop->sho_name;

        $get_province = $this->province_model->get('pre_name',['pre_id'=>(int)$shop->sho_kho_province]);
        $get_district = $this->district_model->get('DistrictName',array('DistrictCode'=> (int)$shop->sho_kho_district, 'ProvinceCode' => (int)$shop->sho_kho_province));
        $data['address_kho'] = $shop->sho_kho_address.', '.$get_district->DistrictName.', '.$get_province->pre_name;
        $this->load->view('shop/introduct/show', $data);
    }

    public function edit_introduct(){
        $shop = $this->shop_current;
        $result['error'] = true;
        // $data['page_view'] = 'image-page';
        $user_id = (int)$this->session->userdata('sessionUser');
        if($user_id == $shop->sho_user){
            $sho_id = $shop->sho_id;
            $introduct = strip_tags(html_entity_decode($this->input->post('sho_introduct')), '<br>,<br/>,</br>');
            if($this->shop_model->update(['sho_introduction' => $introduct], 'sho_id = '.$sho_id.' AND sho_user = '.$user_id)){
                $result['error'] = false;
            }
        }
        echo json_encode($result);
        die();
    }

    public function edit_contact(){
        $shop = $this->shop_current;
        $result['error'] = true;
        // $data['page_view'] = 'image-page';
        $user_id = (int)$this->session->userdata('sessionUser');
        if($user_id == $shop->sho_user){
            $sho_id = (int)$this->input->post('sho_id');
            $province = (int)$this->input->post('sho_province');
            $district = $this->input->post('sho_district');
            $sho_kho_province = (int)$this->input->post('sho_kho_province');
            $sho_kho_district = $this->input->post('sho_kho_district');

            $sho_links = $this->shop_model->get('sho_link', 'sho_status = 1 and sho_link = "'.$this->input->post('sho_link').'" AND sho_user != '.(int)$shop->sho_user);
            if(empty($sho_links)){
                $update = array(
                    'sho_name' => $this->input->post('sho_name'),
                    'sho_description' => $this->input->post('sho_description'),
                    'sho_keywords' => $this->input->post('sho_keywords'),
                    'sho_link' => $this->input->post('sho_link'),
                    'sho_address' => $this->input->post('sho_address'),
                    'sho_province' => $province,
                    'sho_district' => $district,
                    'sho_kho_address' => $this->input->post('sho_kho_address'),
                    'sho_kho_province' => $sho_kho_province,
                    'sho_kho_district' => $sho_kho_district,
                    'sho_mobile' => $this->input->post('sho_mobile'),
                    'sho_phone' => $this->input->post('sho_phone'),
                    'shop_fax' => $this->input->post('shop_fax'),
                    'sho_email' => $this->input->post('sho_email'),
                    'sho_website' => $this->input->post('sho_website'),
                    'sho_establish' => $this->input->post('sho_establish'),
                    'sho_taxcode' => $this->input->post('sho_taxcode'),
                    'sho_facebook' => $this->input->post('sho_facebook'),
                    'sho_youtube' => $this->input->post('sho_youtube'),
                    'sho_vimeo' => $this->input->post('sho_vimeo'),
                    'permission_email' => $this->input->post('typepost_email'),
                    'permission_mobile' => $this->input->post('typepost_mobile'),
                    'permission_phone' => $this->input->post('typepost_phone'),
                );
                if($this->shop_model->update($update, 'sho_id = '.$sho_id.' AND sho_user = '.$user_id)){
                    // $data['introduct'] = $introduct;
                    $result['error'] = false;
                    $result['message'] = '';
                }
            }else{
                $result['error'] = false;
                $result['message'] = 'Liên kết gian hàng đã tồn tại, vui lòng chọn liên kết khác';
            }
        }
        echo json_encode($result);
        die();
    }

    public function edit_timework(){

        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        $result['error'] = true;
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $sho_id = (int)$this->input->post('sho_id');

            if($this->input->post('status_time') == 1){
                $monday = $this->input->post('monday');
                $tuesday = $this->input->post('tuesday');
                $wednesday = $this->input->post('wednesday');
                $thursday = $this->input->post('thursday');
                $friday = $this->input->post('friday');
                $saturday = $this->input->post('saturday');
                $sunday = $this->input->post('sunday');

                $data = array(
                    'Mon' => $monday,
                    'Tue' => $tuesday,
                    'Wed' => $wednesday,
                    'Thu' => $thursday,
                    'Fri' => $friday,
                    'Sat' => $saturday,
                    'Sun' => $sunday
                );
            }

            $data['type'] = (int)$this->input->post('status_time');
            if($this->session->userdata('sessionUser') && $shop->sho_user == $user_id){
                if($this->shop_model->update(['time_work' => json_encode($data)], 'sho_id = '.$shop->sho_id.' AND sho_user = '.$user_id)){
                    $result['error'] = false;
                }
            }
        }
        echo json_encode($result);
        die();
    }

    public function add_team(){

        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $result['error'] = true;
            $this->load->model('company_team_model');
            $sho_id = (int)$shop->sho_id;
            $team_id = (int)$this->input->post('team_id');

            $company_team = $this->company_team_model->get('*','id = '.$team_id.' AND team_shop = '.$sho_id);
            $this->load->library(['ftp', 'upload']);
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            $this->load->library('image_lib');
            $this->load->library('upload');
            #Create folder

            $imgSrc = $this->input->post('team_avatar');
            $pathImage = 'media/shop/teams';
            $path = '/public_html/media/shop';
            $dir_year = date('Y');
            $dir_month = date('m');
            $dir_day = date('d');
            
            if (!is_dir($pathImage .'/')) {
                @mkdir($pathImage, 0775);
                $this->load->helper('file');
                @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            if (!is_dir($pathImage .'/' . $dir_year)) {
                @mkdir($pathImage .'/' . $dir_year, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
            }

            $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;

            // Upload to other server cloud
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (!in_array('teams', $ldir)) {
                $this->ftp->mkdir($path . '/teams', 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/teams');
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/teams/' . $dir_year, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/teams/' . $dir_year);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/teams/' . $dir_year .'/' . $dir_month, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/teams/' . $dir_year .'/' . $dir_month);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/teams/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
            }
            
            $sCustomerImageName = uniqid() . time() . uniqid();
            $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

            $cus_avatar = $sCustomerImageName.'.'.$type_image;

            $config['upload_path'] = $dir_folder.'/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 5120;#KB
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            
            $data = array(
                'team_name' => $this->input->post('team_name'),
                'team_avatar' => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar,
                'team_role' => $this->input->post('team_role'),
                'team_desc' => $this->input->post('team_desc'),
                'team_facebook' => $this->input->post('team_facebook'),
                'team_twitter' => $this->input->post('team_twitter'),
                'team_linkedin' => $this->input->post('team_linkedin'),
                'team_instagram' => $this->input->post('team_instagram'),
                'team_azibai' => $this->input->post('team_azibai'),
                'team_shop' => $sho_id,
            );

            if (file_exists($dir_folder . '/' . $cus_avatar)) {
                
                if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                    if($this->company_team_model->add($data)){
                        $result['error'] = false;
                    }
                }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function update_team(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $this->load->model('company_team_model');
            
            $sho_id = (int)$shop->sho_id;
            // $data['page_view'] = 'image-page';
            $team_id = (int)$this->input->post('team_id');
            
            $company_team = $this->company_team_model->get('*','id = '.$team_id.' AND team_shop = '.$sho_id);

            $imgSrc = $this->input->post('team_avatar');

            $data = array(
                'team_name' => $this->input->post('team_name'),
                'team_role' => $this->input->post('team_role'),
                'team_desc' => $this->input->post('team_desc'),
                'team_facebook' => $this->input->post('team_facebook'),
                'team_twitter' => $this->input->post('team_twitter'),
                'team_linkedin' => $this->input->post('team_linkedin'),
                'team_instagram' => $this->input->post('team_instagram'),
                'team_azibai' => $this->input->post('team_azibai'),
                'team_shop' => $sho_id
            );

            if($imgSrc != $company_team[0]->team_avatar){

                $this->load->library(['ftp', 'upload']);
                $this->load->library('ftp');

                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port'] = PORT_CLOUDSERVER;
                $config['debug'] = false;
                $this->ftp->connect($config);

                $this->load->library('image_lib');
                $this->load->library('upload');
                #Create folder
                $pathImage = 'media/shop/teams';
                $path = '/public_html/media/shop';

                $arr_image = explode('/', $company_team[0]->team_avatar);
                if(!empty($company_team)){
                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];
                    if($image_name == ''){
                        $dir_year = date('Y');
                        $dir_month = date('m');
                        $dir_day = date('d');
                    }
                }
            
                if (!is_dir($pathImage .'/')) {
                    @mkdir($pathImage, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                if (!is_dir($pathImage .'/' . $dir_year)) {
                    @mkdir($pathImage .'/' . $dir_year, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
                }

                $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;

                // Upload to other server cloud
                $ldir = array();
                $ldir = $this->ftp->list_files($path);
                // if $my_dir name exists in array returned by nlist in current '.' dir
                if (!in_array('teams', $ldir)) {
                    $this->ftp->mkdir($path . '/teams', 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/teams');
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/teams/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/teams/' . $dir_year);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/teams/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/teams/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/teams/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }
                
                $sCustomerImageName = uniqid() . time() . uniqid();
                $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

                $cus_avatar = $sCustomerImageName.'.'.$type_image;

                $config['upload_path'] = $dir_folder.'/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 5120;#KB
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);

                $result['error'] = true;
                $data['team_avatar'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;

                if (file_exists($dir_folder . '/' . $cus_avatar)) {
                    
                    if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                        if($this->company_team_model->update($data, 'id = '.$company_team[0]->id.' AND team_shop = '.$sho_id)){
                            unlink($dir_folder .'/' . $image_name);
                            $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                            $result['error'] = false;
                        }
                    }
                }
            }
            else{
                if($this->company_team_model->update($data, 'id = '.$company_team[0]->id.' AND team_shop = '.$sho_id)){
                        $result['error'] = false;
                    }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    function check_azi(){
        $result['check'] = false;
        $url = $this->input->post('url');
        $check_azi = strpos($url, domain_site);
        if($check_azi > 0){
            if($check_azi <= 8){
                $result['check'] = true;
            }else{
                $arr_url = explode('.', $url);
                $arr_sholink = explode('/', $arr_url[0]);
                $isshop = $this->shop_model->get("sho_id, sho_link, domain", "sho_status = 1 and sho_link = '".$arr_sholink[2]."'");
                if(!empty($isshop)){
                    $result['check'] = true;
                }
            }
        }else{
            $arr_domain = explode('/', $url);
            $where = " AND domain IN('".$arr_domain[2]."', 'http://".$arr_domain[2]."', 'https://".$arr_domain[2]."')";
            $is_domain = $this->shop_model->get("sho_id, sho_link, domain", "sho_status = 1".$where);
            if(!empty($is_domain)){
                $result['check'] = true;
            }
        }
        echo json_encode($result);
        die();
    }

    public function delete_team(){
        $result['error'] = true;
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $this->load->model('company_team_model');
            $sho_id = (int)$shop->sho_id;
            $team_id = (int)$this->input->post('team_id');
            if($user_id == $shop->sho_user){
                $company_team = $this->company_team_model->get('*','id = '.$team_id.' AND team_shop = '.$sho_id);
                if(!empty($company_team)){
                    
                    $this->load->library(['ftp', 'upload']);
                    $this->load->library('ftp');

                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port'] = PORT_CLOUDSERVER;
                    $config['debug'] = false;
                    $this->ftp->connect($config);

                    $this->load->library('image_lib');
                    $this->load->library('upload');
                    #Create folder

                    $pathImage = 'media/shop/teams';
                    $path = '/public_html/media/shop';

                    $arr_image = explode('/', $company_team[0]->team_avatar);

                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;
                    $this->ftp->delete_file($company_team[0]->team_avatar);
                    if($this->company_team_model->delete($team_id)){
                        $result['error'] = false;
                    }
                }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function info_team(){
        $this->load->model('company_team_model');
        $shop = $this->shop_current;
        $sho_id = (int)$shop->sho_id;
        // $data['page_view'] = 'image-page';
        $team_id = (int)$this->input->post('team_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        $company_team = $this->company_team_model->get('*','id = '.$team_id.' AND team_shop = '.$shop->sho_id);
        $result = $company_team[0];
        echo json_encode($result);
        die();
    }

    public function add_certify(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $result['error'] = true;
            $this->load->model('shop_certify_model');
            $sho_id = (int)$shop->sho_id;
            $this->load->library(['ftp', 'upload']);
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            $this->load->library('image_lib');
            $this->load->library('upload');
            #Create folder

            $imgSrc = $this->input->post('certify_avatar');
            $pathImage = 'media/shop/certify';
            $path = '/public_html/media/shop';
            $dir_year = date('Y');
            $dir_month = date('m');
            $dir_day = date('d');
            
            if (!is_dir($pathImage .'/')) {
                @mkdir($pathImage, 0775);
                $this->load->helper('file');
                @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            if (!is_dir($pathImage .'/' . $dir_year)) {
                @mkdir($pathImage .'/' . $dir_year, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
            }

            $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;

            // Upload to other server cloud
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (!in_array('certify', $ldir)) {
                $this->ftp->mkdir($path . '/certify', 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/certify');
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/certify/' . $dir_year, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/certify/' . $dir_year);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/certify/' . $dir_year .'/' . $dir_month, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/certify/' . $dir_year .'/' . $dir_month);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/certify/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
            }
            
            $sCustomerImageName = uniqid() . time() . uniqid();
            $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

            $cus_avatar = $sCustomerImageName.'.'.$type_image;

            $config['upload_path'] = $dir_folder.'/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 5120;#KB
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            $data = array(
                'certify_name' => $this->input->post('certify_name'),
                'certify_avatar' => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar,
                'certify_released' => $this->input->post('certify_released'),
                'certify_year' => $this->input->post('certify_year'),
                'certify_shop' => $sho_id
            );

            if (file_exists($dir_folder . '/' . $cus_avatar)) {
                
                if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                    if($this->shop_certify_model->add($data)){
                        $result['error'] = false;
                    }
                }
            }
        
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function update_certify(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){

            $result['error'] = true;

            $this->load->model('shop_certify_model');
            $sho_id = (int)$shop->sho_id;
            // $data['page_view'] = 'image-page';
            $certify_id = (int)$this->input->post('certify_id');
            $certify = $this->shop_certify_model->get('*','id = '.$certify_id.' AND certify_shop = '.$sho_id);
            $imgSrc = $this->input->post('certify_avatar');
            $data = array(
                'certify_name' => $this->input->post('certify_name'),
                'certify_released' => $this->input->post('certify_released'),
                'certify_year' => $this->input->post('certify_year'),
                'certify_shop' => $sho_id
            );

            if($imgSrc != $certify[0]->certify_avatar){

                $this->load->library(['ftp', 'upload']);
                $this->load->library('ftp');

                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port'] = PORT_CLOUDSERVER;
                $config['debug'] = false;
                $this->ftp->connect($config);

                $this->load->library('image_lib');
                $this->load->library('upload');
                #Create folder

                $pathImage = 'media/shop/certify';
                $path = '/public_html/media/shop';

                $arr_image = explode('/', $certify[0]->certify_avatar);
                if(!empty($certify)){
                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];
                    if($image_name == ''){
                        $dir_year = date('Y');
                        $dir_month = date('m');
                        $dir_day = date('d');
                    }
                }
            
                if (!is_dir($pathImage .'/')) {
                    @mkdir($pathImage, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                if (!is_dir($pathImage .'/' . $dir_year)) {
                    @mkdir($pathImage .'/' . $dir_year, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
                }

                $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;

                // Upload to other server cloud
                $ldir = array();
                $ldir = $this->ftp->list_files($path);
                // if $my_dir name exists in array returned by nlist in current '.' dir
                if (!in_array('certify', $ldir)) {
                    $this->ftp->mkdir($path . '/certify', 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/certify');
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/certify/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/certify/' . $dir_year);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/certify/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/certify/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/certify/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }
                
                $sCustomerImageName = uniqid() . time() . uniqid();
                $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

                $cus_avatar = $sCustomerImageName.'.'.$type_image;

                $config['upload_path'] = $dir_folder.'/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 5120;#KB
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                
                $data['certify_avatar'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;

                if (file_exists($dir_folder . '/' . $cus_avatar)) {
                    
                    if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                        if($this->shop_certify_model->update($data, 'id = '.$certify[0]->id.' AND certify_shop = '.$sho_id)){
                            unlink($dir_folder .'/' . $image_name);
                            $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                            $result['image'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;
                        }
                        $result['error'] = false;
                    }
                }
            }else{
                if($this->shop_certify_model->update($data, 'id = '.$certify[0]->id.' AND certify_shop = '.$sho_id)){
                    $result['error'] = false;
                }
            }
        
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function delete_certify(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $result['error'] = true;
            $this->load->model('shop_certify_model');
            $sho_id = (int)$shop->sho_id;

            $certify_id = (int)$this->input->post('certify_id');
            if($user_id == $shop->sho_user){

                $certify = $this->shop_certify_model->get('*','id = '.$certify_id.' AND certify_shop = '.$sho_id);

                if(!empty($certify)){
                
                    $this->load->library(['ftp', 'upload']);
                    $this->load->library('ftp');

                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port'] = PORT_CLOUDSERVER;
                    $config['debug'] = false;
                    $this->ftp->connect($config);

                    $this->load->library('image_lib');
                    $this->load->library('upload');
                    #Create folder

                    $pathImage = 'media/shop/certify';
                    $path = '/public_html/media/shop';

                    $arr_image = explode('/', $certify[0]->certify_avatar);

                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $dir_folder = $pathImage.'/'.$dir_year.'/'.$dir_month .'/'.$dir_day;
                    $this->ftp->delete_file($certify[0]->certify_avatar);

                    if($this->shop_certify_model->delete($certify_id)){
                        $result['error'] = false;
                        unlink($dir_folder .'/' . $image_name);
                        $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                    }
                }
            }
        
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function info_certify(){
        $this->load->model('shop_certify_model');
        $shop = $this->shop_current;
        $sho_id = (int)$shop->sho_id;
        $certify_id = (int)$this->input->post('certify_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        $certify = $this->shop_certify_model->get('*','id = '.$certify_id.' AND certify_shop = '.$sho_id);
        $result = $certify[0];
        echo json_encode($result);
        die();
    }

    public function add_customer(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');

        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $this->load->model('shop_customer_model');
            $sho_id = (int)$shop->sho_id;

            $video_name = '';

            if(isset($_FILES['customer_video']) && $_FILES['customer_video'] != NULL){
                $video_name = $_FILES['customer_video']['name'];
                $video_tmp = $_FILES['customer_video']['tmp_name'];
                $video_type = explode('/',$_FILES['customer_video']['type'])[1];
                $video_size = $_FILES['customer_video']['size'];
                if($video_size > 104857600) {
                    $message  = 'Vui lòng chọn video dưới 100M';
                    echo $message;
                    die();
                }
            }

            $message = 'Lưu thông tin thất bại';

            $this->load->library(['ftp', 'upload']);
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            $this->load->library('image_lib');
            $this->load->library('upload');
            #Create folder

            $imgSrc = $this->input->post('customer_avatar');
            $folder = 'customer';
            $pathImage = 'media/shop/'.$folder;
            $path = '/public_html/media/shop';

            $dir_year = date('Y');
            $dir_month = date('m');
            $dir_day = date('d');

            $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
            $dir_folder = $pathImage.'/'.$path_folder;
            $path_video = $path.'/'.$folder.'/video/'.$path_folder;

            if (!is_dir($pathImage .'/')) {
                @mkdir($pathImage, 0775);
                $this->load->helper('file');
                @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            if (!is_dir($pathImage .'/' . $dir_year)) {
                @mkdir($pathImage .'/' . $dir_year, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
            }

            // Upload to other server cloud
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (!in_array($folder, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder);
            if (!in_array($dir_year, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year);
            if (!in_array($dir_month, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month);
            if (!in_array($dir_day, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
            }

            if($video_name != ''){
                $ldir = $this->ftp->list_files($path . '/'.$folder.'');
                if (!in_array('video', $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video', 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video');
                if (!in_array($dir_year, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year);
                if (!in_array($dir_month, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir_day, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }
            }

            $ImageName = uniqid() . time() . uniqid();
            $type_image = $this->convertStringToImageFtp($ImageName,$dir_folder.'/',$imgSrc);

            $cus_avatar = $ImageName.'.'.$type_image;

            $config['upload_path'] = $dir_folder.'/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 5120;#KB
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            $data = array(
                'customer_name' => $this->input->post('customer_name'),
                'customer_avatar' => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar,
                'customer_quote' => $this->input->post('customer_quote'),
                'customer_shop' => $sho_id
            );

            if (file_exists($dir_folder . '/' . $cus_avatar)) {
                if($video_name != ''){
                    $video_up_name = $ImageName.'.'.$video_type;
                    $dir_video = $pathImage . '/video/' . $path_folder;
                    $data['customer_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;
                }
                
                if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                    if($video_name != ''){
                        $this->ftp->upload($video_tmp, $path_video .'/' . $video_up_name, 0755);
                    }
                    if($this->shop_customer_model->add($data)){
                        $message = '';
                    }
                }
            }

            echo $message;
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function update_customer(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $this->load->model('shop_customer_model');
            $sho_id = (int)$shop->sho_id;
            // $data['page_view'] = 'image-page';
            $customer_id = (int)$this->input->post('customer_id');

            $customer = $this->shop_customer_model->get('*','id = '.$customer_id.' AND customer_shop = '.$sho_id);
            $imgSrc = $this->input->post('customer_avatar');        
            
            $data = array(
                'customer_name' => $this->input->post('customer_name'),
                'customer_quote' => $this->input->post('customer_quote'),
                'customer_shop' => $sho_id
            );

            $video_name = '';

            if(isset($_FILES['customer_video']) && $_FILES['customer_video'] != NULL){
                $video_name = $_FILES['customer_video']['name'];
                $video_tmp = $_FILES['customer_video']['tmp_name'];
                $video_type = explode('/',$_FILES['customer_video']['type'])[1];
                $video_size = $_FILES['customer_video']['size'];
                if($video_size > 104857600) {
                    $message  = 'Vui lòng chọn video dưới 100M';
                    echo $message;
                    die();
                }
            }

            if($imgSrc != $customer[0]->customer_avatar || $video_name != ''){
                $this->load->library(['ftp', 'upload']);
                $this->load->library('ftp');

                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port'] = PORT_CLOUDSERVER;
                $config['debug'] = false;
                $this->ftp->connect($config);

                $this->load->library('image_lib');
                $this->load->library('upload');
                #Create folder
                $folder = 'customer';
                $pathImage = 'media/shop/'.$folder;
                $path = '/public_html/media/shop';

                if(!empty($customer)){

                    $arr_image = explode('/', $customer[0]->customer_avatar);
                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $arr_video = explode('/', $customer[0]->customer_video);
                    $get_videoname = $arr_video[10];
                    if($image_name == '' || $get_videoname == ''){
                        $dir_year = date('Y');
                        $dir_month = date('m');
                        $dir_day = date('d');
                    }
                }
            
                if (!is_dir($pathImage .'/')) {
                    @mkdir($pathImage, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                if (!is_dir($pathImage .'/' . $dir_year)) {
                    @mkdir($pathImage .'/' . $dir_year, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
                }

                $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
                $dir_folder = $pathImage.'/'.$path_folder;
                $path_video = $path.'/'.$folder.'/video/'.$path_folder;

                // Upload to other server cloud
                $ldir = array();
                $ldir = $this->ftp->list_files($path);
                // if $my_dir name exists in array returned by nlist in current '.' dir
                if (!in_array($folder, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder);
                if (!in_array($dir_year, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year);
                if (!in_array($dir_month, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir_day, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }

                if($video_name != ''){
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'');
                    if (!in_array('video', $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video', 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video');
                    if (!in_array($dir_year, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year, 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year);
                    if (!in_array($dir_month, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month, 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month);
                    if (!in_array($dir_day, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                    }
                }
                
                $ImageName = uniqid() . time() . uniqid();
            }

            if($imgSrc != $customer[0]->customer_avatar){
                $type_image = $this->convertStringToImageFtp($ImageName,$dir_folder.'/',$imgSrc);

                $cus_avatar = $ImageName.'.'.$type_image;

                $config['upload_path'] = $dir_folder.'/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 5120;#KB
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                
                $data['customer_avatar'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;
                $message = 'Lưu thông tin thất bại';

                if (file_exists($dir_folder . '/' . $cus_avatar)) {
                    
                    if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                        unlink($dir_folder .'/' . $image_name);
                        $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                        if($video_name != ''){

                            $video_up_name = $ImageName.'.'.$video_type;
                            $dir_video = $pathImage . '/video/' . $path_folder;
                            $data['customer_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;

                            if($this->ftp->upload($video_tmp, $path_video .'/' . $video_up_name, 0755)){
                                $ldir = $this->ftp->list_files($path_video);
                                if (in_array($get_videoname, $ldir)) {
                                    $this->ftp->delete_file($path_video .'/' . $get_videoname);
                                }
                                if($this->shop_customer_model->update($data, 'id = '.$customer[0]->id.' AND customer_shop = '.$sho_id)){
                                    $message = '';
                                }
                            }
                        }else{
                            if($this->shop_customer_model->update($data, 'id = '.$customer[0]->id.' AND customer_shop = '.$sho_id)){
                                $message = '';
                            }
                        }
                    }
                }
                
            }else{
                if($video_name != ''){
                    $video_up_name = $ImageName.'.'.$video_type;
                    $dir_video = $pathImage . '/video/' . $path_folder;
                    $data['customer_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;

                    if($this->ftp->upload($video_tmp, $path_video.'/' . $video_up_name, 0755)){
                        $ldir = $this->ftp->list_files($path_video);
                        if (in_array($get_videoname, $ldir)) {
                            $this->ftp->delete_file($path_video .'/' . $get_videoname);
                        }
                        if($this->shop_customer_model->update($data, 'id = '.$customer[0]->id.' AND customer_shop = '.$sho_id)){
                            $message = '';
                        }
                    }
                }else{
                    if($this->shop_customer_model->update($data, 'id = '.$customer[0]->id.' AND customer_shop = '.$sho_id)){
                        $message = '';
                    }
                }
            }
        
            echo $message;
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function delete_customer(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $result['error'] = true;
            $this->load->model('shop_customer_model');
            $sho_id = (int)$shop->sho_id;

            $customer_id = (int)$this->input->post('customer_id');
            if($user_id == $shop->sho_user){

                $customer = $this->shop_customer_model->get('*','id = '.$customer_id.' AND customer_shop = '.$sho_id);

                if(!empty($customer)){
                
                    $this->load->library(['ftp', 'upload']);
                    $this->load->library('ftp');

                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port'] = PORT_CLOUDSERVER;
                    $config['debug'] = false;
                    $this->ftp->connect($config);

                    $this->load->library('image_lib');
                    $this->load->library('upload');
                    #Create folder

                    $folder = 'customer';
                    $pathImage = 'media/shop/'.$folder;
                    $path = '/public_html/media/shop';
                    $arr_image = explode('/', $customer[0]->customer_avatar);

                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
                    $dir_folder = $pathImage.'/'.$path_folder;
                    $path_video = $path.'/'.$folder.'/video/'.$path_folder;
                    
                    if($this->shop_active_model->delete($customer_id)){
                        $result['error'] = false;
                        unlink($dir_folder .'/' . $image_name);
                        $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                        if($customer[0]->customer_video != ''){
                            $arr_video = explode('/', $customer[0]->customer_video);
                            $get_videoname = $arr_video[10];
                            $this->ftp->delete_file($path_video.'/' . $get_videoname);
                        }
                    }
                }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function delete_customer_video(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user){
            $result['error'] = true;
            $this->load->model('shop_customer_model');
            $sho_id = (int)$shop->sho_id;

            $customer_id = (int)$this->input->post('customer_id');
            if($user_id == $shop->sho_user){
                $customer = $this->shop_customer_model->get('*','id = '.$customer_id.' AND customer_shop = '.$sho_id);

                if(!empty($customer)){
                
                    $this->load->library(['ftp', 'upload']);
                    $this->load->library('ftp');

                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port'] = PORT_CLOUDSERVER;
                    $config['debug'] = false;
                    $this->ftp->connect($config);

                    $this->load->library('image_lib');
                    $this->load->library('upload');
                    #Create folder

                    $pathImage = 'media/shop/customer';
                    $path = '/public_html/media/shop';

                    $arr_image = explode('/', $customer[0]->customer_avatar);
                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;

                    if($customer[0]->customer_video != ''){
                        $arr_video = explode('/', $customer[0]->customer_video);
                        $get_videoname = $arr_video[10];
                        if($this->ftp->delete_file($path.'/customer/video/' . $path_folder .'/' . $get_videoname))
                        {
                            $data['customer_quote'] = $this->input->post('customer_quote');
                            $data['customer_video'] = '';
                            if($this->shop_customer_model->update($data, 'id = '.$customer_id))
                            {
                                $result['error'] = false;
                            }
                        }
                    }
                }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function info_customer(){
        $this->load->model('shop_customer_model');
        $shop = $this->shop_current;
        $sho_id = (int)$shop->sho_id;
        $customer_id = (int)$this->input->post('customer_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        $customer = $this->shop_customer_model->get('*','id = '.$customer_id.' AND customer_shop = '.$sho_id);
        $result = $customer[0];
        echo json_encode($result);
        die();
    }

    public function add_activities(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');

        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $this->load->model('shop_active_model');
            $sho_id = (int)$shop->sho_id;
            $video_name = '';

            if(isset($_FILES['active_video']) && $_FILES['active_video'] != NULL){
                $video_name = $_FILES['active_video']['name'];
                $video_tmp = $_FILES['active_video']['tmp_name'];
                $video_type = explode('/',$_FILES['active_video']['type'])[1];
                $video_size = $_FILES['active_video']['size'];
                if($video_size > 104857600) {
                    $message  = 'Vui lòng chọn video dưới 100M';
                    echo $message;
                    die();
                }
            }

            $this->load->library(['ftp', 'upload']);
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            $this->load->library('image_lib');
            $this->load->library('upload');
            #Create folder

            $imgSrc = $this->input->post('active_avatar');

            $folder = 'active';
            $pathImage = 'media/shop/'.$folder;
            $path = '/public_html/media/shop';
            
            $dir_year = date('Y');
            $dir_month = date('m');
            $dir_day = date('d');

            $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
            $dir_folder = $pathImage.'/'.$path_folder;
            $path_video = $path.'/'.$folder.'/video/'.$path_folder;

            if (!is_dir($pathImage .'/')) {
                @mkdir($pathImage, 0775);
                $this->load->helper('file');
                @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            if (!is_dir($pathImage .'/' . $dir_year)) {
                @mkdir($pathImage .'/' . $dir_year, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
            }

            if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
            }

            // Upload to other server cloud
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (!in_array($folder, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month, 0775, true);
            }
            $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month);
            if (!in_array($dir, $ldir)) {
                $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
            }

            if($video_name != ''){
                $ldir = $this->ftp->list_files($path . '/'.$folder);
                if (!in_array('video', $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video', 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video');
                if (!in_array($dir_year, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year);
                if (!in_array($dir_month, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir_day, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }
            }
            $ImageName = uniqid() . time() . uniqid();
            $message = 'convert img lỗi';
            $type_image = $this->convertStringToImageFtp($ImageName,$dir_folder.'/',$imgSrc);

            $cus_avatar = $ImageName.'.'.$type_image;

            $config['upload_path'] = $dir_folder.'/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 5120;#KB
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            $date = explode('-',$this->input->post('active_date'));
            $data = array(
                'active_title' => $this->input->post('active_title'),
                'active_avatar' => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar,
                'active_desc' => $this->input->post('active_desc'),
                'active_url' => $this->input->post('active_url'),
                'active_date' => $date[2].'/'.$date[1].'/'.$date[0],
                'active_year' => $date[0],
                'active_at' => (int)$this->input->post('active_at'),
                'active_shop' => $sho_id
            );

            $message = 'Lưu thông tin thất bại';
            if (file_exists($dir_folder . '/' . $cus_avatar)) {
                
                if($video_name != ''){
                    $video_up_name = $ImageName.'.'.$video_type;
                    $dir_video = $pathImage . '/video/' . $path_folder;
                    $data['active_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;
                    $data['active_urlvideo'] = '';
                }else{
                    $data['active_video'] = '';
                    $data['active_urlvideo'] = $this->input->post('active_urlvideo');
                }

                if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                    if($this->shop_active_model->add($data)){
                        if($video_name != ''){
                            $this->ftp->upload($video_tmp, $path_video .'/' . $video_up_name, 0755);
                        }
                        $message = '';
                    }
                }
            }
            echo $message;
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function update_activities(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');

        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $this->load->model('shop_active_model');
            $sho_id = (int)$shop->sho_id;
            $active_id = (int)$this->input->post('active_id');
            $active = $this->shop_active_model->get('*','id = '.$active_id.' AND active_shop = '.$sho_id);
            $imgSrc = $this->input->post('active_avatar');
            $select_video = $this->input->post('select_video');
            $active_urlvideo = $this->input->post('active_urlvideo');

            $date = explode('-',$this->input->post('active_date'));
            $data = array(
                'active_title' => $this->input->post('active_title'),
                'active_desc' => $this->input->post('active_desc'),
                'active_url' => $this->input->post('active_url'),
                'active_date' => $date[2].'/'.$date[1].'/'.$date[0],
                'active_year' => $date[0],
                'active_at' => (int)$this->input->post('active_at'),
                'active_shop' => $sho_id
            );

            $video_name = '';

            if($select_video == 1 && isset($_FILES['active_video']) && $_FILES['active_video'] != NULL){
                $video_name = $_FILES['active_video']['name'];
                $video_tmp = $_FILES['active_video']['tmp_name'];
                $video_type = explode('/',$_FILES['active_video']['type'])[1];
                $video_size = $_FILES['active_video']['size'];
                if($video_size > 104857600) {
                    $message  = 'Vui lòng chọn video dưới 100M';
                    echo $message;
                    die();
                }
            }

            if(($imgSrc != '' && $imgSrc != $active[0]->active_avatar) || $video_name != '' || ($active_urlvideo != '' && $select_video == 0))
            {
                $this->load->library(['ftp', 'upload']);
                $this->load->library('ftp');

                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port'] = PORT_CLOUDSERVER;
                $config['debug'] = false;
                $this->ftp->connect($config);

                $this->load->library('image_lib');
                $this->load->library('upload');
                #Create folder
                $folder = 'active';
                $pathImage = 'media/shop/'.$folder;
                $path = '/public_html/media/shop';

                if(!empty($active)){
                    $arr_image = explode('/', $active[0]->active_avatar);
                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $arr_video = explode('/', $active[0]->active_video);
                    $get_videoname = $arr_video[10];

                    if($image_name == '' || $get_videoname == ''){
                        $dir_year = date('Y');
                        $dir_month = date('m');
                        $dir_day = date('d');
                    }
                }

                $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
                $dir_folder = $pathImage.'/'.$path_folder;
                $path_video = $path.'/'.$folder.'/video/'.$path_folder;
            
                if (!is_dir($pathImage .'/')) {
                    @mkdir($pathImage, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                if (!is_dir($pathImage .'/' . $dir_year)) {
                    @mkdir($pathImage .'/' . $dir_year, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month, 0775);
                }

                if (!is_dir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day)) {
                    @mkdir($pathImage .'/' . $dir_year .'/'.$dir_month .'/'.$dir_day, 0775);
                }

               // Upload to other server cloud
                $ldir = array();
                $ldir = $this->ftp->list_files($path);
                // if $my_dir name exists in array returned by nlist in current '.' dir
                if (!in_array($folder, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month, 0775, true);
                }
                $ldir = $this->ftp->list_files($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month);
                if (!in_array($dir, $ldir)) {
                    $this->ftp->mkdir($path . '/'.$folder.'/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                }
                if($video_name != ''){
                    $ldir = $this->ftp->list_files($path . '/'.$folder);
                    if (!in_array('video', $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video', 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video');
                    if (!in_array($dir_year, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year, 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year);
                    if (!in_array($dir_month, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month, 0775, true);
                    }
                    $ldir = $this->ftp->list_files($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month);
                    if (!in_array($dir_day, $ldir)) {
                        $this->ftp->mkdir($path . '/'.$folder.'/video/' . $dir_year .'/' . $dir_month .'/' . $dir_day, 0775, true);
                    }
                }
                
                $ImageName = uniqid() . time() . uniqid();
            }
            $message = 'Lưu thông tin thất bại';

            if($imgSrc != '' && $imgSrc != $active[0]->active_avatar){
                $type_image = $this->convertStringToImageFtp($ImageName,$dir_folder.'/',$imgSrc);

                $cus_avatar = $ImageName.'.'.$type_image;

                $config['upload_path'] = $dir_folder.'/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 5120;#KB
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                
                $data['active_avatar'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;

                if (file_exists($dir_folder . '/' . $cus_avatar)) {
                    if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                        unlink($dir_folder .'/' . $image_name);
                        $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                        
                        if($video_name != ''){
                            $video_up_name = $ImageName.'.'.$video_type;

                            $dir_video = $pathImage . '/video/' . $path_folder;
                            $data['active_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;
                            $data['active_urlvideo'] = '';

                            if($this->ftp->upload($video_tmp, $path_video .'/' . $video_up_name, 0755)){
                                $ldir = $this->ftp->list_files($path_video);
                                if (in_array($get_videoname, $ldir)) {
                                    $this->ftp->delete_file($path_video .'/' . $get_videoname);
                                }
                                if($this->shop_active_model->update($data, 'id = '.$active[0]->id.' AND active_shop = '.$sho_id))
                                {
                                    $message = '';
                                }
                            }
                        }else{
                            if($this->input->post('active_urlvideo') != ''){
                                $data['active_video'] = '';
                                $data['active_urlvideo'] = $this->input->post('active_urlvideo');
                            }
                            if($this->shop_active_model->update($data, 'id = '.$active[0]->id.' AND active_shop = '.$sho_id)){
                                $message = '';
                            }
                        }
                    }
                }
            }else{
                if($video_name != ''){
                    $video_up_name = $ImageName.'.'.$video_type;
                    $dir_video = $pathImage . '/video/' . $path_folder;
                    $data['active_video'] = DOMAIN_CLOUDSERVER . $dir_video .'/' . $video_up_name;
                    $data['active_urlvideo'] = '';

                    if($this->ftp->upload($video_tmp, $path_video.'/' . $video_up_name, 0755)){
                        $ldir = $this->ftp->list_files($path_video);
                        if (in_array($get_videoname, $ldir)) {
                            if($this->ftp->delete_file($path_video .'/' . $get_videoname)){
                            }
                            else{
                                $message = 'Xóa video thất bại';
                            }
                        }
                        if($this->shop_active_model->update($data, 'id = '.$active[0]->id.' AND active_shop = '.$sho_id)){
                            $message = '';
                        }
                    }
                }else{
                    if($this->input->post('active_urlvideo') != ''){
                        $data['active_video'] = '';
                        $data['active_urlvideo'] = $this->input->post('active_urlvideo');
                        $this->ftp->delete_file($path_video.'/' . $get_videoname);
                    }
                    if($this->shop_active_model->update($data, 'id = '.$active[0]->id.' AND active_shop = '.$sho_id)){
                        $message = '';
                    }
                }
            }

            echo $message;
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function delete_activities(){
        $shop = $this->shop_current;
        $user_id = (int)$this->session->userdata('sessionUser');
        $result['error'] = true;
        if($this->session->userdata('sessionUser') && $user_id == $shop->sho_user)
        {
            $this->load->model('shop_active_model');
            $shop = $this->shop_current;
            $sho_id = (int)$shop->sho_id;

            $active_id = (int)$this->input->post('active_id');
            $user_id = (int)$this->session->userdata('sessionUser');
            if($user_id == $shop->sho_user){
                $active = $this->shop_active_model->get('*','id = '.$active_id.' AND active_shop = '.$sho_id);

                if(!empty($active)){
                
                    $this->load->library(['ftp', 'upload']);
                    $this->load->library('ftp');

                    $config['hostname'] = IP_CLOUDSERVER;
                    $config['username'] = USER_CLOUDSERVER;
                    $config['password'] = PASS_CLOUDSERVER;
                    $config['port'] = PORT_CLOUDSERVER;
                    $config['debug'] = false;
                    $this->ftp->connect($config);

                    $this->load->library('image_lib');
                    $this->load->library('upload');
                    #Create folder
                    $folder = 'active';
                    $pathImage = 'media/shop/'.$folder;
                    $path = '/public_html/media/shop';
                    $arr_image = explode('/', $active[0]->active_avatar);

                    $dir_year = $arr_image[6];
                    $dir_month = $arr_image[7];
                    $dir_day = $arr_image[8];
                    $image_name = $arr_image[9];

                    $path_folder = $dir_year.'/'.$dir_month .'/'.$dir_day;
                    $dir_folder = $pathImage.'/'.$path_folder;
                    $path_video = $path.'/'.$folder.'/video/'.$path_folder;
                    
                    if($this->shop_active_model->delete($active_id)){
                        $result['error'] = false;
                        unlink($dir_folder .'/' . $image_name);
                        $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                        if($active[0]->active_video != ''){
                            $arr_video = explode('/', $active[0]->active_video);
                            $get_videoname = $arr_video[10];
                            // $this->ftp->delete_file($path.'/active/video/' . $get_videoname);
                            $this->ftp->delete_file($path_video.'/' . $get_videoname);
                        }
                    }
                }
            }
            echo json_encode($result);
            die();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    public function info_activities(){
        $this->load->model('shop_active_model');
        $shop = $this->shop_current;
        $sho_id = (int)$shop->sho_id;
        $active_id = (int)$this->input->post('active_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        $active = $this->shop_active_model->get('*','id = '.$active_id.' AND active_shop = '.$sho_id);
        $result = $active[0];
        $date = explode('/',$active[0]->active_date);
        $result->active_date = $date[2].'-'.$date[1].'-'.$date[0];
        echo json_encode($result);
        die();
    }

    public function slider_activities(){
        $this->load->model('shop_active_model');
        $shop = $this->shop_current;
        $active_year = (int)$this->input->post('active_year');
        $active = $this->shop_active_model->fetch('*','active_shop = '.$shop->sho_id . ' AND active_year = '.$active_year);
        $result = $active;
        echo json_encode($result);
        die();
    }

    private function _getListShop($sho_id, $is_owns, $sho_user, $start = false, $limit = 5)
    {
        $group_id = (int)$this->session->userdata('sessionGroup');
        $user_id  = (int)$this->session->userdata('sessionUser');

        $select = 'tbtt_content.*, tbtt_permission.name as not_permission_name, cat_name, sho_name, sho_link, sho_logo, sho_dir_logo, sho_user, sho_mobile, sho_phone, sho_email, sho_facebook, domain';
        $where  = "not_status = 1 AND not_publish = 1 AND id_category = 16 AND sho_status = 1";
        $order  = 'not_ghim DESC, not_id';

        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        if ((int)$page < 1) {
            $page = 1;
        }

        if(!$limit){
            $limit = 5;
        }

        if($start === false){
            $start = ($limit * $page) - $limit;
        }
        $start = (int)$start;

        //sai owner
        $where_permission = ' AND not_permission = 1';
        if ($is_owns) {
            $where_permission = '';
        }
        $where .= $where_permission;


        $get_share_news = 'SELECT not_id FROM tbtt_send_news WHERE status = 1 and user_shop_id = '. $sho_user;
        $query_news  = $this->db->query($get_share_news);
        $result_share = $query_news->result();
        $not_id_share = [];
        if (!empty($result_share))
        {
            foreach ($result_share as $k_share => $v_share)
            {
                $not_id_share[] = $v_share->not_id;
            }
        }

        if (!empty($not_id_share))
        {
            $where .= " AND (tbtt_content.sho_id = ". $sho_id . " OR tbtt_content.not_id IN (" . implode(",",$not_id_share) . "))";
        }
        else
        {
            $where .= " AND tbtt_content.sho_id = ". $sho_id;
        }

        $list_news = $this->content_model->fetch_join_3($select, 'LEFT', 'tbtt_permission', 'tbtt_permission.id = not_permission', 'LEFT', 'tbtt_category', 'cat_id = not_pro_cat_id', 'LEFT', 'tbtt_shop', 'sho_user = not_user', $where, $order, 'DESC', $start, $limit);

        foreach ($list_news as $key => $item) {
            $item->chontin = 0;
            $list_news[$key]->check_quick_view['link'] = false;
            $list_news[$key]->check_quick_view['product'] = false;
            //Dem so luot chon tin
            $query  = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $item->not_id);
            $result = $query->result();
            if (count($result)) {
                $item->solanchon = count($result);
            } else {
                $item->solanchon = 0;
            }
            //Dem binh luan
            $query          = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $item->not_id);
            $result         = $query->result();
            $item->comments = count($result);

            //Dem like
            $list_likes = $this->like_content_model->get('id', ['not_id' => (int) $item->not_id]);
            $item->likes = count($list_likes);

            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_CONTENT.'/'.$item->not_id, []));
            $item->total_share = $jData->data->total_share;

            $item->type_share = TYPESHARE_SHOP_NEWS;
            if ($user_id) {
                //Kiem tra 1 user bat ky da chon tin nay chua
                $query  = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $item->not_id . ' AND sho_user_1 = ' . $user_id);
                $result = $query->result();
                if (count($result)) {
                    $item->dachon = 1;
                } else {
                    $item->dachon = 0;
                }
                
				//User co duoc phep chon tin nay khong
                if (in_array($group_id, json_decode(ListGroupAff, true)) && $item->not_user != $user_id) {
                    $item->chochontin = 1;
                } else {
                    $item->chochontin = 0;
                }

                // đã like
                $is_like = $this->like_content_model->get('id', ['user_id' => $user_id, 'not_id' => (int) $item->not_id]);
                $item->is_like = count($is_like);
            }

            /* Get list product */
            $array = array();
            $aListImage = $this->images_model->get("*",'not_id = '.$item->not_id);
            if(!empty($aListImage)) {
                foreach ($aListImage as $key2 => $oImage) {
                    $array[$key2] = array(
                        $oImage->name,
                        $oImage->product_id,
                        $oImage->title,
                        $oImage->link,
                        $oImage->content,
                        $oImage->style_show,
                        $oImage->link_to,
                        $oImage->tags,
                        $oImage->id,
                        $oImage->link_crop,
                    );
                }
            }

            $listImg = array();
            $listPro = array();

            $this->load->model('detail_product_model');
            $select_hh = 'apply, pro_saleoff, pro_type_saleoff, begin_date_sale, end_date_sale, pro_saleoff_value, af_dc_rate, af_dc_amt, ';

            foreach ($array as $k => $value) {
                if (strlen($value[0]) > 10) {
                    @$listImg[$k]->image = $value[0];
                    if ($value[1] > 0) {

                        $product = $this->product_model->get($select_hh."pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, af_amt, (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int)$value[1]);
                        $detailproduct = $this->detail_product_model->get('count(tbtt_detail_product.dp_pro_id) as have_num_tqc', 'dp_pro_id = '. (int) $value[1]);

                        if (!empty($product)){
                            if ($user_id) {
                                $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$user_id, 'pro_id' => $product->pro_id));
                                if ($selected_sale) {
                                    $product->selected_sale = $selected_sale;
                                }
                            }
                        }
                        @$listImg[$k]->product = $product; 

                        $dataHH = $this->dataGetHH($product);
                        $product->hoahong = $this->checkHH($dataHH);
                        $product->Shopname = $this->get_InfoShop($product->pro_user, 'sho_name')->sho_name;
                        $product->have_num_tqc = $detailproduct->have_num_tqc;

                        @$listPro[$k]          = $product;
                    }
                    @$listImg[$k]->title   = $value[2];
                    @$listImg[$k]->detail  = $value[3];
                    @$listImg[$k]->caption = $value[4];
                    @$listImg[$k]->style   = $value[5];
                    @$listImg[$k]->link_to = json_decode($value[6]);
                    @$listImg[$k]->tags    = json_decode($value[7]);
                    @$listImg[$k]->id      = $value[8];
                    @$listImg[$k]->link_crop      = $value[9];
                }
            }
            $item->listImg = $listImg;
            $item->listPro = $listPro;
            //Get content link
            $item->not_customlink = $this->link_library->link_of_news($item->not_id, '', 0, 0, 0, $is_owns);

            if(!empty($item->listPro)){
                $list_news[$key]->check_quick_view['product'] = true;
            }
            if(!empty($item->not_customlink)){
                $list_news[$key]->check_quick_view['link'] = true;
            }

            if($item->not_video_url1 && strlen($item->not_video_url1) <= 11){
                $item->video_id = $item->not_video_url1;
                $aVideos = $this->videos_model->find_where('id = '.((int)$item->not_video_url1), [], 'object');
                if(!empty($aVideos)){
                    $item->not_video_url1 = $aVideos->name;
                    $item->poster = $aVideos->thumbnail ? (DOMAIN_CLOUDSERVER . $aVideos->path . $aVideos->thumbnail): DEFAULT_IMAGE_ERROR_PATH;
                }
            }

            $follow = 0;
            $status_follow = array();
            $this->load->model('follow_shop_model');
            $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$item->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
            
            $status_follow['follow_shop'] = 0;
            if (!empty($getFollow))
            {
                if($getFollow[0]->hasFollow == 1){
                    $status_follow['follow_shop'] = 1;
                }
            }
            $item->follow = $status_follow;

            // get mention user
            $mentions = $this->content_model->get_mention_by_content_id($item->not_id);
            $list_news[$key]->mentions = $mentions;
        }

        // get Suggest
        if($this->session->userData("sessionUser") && !empty($list_news)) {
            // include api
            $this->load->file(APPPATH.'controllers/home/api_content.php', false);
            // end
            $suggest_list = Api_content::suggest_in_newsfeed();
            foreach ($suggest_list as $key => $suggest) {
                if($suggest['offset'] <= ($page * $limit) && $suggest['offset'] > $start && $suggest['offset'] > 0) {
                    if($suggest['offset'] <= (1 * $limit)) {
                        $off_set_list_news = $suggest['offset'] - 1;
                    } else {
                        $off_set_list_news = ($limit - ($page * $limit) % $suggest['offset'] - 1);
                    }
                    $html = $this->load->view('home/tintuc/goiy_choban', ['suggest'=>$suggest, 'page'=>$page], TRUE);

                    if(!empty($list_news[$off_set_list_news])) {
                        $list_news[$off_set_list_news]->suggest_list[] = $html;
                    }
                }
            }
        }


        return $list_news;
    }

    public function ajax_pop_load_image_lib()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $owns_id = (int)$this->session->userdata('sessionUser');
            $album_id = false;
            // Kiểm tra trang hiện tại có bé hơn 1 hay không
            $page = (int)$this->input->post('page');
            $typeIMG = (int)$this->input->post('typeIMG');
            if(!in_array($typeIMG, [IMAGE_UP_DETECT_LIBRARY, IMAGE_UP_DETECT_CONTENT])){
                echo ''; die;
            }

            if ($page < 1) {
                $page = 1;
            }

            // Số record trên một trang
            $limit = 10;

            // Tìm start
            $start = ($limit * $page) - $limit;

            // $image = $this->content_model->shop_news_list_image($this->shop_current->sho_id, $limit, $start, $owns_id, false, [], 0, $this->shop_current->sho_user);
            $image = $this->content_model->shop_news_list_image_type($this->shop_current->sho_id, $limit, $start, $owns_id, false, [], 0, $this->shop_current->sho_user, $typeIMG);

            $arr = [];

            // xài trong chỉnh xữa album
            $album_id = $this->input->post('album_id');
            if($album_id) {
                $x=1;
                $query = $this->db->query("SELECT ref_item_id FROM tbtt_album_media_detail WHERE ref_album_id = $album_id");
                $result = $query->result();
                $temp = [];
                foreach ($result as $key => $value) {
                    array_push($temp, $value->ref_item_id);
                }
                $arr['key_imgs'] = $temp;
            }
            $html = '';
            foreach ($image as $key => $item) {
                $arr['item'] = $item;
                $html .= $this->load->view('shop/media/album/html/item-img-pop-lib', $arr, true);
            }
            echo $html;
            die;
        }
    }

    public function ajax_process_album_image($process = 'create')
    {
        if ($process == 'create' && $this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            // ------------------------------------------------------------------------
            $data_ref_id = [];
            $data_src_image_resize = [];
            // ------------------------------------------------------------------------
            $data_input = json_decode($this->input->post('data_input'));
            $data_img_lib = json_decode($this->input->post('data_img_lib'));
            $album_ava = $this->input->post('album_ava');
            $album_from = $this->input->post('album_from');
            $album_name = $this->input->post('album_name');
            $album_des = $this->input->post('album_des');
            $album_permission = (int)$this->input->post('album_permission');
            $album_type = (int)$this->input->post('album_type');
            ## record image update title
            $record_sub_updates = json_decode($this->input->post('data_sub_input_upload'));
            ##
            // ------------------------------------------------------------------------
            // data submit
            $dataRequest_Album = [
                'album_name' => $album_name,
                'album_description' => $album_des,
                'album_image' => FALSE,
                'album_path_image' => FALSE,
                'album_path_full' => FALSE,
                'album_type' => $album_type,
                'album_status' => 1,
                'album_permission' => $album_permission,
                'ref_shop_id' => (int)$this->shop_current->sho_id,
                'ref_user' => (int)$this->shop_current->sho_user
            ];
            // ------------------------------------------------------------------------

            $filepath = '/public_html/media/images/album/';
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            #Create folder
            $pathImage = '/public_html/tmp';
            $path = '/public_html/media/images/album';
            $dir = date('Y').'/'.date('m').'/'.date('d');
            // Upload to other server cloud
            $ldir = array();
            // if $my_dir name exists in array returned by nlist in current '.' dir
            $ldir = $this->ftp->list_files($path);
            if (!in_array(date('Y'), $ldir)) {
                $this->ftp->mkdir($path . '/'.date('Y'), 0775);
            }
            $ldir = $this->ftp->list_files($path. '/'.date('Y'));
            if (!in_array(date('m'), $ldir)) {
                $this->ftp->mkdir($path . '/'.date('Y').'/'.date('m'), 0775);
            }
            $ldir = $this->ftp->list_files($path .'/'.date('Y').'/'.date('m'));
            if (!in_array(date('d'), $ldir)) {
                $this->ftp->mkdir($path .'/'.date('Y').'/'.date('m').'/'.date('d'), 0775);
            }

            //xử lý data album ảnh
            if($album_ava != '' && $album_from != '' && in_array($album_from, ['input','library'])){
                if($album_from == 'input'){
                    $item_img_avata = '';
                    foreach ($data_input as $key => $value) {
                        if(strcmp($album_ava, $value->dataImg) == 0) {
                            // 2 strings
                            $item_img_avata = array_shift(array_splice($data_input, $key, 1));
                            break;
                        };
                    }
                    if($item_img_avata != '') {
                        if($this->ftp->move($pathImage . '/' . $item_img_avata->dataImg, $path . '/' . $dir .'/' . $item_img_avata->dataImg)){
                            $data_image = array(
                                'name'              =>  $item_img_avata->dataImg,
                                'user_id'           =>  (int)$this->session->userdata('sessionUser'),
                                'product_id'        =>  0,
                                'created_at'        =>  date('Y-m-d h:i:s'),
                                'img_w'             =>  $item_img_avata->dataImg_w,
                                'img_h'             =>  $item_img_avata->dataImg_h,
                                'img_type'          =>  $item_img_avata->dataType,
                                'updated_at'        =>  date('Y-m-d h:i:s'),
                                'img_up_detect'     =>  IMAGE_UP_DETECT_LIBRARY,
                                'img_up_by_shop'    =>  $this->shop_current->sho_id,
                                'img_library_dir'   =>  $dir,
                                'img_library_title' =>  $item_img_avata->dataTitle,
                            );
                            if($this->images_model->add($data_image)){
                                $img_id = $this->db->insert_id();
                                array_push($data_ref_id, $img_id);

                                $dataRequest_Album['album_image'] = $album_ava;
                                $dataRequest_Album['album_path_image'] = 'media/images/album/'.$dir.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            } else {
                                echo 0; die;
                            }
                        } else {
                            echo 0; die;
                        }
                    } else {
                        echo 0; die;
                    }
                } else if($album_from == 'library'){
                    if(is_numeric($album_ava)){
                        $id_img = (int)$album_ava;
                        $dataGetImage = array_shift($this->images_model->getImageAndDir($id_img));
                        if(!empty($dataGetImage)) {
                            if($dataGetImage->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                                $dataRequest_Album['album_image'] = $dataGetImage->name;
                                $dataRequest_Album['album_path_image'] = 'media/images/album/'.$dataGetImage->img_library_dir.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            } else {
                                $dataRequest_Album['album_image'] = $dataGetImage->name;
                                $dataRequest_Album['album_path_image'] = 'media/images/content/'.$dataGetImage->not_dir_image.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            }
                        } else {
                            echo 0; die;
                        }
                    } else {
                        echo 0; die;
                    }
                } else {
                    echo 0; die;
                }
            }

            //xử lý ảnh chọn trong thư viên
            if(count($data_img_lib) > 0) {
                foreach ($data_img_lib as $key => $value) {
                    $data_img_lib[$key] = (int)$value;
                }
                $temp = array_merge($data_ref_id, $data_img_lib);
                $data_ref_id = $temp;
            }

            //xử lý ảnh upload
            if(count($data_input) > 0) {
                foreach ($data_input as $key => $input) {
                    /**
                     * $input->dataImg
                     * $input->dataImg_w
                     * $input->dataImg_h
                     * $input->dataType
                     * $input->dataTitle
                     */
                    if($this->ftp->move($pathImage . '/' . $input->dataImg, $path . '/' . $dir .'/' . $input->dataImg)) {
                        $data_image = array(
                            'name'              =>  $input->dataImg,
                            'user_id'           =>  (int)$this->session->userdata('sessionUser'),
                            'product_id'        =>  0,
                            'created_at'        =>  date('Y-m-d h:i:s'),
                            'img_w'             =>  $input->dataImg_w,
                            'img_h'             =>  $input->dataImg_h,
                            'img_type'          =>  $input->dataType,
                            'updated_at'        =>  date('Y-m-d h:i:s'),
                            'img_up_detect'     =>  IMAGE_UP_DETECT_LIBRARY,
                            'img_up_by_shop'    =>  $this->shop_current->sho_id,
                            'img_library_dir'   =>  $dir,
                            'img_library_title' =>  $input->dataTitle,
                        );
                        if($this->images_model->add($data_image)){
                            $img_id = $this->db->insert_id();
                            array_push($data_ref_id, $img_id);
                        } else {
                            echo 0; die;
                        }
                    }
                }
            }

            //tạo bộ Album
            if($this->album_model->add($dataRequest_Album)){
                $album_id = $this->db->insert_id();
                $data_item_detail = [];
                foreach ($data_ref_id as $key => $id) {
                    $data_item_detail[] = [
                        'ref_album_id' => $album_id,
                        'ref_item_id' => $id,
                        'ref_user' => $this->shop_current->sho_user,
                        'ref_shop_id' => $this->shop_current->sho_id
                    ];
                }
                $this->db->insert_batch('tbtt_album_media_detail', $data_item_detail);

                // update lại title của hình nếu hình đó nằm trong library được up từ thiết bị
                if($record_sub_updates != '' && !empty($record_sub_updates) && is_array($record_sub_updates)) {
                    $arr_img = [];
                    foreach ($record_sub_updates as $key => $value) {
                        $arr_img[] = array('id'=>$value->id, 'img_library_title'=>$value->title);
                    }
                    $this->images_model->updateIn($arr_img, 'id');
                }
                echo 1; die;
            } else {
                echo 0; die;
            }
        }
        else if ($process == 'update' && $this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            //data will be processed
            $data_input = json_decode($this->input->post('data_input'));
            $data_img_update = json_decode($this->input->post('data_img_update'));
            $data_key_img = json_decode($this->input->post('data_key_img'));

            //data album
            $album_id = $this->input->post('album_id');
            $album_ava = $this->input->post('album_ava');
            $album_from = $this->input->post('album_from');
            $album_name = $this->input->post('album_name');
            $album_des = $this->input->post('album_des');
            $album_permission = (int)$this->input->post('album_permission');
            $album_type = (int)$this->input->post('album_type');
            // ------------------------------------------------------------------------
            // data submit
            $dataRequest_Album = [
                'album_id'  =>  $album_id,
                'album_name' => $album_name,
                'album_description' => $album_des,
                'album_image' => FALSE,
                'album_path_image' => FALSE,
                'album_path_full' => FALSE,
                'album_type' => $album_type,
                'album_status' => 1,
                'album_permission' => $album_permission,
                'ref_shop_id' => (int)$this->shop_current->sho_id,
                'ref_user' => (int)$this->shop_current->sho_user
            ];

            $filepath = '/public_html/media/images/album/';
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            #Create folder
            $pathImage = '/public_html/tmp';
            $path = '/public_html/media/images/album';
            $dir = date('Y').'/'.date('m').'/'.date('d');
            // Upload to other server cloud
            $ldir = array();
            // if $my_dir name exists in array returned by nlist in current '.' dir
            $ldir = $this->ftp->list_files($path);
            if (!in_array(date('Y'), $ldir)) {
                $this->ftp->mkdir($path . '/'.date('Y'), 0775);
            }
            $ldir = $this->ftp->list_files($path. '/'.date('Y'));
            if (!in_array(date('m'), $ldir)) {
                $this->ftp->mkdir($path . '/'.date('Y').'/'.date('m'), 0775);
            }
            $ldir = $this->ftp->list_files($path .'/'.date('Y').'/'.date('m'));
            if (!in_array(date('d'), $ldir)) {
                $this->ftp->mkdir($path .'/'.date('Y').'/'.date('m').'/'.date('d'), 0775);
            }

            //xử lý data album ảnh
            if($album_ava != '' && $album_from != '' && in_array($album_from, ['input','library'])){
                if($album_from == 'input'){
                    $item_img_avata = '';
                    foreach ($data_input as $key => $value) {
                        if(strcmp($album_ava, $value->dataImg) == 0) {
                            // 2 strings
                            $item_img_avata = array_shift(array_splice($data_input, $key, 1));
                            break;
                        };
                    }
                    if($item_img_avata != '') {
                        if($this->ftp->move($pathImage . '/' . $item_img_avata->dataImg, $path . '/' . $dir .'/' . $item_img_avata->dataImg)){
                            $data_image = array(
                                'name'              =>  $item_img_avata->dataImg,
                                'user_id'           =>  (int)$this->session->userdata('sessionUser'),
                                'product_id'        =>  0,
                                'created_at'        =>  date('Y-m-d h:i:s'),
                                'img_w'             =>  $item_img_avata->dataImg_w,
                                'img_h'             =>  $item_img_avata->dataImg_h,
                                'img_type'          =>  $item_img_avata->dataType,
                                'updated_at'        =>  date('Y-m-d h:i:s'),
                                'img_up_detect'     =>  IMAGE_UP_DETECT_LIBRARY,
                                'img_up_by_shop'    =>  $this->shop_current->sho_id,
                                'img_library_dir'   =>  $dir,
                                'img_library_title' =>  $item_img_avata->dataTitle,
                            );
                            if($this->images_model->add($data_image)){
                                $img_id = $this->db->insert_id();
                                array_push($data_key_img, $img_id);

                                $dataRequest_Album['album_image'] = $album_ava;
                                $dataRequest_Album['album_path_image'] = 'media/images/album/'.$dir.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            } else {
                                echo 0; die;
                            }
                        } else {
                            echo 0; die;
                        }
                    } else {
                        echo 0; die;
                    }
                } else if($album_from == 'library'){
                    if(is_numeric($album_ava)){
                        $id_img = (int)$album_ava;
                        $dataGetImage = array_shift($this->images_model->getImageAndDir($id_img));
                        if(!empty($dataGetImage)) {
                            if($dataGetImage->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                                $dataRequest_Album['album_image'] = $dataGetImage->name;
                                $dataRequest_Album['album_path_image'] = 'media/images/album/'.$dataGetImage->img_library_dir.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            } else {
                                $dataRequest_Album['album_image'] = $dataGetImage->name;
                                $dataRequest_Album['album_path_image'] = 'media/images/content/'.$dataGetImage->not_dir_image.'/';
                                $dataRequest_Album['album_path_full'] = DOMAIN_CLOUDSERVER . $dataRequest_Album['album_path_image'] . $dataRequest_Album['album_image'];
                            }
                        } else {
                            echo 0; die;
                        }
                    } else {
                        echo 0; die;
                    }
                } else {
                    echo 0; die;
                }
            }

            //xử lý ảnh upload
            if(count($data_input) > 0) {
                foreach ($data_input as $key => $input) {
                    /**
                     * $input->dataImg
                     * $input->dataImg_w
                     * $input->dataImg_h
                     * $input->dataType
                     * $input->dataTitle
                     */
                    if($this->ftp->move($pathImage . '/' . $input->dataImg, $path . '/' . $dir .'/' . $input->dataImg)) {
                        $data_image = array(
                            'name'              =>  $input->dataImg,
                            'user_id'           =>  (int)$this->session->userdata('sessionUser'),
                            'product_id'        =>  0,
                            'img_w'             =>  $input->dataImg_w,
                            'img_h'             =>  $input->dataImg_h,
                            'img_type'          =>  $type_image,
                            'updated_at'        =>  date('Y-m-d h:i:s'),
                            'img_up_detect'     =>  IMAGE_UP_DETECT_LIBRARY,
                            'img_up_by_shop'    =>  $this->shop_current->sho_id,
                            'img_library_dir'   =>  $dir,
                            'img_library_title' =>  $input->dataTitle,
                        );
                        if($this->images_model->add($data_image)){
                            $img_id = $this->db->insert_id();
                            array_push($data_key_img, $img_id);
                        } else {
                            echo 0; die;
                        }
                    }
                }
            }

            // updated bộ Album
            if($this->album_model->update($dataRequest_Album, "album_id = $album_id")){
                $data_item_detail = [];
                foreach ($data_key_img as $key => $id) {
                    $data_item_detail[] = [
                        'ref_album_id' => $album_id,
                        'ref_item_id' => $id,
                        'ref_user' => (int)$this->shop_current->sho_user,
                        'ref_shop_id' => (int)$this->shop_current->sho_id
                    ];
                }
                // xóa tất cả các record cũ
                $this->db->delete('tbtt_album_media_detail', array('ref_album_id' => $album_id, 'ref_user' => (int)$this->shop_current->sho_user, 'ref_shop_id' => (int)$this->shop_current->sho_id));
                // insert lại record mơi
                $this->db->insert_batch('tbtt_album_media_detail', $data_item_detail);
                // ------------------------------------------------------------------------
                // update lại title của hình nếu hình đó nằm trong library được up từ thiết bị
                $dataUpdateImage = []; // data này chỉ chứa những hình mà user up lên trong lúc tạo album image
                if(!empty($data_img_update)){
                    foreach ($data_img_update as $key => $item) {
                        array_push($dataUpdateImage, ['id'=>$item->id, 'img_library_title'=>$item->title]);
                    }
                    $this->images_model->updateIn($dataUpdateImage, 'id');
                }
                echo 1; die;
            } else {
                echo 0; die;
            }
        }
        else {
            echo 0; die;
        }
    }

    /**
     * @param $shop_id
     * @param int $user_id
     * @return bool
     */
    private function _user_is_follow_shop($shop_id, $user_id = 0)
    {
        //cần xem lại logic follow shop, user follow shop id chứ không phải follow user
        if(!$user_id){
            $user_id = $this->session->userdata('sessionUser');
            if(!$user_id)
                return false;
        }
        $this->load->model('follow_shop_model');
        $getFollow  = $this->follow_shop_model->get('*', [
            'shop_id'  => (int)$shop_id,
            'follower' => (int)$user_id
        ]);
        if (!empty($getFollow)) {
            if($getFollow[0]->hasFollow == 1){
                return true;
            }
        }
        return false;
    }

    public function ajax_set_album_to_top()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $album_id = $this->input->post('album_id');
            $album_off_set = $this->input->post('album_offset');
            $album_type = $this->input->post('album_type');
            $album_user = (int)$this->session->userdata('sessionUser');

            if(!in_array($album_type, [ALBUM_IMAGE, ALBUM_PRODUCT, ALBUM_VIDEO, ALBUM_COUPON])) {
                echo 0; die;
            }
            $date_time_update = date("Y-m-d h:i:s");

            if($album_type == ALBUM_IMAGE) {
                $field = 'album_id';
                $select = '*';
                $where = 'album_type = '.$album_type.' AND ref_user = '.$album_user.' AND ref_shop_id = '. (int)$this->shop_current->sho_id;
                $data = $this->album_model->fetch($select, $where);
                foreach ($data as $key => $value) {
                    if($value->album_id == $album_id) {
                        $data[$key]->album_offset_top = 1;
                    } else {
                        $data[$key]->album_offset_top = 0;
                    }
                    $data[$key]->album_updated = $date_time_update;
                }

                if($this->album_model->update_multi($data, 'album_id')){
                    echo 1; die;
                }
                echo 0; die;
            }

            if($album_type == ALBUM_PRODUCT) {
                echo 1; die;
            }

            if($album_type == ALBUM_VIDEO) {
                echo 1; die;
            }

            if($album_type == ALBUM_COUPON) {
                echo 1; die;
            }
        }
        echo 0; die;
    }

    public function ajax_delete_album()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $album_id = $this->input->post('album_id');
            $album_type = $this->input->post('album_type');
            $ref_user = (int)$this->session->userdata('sessionUser');
            $ref_shop_id = (int)$this->shop_current->sho_id;

            if($this->album_model->get('*',"album_id = $album_id AND album_type = $album_type AND ref_user = $ref_user AND ref_shop_id = $ref_shop_id")){
                if($this->album_model->delete($album_id, 'album_id')){
                    $this->db->where_in('ref_album_id', $album_id);
                    $this->db->delete('tbtt_album_media_detail');
                    echo 1; die;
                }
            } else {
                echo 0; die;
            }
        }
        echo 0; die;
    }

    public function ajax_get_info_album()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $album_id = $this->input->post('album_id');
            $album_type = $this->input->post('album_type');
            $ref_user = (int)$this->session->userdata('sessionUser');
            $ref_shop_id = (int)$this->shop_current->sho_id;

            $album_info = $this->album_model->get('*',"album_id = $album_id AND album_type = $album_type AND ref_user = $ref_user AND ref_shop_id = $ref_shop_id");
            if(empty($album_info)){
                echo 0; die;
            }
            $album_items = $this->album_model->get_detail_data_album($ref_user, $ref_shop_id, $album_type, $album_id);
            // $lib_images = $this->content_model->shop_news_list_image($ref_shop_id, $limit = 10, $start = 0, $ref_user, false, [], 0, $ref_user);
            $lib_images_content = $this->content_model->shop_news_list_image_type($ref_shop_id, $limit = 10, $start = 0, $ref_user, false, [], 0, $ref_user, IMAGE_UP_DETECT_CONTENT);
            $lib_images_upload = $this->content_model->shop_news_list_image_type($ref_shop_id, $limit = 10, $start = 0, $ref_user, false, [], 0, $ref_user, IMAGE_UP_DETECT_LIBRARY);


            $query = $this->db->query("SELECT ref_item_id FROM tbtt_album_media_detail WHERE ref_album_id = $album_id AND ref_user = $ref_user AND ref_shop_id = $ref_shop_id");
            $result = $query->result();
            $temp = [];
            foreach ($result as $key => $value) {
                array_push($temp, $value->ref_item_id);
            }
            $arr = [
                'key_imgs' => $temp,
                'album_items'=>$album_items,
                'album_info'=>$album_info,
                // 'lib_images'=>$lib_images
                'lib_images_content'=>$lib_images_content,
                'lib_images_upload'=>$lib_images_upload
                ];

            $html = '';
            $html = $this->load->view('shop/media/album/html/html-popup-edit-album-image', $arr, true);

            // $html_item = '';
            // foreach ($album_items as $key => $item) {
            //     $html_item .= $this->load->view('shop/media/album/html/edit-item-in-library', ['item'=>$item,'album_info'=>$album_info], true);
            // }
            echo $html; die;
        } else {
            echo 0; die;
        }
    }

    public function ajax_openPopupGhim()
    {
        if($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ){
            $img_id = $this->input->post('img_id');
            $album_type = $this->input->post('album_type');
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = (int)$this->shop_current->sho_id;

            $album_has = $this->album_model->get_data_album_with_id($img_id, $album_type, $user_id, $shop_id);
            $temp_arr = [];
            foreach ($album_has as $key => $album) {
                array_push($temp_arr, $album->album_id);
            }

            $album_all = $this->album_model->get_album_with_total($user_id, $shop_id, $album_type);
            if(!empty($album_all)) {
                foreach ($album_all as $key => $album) {
                    if(in_array($album->album_id, $temp_arr)) {
                        $album->checked = true;
                    } else {
                        $album->checked = false;
                    }
                }
                $html = "";
                $html = $this->load->view('shop/media/album/html/html-popup-img-ghim-album', ['albums'=>$album_all], true);
                echo $html; die;
            } else {
                $html = "";
            }
        } else {
            echo 0; die;
        }
    }

    public function ajax_pin_to_album()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = $this->shop_current->sho_id;

            $arr_album = json_decode($this->input->post('album_id'));
            $img_id = (int)$this->input->post('img_id');
            //data image thêm/xóa vào album
            $data_image = array_shift($this->images_model->getImageAndDir($img_id));

            // lấy tất cả album user
            $data_albums_current = $this->album_model->get_album_with_total($user_id, $shop_id, ALBUM_IMAGE);

            // xóa record ảnh nằm trong tất cả album doanh nghiệp
            $this->db->delete('tbtt_album_media_detail', array('ref_item_id' => $img_id, 'ref_user' => $user_id, 'ref_shop_id' => $shop_id));

            // update record in tbtt_album_media_detail;
            $__tbtt_album_media_detail_insert = [];
            $__tbtt_album_media_update = [];
            $__tbtt_album_media_delete = [];

            foreach ($data_albums_current as $key => $album) {
                if(in_array($album->album_id,$arr_album)){
                    // thêm new row vào album
                    $__tbtt_album_media_detail_insert[] = [
                        'ref_album_id'  => $album->album_id,
                        'ref_item_id'   => $img_id,
                        'ref_user'      => $user_id,
                        'ref_shop_id'   => $shop_id
                    ];
                } else {
                    // (xác định album nào đang làm lấy hình đó đang làm avatar) lấy image ra khỏi album, check album null
                    if(strcmp($album->album_image, $data_image->name) == 0) {
                        // giống nhau
                        // check data in album has more 1 record
                        if($album->total == 1) {
                            // xóa album này
                            array_push($__tbtt_album_media_delete, $album->album_id);
                        } else if($album->total > 1) {
                            unset($album->total);
                            // cập nhật lại avatar
                            $image_new = $this->images_model->getFirstImgAlbum($album->album_id, $user_id, $shop_id);
                            if($image_new->img_up_detect == IMAGE_UP_DETECT_CONTENT) {
                                $album->album_image = $image_new->name;
                                $album->album_path_image = "media/images/content/$image_new->not_dir_image/";
                                $album->album_path_full = DOMAIN_CLOUDSERVER . $album->album_path_image . $album->album_image;
                                $album->album_updated = date("Y-m-d h:i:s");
                            } else if($image_new->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                                $album->album_image = $image_new->name;
                                $album->album_path_image = "media/images/album/$image_new->img_library_dir/";
                                $album->album_path_full = DOMAIN_CLOUDSERVER . $album->album_path_image . $album->album_image;
                                $album->album_updated = date("Y-m-d h:i:s");
                            } else {
                                echo 0; die;
                            }
                            // data image update
                            $__tbtt_album_media_update[] = $album;
                        }
                    }
                }
            }

            // process data in mysql
            if(!empty($__tbtt_album_media_delete)) {
                $this->album_model->delete($__tbtt_album_media_delete,'album_id');
            }
            if(!empty($__tbtt_album_media_update)) {
                $this->album_model->update_multi($__tbtt_album_media_update, 'album_id');
            }
            if(!empty($__tbtt_album_media_detail_insert)) {
                // insert lại record mơi
                $this->db->insert_batch('tbtt_album_media_detail', $__tbtt_album_media_detail_insert);
            }
            echo 1; die;
        } else {
            echo 0; die;
        }
    }

    public function ajax_remove_file()
    {
        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = $this->shop_current->sho_id;
            $img_id = (int)$this->input->post('img_id');
            $data_image = array_shift($this->images_model->getImageAndDir($img_id));
            if(empty($data_image)) {
                echo 0; die;
            }

            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port'] = PORT_CLOUDSERVER;
            $config['debug'] = false;
            $this->ftp->connect($config);

            if($data_image->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                $filepath = '/public_html/media/images/album/' . $data_image->img_library_dir;
            } else {
                echo 0; die;
            }

            if($this->ftp->delete_file($filepath . '/' . $data_image->name)) {
                // lấy tất cả album user
                $data_albums_current = $this->album_model->get_album_with_total($user_id, $shop_id, ALBUM_IMAGE);
                // xóa record image
                $this->images_model->delete($data_image->id, 'id');
                // xóa tất cả các record cũ
                $this->db->delete('tbtt_album_media_detail', array('ref_item_id' => $img_id, 'ref_user' => $user_id, 'ref_shop_id' => $shop_id));

                $__tbtt_album_media_delete = [];
                $__tbtt_album_media_update = [];
                if(!empty($data_albums_current)){
                    foreach ($data_albums_current as $key => $album) {
                        // (xác định album nào đang làm lấy hình đó đang làm avatar) lấy image ra khỏi album, check album null
                        if(strcmp($album->album_image, $data_image->name) == 0) {
                            // giống nhau
                            // check data in album has more 1 record
                            if($album->total == 1) {
                                // xóa album này
                                array_push($__tbtt_album_media_delete, $album->album_id);
                            } else if($album->total > 1) {
                                unset($album->total);
                                // cập nhật lại avatar
                                $image_new = $this->images_model->getFirstImgAlbum($album->album_id, $user_id, $shop_id);
                                if($image_new->img_up_detect == IMAGE_UP_DETECT_CONTENT) {
                                    $album->album_image = $image_new->name;
                                    $album->album_path_image = "media/images/content/$image_new->not_dir_image/";
                                    $album->album_path_full = DOMAIN_CLOUDSERVER . $album->album_path_image . $album->album_image;
                                    $album->album_updated = date("Y-m-d h:i:s");
                                } else if($image_new->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                                    $album->album_image = $image_new->name;
                                    $album->album_path_image = "media/images/album/$image_new->img_library_dir/";
                                    $album->album_path_full = DOMAIN_CLOUDSERVER . $album->album_path_image . $album->album_image;
                                    $album->album_updated = date("Y-m-d h:i:s");
                                } else {
                                    echo 0; die;
                                }
                                // data image update
                                $__tbtt_album_media_update[] = $album;
                            }
                        }
                    }
                    if(!empty($__tbtt_album_media_delete)) {
                        $this->album_model->delete($__tbtt_album_media_delete,'album_id');
                    }
                    if(!empty($__tbtt_album_media_update)) {
                        $this->album_model->update_multi($__tbtt_album_media_update, 'album_id');
                    }
                }

                echo 1; die;
            } else {
                echo 0; die;
            }
        } else {
            echo 0; die;
        }
    }

    public function ajax_up_file(){

        $result['message']  = 'Lỗi kết nối';
        $result['error']     = true;

        if ($this->input->is_ajax_request() && ($this->shop_current->sho_user == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = $this->shop_current->sho_id;
            if(isset($_FILES['image']) && !empty($_FILES['image'])){
                $filepath = '/public_html/media/images/album/';
                $this->load->library(['ftp', 'image_lib', 'upload']);
                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port'] = PORT_CLOUDSERVER;
                $config['debug'] = false;
                $this->ftp->connect($config);

                #Create folder
                $pathImage = 'media/images/album/';
                $path = '/public_html/tmp';
                $dir_image = $this->session->userdata('sessionUsername');

                if (!is_dir($pathImage)) {
                    @mkdir($pathImage, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                if (!is_dir($pathImage . $dir_image)) {
                    @mkdir($pathImage . $dir_image, 0775);
                    $this->load->helper('file');
                    @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
                }

                // upload ảnh
                $image = $_FILES['image'];
                $exif = exif_read_data($image['tmp_name']); //thông tin tấm ảnh

                if($image['size'] > 5242880) { #byte
                    $result['message']  = 'Hình ảnh '.$image['name'].' quá lớn!';
                    $result['error']     = true;
                    echo json_encode($result);
                    die();
                }
                $config['upload_path'] = $pathImage . $dir_image . '/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 5120;#KByte
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploadData = $this->upload->data();
                    // scale ảnh
                    $config_compression['image_library'] = 'gd2';
                    $config_compression['source_image'] = $pathImage . $dir_image . '/' . $uploadData['file_name'];
                    $config_compression['maintain_ratio'] = true;
                    $config_compression['quality'] = '60%';
                    $config_compression['width'] = $uploadData['image_width'] - 1;
                    $config_compression['height'] = $uploadData['image_height'] - 1;
                    if($exif && $exif['Orientation'] != false) {
                        if(in_array($exif['Orientation'], [7,8])) {
                            // phải xoay qua từ phải -> trái 270
                            // trong php xoay ngược chiều kim đồng hồ trái -> phải => xoay trái sang phải 90
                            $config_compression['rotation_angle'] = 90;
                        } else if(in_array($exif['Orientation'], [3,4])) {
                            // phải xoay qua từ phải -> trái 180
                            // trong php xoay ngược chiều kim đồng hồ trái -> phải => xoay trái sang phải 180
                            $config_compression['rotation_angle'] = 180;
                        } else if(in_array($exif['Orientation'], [5,6])) {
                            // phải xoay qua từ phải -> trái 90
                            // trong php xoay ngược chiều kim đồng hồ trái -> phải => xoay trái sang phải 270
                            $config_compression['rotation_angle'] = 270;
                        }
                    }
                    $this->image_lib->initialize($config_compression);
                    if ($this->image_lib->resize()) {
                        $this->image_lib->rotate();
                        // đẩy lên sv hình
                        if(file_exists($pathImage . $dir_image .'/'. $uploadData['file_name'])){
                            $this->ftp->upload($pathImage . $dir_image .'/'. $uploadData['file_name'], $path .'/'. $uploadData['file_name'], 'auto', 0775);
                            $result['message']      = 'Thêm hình thành công!';
                            $result['error']        = false;
                            $result['image_name']   = $uploadData['file_name'];
                            $result['image_type']   = $uploadData['file_type'];
                            $result['image_w']      = $uploadData['image_width'] - 1;
                            $result['image_h']      = $uploadData['image_height'] - 1;
                            $result['image_url']    = DOMAIN_CLOUDSERVER . 'tmp/' .$uploadData['file_name'];
                            echo json_encode($result); die;
                        }
                    }
                } else {
                    $result['message']  = 'Quá trình Upload hình '.$image['name'].'bị lỗi';
                    $result['error']     = true;
                    echo json_encode($result); die;
                }

                echo json_encode($result); die;
            }
        } else {
            echo json_encode($result); die;
        }
    }

    public function detail_album_image($album_id = 0)
    {
        $this->_exist_shop();
        $this->set_layout('shop/media/media-layout');
        $data['view_type'] = $this->_view_type();
        $shop              = $data['siteGlobal'] = $this->shop_current;

        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop.'/library/images';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = $shop->sho_descr;
        $data['ogimage']            = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop->sho_dir_banner . '/' . $shop->sho_banner;
        $data['linktoshop']         = $linktoshop;

        $follow = 0;
        $this->load->model('follow_shop_model');
        $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$shop->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFollow))
        {
            if($getFollow[0]->hasFollow == 1){
                $follow = 1;
            }
        }
        $data['follow'] = $follow;
        $data['sho_id'] = $shop->sho_id;

        // $data['page_view'] = 'image-page';
        $user_id           = (int)$this->session->userdata('sessionUser');
        $group_id          = $this->session->userdata('sessionGroup');
        // $news_id           = $news_id ? (int)$news_id : null;
        // $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['is_owns'] = $shop->sho_user == $user_id;

        if($data['is_owns']){
            $owns_id = $user_id;
        }
        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
                $owns_id = $user_id;
            }
        }

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');

        if ($page < 1) {
            $page = 1;
        }

        // Số record trên một trang
        $limit = 10;

        // Tìm start
        $start = ($limit * $page) - $limit;

        $image = $this->content_model->shop_news_list_image($shop->sho_id, $limit, $start, $owns_id, false, $arr_relation, $album_id, $shop->sho_user);
        $data['album'] = $this->db->get_where('tbtt_album_media', array('album_id' => $album_id))->row();
        $data['album_total'] = $this->db->select('count(*) as total')->get_where('tbtt_album_media_detail', array('ref_album_id' => $album_id, 'ref_user' => $shop->sho_user, 'ref_shop_id' => $shop->sho_id))->row()->total;

        $this->load->model('like_image_model');

        foreach ($image as $index => $item) {
            if($this->session->userdata('sessionUser')){
                //active user like
                $is_like = $this->like_image_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'image_id' => (int) $item->id]);
                $image[$index]->is_like = count($is_like);
            }
            //get total like
            $list_likes = $this->like_image_model->get('id', ['image_id' => (int) $item->id]);
            $image[$index]->likes = count($list_likes);
            
            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_IMAGE.'/'.$item->id, []));
            $image[$index]->total_share = $jData->data->total_share;
        }
        $data['images'] = $image;
        $data['start'] = $start;
        $data['page_view'] = 'image-page';
        $data['share_url'] = base_url().'library/images/view-album/'.$album_id;
        $data['share_name'] = 'Thư viện ảnh của '.$shop->sho_name;

        // $data['albums'] = $this->album_model->get_album_with_total($this->shop_current->sho_user, $this->shop_current->sho_id, IMAGE_UP_DETECT_LIBRARY);

        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/image-items', $data, true);
            die();
        }else{
            $this->load->view('shop/media/pages/media-image', $data);
        }


        // echo $album_id ;die();
    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Get price affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    private function getPriceAffiliate($id,$iUserId = 0) {
        $this->load->model('package_model');
        $this->load->model('affiliate_price_model');
        
        $aPack = array();
        if($iUserId == 0) {
            $iUserId = (int)$this->session->userdata('sessionUser');
        }
        
        if($iUserId == '' || $iUserId == 0){
           die('co loi');
        }
        $oAffUser = $this->user_model->get("affiliate_level,parent_id","use_id = " . $iUserId);
        $aPack = $this->package_model->get_one(array('where' => 'package.id = '.$id));

        if(!empty($aPack)) {
            // Ưu tiên 1 : lấy giá và cấp trên set cho nó
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$aPack['info_id'].' && user_set = '.$oAffUser->parent_id.' && user_app = '.$iUserId.' && id_level = '.$oAffUser->affiliate_level);
            // Ưu tiên 2 : Nếu ưu tiên 1 ko có thì lấy giá của đại lý cấp trên set cho toàn bộ affiliate cùng cấp
            if(empty($aAffPrice)) {
                $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$aPack['info_id'].' && user_set = '.$oAffUser->parent_id.' && user_app = 0 && id_level = '.$oAffUser->affiliate_level);
            }
            // Ưu tiên 3 : nếu cả 2 cái trên không có thì lấy giá azibai set cho affiliate cùng cấp
            if(empty($aAffPrice)) {
                $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$aPack['info_id'].' && user_set = 0 && user_app = 0 && id_level = '.$oAffUser->affiliate_level);
            }
            // Ưu tiên 4 : nếu ko set giá thì lấy giá gốc
            if(!empty($aAffPrice)) {
                $aPack['discount_price']    = $aAffPrice['discount_price'];
                $aPack['discount_percen']   = $aAffPrice['discount_percen'];
                $aPack['discount_rate']     = $aAffPrice['cost'] - $aAffPrice['discount_price'];
            }else {
                $aPack['discount_price']    = $aPack['month_price'];
                $aPack['discount_rate']     = 0;
                $aPack['discount_percen']   = 0;
            }
        }
        return $aPack;
    }

    /**
     ***************************************************************************
     * Created: 2019/05/13
     * Page service
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function shopServices() {
        $user_login  = MY_Loader::$static_data['hook_user'];
        if(empty($user_login)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $limit = 10;
        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $data = Api_affiliate::get_list_service_azibai($page, $limit);

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

        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        $data['user_infomation'] = $user_login;

        // $this->set_layout('shop/media/media-layout');
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('shop/service/index', $data);
    }


    function upPackage()
    {
        $this->load->model('package_user_model');
        
        if ($_REQUEST['errorCode'] == 0 && !empty($_REQUEST['orderId']) && !empty($_REQUEST['signature'])) 
        {
            $orderId = str_replace('Azibai-','',$_REQUEST['orderId']);
            $getOrder = $this->package_user_model->get('*', ['id' => (int) $orderId]);
            if (!empty($getOrder) && empty($getOrder->payment_status)) 
            {
                $endpoint = END_POINT;
                $partnerCode = PARTNER_CODE;
                $accessKey = ACCESS_KEY;
                $serectkey = SERECT_KEY;
                $orderid = $_REQUEST['orderId'];
                $requestId = $_REQUEST['orderId'];
                $requestType = "transactionStatus";
                $rawHash = "partnerCode=".$partnerCode."&accessKey=".$accessKey."&requestId=".$requestId."&orderId=".$orderid. "&requestType=" . $requestType;
                $signature = hash_hmac("sha256", $rawHash, $serectkey);
                $data_mono =  array(
                    'partnerCode' => $partnerCode,
                    'accessKey' => $accessKey,
                    'requestId' => $requestId,
                    'orderId' => $orderid,
                    'requestType' => $requestType,
                    'signature' => $signature
                );
                $result_momo = $this->execPostRequest($endpoint, json_encode($data_mono));

                if (!empty($result_momo) && empty($result_momo['errorCode'])) 
                {  
                    $this->load->model('package_user_model');
                    $this->package_user_model->updateOrder($getOrder->id, 1);
                } 
            }
            
        }
        exit();
    }


    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    /**
     ***************************************************************************
     * Created: 2019/05/13
     * Shop Buy Services Success
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function shopServicesSuccess() {

        // debug
        // $user_login  = MY_Loader::$static_data['hook_user'];
        // if(empty($user_login)){
        //     redirect(base_url() . 'page-not-found', 'location');
        //     exit();
        // }
        $data['msg'] = 1;

        if (!empty($_REQUEST['extraData']))
        {
            $extraData = explode(';', $_REQUEST['extraData']);
            if (!empty($extraData))
            {
                foreach ($extraData as $key => $value)
                {
                    $getData = explode('=', $value);
                    if (count($getData) == 2)
                    {
                        $data[$getData[0]] = $getData[1];
                    }
                }
            }
        }

        if (!empty($_REQUEST['package'])) 
        {
            $data['package'] = $_REQUEST['package'];
        }

        if (!empty($_REQUEST['name'])) 
        {
            $data['name'] = $_REQUEST['name'];
        }

        
        if (!empty($_REQUEST['orderId']) || !empty($_REQUEST['order_code'])) 
        {

            $orderId = !empty($_REQUEST['orderId']) ? str_replace('Azibai-','',$_REQUEST['orderId']) :  str_replace('Azibai-','',$_REQUEST['order_code']);

            $getOrder = $this->package_user_model->get('*', ['id' => (int) $orderId]);


            if (!empty($getOrder)) 
            {
                $data['msg'] = $getOrder->payment_status == 1 ? 2 : 1;
                $data['amount'] = $_REQUEST['amount'];

                if ($getOrder->type_payment == 1 && empty($getOrder->payment_status)) 
                {
                    $endpoint = END_POINT;
                    $partnerCode = PARTNER_CODE;
                    $accessKey = ACCESS_KEY;
                    $serectkey = SERECT_KEY;
                    $orderid = 'Azibai-'.$getOrder->id;
                    $requestId = 'Azibai-'.$getOrder->id;
                    $requestType = "transactionStatus";
                    $rawHash = "partnerCode=".$partnerCode."&accessKey=".$accessKey."&requestId=".$requestId."&orderId=".$orderid. "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $serectkey);
                    $data_momo =  array(
                        'partnerCode' => $partnerCode,
                        'accessKey' => $accessKey,
                        'requestId' => $requestId,
                        'orderId' => $orderid,
                        'requestType' => $requestType,
                        'signature' => $signature
                    );
                    $result_momo = $this->execPostRequest($endpoint, json_encode($data_momo));

                    $result_momo = json_decode($result_momo);
                    if (!empty($result_momo) && empty($result_momo->errorCode)) 
                    {
                        $this->load->model('package_user_model');
                        $orderId = str_replace('Azibai-','',$result_momo->orderId);
                        $this->package_user_model->updateOrder($orderId, 1);
                        $data['msg']  = 2;
                    }
                }
                else if (($getOrder->type_payment == 2 || $getOrder->type_payment == 3) && empty($getOrder->payment_status) && !empty($_REQUEST['token']))
                {

                    $this->load->model('nganluong_model');

                    if (!empty($data['sho_id'])) 
                    {
                        $shop_nganluong = $this->shop_nganluong_model->get('*', 'sho_id =' . (int) $data['sho_id']);
                        if (!empty($shop_nganluong)) 
                        {
                            $this->nganluong_model->set_variable($shop_nganluong->merchant_id, $shop_nganluong->merchant_pass, $shop_nganluong->receiver);
                            $nl_result = $this->nganluong_model->GetTransactionDetail($_REQUEST['token']);
                        }
                    } 
                    else 
                    {
                        $nl_result = $this->nganluong_model->GetTransactionDetail($_REQUEST['token']);
                    }

                    if (!empty($nl_result) && $nl_result->error_code == '00') 
                    {
                        $this->load->model('package_user_model');
                        if (!empty($nl_result->order_code)) 
                        {
                            $orderId = str_replace('Azibai-','',$nl_result->order_code);
                            $this->package_user_model->updateOrder($orderId, 1);
                            $data['msg']  = 2;
                        }
                    }
                }
            }
        }

        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end

        // $this->set_layout('shop/media/media-layout');
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('shop/service/success', $data);
    }


    public function shopCancelNotify() {

        // debug
        // $user_login  = MY_Loader::$static_data['hook_user'];
        // if(empty($user_login)){
        //     redirect(base_url() . 'page-not-found', 'location');
        //     exit();
        // }
        $data['msg'] = 1;

        if (!empty($_REQUEST['extraData']))
        {
            $extraData = explode(';', $_REQUEST['extraData']);
            if (!empty($extraData))
            {
                foreach ($extraData as $key => $value)
                {
                    $getData = explode('=', $value);
                    if (count($getData) == 2)
                    {
                        $data[$getData[0]] = $getData[1];
                    }
                }
            }
        }

        if (!empty($_REQUEST['package'])) 
        {
            $data['package'] = $_REQUEST['package'];
        }

        if (!empty($_REQUEST['name'])) 
        {
            $data['name'] = $_REQUEST['name'];
        }
        
        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        
        // $this->set_layout('shop/media/media-layout');
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('shop/service/success', $data);
    }




    /**
     ***************************************************************************
     * Created: 2019/05/13
     * Page service
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function shopServicesDetail($service_id)
    {
        // làm data thanh toán
        $user_login  = MY_Loader::$static_data['hook_user'];
        if(empty($user_login)){
            $this->session->set_userdata('urlservice', 'shop/service/detail/'.$service_id.'?af_id='.$_REQUEST['af_id']);

            $oAffUserP = $this->user_model->get('use_id','af_key = "' . $_REQUEST['af_id'] .'"');
            if(isset($oAffUserP->use_id)) {
                $this->session->set_userdata('parent_invited', $oAffUserP->use_id);
            }
            
            redirect(base_url() . 'login', 'location');
            exit();
        }

        $iUserId = $this->checkCalculateA($user_login,$_REQUEST['af_id']);
        
        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);

        $data['service'] = Api_affiliate::get_detail_service($service_id, $iUserId, 1);
        
        $type_affiliate = 1;
        $data['service_payment'] = [
            'id' => $data['service']['id'],
            'name' => $data['service']['name'],
            'info_id' => $data['service']['iInfoId'],
            'discount_price' => $data['service']['iDiscountPrice'],
            'month_price' => $data['service']['iPrice'],
            'iUserId' => $iUserId,
            'type_affiliate' => $type_affiliate,
            'discount_type' => $data['service']['iDiscountType'],
        ];

        // END: làm data thanh toán

        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        $this->load->model('like_service_model');
        //Dem like
        $list_likes = $this->like_service_model->get('id', ['service_id' => (int)$service_id]);
        // đã like
        $is_like = $this->like_service_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'service_id' => (int)$service_id]);
        $data['list_likes'] = count($list_likes);
        $data['is_like'] = count($is_like);
        $ogimage = base_url().'templates/home/styles/images/svg/bg_dichvu.png';
        $ogurl = base_url().'shop/service/detail/'.$service_id;
        if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
            $ogurl .= '?af_id='.$_REQUEST['af_id'];
        }
        $data['sho_user']         = '';
        $data['type_share']         = TYPESHARE_AZI_SERVICE;
        $data['ogimage']            = $ogimage;
        // $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        // $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $ogurl;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = 'Dịch vụ azibai';
        $data['ogdescription']      = $data['service']['name'];
        
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];

        // $this->set_layout('shop/media/media-layout');
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('shop/service/detail', $data);
    }

    public function shopServicesDetail_bak($id) {
        if(isset($_REQUEST['af_id'])) {
            $oAffUser = $this->user_model->get('parent_id,affiliate_level,use_id','af_key = "' . $_REQUEST['af_id'].'"');
            $parent_id = $oAffUser->use_id;
        }
        $user_login  = MY_Loader::$static_data['hook_user'];
        if(empty($user_login)){
            $this->session->set_userdata('urlservice', 'shop/service/detail/'.$id.'?af_id='.$_REQUEST['af_id']);
            redirect(base_url() . 'login', 'location');
            exit();
        }

        $this->data['user_infomation'] = $user_login;
        $this->load->model('package_model');
        $this->load->model('affiliate_price_model');
        $data['iUserId'] = 0;
        $affiliate_level = 0;
        $parent_id       = 0;
        $data['service'] = $this->package_model->get_one(
            array('where' => 'tbtt_package.id = '.$id)
        );

        $oAffUserP = $this->user_model->get('parent_id,affiliate_level,use_id','use_id = "' . $user_login['parent_id'] .'"');

        if(!empty($oAffUserP) && $oAffUserP->affiliate_level != 0) {
            $oAffUser = $oAffUserP;
        }
        
        if(!empty($oAffUser)) {
            $data['iUserId'] = $oAffUser->use_id;
            $affiliate_level = $oAffUser->affiliate_level;
            $parent_id       = $oAffUser->parent_id;
        }

        // Nếu nó là affiliate thì lấy thông tin của nó cho giá giảm
        if($user_login['affiliate_level'] != 0) {

            $data['iUserId'] = $user_login['use_id'];
            $affiliate_level = $user_login['affiliate_level'];
            $parent_id       = $user_login['parent_id'];
        }

        // Nếu user chưa thuộc về ai thì sẽ set cho affiliate gửi link làm người quản lý
        if($user_login['parent_id'] == 1336 || $user_login['parent_id'] == 0) {
            $this->user_model->update_where(['parent_id' => $parent_id], ['use_id' => $user_login['use_id']]);
        }

        // Ưu tiên 1 : lấy giá và cấp trên set cho nó
        $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$data['service']['info_id'].' && user_app = '.$parent_id.' && id_level = '.$affiliate_level);

        // Ưu tiên 2 : Nếu ưu tiên 1 ko có thì lấy giá của đại lý cấp trên set cho toàn bộ affiliate cùng cấp
        if(empty($aAffPrice)) {
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$data['service']['info_id'].' && user_set = '.$parent_id.' && user_app = 0 && id_level = '.$affiliate_level);
        }
        // Ưu tiên 3 : nếu cả 2 cái trên không có thì lấy giá azibai set cho affiliate cùng cấp
        if(empty($aAffPrice)) {
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$data['service']['info_id'].' && user_set = 0 && user_app = 0 && id_level = '.$affiliate_level);
        }
        
        // Ưu tiên 4 : nếu ko set giá thì lấy giá gốc
        if(empty($aAffPrice)) {
            $data['service']['discount_price'] = 0;
        }else {
            $data['service']['discount_price'] = $aAffPrice['discount_price'];
            $data['service']['discount_rate']  = $oService['month_price'] - $aAffPrice['discount_price'];
        }

        $data['top_loadding'] = true;

        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        $this->load->model('like_service_model');
        //Dem like
        $list_likes = $this->like_service_model->get('id', ['service_id' => (int)$id]);
        // đã like
        $is_like = $this->like_service_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'service_id' => (int)$id]);
        $data['list_likes'] = count($list_likes);
        $data['is_like'] = count($is_like);
        $ogimage = base_url().'templates/home/styles/images/svg/bg_dichvu.png';
        $ogurl = base_url().'shop/service/detail/'.$id;
        if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
            $ogurl .= '?af_id='.$_REQUEST['af_id'];
        }
        $data['sho_user']         = '';
        $data['type_share']         = TYPESHARE_AZI_SERVICE;
        $data['ogimage']            = $ogimage;
        // $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        // $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $ogurl;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = 'Dịch vụ azibai';
        $data['ogdescription']      = $data['service']['name'];
        
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];

        // $this->set_layout('shop/media/media-layout');
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('shop/service/detail', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/14
     * Page service
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function shopServicesUse() {
        $user_login  = MY_Loader::$static_data['hook_user'];
        if(empty($user_login)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        $shop = $this->shop_model->get("*", "sho_user = " . $user_login['use_id']);
        
        $this->load->model('package_user_model');
        $this->load->model('package_service_model');

        $data['services'] = $this->package_user_model->listerUsingPage($user_login['use_id']);
        if(!empty($data['services'])) {
            foreach ($data['services'] as $iKey => $oService) {
                $unit = $this->package_service_model->get_unit(array('where' => 'package_id ='.$oService['package_id']));
                if(!empty($unit)) {
                    $data['services'][$iKey]['unit'] = $unit['unit'];
                }
            }
        }
        $this->set_layout('shop/media/media-layout');
        $this->load->view('shop/service/serviceuse', $data);
    }

    /**
     * 
     */
    public function branch()
    {
        //check exist shop
        $this->_exist_shop();
        $this->set_layout('shop/branch/main-layout');
        $shop                       = $data['siteGlobal'] = $this->shop_current;
        $data['aliasDomain']        = $shop->shop_url;
        $linktoshop                 = substr($data['aliasDomain'], 0, -1);
        $data['linktoshop']         = $linktoshop;
        $data['follow']             = $this->_user_is_follow_shop($shop->sho_id);
        $data['sho_id']           = $shop->sho_id;
        $data['page_view']          = 'image-page';
        $user_id                    = (int)$this->session->userdata('sessionUser');
        $group_id                   = $this->session->userdata('sessionGroup');
        $data['is_owns']            = $shop->sho_user == $user_id;
        if($group_id == StaffStoreUser){
            if(($user_staff = $this->user_model->find_where(['use_id' => $user_id, 'parent_id' => $shop->sho_user], ['select' => 'use_id']))){
                $data['is_owns'] = true;
            }
        }

        $data['sho_user']           = $shop->sho_user;
        // $data['type_share']         = TYPESHARE_SHOP_LIBIMAGE;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = ($shop->sho_description != '') ? $shop->sho_description : settingDescr;
        $data['keywordsSiteGlobal'] = $shop->sho_keywords;
        $data['ogurl']              = $linktoshop . '/page-business';
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $shop->sho_name;
        $data['ogdescription']      = 'Thư viện ảnh của '.$this->shop_current->sho_name;

        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];



        $data['province'] = $this->province_model->fetch();
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => $shop->sho_province));

        $get_province = $this->province_model->get('pre_name',['pre_id'=>(int)$shop->sho_province]);
        $get_district = $this->district_model->get('DistrictName',array('DistrictCode'=> (int)$shop->sho_district, 'ProvinceCode' => (int)$shop->sho_province));
        $data['province_name'] = $get_province->pre_name;
        $data['district_name'] = $get_district->DistrictName;



        $this->load->model('user_model');
        if (!empty($data['list_bran'])) 
        {
            foreach ($data['list_bran'] as $key => $value) 
            {
                $get_province = $this->province_model->get('pre_name',['pre_id'=>(int)$value->sho_province]);
                $get_district = $this->district_model->get('DistrictName',array('DistrictCode'=> $value->sho_district, 'ProvinceCode' => (int)$value->sho_province));

                $data['list_bran'][$key]->province_name = !empty($get_province->pre_name) ? $get_province->pre_name : '';
                $data['list_bran'][$key]->district_name = !empty($get_district->DistrictName) ? $get_district->DistrictName : '';
            }
        }

        $this->load->view('shop/branch/page/page-home', $data);
    }

    private function checkCalculateA($aUser = array(), $af_key = '') {
        $iUserId = $aUser['use_id'];
        $aUserSystem = array(0,1336);
        // Tính hoa hồng cho người giới thiệu đầu tiên nếu nó thuộc về azibai
        if(in_array($aUser['parent_id'],$aUserSystem)) {
            $iUserId = $aUser['parent_id'];
            if(isset($aUser['parent_invited']) && $aUser['parent_invited'] != 0) {
                $aOrder = $this->package_user_model->getwhere('*','user_id = '. $aUser['use_id'] .' AND payment_status = 1');
                if(empty($aOrder)) {
                    return $aUser['parent_invited'];
                }
            }

            if($af_key != '') {
                $oAffUserP = $this->user_model->get('use_id','af_key = "' . $af_key .'"');
                if(isset($oAffUserP->use_id)) {
                    return $oAffUserP->use_id;
                }
            }

            if($aUser['affiliate_level'] != 0) {
                return $aUser['use_id'];
            }

            return $iUserId;
        }

        // Tính hoa hồng cho user khác

        if($af_key != '') {
            $oAffUserP = $this->user_model->get('use_id','af_key = "' . $af_key .'"');
            if(isset($oAffUserP->use_id)) {
                $iUserId = $oAffUserP->use_id;
            }
        }

        return $iUserId;
    }
}
