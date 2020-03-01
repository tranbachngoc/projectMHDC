<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Collection_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table                    = "tbtt_collection";
        $this->select                   = "*";
        $this->table_collection         = 'tbtt_collection';
        $this->table_collection_content = 'tbtt_collection_content';
        $this->table_collection_link    = 'tbtt_collection_link';
        $this->table_collection_product = 'tbtt_collection_product';
    }


    function add_c($data)
    {
        return $this->db->insert($this->table_collection, $data);
    }

    function add_cc($data)
    {
        return $this->db->insert($this->table_collection_content, $data);
    }

    function add_cl($data)
    {
        return $this->db->insert($this->table_collection_link, $data);
    }

    function update_c($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_collection, $data);
    }

    function update_cc($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_collection_content, $data);
    }

    function update_cl($data, $where = "")
    {
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update($this->table_collection_link, $data);
    }

    function delete_c($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_collection);
    }

    function delete_cc($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_collection_content);
    }

    function delete_cl($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_collection_link);
    }

    function delete_cp($value, $field = "id", $in = true)
    {
        if ($in == true) {
            $this->db->where_in($field, $value);
        } else {
            $this->db->where($field, $value);
        }
        return $this->db->delete($this->table_collection_product);
    }

    function get_c($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_collection);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function get_cc($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_collection_content);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function get_cl($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_collection_link);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function get_cp($select = '*', $where = '')
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != '') {
            $this->db->where($where);
        }
		#Query
        $query = $this->db->get($this->table_collection_product);
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch_c($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_collection);
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
            // $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_cc($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_collection_content);
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
            // $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_cl($select = '*', $where = '', $order = 'id', $by = 'DESC', $start = -1, $limit = 10, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from($this->table_collection_link);
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
            // $this->db->group_by($this->table_name);
        }	
		#Query		
        $query = $this->db->get();
        $result = $query->result();
        $query->free_result();
        return $result;
    }
                                                    //array(array('table' => '', 'on' => '', 'option' => ''))
    function fetch_join($select = '*', $from = 'tbtt_collection_content', $where = '', $join = array(), $order = '', $by = 'DESC', $start = -1, $limit = 10)
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

    public function get_collection_by_user($user_id, $is_owns = false, $result = 'get')
    {
        if(!$user_id){
            return false;
        }

        $sql = 'SELECT b.id, b.name, b.avatar_path_full, b.user_id ';
        if($result == 'count'){
            $sql = 'SELECT count(b.id) as total ';
        }
        $sql .= ' FROM tbtt_collection as b ';

        $where = " WHERE b.user_id = $user_id AND b.status = 1 ";
        if (!$is_owns) {
            $where .= ' AND b.isPublic = 1 ';
        }

        $sql .= $where;

        if($result == 'count'){
            return $this->db->query($sql)->row_array();
        }
        return $this->db->query($sql . ' LIMIT 10')->result();
    }

    /**
     * @param $user_id
     * @param array $shops
     * @param array $collection_ids
     * @param int $collection_type default : collection link
     * get all collections owner user, shop
     */
    public function my_collections($user_id, $shops = [], $collection_ids = [], $collection_type = COLLECTION_CUSTOMLINK)
    {
        if (empty($user_id) && empty($shops))
            return [];

        $where = "tbtt_collection.type = " . $collection_type;

        //lấy bộ sưu tập của cá nhân hoặc của shop
        if (!empty($shops)) {
            $where .= ' AND tbtt_collection.sho_id IN ('.implode(',', $shops).')';
        }else{
            $where .= ' AND tbtt_collection.user_id = '.$user_id.' AND tbtt_collection.sho_id = 0';
        }

        if (!empty($collection_ids)) {
            $where .= ' AND tbtt_collection.id IN ('.implode(',', $collection_ids).')';
        }

        return $this->gets([
            'select'    => 'tbtt_collection.*, tbtt_shop.sho_name',
            'param'     => $where,
            'orderby'   => 'tbtt_collection.user_id, tbtt_collection.sho_id, tbtt_collection.id',
            'joins'         => [
                ['table' => 'tbtt_shop', 'where' => 'tbtt_collection.sho_id = tbtt_shop.sho_id AND tbtt_collection.sho_id != 0', 'type_join' => 'LEFT'],
            ]
        ]);
    }
}

/* End of file Collection_model.php */

?>