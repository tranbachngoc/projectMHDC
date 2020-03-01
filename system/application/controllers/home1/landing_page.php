<?php

class Landing_page extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        $this->load->model('landing_page_model');
        #END CHECK SETTING
        #Load language
        $this->lang->load('home/common');
        $this->load->model('user_model');
        $this->load->model('shop_model');
        $this->load->model('package_user_model');
        $this->load->model('common_model');
        $data = $this->common_model->getPackageAccount();

        $ssuser = (int)$this->session->userdata('sessionUser');

        $shop = $this->shop_model->get("sho_link, sho_package", "sho_user = " . $ssuser);

        $data['shoplink'] = $shop->sho_link;

        //$data['sho_package'] = $this->getConditionsShareNews($this->session->userdata('sessionGroup'),$this->session->userdata('sessionUser'));
        $data['mainURL'] = $this->getMainDomain();
        if ($this->session->userdata('sessionGroup') == BranchUser) {
            $UserID = (int)$this->session->userdata('sessionUser');
            $u_pa = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $UserID . " AND use_status = 1 AND use_group = " . BranchUser);
            $u_pa1 = $this->user_model->get("use_id, use_group, parent_id", "use_id = " . $u_pa->parent_id . " AND use_status = 1");
            if ($u_pa) {
                $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa->parent_id);
                if ($u_pa1->use_group == StaffStoreUser) {
                    $data['sho_pack_bran'] = $this->package_user_model->getCurrentPackage($u_pa1->parent_id);
                }
            }
        }
              
        
        if ($this->session->userdata('sessionUser') > 0) {
            # Check user actived
            $cur_user =  $this->user_model->get('use_id,use_username,avatar,af_key', 'use_id = '. (int)$this->session->userdata('sessionUser') . ' AND use_status = 1');
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));
		$data['af_id'] = $cur_user->af_key;
	    } else {
		$parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
	    }
	    $data['myshop'] = $myshop;
	    $data['currentuser'] = $cur_user;
            $data['menuType'] = 'account';	    
	    
            if($cur_user && count($cur_user) === 1 && (int)$cur_user->use_id > 0){
		/**/		
            } else {
                redirect(base_url() . 'logout', 'location'); die;
            }
        }
            
        $this->load->vars($data);

    }

    function index()
    {

    }

    function loadJson($id)
    {
        $this->load->model('landing_page_model');
        $json = $this->landing_page_model->getLandingByID($id);
        $result = $json->result();
        // $result['content'];
        $data = array();
        $data["isOk"] = 0;
        $result = array_filter($result);
        if (!empty($result)) {
            $data["content"] = $result[0]->content;
            $data["isOk"] = 1;
        }
        echo json_encode($data);
    }

    function saveJson()
    {
        //$id = $_POST['id'];
        $content = $_POST['content'];
        $content = base64_decode($content);
        $templateId = $_POST['templateId'];
        $this->load->model('landing_page_model');
        $id = $_POST['landing_id'];
        $isAuthor = $this->landing_page_model->isAuthor((int)$this->session->userdata('sessionUser'), $id);
        $data["isOk"] = 0;
        if ($isAuthor) {
            //        $file = 'templates/landing_page/user/'.$id.'.json';
            // The new person to add to the file
            // Write the contents to the file,
            // using the FILE_APPEND flag to append the content to the end of the file
            // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
            //        if (file_exists($file)) {
            //            unlink($file);
            //        }
            //file_put_contents($file, $content);
            $this->landing_page_model->updateLandingPage($id, $templateId, $content, "", "");

            $data["isOk"] = 1;
        }
        echo json_encode($data);
    }

    function saveLandingPage()
    {
        $this->load->model('landing_page_model');
        $id = $_POST['landing_id'];
        $templateId = $_POST['templateId'];
        $content = $_POST['content'];
        $content = base64_decode($content);
        $name = $_POST['name'];
        $data["isOk"] = 0;

        if ($id) {
            $pages = $_POST['pages'];
            reset($pages);
            $page = key($pages);
            $t_seo = json_decode($_POST['seo'][$page]);
            $t_css = json_decode($_POST['css'][$page]);
            $skeleton1 = file_get_contents('templates/landing_page/elements/sk1a.html');
            $skeleton2 = file_get_contents('templates/landing_page/elements/sk2a.html');
            $skeleton3 = file_get_contents('templates/landing_page/elements/sk3a.html');
            $seo_tags = '<title>' . $name . '</title>' . "\n" . '<meta name="description" content="' . $t_seo[1] . '">' . "\n" . '<meta name="keywords" content="' . $t_seo[2] . '">' . "\n" . $t_seo[3];
            if (!empty($t_css)) {
                $customStyle = "<style type=\"text/css\" id=\"pix_style\">\n" . stripslashes($t_css) . "\n</style>\n</head>\n<body>";
            } else {
                $customStyle = "\n</head>\n<body>";
            }
            $html = stripslashes(array_shift(array_values($_POST['pages'])));
            $html = html_entity_decode($html);
            $html = str_replace('<img src="images/', '<img src="/templates/landing_page/elements/images/', $html);
            $html = str_replace('[removed]', '', $html);
            $new_content = $skeleton1 . $seo_tags . $skeleton2 . $customStyle . stripslashes($html) . $skeleton3;
            $new_content = mb_convert_encoding($new_content, "UTF-8", "auto");
            $isAuthor = $this->landing_page_model->isAuthor((int)$this->session->userdata('sessionUser'), $id);
            if ($isAuthor) {

                $this->landing_page_model->updateLandingPage($id, $templateId, $content, $new_content, "");
                $data["isOk"] = 1;
            }
            $landing = new stdClass();
            $landing->id = $id;
            $landing->name = $name;
            $landing->template_id = $templateId;
            $landing->content = '';
            $landing->html = $new_content;
            $data['landing'] = $landing;
            redirect(base_url() . "landing_page/id/" . $id . "/" . RemoveSign($name));
        }
    }

    public function checkLandPermissions()
    {
        #BEGIN: Load model
        $this->load->model('package_user_model');
        $this->load->model('landing_page_model');
        $this->load->model('service_model');
        $this->load->model('user_model');
        $this->load->model('branch_model');
        #END: Load model        
        $userId = (int)$this->session->userdata('sessionUser');
        //Neu la Chi Nhanh thi gan lai userId
        if ((int)$this->session->userdata('sessionGroup') == BranchUser) {
            $user_pa = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $userId . ' AND use_status = 1');
            $userId = $user_pa->parent_id;
            $pa_group = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $userId . ' AND use_status = 1');
            if ($pa_group->use_group == StaffStoreUser) {
                $user_pa = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $pa_group->parent_id . ' AND use_status = 1');
                $userId = $user_pa->use_id;
            }
        }

        //Get shop package
        $sho_package = $this->package_user_model->getCurrentPackage($userId);

        //--- Cho Aff duoc su dung cong cu landing page ---//
        if ((int)$this->session->userdata('sessionGroup') == 2) {
            $sho_package['id'] = 2;
        }

        if (empty($sho_package) || $sho_package['id'] == 1) {
            $this->session->set_flashdata('flash_message_error', 'Gói miễn phí không thể tạo Landing page.');
            die('0');
        } else {
            //Kiem tra cau hinh Gian Hàng, Chi nhánh có được phép tạo Landing?
            if ((int)$this->session->userdata('sessionGroup') == BranchUser) {
                $bran_rule = $this->branch_model->getConfig('*', 'bran_id = ' . (int)$this->session->userdata('sessionUser'));
                if ($bran_rule) {
                    $list_br = explode(",", $bran_rule->config_rule);
                    if (isset($list_br) && in_array('48', $list_br)) {
                    } else {
                        $this->session->set_flashdata('flash_message_error', 'Chi nhánh của Gian hàng này hiện không tạo được Landing page.');
                        die("8");
                    }
                } else {
                    $this->session->set_flashdata('flash_message_error', 'Chi nhánh của Gian hàng này hiện không tạo được Landing page.');
                    die("8");
                }
            }

            //By Bao Tran, get limit for services
            $ser_by_packId = $this->service_model->getPackageServiceByInfoID($userId, $sho_package['ID']);
            $limit_pack = $ser_by_packId->limit;
            //Get list landing page of Gian hang
            $list_land = $this->landing_page_model->getLandingByUserId($userId);


            //Get list landing page of chi nhanh duoi GH
            $tree = array();
            $sub_user = $this->user_model->fetch('use_id, use_username, use_group', 'parent_id = ' . $userId . ' AND use_status = 1 AND use_group IN(' . BranchUser . ',' . StaffStoreUser . ')');
            foreach ($sub_user as $key) {
                $tree[] = $key->use_id;
                if ($key->use_group == StaffStoreUser) {
                    $sub_cnnvgh = $this->user_model->fetch('use_id, use_username, use_group', 'parent_id ="' . $key->use_id . '" AND use_status = 1 AND use_group="' . BranchUser . '"');
                    if (!empty($sub_cnnvgh)) {
                        foreach ($sub_cnnvgh as $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
            }
            $tree = implode(',', $tree);
            $list_land_of_sub = 0;
            if ($tree != '') {
                $land_of_sub = $this->landing_page_model->getLangOfSub($tree);
                $list_land_of_sub = count($land_of_sub);
            }

            //Tinh tong so Landing page cua Gian Hang va Chi nhanh con
            // $list_landing = count($list_land) +  $list_land_of_sub ? count($list_land) +  $list_land_of_sub : 0;
            $list_landing = 0;
            $list_landing = count($list_land) + $list_land_of_sub;

            if ($list_landing == 0) {
                die("-1");
            }
            switch ($sho_package['id']) {
                case '2':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('1');
                    } else {
                        die('-1');
                    }
                    break;
                case '3':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('2');
                    } else {
                        die('-1');
                    }
                    break;
                case '4':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('4');
                    } else {
                        die('-1');
                    }
                    break;
                case '5':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('4');
                    } else {
                        die('-1');
                    }
                    break;
                case '6':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('5');
                    } else {
                        die('-1');
                    }
                    break;
                case '7':
                    if ($list_landing >= $limit_pack) {
                        $this->session->set_flashdata('flash_message_error', 'Gói dịch vụ của bạn chỉ được tạo ' . $limit_pack . ' Landing page.');
                        die('6');
                    } else {
                        die('-1');
                    }
                    break;
            }
        }
    }

    function builder()
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        $data = array();
        $data['userId'] = (int)$this->session->userdata('sessionUser');
        $data['templateId'] = $_POST['template_id'];
        if (trim($data['templateId']) == "") {
            redirect(base_url() . 'account/');
        }
        $content = $this->landing_page_model->getHTMLTemplateByID($data['templateId']);
        $data['content'] = "";
        if ($content->num_rows) {
            $content = $content->result();
            $data['content'] = $content[0]->content;
        }
        $data['list_id'] = $_POST['list_id'];
        $data['list_name'] = $_POST['list_name'];
        $data['name'] = $_POST['name'];
        $data['landingId'] = $this->landing_page_model->createLandingPage($data['name'], $data['templateId'], $data['content'], "", $data['userId'], $data['list_id'], $data['list_name']);
        //        $file = 'templates/landing_page/user/'.$data['landingId'].'.json';
        //
        //        if (file_exists($file)) {
        //            unlink($file);
        //        }
        //        file_put_contents($file, $data['content']);
        if ($data['landingId'] > 0) {
            redirect(base_url() . 'templates/landing_page/' . $data['landingId']);
        }
        //$this->load->view("home/landing_page/builder",$data);
    }

    function edit($id)
    {
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        //		$data['menuSelected'] = 'landingpage';
        //		$data['menuType'] = 'account';
        //$data['templateId'] = $_POST['templateId'];
        $data['userId'] = (int)$this->session->userdata('sessionUser');
        $isAuthor = $this->landing_page_model->isAuthor($data['userId'], $id);
        if ($isAuthor) {
            $content = $this->landing_page_model->getLandingByID($id);
            $content = $content->result();
            $data['name'] = $content[0]->name;
            $data['landingId'] = $id;
            //$data['landingId'] = $this->landing_page_model->createLandingPage("",$data['templateId'],$data['content'],"",$data['userId']);
            $this->load->view('home/landing_page/builder', $data);
        } else {
            redirect(base_url() . 'account/');
        }
    }

    function delete($id)
    {
        $this->load->model("landing_page_model");
        $data['userId'] = (int)$this->session->userdata('sessionUser');
        $isAuthor = $this->landing_page_model->isAuthor($data['userId'], $id);
        if ($isAuthor) {
            $this->landing_page_model->deleteLandingPage($id);
        }
        redirect(base_url() . 'account/landing_page/lists/');
    }

    function landing_list()
    {
        // Tung ADD       
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        
        $shop = $this->shop_model->get("*", "sho_user = " . (int)$this->session->userdata('sessionUser') . ' AND sho_status = 1');
        if (count($shop) > 0 && $shop->sho_name != '' && $shop->sho_address != '' && $shop->sho_kho_address != '' && $shop->sho_kho_district != '' && $shop->sho_kho_province != '') {
        } else {
            $this->session->set_flashdata('flash_message', 'Bạn phải cập nhật đầy đủ thông tin cần thiết của gian hàng ( được đánh dấu * ) để thực hiện những chức năng khác');
            redirect(base_url() . "account/shop", 'location');
            die();
        }
        
        $this->load->model('package_user_model');
        $this->load->model('landing_page_model');
        $this->load->model('service_model');
        $this->load->model('user_model');
        $this->load->model('branch_model');
        $ser_by_packId = $this->service_model->getPackageServiceByInfoID($this->session->userdata('sessionUser'), 'fd');
        $lList = array();
        $lListName = array();
        $userId = (int)$this->session->userdata('sessionUser');
        $email = $this->user_model->get("use_id, use_email", "use_id = {$userId}");
        $emailShop = $email->use_email;
        $sublists = $this->getSubList($emailShop);

        if (!empty($sublists)) {
            foreach ($sublists as $item) {
                $lList[] = $item['id'];
                $lListName[] = $item['name'];
            }
        }
        //END get to roi cua GH
        $status = '';
        // if ($this->session->userdata('sessionGroup') != AffiliateStoreUser) {
        //     $status = ' and status = 1';
        // }
        //END lay landing page cho tc tai khoan
        $data["lListName"] = $lListName;
        $data["lList"] = $lList;
        $data["list"] = $this->landing_page_model->getLandingByUserId($userId, $status);
        $status = $_REQUEST['active'] ? $_REQUEST['active'] : 0;
        $id_lan = $_REQUEST['id'] ? $_REQUEST['id'] : 0;
        if ($id_lan > 0) {
            if ((int)$this->session->userdata('sessionGroup') == BranchUser) {
            } else {
                $this->landing_page_model->update(array('status' => $status), 'id = ' . $id_lan);
            }
            redirect(base_url() . 'account/landing_page/lists/', 'location');
        }
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'landingpage';
        $this->load->model('package_user_model');
        $this->load->model('wallet_model');
        $data['sho_package'] = $this->package_user_model->getCurrentPackage((int)$this->session->userdata('sessionUser'));

        $data['wallet_info'] = $this->wallet_model->getSumWallet(array('user_id' => (int)$this->session->userdata('sessionUser')), 1);
        $this->load->view('home/landing_page/listview', $data);
    }

    // share landing page
    function list_share()
    {
        // Tung ADD
        if ($this->session->userdata('sessionUser') <= 0) {
            redirect(base_url() . 'login', 'location');
            die();
        }
        ///

        $get_u = $this->user_model->get('parent_id, use_group', 'use_id = ' . $this->session->userdata('sessionUser'));
        $get_p = $this->user_model->get('use_id, parent_id, use_group', 'use_id = ' . $get_u->parent_id);
        if ($get_p) {
            $get_p1 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $get_p->parent_id . '"');
            $get_p2 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p1->parent_id . '"'); //lay cha thu 2
        }
        $use_landding = $this->session->userdata('sessionUser');
        //get to roi cua GH
        switch ($this->session->userdata('sessionGroup')) {
            case AffiliateStoreUser:
                $use_landding = $this->session->userdata('sessionUser');
                $where = 'user_id =' . $use_landding;
                break;
            case StaffStoreUser:
                $use_landding = $get_u->parent_id;
                $where = 'user_id =' . $use_landding;
                break;
            case BranchUser:
                $use_landding = $get_u->parent_id . ',' . $get_p->parent_id . ',' . $this->session->userdata('sessionUser');
                $where = 'user_id IN(' . $use_landding . ')';
                break;
            case StaffUser:
                $use_landding = $get_u->parent_id . ',' . $get_p->parent_id . ',' . $get_p1->parent_id;
                $where = 'user_id IN(' . $use_landding . ')';
                break;
            case AffiliateUser:
                if ($get_p->parent_id != '') {
                    $use_landding .= $get_p->parent_id . ',';
                }
                if ($get_p1->parent_id != '') {
                    $use_landding .= $get_p1->parent_id . ',';
                }
                if ($get_p2->parent_id != '') {
                    $use_landding .= $get_p2->parent_id . ',';
                }
                $use_landding .= $get_u->parent_id . ',' . $get_p->parent_id;
                $where = 'user_id IN(' . $use_landding . ')';
                break;
        }
        $where .= ' and status = 1';
        ////
        $parent = $this->user_model->get("use_id, parent_id,af_key", "use_id IN( {$use_landding})");
        $data['parent'] = $parent;
        $sort = 'id';
        $by = 'DESC';
        $sortUrl = '';
        $pageSort = '';
        $pageUrl = '';
        $keyword = '';
        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        if ($getVar['search'] != FALSE && trim($getVar['search']) != '' && $getVar['keyword'] != FALSE && trim($getVar['keyword']) != '') {
            switch (strtolower($getVar['search'])) {
                case 'title':
                    $sortUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $pageUrl .= '/search/title/keyword/' . $getVar['keyword'];
                    $where .= " AND name LIKE '%" . $this->filter->injection_html($getVar['keyword']) . "%'";
                    break;
            }
        }

        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & sort
        #Keyword
        $data['keyword'] = $keyword;
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/contact' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        #BEGIN: Pagination
        $this->load->library('pagination');
        $limit = 15;
        #Count total record
        //  $totalRecord = count($this->landing_page_model->fetch("id", 'user_id = '.$parent->parent_id.$where,"","","",""));
        $totalRecord = count($this->landing_page_model->fetch("id", $where, "", "", "", ""));
        $config['base_url'] = base_url() . 'account/share-land' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limit;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();

        // $data["list"] = $this->landing_page_model->fetch("*", 'status = 1 AND user_id IN( '.$use_landding.') '.$where,$sort,$by,$start,$limit);
        $data["list"] = $this->landing_page_model->fetch("*", $where, $sort, $by, $start, $limit);
        $data['menuType'] = 'account';
        $data['menuSelected'] = 'share';
        $this->load->view('home/account/notify/landlink', $data);
    }

    function getSubList($email)
    {
        $conn = new mysqli(email_hostname, email_username, email_password, email_database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query = "SELECT l.list_uid as id, l.name as name FROM `mw_list` as l
                    join mw_customer as c
                    on c.customer_id = l.customer_id
                    where c.email = '" . $email . "'";
        $result = $conn->query($query);
        $value = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $value[] = $row;
            }
        }
        return $value;
    }

    function view($id)
    {
        $this->load->model('landing_page_model');
        $landing_page = $this->landing_page_model->get('*', array('id' => $id));
        // see if the request is made via ajax.
        //$isAjaxRequest = ($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        // and if it is and we have post values, then we can proceed in sending the subscriber.
        if (!empty($_REQUEST)) {
            //$listUid    = 'LIST-UNIQUE-ID';// you'll take this from your customers area, in list overview from the address bar.
            //$listUid = 'qo7813bvkc08e';
            $listUid = $landing_page->list_id;
            if ($listUid != '') {
                require_once(FCPATH . 'api/email/examples/setup.php');
                $endpoint = new MailWizzApi_Endpoint_ListSubscribers();
                $response = $endpoint->create($listUid, array(
                    'EMAIL' => isset($_REQUEST['email']) ? $_REQUEST['email'] : null,
                    'FNAME' => isset($_REQUEST['name']) ? $_REQUEST['name'] : null,
                ));
                $response = $response->body;
                // print_r($response); die();
                // if the returned status is success, we are done.
                if ($response->itemAt('status') == 'success') {
                    $data['success'] = 1;
                    /*exit(MailWizzApi_Json::encode(array(
                        'status'    => 'success',
                        'message'   => 'Thank you for joining our email list. Please confirm your email address now!'
                    )));*/
                } else {
                    $data['success'] = 0;
                }
                // otherwise, the status is error
                MailWizzApi_Json::encode(array(
                    'status' => 'error',
                    'message' => $response->itemAt('error')//error
                ));
                $data['message'] = $response->itemAt('error');
            }
        }

        $data['landing'] = $landing_page;
        $this->load->view('home/landing_page/detail', $data);
    }

    public function getConditionsShareNews($sessionGroup, $sessionUser)
    {
        switch ($sessionGroup) {
            case 3:
                $sho_package = $this->package_user_model->getCurrentPackage($sessionUser);
                break;
            case 14:
                $userCurent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $sessionUser);
                $userParent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userCurent->parent_id);
                if ($userParent->use_group == 3) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);
                } else { //=15
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
                }
                break;
            case 2:
                $userCurent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $sessionUser);
                $userParent = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userCurent->parent_id);
                if ($userParent->use_group == 3) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->use_id);
                }
                if ($userParent->use_group == 15) {
                    $sho_package = $this->package_user_model->getCurrentPackage($userParent->parent_id);
                }
                if ($userParent->use_group == 14) {
                    $userParent2 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent->parent_id);
                    if ($userParent2->use_group == 3) {
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);
                    } else { //=15
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->parent_id);
                    }
                }
                if ($userParent->use_group == 11) {
                    $userParent2 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent->parent_id);
                    if ($userParent2->use_group == 3) {
                        $sho_package = $this->package_user_model->getCurrentPackage($userParent2->use_id);
                    } else { //=14
                        $userParent3 = $this->user_model->get("use_id,use_group,parent_id", "use_id = " . $userParent2->parent_id);
                        if ($userParent3->use_group == 3) {
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent3->use_id);
                        } else {//=15
                            $sho_package = $this->package_user_model->getCurrentPackage($userParent3->parent_id);
                        }
                    }
                }
                break;
        }

        return $sho_package;
    }

    public function getMainDomain()
    {
        $result = base_url();
        $sub = $this->getShopLink();
        if ($sub != '') {
            $result = str_replace('//' . $sub . '.', '//', $result);
        }
        return $result;
    }

    public function getShopLink()
    {
        $result = '';
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[0];
        }
        return $result;
    }

}