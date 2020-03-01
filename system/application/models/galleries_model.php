<?php
#****************************************#
# * @Author: thuan                       #
# * @Email:                              #
# * @Website:                            #
# *                                      #
#****************************************#
class Galleries_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_pro_gallery_detail";
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
		$query = $this->db->get("tbtt_pro_gallery_detail");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_pro_gallery_detail", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_pro_gallery_detail", $data);
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
		return $this->db->delete("tbtt_pro_gallery_detail");
    }
}