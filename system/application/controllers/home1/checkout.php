<?php
#****************************************#
# * @Author: thuan                       #
# * @Email:  thuanthuan0907@gmail.com    #
# *                                      #
# *                                      #
#****************************************#
class Checkout extends MY_Controller
{
    private $mainURL;
    private $shopURL;

    function __construct()
    {
        parent::__construct();
        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }

        $this->mainURL = $this->getMainDomain();
        $this->shopURL = $this->getShopLink();
        $this->load->helper('cookie');
        $this->load->library('session');

        #END CHECK SETTING
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/showcart');
        #Load model
        $this->load->model('voucher_model');
        $this->load->model('showcart_model');
        $this->load->model('category_model');
        $this->load->model('viettelpost_model');
        $this->load->model('product_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('shop_model');
        $this->load->model('user_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('detail_product_model');
        $this->load->model('shop_mail_model');
        $this->load->model('grouptrade_model');
        $this->load->model('flatform_model');
        $this->load->model('order_nhanhvn_model');
        $this->load->model('shop_momo_model');
        $this->load->model('shop_nganluong_model');
        $this->load->model('shop_nhanh_model');
         $this->load->model('order_model');
        $this->load->library('NhanhService');
        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;

        
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }

        #BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }

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


    public function product() {
        $data = array();
        // check admin azibai can't buy product
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
        $cart = $this->session->userdata('cart');
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
            }
        }

        
        $listProduct = array();
        $productList = array();
        $jsCart = array();
        foreach ($cart as $cartItem) {
            if (!empty($cartItem)) {
                foreach ($cartItem as $pItem) {
                    array_push($listProduct, $pItem['pro_id']);
                }
            }
        }

        if (!empty($listProduct)) {
            $where = 'pro_id IN ('. implode(',', $listProduct) .') AND pro_status = 1';

            $select = $select_hh.'apply, pro_saleoff, pro_type_saleoff, pro_saleoff_value, begin_date_sale, end_date_sale, af_dc_rate, af_dc_amt, pro_user, pro_instock, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
            $products = $this->product_model->fetch($select, $where, 'pro_id', 'ASC');
            $this->load->model('product_promotion_model');
            
            foreach ($products as $pro) {
                foreach ($cart as $key => $cartItems) {
                    if (!isset($jsCart[$key])) {
                        $jsCart[$key] = array('shop' => $key, 'products' => array());
                    }
                    if (!empty($cartItems)) {
                        foreach ($cartItems as $cItem) {
                            if ($cItem['pro_id'] == $pro->pro_id) {
                                $pItem = clone $pro;
                                $afSelect = false;
                                if ($cItem['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                                    $afSelect = true;
                                }

                                // $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);
                                
                                $dataHH = $this->dataGetHH($pro, $cItem['af_key']);
                                ## Get price for Trường Quy Cách SP, by Bao Tran
                                $quycach = null;
                                if ($cItem['dp_id'] > 0) {
                                    $dp_where = 'pro_id = '. $pro->pro_id .' AND pro_status = 1';
                                    $dp_select = 'apply, pro_saleoff, pro_type_saleoff, pro_saleoff_value, begin_date_sale, end_date_sale, af_dc_rate, af_dc_amt, pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) AS pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                                    $dp_product = $this->product_model->getProAndDetailForCheckout($dp_select, $dp_where, (int)$cItem['dp_id']);
                                    $quycach = $dp_product->pro_cost;
                                    $dataHH = $this->dataGetHH($product, $cItem['af_key']);
                                    // $discount = lkvUtil::buildPrice($dp_product, $this->session->userdata('sessionGroup'), $afSelect);
                                }
                                $hoahong = $this->checkHH($dataHH, $quycach);
                                $pro_price = ($hoahong['price_aff'] > 0) ? $hoahong['price_aff'] : $hoahong['priceSaleOff'];

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

                                $pItem->pro_cost = $pro_price;
                                // $pItem->pro_cost = $discount['salePrice'];
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
                                $pItem->fl_id = $cItem['fl_id'];

                                if ($pItem->pro_type == 0) {
                                    if (!isset($productList[$key])) {
                                        $productList[$key] = array();
                                    }
                                    array_push($productList[$key], $pItem);
                                }
                                $productItem = array('pro_id' => $pItem->pro_id, 'key' => $pItem->key, 'qty' => $pItem->qty, 'pro_cost' => $pItem->pro_cost, 'em_discount' => $pItem->em_discount, 'shipping_fee' => $pItem->shipping_fee, 'dp_id' => $pItem->dp_id);
                                array_push($jsCart[$key]['products'], $productItem);
                            }
                        }
                    }
                }
            }
        }

        $data['mainDomain'] = $this->mainURL;
        $data['cart'] = $productList;
        $data['jsCart'] = $jsCart;
        $data['shops'] = array();
        $data['type'] = 'product';
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
        $this->load->view('home/checkout/checkout', $data);
    }

