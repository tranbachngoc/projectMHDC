<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

/**
 *Class Setting: Luu tat ca cac cau hinh
**/
#Thong tin website


define('contentFooter',8);
define('yahooChatFooter',9);
define('fastLink',10);
define('footerLogo',11);
define('footerNetwork',12);
define('footerDangKyBo',13);
define('hotroHorver',19);
define('taogianhang',21);
define('thongtinRightTopGlobal',22);
define('thongtinRightTopDangNhap',23);
define('thongbao_login',26);
define('thongbao_out',27);
define('noi_quy_gian_hang',391);
define('noi_quy_af',391);
//define('thongtinRightTopDangKy',24);
define('thongtinRightTopPost',25);
#Vote Product in Homepage
define('settingProductVote',20);

define('limitShowProduct',60);

#Notify in Homepage
define('settingNotify',5);

define('SMTPHOST', 'mail.azibai.com');
define('SMTPPORT', 25);
define('SMTPSERCURITY', '');
define('GUSER', 'no-reply@azibai.com');  // Email use to send SMTP
define('GPWD', '62363cSi9'); 	// Password use to send SMTP

if($_SERVER['SERVER_NAME']=='localhost'||$_SERVER['SERVER_NAME']=='server01'){
	define('folderWeb', '/azibai');
}else{
	define('folderWeb', '');
}

#Link bai viet danh cho nguoi ban
define('sellerRegister','content/62');
define('sellerManageShop','content/18');
define('sellerPostProduct','content/17');
define('sellerPostAds','content/319');

#Link bai viet danh cho nguoi mua
define('buyerRegister','content/55');
define('buyerHowToBuy','content/57');
define('buyerHowToSearch','content/320');
define('buyerOrderHistory','account/lichsugiaodich');

#Link bai viet danh cho nguoi mua
define('supporterServicePrices','content/318');
define('supporterAdvertisement','content/321');
define('supporterBenefitWhenJoin','content/322');
define('supporterTermOfUse','content/323');
define('supporterBecomeAzibaiLink','content/324');
#Social Azibai
define('socialFacebook','https://www.facebook.com/azibai');
define('socialTwitter','https://www.twitter.com/azibaiglobal');
define('socialGooglePlus','https://www.google.com/+azibaiglobal');
define('socialLinkedin','https://www.linkedin.com/company/azibai/');
define('socialYoutube','https://www.youtube.com/channel/UCrtuU7KhPZiOiHvao1m3lWA');
define('socialPinterest','https://www.pinterest.com/azibaiglobal/');
define('socialVimeo','https://www.vimeo.com/azibai');
define('socialIntergram','https://instagram.com/azibai');
define('socialSkype','azibai');
define('socialTumblr','https://www.tumblr.com/azibai');
define('defaultVideo','zlsQF_ufUNU');
define('app_id','369989080389798');

# Group ID
define('NormalUser',1);
define('AffiliateUser',2);// ctv
define('AffiliateStoreUser',3);// store
define('ADMIN_SYSTEM',4);//system
define('Developer2User',6);//system
define('Developer1User',7);//system
define('Partner2User',8);//system
define('Partner1User',9);//system
define('CoreMemberUser',10);//system
define('CoreAdminUser',12);//system
define('StaffUser',11);//bỏ
define('BranchUser',14);//chi nhánh
define('StaffStoreUser',15);// nhân viên store
define('SubAdminUser',16);//system

# List Group Affiliate
define('ListGroupAff','['. AffiliateUser .','. AffiliateStoreUser .','. BranchUser .']');


// Tien AF, Store, Dev duoc rut khi co it nhat trong tai khoan
define('MinAmountAff',50000);
define('MinAmountStore',50000);
define('MinAmountOther',100000);
define('TimeMemberStatic', 3);

//test mode - commission
define('testMode',0);
define('testModeMonth',9);
define('testModeYear',2016);

//ngan luong old
// define('MERCHANT_ID', '45742');
// define('MERCHANT_PASS', 'd9cbfe91ef00fd8c6759b7db1b143a06');
// define('RECEIVER','azibaiglobe@gmail.com');

