<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

#BEGIN: File mode
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);


#MoMo
define('PARTNER_CODE', 'MOMOTZG920190528');
define('ACCESS_KEY', 'gBRYhT9pnewlrS4J');
define('SERECT_KEY', 'FWsduHHOVgxAxtus8ZmLVoCAIpO6yoKZ');
define('END_POINT', 'https://payment.momo.vn/gw_payment/transactionProcessor');

// dev
// define('PARTNER_CODE', 'MOMOTZG920190528');
// define('ACCESS_KEY', 'RaGwUcGQsmw78ELE');
// define('SERECT_KEY', 'UAUoKa3QWGoXPbMpqXX5dPWOVgpmfEkZ');
// define('END_POINT', 'https://test-payment.momo.vn/gw_payment/transactionProcessor');
#End MoMo

#END File mode
#BEGIN: Fopen file
define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); 
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b');
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
#END Fopen file

define('PAYMENT_USER_ID', 1);
define('AF_OFF', 1);

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define( 'FACEBOOK_ID',			'369989080389798');
define( 'FACEBOOK_SERECT',			'15c975c90842eb437925b346f4b959ef');
define( 'FACEBOOK_FIELD',			'name,gender,email,birthday,hometown,locale,religion,photos');
define( 'FACEBOOK_PERMISSION',			'public_profile,email');
define('GG_APP_ID', '621083596927-i47ls5eq20oqinrspd5h3fa5nf1sj6s8.apps.googleusercontent.com');
define('GG_APP_SERET', 'dXGUEvV3JQ4FV04lZ9zFgZ5g');
define('GOOGLE_KEY', 'AIzaSyAipO1bVSILfi92kyndTHikxF_OjzUZ6wM');
define( 'GOOGLE_SCOPE', 'profile email'); // https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.login
define('GG_SCOPES', 'https://www.googleapis.com/auth/plus.login,https://www.googleapis.com/auth/plus.me,https://www.googleapis.com/auth/userinfo.email,https://www.googleapis.com/auth/userinfo.profile');

// Define param sequence to get $this->uri->segment(param);
// Use for subdomain
// Get segment First
define('segmentFirst', 1);
define('segmentSecond', 2);
define('segmentThird', 3);
define('segmentFourth', 4);
define('segmentFifth', 5);

define('COLLECTION_CONTENT', 1);
define('COLLECTION_PRODUCT', 2);
define('COLLECTION_CUSTOMLINK', 3);
define('COLLECTION_COUPON', 4);
define('COLLECTION_IMAGE', 5);
define('COLLECTION_VIDEO', 6);

define('CUSTOMLINK_CONTENT', 'content');
define('CUSTOMLINK_COLLECTION', 'collection');
define('CUSTOMLINK_IMAGE', 'image');
define('CUSTOMLINK_PRODUCT', 'product');
define('CUSTOMLINK_LINK', 'link');
define('CUSTOMLINK', '["'.CUSTOMLINK_CONTENT.'", "'.CUSTOMLINK_COLLECTION.'", "'.CUSTOMLINK_IMAGE.'", "'.CUSTOMLINK_PRODUCT.'", "'.CUSTOMLINK_LINK.'"]');

define('ALBUM_IMAGE', 1);
define('ALBUM_PRODUCT', 2);
define('ALBUM_VIDEO', 3);
define('ALBUM_COUPON', 4);

define('PERMISSION_SOCIAL_ALL', 0);
define('PERMISSION_SOCIAL_PUBLIC', 1);
define('PERMISSION_SOCIAL_FRIEND', 2);
define('PERMISSION_SOCIAL_ME', 3);

define('IMAGE_1X1', '1x1_');
define('IMAGE_FULL', 'full_');

define('IMAGE_UP_DETECT_CONTENT', 0);
define('IMAGE_UP_DETECT_LIBRARY', 1);

define('ALBUM_AZI_TRUE', 1);
define('ALBUM_AZI_FALSE', 0);

define('LINK_TABLE_LIBRARY', 'tbtt_lib_links');
define('LINK_TABLE_CONTENT', 'tbtt_content_links');
define('LINK_TABLE_IMAGE', 'tbtt_content_image_links');

define('NEWS_FILTER', '["all","shop","user"]');

define('SHOP_DOMAIN', 'shop');
define('AZIBAI_DOMAIN', 'azibai');
define('PERSONAL_DOMAIN', 'personal');

