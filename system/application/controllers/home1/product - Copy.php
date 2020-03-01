<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Product extends MY_Controller
{
    private $mainURL;
    private $subURL;
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
        
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/product');
        $this->load->helper('cookie');
        $this->load->helper('product_helper');
        #Load model
        $this->load->model('product_model');
        $this->load->model('detail_product_model');
        $this->load->model('content_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('package_user_model');
        $this->load->model('common_model');
        $this->load->model('eye_model');
        $this->load->model('product_promotion_model');
        $this->load->model('ads_model');
        $this->load->model('notify_model');
        $this->load->model('product_favorite_model');
        $this->load->model('af_product_model');
        $this->load->model('branch_model');
   

        $data = $this->common_model->getPackageAccount();
        $this->mainURL = $this->getMainDomain();

        #BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }
        #END Update counter
        #BEGIN Eye
        if ($this->session->userdata('sessionUser') > 0) {
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
        #END Eye
        #BEGIN: Ads & Notify Taskbar        
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;
        $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;
        $shoptypeMessage = $this->content_model->fetch("not_id, not_title,not_detail", "not_id = 20 AND not_status = 1", "not_id", "DESC", 0, 1);
        //print_r($shoptypeMessage);die();
        $data['shoptypeMessage'] = $shoptypeMessage;
        #BEGIN: Top lastest ads right
        $select = "ads_id, ads_title, ads_descr, ads_category";
        $start = 0;
        $limit = (int)settingAdsNew_Top;
        $data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        # Tin tức        
        $select = "not_id, not_title, not_image,not_dir_image, not_begindate";
        $data['listNews'] = $this->content_model->fetch($select, "not_status = 1 AND cat_type = 1", "not_id", "DESC", 0, 10);
        # Hàng gợi ý        
        $select = "pro_id, pro_name, pro_cost, pro_image, pro_dir,pro_category, ";
        $whereTmp = "pro_status = 1  and is_asigned_by_admin = 0";
        $products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC", 0, 10);
        $data['products'] = $products;
        # Hàng yêu thích       
        $select = 'prf_id, prf_product, prf_user, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost ';
        $join = 'INNER';
        $table = 'tbtt_product';
        $on = 'tbtt_product_favorite.prf_product = tbtt_product.pro_id';
        $where = 'prf_user = ' . (int)$this->session->userdata('sessionUser');
        $data['favoritePro'] = $this->product_favorite_model->fetch_join($select, $join, $table, $on, $where, 0, 10);
        #END Notify        
        $shop = $this->shop_model->get("sho_link, sho_package", "sho_user = " . (int)$this->session->userdata('sessionUser'));
        $data['shoplink'] = $shop->sho_link;
        $data['productCategoryRoot'] = $this->loadProductCategoryRoot(0, 5);
        $data['productCategoryHot'] = $this->loadCategoryHot(0, 0);
        $data['globalProduct'] = 1;

        #Load menu cho Chi nhanh theo GH cha cua no, Quan Ly Nhan Vien        
        if ($this->session->userdata('sessionGroup') == BranchUser) {
            $UserID = (int)$this->session->userdata('sessionUser');
            $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
            if ($u_pa) {
                $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
            }
        }
       
        if($this->session->userdata('sessionUser')) {
            $sessionUser = (int)$this->session->userdata('sessionUser');
            $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. $sessionUser . ' AND use_status = 1');
            $data['currentuser'] = $cur_user;

            if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2){
                $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $sessionUser);
            } else {
                $parentUser = $this->user_model->get("parent_id","use_id = " . $sessionUser);
                $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
            }           
                
        }
		
        $data['mainURL'] = $this->getMainDomain();

        $this->load->model('grouptrade_model');
        $list_grouptrade = $this->grouptrade_model->fetch('grt_id,grt_name', 'grt_admin = "' . $this->session->userdata('sessionUser') . '"');
        $data['list_grouptrade'] = $list_grouptrade;
        
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }	
	
        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }

    function loadProductCategoryRoot($parent, $level)
    {
        $select = "*";
        $whereTmp = "cat_status = 1 AND parent_id = ". $parent;
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $category;
    }

    public function loadTest()
    {
        $select = "*";
        $whereTmp = "cat_status = 1";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC", 0, 10);
        return $category;
    }

    function loadSubSubCategoryCut($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1 and parent_id = ". $parent;
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<ul>";
            foreach ($category as $key => $row) {
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $image = '<img src="' . base_url() . 'images/icon/icon' . $row->cat_id . '.png"/>';
                $retArray .= "<li>" . $image . $link . "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    function loadCategoryHot($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1 AND parent_id = ". $parent ." AND cat_hot = 1 ";
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
        $whereTmp = "cat_status = 1 AND parent_id = ". $parent ." AND cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        $retArray .= '<ul class="supcat">';
        foreach ($category as $key => $row) {
            $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
            $retArray .= '<li> - ' . $link . '</li>';
        }
        $retArray .= '</ul>';
        return $retArray;
    }


    function getChildCategory($category, $cateType, &$listcat) {
        foreach ($category as $key => $item) {
            $catitemlv2 = $this->category_model->fetch("cat_id,cat_name, cate_type", "cat_status = 1 AND parent_id = " . (int)$item->cat_id . ' AND cate_type = ' . (int)$cateType);
            if (count($catitemlv2) > 0) {
                $list_cate = $this->getChildCategory($catitemlv2, (int)$cateType, $listcat);

                // foreach ($catitemlv2 as $itemlv2) {
                //     if ($listcat == '') {
                //         $listcat .= $itemlv2->cat_id;
                //     } else {
                //         $listcat .= ',' . $itemlv2->cat_id;
                //     }
                // }
            } else {
                if ($listcat == '') {
                    $listcat .= $item->cat_id;
                } else {
                    $listcat .= ',' . $item->cat_id;
                }
            }
        }
        return $listcat;
        
    }
    

    function category($categoryID)
    {
        $this->load->model('category_model');
        $linkDetail = $this->uri->segment(1);
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        $siteGlobal = $this->category_model->get("*", "cat_id = '" . $linkDetail . "'");
        $data['siteGlobal'] = $siteGlobal;
        
	/*$data['shop_glonal_conten'] = $this->loadSubSubCategoryCut($linkDetail);
        $CategoryPro = $this->category_model->get("*", "cat_id = '" . $siteGlobal->parent_id . "'");
        $data['CategorysiteGlobal'] = $CategoryPro;
        $data['CategorysiteGlobalConten'] = $this->loadSubSubCategoryCut($CategoryPro->cat_id);
        $CategoryRoot = $this->category_model->get("*", "cat_id = '" . $CategoryPro->parent_id . "'");
        $data['CategorysiteGlobalRoot'] = $CategoryRoot;
        $data['CategorysiteRootConten'] = $this->loadSubSubCategoryCut($CategoryRoot->cat_id);*/
	
        $this->load->model('province_model');
        $data['province'] = $this->province_model->fetch('pre_id, pre_name, pre_order', "pre_status = 1", "pre_order", "ASC", 1, -1);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;

        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        #
        #
        #BEGIN: Check exist category by $categoryID  $id_cat = (int)$this->uri->segment(1);
        $category = $this->category_model->get("cat_id, cat_name, cat_level, parent_id, cat_descr, keyword, h1tag, cate_type", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        $data['categoryName'] = $category->cat_name;
	
	if($category->cate_type == 0){
	    $data['menuActive'] = 'product';
	} else {
	    $data['menuActive'] = 'coupon';
	}
	if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        } else {
            $data['catlv2'] = $category->cat_level;
        }

        $categoryIsParent = $this->category_model->get("cat_id, cat_name, cat_level, parent_id, cat_descr, keyword, h1tag, cate_type", "parent_id = " . (int)$categoryID . " AND cat_status = 1");

        if (count($categoryIsParent) == 0) {
            $data['endCat'] = 1;
        } else {
            $data['endCat'] = 0;
        }
        $data['levelCat'] = $category->cat_level;
        // print_r($listcat); die;
        #END Check exist category by $categoryID 

        #BEGIN get sub cat
        $listcat = '';
        if ($category->cat_level < 4) {
            // get sub category level 1
            $catlevel1 = $this->category_model->fetch("cat_id, cat_name, cate_type, cat_image, cat_level", "cat_status = 1 AND  parent_id = " . (int)$category->cat_id . ' AND cate_type = ' . (int)$category->cate_type, 'cat_name', 'ASC');
            if (isset($catlevel1) && count($catlevel1) > 0) {
                foreach ($catlevel1 as $key => $item) {
                    // get sub category level 2
                    $catitemlv2 = $this->category_model->fetch("cat_id,cat_name, cate_type", "cat_status = 1 AND parent_id = " . (int)$item->cat_id . ' AND cate_type = ' . (int)$category->cate_type);
                    $catlevel1[$key]->cat_level2 = $catitemlv2;
                    if (count($catitemlv2) > 0) {
                        $list_cate = $this->getChildCategory($catitemlv2, (int)$category->cate_type, $listcat);

                        // foreach ($catitemlv2 as $itemlv2) {
                        //     if ($listcat == '') {
                        //         $listcat .= $itemlv2->cat_id;
                        //     } else {
                        //         $listcat .= ',' . $itemlv2->cat_id;
                        //     }
                        // }
                    } else {
                        if ($listcat == '') {
                            $listcat .= $item->cat_id;
                        } else {
                            $listcat .= ',' . $item->cat_id;
                        }
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
            $data['categorylv1'] = $catlevel1;
        }

        if ($category->cat_level >= 4) {
            $catlevel2 = $this->category_model->fetch("cat_id, cat_name, cate_type, cat_image", "cat_status = 1 AND cat_level = 2 AND parent_id = " . (int)$category->cat_id . ' AND cate_type = ' . (int)$category->cate_type);
            $data['categorylv2'] = $catlevel2;
            if (count($catlevel2) > 0) {
                foreach ($catlevel2 as $itemlv2) {
                    if ($listcat == '') {
                        $listcat .= $itemlv2->cat_id;
                    } else {
                        $listcat .= ',' . $itemlv2->cat_id;
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
        }
        // if ($category->cat_level == 2) {
        //     $listcat = (int)$categoryID;
        // }
        #END
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
	
        $data['menuType'] = 'product';
	
        //$retArray = $this->loadCategory(0, 0);
        //$data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'home';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe, cat_id", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "id, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_begindate, pro_saleoff_value, pro_type_saleoff, pro_saleoff, pro_view, pro_type";
       
        $start = 0;
        //$limit = (int)settingProductSaleoff_Top;
        $where_topSaleoffProduct = "tbtt_product.pro_category IN (" . $listcat . ") AND tbtt_product.pro_saleoff = 1 AND tbtt_product.pro_status = 1 AND tbtt_shop.sho_status = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))";
        if ($this->session->userdata['s_province']) {
            $where_topSaleoffProduct = "tbtt_product.pro_category IN (" . $listcat . ") AND tbtt_product.pro_saleoff = 1 AND tbtt_product.pro_status = 1 AND tbtt_shop.sho_status = 1 AND (sho_province = " . $this->session->userdata["s_province"] . ") OR tbtt_shop.sho_provinces LIKE '%," . $this->session->userdata["s_province"] . ",%'";
        }
        $limit = 8;
        $topSaleoffProduct = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_product.pro_id = tbtt_detail_product.dp_pro_id", $where_topSaleoffProduct, "rand()", "DESC", $start, $limit, FALSE, NULL);
        
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "id, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_buy, pro_category, pro_image, pro_dir, pro_saleoff_value, pro_type_saleoff, pro_saleoff, pro_view, pro_type";
        
        $start = 0;
        //$limit = (int)settingProductBuyest_Top;
        $limit = 8;
        $where_topBuyestProduct = "pro_category IN (" . $listcat . ") AND pro_buy > 0 AND pro_status = 1 AND sho_status = 1 ";
        if ($this->session->userdata['s_province']) {
            $where_topBuyestProduct = "pro_category IN (" . $listcat . ") AND pro_buy > 0 AND pro_status = 1 AND sho_status = 1 AND (sho_province = " . $this->session->userdata["s_province"] . ") OR tbtt_shop.sho_provinces LIKE '%," . $this->session->userdata["s_province"] . ",%'";
        }

        $topBuyestProduct = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_product.pro_id = tbtt_detail_product.dp_pro_id", $where_topBuyestProduct, "rand()", "DESC", $start, $limit, FALSE, NULL);
        #END Top product buyest right

        #BEGIN: Reliable product
        $select = "id, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category, pro_saleoff_value, pro_type_saleoff, pro_saleoff, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, sho_user, pro_type";
        $start = 0;
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort = '/page/' . $start;
        } else {
            $start = 0;
        }
        //if ((int)$this->uri->segment(4) == 1)
        //$limit = (int)settingProductReliable_Category;
        $limit = 60;
        $this->load->library('pagination');
        $totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category IN (" . $listcat . ")  AND pro_status = 1"));
        $config['base_url'] = base_url() . $categoryID . '/' . $this->uri->segment(2) . '/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['url_search'] = "" . base_url() . $categoryID . "/" . $this->uri->segment(2) . "/" . $pageUrl . "/page/" . $start . "";
        $data['linkPage1'] = $this->pagination->create_links();
        $data['start'] = $start;
        $data['totalRecord'] = $totalRecord;
        $data['sTT'] = $start + 1;
        $filter = $this->uri->segment(3);
        switch ($filter) {
            case 'giam-gia':
                $order = 'pro_saleoff';
                break;
            case 'ban-chay':
                $order = 'pro_buy';
                break;
            case 'dam-bao':
                $sql = '';
                break;
            default :
                $order = 'pro_id';
                break;
        }
        //echo DISCOUNT_QUERY; die;
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $subcat = $listcat;
        //array_push($subcat, $listcat);
        $catFilter = array('subcat1' => $subcat, 'start' => $start * 1, 'limit' => settingProductNew_Category);
        $reliableProduct = $this->product_model->fetchCategory($select . DISCOUNT_QUERY, $catFilter, $this->session->userdata["s_province"]);


        $data['filter'] = $this->product_model->getFilter();

        $this->load->model('like_product_model');

        //   print_r($this->db->last_query()); exit;
        $select = "tbtt_product.pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff, pro_saleoff_value, pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name, pro_detail, sho_user, pro_type";
        $start = 0;
        $limit = 8;
        $where_favoriteProduct = "pro_category IN (" . $listcat . ") AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND sho_status = 1 ";
        if ($this->session->userdata['s_province']) {
            $where_favoriteProduct = "pro_category IN (" . $listcat . ") AND pro_image != 'none.gif' AND pro_cost > 0  AND pro_status = 1 AND sho_status = 1 AND (sho_province = " . $this->session->userdata["s_province"] . ") OR tbtt_shop.sho_provinces LIKE '%," . $this->session->userdata["s_province"] . ",%'";
        }
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        #BEGIN: Sort        $getVar = $this->uri->uri_to_assoc(3, $action);
        $where = "pro_category IN(" . $listcat . ") AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';

        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
                    break;
                case 'vote':
                    $pageUrl .= '/sort/vote';
                    $sort = "pro_vote_total";
                    break;
                case 'comment':
                    $pageUrl .= '/sort/comment';
                    $sort = "pro_comment";
                    break;
                case 'reputation':
                    $pageUrl .= '/sort/reputation';
                    $sort = "uytin";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }

        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . $categoryID . '/' . removeSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        //$totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        unset($config);
        $totalRecord = $this->product_model->fetchCategory($select . DISCOUNT_QUERY, array('subcat1' => $subcat), $this->session->userdata["s_province"], TRUE);

        $config['base_url'] = base_url() . $categoryID . "/" . removeSign($category->cat_name) . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        #END Pagination
        if ($this->session->userdata('sessionUser')) {
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $af_id = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
                $data['af_id'] = $af_id->af_key ? $af_id->af_key : "";
            }
        }

        $af_id = $data['af_id'] ? '?af_id=' . $data['af_id'] : '';

        if ($category->h1tag != '') {
            $data['titleSiteGlobal'] = str_replace(",", "|", $category->h1tag);
        } else {
            $data['titleSiteGlobal'] = $category->cat_name;
        }
        $data['descrSiteGlobal'] = $category->cat_descr;
        $data['keywordSiteGlobal'] = $category->keyword;
        $data['ogurl'] = base_url() . $category->cat_id . '/' . RemoveSign($category->cat_name) . $af_id;
        $data['ogtype'] = "website";
        $data['ogtitle'] = $category->cat_name;
        $data['ogdescription'] = $category->cat_descr;
        $data['ogimage'] = DOMAIN_CLOUDSERVER . 'templates/home/images/category/cat-' . $category->cat_id . '.png';
        $data['h1tagSiteGlobal'] = $category->h1tag;
        #Fetch record

        $select = "id, pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_type_saleoff, pro_saleoff_value, pro_view, sho_name, sho_begindate, pre_name, pro_detail, pro_vote_total, pro_vote as uytin, pro_vote_total, pro_vote, pro_type";
        
        //$limit = settingProductNew_Category;
        $limit = 8;
        $where_newProduct = "tbtt_product.pro_category IN (" . $listcat . ") AND tbtt_product.pro_status = 1 AND sho_status = 1 ";
        if ($this->session->userdata['s_province']) {
            $where_newProduct = "tbtt_product.pro_category IN (" . $listcat . ") AND tbtt_product.pro_status = 1  AND sho_status = 1 AND (sho_province = " . $this->session->userdata["s_province"] . ") OR tbtt_shop.sho_provinces LIKE '%," . $this->session->userdata["s_province"] . ",%'";
        }
        $protab = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_product.pro_id = tbtt_detail_product.dp_pro_id", $where_newProduct, $sort, $by, $start, $limit, FALSE, NULL);
        
        $favoriteProduct = $this->like_product_model->fetch_join4('*, tbtt_product.pro_id, tbtt_detail_product.id, count(tbtt_like_product.pro_id) as countlike' . DISCOUNT_QUERY, "LEFT","tbtt_product","tbtt_product.pro_id = tbtt_like_product.pro_id", "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_product.pro_id = tbtt_detail_product.dp_pro_id", $where_favoriteProduct, "countlike", "DESC", $start, $limit, FALSE,NULL);
            
        if($this->session->userdata('sessionUser')){
            if(count($protab) > 0){
                foreach ($protab as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($topBuyestProduct) > 0){
                foreach ($topBuyestProduct as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($topSaleoffProduct) > 0){
                foreach ($topSaleoffProduct as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($reliableProduct) > 0){
                foreach ($reliableProduct as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            if(count($favoriteProduct['data']) > 0){
                foreach ($favoriteProduct['data'] as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
        }
        $data['favoriteProduct'] = $favoriteProduct['data'];
        $data['topBuyestProduct'] = $topBuyestProduct;
        $data['topSaleoffProduct'] = $topSaleoffProduct;
        $data['reliableProduct'] = $reliableProduct;
        $data['newProduct'] = $protab;
        // print_r($this->db->last_query()); die;
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        $this->load->model('province_model');
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");

        #Load view
        $this->load->view('home/product/category', $data);
    }

    function muanhieunhat($categoryID)
    {
        $this->load->model('category_model');
        $linkDetail = $this->uri->segment(1);
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        $siteGlobal = $this->category_model->get("*", "cat_id = '" . $linkDetail . "'");
        $data['siteGlobal'] = $siteGlobal;
        $data['shop_glonal_conten'] = $this->loadSubSubCategoryCut($linkDetail);
        $CategoryPro = $this->category_model->get("*", "cat_id = '" . $siteGlobal->parent_id . "'");
        $data['CategorysiteGlobal'] = $CategoryPro;
        $data['CategorysiteGlobalConten'] = $this->loadSubSubCategoryCut($CategoryPro->cat_id);
        //echo $CategoryPro->cat_id;die();
        $CategoryRoot = $this->category_model->get("*", "cat_id = '" . $CategoryPro->parent_id . "'");
        $data['CategorysiteGlobalRoot'] = $CategoryRoot;
        $data['CategorysiteRootConten'] = $this->loadSubSubCategoryCut($CategoryRoot->cat_id);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        #BEGIN: Check exist category by $categoryID
        $category = $this->category_model->get("cat_id, cat_name, cat_level, cat_descr", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        print_r($category);
        die;
        $data['categoryName'] = $category->cat_name;
        #END Check exist category by $categoryID
        #BEGIN get sub cat
        $listcat = '';
        if ($category->cat_level < 4) {
            // get sub category level 1
            $catlevel1 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 1 AND parent_id = " . (int)$category->cat_id);
            if (isset($catlevel1) && count($catlevel1) > 0) {
                foreach ($catlevel1 as $key => $item) {
                    // get sub category level 2
                    $catitemlv2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$item->cat_id);
                    $catlevel1[$key]->cat_level2 = $catitemlv2;
                    if (count($catitemlv2) > 0) {
                        foreach ($catitemlv2 as $itemlv2) {
                            if ($listcat == '') {
                                $listcat .= $itemlv2->cat_id;
                            } else {
                                $listcat .= ',' . $itemlv2->cat_id;
                            }
                        }
                    } else {
                        if ($listcat == '') {
                            $listcat .= $item->cat_id;
                        } else {
                            $listcat .= ',' . $item->cat_id;
                        }
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
            $data['categorylv1'] = $catlevel1;
        }
        if ($category->cat_level == 1) {
            $catlevel2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$category->cat_id);
            $data['categorylv2'] = $catlevel2;
            if (count($catlevel2) > 0) {
                foreach ($catlevel2 as $itemlv2) {
                    if ($listcat == '') {
                        $listcat .= $itemlv2->cat_id;
                    } else {
                        $listcat .= ',' . $itemlv2->cat_id;
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
        }
        if ($category->cat_level == 2) {
            $listcat = (int)$categoryID;
        }
        #END
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0); 
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        // $limit = (int)settingProductBuyest_Top;
        $limit = 8;
        $data['topBuyestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_buy > 0 AND pro_status = 1", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category, pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 60;//(int)settingProductReliable_Category;
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_buy > 0 AND pro_reliable = 1 AND pro_status = 1", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail";
        $start = 0;
        $limit = 8;
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_buy > 0 AND  pro_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Sort
        $where = "pro_buy > 0  AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
                    break;
                case 'vote':
                    $pageUrl .= '/sort/vote';
                    $sort = "pro_vote_total";
                    break;
                case 'comment':
                    $pageUrl .= '/sort/comment';
                    $sort = "pro_comment";
                    break;
                case 'reputation':
                    $pageUrl .= '/sort/reputation';
                    $sort = "uytin";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . $categoryID . '/' . removeSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . $categoryID . "/" . removeSign($category->cat_name) . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        $data['titleSiteGlobal'] = $category->cat_name;
        $this->load->helper('text');
        $data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)), 255);
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail, pro_vote_total, pro_vote as uytin,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/muanhieunhat', $data);
    }

    function cungnhasanxuat($categoryID)
    {
        $this->load->model('category_model');
        $linkDetail = $this->uri->segment(1);
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        $siteGlobal = $this->category_model->get("*", "cat_id = '" . $linkDetail . "'");
        $data['siteGlobal'] = $siteGlobal;
        $data['shop_glonal_conten'] = $this->loadSubSubCategoryCut($linkDetail);
        $CategoryPro = $this->category_model->get("*", "cat_id = '" . $siteGlobal->parent_id . "'");
        $data['CategorysiteGlobal'] = $CategoryPro;
        $data['CategorysiteGlobalConten'] = $this->loadSubSubCategoryCut($CategoryPro->cat_id);
        $CategoryRoot = $this->category_model->get("*", "cat_id = '" . $CategoryPro->parent_id . "'");
        $data['CategorysiteGlobalRoot'] = $CategoryRoot;
        $data['CategorysiteRootConten'] = $this->loadSubSubCategoryCut($CategoryRoot->cat_id);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        #BEGIN: Check exist category by $categoryID
        $category = $this->category_model->get("cat_id, cat_name, cat_level, cat_descr", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        $data['categoryName'] = $category->cat_name;
        $listcat = '';
        if ($category->cat_level == 0) {
            // get sub category level 1
            $catlevel1 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 1 AND parent_id = " . (int)$category->cat_id);
            if (isset($catlevel1) && count($catlevel1) > 0) {
                foreach ($catlevel1 as $key => $item) {
                    // get sub category level 2
                    $catitemlv2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$item->cat_id);
                    $catlevel1[$key]->cat_level2 = $catitemlv2;
                    if (count($catitemlv2) > 0) {
                        foreach ($catitemlv2 as $itemlv2) {
                            if ($listcat == '') {
                                $listcat .= $itemlv2->cat_id;
                            } else {
                                $listcat .= ',' . $itemlv2->cat_id;
                            }
                        }
                    } else {
                        if ($listcat == '') {
                            $listcat .= $item->cat_id;
                        } else {
                            $listcat .= ',' . $item->cat_id;
                        }
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
            $data['categorylv1'] = $catlevel1;
        }
        if ($category->cat_level == 1) {
            $catlevel2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$category->cat_id);
            $data['categorylv2'] = $catlevel2;
            if (count($catlevel2) > 0) {
                foreach ($catlevel2 as $itemlv2) {
                    if ($listcat == '') {
                        $listcat .= $itemlv2->cat_id;
                    } else {
                        $listcat .= ',' . $itemlv2->cat_id;
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
        }
        if ($category->cat_level == 2) {
            $listcat = (int)$categoryID;
        }
        #END
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        //$limit = (int)settingProductSaleoff_Top;
        $limit = 8;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_buy > 0 AND pro_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category, pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote";
        $start = 0;
        $limit = (int)settingProductReliable_Category;
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_buy > 0 AND pro_reliable = 1 AND pro_status = 1  AND pro_manufacturer_id = " . (int)$categoryID, "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail";
        $start = 0;
        $limit = 8;
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_buy > 0 AND  pro_status = 1  AND pro_manufacturer_id = " . (int)$categoryID, "pro_vote", "DESC", $start, $limit);
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Sort
        $where = "pro_manufacturer_id = " . (int)$categoryID . "  AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
                    break;
                case 'vote':
                    $pageUrl .= '/sort/vote';
                    $sort = "pro_vote_total";
                    break;
                case 'comment':
                    $pageUrl .= '/sort/comment';
                    $sort = "pro_comment";
                    break;
                case 'reputation':
                    $pageUrl .= '/sort/reputation';
                    $sort = "uytin";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . $categoryID . '/' . removeSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . $categoryID . "/" . removeSign($category->cat_name) . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        $data['titleSiteGlobal'] = $category->cat_name;
        $this->load->helper('text');
        $data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($category->cat_descr)), 255);
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail, pro_vote_total, pro_vote as uytin,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/cungnhasanxuat', $data);
    }

    //xem tat ca
    function xemtatca($categoryID)
    {
        $this->load->model('category_model');
        $linkDetail = $this->uri->segment(3);
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        $siteGlobal = $this->category_model->get("*", "cat_id = '" . $linkDetail . "'");
        $data['siteGlobal'] = $siteGlobal;
        $data['shop_glonal_conten'] = $this->loadSubSubCategoryCut($linkDetail);
        $CategoryPro = $this->category_model->get("*", "cat_id = '" . $siteGlobal->parent_id . "'");
        $data['CategorysiteGlobal'] = $CategoryPro;
        $data['CategorysiteGlobalConten'] = $this->loadSubSubCategoryCut($CategoryPro->cat_id);
        //echo $CategoryPro->cat_id;die();
        $CategoryRoot = $this->category_model->get("*", "cat_id = '" . $CategoryPro->parent_id . "'");
        $data['CategorysiteGlobalRoot'] = $CategoryRoot;
        $data['CategorysiteRootConten'] = $this->loadSubSubCategoryCut($CategoryRoot->cat_id);
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        #BEGIN: Check exist category by $categoryID
        $category = $this->category_model->get("cat_id, cat_name, cat_level", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        $data['categoryName'] = $category->cat_name;
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }
        #END Check exist category by $categoryID
        #BEGIN get sub cat
        $listcat = '';
        if ($category->cat_level == 0) {
            // get sub category level 1
            $catlevel1 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 1 AND parent_id = " . (int)$category->cat_id);
            if (isset($catlevel1) && count($catlevel1) > 0) {
                foreach ($catlevel1 as $key => $item) {
                    // get sub category level 2
                    $catitemlv2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$item->cat_id);
                    $catlevel1[$key]->cat_level2 = $catitemlv2;
                    if (count($catitemlv2) > 0) {
                        foreach ($catitemlv2 as $itemlv2) {
                            if ($listcat == '') {
                                $listcat .= $itemlv2->cat_id;
                            } else {
                                $listcat .= ',' . $itemlv2->cat_id;
                            }
                        }
                    } else {
                        if ($listcat == '') {
                            $listcat .= $item->cat_id;
                        } else {
                            $listcat .= ',' . $item->cat_id;
                        }
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
            $data['categorylv1'] = $catlevel1;
        }
        if ($category->cat_level == 1) {
            $catlevel2 = $this->category_model->fetch("cat_id,cat_name", "cat_level = 2 AND parent_id = " . (int)$category->cat_id);
            $data['categorylv2'] = $catlevel2;
            if (count($catlevel2) > 0) {
                foreach ($catlevel2 as $itemlv2) {
                    if ($listcat == '') {
                        $listcat .= $itemlv2->cat_id;
                    } else {
                        $listcat .= ',' . $itemlv2->cat_id;
                    }
                }
            } else {
                $listcat = (int)$category->cat_id;
            }
        }
        if ($category->cat_level == 2) {
            $listcat = (int)$categoryID;
        }
        #END
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_status = 1  AND sho_status = 1  ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_buy > 0 AND pro_status = 1  AND sho_status = 1", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category, pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote,pro_detail";
        $start = 0;
        $limit = (int)settingProductReliable_Category;
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category IN (" . $listcat . ") AND pro_reliable = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote,pro_detail";
        $start = 0;
        $limit = 8;
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category IN (" . $listcat . ")  AND pro_status = 1  AND sho_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        #BEGIN: Sort
        $where = "pro_category IN(" . $listcat . ") AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
                    break;
                case 'vote':
                    $pageUrl .= '/sort/vote';
                    $sort = "pro_vote_total";
                    break;
                case 'comment':
                    $pageUrl .= '/sort/comment';
                    $sort = "pro_comment";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . $categoryID . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . $categoryID . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where . " AND sho_status = 1", $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/xemtatca', $data);
    }

    function all()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate,pro_detail";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir,pro_detail";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_buy > 0 AND pro_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category,pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = (int)settingProductReliable_Category;
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_reliable = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail";
        $start = 0;
        $limit = 8;
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Sort
        $where = "pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'product/all/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort

        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'product/all/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination	
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);

        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view        
        $this->load->view('home/product/all', $data);
    }

    function giamgia()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate,pro_detail";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir,pro_detail";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_buy > 0 AND pro_status = 1  AND sho_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category,pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 60;//(int)settingProductReliable_Category;
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 8;
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1  AND sho_status = 1  ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        #BEGIN: Sort
        $where = "pro_saleoff = 1 AND pro_status = 1 AND pro_cost>0 ";
        $sort = 'pro_cost';
        $by = 'ASC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'giamgia/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'giamgia/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where . " AND sho_status = 1 ", $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/giamgia', $data);
    }

    function cheapest($categoryID)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        $category = $this->category_model->get("cat_id, cat_name", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        $data['categoryName'] = $category->cat_name;
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }
        #END Check exist category by $categoryID
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_buy > 0 AND pro_status = 1  AND sho_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category,pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 60;//(int)settingProductReliable_Category;
        $this->db->order_by("pro_cost", "ASC");
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = $categoryIDQuery  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_reliable = 1 AND pro_status = 1  AND sho_status = 1", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 8;
        $this->db->order_by("pro_cost", "ASC");
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = $categoryIDQuery  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1  AND sho_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        #BEGIN: Sort
        $where = "pro_category = $categoryIDQuery  AND pro_cost > 0 AND pro_status = 1 ";
        $sort = 'pro_cost';
        $by = 'ASC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'renhat/' . $categoryID . '/' . RemoveSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'renhat/' . $categoryID . "/" . RemoveSign($category->cat_name) . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where . " AND sho_status = 1", $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/cheapest', $data);
    }

    function topweek($categoryID)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        $category = $this->category_model->get("cat_id, cat_name", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        $data['categoryName'] = $category->cat_name;
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }
        #END Check exist category by $categoryID
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_saleoff = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_buy > 0 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category,pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = (int)settingProductReliable_Category;
        $this->db->order_by("pro_view", "DESC");
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = $categoryIDQuery  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_reliable = 1 AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name,pro_detail,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 8;
        $this->db->order_by("pro_view", "DESC");
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_category = $categoryIDQuery  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1   AND sho_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        #BEGIN: Sort
        $where = "pro_category = $categoryIDQuery  AND pro_status = 1  ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'nhattuan/' . $categoryID . '/' . removeSign($category->cat_name) . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'nhattuan/' . $categoryID . "/" . removeSign($category->cat_name) . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 2;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where . " AND sho_status = 1 ", $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/topweek', $data);
    }

    function topvote($categoryID)
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Menu
        $data['menuSelected'] = (int)$categoryID;
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate,pro_vote_total,pro_vote";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Top product saleoff right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_buy > 0 AND pro_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #BEGIN: Reliable product
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_category,pro_saleoff_value,pro_type_saleoff,pro_saleoff, pro_view, sho_name, sho_begindate, pre_name, pro_begindate,pro_vote_total,pro_vote";
        $start = 0;
        $limit = 60;//(int)settingProductReliable_Category;
        $this->db->order_by("pro_vote_total", "DESC");
        $data['reliableProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_reliable = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        #END Reliable product
        #BEGIN: Favorite product
        $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_view, sho_name, sho_begindate, pre_name, pro_begindate,pro_vote_total,pro_vote,pro_detail";
        $start = 0;
        $limit = 8;
        $this->db->order_by("pro_vote_total", "DESC");
        $data['favoriteProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", "pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 ", "pro_vote", "DESC", $start, $limit);
        #END Favorite product
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        #BEGIN: Sort
        $where = "pro_status = 1 AND  pro_cost > 0 ";
        $sort = 'pro_vote_total';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'danhgia/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'danhgia/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductNew_Category;
        $config['num_links'] = 1;
        $config['uri_segment'] = 2;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name";
        $limit = settingProductNew_Category;
        $data['newProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        #Load view
        $this->load->view('home/product/topvote', $data);
    }

    function saleoff()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        #END Add favorite
        #BEGIN: Menu
        $data['menuSelected'] = 0;
        $data['menuType'] = 'product';
        $data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter
        #Module
        $data['module'] = 'top_lastest_product,top_buyest_product';
        #BEGIN: Top product lastest right
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductNew_Top;
        $data['topLastestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_status = 1 ", "pro_id", "DESC", $start, $limit);
        #END Top product lastest right
        #BEGIN: Top product buyest right
        $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
        $start = 0;
        $limit = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_buy > 0 AND pro_status = 1 ", "pro_buy", "DESC", $start, $limit);
        #END Top product buyest right
        #Define url for $getVar
        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Sort
        $where = "pro_saleoff = 1 AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                case 'buy':
                    $pageUrl .= '/sort/buy';
                    $sort = "pro_buy";
                    break;
                case 'view':
                    $pageUrl .= '/sort/view';
                    $sort = "pro_view";
                    break;
                case 'date':
                    $pageUrl .= '/sort/date';
                    $sort = "pro_begindate";
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
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'product/saleoff/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'product/saleoff' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductSaleoff;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_saleoff_value,pro_type_saleoff,sho_name,sho_begindate,pre_name,pro_detail";
        $limit = settingProductSaleoff;
        $data['saleoffProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
        #Load view
        $this->load->view('home/product/saleoff', $data);
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

    function detail($categoryID, $productID)
    {
        //Affiliate
        $af_id = $_REQUEST['af_id'];
        if ($af_id != "") {
            $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
            if ($userObject->use_id > 0) {
                $this->session->set_userdata("af_id", $af_id);
                // setcookie("af_id", $af_id, time() + (86400 * 7), '/'); // 86400 = 1 day
            }
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $data['protocol'] = $protocol;
        $data['domainName'] = $domainName;

        if ($this->session->userdata('sessionUser') > 0) {
            $this->load->model('eye_model');
            $dataEye = array(
                'idview' => $productID,
                'userid' => $this->session->userdata('sessionUser'),
                'typeview' => 1,
                'timeview' => 1
            );
            $checkEye = $this->eye_model->fetch("*", "idview = " . $productID . "  AND userid= " . $this->session->userdata('sessionUser') . " AND typeview = 1 ", "id", 'DESC');
            if (count($checkEye) == 0)
                $this->eye_model->add($dataEye);
        } else {
            $check = 0;
            foreach ($this->session->userdata('arrayEyeSanpham') as $pitem) {
                if ($pitem == $productID)
                    $check = 1;
            }
            if ($check == 0) {
                $this->session->userdata['arrayEyeSanpham'][] = $productID;
                $this->session->sess_write();
            }
        }
        #BEGIN Eye
        if ($this->session->userdata('sessionUser') > 0) {
            $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
            $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
            $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));
        } else {
            array_values($this->session->userdata['arrayEyeSanpham']);
            array_values($this->session->userdata['arrayEyeRaovat']);
            array_values($this->session->userdata['arrayEyeHoidap']);
            $data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');
            $data['listeyeraovat'] = $this->eye_model->geteyetypenologin('raovat');
            $data['listeyehoidap'] = $this->eye_model->geteyetypenologin('hoidap');
        }
        #END Eye
        $linkDetail = (int)$this->uri->segment(1);
        $data["sanpham_sub_rum"] = $this->loadSubSubCategory(0);
        $shop = $this->category_model->get("*", "cat_id = " . $linkDetail);
	
        $data['siteGlobal'] = $shop;
	
        /*$data['shop_glonal_conten'] = $this->loadSubSubCategoryCut($shop->cat_id);        
	$CategoryPro = $this->category_model->get("*", "cat_id = " . (int)$shop->parent_id);	
	print_r($CategoryPro);	
        $data['CategorysiteGlobal'] = $CategoryPro;
        //$data['CategorysiteGlobalConten'] = $this->loadSubSubCategoryCut($CategoryPro->cat_id);        
	$CategoryProRoot = $this->category_model->get("*", "cat_id = " . (int)$CategoryPro->parent_id );	
        $data['CategorysiteGlobalRoot'] = $CategoryProRoot;	
        $data['CategorysiteRootConten'] = $this->loadSubSubCategoryCut($CategoryProRoot->cat_id);*/
	
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Check exist category by $categoryID
        $category = $this->category_model->get("cat_id, cat_name", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }
        #END Check exist category by $categoryID
        $categoryIDQuery = (int)$categoryID;
        #BEGIN: Check exist product by $productID
        $product = $this->product_model->get("* , (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int)$productID . " AND pro_category = $categoryIDQuery AND pro_status = 1 ");

        if ($product && $product->pro_id <= 0) {
            redirect($this->subURL, 'location');
            die();
        }

        if (count($product) > 0) {
            $user_product = $this->user_model->get("*", "use_id = " . $product->pro_user);
        }

        if ($product->pro_user == "") {
            redirect(base_url(), 'location');
        }

        $shop_id_user = $this->shop_model->get("sho_id,shop_type", "sho_user = " . $product->pro_user . " AND sho_status = 1 ");
        if ($this->uri->segment(4) == "admin" || $product->pro_user == $this->session->userdata('sessionUser')) {
        } else {
            if ($shop_id_user->sho_id == "") {
                redirect(base_url(), 'location');
            }
        }
        $data['user_product'] = $user_product->use_username;
        if (count($product) != 1 || !$this->check->is_id($productID)) {
            redirect(base_url(), 'location');
            die();
        }
        #END Check exist product by $productID      

        //Check exist Truong Qui Cach of product, by Bao Tran
        $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$productID);

        if ($list_style) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . (int)$productID . " AND pro_status = 1", (int)$productID);
        }
        $data['shop_type'] = $shop_id_user;
        #####Backup######
        // if($list_style && count($list_style) > 0){
        //     $data['list_style'] = $list_style;
        //     $ar_color = array();
        //     $ar_size = array();
        //     $ar_material = array();
        //     foreach ($list_style as $k => $v) {
        //         if($v->dp_size != ''){
        //             $ar_size[] = $v->dp_size;
        //         }                                                 
        //         if($v->dp_color != ''){
        //             $ar_color[] = $v->dp_color;
        //         }
        //         if($v->dp_material != ''){
        //             $ar_material[] = $v->dp_material; 
        //         }                                         
        //     }
        //     $data['ar_size'] = array_unique($ar_size); 
        //     $data['ar_color'] = array_unique($ar_color);
        //     $data['ar_material'] = array_unique($ar_material);
        // }
        $list_style = array_reverse($list_style);
        if ($list_style && count($list_style) > 0) {
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

            $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$productID . $dp_color);
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
            $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$productID . $dp_color . $dp_size);
            if ($li_material) {
                foreach ($li_material as $km => $vm) {
                    $material_arr[] = $vm->dp_material;
                }
                $data['ar_material'] = array_unique($material_arr);
            }
        }

        $productIDQuery = (int)$productID;
        $this->load->model('af_share_model');
        // Get ip exit
        $current_ip = $this->get_client_ip_server();
        $ip_exit = $this->af_share_model->getAll('*', 'ip_use = "' . $current_ip . '"');
        //Get AF Login
        if ($this->session->userdata('sessionUser')) {
            $user_login = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $data['af_id'] = $user_login->af_key;
            }
        }
        #BEGIN: Update view
        if (!$this->session->userdata('sessionViewProduct_' . $productIDQuery)) {
            $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = " . $productIDQuery);
            $this->session->set_userdata('sessionViewProduct_' . $productIDQuery, 1);

            //dem so luong click link cho af            
            if (isset($_REQUEST['share'])) {
                $shareId = $_REQUEST['share'];
            } elseif (isset($_REQUEST['af_id'])) {
                $shareId = $_REQUEST['af_id'];
            } else {
                $shareId = '';
            }

            if ($shareId != '' && count($ip_exit) == 0 && $user_login->af_key != $shareId) {
                $this->load->model('share_model');
                $this->share_model->counter(array('link' => uri_string(), 'share_id' => $shareId, 'content_id' => $productID, 'content_title' => $product->pro_name, 'content_type' => '01'));
                //them bang af share
                $this->add_view_af_share($productID);
            }
        }
        #END Update view
        $this->load->library('bbcode');
        $this->load->library('captcha');
        $this->load->library('form_validation');
        $this->load->helper('unlink');
        #BEGIN: Vote & send friend & send fail
        $data['successVote'] = false;
        $data['successSendFriendProduct'] = false;
        $data['successSendFailProduct'] = false;
        if ($this->session->flashdata('sessionSuccessVote')) {
            $data['successVote'] = true;
        } elseif ($this->session->flashdata('sessionSuccessSendFriendProduct')) {
            $data['successSendFriendProduct'] = true;
        } elseif ($this->session->flashdata('sessionSuccessSendFailProduct')) {
            $data['successSendFailProduct'] = true;
        }
        #BEGIN: Vote
        if ($this->input->post('cost') && $this->input->post('quanlity') && $this->input->post('model') && $this->input->post('service') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost && time() - (int)$this->session->userdata('sessionTimeVote_' . $productIDQuery) > (int)settingTimePost * 20) {
            $dataVote = array(
                'pro_vote_cost' => (int)$product->pro_vote_cost + (int)$this->input->post('cost'),
                'pro_vote_quanlity' => (int)$product->pro_vote_quanlity + (int)$this->input->post('quanlity'),
                'pro_vote_model' => (int)$product->pro_vote_model + (int)$this->input->post('model'),
                'pro_vote_service' => (int)$product->pro_vote_service + (int)$this->input->post('service'),
                'pro_vote_total' => round(((int)$product->pro_vote_cost + (int)$this->input->post('cost') + (int)$product->pro_vote_quanlity + (int)$this->input->post('quanlity') + (int)$product->pro_vote_model + (int)$this->input->post('model') + (int)$product->pro_vote_service + (int)$this->input->post('service')) / (4 * ((int)$product->pro_vote + 1))),
                'pro_vote' => (int)$product->pro_vote + 1
            );
            if ($this->product_model->update($dataVote, "pro_id = " . $productIDQuery)) {
                $this->session->set_flashdata('sessionSuccessVote', 1);
                $this->session->set_userdata('sessionTimeVote_' . $productIDQuery, time());
            }
            $this->session->set_userdata('sessionTimePosted', time());
            redirect(base_url() . trim(uri_string(), '/'), 'location');
        }
        #END Vote
        #BEGIN: Send link for friend
        elseif ($this->input->post('captcha_sendlink') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
            #BEGIN: Set rules
            $this->form_validation->set_rules('sender_sendlink', 'lang:sender_sendlink_label_detail', 'trim|required|valid_email');
            $this->form_validation->set_rules('receiver_sendlink', 'lang:receiver_sendlink_label_detail', 'trim|required|valid_email');
            $this->form_validation->set_rules('title_sendlink', 'lang:title_sendlink_label_detail', 'trim|required');
            $this->form_validation->set_rules('content_sendlink', 'lang:content_sendlink_label_detail', 'trim|required|min_length[10]|max_length[400]');
            //$this->form_validation->set_rules('captcha_sendlink', 'lang:captcha_sendlink_label_detail', 'required|callback__valid_captcha_send_friend');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
            $this->form_validation->set_message('_valid_captcha_send_friend', $this->lang->line('_valid_captcha_send_friend_message_detail'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                $this->load->library('email');
                $config['useragent'] = $this->lang->line('useragen_mail_detail');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from($this->input->post('sender_sendlink'));
                $this->email->to($this->input->post('receiver_sendlink'));
                $this->email->subject($this->input->post('title_sendlink'));
                $this->email->message($this->lang->line('content_default_send_friend_detail') . base_url() . trim(uri_string(), '/') . '">' . base_url() . trim(uri_string(), '/') . '</a> ' . $this->lang->line('next_content_default_send_friend_detail') . $this->filter->html($this->input->post('content_sendlink')));
                #Email
                $folder = folderWeb;
                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');
                $return_email = $this->smtpmailer($this->input->post('receiver_sendlink'), $this->input->post('sender_sendlink'), "azibai.com", $this->input->post('title_sendlink'), $this->lang->line('content_default_send_friend_detail') . base_url() . trim(uri_string(), '/') . '">' . base_url() . trim(uri_string(), '/') . '</a> ' . $this->lang->line('next_content_default_send_friend_detail') . $this->filter->html($this->input->post('content_sendlink')));
                if ($return_email) {
                    $this->session->set_flashdata('sessionSuccessSendFriendProduct', 1);
                }
                /*if($this->email->send())
                {
                    $this->session->set_flashdata('sessionSuccessSendFriendProduct', 1);
                }*/
                $this->session->set_userdata('sessionTimePosted', time());
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            } else {
                $data['sender_sendlink'] = $this->input->post('sender_sendlink');
                $data['receiver_sendlink'] = $this->input->post('receiver_sendlink');
                $data['title_sendlink'] = $this->input->post('title_sendlink');
                $data['content_sendlink'] = $this->input->post('content_sendlink');
                $data['isSendFriend'] = true;
            }
        }
        #END Send link for friend
        #BEGIN: Send link fail product
        elseif ($this->input->post('captcha_sendfail') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost && !$this->session->userdata('sessionSendFailedProduct_' . $productIDQuery)) {
            //var_dump($this->input->post('bao_cao_sai_gia'));die();
            if ($this->input->post('bao_cao_sai_gia') == "1") {
                $this->load->model('product_bad_model');
                $dataFailAdd = array(
                    'prb_title' => trim($this->filter->injection_html($this->input->post('title_sendfail'))),
                    'prb_detail' => trim($this->filter->injection_html($this->input->post('content_sendfail'))),
                    'prb_email' => trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
                    'prb_product' => (int)$product->pro_id,
                    'prb_user_id' => (int)$this->session->userdata('sessionUser'),
                    'prb_date' => $currentDate
                );
                if ($this->product_bad_model->add($dataFailAdd)) {
                    $this->session->set_flashdata('sessionSuccessSendFailProduct', 1);
                    $this->session->set_userdata('sessionSendFailedProduct_' . $productIDQuery, 1);
                }
                $this->session->set_userdata('sessionTimePosted', time());
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            } else {
                $data['sender_sendfail'] = $this->input->post('sender_sendfail');
                $data['title_sendfail'] = $this->input->post('title_sendfail');
                $data['content_sendfail'] = $this->input->post('content_sendfail');
                $data['isSendFail'] = true;
            }
        }

        if ($this->input->post('bao_cao_sai_gia') == "1") {
            $this->load->model('product_bad_model');
            $dataFailAdd = array(
                'prb_title' => trim($this->filter->injection_html($this->input->post('title_sendfail'))),
                'prb_detail' => trim($this->filter->injection_html($this->input->post('content_sendfail'))),
                'prb_email' => trim($this->filter->injection_html($this->input->post('sender_sendfail'))),
                'prb_product' => (int)$product->pro_id,
                'prb_user_id' => (int)$this->session->userdata('sessionUser'),
                'prb_date' => $currentDate
            );
            if ($this->product_bad_model->add($dataFailAdd)) {
                $this->session->set_flashdata('sessionSuccessSendFailProduct', 1);
                $this->session->set_userdata('sessionSendFailedProduct_' . $productIDQuery, 1);
            }
            $this->session->set_userdata('sessionTimePosted', time());
        }

        if ($this->input->post('bao_cao_het_hang') == "1") {
            $this->load->model('product_bad_model');
            $dataFailAdd = array(
                'prb_title' => trim($this->filter->injection_html($this->input->post('title_sendfail_het_hang'))),
                'prb_detail' => trim($this->filter->injection_html($this->input->post('content_sendfail_het_hang'))),
                'prb_email' => trim($this->filter->injection_html($this->input->post('content_sendfail_het_hang'))),
                'prb_product' => (int)$product->pro_id,
                'prb_price_out' => 1,
                'prb_user_id' => (int)$this->session->userdata('sessionUser'),
                'prb_date' => $currentDate
            );
            if ($this->product_bad_model->add($dataFailAdd)) {
                $this->session->set_flashdata('sessionSuccessSendFailProduct', 1);
                $this->session->set_userdata('sessionSendFailedProduct_' . $productIDQuery, 1);
            }
        }

        $this->load->model('product_comment_model');
        #BEGIN: Add favorite and submit forms
        $data['successFavoriteProduct'] = false;
        $data['successReplyProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            } elseif ($this->session->flashdata('sessionSuccessReplyProduct')) {
                $data['successReplyProduct'] = true;
            }
            #BEGIN: Favorite
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
            #END Favorite
            #BEGIN: Reply (Comment)
            elseif ($this->input->post('captcha_reply') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                #BEGIN: Set rules
                $this->form_validation->set_rules('title_reply', 'lang:title_reply_label_detail', 'trim|required');
                $this->form_validation->set_rules('content_reply', 'lang:content_reply_label_detail', 'trim|required|min_length[10]|max_length[400]');
                $this->form_validation->set_message('required', $this->lang->line('required_message'));
                $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                $this->form_validation->set_message('_valid_captcha_reply', $this->lang->line('_valid_captcha_reply_message_detail'));
                $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
                if ($this->form_validation->run() != FALSE) {
                    $dataAddReply = array(
                        'prc_title' => trim($this->filter->injection_html($this->input->post('title_reply'))),
                        'prc_comment' => trim($this->filter->injection_html($this->input->post('content_reply'))),
                        'prc_product' => (int)$product->pro_id,
                        'prc_user' => (int)$this->session->userdata('sessionUser'),
                        'prc_date' => mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y'))
                    );
                    if ($this->product_comment_model->add($dataAddReply)) {
                        $this->product_model->update(array('pro_comment' => (int)$product->pro_comment + 1), "pro_id = " . $productIDQuery);
                        $this->session->set_flashdata('sessionSuccessReplyProduct', 1);
                    }
                    $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                } else {
                    $data['title_reply'] = $this->input->post('title_reply');
                    $data['content_reply'] = $this->input->post('content_reply');
                    $data['isReply'] = true;
                }
            }
            unlink_captcha($this->session->flashdata('sessionPathCaptchaReplyProduct'));
            $aCaptcha = $this->createCaptcha(md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'r.jpg');
            if(!empty($aCaptcha)) {
                $data['cacha_reply']                = $aCaptcha['captcha']; 
                $data['imageCaptchaReplyProduct']    = $aCaptcha['imageCaptchaContact'];

                $this->session->set_flashdata('sessionCaptchaReplyProduct', $aCaptcha['captcha']);
                $this->session->set_flashdata('sessionPathCaptchaReplyProduct', $aCaptcha['imageCaptchaContact']); 
            }
        }

        $this->load->helper('text');
        $af_id = $data['af_id'] ? '?af_id=' . $data['af_id'] : '';
        $img = explode(',', $product->pro_image);
        $check_http = explode(':', $img[0])[0];
        if($check_http == 'http' || $check_http == 'https'){
            $ogimage = $img[0];
        }else{
            $ogimage = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_'.$img[0];
        }
        $data['titleSiteGlobal'] = $product->pro_name . " | " . $category->cat_name;
        $data['descrSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product->pro_descr)), 255);
        $data['keywordproSiteGlobal'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product->pro_keyword)), 255);
        $data['ogurl'] = base_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $af_id;
        $data['ogtype'] = "product";
        $data['ogtitle'] = $product->pro_name;
        $data['ogdescription'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product->pro_descr)), 255);
        $data['ogimage'] = $ogimage;
        $data['h1tagSiteGlobal'] = $product->pro_name;
        #BEGIN: Get product by $productID and relate info
        $data['product'] = $product;

        $shop = $this->shop_model->get("*", "sho_user = " . (int)$product->pro_user);
        $_province = $this->province_model->get('pre_name', 'pre_id = "' . $shop->sho_province . '"');
        $_district = $this->district_model->find_by(array("DistrictCode" => $shop->sho_district, 'pre_status' => 1), 'DistrictName');
        $shop->province_name = $_province->pre_name;
        $shop->district_name = $_district[0]->DistrictName;
        $data['shop'] = $shop;

        $data['province'] = $this->province_model->get("pre_name", "pre_id = " . (int)$product->pro_province);
        $data['menuSelected'] = (int)$categoryID;
	
	
	if($category->cat_type == 2){
	    $data['menuActive'] = 'product';
	} else {
	    $data['menuActive'] = 'coupon';
	}
	
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data['advertisePage'] = 'product_detail';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        $data['counter'] = $this->counter_model->get();
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        $start = 0;
        
        $limit1 = (int)settingProductSaleoff_Top;
        $select1 = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $data['topSaleoffProduct'] = $this->product_model->fetch($select1, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit1);
        
        $select2 = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir,pro_detail";
        $limit2 = (int)settingProductBuyest_Top;
        $data['topBuyestProduct'] = $this->product_model->fetch($select2, "pro_buy > 0 AND pro_status = 1 ", "pro_buy", "DESC", $start, $limit2);
        $action = array('sort', 'by', 'page', 'cPage');
        $getVar = $this->uri->uri_to_assoc(6, $action);
        #BEGIN: Comment
        #Check open tab comment
        $data['isViewComment'] = false;
        if (trim(uri_string()) != '' && stristr(uri_string(), 'cPage')) {
            $data['isViewComment'] = true;
        }
        if ($getVar['cPage'] != FALSE && (int)$getVar['cPage'] > 0) {
            $start = (int)$getVar['cPage'];
        } else {
            $start = 0;
        }
        $this->load->library('pagination');
        $totalRecord = count($this->product_comment_model->fetch_join("prc_id", "LEFT", "tbtt_user", "tbtt_product_comment.prc_user = tbtt_user.use_id", "prc_product = $productIDQuery", "", ""));
        $config['base_url'] = base_url() . 'product/category/detail/' . $categoryID . '/' . $productID . '/cPage/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = 5;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['cLinkPage'] = $this->pagination->create_links();
        $select = "prc_title, prc_comment, prc_date, use_fullname, use_email";
        $limit = 5;
        $data['comment'] = $this->product_comment_model->fetch_join($select, "LEFT", "tbtt_user", "tbtt_product_comment.prc_user = tbtt_user.use_id", "prc_product = $productIDQuery", "prc_id", "DESC", $start, $limit);
        unset($start);
        unset($config);
        #END Comment
        #BEGIN: Relate user
        #BEGIN: Sort
        $where = "pro_user = " . (int)$product->pro_user . " AND pro_id != $productIDQuery AND pro_status = 1 ";
        $sort = 'pro_id';
        $by = 'DESC';
        $pageSort = '';
        $pageUrl = '';
        $data['sortUrl'] = base_url() . 'product/category/detail/' . $categoryID . '/' . $productID . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        #Count total record
        $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
        $config['base_url'] = base_url() . 'product/category/detail/' . $categoryID . '/' . $productID . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingProductUser;
        $config['num_links'] = 1;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #Fetch record
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_saleoff_value,pro_type_saleoff,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote, sho_link, pro_minsale,  tbtt_detail_product.id as dp_id";
        //$limit = settingProductUser;
        $data['userProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_detail_product.dp_pro_id = tbtt_product.pro_id", $where . " AND sho_status = 1", $sort, $by, $start, 8, '', 'pro_id');
        
        #END Relate user
        #BEGIN: Relate category
        $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_saleoff_value, pro_type_saleoff, pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote_total,pro_vote, sho_link";
        $start = 0;
        $data['categoryProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_detail_product.dp_pro_id = tbtt_product.pro_id", "pro_category = " . (int)$product->pro_category . " AND pro_id != $productIDQuery AND pro_status = 1  AND sho_status = 1 ", "rand()", "DESC", $start, 8, '', 'pro_id');
        #END Relate category
        #BEGIN: Notify
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        $data['user'] = (int)$this->session->userdata('sessionUser');
        $data['globalProduct'] = 0;
        unlink_captcha($this->session->flashdata('sessionPathCaptchaSendFriendProduct'));
        $aCaptcha = $this->createCaptcha(md5(microtime()) . '.' . rand(1, 10000) . 'f.jpg');
        if(!empty($aCaptcha)) {
            $data['cacha']                = $aCaptcha['captcha']; 
            $data['imageCaptchaSendFriendProduct']    = $aCaptcha['imageCaptchaContact'];

            $this->session->set_flashdata('sessionCaptchaSendFriendProduct', $aCaptcha['captcha']);
            $this->session->set_flashdata('sessionPathCaptchaSendFriendProduct', $aCaptcha['imageCaptchaContact']); 
        }
        //BÁO CÁO SP     
        $this->load->model('reports_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rpd_id', 'asc');
        
        $data['listreports'] = $listreports;
        
        $data['pro_link'] = $protocol.domain_site.'/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
        //END BÁO CÁO SP
        
        //get thông báo chọn bán hay chưa
        if ($this->session->userdata('sessionUser')) {
            $this->load->model('product_affiliate_user_model');
            $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $product->pro_id));
            if ($selected_sale) {
                $data['selected_sale'] = $selected_sale;
            }
        }
        
        if ($this->session->userdata('sessionUser')) {
            $currentUser = $this->user_model->get("*", "use_id = " . $this->session->userdata('sessionUser'));
            $data['currentUser'] = $currentUser;
        }
        // Get product promotion
        if ($product->pro_user != $this->session->userdata('sessionUser')) {
            $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));
        }
        // dd($data);die;
        ##Load:: View
        $this->load->view('home/product/detail', $data);
    }

    public function report(){
        if($this->session->userdata('sessionUser'))
        {
            $result['message'] = '';
            $pro_id = (int)$this->input->post("pro_id");
            $this->load->model('report_detail_model');
            $query = $this->report_detail_model->get("*","rpd_by_user = " . $this->session->userdata('sessionUser') . " AND rpd_product = ". $pro_id);
            if(count($query) == 0) {
                $form_data = array(
                    "rpd_type" => 2,
                    "rpd_product" => $pro_id,
                    "rpd_reportid" => $this->input->post("rp_id"),
                    "rpd_by_user" => $this->session->userdata('sessionUser')
                );
                if($this->input->post("rpd_reason") != ''){
                    $form_data['rpd_reason'] = $this->input->post("rpd_reason");
                }
                if ($this->report_detail_model->add($form_data))
                {
                    $byuser = $this->user_model->get("use_email, use_fullname", "use_id = ".$this->session->userdata('sessionUser'));
                    
                    $getemailto = $this->user_model->fetch_join("use_email", "LEFT", "tbtt_product", "use_id = pro_user", "use_status = 1 AND pro_status = 1 AND pro_id = " . $pro_id);
                    $emailto = $getemailto[0]->use_email;
                    
                    $this->load->library('email');
                    $config['useragent'] = "azibai.com";
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.phpmailer.php'); 
                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.pop3.php');

                    $from = GUSER;									
                    $from_name = 'AZIBAI.COM';
                    $subject = 'Báo cáo sản phẩm vi phạm';
                    
                    $this->load->model('reports_model');
                    $reports = $this->reports_model->get('rp_desc', 'rp_type = 2 AND rp_status = 1 AND rp_id = ' . $this->input->post("rp_id"));
                    
                    if($this->input->post("rpd_reason") != ''){
                        $cntreports = $this->input->post("rpd_reason");
                    }else{
                        $cntreports = $reports->rp_desc;
                    }

                    $body1 = 'Chào shop <a href="' . $this->input->post("sho_link") . '" target="_blank" alt="' . $this->input->post("sho_name") . '">' . $this->input->post("sho_name") . '</a>! <br/>Sản phẩm <a href="' . $this->input->post("pro_link") . '" target="_blank" alt="' . $this->input->post("pro_name") . '">' . $this->input->post("pro_name") . '</a> của bạn vừa bị báo cáo với nội dung: "<b>' . $cntreports . '</b>".<br/>Vui lòng CHỈNH SỬA hoặc là XÓA sản phẩm của bạn.';			
                    $this->smtpmailer($emailto, $from, $from_name, $subject, $body1);
                    
                    $body2 = 'Chào Admin! <br/>Admin đã nhận được một báo cáo từ tài khoản: ' . $byuser->use_fullname . ' <font small>[' . $byuser->use_email . ']</font>. <br/> ' . $byuser->use_fullname . ' báo cáo sản phẩm <a href="' . $this->input->post("pro_link") . '" target="_blank" alt="' . $this->input->post("pro_name") . '">' . $this->input->post("pro_name") . '</a> của gian hàng <a href="' . $this->input->post("sho_link") . '" target="_blank" alt="' . $this->input->post("sho_name") . '">' . $this->input->post("sho_name") . '</a> với nội dung: "<b>' . $cntreports . '</b>". <br/>Admin vui lòng đăng nhập vào quản trị để xử lý báo cáo.';
                    $this->smtpmailer(settingEmail_1, $from, $from_name, $subject, $body2);
                    $result['message'] = 'Báo cáo sản phẩm thành công';
                }
            }else{
                $result['message'] = 'Bạn đã báo cáo cho sản phẩm này rồi';
            }
            echo json_encode($result); exit();
        }else{
            redirect(base_url().'page-not-found', 'location');
        }
    }

    function load_size()
    {
        $id = (int)$this->input->post('pro_id');
        $color = $this->input->post('color');
        $size_arr = array();

        $li_size = $this->detail_product_model->fetch("DISTINCT dp_size", "dp_pro_id = " . (int)$id . ' AND dp_color = "' . $color . '"', $id, $color, '', '');
        if ($li_size) {
            foreach ($li_size as $ks => $vs) {
                $size_arr[] = $vs->dp_size;
            }
        }
        $t2 = 0;
        $rs = array();
        if (!empty($size_arr)) {
            $vowels = array(".", " ", ",", "/");
            foreach ($size_arr as $k2 => $v2) {
                $t2++;
                if ($k2 == 0) {
                    $sel_size = $v2;
                }
                $st_size = str_replace($vowels, "_", $v2);
                $size = "'" . $st_size . "'";
                $nsize = $st_size;
                $rs['li'][] = '<li style="cursor: pointer;"><span id="kichthuoc_' . $t2 . '" onclick="ClickSize(' . $size . ',' . $t2 . ');">' . $v2 . '</span>'
                . '<input type="hidden" id="st_size_' . $nsize . '" name="st_size_' . $nsize . '" value="' . $v2 . '" /></li>';
            }
            echo json_encode($rs);
            exit();
        }else{
            $this->load_chatlieu();
        }
    }

    function load_chatlieu()
    {
        $id = (int)$this->input->post('pro_id');
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $where = '';
        if ($color != '') {
            $where .= ' AND dp_color = "' . $color . '"';
        }
        if ($size != '') {
            $where .= ' AND dp_size = "' . $size . '"';
        }
        $rs['li'] = $where;
        $material_arr = array();
        $rs = array();
        $li_material = $this->detail_product_model->fetch("distinct(dp_material)", "dp_pro_id = " . (int)$id . $where, $id, $size, '', '');
        if ($li_material) {
            foreach ($li_material as $key => $vm) {
                $material_arr[] = $vm->dp_material;
            }
        }
        $rs['where'][] = "dp_pro_id = " . (int)$id . $where;
        $t2 = 0;
        if (!empty($material_arr)) {
            $vowels = array(".", " ", ",", "/");
            foreach ($material_arr as $k2 => $v2) {
                $t2++;
                if ($k2 == 0) {
                    $sel_size = $v2;
                }
                $st_material = str_replace($vowels, "_", $v2);
                if($st_material != ''){
                    $cl = "'" . $st_material . "'";
                    $rs['li'][] = '<li style="cursor: pointer;"><span id="chatlieu_' . $t2 . '" onclick="ClickMaterial(' . $cl . ',' . $t2 . ');">' . $v2 . '</span>'
                        . '<input type="hidden" id="st_material_' . $st_material . '" name="st_material_' . $st_material . '" value="' . $v2 . '" /></li>';
            
                }
            }
        }
        echo json_encode($rs);
        exit();
    }

    function slide_img()
    {
        $img_dir = $_REQUEST['dir_img'];
        $img_str = $_REQUEST['arr_img'];
        $arr_img = explode(',', $img_str);
        echo '<div id="carousel-ligghtgallery" class="owl-carousel owl-theme"> ';
        foreach ($arr_img as $k2 => $v2) {
            $ac = '';
            if ($k2 == 0) {
                $ac = ' active';
            }
            $d = '<div class="fix1by1 item' . $ac . '">';
            $imgsrc = 'media/images/product/' . $img_dir . '/thumbnail_3_' . $v2;
            if ($v2 != '') { //file_exists($imgsrc) && 
                $a = '<a class="c image" href="' . DOMAIN_CLOUDSERVER . $imgsrc . '">
            <img src="' . DOMAIN_CLOUDSERVER . $imgsrc . '" alt="..."> </a>';
            } else {
                $a = '<a class="c image" href="' . base_url() . 'images/noimage.jpg"><img src="' . base_url() . 'images/noimage.jpg" alt="..."></a>';
            }
            echo $d . $a . '</div>';
        }
        echo '</div>';
    }

    function product_style_azibai()
    {
        $id = (int)$this->input->post('id');
        $color = $this->input->post('color');
        $material = $this->input->post('material');
        $result = $img = array();
        $result['error'] = FALSE;
        //$gt = explode('_', $color);
        //$color = implode(' ', $gt);
        $size = '';
        if($this->input->post('size')){
            $size = $this->input->post('size');
        }
        //$result['where'] = "pro_id = " . $id . " AND pro_status = 1";
        if (isset($id) && $id > 0) {
            $product = $this->product_model->getProAndDetail0("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, $size, $material);
            $result['pro_dir'] = $product[0]->pro_dir;
            $result['pro_id'] = $product[0]->id;
            $result['off_amount'] = $product[0]->off_amount;
            $result['af_off'] = $product[0]->af_off;
            $result['message'] = 'Susseccc!!';
            foreach ($product as $vl) {
                $img[] = $vl->dp_images;
                $price[] = $vl->dp_cost;
                $max[] = $vl->dp_instock;
                $pro_id[] = $vl->id;
                $off_amount[] = $vl->off_amount;
                $af_off[] = $vl->af_off;
            }
            $image = implode(',', $img);
            $prices = implode(',', $price);
            $qty_max = implode(',', $max);
            $str_id = implode(',', $pro_id);
            $str_offamount = implode(',', $off_amount);
            $str_afoff = implode(',', $af_off);
            $result['offamount_arr'] = $str_offamount;
            $result['offaff_arr'] = $str_afoff;
            $result['pro_images'] = $image;
            $result['pro_prices'] = $prices;
            $result['pro_max'] = $qty_max;
            $result['pro_id'] = $str_id;

            if ($product[0]->af_rate > 0 && $product[0]->is_product_affiliate == 1 && (int) $result['pro_prices'] > 0) {
                $result['af_off'] = $product[0]->af_rate * (($result['pro_prices'] - $result['off_amount']) / 100 );
            }



        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function product_style_azibai3()
    {
        $result = $img = array();
        $result['error'] = FALSE;
        $id = $_REQUEST['id'];
        $color = $_REQUEST['color'];
        $gt = explode('_', $color);
        $color = implode(' ', $gt);
        $size = '';
        if($_REQUEST['size']){
        $size = $_REQUEST['size'];
        }
        $material = $_REQUEST['chatlieu'];
        if (isset($id) && $id > 0) {
            $product = $this->product_model->getProAndDetail0("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, $size, $material);
//            $product = $this->product_model->getProAndDetail0("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, 'hồng', '10x12', $material);
            $result['pro_dir'] = $product[0]->pro_dir;
            $result['pro_id'] = $product[0]->id;
            $result['off_amount'] = $product[0]->off_amount;
            $result['af_off'] = $product[0]->af_off;
            $result['message'] = 'Susseccc!!';
//            var_dump($product);
            foreach ($product as $vl) {
                $img[] = $vl->dp_images;
                $price[] = $vl->dp_cost;
                $max[] = $vl->dp_instock;
                $pro_id[] = $vl->id;
            }
//            var_dump($id);
            $image = implode(',', $img);
            $prices = implode(',', $price);
            $qty_max = implode(',', $max);
            $str_id = implode(',', $pro_id);
            $result['pro_images'] = $image;
            $result['pro_prices'] = $prices;
            $result['pro_max'] = $qty_max;
            $result['pro_id'] = $str_id;

            if ($product[0]->af_rate > 0 && $product[0]->is_product_affiliate == 1 && (int) $result['pro_prices'] > 0) {
                $result['af_off'] = $product[0]->af_rate * (($result['pro_prices'] - $result['off_amount']) / 100 );
            }
        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function product_style_azibai0()
    {
        $id = (int)$this->input->post('id');
        $color = $this->input->post('color');
        $size = $this->input->post('size');
        $material = $this->input->post('material');
        $result = $img = array();
        $result['error'] = FALSE;
        if (isset($id) && $id > 0) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, $size, $material);
            $result['pro_dir'] = $product->pro_dir;
            $result['pro_id'] = $product->id;
            $result['pro_images'] = $product->dp_images;
            $result['pro_prices'] = $product->dp_cost;
            $result['off_amount'] = $product->off_amount;
            $result['af_off'] = $product->af_off;
            $result['message'] = 'Susseccc!!';

            if ($product[0]->af_rate > 0 && $product[0]->is_product_affiliate == 1 && (int) $result['pro_prices'] > 0) {
                $result['af_off'] = $product[0]->af_rate * (($result['pro_prices'] - $result['off_amount']) / 100 );
            }

        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function select_style_pro_1()
    {
        $id = (int)$this->input->post('id');
        $color = $this->input->post('color');
        $result = array();
        $result['error'] = FALSE;
        if (isset($id) && $id > 0) {
            $ar_size = array();
            $ar_material = array();
            $list_style = $this->detail_product_model->fetch('dp_color, dp_size, dp_material', 'dp_pro_id = ' . $id . ' AND dp_color LIKE "%' . $color . '%"');
            if ($list_style) {
                foreach ($list_style as $kl => $vl) {
                    if ($vl->dp_color != '') {
                        $ar_color[] = $vl->dp_color;
                    }
                    if ($vl->dp_size != '') {
                        $ar_size[] = $vl->dp_size;
                    }
                    if ($vl->dp_material != '') {
                        $ar_material[] = $vl->dp_material;
                    }
                }
            }
            $result['ar_color'] = array_unique($ar_color);
            $result['ar_size'] = array_unique($ar_size);
            $result['ar_material'] = array_unique($ar_material);


            $material_arr = array();
            $first_s = current($result['ar_size']);
            if ($first_s) {
                $li_material = $this->detail_product_model->fetch('dp_material', 'dp_pro_id = ' . $id . ' AND dp_size LIKE "%' . $first_s . '%"');
                if ($li_material) {
                    foreach ($li_material as $km => $vm) {
                        if ($vm->dp_material != '') {
                            $material_arr[] = $vm->dp_material;
                        }
                    }
                }
                $result['ar_material'] = array_unique($material_arr);
            }

            if(!empty($result['ar_color']) && empty($result['ar_material']) && empty($result['ar_size'])){
                $product = $this->product_model->getProAndDetail0("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, '', '');
                $result['pro_dir'] = $product[0]->pro_dir;
                $result['pro_id'] = $product[0]->id;
                $result['off_amount'] = $product[0]->off_amount;
                $result['af_off'] = $product[0]->af_off;
                $result['message'] = 'Susseccc!!';
                foreach ($product as $vl) {
                    $img[] = $vl->dp_images;
                    $price[] = $vl->dp_cost;
                    $max[] = $vl->dp_instock;
                    $pro_id[] = $vl->id;
                    $off_amount[] = $vl->off_amount;
                    $af_off[] = $vl->af_off;
                }
                $image = implode(',', $img);
                $prices = implode(',', $price);
                $qty_max = implode(',', $max);
                $str_id = implode(',', $pro_id);
                $str_offamount = implode(',', $off_amount);
                $str_afoff = implode(',', $af_off);

                $result['offamount_arr'] = $str_offamount;
                $result['offaff_arr'] = $str_afoff;
                $result['pro_images'] = $image;
                $result['pro_prices'] = $prices;
                $result['pro_max'] = $qty_max;
                $result['pro_id'] = $str_id;

                if ($product[0]->af_rate > 0 && $product[0]->is_product_affiliate == 1 && (int) $result['pro_prices'] > 0) {
                    $result['af_off'] = $product[0]->af_rate * (($result['pro_prices'] - $result['off_amount']) / 100 );
                }
            }


            $result['message'] = 'Susseccc!!';

        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function select_style_product()
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

            if ($product[0]->af_rate > 0 && $product[0]->is_product_affiliate == 1 && (int) $result['pro_prices'] > 0) {
                $result['af_off'] = $product[0]->af_rate * (($result['pro_prices'] - $result['off_amount']) / 100 );
            }

            $result['message'] = 'Susseccc!!';
        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    function baocaosaigia()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $id_hds = $this->input->post('id_hds');
        $id_user = (int)$this->input->post('id_user');
        $id_gia = (int)$this->input->post('id_gia');
        $this->load->model('product_bad_model');
        $dataFailAdd = array(
            'prb_product' => (int)$id_hds,
            'prb_user_id' => (int)$id_user,
            'prb_price_out' => $id_gia,
            'prb_date' => $currentDate
        );
        if ($this->product_bad_model->add($dataFailAdd)) {
            echo "Báo cáo thành công";
        }
    }

    function display_child($parent, $level, &$retArray)
    {
        $sql = "SELECT * from `tbtt_category` WHERE parent_id = " . $parent . " and cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $i = 0;
        foreach ($query->result_array() as $row) {
            $object = new StdClass;
            $object->cat_id = $row['cat_id'];
            $object->cat_name = str_repeat('-', $level) . " " . $row['cat_name'];
            $object->levelQ = $level;
            $retArray[] = $object;
            $this->display_child($row['cat_id'], $level + 1, $retArray);
            //edit by nganly de qui
            $i = $i + 1;
        }
    }

    function recursive($parent_id = 0, $data, $step = '', $catlv = 0)
    {
        $sql = "SELECT cat_id, cat_name,cat_level, parent_id from `tbtt_category` WHERE parent_id = " . $parent_id . " AND cat_level = " . $catlv . " AND cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        if (isset($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parent_id) {
                    $object = new StdClass;
                    $object->cat_id = $val['cat_id'];
                    $object->cat_name = $step . ' ' . $val['cat_name'];
                    $object->cat_level = $val['cat_level'];
                    $object->parent_id = $val['parent_id'];
                    $this->recursive[] = $object;
                    unset($data[$key]);
                    $this->recursive($val['cat_id'], $data, $step . ' |-- ', $catlv + 1);
                }
            }
        }
        return $this->recursive;
    }

    function post() {
    
        // Defaule Value 

        $parent_id = 0;
        $catpye = 0;

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'login', 'location');
            die();
        }

        // Check Permissions Post Product

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            $data['disAllowPost'] = true;
            // redirect(base_url() . "account", 'location');
            // die();
        }
       
        $aShop = $this->getShop($group_id, $parent_id);
        
        if(empty($aShop)) {
            $this->session->set_flashdata('flash_message', 'Bạn phải cập nhật đầy đủ thông tin cần thiết của gian hàng ( được đánh dấu * ) để thực hiện những chức năng khác');
            redirect(base_url() . "account/shop", 'location');
            die();
        }
        
        $data['shopid'] = $aShop->sho_id;
        $data['shoptype'] = $aShop->shop_type;

        //Kiểm tra Chi Nhánh có được cấu hình đăng sản phẩm hay không????
        #BEGIN: CHECK CONFIG FOR BRANCH

        $data['ConfigPrice'] = $this->getConfigPrice($group_id, $parent_id);

        #END: CHECK CONFIG FOR BRANCH

        if ($this->input->post('saleoff_pro') && ($this->input->post('saleoff_pro') != '')) {
            if ($this->input->post('prom_begin') && ($this->input->post('prom_begin') != '')) {
                $begin_date = $this->input->post('prom_begin');
            } else {
                $begin_date = date('Y/m/d', time());
            }
            $add_days = (int)$this->input->post('promotion_expiry');
            $promotion_expiry = strtotime($begin_date . ' +' . $add_days . ' days');
        } else {
            $begin_date = 0;
            $promotion_expiry = 0;
        }

        $url1 = $this->uri->segment(3);

        
        if ($url1 != '' && $url1 == 'service') {
            $catpye = 1;
        } elseif ($url1 != '' && $url1 == 'coupon') {
            $catpye = 2;
        }
        $this->lang->load('home/account');
        $this->countProductByUser($this->session->userdata('sessionUser'));
        if($group_id == StaffStoreUser) {
            $data['user_group'] = $this->user_model->get("use_group", "use_id =" . $parent_id)->use_group;
        } else {
            $data['user_group'] = (int)$this->session->userdata('sessionGroup');
        }
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        #BEGIN: Menu
	    $data['menuPanelGroup'] = 4;
        $data['menuType'] = 'account';
        if (($url1 != '' && $url1 == 'coupon') || ($url1 != '' && $url1 == 'service')) {
            $data['menuSelected'] = 'product_' . $url1;
        } else {
            $data['menuSelected'] = 'product';
        }
        #END Menu
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter


        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaEditShopAccount'));
        $data['counter'] = $this->counter_model->get();
        unlink_captcha($this->session->flashdata('sessionPathCaptchaPostProduct'));

        if ($aShop->sho_category > 0) {
            $cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cat_level = 0 AND cate_type = " . $catpye, "cat_service, cat_order, cat_id", "ASC");
        }

        if (isset($cat_level_0)) {
            foreach ($cat_level_0 as $key => $item) {
                $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                $cat_level_0[$key]->child_count = count($cat_level_1);
            }
        }
        $data['catlevel0'] = $cat_level_0;


        if ($this->session->flashdata('sessionSuccessPostProduct')) {
            $data['successPostProduct'] = true;
        } else {

            $this->load->library('form_validation');
            $data['successPostProduct'] = false;
            #BEGIN: Set date
            if ((int)date('m') < 12) {
                $data['nextMonth'] = (int)date('m') + 1;
                $data['nextYear'] = (int)date('Y');
            } else {
                $data['nextMonth'] = 1;
                $data['nextYear'] = (int)date('Y') + 1;
            }
            #END: Set date
            #BEGIN: Province
            $this->load->model('province_model');
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
            #END Province               
            #BEGIN: User
            $arrycat_ss = $this->session->userdata('catidArr');
           
            if ($arrycat_ss[0] && $arrycat_ss[0] > 0) {
                $data['catlevel_0'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 0 and cate_type = " . $catpye . " and parent_id = 0", "cat_name", "ASC");
            }
            if ($arrycat_ss[1] && $arrycat_ss[1] > 0) {
                $data['catlevel_1'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 1 and cate_type = " . $catpye . " and parent_id = " . $arrycat_ss[0], "cat_name", "ASC");
            }

            if ($arrycat_ss[2] && $arrycat_ss[2] > 0) {
                $data['catlevel_2'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 2 and cate_type = " . $catpye . " and parent_id = " . $arrycat_ss[1], "cat_name", "ASC");
            }

            if ($arrycat_ss[3] && $arrycat_ss[3] > 0) {
                $data['catlevel_3'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 3 and cate_type = " . $catpye . "  and parent_id = " . $arrycat_ss[2], "cat_name", "ASC");
            }
            if ($arrycat_ss[4] && $arrycat_ss[4] > 0) {
                $data['catlevel_4'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 4 and cate_type = " . $catpye . " and parent_id = " . $arrycat_ss[3], "cat_name", "ASC");
            }

            $this->load->model('user_model');
            if($group_id == StaffStoreUser) {
                $user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . $parent_id);
            } else {
                $user = $this->user_model->get("use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . (int)$this->session->userdata('sessionUser'));
            }
            $data['fullname_pro'] = $user->use_fullname;
            $data['address_pro'] = $user->use_address;
            $data['phone_pro'] = $user->use_phone;
            $data['mobile_pro'] = $user->use_mobile;
            $data['email_pro'] = $user->use_email;
            $data['yahoo_pro'] = $user->use_yahoo;
            $data['skype_pro'] = $user->use_skype;


            $data['name_pro'] = $this->input->post('name_pro');
            $data['pro_sku'] = $this->input->post('pro_sku');
            $data['descr_pro'] = $this->input->post('descr_pro');
            $data['keyword_pro'] = $this->input->post('keyword_pro');
            $data['pro_detail'] = $this->input->post('pro_detail');
            $data['cost_pro'] = $this->input->post('cost_pro');
            $data['currency_pro'] = $this->input->post('currency_pro');
            $data['nonecost_pro'] = $this->input->post('nonecost_pro');
            $data['nego_pro'] = $this->input->post('nego_pro');
            $data['saleoff_pro'] = $this->input->post('saleoff_pro');
            $data['province_pro'] = $this->input->post('province_pro');
            $data['category_pro'] = $this->input->post('category_pro');
            $data['day_pro'] = $this->input->post('day_pro');
            $data['month_pro'] = $this->input->post('month_pro');
            $data['year_pro'] = $this->input->post('year_pro');
            $data['txtContent'] = $this->input->post('txtContent');                   
            $data['dc_amount'] = $this->input->post('dc_amount');
            $data['dc_type'] = $this->input->post('dc_type');
            $data['dc_af_amount'] = $this->input->post('pro_dc_affiliate_value');
            $data['dc_af_type'] = $this->input->post('pro_type_dc_affiliate');
            $data['pro_weight'] = $this->input->post('pro_weight');
            $data['pro_length'] = $this->input->post('pro_length');
            $data['pro_width'] = $this->input->post('pro_width');
            $data['pro_height'] = $this->input->post('pro_height');
            $data['pro_minsale'] = $this->input->post('pro_minsale');                    
            $data['pro_unit'] = $this->input->post('pro_unit');                    
     
            if($this->input->post('name_pro')) {
                $saleoff_pro = 0;
                $nego_pro = 0;
                $currency_pro = 'VND';
                $reliable = 0;

                #Create folder   
                $pathImage = "media/images/product/";
                $dir_image = date('dmY');
                $image = 'none.gif';
                $image_name = $this->session->userdata('image_name');
 
                if ($image_name != '') {
                    $image = $image_name;
                }

                if ($image == 'none.gif') {
                    #Remove dir
                    $this->load->library('file');
                    if (trim($dir_image) != '' && trim($dir_image) != 'default' && is_dir('media/images/product/' . $dir_image) && count($this->file->load('media/images/product/' . $dir_image, 'index.html')) == 0) {
                        if (file_exists('media/images/product/' . $dir_image . '/index.html')) {
                            @unlink('media/images/product/' . $dir_image . '/index.html');
                        }
                        @rmdir('media/images/product/' . $dir_image);
                    }
                    $dir_image = 'default';
                }
        
                #END Upload image
                if (strtoupper($this->input->post('currency_pro')) == 'USD') {
                    $currency_pro = 'USD';
                } 

                if ((int)$this->input->post('cost_pro') == 0 || $this->input->post('nonecost_pro') == '1') {
                    $cost_pro = 0;
                    $currency_pro = 'VND';
                } else {
                    $cost_pro = (int)$this->input->post('cost_pro');
                }

                if ($this->input->post('nego_pro') == '1') {
                    $nego_pro = 1;
                } 


                if ($this->input->post('saleoff_pro') == '1') {
                    $saleoff_pro = 1;
                }
                if ((int)$this->session->userdata('sessionGroup') == 3) {
                    $reliable = 1;
                } 
                if ($this->input->post('mannufacurer_pro') == "khac" && $this->input->post('manafac_khac') != "") {
                    $this->load->model('manufacturer_model');
                    $dataPostManafac = array(
                        'man_name' => trim($this->filter->injection_html($this->input->post('manafac_khac'))),
                        'man_status' => 0,
                        'man_id_category' => trim($this->filter->injection_html($this->input->post('hd_category_id')))
                    );
                    if ($this->manufacturer_model->add($dataPostManafac)) {
                        $manufacturecusomGetMax = $this->manufacturer_model->get("max(man_id) as Maxman_id");
                        $manufacturecusom = $manufacturecusomGetMax->Maxman_id;
                    }
                } else {
                    $manufacturecusom = (int)$this->input->post('mannufacurer_pro');
                }
                $ngaykeythuc = explode("-", $this->input->post('ngay_ket_thuc'));
                $this->load->model('shop_model');
                $tinh_thanh_shop_get = $this->shop_model->get("sho_province", "sho_user  = " . (int)$this->session->userdata('sessionUser'));
                $tinh_thanh_shop = $tinh_thanh_shop_get->sho_province;
                $af_amt = 0;
                $af_rate = 0;
                $af_dc_amt = 0;
                $af_dc_rate = 0;
                if ($this->input->post('affiliate_pro') == 0) {
                    $af_amt = 0;
                    $af_rate = 0;
                } else {
                    if ($this->input->post('pro_type_affiliate') == 1) {
                        $af_amt = 0;
                        $af_rate = $this->input->post('pro_affiliate_value');
                    } else {
                        $af_amt = $this->input->post('pro_affiliate_value');
                        $af_rate = 0;
                    }
                    if ($this->input->post('pro_type_dc_affiliate') == 1) {
                        $af_dc_amt = 0;
                        $af_dc_rate = $this->input->post('pro_dc_affiliate_value');
                    } else {
                        $af_dc_amt = $this->input->post('pro_dc_affiliate_value');
                        $af_dc_rate = 0;
                    }
                }

                if($group_id == StaffStoreUser) {
                    $pro_user       = $parent_id;
                    $pro_user_up    = $this->session->userdata('sessionUser');
                }else {
                    $pro_user = (int)$this->session->userdata('sessionUser');

                }

                $dataPost = array(
                    'pro_name' => trim($this->filter->injection_html($this->input->post('name_pro'))),
                    'pro_sku' => trim($this->filter->injection_html($this->input->post('pro_sku'))),
                    'pro_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_pro')))),
                    'pro_keyword' => trim($this->filter->injection_html($this->filter->clear($this->input->post('keyword_pro')))),
                    'pro_cost' => $cost_pro,
                    'pro_currency' => $currency_pro,
                    'pro_hondle' => $nego_pro,
                    'pro_saleoff' => $saleoff_pro,
                    'pro_province' => (int)$tinh_thanh_shop,
                    'pro_category' => (int)$this->input->post('hd_category_id'),
                    'pro_begindate' => $currentDate,
                    'pro_enddate' => mktime(0, 0, 0, (int)$ngaykeythuc[1], (int)$ngaykeythuc[0], (int)$ngaykeythuc[2]),
                    'pro_detail' => trim($this->filter->injection_html($this->input->post('txtContent'))),
                    'pro_image' => $image,
                    'pro_dir' => $dir_image,
                    'pro_user' => $pro_user,
                    'pro_post_by' => 'web',
                    'pro_user_up' => (isset($pro_user_up)) ? $pro_user_up : 0,
                    'pro_poster' => trim($this->filter->injection_html($this->input->post('fullname_pro'))),
                    'pro_address' => trim($this->filter->injection_html($this->input->post('address_pro'))),
                    'pro_phone' => trim($this->filter->injection_html($this->input->post('phone_pro'))),
                    'pro_mobile' => trim($this->filter->injection_html($this->input->post('mobile_pro'))),
                    'pro_email' => trim($this->filter->injection_html($this->input->post('email_pro'))),
                    'pro_yahoo' => trim($this->filter->injection_html($this->input->post('yahoo_pro'))),
                    'pro_skype' => trim($this->filter->injection_html($this->input->post('skype_pro'))),
                    'pro_status' => $data['user_group'] == 3 ? 1 : 0, // gian hang va nhan vien cua gian hang = 1
                    'pro_view' => 0,
                    'pro_buy' => 0,
                    'pro_comment' => 0,
                    'pro_vote_cost' => 0,
                    'pro_vote_quanlity' => 0,
                    'pro_vote_model' => 0,
                    'pro_vote_service' => 0,
                    'pro_vote_total' => 0,
                    'pro_vote' => 0,
                    'pro_reliable' => $reliable,
                    'pro_saleoff_value' => ($this->input->post('pro_saleoff_value')) ? trim($this->filter->injection_html($this->input->post('pro_saleoff_value'))) : 0,
                    'pro_hot' => (int)$this->input->post('pro_hot'),
                    'is_product_affiliate' => ($this->input->post('affiliate_pro')) ? trim($this->input->post('affiliate_pro')) : 0,
                    'af_amt' => $af_amt,
                    'af_rate' => $af_rate,
                    'af_dc_amt' => $af_dc_amt,
                    'af_dc_rate' => $af_dc_rate,
                    'pro_show' => (int)$this->input->post('pro_show_img'),
                    'pro_type_saleoff' => trim($this->filter->injection_html($this->input->post('pro_type_saleoff'))),
                    'pro_manufacturer_id' => $manufacturecusom,
                    'pro_instock' => trim($this->filter->injection_html($this->input->post('pro_instock'))),
                    'pro_unit' => trim($this->filter->injection_html($this->input->post('pro_unit'))),
                    'pro_weight' => ($this->input->post('pro_weight')) ? trim($this->filter->injection_html($this->input->post('pro_weight'))) : 0,
                    'pro_length' => ($this->input->post('pro_length')) ? trim($this->filter->injection_html($this->input->post('pro_length'))) : 0,
                    'pro_width' => ($this->input->post('pro_width')) ? trim($this->filter->injection_html($this->input->post('pro_width'))) : 0,
                    'pro_height' => ($this->input->post('pro_height')) ? trim($this->filter->injection_html($this->input->post('pro_height'))) : 0,
                    'pro_minsale' => (int)$this->input->post('pro_minsale'),
                    'pro_vat' => $this->input->post('pro_vat'),
                    'pro_quality' => $this->input->post('pro_quality'),
                    'pro_made_from' => $this->input->post('pro_made_from'),
                    'pro_warranty_period' => trim($this->filter->injection_html($this->input->post('pro_warranty_period'))),
                    'pro_video' => trim($this->filter->injection_html($this->input->post('pro_video'))),
                    'created_date' => date("Y-m-d"),
                    'begin_date_sale' => strtotime($begin_date),
                    'end_date_sale' => $promotion_expiry,
                    'pro_type' => $catpye,

                );
                
               
                if ($dataPost && $this->session->userdata('catidArr')) {
                    $this->session->unset_userdata('catidArr');
                }

                if ($dataPost && $this->session->userdata('image_name')) {
                    $this->session->unset_userdata('image_name');
                }
                
                //add product
                if ($id = $this->product_model->add($dataPost)) {
                    
                    $pro_id = (int)mysql_insert_id();
                    $this->session->set_flashdata('sessionSuccessPostProduct', 1);

                    // Add promotion                       
                    $promotions = array();
                    if (!empty($_POST['row'])) {
                        foreach ($_POST['row'] as $row) {
                            $promotion = array();
                            $promotion['limit_from'] = $row['limit_from'];
                            $promotion['limit_to'] = $row['limit_to'];
                            $promotion['limit_type'] = $_POST['limit_type'];
                            if ($row['type'] == 1) {
                                $promotion['dc_amt'] = $row['amount'];
                                $promotion['dc_rate'] = 0;
                            } else {
                                $promotion['dc_rate'] = $row['amount'];
                                $promotion['dc_amt'] = 0;
                            }
                            $promotion['pro_id'] = $id;
                            array_push($promotions, $promotion);
                        }
                        $this->product_promotion_model->add($promotions);
                    }

                    //Lưu trữ trường quy cách                       
                    $standards = array();
                    if (!empty($_POST['rowqc'])) {
                        $t = 0;
                        // Get truong quy cach
                        $image_qc = $this->session->userdata('image_name_qc');
                        // $image_qc = array();
                        // if ($image_name_qc != '') {
                        //     $str_image_qc = $image_name_qc;
                        // }
                        ///$image_qc = explode(',', $str_image_qc);

                        foreach ($_POST['rowqc'] as $key => $rowqc) {
                            $field_image = 'rowqc_' . $t . '_qcimage'; //$_REQUEST[$field_image] != '' && 
                            if ($rowqc['qccost'] != '' && $rowqc['qcinstock'] != '' && ($rowqc['qcsize'] != '' || $rowqc['qccolor'] != '' || $rowqc['qcmaterial'] != '')) {
                                $standard = array();
                                $standard['dp_pro_id'] = $id;
                                $standard['dp_size'] = $rowqc['qcsize'];
                                $standard['dp_color'] = $rowqc['qccolor'];
                                $standard['dp_material'] = $rowqc['qcmaterial'];
                                $standard['dp_cost'] = $rowqc['qccost'];
                                $standard['dp_instock'] = $rowqc['qcinstock'];
                                $standard['dp_createdate'] = date('Y-m-d');
                                $standard['dp_images'] = $image_qc[$key];
                                array_push($standards, $standard);

                                $this->detail_product_model->add($standard);
                            }
                            $t++;
                        }

                        if ($standards && $this->session->userdata('image_name_qc')) {
                            $this->session->unset_userdata('image_name_qc');
                        }
                    }

                    // $arr = array();
                    // $cat_id_0 = (int)$this->input->post('cat_pro_0');
                    // $cat_id_1 = (int)$this->input->post('cat_pro_1');
                    // $cat_id_2 = (int)$this->input->post('cat_pro_2');
                    // $cat_id_3 = (int)$this->input->post('cat_pro_3');
                    // $cat_id_4 = (int)$this->input->post('cat_pro_4');
                    // if (isset($cat_id_0) && $cat_id_0 > 0) {
                    //     array_push($arr, $cat_id_0);
                    //     $this->session->set_userdata('catidArr', $arr);
                    // }
                    // if (isset($cat_id_1) && $cat_id_1 > 0) {
                    //     array_push($arr, $cat_id_1);
                    //     $this->session->set_userdata('catidArr', $arr);
                    // }
                    // if (isset($cat_id_2) && $cat_id_2 > 0) {
                    //     array_push($arr, $cat_id_2);
                    //     $this->session->set_userdata('catidArr', $arr);
                    // }
                    // if (isset($cat_id_3) && $cat_id_3 > 0) {
                    //     array_push($arr, $cat_id_3);
                    //     $this->session->set_userdata('catidArr', $arr);
                    // }
                    // if (isset($cat_id_4) && $cat_id_4 > 0) {
                    //     array_push($arr, $cat_id_4);
                    //     $this->session->set_userdata('catidArr', $arr);
                    // }
                }
               
                $this->session->set_userdata('sessionTimePosted', time());
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }              
        }
        
        #Hủy session image_name
        if ($this->session->userdata('image_name')) {
            $this->session->unset_userdata('image_name');
        }

        #Hủy session image_name_qc
        if ($this->session->userdata('image_name_qc')) {
            $this->session->unset_userdata('image_name_qc');
        }

        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        #Load view
        $data['globalProduct'] = 0;
        $this->load->model('shop_model');

        #Load view
        $this->load->view('home/product/post', $data);
    }

    function upload_photo()
    {
        $num = (int)$_REQUEST['images_pos'];
        $image_old = $_REQUEST['images_old'];
        if($image_old != '') {
            //Connect FTP to server cloud
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = FALSE;
            $this->ftp->connect($config);
            $path_delete = '/public_html/media/images/product';
            $product_dir_delete = date('dmY');
            $lfile = array();
    
            $lfile = $this->ftp->list_files($path_delete .'/'. $product_dir_delete);
           
            if (in_array($image_old, $lfile)) {
                $this->ftp->delete_file($path_delete .'/'. $product_dir_delete .'/'. $image_old);
                $this->ftp->delete_file($path_delete .'/'. $product_dir_delete .'/thumbnail_1_'. $image_old);
                $this->ftp->delete_file($path_delete .'/'. $product_dir_delete .'/thumbnail_2_'. $image_old);
                $this->ftp->delete_file($path_delete .'/'. $product_dir_delete .'/thumbnail_3_'. $image_old);
                $this->ftp->close();
            }
        }
        if ($num > 0) {
            $this->load->library('upload');         
            $pathImage = "media/images/product/";
            #Create folder            
            $dir_image = $this->session->userdata('sessionUsername');
            $image = 'none.gif';
            if (! is_dir($pathImage . $dir_image)) {
                @mkdir($pathImage . $dir_image, 0777, true);
                $this->load->helper('file');
                @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
            }
            $config['upload_path'] = $pathImage . $dir_image . '/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10240;#KB
            $config['max_width'] = 10240;#px
            $config['max_height'] = 10240;#px
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            $imageArray = '';
            if ($this->upload->do_upload('photo')) {
                $uploadData = $this->upload->data();
               
                if ($uploadData['is_image'] == TRUE) { 
                    $this->load->library('image_lib');
                    $imageArray = $uploadData['file_name'];                                         
                    $configResize['source_image'] = $pathImage . $dir_image . '/' . $imageArray;
                    $configResize['new_image'] = $pathImage . $dir_image . '/' . $imageArray;
                    $configResize['maintain_ratio'] = TRUE;
                    $configResize['quality'] = '90%';
                    if($uploadData['image_width'] > $uploadData['image_height']){
                        $configResize['width'] = '1';
                        $configResize['height'] = '600';                     
                        $configResize['master_dim'] = 'height';
                    }                   
                    if($uploadData['image_width'] < $uploadData['image_height']){
                        $configResize['width'] = '600';
                        $configResize['height'] = '1';                   
                        $configResize['master_dim'] = 'width';
                    }
                    if($uploadData['image_width'] == $uploadData['image_height']){
                        $configResize['width'] = '600';
                        $configResize['height'] = '600';
                    }                   
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                    
                    
                } elseif (file_exists($pathImage . $dir_image . '/' . $uploadData['file_name'])) {
                    @unlink($pathImage . $dir_image . '/' . $uploadData['file_name']);
                }
                
                $type = pathinfo($uploadData['full_path'], PATHINFO_EXTENSION);
                $data = file_get_contents($uploadData['full_path']);
                $photo_dest_crop = 'data:image/' . $type . ';base64,' . base64_encode($data);

                //$photo_dest_crop = '/' . $pathImage . $dir_image . '/' . $uploadData['file_name'];
                unset($uploadData);
            }

            $image_name = $this->session->userdata('image_name');
            if (empty($image_name)) {
                $image_name = $imageArray;
            } else {
                $image_name .= ',' . $imageArray;
            }
            $this->session->set_userdata('image_name', $image_name);

            if ($image_name != '') {
                echo '<script type="text/javascript">window.top.window.show_popup_crop("' . $photo_dest_crop . '",' . $num . ')</script>'; die;
            }
        }
    }

    function crop_photo()
    {
        // Target siz
        $targ_w = $_POST['targ_w'];
        $targ_h = $_POST['targ_h'];
        // quality
        $jpeg_quality = 90;
        // photo path
        $src = $_POST['photo_url'];

        $pathImage = "media/images/product/";

        $dir_image = $this->session->userdata('sessionUsername');
 
        $img = end(explode(',', $this->session->userdata('image_name')));

        if (preg_match('/^data:image\/(\w+);base64,/', $src)) {

            $data = explode(';', $src);
            $type = str_replace('data:image/', '', $data[0]);

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }

            $img_temp =  base64_decode(str_replace('base64,', '', $data[1]));

            $success = file_put_contents($pathImage .'/'. $dir_image .'/'.$img, $img_temp);
            

            if ($success === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }
        
        // $dir_image = date('dmY');

        $src = $pathImage . $dir_image . '/' . $img;
        
        // create new jpeg image based on the target sizes
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
        // crop photo
        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
        // create the physical photo
        imagejpeg($dst_r, $src, $jpeg_quality);

        #BEGIN: Create thumbnail
        $this->load->library('image_lib');
        if (file_exists($pathImage . $dir_image . '/' . $img)) {
            for ($j = 1; $j <= 3; $j++) {
                switch ($j) {
                    case 1:
                        $maxWidth = 150;#px
                        $maxHeight = 150;#px
                        break;
                    case 3:
                        $maxWidth = 600;#px
                        $maxHeight = 600;#px
                        break;
                    default:
                        $maxWidth = 300;#px
                        $maxHeight = 300;#px
                }

                $sizeImage = size_thumbnail($src, $maxWidth, $maxHeight);
                $configImage['source_image'] = $pathImage . $dir_image . '/' . $img;
                $configImage['new_image'] = $pathImage . $dir_image . '/thumbnail_' . $j . '_' . $img;
                $configImage['maintain_ratio'] = TRUE;
                $configImage['width'] = $sizeImage['width'];
                $configImage['height'] = $sizeImage['height'];
                $this->image_lib->initialize($configImage);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }
        }

        // Upload to other server cloud
        $img_thum = '';
        if(file_exists($pathImage . $dir_image .'/'. $img) 
            && file_exists($pathImage . $dir_image .'/thumbnail_1_'. $img)        
            && file_exists($pathImage . $dir_image .'/thumbnail_2_'. $img)
            && file_exists($pathImage . $dir_image .'/thumbnail_3_'. $img)
        ){
            $this->load->library('ftp');

            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = TRUE;
            $this->ftp->connect($config);

            $path = '/public_html/media/images/product';
            $dirname = date('dmY');            
            $tmp_path = $pathImage . $dir_image . '/' . $img;
            $tmp_path_1 = $pathImage . $dir_image . '/thumbnail_1_' . $img;
            $tmp_path_2 = $pathImage . $dir_image . '/thumbnail_2_' . $img;
            $tmp_path_3 = $pathImage . $dir_image . '/thumbnail_3_' . $img;
            $lfile = array();
            $lfile = $this->ftp->list_files($path);
           
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (! in_array($dirname, $lfile)) {                    
                $this->ftp->mkdir($path .'/'. $dirname, 0775);
            }

            if($this->ftp->upload($tmp_path, $path .'/'. $dirname .'/'. $img, 'auto', 0775) 
                && $this->ftp->upload($tmp_path_1, $path .'/'. $dirname .'/thumbnail_1_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_2, $path .'/'. $dirname .'/thumbnail_2_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_3, $path .'/'. $dirname .'/thumbnail_3_'. $img, 'auto', 0775)
            ){
                $img_thum = DOMAIN_CLOUDSERVER .'media/images/product/'. $dirname .'/thumbnail_1_'. $img;
                if (file_exists('media/images/product/' . $dir_image . '/index.html')) {
                    @unlink('media/images/product/' . $dir_image . '/index.html');
                }
                array_map('unlink', glob('media/images/product/'. $dir_image .'/*'));
                @rmdir('media/images/product/' . $dir_image);
            } 

            $this->ftp->close();     
        }

        #END Create thumbnail 
        // display the  photo - "?time()" to force refresh by the browser
        // $img_thum = '/' . $pathImage . $dir_image . '/thumbnail_1_' . $img;
        $result = array('image_name' => $img, 'image' => '<img src="' . $img_thum . '?' . time() . '">');       
            
        echo json_encode($result);
       
        exit;
    }

    function upload_photo_qc()
    {
        $num = (int)$_REQUEST['images_pos_qc'];
        $dp_images = $_REQUEST['dp_images'];
        if ($num > 0) {
            $this->load->library('upload');
            $pathImage = "media/images/product/";
            // $dir_image = date('dmY');
            $dir_image = $this->session->userdata('sessionUsername');
            if (!is_dir($pathImage . $dir_image)) {
                @mkdir($pathImage . $dir_image, 0777, true);
                $this->load->helper('file');
                @write_file($pathImage . $dir_image . '/index.html', '<p>Directory access is forbidden.</p>');
            }
            $config['upload_path'] = $pathImage . $dir_image . '/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10240;#KB
            $config['max_width'] = 10240;#px
            $config['max_height'] = 10240;#px
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);

            $imageArray = '';
            if ($this->upload->do_upload('photo_qc')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    $this->load->library('image_lib');
					$imageArray = $uploadData['file_name'];											
					$configResize['source_image'] = $pathImage . $dir_image . '/' . $imageArray;
					$configResize['new_image'] = $pathImage . $dir_image . '/' . $imageArray;
					$configResize['maintain_ratio'] = TRUE;
					$configResize['quality'] = '90%';
					if($uploadData['image_width'] > $uploadData['image_height']){
						$configResize['width'] = '1';
						$configResize['height'] = '600';					 
						$configResize['master_dim'] = 'height';
					}					
					if($uploadData['image_width'] < $uploadData['image_height']){
						$configResize['width'] = '600';
						$configResize['height'] = '1';					 
						$configResize['master_dim'] = 'width';
					}
					if($uploadData['image_width'] == $uploadData['image_height']){
						$configResize['width'] = '600';
						$configResize['height'] = '600';
					}					
					$this->image_lib->initialize($configResize);
					$this->image_lib->resize();
					$this->image_lib->clear();
                } elseif (file_exists($pathImage . $dir_image . '/' . $uploadData['file_name'])) {
                    @unlink($pathImage . $dir_image . '/' . $uploadData['file_name']);
                }
                $type = pathinfo($uploadData['full_path'], PATHINFO_EXTENSION);
                $data = file_get_contents($uploadData['full_path']);
                $photo_dest_crop = 'data:image/' . $type . ';base64,' . base64_encode($data);
                // $photo_dest_crop = '/' . $pathImage . $dir_image . '/' . $uploadData['file_name'];
                unset($uploadData);
            }
            
            if ($dp_images != '') {
                $dir_image = date('dmY');
                $this->load->library('ftp');
                $config['hostname'] = IP_CLOUDSERVER;
                $config['username'] = USER_CLOUDSERVER;
                $config['password'] = PASS_CLOUDSERVER;
                $config['port']     = PORT_CLOUDSERVER;                
                $config['debug']    = TRUE;
                $this->ftp->connect($config);
                $path = '/public_html/media/images/product';
                $ldir = array(); 
                $lfile = array();
                $ldir = $this->ftp->list_files($path);
                $lfile = $this->ftp->list_files($path .'/'. $dir_image);
                if (in_array($dir_image, $ldir) && in_array($dp_images, $lfile)) {//$pr_qc->dp_images
                    $this->ftp->delete_file($path .'/'. $dir_image .'/'. $dp_images);
                    $this->ftp->delete_file($path .'/'. $dir_image .'/thumbnail_1_'. $dp_images);
                    $this->ftp->delete_file($path .'/'. $dir_image .'/thumbnail_2_'. $dp_images);                
                    $this->ftp->delete_file($path .'/'. $dir_image .'/thumbnail_3_'. $dp_images);
                    $this->ftp->close();
                    echo '1';
                }
                echo '<script>console.log("'.$dp_images.', '.$dir_image.'")</script>';
            }

            $image_name_qc = array();
            $image_name_qc = $this->session->userdata('image_name_qc');
            $image_name_qc[$num] = $imageArray;

            // $image_name_qc = $this->session->userdata('image_name_qc');
            // if (empty($image_name_qc)) {
            //     $image_name_qc = $imageArray;
            // }else {
            //     $image_name_qc .= ',' . $imageArray;

            //     $array = array();
            //     $image_ = explode(',', $image_name_qc);
            //     foreach($image_ as $key => $value){
            //         if($value != $dp_images){
            //             $array[] = $value;
            //         }
            //     }
            //     $image_name_qc = implode(',', $array);
            // }
            $this->session->set_userdata('image_name_qc', $image_name_qc);
            if ($image_name_qc != '') {
                echo '<script type="text/javascript">window.top.window.show_popup_crop_qc("' . $photo_dest_crop . '",' . $num . ')</script>'; die;
            }
        }
    }

    function crop_photo_qc()
    {
        // Target siz
        $targ_w = $_POST['targ_w'];
        $targ_h = $_POST['targ_h'];
        // quality
        $jpeg_quality = 90;
        // photo path
        $src = $_POST['photo_url'];
        $num = (int)$_POST['num_qc'];
        $pathImage = "media/images/product/";
        // $dir_image = date('dmY');
        $dir_image = $this->session->userdata('sessionUsername');

        $aImage = $this->session->userdata('image_name_qc');
        $img = $aImage[$num];

        $path = $pathImage.$dir_image;

        $this->convertStringToImage($img, $path, $src);

        $src = $pathImage . $dir_image . '/' . $img;
        // create new jpeg image based on the target sizes
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
        // crop photo
        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
        // create the physical photo
        imagejpeg($dst_r, $src, $jpeg_quality);

        #BEGIN: Create thumbnail
        $this->load->library('image_lib');
        if (file_exists($pathImage . $dir_image . '/' . $img)) {
            for ($j = 1; $j <= 3; $j++) {
                switch ($j) {
                    case 1:
                        $maxWidth = 150;#px
                        $maxHeight = 150;#px
                        break;
                    case 3:
                        $maxWidth = 600;#px
                        $maxHeight = 600;#px
                        break;
                    default:
                        $maxWidth = 300;#px
                        $maxHeight = 300;#px
                }

                $sizeImage = size_thumbnail($src, $maxWidth, $maxHeight);
                $configImage['source_image'] = $pathImage . $dir_image . '/' . $img;
                $configImage['new_image'] = $pathImage . $dir_image . '/thumbnail_' . $j . '_' . $img;
                $configImage['maintain_ratio'] = TRUE;
                $configImage['width'] = $sizeImage['width'];
                $configImage['height'] = $sizeImage['height'];
                $this->image_lib->initialize($configImage);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }
        }
        #END Create thumbnail 
        // Upload to other server cloud
        $img_thum = '';
        if(file_exists($pathImage . $dir_image .'/'. $img) 
            && file_exists($pathImage . $dir_image .'/thumbnail_1_'. $img)        
            && file_exists($pathImage . $dir_image .'/thumbnail_2_'. $img)
            && file_exists($pathImage . $dir_image .'/thumbnail_3_'. $img)
        ){
            $this->load->library('ftp');

            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = TRUE;
            $this->ftp->connect($config);

            $path = '/public_html/media/images/product';
            $dirname = date('dmY');            
            $tmp_path = $pathImage . $dir_image . '/' . $img;
            $tmp_path_1 = $pathImage . $dir_image . '/thumbnail_1_' . $img;
            $tmp_path_2 = $pathImage . $dir_image . '/thumbnail_2_' . $img;
            $tmp_path_3 = $pathImage . $dir_image . '/thumbnail_3_' . $img;
            $lfile = array();
            $lfile = $this->ftp->list_files($path);
           
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (! in_array($dirname, $lfile)) {                    
                $this->ftp->mkdir($path .'/'. $dirname, 0775);
            }
            
            if($this->ftp->upload($tmp_path, $path .'/'. $dirname .'/'. $img, 'auto', 0775) 
                && $this->ftp->upload($tmp_path_1, $path .'/'. $dirname .'/thumbnail_1_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_2, $path .'/'. $dirname .'/thumbnail_2_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_3, $path .'/'. $dirname .'/thumbnail_3_'. $img, 'auto', 0775)
            ){
                $img_thum = DOMAIN_CLOUDSERVER .'media/images/product/'. $dirname .'/thumbnail_1_'. $img;
                if (file_exists('media/images/product/' . $dir_image . '/index.html')) {
                    @unlink('media/images/product/' . $dir_image . '/index.html');
                }
                array_map('unlink', glob('media/images/product/'. $dir_image .'/*'));
                @rmdir('media/images/product/' . $dir_image);
            }
            
            $this->ftp->close();   
        }

        // display the  photo - "?time()" to force refresh by the browser
        // $img_thum = '/' . $pathImage . $dir_image . '/thumbnail_1_' . $img;
        $str_cancel = "'rqc_image_" . $num . "'";
        // echo '<input type="button" class="btn btn-default" id="btn_cancel_' . $num . '" onclick="resetBrowesIimgQ_qc(' . $str_cancel . ',' . $num . ');" value="Hủy"/>'
        //         . '<input type="hidden" class="imgthum_'.$num.'" value="' . $img_thum . '?' . time() . '"><img src="' . $img_thum . '?' . time() . '">';

        $result = array(
            'image_name' => $img, 
            'image' => '<input type="button" class="btn btn-default" id="btn_cancel_' . $num . '" onclick="resetBrowesIimgQ_qc(' . $str_cancel . ',' . $num . ');" value="Hủy"/>'
                . '<input type="hidden" class="imgthum_'.$num.'" value="' . $img . '"><img src="' . $img_thum . '?' . time() . '">'
        );       
        
        echo json_encode($result);
        exit;
    }

    function ajax_delete_image()
    {
        $name_pic = $this->input->post('name_pic');
        $num = (int)$this->input->post('num');
        $pro_dir = $this->input->post('pro_dir');
        if ($name_pic != "") {            
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = TRUE;
            $this->ftp->connect($config);

            $pathImage = "/public_html/media/images/product/";
            $dir_image = date('dmY');
            if ($pro_dir && $pro_dir != "") {
                $dir_image = $pro_dir;
            }
            
            $ldir = array();
            $lfile = array();
            $ldir = $this->ftp->list_files('/public_html/media/images/product');
            $lfile = $this->ftp->list_files('/public_html/media/images/product/'. $dir_image);
            
            if (in_array($dir_image, $ldir) && in_array($name_pic, $lfile)) {

                $this->ftp->delete_file($pathImage . $dir_image .'/'. $name_pic);                
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_1_' . $name_pic);
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_2_' . $name_pic);
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_3_' . $name_pic);
                $this->ftp->close();

                $image_name = $this->session->userdata('image_name');
                $img_pos = explode(',', $image_name);
                unset($img_pos[$num - 1]);
                $image_name_del = implode(',', $img_pos);
                $this->session->set_userdata('image_name', $image_name_del);

                echo "1";
                exit();
            }
        }
        echo "-1";
        exit();
    }

    function ajax_delete_image_qc()
    {
        $name_pic = $this->input->post('name_pic');
        $num = (int)$this->input->post('num');
        $product_dir = (int)$this->input->post('pro_dir');

        if ($name_pic != "") {
            
            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = TRUE;
            $this->ftp->connect($config);

            $pathImage = "/public_html/media/images/product/";
            $dir_image = $product_dir;
            $ldir = array();
            $lfile = array();
            $ldir = $this->ftp->list_files('/public_html/media/images/product');
            $lfile = $this->ftp->list_files('/public_html/media/images/product/'. $dir_image);
  
            if (in_array($dir_image, $ldir) && in_array($name_pic, $lfile)) {

                $this->ftp->delete_file($pathImage . $dir_image . '/' . $name_pic);                
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_1_' . $name_pic);
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_2_' . $name_pic);
                $this->ftp->delete_file($pathImage . $dir_image . '/thumbnail_3_' . $name_pic);
               
                $image_name_qc = $this->session->userdata('image_name_qc');
                $img_pos_qc = explode(',', $image_name_qc);
                unset($img_pos_qc[$num - 1]);
                $image_name_qc_del = implode(',', $img_pos_qc);
                $this->session->set_userdata('image_name_qc', $image_name_qc_del);
                $this->ftp->close();
                
                echo "1";
                exit();
            }
        }else{
            echo "-1";
        }
        exit();
    }
    private function checkConfigBranch()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if($group_id == StaffStoreUser) {
            $parent_id = $this->user_model->get("parent_id", "use_id =" . $this->session->userdata('sessionUser'))->parent_id;
            $userId = $parent_id;              
            $bran_rule = $this->branch_model->getConfig('*', 'bran_id = ' . $userId);
            $segment = $this->uri->segment(3);
            if($segment == 'product') {
                $segment = 'emp-product';
            } elseif($segment == 'coupon') {
                $segment = 'emp-coupon';
            }
            if ($bran_rule) {
                $list_br = explode(",", $bran_rule->config_rule);
                if (isset($list_br) && in_array('47', $list_br)) {
                } else {
                    $this->session->set_flashdata('checkConfigBranch', 'Chi nhánh của Gian hàng này hiện không đăng được sản phẩm.');
                    redirect(base_url() . "account/".$segment);
                }
            } else {
                $this->session->set_flashdata('checkConfigBranch', 'Chi nhánh của Gian hàng này hiện không đăng được sản phẩm.');
                redirect(base_url() . "account/".$segment);
            }
        } else {
            $userId = (int)$this->session->userdata('sessionUser');              
            $bran_rule = $this->branch_model->getConfig('*', 'bran_id = ' . $userId);
            $segment = $this->uri->segment(3);
            if ($bran_rule) {
                $list_br = explode(",", $bran_rule->config_rule);
                if (isset($list_br) && in_array('47', $list_br)) {
                } else {
                    $this->session->set_flashdata('checkConfigBranch', 'Chi nhánh của Gian hàng này hiện không đăng được sản phẩm.');
                    redirect(base_url() . "account/product/".$segment);
                }
            } else {
                $this->session->set_flashdata('checkConfigBranch', 'Chi nhánh của Gian hàng này hiện không đăng được sản phẩm.');
                redirect(base_url() . "account/product/".$segment);
            }
        }
    }

    function _valid_captcha_reply($str)
    {
        if ($this->session->flashdata('sessionCaptchaReplyProduct') && $this->session->flashdata('sessionCaptchaReplyProduct') === $str) {
            return true;
        }
        return false;
    }

    function _valid_captcha_send_friend($str)
    {
        if ($this->session->flashdata('sessionCaptchaSendFriendProduct') && $this->session->flashdata('sessionCaptchaSendFriendProduct') === $str) {
            return true;
        }
        return false;
    }

    function _valid_captcha_send_fail($str)
    {
        if ($this->session->flashdata('sessionCaptchaSendFailProduct') && $this->session->flashdata('sessionCaptchaSendFailProduct') === $str) {
            return true;
        }
        return false;
    }

    function _is_phone($str)
    {
        if ($this->check->is_phone($str)) {
            return true;
        }
        return false;
    }

    function _exist_province($str)
    {
        $this->load->model('province_model');
        if (count($this->province_model->get("pre_id", "pre_status = 1 AND pre_id = " . (int)$str)) == 1) {
            return true;
        }
        return false;
    }

    function _exist_category($str)
    {
        if (count($this->category_model->get("cat_id", "cat_status = 1 AND cat_id = " . (int)$str)) == 1) {
            return true;
        }
        return false;
    }

    function _valid_enddate()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endDate = mktime(0, 0, 0, (int)$this->input->post('month_pro'), (int)$this->input->post('day_pro'), (int)$this->input->post('year_pro'));
        if ($this->check->is_more($currentDate, $endDate)) {
            return false;
        }
        return true;
    }

    function _valid_nick($str)
    {
        if (preg_match('/[^0-9a-z._-]/i', $str)) {
            return false;
        }
        return true;
    }

    function _valid_captcha_post($str)
    {
        if ($this->session->flashdata('sessionCaptchaPostProduct') && $this->session->flashdata('sessionCaptchaPostProduct') === $str) {
            return true;
        }
        return false;
    }

    function baokim_success()
    {
        $data['globalProduct'] = 0;
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data['menuType'] = 'account';        
        $this->load->model('order_model');
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data['module'] = 'top_saleoff_product';
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        $order_id = $this->uri->segment(3);
        //echo $order_id;die();
        $order = $this->order_model->loadDetailOrder($order_id);
        $data['list_product'] = $order;
        //echo "<pre>";print_r($order);echo "</pre>";die();
        $this->load->model('user_model');
        $user_order = $this->user_model->get("*", "use_id = " . (int)$order[0]->use_id . " AND use_status = 1 AND (use_enddate >= $currentDate OR use_enddate=0)");
        $data['user'] = $user_order;
        #BEGIN: Advertise
        $data['advertisePage'] = 'account';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        $this->load->view('home/product/baokim_success', $data);
    }

    function payment_success()
    {
        $data['globalProduct'] = 0;
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data['menuType'] = 'account';
        $this->load->model('product_model');
        $this->load->model('order_model');
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data['module'] = 'top_saleoff_product';
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        $order_id = $this->uri->segment(3);
        //echo $order_id;die();
        $order = $this->order_model->loadDetailOrder($order_id);
        $data['list_product'] = $order;
        //echo "<pre>";print_r($order);echo "</pre>";die();
        $this->load->model('user_model');
        $user_order = $this->user_model->get("*", "use_id = " . (int)$order[0]->use_id . " AND use_status = 1 AND (use_enddate >= $currentDate OR use_enddate=0)");
        $data['user'] = $user_order;
        #BEGIN: Advertise
        $data['advertisePage'] = 'account';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        $this->load->view('home/product/payment_success', $data);
    }

    function nganluong_success($order_id)
    {
        $this->load->model('nganluong_model');
        $this->load->model('order_model');
        $this->load->model('product_model');
        $order_detail = $this->order_model->get("*", "id = " . $order_id);
        $nl_result = $this->nganluong_model->GetTransactionDetail($order_detail->token);
        //$order_id = $nl_result->order_code;
        $pro_type = (int)$order_detail->product_type;
        $status = 0;
        $order_status = '';
        if ($nl_result) {
            $nl_errorcode = (string)$nl_result->error_code;
            $nl_transaction_status = (string)$nl_result->transaction_status;
            if ($nl_errorcode == '00') {
                if ($nl_transaction_status == '00' || $nl_transaction_status == '04') {
                    $status = 1;
                    $order_status = '98';
                    //trạng thái thanh toán thành công
                }
                if ($nl_transaction_status == '01' || $nl_transaction_status == '02') {
                    $status = 0;
                }
                $mcode = $order_detail->order_coupon_code;
                if ($pro_type == 2 && $mcode == "") {
                    do {
                        $mcode = $this->order_model->makeOrderCouponCode();
                        $order = $this->order_model->get("*", "order_coupon_code ='" . $mcode . "'");
                        if (count($order) > 0) {
                            $isExist = true;
                        } else {
                            $isExist = false;
                        }
                    } while ($isExist);
                }
                $this->order_model->update_nl_order($order_id, $status, "", "payment method :" . $nl_result->payment_method . " | bank code :" . $nl_result->bank_code . " | transaction_status : " . $nl_result->transaction_status . " | transaction_id : " . $nl_result->transaction_id, $mcode, $order_status);
                redirect(base_url() . 'orders-success/' . $order_id . "?order_token=" . $order_detail->order_token . "&pro_type=" . $pro_type);
            } else {
                //$error =  $this->nganluong_model->GetErrorMessage($nl_errorcode);
                if ($pro_type > 0) {
                    $this->order_model->update_nl_order($order_id, '0', "", "", "", "99");
                }
                redirect(base_url() . 'orders-error/' . $order_id . "?order_token=" . $order_detail->order_token . "&pro_type=" . $pro_type);
            }
        }
    }

    private function sendEmail($to, $from, $body, $attachment = '', $from_name = "Azibai.com", $subject = "")
    {
        $this->load->model('shop_mail_model');
        $this->load->library('email');
        $config['useragent'] = $this->lang->line('useragen_mail_detail');
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.pop3.php');
        return $this->shop_mail_model->smtpmailer($to, $from, $from_name, $subject, $body, $attachment);
    }

    function nganluong_cancle($order_id)
    {
        $this->load->model('order_model');
        $this->order_model->update_nl_order($order_id, "0", "", "", "", "99");
        redirect(base_url() . 'orders-error/' . $order_id);
        //$this->load->view('home/product/nganluong_cancle');
    }

    function fail_transaction_baokim()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $data['menuType'] = 'product';
        $this->load->model('product_model');
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data['module'] = 'top_saleoff_product';
        $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
        $start = 0;
        $limit = (int)settingProductSaleoff_Top;
        $data['topSaleoffProduct'] = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_saleoff = 1 AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
        $this->load->view('home/product/baokim_fail', $data);
    }

    // Quang
    function loadCategory_two()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
        if ($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            $data['isLogined'] = true;
            if ($this->session->flashdata('sessionSuccessFavoriteProduct')) {
                $data['successFavoriteProduct'] = true;
            }
            if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost) {
                $this->load->model('product_favorite_model');
                $isAdded = false;
                foreach ($this->input->post('checkone') as $checkOneArray) {
                    $productOne = $this->product_model->get("pro_user", "pro_id = " . (int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = " . (int)$checkOneArray . " AND prf_user = " . (int)$this->session->userdata('sessionUser'));
                    if (count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray)) {
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
                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;
        $data['advertisePage'] = 'product_sub';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        $data['counter'] = $this->counter_model->get();
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        $retArray = array();
        $this->display_child_showcategory_page(0, 0, $retArray);
        $data['categoryViewPage'] = $retArray;
        $this->load->view('home/product/showcategory', $data);
    }

    // Quang sub category end
    function display_showSubcategory_end($parent, $level, &$retArray)
    {
        $sql = "SELECT * from `tbtt_category` WHERE parent_id='$parent' and cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $i = 0;
        if (count($query->result_array()) > 0) {
            foreach ($query->result_array() as $row) {
                $sql1 = "SELECT * from `tbtt_category` WHERE parent_id='" . $row['cat_id'] . "' and cat_status = 1 order by cat_order";
                $query1 = $this->db->query($sql1);
                if (count($query1->result_array()) > 0) {
                    foreach ($query1->result_array() as $row1) {
                        $object = new StdClass;
                        $object->cat_id = $row1['cat_id'];
                        $retArray[] = $object;
                    }
                } else {
                    $object = new StdClass;
                    $object->cat_id = $row['cat_id'];
                    $retArray[] = $object;
                }
            }
        } else {
            $object = new StdClass;
            $object->cat_id = $parent;
            $retArray[] = $object;
        }
    }

    function display_child_showcategory_page($parent, $level, &$retArray)
    {
        $sql = "SELECT * from `tbtt_category` WHERE parent_id='$parent' and cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $i = 0;
        foreach ($query->result_array() as $row) {
            $object = new StdClass;
            $object->cat_id = $row['cat_id'];
            $object->cat_name = $row['cat_name'];
            $object->levelQ = $level;
            $retArray[] = $object;
            $this->display_child_showcategory_page($row['cat_id'], $level + 1, $retArray);
            //edit by nganly de qui
            $i = $i + 1;
        }
    }

    function ajax()
    {
        $this->load->model('category_model');
        $parent_id = (int)$this->input->post('parent_id');
        $cat_level = $this->category_model->fetch("*", "parent_id = ". $parent_id ." AND cat_status = 1", "cat_order, cat_id", "ASC");

        if (isset($cat_level)) {
            foreach ($cat_level as $key => $item) {
                $cat_level_next = $this->category_model->fetch("*", "parent_id = ". (int)$item->cat_id ." AND cat_status = 1");
                $cat_level[$key]->child_count = count($cat_level_next);
            }
        }
        echo "[". json_encode($cat_level) .",". count($cat_level) ."]";
        exit();
    }
    //end Quang

    //Build by Phuc Nguyen
    public function search($params1 = NULL)
    {
        // if ($this->input->post('category_quick_search_q')) {
        //     $detail = $this->product_model->get('pro_id,pro_name,pro_category', 'pro_name = "' . $this->input->post('key') . '"');
        //     if ($detail) {
        //         redirect(base_url() . $detail->pro_category . '/' . $detail->pro_id . '/' . RemoveSign($detail->pro_name));
        //     }
        // }

        $this->load->library("pagination");
        if ($params1 == NULL) {
            $offset = 0;
        } else {
            $offset = ($params1 - 1) * limitShowProduct;
        }

        $province = "";
        $district = "";
        $where = array();

        if ($this->input->post('province')) {
            $province = $this->input->post('province');
        }
        if ($this->input->post('key')) {
            $where['sho_name'] = $this->input->post('key');
        }

        if ($this->input->post('district') && $this->input->post('district') != "product" && $this->input->post('district') != "service" && $this->input->post('district') != "coupon") {
            $select2 = "sho_id, sho_name, sho_descr, sho_province, sho_address, sho_banner, sho_dir_banner, sho_logo, sho_dir_logo, sho_phone,sho_mobile, sho_email, shop_type";
            $where['sho_province'] = $province;
            switch ($this->input->post('district')) {
                case 'store';
                    $where['use_group'] = 3;
                    break;
                case 'agency';
                    $where['use_group'] = 2;
                    break;
                case 'saler';
                    $where['shop_type'] = 1;
                    $where['use_group'] = 3;
                    break;
            }
            $result = $this->_getLisShops($where, limitShowProduct, $offset);
            if ($this->input->post('district') == "store") {
                $data['store'] = $result;
            } else {
                $data['agency'] = $result;
            }
        } else {
            $where['pro_name'] = $where['sho_name'];
            switch ($this->input->post('district')) {
                case 'service';
                    $where['pro_type'] = 1;
                    break;
                case 'coupon';
                    $where['pro_type'] = 2;
                    break;
                case 'product';
                    $where['pro_type'] = 0;
                    break;
            }
            $where['province'] = $province;

            if ($this->input->post('low_price')) {
                $where['low_price'] = $this->input->post('low_price');
            }

            if ($this->input->post('high_price')) {
                $where['high_price'] = $this->input->post('high_price');
            }

            if ($this->input->post('sale_off')) {
                $where['sale_off'] = 1;
            } else {
                $where['sale_off'] = "";
            }
            $pro_ducts = $this->__getListProducts($where, limitShowProduct, $offset);
            if($this->session->userdata('sessionUser') && count($pro_ducts) > 0){
                $this->load->model('like_product_model');
                foreach ($pro_ducts as $key => $value) {
                    $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                    $value->is_like = count($is_like);
                }
            }
            $data['pro_ducts'] = $pro_ducts;
        }
        $data['linkPage'] = $this->pagination->create_links();
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
        $this->load->view('home/product/search', $data);
    }

    private function _getLisShops($where, $limitShowProduct, $offset, $order = 'tbl.sho_id', $order_value = 'DESC')
    {
        $total = $this->shop_model->getLisShops($where, NULL, NULL, NULL, TRUE);
        $config = pagination(base_url() . 'search-information/', $total, 8, 2);
        $this->pagination->initialize($config);

        return $this->shop_model->getLisShops($where, array('key' => $order, 'value' => $order_value), limitShowProduct, $offset, NULL);
    }

    private function __getListProducts($where, $limitShowProduct, $offset, $order = 'sho.sho_id', $order_value = 'DESC')
    {
        $total = $this->product_model->getListProducts($where, array('key' => $order, 'value' => $order_value), NULL, NULL, TRUE);
        $config = pagination(base_url() . 'search-information/', $total, 8, 2);
        $this->pagination->initialize($config);

        return $this->product_model->getListProducts($where, array('key' => $order, 'value' => $order_value), $limitShowProduct, $offset, NULL);
    }

    private function countProductByUser($params1)
    {
        #END: Load model        
        $userId = $params1;
        //Neu la Chi Nhanh thi gan lai userId
        if ((int)$this->session->userdata('sessionGroup') == BranchUser) {
            $user_pa = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $userId . ' AND use_status = 1');
            $userId = $user_pa->parent_id;
            if ($user_pa->use_group == StaffStoreUser) {
                $user_pa_pa = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $user_pa->parent_id . ' AND use_status = 1');
                $userId = $user_pa_pa->parent_id;
            }
        }

        $check = FALSE;
        $shopInfo = $this->product_model->GetPackageValue($userId);
        $now = date("Y-m-d H:i:s");
        $temp = 1;
        $limits = $this->product_model->GetLimitOfShopPackage(1);

        $limit = $limits[0]->limit;

        if ($shopInfo[0]->info_id > 1 && $shopInfo[0]->begined_date <= $now && $shopInfo[0]->ended_date >= $now) {
            $temp = $shopInfo[0]->info_id;
            $limit = $shopInfo[0]->limit;
            $begined_date = $shopInfo[0]->begined_date;
            $ended_date = $shopInfo[0]->ended_date;
        }
        if ($shopInfo[0]->info_id == 1) {
            $temp = $shopInfo[0]->info_id;
            $limit = $shopInfo[0]->limit;
        }

        foreach ($shopInfo as $shop) {
            if ($shop->info_id > $temp && $shop->begined_date <= $now && $shop->ended_date >= $now && $shop->info_id > 1) {
                $temp = $shop->info_id;
                $limit = $shop->limit;
                $begined_date = $shopInfo[0]->begined_date;
                $ended_date = $shopInfo[0]->ended_date;
            }
        }
        //Get array Branch son of SHOP
        $tree = array();
        $sub_user = $this->user_model->fetch('use_id, use_username, use_group', 'parent_id = ' . $userId . ' AND use_status = 1 AND use_group = ' . BranchUser);
        foreach ($sub_user as $key) {
            $tree[] = $key->use_id;
        }
        $tree = implode(',', $tree);
        $list_pro_of_sub = 0;

        //get total product or service or coupon of Shop
        if ($this->uri->segment(2) == 'product') {
            $count_products_shop = $this->product_model->countProductPackage(array('pro_user' => $userId, 'pro_type' => 0), 'pro_id', TRUE);
            $pro_type = 'pro_type = 0';
            $type = "sản phẩm";
        }

        if ($this->uri->segment(2) == 'service') {
            $count_products_shop = $this->product_model->countProductPackage(array('pro_user' => $userId, 'pro_type' => 1), 'pro_id', TRUE);
            $pro_type = 'pro_type = 1';
            $type = "dịch vụ";
        }
        if ($this->uri->segment(2) == 'coupon') {
            $count_products_shop = $this->product_model->countProductPackage(array('pro_user' => $userId, 'pro_type' => 2), 'pro_id', TRUE);
            $pro_type = 'pro_type = 2';
            $type = "coupon";
        }

        if ($tree != '') {
            $list_pro_of_sub = $this->product_model->getProductOfSub('pro_user IN (' . $tree . ') AND ' . $pro_type, 'pro_id', TRUE);
        }

        $count_products = $count_products_shop + $list_pro_of_sub;
        switch ($temp) {
            case '1':
                if ($count_products >= $limit) {
                    $this->session->set_flashdata('countProductByUser', "Gói dịch vụ của Gian hàng này đang sử dụng chỉ được phép tạo tối đa " . $limit . " " . $type . ".");
                    if ($this->uri->segment(2) == 'post') {
                        redirect(base_url() . 'account/product');
                    }
                    if ($this->uri->segment(2) == 'service') {
                        redirect(base_url() . 'account/product/service');
                    }
                    if ($this->uri->segment(2) == 'coupon') {
                        redirect(base_url() . 'account/product/coupon');
                    }
                }
                break;
            case '2':
                $now = date("Y-m-d H:i:s");
                if ($count_products >= $limit) {
                    $check = TRUE;
                    $lang = "Gói dịch vụ của Gian hàng này đang sử dụng chỉ được phép tạo tối đa " . $limit . " " . $type . ".";
                }

                if ($check) {

                    $this->session->set_flashdata('countProductByUser', $lang);
                    if ($this->uri->segment(2) == 'post') {
                        redirect(base_url() . 'account/product');
                    }
                    if ($this->uri->segment(2) == 'service') {
                        redirect(base_url() . 'account/product/service');
                    }
                    if ($this->uri->segment(2) == 'coupon') {
                        redirect(base_url() . 'account/product/coupon');
                    }
                }
                break;
            case '3':
                $now = date("Y-m-d H:i:s");
                if ($count_products >= $limit) {
                    $check = TRUE;
                    $lang = "Gói dịch vụ của Gian hàng này đang sử dụng chỉ được phép tạo tối đa " . $limit . " " . $type . ".";
                    //$lang = $this->lang->line('redirect_notice_package_100');
                }

                if ($check) {
                    $this->session->set_flashdata('countProductByUser', $lang);
                    if ($this->uri->segment(2) == 'post') {
                        redirect(base_url() . 'account/product');
                    }
                    if ($this->uri->segment(2) == 'service') {
                        redirect(base_url() . 'account/product/service');
                    }
                    if ($this->uri->segment(2) == 'coupon') {
                        redirect(base_url() . 'account/product/coupon');
                    }
                }
                break;
            case '4':
                $now = date("Y-m-d H:i:s");
                if ($count_products >= $limit) {
                    $check = TRUE;
                    $lang = "Gói dịch vụ của Gian hàng này đang sử dụng chỉ được phép tạo tối đa " . $limit . " " . $type . ".";                    
                }

                if ($check) {
                    $this->session->set_flashdata('countProductByUser', $lang);
                    if ($this->uri->segment(2) == 'post') {
                        redirect(base_url() . 'account/product');
                    }
                    if ($this->uri->segment(2) == 'service') {
                        redirect(base_url() . 'account/product/service');
                    }
                    if ($this->uri->segment(2) == 'coupon') {
                        redirect(base_url() . 'account/product/coupon');
                    }
                }
                break;
        }

        return TRUE;
    }

    public function noticeServicePackage()
    {
        if ($this->session->flashdata('countProductByUser')) {
            $data['flash_message'] = $this->session->flashdata('countProductByUser');
            $this->load->view('home/product/noticeServicePackage', $data);
        } else {
            redirect(base_url() . 'account');
        }
    }

    // check ip
    function get_client_ip_server()
    {
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $ipaddress = getHostByName(getHostName());
            return $ipaddress;
        } else {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP']) $ipaddress = $_SERVER['HTTP_CLIENT_IP']; else if ($_SERVER['HTTP_X_FORWARDED_FOR']) $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']; else if ($_SERVER['HTTP_X_FORWARDED']) $ipaddress = $_SERVER['HTTP_X_FORWARDED']; else if ($_SERVER['HTTP_FORWARDED_FOR']) $ipaddress = $_SERVER['HTTP_FORWARDED_FOR']; else if ($_SERVER['HTTP_FORWARDED']) $ipaddress = $_SERVER['HTTP_FORWARDED']; else if ($_SERVER['REMOTE_ADDR']) $ipaddress = $_SERVER['REMOTE_ADDR']; else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }

    public function add_view_af_share($productID)
    {
        //add info view af share
        if (isset($_REQUEST['share'])) {
            $user_key = $_REQUEST['share'];
        } elseif (isset($_REQUEST['af_id'])) {
            $user_key = $_REQUEST['af_id'];
        } else {
            $user_key = '';
        }
        if ($user_key != '') {
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
                // check mobi
                $device = "";
                $this->load->library('Mobile_Detect');
                $detect = new Mobile_Detect();
                if ($detect->isAndroidOS()) {
                    $device = 'AndroidOS';
                } elseif ($detect->isiOS()) {
                    $device = 'iOS';
                } elseif ($detect->isMobile()) {
                    $device = 'Mobile';
                } else {
                    $device = 'Desktop';
                }
                // get ip client
                $ip = $this->get_client_ip_server();
                $this->load->model('af_share_model');
                $data_view['pro_id'] = $productID;
                $data_view['af_key'] = $user_key;
                $data_view['time_view'] = date('Y-m-d H:i:s');
                $data_view['agent_view'] = $agent;
                $data_view['device'] = $device;
                $data_view['ip_use'] = $ip;
                $kq = $this->af_share_model->add($data_view);
            }

        }
    }

    function profromshop($page = 0)
    {
	    if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == BranchUser) {
            } else {
                redirect(base_url() .'account', 'location');
                die();
            }

            #If have page
            if ($this->uri->segment(3) != '') {
                $page = (int)$this->uri->segment(3);
            } else {
                $page = 0;
            }

            $body = array();
            #BEGIN: Menu
            $body['menuType'] = 'account';
            $url = $this->uri->segment(2);
            if ($url == 'coufromshop') {
                $body['menuSelected'] = 'product_coupon';
            } elseif ($url == 'profromshop') {
                $body['menuSelected'] = 'product';
            }
            #END: Menu
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/affiliate.js');
            $this->af_product_model->pagination(TRUE);
            $this->af_product_model->setCurLink('account/profromshop');

            $shop = $this->shop_model->get('*', 'sho_user = '. (int)$this->session->userdata('sessionUser'));
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;
            $body['sho_category'] = $shop->sho_category;
            $afId = (int)$this->session->userdata('sessionUser');
            $get_info = $this->user_model->get('parent_id, use_group', 'use_id = ' . $afId);
            $get_parent = $this->user_model->get('parent_id, use_group, use_id', 'use_id = ' . $get_info->parent_id);
            if ($get_parent->use_group != 3) {
                $afId = (int)$get_parent->use_id;
            }
            $body['number_cat'] = 1;
            $numberMyProduct = $this->af_product_model->myNumberProduct($afId);
            $body['numberMyProduct'] = $numberMyProduct;

            $catlv = $this->category_model->fetch('cat_id, cat_name, parent_id', 'cat_level = 0 AND cat_status = 1', '', '', '', '');
            if (isset($catlv)) {
                foreach ($catlv as $key => $item) {
                    $cat_level_1 = $this->category_model->fetch('*', 'parent_id = '. (int)$item->cat_id .' AND cat_status = 1');
                    $catlv[$key]->child_count = count($cat_level_1);
                }
            }
            $body['childcat'] = $catlv;
            $catsub = $_REQUEST['cat_pro_0'];
            $catsub1 = $_REQUEST['cat_pro_1'];
            $catsub2 = $_REQUEST['cat_pro_2'];
            $catsub3 = $_REQUEST['cat_pro_3'];
            $catsub4 = $_REQUEST['cat_pro_4'];
            if (isset($catsub) && (int)$catsub > 0) {
                if (isset($catsub1) && $catsub1 > 0) {
                    $catsubArray = $this->recursive($catsub1);
                } elseif (isset($catsub2) && $catsub2 > 0) {
                    $catsubArray = $this->recursive($catsub2);
                } elseif (isset($catsub3) && $catsub3 > 0) {
                    $catsubArray = $this->recursive($catsub3);
                } elseif (isset($catsub4) && $catsub4 > 0) {
                    $catsubArray = $this->recursive($catsub4);
                } else {
                    $catsubArray = $this->recursive($catsub);
                }
                $cat_id = '';

                if (is_array($catsubArray) && count($catsubArray) > 0) {
                    foreach ($catsubArray as $k => $item) {
                        if ($k == 0) {
                            $cat_id = $item->cat_id;
                        } else {
                            $cat_id .= ',' . $item->cat_id;
                        }
                    }
                } else {
                    $cat_id = (int)$catsub;
                }
            }
            $body['cat_id'] = $cat_id;
            
	        $body['products'] = $this->af_product_model->SelectListFromShop(array('use_id' => $afId), $page, $cat_id);
            
	        $user_detail = $this->user_model->get('*', 'use_id = '. (int)$this->session->userdata('sessionUser'));
            $this->db->flush_cache();
            $parent_detail = $this->user_model->get('*', 'use_id = '. $user_detail->parent_id);
            $this->db->flush_cache();
            if ((int)$parent_detail->use_group != 3 && $user_detail->parent_shop == 0) {
                $body['show_btn'] = 0;
            } else {
                $body['show_btn'] = 1;
            }

            #BEGIN:Get list product in my factory            
            $list_pro_of_shop = $this->product_model->fetch('pro_of_shop', 'pro_user = '. (int)$this->session->userdata('sessionUser') .' AND pro_status = 1');
            $this->db->flush_cache();
            $tree = array();
            foreach ($list_pro_of_shop as $pro => $p_id) {
                $tree[] = $p_id->pro_of_shop;
            }
            $body['factory_bran'] = $tree;
            #END:Get list product in my factory
	    
            $body['pager'] = $this->af_product_model->pager;
            $body['sort'] = $this->af_product_model->getAdminSort();
            $body['filter'] = $this->af_product_model->getFilter();
            $body['category'] = $this->af_product_model->getCategory();
            $body['link'] = base_url() . $this->af_product_model->getRoute('profromshop');
            $body['productLink'] = $body['link'];
            $body['myproductsLink'] = base_url() . $this->af_product_model->getRoute('myproducts');
            $body['num'] = $page;
            $body['shopCategory'] = $this->af_product_model->getShopCategory();
	       
	        # Load view
            $this->load->view('home/product/profromshop', $body);
        } else {
            redirect(base_url() .'login', 'location');
            die();
        }
    }
    
    public function ajaxclone()
    {
	    $user_detail = $this->user_model->get('*', 'use_id = '. (int)$this->session->userdata('sessionUser'));	
	    $get_parent = $this->user_model->get('parent_id, use_group, use_id', 'use_id = '. $user_detail->parent_id);    	
    	$pro_id = (int)$this->input->post('proid');
    	$quantity = (int)$this->input->post('quantity');

        // Param redirect
        $protype = '';      
        if ((int)$this->input->post('protype') == 0) {
            $protype = 'profromshop'; 
        } else if ((int)$this->input->post('protype') == 2) {
            $protype = 'coufromshop'; 
        }

    	if (isset($pro_id) && $pro_id > 0 && isset($quantity) && $quantity > 0) {
    	    $this->db->flush_cache();

    	    //Kiểm tra số lượng đủ trong kho gian hàng
    	    $p_id = $user_detail->parent_id;
    	    if ($get_parent->use_group != AffiliateStoreUser) {		    
    		    $p_id = $get_parent->parent_id;
    	    }

    	    $check_pro = $this->product_model->get('*', 'pro_id = '. $pro_id .' AND pro_user = "'. $p_id .'"');
    	    if ($check_pro && $check_pro->pro_instock >= $quantity) {
    		    $this->db->flush_cache();
    		    //Kiểm tra nó đã được Chi nhánh chọn bán chưa?
    		    $is_pro_bran = $this->product_model->get('*', 'pro_of_shop = ' . $pro_id . ' AND pro_user = ' . (int)$this->session->userdata('sessionUser'));
    		    if (empty($is_pro_bran)) {
        		    $this->load->library('image_lib');
        		    $this->load->library('ftp');
        		    $configftp['hostname'] = IP_CLOUDSERVER;
        		    $configftp['username'] = USER_CLOUDSERVER;
        		    $configftp['password'] = PASS_CLOUDSERVER;
        		    $configftp['port'] = PORT_CLOUDSERVER;
        		    $configftp['debug'] = FALSE;
        		    $this->ftp->connect($configftp);

    		        $pathLocal = 'media/images/product/'. $check_pro->pro_dir;
        		    if (! file_exists($pathLocal)) {
        			    mkdir($pathLocal, 0775, true);
        		    }		
    		    	
        		    $pathTarget = '/public_html/media/images/product/'. $check_pro->pro_dir;			
        		    $listDown = explode(',', $check_pro->pro_image);
        		    $listUp = '';
    		    
                    foreach($listDown as $key => $value) {
            			//Download to domain.com
            			$this->ftp->download($pathTarget .'/'. $value, $pathLocal .'/'. $value);		 
            			//Rename all image download
            			$extension = end(explode('.', $value));
            			$newName = $this->randkey(32) .'.'. $extension; 
            			rename($pathLocal .'/'. $value, $pathLocal .'/'. $newName);

            			if($key == 0) { $listUp .= $newName;
            			} else { $listUp .= ','. $newName;				    
            			}

            			for($i = 1; $i < 4; $i++) {
            			    if($i == 1) {$sizethumb = '150';}
            			    if($i == 2) {$sizethumb = '300';}
            			    if($i == 3) {$sizethumb = '600';}
            			    $configResize = array(
                				'source_image' => $pathLocal .'/'. $newName,
                				'new_image' => $pathLocal .'/thumbnail_'. $i .'_'. $newName,
                				'maintain_ratio' => true,
                				'width' => $sizethumb,
                				'height' => $sizethumb			    
            			    );

            			    $this->image_lib->clear();
            			    $this->image_lib->initialize($configResize);
            			    $this->image_lib->resize();
            			}

            			// Upload to domain.org
            			$this->ftp->upload($pathLocal .'/'. $newName, $pathTarget .'/'. $newName, 'auto', 0775);
            			$this->ftp->upload($pathLocal .'/thumbnail_1_'. $newName, $pathTarget .'/thumbnail_1_'. $newName, 'auto', 0775);
            			$this->ftp->upload($pathLocal .'/thumbnail_2_'. $newName, $pathTarget .'/thumbnail_2_'. $newName, 'auto', 0775);
            			$this->ftp->upload($pathLocal .'/thumbnail_3_'. $newName, $pathTarget .'/thumbnail_3_'. $newName, 'auto', 0775);
        		    } // endforeach;	

        		    //Chưa có, thêm product này cho Chi Nhánh
        		    $dataCopy = array(
            			'pro_name' => $check_pro->pro_name,
            			'pro_sku' => $check_pro->pro_sku,
            			'pro_descr' => $check_pro->pro_descr,
            			'pro_keyword' => $check_pro->pro_keyword,
            			'pro_cost' => $check_pro->pro_cost,
            			'pro_currency' => $check_pro->pro_currency,
            			'pro_hondle' => $check_pro->pro_hondle,
            			'pro_saleoff' => $check_pro->pro_saleoff,
            			'pro_province' => $check_pro->pro_province,
            			'pro_category' => $check_pro->pro_category,
            			'pro_begindate' => $check_pro->pro_begindate,
            			'pro_enddate' => $check_pro->pro_enddate,
            			'pro_detail' => $check_pro->pro_detail,
            			'pro_image' => $listUp,
            			'pro_dir' => $check_pro->pro_dir,
            			'pro_user' => (int)$this->session->userdata('sessionUser'), //ID chi nhánh
            			'pro_poster' => $check_pro->pro_poster,
            			'pro_address' => $check_pro->pro_address,
            			'pro_phone' => $check_pro->pro_phone,
            			'pro_mobile' => $check_pro->pro_mobile,
            			'pro_email' => $check_pro->pro_email,
            			'pro_yahoo' => $check_pro->pro_yahoo,
            			'pro_skype' => $check_pro->pro_skype,
            			'pro_status' => $check_pro->pro_status,
            			'pro_view' => $check_pro->pro_view,
            			'pro_buy' => $check_pro->pro_buy,
            			'pro_comment' => $check_pro->pro_comment,
            			'pro_vote_cost' => $check_pro->pro_vote_cost,
            			'pro_vote_quanlity' => $check_pro->pro_vote_quanlity,
            			'pro_vote_model' => $check_pro->pro_vote_model,
            			'pro_vote_service' => $check_pro->pro_vote_service,
            			'pro_vote_total' => $check_pro->pro_vote_total,
            			'pro_vote' => $check_pro->pro_vote,
            			'pro_reliable' => $check_pro->pro_reliable,
            			'pro_saleoff_value' => $check_pro->pro_saleoff_value,
            			'pro_hot' => $check_pro->pro_hot,
            			'is_product_affiliate' => $check_pro->is_product_affiliate,
            			'af_amt' => $check_pro->af_amt,
            			'af_rate' => $check_pro->af_rate,
            			'af_dc_amt' => $check_pro->af_dc_amt,
            			'af_dc_rate' => $check_pro->af_dc_rate,
            			'pro_show' => $check_pro->pro_show,
            			'pro_type_saleoff' => $check_pro->pro_type_saleoff,
            			'pro_manufacturer_id' => $check_pro->pro_manufacturer_id,
            			'pro_instock' => $quantity, //get so luong
            			'pro_weight' => $check_pro->pro_weight,
            			'pro_length' => $check_pro->pro_length,
            			'pro_width' => $check_pro->pro_width,
            			'pro_height' => $check_pro->pro_height,
            			'pro_minsale' => $check_pro->pro_minsale,
            			'pro_vat' => $check_pro->pro_vat,
            			'pro_quality' => $check_pro->pro_quality,
            			'pro_made_from' => $check_pro->pro_made_from,
            			'pro_warranty_period' => $check_pro->pro_warranty_period,
            			'pro_video' => $check_pro->pro_video,
            			'created_date' => date("Y-m-d"), //ngày lấy
            			'begin_date_sale' => $check_pro->begin_date_sale,
            			'end_date_sale' => $check_pro->end_date_sale,
            			'pro_type' => $check_pro->pro_type,
            			'pro_of_shop' => $check_pro->pro_id//ID sản phẩm nó lấy
        		    );

        		    if ($this->product_model->add($dataCopy)) {
        			    $id_insert = $this->db->insert_id();
        			    $this->db->flush_cache();
        			    $get_detail_pro = $this->detail_product_model->fetch('*', 'dp_pro_id = '. $check_pro->pro_id);
        			    if ($get_detail_pro) {
        			        foreach ($get_detail_pro as $k_dp => $v_dp) {
        				        //Download to domain.com
            				    $this->ftp->download($pathTarget .'/'. $v_dp->dp_images, $pathLocal .'/'. $v_dp->dp_images);			 
            				    //Rename all image download
            				    $extension = end(explode('.', $v_dp->dp_images));
            				    $newName = $this->randkey(32) .'.'. $extension; 
            				    rename($pathLocal .'/'. $v_dp->dp_images, $pathLocal .'/'. $newName);
                				
                                for($i = 1; $i < 4; $i++){
                				    if($i == 1) {$sizethumb = '150';}
                				    if($i == 2) {$sizethumb = '300';}
                				    if($i == 3) {$sizethumb = '600';}
                				    $configResize = array(
                    					'source_image' => $pathLocal .'/'. $newName,
                    					'new_image' => $pathLocal .'/thumbnail_'. $i .'_'. $newName,
                    					'maintain_ratio' => true,
                    					'width' => $sizethumb,
                    					'height' => $sizethumb			    
                				    );
                				    $this->image_lib->clear();
                				    $this->image_lib->initialize($configResize);
                				    $this->image_lib->resize();
                				}

                				// Upload to domain.org
                				$this->ftp->upload($pathLocal .'/'. $newName, $pathTarget .'/'. $newName, 'auto', 0775);
                				$this->ftp->upload($pathLocal .'/thumbnail_1_'. $newName, $pathTarget .'/thumbnail_1_'. $newName, 'auto', 0775);
                				$this->ftp->upload($pathLocal .'/thumbnail_2_'. $newName, $pathTarget .'/thumbnail_2_'. $newName, 'auto', 0775);
                				$this->ftp->upload($pathLocal .'/thumbnail_3_'. $newName, $pathTarget .'/thumbnail_3_'. $newName, 'auto', 0775);

                				$arr_detail_pro = array(
                				    'dp_pro_id' => $id_insert,
                				    'dp_images' => $newName,
                				    'dp_size' => $v_dp->dp_size,
                				    'dp_color' => $v_dp->dp_color,
                				    'dp_material' => $v_dp->dp_material,
                				    'dp_cost' => $v_dp->dp_cost,
                				    'dp_instock' => $v_dp->dp_instock,
                				    'dp_createdate' => date('Y-m-d')
                				);
                				$this->detail_product_model->add($arr_detail_pro);
            			    }
            			}

    			        array_map('unlink', glob($pathLocal .'/*'));
        			    @rmdir($pathLocal);			
        			    $this->ftp->close();
        			    $this->db->flush_cache();
        			    $get_promo_pro = $this->product_promotion_model->fetch('*', 'pro_id = '. $check_pro->pro_id);
        			    if ($get_promo_pro) {
            			    foreach ($get_promo_pro as $k_promo => $v_promo) {
                				$arr_promo_pro = array(
                				    'pro_id' => $id_insert,
                				    'limit_from' => $v_promo->limit_from,
                				    'limit_to' => $v_promo->limit_to,
                				    'limit_type' => $v_promo->limit_type,
                				    'dc_rate' => $v_promo->dc_rate,
                				    'dc_amt' => $v_promo->dc_amt
                				);
                				$this->product_promotion_model->addPromo($arr_promo_pro);
            			    }
            			}

        			    $this->db->flush_cache();
        			    //Add xong, trừ số lượng của GH                            
        			    $this->product_model->update(array('pro_instock' => $check_pro->pro_instock - $quantity), 'pro_id = '. $pro_id);
        			    //echo $this->db->last_query();                            
    		        }

        		    array_map('unlink', glob($pathLocal .'/*'));
        		    @rmdir($pathLocal);			
        		    $this->ftp->close();	    
        		    $this->session->set_flashdata('sessionSuccess', 'Lấy hàng thành công!!');
    		    } else {
        		    //Có rồi thì update số lượng
        		    $this->db->flush_cache();
        		    $dataUpdate = array('pro_instock' => $is_pro_bran->pro_instock + $quantity);			
        		    if ($this->product_model->update($dataUpdate, 'pro_of_shop = '. $pro_id .' AND pro_user = '. (int)$this->session->userdata('sessionUser'))) {
            			$this->db->flush_cache();
            			$this->product_model->update(array('pro_instock' => $check_pro->pro_instock - $quantity), 'pro_id = '. $pro_id);
            			$this->session->set_flashdata('sessionSuccess', 'Cập nhật số lượng thành công!!');
        		    }
        		}
    	    } else {
                $this->session->set_flashdata('sessionSuccess', 'Số lượng sản phẩm không đủ!!');
            }    		
	    } else {
            $this->session->set_flashdata('sessionSuccess', 'Sản phẩm không tồn tại hoặc phải nhập số lượng lớn hơn không!!');
        }

        redirect(base_url() .'account/'. $protype, 'location');
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
    
    
    public function randkey($leng = 1)
    {
	    $numbers = '0123456789';
	    $lowers = 'abcdefghijklmnopqrstuvwxyz';
	    $specials = '';
	    $chars = $numbers.$lowers.strtolower($lowers).$specials;
	    $key = '';
	    for($i = 0; $i < $leng; $i++)
	    {
		    $key = $key . substr($chars, rand(0, strlen($chars)-1), 1);
	    }
	    return $key;
    }
    
    public function rrmdir($dir) 
    { 
    	if (is_dir($dir)) { 
    	    $objects = scandir($dir); 
    	    foreach ($objects as $object) { 
        	    if ($object != "." && $object != "..") { 
        	        if (is_dir($dir."/".$object))
        		        rrmdir($dir."/".$object);
        	        else
        		        unlink($dir."/".$object); 
    	        } 
        	}
    	    rmdir($dir); 
    	} 
    }

    /**
     ***************************************************************************
     * Created: 2018/08/29
     * Get Shop 
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return array shop infomation
     *  
     ***************************************************************************
    */

    private function getShop($iGroupId = 0, &$parent_id) {

        if($iGroupId == StaffStoreUser) {
            $parent_id = $this->user_model->get("parent_id", "use_id =" . $this->session->userdata('sessionUser'))->parent_id;
            $shop = $this->shop_model->get("*", "sho_user = " . $parent_id . ' AND sho_status = 1');
        } else {
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser') . ' AND sho_status = 1');
        }

        if(isset($shop) && !empty($shop) && $shop->sho_name != '' && $shop->sho_address != '' && $shop->sho_kho_address != '' && $shop->sho_kho_district != '' && $shop->sho_kho_province != '') {
            return $shop;
        }
        
        return array();
    }

    /**
     ***************************************************************************
     * Created: 2018/08/29
     * Get price config 
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return config price
     *  
     ***************************************************************************
    */

    private function getConfigPrice($iGroupId = 0, $iParent_Id = 0) {

        $ConfigPrice = false;

        if ($iGroupId == BranchUser) {
            $this->checkConfigBranch();
            #Begin: Check config for discount for Affiliate 
            $userId = (int)$this->session->userdata('sessionUser');           
            $bran_rule = $this->branch_model->getConfig('*', 'bran_id = ' . $userId);
            if ($bran_rule) {
                $list_br = explode(",", $bran_rule->config_rule);
                if (isset($list_br) && in_array('49', $list_br)) {
                    $ConfigPrice = true;
                }
            }
            #End: Check config for discount       
        }

        if($iGroupId == StaffStoreUser) {
            $parent_group = $this->user_model->get("use_group", "use_id =" . $iParent_Id)->use_group;
            if($parent_group == BranchUser){
                $this->checkConfigBranch();
                #Begin: Check config for discount for Affiliate            
                $bran_rule = $this->branch_model->getConfig('*', 'bran_id = ' . $iParent_Id);
                if ($bran_rule) {
                    $list_br = explode(",", $bran_rule->config_rule);
                    if (isset($list_br) && in_array('49', $list_br)) {
                        $ConfigPrice = true;
                    }
                }
                #End: Check config for discount  
            }   
        }

        return $ConfigPrice;
    }

    /**
     ***************************************************************************
     * Created: 2018/11/13
     * Get List Product Preview
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getProPreview() {
        $page        = $this->input->post('page');
        $category_id = $this->input->post('category_id');
        $who_get     = $this->input->post('who_get');
        $pro_type    = $this->input->post('pro_type');
        $text_search = $this->input->post('text_search');
        $result = [
            'list_product'  => '',
            'list_category' => '',
        ];
        
        if ($category_id != -1) {
            $listcat = '';

            $category = $this->category_model->get("cat_id, cat_name, cat_level, parent_id, cate_type", "cat_id = " . (int) $category_id . " AND cat_status = 1");
            if (!empty($category)) {
                if ($who_get == 1) {
                    $listcat = (int) $category_id;
                } else if ($who_get == 2) {
                    $child_category = $this->category_model->fetch("cat_id, cat_name, cate_type, cat_image, cat_level", "cat_status = 1 AND  parent_id = " . (int)$category->cat_id . ' AND cate_type = ' . (int)$category->cate_type, 'cat_name', 'ASC');
                    if (count($child_category) > 0) {
                        foreach ($child_category as $key => $item) {
                            // get sub category
                            $catitemlv2 = $this->category_model->fetch("cat_id,cat_name, cate_type", "cat_status = 1 AND parent_id = " . (int)$item->cat_id . ' AND cate_type = ' . (int)$category->cate_type);
                            if (count($catitemlv2) > 0) {
                                $list_cate = $this->getChildCategory($catitemlv2, (int)$category->cate_type, $listcat);
                            } else {
                                if ($listcat == '') {
                                    $listcat .= $item->cat_id;
                                } else {
                                    $listcat .= ',' . $item->cat_id;
                                }
                            }
                        }
                    } else {
                        $listcat = (int)$category->cat_id;
                    }
                }
            }

            if ($listcat == '' ||  ( empty($this->session->userdata('sessionUser')) &&  $who_get == 1))
            {
                echo json_encode($result);die;
            }

            $where_product = 'pro_category IN (' . $listcat . ') AND pro_status = 1 AND pro_type = '.  $pro_type;  
        } else {
            $where_product = 'pro_status = 1 AND pro_type = '.  $pro_type;
        }
        
        // Kiểm tra trang hiện tại có bé hơn 1 hay không
        if ($page < 1) {
            $page = 1;
        }
        // Số record trên một trang
        $limit = 12;
        // Tìm start
        $start = ($limit * $page) - $limit;

        $select_product = "id, id as dp_id, pro_id, pro_name, pro_detail, pro_descr, pro_keyword, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_saleoff_value, pro_hondle, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, pro_type";
        $sort = "pro_id";
        $by = "DESC";

        
        if ($who_get == 1) {
            $where_product .= ' AND pro_user = ' . (int) $this->session->userdata('sessionUser');
        }

        if (trim($text_search) != '')
        {
            $where_product .= " AND pro_name LIKE '%".$this->filter->injection($text_search)."%'";
        }

        $list_user_product = $this->product_model->fetch_join($select_product . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where_product.' GROUP BY pro_id', $sort, $by, $start, $limit);

        $result['list_product'] = $this->load->view('home/product/ajax_html/items', array('list_user_product' => $list_user_product), TRUE);

        if ($who_get == 2) {
            $cat_pro_aff = 'SELECT DISTINCT(pro_category) FROM tbtt_product WHERE '. $where_product ;
            $get_data = $this->db->query($cat_pro_aff);
            $arrylist = $get_data->result();
            
            $listcat = '';
            if (!empty($arrylist)) {
                foreach ($arrylist as $key => $value) {
                    if ($listcat == '') {
                        $listcat .= $value->pro_category;
                    } else {
                        $listcat .= ',' . $value->pro_category;
                    }
                }
                $result['list_category'] = $this->category_model->fetch("cat_id, cat_name, cat_level, parent_id, cate_type", "cat_id IN (" . $listcat . ") AND cat_status = 1");
            }
        }

        echo json_encode($result);die;
    }


    /**
     ***************************************************************************
     * Created: 2018/11/13
     * Get List Product
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function getProChoose() {
        $af_key = '';
        $oUser = $this->user_model->get("use_id, parent_id,af_key", "use_id = ". $this->session->userdata('sessionUser'));
        if(isset($oUser->af_key)) {
            $af_key = $oUser->af_key;
        }
        $list = $this->input->post('product');
        $type = $this->input->post('type');
        $result = ['list_product'  => ''];
        if (!empty($list)) {
            $list_product = implode(", ",$list);
            $where_product = 'pro_id IN (' . $list_product . ') AND pro_status = 1';
            $select_product = "id, id as dp_id, pro_id, pro_name, pro_detail, pro_descr, pro_keyword, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_saleoff_value, pro_hondle, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, pro_type, pro_category, is_product_affiliate, begin_date_sale, end_date_sale";
            $sort = "pro_id";
            $by = "DESC";

            $list_user_product = $this->product_model->fetch_join($select_product . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where_product.' GROUP BY pro_id', $sort, $by);
            $x=1;
            $result['list_product'] = $this->load->view('home/product/ajax_html/items', array('list_product_choose' => $list_user_product, 'type_view' => $type, 'af_key' => $af_key), TRUE); 
        }
        echo json_encode($result);die;
    }





    /**
     ***************************************************************************
     * Created: 2018/11/20
     * Add Coupon
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: html
     *  
     ***************************************************************************
    */
    public function addCoupon($use_param) {
        
        $data = array();
        $this->load->model('category_model');

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
        {
            redirect(base_url() . "account", 'location');
            die();
        }

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            redirect(base_url() . "account", 'location');
            die();
        }

        if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14)
        {
            if($use_param == $this->session->userdata('sessionUser')){
                $user_id = (int)$this->session->userdata('sessionUser');
            }else{
                $is_bran = $this->user_model->get('*', 'use_status = 1 AND use_group = 14 AND use_id = '.(int)$use_param.' AND parent_id = '.(int)$this->session->userdata('sessionUser'));
                if(empty($is_bran))
                {
                    redirect(base_url(),'location');
                    die();
                }else{
                    $user_id = (int)$use_param;
                }
            }
        }else{
            redirect(base_url(),'location');
            die();
        }

        // get root category product (type 2);
        $data['category_root'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 0 and cate_type = 2 and parent_id = 0", "cat_name", "ASC");
        if (isset($data['category_root'])) {
            foreach ($data['category_root'] as $key => $item) {
                $cat_level_next = $this->category_model->fetch("*", "parent_id = ". (int)$item->cat_id ." AND cat_status = 1");
                $data['category_root'][$key]->child_count = count($cat_level_next);
            }
        }

        $data['products'] = $this->product_model->fetch("pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type", "pro_type IN (0,2) AND pro_status = 1 AND pro_user=" . $user_id, "pro_type", "ASC", null, null);
        $data['pro_type'] = 2;
        $data['text'] = 'phiếu mua hàng';
        $data['use_param'] = $use_param;
        $this->load->view('home/product/add_product', $data);
    }

    /**
     ***************************************************************************
     * Created: 2018/11/20
     * Add Product
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: html
     *  
     ***************************************************************************
    */
    public function addProduct($use_param) {

        $data = array();
        $this->load->model('category_model');

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
        {
            redirect(base_url() . "account", 'location');
            die();
        }

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            redirect(base_url() . "account", 'location');
            die();
        }

        if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14)
        {
            if($use_param == $this->session->userdata('sessionUser')){
                $user_id = (int)$this->session->userdata('sessionUser');
            }else{
                $is_bran = $this->user_model->get('*', 'use_status = 1 AND use_group = 14 AND use_id = '.(int)$use_param.' AND parent_id = '.(int)$this->session->userdata('sessionUser'));
                if(empty($is_bran))
                {
                    redirect(base_url(),'location');
                    die();
                }else{
                    $user_id = (int)$use_param;
                }
            }
        }else{
            redirect(base_url(),'location');
            die();
        }

        // get root category product (type 0);
        $data['category_root'] = $this->category_model->fetch("*", "cat_status = 1 and cat_level = 0 and cate_type = 0 and parent_id = 0", "cat_name", "ASC");
        if (isset($data['category_root'])) {
            foreach ($data['category_root'] as $key => $item) {
                $cat_level_next = $this->category_model->fetch("*", "parent_id = ". (int)$item->cat_id ." AND cat_status = 1");
                $data['category_root'][$key]->child_count = count($cat_level_next);
            }
        }

        $data['products'] = $this->product_model->fetch("pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type", "pro_type IN (0,2) AND pro_status = 1 AND pro_user=" . $user_id, "pro_type", "ASC", null, null);
        $data['pro_type'] = 0;
        $data['use_param'] = $use_param;
        $data['text'] = 'sản phẩm';
        $this->load->view('home/product/add_product', $data);
    }


    /**
     ***************************************************************************
     * Created: 2018/11/26
     * Add Product
     ***************************************************************************
     * @author: Thuan<thuanthuan0907@gmail.com>
     * @return: html
     *  
     ***************************************************************************
    */
    public function ajaxAddProduct() {
        $result = ['error' => true];

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
        {
            echo json_encode($result);
            die();
        }

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            echo json_encode($result);
            die();
        }

        if ($this->input->post('product')) {
            $use_param = $this->input->post('use_param');
            $data_post = $this->input->post('product');
            // dd($data_post);die;
            $this->load->model('user_model');
            $user_check = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . (int)$this->session->userdata('sessionUser'));

            if($group_id == StaffStoreUser) {
                $user = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . $user_check->parent_id);
                $pro_user       = $user_check->parent_id;
            } else {
                $user = $user_check;
                $pro_user = (int)$this->session->userdata('sessionUser');
                if($use_param != $this->session->userdata('sessionUser')){
                    $is_bran = $this->user_model->get('*', 'use_status = 1 AND use_group = 14 AND use_id = '.(int)$use_param.' AND parent_id = '.(int)$this->session->userdata('sessionUser'));
                    if(!empty($is_bran))
                    {
                        $pro_user = (int)$use_param;
                    }
                }
            }
            $pro_user_up = (int)$this->session->userdata('sessionUser');

            $this->load->model('shop_model');
            $get_pro_province = $this->shop_model->get("sho_province", "sho_user  = " . (int) $user->use_id);
            $pro_province = $get_pro_province->sho_province;

            $reliable = 0;
            if ((int)$this->session->userdata('sessionGroup') == 3) {
                $reliable = 1;
            }


            $af_amt = 0;
            $af_rate = 0;
            $af_dc_amt = 0;
            $af_dc_rate = 0;
            if ($data_post['product']['is_product_affiliate'] == 0) {
                $af_amt = 0;
                $af_rate = 0;
            } else {
                if ( $data_post['product']['pro_affiliate_type'] == 1) {
                    $af_amt = 0;
                    $af_rate = $data_post['product']['pro_affiliate_value'];
                } else {
                    $af_amt = $data_post['product']['pro_affiliate_value'];
                    $af_rate = 0;
                }
                if ($data_post['product']['pro_dc_affiliate_type'] == 1) {
                    $af_dc_amt = 0;
                    $af_dc_rate = $data_post['product']['pro_dc_affiliate_value'];
                } else {
                    $af_dc_amt = $data_post['product']['pro_dc_affiliate_value'];
                    $af_dc_rate = 0;
                }
            }
            $pathImage = "media/images/product/";
            $dir_image = date('dmY');
            $image = 'none.gif';
            if (!empty($data_post['product']['pro_image'])) {
                $image_upload = array(); 
                foreach ($data_post['product']['pro_image'] as $key => $value) {
                    $image_upload[] = $this->add_photo_qc($value, $dir_image);
                }

                if (count($image_upload) > 0) {
                    $image = implode(',', $image_upload);
                }
            }
            if ($image == 'none.gif') {
                $dir_image = 'default';
            }

            // @@
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));


            $dataPost = array(
                    'pro_name' => trim($data_post['product']['pro_name']), // done
                    'pro_sku' => trim($data_post['product']['pro_sku']), // done
                    'pro_descr' => trim($data_post['product']['pro_descr']), // done
                    'pro_keyword' => trim($data_post['product']['pro_keyword']), // done
                    'pro_cost' => (int) $data_post['product']['pro_cost'], // done
                    'pro_currency' => trim(strtoupper($data_post['product']['pro_currency'])), // done
                    'pro_hondle' => (int) $data_post['product']['pro_hondle'], // done giá thương lượng
                    'pro_province' => (int) $pro_province,
                    'pro_category' => (int) $data_post['product']['pro_category'], // done
                    'pro_begindate' => $currentDate,
                    'pro_enddate' => $currentDate, // default time 
                    'pro_detail' => trim($data_post['product']['pro_detail']), // done
                    'pro_image' => $image,
                    'pro_dir' => $dir_image,
                    'pro_user' => $pro_user, // done
                    'pro_post_by' => 'web',  // done
                    'pro_user_up' => (isset($pro_user_up)) ? $pro_user_up : 0, // done
                    'pro_poster' => trim($user->use_fullname), // done
                    'pro_address' => trim($user->use_address), // done
                    'pro_phone' => trim($user->use_phone), // done
                    'pro_mobile' => trim($user->use_mobile), // done
                    'pro_email' => trim($user->use_email), // done
                    'pro_yahoo' => trim($user->use_yahoo), // done
                    'pro_skype' => trim($user->use_skype), // done
                    'pro_status' => 1, // done gian hang va nhan vien cua gian hang = 1
                    'pro_view' => 0, // done
                    'pro_buy' => 0,  // done
                    'pro_comment' => 0, // done
                    'pro_vote_cost' => 0, // done
                    'pro_vote_quanlity' => 0, // done
                    'pro_vote_model' => 0, // done
                    'pro_vote_service' => 0, // done
                    'pro_vote_total' => 0, // done
                    'pro_vote' => 0, // done
                    'pro_reliable' => $reliable, // done
                    'pro_saleoff' => (int)$data_post['product']['pro_saleoff'], // done
                    'pro_saleoff_value' => ($data_post['product']['pro_saleoff_value'] != '') ? $data_post['product']['pro_saleoff_value'] : 0, // done
                    'pro_type_saleoff' => (int)$data_post['product']['pro_saleoff_type'], // done
                    'begin_date_sale' => strtotime($data_post['product']['begin_date_sale']), // done
                    'end_date_sale' => strtotime($data_post['product']['end_date_sale']), // done
                    'pro_hot' => (int)$data_post['product']['pro_hot'], // done
                    'is_product_affiliate' => (int) $data_post['product']['is_product_affiliate'], // done
                    'af_amt' => $af_amt,
                    'af_rate' => $af_rate,
                    'af_dc_amt' => $af_dc_amt,
                    'af_dc_rate' => $af_dc_rate,
                    'pro_show' => 0, // done
                    'pro_manufacturer_id' => -1, // done
                    'pro_manufacturer' => trim($data_post['product']['pro_mannufacurer']), // done
                    'pro_instock' => (int) $data_post['product']['pro_instock'], // done
                    'pro_unit' => trim($data_post['product']['pro_unit']), // done
                    'pro_weight' => (int) $data_post['product']['pro_weight'], // done
                    'pro_length' => 0,  // done
                    'pro_width' => 0,   // done
                    'pro_height' =>  0, // done
                    'pro_minsale' => (int)$data_post['product']['pro_minsale'], // done
                    'pro_vat' => (int)$data_post['product']['pro_vat'], // done
                    'pro_quality' => (int) $data_post['product']['pro_quality'], // done
                    'pro_made_from' => (int) $data_post['product']['pro_made_from'], // done
                    'pro_warranty_period' => (int) $data_post['product']['pro_warranty_period'],
                    'pro_video' => trim($data_post['product']['pro_video']), // done
                    'created_date' => date("Y-m-d"), // done
                    'pro_type' => (int) $data_post['product']['pro_type'], // done
                    'pro_brand' => trim($data_post['product']['pro_brand']), // done
                    'pro_protection'    => (int) $data_post['product']['pro_protection'], // done
                    'pro_specification' => !empty($data_post['product']['pro_specification']) ? json_encode($data_post['product']['pro_specification']) : null, // done
                    'pro_attach'        => !empty($data_post['product']['pro_attach']) ? json_encode($data_post['product']['pro_attach']) : null, // done
                    'pro_made_in'       => trim($data_post['product']['pro_made_in']), // done
                );


            if ($id = $this->product_model->add($dataPost)) {
                
                $pro_id = (int) mysql_insert_id();

                // Add gallery 
                $this->load->model('cate_galleries_model');
                $this->load->model('galleries_model');

                if (!empty($data_post['pro_gallegy'])) {
                    foreach ($data_post['pro_gallegy'] as $k_gallegy => $v_gallegy) {
                        if ($v_gallegy['hidden'] == 'false') {                            
                            $dataInsert = array(
                                'user_id' => $pro_user,
                                'pro_id'  => $pro_id,
                                'name'    => $v_gallegy['content']
                            );
                            $id_insert = $this->cate_galleries_model->add($dataInsert);

                            if ($id_insert > 0 && !empty($v_gallegy['list_pro']))
                            {
                                foreach ($v_gallegy['list_pro'] as $k_list_pro => $v_list_pro)
                                {

                                    if ($v_list_pro['delete'] == 'false') {

                                        $this->galleries_model->update(array('gallery_id' => $id_insert, 'pro_id' => $pro_id, 'caption' => $v_list_pro['caption']), "id = " . $v_list_pro['id']);
                                    }
                                    
                                }
                            }
                        }
                    }
                }
                // Add promotion                       
                $promotions = array();
                if (!empty($data_post['pro_promotion']['promotion_list']) && (int) $data_post['pro_promotion']['limit_type'] == 1) {
                    // $limit_type = (int) $data_post['pro_promotion']['limit_type'];
                    foreach ($data_post['pro_promotion']['promotion_list'] as $row) {
                        $promotion = array();
                        $promotion['limit_from'] = $row['limit_from'];
                        $promotion['limit_to'] = $row['limit_to'];
                        $promotion['limit_type'] = 1;
                        if ($row['type'] == 1) {
                            $promotion['dc_amt'] = $row['amount'];
                            $promotion['dc_rate'] = 0;
                        } else {
                            $promotion['dc_rate'] = $row['amount'];
                            $promotion['dc_amt'] = 0;
                        }
                        $promotion['pro_id'] = $id;
                        array_push($promotions, $promotion);
                    }
                    $this->product_promotion_model->add($promotions);
                }

                if (!empty($data_post['pro_promotion']['promotion_price']) && (int) $data_post['pro_promotion']['limit_type'] == 2) {
                    // $limit_type = (int) $data_post['pro_promotion']['limit_type'];
                    foreach ($data_post['pro_promotion']['promotion_price'] as $row) {
                        $promotion = array();
                        $promotion['limit_from'] = $row['limit_from'];
                        $promotion['limit_to'] = $row['limit_to'];
                        $promotion['limit_type'] = 2;
                        if ($row['type'] == 1) {
                            $promotion['dc_amt'] = $row['amount'];
                            $promotion['dc_rate'] = 0;
                        } else {
                            $promotion['dc_rate'] = $row['amount'];
                            $promotion['dc_amt'] = 0;
                        }
                        $promotion['pro_id'] = $id;
                        array_push($promotions, $promotion);
                    }
                    $this->product_promotion_model->add($promotions);
                }
                //Lưu trữ trường quy cách                       
                $standards = array();
                if (!empty($data_post['pro_qc'])) {

                    foreach ($data_post['pro_qc'] as $key => $rowqc) {
                       
                        if ($rowqc['dp_cost'] != '' && $rowqc['dp_instock'] != '' && ($rowqc['dp_size'] != '' || $rowqc['dp_color'] != '' || $rowqc['dp_material'] != '')) {
                            $standard = array();
                            $standard['dp_pro_id'] = $id;
                            $standard['dp_size'] = $rowqc['dp_size'];
                            $standard['dp_color'] = $rowqc['dp_color'];
                            $standard['dp_material'] = $rowqc['dp_material'];
                            $standard['dp_cost'] = $rowqc['dp_cost'];
                            $standard['dp_instock'] = $rowqc['dp_instock'];
                            $standard['dp_createdate'] = date('Y-m-d');
                            $standard['dp_weight'] = !empty($rowqc['dp_weight']) ? $rowqc['dp_weight'] : null;
                            $standard['dp_images'] = $this->add_photo_qc($rowqc['dp_image'], $dir_image);
                            array_push($standards, $standard);

                            $this->detail_product_model->add($standard);
                        }
                        $t++;
                    }

                    if ($standards && $this->session->userdata('image_name_qc')) {
                        $this->session->unset_userdata('image_name_qc');
                    }
                }


                // get list user and add affiliate
                $list_user_affiliate = $this->user_model->get_list_user("use_id", "parent_id = " . (int)$pro_user.' OR parent_shop = ' .(int)$pro_user );

                if (!empty($list_user_affiliate)) 
                {
                    $this->load->model('product_affiliate_user_model');
                    $dataAffiliate = array();
                    foreach ($list_user_affiliate as $key => $value) {
                        $dataAffiliate[] = array('use_id' => $value->use_id, 'pro_id' => $pro_id, 'homepage' => 1, 'date_added' => time(), 'kind_of_aff' => 1);
                    }
                    if (!empty($dataAffiliate)) {
                        $this->product_affiliate_user_model->add_all($dataAffiliate);
                    }
                }


                $result = ['error' => false];
                //create or update view on azibai-ecommerce
                // $this->createViewProduct();
            }
            
        }

        echo json_encode($result);
        die();

    }


    function add_photo_qc($baseImg , $dir_image = '')
    {
        
        $pathImage = "media/images/product/";

        if ($dir_image == '') {
            $dir_image = $this->session->userdata('sessionUsername');
        }

        if(!is_dir($pathImage.$dir_image))
        {
            @mkdir($pathImage.$dir_image);
            $this->load->helper('file');
            @write_file($pathImage.$dir_image.'/index.html', '<p>Directory access is forbidden.</p>');
        }

        $path = $pathImage.$dir_image .'/';

        $name_image = uniqid().time().uniqid();
        $type_image = $this->convertStringToImageFtp($name_image, $path, $baseImg);
        
        $img = $name_image.'.'.$type_image;
        $src = $pathImage . $dir_image . '/' . $img;
        #BEGIN: Create thumbnail
        $this->load->library('image_lib');
        if (file_exists($pathImage . $dir_image . '/' . $img)) {
            for ($j = 1; $j <= 3; $j++) {
                switch ($j) {
                    case 1:
                        $maxWidth = 150;#px
                        $maxHeight = 150;#px
                        break;
                    case 3:
                        $maxWidth = 600;#px
                        $maxHeight = 600;#px
                        break;
                    default:
                        $maxWidth = 300;#px
                        $maxHeight = 300;#px
                }

                $sizeImage = size_thumbnail($src, $maxWidth, $maxHeight);
                $configImage['source_image'] = $pathImage . $dir_image . '/' . $img;
                $configImage['new_image'] = $pathImage . $dir_image . '/thumbnail_' . $j . '_' . $img;
                $configImage['maintain_ratio'] = TRUE;
                $configImage['width'] = $sizeImage['width'];
                $configImage['height'] = $sizeImage['height'];
                $this->image_lib->initialize($configImage);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }
        }
        #END Create thumbnail 
        // Upload to other server cloud
        $img_thum = '';
        if(file_exists($pathImage . $dir_image .'/'. $img) 
            && file_exists($pathImage . $dir_image .'/thumbnail_1_'. $img)        
            && file_exists($pathImage . $dir_image .'/thumbnail_2_'. $img)
            && file_exists($pathImage . $dir_image .'/thumbnail_3_'. $img)
        ){
            $this->load->library('ftp');

            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = FALSE;
            $this->ftp->connect($config);

            $path = '/public_html/media/images/product';
            $tmp_path = $pathImage . $dir_image . '/' . $img;
            $tmp_path_1 = $pathImage . $dir_image . '/thumbnail_1_' . $img;
            $tmp_path_2 = $pathImage . $dir_image . '/thumbnail_2_' . $img;
            $tmp_path_3 = $pathImage . $dir_image . '/thumbnail_3_' . $img;
            $ldir = array();
            $ldir = $this->ftp->list_files($path);
           
            // if $my_dir name exists in array returned by nlist in current '.' dir
            if (! in_array($dir_image, $ldir)) {                    
                $this->ftp->mkdir($path .'/'. $dir_image, 0775);
            }

            if($this->ftp->upload($tmp_path, $path .'/'. $dir_image .'/'. $img, 'auto', 0775) 
                && $this->ftp->upload($tmp_path_1, $path .'/'. $dir_image .'/thumbnail_1_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_2, $path .'/'. $dir_image .'/thumbnail_2_'. $img, 'auto', 0775)
                && $this->ftp->upload($tmp_path_3, $path .'/'. $dir_image .'/thumbnail_3_'. $img, 'auto', 0775)
            ){
                $img_thum = DOMAIN_CLOUDSERVER .'media/images/product/'. $dir_image .'/thumbnail_1_'. $img;
                if (file_exists('media/images/product/' . $dir_image . '/index.html')) {
                    @unlink('media/images/product/' . $dir_image . '/index.html');
                }
                array_map('unlink', glob('media/images/product/'. $dir_image .'/*'));
                @rmdir('media/images/product/' . $dir_image);
            } 

            $this->ftp->close(); 

        }
        return $img;
    }

    public function detail_product($productID)
    {
        
        #BEGIN: kiểm tra product by $productID
        $product = $this->product_model->get("* , (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int)$productID . " AND pro_status = 1 ");
        
        if ($product && $product->pro_id <= 0) {
            redirect($this->subURL, 'location');
            die();
        }
        if (count($product) > 0) {
            $user_product = $this->user_model->get("*", "use_id = " . $product->pro_user);
        }

        if ($product->pro_user == "") {
            redirect(base_url(), 'location');
        }

        $data['user_product'] = $user_product->use_username;
        #END kiểm tra product by $productID

        /*if (!$this->session->userdata('sessionViewProduct_' . $productIDQuery)) {
            $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = " . $productIDQuery);
            $this->session->set_userdata('sessionViewProduct_' . $productIDQuery, 1);

            //dem so luong click link cho af            
            if (isset($_REQUEST['share'])) {
                $shareId = $_REQUEST['share'];
            } elseif (isset($_REQUEST['af_id'])) {
                $shareId = $_REQUEST['af_id'];
            } else {
                $shareId = '';
            }

            if ($shareId != '' && count($ip_exit) == 0 && $user_login->af_key != $shareId) {
                $this->load->model('share_model');
                $this->share_model->counter(array('link' => uri_string(), 'share_id' => $shareId, 'content_id' => $productID, 'content_title' => $product->pro_name, 'content_type' => '01'));
                //them bang af share
                $this->add_view_af_share($productID);
            }
        }*/
        $this->product_model->update(array('pro_view' => (int)$product->pro_view + 1), "pro_id = " . $productID);
        
        //danh mục sản phẩm
        $categoryID = $product->pro_category;
        $select_cat = "cat_id, cat_name,cat_level, parent_id";
        $category = $this->category_model->get($select_cat, "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }
        $getcat = array();
        if(!empty($category)){
            $getcat[] = $category->cat_id.':'.$category->cat_name;
            switch ($category->cat_level) {
                case '4':
                    $cat1 = $this->category_model->fetch($select_cat, "cat_id = " . $category->parent_id);
                    if(!empty($cat1)){
                        foreach ($cat1 as $key1 => $item1){
                            $getcat[] = $item1->cat_id.':'.$item1->cat_name;
                            $cat2 = $this->category_model->fetch($select_cat, "cat_id = " . $item1->parent_id);
                            if(!empty($cat2)){
                                foreach ($cat2 as $key2 => $item2){
                                    $getcat[] = $item2->cat_id.':'.$item2->cat_name;
                                    $cat3 = $this->category_model->fetch($select_cat, "cat_id = " . $item2->parent_id);
                                    if(!empty($cat3)){
                                        foreach ($cat3 as $key3 => $item3){
                                            $getcat[] = $item3->cat_id.':'.$item3->cat_name;
                                            $cat4 = $this->category_model->fetch($select_cat, "cat_id = " . $item3->parent_id);
                                            if(!empty($cat4)){
                                                foreach ($cat4 as $key4 => $item4){
                                                    $getcat[] = $item4->cat_id.':'.$item4->cat_name;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                case '3':
                    $cat2 = $this->category_model->fetch($select_cat, "cat_id = " . $category->parent_id);
                    if(!empty($cat2)){
                        foreach ($cat2 as $key2 => $item2){
                            $getcat[] = $item2->cat_id.':'.$item2->cat_name;
                            $cat3 = $this->category_model->fetch($select_cat, "cat_id = " . $item2->parent_id);
                            if(!empty($cat3)){
                                foreach ($cat3 as $key3 => $item3){
                                    $getcat[] = $item3->cat_id.':'.$item3->cat_name;
                                    $cat4 = $this->category_model->fetch($select_cat, "cat_id = " . $item3->parent_id);
                                    if(!empty($cat4)){
                                        foreach ($cat4 as $key4 => $item4){
                                            $getcat[] = $item4->cat_id.':'.$item4->cat_name;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                case '2':
                    $cat3 = $this->category_model->fetch($select_cat, "cat_id = " . $category->parent_id);
                    if(!empty($cat3)){
                        foreach ($cat3 as $key3 => $item3){
                            $getcat[] = $item3->cat_id.':'.$item3->cat_name;
                            $cat4 = $this->category_model->fetch($select_cat, "cat_id = " . $item3->parent_id);
                            if(!empty($cat4)){
                                foreach ($cat4 as $key4 => $item4){
                                    $getcat[] = $item4->cat_id.':'.$item4->cat_name;
                                }
                            }
                        }
                    }
                    break;
                case '1':
                    $cat4 = $this->category_model->fetch($select_cat, "cat_id = " . $category->parent_id);
                    if(!empty($cat4)){
                        foreach ($cat4 as $key4 => $item4){
                            $getcat[] = $item4->cat_id.':'.$item4->cat_name;
                        }
                    }
                    break;
                case '0':
                    $getcat[] = $category->cat_id.':'.$category->cat_name;
                    break;
            }
        }
        // dd($category);die;
        //end danh mục sản phảm

        //Check exist Truong Qui Cach of product, by Bao Tran
        $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$productID);
        
        if ($list_style) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, T2.dp_instock AS pro_instock, dp_images" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . (int)$productID . " AND pro_status = 1", (int)$productID);
        }

        $list_style = array_reverse($list_style);
        if ($list_style && count($list_style) > 0) {
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

            $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$productID . $dp_color);
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
            $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$productID . $dp_color . $dp_size);
            if ($li_material) {
                foreach ($li_material as $km => $vm) {
                    $material_arr[] = $vm->dp_material;
                }
                $data['ar_material'] = array_unique($material_arr);
            }

            $arr_dp_image = array();
            $arr_dp = array();
            $arr_dp_txt = array();
            $arr_dp_id = array();
            foreach ($list_style as $key => $value) {
                if($value->dp_images != ''){
                    array_push($arr_dp_image, $value->dp_images);
                    // array_push($arr_dp_id, $value->id);
                    // $arr_dp[$key]['images'] = $value->dp_images;
                    $arr_dp[$key]['id'] = $value->id;
                    if($value->dp_color != ''){
                        $arr_dp[$key]['type'] = 'tqc1';
                        $arr_dp[$key]['color'] = $value->dp_color;
                        // array_push($arr_dp, 'tqc1');
                        // array_push($arr_dp_txt, $value->dp_material);
                    }
                    if($value->dp_size != ''){
                        $arr_dp[$key]['type'] = 'tqc2';
                        $arr_dp[$key]['size'] = $value->dp_size;
                        // array_push($arr_dp, 'tqc2');
                        // array_push($arr_dp_txt, $value->dp_material);
                    }else{
                        
                    }
                    if($value->dp_material != ''){
                        $arr_dp[$key]['type'] = 'tqc3';
                        $arr_dp[$key]['material'] = $value->dp_material;
                        // array_push($arr_dp, 'tqc3');
                        // array_push($arr_dp_txt, $value->dp_material);
                    }else{
                        
                    }
                }
            }
            $data['arr_dp_id'] = $arr_dp_id;
            $data['arr_dp'] = $arr_dp;
            $data['arr_dp_txt'] = $arr_dp_txt;
            $data['arr_dp_image'] = $arr_dp_image;
        }
        // dd($product);die;

        //Dem like
        $this->load->model('like_product_model');
        //active user like
        if($this->session->userdata('sessionUser')){
            $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $product->pro_id]);
            $product->is_like = count($is_like);
        }
        //get total like
        $list_likes = $this->like_product_model->get('id', ['pro_id' => (int) $product->pro_id]);
        $product->likes = count($list_likes);

        if ($this->session->userdata('sessionUser')) {
            $this->load->model('product_affiliate_user_model');
            $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $product->pro_id));
            if ($selected_sale) {
                $data['selected_sale'] = $selected_sale;
            }
        }
        
        $shop = $this->shop_model->get("*", "sho_user = " . (int)$product->pro_user);
        $_province = $this->province_model->get('pre_name', 'pre_id = "' . $shop->sho_province . '"');
        $_district = $this->district_model->find_by(array("DistrictCode" => $shop->sho_district, 'pre_status' => 1), 'DistrictName');
        $shop->province_name = $_province->pre_name;
        $shop->district_name = $_district[0]->DistrictName;

        //product attached
        $product_attached = false;
        if($product->pro_attach != 'null' && $product->pro_attach != null) {
            $list_pro = json_decode($product->pro_attach);
            if (!empty($list_pro)) 
            {
                $list_pro = implode(",", $list_pro);
                $product_attached = $this->product_model->fetch('pro_id, pro_name, pro_cost, pro_image, pro_dir, pro_saleoff, pro_type_saleoff, pro_saleoff_value','pro_id IN (' . $list_pro . ')');
            }
        }
        

        $data['shop'] = $shop;
        $data['product'] = $product;
        $data['category'] = $getcat;
        $data['product_attached'] = $product_attached;
        if($product->id > 0) {
            $data['product_check_TQC'] = $this->detail_product_model->get('*','id = '.$product->id);
            // dd($data['product_check_TQC']);die;
        }

        if ($product->pro_user != $this->session->userdata('sessionUser')) {
            $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));
        }
        
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
        
        $this->load->model('reports_model');
        $this->load->model('report_detail_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rpd_id', 'asc');
        $data['listreports'] = $listreports;
        $is_report = $this->report_detail_model->get('rpd_reportid', 'rpd_by_user = '.(int)$this->session->userdata('sessionUser').' AND rpd_product = '.$productID);
        $data['is_report'] = $is_report;
        
        #Fetch record
        $this->load->model('product_affiliate_user_model');
        $selected_sale_arr = '';
        //$limit = settingProductUser;
        $proshop = $this->product_model->fetch_join('*, count(tbtt_detail_product.dp_pro_id) as have_num_tqc, (af_rate) as aff_rate' . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_detail_product.dp_pro_id = tbtt_product.pro_id", "pro_user = " . (int)$product->pro_user . " AND pro_id != " . (int)$product->pro_id . " AND pro_status = 1 AND sho_status = 1", 'pro_id', 'DESC', 0, 15, '', 'pro_id');
        if($this->session->userdata('sessionUser') && count($proshop) > 0){
            foreach ($proshop as $key => $value) {
                $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                $value->is_like = count($is_like);

                $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $value->pro_id));
                if (!empty($selected_sale)) {
                    $selected_sale_arr[$value->pro_id] = $value->pro_id;
                }
            }
        }
        $data['productShop'] = $proshop;
        #END Relate user
        #BEGIN: Relate category
        $procat = $this->product_model->fetch_join('*, count(tbtt_detail_product.dp_pro_id) as have_num_tqc, (af_rate) as aff_rate' . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT", "tbtt_detail_product", "tbtt_detail_product.dp_pro_id = tbtt_product.pro_id", "pro_category = " . (int)$product->pro_category . " AND pro_id != " . (int)$product->pro_id . " and pro_status = 1 AND sho_status = 1 ", 'pro_id', 'DESC', 0, 15, '', 'pro_id');
        if($this->session->userdata('sessionUser') && count($procat) > 0){
            foreach ($procat as $key => $value) {
                $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                $value->is_like = count($is_like);

                $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $value->pro_id));
                if (!empty($selected_sale)) {
                    $selected_sale_arr[$value->pro_id] = $value->pro_id;
                }
            }
        }

        $data['selected_sale_arr'] = $selected_sale_arr;
        
        $af_key = $af_id = '';
        $currentuser = $this->user_model->get("af_key", "use_id = '" . $this->session->userdata('sessionUser') . "'");
        if(count($currentuser) > 0 && $currentuser->af_key != ''){
            $af_id = $currentuser->af_key;
            $af_key = '?af_id='.$currentuser->af_key;
        }else{
            if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
                $af_id = $_REQUEST['af_id'];
                $af_key = '?af_id='.$_REQUEST['af_id'];
            }
        }

        $data['af_id'] = $af_id;
        $data['af_key'] = $af_key;

        $check_http = explode(':', explode(',',$product->pro_image)[0])[0];
        if($check_http == 'http' || $check_http == 'https'){
            $ogimage = explode(',',$product->pro_image)[0];
        }else{
            $ogimage = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . explode(',',$product->pro_image)[0];
        }
        
        $this->load->model('share_metatag_model');
        if($product->pro_type == 0){
            $type_share = TYPESHARE_DETAIL_PRODUCT;
        }else{
            $type_share = TYPESHARE_DETAIL_COUPON;
        }
        
        $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$product->pro_user.' AND type = '.$type_share . ' AND item_id = '.$product->pro_id);
        if(!empty($get_avtShare)){
            $ogimage = $get_avtShare[0]->image;
        }
        $data['type_share'] = $type_share;
        $data['ogimage'] = $ogimage;
        
        $data['categoryProduct'] = $procat;
        $data['ogurl'] = azibai_url().'/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af_key;
        $data['ogtype'] = 'website';
        $data['ogtitle'] = $product->pro_name;
        $data['ogdescription'] = $product->pro_descr;
        $data['share_id'] = $product->pro_id;
        $data['share_url'] = azibai_url().'/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af_key;
        $data['share_name'] = $product->pro_name;
        
        $this->load->model('cate_galleries_model');
        $data['cate_galleries'] = $this->cate_galleries_model->get("*", "pro_id = " . $productID );
        $this->load->view('home/product/detail_product', $data);
    }

    public function getTQC()
    {
        $receive = $_POST['data'];
        $receive = json_decode($receive);
        $where = '';
        if($receive->tqc == 1) {
            $where = 'dp_color = "'.$receive->text.'"';
            if($receive->text_size != ''){
                $where .= ' AND dp_size = "'.$receive->text_size.'"';
            }
            if($receive->txt_material != ''){
                $where .= ' AND dp_material = "'.$receive->txt_material.'"';
            }
        }else{
            if($receive->tqc == 2) {
                $where = 'dp_size = "'.$receive->text.'"';
                if($receive->text_color != ''){
                    $where .= ' AND dp_color = "'.$receive->text_color.'"';
                }
                if($receive->txt_material != ''){
                    $where .= ' AND dp_material = "'.$receive->txt_material.'"';
                }
            }else{
                $where = 'dp_material = "'.$receive->text.'"';
                if($receive->text_color != ''){
                    $where .= ' AND dp_color = "'.$receive->text_color.'"';
                }
                if($receive->text_size != ''){
                    $where .= ' AND dp_size = "'.$receive->text_size.'"';
                }
            }
        }

        $tqc_select = $this->detail_product_model->get('*', 'dp_pro_id = '.$receive->pro_id.' AND '.$where);
        //old of ATai /*' AND (dp_size = "'.$receive->text.'" OR dp_color = "'.$receive->text.'" OR dp_material = "'.$receive->text.'")'*/
        $arr = array();
        if($receive->tqc == 1) {
            $list_style = $this->detail_product_model->fetch('*', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_color = "'.$tqc_select->dp_color.'"');
            $temp_material = array();
            foreach ($list_style as $k => $v) {
                $temp = array();
                if ($v->dp_color != '') {
                    $temp['dp_color'] = $v->dp_color;
                }
                if ($v->dp_size != '') {
                    $temp['size'] = $v->dp_size;
                }
                if ($v->dp_material != '') {
                    $temp['material'] = $v->dp_material;
                    array_push($temp_material,$v->dp_material);
                }
                if( count($arr) == 0 ){
                    $arr = array($temp);
                }else{
                    array_push($arr,$temp);
                }
            }
            foreach ($arr as $key => $value) {
                if($value['dp_color'] == $tqc_select->dp_color && $value['size'] == $tqc_select->dp_size) {
                    $material = $this->detail_product_model->fetch('dp_material', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_color = "'.$value['dp_color'].'" AND dp_size = "'.$value['size'].'"');
                    break;
                }
            }
            // if($arr[0]['dp_color'] != ''){
            //     $material = $this->detail_product_model->fetch('dp_material', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_color = "'.$arr[0]['dp_color'].'" AND dp_size = "'.$arr[0]['size'].'"');
            // } else {
            //     $material = $this->detail_product_model->fetch('dp_material', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_size = "'.$arr[0]['size'].'"');
            // }
            if(count($material)>0){
                foreach ($material as $key => $value) {
                    $material[$key] = $value->dp_material;
                }
                $arr['material'] = $material;
            }
            
        }
        if($receive->tqc == 2) {
            $list_style = $this->detail_product_model->fetch('*', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_size = "'.$tqc_select->dp_size.'" AND dp_color = "'.$receive->text_color.'"');
            foreach ($list_style as $k => $v) {
                $temp = array();
                if ($v->dp_size != '') {
                    $temp['size'] = $v->dp_size;
                }
                if ($v->dp_material != '') {
                    $temp['material'] = $v->dp_material;
                }
                
                if( count($arr) == 0 ){
                    $arr = array($temp);
                }else{
                    array_push($arr,$temp);
                }
            }
        }

        if($receive->tqc == 3) {
            $list_style = $this->detail_product_model->fetch('*', 'dp_pro_id = ' .$receive->pro_id . ' AND dp_material = "'.$tqc_select->dp_material.'" AND id = '.(int)$tqc_select->id);
            foreach ($list_style as $k => $v) {
                $temp = array();
                if ($v->dp_material != '') {
                    $temp['material'] = $v->dp_material;
                }
                if( count($arr) == 0 ){
                    $arr = array($temp);
                }else{
                    array_push($arr,$temp);
                }
            }
        }
        $array = array('tqc_select'=>$tqc_select, 'arr'=>$arr, 're' => $receive);
        echo json_encode($array);die;
    }


    public function ajaxAddGallegy() {
        $result = ['error' => true, 'list_data' => array()];

        $list_data = array();
        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
        {
            echo json_encode($result);
            die();
        }

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            echo json_encode($result);
            die();
        }

        if (!empty($_FILES)) {
            $data_post = $_FILES;
            
            $this->load->model('user_model');
            $user_check = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . (int)$this->session->userdata('sessionUser'));

            if($group_id == StaffStoreUser) {
                $user = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . $user_check->parent_id);
                $pro_user       = $user_check->parent_id;
                $pro_user_up    = $this->session->userdata('sessionUser');
            } else {
                $user = $user_check;
                $pro_user = (int)$this->session->userdata('sessionUser');
            }

            $this->load->library('upload');
            $this->load->library('image_lib');
            $pathUpload = "media/images/gallery/";
            $dirUpload = date('dmY');
            if (!is_dir($pathUpload . $dirUpload)) {
                @mkdir($pathUpload . $dirUpload, 0777, true);
                $this->load->helper('file');
                @write_file($pathUpload . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
            }

            $configUpload['upload_path'] = $pathUpload . $dirUpload . '/';
            $configUpload['allowed_types'] = 'gif|jpg|jpeg|png';
            $configUpload['encrypt_name'] = true;
            $configUpload['max_size'] = '10240';
            $this->upload->initialize($configUpload);


            $this->load->library('ftp');
            $config['hostname'] = IP_CLOUDSERVER;
            $config['username'] = USER_CLOUDSERVER;
            $config['password'] = PASS_CLOUDSERVER;
            $config['port']     = PORT_CLOUDSERVER;                
            $config['debug']    = FALSE;

            $pathFpt = '/public_html/media/images/galleries/';
            $this->ftp->connect($config);
            if (! in_array($pathFpt, $dirUpload)) {                    
                $this->ftp->mkdir($pathFpt . $dirUpload, 0775);
            }

            $this->load->model('galleries_model');
            foreach ($data_post as $key => $value) {
                if ($this->upload->do_upload($key)) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $tmp_path = $pathUpload . $dirUpload .'/'. $uploadData['file_name'];
                        $ftp_path = $pathFpt . $dirUpload .'/'. $uploadData['file_name'];
                        if($this->ftp->upload($tmp_path, $ftp_path, 'auto', 0775)){
                            @unlink($tmp_path);
                            $dataInsert = array(
                                'user_id' => $pro_user,
                                'link'    => $uploadData['file_name'],
                                'img_dir' => $dirUpload,
                                'detail_w'=> $uploadData['image_width'],
                                'detail_h'=> $uploadData['image_height'],
                                'detail_type'=> $uploadData['file_type']
                            );

                            $id_insert = $this->galleries_model->add($dataInsert);

                            if ($id_insert > 0) {
                                $list_data[] = array(
                                    'id'        => $id_insert,
                                    'link'      => DOMAIN_CLOUDSERVER . 'media/images/galleries/' . $dirUpload . '/'. $uploadData['file_name'],
                                    'detail_w'  =>$uploadData['image_width'],
                                    'detail_h'  => $uploadData['image_height'],
                                    'delete'    => false,
                                    'caption'   => '' 
                                ); 
                            }
                        }
                    }
                }
            }
            $this->ftp->close();

            if (!empty($list_data)) {
                $result = ['error' => false, 'list_data' => $list_data];
            }
        }

        echo json_encode($result);
        die();
    }


    public function gallegy($productID) {

        $product = $this->product_model->get("* , (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int)$productID . " AND pro_status = 1 ");
        if ($product && $product->pro_id <= 0) {
            redirect($this->subURL, 'location');
            die();
        }
        if (count($product) > 0) {
            $user_product = $this->user_model->get("*", "use_id = " . $product->pro_user);
        }

        if ($product->pro_user == "") {
            redirect(base_url(), 'location');
        }
        $af_key = '';
        $currentuser = $this->user_model->get("af_key", "use_id = '" . $this->session->userdata('sessionUser') . "'");
        if(count($currentuser) > 0 && $currentuser->af_key != ''){
            $af_key = '?af_id='.$currentuser->af_key;
        }else{
            if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
                $af_key = '?af_id='.$_REQUEST['af_id'];
            }
        }
        $categoryID = $product->pro_category;
        $category = $this->category_model->get("cat_id, cat_name", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }

        $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$productID);
        
        if ($list_style) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . (int)$productID . " AND pro_status = 1", (int)$productID);
        }

        $this->load->model('cate_galleries_model');
        $this->load->model('galleries_model');

        $cate_galleries = $this->cate_galleries_model->get("*", "pro_id = " . $productID );

        $data = array(
           'product' => $product,
           'galleries' => []
        );
        if (!empty($cate_galleries)) {
            foreach ($cate_galleries as $key => $value) {
                $data['galleries'][$key]['name'] = $value->name;
                $data['galleries'][$key]['detail'] = [];
                $gallery_detail = $this->galleries_model->get("*", "gallery_id = " . $value->id . " AND pro_id = " . $productID);
                if (!empty($cate_galleries)) {
                    $data['galleries'][$key]['detail'] = $gallery_detail;
                }

            }
        }
        $getshop = $this->shop_model->get('*','sho_user = '.$product->pro_user);
        $data['getshop'] = $getshop;

        $ogurl = azibai_url().'/product/gallegy/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af_key;
        $data['ogtype'] = 'website';
        $og_title = $product->pro_name;
        $og_des = $product->pro_descr;

        $check_http = explode(':', explode(',',$product->pro_image)[0])[0];
        if($check_http == 'http' || $check_http == 'https'){
            $og_image = explode(',',$product->pro_image)[0];
        }else{
            $og_image = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . explode(',',$product->pro_image)[0];
        }
        
        if(isset($_REQUEST['img']) && $_REQUEST['img'] != ''){
            $this->load->model('images_model');
            $this->load->model('videos_model');
            if($af_id != ''){
                $ogurl .= '&img='.$_REQUEST['img'].'#image_'.$_REQUEST['img'];
            }else{
                $ogurl .= '?img='.$_REQUEST['img'].'#image_'.$_REQUEST['img'];
            }
            $gallery_share = $this->galleries_model->get("*", "id = " . $_REQUEST['img'] . " AND pro_id = " . $productID);
            if(!empty($gallery_share)){
                $check_http = explode(':', $gallery_share[0]->link)[0];
                if($check_http == 'http' || $check_http == 'https'){
                    $og_image = $gallery_share[0]->link;
                }else{
                    $og_image = DOMAIN_CLOUDSERVER . 'media/images/galleries/' . $gallery_share[0]->img_dir .'/'. $gallery_share[0]->link;
                }
            }
        }
        
        $data['af_id'] = $af_key;
        $data['ogurl'] = $ogurl;
        $data['ogtitle'] = $og_title;
        $data['ogdescription'] = $og_des;
        $data['ogimage'] = $og_image;
        
        $this->load->view('home/product/gallery', $data);
    }

    function display_parent($parent = 0, $level, &$retArray, $cate_type = 0, $cat_id)
    {
        $sql = "SELECT * from `tbtt_category` WHERE parent_id = " . $parent . " and cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {

            $cat_level_next = $this->category_model->fetch("*", "parent_id = ". (int)$row['cat_id'] ." AND cat_status = 1");
            $object = new StdClass;
            $object->cat_id = $row['cat_id'];
            $object->cat_name = $row['cat_name'];
            $object->levelQ = $level;
            $object->b2c_fee = $row['b2c_fee'];
            $object->active = ($row['cat_id'] == $cat_id) ? true : false;
            $object->child_count = count($cat_level_next);
            $retArray[$level][] = $object;
        }

        $sql = "SELECT * from `tbtt_category` WHERE cat_id = " . $parent . " and cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $result = $query->row();
        $query->free_result();

        if ($result->cat_level > 0) {
            $this->display_parent($result->parent_id, $result->cat_level , $retArray, $cate_type, $parent);
        } else if ($result->cat_level == 0) {
            $sql = "SELECT * from `tbtt_category` WHERE parent_id = 0 and cat_status = 1 and cate_type = ". $cate_type ." order by cat_order";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row) {
                $cat_level_next = $this->category_model->fetch("*", "parent_id = ". (int)$row['cat_id'] ." AND cat_status = 1");
                $object = new StdClass;
                $object->cat_id = $row['cat_id'];
                $object->cat_name = $row['cat_name'];
                $object->levelQ = $level;
                $object->b2c_fee = $row['b2c_fee'];
                $object->active = ($row['cat_id'] == $result->cat_id) ? true : false;
                $object->child_count = count($cat_level_next);
                $retArray[0][] = $object;
            }
        }
        
    }

    public function editProduct($productID) {
        #BEGIN: kiểm tra product by $productID
        $product = $this->product_model->get("*, (af_rate) AS aff_rate", "pro_id = " . (int)$productID);
        $user = $this->session->userdata('sessionUser');
        if ($user && $user == $product->pro_user) {

        } else {
            redirect(base_url() . $product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name), 'location');
            die();
        }
        if ($product && $product->pro_id <= 0) {
            redirect($this->subURL, 'location');
            die();
        }
        if (count($product) > 0) {
            $user_product = $this->user_model->get("*", "use_id = " . $product->pro_user);
        }

        if ($product->pro_user == "") {
            redirect(base_url(), 'location');
        }

        $data['user_product'] = $user_product->use_username;
        #END kiểm tra product by $productID
        
        //danh mục sản phẩm
        $categoryID = $product->pro_category;
        $category = $this->category_model->get("cat_id, cat_name, parent_id, cat_level", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            redirect(base_url(), 'location');
            die();
        }

        
        
        //end danh mục sản phảm

        //Check exist Truong Qui Cach of product, by Bao Tran
        $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$productID);
        
        if ($list_style) {
            $product = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost_qc" . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . (int)$productID, (int)$productID);
        }
        
        $list_style = array_reverse($list_style);

        $list_qc = [];
        $pro_qc_checkbox = [
            'qc_color' => false,
            'qc_size' => false,
            'qc_material' => false,
        ];
        foreach ($list_style as $k_qc => $v_qc) {

            if ($k_qc == 0) {
                if ($v_qc->dp_color != '') {
                    $pro_qc_checkbox['qc_color'] = true;
                }
                if ($v_qc->dp_size != '') {
                    $pro_qc_checkbox['qc_size'] = true;
                }
                if ($v_qc->dp_material != '') {
                    $pro_qc_checkbox['qc_material'] = true;
                }
            }

            $list_qc[$k_qc]['dp_image'] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/'. $v_qc->dp_images;
            $list_qc[$k_qc]['dp_color'] = $v_qc->dp_color;
            $list_qc[$k_qc]['dp_size']  = $v_qc->dp_size;
            $list_qc[$k_qc]['dp_material'] = $v_qc->dp_material;
            $list_qc[$k_qc]['dp_cost']  = $v_qc->dp_cost;
            $list_qc[$k_qc]['dp_instock'] = $v_qc->dp_instock;
            $list_qc[$k_qc]['dp_weight']  = $v_qc->dp_weight === null ? '' : $v_qc->dp_weight;
        }        
        //product attached
        $product_attached = [];
        if($product->pro_attach != 'null' && $product->pro_attach != null) {
            $list_pro = json_decode($product->pro_attach);
            if (!empty($list_pro)) 
            {
                $list_pro = implode(",", $list_pro);
                $product_attached = $this->product_model->fetch('pro_id, pro_name, pro_cost, pro_image, pro_dir, pro_saleoff, pro_type_saleoff, pro_saleoff_value','pro_id IN (' . $list_pro . ')');
            }
        }
        
        $data['product'] = $product;
        $data['category'] = $category;
        $data['product_attached'] = $product_attached;
        
        
        $this->load->model('cate_galleries_model');
        $this->load->model('galleries_model');
        $data['cate_galleries'] = $this->cate_galleries_model->get("*", "pro_id = " . $productID );
        $data['pro_gallegy'] = [];
        if (!empty($data['cate_galleries'])) {
            foreach ($data['cate_galleries'] as $k_galleries => $v_galleries) {
                $data['pro_gallegy'][$k_galleries]['id'] = $v_galleries->id;
                $data['pro_gallegy'][$k_galleries]['content'] = $v_galleries->name;
                $data['pro_gallegy'][$k_galleries]['hidden'] = false;
                $data['pro_gallegy'][$k_galleries]['list_pro'] = [];
                $gallery_detail = $this->galleries_model->get("*", "gallery_id = " . $v_galleries->id . " AND pro_id = " . $productID);
                if (!empty($gallery_detail)) {
                    foreach ($gallery_detail as $k_gallery_detail => $v_gallery_detail) {
                        $data['pro_gallegy'][$k_galleries]['list_pro'][$k_gallery_detail] = array(
                            'id' => $v_gallery_detail->id,
                            'link' => DOMAIN_CLOUDSERVER . 'media/images/galleries/' . $v_gallery_detail->img_dir . '/'. $v_gallery_detail->link,
                            'detail_w' => $v_gallery_detail->detail_w,
                            'detail_h' => $v_gallery_detail->detail_h,
                            'delete'    => false,
                            'caption'   => $v_gallery_detail->caption
                        );
                    }
                }
            }
        }


        
        // get list category parent
        $retArray = array();
        $this->display_parent($category->parent_id, $category->cat_level, $retArray, 0, $category->cat_id);
        ksort($retArray);

        //product attached
        $get_promo_pro = $this->product_promotion_model->fetch('*', 'pro_id = '. $productID);
        $limit_type = 1;
        $promotion_price = [];
        $promotion_list  = [];
        foreach ($get_promo_pro as $k_promo_pro => $v_promo_pro)
        {
            $promo_pro_type = 1;
            $promo_pro_amount = $v_promo_pro->dc_amt;
            if (!empty($v_promo_pro->dc_rate)) {
                $promo_pro_type = 2;
                $promo_pro_amount = $v_promo_pro->dc_rate;
            }

            if ($v_promo_pro->limit_type == 2)
            {
                $limit_type = 2;
                $promotion_price[] = (object) [
                    'limit_from' => $v_promo_pro->limit_from,
                    'limit_to' => $v_promo_pro->limit_to,
                    'amount' => $promo_pro_amount,
                    'type' => $promo_pro_type
                ];
            }
            else
            {
                $promotion_list[] = (object) [
                    'limit_from' => $v_promo_pro->limit_from,
                    'limit_to' => $v_promo_pro->limit_to,
                    'amount' => $promo_pro_amount,
                    'type' => $promo_pro_type
                ];
            }            
        }

        // var_dump($get_promo_pro);
        // die;
        
        if ($product->is_product_affiliate == 0) {
            $affiliate_value = 0;
            $affiliate_type = 1;
            $dc_affiliate_value = 0;
            $dc_affiliate_type = 1;
        } else {
            if ($product->af_amt > 0) {
                $affiliate_value = $product->af_amt;
                $affiliate_type = 2;
            } else {
                if ($product->aff_rate > 0) {
                    $affiliate_value = $product->aff_rate;
                    $affiliate_type = 1;
                }
            }
            
            if ($product->af_dc_amt > 0) {
                $dc_affiliate_value = $product->af_dc_amt;
                $dc_affiliate_type = 2;
            } else {
                if ($product->af_dc_rate > 0) {
                    $dc_affiliate_value = $product->af_dc_rate;
                    $dc_affiliate_type = 1;
                }
            }
        }
        
        $list_img_cover = [];
        if (!empty($product->pro_image)) {
            $list_img = explode(",",$product->pro_image);
            foreach ($list_img as $k_img => $v_img)
            {
                $list_img_cover[] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/'. $v_img;
            }
        }
        $text = 'sản phẩm';
        if($product->pro_type == 2){
          $text = 'phiếu mua hàng';
        }

        if ($product->pro_saleoff != 1) {
            $product->begin_date_sale = time();
            $product->end_date_sale = time(); 
        }

        
        $data['result'] = (object) [
            'product'=> (object) [
                'pro_id'    => $product->pro_id, // id product
                'pro_video' => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_video : $this->filter->injection_html($product->pro_video), // video (link youtube or vimeo)
                'pro_image' => $list_img_cover, // * list image
                'pro_name'  => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_name : $this->filter->injection_html($product->pro_name),  // * tên sản phẩm
                'pro_sku'   => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_sku : $this->filter->injection_html($product->pro_sku),   // * mã sản phẩm
                'pro_brand' => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_brand : $this->filter->injection_html($product->pro_brand), //   thương hiệu
                'pro_cost'  => $product->pro_cost,  // * giá bán
                'pro_currency'    => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_currency : $this->filter->injection_html($product->pro_currency),  // * loại tiền tệ
                'pro_unit'        => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_unit : $this->filter->injection_html($product->pro_unit),   // đơn vị bán 
                'pro_instock'     => $product->pro_instock,    // * số lượng trong kho
                'pro_minsale'     => $product->pro_minsale,    // * số lượng bán tối thiểu
                'pro_hot'       => $product->pro_hot,    // * sản phẩm hot
                'pro_weight'      => $product->pro_weight,    // * trọng lượng sản phẩm
                'pro_descr'       => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_descr : $this->filter->injection_html($product->pro_descr),  // wait
                'pro_keyword'     => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_keyword : $this->filter->injection_html($product->pro_keyword),  // wait
                'pro_hondle'        => $product->pro_hondle, // wait
                'pro_type' => $product->pro_type,


                'pro_saleoff'     => $product->pro_saleoff,    //  sản phẩm có giảm giá
                'pro_saleoff_value'   => $product->pro_saleoff_value,    //  giá trị giảm giá
                'pro_saleoff_type'    => $product->pro_type_saleoff,    //  loại giảm giá (1 - %, 2 - VND)
                'begin_date_sale'   => $product->begin_date_sale,   //  ngày bắt đầu giảm giá
                'end_date_sale'     => $product->end_date_sale,   //  ngày kết thúc giảm giá

                'is_product_affiliate'  => $product->is_product_affiliate,    //  sản phẩm có Affiliate hay không
                'pro_affiliate_value' => $affiliate_value,    //  giá trị hoa hồng cho người giới thiệu
                'pro_affiliate_type'  => $affiliate_type,    //  loại hoa hồng cho người giới thiệu (2 -VND or 1 - %)
                'pro_dc_affiliate_value'=> $dc_affiliate_value,    //  giá trị người mua được giảm
                'pro_dc_affiliate_type' => $dc_affiliate_type,    //  loại giá trị người mua được giảm (2 -VND or 1 - %)


                'pro_category'      => $product->pro_category,    // * danh mục sản phẩm
                'pro_category_name'      => $category->cat_name,    // tên danh mục sản phẩm
                'pro_mannufacurer'    => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_manufacturer : $this->filter->injection_html($product->pro_manufacturer),   // nhà sản xuất
                'pro_made_from'     => $product->pro_made_from,   // xuất xứ (1 - chính hãng, 2 - xách tay, 3 - hàng công ty)
                'pro_made_in'     => (date('Y-m-d', strtotime($product->up_date)) < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_made_in : $this->filter->injection_html($product->pro_made_in),   // sản xuất tại
                'pro_vat'       => $product->pro_vat,   // * VAT (1 - có , 2 không)
                'pro_quality'     =>  $product->pro_quality,   // tình trạng (0 - mới, 1 - cũ)
                'pro_warranty_period' => $product->pro_warranty_period,    // thời hạn bảo hành
                'pro_protection'    => $product->pro_protection,    // bảo hộ người mua (0 - không, 1 - có) - (non database)
                'pro_detail'      => (date('Y-m-d', strtotime($product->up_date))  < date('Y-m-d', strtotime('2019-03-18'))) ? $product->pro_detail : $product->pro_detail,   // * mô tả chi tiết
                'pro_specification'   => (!empty($product->pro_specification) && $product->pro_specification != 'null') ? json_decode($product->pro_specification) : [],   // đặc điểm kỹ thuật (non database, key - value)
                'pro_attach'      => ($product->pro_attach && $product->pro_attach != 'null') ? json_decode($product->pro_attach) : [],   // sản phẩm thường mua kèm
                'pro_attach_temp'      => (!empty($product->pro_attach) && $product->pro_attach != 'null') ? json_decode($product->pro_attach) : [],   // sản phẩm thường mua kèm tem
            ],
            'list_name_category'    => '',   // get list category choose show preview
            'list_get_category'    => $retArray,   // get list category choose show preview
            'pro_promotion'       => (object) [
              'limit_type'      => $limit_type,    //  loại giá sỉ (1 - số lượng, 2 - số tiền) 
              'promotion_price'    => $promotion_price,   //  list giá sỉ cho thành viên (giá tiền)
              'promotion_list'    => $promotion_list,   //  list giá sỉ cho thành viên (số lượng )
            ],
            'pro_qc'          => $list_qc,   // list trường quy cách nếu có
            'pro_qc_checkbox'          => $pro_qc_checkbox,   // list checkbox qc
            'pro_gallegy' => $data['pro_gallegy'],
            'text' => $text
        ];
        
        $data['products'] = $this->product_model->fetch("pro_category, pro_id, pro_name, pro_image, pro_dir, pro_type", "pro_type IN (0,2) AND pro_status = 1 AND pro_user=" . $user, "pro_type", "ASC", null, null);
        $this->load->view('home/product/edit_product', $data);
    }

    public function ajaxEditProduct($productID) {
        $result = ['error' => true];

        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
        {
            echo json_encode($result);
            die();
        }

        $group_id = $this->session->userdata('sessionGroup');
        if(!checkPerProduct($group_id)) {
            echo json_encode($result);
            die();
        }

        $product = $this->product_model->get("* , (af_rate) as aff_rate" . DISCOUNT_QUERY, "pro_id = " . (int)$productID);
        
        if ($product && $product->pro_id <= 0) {
            echo json_encode($result);
            die();
        }
        if (count($product) > 0) {
            $user_product = $this->user_model->get("*", "use_id = " . $product->pro_user);
        }

        if ($product->pro_user == "") {
            echo json_encode($result);
        }

        $data['user_product'] = $user_product->use_username;
        #END kiểm tra product by $productID
        
        //danh mục sản phẩm
        $categoryID = $product->pro_category;
        $category = $this->category_model->get("cat_id, cat_name, parent_id, cat_level", "cat_id = " . (int)$categoryID . " AND cat_status = 1");
        if (count($category) != 1 || !$this->check->is_id($categoryID)) {
            echo json_encode($result);
            die();
        }

        if ($this->input->post('product')) {
            $data_post = $this->input->post('product');
            
            $this->load->model('user_model');
            $user_check = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . (int)$this->session->userdata('sessionUser'));

            if($group_id == StaffStoreUser) {
                $user = $this->user_model->get("use_id, use_fullname, use_address, use_email, use_phone, use_mobile, use_yahoo, use_skype", "use_id = " . $user_check->parent_id);
                $pro_user       = $user_check->parent_id;
                $pro_user_up    = $this->session->userdata('sessionUser');
            } else {
                $user = $user_check;
                $pro_user = (int)$this->session->userdata('sessionUser');
            }

            $this->load->model('shop_model');
            $get_pro_province = $this->shop_model->get("sho_province", "sho_user  = " . (int) $user->use_id);
            $pro_province = $get_pro_province->sho_province;

            $reliable = 0;
            if ((int)$this->session->userdata('sessionGroup') == 3) {
                $reliable = 1;
            }


            $af_amt = 0;
            $af_rate = 0;
            $af_dc_amt = 0;
            $af_dc_rate = 0;
            if ($data_post['product']['is_product_affiliate'] == 0) {
                $af_amt = 0;
                $af_rate = 0;
            } else {
                if ( $data_post['product']['pro_affiliate_type'] == 1) {
                    $af_amt = 0;
                    $af_rate = !empty($data_post['product']['pro_affiliate_value']) ? $data_post['product']['pro_affiliate_value'] : 0;
                } else {
                    $af_amt = !empty($data_post['product']['pro_affiliate_value']) ? $data_post['product']['pro_affiliate_value'] : 0;
                    $af_rate = 0;
                }
                if ($data_post['product']['pro_dc_affiliate_type'] == 1) {
                    $af_dc_amt = 0;
                    $af_dc_rate = !empty($data_post['product']['pro_dc_affiliate_value']) ? $data_post['product']['pro_dc_affiliate_value'] : 0;
                } else {
                    $af_dc_amt = !empty($data_post['product']['pro_dc_affiliate_value']) ? $data_post['product']['pro_dc_affiliate_value'] : 0 ;
                    $af_dc_rate = 0;
                }
            }


            $list_img_cover = [];
            if (!empty($product->pro_image)) {
                $list_img = explode(",",$product->pro_image);
                foreach ($list_img as $k_img => $v_img)
                {
                    $list_img_cover[] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/'. $v_img;
                }
            }


            $pathImage = "media/images/product/";
            $dir_image = $product->pro_dir;
            $image = 'none.gif';
            if (!empty($data_post['product']['pro_image'])) {
                $image_upload = array(); 
                foreach ($data_post['product']['pro_image'] as $key => $value) {

                    if (in_array($value, $list_img_cover)) {
                        $image_upload[] = str_replace(DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/',"",$value); 
                    } else {
                       $image_upload[] = $this->add_photo_qc($value, $dir_image); 
                    }

                    
                }

                if (count($image_upload) > 0) {
                    $image = implode(',', $image_upload);
                }
            }
            if ($image == 'none.gif') {
                $dir_image = 'default';
            }

            // @@
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            
            $dataPost = array(
                    'pro_name' => trim($data_post['product']['pro_name']), // done
                    'pro_sku' => trim($data_post['product']['pro_sku']), // done
                    'pro_descr' => trim($data_post['product']['pro_descr']), // done
                    'pro_keyword' => trim($data_post['product']['pro_keyword']), // done
                    'pro_cost' => (int) $data_post['product']['pro_cost'], // done
                    'pro_currency' => trim(strtoupper($data_post['product']['pro_currency'])), // done
                    'pro_hondle' => (int) $data_post['product']['pro_hondle'], // done giá thương lượng
                    'pro_province' => (int) $pro_province,
                    'pro_category' => (int) $data_post['product']['pro_category'], // done
                    'pro_begindate' => $currentDate,
                    'pro_enddate' => $currentDate, // default time 
                    'pro_detail' => trim($data_post['product']['pro_detail']), // done
                    'pro_image' => $image,
                    'pro_dir' => $dir_image,
                    'pro_user' => $pro_user, // done
                    'pro_post_by' => 'web',  // done
                    'pro_user_up' => (isset($pro_user_up)) ? $pro_user_up : 0, // done
                    'pro_poster' => trim($user->use_fullname), // done
                    'pro_address' => trim($user->use_address), // done
                    'pro_phone' => trim($user->use_phone), // done
                    'pro_mobile' => trim($user->use_mobile), // done
                    'pro_email' => trim($user->use_email), // done
                    'pro_yahoo' => trim($user->use_yahoo), // done
                    'pro_skype' => trim($user->use_skype), // done
                    // 'pro_status' => 1, // done gian hang va nhan vien cua gian hang = 1
                    // 'pro_view' => 0, // done
                    // 'pro_buy' => 0,  // done
                    // 'pro_comment' => 0, // done
                    // 'pro_vote_cost' => 0, // done
                    // 'pro_vote_quanlity' => 0, // done
                    // 'pro_vote_model' => 0, // done
                    // 'pro_vote_service' => 0, // done
                    // 'pro_vote_total' => 0, // done
                    // 'pro_vote' => 0, // done
                    'pro_reliable' => $reliable, // done
                    'pro_saleoff' => (int)$data_post['product']['pro_saleoff'], // done
                    'pro_saleoff_value' => $data_post['product']['pro_saleoff_value'], // done
                    'pro_type_saleoff' => (int)$data_post['product']['pro_saleoff_type'], // done
                    'begin_date_sale' => strtotime($data_post['product']['begin_date_sale']), // done
                    'end_date_sale' => strtotime($data_post['product']['end_date_sale']), // done
                    'pro_hot' => (int)$data_post['product']['pro_hot'], // done
                    'is_product_affiliate' => (int) $data_post['product']['is_product_affiliate'], // done
                    'af_amt' => $af_amt,
                    'af_rate' => $af_rate,
                    'af_dc_amt' => $af_dc_amt,
                    'af_dc_rate' => $af_dc_rate,
                    // 'pro_show' => 0, // done
                    'pro_manufacturer_id' => -1, // done
                    'pro_manufacturer' => trim($data_post['product']['pro_mannufacurer']), // done
                    'pro_instock' => (int) $data_post['product']['pro_instock'], // done
                    'pro_unit' => trim($data_post['product']['pro_unit']), // done
                    'pro_weight' => (int) $data_post['product']['pro_weight'], // done
                    'pro_length' => 0,  // done
                    'pro_width' => 0,   // done
                    'pro_height' =>  0, // done
                    'pro_minsale' => (int)$data_post['product']['pro_minsale'], // done
                    'pro_vat' => (int)$data_post['product']['pro_vat'], // done
                    'pro_quality' => (int) $data_post['product']['pro_quality'], // done
                    'pro_made_from' => (int) $data_post['product']['pro_made_from'], // done
                    'pro_warranty_period' => (int) $data_post['product']['pro_warranty_period'],
                    'pro_video' => trim($data_post['product']['pro_video']), // done
                    // 'created_date' => date("Y-m-d"), // done
                    // 'pro_type' => 0, // done
                    'pro_brand' => trim($data_post['product']['pro_brand']), // done
                    'pro_protection'    => (int) $data_post['product']['pro_protection'], // done
                    'pro_specification' => !empty($data_post['product']['pro_specification']) ? json_encode($data_post['product']['pro_specification']) : null, // done
                    'pro_attach'        => !empty($data_post['product']['pro_attach']) ? json_encode($data_post['product']['pro_attach']) : null, // done
                    'pro_made_in'       => trim($data_post['product']['pro_made_in']), // done
                );


            if ($this->product_model->update($dataPost, "pro_id = " . (int) $productID)) {
                
                $pro_id = (int) $productID;

                // get list user and add affiliate
                
                if ($product->is_product_affiliate != $dataPost['is_product_affiliate']) {
                    $this->load->model('product_affiliate_user_model');
                    if ($dataPost['is_product_affiliate'] == 0) {
                        $this->product_affiliate_user_model->delete(array('pro_id' => $pro_id));
                    } 
                    else 
                    {
                        $list_user_affiliate = $this->user_model->get_list_user("use_id", "parent_id = " . (int)$pro_user.' OR parent_shop = ' .(int)$pro_user );
                        
                        $dataAffiliate = array();
                        foreach ($list_user_affiliate as $key => $value) {
                            $dataAffiliate[] = array('use_id' => $value->use_id, 'pro_id' => $pro_id, 'homepage' => 1, 'date_added' => time(), 'kind_of_aff' => 1);
                        }
                        if (!empty($dataAffiliate)) {
                            $this->product_affiliate_user_model->add_all($dataAffiliate);
                        }
                    }  
                } 
                
                

                // Add gallery 
                $this->load->model('cate_galleries_model');
                $this->load->model('galleries_model');

                if (!empty($data_post['pro_gallegy'])) {
                    foreach ($data_post['pro_gallegy'] as $k_gallegy => $v_gallegy) {
                        if ($v_gallegy['hidden'] == 'false') {                            
                            $dataInsert = array(
                                'user_id' => $pro_user,
                                'pro_id'  => $pro_id,
                                'name'    => $v_gallegy['content']
                            );

                            $id_insert = 0;

                            if (!isset($v_gallegy['id']))
                            {
                                $id_insert = $this->cate_galleries_model->add($dataInsert);
                            } 
                            else if ($this->cate_galleries_model->update($dataInsert, ['id' => $v_gallegy['id']])) 
                            {
                               $id_insert = $v_gallegy['id'];
                            }

                            if ($id_insert > 0 && !empty($v_gallegy['list_pro']))
                            {
                                foreach ($v_gallegy['list_pro'] as $k_list_pro => $v_list_pro)
                                {

                                    if ($v_list_pro['delete'] == 'false') {

                                        $this->galleries_model->update(array('gallery_id' => $id_insert, 'pro_id' => $pro_id, 'caption'=> $v_list_pro['caption']), "id = " . $v_list_pro['id']);
                                    } else {
                                        $this->galleries_model->delete(['id' => $v_list_pro['id']]);
                                    }
                                    
                                }
                            }
                        }
                        else if (($v_gallegy['hidden'] == 'true') && isset($v_gallegy['id']))
                        {
                            if ($this->cate_galleries_model->delete(['id' => $v_gallegy['id']])) {
                                $this->galleries_model->delete(['gallery_id' =>$v_list_pro['id']], 'gallery_id');
                            }
                        }
                    }
                }
                // Add promotion
                $this->product_promotion_model->deleteRow(array('pro_id' => $pro_id));
                $promotions = array();
                if (!empty($data_post['pro_promotion']['promotion_list']) && (int) $data_post['pro_promotion']['limit_type'] == 1) {
                    foreach ($data_post['pro_promotion']['promotion_list'] as $row) {
                        $promotion = array();
                        $promotion['limit_from'] = $row['limit_from'];
                        $promotion['limit_to'] = $row['limit_to'];
                        $promotion['limit_type'] = 1;
                        if ($row['type'] == 1) {
                            $promotion['dc_amt'] = $row['amount'];
                            $promotion['dc_rate'] = 0;
                        } else {
                            $promotion['dc_rate'] = $row['amount'];
                            $promotion['dc_amt'] = 0;
                        }
                        $promotion['pro_id'] = $pro_id;
                        array_push($promotions, $promotion);
                    }
                    $this->product_promotion_model->add($promotions);
                }

                if (!empty($data_post['pro_promotion']['promotion_price']) && (int) $data_post['pro_promotion']['limit_type'] == 2) {
                    foreach ($data_post['pro_promotion']['promotion_price'] as $row) {
                        $promotion = array();
                        $promotion['limit_from'] = $row['limit_from'];
                        $promotion['limit_to'] = $row['limit_to'];
                        $promotion['limit_type'] = 2;
                        if ($row['type'] == 1) {
                            $promotion['dc_amt'] = $row['amount'];
                            $promotion['dc_rate'] = 0;
                        } else {
                            $promotion['dc_rate'] = $row['amount'];
                            $promotion['dc_amt'] = 0;
                        }
                        $promotion['pro_id'] = $pro_id;
                        array_push($promotions, $promotion);
                    }
                    $this->product_promotion_model->add($promotions);
                }
                //Lưu trữ trường quy cách                       
                $standards = array();

                $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$productID);
                $list_style_cover = [];
                if (!empty($list_style)) {
                    foreach ($list_style as $k_style => $v_style)
                    {
                        $list_style_cover[] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/'. $v_style->dp_images;
                    }
                }

                // dd($list_style_cover);die;
                $this->detail_product_model->delete([$productID], 'dp_pro_id');

                if (!empty($data_post['pro_qc'])) {
                    foreach ($data_post['pro_qc'] as $key => $rowqc) {
                        if ($rowqc['dp_cost'] != '' && $rowqc['dp_instock'] != '' && ($rowqc['dp_size'] != '' || $rowqc['dp_color'] != '' || $rowqc['dp_material'] != '')) {
                            $standard = array();
                            $standard['dp_pro_id'] = $pro_id;
                            $standard['dp_size'] = $rowqc['dp_size'];
                            $standard['dp_color'] = $rowqc['dp_color'];
                            $standard['dp_material'] = $rowqc['dp_material'];
                            $standard['dp_cost'] = $rowqc['dp_cost'];
                            $standard['dp_instock'] = $rowqc['dp_instock'];
                            $standard['dp_weight'] = !empty($rowqc['dp_weight']) ? $rowqc['dp_weight'] : null;
                            $standard['dp_createdate'] = date('Y-m-d');

                            if (in_array($rowqc['dp_image'], $list_style_cover)) {
                                $standard['dp_images'] = str_replace(DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/',"",$rowqc['dp_image']);
                            } else {
                               $standard['dp_images'] = $this->add_photo_qc($rowqc['dp_image'], $dir_image);
                            }
                            
                            array_push($standards, $standard);

                            $this->detail_product_model->add($standard);
                        }
                        $t++;
                    }

                    if ($standards && $this->session->userdata('image_name_qc')) {
                        $this->session->unset_userdata('image_name_qc');
                    }
                }
            }
            $result = ['error' => false];
            //create or update view on azibai-ecommerce
            // $this->createViewProduct();
        }

        echo json_encode($result);
        die();
    }
}
