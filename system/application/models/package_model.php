<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/8/2015
 * Time: 11:01 AM
 */
class Package_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function getPackage(){
        $this->db->cache_off();
        $this->db->select('`id`,`name`,`desc`');
        $this->db->from('tbtt_package_info');
        $this->db->where('published', 1);
        $this->db->where('pType', 'package');


        $this->db->where('id >=', 1);
        $this->db->where('id <=', 7);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getSimplePackageNew($use_group = 0){
        $this->db->cache_off();
        $select = "*,
        tbtt_package_info.`name`,
        tbtt_package.*,
        (
            SELECT
              tbtt_service_group.content_id          
            FROM
              tbtt_package_service
              LEFT JOIN tbtt_service
                ON tbtt_service.id = tbtt_package_service.service_id
              LEFT JOIN tbtt_service_group
                ON tbtt_service_group.group = tbtt_service.group
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as content_id,
        (
            SELECT
              tbtt_service.limit    
            FROM
              tbtt_service              
              JOIN tbtt_package_service
                ON tbtt_package_service.service_id = tbtt_service.id
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as limits,
        (
            SELECT
              tbtt_service.unit      
            FROM
              tbtt_service              
              JOIN tbtt_package_service
                ON tbtt_package_service.service_id = tbtt_service.id
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as units
        ";
        $this->db->select($select, false);
        $this->db->from('tbtt_package_show');
        $this->db->join('tbtt_package', 'tbtt_package_show.service_id = tbtt_package.id');
        $this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id');
        // $this->db->where('tbtt_package_info.pType', 'simple' );
        $this->db->where('tbtt_package_info.published', 1);
        $this->db->where('tbtt_package.published', 1);
        $this->db->where('tbtt_package_show.group_id', $use_group);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getSimplePackage(){
        $this->db->cache_off();
        $select = "
        tbtt_package_info.`name`,
        tbtt_package.*,
        (
            SELECT
              tbtt_service_group.content_id          
            FROM
              tbtt_package_service
              LEFT JOIN tbtt_service
                ON tbtt_service.id = tbtt_package_service.service_id
              LEFT JOIN tbtt_service_group
                ON tbtt_service_group.group = tbtt_service.group
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as content_id,
        (
            SELECT
              tbtt_service.limit    
            FROM
              tbtt_service              
              JOIN tbtt_package_service
                ON tbtt_package_service.service_id = tbtt_service.id
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as limits,
        (
            SELECT
              tbtt_service.unit      
            FROM
              tbtt_service              
              JOIN tbtt_package_service
                ON tbtt_package_service.service_id = tbtt_service.id
            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
        ) as units
        ";
        $this->db->select($select, false);
        $this->db->from('tbtt_package');
        $this->db->join('tbtt_package_info', 'tbtt_package.info_id = tbtt_package_info.id');
        $this->db->where('tbtt_package_info.pType', 'simple' );
        $this->db->where('tbtt_package_info.published', 1);
        $this->db->where('tbtt_package.published', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getService(){
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from('tbtt_package_service');
        $this->db->join('tbtt_package', 'tbtt_package_service.package_id = tbtt_package.id');
        $this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id');
        $this->db->where('tbtt_package.published', 1);
        $this->db->where('tbtt_service.published', 1);
        $this->db->order_by("tbtt_service.`group`", "asc");
        $this->db->order_by("tbtt_package_service.`ordering`", "asc");
        $query = $this->db->get();

        $data = array();
        foreach($query->result_array() as $row){
            if(!isset($data[$row['group']])){
                $data[$row['group']] = array('name'=>$row['name'], 'service'=>array());
            }
            array_push($data[$row['group']]['service'], $row);
        }
        //echo $this->db->last_query();
        $query->free_result();
        return $data;
    }

    function getServiceList(){
        $this->db->cache_off();
        $this->db->select('tbtt_service.`name`,
                                tbtt_service.`group`,
                                (SELECT `content_id` FROM `tbtt_service_group` WHERE `group` = tbtt_service.`group`) as content_id,
                                tbtt_service.`limit`,
                                tbtt_service.`unit`,
                                GROUP_CONCAT(tbtt_package_service.`package_id`) AS packageList', false);
        $this->db->from('tbtt_package_service');
        $this->db->join('tbtt_package', 'tbtt_package_service.package_id = tbtt_package.id');
        $this->db->join('tbtt_service', 'tbtt_package_service.service_id = tbtt_service.id');
        $this->db->where('tbtt_package.published', 1);
        $this->db->where('tbtt_service.published', 1);
        $this->db->where('tbtt_package.info_id >= ', 1);
        $this->db->where('tbtt_package.info_id <= ', 7);
        $this->db->group_by('tbtt_package_service.service_id');
        $this->db->order_by("tbtt_service.`group`", "asc");
        $query = $this->db->get();

        $data = array();
        foreach($query->result_array() as $row){
            $row['packageList'] = explode(',', $row['packageList']);
            if(!isset($data[$row['group']])){
                $data[$row['group']] = array('name'=>$row['name'], 'service'=>array(), 'content_id'=>$row['content_id']);
            }
            array_push($data[$row['group']]['service'], $row);
        }
        //echo $this->db->last_query();

        $query->free_result();
        return $data;
    }

    function getPackagePrice(){
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from('tbtt_package');
        $this->db->order_by("tbtt_package.`period`", "asc");
        $query = $this->db->get();
        $data = $query->result_array();
        $query->free_result();
        return $data;
    }

    function getMaxUsedPackage($uid){
        $this->db->cache_off();
        $this->db->select('(SELECT 
                                p.`info_id`
                              FROM
                                `tbtt_package` AS p
                              LEFT JOIN tbtt_package_info as pi
                                 ON pi.id = p.info_id
                              WHERE p.`id` = MAX(`package_id`) AND pi.pType = "package") AS maxUse ');
        $this->db->from('tbtt_package_user');
        $this->db->where('`status` <>', 9);
        $this->db->where('user_id', $uid);
        $this->db->where('(ended_date IS NULL OR ended_date < NOW())', null);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

    function getAvailableDate($uid)
    {
        $this->db->cache_off();
        $sql = "SELECT
                  DATE_FORMAT(pack.begin_date, '%d/%m/%Y') AS begin_date,
                  DATE_FORMAT(
                    DATE_ADD(pack.begin_date, INTERVAL 1 MONTH),
                    '%d/%m/%Y'
                  ) AS month_1,
                  DATE_FORMAT(
                    DATE_ADD(pack.begin_date, INTERVAL 3 MONTH),
                    '%d/%m/%Y'
                  ) AS month_3,
                  DATE_FORMAT(
                    DATE_ADD(pack.begin_date, INTERVAL 6 MONTH),
                    '%d/%m/%Y'
                  ) AS month_6,
                  DATE_FORMAT(
                    DATE_ADD(
                      pack.begin_date,
                      INTERVAL 12 MONTH
                    ),
                    '%d/%m/%Y'
                  ) AS month_12,
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
        /*$this->db->select('IF(
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
                          ', false);
        $this->db->from('tbtt_package_user');
        $this->db->join('tbtt_package', 'tbtt_package_user.package_id = tbtt_package.id', 'left');
        $where = array();
        $where['tbtt_package_user.user_id'] = $uid;
        $where['tbtt_package_user.payment_status'] = 1;
        $where['tbtt_package_user.status'] = 1;
        $where['tbtt_package.info_id >='] = 2;
        $where['tbtt_package.info_id <='] = 7;
        $this->db->where($where);*/
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    function checkFreePackage($uid){
        $sql = " SELECT
                          COUNT(*) AS num
                        FROM
                          `tbtt_package_user`
                        WHERE `package_id` = 1
                          AND `user_id` = {$uid}";
        $result = $this->db->query($sql);
        return $result->row()->num;
    }

    function get_list($filter)
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        $this->db->order_by("ordering", "asc");
        #Query
        $query = $this->db->get("tbtt_package");
        $result = $query->result_array();
        $query->free_result();
        return $result;
    }

    function get_one($filter)
    {
        $this->db->cache_off();
        if(isset($filter['select'])){
            $this->db->select($filter['select']);
        }else {
            $select = 'tbtt_package.*,tbtt_package_info.name,tbtt_package_info.desc,tbtt_package_info.published,tbtt_package_info.pType,(
                    SELECT
                      tbtt_service.limit    
                    FROM
                      tbtt_service              
                      JOIN tbtt_package_service
                        ON tbtt_package_service.service_id = tbtt_service.id
                    WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
                ) as limits,
                (
                    SELECT
                      tbtt_service.unit      
                    FROM
                      tbtt_service              
                      JOIN tbtt_package_service
                        ON tbtt_package_service.service_id = tbtt_service.id
                    WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
                ) as units';
            $this->db->select($select);
        }
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        $this->db->order_by("ordering", "asc");
        $this->db->join('tbtt_package_info', 'tbtt_package_info.id = tbtt_package.info_id');
        #Query
        $query = $this->db->get("tbtt_package");

        $result = $query->row_array();
        $query->free_result();
        return $result;
    }

}