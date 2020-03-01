<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = "tbtt_music";
        $this->select = "*";
    }

    public function find_audio_azibai($audio_name)
    {
        return $this->find_where(['music_path' => $audio_name], [], 'array');
    }


}