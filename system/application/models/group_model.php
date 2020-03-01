<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Group_model extends CI_Model
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
		$query = $this->db->get("tbtt_group");
		$result = $query->row();
		$query->free_result();
		return $result;
	}

	function fetch($select = "*", $where = "", $order = "gro_id", $by = "DESC", $start = -1, $limit = 0)
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
		$query = $this->db->get("tbtt_group");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function add($data)
	{
		return $this->db->insert("tbtt_group", $data);
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_group", $data);
	}

	function delete($value, $field = "gro_id", $in = true)
    {
		if($in == true)
		{
			$this->db->where_in($field, $value);
		}
		else
		{
            $this->db->where($field, $value);
		}
		return $this->db->delete("tbtt_group");
    }


    //Load product and detail product, not use differen case, by Bao Tran
    function getProAndDetail($select="*", $where="", $pro_id=0, $color="", $size="", $material="")
    {
        $this->db->cache_off();

        $clause = '';

        if ($color && $color != "") {
            $clause .= ' AND dp_color LIKE "%'. $color .'%"';
        }
        if ($size && $size != "") {
            $clause .= ' AND dp_size LIKE "%'. $size .'%"';
        }
        if ($material && $material != "") {
            $clause .= ' AND dp_material = "'. $material .'"';
        }

        $sql_select_join = '(SELECT * FROM tbtt_detail_product WHERE dp_pro_id = '. $pro_id .' '. $clause .' ORDER BY id DESC LIMIT 1) AS T2';

        $this->db->select($select, false);
        $this->db->from('tbtt_product');
        $this->db->join($sql_select_join, 'T2.`dp_pro_id` = tbtt_product.`pro_id`', 'LEFT');
        $this->db->where($where, NULL, false);
        #Query
        $query = $this->db->get();
        $result = $query->row();
        $query->free_result();
        return $result;
    }
}