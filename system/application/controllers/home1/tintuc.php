<?php

#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#

class Tintuc extends MY_Controller {

    public function __construct()
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
        $this->lang->load('home/defaults');
        #Load model
        $this->db->distinct('pro_category');
        $this->load->model('category_model');
        $this->load->model('product_model');
        $this->load->model('ads_model');
        $this->load->model('job_model');
        $this->load->model('shop_model');
        $this->load->model('package_user_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('user_model');
        $this->load->model('product_favorite_model');
        $this->load->model('content_model');
        $this->load->model('comment_model');
        $this->load->model('eye_model');
        $this->load->model('notify_model');
        $this->load->model('reports_model');
        $this->load->model('collection_model');
        $this->load->model('follow_favorite_model');
        $this->load->model('customlink_model');
        $this->load->model('grouptrade_model');

        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect           = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }

        #BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }
        #END Update counter
        #
        #BEGIN Eye
        if ($this->session->userdata('sessionUser') > 0) {
            $data['sho_package']    = $this->getConditionsShareNews((int)$this->session->userdata('sessionGroup'), (int)$this->session->userdata('sessionUser'));
            $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
            $data['listeyeraovat']  = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
            $data['listeyehoidap']  = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));

        } else {
            array_values($this->session->userdata['arrayEyeSanpham']);
            array_values($this->session->userdata['arrayEyeRaovat']);
            array_values($this->session->userdata['arrayEyeHoidap']);
            $data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');
            $data['listeyeraovat']  = $this->eye_model->geteyetypenologin('raovat');
            $data['listeyehoidap']  = $this->eye_model->geteyetypenologin('hoidap');
        }


        #END Eye
        $currentDate              = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar               = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;

        $notifyTaskbar               = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;


        $data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
        //$data['productCategoryHot'] = $this->loadCategoryHot(0, 0);

        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);

        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_enddate  >= $currentDate", "not_degree", "DESC");
        $data['mainURL']    = $this->getMainDomain();
        $data['permission'] = $this->db->query('SELECT * FROM `tbtt_permission`')->result();

        //Get shop from User
        if (($sessionUser = $this->session->userdata('sessionUser'))) {
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite","use_id = " . $sessionUser);
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain, sho_logo, sho_dir_logo","sho_user = " . $sessionUser);
                //Get AF Login
                $data['af_id'] = $data['currentuser']->af_key;
            } elseif($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15 ) {
                $parentUser = $this->user_model->get("parent_id","use_id = " . $sessionUser);
                $myshop = $this->shop_model->get("sho_link, domain, sho_logo, sho_dir_logo","sho_user = " . $parentUser->parent_id);
            }
            $data['myshop'] = $myshop;
        }

        //user new type array
        $data['user_login'] = MY_Loader::$static_data['hook_user'];

        $list_grouptrade = $this->grouptrade_model->fetch('grt_id,grt_name', 'grt_admin = "' . $this->session->userdata('sessionUser') . '"');
        if (!empty($list_grouptrade)) {
            foreach ($list_grouptrade as $key => $value) {
                $this->session->set_userdata('sessionGrt_' . $value->grt_id, $value->grt_id);
            }
        }
        $data['list_grouptrade'] = $list_grouptrade;

        $this->load->vars($data);
    }

    public function loadCategoryLevel1($parent, $level) {
        $select = "*";
        $this->load->model('category_model');
        $where = "parent_id='$parent' AND cat_level=$level";
        $category = $this->category_model->fetch($select, $where);
        return $category;
    }

    public function _valid_captcha($str) {
        if ($this->session->userdata('sessionCaptchaRegister') && $this->session->userdata('sessionCaptchaRegister') === strtoupper($str)) {
            $this->session->unset_userdata('sessionCaptchaRegister');
            return true;
        }
        return false;
    }

    public function cronuptin() {
        $this->load->model('uptin_model');
        $thu = date('N') + 1;
        $gio = date('G:i');
        $lichUp = $this->uptin_model->getLichUp($thu, $gio);
        foreach ($lichUp as $row) {
            $this->uptin_model->uptin($row->tin_id, $row->type);
            $this->uptin_model->minusLichUp($row->id);
        }
    }

    public function loadMenu($parent, $level, &$retArray) {
        $select = "men_name, men_descr, men_image, men_category";
        $whereTmp = "men_status = 1";
        if (strlen($where) > 0) {
            $whereTmp .= $where . " and parent_id='$parent' ";
        } else {
            $whereTmp .= $where . "parent_id='$parent'";
        }
        $menu = $this->menu_model->fetch($select, $whereTmp, "men_order", "ASC");


        foreach ($category as $row) {

            $row->cat_name = str_repeat('-', $level) . " " . $row->cat_name;
            $retArray[] = $row;
            $this->loadMenu($row->men_category, $level + 1, $retArray);
            //edit by nganly de qui
        }
    }

    public function loadCategoryRoot($parent, $level) {
        $select = "*";
        $whereTmp = "cat_status = 1 and parent_id = '$parent'";
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }

    public function loadCategory($parent, $level) {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");

        if (count($category) > 0) {
            $retArray .= "<ul id='mega-1' class='mega-menu right'>";
            foreach ($category as $key => $row) {
                //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
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

    public function loadSubCategory($parent, $level) {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<div class='sub-container mega'>";
            $rowwidth = 190;
            if (count($category) == 2) {
                $rowwidth = 450;
            }
            if (count($category) >= 3) {
                $rowwidth = 660;
            }
            $retArray .= "<ul class='sub row' style='width: " . $rowwidth . "px;'>";
            foreach ($category as $key => $row) {
                //$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
                $link = '<a class="mega-hdr-a"  href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key % 3 == 0) {
                    //$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
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
                    //$retArray .= "</div>";
                }
                /* if(($key % 3 == 0)&&(!$category[$key+1]))
                  {
                  $retArray .= "</div>";
                  }else if(($key % 3 == 1)&&(!$category[$key+1])){
                  $retArray .= "</div>";
                  } */
            }
            $retArray .= "</ul></div>";
        }
        return $retArray;
    }

    public function loadSubSubCategory($parent, $level) {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  AND parent_id = '$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", "0", "5");
        if (count($category) > 0) {
            $retArray .= "<ul>";
            foreach ($category as $key => $row) {
                //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, "");
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $retArray .= "<li>" . $link . "</li>";
            }
            $retArray .= "<li ><a class='xemtatca_menu' href='product/xemtatca/" . $parent . "' > Xem tất cả </a></li>";
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    public function loadCategoryHot($parent, $level) {
        $retArray = '';

        $select = "*";
        $whereTmp = "cat_status = 1  AND parent_id='$parent' AND cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");

        $retArray .= '<div class="row hotcat">';
        foreach ($category as $key => $row) {
            $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $images = '<img class="img-responsive" src="' . base_url() . 'templates/home/images/category/' . $row->cat_image . '"/><br/>';
            $retArray .= '<div class="col-sm-4">' . $images . '<strong>' . $link . '</strong>';
            $retArray .= $this->loadSupCategoryHot($row->cat_id, $level + 1);
            $retArray .= "</div>";
        }
        $retArray .= '</div>';
        return $retArray;
    }

    public function loadSupCategoryHot($parent, $level) {

        $retArray = '';

        $select = "*";
        $whereTmp = "cat_status = 1  AND parent_id=' $parent '  AND cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");

        $retArray .= '<ul class="supcat">';
        foreach ($category as $key => $row) {
            $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $retArray .= '<li> - ' . $link . '</li>';
        }
        $retArray .= '</ul>';
        return $retArray;
    }

    public function my_array_random($arr, $num = 1) {
        shuffle($arr);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[] = $arr[$i];
        }
        return $num == 1 ? $r[0] : $r;
    }
    
    public function index($type = '', $id = '') {
        $this->load->model('images_model');
        $this->load->model('videos_model');
        $this->load->model('collection_model');
        $this->load->model('category_link_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->library('Mobile_Detect');

        $data['user_login']      = MY_Loader::$static_data['hook_user'];
        $data['protocol']        = get_server_protocol();
        $data['titleSiteGlobal'] = settingTitleTintuc;
        $data['descrSiteGlobal'] = settingDescrTintuc;
        $data['ogurl']           = azibai_url();
        $data['ogtype']          = "website";
        $data['ogtitle']         = settingTitleTintuc;
        $data['ogdescription']   = settingDescrTintuc;
        $params['filter']        = 'all';
        $data['home_page'] = 1;

        if(!empty($_REQUEST['filter']) && in_array($_REQUEST['filter'], json_decode(NEWS_FILTER, true))){
            $params['filter'] = $_REQUEST['filter'];
        }

        $page = isset($_POST['page']) ? $_POST['page'] : 1;

        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        if ($page < 1) {
            $page = 1;
        }
        $data['page']   = $page;
        // Số record trên một trang
        $limit = 5;

        // Tìm start
        $start = ($limit * $page) - $limit;

        $params['start'] = (int)$start;
        $params['limit'] = (int)$limit;
        $params['page']  = (int)$page;

        if($type == 'category' && $id){
            $category = $this->category_model->get("cat_id, cat_name, cat_descr, keyword","cat_status = 1 AND cat_id = ".(int)$id);
            if(empty($category)){
                redirect(base_url() . 'page-not-found', 'location');
                exit();
            }
            $data['titleSiteGlobal']      = $category->cat_name;
            $data['descrSiteGlobal']      = $category->cat_descr;
            $data['keywordproSiteGlobal'] = $category->keyword;
            $data['ogurl']                = azibai_url();
            $data['ogtype']               = "website";
            $data['ogtitle']              = settingTitleTintuc;
            $data['ogdescription']        = settingDescrTintuc;

            $data['category']             = $category;
            $params['cat_id']             = $category->cat_id;
        }

        $data['collection']      = false;

        $af_id = '';
        if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
            $af_id = $_REQUEST['af_id'];
        }
        $data['af_id'] = $af_id;

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
                    // if (strpos('x'.$value->avatar, 'https://') !== false || strpos('x'.$value->avatar, 'http://') !== false) {

                    // } else {
                    //     $data['collection'][$key]->avatar = DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar_path;
                    // }
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

        $data['list_news']  = $this->_get_news($params);

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/tintuc/items', $data, TRUE);
            exit();
        }
        $data['isHome']          = 1;
        $data['listShop']        = $this->getListShop();
        $data['listreports']     = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'ASC');

        $detect = new Mobile_Detect();  
        $data['num'] = 5; 
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['num'] = 4;
        }

        $data['categories_popup_create_link'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        $this->load->helper('text');
        $this->load->view('home/tintuc/defaults', $data);
    }

    private function _get_news($params = array())
    {
        $this->load->library('link_library');
        $this->load->model('like_content_model');

        if(($sessionUser = $this->session->userdata('sessionUser'))){
            $params['user_login'] =  $sessionUser;
        }

        if(($sessionGroup = $this->session->userdata('sessionGroup'))){
            $params['user_group'] =  $sessionGroup;
        }

        $list_news = $this->content_model->get_news_wall($params);

        foreach ($list_news as $key => $item) {
            $web_profile = $this->user_model->get('website', 'use_id = '.$item->not_user);
            if($web_profile->website != '' && $web_profile->website != NULL)
            {
                $item->website = $web_profile->website;
            }
            
            //Dem so luọc chon tin
            $this->load->model('chontin_model');
            $item->chontin = 0;
            $result = $this->chontin_model->fetch('id', 'not_id = '. $item->not_id);
            if (count($result)) {
                $item->chontin = count($result);
            }

            //Dem like
            $list_likes = $this->like_content_model->get('id', ['not_id' => (int)$item->not_id]);
            $item->likes = count($list_likes);

            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_CONTENT.'/'.$item->not_id, []));
            $item->total_share = $jData->data->total_share;
            
            $item->type_share = TYPESHARE_HOME_NEWS;
            if($sessionUser){
                //Kiem tra 1 user bat ky da chon tin nay chua

                $item->dachon = 0;
                $dachon = $this->chontin_model->fetch('id', 'not_id = '.$item->not_id.' AND sho_user_1 = '. $sessionUser);
                if (count($dachon)) {
                    $item->dachon = 1;
                }

                //User co duoc phep chon tin nay khong
                if(in_array($sessionGroup, json_decode(ListGroupAff, true) ) && $item->not_user !=  $sessionUser) {
                    $item->chochontin = 1;
                } else {
                    $item->chochontin = 0;
                }

                // đã like
                $is_like = $this->like_content_model->get('id', ['user_id' => $sessionUser, 'not_id' => (int) $item->not_id]);
                $item->is_like = count($is_like);
            }

            //Get Customlink
            $item->not_customlink = $this->link_library->link_of_news($item->not_id, '', 0, 0, 0, true);

            /* GOI SAN PHAM NẾU CÓ CHỌN */
            $array = array();
            $aListImage = $this->images_model->get('*', 'not_id = ' . $item->not_id);
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
                        $oImage->link_crop,
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
                        $product = $this->product_model->get($select_hh.'pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff_value, end_date_sale, af_amt, (af_rate) as aff_rate'. DISCOUNT_QUERY, 'pro_id = '. (int) $value[1]);
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
                    $listImg[$k]->link_crop = $value[11];
                    $listImg[$k]->type = 'img';
                }
            }
            $item->listImg = $listImg;
            $item->listPro = $listPro;

            //kiểm tra có quick view link + product + tag
            $list_news[$key]->check_quick_view['product'] = false;
            $list_news[$key]->check_quick_view['link'] = false;
            $list_news[$key]->check_quick_view['tag'] = false;

            if(!empty($item->listPro)){
                $list_news[$key]->check_quick_view['product'] = true;
            }
            if(!empty($item->not_customlink)){
                $list_news[$key]->check_quick_view['link'] = true;
            }
            if (count($item->listImg) > 0) {
                foreach ($item->listImg as $key_img => $value) {
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

            $iVideoId       = (int)$item->not_video_url1;
            $item->video_id = $iVideoId;
            $aVideos        = $this->videos_model->get("*", 'id = ' . $iVideoId);
            $item->poster   = '';
            $item->poster_path   = '';

            if (!empty($aVideos)) {
                $item->not_video_url1 = $aVideos[0]->name;
                if (!empty($aVideos[0]->thumbnail)) {
                    $item->poster =  DOMAIN_CLOUDSERVER . 'video/thumbnail/'. $aVideos[0]->thumbnail;
                    $item->poster_path = $aVideos[0]->thumbnail;
                }
            }

            $follow = 0;
            $status_follow = array();
            if($item->sho_id > 0){
                $this->load->model('follow_shop_model');
                $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$item->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
                
                $status_follow['follow_shop'] = 0;
                if (!empty($getFollow))
                {
                    if($getFollow[0]->hasFollow == 1){
                        $status_follow['follow_shop'] = 1;
                    }
                }
            }else{
                $this->load->model('friend_model');
                $getFollow = $this->friend_model->get('id, accept', ['user_id' => (int)$item->use_id, 'add_friend_by' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getFollow))
                {
                    if($getFollow[0]->accept == 0){
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
            }
            $item->follow = $status_follow;

            // get mention user
            $mentions = $this->content_model->get_mention_by_content_id($item->not_id);
            $list_news[$key]->mentions = $mentions;
        }

        // get Suggest
        $page   = $params['page'];
        $limit  = $params['limit'];
        $start  = $params['start'];
        if($this->session->userData("sessionUser") && !empty($list_news)) {
            // include api
            $this->load->file(APPPATH.'controllers/home/api_content.php', false);
            // end
            $suggest_list = Api_content::suggest_in_newsfeed();
// dd($suggest_list);die;
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

    public function detail($not_id, $profile = false)
    {
        $data = $this->_data_detail($not_id, $profile);
        $this->load->view('home/tintuc/detail', $data);
    }

    public function icons_detail($not_id, $slug_icon, $profile = false)
    {
        $data = $this->_data_detail($not_id, $profile);
        $data['slug_icon'] = $slug_icon;
        $this->load->view('home/tintuc/icons-detail', $data);
    }

    private function _data_detail($not_id, $profile) {
        $this->load->model('content_model');
        $this->load->model('images_model');
        $this->load->model('music_model');
        $this->load->model('videos_model');
        $this->load->model('customlink_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('follow_shop_model');
        $this->load->model('like_content_model');
        $this->load->model('category_link_model');
        $this->load->model('content_link_model');
        $this->load->model('content_image_link_model');
        $this->load->library('link_library');
        $this->load->library('file_library');
        $this->load->library('content_library');
        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $sessionUser        = (int)$this->session->userdata('sessionUser');
        $sessionGroup       = (int)$this->session->userdata('sessionGroup');
        $data['is_owner']   = false;

        if(!empty($data['user_login'])){
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        //Affiliate
        $af_id = '';
        if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
            $af_id = $_REQUEST['af_id'];
            $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
            if (!empty($userObject) && $userObject->use_id > 0) {
                $this->session->set_userdata("af_id", $af_id);
                setcookie("af_id", $userObject->use_id, time() + (86400 * 30), '/'); // 86400 = 1 day
            }
        }
        
        ##BEGIN:: protocol and domain
        $data['protocol'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'on' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $data['domainname'] = $_SERVER['HTTP_HOST'];
        ##END:: protocol and domain

        #BEGIN: Update view
        if ($not_id) {
            $query = 'UPDATE tbtt_content SET not_view = not_view + 1 WHERE not_id = ' . $not_id;
            $this->db->query($query);
        }
        #END Update view

        $data['listreports'] = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'ASC');
        $shopID = null;
        $shop_near = null;
        if( $sessionUser ) { // neu co mot user dang nhap vao
            $shopID = $this->get_shop_in_tree($sessionUser);
            $shopID = $shopID != 0 ? $shopID : $sessionUser;
            $shop_near = $this->get_shop_nearest($sessionUser);
            $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
        }
        $item = $this->content_model->news_detail($not_id, $sessionUser, $sessionGroup, $shopID, $shop_near);
        if(!$item){
            redirect(base_url(), 'location');
        }

        //check có phải là chủ bài viết ko.
        if(!empty($data['user_login'])){
            $data['is_owner']   = check_owner($data['user_login']['use_id'], $data['user_login']['my_shop']['sho_id'], $item->not_user, $item->sho_id);
        }
        $item->not_description  = $this->filter->reinjection($item->not_description);
        $item->not_detail       = $this->filter->reinjection($item->not_detail);
        // Khởi tạo đường dẫn hình ảnh
        $af_key = '';
        $currentuser = $this->user_model->get("af_key", "use_id = '" . $sessionUser . "'");
        if(count($currentuser) > 0 && $currentuser->af_key != ''){
            $af_key = '?af_id='.$currentuser->af_key;
        }else{
            if($af_id != ''){
                $af_key = '?af_id='.$af_id;
            }
        }
        $item->sLinkFolderImage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/';

        if(in_array($sessionGroup, json_decode(ListGroupAff, true) ) && $item->not_user !=  $sessionUser) {
            $item->chochontin = 1;
        } else {
            $item->chochontin = 0;
        }

        //Dem so lan chon tin
        $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = '.$not_id );
        $result = $query->result() ;
        if( count($result) ) { $item->chontin = count($result); } else { $item->chontin = 0; } 

        $list_likes = $this->like_content_model->get('id', ['not_id' => (int) $not_id]);
        $item->likes_content = count($list_likes);

        //Dem share
        $jData = json_decode($this->callAPI('GET', API_LISTSHARE_CONTENT.'/'.$not_id, []));
        $item->total_share = $jData->data->total_share;

        //Kiem tra user dang nhap da chon tin nay chua
        if($sessionUser){
            $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $not_id . ' AND sho_user_1 = ' . $sessionUser );
            $result = $query->result();
            if( count($result) ) { $item->dachon = 1; } else { $item->dachon = 0; } 
            
            $query = $this->db->query('SELECT * FROM tbtt_content_favorite WHERE fav_not_id = ' . $item->not_id . ' AND fav_user = ' . $sessionUser);
            $result = $query->result();
            if (count($result)) { $item->yeuthich = 1; } else { $item->yeuthich = 0; }

            // đã like
            $is_like = $this->like_content_model->get('id', ['user_id' => $sessionUser, 'not_id' => (int) $not_id]);
            $item->is_like_content = count($is_like); 
        }      

        $iVideoId =  (int) $item->not_video_url1;
        $item->video_id = $iVideoId;

        $aVideos = $this->videos_model->get("*",'id = '.$iVideoId);

        if(!empty($aVideos)){
            $item->not_video_url1       = @$aVideos[0]->name;
            $item->video_title          = @$aVideos[0]->title;
            $item->video_description    = @$aVideos[0]->description;
        }

        /*GOI SAN PHAM NẾU CÓ CHỌN */
        $array = array();
        $aListImage = $this->images_model->get("*",'not_id = '.$item->not_id);
        if(!empty($aListImage)) {
            $this->load->model('like_image_model');
            foreach ($aListImage as $key => $oImage) {
                //Get content image link
                $content_image_links = $this->content_image_link_model->link_of_news($item->not_id, $oImage->id, 0, $data['is_owner'], 'ASC');
                if($sessionUser){
                    //active user like
                    $is_like = $this->like_image_model->get('id', ['user_id' => $sessionUser, 'image_id' => (int) $oImage->id]);
                    $oImage->is_like = count($is_like);
                }
                //get total like
                $list_likes = $this->like_image_model->get('id', ['image_id' => (int) $oImage->id]);
                $oImage->likes = count($list_likes);

                //Dem share
                $jData = json_decode($this->callAPI('GET', API_LISTSHARE_IMAGE.'/'.$oImage->id, []));
                $oImage->total_share = $jData->data->total_share;

                $array[$key] = array(
                    $oImage->name,
                    $oImage->product_id,
                    $oImage->title,
                    $oImage->link,
                    $oImage->content,
                    $oImage->style_show,
                    $content_image_links,
                    $oImage->tags,
                    $oImage->id,
                    $oImage->is_like,
                    $oImage->likes,
                    $oImage->link_crop,
                    $oImage->total_share
                );
            }
        }
        if($item->not_video_url1){
            $this->load->model('like_video_model');
            if($sessionUser){
                //active user like
                $is_like        = $this->like_video_model->get('id', ['user_id' => $sessionUser, 'video_id' => (int) $iVideoId]);
                $item->is_like  = count($is_like);
            }
            //get total like
            $list_likes  = $this->like_video_model->get('id', ['video_id' => (int) $iVideoId]);
            $item->likes = count($list_likes);

            //Dem share
            $jData = json_decode($this->callAPI('GET', API_LISTSHARE_VIDEO.'/'.$iVideoId, []));
            $item->total_share = $jData->data->total_share;
        }
        
        $listImg = array();
        $listPro = array();
        $this->load->model('detail_product_model');

        if(!empty($array)){
            foreach ($array as $k => $value) {
                if (strlen($value[0]) > 10) {

                    @$listImg[$k]->image = $value[0];
                    if ($value[1] > 0) {
                        $select_hh = 'apply, pro_saleoff, pro_type_saleoff, begin_date_sale, end_date_sale, pro_saleoff_value, af_dc_rate, af_dc_amt, ';
                        $product = $this->product_model->get($select_hh."pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, af_amt, (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int) $value[1]);
                        $detailproduct = $this->detail_product_model->get('count(tbtt_detail_product.dp_pro_id) as have_num_tqc', 'dp_pro_id = '. (int) $value[1]);

                        if (($current_user_id = $this->session->userdata('sessionUser'))) {
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

                        $listPro[$k]          = $product;
                    }
                    $listImg[$k]->title               = $value[2];
                    $listImg[$k]->detail              = $value[3];
                    $listImg[$k]->caption             = $value[4];
                    $listImg[$k]->style               = $value[5];
                    $listImg[$k]->content_image_links = $value[6];
                    $listImg[$k]->tags                = json_decode($value[7]);
                    $listImg[$k]->id                  = $value[8];
                    $listImg[$k]->is_like             = $value[9];
                    $listImg[$k]->likes               = $value[10];
                    $listImg[$k]->type                = 'img';
                    $listImg[$k]->link_crop           = $value[11];
                    $listImg[$k]->total_share           = $value[12];
                }
            }
        }

        $data['listImg'] = $listImg;
        $data['listPro'] = $listPro;

        // Slider effect
        $aListEffects = array(
            'turn',
            'shift',
            'louvers',
            'cube_over',
            'tv',
            'lines',
            'bubbles',
            'dribbles',
            'glass_parallax',
            'parallax',
            'brick',
            'collage',
            'seven',
            'kenburns',
            'cube',
            'blur',
            'book',
            'rotate',
            'domino',
            'slices',
            'blast',
            'blinds',
            'basic',
            'basic_linear',
            'fade',
            'fly',
            'flip',
            'page',
            'stack',
            'stack_vertical'
        );
        $item->not_effect = $aListEffects[array_rand($aListEffects)];

        // Show background
        $item->sBackground         = '';
        $item->sClassBackground    = '';
        $item->sBackgroundTwo      = '';
        $item->sClassBackgroundTwo = '';

        if($item->not_image != '') {
            $pattern = parse_url(DOMAIN_CLOUDSERVER, PHP_URL_HOST);
            $check = preg_match('/'.$pattern.'/', $item->not_image);
            if ($item->not_display == 1) {
                if ($check) {
                    $item->sBackgroundTwo = 'background-image: url('.$item->not_image.')';
                } else {
                    $item->sBackgroundTwo      = 'background-image: url('.$item->sLinkFolderImage.$item->not_image.')';
                }
                $item->sClassBackgroundTwo = 'have-bg';
            }
            if ($check) {
                $item->sBackground = 'background-image: url('.$item->not_image.')';
            } else {
                $item->sBackground      = 'background-image: url('.$item->sLinkFolderImage.$item->not_image.')';
            }
            $item->sClassBackground = 'have-bg';
        }

        $item->sBackgroundSlider = '';

        if($item->sBackground != '') {
            $item->sBackgroundSlider = $item->sBackground;
        }else {
            $item->sBackgroundSlider = 'background-image: url('.$item->sLinkFolderImage.$item->not_image.')';
        }

        //Get content link
        $item->not_customlink = $this->content_link_model->link_of_news($item->not_id, 0, $data['is_owner'], 'ASC');

        // Decode not_additional
        $item->not_additional = $item->not_additional ? @json_decode($item->not_additional) : null;
//        $item->not_additional =  json_decode($item->not_additional) ;
//        echo '<pre>';
//        echo '<br/>';
//        print_r($item->not_additional);echo '<br/>';
//        echo '<br/>';
//        echo '<br/>';
//        echo '<pre>';
//        die('dbphp');
        // get mention user
        $mentions = $this->content_model->get_mention_by_content_id($item->not_id);
        $item->mentions = $mentions;

        $data_detail = preg_replace('/(?<!href="|">)(?<!data-original=\")(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', html_entity_decode($item->not_detail));
        // process mentions
        if(!empty($mentions)) {
            foreach ($mentions as $key => $mention) {
                $str_find = "<{$mention->user_id}>";
                $str_replace = "<a class='text-primary' href='{$mention->link_website}'>@{$mention->full_name}</a>";
                $data_detail = str_replace($str_find, $str_replace, $data_detail);
            }
        }
        // set hashtag
        if(preg_match_all('/#[a-zA-Z0-9]*/i', $data_detail, $m)) {
            foreach ($m[0] as $key => $value) {
                $keyword = urlencode($value);
                $url = azibai_url("/search?keyword=$keyword");
                $str_find = "{$value}";
                $str_replace = "<a class='text-primary' href='{$url}'>{$value}</a>";
                $data_detail = str_replace($str_find, $str_replace, $data_detail);
            }
        }

        $item->not_detail = $data_detail;

        $data['item'] = $item;

        #BEGIN: Load comment        
        $this->comment_model->setCurLink(uri_string());
        $countcomments = $this->comment_model->getComments(array('noc_content' => $not_id));
        $data['countcomments'] = count($countcomments);
        
        if( $this->session->userdata('sessionUser') == $item->not_user ) {
            $comments = $this->comment_model->getComments(array('noc_content' => $not_id, 'noc_reply' => 0));
        } else {
            $comments = $this->comment_model->getComments(array('noc_content' => $not_id, 'noc_reply' => 0, 'noc_user' => $sessionUser ) );
        }
        
        foreach($comments as $key=>$value) {            
           $comments[$key]['replycomment'] =  $this->comment_model->getComments(array('noc_reply' => $value['noc_id']));
        }  
        
        $data['comments'] = $comments;
    
        $data['pager'] = $this->comment_model->pager;
        #END Load comment

        // Add share link counter
        $shareId = isset($_REQUEST['share']) ? $_REQUEST['share'] : '';
        
        if ($shareId != '') {
            $this->load->model('share_model');
            $a = $this->share_model->counter(array('link' => uri_string(), 'share_id' => $shareId, 'content_id' => $id_detail, 'content_title' =>$detail_content->not_title, 'content_type' => '02'));
        }


        $where_related = "id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_pro_cat_id = " . $item->not_pro_cat_id . " AND not_id != " . $item->not_id . " AND not_title != '' AND (not_image != '' OR not_image != 0) AND tbtt_content.sho_id != 0 " . $where_permission;
        if(is_domain_shop()) {
            $where_related = "id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_pro_cat_id = " . $item->not_pro_cat_id . " AND not_id != " . $item->not_id . " AND not_title != '' AND (not_image != '' OR not_image != 0) AND tbtt_content.sho_id = $item->sho_id " . $where_permission;
        }

        $list_related = $this->content_model->fetch_join(
            "not_id, not_title, not_detail, not_begindate, not_view, not_image, not_dir_image, not_description, not_user, tbtt_shop.sho_name as use_fullname, tbtt_shop.sho_id, tbtt_shop.sho_logo, tbtt_shop.sho_dir_logo, tbtt_shop.sho_link, tbtt_shop.domain, tbtt_shop.sho_user",
            "LEFT",
            "tbtt_shop",
            'tbtt_shop.sho_id = tbtt_content.sho_id',
            $where_related,
            "not_id",
            "DESC",
            0,
            10
        );

        if(isset($list_related) && !empty($list_related)) {
            foreach ($list_related as $iKeyNewRe => $oNewRe) {
                $follow = 0;
                $getFollow = $this->follow_shop_model->get('*', ['shop_id' => (int)$oNewRe->sho_id, 'follower' => (int)$this->session->userdata('sessionUser')]);
                if (!empty($getFollow))
                {
                    if($getFollow[0]->hasFollow == 1){
                        $follow = 1;
                    }
                }
                $oNewRe->follow = $follow;
            }
        }
        
        $data['list_related'] = $list_related;
        $data['list_views']   = $this->content_model->fetch("not_id, not_title, not_begindate, not_view, not_image, not_dir_image, not_description","id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_pro_cat_id = " . $item->not_pro_cat_id . " AND not_id != " . $item->not_id . " AND not_title != '' AND (not_image != '' OR not_image != 0) " . $where_permission , "not_view", "DESC", 0 , 10);

        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();  
        $data['num'] = 5; 
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['num'] = 4;
        }

        $data['is_detail_news_profile'] = $profile;

        if ($item->not_image != '') {
            $check_http = explode(':', $item->not_image)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $item->not_image;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image;
            }
        } else if (!empty($listImg)) {
            $check_http = explode(':', $listImg[0]->image)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $listImg[0]->image;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $listImg[0]->image;
            }
        } else if (!empty($aVideos)) {
            $check_http = explode(':', $aVideos[0]->thumbnail)[0];
            if ($check_http == 'http' || $check_http == 'https') {
                $ogimage = $aVideos[0]->thumbnail;
            } else {
                $ogimage = DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $aVideos[0]->thumbnail;
            }
        } else if ($item->not_customlink != '' && !empty($item->not_customlink)) {
            $ogimage = $item->not_customlink[0]['image'] ? $item->not_customlink[0]['image_url'] : $item->not_customlink[0]['link_image'];
        }

        if(($_SERVER['HTTP_HOST'] == domain_site && strpos($_SERVER['REQUEST_URI'], 'profile') != '') || ($_SERVER['HTTP_HOST'] != domain_site && empty($item->sho_id)))
        {
            $type_share = TYPESHARE_DETAIL_PRFNEWS;
        }else
        {
            if($item->sho_id > 0 && $_SERVER['HTTP_HOST'] != domain_site){
                $type_share = TYPESHARE_DETAIL_SHOPNEWS;
            }
            else{
                $type_share = TYPESHARE_DETAIL_HOMENEWS;
            }
        }

        if(!empty($item->sho_id)){
            $og_title = $item->not_title;
        }else{
            $og_title = $item->use_fullname;
            if($item->not_detail != ''){
                $og_title .= ' - '.cut_string_unicodeutf8(strip_tags(html_entity_decode($item->not_detail)), 150);
            }
        }

        $og_des = $item->not_description ? $item->not_description : cut_string_unicodeutf8(strip_tags(html_entity_decode($item->not_detail)), 225);
        
        if($profile != false || explode('/',$_SERVER['REQUEST_URI'])[1] == 'profile'){
            $ogurl = base_url() . 'profile/'. explode('/',$_SERVER['REQUEST_URI'])[2] . '/news/detail/'.$item->not_id.$af_key;
        }else
            $ogurl = base_url() . explode('/',$_SERVER['REQUEST_URI'])[1] . '/detail/'.$item->not_id.'/'. RemoveSign($item->not_title).$af_key;
        
        $data['share_url'] = $ogurl;
        
        if((isset($_REQUEST['img']) && $_REQUEST['img'] != '') || (isset($_REQUEST['pop']) && $_REQUEST['pop'] != '')){
            $request = '';
            if(isset($_REQUEST['pop']) && $_REQUEST['pop'] != ''){
                $request = $_REQUEST['pop'];
                if($af_id != ''){
                    $ogurl .= '&pop='.$request.'#image_'.$request;
                }else{
                    $ogurl .= '?pop='.$request.'#image_'.$request;
                }
                $data['popup']           = $request;
            }else{
                if(isset($_REQUEST['img']) && $_REQUEST['img'] != ''){
                    $request = $_REQUEST['img'];
                    if($af_id != ''){
                        $ogurl .= '&img='.$request.'#image_'.$request;
                    }else{
                        $ogurl .= '?img='.$request.'#image_'.$request;
                    }
                }
            }

            $getImage = $this->images_model->get("*",'id = '.(int)$request);
            if(!empty($getImage)){
                $og_title = ($getImage[0]->title != '') ? $getImage[0]->title : $og_title;
                $og_des = $getImage[0]->content ? $getImage[0]->content : $og_des;
                $check_http = explode(':', $getImage[0]->name)[0];
                if($check_http == 'http' || $check_http == 'https'){
                    $ogimage = $getImage[0]->name;
                }else{
                    $ogimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image .'/'. $getImage[0]->name;
                }
            }else{
                $getVideo = $this->videos_model->get("*",'id = '.(int)$request);
                if(!empty($getVideo)){
                    $og_des = $getVideo[0]->description ? $getVideo[0]->description : $og_des;
                    $check_http = explode(':', $getVideo[0]->thumbnail)[0];
                    if($check_http == 'http' || $check_http == 'https'){
                        $ogimage = $getVideo[0]->thumbnail;
                    }else{
                        $ogimage = DOMAIN_CLOUDSERVER . 'video/thumbnail/'. $getVideo[0]->thumbnail;
                    }
                }
            }
        }

        $this->load->model('share_metatag_model');
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$item->not_user.' AND type = '.$type_share . ' AND item_id = '.$item->not_id);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }

        $arr_char = array('"', '“', '”');
        $ogtitle = str_replace($arr_char, "'", $og_title);
        $og_des   = str_replace($arr_char, "'", $og_des);

        $data['type_share']           = $type_share;
        $data['ogimage']              = $ogimage;
        $data['menuActive']           = 'news';
        $data['titleSiteGlobal']      = $item->not_title;
        $data['descrSiteGlobal']      = $item->not_description ? $item->not_description : cut_string_unicodeutf8(strip_tags(html_entity_decode($item->not_detail)), 225);
        $data['keywordproSiteGlobal'] = $item->not_keywords ? $item->not_keywords : $item->not_title;
        $data['ogurl']                = $ogurl;
        $data['ogtype']               = "article";
        $data['ogtitle']              = $ogtitle;
        $data['ogdescription']        = cut_string_unicodeutf8($og_des, 150);
        $data['share_name']           = convert_percent_encoding($og_title);

        return $data;
    }

    public function tin_hot_danhmuc($cat_id) {

        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $pageSort = "";
        $pageUrl = '';
        #END Menu
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        #If have page

        $getVar = $this->uri->uri_to_assoc(4);

        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;


        if ($cat_id > 0) {
            $where = 'not_status = 1 and not_publish = 1 and id_category = 16 and not_pro_cat_id = ' . $cat_id . ' and not_news_hot = 1';
        } else {
            $where = "";
        }

        $select = "not_id, not_title, not_begindate, not_detail, not_image, not_dir_image,not_paid_news, not_view, tbtt_category.cat_name, not_pro_cat_id";
        $table = "tbtt_category";
        $on = "tbtt_content.not_pro_cat_id = tbtt_category.cat_id";
        $sort = "not_paid_news, not_id";
        $by = "DESC";

        $tin_hot_danhmuc = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, $limit);

        $data['tin_hot_danhmuc'] = $tin_hot_danhmuc;

        $this->load->library('pagination');
        $list_news_count = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, -1);
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/' . $cat_id . '/tin-hot/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $data['isHome'] = 1;
        $this->load->helper('text');
        $this->load->view('home/tintuc/tin-hot-category', $data);
    }

    public function tin_sale_danhmuc($cat_id) {
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $pageSort = "";
        $pageUrl = '';
        #END Menu
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        #If have page

        $getVar = $this->uri->uri_to_assoc(4);

        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;


        if ($cat_id > 0) {
            $where = 'not_status = 1 AND not_publish = 1 AND id_category = 16 AND not_pro_cat_id = ' . $cat_id . ' AND not_news_hot = 1';
        } else {
            $where = "";
        }

        $select = "not_id, not_title, not_begindate, not_detail, not_image, not_dir_image, not_paid_news, not_view, tbtt_category.cat_name, not_pro_cat_id";
        $table = "tbtt_category";
        $on = "tbtt_content.not_pro_cat_id = tbtt_category.cat_id";
        $sort = "not_paid_news, not_id";
        $by = "DESC";

        $tin_sale_danhmuc = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, $limit);

        $data['tin_sale_danhmuc'] = $tin_sale_danhmuc;

        $this->load->library('pagination');
        $list_news_count = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, -1);
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/' . $cat_id . '/khuyen-mai/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $data['isHome'] = 1;
        $this->load->helper('text');
        $this->load->view('home/tintuc/tin-sale-category', $data);
    }

    public function tin_hot() {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $data['titleSiteGlobal'] = 'Tin tức HOT';
        $data['descrSiteGlobal'] = 'Tin tức azinet, Tin tức HOT';
        #END Menu
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        $this->db->distinct('pro_category');
        $this->load->model('shop_model');
        #If have page
        $getVar = $this->uri->uri_to_assoc(3);
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;

        $data['list_news'] = $this->content_model->fetch_join("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_news_hot = 1 AND not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_id", "DESC", $start, $limit);

        $list_news_count = $this->content_model->fetch_join("not_id, not_title, not_begindate, not_detail, not_image, not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_news_hot = 1 AND not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_id", "DESC", NULL, NULL);

        $this->load->library('pagination');
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/tin-hot/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $retArrayTintuc = array();
        $id_category = 16;
        $this->loadCategoryPhanMem($id_category, 0, $retArrayTintuc);

        $data['isHome'] = 1;
        $this->load->helper('text');
        $data['module'] = 'relatedthesim';
        $data['category_view_right'] = $this->content_category_model->fetch("*", "cat_type = 1");
        $this->load->view('home/tintuc/tin-hot', $data);
    }

    public function tin_sale() {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $data['titleSiteGlobal'] = 'Tin tức khuyễn mãi, giảm giá';
        $data['descrSiteGlobal'] = 'Tin tức azinet, Tin tức khuyễn mãi, giảm giá';
        #END Menu
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        $this->db->distinct('pro_category');
        $this->load->model('shop_model');
        #If have page
        $getVar = $this->uri->uri_to_assoc(3);
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;

        $data['list_news'] = $this->content_model->fetch_join("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_news_sale = 1 AND not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_id", "DESC", $start, $limit);

        $list_news_count = $this->content_model->fetch_join("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_news_sale = 1 AND not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_id", "DESC", NULL, NULL);

        $this->load->library('pagination');
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/khuyen-mai/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $retArrayTintuc = array();
        $id_category = 16;
        $this->loadCategoryPhanMem($id_category, 0, $retArrayTintuc);

        $data['isHome'] = 1;
        $this->load->helper('text');
        $data['module'] = 'relatedthesim';
        $data['category_view_right'] = $this->content_category_model->fetch("*", "cat_type = 1");
        $this->load->view('home/tintuc/tin-khuyen-mai', $data);
    }

    public function tin_view() {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $data['titleSiteGlobal'] = 'Tin xem nhi�?u';
        $data['descrSiteGlobal'] = 'Tin tức azinet, Tin tức được xem nhi�?u nhất';
        #END Menu
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        $this->db->distinct('pro_category');
        $this->load->model('shop_model');
        #If have page
        $getVar = $this->uri->uri_to_assoc(3);
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;

        $data['list_news'] = $this->content_model->fetch_join("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_view", "DESC", $start, $limit);

        $list_news_count = $this->content_model->fetch_join("not_id, not_title, not_begindate,not_detail,not_image,not_dir_image, not_view, not_video_url, not_user, sho_name, sho_descr, sho_user, sho_link, sho_logo, sho_dir_logo, sho_style", "LEFT", "tbtt_shop", "sho_user = not_user", "not_status = 1 AND not_publish = 1 AND id_category = 16 ", "not_view", "DESC", NULL, NULL);

        $this->load->library('pagination');
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/xem-nhieu/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $retArrayTintuc = array();
        $id_category = 16;
        $this->loadCategoryPhanMem($id_category, 0, $retArrayTintuc);

        $data['isHome'] = 1;
        $this->load->helper('text');
        $data['module'] = 'relatedthesim';
        $data['category_view_right'] = $this->content_category_model->fetch("*", "cat_type = 1");
        $this->load->view('home/tintuc/tin-xem-nhieu', $data);
    }

    public function tin_view_danhmuc($cat_id) {
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $pageSort = "";
        $pageUrl = '';
        #END Menu
        #BEGIN: Get random category
        $this->load->model('category_model');
        $this->load->model('content_model');
        #If have page

        $getVar = $this->uri->uri_to_assoc(4);

        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = 8;


        if ($cat_id > 0) {
            $where = 'not_status = 1 AND not_publish = 1 AND id_category = 16 AND not_pro_cat_id = ' . $cat_id . ' AND not_news_hot = 1';
        } else {
            $where = "";
        }

        $select = "not_id, not_title, not_begindate, not_detail, not_image, not_dir_image, not_paid_news, not_view, tbtt_category.cat_name, not_pro_cat_id";
        $table = "tbtt_category";
        $on = "tbtt_content.not_pro_cat_id = tbtt_category.cat_id";
        $sort = "not_paid_news, not_view";
        $by = "DESC";

        $tin_view_danhmuc = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, $limit);

        $data['tin_view_danhmuc'] = $tin_view_danhmuc;

        $this->load->library('pagination');
        $list_news_count = $this->content_model->fetch_join($select, "LEFT", $table, $on, $where, $sort, $by, $start, -1);
        $totalRecord = count($list_news_count);
        $config['base_url'] = base_url() . 'tintuc/' . $cat_id . '/xem-nhieu/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $data['isHome'] = 1;
        $this->load->helper('text');
        $this->load->view('home/tintuc/tin-view-category', $data);
    }

    public function get_shop_in_tree($uid){
        $parent = 0;
        $user = $this->user_model->get("use_id, parent_id", "use_id = ". $uid); //lấy nó
        $u_pa_1 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$user->parent_id); // lấy cho nó        
        if($u_pa_1 && $u_pa_1->use_group == 3){
            $parent = $u_pa_1->use_id;
        } elseif ($u_pa_1 && $u_pa_1->use_group == 14) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            } else {
                $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_2->parent_id);
                if($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                }
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 15) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 11) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_1->parent_id);
            if($u_pa_2 && $u_pa_2->use_group == 3){
                $parent = $u_pa_2->use_id;
            } elseif ($u_pa_2 && $u_pa_2->use_group == 14) {
                $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_2->parent_id);
                if($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                } else {
                    $u_pa_4 = $this->user_model->get("use_id, use_group, parent_id", "use_id = ". (int)$u_pa_3->parent_id);
                    if($u_pa_4 && $u_pa_4->use_group == 3) {
                        $parent = $u_pa_4->use_id;
                    }
                }
            }
        }
        return $parent;
    }

    ## Get my company or my Branch, I am CTV online
    public function get_shop_nearest($userId)
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

    public function loadCategoryPhanMem($parent, $level, &$retArray, $where) {
        $this->load->model('content_category_model');
        $select = "*";
        $whereTmp = "";
        if (strlen($where) > 0) {
            $whereTmp .= $where;
        } else {
            $whereTmp .= $where . "parent_id='$parent'";
        }
        $category = $this->content_category_model->fetch($select, $whereTmp);

        foreach ($category as $row) {
            $row->cat_name = $row->cat_name;
            $retArray[] = $row;
            $this->loadCategoryPhanMem($row->cat_id, $level + 1, $retArray);
            //edit by nganly de qui
        }
    }

    public function ajax_category() {

        $ret = $this->loadCategory4Search(0, 0);
        echo $ret;
        exit();
    }

    public function long_polling() {
        if ($this->session->userdata('sessionUser') > 0) {
            $query = "SELECT * FROM tbtt_session WHERE ip_address <> '" . $_SERVER['REMOTE_ADDR'] . "' AND user_data like '%" . $this->session->userdata('sessionUsername') . "%'";
            $tempresult = $this->db->query($query);
            $result = $tempresult->result();
            if (count($result) >= 2) {
                echo json_encode("1");
            } else {
                echo json_encode("0");
            }
        }
        exit();
    }

    public function long_polling_cancel() {
        $sessionLogin1 = array('sessionLongPollingCancel' => 1);
        $this->session->set_userdata($sessionLogin1);
        echo $this->session->userdata('sessionLongPollingCancel');
        exit();
    }

    public function loadCategory4Search($parent, $level) {
        $this->load->model('category_model');
        $retArray = '';
        $select = "*";
        $selCat = $this->input->post('selCate');
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {

            foreach ($category as $key => $row) {
                $selected = "";
                if ($selCat == $row->cat_id) {
                    $selected = "selected='selected'";
                }
                $retArray .= "<option  value='$row->cat_id' $selected>$row->cat_name</option>";
            }
        }
        return $retArray;
    }

    public function ajax_required_guarantee() {
        $shop_id = $_POST['shop_id'];
        $user_id = $this->session->userdata('sessionUser');
        $query = "SELECT * FROM tbtt_shop WHERE sho_users_required LIKE '%," . $user_id . "%'";
        $tempresult = $this->db->query($query);
        $result = $tempresult->result();
        if (count($result) > 0) {
            echo "1";
        } else {
            $query = "SELECT * FROM tbtt_shop WHERE sho_user=" . $shop_id;
            $tempresult1 = $this->db->query($query);
            $result1 = $tempresult1->result();
            if (count($result1) > 0) {
                $query = "UPDATE tbtt_shop SET sho_users_required = concat(sho_users_required,'," . $user_id . "') WHERE sho_user=" . $shop_id;
                $this->db->query($query);
            }
            echo "0";
        }
        exit();
    }

    public function ajax() {
        if (isset($_POST['code'])) {
            $localhost = settingLocalhost;
            $username = settingUsername;
            $password = settingPassword;
            $dbname = settingDatabase;
            $link = mysql_connect($localhost, $username, $password);
            if (!$link) {
                die('Could not connect: ' . mysql_error());
            }
            mysql_select_db($dbname, $link);
            //check for existence of active code
            $query = "SELECT * FROM jos_comprofiler WHERE active_code = '" . $_POST['code'] . "' limit 1";

            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);
            $quantity = mysql_num_rows($result);
            mysql_close($link);
            // check for existence of active code in
            $select = "use_id";
            $this->load->model('user_model');
            if ($_POST['code'] != "") {
                $userHaveActiveCode = $this->user_model->fetch($select, "active_code = '" . $_POST['code'] . "'", "use_id", "DESC");
            }
            if (count($userHaveActiveCode) > 0) {
                echo "2";
            } else {

                if ($quantity > 0 && $_POST['code'] != "") {
                    echo "1";
                } else {
                    echo "0";
                }
            }
        } else {
            if ($this->input->post('token') && $this->input->user_agent() != FALSE && $this->input->post('token') == $this->hash->create($this->input->ip_address(), $this->input->user_agent(), 'sha256md5') && $this->input->post('object')) {
                if ($this->input->post('type') && (int) $this->input->post('object') == 1) {
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $categoryProduct = (int) $this->input->post('type');
                    $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category";
                    $start = 0;
                    $limit = (int) settingProductNew_Home;
                    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryProduct AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
                    echo "[" . json_encode($product) . "," . count($product) . "]";
                } elseif ((int) $this->input->post('object') == 2) {
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $select = "pro_id, pro_name, pro_descr, pro_cost,pro_saleoff ,pro_saleoff_value, pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category, pro_vip";
                    $start = 0;
                    $limit = (int) settingProductReliable_Home;
                    $this->db->order_by("pro_vip", "random");
                    $this->db->order_by("pro_id", "random");
                    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_reliable = 1  AND pro_status = 1 ", $start, $limit); //AND pro_cost > 0 AND pro_reliable = 1 , order: "pro_vip", "DESC", \
                    for ($i = 0; $i < settingProductReliable_Home; $i++) {

                        if ($product[$i]->pro_saleoff == 1) {
                            if ($product[$i]->pro_saleoff_value > 0) {
                                if ($product[$i]->pro_type_saleoff == 1) {
                                    $product[$i]->pro_cost = $product[$i]->pro_cost - round(($product[$i]->pro_cost * $product[$i]->pro_saleoff_value) / 100);
                                } else {
                                    $product[$i]->pro_cost = $product[$i]->pro_cost - $product[$i]->pro_saleoff_value;
                                }
                            }
                        }
                    }
                    echo "[" . json_encode($product) . "," . settingProductReliable_Home . "]";
                } elseif ((int) $this->input->post('object') == 3) {
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $select = "sho_descr, sho_logo, sho_dir_logo, sho_link";
                    $start = 0;
                    $limit = (int) settingShopInterest;
                    $shop = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
                    echo "[" . json_encode($shop) . "," . count($shop) . "]";
                } elseif ($this->input->post('type') && (int) $this->input->post('object') == 4) {
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $where = "ads_status = 1 AND ads_enddate >= $currentDate";
                    //$sort = "ads_id";
                    $this->db->order_by("ads_vip", "desc");
                    $this->db->order_by("ads_id", "desc");
                    //$by = "DESC";
                    switch ((int) $this->input->post('type')) {
                        case 1:
                            $sort = "ads_view";
                            break;
                        case 2:
                            break;
                        default:
                            $where .= " AND ads_reliable = 1 ";
                        //$sort = "ads_vip";
                    }
                    $select = "ads_id, ads_category, ads_title, ads_descr,FROM_UNIXTIME(ads_begindate) as ads_begindates, pre_name, ads_vip";
                    $start = 0;
                    $limit = (int) settingAdsNew_Home;
                    $ads = $this->ads_model->fetch_join($select, "LEFT", "tbtt_province", "tbtt_ads.ads_province = tbtt_province.pre_id", "", "", "", "", "", "", $where, $start, $limit); //$sort, $by,
                    echo "[" . json_encode($ads) . "," . count($ads) . "]";
                } elseif ((int) $this->input->post('object') == 5) {
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $where = "job_status = 1 AND job_enddate >= $currentDate";
                    $sort = "rand()";
                    $by = "DESC";
                    $select = "job_id, job_title, job_field, job_jober";
                    $start = 0;
                    $limit = (int) settingAdsNew_Home;
                    $job = $this->job_model->fetch($select, $where, $sort, $by, $start, $limit);
                    echo "[" . json_encode($job) . "," . count($job) . "]";
                }
            } else {
                show_404();
                die();
            }
        }
    }

    // quang
    public function ajax_mancatego() {
        $categoryId = $_POST['selCate'];
        $ret = $this->loadMancategory4Search($categoryId);
        echo $ret;
        exit();
    }

    public function loadMancategory4Search($categoryId) {
        $this->load->model('category_model');
        $retArray = '';
        $select = "*";

        $whereTmp = "man_status = 1 AND man_id_category = " . $categoryId;
        $category = $this->category_model->fetch_mannufacturer($select, $whereTmp, "man_order", "ASC");
        if (count($category) > 0) {

            foreach ($category as $key => $row) {
                $selected = "";
                if ($selCat == $row->cat_id) {
                    $selected = "selected='selected'";
                }
                $retArray .= "<option  value='$row->man_id' $selected>$row->man_name</option>";
            }
        }
        return $retArray;
    }

    //edn quang

    public function autocompleteads() {
        $q = $_REQUEST["q"];
        if (!$q)
            return;
        $this->load->model('ads_model');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: autocomplete Ads
        $select = "ads_title";
        $this->db->like('ads_title', $q);
        $allAds = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_title", "DESC");
        #END autocomplete Ads

        foreach ($allAds as $item) {
            echo "$item->ads_title|$item->ads_title\n";
        }
    }

    // Quang
    public function autocompleteshop() {
        $q = $_REQUEST["q"];
        if (!$q)
            return;
        $this->load->model('shop_model');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: autocomplete Ads
        $select = "sho_name";
        $this->db->like('sho_name', $q);
        $allAds = $this->ads_model->fetch($select, "sho_status = 1 AND  sho_enddate >= $currentDate", "sho_name", "DESC");
        #END autocomplete Ads

        foreach ($allAds as $item) {
            echo "$item->sho_name|$item->sho_name\n";
        }
    }

    //end Quang
    public function autocomplete() {
        $q = $_REQUEST["q"];
        $type = $this->uri->segment(3);
        if ($type == "hoidap") {
            if (!$q)
                return;
            $this->load->model('hds_model');
            $select = "hds_title";
            $this->db->like('hds_title', $q);
            $allAds = $this->hds_model->fetch($select);
            #END autocomplete Ads

            foreach ($allAds as $item) {
                echo "$item->hds_title|$item->hds_title\n";
            }
        } else {
            if ($type == "raovat") {
                if (!$q)
                    return;
                $this->load->model('ads_model');
                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                #BEGIN: autocomplete Ads
                $select = "ads_title";
                $this->db->like('ads_title', $q);
                $allAds = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_title", "DESC");
                #END autocomplete Ads

                foreach ($allAds as $item) {
                    echo "$item->ads_title|$item->ads_title\n";
                }
            } else {
                if ($type == "shop") {

                    if (!$q)
                        return;
                    $this->load->model('shop_model');
                    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    #BEGIN: autocomplete Ads
                    $select = "sho_name";
                    $this->db->like('sho_name', $q);
                    $allAds = $this->shop_model->fetch($select, "sho_status = 1 AND     sho_enddate >= $currentDate", "sho_name", "DESC");
                    #END autocomplete Ads

                    foreach ($allAds as $item) {
                        echo "$item->sho_name|$item->sho_name\n";
                    }
                } else {
                    if ($type == "timviec") {

                        if (!$q)
                            return;
                        $this->load->model('employ_model');
                        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                        #BEGIN: autocomplete Ads
                        $select = "emp_title";
                        $this->db->like('emp_title', $q);
                        $allAds = $this->employ_model->fetch($select, "emp_status = 1 AND   emp_enddate >= $currentDate", "emp_title", "DESC");
                        #END autocomplete Ads

                        foreach ($allAds as $item) {
                            echo "$item->emp_title|$item->emp_title\n";
                        }
                    } else {
                        if ($type == "tuyendung") {

                            if (!$q)
                                return;
                            $this->load->model('job_model');
                            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                            #BEGIN: autocomplete Ads
                            $select = "job_title";
                            $this->db->like('job_title', $q);
                            $allAds = $this->job_model->fetch($select, "job_status = 1 AND  job_enddate >= $currentDate", "job_title", "DESC");
                            #END autocomplete Ads

                            foreach ($allAds as $item) {
                                echo "$item->job_title|$item->job_title\n";
                            }
                        } else {
                            if ($type == "product") {
                                if (!$q)
                                    return;
                                $this->load->model('product_model');
                                $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                #BEGIN: autocomplete
                                $select = "pro_name";
                                $this->db->like('pro_name', $q);
                                $allProduct = $this->product_model->fetch_join($select, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "", "", "", "", "", "", "pro_status = 1  AND sho_status = 1 ", "pro_name", "DESC");

                                //$allProduct = $this->product_model->fetch($select, "pro_status = 1 ", "pro_name", "DESC");

                                foreach ($allProduct as $item) {
                                    echo "$item->pro_name|$item->pro_name\n";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function rss() {

        $this->load->model('product_model');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: autocomplete
        $select = "pro_id,pro_name,pro_descr,pro_detail,pro_category,pro_dir,pro_image,pro_begindate";
        //$this->db->like('pro_id', $q);
        $this->db->limit(20);
        $allProduct = $this->product_model->fetch($select, "pro_status = 1 ", "pro_id", "DESC");

        $now = date("D, d M Y H:i:s T");

        $output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <rss version=\"2.0\">
                <channel>
                    <title>Sản phẩm mới nhất</title>
                    <link>http://vnbuy.com/rss</link>
                    <description>20 sản phẩm cập nhật gần đây nhất</description>
                    <language>vi-vn</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <docs></docs>
                    <managingEditor>tiennham@icsc.vn</managingEditor>
                    <webMaster>tiennham@icsc.vn</webMaster>
            ";

        for ($i = 0; $i < count($allProduct); $i++) {
            $line = $allProduct[$i];

            $output .= "<item><title>" . $line->pro_name . "</title>

                            <link>" . base_url() . $line->pro_category . "/" . $line->pro_id . "/" . removeSign($line->pro_name) . "</link>
        <description><![CDATA[ <a href=\"" . base_url() . $line->pro_category . "/" . $line->pro_id . "/" . removeSign($line->pro_name) . "\"><img src=\"" . base_url() . "media/images/product/" . $line->pro_dir . "/" . show_thumbnail($line->pro_dir, $line->pro_image, 2) . "\"/></a> <br/> " . $line->pro_descr . " ]]></description>
        <pubDate>" . date('d / m / Y H:i', $line->pro_begindate) . "</pubDate>
                        </item>";
        }

        $output .= "</channel></rss>";
        header("Content-Type: application/rss+xml");
        echo $output;
    }

    public function ajaxdomain() {
        $domain = $_POST['domainname'];

        $domaintohtmlid = str_replace(".", "_", $domain);
        // Kiem tra su ton tai cua ten mien
        if (file_get_contents("http://www.pavietnam.vn/vn/whois.php?domain=$domain") == '0') {
            echo "$domaintohtmlid----1";
        } else {
            echo "$domaintohtmlid----0";
        }
        exit();
    }
    
    public function comment() {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('noc_name', 'lang:tên', 'trim|required');
        $this->form_validation->set_rules('noc_comment', 'lang:nội dung', 'trim|required');
        $this->form_validation->set_rules('noc_content', 'lang:bài viết', 'trim|required');
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            $userID = (int)$this->session->userdata('sessionUser'); 	    
            $user = $this->user_model->get("use_id, use_fullname, use_email, use_phone, avatar", "use_id = ". $userID);	    
	    $comment = array (
		'noc_comment' => $this->input->post('noc_comment'),
		'noc_name' => $user->use_fullname,
		'noc_email' => $user->use_email,
		'noc_phone' => $user->use_phone,
		'noc_user' => $user->use_id,
		'noc_date' => date('Y-m-d H:i:s'), 	    
		'noc_content' => $this->input->post('noc_content'),
		'noc_avatar' =>  $user->avatar,
		'noc_reply' => $this->input->post('noc_reply')
	    );
            $this->comment_model->add($comment);
	    
	    /*// Start add notifications
	    $this->load->model('notifications_model');
	    $dataNotifications = array(			
		'`read`' => 0,
		'userId' => $user->use_id,
		'actionType' => "key_new_comment",
		'actionId' => $this->input->post('item_user'),
		'title' => "Có người bình luận về tin tức của bạn",
		'body' => '<strong>' . $user->use_fullname . '</strong> đã bình luận về bài viết <strong>'.$this->input->post('item_title').'</strong>',
		'meta' => '{"noc_content":' . $comment['noc_content'] . ',"id":}',
		'updatedAt' => time(),
		'createdAt' => time()
	    );
	    $this->notifications_model->add($dataNotifications);
	    // End add notifications*/	
	    
            $result = array('error' => false, 'comment' => $comment);
        } else {
            $validator = & _get_validation_object();
            $error_messages = $validator->_error_array;
            $result = array('error' => true, 'error' => $error_messages);
        }
        echo json_encode($result);
        exit();
    }

    public function search() {        
        
	if($this->input->post('keyword')){
		$keyword = $this->input->post('keyword'); 			
	} else { 
		$keyword = $this->uri->segment(4);			
	}
	$data['keyword'] = $keyword;
	$data['totalRecord'] = 0;

	if ($keyword) {
		$this->load->model('content_model');
		#If have page
		$action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);

		if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
		    $start = (int) $getVar['page'];
		    $pageSort .= '/page/' . $start;
		} else {
		    $start = 0;
		}

		$limit = 10;

		$results = $this->content_model->fetch("*", "not_title LIKE '%" . $keyword . "%' OR not_description LIKE '%" . $keyword . "%' AND not_status = 1 and id_category = 16", "not_id", "DESC", $start, $limit);
		$data['results'] = $results;

		$this->load->library('pagination');
		$total = $this->content_model->fetch("*", "not_title LIKE '%" . $keyword . "%' OR not_description LIKE '%" . $keyword . "%' AND not_status = 1 and id_category = 16", "not_id", "DESC", $start, -1);
		$totalRecord = count($total);
		$data['totalRecord'] = $totalRecord;
		$config['base_url'] = base_url() . 'tintuc/search/keyword/' . $keyword . '/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAccount;
		$config['num_links'] = 5;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
	    }
        $this->load->view('home/tintuc/search', $data);
    }
    
    public function get_youtube_id_from_url($url)
    {
        if (stristr($url,'youtu.be/'))
            {@preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); return $final_ID[4]; }
        else 
            {@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); return $IDD[5]; }
    }
    
    public function hidePost(){
        $this->load->model('content_model');
        $id = $this->input->post('id'); 
        $this->content_model->update(array('not_status' => 0), array('not_id' => $id));            
        echo '1';     
        exit();        
    }
    
    function deletePost(){
        $not_id = (int)$this->input->post('id');
        $this->load->model('content_model');
        $item = $this->content_model->get('*', 'not_id =' . $not_id);
        $ad = json_decode($item->not_ad);                   
        $listimage = array(
            $item->not_image, 'thumbnail_1_'.$item->not_image, 'thumbnail_2_'.$item->not_image, 'thumbnail_3_'.$item->not_image,
            $item->not_image1, '1x1_'.$item->not_image1,
            $item->not_image2, '1x1_'.$item->not_image2, 
            $item->not_image3, '1x1_'.$item->not_image3, 
            $item->not_image4, '1x1_'.$item->not_image4, 
            $item->not_image5, '1x1_'.$item->not_image5, 
            $item->not_image6, '1x1_'.$item->not_image6, 
            $item->not_image7, '1x1_'.$item->not_image7, 
            $item->not_image8, '1x1_'.$item->not_image8, 
            $item->not_image9, '1x1_'.$item->not_image9,
            $item->not_image10, '1x1_'.$item->not_image10, 
            $item->not_image11, '1x1_'.$item->not_image11, 
            $item->not_image12, '1x1_'.$item->not_image12,               
            $item->img_statistic, 
            $ad->ad_image
        );
        $cus = json_decode($item->not_customer);
        $cus_list = $cus->cus_list;  
        foreach ($cus_list as $key => $value) {
            $listimage[] = $value->cus_avatar; 
        } 
        
        $filepath = '/public_html/media/images/content/' . $item->not_dir_image;
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);        
        
        //xoa anh
        foreach ($listimage as $value) {
            if(strlen($value) > 10) {
                $this->ftp->delete_file($filepath . '/' . $value);
            }
        }
        $this->ftp->close();
        
        //xoa data
        $this->db->delete('tbtt_content', 'not_id = ' . $not_id);
        $this->callAPI('GET', API_DELETE_SEARCH_ARTICLE.$item->not_id);
        echo '1';
        exit();  
    }
    
    
    public function selectPost(){
        $data = array(                
                'sho_user_1' => (int)$this->session->userdata('sessionUser'),
                'not_id' => (int)$this->input->post('not_id'),
                'sho_user_2' => (int)$this->input->post('not_user')
        );        
        $query = $this->db->get_where('tbtt_chontin', $data);
        $row = $query->row();
        if($row->id){
            echo '0'; 
        } else {
            $this->db->insert("tbtt_chontin", $data); 
            echo '1';        
        }
        exit();
    }
    
    public function unSelectPost(){
        $data = array(                
                'sho_user_1' => (int)$this->session->userdata('sessionUser'),
                'not_id' => (int)$this->input->post('not_id')
        ); 
        
        $query = $this->db->get_where('tbtt_chontin', $data);
        $row = $query->row();
        $this->db->delete('tbtt_chontin', 'id = '. $row->id );
        echo '1';        
        exit();
    }
    
    public function ghimtin(){
        // Update = 0 neu = 1
        $this->db->where('not_ghim = 1');
        $data1 = array(                
               'not_ghim' => 0
        );
        $this->db->update('tbtt_content', $data1);
        
        // Update = 1 neu = id
        $this->db->where('not_id = '.$this->input->post('not_id'));
        $data2 = array(                
               'not_ghim' => 1
        );
        $this->db->update('tbtt_content', $data2);   
        echo '1';        
        exit();
    }
    
    public function setpermission(){
        $data = array(
            'not_permission' => $this->input->post('value')
        );
        $this->db->where('not_id', $this->input->post('not_id'));        
        $this->db->update('tbtt_content', $data);
        echo '1';        
        exit();
    }
    
    // Yeu thich favorite
    public function favorite(){
        $data = array(                
            'fav_user' => (int)$this->session->userdata('sessionUser'),
            'fav_not_id' => (int)$this->input->post('not_id')
        );
        $query = $this->db->get_where('tbtt_content_favorite', $data);
        $row = $query->row();
        if($row->fav_id){
            echo '0'; 
        } else {
            $this->db->insert("tbtt_content_favorite", $data); 
            echo '1';        
        }
        exit();
    }
    
    // Huy thich unfavorite
    public function unfavorite(){
        $data = array(                
            'fav_user' => (int)$this->session->userdata('sessionUser'),
            'fav_not_id' => (int)$this->input->post('not_id')
        );        
        $query = $this->db->get_where('tbtt_content_favorite', $data);
        $row = $query->row();
        if($row->fav_id){            
            $this->db->delete('tbtt_content_favorite', 'fav_id = '. $row->fav_id ); 
            echo '1';
        } else { 
            echo '0';           
        }      
        exit();
    }    
    
    /* GET LIST USER SELECT NEWS*/
    public function danhsachchon($not_id) {
        $query =    'SELECT 
                        a.`sho_name`, a.`sho_user`, a.`sho_link`, a.`sho_logo`, a.`sho_dir_logo`, a.`domain` 
                    FROM 
                        tbtt_shop AS a 
                    LEFT JOIN 
                        tbtt_chontin AS b ON a.`sho_user` = b.`sho_user`
                    WHERE  
                        b.`not_id` = '. $not_id;
        
        $data['listselect'] = $this->db->query($query)->result();

        $this->load->view('home/tintuc/dschontin', $data);
    }
    
    public function getConditionsShareNews($sessionGroup,$sessionUser) {                       
        switch ($sessionGroup){
	    case 3: //gianhang 
		$sho_package = $this->package_user_model->getCurrentPackage($sessionUser);
		break;                        
	    case 14://chinhanh 
		$userCurent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $sessionUser);
		$sho_package = $this->package_user_model->getCurrentPackage($userCurent->parent_id);
		break;
	    case 2: //affiliate
	    case 15: //nhanvien
		$userCurent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $sessionUser);
		$userParent = $this->user_model->get("use_id,use_group,parent_id","use_id = " . $userCurent->parent_id);
		if($userParent->use_group == 14){		    
		    $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
		} else { // 3
		    $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);
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
    
    public function getListShop(){  
    	$select = 'sho_name, sho_link, sho_logo, sho_dir_logo, domain';
            $where = 'sho_link != "" AND sho_status = 1 AND use_group = 3 AND use_status = 1';
    	$dsafdg = $this->shop_model->fetch_join($select, "LEFT", "tbtt_user", "use_id = sho_user", "", "", "", $where, "sho_id", "DESC");
    	return $dsafdg;
    }

    /**
     ***************************************************************************
     * Created: 2018/09/24
     * Ajax add new
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function addNewsHome() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $this->load->model('images_model');
        $this->load->model('videos_model');
        $this->load->model('content_link_model');
        $this->load->model('content_image_link_model');
        $this->load->model('music_model');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library('file_library');
        $this->load->library('ftp');
        $this->load->library('link_library');
        $this->load->library('form_validation');
        $this->load->library('content_library');
        $result['message']  = 'Thêm bài viết thất bại!';
        $result['type']     = 'error';

        if (!$this->input->post('personal')){
            $this->form_validation->set_rules(
                'not_title',
                'Tiêu đề',
                'required|max_length[130]|xss_clean'
            );
        }else  {
            $this->form_validation->set_rules(
                'not_title',
                'Tiêu đề',
                'max_length[130]|xss_clean'
            );
        }

        $this->form_validation->set_message('max_length', 'Tiêu đề không được nhập quá 130 kí tự');
        if ($this->form_validation->run() == FALSE){
            $result['message'] = validation_errors();
            echo json_encode($result);
            die();
        }

        // Check video hoặc hình hoặc customlink
        $check = 0;

        if($this->input->post('images')) {
            $check = 1;
        }

        if($this->input->post('not_video')) {
            $check = 1;
        }

        if($this->input->post('not_customlink')) {
            $check = 1;
        }

        if($check == 0) {
            $result['message'] = 'Vui lòng nhập ít nhất 1 tấm hình hoặc link liên kết hoặc video';
            echo json_encode($result);
            die();
        }

        if(!$this->isLogin()){
            $result['message']  = 'Vui lòng đăng nhập để thêm bài viết.';
            echo json_encode($result);
            die();
        }

        $group_id = (int)$this->session->userdata('sessionGroup');
        $iUserId = (int)$this->session->userdata('sessionUser');
        $this->ftp->connect($this->config->item('configftp'));

        #Create folder
        $pathImage = 'media/images/content/';
        $path      = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir       = date('dmY');
        // Upload to other server cloud
        $ldir = $this->ftp->list_files($path);
        $listFilesDelete = [];
        $listFilesSendFtp = [];

        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (! in_array($dir, $ldir)) {                    
            $this->ftp->mkdir($path . '/' . $dir, 0775);
        }

        if (!is_dir($pathImage . $dir_image)) {
            @mkdir($pathImage . $dir_image, 0775);
            $this->load->helper('file');
            @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
        }
        $aData = array(
            'not_title'         => '',
            'not_description'   => '',
            'not_keywords'      => '',
            'not_group'         => $group_id,
            'not_user'          => $iUserId,
            'not_degree'        => 1,
            'not_detail'        => '',
            'not_additional'    => '',
            'not_display'       => 0,
            'not_begindate'     => mktime(),
            'not_enddate'       => 0,
            'not_view'          => 0,
            'not_status'        => 1,
            'id_category'       => 16,
            'cat_type'          => 1,
            'not_dir_image'     => $dir,
            'not_video_url'     => '',
            'not_video_url1'    => 0,
            'group_docs'        => 0,
            'not_pro_cat_id'    => 0,
            'not_news_hot'      => 0,
            'not_news_sale'     => 0,
            'not_paid_news'     => 0,
            'not_ghim'          => 0,
            'not_publish'       => 1,
            'not_permission'    => 1,
            'not_slideshow'     => 0,
            'not_effect'        => '',
            'not_music'         => '',
            'not_ad'            => '',
            'statistic'         => '',
            'not_statistic'     => 0,
            'img_statistic'     => '',
            'not_customer'      => '',
            'not_posted_by'     => 'website',
            'not_image'         => '',
            'not_image1'        => '',
            'imgtitle1'         => '',
            'imglink1'          => 0,
            'linkdetail1'       => '',
            'imgcaption1'       => '',
            'imgstyle1'         => '',
            'not_image2'        => '',
            'imgtitle2'         => '',
            'imglink2'          => 0,
            'linkdetail2'       => '',
            'imgcaption2'       => '',
            'imgstyle2'         => '',
            'not_image3'        => '',
            'imgtitle3'         => '',
            'imglink3'          => 0,
            'linkdetail3'       => '',
            'imgcaption3'       => '',
            'imgstyle3'         => '',
            'not_image4'        => '',
            'imgtitle4'         => '',
            'imglink4'          => 0,
            'linkdetail4'       => '',
            'imgcaption4'       => '',
            'imgstyle4'         => '',
            'not_image5'        => '',
            'imgtitle5'         => '',
            'imglink5'          => 0,
            'linkdetail5'       => '',
            'imgcaption5'       => '',
            'imgstyle5'         => '',
            'not_image6'        => '',
            'imgtitle6'         => '',
            'imglink6'          => 0,
            'linkdetail6'       => '',
            'imgcaption6'       => '',
            'imgstyle6'         => '',
            'not_image7'        => '',
            'imgtitle7'         => '',
            'imglink7'          => 0,
            'linkdetail7'       => '',
            'imgcaption7'       => '',
            'imgstyle7'         => '',
            'not_image8'        => '',
            'imgtitle8'         => '',
            'imglink8'          => 0,
            'linkdetail8'       => '',
            'imgcaption8'       => '',
            'imgstyle8'         => '',
            'not_image9'        => '',
            'imgtitle9'         => '',
            'imglink9'          => 0,
            'linkdetail9'       => '',
            'imgcaption9'       => '',
            'imgstyle9'         => '',
            'not_image10'        => '',
            'imgtitle10'         => '',
            'imglink10'          => 0,
            'linkdetail10'       => '',
            'imgcaption10'       => '',
            'imgstyle10'         => '',
            'not_image11'        => '',
            'imgtitle11'         => '',
            'imglink11'          => 0,
            'linkdetail11'       => '',
            'imgcaption11'       => '',
            'imgstyle11'         => '',
            'not_image12'        => '',
            'imgtitle12'         => '',
            'imglink12'          => 0,
            'linkdetail12'       => '',
            'imgcaption12'       => '',
            'imgstyle12'         => '',
            'type_show'          => STYLE_SHOW_CONTENT_DEFAULT,
            'sho_id'             => 0,
            'not_hashtag'        => null,
        );
        
        // Lưu thông tin input
        foreach ($aData as $key => $oData) {
           if($this->input->post($key) != '') {
                $aData[$key] = $this->input->post($key);
           }
        }

        $aData['not_music'] = $this->_get_not_music($aData, '', $listFilesDelete, $listFilesSendFtp);

        if (!$this->input->post('personal')){
            if(!($my_shop = $this->shop_model->find_where(['sho_status' => ACTIVE, 'sho_user' => $iUserId], ['select' => 'sho_id, sho_user']))){
                $result['message']  = 'Gian hàng hoặc chi nhánh không tồn tại.';
                echo json_encode($result);
                die();
            }
            if(($sho_id = $this->input->post('sho_id')) && $my_shop['sho_id'] != $sho_id){
                if($group_id == AffiliateStoreUser && ($branch = $this->shop_model->has_branch($iUserId, $sho_id))){
                    $aData['sho_id']   = $branch['sho_id'];
                    $aData['not_user'] = $branch['sho_user'];
                }else{
                    $aData['sho_id'] = 0;
                }
            }
            if(!$aData['sho_id']){
                $aData['sho_id'] = $my_shop['sho_id'];
            }
            /*
             * check bài viết có đúng của doanh nghiệp doanh nghiệp.
             * case 1: đăng trên trang chủ => cá nhân
             * case 2: đăng trên trang doanh nghiệp => doanh nghiệp
             * case 3: đăng trên trang cá nhân => cá nhân. personal = 1
             *
            */
        }else {
            $my_shop['sho_id']  = 0;
            $aData['sho_id']    = 0;
        }

        $_POST['not_user'] = @$aData['not_user'];
        $_POST['sho_id']   = @$aData['sho_id'];

        $style_show_content = (int)$this->input->post('type_show');
        $aData['type_show'] =  $style_show_content && in_array($style_show_content, json_decode(STYLE_SHOW_CONTENT, true)) ? $style_show_content : STYLE_SHOW_CONTENT_DEFAULT;

        // Lưu icon
        if($this->input->post('list_icon') != '') {
            $list_icon = json_decode($this->input->post('list_icon'));
            foreach ($list_icon as $iKicon => $jIcon) {
                $oIconMain = json_decode($jIcon);
                $aData['not_additional'][$iKicon]  = array (
                    'icon'      => $oIconMain->icon,
                    'type'      => $oIconMain->icon_type,
                    'icon_url'  => $oIconMain->icon_url,
                    'posi'      => $oIconMain->position,
                    'effect'    => $oIconMain->effect,
                    'title'     => $oIconMain->title,
                    'desc'      => $oIconMain->desc
                );
            }
            $aData['not_additional'] = json_encode($aData['not_additional']);
            if($aData['not_additional'] === '""'){
                $aData['not_additional'] = null;
            }
        }

        if($this->input->post('relative_title') || $this->input->post('relative_content')) {
            $aCustomer = array(
                'cus_status'        => '1',
                'cus_title'         => 'KHÁCH HÀNG VIẾT VỀ CHÚNG TÔI',
                'cus_color'         => 'ffffff',
                'cus_background'    => '',
                'cus_type'          => 0,
                'cus_list'          => array()
            );

            $aCustomerDataInput = array(
                'cus_title'     => $this->filter->injection_html($this->input->post('relative_title')),
                'cus_background'=> $this->filter->injection_html(str_replace('#', '', $this->input->post('related_background'))),
                'cus_color'     => $this->filter->injection_html(str_replace('#', '', $this->input->post('related_color'))),
                'cus_type'     => $this->filter->injection_html($this->input->post('related_style')),
            );
            $aCustomer = array_merge($aCustomer,$aCustomerDataInput);
            $aCustomerItem    = json_decode($this->input->post('relative_content'));
            if(is_array($aCustomerItem) && !empty($aCustomerItem)) {
                foreach ($aCustomerItem as $key => $jCustomer) {
                    $oCustomer = json_decode($jCustomer);
                    $aCustomer['cus_list'][$key] = array(
                        'cus_avatar'    => $oCustomer->cus_avatar,
                        'cus_text1'     => $this->filter->injection_html($oCustomer->cus_text1),
                        'cus_text2'     => $this->filter->injection_html($oCustomer->cus_text2),
                        'cus_text3'     => $this->filter->injection_html($oCustomer->cus_text3),
                        'cus_facebook'  => $this->filter->injection_html(urlencode($oCustomer->cus_facebook)),
                        'cus_twitter'   => $this->filter->injection_html(urlencode($oCustomer->cus_twitter)),
                        'cus_google'    => $this->filter->injection_html(urlencode($oCustomer->cus_google)),
                        'cus_link'      => $this->filter->injection_html(urlencode($oCustomer->cus_link)),
                    );
                }
            }
            $aData['not_customer'] = json_encode($aCustomer);
        }

        // Tạo hình đại diện
        if($this->input->post('images') != '') {
            $aListImage = $this->input->post('images');
            $iCountImage = $this->input->post('have_image');
            if($iCountImage > 30){
                $result['message']  = 'Chỉ được nhập tối đa 30 hình';
                echo json_encode($result);
                die();
            }
            if($iCountImage != count($aListImage)) {
                $result['message']  = 'Vui lòng đợi hình!';
                echo json_encode($result);
                die();
            }

            $oImageNew = json_decode(reset($aListImage));
        }

        // Lưu Ads
        if($this->input->post('ads')) {

            $aAds = array();
            $oAds = json_decode($this->input->post('ads'));
            
            if(!empty($oAds)) {
                $aAds = array(
                    'ad_status' => '1',
                    'ad_image' => '',
                    'ad_link' => '',
                    'ad_content' => array(),
                    'ad_time' => '',
                    'ad_display' => '1',
                );

                // Lưu thông tin input
                foreach ($aAds as $key => $val) {
                    if($oAds->$key != '') {
                        $aAds[$key] = $this->filter->injection_html($oAds->$key);
                    }
                }
                
                // Lưu hình
                $aAds['ad_image'] = $oAds->image_name;
                if(!empty($oAds->ad_content)) {
                    foreach ($oAds->ad_content as $key => $oContent) {
                        $aAds['ad_content'][$key] = array(
                            'title'     => $oContent->title,
                            'desc'       => $oContent->desc,
                        );
                    }
                }
            }
            if(!empty($aAds)) {
                $aData['not_ad'] = json_encode($aAds);
            }
        }

        // Lưu thống kê
        if($this->input->post('static') != '') {
            $oStatic = json_decode($this->input->post('static'));
            $aData['not_statistic']     = 1;
            $aData['img_statistic']     = $oStatic->image_name;
            $aData['statistic']         = json_encode($oStatic->data_content);
        }

        //Save video
        if($this->input->post('not_video')){
            if($video = $this->content_library->saveVideo($_POST, null, $listFilesDelete, $listFilesSendFtp)){
                $aData['not_video_url1'] = $video['id'];
                if($video['processing'] == 1){
                    $aData['processing'] = 1;
                }
            }
        }

        $aData['not_hashtag'] = $this->content_library->saveHashTag($aData);

        if($this->input->post('not_image')) {
            $aData['not_image'] = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/'.$this->input->post('not_image');
        }else if(isset($oImageNew->image_url) && $oImageNew->image_url !='') {
            $aData['not_image'] = $oImageNew->image_url;
        }else if($aData['not_video_url1'] && !empty($video)){
            $aData['not_image'] = DOMAIN_CLOUDSERVER . $video['path'] . $video['thumbnail'];
        }

        if (($sNewsId = $this->content_model->add($aData))) {
            $aData['not_id'] = $sNewsId;
            if($this->input->post('not_customlink') != '') {
                $aLinkImage     = [];
                foreach ($this->input->post('not_customlink') as $iKeyLinkImg => $oLinkImg) {
                    $oLinkImg = json_decode($oLinkImg);
                    $aLinkImage[$oLinkImg->save_link] = $oLinkImg;
                    unset($oLinkImg);
                }
                
                foreach ($aLinkImage as $iKeyLinkImg => $oLink) {
                    if(($link_info = $this->link_library->add_if_not_exist($oLink->save_link))){
                        $this->content_link_model->add_new([
                            'link_id'       => $link_info['id'],
                            'user_id'       => $aData['not_user'],
                            'sho_id'        => (int)$aData['sho_id'],
                            'content_id'    => $sNewsId,
                            'is_public'     => 1,// chưa có
                            'created_at'    => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
            $this->_save_images_content($aListImage, $aData, $listFilesDelete, $listFilesSendFtp);

            if(!empty($listFilesSendFtp) || !empty($listFilesDelete)){
                $this->file_library->saveFilesOfArticle($listFilesSendFtp, $listFilesDelete, $aData['not_dir_image']);
            }

            //trigger tự update min_id, tbl_min, max_id,tbl_max tbtt_link: dùng cho trình duyệt
            if(($group_id == BranchUser) || (!empty($aData['sho_id']) && $my_shop['sho_id'] != $aData['sho_id'])){
                /*check current branch has config auto allow show post on walk store (auto allow = 52)*/
                if(($store = $this->shop_model->get_store_from_branch_id($aData['sho_id']))){
                    $this->load->model('branch_model');
                    if(($branch_rule = $this->branch_model->getConfig("*", "bran_id = " . (int)$aData['not_user']))){
                        if(gettype($branch_rule) == 'object' && ($branch_rule != new stdClass()) && $branch_rule->config_rule){
                            $rules = explode(',', $branch_rule->config_rule);
                            if($rules && is_array($rules) && in_array(52, $rules)){
                                $this->load->model('send_news_model');
                                $this->send_news_model->add_new([
                                    'not_id'        => (int) $sNewsId,
                                    'user_shop_id'  => $store['sho_user'],
                                    'created_at'    => date('Y-m-d H:i:s'),
                                    'updated_at'    => date('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    }
                }
            }

            /*send job optimize video*/
            if(!empty($video)){
                /*fix relation content 1-1 video */
                $this->videos_model->update_where(['content_id' => $aData['not_id']], ['id' => $aData['not_video_url1']]);
                if($video['processing'] == 1){
                    try{
                        $result = curl_data(SERVER_OPTIMIZE_URL.'otp-video', ['video_id' => $video['id']],'','','POST', $this->session->userdata('token'));
                        $result = @json_decode($result, true);
                        if($result && array_key_exists('error_code', $result) && $result['error_code'] == 0){
                            /*success*/
                        }else{
                            log_message('error', json_encode([$result]));
                        }
                    }catch (\Exception $e){
                        log_message('error', json_encode([$e]));
                    }
                }
            }

            $this->callAPI('GET', API_UPDATE_SEARCH_ARTICLE.$sNewsId);

            $result['message']  = 'Thêm bài viết thành công!';
            $result['type']     = 'success';
        }
        echo json_encode($result);
        die();
    }

    private function _get_not_music($request, $old_news, &$listFilesDelete, &$listFilesSendFtp)
    {
        if(!empty($request['not_music'])){
            $this->load->model('music_model');
            if($old_news && $old_news->not_music){
                if($old_news->not_music == $request['not_music']){
                    return $old_news->not_music;
                }
                if($old_news->not_music != $request['not_music']){
                    $listFilesDelete['audios'][] = $old_news->not_music;
                }
            }

            if(filter_var($request['not_music'], FILTER_VALIDATE_URL)) {
                $url = parse_url($request['not_music']);
                if(!empty($url['path']) && preg_match('/\.mp3$/i', $url['path'])){
                    return $request['not_music'];
                }
            }else if(preg_match('/\.mp3$/i', $request['not_music'])){
                if(!$this->music_model->find_audio_azibai($request['not_music']) && $this->file_library->checkTmpFileExist($request['not_music'])){
                    return $listFilesSendFtp['audios'][] = $request['not_music'];
                }else{
                    return $request['not_music'];
                }
            }
        }
        return null;
    }

    private function _save_images_content($aListImage, $aData, &$listFilesDelete, &$listFilesSendFtp )
    {
        if(empty($aData['not_id'])){
            return false;
        }
        $sNewsId = $aData['not_id'];

        if(!empty($aListImage)) {
            foreach ($aListImage as $key => $jImage) {
                $oImage = json_decode($jImage);
                $aImage = [
                    'name'      => $oImage->image_name,
                    'title'     => '',
                    'content'   => '',
                    'link'      => '',
                    'link_crop' => $oImage->image_crop,
                    'link_to'   => '',
                    'not_id'    => $sNewsId,
                    'user_id'   => $aData['not_user'],
                    'product_id'=> 0,
                    'style_show'=> '',
                    'animation' => 0,
                    'tags'      => property_exists($oImage,'tags') ? $oImage->tags : '',
                    'img_w'     => 0,
                    'img_h'     => 0,
                    'img_type'  => NULL
                ];

                // Lưu thông tin input
                foreach ($aImage as $key => $Image) {
                    if(property_exists($oImage, $key) && $oImage->{$key} != '') {
                        $aImage[$key] = $this->filter->injection_html($oImage->{$key});
                    }
                }

                $aImage['tags'] = property_exists($oImage, 'tags') ? strip_tags(json_encode($oImage->tags)) : '';

                if(isset($oImage->text_list) && !empty($oImage->text_list)) {
                    $aImage['style_show']['display'] = 1;
                    foreach ($oImage->text_list as $k => $oText) {
                        $aImage['style_show']['text_list'][$k] = $oText;
                    }
                }

                if(isset($oImage->show) && !empty($oImage->show)) {
                    $show = $oImage->show;

                    if(isset($show->backgroud_color) && $show->backgroud_color != '') {
                        $aImage['style_show']['background'] = $show->backgroud_color;
                    }

                    if(isset($show->backgroud_image) && $show->backgroud_image != '') {
                        $aImage['style_show']['background_image'] = $show->backgroud_image;
                    }

                    if(isset($show->color_text) && $show->color_text != '') {
                        $aImage['style_show']['color'] = $show->color_text;
                    }

                    if(isset($show->overlay_bg) && $show->overlay_bg != '') {
                        $aImage['style_show']['overlay_bg'] = $show->overlay_bg;
                    }

                    if(isset($show->type_show) && $show->type_show != '') {
                        $aImage['style_show']['type_show'] = $show->type_show;
                    }
                }

                if(isset($oImage->imgeffect) && $oImage->imgeffect != '') {
                    $aImage['style_show']['imgeffect'] = $oImage->imgeffect;
                }

                if(isset($oImage->texteffect) && $oImage->texteffect != '') {
                    $aImage['style_show']['texteffect'] = $oImage->texteffect;
                }

                //check đúng thì lưu ko thì thôi
                if(property_exists($oImage, 'audio') && $oImage->audio){
                    if(filter_var($oImage->audio, FILTER_VALIDATE_URL)) {
                        $url = parse_url($oImage->audio);
                        if(!empty($url['path']) && preg_match('/\.mp3$/i', $url['path'])){
                            $aImage['style_show']['audio'] = $oImage->audio;
                        }
                    }else if(preg_match('/\.mp3$/i', $oImage->audio)){
                        if(!$this->music_model->find_audio_azibai($oImage->audio) && $this->file_library->checkTmpFileExist($oImage->audio)){
                            $listFilesSendFtp['audios'][] = $aImage['style_show']['audio'] = $oImage->audio;
                        }else{
                            $aImage['style_show']['audio'] = $oImage->audio;
                        }
                    }else{
                        $aImage['style_show']['audio'] = null;
                    }
                }else{
                    $aImage['style_show']['audio'] = null;
                }

                if(isset($oImage->icon_list) && !empty($oImage->icon_list)) {
                    foreach ($oImage->icon_list as $k => $oIcon) {
                        $aImage['style_show']['caption2'][$k] =  array(
                            'icon'      => $oIcon->icon,
                            'icon_url'  => $oIcon->icon_url,
                            'type'      => $oIcon->icon_type,
                            'position'  => $oIcon->position,
                            'effect'    => $oIcon->effect,
                            'title'     => $oIcon->title,
                            'desc'      => $oIcon->desc,
                        );
                    }
                    $aImage['style_show']['caption2'] = $aImage['style_show']['caption2'];
                }

                if(isset($oImage->link_product) && !empty($oImage->link_product)) {
                    $oProduct = $oImage->link_product;
                    $aImage['product_id'] = $oProduct->pro_id;
                }

                $aImage['style_show'] = json_encode($aImage['style_show']);
                $iImage = $this->images_model->add($aImage);

                if($iImage){
                    if(property_exists($oImage, 'list_link') && $oImage->list_link) {
                        $aLinkImage = [];
                        foreach ($oImage->list_link as $oLinkImg) {
                            $aLinkImage[$oLinkImg->save_link] = $oLinkImg;
                            unset($oLinkImg);
                        }
                        foreach ($aLinkImage as $oLinkImg2) {
                            if($oLinkImg2->save_link){
                                if(($link_info = $this->link_library->add_if_not_exist($oLinkImg2->save_link))){
                                    $this->content_image_link_model->add_new([
                                        'link_id'           => $link_info['id'],
                                        'user_id'           => (int)$aData['not_user'],
                                        'sho_id'            => (int)$aData['sho_id'],
                                        'content_id'        => $sNewsId,
                                        'content_image_id'  => $iImage,
                                        'is_public'         => 1,// chưa có
                                        'created_at'        => date('Y-m-d H:i:s'),
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     ***************************************************************************
     * Created: 2018/10/08
     * Ajax get list produts
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getListProduct() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $iShopId = (int)$this->session->userdata('sessionUser');
        
        $sessionGroup = (int)$this->session->userdata('sessionGroup');

        if($sessionGroup == StaffStoreUser) {
            $oUser = $this->user_model->get("*","use_id = " . $sessionUser  . ' AND use_status = 1');
            
            $iShopId = $oUser->parent_id;
            
            if(!empty($oUser)) {
                $oShop = $this->user_model->get("*","use_id = " . $oUser->parent_id  . ' AND use_status = 1');
                if(!empty($oShop) && $oShop->use_group == 3) {
                    $iShopId = $oUser->parent_id;
                }
            }   
        }


        $products = $this->product_model->fetch("pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type", "pro_type IN (0,2) AND pro_status = 1 AND pro_user=" . $iShopId, "pro_type", "ASC", null, null);

        echo json_encode($products);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/11/07
     * Ajax get list icons
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *
     ***************************************************************************
    */

    public function getListIcons() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy icons thất bại!';
        $result['type']     = 'error';
        $result['data']     = '';
        $iCateId = $this->input->post('category_id');

        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $url = $this->config->item('api_get_icons');

        if($iCateId != '') {
            $url .= '?category_id='.$iCateId;
        }

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            foreach ($make_call['data']['list_icon'] as $iKeyI => $image) {
                $result['data'] .= '<div class="icon-item chooseimage" style="cursor:pointer;" data-image-url="'.$image['url'].'"
                     data-image="'.$image['name'].'" title="'.$image['name'].'" data-type="'.$image['type'].'">';
                    if($image['type'] == 'json') {
                        $result['data'] .= '<div class="image-json" id="image_json_'.$iKeyI.'"></div>';
                    }else {
                        $result['data'] .= '<img class="aicon img-responsive" src="' .$image['url'] . '"/>';
                    }
                $result['data'] .='</div>';

                if($image['type'] == 'json') {
                    $result['data'] .="<script>bodymovin.loadAnimation({
                      container: document.getElementById('image_json_".$iKeyI."'),
                      renderer: 'svg',
                      loop: true,
                      autoplay: true,
                      path: '".$image['url']."'
                    });</script>";
                }

            }

            $result['message']  = 'Lấy icons thành công';
            $result['type']     = 'success';
        }

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/10/08
     * Ajax get list produts
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getListCategoriesNews() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $cat_level = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cate_type = 2", "cat_service, cat_order, cat_id", "ASC");

        echo json_encode($cat_level);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/11/1
     * Ajax get list images
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getListImageSlider() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $this->load->helper('directory');
        $list_image = directory_map('./media/slides');
        $aListImage = array();
        foreach ($list_image as $key => $sImage) {
            $aListImage[$key] = array(
                'image_name'    => str_replace('.jpg', '', $sImage),
                'image_url'     => base_url().'media/slides/'.$sImage
            );
        }

        echo json_encode($aListImage);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/11/8
     * Page Preview
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function preView() {

        if(!$this->isLogin()){
            redirect($this->mainURL . 'page-not-found');
            die;
        }

        $data['user_login']  = MY_Loader::$static_data['hook_user'];

        if($data['user_login']['use_group'] == AffiliateStoreUser){
            $data['list_branches'] = $this->shop_model->branch_of_user($data['user_login']['use_id']);
            if(!empty($data['list_branches'])){
                foreach ($data['list_branches'] as $key_branch => $branch) {
                    $data['list_branches'][$key_branch]['logo_shop'] = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $branch['sho_dir_logo'] . '/' . $branch['sho_logo'];
                }
            }
        }

        $not_customlink = $this->input->post('not_customlink');

        if($this->input->post('not_title') != '') {
            $data['not_title'] = $this->input->post('not_title');
        }
        if($this->input->post('not_detail') != '') {
            $data['not_detail'] = $this->input->post('not_detail');
        }
        if($this->input->post('images') != '') {
            $data['images'] = $this->input->post('images');
        }
        if($not_customlink != '' && !empty($not_customlink)) {
            $data['not_customlink'] = $not_customlink;
        }
        if($not_video = $this->input->post('not_video')) {
            $data['not_video']          = (string)$not_video;
            $data['not_video_thumb']    = (string)$this->input->post('not_video_thumb');
            $data['have_video']         = (int)$this->input->post('have_video');
        }
        if($video_title = $this->input->post('video_title')) {
            $data['video_title'] = $video_title;
        }
        if($video_content = $this->input->post('video_content')) {
            $data['video_content'] = $video_content;
        }

        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $url = $this->config->item('api_get_icons');

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            $data['icons']  = $make_call['data']['list_icon'];
            $data['category_icons']  = $make_call['data']['category'];
        }


        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        $this->load->view('home/tintuc/preview', $data);
    }

    /**
     ***************************************************************************
     * Created: 2018/11/8
     * Page Preview
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function preViewPerson() {
        $not_customlink = $this->input->post('not_customlink');

        if($this->input->post('not_title') != '') {
            $data['not_title'] = $this->input->post('not_title');
        }
        if($this->input->post('not_detail') != '') {
            $data['not_detail'] = $this->input->post('not_detail');
        }
        if($this->input->post('images') != '') {
            $data['images'] = $this->input->post('images');
        }
        if($not_customlink != '' && !empty($not_customlink)) {
            $data['not_customlink'] = $not_customlink;
        }
        if($not_video = $this->input->post('not_video')) {
            $data['not_video']          = (string)$not_video;
            $data['not_video_thumb']    = (string)$this->input->post('not_video_thumb');
            $data['have_video']         = (int)$this->input->post('have_video');
        }
        if($video_title = $this->input->post('video_title')) {
            $data['video_title'] = $video_title;
        }
        if($video_content = $this->input->post('video_content')) {
            $data['video_content'] = $video_content;
        }

        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        $this->load->view('home/tintuc/preview_person', $data);
    }

    /**
     ***************************************************************************
     * Created: 2018/12/22
     * Edit News
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: view
     *  
     ***************************************************************************
    */

    public function updateNewsHome($item, $aData = array(), $iUserId = 0, $group_id = 0, $sessionUsername = '') {
        $this->load->model('images_model');
        $this->load->model('videos_model');
        $this->load->model('customlink_model');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library('link_library');
        $this->load->library('content_library');

        if (!$this->input->post('personal')){
            if(!($user_own_shop = $this->user_model->get_own_shop_or_branch($iUserId))){
                $result['message']  = 'Bạn không có quyền thêm bài viết.';
                echo json_encode($result);
                die();
            }

            if(!($my_shop = $this->shop_model->find_where(['sho_status' => ACTIVE, 'sho_user' => $user_own_shop], ['select' => 'sho_id, sho_user']))){
                $result['message']  = 'Gian hàng hoặc chi nhánh không tồn tại.';
                echo json_encode($result);
                die();
            }
        }

        // Check video hoặc hình hoặc customlink
        $check = 0;

        if($this->input->post('images')) {
            $check = 1;
        }

        if($this->input->post('not_video')) {
            $check = 1;
        }

        if($this->input->post('not_customlink')) {
            $check = 1;
        }

        if($check == 0) {
            $result['message'] = 'Vui lòng nhập ít nhất 1 tấm hình hoặc link liên kết hoặc video';
            echo json_encode($result);
            die();
        }

        if($this->input->post('images') != '') {
            $aListImage = $this->input->post('images');
            $iCountImage = $this->input->post('have_image');
            if($iCountImage != count($aListImage)) {
                $result['message']  = 'Vui lòng đợi hình!';
                echo json_encode($result);
                die();
            }
            foreach ($aListImage as $iKeyImage => $sImage) {
                $oImageNew = @json_decode($sImage);
                $aImageOld = $this->images_model->getwhere("*",'id = '.$oImageNew->image_id);
                if(!empty($aImageOld)) {
                    $this->updateImageNews($aImageOld, $oImageNew, $iUserId, $my_shop['sho_id'], $sessionUsername);
                } else {
                    $this->addImageNews($oImageNew, $item->not_id, $iUserId, $my_shop['sho_id'], $sessionUsername);
                }
            }
        }

        // Lưu thông tin input
        foreach ($item as $key => $oData) {
           if($this->input->post($key) != '') {
                if ($key == 'not_title') {
                    $aDataEdit[$key] = strip_tags($aData[$key]);
                }else {
                    $aDataEdit[$key] = $this->filter->injection_html($aData[$key]);
                }
           }
        }

        $aDataEdit['not_hashtag']   = $this->content_library->saveHashTag($aDataEdit);
        $aDataEdit['not_music']     = $this->_get_not_music($aData, $item, $listFilesDelete, $listFilesSendFtp);

        if(array_key_exists('type_show', $_POST)){
            $style_show_content     = (int)$this->input->post('type_show');
            $aDataEdit['type_show'] = $style_show_content && in_array($style_show_content, json_decode(STYLE_SHOW_CONTENT, true)) ? $style_show_content : STYLE_SHOW_CONTENT_DEFAULT;
        }

        //Save video
        if($item->not_video_url1 || $this->input->post('not_video') || $this->input->post('video_title') || $this->input->post('video_content')) {
            if($video = $this->content_library->saveVideo($_POST, $item->not_video_url1, $listFilesDelete, $listFilesSendFtp)){
                $aData['not_video_url1'] = $video['id'];
                if($video['processing'] == 1){
                    $aData['processing'] = 1;
                }
            }
        }

        // Lưu icon
        if($this->input->post('list_icon')) {
            $list_icon = json_decode($this->input->post('list_icon'));
            foreach ($list_icon as $iKicon => $jIcon) {
                if($jIcon != '') {
                    $oIconMain = json_decode($jIcon);
                    $aDataEdit['not_additional'][$iKicon]  = array (
                        'icon'      => $oIconMain->icon,
                        'icon_url'  => $oIconMain->icon_url,
                        'position'  => $oIconMain->position,
                        'effect'    => $oIconMain->effect,
                        'title'     => $oIconMain->title,
                        'desc'      => $oIconMain->desc
                    );
                }
                
            }
            $aDataEdit['not_additional'] = json_encode($aDataEdit['not_additional']);
        }

        // Lưu thống kê
        if($this->input->post('static')) {
            $oStatic = json_decode($this->input->post('static'));
            $aDataEdit['not_statistic']     = 1;
            $aDataEdit['img_statistic']     = $oStatic->image_name;
            $aDataEdit['statistic']         = json_encode($oStatic->data_content);
        }

        if($this->input->post('not_customlink') != '') {
            $aLinkContentNew  = array();
            foreach ($this->input->post('not_customlink') as $iKeyLinkImg => $oLinkImg) {
                $oLinkImg = json_decode($oLinkImg);
                if(!property_exists($oLinkImg, 'id')) {
                    $aLinkContentNew[$oLinkImg->save_link] = $oLinkImg;
                    unset($oLinkImg);
                }
            }

            if(!empty($aLinkContentNew)) {
                foreach ($aLinkContentNew as $iKeyLinkImg => $oLink) {
                    if(($link_info = $this->link_library->add_if_not_exist($oLink->save_link))){
                        $this->content_link_model->add_new([
                            'link_id'       => $link_info['id'],
                            'user_id'       => $item->not_user,
                            'sho_id'        => $item->sho_id,
                            'content_id'    => $item->not_id,
                            'is_public'     => 1,// chưa có
                            'created_at'    => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
            
        }

        // Lưu Ads
        if($this->input->post('ads')) {
            $aAds = array();
            $oAds = json_decode($this->input->post('ads'));
            if(!empty($oAds)) {
                $aAds = array(
                    'ad_status' => '1',
                    'ad_image' => '',
                    'ad_link' => '',
                    'ad_content' => array(),
                    'ad_time' => '',
                    'ad_display' => '1',
                );

                // Lưu thông tin input
                foreach ($aAds as $key => $val) {
                    if($oAds->$key != '') {
                        $aAds[$key] = $this->filter->injection_html($oAds->$key);
                    }
                }
                
                // Lưu hình
                $aAds['ad_image'] = $oAds->image_name;

                if(!empty($oAds->ad_content)) {
                    foreach ($oAds->ad_content as $key => $oContent) {
                        $aAds['ad_content'][$key] = array(
                            'title'     => $oContent->title,
                            'desc'       => $oContent->desc,
                        );
                    }
                }
            }

            if(!empty($aAds)) {
                $aDataEdit['not_ad'] = json_encode($aAds);
            }
        }

        // Lưu khách hàng nói về chúng tôi
        if($this->input->post('relative_title') || $this->input->post('relative_content')) {
            $aCustomer = array(
                'cus_status'        => '1',
                'cus_title'         => 'KHÁCH HÀNG VIẾT VỀ CHÚNG TÔI',
                'cus_color'         => 'ffffff',
                'cus_background'    => '',
                'cus_type'          => 0,
                'cus_list'          => array()
            );
       
            $aCustomerDataInput = array(
                'cus_title'     => $this->filter->injection_html($this->input->post('relative_title')),
                'cus_background'=> $this->filter->injection_html(str_replace('#', '', $this->input->post('related_background'))),
                'cus_color'     => $this->filter->injection_html(str_replace('#', '', $this->input->post('related_color'))),
                'cus_type'     => $this->filter->injection_html($this->input->post('related_style')),
            );
            $aCustomer = array_merge($aCustomer,$aCustomerDataInput);
            $aCustomerItem    = json_decode($this->input->post('relative_content'));
            if(is_array($aCustomerItem) && !empty($aCustomerItem)) {
                foreach ($aCustomerItem as $key => $jCustomer) {
                    $oCustomer = json_decode($jCustomer);

                    $aCustomer['cus_list'][$key] = array(
                        'cus_avatar'    => $oCustomer->cus_avatar,
                        'cus_text1'     => $this->filter->injection_html($oCustomer->cus_text1),
                        'cus_text2'     => $this->filter->injection_html($oCustomer->cus_text2),
                        'cus_text3'     => $this->filter->injection_html($oCustomer->cus_text3),
                        'cus_facebook'  => $this->filter->injection_html(urlencode($oCustomer->cus_facebook)),
                        'cus_twitter'   => $this->filter->injection_html(urlencode($oCustomer->cus_twitter)),
                        'cus_google'    => $this->filter->injection_html(urlencode($oCustomer->cus_google)),
                        'cus_link'      => $this->filter->injection_html(urlencode($oCustomer->cus_link)),
                    );
                }
            }
            $aDataEdit['not_customer'] = json_encode($aCustomer);
        }

        if($this->content_model->update($aDataEdit, 'not_id = ' . (int)$item->not_id)){
            $this->callAPI('GET', API_UPDATE_SEARCH_ARTICLE.$item->not_id);

            /*send job optimize video*/
            if(!empty($video)){
                /*fix relation content 1-1 video */
                if($video['processing'] == 1){
                    try{
                        $result = curl_data(SERVER_OPTIMIZE_URL.'otp-video', ['video_id' => $video['id']],'','','POST', $this->session->userdata('token'));
                        $result = @json_decode($result, true);
                        if($result && array_key_exists('error_code', $result) && $result['error_code'] == 0){
                            /*success*/
                        }else{
                            log_message('error', json_encode([$result]));
                        }
                    }catch (\Exception $e){
                        log_message('error', json_encode([$e]));
                    }
                }
            }

            return true;
        }
    }

    /**
     ***************************************************************************
     * Created: 2019/01/18
     * update Image News to Database
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: boolen
     *  
     ***************************************************************************
    */

    public function updateImageNews($aImageOld, $oImageNew, $iUserId, $iShopId, $sUserName) {
        $this->load->library('link_library');
        // Lưu thông tin input
        foreach ($aImageOld as $key => $Image) {
           if($oImageNew->{$key} != '') {
                $aImageOld[$key] = $this->filter->injection_html($oImageNew->{$key});
           }
        }
        if($oImageNew->tags != '' && $aImageOld['tags'] != 'null') {
            $aImageOld['tags'] = strip_tags(json_encode($oImageNew->tags));
        }
        if($aImageOld['style_show'] != '') {
            $aImageOld['style_show'] = (array) @json_decode($aImageOld['style_show']);
        }
        if(isset($oImageNew->text_list) && !empty($oImageNew->text_list)) {
            $aImageOld['style_show']['display'] = 1;
            if(isset($aImageOld['style_show']['text_list'])) {
                $aImageOld['style_show']['text_list'] = (array) $aImageOld['style_show']['text_list'];
            }
            foreach ($oImageNew->text_list as $k => $oText) {
                if($k == 'list_text_content') {
                    $aImageOld['style_show']['text_list'][$k] = (array) $oText;
                }else {
                    $aImageOld['style_show']['text_list'][$k] = $oText;
                }
            }
        }

        if(isset($oImageNew->show) && !empty($oImageNew->show)) {
            $show = $oImageNew->show;

            if(isset($show->backgroud_color) && $show->backgroud_color != '') {
                $aImageOld['style_show']['background'] = $show->backgroud_color;
            }

            if(isset($show->backgroud_image) && $show->backgroud_image != '') {
                
                $aImageOld['style_show']['background_image'] = $show->backgroud_image;
            }

            if(isset($show->color_text) && $show->color_text != '') {
                $aImageOld['style_show']['color'] = $show->color_text;
            }

            if(isset($show->overlay_bg) && $show->overlay_bg != '') {
                $aImageOld['style_show']['overlay_bg'] = $show->overlay_bg;
            }

            if(isset($show->type_show) && $show->type_show != '') {
                $aImageOld['style_show']['type_show'] = $show->type_show;
            }
        }

         if(isset($oImageNew->imgeffect) && $oImageNew->imgeffect != '') {
            $aImageOld['style_show']['imgeffect'] = $oImageNew->imgeffect;
        }

        if(isset($oImageNew->texteffect) && $oImageNew->texteffect != '') {
            $aImageOld['style_show']['texteffect'] = $oImageNew->texteffect;
        }

        if(isset($oImageNew->audio) && $oImageNew->audio != '') {
            $aImageOld['style_show']['audio'] = $oImageNew->audio;
        }
        
        if(isset($oImageNew->icon_list) && !empty($oImageNew->icon_list)) {

            foreach ($oImageNew->icon_list as $k => $oIcon) {
                $aImageOld['style_show']['caption2'][$k] =  array(
                    'icon'      => $oIcon->icon,
                    'icon_url'  => $oIcon->icon_url,
                    'position'  => $oIcon->position,
                    'effect'    => $oIcon->effect,
                    'title'     => $oIcon->title,
                    'desc'      => $oIcon->desc,
                );
            }
            $aImageOld['style_show']['caption2'] = $aImageOld['style_show']['caption2'];
        }

        if(isset($oImageNew->link_product) && !empty($oImageNew->link_product)) {
            $oProduct = $oImageNew->link_product;
            $aImageOld['product_id'] = $oProduct->pro_id;
        }
        
        $aImageOld['style_show'] = json_encode($aImageOld['style_show']);

        if($oImageNew->list_link != '') {
            $aLinkContentNew  = array();

            foreach ($oImageNew->list_link as $iKeyLinkImg => $oLinkImg) {
                if(!property_exists($oLinkImg, 'id')){
                    $aLinkContentNew[$oLinkImg->save_link] = $oLinkImg;
                }
                unset($oLinkImg);
            }

            if(!empty($aLinkContentNew)) {
                foreach ($aLinkContentNew as $iKeyLinkImg => $oLinkImg) {
                    $link_info = $this->link_library->add_if_not_exist($oLinkImg->save_link);
                    if($link_info) {
                        $this->content_image_link_model->add_new([
                            'link_id'           => $link_info['id'],
                            'user_id'           => (int)$iUserId,
                            'sho_id'            => (int)$iShopId,
                            'content_id'        => $aImageOld['not_id'],
                            'content_image_id'  => $aImageOld['id'],
                            'is_public'         => 1,// chưa có
                            'created_at'        => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
        }
        
        // Update image
        $this->images_model->update($aImageOld, 'id = ' . (int)$aImageOld['id']);
        
    }

    /**
     ***************************************************************************
     * Created: 2019/01/18
     * add Image News to Database
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: boolen
     *  
     ***************************************************************************
    */

    public function addImageNews($oImage, $iNewsId, $iUserId, $iShopId, $sUserName) {

        $this->load->model('images_model');
        $this->load->model('customlink_model');

        $aImage = array(
            'name'      => $oImage->image_name,
            'title'     => '',
            'content'   => '',
            'link'      => '',
            'link_crop' => $oImage->image_crop,
            'link_to'   => '',
            'not_id'    => $iNewsId,
            'user_id'   => $iUserId,
            'product_id'=> 0,
            'style_show'=> '',
            'animation' => 0,
            'tags'      => $oImage->tags,
            'img_w'     => 0,
            'img_h'     => 0,
            'img_type'  => NULL
        );
        // Lưu thông tin input
        foreach ($aImage as $key => $Image) {
           if($oImage->$key != '') {
                $aImage[$key] = $this->filter->injection_html($oImage->$key);
           }
        }

        $aImage['tags'] = strip_tags(json_encode($oImage->tags));

        if(isset($oImage->text_list) && !empty($oImage->text_list)) {
            $aImage['style_show']['display'] = 1;
            foreach ($oImage->text_list as $k => $oText) {
                $aImage['style_show']['text_list'][$k] = $oText;
            }
        }
        
        if(isset($oImage->show) && !empty($oImage->show)) {
            $show = $oImage->show;

            if(isset($show->backgroud_color) && $show->backgroud_color != '') {
                $aImage['style_show']['background'] = $show->backgroud_color;
            }

            if(isset($show->backgroud_image) && $show->backgroud_image != '') {
                
                $aImage['style_show']['background_image'] = $show->backgroud_image;
            }

            if(isset($show->color_text) && $show->color_text != '') {
                $aImage['style_show']['color'] = $show->color_text;
            }

            if(isset($show->overlay_bg) && $show->overlay_bg != '') {
                $aImage['style_show']['overlay_bg'] = $show->overlay_bg;
            }

            if(isset($show->type_show) && $show->type_show != '') {
                $aImage['style_show']['type_show'] = $show->type_show;
            }
        }

        if(isset($oImage->imgeffect) && $oImage->imgeffect != '') {
            $aImage['style_show']['imgeffect'] = $oImage->imgeffect;
        }

        if(isset($oImage->texteffect) && $oImage->texteffect != '') {
            $aImage['style_show']['texteffect'] = $oImage->texteffect;
        }

        if(isset($oImage->audio) && $oImage->audio != '') {
            $aImage['style_show']['audio'] = $oImage->audio;
        }
        
        if(isset($oImage->icon_list) && !empty($oImage->icon_list)) {

            foreach ($oImage->icon_list as $k => $oIcon) {
                $aImage['style_show']['caption2'][$k] =  array(
                    'icon'      => $oIcon->icon,
                    'icon_url'  => $oIcon->icon_url,
                    'position'  => $oIcon->position,
                    'effect'    => $oIcon->effect,
                    'title'     => $oIcon->title,
                    'desc'      => $oIcon->desc,
                );
            }
            $aImage['style_show']['caption2'] = $aImage['style_show']['caption2'];
        }

        if(isset($oImage->link_product) && !empty($oImage->link_product)) {
            $oProduct = $oImage->link_product;
            $aImage['product_id'] = $oProduct->pro_id;
        }

        $aImage['style_show'] = json_encode($aImage['style_show']);

        $iImage = $this->images_model->add($aImage);

        if($iImage){
            if($oImage->list_link != '') {
                $aLinkImage = array();
                foreach ($oImage->list_link as $iKeyLinkImg => $oLinkImg) {
                    $aLinkImage[$oLinkImg->save_link] = $oLinkImg;
                    unset($oLinkImg);
                }
                foreach ($aLinkImage as $iKeyLinkImg => $oLinkImg) {
                    $aLink = array(
                        'type_id'       => $iImage,
                        'type'          => 'image',
                        'user_id'       => $iUserId,
                        'sho_id'        => $iShopId,
                        'title'         => $oLinkImg->title,
                        'description'   => $oLinkImg->description,
                        'image'         => $oLinkImg->image,
                        'save_link'     => $oLinkImg->save_link,
                        'host'          => $oLinkImg->host,
                    );
                    $this->customlink_model->add($aLink);
                }
            } 
        }

        return true;
    }

    /**
     ***************************************************************************
     * Created: 2018/12/22
     * Page Edit News
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: view
     *  
     ***************************************************************************
    */

    public function editNewsHome($not_id)
    {
        $data = array();
        $this->load->model('images_model');
        $select = "a.*, b.cat_name, p.name as not_permission_name, s.sho_name, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_banner, s.sho_dir_banner, s.sho_mobile, s.sho_phone, s.sho_facebook, s.domain, s.sho_user, s.sho_email";
        $where  = "a.not_status = 1 AND a.id_category = 16 AND a.not_publish = 1 AND a.not_id = " . $not_id;

        $sessionUser      = (int)$this->session->userdata('sessionUser');
        $sessionGroup     = (int)$this->session->userdata('sessionGroup');
        $sessionUsername  = $this->session->userdata('sessionUsername');
        $where_permission = ' AND not_permission = 1';
        if( $sessionUser ) { // neu co mot user dang nhap vao
            $shopID = $this->get_shop_in_tree($sessionUser);
            $shopID = $shopID != 0 ? $shopID : $sessionUser;
            $shop_near = $this->get_shop_nearest($sessionUser);
            $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
            if( $sessionGroup == 2) {
                $aaaa = ' AND (not_permission IN (1,2,4) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .')))';
            } else {
                $aaaa = ' AND (not_permission IN (1,2,3) OR (( not_permission = 5 AND ( not_user = '. $shopID .' OR not_user = '. $shop_near .')) OR ( not_permission = 6 AND not_user = '. $sessionUser .') OR ( not_permission = 4 AND ( not_user = '. $sessionUser .' OR not_user = '. $shop_near .'))))';
            }
            $where_permission = $aaaa;
        }
        
        $where .= $where_permission;
        
        $sql2 = 'SELECT ' . $select . ' FROM tbtt_content AS a '
                . 'LEFT JOIN tbtt_category AS b ON a.not_pro_cat_id = b.cat_id '
                . 'LEFT JOIN tbtt_shop AS s ON a.not_user = s.sho_user '
                . 'LEFT JOIN tbtt_permission AS p ON p.id = a.not_permission '
                . 'WHERE ' . $where;

        $query = $this->db->query($sql2);
        $item  = $query->row();

        if(!$item){
            redirect(base_url(), 'location');
        }
        if($sessionUser != $item->not_user) {
            redirect(base_url(), 'location');
        }

        $this->load->model('videos_model');
        $this->load->model('customlink_model');
        $this->load->model('category_link_model');
        $this->load->model('content_link_model');
        $this->load->model('content_image_link_model');
        $this->load->library('link_library');

        //user đang login cũng là chủ bài viết.
        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $data['is_owner']   = true;

        if(!empty($data['user_login'])){
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        if($this->input->post('action')) {
            $this->updateNewsHome($item, $_POST, $sessionUser,$sessionGroup, $sessionUsername);
            $result['message']  = 'Cập nhật bài viết thành công!';
            $result['type']     = 'success';
            echo json_encode($result);
            die();
        }

        $data['item'] = $item;
        $data['sLinkFolderImage'] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/';
        $aListImageTemp = $this->images_model->get("*",'not_id = '.$item->not_id);

        if(!empty($aListImageTemp)) {
            foreach ($aListImageTemp as $iKeyImage => $oImage) {
                $image_customlink = $this->content_image_link_model->link_of_news($item->not_id, $oImage->id, 0, $data['is_owner'], 'ASC');
                $aStyleShow     = (json_decode($oImage->style_show));
                $product = $this->product_model->get("*","pro_id = ".(int) $oImage->product_id);
                $aProduct = array();
                if(!empty($product)) {
                    $aProduct = array(
                        'pro_id'    => $product->pro_id,
                        'pro_name'  => $product->pro_name
                    );
                }
                
                $aListImage[] = (object) array(
                    'image_id'      => $oImage->id,
                    'title'         => $oImage->title,
                    'content'       => $oImage->content,
                    'image_name'    => $oImage->name,
                    'image_title'   => ($oImage->title != '') ? $oImage->title : $oImage->name,
                    'image_url'     => $data['sLinkFolderImage'].$oImage->name,
                    'link_product'  => $aProduct,
                    'link'          => $oImage->link,
                    'tags'          => json_decode($oImage->tags),
                    'icon_list'     => isset($aStyleShow->caption2) ? $aStyleShow->caption2 : array(),
                    'text_list'     => isset($aStyleShow->text_list) ? $aStyleShow->text_list : array(),
                    'show'          => array(
                        'type_show'         => isset($aStyleShow->type_show) ? $aStyleShow->type_show : '',
                        'backgroud_image'   => isset($aStyleShow->backgroud_image) ? $aStyleShow->backgroud_image : '',
                        'backgroud_color'   => isset($aStyleShow->background) ? $aStyleShow->background : '',
                        'color_text'        => isset($aStyleShow->color) ? $aStyleShow->color : '',
                        'overlay_bg'        => isset($aStyleShow->overlay_bg) ? $aStyleShow->overlay_bg : 0.5
                    ),
                    'list_link' => $image_customlink
                );
            }
        }

        if($item->not_video_url1){
            $data['video'] = $this->videos_model->find_where(['id' => $item->not_video_url1]);
        }

        $data['not_customlink'] = $this->content_link_model->link_of_news($item->not_id, 0, $data['is_owner'], 'DESC');
        $data['aListImage'] = $aListImage;
        $data['url'] = current_url();
        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
        $data['token'] = $this->session->userdata('token');

        if($item->sho_id == 0) {
            $data['domain_use'] = @$data['user_login']['profile_url'];
            $this->load->view('home/tintuc/edit_new_person', $data);
        }else {
            $data['domain_use'] = @$data['user_login']['my_shop']['shop_url'];
            // Tin nổi bật
            $data['not_additional'] = json_decode($item->not_additional);
            // Thống kê
            if($item->not_statistic == 1) {
                $data['statistic'] = array(
                    'image'     => $data['sLinkFolderImage'].$item->img_statistic,
                    'image_name'=> $item->img_statistic,
                    'aStatic'   => (array) json_decode($item->statistic)
                );
            }

            // Quảng cáo
            if($item->not_ad != '') {
                $data['not_ad'] = json_decode($item->not_ad);
            }

            if($item->not_customer != '') {
                $data['not_customer'] = json_decode($item->not_customer);
            }
            $this->load->view('home/tintuc/edit_new_home', $data);
        }

    }

    /**
     ***************************************************************************
     * Created: 2018/11/12
     * Ajax get infomation link
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getLinkInfomation() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $sLink = $this->input->post('link');

        if (!filter_var($sLink, FILTER_VALIDATE_URL)) {
            $sLink = 'http://'.$sLink;
        }

        $urlData = parse_url($sLink);
        
        $aMeta =  getUrlMeta($sLink);
        
        $aMeta['host'] = str_replace('www.', '', $urlData['host']);
    
        echo json_encode($aMeta);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/11/1
     * Ajax get list effect slider
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getListEffectSlider() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $aListEffects_Temp = array("flip|DepthPage","fade|Fade","shift|FlipHorizontal","page|FlipPage","rotate|RotateUp","stack|Stack","basic|Tablet","kenburns|ZoomIn");
        foreach ($aListEffects_Temp as $key => $value) {
            $aListEffects[$key] = array(
                'value' => explode("|", $value)[0],
                'name'  =>  explode("|", $value)[1]
            );
        }
        echo json_encode($aListEffects);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/11/1
     * Ajax get list audio
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getListAudioSlider() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $this->load->helper('directory');
        $aListMusics = directory_map('./media/musics');

        echo json_encode($aListMusics);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2018/11/1
     * Ajax get list detail image 
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: json
     * Lưu ý: bài viết có sho_id => bài viết doanh nghiệp, bài viết chỉ có not_user => bài viết cá nhân
     ***************************************************************************
    */
    public function getDetailImg() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $not_id = (int)$this->input->post('new_id');
        $key_id = (int)$this->input->post('key_id');
//        $select = "a.*, s.sho_name, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_banner, s.sho_dir_banner, s.sho_mobile, s.sho_phone, s.sho_facebook, s.domain, s.sho_user, s.sho_email";
        $select = "a.*";
        $where  = "a.not_status = 1 AND  a.not_publish = 1 AND a.not_id = " . $not_id;
        $sql2   = 'SELECT ' . $select . ' FROM tbtt_content AS a '
//                . 'LEFT JOIN tbtt_shop AS s ON a.not_user = s.sho_user '
                . 'WHERE ' . $where;
        $query = $this->db->query($sql2);
        $item  = $query->row();

        $data = array(
            'listImg' => '',
            'info'    => '',
        );
        $azibai_url = azibai_url();

        if (!empty($item)) {
            $logo = site_url('templates/home/images/no-logo.jpg');
            if($item->sho_id){
                $shop = $this->shop_model->find_where([
                    'sho_status'    => 1,
                    'sho_id'        => $item->sho_id
                ],
                    ['select'  => 'sho_name, sho_link, sho_logo, sho_dir_logo, sho_banner, sho_dir_banner, sho_mobile, sho_phone, sho_facebook, domain, sho_user, sho_email'],
                    'object'
                );

                if(!empty($shop)){
                    if ($shop->sho_logo) {
                        $logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                    }

                    $data['info'] = array(
                        'name'          => $shop->sho_name,
                        'created'       => date("d/m/Y", $item->not_begindate),
                        'not_id'        => $item->not_id,
                        'avatar'        => $logo,
                        'path_img'      => DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/',
                        'type_post'     => $item->not_posted_by,
                        'is_shop' => 1
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

                    $data['info'] = array(
                        'name'          => $user->use_fullname,
                        'created'       => date("d/m/Y", $item->not_begindate),
                        'not_id'        => $item->not_id,
                        'avatar'        => $logo,
                        'path_img'      => DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/',
                        'type_post'     => $item->not_posted_by
                    );
                }
            }

            $array = array();
            $this->load->model('images_model');
            $aListImage = $this->images_model->get("*",'not_id = '.$item->not_id);

            if(!empty($aListImage)) {
                foreach ($aListImage as $key => $oImage) {
                    $array[$key] = array(
                        $oImage->name,
                        $oImage->product_id,
                        $oImage->title,
                        $oImage->link,
                        $oImage->content,
                        $oImage->style_show,
                        $oImage->link_to,
                        $oImage->tags,
                        $oImage->id,
                        $oImage->img_w,
                        $oImage->img_h,
                        $oImage->img_type,
                    );
                }
            }
            
            $listImg = array();

            if (!empty($this->input->post('info_video'))) {
                $info_video = $this->input->post('info_video');
                $listImg[0]->id = $info_video['id'];
                $listImg[0]->link = $info_video['link'];
                $listImg[0]->shop_link = $info_video['shop_link'];
                $listImg[0]->image_size = array('width' => $info_video['clientWidth'], 'height' => $info_video['clientHeight']);
                $listImg[0]->type = 'video';
            }

            foreach ($array as $k => $value) {
                if (!empty($this->input->post('info_video'))) {
                    $key = $k + 1;
                } else {
                    $key = $k;
                }
                if (strlen($value[0]) > 10) {

                    $listImg[$key]->image = $value[0];
                    if ($value[1] > 0) {
                        $product = $this->product_model->get("pro_category, pro_user, is_product_affiliate, pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir, end_date_sale, af_amt, (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int) $value[1]);
                        if (!empty($product)) {
                           $listImg[$key]->product = $product;
                           $listImg[$key]->pro_link =  $azibai_url . '/'. $product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name);
                          
                        }
                    }

                    $listImg[$key]->id = $value[8];
                    $listImg[$key]->title = $value[2];
                    $listImg[$key]->detail = $value[3];
                    $listImg[$key]->caption = html_entity_decode(htmlspecialchars_decode($value[4]));
                    $listImg[$key]->style = $value[5];
                    $listImg[$key]->link_to = json_decode($value[6]);
                    $listImg[$key]->tags    = json_decode($value[7]);
                    $listImg[$key]->icon_caption = '';
                    $listImg[$key]->type = 'img';

                    if (!empty($value[9]) && !empty($value[10])) {
                       $listImg[$key]->image_size = array('width' => $value[9], 'height' => $value[10]); 
                    } else {
                        list($width, $height) = getimagesize(DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/1x1_' . $listImg[$k]->image);
                        $listImg[$key]->image_size = array('width' => $width, 'height' => $height);
                    }
                    if(!empty($value[5])) {
                        $oImageOption = json_decode($value[5]);
                        if(isset($oImageOption->caption2)) {
                            $aListIconImage = json_decode($oImageOption->caption2);
                            $listImg[$key]->icon_caption = $this->load->view('home/tintuc/elements/icon-position',array('icons_position' => $aListIconImage), TRUE);
                        }
                    }

                }
            }
            $data['item'] = $item;
            $data['listImg'] = $listImg;
        }
        echo json_encode($data);
        die();
    }

    public function runImg() {
        $this->load->model('images_model');

        $select = "a.*, s.not_id, s.not_dir_image";
        $sql2 = 'SELECT ' . $select . ' FROM tbtt_images  AS a '
                . 'LEFT JOIN tbtt_content AS s ON a.not_id = s.not_id WHERE a.img_h = 0';
        $query = $this->db->query($sql2);
        $item  = $query->result_array();
        foreach ($item as $key => $value) {
            $type =  getimagesize(DOMAIN_CLOUDSERVER . 'media/images/content/' . $value['not_dir_image'] .'/' . $value['name']);
            if (!empty($type)) {
                $query = 'UPDATE tbtt_images SET  img_w = '. $type['0'] .', img_h = '.$type['1'].', img_type = "' . $type['mime'] .'" WHERE id = ' . $value['id'];
                $this->db->query($query);
            } else {
                echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $value['not_dir_image'] .'/' . $value['name'];
            }
        }
        echo 'xong';
        die;
    }

    // public function quick_view($not_id = 0)
    // {
    //     $this->load->model('images_model');
    //     $this->load->model('customlink_model');
    //     $url_par =  $this->uri->segment(2);
    //     $data['content'] = $this->content_model->get('*',"not_id = $not_id");
    //     $shop_id = $data['content']->sho_id;
    //     $data['shop'] = $this->shop_model->get('domain,sho_link',"sho_id = $shop_id");
    //     $data['view_detect'] = $url_par;

    //     if($url_par == 'link'){
    //         //lấy id image được gắn link gắn trong hình
    //         $arr_image_keys = $this->images_model->get('id',"not_id = $not_id");
    //         if(!empty($arr_image_keys)){
    //             foreach ($arr_image_keys as $key => $value) {
    //                 $arr_image_keys[$key] = $value->id;
    //             }
    //             $arr_image_keys = implode(',',$arr_image_keys);
    //             //lấy data link bài viết và trong hình
    //             $data['arr_links'] = $this->customlink_model->get('*',"(type_id = $not_id AND type = 'content') OR (type_id IN ($arr_image_keys) AND type = 'image')");
    //         }
    //     }

    //     if($url_par == 'product'){
    //         //lấy pro_id trong tag + trong image
    //         $img_result = $this->images_model->get('product_id, tags',"not_id = $not_id AND product_id != 0");
    //         $arr_image_keys = [];
    //         if(!empty($img_result)){
    //             foreach ($img_result as $key => $value) {
    //                 array_push($arr_image_keys,$value->product_id);
    //                 $a = json_decode($value->tags);
    //                 foreach ($a as $k => $v) {
    //                     $arr_image_keys = array_merge($arr_image_keys,$v->list_pro);
    //                 }
    //             }
    //             $arr_image_keys = implode(',',$arr_image_keys);
    //             //lấy data product trong tag + trong image
    //             $data['arr_products'] = $this->product_model->fetch($select = '*',$where = "pro_id IN ($arr_image_keys)", $order = "created_date", $by = "DESC", $start = -1, $limit = 0);
    //         }
    //     }

    //     $this->load->view('home/tintuc/quick-view/layout-main', $data);
    // }

    public function quick_view($not_id = 0)
    {
        $this->load->model('images_model');
        $this->load->model('customlink_model');

        $data['content'] = $this->content_model->get('*',"not_id = $not_id");

        if($data['content']->sho_id > 0){
            $data['shop'] = $this->shop_model->get('domain,sho_link','sho_id = ' . $data['content']->sho_id);
        }else{
            $data['shop'] = $this->shop_model->get('domain,sho_link','sho_user = ' . $data['content']->not_user);
        }

        // $data['view_detect'] = $url_par;

        //lấy id image được gắn link gắn trong hình
        $arr_image_keys = $this->images_model->get('id',"not_id = $not_id");
        if(!empty($arr_image_keys)){
            foreach ($arr_image_keys as $key => $value) {
                $arr_image_keys[$key] = $value->id;
            }
            $arr_image_keys = implode(',',$arr_image_keys);
            //lấy data link bài viết và trong hình
            $data['arr_links'] = $this->customlink_model->get('*',"(type_id = $not_id AND type = 'content') OR (type_id IN ($arr_image_keys) AND type = 'image')");
        }

        $arr_image_keys = [];
        //lấy pro_id trong tag + trong image
        $img_result = $this->images_model->get('product_id, tags',"not_id = $not_id");
        if(!empty($img_result)){
            foreach ($img_result as $key => $value) {
                array_push($arr_image_keys,$value->product_id);
                $a = json_decode($value->tags);
                if(gettype($a) == 'string'){
                    $a = json_decode($a);
                }
                foreach ($a as $k => $v) {
                    foreach ($v->list_pro as $k1 => $v1) {
                        array_push($arr_image_keys,$v1);
                    }
                }
            }
        }

        $arr_image_keys = implode(',',$arr_image_keys);
        if(!empty($arr_image_keys)){
            //lấy data product trong tag + trong image
            $data['arr_products'] = $this->product_model->fetch($select = '*',$where = "pro_id IN ($arr_image_keys)", $order = "created_date", $by = "DESC", $start = -1, $limit = 0);
        }

        $this->load->view('home/tintuc/quick-view/layout-main', $data);
    }

    // public function check_quick_view($not_id = 0)
    // {
    //     $this->load->model('images_model');
    //     $this->load->model('customlink_model');

    //     $return = [];
    //     //lấy id image được gắn link gắn trong hình
    //     $arr_image_keys = $this->images_model->get('id',"not_id = $not_id");
    //     if(!empty($arr_image_keys)){
    //         foreach ($arr_image_keys as $key => $value) {
    //             $arr_image_keys[$key] = $value->id;
    //         }
    //         $arr_image_keys = implode(',',$arr_image_keys);
    //         //lấy data link bài viết và trong hình
    //         $result = $this->customlink_model->get('*',"(type_id = $not_id AND type = 'content') OR (type_id IN ($arr_image_keys) AND type = 'image')");
    //         if(!empty($result)){
    //             $return['link'] = true;
    //         } else {
    //             $return['link'] = false;
    //         }
    //     }

    //     //lấy pro_id trong tag + trong image
    //     $img_result = $this->images_model->get('product_id, tags',"not_id = $not_id AND product_id != 0");
    //     $arr_image_keys = [];
    //     if(!empty($img_result)){
    //         foreach ($img_result as $key => $value) {
    //             array_push($arr_image_keys,$value->product_id);
    //             $a = json_decode($value->tags);
    //             foreach ($a as $k => $v) {
    //                 $arr_image_keys = array_merge($arr_image_keys,$v->list_pro);
    //             }
    //         }
    //         $arr_image_keys = implode(',',$arr_image_keys);
    //         //lấy data product trong tag + trong image
    //         $result = $this->product_model->fetch($select = '*',$where = "pro_id IN ($arr_image_keys)", $order = "created_date", $by = "DESC", $start = -1, $limit = 0);
    //         if(!empty($result)){
    //             $return['product'] = true;
    //         } else {
    //             $return['product'] = false;
    //         }
    //     }

    //     return $return;
    // }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax add image not thumb
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function addImageNotThumb() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Thêm hình thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $this->load->library('image_lib');
        $this->load->library('upload');

        #Create folder
        $pathImage = 'media/images/content/';
        $path = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');

        if($this->input->post('dir') != '' && $this->input->post('dir') != 'null') {
            $dir = $this->input->post('dir');
        }else {
            $dir = date('dmY');
        }
        
        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
       
        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (! in_array($dir, $ldir)) {                    
            $this->ftp->mkdir($path . '/' . $dir, 0775);
        }
        // Up hình crop
        if(isset($_FILES['images']) && !empty($_FILES['images'])){
            $fImage     = $_FILES['images'];
            if($fImage['size'] > 5242880) {
                $result['message']  = 'Hình ảnh '.$fImage['name'].' quá lớn!';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            $sType = checkExtensionImage($fImage['type']);

            if($sType == '') {
                $result['message']  = 'Hình ảnh '.$fImage['name'].' có định đạng không được phép';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            $sImageName = uniqid().time().uniqid().$sType;
    
            $this->ftp->upload($fImage['tmp_name'],$path .'/'. $dir .'/'.$sImageName,0755);
                $result['message']          = 'Thêm hình thành công!';
                $result['type']             = 'success';
                $result['image_name']       = $sImageName;
                $result['path']             = $dir;
                $result['image_url']        = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/'.$sImageName;
            
        }
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax add image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function addImage() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Thêm hình thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = TRUE;
        $this->ftp->connect($config);
        $this->load->library('image_lib');
        $this->load->library('upload');

        #Create folder
        $pathImage = 'media/images/content/';
        $path = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');
        if($this->input->post('dir') != '' && $this->input->post('dir') != 'null') {
            $dir = $this->input->post('dir');
        }else {
            $dir = date('dmY');
        }

        // Upload to other server cloud
        $ldir = array();
  
        $ldir = $this->ftp->list_files($path);

        // if $my_dir name exists in array returned by nlist in current '.' dir
   
        if (! in_array($dir, $ldir)) {           
            $this->ftp->mkdir($path . '/' . $dir, 0775);
        }
        if (!is_dir($pathImage . $dir_image)) {
            @mkdir($pathImage . $dir_image, 0775);
            $this->load->helper('file');
            @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
        }
        // Up hình không có crop
        if(isset($_FILES['images']) && !empty($_FILES['images'])){
            $fImage     = $_FILES['images'];
            if($fImage['size'] > 5242880) {
                $result['message']  = 'Hình ảnh '.$fImage['name'].' quá lớn!';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }
            // $sImageName = uniqid().time().uniqid();
            // $sType      = '.jpeg';

            $config['upload_path'] = $pathImage . $dir_image . '/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 5120;#KB
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('images')) {
                $uploadData = $this->upload->data();
               
                //* Create thumbnail 1:1 */
                $configCrop['source_image'] = $pathImage . $dir_image . '/' . $uploadData['file_name'];
                $configCrop['new_image'] = $pathImage . $dir_image .'/1x1_' . $uploadData['file_name'];
                
                $configCrop['maintain_ratio'] = FALSE;
                $size = getimagesize($pathImage . $dir_image . '/' . $uploadData['file_name']);
                
                if (!empty($size)) {
                    $result['img_w']       = $size[0];
                    $result['img_h']       = $size[1];
                    $result['img_type']    = $size['mime'];
                }

                $w = $size[0];
                $h = $size[1];

                if($w > $h) {
                    $configCrop['width'] = $h;
                    $configCrop['height'] = $h;
                    $configCrop['x_axis'] = $w/2 - $h/2;
                    $configCrop['y_axis'] = 0;
                }
                if($w < $h) {
                    $configCrop['width'] = $w;
                    $configCrop['height'] = $w;
                    $configCrop['x_axis'] = 0;
                    $configCrop['y_axis'] = $h/2 - $w/2;
                }
                if($w == $h) {
                    $configCrop['width'] = $w;
                    $configCrop['height'] = $h;
                    $configCrop['x_axis'] = 0;
                    $configCrop['y_axis'] = 0;
                }
                            
                $this->image_lib->initialize($configCrop);
                $this->image_lib->crop();
                $this->image_lib->clear();

                if(file_exists($pathImage . $dir_image .'/1x1_'. $uploadData['file_name'])){
                    $this->ftp->upload($pathImage . $dir_image .'/1x1_'. $uploadData['file_name'], $path .'/'. $dir .'/1x1_'. $uploadData['file_name'], 'auto', 0775);
                    array_map('unlink', glob('media/images/content/'. $dir_image .'/*'));
                }

                $this->ftp->upload($fImage['tmp_name'],$path .'/'. $dir .'/'.$uploadData['file_name'],0755);
                $result['message']          = 'Thêm hình thành công!';
                $result['type']             = 'success';
                $result['image_name']       = $uploadData['file_name'];
                $result['path']             = $dir;
                $result['image_url']        = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/'.$uploadData['file_name'];
                $result['main_url']         = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/';
                $result['image_crop_true']  = 0;
            }
            
        }
        // Up hình crop
        if(isset($_FILES['image_crop']) && !empty($_FILES['image_crop'])){
            $fImage     = $_FILES['image_crop'];
            if($fImage['size'] > 5242880) {
                $result['message']  = 'Hình ảnh '.$fImage['name'].' quá lớn!';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            $sImageName = '1x1_'.$fImage['name'];

            $this->ftp->upload($fImage['tmp_name'],$path .'/'. $dir .'/'.$sImageName,0755);
                $result['message']          = 'Thêm hình thành công!';
                $result['type']             = 'success';
                $result['image_name']       = $sImageName;
                $result['path']             = $dir;
                $result['image_url']        = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/'.$sImageName;
                $result['main_url']         = DOMAIN_CLOUDSERVER . 'media/images/content/'. $dir .'/';
                $result['image_crop_true']  = 1;
            
        }
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax add image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function deleteImage() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Xóa hình thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);

        $path       = '/public_html/media/images/content/';
        $folder     = $this->input->post('path');
        $image_name = $this->input->post('image_name');
        $image_id   = $this->input->post('image_id');
        
        if($image_id != '' && $image_id != 0) {
            $this->load->model('images_model');
            $aImage = $this->images_model->get('*','id = ' . $image_id);
            if(isset($aImage) && count( array($aImage) ) != 0) {
                $this->images_model->delete($image_id,'id',false);
                $this->ftp->delete_file($path.$folder.'/'.$image_name);
                $this->ftp->delete_file($path.$folder.'/'.'1x1_'.$image_name);
                // $aListImageDelete = $this->session->userdata('aListImages');
                // $index = array_search($image_id,$aListImageDelete);
                // unset($aListImageDelete[$index]);
                // $this->session->set_userdata('aListImages',$aListImageDelete);
                $result['message']          = 'xóa hình thành công!';
                $result['type']             = 'success';
            }
        }

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax video
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function addVideo() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Thêm video thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->model('videos_model');

        #Create folder
        $pathImage = 'media/images/content/';
        $path = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir = date('dmY');
        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
       
        // if $my_dir name exists in array returned by nlist in current '.' dir
        if (! in_array($dir, $ldir)) {                    
            $this->ftp->mkdir($path . '/' . $dir, 0775);
        }

        if (!is_dir($pathImage . $dir_image)) {
            @mkdir($pathImage . $dir_image, 0775);
            $this->load->helper('file');
            @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
        }
        if(isset($_FILES['video']) && !empty($_FILES['video'])){
            $fVideo     = $_FILES['video'];
            if($fVideo['size'] > 524288000) {
                $result['message']  = 'Vui lòng chọn video dưới 500M';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            $iUserId = (int)$this->session->userdata('sessionUser');
            
            // Lưu video
            $aTypeVideo = array(
                'video/quicktime' => '.mp4',
                'video/mp4'       => '.mp4',
                'video/mpeg'      => '.mpeg',
            );
            $sImageVideo    = '';
            $sWidth         = 0;
            $sHeight        = 0;
            $sVideoName     = uniqid().time().uniqid();
            // Create video Thumb
            if($this->input->post('video_thumb') != '') {
                $sImageVideo = uniqid().time().uniqid();
                $sImageVideoType = $this->convertStringToImageFtp($sImageVideo,'media/images/content/'.$dir_image.'/',$this->input->post('video_thumb'));
                $sImageVideo = $sImageVideo.'.'.$sImageVideoType;

                $configImage['source_image'] = $pathImage . $dir_image .'/' . $sImageVideo;
                $configImage['new_image'] = $pathImage . $dir_image . '/thumbnail_1_' . $sImageVideo;
                $configImage['maintain_ratio'] = TRUE;
                $configImage['width'] = 580;
                $configImage['height'] = 1;
                $configImage['quality'] = 90; 
                $configImage['master_dim'] = 'width';                            
                $this->image_lib->initialize($configImage);
                $this->image_lib->resize();
                $this->image_lib->clear();

                if(file_exists($pathImage . $dir_image .'/'. $sImageVideo) 
                && file_exists($pathImage . $dir_image .'/thumbnail_1_'. $sImageVideo)
                ){
                    $this->ftp->upload($pathImage . $dir_image .'/'. $sImageVideo, '/public_html/video/thumbnail/'.$sImageVideo, 0775);
                $this->ftp->upload($pathImage . $dir_image .'/thumbnail_1_'. $sImageVideo, '/public_html/video/thumbnail/thumbnail_1_'.$sImageVideo, 0775);
                }
                
            }

            // Set width

            if($this->input->post('video_width') != '') {
                $sWidth = $this->input->post('video_width');
            }

            // Set height

            if($this->input->post('video_height') != '') {
                $sHeight = $this->input->post('video_height');
            }

            // Set title 
            $sTitle = '';
            if($this->input->post('video_title') != '') {
                $sTitle = $this->input->post('video_title');
            }

            // Set Description 
            $sDescription = '';
            if($this->input->post('video_content') != '') {
                $sDescription = $this->input->post('video_content');
            }
            $iVideoId = $this->videos_model->add(
                array(
                    'name'          => ($sVideoName.$aTypeVideo[$fVideo['type']] != '') ? $sVideoName.$aTypeVideo[$fVideo['type']] : '.mp4',
                    'title'         => $sTitle,
                    'description'   => $sDescription,
                    'width'         => $sWidth,
                    'height'        => $sHeight,
                    'thumbnail'     => $sImageVideo,
                    'path'          => 'video/thumbnail/',
                    'user_id'       => $iUserId
                )
            );
            if($iVideoId){
                $this->ftp->upload($fVideo['tmp_name'],'/public_html/video/'.$sVideoName.$aTypeVideo[$fVideo['type']],0755);
                $result['message']                  = 'Thêm hình thành công!';
                $result['type']                     = 'success';
                $result['not_video_url1']           = $iVideoId;
            }
        }
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax delete video
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */
    public function deleteVideo() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Xóa video thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $this->load->model('videos_model');

        #Create folder
        $pathImage = 'media/images/content/';
        $path = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir = date('dmY');
        $iVideoId = $this->input->post('iVideoId');

        $aVideos = $this->videos_model->get("*",'id = '.$iVideoId);
        if(isset($aVideos[0]) && !empty($aVideos[0])) {
            $oVideo = $aVideos[0];
            $this->videos_model->delete($iVideoId,'id',false);
            $this->ftp->delete_file('/public_html/video/'.$oVideo->name);
            $this->ftp->delete_file('/public_html/video/thumbnail/'.$oVideo->thumbnail);
            $this->ftp->delete_file('/public_html/video/thumbnail/thumbnail_1_'.$oVideo->thumbnail);
        }
        
        $result['message']          = 'Xóa video thành công!';
        $result['type']             = 'success';

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax get video
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function getVideo() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy video thất bại!';
        $result['type']     = 'error';
         // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $this->load->model('videos_model');

        #Create folder
        $pathImage = 'media/images/content/';
        $path = '/public_html/media/images/content';
        $dir_image = $this->session->userdata('sessionUsername');
        $dir = date('dmY');
        $iVideoId = $this->input->post('id');

        $aVideos = $this->videos_model->get("*",'id = '.$iVideoId);
        if(isset($aVideos[0]) && !empty($aVideos[0])) {
            $oVideo = $aVideos[0];
            dd($oVideo);
        }
        
        $result['message']          = 'Xóa video thành công!';
        $result['type']             = 'success';

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax add image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function getCustomlink() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy Customlink thất bại!';
        $result['type']     = 'error';
        
        $this->load->model('customlink_model');

        $id             = $this->input->post('id');
        $user_id        = $this->session->userdata('sessionUser');
        if($user_id == 0 || $user_id == '') {
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }
   
        $oCustomLink    = $this->customlink_model->get('*', 'id = ' . $id .' AND user_id = '.$user_id);

        if(isset($oCustomLink[0]) && !empty($oCustomLink)) {
            if($oCustomLink[0]->image_path != '') {
                $image = DOMAIN_CLOUDSERVER . 'media/custom_link/'.$oCustomLink[0]->image_path;
            } elseif (@getimagesize($oCustomLink[0]->image)) {
                $image = $oCustomLink[0]->image;
            } else {
                $image = base_url().'/templates/home/styles/images/default/error_image_400x400.jpg';
            }

            //Lấy video
            $video = '';
            if($oCustomLink[0]->media_type == 'video' && $oCustomLink[0]->video_path != '') {
                $video = $oCustomLink[0]->video_path;
            }

            $result['data']             = array(
                'title'         => $oCustomLink[0]->title,
                'description'   => $oCustomLink[0]->description,
                'image'         => $image,
                'video'         => DOMAIN_CLOUDSERVER . 'media/custom_link/'. $video
            );

            $result['message']          = 'Lấy Customlink thành công!';
            $result['type']             = 'success';
        }
        

        

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax edit Customlink
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function editCustomlink() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy Customlink thất bại!';
        $result['type']     = 'error';
        
        $this->load->model('customlink_model');

        
        // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        $this->load->library('image_lib');
        $this->load->library('upload');
        $this->load->library('form_validation');

        #Create folder
        $path       = '/public_html/media/custom_link';
        $path_ftp   = $path;
        $dir = date('Y').'/'.date('m').'/'.date('d');
        $aDir = array(date('m'),date('d'));
        $validate_size = 5242880;
        // Upload to other server cloud
        $ldir = array();
        $ldir = $this->ftp->list_files($path);
        if(in_array(date('Y'), $ldir)) {
            $ldir = $this->ftp->list_files($path.'/'.date('Y'));
            $path_ftp = $path.'/'.date('Y');
        }
        if(in_array(date('m'), $ldir)) {
            $ldir = $this->ftp->list_files($path.'/'.date('Y').'/'.date('m'));
            $path_ftp = $path.'/'.date('Y').'/'.date('m');
        }
        $id = $this->input->post('id');

        if(isset($_FILES['image']) && !empty($_FILES['image']) && $id != 0) {
            $allowed_mime_type_arr = array('video/mp4','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
            if(!in_array($_FILES['image']['type'],$allowed_mime_type_arr)){
                $result['message']  = 'Định dạng file bạn up lên không được cho phép';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            $fImage     = $_FILES['image'];

            $sImageName = uniqid().time().uniqid().'.'.pathinfo($fImage['name'], PATHINFO_EXTENSION);
            
            $image = $dir .'/'.$sImageName;
            $aData = array('image_path'=>$image,'media_type' => 'image','video_path'=>'');
            // Đăng video
            if($fImage['type'] == 'video/mp4') {
                $validate_size = 104857600;
                $aData = array('video_path'=>$image,'media_type' => 'video');
                $fVideoThumb = $_FILES['video_thumb'];
                if(isset($fVideoThumb) && !empty($fVideoThumb)) {
                    $sImageVideoThumb = uniqid().time().uniqid().'.'.pathinfo($fVideoThumb['name'], PATHINFO_EXTENSION); 
                    $aData['image_path']    = $dir .'/'.$sImageVideoThumb;
                    $aData['image_width']   = $this->input->post('video_width');
                    $aData['image_height']  = $this->input->post('video_height');
                    $result['media_type']   = 'video';
                    $result['image_path']   =  DOMAIN_CLOUDSERVER . 'media/custom_link/'. $aData['image_path'];
                }
            }

            if($fImage['size'] > $validate_size) {
                $result['message']  = 'File '.$fImage['name'].' quá lớn!';
                $result['type']     = 'error';
                echo json_encode($result);
                die();
            }

            // if $my_dir name exists in array returned by nlist in current '.' dir
            
            if(isset($aDir) && !empty($aDir)) {
                foreach ($aDir as $key => $sdir) {
                    if (! in_array($sdir, $ldir)) {
                        $this->ftp->mkdir($path_ftp . '/' . $sdir. '/', 0775);
                    }
                }
            }
            
            $this->ftp->upload($fImage['tmp_name'],$path .'/'. $dir .'/'.$sImageName,0755);
            
            if(isset($sImageVideoThumb) && $sImageVideoThumb != '') {
                $this->ftp->upload($fVideoThumb['tmp_name'],$path .'/'. $dir .'/'.$sImageVideoThumb,0755);
            }
            $user_id        = $this->session->userdata('sessionUser');
            $oLink = $this->customlink_model->get('*','id = ' . $id .' AND user_id = '.$user_id);
            if(isset($oLink[0]) && !empty($oLink[0])) {
                if($oLink[0]->image_path != '') {
                   $image_path = str_replace(DOMAIN_CLOUDSERVER, '', $oLink[0]->image_path);
                   $this->ftp->delete_file($path.'/'.$image_path);
                }
                if($oLink[0]->video_path != '' && $oLink[0]->media_type == 'video') {
                   $image_path = str_replace(DOMAIN_CLOUDSERVER, '', $oLink[0]->video_path);
                   $this->ftp->delete_file($path.'/'.$image_path);
                }
            }
            
            $this->customlink_model->update($aData, 'id = ' . $id .' AND user_id = '.$user_id);
            $result['message']          = 'Updae Customlink thành công!';
            $result['link']             =  DOMAIN_CLOUDSERVER . 'media/custom_link/'. $image;
            $result['id']               = $id;
            $result['type']             = 'success';
        }

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/04/01
     * Ajax add image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: string
     *  
     ***************************************************************************
    */

    public function deleteCustomlink() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Xóa Customlink thất bại!';
        $result['type']     = 'error';

        // Create FTP
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);
        
        $this->load->model('customlink_model');

        $id             = $this->input->post('id');
        $user_id        = $this->session->userdata('sessionUser');
        if($user_id == 0 || $user_id == '') {
            $result['message']  = 'Có lỗi session vui lòng thử lại!';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }
   
        $aCustomLink    = $this->customlink_model->get('*', 'id = ' . $id .' AND user_id = '.$user_id);
        if(isset($aCustomLink[0]) && count( (array) $aCustomLink[0] ) != 0 ) {
            $oCustomer = $aCustomLink[0];
            if($oCustomer->media_type == 'video') {
                // Xóa video
                if($oCustomer->video_path != '') {
                    $this->ftp->delete_file('/public_html/custom_link/'.$oCustomer->video_path);
                }
                // Xóa Image
                if($oCustomer->image_path != '') {
                    $this->ftp->delete_file('/public_html/custom_link/'.$oCustomer->image_path);
                }
            }else if ($oCustomer->image_path != '') {
                $this->ftp->delete_file('/public_html/custom_link/'.$oCustomer->image_path);
            }

            $this->customlink_model->delete($id,'id',false);

            $result['message']          = 'Xóa Customlink thành công!';
            $result['type']             = 'success';
        }
        

        

        echo json_encode($result);
        die();
    }

    public function not_img() {
        $sql2 = "SELECT a.not_id, p.name, p.id  FROM tbtt_content AS a "
            . 'LEFT JOIN tbtt_images AS p ON p.not_id = a.not_id '
            . "WHERE not_image = '' GROUP BY p.not_id ORDER BY p.id ASC";

        $query = $this->db->query($sql2);
        $item  = $query->result_array();
        if (!empty($item)) {
            foreach ($item as $key => $value) 
            {
                if (!empty($value['name'])) {
                   $query_sql = 'UPDATE tbtt_content SET  not_image = "' . $value['name'] .'" WHERE not_id = ' . $value['not_id']; 
                   $this->db->query($query_sql);
                }                
            }
        }
    }

    public function file_check($str){
        $allowed_mime_type_arr = array('video/mp4','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['image']['name']);
        if(isset($_FILES['file']['name']) && $_FILES['image']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }


    // public function cover_org() {
    //     $sql2 = "SELECT a.not_id, a.not_image FROM tbtt_content AS a ";
    //     $query = $this->db->query($sql2);
    //     $item  = $query->result_array();
    //     if (!empty($item)) {
    //         foreach ($item as $key => $value) 
    //         { 
    //             if (!empty($value['not_image'])) {
    //                $not_image = str_replace("http://azibai.org","http://cdn1.azibai.com",$value['not_image']);
    //                $query_sql = 'UPDATE tbtt_content SET  not_image = "' . $not_image .'" WHERE not_id = ' . $value['not_id']; 
    //                $this->db->query($query_sql);
    //             }                
    //         }
    //     }
    // }
}