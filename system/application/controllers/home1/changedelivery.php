<?php
#****************************************#
# * @Author: nguyenvanphuc                   #
# * @Email: nguyenvanphuc0626@gmail.com          #
# * @Website: http://www.phucdevelop.net  #
#****************************************#
class Changedelivery extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->model('shop_model'); 
        $this->load->model('order_model');       
        $this->load->model('delivery_model');
        $this->load->model('delivery_comments_model');

        if ($this->session->userdata('sessionUser') > 0) {
            # Check user actived
            $cur_user =  $this->user_model->get('use_id,use_username,avatar,af_key', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
                $data['af_id'] = $cur_user->af_key;
            } else {
                $parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
            }
        }
        $data['myshop'] = isset($myshop) ? $myshop : '';
        $data['currentuser'] = isset($cur_user) ? $cur_user : '';
        $this->load->vars($data);
        
                
        $this->load->library('RestApiClient');
        $this->RestApiClient = new RestApiClient();
    }
    
    public function index($order_id)
    {
        if(!isset($_REQUEST['order_token'])){
            redirect(base_url());
        }
   
        $data['status_comment']         =   FALSE;
        $data['order_info']             =   array();
        if($order_id){
            $getListOrders = $this->order_model->getListOrders(array('order_id' => $params, 'order_status_delivery' => 'TRUE', 'order_user' => $user_id), NULL, 'id, order_status, order_clientCode, order_saler, order_user');
            if(empty($getListOrders)){
                $this->session->set_flashdata('flash_message_error', 'Trạng thái đơn hàng không thể thao tác Hoặc đơn hàng này không phải của bạn.');
                redirect(base_url() .'change-delivery'.'?order_token='. $_REQUEST['order_token']);
            }

            $this->load->model('user_receive_model');
            $data['order_info'] = $this->user_receive_model->get('order_id, ord_semail', 'order_id = '. $order_id);
            
            if(empty($data['order_info'])){
                $this->session->set_flashdata('flash_message_error', 'Đơn hàng không tồn tại');
                redirect(base_url() .'change-delivery'.'?order_token='. $_REQUEST['order_token']);
            } else {
                $data['all_comments'] = $this->delivery_comments_model->getAllCommentByOrder(array('order_id' => $order_id), array('key' => 'tbl.id', 'value' => 'DESC'));
                
                if($data['all_comments'] && $data['all_comments'][0]->status_changedelivery){
                    $data['status_comment']        =   TRUE;
                    if($data['all_comments'][0]->status_comment == "2" && $data['all_comments'][0]->status_changedelivery == "02"){
                        $data['status_comment']        =   FALSE;
                    }
                    
                    $this->load->model('user_model');
                    $this->load->model('shop_model');
                    
                    foreach($data['all_comments'] as $key => $vals){
                        if(in_array($vals->status_changedelivery, array("01","03"))){
                            $thumb_user = 'thumbnail_d2ee8c3adc99e19e7a300355aaf9fab8.png';
                            if($vals->user_id > 0){
                                $user       = $this->user_model->get('use_fullname,avatar','use_id = '.$vals->user_id);
                                if($user->avatar){
                                    $thumb_user = $user->avatar;
                                }
                            } else {
                                $thumb_user = 'thumbnail_d2ee8c3adc99e19e7a300355aaf9fab8.png';
                            }
                            $data['_thumb'][$key] = array(
                                'name'              =>      $user->use_fullname, 
                                'logo'              =>      'media/images/avatar/'.$thumb_user,
                                'link'              =>      ""
                            );
                            
                            if($vals->bill){
                                $data['_thumb'][$key]['bill']       =   'media/images/mauvandon/'.$vals->bill;
                            }
                            
                        } else {
                            $shop = $this->shop_model->get('sho_logo,sho_dir_logo,sho_link,sho_name','sho_user = '.$vals->user_id);
                            $data['_thumb'][$key] = array(
                                'name'             =>      $shop->sho_name,
                                'logo'             =>      'media/shop/logos/'.$shop->sho_dir_logo.'/'.$shop->sho_logo,
                                'link'             =>      $shop->sho_link,
                                'bill'             =>      ""
                            );
                        }
                    }
                    
                    
                } else {
                    $this->session->set_flashdata('flash_message_success', "Vui lòng điền đẩy đủ thông tin bên dưới");
                    redirect(base_url().'change-delivery'.'?order_token='.$_REQUEST['order_token']);
                }
                $data['delivery'] = $this->delivery_model->get('*',array('order_id'=>$order_id));
            }
        } else {
            $data['status_comment']        =   TRUE;
            $this->load->model('user_receive_model');
            $data['order_id_token']        =    $this->order_model->get('id','order_token = "'. $_REQUEST['order_token'] .'"');

            if(empty($data['order_id_token'])){
                redirect(base_url());
            }

            $data['user_receive_token']    =    $this->user_receive_model->get('ord_semail','order_id = '. $data['order_id_token']->id);
        }
        
        if($this->session->userdata('sessionUser') > 0){
            $this->load->model('user_model');
            $data['user_info']      =   $this->user_model->get('use_email','use_id = '. $this->session->userdata('sessionUser'));
            $data['listComplaintsOrders']  =   $this->delivery_model->fetch('*', array('user_id' => $this->session->userdata('sessionUser')));
        }

        $this->load->view('home/changedelivery/default', $data);
    }

    public function submitDelivery($order_id = NULL)
    {
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            
            if($order_id){
                $params = $order_id;
            } else {
                $params = $this->input->post('order_id');
            }
            //chỉ cho phép đổi - trả hàng khi đon hàng status 02 hoac 03
            $user_id = 0;
            if ($this->session->userdata('sessionUser') > 0) {
                $user_id = $this->session->userdata('sessionUser');
            }

            $getListOrders = $this->order_model->getListOrders(array('order_id' => $params, 'order_status_delivery' => 'TRUE', 'order_user' => $user_id), NULL, 'id, order_status, order_clientCode, order_saler, order_user');
            
            if (empty($getListOrders)) {
                $this->session->set_flashdata('flash_message_error', "Trạng thái đơn hàng không thể thao tác Hoặc đơn hàng này không phải của bạn.");
                redirect(base_url() .'change-delivery'.'?order_token='. $_REQUEST['order_token']);
            }
            
            $all_comments = $this->delivery_comments_model->getAllCommentByOrder(array('order_id' => $params),array('key' => 'tbl.id','value' => 'DESC'));            
            
             //user ko dong ý
            if ($all_comments[0]->status_changedelivery == '02' && $this->input->post('status_comment') == '2'){
                $content = $all_comments[0]->content .'<br/><img src="'. base_url() .'images/reply_icon.png"/>'. $this->input->post('content');
                $this->delivery_comments_model->update(array('status_comment' => '1','content' => $content), 'id_request = '. $all_comments[0]->id_request .' AND status_changedelivery = "02"');
                $this->session->set_flashdata('flash_message_success', 'Thông tin bạn đã đc duyệt!');
                redirect(base_url() .'change-delivery/'. $params .'?order_token='. $_REQUEST['order_token']);
            } else if ($all_comments[0]->status_changedelivery == '02' && $this->input->post('status_comment') == '1') {                
                $this->delivery_model->delete(array('id' => $all_comments[0]->id_request));
                $this->delivery_comments_model->delete(array('id_request' => $all_comments[0]->id_request));
                
                $this->order_model->updateOrderCode($getListOrders[0]->order_clientCode, '03', $getListOrders[0]->order_saler, $params);
                $this->session->set_flashdata('flash_message_success', 'Cám ơn ý kiến đóng góp của bạn');
                redirect(base_url() .'change-delivery?order_token='. $_REQUEST['order_token']);
            }            
            
            if (empty($all_comments)) {
                    $status_id = "01";

                    $delivery = array(
                        'order_id'      =>  $params,
                        'type_id'       =>  $this->input->post('type_id'),
                        'user_id'       =>  $getListOrders[0]->order_user,
                        'shop_id'       =>  $getListOrders[0]->order_saler,
                        'status_id'     =>  $status_id,
                        'email'         =>  $this->input->post('email'),
                        'lastupdated'   =>  date("Y-m-d H:i:s",time())
                    );
                    $delivery_id        = $this->delivery_model->add($delivery);
                    $email              = $this->input->post('email');
            } else if ($all_comments) {
                if ($this->input->post('order_id')) {
                    $this->session->set_flashdata('flash_message_error', "Điền đầy đủ thông tin bên dưới");
                    redirect(base_url() .'change-delivery/'. $params .'?order_token='. $_REQUEST['order_token']);
                }
                
                if (in_array($all_comments[0]->status_changedelivery,array('01','03'))) {
                    $this->session->set_flashdata('flash_message_error', "Để tiếp tục comments - Vui lòng chờ Shop xác nhận.");
                    redirect(base_url() .'change-delivery/'. $params .'?order_token='. $_REQUEST['order_token']);
                }
                
                if ($_FILES['image_mavandon']['error'] == 0) {
                    $comments['bill']               =   $this->upload();
                    $status_id                      =   '03';
                    $update                         =   $this->delivery_model->update(array('status_id' => $status_id, 'bill' => $comments['bill'], 'lastupdated' => date("Y-m-d H:i:s", time())),'order_id = '. $params);
                    $delivery                       =   $this->delivery_model->get('id,email', 'order_id = '. $params);
                    $delivery_id                    =   $delivery->id;
                }
                
                $email                              =   $delivery->email;
                $_data['attachment']                =   DOMAIN_CLOUDSERVER .'media/images/mauvandon/'. $comments['bill'];
            }
            
            $comments['id_request']                 =       $delivery_id;
            $comments['status_changedelivery']      =       $status_id;
            $comments['user_id']                    =       $user_id;
            $comments['content']                    =       $this->input->post('content');
            $comments['status_comment']             =       $this->input->post('status_comment');
            $comments['lastupdated']                =       date("Y-m-d H:i:s",time());
            $comments_id = $this->delivery_comments_model->add($comments);
            
            if ($delivery_id && $comments_id) {
                $this->load->model('shop_model');
                $this->load->model('user_model');
                $_data['shop_info']  =   $this->shop_model->get('sho_name','sho_user = '. $getListOrders[0]->order_saler);
                $_data['user_info']  =   $this->user_model->get('use_email','use_id = '. $getListOrders[0]->order_saler);
                
                if($_data['user_info']->use_email) {
                    $_data['order_id']      =   $params;
                    $_data['content']       =   $this->input->post('content');
                    $_data['delivery_id']   =   $delivery_id;
                    $content_email          =   $this->load->view('home/changedelivery/email', $_data, true);
                    $this->sendEmail($_data['user_info']->use_email, $email, $content_email);//to from body
                }
                $this->order_model->updateOrderCode($getListOrders[0]->order_clientCode, "05", $getListOrders[0]->order_saler, $params);
                $this->session->set_flashdata('flash_message_success', "Thông tin của bạn đã gởi đến Shop");
                redirect(base_url() .'change-delivery/'. $params .'?order_token='. $_REQUEST['order_token']);
            }
        } else {
            $this->session->set_flashdata('flash_message_error', "Thao tác lỗi");
            redirect(base_url() .'change-delivery'.'?order_token='. $_REQUEST['order_token']);
        }
    }
    
    public function checkDelivery() {            
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $_order_id = $this->input->post('order_id');

            if( $this->input->post('left_order_id') != '' ) {
                $_order_id =  $this->input->post('left_order_id');
            }

            $orders = $this->order_model->getListOrders(array('order_id' => $_order_id, 'order_status_delivery' => TRUE), NULL, 'id, order_token');
            
            if($orders){
                $result = $this->delivery_comments_model->getAllCommentByOrder(array('order_id' => $_order_id), array('key' => 'tbl.id', 'value' => 'DESC'));
                
                if($result){
                    if(in_array($result[0]->status_changedelivery, array('01','03'))){
                        $this->session->set_flashdata('flash_message_error', "Để tiếp tục comments - Vui lòng chờ Shop xác nhận.");
                        die(json_encode(array('error' => 2, 'order_token' => $orders[0]->order_token)));
                        //die('2');//dong hang ton tai co comment
                    } else {
                        if($result[0]->status_comment == "2"){
                            $this->session->set_flashdata('flash_message_error', "Shop không đồng ý. Bạn vui lòng xác nhận lần nữa.");
                        } else {
                            $this->session->set_flashdata('flash_message_success', "Vui lòng điền đầy đủ thông tin.");
                        }
                        die(json_encode(array('error' => 1, 'order_token' => $orders[0]->order_token)));
                        // die('1');//don hang ton tai chua co comment
                    }
                } else {
                    $this->session->set_flashdata('flash_message_success', "Vui lòng điền đầy đủ thông tin.");
                    die(json_encode(array('error' => 1, 'order_token' => $orders[0]->order_token)));
                    // die('1');//don hang ton tai chua co comment
                }
            } else {
                $this->session->set_flashdata('flash_message_error', "Trạng thái đơn hàng không thể TRẢ hoặc Đổi hàng.");
                die(json_encode(array('error' => 0)));//ko ton tai don hang
            }
        }
    }
    
    private function upload(){
        
            $this->load->library('upload');

            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            $pathTarget = '/public_html/media/images/';
            $dirTarget = 'mauvandon';

            $pathBanner = "media/images/mauvandon/";
            #Create folder

            if (!is_dir($pathBanner)) {
                    @mkdir($pathBanner);
                    $this->load->helper('file');
            }
            $config['upload_path'] = $pathBanner . '/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10240;#KB
            $config['max_width'] = 10240;#px
            $config['max_height'] = 10240;#px
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image_mavandon')) {
                $uploadBanner = $this->upload->data();
                $content = $uploadBanner['file_name'];
                $upload = $this->upload->data();

                $source_path = $pathBanner . $upload['file_name'];                    
                $target_path = $pathTarget . $dirTarget . '/' . $upload['file_name'];
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                array_map('unlink', glob($pathBanner . '/*'));
                $this->ftp->close();

                return $upload['file_name'];
            } else {
                die("Upload hình fail!!!!");
            }
            
    }
    
    private function sendEmail($to, $from, $body ,$attachment='',$from_name="Azibai.com", $subject="Thông báo khiếu nại sản phẩm"){
        $this->load->model('shop_mail_model');
        $this->load->library('email');
        $this->email->initialize($config);
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.phpmailer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb . '/PHPMailer/class.pop3.php');
        return $this->shop_mail_model->smtpmailer($to, $from, $from_name, $subject, $body,$attachment);
    }
    
}