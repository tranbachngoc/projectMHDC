<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    private $layout = '';

    public $is_mobile  = false;
    public $is_ios     = false;
    public $is_android = false;

	function __construct() {

		parent::__construct();
		// load lib call api
		$this->load->library('Api_lib');
		//register new hook
        $GLOBALS['EXT']->_call_hook('pre_controller_constructor');

        $this->get_profile_user();

        if(!empty($_SERVER['HTTP_REFERER'])){
            $azibai_regex = str_replace(['/', '.'], ['\/', '\.'], azibai_url());
            if(preg_match('/^'.$azibai_regex.'/', $_SERVER['HTTP_REFERER'])){
                $this->session->set_userdata('visited_azibai', date('Y-m-d'));
            }
        }

   		$this->load->helper('cookie');

   		$list_cookie = [];
   		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
	        $parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        if ($name == 'etc_anything_sessionAz') {
	        	$list_cookie[] = $parts[1];
	        }
	    }

	    if (count($list_cookie) > 1)
	    {
	    	// $cookie_info = session_get_cookie_params();
	    	// if (!empty($cookie_info['path']) && $cookie_info['path'] != "/") 
	    	// {
	    	// 	$this->session->sess_destroy();
	    	// }
	    	if (empty($this->session->userdata('auth_callback_in')) && empty($this->session->userdata('sessionUser'))) 
            {
            	$this->session->sess_destroy();
            }
	    }

        if(strpos($_SERVER["HTTP_USER_AGENT"], "facebookexternalhit/") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Facebot") !== false || strpos($_SERVER["HTTP_USER_AGENT"], "Azibai") !== false) 
        {

        }else if ( isset($_SERVER['HTTP_X_FORWARDED_HOST'])  &&   strpos( $_SERVER['HTTP_X_FORWARDED_HOST'], domain_site ) === false && $this->input->server('REQUEST_METHOD') == 'GET' && $this->input->is_ajax_request() === FALSE) {
       	 //if ( $this->input->server('REQUEST_METHOD') == 'GET' && $_SERVER['HTTP_HOST'] !== domain_site ) {
       	 	$current_url =& get_instance(); //  get a reference to CodeIgniter
       	 	$this->load->helper('url');
			$fullURL   	= !empty($_SERVER['QUERY_STRING']) ? current_url() . '?' . $_SERVER['QUERY_STRING'] : current_url();

			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $link_redirect = $protocol.$_SERVER['HTTP_X_FORWARDED_HOST'].'/';

       	 	if ($current_url->router->fetch_class() == 'login' && $current_url->router->fetch_method() == 'logout') {
       	 		redirect('https://'. domain_site . '/logout');
       	 	}
       	 	if ($current_url->router->fetch_class() == 'login' && $current_url->router->fetch_method() == 'index') {
       	 		redirect('https://'. domain_site . '/login?callback='.$link_redirect);
       	 	}



			if (isset($_REQUEST['tokenId']) && isset($_REQUEST['callback']))
			{

	        	$this->db->select("user_data");
		        $this->db->where("session_id", $_REQUEST['tokenId']);
		        $access = $this->db->get("tbtt_session")->row();

		        $this->session->unset_userdata('sessionUser');
		        $this->session->unset_userdata('sessionGroup');
		        $this->session->unset_userdata('sessionUsername');
		        $this->session->unset_userdata('sessionName');
		        $this->session->unset_userdata('sessionAvatar');
			    if (!empty($access))
			    {	
		    		$udata = unserialize($access->user_data);
			        unset($udata[0]);
			        unset($udata[1]);
			        $udata['auth_callback_in'] = true;
			        $this->session->set_userdata($udata);
			        redirect($_REQUEST['callback']);
			    }
			    else
			    {
			    	$udata = array('auth_callback_in' => true);
			        $this->session->set_userdata($udata);
			        redirect($_REQUEST['callback']);
			    }
	        } 
	        
	        if (empty($this->session->userdata('auth_callback_in')))
	        {	
				redirect('https://'. domain_site . '/home/login/getAuthLogin?callback='.$fullURL);
	        } 
	        else 
	        {
	        	$this->session->unset_userdata('auth_callback_in');
	        }
		}

        $this->load->library('Mobile_Detect');
        $detect           = new Mobile_Detect();
        $data['isMobile'] = 0;
        $this->is_android = $data['isAndroid'] = $detect->isAndroidOS();
        $this->is_ios     = $data['isiOS'] = $detect->isiOS();
        $this->is_mobile  = $data['isMobile'] = $detect->isMobile();

        if ($this->is_mobile || $this->is_android || $this->is_ios) {
            $data['isMobile'] = 1;
            $this->is_mobile  = 1;
        }

        $this->load->vars($data);

	}

	//overrider view, tạo layout để extend lại view
    //https://stackoverflow.com/questions/3675135/codeigniter-best-way-to-structure-partial-views
    function _output($content)
    {
        // Load the base template with output content available as $content
        if($this->input->is_ajax_request()){
            $this->layout = '';
        }
        if($this->layout){
            $data['layout_extend'] = &$content;
            echo $this->load->view($this->layout, $data, true);
        }else{
            echo $content;
        }
    }

    public function set_layout($layout_name = '')
    {
        $this->layout = $layout_name;
    }

    public function get_layout()
    {
        return $this->layout;
    }

	public function loadCategory($parent, $level) {
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   //$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
			   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
			   if($key == 0){
			   		$retArray .= "<li class='menu_item_top dc-mega-li'>".$link;
			   }else if($key == count($category)-1){
			   		$retArray .= "<li class='menu_item_last dc-mega-li'>".$link;
			   }else{
			   		$retArray .= "<li class='dc-mega-li'>".$link;
			   }
			   $retArray .=$this->loadSubCategory($row->cat_id, $level+1);
			   $retArray .= "</li>";
		   }
		     $retArray .= "</ul>";
	   }
	   return $retArray;
	}

	public function loadSubCategory($parent, $level) {
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega'>";
			$retArray .= "<ul class='sub'>";
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 450;}
			if(count($category) >= 3){$rowwidth = 660;}
			foreach ($category as $key=>$row)
			{
				
				$link = '<a class="mega-hdr-a" alt="'.$row->cat_name.'" href="'.base_url().'ads/category/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				if($key % 3 == 0){
					$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 2 || $key = count($category)-1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
					$retArray .= "</div>";
				}
			}
			$retArray .= "</ul></div>";
	   }
	   return $retArray;
	}

	public function loadSubSubCategory($parent, $level) {
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC","0","5");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor($row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
				$retArray.= "<li ><a class='xemtatca_menu' href='".base_url()."product/xemtatca/".$parent."' > Xem tất cả </a></li>";
			$retArray .= "</ul>";
	   }
	   return $retArray;
	}

	/**
     ***************************************************************************
     * Created: 2018/08/16
     * Create captcha
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: image captcha
     *  
     ***************************************************************************
    */

	public function createCaptcha($name = '') {
		// Load library
		$this->load->library('captcha');
		$this->load->library('ftp');

		$data = array();

		// Create FTP

        
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);

        $path = '/public_html/captcha/';

        if($name != '') {
        	$sImageName = $name;
        }else {
        	$sImageName = md5(microtime()).'.'.rand(10, 10000).'coni.jpg';
        }
        

		$codeCaptcha = $this->captcha->code(6);
		$data['captcha'] = $codeCaptcha;
        $pathCaptcha = 'templates/captcha/';
        $imageCaptcha = 'templates/captcha/'.$sImageName;

        if (!is_dir($pathCaptcha)) {
            @mkdir($pathCaptcha, 0777, true);
            @write_file($pathCaptcha . '/index.html', '<p>Directory access is forbidden.</p>');
        }

		$this->captcha->create($codeCaptcha, $imageCaptcha);

		$this->ftp->upload($imageCaptcha,$path.$sImageName,0755);

		$aListFile = $this->ftp->list_files($path.$sImageName);
		if(!empty($aListFile)) {
			unlink($imageCaptcha);
			$data['imageCaptchaContact'] = DOMAIN_CLOUDSERVER.'captcha/'.$sImageName;
		}
		$this->ftp->close();
		return $data;
	}

	/**
     ***************************************************************************
     * Created: 2018/08/25
     * Convert String to Image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return image
     *  
     ***************************************************************************
    */
	public function convertStringToImage($name = '', $path = '', $sData) {

		if (preg_match('/^data:image\/(\w+);base64,/', $sData)) {

            $data = explode(';', $sData);
            $type = str_replace('data:image/', '', $data[0]);

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }

            $img_temp =  base64_decode(str_replace('base64,', '', $data[1]));

            $success = file_put_contents($path.'/'.$name, $img_temp);
            

            if ($success === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        return true;
	}

	/**
     ***************************************************************************
     * Created: 2018/10/27
     * Convert String to Image upload ftp
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return image
     *  
     ***************************************************************************
    */

	public function convertStringToImageFtp($name = '', $path = '', $sData, $sType = '') {

		if ($newdata = preg_replace('/^data:image\/(\w+);base64,/', '', $sData)) {
			
            $data = explode(';', $sData);
            $type = str_replace('data:image/', '', $data[0]);

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
 
            $img_temp =  base64_decode($newdata);
            if($sType != '') {
            	$success = file_put_contents($path.$name.$sType, $img_temp);
            }else {
            	$success = file_put_contents($path.$name.'.'.$type, $img_temp);
            }
            
            

            if ($success === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        return $type;
	}

    /**
     * @param string $location admin|home
     * @return boolean
     */
    public function isLogin($location = 'home')
    {
        return $this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), $location);
	}

	/**
     ***************************************************************************
     * Created: 2019/01/18
     * Check image base64
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return boolean
     *  
     ***************************************************************************
    */

	public function checkBase64Image($sData) {
		$sString = strpos($sData, ';');
		if($sString != '') {
			return true;
		} else {
			return false;
		}
	}

	/**
     ***************************************************************************
     * Create view query product on Azibai E-commerce
     ***************************************************************************
     */

    public function createViewProduct()
    {
		// af_dc_amt người mua đc giảm VND
		// af_dc_rate người mua đc giảm %
		// af_amt người mua đc nhận VND
		// af_rate người mua đc nhận %

        // create/replace view product status = 1 has or has TQC 
        $this->db->query("CREATE OR REPLACE VIEW tbtt_view_market_product AS 
            SELECT tbtt_product.pro_id, pro_type, pro_user, tbtt_product.pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, pro_view, pro_quality,
                    is_product_affiliate, af_amt, af_rate, af_dc_amt, af_dc_rate,
                    COALESCE(id, 0) AS dp_id, dp_images, dp_cost
            FROM tbtt_product
            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = tbtt_product.pro_id
            WHERE pro_status = 1 AND pro_instock > 0
            GROUP BY pro_id, dp_id");
	}
	


	// callAPI
	//request.Headers.Add("user_id", userID);
	function callAPI($method, $url, $data = null, $headers = false){
		$curl = curl_init();

		switch ($method){
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				if ($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// OPTIONS:
		curl_setopt($curl, CURLOPT_URL, $url);
		if(!$headers){
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			   'Content-Type: application/json',
			));
		}else{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		// EXECUTE:
		$result = curl_exec($curl);

		if(curl_errno($curl)) {
			$error_msg = curl_error($curl);
			$result = json_encode($error_msg);
		}

		curl_close($curl);
		return $result;
	}

    public function get_profile_user($user_id = null)
    {
        $user = [];
        $CI =& get_instance();

        if(!$user_id){
            $user_id  = (int)$CI->session->userdata('sessionUser');
        }

        if($user_id){
            $CI->load->model('user_model');
            $CI->load->model('shop_model');
            $CI->load->helper('theme');
            $user = $CI->user_model->generalInfo($user_id);
            if(!empty($user)){
                if($user['avatar']){
                    $user['avatar_url'] = $CI->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user['use_id'] . '/' .  $user['avatar'];
                }
                $user['profile_url'] = !empty($user['website']) ? 'http://' .$user['website'] . '/' : azibai_url() . '/profile/' . $user['use_id'] . '/';
                $shops = $CI->shop_model->get_shop_by_user($user_id, $user['use_group']);

                if(!empty($shops)){
                    $shop = reset($shops);
                    unset($shops);
                    if ($shop['sho_logo'] != "") {
                        $shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop['sho_dir_logo'] . '/' . $shop['sho_logo'];
                    } else {
                        $shop_logo = site_url('templates/home/images/no-logo.jpg');
                    }
                    $shop['distin'] = [];
                    if($shop['sho_district']){
                        $shop['distin'] = $CI->district_model->find_where(['DistrictCode' => $shop['sho_district']], [
                            'select' => 'DistrictName, ProvinceName'
                        ]);
                    }
                    //if co domain rieng va server host != thì set lại shop link
                    $shop['shop_url'] = shop_url($shop) . '/';
                    $shop['logo']    = $shop_logo;
                    $user['my_shop'] = $shop;
                    unset($shop);
                }
            }
        }

        if($CI->session->userdata('sessionUser')){
            MY_Loader::$static_data['hook_user'] = $user;
        }
        return $user;
	}

	public function get_InfoShop($sho_user, $select = '*')
	{
		$this->load->model('shop_model');
		$getShop = $this->shop_model->get($select, "sho_status = 1 and sho_user = " . (int)$sho_user);
		return $getShop;
	}

	public function checkAandD($affiliate_level, $user_id){
        $data['type'] = 0;
        // if($this->session->userdata('sessionUser'))
        // {
        	$this->load->model('affiliate_relationship_model');
            
            $affDN_share = $this->affiliate_relationship_model->get('*', 'user_id = '.(int)$user_id.'  and public = 1');
            if($affiliate_level > 0)
            {
                if(!empty($affDN_share))
                {
                    $data['type'] = 1;
                }else{
                    $data['type'] = 3;
                }
            }else{
                //ctv GH
                if(!empty($affDN_share))
                {
                    $data['type'] = 2;
                }
                //thuong
            }
        // }
        $data['relationship'] = $affDN_share[0];
        return $data;
    }

    public function checkTreeAff($user_id, $parent_id){
    	$this->load->model('affiliate_relationship_model');
        $check = false;
        $affofOwn = $this->affiliate_relationship_model->get('*', 'user_id = '.(int)$user_id.'  and public = 1 and accept = 1 and (parent_id = '.(int)$parent_id.' or user_parent_id = '.(int)$parent_id.')');
        if(!empty($affofOwn))
        {
            $check = true;
        }
        return $check;
    }

    //Lay gia goc hoa gia KM neu co
    public function getPrice($isAff = false, $product, $quycach = null){
        
        if(isset($product))
    	{
    	
	        $saleoff = $price_c = 0;

	        if( $quycach != null)
	        {
	        	$price = (int)$quycach;
	        }
	        else
	        {
	        	$price = $product['pro_cost'];
	        }

	        if(!isset($product['pro_saleoff']) || !isset($product['begin_date_sale']) || !isset($product['end_date_sale']) || !isset($product['pro_type_saleoff']) || !isset($product['pro_saleoff_value']))
	    	{
	    		return 'Bạn chưa truyền đủ các trường: pro_saleoff, begin_date_sale, end_date_sale, pro_type_saleoff, pro_saleoff_value'; die();
	    	}

	        if ($product['pro_saleoff']) 
	        {
	            $curDate = time();
	            $beginSaleDate = $product['begin_date_sale'];
	            $endSaleDate = $product['end_date_sale'];
	            if ($beginSaleDate <= $curDate && $endSaleDate >= $curDate) 
	            {
	                if ($product['pro_type_saleoff'] == 1) 
	                {
	                    $saleoff = $price * $product['pro_saleoff_value'] / 100;
	                }
	                else 
	                {
	                    $saleoff = $product['pro_saleoff_value'];
	                }
	            }       
	        }
	        $data['price'] = $price; //gia goc
	        $data['saleoff'] = $saleoff; //so tien giam gia
	        $priceSaleOff = $data['price'] - $saleoff; //giá khuyến mãi

	        if($isAff == true)
	        {
	        	if(!isset($product['af_dc_amt']) || !isset($product['af_dc_rate']))
	        	{
	        		return 'af_dc_rate hoặc af_dc_amt không tồn tại'; die();
	        	}
	           if($product['af_dc_rate'] > 0)
	            {
	                $price_c = $priceSaleOff * ( 1 - $product['af_dc_rate']/100);
	            }
	            else
	            {
	                $price_c = $priceSaleOff - $product['af_dc_amt'];
	            }
	        }
	        $data['price_aff'] = $price_c; //giá tiền đã trừ ưu đãi hệ thống bán hộ
	        $data['priceSaleOff'] = $priceSaleOff;
	        $data['pro_saleoff_value'] = $priceSaleOff;

	        return $data;
	    }
    }

    public function gethoahong($where, $service, $type, $quycach = null, $giamsi = null){
        $this->load->model('affiliate_price_model');
        if($where != '')
        {
            $where .= ' and';
        }
        $hoahongaff = 0;
        $hhShare = $this->affiliate_price_model->get('*', $where.' service_id = ' . (int)$service['service_id'] . ' and type = ' . (int)$type)[0];
        if( $giamsi != null)
        {
        	$price_c = (int)$giamsi;
        }
        else{
        	$price_c = $this->getPrice(true, $service, $quycach)['price_aff'];
        }
        
        if($hhShare->discount_type == 1)
        {
            $hoahongaff = $price_c * $hhShare->discount_value/100;
        }else{
            $hoahongaff = $hhShare->discount_value;
        }

        return $hoahongaff;
    }

    //Du lieu truyen vao checkHH
    public function dataGetHH($product, $af_id = null){
    	$product = json_decode(json_encode($product), true);

        $user_login = $this->session->userdata('sessionUser');
        $afflevel_login = $this->session->userdata('sessioniAFLevel');
        $typeUserLogin = $this->checkAandD($afflevel_login, $user_login);
        if( $afflevel_login == 0)
        {
        	$afflevel_login = $typeUserLogin['relationship']->affiliate_level;
        }

        $data = array(
            'afflevel_login' => $afflevel_login,
            'user_login' => $user_login,
            'product' => $product,
            'whereLogin' => 'id_level = '.$afflevel_login,
            'typeUserLogin' => $typeUserLogin,
            'af_id' => $af_id
        );

        
        if ($af_id == null) {
        	if( isset($_REQUEST['af_id'])){
        		$af_id = $_REQUEST['af_id'];
        	}
        }

        if ($af_id == null && $this->session->userdata('sessionUser')) {
        	// $af_id = $this->session->userdata('sessionAfKey');
        }

        if ($af_id != null) {
    		$this->load->model('user_model');
            $whereS = 'af_key = "'.$af_id.'" and use_status = 1';
	        $getuser_share = $this->user_model->get('use_id, affiliate_level', $whereS);

	        $user_share = $getuser_share->use_id;
	        $afflevelShare = $getuser_share->affiliate_level;
        
        	$typeUserShare = $this->checkAandD($afflevelShare, $user_share);
	        $data['typeUserShare'] = $typeUserShare;
	        if( $afflevelShare == 0)
	        {
	        	$afflevelShare = $typeUserShare['relationship']->affiliate_level;
	        }
	        $data['whereShare'] = 'id_level = '.$afflevelShare;

	        $data['afflevelShare'] = $afflevelShare;

        	//DN share sp D1
        	$checkTree = $this->checkTreeAff($user_share, $product['pro_user']);
	        $data['checkTree'] = $checkTree;
        }

        return $data;
    }

    //Hàm check cac truong hop hien thi, lay hoa hong tren sp cua ctv Azi và ctv DN
    public function checkHH($arr, $quycach = null, $giamsi = null){
    	$product = json_decode(json_encode($arr['product']), true);
    	// $product = json_decode($arr['product'], true);
        $apply = $product['apply'];

        $whereLogin = $arr['whereLogin'];
        $checkTree = $arr['checkTree'];
        $typeUserLogin = $arr['typeUserLogin']['type']; //0: không, 1: D&A, 2: A, 3: D

        if(isset($arr['typeUserShare'])){
        	$typeUserShare = $arr['typeUserShare']['type'];
        	$whereShare = $arr['whereShare'];
        }
        else{
        	$typeUserShare = 0;
        }

        $showIcon = false;
        $hoahongaff = 0;
        $typeIcon = 0; //1: dky, 2: tham gia, 3: hoa hong
        
        $getHHShare = 0;
        $getHHLogin = 0;
        $getGiaCTV = 0;

        if(!isset($apply) || !isset($product['is_product_affiliate']))
        {
        	return 'Apply hoặc is_product_affiliate không tồn tại trong dữ liệu đã truyền';
        	die();
        }

        if($product['is_product_affiliate'] == 1 && $apply > 0)
        {
	        $product['service_id'] = $product['pro_id'];
	        switch ($typeUserLogin) {
	            case 2:
	                $typeIcon = 3;
	                switch ($typeUserShare) {
	                    case 1:
	                    case 3:
	                    	if ($apply == 1 || $apply == 2) {
	                        	$showIcon = true;
	                        	$getHHLogin = 1;
	                        }
	                        $getGiaCTV = 1;
	                        break;
	                    case 2:
	                    	if ($apply == 1) {
	                        	$showIcon = true;
	                        	$getHHLogin = 1;
                            	$getGiaCTV = 1;
	                        }

	                        if($apply == 2){
	                        	if($checkTree == true){
	                        		$showIcon = true;
		                        	$getHHLogin = 1;
	                            	$getGiaCTV = 1;
	                        	}else{
	                        		$showIcon = true;
	                        		$typeIcon = 2;
	                        	}
	                        }
	                        break;
	                }
	                break;
	                
	            case 3:
	                $showIcon = true;

	                switch ($typeUserShare) {
	                    case 1:
	                    case 2:
	            		 	$typeIcon = 3;

	                        if($apply == 2){
	                        	if($checkTree == true){
	                        		$showIcon = true;
		                        	$getHHShare = 1;
	                            	$getGiaCTV = 1;
	                        	}else{
	                        		$showIcon = true;
	                        		$typeIcon = 2;
	                        	}
	                        }else{
	            		 		$getGiaCTV = 1;
	                        	$getHHLogin = 1;
	                        }
	                        break;
	                    default:
	            		 	$typeIcon = 2;
	                    	if ($apply == 1 || $apply == 3) {
	                        	$getGiaCTV = 1;
	                        	$getHHLogin = 1;
	                        	$typeIcon = 3;
	                        }
	                    	break;
	                }

	                break;

	            case 1:
	            	$typeIcon = 3;
	            	$getGiaCTV = 1;
	            	$getHHLogin = 1;
	            	$showIcon = true;
	                break;
	                
	            default:
	                if($this->session->userdata('sessionUser'))
	                {
	                	$typeIcon = 2;
	                }
	                else{
	                	$typeIcon = 1;
	                }
	                switch ($typeUserShare) {
	                	case 2:
	                		if($apply == 2 || $apply == 1 )
	                        {
	                            $showIcon = true;
				                $getGiaCTV = 1;
	                        }
	                		break;
	                	case 3:
	                        if($apply == 2 || $apply == 1 )
	                        {
	                			$showIcon = true;
	                        }
	                        if($apply == 1 || $apply == 3 )
	                        {
	                			$getGiaCTV = 1;
	                        }
	                		break;
	                	case 1:
                        	$getGiaCTV = 1;
	                        if($apply == 2 || $apply == 1)
	                        {
	                			$showIcon = true;
	                        }
	                		break;
	                	default:
	                		if($apply == 2 || $apply == 1)
	                        {
	                			$showIcon = true;
	                        }
	                		break;
	                }
	            	break;
	        }
	    }

        if($getGiaCTV == 1)
        {
        	$price = $this->getPrice(true, $product, $quycach);
        }else{
        	$price = $this->getPrice(false, $product, $quycach);
        }

        $data = $price;

        if($getHHShare == 1)
        {
        	$hoahongaff = $this->gethoahong($whereShare, $product, 2, $quycach, $giamsi);
        	$data['hoahongShare'] = $hoahongaff;
        }
        elseif($getHHLogin == 1)
        {
        	$hoahongaff = $this->gethoahong($whereLogin, $product, 2, $quycach, $giamsi);
        	$data['hoahongLogin'] = $hoahongaff;
        }

        $registerAff = '';
        if($typeIcon == 1)
        {
	        if($checkTree == false || $typeUserShare == 0)
	        {
	        	$registerAff = azibai_url().'/register/verifycode?reg_pa='.$product['pro_user'].'&type_affiliate=2&parent_id='.$product['pro_user'];
	        }else{
	        	if($typeUserShare > 0 && $checkTree == true)
	        	{
	        		$registerAff = azibai_url().'/register/verifycode?reg_pa='.$arr['typeUserShare']['relationship']->user_id.'&type_affiliate=2&parent_id='.$product['pro_user'];
	        	}
	        }
        }
        
        $data['typeIcon'] = $typeIcon;
        $data['showIcon'] = $showIcon;
        $data['typeUserLogin'] = $typeUserLogin;
        $data['typeUserShare'] = $typeUserShare;
        $data['registerAff'] = $registerAff;
        $data['getGiaCTV'] = $getGiaCTV;
        $data['apply'] = $apply;
        $data['af_id'] = $arr['af_id'];

    	return $data;
    }

    public function checkPackageAff($iUserId, $package_id, $select = '*', $where = null)
    {
    	if(!empty($package_id))
    	{
	    	$this->load->model('package_user_model');
	    	if($where != null)
	    	{
	    		$where .= ' AND ';
	    	}
	    	$packAff = $this->package_user_model->get($select, "payment_status = 1 AND user_id = " . (int)$iUserId . " AND package_id IN(".$package_id.")".$where);
	    	return $packAff;
    	}
    }
}