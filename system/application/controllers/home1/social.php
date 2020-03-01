<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Social extends MY_Controller
{
    function __construct() {
        parent::__construct();
        define( 'DS', DIRECTORY_SEPARATOR );
        $this->load->model('social_model');
    }

    function login() {       
        $socialData = array();
        $socialData['providerId'] = $this->input->post('social');
        $socialData['providerUserId'] = $this->input->post('id');
        $socialData['accessToken'] = $this->input->post('accessToken');        
        $avatar = $this->input->post('avatar');        

        // Update social login
        $this->social_model->updateLogin($socialData);        

        if($this->input->post('social') == 'facebook'){
            require_once(APPPATH.'libraries'.DS.'facebook'.DS.'facebook.php');
            $facebook = new Facebook(array(
                'appId' => FACEBOOK_ID,
                'secret' => FACEBOOK_SERECT,
                'cookie' => true
            ));
            // See if there is a user from a cookie
            $facebook->setAccessToken($this->input->post('accessToken'));
            $user = $facebook->getUser();           
            
            if ($user) {
                try {
                    $user_profile = $facebook->api('/me?fields=' . FACEBOOK_FIELD);
                    //print_r($user_profile);
                    foreach ($user_profile as $k => $val) {
                        $socialData[$k] = $val;
                    }
                    if ($socialData['email'] != '') {
                        $userInfo = $this->social_model->checkExistUser($socialData);
                        if (!empty($userInfo)) {
                            $this->social_model->login($userInfo);
                            echo json_encode(array('error'=>false, 'redirect'=>base_url().'account','user'=>$user));
                        } else {                            
                            // Tao nguoi dung moi
                            $newUser = array(
                                'use_username'      =>      $socialData['providerUserId'],
                                'use_password'      =>      '',
                                'use_salt'          =>      '',
                                'use_email'         =>      $socialData['email'],
                                'use_fullname'      =>      $socialData['name'],
                                'use_birthday'      =>      '',
                                'use_sex'           =>      '',
                                'use_address'       =>      '',
                                'use_province'      =>      '',
                                'use_phone'         =>      '',
                                'use_mobile'        =>      '',
                                'use_yahoo'         =>      '',
                                'use_skype'         =>      '',
                                'use_group'         =>      3,
                                'use_status'        =>      1,
                                'use_regisdate'     =>      time(),
                                'use_enddate'       =>      0,
                                'use_key'           =>      '',
                                'use_lastest_login' =>      time(),
                                'member_type'		=>      0,
                                'active_code' 		=>     	'',
                                'avatar'      		=>   	'',
                                'parent_id'       	=>   	0
                            );

                            $newUser['use_id'] = $this->social_model->createdUser($newUser);

                            // Lay avatar facebook
                            $pathUpload = "media/images/avatar";
                            $dirUpload = $newUser['use_id'];
                            if (!is_dir($pathUpload .'/'. $dirUpload)) {
                                @mkdir($pathUpload .'/'. $dirUpload, 0775, true);
                                $this->load->helper('file');
                                @write_file($pathUpload .'/'. $dirUpload .'/index.html', '<p>Directory access is forbidden.</p>');
                            }

                            $chars = '0123456789abcdefghijklmnopqrstuvxyw';
                            $nameImage = ''; 
                            for ($i = 0; $i < 32; $i++) {
                                $nameImage = $nameImage.substr($chars, rand(0, strlen($chars) - 1), 1);
                            } 

                            $content = file_get_contents($avatar);
                            $fp = fopen($pathUpload."/".$dirUpload."/".$nameImage.".jpg", "w+");
                            fwrite($fp, $content);
                            fclose($fp); 

                            $this->load->library('ftp');                
                            $configftp['hostname'] = IP_CLOUDSERVER;
                            $configftp['username'] = USER_CLOUDSERVER;
                            $configftp['password'] = PASS_CLOUDSERVER;
                            $configftp['port'] = PORT_CLOUDSERVER;
                            $configftp['debug'] = FALSE;
                            $this->ftp->connect($configftp);        
                            $pathTarget = 'public_html/media/images/avatar';
                            /* Upload this image to cloud server */
                            $source_path = $pathUpload .'/'. $dirUpload . '/' . $nameImage;
                            $target_path = $pathTarget . '/' . $nameImage;
                            $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                            /* Delete file amd folder upload */
                            if (file_exists($pathUpload . '/' . $dirUpload . '/index.html')) {
                                @unlink($pathUpload . '/' . $dirUpload . '/index.html');
                            }
                            array_map('unlink', glob($pathUpload .'/' . $dirUpload . '/*'));
                            @rmdir($pathUpload . '/' . $dirUpload);
                            /* Close connect ftp */
                            $this->ftp->close(); 
                            $this->user_model->update(array('avatar'=>$nameImage), 'use_id = '.$newUser['use_id']);
		
							$this->social_model->login($newUser);
							echo json_encode(array('error'=>false, 'redirect'=>base_url().'home/social/register_social_continue','user'=>$user));
                           
							//echo json_encode(array('error'=>true, 'message'=>'Khong tim thay nguoi dung'));
						}
                    }
                } catch (FacebookApiException $e) {
                    echo json_encode(array('error'=>true,'message'=>'Lỗi kết nối với facebook','user'=>$user));
                }
            }
        } elseif ($this->input->post('social') == 'google') {			
            require_once(APPPATH.'libraries'.DS.'google'.DS.'autoload.php');
            $gg = new Google_Client();
            $gg->setApplicationName("Azibai"); // Set Application name
            $gg->setClientId(GG_APP_ID); // Set Client ID
            $gg->setClientSecret(GG_APP_SERET); //Set client Secret
            $gg->setAccessType('online'); // Access method
            $gg->setScopes(GOOGLE_SCOPE);
            $gg->setRedirectUri(base_url().'login/google'); // Enter your file path (Redirect Uri) that you have set to get client ID in API console
			
			//$accessToken = '{"access_token":"'.$this->input->post('accessToken').'", "token_type":"Bearer", "expires_in":3600, "id_token":"'.$this->input->post('id_token').'"}';
			
			$gg->authenticate($this->input->post('code'), true);
			
			$accessToken = $gg->getAccessToken();
			print_r($accessToken);
            $gg->setAccessToken($accessToken);
			
            $service = new Google_Service_Oauth2($gg);
            $userNode = $service->userinfo->get();
			print_r($userNode);
			die('dfd');			

            $socialData['email'] = $this->input->post('email');

            if ($socialData['email'] != '') {
                $userInfo = $this->->checkExistUser($socialData);
                if (!empty($userInfo)) {
                    $this->social_model->login($userInfo);
                    echo json_encode(array('error'=>false, 'redirect'=>base_url().'account'));
                } else {
					// Tao nguoi dung moi
					$newUser = array(
						'use_username'      =>      $socialData['providerUserId'],
						'use_password'      =>      '',
						'use_salt'          =>      '',
						'use_email'         =>      $socialData['email'],
						'use_fullname'      =>      $this->input->post('name'),
						'use_birthday'      =>      '',
						'use_sex'           =>      '',
						'use_address'       =>      '',
						'use_province'      =>      '',
						'use_phone'         =>      '',
						'use_mobile'        =>      '',
						'use_yahoo'         =>      '',
						'use_skype'         =>      '',
						'use_group'         =>      3,
						'use_status'        =>      1,
						'use_regisdate'     =>      time(),
						'use_enddate'       =>      0,
						'use_key'           =>      '',
						'use_lastest_login' =>      time(),
						'member_type'		=>      0,
						'active_code' 		=>     	'',
						'avatar'      		=>   	'',
						'parent_id'       	=>   	0
					);

					$newUser['use_id'] = $this->social_model->createdUser($newUser);

					$this->social_model->login($newUser);
					echo json_encode(array('error'=>false, 'redirect'=>base_url().'account'));
				}
            }
        }
        exit();
    } 
}