    public function coupon() {
        $data = array();
        // check admin azibai can't buy product
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

        $cart = $this->session->userdata('cart_coupon');

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
                $this->session->set_userdata('cart_coupon', $cart);
            }
        }

        
        $listProduct = array();
        $productList = array();
        $jsCart = array();
        foreach ($cart as $cartItem) {
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
                foreach ($cart as $key => $cartItems) {
                    if (!isset($jsCart[$key])) {
                        $jsCart[$key] = array('shop' => $key, 'products' => array());
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
                                $pItem->fl_id = $cItem['fl_id'];

                                if ($pItem->pro_type == 2) {
                                    if (!isset($productList[$key])) {
                                        $productList[$key] = array();
                                    }
                                    array_push($productList[$key], $pItem);
                                }
                                $productItem = array('pro_id' => $pItem->pro_id, 'key' => $pItem->key, 'qty' => $pItem->qty, 'pro_cost' => $pItem->pro_cost, 'em_discount' => $pItem->em_discount, 'shipping_fee' => $pItem->shipping_fee, 'dp_id' => $pItem->dp_id);
                                array_push($jsCart[$key]['products'], $productItem);
                            }
                        }
                    }
                }
            }
        }


        $data['mainDomain'] = $this->mainURL;
        $data['cart'] = $productList;
        $data['jsCart'] = $jsCart;
        $data['shops'] = array();
        $data['type'] = 'coupon';
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
        $this->load->view('home/checkout/checkout', $data);
    }

    public function delete_all_qty() {
        $type = $this->input->post('type');
        if ($type == 'coupon') {
            $this->session->unset_userdata('cart_coupon');
        } else {
          $this->session->unset_userdata('cart');
        }
        echo json_encode(array('error' => false));
        exit();
    }


    public function order_temp() {
        $list_key = $this->input->post('list_key');
        $type = $this->input->post('type');
        $this->load->library('hash');
        $salt = $this->hash->key(20);
        $data_insert = [
            'salt'  => $salt,
            'type' => $type,
            'list_key' => $list_key
        ];

        // 
        $productList = array();
        $cart = $type == 'product' ? $this->session->userdata('cart') : $this->session->userdata('cart_coupon');
        if (!empty($cart)) {
            $this->load->model('product_promotion_model');
            foreach ($cart as $key => $items) {
                if (!empty($items)) {
                    foreach ($items as $k => $cp) {
                        // Build product price
                        $select = 'pro_user, pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_type, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                        $pro = $this->product_model->get($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1');
                        ## Get price for Trường Quy Cách SP, by Bao Tran
                        if ($cp['dp_id'] > 0) {
                            $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) as pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                            $pro = $this->product_model->getProAndDetailForCheckout($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1', (int)$cp['dp_id']);
                        }
                        
                        $afSelect = false;
                        $items[$k]['af_user'] = $cp['af_id'];
                        if ($cp['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                            $afSelect = true;
                        }

                        $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                        // Make discount for member
                        $pro->em_discount = 0;
                        if ($pro->pro_user != (int)$this->session->userdata('sessionUser')) {
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
                        $pro->pro_weight = $cp['pro_weight'];
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
                        $pro->fl_id = $cp['fl_id'];
                        $pro->af_id = $cp['af_id'];
                        if (in_array($cp['key'], $list_key))
                        {
                            if (!isset($productList[$key])) {
                                $shopFilter = array(
                                    'select' => 'sho_name, sho_link, domain, sho_id, sho_user, sho_shipping, IF(sho_kho_district <> \'\' AND sho_kho_district <> 0, sho_kho_district, sho_district) AS district, IF((sho_kho_province <> 0) AND (sho_kho_district <> \'\' AND sho_kho_district <> 0), sho_kho_province, sho_province) AS province',
                                    'where' => array('sho_user' => $key)
                                );
                                // Add shop to seesion
                                $shop = $this->shop_model->getShopInfo($shopFilter);
                                $productList[$key] = array(
                                    'info' => $shop,
                                    'product' => [],
                                    'shipping' => [],
                                    'totalWeight' => 0,
                                );
                            }
                            $productList[$key]['totalWeight'] += $pro->qty * $pro->pro_weight;
                            array_push($productList[$key]['product'], $pro);
                        }
                    }
                }
            } 
        }
        $data_insert['productList'] = $productList;
        $this->session->set_userdata($salt, $data_insert);
        echo json_encode(['error' => false, 'salt'=> $salt]);
        exit();        
    }


    public function order_address() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') 
        {
            $this->load->model('province_model');
            $this->load->model('district_model');

            if (!empty($this->input->post('id_address')) && $this->session->userdata('sessionUser')) 
            {
                $this->load->model('user_order_receive_model');
                $receive = $this->user_order_receive_model->get('*', 'use_id = ' . (int)$this->session->userdata('sessionUser') . ' AND id = '. $this->input->post('id_address'));

                if (!empty($receive)) {
                    $data_address = array(
                        'name' => $receive->name,
                        'phone' => $receive->phone,
                        'semail' => $receive->semail,
                        'address' => $receive->address,
                        'province' => $receive->province,
                        'district' => $receive->district,
                        'active'      => $receive->active,
                        'new'      => 0
                    );
                } 
            }
            else
            {
                $data_address = array(
                    'name' => $this->input->post('name'),
                    'phone' => $this->input->post('phone'),
                    'semail' => $this->input->post('semail'),
                    'address' => $this->input->post('address'),
                    'province' => $this->input->post('province'),
                    'district' => $this->input->post('district'),
                    'active'      => (int) $this->input->post('active'),
                    'new'      => 1,
                    'receiver_other'=> (int) $this->input->post('receiver_other'),
                    'name_buy'      => $this->input->post('name_buy'), 
                    'phone_buy'      => $this->input->post('phone_buy'), 
                );
            }

            if (empty($data_address)) {
                redirect(base_url() . 'v-checkout');
            }

            $name_province = $this->province_model->get('pre_name', 'pre_status = 1 AND pre_id ='. (int) $data_address['province']);           
            $name_district = $this->district_model->get('DistrictName, DistrictCode', 'id = '. (int) $data_address['district']);

            $data_address['district_code'] = $name_district->DistrictCode;
            $data_address['full_address'] = $data_address['address'] .', '. $name_district->DistrictName . ', ' . $name_province->pre_name;
            $data_address['name_district'] = $name_district->DistrictName;
            $data_address['name_province'] = $name_province->pre_name;

            $this->session->set_userdata('order_address', json_encode($data_address));
            redirect(base_url() . 'v-checkout/order?key='.$_REQUEST['key']);
        } 
        else
        {
            $this->load->model('province_model');
            $data['province'] = $this->province_model->getProvince(['where' => 'pre_status = 1', 'order_by' => 'pre_order ASC' ]);
            $this->load->model('user_order_receive_model');
            $data['list_receive'] = [];

            if ($this->session->userdata('sessionUser') > 0) 
            {
                $data['list_receive'] = $this->user_order_receive_model->fetch('*', 'use_id = ' . (int)$this->session->userdata('sessionUser'));
            }
            else 
            {

            }

            $this->load->view('home/checkout/address', $data);
        }
    }

    function check_sms_verify() {
        $key_order = $this->session->userdata($this->input->post('key_order'));
        $sms_verify = $this->input->post('sms_verify');
        $result = [
            'error' => true,
        ];
        if (!empty($key_order['case_user']['key_sms']) && !empty($sms_verify)) {
            if ($key_order['case_user']['key_sms'] == $sms_verify) {
                $key_order['case_user']['sms_verify'] = 1;
                $key_order['case_user']['password']  = trim($this->input->post('new_password'));
                $result = [
                    'error' => false,
                ];
                $this->session->set_userdata($this->input->post('key_order'), $key_order);
            }
        }
        echo json_encode($result);
        exit();
    }

    function get_sms_verify() {
        $key_order = $this->session->userdata($this->input->post('key_order'));
        $new_phone = $this->input->post('new_phone');
        $result = [
            'error' => true,
            'msg_error' => 'Vui lòng kiểm tra lại đơn hàng.'
        ];
        
        if (!empty($key_order)) 
        {
            if (is_numeric($new_phone)) 
            {
                if (substr($new_phone, 0, 1) == 0) 
                {
                    $phone_num = substr($new_phone, 1);
                } 
                else 
                {
                    $phone_num = '0' . $new_phone;
                }

                $where_or = 'use_mobile = "' . $new_phone . '"';
                $where_or .= 'OR use_phone = "' . $new_phone . '"';
                $where_or .= 'OR use_username = "' . $new_phone . '"';
                $where_or .= 'OR use_mobile = "' . $phone_num . '"';
                $where_or .= 'OR use_phone = "' . $phone_num . '"';
                $where_or .= 'OR use_username = "' . $phone_num . '"';

                $user = $this->user_model->get('use_id', $where_or);
                if ($user && $user->use_id > 0) 
                {
                    $result['msg_error'] = 'Số điện thoại này đã có người sử dụng. Vui lòng kiểm tra lại và nhập số khác!';              
                }
                else
                {
                    $msg_authorized_phone = json_decode($this->add_authorized_phone($new_phone),true);

                    if (!empty($msg_authorized_phone['key_sms']) && empty($msg_authorized_phone['msg_error'])) 
                    {
                        $key_order['case_user']['key_sms'] = $msg_authorized_phone['key_sms'];
                        $key_order['case_user']['phone'] = $phone;
                        $result['error'] = false;
                        $this->session->set_userdata($this->input->post('key_order'), $key_order);
                    } 
                    else if (!empty($msg_authorized_phone['msg_error'])) 
                    {
                        $result['msg_error'] = $msg_authorized_phone['msg_error'];
                    }
                } 
            } 
            else
            {
               $result['msg_error'] = 'Số điện thoại này không hợp lệ. Vui lòng kiểm tra lại và nhập số khác!'; 
            }
        }
        echo json_encode($result);
        exit();
    }

    function add_address_case(){
        $result = [
            'error' => true,
        ];
        $this->load->model('user_model');
        $this->load->model('district_model');
        $this->load->model('user_order_receive_model');
        $receiver_other = (int) $this->input->post('receiver_other');
        $key_order = $this->session->userdata($this->input->post('key_order'));
        $phone = $receiver_other > 0 ? $this->filter->injection_html($this->input->post('phone_buy')) : $this->filter->injection_html($this->input->post('phone'));
        $msg_error = '';
        
        if (!empty($phone) && !empty($key_order)) {

            if (substr($phone, 0, 1) == 0) 
            {
                $phone_num = substr($phone, 1);
            } 
            else 
            {
                $phone_num = '0' . $phone;
            }

            $where_or = 'use_mobile = "' . $phone . '"';
            $where_or .= 'OR use_phone = "' . $phone . '"';
            $where_or .= 'OR use_username = "' . $phone . '"';
            $where_or .= 'OR use_mobile = "' . $phone_num . '"';
            $where_or .= 'OR use_phone = "' . $phone_num . '"';
            $where_or .= 'OR use_username = "' . $phone_num . '"';

            $getphone = $this->user_model->get('use_id', $where_or);
            // 1. Số điện thoại không tồn tại tạo tài khoản mới và lưu lại địa chỉ giao hàng.
            // 2. Số điện thoại tồn tại. lấy luôn số điện thoại đó.
            
            
            if (empty($getphone)) 
            {
                $case = 1;
                $data = '';
            } 
            else 
            {
                $case = 2;
                $data = $getphone;
            }

            if ($case == 1) 
            {
                $msg_authorized_phone = json_decode($this->add_authorized_phone($phone),true);
            }
            
            $result['case'] = $case;
            $result['phone'] = $phone;
            $result['email'] = $email;
            $result['data'] = $data;
            $result['sms_error'] = !empty($msg_authorized_phone['msg_error']) ? $msg_authorized_phone['msg_error'] : '';
            $key_order['case_user'] =  $result;
            $key_order['case_user']['key_sms'] =  !empty($msg_authorized_phone['key_sms']) ? $msg_authorized_phone['key_sms'] : '';
            $key_order['case_user']['sms_verify'] = 0;

            $this->session->set_userdata($this->input->post('key_order'), $key_order);
        }
        
        echo json_encode($result);
        exit();
    }

    function add_authorized_phone($phone) {
        $msg_error = '';
        $this->load->model('authorized_code_model');
        $mobile = trim($this->filter->injection_html($phone));
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
            $data_sms = [
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

            $dataString = json_encode($data_sms);
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
            $result_sms = json_decode($respon);
            if ((int)$result_sms->response->submission->sms[0]->status != 0) 
            {
                 switch ((int)$result_sms->response->submission->sms[0]->status) {
                    case 7:
                        $msg_error = 'Thuê bao quý khách từ chối nhận tin. Vui lòng cài đặt lại!';
                        break;
                    case 10:
                        $msg_error = 'Không phải thuê bao di dộng. Vui lòng kiểm tra lại!';
                        break;
                    case 31:
                        $msg_error = 'Đầu số sim của bạn hiện ngừng sử dụng. Vui lòng kiểm tra lại!';
                        break;
                    default:
                        $msg_error = 'Hệ thống lỗi. Vui lòng thử lại!';
                        break;
                }          
            }
        }

        return json_encode(['msg_error' => $msg_error, 'key_sms' => $key]);
    }

    function add_address(){
        $result = [
            'error' => true,
        ];
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('user_order_receive_model');
        $data_add = array(
            'use_id' => $this->session->userdata('sessionUser'),
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('phone'),
            'semail' => $this->input->post('semail'),
            'address' => $this->input->post('address'),
            'province' => $this->input->post('province'),
            'district' => $this->input->post('district'),
            'active'      => (int)$this->input->post('active'),
            'updated_at'      => date('Y-m-d H:i:s', time())
        );
        if($this->input->post('active')){
            $this->user_order_receive_model->update(array('active' => 0));
        }
        $name_province = $this->province_model->get('pre_name', 'pre_status = 1 AND pre_id ='. (int) $data_add['province']);           
        $name_district = $this->district_model->get('DistrictName, DistrictCode', 'id = '. (int) $data_add['district']);
        $data_add['full_address'] = $data_add['address'] .', '. $name_district->DistrictName . ', ' . $name_province->pre_name;
        if($this->user_order_receive_model->add($data_add)){
            $result = [
                'error' => false,
            ];
        }
        echo json_encode($result);
        exit();
    }

    function update_address(){

        $result = array();
        $result['error'] = true;
        $result['check'] = false;

        if($this->input->post('active') == 1){
            $result['check'] = true;
        }
        
        if($this->input->post('province_id') > 0){
            $this->load->model('province_model');
            $this->load->model('district_model');

            $province = $this->province_model->getProvince(['where' => 'pre_status = 1', 'order_by' => 'pre_order ASC' ]);

            $where = 'pre_status = 1 AND ProvinceCode = '.(int)$this->input->post('province_id');
            $district = $this->district_model->getDistrict(['where' => $where, 'order_by' => 'DistrictName ASC' ]);
            $result['province'] = $province;
            $result['district'] = $district;
        }

        if($this->input->post('id')){
            $this->load->model('province_model');
            $this->load->model('district_model');
            $this->load->model('user_order_receive_model');
            
            $data_update = array(
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'semail' => $this->input->post('semail'),
                'address' => $this->input->post('address'),
                'province' => $this->input->post('province'),
                'district' => $this->input->post('district'),
                'active'      => (int) $this->input->post('active'),
                'updated_at'      => date('Y-m-d H:i:s', time())
            );
            if($this->input->post('active')){
                $this->user_order_receive_model->update(array('active' => 0));
            }
            $name_province = $this->province_model->get('pre_name', 'pre_status = 1 AND pre_id ='. (int) $data_update['province']);           
            $name_district = $this->district_model->get('DistrictName, DistrictCode', 'id = '. (int) $data_update['district']);
            $data_update['full_address'] = $data_update['address'] .', '. $name_district->DistrictName . ', ' . $name_province->pre_name;
            if($this->user_order_receive_model->update($data_update, 'id = ' . (int)$this->input->post('id').' AND use_id = '.(int)$this->session->userdata('sessionUser')))
            {
                $result['error'] = false;
            }
        }

        echo json_encode($result);
        exit();
    }

    function delete_address(){
        $result = array();
        $result['error'] = true;
        if($this->input->post('id')){
            $this->load->model('user_order_receive_model');
            if($this->user_order_receive_model->delete('id = ' . (int)$this->input->post('id').' AND use_id = '.(int)$this->session->userdata('sessionUser'))){
                if($this->input->post('active') == 1){
                    $this->user_order_receive_model->update(array('active' => 1), 'id = '. (int)$this->input->post('id_max').' AND use_id = '.(int)$this->session->userdata('sessionUser'));
                }
                $result['error'] = false;
            }
        }
        echo json_encode($result);
        exit();
    }

    public function get_district() {
        $result = [
            'error' => true,
            'result'  => []
        ];
        if ($this->input->post('id_province') != '')
        {
            $this->load->model('district_model');
            $district = $this->district_model->find_by(array('pre_status' => 1, 'ProvinceCode' => $this->input->post('id_province')), 'id, DistrictName, DistrictCode');
            $result = [
                'error' => false,
                'result'  => $district
            ];
        }
        echo json_encode($result);
        exit();
    }

    function shipping()
    {
        $shop_id = (int)$this->input->post('shop_id');
        $shop_district = $this->input->post('shop_district');
        $company = $this->input->post('company');
        $order_temp =  $this->session->userdata($this->input->post('key_order'));
        $totalWeight = 0;
        $feeError = false;
        $feeAmount = 0;
        $feeTime = '';
        $feeError = true;
        $shipfee = array();
        if (!empty($order_temp['type']) && !empty($order_temp['productList']) && !empty($shop_id) && !empty($order_temp['info_address'])) 
        { 
            if (!empty($order_temp[$shop_id])) {
                foreach ($cart[$shop_id] as $k => $cp) {
                    $totalWeight += $cp['pro_weight'] * $cItems[$k]['qty'];
                }
            }

            if ($order_temp['info_address']->district_code != '' && $shop_district != '') {                
                if ($company == 'GHN') {
                    $shipfee = $this->getShippingFee($shop_district, $order_temp['info_address']->district_code, $totalWeight);                    
                } elseif ($company == 'SHO') {
                    $shipfee['ServiceFee'] = 0;
                    $shipfee['ServiceName'] = "";
                    $shipfee['ServiceID'] = "SHO";
                }

                if (isset($order_temp['productList'][$shop_id])) {
                    $order_temp['productList'][$shop_id]['shipping'] =  $shipfee;
                    $this->session->set_userdata($this->input->post('key_order'), $order_temp);
                }

                if (isset($shipfee['ServiceFee'])) {
                    $feeAmount = $shipfee['ServiceFee'];
                    $feeTime = $shipfee['ServiceName'];
                    $feeError = false;
                }
            }
        }

        echo json_encode(array('error' => false, 'fee_error' => $feeError, 'fee_amount' => $feeAmount, 'feeTime' => $feeTime, 'fee' => $fee));
        exit();
    }  

    private function getShippingFee($fromDistrict, $toDistrict, $totalWeight)
    {
        $this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();
        $serviceClient = $this->RestApiClient->connectGHN();
        $sessionToken = $serviceClient->SignIn();
        $serviceClient->SignOut();
        $result = array();

        if ($sessionToken) {
            foreach (json_decode(ServiceID) as $k => $vls) {
                $items[] = array(
                    "FromDistrictCode" => $fromDistrict,
                    "ServiceID" => $k,
                    "ToDistrictCode" => $toDistrict,
                    "Weight" => $totalWeight,
                    "Length" => 0,
                    "Width" => 0,
                    "Height" => 0
                );
                
                $calculateServiceFeeRequest = array("SessionToken" => $sessionToken, "Items" => $items);
                $responseCalculateServiceFee = $serviceClient->CalculateServiceFee($calculateServiceFeeRequest);
                $result = reset($responseCalculateServiceFee['Items']);

                if ($responseCalculateServiceFee['ErrorMessage'] == "") {
                    break;
                }
                unset($items);
                unset($responseCalculateServiceFee);
            }
        }
        return $result;
    }

    private function getNhanhShippingFee($dataFree, $shop_info)
    {
        $service_nhanh = new NhanhService($shop_info->user_name, $shop_info->secret_key, false);
        $response = $service_nhanh->sendRequest(NhanhService::URI_SHIPPING_FEE, $dataFree);
        $result = [];
        if($response->code)
        {
            foreach ($response->data as $key => $value)
            {
                if (!empty($value->contentId))
                {
                    $result[$value->contentId] = $value;
                }
            }
        }
        return $result;
    }

    private function addNhanhOrder($nhanh_data, $shop_info, $storeId)
    {
        $service_nhanh = new NhanhService($shop_info->user_name, $shop_info->secret_key, false);
        $response = $service_nhanh->sendRequest(NhanhService::URI_ORDER_ADD, $nhanh_data, $storeId);
    }

    public function order() {
        
        $this->load->model('product_promotion_model');
       
        $data = [];

        $order_address = $this->session->userdata('order_address');
        $order_temp = !empty($_REQUEST['key']) ? $this->session->userdata($_REQUEST['key']) : '';
        $productList = array();
        if (!empty($order_temp['productList']) && !empty($order_address)) 
        {
            $data['order_address'] = json_decode($order_address);
            $data['order_type'] = $order_temp['type'];
            $order_temp['info_address'] = $data['order_address'];

            $shop_id = key($order_temp['productList']);
            $order_temp['productList'][$shop_id]['listVoucher'] = array();
            $order_temp['productList'][$shop_id]['typeVoucher'] = 0;
            if ($order_temp['type'] == 'product') {
                foreach ($order_temp['productList'] as $key => $value)
                {
                    
                    $order_temp['productList'][$key]['shipping'] = array(
                        'ServiceFee' => 0,
                        'ServiceName' => "",
                        'ServiceID'   => "SHO"
                    );

                    $shop_province = $this->province_model->get('pre_name', 'pre_status = 1 AND pre_id ='. (int) $value['info']['province']);
                    $shop_district = $this->district_model->get('DistrictName, DistrictCode', 'DistrictCode = '. (int) $value['info']['district']);

                    // check nhanhvn
                    
                    $shop_nhanh = $this->shop_nhanh_model->get('*', 'sho_id =' . (int) $value['info']['sho_id']);

                    $shop_momo = $this->shop_momo_model->get('*', 'sho_id =' . (int) $value['info']['sho_id']);

                    $shop_nganluong = $this->shop_nganluong_model->get('*', 'sho_id =' . (int) $value['info']['sho_id']);
                       
                    if ( !empty($shop_nhanh) && !empty($shop_province->pre_name) && !empty($shop_district->DistrictName) && !empty($data['order_address']->name_province) && !empty($data['order_address']->name_district))
                    {
                        $data_fee = array(
                            "fromCityName" => $shop_province->pre_name,
                            "fromDistrictName" => $shop_district->DistrictName,
                            "toCityName" => $data['order_address']->name_province,
                            "toDistrictName" => $data['order_address']->name_district,
                            "shippingWeight" => (int) $value['totalWeight'], // 1000 gr = 1 kg
                        );
                        $order_temp['productList'][$key]['nhanh_shipping'] = $this->getNhanhShippingFee($data_fee, $shop_nhanh);
                        $order_temp['productList'][$key]['nhanh_data'] = $data_fee;
                        // dd($order_temp['productList'][$key]['nhanh_shipping']);die;
                    }

                    // $this->getShippingFee();
                }
            }            
            $productList = $order_temp['productList'];
            $this->session->set_userdata($_REQUEST['key'], $order_temp);
        }

        
        $data['shop_momo'] = !empty($shop_momo) ? true : false;
        $data['shop_nganluong'] = !empty($shop_nganluong) ? true : false;
        
        $data['productList'] = $productList;

        $data['list_voucher'] = !empty($shop_id) ? $this->voucher_model->listVoucher($shop_id) : false;
        $this->load->view('home/checkout/order', $data);
    }

    public function place_order() {

        $this->load->model('shop_nhanh_model');
        $this->load->model('order_voucher_model');
        $result = array(
            'error' => true,
            'data'  => [],
            'total' => 0
        );
        if ($this->input->server('REQUEST_METHOD') == 'POST' && !empty($this->input->post('key'))) 
        {
            $protocol   = get_server_protocol();
            $domainName = $_SERVER['HTTP_HOST'];
            
            $company = $this->input->post('company');
            $payment_method = $this->input->post('payment_method');
            $bankcode = $this->input->post('bankcode');
            $note_order = $this->input->post('note');
            
            $key_oder = $this->input->post('key');
            $order_temp = $this->session->userdata($key_oder);

            $this->load->model('product_promotion_model');
            $this->load->model('order_model');
            $this->load->model('user_receive_model');
            $this->load->model('user_order_receive_model');
            if (!empty($order_temp)) {

                $cart = $order_temp['type'] == 'product' ? $this->session->userdata('cart') : $this->session->userdata('cart_coupon');

                $list_remove_session = [];
                $address = $order_temp['info_address'];
                $result['name'] = $address->name;
                $orderUser = 0;
                
                if ($this->session->userdata('sessionUser')) {
                    $orderUser = $this->session->userdata('sessionUser');
                } 
                else if (!empty($order_temp['case_user']['data']) && $order_temp['case_user']['case'] == 2 ) 
                { 
                    $orderUser = $order_temp['case_user']['data']->use_id;
                } 
                else if ($order_temp['case_user']['case'] == 1 && $order_temp['case_user']['sms_verify'] == true)
                {   
                    $this->load->library('hash');
                    $salt = $this->hash->key(8);
                    $pass = $order_temp['case_user']['password'];
                    
                    $phone_buy = $order_temp['info_address']->phone;
                    $name_buy = $order_temp['info_address']->name;
                    if (!empty($order_temp['info_address']->receiver_other)) 
                    {
                        $phone_buy = $order_temp['info_address']->phone_buy;
                        $name_buy = $order_temp['info_address']->name_buy;
                    }


                    $data_user = array(
                        'use_username' => $phone_buy,
                        'use_salt' => $salt,
                        'use_password' => $this->hash->create($pass, $salt, 'md5sha512'),
                        'use_fullname' => $name_buy,
                        // 'use_address' =>$order_temp['info_address']->full_address,
                        // 'use_province' => $order_temp['info_address']->province,
                        // 'user_district' => $order_temp['info_address']->district_code,
                        // 'use_email' => $order_temp['info_address']->semail,
                        'use_status' => 1,
                        'use_group' => 3,
                        'parent_id' => 0,
                        'use_regisdate' => time(),
                        'use_enddate' => 0,
                        'active_date' => date('Y-m-d'),
                        'use_mobile' => $phone_buy,
                    );
                    

                    
                    if ($this->user_model->add($data_user)) {
                        $orderUser = $this->db->insert_id();

                        $this->user_model->update(array('use_slug'=>$orderUser), "use_id = ".(int)$orderUser);

                        $this->session->set_userdata('password', $pass);
                        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                        $dataShopRegister = array(
                            'sho_name' => !empty($data_user['use_fullname']) ? trim($data_user['use_fullname']) . ' Shop' : 'Gian hàng trên Azibai',
                            'sho_descr' => '',
                            'sho_address' => '',
                            'sho_link' => $phone_buy,
                            'sho_logo' => 'default-logo.png',
                            'sho_dir_logo' => 'defaults',
                            'sho_banner' => 'default-banner.jpg',
                            'sho_dir_banner' => 'defaults',
                            'sho_province' => 0,
                            'sho_district' => '',
                            'sho_category' => 0,
                            'sho_phone' => $phone_buy,
                            'sho_mobile' => $phone_buy,
                            'sho_user' => $orderUser,
                            'sho_view' => 1,
                            'sho_status' => 1,
                            'sho_style' => 2,
                            'sho_email' => '',
                            'shop_type' => 2,
                            'sho_begindate' => $currentDate
                        );
                        $this->shop_model->add($dataShopRegister);
                    }
                    
                }
                

                if (!empty($orderUser)) 
                {
                    $productList = $order_temp['productList'];

                    foreach ($productList as $key => &$cItems) {
                        
                        $total = 0;
                        $shipping_fee = 0;
                        $order_af_id = 0;
                        $total_price_voucher = 0;
                        foreach ($cItems['product'] as $k => $cp) {
                            $cItems['product'][$k]->stock = true;
                            // Build product price
                            $productInfo = $this->product_model->get('pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate, pro_cost, is_product_affiliate '. DISCOUNT_QUERY, 'pro_id = '. (int)$cp->pro_id .' AND pro_status = 1');
                            
                            if ($cp->dp_id > 0) {
                                $productInfo = $this->product_model->getProAndDetailForCheckout('pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate, (dp_cost) AS pro_cost, is_product_affiliate, T2.*'. DISCOUNT_DP_QUERY, 'pro_id = '. (int)$cp->pro_id .' AND pro_status = 1', (int)$cp->dp_id);
                            }
                            
                            if (empty($productInfo)) {
                                $cItems['product'][$k]->stock = false;
                                continue;
                            }

                            $wholesale = false;
                            if ($this->session->userdata('sessionUser') > 0) {
                                // Check if login user is saler shop
                                $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                                $wholesale = $shopInfo->shop_type > 0 ? true : false;
                            }
                            if ($wholesale) {
                                if ($cp->store_type == 0) {
                                    // retailer shop
                                    unset($cItems['product'][$k]);
                                    continue;
                                } elseif ($cItems['product'][$k]->qty < $cp->qty_min) {
                                    $cItems['product'][$k]->qty = $cp->qty_min;
                                }
                            }

                            $afSelect = false;
                            $cItems['product'][$k]->af_user = $cp->af_id;
                            if (!empty($cp->af_id) && $order_af_id == 0)
                            {
                                $order_af_id = $cp->af_id;
                            }

                            if ($cp->af_id > 0 && $productInfo->is_product_affiliate == 1) {
                                $afSelect = true;
                            }
                            $priceInfo = lkvUtil::buildPrice($productInfo, $this->session->userdata('sessionGroup'), $afSelect);

                            $cItems['product'][$k]->pro_price_original = $productInfo->pro_cost;
                            $cItems['product'][$k]->pro_price = $priceInfo['salePrice'];
                            //print_r($priceInfo);
                            $cItems['product'][$k]->pro_price_rate = 0;
                            $cItems['product'][$k]->pro_price_amt = 0;
                            $cItems['product'][$k]->pro_category = $productInfo->pro_category;
                            if ($priceInfo['saleOff'] > 0) {
                                if ($productInfo->off_rate > 0) {
                                    $cItems['product'][$k]->pro_price_rate = $productInfo->off_rate;
                                } else {
                                    $cItems['product'][$k]->pro_price_amt = $productInfo->off_amount;
                                }
                            }
                            $cItems['product'][$k]->af_rate = $productInfo->af_rate_ori;
                            $cItems['product'][$k]->af_amt = $productInfo->af_amt_ori;
                            $cItems['product'][$k]->dc_amt = 0;
                            $cItems['product'][$k]->dc_rate = 0;
                            if ($priceInfo['em_off'] > 0) {
                                $cItems['product'][$k]->dc_amt = $productInfo->dc_amt;
                                $cItems['product'][$k]->dc_rate = $productInfo->dc_rate;
                            }
                            $cItems['product'][$k]->affiliate_discount_amt = 0;
                            $cItems['product'][$k]->affiliate_discount_rate = 0;

                            if ($priceInfo['af_off'] > 0) {
                                if ($cItems['product'][$k]->af_rate > 0) {
                                    
                                    $cItems['product'][$k]->affiliate_discount_rate = (int) $cItems['product'][$k]->af_dc_rate;

                                } else {
                                    $cItems['product'][$k]->affiliate_discount_amt = (int) $cItems['product'][$k]->af_dc_amt;
                                }
                            }

                            $cItems['product'][$k]->em_promo = 0;
                            if ($productInfo->pro_user != $this->session->userdata('sessionUser')) 
                            {
                                $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $productInfo->pro_id, 'qty' => $cItems['product'][$k]->qty, 'total' => ($cItems['product'][$k]->pro_price * $cItems['product'][$k]->qty)));
                                if (!empty($promotion)) {
                                    if ($promotion['dc_rate'] > 0) {
                                        $cItems['product'][$k]->em_promo = $cItems['product'][$k]->pro_price * $cItems['product'][$k]->qty * $promotion['dc_rate'] / 100;
                                    } else {
                                        $cItems['product'][$k]->em_promo = $promotion['dc_amt'];
                                    }
                                }
                            }
                            // get shop type
                            $cItems['product'][$k]->shc_saler_store_type = $cp->store_type;
                            $total += ($cItems['product'][$k]->pro_price * $cItems['product'][$k]->qty) - $cItems['product'][$k]->em_promo;
                        }


                        foreach ($cItems['listVoucher'] as $k_voucher => $v_voucher) {
                            $total_price_voucher += $v_voucher['price_voucher'];
                        }
                        
                        if ($payment_method == 'info_cod' && $company != 'SHO' && array_key_exists($company, $cItems['nhanh_shipping']))
                        {
                           $total += $cItems['nhanh_shipping'][$company]->totalFee;
                           $shipping_fee = $cItems['nhanh_shipping'][$company]->totalFee;
                           $order_serviceID = $cItems['nhanh_shipping'][$company]->serviceId;
                           $shipping_method = 'Nhanh.vn - ' . $cItems['nhanh_shipping'][$company]->carrierName;
                           $shipping_info = json_encode($cItems['nhanh_shipping'][$company]);

                        }
                        else
                        {
                            $total += $cItems['shipping']['ServiceFee'];
                            $shipping_fee = $cItems['shipping']['ServiceFee'];
                            $order_serviceID = $cItems['shipping']['ServiceID'];
                            $shipping_method = $cItems['shipping']['ServiceID'];
                        }

                        $total -= (int) $total_price_voucher;
                        if ($total < 0) 
                        {
                            $total = 0;
                        }
                        $orderInfo = array(
                            'date' => time(),
                            'payment_method' => $payment_method,
                            'shipping_method' => $shipping_method,
                            'order_user' => $orderUser,
                            'shipping_fee' => $shipping_fee,
                            'order_saler' => $key,
                            'af_id' => $order_af_id,
                            'order_serviceID' => $cItems['shipping']['ServiceID'],
                            'order_total' => $total,
                            'order_total_no_shipping_fee' => $total - $shipping_fee,
                            'change_status_date' => time(),
                            'payment_status' => '0',
                            'token' => "",
                            'order_code' => time() . '_' . rand(100, 9999),
                            'other_info' => "",
                            'order_token' => md5(time() . rand()),
                            'order_group_id' => 0,
                            'order_user_sale' => 0,
                            'shipping_info' => !empty($shipping_info) ? $shipping_info : ''
                        );

                        $orderInfo['product_type'] = $order_temp['type'] == 'product' ? 0 : 2;

                        if ($order_temp['type'] != 'product') {
                            unset($orderInfo['shipping_method']);
                            unset($orderInfo['shipping_fee']);
                            unset($orderInfo['order_serviceID']);
                        }

                        $order_id = $this->order_model->makeOrder($orderInfo);
                        
                        if ($order_id > 0) {

                            // save log voucher
                            if (!empty($cItems['listVoucher'])) 
                            {
                                $this->load->model('package_user_model');
                                foreach ($cItems['listVoucher'] as $k_voucher => $v_voucher) {
                                    $log_voucher = array(
                                        'order_id' => $order_id,
                                        'pro_id'   => $v_voucher['product_use'],
                                        'voucher'  => $k_voucher,
                                        'price_voucher' => $v_voucher['price_voucher'],
                                        'content'  => json_encode($v_voucher),
                                        'created_at' => date('Y-m-d H:i:s'), 
                                        'updated_at' => date('Y-m-d H:i:s')
                                    );
                                    $this->order_voucher_model->add($log_voucher);
                                    $this->package_user_model->updateStatusOrder($k_voucher, 1);
                                }
                            }
                           
                            $result['data'][] = array(
                                'order_id' => $order_id,
                                'order_token' => $orderInfo['order_token'],
                                'sho_name' => $cItems['info']['sho_name'],
                                'sho_link' => $cItems['info']['domain'] != '' ?  $protocol . $cItems['info']['domain'] : $protocol . $cItems['info']['sho_link'] . '.' . $domainName,
                                'order_link' => '/information-order/'. $order_id .'?order_token=' . $orderInfo['order_token'],
                                'pro_type' => $order_temp['type'] == 'product' ? 0 : 2,
                            );


                            // save user receive
                            $data_user_receive = array(
                                'use_id' => $orderUser,
                                'order_id' => $order_id,
                                'ord_sname' => $address->name,
                                'ord_saddress' => $address->address,
                                'ord_province' => $address->province,
                                'ord_district' => $address->district_code,
                                'ord_semail' => $address->semail,
                                'ord_smobile' => $address->phone,
                                'ord_note' => $note_order[$key]
                            );
                            $this->user_receive_model->add($data_user_receive);

                            // save order detail (showcard)
                            $productListFee = [];

                            foreach ($cItems['product'] as $kpro => $pro) {
                                $list_remove_session[$pro->key] = array(
                                    'qty' =>$pro->qty
                                );
                                
                                $shc_saler_parent = 0;
                                $shc_saler_parent_group = 0;
                                if ($pro->pro_user > 0) {
                                    $salerParent = $this->user_model->get("*", "use_id = {$pro->pro_user}");
                                    $shc_saler_parent = $salerParent->parent_id;
                                    $shc_saler_parent_group = $salerParent->use_group;
                                } else {
                                    $shc_saler_parent = 0;
                                    $shc_saler_parent_group = 0;
                                }
                                if ($this->session->userdata('sessionUser') > 0) {
                                    $buyerParent = $this->user_model->get("*", "use_id = {$this->session->userdata('sessionUser')}");
                                    $shc_buyer_parent = $buyerParent->parent_id;
                                } elseif ($user->parent_id > 0) {
                                    $shc_buyer_parent = $user->parent_id;
                                } else {
                                    $shc_buyer_parent = 0;
                                }
                                $af_id_parent = 0;
                                if ($pro->af_user > 0) {
                                    $afParent = $this->user_model->get("*", "use_id = {$pro->af_user}");
                                    $af_id_parent = $afParent->parent_id;
                                }
                                if ($this->session->userdata('sessionGroup') > 0) {
                                    $shc_buyer_group = (int)$this->session->userdata('sessionGroup');
                                } elseif ($user->use_group > 0) {
                                    $shc_buyer_group = $user->use_group;
                                } else {
                                    $shc_buyer_group = 1;
                                }
                                $shc_buyer = 0;
                                if ($this->session->userdata('sessionUser') > 0) {
                                    $shc_buyer = (int)$this->session->userdata('sessionUser');
                                } elseif ($userid > 0) {
                                    $shc_buyer = $userid;
                                }
                                if ($pro->shipping_fee <= 0) {
                                    $pro->shipping_fee = 0;
                                }

                                $order_type = $pro->shc_saler_store_type;
                                if ($order_type == 2) {
                                    if ($productInfo->pro_minsale <= $pro->qty) {
                                        $order_type = 1;
                                    } else {
                                        $order_type = 0;
                                    }
                                }
                                $orderDetail = array(
                                    'shc_product' => $pro->pro_id,
                                    'shc_dp_pro_id' => $pro->dp_id,
                                    'shc_quantity' => $pro->qty,
                                    'pro_category' => $pro->pro_category,
                                    'shc_saler' => $pro->pro_user,
                                    'shc_buyer' => $shc_buyer,
                                    'shc_saler_parent' => $shc_saler_parent,
                                    'shc_buyer_parent' => $shc_buyer_parent,
                                    'shc_buyer_group' => $shc_buyer_group,
                                    'shc_buydate' => time(),
                                    'shc_process' => 0,
                                    'shc_orderid' => $order_id,
                                    'shc_status' => '01',
                                    'shc_change_status_date' => time(),
                                    'shc_saler_store_type' => $order_type,
                                    'em_discount' => $pro->em_promo,
                                    'shc_total' => $pro->pro_price * $pro->qty - $pro->em_promo,
                                    'af_amt' => $pro->af_amt,
                                    'af_rate' => $pro->af_rate,
                                    'dc_amt' => $pro->dc_amt,
                                    'dc_rate' => $pro->dc_rate,
                                    'affiliate_discount_amt' => $pro->affiliate_discount_amt,
                                    'affiliate_discount_rate' => $pro->affiliate_discount_rate,
                                    'pro_price' => $pro->pro_price,
                                    'pro_price_original' => $pro->pro_price_original,
                                    'pro_price_rate' => $pro->pro_price_rate,
                                    'pro_price_amt' => $pro->pro_price_amt,
                                    'af_id' => $pro->af_user,
                                    'af_id_parent' => $af_id_parent,
                                    'shc_group_id' => 0,
                                    'shc_user_sale' => 0,
                                    'fl_id' => $pro->fl_id
                                );
                                if ($this->showcart_model->add($orderDetail)) {
                                    $productListFee[] = array(
                                        "id" => $pro->pro_id,
                                        "quantity" => $pro->qty,
                                        "name" => $pro->pro_name,
                                        "price" => $pro->pro_price,
                                        "description" => json_encode($orderDetail)
                                    );
                                    $this->product_model->updateProBuy($pro->pro_id, $pro->qty);
                                }
                            }

                            // send api nhanh
                            $shop_nhanh = $this->shop_nhanh_model->get('*', 'sho_id =' . (int) $cItems['info']['sho_id']);

                            if ($company != 'SHO' && array_key_exists($company, $cItems['nhanh_shipping']) && !empty($productListFee) && !empty($shop_nhanh))
                            {  
                                $storeId = null;
                                $nhanh_data = array(
                                    "id" => $order_id,
                                    "status" => "Confirmed", // New | Confirmed
                                    "carrierId" => $cItems['nhanh_shipping'][$company]->carrierId, //
                                    "carrierServiceId" => $cItems['nhanh_shipping'][$company]->serviceId, //
                                    "customerShipFee" => $cItems['nhanh_shipping'][$company]->shipFee,
                                    "shipFee"       => $cItems['nhanh_shipping'][$company]->shipFee,
                                    "description" => !empty($note_order[$key]) ? $note_order[$key]: "",
                                    "autoSend" => 1,
                                    "fromCityName" => $cItems['nhanh_data']['fromCityName'],
                                    "fromDistrictName" => $cItems['nhanh_data']['fromDistrictName'],
                                    "weight" => $cItems['nhanh_data']['shippingWeight'], // in gram
                                    "width" => null,
                                    "height" => null,
                                    "length" => null,
                                    "customerName" => $address->name,
                                    "customerMobile" => $address->phone,
                                    "customerEmail" => $address->semail,
                                    "customerCityName" => $cItems['nhanh_data']['toCityName'],
                                    "customerDistrictName" => $cItems['nhanh_data']['toDistrictName'],
                                    "customerAddress" => $address->address,
                                    "productList" => $productListFee,
                                );

                                if ($payment_method == 'info_cod') 
                                {
                                    $nhanh_data['paymentMethod'] = 'COD';
                                    $this->order_nhanhvn_model->add(['order_id'=> $order_id, 'content' => json_encode($nhanh_data), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                    // $this->addNhanhOrder($nhanh_data, $shop_nhanh, $storeId);
                                } 
                                else
                                {
                                    // $nhanh_data['paymentMethod'] = 'Gateway';
                                    // $this->order_nhanhvn_model->add(['order_id'=> $order_id, 'content' => json_encode($nhanh_data), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                                }                                
                            }

                            
                            if ($payment_method == 'info_momo') 
                            {
                                $result['reponse_momo'] = $this->order_momo($cItems['info']['sho_id'], $order_id, $total);
                            }
                            else if ($payment_method == 'info_nganluong_bank' || $payment_method == 'info_nganluong_visa') 
                            {
                                $result['reponse_nganluong'] = $this->order_nganluong($cItems['info']['sho_id'], $order_id, $total, $payment_method, $bankcode, $orderUser);
                            }
                                                      
                            // sendmail
                            $this->sendmailOrder($order_id);
                        }
                    }

                    // save user receive order
                    if ($address->new == 1) 
                    {
                        $data_user_receive = array(
                            'use_id' => $orderUser,
                            'name' => $address->name,
                            'address' => $address->address,
                            'province' => $address->province,
                            'district' => $address->district,
                            'semail' => $address->semail,
                            'phone' => $address->phone,
                            'full_address' => $address->full_address,
                            'active' => $address->active,
                        );
                        if ($address->active == 1)
                        {
                            $this->user_order_receive_model->update( array('active' => 0), 'use_id = '. $orderUser);
                        }
                        $this->user_order_receive_model->add($data_user_receive);
                    } 
                }
            }
        }

        if (!empty($result['data'])) {
            $total_num = 0;
            foreach ($cart as $k_cart => &$cItems) 
            {
                foreach ($cItems as $k => $cp) 
                {
                    $order_total = (int) $cp['qty'];
                    if (array_key_exists($cp['key'], $list_remove_session)) 
                    {
                        $order_buy = (int) $list_remove_session[$cp['key']]['qty'];
                        if ($order_buy < $order_total) 
                        {
                            $order_total = $order_total - $order_buy;
                            $cItems[$k]['qty'] = $order_total;
                        }
                        else
                        {
                            $order_total = 0;
                            unset($cItems[$k]);
                        }
                    }
                    $total_num += (int) $order_total; 
                }
            }
            if ($order_temp['type'] == 'product') {
                $this->session->set_userdata('cart', $cart);
            } else {
                $this->session->set_userdata('cart_coupon', $cart);
            }
            $this->session->unset_userdata($key_oder);
            $result['error'] = false; 
            $result['total'] = $total_num; 
        }
        echo json_encode($result);
        exit();
    }

    public function order_momo ($sho_id, $order_id, $total) 
    {
        // send api momo
        $shop_momo = $this->shop_momo_model->get('*', 'sho_id =' . (int) $sho_id);
        
        if (!empty($shop_momo)) 
        {
            $endpoint = END_POINT;
            $partnerCode = $shop_momo->partner_code;
            $accessKey = $shop_momo->access_key;
            $serectkey = $shop_momo->serect_key;
            $orderInfo = "Thanh toán đơn hàng " . $order_id;
            $returnUrl = base_url() . 'v-checkout/orders-notify';
            $notifyurl = base_url() . 'v-checkout/update-orders-momo';
            $amount = $total."";
            $orderid = time() .'-'. $order_id."";
            $requestId = time() .'-'. $order_id."";
            $requestType = "captureMoMoWallet";
            $extraData = "";
            $rawHash = "partnerCode=".$partnerCode."&accessKey=".$accessKey."&requestId=".$requestId."&amount=".$amount."&orderId=".$orderid."&orderInfo=".$orderInfo."&returnUrl=".$returnUrl."&notifyUrl=".$notifyurl."&extraData=".$extraData;

            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data_momo =  array(
                'partnerCode' => $partnerCode,
                'accessKey' => $accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderid,
                'orderInfo' => $orderInfo,
                'returnUrl' => $returnUrl,
                'notifyUrl' => $notifyurl,
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            return $this->execPostRequest($endpoint, json_encode($data_momo));
        }
        return false;
    }

    public function order_nganluong ($sho_id, $order_id, $total, $payment_method, $bankcode, $orderUser) 
    {
        // send api momo
        $shop_nganluong = $this->shop_nganluong_model->get('*', 'sho_id =' . (int) $sho_id);
        
        if (!empty($shop_nganluong)) 
        {
            $this->load->model('nganluong_model');
            $this->nganluong_model->set_variable($shop_nganluong->merchant_id, $shop_nganluong->merchant_pass, $shop_nganluong->receiver);
            $user_info = $this->user_model->get('*', 'use_id = ' . $orderUser);

            $payment_method = $payment_method;
            $bank_code = $bankcode; // done
            $total_amount = $total.""; // done
            $order_id = time() .'-'. $order_id."";   // done
            $return_url = base_url() . 'v-checkout/orders-notify';
            $cancel_url = base_url() . 'v-checkout/orders-notify?cancel-order='. $order_id;
            
            $array_items = array();
            $fee_shipping = 0;
            $order_description = "";
            $order_code = $order_id;
            $payment_type = 1;
            $discount_amount = 0;
            $tax_amount = 0;
            $buyer_fullname = $user_info->use_fullname;
            $buyer_email = !empty($user_info->use_email) ? $user_info->use_email : 'info@azibai.com';
            $buyer_mobile = $user_info->use_mobile;
            $buyer_address = $user_info->use_address;

            if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {

                if ($payment_method == 'info_nganluong_visa') 
                {
                    $nl_result = $this->nganluong_model->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

                    return $nl_result;

                } 
                else if ($payment_method == 'info_nganluong_bank' && $bank_code != '') 
                {

                    $nl_result = $this->nganluong_model->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount,
                        $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                        $buyer_address, $array_items);

                    return $nl_result;

                }
            }
        }
        return false;
    }

    public function orders_notify() 
    {
        $protocol   = get_server_protocol();
        $result = array(
            'error' => true,
            'order_status' => 0,
            'shop_name'  => '',
            'order_id' => '',
            'name_user' => '',
            'sho_link' => '',
            'order_link' => ''
        );
        $cancel_order = $_REQUEST['cancel-order'];
        if (!empty($cancel_order)) 
        {
            $orderId = explode("-", $cancel_order);

            if (count($orderId) == 2) 
            {
                $getOrder = $this->order_model->get('*', ['id' => (int) $orderId[1] , 'date' => $orderId[0]]);
                if (!empty($getOrder)) 
                {
                    $shopInfo = $this->shop_model->get('sho_id, sho_name, domain, sho_link', 'sho_user = '. $getOrder->order_saler);

                    $result['error'] = false;
                    $result['order_id'] = $getOrder->id; 
                    $result['shop_name'] = !empty($shopInfo) ? $shopInfo->sho_name : '';

                    if (!empty($shopInfo)) 
                    {
                       $result['sho_link'] =  $shopInfo->domain != '' ? $shopInfo->domain : $shopInfo->sho_link . '.' . domain_site;
                    } 
                    $result['order_link'] = '/information-order/'. $getOrder->id .'?order_token=' . $getOrder->order_token;
                }
            }
        }
        else 
        {
            if (!empty($_REQUEST['orderId']) || !empty($_REQUEST['order_code'])) 
            {
                $orderId = !empty($_REQUEST['orderId']) ? explode("-", $_REQUEST['orderId']) :  explode("-", $_REQUEST['order_code']);
                if (count($orderId) == 2) 
                {
                    // $getOrder = $this->order_model->get('*', ['id' => (int) $orderId[1] , 'date' => $orderId[0], 'payment_status' => 0]);

                    $getOrder = $this->order_model->get('*', ['id' => (int) $orderId[1] , 'date' => $orderId[0]]);
                    
                    if (!empty($getOrder)) 
                    {
                        $result['order_id'] = $orderId[1];
                        $shopInfo = $this->shop_model->get('sho_id, sho_name', 'sho_user = '. $getOrder->order_saler);
                        $result['shop_name'] = !empty($shopInfo) ? $shopInfo->sho_name : '';
                        $result['order_link'] = '/information-order/'. $getOrder->id .'?order_token=' . $getOrder->order_token;
                        if (!empty($shopInfo)) 
                        {
                            $result['sho_link'] =  $shopInfo->domain != '' ? $protocol . $shopInfo->domain : $shopInfo->sho_link .'.' . domain_site;
                            $shop_momo = $this->shop_momo_model->get('*', 'sho_id =' . (int) $shopInfo->sho_id);
                            $shop_nganluong = $this->shop_nganluong_model->get('*', 'sho_id =' . (int) $shopInfo->sho_id);
                            if ($getOrder->payment_method == 'info_momo' && !empty($shop_momo)) 
                            {

                                $endpoint = END_POINT;
                                $partnerCode = $shop_momo->partner_code;
                                $accessKey = $shop_momo->access_key;
                                $serectkey = $shop_momo->serect_key;
                                $orderid = $getOrder->date .'-'. $getOrder->id;
                                $requestId = $getOrder->date .'-'. $getOrder->id;
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
                                
                                if (!empty($result_momo)) 
                                {
                                    $result_momo = json_decode($result_momo);
                                    
                                    if (!empty($result_momo) && empty($result_momo->errorCode)) 
                                    {
                                        if($this->order_model->updateStatus($getOrder->id, 1)) 
                                        {
                                            // thành công
                                            $result['order_status'] = 1;
                                            $result['error'] = false;
                                            // post order to nhanhvn 
                                            $check_nhanh = $this->order_nhanhvn_model->get('*', 'active = 0 AND order_id ='. $result['order_id']);
                                            $shop_nhanh = $this->shop_nhanh_model->get('*', 'sho_id =' . (int) $shopInfo->sho_id);
                                            if (!empty($check_nhanh) && !empty($check_nhanh->content) && !empty($shop_nhanh)) 
                                            {
                                                $storeId = null;
                                                $nhanh_data = json_decode($check_nhanh->content, true);
                                                if (is_array($nhanh_data)) 
                                                {   
                                                    $nhanh_data['moneyTransfer'] = $result_momo->amount;
                                                    $this->addNhanhOrder($nhanh_data, $shop_nhanh, $storeId);
                                                }
                                            }
                                        }
                                    } 
                                    else 
                                    {
                                        $result['error'] = false;
                                    }
                                }
                            } 
                            else if ( ($getOrder->payment_method == 'info_nganluong_visa' || $getOrder->payment_method == 'info_nganluong_bank') && !empty($shop_nganluong) && !empty($_REQUEST['token'])) 
                            {
                                
                                $this->load->model('nganluong_model');
                                $this->nganluong_model->set_variable($shop_nganluong->merchant_id, $shop_nganluong->merchant_pass, $shop_nganluong->receiver);
                                $nl_result = $this->nganluong_model->GetTransactionDetail($_REQUEST['token']);

                                if (!empty($nl_result)) 
                                {
                                    if ($nl_result->error_code == '00') 
                                    {
                                        if($this->order_model->updateStatus($getOrder->id, 1, $_REQUEST['token'])) 
                                        {
                                            // thành công
                                            $result['order_status'] = 1;
                                            $result['error'] = false;
                                            
                                            // post order to nhanhvn 
                                            $check_nhanh = $this->order_nhanhvn_model->get('*', 'active = 0 AND order_id ='. $result['order_id']);
                                            $shop_nhanh = $this->shop_nhanh_model->get('*', 'sho_id =' . (int) $shopInfo->sho_id);
                                            if (!empty($check_nhanh) && !empty($check_nhanh->content) && !empty($shop_nhanh)) 
                                            {
                                                $storeId = null;
                                                $nhanh_data = json_decode($check_nhanh->content, true);
                                                if (is_array($nhanh_data)) 
                                                {   
                                                    $nhanh_data['moneyTransfer'] = $nl_result->total_amount;
                                                    $this->addNhanhOrder($nhanh_data, $shop_nhanh, $storeId);
                                                }
                                            }
                                        }
                                    } 
                                    else 
                                    {
                                        $result['error'] = false;
                                    }
                                    
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($result['error'] == true) 
        {
            redirect(base_url(), 'location');
        } 
        else 
        {
            $this->load->model('user_receive_model');
            $get_name = $this->user_receive_model->get('ord_sname', 'order_id ='.$result['order_id']);
            if (!empty($get_name)) 
            {
                $result['name_user'] = $get_name->ord_sname;
            }
            $this->load->view('home/checkout/order_notify', $result);
        }

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

    private function sendmailOrder($order_id)
    {
        $data['order_cart'] = $this->showcart_model->getDetailOrders(['order_id' => $order_id]);

        if ($data['order_cart'][0]->shipping_method == 'GHN' || $data['order_cart'][0]->shipping_method == 'GHTK') 
        {
            $data['_province'] = $this->province_model->fetch('pre_name', "pre_id = " . (int)$data['order_cart'][0]->ord_province, '')[0]->pre_name;
            $data['_district'] = $this->district_model->find_by(array('DistrictCode' => $data['order_cart'][0]->ord_district), 'DistrictName')[0]->DistrictName;
            foreach (json_decode(ServiceID) as $key => $vals)
            {
                if ($key == $data['order_cart'][0]->ghn_ServiceID)
                {
                    $data['timeShip'] = $vals;
                    break;
                }
            }
        }
        else
        {
            $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('vtp_code' => $data['order_cart'][0]->ord_district));
            $data['_province'] = $tinhThanh->ProvinceName;
            $data['_district'] = $tinhThanh->DistrictName;
        }
        $data['settingTitle'] = settingTitle;

        if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type == 0) 
        {
            $this->shop_mail_model->sendingOrderEmailForCustomer($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
        }

        if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type != 0 && $data['order_cart'][0]->order_status != '98') 
        {
            $this->shop_mail_model->sendingOrderEmailForCustomerV2($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
        }

        if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type != 0 && $data['order_cart'][0]->order_status == '98') 
        {
            $title_type = '';
            if ($data['order_cart'][0]->pro_type == 1) 
            {
                $title_type = 'Dịch vụ';
                $ordercode = $data['order_cart'][0]->id;
            } 
            elseif ($data['order_cart'][0]->pro_type == 2) 
            {
                $title_type = 'Coupon';
                $ordercode = $data['order_cart'][0]->order_coupon_code;
            }
            // Noi dung email gui nguoi mua
            $subjectuse_buyer = 'Đơn hàng đã xác nhận';
            $bodyuserbuyer = '';
            $bodyuserbuyer .= '<p><img alt="" src="https://azibai.com/images/logo-azibai.png" class="CToWUd"></p>';
            $bodyuserbuyer .= '<p> Chúc mừng quý khách, đơn hàng của quý khách đã hoàn thành!</p>';
            $bodyuserbuyer .= '<p> Đơn hàng ' . $title_type . ' có mã số <b>' . $ordercode . '</b> đã được xác nhận</p>';
            $bodyuserbuyer .= '<p> Quý khách lưu ý bảo mật mã số này <b>' . $ordercode . '</b>. Đây là mã số dùng để giao dịch tại cửa hàng của chúng tôi!</p>';
            $bodyuserbuyer .= '<hr/>';
            $bodyuserbuyer .= '<h4> Thông tin của quý khách</h4>';
            $bodyuserbuyer .= '<p>Họ và tên: ' . $data['order_cart'][0]->ord_sname . '</p>';
            $bodyuserbuyer .= '<p>Số điện thoại: ' . $data['order_cart'][0]->ord_smobile . '</p>';
            $bodyuserbuyer .= '<p>Email: ' . $data['order_cart'][0]->ord_semail . '</p>';
            $bodyuserbuyer .= '<p>Cảm ơn quý khách đã mua sản phẩm của chúng tôi!</p>';
            $bodyuserbuyer .= '<hr/>';
            $bodyuserbuyer .= '<p style="line-height:24px;color:#2a2a2a;margin-top:10px;display:block">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI, AZIBAI.COM<br> ' . settingAddress_1 . '<br> Liên hệ: Số điện thoại <span style="color:#666">' . settingPhone . '</span> - Email <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a></p>';
            $bodyuserbuyer .= '<img alt="Banking" src="https://azibai.com/templates/home/images/dichvuthanhtoan.jpg" />';
            $this->sendEmail($data['order_cart'][0]->ord_semail, GUSER, $bodyuserbuyer, $attachment = '', $from_name = "Azibai.com", $subjectuse_buyer);//to from body
        }
        if ($data['order_cart'][0]->pro_type == 0) 
        {
            $this->shop_mail_model->sendingOrderEmailForShop($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
        }
    } 

    private function sendEmail($to, $from, $body, $attachment = '', $from_name = "Azibai.com", $subject = "")
    {
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.pop3.php');
        return $this->shop_mail_model->smtpmailer($to, $from, $from_name, $subject, $body, $attachment);
    }

    function generateRandomString($length = 6)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_voucher() 
    {  
        $voucher = $this->input->post('voucher');
        $key_order = $this->input->post('key_order');
        $order_temp = $this->session->userdata($key_order);

        if (empty($order_temp['productList'])) 
        {
            echo json_encode(array('error' => true, 'msg'=> 'Lỗi hệ thống.')); 
            exit();
        }
        $shop_id = key($order_temp['productList']);

        if (!array_key_exists('listVoucher', $order_temp['productList'][$shop_id])) 
        {
            $order_temp['productList'][$shop_id]['listVoucher'] = array();
            $order_temp['productList'][$shop_id]['typeVoucher'] = 0;
        }

        // đang sử dụng mã giảm giá đó
        if (array_key_exists($voucher, $order_temp['productList'][$shop_id]['listVoucher'])) 
        {
            echo json_encode(array('error' => true, 'msg'=> 'Mã giảm giá đang được sử dụng.')); 
            exit();
        }

        $get_voucher = $this->voucher_model->get($voucher, $shop_id);

        $total = 0;
        $total_price_voucher = 0;
        if (!empty($get_voucher)) 
        {

            if ($get_voucher['product_type'] == 1) 
            {
                if (!empty($order_temp['productList'][$shop_id]['typeVoucher']))
                {
                    if ($order_temp['productList'][$shop_id]['typeVoucher'] == 1) 
                    {
                        echo json_encode(array('error' => true, 'msg'=> 'Loại giảm giá này bạn chỉ sử dụng được 1 mã cho đơn hàng.')); 
                        exit();
                    } 
                    else 
                    {
                        echo json_encode(array('error' => true, 'msg'=> 'Bạn chỉ có thể sử dụng 1 trong 2 loại giảm giá.')); 
                        exit();
                    }
                }
                
                foreach ($order_temp['productList'][$shop_id]['product'] as $k => $cp) 
                {
                    $total += $cp->pro_cost * $cp->qty - $cp->em_discount;
                }

                if ($total < $get_voucher['price_rank']) 
                {
                    echo json_encode(array('error' => true, 'msg'=> 'Áp dụng đơn hàng tối thiểu:'. number_format($get_voucher['price_rank'], 0, ',', '.') . ' VNĐ')); 
                    exit();
                }

                if ($get_voucher['voucher_type'] == 1) 
                {
                    $price_voucher = ($total * $get_voucher['value'])/ 100 ;
                } 
                else 
                {
                    $price_voucher = $get_voucher['value'];
                }
                
                if (empty($order_temp['productList'][$shop_id]['listVoucher'])) 
                {
                    $order_temp['productList'][$shop_id]['typeVoucher'] = $get_voucher['product_type'];
                }

                $price_voucher = (int) $price_voucher > $total ?  $total : (int) $price_voucher;
                $get_voucher['price_voucher'] = (int) $price_voucher;
                $total_price_voucher += (int) $price_voucher;

                $order_temp['productList'][$shop_id]['listVoucher'][$voucher] = $get_voucher;
                $this->session->set_userdata($key_order, $order_temp);
                echo json_encode(array(
                                    'error' => false, 
                                    'msg'=> 'Áp dụng mã giảm giá thành công.', 
                                    'total_price_voucher' => (int) $total_price_voucher,
                                    'shop_id' => $shop_id
                                ));
                exit();
            }
            else if ($get_voucher['product_type'] == 2) 
            {
                $exists_product = false;

                if ($order_temp['productList'][$shop_id]['typeVoucher'] == 1)
                {
                    echo json_encode(array('error' => true, 'msg'=> 'Bạn chỉ có thể sử dụng 1 trong 2 loại giảm giá.')); 
                    exit();
                }

                $list_v_product = $this->voucher_model->productListVoucher($get_voucher['id']);
                
                $list_id_product = [];
                $list_pro_use_voucher = [];

                if (!empty($list_v_product)) 
                {
                    foreach ($list_v_product as $key => $value) 
                    {
                        $list_id_product[] = $value->product_id;
                    }
                }
                $get_voucher['list_id_product'] = $list_id_product;
                

                
                foreach ($order_temp['productList'][$shop_id]['listVoucher'] as $key => $value) 
                {
                    $total_price_voucher += $value['price_voucher'];
                    if (array_key_exists($value['product_use'], $list_pro_use_voucher)) 
                    {
                        $list_pro_use_voucher[$value['product_use']] = $list_pro_use_voucher[$value['product_use']] + 1;
                    }
                    else 
                    {
                        $list_pro_use_voucher[$value['product_use']] = 1;
                    }
                }
                
                foreach ($order_temp['productList'][$shop_id]['product'] as $k => $cp) 
                {
                    if (in_array($cp->pro_id, $list_id_product) && $exists_product == false) 
                    {
                        if (array_key_exists($cp->pro_id, $list_pro_use_voucher)) 
                        {
                            if ($cp->qty > $list_pro_use_voucher[$cp->pro_id]) 
                            {
                                $exists_product = true;
                                $get_voucher['product_use'] = $cp->pro_id;
                            }
                        }
                        else 
                        {
                            $exists_product = true;
                            $get_voucher['product_use'] = $cp->pro_id;
                        }

                        if ($exists_product == true) 
                        {
                            if ($get_voucher['voucher_type'] == 1) 
                            {
                                $price_voucher = ($cp->pro_cost * $get_voucher['value'])/ 100;
                            } 
                            else 
                            {
                                $price_voucher =  $get_voucher['value'];
                            }
                            $price_voucher = (int) $price_voucher > $cp->pro_cost ?  $cp->pro_cost : (int) $price_voucher;
                            $get_voucher['price_voucher'] = (int) $price_voucher;
                            $total_price_voucher += (int) $price_voucher;
                        }
                    }
                }
                
                if(!$exists_product) 
                {
                    echo json_encode(array('error' => true, 'msg'=> 'Mã giảm giá không áp dụng cho sản phẩm này.')); 
                    exit();
                } 
                else 
                {
                    if (empty($order_temp['productList'][$shop_id]['listVoucher'])) 
                    {
                        $order_temp['productList'][$shop_id]['typeVoucher'] = $get_voucher['product_type'];
                    }
                    $order_temp['productList'][$shop_id]['listVoucher'][$voucher] = $get_voucher;
                    $this->session->set_userdata($key_order, $order_temp);
                    echo json_encode(array(
                                    'error' => false, 
                                    'msg'=> 'Áp dụng mã giảm giá thành công.', 
                                    'total_price_voucher' => (int) $total_price_voucher,
                                    'shop_id' => $shop_id
                                ));
                    exit();
                }
            }
        } 
        echo json_encode(array('error' => true, 'msg'=> 'Mã giảm giá không tồn tại.')); 
        exit();
    }

    public function remove_voucher() 
    {
        $voucher = $this->input->post('voucher');
        $key_order = $this->input->post('key_order');
        $order_temp = $this->session->userdata($key_order);

        if (empty($order_temp['productList'])) 
        {
            echo json_encode(array('error' => true, 'msg'=> 'Lỗi hệ thống.')); 
            exit();
        }
        $shop_id = key($order_temp['productList']);
        $total_price_voucher = 0;
        
        if (array_key_exists('listVoucher', $order_temp['productList'][$shop_id])) 
        {
            foreach ($order_temp['productList'][$shop_id]['listVoucher'] as $key => $value) 
            {
                if ($key != $voucher) 
                {
                   $total_price_voucher += $value['price_voucher']; 
               } 
               else 
               {
                   unset($order_temp['productList'][$shop_id]['listVoucher'][$key]);
               }
            }

            $this->session->set_userdata($key_order, $order_temp);
        }

        echo json_encode(array(
                            'error' => false, 
                            'msg'=> 'Hủy mã giảm giá thành công.', 
                            'total_price_voucher' => (int) $total_price_voucher,
                            'shop_id' => $shop_id
                        ));
        exit();
    }

}