// new
// define('MERCHANT_ID', '59935');
// define('MERCHANT_PASS', '50623a2d4f5646a74e81eae8f6961ee4');
// define('RECEIVER','azilong77@gmail.com ');

// sanbox
define('MERCHANT_ID', '47744');
define('MERCHANT_PASS', '902aad70ad6d3aba3c506ac7a2225e81');
define('RECEIVER','thuanthuan0907@gmail.com');


define('NL_VERSION', '3.1');
define('NL_FUNCTION', 'SetExpressCheckout');
// define('NL_URL_SERVICE','https://www.nganluong.vn/checkout.api.nganluong.post.php');
define('NL_URL_SERVICE','https://sandbox.nganluong.vn:8088/nl35/checkout.api.nganluong.post.php');
//rest api giaohangnhanh
// define('apiSettingGHN', '{"serviceURL":"https:\/\/testapipds.ghn.vn:9999\/external\/marketplace","clientID":"58960","password":"c3TfjJbFzAaDmRVHn","apiKey":"wcsNLLjyLyKX6EsB","apiSecretKey":"9869C9338C530081E31BB9135355A2BF"}');
define('apiSettingGHN', '{"serviceURL":"https:\/\/apipds.ghn.vn\/external\/marketplace","clientID":"72869","password":"6kMufjmmuNAm2fT8M","apiKey":"wcsNLLjyLyKX6EsB","apiSecretKey":"9869C9338C530081E31BB9135355A2BF"}');
define('ServiceID', '{"53319":"6 giờ","53320":"1 ngày","53321":"2 ngày","53322":"3 ngày","53323":"4 ngày","53324":"5 ngày"}');

// service Id của viettel post: Liên tỉnh
define('ServiceID_VTP_LT', '{"VCN":"chuyển phát nhanh","VBK":"Bưu kiện chuyển thường","VBK":"Bảo đảm","V60":"Dịch vụ nhanh 60h","V36":"Dịch vụ nhanh 36h"}');
// service Id của viettel post: Nội tỉnh
define('ServiceID_VTP_NT', '{"PTN":"Phát trong ngày nội tỉnh","PHT":"Phát hỏa tốc nội tỉnh","PHS":"Phát hôm sau nội tỉnh"}');
define('VTP_SERVICE', 'VCN');
define('passwordVTP','LKVAZBVTP');

// define('apiSettingGHTK', '{"serviceurl":"https:\/\/dev.giaohangtietkiem.vn\/","emaillogin":"tienlam@azibai.com","password":"\"S9XF}ma-M\"J`53)","apitoken":"8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014"}');
define('apiSettingGHTK', '{"serviceurl":"https:\/\/services.giaohangtietkiem.vn\/","emaillogin":"tienlam@azibai.com","password":"\"S9XF}ma-M\"J`53)","apitoken":"8cc20D58F9c595840c14Ed2C8fb0C77C1BBBF014"}');

define('PAYMENT_METHOD','{"info_nganluong":"Thanh toán trực tuyến - Ngân Lượng","info_cod":"Thanh toán khi nhận hàng","info_bank":"Chuyển khoản qua ngân hàng","info_cash":"Thanh toán bằng tiền mặt tại quầy","default":"Chưa xác định"}');
// service VHT connect verify code by SMS number phone
define('apiSettingVHT', '{"URL":"http:\/\/sms3.vht.com.vn\/ccsms\/Sms\/SMSService.svc\/ccsms\/json","Key":"Mncvcskh","SecretKey":"Mdhadjhdladvbmnsdha"}');

