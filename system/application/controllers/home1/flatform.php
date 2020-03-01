<?php
/**
 * Created by Bao Tran.
 * User: Administrator
 * Date: 10/10/2017
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flatform extends MY_Controller
{    
    function __construct()
    {
        parent::__construct();
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');            
            show_error($this->lang->line('stop_site_main'));
            die();
        }
	
        $this->load->helper('language');
        $this->lang->load('home/common');
        $this->lang->load('home/shop');
        $this->lang->load('home/contact');
        $this->load->helper('cookie');
        $this->load->library('Mobile_Detect');

        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }

        $this->load->model('content_model');
	    $this->load->model('shop_model');
        $this->load->model('user_model');
        $this->load->model('flatform_model');
        $this->load->model('category_model');
        $this->load->model('wallet_model');
        // $this->load->model('product_model');  // Model auto loaded
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('product_promotion_model');       

        $data['wallet_info'] = $this->wallet_model->getSumWallet(array('user_id' => (int)$this->session->userdata('sessionUser')), 1);	
        $user_current = $this->user_model->get("*", "use_id = " . (int)$this->session->userdata('sessionUser'));
        $data['currentuser'] = $user_current;
	
	$data['permission'] = $this->db->query('SELECT * FROM `tbtt_permission`')->result();
	# Return data
	$this->load->vars($data);
    }    

    function news() {
	$data['protocol'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'"); 
        if($shop) {

        } else {
            redirect( base_url() . 'login', 'location');			
            die();
        }
        $dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
        $shop->fl_district = $dp->DistrictName;
        $shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
	
        $userid = $shop->fl_user; 
        $data['sitedesc'] = $shop->fl_desc;
        $data['sitekeyword'] = $shop->fl_name .','. $shop->fl_link;
	    //FOR SOCIAL
        $data['ogurl'] = site_url('flatform/news');
        $data['ogtitle'] = 'website';
        $data['ogtitle'] = $shop->fl_name;
        $data['ogimage'] = DOMAIN_CLOUDSERVER .'media/images/flatform/'. $shop->fl_dir_banner .'/'. $shop->fl_banner;     
        $data['ogdescription'] = $shop->fl_desc;
        
        // DS gian hang do d2 phat trien
        $listShop = $this->getListShop($userid); 
        $data['listShop'] = $listShop;
    	$listNews = array();
	if($shop->fl_listshop != ''){
            $select = "a.not_id, a.not_title, a.not_description, a.not_keywords, a.not_detail, a.not_user, a.not_begindate, a.not_view, a.not_dir_image, a.not_video_url, a.not_image, "
                    . "a.not_image1, a.imglink1, "
                    . "a.not_image2, a.imglink2, "
                    . "a.not_image3, a.imglink3, "
                    . "a.not_image4, a.imglink4, "
                    . "a.not_image5, a.imglink5, "
                    . "a.not_image6, a.imglink6, "
                    . "a.not_image7, a.imglink7, "
                    . "a.not_image8, a.imglink8, "
                    . "a.not_image9, a.imglink9, "
                    . "a.not_image10, a.imglink10, "
                    . "a.not_pro_cat_id, a.not_ghim, a.not_permission, a.not_slideshow, a.not_effect, a.not_music, p.name as not_permission_name, a.not_ad, "
                    . "s.sho_name, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_mobile, s.sho_phone, s.sho_facebook, s.domain, s.sho_user, "
                    . "c.cat_name ";
            $where  = 'a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND a.not_user IN ('.$shop->fl_listshop.')';
            $order  = 'a.not_id DESC';           
            $start  = 0;
            $limit  = 1000; 

            $where1 =  ' AND not_permission IN (1)';
            $sessionUser = (int) $this->session->userdata('sessionUser');
            $sessionGroup = (int) $this->session->userdata('sessionGroup');

            // neu co mot thanh vien dang nhap vao
            if( $sessionUser && $sessionGroup != 6) { 
                $shopID = $this->get_shop_in_tree($sessionUser);
                $shopID = $shopID != 0 ? $shopID : $sessionUser;
                $shop_near = $this->get_shop_nearest($sessionUser);
                $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
                $aaaa = ' AND not_permission IN (1,2)';           
                if( $sessionGroup == 2) {
                    $aaaa = ' AND not_permission IN (1,2,4) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .'))';
                } else {
                    $aaaa = ' AND not_permission IN (1,2,3) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .')) OR (not_permission = 6 AND not_user = '. $sessionUser .') OR (not_permission = 4 AND (not_user = '. $sessionUser .' OR not_user = '. $shopID .'))';
                }
                $where1 = $aaaa;
            }
            $where .= $where1;
	    
	switch ($this->uri->segment(3)) {
	    case 'hot': 
		$where .= ' AND not_news_hot = 1 ';
		break;
	    case 'sale':
		$where .= ' AND not_news_sale = 1 ';
		break;
	    case 'view': 
		$order  = ' a.not_view DESC '; 
		break;
	}
	    
            $mysql = "SELECT DISTINCT ". $select
                    . "FROM tbtt_content AS a "
                    . "LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user "
                    . "LEFT JOIN tbtt_category AS c ON c.cat_id = a.not_pro_cat_id "
                    . "LEFT JOIN tbtt_permission AS p ON p.id = a.not_permission "
                    . "WHERE ". $where ." ORDER BY ". $order ." LIMIT ". $start .", ". $limit;
	    
            $query = $this->db->query($mysql);
            $listNews = $query->result();

            foreach ($listNews as $key => $value) {                        
                //Dem so luot chon tin
                $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $value->not_id);
                $result = $query->result();
                if (count($result)) {
                    $value->solanchon = count($result);
                } else {
                    $value->solanchon = 0;
                }

                //Dem binh luan
                $query = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $value->not_id);
                $result = $query->result();
                $value->comments = count($result);

                //Kiem tra 1 user bat ky da chon tin nay chua  
                if ($sessionUser) {
                    $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $value->not_id . ' AND sho_user = ' . $sessionUser);
                    $result = $query->result();
                    if (count($result)) {
                        $value->dachon = 1;
                    } else {
                        $value->dachon = 0;
                    }
                }
                //User co duoc phep chon tin nay khong
                //$value->ConditionsSelectNews = $this->getConditionsSelectNews($value, $sessionGroup, $sessionUser);
		$list_image = array();
		if ($value->not_image1 !='') { $list_image[0] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image1; }
		if ($value->not_image2 !='') { $list_image[1] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image2; } 
		if ($value->not_image3 !='') { $list_image[2] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image3; } 
		if ($value->not_image4 !='') { $list_image[3] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image4; } 
		if ($value->not_image5 !='') { $list_image[4] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image5; } 
		if ($value->not_image6 !='') { $list_image[5] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image6; } 
		if ($value->not_image7 !='') { $list_image[6] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image7; } 
		if ($value->not_image8 !='') { $list_image[7] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image8; } 
		if ($value->not_image9 !='') { $list_image[8] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image9; } 
		if ($value->not_image10 !='') { $list_image[9] = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/' . $value->not_image10; } 
		$value->list_image = $list_image;
		
		/*get list product */		
		$array_id = $value->imglink1 . ',' . $value->imglink2 . ',' . $value->imglink4 . ',' . $value->imglink5 . ',' . $value->imglink6 . ',' . $value->imglink7 . ',' . $value->imglink8 . ',' . $value->imglink9 . ',' .  $value->imglink10;		
		$value->list_product = $this->product_model->fetch("pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir", "pro_id IN (" . $array_id . ")");
		
		
	    }
        }
        $data['listNews'] = $listNews;
        $this->load->model('reports_model');
        $listreports = $this->reports_model->fetch('*', 'rp_type = 1 AND rp_status = 1', 'rp_id', 'ASC');
        $data['listreports'] = $listreports;
        $this->load->view('flatform/news/default', $data);        
    }
    function searchnews() {        
        
	$fl_Link = $this->getShopLink();        
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");	        
        if($this->input->post('keyword')){
		$keyword = $this->input->post('keyword'); 			
	} else { 
		$keyword = $this->uri->segment(5);			
	}
	$data['keyword'] = $keyword;
	$data['totalRecord'] = 0;

	if ($keyword) {
            $this->load->model('content_model');
            #If have page
            $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(4, $action);

            if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
                $start = (int) $getVar['page'];
                $pageSort .= '/page/' . $start;
            } else {
                $start = 0;
            }

            $limit = 10; 
            if($shop->fl_listshop != ''){
                $results = $this->content_model->fetch("*", "not_title LIKE '%" . $keyword . "%' OR not_description LIKE '%" . $keyword . "%' AND not_status = 1 and id_category = 16 AND not_user IN (".$shop->fl_listshop.")", "not_id", "DESC", $start, $limit);
                $data['results'] = $results;

                $this->load->library('pagination');
                $total = $this->content_model->fetch("*", "not_title LIKE '%" . $keyword . "%' OR not_description LIKE '%" . $keyword . "%' AND not_status = 1 and id_category = 16 AND not_user IN (".$shop->fl_listshop.")", "not_id", "DESC", $start, -1);
                $totalRecord = count($total);
                $data['totalRecord'] = $totalRecord;
                $config['base_url'] = base_url() . 'flatform/news/search/keyword/' . $keyword . '/page/';
                $config['total_rows'] = $totalRecord;
                $config['per_page'] = settingOtherAccount;
                $config['num_links'] = 5;
                $config['cur_page'] = $start;
                $this->pagination->initialize($config);
                $data['linkPage'] = $this->pagination->create_links();
            }
        }
        $this->load->view('flatform/news/search', $data);
    }
    
    function cat_news($cat_id) {
        $fl_Link = $this->getShopLink();        
        $shop  = $this->flatform_model->get("*", "fl_link = '". $fl_Link ."'");        
        $userid = $shop->fl_user;
        
        $data['sitedesc'] = $shop->fl_desc;
        $data['sitekeyword'] = $shop->fl_name .','. $shop->fl_link;
        $data['head_footer'] = $shop;
        $data['ogurl'] = site_url('flatform/news');
        $data['ogtitle'] = $shop->fl_name;
        $data['ogdescription'] = $shop->fl_desc;
        $data['ogimage'] = DOMAIN_CLOUDSERVER .'media/images/flatform/'. $shop->fl_dir_banner .'/'. $shop->fl_banner;
        
        // DS gian hang do d2 phat trien
        $listShop = $this->getListShop($userid); 
        $listUser = $userid;
        foreach($listShop as $key => $value){
            $listUser .= ','.$value->sho_user;
        }
        $data['listShop'] = $listShop;  
        $listNews = array();
        if($listUser != ''){
            $select = "a.not_id, a.not_title, a.not_description, a.not_keywords, a.not_detail, a.not_user, a.not_begindate, a.not_view, a.not_dir_image, a.not_video_url, a.not_image, "
                    . "a.not_image1, "
                    . "a.not_image2, "
                    . "a.not_image3, "
                    . "a.not_image4, "
                    . "a.not_image5, "
                    . "a.not_image6, "
                    . "a.not_image7, "
                    . "a.not_image8, "
                    . "a.not_pro_cat_id, a.not_ghim, a.not_permission, a.not_slideshow, a.not_effect, a.not_music, p.name as not_permission_name, "
                    . "s.sho_name, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_mobile, s.sho_phone, s.sho_facebook, s.domain, s.sho_user, "
                    . "c.cat_name ";
            $where  = 'a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND a.not_user IN ('.$listUser.')';
            $order  = 'a.not_ghim DESC, a.not_id';
            $by     = 'DESC';
            $start  = 0;
            $limit  = 1000; 

            $where1 =  ' AND not_permission IN (1)';
            $sessionUser = (int) $this->session->userdata('sessionUser');
            $sessionGroup = (int) $this->session->userdata('sessionGroup');

            // neu co mot thanh vien dang nhap vao
            if( $sessionUser && $sessionGroup != 6) { 
                $shopID = $this->get_shop_in_tree($sessionUser);
                $shopID = $shopID != 0 ? $shopID : $sessionUser;
                $shop_near = $this->get_shop_nearest($sessionUser);
                $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
                $aaaa = ' AND not_permission IN (1,2)';           
                if( $sessionGroup == 2) {
                    $aaaa = ' AND not_permission IN (1,2,4) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .'))';
                } else {
                    $aaaa = ' AND not_permission IN (1,2,3) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .')) OR (not_permission = 6 AND not_user = '. $sessionUser .') OR (not_permission = 4 AND (not_user = '. $sessionUser .' OR not_user = '. $shopID .'))';
                }
                $where1 = $aaaa;
            }
            $where .= $where1;        

            $mysql = "SELECT DISTINCT ". $select
                    . "FROM tbtt_content AS a "
                    . "LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user "
                    . "LEFT JOIN tbtt_category AS c ON c.cat_id = a.not_pro_cat_id "
                    . "LEFT JOIN tbtt_permission AS p ON p.id = a.not_permission "
                    . "WHERE ". $where ." ORDER BY a.not_id DESC LIMIT ". $start .", ". $limit;

            $query = $this->db->query($mysql);
            $listNews = $query->result();

            foreach ($listNews as $key => $value) {                        
                //Dem so luot chon tin
                $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $value->not_id);
                $result = $query->result();
                if (count($result)) {
                    $value->solanchon = count($result);
                } else {
                    $value->solanchon = 0;
                }

                //Dem binh luan
                $query = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $value->not_id);
                $result = $query->result();
                $value->comments = count($result);

                //Kiem tra 1 user bat ky da chon tin nay chua  
                if ($sessionUser) {
                    $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $value->not_id . ' AND sho_user = ' . $sessionUser);
                    $result = $query->result();
                    if (count($result)) {
                        $value->dachon = 1;
                    } else {
                        $value->dachon = 0;
                    }
                }

                //User co duoc phep chon tin nay khong
                //$value->ConditionsSelectNews = $this->getConditionsSelectNews($value, $sessionGroup, $sessionUser);
            }

        }
        $data['listNews'] = $listNews;
        
        $this->load->view('flatform/news/category', $data);        
    }   
    
    function detail($not_id) {	
	$data['protocal'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $userid = $shop->fl_user;       
        
        $select = "a.not_id, a.not_title, a.not_description, a.not_keywords, a.not_detail, a.not_user, a.not_begindate, a.not_view, a.not_dir_image, a.not_video_url, a.not_image, "
                . "a.not_image1, a.imglink1, a.linkdetail1, a.imgcaption1, "
                . "a.not_image2, a.imglink2, a.linkdetail2, a.imgcaption2, "
                . "a.not_image3, a.imglink3, a.linkdetail3, a.imgcaption3, "
                . "a.not_image4, a.imglink4, a.linkdetail4, a.imgcaption4, "
                . "a.not_image5, a.imglink5, a.linkdetail5, a.imgcaption5, "
                . "a.not_image6, a.imglink6, a.linkdetail6, a.imgcaption6, "
                . "a.not_image7, a.imglink7, a.linkdetail7, a.imgcaption7, "
                . "a.not_image8, a.imglink8, a.linkdetail8, a.imgcaption8, "
                . "a.not_image9, a.imglink9, a.linkdetail9, a.imgcaption9, "
                . "a.not_image10, a.imglink10, a.linkdetail9, a.imgcaption10, "
                . "a.not_pro_cat_id, a.not_ghim, a.not_permission, a.not_slideshow, a.not_effect, a.not_music, p.name as not_permission_name, a.not_ad, "
                . "s.sho_name, s.sho_link, s.sho_logo, s.sho_dir_logo, s.sho_mobile, s.sho_phone, s.sho_facebook, s.domain, s.sho_user, "
                . "c.cat_name ";
        $where  = 'a.not_status = 1 AND a.not_publish = 1 AND a.id_category = 16 AND a.not_id = '.$not_id;

        
        $where1 =  ' AND not_permission IN (1)';
        $sessionUser = (int) $this->session->userdata('sessionUser');
        $sessionGroup = (int) $this->session->userdata('sessionGroup');
        // neu co mot thanh vien dang nhap vao
        if( $sessionUser  && $sessionGroup != 6) { 
            $shopID = $this->get_shop_in_tree($sessionUser);
            $shopID = $shopID != 0 ? $shopID : $sessionUser;
            $shop_near = $this->get_shop_nearest($sessionUser);
            $shop_near = $shop_near != 0 ? $shop_near : $sessionUser;
            $aaaa = ' AND not_permission IN (1,2)';           
            if( $sessionGroup == 2) {
                $aaaa = ' AND not_permission IN (1,2,4) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .'))';
            } else {
                $aaaa = ' AND not_permission IN (1,2,3) OR (not_permission = 5 AND (not_user = '. $shopID .' OR not_user = '. $shop_near .')) OR (not_permission = 6 AND not_user = '. $sessionUser .') OR (not_permission = 4 AND (not_user = '. $sessionUser .' OR not_user = '. $shopID .'))';
            }
            $where1 = $aaaa;
        }
        $where .= $where1;

	if($this->uri->segment(3)=="hot") { $where .= ' AND not_news_hot = 1'; }
	if($this->uri->segment(3)=="sale") { $where .= ' AND not_news_sale = 1'; }	
	$order = 'not_id DESC';
	if($this->uri->segment(3)=="view") { $order = 'not_view DESC';}
                
        $mysql = "SELECT DISTINCT ". $select
                . "FROM tbtt_content AS a "
                . "LEFT JOIN tbtt_shop AS s ON s.sho_user = a.not_user "
                . "LEFT JOIN tbtt_category AS c ON c.cat_id = a.not_pro_cat_id "
                . "LEFT JOIN tbtt_permission AS p ON p.id = a.not_permission "
                . "WHERE ". $where . " ORDER BY ".$order;
        
        $query = $this->db->query($mysql);
        
        $item = $query->row();        
                       
        //Dem so luot chon tin
        $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $item->not_id);
        $result = $query->result();
        if (count($result)) {
            $item->solanchon = count($result);
        } else {
            $item->solanchon = 0;
        }

        //Dem binh luan
        $query = $this->db->query('SELECT * FROM tbtt_content_comment WHERE noc_content = ' . $item->not_id);
        $result = $query->result();
        $item->comments = count($result);

        //Kiem tra 1 user bat ky da chon tin nay chua  
        if ($sessionUser) {
            $query = $this->db->query('SELECT * FROM tbtt_chontin WHERE not_id = ' . $item->not_id . ' AND sho_user = ' . $sessionUser);
            $result = $query->result();
            if (count($result)) {
                $item->dachon = 1;
            } else {
                $item->dachon = 0;
            }
        }

        //User co duoc phep chon tin nay khong
        //$value->ConditionsSelectNews = $this->getConditionsSelectNews($value, $sessionGroup, $sessionUser);
        if($item->not_video_url){                       
	   $item->not_video_url = $this->get_youtube_id_from_url($item->not_video_url);       
	}
        /*GOI 8 SAN PHAM NẾU CÓ CHỌN*/
        $select = "pro_id, pro_name, pro_category, sho_link, domain"; 
        
        $listProducts = array();
                    //not_image1
                        if($item->not_image1){            
                            $listProducts[1]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image1;
                            
                            if($item->imglink1) {            
                                $list1 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink1 );
                                $listProducts[1]->product = $list1[0];
                            }
                            if($item->linkdetail1){
                               $listProducts[1]->detail = $item->linkdetail1; 
                            }
                            if($item->imgcaption1){
                                $listProducts[1]->caption = $item->imgcaption1;
                            }
                        }
                        //not_image2
                        if($item->not_image2){
                            $listProducts[2]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image2;
                        
                            if($item->imglink2) {            
                                $list2 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink2 );
                                $listProducts[2]->product = $list2[0];
                            }
                            if($item->linkdetail2) {     
                                $listProducts[2]->detail = $item->linkdetail2;
                            }
                            if($item->imgcaption2) { 
                                $listProducts[2]->caption = $item->imgcaption2;
                            }
                        }
                        //not_image3
                        if($item->not_image3){
                            $listProducts[3]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image3;
                        
                            if($item->imglink3) {            
                                $list3 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink3 );
                                $listProducts[3]->product = $list3[0];
                            }
                            if($item->linkdetail3) {     
                                $listProducts[3]->detail = $item->linkdetail3;
                            }
                            if($item->imgcaption3) { 
                                $listProducts[3]->caption = $item->imgcaption3;
                            }
                        }
                        //not_image4    
                        if($item->not_image4){
                            $listProducts[4]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image4;
                        
                            if($item->imglink4) {            
                                $list4 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink4 );
                                $listProducts[4]->product = $list4[0];
                            }
                            if($item->linkdetail4) {     
                                $listProducts[4]->detail = $item->linkdetail4;
                            }
                            if($item->imgcaption4) { 
                                $listProducts[4]->caption = $item->imgcaption4;
                            }
                        }
                        //not_image5    
                        if($item->not_image5){
                            $listProducts[5]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image5;
                            
                            if($item->imglink5) {            
                                $list5 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink5 );
                                $listProducts[5]->product = $list5[0];
                            }
                            if($item->linkdetail5) {     
                                $listProducts[5]->detail = $item->linkdetail5;
                            }
                            if($item->imgcaption5) { 
                                $listProducts[5]->caption = $item->imgcaption5;
                            }
                        }
                        //not_image6    
                        if($item->not_image6){
                            $listProducts[6]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image6;

                            if($item->imglink6) {            
                                $list6 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink6 );
                                $listProducts[6]->product = $list6[0];
                            }
                            if($item->linkdetail6) {     
                                $listProducts[6]->detail = $item->linkdetail6;
                            }
                            if($item->imgcaption6) { 
                                $listProducts[6]->caption = $item->imgcaption6;
                            }
                        }
                        //not_image7    
                        if($item->not_image7){
                            $listProducts[7]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image7;
                        
                            if($item->imglink7) {
                                $list7 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink7 );
                                $listProducts[7]->product = $list7[0];
                            }
                            if($item->linkdetail7) {     
                                $listProducts[7]->detail = $item->linkdetail7;
                            }
                            if($item->imgcaption7) { 
                                $listProducts[7]->caption = $item->imgcaption7;
                            }
                        }
                        //not_image8    
                        if($item->not_image8){
                            $listProducts[8]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image8;
                        
                            if($item->imglink8) {            
                                $list8 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink8 );
                                $listProducts[8]->product = $list8[0];
                            }
                            if($item->linkdetail8) {     
                                $listProducts[8]->detail = $item->linkdetail8;
                            }
                            if($item->imgcaption8) { 
                                $listProducts[8]->caption = $item->imgcaption8;
                            }
                        }
						//not_image9    
                        if($item->not_image9){
                            $listProducts[9]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image9;
                        
                            if($item->imglink9) {            
                                $list9 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink9 );
                                $listProducts[9]->product = $list9[0];
                            }
                            if($item->linkdetail9) {     
                                $listProducts[9]->detail = $item->linkdetail9;
                            }
                            if($item->imgcaption9) { 
                                $listProducts[9]->caption = $item->imgcaption9;
                            }
                        }
						//not_image10    
                        if($item->not_image10){
                            $listProducts[10]->image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image.'/'. $item->not_image10;
                        
                            if($item->imglink10) {            
                                $list10 = $this->product_model->fetch_join1( $select, "LEFT", "tbtt_shop", "pro_user = sho_user", "pro_id = " .(int)$item->imglink10 );
                                $listProducts[10]->product = $list10[0];
                            }
                            if($item->linkdetail10) {     
                                $listProducts[10]->detail = $item->linkdetail10;
                            }
                            if($item->imgcaption10) { 
                                $listProducts[10]->caption = $item->imgcaption10;
                            }
                        }
                        $data['listProducts'] = $listProducts;  
			
	/*get list product */		
	$array_id = $item->imglink1 . ',' . $item->imglink2 . ',' . $item->imglink4 . ',' . $item->imglink5 . ',' . $item->imglink6 . ',' . $item->imglink7 . ',' . $item->imglink8 . ',' . $item->imglink9 . ',' .  $item->imglink10;		
	$data['listProducts2'] = $this->product_model->fetch("pro_id, pro_name, pro_sku, pro_cost, pro_currency, pro_image, pro_dir", "pro_id IN (" . $array_id . ")");

        
        #BEGIN: Load comment
        $this->load->model('comment_model');
        $this->comment_model->setCurLink(uri_string());
        $countcomments = $this->comment_model->getComments(array('noc_content' => $not_id));
        $data['countcomments'] = count($countcomments);
        
        if( $this->session->userdata('sessionUser') == $item->not_user ) {
            $comments = $this->comment_model->getComments(array('noc_content' => $not_id, 'noc_reply' => 0));
        } else {
            $comments = $this->comment_model->getComments(array('noc_content' => $not_id, 'noc_reply' => 0, 'noc_user' => $this->session->userdata('sessionUser') ) );
        }
        
        foreach($comments as $key=>$value) {            
           $comments[$key]['replycomment'] =  $this->comment_model->getComments(array('noc_reply' => $value['noc_id']));  
        }  
        
        $data['comments'] = $comments;
	
	$data['list_related']	= $this->content_model->fetch("not_id, not_title, not_begindate, not_view, not_image, not_dir_image, not_description","id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_user =  " . $item->not_user . " AND not_id != " . $item->not_id, "not_id", "DESC", 0 , 5);            	
	$data['list_views']	= $this->content_model->fetch("not_id, not_title, not_begindate, not_view, not_image, not_dir_image, not_description","id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_user =  " . $item->not_user . " AND not_id != " . $item->not_id, "not_view", "DESC", 0 , 5);

	
         
        $data['sitedesc'] = $item->not_description ? $item->not_description : $shop->fl_desc;
        $data['sitekeyword'] = $item->not_keywords ? $item->not_keywords :  $shop->fl_name .','.$shop->fl_link;        
        $data['ogurl'] = current_url();
        $data['ogtype'] = 'article';        
        $data['ogtitle'] = $item->not_title ? $item->not_title : $shop->fl_name;        
        $data['ogdescription'] = $item->not_description ? $item->not_description : $shop->fl_desc;        
        if($item->not_image!=''){
            $data['ogimage'] = DOMAIN_CLOUDSERVER.'media/images/content/'.$item->not_dir_image.'/'.$item->not_image; 
        } else {
            $data['ogimage'] = DOMAIN_CLOUDSERVER.'media/images/flatform/'.$shop->fl_dir_banner.'/'.$shop->fl_banner;  
        }
        
        $data['item'] = $item;
	
        $data['head_footer'] = $shop;
	
        $data['list_related'] = $this->content_model->fetch_join("id_category,not_id, not_title, not_begindate, not_view, not_image, not_dir_image, not_description", "LEFT", "tbtt_user", "not_user = use_id", "id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_pro_cat_id = " . $item->not_pro_cat_id . " AND not_id != " . $item->not_id . " AND not_user IN(" . $shop->fl_listshop . ")", "not_id", "DESC", 0 , 5);            	
	
	$data['list_views'] = $this->content_model->fetch_join("id_category,not_id, not_title, not_begindate, not_view, not_image, not_dir_image, not_description", "LEFT", "tbtt_user", "not_user = use_id", "id_category = 16 AND not_status = 1  AND not_publish = 1 AND not_pro_cat_id = " . $item->not_pro_cat_id . " AND not_id != " . $item->not_id . " AND not_user IN(" . $shop->fl_listshop . ")", "not_view", "DESC", 0 , 5);
        
	// DS gian hang do d2 phat trien
        $listShop = $this->getListShop($userid);
        $data['listShop'] = $listShop;
        
        $this->load->view('flatform/news/detail', $data);        
    }
    
    function products() {
        $data['menuactive'] = 'product';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'"); 
        $dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
        $shop->fl_district = $dp->DistrictName;
        $shop->fl_province = $dp->ProvinceName;
		
        $data['sitedesc'] = $shop->fl_desc;
        $data['sitekeyword'] = $shop->fl_name .','.$shop->fl_link;
        $data['ogurl'] = site_url('flatform/product');
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Sản phẩm - ' . $shop->fl_name;
        $data['ogimage'] = DOMAIN_CLOUDSERVER.'media/images/flatform/'.$shop->fl_dir_banner.'/'.$shop->fl_banner;     
        $data['ogdescription'] = $shop->fl_desc;
        $data['head_footer'] = $shop;      
        
        /*$listpro = $this->product_model->fetch('pro_category', "pro_status = 1 AND pro_user IN (" . $shop->fl_listshop . ")");
        $arrCat = array();
        foreach ($listpro as $item){
            $arrCat[] = $item->pro_category;
        }
        $listCat = implode(',',$arrCat);*/
        $data['categories'] = $this->loadCategoryRoot(0,0,0);     
        //var_dump($data['categories']);
        
        if($shop->fl_listshop != ''){
            foreach ($data['categories'] as $key => $value) {	    
                $listCatId = $value->cat_id . $this->loadListCate($value->cat_id, 0);	    
                $select = "id, id as dp_id, pro_id, pro_name, pro_cost, pro_image, pro_dir, pro_type, shop_type, pro_minsale";
                $value->list_product = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', '', '', '', "pro_status = 1 AND pro_category IN (".$listCatId.") AND pro_user IN (".$shop->fl_listshop.")".' GROUP BY pro_id', "pro_id", "DESC",0,20);
            }
        }
        $list_favorite = array();
        $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
        foreach ($pro_favorite as $key => $item){
            $list_favorite[] = $item->prf_product;
        }
        $data['favorite'] = $list_favorite;		
        $this->load->view('flatform/products/default', $data);        
    }
    
    function favorite_pro() {        
	$data['menuactive'] = 'product';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
        $data['head_footer'] = $shop;
	
        $listShop = $this->getListShop($shop->fl_user);
        $data['listShop'] = $listShop;	
        
	// Get list child category product 
	$listIdCat = $cat_id . $this->loadListCate($cat_id, 0); 
	
        $data['categories'] = $this->loadCategoryRoot(0,0,0,$cat_id);
        
        $data['catcurent'] = $cat_id;
        $limit = 20;
        $page = array('page');
        $getpage = $this->uri->uri_to_assoc(3, $page);
        if ($getpage['page'] != FALSE && (int)$getpage['page'] > 0) {
            $start = (int)$getpage['page'];
        } else {
            $start = 0;
        }
        $pro_ = array();
        if($shop->fl_listshop != ''){
            $pro_ = $this->product_favorite_model->fetch_join('*,'.DISCOUNT_QUERY,'INNER','tbtt_product','tbtt_product_favorite.prf_product = pro_id','pro_type = 0 AND pro_user IN ('.$shop->fl_listshop.') AND prf_user = '.(int)$this->session->userdata('sessionUser'), $sort, $by, $start, $limit);
            
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->product_favorite_model->fetch_join('*,'.DISCOUNT_QUERY,'INNER','tbtt_product','tbtt_product_favorite.prf_product = pro_id','pro_type = 0 AND pro_user IN ('.$shop->fl_listshop.') AND prf_user = '.(int)$this->session->userdata('sessionUser'), $sort, $by));

            $config['base_url'] = base_url() . 'flatform/' . $this->uri->segment(2) . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['uri_segment'] = 6;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            
            $data['linkPage'] = $this->pagination->create_links();
        }
        $data['listProduct'] = $pro_;
               
        $this->load->view('flatform/products/category', $data);        
    }
    
    function cat_pro($cat_id) {        
	$data['menuactive'] = 'product';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
        $dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
	
        $listShop = $this->getListShop($shop->fl_user);
        $data['listShop'] = $listShop;	
        
	// Get list child category product 
	$listIdCat = $cat_id . $this->loadListCate($cat_id, 0); 
	
	$data['catcurent'] = $cat_id;
        if($shop->fl_listshop != ''){
            $limit = 20;
            
            $action = array('cat');
            $getVar = $this->uri->uri_to_assoc(3, $action);
            
            $page = array('page');
            $getpage = $this->uri->uri_to_assoc(6, $page);
            if ($getpage['page'] != FALSE && (int)$getpage['page'] > 0) {
                $start = (int)$getpage['page'];
            } else {
                $start = 0;
            }
            
            $category = $this->category_model->get("cat_name", "cat_id = " . (int)$getVar['cat'] . ' AND cat_status = 1');
            $data['catname'] = $category->cat_name;
            $select = '*, id as dp_id,'.DISCOUNT_QUERY;
            $where = "pro_status = 1 AND pro_user IN (" . $shop->fl_listshop . ") AND pro_category IN (" . $listIdCat . ")";
            $data['listProduct'] = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', '', '', '', $where . ' GROUP BY pro_id', 'pro_id','DESC', $start, $limit);
            
            $listpro = $this->product_model->fetch('pro_category', "pro_status = 1 AND pro_user IN (" . $shop->fl_listshop . ")");
            $arrCat = array();
            foreach ($listpro as $item){
                $arrCat[] = $item->pro_category;
            }
            $listCat = implode(',',$arrCat);
            
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', '', '', '', $where . ' GROUP BY pro_id', 'pro_id','DESC'));

            $config['base_url'] = base_url() . 'flatform/' . $this->uri->segment(2) . '/cat/' . $getVar['cat'] . '/' . $this->uri->segment(5) . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['uri_segment'] = 6;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);

            $data['linkPage'] = $this->pagination->create_links();
        }
        $data['categories'] = $this->loadCategoryRoot(0,0,0,$listCat);
        $list_favorite = array();
        $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
        foreach ($pro_favorite as $key => $item){
            $list_favorite[] = $item->prf_product;
        } 
        $data['favorite'] = $list_favorite;      
        $this->load->view('flatform/products/category', $data);        
    }
    
    function product($pro_id) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $data['menuactive'] = 'products';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
        $userid = $shop->fl_user;  
        $type = 0;
        //get detail pro
        $action = array('product');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        $proid = (int)$getVar['product'];
        if ($this->session->userdata('sessionUser') > 0) {
            $dataEye = array(
                'idview' => (int)$getVar['detail'],
                'userid' => $this->session->userdata('sessionUser'),
                'typeview' => 1,
                'timeview' => 1
            );
            $this->load->model('eye_model');
            $checkEye = $this->eye_model->fetch("*", "idview = " . $proid . "  AND userid= " . $userid . " AND typeview = 1 ", "id", 'DESC');
            if (count($checkEye) == 0)
                $this->eye_model->add($dataEye);
        }

        if ($getVar['product'] != FALSE) {
            //BÁO CÁO SP
            
            $this->load->model('reports_model');
            $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rp_id', 'ASC');
            $data['listreports'] = $listreports;
            
            //END BÁO CÁO SP
            #BEGIN: Check exist product by id   
            $select = "* , (af_rate) AS aff_rate" . DISCOUNT_QUERY;// . ", count(*) as dem"
            $product = $this->product_model->fetch_join1($select, "LEFT","tbtt_user","tbtt_product.pro_user = tbtt_user.use_id", "pro_status = 1 AND pro_id = " . $proid . " AND use_status = 1 AND tbtt_user.use_group = 3", "pro_id", "DESC", 0, 20);               
            $shop = $this->shop_model->get("sho_name, sho_link, domain, shop_type", "sho_user = ".$product[0]->pro_user." AND sho_status = 1");
            $data['shop'] = $shop;
            // AND pro_category IN (".$listCatId.")
            $pro_id = $product[0]->pro_id;
            if ($product && $pro_id <= 0) {
                redirect('/flatform/product', 'location');
                die();
            }
            ##BEGIN::Check product have TRƯỜNG QUI CÁCH
            
            $this->load->model('detail_product_model');
            $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$pro_id);
            ##BEGIN::Check product have TRƯỜNG QUI CÁCH
            //Nếu có TQC
            if ($list_style) {
                $product[0] = $this->product_model->getProAndDetail($select . ", T2.*", "pro_id = " . (int)$proid . " AND pro_user = " . (int)$product[0]->pro_user . " AND pro_status = 1", $proid);
            }
            #END Check exist product by id
            $this->load->library('bbcode');
            #BEGIN: Update view
            if (!$this->session->userdata('sessionViewProduct_' . $proid)) {
                $this->product_model->update(array('pro_view' => (int)$product[0]->pro_view + 1), "pro_id = " . $proid);
                $this->session->set_userdata('sessionViewProduct_' . $proid, 1);

                //dem so luong click link cho af
                $this->add_view_af_share($proid);
            }
            #END Update view
            #Begin:: SEO keyword meta tag
            $img_pro = explode(',', $product[0]->pro_image);
            
            $this->load->helper('text');
	    $data['sitedesc'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product[0]->pro_descr)), 255);
            $data['sitekeyword'] = $product[0]->pro_keyword;
            $data['ogtype'] = "product";
            $data['ogtitle'] = $product[0]->pro_name;
            $data['ogimage'] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product[0]->pro_dir . '/thumbnail_2_' . $img_pro[0];
            $data['ogdescription'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product[0]->pro_descr)), 255);

            $data['shop_pro'] = $shop_pro = $this->shop_model->get("sho_name,sho_link, domain, sho_user, sho_id", "sho_user = " . (int)$product[0]->pro_user);
            $data['linkshop'] = $protocol . $shop_pro->sho_link . domain_site.'/';
            $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
            $data['ogurl'] = base_url() . 'flatform/product/' . $product[0]->pro_id . '/' . RemoveSign($product[0]->pro_name) . $af;
            
            #END:: SEO keyword meta tag
            #BEGIN: Get product by id and relate info
            //Check in_stock
            if ($product[0]->pro_instock < 1) {
                $data['product']->status = array(
                    'val' => TRUE,//Has message
                    'pro_instock' => FALSE,//No products
                    'message' => 'Sản phẩm hết hàng'
                );
            }
            $data['products'] = $product;
            $data['category'] = $this->category_model->get("cat_id, cat_name, cat_descr, cat_status, cate_type", "cat_id = " . (int)$product[0]->pro_category);
            #END Get product by id and relate info
            //Get shop of product, by BaoTran
            $select = 'id as dp_id,pro_id,pro_name,pro_dir,pro_image,pro_cost,pro_minsale, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type,'.DISCOUNT_QUERY;
            $where = "pro_status = 1 AND pro_id != ".(int)$product[0]->pro_id." AND pro_type = ".$type." AND pro_user = ".(int)$product[0]->pro_user;
            $same_store_products = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where.' GROUP BY pro_id', 'pro_id','DESC', 0, 6);
            $data['same_store_products'] = $same_store_products;
            //Get trường quy cách nếu có                            

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

                $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$pro_id . $dp_color);
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
                $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$pro_id . $dp_color . $dp_size);
                if ($li_material) {
                    foreach ($li_material as $km => $vm) {
                        $material_arr[] = $vm->dp_material;
                    }
                    $data['ar_material'] = array_unique($material_arr);
                }
            }
            // Get product promotion
            if ($product[0]->pro_user != $this->session->userdata('sessionUser')) {
                $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $pro_id));
            }
            $this->load->model('product_affiliate_user_model');
            //get thông báo chọn bán hay chưa
            if ($this->session->userdata('sessionUser')) {
                $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $pro_id));
                if ($selected_sale) {
                    $data['selected_sale'] = $selected_sale;
                }
            }
            
            $list_favorite = array();
            $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
            foreach ($pro_favorite as $key => $item){
                $list_favorite[] = $item->prf_product;
            } 
            $data['favorite'] = $list_favorite;
        }
        $this->load->view('flatform/products/detail', $data);        
    }
    
    function coupons() {
        $data['menuactive'] = 'coupon';
	$fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
	
        $data['categories'] = $this->loadCategoryRoot(0,0,2);	
        if($shop->fl_listshop != ''){
            foreach ($data['categories'] as $key => $value) {	    
                $listCatId = $value->cat_id . $this->loadListCate($value->cat_id, 2);	    
                $select = "id, id as dp_id, pro_id, pro_name, pro_detail, pro_descr, pro_keyword, pro_cost, pro_currency, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_saleoff_value, pro_hondle, pro_view, sho_name, sho_begindate, pre_name, pro_vote_total, pro_vote, pro_type";
                $value->list_product = $this->product_model->fetch_join($select . DISCOUNT_QUERY, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "LEFT",'tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_status = 1 AND pro_category IN (".$listCatId.") AND pro_user IN (".$shop->fl_listshop.")".' GROUP BY pro_id', "pro_id", "DESC",0,20);
            }
        }
        $list_favorite = array();
        $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
        foreach ($pro_favorite as $key => $item){
            $list_favorite[] = $item->prf_product;
        } 
        $data['favorite'] = $list_favorite;  
        $this->load->view('flatform/coupons/default', $data);       
    }
    
    function favorite_cou() {        
	$data['menuactive'] = 'coupon';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
        $data['head_footer'] = $shop;
        $listShop = $this->getListShop($shop->fl_user);
        $data['listShop'] = $listShop;	
        
        
        $limit = 20;
        $page = array('page');
        $getpage = $this->uri->uri_to_assoc(3, $page);
        if ($getpage['page'] != FALSE && (int)$getpage['page'] > 0) {
            $start = (int)$getpage['page'];
        } else {
            $start = 0;
        }


	// Get list child category product 
	$listIdCat = $cat_id . $this->loadListCate($cat_id, 2); 
	
        if($shop->fl_listshop != ''){            
            $listpro = $this->product_model->fetch('pro_category', "pro_status = 1 AND pro_user IN (" . $shop->fl_listshop . ")");
            
            $arrCat = array();
            foreach ($listpro as $item){
                $arrCat[] = $item->pro_category;
            }
            $listCat = implode(',',$arrCat);
            $cou_ = array();
            $cou_ = $this->product_favorite_model->fetch_join('*,'.DISCOUNT_QUERY,'INNER','tbtt_product','tbtt_product_favorite.prf_product = pro_id','pro_type = 2 AND pro_user IN ('.$shop->fl_listshop.') AND prf_user = '.(int)$this->session->userdata('sessionUser'), $sort, $by, $start, $limit);
            $data['listProduct'] = $cou_;
            
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->product_favorite_model->fetch_join('*,'.DISCOUNT_QUERY,'INNER','tbtt_product','tbtt_product_favorite.prf_product = pro_id','pro_type = 2 AND pro_user IN ('.$shop->fl_listshop.') AND prf_user = '.(int)$this->session->userdata('sessionUser'), $sort, $by));

            $config['base_url'] = base_url() . 'flatform/' . $this->uri->segment(2) . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['uri_segment'] = 6;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);
            
            $data['linkPage'] = $this->pagination->create_links();
        }
        $data['categories'] = $this->loadCategoryRoot(0,0,2,$listCat);
        
        $data['catcurent'] = $cat_id;
               
        $this->load->view('flatform/coupons/category', $data);        
    }
    
    function cat_cou($cat_id) {        
	$data['menuactive'] = 'coupon';
	$fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
	
        $listShop = $this->getListShop($shop->fl_user);
        $data['listShop'] = $listShop;	
        
	// Get list child category product 
	$listIdCat = $cat_id . $this->loadListCate($cat_id, 2); 
	
        if($shop->fl_listshop != ''){            
            $listpro = $this->product_model->fetch('pro_category', "pro_status = 1 AND pro_user IN (" . $shop->fl_listshop . ")");
            $arrCat = array();
            foreach ($listpro as $item){
                $arrCat[] = $item->pro_category;
            }
            $listCat = implode(',',$arrCat);
        }
        $data['categories'] = $this->loadCategoryRoot(0,0,2,$listCat);
        
        $data['catcurent'] = $cat_id;
        
	if($shop->fl_listshop != ''){
            $limit = 20;
            
            $action = array('cat');
            $getVar = $this->uri->uri_to_assoc(3, $action);
            
            $page = array('page');
            $getpage = $this->uri->uri_to_assoc(6, $page);
            if ($getpage['page'] != FALSE && (int)$getpage['page'] > 0) {
                $start = (int)$getpage['page'];
            } else {
                $start = 0;
            }
            
            $data['listProduct'] = $this->product_model->fetch('tbtt_product.*' . DISCOUNT_QUERY, "pro_status = 1 AND pro_user IN (".$shop->fl_listshop.") AND pro_category IN (".$listIdCat.")", "pro_id", "DESC", $start, $limit);
            #BEGIN: Pagination
            $this->load->library('pagination');
            #Count total record
            $totalRecord = count($this->product_model->fetch('tbtt_product.*' . DISCOUNT_QUERY, "pro_status = 1 AND pro_user IN (".$shop->fl_listshop.") AND pro_category IN (".$listIdCat.")", "pro_id", "DESC"));

            $config['base_url'] = base_url() . 'flatform/' . $this->uri->segment(2) . '/cat/' . $getVar['cat'] . '/' . $this->uri->segment(5) . '/page/';
            $config['total_rows'] = $totalRecord;
            $config['per_page'] = $limit;
            $config['num_links'] = 5;
            $config['uri_segment'] = 6;
            $config['cur_page'] = $start;
            $this->pagination->initialize($config);

            $data['linkPage'] = $this->pagination->create_links();
        }
        $list_favorite = array();
        $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
        foreach ($pro_favorite as $key => $item){
            $list_favorite[] = $item->prf_product;
        } 
        $data['favorite'] = $list_favorite;  
        $this->load->view('flatform/coupons/category', $data);        
    }
    
    function coupon($pro_id) {
        $data['menuactive'] = 'coupon';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'"); 
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
        $data['head_footer'] = $shop;
        $userid = $shop->fl_user;  
        $type = 2;
        //get detail pro
        $action = array('coupon');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        $proid = (int)$getVar['coupon'];
        if ($this->session->userdata('sessionUser') > 0) {
            $dataEye = array(
                'idview' => (int)$getVar['detail'],
                'userid' => $this->session->userdata('sessionUser'),
                'typeview' => 1,
                'timeview' => 1
            );
            $this->load->model('eye_model');
            $checkEye = $this->eye_model->fetch("*", "idview = " . $proid . "  AND userid= " . $userid . " AND typeview = 1 ", "id", 'DESC');
            if (count($checkEye) == 0)
                $this->eye_model->add($dataEye);
        }

        if ($getVar['coupon'] != FALSE) {
            //BÁO CÁO SP
            
            $this->load->model('reports_model');
            $listreports = $this->reports_model->fetch('*', 'rp_type = 2 AND rp_status = 1', 'rp_id', 'ASC');
            $data['listreports'] = $listreports;
            
            //END BÁO CÁO SP
            
            #BEGIN: Check exist product by id   
            $select = "* , (af_rate) AS aff_rate, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type, (SELECT use_group FROM tbtt_user WHERE use_id = pro_user) AS user_group " . DISCOUNT_QUERY . ", count(*) as dem";
            //$product = $this->product_model->get($select, "pro_id = " . $proid . " AND pro_user = $userid AND pro_status = 1");
            $product = $this->product_model->fetch_join1($select, "LEFT","tbtt_user","tbtt_product.pro_user = tbtt_user.use_id", "pro_status = 1 AND pro_id = " . $proid . " AND use_status = 1 AND tbtt_user.use_group = 3 AND tbtt_user.parent_id = ".$shop->fl_user, "pro_id", "DESC", 0, 20);               
            // AND pro_category IN (".$listCatId.")
            $pro_id = $product[0]->pro_id;
            if ($product && $pro_id <= 0) {
                redirect('/flatform/coupon', 'location');
                die();
            }
            ##BEGIN::Check product have TRƯỜNG QUI CÁCH
            
            $this->load->model('detail_product_model');
            $list_style = $this->detail_product_model->fetch("*", "dp_pro_id = " . (int)$pro_id);
            ##BEGIN::Check product have TRƯỜNG QUI CÁCH
            //Nếu có TQC
            if ($list_style) {
                $product[0] = $this->product_model->getProAndDetail("*, (af_rate) AS aff_rate, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type, (SELECT use_group FROM tbtt_user WHERE use_id = pro_user) AS user_group " . DISCOUNT_DP_QUERY . " , count(*) as dem, T2.*", "pro_id = " . $proid . " AND pro_user = $idUser AND pro_status = 1", $proid);
            }

            #END Check exist product by id
            $this->load->library('bbcode');
            #BEGIN: Update view
            if (!$this->session->userdata('sessionViewProduct_' . $proid)) {
                $this->product_model->update(array('pro_view' => (int)$product[0]->pro_view + 1), "pro_id = " . $proid);
                $this->session->set_userdata('sessionViewProduct_' . $proid, 1);

                //dem so luong click link cho af
                $this->add_view_af_share($proid);
            }
            #END Update view
            #Begin:: SEO keyword meta tag
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $this->load->helper('text');
            $data['$sitedesc'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product[0]->pro_descr)), 255);
            $data['$sitekeyword'] = $product[0]->pro_keyword;
            $img_pro = explode(',', $product[0]->pro_image);
            $data['ogtype'] = "product";
            $data['ogtitle'] = $product[0]->pro_name;
            $data['ogimage'] = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product[0]->pro_dir . '/thumbnail_2_' . $img_pro[0];
            $data['ogdescription'] = cut_string_unicodeutf8(strip_tags(html_entity_decode($product[0]->pro_descr)), 255);

            $af = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
            $data['ogurl'] = base_url() . 'flatform/coupon/' . $product[0]->pro_id . '/' . RemoveSign($product[0]->pro_name) . $af;
            
             #END:: SEO keyword meta tag
            #BEGIN: Get product by id and relate info
            $data['products'] = $product;
            //Check in_stock
            if ($product[0]->pro_instock < 1) {
                $data['product']->status = array(
                    'val' => TRUE,//Has message
                    'pro_instock' => FALSE,//No products
                    'message' => 'Sản phẩm hết hàng'
                );
            }
            $data['category'] = $this->category_model->get("cat_id, cat_name, cat_descr, cat_status, cate_type", "cat_id = " . (int)$product[0]->pro_category);
            #END Get product by id and relate info
            //Get shop of product, by BaoTran
            $data['shop_pro'] = $shop_pro = $this->shop_model->get("sho_name,sho_link, domain, sho_user, sho_id", "sho_user = " . (int)$product[0]->pro_user);
            $data['linkshop'] = $protocol . $shop_pro->sho_link . domain_site.'/';
            $same_store_products = $this->product_model->fetch('pro_id,pro_name,pro_dir,pro_image,pro_cost,pro_minsale, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type,'.DISCOUNT_QUERY, "pro_status = 1 AND pro_id != ".(int)$product[0]->pro_id." AND pro_type = ".$type." AND pro_user = ".(int)$product[0]->pro_user, "pro_id", "DESC", 0, 6);               
            $data['same_store_products'] = $same_store_products;
            //Get trường quy cách nếu có                            

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

                $li_size = $this->detail_product_model->fetch("dp_size", "dp_pro_id = " . (int)$pro_id . $dp_color);
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
                $li_material = $this->detail_product_model->fetch("dp_material", "dp_pro_id = " . (int)$pro_id . $dp_color . $dp_size);
                if ($li_material) {
                    foreach ($li_material as $km => $vm) {
                        $material_arr[] = $vm->dp_material;
                    }
                    $data['ar_material'] = array_unique($material_arr);
                }
            }
            // Get product promotion
            if ($product->pro_user != $this->session->userdata('sessionUser')) {
                $data['promotions'] = $this->product_promotion_model->getPromotion(array('pro_id' => $pro_id));
            }
            $this->load->model('product_affiliate_user_model');
            //get thông báo chọn bán hay chưa
            if ($this->session->userdata('sessionUser')) {
                $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $pro_id));
                if ($selected_sale) {
                    $data['selected_sale'] = $selected_sale;
                }
            }
            $list_favorite = array();
            $pro_favorite = $this->product_favorite_model->fetch_join('prf_id,prf_product','','','','prf_user = '.(int)$this->session->userdata('sessionUser'));
            foreach ($pro_favorite as $key => $item){
                $list_favorite[] = $item->prf_product;
            } 
        }
        $this->load->view('flatform/coupons/detail', $data);        
    }
    
    function report(){
        $pro_id = (int)$this->input->post("pro_id");
        $this->load->model('report_detail_model');
        $query = $this->report_detail_model->get("*","rpd_by_user = " . $this->session->userdata('sessionUser') . " AND rpd_product = ". $pro_id);
        if(empty($query)) {
            $form_data = array(
                "rpd_type" => 2,
                "rpd_content" => 0,
                "rpd_product" => $pro_id,
                "rpd_reportid" => $this->input->post("rp_id"),
                "rpd_by_user" => $this->session->userdata('sessionUser'),
                "rpd_status" => 0
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
                if($this->input->post("rp_id") == 11){
                    $cntreports = $this->input->post("rpd_reason");
                }else{
                    $cntreports = $reports->rp_desc;
                }

                $body1 = 'Chào shop <a href="' . $this->input->post("sho_link") . '" target="_blank" alt="' . $this->input->post("sho_name") . '">' . $this->input->post("sho_name") . '</a>! <br/>Sản phẩm <a href="' . $this->input->post("pro_link") . '" target="_blank" alt="' . $this->input->post("pro_name") . '">' . $this->input->post("pro_name") . '</a> của bạn vừa bị báo cáo với nội dung: "<b>' . $cntreports . '</b>".<br/>Vui lòng CHỈNH SỬA hoặc là XÓA sản phẩm của bạn.';			
                $this->smtpmailer($emailto, $from, $from_name, $subject, $body1);
                
                $body2 = 'Chào Admin! <br/>Admin đã nhận được một báo cáo từ tài khoản: ' . $byuser->use_fullname . ' <font small>[' . $byuser->use_email . ']</font>. <br/> ' . $byuser->use_fullname . ' báo cáo sản phẩm <a href="' . $this->input->post("pro_link") . '" target="_blank" alt="' . $this->input->post("pro_name") . '">' . $this->input->post("pro_name") . '</a> của gian hàng <a href="' . $this->input->post("sho_link") . '" target="_blank" alt="' . $this->input->post("sho_name") . '">' . $this->input->post("sho_name") . '</a> với nội dung: "<b>' . $cntreports . '</b>". <br/>Admin vui lòng đăng nhập vào quản trị để xử lý báo cáo.';
                $this->smtpmailer(settingEmail_1, $from, $from_name, $subject, $body2);
                echo '1'; exit();
            }
        }
        echo '0'; exit();
    }
    
    function about() {
        $data['menuactive'] = 'about';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
        $dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;        
	$shop->fl_video = $this->get_youtube_id_from_url($shop->fl_video);
	$data['sitedesc'] = $shop->fl_desc;
        $data['sitekeyword'] = $shop->fl_name .','.$shop->fl_link;
	$data['ogurl'] = site_url('flatform/about');
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Giới thiệu - ' . $shop->fl_name;
        $data['ogimage'] = DOMAIN_CLOUDSERVER.'media/images/flatform/'.$shop->fl_dir_banner.'/'.$shop->fl_banner;     
        $data['ogdescription'] = $shop->fl_desc;
        $data['head_footer'] = $shop;       
        
        $this->load->view('flatform/about/default', $data);
    }
   
    function contact() {
        $data['menuactive'] = 'contact';
        $fl_Link = $this->getShopLink();
        $shop  = $this->flatform_model->get("*", "fl_link = '".$fl_Link."'");  
	$dp = $this->district_model->get("DistrictName,ProvinceName", "DistrictCode = '".$shop->fl_district ."'");
	$shop->fl_district = $dp->DistrictName;
	$shop->fl_province = $dp->ProvinceName;
	$data['sitedesc'] = $shop->fl_desc;
        $data['sitekeyword'] = $shop->fl_name .','.$shop->fl_link;
	$data['ogurl'] = site_url('flatform/contact');
        $data['ogtype'] = 'website';
        $data['ogtitle'] = 'Liên hệ - ' . $shop->fl_name;
        $data['ogimage'] = DOMAIN_CLOUDSERVER.'media/images/flatform/'.$shop->fl_dir_banner.'/'.$shop->fl_banner;     
        $data['ogdescription'] = $shop->fl_name.' | Địa chỉ: '.$shop->fl_address.', '.$shop->fl_district.', '.$shop->fl_province.' | Email: '.$shop->fl_email.' | Mobile: '.$shop->fl_mobile ;
        $data['head_footer'] = $shop;
	
        if($this->input->post('contact_submit')==1){            
            $this->load->helper('form');
            $this->load->library('form_validation');
            #BEGIN: Set rules
            $this->form_validation->set_rules('contact_fullname', 'lang:name_contact_label_detail_contact', 'trim|required');
            $this->form_validation->set_rules('contact_email', 'lang:email_contact_label_detail_contact', 'trim|required|valid_email');
            $this->form_validation->set_rules('contact_phone', 'lang:phone_contact_label_detail_contact', 'trim|required');
            $this->form_validation->set_rules('contact_address', 'lang:address_contact_label_detail_contact', 'trim|required');
            $this->form_validation->set_rules('contact_subject', 'lang:title_contact_label_detail_contact', 'trim|required');
            $this->form_validation->set_rules('contact_content', 'lang:content_contact_label_detail_contact', 'trim|required|min_length[10]|max_length[1000]');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
            $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            
            if ($this->form_validation->run() != FALSE) {
                
                $this->load->library('email');
                $config['useragent'] = $this->lang->line('useragen_mail_detail_contact');
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $messageContact = $this->lang->line('info_title_sender_detail_contact')
                        . $this->lang->line('fullname_sender_detail_contact')
                        . $this->input->post('contact_fullname') . '<br/>'
                        . $this->lang->line('address_sender_detail_contact')
                        . $this->input->post('contact_address') . '<br/>'
                        . $this->lang->line('phone_sender_detail_contact')
                        . $this->input->post('contact_phone') . '<br/>'
                        . $this->lang->line('content_sender_detail_contact')
                        . nl2br($this->filter->html($this->input->post('contact_content')));
                $this->email->from($this->input->post('contact_email'));
                
                if (trim($shop->fl_email) != '') {
                    $emailContact = $shop->fl_email;
                } else {
                    $emailContact = settingEmail_1;
                }
                
                $this->email->to($emailContact);
                $this->email->subject($this->input->post('title_contact'));
                $this->email->message($messageContact);

                $folder = folderWeb;

                //$folder='';
                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');

                $return_email = $this->smtpmailer($emailContact, $this->lang->line('EMAIL_MEMBER_TT24H'), $this->input->post('contact_subject'), "Thư liên hệ tại " . $domainName, $messageContact);
                
                if ($return_email) {
                    $data['successContact'] = 1; 
                }
                        
            } else {
                $data['contact_fullname'] = $this->input->post('contact_fullname');
                $data['contact_email'] = $this->input->post('contact_email');
                $data['contact_phone'] = $this->input->post('contact_phone');
                $data['contact_address'] = $this->input->post('contact_address');
                $data['contact_subject'] = $this->input->post('contact_subject');
                $data['contact_content'] = $this->input->post('contact_content');
                
                $data['successContact'] = 0;
            }
        }
        
	$this->load->library('GMap');
	$this->gmap->GoogleMapAPI();
	// valid types are hybrid, satellite, terrain, map
	$this->gmap->setMapType('map');
	$this->gmap->setWidth('100%');
	$this->gmap->setHeight('420px');
	
	// you can also use addMarkerByCoords($long,$lat)
	// both marker methods also support $html, $tooltip, $icon_file and $icon_shadow_filename
	$address = $shop->fl_address.', '.$shop->fl_district.', '.$shop->fl_province;
	$data['address'] = $address;
	
	$this->gmap->addMarkerByAddress($address, $shop->fl_name, '<div style="color: #1155CC; font-size:120%;font-weight: bold;">' . $shop->fl_name . '</div><div style="color: #f01929;">' . $address . '</div><div style="color: #f01929;">' . $shop->fl_descr . '</div><div style="text-align:left; font-weight:bold;color: #f01929;">Điện Thoại: ' . $shop->fl_mobile . ' - ' . $shop->fl_hotline . '</div>');

	$data['headerjs'] = $this->gmap->getHeaderJS();
	$data['headermap'] = $this->gmap->getMapJS();
	$data['onload'] = $this->gmap->printOnLoad();
	$data['map'] = $this->gmap->printMap();
	
        $this->load->view('flatform/contact/default', $data); 
    }
    
    function loadListCate($cat_id, $type){        
        $listidcat = '';
        $select = "cat_id";
        $whereTmp = "cat_status = 1 and parent_id = '$cat_id' and cate_type = '$type'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");	
        if (count($category) > 0) {
            foreach ($category as $key => $row) { 
                $listidcat .=  ','.$row->cat_id;                           
                $listidcat .= $this->loadListCate($row->cat_id, $type);
            }
        }
        return $listidcat;
    }    
    
    public function getListShop($userid){
        $where = "sho_status = 1 AND use_status = 1 AND use_group = 3 AND parent_id = " . (int)$userid;        
        if($this->input->post('keysearch')!=""){
            $keysearch = $this->input->post('keysearch');
            $where .= " AND sho_name like %".$keysearch."%";
        }
        $mySql = "SELECT sho_user,sho_name,sho_link,sho_logo,sho_dir_logo,domain FROM tbtt_shop "
                . "LEFT JOIN tbtt_user ON use_id = sho_user "
                . "WHERE ".$where."  ORDER BY sho_id DESC";
        
        $query = $this->db->query($mySql);
        return $query->result();
    }
    
    public function showDistrictName($district_code){
	$re = $this->district_model->get("DistrictName", "DistrictCode = ".$district_code);
	return $re->DistrictName;
    }
    
    public function showProvinceName($province_code){
	$re = $this->district_model->get("ProvinceName", "ProvinceCode = ".$province_code);
	return $re->ProvinceName;
    } 
    
    function comment() {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('noc_name', 'lang:tên', 'trim|required');
        $this->form_validation->set_rules('noc_comment', 'lang:nội dung', 'trim|required');
        $this->form_validation->set_rules('noc_content', 'lang:bài viết', 'trim|required');
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            $comment = array();
            $comment['noc_comment'] = $this->input->post('noc_comment');
            $comment['noc_content'] = $this->input->post('noc_content');
            $comment['noc_reply']   = $this->input->post('noc_reply');
            $comment['noc_date'] = date('Y-m-d H:i:s');            
            $userID = (int)$this->input->post('noc_user');            
            $user = $this->user_model->get("use_id, use_fullname, use_email, use_phone, avatar", "use_id = ". $userID);
            $comment['noc_name'] = $user->use_fullname;
            $comment['noc_email'] = $user->use_email;
            $comment['noc_user'] = $user->use_id;
            $comment['noc_phone'] = $user->use_phone;
            $comment['noc_avatar'] = $user->avatar;
            $this->load->model('comment_model');
            $this->comment_model->add($comment);
            $result = array('error' => false, 'comment' => $comment);
        } else {
            $validator = & _get_validation_object();
            $error_messages = $validator->_error_array;
            $result = array('error' => true, 'error' => $error_messages);
        }
        echo json_encode($result);
        exit();
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

    public function getDomainNoProtocal()
    {
        $result = '';
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[1] . '.' . $arrUrl[2];
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

    public function get_youtube_id_from_url($url)
    {
        if (stristr($url, 'youtu.be/')) {
            @preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
            return $final_ID[4];
        } else {
            @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
            return $IDD[5];
        }
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
    
    function get_shop_nearest($userId)
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
    /**/    
        
    function add()
    {
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'flatform';
	
		if (! $this->session->userdata('sessionUser')) {
            redirect(base_url() . 'login', 'location');
        }

        if ($this->session->userdata('sessionGroup') == Developer2User) {
	    
        } else {
            redirect(base_url() . 'account', 'location');
            die();
        }
		
        $userid = $this->session->userdata('sessionUser');
        $data['user'] = $this->user_model->get("use_email,use_mobile,use_phone,use_province,user_district,use_address", "use_id = ".$userid);
        $shopedit = $this->flatform_model->get("*","fl_user = " . $userid);        
        if(empty($shopedit)) {
            $this->db->insert("tbtt_flatform", array('fl_user' => $userid, 'fl_createdate' => date('Y-m-d H:i:s', time())));       
        } 
        
        if ($this->input->post('update') == 1) {
            $this->load->helper('form');
            $this->load->library('form_validation');        
            /*set_rules*/
            $this->form_validation->set_rules('fl_name', 'lang:Tên gian hàng', 'required');
            $this->form_validation->set_rules('fl_link', 'lang:Link gian hàng', 'required');
            $this->form_validation->set_rules('fl_desc', 'lang:Mô tả gian hàng', 'required');
            $this->form_validation->set_rules('fl_mobile', 'lang:Số di động', 'required');
            $this->form_validation->set_rules('fl_email', 'Email', 'trim|required|valid_email');
            /*set_message*/
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));       
            
            if ($this->form_validation->run() != FALSE) {
                $this->load->library('upload');
                $this->load->library('image_lib');
                $pathUpload = "media/images/flatform/";
                $dirUpload = $userid;
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
                $pathTarget = '/public_html/media/images/flatform/';
                
                $listDir = array();
                $listDir = $this->ftp->list_files($pathTarget);
                $dir_logo = 'logos';
                if (!in_array($dir_logo, $listDir)) {
                    $this->ftp->mkdir($pathTarget . $dir_logo, 0775);
                }
                $dir_banner = 'banners';
                if (!in_array($dir_banner, $listDir)) {
                    $this->ftp->mkdir($pathTarget . $dir_banner, 0775);
                }
                
                if ($this->upload->do_upload('fl_logo')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        if ($shopedit->fl_logo && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/flatform/'.$dir_logo.'/' . $shopedit->fl_logo))) {
                            $this->ftp->delete_file($pathTarget . $dir_logo . '/' . $shopedit->fl_logo);
                        }
                        $logo = $uploadData['file_name'];
                        $configResize = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $logo,
                            'new_image' => $pathUpload . $dirUpload . '/' . $logo,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '1',
                            'height' => '120',
                            'master_dim' => 'height'
                        );
                        $this->image_lib->clear();
                        $this->image_lib->initialize($configResize);
                        $this->image_lib->resize();
                    }
                    $source_path = $pathUpload . $dirUpload . '/' . $logo;
                    $target_path = $pathTarget . $dir_logo . '/' . $logo;
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                } else {
                    $logo = $shopedit->fl_logo;
                }
                if ($this->upload->do_upload('fl_banner')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        if ($shopedit->fl_banner && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/flatform/'.$dir_banner.'/' . $shopedit->fl_banner))) {
                            $this->ftp->delete_file($pathTarget . $dir_banner . '/' . $shopedit->fl_banner);
                        }
                        $banner = $uploadData['file_name'];
                        $configResize = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $banner,
                            'new_image' => $pathUpload . $dirUpload . '/' . $banner,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '1600',
                            'height' => '1',
                            'master_dim' => 'width'
                        );
                        $this->image_lib->clear();
                        $this->image_lib->initialize($configResize);
                        $this->image_lib->resize();
                    }
                    $source_path = $pathUpload . $dirUpload . '/' . $banner;
                    $target_path = $pathTarget . $dir_banner . '/' . $banner;
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                } else {
                    $banner = $shopedit->fl_banner;
                }
                
                if (file_exists('media/images/flatform/' . $dirUpload . '/index.html')) {
                    @unlink('media/images/flatform/' . $dirUpload . '/index.html');
                }
                array_map('unlink', glob('media/images/flatform/' . $dirUpload . '/*'));
                @rmdir('media/images/flatform/' . $dirUpload);

                $this->ftp->close();
                
                $datapost = array(
                    'fl_name' => $this->filter->injection_html($this->input->post('fl_name')),
                    'fl_link' => $this->filter->injection_html($this->input->post('fl_link')),
                    'fl_desc' => $this->filter->injection_html($this->input->post('fl_desc')),
                    'fl_logo' => $logo, 
                    'fl_dir_logo' => $dir_logo,
                    'fl_banner' => $banner, 
                    'fl_dir_banner' => $dir_banner,
                    'fl_mobile' => $this->filter->injection_html($this->input->post('fl_mobile')),
                    'fl_hotline' => $this->filter->injection_html($this->input->post('fl_hotline')),
                    'fl_email' => $this->filter->injection_html($this->input->post('fl_email')),
                    'fl_introduction' => str_replace("\r\n", '', $this->input->post('fl_introduction')),
                    'fl_province' => $this->input->post('fl_province'),
                    'fl_district' => $this->input->post('fl_district'),
                    'fl_address' => $this->input->post('fl_address'),                
                    'fl_facebook' => $this->input->post('fl_facebook'),                
                    'fl_twitter' => $this->input->post('fl_twitter'),                
                    'fl_youtube' => $this->input->post('fl_youtube'),                
                    'fl_google_plus' => $this->input->post('fl_google_plus'),                
                    'fl_video' => $this->input->post('fl_video'),                
                    'fl_bank' => $this->input->post('fl_bank'),                
                    'fl_bank_num' => $this->input->post('fl_bank_num'),                
                    'fl_bank_address' => $this->input->post('fl_bank_address'), 
                    'fl_domain' => $this->input->post('fl_domain'), 
                    'fl_update' => date('Y-m-d H:i:s', time()),
                    'fl_status' => 1
                );
                $this->db->where('fl_id', $shopedit->fl_id);
                $this->db->update("tbtt_flatform", $datapost);  
                $this->db->trans_complete();                
                if ($this->db->trans_status() === FALSE) {
                   $data['updateshopdev'] = 0;
                } else {                    
                   $data['updateshopdev'] = 1; 
                }
            } else {
                $data['updateshopdev'] = 0;
                // chua biet lam gi
            }
        }
        
        $data['shopedit'] = $this->flatform_model->get("*","fl_user = " . $userid);
     
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC"); 
        $data['district'] = $this->district_model->find_by(array('ProvinceCode' => $data['shopedit']->fl_province));
        #load view
        $this->load->view('home/account/flatform/add', $data);
    }


    function joinshop()
    {        	
		if (! $this->session->userdata('sessionUser')) {
            redirect(base_url() . 'login', 'location');
            die;
        }
		$userid = $this->session->userdata('sessionUser');
		
		$getshopD2 = $this->flatform_model->get("*","fl_user = " . $userid);
		if(count($getshopD2) <= 0 ){
			redirect('account/flatformd2/add', 'location');
		}		
		$data['shop'] = $getshopD2;
		$data['menuType'] = 'account';		
		$data['menuSelected'] = 'flatform';			
	
		$data['listshopchild'] = $this->shop_model->fetch_join(
			"sho_user,sho_name, sho_logo, sho_dir_logo, sho_link, domain", 
			"LEFT", "tbtt_user", "sho_user = use_id", 
			"","","", 
			"sho_status = 1 AND use_group = 3 AND use_status = 1 AND parent_id = " . (int)$this->session->userdata('sessionUser'),
			"sho_user",
			"DESC");        
	
		if($this->input->post('update') == 1){	 
			$arr_listshop = $this->input->post('check');  
			$fl_listshop = implode(',', $arr_listshop);
			
			$datapost = array('fl_listshop' => $fl_listshop);
			
			$this->db->where('fl_user', $userid);
			$this->db->update("tbtt_flatform", $datapost);  
			$this->db->trans_complete();                
			if ($this->db->trans_status() === FALSE) {
			   $updatesuccess = 0;
			} else {                    
			   $updatesuccess = 1; 
			}	    
		}
	  
		$arr = explode(',', $getshopD2->fl_listshop);
		$data['check'] = $arr;
		$data['updatesuccess'] = $updatesuccess;
        # Load view
        $this->load->view('home/account/flatform/joinshop', $data);
    }

    /**/
    
    /**
     **  by BaoTran
     **  create date 16/10/2017
     **  Get all tree of Shop
     **/
    public function CheckAdminGroupTrade($user = 0){
        $return = false;
        if($user > 0){
            $grtId = (int)$this->uri->segment(2);
            $checkGrt = $this->grouptrade_model->get('grt_id', 'grt_admin = '. $user .' AND grt_Id = '. $grtId);
            if(count($checkGrt) == 1 && $checkGrt->grt_id > 0){
                $return = true;
            }
        }
        return $return;
    }
    
    public function SearchTree($id)
    {
        GLOBAL $tree;
        $tree[] = $id;
        $list = $this->user_model->fetch('use_id', 'parent_id IN(' . $id . ')');
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $this->SearchTree($value->use_id);
            }
        } else {
            return;
        }
        return $tree;
    }

    function updatecontact()
    {
        if (!$this->session->userdata('sessionUser')) {
            redirect(base_url() . 'login', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }
                
        $sessionCaptchaGrtContact = $this->session->userdata('sessionCaptchaGrtContact');
        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $grt_Id = (int)$this->uri->segment(2);
        $get_grt = $this->grouptrade_model->get('*', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . $grt_Id);

        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaGrtContact'));
        $this->load->library('form_validation');
        #END Unlink captcha 
        $this->form_validation->set_rules('grt_name', 'lang:Tên nhóm', 'trim|required');
        $this->form_validation->set_rules('grt_link', 'lang:title_label_add', 'trim|required');
        $this->form_validation->set_rules('grt_email', 'lang:email_regis_label_defaults', 'trim|required|valid_email');
        $this->form_validation->set_rules('grt_phone', 'lang:phone_regis_label_defaults', 'trim|required|callback_is_phone');
        $this->form_validation->set_rules('grt_captcha', 'lang:captcha_regis_label_defaults', 'trim|required');

        #BEGIN: Set message
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_message('alpha_dash', $this->lang->line('alpha_dash_message'));
        $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
        $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
        $this->form_validation->set_message('matches', $this->lang->line('matches_message'));
        $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));       
        $this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));      
        $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
        $this->form_validation->set_error_delimiters('<div class="text-danger"><em>', '</em></div>');
        if ($this->form_validation->run() != FALSE && $this->input->post('grt_captcha') == $this->session->userdata('sessionCaptchaGrtContact')) {
           #BEGIN: Upload image
            $this->load->library('upload');
            $this->load->library('image_lib');
            $pathUpload = "media/group/";
            $dirUpload = $this->session->userdata('sessionUser');
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
            /**/
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            
            
            
            $pathLogo = '/public_html/media/group/logos/';
            if (count($get_grt) > 0 && $get_grt->grt_dir_logo != '') {
                $dirLogo = $get_grt->grt_dir_logo;
            } else {
                $dirLogo  = date('dmY');
            }
            $listDirLogo = array();
            $listDirLogo = $this->ftp->list_files($pathLogo);
            if (!in_array($dirLogo, $listDirLogo)) {
                $this->ftp->mkdir($pathLogo . $dirLogo, 0775);
            }
                         
            if ($this->upload->do_upload('grt_logo')) {
                $uploadLogo = $this->upload->data();
                if ($uploadLogo['is_image'] == TRUE) {
                    $logo_group = $uploadLogo['file_name'];
                    /*#BEGIN: Crop logo 1:1
                    $w = $uploadLogo['image_width']; 
                    $h = $uploadLogo['image_height'];
                    if($w != $h){
                        if($w > $h){
                            $width = $h;
                            $height = $h;
                            $x_axis = ($w - $h) / 2;
                            $y_axis = 0;
                        }
                        if($w < $h){
                            $width = $w;
                            $height = $w;
                            $x_axis = 0;
                            $y_axis = ($h - $w) / 2;
                        }
                        $configCrop = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $logo_group,
                            'new_image' => $pathUpload . $dirUpload . '/' . $logo_group,
                            'maintain_ratio' => FALSE,
                            'width' => $width, 'height' => $height,
                            'x_axis' => $x_axis, 'y_axis' => $y_axis
                        );
                        $this->image_lib->initialize($configCrop);
                        $this->image_lib->crop();
                        $this->image_lib->clear();
                    }*/
                    #BEGIN: Resize logo                        
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $logo_group,
                        'new_image' => $pathUpload . $dirUpload . '/' . $logo_group,
                        'maintain_ratio' => true,
                        'width' => '1',
                        'height' => '120',
			            'master_dim' => 'height'
                    );
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                    #END Resize logo
                    $source_path = $pathUpload . $dirUpload . '/' . $logo_group;
                    $target_path = $pathLogo . $dirLogo . '/' . $logo_group; 
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                } 
            } else {
                $logo_group = $get_grt->grt_logo;
            }                        
            #END Upload logo
            $pathBanner = '/public_html/media/group/banners/';
            if (count($get_grt) > 0 && $get_grt->grt_dir_banner != '') {
                $dirBanner = $get_grt->grt_dir_banner;
            } else {
                $dirBanner  = date('dmY');
            }            
            $listDirBanner = array();
            $listDirBanner = $this->ftp->list_files($pathBanner);
            if (!in_array($dirBanner, $listDirBanner)) {
                $this->ftp->mkdir($pathBanner . $dirBanner, 0775);
            }
            #BEGIN: Upload banner            
            if ($this->upload->do_upload('grt_banner')) {
                $uploadBanner = $this->upload->data();
                if ($uploadBanner['is_image'] == TRUE) {                        
                    $banner_group = $uploadBanner['file_name'];
                    #BEGIN: Resize logo                        
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $banner_group,
                        'new_image' => $pathUpload . $dirUpload . '/' . $banner_group,
                        'maintain_ratio' => true,
                        'width' => '1600',
                        'height' => '1',
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                    $this->image_lib->clear();
                    #END Resize logo
                    $source_path = $pathUpload . $dirUpload . '/' . $banner_group;
                    $target_path = $pathBanner . $dirBanner . '/' . $banner_group; 
                    $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                } 
            } else {
                $banner_group = $get_grt->grt_banner;
            }                      
            #END Upload banner
            
            if (file_exists($pathUpload . $dirUpload . '/index.html')) {
                @unlink($pathUpload . $dirUpload . '/index.html');
            }
            array_map('unlink', glob($pathUpload . $dirUpload . '/*'));
            @rmdir($pathUpload . $dirUpload);
            
            $this->ftp->close();            
            
            $dataEdit = array(
                'grt_name' => trim($this->filter->injection_html($this->input->post('grt_name'))),
                'grt_link' => trim(strtolower($this->filter->injection_html($this->input->post('grt_link')))),
                'grt_logo' => $logo_group,
                'grt_dir_logo' => $dirLogo,
                'grt_banner' => $banner_group,
                'grt_dir_banner' => $dirBanner,
                'grt_desc' => $this->filter->injection_html($this->input->post('grt_desc')),
                'grt_email' => trim(strtolower($this->filter->injection_html($this->input->post('grt_email')))),
                'grt_mobile' => trim($this->input->post('grt_mobile')),
                'grt_phone' => trim($this->input->post('grt_phone')),
                'grt_facebook' => $this->input->post('grt_facebook'),
                'grt_message' => $this->input->post('grt_message'),
                'grt_video' => $this->input->post('grt_video'),
                'grt_province' => (int)$this->input->post('grt_province'),
                'grt_district' => $this->input->post('grt_district'),
                'grt_address' => $this->input->post('grt_address'),
                'grt_introduction' => $this->input->post('grt_introduction')
            );

            $this->grouptrade_model->update($dataEdit, 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . $grt_Id);
            $this->session->unset_userdata('sessionCaptchaGrtContact');
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
        } else {
            if($this->input->post("grt_captcha") && $sessionCaptchaGrtContact != $this->input->post("grt_captcha")){
                $err_cap = 'Mã xác nhận không đúng';
            }
            $data['grt_type'] = $get_grt->grt_type;
            $data['grt_id'] = $get_grt->grt_id;
            $data['grt_name'] = $get_grt->grt_name;
            $data['grt_link'] = $get_grt->grt_link;
            $data['grt_logo'] = $get_grt->grt_logo;
            $data['grt_dir_logo'] = $get_grt->grt_dir_logo;
            $data['grt_banner'] = $get_grt->grt_banner;
            $data['grt_dir_banner'] = $get_grt->grt_dir_banner;
            $data['grt_desc'] = $get_grt->grt_desc;
            $data['grt_email'] = $get_grt->grt_email;
            $data['grt_mobile'] = $get_grt->grt_mobile;
            $data['grt_phone'] = $get_grt->grt_phone;
            $data['grt_facebook'] = $get_grt->grt_facebook;
            $data['grt_message'] = $get_grt->grt_message;
            $data['grt_video'] = $get_grt->grt_video;
            $data['grt_province'] = $get_grt->grt_province;
            $data['grt_district'] = $get_grt->grt_district;
            $data['grt_address'] = $get_grt->grt_address;
            $data['grt_introduction'] = $get_grt->grt_introduction; 
        }
        #province && district
        $data['province'] = $this->province_model->fetch('pre_id, pre_name', 'pre_status = 1', 'pre_order', 'ASC');
        if ($this->input->post('district_regis')) {
            $filterDistrict = array(
                'select' => 'DistrictCode, DistrictName',
                'where' => array('ProvinceCode' => (int)$get_grt->grt_province)
            );
            $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
        }
        $data['district'] = $this->district_model->fetch("DistrictCode, DistrictName", "pre_status = 1 and ProvinceCode = " . (int)$get_grt->grt_province, "vtp_province_code", "ASC");

        #BEGIN: Create captcha group bank
        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $this->session->set_userdata('sessionCaptchaGrtContact', $codeCaptcha);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        $this->session->set_flashdata('sessionPathCaptchaGrtContact', $imageCaptcha);
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaGrtContact'] = $imageCaptcha;
        }
        $this->session->set_userdata('sessionCaptchaGrtContact', $codeCaptcha);
        #END Create captcha group bank
        #load view        
        $this->load->view('group/account/up_contact', $data);
    }    
    
    //xoa logo, banner cho lien he group
    function ajax_del_img()
    {
        $this->load->library('ftp');
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = TRUE;
        $this->ftp->connect($config);        
        if ($this->session->userdata('sessionUser')) {
            $no = (int)$this->input->post('num');
            $grt_id = (int)$this->input->post('grt_id');
            $grt_img = $this->grouptrade_model->get('grt_logo, grt_banner, grt_dir_logo, grt_dir_banner', 'grt_id = ' . $grt_id);
            if ($grt_img && $no == 1) {
                $aburl = DOMAIN_CLOUDSERVER.'media/group/logos/' . $grt_img->grt_dir_logo . '/' . $grt_img->grt_logo;
                $filepath = '/public_html/media/group/logos/' . $grt_img->grt_dir_logo . '/' . $grt_img->grt_logo;
                if (is_array(getimagesize($aburl))) {              
                    $this->ftp->delete_file($filepath);  
                    $this->grouptrade_model->update(array('grt_logo' => ''), 'grt_id = ' . $grt_id);
                }                
            }
            if ($grt_img && $no == 2) {
                $aburl = DOMAIN_CLOUDSERVER . 'media/group/banners/' . $grt_img->grt_dir_banner . '/' . $grt_img->grt_banner;
                $filepath = '/public_html/media/group/banners/' . $grt_img->grt_dir_banner . '/' . $grt_img->grt_banner;
                if (is_array(getimagesize($aburl))) {              
                    $this->ftp->delete_file($filepath);  
                    $this->grouptrade_model->update(array('grt_banner' => ''), 'grt_id = ' . $grt_id);
                }                
            }
            $this->db->cache_delete_all();
            if (!file_exists('system/cache/index.html')) {
                $this->load->helper('file');
                @write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
            }
            $this->ftp->close();
            echo '1';
            exit();
        }
        echo '-1';
        exit();
    }

    function updateadmin()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . 'login', 'location');
        }
        if ($group_id == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $get_grt = $this->grouptrade_model->get('grt_id, (SELECT use_username FROM tbtt_user WHERE tbtt_user.use_id = tbtt_group_trade.grt_ad_moderator) AS Mode, (SELECT use_username FROM tbtt_user WHERE tbtt_user.use_id = tbtt_group_trade.grt_ad_approver) AS Approve, (SELECT use_username FROM tbtt_user WHERE tbtt_user.use_id = tbtt_group_trade.grt_admin) AS Admin', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        #END Unlink captcha
        #BEGIN: Valida       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grt_ad_moderator', 'lang:title_label_add', 'trim');
        $this->form_validation->set_rules('grt_ad_approver', 'lang:title_label_add', 'trim');
        $this->form_validation->set_rules('grt_captcha', 'lang:captcha_regis_label_defaults', 'callback__valid_captcha');
        #BEGIN: Set message
        $this->form_validation->set_message('required', $this->lang->line('required_message'));
        $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        
        $CaptchaGroupAdmin = $this->session->userdata('CaptchaGroupAdmin');
        $err_cap = '';
        $grt_ad_moderator_ip = $this->input->post('grt_ad_moderator');
        $grt_ad_approver_ip = $this->input->post('grt_ad_approver');
        if ($this->form_validation->run() != FALSE && $CaptchaGroupAdmin == $this->input->post("grt_captcha") && ($grt_ad_moderator_ip != '' || $grt_ad_approver_ip != '')) {
            $grt_moderator = $grt_approver = 0;
            if ($grt_ad_moderator_ip != '') {
                $grt_ad_moderator = $this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('grt_ad_moderator')))) . "' AND use_status = 1");
                $grt_moderator = $grt_ad_moderator ? $grt_ad_moderator->use_id : 0;
            }
            if ($grt_ad_approver_ip != '') {
                $grt_ad_approver = $this->user_model->get("use_id", "use_username = '" . trim(strtolower($this->filter->injection_html($this->input->post('grt_ad_approver')))) . "' AND use_status = 1");
                $grt_approver = $grt_ad_approver ? $grt_ad_approver->use_id : 0;
            }

            $dataEdit = array(
                "grt_ad_moderator" => $grt_moderator,
                "grt_ad_approver" => $grt_approver
            );

            $this->grouptrade_model->update($dataEdit, "grt_admin = " . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
            $this->session->unset_userdata('CaptchaGroupAdmin');
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
        } else {
            if($this->input->post("grt_captcha") && $CaptchaGroupAdmin != $this->input->post("grt_captcha")){
                $err_cap = 'Mã xác nhận không đúng';
            }
            $data['grt_ad_moderator'] = $get_grt->Mode;
            $data['grt_ad_approver'] = $get_grt->Approve;
            $data['grt_ad_admin'] = $get_grt->Admin;
        }
        #BEGIN: Create captcha
        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaGrtAdmin'] = $imageCaptcha;
        }
        $this->session->set_userdata('CaptchaGroupAdmin', $codeCaptcha);
        $data['error_captcha'] = $err_cap;
        #END Create captcha
        #load view
        $this->load->view('group/account/up_admin', $data);
    }

    function updatestore()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $get_grt = $this->grouptrade_model->get('grt_id, grt_province_store, grt_district_store, grt_address_store', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->userdata('sessionPathCaptchaGrtStore'));
        $this->load->library('form_validation');
        #END Unlink captcha 

        $this->form_validation->set_rules('captcha_groupStore', 'lang:captcha', '');
        $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        $err_cap='';
        $sessionCaptchaGrtStore = $this->session->userdata('sessionCaptchaGrtStore');
        if ($this->form_validation->run() != FALSE && $sessionCaptchaGrtStore == $this->input->post("grt_captcha")) {
            $dataEdit = array(
                "grt_province_store" => (int)$this->input->post("grt_province_store"),
                "grt_district_store" => $this->input->post("grt_district_store"),
                "grt_address_store" => $this->input->post("grt_address_store")
            );
            $this->grouptrade_model->update($dataEdit, 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
            $this->session->unset_userdata('sessionCaptchaGrtStore');
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
        } else {
            if($this->input->post("grt_captcha") && $sessionCaptchaGrtStore != $this->input->post("grt_captcha")){
                $err_cap = 'Mã xác nhận không đúng';
            }
            $data['grt_province_store'] = $get_grt->grt_province_store;
            $data['grt_district_store'] = $get_grt->grt_district_store;
            $data['grt_address_store'] = $get_grt->grt_address_store;
        }
        
        ##province && district        
        $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
        if ($this->input->post('district_regis')) {
            $filterDistrict = array(
                'select' => 'DistrictCode, DistrictName',
                'where' => array('ProvinceCode' => (int)$get_grt->grt_province_store)
            );
            $data['district_list'] = $this->district_model->getDistrict($filterDistrict);
        }
        $data['district'] = $this->district_model->fetch("DistrictCode , DistrictName", "pre_status = 1 AND ProvinceCode = " . (int)$get_grt->grt_province_store, "vtp_province_code", "ASC");

        #BEGIN: Create captcha
        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $this->session->set_userdata('sessionCaptchaGrtStore', $codeCaptcha);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        $this->session->set_userdata('sessionPathCaptchaGrtStore', $imageCaptcha);
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        $data['codeCaptcha'] = $codeCaptcha;
        $data['note'] = $err_cap;
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaGrtStore'] = $imageCaptcha;
        }
        $data['error_captcha'] = $err_cap;
        #END Create captcha
        #load view
        $this->load->view('group/account/up_store', $data);
    }

    function updatebank()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }
        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        #END Unlink captcha
        $get_grt = $this->grouptrade_model->get('grt_id, grt_bank, grt_bank_num, grt_bank_addr', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
        $this->load->library('form_validation');
        
        $sessionPathCaptchaGrtBank = $this->session->userdata('sessionPathCaptchaGrtBank');
        // $this->form_validation->set_rules('captcha_groupBank', 'lang:captcha', '');
        $this->form_validation->set_rules('captcha_groupBank', 'captcha', 'callback_check_captcha');
        // $this->form_validation->set_message('callback__valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
        // $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        
        $err_cap = '';
        if ($this->form_validation->run() != FALSE && $sessionPathCaptchaGrtBank == $this->input->post("grt_captcha")) {
            $dataEdit = array(
                "grt_bank" => $this->input->post("grt_bank"),
                "grt_bank_num" => trim($this->input->post("grt_bank_num")),
                "grt_bank_addr" => $this->input->post("grt_bank_addr")
            );
            $this->grouptrade_model->update($dataEdit, "grt_admin = " . $this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
            $this->session->unset_userdata('sessionPathCaptchaGrtBank');
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
        } else {
            if($this->input->post("grt_captcha") && $sessionPathCaptchaGrtBank != $this->input->post("grt_captcha")){
                $err_cap = 'Mã xác nhận không đúng';
            }
            $data['grt_bank'] = $get_grt->grt_bank;
            $data['grt_bank_num'] = $get_grt->grt_bank_num;
            $data['grt_bank_addr'] = $get_grt->grt_bank_addr;
        }
        #BEGIN: Create captcha
        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaGrtBank'] = $imageCaptcha;
        }
        $this->session->set_userdata('sessionPathCaptchaGrtBank', $codeCaptcha);
        $data['error_captcha'] = $err_cap;
        ##END Create captcha
        ##load view
        $this->load->view('group/account/up_bank', $data);
    }

    function updatedomain()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }
        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $get_grt = $this->grouptrade_model->get('grt_id, grt_link, grt_domain', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
        $fileName = "domain.txt";
        if ($this->input->post('txtdomain')) {
            $domain = trim($this->filter->injection_html($this->input->post('txtdomain')));
            $get_ip_domain = gethostbynamel($domain);
            foreach ($get_ip_domain as $v) {
                $ip = $v;
                break;
            }

            if ($ip != $_SERVER['SERVER_ADDR']) {
                $this->session->set_flashdata('ErrorMessage', 'Tên miền của bạn chưa trỏ về Server IP ' . $_SERVER['SERVER_ADDR']);
                redirect(base_url() . "grouptrade/" . $this->uri->segment(2) . "/updatedomain", "location");
            }

            $start = 0;
            if (strpos($domain, ':') > 0) {
                $start = strpos($domain, '/') + 2;
            }
            $domain = substr($domain, $start, strlen($domain));
            $strdomain = '';
            foreach (file($fileName) as $key => $values) {
                $arr = explode(' ', $values);
                foreach ($arr as $key => $value) {
                    // tim domain trong domain.txt, thay thế domain
                    if (strpos($value, $domain) !== false) {
                        $strdomain = $arr[$key] . " " . $arr[$key + 1];
                        $thaythe = $domain . " " . $get_grt->grt_link;
                        if ($key + 1 < count($arr)) {
                            $thaythe .= "\r\n";
                        }
                    }
                    // tim sho_link trong domain.txt, thay the sho_link
                    if (strpos($value, $get_grt->grt_link) !== false) {
                        $strdomain = $arr[$key - 1] . " " . $get_grt->grt_link;
                        $thaythe = $domain . " " . $get_grt->grt_link;
                    }
                }
            }

            $dem = explode(' ', $strdomain);
            if (count($dem) > 1) {
                $contents = file_get_contents($fileName);
                $contents = str_replace($strdomain, $thaythe, $contents);
                file_put_contents($fileName, $contents);
            } else {
                $fp = fopen($fileName, 'a+') or die("Can't open file");
                $str = "\r\n" . $domain . " " . $get_grt->grt_link;
                fwrite($fp, $str);
                fclose($fp);
            }
            $this->grouptrade_model->update(array('grt_domain' => $domain), 'grt_id = ' . (int)$get_grt->grt_id);
            $this->session->set_flashdata('ErrorMessage', 'Cập nhật domain thành công!');
            redirect(base_url() . "grouptrade/" . $this->uri->segment(2) . "/updatedomain", "location");
        }
        $data['grTrade'] = $get_grt;
        #load view
        $this->load->view('group/account/up_domain', $data);
    }

    function updateslideshow()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }
        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $get_grt = $this->grouptrade_model->get('grt_id, grt_dir_banner, grt_banner_slide', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
	
	$slideEdit = json_decode($get_grt->grt_banner_slide);
	
	if($this->input->post('updateslideshow')==1) {
	    	    
	    #BEGIN: Upload images
            $this->load->library('upload');
            $this->load->library('image_lib');
            $pathUpload = "media/group/";
            $dirUpload = $this->session->userdata('sessionUser');            
	    if (!is_dir($pathUpload . $dirUpload)) {
                @mkdir($pathUpload . $dirUpload, 0777, true);
                $this->load->helper('file');
                @write_file($pathUpload . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
            }
            $configUpload['upload_path'] = $pathUpload . $dirUpload . '/';
            $configUpload['allowed_types'] = 'gif|jpg|png';
            $configUpload['encrypt_name'] = true;
            
            $this->upload->initialize($configUpload);
            /**/
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            
            $pathBanner = '/public_html/media/group/banners/';
            if (count($get_grt) > 0 && $get_grt->grt_dir_banner != '') {
                $dirBanner = $get_grt->grt_dir_banner;
            } else {
                $dirBanner  = date('dmY');
            }
            $listDirBanner = array();
            $listDirBanner = $this->ftp->list_files($pathBanner);
            if (!in_array($dirBanner, $listDirBanner)) {
                $this->ftp->mkdir($pathBanner . $dirBanner, 0775);
            }	
	    
	    for($i=0;$i<5;$i++){
		if($this->upload->do_upload('image_'.$i)) {		
		    $uploadImage = $this->upload->data();
		    if($uploadImage['is_image'] == TRUE) {
			$image = $uploadImage['file_name'];
			#BEGIN: Crop image 3x1
			$w = $uploadImage['image_width']; 
			$h = $uploadImage['image_height'];
			$width  = $w;
			$height = $w/3;
			$y_axis = ($h-$height)/2;
			$x_axis = 0;
			$configCrop = array(
			    'source_image' => $pathUpload . $dirUpload . '/' . $image,
			    'new_image' => $pathUpload . $dirUpload . '/' . $image,
			    'maintain_ratio' => FALSE,
			    'width' => $width, 'height' => $height,
			    'x_axis' => $x_axis, 'y_axis' => $y_axis
			);
			$this->image_lib->initialize($configCrop);
			$this->image_lib->crop();
			$this->image_lib->clear();
			#BEGIN: Resize image  1200x400                      
			$configResize = array(
			    'source_image' => $pathUpload . $dirUpload . '/' . $image,
			    'new_image' => $pathUpload . $dirUpload . '/' . $image,
			    'maintain_ratio' => TRUE,
			    'width' => '1200',
			    'height' => '400'
			);
			$this->image_lib->initialize($configResize);
			$this->image_lib->resize();
			$this->image_lib->clear();
			#END Resize image
			$source_path = $pathUpload . $dirUpload . '/' . $image;
			$target_path = $pathBanner . $dirBanner . '/' . $image; 
			$this->ftp->upload($source_path, $target_path, 'auto', 0775);
		    } 
		    $slide[$i]->image = $image;
		    if($slideEdit[$i]->image!=""){
			$this->ftp->delete_file('/public_html/media/group/banners/' . $get_grt->grt_dir_banner . '/' . $slideEdit[$i]->image);
		    }
		} else {
		    $slide[$i]->image = $this->input->post('image_'.$i.'_old');		
		} 
		$slide[$i]->url	= $this->input->post('url_'.$i);		
	    }
	    
	    $dataUpdate = array(
		'grt_banner_slide' => json_encode($slide)
	    );
	    
            #END Upload images
	    
            $this->grouptrade_model->update($dataUpdate, 'grt_id = ' . (int)$get_grt->grt_id);
            $this->session->set_flashdata('ErrorMessage', 'Cập nhật BANNER SLIDE thành công!');
	    if (file_exists($pathUpload . $dirUpload . '/index.html')) {
		@unlink($pathUpload . $dirUpload . '/index.html');
	    }
	    array_map('unlink', glob($pathUpload . $dirUpload . '/*'));
	    @rmdir($pathUpload . $dirUpload);            
	    $this->ftp->close();
        }
	$get_grt_view = $this->grouptrade_model->get('grt_id, grt_dir_banner, grt_banner_slide', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
	$data['grTrade'] = $get_grt_view;
        #load view
        $this->load->view('group/account/up_slideshow', $data);
    }
    
    function updatebannerfloor()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }
        $data = array();
        $data['menuSelected'] = 'updateinfo';
        $data['showbanner'] = 1;
        $get_grt = $this->grouptrade_model->get('grt_id, grt_dir_banner, grt_banner_floor', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
	
	$bannerEdit = json_decode($get_grt->grt_banner_floor);
	if($this->input->post('updatebannerfloor')==1) {
	    	    
	    #BEGIN: Upload images
            $this->load->library('upload');
            $this->load->library('image_lib');
            $pathUpload = "media/group/";
            $dirUpload = $this->session->userdata('sessionUser');            
	    if (!is_dir($pathUpload . $dirUpload)) {
                @mkdir($pathUpload . $dirUpload, 0777, true);
                $this->load->helper('file');
                @write_file($pathUpload . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
            }
            $configUpload['upload_path'] = $pathUpload . $dirUpload . '/';
            $configUpload['allowed_types'] = 'gif|jpg|png';
            $configUpload['encrypt_name'] = true;
            
            $this->upload->initialize($configUpload);
            /**/
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            
            $pathBanner = '/public_html/media/group/banners/';
            if (count($get_grt) > 0 && $get_grt->grt_dir_banner != '') {
                $dirBanner = $get_grt->grt_dir_banner;
            } else {
                $dirBanner  = date('dmY');
            }
            $listDirBanner = array();
            $listDirBanner = $this->ftp->list_files($pathBanner);
            if (!in_array($dirBanner, $listDirBanner)) {
                $this->ftp->mkdir($pathBanner . $dirBanner, 0775);
            }	
	    
	    for($i=0;$i<15;$i++){
		if($this->upload->do_upload('image_'.$i)) {		
		    $uploadImage = $this->upload->data();
		    if($uploadImage['is_image'] == TRUE) {
			$image = $uploadImage['file_name'];
			#BEGIN: Crop image 1x2
			$w = $uploadImage['image_width']; 
			$h = $uploadImage['image_height'];
			$width  = $h/2;
			$height = $h;
			$y_axis = 0;
			$x_axis = ($w-$width)/2;
			$configCrop = array(
			    'source_image' => $pathUpload . $dirUpload . '/' . $image,
			    'new_image' => $pathUpload . $dirUpload . '/' . $image,
			    'maintain_ratio' => FALSE,
			    'width' => $width, 'height' => $height,
			    'x_axis' => $x_axis, 'y_axis' => $y_axis
			);
			$this->image_lib->initialize($configCrop);
			$this->image_lib->crop();
			$this->image_lib->clear();
			#BEGIN: Resize image  1200x400                      
			$configResize = array(
			    'source_image' => $pathUpload . $dirUpload . '/' . $image,
			    'new_image' => $pathUpload . $dirUpload . '/' . $image,
			    'maintain_ratio' => TRUE,
			    'width' => '300',
			    'height' => '600'
			);
			$this->image_lib->initialize($configResize);
			$this->image_lib->resize();
			$this->image_lib->clear();
			#END Resize image
			$source_path = $pathUpload . $dirUpload . '/' . $image;
			$target_path = $pathBanner . $dirBanner . '/' . $image; 
			$this->ftp->upload($source_path, $target_path, 'auto', 0775);
		    } 
		    $slide[$i]->image = $image;
		    if($bannerEdit[$i]->image!=""){
			$this->ftp->delete_file('/public_html/media/group/banners/' . $get_grt->grt_dir_banner . '/' . $bannerEdit[$i]->image);
		    }
		} else {
		    $slide[$i]->image = $this->input->post('image_'.$i.'_old');		
		} 
		$slide[$i]->url	= $this->input->post('url_'.$i);
		$slide[$i]->title	= $this->input->post('title_'.$i);
	    }
	    
	    $dataUpdate = array(
		'grt_banner_floor' => json_encode($slide)
	    );
	    
            #END Upload images
	    
            $this->grouptrade_model->update($dataUpdate, 'grt_id = ' . (int)$get_grt->grt_id);
            $this->session->set_flashdata('ErrorMessage', 'Cập nhật BANNER SLIDE thành công!');
	    if (file_exists($pathUpload . $dirUpload . '/index.html')) {
		@unlink($pathUpload . $dirUpload . '/index.html');
	    }
	    array_map('unlink', glob($pathUpload . $dirUpload . '/*'));
	    @rmdir($pathUpload . $dirUpload);            
	    $this->ftp->close();
        }
	$get_grt_view = $this->grouptrade_model->get('grt_id, grt_dir_banner, grt_banner_floor', 'grt_admin = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(2));
	$data['grTrade'] = $get_grt_view;
        #load view
        $this->load->view('group/account/up_bannerfloor', $data);
    }  

    function getTreeInList($userid, &$allChild)
    {
        $listChild = array();
        $this->getListChildTree($userid, $listChild);
        foreach ($listChild as $child) {
            if ($child > 0) {
                $allChild[] = $child;
                $this->getTreeInList($child, $allChild);
            }
        }
    }

    function getListChildTree($userid, &$list_child = array())
    {
        $child = $this->getChild($userid);
        if ($child > 0) {
            $list_child[] = $child;
            $this->getNextList($child, $list_child);
        } else {
            return 0;
        }
    }

    function getChild($userid)
    {
        $this->load->model('user_tree_model');
        if ($userid > 0) {
            $userObject = $this->user_tree_model->get("*", "user_id = " . $userid);
            return $userObject->child;
        } else {
            return 0;
        }
    }

    function getNextList($child, &$list_next = array())
    {
        $this->load->model('user_tree_model');
        $userObject = $this->user_tree_model->get("*", "user_id = " . $child);
        if ($userObject->next > 0) {
            $list_next[] = $userObject->next;
        }
        if ($userObject->next > 0) {
            $this->getNextList($userObject->next, $list_next);
        } else {
            return $list_next;
        }
    }

    function orderdetail()
    {

        $this->load->model('product_promotion_model');
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }

        $order_id = $this->uri->segment(4);
        if ($order_id == "") {
            redirect(base_url() . 'account');
        }

        $userdata = $this->session->userdata;
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        if ($this->session->userdata('sessionGroup') <= 3) {
            $where['shc_saler'] = $userdata['sessionUser'];
        }

        $data = array();
        $data['menuSelected'] = 'orders';
        $data['showbanner'] = 1;
        $tree = array();
        $this->getTreeInList($this->session->userdata('sessionUser'), $tree);
        $tree[] = $this->session->userdata('sessionUser');
        $tree = implode(',', $tree);

        if ($this->input->post('order_status')) {
            $data = array(
                'shc_status' => $this->input->post('order_status')
            );
            $where = array(
                'shc_saler' => $userdata['sessionUser'],
                'shc_orderid' => $this->uri->segment(4)
            );
            $this->showcart_model->update($data, $where);
            redirect(base_url() . "account/order_detail/" . $this->uri->segment(4), 'location');
        }
        #END Menu
        
        $where['where'] = 'shc_group_id = ' . (int)$this->uri->segment(2);
        $where['id'] = (int)$order_id;
        $order = $this->order_model->getDetailOrders($where);
        $data['list_product'] = $order;

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
                $get_p = $this->user_model->fetch_join('use_id, parent_id, use_group, sho_link, domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');

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
        $data['flash_message'] = $this->session->flashdata('flash_message');
        
        $tinhThanh = $this->district_model->get('DistrictName, ProvinceName', array('vtp_code' => $order[0]->ord_district));
        $data['_province'] = $tinhThanh->ProvinceName;
        $data['_district'] = $tinhThanh->DistrictName;
        $data['order_id'] = $order_id;
        #load view
        $this->load->view('group/actions/order_detail', $data);
    }

    function statisticsgeneral()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }
        $grt_id = (int)$this->uri->segment(2);
        $data = array();
        $this->load->model('order_model');
        $this->load->model('statistics_model');
        $list_join = $this->group_trade_action_model->fetch('id,list_join', 'grt_id = ' . $grt_id);
        $arr_join = array();
        foreach ($list_join as $key => $item) {
            $arr_join[] = $item->list_join;
        }
        $userId = implode(',', $arr_join);
        $branch = $this->get_branch_grt($userId, $grt_id);
        $arr_join_br = explode(',', $branch);
        foreach ($branch as $key => $item) {
            $arr_join_br[] = $item->list_join;
        }
        $userId_br = implode(',', $arr_join_br);
        if ($userId_br != '') {
            $userId .= ',' . $userId_br;
        }
        //get list aff

        $or_saler = '';
        $where_order = 'shc_group_id = '.$grt_id;
        $groupBy = 'id';
        $currentDate_first = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $currentDate_after = mktime(23, 59, 59, date('m'), date('d'), date('Y'));;

        $data['menuType'] = 'account';
        $data['menuSelected'] = 'statisticStore';
        // tong so san pham het hang
        $this->load->model('product_model');
        $select = "pro_id, pro_name, pro_user";
        $whereTmp = "pro_status = 1 and pro_instock = 0 and pro_user IN( " . $userId." )";
        $products = $this->product_model->fetch($select, $whereTmp, "pro_id", "DESC", '', '');
        $data['products'] = count($products);
        // Tong so affiliate
        // #sTT - So thu tu

        
        $this->load->library('utilSlv');
        $this->util = new utilSlv();
        $this->load->model('statistics_model');
        //tổng doanh thu đơn hàng
        #BEGIN: CHECK PERMISSION
        $q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        #END CHECK PERMISSION
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

        $now = date("Y-m-d H:i:s");
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $last_month = date("Y-m", strtotime("-1 month"));
        $end_yesterday = date("Y-m-d", strtotime("-1 day")) . ' 23:59:00';
        $begin_yesterday = date("Y-m-d", strtotime("-1 day")) . ' 00:00:00';
        $end_last_month = $last_month . '-' . date("t", strtotime($last_month . '-01')) . ' 23:59:00';
        $begin_last_month = $last_month . '-01 00:00:00'; // tong don hang moi
        
        $new_order = $this->order_model->fetch_join4('*', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where_order . ' and tbtt_showcart.shc_status IN (01,02,03,98) and change_status_date >= ' . $currentDate_first . ' and change_status_date <=' . $currentDate_after, '', '', '', '', '', $groupBy);
        $data['totaldonhanghnay'] = count($new_order);

        // tong don hang
        
        $total_order = $this->order_model->fetch_join4('*', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where_order, '', '', '', '', '', $groupBy);
        $data['total_order'] = count($total_order);
        $groupOrder = 'id,tbtt_showcart.af_id,pro_id';
        //Doanh số hôm nay
        $total_re = $this->order_model->fetch_join4('shc_total', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where_order . ' and change_status_date >= ' . $currentDate_first . ' and change_status_date <=' . $currentDate_after, '', '', '', '', '', '');
        
        $dshnay = 0;
        foreach ($total_re as $vl) {
            $dshnay += $vl->shc_total;
        }
        $data['total_re'] = $dshnay;

        //Doanh số hôm qua
        $total_hqua = $this->order_model->fetch_join4('shc_total', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where_order . ' and change_status_date <= ' . strtotime($end_yesterday) . ' and change_status_date >=' . strtotime($begin_yesterday), '', '', '', '', '', '');
        
        $tongHQ = 0;
        foreach ($total_hqua as $vl) {
            $tongHQ += $vl->shc_total;
        }
        $data['sales_yesterday'] = $tongHQ;

        //doanh số tháng trước
        $static_last_month = $this->statistics_model->getOrders(strtotime($begin_last_month), strtotime($end_last_month), '', $where_order);// . ' GROUP BY id'
        $tongTTrc = 0;
        foreach ($static_last_month as $vals) {
            $tongTTrc += $vals->shc_total;
        }
        $data['last_month'] = $tongTTrc;

        //doanh số tháng này
        $end_current_month = date("Y-m-d H:i:s");
        $begin_current_month = date("Y-m") . '-01 00:00:00';
        $static_current_month = $this->statistics_model->getOrders(strtotime($begin_current_month), strtotime($end_current_month), '', $where_order);
        $tongTNay = 0;
        foreach ($static_current_month as $vals) {
            $tongTNay += $vals->shc_total;
        }
        $data['current_month'] = $tongTNay;
        // Tong doanh so
        $total_dt = $this->order_model->fetch_join4('shc_total', 'INNER', 'tbtt_showcart', 'tbtt_showcart.shc_orderid = tbtt_order.id', 'LEFT', 'tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'LEFT', 'tbtt_user', 'tbtt_user.use_id = tbtt_product.pro_user', $where_order, '', '', '', '', '', '');
        $tongDT = 0;
        foreach ($total_dt as $vl) {
            $tongDT += $vl->shc_total;
        }
        $data['total'] = $tongDT;

        //Thu nhập hiện tại
        $data['current_earnings'] = $this->statistics_model->getCurrentEarningsStatistics('public', date("m-Y"), $user_id_arr);

        if ($this->input->post('options_tad') == "2") {
            $services_day['tad'] = "frm_revenues";
        } else {
            $services_day['tad'] = "frm_orders";
        }

        $user_id = array((int)$this->session->userdata('sessionUser'));

        if ($services_day['tad'] == "frm_orders") {
            $dayx = $this->statistics_model->getQuantityOrder(strtotime($begin_date), strtotime($end_date), 'day', $where_order);
            $monthx = $this->statistics_model->getQuantityOrder(strtotime($daunam), strtotime($end_date), 'month', $where_order);
            $yearx = $this->statistics_model->getQuantityOrder(strtotime($daunam), strtotime($end_date), 'year', $where_order);
            $services_day['title'] = "Thống kê tổng số lượng đơn hàng theo";
            $services_day['arrayToDataTable'] = "Số lượng";
        } else {
            $dayx = $this->statistics_model->getOrders(strtotime($begin_date), strtotime($end_date), 'day', $where_order);
            $monthx = $this->statistics_model->getOrders(strtotime($daunam), strtotime($end_date), 'month', $where_order);
            $yearx = $this->statistics_model->getOrders(strtotime($daunam), strtotime($end_date), 'year', $where_order);
            $services_day['title'] = "Thống kê tổng doanh thu đơn hàng theo";
            $services_day['arrayToDataTable'] = "Đơn hàng";
        }

        foreach ($this->util->getDatesFromRange($_begin_date, $_end_date) as $vals) {

            $tongngay = 0;
            for ($i = 0; $i < count($dayx); $i++) {
                if ($dayx[$i]->updated_date == $vals) {
                    $tongngay += $dayx[$i]->shc_total;
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
                    $tongthang += $monthx[$i]->shc_total;
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
                    $tongnam += $yearx[$i]->shc_total; //order_total_no_shipping_fee;
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

        $data['menuSelected'] = 'statistics';
        #load view
        $this->load->view('group/actions/statis_general', $data);
    }

    function statisticsincome()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        $data = array();
        $this->load->model('order_model');

        $list_join = $this->group_trade_action_model->fetch('*', 'grt_id = ' . (int)$this->uri->segment(2));
        $_li_user = '0';
        if ($list_join) {
            foreach ($list_join as $key => $value) {
                $_li_user .= ',' . $value->list_join;
            }
        }

        $sc_shop_grt = $this->order_model->fetch_join('order_saler, order_group_id, SUM(order_total_no_shipping_fee) AS total, (SELECT sho_name FROM tbtt_shop WHERE sho_user = order_saler) AS shopname, ', '', '', '', 'order_saler IN (' . $_li_user . ') AND order_group_id = ' . (int)$this->uri->segment(2), 'id', 'DESC', -1, 0, false, 'order_saler');

        $data['sc_shop_grt'] = $sc_shop_grt;

        $data['menuSelected'] = 'statistics';
        #load view
        $this->load->view('group/actions/statis_income', $data);
    }

    function detail_statis_income()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        if ((int)$this->uri->segment(4) <= 0) {
            redirect(base_url() . trim(uri_string(), '/'), 'location');
            die();
        }

        $data = array();
        $this->load->model('showcart_model');

        $dt_sc_shop_grt = $this->order_model->fetch_join('*, (SELECT sho_name FROM tbtt_shop WHERE sho_user = order_saler) AS shopname, (SELECT use_username FROM tbtt_user WHERE use_id = order_user_sale) AS usersaler, (SELECT use_mobile FROM tbtt_user WHERE use_id = order_user_sale) AS mobilesaler, (SELECT use_email FROM tbtt_user WHERE use_id = order_user_sale) AS emailsaler, (SELECT parent_id FROM tbtt_user WHERE use_id = order_user_sale) AS parentid, (SELECT tbtt_user.`use_username` FROM tbtt_user WHERE tbtt_user.`use_id` = parentid) AS parentsaler ','','','', 'order_saler = '.  (int)$this->uri->segment(4) .' AND order_group_id = '. (int)$this->uri->segment(2), 'id', 'DESC', -1, 0, false, '');
        $shop = $this->shop_model->get('sho_name, sho_id, sho_link', 'sho_user = '. (int)$this->uri->segment(4));

        $data['shop'] = $shop;        
        $data['dt_sc_shop_grt'] = $dt_sc_shop_grt;
        $data['menuSelected'] = 'statistics';
        #load view
        $this->load->view('group/actions/detail_statis_income', $data);
    }

    function statisticsadmin()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }

        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        $data = array();
        $data['menuSelected'] = 'statistics';
        
        $this->load->model('order_model');
        $this->load->model('statistics_model');

        $list_join = $this->group_trade_action_model->fetch('list_join', 'grt_id = ' . (int)$this->uri->segment(2));
        $arr_join = array();
        if ($list_join) {
            foreach ($list_join as $key => $value) {
                $arr_join[] = $value->list_join;
            }
        }
        $begin_current_month = date("Y-m") . '-01 00:00:00';
        $end_current_month = date("Y-m-d H:i:s");
        $where = 'order_group_id = ' . (int)$this->uri->segment(2).' and date BETWEEN '.strtotime($begin_current_month).' AND '.strtotime($end_current_month);
        
        $str_join = implode(',', $arr_join);
        $shop_grt = $this->order_model->fetch_join('order_saler, order_group_id, SUM(order_total_no_shipping_fee) AS total, (SELECT sho_name FROM tbtt_shop WHERE sho_user = order_saler) AS shopname, ', 'INNER', 'tbtt_group_trade', 'grt_id = order_group_id', $where, 'tbtt_order.id', 'DESC', -1, 0, false, 'order_saler');
        $arr = array();
        if(!(empty($shop_grt))){
            foreach ($shop_grt as $keys => $items){
                $commis_admin = $this->group_trade_action_model->fetch('list_join,cmss_for_admin', 'list_join = ' . (int)$items->order_saler.' AND grt_id = '.(int)$this->uri->segment(2));
                if(!(empty($commis_admin))){
                    foreach ($commis_admin as $key => $item){
                        if ($item->cmss_for_admin > 0) {
                            $order_saler = $item->list_join;
                            $branch = $this->get_branch_grt($item->list_join, (int) $this->uri->segment(2));
                            if ($branch != '') {
                                $order_saler .= ',' . $branch;
                            }
                            $where_order = 'order_saler IN( ' . $order_saler . ') and tbtt_showcart.shc_status IN(98) and order_group_id = '.(int)$this->uri->segment(2);
                            $static_current_month = $this->statistics_model->getOrders(strtotime($begin_current_month), strtotime($end_current_month), '', $where_order);
                            $tongTNay = 0;
                            foreach ($static_current_month as $vals) {
                                $tongTNay += $vals->shc_total;
                            }
                            if ($tongTNay > 0) {
                                $arr[$items->order_saler][] = array(
                                    'shopname' => $items->shopname,
                                    'total' => $tongTNay,
                                    'cmss_for_admin' => $item->cmss_for_admin,
                                    'doanhthu_admin' => $tongTNay * ( $item->cmss_for_admin / 100)
                                );
                            }
                        }
                    }
                }
            }
        }
        $data['shop_grt'] = $shop_grt;
        $data['arr_grt'] = $arr;
        $this->load->view('group/actions/statis_admin', $data);
    }
    
    function statisticsshop()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        // Quyền admin group => ! TRUE
        if (! $this->CheckAdminGroupTrade($this->session->userdata('sessionUser'))) {
            redirect(base_url() . 'account', 'location');
            die();
        }
        
        if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) {
        } else {
            redirect(base_url() . 'grouptrade/' . $this->uri->segment(2) . '/default', 'location');
            die();
        }

        $data = array();
        $data['menuSelected'] = 'statistics';
        
        $this->load->model('order_model');
        $this->load->model('statistics_model');

        $list_join = $this->group_trade_action_model->fetch('list_join', 'grt_id = ' . (int)$this->uri->segment(2));
        $arr_join = array();
        if ($list_join) {
            foreach ($list_join as $key => $value) {
                $arr_join[] = $value->list_join;
            }
        }
        $begin_current_month = date("Y-m") . '-01 00:00:00';
        $end_current_month = date("Y-m-d H:i:s");
        $where = 'order_group_id = ' . (int)$this->uri->segment(2).' and date BETWEEN '.strtotime($begin_current_month).' AND '.strtotime($end_current_month);
        
        $str_join = implode(',', $arr_join);
        $shop_grt = $this->order_model->fetch_join('order_saler, order_group_id, SUM(order_total_no_shipping_fee) AS total, (SELECT sho_name FROM tbtt_shop WHERE sho_user = order_saler) AS shopname, (SELECT sho_link FROM tbtt_shop WHERE sho_user = order_saler) AS shoplink, ', 'INNER', 'tbtt_group_trade', 'grt_id = order_group_id', $where, 'tbtt_order.id', 'DESC', -1, 0, false, 'order_saler');
        $arr = array();
        if(!(empty($shop_grt))){
            foreach ($shop_grt as $keys => $items){
                $commis_shop = $this->group_trade_action_model->fetch('list_join,cmss_for_shop', 'list_join = ' . (int)$items->order_saler.' AND grt_id = '.(int)$this->uri->segment(2));
                if(!(empty($commis_shop))){
                    foreach ($commis_shop as $key => $item){
                        if ($item->cmss_for_shop > 0) {
                            $order_saler = $item->list_join;
                            
                            $branch = $this->get_branch_grt($item->list_join, (int) $this->uri->segment(2));
                            if ($branch != '') {
                                $order_saler .= ',' . $branch;
                            }
                            
                            $where_order = 'order_saler IN(' . $order_saler . ') and tbtt_showcart.shc_status IN(98) and order_group_id = '.(int)$this->uri->segment(2);
                            $static_current_month = $this->statistics_model->getOrders(strtotime($begin_current_month), strtotime($end_current_month), '', $where_order);
                            $tongTNay = 0;
                            foreach ($static_current_month as $vals) {
                                $tongTNay += $vals->shc_total;
                            }
                            if ($tongTNay > 0) {
                                $arr[$items->order_saler][] = array(
                                    'shopname' => $items->shopname,
                                    'shoplink' => $items->shoplink,
                                    'total' => $tongTNay,
                                    'cmss_for_shop' => $item->cmss_for_shop,
                                    'doanhthu_shop' => $tongTNay * ( $item->cmss_for_shop / 100)
                                );
                            }
                        }
                    }
                }
            }
        }
        $data['shop_grt'] = $shop_grt;
        $data['arr_grt'] = $arr;
        $this->load->view('group/actions/statis_shop', $data);
    }

    function load_size()
    {
        $id = (int)$_REQUEST['pro_id'];
        $color = $_REQUEST['color'];
        $gt = explode('_', $color);
        $color = implode(' ', $gt);
        $li_size = $this->detail_product_model->fetch("DISTINCT dp_size", "dp_pro_id = " . (int)$id . ' AND dp_color = "' . $color . '"', $id, $color, '', '');
        if ($li_size) {
            foreach ($li_size as $ks => $vs) {
                $size_arr[] = $vs->dp_size;
            }
        }
        $t2 = 0;
        if (!empty($size_arr)) {
            foreach ($size_arr as $k2 => $v2) {
                $t2++;
                if ($k2 == 0) {
                    $sel_size = $v2;
                }
                $gt = explode(' ', $v2);
                $st_size = implode('_', $gt);
                $size = "'" . $st_size . "'";
                $nsize = $st_size;
                echo '<li style="cursor: pointer;"><span id="kichthuoc_' . $t2 . '" onclick="ClickSize(' . $size . ',' . $t2 . ');">' . $v2 . '</span>';
                echo '<input type="hidden" id="st_size_' . $nsize . '" name="st_size_' . $nsize . '" value="' . $v2 . '" /></li>';
            }
        } else {
            $this->load_chatlieu();
        }
    }

    function load_chatlieu()
    {
        $id = (int)$_REQUEST['pro_id'];

        $color = $_REQUEST['color'];
        $gt = explode('_', $color);
        $color = implode(' ', $gt);

        $gtsize = explode('_', $_REQUEST['size']);
        $size = implode(' ', $gtsize);
        $where = '';
        if ($color != '') {
            $where .= ' AND  dp_color = "' . $color . '"';
        }
        if ($size != '') {
            $where .= ' AND  dp_size = "' . $size . '"';
        }
        $li_material = $this->detail_product_model->fetch("distinct(dp_material)", "dp_pro_id = " . (int)$id . $where, $id, $size, '', '');
        if ($li_material) {
            foreach ($li_material as $km => $vm) {
                $material_arr[] = $vm->dp_material;
            }
        }
        $t2 = 0;
        if (!empty($material_arr)) {
            foreach ($material_arr as $k2 => $v2) {
                $t2++;
                if ($k2 == 0) {
                    $sel_size = $v2;
                }
                $gt = explode(' ', $v2);
                $st_material = implode('', $gt);
                $cl = "'" . $st_material . "'";
                echo '<li style="cursor: pointer;"><span id="chatlieu_' . $t2 . '" onclick="ClickMaterial(' . $cl . ',' . $t2 . ');">' . $v2 . '</span>';
                echo '<input type="hidden" id="st_material_' . $st_material . '" name="st_material_' . $st_material . '" value="' . $v2 . '" /></li>';
            }
        }
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
            $imgsrc = 'media/images/product/' . $img_dir . '/' . $v2;
            if (file_exists($imgsrc) && $v2 != '') {
                $a = '<a class="c image" href="' . base_url() . $imgsrc . '">
            <img src="' . base_url() . $imgsrc . '" alt="..."> </a>';
            } else {
                $a = '<a class="c image" href="' . base_url() . 'images/noimage.jpg"><img src="' . base_url() . 'images/noimage.jpg" alt="..."></a>';
            }
            echo $d . $a . '</div>';
        }
        echo '</div>';
    }

    function product_style_azibai()
    {
        $result = $img = array();
        $result['error'] = FALSE;
        $id = $_REQUEST['id'];
        $color = $_REQUEST['color'];
        $gt = explode('_', $color);
        $color = implode(' ', $gt);
        $size = '';
        if ($_REQUEST['size']) {
            $size = $_REQUEST['size'];
        }
        $material = $_REQUEST['chatlieu'];
        if (isset($id) && $id > 0) {
            $product = $this->product_model->getProAndDetail0("*, (af_rate) AS aff_rate, (T2.`dp_cost`) AS pro_cost, (SELECT shop_type FROM tbtt_shop WHERE sho_user = pro_user) as shop_type" . DISCOUNT_DP_QUERY . " , T2.*", "pro_id = " . $id . " AND pro_status = 1", $id, $color, $size, $material);
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
            }
            $image = implode(',', $img);
            $prices = implode(',', $price);
            $qty_max = implode(',', $max);
            $str_id = implode(',', $pro_id);
            $result['pro_images'] = $image;
            $result['pro_prices'] = $prices;
            $result['pro_max'] = $qty_max;
            $result['pro_id'] = $str_id;
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
            $list_style = $this->detail_product_model->fetch('dp_size, dp_material', 'dp_pro_id = ' . $id . ' AND dp_color LIKE "%' . $color . '%"');
            if ($list_style) {
                foreach ($list_style as $kl => $vl) {
                    if ($vl->dp_size != '') {
                        $ar_size[] = $vl->dp_size;
                    }
                    if ($vl->dp_material != '') {
                        $ar_material[] = $vl->dp_material;
                    }
                }
            }
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
            $result['message'] = 'Susseccc!!';

        } else {
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
        exit();
    }

    public function add_view_af_share($productID)
    {
        //add info view af share
        if (isset($_REQUEST['share'])) {
            $user_key = $_REQUEST['share'];
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
                $this->load->model('af_share_model');
                $data_view['pro_id'] = $productID;
                $data_view['af_key'] = $_REQUEST['share'];
                $data_view['agent_view'] = $agent;
                $data_view['time_view'] = date('Y-m-d H:i:s');
                $kq = $this->af_share_model->add($data_view);
            }

        }
    }

    function get_shop_in_tree($uid)
    {
        $parent = 0;
        $user = $this->user_model->get("use_id, parent_id", "use_id = " . $uid); //lấy nó
        $u_pa_1 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$user->parent_id); // lấy cho nó
        if ($u_pa_1 && $u_pa_1->use_group == 3) {
            $parent = $u_pa_1->use_id;
        } elseif ($u_pa_1 && $u_pa_1->use_group == 14) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_1->parent_id);
            if ($u_pa_2 && $u_pa_2->use_group == 3) {
                $parent = $u_pa_2->use_id;
            } else {
                $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_2->parent_id);
                if ($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                }
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 15) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_1->parent_id);
            if ($u_pa_2 && $u_pa_2->use_group == 3) {
                $parent = $u_pa_2->use_id;
            }
        } elseif ($u_pa_1 && $u_pa_1->use_group == 11) {
            $u_pa_2 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_1->parent_id);
            if ($u_pa_2 && $u_pa_2->use_group == 3) {
                $parent = $u_pa_2->use_id;
            } elseif ($u_pa_2 && $u_pa_2->use_group == 14) {
                $u_pa_3 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_2->parent_id);
                if ($u_pa_3 && $u_pa_3->use_group == 3) {
                    $parent = $u_pa_3->use_id;
                } else {
                    $u_pa_4 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . (int)$u_pa_3->parent_id);
                    if ($u_pa_4 && $u_pa_4->use_group == 3) {
                        $parent = $u_pa_4->use_id;
                    }
                }
            }
        }
        return $parent;
    }

    //product account
    function product1()
    {
        $group_id = $this->session->userdata('sessionGroup');
        // Set group id
        $data['group_id'] = $group_id;
        if ($group_id == AffiliateStoreUser || $group_id == BranchUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu 1

        #Define url for $getVar
        $action = array('edit', 'search', 'keyword', 'sort', 'by', 'status', 'id', 'page');
        $url1 = $this->uri->segment(4);
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'grouptrade';
        $getVar = $this->uri->uri_to_assoc(5, $action);

        #BEGIN: CHECK GROUP
        if ((int)$this->session->userdata('sessionGroup') == 1) {
            redirect(base_url() . 'account', 'location');
            die();
        }
        #END CHECK GROUP       
        $this->load->library('hash');
        #BEGIN: Search & sort
        $where = '';
        $sort = 'tbtt_product.pro_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';

        $join_1 = 'LEFT';
        $table_1 = 'tbtt_category';
        $on_1 = 'tbtt_product.pro_category = tbtt_category.cat_id';
        $join_2 = '';
        $table_2 = '';
        $on_2 = '';
        $branch = $this->get_branch_grt((int)$this->session->userdata('sessionUser'), (int)$this->uri->segment(4));
        $where .= "pro_user IN(" . $branch . ') and pro_status=1 AND pro_type = 0';
        #If have sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'category':
                    $pageUrl .= '/sort/category';
                    $sort = "cat_name";
                    break;
                case 'postdate':
                    $pageUrl .= '/sort/postdate';
                    $sort = "pro_begindate";
                    break;
                case 'enddate':
                    $pageUrl .= '/sort/enddate';
                    $sort = "pro_enddate";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "pro_order, pro_id";
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
        #END Search & sort

        if ($url1 == 'service' || $url1 == 'coupon') {
            $linkactive = '/' . $url1;
        } else {
            $linkactive = '';
        }

        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/groups/approveproduct/' . $this->uri->segment(4) . $linkactive . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort 
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->product_model->fetch_join("pro_id", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, "", "", "", $where, "", ""));

        $limit = 20;
        $config['base_url'] = base_url() . 'account/groups/approveproduct/' . $this->uri->segment(4) . $linkactive . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);

        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $select = "pro_type,pro_id, pro_name,pro_user, pro_descr, pro_category, pro_dir, pro_image, pro_begindate, pro_enddate, pro_status, pro_view, pro_cost, pro_instock, pro_saleoff_value, pro_type_saleoff, pro_order, cat_name, is_product_affiliate, af_amt, af_rate, pro_of_shop";
        $data['product'] = $this->product_model->fetch_join($select, $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, "", "", "", $where, $sort, $by, $start, $limit);
        $data['totalRecord'] = $totalRecord;
        #Load view       
        $arrProID = array();
        $proNoGroup = $this->group_trade_action_model->get('blacklist_product', 'grt_id = ' . (int)$this->uri->segment(4) . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
        $arrProID = explode(',', $proNoGroup->blacklist_product);
        $data['proNoGroup'] = $arrProID;

        $linkgh = array();
        if (!empty($data['product'])) {
            foreach ($data['product'] as $item) {
                $profile = $this->user_model->get("use_id,use_username,use_fullname", "use_status = 1 AND use_id = " . (int)$item->pro_user);
                $getShop = $this->get_my_shop($item->pro_user);
                $linkgh[] = array(
                    'username' => $profile->use_username,
                    'fullname' => $profile->use_fullname,
                    'link_gh' => $getShop['link_gh'],
                    'link_sp' => $getShop['link_sp']
                );
            }
        }
        $data['info'] = $linkgh;
        $data['flash_message'] = $this->session->flashdata('countProductByUser');
        $data['flash_msg_error'] = $this->session->flashdata('checkConfigBranch');
        $this->load->view('home/group/product_group', $data);
    }

    //tin tức account
    function listnews()
    {
        $group_id = (int)$this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser || $group_id == BranchUser
        ) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }

        $data['group_id'] = $group_id;
        $data['menuSelected'] = 'news';
        $data['menuType'] = 'account';
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'id');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #If have page
        #END Search & Filter
        #BEGIN: Create link sort
        $pageSort = '';
        $pageUrl = '';
        #END Create link sort
        #BEGIN: Status
        $statusUrl = $pageUrl . $pageSort;
        $data['statusUrl'] = base_url() . 'account/grouptrade/news' . $statusUrl;
        $data['menuSelected'] = 'grouptrade';
        $data['menuType'] = 'account';

        $this->load->model('content_model');
        $this->load->model('content_category_model');
        $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
        $data['shop'] = $shop;
        $data['shopid'] = $shop->sho_id;

        $sort = 'not_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageUrl = '';
        $pageSort = '';
        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);

        #If have sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "not_title";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "not_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }

        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & sort

        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/groups/approvenews/' . $this->uri->segment(4) . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort

        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $limmit = 20; // -1 all
        $branch = $this->get_branch_grt((int)$this->session->userdata('sessionUser'), (int)$this->uri->segment(4));

        $data['listnews'] = $this->content_model->fetch_join('use_id,use_fullname,use_username,not_id,not_title,not_detail,not_status, not_image, not_dir_image, not_begindate', 'INNER', 'tbtt_user', 'use_id = not_user', 'not_user IN(' . $branch . ') and not_status=1', $sort, $by, $start, $limmit);
        $totalRecord = count($this->content_model->fetch_join('not_id', 'INNER', 'tbtt_user', 'use_id = not_user', 'not_user IN(' . $branch . ') and not_status=1', $sort, $by, '', ''));
        $config['base_url'] = base_url() . 'account/groups/approvenews/' . $this->uri->segment(4) . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limmit;
        $config['num_links'] = 1;
        $config['uri_segment'] = 6;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        $proNoGroup = $this->group_trade_action_model->get('blacklist_news', 'grt_id = ' . (int)$this->uri->segment(4) . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
        $arrProID = explode(',', $proNoGroup->blacklist_news);
        $data['newsNoGroup'] = $arrProID;
        $linkgh = array();
        if (!empty($data['listnews'])) {
            foreach ($data['listnews'] as $item) {
                $getShop = $this->get_my_shop($item->use_id);
                $linkgh[] = array(
                    'link_gh' => $getShop['link_gh'],
                    'link_sp' => $getShop['link_sp']
                );
            }
        }
        $data['sTT'] = $start + 1;
        $data['info'] = $linkgh;
        //print_r($data);
        $this->load->view('home/group/news_group', $data);
    }

    //duyet product cho account, group
    function duyetsp()
    {
        //$grt_id = $_REQUEST['grt_id'];
        $grt_id = $this->input->post('grt_id');
        if (!$grt_id) {
            $grt_id = $this->uri->segment(2);
        }
        //$pro_id = $_REQUEST['pro_id'];
        $pro_id = $this->input->post('pro_id');
        if ($pro_id != '') {
            $proNoGroup = $this->group_trade_action_model->get('id,blacklist_product', 'grt_id = ' . (int)$grt_id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
            if (count($proNoGroup) > 0) {
                $proNoGroupID = explode(',', $proNoGroup->blacklist_product);
                if (in_array($pro_id, $proNoGroupID)) {
                    $arrProid = array();
                    foreach ($proNoGroupID as $item) {
                        if ($item != $pro_id) {
                            $arrProid[] = $item;
                        }
                    }
                } else {
                    $arrProid = array();
                    if ($proNoGroup->blacklist_product != '') {
                        foreach ($proNoGroupID as $item) {
                            $arrProid[] = $item;
                        }
                    }
                    $arrProid[] = $pro_id;
                }
                $blacklist_product = implode(',', $arrProid);
                $dataEdit = array('blacklist_product' => $blacklist_product);
                $this->group_trade_action_model->update($dataEdit, 'id = ' . (int)$proNoGroup->id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
            }
        }
        echo '<script>window.history.back();</script>';
    }

    //duyet tin cho account, group
    function duyetNews()
    {
        
       
        //$grt_id = $_REQUEST['grt_id'];
        $grt_id = $this->input->post('grt_id');
        if (!$grt_id) {
            $grt_id = $this->uri->segment(2);
        }
        //$news_id = $_REQUEST['news_id'];
        $news_id = $this->input->post('content_id');
        
        $this->load->library('form_validation');

        if ($news_id != '') {
            $proNoGroup = $this->group_trade_action_model->get('id,blacklist_news', 'grt_id = ' . (int)$grt_id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
            if (count($proNoGroup) > 0) {
                $proNoGroupID = explode(',', $proNoGroup->blacklist_news);
                if (in_array($news_id, $proNoGroupID)) {
                    $arrProid = array();
                    foreach ($proNoGroupID as $item) {
                        if ($item != $news_id) {
                            $arrProid[] = $item;
                        }
                    }
                } else {
                    $arrProid = array();
                    if ($proNoGroup->blacklist_news != '') {
                        foreach ($proNoGroupID as $item) {
                            $arrProid[] = $item;
                        }
                    }
                    $arrProid[] = $news_id;
                }
                $blacklist_product = implode(',', $arrProid);
                $dataEdit = array('blacklist_news' => $blacklist_product);
                $this->group_trade_action_model->update($dataEdit, 'id = ' . (int)$proNoGroup->id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
            }
        }
        echo '<script>window.history.back();</script>';
    }

    function leavegroup()
    {
        if ($this->session->userdata('sessionUser') > 0) {
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
        $grt_id = (int)$this->uri->segment(4);
        $data = array();
        $data['menuSelected'] = 'grouptrade';
        $data['menuType'] = 'account';
            $user = $this->user_model->get('use_group_trade', "use_id = " . (int)$this->session->userdata('sessionUser'));
            $use_group_trade = explode(',', $user->use_group_trade);
            if (in_array($grt_id, $use_group_trade)) {
                $arr = array();
                foreach ($use_group_trade as $item) {
                    if ($item != $grt_id) {
                        $arr[] = $item;
                    }
                }
            }
            $usegroup_trade = implode(',', $arr);
            $dataUpdate = array('use_group_trade' => $usegroup_trade);
        if ($this->user_model->update($dataUpdate, "use_id = " . (int)$this->session->userdata('sessionUser')) && $this->group_trade_action_model->delete('grt_id = ' . $grt_id.' AND list_join = ' . (int)$this->session->userdata('sessionUser'))) {
            redirect('/logout', 'location');
        }
    }

    function deletegroup()
    {
        if ($this->session->userdata('sessionUser') > 0) {
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }
        $grt_id = (int)$this->uri->segment(4);
        $data = array();
        $data['menuSelected'] = 'grouptrade';
        $data['menuType'] = 'account';
        $arr = array();
        $list_join = $this->group_trade_action_model->fetch('id','grt_id = ' . $grt_id);
        if(!empty($list_join)){
            foreach ($list_join as $key => $item) {
                $this->group_trade_action_model->delete('', $item->id, 'id', false);
            }
            if($this->grouptrade_model->delete($grt_id,'grt_id')){
                redirect('/logout', 'location');
            }
        }
    }

    function configcommiss($grtID = 0)
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($this->session->userdata('sessionUser') > 0) {
        } else {
            redirect(base_url() . "login", 'location');
        }

        if ($group_id == AffiliateStoreUser || $group_id == BranchUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }

        $data = array();
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'grouptrade';
        $this->load->model('group_commiss_model');
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionCaptchaGrtCommiss'));
        #END Unlink captcha

        $this->load->library('form_validation');
        $error_captcha = $codeCaptcha = '';

        #BEGIN: Create captcha
        $CaptchaConfig = $this->session->userdata('CaptchaConfig');

        $this->form_validation->set_rules('captcha_groupBank', 'captcha', 'callback_check_captcha');
        $notify = '';
        if ($this->form_validation->run() != FALSE && ($CaptchaConfig == $this->input->post('captchaConfig'))) {
            $cmss_for_admin = $this->input->post("cmss_for_grt");
            $cmss_for_sho = $this->input->post("cmss_for_sho");
            if ($cmss_for_admin == '') {
                $cmss_for_admin = 0;
            }
            if ($cmss_for_sho == '') {
                $cmss_for_sho = 0;
            }
            $dataEdit = array(
                "cmss_for_admin" => $cmss_for_admin,
                "cmss_for_shop" => $cmss_for_sho
            );
            if ($this->group_trade_action_model->update($dataEdit, 'list_join = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(4))) {
                $notify = 'Cập nhập dữ liệu thành công';
            }
            $this->session->unset_userdata('CaptchaConfig');
            redirect('account/groups/configcommiss/' . (int)$this->uri->segment(4), 'location');
        } else {
            if ($this->input->post('captchaConfig') && $CaptchaConfig != $this->input->post('captchaConfig')) {
                $error_captcha = 'Mã bảo vệ nhập sai';
            }
            $get_commiss = $this->group_trade_action_model->get('cmss_for_admin, cmss_for_shop, grt_id', 'list_join = ' . (int)$this->session->userdata('sessionUser') . ' AND grt_id = ' . (int)$this->uri->segment(4));
            $data['cmss_for_grt'] = $get_commiss->cmss_for_admin;
            $data['cmss_for_sho'] = $get_commiss->cmss_for_shop;
        }
        $data['notify'] = $notify;

        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $CaptchaGroupBank = $this->session->userdata('CaptchaConfig');
        $this->session->set_flashdata('sessionCaptchaConfig', $codeCaptcha);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        $this->session->set_flashdata('sessionCaptchaGrtCommiss', $imageCaptcha);
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        $data['codeCaptcha'] = $codeCaptcha;
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaConfig'] = $imageCaptcha;
        }
        $this->session->set_userdata('CaptchaConfig', $codeCaptcha);
        #END Create captcha
        ##load view
        $get_grt = $this->grouptrade_model->fetch_join('grt_name, grt_type, cmss_for_admin, cmss_for_shop', 'INNER', 'tbtt_group_trade_action', 'tbtt_group_trade.grt_id = tbtt_group_trade_action.grt_id', '', '', '', 'tbtt_group_trade_action.grt_id = "' . $this->uri->segment(4) . '" and list_join = ' . (int)$this->session->userdata('sessionUser'));
        $data['get_grt'] = $get_grt;
        $this->load->view('home/group/set_commission', $data);
    }

    function listmember_account()
    {
        if ($this->session->userdata('sessionUser') > 0) {
        } else {
            redirect(base_url() . 'login', 'location');
            die();
        }

        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(5, $action);
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';

        $data = array();
        $data['menuSelected'] = 'grouptrade';
        $data['menuType'] = 'account';
        $segment = $this->uri->segment(4);
        $act = $this->uri->segment(5);
        if ($act == 'page' && $this->uri->segment(5) == '') {
            redirect('account/groups/approvemember/' . $segment, 'location');
        }

        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/groups/approvemember/' . $segment . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        $limit = 20;
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        $use_id = (int)$this->uri->segment(6);
        $grt_id = (int)$this->uri->segment(4);
        $listTV = array();
        $userId = '0';
        $array = $this->SearchTree((int)$this->session->userdata('sessionUser'));
        $userId .= implode(',', $array);
                    
        if ($act != '' && $act != 'page') {

            if ($act == 'duyetall') {
                $listmember = $this->user_model->fetch("use_id,use_group_trade", "use_id IN(". $userId .") AND use_status = 1");
                foreach ($listmember as $key => $items) {
                    $arrGrtid = array();
                    $use_arr = explode(',', $items->use_group_trade);
                    if ($use_arr[0] != '') {
                    } else {
                        $use_arr = array();
                    }
                    if (!in_array($this->uri->segment(4), $use_arr)) {
                        $use_arr[] = $this->uri->segment(4);
                    }
                    $addgrt = implode(',', $use_arr);
                    $dataEdit = array(
                        "use_group_trade" => $addgrt
                    );
                    $this->user_model->update($dataEdit, "use_id = " . $items->use_id);
                }
                redirect('account/groups/approvemember/' . $segment, 'location');
            } else {
                $blacklist_user = $this->group_trade_action_model->get('blacklist_user', 'grt_id = ' . (int)$grt_id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
                $arrProid = array();
                $arr_bu = explode(',', $blacklist_user->blacklist_user);
                if ($blacklist_user->blacklist_user != '') {
                    if ($act == 'duyet') {
                        foreach ($arr_bu as $item) {
                            if ($item != $use_id) {
                                $arrProid[] = $item;
                            }
                        }
                    } else {
                        foreach ($arr_bu as $item) {
                            $arrProid[] = $item;
                        }
                        $arrProid[] = $use_id;
                    }
                }
                $blacklist_product = implode(',', $arrProid);
                $dataEdit = array('blacklist_user' => $blacklist_product);
                if ($this->group_trade_action_model->update($dataEdit, 'grt_id = ' . $grt_id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'))) {
                    redirect('account/groups/approvemember/' . $segment, 'location');
                }
            }

        }
        if ($userId != '') {
            $data['listtree'] = $array;
            $listmember = $this->user_model->fetch("use_id,use_group_trade", "use_id IN( " . $userId . ") AND use_status = 1");
            $arr_member = array();
            foreach ($listmember as $key => $items) {
                $use_group_trade = explode(',', $items->use_group_trade);
                if (in_array($this->uri->segment(4), $use_group_trade) && ($items->use_id != (int)$this->session->userdata('sessionUser'))) {
                    $arr_member[] = $items->use_id;
                }
            }
            $list_member = implode(',', $arr_member);
            if ($list_member != '') {
                $listu = $this->user_model->fetch("use_id, parent_id, use_fullname, use_username, use_mobile, use_email, avatar, use_regisdate, use_group_trade", "use_id IN(" . $list_member .") AND use_status = 1");
                 if (!empty($listu)) {
                    $blacklist_user = $this->group_trade_action_model->get('blacklist_user', 'grt_id = ' . (int)$grt_id . ' AND list_join = ' . (int)$this->session->userdata('sessionUser'));
                    $arr_backu = explode(',', $blacklist_user->blacklist_user);
                    $data['arr_backu'] = $arr_backu;
                    foreach ($listu as $key => $value) {
                        $listTV[] = array(
                            'use_id' => $value->use_id,
                            'parent_id' => $value->parent_id,
                            'use_fullname' => $value->use_fullname,
                            'use_username' => $value->use_username,
                            'avatar' => $value->avatar,
                            'use_regisdate' => $value->use_regisdate,
                            'use_mobile' => $value->use_mobile,
                            'use_email' => $value->use_email,
                            'use_group_trade' => $value->use_group_trade,
                            'group_thamgia' => $this->get_grouptrade_user((int)$this->uri->segment(4))
                        );
                    }
                }
            }
        }
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($listu);
        $config['base_url'] = base_url() . 'account/groups/approvemember/' . $segment . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAccount;
        $config['num_links'] = 1;
        $config['uri_segment'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        #sTT - So thu tu
        $data['limit'] = settingOtherAccount;
        $data['stt'] = $start;
        $data['listMember'] = $listTV;
        $this->load->view('home/group/listmember', $data);
    }

    function applyAll()
    {
        $parent_id = $this->input->post('parent_id');
        $group_id = $this->input->post('group_id');
        $array = $this->SearchTree((int)$parent_id);
        if (count($array)) {
            foreach ($array as $value) {
                $user = $this->user_model->get('*', 'use_id = ' . $value);
                if ($user->use_group_trade) {
                    $l = $user->use_group_trade . ',' . $group_id;
                    $query = 'UPDATE tbtt_user SET use_group_trade = "' . $l . '" WHERE use_id = ' . $value;
                    $this->db->query($query);
                } else {
                    $l = $user->use_group_trade;
                    $query = 'UPDATE tbtt_user SET use_group_trade = "' . $l . '" WHERE use_id = ' . $value;
                    $this->db->query($query);
                }
            }
            echo '1';
            exit();
        } else {
            echo '0';
            exit();
        }
    }

    function get_grouptrade_user($list_grouptrade = null)
    {
        if ($list_grouptrade != NULL) {
            $in_grt_id = ' AND tbtt_group_trade.grt_id IN(' . $list_grouptrade . ')';
            $get_grt = $this->grouptrade_model->fetch_join('tbtt_group_trade.grt_id as grt_id,grt_name,grt_link', 'INNER', 'tbtt_group_trade_action', 'tbtt_group_trade.grt_id = tbtt_group_trade_action.grt_id', '', '', '', 'list_join = ' . (int)$this->session->userdata('sessionUser') . $in_grt_id);
            foreach ($get_grt as $k => $value) {
                $result['grt_id'][] = $value->grt_id;
                $result['grt_name'][] = $value->grt_name;
                $result['grt_link'][] = $value->grt_link;
            }
            return $result;
        } else {
            return false;
        }
    }

    function invitemember_account()
    {
        $group_id = $this->session->userdata('sessionGroup');
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . "login", 'location');
        }
        if ($group_id == AffiliateStoreUser) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }

        $data = array();
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'grouptrade';
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionCaptchaGroupBank'));
        #END Unlink captcha
        $get_grt = $this->grouptrade_model->get('grt_id,grt_bank,grt_bank_num,grt_bank_addr', 'grt_admin = "' . (int)$this->session->userdata('sessionUser') . '"');
        $this->load->library('form_validation');

        $note = $error_captcha = $codeCaptcha = '';

        #BEGIN: Create captcha
        $this->load->library('captcha');
        $codeCaptcha = $this->captcha->code(6);
        $CaptchaGroupBank = $this->session->userdata('CaptchaGroupInvite');
        //        if ($this->input->post('captcha_groupBank')) {
        //            $this->form_validation->set_rules('captcha_groupBank', 'lang:captcha', '');
        $this->form_validation->set_rules('captcha_groupMember', 'captcha', 'callback_check_captcha');
        //        $this->form_validation->set_message('callback__valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
        //        $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
        if ($this->form_validation->run() != FALSE && ($CaptchaGroupBank == $this->input->post('captcha_Invitemember'))) {
            $proNoGroup = $this->group_trade_action_model->get('id,list_invite', 'grt_id = ' . (int)$this->uri->segment(2));
            $userid_invite = $this->user_model->get("use_group_trade,use_id", "use_username = '" . $this->input->post("list_invite") . "' AND use_status = 1");
            $proNoGroupID = explode(',', $proNoGroup->list_invite);

            $arrProid = array();
            $addU = $this->input->post("use_id");
            foreach ($proNoGroupID as $j => $item) {
                $arrProid[] = $item;
            }
            $user_invite = array();
            foreach ($addU as $k => $iduser) {
                if (!in_array($iduser, $proNoGroupID)) {
                    $user_invite[] = $iduser;
                }
            }
            if (!empty($user_invite)) {
                $list_invite = implode(',', $user_invite);
                $arrProid[] = $list_invite;
                $blacklist_product = implode(',', $arrProid);
                $dataEdit = array('list_invite' => $blacklist_product);
                if ($this->group_trade_action_model->update($dataEdit, 'id = ' . (int)$proNoGroup->id)) {
                    $data['notification'] = 'Gửi lời mời thành công';
                    $this->session->unset_userdata('CaptchaGroupInvite');
                    redirect('account', 'location');
                }
            }
        } else {
            if ($this->input->post('captcha_Invitemember') && $CaptchaGroupBank != $this->input->post('captcha_Invitemember')) {
                $error_captcha = 'Mã bảo vệ nhập sai';
            }
            $data['list_invite'] = $this->input->post("list_invite");
        }

        $list_User = $this->SearchTree((int)$this->session->userdata('sessionUser'));
        $data['allUser'] = implode(',', $list_User);

        $data['note'] = $note;
        $data['error_captcha'] = $error_captcha;
        $this->session->set_flashdata('imageCaptchaInvitemember', $codeCaptcha);
        $imageCaptcha = 'templates/captcha/' . md5(microtime()) . '.' . (int)$this->session->userdata('sessionUser') . 'chpa.jpg';
        $this->session->set_flashdata('imageCaptchaInvitemember', $imageCaptcha);
        $this->captcha->create($codeCaptcha, $imageCaptcha);
        $data['codeCaptcha'] = $codeCaptcha;
        if (file_exists($imageCaptcha)) {
            $data['imageCaptchaInvitemember'] = $imageCaptcha;
        }
        $this->session->set_userdata('CaptchaGroupInvite', $codeCaptcha);
        $this->load->view('home/group/invite_member', $data);
    }

    function get_user()
    {
        $name = $_REQUEST['name'];
        $result = array();
        $result['error'] = FALSE;
        $userid_invite = $this->user_model->get("use_id,use_username", "use_username = '" . $name . "' AND use_status = 1");
        if ($userid_invite) {
            if (count($userid_invite) > 0) {
                $result['id'] = $userid_invite->use_id;
                $result['name'] = $userid_invite->use_username;
            } else {
            }
        } else {
            $result['id'] = '0';
            $result['name'] = 'không xác định';
            $result['error'] = TRUE;
            $result['message'] = 'Failed!!';
        }
        echo json_encode($result);
    }

    ##Get my company, I am Branch or Staff or StaffStore
    function get_my_shop($userId)
    {
        $protocol = "http://";//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $pshop = $link = '';
        $p_userddd = $this->user_model->get('use_id,use_username, use_group, parent_id, use_status', 'use_status = 1 AND use_id = ' . (int)$userId);
        $linksp = '';
        switch ($p_userddd->use_group) {
            case AffiliateStoreUser:

                $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$p_userddd->use_id);
                $domain_p = $checkDomain->sho_link . '.' . $domainName;
                if ($checkDomain->domain != '') {
                    $domain_p = $checkDomain->domain;
                }
                $pshop = $checkDomain->sho_link;
                $link = $linksp = $protocol . $domain_p;
                break;

            case StaffUser:

                $user_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$p_userddd->parent_id);
                $userID = $user_p->use_id;
                if ($user_p->use_group == BranchUser) {
                    $info_parent = 'CN: ' . $user_p->use_username;
                    $checkDomain_parent = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$user_p->use_id);

                    $user_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$user_p->parent_id);
                    $userID = $user_p_p->use_id;
                    if ($user_p_p->use_group == StaffStoreUser) {
                        $info_parent .= ' ,NVGH: ' . $user_p_p->use_username;
                        $checkDomain_parent = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$user_p_p->parent_id);

                        $user_p_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$user_p_p->parent_id);
                        $userID = $user_p_p_p->use_id;
                        $info_parent .= ', GH: ' . $user_p_p_p->use_username;
                    } else {
                        $info_parent .= ', GH: ' . $user_p_p->use_username;
                    }
                } else {
                    $info_parent = 'GH: ' . $user_p->use_username;
                }
                break;

            case BranchUser:

                $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$p_userddd->use_id);
                $user_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$p_userddd->parent_id);
                $userID = $user_p->use_id;
                $info_parent = 'GH: ' . $user_p->use_username;
                $checkDomain_p = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$user_p->use_id);
                if ($user_p->use_group == StaffStoreUser) {
                    $user_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$user_p->parent_id);
                    $userID = $user_p_p->use_id;
                    $info_parent = 'NVGH: ' . $user_p->use_username . ', GH: ' . $user_p_p->use_username;
                    $checkDomain_p = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$user_p_p->use_id);
                }
                $domain_p = $checkDomain_p->sho_link . '.' . $domainName;
                if ($checkDomain_p->domain != '') {
                    $domain_p = $checkDomain_p->domain;
                }
                $pshop = $checkDomain->sho_link;
                $link = $protocol . $domain_p . '/' . $checkDomain->sho_link;
                //get link sp, link tin
                $linksp = $protocol . $checkDomain->sho_link . '.' . $domainName;
                if ($checkDomain->domain != '') {
                    $linksp = $protocol . $checkDomain->domain;
                }
                break;

            case StaffStoreUser:
                $user_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$p_userddd->parent_id);
                $userID = $user_p->use_id;
                $info_parent = 'GH: ' . $user_p->use_username;
                break;

            case AffiliateUser:
                // $get_p = $this->user_model->fetch_join('use_id, parent_id, use_group, sho_link, domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                $sho_aff = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . (int)$p_userddd->use_id);
                $user_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . (int)$p_userddd->parent_id);
                $userID = $user_p->use_id;
                $info_parent = 'GH: ' . $user_p->use_username;
                switch ($user_p->use_group) {
                    case StaffUser:
                        $info_parent = 'NV: ' . $user_p->use_username;
                        $user_p1 = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p->parent_id);
                        $userID = $user_p1->use_id;
                        $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $user_p1->use_id);
                        if ($user_p1->use_group == BranchUser) {
                            $info_parent .= ', CN: ' . $user_p1->use_username;

                            $user_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p1->parent_id);
                            $userID = $user_p_p->use_id;
                            if ($user_p_p->use_group == StaffStoreUser) {
                                $info_parent .= ' ,NVGH: ' . $user_p_p->use_username;

                                $user_p_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p_p->parent_id);
                                $userID = $user_p_p_p->use_id;
                                $info_parent .= ', GH: ' . $user_p_p_p->use_username;
                            } else {
                                $info_parent .= ', GH: ' . $user_p_p->use_username;
                            }
                        } else {
                            $info_parent .= ', GH: ' . $user_p1->use_username;;
                        }
                        break;
                    case BranchUser:
                        $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $user_p->use_id);
                        $user_p1 = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p->parent_id);
                        $userID = $user_p->use_id;
                        $info_parent = 'CN: ' . $user_p->use_username . ', GH: ' . $user_p1->use_username;

                        if ($user_p1->use_group == StaffStoreUser) {
                            $user_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p1->parent_id);
                            $userID = $user_p_p->use_id;

                            $info_parent = 'CN: ' . $user_p->use_username . ', NVGH: ' . $user_p1->use_username . ', GH: ' . $user_p_p->use_username;
                            //  $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $user_p_p->use_id);
                        }
                        break;
                    case StaffStoreUser:
                        $user_p_p = $this->user_model->get("use_id,use_username, use_group, parent_id", "use_status = 1 AND use_id = " . $user_p->parent_id);
                        $userID = $user_p_p->use_id;

                        $info_parent = 'NVGH: ' . $user_p->use_username . ', GH: ' . $user_p_p->use_username;
                        $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $user_p_p->use_id);
                        break;
                    default:
                        $checkDomain = $this->shop_model->get('sho_id, sho_link, domain', 'sho_user = ' . $user_p->use_id);
                        break;
                }

                $pshop = $checkDomain->sho_link;
                $link = $protocol . $checkDomain->sho_link . '.' . $domainName;
                if ($checkDomain->domain != '') {
                    $pshop = $checkDomain->domain;
                    $link = $protocol . $checkDomain->domain;
                }
                $linksp = $link;
                $link .= '/' . $sho_aff->sho_link;

                break;

            default:

                break;
        }
        $info = array(
            'info_parent' => $info_parent,
            'pshop' => $pshop,
            'link_gh' => $link,
            'link_sp' => $linksp
        );
        return $info;
    }

    function getuser_group()
    {
        $tree = array();
        $sub_tructiep = $this->grouptrade_model->get('grt_id', 'grt_admin = "' . $this->session->userdata('sessionUser') . '"');

        if (!empty($sub_tructiep)) {
            foreach ($sub_tructiep as $key => $value) {
                $tree[] = $value->grt_id;
            }
        }
        $getgroup = implode(',', $tree);
        if (!empty($getgroup)) {
            $staffs = $this->user_model->fetch('use_id', 'grt_id IN(' . $getgroup . ')', '', '', '', '');
            $treemembergroup = array();
            if (!empty($staffs)) {
                foreach ($staffs as $key => $value) {
                    $treemembergroup[] = $value->use_id;
                }
            }
        }
        $treemembergroup[] = (int)$this->session->userdata('sessionUser');
        $tree_userid = implode(',', $treemembergroup);
        return $tree_userid;
    }

    function get_branch_grt($user_id, $grt)
    {
        $tree = $arr_trade = $arr_cn_trade = array();
        $get_p = $this->user_model->fetch('use_id, use_group, use_group_trade', 'parent_id IN(' . $user_id . ') and ( use_group = ' . BranchUser . ' OR use_group = ' . StaffStoreUser . ')', "", "", "", "");
        if($this->session->userdata('sessionUser') && $this->uri->segment(3) != 'statisticsadmin' && $this->uri->segment(3) != 'statisticsshop'){
            $tree[] = $this->session->userdata('sessionUser');
        }
        //get user cua cay khac ma tham gia nhom cua sessionUser
        $userKhac = explode(',', $user_id);
        if (count($userKhac) > 1) {
            foreach ($userKhac as $key => $value) {
                $arr_trade = explode($value->use_group_trade);
                if (in_array($grt, $arr_trade)) {
                    $tree[] = $value->use_id;
                }
            }
        }
        //end
        if (!empty($get_p)) {
            
            foreach ($get_p as $keys => $value) {
                $arr_trade = explode(',', $value->use_group_trade);
                if ($value->use_group == BranchUser && in_array($grt, $arr_trade)) {
                    $tree[] = $value->use_id;
                }
                if ($value->use_group == StaffStoreUser) {
                    $get_cn = $this->user_model->fetch('use_id, use_group_trade', 'parent_id =' . (int)$value->use_id . ' and use_group = ' . BranchUser, "", "", "", "");
                    if (!empty($get_cn)) {
                        foreach ($get_cn as $key => $value1) {
                            $arr_cn_trade = explode(',', $value1->use_group_trade);
                            if (in_array($grt, $arr_cn_trade)) {
                                $tree[] = $value1->use_id;
                            }
                        }
                    }
                }
            }
        }
        $parent_bran = implode(',',$tree);
        return $parent_bran;
    }

    function get_branch($user_id)
    {
        $tree = array();
        $get_p = $this->user_model->fetch('use_id, use_group', 'parent_id IN(' . $user_id . ') and ( use_group = ' . BranchUser . ' OR use_group = ' . StaffStoreUser . ')', "", "", "", "");
        $tree[] = $this->session->userdata('sessionUser');
        //get user cua cay khac ma tham gia nhom cua sessionUser
        $userKhac = explode(',', $user_id);
        if (count($userKhac) > 1) {
            foreach ($userKhac as $key => $value) {
                $tree[] = $value;
            }
        }
        //end
        if (!empty($get_p)) {
            foreach ($get_p as $key => $value) {
                if ($value->use_group == BranchUser) {
                    $tree[] = $value->use_id;
                }
                if ($value->use_group == StaffStoreUser) {
                    $get_cn = $this->user_model->fetch('use_id', 'parent_id =' . (int)$value->use_id . ' and use_group = ' . BranchUser, "", "", "", "");
                    if (!empty($get_cn)) {
                        foreach ($get_cn as $key => $value1) {
                            $tree[] = $value1->use_id;
                        }
                    }
                }
            }
        }
        $parent_bran = implode($tree, ',');
        return $parent_bran;
    }

    ///END
    function checkpackshopusing()
    {
        if ($this->session->userdata('sessionUser')) {
            $get_current_pack = $this->package_user_model->getCurrentPackage((int)$this->session->userdata('sessionUser'));
            if ($get_current_pack && ($get_current_pack['id'] == 4 || $get_current_pack['id'] == 7)) {
                echo '1';
                exit();
            }
        }
        echo '-1';
        exit();
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

    function products2($page = 0)
    {
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
            $body = array();
            // get cau hinh hoa hong cho aff
            $get_u = $this->user_model->get('use_id,parent_id, use_group', 'use_id = "' . $this->session->userdata('sessionUser') . '"');
            switch ($get_u->use_group) {
                case AffiliateUser:
                    $get_p1 = $this->user_model->get('use_id,parent_id, use_group', 'use_id = "' . $get_u->parent_id . '"');
                    $get_p2 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $get_p1->parent_id . '"');
                    if ($get_p2) {
                        $get_p3 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p2->parent_id . '"'); //lay cha thu 2
                    }
                    if ($get_p3->use_group == StaffStoreUser) {
                        $get_p4 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p3->parent_id . '"'); //lay cha thu 3
                        $sho_user = $get_p4->use_id;

                    } else {
                        if ($get_p2->use_group == AffiliateStoreUser || $get_p2->use_group == StaffStoreUser || $get_p2->use_group == BranchUser) {
                            if ($get_p2->use_group == AffiliateStoreUser) {
                                $sho_user = $get_p2->use_id;
                                if ($get_p1->use_group == StaffStoreUser) {
                                }
                            } else {
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
            $list_commiss_sho = $this->commissionaffilite_model->fetch("id, sho_user, min, max, percent", "sho_user = " . (int)$sho_user, '', '', '', '');
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
            $body['list_commiss_sho'] = end($L_Array1);
            //  end cau hinh hoa hong
            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;
            $body['sho_category'] = $shop->sho_category;
            $afId = (int)$this->session->userdata('sessionUser');

            $body['number_cat'] = 1;
            $numberMyProduct = $this->af_product_model->myNumberProduct($afId);
            $body['numberMyProduct'] = $numberMyProduct;
            $catlv = $this->category_model->fetch('cat_id, cat_name, parent_id', 'cat_level = 0 AND cat_status = 1', "", "", "", "");
            if (isset($catlv)) {
                foreach ($catlv as $key => $item) {
                    $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
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

            $body['products'] = $this->af_product_model->lister1($afId, $page, $cat_id);

            $user_detail = $this->user_model->get('*', "use_id = " . (int)$this->session->userdata('sessionUser'));
            $this->db->flush_cache();
            $parent_detail = $this->user_model->get('*', "use_id = " . $user_detail->parent_id);
            if ((int)$parent_detail->use_group != AffiliateStoreUser && (int)$parent_detail->use_group != BranchUser && (int)$parent_detail->use_group != StaffStoreUser && (int)$parent_detail->use_group != StaffUser && $user_detail->parent_shop == 0) {
                $body['show_btn'] = 1;
            } else {
                $body['show_btn'] = 1;
            }
            $get_domain = $this->shop_model->get('sho_id, domain', 'sho_user = "' . (int)$parent_detail->use_id . '"');
            $body['domain'] = $get_domain->domain;

            $body['pager'] = $this->af_product_model->pager;
            $body['sort'] = $this->af_product_model->getAdminSort();
            $body['filter'] = $this->af_product_model->getFilter();
            $body['category'] = $this->af_product_model->getCategory();
            $body['link'] = base_url() . $this->af_product_model->getRoute('product');
            $body['productLink'] = $body['link'];
            $body['myproductsLink'] = base_url() . $this->af_product_model->getRoute('myproducts');
            $body['num'] = $page;
            $body['shopCategory'] = $this->af_product_model->getShopCategory();
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'affiliate';
            $this->load->view('home/affiliate/products', $body);
        } else {
            redirect(base_url() . 'login', 'location');
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

            $body = array();
            $select = '';
            $where = '';
            $pageSort = '';
            $pageUrl = '';
            $sort = '';
            $by = '';

            $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
            $getVar = $this->uri->uri_to_assoc(4, $action);
            $getVar['sort'] = $getVar['sort'] != '' ? $getVar['sort'] : 'id';
            $getVar['by'] = $getVar['by'] != '' ? $getVar['by'] : 'desc';
            switch (strtolower($getVar['sort'])) {
                case 'name':
                    $pageUrl .= '/sort/name';
                    $sort = "pro_name";
                    break;
                case 'cost':
                    $pageUrl .= '/sort/cost';
                    $sort = "pro_cost";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "tbtt_product.pro_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
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
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;

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
            $pro_type = 0;
            $ptype = (int)$this->input->post('product_type');
            if ($ptype && $ptype > 0) {
                $pro_type = $ptype;
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

            $select .= "tbtt_product.pro_id, pro_name, pro_category, pro_descr, pro_cost, pro_user, pro_image, pro_dir, pro_type, af_amt, af_rate, sho_link, sho_name, domain";
            $products = $this->af_product_model->myProduct1($select, $afId, "LEFT", "tbtt_shop", "tbtt_product.pro_user = tbtt_shop.sho_user", "", "", "", $where, $sort, $by, $start, 0, false, $page);

            $body['products'] = $products['data'];
            $body['setAfKey'] = $products['setAfKey'];
            $body['parent_shop'] = $id_my_parent;
            $body['pro_type'] = (int)$pro_type;

            $body['pager'] = $this->af_product_model->pager;
            $body['sort'] = $this->af_product_model->getAdminSort();
            $body['filter'] = $this->af_product_model->getFilter();
            $body['category'] = $this->af_product_model->getCategory();
            $body['link'] = base_url() . $this->af_product_model->getRoute('myproducts');
            $body['myproductsLink'] = $body['link'];
            $body['productLink'] = base_url() . $this->af_product_model->getRoute('product');
            $body['num'] = $page;
            $body['shopCategory'] = $this->af_product_model->getShopCategory();
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'affiliate';
            #Load View
            $this->load->view('home/affiliate/myproducts', $body);

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
            $body = array();

            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;
            $afId = (int)$this->session->userdata('sessionUser');
            $body['products'] = $this->af_product_model->pressProduct(array('use_id' => $afId), $page);
            $body['pager'] = $this->af_product_model->pager;
            $body['sort'] = $this->af_product_model->getAdminSort();
            $body['filter'] = $this->af_product_model->getFilter();
            $body['category'] = $this->af_product_model->getCategory();
            $body['link'] = base_url() . 'account/affiliate/pressproducts';
            $body['pressproductsLink'] = $body['link'];
            $body['productLink'] = base_url() . $this->af_product_model->getRoute('product');
            $body['num'] = $page;
            $body['shopCategory'] = $this->af_product_model->getShopCategory();
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'affiliate';
            $this->load->view('home/affiliate/pressproducts', $body);

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
        foreach ($cat as $item) {
            if ($item->total_pro == $product_allow_af) {
                $product_allow_aftotal = 1;
            }
        }
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
                    } elseif (($status == 1) && $product_allow_aftotal == 1) {
                        $return = array('error' => true, 'message' => 'Bạn chỉ có thể gắp hàng tối đa ' . $product_allow_af . ' sản phẩm trong một danh mục!');
                    }
                }
            }
        }
        echo json_encode($return);
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
            $body = array();

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
            $body['parent'] = $parent;

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
                    $body['orders'] = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . ')', $page);
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
                    $body['info_parent'] = $LArray;
                    break;
                default:
                    $afId = (int)$this->session->userdata('sessionUser');
                    $body['orders'] = $this->af_order_model->getAfList(array('tbtt_showcart.af_id ' => $afId), $page);

                    break;
            }


            $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
            $body['shop'] = $shop;
            $body['shopid'] = $shop->sho_id;
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'showcart';
            $body['pager'] = $this->af_order_model->pager;
            $body['sort'] = $this->af_order_model->getAdminSort();
            $body['link'] = base_url() . $link;
            $body['status'] = $this->af_order_model->getStatus();
            $body['filter'] = $this->af_order_model->getFilter();
            $body['num'] = $page;

            $this->load->view('home/affiliate/orders', $body);

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
            $body = array();
            $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$this->session->userdata('sessionUser') . '"');
            $protocol = "http://";//(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $duoi = '.' . $_SERVER['HTTP_HOST'].'/';
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
            $body['parent'] = $parent;
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
                    $group = AffiliateUser;
                    /*if($this->uri->segment(3)=='bran_order'){
                        $group =BranchUser;
                    }*/
                    $getAF = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . $group . ') AND use_status = 1 AND parent_id IN(' . $parentId . ')');

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
                    $limit = settingOtherAccount;//
                    // $totalRecord = count($this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . $idCN . ')', '', ''));
                    $totalRecord = count($this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ')' . $saler, '', ''));
                    $config['base_url'] = base_url() . 'account/affiliate/orders' . $pageUrl . '/page/';
                    $config['total_rows'] = $totalRecord;
                    $config['per_page'] = $limit;
                    $config['num_links'] = 1;
                    $config['cur_page'] = $start;
                    $this->pagination->initialize($config);
                    $body['pager'] = $this->pagination->create_links();
                    $body['num'] = $start;
                    #END Pagination
                    // $body['orders'] = $liststore = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ') AND shc_saler IN(' . $get_u->parent_id . $idCN . ')', $start, $limit);
                    $body['orders'] = $liststore = $this->af_order_model->getAfListV2('tbtt_showcart.af_id IN(' . $afAll . ')' . $saler, $start, $limit);
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
                    $body['info_parent'] = $LArray;
                    break;
                default:
                    $afId = (int)$this->session->userdata('sessionUser');
                    $body['orders'] = $orders = $this->af_order_model->getAfList(array('tbtt_showcart.af_id' => $afId), $page);

                    $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser'));
                    $body['shop'] = $shop;
                    $body['shopid'] = $shop->sho_id;
                    $body['pager'] = $this->af_order_model->pager;
                    $body['sort'] = $this->af_order_model->getAdminSort();
                    $body['link'] = base_url() . $link;
                    $body['status'] = $this->af_order_model->getStatus();
                    $body['filter'] = $this->af_order_model->getFilter();
                    $body['num'] = $page;
                    break;
            }
            $body['menuType'] = 'account';
            $body['menuSelected'] = 'showcart';

            $this->load->view('home/affiliate/orders', $body);

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

    function loadCategoryRoot($parent, $level, $style, $listcat = '')
    {
        $select = "*";
        $whereTmp = "cat_status = 1 AND cate_type = " . $style;
        if($listcat != ''){
            $whereTmp .= ' AND cat_id IN(' . $listcat . ')';
        }else{
            $whereTmp .= " AND parent_id = " . $parent;
        }
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }
    
    function repinvite()
    {
        $reply = (int)$this->input->post('reply');
        $uid = (int)$this->input->post('uid');
        $grt = (int)$this->input->post('grt');

        $user = $this->user_model->get("use_invite,use_group_trade", "use_id = " . $uid);
        if ($user) {
            // delete id group trade invite
            $l_invite = explode(',', $user->use_invite);
            foreach ($l_invite as $key => $value) {
                if ((int)$value == $grt) {
                    unset($l_invite[$key]);
                }
            }

            $str_invite = implode(',', $l_invite);
            $t = count($l_invite);
            $use_arr = explode(',', $user->use_group_trade);

            // add grouptrade action 
            if ($reply == 1) {
                $data = array('grt_id' => $grt, 'list_join' => $uid, 'createdate' => date('Y-m-d H:i:s', time()));
                $this->group_trade_action_model->add($data);
                if ($user->use_group_trade != '') {
                    if (!in_array($grt, $use_arr)) {
                        $use_arr[] = $grt;
                    }
                } else {
                    $use_arr = array();
                    $use_arr[] = $grt;
                }
            }
            $addgrt = implode(',', $use_arr);
            // update list invite this user
            $this->user_model->update(array('use_invite' => $str_invite, "use_group_trade" => $addgrt), 'use_id = ' . $uid);

            echo $t;
            exit();
        }
        echo '-1';
        exit();
    }    
    
    public function autocomplete()
    {
        $search_data = $this->input->post('search_data');
        $slq = 'SELECT sho_name FROM tbtt_shop INNER JOIN tbtt_user ON use_id = sho_user AND use_group IN (14,3) WHERE sho_name LIKE "%'.$search_data.'%"';        
        $query = $this->db->query($slq);        
        $result = $query->result();        
        if (!empty($result))
        {
             foreach ($result as $row):
                  echo "<li>" . $row->sho_name . "</li>";
             endforeach;
        }
        else
        {
              echo "<li> <em> Not found ... </em> </li>";
        }
    }
    
    function loadCategory($parent)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id = '$parent' and cate_type = 0";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_id", "ASC");	
        if (count($category) > 0) {
            $retArray .= "<ul id='megamenu' class='mega-menu right'>";
            foreach ($category as $key => $row) { 
		$link = '<a href="//' . domain_site .'/'. $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key == 0) {
                    $retArray .= "<li class='az-mega-li menu_item_first'>". $link;
                } else if ($key == count($category) - 1) {
                    $retArray .= "<li class='az-mega-li menu_item_last'>" . $link;
                } else {
                    $retArray .= "<li class='az-mega-li'>" . $link;
                }
                $retArray .= $this->loadCategory($row->cat_id);
                $retArray .= "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
    }
} 
