<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Share extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->lang->load('home/common');

        $this->load->model('common_model');
        $data = $this->common_model->getPackageAccount();

        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()){
            $data['isMobile'] = 1;
            $data['isAndroidOS'] = $detect->isAndroidOS();
            $data['isiOS'] = $detect->isiOS();
        }
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $ssuser = (int)$this->session->userdata('sessionUser');

        $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
        $data['currentuser'] = $cur_user;

        $shop = $this->shop_model->get("sho_link, sho_package", "sho_user = " . $ssuser);
        $data['shoplink'] = $shop->sho_link;

        $data['sho_package'] = $this->getConditionsShareNews($this->session->userdata('sessionGroup'),$this->session->userdata('sessionUser'));
        $data['mainURL'] = $this->getMainDomain();
        $this->load->vars($data);
    }

    function index($page = 0)
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $this->load->model('share_model');
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/clipboard.min.js');
            $this->share_model->pagination(TRUE);

            //$data = array();
            $shareId = (int)$this->session->userdata('sessionUser');
            $data['menuPanelGroup'] = 4;
            $data['menuSelected'] = 'share';
            $data['menuType'] = 'account';
            $data['num'] = $page;
            $data['list'] = $this->share_model->lister(array('tbtt_share.share_id' => $shareId), $page);
            $data['sort'] = $this->share_model->getAdminSort();
            $data['filter'] = $this->share_model->getFilter();
            $data['link'] = base_url() . $this->share_model->getRoute('share');
            $data['pager'] = $this->share_model->pager;

            $this->load->view('home/share/share', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function view_list()
    {
        $action = array('page','detail');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        if($getVar['detail'] != ''){
            $this->detail_view($getVar['detail']);
        }
        else{
            if ($this->session->userdata('sessionUser') > 0) {
                $this->load->model('share_model');
                $this->load->library('utilslv');
                $util = utilslv::getInstance();
                $util->addScript(base_url() . 'templates/home/js/clipboard.min.js');
                $this->share_model->pagination(TRUE);

                //$data = array();
                $shareId = (int)$this->session->userdata('sessionUser');
                $this->load->model('user_model');
                $af_user=$this->user_model->get_user_id($shareId);
               // var_dump($af_user);
                if($af_user!=false) {
                    if ($af_user->use_group != 3)//neu la af
                    {
                        $this->load->model('af_share_model');
                        $list =  $this->af_share_model->getAll_ListViewShare($af_user->af_key);
                        $data['title_view']='Thống kê những sản phẩm đã có lượt view của bạn đã chia sẽ ';
                    } else {//neu la chu shop
                        $this->load->model('af_share_model');
                        $list =  $this->af_share_model->getAll_ListViewShare_Shop($af_user->use_id);
                        $data['title_view']='Thống kê những sản phẩm đã có lượt view của Shop bạn';
                    }

                    if ($getVar['page'] != false && $getVar['page'] != '') {
                        $start = $getVar['page'];
                    } else {
                        $start = 0;
                    }
                    $limit = settingOtherAccount;
                    $this->load->library('pagination');
                    $totalRecord = count($list);
                    $config['base_url'] = base_url() . 'account/share/view-list/page/';
                    $config['total_rows'] = $totalRecord;
                    $config['per_page'] = $limit;
                    $config['num_links'] = 1;
                    $config['cur_page'] = $start;
                    $this->pagination->initialize($config);
                    $data['linkPage'] = $this->pagination->create_links();
                    if ($af_user->use_group != 3)//neu la af
                    {
                        $data['list'] = $this->af_share_model->getAll_ListViewShare($af_user->af_key,$start,$limit);
                    }else {
                        $data['list'] = $this->af_share_model->getAll_ListViewShare_Shop($af_user->use_id,$start,$limit);
                    }
                    $data['stt'] = $start + 1;

                    $data['menuPanelGroup'] = 4;
                    $data['menuSelected'] = 'share';
                    $data['menuType'] = 'account';

                    $data['sort'] = $this->share_model->getAdminSort();
                    $data['filter'] = $this->share_model->getFilter();
                    $data['link'] = base_url() . $this->share_model->getRoute('share');
                    $this->load->view('home/share/view_list', $data);
                }

            } else {
                redirect(base_url() . 'login', 'location');
                die();
            }
        }
    }

    public function detail_view($pro_id)
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $this->load->model('share_model');
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/clipboard.min.js');
            $this->share_model->pagination(TRUE);
            
            $shareId = (int)$this->session->userdata('sessionUser');
            $this->load->model('user_model');
            
            $af_user = $this->user_model->get_user_id($shareId);
            $data['use_group'] = false;
            if($af_user!=false) {
                $data['use_group'] = $af_user->use_group;
                if ($af_user->use_group != 3)//neu la af
                {
                    $this->load->model('af_share_model');
                    $list = $this->af_share_model->getAll_by_afKey_proId($af_user->af_key,$pro_id);
                }
                else{
                    $this->load->model('af_share_model');
                    $list = $this->af_share_model->getAll_by_proId($pro_id);
                }
                
                ///PHAN TRANG
                $action = array('page','detail');
                $getVar = $this->uri->uri_to_assoc(4, $action);
                if ($getVar['page'] != false && $getVar['page'] != '') {
                    $start = $getVar['page'];
                } else {
                    $start = 0;
                }
                ///END PHAN TRANG
                $limit = settingOtherAccount;
                $this->load->library('pagination');
                $totalRecord = count($list);
                $config['base_url'] = base_url() . 'account/share/view-list/detail/'.$getVar['detail'].'/page/';
                $config['total_rows'] = $totalRecord;
                $config['per_page'] = $limit;
                $config['num_links'] = 1;
                $config['cur_page'] = $start;
                $this->pagination->initialize($config);
                $data['linkPage'] = $this->pagination->create_links();
                
                if ($af_user->use_group != 3) //neu la af
                {
                    $data['list'] = $this->af_share_model->getAll_by_afKey_proId($af_user->af_key,$pro_id,$start,$limit);
                }else {
                    $data['list'] = $this->af_share_model->getAll_by_proId($pro_id,$start,$limit);
                }
                $data['stt'] = $start + 1;
            }
        $data['menuPanelGroup'] = 4;
            $data['menuSelected'] = 'share';
            $data['menuType'] = 'account';
            $data['sort'] = $this->share_model->getAdminSort();
            $data['filter'] = $this->share_model->getFilter();
            $data['link'] = base_url() . $this->share_model->getRoute('share');

            $this->load->view('home/share/detail_view_share', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function ajax_showtin(){
        
        $this->load->model('content_model');
        $this->load->model('images_model');
        $this->load->model('videos_model');
        
        $not_id = (int)$this->input->post('new_id');

        $data = array();
        
        $sessionUser = (int)$this->session->userdata('sessionUser');
        $sessionGroup = (int)$this->session->userdata('sessionGroup');

        $user = $this->user_model->get("use_id, avatar, use_fullname, af_key",'use_id = '.$sessionUser . ' and use_status = 1');
        $afkey = '?af_id='.$user->af_key;
        $select = "a.*";
        $where  = "a.not_status = 1 AND  a.not_publish = 1 AND a.id_category = 16 AND a.not_id = " . $not_id;
        $sql2   = 'SELECT ' . $select . ' FROM tbtt_content AS a WHERE ' . $where;
        $query = $this->db->query($sql2);
        $item  = $query->row();
        
        $status_friend = '';
        $css_friend = '';
        $class_friend = '';
        if($sessionUser != $item->not_user){
            if($item->sho_id){
                $this->load->model('follow_shop_model');
                $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$item->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
                
                if (!empty($getFollow) && $getFollow[0]->hasFollow == 1)
                {
                    // if($getFollow[0]->hasFollow == 1){
                        $follow = 1;
                        $css_friend = 'hasfriend';
                        $class_friend = 'cancel-follow-shop-'.$item->sho_id.' cancel-follow-shop';
                        $status_friend = '<span class="md"><img src="/templates/home/styles/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"> Đang theo dõi</span><span class="sm"><img src="/templates/home/styles/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"></span>';
                    // }
                }else{
                    $css_friend = 'hasfriend';
                    $class_friend = 'is-follow-shop-'.$item->sho_id.' is-follow-shop';
                    $status_friend = '<span class="md"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"> Theo dõi</span><span class="sm"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"></span>';
                }
            }
            else{
                $this->load->model('friend_model');
                $getFriend = $this->friend_model->get('*', "(add_friend_by = ".  $sessionUser .' AND user_id = '.  (int)$item->not_user.") OR (user_id = ".  $sessionUser.' AND add_friend_by = '.  (int)$item->not_user .')');
                if(count($getFriend) > 0){
                    if($getFriend[0]->accept == 1){
                        $css_friend = 'hasfriend';
                        $class_friend = 'unfriend';
                        $status_friend = '<img src="/templates/home/styles/images/svg/banbe.svg" style="margin-right: 5px;" alt="Bạn bè" title="Bạn bè"><span class="text"> Bạn bè</span>';
                    }else{
                        $this->load->model('follow_model');
                        $getFollow = $this->follow_model->get('*', ['user_id' => (int)$item->not_user, 'follower' => $sessionUser]);
                        if(count($getFollow) > 0){
                            $css_friend = 'pendFriend';
                            $class_friend = '';
                            $status_friend = '<img src="/templates/home/styles/images/svg/daguiloimoi.svg" style="margin-right: 5px;" alt="Đã gửi yêu cầu" title="Đã gửi yêu cầu"><span class="text"> Đã gửi yêu cầu</span>';
                        }else{
                            $isFollow = $this->follow_model->get('*', ['user_id' => $sessionUser, 'follower' => (int)$item->not_user]);
                            if(count($isFollow) > 0){
                                $css_friend = 'confirmFriend';
                                $class_friend = 'js-confirmfollow-user';
                                $status_friend = 'Xác nhận';
                            }
                        }
                    }
                }else{
                    $css_friend = 'nofriend';
                    $class_friend = 'js-follow-user-profile';
                    $status_friend = '<img src="/templates/home/styles/images/svg/ketban.svg" style="margin-right: 5px;" alt="Kết bạn" title="Kết bạn"><span class="text"> Kết bạn</span>';
                }
            }
        }
        $data['friend'] = array(
            'status_fr' => $status_friend,
            'css_fr' => $css_friend,
            'class_fr' => $class_friend
        );
        $iVideoId =  (int) $item->not_video_url1;
        $aVideos = $this->videos_model->get("*",'id = '.$iVideoId);
        if(!empty($aVideos)){
            $item->video_path       = DOMAIN_CLOUDSERVER . 'video/' . @$aVideos[0]->name;
            $item->video_title          = @$aVideos[0]->title;
            $item->video_description    = @$aVideos[0]->description;
        }
        $shop_url = azibai_url();
        $news_url = $shop_url . '/tintuc/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
        $logo = site_url('templates/home/images/no-logo.jpg');
        if($item->sho_id){
            $shop = $this->shop_model->find_where([
                'sho_status'    => 1,
                'sho_id'        => $item->sho_id
            ],
                ['select'  => 'sho_id, sho_name, sho_link, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_mobile, sho_phone, sho_facebook, domain, sho_user, sho_email'],
                'object'
            );

            if(!empty($shop)){
                if ($shop->sho_logo) {
                    $logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                }
                $shop_url = shop_url($shop);
                $news_url = $shop_url . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
                $data['info'] = array(
                    'type' => 'shop',
                    'sho_id' => $shop->sho_id,
                    'name'          => $shop->sho_name,
                    'link' => $shop_url . $afkey,
                    'created'       => date("d/m/Y", $item->not_begindate),
                    'not_id'        => $item->not_id,
                    'avatar'        => $logo,
                    'path_img'      => DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/',
                    'type_post'     => $item->not_posted_by
                );
            }
        }

        if(!$item->sho_id && $item->not_user){
            $user = $this->user_model->find_where([
                'use_status'    => 1,
                'use_id'        => $item->not_user
            ],
                ['select'  => 'use_id, use_group, parent_id, parent_shop, use_status, use_username, use_fullname, use_skype, avatar'],
                'object'
            );

            if(!empty($user)){
                if ($user->avatar) {
                    $logo = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user->use_id . '/' .  $user->avatar;
                }
                $shop_url = azibai_url() . '/profile/' . $item->not_user;
                $news_url = $shop_url . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
                $data['info'] = array(
                    'type' => 'profile',
                    'name'          => $user->use_fullname,
                    'link' => $shop_url . $afkey,
                    'created'       => date("d/m/Y", $item->not_begindate),
                    'not_id'        => $item->not_id,
                    'avatar'        => $logo,
                    'path_img'      => DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/',
                    'type_post'     => $item->not_posted_by
                );
            }
        }

        $item->link_news = $news_url;
        $array = array();
        $where_img = 'not_id = '.$item->not_id;
        $aListImage = $this->images_model->get("*",$where_img);

        if(!empty($aListImage)) {
            $this->load->model('customlink_model');
            foreach ($aListImage as $key => $oImage) {
                $link_to = $this->customlink_model->get('*', 'type_id = ' . $oImage->id .' AND type = "image"');

                $array[$key] = array(
                    $oImage->link_crop,
                    $oImage->product_id,
                    $oImage->title,
                    $oImage->link,
                    $oImage->content,
                    $oImage->style_show,
                    $link_to,
                    $oImage->tags,
                    $oImage->id
                );
            }
        }
        
        $listImg = array();
        foreach ($array as $k => $value) {
            if (strlen($value[0]) > 10) {
                @$listImg[$k]->image = $value[0];
                $listImg[$k]->title = $value[2];
                $listImg[$k]->detail = $value[3];
                $listImg[$k]->caption = $value[4];
                $listImg[$k]->style = $value[5];
                $listImg[$k]->link_to = $value[6];
                $listImg[$k]->tags    = json_decode($value[7]);
                $listImg[$k]->id        = $value[8];
                $listImg[$k]->type        = 'img';
            }
        }

        $data['listImg'] = $listImg;
        $data['detail'] = $item;
        $data['user'] = $user;
        echo json_encode($data);
        die();
    }

    function ajax_showproduct(){
        
        $this->load->model('product_model');
        
        $pro_id = (int)$this->input->post('pro_id');
        
        $data = array();
        
        $sessionUser = (int)$this->session->userdata('sessionUser');
        $sessionGroup = (int)$this->session->userdata('sessionGroup');

        $user = $this->user_model->get("use_id, avatar, use_fullname, af_key",'use_id = '.$sessionUser . ' and use_status = 1');
        $afkey = '?af_id='.$user->af_key;

        $product = $this->product_model->get("* , (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . $pro_id . " AND pro_status = 1 ");
        
        $shop_url = azibai_url();
        $logo = site_url('templates/home/images/no-logo.jpg');
        if(!empty($product)){
            $shop = $this->shop_model->find_where([
                'sho_status'    => 1,
                'sho_user'        => $product->pro_user
            ],
                ['select'  => 'sho_id, sho_name, sho_link, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_mobile, sho_phone, sho_facebook, domain, sho_user, sho_email'],
                'object'
            );

            if(!empty($shop)){
                if ($shop->sho_logo) {
                    $logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                }
                $shop_url = shop_url($shop);
                $data['info'] = array(
                    'name'          => $shop->sho_name,
                    'link' => $shop_url . $afkey,
                    'avatar'        => $logo,
                    'sho_id'        => $shop->sho_id
                );
            }
        }
        $status_friend = '';
        $css_friend = '';
        $class_friend = '';
        if($sessionUser != $product->pro_user){
            $this->load->model('follow_shop_model');
            $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$shop->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
            
            if (!empty($getFollow) && $getFollow[0]->hasFollow == 1)
            {
                // if($getFollow[0]->hasFollow == 1){
                    $follow = 1;
                    $css_friend = 'hasfriend';
                    $class_friend = 'cancel-follow-shop-'.$shop->sho_id.' cancel-follow-shop';
                    $status_friend = '<span class="md"><img src="/templates/home/styles/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"> Đang theo dõi</span><span class="sm"><img src="/templates/home/styles/images/svg/dangtheodoi.svg" alt="Đang theo dõi" title="Đang theo dõi" style="width: 18px;height: 18px;"></span>';
                // }
            }else{
                $css_friend = 'hasfriend';
                $class_friend = 'is-follow-shop-'.$shop->sho_id.' is-follow-shop';
                $status_friend = '<span class="md"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"> Theo dõi</span><span class="sm"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="Theo dõi" title="Theo dõi" style="width: 18px;height: 18px;"></span>';
            }
        }
        $data['friend'] = array(
            'status_fr' => $status_friend,
            'css_fr' => $css_friend,
            'class_fr' => $class_friend
        );

        $product->image = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . explode(',',$product->pro_image)[0];
        $data['product'] = $product;
        $data['user'] = $user;
        echo json_encode($data);
        die();
    }

    public function getConditionsShareNews($sessionGroup,$sessionUser) {
                       
        switch ($sessionGroup){
                    case 3: 
                        $sho_package = $this->package_user_model->getCurrentPackage($sessionUser);
                        break;                        
                    case 14: 
                        $userCurent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $sessionUser);
                        $userParent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userCurent->parent_id);
                        if($userParent->use_group == 3){
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);                           
                        } else { //=15
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
                        }
                        break;
                    case 2:
                        $userCurent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $sessionUser);
                        $userParent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userCurent->parent_id);
                        if($userParent->use_group==3){
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);                            
                        }
                        if($userParent->use_group==15){
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);                            
                        }
                        if($userParent->use_group==14){                          
                            $userParent2 = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userParent->parent_id);
                            if($userParent2->use_group == 3){
                                $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);  
                            } else { //=15
                                $sho_package = $this->package_user_model->getCurrentPackage($userParent2->parent_id); 
                            }
                        }
                        if($userParent->use_group==11){
                            $userParent2 = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userParent->parent_id);
                            if($userParent2->use_group == 3){
                                $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);                                 
                            } else { //=14                                
                                $userParent3 = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userParent2->parent_id);
                                if($userParent3->use_group == 3){
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

    function get_avatarShare(){
        $this->load->model('share_metatag_model');
        $use_id = (int)$this->session->userdata('sessionUser');
        $type = (int)$this->input->post('type');
        $item_id = (int)$this->input->post('item_id');
        $where = 'use_id = '.$use_id.' AND type = '.$type;
        if($item_id > 0){
            $where .= ' AND item_id = '.$item_id;
        }
        $get_avtShare = $this->share_metatag_model->get('*',$where);
        $result['count'] = 0;
        if(!empty($get_avtShare)){
            $result['data'] = $get_avtShare;
            $result['count'] = count($get_avtShare);
        }
        echo json_encode($result);
        die();
    }

    function add_avatarShare(){
        $result['error'] = true;

        $this->load->library(['ftp', 'upload']);
        $imgSrc         = $this->input->post('avatarShare');
        $type           = (int)$this->input->post('type');
        $item_id       = (int)$this->input->post('item_id');
        $use_id        = (int)$this->session->userdata('sessionUser');

        $this->load->model('share_metatag_model');
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

        $pathImage = 'media/images/avatarShare';
        $path = '/public_html/media/images';
        $dir = $type;
        $dir_image = date('dmY');
        
        if (!is_dir($pathImage .'/')) {
            @mkdir($pathImage, 0775);
            $this->load->helper('file');
            @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
        }

        if (!is_dir($pathImage .'/' . $dir)) {
            @mkdir($pathImage .'/' . $dir, 0775);
        }

        if($item_id > 0){
            $dir_folder = $pathImage.'/'.$dir.'/'.$dir_image;
            if (!is_dir($dir_folder)) {
                @mkdir($dir_folder, 0775);
            }
        }else{
            $dir_folder = $pathImage.'/'.$dir;
        }

        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (!in_array('avatarShare', $ldir)) {
            $this->ftp->mkdir($path . '/avatarShare', 0775, true);
        }
        $ldir = $this->ftp->list_files($path . '/avatarShare');
        if (!in_array($dir, $ldir)) {
            $this->ftp->mkdir($path . '/avatarShare/' . $dir, 0775, true);
        }
        if($item_id > 0){
            $ldir = $this->ftp->list_files($path . '/avatarShare/' . $dir);
            if (!in_array(date('dmY'), $ldir)) {
                $this->ftp->mkdir($path . '/avatarShare/' . $dir.'/'.date('dmY'), 0775, true);
            }
            $name_img = 'avtShare'.$item_id.'_';
        }else{
            $name_img = 'avtShare'.$use_id.'_';
        }
        
        $sCustomerImageName = $name_img.uniqid() . time() . uniqid();
        $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

        $cus_avatar = $sCustomerImageName.'.'.$type_image;

        $config['upload_path'] = $dir_folder.'/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 5120;#KB
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);

        if (file_exists($dir_folder . '/' . $cus_avatar)) {
            
            if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                $data = array(
                    'use_id'       => $use_id,
                    'image'        => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar,
                    'type'          => $type,
                    'item_id'          => $item_id,
                );
                if($this->share_metatag_model->add($data)){
                    $result['error'] = false;
                    $result['image'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;
                    $result['id'] = mysql_insert_id();
                }
            }
        }
        echo json_encode($result);die();
    }

    function update_avatarShare(){

        $result['error'] = true;
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

        $imgSrc = $this->input->post('avatarShare');
        $id = (int)$this->input->post('id');
        $item_id = (int)$this->input->post('item_id');
        $use_id = (int)$this->session->userdata('sessionUser');

        $pathImage = 'media/images/avatarShare';
        $path = '/public_html/media/images';

        $this->load->model('share_metatag_model');
        $where = 'use_id = '.$use_id.' AND id = '.$id;
        if($item_id > 0){
            $where .= ' AND item_id = '.$item_id;
        }
        $get_avtShare = $this->share_metatag_model->get('*',$where);

        // $item_id = $get_avtShare[0]->item_id;
        $dir = $get_avtShare[0]->type;
        $arr_image = explode('/', $get_avtShare[0]->image);
        
        if($item_id > 0){
            $dir_image = $arr_image[7];
            $image_name = $arr_image[8];
        }else{
            $dir_image = '';
            $image_name = $arr_image[7];
        }
        
        if (!is_dir($pathImage .'/')) {
            @mkdir($pathImage, 0775);
            $this->load->helper('file');
            @write_file($pathImage . '/index.html', '<p>Directory access is forbidden.</p>');
        }

        if (!is_dir($pathImage .'/' . $dir)) {
            @mkdir($pathImage .'/' . $dir, 0775);
        }

        if($item_id > 0){
            $dir_folder = $pathImage.'/'.$dir.'/'.$dir_image;
            if (!is_dir($dir_folder)) {
                @mkdir($dir_folder, 0775);
            }
        }else{
            $dir_folder = $pathImage.'/'.$dir;
        }

        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (!in_array('avatarShare', $ldir)) {
            $this->ftp->mkdir($path . '/avatarShare', 0775, true);
        }
        $ldir = $this->ftp->list_files($path . '/avatarShare');
        if (!in_array($dir, $ldir)) {
            $this->ftp->mkdir($path . '/avatarShare/' . $dir, 0775, true);
        }
        if($item_id > 0){
            $ldir = $this->ftp->list_files($path . '/avatarShare/' . $dir);
            if (!in_array(date('dmY'), $ldir)) {
                $this->ftp->mkdir($path . '/avatarShare/' . $dir.'/'.date('dmY'), 0775, true);
            }
            $name_img = 'avtShare'.$item_id.'_';
        }else{
            $name_img = 'avtShare'.$use_id.'_';
        }

        $sCustomerImageName = $name_img.uniqid() . time() . uniqid();
        $type_image = $this->convertStringToImageFtp($sCustomerImageName,$dir_folder.'/',$imgSrc);

        $cus_avatar = $sCustomerImageName.'.'.$type_image;


        $config['upload_path'] = $dir_folder.'/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 5120;#KB
        $config['encrypt_name'] = true;
        $this->upload->initialize($config);

        $data = array(
            'image' => DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar
        );
        
        if (file_exists($dir_folder . '/' . $cus_avatar)) {
            
            if($this->ftp->upload($dir_folder . '/' . $cus_avatar, '/public_html/' . $dir_folder .'/' . $cus_avatar, 'auto', 0775)){
                if($this->share_metatag_model->update($data, $where)){
                    unlink($dir_folder .'/' . $image_name);
                    $this->ftp->delete_file('/public_html/' . $dir_folder .'/' . $image_name);
                    $result['image'] = DOMAIN_CLOUDSERVER . $dir_folder .'/' . $cus_avatar;
                }
                $result['error'] = false;
            }
        }
        echo json_encode($result);die();
    }

    function delete_avatarShare(){
        $this->load->library(['ftp', 'upload']);
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port'] = PORT_CLOUDSERVER;
        $config['debug'] = true;
        $this->ftp->connect($config);

        $this->load->library('image_lib');
        $this->load->library('upload');

        $result['error'] = true;
        $this->load->model('share_metatag_model');

        $use_id = (int)$this->session->userdata('sessionUser');
        $id = (int)$this->input->post('id');

        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$use_id.' AND id = '.$id);
        $type = (int)$get_avtShare[0]->type;
        $item_id = (int)$get_avtShare[0]->item_id;
        $get_img = $get_avtShare[0]->image;

        $arr_img = explode('/',$get_img);
        if($item_id > 0){
            $avtShare = $arr_img[8];
            $dir_image = '/'.$arr_img[7];
        }else{
            $avtShare = $arr_img[7];
            $dir_image = '';
        }
        $path_img = 'media/images/avatarShare/'.$type.$dir_image.'/'.$avtShare;

        if($this->ftp->delete_file('/public_html/'.$path_img)){
            $result['error'] = false;
            $this->share_metatag_model->delete(['id' => $id, 'use_id' => $use_id]);
            @unlink($path_img);
        }

        echo json_encode($result);
        die();
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

    public function show_content_has_share($id)
    {
        $this->load->model('content_model');
        $this->load->library('link_library');
        $this->load->model('like_content_model');
        $this->load->model('images_model');
        $this->load->model('product_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('chontin_model');
        $this->load->model('videos_model');

        // $data['protocol']        = get_server_protocol();
        // $data['titleSiteGlobal'] = settingTitleTintuc;
        // $data['descrSiteGlobal'] = settingDescrTintuc;
        // $data['ogurl']           = azibai_url();
        // $data['ogtype']          = "website";
        // $data['ogtitle']         = settingTitleTintuc;
        // $data['ogdescription']   = settingDescrTintuc;

        $sessionUser = $this->session->userdata('sessionUser');

        $content = array_shift($this->content_model->get_new_by_id($id, $sessionUser));
        if(!$content) {
            show_404();
        }

        //Dem so luọc chon tin
        $content->chontin = 0;
        $result = $this->chontin_model->fetch('id', 'not_id = '. $content->not_id);
        if (count($result)) {
            $content->chontin = count($result);
        }

        //Dem like
        $list_likes = $this->like_content_model->get('id', ['not_id' => (int)$content->not_id]);
        $content->likes = count($list_likes);

        if(($_SERVER['HTTP_HOST'] == domain_site && strpos($_SERVER['REQUEST_URI'], 'profile') != '') || ($_SERVER['HTTP_HOST'] != domain_site && empty($content->sho_id)))
        {
            $content->type_share = TYPESHARE_PROFILE_NEWS;
        }else
        {
            if($content->sho_id > 0 && $_SERVER['HTTP_HOST'] != domain_site){
                $content->type_share = TYPESHARE_SHOP_NEWS;
            }
            else{
                $content->type_share = TYPESHARE_HOME_NEWS;
            }
        }
        $type_share = $content->type_share;

        if($sessionUser){
            //Kiem tra 1 user bat ky da chon tin nay chua

            $content->dachon = 0;
            $dachon = $this->chontin_model->fetch('id', 'not_id = '.$content->not_id.' AND sho_user_1 = '. $sessionUser);
            if (count($dachon)) {
                $content->dachon = 1;
            }

            //User co duoc phep chon tin nay khong
            if(in_array($sessionGroup, json_decode(ListGroupAff, true) ) && $content->not_user !=  $sessionUser) {
                $content->chochontin = 1;
            } else {
                $content->chochontin = 0;
            }

            // đã like
            $is_like = $this->like_content_model->get('id', ['user_id' => $sessionUser, 'not_id' => (int) $content->not_id]);
            $content->is_like = count($is_like);
        }

        //Get Customlink
        $content->not_customlink = $this->link_library->link_of_news($content->not_id, '', 0, 0, 0, true);

        /* GOI SAN PHAM NẾU CÓ CHỌN */
        $array = array();
        $aListImage = $this->images_model->get('*', 'not_id = ' . $content->not_id);
        if (!empty($aListImage)) {
            foreach ($aListImage as $k2 => $oImage) {
                $array[$k2] = array(
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
                );
            }
        }

        $listImg = array();
        $listPro = array();
        $this->load->model('detail_product_model');

        foreach ($array as $k => $value) {
            if (strlen($value[0]) > 10) {
                $listImg[$k]->image = $value[0];
                if ($value[1] > 0) {
                    $select_hh = 'apply, pro_saleoff, pro_type_saleoff, begin_date_sale, end_date_sale, pro_saleoff_value, af_dc_rate, af_dc_amt, ';
                    $product = $this->product_model->get($select_hh. 'pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, af_amt, (af_rate) as aff_rate, '. DISCOUNT_QUERY, 'pro_id = '. (int) $value[1]);
                    $detailproduct = $this->detail_product_model->get('count(tbtt_detail_product.dp_pro_id) as have_num_tqc', 'dp_pro_id = '. (int) $value[1]);

                    if (($current_user_id = $sessionUser)) {
                        $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$current_user_id, 'pro_id' => $product->pro_id));
                        if ($selected_sale) {
                            $product->selected_sale = $selected_sale;
                        }
                    }
                    $listImg[$k]->product = $product;
                    $dataHH = $this->dataGetHH($product);
                    $product->hoahong = $this->checkHH($dataHH);
                    $product->Shopname = $this->get_InfoShop($product->pro_user, 'sho_name')->sho_name;
                    $product->have_num_tqc = $detailproduct->have_num_tqc;
                    // $pro_price = ($hoahong['price_aff'] > 0) ? $hoahong['price_aff'] : $hoahong['priceSaleOff'];
                    $listPro[$k] = $product;
                }
                $listImg[$k]->title    = $value[2];
                $listImg[$k]->detail   = $value[3];
                $listImg[$k]->caption  = $value[4];
                $listImg[$k]->style    = $value[5];
                $listImg[$k]->tags     = $value[6];
                $listImg[$k]->id       = $value[7];
                $listImg[$k]->img_w    = $value[8];
                $listImg[$k]->img_h    = $value[9];
                $listImg[$k]->img_type = $value[10];
                $listImg[$k]->type = 'img';
            }
        }
        $content->listImg = $listImg;
        $content->listPro = $listPro;

        //kiểm tra có quick view link + product + tag
        $content->check_quick_view['product'] = false;
        $content->check_quick_view['link'] = false;
        $content->check_quick_view['tag'] = false;

        if(!empty($content->listPro)){
            $content->check_quick_view['product'] = true;
        }
        if(!empty($content->not_customlink)){
            $content->check_quick_view['link'] = true;
        }
        if (count($content->listImg) > 0) {
            foreach ($content->listImg as $key_img => $value) {
                if(isset($value->tags) && $value->tags != '' && $value->tags != "'null'" && $value->tags != "[]" && $value->tags != null && $value->tags != 'null' && $value->tags != "\"null\"") {
                    $count_tags = count(json_decode($value->tags,true));
                    if ($count_tags == 0 ) {
                        $list_news[$key_img]->check_quick_view['tag'] = false;
                        break;
                    }
                    $list_news[$key_img]->check_quick_view['tag'] = true;
                    break;
                }
            }
        }
        // Get video

        $iVideoId       = (int)$content->not_video_url1;
        $content->video_id = $iVideoId;
        $aVideos        = $this->videos_model->get("*", 'id = ' . $iVideoId);
        $content->poster   = '';
        $content->poster_path   = '';

        if (!empty($aVideos)) {
            $content->not_video_url1 = $aVideos[0]->name;
            if (!empty($aVideos[0]->thumbnail)) {
                $content->poster =  DOMAIN_CLOUDSERVER . 'video/thumbnail/'. $aVideos[0]->thumbnail;
                $content->poster_path = $aVideos[0]->thumbnail;
            }
        }

        $af_id = '';
        if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
            $af_id = $_REQUEST['af_id'];
        }

        /*if ($content->not_image != '') {
            $check_http = explode(':', $content->not_image)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $content->not_image;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $content->not_image;
            }
        } else if (!empty($listImg)) {
            $check_http = explode(':', $listImg[0]->image)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $listImg[0]->image;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $content->not_dir_image . '/' . $listImg[0]->image;
            }
        } else if (!empty($aVideos)) {
            $check_http = explode(':', $aVideos[0]->thumbnail)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $aVideos[0]->thumbnail;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $aVideos[0]->thumbnail;
            }
        } else if ($content->not_customlink != '' && !empty($content->not_customlink)) {
            $ogimage = $content->not_customlink[0]['image'] ? $content->not_customlink[0]['image_url'] : $content->not_customlink[0]['link_image'];
        }*///tam khoa duoi view da co

        $content->og_image = '';

        $this->load->model('share_metatag_model');
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$content->not_user.' AND type = '.(int)$type_share . ' AND item_id = '.$content->not_id);
        if(!empty($get_avtShare)){
            $content->og_image = $get_avtShare[0]->image;
        }
        // get mention user
        $mentions = $this->content_model->get_mention_by_content_id($content->not_id);
        $content->mentions = $mentions;

        $this->load->view('home/share/page/content-intermediate', ['content'=>$content, 'af_id' => $af_id], FALSE);
    }
 
    function api_share_content(){
        $new_id = (int)$this->input->post('id');
        $jData = $this->callAPI('GET', API_LISTSHARE_CONTENT.'/'.$new_id, []);
        echo $jData;
        die();
    }

    function api_share_images(){
        $id_image = (int)$this->input->post('id');
        $jData = $this->callAPI('GET', API_LISTSHARE_IMAGE.'/'.$id_image, []);
        echo $jData;
        die();
    }

    function api_share_videos(){
        $id_image = (int)$this->input->post('id');
        $jData = $this->callAPI('GET', API_LISTSHARE_VIDEO.'/'.$id_image, []);
        echo $jData;
        die();
   }

    function api_share_links(){
        $id_link = (int)$this->input->post('id');
        $jData = $this->callAPI('GET', API_LISTSHARE_LINK.'/'.$id_link, []);
        echo $jData;
        die();
    }

    function api_share_collection(){
        $id_collection = (int)$this->input->post('id');
        $jData = $this->callAPI('GET', API_LISTSHARE_COLLECTION.'/'.$id_collection, []);
        echo $jData;
        die();
    }

    function api_push_share(){
        $result['error'] = true;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        $data = array('id' => (int)$this->input->post('id'), 'type' => (int)$this->input->post('type'), 'source' => $this->input->post('source'));
        $jData = $this->callAPI('POST', API_PUSH_SHARE, $data, $rent_header);
        $status = json_decode($jData);
        if($status->status == 0){
            $jData = $this->callAPI('POST', API_PUSH_SHARE, json_encode($data), $rent_header);//page shop
        }
        $status = json_decode($jData);
        
        $api_get_linkshr = '';
        if($status->status == 1){
            $tag = $this->input->post('tag');
            switch ($tag) {
                case 'image':
                    $api_get_linkshr = API_LISTSHARE_IMAGE;
                    break;
                
                case 'video':
                    $api_get_linkshr = API_LISTSHARE_VIDEO;
                    break;
                
                case 'link':
                    $api_get_linkshr = API_LISTSHARE_LINK;
                    break;
                
                case 'content':
                    $api_get_linkshr = API_LISTSHARE_CONTENT;
                    break;
            }

            $getapi = json_decode($this->callAPI('GET', $api_get_linkshr.'/'.$this->input->post('id'), []));
            $result['error'] = false;
            $result['data'] = $getapi;
        }

        echo json_encode($result);
        die();
    }
}