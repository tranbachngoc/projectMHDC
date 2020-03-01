<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');

/**
 *Class Setting: Luu tat ca cac cau hinh
 **/
#Thong tin website
define('settingTitle','Azibai.com - Trang mua bán trực tuyến hàng đầu Việt Nam');
define('settingDescr','Sàn mua bán trực tuyến hàng đầu Việt Nam, hệ thống gian hàng giúp doanh nghiệp đẩy mạnh kinh doanh online');
define('settingKeyword','mua ban truc tuyen, kinh doanh truc tuyen, kinh doanh online, azibai lien ket, azibai');
define('settingPassDefault','Admin123456!');
define('serviceConfig','0');
//Rao vat
define('settingTitleRaovat','Rao vặt Azibai');
define('settingDescrRaovat','Azibai.com Rao vặt');
//Hoi Dap
define('settingTitleHoidap','Hỏi đáp Azibai');
define('settingDescrHoidap','Azibai.com – Hỏi đáp');
//Hoi Dap
define('settingTitleTintuc','Mạng xã hội - Kinh doanh');
define('settingDescrTintuc','Azibai.com – Mạng xã hội - Kinh doanh');
//Tuyen dung
define('settingTitleTuyendung','Tuyển dụng Azibai');
define('settingDescrTuyendung','Azibai.com – Tuyển dụng');
//Tim viec
define('settingTitleTimviec','Tìm việc làm Azibai');
define('settingDescrTimviec','Azibai.com – Tìm việc làm');
//Thời gian xử lý đơn hàng
define('process_oder_time','24h');
//Giới hạn gắp hàng hàng
define('product_allow_af','16');
//Pass truy cap
define('pass_access','123456');
//Email kinh doanh va ky thuat
define('Email_technical','info@azibai.com');
define('Email_business','support@azibai.com');
// Tình trạng đơn hàng
define('status_1','Mới');
define('status_2','Đang vận chuyển');
define('status_3','Đã giao hàng');
define('status_4','Giao không thành công');
define('status_5','Đang khiếu nại');
define('status_6','Đã nhận lại hàng - trả hàng');
define('status_7','Chờ xác nhận');
define('status_99','Hủy');
define('status_98','Đã hoàn thành');

define('settingEmail_Advs',' info@azibai.com'); // Email nhan thong bao quang cao
define('settingEmail_1',' info@azibai.com');
define('settingEmail_2',' info@azibai.com');
define('settingAddress_1','262 Huỳnh Văn Bánh, Phường 11, Quận Phú Nhuận, Tp.HCM');
define('settingAddress_2','262 Huỳnh Văn Bánh, Phường 11, Quận Phú Nhuận, Tp.HCM');
define('settingPhone','02862783969');
define('settingMobile',' 0919575925');
define('settingYahoo_1','azibai1');
define('settingYahoo_2','azibai2');
define('settingSkype_1','azibai1');
define('settingSkype_2','azibai2');
define('settingWebsite','https://azibai.com');
define('settingCopyright',' Bản quyền 2015 - Azibai.com.');
define('SettimeClick',5);
#Cau hinh chung
define('settingTimeSlide_Advs',5000);
define('settingTimePost',2);
define('settingLockAccount',60);
define('settingTimeSession',30);
define('settingTimeCache',10);
define('settingStopSite','0');
define('settingActiveAccount','1');
define('settingStopRegister','0');
define('settingStopRegisterVip','0');
define('settingStopRegisterShop','0');
define('settingExchange',20800);
define('settingChiPhiUpTin',500);
#Hien thi san pham
define('settingProductNew_Home',12);
define('settingProductReliable_Home',6);
define('settingProductNew_Category',60);
define('settingProductReliable_Category',24);
define('settingProductSaleoff',30);
define('settingProductNew_Top',10);
define('settingProductSaleoff_Top',10);
define('settingProductBuyest_Top',10);
define('settingProductUser',5);
define('settingProductCategory',5);
#Hien thi rao vat
define('settingAdsNew_Home',15);
define('settingAdsReliable_Category',20);
define('settingAdsNew_Category',40);
define('settingAdsShop',60);
define('settingAdsReliable_Top',10);
define('settingAdsNew_Top',10);
define('settingAdsViewest_Top',10);
define('settingAdsShop_Top',10);
define('settingAdsUser',5);
define('settingAdsCategory',5);
#Hien thi tin tuyen dung, tim viec
define('settingJobInterest',20);
define('settingJobNew',40);
define('settingJob24Gio_J_Top',10);
define('settingJob24Gio_E_Top',10);
define('settingJobUser',5);
define('settingJobField',5);
#Hien thi cua hang
define('settingShopInterest',20);
define('settingShopInterest_Category',12);
define('settingShopNew_Category',20);
define('settingShopSaleoff',30);
define('settingShopNew_Top',10);
define('settingShopSaleoff_Top',10);
define('settingShopProductest_Top',15);
#Hien thi shopping
define('settingShoppingInterest_Home',12);
define('settingShoppingNew_Home',12);
define('settingShoppingSaleoff_Home',12);
define('settingShoppingNew_List',3);
define('settingShoppingSaleoff_List',21);
define('settingShoppingAdsNew',40);
define('settingShoppingProductNew_Top',10);
define('settingShoppingAdsNew_Top',10);
define('settingShoppingSearch',20);
#Hien thi tim kiem
define('settingSearchProduct',20);
define('settingSearchAds',40);
define('settingSearchJob',40);
define('settingSearchShop',20);
define('noi_quy_dang_ky_thanh_vien',29);
#Cau hinh hien thi khac
define('settingOtherAccount',20);
define('settingOtherAdmin',20);
define('settingOtherShowcart',20);

