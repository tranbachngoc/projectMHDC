<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// domain use api
$config['config_domain_api'] = link_get_token;
$config['config_domain_file'] = DOMAIN_CLOUDSERVER;
define('DOMAIN_CLOUDSERVER_PATH', DOMAIN_CLOUDSERVER . 'tmp/');


// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// ------------------*****PATH API COMMON*****-----------------------------
// UPLOAD MEDIA------------------------------------------------------------
$config['url']['common']['url_check_tmp_file_exist'] = 'upload_media.php?act=check-tmp-file-exist';

$config['url']['common']['url_check_tmp_video_file_exist'] = 'check-tmp-video-file-exist';

$config['url']['common']['url_copy_content_file'] = 'upload_media.php?act=copy';
/**
 * IMAGE
 * @image: type file
 * @crop: type file
 */

$config['url']['common']['up_image'] = 'upload_media.php?act=upload-image-content';
/**
 * IMAGE
 * @image: type file
 * @crop: type file
 */
$config['url']['common']['up_audio'] = 'upload_media.php?act=upload-audio-content';
/**
 * VIDEO
 * @video: type file
 */
$config['url']['common']['up_video'] = 'upload_media.php?act=upload-video-content';
/**
 * CLONE FILE
 * @files[]: path_file
 */
$config['url']['common']['clone_file'] = 'upload_media.php?act=dupicate-custom-link-file-to-tmp';
// REVIEW LINK-------------------------------------------------------------
$config['url']['common']['review_link'] = 'link-preview?link={$url_link}';
// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// path API CONTENT
/**
 * DELETE CONTENT BY ID
 */
$config['url']['content']['delete_by_id'] = 'content/delete/{$content_id}';
/**
 * SUGGEST FRIENDS AND SHOPS
 */
$config['url']['content']['suggest_in_newsfeed'] = 'suggestion/suggestions';
/**
 * SUGGEST FRIEND BY ID
 */
$config['url']['content']['remove_suggest_friend_in_newsfeed'] = 'suggestion/block-friends';
/**
 * SUGGEST SHOP BY ID
 */
$config['url']['content']['remove_suggest_shop_in_newsfeed'] = 'suggestion/block-shops';
/**
 * LOAD DATA SUGGEST MORE
 */
// FRIEND
$config['url']['content']['suggest_list_friends'] = 'suggestion/list-friends';
// MUTUAL FRIENDS
$config['url']['content']['suggest_list_mutual_friends'] = 'suggestion/list-mutual-friends';
// SHOPS AND SHOPS HAVE MANY FOLLOWS
$config['url']['content']['suggest_list_shop_follow'] = 'suggestion/list-shop-follow';
/**
 * USER ADD FRIEND
 */
$config['url']['content']['send_request_add_friend'] = 'add-friend/{$user_id}';
$config['url']['content']['cancel_request_add_friend'] = 'delete-request-friend/{$user_id}';
/**
 * USER FOLLOW SHOP
 */
// FOLLOW AND CANCEL FOLLOW
$config['url']['content']['follow_shop'] = 'follow/shop/{$shop_id}';
// ƯU TIÊN FOLLOW
$config['url']['content']['follow_shop_priority'] = 'follow/shop/{$shop_id}/change-priority';

/**
 * GET ICONS
 */
$config['url']['content']['icons'] = 'get-icons';

// ------------------------------------------------------------------------

// ------------------------------------------------------------------------
// path API collection
/**
 * GET DATA CATEGORY COLLECTION LINK & LINK
 */
$config['url']['collection']['common_get_category_link_get'] = 'category-links';
/**
 * GET DATA COLLECTION LINK
 * |SHOP||PERSON| $user_id : user id
 * |SHOP||PERSON| $last_id : id collection
 */
$config['url']['collection']['link_get'] = 'user/{$user_id}/shop-collections-of-links?last_id={$last_id}';
$config['url']['collection']['link_mini_get'] = 'me/link-collections';
$config['url']['collection_p']['link_get'] = 'user/{$user_id}/personal-collections-of-links?last_id={$last_id}';
/**
 * GET DATA DETAIL COLLECTION LINK
 * |SHOP||PERSON| $id : user id
 * |SHOP||PERSON| $id_collection : id collection
 * |SHOP||PERSON| $last_created_at : 0 || string date
 */
