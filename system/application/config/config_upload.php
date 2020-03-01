<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*-----------config fpt---------------*/
$config['configftp']['hostname'] = IP_CLOUDSERVER;
$config['configftp']['username'] = USER_CLOUDSERVER;
$config['configftp']['password'] = PASS_CLOUDSERVER;
$config['configftp']['port']     = PORT_CLOUDSERVER;
$config['configftp']['debug']    = false;
$config['configftp']['passive']  = true;

/*-----------config folder temp---------------*/
$config['img_dir_temp'] = 'media/images/temp';

/*-----------config image avatar user---------------*/
$config['avatar_user_config']['upload_path']            = "media/images/avatar";
$config['avatar_user_config']['upload_path_temp']       = $config['img_dir_temp'];
$config['avatar_user_config']['allowed_types']          = 'jpg|jpeg|png';
$config['avatar_user_config']['max_size']               = 5240;#KB//10MB
$config['avatar_user_config']['min_width']              = 180;#px
$config['avatar_user_config']['min_height']             = 180;#px
$config['avatar_user_config']['max_width']              = 5000;#px
$config['avatar_user_config']['max_height']             = 5000;#px
$config['avatar_user_config']['encrypt_name']           = true;
$config['cloud_avatar_user_config']['upload_path']      = '/public_html/media/images/avatar';
$config['avatar_user_config']['cloud_server_show_path'] = DOMAIN_CLOUDSERVER . $config['avatar_user_config']['upload_path'];

/*-----------config image cover user---------------*/
$config['cover_user_config']['upload_path']              = "media/images/profiles";//root path cover/id_user is personal user
$config['cover_user_config']['upload_path_temp']         = $config['img_dir_temp'];
$config['cover_user_config']['allowed_types']            = 'jpg|jpeg|png';
$config['cover_user_config']['max_size']                 = 10240;#KB//10MB
$config['cover_user_config']['min_width']                = 800;#px
$config['cover_user_config']['min_height']               = 266;#px 267
$config['cover_user_config']['max_width']                = 4800;#pxcover_user_config
$config['cover_user_config']['max_height']               = 1600;#px
$config['cover_user_config']['fit_width']                = 1140;#px
$config['cover_user_config']['fit_height']               = 380;#px
$config['cover_user_config']['encrypt_name']             = true;
$config['cloud_cover_user_config']['upload_path']        = '/public_html/media/images/profiles';
$config['cover_user_config']['cloud_server_show_path']   = DOMAIN_CLOUDSERVER . $config['cover_user_config']['upload_path'];

/*-----------config image banner shop ---------------*/
$config['banner_shop_config']['upload_path']            = "media/shop/banners";
$config['banner_shop_config']['upload_path_temp']       = $config['img_dir_temp'];
$config['banner_shop_config']['allowed_types']          = 'jpg|jpeg|png';
$config['banner_shop_config']['max_size']               = 10240;#KB//10MB
$config['banner_shop_config']['min_width']              = 800;#px
$config['banner_shop_config']['min_height']             = 266;#px
$config['banner_shop_config']['max_width']              = 4800;#px
$config['banner_shop_config']['max_height']             = 1600;#px
$config['banner_shop_config']['fit_width']              = 1140;#px
$config['banner_shop_config']['fit_height']             = 380;#px
$config['banner_shop_config']['encrypt_name']           = true;
$config['cloud_banner_shop_config']['upload_path']      = '/public_html/media/shop/banners/';
$config['banner_shop_config']['cloud_server_show_path'] = DOMAIN_CLOUDSERVER . $config['banner_shop_config']['upload_path'];

/*-----------config image logo shop ---------------*/
$config['logo_shop_config']['upload_path']            = "media/shop/logos";
$config['logo_shop_config']['upload_path_temp']       = $config['img_dir_temp'];
$config['logo_shop_config']['allowed_types']          = 'jpg|jpeg|png';
$config['logo_shop_config']['max_size']               = 5240;#KB//10MB
$config['logo_shop_config']['min_width']              = 180;#px
$config['logo_shop_config']['min_height']             = 180;#px
$config['logo_shop_config']['max_width']              = 5000;#px
$config['logo_shop_config']['max_height']             = 5000;#px
$config['logo_shop_config']['encrypt_name']           = true;
$config['cloud_logo_shop_config']['upload_path']      = '/public_html/media/shop/logos/';
$config['logo_shop_config']['cloud_server_show_path'] = DOMAIN_CLOUDSERVER . $config['logo_shop_config']['upload_path'];

/*-----------config image library link ---------------*/
$config['library_link_config']['upload_path']            = "media/custom_link";// + thêm folder /Y/m/d
$config['library_link_config']['upload_path_temp']       = $config['img_dir_temp'];
$config['library_link_config']['allowed_types']          = 'jpg|jpeg|png|gif|mp4';
$config['library_link_config']['max_size']               = 50240;#KB//10MB
$config['library_link_config']['min_width']              = 300;#px
$config['library_link_config']['min_height']             = 150;#px
$config['library_link_config']['max_width']              = 5000;#px
$config['library_link_config']['max_height']             = 5000;#px
$config['library_link_config']['encrypt_name']           = true;
$config['cloud_library_link_config']['upload_path']      = '/public_html/media/custom_link/';// + thêm folder /Y/m/d
$config['library_link_config']['cloud_server_show_path'] = DOMAIN_CLOUDSERVER . $config['library_link_config']['upload_path'];

/*config common url*/
$config['icon_path']            = DOMAIN_CLOUDSERVER . 'media/icons/';
$config['video_path']           = DOMAIN_CLOUDSERVER . 'video/';
$config['video_thumb']          = DOMAIN_CLOUDSERVER . 'video/thumbnail/';
$config['image_path_content']   = DOMAIN_CLOUDSERVER . 'media/images/content/';
$config['audio_path']           = DOMAIN_CLOUDSERVER . 'media/musics/';

?>
