<?php
#****************************************#
# * @Author: icsc                   #
# * @Email: info@icsc.vn          #
# * @Website: http://www.icsc.vn  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Newsletter_model extends CI_Model
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
	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where);
		}
		#Query
		$query = $this->db->get("tbtt_newsletter");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "new_id", $by = "DESC", $start = -1, $limit = 0)
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
		$query = $this->db->get("tbtt_newsletter");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_newsletter", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_newsletter", $data);
	}

	function delete($value, $field = "new_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_newsletter");
    }

    #fun db
    function getLits($filter = array())
    {

        $this->db->cache_off();

        $this->db->select($filter['select'], false);
        $this->db->from('tbtt_newsletter');
        if(isset($filter['where'])){
            $this->db->where($filter['where']);
        }
        if(isset($filter['like'])){
            foreach($filter['like'] as $key=>$val){
                $this->db->like($key, $val);
            }
        }
        if(isset($filter['where_in'])){
            foreach($filter['where_in'] as $key=>$val){
                $this->db->where_in($key, $val);
            }
        }
        if(isset($filter['where_not_in'])){
            foreach($filter['where_not_in'] as $key=>$val){
                $this->db->where_not_in($key, $val);
            }
        }
        if(isset($filter['join'])){
            $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
        }

        if(isset($filter['group_by'])){
            $this->db->group_by($filter['group_by']);
        }


        if(isset($filter['order_by'])){
            $this->db->order_by($filter['order_by']);
        }
        if ($this->pagination_enabled == TRUE) {
            $this->db->limit($this->pagination_per_page, $filter['page']);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query();
        $temp_result = $query->result_array();
        $query->free_result();


        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $this->db->select('COUNT(*) AS total');
            $this->db->from('tbtt_newsletter');
            if(isset($filter['where'])){
                $this->db->where($filter['where']);
            }
            if(isset($filter['like'])){
                foreach($filter['like'] as $key=>$val){
                    $this->db->like($key, $val);
                }
            }
            if(isset($filter['where_in'])){
                foreach($filter['where_in'] as $key=>$val){
                    $this->db->where_in($key, $val);
                }
            }
            if(isset($filter['where_not_in'])){
                foreach($filter['where_not_in'] as $key=>$val){
                    $this->db->where_not_in($key, $val);
                }
            }
            if(isset($filter['join'])){
                $this->db->join($filter['join'][0], $filter['join'][1], $filter['join'][2]);
            }

            if(isset($filter['group_by'])){
                $this->db->group_by($filter['group_by']);
            }

            $query = $this->db->get();
            $total = $query->num_rows();

            $config = array();
            $config['cur_page'] = $filter['page'];
            $config['total_rows'] = $total;
            $config['base_url'] = $filter['link'];
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $filter['sufix'];
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
        }


        return $temp_result;
    }
    
}