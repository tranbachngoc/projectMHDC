<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
$check_domain = '';//preg_replace('/^(?:([^\.]+)\.)?azibai.*$/', '\1', $_SERVER['HTTP_HOST']);
$route = array();
//load data router
require_once( BASEPATH .'database/DB'. EXT );
$db   =& DB();
switch ($check_domain) {
    case true:
        //set current page is shop

        $query  = $db->query('SELECT * FROM tbtt_domains WHERE `domain` LIKE "%'.$_SERVER["HTTP_HOST"].'%" AND `domain_type` = 1');
        $result = $query->row_object();

        if(!empty($result)) {
            if(!defined('DOMAIN_IS')){
                define('DOMAIN_IS', PERSONAL_DOMAIN);
            }
            $route['default_controller']           = "home/personal/profile";
            $route['news/detail/(:num)(/?)']       = 'home/tintuc/detail/$1/is_personal';// chi tiết tin cá nhân
            $route['news/(\d+)/([a-zA-Z0-9]+)(\/.*)?'] = 'home/tintuc/icons_detail/$1/$2/is_personal';// chi tiết tin cá nhân
            // Trang cá nhân tên miền

            /*---------library link------------*/
            $route['library/links']                      = 'home/personal/library_links';
            $route['library/links/ajax']                 = 'home/personal/library_links';
            $route['custom-links/(:num)']                = 'home/personal/custom_link_detail/$1';
            $route['library/links/([a-zA-Z0-9-]+)']      = 'home/personal/media_link_category/$1';
            $route['library/links/([a-zA-Z0-9-]+)/ajax'] = 'home/personal/media_link_category/$1';
            $route['library-link/upload-media']          = 'home/link/validate_upload_media';

            /***-------chi tiết liên kết------**/
            $route['library-link/(:num)'] = 'home/personal/library_link_detail/$1/library-link';
            $route['content-link/(:num)'] = 'home/personal/library_link_detail/$1/content-link';
            $route['image-link/(:num)']   = 'home/personal/library_link_detail/$1/image-link';
            /***-------end chi tiết liên kết------**/
            
            
            $route['upload_cover']                  = 'home/personal/upload_cover';
            $route['process_cover']                 = 'home/personal/process_cover';
            $route['upload_avatar']                 = 'home/personal/upload_avatar';
            $route['process_avatar']                = 'home/personal/process_avatar';

            

            $route['library/videos(/(videos|news))?'] = 'home/personal/library_videos/$2';
            $route['get_more_news']  = 'home/personal/get_more_news';
            $route['about']          = 'home/personal/about';
            // $route['affiliate-shop/(:any)']           = 'home/personal/affiliate_shop_slash/$1';
            // $route['affiliate-shop']         = 'home/personal/affiliate_shop';
            $route['affiliate-shop']           = 'home/personal/affiliate_shop_v2';
            $route['affiliate-shop/(voucher|product|coupon)?']           = 'home/personal/affiliate_shop_v2/$1';
            $route['affiliate-shop/voucher/type/(:num)']           = 'home/personal/affiliate_shop_v2/voucher/$1';
            $route['affiliate-shop/voucher/search']           = 'home/personal/affiliate_shop_v2_search';
            $route['friends']                = 'home/personal/friends';
            $route['friends/(:any)']                = 'home/personal/friends/$2';
            $route['ajax_status_friend']                = 'home/personal/ajax_status_friend';
            $route['ajax_poplist_user']                = 'home/personal/ajax_poplist_user';
            $route['search-user']                = 'home/personal/search_api';
            $route['list-search-user']                = 'home/personal/list_search';

            $route['profile/ajax_status_friend']        = 'home/personal/ajax_status_friend';
            // $route['share-content-page/(:num)']         = 'home/share/show_content_has_share/$1';

            $route['about']                = 'home/personal/information';
            $route['profile/edit_info_user']                = 'home/personal/edit_info_user';
            $route['profile/edit_maritals_user']                = 'home/personal/edit_maritals_user';
            $route['profile/edit_detail_user']                = 'home/personal/edit_detail_user';
            $route['profile/add_jobs_user']                = 'home/personal/add_jobs_user';
            $route['profile/edit_jobs_user']                = 'home/personal/edit_jobs_user';
            $route['profile/get_jobs_user']                = 'home/personal/get_jobs_user';
            $route['profile/delete_jobs_user']                = 'home/personal/delete_jobs_user';


            $route['library/images(/relation_images/(:num)/(:num))?'] = 'home/personal/library_images/$2/$3';
            $route['library/images/view-album/(:num)']                = 'home/personal/detail_album_image/$1';

            /*--------------ajax album personal-----------------------*/
            $route['library/album-image/(create|update)?']     = 'home/personal/ajax_process_album_image/$1';
            $route['library/album-image/load-img-lib']         = 'home/personal/ajax_pop_load_image_lib';
            $route['library/album-image/off-set']              = 'home/personal/ajax_set_album_to_top';
            $route['library/album-image/delete-album']         = 'home/personal/ajax_delete_album';
            $route['library/album-image/getInfoAlbum']         = 'home/personal/ajax_get_info_album';
            $route['library/album-image/openPopupGhim']        = 'home/personal/ajax_openPopupGhim';
            $route['library/album-image/action-pin-to-album']  = 'home/personal/ajax_pin_to_album';
            $route['library/album-image/remove-item-library']  = 'home/personal/ajax_remove_file';
            $route['library/album-image/upImage']              = 'home/personal/ajax_up_file';
            /*--------------END ajax album personal-----------------------*/


            # Affiliate Service
            $route['affiliate']                = 'home/personal/affiliate';
            $route['affiliate/list']                = 'home/personal/affiliatelist';
            $route['affiliate/coupons']                = 'home/personal/affiliatecoupons';
            $route['affiliate/user']                = 'home/personal/getAffilateUser';
            $route['affiliate/select']                = 'home/personal/affiliateselect';
            $route['affiliate/selectcoupons']                = 'home/personal/affiliateselectcoupons';
            $route['affiliate/order']                = 'home/personal/affiliateOrder';
            $route['profile/affiliate/addservice']                = 'home/personal/ajaxAddAffiliate';
            $route['profile/affiliate/editlevel']                = 'home/personal/ajaxEditAffiliate';
            $route['profile/affiliate/getservice']                = 'home/personal/ajaxGetService';
            $route['profile/affiliate/editservice']                = 'home/personal/ajaxEditService';
            $route['affiliate/user/(:num)']     =  'home/personal/detailAffilateUser/$1';
            $route['profile/affiliate/deleteservice']                = 'home/personal/ajaxDeleteService';
            $route['account/updateprofile'] = 'home/user/updateprofile';
            $route['resume/(:num)/(:any)'] = 'home/user/viewresume/$1'; 
            $route['profile/(:num)/(:any)'] = 'home/user/viewprofile/$1';
            $route['account/collection.*'] = 'home/account/collection';

            // ------------------------------------------------------------------------
            // -------------------------COLLECTION V2-------------------------------------
            // ------------------------------------------------------------------------
            $route['collection/link']                       = 'home/personal/collection_link_v2';
            $route['collection/link/(:num)']                = 'home/personal/collection_link_detail_v2/$2';

        }else {
            if(!defined('DOMAIN_IS')){
                define('DOMAIN_IS', SHOP_DOMAIN);
            }
            $route['default_controller']    = "home/shop/home_page";
            ################# Media ############################
            $route['library/images(/relation_images/(:num)/(:num))?'] = 'home/shop/media_images/$2/$3'; // list all images shop
            $route['library/images/view-album/(:num)']                = 'home/shop/detail_album_image/$1';
            $route['library/videos(/(videos|news))?']                 = 'home/shop/media_videos/$2'; // list all images shop
            $route['library/products']                                = 'home/shop/media_products';
            $route['library/coupons']                                 = 'home/shop/media_products/' . COUPON_TYPE;
            $route['library/vouchers']                                = 'home/shop/media_vouchers';
            $route['library/vouchers/type/(0|1)?']                    = 'home/shop/media_vouchers_type/$1';
            $route['library/vouchers/search']                         = 'home/shop/media_vouchers_search';
            $route['library/vouchers/(:num)']                         = 'home/shop/media_vouchers_show_product/$1';

            $route['branch']                                          = 'home/shop/branch';

            $route['library/links']                                   = 'home/shop/media_links';
            $route['library/links/ajax']                              = 'home/shop/media_links';
            $route['library/links/([a-zA-Z0-9-]+)/ajax']              = 'home/shop/media_link_category/$1';
            $route['library/links/([a-zA-Z0-9-]+)']                   = 'home/shop/media_link_category/$1';
            $route['custom-links/(:num)']                             = 'home/shop/custom_link_detail/$1';

            /***-------chi tiết liên kết------**/
            $route['library-link/(:num)']         = 'home/shop/library_link_detail/$1/library-link';
            $route['content-link/(:num)']         = 'home/shop/library_link_detail/$1/content-link';
            $route['image-link/(:num)']           = 'home/shop/library_link_detail/$1/image-link';
            /***-------end chi tiết liên kết------**/

            /*--------------ajax album shop-----------------------*/
            $route['library/album-image/(create|update)?']     = 'home/shop/ajax_process_album_image/$1';
            $route['library/album-image/load-img-lib']                = 'home/shop/ajax_pop_load_image_lib';
            $route['library/album-image/off-set']                     = 'home/shop/ajax_set_album_to_top';
            $route['library/album-image/delete-album']                = 'home/shop/ajax_delete_album';
            $route['library/album-image/getInfoAlbum']                = 'home/shop/ajax_get_info_album';
            $route['library/album-image/openPopupGhim']               = 'home/shop/ajax_openPopupGhim';
            $route['library/album-image/action-pin-to-album']         = 'home/shop/ajax_pin_to_album';
            $route['library/album-image/remove-item-library']         = 'home/shop/ajax_remove_file';
            $route['library/album-image/upImage']                     = 'home/shop/ajax_up_file';

            ################# DOMAINSHOP.COM SHOP-AFFILIATE###################
            $route['affiliate-shop']             = 'home/shop/myshop_builded/affiliate-shop'; // Home page af product
            $route['affiliate-shop/product']               = 'home/shop/myshop_builded/product'; // Category
            $route['affiliate-shop/coupon']               = 'home/shop/myshop_builded/coupon'; // Category

        }
        $route['ajax_district']                = 'home/personal/ajax_district';
        $route['load_more_news']        = "home/shop/home_page";//ajax load more news
        $route['detect/server_info']    = 'home/shop/info_s';

        $route['collection/my-collections']      = 'home/collection/my_collections';

        $route['login'] = 'home/login';
        //        $route['login'] = 'home/login/login_user';
        $route['logout'] = 'home/login/logout';
        $route['forgot'] = 'home/forgot';
        $route['forgot/reset/key/(:any)/token/(:any)'] = 'home/forgot/reset/$1/$2';
        //SEO
        $route['gianhang'] = 'home/shop';
        $route['gianhang/sort.*'] = 'home/shop';
        $route['gianhang/page.*'] = 'home/shop';
        $route['category/(:num)'] = 'home/shop/category/$1';
        $route['category/(:num)/sort.*'] = 'home/shop/category/$1';
        $route['category/(:num)/page.*'] = 'home/shop/category/$1';
        //SEO
        $route['gianhang/(:num)/(:any)'] = 'home/shop/category/$1';
        $route['gianhang/(:num)/(:any)/sort.*'] = 'home/shop/category/$1';
        $route['gianhang/(:num)/(:any)/page.*'] = 'home/shop/category/$1';
        $route['shop/saleoff.*'] = 'home/shop/saleoff';
        $route['shop/ajax'] = 'home/shop/ajax';
        $route['page-not-found'] = 'home/notfound/index';
       
        // Content
        $route['content/(:num)'] = 'home/content';
        $route['content/(:num)/page'] = 'home/content';
        $route['content/(:num)/page/(:num)'] = 'home/content';
        // News
        $route['news/category-1'] = 'home/content/news_1';
        $route['news/category-2'] = 'home/content/news_2';
        $route['news/category-3'] = 'home/content/news_3';
        // Pay ment
        $route['payment'] = 'home/payment';
        $route['payment/(:num)'] = 'home/payment';
        $route['payment/addWallet'] = 'home/payment/addWallet';
        $route['payment/addWallet/payment_nl'] = 'home/payment/payment_nl';
        $route['payment/addWallet/nganluong_success/(:num)'] = 'home/payment/nganluong_success/$1';
        $route['payment/addWallet/nganluong_cancel/(:num)'] = 'home/payment/nganluong_cancel/$1';
        $route['payment/loadAddWallet'] = 'home/payment/loadAddWallet';
        $route['payment/addWalletSubmit'] = 'home/payment/addWalletSubmit';
        $route['payment/addWalletSuccess'] = 'home/payment/addWalletSuccess';
        $route['payment/addWalletSuccess/(:num)'] = 'home/payment/addWalletSuccess/$1';

        // checkout new
        $route['v-checkout'] = 'home/checkout/product';
        $route['v-checkout/coupon'] = 'home/checkout/coupon';
        $route['v-checkout/delete-all-qty'] = 'home/checkout/delete_all_qty';
        $route['v-checkout/order-temp'] = 'home/checkout/order_temp';
        $route['v-checkout/order-address'] = 'home/checkout/order_address';
        $route['v-checkout/get-district'] = 'home/checkout/get_district';
        $route['v-checkout/order'] = 'home/checkout/order';
        $route['v-checkout/shipping'] = 'home/checkout/shipping';
        $route['v-checkout/place-order'] = 'home/checkout/place_order';
        $route['v-checkout/orders-notify'] = 'home/checkout/orders_notify';
        $route['v-checkout/list-voucher'] = 'home/checkout/list_voucher';
        $route['v-checkout/get-voucher'] = 'home/checkout/get_voucher';
        $route['v-checkout/remove-voucher'] = 'home/checkout/remove_voucher';
        

         //testOrder
        $route['order-cancel'] = 'home/showcart/cancelOrders';
        $route['order-cancel/(:num)'] = 'home/showcart/cancelOrders/$1';
        $route['order-cancel-user/(:num)'] = 'home/showcart/cancelOrdersUser/$1';
        //Showcart        
        $route['showcart/add.*'] = 'home/showcart/add';        
        $route['showcart.*'] = 'home/showcart';
        $route['payment/nganluong_success/(:any)'] = 'home/product/nganluong_success/$1';
        $route['payment/nganluong_cancle/(:any)'] = 'home/product/nganluong_cancle/$1';
        $route['showcart/order_cart'] = 'home/showcart/order_cart';
        $route['showcart/shipfee'] = 'home/showcart/shipfee';
        $route['showcart/getPromotion'] = 'home/showcart/getPromotion';
        $route['showcart/update_qty'] = 'home/showcart/updateQty';
        $route['showcart/shipping_fee'] = 'home/showcart/shippingFee';
        $route['showcart/place_order'] = 'home/showcart/placeOrder';
        $route['showcart/place_order_v2'] = 'home/showcart/placeOrderv2';
        $route['showcart/delete'] = 'home/showcart/delete';
        $route['checkout'] = 'home/showcart/checkout';
        $route['showcat/district'] = 'home/showcart/get_district';
        $route['checkout/(:num)/:any'] = 'home/showcart/shop/$1';
        $route['checkout/v2/(:num)/(:any)'] = 'home/showcart/shopv2/$1/$2';
        $route['orders-success/(:num)'] = 'home/showcart/ordersSuccess/$1';
        $route['orders-error/(:num)'] = 'home/showcart/ordersError/$1';
        $route['information-order'] = 'home/showcart/checkOrders';
        $route['not-found-order/(:num)/(:any)'] = 'home/showcart/notFoundOrders/$1/$2';
        $route['information-order/(:num)'] = 'home/showcart/checkOrders/$1';
        $route['print-order'] = 'home/showcart/printOrders';
        $route['print-order/(:num)'] = 'home/showcart/printOrders/$1';
        $route['test-order'] = 'home/showcart/testOrder';
        $route['ajax/action/(:any)'] = 'home/ajax/action/$1';        
        $route['news/danh-sach-chon-tin/(:num)/(:any)'] = 'home/shop/danhsachchon/$1';
        $route['domain'] = 'home/shop/domain';
        // Content
        $route['administ/content/(search|filter|sort|page|status).*'] = 'administ/content';
        $route['administ/content/add'] = 'administ/content/add';
        $route['administ/content/edit/(:num)'] = 'administ/content/edit/$1';
        $route['administ/shop/ajax_category_shop'] = 'administ/shop/ajax_category_shop';
        // Xem hoa hong va doanh so
        $route['administ/commission.*'] = 'administ/commission/commiss';
        $route['administ/revenue.*'] = 'administ/commission/revenue';
        $route['tintuc/comment'] = 'home/tintuc/comment';
        $route['news/comment'] = 'home/shop/comment';
        /*--------------ajax upload banner, logo shop-----------------------*/
        $route['shop/update/banner']      = 'home/shop/upload_banner';
        $route['shop/update/banner_save'] = 'home/shop/process_banner';
        $route['shop/update/logo']        = 'home/shop/upload_logo';
        $route['shop/update/logo_save']   = 'home/shop/process_logo';
        /*--------------/end ajax upload banner, logo shop-----------------------*/
        $route['share/ajax_showtin']       = "home/share/ajax_showtin";
        $route['share/ajax_showproduct']       = "home/share/ajax_showproduct";
        $route['share/get_avatarShare']                = 'home/share/get_avatarShare';
        $route['share/add_avatarShare']                = 'home/share/add_avatarShare';
        $route['share/update_avatarShare']                = 'home/share/update_avatarShare';
        $route['share/delete_avatarShare']                = 'home/share/delete_avatarShare';

        $route['share/api_share_content']        = 'home/share/api_share_content';
        $route['share/api_share_images']        = 'home/share/api_share_images';
        $route['share/api_share_videos']        = 'home/share/api_share_videos';
        $route['share/api_share_links']        = 'home/share/api_share_links';
        $route['share/api_share_collections']        = 'home/share/api_share_collections';
        $route['share/api_push_share']        = 'home/share/api_push_share';

        /**
         * page search intermediate
         */
        $route['share-content-page/(:num)']         = 'home/share/show_content_has_share/$1';
        // ------------------------------------------------------------------------

        /*---------bookmark------------*/
        $route['bookmarks']                     = 'home/bookmark';
        $route['bookmarks/create']              = 'home/bookmark/create';// ko có edit, xóa tạo mới
        $route['bookmarks/(:num)/delete']       = 'home/bookmark/destroy/$1';// ko có edit, xóa tạo mới
        /*---------end bookmark------------*/

        /*---------link new-------------------*/

        /***-------get info liên kết------**/
        $route['library-link/info-link/(:num)']  = 'home/link/info_link/$1/library-link';
        $route['content-link/info-link/(:num)']  = 'home/link/info_link/$1/content-link';
        $route['image-link/info-link/(:num)']    = 'home/link/info_link/$1/image-link';
        /***-------end get info liên kết------**/

        

        $route['links/create']                  = 'home/link/create';
        $route['library-link/upload-media']     = 'home/link/validate_upload_media';

        /***-------update liên kết------**/
        $route['library-link/update']            = 'home/link/update/library-link';
        $route['content-link/update']            = 'home/link/update/content-link';
        $route['image-link/update']              = 'home/link/update/image-link';
        /***-------end update liên kết------**/


        /***-------xóa liên kết------**/
        /*chỉ ẩn trong library*/
        $route['library-link/(:num)/delete']     = 'home/link/destroy/$1/library-link';
        $route['content-link/(:num)/delete']     = 'home/link/destroy/$1/content-link';
        $route['image-link/(:num)/delete']       = 'home/link/destroy/$1/image-link';

        /*xóa khỏi db*/
        $route['library-link/(:num)/remove']     = 'home/link/destroy/$1/library-link/true';
        $route['content-link/(:num)/remove']     = 'home/link/destroy/$1/content-link/true';
        $route['image-link/(:num)/remove']       = 'home/link/destroy/$1/image-link/true';

        /***-------clone liên kết------**/
        $route['library-link/clone/(:num)']      = 'home/link/clone_link/$1/library-link';
        $route['content-link/clone/(:num)']      = 'home/link/clone_link/$1/content-link';
        $route['image-link/clone/(:num)']        = 'home/link/clone_link/$1/image-link';
        $route['library-link/save-clone/(:num)'] = 'home/link/save_clone/$1';
        /***-------end clone liên kết------**/

        
        /*--------------ajax custom links shop-----------------------*/
        $route['custom-link/category-child']      = 'home/custom_link/ajax_load_child_categories_link';
        /*--------------/end ajax custom links shop-----------------------*/

        //view detail item
        $route['library/view/node/(:any)/(:num)']   = 'home/shop/media_view_node/$1/$2'; // View detail node

        ################# DOMAINSHOP.COM NEWS###################
        $route['/']                           = 'home/shop/myshop_design1';
        $route['like/content'] = 'home/like/ajax_like_content';
        $route['like/info'] = 'home/like/ajax_like_info';
        $route['like/image'] = 'home/like/ajax_like_image';
        $route['like/active_like_image'] = 'home/like/active_like_image';
        $route['like/info-image'] = 'home/like/ajax_like_info_image';
        $route['like/video'] = 'home/like/ajax_like_video';
        $route['like/active_like_video'] = 'home/like/active_like_video';
        $route['like/info-video'] = 'home/like/ajax_like_info_video';
        $route['like/link'] = 'home/like/ajax_like_link';
        $route['like/active_like_link'] = 'home/like/active_like_link';
        $route['like/info-link'] = 'home/like/ajax_like_info_link';
        $route['like/service'] = 'home/like/ajax_like_service';
        $route['like/info-service'] = 'home/like/ajax_like_info_service';
        $route['follow/user'] = 'home/follow/ajax_follow_user';
        $route['confirmfollow/user'] = 'home/follow/ajax_confirmfollow_user';
        $route['cancelfollow/user'] = 'home/follow/ajax_cancelfollow_user';
        $route['follow/shop'] = 'home/follow/ajax_follow_shop';
        $route['follow/follow-profile'] = 'home/follow/ajax_follow_profile';
        $route['follow/cancel-follow-profile'] = 'home/follow/ajax_cancel_follow_profile';
        $route['follow/follow-shop'] = 'home/follow/ajax_follow_shop';
        $route['follow/cancel-follow-shop'] = 'home/follow/ajax_cancel_follow_shop';
        $route['follow/blockfriend-profile'] = 'home/follow/ajax_blockfriend_profile';
        $route['follow/cancelblock-profile'] = 'home/follow/ajax_cancel_blockfriend_profile';
        $route['follow/priority-profile'] = 'home/follow/ajax_priofollow_profile';
        $route['follow/cancelpriority-profile'] = 'home/follow/ajax_cancel_priofollow_profile';

        $route['news']                        = 'home/shop/myshop_design1';
        $route['news/page.*']                 = 'home/shop/myshop_design1';
        $route['news/detail/(\d+)(/.*)?']     = 'home/tintuc/detail/$1';
        $route['news/(\d+)/([a-zA-Z0-9]+)(\/.*)?'] = 'home/tintuc/icons_detail/$1/$2';
        //News
        $route['news/category/(:num)/(:any)'] = 'home/shop/myshop_design1';
        $route['news/view']                   = 'home/shop/myshop_design1';
        $route['news/hot']                    = 'home/shop/myshop_design1';
        $route['news/promotion']              = 'home/shop/myshop_design1';
        $route['news/tin-chon-ve']            = 'home/shop/myshop_design1';
        $route['news/tin-duoc-chon']          = 'home/shop/myshop_design1';

        #Map routes add news home to shop, branch to url shop #

        $route['tintuc/addnewshome']    = "home/tintuc/addNewsHome";
        $route['tintuc/addnewsp']       = "home/tintuc/addNewsPerson";
        $route['tintuc/getproducthome'] = "home/tintuc/getListProduct";
        $route['tintuc/geticons']       = "home/tintuc/getListIcons";
        $route['tintuc/preview']        = "home/tintuc/preView";
        $route['tintuc/previewp']       = "home/tintuc/preViewPerson";
        $route['tintuc/runImg']         = "home/tintuc/runImg";
        $route['tintuc/editnewhome/(:num)'] = "home/tintuc/editNewsHome/$1";
        $route['product/getProPreview'] = "home/product/getProPreview";
        $route['tintuc/getDetailImg']   = "home/tintuc/getDetailImg";
        $route['tintuc/linkinfo']       = "home/tintuc/getLinkInfomation";
        $route['product/getProChoose']  = "home/product/getProChoose";
        $route['addimage']              = "home/tintuc/addImage";
        $route['addimagenotthumb']      = "home/tintuc/addImageNotThumb";
        $route['deleteimage']           = "home/tintuc/deleteImage";
        $route['addvideo']              = "home/tintuc/addVideo";
        $route['deletevideo']           = "home/tintuc/deleteVideo";
        $route['getvideo']              = "home/tintuc/getVideo";
        $route['tintuc/getcustomlink']  = "home/tintuc/getCustomlink";
        $route['tintuc/editcustomlink']  = "home/tintuc/editCustomlink";
        $route['tintuc/deltecustomlink']  = "home/tintuc/deleteCustomlink";
        $route['tintuc/getcategoriesnewshome']  = "home/tintuc/getListCategoriesNews";
        $route['tintuc/listimageslider'] = "home/tintuc/getListImageSlider";
        $route['tintuc/listeffectslider'] = "home/tintuc/getListEffectSlider";
        $route['tintuc/listaudioslider'] = "home/tintuc/getListAudioSlider";
        
        ################# DOMAINSHOP.COM SHOP###################
        //new
        $route['shop']                       = 'home/shop/myshop_builded'; // Home page product
        $route['like/product'] = 'home/like/ajax_like_product';
        $route['shop/product']               = 'home/shop/myshop_builded/product'; // Category
        $route['shop/coupon']                = 'home/shop/myshop_builded/coupon';
        $route['shop/voucher']                = 'home/shop/myshop_builded/voucher';
        $route['shop/product/(:any)/page.*'] = 'home/shop/slash_product';//Sort, pagination
        $route['shop/product/cat/(:any)']    = 'home/shop/slash_product';
        $route['shop/coupon/cat/(:any)']     = 'home/shop/slash_product';

        // $route['shop/introduct']      = 'home/shop/myshop_design1'; // Gioi thieu ban cu
        $route['shop/introduct']        = 'home/shop/introduct'; // Gioi thieu
        $route['shop/edit_introduct']        = 'home/shop/edit_introduct';
        $route['shop/edit_contact']        = 'home/shop/edit_contact';
        $route['shop/edit_timework']        = 'home/shop/edit_timework';
        $route['shop/add_team']        = 'home/shop/add_team';
        $route['shop/update_team']        = 'home/shop/update_team';
        $route['shop/delete_team']        = 'home/shop/delete_team';
        $route['shop/info_team']        = 'home/shop/info_team';
        $route['shop/add_certify']        = 'home/shop/add_certify';
        $route['shop/update_certify']        = 'home/shop/update_certify';
        $route['shop/delete_certify']        = 'home/shop/delete_certify';
        $route['shop/info_certify']        = 'home/shop/info_certify';
        $route['shop/add_customer']        = 'home/shop/add_customer';
        $route['shop/update_customer']        = 'home/shop/update_customer';
        $route['shop/delete_customer']        = 'home/shop/delete_customer';
        $route['shop/info_customer']        = 'home/shop/info_customer';
        $route['shop/add_activities']        = 'home/shop/add_activities';
        $route['shop/update_activities']        = 'home/shop/update_activities';
        $route['shop/delete_activities']        = 'home/shop/delete_activities';
        $route['shop/info_activities']        = 'home/shop/info_activities';
        
        $route['shop/contact']        = 'home/shop/myshop_design1'; // Lien he
        $route['map']                 = 'home/shop/myshop_design1';
        $route['company_profile']     = 'home/shop/myshop_design1';
        $route['certificate']         = 'home/shop/myshop_design1';
        $route['trade_capacity']      = 'home/shop/myshop_design1';
        $route['shop/warranty']       = 'home/shop/myshop_design1'; // Chinh sach

        $route['shop/services']              = 'home/shop/shopServices';
        $route['shop/afproduct']             = 'home/shop/myshop_design1';
        $route['shop/afservices']            = 'home/shop/myshop_design1';
        $route['shop/afcoupon']              = 'home/shop/myshop_design1';
        $route['shop/san-pham-tu-gian-hang'] = 'home/shop/myshop_design1';//san pham gian hang
        $route['shop/dich-vu-tu-gian-hang']  = 'home/shop/myshop_design1';//dich vu gian hang
        $route['shop/coupon-tu-gian-hang']   = 'home/shop/myshop_design1';//coupon gian hang
        $route['shop/services/cat/(:any)']   = 'home/shop/myshop_design1';
        $route['shop/afproduct/cat/(:any)']  = 'home/shop/myshop_design1';
        $route['shop/afservices/cat/(:any)'] = 'home/shop/myshop_design1';
        $route['shop/afcoupon/cat/(:any)']   = 'home/shop/myshop_design1';

        $route['shop/services/(:any)/page.*']              = 'home/shop/myshop_design1';
        $route['shop/coupon/(:any)/page.*']                = 'home/shop/myshop_design1';
        $route['shop/afproduct/(:any)/page.*']             = 'home/shop/myshop_design1';
        $route['shop/afservices/(:any)/page.*']            = 'home/shop/myshop_design1';
        $route['shop/afcoupon/(:any)/page.*']              = 'home/shop/myshop_design1';
        $route['shop/san-pham-tu-gian-hang/(:any)']        = 'home/shop/myshop_design1';
        $route['shop/san-pham-tu-gian-hang/(:any)/page.*'] = 'home/shop/myshop_design1';
        $route['shop/dich-vu-tu-gian-hang/(:any)/page.*']  = 'home/shop/myshop_design1';
        $route['shop/coupon-tu-gian-hang/(:any)/page.*']   = 'home/shop/myshop_design1';
        $route['shop/afproduct/pro_type/(:any)']           = 'home/shop/myshop_design1';
        $route['shop/afservices/pro_type/(:any)']          = 'home/shop/myshop_design1';
        $route['shop/afcoupon/pro_type/(:any)']            = 'home/shop/myshop_design1';
        $route['shop/afproduct/pro_type/(:any)/page.*']    = 'home/shop/myshop_design1';
        $route['shop/afservices/pro_type/(:any)/page.*']   = 'home/shop/myshop_design1';
        $route['shop/afcoupon/pro_type/(:any)/page.*']     = 'home/shop/myshop_design1';
        $route['shop/product/detail/(:num)/(:any)']        = 'home/shop/myshop_design1';//Detail product
        $route['shop/services/detail/(:num)/(:any)']       = 'home/shop/myshop_design1';
        $route['shop/coupon/detail/(:num)/(:any)']         = 'home/shop/myshop_design1';

        ########################DOMAINSHOP.COM/SHOP SERVICE###############
        $route['shop/service']                            = 'home/shop/shopServices';
        $route['shop/service/detail/(:num)']              = 'home/shop/shopServicesDetail/$1';
        $route['shop/service/notify']              = 'home/shop/shopServicesSuccess';
        $route['shop/service/up-package']              = 'home/shop/upPackage';
        $route['shop/service/cancel-notify']              = 'home/shop/shopCancelNotify';

        ########################DOMAINSHOP.COM/AFFLINK NEWS###############
        //$route['([a-z0-9_-])+'] = 'home/shop/myshop_design2'; // Not use
        $route['([a-z0-9_-])+/news'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/news/detail/(:num)/(:any)'] = 'home/shop/myshop_design2';
        
        ################DOMAINSHOP.COM/AFFLINK NEWS#######################
        $route['([a-z0-9_-])+/shop'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/introduct'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/contact'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/map'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/company_profile'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/certificate'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/trade_capacity'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/warranty'] = 'home/shop/myshop_design2'; 
        # Detail product
        $route['([a-z0-9_-])+/shop/product/detail/(:num)/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services/detail/(:num)/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon/detail/(:num)/(:any)'] = 'home/shop/myshop_design2'; 
        $route['([a-z0-9_-])+/shop/san-pham-tu-gian-hang'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/san-pham-tu-gian-hang.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/dich-vu-tu-gian-hang'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon-tu-gian-hang'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afproduct/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afservices/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afcoupon/cat/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afproduct/pro_type/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afcoupon/pro_type/(:any)'] = 'home/shop/myshop_design2';

        $route['([a-z0-9_-])+/shop/product'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon'] = 'home/shop/myshop_design2';

        $route['([a-z0-9_-])+/shop/product/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon/(:any)/page.*'] = 'home/shop/myshop_design2';       
        $route['([a-z0-9_-])+/shop/afproduct/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afservices/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afcoupon/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/san-pham-tu-gian-hang/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/dich-vu-tu-gian-hang/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon-tu-gian-hang/(:any)/page.*'] = 'home/shop/myshop_design2';

        $route['([a-z0-9_-])+/shop/san-pham-tu-gian-hang/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/dich-vu-tu-gian-hang/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon-tu-gian-hang/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/services/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/coupon/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afproduct/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afservices/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afcoupon/cat/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afproduct/pro_type/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/afcoupon/pro_type/(:any)/page.*'] = 'home/shop/myshop_design2';    
        
        $route['([a-z0-9_-])+/shop/product/sort.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/page.*'] = 'home/shop/myshop_design2'; 
        $route['([a-z0-9_-])+/shop/detail/(:num)/(:any)'] = 'home/shop/myshop_design2';       
        $route['([a-z0-9_-])+/shop/product/cat/(:num)/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/cat/(:num)/(:any)/sort.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/cat/(:num)/(:any)/page.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/pro_type/(:num)/(:any)'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/pro_type/(:num)/(:any)/sort.*'] = 'home/shop/myshop_design2';
        $route['([a-z0-9_-])+/shop/product/pro_type/(:num)/(:any)/page.*'] = 'home/shop/myshop_design2';
        ##################################################################
        // Group news
        $route['grtnews'] = 'home/grouptrade/my_group_trade';
        $route['grtnews/page.*'] = 'home/grouptrade/my_group_trade';
        
        $route['grtnews/detail/(:num)/(:any)'] = 'home/grouptrade/my_group_trade';
        $route['grtnews/members'] = 'home/grouptrade/my_group_trade';        
        $route['grtnews/landing_page'] = 'home/grouptrade/my_group_trade';             
        $route['grtnews/search.*'] = 'home/grouptrade/my_group_trade';             
        // Group product
        $route['grtshop'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/introduction'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/contact'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/warranty'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/product'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/coupon'] = 'home/grouptrade/my_group_trade';        
        $route['grtshop/product/detail/(:num)/(:any)'] = 'home/grouptrade/my_group_trade';    
        $route['grtshop/coupon/detail/(:num)/(:any)'] = 'home/grouptrade/my_group_trade';      
        $route['grtshop/search.*'] = 'home/grouptrade/my_group_trade';      
         
        $route['grtshop/product/cat/(:any)'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/product/cat/(:any)/page/(:num)'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/coupon/cat/(:any)'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/coupon/cat/(:any)/page/(:num)'] = 'home/grouptrade/my_group_trade';

        $route['grtshop/product/pro_type/(:any)'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/product/pro_type/(:any)/page/(:num)'] = 'home/grouptrade/my_group_trade';
        $route['grtshop/coupon/pro_type/(:any)'] = 'home/grouptrade/my_group_trade'; 
        $route['grtshop/coupon/pro_type/(:any)/page/(:num)'] = 'home/grouptrade/my_group_trade';
        
        $route['grtshop/favorites.*'] = 'home/grouptrade/my_group_trade'; 
        
        // flatform	
        $route['flatform/login'] = 'home/login';
        $route['flatform/contact'] = 'home/flatform/contact';
        $route['flatform/about'] = 'home/flatform/about';
	
        $route['flatform'] = 'home/flatform/news';        	
        $route['flatform/news'] = 'home/flatform/news';        	
	    $route['flatform/news/(:num)/(:any)'] = 'home/flatform/detail/$1'; 
        $route['flatform/news/search.*'] = 'home/flatform/searchnews';
	    $route['flatform/news/hot'] = 'home/flatform/news';    
	    $route['flatform/news/sale'] = 'home/flatform/news';    
	    $route['flatform/news/view'] = 'home/flatform/news';    
	    $route['flatform/news/comment'] = 'home/flatform/comment';
	
        $route['flatform/product'] = 'home/flatform/products';
        $route['flatform/product/cat/(:num)/(:any)'] = 'home/flatform/cat_pro/$1';
        $route['flatform/product/(:num)/(:any)'] = 'home/flatform/product/$1';
        $route['flatform/favorite_pro'] = 'home/flatform/favorite_pro';
        $route['flatform/favorite_pro/(:any)'] = 'home/flatform/favorite_pro';
	
        $route['flatform/coupon'] = 'home/flatform/coupons';
        $route['flatform/coupon/cat/(:num)/(:any)'] = 'home/flatform/cat_cou/$1';
        $route['flatform/coupon/(:num)/(:any)'] = 'home/flatform/coupon/$1';
        $route['flatform/favorite_cou'] = 'home/flatform/favorite_cou';
        $route['flatform/favorite_cou/(:any)'] = 'home/flatform/favorite_cou';

        # Affiliate shop
        $route['affiliate/news'] = 'home/shop/affiliate_shop';
        $route['affiliate/news.*'] = 'home/shop/affiliate_shop';

        $route['affiliate/product'] = 'home/shop/affiliate_shop';
        $route['affiliate/coupon'] = 'home/shop/affiliate_shop';

        $route['affiliate/product/(:any)'] = 'home/shop/affiliate_shop';//        
        $route['affiliate/coupon/(:any)'] = 'home/shop/affiliate_shop';//

        $route['affiliate/product/detail/(:num)/(:any)'] = 'home/shop/affiliate_detail/$1';
        $route['affiliate/coupon/detail/(:num)/(:any)'] = 'home/shop/affiliate_detail/$1';

        $route['affiliate/checkout'] = 'home/shop/affiliate_shop';
        $route['affiliate/checkout_order/(:num)/(:any)'] = 'home/shop/affiliate_shop/$1';

        $route['affiliate/showcart/add'] = 'home/showcart/add';
        $route['affiliate/showcart/delete'] = 'home/showcart/delete';
        $route['affiliate/showcart/update_qty'] = 'home/showcart/updateQty';
        $route['affiliate/showcart/shipping_fee'] = 'home/showcart/shippingFee';


        $route['affiliate/orderv0/(:num)/(:any)'] = 'home/shop/affiliate_shop';
        $route['affiliate/orderv2/(:num)/(:any)'] = 'home/shop/affiliate_shop';

        //Collection
        $route['collection/ajax_createCollection']                                 = 'home/shop/ajax_createCollection';
        $route['collection/ajax_createCollectionContent/(:num)/(:num)']            = 'home/shop/ajax_createCollectionContent/$1/$2';
        $route['collection/ajax_loadCollection/(:num)/(:num)']                     = 'home/shop/ajax_loadCollection/$1/$2';
        $route['collection/ajax_createCollection_choose']                          = 'home/shop/ajax_createCollection_choose';
        $route['collection/ajax_updateCollection_choose']                          = 'home/shop/ajax_updateCollection_choose';
        $route['collection/ajax_deleteCollection_choose']                          = 'home/shop/ajax_deleteCollection_choose';
        $route['collection/ajax_Save_CustomLink_Collection']                       = 'home/shop/ajax_Save_CustomLink_Collection';
        $route['collection/ajax_Update_CustomLink_Collection']                     = 'home/shop/ajax_Update_CustomLink_Collection';
        $route['collection/ajax_loadAll_Collection_CheckExist_Node/(:num)/(:num)'] = 'home/shop/ajax_loadAll_Collection_CheckExist_Node/$1/$2';

        $route['shop/collection/all']                            = 'home/shop/showCollectionAll';
        $route['shop/collection']                                = 'home/shop/showCollection';
        $route['shop/collection/select/(:num)']                  = 'home/shop/detailCollection/$1';
        // $route['shop/collection-link']                           = 'home/shop/showCollectionLink';
        // $route['shop/collection-link/select/(:num)']             = 'home/shop/detailCollectionLink/$1';
        // $route['shop/collection-link/select/(:num)/view/(:num)'] = 'home/shop/viewNodeCollectionLink/$1/$2';//không có banner + menu horizontal
        $route['shop/collection-product']                        = 'home/shop/showCollectionProduct';
        $route['shop/collection-product/select/(:num)']          = 'home/shop/detailCollectionProduct/$1';
        $route['shop/collection-coupon']                         = 'home/shop/showCollectionCoupon';
        $route['shop/collection-coupon/select/(:num)']           = 'home/shop/detailCollectionProduct/$1';

        // ------------------------------------------------------------------------
        // -------------------------COLLECTION V2-------------------------------------
        // ------------------------------------------------------------------------
        $route['shop/collection-link']                           = 'home/shop/collection_link_v2';
        $route['shop/collection-link/select/(:num)']             = 'home/shop/collection_link_detail_v2/$1';



        $route['quick-view/(:num)'] = 'home/tintuc/quick_view/$1';

        $route['(:num)/(:num)/(:any)'] = 'home/product/detail_product/$2'; // chi tiet sp
        $route['(:num)/(:any)'] = 'home/market/product_category/$1/$2'; // tat ca sp/cp theo category
        $route['(:num)/(:any)/(:num)'] = 'home/market/product_category/$1/$2/$3'; // tat ca sp/
        $route['report'] = 'home/report/index';
        $route['report/report_pro'] = 'home/report/report_pro';


    	break;
        
    default:
        //set current page is
        if(!defined('DOMAIN_IS')){
            $current_url    = (!empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];
            $profile_regex  = domain_site . '\/profile\/[a-zA-Z0-9\-\_\.]+';
            if(preg_match('/^'.$profile_regex.'/', $current_url)){
                define('DOMAIN_IS', PERSONAL_DOMAIN);
            }else{
                define('DOMAIN_IS', AZIBAI_DOMAIN);
            }
        }
        /**
         * Seach on azibai
         */
        $route['search']                            = 'home/search/search_all';
        $route['search-all-auto']                   = 'home/search/search_autocomplete';
        $route['search-article']                    = 'home/search/search_article';
        $route['search-personal']                   = 'home/search/search_personal';
        $route['search-company']                    = 'home/search/search_company';
        $route['search-image']                      = 'home/search/search_image';
        // ------------------------------------------------------------------------

        /**
         * page search intermediate
         */
        $route['share-content-page/(:num)']         = 'home/share/show_content_has_share/$1';
        // ------------------------------------------------------------------------

        //trình duyệt "links" azibai
        $route['links']                             = 'home/link';
        $route['links/ajax']                        = 'home/link';
        $route['links/links-common/(:num)']         = 'home/link/links_common/$1';
        /*clone link*/
        $route['links/content-link/clone/(:num)']   = 'home/link/clone_link/$1/content-link';
        $route['links/image-link/clone/(:num)']     = 'home/link/clone_link/$1/image-link';
        $route['links/library-link/clone/(:num)']   = 'home/link/clone_link/$1/library-link';
        $route['links/library-link/save-clone']     = 'home/link/save_clone';
        /*end clone link*/
        /*detail link*/
        $route['links/content-link/(:num)']         = 'home/link/show/$1/content-link';
        $route['links/image-link/(:num)']           = 'home/link/show/$1/image-link';
        $route['links/library-link/(:num)']         = 'home/link/show/$1/library-link';
        /*end detail link*/
        /*category link*/
        $route['links/([a-zA-Z0-9-]+)']             = 'home/link/link_category/$1';
        $route['links/([a-zA-Z0-9-]+)/ajax']        = 'home/link/link_category/$1';
        $route['links/convert_min_max']             = 'home/link/convert_min_max';
        /*end category link*/

        $route['comment/(:num)']                    = 'home/comment/loadCommnet/$1';
        $route['comment/addcomment/(:num)']         = 'home/comment/AjaxAddCommnet/$1';
        $route['comment/loadcomment/(:num)']        = 'home/comment/AjaxLoadCommnet/$1';
        $route['comment/loadcommentimage/(:num)']   = 'home/comment/AjaxLoadListImage/$1';
        $route['comment/getcategories/(:num)']      = 'home/comment/AjaxGetCategory/$1';
        $route['comment/getcategorieschild/(:num)'] = 'home/comment/AjaxGetCategoryChild/$1';
        $route['comment/getproduct/(:num)']         = 'home/comment/AjaxGetProduct/$1';
        $route['comment/getlinks']                  = 'home/comment/AjaxGetLinks';

        $route['conver-avatar-user/(:num)']         = 'home/personal/convert_avatar_new/$1';
        $route['conver-cover-user/(:num)']          = 'home/personal/convert_cover_new/$1';
        $route['share/ajax_showtin']       = "home/share/ajax_showtin";
        $route['share/ajax_showproduct']       = "home/share/ajax_showproduct";
        $route['share/get_avatarShare']                = 'home/share/get_avatarShare';
        $route['share/add_avatarShare']                = 'home/share/add_avatarShare';
        $route['share/update_avatarShare']                = 'home/share/update_avatarShare';
        $route['share/delete_avatarShare']                = 'home/share/delete_avatarShare';
        
        $route['share/api_share_content']        = 'home/share/api_share_content';
        $route['share/api_share_images']        = 'home/share/api_share_images';
        $route['share/api_share_videos']        = 'home/share/api_share_videos';
        $route['share/api_share_links']        = 'home/share/api_share_links';
        $route['share/api_share_collections']        = 'home/share/api_share_collections';
        $route['share/api_push_share']        = 'home/share/api_push_share';

         //Build Ecommerce
        $route['shop'] = 'home/market/ecommerce';
        $route['shop/products'] = 'home/market/ecommerce/products';
        $route['shop/coupons'] = 'home/market/ecommerce/coupons';

        // $route['(:num)/(:any)'] = 'home/product/category/$1';
        $route['(:num)/(:num)/(:any)'] = 'home/product/detail_product/$2'; // chi tiet sp
        $route['(:num)/(:any)'] = 'home/market/product_category/$1/$2'; // tat ca sp/cp theo category
        $route['(:num)/(:any)/(:num)'] = 'home/market/product_category/$1/$2/$3'; // tat ca sp/cp theo category + pagination
        $route['voucher/(:num)/(:num)'] = 'home/market/voucher_detail/$1/$2';
        $route['report'] = 'home/report/index';
        $route['report/report_pro'] = 'home/report/report_pro';
        
        //End
        $route['detect/server_info'] = 'home/shop/info_s';
        $route['like/content'] = 'home/like/ajax_like_content';
        $route['like/info'] = 'home/like/ajax_like_info';
        $route['like/link'] = 'home/like/ajax_like_link';
        $route['like/active_like_link'] = 'home/like/active_like_link';
        $route['like/info-link'] = 'home/like/ajax_like_info_link';
        $route['like/service'] = 'home/like/ajax_like_service';
        $route['like/info-service'] = 'home/like/ajax_like_info_service';
        $route['follow/user'] = 'home/follow/ajax_follow_user';
        $route['confirmfollow/user'] = 'home/follow/ajax_confirmfollow_user';
        $route['cancelfollow/user'] = 'home/follow/ajax_cancelfollow_user';
        $route['follow/blockfriend-profile'] = 'home/follow/ajax_blockfriend_profile';
        $route['follow/cancelblock-profile'] = 'home/follow/ajax_cancel_blockfriend_profile';
        $route['deletefollow/user'] = 'home/follow/ajax_deletefollow_user';
        $route['removefollow/user'] = 'home/follow/ajax_removefollow_user';
        $route['follow/user-profile'] = 'home/follow/ajax_follow_user_profile';
        $route['follow/follow-profile'] = 'home/follow/ajax_follow_profile';
        $route['follow/cancel-follow-profile'] = 'home/follow/ajax_cancel_follow_profile';
        $route['follow/follow-shop'] = 'home/follow/ajax_follow_shop';
        $route['follow/cancel-follow-shop'] = 'home/follow/ajax_cancel_follow_shop';
        $route['follow/priority-profile'] = 'home/follow/ajax_priofollow_profile';
        $route['follow/cancelpriority-profile'] = 'home/follow/ajax_cancel_priofollow_profile';

        //News
        $route['default_controller']                                         = "home/tintuc";//Controller default
        $route['profile/([a-zA-Z0-9\-\_\.]+)/news/detail/(:num)(/.*)?']      = 'home/tintuc/detail/$2/is_personal';// chi tiết tin cá nhân
        $route['profile/([a-zA-Z0-9\-\_\.]+)/news/(\d+)/([a-zA-Z0-9]+)(\/.*)?'] = 'home/tintuc/icons_detail/$2/$3/is_personal';// chi tiết tin cá nhân
        $route['tintuc/detail/(\d+)(/.*)?']                                  = 'home/tintuc/detail/$1';
        $route['news/(\d+)/([a-zA-Z0-9]+)(\/.*)?']                           = 'home/tintuc/icons_detail/$1/$2';
        $route['tintuc/category/(:num)/(:any)']                              = 'home/tintuc/index/category/$1';
        $route['tintuc/search.*']                                            = 'home/tintuc/search';
        $route['tintuc/addnewshome']                                         = "home/tintuc/addNewsHome";
        $route['tintuc/addnewsp']                                            = "home/tintuc/addNewsPerson";
        $route['tintuc/getproducthome']                                      = "home/tintuc/getListProduct";
        $route['tintuc/geticons']                                            = "home/tintuc/getListIcons";
        $route['tintuc/getcategoriesnewshome']                               = "home/tintuc/getListCategoriesNews";
        $route['tintuc/preview']                                             = "home/tintuc/preView";
        $route['tintuc/previewp']                                            = "home/tintuc/preViewPerson";
        $route['tintuc/runImg']                                              = "home/tintuc/runImg";
        $route['tintuc/editnewhome/(:num)']                                  = "home/tintuc/editNewsHome/$1";
        $route['tintuc/getDetailImg']                                        = "home/tintuc/getDetailImg";
        $route['addimage']              = "home/tintuc/addImage";
        $route['addimagenotthumb']      = "home/tintuc/addImageNotThumb";
        $route['deleteimage']           = "home/tintuc/deleteImage";
        $route['addvideo']              = "home/tintuc/addVideo";
        $route['deletevideo']           = "home/tintuc/deleteVideo";
        $route['getvideo']              = "home/tintuc/getVideo";
        $route['tintuc/getcustomlink']  = "home/tintuc/getCustomlink";
        $route['tintuc/deletecustomlink']  = "home/tintuc/deleteCustomlink";
        $route['tintuc/editcustomlink']  = "home/tintuc/editCustomlink";
        $route['tintuc/getcategoriesnewshome']                           = "home/tintuc/getListCategoriesNews";
        //        $route['tintuc.*']                                               = 'home/tintuc';

        /*--------------ajax custom links shop-----------------------*/
        $route['custom-link/category-child']    = 'home/custom_link/ajax_load_child_categories_link';
        /*--------------/end ajax custom links shop-----------------------*/

        //End News

        $route['menus']                                                  = "home/menus";
        $route['like/product'] = 'home/like/ajax_like_product';
        $route['like/infopro'] = 'home/like/ajax_like_info_product';
        $route['like/image'] = 'home/like/ajax_like_image';
        $route['like/active_like_image'] = 'home/like/active_like_image';
        $route['like/info-image'] = 'home/like/ajax_like_info_image';
        $route['like/video'] = 'home/like/ajax_like_video';
        $route['like/active_like_video'] = 'home/like/active_like_video';
        $route['like/info-video'] = 'home/like/ajax_like_info_video';
        $route['product/getProPreview'] = "home/product/getProPreview";
        $route['product/getProChoose'] = "home/product/getProChoose";
        $route['product/add/(:num)'] = 'home/product/addProduct/$1';
        $route['coupon/add/(:num)'] = 'home/product/addCoupon/$1';
        $route['product/ajaxAddGallegy'] = 'home/product/ajaxAddGallegy';
        $route['product/gallegy/(:num)/(:any)'] = 'home/product/gallegy/$1';
        $route['like/gallery'] = 'home/like/ajax_like_gallery';
        $route['like/active_like_gallery'] = 'home/like/active_like_gallery';
        $route['like/info-gallery'] = 'home/like/ajax_like_info_gallery';
        $route['product/view/(:num)'] = 'home/product/detail_product/$1';
        $route['product/ajaxAdd'] = 'home/product/ajaxAddProduct';
        $route['product/edit/(:num)/(:any)'] = 'home/product/editProduct/$1';
        $route['coupon/edit/(:num)/(:any)'] = 'home/product/editProduct/$1';
        $route['product/ajaxEdit/(:num)'] = 'home/product/ajaxEditProduct/$1';
        $route['tintuc/linkinfo'] = "home/tintuc/getLinkInfomation";
        $route['tintuc/listimageslider'] = "home/tintuc/getListImageSlider";
        $route['tintuc/listeffectslider'] = "home/tintuc/getListEffectSlider";
        $route['tintuc/listaudioslider'] = "home/tintuc/getListAudioSlider";
        // $route['shop'] = "home/defaults";
        // $route['shop/products.*'] = "home/defaults/products_home";
        // $route['shop/services.*'] = "home/defaults/services_home";
        // $route['shop/coupons.*'] = "home/defaults/coupons_home";
        //Content
        //        $route['content.*'] = 'home/content';

        $route['save-province'] = "home/defaults/storeSessionProvince";
        $route['bieuphisanpham.*'] = "home/defaults/CatBieuphi";
        $route['scaffolding_trigger'] = "";
        #END Route Default
        #BEGIN: Administ
        //Default PHUC
        $route['administ'] = 'administ/defaults';
        $route['newsletter'] = 'home/account/newsletter';

        //Category
        $route['administ/category-links']           = 'administ/category_link';
        $route['administ/category-links/create']    = 'administ/category_link/create';
        //        $route['administ/category/edit/(:num)'] = 'administ/category/edit/$1';


        // admin-azibai
        $route['azi-admin']           = 'azi-admin/login';
        $route['azi-admin/logout']    = 'azi-admin/logout';

        $route['azi-admin/notifications']  = 'azi-admin/notifications/index';
        $route['azi-admin/notifications/(:num)']  = 'azi-admin/notifications/index/$1';

        $route['azi-admin/notifications/business-news']  = 'azi-admin/notifications/business_news';
        $route['azi-admin/notifications/business-news/(:num)']  = 'azi-admin/notifications/business_news/$1';

        $route['azi-admin/notifications/personal-news']  = 'azi-admin/notifications/personal_news';
        $route['azi-admin/notifications/personal-news/(:num)']  = 'azi-admin/notifications/personal_news/$1';

        
        $route['azi-admin/notifications/get-notification/(:num)']  = 'azi-admin/notifications/get_notification/$1';
        $route['azi-admin/notifications/push-news/(:num)']  = 'azi-admin/notifications/push_news/$1';
        $route['azi-admin/notifications/delete/(:num)']          = 'azi-admin/notifications/delete/$1';

        $route['azi-admin/notifications/links']          = 'azi-admin/notifications/links';
        $route['azi-admin/notifications/links/(:num)']          = 'azi-admin/notifications/links/$1';
        $route['azi-admin/notifications/get_catchild_link']          = 'azi-admin/notifications/get_catchild_link';
        $route['azi-admin/notifications/push-links/(:any)/(:num)']  = 'azi-admin/notifications/push_links/$1/$2';
        $route['azi-admin/notifications/get-notification-link/(:any)/(:num)']  = 'azi-admin/notifications/get_notification_link/$1/$2';
        $route['azi-admin/notifications/delete-link/(:num)']          = 'azi-admin/notifications/delete_link/$1';

        $route['azi-admin/notifications/general/page_push']          = 'azi-admin/notifications/page_push';
        // $route['azi-admin/notifications/general/edit/(:num)']          = 'azi-admin/notifications/edit/$1';
        $route['azi-admin/notifications/general/push']          = 'azi-admin/notifications/push';
        $route['azi-admin/notifications/general/delete/(:num)']          = 'azi-admin/notifications/delete_push/$1';

        $route['azi-admin/notifications/list-user']          = 'azi-admin/notifications/list_user';
        $route['azi-admin/notifications/list-user/(:num)']          = 'azi-admin/notifications/list_user/$1';
        $route['azi-admin/notifications/change-status-user']          = 'azi-admin/notifications/change_status_user';
        $route['azi-admin/notifications/block-news']          = 'azi-admin/notifications/push_block_news';

        // Admin Entertainment Link
        $route['azi-admin/entertainment-link']  = 'azi-admin/EntertainmentLink/getList';
        $route['azi-admin/entertainment-link/(:num)']  = 'azi-admin/EntertainmentLink/getList/$1';
        $route['azi-admin/entertainment-link/search']  = 'azi-admin/EntertainmentLink/search';
        $route['azi-admin/entertainment-link/search/(:num)']  = 'azi-admin/EntertainmentLink/search/$1';
        $route['azi-admin/entertainment-link/get-by-id/(:num)']  = 'azi-admin/EntertainmentLink/getById/$1';
        $route['azi-admin/entertainment-link/add']  = 'azi-admin/EntertainmentLink/add';
        $route['azi-admin/entertainment-link/edit/(:num)']  = 'azi-admin/EntertainmentLink/edit/$1';
        $route['azi-admin/entertainment-link/delete/(:num)']  = 'azi-admin/EntertainmentLink/deleteById/$1';
        $route['azi-admin/entertainment-link/multi-delete']  = 'azi-admin/EntertainmentLink/multiDelete';
        $route['azi-admin/entertainment-link/change-status/(:num)']  = 'azi-admin/EntertainmentLink/changeStatusById/$1';
        $route['azi-admin/entertainment-link/multi-change-status']  = 'azi-admin/EntertainmentLink/multiChangeStatus';

        $route['azi-admin/entertainment-link/get-link-preview']  = 'azi-admin/EntertainmentLink/getLinkPreview';

        $route['azi-admin/entertainment-link/add-link']  = 'azi-admin/EntertainmentLink/addLink';
        $route['azi-admin/listtransfer']     = 'azi-admin/Money/index';
        $route['azi-admin/listtransfer/(:num)']     = 'azi-admin/Money/index/$1';
        $route['azi-admin/listlog/(:num)']          = 'azi-admin/Money/ajaxGetLogs/$1';
        $route['azi-admin/updatestatus/(:num)']     = 'azi-admin/Money/ajaxUpdateStatus/$1';

        //UpTin
        $route['adv/(:num)'] = 'home/defaults/adv_click/$1';
        $route['administ/uptin/thongke'] = 'administ/uptin/thongke';
        $route['administ/uptin/thongkedondatnaptien'] = 'administ/uptin/thongkedondatnaptien';
        $route['administ/uptin/xoathongkedondatnaptien'] = 'administ/uptin/xoathongkedondatnaptien';
        $route['administ/uptin/naptientudondat.*'] = 'administ/uptin/naptientudondat';
        $route['administ/uptin/xoagiaodich'] = 'administ/uptin/xoagiaodich';
        $route['administ/uptin/naptien'] = 'administ/uptin/naptien';
        $route['administ/uptin/suanaptien'] = 'administ/uptin/suanaptien';
        $route['administ/uptin/check_username/([a-zA-Z0-9_-]+)'] = 'administ/uptin/check_username/$1';
        $route['administ/uptin/ajax_update_naptien'] = 'administ/uptin/ajax_update_naptien';
        $route['administ/uptin/giaup'] = 'administ/uptin/giaup';

        $route['administ/ctcategory/(search|filter|sort|page|status).*'] = 'administ/ctcategory';
        $route['administ/ctcategory/add'] = 'administ/ctcategory/add';
        $route['administ/ctcategory/edit/(:num)'] = 'administ/ctcategory/edit/$1';
        $route['administ/ctcategory/ajax'] = 'administ/ctcategory/ajax';

        $route['administ/content/(search|filter|sort|page|status).*'] = 'administ/content';
        $route['administ/content/add'] = 'administ/content/add';
        $route['administ/content/edit/(:num)'] = 'administ/content/edit/$1';
        $route['administ/content/ajax_category_content'] = 'administ/content/ajax_category_content';
        $route['administ/cttintuc/add'] = 'administ/ctcategory/addcttintuc';
        $route['administ/cttintuc/edit/(:num)'] = 'administ/ctcategory/editttintuc/$1';

        $route['administ/commission.*'] = 'administ/commission/commiss';
        $route['administ/revenue.*'] = 'administ/commission/revenue';
        $route['administ/ttcategory'] = 'administ/ctcategory/cttintuc';
        $route['administ/ttcategory/(search|filter|sort|page|status).*'] = 'administ/ctcategory/cttintuc';
        $route['administ/ttcategory/add'] = 'administ/ctcategory/addcttintuc';
        $route['administ/ttcategory/edit/(:num)'] = 'administ/ctcategory/editttintuc/$1';
        $route['administ/tintuc/(search|filter|sort|page|status|paid).*'] = 'administ/content/tintuc';
        $route['administ/tintuc'] = 'administ/content/tintuc';
        $route['administ/tintuc/add'] = 'administ/content/addtintuc';
        $route['administ/edittintuc/(:num)'] = 'administ/content/edittintuc/$1';

        $route['administ/chcategory'] = 'administ/ctcategory/ctcohoi';
        $route['administ/chcategory/(search|filter|sort|page|status).*'] = 'administ/ctcategory/ctcohoi';
        $route['administ/chcategory/add'] = 'administ/ctcategory/addctcohoi';
        $route['administ/chcategory/edit/(:num)'] = 'administ/ctcategory/editctcohoi/$1';

        $route['administ/cohoi/(search|filter|sort|page|status).*'] = 'administ/content/cohoi';
        $route['administ/cohoi'] = 'administ/content/cohoi';
        $route['administ/cohoi/add'] = 'administ/content/addcohoi';
        $route['administ/cohoi/edit/(:num)'] = 'administ/content/editcohoi/$1';

        $route['administ/doccategory'] = 'administ/ctcategory/ctdoc';
        $route['administ/doccategory/(search|filter|sort|page|status).*'] = 'administ/ctcategory/ctdoc';
        $route['administ/doccategory/add'] = 'administ/ctcategory/addctdoc';
        $route['administ/doccategory/edit/(:num)'] = 'administ/ctcategory/editctdoc/$1';

        $route['administ/doc/(search|filter|sort|page|status).*'] = 'administ/content/doc';
        $route['administ/doc'] = 'administ/content/doc';
        $route['administ/doc/add'] = 'administ/content/adddoc';
        $route['administ/doc/edit/(:num)'] = 'administ/content/editdoc/$1';

        $route['administ/user/(search|filter|sort|page|status).*'] = 'administ/user';
        $route['administ/user/end/(search|filter|sort|page).*'] = 'administ/user/end';
        $route['administ/user/inactive/(search|filter|sort|page|status).*'] = 'administ/user/inactive';
        $route['administ/user/uprated/(search|filter|sort|page|status).*'] = 'administ/user/uprated';
        $route['administ/user/vip/(search|filter|sort|page|status).*'] = 'administ/user/vip';
        $route['administ/user/vip/end.*'] = 'administ/user/endvip';
        $route['administ/user/saler/(search|filter|sort|page|status).*'] = 'administ/user/saler';
        $route['administ/user/saler/end.*'] = 'administ/user/endsaler';
        $route['administ/user/add'] = 'administ/user/add';
        $route['administ/user/edit/(:num)'] = 'administ/user/edit/$1';
        $route['administ/user/ajax'] = 'administ/user/ajax';
        $route['user/ajax_lien_he'] = 'home/user/ajax_lien_he';
        $route['user/ajax_lien_he/check_username'] = 'home/user/check_username';
        $route['administ/user/developer1/(search|filter|sort|page|status).*'] = 'administ/user/developer1';
        $route['administ/user/developer2/(search|filter|sort|page|status).*'] = 'administ/user/developer2';
        $route['administ/user/partner1/(search|filter|sort|page|status).*'] = 'administ/user/partner1';
        $route['administ/user/partner2/(search|filter|sort|page|status).*'] = 'administ/user/partner2';
        $route['administ/user/coremember/(search|filter|sort|page|status).*'] = 'administ/user/coremember';
        $route['administ/user/shoppremium/(search|filter|sort|page|status).*'] = 'administ/user/shoppremium';
        $route['administ/user/affiliate/(search|filter|sort|page|status).*'] = 'administ/user/affiliate';
        $route['administ/user/shopfree/(search|filter|sort|page|status).*'] = 'administ/user/shopfree';
        $route['administ/user/alluser/(search|filter|sort|page|status).*'] = 'administ/user/alluser';
        $route['administ/user/admin/(search|filter|sort|page|status).*'] = 'administ/user/admin';
        $route['administ/user/allusertree.*'] = 'administ/user/allusertree';

        $route['administ/user/usertree/(:num)/.*'] = 'administ/user/usertree/$1';
        $route['administ/user/usertreetree/(:num)/.*'] = 'administ/user/usertreetree/$1';
        $route['administ/user/liststore/(:num)/.*'] = 'administ/user/liststore/$1';
        $route['administ/user/listaf/(:num)/.*'] = 'administ/user/listaf/$1';


        //Group
        $route['administ/group/(search|filter|sort|page|status).*'] = 'administ/group';
        $route['administ/group/add'] = 'administ/group/add';
        $route['administ/group/edit/(:num)'] = 'administ/group/edit/$1';
        //Category
        $route['administ/category/(search|filter|sort|page|status).*'] = 'administ/category';
        $route['administ/category/add'] = 'administ/category/add';
        $route['administ/category/edit/(:num)'] = 'administ/category/edit/$1';
        //Service
        $route['administ/category/service.*'] = 'administ/category';
        $route['administ/category/service/add'] = 'administ/category/add';
        $route['administ/category/service/edit/(:num)'] = 'administ/category/edit/$1';
        //Coupon
        $route['administ/category/coupon.*'] = 'administ/category';
        $route['administ/category/coupon/add'] = 'administ/category/add';
        $route['administ/category/coupon/edit/(:num)'] = 'administ/category/edit/$1';

        $route['administ/category/fee'] = 'administ/category/fee';
        $route['administ/category/updateFee'] = 'administ/category/updateFee';
        // hoi dap
        $route['administ/hoidap/category/(search|filter|sort|page|status).*'] = 'administ/hoidap/category';
        $route['administ/hoidap/theodoi/(search|filter|sort|page|status).*'] = 'administ/hoidap/theodoi';
        $route['administ/hoidap/traloi/(search|filter|sort|page|status).*'] = 'administ/hoidap/traloi';
        $route['administ/hoidap/cat/add'] = 'administ/hoidap/categoryadd';
        $route['administ/hoidap/cat/edit/(:num)'] = 'administ/hoidap/categoryedit/$1';
        $route['administ/hoidap'] = 'administ/hoidap';
        $route['administ/hoidap/(search|filter|sort|page|status).*'] = 'administ/hoidap';
        $route['administ/hoidap/bad/(search|filter|sort|page|status|detail).*'] = 'administ/hoidap/bad';
        $route['administ/hoidapvipham.*'] = 'administ/hoidap/bad';
        $route['administ/traloivipham.*'] = 'administ/hoidap/traloibad';
        //manufacturer
        $route['administ/manufacturer/(search|filter|sort|page|status).*'] = 'administ/manufacturer';
        $route['administ/manufacturer/add'] = 'administ/manufacturer/add';
        $route['administ/manufacturer/ajax_category_shop'] = 'administ/manufacturer/ajax_category_shop';
        $route['administ/manufacturer/edit/(:num)'] = 'administ/manufacturer/edit/$1';
        //Field
        $route['administ/field/(search|filter|sort|page|status).*'] = 'administ/field';
        $route['administ/field/add'] = 'administ/field/add';
        $route['administ/field/edit/(:num)'] = 'administ/field/edit/$1';
        //Province
        $route['administ/province/(search|filter|sort|page|status).*'] = 'administ/province';
        $route['administ/province/add'] = 'administ/province/add';
        $route['administ/province/edit/(:num)'] = 'administ/province/edit/$1';
        //District
        $route['administ/district/(search|filter|sort|page|status).*'] = 'administ/district';
        $route['administ/district/add'] = 'administ/district/add';
        $route['administ/district/edit/(:num)'] = 'administ/district/edit/$1';
        //Menu
        $route['administ/menu/(search|filter|sort|page|status).*'] = 'administ/menu';
        $route['administ/menu/add'] = 'administ/menu/add';
        $route['administ/menu/edit/(:num)'] = 'administ/menu/edit/$1';
        //Notify
        $route['administ/notify/(search|filter|sort|page|status).*'] = 'administ/notify';
        $route['administ/notify/add'] = 'administ/notify/add';
        $route['administ/notify/edit/(:num)'] = 'administ/notify/edit/$1';
        $route['administ/notify/share/edit/(:num)'] = 'administ/notify/edit/$1';
        $route['administ/notify/share.*'] = 'administ/notify';
        $route['administ/notify/share/add'] = 'administ/notify/add';

        //Contact
        $route['administ/contact'] = 'administ/contact';
        $route['administ/contact/(search|filter|sort|page|status).*'] = 'administ/contact';
        $route['administ/contact/view/(:num)'] = 'administ/contact/view/$1';
        //Reports
        $route['administ/reports/content'] = 'administ/reports';
        $route['administ/reports/content/(search|filter|sort|page).*'] = 'administ/reports';
        $route['administ/reports/content/detail/(:num).*'] = 'administ/reports/rpdetail_content';
        
        $route['administ/reports/product'] = 'administ/reports/report_pro';
        $route['administ/reports/product/(search|filter|sort|page).*'] = 'administ/reports/report_pro';
        $route['administ/reports/product/detail/(:num).*'] = 'administ/reports/rpdetail_pro';
        
        $route['administ/reports/change_rpstatus'] = 'administ/reports/change_rpstatus';
        //Advertise
        $route['administ/advertise/(search|filter|sort|page|status).*'] = 'administ/advertise';
        $route['administ/advertise/end/(search|filter|sort|page).*'] = 'administ/advertise/end';
        $route['administ/advertise/add'] = 'administ/advertise/add';
        $route['administ/advertise/edit/(:num)'] = 'administ/advertise/edit/$1';
        //Advertise Config

        $route['administ/advertiseconfig/add'] = 'administ/advertise/addConfig';
        $route['administ/advertiseconfig/edit/(:num)'] = 'administ/advertise/editConfig/$1';
        $route['administ/advertiseconfig.*'] = 'administ/advertise/listPosition';
        $route['administ/advertise-statistics.*'] = 'administ/advertise/advStatistics';
        //Shop
        $route['administ/shop/(search|filter|sort|page|status|guarantee).*'] = 'administ/shop';
        $route['administ/shop/dambao/.*'] = 'administ/shop/dambao';
        $route['administ/shop/end/(search|filter|sort|page).*'] = 'administ/shop/end';
        $route['administ/shop/noactive/(search|filter|sort|page).*'] = 'administ/shop/noactive';
        $route['administ/shop/all/(search|filter|sort|page).*'] = 'administ/shop/all';
        $route['administ/shop/af.*'] = 'administ/shop/all';
        $route['administ/shop/add'] = 'administ/shop/add';
        $route['administ/shop/kiem_tra_link_shop'] = 'administ/shop/kiem_tra_link_shop';
        $route['administ/shop/edit/(:num)'] = 'administ/shop/edit/$1';
        $route['administ/shop/danhmuc/add'] = 'administ/shop/add_danhmuc';
        $route['administ/shop/danh_muc_ajax'] = 'administ/shop/ajax';
        $route['administ/shop/danhmuc.*'] = 'administ/shop/danh_muc_san_pham';
        $route['administ/shop-danhmuc/edit/(:num)'] = 'administ/shop/edit_danhmuc/$1';
        $route['administ/danhsachsanpham/(:num).*'] = 'administ/shop/danhsachsanpham/$1';        
        $route['administ/branch/all/(search|filter|sort|page).*'] = 'administ/branch/all';
        $route['administ/branch/danhsachsanpham/(:num).*'] = 'administ/branch/danhsachsanpham/$1'; 

        //Product
        $route['administ/product'] = 'administ/product';
        $route['administ/service/product.*'] = 'administ/product';
        $route['administ/coupon/product.*'] = 'administ/product';
        $route['administ/product/anhang.*'] = 'administ/product/anhang';
        $route['administ/product/(search|filter|sort|page|status|vip|admin).*'] = 'administ/product';
        $route['administ/product/bad/(search|filter|sort|page|status|detail).*'] = 'administ/product/bad';
        $route['administ/product/hethang/(search|filter|sort|page|status|detail).*'] = 'administ/product/hethang';
        $route['administ/product/end/(search|filter|sort|page).*'] = 'administ/product/end';
        $route['administ/product/affiliate.*'] = 'administ/product/affiliate';

        //Ads
        $route['administ/ads'] = 'administ/ads';
        $route['administ/ads/(search|filter|sort|page|status|vip).*'] = 'administ/ads';
        $route['administ/ads/bad/(search|filter|sort|page|status|detail).*'] = 'administ/ads/bad';
        $route['administ/ads/end/(search|filter|sort|page).*'] = 'administ/ads/end';
        $route['administ/adscategory'] = 'administ/adscategory';
        $route['administ/adscategory/(search|filter|sort|page|status).*'] = 'administ/adscategory';
        $route['administ/adscategory/add'] = 'administ/adscategory/add';
        $route['administ/adscategory/edit/(:num)'] = 'administ/adscategory/edit/$1';
        //Job
        $route['administ/job/(search|filter|sort|page|status|reliable).*'] = 'administ/job';
        $route['administ/job/bad/(search|filter|sort|page|status|reliable|detail).*'] = 'administ/job/bad';
        $route['administ/job/end/(search|filter|sort|page|reliable).*'] = 'administ/job/end';
        //Employ
        $route['administ/employ/(search|filter|sort|page|status|reliable).*'] = 'administ/employ';
        $route['administ/employ/bad/(search|filter|sort|page|status|reliable|detail).*'] = 'administ/employ/bad';
        $route['administ/employ/end/(search|filter|sort|page|reliable).*'] = 'administ/employ/end';
        //Showcart
        $route['administ/showcart/(search|filter|sort|page).*'] = 'administ/showcart';
        $route['administ/showcart/allorder.*'] = 'administ/showcart/allorder';
        $route['administ/showcart/confirm_order_saler.*'] = 'administ/showcart/confirm_order_saler';
        $route['administ/showcart/confirm_order_checkout.*'] = 'administ/showcart/confirm_order_checkout';
        $route['administ/showcart/news_order_saler.*'] = 'administ/showcart/news_order_saler';
        $route['administ/showcart/pay_order_saler.*'] = 'administ/showcart/pay_order_saler';
        $route['administ/showcart/inprogress_order_saler.*'] = 'administ/showcart/inprogress_order_saler';
        $route['administ/showcart/success_order_saler.*'] = 'administ/showcart/success_order_saler';
        $route['administ/showcart/re_order_saler.*'] = 'administ/showcart/re_order_saler';
        $route['administ/showcart/cancel_order_saler.*'] = 'administ/showcart/cancel_order_saler';
        $route['administ/showcart/done_order_saler.*'] = 'administ/showcart/done_order_saler';
        $route['administ/showcart/refundOrders.*'] = 'administ/showcart/refundOrders';
        $route['administ/showcart/updateStatusRefund'] = 'administ/showcart/updateStatusRefund';
        $route['administ/showcart/normalorder/(search|filter|sort|page).*'] = 'administ/showcart/normalorder';
        $route['administ/showcart/affiliateorder/(search|filter|sort|page).*'] = 'administ/showcart/affiliateorder';
        $route['administ/showcart/detail/(:num)'] = 'administ/showcart/detail/$1';

        //Config
        $route['administ/system/config'] = 'administ/config';
        $route['administ/system/info'] = 'administ/config/info';
        $route['administ/system/payment'] = 'administ/config/payment';
        $route['administ/system/sohapay'] = 'administ/config/sohapay';
        $route['administ/system/config/solution_commission'] = 'administ/config/solution_commission_config';
        $route['administ/system/config/solution_commission/ajax'] = 'administ/config/solution_commission_config_ajax';
        $route['administ/system/config/commission_rate'] = 'administ/config/commissionRate';
        $route['administ/system/config/commission_rate/ajax'] = 'administ/config/ajaxCommissionRate';
        $route['administ/system/config/data'] = 'administ/config/configData';
        $route['administ/system/config/data/ajax'] = 'administ/config/ajaxConfig';

        //Tool
        $route['administ/tool/mail'] = 'administ/tool/mail';
        $route['administ/tool/cache'] = 'administ/tool/cache';
        $route['administ/tool/captcha'] = 'administ/tool/captcha';
        $route['administ/tool/mediamanage'] = 'administ/tool/mediamanage';
        //Unlocked Ip
        $route['administ/tool/unlocked/delete/(:any)'] = 'administ/tool/unlocked_delete/$1';
        $route['administ/tool/unlocked/search/(:any)'] = 'administ/tool/unlocked_search/$1';
        $route['administ/tool/unlocked'] = 'administ/tool/unlocked';
        //Logout
        $route['administ/logout'] = 'administ/logout';

        $route['administ/share'] = 'administ/share/index';
        $route['administ/share/(:num)'] = 'administ/share/index/$1';
        $route['administ/affiliate'] = 'administ/affiliate/index';
        $route['administ/affiliate/(:num)'] = 'administ/affiliate/index/$1';
        $route['administ/affiliate/shop'] = 'administ/affiliate/affiliateShop';
        $route['administ/affiliate/shop/(:num)'] = 'administ/affiliate/affiliateShop/$1';
        $route['administ/affiliate/statistics/(:num).*'] = 'administ/affiliate/statistics/$1';
        $route['administ/affiliate/statistics/(:num)/(:num)'] = 'administ/affiliate/statistics/$1/$2';
        // shop
        $route['administ/shop/statistical.*'] = 'administ/shop/list_shop';
        $route['administ/shop/statistics/(:num).*'] = 'administ/shop/statistical_shop';
        $route['administ/branch/statistical.*'] = 'administ/branch/statistics';    
        $route['administ/branch/statistics/(:num).*'] = 'administ/branch/statistics_detail';    

        $route['administ/service'] = 'administ/service/index';
        $route['administ/service/(:num)'] = 'administ/service/index/$1';
        $route['administ/service/package'] = 'administ/service/package';
        $route['administ/service/package/(:num)'] = 'administ/service/package/$1';

        $route['administ/service/simple'] = 'administ/service/simple';
        $route['administ/service/simple/(:num)'] = 'administ/service/simple/$1';
        $route['administ/service/simple/add'] = 'administ/service/simpleAdd';
        $route['administ/service/simple/edit/(:num)'] = 'administ/service/simpleEdit/$1';
        $route['administ/service/simple/status/([a-z]+)/(:num)'] = 'administ/service/simpleStatus/$1/$2';

        $route['administ/service/daily_service'] = 'administ/service/daily_service';
        $route['administ/service/daily_service/(:num)'] = 'administ/service/daily_service/$1';
        $route['administ/service/daily_service/edit/(:num)'] = 'administ/service/dailyEdit/$1';
        $route['administ/service/daily_service/status/([a-z]+)/(:num)'] = 'administ/service/dailyStatus/$1/$2';

        $route['administ/service/request'] = 'administ/service/request';
        $route['administ/service/paymented'] = 'administ/service/paymented';
        $route['administ/service/using'] = 'administ/service/using';
        $route['administ/service/expiring'] = 'administ/service/expiring';
        $route['administ/service/expired'] = 'administ/service/expired';
        $route['administ/service/cancel'] = 'administ/service/cancel';

        $route['administ/service/add-package'] = 'administ/service/addPackage';
        $route['administ/service/complete-payment'] = 'administ/service/completePayment';
        $route['administ/service/cancel-order'] = 'administ/service/cancelOrder';
        $route['administ/service/start-service'] = 'administ/service/startService';

        $route['administ/service/package/servicelist/(:num)'] = 'administ/service/servicelist/$1';
        $route['administ/service/changePackageService'] = 'administ/service/changePackageService';
        $route['administ/service/deletePackageService'] = 'administ/service/deletePackageService';
        $route['administ/service/update-user-service'] = 'administ/service/updateUserService';

        $route['administ/service/register'] = 'administ/service/registerService';
        $route['administ/service/register/(:num)'] = 'administ/service/registerService/$1';

        $route['administ/service/list'] = 'administ/service/listService';
        $route['administ/service/list/(:num)'] = 'administ/service/listService/$1';
        $route['administ/service/list/edit/(:num)'] = 'administ/service/editService/$1';
        $route['administ/service/list/status/([a-z]+)/(:num)'] = 'administ/service/serviceStatus/$1/$2';

        $route['administ/service/group'] = 'administ/service/serviceGroup';
        $route['administ/service/group/(:num)'] = 'administ/service/serviceGroup/$1';
        $route['administ/service/group/edit/(:num)'] = 'administ/service/editServiceGroup/$1';
        $route['administ/service/group/status/([a-z]+)/(:num)'] = 'administ/service/serviceGroupStatus/$1/$2';

        $route['administ/service/subservice/(:num)'] = 'administ/service/subService/$1';
        $route['administ/service/package/pricelist/(:num)'] = 'administ/service/pricelist/$1';
        $route['administ/service/package/pricelist/(:num)/(:num)'] = 'administ/service/pricelist/$1/$2';
        $route['administ/service/package/pricelist/(:num)/status/([a-z]+)/(:num)'] = 'administ/service/pricelistStatus/$1/$2/$3';
        $route['administ/service/package/pricelist/(:num)/edit/(:num)'] = 'administ/service/pricelistEdit/$1/$2';
        $route['administ/service/package/status/([a-z]+)/(:num)'] = 'administ/service/packageStatus/$1/$2';
        $route['administ/service/package/edit/(:num)'] = 'administ/service/packageEdit/$1';
        #Newsletter
        $route['administ/newsletter'] = 'administ/newsletter';
        $route['administ/newsletter/(search|filter|sort|page|status).*'] = 'administ/newsletter';

        $route['administ/account'] = 'administ/account/mainboard';
        $route['administ/account/(:num)'] = 'administ/account/mainboard/$1';
        $route['administ/account/update'] = 'administ/account/update';
        $route['administ/account/request'] = 'administ/account/requestPayment';
        $route['administ/account/history/(:num)'] = 'administ/account/history/$1';
        $route['administ/account/detail/(\d+)'] = 'administ/account/detail/$1';
        $route['administ/account/detail/(\d+)/(:num)'] = 'administ/account/detail/$1';
        $route['administ/user/noactive/*'] = 'administ/user/noactive/$1';

        $route['administ/test.*'] = 'administ/test';

        #END Administ
        #BEGIN: Home
        //Defaults
        $route['update_gian_hang_dam_bao'] = 'home/defaults/update_gian_hang_dam_bao';
        $route['ajax'] = 'home/defaults/ajax';
        $route['ajax_mancatego'] = 'home/defaults/ajax_mancatego';

        $route['ajax_category'] = 'home/defaults/ajax_category';

        $route['autocomplete/(:any)'] = 'home/defaults/autocomplete';
        $route['ajax_long_polling'] = 'home/defaults/long_polling';
        $route['ajax_long_polling_cancel'] = 'home/defaults/long_polling_cancel';
        //        //Required Guarantee
        $route['ajax_required_guarantee'] = 'home/defaults/ajax_required_guarantee';
        //RSS
        $route['rss'] = 'home/defaults/rss';
        //Information
        $route['information'] = 'home/information/index';
        //Product
        //        $route['content.*'] = 'home/content';

        $route['product/upload_photo'] = 'home/product/upload_photo';
        $route['product/crop_photo'] = 'home/product/crop_photo';
        $route['product/ajax_delete_image'] = 'home/product/ajax_delete_image';
        $route['product/upload_photo_qc'] = 'home/product/upload_photo_qc';
        $route['product/crop_photo_qc'] = 'home/product/crop_photo_qc';
        $route['product/ajax_delete_image_qc'] = 'home/product/ajax_delete_image_qc';

        $route['product/category/(:num)'] = 'home/product/category/$1';
        $route['product/category/(:num)/(:any)'] = 'home/product/category/$1';
        $route['product/searchcat'] = 'home/product/seacrch_cat';

        $route['product/category/(:num)/(:any)/sort.*'] = 'home/product/category/$1';
        $route['product/category/(:num)/(:any)/page.*'] = 'home/product/category/$1';
        $route['product/saleoff.*'] = 'home/product/saleoff';
        $route['product/category/detail/(:num)/(:num)/(:any)'] = 'home/product/detail/$1/$2';
        $route['product/category/detail/(:num)/(:num)'] = 'home/product/detail/$1/$2';

        $route['account/product/product/post'] = 'home/product/post';
        $route['account/product/coupon/post'] = 'home/product/post';
        $route['account/product/service/post'] = 'home/product/post';

        $route['product/bao_cao_sai_gia'] = 'home/product/baocaosaigia';
        $route['product/ajax'] = 'home/product/ajax';
        $route['product/category'] = 'home/product/loadCategory_two';
        $route['product/xemtatca/(:num)'] = 'home/product/xemtatca/$1';
        $route['product/xemtatca/(:num)/(:any)'] = 'home/product/xemtatca/$1';
        $route['product/xemtatca/(:num)/(:any)/sort.*'] = 'home/product/xemtatca/$1';
        $route['product/xemtatca/(:num)/(:any)/page.*'] = 'home/product/xemtatca/$1';

        //search
        $route['product/search.*'] = 'home/product/search';
        $route['search-information'] = 'home/product/search';
        $route['search-information/(:num)'] = 'home/product/search/$1';
        $route['(:num)/(:any)/sort.*'] = 'home/product/category/$1';
        $route['(:num)/(:any)/page.*'] = 'home/product/category/$1';
        /* End Ngan work SEO 15/6 */
        $route['product/giamgia'] = 'home/product/giamgia';
        $route['product/giamgia/sort.*'] = 'home/product/giamgia';
        $route['product/giamgia/page.*'] = 'home/product/giamgia';
        //SEO
        $route['giamgia'] = 'home/product/giamgia';
        $route['giamgia/sort.*'] = 'home/product/giamgia';
        $route['giamgia/page.*'] = 'home/product/giamgia';
        $route['product/all'] = 'home/product/all';
        $route['product/all/sort.*'] = 'home/product/all';
        $route['product/all/page.*'] = 'home/product/all';
        $route['product/cheapest/(:num)'] = 'home/product/cheapest/$1';
        $route['product/cheapest/(:num)/sort.*'] = 'home/product/cheapest/$1';
        $route['product/cheapest/(:num)/page.*'] = 'home/product/cheapest/$1';
        //SEO
        $route['renhat/(:num)/(:any)'] = 'home/product/cheapest/$1';
        $route['renhat/(:num)/(:any)/sort.*'] = 'home/product/cheapest/$1';
        $route['renhat/(:num)/(:any)/page.*'] = 'home/product/cheapest/$1';
        $route['product/topweek/(:num)'] = 'home/product/topweek/$1';
        $route['product/topweek/(:num)/sort.*'] = 'home/product/topweek/$1';
        $route['product/topweek/(:num)/page.*'] = 'home/product/topweek/$1';
        //SEO
        $route['nhattuan/(:num)/(:any)'] = 'home/product/topweek/$1';
        $route['nhattuan/(:num)/(:any)/sort.*'] = 'home/product/topweek/$1';
        $route['nhattuan/(:num)/(:any)/page.*'] = 'home/product/topweek/$1';
        $route['product/topvote'] = 'home/product/topvote';
        $route['product/topvote/sort.*'] = 'home/product/topvote';
        $route['product/topvote/page.*'] = 'home/product/topvote';
        $route['muanhieunhat'] = 'home/product/muanhieunhat';
        //SEO
        $route['cungnhasanxuat/(:num)'] = 'home/product/cungnhasanxuat/$1';
        $route['danhgia'] = 'home/product/topvote';
        $route['danhgia/sort.*'] = 'home/product/topvote';
        $route['danhgia/page.*'] = 'home/product/topvote';
        $route['raovat/xem-nhieu-nhat'] = 'home/raovat/raovatxemnhieunhat';
        //Ads
        $route['raovat'] = 'home/raovat';
        $route['raovat/tin-mua.*'] = 'home/raovat/tinmua';
        $route['raovat/category'] = 'home/raovat/loadCategory_two';
        $route['raovat/ajax'] = 'home/raovat/ajax';
        $route['raovat/rao_vat_xau'] = 'home/raovat/rao_vat_xau';
        $route['raovat/rSort.*'] = 'home/raovat';
        $route['raovat/nSort.*'] = 'home/raovat';
        $route['raovat/rPage.*'] = 'home/raovat';
        $route['raovat/nPage.*'] = 'home/raovat';
        /*$route['raovat/category/(:num)/(:any)'] = 'home/raovat/category/$1';*/
        $route['raovat/category/(:num)/rSort.*'] = 'home/raovat/category/$1';
        $route['raovat/category/(:num)/nSort.*'] = 'home/raovat/category/$1';
        $route['raovat/category/(:num)/rPage.*'] = 'home/raovat/category/$1';
        $route['raovat/category/(:num)/nPage.*'] = 'home/raovat/category/$1';
		//SEO
        $route['raovat/(:num)/(:num).*'] = 'home/raovat/detail/$1/$2';
		//SEO
        $route['raovat/(:num)/(:any)'] = 'home/raovat/category/$1';
        $route['raovat/(:num)/rSort.*'] = 'home/raovat/category/$1';
        $route['raovat/(:num)/nSort.*'] = 'home/raovat/category/$1';
        $route['raovat/(:num)/rPage.*'] = 'home/raovat/category/$1';
        $route['raovat/(:num)/nPage.*'] = 'home/raovat/category/$1';
        $route['raovat/shop.*'] = 'home/raovat/shop';
        $route['raovat/category/detail/(:num)/(:num).*'] = 'home/raovat/detail/$1/$2';
        $route['raovat/post'] = 'home/raovat/post';
		//Hoi Dap
        $route['hoidap'] = 'home/hoidap';
        $route['hoidap/latest'] = 'home/hoidap/latest';
        $route['hoidap/latest/sort.*'] = 'home/hoidap/latest';
        $route['hoidap/latest/page.*'] = 'home/hoidap/latest';
        $route['hoidap/hoi_dap_xau'] = 'home/hoidap/hoi_dap_xau';
        $route['hoidap/tra_loi_xau'] = 'home/hoidap/tra_loi_xau';
		//SEO
        $route['hoidap/moinhat'] = 'home/hoidap/latest';
        $route['hoidap/moinhat/sort.*'] = 'home/hoidap/latest';
        $route['hoidap/moinhat/page.*'] = 'home/hoidap/latest';
        $route['hoidap/notanswers'] = 'home/hoidap/notanswers';
        $route['hoidap/notanswers/sort.*'] = 'home/hoidap/notanswers';
        $route['hoidap/notanswers/page.*'] = 'home/hoidap/notanswers';
		//SEO
        $route['hoidap/chuatraloi'] = 'home/hoidap/notanswers';
        $route['hoidap/chuatraloi/sort.*'] = 'home/hoidap/notanswers';
        $route['hoidap/chuatraloi/page.*'] = 'home/hoidap/notanswers';
        $route['hoidap/topanswers'] = 'home/hoidap/topanswers';
        $route['hoidap/topanswers/sort.*'] = 'home/hoidap/topanswers';
        $route['hoidap/topanswers/page.*'] = 'home/hoidap/topanswers';
		//SEO
        $route['hoidap/traloinhieunhat'] = 'home/hoidap/topanswers';
        $route['hoidap/traloinhieunhat/sort.*'] = 'home/hoidap/topanswers';
        $route['hoidap/traloinhieunhat/page.*'] = 'home/hoidap/topanswers';
        $route['hoidap/topviews'] = 'home/hoidap/topviews';
        $route['hoidap/topviews/sort.*'] = 'home/hoidap/topviews';
        $route['hoidap/topviews/page.*'] = 'home/hoidap/topviews';
		//SEO
        $route['hoidap/xemnhieunhat'] = 'home/hoidap/topviews';
        $route['hoidap/xemnhieunhat/sort.*'] = 'home/hoidap/topviews';
        $route['hoidap/xemnhieunhat/page.*'] = 'home/hoidap/topviews';
        $route['hoidap/toplikes'] = 'home/hoidap/toplikes';
        $route['hoidap/toplikes/sort.*'] = 'home/hoidap/toplikes';
        $route['hoidap/toplikes/page.*'] = 'home/hoidap/toplikes';
		//SEO
        $route['hoidap/coichnhat'] = 'home/hoidap/toplikes';
        $route['hoidap/coichnhat/sort.*'] = 'home/hoidap/toplikes';
        $route['hoidap/coichnhat/page.*'] = 'home/hoidap/toplikes';
        $route['hoidap/post'] = 'home/hoidap/post';
        $route['hoidap/ajax'] = 'home/hoidap/ajax';
        $route['hoidap/all/(:num)'] = 'home/hoidap/category/$1';
        $route['hoidap/all/(:num)/(:any)'] = 'home/hoidap/all/$1';
        $route['hoidap/all/(:num)/(:any)/sort.*'] = 'home/hoidap/all/$1';
        $route['hoidap/all/(:num)/(:any)/page.*'] = 'home/hoidap/all/$1';
        $route['hoidap/category/(:num)'] = 'home/hoidap/category/$1';
        $route['hoidap/category/(:num)/(:any)'] = 'home/hoidap/category/$1';
		//SEO
        $route['hoidap/(:num)/(:num)/(:any)'] = 'home/hoidap/detail/$1/$2';
        $route['hoidap/(:num)/(:any)'] = 'home/hoidap/category/$1';
        $route['hoidap/category/(:num)/(:any)/sort.*'] = 'home/hoidap/category/$1';
        $route['hoidap/category/(:num)/(:any)/page.*'] = 'home/hoidap/category/$1';
        $route['hoidap/category/detail/(:num)/(:num)/(:any)'] = 'home/hoidap/detail/$1/$2';
        $route['hoidap/ajaxvote'] = 'home/hoidap/ajaxvote';
        $route['hoidap/ajaxvoteans'] = 'home/hoidap/ajaxvoteans';
        $route['hoidap/ajaxdeleteans'] = 'home/hoidap/ajaxdeleteans';
		//Job
        $route['job'] = 'home/job';
        $route['job/sort.*'] = 'home/job';
        $route['job/page.*'] = 'home/job';
		//SEO
        $route['tuyendung'] = 'home/job';
        $route['tuyendung/sort.*'] = 'home/job';
        $route['tuyendung/page.*'] = 'home/job';
        $route['job/field/(:num)'] = 'home/job/field/$1';
        $route['job/field/(:num)/sort.*'] = 'home/job/field/$1';
        $route['job/field/(:num)/page.*'] = 'home/job/field/$1';
        $route['job/field/(:num)/detail/(:num).*'] = 'home/job/detail/$1/$2';
		//SEO
        $route['tuyendung/(:num)/(:num).*'] = 'home/job/detail/$1/$2';
        $route['tuyendung/(:num)/(:any)'] = 'home/job/field/$1';
        $route['tuyendung/(:num)/(:any)/sort.*'] = 'home/job/field/$1';
        $route['tuyendung/(:num)/(:any)/page.*'] = 'home/job/field/$1';
        $route['tuyendung/tuyendungquypham'] = 'home/job/tuyendungquypham';
        $route['job/post'] = 'home/job/post';
		//Employ
        $route['employ'] = 'home/employ';
        $route['employ/sort.*'] = 'home/employ';
        $route['employ/page.*'] = 'home/employ';
		//SEO
        $route['timviec'] = 'home/employ';
        $route['timviec/timviecquypham'] = 'home/employ/tim_viec_quy_pham';
        $route['timviec/sort.*'] = 'home/employ';
        $route['timviec/page.*'] = 'home/employ';
        $route['employ/field/(:num)'] = 'home/employ/field/$1';
        $route['employ/field/(:num)/sort.*'] = 'home/employ/field/$1';
        $route['employ/field/(:num)/page.*'] = 'home/employ/field/$1';
        $route['employ/field/(:num)/detail/(:num).*'] = 'home/employ/detail/$1/$2';
		//SEO
        $route['timviec/(:num)/(:num).*'] = 'home/employ/detail/$1/$2';
        $route['timviec/(:num)/(:any)'] = 'home/employ/field/$1';
        $route['timviec/(:num)/(:any)/sort.*'] = 'home/employ/field/$1';
        $route['timviec/(:num)/(:any)/page.*'] = 'home/employ/field/$1';
        $route['employ/post'] = 'home/employ/post';

        // checkout new
        $route['v-checkout'] = 'home/checkout/product';
        $route['v-checkout/coupon'] = 'home/checkout/coupon';
        $route['v-checkout/delete-all-qty'] = 'home/checkout/delete_all_qty';
        $route['v-checkout/order-temp'] = 'home/checkout/order_temp';
        $route['v-checkout/order-address'] = 'home/checkout/order_address';
        $route['v-checkout/get-district'] = 'home/checkout/get_district';
        $route['v-checkout/order'] = 'home/checkout/order';
        $route['v-checkout/shipping'] = 'home/checkout/shipping';
        $route['v-checkout/place-order'] = 'home/checkout/place_order';
        $route['v-checkout/orders-notify'] = 'home/checkout/orders_notify';
        $route['v-checkout/list-voucher'] = 'home/checkout/list_voucher';
        $route['v-checkout/get-voucher'] = 'home/checkout/get_voucher';
        $route['v-checkout/remove-voucher'] = 'home/checkout/remove_voucher';
        
		//Showcart
        $route['showcart/add.*'] = 'home/showcart/add';
        $route['showcart.*'] = 'home/showcart';
        $route['payment/nganluong_success/(:any)'] = 'home/product/nganluong_success/$1';
        $route['payment/nganluong_cancle/(:any)'] = 'home/product/nganluong_cancle/$1';
        $route['showcart/order_cart'] = 'home/showcart/order_cart';
        $route['showcart/shipfee'] = 'home/showcart/shipfee';
        $route['showcart/getPromotion'] = 'home/showcart/getPromotion';
        $route['showcart/update_qty'] = 'home/showcart/updateQty';
        $route['showcart/shipping_fee'] = 'home/showcart/shippingFee';
        $route['showcart/place_order'] = 'home/showcart/placeOrder';
        $route['showcart/place_order_v2'] = 'home/showcart/placeOrderv2';
        $route['showcart/delete'] = 'home/showcart/delete';
        $route['checkout'] = 'home/showcart/checkout';
        $route['showcat/district'] = 'home/showcart/get_district';
        $route['checkout/(:num)/:any'] = 'home/showcart/shop/$1';
        $route['checkout/v2/(:num)/(:any)'] = 'home/showcart/shopv2/$1/$2';
        $route['orders-success/(:num)'] = 'home/showcart/ordersSuccess/$1';
        $route['orders-error/(:num)'] = 'home/showcart/ordersError/$1';
        $route['information-order'] = 'home/showcart/checkOrders';
        $route['not-found-order/(:num)/(:any)'] = 'home/showcart/notFoundOrders/$1/$2';
        $route['information-order/(:num)'] = 'home/showcart/checkOrders/$1';
        $route['print-order'] = 'home/showcart/printOrders';
        $route['print-order/(:num)'] = 'home/showcart/printOrders/$1';
        $route['test-order'] = 'home/showcart/testOrder';
		//testOrder
        $route['order-cancel'] = 'home/showcart/cancelOrders';
        $route['order-cancel/(:num)'] = 'home/showcart/cancelOrders/$1';
        $route['order-cancel-user/(:num)'] = 'home/showcart/cancelOrdersUser/$1';
        //Notify
        $route['notify/(:num)'] = 'home/notify';
        $route['notify/(:num)/page'] = 'home/notify';
        $route['notify/(:num)/page/(:num)'] = 'home/notify';
        $route['notify/all'] = 'home/notify/all';
        $route['notify/all/page'] = 'home/notify/all';
        $route['notify/all/page/(:num)'] = 'home/notify/all';

		//Eye
        $route['eye/delete'] = 'home/eye/delete_eye';
        $route['eye/delete_all'] = 'home/eye/delete_all';
        $route['eye/deletenologin'] = 'home/eye/delete_eye_no_login';
        $route['eye/delete_all_no_login'] = 'home/eye/delete_all_no_login';
		//Guide
        $route['guide'] = 'home/guide';
		//Register

        $route['register'] = 'home/register';
        $route['register/verifycode'] = 'home/register/verifyCode';
        $route['register/account'] = 'home/register/register_account';
        $route['register/signupcontinue'] = 'home/register/signup_continue';
        $route['register/signupdone'] = 'home/register/signupdone';

        $route['register/ajax_category_shop'] = 'home/register/ajax_category_shop';
        $route['register/ajax'] = 'home/register/ajax';
        $route['register/check/emailusername'] = 'home/register/exist_usename_email';
        $route['register/check/useridcard/(:any)'] = 'home/register/exist_usename_idcard';
        $route['register/check/usertaxcode/(:any)'] = 'home/register/exist_usename_taxcode';
        $route['register/check/usermobile/(:any)'] = 'home/register/exist_usename_mobile';
        $route['register/check/username'] = 'home/register/exist_usename';
        $route['activation/user/(:any)/key/(:any)/token/(:any)'] = 'home/register/activation/$1/$2/$3';
        $route['register/estore/pid/(:num)'] = 'home/register';
        $route['register/affiliate/pid/(:num)'] = 'home/register';
        $route['register/afstore'] = 'home/register';
        $route['register/affiliate'] = 'home/register';
        $route['discovery'] = 'home/register/discovery';
        $route['register/affiliate/user/(:num)'] = 'home/register/affiliate/$1';

		//Contact
        $route['contact'] = 'home/contact';
		//Login - logout
        $route['login'] = 'home/login';
        $route['social'] = 'home/social/login';
        $route['logout'] = 'home/login/logout';
        $route['register/socialgoogle'] = 'home/register/register_by_social_google';
        $route['register/socialfacebook'] = 'home/register/register_by_social_facebook';
        $route['register/inputmobile.*'] = 'home/register/inputMobile';
        $route['register/checkauth.*'] = 'home/register/checkAuth';
		//Forgot
        $route['forgot'] = 'home/forgot';
        $route['forgot/1'] = 'home/forgot/index/1';
        $route['forgot/reset/key/(:any)/token/(:any)'] = 'home/forgot/reset/$1/$2';

		// Timeline User (trang của tôi)
        /*---------bookmark------------*/
        $route['bookmarks']                     = 'home/bookmark';
        $route['bookmarks/create']              = 'home/bookmark/create';// ko có edit, xóa tạo mới
        $route['bookmarks/(:num)/delete']       = 'home/bookmark/destroy/$1';// ko có edit, xóa tạo mới

        /*---------library link------------*/
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/links']                      = 'home/personal/library_links/$1';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/links/ajax']                 = 'home/personal/library_links/$1';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/custom-links/(:num)']                = 'home/personal/custom_link_detail/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/links/([a-zA-Z0-9-]+)']      = 'home/personal/media_link_category/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/links/([a-zA-Z0-9-]+)/ajax'] = 'home/personal/media_link_category/$2';
        $route['library-link/upload-media']                                       = 'home/link/validate_upload_media';

        /***-------get info liên kết------**/
        $route['library-link/info-link/(:num)']  = 'home/link/info_link/$1/library-link';
        $route['content-link/info-link/(:num)']  = 'home/link/info_link/$1/content-link';
        $route['image-link/info-link/(:num)']    = 'home/link/info_link/$1/image-link';
        /***-------end get info liên kết------**/

        $route['links/create']                   = 'home/link/create';

        $route['links/([a-zA-Z0-9-]+)/ajax']     = 'home/link/link_category/$1';
        $route['links/([a-zA-Z0-9-]+)']          = 'home/link/link_category/$1';

        /***-------update liên kết------**/
        $route['library-link/update']            = 'home/link/update/library-link';
        $route['content-link/update']            = 'home/link/update/content-link';
        $route['image-link/update']              = 'home/link/update/image-link';
        /***-------end update liên kết------**/

        /***-------xóa liên kết------**/
        $route['library-link/(:num)/delete']     = 'home/link/destroy/$1/library-link';
        $route['content-link/(:num)/delete']     = 'home/link/destroy/$1/content-link';
        $route['image-link/(:num)/delete']       = 'home/link/destroy/$1/image-link';

        /*xóa khỏi db*/
        $route['library-link/(:num)/remove']     = 'home/link/destroy/$1/library-link/true';
        $route['content-link/(:num)/remove']     = 'home/link/destroy/$1/content-link/true';
        $route['image-link/(:num)/remove']       = 'home/link/destroy/$1/image-link/true';

        /***-------clone liên kết------**/
        $route['library-link/clone/(:num)']      = 'home/link/clone_link/$1/library-link';
        $route['content-link/clone/(:num)']      = 'home/link/clone_link/$1/content-link';
        $route['image-link/clone/(:num)']        = 'home/link/clone_link/$1/image-link';
        $route['library-link/save-clone/(:num)'] = 'home/link/save_clone/$1';
        /***-------end clone liên kết------**/

        /***-------chi tiết liên kết------**/
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library-link/(:num)'] = 'home/personal/library_link_detail/$2/library-link';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/content-link/(:num)'] = 'home/personal/library_link_detail/$2/content-link';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/image-link/(:num)']   = 'home/personal/library_link_detail/$2/image-link';
        /***-------end chi tiết liên kết------**/


        $route['collection/my-collections']     = 'home/collection/my_collections';
        $route['profile/upload_cover']          = 'home/personal/upload_cover';
        $route['profile/process_cover']         = 'home/personal/process_cover';
        $route['profile/upload_avatar']         = 'home/personal/upload_avatar';
        $route['profile/process_avatar']        = 'home/personal/process_avatar';

        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/images(/relation_images/(:num)/(:num))?'] = 'home/personal/library_images/$3/$4';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/images/view-album/(:num)']                = 'home/personal/detail_album_image/$2';

        /*--------------ajax album personal-----------------------*/
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/(create|update)?']     = 'home/personal/ajax_process_album_image/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/load-img-lib']         = 'home/personal/ajax_pop_load_image_lib';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/off-set']              = 'home/personal/ajax_set_album_to_top';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/delete-album']         = 'home/personal/ajax_delete_album';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/getInfoAlbum']         = 'home/personal/ajax_get_info_album';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/openPopupGhim']        = 'home/personal/ajax_openPopupGhim';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/action-pin-to-album']  = 'home/personal/ajax_pin_to_album';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/remove-item-library']  = 'home/personal/ajax_remove_file';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/album-image/upImage']              = 'home/personal/ajax_up_file';
        /*--------------END ajax album personal-----------------------*/

        //$route['library/images(/relation_images/(:num)/(:num))?'] = 'home/shop/media_images/$2/$3'; // list all images shop
        //$route['library/videos(/(videos|news))?']                 = 'home/shop/media_videos/$2'; // list all images shop
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library/videos(/(videos|news))?'] = 'home/personal/library_videos/$3';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/get_more_news']  = 'home/personal/get_more_news/$1';
        // $route['profile/([a-zA-Z0-9\-\_\.]+)/about']          = 'home/personal/about/$1';s
        // $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop/(:any)']           = 'home/personal/affiliate_shop_slash/$1/$2';
        // $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop']           = 'home/personal/affiliate_shop/$1';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop']           = 'home/personal/affiliate_shop_v2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop/voucher/type/(:num)']           = 'home/personal/affiliate_shop_v2/voucher/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop/(voucher|product|coupon)?']           = 'home/personal/affiliate_shop_v2/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop/voucher/search']           = 'home/personal/affiliate_shop_v2_search';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate-shop/(product|coupon)/search']           = 'home/personal/affiliate_shop_v2_search_product/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/friends']                = 'home/personal/friends';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/friends/(:any)']                = 'home/personal/friends/$2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/about']                = 'home/personal/information';
        $route['ajax_district']                = 'home/personal/ajax_district';
        $route['profile/edit_info_user']                = 'home/personal/edit_info_user';
        $route['profile/edit_maritals_user']                = 'home/personal/edit_maritals_user';
        $route['profile/edit_detail_user']                = 'home/personal/edit_detail_user';
        $route['profile/add_jobs_user']                = 'home/personal/add_jobs_user';
        $route['profile/edit_jobs_user']                = 'home/personal/edit_jobs_user';
        $route['profile/get_jobs_user']                = 'home/personal/get_jobs_user';
        $route['profile/delete_jobs_user']                = 'home/personal/delete_jobs_user';
        $route['profile/([a-zA-Z0-9\-\_\.]+)']                = 'home/personal/profile/$1';
        $route['profile/ajax_status_friend']                = 'home/personal/ajax_status_friend';
        $route['ajax_poplist_user']                = 'home/personal/ajax_poplist_user';
        $route['search-user']                = 'home/personal/search_api';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/list-search-user']                = 'home/personal/list_search';

        $route['profile/([a-zA-Z0-9\-\_\.]+)/share-content-page/(:num)']         = 'home/share/show_content_has_share/$2';

        // ------------------------------------------------------------------------
        // -------------------------COLLECTION V2-------------------------------------
        // ------------------------------------------------------------------------
        $route['profile/([a-zA-Z0-9\-\_\.]+)/collection/link'] = 'home/personal/collection_link_v2';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/collection/link/(:num)'] = 'home/personal/collection_link_detail_v2/$2';

        /***-------chi tiết liên kết------**/
        $route['profile/([a-zA-Z0-9\-\_\.]+)/library-link/(:num)'] = 'home/personal/library_link_detail/$2/library-link';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/content-link/(:num)'] = 'home/personal/library_link_detail/$2/content-link';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/image-link/(:num)']   = 'home/personal/library_link_detail/$2/image-link';
        /***-------end chi tiết liên kết------**/

        // User
        $route['user/profile/(:num)'] = 'home/user/profile/$1';
        $route['user/listaffiliate/(:num)'] = 'home/user/listaffiliate/$1';
        $route['user/listaffiliate/(:num)/(:any)'] = 'home/user/listaffiliate/$1';
        $route['user/doanhthu.*'] = 'home/user/doanhthuAff';

        //Account
        $route['account'] = 'home/account';
        $route['account/bank'] = 'home/account/bank';
        $route['account/bank.*'] = 'home/account/bank/$1';
        $route['account/kho.*'] = 'home/account/kho/$1';
        $route['account/limitctv.*'] = 'home/account/limitctvbran/$1';
        $route['account/edit'] = 'home/account/edit';
        $route['account/edit/(:num)'] = 'home/account/edit/$1';
        $route['account/delete'] = 'home/user/delete';
        $route['account/setup_up'] = 'home/account/setup_up';
        $route['account/naptien'] = 'home/account/naptien';
        $route['account/naptien/buoc1'] = 'home/account/naptienb1';
        $route['account/danhsachnaptien.*'] = 'home/account/danhsachdondathangnoptien';
        $route['account/naptien/buoc2'] = 'home/account/naptienb2';
        $route['account/naptien/buoc3-tai-tru-so'] = 'home/account/naptienb3_tai_tru_so';
        $route['account/naptien/buoc3sohapay'] = 'home/account/naptienb3sohapay';
        $route['account/naptien/buoc4sohapay'] = 'home/account/naptienb4sohapay';
        $route['account/naptien/buoc5sohapay'] = 'home/account/naptienb5sohapay';
        $route['account/naptien/naptienthuchienthanhcong'] = 'home/account/thuchienthanhcong';
        $route['account/yeucautamgiu'] = 'home/account/yeucautamgiu';
        $route['account/naptien/buoc3sms'] = 'home/account/naptienb3sms';
        $route['account/naptien/buoc3thutientannoi'] = 'home/account/buoc3thutientannoi';
        $route['account/naptien/buoc4thutientannoi'] = 'home/account/buoc4thutientannoi';
        $route['account/naptien/buoc5thutientannoi'] = 'home/account/buoc5thutientannoi';
        $route['account/naptien/buoc3thutaitruso'] = 'home/account/buoc3thutaitruso';
        $route['account/naptien/buoc4thutaitruso'] = 'home/account/buoc4thutaitruso';
        $route['account/naptien/buoc3chuyenkhoan'] = 'home/account/buoc3chuyenkhoan';
        $route['account/naptien/buoc4chuyenkhoan'] = 'home/account/buoc4chuyenkhoan';
        $route['naptien/process'] = 'home/naptien/process';
        $route['naptien/submit_sohapay'] = 'home/naptien/submit_sohapay';
        $route['naptien/verifyresponse'] = 'home/naptien/verifyresponse';
        $route['naptien/success'] = 'home/naptien/success';
        $route['naptien/fail_transaction'] = 'home/naptien/fail_transaction';
        $route['account/naptien_baokim'] = 'home/account/naptien_baokim';
        $route['account/process_baokim'] = 'home/account/process_baokim';
        $route['account/verifyresponse_baokim'] = 'home/account/verifyresponse_baokim';
        $route['account/fail_transaction_baokim'] = 'home/account/fail_transaction_baokim';
        $route['account/baokim_success'] = 'home/account/baokim_success';
        $route['account/toolmarketing/azidirect'] = 'home/account/azidirect';
        $route['account/update_company_code'] = 'home/account/update_company_code';
        $route['payment/order_now/(:num)'] = 'home/payment/order_now/$1';
        $route['payment/order_bill/(:num)'] = 'home/payment/order_bill/$1';
        $route['payment/order_bill_nganluong/(:num)'] = 'home/payment/order_bill_nganluong/$1';
        $route['payment/verifyresponse_baokim'] = 'home/payment/verifyresponse_baokim';
        $route['payment/verifyresponse_nganluong'] = 'home/payment/verifyresponse_nganluong';
        $route['product/fail_transaction_baokim'] = 'home/product/fail_transaction_baokim';
        $route['product/baokim_success/(:num)'] = 'home/product/baokim_success/$1';
        $route['product/payment_success/(:num)'] = 'home/product/payment_success/$1';
        $route['account/history_up'] = 'home/account/history_up';
        $route['account/chitietup/(:any)'] = 'home/account/chitietup/$1';
        $route['account/uptin/(:num)/(:num)'] = 'home/account/uptin/$1/$2';
        $route['cronuptin'] = 'home/defaults/cronuptin';
        $route['account/smsuptin'] = 'home/account/smsuptin';
        $route['account/lichsugiaodich'] = 'home/account/lichsugiaodich';
        $route['account/gianhang'] = 'home/account/gianhang';
        $route['account/checkid/(:num)/(:num)'] = 'home/account/checkid/$1/$2';
        $route['account/kiem_tra_link_shop'] = 'home/account/kiem_tra_link_shop';
        $route['account/noi-quy-gian-hang'] = 'home/account/noi_quy_giang_hang';
        $route['account/changepassword'] = 'home/account/changepassword';
        $route['account/personaldomain'] = 'home/account/personaldomain';
        $route['account/shop'] = 'home/account/shop';
        $route['account/ajax_category_shop'] = 'home/account/ajax_category_shop';
        $route['account/sharelist.*'] = 'home/account/notify';
        $route['account/notify.*'] = 'home/account/notify';
        $route['account/contact.*'] = 'home/account/contact';
        $route['account/contact/outbox.*'] = 'home/account/contact';
        $route['account/product.*'] = 'home/account/product';
        $route['account/order_pro'] = 'home/account/order_pro';
        $route['account/raovat.*'] = 'home/account/raovat';
        $route['account/job.*'] = 'home/account/job';
        $route['account/employ.*'] = 'home/account/employ';
        $route['account/customer/list_orders/(:num)'] = 'home/account/list_orders';
        $route['account/customer.*'] = 'home/account/customer';
        $route['account/showcart.*'] = 'home/account/showcart';
        $route['account/order_detail.*'] = 'home/account/order_detail';
        $route['account/orderDetailTKSP.*'] = 'home/account/order_detail';
        $route['account/order.*'] = 'home/account/order';
        $route['account/listbran_order.*'] = 'home/account/listbran_order';
        $route['account/bran_order.*'] = 'home/account/order_bran';
        $route['account/shop_tree'] = 'home/account/shop_tree';
        $route['account/changeDelivery'] = 'home/account/changeDelivery';
        $route['account/complaintsOrders'] = 'home/account/complaintsOrders';
        $route['account/complaintsOrdersForm'] = 'home/account/complaintsOrdersForm';
        $route['account/complaintsOrdersForm/(:num)'] = 'home/account/complaintsOrdersForm/$1';
        $route['account/solvedOrders'] = 'home/account/solvedOrders';
        $route['account/submitComplaintsOrdersForm'] = 'home/account/submitComplaintsOrdersForm';
        $route['account/getShippingFee/(:num)'] = 'home/account/getShippingFee/$1';
        $route['account/addWallet'] = 'home/account/addWallet';
        $route['account/loadAddWallet'] = 'home/account/loadAddWallet';
        $route['account/addWalletSubmit'] = 'home/account/addWalletSubmit';
        $route['account/addWalletSuccess'] = 'home/account/addWalletSuccess';
        $route['account/addWalletSuccess/(:num)'] = 'home/account/addWalletSuccess/$1';

        $route['account/payment_nl'] = 'home/account/payment_nl';
        $route['account/nganluong_cancel'] = 'home/account/nganluong_cancel';
        $route['account/nganluong_cancel/(:num)'] = 'home/account/nganluong_cancel/$1';
        $route['account/nganluong_success'] = 'home/account/nganluong_success';
        $route['account/nganluong_success/(:num)'] = 'home/account/nganluong_success/$1';
        $route['account/spendingHistory'] = 'home/account/spendingHistory';
        $route['account/spendingHistory/(:any)'] = 'home/account/spendingHistory';

        $route['account/user_order/(:num)'] = 'home/account/user_order_detail';
        $route['account/user_order.*'] = 'home/account/user_order';
        $route['account/ajax_update_order/(:num)/(:num)'] = 'home/account/ajax_update_order/$1/$2';
        $route['account/ajax'] = 'home/account/ajax';
        $route['account/shop/intro'] = 'home/account/shopintro';
        $route['account/shop/warranty'] = 'home/account/shopwarranty';
        $route['account/shop/shoprule'] = 'home/account/shoprule';
        $route['account/shop/payment_method'] = 'home/account/payment_method';
        $route['account/shop/save_payment_method'] = 'home/account/save_payment_method';
        $route['account/shop/shipping_method'] = 'home/account/shipping_method';
        $route['account/shop/save_shipping_method'] = 'home/account/save_shipping_method';
        $route['account/shop/addbanner'] = 'home/account/addbanner';
        $route['account/shop/listbanner'] = 'home/account/listbanner';
        $route['account/shop/banner/.*'] = 'home/account/banner';
        $route['account/shop/xoa_hinh_one'] = 'home/account/xoa_hinh_one';
        $route['account/shop/xoa_hinh_one_and_defalut'] = 'home/account/xoa_hinh_one_and_defalut';
        $route['account/shop/xoa_hinh_one_and_shop'] = 'home/account/xoa_hinh_one_and_shop';
        $route['account/shop/xoa_hinh_nhieu'] = 'home/account/xoa_hinh_nhieu';
        $route['account/theo_doi_hoi_dap'] = 'home/account/theo_doi_hoi_dap';
        $route['account/hoidap.*'] = 'home/account/hoidap';		
        $route['account/pexpiration.*'] = 'home/account/hethan';
        $route['account/pnoprice.*'] = 'home/account/khonggia';
        $route['account/traloi.*'] = 'home/account/traloi';
        $route['account/theodoihoidap.*'] = 'home/account/theodoihoidap';
        $route['account/delete_theo_doi_hoi_dap'] = 'home/account/delete_theo_doi_hoi_dap';
        // tree
        $route['account/tree'] = 'home/account/tree';
        $route['account/tree/(:num)'] = 'home/account/tree';
        $route['account/treelist.*'] = 'home/account/treelist';
        $route['account/tree/request/member'] = 'home/register';
        $route['account/tree/invite'] = 'home/account/invite_tree';
        $route['account/tree/inviteaf'] = 'home/account/invite_tree';
        $route['account/tree/affiliate.*'] = 'home/account/affiliate_store';
        $route['account/tree/store.*'] = 'home/account/treestore';
        $route['account/tree/uprated.*'] = 'home/account/require_uprated_member';
        $route['account/listaffiliate.*'] = 'home/account/listaffiliate';
        $route['account/listbran.*'] = 'home/account/listaffiliate';
        $route['account/listaffstaff.*'] = 'home/account/listaffiliate';
        $route['account/allaffiliateunder'] = 'home/account/allaffiliateunder';
        $route['account/allaffiliateunder.*'] = 'home/account/allaffiliateunder/$1';
        $route['account/coverdata.*'] = 'home/account/coverdata';

        //docs
        $route['account/docs'] = 'home/account/docs';
        $route['account/docs/(:num)/detail/(:any)'] = 'home/account/docsdetail/$1';
        $route['account/docs/(:num)/(:any)'] = 'home/account/docs/$1';
        //staff
        $route['account/staffs/mytask'] = 'home/account/mytask';
        $route['account/staffs/mytask.*'] = 'home/account/mytask';
        $route['account/staffs'] = 'home/account/staffs';
        $route['account/staffs/sort.*'] = 'home/account/staffs';
        $route['account/staffs/page.*'] = 'home/account/staffs';
        $route['account/staffs/all.*'] = 'home/account/staffs';
        $route['account/staffs/task/(:num)'] = 'home/account/staffs/task/$1';
        $route['account/staffs/task/today.*'] = 'home/account/task_today';

        $route['account/treetaskuser.*'] = 'home/account/treetaskuser';
        $route['account/treetask/today.*'] = 'home/account/treetasktoday';
        $route['account/treetask.*'] = 'home/account/treetask';
        //Bao them vao cua Staff
        $route['account/viewtasks.*'] = 'home/account/viewtasks';
		$route['account/statisticalbran.*'] = 'home/account/statisticalemployee';
		$route['account/statisticalemployee.*'] = 'home/account/statisticalemployee';
        $route['account/salesemployee_Store.*'] = 'home/account/salesemployee_Store';
		$route['account/salesemployee.*'] = 'home/account/salesemployee';

        $route['account/staffs/task/(:num)/month/(:num)'] = 'home/account/staffs/task/$1/$2';
        $route['account/staffs/task/(:num)/month/(:num)/day/(:num)'] = 'home/account/staffs/task/$1/$2/$3';
        $route['account/staffs/task/(:num)/month/(:num)/day/(:num)/edit/(:num).*'] = 'home/account/staffs/task/$1/$2/$3/$4';
        $route['account/staffs/add'] = 'home/register/registerEmployee';
        $route['account/staffs/modified-role'] = 'home/register/updateRoleEmployee';
        $route['account/commission'] = 'home/account/commission';
        $route['account/commission/(:num)'] = 'home/account/commission/$1';
        $route['account/detail/commission/(:num)'] = 'home/account/detailcommission/$1';
        $route['account/detail-commission/(:num)/type/(:any)/month/(:any)/year/(:any)'] = 'home/account/moreDetailCommission/$1/$2/$3/$4';
        $route['account/detail/commission-position-empty/(:num)'] = 'home/account/detailcommissionpositionempty/$1';
        $route['account/detail/commission/buyer/(:num)'] = 'home/account/detailcomission_type4/$1';
        $route['account/detail/commission/retail/(:num)'] = 'home/account/detailcomission_type5/$1';
        $route['account/detail/commission/wholesale/(:num)'] = 'home/account/detailcomission_type2/$1';
        $route['account/detail/commission/aggre/(:num)'] = 'home/account/detailcomission_type1/$1';
        $route['account/income/user'] = 'home/account/user_income';
        $route['account/income/provisional'] = 'home/account/provisional_income';
        $route['account/income/provisional_store'] = 'home/account/provisional_income_store';
        $route['account/income/tamtinhGH'] = 'home/account/tamtinhGH';
        $route['account/income/detail/(:num)'] = 'home/account/income_detail/$1';
        $route['account/income/detail.*'] = 'home/account/income_detail';
        $route['account/income/user/af'] = 'home/account/user_income';
        $route['account/comments'] = 'home/account/comments';
        $route['account/comments/(:num)'] = 'home/account/comments/$1';
        $route['account/delete_promotion'] = 'home/account/delete_promotion';

        //upload
        $route['upload'] = 'home/upload';
        $route['upload/upload_img'] = 'home/upload/do_upload';
        $route['account/staffs/task/(:num)/month/(:num)/day/(:num)/upload'] = 'home/upload';
        $route['account/staffs/task/(:num)/month/(:num)/day/(:num)/upload/upload_img'] = 'home/upload/do_upload';

        $route['nganluong_upload'] = 'home/upload/file_nganluong';

        //landing page
        $route['account/landing_page/create/(:num)'] = 'home/landing_page/create/$1';
        $route['templates/landing_page/(:num)'] = 'home/landing_page/edit/$1';
        $route['account/landing_page/delete/(:num)'] = 'home/landing_page/delete/$1';
        $route['templates/landing_page/builder'] = 'home/landing_page/builder';
        $route['landing_page/html/(:any)'] = 'home/landing_page/loadJson/$1';
        $route['landing_page/saveJson'] = 'home/landing_page/saveJson';
        $route['landing_page/id/(:num)/(:any)'] = 'home/landing_page/view/$1';
        $route['landing_page/saveLandingPage'] = 'home/landing_page/saveLandingPage';
        $route['account/landing_page/lists'] = 'home/landing_page/landing_list';
        $route['account/share-land.*'] = 'home/landing_page/list_share';
        $route['account/landing_page/checkLandPermissions'] = 'home/landing_page/checkLandPermissions';
        // Azi service
        $route['account/tool-marketing/azi-direct'] = 'home/account/aziDirect';
        $route['account/tool-marketing/azi-branch'] = 'home/account/aziBranch';
        $route['account/tool-marketing/azi-publisher'] = 'home/account/aziPublisher';
        $route['account/tool-marketing/azi-affiliate'] = 'home/account/aziAffiliate';
        $route['account/tool-marketing/azi-manager'] = 'home/account/aziManager';
        $route['account/tool-marketing/email-marketing'] = 'home/account/emailMarketing';
        $route['account/chuyentien_emailmarketing'] = 'home/account/chuyentien_emailmarketing';
        $route['account/tool-marketing/access-email-marketing'] = 'home/account/accessEmailMarketing';
        // news
        $route['account/news/add'] = 'home/account/newsAdd';
        $route['account/news/edit/(:num)'] = 'home/account/editNew/$1';
        $route['account/news.*'] = 'home/account/listnews';
        $route['createsitemap'] = 'home/sitemap';
		#END Home

		#Start affiliate
        $route['account/affiliate'] = 'home/affiliate/index';
        $route['account/affiliate/products'] = 'home/affiliate/products';
        $route['account/affiliate/upgrade'] = 'home/account/upgrade_af';
        $route['account/affiliate/products/(:num)'] = 'home/affiliate/products/$1';
        $route['account/affiliate/myproducts'] = 'home/affiliate/myproducts';
        $route['account/affiliate/myproducts/(:num)'] = 'home/affiliate/myproducts/$1';
        $route['account/affiliate/pressproducts'] = 'home/affiliate/pressproducts';
        $route['account/affiliate/pressproducts/(:num)'] = 'home/affiliate/pressproducts/$1';
        $route['account/affiliate/orders'] = 'home/affiliate/orders';
        $route['account/affiliate/orders/(:num)'] = 'home/affiliate/orders/$1';
        $route['account/affiliate/orders.*'] = 'home/affiliate/orders';
        $route['account/affiliate/statistic'] = 'home/affiliate/statistic';
        $route['account/affiliate/statistic/(:num)'] = 'home/affiliate/statistic/$1';
        //aaa
        $route['account/affiliate/configaffiliate/(:num).*'] = 'home/affiliate/configaffiliate/$1';		
        $route['account/affiliate/configaffiliate.*'] = 'home/affiliate/configaffiliate';
        // $route['account/affiliate/addcommissonaffiliate'] = 'home/affiliate/addcommissonaffiliate';
        $route['account/affiliate/addcommissonaffiliate/(:num)'] = 'home/affiliate/addcommissonaffiliate/$1';
        $route['account/affiliate/addcommissonaffiliate/(:num)/(:num)'] = 'home/affiliate/addcommissonaffiliate/$1/$2';		
		$route['account/affiliate/deletecommissionaff/(:num)/(:num)'] = 'home/affiliate/deletecommissionaff/$1/$2';
        // $route['account/affiliate/configforuseraff/(:num)'] = 'home/affiliate/configforuseraff/$1';
        $route['account/affiliate/Update_Commission_Aff_Ajax/(:num)/(:num)/(:num)'] = 'home/affiliate/Update_Commission_Aff_Ajax';
        $route['account/statisticlistbran.*'] = 'home/account/statisticlistbran';        
        $route['af/add-products'] = 'home/affiliate/ajaxAddProduct';

        #BEGIN:: Affiliate shop
        $route['account/affiliate/pickup/product'] = 'home/affiliate/pickup';
        $route['account/affiliate/pickup/product/(:any)'] = 'home/affiliate/pickup';
        $route['account/affiliate/ajax_pickup'] = 'home/affiliate/ajaxpickup';
        $route['account/affiliate/pickup/coupon'] = 'home/affiliate/pickup';
        $route['account/affiliate/pickup/coupon/(:any)'] = 'home/affiliate/pickup';
        $route['account/affiliate/depot/product'] = 'home/affiliate/depot';
        $route['account/affiliate/depot/product/(:any)'] = 'home/affiliate/depot';
        $route['account/affiliate/depot/coupon'] = 'home/affiliate/depot';
        $route['account/affiliate/depot/coupon/(:any)'] = 'home/affiliate/depot';
		
        $route['account/affiliate/order/product'] = 'home/affiliate/afs_orders';        
        $route['account/affiliate/order/product/(:any)'] = 'home/affiliate/afs_orders';
        $route['account/affiliate/order/coupon'] = 'home/affiliate/afs_orders';
        $route['account/affiliate/order/coupon/(:any)'] = 'home/affiliate/afs_orders';
        $route['account/affiliate/order/(:num)'] = 'home/affiliate/afs_order/$1';
		
		$route['account/affiliate/income/product'] = 'home/affiliate/afs_income';
		$route['account/affiliate/income/product/(:any)'] = 'home/affiliate/afs_income';
		$route['account/affiliate/income/coupon'] = 'home/affiliate/afs_income';
		$route['account/affiliate/income/coupon/(:any)'] = 'home/affiliate/afs_income';

        $route['account/affiliate/statistic/product'] = 'home/affiliate/afs_statistic';
        $route['account/affiliate/statistic/product/(:any)'] = 'home/affiliate/afs_statistic';
        $route['account/affiliate/statistic/detail/(:num)'] = 'home/affiliate/afs_statistic_detail/$1';
        $route['account/affiliate/statistic/detail/(:num)/(:any)'] = 'home/affiliate/afs_statistic_detail/$1';
        $route['account/affiliate/statistic/coupon'] = 'home/affiliate/afs_statistic';
        $route['account/affiliate/statistic/coupon/(:any)'] = 'home/affiliate/afs_statistic';

        $route['account/affiliate/shop_statistic'] = 'home/affiliate/shop_statistic';

        $route['account/affiliate/shop_income'] = 'home/affiliate/shop_income';
        $route['account/affiliate/shop_temp_income'] = 'home/affiliate/shop_temp_income';
        $route['account/affiliate/shop_temp_income/page.*'] = 'home/affiliate/shop_temp_income';
        $route['account/affiliate/listuserregister'] = 'home/affiliate/listUserRegister';

        #END:: Affiliate shop

        #End affiliate
        #Start share
        $route['account/share'] = 'home/share/index';
        $route['account/share/(:num)'] = 'home/share/index/$1';
        $route['account/share/view-list'] = 'home/share/view_list';
        $route['account/share/view-list/(:any)'] = 'home/share/view_list';
        $route['account/share/view-list/detail/(:num)'] = 'home/share/detail_view/$1';
        #End share
        // advs
        $route['account/advs/click.*'] = 'home/account/list_click';
        $route['account/advs.*'] = 'home/account/advs';
        $route['account/myads.*'] = 'home/account/myads';
        // end advs
        //Start Newsletter
        $route['newsletter/ajax'] = 'home/newsletter/ajax';
        #End Newsletter
        //Start Service
        $route['ajax/add-package'] = 'home/account/addPackage';
        $route['ajax/complete-payment'] = 'home/account/completePayment';
        $route['ajax/cancel-order'] = 'home/account/cancelOrder';
        $route['ajax/start-service'] = 'home/account/startService';

        $route['ajax/update-payment'] = 'home/account/updatePayment';
        $route['ajax/action/([a-z]+)'] = 'home/ajax/action/$1';
        $route['vtp/update-order'] = 'home/restapi/updateOrderVTP';
        $route['ghtk/update-status'] = 'home/restapi/updateOrderGHTK';

        $route['ghtk/updatelog'] = 'home/restapi/updateOrderGHTK';        

        $route['account/service'] = 'home/account/service';
        $route['account/service/news/(:num)'] = 'home/account/registerService/$1';
        $route['account/service/products/(:num)'] = 'home/account/registerService/$1';		
        $route['account/service/using'] = 'home/account/service_using';
        $route['account/service/using/(:num)'] = 'home/account/service_using/$1';
        $route['account/service/detail/(:num)'] = 'home/account/serviceDetail/$1';
        $route['account/service/detail_daily/(:num)'] = 'home/account/serviceDetail/$1';
        $route['account/service/detail_daily/(:num)/(:any)'] = 'home/account/serviceDetail/$1';
        $route['account/service/requesting'] = 'home/account/service_requesting';
        $route['account/service/requesting/(:num)'] = 'home/account/service_requesting/$1';
        $route['account/service/expired'] = 'home/account/service_expired';
        $route['account/service/expired/(:num)'] = 'home/account/service_expired/$1';
        $route['account/service/canceled'] = 'home/account/service_canceled';
        $route['account/service/canceled/(:num)'] = 'home/account/service_canceled/$1';
        $route['account/service/add_daily_content'] = 'home/account/addDailyContent';
        $route['account/service/remove_daily_content'] = 'home/account/removeDailyContent';
        #End Service
        //Start Statistic
        $route['account/statistic'] = 'home/account/statistic';
        $route['account/statistic_Store'] = 'home/account/statistic_Store';
        $route['account/statistic/order'] = 'home/account/statistic_order';
        $route['account/statistic/product'] = 'home/account/statistic_product';
        $route['account/statistic/revenue'] = 'home/account/statistic_revenue';
        $route['account/statistic/commission'] = 'home/account/statistic_commission';
        $route['account/statistic/tree'] = 'home/account/statistic_tree';
        $route['account/statistic/sharing'] = 'home/account/statistic_sharing';
        $route['account/supplier'] = 'home/account/supplier';
        $route['account/supplier/(:num)'] = 'home/account/supplier/$1';
        //End Statistic
        $route['account/statisticIncome'] = 'home/account/statisticIncome';
        $route['account/statisticIncome_Store'] = 'home/account/statisticIncome_Store';
        $route['account/statisticMember.*'] = 'home/account/statisticMember';
        $route['account/statisticlistaffiliate_Store.*'] = 'home/account/statisticlistaffiliate_Store';
        $route['account/statisticlistaffiliatebran.*'] = 'home/account/statisticlistaffiliatebran';
        $route['account/statisticlistaffiliate.*'] = 'home/account/statisticlistaffiliate';
        $route['account/statisticlistNVGH.*'] = 'home/account/statisticlistNVGH';
        $route['account/detailstatisticlistaffiliate.*'] = 'home/account/detailstatisticlistaffiliate';
        $route['account/statisticlistshop.*'] = 'home/account/statisticlistshop';
        $route['account/detailstatisticlistshop.*'] = 'home/account/detailstatisticlistshop';

        $route['account/statisticlistshopall.*'] = 'home/account/statisticlistshop';
        $route['account/statisticlistPartner.*'] = 'home/account/statisticlistPartnerAndDeveloper';
        $route['account/statisticlistDeveloper.*'] = 'home/account/statisticlistPartnerAndDeveloper';
        $route['account/listPartner.*'] = 'home/account/listPartner';
        $route['account/listDeveloper.*'] = 'home/account/listDeveloper';
        $route['account/listallDeveloper.*'] = 'home/account/listDeveloper';
        $route['account/listshop.*'] = 'home/account/listshop';
        $route['account/listaff.*'] = 'home/account/listaff';

        $route['account/detailstatisticlistbran.*'] = 'home/account/detailstatisticlistaffiliate';
        $route['account/statisticproduct_Store.*'] = 'home/account/statisticproduct_Store';
        $route['account/statisticproduct.*'] = 'home/account/statisticproduct';
        $route['account/detail_statistic_product.*'] = 'home/account/detail_statistic_product';
        $route['account/detail_statistic_order_product/saler/(:num)/proid/(:num)'] = 'home/account/detail_statistic_order_product/$1/proid/$2';

        $route['account/upload_photo'] = 'home/account/upload_photo';
        $route['account/upload_photo_qc'] = 'home/account/upload_photo_qc';
        $route['account/crop_photo'] = 'home/account/crop_photo';
        $route['account/crop_photo_qc'] = 'home/account/crop_photo_qc';

        # Affiliate Service
        $route['affiliate']                                                 = 'home/personal/affiliate';
        $route['affiliate/list']                                            = 'home/personal/affiliatelist';
        $route['affiliate/coupons']                                         = 'home/personal/affiliatecoupons';
        $route['affiliate/user']                                            = 'home/personal/getAffilateUser';
        $route['affiliate/invite']                                          = 'home/personal/getAffilateInvite';
        $route['affiliate/invitea']                                          = 'home/personal/getAffilateInviteA';
        $route['affiliate/inviterequest']                                   = 'home/personal/inviteRequest';
        $route['affiliate/inviteuser']                                      = 'home/personal/inviteUser';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate/user_bak']           = 'home/personal/getAffilateUser_bak';//tai bak
        $route['affiliate/select']                                          = 'home/personal/affiliateselect';
        $route['affiliate/selectcoupons']                                   = 'home/personal/affiliateselectcoupons';
        $route['affiliate/order']                                           = 'home/personal/affiliateOrder';
        $route['profile/([a-zA-Z0-9\-\_\.]+)/affiliate/order_bak']          = 'home/personal/affiliateOrder_bak';//tai bak
        $route['affiliate/user/(:num)']                                     =  'home/personal/detailAffilateUser/$1';

        // tai create
        $route['affiliate-invite']                                          = 'home/personal/affiliate_invite';
        $route['affiliate/list/(:num)']                                     = 'home/personal/affiliatelist_detail/$1';
        $route['affiliate/order/(:num)']                                    = 'home/personal/affiliateOrder_detail/$1';
        $route['affiliate/income']                                          = 'home/personal/affiliate_income';
        $route['affiliate/withdrawal']                                      = 'home/personal/affiliate_withdrawal';
        $route['affiliate/withdrawal-confirm/(:num)']                       = 'home/personal/affiliate_withdrawal_bank_confirm_code/$1';
        $route['affiliate/withdrawal/process']                              = 'home/personal/affiliate_withdrawal_process';
        $route['affiliate/income-provisonal-sum']                           = 'home/personal/affiliate_provisonal_sum';
        $route['affiliate/income-history']                                  = 'home/personal/affiliate_history';
        $route['affiliate/income-payment']                                  = 'home/personal/affiliate_manager_payment_acc';
        $route['affiliate/income-payment-account']                          = 'home/personal/affiliate_payment_show_create';
        $route['affiliate/income-payment-account-edit/(:num)']              = 'home/personal/affiliate_payment_show_edit/$1';
        $route['affiliate/income-payment-account/(create|edit)?']           = 'home/personal/affiliate_payment_action/$1';
        $route['affiliate/statistic']                                       = 'home/personal/affiliate_statistic';
        // end

        $route['profile/affiliate/addservice']                              = 'home/personal/ajaxAddAffiliate';
        $route['profile/affiliate/editlevel']                               = 'home/personal/ajaxEditAffiliate';
        $route['profile/affiliate/getservice']                              = 'home/personal/ajaxGetService';
        $route['profile/affiliate/editservice']                             = 'home/personal/ajaxEditService';
        $route['profile/affiliate/deleteservice']                           = 'home/personal/ajaxDeleteService';
        $route['affiliate/getlistparent']                              = 'home/personal/ajaxGetListAffP';
        $route['affiliate/checkparent']                              = 'home/personal/ajaxcheckAffliateOwner';
        $route['affiliate/choseparent/(:num)']                              = 'home/personal/ajaxChoseParrent/$1';

        $route['account/updateprofile'] = 'home/user/updateprofile';
        $route['resume/(:num)/(:any)'] = 'home/user/viewresume/$1'; 
        $route['profile/(:num)/(:any)'] = 'home/user/viewprofile/$1';

        $route['account/collection.*'] = 'home/account/collection';



        //Start Cron
        $route['cron/commission'] = 'home/cron/commission';
        $route['cron/test'] = 'home/cron/test';
        $route['cron/backupdatabse/(:any)'] = 'home/cron/backupDatabase/$1';
        $route['cron/money'] = 'home/cron/money';
        $route['cron/ghnUpdateOrder'] = 'home/cron/ghnUpdateOrder';
        $route['cron/cron24hDelivery'] = 'home/cron/cron24hDelivery';
        $route['cron/cronDelivery'] = 'home/cron/cronDelivery';
        $route['cron/calculate_money_store'] = 'home/cron/calculate_money_store';
        $route['cron/calculate_money_store_custom'] = 'home/cron/calculate_money_store_custom_weekly';
        $route['cron/ghnOrderComplete'] = 'home/cron/ghnOrderComplete';
        $route['cron/cancelOrder'] = 'home/cron/cancelOrder';
        $route['cron/message'] = 'home/cron/message';
        $route['cron/removesession'] = 'home/cron/removeSessionDaily';
        $route['cron/updatedomainmap'] = 'home/cron/updateDomainMapToFile';

        //End Cron 3
        $route['thong-bao-dich-vu-gian-hang'] = 'home/product/noticeServicePackage';
        // Edit here
        #404
        $route['page-not-found'] = 'home/notfound/index';
        $route['administ/banking'] = 'administ/account/test';
        $route['change-delivery'] = 'home/changedelivery';
        $route['change-delivery/(:num)'] = 'home/changedelivery/index/$1';
        $route['check-delivery'] = 'home/changedelivery/checkDelivery';

        $route['submit-request-delivery'] = 'home/changedelivery/submitDelivery';
        $route['submit-request-delivery/(:num)'] = 'home/changedelivery/submitDelivery/$1';
        $route['account/historyRecharge'] = 'home/account/historyRecharge';
        $route['account/historyRecharge/(:any)'] = 'home/account/historyRecharge';

        $route['account/historyRechargeNL'] = 'home/account/historyRechargeNL';
        $route['account/historyRechargeNL/(:any)'] = 'home/account/historyRechargeNL';

        //Bao them vao
        $route['recharge.*'] = 'administ/recharge/index';
        $route['recharge.*'] = 'administ/recharge/$1/$2';
        $route['recharge/page/*'] = 'administ/recharge/$1/$2';

        $route['administ/recharge.*'] = 'administ/recharge/index';
        $route['administ/recharge.*'] = 'administ/recharge/index/$1/$2';
        $route['administ/recharge/page/*'] = 'administ/recharge/index/$1/$2';

        //Lợi Thêm vào
        $route['administ/recharge/Checkpass'] = 'administ/recharge/Checkpass';
        $route['administ/recharge/updateStatus'] = 'administ/recharge/updateStatus';
        $route['administ/recharge/AdminActive'] = 'administ/recharge/AdminActive';
        $route['administ/recharge/AdminDelete'] = 'administ/recharge/AdminDelete';


        // Chi nhanh news
        $route['page-business'] = 'home/page_business/index';
        $route['page-business/(:num)'] = 'home/page_business/manager/$1';
        $route['page-business/add-branch'] = 'home/page_business/add_branch';
        $route['page-business/config-branch/(:num)'] = 'home/page_business/config_branch/$1';
        $route['page-business/news/(:num)'] = 'home/page_business/news/$1';
        // $route['page-business/news/(:num)/(:num)'] = 'home/page_business/news/$1/$2';
        $route['page-business/send-news-branch'] = 'home/page_business/send_news_branch';

        $route['page-business/products/(:num)'] = 'home/page_business/products/$1';
        $route['page-business/products/(:num)/(:num)'] = 'home/page_business/products/$1/$2';
        $route['page-business/send-product-branch'] = 'home/page_business/send_product_branch';

        $route['page-business/list-news/(:num)'] = 'home/page_business/list_news/$1';
        $route['page-business/list-news/(:num)/(:num)'] = 'home/page_business/list_news/$1/$2';

        $route['page-business/list-product/(:num)'] = 'home/page_business/list_product/$1';
        $route['page-business/list-product/(:num)/(:num)'] = 'home/page_business/list_product/$1/$2';

        $route['page-business/list-coupon/(:num)'] = 'home/page_business/list_coupon/$1';
        $route['page-business/list-coupon/(:num)/(:num)'] = 'home/page_business/list_coupon/$1/$2';

        $route['page-business/create-voucher/(:num)'] = 'home/page_business/backend_create_voucher/$1';
        $route['page-business/list-voucher/(:num)'] = 'home/page_business/backend_list_voucher/$1';
        $route['page-business/list-voucher/(:num)/detail'] = 'home/page_business/backend_create_voucher/$1';

        $route['page-business/active-content-branch'] = 'home/page_business/active_content_branch';
        $route['page-business/remove-content-branch'] = 'home/page_business/remove_content_branch';
        

        $route['page-business/coupons/(:num)'] = 'home/page_business/coupons/$1';
        $route['page-business/coupons/(:num)/(:num)'] = 'home/page_business/coupons/$1/$2';
        $route['page-business/pro-status'] = 'home/page_business/pro_status';
        $route['page-business/news-status'] = 'home/page_business/news_status';

        $route['page-business/list-branch/(:num)'] = 'home/page_business/list_branch/$1';
        $route['page-business/list-branch/(:num)/(:num)'] = 'home/page_business/list_branch/$1/$2';
        $route['page-business/list-news-branch/(:num)'] = 'home/page_business/list_news_branch/$1';
        $route['page-business/list-news-branch/(:num)/(:num)'] = 'home/page_business/list_news_branch/$1/$2';
        $route['page-business/list-product-branch/(:num)'] = 'home/page_business/list_product_branch/$1';
        $route['page-business/list-product-branch/(:num)/(:num)'] = 'home/page_business/list_product_branch/$1/$2';
        $route['page-business/list-coupon-branch/(:num)'] = 'home/page_business/list_coupon_branch/$1';
        $route['page-business/list-coupon-branch/(:num)/(:num)'] = 'home/page_business/list_coupon_branch/$1/$2';

        $route['page-business/get-setting-branch'] = 'home/page_business/get_setting_branch';

        $route['page-business/choose-product-branch'] = 'home/page_business/choose_product_branch';
        $route['page-business/choose-content-branch'] = 'home/page_business/choose_content_branch';

        $route['page-business/listaffiliate/(:num)'] = 'home/page_business/getAffilateUser/$1';
        $route['page-business/inviteaffiliate/(:num)'] = 'home/page_business/inviteAffilateUser/$1';

        $route['page-business/list-order/(:num)'] = 'home/page_business/list_order/$1';
        $route['page-business/list-order/(:num)/view/(:num)'] = 'home/page_business/list_order_item/$1/$2';

        $route['page-business/config/(transport|payment_nl)?/(:num)'] = 'home/page_business/config_service/$1/$2';

        //user_list_order
        $route['manager/order'] = 'home/page_business/user_list_order';
        $route['manager/order/view/(:num)'] = 'home/page_business/user_list_order_item/$1';

        // search product azibai
        $route['find-product'] = 'home/market/search_product';

        //Chi nhanh by Bao Tran
		$route['account/addbranch'] = 'home/register';
		$route['account/listbranch'] = 'home/account/listbranch';        
		$route['account/dsbran.*'] = 'home/account/listbranch';
		$route['branch/configforbranch/(:num)'] = 'home/branch/configforbranch/$1';
		$route['branch/prowaitingapprove'] = 'home/branch/prowaitingapprove';
		$route['branch/flyerwaitapprove'] = 'home/branch/flyerwaitapprove';
		$route['branch/deletebranch/(:num)'] = 'home/branch/deletebranch/$1';
		$route['branch/deleteflyer/(:num)'] = 'home/branch/deleteflyer/$1';
		$route['branch/prowaitingapprove.*'] = 'home/branch/prowaitingapprove';
		$route['branch/newswaitapprove'] = 'home/branch/newswaitapprove';
		$route['branch/deletenews/(:num)'] = 'home/branch/deletenews/$1';
		$route['account/profromshop.*'] = 'home/product/profromshop';		
		$route['account/coufromshop.*'] = 'home/product/profromshop';
		// $route['account/coufromshop/(:num)'] = 'home/product/profromshop/$1';
		$route['account/cancelsale'] = 'home/product/cancelsale';
        $route['account/ajaxClone'] = 'home/product/ajaxClone';

        //Nhan vien Gian Hang by Bao Tran
        $route['account/addstaffstore'] = 'home/register';
        $route['account/editstaffstore.*'] = 'home/account/edit';
        $route['account/liststaffstore'] = 'home/account/liststaffstore';
        $route['account/liststaffstore.*'] = 'home/account/liststaffstore';
        $route['account/shop/domain'] = 'home/account/domain';

        //Nhan vien hanh chinh
        $route['account/addsubadmin'] = 'home/register/addsubadmin';
	    $route['account/editsubadmin/(:num)'] = 'home/register/editsubadmin/$1';

        $route['account/listsubadmin.*'] = 'home/account/listsubadmin';
        $route['account/configsubadmin/(:num)'] = 'home/account/configsubadmin/$1';
        
        //Menu Nhan vien
        $route['account/menu/(:num)'] = 'home/register/menuEmpRedirect/$1';
        $route['account/emp-addbranch'] = 'home/nhanvien/invited_branch';
        $route['account/emp-listaffiliate'] = 'home/nhanvien/list_affiliate_invited';
        $route['account/emp-listaffiliate/page/(:num)'] = 'home/nhanvien/list_affiliate_invited';
        $route['account/emp-listbranch'] = 'home/nhanvien/list_branch_invited';
        $route['account/emp-listbranch/page/(:num)'] = 'home/nhanvien/list_branch_invited';
        $route['account/emp-complaintsOrders'] = 'home/nhanvien/comment_processing';
        $route['account/emp-complaintsOrders/page/(:num)'] = 'home/nhanvien/comment_processing';
        $route['account/emp-product'] = 'home/nhanvien/listProductCouponPostByNV';
        $route['account/emp-product/search/(:any)/sort/(:any)/(:any)/page/(:num)'] = 'home/nhanvien/listProductCouponPostByNV';
        $route['account/emp-product/product/edit/(:num)'] = 'home/account/product';
        $route['account/emp-coupon'] = 'home/nhanvien/listProductCouponPostByNV';
        $route['account/emp-coupon/search/(:any)/sort/(:any)/(:any)/page/(:num)'] = 'home/nhanvien/listProductCouponPostByNV';
        $route['account/emp-coupon/product/edit/(:num)'] = 'home/account/product';
        //action loadview nhanvien
        $route['account/affiliate/empid/(:num)'] = 'home/nhanvien/invited_ctv/$1';

        // Group trade
        $route['grouptrade'] = 'home/grouptrade/channel';
        $route['grouptrade/type/(:num)'] = 'home/grouptrade/channel/$1';        
        $route['grouptrade/(:num)/default'] = 'home/grouptrade/index';
        $route['grouptrade/introduce'] = 'home/grouptrade/introduce';
        $route['grouptrade/products'] = 'home/grouptrade/products';
        $route['grouptrade/products/page.*'] = 'home/grouptrade/products';
        $route['grouptrade/repinvite'] = 'home/grouptrade/repinvite'; // ajax

        $route['grouptrade/add'] = 'home/grouptrade/add';
        $route['grouptrade/(:num)/updatecontact'] = 'home/grouptrade/updatecontact';
        $route['grouptrade/(:num)/updateadmin'] = 'home/grouptrade/updateadmin';
        $route['grouptrade/(:num)/updatestore'] = 'home/grouptrade/updatestore';
        $route['grouptrade/(:num)/updatebank'] = 'home/grouptrade/updatebank';       
        $route['grouptrade/(:num)/updatedomain'] = 'home/grouptrade/updatedomain';        
        $route['grouptrade/(:num)/updateslideshow'] = 'home/grouptrade/updateslideshow';        
        $route['grouptrade/(:num)/updatebannerfloor'] = 'home/grouptrade/updatebannerfloor';        

        $route['grouptrade/(:num)/approvenews'] = 'home/grouptrade/approvenews';
        $route['grouptrade/(:num)/approvenews.*'] = 'home/grouptrade/approvenews';
        $route['grouptrade/(:num)/duyetGroupNews.*'] = 'home/grouptrade/duyetNews';

        $route['grouptrade/(:num)/approveproduct'] = 'home/grouptrade/approveproduct';
        $route['grouptrade/(:num)/approveproduct.*'] = 'home/grouptrade/approveproduct';
        $route['grouptrade/(:num)/duyetGroupPro'] = 'home/grouptrade/duyetsp';

        $route['grouptrade/(:num)/invitemember'] = 'home/grouptrade/invitemember';        
        $route['grouptrade/(:num)/listmember'] = 'home/grouptrade/listmember';
        $route['grouptrade/(:num)/listmember/duyet/(:num)'] = 'home/grouptrade/listmember';
        $route['grouptrade/(:num)/listmember/loai/(:num)'] = 'home/grouptrade/listmember';
        $route['grouptrade/(:num)/listorder/product'] = 'home/grouptrade/listorder';
        $route['grouptrade/(:num)/listorder/product.*'] = 'home/grouptrade/listorder';
        $route['grouptrade/(:num)/listorder/coupon.*'] = 'home/grouptrade/listorder';
        $route['grouptrade/(:num)/orderdetail/(:num)'] = 'home/grouptrade/orderdetail/$1';
        $route['grouptrade/(:num)/statisticsgeneral'] = 'home/grouptrade/statisticsgeneral';
        $route['grouptrade/(:num)/statisticsincome'] = 'home/grouptrade/statisticsincome';
        $route['grouptrade/(:num)/detail_statis_income/(:num)'] = 'home/grouptrade/detail_statis_income';
        $route['grouptrade/(:num)/statisticsadmin'] = 'home/grouptrade/statisticsadmin';
        $route['grouptrade/(:num)/statisticsshop'] = 'home/grouptrade/statisticsshop';

        // Group trade account
        $route['account/group/mychannel'] = 'home/grouptrade/mychannel';
        $route['account/group/joinchannel'] = 'home/grouptrade/joinchannel';       
        $route['account/groups/approvemember/(:any)'] = 'home/grouptrade/listmember_account/$1';
        $route['account/groups/approvemember/page.*'] = 'home/grouptrade/listmember_account';
        $route['account/groups/approvenews/(:num)'] = 'home/grouptrade/listnews/$1';
        $route['account/groups/approvenews/(:num)/page.*'] = 'home/grouptrade/listnews/$1';
        $route['account/grouptrade/duyetNews.*'] = 'home/grouptrade/duyetNews';
        $route['account/groups/approveproduct/(:num)'] = 'home/grouptrade/product/$1';
        $route['account/groups/approveproduct/(:num)/page.*'] = 'home/grouptrade/product/$1';
        $route['account/grouptrade/duyetsp.*'] = 'home/grouptrade/duyetsp';
        $route['account/groups/configcommiss/(:num)'] = 'home/grouptrade/configcommiss/$1'; 
        $route['account/groups/leavegroup/(:num)'] = 'home/grouptrade/leavegroup';      
        $route['account/groups/deletegroup/(:num)'] = 'home/grouptrade/deletegroup';

        // Flatform D2
        $route['account/flatformd2/add'] = 'home/flatform/add';
        $route['account/flatformd2/joinshop'] = 'home/flatform/joinshop';

        //Collection
        $route['collection/ajax_createCollection'] = 'home/shop/ajax_createCollection';
        $route['collection/ajax_createCollectionContent/(:num)/(:num)'] = 'home/shop/ajax_createCollectionContent/$1/$2';
        $route['collection/ajax_loadCollection/(:num)/(:num)'] = 'home/shop/ajax_loadCollection/$1/$2';
        $route['collection/ajax_createCollection_choose'] = 'home/shop/ajax_createCollection_choose';
        $route['collection/ajax_Save_CustomLink_Collection'] = 'home/shop/ajax_Save_CustomLink_Collection';
        $route['collection/ajax_loadAll_Collection_CheckExist_Node/(:num)/(:num)'] = 'home/shop/ajax_loadAll_Collection_CheckExist_Node/$1/$2';

        //quick-view
        // $route['quick-view/link/(:num)'] = 'home/tintuc/quick_view/$1';
        // $route['quick-view/product/(:num)'] = 'home/tintuc/quick_view/$1';
        $route['quick-view/(:num)'] = 'home/tintuc/quick_view/$1';

        ########################DOMAINSHOP.COM/SHOP SERVICE###############
        $route['shop/service']                            = 'home/shop/shopServices';
        $route['shop/serviceuse']                         = 'home/shop/shopServicesUse';
        $route['shop/service/detail/(:num)']              = 'home/shop/shopServicesDetail/$1';
        $route['shop/service/notify']                     = 'home/shop/shopServicesSuccess';
        $route['shop/service/up-package']                 = 'home/shop/upPackage';
        $route['shop/service/cancel-notify']              = 'home/shop/shopCancelNotify';

        //--------------------------------AZIBAI------------------------------------//
        $route['stipulation'] = 'home/azibai/dieukhoan'; //Dieu khoan su dung azibai
        $route['agreement'] = 'home/azibai/thoathuan'; //Thoa thuan dich vu azibai
    	break;
}
//Test connect api ghtk
$route['testconnect'] = 'home/showcart/TestConnectGHTK';
$route['cron/tinhtienthem'] = 'home/cron/calculate_commission_bonus_affiliate';






