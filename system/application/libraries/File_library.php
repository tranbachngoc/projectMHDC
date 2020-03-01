<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_library
{
    protected $CI;

    function __construct()
    {
        if(!$this->CI){
            $this->CI =& get_instance();
        }
        $this->CI->config->load('config_api');
    }

    public function checkTmpFileExist($file_name)
    {
        if($file_name){
            try{
                $result = curl_data($this->CI->config->item('api_check_tmp_file_exist'), [
                    'name' => $file_name
                ],'','','POST', $this->CI->session->userdata('token'));
                if($result) {
                    $result = @json_decode($result, true);
                }
                if(!empty($result['status']) && $result['status'] == 1){
                    return true;
                }
            }catch (\Exception $e){
                return false;
            }
        }
        return false;
    }

    public function checkTmpVideoFileExist($file_name)
    {
        if($file_name){
            try{
                $result = curl_data($this->CI->config->item('api_check_tmp_video_file_exist'), [
                    'name' => $file_name
                ],'','','POST', $this->CI->session->userdata('token'));
                $result = @json_decode($result, true);
                if(!empty($result['file_info'])){
                    return $result['file_info'];
                }
                log_message('error', json_encode([$result]));
            }catch (\Exception $e){
                log_message('error', json_encode([$e]));
            }
        }
        return false;
    }

    public function saveFilesOfArticle($listFilesSendFtp, $listFilesDelete, $dir) {
        $params = [
            'file_names'          => !empty($listFilesSendFtp['ftp']) ? $listFilesSendFtp['ftp'] : null,
            'video'               => isset($listFilesSendFtp['ftp3']['video']) ? $listFilesSendFtp['ftp3']['video'] : NULL,
            'thumbnail'           => isset($listFilesSendFtp['ftp3']['thumbnail']) ? $listFilesSendFtp['ftp3']['thumbnail'] : NULL,
            'file_names_delete'   => !empty($listFilesDelete['ftp']) ? $listFilesDelete['ftp'] : null,
            'video_delete'        => isset($listFilesDelete['ftp3']['video']) ? $listFilesDelete['ftp3']['video'] : NULL,
            'thumbnail_delete'    => isset($listFilesDelete['ftp3']['thumbnail']) ? $listFilesDelete['ftp3']['thumbnail'] : NULL,
            'custom_links'        => !empty($listFilesSendFtp['custom_link']) ? $listFilesSendFtp['custom_link'] : null,
            'custom_links_delete' => !empty($listFilesDelete['custom_link']) ? $listFilesDelete['custom_link'] : null,
            'custom_link_dir'     => date('Y/m/d/'),
            'dir'                 => $dir
        ];

        if(!empty($listFilesSendFtp['audios'])){
            $params['audios'] = $listFilesSendFtp['audios'];
        }

        if(!empty($listFilesDelete['audios'])){
            $params['audios_delete'] = $listFilesDelete['audios'];
        }

        if(!empty($listFilesSendFtp['video_icons'])){
            $params['video_icons'] = $listFilesSendFtp['video_icons'];
        }

        if(!empty($listFilesDelete['delete_video_icons'])){
            $params['delete_video_icons'] = $listFilesDelete['delete_video_icons'];
        }

        try{
            $result = curl_multi_level_arr($this->CI->config->item('api_copy_content_file'), $params,'POST', $this->CI->session->userdata('token'));
            if($result) {
                $result =  @json_decode($result, true);
            }
            if(!empty($result['status']) && $result['status'] == 1){
                return true;
            }
        }catch (\Exception $e){
            return false;
        }

        return false;
    }

}