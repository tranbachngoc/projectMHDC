<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EntertainmentLink extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->config->load('config_api');
        // Check login
        if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin'))) {
            redirect(base_url().'azi-admin', 'location');
            die();
        }

//
//
//        $this->load->model('user_model');
//        $this->load->library('Mobile_Detect');
//
//        $detect = new Mobile_Detect();
//        $data['isMobile'] = 0;
//        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
//            $data['isMobile'] = 1;
//            if($detect->isiOS()){
//                $data['isIOS'] = 1;
//            }
//        }
//
//        $config = [
//            'full_tag_open' => '<nav aria-label="Page navigation example"><ul class="pagination pagination-center-style justify-content-center">',
//            'full_tag_close' => '</ul></nav>',
//            'next_tag_open' => '<li class="page-item">',
//            'next_tag_close' => '</li>',
//            'next_link' => '<span aria-hidden="true">&gt;</span>',
//            'prev_tag_open' => '<li class="page-item">',
//            'prev_tag_close' => '</li>',
//            'prev_link' => '<span aria-hidden="true">&lt;</span>',
//            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
//            'cur_tag_close' => '</a></li>',
//            'num_tag_open' => '<li class="page-item">',
//            'num_tag_clos' => '</li>',
//            'anchor_class' => 'class="page-link" ',
//            'first_link' => false,
//            'last_link' => false,
//        ];
//
//        $this->_config = $config;
//
//        $this->load->vars($data);


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

    public function getList($page = 1) {
        $list_limit = 10;

        $province = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");

        if (!empty($_REQUEST['list_limit'])) {
            $list_limit = $_REQUEST['list_limit'];
        }

        $requests = [
            'list_limit' => $list_limit,
            'page' => $page,
            'sort' => [
                'type' => 'id',
                'order' => 'desc'
            ]
        ];
        $links = [];
        $category = [];

        try {
            $token = $this->session->userdata('token');

            $res = curl_data(URL_API.'entertainment-link/get-list-detail', $requests,'','','GET', $token);
            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            $resCategory = curl_data(URL_API.'entertainment-link/get-category-by-tree', $requests,'','','GET');
            if (!empty($resCategory)) {
                $dataCategory = json_decode($resCategory);
                if ($dataCategory->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($dataCategory->status == 1) {
                    $category = $dataCategory->data;
                } elseif ($dataCategory->status == 0) {
                    throw new \Exception($dataCategory->message);
                }
            }

            $this->set_layout('azi-admin/layout/default-layout');

            $total = !empty($links->total) ? $links->total : 0;
            $limit = !empty($links->per_page) ? $links->per_page : 20;

            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/entertainment-link';
            $config["total_rows"] = $total;
            $config["per_page"] = $limit;
            $config['use_page_numbers'] = TRUE;
            $config['num_links'] = 3;
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
            $pagination = $this->pagination->create_links();

            $this->load->view('azi-admin/entertainment-link/index', ['response' => $links, 'category' => $category, 'pagination' => $pagination, 'province' =>$province]);
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::getList',
                'message' => $e->getMessage()
            ], true));

            $this->set_layout('azi-admin/layout/default-layout');
            $this->load->view('azi-admin/entertainment-link/index', ['response' => $links, 'category' => $category, 'province' =>$province]);
        }
    }

    public function search($page = 1) {
        $list_limit = 10;

        $province = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
        if (!empty($_REQUEST['list_limit'])) {
            $list_limit = $_REQUEST['list_limit'];
        }

        $links = [];
        $category = [];
        $params = $_REQUEST;

        try {
            $token = $this->session->userdata('token');
            $requests = [
                'list_limit' => $list_limit,
                'page' => $page
            ];
            $url = URL_API.'entertainment-link/get-list-detail';

            if (!empty($_REQUEST['category'])) {
                $url = $url.'/'.$_REQUEST['category'];
            }

            if (!empty($_REQUEST['name'])) {
                $requests['name'] = $_REQUEST['name'];
            }

            if (!empty($_REQUEST['status'])) {
                $requests['status'] = $_REQUEST['status'];
            }

            // 1: Tu thap den cao   2: Tu cao den thap
            if (!empty($_REQUEST['sort_order'])) {
                $requests['sort_order'] = $_REQUEST['sort_order'];
            }

            if (!empty($_REQUEST['created_date'])) {
                $requests['created_date'] = $_REQUEST['created_date'];
            }

            $requests['sort'] = [
                'type' => 'id',
                'order' => 'desc'
            ];

            $res = curl_data($url, $requests,'','','GET', $token);
            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            $resCategory = curl_data(URL_API.'entertainment-link/get-category-by-tree', $requests,'','','GET');
            if (!empty($resCategory)) {
                $dataCategory = json_decode($resCategory);
                if ($dataCategory->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($dataCategory->status == 1) {
                    $category = $dataCategory->data;
                } elseif ($dataCategory->status == 0) {
                    throw new \Exception($dataCategory->message);
                }
            }

            $total = !empty($links->total) ? $links->total : 0;
            $limit = !empty($links->per_page) ? $links->per_page : 20;

            $config = $this->_config;
            // Set base_url for every links
            $config["base_url"] = azibai_url() . '/azi-admin/entertainment-link/search';
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
            $pagination = $this->pagination->create_links();

            $this->set_layout('azi-admin/layout/default-layout');
            $this->load->view('azi-admin/entertainment-link/index', ['response' => $links, 'category' => $category, 'params' => $params, 'pagination' => $pagination, 'province' =>$province]);
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::getList',
                'message' => $e->getMessage()
            ], true));

            $this->set_layout('azi-admin/layout/default-layout');
            $this->load->view('azi-admin/entertainment-link/index', ['response' => $links, 'category' => $category, 'params' => $params, 'province' =>$province]);
        }
    }

    public function getLinkPreview() {
        try {
            $data = [];
            $requests = [];
            $category = [];
            $token = $this->session->userdata('token');
            $link = $this->input->post('link');

            if (!empty($link)) {
                $url = URL_API.'link-preview?link='.$link;

                $res = curl_data($url, $requests,'','','GET', $token);
                if (!empty($res)) {
                    $jsonRes = json_decode($res);
                    if ($jsonRes->status == 2) {
                        $this->session->sess_destroy();
                        redirect(base_url().'azi-admin', 'location');
                    } elseif ($jsonRes->status == 1) {
                        $data = $jsonRes->data;
                    } elseif ($jsonRes->status == 0) {
                        throw new \Exception($jsonRes->message);
                    }
                }
            }

            $resCategory = curl_data(URL_API.'entertainment-link/get-category-by-tree', $requests,'','','GET');
            if (!empty($resCategory)) {
                $dataCategory = json_decode($resCategory);
                if ($dataCategory->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($dataCategory->status == 1) {
                    $category = $dataCategory->data;
                } elseif ($dataCategory->status == 0) {
                    throw new \Exception($dataCategory->message);
                }
            }

            echo json_encode([
                'status' => 1,
                'data' => $data,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::getLinkPreview',
                'message' => $e->getMessage()
            ], true));

            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getById($id) {
        try {
            $token = $this->session->userdata('token');
            $requests = [];
            $category = [];

            if (empty($id)) {
                throw new \Exception('ID không được rỗng');
            }

            $res = curl_data(URL_API.'entertainment-link/get-detail-by-id/'.$id, $requests,'','','GET', $token);

            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $link = $data->data;

                    if (!empty($link->image)) {
                        $link->image = URL_CDN2_CUSTOM_LINK.$link->image;
                    }

                    if (!empty($link->video)) {
                        $link->video = URL_CDN2_CUSTOM_LINK.$link->video;
                    }
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            $resCategory = curl_data(URL_API.'entertainment-link/get-category-by-tree', $requests,'','','GET');
            if (!empty($resCategory)) {
                $dataCategory = json_decode($resCategory);
                if ($dataCategory->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($dataCategory->status == 1) {
                    $category = $dataCategory->data;
                } elseif ($dataCategory->status == 0) {
                    throw new \Exception($dataCategory->message);
                }
            }

            echo json_encode([
                'status' => 1,
                'link' => $link,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::add',
                'message' => $e->getMessage()
            ], true));

            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function upload_file($file) {
        // Lấy thông tin file upload
        $filename = $file['name'];
        $filedata = $file['tmp_name'];
        $filesize = $file['size'];
        $filetype = $file['type'];

        // Nếu file OK
        if ($filedata != '')
        {
            $ch = curl_init();

            if(strstr($filetype, "video/")){
                $url = URL_CDN2_UPLOAD_MEDIA . '?act=upload-video-content';
                $data = array('name' => $filename, 'video' => "@$filedata");
            }else if(strstr($filetype, "image/")){
                $url = URL_CDN2_UPLOAD_MEDIA . '?act=upload-image-content';
                $data = array('name' => $filename, 'image' => "@$filedata");
            }

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            // Nếu không tồn tại lỗi nào trong CURL
            if(!curl_errno($ch)) {
                $info = curl_getinfo($ch);
                if ($info['http_code'] == 200){
                    $response = json_decode($response);
                    return [
                        'status' => $response->status,
                        'data' => $response->data
                    ];
                }
            } else {
                return [
                    'status' => 0,
                    'message' => 'Error'
                ];
            }

            // Đóng CURL
            curl_close($ch);
        }
        else {
            return [
                'status' => 0,
                'message' => 'Please choose file to upload.'
            ];
        }
    }

    public function add() {
        try {
            $token = $this->session->userdata('token');
            if (!empty($this->input->post('category_child'))) {
                $category_id = $this->input->post('category_child');
            } elseif (!empty($this->input->post('category'))) {
                $category_id = $this->input->post('category');
            } else {
                throw new \Exception('Category không được rỗng');
            }

            $requests = [
                'link' => $this->input->post('link'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $category_id,
                'image' => null,
                'orientation' => 0,
                'video' => null,
                'province_id' => $this->input->post('province_id'),
                'district_id' => $this->input->post('district_id'),
                'sort_order' => !empty($this->input->post('sort_order')) ? $this->input->post('sort_order') : 0
            ];

            // Upload file to CDN
            if (!empty($_FILES['link_file']['name'])) {
                $type = $_FILES['link_file']['type'];
                $uploadFile = $this->upload_file($_FILES['link_file']);
                if ($uploadFile['status'] == 1) {
                    if(strstr($type, "video/")){
                        $requests['image'] = $uploadFile['data']->thumbnail;
                        $requests['video'] = $uploadFile['data']->video;
                    }else if(strstr($type, "image/")){
                        $requests['image'] = $uploadFile['data']->original;
                    }else if(strstr($type, "audio/")){
//                        $filetype = "audio";
                    }
                } elseif ($uploadFile['status'] == 0) {
                    throw new \Exception('Can not upload file.');
                }
            }

            $res = curl_data(URL_API.'entertainment-link/add-link', $requests,'','','POST', $token);

            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            redirect($_SERVER['HTTP_REFERER'], 'location');
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::add',
                'message' => $e->getMessage()
            ], true));

            redirect($_SERVER['HTTP_REFERER'], 'location');
        }
    }

    public function edit($id) {
        try {
            $token = $this->session->userdata('token');
            if (!empty($this->input->post('category_child'))) {
                $category_id = $this->input->post('category_child');
            } elseif (!empty($this->input->post('category'))) {
                $category_id = $this->input->post('category');
            } else {
                throw new \Exception('Category không được rỗng');
            }
            $requests = [
                'link' => $this->input->post('link'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $category_id,
                'province_id' => $this->input->post('edit_province_id'),
                'district_id' => $this->input->post('edit_district_id'),
                'image' => null,
                'orientation' => 0,
                'video' => null,
                'sort_order' => !empty($this->input->post('sort_order')) ? $this->input->post('sort_order') : 0
            ];

            if (empty($id)) {
                throw new \Exception('ID không được rỗng');
            }

            // Upload file to CDN
            if (!empty($_FILES['link_file']['name'])) {
                $type = $_FILES['link_file']['type'];
                $uploadFile = $this->upload_file($_FILES['link_file']);
                if ($uploadFile['status'] == 1) {
                    if(strstr($type, "video/")){
                        $requests['image'] = $uploadFile['data']->thumbnail;
                        $requests['video'] = $uploadFile['data']->video;
                    }else if(strstr($type, "image/")){
                        $requests['image'] = $uploadFile['data']->original;
                    }else if(strstr($type, "audio/")){
//                        $filetype = "audio";
                    }
                } elseif ($uploadFile['status'] == 0) {
                    throw new \Exception('Can not upload file.');
                }
            }

            $res = curl_data(URL_API.'entertainment-link/update-user-link/'.$id, $requests,'','','POST', $token);

            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            redirect($_SERVER['HTTP_REFERER'], 'location');
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::add',
                'message' => $e->getMessage()
            ], true));

            redirect($_SERVER['HTTP_REFERER'], 'location');
        }
    }

    public function deleteById($id) {
        try {
            $token = $this->session->userdata('token');
            $requests = [];

            if (empty($id)) {
                throw new \Exception('ID không được rỗng');
            }

            $res = curl_data(URL_API.'entertainment-link/delete-admin-link-by-id/'.$id, $requests,'','','DELETE', $token);
            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            redirect($_SERVER['HTTP_REFERER'], 'location');
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::deleteById',
                'message' => $e->getMessage()
            ], true));

            redirect($_SERVER['HTTP_REFERER'], 'location');
        }
    }

    public function multiDelete() {
        try {
            $token = $this->session->userdata('token');
            $ids = $this->input->post('ids');

            if (empty($ids)) {
                throw new \Exception('List IDs rỗng.');
            }

            $url = URL_API.'entertainment-link/multi-delete-admin-link';
            $fields = array(
                'ids' => $ids
            );

            //url-ify the data for the POST
            $fields_string = http_build_query($fields);

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token
            ));

            //execute post
            $res = curl_exec($ch);
            curl_close($ch);

            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            echo json_encode(['url_back' => $_SERVER['HTTP_REFERER']]);die;
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::multiChangeStatus',
                'message' => $e->getMessage()
            ], true));

            echo json_encode(['url_back' => $_SERVER['HTTP_REFERER']]);die;
        }
    }

    public function changeStatusById($id) {
        try {
            $token = $this->session->userdata('token');
            $requests = [];

            if (empty($id)) {
                throw new \Exception('ID không được rỗng');
            }

            $res = curl_data(URL_API.'entertainment-link/change-status/'.$id, $requests,'','','POST', $token);
            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            redirect($_SERVER['HTTP_REFERER'], 'location');
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::changeStatusById',
                'message' => $e->getMessage()
            ], true));

            redirect($_SERVER['HTTP_REFERER'], 'location');
        }
    }

    public function multiChangeStatus() {
        try {
            $token = $this->session->userdata('token');
            $ids = $this->input->post('ids');

            if (empty($ids)) {
                throw new \Exception('List IDs rỗng.');
            }

            $url = URL_API.'entertainment-link/multi-change-status';
            $fields = array(
                'ids' => $ids
            );

            //url-ify the data for the POST
            $fields_string = http_build_query($fields);

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$token
            ));

            //execute post
            $res = curl_exec($ch);
            curl_close($ch);

            if (!empty($res)) {
                $data = json_decode($res);
                if ($data->status == 2) {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } elseif ($data->status == 1) {
                    $links = $data->data;
                } elseif ($data->status == 0) {
                    throw new \Exception($data->message);
                }
            }

            echo json_encode(['url_back' => $_SERVER['HTTP_REFERER']]);die;
        } catch (\Exception $e) {
            log_message('error', print_r([
                'action' => '\EntertainmentLink::multiChangeStatus',
                'message' => $e->getMessage()
            ], true));

            echo json_encode(['url_back' => $_SERVER['HTTP_REFERER']]);die;
        }
    }

    // new add link
    public function addLink() 
    {
        $data['token'] = $this->session->userdata('token');
        $data['api_common_audio_post'] = $this->config->item('api_common_audio_post');
        $data['api_common_video_post'] = $this->config->item('api_common_video_post');
            

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $_POST['sort_order'] = (int) $_POST['sort_order'];
            $url = URL_API.'entertainment-link/add-link';
            //url-ify the data for the POST
            $fields_string = http_build_query($_POST);

            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$data['token']
            ));

            //execute post
            $res = curl_exec($ch);
            curl_close($ch);
            redirect('azi-admin/entertainment-link', 'location');
        }
        else 
        {  
            $data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
            $resCategory = curl_data(URL_API.'entertainment-link/get-category-by-tree', [],'','','GET', $data['token']);
            $data['category'] = [];
            if (!empty($resCategory)) 
            {
                $dataCategory = json_decode($resCategory);
                if ($dataCategory->status == 2) 
                {
                    $this->session->sess_destroy();
                    redirect(base_url().'azi-admin', 'location');
                } 
                elseif ($dataCategory->status == 1) 
                {
                    $data['category'] = $dataCategory->data;
                }
            }
            $this->set_layout('azi-admin/layout/default-layout');
            $this->load->view('azi-admin/entertainment-link/add', $data);
        }
    }
}

