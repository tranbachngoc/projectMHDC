<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Forgot extends MY_Controller
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
		#BEGIN: CHECK LOGIN
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
			redirect(base_url(), 'location');
			die();
		}
		#END CHECK LOGIN
		#Load library
		$this->load->library('hash');
		#Load language
		$this->lang->load('home/common');
		$this->lang->load('home/forgot');
		#Load model
		$this->load->model('forgot_model');
		$this->load->model('user_model');
		
		
		$this->load->library('Mobile_Detect');
		$detect = new Mobile_Detect();
		$data['isMobile'] = 0;
		if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
		    $data['isMobile'] = 1;
		}
		$css = loadCss(array(
			'home/css/libraries.css',
			'home/css/style-azibai.css',
			'home/js/jAlert-master/jAlert-v3.css'
		),'asset/home/forgot.min.css');
		$data['css'] = '<style>'.$css.'</style>';
		
		$js = loadJs(array(
			'home/js/jquery-migrate-1.2.1.js',
			'home/js/bootstrap.min.js',
			'home/js/check_email.js',
			'home/js/jAlert-master/jAlert-v3.min.js',
			'home/js/jAlert-master/jAlert-functions.min.js',
			'home/js/general.js',
			'home/js/jquery.validate.js',
			'home/js/general_registry.js',
		),'asset/home/forgot.min.js');
		$data['js'] = '<script src="'.$js.'"></script>"';

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
	
	
	function index($clear = 0)
	{	
		if($clear > 0) {
			$this->session->unset_userdata('forgot');
			redirect(base_url(). 'forgot', 'location');
		}
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
        #BEGIN: Unlink captcha
        $this->load->helper('unlink');
        unlink_captcha($this->session->flashdata('sessionPathCaptchaForgot'));
		#END Unlink captcha		
		if ($this->session->flashdata('sessionSuccessForgot')) {
			$data['successForgot'] = true;
		} else {
			$this->load->library('form_validation');
			$data['successForgot'] = false;
			if($this->input->post('captcha_forgot') && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
			{
				
				#BEGIN: Set rules
				//$this->form_validation->set_rules('username_forgot', 'lang:username_forgot_label_defaults', 'trim|required|min_length[6]|max_length[35]');
				if($this->input->post('option') == 0){
					$this->form_validation->set_rules('email_forgot','trim|required|valid_email|callback__valid_forgot');
					$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
					$this->form_validation->set_message('_valid_forgot', 'Email của bạn chưa được đăng ký.');
				} else {
					$this->form_validation->set_rules('phone_num', 'lang:mobile_regis_label_defaults', 'trim|callback__is_phone');
					$this->form_validation->set_message('_is_phone', $this->lang->line('_is_phone_message'));					
				}
				$this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));

				#BEGIN: Set message
				// $this->form_validation->set_message('required', $this->lang->line('required_message'));
				// $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
				// $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
				//$this->form_validation->set_message('_valid_forgot', $this->lang->line('_valid_forgot_message_defaults'));
				//$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
				#END Set message
                if($this->form_validation->run() != FALSE && ($this->input->post('isPostValidCaptcha')==1)) {
					if($this->input->post('option') == 0){
						$salt = $this->hash->key(8);
						//  $newPassword = $this->hash->key(10);
						$key = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), microtime(), 'sha256md5');
						$dataForgot = array(
											'for_password'      =>      $this->hash->create($newPassword, $salt, 'md5sha512'),
											'for_salt'          =>      $salt,
											'for_email'         =>      trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))),
											'for_key'           =>      $key
											);
						$this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");

						if($this->forgot_model->add($dataForgot))
						{
							$this->load->model('user_model');
							$email =  trim(strtolower($this->filter->injection_html($this->input->post('email_forgot'))));
							$user = $this->user_model->get("use_id, use_email, use_username", "use_email = '" .$email. "'");
							if (count($user) > 0) {
								$user_name = $user->use_username;
							} else {
								$user_name = '';
							}
							
							$this->load->library('email');
							$config['useragent'] = $this->lang->line('useragen_defaults');
							$config['mailtype'] = 'html';
							$this->email->initialize($config);
							$keySend = base_url().'forgot/reset/key/'.$key.'/token/'.$this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), $key, "sha512md5");
							$messageContact = '
							<table  align="center" border="0" cellpadding="0" cellspacing="0" style="font-size: 105%" width="100%">
							<tr>
							<td>
							<img width="150" alt="" src="http://azibai.com/images/logo-azibai.png">
	</td>
	</tr>
							<tr><td align="center"><h2>YÊU CẦU LẤY LẠI MẬT KHẨU</h2></td></tr>
							<tr><td>
							Xin chào '.$user_name.', <br>
							<p>Bạn hoặc ai đó đã sử dụng địa chỉ email này để yêu cầu lấy lại mật khẩu đăng nhập trên <a href="azibai.com"> www.azibai.com</a><br/>
							Trường hợp bạn quên mật khẩu đăng nhập, Vui lòng <b><a href="'.$keySend.'">Click vào đây </a></b> để xác nhận mật khẩu mới.<br/>
							Hoặc copy đường dẫn bên dưới và dán vào trình duyệt web trên máy tính của bạn:<br/>
							<a href="'.$keySend.'">'.$keySend.'</a><br/>
							<p><b>Lưu ý : Link yêu cầu lấy lại mật khẩu chỉ có giá trị trong vòng 24h.</b></p>
							<p>Nếu bạn không phải là người đã gửi yêu cầu lấy lại mật khẩu, hãy bỏ qua email này và KHÔNG cần thao tác gì thêm.<br/> Tài khoản của bạn trên <a href="azibai.com"> www.azibai.com</a> vẫn đang an toàn.</p>
							<p>Trân trọng,</p>
							<p><a href="azibai.com"> www.azibai.com</a> – TECHNOLOGY 2B MODERN ART.<br/>
								CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI<br/>
								Địa chỉ: '.settingAddress_1.'<br/>
								Điện thoại: '.settingPhone.' – Email: <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a></p>

	</td></tr>
							
							</table>
							';

							// $this->lang->line('new_password_mail_defaults').$newPassword.'<br/><br/>'.$this->lang->line('content_mail_defaults').$keySend.'">Click vào đây</a>';
							$this->email->from($this->lang->line('EMAIL_MEMBER_TT24H'));
							$this->email->to(trim($this->input->post('email_forgot')));
							$this->email->subject($this->lang->line('title_mail_defaults'));
							$this->email->message($messageContact);
							
							$folder=folderWeb;
							require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.phpmailer.php');
							require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.pop3.php');
															
							$return_email=$this->smtpmailer(trim($this->input->post('email_forgot')), $this->lang->line('EMAIL_MEMBER_TT24H'), "azibai.com", "Lấy lại mật khẩu", $messageContact);        	
									
							if ($return_email) {							
								$this->session->set_flashdata('sessionSuccessForgot', 1);
							} else {
								$this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");
							}
						}
						$this->session->set_userdata('sessionTimePosted', time());
						redirect(base_url().trim(uri_string(), '/'), 'location');
					} elseif($this->input->post('option') == 1){
						if ($this->input->post('phone_num') && $this->input->post('phone_num') != '') {
							// Check number phone
							if (substr($this->input->post('phone_num'), 0, 1) == 0) 
			                {
			                    $phone_num = substr($this->input->post('phone_num'), 1);
			                } 
			                else 
			                {
			                    $phone_num = '0' . $this->input->post('phone_num');
			                }

			                $where_or = 'use_mobile = "' . $this->input->post('phone_num') . '"';
			                $where_or .= 'OR use_mobile = "' . $phone_num . '"';

			                $user = $this->user_model->get("use_id", $where_or);
							
							// $user2 = $this->user_model->get('use_id', 'use_phone = "'    . $this->input->post('phone_num') . '"');
							// if ( (($user && $user->use_id > 0) == false || ($user2 && $user2->use_id > 0) == false) ) {
							if ( ($user && $user->use_id > 0) == false ) {
								$this->session->set_flashdata('_sessionErrorForgot', 'Số điện thoại của bạn chưa được đăng ký.');
								redirect(base_url() . 'forgot', 'location');
								die;
							}
							// Init Curl to VHT API
							$this->load->model('authorized_code_model');
							$mobile = trim($this->filter->injection_html($this->input->post('phone_num')));
							$chars = '0123456789';
							$key = '';
							for ($i = 0; $i < 6; $i++) {
								$key = $key . substr($chars, rand(0, strlen($chars) - 1), 1);
							}
				
							$dataAdd = array(
								'code' => $key,
								'mobile' => $mobile,
								'during' => 600,
								'create_date' => date('Y-m-d H:i:s'),
								'active' => 0
							);
				
							if ($this->authorized_code_model->add($dataAdd)) {
								$keyVht = 'Mncvcskh';
								$secretVht = 'Mdhadjhdladvbmnsdha';
								$text = "Ma kich hoat cua so dien thoai " . $mobile . " la " . $key;
				
								$data = [
				                    'submission' => [
				                        'api_key' => 'Mncvcskh',
				                        'api_secret' => 'Mdhadjhdladvbmnsdha',
				                        'sms' => [
				                            [
				                                'id' => 0,
				                                'brandname' => 'azibai.com',
                                				'text' => 'Ma xac thuc tai khoan azibai.com cua ban ' . $key,
				                                'to' => $mobile,
				                            ],
				                        ],
				                    ],
				                ];
								$dataString = json_encode($data);
								$ch = curl_init('http://sms3.vht.com.vn/ccsms/Sms/SMSService.svc/ccsms/json');
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
								curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
								curl_setopt(
									$ch,
									CURLOPT_HTTPHEADER,
									array(
										'Content-Type: application/json',
										'Content-Length: ' . strlen($dataString)
									)
								);
								$respon = curl_exec($ch);
								$result = json_decode($respon);   
								// echo '<pre>';
								// print_r($result); die;
				
								if ((int)$result->response->submission->sms[0]->status === 0) {
									$this->session->set_userdata('phone_num', $mobile);
									$this->session->set_userdata('forgot', true);
									$this->session->set_flashdata('sessionSuccessForgot', 1);
									redirect(base_url().trim(uri_string(), '/'), 'location');
									die;
								} else {
									$msg = '';
									switch ((int)$result->response->submission->sms[0]->status) {
										case 7:
											$msg = 'Thuê bao quý khách từ chối nhận tin. Vui lòng cài đặt lại!';
											break;
										case 10:
											$msg = 'Không phải thuê bao di dộng. Vui lòng kiểm tra lại!';
											break;
										case 31:
											$msg = 'Đầu số sim của bạn hiện ngừng sử dụng. Vui lòng kiểm tra lại!';
											break;
										default:
											$msg = 'Hệ thống lỗi. Vui lòng thử lại!';
											break;
									}
									$this->session->set_flashdata('_sessionErrorForgot', $result->response->submission->sms[0]->status . ' - ' . $msg);
									$this->session->set_userdata('sessionTimePosted', time());
									redirect(base_url().trim(uri_string(), '/'), 'location');
									die;
								}
							}
						}
					}				
				}
				else
				{
					//$data['username_forgot'] = $this->input->post('username_forgot');
					$data['email_forgot'] = $this->input->post('email_forgot');
				}
			}
            #BEGIN: Create captcha
            $aCaptcha = $this->createCaptcha(md5(microtime()).'.'.rand(10, 10000).'fori.jpg');
            if(!empty($aCaptcha)) {
                $data['captcha']                = $aCaptcha['captcha']; 
                $data['imageCaptchaForgot']    = $aCaptcha['imageCaptchaContact'];

                $this->session->set_userdata('sessionCaptchaForgot', $data['captcha']);
                $this->session->set_userdata('sessionPathCaptchaForgot', $data['imageCaptchaContact']); 
            }

			#END Create captcha
		}
		
		#Load view
		$this->load->view('home/forgot/defaults', $data);
	}

	function forgotByPhone()
	{

		$this->load->library('form_validation');
		$this->form_validation->set_rules('password_regis', 'lang:password_regis_label_defaults', 'trim|required|min_length[6]|max_length[35]');
		$this->form_validation->set_rules('repassword_regis', 'lang:repassword_regis_label_defaults', 'trim|required|matches[password_regis]');
		
		$this->form_validation->set_message('required', $this->lang->line('required_message'));
		$this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
		$this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
		$this->form_validation->set_message('matches', $this->lang->line('matches_message'));
		
		if ($this->form_validation->run() != false) {
			$mobile_num = $this->session->userdata('phone_num');

			$vcode = trim(strtolower($this->filter->injection_html($this->input->post('verify_regis'))));
			$this->load->model('authorized_code_model');
			$autho = $this->authorized_code_model->get('*', 'code = "' . $vcode . '" AND active = 0 AND mobile = "' . $this->session->userdata('phone_num') . '"');

			if (count($autho) < 1) {
				$this->session->unset_userdata('phone_num');
				$this->session->unset_userdata('forgot');
				redirect(base_url() . 'forgot', 'location');
				die;
			} else if (count($autho) >= 1 && (strtotime($autho->create_date) + $autho->during <= strtotime(date('Y-m-d H:i:s')))) {
				$this->session->set_flashdata('_sessionErrorForgot', 'Mã kích hoạt đã hết thời hạn! Vui lòng gửi yêu cầu để nhận mã mới.');
				$this->session->unset_userdata('phone_num');
				$this->session->unset_userdata('forgot');
				redirect(base_url() . 'forgot', 'location');
				die;
			}

			/////////////////////////////////////////
			// $user1 = $this->user_model->get('*', 'use_mobile = "' . $mobile_num . '"');
			// $user2 = $this->user_model->get('*', 'use_phone = "'    . $mobile_num . '"');


			if (substr($mobile_num, 0, 1) == 0) 
            {
                $phone_num = substr($mobile_num, 1);
            } 
            else 
            {
                $phone_num = '0' . $mobile_num;
            }

            $where_or = 'use_mobile = "' . $mobile_num . '"';
            $where_or .= 'OR use_mobile = "' . $phone_num . '"';

            $user1 = $this->user_model->get("use_id, use_password, use_salt, use_username, use_group, use_status, use_enddate, use_fullname, use_email, avatar", $where_or);

			$salt = $this->hash->key(8);
			$new_pass = $this->hash->create($this->input->post('password_regis'), $salt, 'md5sha512');
			if (!empty($user1)) {

				$user1->use_salt = $salt;
				$user1->use_password = $new_pass;
				$this->user_model->update($user1,'use_id = ' . $user1->use_id);
				$this->session->set_flashdata('_sessionSuccessForgot', 'Đổi mật khẩu thành công.');
				$this->session->unset_userdata('phone_num');
				$this->session->unset_userdata('forgot');
				redirect(base_url() . 'login', 'location');
				// redirect(base_url() . 'forgot', 'location');
			} 
			// else 
			// {

			// 	$user2->use_salt = $salt;
			// 	$user2->use_password = $new_pass;
			// 	$this->user_model->update($user2,'use_id = ' . $user2->use_id);
			// 	$this->session->set_flashdata('_sessionSuccessForgot', 'Đổi mật khẩu thành công.');
			// 	$this->session->unset_userdata('phone_num');
			// 	$this->session->unset_userdata('forgot');
			// 	redirect(base_url() . 'login', 'location');
			// 	// redirect(base_url() . 'forgot', 'location');
			// }
		}

	}


	function forgotByEmail() {
		$result = ['error' => true];

		$this->load->model('user_model');
		$email =  trim(strtolower($this->filter->injection_html($this->input->post('email_forgot'))));
		$user = $this->user_model->get("use_id, use_email, use_username", "use_email = '" .$email. "'");

		if (count($user) > 0) {
			$salt = $this->hash->key(8);
			$key = $this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), microtime(), 'sha256md5');
			$dataForgot = array(
								'for_password'      =>      '',
								'for_salt'          =>      $salt,
								'for_email'         =>      $email,
								'for_key'           =>      $key
								);
			$this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");

			if($this->forgot_model->add($dataForgot))
			{
				$user_name = $user->use_username;
				
				$this->load->library('email');
				$config['useragent'] = $this->lang->line('useragen_defaults');
				$config['mailtype'] = 'html';
				$this->email->initialize($config);
				$keySend = base_url().'forgot/reset/key/'.$key.'/token/'.$this->hash->create(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), $key, "sha512md5");
				$messageContact = '
				<table  align="center" border="0" cellpadding="0" cellspacing="0" style="font-size: 105%" width="100%">
				<tr>
				<td>
				<img width="150" alt="" src="http://azibai.com/images/logo-azibai.png">
				</td>
				</tr>
				<tr><td align="center"><h2>YÊU CẦU LẤY LẠI MẬT KHẨU</h2></td></tr>
				<tr><td>
				Xin chào '.$user_name.', <br>
				<p>Bạn hoặc ai đó đã sử dụng địa chỉ email này để yêu cầu lấy lại mật khẩu đăng nhập trên <a href="azibai.com"> www.azibai.com</a><br/>
				Trường hợp bạn quên mật khẩu đăng nhập, Vui lòng <b><a href="'.$keySend.'">Click vào đây </a></b> để xác nhận mật khẩu mới.<br/>
				Hoặc copy đường dẫn bên dưới và dán vào trình duyệt web trên máy tính của bạn:<br/>
				<a href="'.$keySend.'">'.$keySend.'</a><br/>
				<p><b>Lưu ý : Link yêu cầu lấy lại mật khẩu chỉ có giá trị trong vòng 24h.</b></p>
				<p>Nếu bạn không phải là người đã gửi yêu cầu lấy lại mật khẩu, hãy bỏ qua email này và KHÔNG cần thao tác gì thêm.<br/> Tài khoản của bạn trên <a href="azibai.com"> www.azibai.com</a> vẫn đang an toàn.</p>
				<p>Trân trọng,</p>
				<p><a href="azibai.com"> www.azibai.com</a> – TECHNOLOGY 2B MODERN ART.<br/>
					CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI<br/>
					Địa chỉ: '.settingAddress_1.'<br/>
					Điện thoại: '.settingPhone.' – Email: <a href="mailto:+' . settingEmail_1 . '" style="color:#666;text-decoration:none" target="_blank"> ' . settingEmail_1 . '</a></p></td></tr>
				
				</table>
				';
				$this->email->from($this->lang->line('EMAIL_MEMBER_TT24H'));
				$this->email->to(trim($this->input->post('email_forgot')));
				$this->email->subject($this->lang->line('title_mail_defaults'));
				$this->email->message($messageContact);
				
				$folder=folderWeb;
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.phpmailer.php');
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.pop3.php');
												
				$return_email=$this->smtpmailer(trim($this->input->post('email_forgot')), $this->lang->line('EMAIL_MEMBER_TT24H'), "azibai.com", "Lấy lại mật khẩu", $messageContact);        	
				
				if ($return_email) {							
					$result = ['error' => false];
				} else {
					$this->forgot_model->delete(trim(strtolower($this->filter->injection_html($this->input->post('email_forgot')))), "for_email");
				}

			}
		}
		
		echo json_encode($result); 
		exit();
	}

	function exist_email()
	{
		$this->load->model('user_model');
		if (count($this->user_model->get("use_id, use_email", "use_email = '" . trim(strtolower($this->filter->injection_html($this->input->post('email')))) . "'")) > 0) {
			echo '1';
			exit();
		}
	}

	function reset($key, $token)
	{

        if($this->input->post('forgot_password')== null)
        {
            $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            #BEGIN: Advertise
            $data['advertisePage'] = 'forgot';
            $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
            #END Advertise
            #BEGIN: Counter
            $data['counter'] = $this->counter_model->get();
            #END Counter
            $user = $this->forgot_model->get("*", "for_key = '".$this->filter->injection($key)."'");
            if(count($user) == 1 && $token === $this->hash->create($user->for_email, $key, "sha512md5") && trim($key) != '' && trim($token) != '')
            {
                $userdata = $user->for_email;
                $this->session->set_userdata('userInfo', $userdata);
                $demo = $this->session->userdata('userInfo');
                $dataReset = array(
                    'use_password'      =>      $user->for_password,
                    'use_salt'          =>      $user->for_salt
                );
                if($this->user_model->update($dataReset, "use_email = '".$user->for_email."'"))
                {
                    $this->forgot_model->delete($user->for_email, "for_email");
                    $data['successResetPassword'] = true;
                }
                else
                {
                    $data['successResetPassword'] = false;
                }
                if($this->input->post('forgot_password') != null)
                {
                    $this->load->library('hash');
                    $this->load->model('user_model');
                    $salt = $this->hash->key(8);
                    $dataChange = array(
                        'use_password' => $this->hash->create($this->input->post('forgot_password'), $salt, 'md5sha512'),
                        'use_salt' => $salt
                    );
                    if ($this->user_model->update($dataChange, "use_email = " . (int)$this->session->userdata('sessionUser'))) {
                        $this->session->set_flashdata('sessionSuccessChangePasswordAccount', 1);
                    }
                    $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                }



            }
            else
            {
                $data['successResetPassword'] = false;
            }
        }
        else
        {

            if($this->input->post('forgot_password') != null)
            {
                if($this->input->post('forgot_password')!= $this->input->post('reforgot_password'))
                {   $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                }
                $this->load->library('hash');
                $this->load->model('user_model');
                $salt = $this->hash->key(8);
                $dataChange = array(
                    'use_password' => $this->hash->create($this->input->post('forgot_password'), $salt, 'md5sha512'),
                    'use_salt' => $salt
                );
                $demo = $this->session->userdata('userInfo');
                if ($this->user_model->update($dataChange, "use_email = " ."'$demo'")) {
                    $this->session->set_flashdata('sessionSuccessChangePasswordAccount', 1);
                }
                $data['pas'] = 'demo';
                $this->session->set_userdata('sessionTimePosted', time());
//                redirect(base_url() . trim(uri_string(), '/'), 'location');
            }
        }
		#Load view
		$this->load->view('home/forgot/reset', $data);
	}

	function _valid_forgot()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        if(count($this->user_model->get("use_id", "use_status = 1 AND (use_enddate >= $currentDate OR use_enddate=0)  AND use_email = '".trim(strtolower($this->filter->injection_html($this->input->post('email_forgot'))))."' AND use_username = '".trim(strtolower($this->filter->injection_html($this->input->post('username_forgot'))))."'")) == 1)
		{
			return true;
		}
		return false;
	}
	
	function _valid_captcha($str)
	{
        //if($this->session->flashdata('sessionCaptchaForgot') && $this->session->flashdata('sessionCaptchaForgot') === $str)
//		{
//			return true;
//		}
//		return false;
		return true;
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
	
	function loadCategoryRoot($parent, $level)
	{
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $categoryRoot  = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
	   return $categoryRoot;
	}

	function _is_phone($str)
    {
        if ($this->check->is_phone($str)) {
            return true;
        }
        return false;
	}
}