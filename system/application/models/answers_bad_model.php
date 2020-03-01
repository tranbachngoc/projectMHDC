<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Answers_bad_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function fetch($select = "*", $where = "", $order = "adb_id", $by = "DESC", $groupBy = "", $start = -1, $limit = 0)
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
		if($groupBy && $groupBy != "")
		{
			$this->db->group_by($groupBy);
		}
		if((int)$start >= 0 && $limit && (int)$limit > 0)
		{
			$this->db->limit($limit, $start);
		}
		#Query
		$query = $this->db->get("tbtt_hds_re_bad");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_hds_re_bad", $data);
	}

	function delete($value, $field = "adb_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_hds_re_bad");
    }
}