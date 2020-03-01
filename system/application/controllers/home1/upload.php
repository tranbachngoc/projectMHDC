<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'file'));
    }
    public function index() {
        $this->load->view('home/upload/index', array('error' => ''));
    }
    public function do_upload() {
        $upload_path_url = base_url() . 'templates/home/images/fileuploaxd/';
        $config['upload_path'] = FCPATH . 'templates/home/images/fileupload/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|docx|doc';
        $config['max_size']	= '10240';
        $config['max_width']  = '5120';
        $config['max_height']  = '5120';


        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload', $error);
            //Load the list of existing files in the upload directory
            $existingFiles = get_dir_file_info($config['upload_path']);
            $foundFiles = array();
            $f=0;
            foreach ($existingFiles as $fileName => $info) {
                if($fileName!='thumbs'){//Skip over thumbs directory
                    //set the data for the json array
                    $foundFiles[$f]['name'] = $fileName;
                    $foundFiles[$f]['size'] = $info['size'];
                    $foundFiles[$f]['url'] = $upload_path_url . $fileName;
                    $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
                    $foundFiles[$f]['deleteUrl'] = base_url() . 'upload/deleteImage/' . $fileName;
                    $foundFiles[$f]['deleteType'] = 'DELETE';
                    $foundFiles[$f]['error'] = null;
                    $f++;
                }
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('tbtt_files' => $foundFiles)));
        } else {
            $data = $this->upload->data();
            $this->load->model('upload_model');
            $this->upload_model->add($data);
//
//               Array
//                (
//                'file_name' => 'png1.jpg',
//                'file_type' => 'image/jpeg',
//                'file_path' => '/home/ipresupu/public_html/uploads/',
//                'full_path' => '/home/ipresupu/public_html/uploads/png1.jpg',
//                'raw_name' => 'png1',
//                'orig_name' => 'png.jpg',
//                'client_name' => 'png.jpg',
//                'file_ext' => '.jpg',
//                'file_size' => 456.93,
//                'is_image' => 1,
//                'image_width' => 1198,
//                'image_height' => 1166,
//                'image_type' => 'jpeg',
//                'image_size_str' => 'width="1198" height="1166"',
//                );

            // to re-size for thumbnail images un-comment and set path here and in json array
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $data['file_path'] . 'thumbs/';
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '';
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['name'];
            $info->size = $data['size'] * 1024;
            $info->type = $data['type'];
            $info->url = $upload_path_url . $data['name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['name'];
            $info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['name'];
            $info->deleteType = 'DELETE';
            $info->error = null;
            $files[] = $info;
            //this is why we put this in the constants to pass only json data
            if (IS_AJAX) {
                echo json_encode(array("tbtt_files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
                $file_data['upload_data'] = $this->upload->data();
                $this->load->view('home/upload/upload_success', $file_data);
            }
        }
    }
    public function deleteImage($file) {//gets the job done but you might want to add error checking and security
        $success = unlink(FCPATH . 'templates/home/images/fileupload/' . $file);
        $success = unlink(FCPATH . 'templates/home/images/thumbs/fileupload/' . $file);
        //info to see if it is doing what it is supposed to
        $info = new StdClass;
        $info->sucess = $success;
        $info->path = base_url() . 'templates/home/images/fileupload/' . $file;
        $info->file = is_file(FCPATH . 'templates/home/images/fileupload/' . $file);

        if (IS_AJAX) {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {
            //here you will need to decide what you want to show for a successful delete
            $file_data['delete_data'] = $file;
            $this->load->view('home/upload/delete_success', $file_data);
        }
    }


    public function file_nganluong() 
    {
        $this->load->model('user_model');
        if (!empty($_REQUEST['user_id']) && !empty($_REQUEST['accuracy'])) 
        {
            $pattern = '/^[0-9A-Za-z]+$/';
            if (preg_match($pattern, $_REQUEST['accuracy'], $matches))
            {
                $getUser = $this->user_model->get("*", "use_id = " . $_REQUEST['user_id'] ." AND accuracy = '" . $_REQUEST['accuracy'] . "'");
                if (!empty($getUser)) 
                {   
                    $myFile = 'nganluong_'.$_REQUEST['accuracy'].".html"; // or .php   
                    $fh = fopen($myFile, 'w'); // or die("error");  
                    $stringData = $_REQUEST['accuracy'];   
                    fwrite($fh, $stringData);
                    fclose($fh);
                    echo true;
                    exit();
                }
            }
        }
        echo false;
    }

}