<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Api_collection extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->config->load('config_api');
        $this->load->library('Api_lib');
    }

    // tạo bộ sưu tập link
    // AJAX
    public function create_collection_link()
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = [
                'collection[name]' => $this->input->post('name'),
                'collection[description]' => $this->input->post('description'),
                'collection[avatar_path]' => $this->input->post('avatar_path'),
                'collection[img_width]' => $this->input->post('img_width'),
                'collection[img_height]' => $this->input->post('img_height'),
                'collection[mime]' => $this->input->post('mime'),
                'collection[orientation]' => $this->input->post('orientation'),
                'collection[isPublic]' => $this->input->post('isPublic'),
                'collection[is_personal]' => $this->input->post('is_personal'),
                'collection[cate_id]' => $this->input->post('cate_id'),
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_collection_link_create_post');
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
            $result['data'] = $data;
        }

        echo json_encode($result); die;
    }

    // sữa bộ sưu tập link
    // AJAX
    public function edit_collection_link()
    {
        $x =1;
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = [
                'collection[name]' => $this->input->post('name'),
                'collection[description]' => $this->input->post('description'),
                'collection[avatar_path]' => $this->input->post('avatar_path'),
                'collection[img_width]' => $this->input->post('img_width'),
                'collection[img_height]' => $this->input->post('img_height'),
                'collection[mime]' => $this->input->post('mime'),
                'collection[orientation]' => $this->input->post('orientation'),
                'collection[isPublic]' => $this->input->post('isPublic'),
                'collection[is_personal]' => $this->input->post('is_personal'),
                'collection[cate_id]' => $this->input->post('cate_id'),
            ];
            $collection_id = $this->input->post('id');

            $this->config->load('config_api');
            $url = $this->config->item('api_collection_link_edit_post');
            $url = str_replace(['{$collection_id}'], [$collection_id], $url);
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
            $result['data'] = $data;
        }

        echo json_encode($result); die;
    }







    // lấy bộ sưu tập link
    // USE this->load->file
    public function get_data_collection_link($user_id = 0, $last_id = 0, $is_person = false)
    {
        $this->config->load('config_api');
        if($is_person == true) {
            $url = $this->config->item('api_collection_link_p_get');
        } else {
            $url = $this->config->item('api_collection_link_get');
        }
        $url = str_replace(['{$user_id}','{$last_id}'], [$user_id,$last_id], $url);
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }
        $make_call = $this->api_lib->callAPI('GET', $url, '', $rent_header);

        return $make_call;
    }

    public function get_data_mini_collection_link()
    {
        $return = false;
        $this->config->load('config_api');
        $url = $this->config->item('api_collection_link_mini_get');
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }
        $make_call = $this->api_lib->callAPI('GET', $url, '', $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            $return = $make_call['data'];
        }

        return $return;
    }

    public function get_data_detail_collection_link($user_id = 0, $collection_id = 0, $create_at = 0)
    {
        $return = false;
        $this->config->load('config_api');
        $url = $this->config->item('api_collection_link_detail_get');
        $url = str_replace(['{$id}','{$id_collection}','{$create_at}'], [$user_id,$collection_id,$create_at], $url);
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }
        $make_call = $this->api_lib->callAPI('GET', $url, '', $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            $return = $make_call['data'];
        }

        return $return;
    }
}

/* End of file Api_collection.php */


?>