$config['url']['collection']['link_detail_get'] = 'user/{$id}/collection-links/{$id_collection}?last_created_at={$create_at}';
/**
 * CREATE DATA COLLECTION LINK
 * |SHOP||PERSON| : $data : type array
 * key: collection[name]                value: string
 * key: collection[description]         value: string
 * key: collection[avatar_path]         value: path avatar
 * key: collection[img_width]           value: string
 * key: collection[img_height]          value: string
 * key: collection[mime]                value: mine image
 * key: collection[orientation]         value: 0 / 90 / 270
 * key: collection[isPublic]            value: 0/private || 1/public
 * key: collection[is_personal]         value: 0/doanh nghiệp || 1/cá nhân
 * key: collection[cate_id]             value: id category
 */
$config['url']['collection']['link_create_post'] = 'link/collection/save';
/**
 * EDIT DATA COLLECTION LINK
 * |SHOP||PERSON| : $data : type array
 * $collection_id: id collection
 * key: collection[name]                value: string
 * key: collection[description]         value: string
 * key: collection[avatar_path]         value: path avatar
 * key: collection[img_width]           value: string
 * key: collection[img_height]          value: string
 * key: collection[mime]                value: mine image
 * key: collection[orientation]         value: 0 / 90 / 270
 * key: collection[isPublic]            value: 0/private || 1/public
 * key: collection[is_personal]         value: 0/doanh nghiệp || 1/cá nhân
 * key: collection[cate_id]             value: id category
 */
$config['url']['collection']['link_edit_post'] = 'link/collection/save/{$collection_id}';
/**
 * CREATE DATA NEW LINK
 * key: lib_link[link]                  value: string
 * key: lib_link[title]                 value: string
 * key: lib_link[description]           value: string
 * key: lib_link[collection][]          value: array() int
 * key: lib_link[cate_link_id]          value: int
 * key: lib_link[image]                 value: string / have value when change avatar link
 * key: lib_link[video]                 value: string / have value when change avatar link
 * key: lib_link[orientation]           value: 0 / 90 / 270
 * key: lib_link[mime]                  value: string image/type
 * key: lib_link[img_width]             value: int
 * key: lib_link[img_height]            value: int
 * key: lib_link[is_personal]           value: 0/doanh nghiệp || 1/cá nhân
 * key: lib_link[is_public]             value: 0/private || 1/public
 */
$config['url']['link']['create_post'] = 'link/lib/add';
/**
 * GET DATA LINK
 * {$type}          value: content || content-image || lib
 * {$link_id}       value: int
 */
$config['url']['link']['detail_get'] = 'link/{$type}/detail/{$link_id}';
/**
 * UPDATE LINK DATA LINK
 * {$type}          value: lib || content || image
 * {$link_id}       value: int
 */
$config['url']['link']['update_post'] = 'link/{$type}/save/{$link_id}';
/**
 * DELETE LINK
 */
$config['url']['link']['remove_delete'] = 'link/{$type}/delete/{$link_id}';
/**
 * Thay đổi trạng thái show cửa hàng cá nhân
 */
$config['url']['shop_person']['change_show_shop_person'] = 'me/save-storetab';



// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ----------------------------- URL full API -----------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ---------------------*****COMMON API*****-------------------------------
// UP MEDIA----------------------------------------------------------------
// --------IMAGE[SHOP-PERSON]----------------------------------------------
$config['api_check_tmp_file_exist'] = $config['config_domain_file'] . $config['url']['common']['url_check_tmp_file_exist'];

$config['api_check_tmp_video_file_exist'] = SERVER_OPTIMIZE_URL . $config['url']['common']['url_check_tmp_video_file_exist'];

$config['api_copy_content_file'] = $config['config_domain_file'] . $config['url']['common']['url_copy_content_file'];

