<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Azibai extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->helper('language');
        // $this->lang->load('home/common');
        // $this->load->model('user_model');
        // $this->load->model('shop_model');
        // $ssuser = (int)$this->session->userdata('sessionUser');
    }

    public function index(){
    }

    public function dieukhoan(){
        $this->load->view('home/azibai/dieukhoan');
    }

    public function thoathuan(){
        $this->load->view('home/azibai/thoathuan');
    }
}