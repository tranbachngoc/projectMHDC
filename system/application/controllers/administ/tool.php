<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Tool extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		#BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
		{
			redirect(base_url().'administ', 'location');
			die();
		}
		#END CHECK LOGIN
		#Load language
		$this->lang->load('admin/common');
		$this->lang->load('admin/tool');
	}
	function unlocked(){
		$query	=	"SELECT * FROM tbtt_session WHERE user_data like '%\"sessionValidLogin\";s:1:\"5\"%'";
		$tempresult=$this->db->query($query); 
		$result=$tempresult->result();
		$data['unlockeds']=$result;
		#Load view
		$this->load->view('admin/tool/unlocked', $data);
	
	}
	
	function unlocked_delete($session_id){
		if($this->db->delete('tbtt_session', array('session_id' => $session_id))){			
			redirect(base_url().'administ/tool/unlocked', 'location');
			die();
		}else{
			redirect(base_url().'administ/tool/unlocked', 'location');
			die();
		}
	}
	
	function unlocked_search($ip){
		$query	=	"SELECT * FROM tbtt_session WHERE ip_address like '%".$ip."%'";
		$tempresult=$this->db->query($query); 
		$result=$tempresult->result();
		$data['unlockeds']=$result;
		#Load view
		$this->load->view('admin/tool/unlocked', $data);
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
	
	function mail()
	{

		if($this->session->flashdata('sessionSuccessSend'))
		{
			$data['successSend'] = true;
		}
		else
		{
            $data['successSend'] = false;
			$this->load->model('user_model');
			$where="";
			if($this->uri->segment(4)!="")
			{
				$where="use_group=".$this->uri->segment(4);
			}
	        $data['email'] = $this->user_model->fetch("use_email", $where, "use_email", "ASC");
	        $this->load->library('form_validation');
	        #BEGIN: Set rules
	        $this->form_validation->set_rules('to_mail', 'lang:to_mail_label_mail', 'trim|required|valid_emails');
	        $this->form_validation->set_rules('from_mail', 'lang:from_mail_label_mail', 'trim|required|valid_email');
	        $this->form_validation->set_rules('subject_mail', 'lang:subject_mail_label_mail', 'trim|required');
	        $this->form_validation->set_rules('txtContent', 'lang:txtcontent_label_mail', 'trim|required');
	        #END Set rules
			#BEGIN: Set message
			$this->form_validation->set_message('required', $this->lang->line('required_message'));
			$this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
			$this->form_validation->set_message('valid_emails', $this->lang->line('valid_email_message'));
			$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
			#END Set message
			if($this->form_validation->run() != FALSE)
			{
				$this->load->library('bbcode');
				#BEGIN: Mail
                $this->load->library('email');
                $config['useragent'] = $this->lang->line('useragen_mail');
                $config['mailtype'] = 'html';
				$this->email->initialize($config);
				$this->email->from($this->input->post('from_mail'));
				$this->email->to(trim($this->input->post('to_mail'), ','));
				$this->email->subject($this->input->post('subject_mail'));
				$this->email->message($this->bbcode->light($this->input->post('txtContent')));
				#END Mail
				$folder=folderWeb;		
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.phpmailer.php'); 
				require_once($_SERVER['DOCUMENT_ROOT'].$folder.'/PHPMailer/class.pop3.php');								
				$arrayEmail=explode(",",$this->input->post('to_mail'));
				foreach($arrayEmail as $email){		
					$return_email=$this->smtpmailer($email, $this->input->post('from_mail'), "Azibai.com", $this->input->post('subject_mail'), $this->bbcode->light($this->input->post('txtContent')));
					if($return_email)
					{
						$this->session->set_flashdata('sessionSuccessSend', 1);
					}
				}
				
				
				/*if($this->email->send())
				{
                    $this->session->set_flashdata('sessionSuccessSend', 1);
				}*/
				redirect(base_url().'administ/tool/mail', 'location');
			}
			else
			{
                $data['to_mail'] = $this->input->post('to_mail');
                if($this->input->post('from_mail'))
                {
                	$data['from_mail'] = $this->input->post('from_mail');
                }
                else
                {
                    $data['from_mail'] = settingEmail_1;
                }
                $data['subject_mail'] = $this->input->post('subject_mail');
                $data['txtContent'] = $this->input->post('txtContent');
			}
		}
		$data['nhomguimail']= $this->userGroupDropDownListEmail();
		#Load view
		$this->load->view('admin/tool/mail', $data);
	}
	
	function cache()
	{
		$this->load->helper('file');
		if(is_dir('system/cache/'))
		{
			@delete_files('system/cache/', true);
   			@write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
		}
		redirect(base_url().'administ');
	}
	function userGroupDropDownListEmail()
	{
		$this->load->model('group_model');
		$retArray = '';
		
	   	$category  = $this->group_model->fetch("gro_id,gro_name", "", "gro_id", "ASC"); 
	   
	   if( count($category)>0){
		    $retArray .= " <select name='select' id='CategoryView' style='height:25px; width:150px;'>";
			    $retArray .="<option value='tatca' onclick='ActionSort(\"".base_url()."administ/tool/mail\")' >--Tất cả --</option>";
		   foreach ($category as $key=>$row)
		   {
			   if($this->uri->segment(4)==$row->gro_id)
			   {
			    
			    $retArray .="<option value='".$row->gro_id."'  onclick='ActionSort(\"".base_url()."administ/tool/mail/".$row->gro_id."\")'  selected='selected'  >".$row->gro_name."</option>";
			   }
			   else
			   {
				     $retArray .="<option value='".$row->gro_id."'  onclick='ActionSort(\"".base_url()."administ/tool/mail/".$row->gro_id."\")'  >".$row->gro_name."</option>";
			   }
			
		   }
		     $retArray .= "</select>";
	   }
	   return $retArray;
	   
	}
	function captcha()
	{
		// Load library
		$this->load->library('ftp');
		$this->load->helper('file');

		// Create FTP
        $config['hostname'] = IP_CLOUDSERVER;
        $config['username'] = USER_CLOUDSERVER;
        $config['password'] = PASS_CLOUDSERVER;
        $config['port']     = PORT_CLOUDSERVER;                
        $config['debug']    = FALSE;
        $this->ftp->connect($config);

        $path = '/public_html/captcha/';

        $aListCaptcha = $this->ftp->list_files($path);

        if(!empty($aListCaptcha)){
            foreach ($aListCaptcha as $sCaptcha) {
                $this->ftp->delete_file($path.'/'.$sCaptcha);
            }
        }

        
		if(is_dir('templates/captcha/'))
		{
			@delete_files('templates/captcha/', true);
   			@write_file('templates/captcha/index.html', '<p>Directory access is forbidden.</p>');
		}
		redirect(base_url().'administ');
	}
	function mediamanage()
	{
		$folder=folderWeb;
		$dir = $_SERVER['DOCUMENT_ROOT'].$folder."/images/";
		if($this->input->post('isupload'))
		{
			#BEGIN: Upload image
			$this->load->library('upload');
		    $pathImage = $dir;
			$config['upload_path'] = $pathImage;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= 10240;#KB
			$config['max_width']  = 2048;#px
			$config['max_height']  = 2048;#px
			$config['encrypt_name'] = false;
			$this->upload->initialize($config);
			if($this->upload->do_upload('upload_file'))
    		{
				$uploadData = $this->upload->data();
				unset($uploadData);
			}
		}
		if ($opendir = opendir($dir))
		{
			$images=array();
			while (($file = readdir($opendir)) !==FALSE)
			{
				if($file != "." && $file != "..")
				{
					$pathinfo = pathinfo($file); 
					if (isset($pathinfo['extension'])) {$ext = strtolower($pathinfo['extension']);} else {$ext = '';} 
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$images["$file"]=$file;
					}	
				}
			}
		} 
		$data['images'] = $images;
		#Load view
		$this->load->view('admin/tool/media', $data);
	}

	function delete_image_upload()
    {
        $name = $this->input->post('image_name');
        $folder=folderWeb;
        if($name != ''){
        	$image_path= $_SERVER['DOCUMENT_ROOT'].$folder."/images/".$name;
        	@unlink($image_path);
        	echo "1";
        	exit();
        }else{
			echo "0";
        }
         
        /*$dk_xoa = $this->input->post('dk_xoa');
        $field_dk_xoa = $this->input->post('field_dk_xoa');
        $tem_field_img = $this->input->post('tem_field_img');
        $table_update = $this->input->post('table_update');
        $duong_dan = $this->input->post('duong_dan');
        $ten_duong_dan = $this->input->post('ten_duong_dan');
        $ten_hinh = $this->input->post('ten_hinh');
        $this->load->model('user_model');
        $where = $field_dk_xoa . " = " . $dk_xoa;
        $this->db->cache_delete_all();
        if (!file_exists('system/cache/index.html')) {
            $this->load->helper('file');
            @write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
        }
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($table_update = "tbtt_shop") {
            if ($tem_field_img == "sho_bgimg") {
                $duong_dan_url = "shop/bgs";
            }
            if ($tem_field_img == "sho_banner") {
                $duong_dan_url = "shop/banners";
            }
            if ($tem_field_img == "sho_logo") {
                $duong_dan_url = "shop/logos";
            }
        }
        $this->db->update($table_update, array($tem_field_img => ''));
        if (file_exists('media/' . $duong_dan_url . '/' . $ten_duong_dan . '/' . $ten_hinh) && $ten_hinh != 'defaults.png') {
            @unlink('media/' . $duong_dan_url . '/' . $ten_duong_dan . '/' . $ten_hinh);
        }*/
    }
	
}