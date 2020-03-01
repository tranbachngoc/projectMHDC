<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#****************************************#
# * @Author: hthanhbmt                   #
# * @Email: hthanhbmt@gmail.com          #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Library_link extends MY_Controller
{
    private $shop_url       = '';
    private $shop_current   = '';
    private $mainURL        = '';

    function __construct()
    {
        parent::__construct();
        $this->lang->load('form_validation', 'vietnamese');
        $this->load->model('library_link_model');
        $this->load->model('collection_link_model');
        $this->load->model('collection_model');
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $this->load->config('config_upload');

        if(is_domain_shop()){
            $this->shop_current   = MY_Loader::$static_data['hook_shop'];
            $data['shop_current'] = $this->shop_current;
            $data['shop_url']     = $this->shop_url;
        }
        $data['mainURL']        = $this->mainURL;

    }

    public function create()
    {
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('is_owner', 'Thuộc về', 'require|trim');
            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('save_link', 'Liên kết', 'trim|strip_tags|required|url');
            $this->form_validation->set_rules('image_path', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video_path', 'Video', 'trim|strip_tag|callback_exist_image');
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

            if ($this->form_validation->run()) {
                $data_insert                     = $this->form_validation->get_post_data();
                $data_update['created_by']       = $this->session->userdata('sessionUser');
                $collection_ids                  = $data_insert['collections'];
                $data_insert                     = array_merge($data_insert, $this->_get_claw_data($data_insert['save_link']));
                $data_insert['category_link_id'] = !empty($data_insert['category_child']) ? (int)$data_insert['category_child'] : (!empty($data_insert['category_parent']) ? (int)$data_insert['category_parent'] : 0);
                $data_insert['status']           = $this->input->post('is_private') === 'true' ? 0 : 1;
                $data_insert['user_id']          = $this->session->userdata('sessionUser');
                $data_insert                     = $this->library_link_model->pass_column($data_insert);

                if (empty($data_insert['sho_id'])) {
                    $data_insert['sho_id'] = 0;
                }

                if($data_insert['image_path']){
                    $data_insert['image_path'] = date('Y/m/d\/') . $data_insert['image_path'];
                    $data_insert['media_type'] = 'image';
                    //get info image
                    $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_insert['image_path']);
                    if(!empty($info_image)){
                        $data_insert['image_width']  = $info_image[0];
                        $data_insert['image_height'] = $info_image[1];
                    }
                }else{
                    $data_insert['image_path'] = '';
                }

                if($data_insert['video_path']){
                    $data_insert['video_path'] = date('Y/m/d\/') . $data_insert['video_path'];
                    $data_insert['media_type'] = 'video';
                }else{
                    $data_insert['video_path'] = '';
                }

                if(!$data_insert['detail']){
                    $data_insert['detail'] = '';
                }

                if ($this->library_link_model->add_new($data_insert)) {
                    if (!empty($collection_ids)) {
                        $temp    = [];
                        $link_id = $this->db->insert_id();
                        foreach ($collection_ids as $index => $collection_id) {
                            $temp[$index] = [
                                'cl_coll_id'      => $collection_id,
                                'cl_user_id'      => $this->session->userdata('sessionUser'),
                                'library_link_id' => $link_id,
                            ];
                        }
                        $this->collection_link_model->adds($temp);
                    }

                    //remove image temp sau khi insert
                    if (!empty($data_insert['image_path'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['image_path']));
                    }
                    //remove video temp sau khi insert
                    if (!empty($data_insert['video_path'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_insert['video_path']));
                    }

                    echo json_encode(['status' => 1, 'message' => 'Đã thêm liên kết.']);
                    die();
                }
                echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
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
    public function update()
    {
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $link_id = (int)$this->input->post('id');
            if (!($link = $this->exist_library_link($link_id))) {
                echo json_encode(['status' => 0, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('image_path', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video_path', 'Video', 'trim|strip_tag|callback_exist_image');
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
                $data_update                     = $this->form_validation->get_post_data();
                if ($this->input->post('is_owner') === 'personal') {
                    $data_update['sho_id'] = 0;
                }

                $collection_ids                  = $data_update['collections'];
                $data_update['category_link_id'] = !empty($data_update['category_child']) ? (int)$data_update['category_child'] : (!empty($data_update['category_parent']) ? (int)$data_update['category_parent'] : 0);
                $data_update['status']           = $this->input->post('is_private') === 'true' ? 0 : 1;
                $data_update['updated_by']       = $this->session->userdata('sessionUser');
                $data_update['updated_at']       = date('Y-m-d H:i:s');
                $data_update                     = $this->library_link_model->pass_column($data_update);
                $user_id                         = (int)$this->session->userdata('sessionUser');

                if (!empty($data_update['image_path']) && ($link['image_path'] != $data_update['image_path'])) {
                    $data_update['image_path'] = date('Y/m/d\/') . $data_update['image_path'];
                    $data_update['media_type'] = 'image';
                    //get info image
                    $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_update['image_path']);
                    if(!empty($info_image)){
                        $data_update['image_width']  = $info_image[0];
                        $data_update['image_height'] = $info_image[1];
                    }
                }

                if(!$data_update['image_path']){
                    unset($data_update['image_path']);
                }

                if(!$data_update['detail']){
                    unset($data_update['detail']);
                }

                if (!empty($data_update['video_path']) && ($link['video_path'] != $data_update['video_path'])) {
                    $data_update['video_path'] = date('Y/m/d\/') . $data_update['video_path'];
                    $data_update['media_type'] = 'video';
                }

                if(!$data_update['video_path']){
                    unset($data_update['video_path']);
                }

                if ($this->library_link_model->update_where($data_update, ['id' => $link_id])) {
                    //chỉ delete link collection cá nhân hoặc shop.
                    $this->collection_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                    if (!empty($collection_ids)) {
                        $temp = [];
                        foreach ($collection_ids as $index => $collection_id) {
                            $temp[$index] = [
                                'cl_coll_id'        => $collection_id,
                                'cl_user_id'        => $user_id,
                                'library_link_id'   => $link_id,
                            ];
                        }
                        $this->collection_link_model->adds($temp);
                    }

                    //remove image temp sau khi insert
                    if (!empty($data_update['image_path'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['image_path']));
                    }

                    //remove video temp sau khi insert
                    if (!empty($data_update['video_path'])) {
                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_update['video_path']));
                    }

                    $cloud_path = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
                    $response = $this->library_link_model->info_link($link_id, ['select' => 'id, image, image_path, video_path, image_width, image_height, media_type']);

                    echo json_encode(['status' => 1, 'message' => 'Đã cập nhật liên kết.', 'data' => $response, 'cloud_path' => $cloud_path]);
                    die();
                }
                echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
                die();

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
            if (!($link = $this->exist_library_link_clone($link_id))) {
                echo json_encode(['status' => 0, 'message' => 'Liên kết không tồn tại.']);
                die();
            }

            $this->form_validation->set_rules('detail', 'Nội dung', 'trim|strip_tags');
            $this->form_validation->set_rules('image_path', 'Hình ảnh', 'trim|strip_tag|callback_exist_image');
            $this->form_validation->set_rules('video_path', 'Video', 'trim|strip_tag|callback_exist_image');
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
                $data_clone                     = $this->form_validation->get_post_data();
                if ($this->input->post('is_owner') === 'personal') {
                    $data_clone['sho_id'] = 0;
                }

                $user_id                        = (int)$this->session->userdata('sessionUser');
                $collection_ids                 = $data_clone['collections'];
                $data_clone['category_link_id'] = !empty($data_clone['category_child']) ? (int)$data_clone['category_child'] : (!empty($data_clone['category_parent']) ? (int)$data_clone['category_parent'] : 0);
                $data_clone['status']           = $this->input->post('is_private') === 'true' ? 0 : 1;
                $data_clone['created_by']       = $user_id;
                $data_clone['user_id']          = $user_id;

                $data_insert = array_replace_recursive($link, $data_clone);
                $data_insert = $this->library_link_model->pass_column($data_insert);

                if (!empty($data_clone['image_path']) && ($link['image_path'] != $data_clone['image_path'])) {
                    $data_insert['image_path'] = date('Y/m/d\/') . $data_clone['image_path'];
                    $data_insert['media_type'] = 'image';
                    //get info image
                    $info_image = @getimagesize($this->config->item('library_link_config')['upload_path_temp'] .'/'. $data_clone['image_path']);
                    if(!empty($info_image)){
                        $data_insert['image_width']  = $info_image[0];
                        $data_insert['image_height'] = $info_image[1];
                    }
                }

                if (empty($data_clone['image_path'])) {
                    unset($data_clone['image_path']);
                }

                if (empty($data_clone['image_path']) && !empty($link['image_path'])) {
                    $data_insert['image_path']  = date('Y/m/d\/') . preg_replace('/^\d{4}\/\d{2}\/\d{2}\/[a-zA-Z0-9]+\./', md5(date('U') . rand(1000, 10000) ) . '.',$link['image_path']);
                }

                if (!empty($data_clone['video_path'])) {
                    $data_insert['video_path'] = date('Y/m/d\/') . $data_clone['video_path'];
                    $data_insert['media_type'] = 'video';
                }

                if(empty($data_clone['video_path']) && !empty($link['video_path'])){
                    $data_insert['video_path']  = date('Y/m/d\/') . preg_replace('/^\d{4}\/\d{2}\/\d{2}\/[a-zA-Z0-9]+\./', md5(date('U') . rand(1000, 10000) ) . '.',$link['video_path']);
                    $data_insert['media_type'] = 'video';
                }

                if(!$data_insert['video_path']){
                    unset($data_insert['video_path']);
                    $data_insert['media_type'] = '';
                }

                if ($this->library_link_model->add_new($data_insert)) {
                    if (!empty($collection_ids)) {
                        $temp    = [];
                        $link_id = $this->db->insert_id();
                        foreach ($collection_ids as $index => $collection_id) {
                            $temp[$index] = [
                                'cl_coll_id'        => $collection_id,
                                'cl_user_id'        => $user_id,
                                'library_link_id'   => $link_id,
                            ];
                        }
                        $this->collection_link_model->adds($temp);
                    }

                    //clone image old
                    if (empty($data_clone['image_path']) && !empty($link['image_path'])) {
                        $this->_clone_image_to_fpt($data_insert['image_path'], $link['image_path']);
                    }

                    //clone video old
                    if (empty($data_clone['video_path']) && !empty($link['video_path'])) {
                        $this->_clone_image_to_fpt($data_insert['video_path'], $link['video_path']);
                    }

//                    //remove image temp sau khi insert
//                    if (!empty($data_clone['image_path'])) {
//                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_clone['image_path']));
//                    }
//
//                    //remove video temp sau khi insert
//                    if (!empty($data_clone['video_path'])) {
//                        @unlink($this->config->item('library_link_config')['upload_path_temp'] .'/'. ltrim(date('Y/m/d\/'), $data_clone['video_path']));
//                    }

                    $cloud_path = $this->config->item('library_link_config')['cloud_server_show_path'] . '/';
                    $response = $this->library_link_model->info_link($link_id, ['select' => 'id, image, image_path, video_path, image_width, image_height, media_type']);

                    echo json_encode(['status' => 1, 'message' => 'Đã ghim liên kết.', 'data' => $response, 'cloud_path' => $cloud_path]);
                    die();
                }
                echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.', 'query' => $this->db->last_query()]);
                die();

            } else {
                echo json_encode($this->form_validation->error_array());
            }
        }
        die();
    }

    public function destroy($id)
    {
        if($this->isLogin() && $this->input->is_ajax_request()){
            $id = (int)$id;
            if (($link = $this->exist_library_link($id))){
                if($this->library_link_model->delete_where(['id' => $id])){
                    $user_id = (int)$this->session->userdata('sessionUser');
                    $this->collection_link_model->delete_link_in_collection_by($link['id'], $link['sho_id'], $link['sho_id'] ? 0 : $user_id);
                    echo json_encode(['status' => 1, 'message' => 'Đã xóa liên kết.']);
                    die();
                }
                echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình thực hiện vui lòng thử lại.']);
            }
        }
        die();
    }

    /**
     * @param $id
     * get full info library link
     */
    public function info_link($id)
    {
        //còn thiếu collections
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $id = (int)$id;
            if (!$id || !($link = $this->library_link_model->info_link($id))) {
                echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                die();
            }
            $this->load->model('category_link_model');
            $this->load->model('collection_link_model');
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

            //cá nhân: current user có sở hữu link này không
            if (!$link['sho_id']) {
                if ($link['user_id'] != $user_id) {
                    echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                    die();
                }
                $is_owner = true;
            }

            if ($link['image_path']) {
                $link['image_path'] = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['image_path'];
            }

            if ($link['video_path']) {
                $link['video_path'] = $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['video_path'];
            }

            if ($link['category_link_id']) {
                $category_current         = $this->category_link_model->get_category_by_id($link['category_link_id']);
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
            $link['collections'] = $this->collection_link_model->link_belong_to_many_collections($link['id'], $link['sho_id'], $link['user_id'], $is_owner);

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
    public function clone_link($id)
    {
        //còn thiếu collections
        if ($this->isLogin() && $this->input->is_ajax_request()) {
            $id = (int)$id;
            if (!$id || !($link = $this->library_link_model->info_link($id))) {
                echo json_encode(['status' => false, 'message' => 'Liên kết không tồn tại.']);
                die();
            }
            $this->load->model('category_link_model');
            $user_id  = (int)$this->session->userdata('sessionUser');

            if ($link['user_id'] == $user_id) {
                echo json_encode(['status' => false, 'message' => 'Bạn đã ghim liên kết này.']);
                die();
            }

            if ($link['image_path']) {
                $link['image_url'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $link['image_path'];
            }

            if ($link['video_path']) {
                $link['video_url'] = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $link['video_path'];
            }

            $link['sho_id']         = 0;
            $link['user_id']        = 0;
            $link['custom_link_id'] = 0;
            $link['created_by']     = 0;
            $link['updated_by']     = 0;
            $link['not_id']         = 0;
            $link['detail']         = '';

            if ($link['category_link_id']) {
                $category_current         = $this->category_link_model->get_category_by_id($link['category_link_id']);
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
                $result['image_width']  = $width;
                $result['image_height'] = $height;
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

    public function exist_library_link($id)
    {
        if (!$id || !($link = $this->library_link_model->info_link($id))) {
            return false;
        }

        //nếu library link là của shop thì check user đó có sở hữu shop hoặc là nhân viên của shop đó không ?
        if ($link['sho_id']) {
            if(!$this->user_owner_shop($link['sho_id'])){
                return false;
            }
        }else{
            //nếu là link cá nhân
            if($link['user_id'] != $this->session->userdata('sessionUser')){
                return false;
            }
        }
        return $link;
    }

    public function exist_library_link_clone($id)
    {
        if (!$id || !($link = $this->library_link_model->info_link($id))) {
            return false;
        }

        if($link['status'] == 0){
            return false;
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
                $ffmpeg          = '/usr/local/bin/ffmpeg';
                $video           = $uploadData['full_path'];
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
}