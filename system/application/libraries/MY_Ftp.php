<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hthan
 * Date: 04/18/2019
 * Time: 3:14 PM
 */

class MY_Ftp extends CI_FTP
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * @param $rempath: path ftp server
     * @param $upload_path: path ftp upload
     * @param $temp_path: path local temp
     * @return bool
     */
    function ftp_copy($rempath, $upload_path, $temp_path)
    {
         if(!$temp_path){
             return false;
         }
         if($this->download($rempath, $temp_path)){
             if($this->upload($temp_path, $upload_path)){
                 return true;
             }
         }
        return false;
    }

}