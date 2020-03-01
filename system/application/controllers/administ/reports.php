<?php

#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#

class Reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        #BEGIN: CHECK LOGIN
        if (!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin'))) {
            redirect(base_url() . 'administ', 'location');
            die();
        }
        #END CHECK LOGIN
        #Load language
        $this->lang->load('admin/common');
        $this->lang->load('admin/contact');
        #Load model
        $this->load->model('contact_model');
        $this->load->model('reports_model');
    }

    function index() {
        #BEGIN: Delete
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $this->contact_model->delete($this->input->post('checkone'), "con_id");
            redirect(base_url() . trim(uri_string(), '/'), 'location');
        }
        #END Delete
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'detail');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        #BEGIN: Search & Filter
        $where = 'not_status = 1 AND rp_status = 1 and use_status = 1';
        $sort = 'rpd_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        $where .= ' AND rp_type = 1';
        
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'title':
                    $sortUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $where .= " AND not_title LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'username':
                    $sortUrl .= '/search/username/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/username/keyword/' . $getVar['keyword'];
                    $where .= " AND use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
            $data['filtersearch'] = $getVar['search'];
        }
        #If filter
         
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'datereply':
                    $sortUrl .= '/filter/datereply/key/' . $getVar['key'];
                    $pageUrl .= '/filter/datereply/key/' . $getVar['key'];
                    $where .= " AND not_begindate = " . (float)$getVar['key'];
                    break;
            }
        }
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'title':
                    $pageUrl .= '/sort/title';
                    $sort = "not_title";
                    break;
                case 'username':
                    $pageUrl .= '/sort/username';
                    $sort = "use_username";
                    break;
                case 'begindate':
                    $pageUrl .= '/sort/begindate';
                    $sort = "not_begindate";
                    break;
                case 'id':
                    $pageUrl .= '/sort/id';
                    $sort = "not_id";
                    break;
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $url = base_url() . 'administ/reports/' . $this->uri->segment(3);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['filterSr'] = $url . '/';
        $data['sortUrl'] = $url . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        
        $this->load->model('content_model');
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $limit = settingOtherAdmin;
        $totalRecord = count($this->content_model->fetch_join_3($select, "INNER", "tbtt_report_detail", "not_id = rpd_content", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "not_user = tbtt_user.use_id", $where . ' Group by not_id', $sort, $by));
        $config['base_url'] = $url . '/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $select = "not_id, not_title,id_category, not_begindate, rpd_content, use_id, use_username, use_fullname, use_email, count(rpd_id) as cntReport";
        
        $data['reports'] = $this->content_model->fetch_join_3($select, "INNER", "tbtt_report_detail", "not_id = rpd_content", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "not_user = tbtt_user.use_id", $where . ' Group by not_id', $sort, $by, $start, $limit);
        #Load view
        $this->load->view('admin/report/content', $data);
    }

    function report_pro() {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'detail');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        #BEGIN: Search & Filter
        $where = 'pro_status = 1 AND rp_status = 1 and use_status = 1';
        $sort = 'rpd_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        $where .= ' AND rp_type = 2';
        
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'title':
                    $sortUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $where .= " AND pro_name LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'username':
                    $sortUrl .= '/search/username/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/username/keyword/' . $getVar['keyword'];
                    $where .= " AND use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
            $data['filtersearch'] = $getVar['search'];
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] != FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'datereply':
                    $sortUrl .= '/filter/datereply/key/' . $getVar['key'];
                    $pageUrl .= '/filter/datereply/key/' . $getVar['key'];
                    $where .= " AND pro_begindate = " . (float)$getVar['key'];
                    break;
            }
        }
        
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'title':
                    $pageUrl .= '/sort/title';
                    $sort = "pro_name";
                    break;
                case 'username':
                    $pageUrl .= '/sort/username';
                    $sort = "use_username";
                    break;
                case 'begindate':
                    $pageUrl .= '/sort/begindate';
                    $sort = "pro_begindate";
                    break;
                case 'id':
                    $pageUrl .= '/sort/id';
                    $sort = "pro_id";
                    break;
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $url = base_url() . 'administ/reports/' . $this->uri->segment(3);
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['filterSr'] = $url . '/';
        $data['sortUrl'] = $url . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        
        $this->load->model('product_model');
        
        #BEGIN: Pagination
        $this->load->library('pagination');
        #Count total record
        $limit = settingOtherAdmin;
        $totalRecord = count($this->product_model->fetch_join3('rpd_id', "INNER", "tbtt_report_detail", "pro_id = rpd_product", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "pro_user = tbtt_user.use_id", $where, $sort, $by)['data']);
        $config['base_url'] = $url . '/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        
        #sTT - So thu tu
        $data['sTT'] = $start + 1;
        #Fetch record
        $select = "pro_id, pro_name, pro_category, pro_begindate, rpd_product, use_id, use_username, use_fullname, use_email, count(rpd_id) as cntReport";
        $this->load->model('product_model');
        $data['reports'] = $this->product_model->fetch_join3($select, "INNER", "tbtt_report_detail", "pro_id = rpd_product", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "pro_user = tbtt_user.use_id", $where, $sort, $by, $start, $limit)['data'];
        #BEGIN: Delete
        
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'report_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $id = implode(',', $this->input->post('checkone'));echo $id;
            $this->load->model('report_detail_model');
            //$this->report_detail_model->delete($this->input->post('checkone'), "rpd_id", true);
            redirect($url, 'location');
        }
        #END Delete
        #
        #Load view
        $this->load->view('admin/report/product', $data);
    }

    function rpdetail_content() {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'detail');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        
        $ctenpro = $this->uri->segment(3);
        $this->load->model('content_model');
        if($ctenpro == 'content'){
            $wh = 'not_id = '.(int)$getVar['detail'];
            $selectt = 'not_title';
            $title = $this->content_model->get($selectt, $wh)->not_title;
        }else{
            $wh = 'pro_id = '.(int)$getVar['detail'];
            $selectt = 'pro_name';
            $title = $this->product_model->get($selectt, $wh)->pro_name;
        }
        $data['title'] = $title;
        
        #BEGIN: Search & Filter
        $where = 'not_status = 1 AND rp_status = 1 and use_status = 1 AND not_id = ' . (int)$getVar['detail'];
        $sort = 'rpd_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'title':
                    $sortUrl = '/search/title/keyword/' . $getVar['keyword'];
                    $pageUrl = '/search/title/keyword/' . $getVar['keyword'];
                    $where .= " AND rp_desc LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'username':
                    $sortUrl = '/search/username/keyword/' . $getVar['keyword'];
                    $pageUrl = '/search/username/keyword/' . $getVar['keyword'];
                    $where .= " AND use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
            $data['filtersearch'] = $getVar['search'];
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] !== FALSE && trim($getVar['key']) != '') {
            
                $sortUrl = '/filter/rpd_status/key/' . $getVar['key'];
                $pageUrl = '/filter/rpd_status/key/' . $getVar['key'];
                if($getVar['key'] != 3){
                    $where .= " AND rpd_status = " . (int)$getVar['key'];
                }
            }else{
                $getVar['key'] = 3;
            }
        $data['filterStatus'] = $getVar['key'];
        
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'title':
                    $pageUrl .= '/sort/title';
                    $sort = "rp_desc";
                    break;
                case 'username':
                    $pageUrl .= '/sort/username';
                    $sort = "use_username";
                    break;
                case 'rpd_status':
                    $pageUrl .= '/sort/rpd_status';
                    $sort = "rpd_status";
                    break;
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $url = base_url() . 'administ/reports/' . $this->uri->segment(3) . '/detail/' . $getVar['detail'];
        $data['sortUrl'] = $url . $sortUrl.'/' . 'sort/';
        $data['srUrl'] = $url.'/';
        $data['filterUrl'] = $url;
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #
        #BEGIN: Pagination
        $limit = settingOtherAdmin;
        $this->load->library('pagination');
        #Count total record
        $totalRecord = count($this->content_model->fetch_join_3('rpd_id', "INNER", "tbtt_report_detail", "not_id = rpd_content", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "rpd_by_user = tbtt_user.use_id", $where,'rpd_id'));
        $config['base_url'] = $url .'/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        $data['sTT'] = $start + 1;
        $select = "rp_id, rp_desc, rpd_reason, not_id, not_title, not_begindate, rpd_id, rpd_content, rpd_type, rpd_status, use_id, use_username, use_fullname, use_email";
        $data['reports'] = $this->content_model->fetch_join_3($select, "INNER", "tbtt_report_detail", "not_id = rpd_content", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "rpd_by_user = tbtt_user.use_id", $where, $sort, $by, $start, $limit);
        
        #BEGIN: Delete
        
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'report_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $id = implode(',', $this->input->post('checkone'));
            $this->load->model('report_detail_model');
            $this->report_detail_model->delete($this->input->post('checkone'), "rpd_id", true);
            redirect($url, 'location');
        }
        #END Delete
        
        #Load view
        $this->load->view('admin/report/detail_report', $data);
    }

    function rpdetail_pro() {
        #BEGIN: CHECK PERMISSION
        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_view')) {
            show_error($this->lang->line('unallowed_use_permission'));
            die();
        }
        #END CHECK PERMISSION
        
        #Define url for $getVar
        $action = array('search', 'keyword', 'filter', 'key', 'sort', 'by', 'page', 'status', 'detail');
        $getVar = $this->uri->uri_to_assoc(2, $action);
        
        $ctenpro = $this->uri->segment(3);
        $this->load->model('content_model');
        if($ctenpro == 'content'){
            $wh = 'not_id = '.(int)$getVar['detail'];
            $selectt = 'not_title';
            $title = $this->content_model->get($selectt, $wh)->not_title;
        }else{
            $wh = 'pro_id = '.(int)$getVar['detail'];
            $selectt = 'pro_name';
            $title = $this->product_model->get($selectt, $wh)->pro_name;
        }
        $data['title'] = $title;
        
        #BEGIN: Search & Filter
        $where = 'pro_status = 1 AND rp_status = 1 and use_status = 1 AND pro_id = ' . (int)$getVar['detail'];
        $sort = 'rpd_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        #If search
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            $keyword = $getVar['keyword'];
            switch (strtolower($getVar['search'])) {
                case 'title':
                    $sortUrl = '/search/title/keyword/' . $getVar['keyword'];
                    $pageUrl = '/search/title/keyword/' . $getVar['keyword'];
                    $where .= " AND rp_desc LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
                case 'username':
                    $sortUrl = '/search/username/keyword/' . $getVar['keyword'];
                    $pageUrl = '/search/username/keyword/' . $getVar['keyword'];
                    $where .= " AND use_username LIKE '%" . $this->filter->injection($getVar['keyword']) . "%'";
                    break;
            }
            $data['filtersearch'] = $getVar['search'];
        }
        #If filter
        elseif ($getVar['filter'] != FALSE && trim($getVar['filter']) != '' && $getVar['key'] !== FALSE && trim($getVar['key']) != '') {
            switch (strtolower($getVar['filter'])) {
                case 'rpd_status':
                    $sortUrl = '/filter/rpd_status/key/' . $getVar['key'];
                    $pageUrl = '/filter/rpd_status/key/' . $getVar['key'];
                    if($getVar['key'] != 3){
                        $where .= " AND rpd_status = " . (int)$getVar['key'];
                    }
                    break;
            }
        }else{
            $getVar['key'] = 3;
        }
        $data['filterStatus'] = $getVar['key'];
        
        #If sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'title':
                    $pageUrl .= '/sort/title';
                    $sort = "rp_desc";
                    break;
                case 'username':
                    $pageUrl .= '/sort/username';
                    $sort = "use_username";
                    break;
                case 'rpd_status':
                    $pageUrl .= '/sort/rpd_status';
                    $sort = "rpd_status";
                    break;
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        
        #If have page
        if ($getVar['page'] != FALSE && (int) $getVar['page'] > 0) {
            $start = (int) $getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & Filter
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $url = base_url() . 'administ/reports/' . $this->uri->segment(3) . '/detail/' . $getVar['detail'];
        $data['sortUrl'] = $url . $sortUrl.'/' . 'sort/';
        $data['srUrl'] = $url.'/';
        $data['filterUrl'] = $url;
        $data['pageSort'] = $pageSort;
        #END Create link sort
        
        #BEGIN: Pagination
        $limit = settingOtherAdmin;
        
        $this->load->library('pagination');
        $totalRecord = count($this->product_model->fetch_join3('rpd_id', "INNER", "tbtt_report_detail", "pro_id = rpd_product", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "rpd_by_user = tbtt_user.use_id", $where, $sort, $by,'','','','rpd_id')['data']);
        $config['base_url'] = $url .'/' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 5;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        #END Pagination
        
        $data['sTT'] = $start + 1;
        
        $select = "rp_id, rp_desc, rpd_reason, pro_id, pro_name, pro_begindate, rpd_id, rpd_product, rpd_type, rpd_status, use_id, use_username, use_fullname, use_email";
        $data['reports'] = $this->product_model->fetch_join3($select, "INNER", "tbtt_report_detail", "pro_id = rpd_product", "INNER", "tbtt_reports", "rp_id = rpd_reportid", "INNER", "tbtt_user", "rpd_by_user = tbtt_user.use_id", $where, $sort, $by, $start, $limit,'','rpd_id')['data'];
        
        #BEGIN: Delete
        
        if ($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0) {
            #BEGIN: CHECK PERMISSION
            if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'report_delete')) {
                show_error($this->lang->line('unallowed_use_permission'));
                die();
            }
            #END CHECK PERMISSION
            $id = implode(',', $this->input->post('checkone'));
            $this->load->model('report_detail_model');
            $this->report_detail_model->delete($this->input->post('checkone'), "rpd_id", true);
            redirect($url, 'location');
        }
        #END Delete
        
        #Load view
        $this->load->view('admin/report/detail_report', $data);
    }
    
    function updatestatus(){
        $rpd_id = (int)$this->input->post("rpd_id");
        $rpd_type = (int)$this->input->post("rpd_type");
        $rpd_pronews = (int)$this->input->post("rpd_pronews");
        $rpd_by_user = (int)$this->input->post("rpd_by_user");
        $rpd_status = (int)$this->input->post("rpd_status");
        $this->load->model('report_detail_model');
        
        $where = 'rpd_id = ' . $rpd_id;
        $reportdetail = $this->report_detail_model->get("*","rpd_by_user = " . $rpd_by_user . ' AND ' . $where);
        if(!empty($reportdetail)) {
            $form_data = array(
                "rpd_status" => $rpd_status
            );
            if($reportdetail->rpd_status == 0 && $rpd_status == 1){
                $body_email = $this->input->post("body_email");
                if($body_email != ''){
                    $this->load->model('user_model');
                    
                    if($rpd_type == 1){
                        $tp = 'Bài viết';
                        $getemailto = $this->user_model->fetch_join('use_email', 'LEFT', 'tbtt_content', 'use_id = not_user', 'not_id = '. $rpd_pronews);
                    }else{
                        $tp = 'Sản phẩm';
                        $getemailto = $this->user_model->fetch_join("use_email", "LEFT", "tbtt_product", "use_id = pro_user", "use_status = 1 AND pro_status = 1 AND pro_id = " . $rpd_pronews);
                    }
                    $emailto = $getemailto[0]->use_email;
                    $this->load->library('email');
                    $config['useragent'] = "azibai.com";
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.phpmailer.php'); 
                    require_once($_SERVER['DOCUMENT_ROOT'] . folderWeb .'/PHPMailer/class.pop3.php');

                    $from = GUSER;							
                    $from_name = 'AZIBAI.COM';
                    $subject = 'Báo cáo ' . $tp . ' vi phạm';

                    $body1 = $this->input->post('body_email');
                    
                    $this->report_detail_model->update($form_data,$where);
                    $this->smtpmailer($emailto, $from, $from_name, $subject, $body1);
                }
            }else{
                $this->report_detail_model->update($form_data,$where);
            }
            echo '1'; exit();
        }
        echo '0'; exit();
    }
    
    function view($id) {
        if ($this->session->flashdata('sessionSuccessReply')) {
            $data['successReply'] = true;
        } else {
            $data['successReply'] = false;
            #BEGIN: Get contact by $id
            $contact = $this->contact_model->get("*", "con_id = " . (int) $id);
            if (count($contact) != 1 || !$this->check->is_id($id)) {
                redirect(base_url() . 'administ/contact', 'location');
                die();
            }
            $data['contact'] = $contact;
            #END Get contact by $id
            $this->load->library('bbcode');
            #Get user
            $this->load->model('user_model');
            $data['user'] = $this->user_model->get("use_username, use_fullname, use_email, use_phone, use_yahoo", "use_id = " . $contact->con_user);
            #Update view
            $this->contact_model->update(array('con_view' => 1), "con_id = " . (int) $id);
            $this->load->library('form_validation');
            #BEGIN: Set rules
            $this->form_validation->set_rules('txtContent', 'lang:txtcontent_message_view', 'trim|required');
            #END Set rules
            #BEGIN: Set message
            $this->form_validation->set_message('required', $this->lang->line('required_message'));
            $this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');
            #END Set message
            if ($this->form_validation->run() != FALSE) {
                #BEGIN: CHECK PERMISSION
                if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'contact_add')) {
                    show_error($this->lang->line('unallowed_use_permission'));
                    die();
                }
                #END CHECK PERMISSION
                $txtContent = $contact->con_detail . '[fieldset][legend][i]' . $this->lang->line('name_reply_view') . '[/i][/legend]' . $this->input->post('txtContent') . '[/fieldset]';
                $dataReply = array(
                    'con_detail' => trim($this->filter->injection_html($txtContent)),
                    'con_date_reply' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                    'con_reply' => 1,
                    'con_status' => 1
                );
                if ($this->contact_model->update($dataReply, "con_id = " . (int) $id)) {
                    $this->session->set_flashdata('sessionSuccessReply', 1);
                }
                redirect(base_url() . 'administ/contact/view/' . $id, 'location');
            } else {
                if ($this->input->post('isSubmit') && $this->input->post('isSubmit') == 'true') {
                    $data['errorReply'] = true;
                } else {
                    $data['errorReply'] = false;
                }
                $data['txtContent'] = $this->input->post('txtContent');
            }
        }
        #Load view
        $this->load->view('admin/contact/view', $data);
    }
    
    function smtpmailer($to, $from, $from_name, $subject, $body)
        {
            $mail = new PHPMailer();                // tạo một đối tượng mới từ class PHPMailer
            $mail->IsSMTP();
            $mail->CharSet = "utf-8";                    // bật chức năng SMTP
            $mail->SMTPDebug = 0;                    // kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
            $mail->SMTPAuth = true;                // bật chức năng đăng nhập vào SMTP này
            $mail->SMTPSecure = SMTPSERCURITY;                // sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
            $mail->Host = SMTPHOST;        // smtp của gmail
            $mail->Port = SMTPPORT;                        // port của smpt gmail
            $mail->Username = GUSER;
            $mail->Password = GPWD;
            $mail->SetFrom($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->isHTML(true);
            $mail->AddAddress($to);
            if (!$mail->Send()) {
                $message = 'Gởi mail bị lỗi: ' . $mail->ErrorInfo;
                return false;
            } else {
                $message = 'Thư của bạn đã được gởi đi ';
                return true;
            }
        }


}
