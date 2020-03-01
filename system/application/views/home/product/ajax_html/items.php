<?php
	if (!empty($list_user_product)) {
		foreach ($list_user_product as $key_user_pro => $v_user_pro) { 
	 		$this->load->view('home/product/ajax_html/item', array('v_user_pro' => $v_user_pro));
	 	}
	}

	if (!empty($list_product_choose)) {
		
		$template_view = 'home/product/ajax_html/item_choose';
		if(!empty($type_view)) {
			if ($type_view == 'home') {
				$template_view = 'home/product/ajax_html/item_choose_home';
			}
			else if ($type_view == 'product') {
				$template_view = 'home/product/ajax_html/item_choose_product';
			}
			else if ($type_view == 'view_product') {
				$template_view = 'home/product/ajax_html/item_view_product';
			}

			else if ($type_view == 'pro_tag') {
				$template_view = 'home/product/ajax_html/item_pro_tag';
			}
		}
		foreach ($list_product_choose as $key_user_pro => $v_user_pro) {
	 		$this->load->view($template_view, array('v_user_pro' => $v_user_pro));
	 	}
		
	}
?>