<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Ctcategory extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        #BEGIN: CHECK LOGIN
        if (!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin'))) {
            redirect(base_url() . 'administ', 'location');
            die();
        }
        #END CHECK LOGIN
        #Load language
        $this->lang->load('admin/common');
        $this->lang->load('admin/category');
        #Load model
        $this->load->model('content_category_model');
    }

    function index()
    {
        #BEGIN: Delete
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->library('file');
            $this->load->model('product_model');
            $this->load->model('product_favorite_model');
            $this->load->model('product_comment_model');
            $this->load->model('product_bad_model');
            $this->load->model('ads_model');
            $this->load->model('ads_favorite_model');
            $this->load->model('ads_comment_model');
            $this->load->model('ads_bad_model');
            $this->load->model('shop_model');
            $this->load->model('showcart_model');
            $this->load->model('content_category_model');
            $idCategory = $this->input->post('checkone');
            $listIdCategory = implode(',', $idCategory);
            #Get id product
            $product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_category IN($listIdCategory)", "", "");
            $idProduct = array();
            foreach ($product as $productArray) {
                $idProduct[] = $productArray->pro_id;
                #Remove image
                if ($productArray->pro_image != 'none.gif') {
                    $imageArray = explode(',', $productArray->pro_image);
                    foreach ($imageArray as $imageArrays) {
                        if (trim($imageArrays) != '' && file_exists('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays)) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays);
                        }
                    }
                    for ($i = 1; $i <= 3; $i++) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0])) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0]);
                        }
                    }
                    if (trim($productArray->pro_dir) != '' && is_dir('media/images/product/' . $productArray->pro_dir) && count($this->file->load('media/images/product/' . $productArray->pro_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/index.html')) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/index.html');
                        }
                        @rmdir('media/images/product/' . $productArray->pro_dir);
                    }
                }
            }
            #Get id ads
            $ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_category IN($listIdCategory)", "", "");
            $idAds = array();
            foreach ($ads as $adsArray) {
                $idAds[] = $adsArray->ads_id;
                #Remove image
                if ($adsArray->ads_image != 'none.gif') {
                    if (trim($adsArray->ads_image) != '' && file_exists('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image)) {
                        @unlink('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image);
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image)) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image);
                        }
                    }
                    if (trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/' . $adsArray->ads_dir) && count($this->file->load('media/images/ads/' . $adsArray->ads_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/index.html')) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/index.html');
                        }
                        @rmdir('media/images/ads/' . $adsArray->ads_dir);
                    }
                }
            }
            #Delete product
            if (count($idProduct) > 0) {
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
            }
            $this->product_model->delete($idCategory, "pro_category");
            #Delete ads
            if (count($idAds) > 0) {
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
            }
            $this->ads_model->delete($idCategory, "ads_category");
            #Delete shop
            #Remove image
            $shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_category IN($listIdCategory)", "", "");
            foreach ($shop as $shopArray) {
                if (trim($shopArray->sho_logo) != '' && file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo)) {
                    @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo);
                }
                if (trim($shopArray->sho_dir_logo) != '' && is_dir('media/shop/logos/' . $shopArray->sho_dir_logo) && count($this->file->load('media/shop/logos/' . $shopArray->sho_dir_logo, 'index.html')) == 0) {
                    if (file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html')) {
                        @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html');
                    }
                    @rmdir('media/shop/logos/' . $shopArray->sho_dir_logo);
                }
                if (trim($shopArray->sho_banner) != '' && file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner)) {
                    @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner);
                }
                if (trim($shopArray->sho_dir_banner) != '' && is_dir('media/shop/banners/' . $shopArray->sho_dir_banner) && count($this->file->load('media/shop/banners/' . $shopArray->sho_dir_banner, 'index.html')) == 0) {
                    if (file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html')) {
                        @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html');
                    }
                    @rmdir('media/shop/banners/' . $shopArray->sho_dir_banner);
                }
            }
            $this->shop_model->delete($idCategory, "sho_category");
            #Delete showcart
            if (count($idProduct) > 0) {
                $this->showcart_model->delete($idProduct, "shc_product");
            }
            #Delete menu
            //$this->content_category_model->delete($idCategory, "men_category");
            #Delete category
            $this->content_category_model->delete($idCategory, "cat_id");
            redirect(base_url() . trim(uri_string(), '/'), 'location');
        }
        #END Delete
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Search & Filter
        $where = ' cat_type = 0';
        $sort = 'cat_order';
        $by = 'ASC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= "cat_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
        } #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'active':
                    $sortUrl .= '/filter/active/key/' . $getVar['key'];
                    $pageUrl .= '/filter/active/key/' . $getVar['key'];
                    $where .= " AND cat_status = 1";
                    break;
                case 'deactive':
                    $sortUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $pageUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $where .= " AND cat_status = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "cat_name";
                    break;
                case 'order':
                    $pageUrl .= '/sort/order';
                    $sort = "cat_order";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "cat_id";
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
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/ctcategory' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Status
        $statusUrl = $pageUrl . $pageSort;
        $data['statusUrl'] = base_url() . 'administ/ctcategory' . $statusUrl;
        if ($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->model('content_category_model');
            switch (strtolower($getVar['status'])) {
                case 'active':
                    $this->content_category_model->update(array('cat_status' => 1), "cat_id = " . (int)$getVar['id']);
                    break;
                case 'deactive':
                    $this->content_category_model->update(array('cat_status' => 0), "cat_id = " . (int)$getVar['id']);
                    break;
            }
            redirect($data['statusUrl'], 'location');
        }
        #END Status
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->content_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url() . 'administ/ctcategory' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        #Fetch record
        $limit = settingOtherAdmin;
        $retArray = array();
        $this->loadCategory(0, 0, $retArray, $where, $sort, $by);
        $data['category'] = $retArray;
        $this->load->view('admin/ctcategory/defaults', $data);
    }

    function cttintuc()
    {
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->library('file');
            $this->load->model('product_model');
            $this->load->model('product_favorite_model');
            $this->load->model('product_comment_model');
            $this->load->model('product_bad_model');
            $this->load->model('ads_model');
            $this->load->model('ads_favorite_model');
            $this->load->model('ads_comment_model');
            $this->load->model('ads_bad_model');
            $this->load->model('shop_model');
            $this->load->model('showcart_model');
            $this->load->model('content_category_model');
            $idCategory = $this->input->post('checkone');
            $listIdCategory = implode(',', $idCategory);
            #Get id product
            $product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_category IN($listIdCategory)", "", "");
            $idProduct = array();
            foreach ($product as $productArray) {
                $idProduct[] = $productArray->pro_id;
                #Remove image
                if ($productArray->pro_image != 'none.gif') {
                    $imageArray = explode(',', $productArray->pro_image);
                    foreach ($imageArray as $imageArrays) {
                        if (trim($imageArrays) != '' && file_exists('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays)) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays);
                        }
                    }
                    for ($i = 1; $i <= 3; $i++) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0])) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0]);
                        }
                    }
                    if (trim($productArray->pro_dir) != '' && is_dir('media/images/product/' . $productArray->pro_dir) && count($this->file->load('media/images/product/' . $productArray->pro_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/index.html')) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/index.html');
                        }
                        @rmdir('media/images/product/' . $productArray->pro_dir);
                    }
                }
            }
            #Get id ads
            $ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_category IN($listIdCategory)", "", "");
            $idAds = array();
            foreach ($ads as $adsArray) {
                $idAds[] = $adsArray->ads_id;
                #Remove image
                if ($adsArray->ads_image != 'none.gif') {
                    if (trim($adsArray->ads_image) != '' && file_exists('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image)) {
                        @unlink('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image);
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image)) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image);
                        }
                    }
                    if (trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/' . $adsArray->ads_dir) && count($this->file->load('media/images/ads/' . $adsArray->ads_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/index.html')) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/index.html');
                        }
                        @rmdir('media/images/ads/' . $adsArray->ads_dir);
                    }
                }
            }
            #Delete product
            if (count($idProduct) > 0) {
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
            }
            $this->product_model->delete($idCategory, "pro_category");
            #Delete ads
            if (count($idAds) > 0) {
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
            }
            $this->ads_model->delete($idCategory, "ads_category");
            #Delete shop
            #Remove image
            $shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_category IN($listIdCategory)", "", "");
            foreach ($shop as $shopArray) {
                if (trim($shopArray->sho_logo) != '' && file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo)) {
                    @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo);
                }
                if (trim($shopArray->sho_dir_logo) != '' && is_dir('media/shop/logos/' . $shopArray->sho_dir_logo) && count($this->file->load('media/shop/logos/' . $shopArray->sho_dir_logo, 'index.html')) == 0) {
                    if (file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html')) {
                        @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html');
                    }
                    @rmdir('media/shop/logos/' . $shopArray->sho_dir_logo);
                }
                if (trim($shopArray->sho_banner) != '' && file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner)) {
                    @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner);
                }
                if (trim($shopArray->sho_dir_banner) != '' && is_dir('media/shop/banners/' . $shopArray->sho_dir_banner) && count($this->file->load('media/shop/banners/' . $shopArray->sho_dir_banner, 'index.html')) == 0) {
                    if (file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html')) {
                        @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html');
                    }
                    @rmdir('media/shop/banners/' . $shopArray->sho_dir_banner);
                }
            }
            $this->shop_model->delete($idCategory, "sho_category");
            #Delete showcart
            if (count($idProduct) > 0) {
                $this->showcart_model->delete($idProduct, "shc_product");
            }
            #Delete menu
            //$this->content_category_model->delete($idCategory, "men_category");
            #Delete category
            $this->content_category_model->delete($idCategory, "cat_id");
            redirect(base_url() . trim(uri_string(), '/'), 'location');
        }
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Search & Filter
        $where = 'cat_type = 1';
        $sort = 'cat_order';
        $by = 'ASC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= " AND cat_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
        } #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'active':
                    $sortUrl .= '/filter/active/key/' . $getVar['key'];
                    $pageUrl .= '/filter/active/key/' . $getVar['key'];
                    $where .= " AND cat_status = 1";
                    break;
                case 'deactive':
                    $sortUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $pageUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $where .= " AND cat_status = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "cat_name";
                    break;
                case 'order':
                    $pageUrl .= '/sort/order';
                    $sort = "cat_order";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "cat_id";
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
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/ctcategory' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Status
        $statusUrl = $pageUrl . $pageSort;
        $data['statusUrl'] = base_url() . 'administ/ctcategory' . $statusUrl;
        if ($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->model('content_category_model');
            switch (strtolower($getVar['status'])) {
                case 'active':
                    $this->content_category_model->update(array('cat_status' => 1), "cat_id = " . (int)$getVar['id']);
                    break;
                case 'deactive':
                    $this->content_category_model->update(array('cat_status' => 0), "cat_id = " . (int)$getVar['id']);
                    break;
            }
            redirect($data['statusUrl'], 'location');
        }
        #END Status
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->content_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url() . 'administ/ctcategory' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $limit = settingOtherAdmin;
        $retArray = array();
        $this->loadCategory2(0, 0, $retArray, $where, $sort, $by ,$start, $limit);
        $data['category'] = $retArray;
        $this->load->view('admin/ctcategory/tintuc', $data);
    }

    function editttintuc($id)
    {

        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;
            #BEGIN: Get category by $id
            $category = $this->content_category_model->get("*", "cat_id = " . (int)$id);
            if (count($category) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/ctcategory', 'location');
                die();
            }
            #END Get category by $id
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = array_merge($this->file->load('templates/home/images/ctcategory', $usedImage), array($category->cat_image));
            #END Load image category
            #Begin: Category hoi dap
            $cat_parent = $this->content_category_model->get("*", "cat_id = " . (int)$category->parent_id);
            if (isset($cat_parent)) {
                if ($cat_parent->parent_id == 0) {
                    $data['parent_id_0'] = $category->parent_id;
                } else {
                    $data['parent_id_0'] = $cat_parent->parent_id;
                    $data['parent_id_1'] = $category->parent_id;
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . $cat_parent->parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
                    $data['catlevel1'] = $cat_level_1;
                }
            }
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1 and cat_type = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #End
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if ($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category')))) {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            } else {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataEdit = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'cat_status' => $active_category,
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'parent_id' => $this->input->post('parent_id'),
                    'keyword' => $this->input->post('keyword'),
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->update($dataEdit, "cat_id = " . (int)$id)) {
                    $this->session->set_flashdata('sessionSuccessEdit', 1);
                }
                redirect(base_url() . 'administ/cttintuc/edit/' . $id, 'location');
            } else {
                $data['name_category'] = $category->cat_name;
                $data['descr_category'] = $category->cat_descr;
                $data['image_category'] = $category->cat_image;
                $data['order_category'] = $category->cat_order;
                $data['active_category'] = $category->cat_status;
                $data['parent_id'] = $category->parent_id;
                $data['cat_level'] = $category->cat_level;
                $data['cat_index'] = $category->cat_index;
                $data['keyword'] = $category->keyword;
                $data['h1tag'] = $category->h1tag;
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;

        $this->load->view('admin/ctcategory/edit_tintuc', $data);
    }

    function ctdoc()
    {
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->library('file');
            $this->load->model('product_model');
            $this->load->model('product_favorite_model');
            $this->load->model('product_comment_model');
            $this->load->model('product_bad_model');
            $this->load->model('ads_model');
            $this->load->model('ads_favorite_model');
            $this->load->model('ads_comment_model');
            $this->load->model('ads_bad_model');
            $this->load->model('shop_model');
            $this->load->model('showcart_model');
            $this->load->model('content_category_model');
            $idCategory = $this->input->post('checkone');
            $listIdCategory = implode(',', $idCategory);
            #Get id product
            $product = $this->product_model->fetch("pro_id, pro_image, pro_dir", "pro_category IN($listIdCategory)", "", "");
            $idProduct = array();
            foreach ($product as $productArray) {
                $idProduct[] = $productArray->pro_id;
                #Remove image
                if ($productArray->pro_image != 'none.gif') {
                    $imageArray = explode(',', $productArray->pro_image);
                    foreach ($imageArray as $imageArrays) {
                        if (trim($imageArrays) != '' && file_exists('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays)) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/' . $imageArrays);
                        }
                    }
                    for ($i = 1; $i <= 3; $i++) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0])) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/thumbnail_' . $i . '_' . $imageArray[0]);
                        }
                    }
                    if (trim($productArray->pro_dir) != '' && is_dir('media/images/product/' . $productArray->pro_dir) && count($this->file->load('media/images/product/' . $productArray->pro_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/product/' . $productArray->pro_dir . '/index.html')) {
                            @unlink('media/images/product/' . $productArray->pro_dir . '/index.html');
                        }
                        @rmdir('media/images/product/' . $productArray->pro_dir);
                    }
                }
            }
            #Get id ads
            $ads = $this->ads_model->fetch("ads_id, ads_image, ads_dir", "ads_category IN($listIdCategory)", "", "");
            $idAds = array();
            foreach ($ads as $adsArray) {
                $idAds[] = $adsArray->ads_id;
                #Remove image
                if ($adsArray->ads_image != 'none.gif') {
                    if (trim($adsArray->ads_image) != '' && file_exists('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image)) {
                        @unlink('media/images/ads/' . $adsArray->ads_dir . '/' . $adsArray->ads_image);
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image)) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/thumbnail_3_' . $adsArray->ads_image);
                        }
                    }
                    if (trim($adsArray->ads_dir) != '' && is_dir('media/images/ads/' . $adsArray->ads_dir) && count($this->file->load('media/images/ads/' . $adsArray->ads_dir, 'index.html')) == 0) {
                        if (file_exists('media/images/ads/' . $adsArray->ads_dir . '/index.html')) {
                            @unlink('media/images/ads/' . $adsArray->ads_dir . '/index.html');
                        }
                        @rmdir('media/images/ads/' . $adsArray->ads_dir);
                    }
                }
            }
            #Delete product
            if (count($idProduct) > 0) {
                $this->product_favorite_model->delete($idProduct, "prf_product");
                $this->product_comment_model->delete($idProduct, "prc_product");
                $this->product_bad_model->delete($idProduct, "prb_product");
            }
            $this->product_model->delete($idCategory, "pro_category");
            #Delete ads
            if (count($idAds) > 0) {
                $this->ads_favorite_model->delete($idAds, "adf_ads");
                $this->ads_comment_model->delete($idAds, "adc_ads");
                $this->ads_bad_model->delete($idAds, "adb_ads");
            }
            $this->ads_model->delete($idCategory, "ads_category");
            #Delete shop
            #Remove image
            $shop = $this->shop_model->fetch("sho_logo, sho_dir_logo, sho_banner, sho_dir_banner", "sho_category IN($listIdCategory)", "", "");
            foreach ($shop as $shopArray) {
                if (trim($shopArray->sho_logo) != '' && file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo)) {
                    @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/' . $shopArray->sho_logo);
                }
                if (trim($shopArray->sho_dir_logo) != '' && is_dir('media/shop/logos/' . $shopArray->sho_dir_logo) && count($this->file->load('media/shop/logos/' . $shopArray->sho_dir_logo, 'index.html')) == 0) {
                    if (file_exists('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html')) {
                        @unlink('media/shop/logos/' . $shopArray->sho_dir_logo . '/index.html');
                    }
                    @rmdir('media/shop/logos/' . $shopArray->sho_dir_logo);
                }
                if (trim($shopArray->sho_banner) != '' && file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner)) {
                    @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/' . $shopArray->sho_banner);
                }
                if (trim($shopArray->sho_dir_banner) != '' && is_dir('media/shop/banners/' . $shopArray->sho_dir_banner) && count($this->file->load('media/shop/banners/' . $shopArray->sho_dir_banner, 'index.html')) == 0) {
                    if (file_exists('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html')) {
                        @unlink('media/shop/banners/' . $shopArray->sho_dir_banner . '/index.html');
                    }
                    @rmdir('media/shop/banners/' . $shopArray->sho_dir_banner);
                }
            }
            $this->shop_model->delete($idCategory, "sho_category");
            #Delete showcart
            if (count($idProduct) > 0) {
                $this->showcart_model->delete($idProduct, "shc_product");
            }
            #Delete menu
            //$this->content_category_model->delete($idCategory, "men_category");
            #Delete category
            $this->content_category_model->delete($idCategory, "cat_id");
            redirect(base_url() . trim(uri_string(), '/'), 'location');
        }
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #BEGIN: Search & Filter
        $where = 'cat_type = 3';
        $sort = 'cat_order';
        $by = 'ASC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'name':
                    $sortUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/name/keyword/' . $getVar['keyword'];
                    $where .= " AND cat_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
        } #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'active':
                    $sortUrl .= '/filter/active/key/' . $getVar['key'];
                    $pageUrl .= '/filter/active/key/' . $getVar['key'];
                    $where .= " AND cat_status = 1";
                    break;
                case 'deactive':
                    $sortUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $pageUrl .= '/filter/deactive/key/' . $getVar['key'];
                    $where .= " AND cat_status = 0";
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "cat_name";
                    break;
                case 'order':
                    $pageUrl .= '/sort/order';
                    $sort = "cat_order";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "cat_id";
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
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'administ/doccategory' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Status
        $statusUrl = $pageUrl . $pageSort;
        $data['statusUrl'] = base_url() . 'administ/doccategory' . $statusUrl;
        if ($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int)$getVar['id'] > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->load->model('content_category_model');
            switch (strtolower($getVar['status'])) {
                case 'active':
                    $this->content_category_model->update(array('cat_status' => 1), "cat_id = " . (int)$getVar['id']);
                    break;
                case 'deactive':
                    $this->content_category_model->update(array('cat_status' => 0), "cat_id = " . (int)$getVar['id']);
                    break;
            }
            redirect($data['statusUrl'], 'location');
        }
        #END Status
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->content_category_model->fetch("cat_id", $where, "", ""));
        $config['base_url'] = base_url() . 'administ/doccategory' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAdmin;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $limit = settingOtherAdmin;
        $retArray = array();
        $this->loadCategory2(0, 0, $retArray, $where, $sort, $by);
        $data['category'] = $retArray;
        $this->load->view('admin/ctcategory/doc', $data);
    }

    function loadCategory($parent, $level, &$retArray, $where, $sort, $by, $start, $limit)
    {
        $select = "*";
        $whereTmp = "";
        if (strlen($where) > 0) {
            $whereTmp .= $where . " and parent_id='$parent' ";
        } else {
            $whereTmp .= $where . "parent_id='$parent'";
        }
        $category = $this->content_category_model->fetch($select, $whereTmp, $sort, $by, $start, $limit);
        foreach ($category as $row) {
            $row->cat_name = $row->cat_name;
            $retArray[] = $row;
            $this->loadCategory($row->cat_id, $level + 1, $retArray, $where, $sort, $by, $start, $limit);
            //edit by nganly
        }
    }

    function loadCategory2($parent, $level, &$retArray, $where, $sort, $by, $start, $limit)
    {
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
            $this->loadCategory2($row->cat_id, $level + 1, $retArray);
            //edit by nganly
        }
    }

    function loadCategory3($parent, $level, &$retArray, $where, $sort, $by, $start, $limit)
    {
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
            $this->loadCategory3($row->cat_id, $level + 1, $retArray);
            //edit by nganly
        }
    }

    function add()
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessAdd')) {
            $data['successAdd'] = true;
        } else {
            $data['successAdd'] = false;
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = $this->file->load('templates/home/images/ctcategory', $usedImage);
            #Begin: Category hoi dap
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
            $data['next_order'] = (int)$maxorder->maxorder + 1;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #END Load image category
            $this->load->library('form_validation');
            #BEGIN: Set rules
            $this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required'); //|callback__exist_category
            // $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', '');
            $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            //$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataAdd = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'parent_id' => (int)$this->input->post('parent_id'),
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'cat_status' => $active_category,
                    'keyword' => $this->input->post('keyword'),
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->add($dataAdd)) {
                    $this->session->set_flashdata('sessionSuccessAdd', 1);
                }
                redirect(base_url() . 'administ/ctcategory/add', 'location');
            } else {
                $data['name_category'] = $this->input->post('name_category');
                $data['descr_category'] = $this->input->post('descr_category');
                $data['image_category'] = $this->input->post('image_category');
                $data['order_category'] = $this->input->post('order_category');
                $data['active_category'] = $this->input->post('active_category');
                $data['keyword'] = $this->input->post('keyword');
                $data['h1tag'] = $this->input->post('h1tag');
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        #Load view
        $this->load->view('admin/ctcategory/add', $data);
    }

    function addcttintuc()
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessAdd')) {
            $data['successAdd'] = true;
        } else {
            $data['successAdd'] = false;
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = $this->file->load('templates/home/images/ctcategory', $usedImage);
            #Begin: Category hoi dap
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1 and cat_type = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
            $data['next_order'] = (int)$maxorder->maxorder + 1;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #END Load image category
            $this->load->library('form_validation');
            #BEGIN: Set rules
            $this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required'); //|callback__exist_category
            // $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', '');
            $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            //$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataAdd = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'parent_id' => (int)$this->input->post('parent_id'),
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'cat_status' => $active_category,
                    'keyword' => $this->input->post('keyword'),
                    'cat_type' => 1,
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->add($dataAdd)) {
                    $this->session->set_flashdata('sessionSuccessAdd', 1);
                }
                redirect(base_url() . 'administ/ttcategory', 'location');
            } else {
                $data['name_category'] = $this->input->post('name_category');
                $data['descr_category'] = $this->input->post('descr_category');
                $data['image_category'] = $this->input->post('image_category');
                $data['order_category'] = $this->input->post('order_category');
                $data['active_category'] = $this->input->post('active_category');
                $data['keyword'] = $this->input->post('keyword');
                $data['h1tag'] = $this->input->post('h1tag');
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        $this->load->view('admin/ctcategory/add_tintuc', $data);
    }

    function addctdoc()
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessAdd')) {
            $data['successAdd'] = true;
        } else {
            $data['successAdd'] = false;
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = $this->file->load('templates/home/images/ctcategory', $usedImage);
            #Begin: Category hoi dap
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxorder = $this->content_category_model->get("max(cat_order) as maxorder");
            $data['next_order'] = (int)$maxorder->maxorder + 1;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #END Load image category
            $this->load->library('form_validation');
            #BEGIN: Set rules
            $this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required'); //|callback__exist_category
            // $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', '');
            $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            //$this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataAdd = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'parent_id' => (int)$this->input->post('parent_id'),
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'cat_status' => $active_category,
                    'keyword' => $this->input->post('keyword'),
                    'cat_type' => 3,
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->add($dataAdd)) {
                    $this->session->set_flashdata('sessionSuccessAdd', 1);
                }
                redirect(base_url() . 'administ/doccategory', 'location');
            } else {
                $data['name_category'] = $this->input->post('name_category');
                $data['descr_category'] = $this->input->post('descr_category');
                $data['image_category'] = $this->input->post('image_category');
                $data['order_category'] = $this->input->post('order_category');
                $data['active_category'] = $this->input->post('active_category');
                $data['keyword'] = $this->input->post('keyword');
                $data['h1tag'] = $this->input->post('h1tag');
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        #Load view
        $this->load->view('admin/ctcategory/add_doc', $data);
    }

    function edit($id)
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;
            #BEGIN: Get category by $id
            $category = $this->content_category_model->get("*", "cat_id = " . (int)$id);
            if (count($category) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/ctcategory', 'location');
                die();
            }
            #END Get category by $id
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = array_merge($this->file->load('templates/home/images/ctcategory', $usedImage), array($category->cat_image));
            #END Load image category
            #Begin: Category hoi dap
            $cat_parent = $this->content_category_model->get("*", "cat_id = " . (int)$category->parent_id);
            if (isset($cat_parent)) {
                if ($cat_parent->parent_id == 0) {
                    $data['parent_id_0'] = $category->parent_id;
                } else {
                    $data['parent_id_0'] = $cat_parent->parent_id;
                    $data['parent_id_1'] = $category->parent_id;
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . $cat_parent->parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
                    $data['catlevel1'] = $cat_level_1;
                }
            }
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #End
            $this->load->library('form_validation');
            #BEGIN: Set rules
            //$this->form_validation->set_rules('descr_category', 'lang:descr_label_edit', 'trim|required');
            //$this->form_validation->set_rules('image_category', 'lang:image_label_edit', 'required');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if ($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category')))) {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            } else {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataEdit = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'cat_status' => $active_category,
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'parent_id' => $this->input->post('parent_id'),
                    'keyword' => $this->input->post('keyword'),
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->update($dataEdit, "cat_id = " . (int)$id)) {
                    $this->session->set_flashdata('sessionSuccessEdit', 1);
                }
                redirect(base_url() . 'administ/ctcategory/edit/' . $id, 'location');
            } else {
                $data['name_category'] = $category->cat_name;
                $data['descr_category'] = $category->cat_descr;
                $data['image_category'] = $category->cat_image;
                $data['order_category'] = $category->cat_order;
                $data['active_category'] = $category->cat_status;
                $data['parent_id'] = $category->parent_id;
                $data['cat_level'] = $category->cat_level;
                $data['cat_index'] = $category->cat_index;
                $data['keyword'] = $category->keyword;
                $data['h1tag'] = $category->h1tag;
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        $this->load->view('admin/ctcategory/edit', $data);
    }

    function editcttintuc($id)
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;
            #BEGIN: Get category by $id
            $category = $this->content_category_model->get("*", "cat_id = " . (int)$id);
            if (count($category) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/ttcategory', 'location');
                die();
            }
            #END Get category by $id
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = array_merge($this->file->load('templates/home/images/ctcategory', $usedImage), array($category->cat_image));
            #END Load image category
            #Begin: Category hoi dap
            $cat_parent = $this->content_category_model->get("*", "cat_id = " . (int)$category->parent_id);
            if (isset($cat_parent)) {
                if ($cat_parent->parent_id == 0) {
                    $data['parent_id_0'] = $category->parent_id;
                } else {
                    $data['parent_id_0'] = $cat_parent->parent_id;
                    $data['parent_id_1'] = $category->parent_id;
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . $cat_parent->parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
                    $data['catlevel1'] = $cat_level_1;
                }
            }
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #End
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if ($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category')))) {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            } else {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataEdit = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'cat_status' => $active_category,
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'parent_id' => $this->input->post('parent_id'),
                    'keyword' => $this->input->post('keyword'),
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->update($dataEdit, "cat_id = " . (int)$id)) {
                    $this->session->set_flashdata('sessionSuccessEdit', 1);
                }
                redirect(base_url() . 'administ/ttcategory/' . $id, 'location');
            } else {
                $data['name_category'] = $category->cat_name;
                $data['descr_category'] = $category->cat_descr;
                $data['image_category'] = $category->cat_image;
                $data['order_category'] = $category->cat_order;
                $data['active_category'] = $category->cat_status;
                $data['parent_id'] = $category->parent_id;
                $data['cat_level'] = $category->cat_level;
                $data['cat_index'] = $category->cat_index;
                $data['keyword'] = $category->keyword;
                $data['h1tag'] = $category->h1tag;
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        $this->load->view('admin/ctcategory/edit_tintuc', $data);
    }
    function editctdoc($id)
    {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        if ($this->session->flashdata('sessionSuccessEdit')) {
            $data['successEdit'] = true;
        } else {
            $data['successEdit'] = false;
            #BEGIN: Get category by $id
            $category = $this->content_category_model->get("*", "cat_id = " . (int)$id);
            if (count($category) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/doccategory', 'location');
                die();
            }
            #END Get category by $id
            #BEGIN: Load image category
            $this->load->library('file');
            $imageCategory = $this->content_category_model->fetch("cat_image", "", "", "");
            $usedImage = array();
            foreach ($imageCategory as $imageCategoryArray) {
                $usedImage[] = $imageCategoryArray->cat_image;
            }
            $usedImage = array_merge($usedImage, array('index.html'));
            $data['image'] = array_merge($this->file->load('templates/home/images/ctcategory', $usedImage), array($category->cat_image));
            #END Load image category
            #Begin: Category hoi dap
            $cat_parent = $this->content_category_model->get("*", "cat_id = " . (int)$category->parent_id);
            if (isset($cat_parent)) {
                if ($cat_parent->parent_id == 0) {
                    $data['parent_id_0'] = $category->parent_id;
                } else {
                    $data['parent_id_0'] = $cat_parent->parent_id;
                    $data['parent_id_1'] = $category->parent_id;
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . $cat_parent->parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
                    $data['catlevel1'] = $cat_level_1;
                }
            }
            $cat_level_0 = $this->content_category_model->fetch("*", "parent_id = 0 AND cat_status = 1", "cat_order, cat_id", "ASC");
            if (isset($cat_level_0)) {
                foreach ($cat_level_0 as $key => $item) {
                    $cat_level_1 = $this->content_category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                    $cat_level_0[$key]->child_count = count($cat_level_1);
                }
            }
            $data['catlevel0'] = $cat_level_0;
            $maxindex = $this->content_category_model->get("max(cat_index) as maxindex");
            $data['next_index'] = (int)$maxindex->maxindex + 1;
            #End
            $this->load->library('form_validation');
            #BEGIN: Set rules
            //$this->form_validation->set_rules('descr_category', 'lang:descr_label_edit', 'trim|required');
            //$this->form_validation->set_rules('image_category', 'lang:image_label_edit', 'required');
            $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');
            #Expand
            if ($category->cat_name != trim($this->filter->injection_html($this->input->post('name_category')))) {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required|callback__exist_category');
            } else {
                $this->form_validation->set_rules('name_category', 'lang:name_label_edit', 'trim|required');
            }
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_edit'));
            $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('is_natural_no_zero_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                if ($this->input->post('active_category') == '1') {
                    $active_category = 1;
                } else {
                    $active_category = 0;
                }
                $dataEdit = array(
                    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
                    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
                    'cat_image' => $this->filter->injection($this->input->post('image_category')),
                    'cat_order' => (int)$this->input->post('order_category'),
                    'cat_status' => $active_category,
                    'cat_index' => (int)$this->input->post('cat_index'),
                    'cat_level' => (int)$this->input->post('cat_level'),
                    'parent_id' => $this->input->post('parent_id'),
                    'keyword' => $this->input->post('keyword'),
                    'h1tag' => $this->input->post('h1tag')
                );
                if ($this->content_category_model->update($dataEdit, "cat_id = " . (int)$id)) {
                    $this->session->set_flashdata('sessionSuccessEdit', 1);
                }
                redirect(base_url() . 'administ/doccategory/edit/' . $id, 'location');
            } else {
                $data['name_category'] = $category->cat_name;
                $data['descr_category'] = $category->cat_descr;
                $data['image_category'] = $category->cat_image;
                $data['order_category'] = $category->cat_order;
                $data['active_category'] = $category->cat_status;
                $data['parent_id'] = $category->parent_id;
                $data['cat_level'] = $category->cat_level;
                $data['cat_index'] = $category->cat_index;
                $data['keyword'] = $category->keyword;
                $data['h1tag'] = $category->h1tag;
            }
        }
        $retArray = array();
        $this->display_child(0, 0, $retArray);
        $data['parents'] = $retArray;
        $this->load->view('admin/ctcategory/edit_doc', $data);
    }

    function _exist_category()
    {
        if (count($this->content_category_model->get("cat_id", "cat_name = '" . trim($this->filter->injection_html($this->input->post('name_category'))) . "'")) > 0) {
            return false;
        }
        return true;
    }

    function display_child($parent, $level, &$retArray)
    {
        $sql = "SELECT * from `tbtt_content_category` WHERE cat_type = 1 AND parent_id='$parent' order by cat_order";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $object = new StdClass;
            $object->cat_id = $row['cat_id'];
            $object->cat_name = str_repeat('-', $level) . " " . $row['cat_name'];
            $retArray[] = $object;
            $this->display_child($row['cat_id'], $level + 1, $retArray);
            //edit by nganly
        }
    }

    function ajax()
    {
        $parent_id = (int)$this->input->post('parent_id');
        $cat_level = $this->content_category_model->fetch("*", "parent_id = " . $parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
        echo "[" . json_encode($cat_level) . "," . count($cat_level) . "]";
        exit();
    }
}