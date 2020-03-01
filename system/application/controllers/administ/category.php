<?php

#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
ini_set("memory_limit", "-1");
set_time_limit(0);

class Category extends CI_Controller {

    function __construct() {
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
	$this->load->model('category_model');
    }

    function index() {
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
	    $this->load->model('menu_model');
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
	    $this->menu_model->delete($idCategory, "men_category");
	    #Delete category
	    $this->category_model->delete($idCategory, "cat_id");
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
	$type = $this->uri->segment(3);
	if ($type == 'service') {
	    $getVar = $this->uri->uri_to_assoc(4, $action);
	    $type = '/' . $type;
	    $catype = 1;
	} elseif ($type == 'coupon') {
	    $getVar = $this->uri->uri_to_assoc(4, $action);
	    $type = '/' . $type;
	    $catype = 2;
	} else {
	    $getVar = $this->uri->uri_to_assoc(3, $action);
	    $catype = 0;
	}
	#BEGIN: Search & Filter
	$where = '';
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
		    $sortUrl .= $type . '/search/name/keyword/' . $getVar['keyword'];
		    $pageUrl .= $type . '/search/name/keyword/' . $getVar['keyword'];
		    $where .= "cat_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%' AND cate_type = $catype";
		    break;
	    }
	}
	#If filter
	elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
	    switch (strtolower($getVar['filter'])) {
		case 'active':
		    $sortUrl .= $type . '/filter/active/key/' . $getVar['key'];
		    $pageUrl .= $type . '/filter/active/key/' . $getVar['key'];
		    $where .= "cat_status = 1";
		    break;
		case 'deactive':
		    $sortUrl .= $type . '/filter/deactive/key/' . $getVar['key'];
		    $pageUrl .= $type . '/filter/deactive/key/' . $getVar['key'];
		    $where .= "cat_status = 0";
		    break;
	    }
	}
	#If sort
	if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
	    switch (strtolower($getVar['sort'])) {
		case 'name':
		    $pageUrl .= $type . '/sort/name';
		    $sort = "cat_name";
		    break;
		case 'order':
		    $pageUrl .= $type . '/sort/order';
		    $sort = "cat_order";
		    break;
		default:
		    $pageUrl .= $type . '/sort/id';
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
	if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
	    $start = (int) $getVar['page'];
	    $pageSort .= '/page/' . $start;
	} else {
	    $start = 0;
	}
	#END Search & Filter
	#Keyword
	$data['keyword'] = $keyword;

	#BEGIN: Create link sort
	$data['sortUrl'] = base_url() . 'administ/category' . $sortUrl . '/sort/';
	$data['pageSort'] = $pageSort;
	#END Create link sort
	#BEGIN: Status
	$statusUrl = $pageUrl . $pageSort;
	$data['statusUrl'] = base_url() . 'administ/category' . $type . $statusUrl;
	if ($getVar['status'] != FALSE && trim($getVar['status']) != '' && $getVar['id'] != FALSE && (int) $getVar['id'] > 0) {
	    #BEGIN: CHECK PERMISSION
	    if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
		show_error($this->lang->line('unallowed_use_permission'));
		die();
	    }
	    #END CHECK PERMISSION
	    $this->load->model('menu_model');
	    switch (strtolower($getVar['status'])) {
		case 'active':
		    $this->category_model->update(array('cat_status' => 1), "cat_id = " . (int) $getVar['id']);
		    $this->menu_model->update(array('men_status' => 1), "men_category = " . (int) $getVar['id']);
		    break;
		case 'deactive':
		    $this->category_model->update(array('cat_status' => 0), "cat_id = " . (int) $getVar['id']);
		    $this->menu_model->update(array('men_status' => 0), "men_category = " . (int) $getVar['id']);
		    break;
	    }
	    redirect($data['statusUrl'], 'location');
	}
	#END Status
	#BEGIN: Pagination
	$this->load->library('pagination');
	#Count total record
	$totalRecord = count($this->category_model->fetch("cat_id", $where, "", ""));
	$config['base_url'] = base_url() . 'administ/category' . $type . $pageUrl . '/page/';
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

	if (filesize('jsoncat.txt') == 0) {
	    $this->loadCategory2(0, 0, $retArray, $where, $sort, $by, $start, $limit);
	    $myfile = fopen("jsoncat.txt", "w") or die("Unable to open file!");
	    $jsonArray = json_encode($retArray);
	    fwrite($myfile, $jsonArray);
	    fclose($myfile);
	    $data['category'] = $retArray;
	} else {
	    if ($_REQUEST['rebuild'] == 1) {
		// Begin Build  Category to html
		$cat_id = array();
		$cat_id1 = array();
		$cat_id2 = array();

		// Danh muc san pham
		$cat_pro = $this->recursive(0);
		foreach ($cat_pro as $item) {
		    array_push($cat_id, $item->parent_id);
		}
		if (isset($cat_pro) && count($cat_pro) > 0) {
		    file_put_contents("system/application/views/home/common/catlist.php", "");
		    $html = '<select id="cat_search" name="cat_search" data-placeholder="Tìm kiếm nhanh..."  multiple class="chosen-select">';
		    foreach ($cat_pro as $item) {
			if (in_array($item->cat_id, $cat_id)) {
			    $html .= '<optgroup label="' . $item->cat_name . '"></optgroup>';
			} else {
			    $html .= '<option value="' . $item->cat_id . '">' . $item->cat_name . '</option>';
			}
		    }
		    $html .= '</select>';
		    $myfile1 = fopen("system/application/views/home/common/catlist.php", "w") or die("Unable to open file!");
		    fwrite($myfile1, $html);
		    fclose($myfile1);
		}

		// Danh muc dich vu
		$cat_service = $this->rec_sevice(0);
		foreach ($cat_service as $item_service) {
		    array_push($cat_id1, $item_service->parent_id);
		}
		if (isset($cat_service) && count($cat_service) > 0) {
		    file_put_contents("system/application/views/home/common/catlistservice.php", "");
		    $html1 = '<select id="cat_search" name="cat_search" data-placeholder="Tìm kiếm nhanh..."  multiple class="chosen-select">';
		    foreach ($cat_service as $item_service) {
			if (in_array($item_service->cat_id, $cat_id1)) {
			    $html1 .= '<optgroup label="' . $item_service->cat_name . '"></optgroup>';
			} else {
			    $html1 .= '<option value="' . $item_service->cat_id . '">' . $item_service->cat_name . '</option>';
			}
		    }
		    $html1 .= '</select>';
		    $file_service = fopen("system/application/views/home/common/catlistservice.php", "w") or die("Unable to open file!");
		    fwrite($file_service, $html1);
		    fclose($file_service);
		}

		// Danh muc coupon
		$cat_coupon = $this->rec_coupon(0);
		foreach ($cat_coupon as $item_coupon) {
		    array_push($cat_id2, $item_coupon->parent_id);
		}
		if (isset($cat_coupon) && count($cat_coupon) > 0) {
		    file_put_contents("system/application/views/home/common/catlistcoupon.php", "");
		    $html2 = '<select id="cat_search" name="cat_search" data-placeholder="Tìm kiếm nhanh..."  multiple class="chosen-select">';
		    foreach ($cat_coupon as $item_coupon) {
			if (in_array($item_coupon->cat_id, $cat_id2)) {
			    $html2 .= '<optgroup label="' . $item_coupon->cat_name . '"></optgroup>';
			} else {
			    $html2 .= '<option value="' . $item_coupon->cat_id . '">' . $item_coupon->cat_name . '</option>';
			}
		    }
		    $html2 .= '</select>';
		    $file_counpon = fopen("system/application/views/home/common/catlistcoupon.php", "w") or die("Unable to open file!");
		    fwrite($file_counpon, $html2);
		    fclose($file_counpon);
		}

		// END Build  Category to html
		file_put_contents("jsoncat.txt", "");
		$this->loadCategory2(0, 0, $retArray, $where, $sort, $by, $start, $limit);
		$myfile = fopen("jsoncat.txt", "w") or die("Unable to open file!");
		$jsonArray = json_encode($retArray);
		fwrite($myfile, $jsonArray);
		fclose($myfile);
		$data['category'] = $retArray;
	    } else {
		if ($getVar['key'] != '' || $getVar['keyword'] != '') {
		    $this->loadCategory2(0, 0, $retArray, $where, $sort, $by, $start, $limit);
		    $data['category'] = $retArray;
		} else {
		    $myfile = fopen("jsoncat.txt", "r") or die("Unable to open file!");
		    $jsonText = fread($myfile, filesize("jsoncat.txt"));
		    $arrayOfCat = json_decode($jsonText);
		    $data['category'] = $arrayOfCat;
		    fclose($myfile);
		}
	    }
	}

	$this->load->view('admin/category/defaults', $data);
    }

    function recursive($parent_id = 0, $data, $step = '', $catlv = 0) {
	$sql = "SELECT cat_id, cat_name,cat_level, parent_id, cate_type from `tbtt_category` WHERE parent_id = " . $parent_id . " AND cat_level = " . $catlv . " AND cate_type = 0 AND cat_status = 1 order by cat_order";
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
		    $object->cate_type = $val['cate_type'];
		    $this->recursive[] = $object;
		    unset($data[$key]);
		    $this->recursive($val['cat_id'], $data, $step . ' |-- ', $catlv + 1);
		}
	    }
	}
	return $this->recursive;
    }

    function rec_sevice($parent_id = 0, $data, $step = '', $catlv = 0) {
	$sql = "SELECT cat_id, cat_name,cat_level, parent_id, cate_type from `tbtt_category` WHERE parent_id = " . $parent_id . " AND cat_level = " . $catlv . " AND cate_type = 1 AND cat_status = 1 order by cat_order";
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
		    $object->cate_type = $val['cate_type'];
		    $this->rec_sevice[] = $object;
		    unset($data[$key]);
		    $this->rec_sevice($val['cat_id'], $data, $step . ' |-- ', $catlv + 1);
		}
	    }
	}
	return $this->rec_sevice;
    }

    function rec_coupon($parent_id = 0, $data, $step = '', $catlv = 0) {
	$sql = "SELECT cat_id, cat_name,cat_level, parent_id, cate_type from `tbtt_category` WHERE parent_id = " . $parent_id . " AND cat_level = " . $catlv . " AND cate_type = 2 AND cat_status = 1 order by cat_order";
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
		    $object->cate_type = $val['cate_type'];
		    $this->rec_coupon[] = $object;
		    unset($data[$key]);
		    $this->rec_coupon($val['cat_id'], $data, $step . ' |-- ', $catlv + 1);
		}
	    }
	}
	return $this->rec_coupon;
    }

    function loadCategory2($parent, $level, &$retArray, $where, $sort, $by, $start, $limit) {
	$select = "*";
	$whereTmp = "";
	if (strlen($where) > 0) {
	    $whereTmp .= $where;
	} else {
	    $whereTmp .= $where . "parent_id='$parent'";
	}
	$category = $this->category_model->fetch($select, $whereTmp);

	foreach ($category as $row) {
	    $row->cat_name = $row->cat_name;
	    $retArray[] = $row;
	    $this->loadCategory2($row->cat_id, $level + 1, $retArray);
	    //edit by nganly
	}
    }

    function loadCategoryLevel2(&$retArray) {
		$cattye = $this->uri->segment(4);
		if ($cattye == 'service') {
		    $type = ' AND cate_type = 1';
		} elseif ($cattye == 'coupon') {
		    $type = ' AND cate_type = 2';
		} else {
		    $type = ' AND cate_type = 0';
		}
		$select = "*";
		$where = "";
		$whereTmp = "";
		if (strlen($where) > 0) {
		    $whereTmp .= $where;
		} else {
		    //	$whereTmp .= $where."parent_id IN (1,195,636,1086,1224,1565,3902,3906,4707,4796,4923,5659,5875,6181,6475,6476,6478,6482,6486,6638) AND cat_level = 1".$type;
		    $whereTmp .= $where . "cat_level = 1 AND parent_id > 0" . $type;
		}
		$category = $this->category_model->fetch($select, $whereTmp, 'cate_type', 'ASC');
		foreach ($category as $row) {
		    $row->cat_name = $row->cat_name;
		    $retArray[] = $row;
		}
    }

    function loadCategory($parent, $level, &$retArray, $where, $sort, $by, $start, $limit) {

	$select = "*";
	$whereTmp = "";
	if (strlen($where) > 0) {
	    $whereTmp .= $where . " and parent_id='$parent' ";
	} else {
	    $whereTmp .= $where . "parent_id='$parent'";
	}
	$category = $this->category_model->fetch($select, $whereTmp, $sort, $by, $start, $limit);

	foreach ($category as $row) {

	    $row->cat_name = $row->cat_name;
	    $retArray[] = $row;
	    $this->loadCategory($row->cat_id, $level + 1, $retArray, $where, $sort, $by, $start, $limit);
	    //edit by nganly
	}
    }

    function add() {
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
//			$imageCategory = $this->category_model->fetch("cat_image", "", "", "");
//			$usedImage = array();
//			foreach($imageCategory as $imageCategoryArray)
//			{
//				$usedImage[] = $imageCategoryArray->cat_image;
//			}
//			$usedImage = array_merge($usedImage, array('index.html'));
//			$data['image'] = $this->file->load('templates/home/images/category', $usedImage);
	    #Begin: Category hoi dap
	    $url = $this->uri->segment(3);
	    $url1 = '/' . $url;
	    $cattype = 0;
	    if (isset($url) && $url != '') {
		if ($url == 'service') {
		    $cattype = 1;
		} elseif ($url == 'coupon') {
		    $cattype = 2;
		}
	    } else {
		    $cattype = 0;
	    }
	    $cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cate_type = " . $cattype, "cat_order, cat_id", "ASC");

	    if (isset($cat_level_0)) {
		foreach ($cat_level_0 as $key => $item) {
		    $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int) $item->cat_id . " AND cat_status = 1 AND cate_type = " . $cattype);
		    $cat_level_0[$key]->child_count = count($cat_level_1);
		}
	    }
	    $data['catlevel0'] = $cat_level_0;
	    $maxorder = $this->category_model->get("max(cat_order) as maxorder");
	    $data['next_order'] = (int) $maxorder->maxorder + 1;
	    $maxindex = $this->category_model->get("max(cat_index) as maxindex");
	    $data['next_index'] = (int) $maxindex->maxindex + 1;
	    #END Load image category
	    $this->load->library('form_validation');
	    #BEGIN: Set rules
	    //$this->form_validation->set_rules('name_category', 'lang:name_label_add', 'trim|required|callback__exist_category');
	    // $this->form_validation->set_rules('descr_category', 'lang:descr_label_add', 'trim|required');
        if(empty($_FILES['image_category']['name'])) {
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', 'required');
        }
	    $this->form_validation->set_rules('order_category', 'lang:order_label_add', 'trim|required|is_natural_no_zero');
	    #END Set rules
	    #BEGIN: Set message
	    $this->form_validation->set_message('required', $this->lang->line('required_message'));
	    $this->form_validation->set_message('_exist_category', $this->lang->line('_exist_category_message_add'));
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
		    'cat_order' => (int) $this->input->post('order_category'),
		    'parent_id' => (int) $this->input->post('parent_id'),
		    'cat_index' => (int) $this->input->post('cat_index'),
		    'cat_level' => (int) $this->input->post('cat_level'),
		    'cat_status' => $active_category,
		    'keyword' => $this->input->post('keyword'),
		    'h1tag' => $this->input->post('h1tag'),
		    'cat_hot' => $this->input->post('cat_hot'),
		    'cate_type' => $cattype
		);
		if ($this->category_model->add($dataAdd)) {
		    redirect(base_url() . 'administ/category' . $url1 . '/add', 'location');
		    $this->session->set_flashdata('sessionSuccessAdd', 1);
		}
		redirect(base_url() . 'administ/category' . $url1 . '/add', 'location');
	    } else {
		$data['name_category'] = $this->input->post('name_category');
		$data['descr_category'] = $this->input->post('descr_category');
		$data['image_category'] = $this->input->post('image_category');
		$data['order_category'] = $this->input->post('order_category');
		$data['active_category'] = $this->input->post('active_category');
		$data['keyword'] = $this->input->post('keyword');
		$data['h1tag'] = $this->input->post('h1tag');
		$data['cat_hot'] = $this->input->post('cat_hot');
		$data['cat_service'] = $this->input->post('cat_service');
	    }
	}
	//$retArray = array();
	//	$this->display_child(0, 0,$retArray);
	//$data['parents']  = $retArray;
	#Load view
	$this->load->view('admin/category/add', $data);
    }

    function edit($id) {
	#BEGIN: CHECK PERMISSION
	if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_edit')) {
	    show_error($this->lang->line('unallowed_use_permission'));
	    die();
	}
	$cat_type = $this->uri->segment(5);
	#END CHECK PERMISSION
	if ($this->session->flashdata('sessionSuccessEdit')) {
	    $data['successEdit'] = true;
	} else {
	    $data['successEdit'] = false;
	    #BEGIN: Get category by $id
	    $category = $this->category_model->get("*", "cat_id = " . (int) $id);
	    if (count($category) != 1 || !$this->check->is_id($id)) {
		redirect(base_url() . 'administ/category', 'location');
		die();
	    }
	    #END Get category by $id
	    
	    #Begin: Category hoi dap
	    $cat_parent = $this->category_model->get("*", "cat_id = " . (int) $category->parent_id);

	    if (isset($cat_parent)) {
		if ($cat_parent->parent_id == 0) {
		    $data['parent_id_0'] = $category->parent_id;
		    $cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cat_id != " . $id . ' AND cate_type = ' . $cat_type, "cat_order, cat_id", "ASC");
		    if (isset($cat_level_0)) {
			foreach ($cat_level_0 as $key => $item) {
			    $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int) $item->cat_id . " AND cat_status = 1  AND cate_type = $cat_type");
			    $cat_level_0[$key]->child_count = count($cat_level_1);
			}
		    }
		    $data['catlevel0'] = $cat_level_0;
		} else {
		    if ($cat_parent->cat_level == 1) {
			$data['parent_id_1'] = $cat_parent->cat_id;
			$cat_level_1 = $this->category_model->fetch("*", "parent_id = {$cat_parent->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel1'] = $cat_level_1;

			$data['parent_id_0'] = $cat_level_1[0]->parent_id;
			$cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cat_id != " . $id . ' AND cate_type = ' . $cat_type, "cat_order, cat_id", "ASC");
			$data['catlevel0'] = $cat_level_0;
		    }

		    if ($cat_parent->cat_level == 2) {

			$data['parent_id_2'] = $cat_parent->cat_id;
			$cat_level_2 = $this->category_model->fetch("*", "parent_id = {$cat_parent->parent_id} AND cat_status = 1   AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel2'] = $cat_level_2;


			$getparent = $this->category_model->fetch("parent_id", "cat_id = {$cat_level_2[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['parent_id_1'] = $cat_level_2[0]->parent_id;
			$cat_level_1 = $this->category_model->fetch("*", "parent_id = {$getparent[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel1'] = $cat_level_1;

			$data['parent_id_0'] = $cat_level_1[0]->parent_id;
			$cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cat_id != " . $id . ' AND cate_type = ' . $cat_type, "cat_order, cat_id", "ASC");
			$data['catlevel0'] = $cat_level_0;
		    }

		    if ($cat_parent->cat_level == 3) {

			$data['parent_id_3'] = $cat_parent->cat_id;
			$cat_level_3 = $this->category_model->fetch("*", "parent_id = {$cat_parent->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel3'] = $cat_level_3;

			$getparent = $this->category_model->fetch("parent_id", "cat_id = {$cat_level_3[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['parent_id_2'] = $cat_level_3[0]->parent_id;
			$cat_level_2 = $this->category_model->fetch("*", "parent_id = {$getparent[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel2'] = $cat_level_2;

			$getparent1 = $this->category_model->fetch("parent_id", "cat_id = {$cat_level_2[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['parent_id_1'] = $cat_level_2[0]->parent_id;
			$cat_level_1 = $this->category_model->fetch("*", "parent_id = {$getparent1[0]->parent_id} AND cat_status = 1  AND cate_type = {$cat_type}", "cat_order, cat_id", "ASC");
			$data['catlevel1'] = $cat_level_1;

			$data['parent_id_0'] = $cat_level_1[0]->parent_id;
			$cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 AND cat_id != " . $id . ' AND cate_type = ' . $cat_type, "cat_order, cat_id", "ASC");
			$data['catlevel0'] = $cat_level_0;
		    }
		}
	    }


	    $maxindex = $this->category_model->get("max(cat_index) as maxindex");
	    $data['next_index'] = (int) $maxindex->maxindex + 1;
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('order_category', 'lang:order_label_edit', 'trim|required|is_natural_no_zero');

        if(!$category->cat_image && empty($_FILES['image_category']['name'])) {
            $this->form_validation->set_rules('image_category', 'lang:image_label_add', 'required');
        }
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
		
		/*UPLOAD IMAGE CATEGORY*/
		$this->load->library('upload');
		$this->load->library('image_lib');
		$pathUpload = "media/images/categories/";
		$dirUpload = $this->session->userdata('sessionUserAdmin');
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
		$configftp['hostname'] = IP_CLOUDSERVER;
		$configftp['username'] = USER_CLOUDSERVER;
		$configftp['password'] = PASS_CLOUDSERVER;
		$configftp['port'] = PORT_CLOUDSERVER;
		$configftp['debug'] = TRUE;
		$this->ftp->connect($configftp);
		$pathTarget = '/public_html/media/images/';
		$dirTarget = 'categories';
		                 
		if ($this->upload->do_upload('image_category')) {                    
		    $uploadData = $this->upload->data();
		    if ($uploadData['is_image'] == TRUE) {                        
                        if ($category->cat_image != '' && is_array(getimagesize(DOMAIN_CLOUDSERVER.'media/images/categories/'.$category->cat_image))) {
			    $this->ftp->delete_file($pathTarget.$dirTarget.'/'. $category->cat_image);
			}
                        
			$image_category = $uploadData['file_name'];
                        
			#BEGIN: Crop image 1x1
			$w = $uploadData['image_width']; 
			$h = $uploadData['image_height'];
			if($w != $h){
			    if($w > $h) {
				$width = $h;
				$height = $h;
				$y_axis = 0;
				$x_axis = ($w-$width)/2;
			    }
			    if($w < $h) {
				$width = $w;
				$height = $w;
				$y_axis = ($h-$height)/2;
				$x_axis = 0;
			    }			
			    $configCrop = array(
				'source_image' => $pathUpload . $dirUpload . '/' . $image_category,
				'new_image' => $pathUpload . $dirUpload . '/' . $image_category,
				'maintain_ratio' => FALSE,
				'width' => $width, 'height' => $height,
				'x_axis' => $x_axis, 'y_axis' => $y_axis
			    );
			    $this->image_lib->initialize($configCrop);
			    $this->image_lib->crop();
			    $this->image_lib->clear();
			}
			$configResize = array(
			    'source_image' => $pathUpload . $dirUpload . '/' . $image_category,
			    'new_image' => $pathUpload . $dirUpload . '/' . $image_category,
			    'maintain_ratio' => true,
			    'quality' => '90%',
			    'width' => '200',
			    'height' => '200',
			    'master_dim' => 'height'
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configResize);
			$this->image_lib->resize();
		    }
                    
                    
		    $source_path = $pathUpload . $dirUpload . '/' . $image_category;                    
		    $target_path = $pathTarget . $dirTarget . '/' . $image_category;
                    
		    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
		} else {                     
		    $image_category = $this->input->post('image_category_old');
		}
                
		if ( file_exists('media/images/categories/' . $dirUpload . '/index.html') ) {
		    @unlink('media/images/categories/' . $dirUpload . '/index.html');
		}
		array_map('unlink', glob('media/images/categories/' . $dirUpload . '/*'));
		@rmdir('media/images/categories/' . $dirUpload);
		 
                $this->ftp->close();
                 
		if ($this->input->post('active_category') == '1') {
		    $active_category = 1;
		} else {
		    $active_category = 0;
		}
                
		$dataEdit = array(
		    'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
		    'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
		    'cat_image' => $image_category,
		    'cat_order' => (int) $this->input->post('order_category'),
		    'cat_status' => $active_category,
		    'cat_index' => (int) $this->input->post('cat_index'),
		    'cat_level' => (int) $this->input->post('cat_level'),
		    'parent_id' => $this->input->post('parent_id'),
		    'keyword' => $this->input->post('keyword'),
		    'h1tag' => $this->input->post('h1tag'),
		    'cat_hot' => $this->input->post('cat_hot'),
		    'cat_service' => $this->input->post('cat_service')
		);
                
                
		if ($this->category_model->update($dataEdit, "cat_id = " . (int) $id)) {
		    $this->session->set_flashdata('sessionSuccessEdit', 1);
		}
		if ($category->cat_level == 0 && (int) $this->input->post('cat_level') == 1) {
		    $this->category_model->update(array('cat_level' => 2), "parent_id  = " . (int) $id);
		}
		redirect(base_url() . 'administ/category/edit/' . $id, 'location');
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
		$data['cat_hot'] = $category->cat_hot;
		$data['cat_service'] = $category->cat_service;
	    }
	}

	/* $retArray = array();
	  $this->display_child(0, 0,$retArray);
	  $data['parents']  = $retArray; */

	#Load view
	$this->load->view('admin/category/edit', $data);
    }

    function _exist_category() {
	if (count($this->category_model->get("cat_id", "cat_name = '" . trim($this->filter->injection_html($this->input->post('name_category'))) . "'")) > 0) {
	    return false;
	}
	return true;
    }

    function display_child($parent, $level, &$retArray) 
    {
		$sql = "SELECT * from `tbtt_category` WHERE parent_id='$parent' order by cat_order";
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

    function ajax_get_level_1($parent_id) {
		$cat_level = $this->category_model->fetch("*", "parent_id = " . $parent_id . " AND cat_level = 1 AND cat_status = 1", "cat_order, cat_id", "ASC");
		return json_encode($cat_level);
    }

    function ajax_get_level_parent_list($parent_id) {
		$cat_level = $this->category_model->fetch("*", "parent_id = " . $parent_id . " AND cat_status = 1", "cat_order, cat_id", "ASC");
		return json_encode($cat_level);
    }

    function ajax() {
		$parent_id = (int) $this->input->post('parent_id');
		$type = (int) $this->input->post('cate_type');
		$cat_level = $this->category_model->fetch("*", "parent_id = " . $parent_id . " AND cat_status = 1 AND cate_type = " . $type, "cat_id", "DESC"); //cat_order
		echo "[" . json_encode($cat_level) . "," . count($cat_level) . "]";
		exit();
    }

    function updateFee() {
		$cat_id = (int) $this->input->post('cat_id');
		$b2c_fee = (float) $this->input->post('b2c_fee');
		$b2c_af_fee = (float) $this->input->post('b2c_af_fee');
		$b2b_fee = (float) $this->input->post('b2b_fee');
		$b2b_em_fee = (float) $this->input->post('b2b_em_fee');
		if ($cat_id > 0) {
		    $this->category_model->update(array('b2c_fee' => $b2c_fee, 'b2c_af_fee' => $b2c_af_fee, 'b2b_fee' => $b2b_fee, 'b2b_em_fee' => $b2b_em_fee), 'cat_id = ' . $cat_id);
		}
		echo 1;
		exit();
    }

//	 function updateFee(){
//        $cat_id = (int)$this->input->post('cat_id');
//        $b2c_fee = (float)$this->input->post('b2c_fee');
//        $b2c_af_fee = (float)$this->input->post('b2c_af_fee');
//        $b2b_fee = (float)$this->input->post('b2b_fee');
//        $b2b_em_fee = (float)$this->input->post('b2b_em_fee');
//        if($cat_id > 0){
//            $this->category_model->update(array('b2c_fee'=>$b2c_fee, 'b2c_af_fee'=>$b2c_af_fee, 'b2b_fee'=>$b2b_fee, 'b2b_em_fee'=>$b2b_em_fee ), 'cat_id = '.$cat_id);
//        }
//        echo 1;
//        exit();
//    }

    function fee() {
		#BEGIN: CHECK PERMISSION
		if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_view')) {
		    show_error($this->lang->line('unallowed_use_permission'));
		    die();
		}
		$cat_id = $this->input->post('cat_id');
		$b2c_fee = $this->input->post('b2c_fee');
		$b2c_af_fee = $this->input->post('b2c_af_fee');
		$b2b_fee = $this->input->post('b2b_fee');
		$b2b_em_fee = $this->input->post('b2b_em_fee');
		if (count($cat_id) > 0) {
		    foreach ($cat_id as $key => $item) {
			$update = $this->category_model->update(array('b2c_fee' => $b2c_fee[$key], 'b2c_af_fee' => $b2c_af_fee[$key], 'b2b_fee' => $b2b_fee[$key], 'b2b_em_fee' => $b2b_em_fee[$key]), 'cat_id = ' . $item);
		    }
		    if (isset($update)) {
			redirect(base_url() . 'administ/category/fee', 'location');
		    }
		}
		$where = '';
		$sort = 'cat_order';
		$by = 'ASC';
		#END CHECK PERMISSION
		$retArray = array();
		$this->loadCategoryLevel2($retArray);
		$data['category'] = $retArray;
		$this->load->view('admin/category/fee', $data);
    }

}
