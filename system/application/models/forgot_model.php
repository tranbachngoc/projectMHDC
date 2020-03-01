<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Forgot_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
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
		$query = $this->db->get("tbtt_forgot");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_forgot", $data);
	}

	function delete($value, $field = "for_key")
    {
		$this->db->where($field, $value);
		return $this->db->delete("tbtt_forgot");
    }
}