<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/8/2015
 * Time: 15:19 PM
 */
class Package_user_model extends CI_Model {

    function __construct() {
	parent::__construct();

	$this->load->database();

	// Paginaiton defaults
	$this->pagination_enabled = FALSE;
	$this->pagination_per_page = 20;
	$this->pagination_num_links = 5;
	$this->pager = '';
	$this->num = 0;

	$this->filter = array('st' => '', 'pt' => '', 'q' => '', 'df' => '', 'dt' => '');

	$this->_link = '';
    }

    function pagination($bool) {
	$this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getSort() {
	return array(
	    array('id' => 1, 'text' => 'Tăng dần', 'link' => $this->buildLink(array('dir=asc'))),
	    array('id' => 1, 'text' => 'Giảm dần', 'link' => $this->buildLink(array('dir=desc')))
	);
    }

    function getwhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_package_user");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

    function buildLink($parrams, $issort = false) {
	if ($issort == true) {
	    unset($this->filter['sort']);
	    unset($this->filter['dir']);
	}
	foreach ($this->filter as $key => $val) {
	    if ($val != '') {
		array_unshift($parrams, $key . '=' . $val);
	    }
	}
	return '?' . implode('&', $parrams);
    }

    function getFilter() {
	return $this->filter;
    }

    function setLink($var) {
	$this->_link = $var;
    }

    function getLink() {
	return $this->_link;
    }

    function lister($where = array(), $page = FALSE) {

	$this->db->start_cache();
	$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'created_date';
	$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
	$dir = strtolower($dir);
	$dir = $dir == 'asc' ? 'asc' : 'desc';
	$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
	$this->filter['sort'] = $sort;
	$this->filter['dir'] = $dir;
	$this->filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
	$this->filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
	$this->filter['st'] = isset($_REQUEST['st']) ? $_REQUEST['st'] : '';
	$this->filter['pt'] = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';
	$this->filter['os'] = isset($_REQUEST['os']) ? $_REQUEST['os'] : '';

	if (isset($where['os'])) {
	    $this->filter['os'] = $where['os'];
	    unset($where['os']);
	}

	switch ($this->filter['os']) {
	    case '01':
		$where['tbtt_package_user.payment_status'] = 0;
		$where['tbtt_package_user.status'] = 0;
		break;
	    case '02':
		$where['tbtt_package_user.payment_status'] = 1;
		$where['tbtt_package_user.status'] = 0;
		break;
	    case '03':
		$where['tbtt_package_user.payment_status'] = 1;
		$where['tbtt_package_user.status'] = 1;
		$this->db->where('tbtt_package_user.begined_date <= NOW()', null);
		$this->db->where('tbtt_package_user.ended_date >= NOW()', null);
		break;
	    case '04':
		$where['tbtt_package_user.payment_status'] = 1;
		$where['tbtt_package_user.status'] = 1;
		$this->db->where('tbtt_package_user.begined_date <= NOW()', null);
		$this->db->where('tbtt_package_user.ended_date >= NOW()', null);
		$this->db->where('DATE_SUB(tbtt_package_user.ended_date,INTERVAL 30 DAY) <= NOW()', null);
		break;
	    case '05':
		$where['tbtt_package_user.payment_status'] = 1;
		$where['tbtt_package_user.status'] = 1;
		$this->db->where('tbtt_package_user.ended_date <= NOW()', null);
		break;
	    case '06':
		$where['tbtt_package_user.status'] = 9;
		break;
	}
	if ($this->filter['df'] != '') {
	    switch ($this->filter['sort']) {
		case 'created_date':
		    $where['tbtt_package_user.created_date >='] = $this->db->escape($this->filter['df']);
		    break;
		case 'begined_date':
		    $where['tbtt_package_user.begined_date >='] = $this->db->escape($this->filter['df']);
		    break;
		case 'ended_date':
		    $where['tbtt_package_user.ended_date >='] = $this->db->escape($this->filter['df']);
		    break;
		case 'payment_date':
		    $where['tbtt_package_user.payment_date >='] = $this->db->escape($this->filter['df']);
		    break;
	    }
	}
	if ($this->filter['dt'] != '') {
	    switch ($this->filter['sort']) {
		case 'created_date':
		    $where['tbtt_package_user.created_date <='] = $this->db->escape($this->filter['dt']);
		    break;
		case 'begined_date':
		    $where['tbtt_package_user.begined_date <='] = $this->db->escape($this->filter['dt']);
		    break;
		case 'ended_date':
		    $where['tbtt_package_user.ended_date <='] = $this->db->escape($this->filter['dt']);
		    break;
		case 'payment_date':
		    $where['tbtt_package_user.payment_date <='] = $this->db->escape($this->filter['dt']);
		    break;
	    }
	}

	//Filter price
	$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
	if ($pid != '') {
	    $this->filter['pid'] = $pid;
	    $where['tbtt_package.info_id'] = $this->filter['pid'];
	}

	$period = isset($_REQUEST['period']) ? $_REQUEST['period'] : '';
	if ($period != '') {
	    $this->filter['period'] = $period;
	    $where['tbtt_package.period'] = $this->filter['period'];
	}

	// Set filter
	if (trim($q) != '') {
	    $searchString = $this->db->escape('%' . $q . '%');
	    $this->db->where("(tbtt_user.`use_username` LIKE  {$searchString} OR tbtt_user.`use_fullname` LIKE  {$searchString} OR tbtt_user.`use_email` LIKE  {$searchString}) ");
	    $this->filter['q'] = trim($q);
	}
	switch ($this->filter['sort']) {
	    case 'user':
		$this->db->order_by("tbtt_user.`use_fullname`", $this->filter['dir']);
		break;
	    case 'created_date':
		$this->db->order_by("tbtt_package_user.`created_date`", $this->filter['dir']);
		break;
	    case 'begined_date':
		$this->db->order_by("tbtt_package_user.`begined_date`", $this->filter['dir']);
		break;
	    case 'ended_date':
		$this->db->order_by("tbtt_package_user.`ended_date`", $this->filter['dir']);
		break;
	    case 'payment_date':
		$this->db->order_by("tbtt_package_user.`payment_date`", $this->filter['dir']);
		break;
	}


	$select = 'tbtt_package_user.`id`
                  ,tbtt_package_user.`user_id`
                  ,tbtt_package_user.`sponser_id`
                  ,(SELECT `use_fullname` FROM `tbtt_user` WHERE `use_id` = tbtt_package_user.`sponser_id`) as sponserName
                  ,tbtt_package_user.`created_date`
                  ,tbtt_package_user.`begined_date`
                  ,tbtt_package_user.`ended_date`
                  ,tbtt_package_user.`payment_status`
                  ,tbtt_package_user.`status`
                  ,tbtt_package_user.`amount`
                  ,tbtt_package.`info_id`
                  ,(SELECT `name` FROM `tbtt_package_info` WHERE `id` = tbtt_package.`info_id`) as package
                  ,tbtt_package.`period`
                  ,tbtt_user.`use_fullname`
                  ,tbtt_user.`use_username`
                  ,tbtt_user.`use_address`
                  ,tbtt_user.`use_phone`
				  ,tbtt_user.`parent_id`
                  ,tbtt_user.`use_yahoo`
                  ';

	// Unset user id
	unset($where['use_id']);
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_user', 'tbtt_package_user.user_id = tbtt_user.use_id');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id');
	$this->db->where($where);

	/**
	 *   PAGINATION
	 */
	if ($this->pagination_enabled == TRUE) {
	    $config = array();
	    $config['cur_page'] = $page;
	    $config['total_rows'] = $this->db->count_all_results();
	    $config['base_url'] = $this->_link;
	    $config['uri_segment'] = 3;
	    $config['cur_tag_open'] = '<li><span class="current">';
	    $config['cur_tag_close'] = '</span></li>';
	    $config['per_page'] = $this->pagination_per_page;
	    $config['num_links'] = $this->pagination_num_links;
	    $config['suffix'] = $this->buildLink(array());
	    $this->load->library('pagination');
	    $this->pagination->initialize($config);
	    $this->pager = $this->pagination->create_links();
	    $this->num = $page;
	    $this->db->limit($config['per_page'], $page);
	}

	// Get the results
	$query = $this->db->get();
	$temp_result = $query->result_array();

	//echo $this->db->last_query(); die;
	$this->db->flush_cache();
	return $temp_result;
    }

