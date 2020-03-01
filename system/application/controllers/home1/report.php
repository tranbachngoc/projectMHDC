<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->lang->load('home/common');
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $ssuser = (int)$this->session->userdata('sessionUser');
    }

    public function index(){
        $result['isLogin'] = 0;
        if($this->session->userdata('sessionUser'))
        {
            $result['isLogin'] = 1;
            $result['message'] = '';
            $pro_id = (int)$this->input->post("pro_id");
            $this->load->model('report_detail_model');
            $rpd = $this->report_detail_model->get('rpd_id', 'rpd_by_user = '. $this->session->userdata('sessionUser') .' AND rpd_media_id = '. (int)$this->input->post('id'). ' AND rpd_type = '.(int)$this->input->post("rpd_type"));
            $txt = '';

            switch ($this->input->post("rpd_type")) {
                case 1:
                    $txt = ' bài viết';
                    $getemailto = $this->user_model->fetch_join('use_email, use_fullname', 'LEFT', 'tbtt_content', 'use_id = not_user', 'not_id = '. (int)$this->input->post('id'));
                    $name_link = '<a href="'. $this->input->post("rpd_link") . '" target="_blank">'. $this->input->post("rpd_name") . '</a>';
                    break;
                case 3:
                    $txt = ' ảnh';
                    $where = 'tbtt_images.id = '. (int)$this->input->post('id');

                    if($this->input->post('media_id') > 0){
                        $getemailto = $this->user_model->fetch_join2('use_email, use_fullname', 'LEFT', 'tbtt_content', 'use_id = not_user', 'LEFT', 'tbtt_images', 'tbtt_images.not_id = tbtt_content.not_id', '', '', '', $where . ' AND tbtt_content.not_id = '. (int)$this->input->post('media_id'));
                    }else{
                        $getemailto = $this->user_model->fetch_join('use_email, use_fullname', 'LEFT', 'tbtt_images', 'tbtt_images.user_id = use_id', $where . ' AND use_id = user_id');
                    }

                    $name_link = '<br/><a href="'. $this->input->post("rpd_link") . '" target="_blank"><img src="'. $this->input->post("rpd_image") . '" alt="ảnh" width="300"></a>';
                    break;
                default:
                    # code...
                    break;
            }

            if(empty($rpd)) {
                $form_data = array(
                    "rpd_type" => $this->input->post("rpd_type"),
                    "rpd_media_id" => $this->input->post("id"),
                    "rpd_category_id" => $this->input->post("rp_id"),
                    "rpd_by_user" => $this->session->userdata('sessionUser'),
                    "rpd_reason" => $this->input->post("rpd_reason"),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "created_at" => date('Y-m-d H:i:s')
                );

                if($this->input->post("rp_id") == 'write'){
                    $form_data['rpd_category_id'] = 0;
                }else{
                    $form_data['rpd_category_id'] = $this->input->post("rp_id");
                }
                if ($this->report_detail_model->add($form_data)) {                                        
                    $getemailform = $this->user_model->get('use_email, use_fullname', 'use_id = '. $this->session->userdata('sessionUser'));
                    // $emailform = $getemailform->use_email;
                    $emailto = $getemailto[0]->use_email;
                    
                    $this->load->library('email');
                    $config['useragent'] = 'azibai.com';
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.phpmailer.php'); 
                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.pop3.php');

                    $from = GUSER;                                  
                    $from_name = 'AZIBAI.COM';
                    $subject = 'Báo cáo vi phạm';

                    $cntreports = 'Khác';
                    if($this->input->post("rp_id") != 'write'){
                        $this->load->model('reports_model');
                        $reports = $this->reports_model->get('rp_desc', 'rp_type = 1 AND rp_status = 1 AND rp_id = ' . $this->input->post("rp_id"));
                        $cntreports = $reports->rp_desc;
                    }

                    $note = $this->input->post("rpd_reason");

                    $body1 = '<p>Chào bạn!</p>'.$txt.' '.$name_link.' của bạn vừa bị báo cáo
                    <br/>Lý do: <strong>"'. $cntreports .'"</strong></p>';
                    if($note != ''){
                        $body1 .= '<br/>Ghi chú: '.$note;
                    }
                    $body1 .= '<br/>Vui lòng đăng nhập vào quản trị để xử lý báo cáo.
                    <p> Trân trọng!</p>
                    <br/>
                    <a href="'. base_url() . '" target="_blank">'. domain_site . '</a>
                    <br/>
                    CÔNG TY TRÁCH NHIỆM HỮU HẠN MỌI NGƯỜI CÙNG VUI';

                    $this->smtpmailer($emailto, $from, $from_name, $subject, $body1);

                    $body2 = '<p>Xin chào!</p>
                    Tài khoản <b>'.$getemailform->use_fullname.'</b> đã báo cáo'.$txt.' của <b>'.$getemailto[0]->use_fullname.'</b> '.$name_link.'
                    <br/>Lý do: <strong>"'. $cntreports .'"</strong></p>
                    <br/><strong>Ghi chú:</strong> '.$note.'
                    <br/>Vui lòng đăng nhập vào quản trị để xử lý báo cáo.
                    <p> Trân trọng!</p>
                    <br/>
                    <a href="'. base_url() . '" target="_blank">'. domain_site . '</a>
                    <br/>
                    CÔNG TY TRÁCH NHIỆM HỮU HẠN MỌI NGƯỜI CÙNG VUI';

                    $getemailfrom = $this->user_model->fetch('use_email', 'use_group = 16 AND use_status = 1');
                    if(!empty($getemailfrom)){
                        foreach ($getemailfrom as $key => $value) {
                            $this->smtpmailer($value->use_email, $from, $from_name, $subject, $body2);
                        }
                    }
                    $result['message'] = 'Gửi báo cáo'.$txt.' thành công';
                }
            }else{
                $result['message'] = 'Bạn đã từng báo cáo cho'.$txt.' này rồi';
            }
        }else{
            $result['message'] = 'Bạn vui lòng <a href="'.base_url().'/login" target="_blank"><b>Đăng nhập</b></a> để gửi báo cáo';
        }
        echo json_encode($result); exit();
    }

    public function report_pro(){
        $result['isLogin'] = 0;
        if($this->session->userdata('sessionUser'))
        {
            $result['isLogin'] = 1;
            $result['message'] = '';
            $pro_id = (int)$this->input->post("pro_id");
            $this->load->model('report_detail_model');
            $query = $this->report_detail_model->get("*","rpd_by_user = " . $this->session->userdata('sessionUser') . " AND rpd_media_id = ". $pro_id. ' AND rpd_type = 2');
            if(count($query) == 0) {
                $form_data = array(
                    "rpd_type" => $this->input->post("rpd_type"),
                    "rpd_media_id" => $pro_id,
                    "rpd_category_id" => $this->input->post("rp_id"),
                    "rpd_by_user" => $this->session->userdata('sessionUser'),
                    "rpd_reason" => $this->input->post("rpd_reason"),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "created_at" => date('Y-m-d H:i:s')
                );
                if($this->input->post("rp_id") == 'write'){
                    $form_data['rpd_category_id'] = 0;
                }else{
                    $form_data['rpd_category_id'] = $this->input->post("rp_id");
                }

                if ($this->report_detail_model->add($form_data))
                {
                    $getemailform = $this->user_model->get("use_email, use_fullname", "use_id = ".$this->session->userdata('sessionUser'));
                    
                    $getemailto = $this->user_model->fetch_join("use_email, use_fullname", "LEFT", "tbtt_product", "use_id = pro_user", "use_status = 1 AND pro_status = 1 AND pro_id = " . $pro_id);
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
                    
                    $cntreports = 'Khác';
                    if($this->input->post("rp_id") != 'write'){
                        $this->load->model('reports_model');
                        $reports = $this->reports_model->get('rp_desc', 'rp_type = 2 AND rp_status = 1 AND rp_id = ' . $this->input->post("rp_id"));
                        $cntreports = $reports->rp_desc;
                    }

                    $note = $this->input->post("rpd_reason");
                    $name_link = '<a href="'. $this->input->post("rpd_link") . '" target="_blank">'. $this->input->post("rpd_name") . '</a>';
                    $body1 = '<p>Chào bạn!</p>
                    Sản phẩm '.$name_link.' của bạn vừa bị báo cáo
                    <br/>Lý do: <strong>"'. $cntreports .'"</strong></p>';
                    if($note != ''){
                        $body1 .= '<br/>Ghi chú: '.$note;
                    }
                    $body1 .= '<br/>Vui lòng đăng nhập vào quản trị để xử lý báo cáo.
                    <p> Trân trọng!</p>
                    <br/>
                    <a href="'. base_url() . '" target="_blank">'. domain_site . '</a>
                    <br/>
                    CÔNG TY TRÁCH NHIỆM HỮU HẠN MỌI NGƯỜI CÙNG VUI';

                    $this->smtpmailer($emailto, $from, $from_name, $subject, $body1);

                    $body2 = '<p>Xin chào!</p>
                    Tài khoản <b>'.$getemailform->use_fullname.'</b> đã báo cáo sản phẩm '.$name_link.' của <b>'.$getemailto[0]->use_fullname.'</b>
                    <br/>Lý do: <strong>"'. $cntreports .'"</strong></p>
                    <br/><strong>Ghi chú:</strong> '.$note.'
                    <br/>Vui lòng đăng nhập vào quản trị để xử lý báo cáo.
                    <p> Trân trọng!</p>
                    <br/>
                    <a href="'. base_url() . '" target="_blank">'. domain_site . '</a>
                    <br/>
                    CÔNG TY TRÁCH NHIỆM HỮU HẠN MỌI NGƯỜI CÙNG VUI';
                    
                    $getemailfrom = $this->user_model->fetch('use_email', 'use_group = 16 AND use_status = 1');
                    if(!empty($getemailfrom)){
                        foreach ($getemailfrom as $key => $value) {
                            $this->smtpmailer($value->use_email, $from, $from_name, $subject, $body2);
                        }
                    }
                    $result['message'] = 'Gửi báo cáo sản phẩm thành công';
                }
            }else{
                $result['message'] = 'Bạn đã từng báo cáo cho sản phẩm này rồi';
            }
        }else{
            $result['message'] = 'Bạn vui lòng <a href="'.base_url().'/login" target="_blank"><b>Đăng nhập</b></a> để gửi báo cáo';
        }
        echo json_encode($result); exit();
    }
    
    public function smtpmailer($to, $from, $from_name, $subject, $body)
    {       
        $mail = new PHPMailer();                // tạo một đối tượng mới từ class PHPMailer
        $mail->IsSMTP();    
        $mail->CharSet="utf-8";                 // bật chức năng SMTP
        $mail->SMTPDebug = 0;                   // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
        $mail->SMTPAuth = true;                 // bật chức năng đăng nhập vào SMTP này
        $mail->SMTPSecure = SMTPSERCURITY;              // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
        $mail->Host = SMTPHOST;         // smtp của gmail
        $mail->Port = SMTPPORT;                         // port của smpt gmail
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
}