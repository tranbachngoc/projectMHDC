<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Contact extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#CHECK SETTING
		if((int)settingStopSite == 1)
		{
                $this->lang->load('home/common');
			show_error($this->lang->line('stop_site_main'));
			die();
		}
		#END CHECK SETTING
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/contact');
                $this->load->model('notifications_model');
                $this->load->model('grouptrade_model');
		
		#BEGIN Eye
		if($this->session->userdata('sessionUser')>0){
			$this->load->model('eye_model');			
			$data['listeyeproduct']=$this->eye_model->geteyetype('product',$this->session->userdata('sessionUser'));		
			$data['listeyeraovat']=$this->eye_model->geteyetype('raovat',$this->session->userdata('sessionUser'));
			$data['listeyehoidap']=$this->eye_model->geteyetype('hoidap',$this->session->userdata('sessionUser'));
						
		}else{
			array_values($this->session->userdata['arrayEyeSanpham']);
			array_values($this->session->userdata['arrayEyeRaovat']);
			array_values($this->session->userdata['arrayEyeHoidap']);
			$this->load->model('eye_model');
			$data['listeyeproduct']=$this->eye_model->geteyetypenologin('product');			
			$data['listeyeraovat']=$this->eye_model->geteyetypenologin('raovat');
			$data['listeyehoidap']=$this->eye_model->geteyetypenologin('hoidap');
		}
		#END Eye
		#BEGIN: Ads & Notify Taskbar
		$this->load->model('ads_model');
		$this->load->model('notify_model');
		$this->load->model('category_model');
                $this->load->model('shop_model');
                $this->load->model('user_model');
		$data['menuType'] = 'product';

		//$retArray = $this->loadCategory(0,0);	
		//$data['menu'] = $retArray;
		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
		$data['adsTaskbarGlobal'] = $adsTaskbar;
		$notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
		$data['notifyTaskbarGlobal'] = $notifyTaskbar;
		$data['productCategoryRoot'] = $this->loadProductCategoryRoot(0,0);
		$data['productCategoryHot'] = $this->loadCategoryHot(0,0);
                
                
                
                if($this->session->userdata('sessionUser')){
                    $sessionUser = $this->session->userdata('sessionUser');
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
                
                $css = loadCss(array('home/css/libraries.css','home/css/style-azibai.css','home/js/jAlert-master/jAlert-v3.css'),'asset/home/contact.min.css');
		$data['css'] = '<style>'. $css .'</style>';
		$this->load->vars($data);
		#END Ads & Notify Taskbar
		
	}
	
	
	 
	function smtpmailer($to, $from, $from_name, $subject, $body)
	{
		
		$mail = new PHPMailer();  				// tạo một đối tượng mới từ class PHPMailer
		$mail->IsSMTP(); 	
		$mail->CharSet="utf-8";					// bật chức năng SMTP
		$mail->SMTPDebug = 0;  					// kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
		$mail->SMTPAuth = true;  				// bật chức năng đăng nhập vào SMTP này
		$mail->SMTPSecure = SMTPSERCURITY; 				// sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
		$mail->Host = SMTPHOST; 		// smtp của gmail
		$mail->Port = SMTPPORT; 						// port của smpt gmail
		$mail->Username = GUSER;  
		$mail->Password = GPWD;           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->isHTML(true);
		$mail->AddAddress($to);
		
		if(!$mail->Send())
		{
			$message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
			return false;
		} else {
			$message = 'Thư của bạn đã được gởi đi ';
			return true;
		}
		
	}
	
	function index()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		$data['advertisePage'] = 'contact';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
		$this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaContact'));
		#END Unlink captcha
		if($this->session->flashdata('sessionSuccessContact'))
		{
			$data['successContact'] = true;
		}
		else
		{
			$this->load->library('form_validation');
			$data['successContact'] = false;
			if($this->input->post('captcha_contact') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
			{
				#BEGIN: Set rules
				$this->form_validation->set_rules('name_contact', 'lang:name_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('email_contact', 'lang:email_contact_label_defaults', 'trim|required|valid_email');
				$this->form_validation->set_rules('address_contact', 'lang:address_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('phone_contact', 'lang:phone_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('title_contact', 'lang:title_contact_label_defaults', 'trim|required');
				$this->form_validation->set_rules('content_contact', 'lang:content_contact_label_defaults', 'trim|required|min_length[10]|max_length[1000]');
				// $this->form_validation->set_rules('captcha_contact', 'lang:captcha_contact_label_defaults', 'required|callback__valid_captcha');
				#END Set rules
				#BEGIN: Set message
				$this->form_validation->set_message('required', $this->lang->line('required_message'));
				$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
				$this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
				$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
				if($this->form_validation->run() != FALSE)
				{
					if ($this->input->post('position_contact') == '1') {
						$email =  Email_business;
						$position_contact = 'Kinh doanh';
					} else {
						$email =  Email_technical;
						$position_contact = 'Kỹ thuật';
					}
					$this->load->library('email');
					$config['useragent'] = $this->lang->line('useragen_defaults');
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$messageContact = $this->lang->line('title_contact_mail_defaults').$this->lang->line('fullname_contact_mail_defaults').$this->input->post('name_contact').'<br/>'.$this->lang->line('email_contact_mail_defaults').$this->input->post('email_contact').'<br/>'.$this->lang->line('address_contact_mail_defaults').$this->input->post('address_contact').'<br/>'.$this->lang->line('phone_contact_mail_defaults').$this->input->post('phone_contact').'<br/>'.$this->lang->line('position_contact_mail_defaults').$position_contact.'<br/>'.$this->lang->line('date_contact_mail_defaults').date('h\h:i, d-m-Y').'<br/>'.$this->lang->line('content_contact_mail_defaults').nl2br($this->filter->html($this->input->post('content_contact')));
					$this->email->from($this->input->post('email_contact'));
					// $this->email->to($this->lang->line('EMAIL_CONTACT_TT24H'));
					// $this->email->to($email);
					// $this->email->subject($this->input->post('title_contact'));
					// $this->email->message($messageContact);
					#Email
					$folder = folderWeb;		
					require_once($_SERVER['DOCUMENT_ROOT'] . $folder .'/PHPMailer/class.phpmailer.php'); 
					require_once($_SERVER['DOCUMENT_ROOT'] . $folder .'/PHPMailer/class.pop3.php');
					
					$return_email = $this->smtpmailer($email, $this->input->post('email_contact'), "azibai.com", $this->input->post('title_contact'), $messageContact );
					
					if($return_email) {
						$this->session->set_flashdata('sessionSuccessContact', 1);						
					}
					
					/*if($this->email->send())
					{
						$this->session->set_flashdata('sessionSuccessContact', 1);
					}*/
					$this->session->set_userdata('sessionTimePosted', time());
					redirect(base_url().trim(uri_string(), '/'), 'location');
				} else {
					$data['name_contact'] = $this->input->post('name_contact');
					$data['email_contact'] = $this->input->post('email_contact');
					$data['address_contact'] = $this->input->post('address_contact');
					$data['phone_contact'] = $this->input->post('phone_contact');
					$data['title_contact'] = $this->input->post('title_contact');
					$data['position_contact'] = $this->input->post('position_contact');
					$data['content_contact'] = $this->input->post('content_contact');
				}
			}
            #BEGIN: Create captcha
				$aCaptcha = $this->createCaptcha();
				if(!empty($aCaptcha)) {
					$data['captcha'] 				= $aCaptcha['captcha']; 
					$data['imageCaptchaContact'] 	= $aCaptcha['imageCaptchaContact'];

					$this->session->set_userdata('sessionCaptchaContact', $data['captcha']);
					$this->session->set_userdata('sessionPathCaptchaContact', $data['imageCaptchaContact']); 
				}

			#END Create captcha
		}
		#Load view
		$this->load->view('home/contact/defaults', $data);
	}
	
	function _valid_captcha($str)
	{
        if($this->session->flashdata('sessionCaptchaContact') && $this->session->flashdata('sessionCaptchaContact') === strtoupper($str))
		{
			return true;
		}
		return false;
	}
	
	function loadCategoryHot($parent, $level)
	{	   
	   $retArray = '';
	   
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent' and cat_hot = 1 ";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
	   
	   $retArray .= '<div class="row hotcat">';
	   foreach ($category as $key=>$row)
	   {
		   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
		   $images = '<img class="img-responsive" src="'.base_url().'templates/home/images/category/'.$row->cat_image.'"/><br/>';
		   $retArray .= '<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">'.$images.'<strong>'.$link.'</strong>';
		   $retArray .= $this->loadSupCategoryHot($row->cat_id, $level+1);
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
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
	   
	   $retArray .= '<ul class="supcat">';
	   foreach ($category as $key=>$row)
	   {
		   $link = '<a href="'.base_url().$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
		   $retArray .= '<li> - '.$link.'</li>';
		   
	   }
	   $retArray .= '</ul>';
	   return $retArray;
	}
	
	function loadProductCategoryRoot($parent, $level){
		$select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
		return  $category;
	}
}