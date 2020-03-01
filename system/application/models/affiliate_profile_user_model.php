<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Affiliate_profile_user_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get($select = "*", $where = "")
	{
        $this->db->cache_off();
        if($select == '') {
        	$select = '
        		tbtt_affiliate_user.*,
        		tbtt_package.id as package_id,
        		tbtt_package.period,
        		tbtt_package.month_price,
        		tbtt_package.published,
        		tbtt_package_info.id as info_id,
        		tbtt_package_info.name,
        		tbtt_package_info.desc,
        		tbtt_package_info.published,
        		tbtt_package_info.pType,
        		(
		            SELECT
		              tbtt_service.limit    
		            FROM
		              tbtt_service              
		              JOIN tbtt_package_service
		                ON tbtt_package_service.service_id = tbtt_service.id
		            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
		        ) as limits,
		        (
		            SELECT
		              tbtt_service.unit      
		            FROM
		              tbtt_service              
		              JOIN tbtt_package_service
		                ON tbtt_package_service.service_id = tbtt_service.id
		            WHERE tbtt_package_service.package_id = tbtt_package.id LIMIT 0, 1
		        ) as units
		        ';
        }
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$this->db->join('tbtt_package', 'tbtt_package.id = tbtt_affiliate_user.service_id');
		$this->db->join('tbtt_package_info', 'tbtt_package_info.id = tbtt_affiliate_user.info_id');
		$query = $this->db->get("tbtt_affiliate_user");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

	function getwhere($select = "*", $where = ""){
        $this->db->cache_off();
		$this->db->select($select);
		if($where && $where != "")
		{
			$this->db->where($where, NULL, false);
		}
		#Query
		$query = $this->db->get("tbtt_affiliate_user");
		$result = $query->row_array();
		// $query->free_result();
		return $result;
	}

    function add($data){

		$this->db->insert("tbtt_affiliate_user", $data);
		$insert_id = $this->db->insert_id();

   		return  $insert_id;
	}

	function update($data, $where = "")
	{
    	if($where && $where != "")
    	{
			$this->db->where($where);
    	}
		return $this->db->update("tbtt_affiliate_user", $data);
	}

	function updateIn($data, $field = 'id')
	{
		return $this->db->update_batch("tbtt_affiliate_user", $data, $field);
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
		return $this->db->delete("tbtt_affiliate_user");
	}
}