<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends MY_Controller {

    public function __construct() {
        parent::__construct();
        #CHECK SETTING
        if ((int) settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Ajax add Comment
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxAddCommnet($id) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');
        $aTypeVideo = array('video/mp4','video/mpeg');
        $result['message']  = 'Thêm bình luận thất bại!';
        $result['type']     = 'error';
        if(isset($id) && $id != 0) {
            // Khởi tạo biến để tạo comment
            $aData = array();
            //$aComment   = array('type' => 'text','comment' => '');
            $aData['comment[new_id]']    = $id;
            $aData['comment[type]']      = 'text';
            $aData['comment[comment]']   = $this->input->post('comment');

            if(isset($_FILES['comment_images']) && !empty($_FILES['comment_images'])){
                $aData['comment[type]']      = 'image';
                for ($i=0; $i < count($_FILES['comment_images']['name']); $i++) {
                    $file_name  = $_FILES['comment_images']['name'][$i];
                    $file_size  = $_FILES['comment_images']['size'][$i];
                    $file_tmp   = $_FILES['comment_images']['tmp_name'][$i];
                    $file_type  = $_FILES['comment_images']['type'][$i];
                    if(in_array($file_type, $aTypeVideo)) {
                        $aData['video'] = new CURLFile($file_tmp, $file_type, $file_name);
                        $aData['comment[type]']      = 'video';
                        break;
                    }
                    $aData['images['.$i.']'] = new CURLFile($file_tmp, $file_type, $file_name);
                }
            }
            $aListProduct = $this->input->post('listproduct');
            if(!empty($aListProduct) && is_array($aListProduct)) {
                foreach ($aListProduct as $key => $value) {
                   $aData['products['.$key.']'] = $value;
                }
            }
            $aData['comment[is_personal]'] = 1;
            if($this->input->post('parent_id') != '') {
                $aData['comment[parent_id]'] = $this->input->post('parent_id');
            }
            $sToken =  $this->session->userdata('token');
            // Thêm comment 
            $jData = curl_data(api_comment.'comment', $aData,'','','POST',$sToken);
            if($jData != '') {
                echo $jData;
            }
        }
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Comment page
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function loadCommnet($id){
        $this->load->model('content_model');
        $aListComment = array();
        if(isset($id) && $id != 0) {
            $aData = array();
            //$news = $this->content_model->get('','not_id = '.$id);
            $sql2 = 'SELECT * FROM tbtt_content AS a '
            . 'LEFT JOIN tbtt_user AS u ON a.not_user = u.use_id '
            . 'LEFT JOIN tbtt_shop AS s ON a.not_user = s.sho_user '
            . 'WHERE not_id = '.$id;

            $query = $this->db->query($sql2);
            $news  = $query->row();
            if(!empty($news)) {
                $item_link = azibai_url() . '/tintuc/detail/' . $news->not_id . '/' . RemoveSign($news->not_title);
                $data['infomation_user'] = array(
                    'use_fullname'  => $news->use_fullname,
                    'avatar'        => DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $news->sho_dir_logo . '/' . $news->sho_logo,
                    'detail_link'   => $item_link
                );
            }
            $sToken =  $this->session->userdata('token');
            if(isset($_REQUEST['comment_id']) && $_REQUEST['comment_id'] != '') {
                $oDatas = json_decode(curl_data(api_comment.'comment/'.$_REQUEST['comment_id'], $aData,'','','GET',$sToken));

                if($oDatas->status == 1 && !empty($oDatas->data->self)) {
                    $oComment = $oDatas->data->self;
                    if($oComment->user->avatar != '') {
                        $avatar = $oComment->user->avatar;
                    }else {
                        $avatar = site_url('media/images/avatar/default-avatar.png');
                    }
                    $aComment = array(
                        'comment_id'    => $oComment->_id,
                        'new_id'        => $oComment->new_id,
                        'use_id'        => $oComment->user->use_id,
                        'avatar'        => $avatar,
                        'use_fullname'  => $oComment->user->use_fullname,
                        'comment'       => $oComment->comment,
                        'created_at'    => time2str($oComment->created_at),
                        'path'          => $oDatas->path,
                        'number_image'  => count($oComment->collection),
                        'count_likes'   => $oComment->count_likes,
                        'count_children'=> $oComment->count_children,
                        'images'        => $images,
                        'class'         => '',
                        'products'      => $oComment->products
                    );
                    if($oComment->type == 'video') {
                        $aComment['video']  = $oDatas->path.$oComment->path;
                    }
                    $aListComment[] = (object) $aComment;
                }
                if($oDatas->status == 1 && $oDatas->data != '' && $oDatas->data->children) {
                    foreach ($oDatas->data->children as $iKComment => $oComment) {
                        $images = array_slice($oComment->collection,0,4);
                        if($oComment->user->avatar != '') {
                            $avatar = $oComment->user->avatar;
                        }else {
                            $avatar = site_url('media/images/avatar/default-avatar.png');
                        }
                        $aComment = array(
                            'comment_id'    => $oComment->_id,
                            'new_id'        => $oComment->new_id,
                            'use_id'        => $oComment->user->use_id,
                            'avatar'        => $avatar,
                            'use_fullname'  => $oComment->user->use_fullname,
                            'comment'       => $oComment->comment,
                            'created_at'    => time2str($oComment->created_at),
                            'path'          => $oDatas->path,
                            'number_image'  => count($oComment->collection),
                            'count_likes'   => $oComment->count_likes,
                            'count_children'=> $oComment->count_children,
                            'images'        => $images,
                            'class'         => '',
                            'products'      => $oComment->products
                        );
                        if(isset($oComment->reply_to) && isset($oComment->reply_to->use_fullname)) {
                            $aComment['reply_to'] = $oComment->reply_to->use_fullname;
                        }
                        if($oComment->type == 'video') {
                            $aComment['video']  = $oDatas->path.$oComment->path;
                        }
                        $aListComment[] = (object) $aComment;
                    }
                }
                $data['parent_id']           = $_REQUEST['comment_id'];
            }else {
                $oDatas = json_decode(curl_data(api_comment.'comments/'.$id, $aData,'','','GET',$sToken));
                if($oDatas->status == 1 && $oDatas->data != '') {
                    foreach ($oDatas->data as $iKComment => $oComment) {
                        $images = array_slice($oComment->collection,0,4);
                        if($oComment->user->avatar != '') {
                            $avatar = $oComment->user->avatar;
                        }else {
                            $avatar = site_url('media/images/avatar/default-avatar.png');
                        }
                        $aComment = array(
                            'comment_id'    => $oComment->_id,
                            'new_id'        => $oComment->new_id,
                            'use_id'        => $oComment->user->use_id,
                            'avatar'        => $avatar,
                            'use_fullname'  => $oComment->user->use_fullname,
                            'comment'       => $oComment->comment,
                            'created_at'    => time2str($oComment->created_at),
                            'path'          => $oDatas->path,
                            'number_image'  => count($oComment->collection),
                            'count_likes'   => $oComment->count_likes,
                            'count_children'=> $oComment->count_children,
                            'images'        => $images,
                            'class'         => '',
                            'products'      => $oComment->products
                        );
                        // Comment parent last
                        if(isset($oComment->parent_of_last) && !empty($oComment->parent_of_last)) {
                            $oCommentPLast = $oComment->parent_of_last;

                            $images = array_slice($oCommentPLast->collection,0,4);
                            if($oCommentPLast->user->avatar != '') {
                                $avatar = $oCommentPLast->user->avatar;
                            }else {
                                $avatar = site_url('media/images/avatar/default-avatar.png');
                            }
                            $aComment['parent_of_last'] = array(
                                'comment_id'    => $oCommentPLast->_id,
                                'new_id'        => $oCommentPLast->new_id,
                                'use_id'        => $oCommentPLast->user->use_id,
                                'avatar'        => $avatar,
                                'use_fullname'  => $oCommentPLast->user->use_fullname,
                                'comment'       => $oCommentPLast->comment,
                                'created_at'    => time2str($oCommentPLast->created_at),
                                'path'          => $oDatas->path,
                                'number_image'  => count($oCommentPLast->collection),
                                'count_likes'   => $oCommentPLast->count_likes,
                                'count_children'=> $oCommentPLast->count_children,
                                'images'        => $images,
                                'class'         => 'comment-bg-line',
                                'products'      => $oCommentPLast->products
                            );

                            if(isset($oCommentPLast->reply_to) && isset($oCommentPLast->reply_to->use_fullname)) {
                                $aComment['parent_of_last']['reply_to'] = $oCommentPLast->reply_to->use_fullname;
                            }
                            if($oCommentPLast->type == 'video') {
                                $aComment['parent_of_last']['video']  = $oDatas->path.$oCommentPLast->path;
                            }
                            $aComment['parent_of_last'] = (object) $aComment['parent_of_last'];
                        }
                        // Comment Last
                        if(isset($oComment->last) && !empty($oComment->last)) {
                            $oCommentLast = $oComment->last;
                            $images = array_slice($oCommentLast->collection,0,4);
                            if($oCommentLast->user->avatar != '') {
                                $avatar = $oCommentLast->user->avatar;
                            }else {
                                $avatar = site_url('media/images/avatar/default-avatar.png');
                            }
                            $aComment['last'] = array(
                                'comment_id'    => $oCommentLast->_id,
                                'new_id'        => $oCommentLast->new_id,
                                'use_id'        => $oCommentLast->user->use_id,
                                'avatar'        => $avatar,
                                'use_fullname'  => $oCommentLast->user->use_fullname,
                                'comment'       => $oCommentLast->comment,
                                'created_at'    => time2str($oCommentLast->created_at),
                                'path'          => $oDatas->path,
                                'number_image'  => count($oCommentLast->collection),
                                'count_likes'   => $oCommentLast->count_likes,
                                'count_children'=> $oCommentLast->count_children,
                                'images'        => $images,
                                'class'         => '',
                                'products'      => $oCommentLast->products
                            );

                            if(isset($oCommentLast->reply_to) && isset($oCommentLast->reply_to->use_fullname)) {
                                $aComment['last']['reply_to'] = $oCommentLast->reply_to->use_fullname;
                            }
                            if($oCommentLast->type == 'video') {
                                $aComment['last']['video']  = $oDatas->path.$oCommentLast->path;
                            }
                            if( $oComment->level == ($oCommentLast->level -1) ){
                                $aComment['class']  = 'comment-bg-line';
                            }else {
                                $aComment['class']  = 'comment-bg-dot';
                            }
                            $aComment['last'] = (object) $aComment['last'];
                        }
                        
                        if($oComment->type == 'video') {
                            $aComment['video']  = $oDatas->path.$oComment->path;
                        }
                        $aListComment[] = (object) $aComment;
                    }
                }
            }
            
            $data['aListComment'] = $aListComment;
            $data['id']           = $id;
        }
        $this->load->view('comment/comment_page', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Ajax load Comment
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxLoadCommnet($id) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy bình luận thất bại!';
        $result['type']     = 'error';
        $aListComment = array();
        $aCommentP = array();
        $infomation_user = array();
        if(isset($id) && $id != 0) {
            $get_type = 0;
            $sToken =  $this->session->userdata('token');
            $aData  = array();
            if($this->input->post('get_type')) {
                $oDatas = json_decode(curl_data(api_comment.'comment/'.$id, $aData,'','','GET',$sToken));
                $get_type = 1;
            }else {
                $oDatas = json_decode(curl_data(api_comment.'comments/'.$id, $aData,'','','GET',$sToken));
            }

            if($oDatas->status == 1 && $oDatas->data != '') {
                $sPath = $oDatas->path;
                if($get_type == 1) {
                    $oCommentP = $oDatas->data->self;
                    $images = array_slice($oCommentP->collection,0,4);
                    if($oCommentP->user->avatar != '') {
                        $avatar = $oCommentP->user->avatar;
                    }else {
                        $avatar = site_url('media/images/avatar/default-avatar.png');
                    }
                    $aCommentP = array(
                        'comment_id'    => $oCommentP->_id,
                        'new_id'        => $oCommentP->new_id,
                        'use_id'        => $oCommentP->user->use_id,
                        'avatar'        => $avatar,
                        'use_fullname'  => $oCommentP->user->use_fullname,
                        'comment'       => $oCommentP->comment,
                        'created_at'    => time2str($oCommentP->created_at),
                        'path'          => $oDatas->path,
                        'number_image'  => count($oCommentP->collection),
                        'count_likes'   => $oCommentP->count_likes,
                        'count_children'=> $oCommentP->count_children,
                        'images'        => $images,
                        'products'      => $oCommentP->products
                    );
                    if($oCommentP->type == 'video') {
                        $aCommentP['video']  = $oDatas->path.$oCommentP->path;
                    }

                    $id = $oCommentP->new_id;

                    if(!empty($oDatas->data->children)) {
                        foreach ($oDatas->data->children as $iKComment => $oComment) {
                            $images = array_slice($oComment->collection,0,4);
                            if($oComment->user->avatar != '') {
                                $avatar = $oComment->user->avatar;
                            }else {
                                $avatar = site_url('media/images/avatar/default-avatar.png');
                            }
                            $aComment = array(
                                'comment_id'    => $oComment->_id,
                                'new_id'        => $oComment->new_id,
                                'use_id'        => $oComment->user->use_id,
                                'avatar'        => $avatar,
                                'use_fullname'  => $oComment->user->use_fullname,
                                'comment'       => $oComment->comment,
                                'created_at'    => time2str($oComment->created_at),
                                'path'          => $oDatas->path,
                                'number_image'  => count($oComment->collection),
                                'count_likes'   => $oComment->count_likes,
                                'count_children'=> $oComment->count_children,
                                'images'        => $images,
                                'products'      => $oComment->products
                            );
                            if($oComment->type == 'video') {
                                $aComment['video']  = $oDatas->path.$oComment->path;
                            }
                            $aListComment[] = (object) $aComment;
                        }
                    }

                }else {
                    foreach ($oDatas->data as $iKComment => $oComment) {
                        
                        $aComment = $this->_handleComment($oComment, $sPath);

                        if(isset($oComment->last)) {
                            $aComment['last'] = (object) $this->_handleComment($oComment->last);
                        }

                        if(isset($oComment->parent_of_last)) {
                            $aComment['parent_of_last'] = (object) $this->_handleComment($oComment->parent_of_last);
                        }

                        $aListComment[] = (object) $aComment;
                    }
                }

                $sql2 = 'SELECT * FROM tbtt_content AS a '
                . 'LEFT JOIN tbtt_user AS u ON a.not_user = u.use_id '
                . 'LEFT JOIN tbtt_shop AS s ON a.not_user = s.sho_user '
                . 'WHERE not_id = '.$id;

                $query = $this->db->query($sql2);
                $news  = $query->row();
                if(!empty($news)) {
                    $item_link = azibai_url() . '/tintuc/detail/' . $news->not_id . '/' . RemoveSign($news->not_title);
                    $infomation_user = array(
                        'use_fullname'  => $news->use_fullname,
                        'avatar'        => DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $news->sho_dir_logo . '/' . $news->sho_logo,
                        'detail_link'   => $item_link
                    );
                }
            }
            $data = $this->load->view('comment/comment', array('id' => $id, 'comment_type' => $comment_type, 'get_type' => $get_type, 'aCommentP' => $aCommentP, 'aListComment' => $aListComment, 'infomation_user' => $infomation_user), TRUE);
            $result['message']  = 'Lấy bình luận thành công!';
            $result['type']     = 'success';
            $result['data']     = $data;
        }
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Ajax load List Image
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxLoadListImage($id) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Thêm hình thất bại!';
        $result['type']     = 'error';
        $aListComment = array();
        if(isset($id) && $id != 0) {

            $oDatas = json_decode(curl_data(api_comment.'comment/'.$id, array(),'','','GET',''));

            if($oDatas->status == 1 && !empty($oDatas->data->self->collection)) {
                $result['comment_id']    = $oComment->_id;
                $result['path']          = $oDatas->path;
                $result['images']        = $oDatas->data->self->collection;
            }

            $result['message']  = 'Lấy hình thành công!';
            $result['type']     = 'success';
        }
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Get all category
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxGetCategory($type) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy danh mục thất bại!';
        $result['type']     = 'error';
        $sCategory = '';
        if(isset($type) && $type == 0) {
            // Lấy danh mục sản phẩm
            $oDatas = json_decode(curl_data(link_get_token.'categories/categories-products',array(),'','','GET',''));
            if($oDatas->status == 1 && !empty($oDatas->data)) {
                $sCategory .= '<ul class="parent-category">';
                foreach ($oDatas->data as $iCategories => $oCategories) {
                    $sCategory .= '<li data-value="'.$oCategories->cat_id.'">'.$oCategories->cat_name.'</li>';
                }
                $sCategory .= '</ul>';
            }
        }else {
            // Lấy danh mục cupon
            $oDatas = json_decode(curl_data(link_get_token.'categories/categories-coupons',array(),'','','GET',''));
            if($oDatas->status == 1 && !empty($oDatas->data)) {
                $sCategory .= '<ul class="parent-category">';
                foreach ($oDatas->data as $iCategories => $oCategories) {
                    $sCategory .= '<li data-value="'.$oCategories->cat_id.'">'.$oCategories->cat_name.'</li>';
                }
                $sCategory .= '</ul>';
            }
        }
    
        $result['message']  = 'Lấy hình thành công!';
        $result['type']     = 'success';
        $result['data']     = $sCategory;
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Get all category
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxGetCategoryChild($id) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy danh mục thất bại!';
        $result['type']     = 'error';

        if(!isset($id) || $id == 0) {
            $result['message']  = 'Không tồn tại danh mục sản phẩm';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }
        $type = $this->input->get('type');
        $sCategory = '';
        if(isset($type) && $type == 0) {
            // Lấy danh mục sản phẩm
            $oDatas = json_decode(curl_data(link_get_token.'categories/'.$id.'/children/product-exist',array(),'','','GET',''));
            if($oDatas->status == 1 && !empty($oDatas->data)) {
                $sCategory .= '<ul class="child-category">';
                foreach ($oDatas->data as $iCategories => $oCategories) {
                    $sCategory .= '<li data-value="'.$oCategories->cat_id.'">'.$oCategories->cat_name.'</li>';
                }
                $sCategory .= '</ul>';
            }
        }
    
        $result['message']  = 'Lấy hình thành công!';
        $result['type']     = 'success';
        $result['data']     = $sCategory;
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * Get Product
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxGetProduct($id) {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy danh mục thất bại!';
        $result['type']     = 'error';

        if(!isset($id) || $id == 0) {
            $result['message']  = 'Không tồn tại danh mục sản phẩm';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }
        $type   = $this->input->post('type');
        $azibai = $this->input->post('azibai');
        if($type == '' || $azibai == '') {
            $result['message']  = 'Vui lòng chọn loại sản phẩm muốn lấy';
            $result['type']     = 'error';
            echo json_encode($result);
            die();
        }
        $sToken =  $this->session->userdata('token');
        $oDatas = json_decode(curl_data(link_get_token.'products/choose-tag?key_word=&product_type='.$type.'&is_azibai='.$azibai.'&limit=10&page=1&category_id='.$id,array(),'','','GET',$sToken));
        $sProduct = '';
        if($oDatas->status == 1 && !empty($oDatas->data->data)) {
            $sProduct .= '<ul class="list-product-chose">';
            foreach ($oDatas->data->data as $iCategories => $oCategories) {
                $sProduct .= '<li id="'.$oCategories->pro_id.'" class="choose-pro" data-id="'.$oCategories->pro_id.'">';
                    $sProduct .= '<div class="image" data-id="'.$oCategories->pro_id.'">';
                        $sProduct .= '<img class="main-image" src="'.$oCategories->pro_image.'" data-id="'.$oCategories->pro_id.'">';
                        $sProduct .= '<span class="icon-chon">';
                            $sProduct .= '<img data-id="'.$oCategories->pro_id.'" src="/templates/home/images/svg/chon.svg" alt="">';
                        $sProduct .= '</span>';
                    $sProduct .= '</div>';
                    $sProduct .= '<div class="decs">';
                        $sProduct .= '<span class="sale-price">'.number_format($oCategories->pro_cost).'đ</span>';
                    $sProduct .= '</div>';
                $sProduct .= '</li>';
            }
            $sProduct .= '</ul>';
        }
        $result['message']  = 'Lấy sản phẩm thành công!';
        $result['type']     = 'success';
        $result['data']     = $sProduct;
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/10/24
     * Get Links
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: json
     *  
     ***************************************************************************
    */

    public function AjaxGetLinks() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header("Access-Control-Allow-Credentials: true");
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy links thất bại!';
        $result['type']     = 'error';

        $sListGroup = '';
        $aListLinks = array();
        $iCurrentCategory   = $this->input->post('iCategoryId');
        $iLatest            = 0;

        if($iCurrentCategory == '') {
            $iCurrentCategory   = 0;
            $iLatest            = 1;
        }

        $sToken =  $this->session->userdata('token');
        
        // Get all categories
        $oDataLink = json_decode(curl_data(link_get_token.'group-category-links',array(),'','','GET',$sToken));
        if($oDataLink->status == 1) {
            $sListGroup .= '<div class="socials-logos js-scroll-x mb-3">';
            $sListGroup .= '<div class="tag-column-parent"><ul class="overflow-x">';
            foreach ($oDataLink->data as $iKG => $oLinkGroup) {
                $sListGroup .='<li data-id="'.$oLinkGroup->id.'">'.$oLinkGroup->name.'</li>';
            }
            $sListGroup .= '</ul></div>';
            $sListGroup .= '</div>';
        }

        // Get mới nhất
        $oDatas = json_decode(curl_data(link_get_token.'all-links-new?current_category='.$iCurrentCategory.'&latest='.$iLatest,array(),'','','GET',$sToken));
        if($oDatas->status == 1 && !empty($oDatas->data)) {
           foreach ($oDatas->data as $iKL => $oLink) {
                $aListLinks[] = array(
                    'id'                => $oLink->id,
                    'user_id'           => $oLink->user_id,
                    'save_link'         => $oLink->save_link,
                    'title'             => $oLink->title,
                    'description'       => $oLink->description,
                    'full_image_path'   => $oLink->full_image_path,
                );
            }
        }
        $result['message']              = 'Lấy links thành công!';
        $result['type']                 = 'success';
        $result['data']['sListGroup']   = $sListGroup;
        $result['data']['aListLinks']   = $aListLinks;
        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/06/03
     * handle comment
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: comment object
     *  
     ***************************************************************************
    */

    private function _handleComment($oComment = array(), $sPath = '') {

        $aComment       = array();
        $images         = array();
        $aListInclude   = array();
        $number_image   = 0;
        $reply_to       = '';
        if(isset($oComment->collection)) {
            $images         = array_slice($oComment->collection,0,4);
            $number_image   = count($oComment->collection);
        }
        
        if($oComment->user->avatar != '') {
            $avatar = $oComment->user->avatar;
        }else {
            $avatar = site_url('media/images/avatar/default-avatar.png');
        }

        if(isset($oComment->reply_to)) {
            $reply_to = 'Đã trả lời cho '.$oComment->reply_to->use_fullname;
        }

        if(isset($oComment->includes) && count($oComment->includes) >= 2 ) {
            foreach ($oComment->includes as $iKI => $oIncludes) {
                $aListInclude[] =  $oIncludes->user;
            }
        }

        $aComment = array(
            'comment_id'    => $oComment->_id,
            'new_id'        => $oComment->new_id,
            'use_id'        => $oComment->user->use_id,
            'avatar'        => $avatar,
            'use_fullname'  => $oComment->user->use_fullname,
            'comment'       => $oComment->comment,
            'created_at'    => time2str($oComment->created_at),
            'path'          => $sPath,
            'number_image'  => $number_image,
            'count_likes'   => $oComment->count_likes,
            'count_children'=> $oComment->count_children,
            'images'        => $images,
            'reply_to'      => $reply_to,
            'aListInclude'  => $aListInclude,
            'products'      => $oComment->products
        );
        if($oComment->type == 'video') {
            $aComment['video']  = $oDatas->path.$oComment->path;
        }
        return $aComment;
    }

}