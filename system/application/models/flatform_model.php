<?php
#****************************************#
# * @Author: tranbao                     #
# * @Email: tranbaothe@gmail.com         #
# * @Website: http://azibai.com          #
# * @Copyright: 28-03-2018               #
#****************************************#
class Flatform_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table_name = "tbtt_flatform";
    }

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }        
        $query = $this->db->get($this->table_name);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "fl_id", $by = "DESC", $start = -1, $limit = 0)
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
        $query = $this->db->get("tbtt_group_trade");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);

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
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        }
        #Query
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join1($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "fl_id", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
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
        if ($where && $where != "") {
            $this->db->where($where);
            $this->db->group_by();
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {

            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        };
        #Query
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function add($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        return $this->db->insert_id();
    }

    function update($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_name, $data);
    }

    function delete($value, $field = "fl_id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_name);
    }
    
}