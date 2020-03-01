<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


$config['config_domain_affiliate'] = DOMAIN_AFFILIATE;
$config['config_domain_page_business'] = link_get_token;

// dashboard user affiliate
$config['dashboard']['data_get'] = 'api/static?type_affiliate={$type_affiliate}';
// danh sách user affiliate
$config['list_user']['user_get'] = 'api/user?user_id={$user_id}&level={$level}&page={$page}&limit={$limit}&user_type={$user_type}&search={$search}&type_affiliate={$type_affiliate}&parent_id={$parent_id}';
// danh sách mã giảm giá
$config['list_service']['list_service_get'] = 'api/service?user_id={$user_id}&type_affiliate={$type_affiliate}&parent_id={$parent_id}&type_service={$type_service}&page={$page}&limit={$limit}&get_type={$get_type}';
// danh sách mã giảm giá ở menu dịch vụ trang home
$config['list_service']['list_service_azibai_get'] = 'api/service/serviceazibai?page={$page}&limit={$limit}';
// chi tiết mã giảm giá
$config['list_service']['detail_service_get'] = 'api/service/{$service_id}?user_id={$user_id}&type_affiliate={$type_affiliate}';
// danh sách đơn hàng
$config['list_order']['list_order_get'] = 'api/static/order?user_id={$user_id}&type_get={$type_get}&date_start={$start}&date_end={$end}&search={$search}&page={$page}&limit={$limit}';
// chi tiết đơn hàng
$config['list_order']['detail_order_get'] = 'api/static/order/{$order_id}';
// thêm đơn hàng
$config['list_order']['detail_add_get'] = 'api/order';
// Thu nhập số dư
$config['income']['balance_get'] = 'api/money?month={$month_year}&user_id={$user_id}&page={$page}&limit={$limit}';
// Thu nhập tạm tính
$config['income']['provisonal_sum_get'] = 'api/money/subtotal?user_id={$user_id}&page={$page}&limit={$limit}';
// Thu nhập lịch sử
$config['income']['history_get'] = 'api/money/history?user_id={$user_id}&type_get={$type_get}&page={$page}&limit={$limit}';
// lấy tất cả tài khoản giao dịch
$config['income']['payment_accounts_get'] = 'api/money/bank?user_id={$user_id}';
// thêm tài khoản giao dịch
$config['income']['add_payment_account_post'] = 'api/money/bank';
// xóa tài khoản giao dịch
$config['income']['delete_payment_account_post'] = 'api/money/bank/{$bank_id}';
// lấy & cập nhật tài khoản giao dịch
$config['income']['put_payment_account'] = 'api/money/bank/{$bank_id}';
// danh sách ngân hàng
$config['income']['list_bank'] = 'api/money/listbank';
// thống kê doanh thu
$config['statistic']['order_post'] = 'api/static/total';
// thống kê thành viên
// $config['statistic']['user_post'] = 'api/static/user?parent_id={$user_id}&date_start={$start}&date_end={$end}';
// lấy thông tin rút tiền
$config['withdraw']['money_get'] = 'api/money/transfer?user_id={$user_id}';
// rút tiền
$config['withdraw']['money_post'] = 'api/money/transfer';
// xác nhận lệnh rút
$config['withdraw']['confirm_transfer'] = 'api/money/{$transfer}';
// Giới thiệu
$config['invite']['listfriend'] 	= 'api/user/listfriend?page={$page}&limit={$limit}&search={$search}';
$config['invite']['affiliate_invite'] = 'api/user/invite?type_affiliate={$type_affiliate}&parent_id={$parent_id}';
$config['invite']['affiliate_invitere'] = 'api/user/invitere?type_affiliate={$type_affiliate}&parent_id={$parent_id}';
$config['invite']['affiliate_listinvite'] = 'api/user/listinvite?user_id={$user_id}&accept={$accept}';
$config['invite']['affiliate_invite_request'] = 'api/user/editinvite/{$id}';
$config['invite']['affiliate_list_affiliate'] = 'api/user/listaffiliate/{$id}';
$config['invite']['editlevel'] = 'api/user/editlevel';
// Lấy danh sách sản phẩm để tạo voucher
$config['voucher']['list_product_get'] = 'api/voucher/product?user_id={$user_id}&page={$page}&limit={$limit}&search={$search}';
// Tạo mã giảm giá
$config['voucher']['create_voucher_post'] = 'api/voucher';
// Chi tiết voucher
$config['voucher']['detail_voucher_get'] = 'api/voucher/{$voucher_id}';
// Danh sách mã giảm giá đã tạo
$config['voucher']['list_voucher_get'] = 'api/voucher?user_id={$user_id}&page={$page}&limit={$limit}';
// Danh sách sản phẩm áp dụng mã giảm giá
$config['voucher']['list_product_of_voucher_get'] = 'api/voucher/listproduct?voucher_id={$voucher_id}&user_id={$user_id}&page={$page}&limit={$limit}&search={$search}';
// Danh sách mã giảm giá ở menu trang doanh nghiệp
$config['voucher']['list_service_shop_get'] = 'api/voucher/serviceshop';
// Của hàng trang cá nhân
$config['branch']['list_section_shop_person'] = 'api/voucher/personproductaff';
// Danh sách mã giảm giá ở menu trang cá nhân
$config['voucher']['list_service_person_get'] = 'api/voucher/personvoucher';
// chi tiết mã giảm giá sàn azibai
$config['voucher']['detail_by_id'] = 'api/voucher/detail/{$voucher_id}';
// Danh sách chi nhánh của gian hàng
$config['branch']['list_branch_of_shop_get'] = 'page-business/list-branch?user_id={$user_id}';
// Gian hàng show tất cả sp/ phiếu mua hàng của chi nhánh
$config['branch']['list_product_branch'] = 'page-business/list-product-branch?user_id={$user_id}&pro_type={$pro_type}&page={$page}';
// Gian hàng chọn SP/Coupon từ chi nhánh
$config['branch']['choose_product_branch'] = 'page-business/choose-product-branch';
// Danh sách sản phẩm tự đăng
$config['branch']['list_product_post_by_self'] = 'page-business/products?user_id={$user_id}&pro_type={$pro_type}&type={$type}&page={$page}';
// Thay đổi status của sản phẩm tự đăng
$config['branch']['change_status_product_post_by_self'] = 'page-business/update-status-product';
// Shop chia sẽ sản phẩm đăng cho chi nhánh
$config['branch']['shop_share_product_to_branch'] = 'page-business/send-product-branch';
// Danh sách sản phẩm được chia sẽ
$config['branch']['list_product_has_been_shared'] = 'page-business/list-products?user_id={$user_id}&pro_type={$pro_type}&type={$type}';
// Thay đổi trạng thái sản phẩm được chia sẻ
$config['branch']['update_status_product_has_been_shared'] = 'page-business/update-status-send-product';
// Danh sách đơn hàng | quản lý trang
$config['branch']['list_order'] = 'page-business/list-orders?user_id={$user_id}&pro_type={$pro_type}&start_date={$start_date}&end_date={$end_date}&order_id={$order_id}&customer_name={$customer_name}&pro_name={$pro_name}&transporters={$transporters}&order_status={$order_status}&page={$page}';
// Danh sách đơn hàng | tư cách người mua hàng
$config['branch']['user_get_list_order'] = 'user-manager/list-orders?pro_type={$pro_type}&start_date={$start_date}&end_date={$end_date}&order_id={$order_id}&customer_name={$customer_name}&pro_name={$pro_name}&transporters={$transporters}&order_status={$order_status}&page={$page}';
// Chi tiết đơn hàng | quản lý trang
$config['branch']['list_order_item'] = 'page-business/get-order?order_id={$order_id}&user_id={$user_id}&type={$type}';
// Chi tiết đơn hàng | tư cách người mua hàng
$config['branch']['user_list_order_item'] = 'user-manager/get-order?order_id={$order_id}&type={$type}';
// Cập nhật trạng thái đơn hàng | quản lý trang
$config['branch']['update_status_list_order_item'] = 'page-business/update-status';
// Cập nhật trạng thái đơn hàng | tư cách người mua hàng
$config['branch']['update_status_user_list_order_item'] = 'user-manager/update-status';
// Danh sách tin đã đăng
$config['branch']['list_content'] = 'page-business/news?user_id={$user_id}&type={$type}&page={$page}&title={$title}&cate={$cate}';
// Shop chia sẻ tin cho chi nhanh
$config['branch']['shop_share_content_to_branch'] = 'page-business/send-new-branch';
// Thay đổi status của bài viết tự đăng
$config['branch']['change_status_content_post_by_self'] = 'page-business/update-status-content';
// Danh sách tin được chia sẽ
$config['branch']['list_content_has_been_shared'] = 'page-business/list-news?user_id={$user_id}&type={$type}&page={$page}&title={$title}&cate={$cate}&branch={$branch}';
// Thay đổi trạng thái tin được chia sẻ
$config['branch']['update_status_content_has_been_shared'] = 'page-business/update-status-send-news';
// Kiểm tra xem tk mua gói thanh toán trưc tuyến, nhà vận chuyển .....
$config['branch']['check_has_config_service'] = 'page-business/list-setting';
// Lấy thông tin cấu hình nhà vận chuyển (GHN)
$config['branch']['get_info_config_GHN'] = 'page-business/nhanhvn-setting';
// Tạo thông tin cấu hình nhà vận chuyển (GHN)
$config['branch']['create_info_config_GHN'] = 'page-business/nhanhvn-setting';
// Lấy thông tin cấu hình thanh toán ngân lượng
$config['branch']['get_info_config_nganluong'] = 'page-business/nganluong-setting';
// upfile cấu hình thanh toán ngân lượng
$config['branch']['upfile_config_nganluong'] = 'page-business/file-nl-setting';
// Tạo thông tin cấu cổng thanh toán ngân lượng
$config['branch']['create_info_config_nganluong'] = 'page-business/nganluong-setting';


// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ----------------------------- URL full API -----------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// DASHBOARD---------------------------------------------------------------
$config['api_aff_user_dashboard'] = $config['config_domain_affiliate'] . $config['dashboard']['data_get'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// THỐNG KÊ----------------------------------------------------------------
// --------THỐNG KÊ HÓA ĐƠN------------------------------------------------
$config['api_aff_statistic_order'] = $config['config_domain_affiliate'] . $config['statistic']['order_post'];
// --------THỐNG KÊ USER---------------------------------------------------
// $config['api_aff_statistic_user'] = $config['config_domain_affiliate'] . $config['statistic']['user_post'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// THÀNH VIÊN--------------------------------------------------------------
$config['api_aff_list_user_data'] = $config['config_domain_affiliate'] . $config['list_user']['user_get'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// ĐƠN HÀNG----------------------------------------------------------------
// --------DANH SÁCH ĐƠN HÀNG----------------------------------------------
$config['api_aff_list_order_data'] = $config['config_domain_affiliate'] . $config['list_order']['list_order_get'];
// --------CHI TIẾT ĐƠN HÀNG-----------------------------------------------
$config['api_aff_detail_order'] = $config['config_domain_affiliate'] . $config['list_order']['detail_order_get'];
$config['api_aff_add_order'] = $config['config_domain_affiliate'] . $config['list_order']['detail_add_get'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// THU NHẬP----------------------------------------------------------------
// --------THU NHẬP SỐ DƯ--------------------------------------------------
$config['api_aff_income_data'] = $config['config_domain_affiliate'] . $config['income']['balance_get'];
// --------THU NHẬP TẠM TÍNH-----------------------------------------------
$config['api_aff_income_provisonal_sum'] = $config['config_domain_affiliate'] . $config['income']['provisonal_sum_get'];
// --------THU NHẬP LỊCH SƯ------------------------------------------------
$config['api_aff_income_history'] = $config['config_domain_affiliate'] . $config['income']['history_get'];
// --------TÀI KHOẢN NGÂN HÀNG---------------------------------------------
$config['api_aff_income_payment_accounts'] = $config['config_domain_affiliate'] . $config['income']['payment_accounts_get'];
// ---------------------------THÊM TÀI KHOẢN GIAO DỊCH---------------------
$config['api_aff_income_payment_add'] = $config['config_domain_affiliate'] . $config['income']['add_payment_account_post'];
// ---------------------------XÓA TÀI KHOẢN GIAO DỊCH----------------------
$config['api_aff_income_payment_delete'] = $config['config_domain_affiliate'] . $config['income']['delete_payment_account_post'];
// ---------------------------LẤY - CẬP NHẬT TÀI KHOẢN GIAO DỊCH-----------
$config['api_aff_income_payment_put'] = $config['config_domain_affiliate'] . $config['income']['put_payment_account'];
// ---------------------------DANH SÁCH NGÂN HÀNG--------------------------
$config['api_aff_income_list_bank_data'] = $config['config_domain_affiliate'] . $config['income']['list_bank'];
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// MÃ GIẢM GIÁ-------------------------------------------------------------
// -----------MÃ GIẢM GIẢ - AZIBAI-----------------------------------------
$config['api_aff_list_service_data'] = $config['config_domain_affiliate'] . $config['list_service']['list_service_get'];
// -----------MÃ GIẢM GIẢ - Ở MENU DỊCH VỤ TRANG HOME----------------------
$config['api_aff_list_service_azibai_data'] = $config['config_domain_affiliate'] . $config['list_service']['list_service_azibai_get'];
// -----------CHI TIẾT MÃ GIẢM GIÁ-----------------------------------------
$config['api_aff_detail_service'] = $config['config_domain_affiliate'] . $config['list_service']['detail_service_get'];
// ---------Lấy THÔNG TIN CẤU HÌNH DỊCH VỤ AZIBAI/DOANH NGHIỆP-------------
$config['api_get_configservice'] = $config['config_domain_affiliate'].'api/service/configservice';
// ---------CẬP NHẬT CẤU HÌNH DỊCH VỤ AZIBAI-------------------------------
$config['api_update_configservice_A'] = $config['config_domain_affiliate'].'api/service/configservicea';
// ---------CẬP NHẬT CẤU HÌNH DỊCH VỤ AZIBAI CỦA USER ---------------------
$config['api_update_configservice'] = $config['config_domain_affiliate'].'api/service/configservice';

// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// RÚT TIỀN----------------------------------------------------------------
// -----------LẤY THÔNG TIN RÚT TIỀN---------------------------------------
$config['api_aff_detail_withdraw'] = $config['config_domain_affiliate'] . $config['withdraw']['money_get'];
// -----------RÚT TIỀN-----------------------------------------------------
$config['api_aff_draw_money'] = $config['config_domain_affiliate'] . $config['withdraw']['money_post'];
// -----------XÁC THỰC LÊNH RÚT TIỀN---------------------------------------
$config['api_aff_confirm_transfer'] = $config['config_domain_affiliate'] . $config['withdraw']['confirm_transfer'];

// -----------MỜI THÀNH VIÊN-----------------------------------------------------
$config['api_aff_user_invite'] = $config['config_domain_affiliate'] . $config['invite']['affiliate_invite'];
$config['api_aff_user_invitere'] = $config['config_domain_affiliate'] . $config['invite']['affiliate_invitere'];
$config['api_aff_list_invite'] = $config['config_domain_affiliate'] . $config['invite']['affiliate_listinvite'];
$config['api_aff_invite_request'] = $config['config_domain_affiliate'] . $config['invite']['affiliate_invite_request'];
$config['api_aff_list'] = $config['config_domain_affiliate'] . $config['invite']['affiliate_list_affiliate'];
$config['api_aff_listfriend'] = $config['config_domain_affiliate'] . $config['invite']['listfriend'];
$config['api_edit_level'] = $config['config_domain_affiliate'] . $config['invite']['editlevel'];
// TẠO MÃ GIẢM GIÁ---------------------------------------------------------
// ---------------LẤY DANH SÁCH SẢN PHẨM-----------------------------------
$config['api_voucher_get_list_product'] = $config['config_domain_affiliate'] . $config['voucher']['list_product_get'];
// ---------------TẠO VOUCHER----------------------------------------------
$config['api_voucher_create'] = $config['config_domain_affiliate'] . $config['voucher']['create_voucher_post'];
// ---------------CHI TIẾT VOUCHER-----------------------------------------
$config['api_voucher_detail'] = $config['config_domain_affiliate'] . $config['voucher']['detail_voucher_get'];
// ---------------DANH SÁCH VOUCHER ĐÃ TẠO---------------------------------
$config['api_voucher_list'] = $config['config_domain_affiliate'] . $config['voucher']['list_voucher_get'];
// ---------------DANH SÁCH SP ÁP DỤNG VOUCHER-----------------------------
$config['api_voucher_used_by_product'] = $config['config_domain_affiliate'] . $config['voucher']['list_product_of_voucher_get'];
// ---------------DANH SÁCH VOUCHER TRANG DOANH NGHIỆP---------------------
$config['api_voucher_list_service_shop_get'] = $config['config_domain_affiliate'] . $config['voucher']['list_service_shop_get'];
// ---------------DANH SÁCH SECTION TRANG CỬA HÀNG CÁ NHÂN-----------------
$config['api_list_section_shop_person'] = $config['config_domain_affiliate'] . $config['branch']['list_section_shop_person'];
// ---------------DANH SÁCH VOUCHER TRANG CÁ NHÂN---------------------
$config['api_voucher_list_service_person_get'] = $config['config_domain_affiliate'] . $config['voucher']['list_service_person_get'] ;
// ---------------CHI TIẾT VOUCHER TRANG CỬA HÀNG AZIBAI-------------------
$config['api_voucher_detail_for_client'] = $config['config_domain_affiliate'] . $config['voucher']['detail_by_id'];

// CHI NHÁNH---------------------------------------------------------------
// ---------LẤY DANH SÁCH CHI NHÁNH----------------------------------------
$config['api_branch_get_listBranch'] = $config['config_domain_page_business'] . $config['branch']['list_branch_of_shop_get'];
// ---------GIAN HÀNG SHOW SẢN PHẨM/ PHIẾU MUA HÀNG CỦA CHI NHÁNH----------
$config['api_shop_show_product_branch'] = $config['config_domain_page_business'] . $config['branch']['list_product_branch'];
// ---------GIAN HÀNG CHỌN SẢN PHẨM CỦA CHI NHÁNH--------------------------
$config['api_shop_choose_product_branch'] = $config['config_domain_page_business'] . $config['branch']['choose_product_branch'];
// ---------LẤY DANH SÁCH SP TỰ ĐĂNG---------------------------------------
$config['api_get_products_post_by_self'] = $config['config_domain_page_business'] . $config['branch']['list_product_post_by_self'];
// ---------ĐỔI STATUS SP TỰ ĐĂNG------------------------------------------
$config['api_change_status_product_post_by_self'] = $config['config_domain_page_business'] . $config['branch']['change_status_product_post_by_self'];
// ---------SHOP SHARE SP CHO CHI NHÁNH------------------------------------
$config['api_shop_share_product_to_branch'] = $config['config_domain_page_business'] . $config['branch']['shop_share_product_to_branch'];
// ---------LẤY DANH SÁCH SP ĐƯỢC CHIA SẼ----------------------------------
$config['api_get_product_has_shared'] = $config['config_domain_page_business'] . $config['branch']['list_product_has_been_shared'];
// ---------CẬP NHẬT TRẠNG THÁI SP ĐƯỢC CHIA SẼ----------------------------------
$config['api_change_status_product_has_shared'] = $config['config_domain_page_business'] . $config['branch']['update_status_product_has_been_shared'];
// ---------LẤY DANH ĐƠN HÀNG SHOP/BRANCH----------------------------------
$config['api_get_list_order'] = $config['config_domain_page_business'] . $config['branch']['list_order'];
// ---------LẤY DANH ĐƠN HÀNG CỦA USER-------------------------------------
$config['api_user_get_list_order'] = $config['config_domain_page_business'] . $config['branch']['user_get_list_order'];
// ---------CHI TIẾT ĐƠN HÀNG SHOP/BRANCH----------------------------------
$config['api_get_list_order_item'] = $config['config_domain_page_business'] . $config['branch']['list_order_item'];
// ---------CHI TIẾT ĐƠN HÀNG CỦA USER-------------------------------------
$config['api_user_list_order_item'] = $config['config_domain_page_business'] . $config['branch']['user_list_order_item'];
// ---------CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG SHOP/BRANCH-----------------------
$config['api_update_status_list_order_item'] = $config['config_domain_page_business'] . $config['branch']['update_status_list_order_item'];
// ---------CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG CỦA USER--------------------------
$config['api_update_status_user_list_order_item'] = $config['config_domain_page_business'] . $config['branch']['update_status_user_list_order_item'];
// ---------LẤY DANH TIN SHOP/BRANCH---------------------------------------
$config['api_get_list_content'] = $config['config_domain_page_business'] . $config['branch']['list_content'];
// ---------SHOP SHARE TIN CHO CHI NHÁNH-----------------------------------
$config['api_shop_share_content_to_branch'] = $config['config_domain_page_business'] . $config['branch']['shop_share_content_to_branch'];
// ---------ĐỔI STATUS TIN TỰ ĐĂNG------------------------------------------
$config['api_change_status_content_post_by_self'] = $config['config_domain_page_business'] . $config['branch']['change_status_content_post_by_self'];
// ---------LẤY DANH SÁCH TIN ĐƯỢC CHIA SẼ------------------------------------------
$config['api_get_content_has_shared'] = $config['config_domain_page_business'] . $config['branch']['list_content_has_been_shared'];
// ---------CẬP NHẬT TRẠNG THÁI TIN ĐƯỢC CHIA SẼ------------------------------------
$config['api_change_status_content_has_shared'] = $config['config_domain_page_business'] . $config['branch']['update_status_content_has_been_shared'];
// --------- LIST CHUYỂN TIỀN ------------------------------------
$config['listtransfer'] 	= $config['config_domain_affiliate']. 'api/money/listtransfer';
$config['listlog'] 			= $config['config_domain_affiliate']. 'api/money/listlog';
$config['updatestatus'] 	= $config['config_domain_affiliate']. 'api/money/upstatus';
// ---------CHECK LIST DỊCH VỤ ĐƯỢC CẤU HÌNH--------------------------------
$config['api_check_list_has_config'] = $config['config_domain_page_business'] . $config['branch']['check_has_config_service'];
// ---------GET CONFIG GNH--------------------------------------------------
$config['api_get_config_gnh'] = $config['config_domain_page_business'] . $config['branch']['get_info_config_GHN'];
// ---------CREATE CONFIG GNH--------------------------------------------------
$config['api_create_config_gnh'] = $config['config_domain_page_business'] . $config['branch']['create_info_config_GHN'];
// ---------GET CONFIG NGAN LUONG--------------------------------------------------
$config['api_get_config_nganluong'] = $config['config_domain_page_business'] . $config['branch']['get_info_config_nganluong'];
// ---------UPFILE CONFIG NGAN LUONG--------------------------------------------------
$config['api_upfile_config_nganluong'] = $config['config_domain_page_business'] . $config['branch']['upfile_config_nganluong'];
// ---------UPFILE CONFIG NGAN LUONG--------------------------------------------------
$config['api_create_config_nganluong'] = $config['config_domain_page_business'] . $config['branch']['create_info_config_nganluong'];
?>