$config['api_common_image_post'] = $config['config_domain_file'] . $config['url']['common']['up_image'];
// --------IMAGE[SHOP-PERSON]----------------------------------------------
$config['api_common_audio_post'] = $config['config_domain_file'] . $config['url']['common']['up_audio'];
// --------VIDEO[SHOP-PERSON]----------------------------------------------
$config['api_common_video_post'] = $config['config_domain_file'] . $config['url']['common']['up_video'];
// --------CLONE[SHOP-PERSON]----------------------------------------------
$config['api_common_clone_file'] = $config['config_domain_file'] . $config['url']['common']['clone_file'];
// GET META DATA LINK------------------------------------------------------
$config['api_common_review_link'] = $config['config_domain_api'] . $config['url']['common']['review_link'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ---------------------*****CONTENT API*****------------------------------
// DELETE CONTENT----------------------------------------------------------
$config['api_content_delete_by_id'] = $config['config_domain_api'] . $config['url']['content']['delete_by_id'];
// SUGGEST IN NEWSFEED-----------------------------------------------------
$config['api_suggest_in_newsfeed'] = $config['config_domain_api'] . $config['url']['content']['suggest_in_newsfeed'];
// REMOVE SUGGEST FRIEND IN NEWSFEED---------------------------------------
$config['api_remove_suggest_friend_in_newsfeed'] = $config['config_domain_api'] . $config['url']['content']['remove_suggest_friend_in_newsfeed'];
// REMOVE SUGGEST SHOP IN NEWSFEED-----------------------------------------
$config['api_remove_suggest_shop_in_newsfeed'] = $config['config_domain_api'] . $config['url']['content']['remove_suggest_shop_in_newsfeed'];
// LOAD DATA SUGGEST FRIEND-----------------------------------------
$config['api_load_suggest_friend'] = $config['config_domain_api'] . $config['url']['content']['suggest_list_friends'];
// LOAD DATA SUGGEST MUTUAL FRIENDS-----------------------------------------
$config['api_load_suggest_mutual_friends'] = $config['config_domain_api'] . $config['url']['content']['suggest_list_mutual_friends'];
// LOAD DATA SUGGEST SHOPS AND SHOPS HAVE MANY FOLLOWS---------------------
$config['api_load_suggest_shop_follow'] = $config['config_domain_api'] . $config['url']['content']['suggest_list_shop_follow'];
// SEND REQUEST FRIEND-----------------------------------------------------
$config['api_send_request_add_friend'] = $config['config_domain_api'] . $config['url']['content']['send_request_add_friend'];
// CANCEL REQUEST FRIEND---------------------------------------------------
$config['api_send_request_cancel_friend'] = $config['config_domain_api'] . $config['url']['content']['cancel_request_add_friend'];
// FOLLOW/CANCEL FOLLOW SHOP-----------------------------------------------
$config['api_follow_shop_or_cancel'] = $config['config_domain_api'] . $config['url']['content']['follow_shop'];
// GET ICONS -----------------------------------------------------
$config['api_get_icons'] = $config['config_domain_api'] . $config['url']['content']['icons'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ---------------------*****COLLECTION API*****---------------------------
// NEW LINK----------------------------------------------------------------
// --------GET LINK--------------------------------------------------------
$config['api_link_get'] = $config['config_domain_api'] . $config['url']['link']['detail_get'];
// --------CREATE LINK-----------------------------------------------------
$config['api_link_create'] = $config['config_domain_api'] . $config['url']['link']['create_post'];
// --------UPDATE LINK-----------------------------------------------------
$config['api_link_update'] = $config['config_domain_api'] . $config['url']['link']['update_post'];
// --------DELETE LINK-----------------------------------------------------
$config['api_link_delete'] = $config['config_domain_api'] . $config['url']['link']['remove_delete'];
// COLLECTION LINK---------------------------------------------------------
// ---------------GET CATEGORY LINK + COLLECTION LINK[SHOP-PERSON]---------
$config['api_category_link_get'] = $config['config_domain_api'] . $config['url']['collection']['common_get_category_link_get'];
// ---------------GET ALL COLLECTION LINK[SHOP]----------------------------
$config['api_collection_link_get'] = $config['config_domain_api'] . $config['url']['collection']['link_get'];
$config['api_collection_link_p_get'] = $config['config_domain_api'] . $config['url']['collection_p']['link_get'];
$config['api_collection_link_mini_get'] = $config['config_domain_api'] . $config['url']['collection']['link_mini_get'];
// ---------------GET DETAIL COLLECTION LINK[SHOP-PERSON]------------------
$config['api_collection_link_detail_get'] = $config['config_domain_api'] . $config['url']['collection']['link_detail_get'];
// ---------------CREATE COLLECTION LINK[SHOP-PERSON]----------------------
$config['api_collection_link_create_post'] = $config['config_domain_api'] . $config['url']['collection']['link_create_post'];
// ---------------EDIT COLLECTION LINK[SHOP-PERSON]------------------------
$config['api_collection_link_edit_post'] = $config['config_domain_api'] . $config['url']['collection']['link_edit_post'];
// USER
// ----CHANGE SHOW/HIDE PERSON SHOP----------------------------------------
$config['api_change_show_person_shop'] = $config['config_domain_api'] . $config['url']['shop_person']['change_show_shop_person'];;
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------

$config['icon_path'] = DOMAIN_CLOUDSERVER. 'media/icons/';


?>