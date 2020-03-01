<?php
#****************************************#
# * @Author: icsc                   #
# * @Email: info@icsc.vn          #
# * @Website: http://www.icsc.vn  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Commission_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 10;
        $this->pagination_num_links = 5;
        $this->pager = '';
        $this->filter = array();
        $this->num = 0;
        $this->total = 0;
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_commission");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
	{
        $this->db->cache_off();
		$this->db->select($select);
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
		$query = $this->db->get("tbtt_commission");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
	{
		$this->db->cache_off();
		$this->db->select($select);
		if($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "")
		{
			$this->db->join($table_1, $on_1, $join_1);
		}
		if($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "")
		{
			$this->db->join($table_2, $on_2, $join_2);
		}
		if($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "")
		{
			$this->db->join($table_3, $on_3, $join_3);
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
		if($distinct && $distinct == true)
		{
			$this->db->distinct();
		}
		#Query
		$query = $this->db->get("tbtt_commission");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_commission", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_commission", $data);
	}

	function delete($value, $field = "id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_commission");
    }
    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }
    function getAdminSort()
    {
        $sortField = array('type', 'created_date', 'payment_status', 'commission');
        $data = array();
        foreach ($sortField as $item) {
            $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
            $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
        }
        return $data;
    }
    function setCurLink($link)
    {
        $this->_curLink = $link;
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

    function getCommissionList($where = array(), $page = FALSE)
    {
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'ordering';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;

        $this->filter['type'] = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
        if($this->filter['type'] != ''){
            $where['`type`'] = $this->filter['type'];
        }

        $this->filter['month'] = isset($_REQUEST['month']) ? trim($_REQUEST['month']) : date('m', strtotime('-1 month'));

        $this->filter['year'] = isset($_REQUEST['year']) ? trim($_REQUEST['year']) : date('Y');
        $where['commission_month'] = $this->filter['month'].'-'.$this->filter['year'];
        $where['commission > '] = 0;

        switch ($sort) {
            case 'type':
                $this->db->order_by("`type`", $dir);
                break;
            case 'created_date':
                $this->db->order_by("`created_date`", $dir);
                break;
            case 'payment_status':
                $this->db->order_by("`payment_status`", $dir);
                break;
            case 'commission':
                $this->db->order_by("`commission`", $dir);
                break;
        }
        $select = '*';
        $this->db->select($select);
        $this->db->from('tbtt_commission');
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
            $config['suffix'] = $this->buildLink(array());
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
        // Get total product
        $this->db->cache_off();
        $this->db->select("CAST( SUM(commission) AS DECIMAL (10, 2)) as totalAll", false);
        $this->db->where($where);
        $this->db->from('tbtt_commission');
        $query = $this->db->get();
        $total = $query->row_array();
        $this->total = $total['totalAll'];
        $this->db->flush_cache();
        return $temp_result;
    }
    function getTotal(){
        return $this->total;
    }
    function getCommissionType(){
        $this->db->cache_off();
        $this->db->select('*');
        $query = $this->db->get('tbtt_commission_type');
        return $query->result_array();

    }
}