<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Group extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
            #CHECK SETTING
            if ((int)settingStopSite == 1) {
                $this->lang->load('home/common');
                show_error($this->lang->line('stop_site_main'));
                die();
        }

    }
    //
    function index(){
        $this->load->view('group/defaults');
    }
    
    
}