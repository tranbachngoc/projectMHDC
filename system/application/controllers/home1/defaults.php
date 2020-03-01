<?php

#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#

class Defaults extends MY_Controller {

    function __construct() {

        parent::__construct();
        #CHECK SETTING
        if ((int) settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        #END CHECK SETTING
        #Load library
        $this->load->library('hash');
        $this->load->library('pagination');
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/defaults');
        #Load model
        $this->load->model('user_model');
        $this->load->model('category_model');
        //$this->load->model('product_model');
        $this->load->model('ads_model');
        $this->load->model('job_model');
        $this->load->model('shop_model');
        $this->load->model('product_favorite_model');
        $this->load->model('province_model');
        $this->load->model('showcart_model');

        //BEGIN: Update counter
        if (!$this->session->userdata('sessionUpdateCounter')) {
            $this->counter_model->update();
            $this->session->set_userdata('sessionUpdateCounter', 1);
        }
	//END Update counter
	
	//BEGIN: Ads & Notify Taskbar
	$this->load->model('notify_model');
	//BEGIN Eye
	if ($this->session->userdata('sessionUser') > 0) {
	    $this->load->model('eye_model');
	    $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
	    $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
	    $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));
	} else {
	    if (isset($this->session->userdata['arrayEyeSanpham']))
		array_values($this->session->userdata['arrayEyeSanpham']);

	    if (isset($this->session->userdata['arrayEyeRaovat']))
		array_values($this->session->userdata['arrayEyeRaovat']);

	    if (isset($this->session->userdata['arrayEyeHoidap']))
		array_values($this->session->userdata['arrayEyeHoidap']);
	    $this->load->model('eye_model');

	    if (isset($this->session->userdata['arrayEyeSanpham']))
		$data['listeyeproduct'] = $this->eye_model->geteyetypenologin('product');

	    if (isset($this->session->userdata['arrayEyeRaovat']))
		$data['listeyeraovat'] = $this->eye_model->geteyetypenologin('raovat');

	    if (isset($this->session->userdata['arrayEyeHoidap']))
		$data['listeyehoidap'] = $this->eye_model->geteyetypenologin('hoidap');
	}
	//END Eye

	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int) settingAdsNew_Home);
	$data['adsTaskbarGlobal'] = $adsTaskbar;
	$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
	$data['notifyTaskbarGlobal'] = $notifyTaskbar;

	//$retArray = $this->loadCategory(0, 0);
	//$data['menu'] = $retArray;

	#BEGIN: Notify
	$select = "not_id, not_title, not_detail, not_degree";
	$this->db->limit(settingNotify);
	$this->db->order_by("not_id", "DESC");
	$data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC"); //AND not_enddate  >= $currentDate */
	#END Notify
	$data['productCategoryRoot'] = $this->loadCategoryRoot(0, 0);	
        
        $data['menuType'] = 'product';
        
		$this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }	
        
	//Get shop from User
	$sessionUser = $this->session->userdata('sessionUser');
        if($sessionUser){
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite","use_id = " . $sessionUser);
            	    
	    if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $sessionUser);

                //Get AF Login
		$data['af_id'] = $data['currentuser']->af_key;
            } elseif($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15 ) { 
                $parentUser = $this->user_model->get("parent_id","use_id = " . $sessionUser);
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
            }
	    $data['myshop'] = $myshop; 
        }
	
        /*
        $data['css'] = loadCss(
        	array(
                    'home/css/libraries.css',
                    'home/css/style-azibai.css',
                    'home/css/select2.min.css',
                    'home/css/select2-bootstrap.min.css',
                    'home/js/jAlert-master/jAlert-v3.css',
                    'home/css/jquery.autocomplete.css'
        	), 'asset/home/products.min.css'
        );

        $data['css'] = '<style>'.$data['css'].'</style>';

        $data['js'] = '<script type="text/javascript" defer src="'.loadJs(array(
			'home/js/jquery-migrate-1.2.1.js',
			'home/js/bootstrap.min.js',
			'home/js/select2.full.min.js',
			'home/js/general.js',
			'home/js/jAlert-master/jAlert-v3.min.js',
			'home/js/jAlert-master/jAlert-functions.min.js',
			'home/js/bootbox.min.js',
			'home/js/js-azibai-tung.js',
			'home/js/jquery.autocomplete.js',
			'home/js/jquery.validate.js',
			'home/js/jquery-scrolltofixed-min.js'
		),'asset/home/products.min.js').'"></script>';
        */
        
        
        
        $this->load->vars($data);

    }

    function cronuptin() {
		$this->load->model('uptin_model');
		$thu = date('N') + 1;
		$gio = date('G:i');
		$lichUp = $this->uptin_model->getLichUp($thu, $gio);
		foreach ($lichUp as $row) {
		    $this->uptin_model->uptin($row->tin_id, $row->type);

		    $this->uptin_model->minusLichUp($row->id);
		}
    }

    // check ip
    function get_client_ip_server() {
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
		    $ipaddress = getHostByName(getHostName());
		    return $ipaddress;
		} else {
		    $ipaddress = '';
		    if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		    else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else if ($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		    else if ($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		    else if ($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		    else if ($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		    else
			$ipaddress = 'UNKNOWN';
		    return $ipaddress;
		}
    }

    function adv_click($id) {
		$this->db->cache_off();
		$this->load->model('advertise_click_model');
		$this->load->model('advertise_model');
		$banner_id = $this->advertise_model->get('*', 'adv_id = ' . $id);
		$clicked = $this->advertise_click_model->get('*', 'adv_id = ' . $id);
		$data['banner'] = $banner_id;
		// get ip client
		$ip = $this->get_client_ip_server();
		$ipexit = $this->advertise_click_model->fetch('*', 'user_ip = "' . $ip . '"');
		if (isset($ipexit) && count($ipexit) > 0) {
		    $arrIp = array();
		    $idadv = array();
		    foreach ($ipexit as $ip_exit) {
			$arrIp[] = $ip_exit->user_ip;
			$idadv[] = $ip_exit->adv_id;
		    }
		}
		$total = time() - $clicked->created;
		//$hours   = floor($total / 3600);
		$minutes = floor((($total / 60) % 60));
		$dataarrAdd = array(
		    'user_click' => (int) $this->session->userdata('sessionUser'),
		    'user_adv' => $banner_id->user_id,
		    'user_ip' => $ip,
		    'adv_pos' => $banner_id->adv_position,
		    'adv_id' => $id,
		    'number_click' => 1,
		    'created' => time(),
		);

		//Câp nhật nếu tồn tại ip
		if (in_array($ip, $arrIp) == 1 && in_array($id, $idadv) == 1 && $minutes >= SettimeClick) {
		    $click = $clicked->number_click + 1;
		    $this->advertise_click_model->update(array('number_click' => $click, 'created' => time()), 'adv_id = ' . $id . ' AND user_ip = "' . $ip . '"');
		}
		// Insert nêu chua co
		if (($arrIp == null && in_array($id, $idadv) != 1) || (in_array($ip, $arrIp) == 1 && in_array($id, $idadv) != 1)) {
		    $this->advertise_click_model->add($dataarrAdd);
		}
		$this->load->view('home/common/adv_click', $data);
    }

    function loadCategoryHot($parent, $level) {
		$this->load->model('category_model');
		$this->load->model('product_model');
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
		$this->load->model('category_model');
		$this->load->model('product_model');
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

	    private function _excel($data) {
		require_once(APPPATH . 'libraries/xlsxwriter.class.php');
		$filename = "bieu_phi_azibai.xlsx";
		header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Transfer-Encoding: binary');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		$header___old = array(
		    'STT' => 'integer',
		    'Tên danh mục' => 'string',
		    'B2C Ngoài' => 'string',
		    'B2C Trong' => 'string',
		    'B2B Ngoài' => 'string',
		    'B2B Trong' => 'string',
		    'Loại danh mục' => 'string',
		);
		$header = array(
		    'STT' => 'integer',
		    'Tên danh mục' => 'string',
		    'Mức Phí' => 'string',
		    'Loại danh mục' => 'string',
		);

		$excel = array();
		$stt = 0;
		foreach ($data as $item) {
		    $catype = '';
		    if ($item->cate_type == 1) {
			$catype = 'Dịch vụ';
		    } elseif ($item->cate_type == 2) {
			$catype = 'Coupon';
		    } else {
			$catype = 'Sản phẩm';
		    }
		    $stt ++;
		    $row = array();
		    if ($item->cate_type != 1) {
			array_push($row, $stt);
			array_push($row, $item->cat_name);
			array_push($row, $item->b2c_fee);
			//array_push($row, $item->b2c_af_fee);
			//array_push($row, $item->b2b_fee);
			//array_push($row, $item->b2b_em_fee);
			array_push($row, $catype);
			array_push($excel, $row);
		    }
		}
		$writer = new XLSXWriter();
		$writer->setAuthor('Azibai');
		$writer->writeSheet($excel, 'Sheet1', $header);
		$writer->writeToStdOut();
    }

    function CatBieuphi() {
		$this->load->model('category_model');
		$isPaging = $this->input->get_post('excel', 0) == 1 ? FALSE : TRUE;
		$sort = 'cate_type';
		$by = 'ASC';
		$sortUrl = '';
		$pageUrl = '';
		$pageSort = '';
		$keyword = '';
		$where = '';
		$action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(2, $action);
		$data['slrt'] = $this->uri->segment(3);
		#BEGIN: Pagination
		$this->load->library('pagination');
		if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
		    $keyword = $this->filter->html($getVar['keyword']);
		    switch (strtolower($getVar['search'])) {
			case 'product':
			    $sortUrl .= '/search/product/keyword/' . $getVar['keyword'];
			    $pageUrl .= '/search/product/keyword/' . $getVar['keyword'];
			    $where .= "cat_level = 1 and cat_status = 1 AND cate_type = 0 AND cat_name LIKE '%" . $this->filter->injection_html($keyword) . "%'";
			    break;
			case 'service':
			    $sortUrl .= '/search/service/keyword/' . $getVar['keyword'];
			    $pageUrl .= '/search/service/keyword/' . $getVar['keyword'];
			    $where .= "cat_level = 1 and cat_status = 1 AND cate_type = 1 AND cat_name LIKE '%" . $this->filter->injection_html($keyword) . "%'";
			    break;
			case 'coupon':
			    $sortUrl .= '/search/service/keyword/' . $getVar['keyword'];
			    $pageUrl .= '/search/service/keyword/' . $getVar['keyword'];
			    $where .= "cat_level = 1 and cat_status = 1 AND cate_type = 2 AND cat_name LIKE '%" . $this->filter->injection_html($keyword) . "%'";
			    break;

			default: $pageUrl .= '/search/all/keyword/' . $getVar['keyword'];
			    $where .= "cat_level = 1 and cat_status = 1 AND cat_name LIKE '%" . $this->filter->injection_html($keyword) . "%'";
		    }
		} else {
		    $where .= "cat_level = 1 and cat_status = 1 AND cate_type!=1 ";
		}
		$data['keyword'] = $keyword;
		#If have page
		if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
		    $start = (int) $getVar['page'];
		    $pageSort .= '/page/' . $start;
		} else {
		    $start = 0;
		}
		#Count total record

		$limmit = 20; // -1 all
		$list = $this->category_model->fetch('*', $where, $sort, $by, '', '');
		$data['bieuphi'] = $this->category_model->fetch('*', $where, $sort, $by, $start, $limmit);
		if ($isPaging == FALSE) {
		    $this->_excel($list);
		    exit();
		}
		$totalRecord = count($this->category_model->fetch('*', $where));
		$config['base_url'] = base_url() . 'bieuphisanpham' . $pageUrl . '/page/';
		$config['total_rows'] = $totalRecord;
		$config['per_page'] = settingOtherAccount;
		$config['num_links'] = 5;
		$config['uri_segment'] = 3;
		$config['cur_page'] = $start;
		$this->pagination->initialize($config);
		$data['linkPage'] = $this->pagination->create_links();
		$this->load->view('home/defaults/bieuphi', $data);
    }

    function loadMenu($parent, $level, &$retArray) {
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

    function loadCategory($parent, $level) {
		$retArray = '';
		$select = "*";
		$whereTmp = "cat_status = 1  AND parent_id = ". $parent;
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

    function loadProductCategoryRoot($parent, $level) {
		$select = "*";
		$whereTmp = "cat_status = 1  and parent_id = " . $parent;
		$category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
		return $category;
	    }

	    function loadSubCategory($parent, $level) {
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

    function loadSubSubCategory($parent, $level) {
		$retArray = '';
		$select = "*";
		$whereTmp = "cat_status = 1  and parent_id='$parent'";
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

    function my_array_random($arr, $num = 1) {
        shuffle($arr);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[] = $arr[$i];
        }
        return $num == 1 ? $r[0] : $r;
    }

    function update_gian_hang_dam_bao() {
        $this->load->model('shop_model');
        $ngayHienTai = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $this->shop_model->update(array('sho_guarantee' => 0), "sho_enddate < " . (int) $ngayHienTai);
    }

    function Delete_Fav() {
        $id = $_POST['id'];
        if ($this->db->delete('tbtt_product_favorite', array('prf_id' => $id))) {
            echo '1';
        } else {
            echo '0';
        }
        exit();
    }

    function Delete_allFav() {
        if ($this->db->delete('tbtt_product_favorite', array('prf_user' => (int) $this->session->userdata('sessionUser')))) {
            echo '1';
        } else {
            echo '0';
        }
        exit();
    }

    function success_access() {
		if ((int) $this->input->post('iscountdown') == 1) {
		    $this->session->set_userdata('success_access', 1);
		    echo '1';
		    exit();
		} else {
		    $this->session->set_userdata('success_access', 0);
		    echo '0';
		    exit();
		}
    }

    function index() {
	
		redirect( base_url() . 'shop/products', 'location' );
	
		/* $codd = (int)$_REQUEST['countdown'];
		  if((int)$this->session->userdata('success_access') <= 0 && $codd == 0){
		  redirect(base_url().'countdown', 'location');
		  }

		  $email = $this->input->post('email');

		  if((int)$this->session->userdata('sessionUser') <= 0 && $email == ""){

		  //redirect(base_url().'welcome', 'location');

		  } elseif (!empty($email)) {

		  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  redirect(base_url().'welcome?email=invalid', 'location');
		  }

		  $query_userid	=	"SELECT use_id FROM tbtt_user WHERE use_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
		  $query_result=$this->db->query($query_userid);
		  $result=$query_result->result();
		  if(count($result)){
		  redirect(base_url().'login', 'location');
		  } else {

		  $query_email	=	"SELECT new_id FROM tbtt_newsletter WHERE new_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
		  $is_email_result=$this->db->query($query_email);
		  $email_result = $is_email_result->result();

		  if(!count($email_result)){

		  $this->load->model('newsletter_model');

		  $data= array(
		  'new_email' => trim($this->filter->injection_html($this->input->post('email'))),
		  'new_created_date' => time(),
		  'new_status' => 1
		  );

		  $this->newsletter_model->add($data);

		  }
		  redirect(base_url().'welcome?u=guest', 'location');
		  }
		  }

		  /*--------End welcome----------- */
		/* $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		  $data['menuSelected'] = 0;
		  $data['advertisePage'] = 'home';
		  $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		  $data['counter'] = $this->counter_model->get();
		  $data['module'] = 'top_saleoff_product,top_buyest_product';
		  $select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		  $start = 0;
		  $limit = (int)settingProductSaleoff_Top;
		  $data['to#END Top product saleoff right
		  #BEGIN: Top product buyest rightpSaleoffProduct'] = $this->product_model->fetch($select, "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		  $select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		  $start = 0;
		  $limit = (int)settingProductBuyest_Top;
		  $data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		  #END Top product buyest right
		  #BEGIN: Tab product category (4 tab)
		  if((int)date('j') > 10)
		  {
		  $tabStart = 0;
		  }
		  else
		  {
		  $tabStart = (int)date('j') - 1;
		  }

		  $tabProductCategory = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_id", "ASC", $tabStart, 4);
		  $tabIs = 1;
		  foreach($tabProductCategory as $tabProductCategoryArray)
		  {
		  $data['tabIDCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_id;
		  $data['tabNameCategoryProduct_'.$tabIs] = $tabProductCategoryArray->cat_name;
		  $tabIs++;
		  }

		  $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total";
		  $start = 0;
		  $limit = 8;
		  $data['favoriteProduct'] = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_vote", "DESC", $start, $limit);
		  $select = "ads_id, ads_title, ads_descr, ads_category";
		  $start = 0;
		  $limit = (int)settingAdsNew_Top;
		  $data['topLastestAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "up_date", "DESC", $start, $limit);
		  //END Top lastest ads right

		  //BEGIN: Get random category
		  $this->load->model('category_model');
		  $this->load->model('product_model');
		  $this->load->model('product_favorite_model');
		  $this->load->model('province_model');
		  //$select = "cat_id";
		  //$randomCategory= $this->product_model->fetch($select, "parent_id = 0 AND cat_status = 1",'cat_id', 'rand()');
		  $select = "pro_category";
		  $this->db->distinct('pro_category');
		  $randomCategory= $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_status = 1 AND pro_category > 0 AND sho_status = 1 AND pro_enddate >= $currentDate ", "pro_category", "rand()");
		  $arrayCat=array();
		  $rand_keys=array();
		  for($i=0;$i<count($randomCategory);$i++){
		  $arrayCat[]=$randomCategory[$i]->pro_category;
		  }
		  reset($rand_keys);
		  $rand_keys=$this->my_array_random($arrayCat,6);

		  // first category name
		  $select = "*";

		  if($rand_keys[0]>0)
		  {
		  $data['firstCatName'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[0]);
		  }
		  // second category name
		  $select = "*";
		  if($rand_keys[1]>0)
		  {
		  $data['secondCatName'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[1]);
		  }
		  if($rand_keys[2]>0)
		  {
		  $data['CatName3'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[2]);
		  }
		  if($rand_keys[3]>0)
		  {
		  $data['CatName4'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[3]);
		  }
		  if($rand_keys[4]>0)
		  {
		  $data['CatName5'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[4]);
		  }
		  if($rand_keys[5]>0)
		  {
		  $data['CatName6'] = $this->category_model->fetch($select, "cat_id = ".$rand_keys[5]);
		  }

		  //BEGIN: Frirst Category in Homepage
		  $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total,pro_saleoff_value, pro_type_saleoff,pro_cost,pro_view,sho_name,sho_begindate,pre_name,pro_vote_total,pro_vote";
		  $start = 0;
		  $limit = 8;

		  $this->load->model('shop_model');
		  if($rand_keys[0]>0)
		  {
		  $data['firstCat'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[0]."  AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1 ", "up_date", "DESC", $start, $limit);
		  }
		  //BEGIN: Second Category in Homepage
		  $select = "pro_id, pro_name, pro_descr, pro_dir, pro_image, pro_category, pro_vote, pro_vote_total,pro_saleoff_value, pro_type_saleoff,pro_cost,pro_view,sho_name,sho_begindate,pre_name,pro_vote_total,pro_vote";
		  $start = 0;
		  $limit = 8;
		  if($rand_keys[1]>0)
		  {
		  $data['secondCat'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[1]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "up_date", "DESC", $start, $limit);
		  }
		  if($rand_keys[2]>0)
		  {
		  $data['Cat3'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[2]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "up_date", "DESC", $start, $limit);
		  }
		  if($rand_keys[3]>0)
		  {
		  $data['Cat4'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[3]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "up_date", "DESC", $start, $limit);
		  }
		  if($rand_keys[4]>0)
		  {
		  $data['Cat5'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[4]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "up_date", "DESC", $start, $limit);
		  }
		  if($rand_keys[5]>0)
		  {
		  $data['Cat6'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_category = ".$rand_keys[5]." AND pro_image != 'none.gif' AND pro_cost > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "up_date", "DESC", $start, $limit);
		  }



		  $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		  $select = "sho_descr, sho_logo, sho_dir_logo, sho_link, sho_name";
		  $start = 0;
		  $limit = (int)settingShopInterest;
		  $data['shopFeatured'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate AND sho_logo <> ''", "rand()", "DESC", $start, $limit);
		  #END Feature shop
		  #BEGIN Vote
		  /*$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		  $select = "pro_id, pro_name, pro_descr, pro_cost, pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category,pro_view,sho_name,sho_begindate,pre_name,pro_vote_total,pro_vote";
		  $start = 0;
		  $limit = (int)settingProductVote;
		  $data['productVote'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "", "pro_vote > 0 AND pro_status = 1 AND pro_enddate >= $currentDate AND sho_status = 1", "pro_vote", "DESC", $start, $limit);

		  $select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail";
		  $where = "pro_status = 1 AND pro_type = 0";
		  $sort = 'pro_id';
		  $by = 'DESC';
		  $limit = settingProductNew_Category;

		  $this->load->library('pagination');
		  #Count total record
		  $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
		  $config['base_url'] = base_url() . 'shop/product' . $pageUrl . '/page/';
		  $config['total_rows'] = $totalRecord;
		  $config['per_page'] = settingProductNew_Category;
		  $config['num_links'] = 1;
		  $config['uri_segment'] = 3;
		  $config['cur_page'] = $start;
		  $this->pagination->initialize($config);
		  $data['linkPage'] = $this->pagination->create_links();

		  $data['allproducts'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);



		  #END  All Products



		  $this->load->helper('text');
		  $data['province'] = $this->province_model->fetch('pre_id, pre_name, pre_order',"pre_status = 1","pre_order","ASC",1,-1);
		  $this->load->view('home/defaults/products', $data); */
    }
   
    function products_home() {

        $email = $this->input->post('email');

        $filter['sort'] = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
        $filter['pf'] = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : '';
        $filter['pt'] = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';
        $filter['pro_name'] = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';
        $filter['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $data['filter'] = $filter;

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect(base_url() . 'welcome?email=invalid', 'location');
            }
            $query_userid = "SELECT use_id FROM tbtt_user WHERE use_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
            $query_result = $this->db->query($query_userid);
            $result = $query_result->result();
            if (count($result)) {
                redirect(base_url() . 'login', 'location');
            } else {
                $query_email = "SELECT new_id FROM tbtt_newsletter WHERE new_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
                $is_email_result = $this->db->query($query_email);
                $email_result = $is_email_result->result();

                if (!count($email_result)) {
                    $this->load->model('newsletter_model');
                    $data = array(
                        'new_email' => trim($this->filter->injection_html($this->input->post('email'))),
                        'new_created_date' => time(),
                        'new_status' => 1
                    );
                    $this->newsletter_model->add($data);
                }
                redirect(base_url() . 'welcome?u=guest', 'location');
            }
        }

        //Get AF Login
        $data['af_id'] = $_REQUEST['af_id'] != '' ? $_REQUEST['af_id'] : $this->session->userdata('af_id');
        if ($this->session->userdata('sessionUser')) {
            $user_login = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $data['af_id'] = $user_login->af_key;
            }
        }

        $select = '';
        $where = '';
        $by = 'DESC'; 
        $sort = 'pro_id';
        $limit = 60;
        $select .= "id, pro_id, pro_name, pro_instock, pro_minsale, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_type_saleoff, pro_saleoff_value, shop_type, is_product_affiliate";
        $where .= "`pro_status` = 1 AND `pro_type` = 0 AND sho_status = 1 ";
        
        if ($filter['type'] == 'discount') {
        	$where .= "AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))";
        }

         //$sortby = $this->input->post('sort');
        $sortby = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';        
        switch ($sortby) {
            case "product": 
                $sort = 'pro_id';
                break;
            case "seller":
                $sort = 'pro_buy';
                break;
            default:
                $sort = 'pro_id';
                break;
        }

        $getVar = $this->uri->uri_to_assoc();
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
    	#BEGIN: Filter & Search
        // $priceform  = $this->input->post('pf');        
        // $priceto    = $this->input->post('pt');
        // $pro_name  = $this->input->post('pro_name');

        $priceform  = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : '';        
        $priceto    = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';        
        $pro_name  = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';        
        if($priceto && $priceform){
            $where .= ' AND pro_cost >= '. $priceform .' AND pro_cost <= '. $priceto;
        } else if($priceto && !$priceform){
            $where .= ' AND pro_cost <= '. $priceto;
        } else if (!$priceto && $priceform){
            $where .= ' AND pro_cost >= '. $priceform;
        }

        if($pro_name) {
            $where .= ' AND pro_name LIKE "%'. $pro_name .'%"';
        }
    	#END: Filter & Search
        //$data['allproducts'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
        $productAll = $this->product_model->fetch_join($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where.' GROUP BY pro_id', $sort, $by, $start, $limit);
        if($this->session->userdata('sessionUser') && count($productAll) > 0){
        	$this->load->model('like_product_model');
            foreach ($productAll as $key => $value) {
                $is_like = $this->like_product_model->get('id', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $value->pro_id]);
                $value->is_like = count($is_like);
            }
        }
        $data['allproducts'] = $productAll;
        $this->db->flush_cache();

        $data['ogurl'] = base_url().'shop/products';
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Sản phẩm';
        $data['ogdescription'] = '';
        $data['ogimage'] = DOMAIN_CLOUDSERVER . 'media/shop/banners/defaults/default-banner.jpg';
                
        #BEGIN: Phan trang
        #Count total record
        // $totalRecord = count($this->product_model->fetch("pro_id", $where, "", ""));
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where));
        
        $config['base_url'] = base_url() . 'shop/products/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] =	5;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $config['first_url'] = '1?' . http_build_query($_REQUEST, '', "&");
        $config['suffix'] = '?' . http_build_query($_REQUEST, '', "&");
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();        
    	#END: Phan trang	
        
        $this->load->helper('text');
         #Load view       
        $this->load->view('home/defaults/products', $data);
	}

    function services_home() {
		$email = $this->input->post('email');       
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect(base_url() . 'welcome?email=invalid', 'location');
            }
            $query_userid = "SELECT use_id FROM tbtt_user WHERE use_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
            $query_result = $this->db->query($query_userid);
            $result = $query_result->result();
            if (count($result)) {
                redirect(base_url() . 'login', 'location');
            } else {
                $query_email = "SELECT new_id FROM tbtt_newsletter WHERE new_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
                $is_email_result = $this->db->query($query_email);
                $email_result = $is_email_result->result();

                if (!count($email_result)) {
                    $this->load->model('newsletter_model');
                    $data = array(
                        'new_email' => trim($this->filter->injection_html($this->input->post('email'))),
                        'new_created_date' => time(),
                        'new_status' => 1
                    );
                    $this->newsletter_model->add($data);
                }
                redirect(base_url() . 'welcome?u=guest', 'location');
            }
        }

        //Get AF Login
        if ($this->session->userdata('sessionUser')) {
            $user_login = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));            
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $data['af_id'] = $user_login->af_key;
            }
        }

        $select = '';
        $where = '';
        $by = 'DESC'; 
        $sort = 'pro_id';
        $limit = 60;
        $select .= "id, pro_id, pro_name, pro_instock, pro_minsale, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_type_saleoff, pro_saleoff_value, shop_type";
        $where .= "`pro_status` = 1 AND `pro_type` = 1 AND `sho_status` = 1 ";
        
        $sortby = $this->input->post('sort');
        switch ($sortby) {
            case "product": 
                $sort = 'pro_id';
                break;
            case "discount":
                $sort = 'pro_saleoff';
                break;
            case "seller":
                $sort = 'pro_buy';
                break;
            case "guarantee": 
                $sort = '';
                break;
            default:
                $sort = 'pro_id';
                break;
        }

        $getVar = $this->uri->uri_to_assoc();
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
    	#BEGIN: Filter & Search
        $priceform  = $this->input->post('pf');        
        $priceto    = $this->input->post('pt');
        $pro_name  = $this->input->post('pro_name');
        if($priceto){
            $where .= ' AND pro_cost >= '. $priceform .' AND pro_cost <= '. $priceto;
        } 
        if($pro_name) {
            $where .= ' AND pro_name LIKE "%'. $pro_name .'%"';
        }
    	#END: Filter & Search
        $data['allservices'] = $this->product_model->fetch_join($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where.' GROUP BY pro_id', $sort, $by, $start, $limit);
        $this->db->flush_cache();

        $data['ogurl'] = base_url().'shop/services';
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Sản phẩm';
        $data['ogdescription'] = '';
        $data['ogimage'] = DOMAIN_CLOUDSERVER . 'media/shop/banners/defaults/default-banner.jpg';
                
        #BEGIN: Phan trang
        #Count total record
        
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where));
        
        $config['base_url'] = base_url() . 'shop/services/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] =	5;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();        
    	#END: Phan trang	
        
        $this->load->helper('text');
         #Load view    
		$this->load->view('home/defaults/services', $data);
    }

    function coupons_home() { 
        $email = $this->input->post('email');

        $filter['sort'] = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
        $filter['pf'] = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : '';
        $filter['pt'] = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';
        $filter['pro_name'] = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';
        $filter['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $data['filter'] = $filter;

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                redirect(base_url() . 'welcome?email=invalid', 'location');
            }
            $query_userid = "SELECT use_id FROM tbtt_user WHERE use_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
            $query_result = $this->db->query($query_userid);
            $result = $query_result->result();
            if (count($result)) {
                redirect(base_url() . 'login', 'location');
            } else {
                $query_email = "SELECT new_id FROM tbtt_newsletter WHERE new_email = '" . trim(strtolower($this->filter->injection_html($email))) . "' LIMIT 1 ";
                $is_email_result = $this->db->query($query_email);
                $email_result = $is_email_result->result();

                if (!count($email_result)) {
                    $this->load->model('newsletter_model');
                    $data = array(
                        'new_email' => trim($this->filter->injection_html($this->input->post('email'))),
                        'new_created_date' => time(),
                        'new_status' => 1
                    );
                    $this->newsletter_model->add($data);
                }
                redirect(base_url() . 'welcome?u=guest', 'location');
            }
        }

        //Get AF Login
        $data['af_id'] = $_REQUEST['af_id'] != '' ? $_REQUEST['af_id'] : $this->session->userdata('af_id');
        if ($this->session->userdata('sessionUser')) {
            $user_login = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $data['af_id'] = $user_login->af_key;
            }
        }

        $select = '';
        $where = '';
        $by = 'DESC'; 
        $sort = 'pro_id';
        $limit = 60;
        $select .= "id, pro_id, pro_name, pro_instock, pro_minsale, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle, pro_type_saleoff, pro_saleoff_value, shop_type, is_product_affiliate";
        $where .= "`pro_status` = 1 AND `pro_type` = 2 AND `sho_status` = 1 ";
        
        if ($filter['type'] == 'discount') {
        	$where .= "AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))";
        }

        // $sortby = $this->input->post('sort');
        $sortby = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';      
        switch ($sortby) {
            case "product": 
                $sort = 'pro_id';
                break;
            case "seller":
                $sort = 'pro_buy';
                break;
            default:
                $sort = 'pro_id';
                break;
        }

        $getVar = $this->uri->uri_to_assoc();
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
    	#BEGIN: Filter & Search
        // $priceform  = $this->input->post('pf');        
        // $priceto    = $this->input->post('pt');
        // $pro_name  = $this->input->post('pro_name');
        
        $priceform  = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : '';        
        $priceto    = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';        
        $pro_name  = isset($_REQUEST['pro_name']) ? $_REQUEST['pro_name'] : '';        
        if($priceto && $priceform){
            $where .= ' AND pro_cost >= '. $priceform .' AND pro_cost <= '. $priceto;
        } else if($priceto && !$priceform){
            $where .= ' AND pro_cost <= '. $priceto;
        } else if (!$priceto && $priceform){
            $where .= ' AND pro_cost >= '. $priceform;
        }

        if($pro_name) {
            $where .= ' AND pro_name LIKE "%'. $pro_name .'%"';
        }
    	#END: Filter & Search
        $data['allcoupons'] = $this->product_model->fetch_join($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where.' GROUP BY pro_id', $sort, $by, $start, $limit);
        $this->db->flush_cache();

        $data['ogurl'] = base_url().'shop/coupons';
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Sản phẩm';
        $data['ogdescription'] = '';
        $data['ogimage'] = DOMAIN_CLOUDSERVER . 'media/shop/banners/defaults/default-banner.jpg';
                
        #BEGIN: Phan trang
        #Count total record
        
		$totalRecord = count($this->product_model->fetch_join("pro_id", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "LEFT", "tbtt_shop", "sho_user = pro_user", "", "", "", $where));
        
        $config['base_url'] = base_url() . 'shop/coupons/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] =	5;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $config['first_url'] = '1?' . http_build_query($_REQUEST, '', "&");
        $config['suffix'] = '?' . http_build_query($_REQUEST, '', "&");
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();        
    	#END: Phan trang	
        
        $this->load->helper('text');
         #Load view       
        $this->load->view('home/defaults/coupons', $data);	     
	}
	
		

    function ajax_category() {
		$ret = $this->loadCategory4Search(0, 0);
		echo $ret;
		exit();
	}

    function long_polling() {
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

    function long_polling_cancel() {
		$sessionLogin1 = array('sessionLongPollingCancel' => 1);
		$this->session->set_userdata($sessionLogin1);
		echo $this->session->userdata('sessionLongPollingCancel');
		exit();
    }

    function loadCategory4Search($parent, $level) {
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

    function ajax_required_guarantee() {
		$shop_id = $_POST['shop_id'];
		$user_id = $this->session->userdata('sessionUser');
		$query = "SELECT * FROM tbtt_shop WHERE sho_users_required LIKE '%," . $user_id . "%' AND sho_id=" . $shop_id;
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

    function ajax() {
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
		    $query = "select * from jos_comprofiler where active_code='" . $_POST['code'] . "' limit 1";

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
				    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_cost > 0 AND pro_category = $categoryProduct AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
				    echo "[" . json_encode($product) . "," . count($product) . "]";
				} elseif ((int) $this->input->post('object') == 2) {
				    $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
				    $select = "pro_id, pro_name, pro_descr, pro_cost,pro_saleoff ,pro_saleoff_value,pro_type_saleoff, pro_currency, pro_image, pro_dir, pro_category,pro_vip";
				    $start = 0;
				    $limit = (int) settingProductReliable_Home;
				    $this->db->order_by("pro_vip", "random");
				    $this->db->order_by("pro_id", "random");
				    $product = $this->product_model->fetch($select, "pro_image != 'none.gif' AND pro_reliable = 1  AND pro_status = 1 AND pro_enddate >= $currentDate", $start, $limit); //AND pro_cost > 0 AND pro_reliable = 1 , order: "pro_vip", "DESC", \
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
    function ajax_mancatego() {

		$categoryId = $_POST['selCate'];
		$ret = $this->loadMancategory4Search($categoryId);
		echo $ret;
		exit();
    }

    function loadMancategory4Search($categoryId) {
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
    function autocompleteads() {
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
    function autocompleteshop() {
		$q = $_REQUEST["q"];
		if (!$q)
		    return;
		$this->load->model('shop_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: autocomplete Ads
		$select = "sho_name";
		$this->db->like('sho_name', $q);
		$allAds = $this->ads_model->fetch($select, "sho_status = 1 AND 	sho_enddate >= $currentDate", "sho_name", "DESC");
		#END autocomplete Ads

		foreach ($allAds as $item) {
		    echo "$item->sho_name|$item->sho_name\n";
		}
    }

    //end Quang
    function autocomplete() {
		if (isset($_REQUEST['term'])) {
		    $q = $_REQUEST['term'];
		} else {
		    $q = $_REQUEST['q'];
		}
		if (!$q)
		    return;
		if ($this->session->userdata('s_province')) {
		    $province = $this->session->userdata('s_province');
		} else {
		    $province = '';
		}

		$this->load->model('product_model');
		$allProduct = $this->product_model->getListProductsSearch(array('province' => $province, 'status' => 1, 'pro_name' => $q));
		foreach ($allProduct as $item) {
		    echo $item->pro_name . "\n";
		}
		exit;	
    }

    function rss() {
		$this->load->model('product_model');
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		#BEGIN: autocomplete
		$select = "pro_id,pro_name,pro_descr,pro_detail,pro_category,pro_dir,pro_image,pro_begindate";
		//$this->db->like('pro_id', $q); 
		$this->db->limit(50);
		$allProduct = $this->product_model->fetch($select, "pro_status = 1 AND pro_enddate >= $currentDate", "pro_id", "DESC");
		$now = date("D, d M Y H:i:s T");
		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	            <rss version=\"2.0\">
	                <channel>
	                    <title>Sản phẩm mới nhất</title>
	                    <link>http://www.azibai.com/rss</link>
	                    <description>20 sản phẩm cập nhật gần đây nhất</description>
	                    <language>vi-vn</language>
	                    <pubDate>$now</pubDate>
	                    <lastBuildDate>$now</lastBuildDate>
	                    <docs></docs>
	                    <managingEditor>nganly@lkvsolutions.vn</managingEditor>
	                    <webMaster>nganly@lkvsolutions.vn</webMaster>
	            ";
		for ($i = 0; $i < count($allProduct); $i++) {
		    $line = $allProduct[$i];
		    $output .= "<item><title>" . $line->pro_name . "</title><link>" . base_url() . $line->pro_category . "/" . $line->pro_id . "/" . removeSign($line->pro_name) . "</link>                    
			<description><![CDATA[ <a href=\"" . base_url() . $line->pro_category . "/" . $line->pro_id . "/" . removeSign($line->pro_name) . "\"><img src=\"" . base_url() . "media/images/product/" . $line->pro_dir . "/" . show_thumbnail($line->pro_dir, $line->pro_image, 2) . "\"/></a> <br/> " . cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel, "#", $line->pro_detail))), 600) . " ]]></description>
			<pubDate>" . date('d / m / Y H:i', $line->pro_begindate) . "</pubDate>
			                </item>";
		}

		$output .= "</channel></rss>";
		header("Content-Type: application/rss+xml");
		echo $output;
    }

    public function storeSessionProvince() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
		    $this->session->unset_userdata('s_province');
		    $this->session->set_userdata('s_province', $this->input->post('province'));
		    die("1");
		}
		die("-1");
    }
    
    public function loadCategoryRoot($parent, $level) {
        $select = "*";
        $whereTmp = "cat_status = 1 and parent_id = '$parent'";
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }
}
