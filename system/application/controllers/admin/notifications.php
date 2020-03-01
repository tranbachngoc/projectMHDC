<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends MY_Controller
{
    public $info_public = [];
    

    function __construct()
    {
        parent::__construct();

        if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
        {
            redirect(base_url().'azi-admin', 'location');
            die();
        }

        #END CHECK LOGIN
        $this->load->model('user_model');
        $this->load->library('Mobile_Detect');
        
        $detect = new Mobile_Detect();
        $data['isMobile'] = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = 1;
            if($detect->isiOS()){
                $data['isIOS'] = 1;
            }
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

        $this->load->vars($data);
    }

    public function delete($id) 
    {
        $jData = curl_data(LINK_NOTIFICATION .'/schedules/'. $id . '/delete' , [],'','','DELETE');
        echo $jData;
        exit();
    }

    // 
    public function get_notification($id) 
    {  
        $jData = curl_data(LINK_NOTIFICATION .'/'. $id . '/schedules' , [],'','','GET');
        echo $jData;
        exit();
    }

    //
    public function index() 
    {
        
        $aData = array(
            'search' => !empty($_REQUEST['search']) ? $_REQUEST['search'] : '',
            'from'   => !empty($_REQUEST['from']) ? $_REQUEST['from'] : '',
            'to'     => !empty($_REQUEST['to']) ? $_REQUEST['to'] : '',
            'page'   => $page > 1 ? $page : 1,
        );
        $jData = curl_data(LINK_AZI, $aData,'','','GET');
        if (!empty($jData)) 
        {
            $data['result'] = json_decode($jData,true);

            $total = !empty($data['result']['data']['total']) ? $data['result']['data']['total'] : 0;
            $limit = !empty($data['result']['data']['per_page']) ? $data['result']['data']['per_page'] : 20;
            
            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/notifications';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
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
        $data['menu_active'] = 'index';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/index', $data);
    }

    public function push() 
    {

        $result = [
            'data'  => ''
        ];
        if (!empty($this->input->post('content'))) 
        {
            $aData = [
                'content' => $this->input->post('content'),
                'link' => $this->input->post('link'),
        ];
            $jData = curl_data(LINK_AZI . '/push' , $aData,'','','POST');            
        } 
        else if (!empty($this->input->post('schedules'))) 
        {
            $aData = ['schedules' => $this->input->post('schedules')];

            // fix tạm thời
            $post = array();
            $this->http_build_query_for_curl($aData, $post);
            $aData = $post;
            
            $jData = curl_data(LINK_AZI . '/schedule' , $aData,'','','POST');
        }
        if (!empty($jData)) 
        {
            $result['data'] = json_decode($jData,true);
        }
        echo json_encode($result);
        exit();
    }

    public function page_push() 
    {
        $data['menu_active'] = 'index';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/add', $data);
    }

    public function delete_push($id) 
    {
        $jData = curl_data(LINK_AZI .'/'. $id . '/delete' , [],'','','DELETE');
        echo $jData;
        exit();
    }

    //
    public function business_news($page) 
    {
        $aData = array(
            'search' => !empty($_REQUEST['search']) ? $_REQUEST['search'] : '', 
            'cate_id'=> !empty($_REQUEST['cate_id']) ? $_REQUEST['cate_id'] : '',
            'status' => !empty($_REQUEST['status']) ? $_REQUEST['status'] : '',
            'from'   => !empty($_REQUEST['from']) ? $_REQUEST['from'] : '',
            'to'     => !empty($_REQUEST['to']) ? $_REQUEST['to'] : '',
            'page'   => $page > 1 ? $page : 1,
        );

        $jData = curl_data(LINK_BUSINESS_NEWS, $aData,'','','GET');
        if (!empty($jData)) 
        {
            $data['result'] = json_decode($jData,true);
            $total = !empty($data['result']['data']['total']) ? $data['result']['data']['total'] : 0;
            $limit = !empty($data['result']['data']['per_page']) ? $data['result']['data']['per_page'] : 20;
            
            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/notifications/business-news';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
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

        $data['list_cate'] = $this->db->query("SELECT cat_id, cat_name FROM tbtt_category WHERE cat_level = 0 AND cate_type = 2 AND cat_status = 1")->result();
        $data['menu_active'] = 'business-news';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/business-news', $data);
    }

    //
    public function personal_news($page) 
    {
        $aData = array(
            'search' => !empty($_REQUEST['search']) ? $_REQUEST['search'] : '', 
            'cate_id'=> !empty($_REQUEST['cate_id']) ? $_REQUEST['cate_id'] : '',
            'status' => !empty($_REQUEST['status']) ? $_REQUEST['status'] : '',
            'from'   => !empty($_REQUEST['from']) ? $_REQUEST['from'] : '',
            'to'     => !empty($_REQUEST['to']) ? $_REQUEST['to'] : '',
            'page'   => $page > 1 ? $page : 1,
        );

        $jData = curl_data(LINK_PERSONAL_NEWS, $aData,'','','GET');

        
        if (!empty($jData)) 
        {
            $data['result'] = json_decode($jData,true);
            $total = !empty($data['result']['data']['total']) ? $data['result']['data']['total'] : 0;
            $limit = !empty($data['result']['data']['per_page']) ? $data['result']['data']['per_page'] : 20;
            
            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/notifications/personal-news';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
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

        $data['list_cate'] = $this->db->query("SELECT cat_id, cat_name FROM tbtt_category WHERE cat_level = 0 AND cate_type = 2 AND cat_status = 1")->result();

        $data['menu_active'] = 'personal-news';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/personal-news', $data);
    }

    private function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {

        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }

        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                $this->http_build_query_for_curl( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
    }

    // 
    public function push_news($id) 
    {

        $result = [
            'data'  => ''
        ];
        if (!empty($this->input->post('content'))) 
        {
            $aData = ['content' => $this->input->post('content')];
            $jData = curl_data(LINK_NOTIFICATION .'/'. $id . '/push' , $aData,'','','POST');            
        } 
        else if (!empty($this->input->post('schedules'))) 
        {
            $aData = ['schedules' => $this->input->post('schedules')];

            // fix tạm thời
            $post = array();
            $this->http_build_query_for_curl($aData, $post);
            $aData = $post;
            
            $jData = curl_data(LINK_NOTIFICATION .'/'. $id . '/schedule' , $aData,'','','POST');
        }

        if (!empty($jData)) 
        {
            $result['data'] = json_decode($jData,true);
        }
        echo json_encode($result);
        exit();
    }

    //
    public function get_catchild_link(){
        $cat_id = (int)$this->input->post('cat_id');
        $cat_child = $this->db->query("SELECT id, name FROM tbtt_category_links WHERE parent_id = ".$cat_id." AND status = 1")->result();
        echo json_encode($cat_child);
        exit();
    }

    public function links($page) 
    {
        $aData = array(
            'search' => !empty($_REQUEST['search']) ? $_REQUEST['search'] : '',
            'status' => (isset($_REQUEST['status']) && $_REQUEST['status'] != '') ? $_REQUEST['status'] : '',
            'from'   => !empty($_REQUEST['from']) ? $_REQUEST['from'] : '',
            'to'     => !empty($_REQUEST['to']) ? $_REQUEST['to'] : '',
            'page'   => $page > 1 ? $page : 1,
        );
        if(!empty($_REQUEST['catechild_id']))
        {
            $aData['cate_id'] = $_REQUEST['catechild_id'];
        }else{
            if(!empty($_REQUEST['cate_id']))
            {
                $aData['cate_id'] = $_REQUEST['cate_id'];
            }
        }
        if(!empty($_REQUEST['catechild_id'])){
            $cat_child = $this->db->query("SELECT id, name FROM tbtt_category_links WHERE parent_id = ".(int)$_REQUEST['cate_id']." AND status = 1")->result();
            $data['cat_child'] = $cat_child;
        }
        $jData = curl_data(LINK_LINKS, $aData,'','','GET');

        if (!empty($jData)) 
        {
            $data['result'] = json_decode($jData,true);

            $total = !empty($data['result']['data']['total']) ? $data['result']['data']['total'] : 0;
            $limit = !empty($data['result']['data']['per_page']) ? $data['result']['data']['per_page'] : 20;
            
            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/notifications/links';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
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

        $data['list_cate'] = $this->db->query("SELECT id, name FROM tbtt_category_links WHERE parent_id = 0 AND status = 1")->result();
        $data['menu_active'] = 'links';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/links', $data);
    }
    
    public function push_links($link_type, $id) 
    {

        $result = [
            'data'  => ''
        ];
        if (!empty($this->input->post('content'))) 
        {
            $aData = ['content' => $this->input->post('content')];
            $jData = curl_data(LINK_NOTIFICATION_LINK . '/' . $link_type .'/'. $id . '/push' , $aData,'','','POST');            
        } 
        else if (!empty($this->input->post('schedules'))) 
        {
            $aData = ['schedules' => $this->input->post('schedules')];

            // fix tạm thời
            $post = array();
            $this->http_build_query_for_curl($aData, $post);
            $aData = $post;
            
            $jData = curl_data(LINK_NOTIFICATION_LINK . '/' . $link_type .'/'. $id . '/schedule' , $aData,'','','POST');
        }
        if (!empty($jData)) 
        {
            $result['data'] = json_decode($jData,true);
        }
        echo json_encode($result);
        exit();
    }

    public function delete_link($id) 
    {
        $jData = curl_data(LINK_NOTIFICATION_LINK .'/schedules/'. $id . '/delete' , [],'','','DELETE');
        echo $jData;
        exit();
    }

    public function get_notification_link($link_type, $id) 
    {  
        $jData = curl_data(LINK_NOTIFICATION_LINK .'/'. $link_type . '/'. $id . '/schedules' , [],'','','GET');
        echo $jData;
        exit();
    }

    public function list_user($page) 
    {
        $search_phone = $search_user = $search_fullname = '';
        if(isset($_REQUEST['search_user'])){
            if($_REQUEST['search_user'] == 0){
                $search_fullname = $_REQUEST['search'];
            }else{
                if($_REQUEST['search_user'] == 1){
                    $search_phone = $_REQUEST['search'];
                }else{
                    $search_user = $_REQUEST['search'];
                }
            }
        }

        $numpage = 1;
        if(isset($page) && $page > 1){
            $numpage = $page;
        }
        
        $aData = array(
            'page' => $numpage,
            'phone' => $search_phone,
            'fullname' => $search_fullname,
            'username' => $search_user,
            'status' => isset($_REQUEST['status']) ? $_REQUEST['status'] : '',
            'register_date[from]'   => isset($_REQUEST['register_date_from']) ? $_REQUEST['register_date_from'] : '',
            'register_date[to]'   => isset($_REQUEST['register_date_to']) ? $_REQUEST['register_date_to'] : '',
            'lasted_login_date[from]'     => isset($_REQUEST['lasted_login_date_from']) ? $_REQUEST['lasted_login_date_from'] : '',
            'lasted_login_date[to]'     => isset($_REQUEST['lasted_login_date_to']) ? $_REQUEST['lasted_login_date_to'] : '',
            'list_limit'   => 20,
            'show_on_homepage'   => isset($_REQUEST['status_block']) ? $_REQUEST['status_block'] : '',
        );

        $get_token = $this->user_model->get('saved_token', 'use_id = '.(int)$this->session->userdata('sessionUserAdmin'));
        $url = LINK_LIST_USERS;

        $aHeader = false;
        if($get_token->saved_token != ''){
            $aHeader = array('Content-Type: application/json', 'Authorization: Bearer '.$get_token->saved_token);
        }
        $jData = $this->callAPI('GET', $url, $aData, $aHeader);
        
        if (!empty($jData)) 
        {
            $data['result'] = json_decode($jData,true);
            $total = !empty($data['result']['msg']['total']) ? $data['result']['msg']['total'] : 0;
            $limit = !empty($data['result']['msg']['per_page']) ? $data['result']['msg']['per_page'] : 20;
            
            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/notifications/list-user';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
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
            $data['stt'] = ($numpage-1) * $limit;
        }

        $data['menu_active'] = 'list-user';
        $this->set_layout('azi-admin/layout/default-layout');
        $this->load->view('azi-admin/notifications/list-user', $data);
    }
    
    public function change_status_user() 
    {

        $result = [
            'data'  => ''
        ];
        if (!empty($this->input->post('ids'))) 
        {
            $aData = ['ids' => [(int)$this->input->post('ids')]];
            $get_token = $this->user_model->get('saved_token', 'use_id = '.(int)$this->session->userdata('sessionUserAdmin'));
            $aHeader = false;
            if($get_token->saved_token != ''){
                $aHeader = array('Content-Type: application/json', 'Authorization: Bearer '.$get_token->saved_token);
            }
            $jData = $this->callAPI('POST', LINK_STATUS_USERS, json_encode($aData), $aHeader);
        }
        if (!empty($jData)) 
        {
            $result['data'] = json_decode($jData,true);
        }
        echo json_encode($result);
        exit();
    }
    
    public function push_block_news() 
    {
        $result = [
            'data'  => ''
        ];
        if (!empty($this->input->post('ids')))
        {
            $aData = ['ids' => [(int)$this->input->post('ids')]];
            // $jData = curl_data(LINK_PUSH_BLOCK_NEWS , $aData,'','','POST');
            $get_token = $this->user_model->get('saved_token', 'use_id = '.(int)$this->session->userdata('sessionUserAdmin'));
            $aHeader = false;
            if($get_token->saved_token != ''){
                $aHeader = array('Content-Type: application/json', 'Authorization: Bearer '.$get_token->saved_token);
            }
            $jData = $this->callAPI('POST', LINK_PUSH_BLOCK_NEWS, json_encode($aData), $aHeader);
        }
        if (!empty($jData)) 
        {
            $result['data'] = json_decode($jData,true);
        }
        echo json_encode($result);
        exit();
    }
}

