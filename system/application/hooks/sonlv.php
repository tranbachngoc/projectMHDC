<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/20/2016
 * Time: 9:45 AM
 */
class lkvUtil
{
    public static function buildPrice($productObj, $group, $af = false)
    {
        $salePrice = $productObj->pro_cost;
        $saleOff = 0;
        $em_off = 0;
        $af_off = 0;
        $em_sale = 0;
        $af_sale = 0;
        $off_sale = $salePrice;

        if ($productObj->off_amount > 0) {
            $salePrice -= $productObj->off_amount;
            $saleOff += $productObj->off_amount;
            $off_sale = $salePrice;
        }

        // Check employee discount
        // if($group == 3){           
        // }else{
        if ($af == false) {
            $CI =& get_instance();
            $CI->load->model('user_model');
            $data['af_id'] = $_REQUEST['af_id'] != '' ? $_REQUEST['af_id'] : $CI->session->userdata('af_id');
            if ($data['af_id'] != '') {
                $userObject = $CI->user_model->get("use_id", "af_key = '" . $data['af_id'] . "'");
                if ($userObject->use_id > 0) {
                    $af = true;
                }
            }
        }
        if ($af == true) {
            if ($productObj->af_rate > 0) {
                $salePrice -= $productObj->af_rate * ($salePrice / 100);
                $saleOff += $productObj->af_rate * ($salePrice / 100);
                $af_off = $productObj->af_rate * ($salePrice / 100);
                $af_sale = $salePrice;
            } else {
                $salePrice -= $productObj->af_off;
                $saleOff += $productObj->af_off;
                $af_off = $productObj->af_off;
                $af_sale = $salePrice;
            }
        }
        // }

        // Check aff discount
        return array('salePrice' => $salePrice, 'saleOff' => $saleOff, 'em_off' => $em_off, 'af_off' => $af_off, 'em_sale' => $em_sale, 'af_sale' => $af_sale, 'off_sale' => $off_sale);
    }

    public static function formatPrice($price, $currency)
    {
        return number_format($price, 0, '.', '.') . ' ' . $currency;
    }
}

