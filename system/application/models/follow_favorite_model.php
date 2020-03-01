<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Follow_favorite_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table_user_follow = 'tbtt_user_follow';
        $this->table_follow_cate = 'tbtt_follow_category';
        $this->table_content_favorite = 'tbtt_content_favorite';
    }

    // ------------------------------------------------------------------------
    function add_user_follow($data)
    {
        return $this->db->insert($this->table_user_follow, $data);
    }

    function add_follow_cate($data)
    {
        return $this->db->insert_batch($this->table_follow_cate, $data);
    }

    function add_content_favorite($data)
    {
        return $this->db->insert($this->table_content_favorite, $data);
    }

    // ------------------------------------------------------------------------
    function update_user_follow($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_user_follow, $data);
    }

    function update_follow_cate($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_follow_cate, $data);
    }

    function update_content_favorite($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_content_favorite, $data);
    }

    // ------------------------------------------------------------------------
    function delete_user_follow($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_user_follow);
    }

    function delete_follow_cate($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_follow_cate);
    }

    function delete_content_favorite($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_content_favorite);
    }

    
    // ------------------------------------------------------------------------
    function get_user_follow($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_user_follow);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function get_follow_cate($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_follow_cate);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function get_content_favorite($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_content_favorite);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    // ------------------------------------------------------------------------
    function fetch_user_follow($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_user_follow);
        if ($where && $where != "") {
            $this->db->where($where, null, false);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_follow_cate($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_follow_cate);
        if ($where && $where != "") {
            $this->db->where($where, null, false);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }
    function fetch_content_favorite($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_content_favorite);
        if ($where && $where != "") {
            $this->db->where($where, null, false);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
            $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    // ------------------------------------------------------------------------
                                                    //array(array('table' => '', 'on' => '', 'option' => ''))
    function fetch_join($select = '*', $from = '', $where = '', $join = array(), $order = '', $by = 'DESC', $start = -1, $limit = 10)
    {
        $this->db->select($select);
        $this->db->from($from);
        if(!empty($join)) {
            foreach ($join as $key => $value) {
                $this->db->join($value['table'], $value['on'], $value['option']);
            }
        }
        if ($where && $where !== '') {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }
}

/* End of file Follow_favorite_model.php */

?>