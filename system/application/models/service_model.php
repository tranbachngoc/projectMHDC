<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/17/2015
 * Time: 8:31 AM
 */
class Service_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 20;
        $this->pagination_num_links = 5;
        $this->pager = '';
        $this->filter = array();
        $this->num = 0;
    }

    function setPagination_page($page)
    {
        $this->pagination_per_page = $page;
    }

    function setpaginationNum($num)
    {
        $this->pagination_num_links = $num;
    }

    function setCurLink($link)
    {
        $this->_curLink = $link;
    }

    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getPackage($where = array(), $page = FALSE, $select = '*')
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        if ($this->filter['q'] != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            $this->db->where("(tbtt_package_info.`name` LIKE  {$searchString}) ");
        }
        switch ($sort) {
            case 'id':
                $this->db->order_by("tbtt_package_info.`id`", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_package_info.`name`", $dir);
                break;
        }

        $this->db->select($select, false);
        $this->db->from('tbtt_package_info');
        $this->db->where($where);

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$this->filter['sort']}", "dir={$this->filter['dir']}"));
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
        $query->free_result();
        $this->db->flush_cache();

        return $temp_result;
    }

    function getAdminSort()
    {
        $sortField = array('id', 'name', 'period', 'month_price');
        $data = array();
        foreach ($sortField as $item) {
            $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
            $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
        }
        return $data;
    }

    function getFilter()
    {
        return $this->filter;
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

    function packageInfoUpdate($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tbtt_package_info', $data);
    }

    function getPackageInfo($select = "*", $where = "")
    {

        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }

        #Query
        $query = $this->db->get("tbtt_package_info");

        $result = $query->row();

        $query->free_result();
        return $result;
    }

    function getSimplePackageInfo($id)
    {
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
                  tbtt_service.published,
                  tbtt_service.image';
        $this->db->select($select);
        $this->db->from('tbtt_package');
        $this->db->join('tbtt_package_service', 'tbtt_package.id = tbtt_package_service.package_id ');
        $this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id');
        $this->db->where('tbtt_package.info_id', $id);
        $query = $this->db->get();
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    //By Bao Tran,
    function getPackageServiceByInfoID($userId, $id)
    {
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
        $this->db->where('tbtt_package_user.user_id', $userId);
        $this->db->where('tbtt_package_user.package_id', $id);
        $this->db->where('NOW() >= tbtt_package_user.begined_date AND (NOW() <= tbtt_package_user.ended_date OR tbtt_package_user.ended_date IS NULL)', null);        
        $this->db->where('tbtt_service.group', '05');
        $query = $this->db->get();
        //echo $this->db->last_query();        
        $temp_result = $query->row();
        $query->free_result();       

        return $temp_result;
    }

    function updatePackageInfo($data, $where = "", &$parrams)
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        $this->db->update("tbtt_package_info", $data);
        if(isset($parrams['info_id'])) {
            $where = '(SELECT
                      `tbtt_package_service`.`service_id`
                    FROM
                      `tbtt_package`
                      LEFT JOIN `tbtt_package_service`
                        ON `tbtt_package`.id = `tbtt_package_service`.`package_id`
                    WHERE `info_id` = ' . $parrams['info_id'] . '
                    LIMIT 0, 1)';
            $this->db->where('id = ' . $where, null);
            $this->db->update("tbtt_service", $data);
        }
       
        return true;
    }

    function addPackageInfo($data)
    {
        $this->db->insert("tbtt_package_info", $data);
        return $this->db->insert_id();
    }

    function getServiceList($where = array(), $page = FALSE)
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'ordering';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        if ($this->filter['q'] != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            $this->db->where("(tbtt_service.`name` LIKE  {$searchString}) ");
        }
        switch ($sort) {
            case 'ordering':
                $this->db->order_by("tbtt_package_service.`ordering`", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_package_info.`name`", $dir);
                break;
        }
        $select = '*';
        $this->db->select($select);
        $this->db->from('tbtt_package_service');
        $this->db->join('tbtt_service', 'tbtt_service.id = tbtt_package_service.service_id');
        $this->db->where($where);

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$this->filter['sort']}", "dir={$this->filter['dir']}"));
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
        $query->free_result();
        $this->db->flush_cache();

        return $temp_result;
    }

    function updateServiceInfo($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_service", $data);
    }

    function addServiceInfo($data)
    {
        $this->db->insert("tbtt_service", $data);
        return $this->db->insert_id();
    }

    function getPriceList($where = array(), $page = FALSE)
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'ordering';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        if ($this->filter['q'] != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            $this->db->where("(tbtt_package.`period` LIKE  {$searchString}) ");
        }
        switch ($sort) {
            case 'ordering':
                $this->db->order_by("tbtt_package.`ordering`", $dir);
                break;
            case 'period':
                $this->db->order_by("tbtt_package.`period`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_package.`month_price`", $dir);
                break;
        }
        $select = '*';
        $this->db->select($select);
        $this->db->from('tbtt_package');
        $this->db->where($where);

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$this->filter['sort']}", "dir={$this->filter['dir']}"));
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
        $query->free_result();
        $this->db->flush_cache();

        return $temp_result;
    }

    function updatePriceList($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_package", $data);
    }

    function getPriceListInfo($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_package");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function getPricePeriod()
    {
        return array(
            array('id' => '-1', 'text' => 'Không giới hạn'),
            array('id' => '1', 'text' => '1 Tháng'),
            array('id' => '3', 'text' => '3 Tháng'),
            array('id' => '6', 'text' => '6 Tháng'),
            array('id' => '12', 'text' => '12 Tháng')
        );
    }

    function getServiceGroup()
    {
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->where('published', 1);
        $this->db->where('type', 'package');
        #Query
        $query = $this->db->get("tbtt_service_group");

        $this->db->order_by("group", 'asc');
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }

    function getSimpleGroup()
    {
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->where('published', 1);
        $this->db->where('type', 'simple');
        #Query
        $query = $this->db->get("tbtt_service_group");

        $this->db->order_by("group", 'asc');
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }

    function updatePriceListInfo($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_package", $data);
    }

    function addPriceListInfo($data)
    {
        $this->db->insert("tbtt_package", $data);
        return $this->db->insert_id();
    }

    function getServiceData($select = "*", $where = "")
    {
        $this->db->start_cache();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_service");
        $result = $query->result_array();
        $query->free_result();
        $this->db->flush_cache();

        return $result;
    }

    function updatePackageService($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_package_service", $data);
    }

    function addPackageService($data)
    {
        return $this->db->insert("tbtt_package_service", $data);
    }

    function getPackageService($select = "*", $where = ""){
        $this->db->select($select);
        if($where && $where != "")
        {
            $this->db->where($where, NULL, false);
        }
        #Query
        $query = $this->db->get("tbtt_package_service");
        $result = $query->row_object();
        return $result;
    }

    function updateService($data, $where = "")
    {
        $this->db->cache_off();
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_service", $data);
    }

    function updateSimpleServiceStatus($data, $id)
    {
        $this->db->cache_off();
        // Update package info
        $this->db->where('id', $id);
        $this->db->update("tbtt_package_info", $data);

        // Update package
        $this->db->where('info_id', $id);
        return $this->db->update("tbtt_package", $data);

    }

    function updateServiceGroup($data, $where = "")
    {
        $this->db->cache_off();
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_service_group", $data);
    }

    function addService($data)
    {
        $this->db->cache_off();
        $this->db->insert("tbtt_service", $data);

        $serviceId = $this->db->insert_id();

        // add package info
        $simplePackage = array('`name`' => $data['name'], 'published' => 1, 'pType' => 'package');
        $this->db->insert("tbtt_package_info", $simplePackage);
        $packageInfoId = $this->db->insert_id();
        // Add package
        $package = array('info_id' => $packageInfoId, 'period' => -1, 'month_price' => $price, 'discount_rate' => 0, 'published' => 1, 'ordering' => 0);

        $this->db->insert("tbtt_package", $package);
        $packageId = $this->db->insert_id();

        // Add package service
        $pser = array('package_id' => $packageId, 'service_id' => $serviceId, 'ordering' => 0);
        $this->db->insert("tbtt_package_service", $pser);
        return $packageInfoId;
    }

    function addSimpleService($data, $price)
    {
        $this->db->cache_off();
        $this->db->insert("tbtt_service", $data);
        $serviceId = $this->db->insert_id();
        
        // add package info
        $simplePackage = array('`name`' => $data['name'], 'published' => 1, 'pType' => 'simple');
        $this->db->insert("tbtt_package_info", $simplePackage);
        $packageInfoId = $this->db->insert_id();
        // Add package
        $package = array('info_id' => $packageInfoId, 'period' => -1, 'month_price' => $price, 'discount_rate' => 0, 'published' => 1, 'ordering' => 0);

        $this->db->insert("tbtt_package", $package);
        $packageId = $this->db->insert_id();

        // Add package service
        $pser = array('package_id' => $packageId, 'service_id' => $serviceId, 'ordering' => 0);
        $this->db->insert("tbtt_package_service", $pser);
        return $packageInfoId;

    }

    function updateSimpleService($data, $parrams)
    {
        $this->db->cache_off();
        // Update package
        $package = array('month_price' => $parrams['price']);
        $this->db->where('info_id', $parrams['id']);
        $this->db->update("tbtt_package", $package);

        $where = '(SELECT
                      `tbtt_package_service`.`service_id`
                    FROM
                      `tbtt_package`
                      LEFT JOIN `tbtt_package_service`
                        ON `tbtt_package`.id = `tbtt_package_service`.`package_id`
                    WHERE `info_id` = ' . $parrams['id'] . '
                    LIMIT 0, 1)';
        $this->db->where('id = ' . $where, null);
        $this->db->update("tbtt_service", $data);
        //echo $this->db->last_query();

        //Update price
        return true;
    }

    function addServiceGroup($data)
    {
        $this->db->cache_off();
        $select = "IF (MAX(`group`) + 1 < 10, CONCAT('0', MAX(`group`) + 1), MAX(`group`) + 1) AS `group`";
        $this->db->select($select, false);
        $query = $this->db->get("tbtt_service_group");
        $result = $query->row_array();
        $query->free_result();

        foreach ($data as $k => $val) {
            unset($data[$k]);
            $data['`' . $k . '`'] = $val;
        }

        $data['`group`'] = $result['group'];
        $this->db->insert("tbtt_service_group", $data);
        return $this->db->insert_id();
    }

    function deletePackageService($where)
    {
        $this->db->cache_off();
        $this->db->where($where);
        return $this->db->delete('tbtt_package_service');
    }

    function getServiceInfo($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_service");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function getServiceGroupInfo($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_service_group");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function getService($where = array(), $page = FALSE)
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;

        $this->filter['dir'] = $dir;
        if ($this->filter['q'] != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            $this->db->where("(tbtt_service.`name` LIKE  {$searchString}) ");
        }
        switch ($sort) {
            case 'id':
                $this->db->order_by("tbtt_service.`id`", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_service.`name`", $dir);
                break;

        }
        $select = '*';
        $this->db->select($select);
        $this->db->from('tbtt_service');
        if (!empty($where)) {
            $this->db->where($where);
        }

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
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
        $query->free_result();

        return $temp_result;
    }

    function getServiceGroupList($where = array(), $page = FALSE)
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;

        $this->filter['dir'] = $dir;
        if ($this->filter['q'] != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            $this->db->where("(tbtt_service_group.`text` LIKE  {$searchString}) ");
        }
        switch ($sort) {
            case 'id':
                $this->db->order_by("tbtt_service_group.`id`", $dir);
                break;
            case 'name':
                $this->db->order_by("tbtt_service_group.`text`", $dir);
                break;

        }
        $select = ' tbtt_content.not_title ,
                    tbtt_service_group.id,
                    tbtt_service_group.type,
                    tbtt_service_group.group,
                    tbtt_service_group.text,
                    tbtt_service_group.published,
                    tbtt_service_group.content_id';
        $this->db->select($select);
        $this->db->from('tbtt_service_group');
        $this->db->join('tbtt_content', 'tbtt_content.not_id = tbtt_service_group.content_id', 'left');
        if (!empty($where)) {
            $this->db->where($where);
        }

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
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
        $query->free_result();

        return $temp_result;
    }

}
