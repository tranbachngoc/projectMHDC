<?php

class Ghnapilog_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table_name = "tbtt_ghn_log";
    }
    
    public function create($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

}
