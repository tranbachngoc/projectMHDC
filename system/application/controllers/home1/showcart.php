<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Showcart extends MY_Controller
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
        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        

        $url_g_d2 = '';
        if (!empty($this->shopURL))
        {
            
            $grTrade = $this->grouptrade_model->get('*', 'grt_link = "' . trim(strtolower($this->shopURL)) . '" AND grt_status = 1');
            if(empty($grTrade)) {
                $shop  = $this->flatform_model->get("*", "fl_link = '".trim(strtolower($this->shopURL))."'");
                if (!empty($shop)) {
                    $url_g_d2 = 'flatform';
                }  
            }else{
                $url_g_d2 = 'grtshop';
            }
        }
        $data['url_g_d2'] = $url_g_d2;
       
        
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        $data['productCategoryRoot'] = $this->loadProductCategoryRoot(0, 5);
        #BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }
        
        if ($this->session->userdata('sessionUser') > 0) { 
            $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            $data['currentuser'] = $cur_user;            
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

        #END Update counter
        #BEGIN Eye
        /*
        if ($this->session->userdata('sessionUser') > 0) {
            $this->load->model('eye_model');
            $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
            $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
            $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));

        } else {
            array_values($this->session->userdata['arrayEyeSanpham']);
            array_values($this->session->userdata['arrayEyeRaovat']);
            array_values($this->session->userdata['arrayEyeHoidap']);
            $this->load->model('eye_model');
            $data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');
            $data['listeyeraovat'] = $this->eye_model->geteyetypenologin('raovat');
            $data['listeyehoidap'] = $this->eye_model->geteyetypenologin('hoidap');
        }
        */
        #END Eye
        #BEGIN: Ads & Notify Taskbar
        /*$this->load->model('ads_model');
        $this->load->model('notify_model');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;
        $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;*/
        #BEGIN: Notify
        /*$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");*/
        #END Notify
        /*$data['menuType'] = 'product';
        $retArray = $this->loadCategory(0, 0);
        $data['menu'] = $retArray;

        $data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
        $data['productCategoryHot'] = $this->loadCategoryHot(0, 0);*/
        # BEGIN popup right
        # Tin tức
        /*$this->load->model('content_model');
        $select = "not_id, not_title, not_image,not_dir_image, not_begindate";
        $data['listNews'] = $this->content_model->fetch($select, "not_status = 1 AND cat_type = 1", "not_id", "DESC",0, 10);        
        $this->load->model('product_favorite_model');*/
        # Hàng yêu thích
        /*$select = 'prf_id, prf_product, prf_user, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost ';
        $join = 'INNER';
        $table = 'tbtt_product';
        $on = 'tbtt_product_favorite.prf_product = tbtt_product.pro_id';
        $where = 'prf_user = '.(int)$this->session->userdata('sessionUser');
        $data['favoritePro'] = $this->product_favorite_model->fetch_join($select, $join, $table,$on, $where,0,10);*/
        # Hàng gợi ý
        /*$select = "pro_id, pro_name, pro_cost, pro_image, pro_dir,pro_category, ";
        $whereTmp = "pro_status = 1  and is_asigned_by_admin = 1";
        $products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC",0, 10);
        $data['products'] = $products;*/
        # END popup right
        //$this->load->vars($data);
        #END Ads & Notify Taskbar
        #load lib rest api GHN
        /*$this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();*/
    }

    function loadProductCategoryRoot($parent, $level)
    {
        $select = '*';
        $whereTmp = 'cat_status = 1 AND parent_id = '. $parent;
        $category = $this->category_model->fetch($select, $whereTmp, 'cat_order', 'ASC');
        return $category;
    }

    function checkWallet($user_id)
    {
        $localhost = settingLocalhost;
        $username = settingUsername;
        $password = settingPassword;
        $dbname = settingDatabase;
        $link = mysql_connect($localhost, $username, $password);
        if (! $link) {
            die('Could not connect: '. mysql_error());
        }
        mysql_select_db($dbname, $link);
        $query = 'SELECT * FROM jos_sbh_thongkehoahong WHERE user_id = '. $user_id .' AND ispay = 0';
        $result = mysql_query($query);
        $listCommission = array();
        while ($row = mysql_fetch_object($result)) {
            $listCommission[] = $row;
        }
        return $listCommission;
    }

    /*
        (c) sunguyen@icsc.vn
        add san pham vao gio hang
    */

    function add()
    {

        if ($this->input->post('fl_id') != '') {
            $fl_id = $this->input->post('fl_id');
        } else {
            $fl_id = 0;
        }


        if ($this->input->post('af_id') != '') {
            $af_id = $this->input->post('af_id');
        } elseif ($_REQUEST['af_id'] != '') {
            $af_id = $_REQUEST['af_id'];
        } elseif ($this->session->userdata('af_id') != '') {
            $af_id = $this->session->userdata('af_id');
        } elseif (get_cookie('affiliate_id') != '') {            
            $af_id = (int)get_cookie('affiliate_id', TRUE);
        } else {
            $af_id = '';
        }
        
        if ($this->input->get('gr_saler') != '') {
            $gr_saler = $this->input->get('gr_saler');
        } elseif ($this->input->post('gr_saler') != '') {
            $gr_saler = $this->input->post('gr_saler');
        } elseif ($this->session->userdata('gr_saler') != '') {
            $gr_saler = $this->session->userdata('gr_saler');
        } elseif (get_cookie('gr_saler') != '') {            
            $gr_saler = (int)get_cookie('gr_saler', TRUE);
        } else {
            $gr_saler = '';
        }

        $data['fullProductShowcart'] = false;
        if ($this->session->flashdata('sessionFullProductShowcart')) {
            $data['fullProductShowcart'] = true;
        }
        if ($this->input->post('product_showcart') && $this->check->is_id($this->input->post('product_showcart'))) {
            $ajax = false;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $ajax = true;
            }

            // check Product
            $check_product = $this->product_model->get('pro_type', 'pro_id = '. (int)$this->input->post('product_showcart') .' AND pro_status = 1');

            if (empty($check_product)) {
                $result['message'] = 'Sản phẩm không tồn tại';
                echo json_encode($result);
                exit();
            }
            // end check Product 
            


            // New cart
            // Change cart
            $num_all_cart = array();
            if ($check_product->pro_type == 2) {
               $cart = $this->session->userdata('cart_coupon');
               $num_all_cart =  $this->session->userdata('cart');
            } else {
               $cart = $this->session->userdata('cart');
               $num_all_cart =  $this->session->userdata('cart_coupon');
            }
            
            $qty = ($this->input->post('qty')) ? $this->input->post('qty') : 1;
            $dp_id = ($this->input->post('dp_id')) ? (int)$this->input->post('dp_id') : 0;
            // Sale from Group
            $gr_id = ($this->input->post('gr_id')) ? (int)$this->input->post('gr_id') : 0;
            $gr_user = ($gr_saler != '') ? (int)$this->user_model->get('use_id', 'af_key LIKE "%'. $gr_saler .'%"')->use_id : 0;            

            if (empty($cart)) {
                $cart = array();
            }
            // Count num product
            $num = 0;
            $result = array();
            $numPro = $qty;
            // Case cart existed pro_id, add number product
            if ($dp_id > 0) {
                //Nếu sẩn phẩm có Trường Qui Cách, kiểm tra id TQC
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == (int)$this->input->post('product_showcart') && $itemCart['dp_id'] == $dp_id) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            } else {
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == (int)$this->input->post('product_showcart')) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            }

            foreach ($num_all_cart as $item) {
                if (!empty($item)) {
                    foreach ($item as $itemCart) {
                        $num += $itemCart['qty'];
                    }
                }
            }

            if ($num + $qty <= settingOtherShowcart && $qty > 0) {
                if ($dp_id > 0) {
                    //Exist Trường Qui Cách
                    $product = $this->product_model->getProAndDetailForCheckout('af_amt, af_rate, dc_amt, dc_rate, (T2.dp_cost) AS pro_cost,  is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_DP_QUERY .', T2.*', 'pro_id = '. (int)$this->input->post('product_showcart') .' AND pro_status = 1', $dp_id);
                } else {
                    //Not exist TQC
                    $product = $this->product_model->get('af_amt, af_rate, dc_amt, dc_rate, pro_cost, is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_QUERY, 'pro_id = '. (int)$this->input->post('product_showcart') .' AND pro_status = 1');
                }

                if (count($product) == 1 && $numPro <= $product->pro_instock && $product->pro_user != $this->session->userdata('sessionUser')) {

                    /**
                     * Xóa coupon va dich vu truoc khi them moi
                     */
                    // if ($product->pro_type > 0) {
                    //     foreach ($cart as $key => $item) {
                    //         foreach ($item as $key2 => $productItem) {
                    //             if ($productItem['pro_type'] > 0) {
                    //                 unset($item[$key2]);
                    //             }
                    //         }
                    //         if (count($item) == 0) {
                    //             unset($cart[$key]);
                    //         }
                    //     }
                    // }

                    if ($product->shop_info != '') {
                        $tmp = explode(';', $product->shop_info);
                        foreach ($tmp as $tmp_item) {
                            $val = explode(':', $tmp_item);
                            $val[0] = trim($val[0]);
                            $product->$val[0] = $val[1];
                        }
                    }

                    $wholesale = false;
                    if ($this->session->userdata('sessionUser') > 0) {
                        // Check if login user is saler shop
                        $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                        $wholesale = $shopInfo->shop_type > 0 ? true : false;
                    }

                    if ($wholesale == true && $product->shop_type < 1) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Vui lòng chọn sản phẩm của gian hàng bán sỉ';
                    } elseif ($wholesale == true && $numPro < $product->pro_minsale) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn phải mua tối thiểu '. $product->pro_minsale .' sản phẩm';
                    } else {
                        if (!isset($cart[$product->pro_user])) {
                            $cart[$product->pro_user] = array();
                        }
                        // Check exist product
                        $foundProduct = false;
                        $userObject = $this->user_model->get('use_id', 'af_key = "'. $af_id .'"');
                        $af_id = $userObject->use_id > 0 ? $userObject->use_id : 0;

                        if($gr_id > 0 && $gr_user > 0){
                            $af_id = $gr_user;
                        }

                        foreach ($cart[$product->pro_user] as &$pItem) {
                            if ($dp_id > 0) {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['dp_id'] == $product->id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = $product->id;
                                    $foundProduct = true;
                                    break;
                                }
                            } else {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = 0;
                                    $foundProduct = true;
                                    break;
                                }
                            }
                        }

                        if ($foundProduct == false) {
                            $shopItem = array();
                            $afSelect = false;
                            if ($af_id > 0 && $product->is_product_affiliate == 1) {
                                $afSelect = true;
                            }

                            $priceInfo = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                            $shopItem['pro_id'] = $product->pro_id;
                            $shopItem['af_id'] = $af_id;
                            $shopItem['qty'] = $qty;
                            $shopItem['fl_id'] = $fl_id;
                            $shopItem['pro_name'] = $product->pro_name;
                            $shopItem['sho_link'] = $product->sho_link;
                            $shopItem['qty_min'] = $product->pro_minsale;
                            $shopItem['qty_max'] = $product->pro_instock;
                            $shopItem['store_type'] = $product->shop_type;
                            $shopItem['pro_type'] = $product->pro_type;
                            $shopItem['pro_user'] = $product->pro_user;
                            $shopItem['pro_weight'] = $product->pro_weight;
                            $shopItem['pro_length'] = $product->pro_length;
                            $shopItem['pro_width'] = $product->pro_width;
                            $shopItem['pro_height'] = $product->pro_height;
                            $shopItem['pro_price'] = $priceInfo['salePrice'];
                            $shopItem['shipping_fee'] = 0;
                            $shopItem['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                            $shopItem['gr_id'] = ($gr_id > 0) ? $gr_id : 0;
                            $shopItem['gr_user'] = ($gr_user > 0) ? $gr_user : 0;
                            $shopItem['key'] = $product->pro_user .'_'. $product->pro_id .'_'. (count($cart[$product->pro_user]) + 1 .'_'. $shopItem['dp_id']);
                            $shopItem['image'] = 'media/images/product/'. $product->pro_dir .'/'. show_thumbnail($product->pro_dir, $product->pro_image, 1);
                            if (/*!file_exists($shopItem['image']) ||*/ $product->pro_image == ',,,' || $product->pro_image == '') {
                                $shopItem['image'] = 'media/images/noimage.png';
                            }
                            $shopItem['image'] = base_url() . $shopItem['image'];
                            $shopItem['link'] = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                            array_push($cart[$product->pro_user], $shopItem);
                        }

                        if ($check_product->pro_type == 2) {
                           $cart = $this->session->set_userdata('cart_coupon', $cart);
                        } else {
                           $cart = $this->session->set_userdata('cart', $cart);
                        }
                        
                        // Create param callback
                        $_page = '';
                        if ((int)$this->input->post('position') == 3) {
                            $_page = '/affiliate';
                        }                       

                        $strUrl = $this->mainURL;
                        $result['error'] = false;                      
                        
                        $result['message'] = $product->pro_name .' đã được thêm vào giỏ hàng. Xem <a style="color:red;" href="'. $_page .'/v-checkout"><i class="fa fa-shopping-cart fa-fw"></i>giỏ hàng</a>.';

                        $result['num'] = $num + $qty;
                        $result['cart'] = $this->showcart_model->getCart();
                        $result['pro_type'] = $product->pro_type;
                        $result['pro_user'] = $product->pro_user;
                        $result['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                    }
                } elseif ($numPro > $product->pro_instock) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm không đủ đáp ứng yêu cầu của bạn';
                } elseif ($product->pro_user == $this->session->userdata('sessionUser')) {
                    if ($ajax) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn không thể mua sản phẩm của mình bán';
                    } else {
                        $this->session->set_flashdata('error', 'Bạn không thể mua sản phẩm của mình bán.');
                    }
                }
            } else {
                if ($ajax) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng quy định.';
                } else {
                    $this->session->set_flashdata('sessionFullProductShowcart', 1);
                }
            }
            
            if ($ajax) {                
                // Add Cart success, return result data  , AddCart & BuyNow             
                echo json_encode($result);
                exit();
            } else {
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add in showcart
        $key_cart = $this->uri->segment(3);
        redirect(base_url() .'showcart/'. $key_cart);
    }

    /*
        (c) sunguyen@icsc.vn
        thanh toan gio hang
    */

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

    function order_cart()
    {
        $currentDate = time(); //mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        #BEGIN: Delete & add
        if ($this->input->post('checkone')) {
            $deleteProduct = $this->input->post('checkone');
            // Added by le van son
            // Get products from cart
            $cart = $this->session->userdata('cart');
            foreach ($deleteProduct as $p) {
                foreach ($cart as &$cItems) {
                    if (!empty($cItems)) {
                        foreach ($cItems as $k => $cp) {
                            if ($cp['key'] == $p) {
                                unset($cItems[$k]);
                            }
                        }
                    }
                }
            }
            $this->session->set_userdata('cart', $cart);
            die("1");
        } else {
            //Update cart qty
            // Added by le van son
            // Get products from cart
            $nganluong = array("payment_method_nganluong" => "", "bankcode" => "");
            if ($_POST['payment_method'] == "info_nganluong") {
                $nganluong["payment_method_nganluong"] = $_POST['payment_method_nganluong'];
                $nganluong["bankcode"] = $_POST["bankcode"];
            }
            $this->session->set_userdata('nganluong', $nganluong);
            $cart = $this->session->userdata('cart');
            $total = 0;
            $this->load->model('product_promotion_model');
            foreach ($cart as &$cItems) {
                if (!empty($cItems)) {
                    foreach ($cItems as $k => $cp) {
                        $cItems[$k]['qty'] = $this->input->post($cp['key']);
                        $cItems[$k]['stock'] = true;
                        // Build product price
                        $productInfo = $this->product_model->get("pro_category, pro_id, pro_user, pro_buy, af_amt, af_rate, dc_amt, dc_rate,  pro_cost, is_product_affiliate " . DISCOUNT_QUERY, "pro_id = " . (int)$cp['pro_id'] . "  AND pro_status = 1");
                        //print_r($productInfo);
                        if (empty($productInfo)) {
                            $cItems[$k]['stock'] = false;
                            continue;
                        }
                        $wholesale = false;
                        if ($this->session->userdata('sessionUser') > 0) {
                            // Check if login user is saler shop
                            $shopInfo = $this->shop_model->get("shop_type", "sho_user =" . $this->session->userdata('sessionUser'));
                            $wholesale = $shopInfo->shop_type > 0 ? true : false;
                        }
                        if ($wholesale) {
                            if ($cp['store_type'] == 0) {
                                // retailer shop
                                unset($cItems[$k]);
                                continue;
                            } elseif ($cItems[$k]['qty'] < $cp['qty_min']) {
                                $cItems[$k]['qty'] = $cp['qty_min'];
                            }
                        }
                        $afSelect = false;
                        $cItems[$k]['af_user'] = $cp['af_id'];
                        if ($cp['af_id'] > 0 && $productInfo->is_product_affiliate == 1) {
                            $afSelect = true;
                        }
                        $priceInfo = lkvUtil::buildPrice($productInfo, $this->session->userdata('sessionGroup'), $afSelect);
                        $cItems[$k]['pro_price_original'] = $productInfo->pro_cost;
                        $cItems[$k]['pro_price'] = $priceInfo['salePrice'];
                        //print_r($priceInfo);
                        $cItems[$k]['pro_price_rate'] = 0;
                        $cItems[$k]['pro_price_amt'] = 0;
                        $cItems[$k]['pro_category'] = $productInfo->pro_category;
                        if ($priceInfo['saleOff'] > 0) {
                            if ($productInfo->off_rate > 0) {
                                $cItems[$k]['pro_price_rate'] = $productInfo->off_rate;
                            } else {
                                $cItems[$k]['pro_price_amt'] = $productInfo->off_amount;
                            }
                        }
                        $cItems[$k]['af_rate'] = $productInfo->af_rate;
                        $cItems[$k]['af_amt'] = $productInfo->af_amt;
                        $cItems[$k]['dc_amt'] = 0;
                        $cItems[$k]['dc_rate'] = 0;
                        if ($priceInfo['em_off'] > 0) {
                            $cItems[$k]['dc_amt'] = $productInfo->dc_amt;
                            $cItems[$k]['dc_rate'] = $productInfo->dc_rate;
                        }
                        $cItems[$k]['affiliate_discount_amt'] = 0;
                        $cItems[$k]['affiliate_discount_rate'] = 0;
                        if ($priceInfo['af_off'] > 0) {
                            if ($priceInfo['af_rate'] > 0) {
                                $cItems[$k]['affiliate_discount_rate'] = $priceInfo['af_rate'];
                            } else {
                                $cItems[$k]['affiliate_discount_amt'] = $priceInfo['af_off'];
                            }
                        }
                        // Make discount for member
                        $cItems[$k]['em_promo'] = 0;
                        if (/*$this->session->userdata('sessionGroup') == 3 &&*/
                            $productInfo->pro_user != $this->session->userdata('sessionUser')
                        ) {
                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $productInfo->pro_id, 'qty' => $cItems[$k]['qty'], 'total' => ($cItems[$k]['pro_price'] * $cItems[$k]['qty'])));
                            if (!empty($promotion)) {
                                if ($promotion['dc_rate'] > 0) {
                                    $cItems[$k]['em_promo'] = $cItems[$k]['pro_price'] * $cItems[$k]['qty'] * $promotion['dc_rate'] / 100;
                                } else {
                                    $cItems[$k]['em_promo'] = $promotion['dc_amt'];
                                }
                            }
                        }
                        // get shop type
                        $cItems[$k]['shc_saler_store_type'] = $cp['store_type'];
                        // Phi van chuyeen
                        $cItems[$k]['shipping_fee'] = $cItems[$k]['shipping_fee'];
                        $total += ($cItems[$k]['pro_price'] * $cItems[$k]['qty']) + $cItems[$k]['shipping_fee'] - $cItems[$k]['em_promo'];
                    }
                }
            }
            if ($total != $this->input->post('amount')) {
                echo 'Tổng thanh toán bị lệch, cần kiểm tra lại';
                redirect(base_url() . 'showcart', 'location');
                exit();
            }
            $this->session->set_userdata('cart', $cart);

            #END CHECK LOGIN

            // Tung Add user khi khach mua hang khong dang nhap
            $this->load->library('hash');
            $salt = $this->hash->key(8);
            $pass = $this->generateRandomString();
            $data_user = array(
                'use_username' => $this->input->post('ord_semail'),
                'use_salt' => $salt,
                'use_password' => $this->hash->create($pass, $salt, 'md5sha512'),
                'use_fullname' => $this->input->post('ord_sname'),
                'use_address' => $this->input->post('ord_address'),
                'use_province' => $this->input->post('user_province'),
                'user_district' => $this->input->post('user_district'),
                'use_email' => $this->input->post('ord_semail'),
                'use_status' => 1,
                'use_group' => 1,
                'parent_id' => $productInfo->pro_user,
                'use_regisdate' => time(),
                'use_mobile' => $this->input->post('ord_smobile'),
            );
           
            $user = $this->user_model->get('*', 'use_email = "' . $this->input->post('ord_semail') . '"');

            if ($user->use_id <= 0 && (int)$this->session->userdata('sessionUser') <= 0) {
                $this->user_model->add($data_user);
                $userid = $this->db->insert_id();
                $this->session->set_userdata('password', $pass);
            } elseif ($user->use_id > 0) {
                $userid = $user->use_id;
            }
            $orderUser = 0;
            if ((int)$this->session->userdata('sessionUser') > 0) {
                $orderUser = $this->session->userdata('sessionUser');
            } elseif ($userid > 0) {
                $orderUser = $userid;
            }
            // end

            // Insert order
            $this->load->model('order_model');
            $oderInfo = array(
                'date' => time(),
                'payment_method' => $this->input->post('payment_method'),
                'shipping_method' => $this->input->post('company'),
                'order_user' => $orderUser,
                'order_saler' => 0,
                'af_id' => 0,
                'order_total' => $this->input->post('amount'),
                'payment_status' => 0,
                'token' => "",
                'other_info' => ""
            );
            $order_id = $this->order_model->makeOrder($oderInfo);
            if ($order_id > 0) {
                // Insert order item;
                foreach ($cart as &$cItems) {
                    if (!empty($cItems)) {
                        foreach ($cItems as $pro) {
                            $shc_saler_parent = 0;
                            $shc_saler_parent_group = 0;
                            if ($pro['pro_user'] > 0) {
                                $salerParent = $this->user_model->get("*", "use_id = {$pro['pro_user']}");
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
                            if ($pro['af_user'] > 0) {
                                $afParent = $this->user_model->get("*", "use_id = {$pro['af_user']}");
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
                            if ($pro['shipping_fee'] <= 0) {
                                $pro['shipping_fee'] = 0;
                            }
                            $orderDetail = array(
                                'shc_product' => $pro['pro_id'],
                                'shc_quantity' => $pro['qty'],
                                'pro_category' => $pro['pro_category'],
                                'shc_saler' => $pro['pro_user'],
                                'shc_buyer' => $shc_buyer,
                                'shc_saler_parent' => $shc_saler_parent,
                                'shc_buyer_parent' => $shc_buyer_parent,
                                'shc_buyer_group' => $shc_buyer_group,
                                'shc_buydate' => time(),
                                'shc_process' => 0,
                                'shc_orderid' => $order_id,
                                'shc_status' => '01',
                                'shc_saler_store_type' => $pro['shc_saler_store_type'],
                                'em_discount' => $pro['em_promo'],
                                'shc_total' => $pro['pro_price'] * $pro['qty'] - $pro['em_promo'],
                                'af_amt' => $pro['af_amt'],
                                'af_rate' => $pro['af_rate'],
                                'dc_amt' => $pro['dc_amt'],
                                'dc_rate' => $pro['dc_rate'],
                                'affiliate_discount_amt' => $pro['affiliate_discount_amt'],
                                'affiliate_discount_rate' => $pro['affiliate_discount_rate'],
                                'pro_price' => $pro['pro_price'],
                                'pro_price_original' => $pro['pro_price_original'],
                                'pro_price_rate' => $pro['pro_price_rate'],
                                'pro_price_amt' => $pro['pro_price_amt'],
                                'shipping_fee' => $pro['shipping_fee'],
                                'af_id' => $pro['af_user'],
                                'af_id_parent' => $af_id_parent,
                                'ghn_ServiceID' => $pro["ghn_ServiceID"],
                                'shc_code' => $this->rand_string_limit(5)
                            );
                            if ($this->showcart_model->add($orderDetail)) {
                                $this->product_model->updateBuyNum($pro['pro_id']);
                            }
                            unset($orderDetail);
                        }
                    }
                }
                // Add receive
                $time_receive = mktime($this->input->post('ord_hour'), $this->input->post('ord_minute'), 0, $this->input->post('ord_month'), $this->input->post('ord_date'), $this->input->post('ord_year'));
                $_province = $this->province_model->fetch('pre_name', "pre_id = " . $this->input->post('user_province'), '');
                $_district = $this->district_model->find_by(array('DistrictCode' => $this->input->post('user_district')), 'DistrictName');
                $data_user_receive = array(
                    'use_id' => $orderUser,
                    'order_id' => $order_id,
                    'ord_sname' => $this->input->post('ord_sname'),
                    'ord_saddress' => $this->input->post('ord_address') . ' ' . $_province[0]->pre_name . ' ' . $_district[0]->DistrictName,
                    'ord_province' => $this->input->post('user_province'),
                    'ord_district' => $this->input->post('user_district'),
                    'ord_semail' => $this->input->post('ord_semail'),
                    'ord_smobile' => $this->input->post('ord_smobile'),
                    'ord_time_receive' => $time_receive
                );
                $this->load->model('user_receive_model');
                $this->user_receive_model->add($data_user_receive);
                $this->session->set_flashdata('_orders', $order_id);//store session order
                //Clear cart
                $this->session->set_userdata('cart', array());
                redirect(base_url() . 'orders-success');
            }
        }
        #END Delete & add
    }

    function index()
    {
        //$this->session->unset_userdata();
        //$this->session->set_userdata('cart', array());
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if ($this->session->userdata('sessionGroup') == 0 || $this->session->userdata('sessionGroup') == 1 || $this->session->userdata('sessionGroup') == 2 || $this->session->userdata('sessionGroup') == 3) {
        } else {
            redirect(base_url());
        }
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
        }
        #BEGIN: Menu
        $productShowcarts = array();
        $this->load->model('payment_model');
        $this->load->model('shipping_model');
        //$this->session->unset_userdata('quantityProductSession');
        if ($this->input->post('quantityProduct') && $this->session->userdata('quantityProductSession')) {
            $pro_quantity = $this->session->userdata('quantityProductSession');
            unset($pro_quantity[$this->input->post('productId')]);
            $pro_quantity[$this->input->post('productId')] = $this->input->post('quantityProduct');
            $this->session->set_userdata('quantityProductSession', $pro_quantity);
        }
        // Added by le van son
        // Get products from cart
        $cart = $this->session->userdata('cart');
        // Remove shop order product if exists
        if ($this->session->userdata('sessionUser') > 0) {
            $updateCart = false;
            // Check if login user is saler shop
            $shopInfo = $this->shop_model->get("shop_type", "sho_user =" . $this->session->userdata('sessionUser'));
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
            if ($updateCart == true) {
                $this->session->set_userdata('cart', $cart);
            }
        }
        $listProduct = array();
        foreach ($cart as $cartItem) {
            if (!empty($cartItem)) {
                foreach ($cartItem as $pItem) {
                    array_push($listProduct, $pItem['pro_id']);
                }
            }
        }
        if (!empty($listProduct)) {
            $where = "pro_id IN(" . implode(',', $listProduct) . ") AND pro_status = 1";
            $sort = '';
            $by = '';
            if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                switch (strtolower($getVar['sort'])) {
                    case 'name':
                        $sort .= "pro_name";
                        break;
                    case 'cost':
                        $sort .= "pro_cost";
                        break;
                    default:
                        $sort .= "pro_id";
                }
                if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                    $by .= "DESC";
                } else {
                    $by .= "ASC";
                }
            }
            #END Sort
            #BEGIN: Create link sort
            $data['sortUrl'] = base_url() . 'showcart/sort/';
            #END Create link sort
            #Fetch record
            $select = "pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate" . DISCOUNT_QUERY;
            $start = 0;
            $limit = settingOtherShowcart;
            $products = $this->product_model->fetch($select, $where, $sort, $by, $start, $limit);
            $this->load->model('product_promotion_model');
            $user = $this->user_model->getDetail("tbtt_user.*,pre_name", "INNER", "tbtt_province", "tbtt_province.pre_id = tbtt_user.use_province", "use_id = " . (int)$this->session->userdata('sessionUser') . " AND use_status = 1 AND (use_enddate >= $currentDate OR use_enddate=0)");
            foreach ($user as $order_user) {
                $data['user'] = $order_user;
            }
            foreach ($products as $pro) {
                foreach ($cart as $key => $cartItems) {
                    if (!empty($cartItems)) {
                        $productList = array();
                        foreach ($cartItems as $cItem) {
                            if ($cItem['pro_id'] == $pro->pro_id) {
                                $pItem = clone $pro;
                                $afSelect = false;
                                if ($cItem['af_id'] != '' && $pro->is_product_affiliate == 1) {
                                    $userObject = $this->user_model->get("use_id", "af_key = '" . $cItem['af_id'] . "'");
                                    if ($userObject->use_id > 0) {
                                        $afSelect = true;
                                    }
                                }
                                $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);
                                // Make discount for member
                                $pItem->em_discount = 0;
                                if (/*$this->session->userdata('sessionGroup') == 3 && */
                                    $pro->pro_user != $this->session->userdata('sessionUser')
                                ) {
                                    $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cItem['qty'], 'total' => ($discount['salePrice'] * $cItem['qty'])));
                                    if (!empty($promotion)) {
                                        if ($promotion['dc_rate'] > 0) {
                                            $pItem->em_discount = $discount['salePrice'] * $cItem['qty'] * $promotion['dc_rate'] / 100;
                                        } else {
                                            $pItem->em_discount = $promotion['dc_amt'];
                                        }
                                    }
                                }
                                $pItem->pro_cost = strtoupper(trim($pro->pro_currency)) == 'VND' ? $discount['salePrice'] : $discount['salePrice'] * settingExchange;
                                $pItem->key = $cItem['key'];
                                $pItem->qty = $cItem['qty'];
                                $pItem->shipping_fee = 0;
                                $pItem->qty_min = $cItem['qty_min'];
                                $pItem->qty_max = $cItem['qty_max'];
                                $pItem->store_type = $cItem['store_type'];
                                array_push($productList, $pItem);
                            }
                        }
                        if (!empty($productList)) {
                            if (isset($productShowcarts[$key])) {
                                $productShowcarts[$key]->productShowcart = array_merge($productShowcarts[$key]->productShowcart, $productList);
                            } else {
                                $infoShop = $this->shop_model->get('*', "sho_user = " . (int)$key);
                                $infoPayment = $this->payment_model->get('*', "id_user = " . (int)PAYMENT_USER_ID);
                                $infoShipping = $this->shipping_model->get('*', "id_user = " . (int)$key);
                                $shopInfo = new stdClass;
                                $shopInfo->productShowcart = $productList;
                                $shopInfo->infoShop = $infoShop;
                                $shopInfo->infoPayment = $infoPayment;
                                $shopInfo->infoShipping = $infoShipping;
                                $productShowcarts[$key] = $shopInfo;
                            }
                            if ($data['user']->user_district) {
                                $_province = $this->province_model->fetch('pre_name', "pre_id = " . $data['user']->use_province, '');
                                $_district = $this->district_model->find_by(array('DistrictCode' => $data['user']->user_district), 'DistrictName');
                                if ($shopInfo->infoShop->sho_kho_district) {
                                    $s_district = $shopInfo->infoShop->sho_kho_district;
                                } else {
                                    $s_district = $shopInfo->infoShop->sho_district;
                                }
                                $shipping_fee = $this->getShippingDefault($s_district, $data['user']->user_district, $pro->pro_id, $pItem->qty);
                                $data['shipping_fee'][$pro->pro_id] = array(
                                    'shipping_fee' => $shipping_fee['Items'][0]['ServiceFee'],
                                    'ServiceName' => $shipping_fee['Items'][0]['ServiceName'],
                                    'shipping_address' => $data['user']->use_address,
                                    'shipping_province' => $_province[0]->pre_name,
                                    'shipping_district' => $_district[0]->DistrictName,
                                    'ghn_ServiceID' => $shipping_fee['Items'][0]['ServiceID'],
                                    'ServiceName' => $shipping_fee['Items'][0]['ServiceName']
                                );
                            } else {
                                $data['shipping_fee'][$pro->pro_id] = array(
                                    'shipping_fee' => 0,
                                    'ServiceName' => '',
                                    'shipping_address' => '',
                                    'shipping_province' => '',
                                    'shipping_district' => '',
                                    'ghn_ServiceID' => '',
                                    'ServiceName' => ''
                                );
                            }
                        }
                    }
                }
                foreach ($cart as $keys => $_cItems) {
                    if (!empty($_cItems)) {
                        foreach ($_cItems as $k => $cp) {
                            if ($cp['pro_id'] == $pItem->pro_id) {
                                $cart[$keys][$k]['shipping_fee'] = $shipping_fee['Items'][0]['ServiceFee'];
                                $cart[$keys][$k]['qty'] = $pItem->qty;
                                $cart[$keys][$k]['sho_id'] = $infoShop->sho_id;
                                $cart[$keys][$k]['ghn_ServiceID'] = $data['shipping_fee'][$cp['pro_id']]['ghn_ServiceID'];
                            }
                        }
                    }
                }
            }
            $this->session->set_userdata('cart', $cart);
        }
        // code cu=======================================================================================================
        if ($this->input->is_ajax_request()) {
            $quantityProductSession = (int)$this->input->post('quantityProduct');
            $productId = (int)$this->input->post('productId');
            $product = $this->product_model->get('*', array('pro_id' => $productId));
            if ($quantityProductSession > (int)$product->pro_instock) {
                $response = array(
                    'message' => 'Sản phẩm mua vượt quá số lượng. Tối đa: ' . $product->pro_instock,
                    'pro_instock' => $product->pro_instock,
                    'request_pro_instock' => $quantityProductSession
                );
                //                                    echo json_decode($response);
                echo json_encode($response);
                return true;
            }
            echo NULL;
            return true;
        }
        $data['productShowcarts'] = $productShowcarts;
        $this->session->set_userdata('productShowcarts', $productShowcarts);
        $data['quantityProductSession'] = $this->session->userdata('quantityProductSession');
        #Load view
        $key_cart = $this->uri->segment(2);
        $data['key_cart'] = $key_cart;
        $data['province'] = $this->province_model->fetch();
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => $data['user']->use_province));
        $this->load->view('home/showcart/defaults', $data);
    }

    function _is_exist_product_showcart($product)
    {
        $productShowcart = explode(',', $this->session->userdata('sessionProductShowcart'));
        foreach ($productShowcart as $productShowcartArray) {
            if ($productShowcartArray == $product) {
                return true;
            }
        }
        return false;
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
                // $link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", 0, 5);
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

    function shipfee()
    {
        $shipping_method = $this->input->post('shipping_method');
        $shipfee = 0;
        switch ($shipping_method) {
            case 1:
                $shipfee = 10000;
                break;
            case 2:
                $shipfee = 20000;
                break;
            case 3:
                $shipfee = 30000;
                break;
            default:
                $shipfee = 50000;
                break;
        }
        $shipfee = 0;
        $shipArray = array();
        //Update shipfee to cart
        $cart = $this->session->userdata('cart');
        foreach ($cart as &$cItems) {
            if (!empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    $cItems[$k]['shipping_fee'] = $shipfee;
                    array_push($shipArray, array('key' => $cp['key'], 'shipping_fee' => $shipfee));
                }
            }
        }
        $this->session->set_userdata('cart', $cart);
        echo json_encode($shipArray);
        exit();
    }

    function getPromotion()
    {
        $pro_id = (int)$this->input->post('pro_id');
        $key = $this->input->post('key');
        $qty = (int)$this->input->post('qty');        
        $product = $this->product_model->get('*' . DISCOUNT_QUERY, array('pro_id' => $pro_id));
      
        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), false);
        $em_discount = 0;
        if ($product->pro_user != $this->session->userdata('sessionUser')) {
            $this->load->model('product_promotion_model');
            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $product->pro_id, 'qty' => $qty, 'total' => ($discount['salePrice'] * $qty)));
            if (!empty($promotion)) {
                if ($promotion['dc_rate'] > 0) {
                    $em_discount = $discount['salePrice'] * $qty * $promotion['dc_rate'] / 100;
                } else {
                    $em_discount = $promotion['dc_amt'];
                }
            }
        }
        $total_vc = 0;
        $total_amount = 0;
        $cart = $this->session->userdata('cart');
        foreach ($cart as &$cItems) {
            if (!empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    if ($cp['pro_id'] == $pro_id) {
                        $shop_district = $this->shop_model->find_by(array('sho_id' => $cp['sho_id']), 'sho_district,sho_kho_district');
                        if ($shop_district[0]->sho_kho_district) {
                            $s_district = $shop_district[0]->sho_kho_district;
                        } else {
                            $s_district = $shop_district[0]->sho_district;
                        }
                        $shipfee = $this->getShippingDefault($s_district, $this->input->post('user_district'), $pro_id, $qty);
                        $cItems[$k]['shipping_fee'] = $shipfee['Items'][0]['ServiceFee'];
                        $cItems[$k]['ServiceName'] = $shipfee['Items'][0]['ServiceName'];
                        $cItems[$k]['qty'] = $qty;
                    }
                    $total_vc += $cItems[$k]['shipping_fee'];
                }
            }
        }

        foreach ($this->session->userdata['productShowcarts'] as $values) {
            foreach ($values->productShowcart as $productShowcartArray) {
                if ($pro_id == $productShowcartArray->pro_id) {
                    $_qty = $qty;
                } else {
                    $_qty = $productShowcartArray->qty;
                }
                $total_amount += ($productShowcartArray->pro_cost * $_qty - $productShowcartArray->em_discount);
            }
        }

        $total_amount = $total_amount + $total_vc;
        $this->session->set_userdata('cart', $cart);
        echo json_encode(array('error' => false, 'em_discount' => $em_discount, 'key' => $key, 'shipping' => $shipfee['Items'][0]['ServiceFee'], 'ServiceName' => $shipfee['Items'][0]['ServiceName'], 'pro_id' => $pro_id, 'total_vc' => $total_vc, 'total_amount' => $total_amount));
        exit();
    }

    function updateQty()
    {
        $pro_id = (int)$this->input->post('pro_id');
        $key = $this->input->post('key');
        $qty = (int)$this->input->post('qty');
        $dp_id = (int)$this->input->post('dp_id');
        $shop_id = (int)$this->input->post('shop_id');
        $product = $this->product_model->get('*'. DISCOUNT_QUERY, array('pro_id' => $pro_id));
        if ($dp_id > 0) {
            $product = $this->product_model->getProAndDetailForCheckout('*, (dp_cost) AS pro_cost, T2.*'. DISCOUNT_DP_QUERY, 'pro_id = '. $pro_id .' AND pro_status = 1', $dp_id);
        }

        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), true);
        $em_discount = 0;
        if ($product->pro_user != (int)$this->session->userdata('sessionUser')) {
            $this->load->model('product_promotion_model');
            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $product->pro_id, 'qty' => $qty, 'total' => ($discount['salePrice'] * $qty)));
         
            if (!empty($promotion)) {
                if ($promotion['dc_rate'] > 0) {
                    $em_discount = $discount['salePrice'] * $qty * $promotion['dc_rate'] / 100;
                } else {
                    $em_discount = $promotion['dc_amt'];
                }
            }
        }

        if ($product->pro_type == 2) {
           $cart = $this->session->userdata('cart_coupon');
           $cart_num = $this->session->userdata('cart');
        } else {
           $cart     = $this->session->userdata('cart');
           $cart_num = $this->session->userdata('cart_coupon');
        }
        
        $num = 0;
        $totalWeight = 0;
        foreach ($cart as $key_shop => &$cItems) {
            if ($key_shop == $shop_id && !empty($cItems))
            {
                foreach ($cItems as $k => $cp) {
                    if ($cp['dp_id'] > 0) {
                        if ($cp['pro_id'] == $pro_id && $cp['dp_id'] == $dp_id) {
                            $cItems[$k]['qty'] = $qty;
                        }
                        $num += $cItems[$k]['qty'];
                        $totalWeight += $cp['pro_weight'] * $cItems[$k]['qty'];
                    } else {
                        if ($cp['pro_id'] == $pro_id) {
                            $cItems[$k]['qty'] = $qty;
                        }
                        $num += $cItems[$k]['qty'];
                        $totalWeight += $cp['pro_weight'] * $cItems[$k]['qty'];
                    }
                }
            }else {
                foreach ($cItems as $k => $cp) {
                    $num += $cItems[$k]['qty'];
                }
            }
        }

        foreach ($cart_num as $items) {
            if (!empty($items)) {
                foreach ($items as $k => $cp) {
                    $num += $items[$k]['qty'];
                }
            }
        }
        
        // Check shipping fee
        $feeError = fase;
        $feeAmount = 0;
        $des_district = $this->input->post('user_district');
        
        if ($this->input->post('shop_district')) {
          $shop['district'] =  $this->input->post('shop_district');
        } else {
         $shop =  $this->session->userdata('shop');  
        }
        if ($des_district != '' && $shop['district'] != '') {
            /*$fee = $this->session->userdata('fee');
            if ($fee['Weight'] == $totalWeight && $fee['FromDistrictCode'] == $shop['district'] && $fee['ToDistrictCode'] == $des_district) {
                $shipfee = $fee;
            } else {
                $shipfee = $this->getShippingFee($shop['district'], $des_district, $totalWeight);
                $this->session->set_userdata('fee', $shipfee);
            }*/
            $this->session->unset_userdata('fee_'.$shop_id);
            $shipfee = $this->getShippingFee($shop['district'], $des_district, $totalWeight);
            $this->session->set_userdata('fee_'.$shop_id, $shipfee);

            if (isset($shipfee['ServiceFee'])) {
                $feeAmount = $shipfee['ServiceFee'];
            } else {
                $feeError = true;
            }
        }
        

        if ($product->pro_type == 2) {
           $this->session->set_userdata('cart_coupon', $cart);
        } else {
           $this->session->set_userdata('cart', $cart);
        }

        
        echo json_encode(array('error' => false, 'em_discount' => $em_discount, 'key' => $key, 'num' => $num, 'fee_error' => $feeError, 'fee_amount' => $feeAmount));
        exit();
    }

    function shippingFee()
    {
        $cart = $this->session->userdata('cart');
        $shop_id = (int)$this->input->post('shop_id');
        $num = 0;
        $totalWeight = 0;
        foreach ($cart as $key_shop => &$cItems) {
            if ($key_shop == $shop_id && !empty($cItems))
            {
                foreach ($cItems as $k => $cp) {
                    $num += $cItems[$k]['qty'];
                    $totalWeight += $cp['pro_weight'] * $cItems[$k]['qty'];
                }
            }
        }
        // dd($cart);
        // dd($this->session->userdata('shop'));die;
        // Check shipping fee
        $feeError = false;
        $feeAmount = 0;
        $feeTime = '';
        $des_district = $this->input->post('user_district');
        if ($this->input->post('shop_district')) {
          $shop['district'] =  $this->input->post('shop_district');
        } else {
         $shop =  $this->session->userdata('shop');  
        }
        
        if ($des_district != '' && $shop['district'] != '') {
            /*$fee = $this->session->userdata('fee');
            if ($fee['Weight'] == $totalWeight && $fee['FromDistrictCode'] == $shop['district'] && $fee['ToDistrictCode'] == $des_district) {
                $shipfee = $fee;
            } else {
                $shipfee = $this->getShippingFee($shop['district'], $des_district, $totalWeight);
                $this->session->set_userdata('fee', $shipfee);
            }*/

            $company = $this->input->post('company');
            $this->session->unset_userdata('fee_'.$shop_id);
            if ($company == 'GHN') {
                $shipfee = $this->getShippingFee($shop['district'], $des_district, $totalWeight);
            } elseif ($company == 'GHTK') { 
                // by BaoTran, Case nguoi mua chon ship la GHTK
                $shipfee_ghtk = $this->getGHTKShippingFee($shop['district'], $des_district, $totalWeight);
                $shipfee['ServiceFee'] = $shipfee_ghtk;
                $shipfee['ServiceName'] = "";
                $shipfee['ServiceID'] = "GHTK";

            } elseif ($company == 'SHO') {
                // by BaoTran, Case nguoi mua chon ship la SHOP GIAO
                $shipfee['ServiceFee'] = 0;
                $shipfee['ServiceName'] = "";
                $shipfee['ServiceID'] = "SHO";
            } else {
                $shipfee_vtp = $this->getVTPShippingFee($shop['district'], $des_district, $totalWeight);
                if ($shipfee_vtp) {
                    $shipfee['ServiceFee'] = (float)str_replace(",", "", $shipfee_vtp[0]['TONG_CUOC']);
                    $shipfee['ServiceName'] = "";
                    $shipfee['ServiceID'] = VTP_SERVICE;
                }
            }
            $this->session->set_userdata('fee_'.$shop_id, $shipfee);

            if (isset($shipfee['ServiceFee'])) {
                $feeAmount = $shipfee['ServiceFee'];
                $feeTime = $shipfee['ServiceName'];
            } else {
                $feeError = true;
            }
        }
        
        $this->session->set_userdata('cart', $cart);
        echo json_encode(array('error' => false, 'fee_error' => $feeError, 'fee_amount' => $feeAmount, 'feeTime' => $feeTime, 'fee' => $fee));
        exit();
    }
    
    public function getGHTKShippingFee($fromDis = "", $toDis = "", $totalWeightPro = 0)
    {
        $this->load->model('ghtietkiem_model');
        $from = $this->ghtietkiem_model->GetProvinceByDistrictCode($fromDis);
        $to = $this->ghtietkiem_model->GetProvinceByDistrictCode($toDis);
        $dataInfo = array(
            "pick_province" => $from->ProvinceName,
            "pick_district" => $from->DistrictName,
            "province" => $to->ProvinceName,
            "district" => $to->DistrictName,
            "address" => "",
            "weight" => $totalWeightPro,
            "value" => 0
            );        
        $result = $this->ghtietkiem_model->getShippingFee($dataInfo);       
        if($result) {
            $res = json_decode($result);
            $fee = $res->fee->fee + $res->fee->insurance_fee;
            return $fee;
        } else {
            return null;
        }
    }

    public function getVTPShippingFee($from, $to, $totalWeight)
    {
        $from = $this->viettelpost_model->GetProvinceByDistrictCode($from);
        $token = $this->viettelpost_model->Login();
        $data = array("NGAYGUI_BP" => date('d/m/Y'),
            "HUYEN_GUI" => $from->vtp_code,
            "HUYEN_NHAN" => $to,
            "DICHVU" => VTP_SERVICE,
            "DV_DACBIET" => "",
            "LOAIHH" => "HH",
            "TRONG_LUONG" => $totalWeight,
            "KHAI_GIA" => "0",
            "THU_HO" => "0"
        );

        $return = $this->viettelpost_model->callMethod('TinhCuoc', json_encode($data, true), $token, 'POST');
        $this->viettelpost_model->callMethod('Logoff', null, $token, 'POST');
        if ($return) {
            return $return;
        } else {
            return null;
        }
    }

    public function delete_old()
    {
        $pro_id = (int)$this->input->post('pro_id');       
        $store = (int)$this->input->post('store');
        $cart = $this->session->userdata('cart');
        foreach ($cart as $key => &$cItems) {
            if ($key == $store && !empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    if ($cp['pro_id'] == $pro_id) {
                        unset($cItems[$k]);
                        break;
                    }
                }
                if (empty($cItems)) {
                    unset($cart[$key]);
                }
            }
        }
        $num = 0;
        foreach ($cart as $key => $cItems) {
            foreach ($cItems as $k => $cp) {
                $num += $cp['qty'];
            }
        }       
       
        $this->session->set_userdata('cart', $cart);
        echo json_encode(array('error' => false, 'num' => $num));
        exit();
    }

    public function delete()
    {
        $pro_id = (int)$this->input->post('pro_id');        
        $store = (int)$this->input->post('store');
        $type = $this->input->post('type');
        $key_pro = $this->input->post('key');

        if ($type == 'coupon') {
            $cart = $this->session->userdata('cart_coupon');
            $cart_num = $this->session->userdata('cart');
        } else {
          $cart = $this->session->userdata('cart');
          $cart_num = $this->session->userdata('cart_coupon');  
        }
        
        $xoa = $xoa2 = '';
        $num = 0;
        foreach ($cart as $key => &$cItems) {
            $xoa = $key .', '.$store;
            if ($key == $store && !empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    if ($cp['pro_id'] == $pro_id && $cp['key'] == $key_pro) {
                        unset($cart[$key][$k]);
                        break;
                    }
                }
                if (empty($cItems)) {
                    unset($cart[$key]);
                }
            }
            foreach ($cItems as $k => $cp) {
                $num += $cp['qty'];
            }
        }

        foreach ($cart_num as $items) {
            if (!empty($items)) {
                foreach ($items as $k => $cp) {
                    $num += $items[$k]['qty'];
                }
            }
        }
        
        if ($type == 'coupon') {
            $cart = $this->session->set_userdata('cart_coupon', $cart);
        } else {
          $this->session->set_userdata('cart', $cart);
        }
        echo json_encode(array('error' => false, 'num' => $num));
        exit();
    }

    public function getDistrict()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $result = $this->district_model->find_by(array('ProvinceCode' => $this->input->post('user_province_put'), 'pre_status' => 1), 'DistrictCode, DistrictName');
            if ($result) {
                foreach ($result as $vals) {
                    $district[$vals->DistrictCode] = $vals->DistrictName;
                }
                echo json_encode($district);
                exit;
            } else {
                die("");
            }
        } else {
            redirect(base_url());
        }
    }

    public function getProvinces()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $pre_area = $this->province_model->get('pre_area', "pre_status = 1 AND pre_id = " . $this->input->post('user_province_put'));
            $_area = $this->province_model->fetch('pre_id,pre_name', "pre_status = 1 AND pre_area = " . $pre_area->pre_area, '');
            if ($_area) {
                $province = array();
                foreach ($_area as $vals) {
                    $province[$vals->pre_id] = $vals->pre_name;
                }
                echo json_encode($province);
                exit;
            } else {
                die("");
            }
        } else {
            redirect(base_url());
        }
    }

    private function getShippingDefault($fromDistrict, $toDistrict, $product_id, $quantity)
    {
        //Phong adds "$product_id, $quantity";
        $this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();       
        $product = $this->product_model->get('pro_weight, pro_length, pro_width, pro_height', 'pro_id = '. $product_id);
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
                    "Weight" => $product->pro_weight * $quantity,
                    "Length" => $product->pro_length,
                    "Width" => $product->pro_width,
                    "Height" => $product->pro_height
                );
                $calculateServiceFeeRequest = array('SessionToken' => $sessionToken, 'Items' => $items);
                $responseCalculateServiceFee = $serviceClient->CalculateServiceFee($calculateServiceFeeRequest);
                $result = reset($responseCalculateServiceFee['Items']);
                if ($responseCalculateServiceFee['ErrorMessage'] == "") {
                    break;
                }
                unset($items);
                unset($responseCalculateServiceFee);
            }
            return $result;
        }
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
            return $result;
        }
    }

    public function rand_string_limit($length)
    {
        $str = "";
        $chars = "123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        $string = $str . date("s") . date("imd");        
        do {
            $get = $this->showcart_model->fetch('shc_code', 'shc_code = "'. $string .'"', '');
        } while (count($get) > 0);
        return $string;
    }

    public function ordersSuccess($order_id)
    {
        if (!isset($_REQUEST['order_token'])) {
            redirect(base_url());
        }
        $this->load->model('bank_model');
        $data['bank_info'] = $this->bank_model->fetch('*');
        $pro_type = 0;
        if (isset($_REQUEST['pro_type'])) {
            $pro_type = $_REQUEST['pro_type'];
        }
        //$order_code = $this->session->flashdata('_orders');
        if ($order_id) {
            //$this->session->unset_userdata('_orders');//unset session order
            $data['order_cart'] = $this->showcart_model->getDetailOrders(array('order_id' => $order_id, 'order_token' => $_REQUEST['order_token']));
            if (empty($data['order_cart'])) {
                redirect(base_url());
            }
            // if($data['order_cart'][0]->shipping_method != 'VTP'){
            //     $data['_province'] = $this->province_model->fetch('pre_name', "pre_id = " . $data['order_cart'][0]->ord_province, '');
            //     $data['_district'] = $this->district_model->find_by(array('DistrictCode' => $data['order_cart'][0]->ord_district), 'DistrictName');
            //     foreach (json_decode(ServiceID) as $key => $vals) {
            //         if ($key == $data['order_cart'][0]->ghn_ServiceID) {
            //             $data['timeShip'] = $vals;
            //             break;
            //         }
            //     }
            // }else{
            //     $tinhThanh = $this->district_model->get('DistrictName,ProvinceName',array('vtp_code' => $data['order_cart'][0]->ord_district));
            //     $data['_province']= $tinhThanh->ProvinceName;
            //     $data['_district']= $tinhThanh->DistrictName;
            // }
            // by Bao Tran, order with method ship is 'SHOP GIAO'
            if ($data['order_cart'][0]->shipping_method == 'GHN' || $data['order_cart'][0]->shipping_method == 'GHTK') {
                $data['_province'] = $this->province_model->fetch('pre_name', "pre_id = " . (int)$data['order_cart'][0]->ord_province, '')[0]->pre_name;
                $data['_district'] = $this->district_model->find_by(array('DistrictCode' => $data['order_cart'][0]->ord_district), 'DistrictName')[0]->DistrictName;
                foreach (json_decode(ServiceID) as $key => $vals) {
                    if ($key == $data['order_cart'][0]->ghn_ServiceID) {
                        $data['timeShip'] = $vals;
                        break;
                    }
                }
            }  else {
                $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('vtp_code' => $data['order_cart'][0]->ord_district));
                $data['_province'] = $tinhThanh->ProvinceName;
                $data['_district'] = $tinhThanh->DistrictName;
            }

            $data['settingTitle'] = settingTitle;
            // echo '<pre>';
            // var_dump($data['order_cart'][0]);
            // echo '</pre>';

            if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type == 0) {
                $this->shop_mail_model->sendingOrderEmailForCustomer($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
            }
            if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type != 0 && $data['order_cart'][0]->order_status != '98') {
                $this->shop_mail_model->sendingOrderEmailForCustomerV2($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
            }
            if ($data['order_cart'][0]->ord_semail && $data['order_cart'][0]->pro_type != 0 && $data['order_cart'][0]->order_status == '98') {
                $title_type = '';
                if ($data['order_cart'][0]->pro_type == 1) {
                    $title_type = 'Dịch vụ';
                    $ordercode = $data['order_cart'][0]->id;
                } elseif ($data['order_cart'][0]->pro_type == 2) {
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
            if ($data['order_cart'][0]->pro_type == 0) {
                $this->shop_mail_model->sendingOrderEmailForShop($data['order_cart'][0], $data['order_cart'][0], $data['order_cart']);
            }

            $data['mainDomain'] = $this->mainURL;
            // $this->session->set_userdata('cart', array());

            ##Load:: View
            $this->load->view('home/showcart/orders_success', $data);
        } else {
            redirect(base_url());
        }
    }

    public function ordersError($order_id)
    {
        if ($order_id) {            
            $data['order_cart'] = $this->showcart_model->getDetailOrders(array('order_id' => $order_id));
            $data['_province'] = $this->province_model->fetch('pre_name', 'pre_id = '. $data['order_cart'][0]->ord_province, '');
            $data['_district'] = $this->district_model->find_by(array('DistrictCode' => $data['order_cart'][0]->ord_district), 'DistrictName');
            foreach (json_decode(ServiceID) as $key => $vals) {
                if ($key == $data['order_cart'][0]->ghn_ServiceID) {
                    $data['timeShip'] = $vals;
                    break;
                }
            }
            $data['settingTitle'] = settingTitle;
            $this->load->view('home/showcart/orders_error', $data);
        } else {
            redirect(base_url());
        }
    }

    public function checkOrders($order_id = NULL)
    {
        if ($this->input->post('order_id')) {
            $order_id = $this->input->post('order_id');
        }

        $this->load->model('bank_model');
        $data['bank_info'] = $this->bank_model->fetch('*');
        if ($order_id) {
            $this->load->model('af_order_model');
            // $data['order_cart'] = $this->showcart_model->getDetailOrders(array('order_id' => $order_id));
            // $data['order'] = $order= $this->showcart_model->getOrderInformation($order_id);
            // $data['order'] =$order = $this->showcart_model->getDetailOrders(array('order_id' => $order_id));
            $data['order'] = $order = $this->showcart_model->getDetailOrders_(array('order_id' => $order_id));
            if (empty($data['order'])) {
                redirect(base_url());
            }

            foreach ($this->af_order_model->getStatus() as $vals) {
                $data['status'][$vals['status_id']] = $vals['text'];
            }
            $data['mainDomain'] = $this->mainURL;
            $data['shopURL'] = $this->shopURL;              
            $this->load->model('grouptrade_model');
            $arr_domain = explode('.', base_url());

            $name_domain = explode('//', $arr_domain[0]);            
            $get_sp = $this->shop_model->fetch_join('sho_user, sho_link,domain','','','', '(sho_link = "'. $name_domain[1] .'" OR domain = "'. $name_domain[1] .'")');
            $get_trade = $this->grouptrade_model->get('grt_admin, grt_link, grt_domain', '(sho_link = "'. $name_domain[1] .'" OR domain = "'. $name_domain[1] .'" OR grt_link = "'. $name_domain[1] .'" OR grt_domain = "'. $name_domain[1] .'")');
            $usegroup = $this->user_model->get('use_group', '(use_id = "'. $get_sp->sho_user .'" OR use_id = "'. $get_trade->grt_admin .'")');
            $data['useGroup'] = $usegroup->use_group;
            if ($order[0]->shipping_method == 'GHN' || $order[0]->shipping_method == 'GHTK') {
               $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('DistrictCode' => $order[0]->ord_district));
            }else{
               $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('vtp_code' => $order[0]->ord_district));
            }
            $data['_province'] = $tinhThanh->ProvinceName;
            $data['_district'] = $tinhThanh->DistrictName;
            ##Load:: View
            $this->load->view('home/showcart/check_orders', $data);
        } else {
            redirect(base_url());
        }
    }

    public function trackingOrder($maVanDon = '')
    {
        $data['tracking'] = null;
        if (trim($maVanDon)) {            
            $data['tracking'] = $this->viettelpost_model->getTrackingInfo($maVanDon);
        }
        $this->load->view('home/showcart/tracking_order', $data);
    }

    public function checkout()
    {
        $data = array();
        // Added by le van son, Edit by Bao Tran
        // Get products from cart
        $cart = $this->session->userdata('cart');
        $cart_coupon = $this->session->userdata('cart_coupon');
        // var_dump($cart);
        // echo "<pre>"; print_r($cart); echo "</pre>"; die;
        // nganly
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
            $productList = array();
            $jsCart = array();
            // $couponList = array();
            // $serviceList = array();
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
                                $productItem = array('pro_id' => $pItem->pro_id, 'key' => $pItem->key, 'qty' => $pItem->qty, 'pro_cost' => $pItem->pro_cost, 'em_discount' => $pItem->em_discount, 'shipping_fee' => $pItem->shipping_fee, 'dp_id' => $pItem->dp_id);
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
                                $pItem->fl_id = $cItem['fl_id'];

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

        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;            
        }
        $data['mainDomain'] = $this->mainURL;
        // echo '<pre>'; print_r($cart); echo '</pre>'; die;
        ###Load:: View
        // dd($data);die;
        $this->load->view('home/showcart/checkout', $data);
    }

    function shop($shop_id)
    {
        $updateCart = false;
        $data = array();
        $cart = $this->session->userdata('cart'); 
        // echo '<pre>'; print_r($cart); echo '</pre>'; die;
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
        foreach ($cart as $key => $items) {
            if ($shop_id == $key && !empty($items)) {
                $jsCart[$key] = array('shop' => $key, 'products' => array());
                foreach ($items as $k => $cp) {
                    if ($cp['pro_type'] == '0') {
                        // Build product price
                        $select = 'pro_user, pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_type, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_QUERY;
                        $pro = $this->product_model->get($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0');
                        ## Get price for Trường Quy Cách SP, by Bao Tran
                        if ($cp['dp_id'] > 0) {
                            $select = 'pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) as pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate'. DISCOUNT_DP_QUERY .', T2.*';
                            $pro = $this->product_model->getProAndDetailForCheckout($select, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0', (int)$cp['dp_id']);
                        }

                        if (empty($pro)) {
                            unset($items[$k]);
                            $updateCart = true;
                            continue;
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

                        $pro->pro_cost = $discount['salePrice'];//strtoupper(trim($pro->pro_currency)) == 'VND' ? $discount['salePrice'] : $discount['salePrice'] * settingExchange;                    
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
                        $pro->fl_id = $cp['fl_id'];

                        array_push($productList, $pro);
                        $productItem = array('pro_id' => $pro->pro_id, 'key' => $pro->key, 'qty' => $pro->qty, 'pro_cost' => $pro->pro_cost, 'em_discount' => $pro->em_discount, 'dp_id' => $pro->dp_id);
                        array_push($jsCart[$key]['products'], $productItem);
                    }
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
        $data['shop'] = $this->shop_model->getShopInfo($shopFilter);
        $this->session->set_userdata('shop', $data['shop']);
        $filterProvice = array(
            'select' => 'pre_id AS id, pre_name AS val',
            'order_by' => 'pre_order ASC'
        );
        $data['province'] = $this->province_model->getProvince($filterProvice);
        $data['district'] = array();
        $this->load->model('payment_model');
        $data['infoPayment'] = $this->payment_model->get('*', 'id_user = '. (int)PAYMENT_USER_ID);
        // get user information
        $data['user'] = array();
        if ($this->session->userdata('sessionUser') > 0) {
            $filterUser = array(
                'select' => 'use_fullname, use_address, use_province, user_district, use_email, IF(use_mobile <> \'\', use_mobile, use_phone) AS mobile',
                'where' => array(
                    'use_id' => $this->session->userdata('sessionUser')
                )
            );
            $data['user'] = $this->user_model->getUserInfo($filterUser);
            if ($data['user']['user_district'] != '' && $data['user']['use_province']) {
                $filterDistrict = array(
                    'select' => 'DistrictCode AS id, DistrictName AS val',
                    'order_by' => 'DistrictName ASC',
                    'where' => array('ProvinceCode' => $data['user']['use_province'])
                );
                $data['district'] = $this->district_model->getDistrict($filterDistrict);
            }
        }
        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        $data['mainDomain'] = $this->mainURL;

        // echo '<pre>'; print_r($cart); echo '</pre>'; die;
        #Load view
        $this->load->view('home/showcart/shop', $data);
    }

    function shopv2($shop_id, $type)
    {
        $updateCart = false;
        $data = array();
        $cart = $this->session->userdata('cart_coupon');
        $jsCart = array();
        $productList = array();
        if ($this->session->userdata('sessionUser') > 0) {
            // Check if login user is saler shop
            $shopInfo = $this->shop_model->get("shop_type", "sho_user =" . $this->session->userdata('sessionUser'));
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
        
        foreach ($cart as $key => $items) {

            if ($shop_id == $key && !empty($items)) {
                $jsCart[$key] = array('shop' => $key, 'products' => array());
                foreach ($items as $k => $cp) {
                    if ($cp['pro_type'] > 0) {

                        // Build product price
                        $select = "pro_user, pro_instock,pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image,pro_type, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate " . DISCOUNT_QUERY;
                        $pro = $this->product_model->get($select, "pro_id = " . (int)$cp['pro_id'] . "  AND pro_status = 1 AND pro_type > 0 ");

                        ## Get price for Trường Quy Cách SP, by Bao Tran
                        if ($cp['dp_id'] > 0) {
                            $select = "pro_user, pro_instock, pro_id, pro_name, pro_descr, (dp_cost) as pro_cost, pro_currency, pro_category, pro_type, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, is_product_affiliate " . DISCOUNT_DP_QUERY . ", T2.*";
                            $pro = $this->product_model->getProAndDetailForCheckout($select, "pro_id = " . (int)$cp['pro_id'] . " AND pro_status = 1 AND pro_type > 0", (int)$cp['dp_id']);
                        }

                        if (empty($pro)) {
                            unset($items[$k]);
                            $updateCart = true;
                            continue;
                        }
                        $afSelect = false;
                        $items[$k]['af_user'] = $cp['af_id'];
                        if ($cp['af_id'] > 0 && $pro->is_product_affiliate == 1) {
                            $afSelect = true;
                        }
                        $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), $afSelect);

                        // Make discount for member
                        $pro->em_discount = 0;
                        if (/*$this->session->userdata('sessionGroup') == 3 &&*/
                            $pro->pro_user != $this->session->userdata('sessionUser')
                        ) {
                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $pro->pro_id, 'qty' => $cp['qty'], 'total' => ($discount['salePrice'] * $cp['qty'])));
                            if (!empty($promotion)) {
                                if ($promotion['dc_rate'] > 0) {
                                    $pro->em_discount = $discount['salePrice'] * $cp['qty'] * $promotion['dc_rate'] / 100;
                                } else {
                                    $pro->em_discount = $promotion['dc_amt'];
                                }
                            }
                        }
                        $pro->pro_cost = $discount['salePrice']; //strtoupper(trim($pro->pro_currency)) == 'VND' ? $discount['salePrice'] : $discount['salePrice'] * settingExchange;
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
                        $pro->fl_id = $cp['fl_id'];

                        array_push($productList, $pro);
                        $productItem = array('pro_id' => $pro->pro_id, 'key' => $pro->key, 'qty' => $pro->qty, 'pro_cost' => $pro->pro_cost, 'em_discount' => $pro->em_discount, 'dp_id' => $pro->dp_id);
                        array_push($jsCart[$key]['products'], $productItem);
                    }
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
        $data['shop'] = $this->shop_model->getShopInfo($shopFilter);
        $this->session->set_userdata('shop', $data['shop']);
        // $filterProvice = array(
        //     'select' => 'pre_id AS id, pre_name AS val',
        //     'order_by' => 'pre_order ASC'
        // );
        // $data['province'] = $this->province_model->getProvince($filterProvice);
        // $data['district'] = array();
        $this->load->model('payment_model');
        $data['infoPayment'] = $this->payment_model->get('*', "id_user = " . (int)PAYMENT_USER_ID);
        // get user information
        $data['user'] = array();
        if ($this->session->userdata('sessionUser') > 0) {           
            $filterUser = array(
                'select' => 'use_fullname, use_address, use_province, user_district, use_email, IF(use_mobile <> \'\', use_mobile, use_phone) AS mobile',
                'where' => array(
                    'use_id' => $this->session->userdata('sessionUser')
                )
            );
            $data['user'] = $this->user_model->getUserInfo($filterUser);
            // if ($data['user']['user_district'] != '' && $data['user']['use_province']) {            
            //     $filterDistrict = array(
            //         'select' => 'DistrictCode AS id, DistrictName AS val',
            //         'order_by' => 'DistrictName ASC',
            //         'where' => array('ProvinceCode' => $data['user']['use_province'])
            //     );
            //     $data['district'] = $this->district_model->getDistrict($filterDistrict);
            // }
        }
        #END CHECK SETTING
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        $data['pro_type'] = $type;
        $data['mainDomain'] = $this->mainURL;
        
        $this->load->view('home/showcart/shopv2', $data);
    }

    function placeOrder()
    {
        // Check double click
        $lastesd_order = $this->session->userdata('lasted_order');
        if ($lastesd_order > 0 && time() < $lastesd_order + 3) {
            echo json_encode(array('error' => true, 'message' => 'Vui lòng đợi....'));
            exit();
        } else {
            $this->session->set_userdata('lasted_order', time());
        }
        $cart = $this->session->userdata('cart');
        $sho_user = (int)$this->input->post('sho_user');
        $fee = $this->session->userdata('fee_'.$sho_user); 
        $total = 0;
        $this->load->model('product_promotion_model');
        foreach ($cart as $key => &$cItems) {
            if ($key == $sho_user && !empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    if ($cp['pro_type'] == '0') {

                        $cItems[$k]['stock'] = true;
                        // Build product price
                        $productInfo = $this->product_model->get('pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate, pro_cost, is_product_affiliate '. DISCOUNT_QUERY, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0');
                        if ($cp['dp_id'] > 0) {
                            $productInfo = $this->product_model->getProAndDetailForCheckout('pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate, (dp_cost) AS pro_cost, is_product_affiliate, T2.*'. DISCOUNT_DP_QUERY, 'pro_id = '. (int)$cp['pro_id'] .' AND pro_status = 1 AND pro_type = 0', (int)$cp['dp_id']);
                        }

                        if (empty($productInfo)) {
                            $cItems[$k]['stock'] = false;
                            continue;
                        }

                        $wholesale = false;
                        if ($this->session->userdata('sessionUser') > 0) {
                            // Check if login user is saler shop
                            $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                            $wholesale = $shopInfo->shop_type > 0 ? true : false;
                        }
                        if ($wholesale) {
                            if ($cp['store_type'] == 0) {
                                // retailer shop
                                unset($cItems[$k]);
                                continue;
                            } elseif ($cItems[$k]['qty'] < $cp['qty_min']) {
                                $cItems[$k]['qty'] = $cp['qty_min'];
                            }
                        }
                        $afSelect = false;
                        $cItems[$k]['af_user'] = $cp['af_id'];
                        if ($cp['af_id'] > 0 && $productInfo->is_product_affiliate == 1) {
                            $afSelect = true;
                        }
                        $priceInfo = lkvUtil::buildPrice($productInfo, $this->session->userdata('sessionGroup'), $afSelect);
                        $cItems[$k]['pro_price_original'] = $productInfo->pro_cost;
                        $cItems[$k]['pro_price'] = $priceInfo['salePrice'];
                        //print_r($priceInfo);
                        $cItems[$k]['pro_price_rate'] = 0;
                        $cItems[$k]['pro_price_amt'] = 0;
                        $cItems[$k]['pro_category'] = $productInfo->pro_category;
                        if ($priceInfo['saleOff'] > 0) {
                            if ($productInfo->off_rate > 0) {
                                $cItems[$k]['pro_price_rate'] = $productInfo->off_rate;
                            } else {
                                $cItems[$k]['pro_price_amt'] = $productInfo->off_amount;
                            }
                        }
                        $cItems[$k]['af_rate'] = $productInfo->af_rate_ori;
                        $cItems[$k]['af_amt'] = $productInfo->af_amt_ori;
                        $cItems[$k]['dc_amt'] = 0;
                        $cItems[$k]['dc_rate'] = 0;
                        if ($priceInfo['em_off'] > 0) {
                            $cItems[$k]['dc_amt'] = $productInfo->dc_amt;
                            $cItems[$k]['dc_rate'] = $productInfo->dc_rate;
                        }
                        $cItems[$k]['affiliate_discount_amt'] = 0;
                        $cItems[$k]['affiliate_discount_rate'] = 0;
                        if ($priceInfo['af_off'] > 0) {
                            if ($priceInfo['af_rate'] > 0) {
                                $cItems[$k]['affiliate_discount_rate'] = $priceInfo['af_rate'];
                            } else {
                                $cItems[$k]['affiliate_discount_amt'] = $priceInfo['af_off'];
                            }
                        }
                        // Make discount for member
                        $cItems[$k]['em_promo'] = 0;
                        if (/*$this->session->userdata('sessionGroup') == 3 &&*/
                            $productInfo->pro_user != $this->session->userdata('sessionUser')
                        ) {
                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $productInfo->pro_id, 'qty' => $cItems[$k]['qty'], 'total' => ($cItems[$k]['pro_price'] * $cItems[$k]['qty'])));
                            if (!empty($promotion)) {
                                if ($promotion['dc_rate'] > 0) {
                                    $cItems[$k]['em_promo'] = $cItems[$k]['pro_price'] * $cItems[$k]['qty'] * $promotion['dc_rate'] / 100;
                                } else {
                                    $cItems[$k]['em_promo'] = $promotion['dc_amt'];
                                }
                            }
                        }
                        // get shop type
                        $cItems[$k]['shc_saler_store_type'] = $cp['store_type'];
                        $total += ($cItems[$k]['pro_price'] * $cItems[$k]['qty']) - $cItems[$k]['em_promo'];
                    }
                }
            }
        }

        if (!isset($fee['ServiceFee'])) {
            $return = array("error" => true, "message" => "Xin lỗi, chúng tôi chưa hỗ trợ giao hàng tới khu vực của bạn");
        } else {
            $total += $fee['ServiceFee'];
            if ($total > 0 && $total != $this->input->post('amount')) {
                $return = array("error" => true, "message" => "Số tiền yêu cầu thanh toán không hợp lệ", "total" => $total);
            } elseif ($total == 0) {
                $return = array("error" => true, "message" => "Không có sản phẩm trong giỏ hàng. Vui lòng chọn sản phẩm");
            } else {
                // Tung Add user khi khach mua hang khong dang nhap
                $this->load->library('hash');
                $salt = $this->hash->key(8);
                $pass = $this->generateRandomString();
                $data_user = array(
                    'use_username' => $this->input->post('ord_semail'),
                    'use_salt' => $salt,
                    'use_password' => $this->hash->create($pass, $salt, 'md5sha512'),
                    'use_fullname' => $this->input->post('ord_sname'),
                    'use_address' => $this->input->post('ord_address'),
                    'use_province' => $this->input->post('user_province'),
                    'user_district' => $this->input->post('user_district'),
                    'use_email' => $this->input->post('ord_semail'),
                    'use_status' => 1,
                    'use_group' => 1,
                    'parent_id' => $productInfo->pro_user,
                    'use_regisdate' => time(),
                    'use_mobile' => $this->input->post('ord_smobile'),
                );

                $user = $this->user_model->get('*', 'use_email = "' . $this->input->post('ord_semail') . '"');

                if ($user->use_id <= 0 && (int)$this->session->userdata('sessionUser') <= 0) {
                    $this->user_model->add($data_user);
                    $userid = $this->db->insert_id();
                    $this->session->set_userdata('password', $pass);
                } elseif ($user->use_id > 0) {
                    $userid = $user->use_id;
                }
                $orderUser = 0;
                if ($this->session->userdata('sessionUser')) {
                    $orderUser = $this->session->userdata('sessionUser');
                } elseif ($userid > 0) {
                    $orderUser = $userid;
                }
                // end
                // Insert order
                $this->load->model('order_model');
                $oderInfo = array(
                    'date' => time(),
                    'payment_method' => $this->input->post('payment_method'),
                    'shipping_method' => $this->input->post('company'),
                    'order_user' => $orderUser,
                    'shipping_fee' => $fee['ServiceFee'],
                    'order_saler' => $sho_user,
                    'af_id' => 0,
                    'order_serviceID' => $fee['ServiceID'],
                    'order_total' => $total,
                    'order_total_no_shipping_fee' => $total - $fee['ServiceFee'],
                    'change_status_date' => time(),
                    'payment_status' => '0',
                    'token' => "",
                    'order_code' => time() . '_' . rand(100, 9999),
                    'other_info' => "",
                    'order_token' => md5(time() . rand()),
                    'order_group_id' => $this->input->post('gr_id'),
                    'order_user_sale' => $this->input->post('gr_user')
                );
                $order_id = $this->order_model->makeOrder($oderInfo);
                if ($order_id > 0) {
                    // Insert order item;
                    foreach ($cart as $key => &$cItems) {
                        if ($key == $sho_user && !empty($cItems)) {
                            foreach ($cItems as $kpro => $pro) {
                                if ($pro['pro_type'] == '0') {

                                    $shc_saler_parent = 0;
                                    $shc_saler_parent_group = 0;
                                    if ($pro['pro_user'] > 0) {
                                        $salerParent = $this->user_model->get("*", "use_id = {$pro['pro_user']}");
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
                                    if ($pro['af_user'] > 0) {
                                        $afParent = $this->user_model->get("*", "use_id = {$pro['af_user']}");
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
                                    if ($pro['shipping_fee'] <= 0) {
                                        $pro['shipping_fee'] = 0;
                                    }

                                    $order_type = $pro['shc_saler_store_type'];
                                    if ($order_type == 2) {
                                        if ($productInfo->pro_minsale <= $pro['qty']) {
                                            $order_type = 1;
                                        } else {
                                            $order_type = 0;
                                        }
                                    }

                                    $orderDetail = array(
                                        'shc_product' => $pro['pro_id'],
                                        'shc_dp_pro_id' => $pro['dp_id'],
                                        'shc_quantity' => $pro['qty'],
                                        'pro_category' => $pro['pro_category'],
                                        'shc_saler' => $pro['pro_user'],
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
                                        'em_discount' => $pro['em_promo'],
                                        'shc_total' => $pro['pro_price'] * $pro['qty'] - $pro['em_promo'],
                                        'af_amt' => $pro['af_amt'],
                                        'af_rate' => $pro['af_rate'],
                                        'dc_amt' => $pro['dc_amt'],
                                        'dc_rate' => $pro['dc_rate'],
                                        'affiliate_discount_amt' => $pro['affiliate_discount_amt'],
                                        'affiliate_discount_rate' => $pro['affiliate_discount_rate'],
                                        'pro_price' => $pro['pro_price'],
                                        'pro_price_original' => $pro['pro_price_original'],
                                        'pro_price_rate' => $pro['pro_price_rate'],
                                        'pro_price_amt' => $pro['pro_price_amt'],
                                        'af_id' => $pro['af_user'],
                                        'af_id_parent' => $af_id_parent,
                                        'shc_group_id' => $this->input->post('gr_id'),
                                        'shc_user_sale' => $this->input->post('gr_user'),
                                        'fl_id' => $pro['fl_id']
                                    );
                                    if ($this->showcart_model->add($orderDetail)) {
                                        $this->product_model->updateBuyNum($pro['pro_id']);
                                    }
                                    unset($orderDetail);

                                    unset($cItems[$kpro]);
                                    
                                }
                            }

                            if (empty($cart[$key])) {
                                unset($cart[$key]);
                            }
                        }
                    }
                    // Add receive
                    //$time_receive = mktime($this->input->post('ord_hour'), $this->input->post('ord_minute'), 0, $this->input->post('ord_month'), $this->input->post('ord_date'), $this->input->post('ord_year'));
                    //$_province = $this->province_model->fetch('pre_name', "pre_id = " . $this->input->post('user_province'), '');
                    $nganluong = array("payment_method_nganluong" => "", "bankcode" => "");
                    if ($_POST['payment_method'] == "info_nganluong") {
                        $nganluong["payment_method_nganluong"] = $_POST['payment_method_nganluong'];
                        $nganluong["bankcode"] = $_POST["bankcode"];
                    }
                    $this->session->set_userdata('nganluong', $nganluong);
                    $data_user_receive = array(
                        'use_id' => $orderUser,
                        'order_id' => $order_id,
                        'ord_sname' => $this->input->post('ord_sname'),
                        'ord_saddress' => $this->input->post('ord_address'),
                        'ord_province' => $this->input->post('user_province'),
                        'ord_district' => $this->input->post('user_district'),
                        'ord_semail' => $this->input->post('ord_semail'),
                        'ord_smobile' => $this->input->post('ord_smobile'),
                        'ord_note' => $this->input->post('ord_note')
                    );
                    $this->load->model('user_receive_model');
                    $this->user_receive_model->add($data_user_receive);
                    //$this->session->set_flashdata('_orders', $oderInfo['order_code']);//store session order
                    //Clear cart
                    $this->session->set_userdata('cart', $cart);

                    //Clear shipping cart
                    $this->session->set_userdata('fee_'.$sho_user, array());
                    //redirect(base_url() . 'dat-hang-thanh-cong');
                    $return = array('error' => false, 'order_id' => $order_id, 'payment_method' => $this->input->post('payment_method'), 'order_token' => $oderInfo['order_token'], 'cart' => $cart);
                }
            }
        }
        echo json_encode($return);
        exit();
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

    function placeOrderv2()
    {
        // Check double click
        $lastesd_order = $this->session->userdata('lasted_order');
        if ($lastesd_order > 0 && time() < $lastesd_order + 3) {
            echo json_encode(array('error' => true, 'message' => 'Vui lòng đợi....'));
            exit();
        } else {
            $this->session->set_userdata('lasted_order', time());
        }
        $cart = $this->session->userdata('cart_coupon');
        //$shop = $this->session->userdata('shop');
        $sho_user = (int)$this->input->post('sho_user');
        $total = 0;
        $this->load->model('product_promotion_model');
        
        $pro_type = $this->input->post('pro_type');
        foreach ($cart as $key => &$cItems) {
            if ($key == $sho_user && !empty($cItems)) {
                foreach ($cItems as $k => $cp) {
                    if ($cp['pro_type'] > 0) {

                        $cItems[$k]['stock'] = true;
                        // Build product price
                        $productInfo = $this->product_model->get("pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate,  pro_cost, is_product_affiliate " . DISCOUNT_QUERY, "pro_id = " . (int)$cp['pro_id'] . "  AND pro_status = 1 AND pro_type > 0");
                        if ($cp['dp_id'] > 0) {
                            $productInfo = $this->product_model->getProAndDetailForCheckout("pro_minsale, pro_category, pro_id, pro_user, pro_buy, af_amt as af_amt_ori, af_rate as af_rate_ori, dc_amt, dc_rate, (dp_cost) AS pro_cost, is_product_affiliate " . DISCOUNT_DP_QUERY . ", T2.*", "pro_id = " . (int)$cp['pro_id'] . "  AND pro_status = 1 AND pro_type > 0", (int)$cp['dp_id']);
                        }

                        if (empty($productInfo)) {
                            $cItems[$k]['stock'] = false;
                            continue;
                        }
                        $wholesale = false;
                        if ($this->session->userdata('sessionUser') > 0) {
                            // Check if login user is saler shop
                            $shopInfo = $this->shop_model->get("shop_type", "sho_user = " . $this->session->userdata('sessionUser'));
                            $wholesale = $shopInfo->shop_type > 0 ? true : false;
                        }
                        if ($wholesale) {
                            if ($cp['store_type'] == 0) {
                                // retailer shop
                                unset($cItems[$k]);
                                continue;
                            } elseif ($cItems[$k]['qty'] < $cp['qty_min']) {
                                $cItems[$k]['qty'] = $cp['qty_min'];
                            }
                        }
                        $afSelect = false;
                        $cItems[$k]['af_user'] = $cp['af_id'];
                        if ($cp['af_id'] > 0 && $productInfo->is_product_affiliate == 1) {
                            $afSelect = true;
                        }
                        $priceInfo = lkvUtil::buildPrice($productInfo, $this->session->userdata('sessionGroup'), $afSelect);
                        $cItems[$k]['pro_price_original'] = $productInfo->pro_cost;
                        $cItems[$k]['pro_price'] = $priceInfo['salePrice'];
                        //print_r($priceInfo);
                        $cItems[$k]['pro_price_rate'] = 0;
                        $cItems[$k]['pro_price_amt'] = 0;
                        $cItems[$k]['pro_category'] = $productInfo->pro_category;
                        if ($priceInfo['saleOff'] > 0) {
                            if ($productInfo->off_rate > 0) {
                                $cItems[$k]['pro_price_rate'] = $productInfo->off_rate;
                            } else {
                                $cItems[$k]['pro_price_amt'] = $productInfo->off_amount;
                            }
                        }
                        $cItems[$k]['af_rate'] = $productInfo->af_rate_ori;
                        $cItems[$k]['af_amt'] = $productInfo->af_amt_ori;
                        $cItems[$k]['dc_amt'] = 0;
                        $cItems[$k]['dc_rate'] = 0;
                        if ($priceInfo['em_off'] > 0) {
                            $cItems[$k]['dc_amt'] = $productInfo->dc_amt;
                            $cItems[$k]['dc_rate'] = $productInfo->dc_rate;
                        }
                        $cItems[$k]['affiliate_discount_amt'] = 0;
                        $cItems[$k]['affiliate_discount_rate'] = 0;
                        if ($priceInfo['af_off'] > 0) {
                            if ($priceInfo['af_rate'] > 0) {
                                $cItems[$k]['affiliate_discount_rate'] = $priceInfo['af_rate'];
                            } else {
                                $cItems[$k]['affiliate_discount_amt'] = $priceInfo['af_off'];
                            }
                        }
                        // Make discount for member
                        $cItems[$k]['em_promo'] = 0;
                        if ($productInfo->pro_user != $this->session->userdata('sessionUser')) {
                            $promotion = $this->product_promotion_model->getProductPromotion(array('pro_id' => $productInfo->pro_id, 'qty' => $cItems[$k]['qty'], 'total' => ($cItems[$k]['pro_price'] * $cItems[$k]['qty'])));
                            if (!empty($promotion)) {
                                if ($promotion['dc_rate'] > 0) {
                                    $cItems[$k]['em_promo'] = $cItems[$k]['pro_price'] * $cItems[$k]['qty'] * $promotion['dc_rate'] / 100;
                                } else {
                                    $cItems[$k]['em_promo'] = $promotion['dc_amt'];
                                }
                            }
                        }
                        // get shop type
                        $cItems[$k]['shc_saler_store_type'] = $cp['store_type'];
                        $total += ($cItems[$k]['pro_price'] * $cItems[$k]['qty']) - $cItems[$k]['em_promo'];
                    }
                }
            }
        }
        
        if ($total > 0 && $total != $this->input->post('amount')) {
            $return = array('error' => true, 'message' => 'Số tiền yêu cầu thanh toán không hợp lệ', 'total' => $total);
        } elseif ($total == 0) {
            $return = array('error' => true, 'message' => 'Không có sản phẩm trong giỏ hàng. Vui lòng chọn sản phẩm');
        } else {
            // Insert order
            $this->load->model('order_model');
            $isExist = true;
            $mcode = '';

            // Tung Add user khi khach mua hang khong dang nhap
            $this->load->library('hash');
            $salt = $this->hash->key(8);
            $pass = $this->generateRandomString();
            $data_user = array(
                'use_username' => $this->input->post('ord_semail'),
                'use_salt' => $salt,
                'use_password' => $this->hash->create($pass, $salt, 'md5sha512'),
                'use_fullname' => $this->input->post('ord_sname'),
                'use_address' => $this->input->post('ord_address'),
                'use_province' => $this->input->post('user_province'),
                'user_district' => $this->input->post('user_district'),
                'use_email' => $this->input->post('ord_semail'),
                'use_status' => 1,
                'use_group' => 1,
                'parent_id' => $productInfo->pro_user,
                'use_regisdate' => time(),
                'use_mobile' => $this->input->post('ord_smobile'),
            );
            
            $user = $this->user_model->get('*', 'use_email = "' . $this->input->post('ord_semail') . '"');

            if ($user->use_id <= 0 && (int)$this->session->userdata('sessionUser') <= 0) {
                $this->user_model->add($data_user);
                $userid = $this->db->insert_id();
                $this->session->set_userdata('password', $pass);
            } elseif ($user->use_id > 0) {
                $userid = $user->use_id;
            }
            $orderUser = 0;
            if ((int)$this->session->userdata('sessionUser') > 0) {
                $orderUser = $this->session->userdata('sessionUser');
            } elseif ($userid > 0) {
                $orderUser = $userid;
            }
            // end
            $orderInfo = array(
                'date' => time(),
                'payment_method' => $this->input->post('payment_method'),
                'order_user' => $orderUser,
                'order_saler' => $sho_user,
                'af_id' => 0,
                'order_total' => $total,
                'order_total_no_shipping_fee' => $total,
                'change_status_date' => time(),
                'payment_status' => '0',
                'token' => "",
                'order_code' => time() . '_' . rand(100, 9999),
                'other_info' => "",
                'order_token' => md5(time() . rand()),
                'order_coupon_code' => $mcode,
                'order_group_id' => $this->input->post('gr_id'),
                'order_user_sale' => $this->input->post('gr_user')
            );
            if ($pro_type > 0) {
                $orderInfo['product_type'] = $pro_type;
            }
            $order_id = $this->order_model->makeOrder($orderInfo);
            if ($order_id > 0) {
                // Insert order item;
                foreach ($cart as $key => &$cItems) {
                    if ($key == $sho_user && !empty($cItems)) {
                        foreach ($cItems as $kpro => $pro) {
                            if ($pro['pro_type'] > 0) {

                                $shc_saler_parent = 0;
                                $shc_saler_parent_group = 0;
                                if ($pro['pro_user'] > 0) {
                                    $salerParent = $this->user_model->get("*", "use_id = {$pro['pro_user']}");
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
                                if ($pro['af_user'] > 0) {
                                    $afParent = $this->user_model->get("*", "use_id = {$pro['af_user']}");
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
                                $order_type = $pro['shc_saler_store_type'];
                                if ($order_type == 2) {
                                    if ($productInfo->pro_minsale <= $pro['qty']) {
                                        $order_type = 1;
                                    } else {
                                        $order_type = 0;
                                    }
                                }
                                $orderDetail = array(
                                    'shc_product' => $pro['pro_id'],
                                    'shc_dp_pro_id' => $pro['dp_id'],
                                    'shc_quantity' => $pro['qty'],
                                    'pro_category' => $pro['pro_category'],
                                    'shc_saler' => $pro['pro_user'],
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
                                    'em_discount' => $pro['em_promo'],
                                    'shc_total' => $pro['pro_price'] * $pro['qty'] - $pro['em_promo'],
                                    'af_amt' => $pro['af_amt'],
                                    'af_rate' => $pro['af_rate'],
                                    'dc_amt' => $pro['dc_amt'],
                                    'dc_rate' => $pro['dc_rate'],
                                    'affiliate_discount_amt' => $pro['affiliate_discount_amt'],
                                    'affiliate_discount_rate' => $pro['affiliate_discount_rate'],
                                    'pro_price' => $pro['pro_price'],
                                    'pro_price_original' => $pro['pro_price_original'],
                                    'pro_price_rate' => $pro['pro_price_rate'],
                                    'pro_price_amt' => $pro['pro_price_amt'],
                                    'af_id' => $pro['af_user'],
                                    'af_id_parent' => $af_id_parent,
                                    'shc_group_id' => $this->input->post('gr_id'),
                                    'shc_user_sale' => $this->input->post('gr_user'),
                                    'fl_id' => $pro['fl_id']
                                );
                                if ($this->showcart_model->add($orderDetail)) {
                                    $this->product_model->updateBuyNum($pro['pro_id']);
                                }
                                unset($orderDetail);

                                unset($cItems[$kpro]);
                            }
                        }

                        if (empty($cart[$key])) {
                            unset($cart[$key]);
                        }
                    }
                }
                // Add receive
                //$time_receive = mktime($this->input->post('ord_hour'), $this->input->post('ord_minute'), 0, $this->input->post('ord_month'), $this->input->post('ord_date'), $this->input->post('ord_year'));
                //$_province = $this->province_model->fetch('pre_name', "pre_id = " . $this->input->post('user_province'), '');
                $nganluong = array("payment_method_nganluong" => "", "bankcode" => "");
                if ($_POST['payment_method'] == "info_nganluong") {
                    $nganluong["payment_method_nganluong"] = $_POST['payment_method_nganluong'];
                    $nganluong["bankcode"] = $_POST["bankcode"];
                }
                $this->session->set_userdata('nganluong', $nganluong);
                $data_user_receive = array(
                    'use_id' => $orderUser,
                    'order_id' => $order_id,
                    'ord_sname' => $this->input->post('ord_sname'),
                    'ord_saddress' => $this->input->post('ord_address'),
                    'ord_province' => $this->input->post('user_province'),
                    'ord_district' => $this->input->post('user_district'),
                    'ord_semail' => $this->input->post('ord_semail'),
                    'ord_smobile' => $this->input->post('ord_smobile'),
                    'ord_note' => $this->input->post('ord_note')
                );
                $this->load->model('user_receive_model');
                $this->user_receive_model->add($data_user_receive);
                //$this->session->set_flashdata('_orders', $oderInfo['order_code']);//store session order
                //Clear cart
                $this->session->set_userdata('cart_coupon', $cart);

                //Clear shipping cart
                // $this->session->set_userdata('fee', array());
                //redirect(base_url() . 'dat-hang-thanh-cong');
                $return = array('error' => false, 'order_id' => $order_id, 'payment_method' => $this->input->post('payment_method'), 'order_token' => $orderInfo['order_token'], 'cart' => $cart, 'pro_type' => $pro_type);
            }
        }
        echo json_encode($return);
        exit();
    }

    public function cancelOrders($order_id)
    {
        if ($order_id) {
            $this->load->model('order_model');
            $order_info = $this->order_model->getListOrders(array('order_id' => $order_id, 'order_status' => '01'));
            if ($order_info) {                
                $this->order_model->updateOrderCode($order_info[0]->order_clientCode, '99', $order_info[0]->order_saler, $order_id, $this->input->post('info_cancel'), time());
                $this->session->set_flashdata('flash_message_success', "Hủy đơn hàng thành công");
                redirect(base_url() . 'information-order/' . $order_id . '?order_token=' . $order_info[0]->order_token);
            } else {
                $this->session->set_flashdata('flash_message_success', "Trạng thái đơn hàng không thể xóa");
                redirect(base_url() . 'information-order/' . $order_id . '?order_token=' . $order_info[0]->order_token);
            }
        } else {
            redirect(base_url());
        }
    }

    public function cancelOrdersUser($order_id)
    {
        if ($order_id) {
            $this->load->model('order_model');
            $order_info = $this->order_model->getListOrders(array('order_id' => $order_id, 'order_status' => '01'));
            if ($order_info) {
                $this->order_model->updateOrderCode($order_info[0]->order_clientCode, '99', $order_info[0]->order_saler, $order_id, $this->input->post('info_cancel'), time());
                $this->session->set_flashdata('flash_message_success', "Hủy đơn hàng thành công");
                redirect(base_url() . 'account/user_order/' . $order_id);
            } else {
                $this->session->set_flashdata('flash_message_success', "Trạng thái đơn hàng không thể xóa");
                redirect(base_url() . 'account/user_order/' . $order_id);
            }
        } else {
            redirect(base_url());
        }
    }

    public function testOrder()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->load->model('order_model');
            $this->load->model('user_receive_model');
            if ($this->input->post('order_id') > 0) {
                $order_info = $this->order_model->get('id,order_token', 'id = ' . $this->input->post('order_id'));
            }
            if ($this->input->post('order_id') > 0) {
                $user_receive_info = $this->user_receive_model->get('id,ord_semail', 'order_id = ' . $this->input->post('order_id'));
            }

            if (($order_info->id > 0) && ($user_receive_info->ord_semail == $this->input->post('order_email'))) {
                redirect(base_url() . "information-order/" . $order_info->id);
            } else {
                redirect(base_url() . "not-found-order/" . $this->input->post('order_id') . "/" . $this->input->post('order_email'));
            }
        }
    }

    function notFoundOrders($order_id, $order_email)
    {
        $data = array();
        $data['order_id'] = $order_id;
        $data['order_email'] = $order_email;
        $this->load->view('home/showcart/orders_not_found', $data);
    }

    public function printOrders($order_id = NULL)
    {
        if (!isset($_REQUEST['order_token'])) {
            redirect(base_url());
        }
        if ($order_id) {
            $data['order'] = $this->showcart_model->getOrderInformation($order_id);
            if (empty($data['order']['order_info'])) {
                redirect(base_url());
            }

            $data['shop_info'] = $this->shop_model->get('sho_email, sho_phone, sho_address, sho_dir_logo, sho_logo, sho_name', 'sho_user = ' . $data['order']['order_info']->order_saler);
            foreach (json_decode(ServiceID) as $key => $vals) {
                if ($key == $data['order_cart'][0]->ghn_ServiceID) {
                    $data['timeShip'] = $vals;
                    break;
                }
            }

            ##Load:: View
            $this->load->view('home/showcart/print_orders', $data);
        } else {
            redirect(base_url());
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

    public function add_to_cart()
    {
        $receive = $_POST['data'];
        $receive = json_decode($receive);

        if ($receive->fl_id != '') {
            $fl_id = $receive->fl_id;
        } else {
            $fl_id = 0;
        }

        $af_key = '';
        if ($receive->af_id != '') {
            $af_key = $af_id = $receive->af_id;
        } elseif ($_REQUEST['af_id'] != '') {
            $af_key = $af_id = $_REQUEST['af_id'];
        } elseif ($this->session->userdata('af_id') != '') {
            $af_id = $this->session->userdata('af_id');
        } elseif (get_cookie('affiliate_id') != '') {            
            $af_id = (int)get_cookie('affiliate_id', TRUE);
        } else {
            $af_id = '';
        }
        
        if ($receive->gr_saler != '') {
            $gr_saler = $receive->gr_saler;
        } elseif ($this->session->userdata('gr_saler') != '') {
            $gr_saler = $this->session->userdata('gr_saler');
        } elseif (get_cookie('gr_saler') != '') {            
            $gr_saler = (int)get_cookie('gr_saler', TRUE);
        } else {
            $gr_saler = '';
        }

        if ($receive->product_showcart && $this->check->is_id($receive->product_showcart)) {
            $ajax = false;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $ajax = true;
            }

            // check Product
            $check_product = $this->product_model->get('pro_type', 'pro_id = '. $receive->product_showcart .' AND pro_status = 1');

            if (empty($check_product)) {
                $result['message'] = 'Sản phẩm không tồn tại';
                echo json_encode($result);
                exit();
            }
            // end check Product 
            


            // New cart
            // Change cart
            $num_all_cart = array();
            if ($check_product->pro_type == 2) {
               $cart = $this->session->userdata('cart_coupon');
               $num_all_cart =  $this->session->userdata('cart');
            } else {
               $cart = $this->session->userdata('cart');
               $num_all_cart =  $this->session->userdata('cart_coupon');
            }
            
            $qty = $receive->qty ? $receive->qty : 1;
            $dp_id = $receive->dp_id ? $receive->dp_id : 0;
            // Sale from Group
            // $gr_id = ($this->input->post('gr_id')) ? (int)$this->input->post('gr_id') : 0;
            $gr_id = 0;
            $gr_user = ($gr_saler != '') ? (int)$this->user_model->get('use_id', 'af_key LIKE "%'. $gr_saler .'%"')->use_id : 0;            

            if (empty($cart)) {
                $cart = array();
            }
            // Count num product
            $num = 0;
            $result = array();
            $numPro = $qty;
            // Case cart existed pro_id, add number product
            if ($dp_id > 0) {
                //Nếu sẩn phẩm có Trường Qui Cách, kiểm tra id TQC
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == $receive->product_showcart && $itemCart['dp_id'] == $dp_id) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            } else {
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == $receive->product_showcart) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            }

            foreach ($num_all_cart as $item) {
                if (!empty($item)) {
                    foreach ($item as $itemCart) {
                        $num += $itemCart['qty'];
                    }
                }
            }

            if ($num + $qty <= settingOtherShowcart && $qty > 0) {
                $quycach = null;
                $select_hh = 'apply, pro_saleoff, pro_type_saleoff, begin_date_sale, end_date_sale, pro_saleoff_value, af_dc_rate, af_dc_amt, ';

                if ($dp_id > 0) {
                    //Exist Trường Qui Cách
                    $product = $this->product_model->getProAndDetailForCheckout($select_hh.'af_amt, af_rate, dc_amt, dc_rate, (T2.dp_cost) AS pro_cost,  is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_DP_QUERY .', T2.*', 'pro_id = '. $receive->product_showcart .' AND pro_status = 1', $dp_id);
                    $quycach = $product->pro_cost;
                } else {
                    //Not exist TQC
                    $product = $this->product_model->get($select_hh.' begin_date_sale, end_date_sale, af_amt, af_rate, dc_amt, dc_rate, pro_cost, is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_QUERY, 'pro_id = '. $receive->product_showcart .' AND pro_status = 1');
                }

                if (count($product) == 1 && $numPro <= $product->pro_instock && $product->pro_user != $this->session->userdata('sessionUser')) {

                    /**
                     * Xóa coupon va dich vu truoc khi them moi
                     */
                    // if ($product->pro_type > 0) {
                    //     foreach ($cart as $key => $item) {
                    //         foreach ($item as $key2 => $productItem) {
                    //             if ($productItem['pro_type'] > 0) {
                    //                 unset($item[$key2]);
                    //             }
                    //         }
                    //         if (count($item) == 0) {
                    //             unset($cart[$key]);
                    //         }
                    //     }
                    // }

                    if ($product->shop_info != '') {
                        $tmp = explode(';', $product->shop_info);
                        foreach ($tmp as $tmp_item) {
                            $val = explode(':', $tmp_item);
                            $val[0] = trim($val[0]);
                            $product->$val[0] = $val[1];
                        }
                    }

                    $wholesale = false;
                    if ($this->session->userdata('sessionUser') > 0) {
                        // Check if login user is saler shop
                        $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                        $wholesale = $shopInfo->shop_type > 0 ? true : false;
                    }

                    if ($wholesale == true && $product->shop_type < 1) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Vui lòng chọn sản phẩm của gian hàng bán sỉ';
                    } elseif ($wholesale == true && $numPro < $product->pro_minsale) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn phải mua tối thiểu '. $product->pro_minsale .' sản phẩm';
                    } else {
                        if (!isset($cart[$product->pro_user])) {
                            $cart[$product->pro_user] = array();
                        }
                        // Check exist product
                        
                        $dataHH = $this->dataGetHH($product, $af_key);
                        $hoahong = $this->checkHH($dataHH, $quycach);

                        $foundProduct = false;
                        $userObject = $this->user_model->get('use_id', 'af_key = "'. $af_id .'"');
                        $af_id = $userObject->use_id > 0 ? $userObject->use_id : 0;

                        if($gr_id > 0 && $gr_user > 0){
                            $af_id = $gr_user;
                        }

                        foreach ($cart[$product->pro_user] as &$pItem) {
                            if ($dp_id > 0) {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['dp_id'] == $product->id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = $product->id;
                                    $foundProduct = true;
                                    break;
                                }
                            } else {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = 0;
                                    $foundProduct = true;
                                    break;
                                }
                            }
                        }

                        if ($foundProduct == false) {
                            $shopItem = array();
                            $afSelect = false;
                            if ($af_id > 0 && $product->is_product_affiliate == 1) {
                                $afSelect = true;
                            }

                            $pro_price = ($hoahong['price_aff'] > 0) ? $hoahong['price_aff'] : $hoahong['priceSaleOff'];
                            // $priceInfo = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);

                            $shopItem['pro_id'] = $product->pro_id;
                            $shopItem['af_id'] = $af_id;
                            $shopItem['af_key'] = $af_key;
                            $shopItem['qty'] = $qty;
                            $shopItem['fl_id'] = $fl_id;
                            $shopItem['pro_name'] = $product->pro_name;
                            $shopItem['sho_link'] = $product->sho_link;
                            $shopItem['qty_min'] = $product->pro_minsale;
                            $shopItem['qty_max'] = $product->pro_instock;
                            $shopItem['store_type'] = $product->shop_type;
                            $shopItem['pro_type'] = $product->pro_type;
                            $shopItem['pro_user'] = $product->pro_user;
                            $shopItem['pro_weight'] = $product->pro_weight;
                            $shopItem['pro_length'] = $product->pro_length;
                            $shopItem['pro_width'] = $product->pro_width;
                            $shopItem['pro_height'] = $product->pro_height;
                            $shopItem['pro_price'] = $pro_price;
                            $shopItem['hoahong'] = $hoahong;
                            $shopItem['shipping_fee'] = 0;
                            $shopItem['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                            $shopItem['gr_id'] = ($gr_id > 0) ? $gr_id : 0;
                            $shopItem['gr_user'] = ($gr_user > 0) ? $gr_user : 0;
                            $shopItem['key'] = $product->pro_user .'_'. $product->pro_id .'_'. (count($cart[$product->pro_user]) + 1 .'_'. $shopItem['dp_id']);
                            $shopItem['image'] = 'media/images/product/'. $product->pro_dir .'/'. show_thumbnail($product->pro_dir, $product->pro_image, 1);
                            if (/*!file_exists($shopItem['image']) ||*/ $product->pro_image == ',,,' || $product->pro_image == '') {
                                $shopItem['image'] = 'media/images/noimage.png';
                            }
                            $shopItem['image'] = base_url() . $shopItem['image'];
                            $shopItem['link'] = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                            array_push($cart[$product->pro_user], $shopItem);
                        }

                        if ($check_product->pro_type == 2) {
                           $cart = $this->session->set_userdata('cart_coupon', $cart);
                        } else {
                           $cart = $this->session->set_userdata('cart', $cart);
                        }
                        
                        // Create param callback
                        $_page = '';
                        if ((int)$this->input->post('position') == 3) {
                            $_page = '/affiliate';
                        }                       

                        $strUrl = $this->mainURL;
                        $result['error'] = false;                      
                        
                        $result['message'] = '<b>'.$product->pro_name .'</b> đã được thêm vào giỏ hàng. Xem <a style="color:red;" href="'. $_page .'/v-checkout"><i class="fa fa-shopping-cart fa-fw"></i>giỏ hàng</a>.';

                        $result['num'] = $num + $qty;
                        $result['cart'] = $this->showcart_model->getCart();
                        $result['pro_type'] = $product->pro_type;
                        $result['pro_user'] = $product->pro_user;
                        $result['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                    }
                } elseif ($numPro > $product->pro_instock) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm không đủ đáp ứng yêu cầu của bạn';
                } elseif ($product->pro_user == $this->session->userdata('sessionUser')) {
                    if ($ajax) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn không thể mua sản phẩm của mình bán';
                    } else {
                        $this->session->set_flashdata('error', 'Bạn không thể mua sản phẩm của mình bán.');
                    }
                }
            } else {
                if ($ajax) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng quy định.';
                } else {
                    $this->session->set_flashdata('sessionFullProductShowcart', 1);
                }
            }
            
            if ($ajax) {                
                // Add Cart success, return result data  , AddCart & BuyNow             
                echo json_encode($result);die;
                exit();
            } else {
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
    }

    public function add_to_cart_by_attach()
    {
        $receive = $_POST['data'];
        $receive = json_decode($receive);

        $result = array();
        if( is_array($receive) && count($receive) > 0){
            foreach ($receive as $key => $item) {
                $select = 'pro_id, pro_minsale, tbtt_detail_product.id';
                $join = 'LEFT';
                $table = 'tbtt_detail_product';
                $on = 'tbtt_detail_product.dp_pro_id = pro_id';
                $where = 'pro_id = ' . (int)$item->product_showcart;
                $obj = $this->product_model->fetch_join1($select, $join, $table, $on, $where, '','', -1,0,'','')[0];
                $item->qty = $obj->pro_minsale;
                $item->dp_id = $obj->id;
                $result[$obj->pro_id] = $this->clone_add_to_cart($item);
            }
        } else {
            $select = 'pro_id, pro_minsale, tbtt_detail_product.id';
            $join = 'LEFT';
            $table = 'tbtt_detail_product';
            $on = 'tbtt_detail_product.dp_pro_id = pro_id';
            $where = 'pro_id = ' . (int)$receive->product_showcart;
            $obj = $this->product_model->fetch_join1($select, $join, $table, $on, $where, '','', -1,0,'','')[0];
            $receive->qty = $obj->pro_minsale;
            $receive->dp_id = $obj->id;
            $result = $this->clone_add_to_cart($receive);
        }
        
        // dd($result);die;
        // dd($result);die;
        echo json_encode($result);die;
    }

    public function clone_add_to_cart($receive)
    {

        if ($receive->fl_id != '') {
            $fl_id = $receive->fl_id;
        } else {
            $fl_id = 0;
        }


        if ($receive->af_id != '') {
            $af_id = $receive->af_id;
        } elseif ($_REQUEST['af_id'] != '') {
            $af_id = $_REQUEST['af_id'];
        } elseif ($this->session->userdata('af_id') != '') {
            $af_id = $this->session->userdata('af_id');
        } elseif (get_cookie('affiliate_id') != '') {            
            $af_id = (int)get_cookie('affiliate_id', TRUE);
        } else {
            $af_id = '';
        }
        
        if ($receive->gr_saler != '') {
            $gr_saler = $receive->gr_saler;
        } elseif ($this->session->userdata('gr_saler') != '') {
            $gr_saler = $this->session->userdata('gr_saler');
        } elseif (get_cookie('gr_saler') != '') {            
            $gr_saler = (int)get_cookie('gr_saler', TRUE);
        } else {
            $gr_saler = '';
        }

        if ($receive->product_showcart && $this->check->is_id($receive->product_showcart)) {
            $ajax = false;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $ajax = true;
            }

            // check Product
            $check_product = $this->product_model->get('pro_type', 'pro_id = '. $receive->product_showcart .' AND pro_status = 1');

            if (empty($check_product)) {
                $result['message'] = 'Sản phẩm không tồn tại';
                return $result;
            }
            // end check Product 
            


            // New cart
            // Change cart
            $num_all_cart = array();
            if ($check_product->pro_type == 2) {
               $cart = $this->session->userdata('cart_coupon');
               $num_all_cart =  $this->session->userdata('cart');
            } else {
               $cart = $this->session->userdata('cart');
               $num_all_cart =  $this->session->userdata('cart_coupon');
            }
            
            $qty = $receive->qty ? $receive->qty : 1;
            $dp_id = $receive->dp_id ? $receive->dp_id : 0;
            // Sale from Group
            // $gr_id = ($this->input->post('gr_id')) ? (int)$this->input->post('gr_id') : 0;
            $gr_id = 0;
            $gr_user = ($gr_saler != '') ? (int)$this->user_model->get('use_id', 'af_key LIKE "%'. $gr_saler .'%"')->use_id : 0;            

            if (empty($cart)) {
                $cart = array();
            }
            // Count num product
            $num = 0;
            $result = array();
            $numPro = $qty;
            // Case cart existed pro_id, add number product
            if ($dp_id > 0) {
                //Nếu sẩn phẩm có Trường Qui Cách, kiểm tra id TQC
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == $receive->product_showcart && $itemCart['dp_id'] == $dp_id) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            } else {
                foreach ($cart as $item) {
                    if (!empty($item)) {
                        foreach ($item as $itemCart) {
                            $num += $itemCart['qty'];
                            if ($itemCart['pro_id'] == $receive->product_showcart) {
                                $numPro += $itemCart['qty'];
                            }
                        }
                    }
                }
            }

            foreach ($num_all_cart as $item) {
                if (!empty($item)) {
                    foreach ($item as $itemCart) {
                        $num += $itemCart['qty'];
                    }
                }
            }

            if ($num + $qty <= settingOtherShowcart && $qty > 0) {
                if ($dp_id > 0) {
                    //Exist Trường Qui Cách
                    $product = $this->product_model->getProAndDetailForCheckout('af_amt, af_rate, dc_amt, dc_rate, (T2.dp_cost) AS pro_cost,  is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_DP_QUERY .', T2.*', 'pro_id = '. $receive->product_showcart .' AND pro_status = 1', $dp_id);
                } else {
                    //Not exist TQC
                    $product = $this->product_model->get('af_amt, af_rate, dc_amt, dc_rate, pro_cost, is_product_affiliate, pro_dir, pro_category, pro_image, pro_weight, pro_length, pro_width, pro_height, pro_id, pro_user, pro_name, pro_instock, pro_minsale, pro_type, (SELECT CONCAT("sho_link:", sho_link, ";shop_type:", shop_type) AS shop_info FROM tbtt_shop WHERE sho_user = pro_user) as shop_info'. DISCOUNT_QUERY, 'pro_id = '. $receive->product_showcart .' AND pro_status = 1');
                }

                if (count($product) == 1 && $numPro <= $product->pro_instock && $product->pro_user != $this->session->userdata('sessionUser')) {

                    /**
                     * Xóa coupon va dich vu truoc khi them moi
                     */
                    // if ($product->pro_type > 0) {
                    //     foreach ($cart as $key => $item) {
                    //         foreach ($item as $key2 => $productItem) {
                    //             if ($productItem['pro_type'] > 0) {
                    //                 unset($item[$key2]);
                    //             }
                    //         }
                    //         if (count($item) == 0) {
                    //             unset($cart[$key]);
                    //         }
                    //     }
                    // }

                    if ($product->shop_info != '') {
                        $tmp = explode(';', $product->shop_info);
                        foreach ($tmp as $tmp_item) {
                            $val = explode(':', $tmp_item);
                            $val[0] = trim($val[0]);
                            $product->$val[0] = $val[1];
                        }
                    }

                    $wholesale = false;
                    if ($this->session->userdata('sessionUser') > 0) {
                        // Check if login user is saler shop
                        $shopInfo = $this->shop_model->get('shop_type', 'sho_user = '. $this->session->userdata('sessionUser'));
                        $wholesale = $shopInfo->shop_type > 0 ? true : false;
                    }

                    if ($wholesale == true && $product->shop_type < 1) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Vui lòng chọn sản phẩm của gian hàng bán sỉ';
                    } elseif ($wholesale == true && $numPro < $product->pro_minsale) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn phải mua tối thiểu '. $product->pro_minsale .' sản phẩm';
                    } else {
                        if (!isset($cart[$product->pro_user])) {
                            $cart[$product->pro_user] = array();
                        }
                        // Check exist product
                        $foundProduct = false;
                        $userObject = $this->user_model->get('use_id', 'af_key = "'. $af_id .'"');
                        $af_id = $userObject->use_id > 0 ? $userObject->use_id : 0;

                        if($gr_id > 0 && $gr_user > 0){
                            $af_id = $gr_user;
                        }

                        foreach ($cart[$product->pro_user] as &$pItem) {
                            if ($dp_id > 0) {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['dp_id'] == $product->id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = $product->id;
                                    $foundProduct = true;
                                    break;
                                }
                            } else {
                                if ($pItem['pro_id'] == $product->pro_id && $pItem['af_id'] == $af_id) {
                                    $pItem['qty'] += $qty;
                                    $pItem['pro_user'] = $product->pro_user;
                                    $pItem['dp_id'] = 0;
                                    $foundProduct = true;
                                    break;
                                }
                            }
                        }

                        if ($foundProduct == false) {
                            $shopItem = array();
                            $afSelect = false;
                            if ($af_id > 0 && $product->is_product_affiliate == 1) {
                                $afSelect = true;
                            }

                            $priceInfo = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                            $shopItem['pro_id'] = $product->pro_id;
                            $shopItem['af_id'] = $af_id;
                            $shopItem['qty'] = $qty;
                            $shopItem['fl_id'] = $fl_id;
                            $shopItem['pro_name'] = $product->pro_name;
                            $shopItem['sho_link'] = $product->sho_link;
                            $shopItem['qty_min'] = $product->pro_minsale;
                            $shopItem['qty_max'] = $product->pro_instock;
                            $shopItem['store_type'] = $product->shop_type;
                            $shopItem['pro_type'] = $product->pro_type;
                            $shopItem['pro_user'] = $product->pro_user;
                            $shopItem['pro_weight'] = $product->pro_weight;
                            $shopItem['pro_length'] = $product->pro_length;
                            $shopItem['pro_width'] = $product->pro_width;
                            $shopItem['pro_height'] = $product->pro_height;
                            $shopItem['pro_price'] = $priceInfo['salePrice'];
                            $shopItem['shipping_fee'] = 0;
                            $shopItem['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                            $shopItem['gr_id'] = ($gr_id > 0) ? $gr_id : 0;
                            $shopItem['gr_user'] = ($gr_user > 0) ? $gr_user : 0;
                            $shopItem['key'] = $product->pro_user .'_'. $product->pro_id .'_'. (count($cart[$product->pro_user]) + 1 .'_'. $shopItem['dp_id']);
                            $shopItem['image'] = 'media/images/product/'. $product->pro_dir .'/'. show_thumbnail($product->pro_dir, $product->pro_image, 1);
                            if (/*!file_exists($shopItem['image']) ||*/ $product->pro_image == ',,,' || $product->pro_image == '') {
                                $shopItem['image'] = 'media/images/noimage.png';
                            }
                            $shopItem['image'] = base_url() . $shopItem['image'];
                            $shopItem['link'] = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                            array_push($cart[$product->pro_user], $shopItem);
                        }

                        if ($check_product->pro_type == 2) {
                           $cart = $this->session->set_userdata('cart_coupon', $cart);
                        } else {
                           $cart = $this->session->set_userdata('cart', $cart);
                        }
                        
                        // Create param callback
                        $_page = '';
                        if ((int)$this->input->post('position') == 3) {
                            $_page = '/affiliate';
                        }                       

                        $strUrl = $this->mainURL;
                        $result['error'] = false;                      
                        
                        $result['message'] = $product->pro_name .' đã được thêm vào giỏ hàng. Xem <a style="color:red;" href="'. $_page .'/v-checkout"><i class="fa fa-shopping-cart fa-fw"></i>giỏ hàng</a>.';

                        $result['num'] = $num + $qty;
                        $result['cart'] = $this->showcart_model->getCart();
                        $result['pro_type'] = $product->pro_type;
                        $result['pro_user'] = $product->pro_user;
                        $result['dp_id'] = ($dp_id > 0) ? $product->id : 0;
                    }
                } elseif ($numPro > $product->pro_instock) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm không đủ đáp ứng yêu cầu của bạn';
                } elseif ($product->pro_user == $this->session->userdata('sessionUser')) {
                    if ($ajax) {
                        $result['error'] = TRUE;
                        $result['message'] = 'Bạn không thể mua sản phẩm của mình bán';
                    } else {
                        $this->session->set_flashdata('error', 'Bạn không thể mua sản phẩm của mình bán.');
                    }
                }
            } else {
                if ($ajax) {
                    $result['error'] = TRUE;
                    $result['message'] = 'Số lượng sản phẩm trong giỏ hàng vượt quá số lượng quy định.';
                } else {
                    $this->session->set_flashdata('sessionFullProductShowcart', 1);
                }
            }
            
            if ($ajax) {                
                // Add Cart success, return result data  , AddCart & BuyNow             
                return $result;
            } else {
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
    }

}