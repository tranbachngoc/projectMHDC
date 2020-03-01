<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content_library
{
    protected $CI;

    function __construct()
    {
        if(!$this->CI){
            $this->CI =& get_instance();
        }
        $this->CI->load->config('config_upload');
        $this->CI->load->library('file_library');
        $this->CI->load->helper('theme');
        $this->CI->load->model('user_model');
        $this->CI->load->model('shop_model');
        $this->CI->load->model('content_model');
        $this->CI->load->model('videos_model');
        $this->CI->load->model('music_model');
        $this->CI->load->model('lib_link_model');
        $this->CI->load->model('content_link_model');
        $this->CI->load->model('content_image_link_model');
    }

    public function saveIcons($request, $contentMod, &$listFilesDelete, &$listFilesSendFtp)
    {
        $additional_old = null;
        if ($contentMod && $contentMod->not_additional) {
            $temp_additional = @json_decode($contentMod->not_additional, true);
            if ($temp_additional && is_array($temp_additional)) {
                foreach ($temp_additional as $item) {
                    if (array_key_exists('key', $item) && $item['key']) {
                        $key = $item['key'];
                    }
                    else {
                        $key = uniqid();
                        $item['key'] = $key;
                    }
                    $additional_old[$key] = $item;
                }
            }
        }

        if (!empty($request['not_additional']) && is_array($request['not_additional'])) {
            $listIcons = $request['not_additional'];
            $notAdditonal = [];
            foreach ($listIcons as $keyIcon => $icon) {
                if (!empty($icon)) {
                    $temp = [
                        'posi'     => !empty($icon['posi']) ? $icon['posi'] : null,
                        'position' => !empty($icon['position']) ? $icon['position'] : null,
                        'effect'   => !empty($icon['effect']) ? $icon['effect'] : null,
                        'title'    => !empty($icon['title']) ? $icon['title'] : null,
                        'desc'     => !empty($icon['desc']) ? $icon['desc'] : null,
                        'type'     => !empty($icon['type']) && in_array($icon['type'], ICON_TYPE) ? $icon['type'] : ICON_TYPE_ICON,
                    ];

                    if($temp['type'] == ICON_TYPE_ICON){
                        $temp['icon']     = !empty($icon['icon']) ? $icon['icon'] : null;
                    }

                    if (!empty($icon['key']) && !empty($additional_old[$icon['key']])) {
                        $isNew       = false;
                        $image_new   = false;
                        $image_thumb = false;
                        $video_new   = false;
                        $video_thumb = false;
                        $audio_new   = false;
                        $old_icon    = $additional_old[$icon['key']];
                        if($temp['type'] == ICON_TYPE_VIDEO){
                            $this->_get_old_media_icon(['video_path', 'video_thumb'], $old_icon, $listFilesDelete);
                            if (!empty($icon['video_path'])) {
                                if (empty($old_icon['video_path'])) {
                                    $video_new            = true;
                                    $temp['video_path']   = $icon['video_path'];
                                    $temp['video_width']  = !empty($icon['video_width']) ? $icon['video_width'] : 0;
                                    $temp['video_height'] = !empty($icon['video_height']) ? $icon['video_height'] : 0;
                                }else if (!empty($old_icon['video_path']) && $icon['video_path'] != $old_icon['video_path']) {
                                    $video_new            = true;
                                    $temp['video_path']   = $icon['video_path'];
                                    $temp['video_width']  = !empty($icon['video_width']) ? $icon['video_width'] : 0;
                                    $temp['video_height'] = !empty($icon['video_height']) ? $icon['video_height'] : 0;
                                    $listFilesDelete['delete_video_icons'][] = $old_icon['video_path'];
                                }else{
                                    $temp['video_path'] = $icon['video_path'];
                                    $temp['video_width']  = !empty($icon['video_width']) ? $icon['video_width'] : (!empty($old_icon['video_width']) ? $old_icon['video_width'] : 0);
                                    $temp['video_height'] = !empty($icon['video_height']) ? $icon['video_height'] :(!empty($old_icon['video_height']) ? $old_icon['video_height'] : 0);
                                }
                            }else if(!empty($old_icon['video_path'])){
                                $listFilesDelete['delete_video_icons'][] = $old_icon['video_path'];
                            }

                            if (!empty($icon['video_thumb'])) {
                                if (empty($old_icon['video_thumb'])) {
                                    $video_thumb         = true;
                                    $temp['video_thumb'] = $icon['video_thumb'];
                                }else if (!empty($old_icon['video_thumb']) && $icon['video_thumb'] != $old_icon['video_thumb']) {
                                    $video_thumb              = true;
                                    $listFilesDelete['ftp'][] = $old_icon['video_thumb'];
                                    $temp['video_thumb']      = $icon['video_thumb'];
                                }else{
                                    $temp['video_thumb']      = $icon['video_thumb'];
                                }
                            }else if (empty($old_icon['video_thumb'])) {
                                $listFilesDelete['ftp'][] = $old_icon['video_thumb'];
                            }
                        }

                        if($temp['type'] == ICON_TYPE_IMAGE) {
                            $this->_get_old_media_icon(['image_path', 'image_thumb'], $old_icon, $listFilesDelete);

                            if (!empty($icon['image_path'])) {
                                if (empty($old_icon['image_path'])) {
                                    $image_new          = true;
                                    $temp['image_path'] = $icon['image_path'];
                                }else if (!empty($old_icon['image_path']) && $icon['image_path'] != $old_icon['image_path']) {
                                    $image_new                = true;
                                    $listFilesDelete['ftp'][] = $old_icon['image_path'];
                                    $temp['image_path']       = $icon['image_path'];
                                }else{
                                    $temp['image_path']       = $icon['image_path'];
                                }

                            }
                            else if(!empty($old_icon['image_path'])){
                                $listFilesDelete['ftp'][] = $old_icon['image_path'];
                            }

                            if (!empty($icon['image_thumb'])) {
                                if (empty($old_icon['image_thumb'])) {
                                    $image_thumb         = true;
                                    $temp['image_thumb'] = $icon['image_thumb'];
                                }else if (!empty($old_icon['image_thumb']) && $icon['image_thumb'] != $old_icon['image_thumb']) {
                                    $image_thumb              = true;
                                    $listFilesDelete['ftp'][] = $old_icon['image_thumb'];
                                    $temp['image_thumb']      = $icon['image_thumb'];
                                }else{
                                    $temp['image_thumb']      = $icon['image_thumb'];
                                }
                            }
                            else if(!empty($old_icon['image_thumb'])){
                                $listFilesDelete['ftp'][] = $old_icon['image_thumb'];
                            }
                        }

                        if($temp['type'] == ICON_TYPE_AUDIO) {
                            $temp['audio_azibai'] = 1;
                            $this->_get_old_media_icon(['audio_path'], $old_icon, $listFilesDelete);
                            if (empty($old_icon['audio_path']) && !empty($icon['audio_path'])) {
                                $audio_new          = true;
                                $temp['audio_path'] = $icon['audio_path'];
                                $temp['audio_link'] = null;
                            }
                            else if (!empty($old_icon['audio_path']) && !empty($icon['audio_path']) && $icon['audio_path'] != $old_icon['audio_path']) {
                                $audio_new          = true;
                                $temp['audio_path'] = $icon['audio_path'];
                                $temp['audio_link'] = null;
                                $temp['audio_path'] = $icon['audio_path'];
                                $listFilesDelete['audios_delete'][] = $old_icon['audio_path'];
                            }
                            else if(!empty($old_icon['audio_path']) && !empty($icon['audio_path']) && $icon['audio_path'] == $old_icon['audio_path']){
                                $temp['audio_path']   = $icon['audio_path'];
                                if(!$this->CI->music_model->find_audio_azibai($icon['audio_path'])){
                                    $temp['audio_azibai'] = 2;
                                }
                            }
                            else if(empty($icon['audio_path']) && !empty($old_icon['audio_path'])){
                                $listFilesDelete['audios_delete'][] = $old_icon['audio_path'];
                            }

                            if (empty($temp['audio_path'])) {
                                if(!empty($icon['audio_link']) && filter_var($icon['audio_link'], FILTER_VALIDATE_URL)){
                                    $temp['audio_link']   = $icon['audio_link'];
                                    $temp['audio_azibai'] = 3;
                                }
                            }
                        }

                    }else {
                        $isNew = true;
                        if (!empty($icon['image_path']) && $temp['type'] == ICON_TYPE_IMAGE) {
                            $temp['image_path'] = $icon['image_path'];
                        }
                        if (!empty($icon['image_thumb']) && $temp['type'] == ICON_TYPE_IMAGE) {
                            $temp['image_thumb'] = $icon['image_thumb'];
                        }
                        if (!empty($icon['video_path']) && $temp['type'] == ICON_TYPE_VIDEO) {
                            $temp['video_path'] = $icon['video_path'];
                        }
                        if (!empty($icon['video_thumb']) && $temp['type'] ==  ICON_TYPE_VIDEO) {
                            $temp['video_thumb'] = $icon['video_thumb'];
                        }
                        if (!empty($icon['audio_path']) && $temp['type'] == ICON_TYPE_AUDIO) {
                            $temp['audio_path'] = $icon['audio_path'];
                        }
                        if (!empty($icon['audio_link']) && $temp['type'] == ICON_TYPE_AUDIO) {
                            $temp['audio_link'] = $icon['audio_link'];
                        }
                        $temp['key'] = uniqid();
                    }

                    if(empty($temp['icon'])){
                        $temp['icon']     = null;
                        $temp['icon_url'] = null;
                    }

                    if($temp['type'] == ICON_TYPE_ICON && empty($temp['icon'])){
                        unset($temp);
                        continue;
                        throw new \Exception('Icon type Icon không hợp lệ');
                    }

                    if($temp['type'] == ICON_TYPE_IMAGE && (empty($temp['image_path']) || empty($temp['image_thumb']))){
                        unset($temp);
                        continue;
                        throw new \Exception('Icon type Image không hợp lệ');
                    }

                    if($temp['type'] == ICON_TYPE_VIDEO && (empty($temp['video_path']) || empty($temp['video_thumb']))){
                        unset($temp);
                        continue;
                        throw new \Exception('Icon type Video không hợp lệ');
                    }

                    if($temp['type'] == ICON_TYPE_AUDIO){
                        $temp['audio_azibai'] = 1;
                        if (empty($temp['audio_path'])) {
                            $url = parse_url($temp['audio_link']);
                            if(empty($temp['audio_link'])
                                || !filter_var($temp['audio_link'], FILTER_VALIDATE_URL)
                                || (filter_var($temp['audio_link'], FILTER_VALIDATE_URL) && !preg_match('/\.mp3$/i', $url['path']))){
                                unset($temp);
                                continue;
                                throw new \Exception('Icon type Audio không hợp lệ');
                            }
                            $temp['audio_azibai'] = 3;
                        }
                    }

                    if (($isNew || !empty($video_new)) && !empty($temp['video_path'])) {
                        if (!$this->CI->file_library->checkTmpFileExist($temp['video_path'])) {
                            unset($temp);
                            continue;
//                                Log::error('File video ' . $temp['video_path'] . ' không tồn tại');
                            throw new \Exception('File video ' . $temp['video_path'] . ' không tồn tại');
                        }
                        $listFilesSendFtp['video_icons'][] = $temp['video_path'];
                    }

                    if (($isNew || !empty($image_new)) && !empty($temp['image_path'])) {
                        if (!$this->CI->file_library->checkTmpFileExist($temp['image_path'])) {
                            unset($temp);
                            continue;
//                                Log::error('File image ' . $temp['image_path'] . ' không tồn tại');
                            throw new \Exception('File image ' . $temp['image_path'] . ' không tồn tại');
                        }
                        try {
                            $image_info = getimagesize(DOMAIN_CLOUDSERVER . 'tmp/' . $temp['image_path']);
                            if ($image_info && is_array($image_info)) {
                                $temp['image_width']  = $image_info[0];
                                $temp['image_height'] = $image_info[1];
                            }
                        } catch (\Exception $e) {
                            unset($temp);
                            continue;
                            throw new \Exception('File image ' . $temp['image_path'] . ' không hợp lệ');
                        }
                        $listFilesSendFtp['ftp'][] = $temp['image_path'];
                    }

                    if (($isNew || !empty($image_thumb)) && !empty($temp['image_thumb'])) {
                        if (!$this->file_library->checkTmpFileExist($temp['image_thumb'])) {
                            unset($temp);
                            continue;
//                                Log::error('File image ' . $temp['image_thumb'] . ' không tồn tại');
                            throw new \Exception('File image ' . $temp['image_thumb'] . ' không tồn tại');
                        }
                        $listFilesSendFtp['ftp'][] = $temp['image_thumb'];
                    }

                    if (($isNew || !empty($video_thumb)) && !empty($temp['video_thumb'])) {
                        if (!$this->CI->file_library->checkTmpFileExist($temp['video_thumb'])) {
                            unset($temp);
                            continue;
//                                Log::error('File image ' . $temp['video_thumb'] . ' không tồn tại');
                            throw new \Exception('File image ' . $temp['video_thumb'] . ' không tồn tại');
                        }
                        try {
                            $image_info = getimagesize(DOMAIN_CLOUDSERVER .'tmp/'. $temp['video_thumb']);
                            if ($image_info && is_array($image_info)){
                                $temp['video_width']  = $image_info[0];
                                $temp['video_height'] = $image_info[1];
                            }
                        } catch (\Exception $e) {
                            unset($temp);
                            continue;
                            throw new \Exception('File image ' . $temp['video_thumb'] . ' không hợp lệ');
                        }
                        $listFilesSendFtp['ftp'][] = $temp['video_thumb'];
                    }

                    /*check trong db ko có mới check file exit*/
                    if (($isNew || !empty($audio_new)) && !empty($temp['audio_path'])) {
                        if(!$this->CI->music_model->find_audio_azibai($temp['audio_path'])){
                            if(!$this->CI->file_library->checkTmpFileExist($temp['audio_path'])){
                                unset($temp);
                                continue;
//                                    Log::error('File image ' . $temp['audio_path'] . ' không tồn tại');
                                throw new \Exception('File audio ' . $temp['audio_path'] . ' không tồn tại');
                            }
                            $temp['audio_azibai'] = 2;
                        }
                        $listFilesSendFtp['audios'][] = $temp['audio_path'];
                    }
                    if(empty($temp['key'])){
                        $temp['key'] = uniqid();
                    }
                    $notAdditonal[] = $temp;
                }
            }
            return json_encode($notAdditonal);
        }
        return '';
    }

    private function _get_old_media_icon($keep_media, $icon_old, &$listFilesDelete)
    {
        if (empty($keep_media) || empty($icon_old)){
            return false;
        }
        $media_allow = ['image_path', 'image_thumb', 'video_path', 'video_thumb', 'audio_path'];
        foreach ($media_allow as $media) {
            if(!empty($icon_old[$media]) && !in_array($media, $keep_media)){
                if($media == 'image_path'){
                    $listFilesDelete['ftp'][] = $icon_old[$media];
                }
                if($media == 'image_thumb'){
                    $listFilesDelete['ftp'][] = $icon_old[$media];
                }
                if($media == 'video_thumb'){
                    $listFilesDelete['ftp'][] = $icon_old[$media];
                }
                if($media == 'video_path'){
                    $listFilesDelete['delete_video_icons'][] = $icon_old[$media];
                }
                if($media == 'audio_path'){
                    $listFilesDelete['audios'][] = $icon_old[$media];
                }
            }
        }

    }

    public function saveVideo($request, $contentMod, &$listFilesDelete, &$listFilesSendFtp) {
        $oldVideoMod = NULL;
        if ($contentMod && $contentMod->not_video_url1) {
            $oldVideoMod = $this->CI->videos_model->find_where(['id' => $contentMod->not_video_url1], [], 'object');
        }

        if (!empty($request['not_video'])) {
            $video = [];
            if (!$contentMod) {
                $video['user_id'] = $request['not_user'];
                $video['sho_id']  = $request['sho_id'];
                $video['path']    = 'video/thumbnail/';
            }

            if(!empty($request['video_title'])){
                $video['title'] = $this->CI->filter->injection_html($request['video_title']);
            }
            if(!empty($request['video_content'])){
                $video['description']  = $this->CI->filter->injection_html($request['video_content']);
            }

            if ($request['not_video']) {
                $isNew = false;
                if (!$oldVideoMod) {
                    $isNew = true;
                } else if ($request['not_video'] != $oldVideoMod->name) {
                    $listFilesDelete['ftp3']['video']     = $oldVideoMod->name;
                    $listFilesDelete['ftp3']['thumbnail'] = $oldVideoMod->thumbnail;
                    $isNew = true;
                }
                if ($isNew) {
                    if ($video_info2 = $this->CI->file_library->checkTmpVideoFileExist($request['not_video'])) {
                        $video['name']       = $request['not_video'];
                        $video['processing'] = (int)$video_info2['check_resize'];
                        //content_id
                        $listFilesSendFtp['ftp3']['video'] = $request['not_video'];
                    } else {
                        log_message('error', json_encode(['error_file_name' => __FILE__ . ':'. __LINE_, $request['not_video']]));
                        return null;
                    }
                    if ($this->CI->file_library->checkTmpFileExist($request['not_video_thumb'])) {
                        $image_info = getimagesize(DOMAIN_CLOUDSERVER . 'tmp/' . $request['not_video_thumb']);
                        if ($image_info && is_array($image_info)) {
                            $video['width'] = $image_info[0];
                            $video['height'] = $image_info[1];
                        }
                        $listFilesSendFtp['ftp3']['thumbnail'] = $video['thumbnail'] = $request['not_video_thumb'];
                    } else {
                        return null;
                    }
                }
            } else if ($oldVideoMod) {
                $listFilesDelete['ftp3']['video']     = $oldVideoMod->name;
                $listFilesDelete['ftp3']['thumbnail'] = $oldVideoMod->thumbnail;
            }

            //add off update
            if(!$oldVideoMod){
                if($id = $this->CI->videos_model->add($video)){
                    return $this->CI->videos_model->find_where(['id' => $id], [], 'array');
                }
            }else{
                if(empty($video)){
                    return $oldVideoMod->id;
                }
                if($this->CI->videos_model->update_where($video, ['id' => $oldVideoMod->id])){
                    return $this->CI->videos_model->find_where(['id' => $oldVideoMod->id], [], 'array');
                }
            }
            log_message('error', __FILE__ . ':'. __LINE__.' luu video that bai');
        } else if ($oldVideoMod){
            //delete
            if ($this->CI->videos_model->delete_where(['id' => $oldVideoMod->id])) {
                $listFilesDelete['ftp3']['thumbnail'] = $oldVideoMod->thumbnail;
                $listFilesDelete['ftp3']['video']     = $oldVideoMod->name;
                return null;
            }
        } else {
            return null;
        }
        return null;
//        throw new \Exception('Luu video that bai');
    }

    public function saveHashTag($request)
    {
        $string = $request['not_title'] . $request['not_detail'] . str_replace($request['not_detail'], '', $request['not_description']);
        if($string && preg_match_all('/#[\w\x{0080}-\x{FFFF}]+/u', $string, $matches)){
            return json_encode($matches[0]);
        }
        return null;
    }

}