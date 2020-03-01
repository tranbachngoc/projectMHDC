<?php
#****************************************#
# * @Author: tranbao                     #
# * @Email: tranbaothe@gmail.com         #
# * @Website: http://www.azibai.com      #
# * @Copyright: 2018 - 2019              #
#****************************************#
class Aff_price_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->_table = "tbtt_affiliate_price";
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
        $this->db->select($select);
        if($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get($this->_table);
        $result = $query->row();
        $query->free_result();
        return $result;
	}

	function gets($select = "*", $where = "")
	{
        $this->db->cache_off();
        $this->db->select($select);
        if($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get($this->_table);
        $result = $query->result();
        $query->free_result();
        return $result;
	}

	

	function add($data)
	{        
		return $this->db->insert($this->_table, $data);
	}

	function update($data, $where = "")
	{
		if($where && $where != "")
        {
            $this->db->where($where);
        }
        return $this->db->update($this->_table, $data);        
	}

	function delete($where = "")
    {
        if($where && $where != "")
        {
            $this->db->where($where);
        }
		return $this->db->delete($this->_table);
    }   
}