//API

define('API_COM', 'http://api.azibai.com/api/v1');

define('LINK_BUSINESS_NEWS', 'http://azibuy.info/api/v1/admin/notifications/business-news');
define('LINK_PERSONAL_NEWS', 'http://azibuy.info/api/v1/admin/notifications/personal-news');
define('LINK_LINKS', 'http://azibuy.info/api/v1/admin/notifications/links');
define('LINK_NOTIFICATION', 'http://azibuy.info/api/v1/admin/notifications/news');
define('LINK_NOTIFICATION_LINK', 'http://azibuy.info/api/v1/admin/notifications/link');
define('LINK_AZI', 'http://azibuy.info/api/v1/admin/notifications/general');

define('LINK_LIST_USERS', 'http://azibuy.info/api/v1/admin/user/get-user');
define('LINK_STATUS_USERS', 'http://azibuy.info/api/v1/admin/user/change-status');
define('LINK_PUSH_BLOCK_NEWS', 'http://azibuy.info/api/v1/admin/user/change-show-on-homepage');

define('API_SEARCH_USER', 'http://search.azibai.com:9000/search-personal');
define('API_UPDATE_USER', 'http://search.azibai.com:9000/sync-friend-update');
define('API_DELETE_USER', 'http://search.azibai.com:9000/sync-friend-delete');

define('API_UPDATE_SEARCH_ARTICLE',  API_SEARCH.'sync-article-update?article_id=');
define('API_DELETE_SEARCH_ARTICLE', API_SEARCH.'sync-article-delete?article_id=');

define('API_LISTSHARE_CONTENT', API_COM.'/list-share-content');
define('API_LISTSHARE_IMAGE', API_COM.'/list-share-image');
define('API_LISTSHARE_VIDEO', API_COM.'/list-share-video');
define('API_LISTSHARE_LINK', API_COM.'/list-share-link/content');
define('API_LISTSHARE_COLLECTION', API_COM.'/list-share-collection');

define('API_PUSH_SHARE', API_COM.'/share-out/push');
//END API

define('TYPESHARE_AZI_HOME',1);//Trang chủ azi
define('TYPESHARE_AZI_FILTERSHOP',2);//Trang cộng đồng
define('TYPESHARE_AZI_FILTERUSER',3);//Trang cá nhân
define('TYPESHARE_AZI_CATNEWS',4);//Trang danh mục tin
define('TYPESHARE_AZI_QUICKVIEW',5);//Trang xem nhanh liên kết và sp trong tin 
define('TYPESHARE_AZI_PRO',6);//Trang sản phẩm
define('TYPESHARE_AZI_CATPRODUCT',7);//Trang danh mục sản phẩm
define('TYPESHARE_AZI_COUPON',8);//Trang phiếu mua hàng
define('TYPESHARE_AZI_CATCOUPON',9);//Trang danh mục pmh
define('TYPESHARE_AZI_GALLERYPRO',10);
define('TYPESHARE_AZI_GALLERYCOU',11);
define('TYPESHARE_AZI_CART',12);//Trang giỏ hàng
define('TYPESHARE_AZI_SEARCHNEWS',13);//Trang tìm tin tức
define('TYPESHARE_AZI_SEARCHPRODUCT',14);//Trang tìm sản phẩm
define('TYPESHARE_AZI_SEARCHCOUPON',15);//Trang tìm pmhang
define('TYPESHARE_AZI_DETAIL_SERVICE',15);//Trang tìm pmhang