define('HOTLINE','02873009910');
define("clientOrderCode","https://ontime.ghn.vn/Tracking/viewtracking/");
define("clientVTPOrderCode","/tracking-order/");
define("clientComplain","order_detail/");
define('emailSupport','support@azibai.com');
define('timeCronDelivery','24'); //thời gian cron kiểm tra bước 2 khiếu nại tự động (Hours)
define('timeOrderComplete','48'); //thời gian cron cập nhật trạng thái đơn hàng tự động (Hours)
define('bankpayment','
[{"bank_name":"ACB bank","bank_icon":"acbbank.png"},{"bank_name":"Agribank","bank_icon":"agribank.png"},{"bank_name":"BaoViet bank","bank_icon":"baovietbank.png"},{"bank_name":"BIDV bank","bank_icon":"bidvbank.png"},{"bank_name":"DONGA bank","bank_icon":"dongabank.png"},{"bank_name":"Eximbank","bank_icon":"eximbank.png"},{"bank_name":"Maritime Bank","bank_icon":"maritimebank.png"},{"bank_name":"MBBank","bank_icon":"mbbank.png"},{"bank_name":"Pgbank","bank_icon":"pgbank.png"},{"bank_name":"Sacombank","bank_icon":"sacombank.png"},{"bank_name":"SeABank","bank_icon":"seabank.png"},{"bank_name":"SHB iBanking","bank_icon":"shbbank.png"},{"bank_name":"Techcombank","bank_icon":"techcombank.png"},{"bank_name":"TPBank\u200e","bank_icon":"tienphongbank.png"},{"bank_name":"Vietcombank","bank_icon":"vietcombank.png"},{"bank_name":"Vietinbank","bank_icon":"vietinbank.png"},{"bank_name":"VPBank","bank_icon":"vpbank.png"}]');

define('email_hostname','localhost');
define('email_username','root');
define('email_password','');
define('email_database','azibai_emailapp');

// define('email_hostname','localhost');
// define('email_username','azibai_emailapp');
// define('email_password','emailapp123456!');
// define('email_database','azibai_emailapp');

// CHỈ BẬT custome_money_store = 1 khi tính tiền lại gian hàng theo ngày XÁC ĐỊNH tính xong phai chuyen bang 0 ngay lap tuc 
define('custome_money_store',0);
define('custome_money_store_start_date','01-07-2016');
define('custome_money_store_end_date','19-10-2016');

define('FEE_VAT',0.1);
// Setting cloud server save media
// define('IP_CLOUDSERVER', '103.1.238.103');
// define('USER_CLOUDSERVER', 'azibai');
// define('PASS_CLOUDSERVER', '96ddc9TzLVLV');
// define('PORT_CLOUDSERVER', 21);
define('IP_CLOUDSERVER', '42.112.35.42');
define('USER_CLOUDSERVER', 'cdn1');
define('PASS_CLOUDSERVER', '96ddc9TzLVLV');
define('PORT_CLOUDSERVER', 21);
define('DOMAIN_CLOUDSERVER', 'https://cdn1.azibai.com/');
//define('DOMAIN_CLOUDSERVER', 'http://azibai.org/');

define('ACTIVE', 1);
define('DISABLE', 0);

define('TIMELINE_PERSONAL', 1);
define('TIMELINE_SHARE', 2);
define('TIMELINE_TAG', 3);

define('INPUT_DATE_FOMART', 'Y-m-d');
define('OUTPUT_DATE_FOMART', 'd/m/Y');
define('FOLLOW', 1);
define('NOT_FOLLOW', 0);

define('NUM_THOUSANDS_SEP', '.');
define('NUM_DECIMALS', 0);
define('NUM_DECIMAL_POINT', ',');
define('DEFAULT_IMAGE_ERROR_PATH', '/templates/home/styles/images/svg/azibai-default-image.svg');
define('PRODUCT_TYPE', 0);
define('COUPON_TYPE', 2);
define('LINK_TYPE', 3);

# List Group Affiliate
define('MEMBERS_STORE','['. AffiliateStoreUser .','. StaffStoreUser .','. BranchUser .']');

define('domain_site', 'khachweb.xxx');
define('IP_SERVER', 'S48');
define('SERVER_LOADBALANCER', '171.244.9.48');
define('ENVIRONMENT', 'production');
define('link_get_token', 'http://api.azibai.com/api/v1/');
define('api_comment', 'http://comment.azibai.com/');