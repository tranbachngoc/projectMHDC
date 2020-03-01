<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link extends MY_Controller
{
    private $shop_url       = '';
    private $shop_current   = '';
    private $mainURL        = '';

    function __construct()
    {
        parent::__construct();
        $this->lang->load('form_validation', 'vietnamese');
        $this->load->config('config_upload');
        $this->load->library('link_library');
        $this->load->model('user_model');
        $this->load->model('shop_model');

        $this->load->model('category_link_model');
        $this->load->model('link_model');
        $this->load->model('lib_link_model');
        $this->load->model('content_link_model');
        $this->load->model('content_image_link_model');

        $this->load->model('collection_model');
        $this->load->model('collection_lib_link_model');
        $this->load->model('collection_content_link_model');
        $this->load->model('collection_content_image_link_model');

        if(is_domain_shop()){
            $this->shop_current   = MY_Loader::$static_data['hook_shop'];
            $data['shop_current'] = $this->shop_current;
            $data['shop_url']     = $this->shop_url;
        }
        $data['mainURL'] = $this->mainURL;

    }

    /**
     * Display browser azibai "links"
     */
    public function index()
    {
        $this->load->model('bookmark_model');
        $this->set_layout('home/layout/default-layout');
        $data['view_type']    = $this->_view_type();
        $data['user_login']   = MY_Loader::$static_data['hook_user'];
        $data['azibai_url']   = azibai_url();
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';

        $data['categories_parent'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'id ASC',
            'type'      => 'array',
        ]);

        if($this->input->is_ajax_request()){
            $page   = (int)$this->input->post('page');
            $page   = $page < 2 ? 2 : $page;
            $index  = $page - 1;
            if(isset($data['categories_parent'][$index])){
                $cat_id = $data['categories_parent'][$index]['id'];
            }else{
                //het page
                die();
            }
        }

        if(!isset($page)){
            $cat_id = 1;
        }

        $data['links_new']         = $this->link_model->gallery_link_new();
        $data['links']             = $this->link_model->links_unique(0, 0, $cat_id);
        $data['categories_parent'] = array_to_key_arrays($data['categories_parent'], 'id');

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/links/link_category_block_item', $data, true);
            die();
        }

        if(!empty($data['user_login'])){
            $data['bookmarks'] = $this->bookmark_model->my_bookmarks($data['user_login']['use_id']);
            $data['categories_popup_create_link'] = $data['categories_parent'];
        }

        $this->load->view('home/pages/link', $data);
    }

    public function link_category($slug)
    {
        $slug = strip_tags(trim($slug));
        if(!$slug){
            exit();
        }
        $this->load->model('bookmark_model');
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
        }
        $this->set_layout('home/layout/default-layout');
        $data['view_type']     = $this->_view_type();
        $data['user_login']    = MY_Loader::$static_data['hook_user'];
        $data['category_slug'] = $slug;
        $data['server_media']  = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $data['domain_url']    = azibai_url();
        if($slug !== 'moi-nhat' && !($category_current = $this->category_link_model->get_category_by_slug($slug))){
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        //slug != tat-ca
        if(!empty($category_current)) {
            $data['category_current'] = $category_current;

            if ($category_current['parent_id']) {
                $data['category_child_selected'] = $category_current['id'];
                $data['category_parent']         = [
                    'id'             => $category_current['parent_id'],
                    'name'           => $category_current['parent_name'],
                    'slug'           => $category_current['parent_slug'],
                    'class_bg_color' => $category_current['class_bg_color'],
                ];
            } else {
                $data['category_parent'] = $category_current;
            }

            $data['create_category_selected_default'] = $category_current['id'];
            $data['category_parent_selected']         = $data['category_parent']['id'];
            //nếu là parent thì id = id || parent = id;
            $data['links'] = $this->_get_library_links($category_current['id'], (int)$category_current['parent_id'] == 0);
        }else{
            //slug tat ca
            $data['links'] = $this->_get_library_links();
        }

        if($this->input->is_ajax_request()){
            echo $this->load->view('home/links/link-items', $data, true);
            die();
        }

        $data['categories_parent'] = $this->category_link_model->gets([
            'param'     => 'status = 1 AND parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        if($slug != 'moi-nhat'){
            $temp = $this->link_model->distinct_category_child($data['category_parent']['id']);
            $temp = array_to_array_keys($temp, 'cat_id');
            if(!empty($temp)){
                $data['categories_child'] = $this->category_link_model->gets([
                    'param'     => 'status = 1 AND id IN('. implode(',', $temp) . ')',
                    'orderby'   => 'ordering',
                    'type'      => 'array',
                ]);
            }
        }

        if(!empty($data['user_login'])){
            $data['bookmarks'] = $this->bookmark_model->my_bookmarks($data['user_login']['use_id']);
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }

        //SEO
        $ogimage = '';
        if($data['links']){
            if($data['links'][0]['image']) {
                $ogimage = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $data['links'][0]['image'];
            }else{
                $ogimage = $data['links'][0]['link_image'];
            }
        }

        $data['ogimage']            = $ogimage;
        $data['descrSiteGlobal']    = settingDescr;
        $data['keywordsSiteGlobal'] = '';
        $data['ogurl']              = azibai_url() .'/links/'.$slug;
        $data['ogtype']             = 'website';
        $data['ogtitle']            = '';
        $data['ogdescription']      = '';
        $data['share_name']         = $data['ogdescription'];
        $data['share_url']          = '/links/' . $slug;

        $this->load->view('home/pages/category-link', $data);
    }

    public function show($id, $type)
    {
        $this->set_layout('home/layout/default-layout');
        $this->load->library('link_library');
        $this->load->model('category_link_model');
        $this->load->model('collection_model');
        $this->load->model('shop_model');
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
        }
        $id = (int)$id;
        if(!$id || !$type || !($data['link'] = $this->link_library->exist_link($id, $type))){
            redirect($this->mainURL . 'page-not-found');
            die();
        }

        $data['user_login'] = MY_Loader::$static_data['hook_user'];
        $data['url_item']   = azibai_url();
        $data['domain_url'] = $data['url_item'];
        $data['server_media'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
        $user_id            = (int)$this->session->userdata('sessionUser');
        $group_id           = (int)$this->session->userdata('sessionGroup');
        $data['user_owner'] = $this->link_library->get_owner($data['link']);

        if ($data['link']['cate_link_id']) {
            $category_current = $this->category_link_model->get_category_by_id($data['link']['cate_link_id']);
            $data['link']['category_current'] = $category_current;
            if ($category_current['parent_id']) {
                $data['link']['category_parent'] = [
                    'id'   => $category_current['parent_id'],
                    'name' => $category_current['parent_name'],
                    'slug' => $category_current['parent_slug'],
                ];
            } else {
                $data['link']['category_parent'] = $category_current;
            }
        }

        //liên kết cùng bộ sưu tập
        $data['link']['links_collection'] = $this->link_library->links_same_collection($data['link']['id'], $type, $data['link']['sho_id'], $data['link']['user_id']);

        //liên kết cùng danh mục
        $data['link']['links_category']   = $this->link_library->link_same_category($data['link']['cate_link_id'], $type, $data['link']['sho_id'], $data['link']['user_id'], $data['link']['id']);

        //liên kết cùng tin
        if(!empty($data['link']['content_id'])){
            $data['link']['links_news']   = $this->link_library->link_of_news($data['link']['content_id'], '', $data['link']['sho_id'], $data['link']['user_id'], $data['link']['id']);
        }

        if(!empty($data['user_login'])){
            $shops               = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $data['collections'] = $this->collection_model->my_collections(0, array_to_array_keys($shops, 'sho_id'));
            $data['categories_popup_create_link'] = $this->category_link_model->gets([
                'param'     => 'status = 1 AND parent_id = 0',
                'orderby'   => 'ordering',
                'type'      => 'array',
            ]);
        }
        $type_share = '';
        $type_url = '';
        if($data['link']['sho_id']){
            $data['avatar_owner_link']  = @$data['user_owner']['logo'];
            $data['name_owner_link']    = @$data['user_owner']['sho_name'];
            $data['url_owner_link']     = @$data['user_owner']['shop_url'];

            switch ($type) {
                case 'image-link':
                    $type_share = TYPESHARE_DETAIL_SHOPLINK_IMG;
                    $type_url = 'tbtt_content_image_links';
                    break;
                
                case 'content-link':
                    $type_share = TYPESHARE_DETAIL_SHOPLINK_CONTENT;
                    $type_url = 'tbtt_content_links';
                    break;
                
                case 'library-link':
                    $type_share = TYPESHARE_DETAIL_SHOPLIBLINK;
                    $type_url = 'tbtt_lib_links';
                    break;
                
                default:
                    break;
            }
        }else if($data['link']['user_id']){
            $data['avatar_owner_link']  = @$data['user_owner']['avatar_url'];
            $data['name_owner_link']    = @$data['user_owner']['use_fullname'];
            $data['url_owner_link']     = @$data['user_owner']['profile_url'];

            switch ($type) {
                case 'image-link':
                    $type_share = TYPESHARE_DETAIL_PRFLINK_IMG;
                    $type_url = 'tbtt_content_image_links';
                    break;
                
                case 'content-link':
                    $type_share = TYPESHARE_DETAIL_PRFLINK_CONTENT;
                    $type_url = 'tbtt_content_links';
                    break;
                
                case 'library-link':
                    $type_share = TYPESHARE_DETAIL_PRFLIBLINK;
                    $type_url = 'tbtt_lib_links';
                    break;
                
                default:
                    break;
            }
        }
        
        $ogimage = $data['link']['image'] ? $data['link']['image_url'] : $data['link']['link_image'];
        $ogtitle = '';
        if($data['link']['description'] != ''){
            $ogtitle = $data['link']['description'];
        }else{
            $ogtitle = $data['link']['link_title'];
        }
        $this->load->model('like_link_model');
        $list_likes = $this->like_link_model->get('id', ['link_id' => (int) $data['link']['id'], 'tbl' => '"'.$type_url.'"']);
        $data['link']['likes'] = count($list_likes); 

        $is_like = $this->like_link_model->get('id', ['user_id' => $user_id, 'link_id' => (int) $data['link']['id'], 'tbl' => '"'.$type_url.'"']);
        $data['link']['is_like'] = count($is_like);

        //Dem share
        $jData = json_decode($this->callAPI('GET', API_LISTSHARE_LINK.'/'.$data['link']['id'], []));
        $data['link']['total_share'] = $jData->data->total_share;
        
        if($type_share != ''){
            $this->load->model('share_metatag_model');
            $get_avtShare = $this->share_metatag_model->get('*','use_id = '.$data['link']['user_id'].' AND type = '.$type_share);
            if(!empty($get_avtShare)){
                $ogimage = $get_avtShare[0]->image;
            }
        }
        $data['type_share'] = $type_share;
        $data['itemid_shr'] = $data['link']['id'];

        $data['type_link']          = $type;
        $data['aliasDomain']        = $data['url_item'];
        $data['descrSiteGlobal']    = settingDescr;
        $data['keywordsSiteGlobal'] = '';
        $data['ogurl']              = $data['url_item'] .'/links'. $data['link']['short_url'];
        $data['ogtype']             = 'website';
        $data['ogtitle']            = $ogtitle;
        $data['ogdescription']      = $data['link']['description'];
        $data['ogimage']            = $ogimage;
        $data['share_url']          = $data['ogurl'];
        $data['share_name']         = $data['ogtitle'];

        $this->load->view('home/pages/azibai-link-detail', $data);
    }

    public function create()
    {
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('is_owner', 'Thuộc về', 'require|trim');
            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('link', 'Liên kết', 'trim|strip_tags|required|url');
            $this->form_validation->set_rules('image', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video', 'Video', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('collections', 'Bộ sưu tập', 'callback_exist_collection_link');
            $this->form_validation->set_message('exist_collection_link', '%s không tồn tại.');

            if ($this->input->post('category_child')) {
                $this->form_validation->set_rules('category_child', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            } else if ($this->input->post('category_parent')) {
                $this->form_validation->set_rules('category_parent', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            }

            if ($this->input->post('is_owner') === 'shop') {
                $this->form_validation->set_rules('sho_id', 'Cửa hàng', 'callback_user_owner_shop');
                $this->form_validation->set_message('user_owner_shop', '%s không tồn tại.');
            }

            $link_insert = [
                'link' => $this->input->post('link'),
            ];
            $data_insert = [
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->form_validation->run()) {

                //check exist link
                $link_id = 0;
                if(($link = $this->link_model->find_where(['link' => $link_insert['link']]))){
                    $link_id = $link['id'];
                }else{
                    $claw_data = $this->_get_claw_data($this->input->post('link'));
                    $link_insert['link'] = strip_tags(trim($this->input->post('link')));
                    $link_insert['added_at'] = date('Y-m-d H:i:s');
                    $link_insert = array_merge($link_insert, $claw_data);
                    if($this->link_model->add_new($link_insert)){
                        $link_id = $this->db->insert_id();
                    }
                }

                if($link_id){
                    $collection_ids              = $this->input->post('collections');
                    $user_id                     = $this->session->userdata('sessionUser');
                    $data_insert['user_id']      = $user_id;
                    $data_insert['is_public']    = $this->input->post('is_private') == 'true' ? 0 : 1;
                    $data_insert['link_id']      = $link_id;
                    $data_insert['cate_link_id'] = !empty($this->input->post('category_child')) ? (int)$this->input->post('category_child') : (!empty($this->input->post('category_parent')) ? (int)$this->input->post('category_parent') : 0);
                    $data_insert['sho_id']       = (int)$this->input->post('sho_id');
                    $data_insert['image']        = $this->input->post('image');
                    $data_insert['video']        = $this->input->post('video');

                    if($this->input->post('is_owner') == 'personal'){
                        $data_insert['sho_id'] = 0;
                    }

                    if(($description = $this->input->post('detail', true))){
                        $data_insert['description'] = $description;
                    }

                    if($data_insert['image']){
                        //get info image
                        $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_insert['image']);
                        $data_insert['image'] = date('Y/m/d\/') . $data_insert['image'];
                        if(!empty($info_image)){
                            $data_insert['img_width']   = $info_image[0];
                            $data_insert['img_height']  = $info_image[1];
                            $data_insert['mime']        = $info_image['mime'];
                        }
                    }else{
                        $data_insert['image'] = '';
                    }

                    if($data_insert['video']){
                        $data_insert['video'] = date('Y/m/d\/') . $data_insert['video'];
                    }else{
                        $data_insert['video'] = '';
                    }

                    if ($this->lib_link_model->add_new($data_insert)) {
                        if (!empty($collection_ids)) {
                            $temp    = [];
                            $link_id = $this->db->insert_id();
                            foreach ($collection_ids as $index => $collection_id) {
                                $temp[$index] = [
                                    'collection_id' => $collection_id,
                                    'lib_link_id'   => $link_id,
                                ];
                            }
                            $this->collection_lib_link_model->adds($temp);
                        }

                        //remove image temp sau khi insert
                        if (!empty($data_insert['image'])) {
                            @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['image']));
                        }
                        //remove video temp sau khi insert
                        if (!empty($data_insert['video'])) {
                            @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['video']));
                        }

                        echo json_encode(['status' => 1, 'message' => 'Đã thêm liên kết.']);
                        die();
                    }
                }

                echo json_encode(['status' => 0, 'message' => 'Xảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
                die();

            } else {
                echo json_encode($this->form_validation->error_array());
            }
        }
        die();
    }

    /**
     * update library link
     * issue: link cá nhân là link cá nhân, shop là shop. Khi sửa không được chuyển đổi từ shop qua user và ngược lại
     * vd: chủ shop thêm link vô shop sau đó nhân viên sửa link shop thành link cá nhân => link này thuộc về ai ?
     * Trường nói: nhân viên shop không được thao tác với library link ? (chưa được xác thực quyền của nhân viên staff được phép làm những gì)
     */
    public function update($type)
    {
        if(!$type){
            return false;
        }
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $link_id = (int)$this->input->post('id');
            $user_id = (int)$this->session->userdata('sessionUser');
            if (!$link_id || !($link = $this->link_library->exist_link($link_id, $type))) {
                echo json_encode(['status' => 0, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            if($user_id != $link['user_id']){
                echo json_encode(['status' => 0, 'message' => 'Bạn không thể xóa liên kết của người khác.']);
                die();
            }

            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('image', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video', 'Video', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('collections', 'Bộ sưu tập', 'callback_exist_collection_link[' . (int)$this->input->post('sho_id') . ']');
            $this->form_validation->set_message('exist_collection_link', '%s không tồn tại.');

            if ($this->input->post('category_child')) {
                $this->form_validation->set_rules('category_child', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            } else if ($this->input->post('category_parent')) {
                $this->form_validation->set_rules('category_parent', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            }

            if ($this->input->post('is_owner') === 'shop') {
                $this->form_validation->set_rules('sho_id', 'Cửa hàng', 'callback_user_owner_shop');
                $this->form_validation->set_message('user_owner_shop', '%s không tồn tại.');
            }
            if ($this->form_validation->run()) {
                $collection_ids              = $this->input->post('collections');
                $data_update['cate_link_id'] = !empty($this->input->post('category_child')) ? (int)$this->input->post('category_child') : (!empty($this->input->post('category_parent')) ? (int)$this->input->post('category_parent') : 0);
                $data_update['sho_id']       = (int)$this->input->post('sho_id');
                $data_update['is_public']    = $this->input->post('is_private') == 'true' ? 0 : 1;
                $data_update['updated_at']   = date('Y-m-d H:i:s');
                $data_update['description']  = $this->input->post('detail', true);

                if(($video = $this->input->post('video'))){
                    $data_update['video'] = $video;
                }
                if(($image = $this->input->post('image'))){
                    $data_update['image'] = $image;
                }
                if ($this->input->post('is_owner') == 'personal') {
                    $data_update['sho_id'] = 0;
                }

                if(!$data_update['description']){
                    unset($data_update['description']);
                }

                if (!empty($data_update['video'])) {
                    $data_update['video'] = date('Y/m/d\/') . $data_update['video'];
                    if (empty($data_update['image'])) {
                        $data_update['image'] = '';
                        $data_update['video'] = '';
                    }
                }

                if (!empty($data_update['image'])) {
                    //get info image
                    $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_update['image']);
                    $data_update['image'] = date('Y/m/d\/') . $data_update['image'];
                    if(!empty($info_image)){
                        $data_update['img_width']   = $info_image[0];
                        $data_update['img_height']  = $info_image[1];
                        $data_update['mime']        = $info_image['mime'];
                    }

                    if(empty($data_update['video'])){
                        $data_update['video'] = '';
                    }
                }

                //dua theo tbl de update dung
                $flag_update = false;
                $post_data = [];
                if($link['type_tbl'] == 'tbtt_lib_links'){
                    if ($this->lib_link_model->update_where($data_update, ['id' => $link_id])) {
                        $post_data['library_link_id'] = $link_id;
                        $flag_update = true;
                        //chỉ delete link collection cá nhân hoặc shop.
                        $this->collection_lib_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                        if (!empty($collection_ids)) {
                            $temp = [];
                            foreach ($collection_ids as $index => $collection_id) {
                                $temp[$index] = [
                                    'collection_id' => $collection_id,
                                    'lib_link_id'   => $link_id,
                                ];
                            }
                            $this->collection_lib_link_model->adds($temp);
                        }
                    }

                }

                if($link['type_tbl'] == 'tbtt_content_links'){
                    if ($this->content_link_model->update_where($data_update, ['id' => $link_id])) {
                        $post_data['content_link_id'] = $link_id;
                        $flag_update = true;
                        //chỉ delete link collection cá nhân hoặc shop.
                        $this->collection_content_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                        if (!empty($collection_ids)) {
                            $temp = [];
                            foreach ($collection_ids as $index => $collection_id) {
                                $temp[$index] = [
                                    'collection_id'   => $collection_id,
                                    'content_link_id' => $link_id,
                                ];
                            }
                            $this->collection_content_link_model->adds($temp);
                        }
                    }
                }

                if($link['type_tbl'] == 'tbtt_content_image_links'){
                    if ($this->content_image_link_model->update_where($data_update, ['id' => $link_id])) {
                        $post_data['content_image_link_id'] = $link_id;
                        $flag_update = true;
                        //chỉ delete link collection cá nhân hoặc shop.
                        $this->collection_content_image_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                        if (!empty($collection_ids)) {
                            $temp = [];
                            foreach ($collection_ids as $index => $collection_id) {
                                $temp[$index] = [
                                    'collection_id'         => $collection_id,
                                    'content_image_link_id' => $link_id,
                                ];
                            }
                            $this->collection_content_image_link_model->adds($temp);
                        }
                    }
                }

                if ($flag_update) {
                    //remove image temp sau khi insert
                    if (!empty($data_update['image'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['image']));
                    }

                    //remove video temp sau khi insert
                    if (!empty($data_update['video'])) {
                        /*send job optimize video*/
                        curl_data(SERVER_OPTIMIZE_URL.'otp-video', $post_data,'','','POST', $this->session->userdata('token'));
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['video']));
                    }

                    $cloud_path = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
                    $response   = $this->link_library->exist_link($link_id, $type);
                    echo json_encode(['status' => 1, 'message' => 'Đã cập nhật liên kết.', 'data' => $response, 'cloud_path' => $cloud_path]);
                }else{
                    echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
                }
            } else {
                echo json_encode($this->form_validation->error_array());
            }
        }
        die();
    }

    public function save_clone()
    {
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $link_id = (int)$this->input->post('id');
            if (!($link = $this->link_model->find_link_by_id($link_id)) && $link['is_public'] == 0) {
                echo json_encode(['status' => 0, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('image', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video', 'Video', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('collections', 'Bộ sưu tập', 'callback_exist_collection_link[' . (int)$this->input->post('sho_id') . ']');
            $this->form_validation->set_message('exist_collection_link', '%s không tồn tại.');

            if ($this->input->post('category_child')) {
                $this->form_validation->set_rules('category_child', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            } else if ($this->input->post('category_parent')) {
                $this->form_validation->set_rules('category_parent', 'Danh mục', 'numeric|is_exist[tbtt_category_links.id]');
            }

            if ($this->input->post('is_owner') === 'shop') {
                $this->form_validation->set_rules('sho_id', 'Cửa hàng', 'callback_user_owner_shop');
                $this->form_validation->set_message('user_owner_shop', '%s không tồn tại.');
            }

            if ($this->form_validation->run()) {

                $user_id                    = (int)$this->session->userdata('sessionUser');
                $collection_ids             = $this->input->post('collections');
                $data_clone['cate_link_id'] = !empty($this->input->post('category_child')) ? (int)$this->input->post('category_child') : (!empty($this->input->post('category_parent')) ? (int)$this->input->post('category_parent') : 0);
                $data_clone['is_public']    = $this->input->post('is_private') == 'true' ? 0 : 1;
                $data_clone['created_at']   = date('Y-m-d H:i:s');;
                $data_clone['user_id']      = $user_id;
                $data_clone['image']        = $this->input->post('image');
                $data_clone['video']        = $this->input->post('video');
                $data_clone['description']  = $this->input->post('detail', true);
                $data_clone['sho_id']       = $this->input->post('sho_id');

                if ($this->input->post('is_owner') === 'personal') {
                    $data_clone['sho_id'] = 0;
                }

                $data_link = [
                    'link_id'       => $link['link_id'],
                    'image'         => $link['image'],
                    'img_width'     => $link['img_width'],
                    'img_height'    => $link['img_height'],
                    'orientation'   => $link['orientation'],
                    'video'         => $link['video'],
                    'description'   => $link['description'],
                ];

                $data_insert = array_replace_recursive($data_link, $data_clone);

                if (!empty($data_clone['image'])) {
                    //get info image
                    $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_clone['image']);
                    $data_insert['image'] = date('Y/m/d\/') . $data_clone['image'];
                    if(!empty($info_image)){
                        $data_insert['img_width']   = $info_image[0];
                        $data_insert['img_height']  = $info_image[1];
                        $data_insert['mime']        = $info_image['mime'];
                    }
                }

                if (empty($data_clone['image']) && !empty($link['image'])) {
                    $data_insert['image']  = date('Y/m/d\/') . preg_replace('/^\d{4}\/\d{2}\/\d{2}\/[a-zA-Z0-9]+\./', md5(date('U') . rand(1000, 10000) ) . '.', $link['image']);
                }

                if (!empty($data_clone['video'])) {
                    $data_insert['video'] = date('Y/m/d\/') . $data_clone['video'];
                }

                if(empty($data_clone['video']) && !empty($link['video'])){
                    $data_insert['video']  = date('Y/m/d\/') . preg_replace('/^\d{4}\/\d{2}\/\d{2}\/[a-zA-Z0-9]+\./', md5(date('U') . rand(1000, 10000) ) . '.', $link['video']);
                }

                if (empty($data_insert['image'])) {
                    unset($data_insert['image']);
                }

                if(!$data_insert['video']){
                    unset($data_insert['video']);
                }

                $flag_insert = false;
                $link_id     = 0;
                if ($this->lib_link_model->add_new($data_insert)) {
                    $flag_insert = true;
                    $link_id = $this->db->insert_id();
                    if (!empty($collection_ids)) {
                        $temp    = [];
                        foreach ($collection_ids as $index => $collection_id) {
                            $temp[$index] = [
                                'collection_id' => $collection_id,
                                'lib_link_id'   => $link_id,
                            ];
                        }
                        $this->collection_lib_link_model->adds($temp);
                    }
                }

                if ($flag_insert) {
                    //clone image old
                    if (empty($data_clone['image']) && !empty($link['image'])) {
                        $this->_clone_image_to_fpt($data_insert['image'], $link['image']);
                    }

                    //clone video old
                    if (empty($data_clone['video']) && !empty($link['video'])) {
                        $this->_clone_image_to_fpt($data_insert['video'], $link['video']);
                    }

                    //remove image temp sau khi insert
                    if (!empty($data_insert['image'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_insert['image']);
                    }

                    //remove video temp sau khi insert
                    if (!empty($data_insert['video'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_insert['video']);
                    }

                    $cloud_path = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
                    $response   = $this->link_library->exist_link($link_id, 'library-link');

                    echo json_encode(['status' => 1, 'message' => 'Đã ghim liên kết.', 'data' => $response, 'cloud_path' => $cloud_path]);
                }else{
                    echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
                }
            } else {
                echo json_encode($this->form_validation->error_array());
            }
        }
        die();
    }

    //thieu remove image, video
    public function destroy($id, $type, $remove = false)
    {
        if($this->isLogin() && $this->input->is_ajax_request()){
            $id = (int)$id;
            if (!$id || !$type || !($link = $this->link_library->exist_link($id, $type))){
                echo json_encode(['status' => 0, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            $flag_delete = false;
            $user_id     = (int)$this->session->userdata('sessionUser');

            if($user_id != $link['user_id']){
                echo json_encode(['status' => 0, 'message' => 'Bạn không thể xóa liên kết của người khác.']);
                die();
            }

            if($link['type_tbl'] == LINK_TABLE_LIBRARY){
                if ($this->lib_link_model->delete_where(['id' => $id])) {
                    $flag_delete = true;
                    $this->collection_lib_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                }
            }
            /*Khi xóa content link và image link chỉ ẩn hiển thị bên library, trong bài viết vẫn hiển bt */
            if(!$remove && $link['type_tbl'] == LINK_TABLE_CONTENT) {
                if ($this->content_link_model->update_where(['show_in_library' => 0], ['id' => $id])) {
                    $flag_delete = true;
                }
            }else if($remove && $link['type_tbl'] == LINK_TABLE_CONTENT){
                if ($this->content_link_model->delete_where(['id' => $id])) {
                    $flag_delete = true;
                    $this->collection_content_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                }
            }

            if(!$remove && $link['type_tbl'] == LINK_TABLE_IMAGE) {
                if ($this->content_image_link_model->update_where(['show_in_library' => 0], ['id' => $id])) {
                    $flag_delete = true;
                }
            }else if($remove && $link['type_tbl'] == LINK_TABLE_IMAGE){
                if ($this->content_image_link_model->delete_where(['id' => $id])) {
                    $flag_delete = true;
                    $this->collection_content_image_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                }
            }

            if($flag_delete){
                echo json_encode(['status' => 1, 'message' => 'Đã xóa liên kết.', 'id' => $id, 'type' => $type]);
            }else{
                echo json_encode(['status' => 0, 'message' => 'Xảy ra lỗi trong quá trình thực hiện vui lòng thử lại.']);
            }
        }
        die();
    }

    /**
     * @param $id
     * get full info library link
     */
    public function info_link($id, $type)
    {
        //còn thiếu collections
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $id = (int)$id;
            if (!$id || !$type || !($link = $this->link_library->exist_link($id, $type))) {
                echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                die();
            }
            $user_id  = (int)$this->session->userdata('sessionUser');
            $group_id = (int)$this->session->userdata('sessionGroup');
            $is_owner = false;

            //nếu có shop id thì check có sở hữu link này hay ko ?
            if ($link['sho_id']) {
                $my_shops = $this->shop_model->get_shop_by_user($user_id, $group_id);
                if (!empty($my_shops)) {
                    $my_shops = array_to_array_keys($my_shops, 'sho_id');
                    if (!in_array($link['sho_id'], $my_shops)) {
                        echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                        die();
                    }
                    $is_owner = true;
                } else {
                    echo json_encode(['status' => false, 'message' => 'Gian hàng không tồn tại.']);
                    die();
                }
            }

            //cá nhân: current user có sở h,ữu link này không
            if (!$link['sho_id']) {
                if ($link['user_id'] != $user_id) {
                    echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                    die();
                }
                $is_owner = true;
            }

            if ($link['image']) {
                $link['image'] = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['image'];
            }

            if ($link['video']) {
                $link['video'] = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['video'];
            }

            if ($link['cate_link_id']) {
                $category_current         = $this->category_link_model->get_category_by_id($link['cate_link_id']);
                $link['category_current'] = $category_current;
                if ($category_current['parent_id']) {
                    $link['category_parent'] = [
                        'id' => $category_current['parent_id'],
                        'name' => $category_current['parent_name'],
                        'slug' => $category_current['parent_slug'],
                    ];
                } else {
                    $link['category_parent'] = $category_current;
                }
            }

            if($type == 'library-link'){
                $link['collections'] = $this->collection_lib_link_model->link_belong_to_many_collections($link['id'], $link['sho_id'], $link['user_id'], $is_owner);
            }

            if($type == 'content-link'){
                $link['collections'] = $this->collection_content_link_model->link_belong_to_many_collections($link['id'], $link['sho_id'], $link['user_id'], $is_owner);
            }

            if($type == 'image-link'){
                $link['collections'] = $this->collection_content_image_link_model->link_belong_to_many_collections($link['id'], $link['sho_id'], $link['user_id'], $is_owner);
            }

            echo json_encode([
                'status'        => true,
                'message'       => 'Has data.',
                'data'          => $link,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK );
            die();
        }
        die();
    }

    /**
     * @param $id
     * get full info library link
     */
    public function clone_link($id, $type)
    {
        $id = (int)$id;
        //còn thiếu collections
        if ($type && $this->isLogin() && $this->input->is_ajax_request()) {
            if($type == 'library-link'){
                $link = $this->lib_link_model->find_link_by_id($id, false);
            }
            if($type == 'content-link'){
                $link = $this->content_link_model->find_link_by_id($id, false);
            }
            if($type == 'image-link'){
                $link = $this->content_image_link_model->find_link_by_id($id, false);
            }

            if (empty($link)) {
                echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            if ($link['user_id'] == (int)$this->session->userdata('sessionUser')) {
                echo json_encode(['status' => false, 'message' => 'Bạn đã ghim liên kết này.']);
                die();
            }

            if ($link['image']) {
                $link['image_url'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $link['image'];
            }

            if ($link['video']) {
                $link['video_url'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $link['video'];
            }

            $link['sho_id']         = 0;
            $link['user_id']        = 0;

            if ($link['cate_link_id']) {
                $category_current         = $this->category_link_model->get_category_by_id($link['cate_link_id']);
                $link['category_current'] = $category_current;
                if ($category_current['parent_id']) {
                    $link['category_parent'] = [
                        'id' => $category_current['parent_id'],
                        'name' => $category_current['parent_name'],
                        'slug' => $category_current['parent_slug'],
                    ];
                } else {
                    $link['category_parent'] = $category_current;
                }
            }

            echo json_encode(['status' => true, 'message' => 'Has data.', 'data' => $link]);
            die();
        }
        die();
    }

    public function links_common($id)
    {

        if(!$this->input->is_ajax_request() || !$id || !($links = $this->link_model->all_clone_link($id))){
            echo json_encode(['status' => false, 'message' => 'Không có dữ liệu.']);
        }

        if(!empty($links)){
            foreach ($links as $key => $link) {
                $links[$key]['owner']      = $this->link_library->get_owner($link);
                $dis_start = date_create_from_format('Y-m-d H:i:s', $link['created_at']);
                $links[$key]['created_at'] = ($dis_start ? date_format($dis_start, 'H:i d-m-Y') : '');
                if($link['type_tbl'] == LINK_TABLE_LIBRARY){
                    $links[$key]['short_url'] = 'library-link/' . $link['id'];
                }
                if($link['type_tbl'] == LINK_TABLE_CONTENT){
                    $links[$key]['short_url'] = 'content-link/' . $link['id'];
                }
                if($link['type_tbl'] == LINK_TABLE_IMAGE){
                    $links[$key]['short_url'] = 'image-link/' . $link['id'];
                }
            }
        }

        echo json_encode([
            'status' => true,
            'message' => 'Có dữ liệu.',
            'data' => $links
        ]);
        die();
    }

    /**
     * @param $collection_id
     * cho chọn thêm (số nhiều) vào chỉ album cá nhân hoặc album shop đang sở hữu
     * issue: 1 liên kết vừa nằm ở album shop vừa nằm ở album cá nhân => cá nhân xóa shop mất và ngược lại
     */
    public function exist_collection_link($collection_ids, $shop_id = 0)
    {
        if (!$collection_ids || empty($collection_ids))
            return true;

        if(!is_array($collection_ids)){
            return false;
        }

        $user_id  = (int)$this->session->userdata('sessionUser');
        $group_id = (int)$this->session->userdata('sessionGroup');
        $my_shop  = [];

        if ($this->input->post('is_owner') === 'shop' || ($this->input->post('is_owner') === 'shop' && $shop_id)) {
            $my_shop = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $my_shop = array_to_array_keys($my_shop, 'sho_id');
            if (empty($my_shop)) {
                return false;
            }
            $user_id = 0;
        }

        $collections = $this->collection_model->my_collections($user_id, $my_shop, $collection_ids);

        if (empty($collections) || (sizeof($collection_ids) != sizeof($collections))) {
            return false;
        }
        return true;
    }

    public function user_owner_shop($sho_id = 0, $user_id = 0, $group_id = 0)
    {
        if ($this->input->post('is_owner') === 'shop' || $sho_id) {

            if (!$sho_id)
                $sho_id = (int)$this->input->post('sho_id');

            if (!$user_id)
                $user_id = (int)$this->session->userdata('sessionUser');

            if (!$group_id)
                $group_id = (int)$this->session->userdata('sessionGroup');

            if (!$sho_id || !$user_id || !$group_id) {
                return false;
            }

            $my_shops = $this->shop_model->get_shop_by_user($user_id, $group_id);
            $my_shops = array_to_array_keys($my_shops, 'sho_id');
            if (empty($my_shops) || !in_array($sho_id, $my_shops)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $url
     * @return array
     * claw data from url
     */
    private function _get_claw_data($url)
    {
        $result = [];
        if (!$url) {
            return $result;
        }
        $data_crawl = getUrlMeta($url);
        if (!empty($data_crawl)) {
            //nếu có image up thì lấy image size của image up
            if (!empty($data_crawl['image'])) {
                $result['image'] = $data_crawl['image'];
                list($width, $height) = @getimagesize($data_crawl['image']);
                $result['img_width']  = $width;
                $result['img_height'] = $height;
            }
            if (!empty($data_crawl['title'])) {
                $result['title'] = strip_tags(trim($data_crawl['title']));
            }
            if (!empty($data_crawl['description'])) {
                $result['description'] = strip_tags(trim($data_crawl['description']));
            }
            $urlData        = parse_url($url);
            $result['host'] = str_replace('www.', '', $urlData['host']);
        }
        return $result;
    }

    public function exist_link_clone($id)
    {
        if (!$id || !($link = $this->link_model->find_link_by_id($id, true))) {
            return false;
        }

        if($link['is_public'] == 0){
            return false;
        }

        if($link['image']){
            $link['image_url'] =  $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['image'];
        }
        if($link['video']){
            $link['video_url'] =  $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['video'];
        }

        return $link;
    }

    /**
     * @return bool
     */
    public function validate_upload_media()
    {
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $config = $this->config->item('library_link_config');
            $this->_upload_temp('media_file', $config);
        }
        die();
    }

    /**
     * @param $image_name
     * @return bool
     * check exist image|video in folder temp
     */
    public function exist_image($image_name)
    {
        if (!$image_name)
            return true;

        $config = $this->config->item('library_link_config');
        if (!file_exists($config['upload_path_temp'] . '/' . $image_name)) {
            return false;
        }
        return true;
    }

    /**
     * @param $name_input_file
     * @param $config
     * upload image library link to folder temp_image
     * validate success upload to ftp
     */
    private function _upload_temp($name_input_file, $config)
    {
        $this->load->library('upload');
        $this->load->config('config_upload');

        if (!is_dir($config['upload_path_temp'])) {
            @mkdir($config['upload_path_temp'], 0777, true);
            $this->load->helper('file');
            @write_file($config['upload_path_temp'] . '/index.html', '<p>Directory access is forbidden.</p>');
        }
        $config['upload_path'] = $config['upload_path_temp'];
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name_input_file) && ($uploadData = $this->upload->data())) {
            $image_co = $uploadData['file_name'];

            $response = [
                'image_url'     => azibai_url() . '/' . $config['upload_path_temp'] . '/' . $image_co,
                'image_name'    => $image_co,
                'video_url'     => null,
                'video_name'    => null,
                'message'       => 'success',
                'status'        => 1,
            ];

            //is video file
            if(preg_match('/^video\/.+/', $uploadData['file_type'])){
                //create thumb image for video
                $ffmpeg = 'ffmpeg';
                $video  = $uploadData['full_path'];
                //where to save the image
                $tmp_thumb_video = $uploadData['file_path'] . $uploadData['raw_name'] .'.jpg';
                //time to take screen shot at
                $interval        = 1;
                //ffmpeg command
                $cmd_generate_thumb = "$ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y $tmp_thumb_video 2>&1";
                shell_exec($cmd_generate_thumb);
                if (file_exists( $config['upload_path_temp'] .'/'. $uploadData['raw_name'] .'.jpg')) {
                    $this->_move_image_to_fpt(date('Y/m/d\/') . $uploadData['raw_name'] .'.jpg');
                    $response['image_name'] = $uploadData['raw_name'] .'.jpg';
                    $response['image_url'] = azibai_url() . '/' . $config['upload_path_temp'] . '/' . $uploadData['raw_name'] .'.jpg';
                }
                $response['video_url'] = azibai_url() . '/' . $config['upload_path_temp'] . '/' . $uploadData['file_name'];
                $response['video_name'] = $uploadData['file_name'];
            }

            //upload to ftp
            $this->_move_image_to_fpt(date('Y/m/d\/') . $image_co);

            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            echo json_encode([
                'status' => 0,
                'message' => $this->upload->display_errors('', '')
            ]);
        }
        die();
    }

    private function _move_image_to_fpt($image_name)
    {
        $this->load->config('config_upload');
        $this->load->library(['ftp', 'upload']);

        //split directory type "Y/m/d"
        $dir_image = substr($image_name,0,strrpos($image_name, '/'));

        $config = $this->config->item('library_link_config');
        $this->ftp->connect($this->config->item('configftp'));

        $pathTargetC = $this->config->item('cloud_library_link_config')['upload_path'];
        $source_path = $config['upload_path_temp'] . '/' . substr($image_name, (strrpos($image_name, '/') + 1));
        $target_path = $pathTargetC . $image_name;
        $listdir     = $this->ftp->list_files($pathTargetC . $dir_image);

        if (!$listdir) {
            $temp_dir   = explode('/', $dir_image);
            $temp_dir_2 = '';
            if (!empty($temp_dir) && is_array($temp_dir)) {
                foreach ($temp_dir as $key => $dir) {
                    if ($key == 0) {
                        $temp_dir_2 .= $dir;
                    } else {
                        $temp_dir_2 .= '/' . $dir;
                    }
                    $this->ftp->mkdir($pathTargetC . $temp_dir_2, 0775);
                }
            } else {
                $this->ftp->mkdir($pathTargetC . $dir_image, 0775);
            }
        }
        $this->ftp->upload($source_path, $target_path, 'auto', 0775);
        $this->ftp->close();
    }

    private function _clone_image_to_fpt($image_name, $image_clone)
    {
        $this->load->config('config_upload');
        $this->load->library(['ftp', 'upload']);

        //split directory type "Y/m/d"
        $dir_image = substr($image_name,0,strrpos($image_name, '/'));

        $config = $this->config->item('library_link_config');
        $this->ftp->connect($this->config->item('configftp'));

        $pathTargetC = $this->config->item('cloud_library_link_config')['upload_path'];
        $source_path = $config['upload_path_temp'] . '/' . substr($image_name, (strrpos($image_name, '/') + 1));
        $target_path = $pathTargetC  . $image_name;
        $listdir     = $this->ftp->list_files($pathTargetC . $dir_image);

        if (empty($listdir)) {
            $temp_dir   = explode('/', $dir_image);
            $temp_dir_2 = '';
            if (!empty($temp_dir) && is_array($temp_dir)) {
                foreach ($temp_dir as $key => $dir) {
                    if ($key == 0) {
                        $temp_dir_2 .= $dir;
                    } else {
                        $temp_dir_2 .= '/' . $dir;
                    }
                    $this->ftp->mkdir($pathTargetC . $temp_dir_2, 0775);
                }
            } else {
                $this->ftp->mkdir($pathTargetC . $dir_image, 0775);
            }
        }

        $this->ftp->ftp_copy($pathTargetC . $image_clone, $target_path, $source_path);
        $this->ftp->close();
    }

    /**
     * @param $sho_id
     * @param $cat_ids
     * @param int $owner_id
     * @param array $options
     * @return array
     */
    private function _get_library_links($cat_id = 0, $is_parent = false, $options = [])
    {
        $params = ['limit', 'page', 'start'];
        if(!empty($options)){
            foreach ($params as $param) {
                if(isset($options[$param])){
                    ${$param} = $options[$param];
                }
            }
        }

        if(!isset($page))
            $page = $this->input->post('page');

        if ($page < 1)
            $page = 1;

        if(!isset($limit))
            $limit = 20;

        $page = (int)$page;

        if(!isset($start))
            $start = ($limit * (int)$page) - $limit;

        return $this->link_model->azibai_links($cat_id, $is_parent, $start, $limit);
    }

    /**
     * @param string $view_default
     * @return mixed|string
     * replace $_GET // $_GET is turn off
     */
    private function _view_type($view_default = 'grid')
    {
        $list_view = [
            'grid'      => 'grid',
            'list'      => 'list',
            'line'      => 'line',
        ];
        $view1 = !empty($_REQUEST['view']) ? $_REQUEST['view'] : $view_default;
        $view1 = trim(strip_tags($view1));
        if(in_array($view1, $list_view)){
            return $view1;
        }
        return false;
    }

    private function _convert_min_max($link_id, $max = true)
    {
        $sql = 'SELECT tmp.id, tmp.type_tbl, tmp.created_at
                FROM (
                    SELECT id, "tbtt_lib_links" AS type_tbl, 1 AS show_in_library, created_at, is_public, link_id FROM tbtt_lib_links
                    UNION ALL
                    SELECT id, "tbtt_content_links" AS type_tbl, show_in_library, created_at, is_public, link_id FROM tbtt_content_links
                    UNION ALL 
                    SELECT id, "tbtt_content_image_links" AS type_tbl, show_in_library, created_at, is_public, link_id FROM tbtt_content_image_links
                ) as tmp
                JOIN tbtt_links as l ON tmp.link_id = l.id 
                WHERE l.id = '.$link_id.' AND tmp.is_public = 1 AND tmp.show_in_library = 1
                ORDER BY tmp.created_at '.($max ? 'DESC' : 'ASC').' LIMIT 1; 
                ';

        return $this->db->query($sql)->row_array();
    }

    public function convert_min_max()
    {
        if(!($page = (int)$_REQUEST['page'])){
            die();
        }
        $limit = 200;

        $start = ($page - 1) * $limit;

        $result = $this->link_model->gets([
            'type' => 'array',
            'orderby' => 'added_at',
            'start' => $start,
            'limit' => $limit,

        ]);

        $update_links = [];
        if (!empty($result)){
            foreach ($result as $item) {
                $find_max = $this->_convert_min_max($item['id']);
                $find_min = $this->_convert_min_max($item['id'], false);
                if (!empty($find_max)){
                    $this->link_model->update_where([
                        'min_id' => $find_min['id'],
                        'tbl_min' => $find_min['type_tbl'],
                        'tbl_min_time' => $find_min['created_at'],
                        'max_id' => $find_max['id'],
                        'tbl_max' => $find_max['type_tbl'],
                        'tbl_max_time' => $find_max['created_at'],
                    ], ['id' => $item['id']]);
                }
            }
        }else{
            echo 'hết 1111111111111111111111111';
        }

    }
}