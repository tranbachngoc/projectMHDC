<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Router Class
 *
 * Parses URIs and determines routing
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		ExpressionEngine Dev Team
 * @category	Libraries
 * @link		http://codeigniter.com/user_guide/general/routing.html
 */
class CI_Router {

	var $config;
	var $routes			= array();
	var $error_routes	= array();
	var $class			= '';
	var $method			= 'index';
	var $directory		= '';
	var $default_controller;

	/**
	 * Constructor
	 *
	 * Runs the route mapping function.
	 */
	function __construct()
	{
		$this->config =& load_class('Config', 'core');
		$this->uri =& load_class('URI', 'core');
		#BEGIN: Route Default
		$route['default_controller'] = "home/defaults";
		$route['scaffolding_trigger'] = "";
		#END Route Default
		#BEGIN: Administ
		//Default
		$route['administ'] = 'administ/defaults';
		//UpTin
		$route['administ/uptin/thongke'] = 'administ/uptin/thongke';
		$route['administ/uptin/naptien'] = 'administ/uptin/naptien';
		$route['administ/uptin/check_username/([a-zA-Z0-9_-]+)'] = 'administ/uptin/check_username/$1';
		//User
		$route['administ/user/(search|filter|sort|page|status).*'] = 'administ/user';
		$route['administ/user/end/(search|filter|sort|page).*'] = 'administ/user/end';
		$route['administ/user/inactive/(search|filter|sort|page|status).*'] = 'administ/user/inactive';
		$route['administ/user/vip/(search|filter|sort|page|status).*'] = 'administ/user/vip';
		$route['administ/user/vip/end.*'] = 'administ/user/endvip';
		$route['administ/user/saler/(search|filter|sort|page|status).*'] = 'administ/user/saler';
		$route['administ/user/saler/end.*'] = 'administ/user/endsaler';
		$route['administ/user/add'] = 'administ/user/add';
		$route['administ/user/edit/(:num)'] = 'administ/user/edit/$1';
		//Group
		$route['administ/group/(search|filter|sort|page|status).*'] = 'administ/group';
		$route['administ/group/add'] = 'administ/group/add';
		$route['administ/group/edit/(:num)'] = 'administ/group/edit/$1';
		//Category
		$route['administ/category/(search|filter|sort|page|status).*'] = 'administ/category';
		$route['administ/category/add'] = 'administ/category/add';
		$route['administ/category/edit/(:num)'] = 'administ/category/edit/$1';
		// hoi dap
		$route['administ/hoidap/cat'] = 'administ/hoidap/category';
		$route['administ/hoidap/cat/(search|filter|sort|page|status).*'] = 'administ/hoidap/category';
		$route['administ/hoidap/cat/add'] = 'administ/hoidap/categoryadd';
		$route['administ/hoidap/cat/edit/(:num)'] = 'administ/hoidap/categoryedit/$1';
		$route['administ/hoidap'] = 'administ/hoidap';
		$route['administ/hoidap/(search|filter|sort|page|status).*'] = 'administ/hoidap';
		//manufacturer
		$route['administ/manufacturer/(search|filter|sort|page|status).*'] = 'administ/manufacturer';
		$route['administ/manufacturer/add'] = 'administ/manufacturer/add';
		$route['administ/manufacturer/edit/(:num)'] = 'administ/manufacturer/edit/$1';
		
		//Field
		$route['administ/field/(search|filter|sort|page|status).*'] = 'administ/field';
		$route['administ/field/add'] = 'administ/field/add';
		$route['administ/field/edit/(:num)'] = 'administ/field/edit/$1';
		//Province
		$route['administ/province/(search|filter|sort|page|status).*'] = 'administ/province';
		$route['administ/province/add'] = 'administ/province/add';
		$route['administ/province/edit/(:num)'] = 'administ/province/edit/$1';
		//Menu
		$route['administ/menu/(search|filter|sort|page|status).*'] = 'administ/menu';
		$route['administ/menu/add'] = 'administ/menu/add';
		$route['administ/menu/edit/(:num)'] = 'administ/menu/edit/$1';
		//Notify
		$route['administ/notify/(search|filter|sort|page|status).*'] = 'administ/notify';
		$route['administ/notify/add'] = 'administ/notify/add';
		$route['administ/notify/edit/(:num)'] = 'administ/notify/edit/$1';
		//Contact
		$route['administ/contact'] = 'administ/contact';
		$route['administ/contact/(search|filter|sort|page|status).*'] = 'administ/contact';
		$route['administ/contact/view/(:num)'] = 'administ/contact/view/$1';
		//Advertise
		$route['administ/advertise/(search|filter|sort|page|status).*'] = 'administ/advertise';
		$route['administ/advertise/end/(search|filter|sort|page).*'] = 'administ/advertise/end';
		$route['administ/advertise/add'] = 'administ/advertise/add';
		$route['administ/advertise/edit/(:num)'] = 'administ/advertise/edit/$1';
		// Top Video
		$route['administ/video/(search|filter|sort|page|status).*'] = 'administ/video';
		$route['administ/video/add'] = 'administ/video/add';
		$route['administ/video/edit/(:num)'] = 'administ/video/edit/$1';
		// Gift
		$route['administ/gift/(search|filter|sort|page|status).*'] = 'administ/gift';
		$route['administ/gift/add'] = 'administ/gift/add';
		$route['administ/gift/edit/(:num)'] = 'administ/gift/edit/$1';
		//Shop
		$route['administ/shop/(search|filter|sort|page|status|guarantee).*'] = 'administ/shop';
		$route['administ/shop/end/(search|filter|sort|page).*'] = 'administ/shop/end';
		$route['administ/shop/add'] = 'administ/shop/add';
		$route['administ/shop/edit/(:num)'] = 'administ/shop/edit/$1';
		//Product
		$route['administ/product'] = 'administ/product';
		$route['administ/product/(search|filter|sort|page|status|vip).*'] = 'administ/product';
		$route['administ/product/bad/(search|filter|sort|page|status|detail).*'] = 'administ/product/bad';
		$route['administ/product/end/(search|filter|sort|page).*'] = 'administ/product/end';
		//Ads
		$route['administ/ads'] = 'administ/ads';
		$route['administ/ads/(search|filter|sort|page|status|vip).*'] = 'administ/ads';
		$route['administ/ads/bad/(search|filter|sort|page|status|detail).*'] = 'administ/ads/bad';
		$route['administ/ads/end/(search|filter|sort|page).*'] = 'administ/ads/end';
		$route['administ/adscategory']  = 'administ/adscategory';
		$route['administ/adscategory/(search|filter|sort|page|status).*'] = 'administ/adscategory';
		$route['administ/adscategory/add']  = 'administ/adscategory/add';
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
		//Config
		$route['administ/system/config'] = 'administ/config';
		$route['administ/system/info'] = 'administ/config/info';
		//Tool
		$route['administ/tool/mail'] = 'administ/tool/mail';
		$route['administ/tool/cache'] = 'administ/tool/cache';
		$route['administ/tool/captcha'] = 'administ/tool/captcha';
		//Logout
		$route['administ/logout'] = 'administ/logout';
		#END Administ
		#BEGIN: Home
		//Defaults
		$route['ajax'] = 'home/defaults/ajax';
		$route['ajax_mancatego'] = 'home/defaults/ajax_mancatego';
		$route['ajax_category'] = 'home/defaults/ajax_category';
		$route['autocomplete/(:any)'] = 'home/defaults/autocomplete';
		$route['ajax_province'] = 'home/defaults/ajax_province';
		$route['ajax_add_to_cart'] = 'home/defaults/ajax_add_to_cart';
		$route['ajax_delete_from_cart'] = 'home/defaults/ajax_delete_from_cart';
		$route['ajax_get_district'] = 'home/defaults/ajax_get_district';
		$route['ajax_add_to_pend_cart'] = 'home/defaults/ajax_add_to_pend_cart';
		$route['ajax_delete_from_pend_cart'] = 'home/defaults/ajax_delete_from_pend_cart';
		$route['ajax_banner'] = 'home/defaults/ajax_banner';
		//Information
		$route['information'] = 'home/information/index';
		//Product
		$route['product/category/(:num)'] = 'home/product/category/$1';
		$route['product/category/(:num)/(:any)'] = 'home/product/category/$1';
		$route['product/category/(:num)/(:any)/sort.*'] = 'home/product/category/$1';
		$route['product/category/(:num)/(:any)/page.*'] = 'home/product/category/$1';
		$route['product/saleoff.*'] = 'home/product/saleoff';
		$route['product/category/detail/(:num)/(:num)/(:any)'] = 'home/product/detail/$1/$2';
		$route['product/category/detail/(:num)/(:num)'] = 'home/product/detail/$1/$2';
		$route['product/post'] = 'home/product/post';
		$route['product/ajax'] = 'home/product/ajax';
		$route['view/category'] = 'home/product/loadCategory_two';
		
		$route['product/all'] = 'home/product/all';
		$route['product/all/sort.*'] = 'home/product/all';
		$route['product/all/page.*'] = 'home/product/all';
		
		$route['product/cheapest/(:num)'] = 'home/product/cheapest/$1';
		$route['product/cheapest/(:num)/sort.*'] = 'home/product/cheapest/$1';
		$route['product/cheapest/(:num)/page.*'] = 'home/product/cheapest/$1';
		
		$route['product/topweek/(:num)'] = 'home/product/topweek/$1';
		$route['product/topweek/(:num)/sort.*'] = 'home/product/topweek/$1';
		$route['product/topweek/(:num)/page.*'] = 'home/product/topweek/$1';
		
		$route['product/topvote'] = 'home/product/topvote';
		$route['product/topvote/sort.*'] = 'home/product/topvote';
		$route['product/topvote/page.*'] = 'home/product/topvote';
		
		$route['product/tag/(:any)']='home/product/tag/$1';
		
		//Ads
		$route['raovat/all'] = 'home/raovat';
		$route['raovat/ajax'] = 'home/raovat/ajax';
		$route['raovat/rSort.*'] = 'home/raovat';
		$route['raovat/nSort.*'] = 'home/raovat';
		$route['raovat/rPage.*'] = 'home/raovat';
		$route['raovat/nPage.*'] = 'home/raovat';
		$route['raovat/category/(:num)/(:any)'] = 'home/raovat/category/$1';
		$route['raovat/category/(:num)/rSort.*'] = 'home/raovat/category/$1';
		$route['raovat/category/(:num)/nSort.*'] = 'home/raovat/category/$1';
		$route['raovat/category/(:num)/rPage.*'] = 'home/raovat/category/$1';
		$route['raovat/category/(:num)/nPage.*'] = 'home/raovat/category/$1';
		$route['raovat/shop.*'] = 'home/raovat/shop';
		$route['raovat/category/detail/(:num)/(:num).*'] = 'home/raovat/detail/$1/$2';
		$route['raovat/post'] = 'home/raovat/post';
		$route['raovat/tag/(:any)']='home/raovat/tag/$1';
		// Top Video
		$route['video'] = 'home/video';
		//Hoi Dap
		$route['hoidap'] = 'home/hoidap';
		$route['hoidap/latest'] = 'home/hoidap/latest';
		$route['hoidap/latest/sort.*'] = 'home/hoidap/latest';
		$route['hoidap/latest/page.*'] = 'home/hoidap/latest';
		$route['hoidap/notanswers'] = 'home/hoidap/notanswers';
		$route['hoidap/notanswers/sort.*'] = 'home/hoidap/notanswers';
		$route['hoidap/notanswers/page.*'] = 'home/hoidap/notanswers';
		$route['hoidap/topanswers'] = 'home/hoidap/topanswers';
		$route['hoidap/topanswers/sort.*'] = 'home/hoidap/topanswers';
		$route['hoidap/topanswers/page.*'] = 'home/hoidap/topanswers';
		$route['hoidap/topviews'] = 'home/hoidap/topviews';
		$route['hoidap/topviews/sort.*'] = 'home/hoidap/topviews';
		$route['hoidap/topviews/page.*'] = 'home/hoidap/topviews';
		$route['hoidap/toplikes'] = 'home/hoidap/toplikes';
		$route['hoidap/toplikes/sort.*'] = 'home/hoidap/toplikes';
		$route['hoidap/toplikes/page.*'] = 'home/hoidap/toplikes';
		$route['hoidap/post'] = 'home/hoidap/post';
		$route['hoidap/ajax'] = 'home/hoidap/ajax';
		$route['hoidap/category/(:num)'] = 'home/hoidap/category/$1';
		$route['hoidap/category/(:num)/(:any)'] = 'home/hoidap/category/$1';
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
		$route['job/field/(:num)'] = 'home/job/field/$1';
		$route['job/field/(:num)/sort.*'] = 'home/job/field/$1';
		$route['job/field/(:num)/page.*'] = 'home/job/field/$1';
		$route['job/field/(:num)/detail/(:num).*'] = 'home/job/detail/$1/$2';
		$route['job/post'] = 'home/job/post';
		//Employ
		$route['employ'] = 'home/employ';
		$route['employ/sort.*'] = 'home/employ';
		$route['employ/page.*'] = 'home/employ';
		$route['employ/field/(:num)'] = 'home/employ/field/$1';
		$route['employ/field/(:num)/sort.*'] = 'home/employ/field/$1';
		$route['employ/field/(:num)/page.*'] = 'home/employ/field/$1';
		$route['employ/field/(:num)/detail/(:num).*'] = 'home/employ/detail/$1/$2';
		$route['employ/post'] = 'home/employ/post';
		//Showcart
		$route['showcart.*'] = 'home/showcart';
		//Notify
		$route['notify/(:num)'] = 'home/notify';
		$route['notify/(:num)/page'] = 'home/notify';
		$route['notify/(:num)/page/(:num)'] = 'home/notify';
		$route['notify/all'] = 'home/notify/all';
		$route['notify/all/page'] = 'home/notify/all';
		$route['notify/all/page/(:num)'] = 'home/notify/all';
		//Guide
		$route['guide'] = 'home/guide';
		//Register
		$route['register'] = 'home/register';
		$route['register/ajax'] = 'home/register/ajax';
		$route['activation/user/(:any)/key/(:any)/token/(:any)'] = 'home/register/activation/$1/$2/$3';
		//Contact
		$route['contact'] = 'home/contact';
		$route['contact/msgsend'] = 'home/contact/msgsupplier';
		//Search
		$route['search/product.*'] = 'home/search/product';
		$route['search/raovat.*'] = 'home/search/raovat';
		$route['search/job.*'] = 'home/search/job';
		$route['search/employ.*'] = 'home/search/employ';
		$route['search/shop.*'] = 'home/search/shop';
		$route['search/hoidap.*'] = 'home/search/hoidap';
		//Login - logout
		$route['login'] = 'home/login';
		$route['logout'] = 'home/login/logout';
		//Forgot
		$route['forgot'] = 'home/forgot';
		$route['forgot/reset/key/(:any)/token/(:any)'] = 'home/forgot/reset/$1/$2';
		//Account
		$route['account'] = 'home/account';
		$route['account/edit'] = 'home/account/edit';
		$route['account/setup_up'] = 'home/account/setup_up';
		$route['account/naptien'] = 'home/account/naptien';
		$route['account/naptien_baokim'] = 'home/account/naptien_baokim';
		$route['account/process_baokim'] = 'home/account/process_baokim';
		$route['account/verifyresponse_baokim'] = 'home/account/verifyresponse_baokim';
		$route['account/fail_transaction_baokim'] = 'home/account/fail_transaction_baokim';
		$route['account/baokim_success'] = 'home/account/baokim_success';
		$route['payment/order_now/(:num)'] = 'home/payment/order_now/$1';
		$route['payment/order_bill/(:num)'] = 'home/payment/order_bill/$1';
		$route['payment/verifyresponse_baokim'] = 'home/payment/verifyresponse_baokim';
		$route['payment/verifyresponse_nganluong'] = 'home/payment/verifyresponse_nganluong';
		$route['product/fail_transaction_baokim'] = 'home/product/fail_transaction_baokim';
		$route['product/baokim_success/(:num)'] = 'home/product/baokim_success/$1';
		$route['account/history_up'] = 'home/account/history_up';
		$route['account/chitietup/(:any)'] = 'home/account/chitietup/$1';
		$route['account/uptin/(:num)/(:num)'] = 'home/account/uptin/$1/$2';
		$route['cronuptin'] = 'home/defaults/cronuptin';
		$route['account/smsuptin'] = 'home/account/smsuptin';
		$route['account/lichsugiaodich'] = 'home/account/lichsugiaodich';
		$route['account/ajax_checkpass'] = 'home/account/ajax_checkpass';
		
		$route['account/gianhang'] = 'home/account/gianhang';
		$route['account/checkid/(:num)/(:num)'] = 'home/account/checkid/$1/$2';
		
		
		$route['account/changepassword'] = 'home/account/changepassword';
		$route['account/shop'] = 'home/account/shop';
		$route['account/notify.*'] = 'home/account/notify';
		$route['account/contact.*'] = 'home/account/contact';
		$route['account/product.*'] = 'home/account/product';
		$route['account/raovat.*'] = 'home/account/raovat';
		$route['account/job.*'] = 'home/account/job';
		$route['account/employ.*'] = 'home/account/employ';
		$route['account/customer.*'] = 'home/account/customer';
		$route['account/showcart.*'] = 'home/account/showcart';
		$route['account/ajax'] = 'home/account/ajax';
		$route['account/shop/intro'] = 'home/account/shopintro';
		$route['account/shop/warranty'] = 'home/account/shopwarranty';
		$route['account/shop/shoprule'] = 'home/account/shoprule';
		$route['account/shop/addbanner'] = 'home/account/addbanner';
		$route['account/shop/listbanner'] = 'home/account/listbanner';
		$route['account/shop/banner.*'] = 'home/account/banner';
		$route['account/delete_img'] = 'home/account/delete_img';
		$route['account/delete_banner'] = 'home/account/delete_banner';
		//Shop
		$route['shop'] = 'home/shop';
		$route['shop/sort.*'] = 'home/shop';
		$route['shop/page.*'] = 'home/shop';
		$route['shop/category/(:num)'] = 'home/shop/category/$1';
		$route['shop/category/(:num)/sort.*'] = 'home/shop/category/$1';
		$route['shop/category/(:num)/page.*'] = 'home/shop/category/$1';
		$route['shop/category/(:num)/(:any)'] = 'home/shop/category/$1';
		$route['shop/category/(:num)/(:any)/sort.*'] = 'home/shop/category/$1';
		$route['shop/category/(:num)/(:any)/page.*'] = 'home/shop/category/$1';
		
		$route['shop/saleoff.*'] = 'home/shop/saleoff';
		$route['shop/ajax'] = 'home/shop/ajax';
		$route['([a-z0-9_-])+'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/page.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/saleoff'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/saleoff/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/saleoff/page.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/detail/(:num)/(:any)'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/page.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/detail/(:num)/(:any)'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/search.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/contact'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/map'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/introduct'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/warranty'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/estimate'] = 'home/shop/detail';
		// Product in Shop
		$route['([a-z0-9_-])+/product/cat/(:num)'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/cat/(:num)/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/product/cat/(:num)/page.*'] = 'home/shop/detail';
		
		// Ads in Shop
		$route['([a-z0-9_-])+/raovat'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/page.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/detail/(:num)'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/cat/(:num)'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/cat/(:num)/sort.*'] = 'home/shop/detail';
		$route['([a-z0-9_-])+/raovat/cat/(:num)/page.*'] = 'home/shop/detail';
		
		// Content
		$route['administ/content/(search|filter|sort|page|status).*'] = 'administ/content';
		$route['administ/content/add'] = 'administ/content/add';
		$route['administ/content/edit/(:num)'] = 'administ/content/edit/$1';
		
		//Content
		$route['content/(:num)'] = 'home/content';
		$route['content/(:num)/page'] = 'home/content';
		$route['content/(:num)/page/(:num)'] = 'home/content';
		
		//News
		$route['news/category-1'] = 'home/content/news_1';
		$route['news/category-2'] = 'home/content/news_2';
		$route['news/category-3'] = 'home/content/news_3';
		
		
		//Pay ment
		//Added by Le Van Son
		//Created date 13/04/2012
		$route['payment'] = 'home/payment';
		$route['payment/(:num)'] = 'home/payment';
		log_message('debug', "Router Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Set the route mapping
	 *
	 * This function determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_routing()
	{
		// Are query strings enabled in the config file?  Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		$segments = array();
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			if (isset($_GET[$this->config->item('directory_trigger')]))
			{
				$this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
				$segments[] = $this->fetch_directory();
			}

			if (isset($_GET[$this->config->item('controller_trigger')]))
			{
				$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
				$segments[] = $this->fetch_class();
			}

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
				$segments[] = $this->fetch_method();
			}
		}

		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);

		// Were there any query string segments?  If so, we'll validate them and bail out since we're done.
		if (count($segments) > 0)
		{
			return $this->_validate_request($segments);
		}

		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			return $this->_set_default_controller();
		}

		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();

		// Compile the segments into an array
		$this->uri->_explode_segments();

		// Parse any custom routing that may exist
		$this->_parse_routes();

		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();
	}

