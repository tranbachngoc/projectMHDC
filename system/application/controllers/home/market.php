<?php 
class Market extends MY_Controller
{
    private $isMobile = 0;
    private $breadCrumb = [];
    private $_config = [];
    private $has_af_key = false;
    private $af_key = false;
    private $tbtt_query
        = '(SELECT DISTINCT tbtt_product.pro_id, pro_type, pro_user, tbtt_product.pro_category, pro_name, created_date, pro_descr, pro_cost, pro_currency, pro_image, pro_dir, pro_saleoff, pro_saleoff_value, pro_type_saleoff, begin_date_sale, end_date_sale, pro_minsale, pro_view, pro_quality,
                is_product_affiliate, af_amt, af_rate, af_dc_amt, af_dc_rate,
                IF(id > 0, MAX(dp_cost), MAX(pro_cost)) AS price_max,
                IF(id > 0, MIN(dp_cost), MIN(pro_cost)) AS pirce_min,
                COUNT(id) AS have_num_tqc, apply
            FROM tbtt_product
            LEFT JOIN tbtt_detail_product ON tbtt_detail_product.dp_pro_id = tbtt_product.pro_id
            WHERE pro_status = 1 AND pro_instock > 0
            GROUP BY pro_id) as tbtt_query';

    public function __construct()
    {
        parent::__construct();

        // create view
        // if ($this->db->table_exists('tbtt_view_market_product')) {
        //     $this->createViewProduct();
        // }
        // $this->createViewProduct();

        $this->load->model('category_model');
        $this->load->model('showcart_model');
        $this->load->model('user_model');
        $this->load->model('like_product_model');
        // $this->load->model('product_affiliate_user_model');

        //check has af_key
        if ($_REQUEST['af_id'] != '') {
            $af_key = $_REQUEST['af_id'];
            $check = $this->user_model->get("af_key", "af_key = '$af_key'")->af_key;
            $check != '' ? $this->has_af_key = true : $this->has_af_key = false;
        };
        $data['has_af_key'] = $this->has_af_key;

        //load user shop login
        $sessionUser = $this->session->userdata('sessionUser');
        if ($sessionUser) {
            $currentuser = $this->user_model->get("use_id,use_username,avatar,af_key,use_invite", "use_id = " . $sessionUser);
            $arr_pro_af = $this->db->query("SELECT pro_id FROM tbtt_product_affiliate_user WHERE use_id = $sessionUser")->result();
            $arr_pro_like = $this->like_product_model->fetch_join("pro_id", "user_id = $sessionUser");

            foreach ($arr_pro_af as $key => $value) {
                $arr_pro_af[$key] = $value->pro_id;
            }
            foreach ($arr_pro_like as $key => $value) {
                $arr_pro_like[$key] = $value->pro_id;
            }
            $currentuser->arr_pro_af = $arr_pro_af;
            $currentuser->arr_pro_like = $arr_pro_like;

            if (in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true))) {
                $myshop = $this->shop_model->get("sho_link, domain", "sho_user = " . $sessionUser);
                //Get AF Login
                $data['af_id'] = $this->af_key = $currentuser->af_key;
            } elseif ($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15) {
                $parentUser = $this->user_model->get("parent_id", "use_id = " . $sessionUser);
                $myshop = $this->shop_model->get("sho_link, domain", "sho_user = " . $parentUser->parent_id);
            }

            if (!empty($myshop->domain)) {
                $myshop->myshop_url = 'http://' . $myshop->domain;
            } else if (!empty($myshop->sho_link)) {
                $myshop->myshop_url = $protocol . $myshop->sho_link . '.' . domain_site;
            }

            if ($currentuser->avatar) {
                $currentuser->avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
            } else {
                $currentuser->avatar = site_url('templates/home/styles/images/product/avata/default-avatar.png');
            }

            $data['myshop'] = $myshop;
            $data['currentuser'] = $currentuser;
        }

        //check loading on mobile ???
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();
        $data['isMobile'] = $this->isMobile = 0;
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $data['isMobile'] = $this->isMobile = 1;
        }
        //end
        $config = [
            'full_tag_open' => '<nav class="nav-pagination pagination-style"><ul class="pagination">',
            'full_tag_close' => '</ul></nav>',

            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'next_link' => '<i class="fa fa-chevron-right"></i>',

            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'prev_link' => '<i class="fa fa-chevron-left"></i>',

            'cur_tag_open' => '<li class="page-item active"><a class="page-link">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="page-item">',
            'num_tag_clos' => '</li>',

            'anchor_class' => 'class="page-link" ',

            'first_link' => false,
            'last_link' => false,
        ];

        $this->_config = $config;

        // dd($data);
        // die;
        $this->load->vars($data);
    }

    /* $cateType: 0-product || 2-coupon
     ** $parent: 0-Root
     ** $level: 0-level root
     */
    public function loadCategoryRoot($parent, $level, $cateType)
    {
        $select = "*";
        $whereTmp = "cat_status = 1 AND parent_id = $parent AND cate_type = $cateType";
        $categoryRoot = $this->category_model->fetch($select, $whereTmp, "cat_order", "ASC");
        return $categoryRoot;
    }

    public function loadCategoryWithID($cateID)
    {
        $select = "*";
        $where = "cat_status = 1 AND cat_id = $cateID";
        $categoryRoot = $this->category_model->get($select, $where);

        $whereSub = "cat_status = 1 AND parent_id = $categoryRoot->cat_id";
        $cateorySub = $this->category_model->fetch($select, $whereSub, "cat_order", "ASC");

        $categoryBcrum[] = ['cat_id' => $categoryRoot->cat_id, 'cat_name' => $categoryRoot->cat_name, 'parent_id' => $categoryRoot->parent_id];
        $categoryBcrum = $this->getBreadcrumb($categoryRoot, $categoryBcrum);

        $list_CateId = [];
        $list_CateId = $this->getAllChildrenCateId([$categoryRoot->cat_id], $list_CateId);

        return [
            'categoryRoot' => $categoryRoot,
            'categorySub' => $cateorySub,
            'categoryBcrum' => array_reverse($categoryBcrum, true),
            'categoryQuery' => $list_CateId
        ];
    }

    function getBreadcrumb($object, $data_return)
    {
        if ($object->parent_id > 0) {
            $cateTemp = $this->category_model->get('*', "cat_id = $object->parent_id");
        }
        array_push($data_return, ['cat_id' => $cateTemp->cat_id, 'cat_name' => $cateTemp->cat_name, 'parent_id' => $cateTemp->parent_id]);
        if ($cateTemp->parent_id > 0) {
            return $this->getBreadcrumb($cateTemp, $data_return);
        }
        return $data_return;
    }

    function getAllChildrenCateId($arr_cat_id, $list_CateId)
    {
        $arr_temp = implode(',', $arr_cat_id);
        // lấy ds cat_id của sub category
        $cateTemp = $this->category_model->fetch('*', "parent_id in ($arr_temp)");
        // kiểm tra có có sub category hay ko
        if (!empty($cateTemp)) {
            $arr_temp = [];
            foreach ($cateTemp as $cate_key => $cate_item) {
                //kiểm tra có phải cate này có submenu hay ko
                $check = $this->category_model->get('count(*) as total', "parent_id = $cate_item->cat_id")->total;
                if ($check > 0) {
                    // đẩy data vào để truy vấn tiếp
                    array_push($arr_temp, $cate_item->cat_id);
                } else {
                    // lưu cate cấp cuối vào data return
                    array_push($list_CateId, $cate_item->cat_id);
                }
            }
            if (!empty($arr_temp)) {
                return $this->getAllChildrenCateId($arr_temp, $list_CateId);
            } else {
                return implode(',', $list_CateId);
            }
        } else {
            foreach ($arr_cat_id as $key => $value) {
                array_push($list_CateId, $value);
            }
            return implode(',', $list_CateId);
        }
    }

    public function ecommerce($detected = "products")
    {
        if ($detected == "products") {
            $this->__process_ecommerce(0);
        }

        if ($detected == "coupons") {
            $this->__process_ecommerce(2);
        }

        $this->load->view('e-azibai/home/main-home');
    }

    public function __process_ecommerce($typeProcess)
    {
        $af_key = '';
        $currentuser = $this->user_model->get("af_key", "use_id = '" . $this->session->userdata('sessionUser') . "'");
        if(count($currentuser) > 0 && $currentuser->af_key != ''){
            $af_key = '?af_id='.$currentuser->af_key;
        }else{
            if(isset($_REQUEST['af_id']) && $_REQUEST['af_id'] != ''){
                $af_key = '?af_id='.$_REQUEST['af_id'];
            }
        }
        $data['ogurl']              = azibai_url().'/shop/products'.$af_key;
        $data['ogtype']             = 'website';
        $data['ogtitle'] = settingTitle;
        
        $page = 1;

        $data['category'] = $this->loadCategoryRoot(0, 0, $typeProcess);

        $select = '*';
        $from = $this->tbtt_query;
        $where = "pro_type = $typeProcess";
        $order = "created_date";
        $by = "DESC";

        if ($this->input->post('page') > 1) {
            $page = (int)$this->input->post('page');
        }
        $limit = 20;
        $start = ($page - 1) * $limit;
        // sp mới
        $data['items_new'] = $this->db->query("SELECT $select FROM $from WHERE $where ORDER BY $order $by LIMIT $limit OFFSET $start")->result();

        // load more ở trang chủ
        if ($this->input->is_ajax_request()) {
            $html = '';
            foreach ($data['items_new'] as $key => $item) {
                // $dataHH = $this->dataGetHH($item);
                // $item->hoahong = $this->checkHH($dataHH);
                // $item->Shopname = $this->get_InfoShop($item->pro_user, 'sho_name')->sho_name;
                $html .= $this->load->view('e-azibai/common/common-html-item', ['item' => $item, 'has_af_key' => $this->has_af_key], true);
            }
            echo $html;
            die;
        }

        // foreach($data['items_new'] as $k => $item)
        // {
        //     $dataHH = $this->dataGetHH($item);
        //     $item->hoahong = $this->checkHH($dataHH);
        //     $item->Shopname = $this->get_InfoShop($item->pro_user, 'sho_name')->sho_name;
        // }


        // sp sale
        $where_items_fsale = "$where AND pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)";
        $data['items_sale'] = $this->db->query("SELECT $select FROM $from WHERE $where_items_fsale ORDER BY $order $by LIMIT $limit OFFSET $start")->result();

        // foreach($data['items_sale'] as $k => $item)
        // {
        //     $dataHH = $this->dataGetHH($item);
        //     $item->hoahong = $this->checkHH($dataHH);
        //     $item->Shopname = $this->get_InfoShop($item->pro_user, 'sho_name')->sho_name;
        // }

        // sp hay mua
        $temp = $this->showcart_model->fetch_join("shc_product, count(shc_product) as total", "INNER", "tbtt_product", "tbtt_product.pro_id = shc_product", "", "", "", "tbtt_product.pro_instock > 0", "total", "DESC", 0, 20, "", "shc_product");
        $list_proid_best_sale = [];
        foreach ($temp as $key => $value) {
            array_push($list_proid_best_sale, $value->shc_product);
        }
        $list_proid_best_sale = implode(',', $list_proid_best_sale);
        $where_items_order = "$where AND pro_id IN ($list_proid_best_sale)";
        $data['items_order'] = $this->db->query("SELECT $select FROM $from WHERE $where_items_order ORDER BY $order $by LIMIT $limit OFFSET $start")->result();

        // foreach($data['items_order'] as $k => $item)
        // {
        //     $dataHH = $this->dataGetHH($item);
        //     $item->hoahong = $this->checkHH($dataHH);
        //     $item->Shopname = $this->get_InfoShop($item->pro_user, 'sho_name')->sho_name;
        // }

        $selected_sale_arr = '';
        if ($this->session->userdata('sessionUser')) {
            $this->load->model('product_affiliate_user_model');
            foreach ($data['items_sale'] as $key => $value) {
                if($value->pro_user != $this->session->userdata('sessionUser')){
                    $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $value->pro_id));
                    if (!empty($selected_sale)) {
                        $selected_sale_arr[$value->pro_id] = $value->pro_id;
                    }
                }
            }

            foreach ($data['items_order'] as $key => $value) {
                if($value->pro_user != $this->session->userdata('sessionUser')){
                    $selected_sale = $this->product_affiliate_user_model->check(array('use_id' => (int)$this->session->userdata('sessionUser'), 'pro_id' => $value->pro_id));
                    if (!empty($selected_sale)) {
                        $selected_sale_arr[$value->pro_id] = $value->pro_id;
                    }
                }
            }
        }
        $data['selected_sale'] = $selected_sale_arr;
        $this->load->vars($data);
    }

    public function search_product()
    {
        $url_search_product = "http://search.azibai.com:9000/search-product";

        $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
            if ($page < 1) {
                $page = 1;
            }
        $limit = 10;

        $params = [
            'keyword' => $_REQUEST['keyword'],
            'page' => $page
        ];
        $make_call = $this->callAPI("GET", $url_search_product, $params);
        $make_call = json_decode($make_call, true);

        $data['items'] = $make_call['data'];

        //pagination
        $url_full = get_current_full_url();
        $process_url = parse_url($url_full);
        parse_str($process_url['query'], $params);
        if(isset($params['page'])) {
            unset($params['page']);
        }
        $page_url = $process_url['scheme']."://".$process_url['host'].$process_url['path'].'?' . http_build_query($params);

        $config = $this->_config;
        $config['total_rows'] = $make_call['total'];
        $config['base_url'] = $page_url;
        $config['per_page'] = $limit;
        $config['num_links'] = 3;

        $config['uri_segment'] = 2;

        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';

        // To initialize "$config" array and set to pagination library.
        $this->load->library('pagination', $config);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['total'] = $make_call['total'];
        // dd($data);die;

        $this->load->view('e-azibai/search-product/main-find', $data);
    }

    public function product_category($category_id = 1, $category_name = '', $page = 1)
    {
        // die('this feature will be come soon!!!');
        // dd($page);die;
        $this->load->library('uri');

        $data['category'] = $this->loadCategoryWithID($category_id);
        $list_id = $data['category']['categoryQuery'];
        // dd($list_id);die;

        $select = '*';
        $from = $this->tbtt_query;
        $where = "pro_category IN ($list_id)";
        $order = "created_date";
        $by = "DESC";
        $limit = 20;
        $start = ($page - 1) * $limit;

        //fillter option
        $arr_keys = ['sort', 'quality', 'percentage', 'price_f', 'price_t'];
        $getVars = array_keys($_REQUEST);
        $matchs = array_intersect($getVars, $arr_keys);
        $suffix_str = '?';
        if($this->af_key != '') {
            $suffix_str = '?af_id='.$this->af_key.'&';
        }
        $data['filter'] = [];
        if (!empty($matchs)) {
            foreach ($matchs as $key => $value) {
                switch ($value) {
                    case 'sort':
                        if ($_REQUEST[$value] == 'date-new') {
                            $order = "created_date";
                            $by = "DESC";
                        }
                        if ($_REQUEST[$value] == 'date-old') {
                            $order = "created_date";
                            $by = "ASC";
                        }
                        if ($_REQUEST[$value] == 'price-asc') {
                            $order = "pro_cost";
                            $by = "ASC";
                        }
                        if ($_REQUEST[$value] == 'price-desc') {
                            $order = "pro_cost";
                            $by = "DESC";
                        }
                        if ($_REQUEST[$value] == 'name-az') {
                            $order = "pro_name";
                            $by = "ASC";
                        }
                        if ($_REQUEST[$value] == 'name-za') {
                            $order = "pro_name";
                            $by = "DESC";
                        }
                        $suffix_str .= 'sort=' . $_REQUEST[$value] . '&';
                        $data['filter']['sort'] = $_REQUEST[$value];
                        break;
                    case 'quality':
                        if ($_REQUEST[$value] == 1 || $_REQUEST[$value] == 0) {
                            $where .= ' AND pro_quality = ' . $_REQUEST[$value];
                            $suffix_str .= 'quality=' . $_REQUEST[$value] . '&';
                        } else {
                            $where .= ' AND pro_quality = 0';
                            $suffix_str .= 'quality=0&';
                        }
                        $data['filter']['quality'] = $_REQUEST[$value] > 0 ? $_REQUEST[$value] : 0;
                        break;
                    case 'percentage':
                        if ($_REQUEST[$value] > 0) {
                            $where .= ' AND pro_saleoff = 1 AND (UNIX_TIMESTAMP() BETWEEN begin_date_sale AND end_date_sale)';
                            $suffix_str .= 'percentage=' . $_REQUEST[$value] . '&';
                        } else {
                            $suffix_str .= 'percentage=0&';
                        }
                        $data['filter']['percentage'] = $_REQUEST[$value] > 0 ? $_REQUEST[$value] : 0;
                        break;
                }
            }
            if (in_array('price_f', $matchs) && in_array('price_t', $matchs)) {
                if ($_REQUEST['price_f'] > 0 && $_REQUEST['price_t'] > 0) {
                    $where .= ' AND pro_cost BETWEEN ' . $_REQUEST['price_f'] . ' AND ' . $_REQUEST['price_t'];
                    $suffix_str .= 'price_f=' . $_REQUEST['price_f'] . '&price_t=' . $_REQUEST['price_t'];
                } else {
                    $suffix_str .= 'price_f=' . $_REQUEST['price_f'] . '&price_t=' . $_REQUEST['price_t'];
                }
                $data['filter']['price_f'] = $_REQUEST['price_f'] > 0 ? $_REQUEST['price_f'] : 0;
                $data['filter']['price_t'] = $_REQUEST['price_t'] > 0 ? $_REQUEST['price_t'] : 0;
            }
        } else {
            $where .= ' AND pro_quality = 0';
            $order = "created_date";
            $by = "DESC";
            $data['filter'] = [
                'sort' => 'date-new',
                'quality' => 0,
                'percentage' => 0,
                'price_f' => 0,
                'price_t' => 0
            ];
            $suffix_str .= 'quality=0&percentage=0&sort=date-new&price_f=0&price_t=0';
        }
        //config pagination
        $data['total'] = count($this->db->query("SELECT $select FROM $from WHERE $where ORDER BY $order $by")->result());
        $config = $this->_config;
        // Set base_url for every links
        $config["base_url"] = azibai_url() . "/$category_id/$category_name";
        $config["total_rows"] = $data['total'];
        $config["per_page"] = $limit;
        $config['use_page_numbers'] = true;
        $config['num_links'] = 3;

        $config['uri_segment'] = 3;
        if ($this->uri->segment(3) != 1 && $this->uri->segment(3) != 0 && $this->uri->segment(3) != false) {
            $config['first_url'] = 1 . rtrim($suffix_str, '&');
        }
        $config['suffix'] = rtrim($suffix_str, '&');


        // To initialize "$config" array and set to pagination library.
        $this->load->library('pagination', $config);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['items'] = $this->db->query("SELECT $select FROM $from WHERE $where ORDER BY $order $by LIMIT $limit OFFSET $start")->result();

        // foreach($data['items'] as $k => $item)
        // {
        //     $dataHH = $this->dataGetHH($item);
        //     $item->hoahong = $this->checkHH($dataHH);
        //     $item->Shopname = $this->get_InfoShop($item->pro_user, 'sho_name')->sho_name;
        // }

        // dd($data['filter']);die;
        $this->load->view('e-azibai/category/main-category', $data);
    }

    public function voucher_detail($shop_user_id, $voucher_id)
    {
        $temp_user_id = $shop_user_id;
        if(@$_REQUEST["af_id"] != "") {
            $af_key = $_REQUEST['af_id'];
            $use_id = $this->user_model->get("use_id", "af_key = '$af_key'")->use_id;
            $temp_user_id = $use_id;
        } else if ($this->session->userdata('sessionUser') > 0) {
            $temp_user_id = $this->session->userdata('sessionUser');
        }
        // include api
        $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
        $data = Api_affiliate::get_voucher_detail_on_azibai($temp_user_id, $voucher_id);
        $this->load->view('home/product/detail_voucher', $data, FALSE);
    }

    public function voucher_detail_show_product($shop_user_id, $voucher_id)
    {
        $page = 1;
        $limit = 20;
        $search = '';
        if($this->input->is_ajax_request()) {
            $page = $_POST['page'];
            $search = $_POST['search'];
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $shop_user_id, $page, $limit, $search);
            $html = '';
            foreach ($data['list_product']['data'] as $key => $item) {
                $html .= $this->load->view('home/page_business/backend-doanhnghiep/html/item-create-step-review-listitem', ['item'=>$item], TRUE);
            }
            echo $html;die;
        } else {
            $this->load->file(APPPATH.'controllers/home/api_affiliate.php', false);
            $data['list_product'] = Api_affiliate::list_product_use_voucher($voucher_id, $shop_user_id, $page, $limit, $search);
            // $this->set_layout('home/page_business/backend-doanhnghiep/backend-layout');
            $this->load->view('home/product/detail_voucher_show_pro', $data);
        }
    }

}
?>