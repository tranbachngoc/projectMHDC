<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api_content extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->config->load('config_api');
        $this->load->library('Api_lib');
    }

    // Xóa content by id
    // AJAX
    public function delete_content($content_id)
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = null;
            $this->config->load('config_api');
            $url = $this->config->item('api_content_delete_by_id');
            $url = str_replace(['{$content_id}'], [$content_id], $url);
            $token = $this->session->userdata('token');

            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $make_call = $this->api_lib->callAPI('DELETE', $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
            $result['data'] = $data;
        }

        echo json_encode($result); die;
    }

    public function suggest_in_newsfeed()
    {
        # code... api_get_list_content
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api');
        $url = $this->config->item('api_suggest_in_newsfeed');
        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        // if($make_call['status'] != 1) {
        //     return [];
        // } else {
            $data_return = [
                'friends' => [
                    'offset' => $make_call['data']['offset-friends'],
                    'data' => $make_call['data']['friends'],
                    'key' => 'friends'
                ],
                'many_friends' => [
                    'offset' => $make_call['data']['offset-many-friends'],
                    'data' => $make_call['data']['many-friends'],
                    'key' => 'many_friends'
                ],
                'mutual_friends' => [
                    'offset' => $make_call['data']['offset-mutual-friends'],
                    'data' => $make_call['data']['mutual-friends'],
                    'key' => 'mutual_friends'
                ],
                'shop_follow' => [
                    'offset' => $make_call['data']['offset-shop-follow'],
                    'data' => $make_call['data']['shop-follow'],
                    'key' => 'shop_follow'
                ],

                'shop_follow_better' => [
                    'offset' => $make_call['data']['offset-shop-follow-better'],
                    'data' => $make_call['data']['shop-follow-better'],
                    'key' => 'shop_follow_better'
                ],
            ];

            return $data_return;
        // }
    }

    // remove suggest_user by user_id
    // AJAX
    public function remove_suggest_user($user_id)
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = null;
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            $params = [
                'friend_id' => $user_id
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_remove_suggest_friend_in_newsfeed');

            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
        }

        echo json_encode($result); die;
    }

    // remove suggest_shop by shop_id
    // AJAX
    public function remove_suggest_shop($shop_id)
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = null;
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            $params = [
                'sho_id' => $shop_id
            ];

            $this->config->load('config_api');
            $url = $this->config->item('api_remove_suggest_shop_in_newsfeed');

            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
        }

        echo json_encode($result); die;
    }

    // Load suggest data
    // AJAX
    public function load_suggest_data()
    {
        $return_html = '';
        $valid_key = ["friends","many_friends","mutual_friends","shop_follow","shop_follow_better"];
        $key = $_REQUEST['key'];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token')) && in_array($key, $valid_key) ) {
            $params = null;
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api');
            switch ($key) {
                case 'friends':
                    $url = $this->config->item('api_load_suggest_friend');
                    $params = [
                        "type" => "ASC"
                    ];
                    break;
                case 'many_friends':
                    $url = $this->config->item('api_load_suggest_friend');
                    $params = [
                        "type" => "DESC"
                    ];
                    break;
                case 'mutual_friends':
                    $url = $this->config->item('api_load_suggest_mutual_friends');
                    break;
                case 'shop_follow':
                case 'shop_follow_better':
                    $url = $this->config->item('api_load_suggest_shop_follow');
                    break;
                default:
                    echo json_encode($result); die;
                    break;
            }

            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
            $data = json_decode($make_call, true)['data'];

            if(in_array($key, ["friends","many_friends","mutual_friends"])) {
                foreach ($data as $k => $friend) {
                    $site = profile_url($friend);
                    $html =
                    "<div class='item js-item'>
                        <a href='{$site}' target='_blank' class='avata'>
                            <img src='{$friend['full_avatar']}' alt=''>
                        </a>
                        <div class='name'>
                        <div class='tt'>
                            <a href='{$site}' target='_blank'>
                                <h3 class='one-line'>{$friend['use_fullname']}</h3>
                            </a>
                            <div class='small-tt'>{$friend['mutual-friends']} bạn chung</div>
                        </div>
                        <div class='group-btn'>
                            <button class='btn-addfriend js_{$key}_{$friend['use_id']}'
                            data-id='{$friend['use_id']}'
                            data-name_js='.js_{$key}_{$friend['use_id']}'
                            data-is_send='0'
                            data-img_cancel='/templates/home/styles/images/svg/huyketban.svg'
                            data-img_accept='/templates/home/styles/images/svg/ketban_white.svg'
                            onclick='send_request_friend(this, event)'>
                                <img src='/templates/home/styles/images/svg/ketban_white.svg' class='mr10 js-img'><span class='js-text'>Kết bạn</span></button>
                            <button href='javascript:void(0)' class='btn-delete'
                            data-id='{$friend['use_id']}'
                            onclick='remove_suggest_friend(this, false, event)'>Xóa</button>
                        </div>
                        </div>
                    </div>";
                    $return_html .= $html;
                }
            }
            if(in_array($key, ["shop_follow","shop_follow_better"])) {
                $_id_null = '';
                foreach ($data as $key => $shop) {
                    $site = shop_url($shop);
                    $sho_introduction = strip_tags(html_entity_decode($shop['sho_introduction']));
                    $html =
                    "<div class='item js-item'>
                        <span class='close-goiy'
                        data-id='{$shop['sho_id']}'
                        onclick='remove_suggest_shop(this, false, event)'><img src='/templates/home/styles/images/svg/close03.svg'></span>
                        <a href='{$site}' target='_blank' class='banner'>
                            <img class='avata' src='{$shop['sho_logo_full']}'>
                            <img class='cover' src='{$shop['sho_banner_full']}'>
                        </a>
                        <div class='text'>
                            <div class='tit'>
                                <h3 class='two-lines'><a href='{$site}' target='_blank'>{$shop['sho_name']}</a></h3>
                                <button class='btn-follow js_{$_id_null}_{$shop['sho_id']}'
                                data-id='{$shop['sho_id']}'
                                data-name_js='.js_{$_id_null}_{$shop['sho_id']}'
                                data-is_send='0'
                                data-img_cancel='/templates/home/styles/images/svg/dangtheodoi.svg'
                                data-img_accept='/templates/home/styles/images/svg/theodoi_white.svg'
                                onclick='send_request_shop(this, event)' >
                                    <img src='/templates/home/styles/images/svg/theodoi_white.svg' class='mr10 js-img'>
                                    <span class='js-text'>Theo dõi</span>
                                </button>
                            </div>
                            <div class='txt two-lines'>{$sho_introduction}</div>
                        </div>
                    </div>";
                    $return_html .= $html;
                }
            }

        }

        echo $return_html; die;
    }

    // Gửi lời mời kết bạn
    // AJAX
    public function send_request_friend($user_id)
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = null;
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            // gửi lời  mời kết bạn
            $this->config->load('config_api');
            $url = $this->config->item('api_send_request_add_friend');
            $_type = "GET";
            if($_REQUEST['is_sending'] == 1) { // hủy gửi lời  mời kết bạn
                $url = $this->config->item('api_send_request_cancel_friend');
                $_type = "DELETE";
            }
            $url = str_replace(['{$user_id}'],[$user_id],$url);

            $make_call = $this->api_lib->callAPI($_type, $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
        }

        echo json_encode($result); die;
    }

    // follow shop
    // AJAX
    public function send_request_follow_shop($shop_id)
    {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];

        if($this->input->is_ajax_request() && !empty($this->session->userdata('token'))) {
            $params = null;
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            // gửi lời  mời kết bạn
            $this->config->load('config_api');
            $url = $this->config->item('api_follow_shop_or_cancel');
            $url = str_replace(['{$shop_id}'],[$shop_id],$url);

            $make_call = $this->api_lib->callAPI("GET", $url, $params, $rent_header);
            $data = json_decode($make_call, true);

            $result['err'] = $data['status'] == 1 ? false : true;
            $result['mgs'] = $data['status'] == 0 ? $data['msg'] : '';
        }

        echo json_encode($result); die;
    }
}

/* End of file Api_collection.php */


?>