class sonlv
{
    public static function defineConstant()
    {

        $curTime = time();
        $discount = ', IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (15, 5)
                  ) * tbtt_product.pro_cost / 100
                END,
                0
              ) AS off_amount
              , IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN 0
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN tbtt_product.pro_saleoff_value
                END,
                0
              ) AS off_rate,
              IF(
                tbtt_product.dc_amt > 0,
                CAST(
                  tbtt_product.dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.dc_rate > 0,
                  CAST(
                    tbtt_product.dc_rate AS DECIMAL (15, 5)
                  ) * tbtt_product.pro_cost / 100,
                  0
                )
              ) AS em_off,
              IF(
                tbtt_product.dc_amt > 0,
                0,
                IF(
                  tbtt_product.dc_rate > 0,
                  tbtt_product.dc_rate,
                  0
                )
              ) AS em_rate,
              IF(
                tbtt_product.af_dc_amt > 0,
                CAST(
                  tbtt_product.af_dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.af_dc_rate > 0,
                  CAST(
                    tbtt_product.af_dc_rate AS DECIMAL (15, 5)
                  ) * tbtt_product.pro_cost / 100,
                  0
                )
              ) AS af_off,
              IF(
                tbtt_product.af_dc_amt > 0,
                0,
                IF(
                  tbtt_product.af_dc_rate > 0,
                  tbtt_product.af_dc_rate,
                  0
                )
              ) AS af_rate';
        define('DISCOUNT_QUERY', $discount);

        //Add by Bảo Trần, when exist Trường Qui Cách
        $discount_dp = ', IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN tbtt_product.pro_saleoff_value
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN CAST(
                    tbtt_product.pro_saleoff_value AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100
                END,
                0
              ) AS off_amount
              , IF(
                tbtt_product.pro_saleoff = 1 AND ((' . $curTime . ' >= tbtt_product.begin_date_sale AND ' . $curTime . ' <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )),
                CASE
                  WHEN tbtt_product.pro_type_saleoff = 2
                  THEN 0
                  WHEN tbtt_product.pro_type_saleoff = 1
                  THEN tbtt_product.pro_saleoff_value
                END,
                0
              ) AS off_rate,
              IF(
                tbtt_product.dc_amt > 0,
                CAST(
                  tbtt_product.dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.dc_rate > 0,
                  CAST(
                    tbtt_product.dc_rate AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100,
                  0
                )
              ) AS em_off,
              IF(
                tbtt_product.dc_amt > 0,
                0,
                IF(
                  tbtt_product.dc_rate > 0,
                  tbtt_product.dc_rate,
                  0
                )
              ) AS em_rate,
              IF(
                tbtt_product.af_dc_amt > 0,
                CAST(
                  tbtt_product.af_dc_amt AS DECIMAL (15, 5)
                ),
                IF(
                  tbtt_product.af_dc_rate > 0,
                  CAST(
                    tbtt_product.af_dc_rate AS DECIMAL (15, 5)
                  ) * T2.dp_cost / 100,
                  0
                )
              ) AS af_off,
              IF(
                tbtt_product.af_dc_amt > 0,
                0,
                IF(
                  tbtt_product.af_dc_rate > 0,
                  tbtt_product.af_dc_rate,
                  0
                )
              ) AS af_rate';
        define('DISCOUNT_DP_QUERY', $discount_dp);
    }

    public static function initTab()
    {

        $info = array();
        $CI =& get_instance();
        if ('administ' == $CI->uri->segment(1)) {
            return;
        }


        //////////////////////////////////////////////////////////////////////////////////////////
        $CI->load->model('showcart_model');
        // Cart info
        $info['cart_info'] = $CI->showcart_model->getCart();
        $info['cart_num'] = 0;
        if (!empty($info['cart_info'])) {
            foreach ($info['cart_info'] as $cp) {
                $info['cart_num'] += $cp['qty'];
            }
        }
        //////////////////////////////////////////////////////////////////////////////////////////
        $CI->load->model('product_model');

        $position = "";
        $s_province = (int)$CI->session->userdata('s_province');
        if ($s_province > 0) {
            if (in_array($s_province, array(4, 8, 58, 62, 63, 77, 33))) {
                $position = "AND tbtt_package_daily_user.position IN (001,000)";//khu vực 1
            } else {
                $position = "AND tbtt_package_daily_user.position IN (999,000)";//khu vực 2
            }
        } else {
            $position = "AND tbtt_package_daily_user.position IN (000)";//toan quoc
        }

        # Mua gi
        $info['suggestion_buys'] = $CI->product_model->buy_box($position);

        //////////////////////////////////////////////////////////////////////////////////////////
        # An gi
        //$info['suggestion_eat'] = $CI->product_model->eat_box($position);       

        //////////////////////////////////////////////////////////////////////////////////////////

        # Choi gi
        //$info['suggestion_play'] = $CI->product_model->play_box($position);

        //////////////////////////////////////////////////////////////////////////////////////////

        # O dau
        $info['suggestion_place'] = $CI->product_model->place_box($position);


        //////////////////////////////////////////////////////////////////////////////////////////
        # Tin tức
        $info['listNews'] = $CI->product_model->news_box();

        //////////////////////////////////////////////////////////////////////////////////////////
        #Load category cap 1 san pham
        $CI->load->model('category_model');
        $select = "cat_id, cat_name, cat_image, cat_service, parent_id, cat_level, cate_type";
        $where = "cat_status = 1  and parent_id = 0 and cate_type = 0";
        $info['categories'] = $CI->category_model->fetch($select, $where, "cat_order", "ASC");
        //////////////////////////////////////////////////////////////////////////////////////////

        #Load category dich vu
        $CI->load->model('category_model');
        $select = "cat_id, cat_name, cat_image,cat_service, parent_id, cat_level, cate_type";
        $where = "cat_status = 1  and parent_id = 0 and cate_type = 1";
        $info['cat_service'] = $CI->category_model->fetch($select, $where, "cat_order", "ASC");
        //////////////////////////////////////////////////////////////////////////////////////////

        #Load category dich vu
        $CI->load->model('category_model');
        $select = "cat_id, cat_name, cat_image, cat_service, parent_id, cat_level, cate_type";
        $where = "cat_status = 1  and parent_id = 0 and cate_type = 2";
        $info['cat_coupon'] = $CI->category_model->fetch($select, $where, "cat_order", "ASC");

        //////////////////////////////////////////////////////////////////////////////////////////
        /*$select = "cat_image, cat_id, cat_name";
        $where = "cat_status = 1  and parent_id= 0 and cat_hot = 1 ";
        $info['categories_hot']  = $CI->category_model->fetch($select, $where, "cat_order", "ASC");
        if(!empty($info['categories_hot'])){
            foreach($info['categories_hot'] as $item){
                $item->subcat = $CI->category_model->fetch($select, "cat_status = 1  and parent_id= {$item->cat_id} and cat_hot = 1 ", "cat_order", "ASC");
            }
        }*/

        //////////////////////////////////////////////////////////////////////////////////////////    
        $CI->load->model('product_favorite_model');
        $sessionUser = $user_id = (int)$CI->session->userdata('sessionUser');
        # Hàng yêu thích
        $info['user'] ='';

        $group_id = (int)$CI->session->userdata('sessionGroup');
//        $listNotifications = [];

        if ($user_id > 0) {
            $CI->load->model('user_model');
            $filter = array();
            $filter['select'] = 'pro_user, pro_id, pro_name, pro_cost, pro_image, pro_dir,pro_category, prf_id ' . DISCOUNT_QUERY;
            $filter['where'] = array('tbtt_product_favorite.prf_user' => $user_id);
            $info['favoritePro'] = $CI->product_favorite_model->getProducts($filter);
            $info['user'] = $CI->user_model->get('*', 'use_id = ' . $user_id);

//            $CI->load->model('notifications_model');
//            $CI->load->model('grouptrade_model');
//
//            $listNotifications = $CI->notifications_model->fetch_join("a.*, b.use_fullname, b.avatar", "LEFT", "tbtt_user AS b", "a.userId = b.use_id", "a.read = 0 AND a.actionType = 'key_new_invite' AND a.actionId = " . $user_id);
//            foreach ($listNotifications as $key => $value) {
//                $meta = json_decode($value->meta);
//                $get_grt_info = !empty($meta) ? ($CI->grouptrade_model->get('grt_name', 'grt_id = ' . (int)$meta->grt_id)) : [];
//                $listNotifications[$key]->grt_name = !empty($get_grt_info) ? $get_grt_info->grt_name : '';
//            }

        }

//        $info['listNotifications'] = $listNotifications;

        //////////////////////////////////////////////////////////////////////////////////////////

        $CI->load->model('eye_model');
        $user_id = (int)$CI->session->userdata('sessionUser');
        if ($user_id) {
            $info['listeyeproduct'] = $CI->eye_model->geteyetype('product', $user_id);
        } else {
            $info['listeyeproduct'] = $CI->eye_model->geteyetypenologin('product');
        }

        if ($user_id > 0) {
            $CI->load->model('follow_favorite_model');
            $CI->load->model('shop_model');
            $CI->load->model('content_model');
            $info['card_info']['has_user_followed'] = count($CI->follow_favorite_model->fetch_user_follow('*','follower = '.$user_id, '','','','',''));
            $info['card_info']['has_view'] = $CI->shop_model->get('sho_view','sho_user = '.$user_id)->sho_view;
            // $info['card_info']['has_content'] = count($CI->content_model->fetch('*','not_user = '.$user_id, '','','',''));
            $info['card_info']['has_cate_followed'] = $CI->follow_favorite_model->fetch_follow_cate('*','fc_user_id = '.$user_id, '','','','','');

            if (in_array($group_id, json_decode(ListGroupAff, true))) {
                $myshop = $CI->shop_model->get("sho_link, domain, sho_logo, sho_dir_logo", "sho_user = " . $user_id);
                //Get AF Login
                // $data['af_id'] = $data['currentuser']->af_key;
            } elseif ($group_id == StaffUser || $group_id == StaffStoreUser) {
                $parentUser = $CI->user_model->get("parent_id", "use_id = " . $sessionUser);
                $myshop = $CI->shop_model->get("sho_link, domain, sho_logo, sho_dir_logo", "sho_user = " . $parentUser->parent_id);
            }
            $info['myshop'] = $myshop;
        }


        //////////////////////////////////////////////////////////////////////////////////////////
        MY_Loader::$static_data['azitab'] = $info;
    }

    public static function listCategory() {
        $CI =& get_instance();
        $category = array();

        $CI->load->model('category_model');

        // get list category azibai
        $select = "tbtt_category.cat_id, tbtt_category.cat_name, tbtt_category.cate_type, a.cat_id as have_child";
        $where = "tbtt_category.cat_status = 1  and tbtt_category.parent_id = 0 and tbtt_category.cate_type = 0";
        $category['product_azibai']  = $CI->category_model->fetch($select, $where, "tbtt_category.cat_order", "ASC", -1, 0, 'join');


        $where_coupon = "tbtt_category.cat_status = 1  and tbtt_category.parent_id = 0 and tbtt_category.cate_type = 2";
        $category['coupon_azibai']  = $CI->category_model->fetch($select, $where_coupon, "tbtt_category.cat_order", "ASC", -1, 0, 'join');


        $category['category_user'] = array();
        $category['user_product'] = array();
        $id_user = (int)$CI->session->userdata('sessionUser');
        if ($id_user > 0) {

            // get list category user
            $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE pro_status = 1 and pro_user = '. $id_user;
            $result = $CI->db->query($cat_pro_aff);
            $arrylist = $result->result();

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
                          WHERE cat_id IN ('. $catarr .') ORDER BY cat_name ASC ';
                    $query = $CI->db->query($sql);
                    $category['category_user'] = $query->result();
                }
            }

            // get default product user
            $select_product = "id, id as dp_id, pro_id, pro_name, pro_detail, pro_descr, pro_keyword, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_saleoff_value, pro_hondle, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, pro_type";
            $start = 0;
            $limit = 12;
            $sort = "pro_id";
            $by = "DESC";
            $where_product = 'pro_status = 1 AND pro_user = ' . $id_user . ' AND pro_type = 0';

            $category['user_product'] = $CI->product_model->fetch_join($select_product . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where_product.' GROUP BY pro_id', $sort, $by, $start, $limit);
        }
        return $category;
    }

    public static function shopLocation()
    {
        $shop = [];
        $CI =& get_instance();
        $CI->load->model('shop_model');
        $CI->load->model('district_model');
        $CI->load->helper('theme');
        if(($shop_alias = is_domain_shop())){
            $CI->load->model('shop_model');
            $shop = $CI->shop_model->get('*', 'sho_link = "' . $shop_alias . '" OR domain = "' . $shop_alias . '"');
            if(!empty($shop)){
                if ($shop->sho_logo != "") {
                    $shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                } else {
                    $shop_logo = site_url('templates/home/images/no-logo.jpg');
                }
                $shop->distin = [];
                if($shop->sho_district){
                    $shop->distin = $CI->district_model->find_where(['DistrictCode' => $shop->sho_district], ['select' => 'DistrictName, ProvinceName'] );
                }
                //if co domain rieng va server host != thì set lại shop link
                $shop->shop_url = getAliasDomain();
                if(trim_protocol(trim($shop->domain))){
                    $shop->shop_url = shop_url($shop) . '/';
                }
                $shop->logo = $shop_logo;

                $CI->load->model('user_model');
                $shop_user = $CI->user_model->generalInfo($shop->sho_user);
                if (!empty($shop_user))
                {
                  $shop->group_user = $shop_user['use_group'];
                }

                // include api
                // $CI->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
                // $list_branch = Api_affiliate::list_branch_of_shop($CI, $shop->sho_user);
                // $shop->list_branch = $list_branch;
                $shop->list_branch = $CI->shop_model->get_list_branch_by_user_id($shop->sho_user);
            }
        }
        MY_Loader::$static_data['hook_shop'] = $shop;
        unset($shop);
    }

}