define('TYPESHARE_SHOP_HOME',16);//Trang chủ gian hàng
define('TYPESHARE_SHOP_PAGESHOP',17);//Trang cửa hàng của gian hàng
define('TYPESHARE_SHOP_ALLPRODUCT',18);//Trang tất cả sản phẩm của gian hàng
define('TYPESHARE_SHOP_ALLCOUPON',19);//Trang tất cả pmh của gian hàng
define('TYPESHARE_SHOP_LIBLINK',20);//Trang thư viện liên kết của gian hàng
define('TYPESHARE_SHOP_LIBLINKTAB',21);//Trang chi tiết tvien liên kết theo tung tab gian hàng
define('TYPESHARE_SHOP_LIBIMAGE',22);//Trang thư viện ảnh của gian hàng
define('TYPESHARE_SHOP_LIBVIDEO',23);//Trang thư viện video của gian hàng
define('TYPESHARE_SHOP_LIBPRODUCT',24);//Trang thư viện sản phẩm của gian hàng
define('TYPESHARE_SHOP_LIBCOUPON',25);//Tvien pmh của gh
define('TYPESHARE_SHOP_COLLECTNEWS',26);//Trang bộ sưu tập tin của gh
define('TYPESHARE_SHOP_COLLECTPRODUCT',27);//Bst sp của gh
define('TYPESHARE_SHOP_COLLECTCOUPON',28);//Bst pmh của gh
define('TYPESHARE_SHOP_COLLECTLINK',29);//Bst link
define('TYPESHARE_SHOP_RECRUITMENT',30);//Trang tuyển dụng
define('TYPESHARE_SHOP_WARRANTY',31);//Trang chính sách
define('TYPESHARE_SHOP_INTRODUCT',32);//Trang giới thiệu
define('TYPESHARE_SHOP_CONTACT',33);//Trang liên hệ
define('TYPESHARE_SHOP_SEARCHNEWS',34);//Trang tìm tin của gian hàng
define('TYPESHARE_SHOP_SEARCHPRODUCT',35);//Tìm sp của gh
define('TYPESHARE_SHOP_SEARCHCOUPON',36);//Tìm pmh của gh
define('TYPESHARE_SHOP_NEWS',80);//share news trên feed của shop

define('TYPESHARE_PROFILE_HOME',37);//Trang dòng thời gian profile
define('TYPESHARE_PROFILE_FRIENDS',38);//Trang bạn bè profile
define('TYPESHARE_PROFILE_ABOUT',39);//Giới thiệu về profile
define('TYPESHARE_PROFILE_LIBIMG',40);//Tvien ảnh profile
define('TYPESHARE_PROFILE_LIBVIDEO',41);//Tvien video profile
define('TYPESHARE_PROFILE_LIBLINK',42);//Tvien liên kết profile
define('TYPESHARE_PROFILE_LIBLINKTAB',43);//Trang chi tiết tvien liên kết theo tung tab profile
define('TYPESHARE_PROFILE_SHOP',44);//Trang gian hàng profile
define('TYPESHARE_PROFILE_ALLPRODUCT',45);//Trang tất cả sp profile
define('TYPESHARE_PROFILE_ALLCOUPON',46);//Trang tất cả pmh profile
define('TYPESHARE_PROFILE_SEARCHNEWS',47);//Trang tìm kiếm tin tức profile
define('TYPESHARE_PROFILE_SEARCHPRODUCT',48);//Trang tìm kiếm sp profile
define('TYPESHARE_PROFILE_SEARCHCOUPON',49);//Trang tìm kiếm pmh profile
define('TYPESHARE_PROFILE_COLLECTNEWS',75);//Trang bộ sưu tập tin cá nhân
define('TYPESHARE_PROFILE_COLLECTPRODUCT',76);//Bst sp cá nhân
define('TYPESHARE_PROFILE_COLLECTCOUPON',77);//Bst pmh cá nhân
define('TYPESHARE_PROFILE_COLLECTLINK',78);//Bst link cá nhân
define('TYPESHARE_PROFILE_NEWS',81);//share news trên feed của user

define('TYPESHARE_DETAIL_PRODUCT',50);//Trang chi tiết sp
define('TYPESHARE_DETAIL_COUPON',51);//Trang chi tiết pmh
define('TYPESHARE_DETAIL_SHOPNEWS',52);//Trang chi tiết tin tức gian hang
define('TYPESHARE_DETAIL_PRFNEWS',53);//Trang chi tiết tin tức profile
define('TYPESHARE_DETAIL_SHOPCOLLNEWS',54);//Trang chi tiết bst tin gian hàng
define('TYPESHARE_DETAIL_SHOPCOLLPRODUCT',55);//Trang chi tiết bst sp gian hàng
define('TYPESHARE_DETAIL_SHOPCOLLCOUPON',56);//Trang chi tiết bst pmh gian hàng
define('TYPESHARE_DETAIL_SHOPCOLLLINK',57);//Trang chi tiết bst liên kết gian hàng
define('TYPESHARE_DETAIL_SHOPLIBIMG',58);//Trang chi tiết tvien ảnh gian hàng
define('TYPESHARE_DETAIL_SHOPLIBVIDEO',59);//Trang chi tiết tvien video gian hàng
define('TYPESHARE_DETAIL_SHOPLIBLINK',60);//Trang chi tiết tvien liên kết gian hàng
define('TYPESHARE_DETAIL_PRFLIBIMG',61);//Trang chi tiết tvien ảnh profile
define('TYPESHARE_DETAIL_PRFLIBVIDEO',62);//Trang chi tiết tvien video profile
define('TYPESHARE_DETAIL_PRFLIBLINK',63);//Trang chi tiết tvien liên kết profile
define('TYPESHARE_DETAIL_SHOPLINK_CONTENT', 64);//Trang chi tiết liên kết tin của gian hàng
define('TYPESHARE_DETAIL_SHOPLINK_IMG', 65);// Trang chi tiết liên kết ảnh của gian hàng
define('TYPESHARE_DETAIL_PRFLINK_CONTENT', 66);// Trang chi tiết liên kết tin của cá nhân
define('TYPESHARE_DETAIL_PRFLINK_IMG', 67);// Trang chi tiết liên kết ảnh của cá nhân
define('TYPESHARE_DETAIL_HOMENEWS', 82);// trang chi tiết tin tức khi user từ home page đi vào

