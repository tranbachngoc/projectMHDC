<?php

class Api_affiliate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->config->load('config_api_aff');
        $this->load->library('Api_lib');
        $x=1;
    }

    public function get_data_home_dashboard($type_affiliate, $iParentId = 1)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data dashboard
        $url = $this->config->item('api_aff_user_dashboard');
        $url = str_replace(['{$type_affiliate}'], [$type_affiliate], $url);
        $url .= '&parent_id='.$iParentId;
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'dashboard' => $make_call['data'],
            ];
        }

        return $data_return;
    }

    public function get_list_user_affiliate($user_id, $level, $page, $limit, $user_type, $search,$aff_type = 1, $parent_id = 1)
    {
        $data_return = [];
        $rent_header = null;
        
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data list user affiliate
        $url = $this->config->item('api_aff_list_user_data');
        $url = str_replace(['{$user_id}','{$level}','{$page}','{$limit}','{$user_type}','{$search}','{$type_affiliate}','{$parent_id}'], [$user_id, $level, $page, $limit, $user_type, $search,$aff_type,$parent_id], $url);
        
        if(empty($level) && (int)$level !== 0) {
            $url = str_replace('&level=', '', $url);
        }
        if(empty($user_type)) {
            $url = str_replace('&user_type=', '', $url);
        }
        
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'users' => $make_call['data'],
                'user_total' => $make_call['total'],
                'total' => [
                    'all'=>$make_call['iTotal'] ? $make_call['iTotal'] : 0,
                    'lv2'=>$make_call['iTotalLv2'] ? $make_call['iTotalLv2'] : 0,
                    'lv3'=>$make_call['iTotalLv3'] ? $make_call['iTotalLv3'] : 0,
                    'user_new'=>$make_call['iUserNew'] ? $make_call['iUserNew'] : 0,
                    'user_buy'=>$make_call['iUserBuy'] ? $make_call['iUserBuy'] : 0,
                ],
            ];
        }

        return $data_return;
    }

    public function get_list_service_affiliate($user_id, $aDatas = array(), $page = 1, $limit = 10)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        // data list service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_list_service_data');
        $url = str_replace(['{$user_id}','{$page}','{$limit}'], [$user_id,$page,$limit], $url);
        if(isset($aDatas['type_affiliate'])) {
            $url = str_replace(['{$type_affiliate}'], [$aDatas['type_affiliate']], $url);
        }
        if(isset($aDatas['type_service'])) {
            $url = str_replace(['{$type_service}'], [$aDatas['type_service']], $url);
        }

        if(isset($aDatas['parent_id'])) {
            $url = str_replace(['{$parent_id}'], [$aDatas['parent_id']], $url);
        }else{
            $url = str_replace(['&parent_id={$parent_id}'], [''], $url);
        }

        if(isset($aDatas['get_type'])) {
            $url = str_replace(['{$get_type}'], [$aDatas['get_type']], $url);
        }else {
            $url = str_replace(['{$get_type}'], [1], $url);
        }

        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);

        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'services' => $make_call['data'],
                'total' => $make_call['total']
            ];
            // dd($url);
            // dd($make_call);die;

            return $data_return;
        }
    }

    public function get_list_service_azibai($page = 1, $limit = 10)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        // data list service azibai
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_list_service_azibai_data');
        $url = str_replace(['{$page}','{$limit}'], [$page,$limit], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);

        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'services' => $make_call['data'],
                'total' => $make_call['total']
            ];

            return $data_return;
        }
    }

    public function get_detail_service($service_id, $user_id, $type_affiliate)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_detail_service');
        $url = str_replace(['{$service_id}','{$user_id}','{$type_affiliate}'], [$service_id, $user_id, $type_affiliate], $url);
        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = $make_call['data'];

            return $data_return;
        }
    }

    public function get_data_order($user_id, $type_get, $start, $end, $page, $limit, $search, $aRule = array())
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_list_order_data');
        $url = str_replace(['{$user_id}','{$type_get}','{$start}','{$end}','{$page}','{$limit}','{$search}'], [$user_id, $type_get, $start, $end, $page, $limit, $search], $url);
        if(empty($start)) {
            $url = str_replace('date_start=&', '', $url);
        }
        if(empty($end)) {
            $url = str_replace('date_end=&', '', $url);
        }
        if(empty($search)) {
            $url = str_replace('search=&', '', $url);
        }

        if(isset($aRule['type_affiliate']) && $aRule['type_affiliate'] != '') {
            $url .= '&type_affiliate='.$aRule['type_affiliate'];
        }

        if(isset($aRule['id']) && $aRule['id'] != '') {
            $url .= '&parent_id='.$aRule['parent_id'];
        }

        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'orders' => $make_call['data'],
                'order_total' => $make_call['total'] ? $make_call['total'] : 0,
                'total_all' => $make_call['iTotalOrder'] ? $make_call['iTotalOrder'] : 0,
                'total_self' => $make_call['iTotalOrderUser'] ? $make_call['iTotalOrderUser'] : 0,
                'total_ctv' => $make_call['iTotalOrderMember'] ? $make_call['iTotalOrderMember'] : 0,
            ];
        }

        return $data_return;
    }

    public function get_detail_order($order_id)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        // data detail order affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_detail_order');
        $url = str_replace(['{$order_id}'], [$order_id], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = $make_call['data'];

            return $data_return;
        }
    }

    public function get_data_income_sodu($month_year, $user_id, $page, $limit)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data income số dư
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_income_data');
        $url = str_replace(['{$month_year}','{$user_id}','{$page}','{$limit}'], [$month_year, $user_id, $page, $limit], $url);
        if(empty($month_year)) {
            $url = str_replace('month=&', '', $url);
        }
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            $make_call['data']['order_total'] = $make_call['total'];
            $data_return = $make_call['data'];

            return $data_return;
        }
    }

    public function get_data_income_tamtinh($user_id, $page, $limit)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data income tạm tính
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_income_provisonal_sum');
        $url = str_replace(['{$user_id}','{$page}','{$limit}'], [$user_id,$page,$limit], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            $make_call['data']['order_total'] = $make_call['total'];
            $data_return = $make_call['data'];

            return $data_return;
        }
    }

    public function get_data_income_history($user_id, $type_get, $page, $limit)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data income history
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_income_history');
        $url = str_replace(['{$user_id}','{$type_get}','{$page}','{$limit}'], [$user_id,$type_get,$page,$limit], $url);
        if(empty($type_get)) {
            $url = str_replace('&type_get=', '', $url);
        }
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'orders' => $make_call['data'],
                'order_total' => $make_call['total']
            ];

            return $data_return;
        }
    }

    public function get_data_income_payment_accounts($user_id)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data payment accounts
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_income_payment_accounts');
        $url = str_replace(['{$user_id}'], [$user_id], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            $banks = $momos = [];
            foreach ($make_call['data'] as $key => $item) {
                if($item['type_bank'] == 0) {
                    array_push($banks, $item);
                }

                if($item['type_bank'] == 1) {
                    array_push($momos, $item);
                }
            }
            $data_return = [
                'banks' => $banks,
                'momos' => $momos
            ];

            return $data_return;
        }
    }

    public function add_payment_account_income($user_id, $bank_name, $aff, $account_number, $account_name, $type_bank)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        // add account payment
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_income_payment_add');
        $params = [
            'user_id' => $user_id,
            'bank_name' => $bank_name,
            'aff' => $aff,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'type_bank' => $type_bank
        ];
        $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return true;
        }
    }

    //api_aff_income_payment_put
    public function put_payment_account_income($bank_id = 0)
    {
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
        }

        if($this->input->is_ajax_request() && $this->session->userdata('sessionUser') == $_POST['user_id'] && $_POST['user_id'] > 0) {
            // update account payment
            $rent_header[] = "Content-Type: application/json";
            $bank_id = $_POST['id'] ? $_POST['id'] : 0;

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_aff_income_payment_put');
            $url = str_replace(['{$bank_id}'], [$bank_id], $url);
            $params = [
                'user_id' => isset($_POST['user_id']) ? $_POST['user_id'] : '',
                'bank_name' => isset($_POST['bank_name']) ? $_POST['bank_name'] : '',
                'aff' => isset($_POST['aff']) ? $_POST['aff'] : '',
                'account_number' => isset($_POST['account_number']) ? $_POST['account_number'] : '',
                'account_name' => isset($_POST['account_name']) ? $_POST['account_name'] : '',
                'type_bank' => isset($_POST['type_bank']) ? $_POST['type_bank'] : '',
            ];
            $params = array_filter($params, 'strlen');
            if(count($params) == 6) { // ko có field nào rỗng
                $make_call = $this->api_lib->callAPI('PUT', $url, json_encode($params), $rent_header);

                echo $make_call; die;
            } else {
                echo 0; die;
            }

        } else {
            // get account payment
            $url = $this->config->item('api_aff_income_payment_put');
            $url = str_replace(['{$bank_id}'], [$bank_id], $url);
            $params = null;
            $make_call = $this->api_lib->callAPI('PUT', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            if($make_call['status'] != 1) {
                return [];
            } else {
                return $make_call['data'];
            }
        }
    }

    public function delete_payment_account_income()
    {
        if($this->input->is_ajax_request()) {
            $bank_id = $_POST['bank_id'];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            // delete account payment
            $this->config->load('config_api_aff');
            $url = $this->config->item('api_aff_income_payment_delete');
            $url = str_replace(['{$bank_id}'], [$bank_id], $url);

            $make_call = $this->api_lib->callAPI('DELETE', $url, $params, $rent_header);
            echo $make_call; die;
        }
    }

    public function get_list_bank_data()
    {
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        // delete account payment
        $url = $this->config->item('api_aff_income_list_bank_data');
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return [];
        } else {
            return $make_call['data'];
        }
    }

    public function get_data_statistic($user_id, $start_date, $end_date, $type_view, $aRule = array())
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_statistic_order');
        $params = [
            'user_id'   =>  $user_id,
            'date_start'=>  $start_date,
            'date_end'  =>  $end_date,
            'type_get'  =>  $type_view,
            'parent_id' =>  $aRule['parent_id'],
            'type_affiliate' => $aRule['type_affiliate'],
        ];
        $params = array_filter($params, 'strlen');
        $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'total_order' => $make_call['data']['iTotal'],
                'total_user'    => $make_call['data']['iTotalUser'],
                'success_thu_nhap' => $make_call['data']['aOrderSuccess']['income'],
                'success_doanh_thu' => $make_call['data']['aOrderSuccess']['amount'],
            ];

            return $data_return;
        }
    }

    public function get_data_draw_money($user_id)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_detail_withdraw');
        $url = str_replace(['{$user_id}'], [$user_id], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            $banks = $momos = [];
            foreach ($make_call['data']['aListBank'] as $key => $item) {
                if($item['type_bank'] == 0) {
                    array_push($banks, $item);
                }

                if($item['type_bank'] == 1) {
                    array_push($momos, $item);
                }
            }
            $data_return = [
                'banks' => $banks,
                'momos' => $momos,
                'money_draw' => $make_call['data']['iTotalMoney'],
                'money_fee' => $make_call['data']['iTransferFee']
            ];
            return $data_return;
        }
    }

    public function post_data_draw_money($user_id, $bank_id, $money)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_aff_draw_money');
        $params = [
            'user_id' => $user_id,
            'bank_id' => $bank_id,
            'money' => $money,
        ];
        $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $make_call['data']['iMoneyId'];
        }
    }

    public function confirm_transfer_money()
    {
        # api_aff_confirm_transfer
        if($this->input->is_ajax_request()) {
            $code = isset($_POST['code']) ? $_POST['code'] : '';
            $id = isset($_POST['id']) ? $_POST['id'] : '';

            $data_return = [];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: application/json";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_aff_confirm_transfer');
            $url = str_replace(['{$transfer}'], [$id], $url);
            $params = [
                'code' => $code,
            ];
            $make_call = $this->api_lib->callAPI('PUT', $url, json_encode($params), $rent_header);
            echo $make_call; die;
        }
    }

    public function get_voucher_product_list($user_id, $page, $limit, $search)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_get_list_product');
        $url = str_replace(['{$user_id}','{$page}','{$limit}','{$search}'], [$user_id, $page, $limit, $search], $url);
        if(empty($page) && (int)$page !== 0) {
            $url = str_replace('&page=', '', $url);
        }
        if(empty($limit) && (int)$limit !== 0) {
            $url = str_replace('&limit=', '', $url);
        }
        if(empty($search)) {
            $url = str_replace('&search=', '', $url);
        }
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            $data_return = [
                'items' => $make_call['data'],
                'total' => $make_call['total'],
            ];
            return $data_return;
        }
    }

    public function create_voucher($user_id)
    {
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_create');
        $params = [
            'user_id' => $user_id,
            'product_type' => $_REQUEST['product_type'],
            'price_rank' => $_REQUEST['price_rank'],
            'voucher_type' => $_REQUEST['voucher_type'],
            'value' => $_REQUEST['value'],
            'quantily' => $_REQUEST['quantily'],
            'time_start' => DateTime::createFromFormat('H:i d-m-Y', $_REQUEST['time_start'])->getTimestamp(),
            'time_end' => DateTime::createFromFormat('H:i d-m-Y', $_REQUEST['time_end'])->getTimestamp(),
            'apply' => $_REQUEST['apply'],
            'price' => $_REQUEST['price'],
            'discount_type' => $_REQUEST['discount_type'],
            'price_discount' => $_REQUEST['price_discount'],
            'price_percent' => $_REQUEST['price_percent'],
            'affiliate_type' => $_REQUEST['affiliate_type'],
            'affiliate_value_1' => $_REQUEST['affiliate_value_1'],
            'affiliate_value_2' => $_REQUEST['affiliate_value_2'],
            'affiliate_value_3' => $_REQUEST['affiliate_value_3'],
        ];
        $params = array_filter($params, function($v, $k) {
            return $v !== null;
        }, ARRAY_FILTER_USE_BOTH);
        if($_REQUEST['product_type'] == 1 || $_REQUEST['product_type'] == 2) {
            $params['list_product[0]'] = ''; // check all product_type == 1 && list_product[0] = ''
            $arr_tmp = explode(',', $_REQUEST['list_product']);
            if(count($arr_tmp) > 0 && $_REQUEST['list_product'] != '') {
                foreach ($arr_tmp as $key => $id) {
                    $params['list_product['.$key.']'] = $id;
                }
            }
        }

        $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        echo $make_call;die;
    }

    public function detail_voucher($voucher_id = 0)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        if($voucher_id > 0) {
            $this->config->load('config_api_aff');
            $url = $this->config->item('api_voucher_detail');
            $url = str_replace(['{$voucher_id}'], [$voucher_id], $url);
            $params = null;
            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            if($make_call['status'] != 1) {
                return false;
            } else {
                $data_return = $make_call['data'];
                return $data_return;
            }
        } else {
            return $data_return;
        }
    }

    public function list_voucher($user_id, $page=1, $limit=20)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_list');
        $url = str_replace(['{$user_id}','{$page}','{$limit}'], [$user_id,$page,$limit], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = $make_call;
        }
    }

    public function list_product_use_voucher($voucher_id, $user_id, $page=1, $limit=20, $search)
    {
        //api_voucher_used_by_product
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_used_by_product');
        $url = str_replace(['{$voucher_id}','{$user_id}','{$page}','{$limit}','{$search}'], [$voucher_id,$user_id,$page,$limit,$search], $url);
        if(empty($search)) {
            $url = str_replace('&search=', '', $url);
        }
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = $make_call;
        }
    }

    public function list_service_shop_get($page, $limit, $user_id, $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_list_service_shop_get');
        $params = [
            "page" => $page,
            "limit" => $limit,
            "user_id" => $user_id,
            "type" => $type,
            "search" => $search,
            "product_type" => $product_type,
            "voucher_type" => $voucher_type,
            "price_from" => $price_from,
            "price_to" => $price_to,
            "time_start" => $time_start,
            "time_end" => $time_end,
        ];
        $params = array_filter($params, function ($v)
        {
            return $v != '' || $v == '0';
        });

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($this->input->is_ajax_request()) {
            $data_return = [
                "error" => false,
                "msg" => "Lỗi kết nối"
            ];

            if($make_call["status"] == 1) {
                $data_html = "";
                foreach ($make_call["data"]["aAll"] as $key => $item) {
                    $data_html .= $this->load->view('shop/media/elements/voucher-item', ["item"=>$item], TRUE);
                }
                $data_return = [
                    "error" => false,
                    "msg" => "Thành công",
                    "data" => $data_html,
                    "next" => $make_call["next"] == true ? 1 : 0,
                    "params" => $params
                ];
            }
            echo json_encode($data_return);die;
        } else {
            if($make_call["status"] == 1) {
                $data_return = $make_call["data"];
                $data_return["pagination"] = $make_call["pagination"];
                $data_return["next"] = $make_call["next"];
                $data_return["params"] = json_encode($params);
            }
        }

        return $data_return;
    }

    public function list_service_person_get($page, $limit, $user_id, $type, $search, $product_type, $voucher_type, $price_from, $price_to, $time_start, $time_end)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_list_service_person_get');
        $params = [
            "page" => $page,
            "limit" => $limit,
            "user_id" => $user_id,
            "type" => $type,
            "search" => $search,
            "product_type" => $product_type,
            "voucher_type" => $voucher_type,
            "price_from" => $price_from,
            "price_to" => $price_to,
            "time_start" => $time_start,
            "time_end" => $time_end,
        ];
        $params = array_filter($params, function ($v)
        {
            return $v != '' || $v == '0';
        });

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($this->input->is_ajax_request()) {
            $data_return = [
                "error" => false,
                "msg" => "Lỗi kết nối"
            ];

            if($make_call["status"] == 1) {
                $data_html = "";
                foreach ($make_call["data"]["aAll"] as $key => $item) {
                    $data_html .= $this->load->view('shop/media/elements/voucher-item', ["item"=>$item], TRUE);
                }
                $data_return = [
                    "error" => false,
                    "msg" => "Thành công",
                    "data" => $data_html,
                    "next" => $make_call["next"] == true ? 1 : 0,
                    "params" => $params
                ];
            }
            echo json_encode($data_return);die;
        } else {
            if($make_call["status"] == 1) {
                $data_return = $make_call["data"];
                $data_return["pagination"] = $make_call["pagination"];
                $data_return["next"] = $make_call["next"];
                $data_return["params"] = json_encode($params);
            }
        }

        return $data_return;
    }

    public function list_branch_of_shop($_this, $user_id)
    {
        $rent_header = null;

        $_this->config->load('config_api_aff');
        $url = $_this->config->item('api_branch_get_listBranch');
        $url = str_replace(['{$user_id}'], [$user_id], $url);
        $params = null;
        $make_call = $_this->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = [
                'data' => $make_call['data']['list_branch'],
                'total' => $make_call['data']['count_branch']
            ];
        }
    }

    public function shop_get_list_product_branch($user_id, $pro_type = 0, $page)
    {
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_shop_show_product_branch');
        $url = str_replace(['{$user_id}','{$pro_type}','{$page}'], [$user_id,$pro_type,$page], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = [
                'list_branch' => $make_call['data']['list_branch'],
                'list_cate' => $make_call['data']['list_cate'],
                'list_products' => $make_call['data']['list_products'],
                'total' => $make_call['data']['total'],
            ];
        }
    }

    public function shop_choose_product_branch()
    {
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_id'];
            $pro_id = json_encode([$_POST['pro_id']]);

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_shop_choose_product_branch');

            $params = [
                'user_id' => $user_id,
                'list_pro_id' => $pro_id
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function get_products_post_by_self($user_id, $pro_type, $type = "shop", $page = 1)
    {
        $type_value = ['shop', 'branch'];
        if(!in_array($type, $type_value)) {
            return false;
        }

        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_products_post_by_self');
        $url = str_replace(['{$user_id}','{$pro_type}','{$type}','{$page}'], [$user_id,$pro_type,$type,$page], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = [
                'list_branch' => $make_call['data']['list_branch'],
                'list_cate' => $make_call['data']['list_cate'],
                'list_products' => $make_call['data']['list_products'],
                'total' => $make_call['total'],
            ];
        }
    }

    public function change_status_product_post_by_self()
    {
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_id'];
            $list_pro_id = json_encode([$_POST['list_pro_id']]);
            $status = $_POST['status'];
            $type = $_POST['type']; // [shop, branch]

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_change_status_product_post_by_self');

            $params = [
                'user_id' => $user_id,
                'list_pro_id' => $list_pro_id,
                'status' => $status,
                'type' => $type,
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function shop_share_product_to_branch()
    {
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_shop'];
            $data = json_encode($_POST['list_bran']);
            $pro_id = $_POST['pro_id'];

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_shop_share_product_to_branch');

            $params = [
                'user_id' => $user_id,
                'data' => $data,
                'pro_id' => $pro_id,
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function get_product_has_shared($user_id, $pro_type, $type = "shop")
    {
        $type_value = ['shop', 'branch'];
        if(!in_array($type, $type_value)) {
            return false;
        }

        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_product_has_shared');
        $url = str_replace(['{$user_id}','{$pro_type}','{$type}'], [$user_id,$pro_type,$type], $url);
        $params = null;
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] != 1) {
            return false;
        } else {
            return $data_return = [
                'list_branch' => $make_call['data']['list_branch'],
                'list_cate' => $make_call['data']['list_cate'],
                'list_products' => $make_call['data']['list_products'],
            ];
        }
    }

    public function change_status_product_has_shared()
    {
        # code api_change_status_product_has_shared
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_id'];
            $list_pro_id = json_encode([$_POST['list_pro_id']]);
            $status = $_POST['status'];

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_change_status_product_has_shared');

            $params = [
                'user_id' => $user_id,
                'list_pro_id' => $list_pro_id,
                'status' => $status,
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function branch_get_list_order($user_id, $pro_type, $start_date, $end_date, $order_id, $customer_name, $pro_name, $transporters, $order_status,$page)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_list_order');
        $url = str_replace(['{$user_id}','{$pro_type}','{$start_date}','{$end_date}','{$order_id}','{$customer_name}','{$pro_name}','{$transporters}','{$order_status}','{$page}'], [$user_id,$pro_type,$start_date,$end_date,$order_id,$customer_name,$pro_name,$transporters,$order_status,$page], $url);
        if($pro_type === '') {
            $url = str_replace('&pro_type=', '', $url);
        }
        if($start_date === '') {
            $url = str_replace('&start_date=', '', $url);
        }
        if($end_date === '') {
            $url = str_replace('&end_date=', '', $url);
        }
        if($order_id === '') {
            $url = str_replace('&order_id=', '', $url);
        }
        if($customer_name === '') {
            $url = str_replace('&customer_name=', '', $url);
        }
        if($pro_name === '') {
            $url = str_replace('&pro_name=', '', $url);
        }
        if($transporters === '') {
            $url = str_replace('&transporters=', '', $url);
        }
        if($order_status === '') {
            $url = str_replace('&order_status=', '', $url);
        }

        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'orders' => $make_call['data'],
                'total' => $make_call['total'],
            ];

            return $data_return;
        }
    }

    public function user_get_list_order($pro_type, $start_date, $end_date, $order_id, $customer_name, $pro_name, $transporters, $order_status,$page)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_user_get_list_order');
        $url = str_replace(['{$pro_type}','{$start_date}','{$end_date}','{$order_id}','{$customer_name}','{$pro_name}','{$transporters}','{$order_status}','{$page}'], [$pro_type,$start_date,$end_date,$order_id,$customer_name,$pro_name,$transporters,$order_status,$page], $url);
        if($pro_type === '') {
            $url = str_replace('&pro_type=', '', $url);
        }
        if($start_date === '') {
            $url = str_replace('&start_date=', '', $url);
        }
        if($end_date === '') {
            $url = str_replace('&end_date=', '', $url);
        }
        if($order_id === '') {
            $url = str_replace('&order_id=', '', $url);
        }
        if($customer_name === '') {
            $url = str_replace('&customer_name=', '', $url);
        }
        if($pro_name === '') {
            $url = str_replace('&pro_name=', '', $url);
        }
        if($transporters === '') {
            $url = str_replace('&transporters=', '', $url);
        }
        if($order_status === '') {
            $url = str_replace('&order_status=', '', $url);
        }

        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);
        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'orders' => $make_call['data'],
                'total' => $make_call['total'],
            ];

            return $data_return;
        }
    }

    public function branch_get_order_detail($user_id, $order_id, $type)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_list_order_item');
        $url = str_replace(['{$user_id}','{$order_id}','{$type}'], [$user_id,$order_id,$type], $url);
        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'order' => $make_call['data'],
            ];

            return $data_return;
        }
    }

    public function user_get_order_detail($order_id, $type)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data detail service affiliate
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_user_list_order_item');
        $url = str_replace(['{$order_id}','{$type}'], [$order_id,$type], $url);

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'order' => $make_call['data'],
            ];

            return $data_return;
        }
    }

    public function update_status_branch_get_order_detail()
    {
        # code... api_update_status_list_order_item
        $x=1;
        if($this->input->is_ajax_request()) {
            $data_return = [];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            $this->config->load('config_api_aff');
            $url = $this->config->item('api_update_status_list_order_item');
            $params = [
                'order_id' => $_POST['order_id'],
                'type' => $_POST['type'],
                'order_status' => $_POST['order_status'],
                'user_id' => $_POST['user_id'],
                'cancel_reason' => '',
            ];

            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);

            echo $make_call; die;
        }
    }

    public function update_status_user_get_order_detail()
    {
        # code... api_update_status_list_order_item
        if($this->input->is_ajax_request()) {
            $data_return = [];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_update_status_user_list_order_item');
            $params = [
                'order_id' => $_POST['order_id'],
                'order_status' => $_POST['order_status'],
                'cancel_reason' => '',
            ];
            $url .= "?" . http_build_query($params);

            $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);

            echo $make_call; die;
        }
    }

    public function branch_get_list_content($user_id, $type, $page, $title, $cate)
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
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_list_content');
        $url = str_replace(['{$user_id}','{$type}','{$page}','{$title}','{$cate}'], [$user_id,$type,$page,$title,$cate], $url);
        if($title === '') {
            $url = str_replace('&title=', '', $url);
        }
        if($cate === '') {
            $url = str_replace('&cate=', '', $url);
        }
        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'list_cate' => $make_call['data']['list_cate'],
                'list_news' => $make_call['data']['list_news'],
                'list_branch' => $make_call['data']['list_branch'],
                'total' => $make_call['data']['total'],
            ];

            return $data_return;
        }
    }

    public function shop_share_content_to_branch()
    {
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_shop'];
            $data = json_encode($_POST['list_bran']);
            $not_id = $_POST['not_id'];

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            $this->config->load('config_api_aff');
            $url = $this->config->item('api_shop_share_content_to_branch');

            $params = [
                'user_id' => $user_id,
                'data' => $data,
                'not_id' => $not_id,
            ];

            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function change_status_content_post_by_self()
    {
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_id'];
            $list_not_id = is_array($_POST['list_not_id']) ? '['.implode(',', $_POST['list_not_id']).']' : json_encode([$_POST['list_not_id']]);
            $status = $_POST['status'];
            $type = $_POST['type']; // [shop, branch]

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_change_status_content_post_by_self');

            $params = [
                'user_id' => $user_id,
                'list_not_id' => $list_not_id,
                'status' => $status,
                'type' => $type,
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function branch_get_content_has_shared($user_id, $type, $page, $title, $cate, $branch)
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
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_content_has_shared');
        $url = str_replace(['{$user_id}','{$type}','{$page}','{$title}','{$cate}','{$branch}'], [$user_id,$type,$page,$title,$cate, $branch], $url);
        if($title === '') {
            $url = str_replace('&title=', '', $url);
        }
        if($cate === '') {
            $url = str_replace('&cate=', '', $url);
        }
        $params = null;

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        // set data return
        if($make_call['status'] != 1) {
            return [];
        } else {
            $data_return = [
                'list_cate' => $make_call['data']['list_cate'],
                'list_news' => $make_call['data']['list_news'],
                'list_branch' => $make_call['data']['list_branch'],
                'total' => $make_call['data']['total'],
            ];

            return $data_return;
        }
    }

    public function change_status_content_has_shared()
    {
        # code api_change_status_product_has_shared
        /**
         * {
         * "status": 1,
         * "msg": "Thành Công"
         * }
         */
        if($this->input->is_ajax_request()) {
            $user_id = $_POST['user_id'];
            $list_not_id = json_encode($_POST['list_not_id']);
            $status = $_POST['status'];

            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }
            $this->config->load('config_api_aff');
            $url = $this->config->item('api_change_status_content_has_shared');

            $params = [
                'user_id' => $user_id,
                'list_not_id' => $list_not_id,
                'status' => $status,
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            echo $make_call;die;
        }
    }

    public function get_voucher_detail_on_azibai($shop_user_id, $voucher_id)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_voucher_detail_for_client');
        $url = str_replace(['{$voucher_id}'],[$voucher_id],$url);
        $params = [
            "user_id" => $shop_user_id
        ];
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $data_return = [
                "detail_voucher"=>$make_call['data']
            ];
        }
        return $data_return;
    }

    public function buy_voucher_on_azibai()
    {
        function execPostRequest($url, $data)
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
            );
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $error_msg = curl_error($ch);
            }
            curl_close($ch);
            return $result;
        }

        $this->load->library('utilslv');
        $action = new utilslv();
        $userId = (int)$this->session->userdata('sessionUser');
        if ($userId != (int)$_POST["user_id"]) {
            $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');
        } else { // Check admin role here 
            $data_return = [];
            $rent_header = null;
            if($this->session->userdata('token')) {
                $token = $this->session->userdata('token');
                $rent_header[] = "Authorization: Bearer $token" ;
                $rent_header[] = "Content-Type: multipart/form-data";
            }

            // data statistic affiliate order
            $url = $this->config->item('api_aff_add_order');
            $user_affiliate_key = $_POST['user_affiliate_key'];
            $this->load->model('user_model');
            $user_affiliate_id = $this->user_model->get("use_id","af_key = '$user_affiliate_key'")->use_id;
            $user_affiliate_id > 0 ? "" : $user_affiliate_id = $_POST["user_id"];

            $params = [
                'package_id'        => !empty($_POST['id']) ? $_POST['id'] : '',
                'limit'             => isset($_POST['limit']) && $_POST['limit']> 1 ? $_POST['limit'] : 1,
                'user_id'           => !empty($_POST['user_id']) ? $_POST['user_id'] : '',
                'user_affiliate_id' => $user_affiliate_id,
                'type_pay'          => $_POST['type_pay'] > 0 ? $_POST['type_pay'] : 0,
                'type_affiliate'    => $_POST['type_affiliate'] > 0 ? $_POST['type_affiliate'] : 0,
                'discount_type'     => $_POST['discount_type'] > 0 ? $_POST['discount_type'] : 1,
            ];

            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);
            if($make_call['status'] == 1) {
                $return = array('error' => false, 'message' => 'Thành công',
                'order_id' => $make_call['data']['order_id'],
                'amount' => $make_call['data']['iAmount'],
                'sServiceName' => $make_call['data']['sServiceName'],
                'link_pay' => '');
            }else {
                $return = array('error' => true, 'message' => $make_call['msg'], 'link_pay' => '');
                    echo json_encode($return);
                    die();
            }
            // dd($make_call);die;
            $name_package =!empty($return['sServiceName']) ? $return['sServiceName'] : 'Dịch vụ';
            $package = $params['package_id'];
            if (!empty($_POST['type_pay']) && !empty($return['order_id']) && !empty($return['amount'])) 
            {
                if ($_POST['type_pay'] == 1) 
                {
                    $endpoint = END_POINT;
                    $partnerCode = PARTNER_CODE;
                    $accessKey = ACCESS_KEY;
                    $serectkey = SERECT_KEY;
                    $orderInfo = "Mua gói " . $name_package;
                    $returnUrl = base_url() . 'shop/service/notify';
                    $notifyurl = base_url() . 'shop/service/up-package';
                    $amount = $return['amount']."";
                    $orderid = 'Azibai-'. $return['order_id']."";
                    $requestId = 'Azibai-'. $return['order_id']."";
                    $requestType = "captureMoMoWallet";
                    $extraData = "package={$package};name={$name_package}";
                    $rawHash = "partnerCode=".$partnerCode."&accessKey=".$accessKey."&requestId=".$requestId."&amount=".$amount."&orderId=".$orderid."&orderInfo=".$orderInfo."&returnUrl=".$returnUrl."&notifyUrl=".$notifyurl."&extraData=".$extraData;
                    $signature = hash_hmac("sha256", $rawHash, $serectkey);
                    $data_mono =  array(
                        'partnerCode' => $partnerCode,
                        'accessKey' => $accessKey,
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderid,
                        'orderInfo' => $orderInfo,
                        'returnUrl' => $returnUrl,
                        'notifyUrl' => $notifyurl,
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature
                    );
                    $result_momo = execPostRequest($endpoint, json_encode($data_mono));
                    $return['link_pay'] = $result_momo;
                } 
                else if ($_POST['type_pay'] > 1) 
                {
                    $x=1;
                    $this->load->model('nganluong_model');
                    $user_info = $this->user_model->get('*', 'use_id = ' . $this->session->userdata('sessionUser'));

                    $payment_method = $_POST['type_pay'];
                    $bank_code = $_POST['bankcode']; // done
                    $total_amount = $return['amount'].""; // done
                    $order_id = 'Azibai-'. $return['order_id']."";   // done

                    $return_url = base_url() . 'shop/service/notify?package='.$package.'&name='.$name_package;
                    $cancel_url = base_url() . 'shop/service/cancel-notify?package='.$package.'&name='.$name_package;
                    $array_items = array();
                    $fee_shipping = 0;
                    $order_description = "";
                    $order_code = $order_id;
                    $payment_type = 1;
                    $discount_amount = 0;
                    $tax_amount = 0;
                    $buyer_fullname = $user_info->use_fullname;
                    $buyer_email = !empty($user_info->use_email) ? $user_info->use_email : 'info@azibai.com';
                    $buyer_mobile = $user_info->use_mobile;
                    $buyer_address = $user_info->use_address;

                    if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {

                        if ($payment_method == 3) 
                        {
                            $nl_result = $this->nganluong_model->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

                            $return['link_pay'] = $nl_result;

                        } 
                        else if ($payment_method == 2 && $bank_code != '') 
                        {

                            $nl_result = $this->nganluong_model->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount,
                                $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                                $buyer_address, $array_items);

                            $return['link_pay'] = $nl_result;

                        }
                    }
                }
            }
            else if ($return['error'] != true) 
            {
                $logaction = 'Bạn đã mua thành công gói ' . $return['sServiceName'] . '. Số tiền ' . number_format($return['amount'],0,'.',',') . ' đ';
                $this->session->set_flashdata('flash_message_success', $logaction);
            }
        }
        echo json_encode($return);
        exit();
    }

    public function tab_shop_person($page, $limit, $user_id, $type, $search, $pro_quality, $pro_saleoff, $pro_category, $price_from, $price_to)
    {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        $user_id = 16373;
        $this->config->load('config_api_aff');
        $url = $this->config->item('api_list_section_shop_person');
        $params = [
            "page" => $page,
            "limit" => $limit,
            "user_id" => $user_id,
            "type" => $type,
            "person_id" => $user_id,
            "search" => $search,
            "pro_quality" => $pro_quality,
            "pro_saleoff" => $pro_saleoff,
            "pro_category" => $pro_category,
            "price_from" => $price_from,
            "price_to" => $price_to,
        ];
        $params = array_filter($params, function ($v)
        {
            return $v != '' || $v == '0';
        });

        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $data_return = [
                "section"=>$make_call['data'],
                "pagination" => $make_call["pagination"]
            ];
        }
        // dd($make_call);die;
        return $data_return;
    }

    public function check_list_config_service($shop_user_id) {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_check_list_has_config');
        $params = [
            "user_id" => $shop_user_id
        ];
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $data_return = [
                "data_config_status"=>$make_call['data']
            ];
        }

        // $data_return = [
        //     "data_config_status"=>[
        //         "setting_pay" => 1,
        //         "setting_transport" => 1,
        //     ]
        // ];

        return $data_return;
    }

    public function get_user_config_ghn($shop_user_id) {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_config_gnh');
        $params = [
            "user_id" => $shop_user_id
        ];
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $data_return = [
                "data_config"=>$make_call['data']
            ];
        }

        return $data_return;
    }

    public function create_user_config_ghn($shop_user_id) {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];
        if($this->input->is_ajax_request() && !empty($this->session->userdata('token')) && $shop_user_id > 0) {
            $rent_header = array();
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_create_config_gnh');
            $url .= "?user_id={$shop_user_id}";
            $params = [
                "user_name" => $_REQUEST['user_name'],
                "secret_key" => $_REQUEST['secret_key'],
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            if($make_call['status'] == 1) {
                $result["err"] = false;
                $result["mgs"] = $make_call['msg'];
                $result["data"] = $make_call['data'];
            } else {
                $result["mgs"] = $make_call['msg'];
            }
        }

        echo json_encode($result);die;
    }

    public function get_user_config_nganluong($shop_user_id) {
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }

        $this->config->load('config_api_aff');
        $url = $this->config->item('api_get_config_nganluong');
        $params = [
            "user_id" => $shop_user_id
        ];
        $make_call = $this->api_lib->callAPI('GET', $url, $params, $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            $data_return = [
                "data_config"=>$make_call['data']
            ];
        }

        return $data_return;
    }

    public function upfile_config_nganluong($shop_user_id) {

        $result = '';
        if($this->input->is_ajax_request() && !empty($this->session->userdata('token')) && $shop_user_id>0) {
            $params = [
                'fileUpload' => new \CurlFile($_FILES['fileUpload']['tmp_name'], $_FILES['fileUpload']['type'], $_FILES['fileUpload']['name']),
            ];
            $this->config->load('config_api');
            $url = $this->config->item('api_upfile_config_nganluong');
            $url .= "?user_id={$shop_user_id}";
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
            $result = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
        }

        echo $result; die;
    }

    public function create_user_config_nganluong($shop_user_id) {
        $result = [
            'err'   =>  true,
            'mgs'   =>  'Lỗi xử lý !!!',
            'data'  => '',
        ];
        if($this->input->is_ajax_request() && !empty($this->session->userdata('token')) && $shop_user_id > 0) {
            $rent_header = array();
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";

            $this->config->load('config_api_aff');
            $url = $this->config->item('api_create_config_nganluong');
            $url .= "?user_id={$shop_user_id}";
            $params = [
                "merchant_id" => $_REQUEST['merchant_id'],
                "merchant_pass" => $_REQUEST['merchant_pass'],
                "receiver" => $_REQUEST['receiver'],
            ];
            $make_call = $this->api_lib->callAPI('POST', $url, $params, $rent_header);
            $make_call = json_decode($make_call, true);

            if($make_call['status'] == 1) {
                $result["err"] = false;
                $result["mgs"] = $make_call['msg'];
                $result["data"] = $make_call['data'];
            } else {
                $result["mgs"] = $make_call['msg'];
            }
        }

        echo json_encode($result);die;
    }
}

/* End of file Api_affiliate.php */


?>