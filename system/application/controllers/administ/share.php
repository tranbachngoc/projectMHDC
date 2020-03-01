<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Share extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->check->is_logined($this->session->userdata('sessionUserAdmin'), $this->
            session->userdata('sessionGroupAdmin'))) {
            redirect(base_url() . 'administ', 'location');
            die();
        }
        $this->lang->load('admin/common');
        $this->load->helper('language');
    }

    function index($page = 0)
    {
        $this->load->model('share_model');
        $this->share_model->pagination(true);
        $this->share_model->setCurLink('administ/share');
        $body = array();
        $body['list'] = $this->share_model->lister(array(),$page);
        $body['sort'] = $this->share_model->getAdminSort();
        $body['filter'] = $this->share_model->getFilter();
        $body['pager'] = $this->share_model->pager;

        //Begin pagination
        $page = $this->uri->segment(3);       
        if($page > 0){
            $Pagination =  $page;
        }
        else{            
            $Pagination = 0;             
        }
        $body['start'] = $Pagination;
        
        $body['link'] = base_url() . 'administ/share';
        $this->load->view('admin/share/share', $body);
        
    }
}