define('limitPost36MProduct',100000);
define('limitPost600TProduct',10000);
define('limitPost150TProduct',30);
define('limitPostFreeProduct',0	);

define('limitPost36MAds',100000);
define('limitPost600TAds',10000);
define('limitPost150TAds',30);
define('limitPostFreeAds',10);

define('limitPost36MJob',100000);
define('limitPost600TJob',10000);
define('limitPost150TJob',30);
define('limitPostFreeJob',10);

define('limitPost36MEmploy',100000);
define('limitPost600TEmploy',10000);
define('limitPost150TEmploy',30);
define('limitPostFreeEmploy',10);

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
define('SMTPPORT', 587);
define('SMTPSERCURITY', '');
define('GUSER', 'no-reply@azibai.com');  // Email use to send SMTP
define('GPWD', 'Admin123456!'); 	// Password use to send SMTP

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
define('app_id','145194989402737');

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

//ngan luong
define('MERCHANT_ID', '45742');
define('MERCHANT_PASS', 'd9cbfe91ef00fd8c6759b7db1b143a06');
define('RECEIVER','azibaiglobe@gmail.com');

define('NL_VERSION', '3.1');
define('NL_FUNCTION', 'SetExpressCheckout');
define('NL_URL_SERVICE','https://www.nganluong.vn/checkout.api.nganluong.post.php');
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

define('HOTLINE','02862783969');
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
define('IP_CLOUDSERVER', '103.1.238.103');
define('USER_CLOUDSERVER', 'azibainet');
define('PASS_CLOUDSERVER', 'tWG67#d8');
define('PORT_CLOUDSERVER', 21);
define('DOMAIN_CLOUDSERVER', 'http://azibai.net/');

define('ACTIVE', 1);
define('DISABLE', 0);

define('TIMELINE_PERSONAL', 1);
define('TIMELINE_SHARE', 2);
define('TIMELINE_TAG', 3);

define('INPUT_DATE_FOMART', 'U');
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

define('domain_site', 'azibai.xxx');
define('IP_SERVER', 'S40');
define('SERVER_LOADBALANCER', '171.244.9.48');
define('ENVIRONMENT', 'development'); // local ->'localhost', .xyz -> 'development', .com -> 'production'

define('link_get_token', 'http://azibuy.info/public/api/v1/');
define('api_comment', 'http://commentdev.azibai.com/');
define('user_test_com', '');
define('FFMPEG_VER', '-4.0.2');

if(ENVIRONMENT == 'development' && !isset($_REQUEST['off'])){
    error_reporting(E_ALL);
}
