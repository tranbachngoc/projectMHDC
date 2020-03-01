<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
     ***************************************************************************
     * Created: 2018/08/29
     * Check Permissions
     ***************************************************************************
     * @author: Duc<nguyenvietduckt82@gmail.com>
     * @return: return true or false
     *  
     ***************************************************************************
    */
    if(!function_exists('checkPerProduct')) {
		function checkPerProduct($iGroupId = 0) {
			$aListPer = array(AffiliateStoreUser,BranchUser,StaffStoreUser);
			if(in_array($iGroupId, $aListPer)) {
				return true;
			}

			return false;
		}
	}
?>