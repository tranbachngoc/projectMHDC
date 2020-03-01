<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_news_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table  = "tbtt_send_news";
        $this->select = "*";
    }
}
?>