    function getPackage($where = NULL) {
	$this->db->select('*');
	$this->db->from('tbtt_package_info');

	if (isset($where['id']) && $where['id']) {
	    $this->db->where('id', $where['id']);
	}

	$this->db->order_by("tbtt_package_info.`id`", "asc");
	$query = $this->db->get();
	return $query->result_array();
    }

    function getListPackage() {
	$sql = "SELECT
                  `id`,
                  `name`
                FROM
                  `tbtt_package_info`
                WHERE `published` = 1
                UNION
                SELECT
                  `p_type` AS id,
                  `p_name` AS `name`
                FROM
                  `tbtt_package_daily`
                WHERE `published` = 1";
	$query = $this->db->query($sql);
	return $query->result_array();
    }

    function getPeriod() {
	return array(
	    array('id' => 3, 'name' => '3 Tháng'),
	    array('id' => 6, 'name' => '6 Tháng'),
	    array('id' => 12, 'name' => '12 Tháng')
	);
    }

    function getSortDate() {
	return array(
	    array('id' => 'created_date', 'name' => 'Ngày tạo'),
	    array('id' => 'begined_date', 'name' => 'Ngày bắt đầu'),
	    array('id' => 'ended_date', 'name' => 'Ngày kết thúc'),
	    array('id' => 'payment_date', 'name' => 'Ngày xác nhận thanh toán')
	);
    }

    function getAdminSort() {
	$sortField = array('id', 'name', 'period', 'month_price', 'user', 'created_date');
	$data = array();
	foreach ($sortField as $item) {
	    $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
	    $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
	}
	return $data;
    }

    function getServiceStatus() {
	return array(
	    array('id' => '01', 'name' => 'Dịch vụ đang yêu cầu'),
	    array('id' => '02', 'name' => 'Dịch vụ đã thanh toán'),
	    array('id' => '03', 'name' => 'Dịch vụ đang sử dụng'),
	    array('id' => '04', 'name' => 'Dịch vụ sắp hết hạn'),
	    array('id' => '05', 'name' => 'Dịch vụ hết hạn'),
	    array('id' => '06', 'name' => 'Dịch vụ bị hủy'),
	);
    }

    function completePayment($id) {
	$result = 0;
	$date = date('Y-m-d H:i:s');
	$data = array(
	    'payment_status' => 1,
	    'modified_date' => $date,
	    'payment_date' => $date
	);
	$this->db->cache_off();
	$this->db->where('id', $id);
	$this->db->where('payment_status', 0);
	$this->db->where('status', 0);
	$this->db->update('tbtt_package_user', $data);
	if ($this->db->affected_rows() > 0) {
	    $this->db->select('tbtt_package.id');
	    $this->db->from('tbtt_package_user');
	    $this->db->join('tbtt_package', 'tbtt_package.id = tbtt_package_user.package_id');
	    $this->db->where('tbtt_package_user.id', $id);
	    $query = $this->db->get();
	    $row = $query->row_array();
	    $query->free_result();
	    $sql = "INSERT INTO `tbtt_package_user_service` (
                  `order_id`,
                  `service_id`,
                  `status`,
                  `note`,
                  `created_date`,
                  `modified_date`
                )
                (SELECT
                  {$id},
                  ps.service_id,
                  IF(s.install = 1, 0, 1),
                  s.note,
                  NOW(),
                  NOW()
                FROM
                  `tbtt_package_service` AS ps
                  LEFT JOIN `tbtt_service` AS s
                    ON ps.`service_id` = s.id
                WHERE ps.package_id = {$row['id']}) ";
	    $this->db->query($sql);
	    $result = 1;
	}


