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
        $route['default_controller'] = 'home/market/ecommerce';
        $route['login'] = 'home/login';
        $route['logout'] = 'home/login/logout';

        //Quan ly trang
        $route['page-business'] = 'home/page_business/index';
        $route['page-business/list-product/(:num)'] = 'home/page_business/list_product/$1';
        $route['page-business/list-product/(:num)/(:num)'] = 'home/page_business/list_product/$1/$2';

        $route['page-business/list-coupon/(:num)'] = 'home/page_business/list_coupon/$1';
        $route['page-business/list-coupon/(:num)/(:num)'] = 'home/page_business/list_coupon/$1/$2';

        //Sản phẩm
        $route['(:num)/(:num)/(:any)'] = 'home/product/detail_product/$2'; // chi tiet sp
        $route['product/add/(:num)'] = 'home/product/addProduct/$1'; // add sp
        $route['product/ajaxAdd'] = 'home/product/ajaxAddProduct'; // ajax Add

        $route['product/edit/(:num)/(:any)'] = 'home/product/editProduct/$1'; // edit sp
        $route['product/ajaxEdit'] = 'home/product/ajaxEditProduct'; // ajax Add
        
        $route['product/ajax'] = 'home/product/ajax'; //load cat

        //get district
        $route['ajaxDistrict'] = 'home/product/ajaxDistrict'; //load cat

        // admin-page
        $route['admin']           = 'admin/login';
        $route['admin/logout']    = 'admin/logout';

        $route['admin/notifications']  = 'admin/notifications/index';
        $route['admin/notifications/(:num)']  = 'admin/notifications/index/$1';

        $route['account/edit'] = 'home/account/edit';
        $route['account/product.*'] = 'home/account/product';
        // $route['account/product/product'] = 'home/account/edit';
    	break;
}
//Test connect api ghtk
$route['testconnect'] = 'home/showcart/TestConnectGHTK';
$route['cron/tinhtienthem'] = 'home/cron/calculate_commission_bonus_affiliate';






