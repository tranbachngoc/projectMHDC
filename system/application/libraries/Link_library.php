<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: hthan
 * Date: 05/14/2019
 * Time: 10:59 PM
 */

/***-----Lưu ý có 3 loại link: library_link, content_link, content_image_link --------***/
class Link_library
{
    protected $CI;

    function __construct()
    {
        if(!$this->CI){
            $this->CI =& get_instance();
        }
        $this->CI->load->config('config_upload');
        $this->CI->load->helper('theme');
        $this->CI->load->model('user_model');
        $this->CI->load->model('shop_model');
        $this->CI->load->model('category_link_model');
        $this->CI->load->model('link_model');
        $this->CI->load->model('lib_link_model');
        $this->CI->load->model('content_link_model');
        $this->CI->load->model('content_image_link_model');
        $this->CI->load->model('collection_lib_link_model');
        $this->CI->load->model('collection_content_link_model');
        $this->CI->load->model('collection_content_image_link_model');
    }

    /**
     * Get link same collection id
     *
     * @param $link_id
     * @param $type
     * @param int $shop_id
     * @param int $user_id
     * @param bool $is_owner
     * @return array
     */
    public function links_same_collection($link_id, $type, $shop_id = 0, $user_id = 0, $is_owner = false)
    {
        //liên kết cùng bộ sưu tập
        $links_collection = [];
        if($type == 'library-link'){
            $data['link']['collections'] = $this->CI->collection_lib_link_model->link_belong_to_many_collections($link_id, $shop_id, $user_id,$is_owner);
            if(!empty($data['link']['collections'])){
                $temp_collection_ids = array_to_array_keys($data['link']['collections'], 'id');
                $links_collection    = $this->CI->lib_link_model->links_of_collection($temp_collection_ids, $shop_id, 0, $link_id,$is_owner, 30);
            }
        }

        if($type == 'content-link'){
            $data['link']['collections'] = $this->CI->collection_content_link_model->link_belong_to_many_collections($link_id, $shop_id, $user_id,$is_owner);
            if(!empty($data['link']['collections'])){
                $temp_collection_ids = array_to_array_keys($data['link']['collections'], 'id');
                $links_collection    = $this->CI->content_link_model->links_of_collection($temp_collection_ids, $shop_id, 0, $link_id,$is_owner, 30);
            }
        }

        if($type == 'image-link'){
            $data['link']['collections'] = $this->CI->collection_content_image_link_model->link_belong_to_many_collections($link_id, $shop_id, $user_id,$is_owner);
            if(!empty($data['link']['collections'])){
                $temp_collection_ids = array_to_array_keys($data['link']['collections'], 'id');
                $links_collection    = $this->CI->content_image_link_model->links_of_collection($temp_collection_ids, $shop_id, 0, $link_id,$is_owner, 30);
            }
        }

        return $links_collection;
    }

    /**
     * Get info link
     *
     * @param $id
     * @param $type
     * @return array
     */
    public function exist_link($id, $type)
    {
        if (!$id || !$type) {
            return [];
        }

        if($type == 'library-link' && !($link = $this->CI->lib_link_model->find_link_by_id($id, true))){
            return [];
        }

        if($type == 'content-link' && !($link = $this->CI->content_link_model->find_link_by_id($id, true))){
            return [];
        }

        if($type == 'image-link' && !($link = $this->CI->content_image_link_model->find_link_by_id($id, true))){
            return [];
        }

        if($link['image']){
            $link['image_url'] =  $this->CI->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['image'];
        }
        if($link['video']){
            $link['video_url'] =  $this->CI->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link['video'];
        }

        if($link['type_tbl'] == LINK_TABLE_LIBRARY){
            $link['short_url'] = '/library-link/' . $link['id'];
        }
        if($link['type_tbl'] == LINK_TABLE_CONTENT){
            $link['short_url'] = '/content-link/' . $link['id'];
        }
        if($link['type_tbl'] == LINK_TABLE_IMAGE){
            $link['short_url'] = '/image-link/' . $link['id'];
        }

        return $link;
    }

    /**
     * Get link same news
     *
     * @param $new_id
     * @param $type
     * @param $shop_id
     * @param $user_id
     * @param $link_id_expel
     * @param $is_owner
     * @return array
     */
    public function link_of_news($news_id, $type = '', $shop_id = 0, $user_id = 0, $link_id_expel = 0, $is_owner = false, $limit = 0, $start = 0, $image_id = 0)
    {
        //library-link không có content_id
        if (!$news_id || $type == 'library-link') {
            return [];
        }

        //ko có type thì get 2 loại link bài viết
        if(!$type && !($links = $this->CI->link_model->link_of_news($news_id, $shop_id, $user_id, $link_id_expel, $owner_id = false, $limit, $start))){
            return [];
        }

        if($type == 'content-link' && !($links = $this->CI->content_link_model->link_of_news($news_id, $link_id_expel, $is_owner))){
            return [];
        }

        if($type == 'image-link' && !($links = $this->CI->content_image_link_model->link_of_news($news_id, $image_id, $link_id_expel, $is_owner))){
            return [];
        }

        return $links;
    }

