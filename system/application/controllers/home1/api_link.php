<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Api_link extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->config->load('config_api');
        $this->load->library('Api_lib');
    }


    // AJAX
    public function review_link()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $link = $_REQUEST['url'];

            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_common_review_link');
            $url = str_replace(['{$url_link}'],[$link], $url);
            $params = null;

            $result = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        }

        echo $result; die;
    }

    // AJAX
    public function create_link()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_link_create');
            $params = [
                'lib_link[link]'         => $this->input->post('link'),
                'lib_link[title]'        => $this->input->post('title'),
                'lib_link[description]'  => $this->input->post('description'),
                'lib_link[cate_link_id]' => $this->input->post('cate_link_id') && is_numeric($this->input->post('cate_link_id')) ? $this->input->post('cate_link_id') : 0,
                'lib_link[image]'        => $this->input->post('image') && strtolower($this->input->post('image')) != 'null' ? $this->input->post('image') : null,
                'lib_link[video]'        => $this->input->post('video') && strtolower($this->input->post('video')) != 'null' ? $this->input->post('video') : null,
                'lib_link[orientation]'  => $this->input->post('orientation') && is_numeric($this->input->post('orientation')) ? $this->input->post('orientation') : 0,
                'lib_link[mime]'         => $this->input->post('mime') && strtolower($this->input->post('mime')) != 'null' ? $this->input->post('mime') : null,
                'lib_link[img_width]'    => $this->input->post('img_width') && is_numeric($this->input->post('img_width')) ? $this->input->post('img_width') : 0,
                'lib_link[img_height]'   => $this->input->post('img_height') && is_numeric($this->input->post('img_height')) ? $this->input->post('img_height') : 0,
                'lib_link[is_personal]'  => $this->input->post('is_personal') && is_numeric($this->input->post('is_personal')) ? $this->input->post('is_personal') : 0,
                'lib_link[is_public]'    => $this->input->post('is_public') && is_numeric($this->input->post('is_public')) ? $this->input->post('is_public') : 0,
            ];
            if($this->input->post('collection')) {
                $collection_ids = explode(',', $this->input->post('collection'));
                foreach ($collection_ids as $key => $id) {
                    is_numeric($id) ? $params['lib_link[collection]['.$key.']'] = $id : '';
                }
            }
            $params = array_filter($params, function($v, $k) {
                return $v !== null;
            }, ARRAY_FILTER_USE_BOTH);
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);

        }

        echo $result; die;
    }

    // AJAX
    public function get_link()
    {
        $result = '';

        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');

            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_link_get');

            $url = str_replace(['{$type}','{$link_id}'],[$type,$id], $url);
            $params = null;

            $result = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        }

        echo $result; die;
    }

    // AJAX
    public function update_link()
    {
        $result = '';

        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');

            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_link_update');

            $url = str_replace(['{$type}','{$link_id}'],[$type,$id], $url);
            $params = [
                'lib_link[link]'         => $this->input->post('link'),
                'lib_link[title]'        => $this->input->post('title'),
                'lib_link[description]'  => $this->input->post('description'),
                'lib_link[cate_link_id]' => $this->input->post('cate_link_id') && is_numeric($this->input->post('cate_link_id')) ? $this->input->post('cate_link_id') : 0,
                'lib_link[image]'        => $this->input->post('image') && strtolower($this->input->post('image')) != 'null' ? $this->input->post('image') : null,
                'lib_link[video]'        => $this->input->post('video') && strtolower($this->input->post('video')) != 'null' ? $this->input->post('video') : null,
                'lib_link[orientation]'  => $this->input->post('orientation') && is_numeric($this->input->post('orientation')) ? $this->input->post('orientation') : 0,
                'lib_link[mime]'         => $this->input->post('mime') && strtolower($this->input->post('mime')) != 'null' ? $this->input->post('mime') : null,
                'lib_link[img_width]'    => $this->input->post('img_width') && is_numeric($this->input->post('img_width')) ? $this->input->post('img_width') : 0,
                'lib_link[img_height]'   => $this->input->post('img_height') && is_numeric($this->input->post('img_height')) ? $this->input->post('img_height') : 0,
                'lib_link[is_personal]'  => $this->input->post('is_personal') && is_numeric($this->input->post('is_personal')) ? $this->input->post('is_personal') : 0,
                'lib_link[is_public]'    => $this->input->post('is_public') && is_numeric($this->input->post('is_public')) ? $this->input->post('is_public') : 0,
            ];
            if($this->input->post('collection')) {
                $collection_ids = explode(',', $this->input->post('collection'));
                foreach ($collection_ids as $key => $id) {
                    is_numeric($id) ? $params['lib_link[collection]['.$key.']'] = $id : '';
                }
            }
            $params = array_filter($params, function($v, $k) {
                return $v !== null;
            }, ARRAY_FILTER_USE_BOTH);

            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        }

        echo $result; die;
    }

    // AJAX
    public function delete_link()
    {
        $result = '';

        if($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $type = $this->input->post('type');

            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_link_delete');

            $url = str_replace(['{$type}','{$link_id}'],[$type,$id], $url);
            $params = null;

            $result = $this->api_lib->callAPI('DELETE', $url, $params, $rent_header);
        }

        echo $result; die;
    }

    // AJAX
    public function clone_link()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api');
            $url = $this->config->item('api_link_create');
            $params = [
                'lib_link[link]'         => $this->input->post('link'),
                'lib_link[title]'        => $this->input->post('title'),
                'lib_link[description]'  => $this->input->post('description'),
                'lib_link[cate_link_id]' => $this->input->post('cate_link_id') && is_numeric($this->input->post('cate_link_id')) ? $this->input->post('cate_link_id') : 0,
                'lib_link[image]'        => $this->input->post('image') && strtolower($this->input->post('image')) != 'null' ? $this->input->post('image') : null,
                'lib_link[video]'        => $this->input->post('video') && strtolower($this->input->post('video')) != 'null' ? $this->input->post('video') : null,
                'lib_link[orientation]'  => $this->input->post('orientation') && is_numeric($this->input->post('orientation')) ? $this->input->post('orientation') : 0,
                'lib_link[mime]'         => $this->input->post('mime') && strtolower($this->input->post('mime')) != 'null' ? $this->input->post('mime') : null,
                'lib_link[img_width]'    => $this->input->post('img_width') && is_numeric($this->input->post('img_width')) ? $this->input->post('img_width') : 0,
                'lib_link[img_height]'   => $this->input->post('img_height') && is_numeric($this->input->post('img_height')) ? $this->input->post('img_height') : 0,
                'lib_link[is_personal]'  => $this->input->post('is_personal') && is_numeric($this->input->post('is_personal')) ? $this->input->post('is_personal') : 0,
                'lib_link[is_public]'    => $this->input->post('is_public') && is_numeric($this->input->post('is_public')) ? $this->input->post('is_public') : 0,
            ];
            if($this->input->post('collection')) {
                $collection_ids = explode(',', $this->input->post('collection'));
                foreach ($collection_ids as $key => $id) {
                    is_numeric($id) ? $params['lib_link[collection]['.$key.']'] = $id : '';
                }
            }
            $params = array_filter($params, function($v, $k) {
                return $v !== null;
            }, ARRAY_FILTER_USE_BOTH);

            $clone_num = 0;
            if($this->input->post('path_img') && strtolower($this->input->post('path_img')) != 'null') {
                $clone_url = $this->config->item('api_common_clone_file');
                $clone_params['files[0]'] = $this->input->post('path_img');
                $clone_num++;
            }
            if($this->input->post('path_video') && strtolower($this->input->post('path_video')) != 'null') {
                $clone_url = $this->config->item('api_common_clone_file');
                $clone_params['files[1]'] = $this->input->post('path_video');
                $clone_num++;
            }
            if($clone_num > 0) {
                $data_clone = $this->api_lib->callAPI('POST', $clone_url, $clone_params, $rent_header);
                $data_clone = json_decode($data_clone, TRUE);

                if($data_clone['status'] == 1 && count($data_clone['data']) > 0) {
                    if($clone_num == 1) {
                        $params['lib_link[image]'] = $data_clone['data'][0]['to'];
                    }
                    if($clone_num == 2) {
                        $params['lib_link[image]'] = $data_clone['data'][0]['to'];
                        $params['lib_link[video]'] = $data_clone['data'][1]['to'];
                    }
                } else {
                    $result = [
                        'status'    => 1,
                        'mess'      => 'Clone file thất bại'
                    ];
                    echo json_encode($result); die;
                }
            }
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);

        }

        echo $result; die;
    }
}

/* End of file Api_link.php */


?>