<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Videos_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_videos";
        $this->select = "*";
    }

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_videos");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_videos", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_videos", $data);
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
		return $this->db->delete("tbtt_videos");
    }
}