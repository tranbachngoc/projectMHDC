<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_follow_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_user_follow";
        $this->select = '*';
    }
    

    
}