<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal extends MY_Controller
{
    public $info_public = [];
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
        #CHECK SETTINGstatisticlistshopinvite_tree
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }

        #END CHECK LOGIN
        #Load language
        $this->load->model('domains_model');
        $this->config->load('config_api');

        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
        }

        $this->load->model('user_model');

        $oDomain = $this->domains_model->get( '*','domain LIKE "%'.$_SERVER['HTTP_HOST'].'%" AND domain_type = 1');
        if(!empty($oDomain)) {
            $user_id = $oDomain->userid;
        } elseif($this->uri->segment(1) == 'affiliate') { // afffiliate
            $user_id = $this->session->userdata('sessionUser');
        }elseif ($this->uri->segment(2) == 'user') {
            $user_id = (int)$this->uri->segment(3);//user get profile
        } else {
            $user_id = (int)$this->uri->segment(2);//user get profile
            
            //lay use_id khi user da doi use_slug
            $user_slug = $this->uri->segment(2);
            $find_slug = $this->user_model->get('use_id', 'use_slug = "'.$user_slug.'"');
            if(!empty($find_slug)){
                $user_id = (int)$find_slug->use_id;//user get profile
            }
        }
        $this->load->model('blockuser_model');
        $getBlock = $this->blockuser_model->get('*', '(blocked_by = '.(int)$user_id.' AND user_id = '.(int)$this->session->userdata('sessionUser').')');

        if (!empty($getBlock))
        {
            echo "<script>alert('Bạn không thể truy cập trang này do cài đặt của chủ sở hữu'); window.location.href = '".base_url()."'</script>";
            // redirect(base_url(), 'location');
        }else{
            $userBlock = $this->blockuser_model->get('*', '(user_id = '.(int)$user_id.' AND blocked_by = '.(int)$this->session->userdata('sessionUser').')');
            $data['userBlock'] = $userBlock;
            $this->lang->load('home/personal');
            $this->load->model('user_follow_model');
            $this->load->model('province_model');
            $this->load->model('district_model');
            $this->load->model('shop_model');
            $this->load->model('content_model');
            $this->load->model('category_model');
            $this->load->model('collection_model');
            $this->load->library('Mobile_Detect');
            $this->load->model('images_model');
            $this->load->model('album_model');

            if($user_id){
                if(empty($this->info_public) && $user_id){
                    $this->info_public = $this->_get_profile_user($user_id);
                }
                if(!empty($this->info_public['my_shop'])){
                    $data['shop'] = $this->info_public['my_shop'];
                }
            }
            $data['current_profile'] = $this->info_public;

            $this->load->vars($data);
        }
    }

    //trang chủ cá nhan | tường cá nhân
    //layout home/personal/profile-layout
    public function profile()
    {
        if(empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $this->load->model('category_link_model');
        $this->load->model('friend_model');
        $this->load->model('collection_model');
        $this->load->model('follow_model');
        $this->load->model('link_model');
        $this->set_layout('home/personal/profile-layout');
        $is_owner           = false;
        $info_public        = $this->info_public;
        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';

        if($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')){
            $is_owner = true;
        }
        if($info_public['use_province']){
            $info_public['province'] = $this->province_model->find_where(
                ['pre_status'   => 1, 'pre_id' => $info_public['use_province']],
                ['select'       => 'pre_id, pre_name']
            );
        }
        if ($info_public['user_district'] && $info_public['use_province']) {
            $info_public['district'] = $this->district_model->find_where(
                ['DistrictCode' => $info_public['user_district'], 'ProvinceCode' => $info_public['use_province']],
                ['select'    => 'DistrictCode, DistrictName']
            );
        }
        $info_public['is_owner'] = $is_owner;
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$info_public['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$info_public['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$info_public['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        if(($liststore = $this->_product_ids_affiliate($info_public['use_id']))){
            $select           = 'Distinct pro_id, pro_name, pro_dir, pro_image, pro_cost, af_amt, af_rate, sho_name, sho_link, domain, IF( tbtt_product.pro_saleoff = 1 AND ((' . strtotime(date('Y/m/d', time())) . ' >= tbtt_product.begin_date_sale AND ' . strtotime(date('Y/m/d', time())) . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )), CASE WHEN tbtt_product.pro_type_saleoff = 2 THEN tbtt_product.pro_saleoff_value WHEN tbtt_product.pro_type_saleoff = 1 THEN CAST( tbtt_product.pro_saleoff_value AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100 END, 0 ) AS off_amount, IF( tbtt_product.af_dc_amt > 0, CAST( tbtt_product.af_dc_amt AS DECIMAL (15, 5) ), IF( tbtt_product.af_dc_rate > 0, CAST( tbtt_product.af_dc_rate AS DECIMAL (15, 5) ) * tbtt_product.pro_cost / 100, 0 ) ) AS af_off';
            $where            = 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_id IN (' . $liststore . ')';
            $data['products'] = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where . ' AND pro_type = 0', 'pro_id', 'DESC', 0, 5);
            $data['coupons']  = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where . ' AND pro_type = 2', 'pro_id', 'DESC', 0, 5);
        }

        $data['shop'] = $this->shop_model->find_where(
            ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
            ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        );

        $data['protocol']   = get_server_protocol();
        $data['domainName'] = $_SERVER['HTTP_HOST'];

        $data['siderbar_images'] = $this->content_model->fetch("not_image, not_title, not_dir_image", "not_image != ''AND not_status = 1 AND not_publish = 1 AND id_category = ".SubAdminUser." AND not_user = ". $info_public['use_id'], "not_id", "desc", 0, 5);
        $data['productCategoryRoot'] = $this->category_model->loadCategoryRoot(0, 0);
        $data['info_public']        = $info_public;
        $data['af_id']              = $info_public['af_key'];
        $data['is_owner']           = $is_owner;
        $data['news']               = $this->_get_news($info_public['use_id'], $info_public['use_group']);

        //block news
        $data['videos']             = $this->content_model->personal_news_list_videos($info_public['use_id'], 5, 0, $is_owner);
        $data['videos_news_total']  = $this->content_model->personal_news_list_videos($info_public['use_id'], 5, 0, $is_owner, true);
        //block images
        $data['images_total']       = $this->content_model->personal_news_list_image($info_public['use_id'], 0, 0, $is_owner, true);
        $data['images']             = $this->content_model->personal_news_list_image($info_public['use_id'], 4, 0, $is_owner);
        //block links
        $data['customlinks']        = $this->link_model->shop_gallery_list_link(0, $info_public['use_id'], 0, 4, 0, $is_owner);
        $data['customlink_total']   = $this->link_model->shop_gallery_list_link(0, $info_public['use_id'], 0, 0, 0, $is_owner, 'DESC' , true);
        //block collections
        $data['collections']        = $this->collection_model->get_collection_by_user($info_public['use_id'], $is_owner, 'get');
        $data['collection_total']   = $this->collection_model->get_collection_by_user($info_public['use_id'], $is_owner, 'count');
        $data['profile_shop_url']   = shop_url($data['shop']);
        $data['collection']         = false;
        $data['collection_content'] = false;

        if(($user_login = $this->session->userdata('sessionUser'))) {
            $select = '*';
            $where = "user_id = $user_login AND type = 1 AND status = 1";
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
                }

                $list_cc = array();
                foreach ($list_c as $key => $value) {
                    $list_cc[$value] = $this->collection_model->fetch_cc('cc_not_id', 'cc_user_id = '. $user_login .' AND cc_coll_id = '. $value, '','','','','' );
                    foreach ($list_cc[$value] as $k => $v) {
                        $list_cc[$value][$k] = $v->cc_not_id;
                    }
                }
                $data['collection_content'] = $list_cc;
            }
        }

        $detect = new Mobile_Detect();
        $data['num'] = 5;

        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['num'] = 4;
        }

        if(!empty($data['user_login'])){
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        $this->load->model('reports_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'asc');
        $data['listreports'] = $listreports;

        if (($sessionUser = $this->session->userdata('sessionUser'))) {
            $data['currentuser'] = $this->user_model->get("use_id, parent_id, use_username, use_cover, avatar, af_key, use_invite", "use_id = " . $sessionUser);
        }

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = '';
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }

        $ogurl = $info_public['profile_url'];

        $type_share = TYPESHARE_PROFILE_HOME;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }

        $data['sho_user']           = $info_public['use_id'];
        $data['type_share']         = $type_share;
        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = $info_public['use_fullname'];
        $data['keywordsSiteGlobal'] = $info_public['use_fullname'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogdescription']      = $ogdesc;
        $data['ogurl']              = $ogurl;
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = $data['ogurl'];

        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        $this->load->view('home/personal/pages/profile-home', $data);
    }

    public function get_more_news()
    {
        if(!$this->input->is_ajax_request() || empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        $info_public = $this->info_public;

        $news = $this->_get_news($info_public['use_id'], $info_public['use_group']);

        $data['collection'] = false;
        $data['collection_content'] = false;

        if(($user_login = $this->session->userdata('sessionUser'))) {
            $select = '*';
            $where = "user_id = $user_login AND type = 1 AND status = 1";
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
                }

                $list_cc = array();
                foreach ($list_c as $key => $value) {
                    $list_cc[$value] = $this->collection_model->fetch_cc('cc_not_id', 'cc_user_id = '. $user_login .' AND cc_coll_id = '. $value, '','','','','' );
                    foreach ($list_cc[$value] as $k => $v) {
                        $list_cc[$value][$k] = $v->cc_not_id;
                    }
                }
                $data['collection_content'] = $list_cc;
            }
        }

        $detect = new Mobile_Detect();
        $data['num'] = 5;
        $data['list_news'] = $news;

        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['num'] = 4;
        }
        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        echo $this->load->view('home/personal/elements/items', $data, TRUE);
        die();
    }

    private function _get_news($user_id, $group_id)
    {
        $this->load->model('images_model');
        $this->load->model('videos_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('like_content_model');
        $this->load->model('chontin_model');
        $this->load->library('link_library');
        $is_owner = false;

        $where = "not_status  = 1 
            AND not_publish = 1 
            AND use_status  = 1 
            AND (tbtt_content.sho_id IS NULL OR tbtt_content.sho_id = 0) 
            AND not_user = '$user_id' ";

        $where_permission = ' AND not_permission = 1';

        if ($user_id && $user_id == $this->session->userdata('sessionUser')) {
            // neu user đang đăng nhập là chủ page thì load luôn cả tin chỉ mình tôi
            $where_permission = ' AND (not_permission = 1 OR not_permission = 6) ';
            $is_owner = true;
        }

        $where .= $where_permission;

        $select = 'tbtt_content.*, tbtt_permission.name as not_permission_name, tbtt_category.cat_name, use_fullname, use_slug, avatar, use_id, website';

        // Lấy trang hiện tại
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        if ($page < 1) {
            $page = 1;
        }

        // Số record trên một trang
        $limit = 5;

        // Tìm start
        $start = ($limit * $page) - $limit;

        $list_news = $this->content_model->fetch_join_3($select, 'LEFT', 'tbtt_permission', 'tbtt_permission.id = not_permission', 'LEFT', 'tbtt_category', 'cat_id = not_pro_cat_id', 'LEFT', 'tbtt_user', 'use_id = not_user', $where, 'not_id', 'DESC', $start, $limit);
        foreach ($list_news as $key => $item) {
            $web_profile = $this->user_model->get('website', 'use_id = '.$user_id);
            if($web_profile->website != '' && $web_profile->website != NULL){
                $item->website = $web_profile->website;
            }
            //Dem so luọc chon tin
            $item->chontin = 0;
            $result = $this->chontin_model->fetch('id', 'not_id = '. $item->not_id);
            if (count($result)) {
                $item->chontin = count($result);
            }

            //Dem binh luan
            $query = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $item->not_id);
            $result = $query->result();
            $item->comments = count($result);

            //Dem like
            $list_likes = $this->like_content_model->get('id', ['not_id' => (int) $item->not_id]);
            $item->likes = count($list_likes);

            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_CONTENT.'/'.$item->not_id, []));
            $item->total_share = $jData->data->total_share;

            $item->type_share = TYPESHARE_PROFILE_NEWS;
            if($this->session->userdata('sessionUser')){
                //Kiem tra 1 user bat ky da chon tin nay chua
                $item->dachon = 0;
                $dachon = $this->chontin_model->fetch('id', 'not_id = '.$item->not_id.' AND sho_user_1 = '. $user_id);
                if (count($dachon)) {
                    $item->dachon = 1;
                }

                //User co duoc phep chon tin nay khong
                if(in_array($group_id, json_decode(ListGroupAff, true) ) && $item->not_user !=  $user_id) {
                    $item->chochontin = 1;
                } else {
                    $item->chochontin = 0;
                }

                // đã like
                $is_like = $this->like_content_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'not_id' => (int)$item->not_id]);
                $item->is_like = count($is_like);
            }

            /* GOI SAN PHAM NẾU CÓ CHỌN */
            $array = array();
            $aListImage = $this->images_model->get("*", 'not_id = ' . $item->not_id);
            if (!empty($aListImage)) {
                foreach ($aListImage as $key2 => $oImage) {
                    $array[$key2] = array(
                        $oImage->name,
                        $oImage->product_id,
                        $oImage->title,
                        $oImage->link,
                        $oImage->content,
                        $oImage->style_show,
                        $oImage->tags,
                        $oImage->id,
                        $oImage->img_w,
                        $oImage->img_h,
                        $oImage->img_type,
                        $oImage->orientation,
                        $oImage->link_crop,
                    );
                }
            }

            $listImg = array();
            $listPro = array();
            foreach ($array as $k => $value) {
                if (strlen($value[0]) > 10) {
                    @$listImg[$k]->image = $value[0];
                    if ($value[1] > 0) {
                        $select_hh = 'apply, pro_saleoff, pro_type_saleoff, begin_date_sale, end_date_sale, pro_saleoff_value, af_dc_rate, af_dc_amt, ';
                        $product = $this->product_model->get($select_hh.'pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, af_amt, (af_rate) as aff_rate'. DISCOUNT_QUERY, 'pro_id = '. (int) $value[1]);

                        if (($current_user_id = $this->session->userdata('sessionUser'))) {
                            $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$current_user_id, 'pro_id' => $product->pro_id));
                            if ($selected_sale) {
                                $product->selected_sale = $selected_sale;
                            }
                        }

                        @$listImg[$k]->product = $product; 

                        $dataHH = $this->dataGetHH($product);
                        $product->hoahong = $this->checkHH($dataHH);
                        $product->Shopname = $this->get_InfoShop($product->pro_user, 'sho_name')->sho_name;

                        $listPro[$k] = $product;
                    }
                    @$listImg[$k]->title = $value[2];
                    @$listImg[$k]->detail = $value[3];
                    @$listImg[$k]->caption = $value[4];
                    @$listImg[$k]->style = $value[5];
                    @$listImg[$k]->tags = $value[6];
                    @$listImg[$k]->id = $value[7];
                    @$listImg[$k]->img_w = $value[8];
                    @$listImg[$k]->img_h = $value[9];
                    @$listImg[$k]->img_type = $value[10];
                    @$listImg[$k]->orientation = $value[11];
                    @$listImg[$k]->link_crop = $value[12];
                }
            }
            $item->listImg = $listImg;
            $item->listPro = $listPro;

            //Get Customlink
            $item->not_customlink = $this->link_library->link_of_news($item->not_id, '', 0, 0, 0, $is_owner);

            //kiểm tra có quick view link + product + tag
            $list_news[$key]->check_quick_view['product'] = false;
            if(!empty($item->listPro)){
                $list_news[$key]->check_quick_view['product'] = true;
            }
            $list_news[$key]->check_quick_view['link'] = false;
            if(!empty($item->not_customlink)){
                $list_news[$key]->check_quick_view['link'] = true;
            }
            if (count($item->listImg) > 0) {
                foreach ($item->listImg as $key_image => $value) {
                    if(isset($value->tags) && $value->tags != '' && $value->tags != "'null'" && $value->tags != "[]" && $value->tags != null && $value->tags != 'null' && $value->tags != "\"null\"") {
                        $count_tags = count(json_decode($value->tags,true));
                        if ($count_tags == 0 ) {
                            $count_tags = count($value->tags);
                            $list_news[$key]->check_quick_view['tag'] = true;
                            break;
                        }
                        $list_news[$key]->check_quick_view['tag'] = true;
                        break;
                    }
                }
            }
            // Get video

            $iVideoId =  (string)$item->not_video_url1;
            if(strlen($iVideoId) < 12){
                $aVideos = $this->videos_model->get("*",'id = '. (int)$iVideoId);

                $list_news[$key]->poster = false;
                if (!empty($aVideos)) {
                    $list_news[$key]->not_video_url1 = $aVideos[0]->name;
                    $list_news[$key]->video_id       = $aVideos[0]->id;

                    if (!empty($aVideos[0]->thumbnail)) {
                        $list_news[$key]->poster =  DOMAIN_CLOUDSERVER .'video/thumbnail/'. $aVideos[0]->thumbnail;
                    }

                }
            }else{
                $list_news[$key]->not_video_url1  = '';
            }

            $status_follow = array();
            $this->load->model('friend_model');
            
            $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$item->use_id, 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
            if (!empty($getFriend))
            {
                if($getFriend[0]->accept == 0){
                    // 'Đã gửi yêu cầu';
                    $status_follow['is_friend'] = 0;
                    $status_follow['addFriend'] = 1;
                }else{
                    $status_follow['is_friend'] = 1;
                }
            }
            else{
                $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$item->use_id]);
                if (!empty($getIsFollow))
                {
                    if($getIsFollow[0]->accept == 0){
                        // 'Trả lời lời mời kết bạn';
                        $statusFriend = 'Đã gửi yêu cầu';
                        $status_follow['is_friend'] = 0;
                        $status_follow['addFriend'] = 0;
                        $status_follow['isaddFriend'] = 1;
                    }else{
                        $status_follow['is_friend'] = 1;
                    }
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

    public function about()
    {
        if(empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        $this->set_layout('home/personal/profile-layout');

        $is_owner = false;
        $info_public = $this->info_public;

        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$info_public['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$info_public['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$info_public['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        if($this->isLogin() && $info_public['use_id'] == $this->session->userdata('sessionUser')){
            $is_owner = true;
        }
        if($info_public['use_province']){
            $info_public['province'] = $this->province_model->find_where(
                ['pre_status'   => 1, 'pre_id' => $info_public['use_province']],
                ['select'       => 'pre_id, pre_name']
            );
        }
        if ($info_public['user_district'] && $info_public['use_province']) {
            $info_public['district'] = $this->district_model->find_where(
                ['DistrictCode' => $info_public['user_district'], 'ProvinceCode' => $info_public['use_province']],
                ['select'    => 'DistrictCode, DistrictName']
            );
        }
        $data['is_owner']        = $is_owner;
        $data['info_public']     = $info_public;
        $data['af_id']           = $info_public['af_key'];
        $data['shop'] = $this->shop_model->find_where(
            ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
            ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        );

        $data['protocol']   = get_server_protocol();
        $data['domainName'] = $_SERVER['HTTP_HOST'];

        if (($sessionUser = $this->session->userdata('sessionUser'))) {
            $data['currentuser'] = $this->user_model->get("use_id, parent_id, use_username, avatar, af_key, use_invite", "use_id = " . $sessionUser);
        }

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = '';
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = $info_public['profile_url'].'about';     
          

        $type_share = TYPESHARE_PROFILE_ABOUT;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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
        $this->load->view('home/personal/pages/profile-about', $data);
    }

    //upload folder temp
    public function upload_cover()
    {
        if ($this->input->is_ajax_request() && $this->isLogin()){
            
            $config = $this->config->item('cover_user_config');
            $this->_upload_temp('cover_res', $config);
        }
        die('error');
    }

    //upload folder temp
    public function upload_avatar()
    {
        if ($this->input->is_ajax_request() && $this->isLogin()){
            $this->load->config('config_upload');
            $config = $this->config->item('avatar_user_config');
            $this->_upload_temp('avatar_res', $config);
        }
        die('error');
    }

    //apply process crop image
    public function process_cover()
    {
        $this->load->config('config_upload');
        $dir_image  = $this->session->userdata('sessionUser');
        $config = $this->config->item('cover_user_config');
        $config['upload_path'] = $config['upload_path'] . '/' . $dir_image;
        if ($this->input->is_ajax_request() && $this->isLogin() && ($image_name = $this->session->userdata('personal_cover_res'))){
            if (file_exists($config['upload_path_temp'] . '/' . $image_name)) {
                $this->load->library(['ftp', 'upload' , 'image_lib']);
                //copy to folder cover, upload fpt, process crop
                $this->upload->exist_create_dir($config['upload_path']);
                $config_crop    = $this->_get_crop_image($this->input->post('points'), $config['upload_path_temp'] . '/' . $image_name);
                if($config_crop !== false){

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
                    $process_image = true;
                }

                copy($config['upload_path_temp'] . '/' . $image_name, $config['upload_path'] . '/' . $image_name);
                @unlink($config['upload_path_temp'] . '/' . $image_name);

                $this->ftp->connect($this->config->item('configftp'));

                /* Upload this image_co to cloud server */
                $pathTargetC = $this->config->item('cloud_cover_user_config')['upload_path'];
                $source_path = $config['upload_path'] . '/' . $image_name;
                $target_path = $pathTargetC . '/' . $dir_image . '/' . $image_name;

                $listdir = $this->ftp->list_files($pathTargetC . '/' . $dir_image);
                if(empty($listdir)){
                    $this->ftp->mkdir($pathTargetC . '/' . $dir_image, 0775);
                }

                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                $this->ftp->close();

                //upload model user
                $user_id = $this->session->userdata('sessionUser');
                $info_public = $this->user_model->generalInfo($user_id);
                $this->user_model->update_where(['use_cover' => $image_name], ['use_id' => $user_id]);

                //remove cover old
                if($info_public['use_cover'] && file_exists($config['upload_path'] . '/' . $info_public['use_cover'])) {
                    @unlink($config['upload_path'] . '/' . $info_public['use_cover']);
                }

                $this->session->unset_userdata('personal_cover_res');

                echo json_encode([
                    'status'                 => true,
                    'dir'                    => $config['upload_path'],
                    'name'                   => $image_name,
                    'sho_dir_banner'         => $dir_image,
                    'cloud_server_show_path' => $config['cloud_server_show_path'],
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

    //apply process crop image
    public function process_avatar()
    {
        $this->load->config('config_upload');
        $config = $this->config->item('avatar_user_config');
        if (
            $this->input->is_ajax_request() && $this->isLogin() &&
            ($dir_upload = $this->session->userdata('sessionUser')) &&
            ($image_name = $this->session->userdata('personal_avatar_res'))
        ){
            if (file_exists($config['upload_path_temp'] . '/' . $image_name)) {
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

                if($config_crop !== false){
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
                    $config_resize['new_image']      = $config['upload_path'] . '/' . $image_name;
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['width']          = $config['min_width'];
                    $config_resize['height']         = $config['min_height'];

                    $this->image_lib->initialize($config_resize);
                    if (!$this->image_lib->resize()) {
                        echo json_encode([
                            'status'    => false,
                            'message'   => $this->image_lib->display_errors()
                        ]);
                        die('resize');
                    }
                    $this->image_lib->clear();
                    $process_image = true;
                }

                if($process_image){
                    copy($config['upload_path_temp'] . '/' . $image_name, $config['upload_path'] . '/' . $image_name);
                    @unlink($config['upload_path_temp'] . '/' . $image_name);

                    $this->ftp->connect($this->config->item('configftp'));
                    /* Upload this image_co to cloud server */
                    $path_target_c = $this->config->item('cloud_avatar_user_config')['upload_path'];
                    $source_path   = $config['upload_path'] . '/' . $image_name;
                    $target_path   = $path_target_c . '/' . $dir_upload . '/' . $image_name;

                    $listdir = $this->ftp->list_files($path_target_c . '/' . $dir_upload);
                    if(empty($listdir)){
                        $this->ftp->mkdir($path_target_c . '/' . $dir_upload , 0775);
                    }
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);

                    $this->ftp->close();

                    //upload model user
                    $user_id = $this->session->userdata('sessionUser');
                    $info_public = $this->user_model->generalInfo($user_id);
                    $this->user_model->update_where(['avatar' => $image_name], ['use_id' => $user_id]);

                    //remove cover old
                    if($info_public['avatar'] && file_exists($config['upload_path'] . '/' . $info_public['avatar'])) {
                        @unlink($config['upload_path'] . '/' . $info_public['avatar']);
                    }

                    $this->session->unset_userdata('personal_avatar_res');

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
            $this->session->set_userdata('personal_'.$name_input_file, $image_co);

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

    private function _product_ids_affiliate($use_id, $return_str = true)
    {
        $this->load->model('product_affiliate_user_model');
        $products = $this->product_affiliate_user_model->fetch('pro_id', 'use_id = '. (int)$use_id);

        if (!empty($products) && $return_str) {
            $pro_ids = array();
            foreach ($products as $product){
                $pro_ids[] = $product->pro_id;
            }
            return implode(',', $pro_ids);
        }

        return $products;
    }

    public function library_images($news_id = '', $image_id = '')
    {
        $this->_exist_user();
        $this->set_layout('home/personal/library-layout');
        $data['view_type'] = $this->_view_type();
        $user              = $this->info_public;
        $data['page_view'] = 'image-page';
        $user_id           = (int)$this->session->userdata('sessionUser');
        $news_id           = $news_id ? (int)$news_id : null;
        $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owner']){
            $owns_id = $user_id;
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

        $image = $this->content_model->personal_news_list_image($user['use_id'], $limit, $start, $owns_id, false, $arr_relation);
        $imageContents = $this->content_model->personal_news_list_image_type($user['use_id'], $limit, $start, $owns_id, false, $arr_relation, 0, IMAGE_UP_DETECT_CONTENT);
        $imageUploads = $this->content_model->personal_news_list_image_type($user['use_id'], $limit, $start, $owns_id, false, $arr_relation, 0, IMAGE_UP_DETECT_LIBRARY);
        $data['imageContents'] = $imageContents;
        $data['imageUploads'] = $imageUploads;

        $data['start'] = $start;

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

            if(!empty($item->not_user)) {
                $image[$index]->shop             = $this->shop_model->get('sho_id, sho_name, sho_dir_logo, sho_logo, sho_link, domain', 'sho_user = '.$item->not_user);
            } else {
                $image[$index]->shop             = $this->shop_model->get('sho_id, sho_name, sho_dir_logo, sho_logo, sho_link, domain', 'sho_user = '.$user['use_id']);
            }
        }
        $data['images'] = $image;
        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        $permission = PERMISSION_SOCIAL_PUBLIC;
        if($data['is_owner'] == true) {
            $permission = PERMISSION_SOCIAL_ME;
        }else{
            $result = $this->friend_model->is_your_friend($user_id, $user['use_id']);
            if($result) {
                $permission = PERMISSION_SOCIAL_FRIEND;
            }
        }
        $data['albums'] = $this->album_model->get_album_with_total((int)$user['use_id'], 0, ALBUM_IMAGE, $permission);

        $this->load->model('reports_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'asc');
        $data['listreports'] = $listreports;

        if(!empty($image)){
            if($image[0]->not_id == 0 && $image[0]->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
                $ogimage     = DOMAIN_CLOUDSERVER . 'media/images/album/' . $image[0]->img_library_dir . '/' . $image[0]->name;
            } else {
                $ogimage     = DOMAIN_CLOUDSERVER . 'media/images/content/' . $image[0]->not_dir_image . '/' . $image[0]->name;
            }
        }else{
            $ogimage = '/templates/home/images/cover/cover_me.jpg';
            if($user['use_cover']){
                $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $user['use_id'] . '/' . $user['use_cover'];
            }
        }

        $type_share = TYPESHARE_PROFILE_LIBIMG;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$user['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $user['use_id'];
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $ogtitle = $user['use_fullname'];
        $ogdesc = 'Thư viện ảnh của '.$user['use_fullname'];

        $ogurl =$user['profile_url'].'library/images';        

        $data['descrSiteGlobal']    = $user['use_fullname'];
        $data['keywordsSiteGlobal'] = $user['use_fullname'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogdescription']      = $ogdesc;
        $data['ogurl'] = $ogurl;
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/personal/elements-library/image-items', $data, true);
            die();
        }else{
            $this->load->view('home/personal/pages/library-image', $data);
        }
    }

    public function library_links()
    {
        $this->_exist_user();
        $this->set_layout('home/personal/custom-link-layout');
        $this->load->model('collection_model');
        $this->load->model('bookmark_model');
        $this->load->model('category_link_model');
        $this->load->model('link_model');
        $this->load->model('friend_model');
        $this->load->model('follow_model');

        $user                     = $this->info_public;
        $user_id                  = (int)$this->session->userdata('sessionUser');
        $data['view_type']        = $this->_view_type();
        $data['user_login']       = MY_Loader::$static_data['hook_user'];
        $data['url_item']         = $user['profile_url'];
        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;
        $data['is_owns']          = $data['is_owner'];
        $data['azibai_url']       = azibai_url();
        $data['server_media']     = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';

        $owns_id = false;
        if($data['is_owner']){
            $owns_id = $user_id;
        }

        $category_temp  = $this->link_model->get_category_ids_by_shop(0, $user['use_id'], $data['is_owner']);
        $cat_ids        = array_to_array_keys($category_temp, 'cate_link_id');
        if(!empty($cat_ids)){
            $cat_parent = $this->category_link_model->get_category_parent_by_cat_ids($cat_ids);
            $cat_parent = array_unique(array_merge(array_to_array_keys($cat_parent, 'parent_id'), $cat_ids));
            $data['categories_parent'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0 AND id IN ('.implode( $cat_parent, ",").')',
                'orderby'   => 'id ASC',
                'type'      => 'array',
            ]);
            $data['categories_parent'] = $this->_get_bg_color($data['categories_parent']);
        }
        $data['links_new'] = $this->link_model->shop_gallery_list_link(0, $user['use_id'], 0, 21, 0, $owns_id);

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
            if(!isset($page)){
                if(isset($data['categories_parent'][0]['id'])){
                    $cat_id = $data['categories_parent'][0]['id'];
                }else{
                    $cat_id = 1;
                }
            }
        }

        if(!empty($data['categories_parent'])){
            $data['categories_parent'] = array_to_key_arrays($data['categories_parent'], 'id');
        }

        $data['links'] = $this->link_model->links_unique(0, $user['use_id'], $cat_id, $data['is_owns']);

        if($this->input->is_ajax_request()){
            echo $this->load->view('shop/media/elements/library-links/shop-library-block-link', $data, true);
            die();
        }

        if($data['is_owner']){
            $data['collections'] = $this->collection_model->my_collections($user['use_id']);
            $data['bookmarks']   = $this->bookmark_model->my_bookmarks($user['use_id']);
        }else if(!$data['is_owns'] && !empty($data['user_login'])){
            $data['collections'] = $this->collection_model->my_collections($user_id);
        }

        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => $user_id]);
        if (!empty($getFriend)) {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => $user_id, 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => $user_id]);
        $data['getFollow'] = $getFollow;

        if(!empty($data['links_new'])){
            $ogimage = $data['links_new'][0]['link_image'];
            if ($data['links_new'][0]['image']) {
                $ogimage = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data['links_new'][0]['image'];
            }
        }else{
            $ogimage = '/templates/home/images/cover/cover_me.jpg';
            if($user['use_cover']){
                $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $user['use_id'] . '/' . $user['use_cover'];
            }
        }

        $type_share = TYPESHARE_PROFILE_LIBLINK;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$user['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $user['use_id'];
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = $user['use_fullname'];
        $data['keywordsSiteGlobal'] = $user['use_fullname'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $user['use_fullname'];
        $data['ogdescription']      = 'Thư viện liên kết của ' . $user['use_fullname'];
        $data['ogurl']              = $user['profile_url'] . 'library/links';
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = $data['ogurl'];
        $this->load->view('home/personal/pages/library-link', $data);
    }

    /**
     * @param string $slug
     * library links page
     */
    public function media_link_category($slug)
    {
        $slug = strip_tags(trim($slug));
        if(!$slug){
            exit();
        }
        $this->_exist_user();
        $this->set_layout('home/personal/custom-link-layout');
        $this->load->model('collection_model');
        $this->load->model('bookmark_model');
        $this->load->model('category_link_model');
        $this->load->model('link_model');
        $this->load->model('friend_model');
        $this->load->model('follow_model');

        $user                     = $this->info_public;
        $data['user_login']       = MY_Loader::$static_data['hook_user'];
        $data['url_item']         = $user['profile_url'];
        $user_id                  = (int)$this->session->userdata('sessionUser');
        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['view_type']        = $this->_view_type();
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;
        $data['slug']             = $slug;
        $data['azibai_url']       = azibai_url();
        $data['server_media']     = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $cat_ids                  = [];
        $owns_id                  = false;

        if($data['is_owner']){
            $owns_id = $user_id;
        }

        $data['is_owns'] = $data['is_owner'];

        if($slug !== 'moi-nhat' && !($category_current = $this->category_link_model->get_category_by_slug($slug))){
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        //slug != moi-nhat
        if(!empty($category_current)) {
            $data['category_current'] = $category_current;
            if ($category_current['parent_id']) {
                $data['category_child_selected'] = $category_current['id'];
                $data['category_parent']         = [
                    'id' => $category_current['parent_id'],
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
        $this->_get_menu_item($data, $user['use_id']);

        if(!empty($category_current)) {
            //nếu current category là parent thì lấy child, get item link => selected "danh mục tất cả"
            if ((int)$data['category_current']['parent_id'] === 0 && !empty($data['categories_child'])) {
                $cat_ids = array_to_array_keys($data['categories_child'], 'id');
            }

            $cat_ids[]      = $data['category_current']['id'];
        }

        $data['items']      = $this->_get_library_links($user['use_id'], $cat_ids, $owns_id);

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/personal/elements/library-links/library-items', $data, true);
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

        //chủ trang
        if($data['is_owner']){
            $data['collections'] = $this->collection_model->my_collections($user['use_id']);
            $data['bookmarks']   = $this->bookmark_model->my_bookmarks($user['use_id']);
        }

        //user khác login
        if(!$data['is_owns'] && !empty($data['user_login'])){
            $data['collections'] = $this->collection_model->my_collections($user_id);
        }

        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => $user_id]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;

        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => $user_id]);
        $data['getFollow'] = $getFollow;

        $ogimage = $user['avatar_url'];
        if(!empty($data['items'])){
            $ogimage = $data['items'][0]['link_image'];
            if($data['items'][0]['image']) {
                $ogimage = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data['items'][0]['image'];
            }
        }

        $type_share = TYPESHARE_PROFILE_LIBLINKTAB;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$user['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $user['use_id'];
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = $user['use_fullname'];
        $data['keywordsSiteGlobal'] = $user['use_fullname'];
        $data['ogurl']              = $user['profile_url'].'library/links/'.$slug;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $user['use_fullname'];
        $data['ogdescription']      = 'Thư viện liên kết của '.$user['use_fullname'];
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = base_url().'library/links/' . ($slug === 'moi-nhat' ? 'moi-nhat' : $category_current['slug']);

        $this->load->view('home/personal/pages/media-category-link', $data);
    }

    /**
     * @param $user_id
     * @param $cat_ids
     * @param int $owner_id
     * @param array $options
     * @return array
     */
    private function _get_library_links($user_id, $cat_ids, $owner_id = 0, $options = [])
    {
        if(empty($user_id) && empty($cat_ids))
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

        if ((int)$page < 1)
            $page = 1;

        if(!isset($limit))
            $limit = 10;

        if(!isset($start))
            $start = ($limit * (int)$page) - $limit;

        return $this->link_model->shop_gallery_list_link(0, $user_id, $cat_ids, $limit, $start, $owner_id);
    }

    /**
     * @param $id
     * detail library link
     */
    public function library_link_detail($id, $type)
    {
        $this->_exist_user();
        $this->set_layout('home/personal/custom-link-layout');
        $this->load->library('link_library');
        $this->load->model('category_link_model');
        $this->load->model('collection_model');
        $this->load->model('friend_model');
        $this->load->model('follow_model');

        $user_id          = (int)$this->session->userdata('sessionUser');
        $user             = $this->info_public;
        $data['is_owner'] = $user['use_id'] == $user_id;
        $owns_id          = false;
        if($data['is_owner']){
            $owns_id = $user_id;
        }
        if(
            !$id || !$type || !($data['link'] = $this->link_library->exist_link($id, $type))
            || ($data['link']['user_id'] != $user['use_id'] && $data['link']['sho_id'])
        ){
            redirect($this->mainURL . 'page-not-found');
            die();
        }
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $data['page_current'] = 'detail';
        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;

        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        $data['user_login']        = MY_Loader::$static_data['hook_user'];
        $data['url_item']          = $user['profile_url'];
        $data['shop']              = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url']  = shop_url($data['shop']);
        $data['is_owns']           = $data['is_owner'];
        $data['avatar_owner_link'] = $user['avatar_url'];
        $data['name_owner_link']   = $user['use_fullname'];
        $data['url_owner_link']    = $user['profile_url'];

        if ($data['link']['cate_link_id']) {
            $category_current = $this->category_link_model->get_category_by_id($data['link']['cate_link_id']);
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
        $data['link']['links_category']   = $this->link_library->link_same_category($data['link']['cate_link_id'], $type, $data['link']['sho_id'], $data['link']['user_id'], $data['link']['id'], $data['is_owns']);

        //liên kết cùng tin
        if(!empty($data['link']['content_id'])){
            $data['link']['links_news']   = $this->link_library->link_of_news($data['link']['content_id'], $type, $data['link']['sho_id'], $data['link']['user_id'], $data['link']['id'], $data['is_owns']);
        }

        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        //chủ page
        if($data['is_owns']){
            $data['collections'] = $this->collection_model->my_collections($user['use_id']);
        }

        //user khác login
        if(!$data['is_owns'] && !empty($data['user_login'])){
            $data['collections'] = $this->collection_model->my_collections($user_id);
        }

        $ogimage = $data['link']['image'] ? $data['link']['image_url'] : $data['link']['link_image'];
        switch ($type) {
            case 'image-link':
                $type_share = TYPESHARE_DETAIL_PRFLINK_IMG;
                $type_url = 'tbtt_content_image_links';
                break;

            case 'content-link':
                $type_share = TYPESHARE_DETAIL_PRFLINK_CONTENT;
                $type_url = 'tbtt_content_links';
                break;

            case 'library-link':
                $type_share = TYPESHARE_DETAIL_PRFLIBLINK;
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
            $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$user_id.' AND type = '.$type_share);
            if(!empty($get_avtShare)){
                $ogimage = $get_avtShare[0]->image;
            }
        }

        $data['type_share'] = $type_share;
        $data['itemid_shr'] = $data['link']['id'];
        $data['ogimage'] = $ogimage;
        $data['type_link']  = $type;

        $data['aliasDomain']        = $data['profile_shop_url'];
        $linktoshop                 = $data['profile_shop_url'];
        $data['descrSiteGlobal']    = $data['link']['description'];
        $data['ogurl']              = $user['profile_url'] . $type .'/' . $id;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = str_replace('"', '', $data['link']['link_title']);
        $data['ogdescription']      = $data['link']['description'];
        $data['linktoshop']         = $linktoshop;
        $data['share_url']          = $data['ogurl'];
        $data['share_name']         = convert_percent_encoding($data['link']['link_title']);
        $data['color_icon']         = 'black';

        $this->load->view('home/personal/pages/media-link-detail', $data);
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

    public function library_videos($response_type = 'videos')
    {
        //check exist user
        $this->_exist_user();
        if(!$response_type)
            $response_type = 'videos';
        $this->set_layout('home/personal/library-layout');
        $data['view_type']        = $this->_view_type();
        $data['page_view']        = 'video-page';
        $user                     = $this->info_public;
        $user_id                  = (int)$this->session->userdata('sessionUser');
        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;
        $owns_id                  = false;

        if($data['is_owner']){
            $owns_id = $user_id;
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

        $videos = $this->content_model->personal_news_list_videos($user['use_id'], $limit, $start, $owns_id);

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
            if(!empty($video->not_user)) {
                $videos[$index]->shop             = $this->shop_model->get('sho_id, sho_name, sho_dir_logo, sho_logo, sho_link, domain', 'sho_user = '.$video->not_user);
            } else {
                $videos[$index]->shop             = $this->shop_model->get('sho_id, sho_name, sho_dir_logo, sho_logo, sho_link, domain', 'sho_user = '.$user['use_id']);
            }
        }
        $data['videos'] = $videos;
        $data['start']  = $start;

        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        if(!empty($videos)){
            $ogimage         = $videos[0]->thumbnail ? (DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $videos[0]->thumbnail) : DEFAULT_IMAGE_ERROR_PATH;
        }else{
            $ogimage = '/templates/home/images/cover/cover_me.jpg';
            if($info_public['use_cover']){
                $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
            }
        }

        $ogtitle = $user['use_fullname'];
        $ogdesc = 'Thư viện video của '.$user['use_fullname'];
        $ogurl = $user['profile_url'].'library/videos';        

        $type_share = TYPESHARE_PROFILE_LIBVIDEO;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$user['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $user['use_id'];
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['descrSiteGlobal']    = $user['use_fullname'];
        $data['keywordsSiteGlobal'] = $user['use_fullname'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogdescription']      = $ogdesc;
        $data['ogurl'] = $ogurl;
        $data['share_name'] = $data['ogdescription'];
        $data['share_url'] = $data['ogurl'];

        if($this->input->is_ajax_request()){
            if($response_type == 'videos'){
                echo $this->load->view('home/personal/elements-library/video-items', $data, true);
            }
            //request từ block videos trang chủ cá nhân lấy thêm video
            if($response_type == 'news'){
                echo $this->load->view('shop/news/elements/news_video_slider_items', $data, true);
            }
            die();
        }else{
            $this->load->view('home/personal/pages/library-video', $data);
        }
    }

    public function affiliate_shop($use_link = '')
    {
        $this->load->model('domains_model');
        $oDomain = $this->domains_model->get( '*','domain = "'.$_SERVER['HTTP_HOST'].'" AND domain_type = 1');
        if(!empty($oDomain)) {
            $use_link = $oDomain->userid;
        }

        if ($use_link == '') {
            redirect($this->mainURL . 'page-not-found');
            die;
        }
        $user = $this->user_model->get('*',"use_slug = '$use_link'");
        if (empty($user)) {
            $user = $this->user_model->get('*','use_id = '. (int)$use_link);
            if(empty($user)){
                redirect($this->mainURL . 'page-not-found');
                die;
            }
        }
        // get af_id
        $data['af_id'] = $this->get_af_id($user);
        // end get af_id

        $info_public = $this->info_public;
        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$info_public['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$info_public['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$info_public['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        $profile_shop = $this->shop_model->get("sho_id, sho_name, sho_descr, sho_link, domain", "sho_user = " . $info_public['use_id']);
        if(!empty($profile_shop->domain)){
            $info_public['profile_shop_url'] = 'http://' . $profile_shop->domain;
        }else if (!empty($profile_shop->sho_link)){
            $protocol = get_server_protocol();
            $info_public['profile_shop_url'] =  $protocol . $profile_shop->sho_link . '.' . domain_site ;
        }
        if($info_public['use_province']){
            $info_public['province'] = $this->province_model->find_where(
                ['pre_status'   => 1, 'pre_id' => $info_public['use_province']],
                ['select'       => 'pre_id, pre_name']
            );
        }
        if ($info_public['user_district'] && $info_public['use_province']) {
            $info_public['district'] = $this->district_model->find_where(
                ['DistrictCode' => $info_public['user_district'], 'ProvinceCode' => $info_public['use_province']],
                ['select'    => 'DistrictCode, DistrictName']
            );
        }
        $data['current_profile'] = $info_public;
        // ------------------------------------------------------------------------

        $select = ['tbtt_product.pro_id','pro_category','pro_name','pro_descr','pro_cost','pro_currency','pro_image','pro_dir','pro_saleoff','pro_saleoff_value','pro_type_saleoff','end_date_sale','pro_minsale',
            'is_product_affiliate', 'af_amt', 'af_rate', 'af_dc_amt', 'af_dc_rate',
            'dp.id as dp_id', 'dp.dp_images','dp.dp_cost'];
        $where = [
            //logic của Tính
            'product_new'   => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 0 OR ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() < begin_date_sale OR UNIX_TIMESTAMP() > end_date_sale) ) )',
            'product_sale'  => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale) )',
            'coupon_new'    => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 0 OR ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() < begin_date_sale OR UNIX_TIMESTAMP() > end_date_sale) ) )',
            'coupon_sale'   => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale) )',
        ];
        $join = 'LEFT';
        $table = '(SELECT MIN(id) as id, dp_images, dp_cost, dp_pro_id
                    FROM tbtt_detail_product
                    GROUP BY dp_pro_id) dp';
        $on = 'dp.dp_pro_id = pro_id';

        // Affiliate shop - lấy tất cả sản phẩm cho cộng tác viên bán
        $join2 = 'INNER';
        $table2 = 'tbtt_product_affiliate_user pro_af';
        $on2 = 'pro_af.pro_id = tbtt_product.pro_id';
        foreach ($where as $key => $value) {
            $where[$key] .= ' AND is_product_affiliate = 1';
        }
        $data['for_shop_af'] = true;

        $limit = 20;
        $start = 0;
        $order = 'created_date';
        $by = 'DESC';
        $distinct = false;
        $group_by = NULL;

        //product
        $product_new = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_new'], $order, $by, $start, $limit, $distinct, $group_by);
        $product_sale = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_sale'], $order, $by, $start, $limit, $distinct, $group_by);
        //coupon
        $coupon_new = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_new'], $order, $by, $start, $limit, $distinct, $group_by);
        $coupon_sale = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_sale'], $order, $by, $start, $limit, $distinct, $group_by);
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

        if($this->session->userdata('sessionUser')){
            $this->load->model('like_product_model');
            if(count($data_walk['product_new']) > 0){
                foreach ($data_walk['product_new'] as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($data_walk['product_sale']) > 0){
                foreach ($data_walk['product_sale'] as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($data_walk['coupon_new']) > 0){
                foreach ($data_walk['coupon_new'] as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($data_walk['coupon_sale']) > 0){
                foreach ($data_walk['coupon_sale'] as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
        }
        $data['product_new'] = $data_walk['product_new'];
        $data['product_sale'] = $data_walk['product_sale'];
        $data['coupon_new'] = $data_walk['coupon_new'];
        $data['coupon_sale'] = $data_walk['coupon_sale'];
        // ------------------------------------------------------------------------

        $data['shop'] = $this->shop_model->find_where(
            ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
            ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        );
        $data['profile_shop_url']   = shop_url($data['shop']);
        if (($sessionUser = $this->session->userdata('sessionUser'))) {
            $data['currentuser'] = $this->user_model->get("use_id, parent_id, use_username, avatar, af_key, use_invite", "use_id = " . $sessionUser);
        }
        // ------------------------------------------------------------------------

        $data['collection_product'] = $this->collection_model->fetch_c('*', "user_id = " . $info_public['use_id']. " AND status = 1 AND isPublic = 1 AND `type` = ".COLLECTION_PRODUCT , 'created_at', 'DESC', '', '', '');
        $data['collection_coupon'] = $this->collection_model->fetch_c('*', "user_id = " . $info_public['use_id']. " AND status = 1 AND isPublic = 1 AND `type` = ".COLLECTION_COUPON , 'created_at', 'DESC', '', '', '');

        $data['detect_process'] = 'affiliate-shop';
        // ------------------------------------------------------------------------        

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = 'Cửa hàng của '.$info_public['use_fullname'];
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = $info_public['profile_url'].'affiliate-shop';        

        $type_share = TYPESHARE_PROFILE_SHOP;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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
        // dd($data['collection_product']);
        // dd($data['collection_coupon']);
        // die;

        $this->load->view('home/personal/affililate-shop/main-layout',$data);

        // dd($user);die;
    }

    public function affiliate_shop_slash($use_link = '', $detect_process = 'product')
    {
        $this->load->model('domains_model');
        $oDomain = $this->domains_model->get( '*','domain = "'.$_SERVER['HTTP_HOST'].'" AND domain_type = 1');
        if(!empty($oDomain)) {
            $use_link = $oDomain->userid;
        }
        if ($use_link == '') {
            redirect($this->mainURL . 'page-not-found');
            die;
        }
        $user = $this->user_model->get('*',"use_slug = '$use_link'");
        if (empty($user)) {
            $user = $this->user_model->get('*','use_id = '. (int)$use_link);
            if(empty($user)){
                redirect($this->mainURL . 'page-not-found');
                die;
            }
        }


        // get af_id
        $data['af_id'] = $this->get_af_id($user);
        // end get af_id



        $info_public = $this->info_public;
        
        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$info_public['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$info_public['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$info_public['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        $profile_shop = $this->shop_model->get("sho_id, sho_name, sho_descr, sho_link, domain", "sho_user = " . $info_public['use_id']);
        if(!empty($profile_shop->domain)){
            $info_public['profile_shop_url'] = 'http://' . $profile_shop->domain;
        }else if (!empty($profile_shop->sho_link)){
            $protocol = get_server_protocol();
            $info_public['profile_shop_url'] =  $protocol . $profile_shop->sho_link . '.' . domain_site ;
        }
        if($info_public['use_province']){
            $info_public['province'] = $this->province_model->find_where(
                ['pre_status'   => 1, 'pre_id' => $info_public['use_province']],
                ['select'       => 'pre_id, pre_name']
            );
        }
        if ($info_public['user_district'] && $info_public['use_province']) {
            $info_public['district'] = $this->district_model->find_where(
                ['DistrictCode' => $info_public['user_district'], 'ProvinceCode' => $info_public['use_province']],
                ['select'    => 'DistrictCode, DistrictName']
            );
        }
        $data['current_profile'] = $info_public;
        // ------------------------------------------------------------------------

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        $page = (int)$this->input->post('page');
        if ($page < 1) {
            $page = 1;
        }
        
        $select = ['tbtt_product.pro_id','pro_type','pro_category','pro_name','pro_descr','pro_cost','pro_currency','pro_image','pro_dir','pro_saleoff','pro_saleoff_value','pro_type_saleoff','end_date_sale','pro_minsale',
            'is_product_affiliate', 'af_amt', 'af_rate', 'af_dc_amt', 'af_dc_rate',
            'dp.id as dp_id', 'dp.dp_images','dp.dp_cost'];
        $where = [
            // 'product_items'   => 'pro_user = '. $this->shop_current->sho_user . ' AND pro_status = 1 AND pro_type = 0 AND ( pro_saleoff = 0 OR (pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)) )',
            // 'coupon_items'    => 'pro_user = '. $this->shop_current->sho_user . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 0 OR (pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)) )',
            'product_items'   => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 0',
            'coupon_items'    => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 2',
        ];
        $join = 'LEFT';
        $table = '(SELECT MIN(id) as id, dp_images, dp_cost, dp_pro_id
                    FROM tbtt_detail_product
                    GROUP BY dp_pro_id) dp';
        $on = 'dp.dp_pro_id = pro_id';

        // Affiliate shop - lấy tất cả sản phẩm cho cộng tác viên bán
        $join2 = 'INNER';
        $table2 = 'tbtt_product_affiliate_user pro_af';
        $on2 = 'pro_af.pro_id = tbtt_product.pro_id';
        foreach ($where as $key => $value) {
            $where[$key] .= ' AND is_product_affiliate = 1';
        }

        $limit = 10;
        $start = ($page - 1) * $limit;
        $order = 'created_date';
        $by = 'DESC';
        $distinct = false;
        $group_by = NULL;

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
            $query_string = "(SELECT tbtt_product.pro_id, COALESCE(pro_af.use_id, 0) as CTV_chose, pro_type, pro_user, pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, COALESCE(id, 0) AS dp_id, dp_images, dp_cost
                            FROM tbtt_product
                            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = pro_id
                            LEFT JOIN tbtt_product_affiliate_user pro_af ON pro_af.pro_id = tbtt_product.pro_id
                            WHERE pro_status = 1 AND pro_af.use_id = " . (int)$info_public['use_id'] ."
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
                $html .= $this->load->view('home/personal/affililate-shop/ajax_html/item-shop-slash-pro-coup', ['item'=>$value,'index_item'=>($start+$key)], true);
            }

            echo json_encode(['html'=>$html, 'total'=>$total]);
            die();
        }

        // chỉ chạy trong lần đầu tiên load view + load more item bằng ajax(chưa lần nào filter)
        //process get data
        switch ($detect_process) {
            case 'product':
                $items = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_items'], $order, $by, $start, $limit, $distinct, $group_by);
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
                }
                $total = count($this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['product_items'], $order, $by, $start = -1, $limit, $distinct, $group_by));
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
                $items = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_items'], $order, $by, $start, $limit, $distinct, $group_by);
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
                }
                $total = count($this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_items'], $order, $by, $start = -1, $limit, $distinct, $group_by));
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

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = 'Cửa hàng của '.$info_public['use_fullname'];
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = $info_public['profile_url'].'affiliate-shop/'.$detect_process;        

        $type_share = TYPESHARE_PROFILE_SHOP;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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
        // show more
        if($this->input->is_ajax_request()){
            $html = "";
            foreach ($items as $key => $value) {
                $html .= $this->load->view('home/personal/affililate-shop/ajax_html/item-shop-slash-pro-coup', ['item'=>$value,'index_item'=>($start+$key)], true);
            }
            echo $html;
            die();
        } else { // load data to view
            $data['items'] = $items;
            $data['total'] = $total;
            $data['detect_process'] = $detect_process;
            $this->load->view('home/personal/affililate-shop/main-layout',$data);
            // $this->load->vars($data);
        }

        // ------------------------------------------------------------------------
        
        // dd($use_link);
        // dd($detect);
        // die;
        // $this->load->view('home/personal/affililate-shop/main-layout',$data);
    }

    public function affiliate_shop_v2($type_path = '', $type_segment='')
    {
        $_paths = [
            'voucher' => '',
            'product' => 0,
            'coupon' => 2,
            '' => '',
        ];
        $this->_exist_user();
        $data['info_public'] = $user = $this->info_public;
        $user_id           = (int)$this->session->userdata('sessionUser');
        $news_id           = $news_id ? (int)$news_id : null;
        $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owner']){
            $owns_id = $user_id;
        }

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $type = $_paths[$type_path];
        $data['type_path'] = $type_path;
        $data['type_segment'] = $type_segment;

        $search = $product_type = $voucher_type = $price_from = $price_to = $time_start = $time_end = $pro_quality = $pro_saleoff = $pro_category = "";
        if($type_path !== '') {
            $page = 1;
            if(@$_REQUEST["page"] > 1) {
                $page = $_REQUEST["page"];
            }
            $limit = 10;
            if($type_path === "voucher") {
                if($type_segment !== '' && in_array($type_segment, [0,1])) {
                    $type = $type_segment;
                }
                $temp = Api_affiliate::list_service_person_get($page, $limit, $user['use_id'], $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);

            } else if(in_array($type_path, ["coupon","product"])) {
                $temp = Api_affiliate::tab_shop_person($page, $limit, $user['use_id'], $type, $search, $pro_quality, $pro_saleoff, $pro_category, $price_from, $price_to);
            } else {
                $temp = Api_affiliate::tab_shop_person($page, $limit, $user['use_id'], $type, $search, $pro_quality, $pro_saleoff, $pro_category, $price_from, $price_to);
            }
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
    
            $data = array_merge($temp, $data);
        } else {
            $temp = Api_affiliate::list_service_person_get($page, $limit, $user['use_id'], $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);
            $data = array_merge($temp, $data);
        }

        $data['show_sub_aff'] = false;
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affililate-shop-v2/index', $data, FALSE);
    }

    public function affiliate_shop_v2_search()
    {
        $this->_exist_user();
        $data['info_public'] = $user = $this->info_public;
        $user_id           = (int)$this->session->userdata('sessionUser');
        $news_id           = $news_id ? (int)$news_id : null;
        $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owner']){
            $owns_id = $user_id;
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

        $temp = Api_affiliate::list_service_person_get($page, $limit, $user['use_id'], $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end);
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

        $data = array_merge($temp, $data);

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affililate-shop-v2/search-voucher', $data, FALSE);
    }

    public function affiliate_shop_v2_search_product($type_path = "product")
    {
        $_paths = [
            'product' => 0,
            'coupon' => 2,
        ];

        $this->_exist_user();
        $data['info_public'] = $user = $this->info_public;
        $user_id           = (int)$this->session->userdata('sessionUser');
        $news_id           = $news_id ? (int)$news_id : null;
        $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owner']){
            $owns_id = $user_id;
        }

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $page = 1;
        if(@$_REQUEST["page"] > 1) {
            $page = $_REQUEST["page"];
        }
        $limit = 10;
        $data['type_path'] = $type_path;

        $type = $_paths[$type_path];
        $search = @$_REQUEST["search"] && $_REQUEST["search"] !== ''? $_REQUEST["search"] : "";
        $pro_quality = @$_REQUEST["pro_quality"] && $_REQUEST["pro_quality"] !== '' ? $_REQUEST["pro_quality"] : "";
        $pro_saleoff = @$_REQUEST["pro_saleoff"] && $_REQUEST["pro_saleoff"] !== '' ? $_REQUEST["pro_saleoff"] : "";
        $pro_category = @$_REQUEST["pro_category"] && $_REQUEST["pro_category"] !== '' ? $_REQUEST["pro_category"] : "";
        $price_from = @$_REQUEST["price_from"] && $_REQUEST["price_from"] !== '' ? $_REQUEST["price_from"] : "";
        $price_to = @$_REQUEST["price_to"] && $_REQUEST["price_to"] !== '' ? $_REQUEST["price_to"] : "";
        $temp = Api_affiliate::tab_shop_person($page, $limit, $user['use_id'], $type, $search, $pro_quality, $pro_saleoff, $pro_category, $price_from, $price_to);

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
        // dd($temp);die;
        $data = array_merge($temp, $data);

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affililate-shop-v2/search-product', $data, FALSE);
    }

    private function _exist_user($id = null)
    {
        $user = $this->info_public;
        if($id){
            $user = $this->get_profile_user($id);
        }
        if (empty($user) || !$user['use_status']) {
            redirect($this->mainURL . 'page-not-found');
            die;
        }
        return $user;
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

    //conver cover profile old to new
    public function convert_cover_new($get_start)
    {
        $this->load->library(['ftp', 'upload']);
        $users = $this->user_model->gets([
            'select' => 'use_id, use_cover',
            'orderby' => '',
            'limit'         => 500,
            'start'         => (int)$get_start,
            'param'         => 'use_cover IS NOT NULL AND use_cover != ""',
        ]);
        //http://azibai.net/media/images/cover/8f76cc9bc4fbda640362c742a1b20b2a.jpg old
        //http://azibai.net/media/images/profiles/5465/88e2fbec9e6e3a5bd201cb72337dd504.jpeg new
//        echo '<pre>';
//        print_r($users);
//        echo '</pre>';
//        echo '<br>';
//        die('debug');
        $this->ftp->connect($this->config->item('configftp'));
        if(!empty($users)){
            $temp = [];
            foreach ($users as $user) {
                if($user->use_cover){
                    $source_path = '/public_html/media/images/cover/' . $user->use_cover;

                    $dir_image   = $user->use_id;
                    $image_name  = $user->use_cover;
                    $pathTargetC = $this->config->item('cloud_cover_user_config')['upload_path'];
                    $target_path = $pathTargetC . '/' . $dir_image . '/' . $image_name;
                    $listdir = $this->ftp->list_files($pathTargetC . '/' . $dir_image);
                    if(empty($listdir)){
                        try {
                            $this->ftp->mkdir($pathTargetC . '/' . $dir_image, 0775);
                            $this->ftp->rename($source_path, $target_path, 'auto', 0775);
                        } catch ( \Exception $e){
                            print_r($e);
                        }
                    }
                    $temp[] = $target_path;
                }

            }
            print_r($temp);
        }
        $this->ftp->close();
        echo '<pre>';
        echo '</pre>';
        echo '<br>';
        die('debug');
    }

    public function get_af_id($user) {
        // get af_id
        $data['af_id'] = '';
        if ($this->session->userdata('sessionUser')) {
            $user_af_key = $this->user_model->get("af_key", "use_id = " . (int)$this->session->userdata('sessionUser'));
            if (!empty($user_af_key->af_key)) {
                $data['af_id'] = $user_af_key->af_key;
            }
        }
        else if ($_REQUEST['af_id'] != '')
        {
            $data['af_id'] = $_REQUEST['af_id'];
        } 
        else if ($this->session->userdata('af_id') != "") 
        {
            $data['af_id'] = $this->session->userdata('af_id');
        }
        else if (!empty($user->af_key))
        {
            $data['af_id'] = $user->af_key;
        }

        if ($data['af_id'] != '') {
            $this->session->set_userdata('af_id', $data['af_id']);
        }
        return $data['af_id'];
        // end get af_id
    }    

    public function ajax_pop_load_image_lib()
    {
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $info_public = $this->info_public;
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
            // $image = $this->content_model->personal_news_list_image($info_public['use_id'], $limit, $start, false, false, []);
            $image = $this->content_model->personal_news_list_image_type($info_public['use_id'], $limit, $start, false, false, [], 0, $typeIMG);
            $arr = [];

            // xài trong chỉnh xữa album
            $album_id = $this->input->post('album_id');
            if($album_id) {
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
                $html .= $this->load->view('home/personal/album/html/item-img-pop-lib', $arr, true);
            }
            echo $html;
            die;
        }
    }

    public function ajax_process_album_image($process = 'create')
    {
        if ($process == 'create' && $this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
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
                'ref_shop_id' => 0,
                'ref_user' => (int)$this->session->userdata('sessionUser')
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
                                'img_up_by_shop'    =>  0,
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
                            'img_up_by_shop'    =>  0,
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
                        'ref_user' => (int)$this->session->userdata('sessionUser'),
                        'ref_shop_id' => 0
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
        else if ($process == 'update' && $this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
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
                'ref_shop_id' => 0,
                'ref_user' => (int)$this->session->userdata('sessionUser')
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
                                'img_up_by_shop'    =>  0,
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
                            'img_up_by_shop'    =>  0,
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
                        'ref_user' => (int)$this->session->userdata('sessionUser'),
                        'ref_shop_id' => 0
                    ];
                }
                // xóa tất cả các record cũ
                $this->db->delete('tbtt_album_media_detail', array('ref_album_id' => $album_id, 'ref_user' => (int)$this->session->userdata('sessionUser'), 'ref_shop_id' => 0));
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

    public function ajax_get_info_album()
    {
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $album_id = $this->input->post('album_id');
            $album_type = $this->input->post('album_type');
            $ref_user = (int)$this->session->userdata('sessionUser');
            $ref_shop_id = 0;

            $album_info = $this->album_model->get('*',"album_id = $album_id AND album_type = $album_type AND ref_user = $ref_user AND ref_shop_id = $ref_shop_id");
            if(empty($album_info)){
                echo 0; die;
            }
            $album_items = $this->album_model->get_detail_data_album($ref_user, $ref_shop_id, $album_type, $album_id);
            // $lib_images = $this->content_model->personal_news_list_image($ref_user, $limit = 10, $start = 0, false, false, []);
            $lib_images_content = $this->content_model->personal_news_list_image_type($ref_user, $limit = 10, $start = 0, false, false, [], 0, IMAGE_UP_DETECT_CONTENT);
            $lib_images_upload = $this->content_model->personal_news_list_image_type($ref_user, $limit = 10, $start = 0, false, false, [], 0, IMAGE_UP_DETECT_LIBRARY);

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
            $html = $this->load->view('home/personal/album/html/html-popup-edit-album-image', $arr, true);
            echo $html; die;
        } else {
            echo 0; die;
        }
    }

    public function ajax_set_album_to_top()
    {
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
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
                $where = 'album_type = '.$album_type.' AND ref_user = '.$album_user.' AND ref_shop_id = 0';
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
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $album_id = $this->input->post('album_id');
            $album_type = $this->input->post('album_type');
            $ref_user = (int)$this->session->userdata('sessionUser');
            $ref_shop_id = 0;

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

    public function ajax_openPopupGhim()
    {
        if($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ){
            $img_id = $this->input->post('img_id');
            $album_type = $this->input->post('album_type');
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = 0;

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
                $html = $this->load->view('home/personal/album/html/html-popup-img-ghim-album', ['albums'=>$album_all], true);
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
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = 0;

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
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = 0;
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
        if ($this->input->is_ajax_request() && ($this->info_public['use_id'] == $this->session->userdata('sessionUser')) ) {
            $user_id = (int)$this->session->userdata('sessionUser');
            $shop_id = 0;
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
                    if($exif['Orientation'] != false) {
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
        $this->_exist_user();
        $this->set_layout('home/personal/library-layout');
        $data['view_type'] = $this->_view_type();
        $user              = $this->info_public;
        $data['page_view'] = 'image-page';
        $user_id           = (int)$this->session->userdata('sessionUser');
        $news_id           = $news_id ? (int)$news_id : null;
        $image_id          = $image_id ? (int)$image_id : null;
        $arr_relation      = [];

        $data['shop']             = $this->shop_model->getShopByOwnerId($user['use_id']);
        $data['profile_shop_url'] = shop_url($data['shop']);
        $data['is_owner']         = $user['use_id'] == $user_id;

        $owns_id = false;

        if($news_id && $image_id){
            $arr_relation = ['not_id' => $news_id, 'image_id' => $image_id];
        }

        if($data['is_owner']){
            $owns_id = $user_id;
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

        $image = $this->content_model->personal_news_list_image($user['use_id'], $limit, $start, $owns_id, false, $arr_relation, $album_id);

        $data['start'] = $start;

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
        $this->load->model('friend_model');
        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => (int)$user['use_id'], 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$this->session->userdata('sessionUser'), 'add_friend_by' => (int)$user['use_id']]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;
        
        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$user['use_id'], 'follower' => (int)$this->session->userdata('sessionUser')]);
        $data['getFollow'] = $getFollow;

        $data['album'] = $this->db->get_where('tbtt_album_media', array('album_id' => $album_id))->row();
        $data['album_total'] = $this->db->select('count(*) as total')->get_where('tbtt_album_media_detail', array('ref_album_id' => $album_id, 'ref_user' => (int)$user['use_id'], 'ref_shop_id' => 0))->row()->total;

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/personal/elements-library/image-items', $data, true);
            die();
        }else{
            $this->load->view('home/personal/pages/library-image', $data);
        }
    }

    /**
     * @param $data
     * @param $shop
     * load menu item for shop
     * chỉ load những category có link trong đó
     */
    private function _get_menu_item(&$data, $user_id)
    {
        $this->load->model('link_model');
        $cat_menu_ids = $this->link_model->get_category_ids_by_user($user_id);
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

    function friends($type=''){
        if(empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $this->set_layout('home/personal/profile-layout');
        $this->load->model('follow_model');
        $this->load->model('friend_model');

        $info_public = $this->info_public;
        $is_owner = false;
        $info_public = $this->info_public;

        $session = (int)$this->session->userdata('sessionUser');
        $profile = (int)$info_public['use_id'];
        if($this->input->post('keyword')){
            $keyword = $this->input->post('keyword');
        }
        if($this->isLogin() && $profile == $session){
            $is_owner = true;
        }
        $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['shop'] = $this->shop_model->find_where(
            ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
            ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        );

        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => $profile, 'add_friend_by' => $session]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => $session, 'add_friend_by' => $profile]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;

        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => $profile, 'follower' => $session]);
        $data['getFollow'] = $getFollow;

        $numcount = 0;
        $listuser = array();
        // Người theo dõi: người kb với bạn + người theo dõi bạn
        $select = 'DISTINCT use_id,avatar,tbtt_user_follow.user_id as user_follow, tbtt_user_follow.follower, hasFollow, priority, use_fullname, LEFT(use_fullname,1) as Alpha';
        $order = 'use_fullname';
        $by = 'ASC';
        switch ($type) {
            case 'invitation':
                $where = 'tbtt_user_friend.accept = 0 AND tbtt_user_friend.add_friend_by = tbtt_user_follow.follower AND tbtt_user_friend.user_id = '.$profile.' AND use_id != '.$profile;
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $on1 = 'use_id = add_friend_by';
                $on2 = 'tbtt_user_friend.user_id = tbtt_user_follow.user_id';
                // $listuser['alpha'] = $this->follow_model->fetch_join('LEFT(use_fullname,1) as Alpha', $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.follower', $order, $by,'Alpha');
                // $listuser['user'] = $this->follow_model->fetch_join($select, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.follower', $order, $by);
                $listuser['alpha'] = $this->user_model->fetch_join1('LEFT(use_fullname,1) as Alpha', 'LEFT', 'tbtt_user_friend', $on1, 'LEFT', 'tbtt_user_follow', $on2, $where,$order, $by,'','','', 'Alpha');
                $listuser['user'] = $this->user_model->fetch_join1($select, 'LEFT', 'tbtt_user_friend', $on1, 'LEFT', 'tbtt_user_follow', $on2, $where,$order, $by,'','','', 'use_id');
                break;
            
            case 'insistence':
                $where = 'tbtt_user_friend.accept = 0 AND tbtt_user_friend.user_id = tbtt_user_follow.user_id AND tbtt_user_friend.add_friend_by = '.$profile;
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }

                $on1 = 'use_id = user_id';
                $on2 = 'tbtt_user_friend.add_friend_by = tbtt_user_follow.follower';
                
                $listuser['alpha'] = $this->user_model->fetch_join1('LEFT(use_fullname,1) as Alpha', 'LEFT', 'tbtt_user_friend', $on1, 'LEFT', 'tbtt_user_follow', $on2, $where,$order, $by,'','','', 'Alpha');
                $listuser['user'] = $this->user_model->fetch_join1($select, 'LEFT', 'tbtt_user_friend', $on1, 'LEFT', 'tbtt_user_follow', $on2, $where,$order, $by,'','','', 'use_id');
                break;
            
            case 'offriend':
                $select_of = 'DISTINCT use_id,avatar, use_fullname, LEFT(use_fullname,1) as Alpha';
                $where = 'a.`accept` = 1 AND b.accept = 1 AND use_id NOT IN ('.$session.','.$profile.') AND ((a.user_id = '.$profile.' AND b.user_id = '.$session.' AND a.add_friend_by = b.add_friend_by) 
                OR (a.add_friend_by = '.$profile.' AND b.add_friend_by = '.$session.' AND a.user_id = b.user_id) 
                OR (a.add_friend_by = '.$profile.' AND b.user_id = '.$session.' AND a.user_id = b.add_friend_by) 
                OR (a.user_id = '.$profile.' AND b.add_friend_by = '.$session.' AND a.add_friend_by = b.user_id))';
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $on1 = 'use_id = a.user_id OR use_id = a.add_friend_by';
                $on2 = 'use_id = b.user_id OR use_id = b.add_friend_by';
                $listuser['alpha'] = $this->user_model->fetch_join3($select_of, 'LEFT', 'tbtt_user_friend a', $on1, 'LEFT', 'tbtt_user_friend b', $on2,'','','', $where,'','','','','', 'Alpha');
                $listuser['user'] = $this->user_model->fetch_join3($select_of, 'LEFT', 'tbtt_user_friend a', $on1, 'LEFT', 'tbtt_user_friend b', $on2,'','','', $where, $order, $by);
                break;
            
            case 'follow':
                $where = 'tbtt_user_follow.user_id = '.$profile.' AND hasFollow = 1';
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $listuser['alpha'] = $this->follow_model->fetch_join('LEFT(use_fullname,1) as Alpha', $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.follower', $order, $by,'Alpha');
                $listuser['user'] = $this->follow_model->fetch_join($select, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.follower', $order, $by);
                break;
            
            case 'isfollow':
                $where = 'follower = '.$profile.' AND hasFollow = 1';
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $listuser['alpha'] = $this->follow_model->fetch_join('LEFT(use_fullname,1) as Alpha', $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.user_id', $order, $by,'Alpha');
                $listuser['user'] = $this->follow_model->fetch_join($select, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.user_id', $order, $by);
                break;
            
            case 'priofollow':
                $where = 'follower = '.$profile . ' AND hasFollow = 1 AND priority = 1';
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $listuser['alpha'] = $this->follow_model->fetch_join('LEFT(use_fullname,1) as Alpha', $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.user_id', $order, $by,'Alpha');
                $listuser['user'] = $this->follow_model->fetch_join($select, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_follow.user_id', $order, $by);
                break;
            
            case 'listblock':
                $select = 'DISTINCT use_id,avatar, use_fullname, LEFT(use_fullname,1) as Alpha';
                $where = 'blocked_by = '.$profile . ' AND user_id > 0 AND use_id != '.$profile;
                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $listuser['alpha'] = $this->blockuser_model->fetch_join('LEFT(use_fullname,1) as Alpha', $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_social_blocks.user_id', $order, $by,'Alpha');
                $listuser['user'] = $this->blockuser_model->fetch_join($select, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_social_blocks.user_id', $order, $by);
                break;
            
            default:
                $select = 'DISTINCT use_id,avatar, use_fullname, LEFT(use_fullname,1) as Alpha';
                $where = 'use_status = 1 AND accept = 1 AND (add_friend_by = '.$profile.' OR user_id = '.$profile.') AND use_id != '.$profile;

                if(isset($keyword) && $keyword != ''){
                    $where .= ' AND (use_fullname like "%'.$keyword.'%" OR use_username like "%'.$keyword.'%" OR use_mobile like "%'.$keyword.'%")';
                }
                $listuser['alpha'] = $this->user_model->fetch_join('LEFT(use_fullname,1) as Alpha', 'INNER', 'tbtt_user_friend', 'use_id = user_id OR use_id = add_friend_by', $where, $order, $by,'','','','Alpha');
                $listuser['user'] = $this->user_model->fetch_join($select, 'INNER', 'tbtt_user_friend', 'use_id = user_id OR use_id = add_friend_by', $where, $order, $by,'','','','use_id');
                break;
        }

        $list_friends_user_id = array();
        $list_friends_addby = array();

        $friends_accept_user = array();
        $friends_accept_addby = array();
        $getFriend = $this->friend_model->fetch('id, accept, user_id, add_friend_by', 'user_id = ' .$session.' OR add_friend_by = '.$session);
        if(!empty($getFriend)){
            foreach ($getFriend as $key => $value) {
                if($value->user_id != $session){
                    array_push($list_friends_user_id, $value->user_id);
                    array_push($friends_accept_user, $value->accept);
                }else{
                    array_push($list_friends_addby, $value->add_friend_by);
                    array_push($friends_accept_addby, $value->accept);
                }
            }
        }

        $data['list_friends_user_id'] = $list_friends_user_id;
        $data['friends_accept_user'] = $friends_accept_user;

        $data['list_friends_addby'] = $list_friends_addby;
        $data['friends_accept_addby'] = $friends_accept_addby;

        if(!empty($listuser))
        {
            $select_of = 'DISTINCT use_id,avatar, use_fullname';
            foreach ($listuser['user'] as $key => $user) {
                $where = 'a.`accept` = 1 AND b.accept = 1 AND use_id NOT IN ('.$session.','.$user->use_id.') AND ((a.user_id = '.$user->use_id.' AND b.user_id = '.$session.' AND a.add_friend_by = b.add_friend_by) 
                OR (a.add_friend_by = '.$user->use_id.' AND b.add_friend_by = '.$session.' AND a.user_id = b.user_id) 
                OR (a.add_friend_by = '.$user->use_id.' AND b.user_id = '.$session.' AND a.user_id = b.add_friend_by) 
                OR (a.user_id = '.$user->use_id.' AND b.add_friend_by = '.$session.' AND a.add_friend_by = b.user_id))';
                $on1 = 'use_id = a.user_id OR use_id = a.add_friend_by';
                $on2 = 'use_id = b.user_id OR use_id = b.add_friend_by';
                $user->list_offriend = $this->user_model->fetch_join3($select_of, 'LEFT', 'tbtt_user_friend a', $on1, 'LEFT', 'tbtt_user_friend b', $on2,'','','', $where, $order, $by);

                $where = 'blocked_by = '. $session . ' AND user_id = '.$user->use_id;
                $user->isblock = count($this->blockuser_model->fetch_join($select_of, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_social_blocks.user_id', $order, $by));
            }
        }

        $data['listuser'] = $listuser;
        $data['type'] = $type;

        $where = 'tbtt_user_friend.accept = 0 AND tbtt_user_friend.add_friend_by = tbtt_user_follow.follower AND tbtt_user_friend.user_id = '.$profile.' AND use_id != '.$profile;
        $on1 = 'use_id = add_friend_by';
        $on2 = 'tbtt_user_friend.user_id = tbtt_user_follow.user_id';
        $data['count_invitation'] = count($listuser['user'] = $this->user_model->fetch_join1('use_id', 'LEFT', 'tbtt_user_friend', $on1, 'LEFT', 'tbtt_user_follow', $on2, $where,$order, $by,'','','', 'use_id'));

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = 'Trang bạn bè';
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = $info_public['profile_url'].'friends/'.$type;
        $type_share = TYPESHARE_PROFILE_FRIENDS;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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

        $this->load->view('home/personal/pages/list_friends', $data);
    }

    function ajax_status_friend()
    {
        $idUser = (int)$this->input->post('id_user');
        $user_name = $this->input->post('user_name');
        $result = ['error' => true];
        // if($this->session->userdata('sessionUser'))
        // {
        $session = (int)$this->session->userdata('sessionUser');
        $this->load->model('friend_model');
        $this->load->model('follow_model');
        $status_friend = '';
        $getFriend = $this->friend_model->get('id, accept, user_id, add_friend_by', '(user_id = '.$idUser.' AND add_friend_by = '.$session.')');
        
        if(!empty($getFriend) && $getFriend[0]->accept == 1){
            $status_friend .= '<li>Nhắn tin</li>';
            $status_friend .= '<li class="js-cancelfollow-user" data-id="'.$idUser.'">Hủy kết bạn</li>';
        }else{
            $status_friend .= '<li><a href="'.azibai_url().'/profile/'.$idUser.'/friends" target="_blank">Xem bạn bè</a></li>';
        }

        $getFollow = $this->follow_model->get('id, hasFollow, priority, user_id, follower', '(user_id = ' .$idUser.' AND follower = '.$session.') AND hasFollow = 1');
        
        if(!empty($getFollow)){
            
            if(!empty($getFriend) && $getFriend[0]->accept == 0){
                $status_friend .= '<li class="js-removefollow-user" data-id="'.$idUser.'">Xóa lời mời kết bạn</li>';
            }
            $status_friend .= '<li class="cancel-follow" data-id="'.$idUser.'">Bỏ theo dõi</li>';
            
            if($getFollow[0]->priority == 1){
                $status_friend .= '<li class="cancel-priority-follow cancel-priority-follow-'.$idUser.'" data-id="'.$idUser.'">Bỏ theo dõi ưu tiên</li>';
            }else{
                $status_friend .= '<li class="priority-follow priority-follow-'.$idUser.'" data-id="'.$idUser.'">Ưu tiên theo dõi</li>';
            }
        }else{
            $status_friend .= '<li class="is-follow" data-id="'.$idUser.'">Theo dõi</li>';
        }

        $this->load->model('blockuser_model');
        $getBlock = $this->blockuser_model->get('*', ['user_id' => $idUser, 'blocked_by' => $session]);

        if($this->session->userdata('sessionUser') && $getBlock[0]->blocked_by == $this->session->userdata('sessionUser'))
        {
            if($getBlock[0]->user_id = $idUser)
            {
                $status_friend .= '<li class="cancel-block cancel-block-'.$idUser.'" data-id="'.$idUser.'" data-name="'.$user_name.'">Bỏ chặn</li>';
            }
        }else
        {
            $status_friend .= '<li class="block-friend block-friend-'.$idUser.'" data-id="'.$idUser.'" data-name="'.$user_name.'">Chặn</li>';
        }
        $result = ['error' => false, 'cancelBlock' => true, 'user' => true, 'status' => $status_friend, 'getFollow' => $getFollow];
        // }
        // else{
        //     $result = ['error' => true, 'cancelBlock' => false, 'user'=> false];
        // }

        echo json_encode($result);
        die();
    }

    function ajax_poplist_user(){

        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $session = (int)$this->session->userdata('sessionUser');
        $user = (int)$this->input->post('id');

        $select_of = 'DISTINCT use_username, use_id as user_id, avatar, use_fullname';
        $where = 'a.`accept` = 1 AND b.accept = 1 AND use_id NOT IN ('.$session.','.$user.') AND ((a.user_id = '.$user.' AND b.user_id = '.$session.' AND a.add_friend_by = b.add_friend_by) 
        OR (a.add_friend_by = '.$user.' AND b.add_friend_by = '.$session.' AND a.user_id = b.user_id) 
        OR (a.add_friend_by = '.$user.' AND b.user_id = '.$session.' AND a.user_id = b.add_friend_by) 
        OR (a.user_id = '.$user.' AND b.add_friend_by = '.$session.' AND a.add_friend_by = b.user_id))';
        $on1 = 'use_id = a.user_id OR use_id = a.add_friend_by';
        $on2 = 'use_id = b.user_id OR use_id = b.add_friend_by';
        $list_offriend = $this->user_model->fetch_join3($select_of, 'LEFT', 'tbtt_user_friend a', $on1, 'LEFT', 'tbtt_user_friend b', $on2,'','','', $where, $order, $by);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  $session);
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  $session);

        $result = ['total' => $total, 'data' => $list_offriend, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'page' => $page, 'show_more' => true];
        if($this->session->userdata('sessionUser')){
            $result['user'] = $this->session->userdata('sessionUser');
        }
        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    function search_api(){
        $keyword = rawurlencode($this->input->post('keyword'));
        $rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
        $jData = $this->callAPI('GET', API_SEARCH_USER.'?keyword='.$keyword, [], $rent_header);
        echo $jData;
        exit();
    }

    function list_search(){
        if(empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $this->set_layout('home/personal/profile-layout');
        $this->load->model('follow_model');
        $this->load->model('friend_model');

        $info_public = $this->info_public;
        $is_owner = false;

        if(!isset($_REQUEST['keyword'])){
            redirect($info_public['profile_url'], 'location');
            exit();
        }
        $session = (int)$this->session->userdata('sessionUser');
        $profile = (int)$info_public['use_id'];
        if($this->input->post('keyword')){
            $keyword = $this->input->post('keyword');
        }
        if($this->isLogin() && $profile == $session){
            $is_owner = true;
        }
        $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        $data['shop'] = $this->shop_model->find_where(
            ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
            ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        );

        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => $profile, 'add_friend_by' => $session]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => $session, 'add_friend_by' => $profile]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;

        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => $profile, 'follower' => $session]);
        $data['getFollow'] = $getFollow;

        $keyword = rawurlencode(trim($_REQUEST['keyword']));
        $rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
        $jData = $this->callAPI('GET', API_SEARCH_USER.'?keyword='.$keyword, [], $rent_header);
        
        $list_search = json_decode($jData)->data;
        $list_user_id = array();
        if(!empty($list_search)){
            foreach ($list_search as $key => $value) {
                array_push($list_user_id, $value->user_id);
            }
        }
        // Người theo dõi: người kb với bạn + người theo dõi bạn
        $select = 'DISTINCT use_id,avatar,tbtt_user_follow.user_id as user_follow, tbtt_user_follow.follower, hasFollow, priority, use_fullname, LEFT(use_fullname,1) as Alpha';
        $order = 'use_fullname';
        $by = 'ASC';

        $numcount = 0;
        $listuser = array();

        $str_user = implode(',', $list_user_id);
        if($str_user != ''){
            $listuser['alpha'] = $this->user_model->fetch_join('LEFT(use_fullname,1) as Alpha', '', '', '', 'use_id IN('.$str_user.')', $order, $by,'','',false, 'Alpha');
            $listuser['user'] = $this->user_model->fetch_join('DISTINCT use_id, avatar, use_fullname, LEFT(use_fullname,1) as Alpha', '', '', '', 'use_id IN('.$str_user.')', $order, $by,'','',false, 'use_id');

            $list_friends_user_id = array();
            $list_friends_addby = array();

            $friends_accept_user = array();
            $friends_accept_addby = array();
            $getFriend = $this->friend_model->fetch('id, accept, user_id, add_friend_by', 'user_id = ' .$session.' OR add_friend_by = '.$session);
            if(!empty($getFriend)){
                foreach ($getFriend as $key => $value) {
                    if($value->user_id != $session){
                        array_push($list_friends_user_id, $value->user_id);
                        array_push($friends_accept_user, $value->accept);
                    }else{
                        array_push($list_friends_addby, $value->add_friend_by);
                        array_push($friends_accept_addby, $value->accept);
                    }
                }
            }

            $data['list_friends_user_id'] = $list_friends_user_id;
            $data['friends_accept_user'] = $friends_accept_user;

            $data['list_friends_addby'] = $list_friends_addby;
            $data['friends_accept_addby'] = $friends_accept_addby;

            if(!empty($listuser))
            {
                $select_of = 'DISTINCT use_id, avatar, use_fullname';
                foreach ($listuser['user'] as $key => $user) {
                    $where = 'a.`accept` = 1 AND b.accept = 1 AND use_id NOT IN ('.$session.','.$user->use_id.') AND ((a.user_id = '.$user->use_id.' AND b.user_id = '.$session.' AND a.add_friend_by = b.add_friend_by) 
                    OR (a.add_friend_by = '.$user->use_id.' AND b.add_friend_by = '.$session.' AND a.user_id = b.user_id) 
                    OR (a.add_friend_by = '.$user->use_id.' AND b.user_id = '.$session.' AND a.user_id = b.add_friend_by) 
                    OR (a.user_id = '.$user->use_id.' AND b.add_friend_by = '.$session.' AND a.add_friend_by = b.user_id))';
                    $on1 = 'use_id = a.user_id OR use_id = a.add_friend_by';
                    $on2 = 'use_id = b.user_id OR use_id = b.add_friend_by';
                    $user->list_offriend = $this->user_model->fetch_join3($select_of, 'LEFT', 'tbtt_user_friend a', $on1, 'LEFT', 'tbtt_user_friend b', $on2,'','','', $where, $order, $by);

                    $where = 'blocked_by = '. $session . ' AND user_id = '.$user->use_id;
                    $user->isblock = count($this->blockuser_model->fetch_join($select_of, $where, 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_user_social_blocks.user_id', $order, $by));
                }
            }
        }

        $data['listuser'] = $listuser;

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = 'Trang tìm bạn bè';
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = base_url().'list-search-user?keyword='.$keyword;
        $type_share = TYPESHARE_PROFILE_FRIENDS;
        $this->load->model('share_metatag_model');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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

        $this->load->view('home/personal/pages/search-user', $data);
    }

    // ------------------------------------------------------------------------
    // ------------------------------------------------------------------------
    // -----------------------------COLLECTION---------------------------------
    public function collection_link_v2()
    {
        // include api
        $this->load->file(APPPATH.'controllers/home/api_collection.php', false);
        // end

        $data['info_public']    =  $this->info_public;
        $user                   = $this->info_public;
        $user_id                = (int)$this->session->userdata('sessionUser');
        $data['is_owner']       = $user['use_id'] == $user_id;


        // include api
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
            $make_call = Api_collection::get_data_collection_link($user['use_id'], $last_id, true);
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
            $make_call = Api_collection::get_data_collection_link($user['use_id'], 0, true);
            $make_call = json_decode($make_call, true);

            $data['items'] = $make_call['data']['data'];
            $data['is_next'] = $make_call['data']['next'];

            $this->set_layout('home/personal/collection-ver2/collection-layout');
            $this->load->view('home/personal/collection-ver2/page/page-collection-link', $data, FALSE);
        }
    }

    public function collection_link_detail_v2($collection_id)
    {
        // include api
        $this->load->file(APPPATH.'controllers/home/api_collection.php', false);
        // end

        $data['info_public']    =  $this->info_public;
        $user                   = $this->info_public;
        $user_id                = (int)$this->session->userdata('sessionUser');
        $data['is_owner']       = $user['use_id'] == $user_id;

        if($this->input->is_ajax_request()) {
            // // get data
            $last_created_at = $this->input->post('last_created_at') ? $this->input->post('last_created_at') : 0;
            $make_call = Api_collection::get_data_detail_collection_link($user['use_id'], $collection_id, $last_created_at);
            $make_call = json_decode($make_call, true);

            $items = $make_call['data']['data'];

            $html = '';
            foreach ($items as $key => $item) {
                $html .= $this->load->view('home/personal/collection-ver2/element/item-collection-link-detail', ['item' => $item], TRUE);
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
            $make_call = Api_collection::get_data_detail_collection_link($user['use_id'], $collection_id);

            $data['items'] = $make_call['links'];
            $data['collection'] = $make_call['collection'];
            $data['popup_list_collection'] = Api_collection::get_data_mini_collection_link();
            $data['collection']['total'] = $make_call['total'] ? $make_call['total'] : 0;
            $data['like'] = $make_call['liked'] ? $make_call['liked'] : 0;
            $data['share'] = $make_call['count_shares'] ? $make_call['count_shares'] : 0;
            $data['comment'] = $make_call['count_comments'] ? $make_call['count_comments'] : 0;
            $data['is_next'] = $make_call['next'];
            $data['has_black_version'] = true;

            $this->set_layout('home/personal/collection-ver2/collection-layout');
            $this->load->view('home/personal/collection-ver2/page/page-collection-link-detail.php', $data, FALSE);
        }
    }
    // ------------------------------------------------------------------------
    // ------------------------------------------------------------------------
    // ------------------------------------------------------------------------

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Check Permission Affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    private function checkAffliatePer($checkIsUser = false) {
        $iUserId = (int)$this->session->userdata('sessionUser');
        if(empty($this->info_public)){
            redirect(base_url() . 'login', 'location');
            exit();
        }
        $info_public = $this->info_public;

        if($checkIsUser == true) {
            if($iUserId != $info_public['use_id']){
                redirect(base_url() . 'profile/'.$info_public['use_id'], 'location');
                exit();
            }
        }
        

        $oUser = $this->user_model->get("affiliate_level,parent_id","use_id = " . $iUserId);
        if(empty($oUser)) {
            redirect(base_url() . 'profile/'.$info_public['use_id'], 'location');
            exit();
        }

        $aPermissionLevel = array(1,2,3);
        if(!in_array($oUser->affiliate_level, $aPermissionLevel)) {
            redirect(base_url() . 'profile/'.$info_public['use_id'], 'location');
            exit();
        }

        $info_public['affiliate_level']   = $oUser->affiliate_level;
        $info_public['parent_id']         = $oUser->parent_id;
        
        return $info_public;
    }

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Page affiliate profile
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliate() {
        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($data['is_parent']['open_chose'])) {
            $info_public = $this->info_public;

            $data['user_infomation'] = $info_public;
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end
            // include aParentId
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_home_dashboard($data['is_parent']['type_affiliate'], $data['is_parent']['id']);
        }else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-home', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Page affiliate list
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliatelist() {
        $data['is_parent'] = $this->_checkAffliateOwner();

        if($data['is_parent']['type_affiliate'] == 2 && $_REQUEST['type_sv'] == 1) {
            $_REQUEST['type_sv'] = 2;
            $_params = http_build_query($_REQUEST);
            $url = azibai_url("/affiliate/list?{$_params}");
            redirect($url, 'location'); 
        }

        $info_public = $this->info_public;
        $data['user_infomation'] = $info_public;

        if(strcmp($_REQUEST['af_id'], $info_public['af_key']) != 0 && $_REQUEST['type_sv'] == 1) {
            $this->session->set_userdata('urlservice', 'shop/service?af_id='.$_REQUEST['af_id']);
            redirect(azibai_url('/login'), 'location');
            exit();
        }

        if(!isset($_REQUEST['type_sv']) || !in_array($_REQUEST['type_sv'], [1, 2, 3,4,5])){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {

            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }
    
            // Tài add
            $user              = $info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end
    
            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            if($data['is_parent']['type_affiliate'] == 1) {
                $aDatas = array(
                    'type_affiliate' => $data['is_parent']['type_affiliate'],
                    'type_service'   => $_REQUEST['type_sv'],
                );
            } else {
                $aDatas = array(
                    'type_affiliate' => $data['is_parent']['type_affiliate'],
                    'type_service'   => $_REQUEST['type_sv'],
                    'parent_id'      => $data['is_parent']['id'],
                );
            }
            if($_REQUEST['type_sv'] != 3) {
                $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
                if ($page < 1) {
                    $page = 1;
                }
                $limit = 10;
                $data['data_aff'] = Api_affiliate::get_list_service_affiliate($user_id, $aDatas, $page, $limit);

                //pagination
                $url_full = get_current_full_url();
                $process_url = parse_url($url_full);
                parse_str($process_url['query'], $params);
                if(isset($params['page'])) {
                    unset($params['page']);
                }
                $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);
        
                $config = $this->_config;
                $config['total_rows'] = $data['data_aff']['total'];
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
            } else {
                // type_sv = 3;
                $data['data_aff'] = Api_affiliate::get_list_service_affiliate($user_id, $aDatas);
            }

        }else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-service', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Page affiliate list
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliateselect() {
        $info_public = $this->checkAffliatePer();
        
        $this->load->model('affiliate_price_model');
        $this->load->model('affiliate_profile_user_model');

        $data['user_infomation'] = $info_public;

        if( $info_public['affiliate_level'] == 1 || $info_public['affiliate_level'] == 2) {
            $data['show_affiliate_menu'] = 1;
        }else {
            $data['show_affiliate_menu'] = 0;
        }

        $data['services'] = $this->affiliate_profile_user_model->get('','user_id = '.$info_public['use_id']);

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/list_service_select', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Page affiliate list coupons
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliatecoupons() {
        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }
        $info_public = $this->checkAffliatePer();
        $data['user_infomation'] = $info_public;

        if( $info_public['affiliate_level'] == 1 || $info_public['affiliate_level'] == 2) {
            $data['show_affiliate_menu'] = 1;
        }else {
            $data['show_affiliate_menu'] = 0;
        }

        $select = '*';
        $from =  '(SELECT DISTINCT tbtt_product.pro_id, pro_type, pro_user, tbtt_product.pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, pro_view, pro_quality,
                is_product_affiliate, af_amt, af_rate, af_dc_amt, af_dc_rate,
                IF(id > 0, MAX(dp_cost), MAX(pro_cost)) AS price_max,
                IF(id > 0, MIN(dp_cost), MIN(pro_cost)) AS pirce_min,
                COUNT(id) AS have_num_tqc
            FROM tbtt_product
            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = tbtt_product.pro_id
            WHERE pro_status = 1 AND pro_instock > 0
            GROUP BY pro_id) as tbtt_query';
        $where = "pro_type = 2 && is_product_affiliate = 1";
        $order = "created_date";
        $by = "DESC";

        $page = 1;
        if ($this->input->post('page') > 1) {
            $page = (int)$this->input->post('page');
        }
        
        $limit = 20;
        $start = ($page - 1) * $limit;
        
        // sp mới
        $data['services'] = $this->db->query("SELECT $select FROM $from WHERE $where ORDER BY $order $by LIMIT $limit OFFSET $start")->result();
        $data['currentuser'] = $info_public;
        $this->set_layout('home/personal/affiliate-layout');
        $this->load->view('home/personal/affiliate/list_coupons', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/09
     * Page affiliate coupons select list
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliateselectcoupons() {
        $info_public = $this->checkAffliatePer();
        $data['user_infomation'] = $info_public;

        if( $info_public['affiliate_level'] == 1 || $info_public['affiliate_level'] == 2) {
            $data['show_affiliate_menu'] = 1;
        }else {
            $data['show_affiliate_menu'] = 0;
        }

        $arr_pro_af = $this->db->query("SELECT pro_id FROM tbtt_product_affiliate_user WHERE use_id = ".$info_public['use_id'])->result();
        if(!empty($arr_pro_af)) {
            foreach ($arr_pro_af as $key => $value) {
                $arr_pro_af[$key] = $value->pro_id;
            }

            $currentuser['arr_pro_af'] = $arr_pro_af;
            $data['currentuser'] = (object) $currentuser;
        }
        

        $select = ['tbtt_product.pro_id','pro_category','pro_name','pro_descr','pro_cost','pro_currency','pro_image','pro_dir','pro_saleoff','pro_saleoff_value','pro_type_saleoff','end_date_sale','pro_minsale',
            'is_product_affiliate', 'af_amt', 'af_rate', 'af_dc_amt', 'af_dc_rate',
            'dp.id as dp_id', 'dp.dp_images','dp.dp_cost'];
        $where = [
            'coupon_new'    => 'pro_af.use_id = '. $info_public['use_id'] . ' AND pro_status = 1 AND pro_type = 2 AND ( pro_saleoff = 0 OR ( pro_saleoff = 1 AND (UNIX_TIMESTAMP() < begin_date_sale OR UNIX_TIMESTAMP() > end_date_sale) ) )'
        ];

        $join = 'LEFT';
        $table = '(SELECT MIN(id) as id, dp_images, dp_cost, dp_pro_id
                    FROM tbtt_detail_product
                    GROUP BY dp_pro_id) dp';
        $on = 'dp.dp_pro_id = pro_id';

        // Affiliate shop - lấy tất cả sản phẩm cho cộng tác viên bán
        $join2 = 'INNER';
        $table2 = 'tbtt_product_affiliate_user pro_af';
        $on2 = 'pro_af.pro_id = tbtt_product.pro_id';
        foreach ($where as $key => $value) {
            $where[$key] .= ' AND is_product_affiliate = 1';
        }

        $data['for_shop_af'] = true;

        $limit = 20;
        $start = 0;
        $order = 'created_date';
        $by = 'DESC';
        $distinct = false;
        $group_by = NULL;

        $page = 1;
        if ($this->input->post('page') > 1) {
            $page = (int)$this->input->post('page');
        }
        
        $limit = 20;
        $start = ($page - 1) * $limit;
        
        // sp mới
        $data['services'] = $this->product_model->fetch_join_query($select, $join, $table, $on, $join2, $table2, $on2, $where['coupon_new'], $order, $by, $start, $limit, $distinct, $group_by);

        $this->set_layout('home/personal/affiliate-layout');
        $this->load->view('home/personal/affiliate/list_coupon_select', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Ajax add affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function ajaxAddAffiliate() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Thêm affiliate thất bại!';
        $result['type']     = 'error';
        $this->load->model('affiliate_profile_user_model');
        $this->load->model('package_model');
        $this->load->model('affiliate_price_model');

        $iUserId = (int)$this->session->userdata('sessionUser');
        if($iUserId == '' || $iUserId == 0){
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $oAffUser = $this->user_model->get("affiliate_level,parent_id","use_id = " . $iUserId);
        if(count( (array) $oAffUser ) == 0 ){
            $result['message']  = 'User không tồn tại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $id = $this->input->post('id');

        $aPackSelect = $this->affiliate_profile_user_model->getwhere('','user_id = '.$iUserId.' && service_id = '.$id);
        if(!empty($aPackSelect)) {
            $result['message']  = '<div class="error">Bạn đã đăng ký gói dịch vụ này!</div>';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $aPack = $this->getPriceAffiliate($id);
        if(!empty($aPack)) {
            $aAff = array(
                'service_id'        => $id,
                'user_id'           => $iUserId,
                'info_id'           => $aPack['info_id'],
                'discount_price'    => $aPack['discount_price'],
                'discount_rate'     => $aPack['discount_rate'],
                'discount_percen'   => $aPack['discount_percen']
            );
            $iAff = $this->affiliate_profile_user_model->add($aAff);
            if($iAff > 0) {
                $result['message']  = '<div class="success">Thêm Affiliate thành công!</div>';
                $result['type']     = 'success';
            }
        }
        echo json_encode($result);
        die();

    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Ajax add affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function ajaxEditAffiliate() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Sửa affiliate user thất bại!';
        $result['type']     = 'error';
        $data['is_parent'] = $this->_checkAffliateOwner();
        $iUserId = (int)$this->session->userdata('sessionUser');
        if($iUserId == '' || $iUserId == 0){
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $id     = $this->input->post('id');
        $level  = (int) $this->input->post('level');
        $type_request  = (int) $this->input->post('type_request');

        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }

        $url = $this->config->item('api_edit_level');

        $params = array(
            'user_id'   => $id
        );
        if($level >= 0 && is_numeric($this->input->post('level'))) {
            $params['level'] = $level;
        }

        if($type_request == 1) {
            $params['type_affiliate'] = 2;
            $params['parent_id'] = $iUserId;
        }else {
            $params['type_affiliate'] = $data['is_parent']['type_affiliate'];
            $params['parent_id'] = $data['is_parent']['parent_id'];
        }

        $make_call = $this->callAPI('PUT', $url, json_encode($params), $rent_header);

        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] == 1) {
            $result['message']  = 'Sửa affiliate user thành công!';
            $result['type']     = 'success';
        }else {
            $result['message']  = $make_call['msg'];
            $result['type']     = 'error';
        }

        echo json_encode($result);
        die();

    }

    /**
     ***************************************************************************
     * Created: 2019/05/14
     * Get affiliate user
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    public function getAffilateUser () {
        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }
        /**
         * 0: thành viên mới
         * 1: nhà phân phối
         * 2: tổng đại lý
         * 3: đại lý
        */
        $value_request = [0,1,2,3,'all'];
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($data['is_parent']['open_chose'])) {

            $aListId = array();
            $iUserId = (int)$this->session->userdata('sessionUser');
            $info_public = $this->info_public;
            $data['user_infomation'] = $info_public;
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            if(!isset($_REQUEST['affiliate']) || !in_array($_REQUEST['affiliate'], $value_request)) {
                redirect(azibai_url('/affiliate'),'refresh');
                exit();
            }

            $iAff = $_REQUEST['affiliate'] != 'all' ? $_REQUEST['affiliate'] : null;

            // Tài add
            $user              = $info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            $data['user_aff_level'] = $this->session->userdata('affiliate_level');
            // end

            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;

            $user_type = $_REQUEST['user_type'] ? $_REQUEST['user_type'] : null;
            $search = $_REQUEST['search_aff'] ? $_REQUEST['search_aff'] : '';

        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        if(isset($data['is_parent']['type_affiliate'])) {
            $parent_id = $data['is_parent']['id'];
        }

            $data['data_aff'] = Api_affiliate::get_list_user_affiliate($user_id, $iAff, $page, $limit, $user_type, $search,$data['is_parent']['type_affiliate'],$parent_id);
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

        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-user', $data); 
    }

    /**
     ***************************************************************************
     * Created: 2019/05/14
     * Get affiliate invite
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    public function getAffilateInvite () {
        /**
         * 0: thành viên mới
         * 1: nhà phân phối
         * 2: tổng đại lý
         * 3: đại lý
        */
        $value_request = [0,1,2,3,'all'];
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($data['is_parent']['open_chose'])) {

            $aListId = array();
            $iUserId = (int)$this->session->userdata('sessionUser');
            $info_public = $this->info_public;
            $data['user_infomation'] = $info_public;

            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end


            // include api
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            // data list user affiliate
            $url = $this->config->item('api_aff_list_invite');
            $url = str_replace(['{$user_id}','{$accept}'], [$user_id,0], $url);
            $params = null;
            $make_call = $this->callAPI('GET', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            if($make_call['status'] == 1) {
                $data['aListInvite'] = $make_call['data'];
                $data['data_aff']['total'] = array(
                    'all'       => $make_call['iTotal'] ? $make_call['iTotal'] : 0,
                    'lv2'       => $make_call['iTotalLv2'] ? $make_call['iTotalLv2'] : 0,
                    'lv3'       => $make_call['iTotalLv3'] ? $make_call['iTotalLv3'] : 0,
                    'user_new'  => $make_call['iUserNew'] ? $make_call['iUserNew'] : 0,
                    'user_buy'  => $make_call['iUserBuy'] ? $make_call['iUserBuy'] : 0,
                );
            }
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-user-list-invite', $data);
        
    }

    /**
     ***************************************************************************
     * Created: 2019/05/14
     * Get affiliate invite A
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    public function getAffilateInviteA () {
        /**
         * 0: thành viên mới
         * 1: nhà phân phối
         * 2: tổng đại lý
         * 3: đại lý
        */
        $value_request = [0,1,2,3,'all'];
        $data['is_parent'] = $this->_checkAffliateOwner();

        $aListId = array();
        $iUserId = (int)$this->session->userdata('sessionUser');
        $info_public = $this->info_public;
        $data['user_infomation'] = $info_public;

        $data['show_affiliate_menu'] = 0;
        

        // Tài add
        $user              = $info_public;
        $user_id           = (int)$this->session->userdata('sessionUser');
        $data['is_owner']         = $user['use_id'] == $user_id;
        $data['show_sub_aff'] = true;
        $data['open_chose'] = 0;
        // end


        // include api
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data list user affiliate
        $url = $this->config->item('api_aff_list_invite');
        $url = str_replace(['{$user_id}','{$accept}'], [$user_id,0], $url);
        $params = null;
        $make_call = $this->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        
        if($make_call['status'] == 1) {
            $data['aListInvite'] = $make_call['data'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-user-list-invitea', $data);
        
    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Ajax add affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function ajaxGetService() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy Service thất bại!';
        $result['type']     = 'error';

        $iUserId = (int)$this->session->userdata('sessionUser');
        if($iUserId == '' || $iUserId == 0){
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $aSystem = $this->_checkAffliateOwner();

        $html_price = '';

        $id         = $this->input->post('id');
        $user_id    = $this->input->post('user_id');
        $aService   = $this->getPriceAffiliate($id);
        $aAffPrice  = array();
        $isEdit     = false;
        $iUserId = (int)$this->session->userdata('sessionUser');
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $url = $this->config->item('api_get_configservice').'?service_id='.$id;
        // Set loại affiliate
        if($aSystem['type_affiliate']) {
            $url .= '&type_affiliate='.$aSystem['type_affiliate'];
        }
        // Nếu cấu hình cho user thì lấy thêm user id
        if($user_id != '') {
            $url .= '&user_id='.$user_id;
        }

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] == 1) {
            $aAffPrice  = $make_call['data'];
            $isEdit     = $make_call['data']['isEdit'];
        }

        if($isEdit == true) {
            if($user_id != '') {
                $aService['affiliate_data'] = !empty($aAffPrice) ? $aAffPrice : '';
            }else {
                $aService['affiliate_data'] = !empty($aAffPrice) ? $aAffPrice : '';
                $aService['prefix_name_input'] = 'price_aff_';
            }
        } else {
            $result['message']  = 'Bạn không được cấu hình dịch vụ này';
            echo json_encode($result);
            die();
        }

        $this->load->model('package_model');
        $this->load->model('affiliate_price_model');

        if(!empty($aService)) { // discount_percen
            // $aService['discount_percen'] > 0 ? '' : $aService['discount_percen'] = 0;
            $result['data']             = $aService;
            $result['affiliate_level']  = $html_price;
            $result['message']          = 'Lấy Service thành công!';
            $result['type']             = 'success';
        }
        echo json_encode($result);
        die();
        
    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Ajax edit service
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function ajaxEditService() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Sửa Service thất bại!';
        $result['type']     = 'error';

        $iUserId = (int)$this->session->userdata('sessionUser');
        if($iUserId == '' || $iUserId == 0){
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $this->load->model('package_model');
        $this->load->model('affiliate_level_model');
        $this->load->model('affiliate_price_model');

        $affiliatelevel = $this->affiliate_level_model->get();
        $aListPrice = array();
        if(!empty($this->input->post('input'))) {
            foreach ($this->input->post('input') as $iKI => $aInput) {
                $aListPrice[$aInput['name']] = (int)$aInput['value'];
            }
        }

        $id = (int) $this->input->post('id');

        $user_id = (int) $this->input->post('user_id');

        $user_set = $iUserId;
        $user_app = 0;

        if($user_id != '') {
            $oAffUser = $this->user_model->get("affiliate_level,parent_id","use_id = " . $user_id);
            if(!empty( (array) $oAffUser )) {
                $user_set = $oAffUser->parent_id;
                $user_app = $user_id;
            }
        }
        $aSystem = $this->_checkAffliateOwner();

        // lấy data của service
        $type_affiliate = $aSystem['type_affiliate'];
        $service_id = (int) $this->input->post('id');
        $user_id = (int) $this->input->post('user_id');

        if($user_id != '') {
            $params['price_aff'] = array_values($aListPrice)[0];
            $params['service_id'] = $service_id;
            $params['user_id'] = $user_id;
            $params['type_affiliate'] = $type_affiliate;

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: application/json";
            }
            $url = $this->config->item('api_update_configservice');
            $make_call = $this->callAPI('PUT', $url, json_encode($params), $rent_header);
            $make_call = json_decode($make_call, true);
        } else {
            $params = $aListPrice;
            $params['service_id'] = $service_id;
            $params['type_affiliate'] = $type_affiliate;

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: application/json";
            }
            $url = $this->config->item('api_update_configservice_A');
            $make_call = $this->callAPI('PUT', $url, json_encode($params), $rent_header);
            $make_call = json_decode($make_call, true);
        }

        if($make_call['status'] == 1) {
            $result['message'] = 'Cập nhật thành công!';
            $result['type'] = 'success';
        } else {
            $result['message'] = $make_call['msg'];
        }

        echo json_encode($result);
        die();

    }

    /**
     ***************************************************************************
     * Created: 2019/05/10
     * Ajax edit service
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function ajaxDeleteService() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Sửa Service thất bại!';
        $result['type']     = 'error';

        $iUserId = (int)$this->session->userdata('sessionUser');
        if($iUserId == '' || $iUserId == 0){
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }

        $id = $this->input->post('id');

        $this->load->model('affiliate_profile_user_model');

        $aAffUse =  $this->affiliate_profile_user_model->getwhere('*','id = '.$id);
        if(!empty($aAffUse)) {
            $this->affiliate_profile_user_model->delete($id,'id',false);
            $result['message']          = '<div class="success">Xóa Service thành công!</div>';
            $result['type']             = 'success';
        }

        echo json_encode($result);
        die();
        
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
     * Created: 2019/05/10
     * Get price user affiliate
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    private function getPriceAffiliateUser($id,$parent_id,$service_id,$iLevel) {
        $this->load->model('package_model');
        $this->load->model('affiliate_price_model');
        $aPack = array();
        if($id != 0) {
            // Ưu tiên 1 : lấy giá và cấp trên set cho nó
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$service_id.' && user_set = '.$parent_id.' && user_app = '.$id.' && id_level = '.$iLevel); 
        }
        
        // Ưu tiên 2 : Nếu ưu tiên 1 ko có thì lấy giá của đại lý cấp trên set cho toàn bộ affiliate cùng cấp
        if(empty($aAffPrice)) {
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$service_id.' && user_set = '.$parent_id.' && user_app = 0 && id_level = '.$iLevel);
        }
        // Ưu tiên 3 : nếu cả 2 cái trên không có thì lấy giá azibai set cho affiliate cùng cấp
        if(empty($aAffPrice)) {
            $aAffPrice = $this->affiliate_price_model->getwhere("*",'service_id = '.$service_id.' && user_set = 0 && user_app = 0 && id_level = '.$iLevel);
        }

        // Ưu tiên 4 : nếu ko set giá thì lấy giá gốc

        if(!empty($aAffPrice)) {
            $aPack['month_price']       = $aAffPrice['discount_price'];
            $aPack['discount_price']    = $aAffPrice['discount_price'];
            $aPack['discount_rate']     = $aAffPrice['cost'] - $aAffPrice['discount_price'];
            $aPack['discount_percen']   = $aAffPrice['discount_percen'];
        }else {
            $aPack['discount_price']    = 0;
            $aPack['discount_rate']     = 0;
            $aPack['discount_percen']   = 0;
        }
        
        return $aPack;
    }

    /**
     ***************************************************************************
     * Created: 2019/05/14
     * Get affiliate user
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function detailAffilateUser ($user_id) {
        if(!isset($_REQUEST['type_sv']) || !in_array($_REQUEST['type_sv'], [1, 2])){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        $iUserId = (int)$this->session->userdata('sessionUser');
        $info_public = $this->checkAffliatePer();
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($data['is_parent']['open_chose'])) {
            $data['id']  = $user_id;

            $data['user_infomation'] = $info_public;

            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            if($data['is_parent']['type_affiliate'] == 1) {
                $aDatas = array(
                    'type_affiliate' => $data['is_parent']['type_affiliate'],
                    'type_service'   => $_REQUEST['type_sv'],
                    'get_type'       => 2
                );
            } else {
                $aDatas = array(
                    'type_affiliate' => $data['is_parent']['type_affiliate'],
                    'type_service'   => $_REQUEST['type_sv'],
                    'get_type'       => 2,
                    'parent_id'      => $data['is_parent']['id'],
                );
            }
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;

            $data['data_aff'] = Api_affiliate::get_list_service_affiliate($user_id, $aDatas, $page, $limit);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }
            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['data_aff']['total'];
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
        }else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-user-setup-service-item', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/06/04
     * Page affiliate order
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function affiliateOrder() {
        /**
         * 0: tất cả
         * 1: tôi bán
         * 2: ctv bán
         */
        $value_request = [0, 1, 2];
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($_REQUEST['type']) || !in_array($_REQUEST['type'], $value_request)) {
            redirect(azibai_url('/affiliate'),'refresh');
            exit();
        }

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            $type_get = $_REQUEST['type'];

            $iUserId = (int)$this->session->userdata('sessionUser');
            $info_public = $this->info_public;

            $data['user_infomation'] = $info_public;

            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api;
            if(!empty($_REQUEST['start']) && !empty($_REQUEST['end'])) {
                $data['from_date'] = $start_date = date('d-m-Y', strtotime($_REQUEST['start']));
                $data['to_date'] = $end_date = date('d-m-Y', strtotime($_REQUEST['end']));
            } else {
                $start_date = null;
                $end_date = null;
                $data['from_date'] = $data['to_date'] = '';
            }
            $data['search'] = $search = $_REQUEST['search'] ? $_REQUEST['search'] : '';


            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;

            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_order($user_id, $type_get, $start_date, $end_date, $page, $limit, $search, $data['is_parent']);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }
            !empty($start_date) ? $params['start'] = $start_date : '';
            !empty($end_date) ? $params['end'] = $end_date : '';

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['data_aff']['order_total'];
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
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-order', $data);
    }

    public function affiliate_invite() {
        $data['is_parent'] = $this->_checkAffliateOwner();

        $iUserId = $this->session->userdata('sessionUser');
        if($iUserId == 0) {
            redirect(azibai_url('/affiliate'),'refresh');
            exit();
        }

        if(!isset($data['is_parent']['open_chose'])) {
            $data_return = [];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            // data statistic affiliate order
            $url = $this->config->item('api_aff_user_invite');
            $url = str_replace(['{$type_affiliate}','{$parent_id}'], [(int) $data['is_parent']['type_affiliate'], (int) $data['is_parent']['id']], $url);

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
            $type_affiliate = $data['is_parent']['type_affiliate'];
            $parent_id = $data['is_parent']['parent_id'];
            $limit = 20;
            $url = $this->config->item('api_aff_listfriend');
            $url = str_replace(['{$page}','{$limit}','{$search}'], [$page,$limit,$search], $url);
            if(empty($search)) {
                $url = str_replace('&search=', '', $url);
            }
            $url .= "&parent_id={$parent_id}&type_affiliate={$type_affiliate}";

            $make_call = $this->callAPI('GET', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            // set data return
            if($make_call['status'] == 1) {
                $data['aListFriend'] = $make_call['data']['data'];
            }
            // Tài add
            // $data['show_sub_aff'] = true;
            $data['not_show_cover'] = true;
            // end
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
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
            $this->set_layout('home/personal/profile-layout');
            $this->load->view('home/personal/affiliate/page/page-affiliate-invite-user', $data);
        }
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Ajax invite request
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function inviteRequest() {
        $data['is_parent'] = $this->_checkAffliateOwner();
        $result['message']  = 'Cập nhật lời mời cộng tác thất bại!';
        $result['type']     = 'error';

        $id         = $this->input->post('id');
        $iUserId    = $this->session->userdata('sessionUser');

        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }
        // data statistic affiliate order
        $url = $this->config->item('api_aff_invite_request');
        $url = str_replace(['{$id}'], [$id], $url);
        $params = [
            'user_id' =>  $iUserId
        ];
        $iAccept = $this->input->post('accept');
        
        // Đồng ý
        if($iAccept == 1) {
            $params['accept'] = 1;
        }

        // Từ chối
        if($iAccept == 0) {
            $params['public'] = 0;
        }

        $make_call = $this->callAPI('POST', $url, json_encode($params), $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $result['type']   = 'success';
        }else {
            $result['type']   = 'error';
        }

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Ajax invite user
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */
    public function inviteUser() {
        $data['is_parent'] = $this->_checkAffliateOwner();
        $result['message']  = 'Gửi lời mời cộng tác thất bại!';
        $result['type']     = 'error';

        $id         = $this->input->post('id');
        $iUserId    = $this->session->userdata('sessionUser');
        $iTypeAffiliate = (int) $data['is_parent']['type_affiliate'];

        $page_business = $this->input->post('page_business');
        if($page_business == 1) {
            $iParentId = (int) $iUserId;
            $iTypeAffiliate = 2;
        }else {
            $iParentId = (int) $data['is_parent']['id'];
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
        $url = str_replace(['{$type_affiliate}','{$parent_id}'], [$iTypeAffiliate, $iParentId], $url);
        $params = [
            'user_id' =>  $id
        ];
        
        $make_call = $this->callAPI('POST', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 0) {
            $result['message']   = $make_call['msg'];
            $result['type']     = 'error';
        }else {
            $result['message']   = 'Gửi lời mời thành công';
            $result['type']      = 'success';
        }

        echo json_encode($result);
        die();
    }

    public function affiliatelist_detail($service_id = 0)
    {
        $data['is_parent'] = $this->_checkAffliateOwner();
        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        $info_public = $this->info_public;
        if(strcmp($_REQUEST['af_id'], $info_public['af_key']) != 0 && $_REQUEST['type_sv'] == 1) {
            $this->session->set_userdata('urlservice', 'shop/service/detail/'.$service_id.'?af_id='.$_REQUEST['af_id']);
            redirect(azibai_url('/login'), 'location');
            exit();
        }

        if(strcmp($_REQUEST['af_id'], $info_public['af_key']) != 0 && $_REQUEST['type_sv'] == 2 && $_REQUEST['uid'] > 0) {
            $url = azibai_url("/voucher/{$_REQUEST['uid']}/$service_id") . "?af_id={$_REQUEST['af_id']}";
            redirect($url, 'location');
            exit();
        }

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            $iUserId = (int)$this->session->userdata('sessionUser');
            $type_affiliate = $_REQUEST['type_sv'] ? $_REQUEST['type_sv'] : 1;

            if($_REQUEST['af_id']) {
                $oAffUserP = $this->user_model->get('use_id','af_key = "' . $_REQUEST['af_id'] .'"');
                if(isset($oAffUserP->use_id)) {
                    $iUserId = $oAffUserP->use_id;
                }
            }

            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['service'] = Api_affiliate::get_detail_service($service_id, $iUserId, $type_affiliate);

            // làm data thanh toán
            $user_login  = MY_Loader::$static_data['hook_user'];
            if(empty($user_login)){
                $this->session->set_userdata('urlservice', 'shop/service/detail/'.$service_id.'?af_id='.$_REQUEST['af_id']);
                redirect(base_url() . 'login', 'location');
                exit();
            }

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
            $this->load->model('like_service_model');
            //Dem like
            $list_likes = $this->like_service_model->get('id', ['service_id' => (int)$service_id]);
            // đã like
            $is_like = $this->like_service_model->get('id', ['user_id' => (int)$this->session->userdata('sessionUser'), 'service_id' => (int)$service_id]);
            $data['list_likes'] = count($list_likes);
            $data['is_like'] = count($is_like);
            $ogimage = base_url().'templates/home/styles/images/svg/bg_dichvu.png';
            $ogurl = get_current_full_url();

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
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-service-detail', $data);
    }

    public function affiliateOrder_detail($order_id = 0)
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['order'] = Api_affiliate::get_detail_order($order_id);
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-list-order-detail', $data);
    }

    public function affiliate_income()
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $month_year = null; // fiter theo theo m-Y
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_income_sodu($month_year, $user_id, $page, $limit);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['data_aff']['order_total'];
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
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income', $data);
    }

    public function affiliate_provisonal_sum()
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $page = $_REQUEST['page'] ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_income_tamtinh($user_id, $page, $limit);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['data_aff']['order_total'];
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
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-provisional-sum', $data);

    }

    public function affiliate_history()
    {
        $value_request = ['all', 1, 2];
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            if(!isset($_REQUEST['view']) && in_array($_REQUEST['view'], $value_request) ) {
                redirect(azibai_url('/affiliate'),'refresh');
                exit();
            }

            if(empty($this->session->userdata('sessionUser'))) {
                redirect(azibai_url(), 'location');
            }

            // lấy dữ liệu dựa trên $type_view [all, deposit, withdraw]
            $type_view = $_REQUEST['view'] ? ($_REQUEST['view'] == 'all' ? null : $_REQUEST['view']) : '';

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
            $limit = 10;
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_income_history($user_id, $type_view, $page, $limit);

            //pagination
            $url_full = get_current_full_url();
            $process_url = parse_url($url_full);
            parse_str($process_url['query'], $params);
            if(isset($params['page'])) {
                unset($params['page']);
            }

            $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

            $config = $this->_config;
            $config['total_rows'] = $data['data_aff']['order_total'];
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
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-history', $data);
    }

    public function affiliate_manager_payment_acc()
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_income_payment_accounts($user_id);
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-payment-acc', $data);
    }

    public function affiliate_payment_show_create()
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_bank'] = Api_affiliate::get_list_bank_data();
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-payment-acc-create', $data);
    }

    public function affiliate_payment_show_edit($bank_id)
    {
        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {
            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_bank'] = Api_affiliate::get_list_bank_data();

            $data['data_bank'] = Api_affiliate::put_payment_account_income($bank_id);
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-payment-acc-edit', $data);
    }

    public function affiliate_payment_action($action)
    {
        $data['is_parent'] = $this->_checkAffliateOwner();
        $value_action = ['create'];
        if(!in_array($action, $value_action) && $this->session->userdata('sessionUser') > 0) {
            die('you can\'t access link ');
        }

        switch ($action) {
            case 'create':
                $this->load->library('form_validation');

                $this->form_validation->set_rules('bank_name', 'bank_name', 'required');
                $this->form_validation->set_rules('aff', 'aff', 'required');
                $this->form_validation->set_rules('account_number', 'account_number', 'required');
                $this->form_validation->set_rules('account_name', 'account_name', 'required');
                $this->form_validation->set_rules('type_bank', 'type_bank', 'required');

                if ($this->form_validation->run() == FALSE) {
                    redirect(azibai_url('/affiliate/income-payment-account?type=bank'),'refresh');
                } else {
                    $user_id = $this->session->userdata('sessionUser');
                    $bank_name = $_POST['bank_name'];
                    $aff = $_POST['aff'];
                    $account_number = $_POST['account_number'];
                    $account_name = $_POST['account_name'];
                    $type_bank = $_POST['type_bank'];

                    // include api
                    $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                    $status = Api_affiliate::add_payment_account_income($user_id, $bank_name, $aff, $account_number, $account_name, $type_bank);
                    if($status == true) {
                        redirect(azibai_url('/affiliate/income-payment'),'refresh');
                    } else {
                        die('hệ thống đang bảo trì');
                    }
                }
                break;
            default:
                die('url không tồn tại');
                break;
        }

    }

    public function affiliate_withdrawal()
    {
        $data['is_parent'] = $this->_checkAffliateOwner();
        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        // end
        $user_id = (int)$this->session->userdata('sessionUser');
        if($user_id < 1) {
            redirect(azibai_url('/affiliate'),'refresh');
            exit();
        }

        if(!isset($data['is_parent']['open_chose'])) {
            // include api
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['data_aff'] = Api_affiliate::get_data_draw_money($user_id);
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-withdrawal', $data);
    }

    public function affiliate_withdrawal_process()
    {
        $return = [
            'err' => true,
            'msg' => 'lỗi kết nối'
        ];
        if($this->input->is_ajax_request()) {
            $user_id = (int)$this->session->userdata('sessionUser');
            if($user_id < 1) {
                redirect(azibai_url('/affiliate'),'refresh');
                exit();
            }

            // include api
            $user_id = $this->session->userdata('sessionUser');
            $bank_id = $_POST['bank_id'];
            $money = $_POST['money'];
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $flag = Api_affiliate::post_data_draw_money($user_id, $bank_id, $money);
            if($flag == true) {
                $return['err'] = false;
                $return['id_transfer'] = $flag;
            } else {
                $return['msg'] = 'sai dữ liệu rút tiền';
            }

            echo json_encode($return);die;

        } else {
            echo json_encode($return);die;
        }
    }

    public function affiliate_withdrawal_bank_confirm_code($id_payment_transfer = 0)
    {
        if($id_payment_transfer == 0) {
            redirect(azibai_url('/affiliate'),'refresh');
        }
        // Tài add
        // $data['show_sub_aff'] = true;
        $data['not_show_cover'] = true;
        $data['id_payment_transfer'] = $id_payment_transfer;
        // end
        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-income-withdrawal-confirm-code', $data);
    }

    public function affiliate_statistic()
    {
        $value_request = ['general', 'person', 'system'];

        $info_public = $this->info_public;
        $data['is_parent'] = $this->_checkAffliateOwner();

        if(!isset($_REQUEST['view']) || !in_array($_REQUEST['view'], $value_request)) {
            redirect(azibai_url('/affiliate'),'refresh');
            exit();
        }

        if(empty($this->session->userdata('sessionUser'))) {
            redirect(azibai_url(), 'location');
        }

        if(!isset($data['is_parent']['open_chose'])) {

            if( in_array($data['is_parent']['affiliate_level'], [1,2,3])) {
                $data['show_affiliate_menu'] = 1;
            }else {
                $data['show_affiliate_menu'] = 0;
            }

            // lấy dữ liệu dựa trên $type_view [general, person, system]
            $type_view = $_REQUEST['view'];
            switch ($_REQUEST['view']) {
                case 'person':
                    $type_view = 1;
                    break;
                case 'system':
                    $type_view = 2;
                    break;
                default:
                    $type_view = null;
                    break;
            }

            // Tài add
            $user              = $this->info_public;
            $user_id           = (int)$this->session->userdata('sessionUser');
            $data['is_owner']         = $user['use_id'] == $user_id;
            $data['show_sub_aff'] = true;
            // end

            // include api
            if(!empty($_POST['start']) && !empty($_POST['end'])) {
                $data['from_date'] = $start_date = date('d-m-Y', strtotime($_POST['start']));
                $data['to_date'] = $end_date = date('d-m-Y', strtotime($_POST['end']));
            } else {
                $start_date = date('d-m-Y');
                $end_date = date('d-m-Y');
                $data['from_date'] = $data['to_date'] = '';
            }
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data_statistic = Api_affiliate::get_data_statistic($user_id, $start_date, $end_date, $type_view, $data['is_parent']);
            $data['statistic'] = $data_statistic; // chỉ mới có data hệ thống
        } else {
            $data['open_chose'] = $data['is_parent']['open_chose'];
        }        

        $this->set_layout('home/personal/profile-layout');
        $this->load->view('home/personal/affiliate/page/page-affiliate-statistic', $data);
    }

    function information(){
        if(empty($this->info_public)){
            redirect(base_url() . 'page-not-found', 'location');
            exit();
        }
        $this->set_layout('home/personal/profile-layout');
        $this->load->model('follow_model');
        $this->load->model('friend_model');
        $this->load->model('user_detail_model');
        $this->load->model('user_maritals_model');
        $this->load->model('user_jobs_model');

        $info_public = $this->info_public;
        $is_owner = false;

        $session = (int)$this->session->userdata('sessionUser');
        $profile = (int)$info_public['use_id'];
        if($this->input->post('keyword')){
            $keyword = $this->input->post('keyword');
        }
        if($this->isLogin() && $profile == $session){
            $is_owner = true;
        }
        $data['is_owner'] = $is_owner;
        $data['info_public'] = $info_public;
        // $data['shop'] = $this->shop_model->find_where(
        //     ['sho_status'   => 1, 'sho_user' => $info_public['use_id']],
        //     ['select'       => 'sho_user, sho_logo, sho_dir_logo, sho_name, sho_link, domain, sho_descr, sho_address, sho_district, sho_province']
        // );

        $statusFriend = 'Kết bạn';
        $data['add_friend'] = 0;
        $data['jsclass_'] = ' js-follow-user-profile';
        $getFriend = $this->friend_model->get('id, accept', ['user_id' => $profile, 'add_friend_by' => $session]);
        if (!empty($getFriend))
        {
            if($getFriend[0]->accept == 0){
                $data['IsFriend'] = 0;
                $data['add_friend'] = 1;
                $data['statusfollow'] = 'Theo dõi';
                $statusFriend = 'Đã gửi yêu cầu';
            }else{
                $data['IsFriend'] = 1;
                $statusFriend = 'Đang theo dõi';
            }
            $data['jsclass_'] = '';
        }
        else{
            $getIsFollow = $this->friend_model->get('id, accept', ['user_id' => $session, 'add_friend_by' => $profile]);
            if (!empty($getIsFollow))
            {
                if($getIsFollow[0]->accept == 0){
                    $data['IsFriend'] = 0;
                    $statusFriend = 'Trả lời lời mời kết bạn';
                    $data['isaddFriend'] = 1;
                }else{
                    $data['IsFriend'] = 1;
                }
                $data['jsclass_'] = '';
            }
        }
        $data['statusFriend'] = $statusFriend;

        $this->load->model('follow_model');
        $getFollow = $this->follow_model->get('*', ['user_id' => $profile, 'follower' => $session]);
        $data['getFollow'] = $getFollow;

        //End Follow

        $get_province = $this->province_model->get('pre_name',['pre_id'=>(int)$info_public['use_province']]);
        $get_district = $this->district_model->get('DistrictName',array('id'=> (int)$info_public['user_district'], 'ProvinceCode' => (int)$info_public['use_province']));
        $data['quan_huyen'] = $get_district->DistrictName;
        $data['tinh_thanh'] = $get_province->pre_name;

        $data['province'] = $this->province_model->fetch();
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => (int)$info_public['use_province']));

        $user_detail = $this->user_detail_model->get('*', 'user_id = '.$profile);
        $data['user_detail'] = $user_detail[0];

        $user_maritals = $this->user_maritals_model->get('*', 'user_id = '.$profile);
        $data['user_maritals'] = $user_maritals[0];

        $user_jobs = $this->user_jobs_model->fetch('*', 'user_id = '.$profile);
        if(!empty($user_jobs))
        {
            foreach ($user_jobs as $key => $value) {
                $address_job = $this->province_model->get('pre_name',['pre_id'=>(int)$value->province_id]);
                $value->address_job = $address_job->pre_name;
            }
        }
        $data['user_jobs'] = $user_jobs;

        $protocol = 'http://';
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        }

        $link_shop = '';
        if($info_public['my_shop']['domain'] != '')
        {
          $link_shop = 'http://'.$info_public['my_shop']['domain'];
        }else{
          $link_shop = $protocol.$info_public['my_shop']['sho_link'].'.'.domain_site;
        }
        $data['link_shop'] = $link_shop;

        $ogtitle = $info_public['use_fullname'];
        $ogdesc = 'Trang giới thiệu';
        $ogimage = '/templates/home/images/cover/cover_me.jpg';
        if($info_public['use_cover']){
            $ogimage = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $info_public['use_id'] . '/' . $info_public['use_cover'];
        }
        $ogurl = $info_public['profile_url'].'information';

        $type_share = TYPESHARE_PROFILE_ABOUT;
        $this->load->model('share_metatag_model');
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$info_public['use_id'].' AND type = '.$type_share);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        
        $data['profile_user'] = $info_public['use_id'];
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
        
        $this->load->view('home/personal/pages/information', $data);
    }

    function get_province_user(){

        $result['error'] = true;
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');

        if($user_id == $profile){
            $data = array(
                'use_fullname' => $this->input->post('use_fullname'),
                'use_sex' => (int)$this->input->post('use_sex'),
                'use_birthday' => $this->input->post('use_birthday'),
                'use_religion' => $this->input->post('use_religion'),
                'use_home_town' => $this->input->post('use_home_town'),
                'use_address' => $this->input->post('use_address'),
                'use_province' => $this->input->post('use_province'),
                'user_district' => $this->input->post('user_district'),
                'use_email' => $this->input->post('use_email'),
                'use_mobile' => $this->input->post('use_mobile'),
                'website' => $this->input->post('website')
            );
            if($this->user_detail_model->update($data, 'use_id = '.$profile)){
                $result['error'] = false;
            }
        }
        echo json_encode($result);
        die();
    }

    function ajax_district(){
        $province_id = $this->input->post('province_id');
        if($province_id){
            $district = $this->district_model->find_by(array('ProvinceCode' => (int)$province_id), 'id, DistrictName');
            echo json_encode($district);
            exit();
        }else{}
    }

    function edit_info_user(){

        $message = 'Lưu thông tin thất bại';
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');

        if($user_id == $profile){
            $user = $this->user_model->fetch('*', 'use_slug = "'.$this->input->post('use_slug').'" and use_id != '.$user_id);
            if(!empty($user)){
                $message = 'Mã liên kết đã tồn tại, bạn vui lòng nhập mã khác';
            }else{
                $data = array(
                    'use_fullname' => $this->input->post('use_fullname'),
                    'use_sex' => (int)$this->input->post('use_sex'),
                    'use_birthday' => $this->input->post('use_birthday'),
                    'use_religion' => $this->input->post('use_religion'),
                    'use_home_town' => $this->input->post('use_home_town'),
                    'use_address' => $this->input->post('use_address'),
                    'use_province' => $this->input->post('use_province'),
                    'user_district' => $this->input->post('user_district'),
                    'use_email' => $this->input->post('use_email'),
                    'use_mobile' => $this->input->post('use_mobile'),
                    'use_slug' => $this->input->post('use_slug'),
                    // permission
                    'permission_email' => $this->input->post('permission_email'),
                    'permission_mobile' => $this->input->post('permission_mobile'),
                );
                if($this->user_model->update($data, 'use_id = '.$profile)){
                    $message = '';
                }
            }
        }
        echo $message;
        die();
    }

    function edit_maritals_user(){

        $result['error'] = true;
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        if($user_id == $profile){
            $this->load->model('user_maritals_model');
            $user_maritals = $this->user_maritals_model->get('*', 'user_id = '.$profile);
            $data = array(
                'user_id' => $user_id,
                'marital_status' => (int)$this->input->post('marital_status'),
                '`with`' => '',
                'hobby' => (int)$this->input->post('hobby'),
                'want_to_marry' => (int)$this->input->post('want_to_marry'),
                'has_children' => (int)$this->input->post('has_children'),
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            );

            if(!empty($user_maritals)){
                if($this->user_maritals_model->update($data, 'user_id = '.$profile)){
                    $result['error'] = false;
                }
            }else{
                if($this->user_maritals_model->add($data)){
                    $result['error'] = false;
                }
            }
        }
        echo json_encode($result);
        die();
    }

    function edit_detail_user(){
        $result['error'] = true;
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');

        if($user_id == $profile){
            $this->load->model('user_detail_model');
            $user_detail = $this->user_detail_model->get('*', 'user_id = '.$profile);
            $data = array(
                'user_id' => $user_id,
                'description' => $this->input->post('description'),
                'sayings' => $this->input->post('sayings'),
                'hobby' => $this->input->post('hobby'),
                'skills' => '['.$this->input->post('skills').']',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            );

            if(!empty($user_detail)){
                if($this->user_detail_model->update($data, 'user_id = '.$profile)){
                    $result['error'] = false;
                }
            }else{
                if($this->user_detail_model->add($data)){
                    $result['error'] = false;
                }
            }
        }
        echo json_encode($result);
        die();
    }

    function add_jobs_user(){

        $result['error'] = true;
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->input->post('to_present') == 1){
            $to = NULL;
        }else{
            $to = $this->input->post('to');
        }
        if($user_id == $profile){
            $this->load->model('user_jobs_model');
            $data = array(
                'user_id' => $user_id,
                'company_name' => $this->input->post('company_name'),
                'province_id' => (int)$this->input->post('province_id'),
                'position' => $this->input->post('position'),
                '`from`' => $this->input->post('from'),
                '`to`' => $to,
                'to_present' => (int)$this->input->post('to_present'),
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            );

            if($this->user_jobs_model->add($data)){
                $result['error'] = false;
            }
        }
        echo json_encode($result);
        die();
    }

    function edit_jobs_user(){

        $result['error'] = true;
        $id = (int)$this->input->post('id');
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');
        if($this->input->post('to_present') == 1){
            $to = NULL;
        }else{
            $to = $this->input->post('to');
        }

        if($user_id == $profile){
            $this->load->model('user_jobs_model');
            $user_jobs = $this->user_jobs_model->get('*', 'user_id = '.$profile . ' and id = '.$id);
            $data = array(
                'user_id' => $user_id,
                'company_name' => $this->input->post('company_name'),
                'province_id' => (int)$this->input->post('province_id'),
                'position' => $this->input->post('position'),
                '`from`' => $this->input->post('from'),
                '`to`' => $to,
                'to_present' => (int)$this->input->post('to_present'),
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            );

            if(!empty($user_jobs)){
                if($this->user_jobs_model->update($data, 'user_id = '.$profile . ' and id = '.$id)){
                    $result['error'] = false;
                }
            }
        }
        echo json_encode($result);
        die();
    }

    function get_jobs_user(){

        $result['error'] = true;
        $id = (int)$this->input->post('id');
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');

        if($user_id == $profile){
            $this->load->model('user_jobs_model');
            $user_jobs = $this->user_jobs_model->get('*', 'user_id = '.$profile. ' and id = '.$id);
            $result = $user_jobs[0];
        }
        echo json_encode($result);
        die();
    }

    function delete_jobs_user(){

        $result['error'] = true;
        $id = (int)$this->input->post('id');
        $profile = (int)$this->input->post('user_id');
        $user_id = (int)$this->session->userdata('sessionUser');

        if($user_id == $profile){
            $this->load->model('user_jobs_model');
            if($this->user_jobs_model->delete(array('user_id' => $profile, 'id' => $id)))
            {
                $result['error'] = false;
            }
        }
        echo json_encode($result);
        die();
    }

    private function _get_profile_user($user_id)
    {
        $user = $this->user_model->generalInfo($user_id);

        if(!empty($user)){
            if($user['avatar']){
                $user['avatar_url'] = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user['use_id'] . '/' .  $user['avatar'];
            }
            $use_slug = $user['use_id'];
            if($user['use_slug'] != ''){
                $use_slug = $user['use_slug'];
            }
            $user['profile_url'] = !empty($user['website']) ? 'http://' .$user['website'] . '/' : azibai_url() . '/profile/' . $use_slug . '/';
            $shops = $this->shop_model->get_shop_by_user($user_id, $user['use_group']);
            if(!empty($shops)){
                $shop = $shops[0];
                unset($shops);
                if ($shop['sho_logo'] != "") {
                    $shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop['sho_dir_logo'] . '/' . $shop['sho_logo'];
                } else {
                    $shop_logo = site_url('templates/home/images/no-logo.jpg');
                }
                $shop['distin'] = [];
                if($shop['sho_district']){
                    $shop['distin'] = $this->district_model->find_where(['DistrictCode' => $shop['sho_district']], [
                        'select' => 'DistrictName, ProvinceName'
                    ]);
                }
                //if co domain rieng va server host != thì set lại shop link
                $shop['shop_url'] = getAliasDomain();
                if(trim_protocol(trim($shop['domain']))){
                    $shop['shop_url'] = shop_url($shop) . '/';
                }
                $shop['logo']    = $shop_logo;
                $user['my_shop'] = $shop;
                unset($shop);
            }
            if($this->uri->segment(1) != 'affiliate' && $this->session->userdata('sessionUser') > 0 && $user_id > 0) {
                $this->load->model('friend_model');
                $is_friend = $this->friend_model->is_your_friend($user_id, $this->session->userdata('sessionUser'));
                $user["is_friend"] = $is_friend ? true : false;
            }
        }
        return $user;
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Check Affiliate Owner
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    private function _checkAffliateOwner() {
        $aParent = array();
        $aParentTemp = $this->session->userdata('affiliate_parent');
        if($aParentTemp && !empty($aParentTemp)) {
            $aParent = $aParentTemp;
        } else {
            $aParent['open_chose'] = 1;
        }

        return $aParent;
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Check Affiliate Owner
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *
     ***************************************************************************
    */

    public function ajaxcheckAffliateOwner() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy parent thất bại!';
        $result['type']     = 'error';

        $aParentTemp = $this->session->userdata('affiliate_parent');
        if($aParentTemp && !empty($aParentTemp)) {
            $result['message']  = 'Lấy parent thành công!';
            $result['type']     = 'success';
        }

        echo json_encode($result);
        die();

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

    public function ajaxGetListAffP() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy danh sách parent thất bại!';
        $result['type']     = 'error';

        $aDatas = array();
        $iUserId = (int)$this->session->userdata('sessionUser');
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $url = $this->config->item('api_aff_list');
        $url = str_replace(['{$id}'], [$iUserId], $url);

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] == 1) {
            if(!empty($make_call['data'])){
                $aCurrent = $this->_checkAffliateOwner();

                $oUser = $this->user_model->get("parent_id","use_id = " . $iUserId);
                foreach ($make_call['data'] as $iKU => $oU) {
                    $check = 0;
                    $iParentId = $oU['parent_id'];

                    if($oU['type_affiliate'] == 1) {
                        $iParentId = 0;
                    }

                    if($aCurrent['type_affiliate'] == 1 && $oU['type_affiliate'] == 1) {
                        $check = 1;
                    }else {
                        if($aCurrent['id'] == $iParentId) {
                            $check = 1;
                        }
                        
                    }

                    

                    $result['data'][] = array(
                        'user_id'           => $oU['user_id'],
                        'name'              => $oU['name'],
                        'parent_id'         => $iParentId,
                        'affiliate_level'   => $oU['affiliate_level'],
                        'type_affiliate'    => $oU['type_affiliate'],
                        'check'             => $check
                    );
                }
                
                $result['message']  = 'Lấy danh sách parent thành công!';
                $result['type']     = 'success';
            }
        }

        echo json_encode($result);
        die();
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

    public function ajaxChoseParrent($aParentId = 0) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Chọn parent thất bại!';
        $result['type']     = 'error';

        if($aParentId == 0) {
            $aParent = array(
                'id'                => 1,
                'name'              => 'Azibai',
                'type_affiliate'    => 1,
                'affiliate_level'   => $this->session->userdata('sessioniAFLevel'),
                'parent_id'         => 1,
            );

            $this->session->set_userdata('affiliate_parent',$aParent);
            $result['data']     = $aParent;
            $result['message']  = 'Chọn parent thành công!';
            $result['type']     = 'success';
        }else {
            $oUser = $this->user_model->get("use_fullname","use_id = " . $aParentId);
            if(isset($oUser->use_fullname) && $oUser->use_fullname != '') {
                $this->load->model('affiliate_relationship_model');
                $aAR = $this->affiliate_relationship_model->getwhere('*','user_parent_id ='.$aParentId);
                $aParent = array(
                    'id'                => $aParentId,
                    'name'              => $oUser->use_fullname,
                    'type_affiliate'    => 2,
                    'affiliate_level'   => $aAR['affiliate_level'],
                    'parent_id'         => $aAR['parent_id'],
                );

                $this->session->set_userdata('affiliate_parent',$aParent);

                $result['data']     = $aParent;
                $result['message']  = 'Chọn parent thành công!';
                $result['type']     = 'success';
            }
        }
        echo json_encode($result);
        die();
    }

}