define('TYPESHARE_AZI_LINK', 68);//vd: http://azibai.xyz/links
define('TYPESHARE_AZI_TABLINK', 69);//vd: http://azibai.xyz/links/giai-tri
define('TYPESHARE_AZI_DETAIL_LINK', 70);//vd: http://azibai.xyz/links/library-link/136

define('TYPESHARE_DETAIL_SHOPIMG', 71); //Trang chi tiet từng ảnh cua shop.
//vd: Chưa được dựng trên web
define('TYPESHARE_DETAIL_SHOPVIDEO', 72); //Trang chi tiết từng video của shop
//vd: Chưa được dựng trên web
define('TYPESHARE_DETAIL_PRFIMG', 73); //Trang chi tiết từng ảnh của profile
//vd: Chưa được dựng trên web
define('TYPESHARE_DETAIL_PRFVIDEO', 74); //Trang chi tiết từng video của profile
//vd: Chưa được dựng trên web
define('TYPESHARE_HOME_NEWS', 79); //Trang chi tiết từng video của profile
//vd: Chưa được dựng trên web
// ------------------------------------------------------------------------
// Search
// ------------------------------------------------------------------------
define('FILTER_CONTENT_ALL', 0);
define('FILTER_CONTENT_PERSONAL', 1);
define('FILTER_CONTENT_COMPANY', 2);
define('FILTER_CONTENT_GROUP', 3);
define('FILTER_CONTENT_SEEN', 4);

define('FILTER_COMPANY_ALL', 0);
define('FILTER_COMPANY_FOLLOW', 1);

define('FILTER_COMPANY_TYPE_ALL', 0);
define('FILTER_COMPANY_TYPE_MOST_FOLLOW', 1);
define('FILTER_COMPANY_TYPE_MOST_PRODUCT', 2);

define('FILTER_IMAGE_ALL', 0);
define('FILTER_IMAGE_SHOP', 1);
define('FILTER_IMAGE_FRIEND', 2);
define('FILTER_IMAGE_GROUP', 3);

define('FILTER_IMAGE_TYPE_ALL', 0);
define('FILTER_IMAGE_TYPE_CONTENT', 1);
define('FILTER_IMAGE_TYPE_ALBUM', 2);
define('FILTER_IMAGE_TYPE_PRODUCT', 3);
define('FILTER_IMAGE_TYPE_LINK', 4);

define('SHOW_ON_HOMEPAGE', 1);
define('NOT_SHOW_ON_HOMEPAGE', 0);

define('STYLE_SHOW_CONTENT', '[0, 1, 2]');
define('STYLE_SHOW_CONTENT_DEFAULT', 0);
define('STYLE_1_SHOW_CONTENT', 1);
define('STYLE_2_SHOW_CONTENT', 2);

define('ICON_TYPE_ANIMATION', 'json');
define('ICON_TYPE_ICON', 'icon');
define('ICON_TYPE_VIDEO', 'video');
define('ICON_TYPE_IMAGE', 'image');
define('ICON_TYPE_AUDIO', 'audio');
const ICON_TYPE = [ICON_TYPE_ICON, ICON_TYPE_VIDEO, ICON_TYPE_IMAGE, ICON_TYPE_AUDIO, ICON_TYPE_ANIMATION];
