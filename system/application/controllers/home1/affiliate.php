<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Affiliate extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->helper('language');
        $this->lang->load('home/common');
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
        
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $this->load->model('commissionaffilite_model');
        // $this->load->model('detail_commission_aff_model');
        $this->load->model('category_model');
        $this->load->model('package_user_model');
        $this->load->model('wallet_model');
        $this->load->model('product_affiliate_user_model');
        $this->load->model('af_product_model');
        $this->load->model('package_daily_user_model');        

        $shop = $this->shop_model->get("sho_link, sho_package", "sho_user = " . (int)$this->session->userdata('sessionUser'));
        $data['shoplink'] = $shop->sho_link;
        $data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
        $data['productCategoryHot'] = $this->loadCategoryHot(0, 0);

        $data['sho_package'] = $this->package_user_model->getCurrentPackage((int)$this->session->userdata('sessionUser'));
        $data['wallet_info'] = $this->wallet_model->getSumWallet(array('user_id' => (int)$this->session->userdata('sessionUser')), 1);

        #Load menu cho Chi nhanh theo GH cha cua no, Quan Ly Nhan Vien
        if ($this->session->userdata('sessionGroup') == BranchUser) {
            $UserID = (int)$this->session->userdata('sessionUser');
            $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
            if ($u_pa) {
                $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
            }
        }
        $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
        $data['currentuser'] = $cur_user;
	if($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2){
	    $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
	} else {
	    $parentUser = $this->user_model->get("parent_id","use_id = " . (int)$this->session->userdata('sessionUser'));
	    $data['myshop'] = $this->shop_model->get("sho_link, domain","sho_user = " . (int)$parentUser->parent_id);
	}	
        $data['mainURL'] = $this->getMainDomain();

        $this->load->vars($data);
    }

    function index()
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $data = array();
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate';
            $data['products'] = base_url() . 'account/affiliate/products';
            $data['orders'] = base_url() . 'account/affiliate/orders';

            $this->load->view('home/affiliate/dashboard', $data);
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function recursive($parent_id = 0, $data = null)
    {
        $sql = "SELECT cat_id, cat_name,cat_level, parent_id from `tbtt_category` WHERE parent_id = " . $parent_id . " AND cat_status = 1 order by cat_order";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        if (isset($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parent_id) {
                    $object = new StdClass;
                    $object->cat_id = $val['cat_id'];
                    $this->recursive[] = $object;
                    unset($data[$key]);
                    $this->recursive($val['cat_id'], $data);
                }
            }
        }
        return $this->recursive;
    }

    function products($page = 0)
    {
        // Create data default
        $L_Array1 = array();
        $cat_id = '';

        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateUser) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/affiliate.js');
            $this->af_product_model->pagination(TRUE);
            $this->af_product_model->setCurLink('account/affiliate/products');
            $data = array();
            // get cau hinh hoa hong cho aff
            $get_u = $this->user_model->get('use_id,parent_id, use_group', 'use_id = "' . $this->session->userdata('sessionUser') . '"');
            switch ($get_u->use_group) {
                case AffiliateUser:
                    $get_p1 = $this->user_model->get('use_id,parent_id, use_group', 'use_id = "' . $get_u->parent_id . '"');
                    $get_p2 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $get_p1->parent_id . '"');
                    if($get_p2){
                        $get_p3 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p2->parent_id . '"'); //lay cha thu 2
                    }
                    if ($get_p3->use_group == StaffStoreUser) {
                        $get_p4 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p3->parent_id . '"'); //lay cha thu 3
                        $sho_user = $get_p4->use_id;
                    }
                    else {
                        if ($get_p2->use_group == AffiliateStoreUser || $get_p2->use_group == StaffStoreUser || $get_p2->use_group == BranchUser) {
                            if ($get_p2->use_group == AffiliateStoreUser) {
                                $sho_user = $get_p2->use_id;
                            }
                            else {
                                $sho_user = $get_p3->use_id;
                            }
                        } else {
                            if ($get_p2->use_group == StaffStoreUser) {
                                $sho_user = $get_p2->use_id;                               
                            } else {
                                $sho_user = $get_p1->use_id;
                            }
                        }
                    }
                    break;
            }
            $list_commiss_sho = $this->commissionaffilite_model->fetch("id, sho_user, min, max, percent", "af_id = " . (int)$this->session->userdata('sessionUser'), '', '', '', '');
            if (empty($list_commiss_sho)) {
                $data['nullCommissionAff'] = 'Chưa có cấu hình chung các mức thưởng thêm cho Cộng tác viên online.';
            } else {
                foreach ($list_commiss_sho as $key => $value) {
                    $L_Array1[] = array(
                        'id' => $value->id,
                        'shop_user' => $value->sho_user,
                        'min' => $value->min,
                        'max' => $value->max,
                        'percent' => $value->percent
                    );
                }
                // $check_commiss_aff = $this->detail_commission_aff_model->get("*", "aff_id = " . $this->session->userdata('sessionUser'));
                // $L_Array1 = array();
                // if ($check_commiss_aff) {
                //     $l_array = array();
                //     $a_com = explode(',', $check_commiss_aff->commissid_percent);
                //     foreach ($list_commiss_sho as $key => $value) {
                //         $tick = true;
                //         for ($i = 0; $i < count($a_com); $i++) {
                //             $b_com = explode(':', $a_com[$i]);
                //             if ($value->id == $b_com["0"]) {
                //                 $l_array[] = array(
                //                     'id' => $value->id,
                //                     'shop_user' => $value->sho_user,
                //                     'min' => $value->min,
                //                     'max' => $value->max,
                //                     'percent' => $b_com["1"]
                //                 );
                //                 $tick = true;
                //                 break;
                //             } else {
                //                 $tick = false;
                //                 continue;
                //             }
                //         }
                //         if ($tick == false) {
                //             $l_array[] = array(
                //                 'id' => $value->id,
                //                 'shop_user' => $value->sho_user,
                //                 'min' => $value->min,
                //                 'max' => $value->max,
                //                 'percent' => $value->percent
                //             );
                //         }
                //         $L_Array1[] = $l_array;
                //     }
                // } else {
                //     foreach ($list_commiss_sho as $key => $value) {
                //         $l_array[] = array(
                //             'id' => $value->id,
                //             'shop_user' => $value->sho_user,
                //             'min' => $value->min,
                //             'max' => $value->max,
                //             'percent' => $value->percent
                //         );
                //     }
                //     $L_Array1[] = $l_array;
                // }
            }
 
            $data['list_commiss_sho'] = $L_Array1;
            // end cau hinh hoa hong
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $data['shop'] = $shop;
            $data['shopid'] = $shop->sho_id;
            $data['sho_category'] = $shop->sho_category;
            $afId = (int)$this->session->userdata('sessionUser');

            $data['number_cat'] = 1;
            $numberMyProduct = $this->af_product_model->myNumberProduct($afId);
            $data['numberMyProduct'] = $numberMyProduct;
            $catlv = $this->category_model->fetch('cat_id, cat_name, parent_id', 'cat_level = 0 AND cat_status = 1', "", "", "", "");
            if (isset($catlv)) {
                foreach ($catlv as $key => $item) {
                    $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $catlv[$key]->child_count = count($cat_level_1);
                }
            }
            $data['childcat'] = $catlv;
            $catsub     = (isset($_REQUEST['cat_pro_0']) ? $_REQUEST['cat_pro_0'] : '');
            $catsub1    = (isset($_REQUEST['cat_pro_1']) ? $_REQUEST['cat_pro_1'] : '');
            $catsub2    = (isset($_REQUEST['cat_pro_2']) ? $_REQUEST['cat_pro_2'] : '');
            $catsub3    = (isset($_REQUEST['cat_pro_3']) ? $_REQUEST['cat_pro_3'] : '');
            $catsub4    = (isset($_REQUEST['cat_pro_4']) ? $_REQUEST['cat_pro_4'] : '');
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
            $data['cat_id'] = $cat_id;
           
            $data['products'] = $this->af_product_model->lister1($afId, $page, $cat_id);

            $user_detail = $this->user_model->get('*', "use_id = " . (int)$this->session->userdata('sessionUser'));
            $this->db->flush_cache();
            $parent_detail = $this->user_model->get('*', "use_id = " . $user_detail->parent_id);
            if ((int)$parent_detail->use_group != AffiliateStoreUser && (int)$parent_detail->use_group != BranchUser && (int)$parent_detail->use_group != StaffStoreUser && (int)$parent_detail->use_group != StaffUser && $user_detail->parent_shop == 0) {
                $data['show_btn'] = 1;
            } else {
                $data['show_btn'] = 1;
            }
            $get_domain = $this->shop_model->get('sho_id, domain', 'sho_user = "' . (int)$parent_detail->use_id . '"');
            $data['domain'] = $get_domain->domain;

            $data['pager'] = $this->af_product_model->pager;
            $data['sort'] = $this->af_product_model->getAdminSort();
            $data['filter'] = $this->af_product_model->getFilter();
            //$data['category'] = $this->af_product_model->getCategory();
            $data['link'] = base_url() . $this->af_product_model->getRoute('product');
            $data['productLink'] = $data['link'];
            $data['myproductsLink'] = base_url() . $this->af_product_model->getRoute('myproducts');
            $data['num'] = $page;
            //$data['shopCategory'] = $this->af_product_model->getShopCategory();
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate';
            #Load view
            $this->load->view('home/affiliate/products', $data);
        } else {
            redirect(base_url() .'login', 'location');
            die();
        }
    }

    function myproducts($page = 0)
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            $afId = (int)$this->session->userdata('sessionUser');
            if ($group_id == AffiliateUser
            ) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }

            $data = array();
            $select = '';
            $where = '';
            $pageSort = '';
            $pageUrl = '';
            $sort = '';
            $by = '';

            $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
            //$getVar = $this->uri->uri_to_assoc(1, $action);
            $query_str = $this->input->server('QUERY_STRING');
            parse_str($query_str, $getVar);
            $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : 'id';
            $getVar['dir'] = $getVar['dir'] != '' ? $getVar['dir'] : 'desc';
            $pro_type = $getVar['type'] != '' ? $getVar['type'] : 0;echo $getVar['type'];
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'price':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "tbtt_product.pro_id";
            }
            if ($getVar['dir'] != FALSE && strtolower($getVar['dir']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
            #If have page
            if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                $start = (int)$getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }
            #END Sort            
            #Begin:: Load library            
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/clipboard.min.js');
            $util->addScript(base_url() . 'templates/home/js/affiliate.js');
            $this->af_product_model->pagination(TRUE);
            $this->af_product_model->setCurLink('account/affiliate/myproducts');
            #End:: Load library
            $shop = $this->shop_model->get("*", "sho_user = " . $afId);
            $data['shop'] = $shop;
            $data['shopid'] = $shop->sho_id;

            #Begin:: update product to is homepage
            $proid = (int)$this->input->post('proid');
            $ishome = (int)$this->input->post('ishome');
            if (isset($proid) && $proid > 0) {
                $this->product_affiliate_user_model->update(array('homepage' => $ishome), 'use_id = ' . $afId . ' AND pro_id = ' . $proid);
                echo '1';
                exit();
            }
            #End:: update product to is homepage
            #Begin:: Search for product or coupon      
            $ptype = (int)$this->input->post('product_type');
            if ($ptype && $ptype > 0) {
                $pro_type = $ptype;
            }
            if($pro_type != ''){
                $data['typesr'] = '&type='.$pro_type;
                $data['product_type'] = $pro_type;
            }
            
            #End:: Search for product or coupon
            #Get user
            $id_my_parent = '';
            $get_u = $this->user_model->get('use_id, use_username, use_group, parent_id, parent_shop', 'use_id = ' . $afId . ' AND use_group = 2 AND use_status = 1');
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

            #Get product selected sales
            $pro_id_select = array();
            $select_list = $this->product_affiliate_user_model->fetch('*', 'use_id = ' . $afId . ' AND homepage = 1');
            $pro_id_selected = '0';
            if ($select_list) {
                foreach ($select_list as $k => $v) {
                    $pro_id_select[] = $v->pro_id;
                }
                $pro_id_selected = implode(',', $pro_id_select);
            }

            $where .= 'is_product_affiliate = 1 AND pro_status = 1 AND (pro_user = ' . $id_my_parent . ' OR `tbtt_product`.pro_id IN (' . $pro_id_selected . ')) AND pro_type = ' . $pro_type;

            $pro_name = $this->input->post('pro_name');
            if($pro_name && $pro_name != ''){
                $where .= ' AND pro_name LIKE "%' . $pro_name . '%"';
                $data['pro_name'] = $pro_name;
            }
            $price_type = $this->input->post('price_type');
            if($price_type && $price_type != ''){
                $data['price_form'] = $price_form = $this->input->post('pf');
                $data['price_to'] = $price_to = $this->input->post('pt');
                if(!$price_form){
                    $price_form = 0;
                }
                if(!$price_form){
                    $price_to = 0;
                }
                //if(($price_form && $price_form != '') || ($price_to && $price_to != '')){
                    if($price_type == 1){
                        $filed = 'pro_cost';
                        $ope = '>=';
                    }
                    if($price_type == 2){
                        $filed = 'af_amt';
                    }
                    if($price_type == 3){
                        $filed = 'af_rate';
                    }
                    if($price_form > 0 && $price_to > 0){
                        $where .= ' AND ' . $filed . ' BETWEEN ' . $price_form . ' AND ' . $price_to;
                    }else{
                        if($price_form >= 0){
                            $where .= ' AND ' . $filed . '>=' . $price_form;
                        }else{
                            $where .= ' AND ' . $filed . '>=' . $price_to;
                        }
                    }
                //}
                $data['price_type'] = $price_type;
            }
            $select .= "tbtt_product.pro_id, pro_name, pro_category, pro_descr, pro_cost, pro_user, pro_image, pro_dir, pro_type, af_amt, af_rate, sho_link, sho_name, domain";
            $products = $this->af_product_model->myProduct1($select, $afId, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "", "", "", $where, $sort, $by, $start, 0, false, $page);

            $data['products'] = $products['data'];
            $data['setAfKey'] = $products['setAfKey'];
            $data['parent_shop'] = $id_my_parent;
            $data['pro_type'] = (int)$pro_type;

            $data['pager'] = $this->af_product_model->pager;
            $data['sort'] = $this->af_product_model->getAdminSort();
            //$data['filter'] = $this->af_product_model->getFilter();
            $data['category'] = $this->af_product_model->getCategory();
            $data['link'] = base_url() . $this->af_product_model->getRoute('myproducts');
            $data['myproductsLink'] = $data['link'];
            $data['productLink'] = base_url() . $this->af_product_model->getRoute('product');
            $data['num'] = $page;
            $data['shopCategory'] = $this->af_product_model->getShopCategory();
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate';
            #Load View
            $this->load->view('home/affiliate/myproducts', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function pressproducts($page = 0)
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateUser
            ) {

            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
            $this->load->library('utilslv');
            $util = utilslv::getInstance();
            $util->addScript(base_url() . 'templates/home/js/clipboard.min.js');
            $util->addScript(base_url() . 'templates/home/js/affiliate.js');

            $this->af_product_model->pagination(TRUE);
            $this->af_product_model->setCurLink('account/affiliate/pressproducts');
            $data = array();
            $this->load->model('shop_model');
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $data['shop'] = $shop;
            $data['shopid'] = $shop->sho_id;
            $afId = (int)$this->session->userdata('sessionUser');
            $data['products'] = $this->af_product_model->pressProduct(array('use_id' => $afId), $page);
            $data['pager'] = $this->af_product_model->pager;
            $data['sort'] = $this->af_product_model->getAdminSort();
            $data['filter'] = $this->af_product_model->getFilter();
            $data['category'] = $this->af_product_model->getCategory();
            $data['link'] = base_url() . 'account/affiliate/pressproducts';
            $data['pressproductsLink'] = $data['link'];
            $data['productLink'] = base_url() . $this->af_product_model->getRoute('product');
            $data['num'] = $page;
            $data['shopCategory'] = $this->af_product_model->getShopCategory();
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate';
            $this->load->view('home/affiliate/pressproducts', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function ajaxAddProduct()
    {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status', 0);
        $userId = (int)$this->session->userdata('sessionUser');
        $totalAfCate = $this->package_daily_user_model->getTotalAfCate($userId);

        $number_cat = 30 + (int)$totalAfCate[0]['total'];
        $cat_id = $this->product_model->get('pro_category', 'pro_id = ' . $ids[0]);
        $product_allow_af = 32;
        $product_allow_aftotal = 0;
        $query = "SELECT pro.pro_id,pro.pro_category, COUNT(pro.pro_id) as total_pro FROM tbtt_product_affiliate_user AS au JOIN tbtt_product as pro ON pro.pro_id = au.pro_id where au.use_id = " . $userId;
        $return = $this->db->query($query);
        $cat = $return->result();        
        // truong hop 1 product
        $total = $this->getTotalCategories($userId, $ids);
        if ($userId <= 0) {
            $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');
        } else {
            $this->load->model('product_affiliate_user_model');
            if ($status == 1 && $total > $number_cat) {
                $return = array('error' => true, 'message' => 'Bạn chỉ có thể gắp hàng tối đa ' . $number_cat . ' danh mục. Để có thể gắp thêm vui lòng mua <a class="link_popup" href="' . base_url() . 'account/service">Dịch vụ kệ hàng</a>');
            } else {
                foreach ($ids as $k => $id) {
                    if ($status == 0) { //&& $total['error'] == false  && $total < $number_cat && $total >= 0
                        $this->product_affiliate_user_model->delete(array('use_id' => $userId, 'pro_id' => $id));
                        $return = array('error' => false, 'message' => 'Thành công', 'total' => $total);
                    } elseif (($status == 1) && $product_allow_aftotal == 0) { // && $total <= $number_cat
                        $check_pro = $this->product_affiliate_user_model->check(array('use_id' => $userId, 'pro_id' => $id));
                        if ($check_pro) {
                            //UPdate 
                            $this->product_affiliate_user_model->update(array('homepage' => 1), "use_id = " . $userId . " AND pro_id = " . $id);
                        } else {
                            // Add                            
                            $this->product_affiliate_user_model->insert(array('use_id' => $userId, 'pro_id' => $id, 'homepage' => 1, 'date_added' => time()));
                        }
                        $return = array('error' => false, 'message' => 'Thành công', 'total' => $total);
                    }
                }
            }
        }
        echo json_encode($return);
        exit();
    }

    ## Ajax select product sale for Affiliate, by Bao Tran
    function ajax_select_pro_sales()
    {
        $user_id  = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $proid    = (int)$this->input->post('proid');
        if ($group_id && $user_id && $proid) {
            $this->load->model('product_model');

            $user_action    = $this->user_model->find_where(['use_id' => $user_id]);
            $product_action = $this->product_model->find_where(['pro_id' => $proid]);
            if( !empty($product_action) && $product_action['is_product_affiliate'] == 1
                && $user_id != $product_action['pro_user']
                && $group_id != StaffStoreUser
                && !($group_id == AffiliateUser && $user_action['parent_id'] == $product_action['pro_user'])
                && !($user_action['parent_shop'] == $product_action['pro_user'])
            ) {
                //Kiểm tra đã chọn bán chưa
                $check_pro = $this->product_affiliate_user_model->check(array('use_id' => $user_id, 'pro_id' => $proid));
                if ($check_pro) {
                    //UPdate
                    $this->product_affiliate_user_model->update(array('homepage' => 1), "use_id = " . $user_id . " AND pro_id = " . $proid);
                } else {
                    // Add
                    $this->product_affiliate_user_model->insert(array('use_id' => $user_id, 'pro_id' => $proid, 'homepage' => 1, 'date_added' => time()));
                }
                echo "1";
                exit();
            }
        } else {
            echo "-1";
            exit();
        }
    }

    ## Ajax cancel select product sale for Affiliate, by Bao Tran
    function ajax_cancel_select_pro_sales()
    {
        $user_id  = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $proid    = (int)$this->input->post('id_pro');
        if ($group_id && $user_id && $proid) {
            $this->load->model('product_model');
            //Kiểm tra đã chọn bán chưa
            $user_action    = $this->user_model->find_where(['use_id' => $user_id]);
            $product_action = $this->product_model->find_where(['pro_id' => $proid]);
            if( !empty($product_action) && $product_action['is_product_affiliate'] == 1
                && $user_id != $product_action['pro_user']
                && $group_id != StaffStoreUser
                && !($group_id == AffiliateUser && $user_action['parent_id'] == $product_action['pro_user'])
                && !($user_action['parent_shop'] == $product_action['pro_user'])
            ){
                $check_pro = $this->product_affiliate_user_model->check(array('use_id' => $user_id, 'pro_id' => $proid));
                if ($check_pro) {
                    $this->product_affiliate_user_model->delete(array('use_id' => $user_id, 'pro_id' => $proid));
                    echo "1";
                    exit();
                }
            }
        }
        echo "-1";
        exit();
    }

    function getTotalCategories($userId, $ids)
    {
        $this->load->model('product_model');
        $this->load->model('user_model');
        $user_detail = $this->user_model->get('*', 'use_id = ' . $userId . ' AND use_status = 1');
        $shop_parent = 0;
        $return = 0;
        if ($user_detail->parent_id > 0) {
            $user_parent = $this->user_model->get('*', 'use_id = ' . $user_detail->parent_id . ' AND use_status = 1');
            if ($user_parent->use_group == 3) {
                $shop_parent = $user_parent->use_id;
            } elseif ($user_parent->use_group != 3 && $user_detail->parent_shop > 0) {
                $shop_parent = $user_detail->parent_shop;
            }
        }
        if (count($ids) == 1) {
            $product = $this->product_model->get("pro_category, pro_user", "pro_id = " . $ids[0]);
            if ($shop_parent == $product->pro_user) { // neu gap san pham cua shop cha thi luon cho gap
                $return = 0;
            }
        } elseif (count($ids) == 2 && $ids[0] == 1) {
            $product = $this->product_model->get("pro_category, pro_user", "pro_id = " . $ids[1]);
            if ($shop_parent == $product->pro_user) { // neu gap san pham cua shop cha thi luon cho gap
                $return = 0;
            }
        }
        $this->load->model('product_affiliate_user_model');
        $total = $this->product_affiliate_user_model->getTotalCategoriesByAff($userId);
        if (count($total) > 0) {
            // xu ly nhieu row
            if (count($ids) >= 2 && $ids[0] > 1) {
                $counter = 0;
                $restCat = 0;
                foreach ($ids as $id) {
                    $product1 = $this->product_model->get("pro_category, pro_user", "pro_id = " . $id);
                    $this->db->flush_cache();
                    foreach ($total as $total_item) {
                        if ($product1->pro_category == $total_item->pro_category) {
                            $counter++;
                        }
                    }
                }
                $restCat = count($ids) - $counter;
                $return = count($total) + $restCat;
            }
        }

        if (count($ids) == 1) {
            $inList = 0;
            if (count($total) > 0) {
                foreach ($total as $total_item) {
                    if ($product->pro_category == $total_item->pro_category) {
                        $inList = 1;
                        break;
                    }
                }
            }
            if ($inList == 1) {
                $return = count($total);
            } else {
                $return = count($total) + 1;
            }

        } elseif (count($ids) == 2 && $ids[0] == 1) {
            $inList = 0;
            if (count($total) > 0) {
                foreach ($total as $total_item) {
                    if ($product->pro_category == $total_item->pro_category) {
                        $inList = 1;
                        break;
                    }
                }
            }
            if ($inList == 1) {
                $return = count($total);
            } else {
                $return = count($total) + 1;
            }
        }
        return $return;
    }

    function orders_backup($page = 0)
    {
        if ($this->session->userdata('sessionUser')) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateUser
                || $group_id == StaffStoreUser
                || $group_id == StaffUser
            ) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            if ($getVar['page'] != false && $getVar['page'] != '') {
                $start = $getVar['page'];
            } else {
                $start = 0;
            }
            $page = $getVar['page'];

            $link = 'account/affiliate/orders';
            $this->load->model('af_order_model');
            $this->af_order_model->pagination(TRUE);
            $this->af_order_model->setLink($link);
            $afId = (int)$this->session->userdata('sessionUser');
            $data = array();

            $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$this->session->userdata('sessionUser') . '"');
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
            switch ($get_u[0]->use_group) {
                case AffiliateUser:
                    $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                    if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                        if ($get_p[0]->domain != '') {
                            $parent = $get_p[0]->domain;
                        } else {
                            $parent = $get_p[0]->sho_link;
                        }
                    } else {
                        if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                            $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                            if ($get_p1[0]->domain != '') {
                                $parent = $get_p1[0]->domain;
                            } else {
                                $parent = $get_p1[0]->sho_link;
                            }
                        } else {
                            $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                            if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                if ($get_p1[0]->domain != '') {
                                    $parent = $get_p2[0]->domain;
                                } else {
                                    $parent = $get_p2[0]->sho_link;
                                }
                            }
                        }
                    }
                    break;
            }
            $data['parent'] = $parent;

            /*END Lay don hang cua nhung af duoi nvgh*/
            switch ($this->session->userdata('sessionGroup')) {
                case StaffStoreUser:
                case StaffUser:
                    $get_u = $this->user_model->get('use_group, parent_id, use_id', 'use_id = "' . $this->session->userdata('sessionUser') . '"');
                    $tree = array();
                    $tree[] = $this->session->userdata('sessionUser');
                    $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ',' . AffiliateUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = "' . $this->session->userdata('sessionUser') . '"');
                    if (!empty($sub_tructiep)) {
                        foreach ($sub_tructiep as $key => $value) {
                            $tree[] = $value->use_id;
                            //Nếu là chi nhánh, lấy danh sách nhân viên
                            if ($value->use_group == BranchUser) {
                                $sub_nv = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = ' . StaffUser . ' AND use_status = 1 AND parent_id = ' . $value->use_id);
                                if (!empty($sub_nv)) {
                                    foreach ($sub_nv as $k => $v) {
                                        $tree[] = $v->use_id;
                                        $slAff = $v->sl;
                                    }
                                }
                            }

                            if ($value->use_group == StaffStoreUser) {

                                $tree[] = $value->use_id;
                                //Lấy danh sách CN dưới nó cua NVGH
                                $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN(' . BranchUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = ' . $value->use_id);
                                if (!empty($sub_cn)) {
                                    foreach ($sub_cn as $k => $vlue) {
                                        $tree[] = $vlue->use_id;

                                        if ($vlue->use_group == BranchUser) {
                                            // Lay DS NV-CN-NVGH
                                            $sub_nv = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = ' . StaffUser . ' AND use_status = 1 AND parent_id = ' . $vlue->use_id);
                                            if (!empty($sub_nv)) {
                                                foreach ($sub_nv as $k => $v) {
                                                    $tree[] = $v->use_id;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $parentId = implode(',', $tree);
                    $AFID = array();
                    $getAF = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . AffiliateUser . ') AND use_status = 1 AND parent_id IN(' . $parentId . ')');
                    if (!empty($getAF)) {
                        foreach ($getAF as $key => $value) {
                            $AFID[] = $value->use_id;
                        }
                    }
                    $afAll = implode(',', $AFID);
                    $data['orders'] = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . ')', $page);
                    if (!empty($liststore)) {
                        foreach ($liststore as $key => $row) {
                            $p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $row['af_id']);
                            $Str = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $p->parent_id);
                            $info_parent = '';
                            $haveDomain = '';
                            $pshop = '';

                            if ($Str->use_group == AffiliateStoreUser) {
                                $info_parent .= 'GH: ' . $Str->use_username;
                            } elseif ($Str->use_group == BranchUser) {
                                $info_parent = 'CN: ' . $Str->use_username;
                                $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                if (!empty($pa_cn)) {
                                    if ($pa_cn->use_group == AffiliateStoreUser) {
                                        $info_parent .= ', GH: ' . $pa_cn->use_username;
                                    } else {
                                        if ($pa_cn->use_group == StaffStoreUser) {
                                            $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
                                            $info_parent .= ', NVGH: ' . $pa_cn->use_username . ', GH: ' . $pa_nvgh->use_username;
                                        }
                                    }
                                }
                            } elseif ($Str->use_group == StaffStoreUser) {
                                $info_parent = 'NVGH: ' . $Str->use_username;
                                $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
                                if (!empty($pa_cn) && $pa_cn->use_group == AffiliateStoreUser) {
                                    $info_parent .= ', GH: ' . $pa_cn->use_username;

                                }
                            } elseif ($Str->use_group == StaffUser) {
                                $info_parent = 'NV: ' . $Str->use_username;
                                $pa_nv = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                if (!empty($pa_nv) && $pa_nv->use_group == BranchUser) {
                                    $info_parent .= ', CN: ' . $pa_nv->use_username;
                                    $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_nv->parent_id);
                                    if (!empty($pa_cn) && $pa_cn->use_group == AffiliateStoreUser) {
                                        $info_parent .= ', GH: ' . $pa_cn->use_username;
                                    }
                                } elseif (!empty($pa_nv) && $pa_nv->use_group == AffiliateStoreUser) {
                                    $info_parent .= ', GH: ' . $pa_nv->use_username;
                                }
                            } else {
                            }
                            $LArray[] = array(
                                'info_parent' => $info_parent,
                                'parentId' => $Str->use_id
                            );
                        }
                    }
                    $data['info_parent'] = $LArray;
                    break;
                default:
                    $afId = (int)$this->session->userdata('sessionUser');
                    $data['orders'] = $this->af_order_model->getAfList(array('tbtt_showcart.af_id ' => $afId), $page);

                    break;
            }

            $this->load->model('shop_model');
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $data['shop'] = $shop;
            $data['shopid'] = $shop->sho_id;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'showcart';
            $data['pager'] = $this->af_order_model->pager;
            $data['sort'] = $this->af_order_model->getAdminSort();
            $data['link'] = base_url() . $link;
            $data['status'] = $this->af_order_model->getStatus();
            $data['filter'] = $this->af_order_model->getFilter();
            $data['num'] = $page;

            $this->load->view('home/affiliate/orders', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function orders($page = 0)
    {
        if ($this->session->userdata('sessionUser')) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateUser
                || $group_id == StaffStoreUser
                || $group_id == StaffUser
            ) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
            $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            if ($getVar['page'] != false && $getVar['page'] != '') {
                $start = $getVar['page'];
            } else {
                $start = 0;
            }
            $page = $getVar['page'];
            //BEGIN lay domain cua parent AF
            $data = array();
            $get_u = $this->user_model->fetch_join('use_id, parent_id, use_group, sho_link, domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$this->session->userdata('sessionUser') . '"');
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $data['protocol'] = $protocol;
            switch ($get_u[0]->use_group)  {
                case AffiliateUser:
                    $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                    if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                        if ($get_p[0]->domain != '') {
                            $parent = $get_p[0]->domain;
                        } else {
                            $parent = $get_p[0]->sho_link;
                        }
                    } else {
                        if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                            $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                            if ($get_p1[0]->domain != '') {
                                $parent = $get_p1[0]->domain;
                            } else {
                                $parent = $get_p1[0]->sho_link;
                            }
                        } else {
                            $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                            if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                if ($get_p1[0]->domain != '') {
                                    $parent = $get_p2[0]->domain;
                                } else {
                                    $parent = $get_p2[0]->sho_link;
                                }
                            }
                        }
                    }
                    break;
            }
            $data['parent'] = $parent;
            //END lay domain cua parent AF
            $link = 'account/affiliate/orders';
            $this->load->model('af_order_model');
            $this->af_order_model->pagination(TRUE);
            $this->af_order_model->setLink($link);
            /*Lay don hang cua nhung af duoi nvgh*/
            /*END Lay don hang cua nhung af duoi nvgh*/
            $use_landding = '';
            switch ($this->session->userdata('sessionGroup')) {
                case StaffStoreUser:
                case StaffUser:
                    $pageSort = '';
                    $pageUrl = '';
                    $action = array('search', 'keyword', 'sort', 'by', 'process', 'id', 'page');
                    $getVar = $this->uri->uri_to_assoc(4, $action);
                    #If sort
                    if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
                        switch (strtolower($getVar['sort'])) {
                            case 'customer':
                                $pageUrl .= '/sort/customer';
                                $sort = "use_fullname";
                                break;
                            case 'product':
                                $pageUrl .= '/sort/product';
                                $sort = "pro_name";
                                break;
                            case 'cost':
                                $pageUrl .= '/sort/cost';
                                $sort = "pro_cost";
                                break;
                            case 'quantity':
                                $pageUrl .= '/sort/quantity';
                                $sort = "shc_quantity";
                                break;
                            case 'buydate':
                                $pageUrl .= '/sort/buydate';
                                $sort = "shc_buydate";
                                break;
                            default:
                                $pageUrl .= '/sort/id';
                                $sort = "shc_id";
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
                    /*loc don hang cho trong GH*/
                    $saler = '';
                    if ($this->session->userdata('sessionGroup') == AffiliateStoreUser || $this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser) {
                        $tree = array();
                        $GH = (int)$this->session->userdata('sessionUser');
                        if ($this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser) {
                            $getp = $this->user_model->fetch('use_id,parent_id', 'use_id = ' . (int)$this->session->userdata('sessionUser'));
                            $tree[] = $GH = (int)$getp[0]->parent_id;
                        }

                        $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ') AND use_status = 1 AND parent_id = "' . $this->session->userdata('sessionUser') . '"');
                        if (!empty($sub_tructiep)) {
                            foreach ($sub_tructiep as $key => $value) {
                                //Nếu là chi nhánh, lấy danh sách nhân viên
                                if ($value->use_group == StaffStoreUser) {
                                    //Lấy danh sách CN dưới nó cua NVGH
                                    $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN(' . BranchUser . ') AND use_status = 1 AND parent_id = ' . $value->use_id);
                                    if (!empty($sub_cn)) {
                                        foreach ($sub_cn as $k => $vlue) {
                                            $tree[] = $vlue->use_id;
                                        }
                                    }
                                } else {
                                    $tree[] = $value->use_id;
                                }
                            }
                        }
                        $id = implode(",", $tree);
                        $saler = ' AND ((tbtt_showcart.shc_saler=' . $GH . ' AND pro_of_shop=0)';
                        if (!empty($id)) {
                            $saler .= ' OR ((tbtt_showcart.shc_saler IN(' . $id . ')) AND pro_of_shop>0)';
                        }
                        $saler .= ')';
                    } else {
                        if ($this->session->userdata('sessionGroup') == BranchUser) {
                            $saler = ' AND tbtt_showcart.shc_saler = ' . (int)$this->session->userdata('sessionUser');
                        }
                    }
                    //end loc

                    $tree = array();
                    $tree[] = $this->session->userdata('sessionUser');
                    $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ',' . AffiliateUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = "' . $this->session->userdata('sessionUser') . '"');
                    if (!empty($sub_tructiep)) {
                        foreach ($sub_tructiep as $key => $value) {
                            $tree[] = $value->use_id;
                            //Nếu là chi nhánh, lấy danh sách nhân viên
                            if ($value->use_group == BranchUser) {
                                $sub_nv = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = ' . StaffUser . ' AND use_status = 1 AND parent_id = ' . $value->use_id);
                                if (!empty($sub_nv)) {
                                    foreach ($sub_nv as $k => $v) {
                                        $tree[] = $v->use_id;
                                        $slAff = $v->sl;
                                    }
                                }
                            }

                            if ($value->use_group == StaffStoreUser) {

                                $tree[] = $value->use_id;
                                //Lấy danh sách CN dưới nó cua NVGH
                                $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN(' . BranchUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = ' . $value->use_id);
                                if (!empty($sub_cn)) {
                                    foreach ($sub_cn as $k => $vlue) {
                                        $tree[] = $vlue->use_id;

                                        if ($vlue->use_group == BranchUser) {
                                            // Lay DS NV-CN-NVGH
                                            $sub_nv = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = ' . StaffUser . ' AND use_status = 1 AND parent_id = ' . $vlue->use_id);
                                            if (!empty($sub_nv)) {
                                                foreach ($sub_nv as $k => $v) {
                                                    $tree[] = $v->use_id;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $parentId = implode(',', $tree);                                    
                    $getAF = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN ('. AffiliateUser .') AND use_status = 1 AND parent_id IN('. $parentId .')');

                    $AFID = array();
                    $AFID[] = $this->session->userdata('sessionUser');
                    if (!empty($getAF)) {
                        foreach ($getAF as $key => $value) {
                            $AFID[] = $value->use_id;
                        }
                    }
                    $afAll = implode(',', $AFID);
                    #BEGIN: Pagination
                    $this->load->library('pagination');
                    #Count total record
                    $idCN = '';
                    if (!empty($parentId)) {
                        $idCN = ',' . $parentId;
                    }
                    $limit = settingOtherAccount;
                    // $totalRecord = count($this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . $idCN . ')', '', ''));
                    $totalRecord = count($this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ')' . $saler, '', ''));
                    $config['base_url'] = base_url() . 'account/affiliate/orders' . $pageUrl . '/page/';
                    $config['total_rows'] = $totalRecord;
                    $config['per_page'] = $limit;
                    $config['num_links'] = 1;
                    $config['cur_page'] = $start;
                    $this->pagination->initialize($config);
                    $data['pager'] = $this->pagination->create_links();
                    $data['num'] = $start;
                    #END Pagination
                    // $data['orders'] = $liststore = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . $idCN . ')', $start, $limit);
                    $data['orders'] = $liststore = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ')' . $saler, $start, $limit);
                    $data['filter'] = $this->af_order_model->getFilter();
                    if (!empty($liststore)) {
                        foreach ($liststore as $key => $row) {
                            $p = $this->user_model->get('use_id, use_username, use_group, parent_id as pID', 'use_id = ' . $row['afId']);
                            $Str = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . (int)$p->pID);
                            $info_parent = '';

                            if ($Str->use_group == 3) {
                                $info_parent .= 'GH: ' . $Str->use_username;
                            } elseif ($Str->use_group == 14) {
                                $info_parent = 'CN: ' . $Str->use_username;
                                $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                if (!empty($pa_cn)) {
                                    if ($pa_cn->use_group == AffiliateStoreUser) {
                                        $info_parent .= ', GH: ' . $pa_cn->use_username;
                                    } else {
                                        if ($pa_cn->use_group == StaffStoreUser) {
                                            $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
                                            $info_parent .= ', NVGH: ' . $pa_cn->use_username . ', GH: ' . $pa_nvgh->use_username;
                                        }
                                    }
                                }
                            } elseif ($Str->use_group == 15) {
                                $info_parent = 'NVGH: ' . $Str->use_username;
                                $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                $pa_nvgh = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_cn->parent_id);
                                if (!empty($pa_cn) && $pa_cn->use_group == AffiliateStoreUser) {
                                    $info_parent .= ', GH: ' . $pa_cn->use_username;

                                }
                            } elseif ($Str->use_group == 11) {
                                $info_parent = 'NV: ' . $Str->use_username;
                                $pa_nv = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $Str->parent_id);
                                if (!empty($pa_nv) && $pa_nv->use_group == 14) {
                                    $info_parent .= ', CN: ' . $pa_nv->use_username;
                                    $pa_cn = $this->user_model->get('use_username, use_group, parent_id', 'use_id = ' . $pa_nv->parent_id);
                                    if (!empty($pa_cn) && $pa_cn->use_group == 3) {
                                        $info_parent .= ', GH: ' . $pa_cn->use_username;
                                    }
                                } elseif (!empty($pa_nv) && $pa_nv->use_group == 3) {
                                    $info_parent .= ', GH: ' . $pa_nv->use_username;
                                }
                            } else {
                            }
                            $LArray[] = array(
                                'info_parent' => $info_parent,
                                'parentId' => $Str->use_id
                            );
                        }
                    }
                    $data['info_parent'] = $LArray;
                    break;
                default:
                    $afId = (int)$this->session->userdata('sessionUser');
                    $data['orders'] = $orders = $this->af_order_model->getAfList(array('tbtt_showcart.af_id' => $afId), $page);
                    $this->load->model('shop_model');
                    $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
                    $data['shop'] = $shop;
                    $data['shopid'] = $shop->sho_id;
                    $data['pager'] = $this->af_order_model->pager;
                    $data['sort'] = $this->af_order_model->getAdminSort();
                    $data['link'] = base_url() . $link;
                    $data['status'] = $this->af_order_model->getStatus();
                    $data['filter'] = $this->af_order_model->getFilter();
                    $data['num'] = $page;
                    break;
            }
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'showcart';

            $this->load->view('home/affiliate/orders', $data);

        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function statistic($page = 0)
    {
        if ($this->session->userdata('sessionUser')) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateUser
            ) {

            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
            $afId = (int)$this->session->userdata('sessionUser');
            $this->load->model('af_commision_model');
            $this->af_commision_model->pagination(TRUE);

            $data = array();
            $this->load->model('shop_model');
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $data['shop'] = $shop;
            $data['shopid'] = $shop->sho_id;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate';
            //$data['orders'] = $this->af_commision_model->getList(array('tbtt_commission.use_id' => $afId), $page);
            $data['orders'] = $this->af_commision_model->getList(array('user_id' => $afId), $page);
            $data['pager'] = $this->af_commision_model->pager;
            $data['sort'] = $this->af_commision_model->getAdminSort();
            $data['link'] = base_url() . $this->af_commision_model->getRoute('statistic');
            $data['status'] = $this->af_commision_model->getStatus();
            //$data['types'] = $this->af_commision_model->getType();
            $data['filter'] = $this->af_commision_model->getFilter();
            $data['num'] = $page;
            $this->load->view('home/affiliate/statistic', $data);


        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }

    function loadCategoryHot($parent, $level)
    {
        $retArray = '';

        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent' and cat_hot = 1 ";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");

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
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");

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
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        return $categoryRoot;
    }

    function configaffiliate($af_id = 0)
    {
        $af_id = (int)$af_id;
        if ($this->session->userdata('sessionUser')) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateStoreUser && $af_id > 0) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
        }
        $group_id = $this->session->userdata('sessionGroup');
        $ctv_data = $this->user_model->get('use_fullname','use_id = ' . $af_id);
        $ctv_data->af_id = $af_id;
        $data['ctv_data'] = $ctv_data;
        $sort = 'id';
        $by = 'DESC';
        $sortUrl = '';
        $pageUrl = '';
        $pageSort = '';
        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'min':
                    $pageUrl .= '/sort/title';
                    $sort = "min";
                    break;
                case 'percent':
                    $pageUrl .= '/sort/nhanvien';
                    $sort = "percent";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "id";

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

        #BEGIN: Pagination
        $data['sortUrl'] = base_url() . 'account/affiliate/configaffiliate/'. $af_id . $sortUrl . '/sort';
        $this->load->library('pagination');

        $totalRecord = count($this->commissionaffilite_model->get("*", "af_id = $af_id"));
        $config['base_url'] = base_url() . 'account/affiliate/configaffiliate/' . $af_id . '/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAccount;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $limit = 20;
        $config['cur_page'] = $start;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $data['stt'] = $start;
        #END Pagination

        $liststore = $this->commissionaffilite_model->fetch("*", "af_id = " . $af_id, $sort, $by, $start, $limit);
	    $data['menuPanelGroup'] = 4;   
        $data['menuSelected'] = 'affiliate';
        $data['menuType'] = 'account';
        #Load View
        $data['list_doanhthu'] = $liststore;

        // if ($this->session->userdata('sessionGroup') == AffiliateUser) {
        //     $data = $data;
        //     return $data;
        // }
        #Load view
        $this->load->view('home/account/tree/configaffiliate', $data);
    }

    function addcommissonaffiliate($af_id = 0, $commission_id = 0)
    {
        if (!$this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home')) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        $flag = false;
        $af_id = (int)$af_id;
        $commission_id = (int)$commission_id;
        $ctv_data = $this->user_model->get('use_fullname, parent_id','use_id = ' . $af_id);
        $ctv_data->af_id = $af_id;
        $data['ctv_data'] = $ctv_data;

        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        // $getVar = $this->uri->uri_to_assoc(3, $action);
        $this->load->library('form_validation');
        #END Set message
        $this->form_validation->set_rules('min', '0', 'required');
        $this->form_validation->set_rules('max', '0', 'required');
        $this->form_validation->set_rules('percent', '0', 'required');
        $this->form_validation->set_message('min', $this->lang->line('_is_phone_message'));

        $val_num = $this->commissionaffilite_model->get("MAX(max) as val_num","af_id = $af_id")->val_num;
        if(empty($val_num)) {
            $val_num = 0;
        } 

        if ($this->form_validation->run() != FALSE) {
            $dataEdit = array(
                '`sho_user`' => (int)$this->session->userdata('sessionUser'),
                '`af_id`' => $af_id,
                '`desc`' => 'Thưởng doanh số',
                '`min`' => (int)$this->input->post('min'),
                '`max`' => (int)$this->input->post('max'),
                '`percent`' => (int)$this->input->post('percent'),
                '`createdate`' => strtotime(date('Y/m/d', time())),
                '`superior_id`' => $ctv_data->parent_id
            );            

            if((int)$this->input->post('min') > $val_num && (int)$this->input->post('max') > (int)$this->input->post('min')) {
                $flag = true;                
            } else {               
                $this->session->set_flashdata('msg_error', 'Khoảng doanh thu không hơp lệ');                
            }
        }
        // dd($dataEdit);die;
        if ($commission_id > 0) {
            $get = $this->commissionaffilite_model->fetch("*", "id = '" . $commission_id . "'", '', '', '', '');
            $data['desc'] = $get->desc;
            $data['min'] = $get[0]->min; // get domain parent user
            $data['max'] = $get[0]->max;  // get group parent user
            $data['percent'] = $get[0]->percent;  // get group parent user
            if ($flag == true) {
                if ($this->commissionaffilite_model->update($dataEdit, "id = " . $commission_id)) {
                    redirect(base_url() . 'account/affiliate/configaffiliate/'.$af_id , 'location');
                }
            }
        } else {
            if ($flag == true) {
                $this->commissionaffilite_model->add($dataEdit);
                redirect(base_url() . 'account/affiliate/configaffiliate/'.$af_id, 'location');
            }
        }
        
        $data['menuPanelGroup'] = 4;
        $data['menuSelected'] = 'affiliate';
        $data['menuType'] = 'account';

        #Load View
        $data['val_num'] = $val_num;
        $data['msg_error'] = $this->session->flashdata('msg_error');
        $this->load->view('home/account/tree/addcommissonaffiliate', $data);
    }

    function deletecommissionaff($af_id, $c_id)
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateStoreUser) {
            } else {
                redirect(base_url() . "account", 'location');
                die();
            }
        }
        if ($this->commissionaffilite_model->delete($c_id)) {
            redirect(base_url() . 'account/affiliate/configaffiliate/' . $af_id , 'location');
        }
    }

    // function configforuseraff($user_af)
    // {
    //     if ($this->session->userdata('sessionUser') > 0) {
    //         $group_id = $this->session->userdata('sessionGroup');
    //         if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser) {
    //         } else {
    //             redirect(base_url() . "account", 'location');
    //             die();
    //         }
    //     }

    //     $sort = 'id';
    //     $by = 'DESC';
    //     $sortUrl = '';
    //     $pageUrl = '';
    //     $pageSort = '';
    //     $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
    //     $getVar = $this->uri->uri_to_assoc(4, $action);
    //     #If have page
    //     if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
    //         $start = (int)$getVar['page'];
    //         $pageSort .= '/page/' . $start;
    //     } else {
    //         $start = 0;
    //     }

    //     #BEGIN: Pagination
    //     $this->load->library('pagination');
    //     $totalRecord = count($this->commissionaffilite_model->get("*", ""));
    //     $config['base_url'] = base_url() . 'account/affiliate/configforuseraff' . $pageUrl . '/page/';
    //     $config['total_rows'] = $totalRecord;
    //     $config['per_page'] = settingOtherAccount;
    //     $config['num_links'] = 1;
    //     $config['uri_segment'] = 4;
    //     $limit = 20;
    //     $config['cur_page'] = $start;

    //     $this->pagination->initialize($config);
    //     $data['linkPage'] = $this->pagination->create_links();
    //     $data['stt'] = $start;
    //     #END Pagination

    //     $aff_name = $this->user_model->get("use_id, use_username", "use_id = " . $user_af);
    //     $list_commiss_sho = $this->commissionaffilite_model->fetch("id, sho_user, min, max, percent", "sho_user = " . (int)$this->session->userdata('sessionUser'), $sort, $by, $start, $limit);
    //     if (empty($list_commiss_sho)) {
    //         $data['nullCommissionAff'] = 'Chưa có cấu hình chung các mức thưởng thêm cho Cộng tác viên online. Hãy click <a href="' . base_url() . 'account/affiliate/addcommissonaffiliate">vào đây</a> để cấu hình.';
    //     } else {
    //         $check_commiss_aff = $this->detail_commission_aff_model->get("*", "aff_id = " . $user_af);
    //         $L_Array1 = array();
    //         if ($check_commiss_aff) {
    //             $l_array = array();
    //             $a_com = explode(',', $check_commiss_aff->commissid_percent);
    //             foreach ($list_commiss_sho as $key => $value) {
    //                 $tick = true;
    //                 for ($i = 0; $i < count($a_com); $i++) {
    //                     $b_com = explode(':', $a_com[$i]);
    //                     if ($value->id == $b_com["0"]) {
    //                         $l_array[] = array(
    //                             'id' => $value->id,
    //                             'shop_user' => $value->sho_user,
    //                             'min' => $value->min,
    //                             'max' => $value->max,
    //                             'percent' => $b_com["1"]
    //                         );
    //                         $tick = true;
    //                         break;
    //                     } else {
    //                         $tick = false;
    //                         continue;
    //                     }
    //                 }
    //                 if ($tick == false) {
    //                     $l_array[] = array(
    //                         'id' => $value->id,
    //                         'shop_user' => $value->sho_user,
    //                         'min' => $value->min,
    //                         'max' => $value->max,
    //                         'percent' => $value->percent
    //                     );
    //                 }
    //                 $L_Array1[] = $l_array;
    //             }
    //         } else {
    //             foreach ($list_commiss_sho as $key => $value) {
    //                 $l_array[] = array(
    //                     'id' => $value->id,
    //                     'shop_user' => $value->sho_user,
    //                     'min' => $value->min,
    //                     'max' => $value->max,
    //                     'percent' => $value->percent
    //                 );
    //             }
    //             $L_Array1[] = $l_array;
    //         }
    //     }
	//     $data['menuPanelGroup'] = 3; 
    //     $data['menuSelected'] = 'affiliate';
    //     $data['menuType'] = 'account';
    //     $data['list_commiss_sho'] = end($L_Array1);
    //     $data['aff_name'] = $aff_name;
    //     #Load View
    //     $this->load->view('home/account/tree/configforuseraff', $data);
    // }

    function Update_Commission_Aff_Ajax()
    {
        // $id = $this->input->post('id');
        // $commission = $this->input->post('commission');
        // $userid = $this->input->post('userid');
        $id = $this->uri->segment(4);
        $userid = $this->uri->segment(5);
        $commission = $this->uri->segment(6);
        if (isset($id) && $id > 0) {
            //Kiem tra no da duoc cau hinh rieng chua
            $check_commiss_aff = $this->detail_commission_aff_model->get("*", "aff_id = " . $userid);
            if ($check_commiss_aff) {
                $str = '';
                $a_com = explode(',', $check_commiss_aff->commissid_percent);
                for ($i = 0; $i < count($a_com); $i++) {
                    $b_com = explode(':', $a_com[$i]);
                    if ((int)$b_com["0"] == $id) {
                    } else {
                        $str .= $a_com[$i] . ',';
                    }
                }

                $string = $str . $id . ':' . $commission;
                $dataUp = array(
                    'commissid_percent' => $string
                );
                if ($this->detail_commission_aff_model->update($dataUp, "aff_id = " . $userid)) {
                    die('2');
                    exit();
                }
            } else {
                $dataAd = array(
                    'aff_id' => $userid,
                    'commissid_percent' => $id . ':' . $commission,
                    'note' => strtotime(date('Y/m/d', time())) . ' commission'
                );
                if ($this->detail_commission_aff_model->add($dataAd)) {
                    die('1');
                    exit();
                }
            }
        } else {
            die('-1');
            exit();
        }
    }

    function pickup()
    {
        if ($this->session->userdata('sessionUser') > 0) {
            $group_id = $this->session->userdata('sessionGroup');
            if ($group_id == AffiliateStoreUser || $group_id == BranchUser) {
            } else {
                redirect(base_url() .'account', 'location');
                die();
            }
            
            $data = array();
            $get_shop = $this->user_model->fetch_join('sho_user, sho_id, sho_name','INNER','tbtt_shop','use_id = sho_user', 'use_status = 1 and use_group = 3 and sho_status = 1 and use_id != ' . $this->session->userdata('sessionUser'),'sho_name','ASC');
            
            $data['listShop'] = $get_shop;
            
            if(count($get_shop) > 0){
                $listshop = array();
                foreach ($get_shop as $items){
                    $listshop[] = $items->sho_user;
                }
                $liststore = implode(',', $listshop);
            }

            if($liststore != ''){
                //SORT
                $pageSort = '';
                $pageUrl = '';
                $sort = '';
                $by = '';

                $action = array('keyword', 'sort', 'by', 'page', 'key');
                $getVar = $this->uri->uri_to_assoc(5, $action);
                #If have page
                if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
                    $start = (int)$getVar['page'];
                    $pageSort .= '/page/' . $start;
                } else {
                    $start = 0;
                }
                $limit = settingOtherAccount;
                #END Sort
                
                $segment = $this->uri->segment(4); 
                $type = 0;
                $this->session->unset_userdata('sessionType');
                $txttype = 'product';
                if($segment == 'coupon'){ 
                    $type = 2; 
                    $txttype = 'coupon';
                    $this->session->set_userdata('sessionType', $segment);
                }

                if($this->uri->segment(5) != 'page'){
                    $this->session->unset_userdata('sessionProname');
                    $this->session->unset_userdata('sessionCategory0');
                    $this->session->unset_userdata('sessionListstore');
                    $this->session->unset_userdata('sessionTu');
                    $this->session->unset_userdata('sessionDen');
                    $this->session->unset_userdata('sessionUnit');
                }
                $dachon = $this->product_affiliate_user_model->fetch('pro_id','use_id = '.(int)$this->session->userdata('sessionUser'));
                $arr = array();

                foreach($dachon as $item){
                    $arr[] = $item->pro_id;
                }

                $proid = implode(',', $arr);
                if($proid != ''){
                    $where = ' AND pro_id NOT IN(' . $proid . ')';
                }
                //SEARCH
                
                //SEARCH THEO TÊN SẢN PHẨM
                //$keyw = $this->input->post('search');
                if($this->input->post('search')){
                    $this->session->set_userdata('sessionProname', $this->input->post('search'));
                }
                if($this->session->userdata('sessionProname')){
                    $srproname = $this->session->userdata('sessionProname');                    
                    $where .= ' AND pro_name like "%'. $srproname .'%"'; 
                }
                $data['keyword'] = $srproname;
                
                //Get catlist cap 0
                $cat_level_0 = $this->category_model->fetch("cat_id, cat_name", "parent_id = 0 AND cat_status = 1 AND cate_type = " . $type, "cat_name", "ASC");
                $data['catlevel0'] = $cat_level_0;
                
                //SEARCH THEO DANH MỤC
                if($this->input->post('category0')){
                    $this->session->set_userdata('sessionCategory0', $this->input->post('category0'));
                }                
                if($this->session->userdata('sessionCategory0')){
                    
                    $srcat = $this->session->userdata('sessionCategory0');                    
                    $cat_level_1 = $this->category_model->fetch("cat_id", "parent_id = " . $srcat . " AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
                    if(!empty($cat_level_1)){
                        $listcat = '';
                        $arr1 = array();
                        foreach ($cat_level_1 as $item1){
                            $arr1[] = $item1->cat_id;
                        }
                        $strarr1 = implode(',', $arr1);
                        if($strarr1 != ''){
                            $listcat = $strarr1; // Lay danh sach cat cap 1
                            $cat_level_2 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr1 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
                            if(!empty($cat_level_2)){
                                $arr2 = array();
                                foreach ($cat_level_2 as $item2){
                                    $arr2[] = $item2->cat_id;
                                }
                                $strarr2 = implode(',', $arr2);
                                if($strarr2 != ''){
                                    $listcat .= ','. $strarr2; // Lay danh sach cat cap 2
                                    $cat_level_3 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr2 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
                                    
                                    if(!empty($cat_level_3)){
                                        $arr3 = array();
                                        foreach ($cat_level_3 as $item3){
                                            $arr3[] = $item3->cat_id;
                                        }
                                        $strarr3 = implode(',', $arr3);
                                        if($strarr3 != ''){
                                            $listcat .= ','. $strarr3; // Lay danh sach cat cap 3
                                            $cat_level_4 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr3 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
                                        
                                            if(!empty($cat_level_4)){
                                                $arr4 = array();
                                                foreach ($cat_level_4 as $item4){
                                                    $arr4[] = $item4->cat_id;
                                                }
                                                $strarr4 = implode(',', $arr4);
                                                if($strarr4 != ''){
                                                    $listcat .= ','. $strarr4; // Lay danh sach cat cap 4
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $where .= ' AND pro_category IN('. $listcat . ')';
                        }
                    }
                    $data['srcat'] = $this->session->userdata('sessionCategory0');
                }
                
                //SEARCH THEO GIAN HÀNG
                if($this->input->post('liststore')){
                    $this->session->set_userdata('sessionListstore', $this->input->post('liststore'));
                }
                if($this->session->userdata('sessionListstore')){
                    $srstore = $this->session->userdata('sessionListstore');
                    $data['srstore'] = $srstore;
                    $where .= ' AND sho_id = '. $srstore;
                }
                
                //SEARCH theo gia
                
                /*if ($this->input->post('df') && $this->input->post('dt')) {
                    if ($this->input->post('sr_commission') == 0) {
                        $where .= ' AND pro_cost >= '. $this->input->post('df') .' AND pro_cost <= '. $this->input->post('dt');
                    } elseif ($this->input->post('sr_commission') == 1) {
                        $where .= ' AND af_amt >= '. $this->input->post('df') .' AND af_amt <= '. $this->input->post('dt');
                    } elseif ($this->input->post('sr_commission') == 2) {
                        $where .= ' AND af_rate >= '. $this->input->post('df') .' AND af_rate <= '. $this->input->post('dt');
                    }
                }*/
                //INPUT GIA TU, GIA DEN
                
                if($this->input->post('df')){
                    $this->session->set_userdata('sessionTu', $this->input->post('df'));
                }
                if($this->input->post('dt')){
                    $this->session->set_userdata('sessionDen', $this->input->post('dt'));
                }
                
                //DON VI SR: GIA, HOA HONG TIEN, HOA HONG %
                if ($this->input->post('sr_commission') > 0) {
                    $this->session->set_userdata('sessionUnit',$this->input->post('sr_commission'));
                }
                
                //DUA VAO SQL
                
                if($this->session->userdata('sessionUnit') && $this->session->userdata('sessionUnit') != ''){
                    if($this->session->userdata('sessionUnit') == 1){
                        $w = ' AND pro_cost'; //SEARCH THEO GIA
                    }
                    if($this->session->userdata('sessionUnit') == 2){
                        $w = ' AND af_amt > 0 AND af_amt'; //SEARCH THEO HOA HONG TIEN
                    }
                    if($this->session->userdata('sessionUnit') == 3){
                        $w = ' AND af_rate > 0 AND af_rate'; //SEARCH THEO HOA HONG %
                    }
                    $unit = $this->session->userdata('sessionUnit');
                }
                
                if($this->session->userdata('sessionTu') && $this->session->userdata('sessionTu') != ''){
                    $tu = $this->session->userdata('sessionTu');
                    $where .= $w . ' >= ' . $tu;
                }
                if($this->session->userdata('sessionDen') && $this->session->userdata('sessionDen') != ''){
                    $den = $this->session->userdata('sessionDen');
                    $where .= $w . ' <= ' . $den;
                }
                $filter['df'] = isset($tu) ? $tu : '';
                $filter['dt'] = isset($den) ? $den : '';
                $filter['unit'] = isset($unit) ? $unit : '';
                
                $data['filter'] = $filter;
                
                //END SEARCH
                
                $select = 'pro_id, pro_name, pro_category, pro_dir, pro_image, pro_cost, af_amt, af_rate, sho_name, sho_link, domain';
                $data['products'] = $this->product_model->fetch_join1($select, 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_user IN ('. $liststore .') AND pro_type = '. (int)$type . $where, $by, $sort, $start, $limit);
                //PAGE
                //#BEGIN: Pagination
                $this->load->library('pagination');
                $totalRecord = count($this->product_model->fetch_join1($select,'INNER','tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user','pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND pro_user IN (' . $liststore . ') AND pro_type = ' . (int)$type . $where));
                $config['base_url'] = '/account/affiliate/pickup/' . $segment . '/page/';
                $config['total_rows'] = $totalRecord;
                $config['per_page'] = $limit;
                $config['num_links'] = 2;
                $config['uri_segment'] = 6;
                $config['cur_page'] = $start;
                $this->pagination->initialize($config);
                $data['stt'] = $start + 1;
                $data['linkPage'] = $this->pagination->create_links();
                #END Pagination
            }

            $data['segment'] = $segment;
            $data['typepro'] = $txttype;
            $data['menuType'] = 'account';
            $data['menuSelected'] = 'affiliate_store';
            $data['menuPanelGroup'] = 3;

            # Load view
            $this->load->view('home/affiliateshop/pickup', $data);
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
    }
    
    function ajaxpickup()
    {
        $userId = $this->session->userdata('sessionUser');
        $proid = (int)$this->input->post('product_id');        
        if ($proid > 0) {
            $check_pro = $this->product_affiliate_user_model->check(array('use_id' => $userId, 'pro_id' => $proid));

            if ($check_pro) {                
                //UPdate 
                $return = $this->product_affiliate_user_model->delete(array('use_id' => $userId, 'pro_id' => $proid));
                echo '2'; exit();
            } else {
                // Add
                $this->product_affiliate_user_model->add(array('use_id' => $userId, 'pro_id' => $proid, 'homepage' => 1, 'date_added' => time(), 'kind_of_aff' => 1));
            }            
            echo '1'; exit();
        } else {
            echo '0'; exit();
        }
    }
    
    function depot()
    {
        $userId = $this->session->userdata('sessionUser');
        if (! $this->session->userdata('sessionUser')) {
            redirect(base_url() .'login', 'location'); die;
        }
        //SORT
        $pageSort = '';
        $sort = '';
        $by = '';

        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $limit = settingOtherAccount;
        #END Sort
        $segment = $this->uri->segment(4); 
        $type = 0;
        $txttype = 'product';
        if($segment=='coupon'){ 
            $type = 2; 
            $txttype = 'coupon';
        }
        $data['typepro'] = $txttype;
        $data['segment'] = $segment;
        
        
        if($this->uri->segment(5) != 'page'){
            $this->session->unset_userdata('sessionProname');
            $this->session->unset_userdata('sessionCategory0');
            $this->session->unset_userdata('sessionListstore');
            $this->session->unset_userdata('sessionGiatu');
            $this->session->unset_userdata('sessionGiaden');
        }
        //Lay danh sach gian hang da chon ban
        $listsho = $this->product_affiliate_user_model->fetch_join('sho_id, pro_category','INNER','tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id', 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', '', '', '', 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND tbtt_product_affiliate_user.use_id = '. $userId .' AND pro_type = '.(int)$type);
        $strlevel0 = '';
        $arr_cat = array();
        $arr_shop = array();
        foreach ($listsho as $item){
            $arr_cat[] = $item->pro_category;
            $arr_shop[] = $item->sho_id;
        }
        $strsho = implode(',', $arr_shop);
        if($strsho != ''){
            $get_shop = $this->user_model->fetch_join('sho_user, sho_id, sho_name','INNER','tbtt_shop','use_id = sho_user', 'use_status = 1 and use_group = 3 and sho_status = 1 AND sho_id IN(' . $strsho . ')','sho_name','ASC');
            $data['listShop'] = $get_shop;
        }
        
        //LAY RA DANH SACH CAC DANH MUC CAP 0 TU SAN PHAM DA CHON BAN
        
        if(!empty($arr_cat)){
            $level4 = implode(',', $arr_cat);
            if($level4 != ''){
                $strlevel0 = $level4;
                $get_category_leve4 = $this->category_model->fetch("cat_id, cat_name,cat_level, parent_id", "cat_status = 1 AND cate_type = " . $type . " AND cat_id IN(" . $level4 .")");
                if(count($get_category_leve4) > 0){
                    foreach ($get_category_leve4 as $items4){
                        $level_3[] = $items4->parent_id;
                    }
                    $level3 = implode(',', $level_3);
                    if($level3 != ''){
                        $strlevel0 .= ',' . $level3;
                        $get_category_leve3 = $this->category_model->fetch("cat_id, cat_name,cat_level, parent_id", "cat_status = 1 AND cate_type = " . $type . " AND cat_id IN(" . $level3 .")");
                        if($get_category_leve3){
                            foreach ($get_category_leve3 as $key => $items3){
                                $level_2[] = $items3->parent_id;
                            }
                            $level2 = implode(',', $level_2);
                            if($level2 != ''){
                                $strlevel0 .= ',' . $level2;
                                $get_category_leve2 = $this->category_model->fetch("cat_id, cat_name,cat_level, parent_id", "cat_status = 1 AND cate_type = " . $type . " AND cat_id IN(" . $level2 .")");
                                if($get_category_leve2){
                                    foreach ($get_category_leve2 as $key => $items2){
                                        $level_1[] = $items2->parent_id;
                                    }
                                    $level1 = implode(',', $level_1);
                                    if($level1 != ''){
                                        $strlevel0 .= ',' . $level1;
                                        $get_category_leve1 = $this->category_model->fetch("cat_id, cat_name,cat_level, parent_id", "cat_status = 1 AND cate_type = " . $type . " AND cat_id IN(" . $level1 .")");
                                        if($get_category_leve1){
                                            foreach ($get_category_leve1 as $key => $items1){
                                                $level_0[] = $items1->parent_id;
                                            }
                                            $level0 = implode(',', $level_0);
                                            if($level0 != ''){
                                                $strlevel0 .= ',' . $level0;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if($strlevel0 != ''){
            $cat_level_0 = $this->category_model->fetch("cat_id, cat_name", "parent_id = 0 AND cat_status = 1 AND cat_id IN(" . $strlevel0 . ") AND cate_type = " . $type, "cat_name", "ASC");
            $data['catlevel0'] = $cat_level_0;
        
        }
        //END LAY DANH MUC CAP 0 THONG QUA SAN PHAM DA CHON BAN
        
        /*LOC THEO DANH MUC*/
        
        if($this->input->post('category0')){
            $this->session->set_userdata('sessionCategory0', $this->input->post('category0'));
        }
        
        if($this->session->userdata('sessionCategory0')){
            $srcat = $this->session->userdata('sessionCategory0');
            $data['srcat'] = $srcat;
            
            //tìm ra danh sach danh mục con khi search danh muc cap 0
            
            $cat_level_1 = $this->category_model->fetch("cat_id", "parent_id = " . $srcat . " AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
            if(!empty($cat_level_1)){
                $listcat = '';
                $arr1 = array();
                foreach ($cat_level_1 as $item1){
                    $arr1[] = $item1->cat_id;
                }
                $strarr1 = implode(',', $arr1);
                if($strarr1 != ''){
                    $listcat = $strarr1; // Lay danh sach cat cap 1
                    $cat_level_2 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr1 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");
                    if(!empty($cat_level_2)){
                        $arr2 = array();
                        foreach ($cat_level_2 as $item2){
                            $arr2[] = $item2->cat_id;
                        }
                        $strarr2 = implode(',', $arr2);
                        if($strarr2 != ''){
                            $listcat .= ','. $strarr2; // Lay danh sach cat cap 2
                            $cat_level_3 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr2 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");

                            if(!empty($cat_level_3)){
                                $arr3 = array();
                                foreach ($cat_level_3 as $item3){
                                    $arr3[] = $item3->cat_id;
                                }
                                $strarr3 = implode(',', $arr3);
                                if($strarr3 != ''){
                                    $listcat .= ','. $strarr3; // Lay danh sach cat cap 3
                                    $cat_level_4 = $this->category_model->fetch("cat_id", "parent_id IN(" . $strarr3 . ") AND cat_status = 1 AND cate_type = " . $type, "cat_service, cat_order, cat_id", "ASC");

                                    if(!empty($cat_level_4)){
                                        $arr4 = array();
                                        foreach ($cat_level_4 as $item4){
                                            $arr4[] = $item4->cat_id;
                                        }
                                        $strarr4 = implode(',', $arr4);
                                        if($strarr4 != ''){
                                            $listcat .= ','. $strarr4; // Lay danh sach cat cap 4
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $where .= ' AND pro_category IN('. $listcat . ')';
                }
            }
            //Ket thuc tim kim danh sach danh muc con từ danh mục cap 0
        }
        
        /*END LOC SP THEO DANH MUC*/

        //LOC SAN PHAM THEO GIAN HANG
        if($this->input->post('liststore')){
            $this->session->set_userdata('sessionListstore', $this->input->post('liststore'));
        }
        if($this->session->userdata('sessionListstore')){
            $srstore = $this->session->userdata('sessionListstore');
            $data['srstore'] = $srstore;
            $where .= ' AND sho_id = '. $srstore;
        }
        /*END LOC SP THEO GIAN HANG*/
        
        //SEARCH THEO TÊN SẢN PHẨM
        if($this->input->post('search')){
            $this->session->set_userdata('sessionProname', $this->input->post('search'));
        }
        if($this->session->userdata('sessionProname')){
            $srproname = $this->session->userdata('sessionProname');                    
            $where .= ' AND pro_name like "%'. $srproname .'%"'; 
        }
        $data['keyword'] = $srproname;
        
        if($this->input->post('df')){
            $this->session->set_userdata('sessionGiatu', $this->input->post('df'));
        }
        if($this->input->post('dt')){
            $this->session->set_userdata('sessionGiaden', $this->input->post('dt'));
        }
        
        if($this->session->userdata('sessionGiatu') && $this->session->userdata('sessionGiatu') != ''){
            $giatu = $this->session->userdata('sessionGiatu');
            $where .= ' AND pro_cost >= ' . $giatu;
        }
        if($this->session->userdata('sessionGiaden') && $this->session->userdata('sessionGiaden') != ''){
            $giaden = $this->session->userdata('sessionGiaden');
            $where .= ' AND pro_cost <= ' . $giaden;
        }
        $filter['df'] = isset($giatu) ? $giatu : '';
        $filter['dt'] = isset($giaden) ? $giaden : '';
        $data['filter'] = $filter;
        //END SEARCH
        
        $select = 'tbtt_product.pro_id, pro_name, sho_id, pro_dir, pro_category, pro_image, pro_cost, af_amt, af_rate, sho_link, domain, sho_name';
        $data['products'] = $this->product_affiliate_user_model->fetch_join($select,'INNER','tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id', 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', '', '', '', 'pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND tbtt_product_affiliate_user.use_id = '. $userId .' AND pro_type = '.(int)$type . $where, $sort, $by, $start, $limit);
        
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_store';
        
        //#BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->product_affiliate_user_model->fetch_join('tbtt_product.pro_id', 'INNER', 'tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id', 'INNER', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user','','','','pro_status = 1 AND sho_status = 1 AND is_product_affiliate = 1 AND tbtt_product_affiliate_user.use_id = '. $userId .' AND pro_type = '.(int)$type . $where, 'tbtt_product_affiliate_user.pro_id'));
        $config['base_url'] = base_url() .'account/affiliate/depot/'. $segment .'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        
        #END Pagination
        $this->load->view('home/affiliateshop/depot', $data);
    }

    function shop_statistic()
    {
        $userId = (int)$this->session->userdata('sessionUser');
        $user_id_arr = array((int)$this->session->userdata('sessionUser'));
        
        $this->load->model('order_model');
        $groupBy = 'id';
        $where = 'tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser') . ' AND tbtt_showcart.shc_status IN(01,02,03,98)';
        
        $currentDate_first = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $currentDate_after = mktime(23, 59, 59, date('m'), date('d'), date('Y'));;

        $data['menuPanelGroup'] = 3;
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'affiliate_statistic';
        
        // tong so san pham het hang
        $this->load->model('product_model');
        $whereTmp = "pro_status = 1 and pro_instock = 0  and pro_user = " . $userId;
        $products = $this->product_model->fetch("pro_id, pro_name, pro_user", $whereTmp, "pro_id", "DESC", '', '');
        $data['products'] = count($products);
        // Tong so affiliate
        
        #sTT - So thu tu

        $this->load->library('utilSlv');
        $this->util = new utilSlv();
        $this->load->model('statistics_model');
        //tổng doanh thu đơn hàng
        
        $data['page'] = array(
            'title' => 'Thống kê tổng doanh thu đơn hàng'
        );

        if ($this->input->post('daterange')) {
            $date_range = explode("_", $this->input->post('date_range'));
            $begin_date = $date_range[0] . ' 00:00:00';
            $end_date = $date_range[1] . ' 23:59:00';

            $_begin_date = $date_range[0];
            $_end_date = $date_range[1];

            $data['daterange'] = $this->input->post('daterange');
            $data['date_range'] = $this->input->post('date_range');
        } else {
            //mặc định cách 1 tuần
            $begin_date = date("Y-m-d 00:00:00", strtotime("-1 week"));
            $end_date = date("Y-m-d 23:59:00");

            $_begin_date = date("Y-m-d", strtotime("-1 week"));
            $_end_date = date("Y-m-d");
        }
        $daunam = date("Y-01-01 00:00:00");

        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $last_month = date("Y-m", strtotime("-1 month"));
        $end_yesterday = date("Y-m-d", strtotime("-1 day")) . ' 23:59:00';
        $begin_yesterday = date("Y-m-d", strtotime("-1 day")) . ' 00:00:00';
        $end_last_month = $last_month . '-' . date("t", strtotime($last_month . '-01')) . ' 23:59:00';
        $begin_last_month = $last_month . '-01 00:00:00';// tong don hang moi
        
        $new_order = $this->order_model->fetch_join4('*', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where . ' and tbtt_showcart.shc_status IN (01,02,03,98) and change_status_date >= ' . $currentDate_first . ' and change_status_date <=' . $currentDate_after, '', '', '', '', '', $groupBy);
        $data['totaldonhanghnay'] = count($new_order);

        // tong don hang        
        $total_order = $this->order_model->fetch_join4('*', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where, '', '', '', '', '', $groupBy);
        $data['total_order'] = count($total_order);
        
        $select = 'shc_total, em_discount, tbtt_showcart.af_rate, tbtt_showcart.af_amt, shc_quantity';
        
        //Doanh số hôm nay
        $total_re = $this->order_model->fetch_join4($select, 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where . ' and change_status_date >= ' . $currentDate_first . ' and change_status_date <=' . $currentDate_after, '', '', '', '', '', '');
        $dshnay = 0;
        foreach ($total_re as $vals) {
            $tong = 0;
            if($vals->af_rate > 0){
                $tong = $vals->shc_total + $vals->em_discount;
                $tongds = $tong * $vals->af_rate / 100;
            }else{
                $tongds = $vals->af_amt * $vals->shc_quantity;
            }
            $dshnay += $tongds;
        }
        $data['total_re'] = $dshnay;

        //Doanh số hôm qua
        $total_hqua = $this->order_model->fetch_join4($select, 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where . ' and change_status_date <= ' . strtotime($end_yesterday) . ' and change_status_date >=' . strtotime($begin_yesterday), '', '', '', '', '', '');
        $tongHQ = 0;
        foreach ($total_hqua as $vals) {
            $tong = 0;
            if($vals->af_rate > 0){
                $tong = $vals->shc_total + $vals->em_discount;
                $tongds = $tong * $vals->af_rate / 100;
            }else{
                $tongds = $vals->af_amt * $vals->shc_quantity;
            }
            $tongHQ += $tongds;
        }
        $data['sales_yesterday'] = $tongHQ;

        //doanh số tháng trước
        $static_last_month = $this->statistics_model->getOrders(strtotime($begin_last_month), strtotime($end_last_month), '', $where);// . ' GROUP BY id'
        $tongTTrc = 0;
        foreach ($static_last_month as $vals) {
            if($vals->af_rate > 0){
                $tong = $vals->shc_total + $vals->em_discount;
                $tongTTrc += $tong * $vals->af_rate / 100;
            }else{
                $tongTTrc += $vals->af_amt * $vals->shc_quantity;
            }
        }
        $data['last_month'] = $tongTTrc;

        //doanh số tháng này
        $end_current_month = date("Y-m-d H:i:s");
        $begin_current_month = date("Y-m") . '-01 00:00:00';
        $static_current_month = $this->statistics_model->getOrders(strtotime($begin_current_month), strtotime($end_current_month), '', $where);
        $tongTNay = 0;
        foreach ($static_current_month as $vals) {
            $tong = 0;
            if($vals->af_rate > 0){
                $tong = $vals->shc_total + $vals->em_discount;
                $tongds = $tong * $vals->af_rate / 100;
            }else{
                $tongds = $vals->af_amt * $vals->shc_quantity;
            }
            $tongTNay += $tongds;
        }
        
        $data['current_month'] = $tongTNay;
        
        // Tong doanh so
        $total_dt = $this->order_model->fetch_join4($select, 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where, '', '', '', '', '', '');
        $tongDT = 0;
        foreach ($total_dt as $vals) {
            $tong = 0;
            if($vals->af_rate > 0){
                $tong = $vals->shc_total + $vals->em_discount;
                $tongds = $tong * $vals->af_rate / 100;
            }else{
                $tongds = $vals->af_amt * $vals->shc_quantity;
            }
            $tongDT += $tongds;
        }
        $data['total'] = $tongDT;
        
        //Thu nhập hiện tại
        
        $data['current_earnings'] = $this->statistics_model->getCurrentEarningsStatistics('public', date("m-Y"), $user_id_arr);

        //Chart-----------------------------
        
        if ($this->input->post('options_tad') == "2") {
            $services_day['tad'] = "frm_revenues";
        } else {
            $services_day['tad'] = "frm_orders";
        }

        if ($services_day['tad'] == "frm_orders") {
            $dayx = $this->statistics_model->getQuantityOrder(strtotime($begin_date), strtotime($end_date), 'day', $where);
            $monthx = $this->statistics_model->getQuantityOrder(strtotime($daunam), strtotime($end_date), 'month', $where);
            $yearx = $this->statistics_model->getQuantityOrder(strtotime($daunam), strtotime($end_date), 'year', $where);
            $services_day['title'] = "Thống kê tổng số lượng đơn hàng theo";
            $services_day['arrayToDataTable'] = "Số lượng";
        } else {
            $dayx = $this->statistics_model->getOrders(strtotime($begin_date), strtotime($end_date), 'day', $where);
            $monthx = $this->statistics_model->getOrders(strtotime($daunam), strtotime($end_date), 'month', $where);
            $yearx = $this->statistics_model->getOrders(strtotime($daunam), strtotime($end_date), 'year', $where);
            $services_day['title'] = "Thống kê tổng doanh thu đơn hàng theo";
            $services_day['arrayToDataTable'] = "Đơn hàng";
        }
        foreach ($this->util->getDatesFromRange($_begin_date, $_end_date) as $vals) {
            $tongngay = 0;
            for ($i = 0; $i < count($dayx); $i++) {
                if ($dayx[$i]->updated_date == $vals) {
                    if ($this->input->post('options_tad') == "2") {
                        $tong = 0;
                        if($dayx[$i]->af_rate > 0){
                            $tong = $dayx[$i]->shc_total + $dayx[$i]->em_discount;
                            $tongds = $tong * $dayx[$i]->af_rate / 100;
                        }else{
                            $tongds = $dayx[$i]->af_amt * $dayx[$i]->shc_quantity;
                        }
                        $tongngay += $tongds;
                   }else{
                       $tongngay += $dayx[$i]->shc_total;
                   }
                }
            }
            if ($tongngay) {
                $amountD = $tongngay;
            } else {
                $amountD = 0;
            }
            $services_day['dayx'] .= '["' . date("d-m-Y", strtotime($vals)) . '", ' . $amountD . ', "#a3a7b2"],';
        }
        
        //month
        
        foreach ($this->util->getMonthFromRange() as $valsM) {
            $tongthang = 0;
            for ($i = 0; $i < count($monthx); $i++) {
                if ($monthx[$i]->updated_date == $valsM) {
                    if ($this->input->post('options_tad') == "2") {
                        $tong = 0;
                        if($monthx[$i]->af_rate > 0){
                            $tong = $monthx[$i]->shc_total + $monthx[$i]->em_discount;
                            $tongds = $tong * $monthx[$i]->af_rate / 100;
                        }else{
                            $tongds = $monthx[$i]->af_amt * $monthx[$i]->shc_quantity;
                        }
                        $tongthang += $tongds;
                    }else{
                        $tongthang += $monthx[$i]->shc_total;
                    }
                }
            }
            if ($tongthang) {
                $amountM = $tongthang;
            } else {
                $amountM = 0;
            }
            $services_day['monthx'] .= '["T' . $valsM . '", ' . $amountM . ', "#a3a7b2"],';
        }
        
        //year
        
        foreach ($this->util->getYearFromRange(date("Y", time())) as $valsY) {
            $tongnam = 0;
            for ($i = 0; $i < count($yearx); $i++) {
                if ($yearx[$i]->updated_date == $valsY) {
                    if ($this->input->post('options_tad') == "2") {
                        $tong = 0;
                        if($monthx[$i]->af_rate > 0){
                            $tong = $yearx[$i]->shc_total + $yearx[$i]->em_discount;
                            $tongds = $tong * $yearx[$i]->af_rate / 100;
                        }else{
                            $tongds = $yearx[$i]->af_amt * $yearx[$i]->shc_quantity;
                        }
                        $tongnam += $tongds;
                    }else{
                       $tongnam += $yearx[$i]->shc_total;
                   }
                }
            }
            if ($tongnam) {
                $amountY = $tongnam;
            } else {
                $amountY = 0;
            }
            $services_day['yearx'] .= '["' . $valsY . '", ' . $amountY . ', "#a3a7b2"],';
        }
        
        $data['service_charts'] = $this->load->view('home/account/statistic/order_charts', $services_day, true);
        if (isset($_REQUEST) && $_REQUEST['show'] == "earn") {
            $data['group_3_charts'] = FALSE;
        } else {
            $data['group_3_charts'] = TRUE;
        }
        
        $data['CountGetAllOrder'] = $this->order_model->getOrderStatistic();
        $data['sales_last_month'] = $this->statistics_model->getOrdersStatistics($yesterday, $yesterday + 86400, 'day');
        $this->load->view('home/affiliateshop/shop_statistic', $data);
    }

    function shop_income()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id != StaffUser && $group_id != NormalUser) {

        } else {
            redirect(base_url() . "account", 'location');
            die();
        }
        $linkParrams = array();
        $this->load->model('account_model');
        $isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
        $this->account_model->pagination($isPaging);
        $data = array();
        $filter = array();
        $requesP = $_REQUEST;
        $uid = (int)$this->session->userdata('sessionUser');
        $filter['where'] = array();
        $filter['page'] = $page;
        $filter['where']['user_id'] = $uid;
        $filter['where']['status'] = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
        $linkParrams[] = 'status=' . $filter['where']['status'];

        $ctype = isset($_REQUEST['ctype']) ? $_REQUEST['ctype'] : '';
        if ($ctype != '') {
            $filter['where']['type'] = $ctype;
            $linkParrams[] = 'ctype=' . $ctype;
        }else {
            $filter['where']['type'] = '06';
        }

        $month = isset($_REQUEST['month']) ? $_REQUEST['month'] : '';
        $year = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
        if (!isset($_REQUEST['month'])) {
            $month = date("m", strtotime("-1 months"));
            $year = date("Y", strtotime("-1 months"));
        }
        if ($month != '' && $year != '') {
            $filter['where']['month_year'] = $month . '-' . $year;
            $linkParrams[] = 'month=' . $month;
            $linkParrams[] = 'year=' . $year;
            $requesP['month'] = $month;
            $requesP['year'] = $year;
        } else {
            $defaultMonth = date('m-Y', strtotime('first day of last month'));
            $filter['where']['month_year'] = $defaultMonth;
            list($month, $year) = explode('-', $defaultMonth);
            $linkParrams[] = 'month=' . $month;
            $linkParrams[] = 'year=' . $year;
            $requesP['month'] = $month;
            $requesP['year'] = $year;
        }

        $filter['select'] = 'tbtt_money.*';
        $filter['select'] .= ', DATE_FORMAT(created_date, \'%d/%m/%Y %h:%i\') AS created_date';
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $requesP['sort'] = $sort;
        $requesP['dir'] = $dir;
        switch ($sort) {
            case 'group':
                $filter['order_by'] = "group_id $dir , id desc";
                break;
            case 'amount':
                $filter['order_by'] = "amount $dir , id desc";
                break;
            case 'created_date':
                $filter['order_by'] = "created_date $dir , id desc";
                break;
            default:
                $filter['order_by'] = "id desc";
        }
        $filter['sufix'] = '?' . implode('&', array_merge($linkParrams, array('sort=' . $sort, 'dir=' . $dir)));
        $filter['link'] = base_url() . 'account/income/user';
        $data['status'] = $this->account_model->getPaymentStatus();
        //Remove type 5, 6
        unset($data['status'][4]);
        unset($data['status'][5]);
        $data['user'] = $this->account_model->getUserInfo($uid);
        $data['accounts'] = $this->account_model->getAccounts($filter);
        $data['pager'] = $this->account_model->pager;
        $data['num'] = $page;
        $data['sort'] = $this->account_model->getAdminSort($linkParrams);
        $data['groups'] = $this->account_model->getUserGroup();
        $data['types'] = $this->account_model->getFilterType();
        $data['ctypes'] = $this->account_model->getCommissionType();
        $data['link'] = base_url() . 'account/income/user';
        $data['filter'] = $requesP;
        $amountFilter = array(
            'where' => array(
                'user_id' => $uid
            ),
            'where_not_in' => array(
                'status' => array(9)
            )
        );
        $data['user']['havingAmount'] = $this->account_model->getAccountAmount($amountFilter);

        $bankingFilter = array(
            'where' => array(
                'user_id' => $uid,
                'status' => 1
            )
        );
        $data['user']['bankingAmount'] = $this->account_model->getAccountAmount($bankingFilter);
        $data['menuPanelGroup'] = 3;
	$data['menuSelected'] = 'affiliate_income';
        $data['menuType'] = 'account';
        
        $this->load->model('commission_model');
        $whereCommission = array();
        $commissionList = array();
        foreach ($data['accounts'] as $key => $value) {
            $whereCommission['user_id'] = $value['user_id'];
            $whereCommission['group_id'] = $value['group_id'];
            $whereCommission['parent_id'] = $value['parent_id'];
            //$whereCommission['CAST(commission AS DECIMAL(20, 2)) = '] =  $value['amount'];
            $whereCommission['type'] = $value['type'];
            $whereCommission['commission_month'] = $value['month_year'];
            $commissionItem = $this->commission_model->get('*', $whereCommission);
            $commissionItem->moneyId = $value['id'];
            $commissionList[$value['id']] = $commissionItem;
        }
        $data['commissionList'] = $commissionList;
        $this->load->view('home/affiliateshop/shop_income', $data);
    }

    function shop_temp_income() {

        $this->load->model('package_user_model');
        $group_id = $this->session->userdata('sessionGroup');

        if ($group_id != StaffUser && $group_id != NormalUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }
        if($this->uri->segment(4) != 'page'){
            $this->session->unset_userdata('month');
            $this->session->unset_userdata('year');
        }

        $month_af = $this->input->post('month_af');
        $year_af = $this->input->post('year_af');
        if (isset($month_af) && (int)$month_af > 0 && isset($year_af) && (int)$year_af > 0) {
            $this->session->set_userdata('month', $month_af);
            $this->session->set_userdata('year', $year_af);
        }
        
        if ($this->session->userdata('month') > 0 && $this->session->userdata('year') > 0) {
            $firstday = mktime(0, 0, 0, $this->session->userdata('month'), 1, $this->session->userdata('year'));
            $currentday = strtotime('first day of next month', $firstday);
        } else {
            $firstday = mktime(0, 0, 0, date("m"), 1, date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        }
        
        $data['month_af'] = $this->session->userdata('month');
        $data['year_af'] = $this->session->userdata('year');
        
        $action = array('sort', 'by', 'page', 'statistic');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $limit = settingOtherAccount;
        
        $this->load->model('showcart_model');
        $select = 'tbtt_showcart.*, tbtt_product.pro_name, tbtt_product.pro_image, tbtt_product.pro_dir, tbtt_product.pro_cost, tbtt_product.pro_category, tbtt_detail_product.*';
        $where = 'tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser') . ' AND tbtt_showcart.shc_status IN(01,02,03,98) AND (tbtt_showcart.shc_change_status_date BETWEEN ' . $firstday . ' AND '. $currentday . ')';
        $data['provisional'] = $this->showcart_model->fetch_join($select, "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_detail_product", "tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id", $where, $sort, $by, $start, $limit);

        $iUserId = (int)$this->session->userdata('sessionUser');
        $now = date('Y-m-d');
        $start = date('Y-m-1').' 00:00:00';
        $end   = $now.' 23:59:59';
        $data['services'] = $this->package_user_model->getPackageByUserAffiliate($iUserId,$start,$end);
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->showcart_model->fetch_join('shc_orderid', "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_detail_product", "tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id", $where));
        $config['base_url'] = '/account/affiliate/shop_temp_income/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['sTT'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        
	    $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_income';
    	$data['group_id'] = $group_id;
        
        $this->load->view('home/affiliateshop/shop_temp_income', $data);
    }

    function afs_orders() {
        $group_id = $this->session->userdata('sessionGroup');
        
        if ($group_id == AffiliateStoreUser || $group_id == BranchUser) {
        } else {
            redirect(base_url() .'account', 'location'); die();
        }
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');

        $getVar = $this->uri->uri_to_assoc(5, $action);
        
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $limit = settingOtherAccount;
        #END Sort
        $segment = $this->uri->segment(4); 
        $type = 0;
        $txttype = 'product';
        if($segment=='coupon'){ 
            $type = 2; 
            $txttype = 'coupon';
        }
        //BEGIN lay domain cua parent AF
        $data = array();
        // Thay đổi logic mới ngày 10/09/2018
        //get list pro select sale
        // $dachon = $this->product_affiliate_user_model->fetch('pro_id','use_id = '.(int)$this->session->userdata('sessionUser'));
        // $arr = array();
        // foreach($dachon as $item){
        //     $arr[] = $item->pro_id;
        // }
        // $proid = implode(',', $arr);

        //end list sale
        
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $filter['sort'] = $sort;
        $filter['dir'] = $dir;

        // Filter date
        $filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
        $filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';

        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
        $month_fitter = isset($_REQUEST['month_fitter']) ? $_REQUEST['month_fitter'] : '';
        $year_fitter = isset($_REQUEST['year_fitter']) ? $_REQUEST['year_fitter'] : date('Y');

        $filter['status'] = $status;
        $filter['month_fitter'] = $month_fitter;
        $filter['year_fitter'] = $year_fitter;
        $data['filter'] = $filter;

        // Thay đổi logic mới ngày 10/09/2018
        // $where = 'pro_id IN(' . $proid . ') AND pro_type = ' . $type . ' AND tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser');

        $where = 'pro_type = ' . $type . ' AND tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser');

        //where status
        if($status != ''){
            $where .= ' AND order_status = ' . $status;
        }else{
            $where .= ' AND order_status IN(01,02,03,98)';
        }
        if($filter['df'] != ''){
            $where .= ' AND pro_price_original >= ' . $filter['df'];
        }
        if($filter['dt'] != ''){
            $where .= ' AND pro_price_original <= ' . $filter['dt'];
        }

        //where month
        if($month_fitter != ''){
            $startMonth = mktime(0, 0, 0, $month_fitter, 1, $year_fitter);
            $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $month_fitter, $year_fitter);
            $endMonth = mktime(23, 59, 59, $month_fitter, $numberDayOnMonth, $year_fitter);
            $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $startMonth . ' AND tbtt_showcart.shc_change_status_date <= ' . $endMonth;
        }else{
            $startMonth = mktime(0, 0, 0, 1, 1, $year_fitter);
            $endMonth = mktime(23, 59, 59, 12, $numberDayOnMonth, $year_fitter);
            $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $startMonth . ' AND tbtt_showcart.shc_change_status_date <= ' . $endMonth;
        }

        $getorder = $this->product_model->fetch_join('pro_id, shc_quantity, pro_price_original,pro_type,pro_name,tbtt_showcart.af_amt,tbtt_showcart.af_rate,
                      (SELECT
                        `text`
                      FROM
                        `tbtt_status`
                      WHERE `status_id` = tbtt_showcart.shc_status) AS pState
                      ,id,shc_total,em_discount,shc_quantity as qty, tbtt_shop.domain, tbtt_shop.sho_link, tbtt_shop.sho_id','INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user', $where, 'shc_orderid','DESC', $start, $limit);
        //END lay domain cua parent AF
        $link = 'account/affiliate/orders';
        $this->load->model('af_order_model');
        $this->af_order_model->pagination(TRUE);
        $this->af_order_model->setLink($link);
        /*Lay don hang cua nhung af duoi nvgh*/

        $data['orders'] = $getorder;
        $data['status'] = $this->af_order_model->getStatus();
        $get_domain = $this->shop_model->get('sho_link,domain', 'sho_user = "' . $this->session->userdata('sessionUser'). '"');
        $linkShopAff = $get_domain->sho_link . '.' . domain_site;
        if ($get_domain->domain != '') {
            $linkShopAff = $get_domain->domain;
        }
        $data['linkShopAff'] = $linkShopAff;
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->product_model->fetch_join('id','INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', '', '', '', $where));
        $config['base_url'] = base_url() .'account/affiliate/order/'. $segment .'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
	
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_order';
        #Load view
    	$this->load->view('home/affiliateshop/orders', $data);
    }
    
    function afs_order()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];


        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser || $group_id == BranchUser) {
        } else {
            redirect(base_url() .'account', 'location'); die;
        }
        $data['order_id'] = $orderid = $this->uri->segment(4);
        if ($data['order_id'] == "") {
            redirect(base_url() . 'account'); die;
        }
        $this->load->model('product_promotion_model');
        $select = '*, tbtt_order.id, tbtt_showcart.af_id, tbtt_showcart.af_rate, tbtt_showcart.af_amt';
        $where = 'tbtt_order.id = '. $orderid .' AND tbtt_showcart.af_id = '. (int)$this->session->userdata('sessionUser');
        $order = $this->product_model->fetch_join($select,'INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', 'INNER', 'tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id',  $where);
  
        $shop = $this->shop_model->get('sho_name,sho_link,domain','sho_user = '. $order[0]->shc_saler);
        $sho_link = $shop->sho_link .'.'. domain_site;
        if($shop->domain != ''){
            $sho_link = $shop->domain;
        }
        $data['sho_link'] = $sho_link;
        $data['shop'] = $shop;
        
        $get_domain = $this->shop_model->get('sho_link,domain', 'sho_user = "'. $this->session->userdata('sessionUser') .'"');
        $linkShopAff = $get_domain->sho_link .'.'. domain_site;
        if ($get_domain->domain != '') {
            $linkShopAff = $get_domain->domain;
        }
        $data['linkShopAff'] = $linkShopAff;

        $data['order_detail'] = $order;
        
        $this->load->model('detail_product_model');
        foreach ($order as $item){
            if ($item->pro_type == 2) {
                $pro_type = 'coupon';
            } else {
                if ($item->pro_type == 0) {
                    $pro_type = 'product';
                }
            }
            $item->link_sp = $protocol . $linkShopAff . '/shop/' . $pro_type . '/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name);
            $shopitem = $this->shop_model->get('*','sho_user = '.$item->pro_user);
            if(!empty($shopitem)) {
                if($shopitem->domain != '') {
                    $item->link_sp = $protocol . $shopitem->domain . '/shop/' . $pro_type . '/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name);
                }else {
                    $item->link_sp = $protocol . $shopitem->sho_link.'.'. $domainName . '/shop/' . $pro_type . '/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name);
                }
            }

            if($item->shc_dp_pro_id > 0){
                $qc = $this->detail_product_model->get('dp_images, dp_color, dp_size, dp_material','tbtt_detail_product.`id` = '. $item->shc_dp_pro_id);
                $quycach[$item->shc_dp_pro_id]['dp_images'] = $qc->dp_images;
                $quycach[$item->shc_dp_pro_id]['dp_color'] = $qc->dp_color;
                $quycach[$item->shc_dp_pro_id]['dp_size'] = $qc->dp_size;
                $quycach[$item->shc_dp_pro_id]['dp_material'] = $qc->dp_material;
            }
        }
        $data['quycach'] = $quycach;
        $this->load->model('province_model');
        $this->load->model('district_model');
        if ($order[0]->shipping_method == 'GHN' || $order[0]->shipping_method == 'GHTK') {
            $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('DistrictCode' => $order[0]->ord_district));
        }else{
            $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('vtp_code' => $order[0]->ord_district));
        }
        $data['_province'] = $tinhThanh->ProvinceName;
        $data['_district'] = $tinhThanh->DistrictName;
        
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_order';

    	$this->load->view('home/affiliateshop/order', $data);
    }
    
    function afs_statistic_old()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser) {
        } else {
            redirect(base_url() .'account', 'location'); die;
        }
        $action = array('sort', 'by', 'page', 'statistic');
        $getVar = $this->uri->uri_to_assoc(1, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $segment = $getVar['statistic']; 
        $type = 0;
        $txttype = 'product';
        if($segment == 'coupon'){ 
            $type = 2; 
            $txttype = 'coupon';
        }
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
        if ((isset($datefrom) && (int)$datefrom > 0) || (isset($dateto) && (int)$dateto > 0)) {
            $firstday = mktime(0, 0, 0, explode('-',$datefrom)[1], explode('-',$datefrom)[2], explode('-',$datefrom)[0]);
            $currentday = mktime(23, 59, 59, explode('-',$dateto)[1], explode('-',$dateto)[2], explode('-',$dateto)[0]);
        } else {
            $firstday = mktime(0, 0, 0, date("m"), 1, date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        }
        $data['datefrom'] = $datefrom;
        $data['dateto'] = $dateto;
        
        $this->load->model('order_model');
        $where = 'sho_status = 1 AND pro_status = 1 AND pro_type = ' . $type . ' AND shc_status IN(01,03,98) AND is_product_affiliate = 1 AND tbtt_showcart.af_id = ' . $this->session->userdata('sessionUser');
        if(($datefrom && $datefrom != '')){
            $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $firstday;
        }
        if($dateto && $dateto != ''){
            $where .= ' AND tbtt_showcart.shc_change_status_date <= ' . $currentday;
        }
        $select = 'DISTINCT shc_id, pro_id, pro_name, tbtt_order.id AS id, sum(shc_quantity) AS sl, SUM(shc_total) AS doanhso, tbtt_product.pro_category, pro_dir, pro_image, pro_cost, tbtt_showcart.af_amt, tbtt_showcart.af_rate, shc_dp_pro_id, sho_name, sho_link, domain, cat_name';//, dp_images
                  
        $limit = settingOtherAccount;
        $data['products'] = $this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", '', '', '', "INNER", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", $where . ' GROUP BY pro_id', $sort, $by, $start, $limit, '', "INNER", "tbtt_shop", "tbtt_shop.sho_user = tbtt_product.pro_user");
        
        $doanhso = 0;
        $getdso = $this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", '', '', '', "INNER", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", $where . ' GROUP BY pro_id', $sort, $by, '', '', '', "INNER", "tbtt_shop", "tbtt_shop.sho_user = tbtt_product.pro_user");
        foreach ($getdso as $key => $items){
            $doanhso += $items->doanhso;
        }
        $data['doanhso'] = $doanhso;
        //PAGE
        //#BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->order_model->fetch_join6('pro_id', "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'LEFT', 'tbtt_detail_product', 'tbtt_product.pro_id = dp_pro_id', "LEFT", "tbtt_category", "tbtt_product.pro_category = tbtt_category.cat_id", $where . ' GROUP BY pro_id', $sort, $by, '', '', '', "INNER", "tbtt_shop", "tbtt_shop.sho_user = tbtt_product.pro_user"));
        $config['base_url'] = '/account/affiliate/statistic/' . $segment . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_statistic';
    	$this->load->view('home/affiliateshop/statistic', $data);
    }

    function afs_statistic()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id != StaffUser && $group_id != NormalUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }
        
        $month_af = $this->input->post('month_af');
        $year_af = $this->input->post('year_af');
        if (isset($month_af) && (int)$month_af > 0 && isset($year_af) && (int)$year_af > 0) {
            $this->session->set_flashdata('month', $month_af);
            $this->session->set_flashdata('year', $year_af);
            echo 'd: '.$month_af.', '.$this->session->flashdata('month') .', '.$this->session->flashdata('year');
        }
        if ($this->session->flashdata('month_af') > 0 && $this->session->flashdata('year_af') > 0) {
            $firstday = mktime(0, 0, 0, $this->session->flashdata('month_af'), 1, $this->session->flashdata('year_af'));
            $currentday = strtotime('first day of next month', $firstday);
        } else {
            $firstday = mktime(0, 0, 0, date("m"), 1, date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        }
        $data['month_af'] = $month_af;
        $data['year_af'] = $year_af;
        
        $action = array('sort', 'by', 'page', 'statistic');
        $getVar = $this->uri->uri_to_assoc(4, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $limit = 2;//settingOtherAccount;
        
        $this->load->model('showcart_model');
        $select = 'tbtt_showcart.*, tbtt_product.pro_name, tbtt_product.pro_image, tbtt_product.pro_dir, tbtt_product.pro_cost, tbtt_product.pro_category, tbtt_detail_product.*';
        $where = 'tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser') . ' AND tbtt_showcart.shc_status IN(01,02,03,98) AND (tbtt_showcart.shc_change_status_date BETWEEN ' . $firstday . ' AND '. $currentday . ')';
        $data['provisional'] = $this->showcart_model->fetch_join($select, "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_detail_product", "tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id", $where, $sort, $by, $start, $limit);
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->showcart_model->fetch_join('shc_orderid', "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", "LEFT", "tbtt_detail_product", "tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id", $where));
        $config['base_url'] = '/account/affiliate/statistic/' . $this->uri->segment(4) . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        
	$data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_statistic';
    	$get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $this->session->userdata('sessionUser') . '"');
        switch ($get_u[0]->use_group) {
            case AffiliateStoreUser:
            case BranchUser:
                if ($get_u[0]->domain != '') {
                    $domain = $get_u[0]->domain;
                } else {
                    $parent = $get_u[0]->sho_link;
                }
                break;
            case StaffStoreUser:
            case StaffUser:
                $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');

                if ($get_p[0]->domain != '') {
                    $domain = $get_p[0]->domain;
                } else {
                    $parent = $get_p[0]->sho_link;
                }
                break;
            case AffiliateUser:
                $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                    if ($get_p[0]->domain != '') {
                        $domain = $get_p[0]->domain;
                    } else {
                        $parent = $get_p[0]->sho_link;
                    }
                } else {
                    if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                        $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                        if ($get_p1[0]->domain != '') {
                            $domain = $get_p1[0]->domain;
                        } else {
                            $parent = $get_p1[0]->sho_link;
                        }
                    } else {
                        $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                        if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                            $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                            if ($get_p1[0]->domain != '') {
                                $domain = $get_p2[0]->domain;
                            } else {
                                $parent = $get_p2[0]->sho_link;
                            }
                        }
                    }
                }
                break;

        }
        $data['domain'] = $domain;
        $data['parent'] = $parent;
        $this->load->view('home/affiliateshop/provisional', $data);
    }
    
    function afs_statistic_detail($orderid)
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser) {
        } else {
            redirect(base_url() .'account', 'location'); die;
        }
        $action = array('sort', 'by', 'page', 'statistic');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $segment = $getVar['statistic']; 
        $type = 0;
        $txttype = 'product';
        if($segment == 'coupon'){ 
            $type = 2; 
            $txttype = 'coupon';
        }
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
        if (isset($datefrom) && (int)$datefrom > 0 && isset($dateto) && (int)$dateto > 0) {
            $firstday = mktime(0, 0, 0, explode('-',$datefrom)[1], explode('-',$datefrom)[2], explode('-',$datefrom)[0]);
            $currentday = mktime(23, 59, 59, explode('-',$dateto)[1], explode('-',$dateto)[2], explode('-',$dateto)[0]);
        } else {
            $firstday = mktime(0, 0, 0, date("m"), 1, date("Y"));
            $currentday = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
        }
        $data['datefrom'] = $datefrom;
        $data['dateto'] = $dateto;
        
        $this->load->model('order_model');
        $where = 'pro_status = 1 AND shc_status IN(01,03,98) AND tbtt_showcart.af_id = ' . $this->session->userdata('sessionUser') . ' AND shc_product = ' . $orderid;
        
        if(($datefrom && $datefrom != '')){
            $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $firstday;
        }
        if($dateto && $dateto != ''){
            $where .= ' AND tbtt_showcart.shc_change_status_date <= ' . $currentday;
        }
        
        $limit = settingOtherAccount;
        $select = 'shc_id, shc_dp_pro_id, shc_quantity, shc_total, shc_change_status_date, affiliate_discount_amt, affiliate_discount_rate, em_discount, pro_id, pro_name, pro_price_original, pro_price_amt, pro_price_rate, tbtt_order.id AS id, tbtt_product.pro_category, pro_dir, pro_image, pro_cost, tbtt_showcart.af_amt, tbtt_showcart.af_rate, tbtt_order.af_id, dp_images, dp_color, dp_size, dp_material, use_username';
        $data['products'] = $this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'LEFT', 'tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_user_receive.use_id", $where, $sort, $by, $start, $limit, '', 'LEFT', 'tbtt_detail_product', 'tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id');
        
        $this->load->model('detail_product_model');
        foreach ($data['products'] as $item){
            if($item->shc_dp_pro_id > 0){
                $quycach = $this->detail_product_model->get('dp_images','dp_images = "'. $item->shc_dp_pro_id . '"');
            }
        }
        $data['quycach'] = $quycach;
        
        $getdso = $this->order_model->fetch_join6('shc_total', "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'LEFT', 'tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_user_receive.use_id", $where, $sort, $by, '', '', '', 'LEFT', 'tbtt_detail_product', 'tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id');
        foreach ($getdso as $key => $items){
            $doanhso += $items->shc_total;
        }
        $data['doanhso'] = $doanhso;
        
        //PAGE
        //#BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->order_model->fetch_join6($select, "INNER", "tbtt_showcart", "tbtt_order.id = tbtt_showcart.shc_orderid", "INNER", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'LEFT', 'tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', "LEFT", "tbtt_user", "tbtt_user.use_id = tbtt_user_receive.use_id", $where, $sort, $by, $start, '', '', 'LEFT', 'tbtt_detail_product', 'tbtt_detail_product.id = tbtt_showcart.shc_dp_pro_id'));
        $config['base_url'] = '/account/affiliate/statistic/detail/' . $orderid . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_statistic';
    	$this->load->view('home/affiliateshop/detail_statistic', $data);
    }

    function afs_income()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser) {
        } else {
            redirect(base_url() .'account', 'location'); die;
        }
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }
        $limit = settingOtherAccount;
        #END Sort
        $segment = $this->uri->segment(4); 
        $type = 0;
        $txttype = 'product';
        if($segment=='coupon'){ 
            $type = 2; 
            $txttype = 'coupon';
        }
        //BEGIN lay domain cua parent AF
        $data = array();
        //get list pro select sale
        $dachon = $this->product_affiliate_user_model->fetch('pro_id','use_id = '.(int)$this->session->userdata('sessionUser'));
        $arr = array();
        foreach($dachon as $item){
            $arr[] = $item->pro_id;
        }
        $proid = implode(',', $arr);
        //end list sale
        
        if($proid != ''){
        
            $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
            $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
            $dir = strtolower($dir);
            $dir = $dir == 'asc' ? 'asc' : 'desc';
            $filter['sort'] = $sort;
            $filter['dir'] = $dir;

            // Filter date
            $filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
            $filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';

            $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
            $month_fitter = isset($_REQUEST['month_fitter']) ? $_REQUEST['month_fitter'] : '';
            $year_fitter = isset($_REQUEST['year_fitter']) ? $_REQUEST['year_fitter'] : date('Y');

            $filter['status'] = $status;
            $filter['month_fitter'] = $month_fitter;
            $filter['year_fitter'] = $year_fitter;
            $data['filter'] = $filter;
            $where = 'pro_id IN(' . $proid . ') AND pro_type = ' . $type . ' AND tbtt_showcart.af_id = ' . (int)$this->session->userdata('sessionUser');

            //where status
            if($status != ''){
                $where .= ' AND order_status = ' . $status;
            }else{
                $where .= ' AND order_status IN(01,02,03,98)';
            }
            if($filter['df'] != ''){
                $where .= ' AND pro_price_original >= ' . $filter['df'];
            }
            if($filter['dt'] != ''){
                $where .= ' AND pro_price_original <= ' . $filter['dt'];
            }

            //where month
            if($month_fitter != ''){
                $startMonth = mktime(0, 0, 0, $month_fitter, 1, $year_fitter);
                $numberDayOnMonth = cal_days_in_month(CAL_GREGORIAN, $month_fitter, $year_fitter);
                $endMonth = mktime(23, 59, 59, $month_fitter, $numberDayOnMonth, $year_fitter);
                $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $startMonth . ' AND tbtt_showcart.shc_change_status_date <= ' . $endMonth;
            }else{
                $startMonth = mktime(0, 0, 0, 1, 1, $year_fitter);
                $endMonth = mktime(23, 59, 59, 12, $numberDayOnMonth, $year_fitter);
                $where .= ' AND tbtt_showcart.shc_change_status_date >= ' . $startMonth . ' AND tbtt_showcart.shc_change_status_date <= ' . $endMonth;
            }

            $getorder = $this->product_model->fetch_join('pro_id, pro_image, pro_dir, pro_price_original, pro_price_rate, pro_price_amt, affiliate_discount_amt, affiliate_discount_rate, pro_price, shc_quantity, shc_dp_pro_id,pro_type,pro_name,tbtt_showcart.af_amt,tbtt_showcart.af_rate,
                          (SELECT
                            `text`
                          FROM
                            `tbtt_status`
                          WHERE `status_id` = tbtt_showcart.shc_status) AS pState
                          ,id,shc_total,em_discount,shc_quantity as qty','INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', '', '', '', $where, '','', $start, $limit);
            $quycach = array();
            $this->load->model('detail_product_model');
            foreach ($getorder as $item){
                if($item->shc_dp_pro_id > 0){
                    $qc = $this->detail_product_model->get('dp_images','tbtt_detail_product.`id` = '. $item->shc_dp_pro_id);
                    $quycach[$item->shc_dp_pro_id] = $qc->dp_images;
                }
            }
            $data['quycach'] = $quycach;
            
            $getdoanhthu = $this->product_model->fetch_join('pro_price, shc_quantity,tbtt_showcart.af_amt,tbtt_showcart.af_rate','INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', '', '', '', $where);
            foreach ($getdoanhthu as $key => $items){
                if ($items->af_amt > 0) {
                    $hoahongnhan = $items->af_amt * $items->shc_quantity;
                } elseif ($items->af_rate > 0) {
                    $hoahongnhan = $items->pro_price * $items->shc_quantity * ($items->af_rate / 100);
                }
                $tonghh += $hoahongnhan;
            }
            $data['tonghh'] = $tonghh;
        }
        //END lay domain cua parent AF
        $link = 'account/affiliate/orders';
        $this->load->model('af_order_model');
        $this->af_order_model->pagination(TRUE);
        $this->af_order_model->setLink($link);
        /*Lay don hang cua nhung af duoi nvgh*/

        $data['orders'] = $getorder;
        $data['status'] = $this->af_order_model->getStatus();
        $get_domain = $this->shop_model->get('sho_link,domain', 'sho_user = "' . $this->session->userdata('sessionUser'). '"');
        $linkShopAff = $get_domain->sho_link . '.' . domain_site;
        if ($get_domain->domain != '') {
            $linkShopAff = $get_domain->domain;
        }
        $data['linkShopAff'] = $linkShopAff;
        //#BEGIN: Pagination
        $this->load->library('pagination');
        $totalRecord = count($this->product_model->fetch_join('id','INNER','tbtt_showcart','shc_product = pro_id','INNER','tbtt_order','shc_orderid = tbtt_order.id', '', '', '', $where));
        $config['base_url'] = base_url() .'account/affiliate/income/'.$segment.'/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start + 1;
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
	
        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 3;
        $data['menuSelected'] = 'affiliate_income';
    	$this->load->view('home/affiliateshop/income', $data);
    }

    function listUserRegister() {
        if (! $this->session->userdata('sessionUser')) {
            redirect(base_url() .'account', 'location'); die;
        }

        $select = '';
        $where = '';
        $order = '';
        $by = '';
        $start = 0;
        $limit = settingOtherAccount;

        $action = array('sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(1, $action);
        if ($getVar['page'] != false && $getVar['page'] != '') {
            $start = $getVar['page'];
        } else {
            $start = 0;
        }


        $select = 'use_id, use_username, use_group, use_email, use_mobile, use_message, sho_id, sho_link, sho_name, domain';
        $where = 'use_group = 3 AND parent_id = '.$this->session->userdata('sessionUser');
        
        $listUser = $this->user_model->fetch_join($select, 'INNER', 'tbtt_shop', 'tbtt_user.use_id = tbtt_shop.sho_user', $where, $order, $by, $start, $limit);

        $this->load->library('pagination');
        $totalRecord = count($this->user_model->fetch_join($select, 'INNER', 'tbtt_shop', 'tbtt_user.use_id = tbtt_shop.sho_user', $where));
        $config['base_url'] = '/account/affiliate/listuserregister/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 2;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['stt'] = $start;
        $data['linkPage'] = $this->pagination->create_links();
        
        // echo '<pre>'; 
        // print_r($listUser); die;

        $data['menuType'] = 'account';
        $data['menuPanelGroup'] = 4;
        $data['menuSelected'] = 'affiliate';
        $data['listUser'] = $listUser;
        $data['totalRecord'] = $totalRecord;

        #Load view
        $this->load->view('home/affiliate/listuserregister', $data);
    }
    
    public function getMainDomain()
    {
        $result = base_url();
        $sub = $this->getShopLink();
        if ($sub != '') {
            $result = str_replace('//'. $sub .'.', '//', $result);
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
} 
