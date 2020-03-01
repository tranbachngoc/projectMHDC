<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/8/2015
 * Time: 15:19 PM
 */
class Package_daily_user_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();

        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 10;
        $this->pagination_num_links = 5;
        $this->pager = '';
        $this->num = 0;

        $this->filter = array('st' => '', 'pt' => '', 'q' => '', 'df' => '', 'dt' => '');

        $this->_link = '';
    }

    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getSort()
    {
        return array(
            array('id' => 1, 'text' => 'Tăng dần', 'link' => $this->buildLink(array('dir=asc'))),
            array('id' => 1, 'text' => 'Giảm dần', 'link' => $this->buildLink(array('dir=desc')))
        );

    }

    function buildLink($parrams, $issort = false)
    {
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

    function getFilter()
    {
        return $this->filter;
    }

    function setLink($var)
    {
        $this->_link = $var;
    }

    function getLink()
    {
        return $this->_link;
    }


    function lister($where = array(), $page = FALSE)
    {

        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'created_date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
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


        $this->db->flush_cache();
        return $temp_result;
    }

    function getPackage()
    {
        $this->db->select('*');
        $this->db->from('tbtt_package_info');
        $this->db->order_by("tbtt_package_info.`id`", "asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    function getPeriod()
    {
        return array(
            array('id' => 3, 'name' => '3 Tháng'),
            array('id' => 6, 'name' => '6 Tháng'),
            array('id' => 12, 'name' => '12 Tháng')
        );
    }

    function getSortDate()
    {
        return array(
            array('id' => 'created_date', 'name' => 'Ngày tạo'),
            array('id' => 'begined_date', 'name' => 'Ngày bắt đầu'),
            array('id' => 'ended_date', 'name' => 'Ngày kết thúc'),
            array('id' => 'payment_date', 'name' => 'Ngày xác nhận thanh toán')
        );
    }

    function getAdminSort()
    {
        $sortField = array('id', 'name', 'period', 'month_price', 'user', 'created_date');
        $data = array();
        foreach ($sortField as $item) {
            $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
            $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
        }
        return $data;
    }

    function getServiceStatus()
    {
        return array(
            array('id' => '01', 'name' => 'Dịch vụ đang yêu cầu'),
            array('id' => '02', 'name' => 'Dịch vụ đã thanh toán'),
            array('id' => '03', 'name' => 'Dịch vụ đang sử dụng'),
            array('id' => '04', 'name' => 'Dịch vụ sắp hết hạn'),
            array('id' => '05', 'name' => 'Dịch vụ hết hạn'),
            array('id' => '06', 'name' => 'Dịch vụ bị hủy'),
        );
    }

    function completePayment($id)
    {
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

    function cancelOrder($id)
    {
        $data = array(
            'status' => 9,
            'modified_date' => date('Y-m-d H:i:s')
        );
        $this->db->cache_off();
        $this->db->where('id', $id);
        $this->db->update('tbtt_package_user', $data);
        return $this->db->affected_rows();
    }

    function startService($id)
    {
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

    function getWallet($uid)
    {
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

    function getPackAmount($package)
    {
        $this->db->cache_off();
        $sql = "SELECT
                  IF (
                    discount_rate > 0,
                    ABS(
                      `month_price` * `period` * (100 - `discount_rate`) / 100
                    ),
                    ABS(`month_price` * `period`)
                  )  AS request_amt, period, info_id
                FROM
                  `tbtt_package`
                WHERE id = {$package}";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    function getPackageNme($pack_id){
        $this->db->select('p_name');
        $this->db->from('tbtt_package_daily');
        $this->db->where('id', $pack_id);
        return $this->db->get()->row->p_name;
    }
    function addPackage($uid, $package, $regisdate, $amount_request, $pos_num, $content_type, $p_type= '', $position, $package_name, $pid = 0)
    {

        $amount = $this->getWallet($uid);
        $date = date('Y-m-d H:i:s');
        $this->load->model('user_model');
        $userObject = $this->user_model->get("parent_id, use_group", "use_id = " . $uid);

        /*if ($amount_request > $amount['amount_money'] + $amount['amount_point']) {
            return array('error' => true, 'message' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ. Click <a class="link_popup" href="'.base_url().'account/addWallet">vào đây</a> để nạp tiền!');
        }*/

        //$package_name = $this->getPackageNme($package);
        // Tru tien
        $use_money = 0;
        $use_point = 0;
        if ($amount['amount_point'] > 0 && $amount['amount_point'] >= $amount_request['request_amt']) {
            $use_point = $amount_request;
        } else {
            $use_point = $amount['amount_point'];
            $use_money = $amount_request - $use_point;
        }

        if ($use_point > 0) {
            $data = array();
            $data['user_id'] = $uid;
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_point;
            $data['`type`'] = '2';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $this->db->insert('tbtt_wallet', $data);
        }
        if ($use_money > 0) {
            $data = array();
            $data['user_id'] = $uid;
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_money;
            $data['`type`'] = '1';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $this->db->insert('tbtt_wallet', $data);
        }
        // Dang ky goi moi
        $data = array();
        $data['package_id'] = $package;
        $data['user_id'] = $uid;
        $data['sponser_id'] = $userObject->parent_id;
        $data['created_date'] = $date;
        $data['begined_date'] = $regisdate;
        $regisdate_tt = strtotime($regisdate);
        $ended_date = date("Y-m-d",$regisdate_tt).' 23:59:00';
        $data['ended_date'] = $ended_date;
        $data['payment_status'] = 1;
        $data['payment_date'] = $date;
        $data['status'] = 1;
        $data['amount'] = $amount_request;
        $data['real_amount'] = $amount_request;
        $data['pos_num'] = $pos_num;
        $data['content_type'] = $content_type;
        $data['p_type'] = $p_type;
        $data['`position`'] = $position;
        $this->db->insert('tbtt_package_daily_user', $data);
        if($pid > 0){
            $orderId = $this->db->insert_id();
            $data = array(
                "order_id" => $orderId,
                "content_id" => $pid,
                "begin_date" => $regisdate,
                "pos_num" => $pos_num,
                "p_type" => $p_type,
                "content_type" => $content_type
            );
            $this->db->insert('tbtt_package_daily_content', $data);
        }
        /*return array('error' => false, 'message' => 'Thành công');*/
    }

    function getAvailableDate($uid, $period)
    {
        $this->db->cache_off();
        $sql = "SELECT
                  NOW() AS begin_date,
                  DATE_ADD(NOW(), INTERVAL {$period} MONTH) AS ended_date
                ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    function getShelfEndDate(){
        $sql = "SELECT DATE_ADD(NOW(), INTERVAL 1 MONTH) AS ended_date";
        return $this->db->query($sql)->row()->ended_date();
    }
    function addShelfPackage($uid, $package, $amount_request, $period, $content_num, $content_type, $p_type= '', $package_name)
    {

        $amount = $this->getWallet($uid);
        $date = date('Y-m-d H:i:s');
        $this->load->model('user_model');
        $userObject = $this->user_model->get("parent_id, use_group", "use_id = " . $uid);

        if ($amount_request > $amount['amount_money'] + $amount['amount_point']) {
            return array('error' => true, 'message' => 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ. Click <a class="link_popup" href="'.base_url().'account/addWallet">vào đây</a> để nạp tiền!');
        }


        // Tru tien
        $use_money = 0;
        $use_point = 0;
        if ($amount['amount_point'] > 0 && $amount['amount_point'] >= $amount_request['request_amt']) {
            $use_point = $amount_request;
        } else {
            $use_point = $amount['amount_point'];
            $use_money = $amount_request - $use_point;
        }

        if ($use_point > 0) {
            $data = array();
            $data['user_id'] = $uid;
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_point;
            $data['`type`'] = '2';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $this->db->insert('tbtt_wallet', $data);
        }
        if ($use_money > 0) {
            $data = array();
            $data['user_id'] = $uid;
            $data['group_id'] = $userObject->use_group;
            $data['parent_id'] = $userObject->parent_id;
            $data['amount'] = 0 - $use_money;
            $data['`type`'] = '1';
            $data['description'] = 'Mua gói ' . $package_name;
            $data['created_date'] = $date;
            $data['month_year'] = date('m-Y');
            $data['`status`'] = '0';
            $this->db->insert('tbtt_wallet', $data);
        }
        $pack_date = $this->getAvailableDate($uid, $period);
        // Dang ky goi moi
        $data = array();
        $data['package_id'] = $package;
        $data['user_id'] = $uid;
        $data['sponser_id'] = $userObject->parent_id;
        $data['created_date'] = $date;
        $data['ended_date'] = $pack_date['ended_date'];
        $data['begined_date'] = $pack_date['begin_date'];
        $data['payment_status'] = 1;
        $data['payment_date'] = $date;
        $data['status'] = 1;
        $data['amount'] = $amount_request;
        $data['real_amount'] = $amount_request;
        $data['pos_num'] = $period;
        $data['content_num'] = $content_num;
        $data['content_type'] = $content_type;
        $data['p_type'] = $p_type;
        $this->db->insert('tbtt_package_daily_user', $data);
        return array('error' => false, 'message' => 'Thành công');
    }


    function getPackageId($where)
    {
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

    function getSubservice($id, $where = array())
    {
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

    function updateUserService($data, $where)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->update("tbtt_package_user_service", $data);
        return $this->db->affected_rows();
    }

    function getUserPackage($uid)
    {
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

    function getUserList($where = array(), $page = FALSE)
    {

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

    function getPackageList()
    {
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

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_package_daily_user");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get("tbtt_package_daily_user");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $where = "", $order = "tbtt_package_daily_user.id", $by = "DESC", $start = -1, $limit = 0, $group_by = NULL)
    {
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
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }
        #Query
        $query = $this->db->get("tbtt_package_daily_user");
        $result = $query->result();
        $query->free_result();
        
        return $result;
    }

    /* function fetch_join($select = "*", $join_1, $table_1, $on_1, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
     {
         $this->db->cache_off();
         $this->db->select($select);
         if($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "")
         {
             $this->db->join($table_1, $on_1, $join_1);
         }
         if($where && $where != "")
         {
             $this->db->where($where);
         }
         if($order && $order != "" && $by && ($by == "DESC" || $by == "ASC"))
         {
             $this->db->order_by($order, $by);
         }
         if((int)$start >= 0 && $limit && (int)$limit > 0)
         {
             $this->db->limit($limit, $start);
         }
         #Query
         $query = $this->db->get("tbtt_package_user");
         $result = $query->result();
         $query->free_result();
         return $result;
     }
     */
    function get_max_pos_num($date, $pack_id, $position)
    {
        $sql = "SELECT
                  IF(
                    MAX(`pos_num`) IS NULL,
                    1,
                    MAX(`pos_num`) + 1
                  ) AS max_num
                FROM
                  `tbtt_package_daily_user`
                WHERE `package_id` = {$pack_id}
                  AND `position` = '{$position}'
                  AND DATE_FORMAT(`begined_date`, '%Y-%m-%d') = " . $this->db->escape($date);
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    /* Lấy tổng số kệ hàng  */
    function getTotalAfCate($userId){
        $query = "SELECT SUM(content_num) AS total FROM `tbtt_package_daily_user` where p_type = 09 AND begined_date < NOW() AND NOW() < ended_date AND user_id = ".$userId;
        $return = $this->db->query($query);
        return $return->result_array();
    }
    /* thêm ngày cập nhật */
    function updateModifiedDate($id){
        $where['id'] = $id;
        $data['modified_date'] =  date("Y-m-d H:i:s");
        $this->db->where($where);
        $return = $this->db->update('tbtt_package_daily_user',$data);
        return $return;
    }
    
    public function getSumPackageDailyUserStatistic($today=FALSE){
        $this->db->select('SUM(real_amount) AS real_amount');
        $this->db->from('tbtt_package_daily_user');
        
        if($today){
            $this->db->where('DATE(`created_date`) = CURDATE()');
        }
        
        $query = $this->db->get();
        $result = $query->result();
        if($result[0]->real_amount){
            return $result[0]->real_amount;
        } else {
            return '0';
        }
    }
}