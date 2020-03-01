<?php

#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#

class Content extends MY_Controller {

    function __construct() {
	parent::__construct();
	#CHECK SETTING
	if ((int) settingStopSite == 1) {
	    $this->lang->load('home/common');
	    show_error($this->lang->line('stop_site_main'));
	    die();
	}
	#END CHECK SETTING
	#Load language
	$this->lang->load('home/common');
	$this->lang->load('home/content');
	#Load model
	$this->load->model('content_model');
	$this->load->model('category_model');
	$this->load->model('shop_model');
	$this->load->model('user_model');
	#BEGIN Eye
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
	#END Eye
	#BEGIN: Update counter
	if (!$this->session->userdata('sessionUpdateCounter')) {
	    $this->counter_model->update();
	    $this->session->set_userdata('sessionUpdateCounter', 1);
	}
	#END Update counter
	#BEGIN: Ads & Notify Taskbar
	$this->load->model('ads_model');
	$this->load->model('category_model');
	$data['menuType'] = 'product';
	$retArray = $this->loadCategory(0, 0);
	$data['menu'] = $retArray;
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int) settingAdsNew_Home);
	$data['adsTaskbarGlobal'] = $adsTaskbar;
	$notifyTaskbar = $this->content_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
	$data['notifyTaskbarGlobal'] = $notifyTaskbar;

	$data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);
	$data['productCategoryHot'] = $this->loadCategoryHot(0, 0);
	# BEGIN popup right
	# Tin tức
	$this->load->model('content_model');
	$select = "not_id, not_title, not_image,not_dir_image, not_begindate";
	$data['listNews'] = $this->content_model->fetch($select, "not_status = 1 AND cat_type = 1", "not_id", "DESC", 0, 10);
	$this->load->model('product_model');
	$this->load->model('product_favorite_model');
	# Hàng yêu thích
	$select = 'prf_id, prf_product, prf_user, pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_cost ';
	$join = 'INNER';
	$table = 'tbtt_product';
	$on = 'tbtt_product_favorite.prf_product = tbtt_product.pro_id';
	$where = 'prf_user = ' . (int) $this->session->userdata('sessionUser');
	$data['favoritePro'] = $this->product_favorite_model->fetch_join($select, $join, $table, $on, $where, 0, 10);
	# Hàng g?i ý
	$select = "pro_id, pro_name, pro_cost, pro_image, pro_dir,pro_category, ";
	$whereTmp = "pro_status = 1  and is_asigned_by_admin = 1";
	$products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC", 0, 10);
	$data['products'] = $products;
	# END popup right
        $cur_user = $this->user_model->get('use_id,use_username,avatar', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
	$data['currentuser'] = $cur_user;
	
	$css = loadCss(array('home/css/libraries.css','home/css/style-azibai.css'),'asset/home/login.min.css');
	$data['css'] = '<style>'. $css .'</style>';
	$this->load->vars($data);

	#END Ads & Notify Taskbar
    }

    function loadCategory($parent, $level) {
	$retArray = '';
	$select = "*";
	$whereTmp = "cat_status = 1  and parent_id='$parent'";
	$category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", 0, 5);
	if (count($category) > 0) {
	    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
	    foreach ($category as $key => $row) {
		//$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
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

    function loadSubCategory($parent, $level) {
	$retArray = '';
	$select = "*";
	$whereTmp = "cat_status = 1  and parent_id='$parent'";
	$category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", 0, 5);
	if (count($category) > 0) {
	    $retArray .= "<div class='sub-container mega'>";
	    $retArray .= "<ul class='sub'>";
	    $rowwidth = 190;
	    if (count($category) == 2) {
		$rowwidth = 380;
	    }
	    if (count($category) >= 3) {
		$rowwidth = 570;
	    }
	    foreach ($category as $key => $row) {
		//$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
		$link = '<a class="mega-hdr-a" alt="' . $row->cat_name . '" href="' . base_url() . 'ads/category/' . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
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

    function loadSubSubCategory($parent, $level) {
	$retArray = '';
	$select = "*";
	$whereTmp = "cat_status = 1  and parent_id='$parent'";
	$category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC", 0, 5);
	if (count($category) > 0) {
	    $retArray .= "<ul>";
	    foreach ($category as $key => $row) {
		//$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
		$link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
		$retArray .= "<li>" . $link . "</li>";
	    }
	    $retArray .= "</ul>";
	}
	return $retArray;
    }

    function index() {
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$id = (int) $this->uri->segment(2);
        
	$data['id'] = $id;
	$this->load->library('bbcode');
	#BEGIN: Detail
	$notify = $this->content_model->get("*", "not_status = 1 AND not_id = ".$id);
	if (count($notify) != 1 || !$this->check->is_id($id)) {
	    redirect(base_url(), 'location');
	    die();
	}

	$data['notify'] = $notify;       
	#BEGIN: Advertise
	$data['advertisePage'] = 'notify';
	$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
	#END Advertise
	#BEGIN: Counter
	$data['counter'] = $this->counter_model->get();
	#END Counter	
         
        #BEGIN: List notify
	$where = "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate";
	$sort = "not_id";
	$by = "DESC";
	#Define url for $getVar
	$action = array('page');
	$getVar = $this->uri->uri_to_assoc(3, $action);
	#If have page
	if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
	    $start = (int) $getVar['page'];
	} else {
	    $start = 0;
	}
	$data['page'] = $start;
	#BEGIN: Pagination
	$this->load->library('pagination');
	#Count total record
	$totalRecord = count($this->content_model->fetch("not_id", $where));
	$config['base_url'] = base_url() . 'content/' . $id . '/page/';
	$config['total_rows'] = $totalRecord;
	$config['per_page'] = settingOtherAccount;
	$config['num_links'] = 1;
	$config['uri_segment'] = 4;
	$config['cur_page'] = $start;
	$this->pagination->initialize($config);
	$data['linkPage'] = $this->pagination->create_links();
	if (count($totalRecord) < 1) {
	    redirect(base_url(), 'location');
	    die();
	}
	#Fetch record
	$select = "not_id, not_title, not_degree, not_detail, not_begindate";
	$limit = settingOtherAccount;
	$data['listNotify'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
	$this->load->model('content_category_model');
	$category_view_left = $this->content_category_model->fetch("*", "cat_type = 0");
	$data['category_view_left'] = $category_view_left;
	$data['view_cate_1'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[0]->cat_id, "not_id", "ASC", 0, 4);
	$data['view_cate_2'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[1]->cat_id, "not_id", "ASC", 0, 4);
	$data['view_cate_3'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[2]->cat_id, "not_id", "ASC", 0, 4);
	$data['view_cate_4'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[3]->cat_id, "not_id", "ASC", 0, 4);
	$data['view_cate_5'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[4]->cat_id, "not_id", "ASC", 0, 4);
	$data['view_cate_6'] = $this->content_model->fetch($select, "id_category = " . (int) $category_view_left[5]->cat_id, "not_id", "ASC", 0, 4);
	$this->load->model('content_model');

	$this->load->view('home/content/defaults', $data);
    }

    function news_1() {
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

	#BEGIN: Advertise
	$data['advertisePage'] = 'notify';
	$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
	#END Advertise
	#BEGIN: Counter
	$data['counter'] = $this->counter_model->get();
	#END Counter
	#BEGIN: List notify
	$where = "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate";
	$sort = "not_id";
	$by = "DESC";
	#Define url for $getVar
	$action = array('page');
	$getVar = $this->uri->uri_to_assoc(3, $action);
	#If have page
	if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
	    $start = (int) $getVar['page'];
	} else {
	    $start = 0;
	}
	$data['page'] = $start;
	#BEGIN: Pagination
	$this->load->library('pagination');
	#Count total record
	$totalRecord = count($this->content_model->fetch("not_id", $where));
	$config['base_url'] = base_url() . 'content/' . $id . '/page/';
	$config['total_rows'] = $totalRecord;
	$config['per_page'] = settingOtherAccount;
	$config['num_links'] = 1;
	$config['uri_segment'] = 4;
	$config['cur_page'] = $start;
	$this->pagination->initialize($config);
	$data['linkPage'] = $this->pagination->create_links();
	#END Pagination
	#Check is have notify
	if (count($totalRecord) < 1) {
	    redirect(base_url(), 'location');
	    die();
	}
	#Fetch record
	$select = "not_id, not_title, not_degree, not_detail, not_begindate";
	$limit = settingOtherAccount;
	$data['listNotify'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
	#END List notify
	$this->load->view('home/content/news-1', $data);
    }

    function news_2() {
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

	#BEGIN: Advertise
	$data['advertisePage'] = 'notify';
	$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
	#END Advertise
	#BEGIN: Counter
	$data['counter'] = $this->counter_model->get();
	#END Counter
	#BEGIN: List notify
	$where = "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate";
	$sort = "not_id";
	$by = "DESC";
	#Define url for $getVar
	$action = array('page');
	$getVar = $this->uri->uri_to_assoc(3, $action);
	#If have page
	if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
	    $start = (int) $getVar['page'];
	} else {
	    $start = 0;
	}
	$data['page'] = $start;
	#BEGIN: Pagination
	$this->load->library('pagination');
	#Count total record
	$totalRecord = count($this->content_model->fetch("not_id", $where));
	$config['base_url'] = base_url() . 'content/' . $id . '/page/';
	$config['total_rows'] = $totalRecord;
	$config['per_page'] = settingOtherAccount;
	$config['num_links'] = 1;
	$config['uri_segment'] = 4;
	$config['cur_page'] = $start;
	$this->pagination->initialize($config);
	$data['linkPage'] = $this->pagination->create_links();
	#END Pagination
	#Check is have notify
	if (count($totalRecord) < 1) {
	    redirect(base_url(), 'location');
	    die();
	}
	#Fetch record
	$select = "not_id, not_title, not_degree, not_detail, not_begindate";
	$limit = settingOtherAccount;
	$data['listNotify'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
	#END List notify
	$this->load->view('home/content/news-2', $data);
    }

    function news_3() {
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

	#BEGIN: Advertise
	$data['advertisePage'] = 'notify';
	$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
	#END Advertise
	#BEGIN: Counter
	$data['counter'] = $this->counter_model->get();
	#END Counter
	#BEGIN: List notify
	$where = "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate";
	$sort = "not_id";
	$by = "DESC";
	#Define url for $getVar
	$action = array('page');
	$getVar = $this->uri->uri_to_assoc(3, $action);
	#If have page
	if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
	    $start = (int) $getVar['page'];
	} else {
	    $start = 0;
	}
	$data['page'] = $start;
	#BEGIN: Pagination
	$this->load->library('pagination');
	#Count total record
	$totalRecord = count($this->content_model->fetch("not_id", $where));
	$config['base_url'] = base_url() . 'content/' . $id . '/page/';
	$config['total_rows'] = $totalRecord;
	$config['per_page'] = settingOtherAccount;
	$config['num_links'] = 1;
	$config['uri_segment'] = 4;
	$config['cur_page'] = $start;
	$this->pagination->initialize($config);
	$data['linkPage'] = $this->pagination->create_links();
	#END Pagination
	#Check is have notify
	if (count($totalRecord) < 1) {
	    redirect(base_url(), 'location');
	    die();
	}
	#Fetch record
	$select = "not_id, not_title, not_degree, not_detail, not_begindate";
	$limit = settingOtherAccount;
	$data['listNotify'] = $this->content_model->fetch($select, $where, $sort, $by, $start, $limit);
	#END List notify
	$this->load->view('home/content/news-3', $data);
    }

    // Add function by VIET
    function loadCategoryHot($parent, $level) {
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

    function loadSupCategoryHot($parent, $level) {
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

    function loadCategoryRoot($parent, $level) {
	$select = "*";
	$whereTmp = "cat_status = 1  and parent_id='$parent'";
	$categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
	return $categoryRoot;
    }    
}
