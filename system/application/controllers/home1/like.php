<?php 
#****************************************#
# * @Author: taihuynh                    #
# * @Email: hntai92@gmail.com            #
#****************************************#
defined('BASEPATH') or exit('No direct script access allowed');

class Like extends MY_Controller
{
    private $mainURL;
    private $subURL;
    private $shop_url = '';
    private $shop_current = '';

    function __construct()
    {
        parent::__construct();

        #Load model
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $this->load->model('customlink_model');


        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }

        $this->load->helper('cookie');
        #Load language
        $this->lang->load('home/common');
        $this->lang->load('home/shop');
        
        
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
        }
    

        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }
    
    ///////////////////////////////////////////f
    public function ajax_like_content()
    {
        $result = ['error' => true];
        $this->load->model('like_content_model');
        if($this->session->userdata('sessionUser'))
        {   
            $idContent = $this->input->post('id_content');
            $getLike = $this->like_content_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'not_id' => (int) $idContent]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'not_id' => (int) $idContent,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_content_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_content_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }
        else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_content_model->get('id', ['not_id' => (int) $idContent]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function ajax_like_info($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idContent = $this->input->post('id');
        
        $this->load->model('like_content_model');
        
        $listUserLike = $this->like_content_model->fetch_join('user_id, not_id, use_username, use_fullname, avatar, website', "not_id = ".  (int) $idContent, null, null, $start, $limit);

        $countLike = $this->like_content_model->get('id', ['not_id' => (int) $idContent]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'page' => $page, 'show_more' => true];
        if($this->session->userdata('sessionUser')){
            $result['user'] = $this->session->userdata('sessionUser');
        }
        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    public function ajax_like_product()
    {
        $result = ['error' => true];
        $this->load->model('like_product_model');
        if($this->session->userdata('sessionUser'))
        {   
            $idProduct = $this->input->post('id_pro');
            $getLike = $this->like_product_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'pro_id' => (int) $idProduct]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'pro_id' => (int) $idProduct,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_product_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_product_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_product_model->get('id', ['pro_id' => (int) $idProduct]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function ajax_like_info_product($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idProduct = $this->input->post('id');
        
        $this->load->model('like_product_model');
        
        $listUserLike = $this->like_product_model->fetch_join('user_id, pro_id, use_username, use_fullname, avatar, ', "pro_id = ".  (int) $idProduct, null, null, $start, $limit);

        $countLike = $this->like_product_model->get('id', ['pro_id' => (int) $idProduct]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'user' => (int)$this->session->userdata('sessionUser'), 'page' => $page, 'show_more' => true];

        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    public function ajax_like_image()
    {
        $result = ['error' => true];
        $this->load->model('like_image_model');
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_image_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'image_id' => (int) $idImage]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'image_id' => (int) $idImage,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_image_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_image_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_image_model->get('id', ['image_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function active_like_image(){
        $this->load->model('like_image_model');
        $result = ['error' => true, 'count' => 0];
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_image_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'image_id' => (int) $idImage]);
            $result = ['error' => false, 'count' => count($getLike)];
        }
        $countLike = $this->like_image_model->get('id', ['image_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die(); 
    }

    public function ajax_like_info_image($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idProduct = $this->input->post('id');
        
        $this->load->model('like_image_model');
        
        $listUserLike = $this->like_image_model->fetch_join('user_id, image_id, use_username, use_fullname, avatar, ', "image_id = ".  (int) $idProduct, null, null, $start, $limit);

        $countLike = $this->like_image_model->get('id', ['image_id' => (int) $idProduct]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'user' => (int)$this->session->userdata('sessionUser'), 'page' => $page, 'show_more' => true];

        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    public function ajax_like_gallery()
    {
        $result = ['error' => true];
        $this->load->model('like_gallery_model');
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_gallery_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'gallery_id' => (int) $idImage]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'gallery_id' => (int) $idImage,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_gallery_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_gallery_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_gallery_model->get('id', ['gallery_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function active_like_gallery(){
        $this->load->model('like_gallery_model');
        $result = ['error' => true, 'count' => 0];
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_gallery_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'gallery_id' => (int) $idImage]);
            $result = ['error' => false, 'count' => count($getLike)];
        }
        $countLike = $this->like_gallery_model->get('id', ['gallery_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die(); 
    }

    public function ajax_like_info_gallery($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idProduct = $this->input->post('id');

        $this->load->model('like_gallery_model');
        
        $listUserLike = $this->like_gallery_model->fetch_join('user_id, gallery_id, use_username, use_fullname, avatar, ', "gallery_id = ".  (int) $idProduct, null, null, $start, $limit);

        $countLike = $this->like_gallery_model->get('id', ['gallery_id' => (int) $idProduct]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'user' => (int)$this->session->userdata('sessionUser'), 'page' => $page, 'show_more' => true];

        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    public function ajax_like_video()
    {
        $result = ['error' => true];
        $this->load->model('like_video_model');
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_video_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'video_id' => (int) $idImage]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'video_id' => (int) $idImage,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_video_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_video_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_video_model->get('id', ['video_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function active_like_video(){
        $this->load->model('like_video_model');
        $result = ['error' => true, 'count' => 0];
        $idImage = $this->input->post('id_image');
        if($this->session->userdata('sessionUser'))
        {
            $getLike = $this->like_video_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'video_id' => (int) $idImage]);
            $result = ['error' => false, 'count' => count($getLike)];
        }
        $countLike = $this->like_video_model->get('id', ['video_id' => (int) $idImage]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die(); 
    }

    public function ajax_like_info_video($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idProduct = $this->input->post('id');
        
        $this->load->model('like_video_model');
        
        $listUserLike = $this->like_video_model->fetch_join('user_id, video_id, use_username, use_fullname, avatar, ', "video_id = ".  (int) $idProduct, null, null, $start, $limit);

        $countLike = $this->like_video_model->get('id', ['video_id' => (int) $idProduct]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow,'user' => (int)$this->session->userdata('sessionUser'), 'page' => $page, 'show_more' => true];

        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }

    public function ajax_like_link()
    {
        $result = ['error' => true];
        $this->load->model('like_link_model');
        if($this->session->userdata('sessionUser'))
        {
            $id_link = $this->input->post('id_link');
            $tbl = $this->input->post('tbl');
            switch ($tbl) {
                case 'image-link':
                    $type_url = 'tbtt_content_image_links';
                    break;
                
                case 'content-link':
                    $type_url = 'tbtt_content_links';
                    break;
                
                case 'library-link':
                    $type_url = 'tbtt_lib_links';
                    break;
                
                default:
                    $type_url = '';
                    break;
            }
            $getLike = $this->like_link_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'link_id' => (int) $id_link, 'tbl' => '"'.$type_url.'"']);
            if (empty($getLike))
            {
                $dataInsert = [
                    'link_id' => (int) $id_link,
                    'user_id' => $this->session->userdata('sessionUser'),
                    'tbl' => $type_url
                ];
                if ($this->like_link_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_link_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_link_model->get('id', ['link_id' => (int) $id_link, 'tbl' => '"'.$type_url.'"']);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function active_like_link(){
        $this->load->model('like_link_model');
        $result = ['error' => true, 'count' => 0];
        if($this->session->userdata('sessionUser'))
        {
            $id_link = $this->input->post('id_link');
            $tbl = $this->input->post('tbl');
            switch ($tbl) {
                case 'image-link':
                    $type_url = 'tbtt_content_image_links';
                    break;
                
                case 'content-link':
                    $type_url = 'tbtt_content_links';
                    break;
                
                case 'library-link':
                    $type_url = 'tbtt_lib_links';
                    break;
                
                default:
                    $type_url = '';
                    break;
            }
            $getLike = $this->like_link_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'link_id' => (int) $id_link, 'tbl' => '"'.$type_url.'"']);
            $result = ['error' => false, 'count' => count($getLike)];
        }
        $countLike = $this->like_link_model->get('id', ['link_id' => (int) $id_link, 'tbl' => '"'.$type_url.'"']);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die(); 
    }

    public function ajax_like_info_link($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }
        $id_link = $this->input->post('id');
        $tbl = $this->input->post('tbl');
        switch ($tbl) {
            case 'image-link':
                $type_url = 'tbtt_content_image_links';
                break;
            
            case 'content-link':
                $type_url = 'tbtt_content_links';
                break;
            
            case 'library-link':
                $type_url = 'tbtt_lib_links';
                break;
            
            default:
                $type_url = '';
                break;
        }
        
        $this->load->model('like_link_model');
        $listUserLike = $this->like_link_model->fetch_join('user_id, link_id, use_username, use_fullname, avatar, ', "link_id = ".  (int) $id_link . ' AND tbl = "' . $type_url . '"', null, null, $start, $limit);

        $countLike = $this->like_link_model->get('id', ['link_id' => (int) $id_link, 'tbl' => '"'.$type_url.'"']);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow,'user' => (int)$this->session->userdata('sessionUser'), 'page' => $page, 'show_more' => true];

        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }
    public function ajax_like_service()
    {
        $result = ['error' => true];
        $this->load->model('like_service_model');
        if($this->session->userdata('sessionUser'))
        {   
            $idService = $this->input->post('id_service');
            $getLike = $this->like_service_model->get('*', ['user_id' => $this->session->userdata('sessionUser'), 'service_id' => (int) $idService]);
            if (empty($getLike))
            {
                $dataInsert = [
                    'service_id' => (int) $idService,
                    'user_id' => $this->session->userdata('sessionUser')
                ];
                if ($this->like_service_model->add($dataInsert)) {
                    $result = ['error' => false, 'like' => true, 'user' => true];
                }
            } 
            else if ($this->like_service_model->delete(['id' => $getLike[0]->id]))
            {
               $result = ['error' => false, 'like' => false, 'user' => true];
            }
        }
        else{
            $result = ['error' => true, 'like' => false, 'user' => false];
        }
        $countLike = $this->like_service_model->get('id', ['service_id' => (int) $idService]);
        $result['total'] = count($countLike);
        echo json_encode($result);
        die();   
    }

    public function ajax_like_info_service($page = 1) 
    {  
        $limit = 20;
        $start = 0; 
        if ((int)$page > 1)
        {
           $start = ((int)$page - 1) * $limit;
        }

        $idService = $this->input->post('id');
        
        $this->load->model('like_service_model');
        
        $listUserLike = $this->like_service_model->fetch_join('user_id, service_id, use_username, use_fullname, avatar, ', "service_id = ".  (int) $idService, null, null, $start, $limit);

        $countLike = $this->like_service_model->get('id', ['service_id' => (int) $idService]);
        $total = count($countLike);

        $this->load->model('friend_model');
        $listFollow = $this->friend_model->get('*', "add_friend_by = ".  (int)$this->session->userdata('sessionUser'));
        $listIsfollow = $this->friend_model->get('*', "user_id = ".  (int)$this->session->userdata('sessionUser'));
        
        $result = ['total' => $total, 'data' => $listUserLike, 'addFriend' => $listFollow, 'isFriend' => $listIsfollow, 'page' => $page, 'show_more' => true];
        if($this->session->userdata('sessionUser')){
            $result['user'] = $this->session->userdata('sessionUser');
        }
        $show_loadmore = $start + $limit;

        if ($show_loadmore >= $total) {
            $result['show_more'] = false;
        }

        echo json_encode($result);
        die();
    }
}