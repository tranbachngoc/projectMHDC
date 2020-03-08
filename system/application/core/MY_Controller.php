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

	public function uploadImg($imageFile, $folder, $typeAct = 'add', $nameImg = '')
    {
        $this->load->library('image_lib');
        $this->load->library('upload');
        $result = [];
        $error = true;
        $mess = '';
        // var_dump($imageFile); die;
        $pathImage = 'media/images/'.$folder;
        $path = '/public_html/media/images';
        if($typeAct == 'add')
        {
        	$dir_image = date('dmY');
        }
        else{
        	$dir_image = '';
        }
        

        $dir_folder = $pathImage.'/'.$dir_image.'/';
        if (!is_dir($dir_folder)) {
            @mkdir($dir_folder, 0775);
        }

        $sCustomerImageName = $nameImg.uniqid() . time() . uniqid();
        $type_image = pathinfo($imageFile['type'])['basename'];
        $uploadOk = 1;

        $pro_image = $sCustomerImageName.'.'.$type_image;

        $target_file = $dir_folder . $pro_image;


        // Check if image file is a actual image or fake image
        if($imageFile) {
            $check = getimagesize($imageFile["tmp_name"]);
            if($check !== false) {
                $mess = "File is an image - " . $check["mime"] . ".";
                $error = false;
            } else {
                $mess = "File is not an image.";
                // $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $mess = "Sorry, file already exists.";
            // $uploadOk = 0;
        }
        // Check file size
        if ($imageFile["size"] > 5000000) {
            $mess = "Sorry, your file is too large.";
            // $uploadOk = 0;
        }
        // Allow certain file formats
        if($type_image != "jpg" && $type_image != "png" && $type_image != "jpeg"
        && $type_image != "gif" ) {
            $mess = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $mess = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($imageFile["tmp_name"], $dir_folder . $pro_image)) {
                $error = false;
            } else {
                $mess = "Sorry, there was an error uploading your file.";
            }
        }

        if($error == false)
        {
        	$result['img_name'] = $pro_image;
        	$result['dir'] = $dir_image;
        }
        $result['error'] = $error;
        $result['mess'] = $mess;
        
        return $result;
    }

    public function get_provice()
    {

        $this->load->model('province_model');
        $province = $this->province_model->fetch();
        return $province;
    }

    public function get_district($province)
    {
        $this->load->model('district_model');
        $district = $this->district_model->find_by(array('ProvinceCode' => $province));
        return $district;
    }
}