<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Money extends MY_Controller {

    function __construct() {
        parent::__construct();

        // Check login
        if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin'))) {
            redirect(base_url().'azi-admin', 'location');
            die();
        }

        $config = [
            'full_tag_open' => '<nav aria-label="Page navigation example"><ul class="pagination pagination-center-style justify-content-center">',
            'full_tag_close' => '</ul></nav>',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'next_link' => '<span aria-hidden="true">&gt;</span>',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'prev_link' => '<span aria-hidden="true">&lt;</span>',
            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_clos' => '</li>',
            'anchor_class' => 'class="page-link" ',
            'first_link' => false,
            'last_link' => false,
        ];

        $this->_config = $config;
    }

    public function index ($page) {
        $data['aStatus'] = array(
            1 => 'Mới',
            2 => 'Đang chuyển tiền',
            3 => 'Hoàn tất chuyển tiền',
            4 => 'Khiếu nại',
            5 => 'Đang xử lý khiếu nại'
        );
        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $url = $this->config->item('listtransfer');

        $page   = $page > 1 ? $page : 1;

        $url .= '?page='.$page;

        // Tìm kiếm theo loại thẻ
        if(isset($_REQUEST['search']) && $_REQUEST['search'] != '') {
            $url .= '&search='.$_REQUEST['search'];
        }

        // Tìm kiếm theo loại thẻ
        if(isset($_REQUEST['bank_type']) && $_REQUEST['bank_type'] != '') {
            $url .= '&bank_type='.$_REQUEST['bank_type'];
        }

        // Tìm kiếm theo thời gian
        if(isset($_REQUEST['from'])  && $_REQUEST['from'] != '') {
            $time_start = date_create($_REQUEST['from']);
            $url .= '&time_start='.date_format($time_start,"d-m-Y");
        }

        if(isset($_REQUEST['to']) && $_REQUEST['to'] != '') {
            $time_end = date_create($_REQUEST['to']);
            $url .= '&time_end='.date_format($time_end,"d-m-Y");
        }

        if(isset($_REQUEST['status']) && $_REQUEST['status'] != '') {
            $url .= '&status='.$_REQUEST['status'];
        }

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            if(!empty($make_call['data'])){
                $data['aListTransfer'] = $make_call['data'];
                $total = !empty($make_call['total']) ? $make_call['total'] : 0;
                $limit = !empty($make_call['per_page']) ? $make_call['per_page'] : 10;
                
                $config = $this->_config;
                // Set base_url for every links
                $config["base_url"] = azibai_url() . '/azi-admin/listtransfer';
                $config["total_rows"] = $total;
                $config["per_page"] = $limit;
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] = 2;
                $config['uri_segment'] = 3;
                $suffix_str = $_SERVER["QUERY_STRING"];
                $config['suffix'] = '';
                if (!empty($suffix_str)) 
                {   
                    $config['suffix'] = '?'. rtrim($_SERVER["QUERY_STRING"], '&');
                }
                $config['first_url'] = $config['base_url'].$config['suffix'];

                $this->load->library('pagination', $config);
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
            }

            if(!empty($make_call['aStatus'])) {
                $data['aStatus'] = $make_call['aStatus'];
            }
        }else if($make_call['status'] == 0) {
            $data['msg']    = $make_call['msg'];
        }

        $data['menu_active'] = 'money';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/money/index', $data);
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Ajax Get List log
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: array
     *
     ***************************************************************************
    */

    public function ajaxUpdateStatus($iMoneyId = 0) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Cập nhật thất bại!';
        $result['type']     = 'error';

        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: application/json";
        }
        // data statistic affiliate order
        $url = $this->config->item('updatestatus').'/'.$iMoneyId;
        $params = array(
            'status'    => $this->input->post('status')
        );

        $make_call = $this->callAPI('PUT', $url, json_encode($params), $rent_header);
        $make_call = json_decode($make_call, true);
        if($make_call['status'] == 1) {
            $result['message']  = 'Cập nhật thành công!';
            $result['type']     = 'success';
        }

        echo json_encode($result);
        die();
    }

    /**
     ***************************************************************************
     * Created: 2019/09/04
     * Ajax Get List log
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: array
     *
     ***************************************************************************
    */

    public function ajaxGetLogs($iMoneyId = 0) {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header('Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept');

        $result['message']  = 'Lấy log thất bại!';
        $result['type']     = 'error';

        $data_return = [];
        $rent_header = null;
        if($this->session->userdata('token')) {
            $token = $this->session->userdata('token');
            $rent_header[] = "Authorization: Bearer $token" ;
            $rent_header[] = "Content-Type: multipart/form-data";
        }
        // data statistic affiliate order
        $url = $this->config->item('listlog').'/'.$iMoneyId;

        $make_call = $this->callAPI('GET', $url, array(), $rent_header);
        $make_call = json_decode($make_call, true);

        if($make_call['status'] == 1) {
            if(!empty($make_call['data'])){
                $result['data']     = $make_call['data'];
                $result['message']  = 'Lấy log thành công!';
                $result['type']     = 'success';
            }
        }

        echo json_encode($result);
        die();
    }
}