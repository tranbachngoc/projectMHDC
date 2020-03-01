<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/1/2015
 * Time: 10:52 AM
 */
class Af_commision_model extends CI_Model
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

        $this->filter = array('status' => '', 'df' => '', 'dt' => '', 'type'=>'');

        $this->_link = array(
            'statistic' => 'account/affiliate/statistic'
        );

        /**
         *    bool $this->raw_data
         *    Used to decide what data should the SQL queries retrieve if tables are joined
         *     - TRUE:  just the field names of the items table
         *     - FALSE: related fields are replaced with the forign tables values
         *    Triggered to TRUE in the controller/edit method
         */

    }

    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getSort()
    {
        return array(
            array('id' => 1, 'text' => 'Ngày đặt hàng: cũ->mới', 'link' => $this->buildLink(array('sort=date', 'dir=asc'))),
            array('id' => 1, 'text' => 'Ngày đặt hàng: mới->cũ', 'link' => $this->buildLink(array('sort=date', 'dir=desc'))),
            array('id' => 1, 'text' => 'Giá: từ cao tới thấp', 'link' => $this->buildLink(array('sort=price', 'dir=desc'))),
            array('id' => 2, 'text' => 'Giá: từ thấp tới cao', 'link' => $this->buildLink(array('sort=price', 'dir=asc')))
        );

    }

    function buildLink($parrams)
    {
        if (@$this->filter['pf'] > 0 || @$this->filter['pt'] > 0) {
            array_unshift($parrams, 'price=' . $this->filter['pf'] . '-' . $this->filter['pt']);
        }
        if (@$this->filter['type'] > 0) {
            array_unshift($parrams, 'type=' . $this->filter['type']);
        }
        if (@$this->filter['df'] > 0) {
            array_unshift($parrams, 'df=' . $this->filter['df']);
        }
        if (@$this->filter['dt'] > 0) {
            array_unshift($parrams, 'dt=' . $this->filter['dt']);
        }
        if (@$this->filter['cat'] > 0) {
            array_unshift($parrams, 'cat=' . $this->filter['cat']);
        }
        if (@$this->filter['q'] != '') {
            array_unshift($parrams, 'q=' . $this->filter['q']);
        }
        return '?' . implode('&', $parrams);
    }

    function getRoute($var)
    {
        return $this->_link[$var];
    }

    function getFilter()
    {
        return $this->filter;
    }

    function getList($where = array(), $page = FALSE)
    {
        $this->db->start_cache();

        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'date';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        // Filter date
        $this->filter['df'] = isset($_REQUEST['df']) ? $_REQUEST['df'] : '';
        $this->filter['dt'] = isset($_REQUEST['dt']) ? $_REQUEST['dt'] : '';
        $this->filter['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';


        //Filter type
        if($this->filter['type'] != ''){
            $where['tbtt_commission.type'] = $this->filter['type'];
        }


        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
        if ($status != '') {
            $this->filter['status'] = $status;
            $where['tbtt_commission.status'] = $status;
        }

        if($status == 1){
            if ($this->filter['df'] != '') {
                $where['DATE(tbtt_commission.payment_date) >= '] = $this->filter['df'];
            }
            if ($this->filter['dt'] != '') {
                $where['DATE(tbtt_commission.payment_date) <= '] = $this->filter['dt'];
            }
        }else{
            if ($this->filter['df'] != '') {
                $where['DATE(tbtt_commission.created_date) >= '] = $this->filter['df'];
            }
            if ($this->filter['dt'] != '') {
                $where['DATE(tbtt_commission.created_date) <= '] = $this->filter['dt'];
            }
        }


        switch ($sort) {
            case 'creatdate':
                $this->db->order_by("tbtt_commission.created_date", $dir);
                break;
            case 'payment_date':
                $this->db->order_by("tbtt_commission.created_date", $dir);
                break;
            case 'amount':
                $this->db->order_by("tbtt_commission.`commission`", $dir);
                break;
            case 'status':
                $this->db->order_by("tbtt_commission.`status`", $dir);
                break;
        }


        //his->db->where('tbtt_order_detail.lastStatus <>', '05');
        $select = '   tbtt_commission.`commission`
                    , tbtt_commission.`type`
                    , tbtt_commission.`description`
                    ,DATE_FORMAT(tbtt_commission.created_date,"%d-%m-%Y") as created_date
                    ,DATE_FORMAT(tbtt_commission.payment_date,"%d-%m-%Y") as payment_date
                    , tbtt_commission.`status`';


        $this->db->select($select, false);
        $this->db->from('tbtt_commission');
        $this->db->where($where);

        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_link['statistic'];
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result = $query->result_array();
        foreach($temp_result as &$item){
            if($item['status'] == 0){
                $item['status'] = "Chưa thanh toán";
            }else{
                $item['status'] = "Đã thanh toán";
            }
            if($this->filter['status'] == 1){
                $item['created_date'] = $item['payment_date'];
            }
        }
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }
    function getStatus()
    {
        return array(array('id'=>0, 'text'=>'Chưa thanh toán'), array('id'=>1, 'text'=>'Đã thanh toán'));

    }
    function getType()
    {
        $where = array();
        //   $where['cat_level'] = 0;
        $this->db->start_cache();
        $this->db->select('id, text');
        $this->db->from('tbtt_commission_type');
        $this->db->where($where);
        $this->db->order_by("id", "asc");
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result = $query->result_array();
        $this->db->flush_cache();
        return $temp_result;
    }
    function getAdminSort(){
        $sortField = array('amount', 'creatdate', 'paydate', 'status');
        $data = array();
        foreach($sortField as $item){
            $data[$item]['asc'] = $this->buildLink(array('sort='.$item, 'dir=asc'));
            $data[$item]['desc'] = $this->buildLink(array('sort='.$item, 'dir=desc'));
        }
        return $data;
    }
}