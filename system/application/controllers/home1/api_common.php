<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Api_common extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->config->load('config_api');
        $this->load->library('Api_lib');
    }

    // AJAX
    public function up_image()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = [
                'image' => new \CurlFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']),
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_common_image_post');
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);

        }

        echo $result; die;
    }

    // AJAX
    public function up_video()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = [
                'video' => new \CurlFile($_FILES['video']['tmp_name'], $_FILES['video']['type'], $_FILES['video']['name']),
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_common_video_post');
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);

        }

        echo $result; die;
    }

    // AJAX
    public function clone_files()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = [
                'video' => new \CurlFile($_FILES['video']['tmp_name'], $_FILES['video']['type'], $_FILES['video']['name']),
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_common_clone_file');
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);

        }

        echo $result; die;
    }

    public function change_show_person_shop()
    {
        $result = '';

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $url = $this->config->item('api_change_show_person_shop');
            $token = $this->session->userdata('token');
            $params = [
                "show_storetab" => $_REQUEST['show_storetab']
            ];
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        }
        echo $result; die;
    }

}

/* End of file Api_common.php */


?>