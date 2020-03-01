<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Logout extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		#BEGIN: CHECK LOGIN
		if(!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->session->userdata('sessionGroupAdmin')))
		{
			redirect(base_url().'azi-admin', 'location');
			die();
		}
		#END CHECK LOGIN
	}
	
	function index()
	{
		$this->session->sess_destroy();
		redirect(base_url().'azi-admin', 'location');
	}
}