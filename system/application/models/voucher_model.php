<?php

class Voucher_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get($voucher_code, $shop_user_id = null)
	{
		$date = date('Y-m-d H:i:s');
        $this->db->cache_off();
		$this->db->select('tbtt_voucher.*, tbtt_package_user.code as v_code, tbtt_package_user.user_id as v_user_id, tbtt_package_user.sponser_id as v_sponser_id, tbtt_package_user.user_affiliate_id as v_user_affiliate_id, tbtt_package_user.created_date as v_created_date, tbtt_package_user.id as v_id, tbtt_shop.sho_name as sho_name, tbtt_shop.sho_logo as sho_logo, tbtt_shop.sho_dir_logo as sho_dir_logo, tbtt_shop.sho_link as sho_link, tbtt_shop.domain as domain, tbtt_shop.sho_user as sho_user, tbtt_shop.sho_id as sho_id, tbtt_user.use_id as u_user_id');
		$this->db->where('tbtt_package_user.code', $voucher_code);
		$this->db->where('tbtt_package_user.payment_status', 1);
		$this->db->where('tbtt_package_user.status', 0);
		$this->db->where('tbtt_voucher.time_end >=', $date);
		$this->db->where('tbtt_voucher.time_start <=', $date);

		if ($shop_user_id > 0) 
		{
			$this->db->where('tbtt_user.use_id', $shop_user_id);
		}

		$this->db->join('tbtt_package_user', 'tbtt_package_user.package_id = tbtt_voucher.id');
		$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_voucher.user_id');
		$this->db->join('tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
		$query = $this->db->get("tbtt_voucher");
		$result = $query->row_array();
		return $result;
	}


	function listVoucher($shop_user_id = null)
	{
		if (!empty($this->session->userdata('sessionUser'))) 
		{
			$date = date('Y-m-d H:i:s');
	        $this->db->cache_off();
			$this->db->select('tbtt_voucher.*, tbtt_package_user.code as v_code, tbtt_package_user.user_id as v_user_id, tbtt_package_user.sponser_id as v_sponser_id, tbtt_package_user.user_affiliate_id as v_user_affiliate_id, tbtt_package_user.created_date as v_created_date, tbtt_package_user.id as v_id, tbtt_shop.sho_name as sho_name, tbtt_shop.sho_logo as sho_logo, tbtt_shop.sho_dir_logo as sho_dir_logo, tbtt_shop.sho_link as sho_link, tbtt_shop.domain as domain, tbtt_shop.sho_user as sho_user, tbtt_shop.sho_id as sho_id, tbtt_user.use_id as u_user_id, (SELECT COUNT(*) FROM tbtt_voucher_product WHERE voucher_id = tbtt_voucher.id) as product_count');
			$this->db->where('tbtt_package_user.payment_status', 1);
			$this->db->where('tbtt_package_user.status', 0);
			$this->db->where('tbtt_package_user.user_id', (int) $this->session->userdata('sessionUser'));
			$this->db->where('tbtt_voucher.time_end >=', $date);
			$this->db->where('tbtt_voucher.time_start <=', $date);

			if ($shop_user_id > 0) 
			{
				$this->db->where('tbtt_user.use_id', $shop_user_id);
			}
			
			$this->db->join('tbtt_package_user', 'tbtt_package_user.package_id = tbtt_voucher.id');
			$this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_voucher.user_id');
			$this->db->join('tbtt_shop', 'tbtt_shop.sho_user = tbtt_user.use_id');
			$query = $this->db->get("tbtt_voucher");
			$result = $query->result();
			$query->free_result();
			return $result;
		}
		return false;
	}


	function productListVoucher($voucher_id)
	{		
        $this->db->cache_off();
		$this->db->select('*');
		$this->db->where('voucher_id', $voucher_id);
		$query = $this->db->get("tbtt_voucher_product");
		$result = $query->result();
		$query->free_result();
		return $result;
	}

}