	// --------------------------------------------------------------------

	/**
	 * Set the default controller
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_default_controller()
	{
		if ($this->default_controller === FALSE)
		{
			show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
		}
		// Is the method being specified?
		if (strpos($this->default_controller, '/') !== FALSE)
		{
			$x = explode('/', $this->default_controller);

			$this->set_class($x[0]);
			$this->set_method($x[1]);
			$this->_set_request($x);
		}
		else
		{
			$this->set_class($this->default_controller);
			$this->set_method('index');
			$this->_set_request(array($this->default_controller, 'index'));
		}

		// re-index the routed segments array so it starts with 1 rather than 0
		$this->uri->_reindex_segments();

		log_message('debug', "No URI present. Default controller set.");
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Route
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 *
	 * @access	private
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments);

		if (count($segments) == 0)
		{
			return $this->_set_default_controller();
		}

		$this->set_class($segments[0]);

		if (isset($segments[1]))
		{
			// A standard method request
			$this->set_method($segments[1]);
		}
		else
		{
			// This lets the "routed" segment array identify that the default
			// index method is being used.
			$segments[1] = 'index';
		}

		// Update our "routed" segment array to contain the segments.
		// Note: If there is no custom routing, this array will be
		// identical to $this->uri->segments
		$this->uri->rsegments = $segments;
	}

	// --------------------------------------------------------------------

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}

		// Does the requested controller exist in the root folder?
		if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
		{
			return $segments;
		}

		// Is the controller in a sub-folder?
		if (is_dir(APPPATH.'controllers/'.$segments[0]))
		{
			// Set the directory and remove it from the segment array
			$this->set_directory($segments[0]);
			$segments = array_slice($segments, 1);

			if (count($segments) > 0)
			{
				// Does the requested controller exist in the sub-folder?
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
				{
					show_404($this->fetch_directory().$segments[0]);
				}
			}
			else
			{
				// Is the method being specified in the route?
				if (strpos($this->default_controller, '/') !== FALSE)
				{
					$x = explode('/', $this->default_controller);

					$this->set_class($x[0]);
					$this->set_method($x[1]);
				}
				else
				{
					$this->set_class($this->default_controller);
					$this->set_method('index');
				}

				// Does the default controller exist in the sub-folder?
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
				{
					$this->directory = '';
					return array();
				}

			}

			return $segments;
		}


		// If we've gotten this far it means that the URI does not correlate to a valid
		// controller class.  We will now see if there is an override
		if (!empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}


		// Nothing else to do at this point but show a 404
		show_404($segments[0]);
	}

	// --------------------------------------------------------------------

	/**
	 *  Parse Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * @access	private
	 * @return	void
	 */
	function _parse_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val)
		{
			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				return $this->_set_request(explode('/', $val));
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}

	// --------------------------------------------------------------------

	/**
	 * Set the class name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_class($class)
	{
		$this->class = str_replace(array('/', '.'), '', $class);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch the current class
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_class()
	{
		return $this->class;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the method name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_method($method)
	{
		$this->method = $method;
	}

	// --------------------------------------------------------------------

	/**
	 *  Fetch the current method
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_method()
	{
		if ($this->method == $this->fetch_class())
		{
			return 'index';
		}

		return $this->method;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the directory name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_directory($dir)
	{
		$this->directory = str_replace(array('/', '.'), '', $dir).'/';
	}

	// --------------------------------------------------------------------

	/**
	 *  Fetch the sub-directory (if any) that contains the requested controller class
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_directory()
	{
		return $this->directory;
	}

	// --------------------------------------------------------------------

	/**
	 *  Set the controller overrides
	 *
	 * @access	public
	 * @param	array
	 * @return	null
	 */
	function _set_overrides($routing)
	{
		if ( ! is_array($routing))
		{
			return;
		}

		if (isset($routing['directory']))
		{
			$this->set_directory($routing['directory']);
		}

		if (isset($routing['controller']) AND $routing['controller'] != '')
		{
			$this->set_class($routing['controller']);
		}

		if (isset($routing['function']))
		{
			$routing['function'] = ($routing['function'] == '') ? 'index' : $routing['function'];
			$this->set_method($routing['function']);
		}
	}


}
// END Router Class

/* End of file Router.php */
/* Location: ./system/core/Router.php */