    public function link_same_category($cat_id, $type, $shop_id, $user_id, $link_id_expel, $is_owner = false)
    {
        if (!$cat_id || !$type) {
            return [];
        }

        if($type == 'library-link' && !($links = $this->CI->lib_link_model->link_same_category($cat_id, $shop_id, $user_id, $link_id_expel, $is_owner))){
            return [];
        }

        if($type == 'content-link' && !($links = $this->CI->content_link_model->link_same_category($cat_id, $shop_id, $user_id, $link_id_expel, $is_owner))){
            return [];
        }

        if($type == 'image-link' && !($links = $this->CI->content_image_link_model->link_same_category($cat_id, $shop_id, $user_id, $link_id_expel, $is_owner))){
            return [];
        }

        return $links;
    }

    /**
     * Insert link if not exits
     *
     * @param $url
     * @return array|bool
     */
    public function add_if_not_exist($url)
    {
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $url = strip_tags(trim($url));

        if (($link = $this->CI->link_model->find_where(['link' => $url]))) {
            return $link;
        } else {
            $claw_data = $this->_get_claw_data($url);
            $link_insert['added_at'] = date('Y-m-d H:i:s');
            $link_insert['link']     = $url;
            if(!empty($claw_data['img_ext']) && is_array($claw_data['img_ext'])){
                $claw_data['img_ext'] = json_encode($claw_data['img_ext']);
            }

            $link_insert             = array_merge($link_insert, $claw_data);
            if ($this->CI->link_model->add_new($link_insert)) {
                return [
                    'id'        => $this->CI->db->insert_id(),
                    'min_id'    => 0,
                    'tbl_min'   => '',
                    'max_id'    => 0,
                    'tbl_max'   => ''
                ];
            }
            return false;
        }
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
                $optimize_img = curl_data(SERVER_OPTIMIZE_URL.'otp-url-image'
                    , ['url' => $data_crawl['image'], 'type' => 'link']
                    , ""
                    , ''
                    , "POST"
                    , "test"
                );

                if($optimize_img
                    && ($optimize_img = @json_decode($optimize_img, true))
                    && isset($optimize_img['error_code'])
                    && $optimize_img['error_code'] == 0){
                    $result['image']      = $optimize_img['data']['default']['file_url'];
                    $result['img_width']  = $optimize_img['data']['default']['width'];
                    $result['img_height'] = $optimize_img['data']['default']['height'];
                    $result['img_path']   = $optimize_img['data']['default']['date_dir'];
                    $result['img_name']   = $optimize_img['data']['default']['file_name'];

                    $result['img_ext'] = null;
                    if(isset($optimize_img['data']['pc'])){
                        $crop = null;
                        if(isset($optimize_img['data']['pc']['pre_fix_crop']) && $prefix = $optimize_img['data']['pc']['pre_fix_crop']){
                            $crop = [
                                'pre_fix' => $prefix,
                                'width'   => $optimize_img['data']['pc']['width_crop'],
                                'height'  => $optimize_img['data']['pc']['height_crop'],
                            ];
                        }
                        $result['img_ext']['pc'] = [
                            "dir"    => $optimize_img['data']['pc']['mode_dir'],
                            "width"  => $optimize_img['data']['pc']['width'],
                            "height" => $optimize_img['data']['pc']['height'],
                            "crop"   => $crop,
                        ];
                    }
                    if(isset($optimize_img['data']['mb'])){
                        $crop = null;
                        if(isset($optimize_img['data']['mb']['pre_fix_crop']) && $prefix = $optimize_img['data']['mb']['pre_fix_crop']){
                            $crop = [
                                'pre_fix' => $prefix,
                                'width'   => $optimize_img['data']['mb']['width_crop'],
                                'height'  => $optimize_img['data']['mb']['height_crop'],
                            ];
                        }
                        $result['img_ext']['mb'] = [
                            "dir"    => $optimize_img['data']['mb']['mode_dir'],
                            "width"  => $optimize_img['data']['mb']['width'],
                            "height" => $optimize_img['data']['mb']['height'],
                            "crop"   => $crop,
                        ];
                    }
                }else{
                    list($width, $height) = @getimagesize($data_crawl['image']);
                    $result['image']      = $data_crawl['image'];
                    $result['img_width']  = $width;
                    $result['img_height'] = $height;
                }
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

    public function get_owner($link)
    {
        if(!$link)
            return [];

        if(!empty($link['sho_id']) && ($shop = $this->CI->shop_model->get_shop_by_id($link['sho_id']))){
            $this->CI->load->model('district_model');

            if ($shop['sho_logo']) {
                $shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop['sho_dir_logo'] . '/' . $shop['sho_logo'];
            } else {
                $shop_logo = site_url('templates/home/images/no-logo.jpg');
            }

            $shop['logo']     = $shop_logo;
            $shop['distin'] = [];

            if($shop['sho_district']){
                $shop['distin'] = $this->CI->district_model->find_where(['DistrictCode' => $shop['sho_district']], [
                    'select' => 'DistrictName, ProvinceName'
                ]);
            }

            $shop['shop_url'] = shop_url($shop) . '/';
            return $shop;

        }else if(!empty($link['user_id']) && ($user = $this->CI->user_model->generalInfo($link['user_id']))){
            if($user['avatar']){
                $user['avatar_url'] = $this->CI->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user['use_id'] . '/' .  $user['avatar'];
            }
            $user['profile_url'] = azibai_url() . '/profile/' . $user['use_id'] . '/';
            return $user;
        }
        return [];
    }
}