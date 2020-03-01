<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Search extends MY_Controller
{
	private $urlAPI_auto_all = DOMAIN_SEARCH . "search-all-auto";
	private $urlAPI_all = DOMAIN_SEARCH . "search-all";
	private $urlAPI_article = DOMAIN_SEARCH . "search-article";
	private $urlAPI_personal = DOMAIN_SEARCH . "search-personal";
	private $urlAPI_company = DOMAIN_SEARCH . "search-company";
	private $urlAPI_image = DOMAIN_SEARCH . "search-image";
	 	// search-article?keyword=gi%E1%BB%9Bi%20thi%E1%BB%87u&year=2019&type=1&page=1
		// search-personal?keyword=trung&province=8&district=0203&page=1
		// search-company?keyword=azibai&category=1&province=8&district=0203&page=1&is_type=1&is_follow=1
		// search-image?keyword=azibai&year=2019&is_follow=1&is_friend=1
	function __construct()
	{
		parent::__construct();
		$data['url_tab'] =  [
			'all' => azibai_url('/search') . ($_REQUEST['keyword'] ? '?keyword='.urlencode($_REQUEST['keyword']) : ''),
			'article' => azibai_url('/search-article') . ($_REQUEST['keyword'] ? '?keyword='.urlencode($_REQUEST['keyword']) : ''),
			'personal' => azibai_url('/search-personal') . ($_REQUEST['keyword'] ? '?keyword='.urlencode($_REQUEST['keyword']) : ''),
			'company' => azibai_url('/search-company') . ($_REQUEST['keyword'] ? '?keyword='.urlencode($_REQUEST['keyword']) : ''),
			'image' => azibai_url('/search-image') . ($_REQUEST['keyword'] ? '?keyword='.urlencode($_REQUEST['keyword']) : ''),
		];

		$this->load->model('province_model');
		$this->load->model('category_model');

		$this->load->vars($data);
	}

	public function search_autocomplete()
	{
		$url = $this->urlAPI_auto_all;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
		];
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		$make_call = json_decode($make_call, true);
		foreach ($make_call['data']['dataCompany'] as $key => $company) {
			$shop = [
				'sho_link'  => $company['shop_link'],
				'domain'    => $company['domain'],
			];
			$shop_url = shop_url($shop);
			$make_call['data']['dataCompany'][$key]['shop_url'] = $shop_url;
		}

		echo json_encode($make_call);
		die;
	}


	public function search_all()
    {
		if(!isset($_REQUEST['keyword']) || trim($_REQUEST['keyword']) === '')
			redirect(azibai_url(),'refresh');

		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
			'type' => $_REQUEST['type'],
			'is_follow' => $_REQUEST['is_follow'],
			'year' => $_REQUEST['year'],
			'province' => $_REQUEST['province'],
		];
		$params = array_filter($params);

		$url = $this->urlAPI_all;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		// dd(json_decode($make_call, true));die;

		$data['searchs'] = json_decode($make_call, true);
		$filter['order_by'] = 'pre_name ASC';
		$data['provinces'] = $this->province_model->getProvince($filter);
		// $data['categories'] = $this->category_model->get_category_shop();

		$this->set_layout('search/home/main-layout');
        $this->load->view('search/home/page/page-all', $data);
	}

	public function search_article()
    {
		if(!isset($_REQUEST['keyword']) || trim($_REQUEST['keyword']) === '')
			redirect(azibai_url(),'refresh');
		/**
		 * @keyword world will be searched on azibai
		 * @type: 1-shop / 0-personal
		 * @year: content'year has created
		 */
		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
			'type' => $_REQUEST['type'],
			'year' => $_REQUEST['year'],
			'page' => $this->input->post('page'),
		];
		$params = array_filter($params);

		$url = $this->urlAPI_article;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		// dd(json_decode($make_call, true));die;

		if($this->input->is_ajax_request()) {
			$searchs = json_decode($make_call, true);
			$html = '';
			foreach ($searchs['data'] as $key => $item) {
				$html .= $this->load->view('search/home/element/article-item', ['item'=>$item], true);
			}
			echo $html; die;
		} else {
			$this->set_layout('search/home/main-layout');
			$data['searchs'] = json_decode($make_call, true);
			$this->load->view('search/home/page/page-article', $data);
		}
    }

	public function search_personal()
	{
		if(!isset($_REQUEST['keyword']) || trim($_REQUEST['keyword']) === '')
			redirect(azibai_url(),'refresh');

		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
			'province' => $_REQUEST['province'],
			// 'district' => '',
			'page' => $this->input->post('page'),
		];
		$params = array_filter($params);

		$url = $this->urlAPI_personal;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		// dd(json_decode($make_call, true));die;

		if($this->input->is_ajax_request()) {
			$searchs = json_decode($make_call, true);
			$html = '';
			foreach ($searchs['data'] as $key => $item) {
				$html .= $this->load->view('search/home/element/personal-item', ['item'=>$item], true);
			}
			echo $html; die;
		} else {
			$filter['order_by'] = 'pre_name ASC';
			$data['provinces'] = $this->province_model->getProvince($filter);
			$data['searchs'] = json_decode($make_call, true);
			$this->set_layout('search/home/main-layout');
			$this->load->view('search/home/page/page-personal', $data);
		}
	}

	public function search_company()
	{
		if(!isset($_REQUEST['keyword']) || trim($_REQUEST['keyword']) === '')
			redirect(azibai_url(),'refresh');

		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
			'category' => $_REQUEST['category'],	// 	!isset($_REQUEST['category']) == tất cả || $_REQUEST['category'] theo ngành hàng
			'is_follow' => $_REQUEST['is_follow'], 	// 	!isset($_REQUEST['is_follow']) == tất cả || != 0 Những doanh nghiệp bạn theo dõi
			'is_type' => $_REQUEST['is_type'], 		// 	!isset($_REQUEST['is_type']) == tất cả || 1 Nhiều người theo dõi || 2 Nhiều sản phẩm nhất
			'province' => $_REQUEST['province'],	//	!isset($_REQUEST['province']) == tất cả || $_REQUEST['province'] theo thành phố
			// 'district' => '',
			'page' => $this->input->post('page'),
		];

		$params = array_filter($params);

		$url = $this->urlAPI_company;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		// dd(json_decode($make_call, true));die;

		if($this->input->is_ajax_request()) {
			$searchs = json_decode($make_call, true);
			$html = '';
			foreach ($searchs['data'] as $key => $item) {
				$html .= $this->load->view('search/home/element/company-item', ['item'=>$item], true);
			}
			echo $html; die;
		} else {
			$filter['order_by'] = 'pre_name ASC';
			$data['provinces'] = $this->province_model->getProvince($filter);
			$data['categories'] = $this->category_model->get_category_shop();
			// dd($data['categories']);die;
			$data['searchs'] = json_decode($make_call, true);
			$this->set_layout('search/home/main-layout');
			$this->load->view('search/home/page/page-company', $data);
		}
	}

	public function search_image()
	{
		if(!isset($_REQUEST['keyword']) || trim($_REQUEST['keyword']) === '')
			redirect(azibai_url(),'refresh');

		$params = [
			'keyword' => urldecode(trim($_REQUEST['keyword'])),
			'year' => $_REQUEST['year'],
			'image_attr' => $_REQUEST['image_attr'],
			'image_type' => $_REQUEST['image_type'],
			'page' => $this->input->post('page'),
		];
		$params = array_filter($params);

		$url = $this->urlAPI_image;
		$rent_header = "user_id: ". ($this->session->userdata('sessionUser') ? $this->session->userdata('sessionUser') : 0) ;
		$make_call = $this->callAPI('GET', $url, $params, $rent_header);
		// dd(json_decode($make_call, true));die;

		if($this->input->is_ajax_request()) {
			$searchs = json_decode($make_call, true);
			$html = '';
			foreach ($searchs['data'] as $key => $item) {
				$html .= $this->load->view('search/home/element/image-item', ['item'=>$item], true);
			}
			echo $html; die;
		} else {
			$data['searchs'] = json_decode($make_call, true);
			$this->set_layout('search/home/main-layout');
			$this->load->view('search/home/page/page-image.php', $data);
		}
	}



	// ------------------------------------------------------------------------
	// not use
	// ------------------------------------------------------------------------
	function product()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
        #BEGIN: Add favorite
        $data['successFavoriteProduct'] = false;
        $data['isLogined'] = false;
		if($this->check->is_logined($this->session->userdata('sessionUser'), $this->session->userdata('sessionGroup'), 'home'))
		{
            $data['isLogined'] = true;
			if($this->session->flashdata('sessionSuccessFavoriteProduct'))
        	{
				$data['successFavoriteProduct'] = true;
        	}
        	if($this->input->post('checkone') && is_array($this->input->post('checkone')) && count($this->input->post('checkone')) > 0 && time() - (int)$this->session->userdata('sessionTimePosted') > (int)settingTimePost)
        	{
				$this->load->model('product_favorite_model');
				$isAdded = false;
				foreach($this->input->post('checkone') as $checkOneArray)
				{
                    $productOne = $this->product_model->get("pro_user", "pro_id = ".(int)$checkOneArray);
                    $productFavorite = $this->product_favorite_model->get("prf_id", "prf_product = ".(int)$checkOneArray." AND prf_user = ".(int)$this->session->userdata('sessionUser'));
					if(count($productOne) == 1 && count($productFavorite) == 0 && $productOne->pro_user != $this->session->userdata('sessionUser') && $this->check->is_id($checkOneArray))
					{
                        $dataAdd = array(
                                            'prf_product'       =>      (int)$checkOneArray,
                                            'prf_user'          =>      (int)$this->session->userdata('sessionUser'),
                                            'prf_date'          =>      $currentDate
											);
						if($this->product_favorite_model->add($dataAdd))
						{
							$isAdded = true;
						}
					}
				}
				unset($productOne);
				unset($productFavorite);
				if($isAdded == true)
				{
					$this->session->set_flashdata('sessionSuccessFavoriteProduct', 1);
				}
				$this->session->set_userdata('sessionTimePosted', time());
				redirect(base_url().trim(uri_string(), '/'), 'location');
        	}
		}
        #END Add favorite
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'product';
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		//$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		$this->load->model('category_model');
		$data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
		#END Fetch Relate
		#Module
        $data['module'] = 'top_saleoff_product,top_buyest_product';
        #BEGIN: Top product saleoff right
		$select = "pro_id, pro_name, pro_descr, pro_category, pro_image, pro_dir, pro_begindate";
		$start = 0;
  		$limit = (int)settingProductSaleoff_Top;
		$data['topSaleoffProduct'] = $this->product_model->fetch($select, "pro_saleoff = 1 AND pro_status = 1 AND pro_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top product saleoff right
        #BEGIN: Top product buyest right
		$select = "pro_id, pro_name, pro_descr, pro_buy, pro_category, pro_image, pro_dir";
		$start = 0;
  		$limit = (int)settingProductBuyest_Top;
		$data['topBuyestProduct'] = $this->product_model->fetch($select, "pro_buy > 0 AND pro_status = 1 AND pro_enddate >= $currentDate", "pro_buy", "DESC", $start, $limit);
		#END Top product buyest right
		#Define url for $getVar
		$action = array('name', 'sCost', 'eCost', 'currency', 'saleoff', 'place', 'category', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "pro_status = 1 AND pro_enddate >= $currentDate  AND sho_status = 1";
		$sort = 'up_date';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		$getVarCat = $this->uri->uri_to_assoc(5, $action);
		
	
		$data['titleSiteGlobal'] = $getVar['name']." | Thông tin ".$getVar['name']." | Giá ".$getVar['name'];
		$data['descrSiteGlobal'] = $getVar['name']." - "."Thông tin ".$getVar['name']." - Giá ".$getVar['name']." - Mua bán ".$getVar['name']." tại azibai.com";
		
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['name']." trong Sản phẩm";
		
		if($getVar['name'] != FALSE && strlen(trim($getVar['name'])) > 2)
		{
  			$data['nameKeyword'] = $this->filter->html($getVar['name']);
  			$sortUrl .= '/name/'.$getVar['name'];
	    	$pageUrl .= '/name/'.$getVar['name'];
			$where .= " AND pro_name LIKE '%".$this->filter->injection_html($getVar['name'])."%'";
			$haveSearch++;
		}
		if($getVarCat['cat']>0 && isset($getVarCat['cat'])){
			$where .= " AND pro_category = ".$getVarCat['cat'];
			$data['activeCat']=$getVarCat['cat'];
		}
		if($getVar['sCost'] != FALSE && (int)$getVar['sCost'] > 0 && $getVar['eCost'] != FALSE && (int)$getVar['eCost'] >= (int)$getVar['sCost'] && $getVar['currency'] != FALSE && (strtoupper($getVar['currency']) == 'VND' || strtoupper($getVar['currency']) == 'USD'))
		{
  			$data['sCostKeyword'] = (int)$getVar['sCost'];
  			$data['eCostKeyword'] = (int)$getVar['eCost'];
  			$data['currencyKeyword'] = $getVar['currency'];
  			$sortUrl .= '/sCost/'.$getVar['sCost'].'/eCost/'.$getVar['eCost'].'/currency/'.$getVar['currency'];
	    	$pageUrl .= '/sCost/'.$getVar['sCost'].'/eCost/'.$getVar['eCost'].'/currency/'.$getVar['currency'];
	    	if((int)$getVar['sCost'] == (int)$getVar['eCost'])
	    	{
                $where .= " AND pro_cost = ".(int)$getVar['sCost'];
	    	}
			else
			{
                $where .= " AND pro_cost >= ".(int)$getVar['sCost']." AND pro_cost <= ".(int)$getVar['eCost'];
			}
			$where .= " AND pro_currency = '".$this->filter->injection_html(strtoupper($getVar['currency']))."'";
			$haveSearch++;
		}
		if($getVar['saleoff'] != FALSE && (int)$getVar['saleoff'] == 1)
		{
  			$data['saleoffKeyword'] = $getVar['saleoff'];
  			$sortUrl .= '/saleoff/'.$getVar['saleoff'];
	    	$pageUrl .= '/saleoff/'.$getVar['saleoff'];
			$where .= " AND pro_saleoff = 1";
			$haveSearch++;
		}
		if($getVar['place'] != FALSE && (int)$getVar['place'] > 0)
		{
  			$data['placeKeyword'] = $getVar['place'];
  			$sortUrl .= '/place/'.$getVar['place'];
	    	$pageUrl .= '/place/'.$getVar['place'];
			$where .= " AND pro_province = ".(int)$getVar['place'];
			$haveSearch++;
		}
		if($getVar['category'] != FALSE && (int)$getVar['category'] > 0)
		{
  			$data['categoryKeyword'] = $getVar['category'];
  			$sortUrl .= '/category/'.$getVar['category'];
	    	$pageUrl .= '/category/'.$getVar['category'];
			$where .= " AND pro_category = ".(int)$getVar['category'];
			$haveSearch++;
		}
		if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
		{
  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
	    	{
                $where .= " AND pro_begindate = ".(int)$getVar['sPostdate'];
	    	}
			else
			{
                $where .= " AND pro_begindate >= ".(int)$getVar['sPostdate']." AND pro_begindate <= ".(int)$getVar['ePostdate'];
			}
			$haveSearch++;
		}
		
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'nameSort':
					    $pageUrl .= '/sort/nameSort';
					    $sort = "pro_name";
					    break;
	                case 'cost':
					    $pageUrl .= '/sort/cost';
					    $sort = "pro_cost";
					    break;
	                case 'buy':
					    $pageUrl .= '/sort/buy';
					    $sort = "pro_buy";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "pro_view";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "pro_begindate";
					    break;
					default:
					    $pageUrl .= '/sort/up_date';
					    $sort = "up_date";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/product'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "",$where, "", "", 0, (int)settingSearchProduct*100));
	        $config['base_url'] = base_url().'search/product'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchProduct;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
			$select = "pro_id, pro_name, pro_descr, pro_cost, pro_currency, pro_category, pro_image, pro_dir, pro_view, pro_comment, pro_saleoff, pro_hondle,pro_type_saleoff,pro_saleoff_value,pro_view,sho_name,sho_begindate,pre_name,pro_detail,pro_vote,pro_vote_total";
			$limit = settingSearchProduct;
			$data['searchProduct'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_product.pro_province", "", "", "",$where, $sort, $by, $start, $limit);

			//$data['searchProduct'] = $this->product_model->fetch_join($select,"LEFT","tbtt_shop","tbtt_product.pro_user = tbtt_shop.sho_user", "LEFT", "tbtt_province", "tbtt_province.pre_id = tbtt_shop.sho_province", "", "", "", $where, $sort, $by, $start, $limit);
		}
		#Load view
		$this->load->view('home/search/product', $data);
	}
	
	function raovat()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'raovat';
		//$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		$retArray = $this->loadCategory(0,0);	
		$data['menu'] = $retArray;
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		$this->load->model('category_model');
		$data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
		#END Fetch Relate
		#Module
        $data['module'] = 'top_shop_ads,top_view_ads';
        #BEGIN: Top shop ads right
		$select = "ads_id, ads_title, ads_descr, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsShop_Top;
		$data['topShopAds'] = $this->ads_model->fetch($select, "ads_is_shop = 1 AND ads_status = 1 AND ads_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop ads right
		#BEGIN: Top view ads right
		$select = "ads_id, ads_title, ads_descr, ads_view, ads_category, ads_begindate";
		$start = 0;
  		$limit = (int)settingAdsViewest_Top;
		$data['topViewAds'] = $this->ads_model->fetch($select, "ads_status = 1 AND ads_enddate >= $currentDate", "ads_view", "DESC", $start, $limit);
		#END Top view ads right
		#Define url for $getVar
		$action = array('title', 'sView', 'eView', 'place', 'category', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		$getVarCat = $this->uri->uri_to_assoc(5, $action);
		#BEGIN: Sort
		$where = "ads_status = 1 AND ads_enddate >= $currentDate";
		$sort = 'up_date';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		
		$data['titleSiteGlobal'] = $getVar['title']." | tìm kiếm rao vặt về ".$getVar['title']." tại azibai.com";
		$data['descrSiteGlobal'] = $getVar['title']." - "."hàng ngàn tin đăng về ".$getVar['title']." tại azibai.com";
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['title']." trong Rao vặt";
		
		if($getVar['title'] != FALSE && strlen(trim($getVar['title'])) > 2)
		{
  			$data['titleKeyword'] = $this->filter->html($getVar['title']);
  			$sortUrl .= '/title/'.$getVar['title'];
	    	$pageUrl .= '/title/'.$getVar['title'];
			$where .= " AND ads_title LIKE '%".$this->filter->injection_html($getVar['title'])."%'";
			$haveSearch++;
		}
		if($getVarCat['cat']>0 and isset($getVarCat['cat'])){
			$where .= " AND ads_category =".$getVarCat['cat'];
			$data['activeCat']=$getVarCat['cat'];
		}
		if($getVar['sView'] != FALSE && (int)$getVar['sView'] >= 0 && $getVar['eView'] != FALSE && (int)$getVar['eView'] >= (int)$getVar['sView'])
		{
  			$data['sViewKeyword'] = (int)$getVar['sView'];
  			$data['eViewKeyword'] = (int)$getVar['eView'];
  			$sortUrl .= '/sView/'.$getVar['sView'].'/eView/'.$getVar['eView'];
	    	$pageUrl .= '/sView/'.$getVar['sView'].'/eView/'.$getVar['eView'];
	    	if((int)$getVar['sView'] == (int)$getVar['eView'])
	    	{
                $where .= " AND ads_view = ".(int)$getVar['sView'];
	    	}
			else
			{
                $where .= " AND ads_view >= ".(int)$getVar['sView']." AND ads_view <= ".(int)$getVar['eView'];
			}
			$haveSearch++;
		}
		if($getVar['place'] != FALSE && (int)$getVar['place'] > 0)
		{
  			$data['placeKeyword'] = $getVar['place'];
  			$sortUrl .= '/place/'.$getVar['place'];
	    	$pageUrl .= '/place/'.$getVar['place'];
			$where .= " AND ads_province = ".(int)$getVar['place'];
			$haveSearch++;
		}
		if($getVar['category'] != FALSE && (int)$getVar['category'] > 0)
		{
  			$data['categoryKeyword'] = $getVar['category'];
  			$sortUrl .= '/category/'.$getVar['category'];
	    	$pageUrl .= '/category/'.$getVar['category'];
			$where .= " AND ads_category = ".(int)$getVar['category'];
			$haveSearch++;
		}
		if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
		{
  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
	    	{
                $where .= " AND ads_begindate = ".(int)$getVar['sPostdate'];
	    	}
			else
			{
                $where .= " AND ads_begindate >= ".(int)$getVar['sPostdate']." AND ads_begindate <= ".(int)$getVar['ePostdate'];
			}
			$haveSearch++;
		}
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'titleSort':
					    $pageUrl .= '/sort/titleSort';
					    $sort = "ads_title";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "ads_begindate";
					    break;
	                case 'placeSort':
					    $pageUrl .= '/sort/placeSort';
					    $sort = "ads_province";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "ads_view";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "ads_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/raovat'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->ads_model->fetch("ads_id", $where, "", "", 0, (int)settingSearchAds*100));
	        $config['base_url'] = base_url().'search/raovat'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchAds;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
			$select = "ads_id, ads_title, ads_descr, ads_category, ads_view, ads_begindate, ads_province";
			$limit = settingSearchAds;
			$data['searchAds'] = $this->ads_model->fetch($select, $where, $sort, $by, $start, $limit);
		}
		#Load view
		$this->load->view('home/search/raovat', $data);
	}
	
	function job()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuFieldJob'] = false;
        $data['menuFieldEmploy'] = false;
		$data['menuSelected'] = 'job';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		$this->load->model('field_model');
		$data['field'] = $this->field_model->fetch("fie_id, fie_name", "fie_status = 1", "fie_order", "ASC");
		#END Fetch relate
		#Module
        $data['module'] = 'top_24h_job,top_24h_employ';
        #BEGIN: Top job 24h right
		$select = "job_id, job_field, job_title, job_time_surrend, job_position";
		$start = 0;
  		$limit = (int)settingJob24Gio_J_Top*3;
		$data['top24hJob'] = $this->job_model->fetch($select, "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC", $start, $limit);
		#END Top job 24h right
		#BEGIN: Top employ 24h right
		$select = "emp_id, emp_field, emp_title, emp_level, emp_position";
		$start = 0;
  		$limit = (int)settingJob24Gio_E_Top*3;
		$data['top24hEmploy'] = $this->employ_model->fetch($select, "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC", $start, $limit);
		#END Top employ 24h right
		#Define url for $getVar
		$action = array('title', 'salary', 'currency', 'place', 'field', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "job_status = 1 AND job_enddate >= $currentDate";
		$sort = 'job_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		if($getVar['title'] != FALSE && strlen(trim($getVar['title'])) > 2)
		{
  			$data['titleKeyword'] = $this->filter->html($getVar['title']);
  			$sortUrl .= '/title/'.$getVar['title'];
	    	$pageUrl .= '/title/'.$getVar['title'];
			$where .= " AND job_title LIKE '%".$this->filter->injection_html($getVar['title'])."%'";
			$haveSearch++;
		}
		if($getVar['salary'] != FALSE && (int)$getVar['salary'] > 0 && $getVar['currency'] != FALSE && (strtoupper($getVar['currency']) == 'VND' || strtoupper($getVar['currency']) == 'USD'))
		{
  			$data['salaryKeyword'] = (int)$getVar['salary'];
  			$data['currencyKeyword'] = $getVar['currency'];
  			$sortUrl .= '/salary/'.$getVar['salary'].'/currency/'.$getVar['currency'];
	    	$pageUrl .= '/salary/'.$getVar['salary'].'/currency/'.$getVar['currency'];
	    	$where .= " AND job_salary LIKE '%".$this->filter->injection_html($getVar['salary'].'|'.$getVar['currency'])."%'";
			$haveSearch++;
		}
		if($getVar['place'] != FALSE && (int)$getVar['place'] > 0)
		{
  			$data['placeKeyword'] = $getVar['place'];
  			$sortUrl .= '/place/'.$getVar['place'];
	    	$pageUrl .= '/place/'.$getVar['place'];
			$where .= " AND job_province = ".(int)$getVar['place'];
			$haveSearch++;
		}
		if($getVar['field'] != FALSE && (int)$getVar['field'] > 0)
		{
  			$data['fieldKeyword'] = $getVar['field'];
  			$sortUrl .= '/field/'.$getVar['field'];
	    	$pageUrl .= '/field/'.$getVar['field'];
			$where .= " AND job_field = ".(int)$getVar['field'];
			$haveSearch++;
		}
		if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
		{
  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
	    	{
                $where .= " AND job_begindate = ".(int)$getVar['sPostdate'];
	    	}
			else
			{
                $where .= " AND job_begindate >= ".(int)$getVar['sPostdate']." AND job_begindate <= ".(int)$getVar['ePostdate'];
			}
			$haveSearch++;
		}
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'titleSort':
					    $pageUrl .= '/sort/titleSort';
					    $sort = "job_title";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "job_begindate";
					    break;
	                case 'placeSort':
					    $pageUrl .= '/sort/placeSort';
					    $sort = "job_province";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "job_view";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "job_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/job'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->job_model->fetch("job_id", $where, "", "", 0, (int)settingSearchJob*100));
	        $config['base_url'] = base_url().'search/job'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchJob;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
			$select = "job_id, job_title, job_field, job_view, job_time_surrend, job_position, job_begindate, job_province";
			$limit = settingSearchJob;
			$data['searchJob'] = $this->job_model->fetch($select, $where, $sort, $by, $start, $limit);
		}
		
		$data['titleSiteGlobal'] = $getVar['title']." - kết quả tìm kiếm tuyển dụng ".$getVar['title'];
		$data['descrSiteGlobal'] = $getVar['title']." - "."tìm kiếm Tuyển dụng – Hàng trăm ngàn tin tuyển dụng, việc làm ".$getVar['title']." trên khắp Việt Nam tại azibai.com";
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['title']." trong Tuyển dụng";
		#Load view
		$this->load->view('home/search/job', $data);
	}
	
	function employ()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuFieldJob'] = false;
        $data['menuFieldEmploy'] = false;
		$data['menuSelected'] = 'employ';
		$data['menuType'] = 'job';
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_status = 1", "pre_order", "ASC");
		$this->load->model('field_model');
		$data['field'] = $this->field_model->fetch("fie_id, fie_name", "fie_status = 1", "fie_order", "ASC");
		#END Fetch relate
		#Module
        $data['module'] = 'top_24h_job,top_24h_employ';
        #BEGIN: Top job 24h right
		$select = "job_id, job_field, job_title, job_time_surrend, job_position";
		$start = 0;
  		$limit = (int)settingJob24Gio_J_Top*3;
		$data['top24hJob'] = $this->job_model->fetch($select, "job_status = 1 AND job_enddate >= $currentDate", "job_id", "DESC", $start, $limit);
		#END Top job 24h right
		#BEGIN: Top employ 24h right
		$select = "emp_id, emp_field, emp_title, emp_level, emp_position";
		$start = 0;
  		$limit = (int)settingJob24Gio_E_Top*3;
		$data['top24hEmploy'] = $this->employ_model->fetch($select, "emp_status = 1 AND emp_enddate >= $currentDate", "emp_id", "DESC", $start, $limit);
		#END Top employ 24h right
		#Define url for $getVar
		$action = array('title', 'salary', 'currency', 'place', 'field', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "emp_status = 1 AND emp_enddate >= $currentDate";
		$sort = 'emp_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		if($getVar['title'] != FALSE && strlen(trim($getVar['title'])) > 2)
		{
  			$data['titleKeyword'] = $this->filter->html($getVar['title']);
  			$sortUrl .= '/title/'.$getVar['title'];
	    	$pageUrl .= '/title/'.$getVar['title'];
			$where .= " AND emp_title LIKE '%".$this->filter->injection_html($getVar['title'])."%'";
			$haveSearch++;
		}
		if($getVar['salary'] != FALSE && (int)$getVar['salary'] > 0 && $getVar['currency'] != FALSE && (strtoupper($getVar['currency']) == 'VND' || strtoupper($getVar['currency']) == 'USD'))
		{
  			$data['salaryKeyword'] = (int)$getVar['salary'];
  			$data['currencyKeyword'] = $getVar['currency'];
  			$sortUrl .= '/salary/'.$getVar['salary'].'/currency/'.$getVar['currency'];
	    	$pageUrl .= '/salary/'.$getVar['salary'].'/currency/'.$getVar['currency'];
	    	$where .= " AND emp_salary LIKE '%".$this->filter->injection_html($getVar['salary'].'|'.$getVar['currency'])."%'";
			$haveSearch++;
		}
		if($getVar['place'] != FALSE && (int)$getVar['place'] > 0)
		{
  			$data['placeKeyword'] = $getVar['place'];
  			$sortUrl .= '/place/'.$getVar['place'];
	    	$pageUrl .= '/place/'.$getVar['place'];
			$where .= " AND emp_province = ".(int)$getVar['place'];
			$haveSearch++;
		}
		if($getVar['field'] != FALSE && (int)$getVar['field'] > 0)
		{
  			$data['fieldKeyword'] = $getVar['field'];
  			$sortUrl .= '/field/'.$getVar['field'];
	    	$pageUrl .= '/field/'.$getVar['field'];
			$where .= " AND emp_field = ".(int)$getVar['field'];
			$haveSearch++;
		}
		if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
		{
  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
	    	{
                $where .= " AND emp_begindate = ".(int)$getVar['sPostdate'];
	    	}
			else
			{
                $where .= " AND emp_begindate >= ".(int)$getVar['sPostdate']." AND emp_begindate <= ".(int)$getVar['ePostdate'];
			}
			$haveSearch++;
		}
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'titleSort':
					    $pageUrl .= '/sort/titleSort';
					    $sort = "emp_title";
					    break;
	                case 'date':
					    $pageUrl .= '/sort/date';
					    $sort = "emp_begindate";
					    break;
	                case 'placeSort':
					    $pageUrl .= '/sort/placeSort';
					    $sort = "emp_province";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "emp_view";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "emp_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/employ'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->employ_model->fetch("emp_id", $where, "", "", 0, (int)settingSearchJob*100));
	        $config['base_url'] = base_url().'search/employ'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchJob;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
			$select = "emp_id, emp_title, emp_field, emp_view, emp_level, emp_position, emp_begindate, emp_province";
			$limit = settingSearchJob;
			$data['searchEmploy'] = $this->employ_model->fetch($select, $where, $sort, $by, $start, $limit);
		}
		$data['titleSiteGlobal'] = $getVar['title']." - kết quả tìm kiếm ứng viên ".$getVar['title'];
		$data['descrSiteGlobal'] = $getVar['title']." - "."tìm kiếm thông tin ứng viên, người tìm việc handmade – Hàng trăm ngàn tin người tìm việc, tìm việc làm, thông tin ứng viên ".$getVar['title']." trên khắp Việt Nam tại azibai.com";
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['title']." trong Tìm việc";
		#Load view
		$this->load->view('home/search/employ', $data);
	}
	function loadCategory($parent, $level)
	{
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   //$link = anchor('raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
			   $link = '<a href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
			   if($key == 0){
			   		$retArray .= "<li class='menu_item_top dc-mega-li'>".$link;
			   }else if($key == count($category)-1){
			   		$retArray .= "<li class='menu_item_last dc-mega-li'>".$link;
			   }else{
			   		$retArray .= "<li class='dc-mega-li'>".$link;
			   }
			   $retArray .=$this->loadSubCategory($row->cat_id, $level+1);
			   $retArray .= "</li>";
		   }
		     $retArray .= "</ul>";
	   }
	   return $retArray;
	}
	function loadSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega'>";
			$retArray .= "<ul class='sub'>";
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 450;}
			if(count($category) >= 3){$rowwidth = 660;}
			foreach ($category as $key=>$row)
			{
				$link = '<a class="mega-hdr-a" alt="'.$row->cat_name.'" href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				if($key % 3 == 0){
					$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 2 || $key = count($category)-1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->loadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
					$retArray .= "</div>";
				}
			}
			$retArray .= "</ul></div>";
	   }
	   return $retArray;
	}
	function loadSubSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC","0","5");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor('raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().'raovat/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
					$retArray.= "<li ><a class='xemtatca_menu' href='".base_url()."product/xemtatca/".$parent."' > Xem tất cả </a></li>";
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	function shop()
	{
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuSelected'] = 0;
		$data['menuType'] = 'shop';
		$data['menu'] = $this->menu_model->fetch("men_name, men_descr, men_image, men_category", "men_status = 1", "men_order", "ASC");
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
		$this->load->model('province_model');
		$data['province'] = $this->province_model->fetch("pre_id, pre_name", "pre_id != 1 AND pre_status = 1", "pre_order", "ASC");
		$this->load->model('category_model');
		$data['category'] = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
		#END Fetch Relate
		#Module
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
		$select = "sho_name, sho_link, sho_descr, sho_begindate";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->shop_model->fetch($select, "sho_saleoff = 1 AND sho_status = 1 AND sho_enddate >= $currentDate", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
        #BEGIN: Top productest right
		$select = "sho_descr, sho_link, sho_dir_logo, sho_logo";
		$start = 0;
  		$limit = (int)settingShopProductest_Top;
		$data['topProductestShop'] = $this->shop_model->fetch($select, "sho_status = 1 AND sho_enddate >= $currentDate", "sho_quantity_product", "DESC", $start, $limit);
		#END Top productest right
		#Define url for $getVar
		$action = array('name', 'saleoff', 'address', 'province', 'category', 'sPostdate', 'ePostdate', 'sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "sho_status = 1 AND sho_enddate >= $currentDate";
		$sort = 'sho_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		if($getVar['name'] != FALSE && strlen(trim($getVar['name'])) > 2)
		{
  			$data['nameKeyword'] = $this->filter->html($getVar['name']);
  			$sortUrl .= '/name/'.$getVar['name'];
	    	$pageUrl .= '/name/'.$getVar['name'];
			$where .= " AND sho_name LIKE '%".$this->filter->injection_html($getVar['name'])."%'";
			$haveSearch++;
		}
		if($getVar['saleoff'] != FALSE && (int)$getVar['saleoff'] == 1)
		{
  			$data['saleoffKeyword'] = $getVar['saleoff'];
  			$sortUrl .= '/saleoff/'.$getVar['saleoff'];
	    	$pageUrl .= '/saleoff/'.$getVar['saleoff'];
			$where .= " AND sho_saleoff = 1";
			$haveSearch++;
		}
		if($getVar['address'] != FALSE && strlen(trim($getVar['address'])) > 5)
		{
  			$data['addressKeyword'] = $this->filter->html($getVar['address']);
  			$sortUrl .= '/address/'.$getVar['address'];
	    	$pageUrl .= '/address/'.$getVar['address'];
			$where .= " AND sho_address LIKE '%".$this->filter->injection_html($getVar['address'])."%'";
			$haveSearch++;
		}
		if($getVar['province'] != FALSE && (int)$getVar['province'] > 0)
		{
  			$data['provinceKeyword'] = $getVar['province'];
  			$sortUrl .= '/province/'.$getVar['province'];
	    	$pageUrl .= '/province/'.$getVar['province'];
			$where .= " AND sho_province = ".(int)$getVar['province'];
			$haveSearch++;
		}
		if($getVar['category'] != FALSE && (int)$getVar['category'] > 0)
		{
  			$data['categoryKeyword'] = $getVar['category'];
  			$sortUrl .= '/category/'.$getVar['category'];
	    	$pageUrl .= '/category/'.$getVar['category'];
			$where .= " AND sho_category = ".(int)$getVar['category'];
			$haveSearch++;
		}
		if($getVar['sPostdate'] != FALSE && (int)$getVar['sPostdate'] > (int)mktime(0, 0, 0, 1, 1, 2008) && $getVar['ePostdate'] != FALSE && (int)$getVar['ePostdate'] >= (int)$getVar['sPostdate'])
		{
  			$data['sDayKeyword'] = date('d', $getVar['sPostdate']);
  			$data['sMonthKeyword'] = date('m', $getVar['sPostdate']);
  			$data['sYearKeyword'] = date('Y', $getVar['sPostdate']);
  			$data['eDayKeyword'] = date('d', $getVar['ePostdate']);
  			$data['eMonthKeyword'] = date('m', $getVar['ePostdate']);
  			$data['eYearKeyword'] = date('Y', $getVar['ePostdate']);
  			$sortUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	$pageUrl .= '/sPostdate/'.$getVar['sPostdate'].'/ePostdate/'.$getVar['ePostdate'];
	    	if((int)$getVar['sPostdate'] == (int)$getVar['ePostdate'])
	    	{
                $where .= " AND sho_begindate = ".(int)$getVar['sPostdate'];
	    	}
			else
			{
                $where .= " AND sho_begindate >= ".(int)$getVar['sPostdate']." AND sho_begindate <= ".(int)$getVar['ePostdate'];
			}
			$haveSearch++;
		}
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'nameSort':
					    $pageUrl .= '/sort/nameSort';
					    $sort = "sho_name";
					    break;
	                case 'addressSort':
					    $pageUrl .= '/sort/addressSort';
					    $sort = "sho_address";
					    break;
	                case 'view':
					    $pageUrl .= '/sort/view';
					    $sort = "sho_view";
					    break;
                    case 'product':
					    $pageUrl .= '/sort/product';
					    $sort = "sho_quantity_product";
					    break;
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "sho_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/shop'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
			$totalRecord = count($this->shop_model->fetch("sho_id", $where, "", "", 0, (int)settingSearchShop*100));
	        $config['base_url'] = base_url().'search/shop'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchShop;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
			$select = "sho_name, sho_descr, sho_view, sho_quantity_product, sho_link, sho_dir_logo, sho_logo, sho_address, sho_saleoff, sho_yahoo, sho_phone, sho_province";
			$limit = settingSearchShop;
			$data['searchShop'] = $this->shop_model->fetch($select, $where, $sort, $by, $start, $limit);
		}
		#Load view
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['name']." trong Gian hàng";
		$this->load->view('home/search/shop', $data);
	}
	
	function hoidap()
	{
		 	
		$this->lang->load('home/common');
		$this->lang->load('home/hoidap');
		#Load model
		$this->load->model('hds_model');
		$this->load->model('answers_model');
		$this->load->model('hd_category_model');
		$this->load->model('product_model');		
		$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
		$data['menuType'] = 'hoidap';
		$retArray = $this->SearchloadCategory(0,0);	
		$data['menu'] = $retArray;
		#END Menu
		#BEGIN: Advertise
		$data['advertisePage'] = 'search';
		$data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
		#END Advertise
		#BEGIN: Counter
		
	
		#END Menu
		
		#BEGIN: Counter
		$data['counter'] = $this->counter_model->get();
		#END Counter
		#BEGIN: Fetch relate
			
		$this->load->model('hd_category_model');
		$data['category'] = $this->hd_category_model->fetch("cat_id, cat_name", "cat_status = 1", "cat_name", "ASC");
		#END Fetch Relate
		#Module
		
        $data['module'] = 'top_saleoff_shop,top_productest_shop';
        #BEGIN: Top shop saleoff right
		$select = "hds_title, hds_content, hds_category, hds_username";
		$start = 0;
  		$limit = (int)settingShopSaleoff_Top;
		$data['topSaleoffShop'] = $this->hds_model->fetch($select, "hds_status = 1", "rand()", "DESC", $start, $limit);
		#END Top shop saleoff right
        #BEGIN: Top productest right
		$select = "hds_title, hds_content, hds_category, hds_username";
		$start = 0;
  		$limit = (int)settingShopProductest_Top;
		$data['topProductestShop'] = $this->hds_model->fetch($select, "hds_status = 1", "hds_title", "DESC", $start, $limit);
		#END Top productest right
		#Define url for $getVar
		$action = array('name','address','category','sort', 'by', 'page');
		$getVar = $this->uri->uri_to_assoc(3, $action);
		#BEGIN: Sort
		$where = "hds_status = 0";
		$sort = 'hds_id';
		$by = 'DESC';
		$sortUrl = '';
		$pageSort = '';
		$pageUrl = '';
		$haveSearch = 0;
		if($getVar['name'] != FALSE && strlen(trim($getVar['name'])) > 2)
		{
  			$data['nameKeyword'] = $this->filter->html($getVar['name']);
  			$sortUrl .= '/name/'.$getVar['name'];
	    	$pageUrl .= '/name/'.$getVar['name'];
			$where .= " AND hds_title LIKE '%".$this->filter->injection_html($getVar['name'])."%'";
			$haveSearch++;
		}
		
		if($getVar['category'] != FALSE && (int)$getVar['category'] > 0)
		{
  			$data['categoryKeyword'] = $getVar['category'];
  			$sortUrl .= '/category/'.$getVar['category'];
	    	$pageUrl .= '/category/'.$getVar['category'];
			$where .= " hds_category  = ".(int)$getVar['category'];
			$haveSearch++;
		}
			
		if($haveSearch > 0)
		{
			if($getVar['sort'] != FALSE && trim($getVar['sort']) != '')
			{
				switch(strtolower($getVar['sort']))
				{
					case 'nameSort':
					    $pageUrl .= '/sort/nameSort';
					    $sort = "sho_name";
					    break;
	             
                  
					default:
					    $pageUrl .= '/sort/id';
					    $sort = "hds_id";
				}
				if($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc')
				{
	                $pageUrl .= '/by/desc';
					$by = "DESC";
				}
				else
				{
	                $pageUrl .= '/by/asc';
					$by = "ASC";
				}
			}
			#If have page
			if($getVar['page'] != FALSE && (int)$getVar['page'] > 0)
			{
				$start = (int)$getVar['page'];
				$pageSort .= '/page/'.$start;
			}
			else
			{
				$start = 0;
			}
			#END Sort
			#BEGIN: Create link sort
			$data['sortUrl'] = base_url().'search/hoidap'.$sortUrl.'/sort/';
			$data['pageSort'] = $pageSort;
			#END Create link sort
			#BEGIN: Pagination
			$this->load->library('pagination');
			#Count total record
				
			$totalRecord = count($this->hds_model->fetch("hds_id", $where, "", "", 0, (int)settingSearchShop*100));
	        $config['base_url'] = base_url().'search/hoidap'.$pageUrl.'/page/';
			$config['total_rows'] = $totalRecord;
			$config['per_page'] = settingSearchShop;
			$config['num_links'] = 1;
			$config['uri_segment'] = 5;
			$config['cur_page'] = $start;
			$this->pagination->initialize($config);
			$data['linkPage'] = $this->pagination->create_links();
			#END Pagination
			$data['totalResult'] = $totalRecord;
			#Fetch record
	
			$select = "hds_title, hds_content, hds_category, hds_user, hds_username, hds_email, hds_yahoo, hds_skype, hds_view, hds_like";
			$limit = settingSearchShop;
			//var_dump($where);die();
			

			$data['searchHoidap'] = $this->hds_model->hds_model->fetch_join("*, cat_name,sho_dir_logo,sho_logo","LEFT","tbtt_hd_category","tbtt_hds.hds_category = tbtt_hd_category.cat_id", "LEFT", "tbtt_shop", "tbtt_shop.sho_user = tbtt_hds.hds_user","", "", "", $where, $sort, $by, $start, $limit);
		}
		//var_dump($this->hds_model->fetch("hds_title", "", $sort, $by, $start, $limit));die();
		#Load view
		
		$data['h1tagSiteGlobal'] = "Kết quả tìm kiếm ".$getVar['name']." trong Hỏi đáp";
		
		$this->load->view('home/search/hoidap', $data);
	}
	
	function SearchloadCategory($parent, $level)
	{
		$retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
		    $retArray .= "<ul id='mega-1' class='mega-menu right'>";
		   foreach ($category as $key=>$row)
		   {
			   //$link = anchor('hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
			   $link = '<a href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
			   if($key == 0){
			   		$retArray .= "<li class='menu_item_top dc-mega-li'>".$link;
			   }else if($key == count($category)-1){
			   		$retArray .= "<li class='menu_item_last dc-mega-li'>".$link;
			   }else{
			   		$retArray .= "<li class='dc-mega-li'>".$link;
			   }
			   $retArray .=$this->SearchloadSubCategory($row->cat_id, $level+1);
			   $retArray .= "</li>";
		   }
		     $retArray .= "</ul>";
	   }
	   return $retArray;
	}
	function SearchloadSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<div class='sub-container mega'>";
			$retArray .= "<ul class='sub'>";
			$rowwidth = 190;
			if(count($category) == 2){$rowwidth = 450;}
			if(count($category) >= 3){$rowwidth = 660;}
			foreach ($category as $key=>$row)
			{
				//$link = anchor('product/category/'.RemoveSign($row->cat_name).'_'.$row->cat_id, $row->cat_name, array('title' => $row->cat_name));
				$link = '<a class="mega-hdr-a" alt="'.$row->cat_name.'" href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
				if($key % 3 == 0){
					$retArray .= "<div class='row' style='width: ".$rowwidth."px;'>";
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->SearchloadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->SearchloadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
				}else if($key % 3 == 2 || $key = count($category)-1){
					$retArray .= "<li class='mega-unit mega-hdr'>";
					$retArray .= $link;
					$retArray .=$this->SearchloadSubSubCategory($row->cat_id, $level+1);
					$retArray .= "</li>";
					$retArray .= "</div>";
				}
			}
			$retArray .= "</ul></div>";
	   }
	   return $retArray;
	}
	function SearchloadSubSubCategory($parent, $level)
	{
	   $retArray = '';
	   $select = "*";
	   $whereTmp = "cat_status = 1  and parent_id='$parent'";	
	   $category  = $this->hd_category_model->fetch($select, $whereTmp, "cat_name", "ASC");
	   if( count($category)>0){
	   		$retArray .= "<ul>";
				foreach ($category as $key=>$row)
				{
					//$link = anchor('hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name), $row->cat_name, array('title' => $row->cat_name));
					$link = '<a href="'.base_url().'hoidap/'.$row->cat_id.'/'.RemoveSign($row->cat_name).'">'.$row->cat_name.'</a>';
					$retArray .= "<li>".$link."</li>";
				}
			$retArray .= "</ul>";
	   }
	   return $retArray;
	 }
	 
	 
	 
}