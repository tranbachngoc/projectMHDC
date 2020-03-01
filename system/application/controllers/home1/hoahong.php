<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Hoahong extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
        $this->load->model('user_model');
        $this->load->model('affiliate_relationship_model');
        $this->load->model('affiliate_price_model');
	}

    
	
}