	return $result;
    }

    function cancelOrder($id) {
	$data = array(
	    'status' => 9,
	    'modified_date' => date('Y-m-d H:i:s')
	);
	$this->db->cache_off();
	$this->db->where('id', $id);
	$this->db->update('tbtt_package_user', $data);
	return $this->db->affected_rows();
    }

    function startService($id) {
	$return = 0;
	$date = date('Y-m-d H:i:s');
	$this->db->cache_off();
	$this->db->select('tbtt_package.period');
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package.id = tbtt_package_user.package_id');
	$this->db->where('tbtt_package_user.id', $id);
	$this->db->where('tbtt_package_user.payment_status', 1);
	$this->db->where('tbtt_package_user.status', 0);
	$query = $this->db->get();
	$row = $query->row_array();
	$query->free_result();
	//echo $this->db->last_query();

	if (!empty($row) && $row['period'] > 0) {
	    // Update service
	    $sql = "UPDATE tbtt_package_user
                            SET `status` = 1
                            , begined_date = NOW()
                            , ended_date = DATE_ADD( NOW(),INTERVAL {$row['period']} MONTH)
                            , modified_date = '{$date}'
                    WHERE id = {$id}";
	    $this->db->query($sql);
	    $return = $this->db->affected_rows();
	} elseif (!empty($row) && $row['period'] == -1) {
	    $sql = "UPDATE tbtt_package_user
                            SET `status` = 1
                            , begined_date = NOW()
                            , ended_date = DATE_ADD( NOW(),INTERVAL {$row['period']} MONTH)
                            , modified_date = '{$date}'
                    WHERE id = {$id}";
	    $this->db->query($sql);
	    $return = $this->db->affected_rows();
	}
	return $return;
    }

    function getWallet($uid) {
	$this->db->cache_off();
	$sql = "SELECT
                  SUM(IF(`type` = '1', `amount`, 0)) AS amount_money,
                  SUM(IF(`type` = '2', `amount`, 0)) AS amount_point
                FROM
                  `tbtt_wallet`
                WHERE user_id = {$uid}
                  AND `status` <> 9 ";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getPackAmount($package, $userId) {
		$this->db->cache_off();
		$sql = "SELECT
	                IF (
	                    discount_rate > 0,
	                    ABS(
	                      `month_price` * `period` * (100 - `discount_rate`) / 100
	                    ),
	                    ABS(`month_price` * `period`)
	                  ) AS request_amt, period, info_id
	                  
	                FROM
	                  `tbtt_package`
	                WHERE id = {$package}";
		$query = $this->db->query($sql);
		return $query->row_array();
    }

    function getLimitService($pack_id) {
	$this->db->cache_off();
	$sql = "SELECT
                  `limit`
                FROM
                  `tbtt_service`  
                JOIN
                  `tbtt_package_service` ON tbtt_package_service.`service_id` = tbtt_service.`id`
                JOIN
                  `tbtt_package` ON tbtt_package.`id` = tbtt_package_service.`package_id`
                WHERE `tbtt_package`.id = {$pack_id}";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getPackAmountBran($package) {
	$this->db->cache_off();
	$sql = "SELECT
                  IF (
                    discount_rate > 0,
                    ABS(
                      `month_price` * `period` * (100 - `discount_rate`) / 100
                    ),
                    ABS(`month_price` * `period`)
                  )  AS price
                FROM
                  `tbtt_package`
                WHERE info_id = {$package}";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getPackAmountCTV($package) {
	$this->db->cache_off();
	$sql = "SELECT
                  IF (
                    discount_rate > 0,
                    ABS(
                      `month_price` * `period` * (100 - `discount_rate`) / 100
                    ),
                    ABS(`month_price` * `period`)
                  )  AS price
                FROM
                  `tbtt_package`
                WHERE info_id = {$package}";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getPackInfomation($package, $periods) {
	$this->db->cache_off();
	$sql = "SELECT
                  IF (
                    discount_rate > 0,
                    ABS(
                      `month_price` * `period` * (100 - `discount_rate`) / 100
                    ),
                    ABS(`month_price` * `period`)
                  )  AS request_amt, period, info_id,
                  DATE_FORMAT(NOW(), '%d/%m/%Y') as begined_date,
                  DATE_FORMAT(DATE_ADD(NOW(), INTERVAL {$periods} MONTH), '%d/%m/%Y') AS ended_date
                FROM
                  `tbtt_package`
                WHERE id = {$package} AND $periods = {$periods}";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getRemainAmount($uid) {
	$this->db->cache_off();
	$sql = "SELECT
                  amount,
                  DATEDIFF(ended_date, begined_date) AS num_date,
                  IF(
                    begined_date <= NOW(),
                    DATEDIFF(ended_date, NOW()),
                    IF(
                      begined_date > NOW(),
                      DATEDIFF(ended_date, begined_date),
                      0
                    )
                  ) AS remain
                FROM
                  tbtt_package_user
                  LEFT JOIN tbtt_package
                    ON tbtt_package.id = tbtt_package_user.package_id
                WHERE tbtt_package_user.user_id = {$uid}
                  AND payment_status = 1
                  AND STATUS = 1
                  AND tbtt_package.info_id >= 2
                  AND tbtt_package.info_id <= 7 ";
	$query = $this->db->query($sql);
	return $query->result_array();
    }

    function getPackageName($package) {
	$sql = "SELECT
                  period,
                  tbtt_package.unit_type,
                  tbtt_package_info.name
                FROM
                  tbtt_package
                  LEFT JOIN tbtt_package_info
                    ON tbtt_package.info_id = tbtt_package_info.id
                WHERE tbtt_package.id =  " . (int) $package;
	$data = $this->db->query($sql)->row_array();
	return $data['period'] != -1 ? $data['name'] . ' ' . $data['period'] . ' ' . $data['unit_type'] : $data['name'];
    }

    function add($data){

		$this->db->insert("tbtt_package_user", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

    function addPackage($uid, $package, $postData = array(),$discount = array(),$iUserAffId = 0) {

		$amount = $this->getWallet($uid);
		$amount_request = $this->getPackAmount($package, $iUserAffId);
		
		// Nếu có affiliate thì lấy giá bằng affiliate
		if(isset($discount['discount_price']) && $discount['discount_price'] != 0) {
			$amount_request['request_amt'] 		= $discount['discount_price'];
			$amount_request['discount_price'] 	= $discount['discount_price'];
			$amount_request['discount_percen'] 	= $discount['discount_percen'];
		}else {
			$amount_request['discount_price'] = 0;
			$amount_request['discount_percen'] = 0;
		}
	
		$date = date('Y-m-d H:i:s');
		$this->load->model('user_model');
		$this->load->model('shop_model');
		$userObject = $this->user_model->get("parent_id, use_group", "use_id = " . $uid);
		$shop_info = $this->shop_model->get("sho_id, sho_discount_rate", "sho_user = " . $uid);
		$discountShop = ($shop_info->sho_discount_rate > 0) ? (100 - $shop_info->sho_discount_rate) / 100 : 1;

		$postData['type_pay'] = !empty($postData['type_pay']) ? (int) $postData['type_pay'] : 0;

		//Get Số lượng chi nhánh shop mở
		$limited = 1;
		if ($amount_request['info_id'] == 16) 
		{
		    $limited = $limited * (int) $postData['numbran'];
		}

		if ($amount_request['info_id'] == 17) 
		{
		    $limited = $limited * (int) $postData['num_ctv'];
		}

		// Goi mien phi
		if ($package == 1) 
		{
		    $sql = " SELECT
	                          COUNT(*) AS num
	                        FROM
	                          `tbtt_package_user`
	                        WHERE `package_id` = 1
	                          AND `user_id` = {$uid}";
		    $result = $this->db->query($sql);
		    if ($result->row()->num > 0) 
		    {
				return array('error' => true, 'message' => 'Gói dịch vụ đã tồn tại');
		    } 
		    else 
		    {
				$data = array();
				$data['package_id'] = $package;
				$data['user_id'] = $uid;
				$data['sponser_id'] = $userObject->parent_id;
				$data['created_date'] = $date;
				$data['begined_date'] = $date;
				$data['payment_status'] = 1;
				$data['payment_date'] = $date;
				$data['status'] = 1;
				$data['amount'] = $amount_request['request_amt'];
				$data['real_amount'] = $amount_request['request_amt'] * $discountShop;
				$this->db->insert('tbtt_package_user', $data);
				$id = $this->db->insert_id();

				// Insert service
				$sql = "INSERT INTO `tbtt_package_user_service` (
		                  `order_id`,
		                  `service_id`,
		                  `status`,
		                  `note`,
		                  `created_date`,
		                  `modified_date`
		                )
		                (SELECT
		                  {$id},
		                  ps.service_id,
		                  IF(s.install = 1, 0, 1),
		                  s.note,
		                  NOW(),
		                  NOW()
		                FROM
		                  `tbtt_package_service` AS ps
		                  LEFT JOIN `tbtt_service` AS s
		                    ON ps.`service_id` = s.id
		                WHERE ps.package_id = 1 )";
				$this->db->query($sql);
				return array('error' => false, 'message' => 'Thành công');
			}
		} 
		else 
		{
		    $totalRemain = 0;
		    $package_name = $this->getPackageName($package);
		    if ($amount_request['info_id'] >= 2 && $amount_request['info_id'] <= 7) 
		    {
				$totalRemain = 0;
				if ($postData['goline'] == 1) 
				{
				    $remainData = $this->getRemainAmount($uid);
				    foreach ($remainData as $item) {
					$totalRemain += $item['amount'] * $item['remain'] / $item['num_date'];
				    }
				}

				if ($amount_request['request_amt'] * $discountShop > $amount['amount_money'] + $totalRemain) 
				{
				    return array('error' => true, 'message' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ. Click <a class="link_popup" href="' . base_url() . 'account/addWallet">vào đây</a> để nạp tiền!');
				}

				if ($totalRemain > 0) 
				{
				    // Tra tien lai cho khach hang
				    $data = array();
				    $data['user_id'] = $uid;
				    $data['group_id'] = $userObject->use_group;
				    $data['parent_id'] = $userObject->parent_id;
				    $data['amount'] = floor($totalRemain);
				    $data['`type`'] = '1';
				    $data['description'] = 'Cộng tiền còn thừa của gói trước';
				    $data['created_date'] = $date;
				    $data['month_year'] = date('m-Y');
				    $data['`status`'] = '0';
				    $this->db->insert('tbtt_wallet', $data);

				    // Disable dichvu
				    $sql = "UPDATE
		                              tbtt_package_user
		                            SET
		                              `status` = 0
		                            WHERE user_id = {$uid}
		                              AND ended_date >= NOW()
		                              AND package_id IN
		                              (SELECT
		                                id
		                              FROM
		                                tbtt_package
		                              WHERE info_id >= 2
		                                AND info_id <= 7)";
				    $this->db->query($sql);
				}

				// Tru tien
				if ($amount_request['request_amt'] > 0) 
				{
				    $data = array();
				    $data['user_id'] = $uid;
				    $data['group_id'] = $userObject->use_group;
				    $data['parent_id'] = $userObject->parent_id;
				    $data['amount'] = 0 - $amount_request['request_amt'] * $discountShop;
				    $data['`type`'] = '1';
				    $data['description'] = 'Mua gói ' . $package_name;
				    $data['created_date'] = $date;
				    $data['month_year'] = date('m-Y');
				    $data['`status`'] = '0';
				    $this->db->insert('tbtt_wallet', $data);
				}
		    } 
		    else 
		    {
		    	
				if ((($amount_request['request_amt'] * $discountShop * $limited) > ($amount['amount_money'] + $amount['amount_point'])) && (empty($postData['type_pay']))) 
				{
				    return array('error' => true, 'message' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ. Click <a class="link_popup" href="' . base_url() . 'account/addWallet">vào đây</a> để nạp tiền!');
				}

				// Tru tien
				if ($amount_request['request_amt'] > 0) 
				{
					$use_money = 0;
				    $use_point = 0;
				    if ($amount['amount_point'] > 0 && $amount['amount_point'] >= $amount_request['request_amt'] * $discountShop) 
				    {
						$use_point = $amount_request['request_amt'] * $discountShop * $limited;
				    } 
				    else 
				    {
						$use_point = $amount['amount_point'];
						$use_money = $amount_request['request_amt'] * $discountShop * $limited - $use_point;
				    }

				    $type_pay = ' qua ví Azibai';
				    if ($postData['type_pay'] == 1) 
				    {
				    	$type_pay = ' qua ví MoMo';
				    }
				    else if ($postData['type_pay'] == 2) 
				    {
				    	$type_pay = ' qua thẻ ngân hàng nội địa - '. $postData['bankcode'];
				    }
				    else if ($postData['type_pay'] == 3) 
				    {
				    	$type_pay = ' qua thẻ Visa hoặc MasterCard - '. $postData['bankcode'];
				    }

				    if ($use_point > 0) 
				    {
						$data = array();
						$data['user_id'] = $uid;
						$data['group_id'] = $userObject->use_group;
						$data['parent_id'] = $userObject->parent_id;
						$data['amount'] = 0 - $use_point;
						$data['`type`'] = '2';
						$data['description'] = 'Mua gói ' . $package_name . $type_pay;
						$data['created_date'] = $date;
						$data['month_year'] = date('m-Y');
						$data['`status`'] = '0';
						$this->db->insert('tbtt_wallet', $data);
				    }

				    if ($use_money > 0) 
				    {
						$data = array();
						$data['user_id'] = $uid;
						$data['group_id'] = $userObject->use_group;
						$data['parent_id'] = $userObject->parent_id;
						$data['amount'] = 0 - $use_money;
						$data['`type`'] = '1';
						$data['description'] = 'Mua gói ' . $package_name . $type_pay;
						$data['created_date'] = $date;
						$data['month_year'] = date('m-Y');
						$data['`status`'] = '0';
						$this->db->insert('tbtt_wallet', $data);
				    }
				}
		    }

		    // Insert dich vu
		    $data = array();
		    $data['package_id'] = $package;
		    $data['user_id'] = $uid;
		    $data['sponser_id'] = $userObject->parent_id;
		    $data['created_date'] = $date;
		    if ($amount_request['info_id'] >= 2 && $amount_request['info_id'] <= 7) 
		    {
				if ($postData['goline'] == 1) 
				{
				    $available_date = $this->getGolineAvailableDate($amount_request['period']);
				} 
				else 
				{
				    $available_date = $this->getAvailableDate($uid, $amount_request['period']);
				}

				$data['begined_date'] = $available_date['begin_date'];
				$data['ended_date'] = $available_date['ended_date'];
			} 
			elseif ($amount_request['period'] == -1) 
			{
				$data['begined_date'] = $date;
			} 
			else 
			{
				
			}

			if (!empty($postData['type_pay'])) 
		    {
		    	$data['payment_status'] = 0;
		    	$data['status'] = 0;
		    } 
		    else 
		    {
		    	$data['payment_status'] = 1;
		    	$data['status'] = 1;
		    }
		    
		    $data['payment_date'] = $date;
		    $data['amount'] = $amount_request['request_amt'];

		    if ($amount_request['info_id'] == 16) 
		    {
				$numbran = (int) $postData['numbran'];
				$data['limited'] = $numbran;
				$data['amount'] = $amount_request['request_amt'] * $numbran;
				$data['real_amount'] = ($amount_request['request_amt'] * $discountShop - $totalRemain) * $numbran;
		    } 
		    elseif ($amount_request['info_id'] == 17) 
		    {
				$limit = $this->getLimitService($package);
				$numctv = (int) $postData['num_ctv'];
				$data['limited'] = $numctv * $limit['limit'];
				$data['amount'] = $amount_request['request_amt'] * $numctv;
				$data['real_amount'] = ($amount_request['request_amt'] * $discountShop - $totalRemain) * $numctv;
				$data['ended_date'] = date('Y-m-d H:i:s', strtotime("+12 months"));
		    } 
		    else 
		    {
				$data['real_amount'] = $amount_request['request_amt'] * $discountShop - $totalRemain;
				$data['limited'] = 1;
		    }

		    // Phần nâng cấp để tính affiliate

		    $data['user_affiliate_id'] = $iUserAffId;
		    $data['affiliate_percen'] = $amount_request['discount_percen'];
		    $data['affiliate_price_rate'] = ($amount_request['request_amt']/100) * $amount_request['discount_percen'];
		    $data['type_payment'] = !empty($postData['type_pay']) ? (int) $postData['type_pay']: 0;
		    $this->db->insert('tbtt_package_user', $data);
		    $id = $this->db->insert_id();

		    // Insert service
		    $sql = "INSERT INTO `tbtt_package_user_service` (
	                  `order_id`,
	                  `service_id`,
	                  `status`,
	                  `note`,
	                  `created_date`,
	                  `modified_date`
	                )
	                (SELECT
	                  {$id},
	                  ps.service_id,
	                  IF(s.install = 1, 0, 1),
	                  s.note,
	                  NOW(),
	                  NOW()
	                FROM
	                  `tbtt_package_service` AS ps
	                  LEFT JOIN `tbtt_service` AS s
	                    ON ps.`service_id` = s.id
	                WHERE ps.package_id = {$amount_request['info_id']}) ";
		    $this->db->query($sql);

		    // Add bonus point
		    $sql = "INSERT INTO `tbtt_wallet` (
	                          `user_id`,
	                          `group_id`,
	                          `parent_id`,
	                          `amount`,
	                          `type`,
	                          `description`,
	                          `created_date`,
	                          `month_year`,
	                          `status`
	                        )
	                        SELECT
	                          '{$uid}',
	                          '{$userObject->use_group}',
	                          '{$userObject->parent_id}',
	                          `point`,
	                          2,
	                          'Tặng tiền khi mua gói dịch vụ',
	                          NOW(),
	                          DATE_FORMAT(NOW(), '%m-%Y'),
	                          0
	                        FROM
	                          `tbtt_package`
	                        WHERE `period` = {$postData['periods']}
	                          AND `info_id` = {$postData['package']}
	                          AND `point` > 0";
		    $this->db->query($sql);
		    return array('error' => false, 'message' => 'Thành công', 'order_id' => $id, 'amount' => $data['amount'], 'link_pay' => '');
		}
	}

    function getAvailableDate($uid, $period) {
	$this->db->cache_off();
	$sql = "SELECT
                  pack.begin_date,
                  DATE_ADD(pack.begin_date, INTERVAL {$period} MONTH) AS ended_date,
                  pack.is_new
                FROM
                  (SELECT
                    IF(
                      MAX(tbtt_package_user.ended_date) IS NULL,
                      DATE_ADD(NOW(), INTERVAL 1 SECOND),
                      DATE_ADD(
                        MAX(tbtt_package_user.ended_date),
                        INTERVAL 1 SECOND
                      )
                    ) AS begin_date,
                    IF(
                      MAX(tbtt_package_user.ended_date) IS NULL,
                      1,
                      0
                    ) AS is_new
                  FROM
                    tbtt_package_user
                    LEFT JOIN tbtt_package
                      ON tbtt_package_user.package_id = tbtt_package.id
                  WHERE tbtt_package_user.user_id = {$uid}
                    AND tbtt_package_user.payment_status = 1
                    AND tbtt_package_user.status = 1
                    AND tbtt_package.info_id >= 2
                    AND tbtt_package.info_id <= 7) AS pack";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function getGolineAvailableDate($period) {
	$this->db->cache_off();
	$sql = "SELECT
                  NOW() as begin_date,
                  DATE_ADD(NOW(), INTERVAL {$period} MONTH) AS ended_date
                ";
	$query = $this->db->query($sql);
	return $query->row_array();
    }

    function addFreePackage($uid, $package) {
	$date = date('Y-m-d H:i:s');
	$this->db->cache_off();
	$this->db->select('id');
	$this->db->from('tbtt_package_user');
	$this->db->where('status', 0);
	$this->db->where('user_id', $uid);
	$query = $this->db->get();
	$row = $query->row_array();
	$query->free_result();
	$this->load->model('user_model');
	$userObject = $this->user_model->get("parent_id", "use_id = " . $uid);
	// echo $this->db->last_query();

	if (empty($row)) {
	    $sql = "INSERT INTO `tbtt_package_user` (
                  `id`,
                  `package_id`,
                  `user_id`,
                  `sponser_id`,
                  `created_date`,
                  `modified_date`,
                  `begined_date`,
                  `ended_date`,
                  `payment_status`,
                  `payment_date`,
                  `status`,
                  `amount`)
                (SELECT
                  NULL,
                  {$package},
                  {$uid},
                  {$userObject->parent_id},
                  '{$date}',
                  '{$date}',
                  '{$date}',
                  NULL,
                  1,
                  NULL,
                  1,
                  IF (
                    discount_rate > 0,
                    `month_price` * `period` * (100 - `discount_rate`) / 100,
                    `month_price` * `period`
                  )
                FROM
                  `tbtt_package`
                WHERE id = {$package}) ";
	    $this->db->query($sql);
	    $serviceId = $this->db->insert_id();


	    $sql = "INSERT INTO `tbtt_package_user_service` (
                  `order_id`,
                  `service_id`,
                  `status`,
                  `note`,
                  `created_date`,
                  `modified_date`
                )
                (SELECT
                  {$serviceId},
                  ps.service_id,
                  IF(s.install = 1, 0, 1),
                  s.note,
                  NOW(),
                  NOW()
                FROM
                  `tbtt_package_service` AS ps
                  LEFT JOIN `tbtt_service` AS s
                    ON ps.`service_id` = s.id
                WHERE ps.package_id = {$package}) ";

	    $this->db->query($sql);


	    //return array('error'=>false, 'message'=>'Thành công');
	}
    }

    function getPackageId($where) {
	$this->db->select('id');
	$this->db->from('tbtt_package');
	if (!empty($where)) {
	    $this->db->where($where);
	}
	// Get the results
	$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->row_array();
    }

    function getSubservice($id, $where = array()) {
	$this->db->select('tbtt_package_user_service.* ,  tbtt_service.name,  tbtt_service.id, tbtt_service.limit, tbtt_service.unit');
	$this->db->from('tbtt_package_user_service');
	$this->db->join('tbtt_service', 'tbtt_package_user_service.service_id = tbtt_service.id');
	$this->db->where('tbtt_package_user_service.order_id', $id);
	if (!empty($where)) {
	    $this->db->where($where);
	}
	$this->db->order_by("tbtt_package_user_service.`service_id`", "asc");
	$query = $this->db->get();
	//echo $this->db->last_query();
	return $query->result_array();
    }

    function updateUserService($data, $where) {
	if (!empty($where)) {
	    $this->db->where($where);
	}
	$this->db->update("tbtt_package_user_service", $data);
	return $this->db->affected_rows();
    }

    function getUserPackage($uid) {
	$this->db->cache_off();
	$select = 'tbtt_package_info.`name`,
                  tbtt_package.`period`,
                  tbtt_package_user.status,
                  tbtt_package_user.`payment_status`,
                  tbtt_package_user.`created_date`,
                  tbtt_package_user.`begined_date`,
                  tbtt_package_user.`ended_date`';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id ');
	$this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id ');
	$this->db->where('tbtt_package_user.user_id', $uid);
	$this->db->order_by("tbtt_package_user.`created_date`", 'asc');
	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->result_array();
	$this->db->flush_cache();
	return $temp_result;
    }

    function getCurrentPackage($uid) {
	$this->db->cache_off();
	$select = 'tbtt_package_info.`name`,
                   tbtt_package_info.id,                    
                   tbtt_package.`period`,
                   tbtt_package.`id` AS ID,
                   tbtt_package_user.status,
                   tbtt_package_user.`payment_status`,
                   tbtt_package_user.`created_date`,
                   tbtt_package_user.`begined_date`,
                   tbtt_package_user.`ended_date`';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id ');
	$this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id ');
	$this->db->where('tbtt_package_user.user_id', $uid);
	$this->db->where('tbtt_package.info_id >= ', 2);
	$this->db->where('tbtt_package.info_id <= ', 7);
	$this->db->where('tbtt_package_user.payment_status', 1);
	$this->db->where('tbtt_package_user.status', 1);
	$this->db->where('NOW() >= tbtt_package_user.begined_date AND (NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	//$this->db->order_by("tbtt_package_user.`created_date`", 'asc');
//	$this->db->order_by('tbtt_package_user.`id`', 'DESC');
	$this->db->limit(1);

	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->row_array();
	$this->db->flush_cache();
	return $temp_result;
    }

    function getUserList($where = array(), $page = FALSE) {

	$this->db->start_cache();
	$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
	$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
	$dir = strtolower($dir);
	$dir = $dir == 'asc' ? 'asc' : 'desc';
	$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
	$this->filter['sort'] = $sort;
	$this->filter['dir'] = $dir;


	// Set filter
	if (trim($q) != '') {
	    $searchString = $this->db->escape('%' . $q . '%');
	    $this->db->where("(tbtt_user.`use_username` LIKE  {$searchString} OR tbtt_user.`use_id` LIKE  {$searchString} OR tbtt_user.`use_fullname` LIKE  {$searchString} OR tbtt_user.`use_email` LIKE  {$searchString}) ");
	    $this->filter['q'] = trim($q);
	}
	switch ($this->filter['sort']) {
	    case 'name':
		$this->db->order_by("tbtt_user.`use_fullname`", $this->filter['dir']);
		break;
	    case 'begined_date':
		$this->db->order_by("tbtt_package_user.`begined_date`", $this->filter['dir']);
		break;
	    case 'ended_date':
		$this->db->order_by("tbtt_package_user.`ended_date`", $this->filter['dir']);
		break;
	    case 'payment_date':
		$this->db->order_by("tbtt_package_user.`payment_date`", $this->filter['dir']);
		break;
	}


	$select = 'use_id, use_fullname';

	// Unset user id
	unset($where['use_id']);
	$this->db->select($select);
	$this->db->from('tbtt_user');

	$this->db->where($where);

	/**
	 *   PAGINATION
	 */
	if ($this->pagination_enabled == TRUE) {
	    $config = array();
	    $config['cur_page'] = $page;
	    $config['total_rows'] = $this->db->count_all_results();
	    $config['base_url'] = $this->_link;
	    $config['uri_segment'] = 3;
	    $config['cur_tag_open'] = '<li><span class="current">';
	    $config['cur_tag_close'] = '</span></li>';
	    $config['per_page'] = $this->pagination_per_page;
	    $config['num_links'] = $this->pagination_num_links;
	    $config['suffix'] = $this->buildLink(array("dir={$dir}"));
	    $this->load->library('pagination');
	    $this->pagination->initialize($config);
	    $this->pager = $this->pagination->create_links();
	    $this->num = $page;
	    $this->db->limit($config['per_page'], $page);
	}

	// Get the results
	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->result_array();
	$this->db->flush_cache();
	foreach ($temp_result as &$item) {
	    $item['package'] = $this->getUserPackage($item['use_id']);
	}
	return $temp_result;
    }

    function getPackageList() {
	$select = 'id,
                  (SELECT
                    `name`
                  FROM
                    `tbtt_package_info`
                  WHERE id = info_id) AS "name",
                  `period`';
	//$this->db->start_cache();
	$this->db->select($select);
	$this->db->from('tbtt_package');
	$where = array('published' => 1);
	$this->db->where($where);
	$this->db->order_by("id", 'asc');
	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->result_array();
	foreach ($temp_result as &$item) {
	    $item['name'] .= ($item['period'] != -1) ? ' (' . $item['period'] . ' Tháng)' : ' (Không giới hạn)';
	    unset($item['period']);
	}
	return $temp_result;
    }

    function get($select = "*", $where = "") {
	$this->db->cache_off();
	$this->db->select($select);
	if ($where && $where != "") {
	    $this->db->where($where);
	}
	#Query
	$query = $this->db->get("tbtt_package_user");
	$result = $query->row();
	$query->free_result();
	return $result;
    }

    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0) {
	$this->db->cache_off();
	$this->db->select($select);
	if ($where && $where != "") {
	    $this->db->where($where);
	}
	if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
	    $this->db->order_by($order, $by);
	}
	if ((int) $start >= 0 && $limit && (int) $limit > 0) {
	    $this->db->limit($limit, $start);
	}
	#Query
	$query = $this->db->get("tbtt_package_user");
	$result = $query->result();
	$query->free_result();
	return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0) {
	$this->db->cache_off();
	$this->db->select($select);
	if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
	    $this->db->join($table_1, $on_1, $join_1);
	}
	if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
	    $this->db->join($table_2, $on_2, $join_2);
	}
	if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
	    $this->db->join($table_3, $on_3, $join_3);
	}
	if ($join_4 && ($join_4 == "INNER" || $join_4 == "LEFT" || $join_4 == "RIGHT") && $table_4 && $table_4 != "" && $on_4 && $on_4 != "") {
	    $this->db->join($table_4, $on_4, $join_4);
	}

	if ($where && $where != "") {
	    $this->db->where($where);
	}
	if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
	    $this->db->order_by($order, $by);
	}
	if ((int) $start >= 0 && $limit && (int) $limit > 0) {
	    $this->db->limit($limit, $start);
	}
	#Query
	$query = $this->db->get("tbtt_package_user");
	$result = $query->result();
	$query->free_result();
	return $result;
    }

    function listerUsingPage($uid, $page = 0) {
	$sql = "SELECT
                      *
                    FROM
                      (SELECT
                        tbtt_package_user.id,
                        tbtt_package_user.user_id,
                        tbtt_package_user.sponser_id,
                        tbtt_package_user.created_date,
                        tbtt_package_user.begined_date,
                        tbtt_package_user.modified_date,
                        tbtt_package_user.ended_date,
                        tbtt_package_user.payment_status,
                        tbtt_package_user.status,
                        tbtt_package_user.amount,
                        tbtt_package_user.limited as limited,
                        tbtt_package.id as package_id,
                        tbtt_package_user.real_amount,
                        tbtt_package.period,
                        tbtt_package.info_id,
                        (SELECT
                          NAME
                        FROM
                          tbtt_package_info
                        WHERE id = tbtt_package.info_id) AS package,
                        tbtt_package.unit_type,
                        '' AS content_info,
                        'package' AS 'pack_type',
                        0 AS 'content_num'
                      FROM
                        tbtt_package_user
                        LEFT JOIN tbtt_package
                          ON tbtt_package_user.package_id = tbtt_package.id
                      WHERE tbtt_package_user.user_id = {$uid}
                      UNION
                      SELECT
                        tbtt_package_daily_user.id,
                        tbtt_package_daily_user.user_id,
                        tbtt_package_daily_user.sponser_id,
                        tbtt_package_daily_user.created_date,
                        tbtt_package_daily_user.begined_date,
                        tbtt_package_daily_user.modified_date,
                        tbtt_package_daily_user.ended_date,
                        tbtt_package_daily_user.payment_status,
                        tbtt_package_daily_user.status,
                        tbtt_package_daily_user.amount,
                        tbtt_package_daily_user.pos_num as limited,
                        tbtt_package_daily_user.package_id as package_id,
                        tbtt_package_daily_user.real_amount,
                        IF(tbtt_package_daily.p_type = '09', tbtt_package_daily_user.pos_num, tbtt_package_daily.unit) AS period,
                        tbtt_package_daily.p_type as info_id,
                        tbtt_package_daily.p_name AS package,
                        tbtt_package_daily.unit_type,
                        IF(tbtt_package_daily_user.content_type = 'product',
                          (SELECT
                              GROUP_CONCAT(
                                CONCAT_WS(
                                  ';',
                                  `pro_dir`,
                                  `pro_category`,
                                  `pro_id`,
                                  `pro_name`
                                ) SEPARATOR '#'
                              )
                            FROM
                              `tbtt_package_daily_content` AS di
                              LEFT JOIN `tbtt_product` AS pro
                                ON di.`content_id` = pro.`pro_id`
                                AND di.`content_type` = 'product'
                            WHERE di.`order_id` = tbtt_package_daily_user.id
                           ) ,
                           (
                            SELECT
                              GROUP_CONCAT(
                                CONCAT_WS(
                                  ';',
                                  `id_category`,
                                  `not_id`,
                                  `not_title`
                                ) SEPARATOR '#'
                              )
                            FROM
                              `tbtt_package_daily_content` AS di
                              LEFT JOIN  `tbtt_content` AS c
                                ON c.`not_id` = di.`content_id`
                                AND di.`content_type` = 'news'
                            WHERE di.`order_id` = tbtt_package_daily_user.id
                          )
                        ) AS content_info,
                        'package_daily' AS 'pack_type',
                        tbtt_package_daily_user.content_num
                      FROM
                        tbtt_package_daily_user
                        LEFT JOIN tbtt_package_daily
                          ON tbtt_package_daily.id = tbtt_package_daily_user.package_id
                      WHERE tbtt_package_daily_user.user_id = {$uid}) AS a
                    ORDER BY a.created_date DESC ";
	$query = $this->db->query($sql);
	$total = $query->num_rows();

	$query = $this->db->query($sql . " LIMIT {$page}, {$this->pagination_per_page}");
	$config = array();
	$config['cur_page'] = $page;
	$config['total_rows'] = $total;
	$config['base_url'] = $this->_link;
	$config['uri_segment'] = 3;
	$config['cur_tag_open'] = '<li><span class="current">';
	$config['cur_tag_close'] = '</span></li>';
	$config['per_page'] = $this->pagination_per_page;
	$config['num_links'] = $this->pagination_num_links;
	$config['suffix'] = $this->buildLink(array());
	$this->load->library('pagination');
	$this->pagination->initialize($config);
	$this->pager = $this->pagination->create_links();
	$this->num = $page;
	$this->db->limit($config['per_page'], $page);

	$temp_result = $query->result_array();

	//echo $this->db->last_query(); die;
	$this->db->flush_cache();
	return $temp_result;
    }

    function listData($where = array(), $page = FALSE) {

	$this->db->start_cache();
	$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'created_date';
	$dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
	$dir = strtolower($dir);
	$dir = $dir == 'asc' ? 'asc' : 'desc';
	$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
	$this->filter['sort'] = $sort;
	$this->filter['dir'] = $dir;
	$this->filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
	$this->filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
	$this->filter['st'] = isset($_REQUEST['st']) ? $_REQUEST['st'] : '';
	$this->filter['pt'] = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';
	$this->filter['os'] = isset($_REQUEST['os']) ? $_REQUEST['os'] : '';

	if (isset($where['os'])) {
	    $this->filter['os'] = $where['os'];
	    unset($where['os']);
	}

	switch ($this->filter['os']) {
	    case '01':
		$where[] = 'a.payment_status = 0';
		$where[] = 'a.status = 0';
		break;
	    case '02':
		$where[] = 'a.payment_status = 1';
		$where[] = 'a.status = 0';
		break;
	    case '03':
		$where[] = 'a.payment_status = 1';
		$where[] = 'a.status = 1';
		$where[] = 'a.begined_date <= NOW()';
		$where[] = 'a.ended_date >= NOW()';
		break;
	    case '04':
		$where[] = 'a.payment_status = 1';
		$where[] = 'a.status = 1';
		$where[] = 'a.begined_date <= NOW()';
		$where[] = 'a.ended_date >= NOW()';
		$where[] = 'DATE_SUB(a.ended_date,INTERVAL 30 DAY) <= NOW()';
		break;
	    case '05':
		$where[] = 'a.payment_status = 1';
		$where[] = 'a.status = 1';
		$where[] = 'a.ended_date <= NOW()';
		break;
	    case '06':
		$where[] = 'a.status = 9';
		break;
	}
	if ($this->filter['df'] != '') {
	    switch ($this->filter['sort']) {
		case 'created_date':
		    $where[] = 'a.created_date >=' . $this->db->escape($this->filter['df']);
		    break;
		case 'begined_date':
		    $where[] = 'a.begined_date >=' . $this->db->escape($this->filter['df']);
		    break;
		case 'ended_date':
		    $where[] = 'a.ended_date >=' . $this->db->escape($this->filter['df']);
		    break;
		case 'payment_date':
		    $where[] = 'a.payment_date >=' . $this->db->escape($this->filter['df']);
		    break;
	    }
	}
	if ($this->filter['dt'] != '') {
	    switch ($this->filter['sort']) {
		case 'created_date':
		    $where[] = 'a.created_date <=' . $this->db->escape($this->filter['dt']);
		    break;
		case 'begined_date':
		    $where[] = 'a.begined_date <=' . $this->db->escape($this->filter['dt']);
		    break;
		case 'ended_date':
		    $where[] = 'a.ended_date <=' . $this->db->escape($this->filter['dt']);
		    break;
		case 'payment_date':
		    $where[] = 'a.payment_date <=' . $this->db->escape($this->filter['dt']);
		    break;
	    }
	}

	//Filter price
	$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
	if ($pid != '') {
	    $this->filter['pid'] = $pid;
	    $where[] = 'a.info_id = ' . $this->filter['pid'];
	}

	$period = isset($_REQUEST['period']) ? $_REQUEST['period'] : '';
	if ($period != '') {
	    $this->filter['period'] = $period;
	    $where[] = 'a.period = ' . $this->filter['period'];
	}

	// Set filter
	if (trim($q) != '') {
	    $searchString = $this->db->escape('%' . $q . '%');

	    $where[] = "(tbtt_user.`use_username` LIKE  {$searchString} OR tbtt_user.`use_fullname` LIKE  {$searchString} OR tbtt_user.`use_email` LIKE  {$searchString}) ";
	    $this->filter['q'] = trim($q);
	}
	$order = "ORDER BY ";
	switch ($this->filter['sort']) {
	    case 'user':
		$order .= "tbtt_user.`use_fullname`" . $this->filter['dir'];
		break;
	    case 'created_date':
		$order .= "a.`created_date` " . $this->filter['dir'];
		break;
	    case 'begined_date':
		$order .= "a.`begined_date` " . $this->filter['dir'];
		break;
	    case 'ended_date':
		$order .= "a.`ended_date` " . $this->filter['dir'];
		break;
	    case 'payment_date':
		$order .= "a.`payment_date` " . $this->filter['dir'];
		break;
	    default:
		$order .= "a.`created_date` " . $this->filter['dir'];
	}

	$sql = "SELECT
                      a.*,
                      tbtt_user.use_fullname,
                      (SELECT `use_fullname` FROM `tbtt_user` WHERE `use_id` = a.`sponser_id`) as sponserName
                    FROM
                      (SELECT
                        tbtt_package_user.id,
                        tbtt_package_user.user_id,
                        tbtt_package_user.sponser_id,
                        tbtt_package_user.created_date,
                        tbtt_package_user.begined_date,
                        tbtt_package_user.modified_date,
                        tbtt_package_user.ended_date,
                        tbtt_package_user.payment_status,
                        tbtt_package_user.status,
                        tbtt_package_user.amount,
                        tbtt_package.period,
                        tbtt_package.info_id,
                        (SELECT
                          NAME
                        FROM
                          tbtt_package_info
                        WHERE id = tbtt_package.info_id) AS package,
                        tbtt_package.unit_type,
                        'package' AS 'pack_type'
                      FROM
                        tbtt_package_user
                        LEFT JOIN tbtt_package
                          ON tbtt_package_user.package_id = tbtt_package.id
                      UNION
                      SELECT
                        tbtt_package_daily_user.id,
                        tbtt_package_daily_user.user_id,
                        tbtt_package_daily_user.sponser_id,
                        tbtt_package_daily_user.created_date,
                        tbtt_package_daily_user.begined_date,
                        tbtt_package_daily_user.modified_date,
                        tbtt_package_daily_user.ended_date,
                        tbtt_package_daily_user.payment_status,
                        tbtt_package_daily_user.status,
                        tbtt_package_daily_user.amount,
                        IF(tbtt_package_daily.p_type = '09', tbtt_package_daily_user.pos_num, tbtt_package_daily.unit) AS period,
                        tbtt_package_daily.p_type AS info_id,
                        tbtt_package_daily.p_name AS package,
                        tbtt_package_daily.unit_type,
                        'package_daily' AS 'pack_type'
                      FROM
                        tbtt_package_daily_user
                        LEFT JOIN tbtt_package_daily
                          ON tbtt_package_daily.id = tbtt_package_daily_user.package_id
                    ) AS a
                    LEFT JOIN tbtt_user ON tbtt_user.use_id = a.user_id
                     WHERE " . implode(' AND ', $where) . ' ' . $order;
	$query = $this->db->query($sql);

	/**
	 *   PAGINATION
	 */
	/* if ($this->pagination_enabled == TRUE) {
	  $config = array();
	  $config['cur_page'] = $page;
	  $config['total_rows'] = $this->db->count_all_results();
	  $config['base_url'] = $this->_link;
	  $config['uri_segment'] = 3;
	  $config['cur_tag_open'] = '<span class="current">';
	  $config['cur_tag_close'] = '</span>';
	  $config['per_page'] = $this->pagination_per_page;
	  $config['num_links'] = $this->pagination_num_links;
	  $config['suffix'] = $this->buildLink(array());
	  $this->load->library('pagination');
	  $this->pagination->initialize($config);
	  $this->pager = $this->pagination->create_links();
	  $this->num = $page;
	  $this->db->limit($config['per_page'], $page);
	  }

	  // Get the results
	  $query = $this->db->get(); */
	$temp_result = $query->result_array();

	//echo $this->db->last_query(); die;
	$this->db->flush_cache();
	return $temp_result;
    }

    public function getSumPackageUserStatistic($today = FALSE) {
	$this->db->select('SUM(real_amount) AS real_amount');
	$this->db->from('tbtt_package_user');

	if ($today) {
	    $this->db->where('DATE(`created_date`) = CURDATE()');
	}

	$query = $this->db->get();
	$result = $query->result();
	if ($result[0]->real_amount) {
	    return $result[0]->real_amount;
	} else {
	    return '0';
	}
    }

    public function getPackageUser($package_id = NULL) {
	$this->db->select('package_id,real_amount,created_date');
	$this->db->from('tbtt_package_user');

	if ($package_id) {
	    $this->db->where('package_id', $package_id);
	}
	$this->db->order_by('id', 'DESC');

	$query = $this->db->get();
	return $query->result();
    }

    // Get DV tạo đại lý Online 
    public function GetPackageValueshop($shop_userid) {
	$this->db->cache_off();
	$select = 'tbtt_package.info_id as id,
                  tbtt_package.month_price,
                  tbtt_service.name,
                  tbtt_service.limit,
                  tbtt_service.unit,
                  tbtt_service.desc,
                  tbtt_service.install,
                  tbtt_service.note,
                  tbtt_service.group,
                  tbtt_service.published';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'INNER');
	$this->db->join('tbtt_package_service', 'tbtt_package.info_id = tbtt_package_service.package_id', 'INNER');
	$this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id', 'INNER');
	$this->db->where('tbtt_package_user.user_id', $shop_userid);
	$this->db->where('tbtt_service.group', '18');
	$this->db->where('NOW() >= tbtt_package_user.begined_date', null);
	$this->db->where('(NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	$this->db->order_by('tbtt_package_user.id', 'DESC');
	$this->db->limit(1, 0);
	$query = $this->db->get();
	$temp_result = $query->row();
	$query->free_result();

	return $temp_result;
    }

    // Get DV tạo Azi-Branch
    public function getPackageAziBranch($shop_userid) {
	$this->db->cache_off();
	$select = 'tbtt_package.info_id as id,
                  tbtt_package.month_price,
                  tbtt_service.name,
                  tbtt_service.limit,
                  tbtt_service.unit,
                  tbtt_service.desc,
                  tbtt_service.install,
                  tbtt_service.note,
                  tbtt_service.group,
                  tbtt_service.published';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'INNER');
	$this->db->join('tbtt_package_service', 'tbtt_package.info_id = tbtt_package_service.package_id', 'INNER');
	$this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id', 'INNER');
	$this->db->where('tbtt_package_user.user_id', $shop_userid);
	$this->db->where('tbtt_service.group', '09');
	$this->db->where('tbtt_service.published = 1');
	$this->db->where('NOW() >= tbtt_package_user.begined_date', null);
	$this->db->where('(NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	$this->db->order_by('tbtt_package_user.id', 'DESC');
	$this->db->limit(1, 0);
	$query = $this->db->get();
	$temp_result = $query->row();
	$query->free_result();
	$this->db->flush_cache();
	return $temp_result;
    }

    // Get DV tạo Branch(Service use 1 time)
    public function getPackageCreateBranch($shop_id) {
	$this->db->cache_off();
	$select = 'tbtt_package.info_id as id,
                  tbtt_package.month_price,
                  tbtt_package_user.limited,
                  tbtt_service.name,
                  tbtt_service.limit,
                  tbtt_service.unit,
                  tbtt_service.desc,
                  tbtt_service.install,
                  tbtt_service.note,
                  tbtt_service.group,
                  tbtt_service.published';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'INNER');
	$this->db->join('tbtt_package_service', 'tbtt_package.id = tbtt_package_service.package_id', 'INNER');
	$this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id', 'INNER');
	$this->db->where('tbtt_package_user.user_id', $shop_id);
	$this->db->where('tbtt_package_user.payment_status', 1);
	$this->db->where('tbtt_service.group', '25');
	$this->db->where('tbtt_service.published = 1');
	$this->db->where('NOW() >= tbtt_package_user.begined_date', null);
	// $this->db->where('(NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	//$this->db->order_by('tbtt_package_user.id','DESC');
	//$this->db->limit(1, 0);
	$query = $this->db->get();
	$result = $query->result();
	$query->free_result();
	$this->db->flush_cache();
	return $result;
    }

    // Get DV tạo Branch(Service use 1 time)
    public function getPackageDomain($shop_id,$package_id = 0) {
	$this->db->cache_off();
	$select = 'tbtt_package.info_id as id,
                  tbtt_package.month_price,
                  tbtt_package_user.limited,
                  tbtt_service.name,
                  tbtt_service.limit,
                  tbtt_service.unit,
                  tbtt_service.desc,
                  tbtt_service.install,
                  tbtt_service.note,
                  tbtt_service.group,
                  tbtt_service.published';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'INNER');
	$this->db->join('tbtt_package_service', 'tbtt_package.id = tbtt_package_service.package_id', 'INNER');
	$this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id', 'INNER');
	$this->db->where('tbtt_package_user.user_id', $shop_id);
	if(isset($package_id) && $package_id != 0) {
		$this->db->where('tbtt_package_user.package_id', $package_id);
	}
	$this->db->where('tbtt_package_user.payment_status', 1);
	$this->db->where('tbtt_service.group', '30');
	$this->db->where('tbtt_service.published = 1');
	//$this->db->where('NOW() >= tbtt_package_user.begined_date', null);
	//$this->db->where('(NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	//$this->db->order_by('tbtt_package_user.id','DESC');
	//$this->db->limit(1, 0);
	$query = $this->db->get();
	$result = $query->result();
	$query->free_result();
	$this->db->flush_cache();
	return $result;
    }

    // Get DV tạo Branch(Service use 1 time)
    public function getPackageCreateCTVOnline($shop_id) {
	$this->db->cache_off();
	$select = 'tbtt_package.info_id as id,
                  tbtt_package.month_price,
                  tbtt_package_user.limited,
                  tbtt_service.name,
                  tbtt_service.limit,
                  tbtt_service.unit,
                  tbtt_service.desc,
                  tbtt_service.install,
                  tbtt_service.note,
                  tbtt_service.group,
                  tbtt_service.published';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'INNER');
	$this->db->join('tbtt_package_service', 'tbtt_package.id = tbtt_package_service.package_id', 'INNER');
	$this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id', 'INNER');
	$this->db->where('tbtt_package_user.user_id', $shop_id);
	$this->db->where('tbtt_service.group', '26');
	$this->db->where('tbtt_service.published = 1');
	$this->db->where('NOW() >= tbtt_package_user.begined_date', null);
	$this->db->where('NOW() <= tbtt_package_user.ended_date', null);
	$this->db->order_by('tbtt_package_user.id', 'DESC');
	$this->db->limit(1, 0);
	$query = $this->db->get();
	$result = $query->result();
	$query->free_result();
	$this->db->flush_cache();

	return $result;
    }

    //Get package latest
    function getPackageLatest($uid) {
	$this->db->cache_off();
	$select = 'tbtt_package_info.`name`,                   
                   tbtt_package_info.id,  
                   tbtt_package.`period`,
                   tbtt_package_user.status,
                   tbtt_package_user.`payment_status`,
                   tbtt_package_user.`created_date`,
                   tbtt_package_user.`begined_date`,
                   tbtt_package_user.`ended_date`';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id ');
	$this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id ');
	$this->db->where('tbtt_package_user.user_id', $uid);
	$this->db->where('NOW() >= tbtt_package_user.begined_date AND (NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	$this->db->order_by("tbtt_package_user.`created_date`", 'desc');
	$this->db->limit(1, 0);
	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->result_array();
	$this->db->flush_cache();
	return $temp_result;
    }

    function getPackageInfoLatest($uid) {
	$this->db->cache_off();
	$select = 'tbtt_package_info.`name`,                   
                   tbtt_package_info.id,  
                   tbtt_package.`period`,
                   tbtt_package_user.status,
                   tbtt_package_user.`payment_status`,
                   tbtt_package_user.`created_date`,
                   tbtt_package_user.`begined_date`,
                   tbtt_package_user.`ended_date`';
	$this->db->select($select);
	$this->db->from('tbtt_package_user');
	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id ');
	$this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id ');
	$this->db->where('tbtt_package_user.user_id', $uid);
	$this->db->where('tbtt_package.info_id >= ', 1);
	$this->db->where('tbtt_package.info_id <= ', 7);
	$this->db->where('NOW() >= tbtt_package_user.begined_date AND (NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);
	$this->db->order_by("tbtt_package_user.`created_date`", 'desc');
	$this->db->limit(1, 0);
	$query = $this->db->get();
	//echo $this->db->last_query();
	$temp_result = $query->row();
	$this->db->flush_cache();
	return $temp_result;
    }

    function getPackageByUserAffiliate($iUserId, $start = '', $end = '') {
    	$this->db->cache_off();
    	$select = 'tbtt_package.`period`,
                   tbtt_package_user.*,
                   tbtt_user.use_fullname,
                   tbtt_user.affiliate_level,
                   tbtt_user.parent_id as parent_id,
                   tbtt_user.use_id as use_id,
                   (SELECT
                          name
                        FROM
                          tbtt_package_info
                        WHERE id = tbtt_package.info_id) AS name,
                   ';
		$this->db->select($select);
    	$this->db->from('tbtt_package_user');
    	$this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id ');
    	$this->db->join('tbtt_user', 'tbtt_package_user.user_affiliate_id = tbtt_user.use_id ');
    	if(is_array($iUserId)) {
			$this->db->where_in('tbtt_package_user.user_affiliate_id', $iUserId);
    	}else {
    		$this->db->where('tbtt_package_user.user_affiliate_id = ', $iUserId);
    	}
    	$this->db->where('tbtt_package_user.payment_status = 1');
    	if($start !='' && $end != '') {
    		$this->db->where('tbtt_package_user.payment_date >= ', $start);
    		$this->db->where('tbtt_package_user.payment_date <= ', $end);
    	}
    	$query = $this->db->get();
    	$temp_result = $query->result();
		$this->db->flush_cache();
		return $temp_result;
    }

    function updateOrder($id, $payment_status) {
		$data = array(
		    'payment_status' => $payment_status,
		    'modified_date' => date('Y-m-d H:i:s')
		);
		$this->db->cache_off();
		$this->db->where('id', $id);
		$this->db->update('tbtt_package_user', $data);
		return $this->db->affected_rows();
    }

    function updateStatusOrder($code, $status) {
    	if (!empty($code)) 
    	{
    		$data = array(
			    'status' => $status,
			    'modified_date' => date('Y-m-d H:i:s')
			);
			$this->db->cache_off();
			$this->db->where('code', $code);
			$this->db->update('tbtt_package_user', $data);
			return $this->db->affected_rows();
    	}
    	return false;
    }
}