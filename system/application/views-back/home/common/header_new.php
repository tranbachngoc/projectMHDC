<?php
if (!class_exists('utilSlv')) {
    $this->load->library('utilSlv');
}
$util = utilSlv::getInstance(getAliasDomain());

$sHeader = $util->getData();
$siteUrl = $sHeader['url'];

$protocol = get_server_protocol();
$currentuser = !empty($azitab['user']) ? $azitab['user'] : '';
$af_key = '';
if(!empty($currentuser)){
    $af_key = $currentuser->af_key;
}
$myshop      = !empty($azitab['myshop']) ? $azitab['myshop'] : '';
$myshop_url = $siteUrl;

if(!empty($myshop->domain)){
    $myshop_url = 'http://' . $myshop->domain;
}else if (!empty($myshop->sho_link)){
    $myshop_url =  $protocol . $myshop->sho_link . '.' . domain_site ;
}

$ogdescription = isset($ogdescription) ? str_replace('"','“',strip_tags($ogdescription)) : settingDescr;
$ogtitle = isset($ogtitle) ? str_replace('"','“',strip_tags($ogtitle)) : settingTitle;
$iInvite = $this->session->userdata('iInvite');
?>
<!DOCTYPE html>
<html >
    <head>
	<link rel="shortcut icon" href="/templates/home/styles/images/favicon.png" type="image/x-icon"/>   
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="google-site-verification" content="Cxcxfz0Wn9LQGLgWXQ0cRQu61dZGZ-LFyups_lTM4O8" />
	<meta name="revisit-after" content="1 days"/>
	<meta name="description" content="<?php echo $ogdescription ?>"/>
	<meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="og_url" property="og:url" content="<?php echo (isset($ogurl) ? $ogurl : ''); ?>"/>
	<meta name="og_type" property="og:type" content="<?php echo (isset($ogtype)) ? $ogtype : ''; ?>"/>
	<meta name="og_title" property="og:title" content="<?php echo $ogtitle ?>"/>
	<meta name="og_description" property="og:description" content="<?php echo $ogdescription ?>"/>
	
    <meta name="og_image" property="og:image" content="<?php  echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain() . 'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>"/>
	<meta name="og_image_alt" property="og:image:alt" content="<?php  echo $ogtitle; ?>"/>
	<meta property="og:image:secure_url" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>" /> 
    <meta property="og:image:width" content="1500" />  
    <meta property="og:image:height" content="1500" />
    <meta name="fb_app_id" property="fb:app_id" content="<?php echo app_id ?>" />

	<?php if (!empty($isMobile) && $isMobile == 1) { ?>
    	<meta property="al:android:url" content="sharesample://store/apps/details?id=com.azibai.android">
    	<meta property="al:android:package" content="com.azibai.android">
    	<meta property="al:android:app_name" content="Azibai">	
    	<meta property="al:ios:url" content="https://azibai.com" />
    	<meta property="al:ios:app_name" content="azibai" />
    	<meta property="al:ios:app_store_id" content="1284773842" />
    	<meta property="al:web:should_f" content="false"/>
	<?php } ?>

	<link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
	<link rel="stylesheet" href="/templates/home/styles/css/reset.css">
	<link rel="stylesheet" href="/templates/home/styles/css/base.css">
	<link rel="stylesheet" href="/templates/home/styles/css/top.css">
	<link rel="stylesheet" href="/templates/home/styles/css/supperDefault.css">
	<link rel="stylesheet" href="/templates/home/styles/css/slick.css">
	<link rel="stylesheet" href="/templates/home/styles/css/slick-theme.css">
    <link rel="stylesheet" href="/templates/home/css/comment.css">
    <link href="/templates/home/styles/css/search.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/templates/home/styles/css/content.css">
    <link rel="stylesheet" href="/templates/home/styles/css/modal-show-details.css">
	<link rel="stylesheet" href="/templates/home/styles/css/mixin.css">
	<link rel="stylesheet" href="/templates/home/styles/css/variable.css">
	<link rel="stylesheet" href="/templates/home/styles/css/additions.css">

	<link rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css">

	<link rel="stylesheet" href="/templates/home/css/default.css">
    <link rel="stylesheet" href="/templates/home/styles/css/cart.css">
    <?php
    $this->load->library('Mobile_Detect');
    $detect = new Mobile_Detect();
    if (!$detect->isiOS()) {
    ?>
    <style>
        img.rotate-r-90 {
          -webkit-transform: rotate(90deg); 
          -moz-transform: rotate(90deg); 
          -o-transform: rotate(90deg);
          -ms-transform: rotate(90deg);
        }
        img.rotate-l-90 {
          -webkit-transform: rotate(-90deg); 
          -moz-transform: rotate(-90deg); 
          -o-transform: rotate(-90deg);
          -ms-transform: rotate(-90deg);
        }
        img.rotate-180 {
          -webkit-transform: rotate(180deg); 
          -moz-transform: rotate(180deg); 
          -o-transform: rotate(180deg);
          -ms-transform: rotate(180deg);
        }
    </style>
    <?php } ?>

    <?php if ($detect->isiOS()) { ?>
        <link rel="stylesheet" href="/templates/home/styles/css/for_IOS.css">
    <?php } ?>

	<title>
	    <?php echo (isset($ogtitle)) ? strip_tags($ogtitle) : settingTitle; ?>
	</title>
	
	<script src="/templates/home/js/jquery.min.js"></script>
<!--        <script src="/templates/home/js/jquery-3.3.1.min.js"></script>-->
    <script src="/templates/home/boostrap/js/popper.min.js"></script>
    <script type="text/javascript" src="/templates/home/boostrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/clipboard.min.js"></script>
    <script type="text/javascript" defer src="/templates/home/js/lottie.js"></script>
    <script type="text/javascript" defer src="/templates/home/js/comment.js"></script>
    <script src="/templates/home/styles/js/commission-aft.js"></script>

	<script>
        var SERVER_OPTIMIZE_URL = '<?php echo SERVER_OPTIMIZE_URL ?>';
        var server_load = '<?php echo $_SERVER['SERVER_ADDR'] ; ?>';
        var PROTOCOL = '<?php echo get_server_protocol() ?>';
        default_image_error_path = '<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>';
        function image_error(img)
        {
            img.setAttribute('src', default_image_error_path);
            img.className += ' error-image';
        }
        var DOMAIN_SITE = '<?php echo $protocol . domain_site ?>';

        var DOMAIN_SHOP = '<?php echo isset($shop_url) ? $shop_url : "" ?>';

	    jQuery(function ($) {
		$('[href="#notification"]').click(function () {
		    $('.popupright').hide();
		    $('#notification').toggle('fast');
		});
		$('[href="#popup2"]').click(function () {
		    $('.popupright').hide();
		    $('#popup2').toggle('fast');
		});
		$('[href="#popup5"]').click(function () {
		    $('.popupright').hide();
		    $('#popup5').toggle('fast');
		});
		$('.closepopup').click(function () {
		    $('.popupright').hide();
		});
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 500) {
			$('#toTop').fadeIn();
		    } else {
			$('#toTop').fadeOut();
		    }
		});
	    });
	</script>		

	<?php
    $sec1 = $this->uri->segment(1);
    $sec2 = $this->uri->segment(2);
    $sec3 = $this->uri->segment(3);
    $productDetail = false;
    $adsDetail = false;
    $raovatDetail = false;
    $default = false;
    if (is_numeric($sec2) && is_numeric($sec3)) {
    	if ($sec1 == 'raovat') {
    		$raovatDetail = true;
    	}
    	if ($sec1 == 'hoidap') {
    		$hoidapDetail = true;
    	}
    }
    if ($sec1 == '') {
    	$default = true;
    }
    ?>
	<?php if ((is_numeric($this->uri->segment(1)) && is_numeric($this->uri->segment(2)))) { ?>
    	<link type="text/css" rel="stylesheet" href="/templates/home/css/slimbox.css" media="screen"/>
    	<link type="text/css" rel="stylesheet" href="/templates/home/css/tabview_detail.css"/>
    	<script async src="/templates/home/js/check_email.js"></script>
    	<script type="text/javascript">
    	    jQuery(document).ready(function () {
    		var widthScreen = jQuery(window).width();
    		if (widthScreen <= 1024) {
    		    jQuery('.info_view_detail table').css('width', '100%');
    		    jQuery('#product-detail-payment').css('float', 'left');
    		}
	    <?php if ($product->pro_show == 1) { ?>
		jQuery('.colorbox').colorbox({rel: 'colorbox'});
	    <?php
			} ?>
    		jQuery('.image_boxpro').mouseover(function () {
    		    tooltipPicture(this, jQuery(this).attr('id'));
    		});
    	    });
    	</script>
	<?php
    } ?>
	<script type="text/javascript">
        var website_url = window.location.origin + '/';
        <?php echo $sHeader['config']; ?>
        var urlFile = '<?php echo $sHeader['url']; ?>'
	</script>

	<?php if ($sHeader['inline_script'] != '') : ?>
    	<script type="text/javascript">
    <?php echo $sHeader['inline_script']; ?>
    	</script>
	<?php endif; ?>		
	<?php foreach ($sHeader['scripts'] as $script) : ?>
    	<script  src="<?php echo $script; ?>"></script>
	<?php endforeach; ?>	
        
	<script async src="/templates/home/js/news.js"></script>	
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-97816819-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-97816819-2');
    </script>
    </head>
    <body class="<?php echo !empty($body_class) ? $body_class : '' ?>">

    <div class="temp-share">
        <?php $this->load->view('home/share/popup-btn-share'); ?>
    </div>

    <?php $this->load->view('home/common/modal-mess'); ?>

	<div class="wrapper">
        <header>
            <div class="header md">
                <div class="container">
                    <div class="header-menu">
                        <div class="header-menu-left">
                            <ul>
                                <li class="home">
                                    <a href="<?php echo azibai_url() ?>">
                                        <img class="icon-img" src="/templates/home/styles/images/svg/a.svg" alt="azibai">
                                    </a>
                                </li>
                                <li><a href="#">Tải ứng dụng</a></li>
                                <li class="tablet-none"><a href="#">Kết nối</a></li>
                                <li class="no-border">
                                    <a href="#">
                                        <img src="/templates/home/styles/images/svg/instagram.svg" alt="instagram">
                                    </a>
                                </li>
                                <li class="no-border">
                                    <a href="https://www.facebook.com/azibai/">
                                        <img src="/templates/home/styles/images/svg/facebook.svg" alt="facebook">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="header-menu-center">
                            <?php $this->load->view('search/home/input-search');?>
                        </div>
                        <div class="header-menu-right">
                            <ul class="header-list-icon">
                                <li><a href="<?php echo azibai_url() . '/shop/products' . ($af_key ? "?af_id=$af_key" : '') ?>"><img src="/templates/home/styles/images/svg/shop.svg" width="15" alt=""></a></li>
                                <li><a href="<?php echo $siteUrl .'v-checkout' ?>"><img src="/templates/home/styles/images/svg/cart02.svg" width="15" alt=""><span class="num cartNum"><?php echo $azitab['cart_num']; ?></span></a></li>
                                <li>
                                    <a href="<?php echo azibai_url('/links') ?>">
                                        <img src="/templates/home/styles/images/svg/help_black.svg" width="24" alt="">
                                    </a>
                                </li>
                                <!-- <li><a href="#"><img src="/templates/home/styles/images/svg/bell_black.svg" width="15" alt=""><span class="num">19</span></a></li>
                                <li><a href="#"><img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt=""><span class="num">19</span></a></li>
                                <li><a href="#"><img src="/templates/home/styles/images/svg/message02.svg" width="15" alt=""><span class="num">19</span></a></li> -->
                            </ul>
                            <ul class="header-avata">
                                <?php if (isset($currentuser) && $currentuser) {
                                    $avatar      = site_url('media/images/avatar/default-avatar.png');
                                    $avatar_shop = site_url('media/images/avatar/default-avatar.png');
                                    $avatar_used = '';
                                    if ($currentuser->avatar) {
                                        $avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $currentuser->use_id . '/' .  $currentuser->avatar;
                                    }
                                    if($myshop->sho_dir_logo && $myshop->sho_logo){
                                        $avatar_shop = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $myshop->sho_dir_logo . '/' . $myshop->sho_logo;
                                    }
                                    if($_SERVER['HTTP_HOST'] == domain_site){
                                        $avatar_used = $avatar;
                                    } else {
                                        $avatar_used = $avatar_shop;
                                    }
                                    ?>
                                    <li class="avata js-header-avata">
                                        <a href="#">
                                            <img class="img-circle icon-avata" src="<?php echo $avatar_used; ?>" alt="account">
                                        </a>
                                    </li>
                                    <li class="dropdowninfo">
                                        <div class="dropdowninfo-arrow"><a href="#"></a></div>
                                        <div class="dropdowninfo-show-login">
                                            <p>Trang của bạn</p>
                                            <p class="list">
                                                <a target="_blank" href="<?php echo ($currentuser->website ? 'http://'.$currentuser->website : azibai_url() . '/profile/' . $currentuser->use_id)?>">
                                                    <img src="<?php echo $avatar; ?>" alt="" width="32" class="mr15 icon-avata">Trang cá nhân
                                                </a>
                                            </p>
                                            <p class="list">
                                                <a href="<?php echo $myshop_url ?>">
                                                    <img src="<?php echo $avatar_shop; ?>" alt="" width="32" class="mr15 icon-avata">Trang doanh nghiệp
                                                </a>
                                            </p>
                                            <p class="list">
                                                <a href="<?php echo $myshop_url . '/shop' ?>">
                                                    <img src="<?php echo $avatar_shop; ?>" alt="" width="32" class="mr15 icon-avata">Tiệm shop
                                                </a>
                                            </p>
                                            <p class="list"><a href="<?= azibai_url(); ?>/account/edit"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Quản lý chung</a></p>
                                            <?php if(in_array($this->session->userdata('sessionGroup'), [AffiliateStoreUser, BranchUser])) {?>
                                            <p class="list">
                                                <a href="<?= azibai_url('/page-business') . ($this->session->userdata('sessionGroup') == BranchUser ? '/'.$this->session->userdata('sessionUser') : ''); ?>">
                                                    <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Quản lý trang
                                                </a>
                                            </p>
                                            <?php }?>
                                            <p class="list"><a href="<?= azibai_url(); ?>/shop/service"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Dịch vụ</a></p>
                                            <?php if($this->session->userdata('isAffiliate') > 0) { ?>
                                                <p class="list"><a href="<?= azibai_url(); ?>/affiliate"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Đối tác</a></p>
                                            <?php } ?>
                                            <p class="list"><a class="giohang" href="<?= azibai_url(); ?>/affiliate/invitea"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24">
                                                <?php if($iInvite != 0) { ?>
                                                    <span class="mr05"><?=$iInvite;?></span>
                                                <?php } ?>
                                                Lời mời cộng tác</a>
                                            </p>
                                            
                                            <p class="list"><a href="<?=azibai_url('/manager/order')?>"><img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a></p>
                                            <p class="list">
                                                <a href="<?php echo $myshop_url . '/shop/collection'; ?>">
                                                    <img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập
                                                </a>
                                            </p>
                                            <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/vi.svg" alt="" width="24" >Ví điện tử</a></p>
                                            <p class="list"><a href="<?php //echo base_url() ?>account"><img src="/templates/home/styles/images/svg/2user.svg" alt="" width="24" >Người bán hàng</a></p>
                                            <p class="list"><a href=""><img src="/templates/home/styles/images/svg/dola_circle.svg" alt="" width="24" >Cộng tác viên</a></p>
                                            <p class="list"><a href=""><img src="/templates/home/styles/images/svg/headphone.svg" alt="" width="24" >Trợ giúp</a></p> -->
                                            <p class="mt10 f18"><a href="<?php echo $siteUrl .'logout' ?>">Đăng xuất</a></p>
                                        </div>
                                    </li>
                                <?php } else { ?>
                                <li class="avata">                                    
                                    <a href="/login">
                                        <img class="img-circle"
                                                src="/templates/home/styles/images/product/avata/default-avatar.png"
                                                alt="account">
                                    </a>
                                </li>
                                <li class="dropdowninfo">
                                    <div class="dropdowninfo-arrow"><a href="#"></a></div>
                                    <div class="dropdowninfo-show-nologin">
                                        <p class="list"><a href="/login"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" ><strong>Đăng nhập</strong></a></p>
                                        <p class="list"><a href="<?php echo azibai_url() .'/register/verifycode' ?>"><img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký</a></p>
                                        <p class="kiemtradonhang list"><img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng</p>
                                        <div class="kiemtradonhang-show">
                                        <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                                        <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm header-sp js-fixed-header-sm">
                <?php
                $link = '';
                if (isset($currentuser) && $currentuser) {
                    if ($currentuser->avatar) {
                        $avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $currentuser->use_id . '/' .  $currentuser->avatar;
                    } else {
                        $avatar = site_url('media/images/avatar/default-avatar.png');
                    }
                } else {
                    $avatar = site_url('media/images/avatar/default-avatar.png');
                    $link   = "/login";
                }
                ?>
                <div class="header-sp-nav">
                    <ul class="f-gnav">
                        <li><a href="<?php echo azibai_url() ?>"><img class="icon-img" src="/templates/home/styles/images/svg/a.svg" alt="azibai"></a></li>
                        <li><a href="<?= azibai_url() . '/shop/products' . ($af_key ? "?af_id=$af_key" : '') ?>"><img src="/templates/home/styles/images/svg/shop.svg"  alt=""></a></li>
                        <li>
                            <a href="<?php echo azibai_url('/links') ?>">
                                <img src="/templates/home/styles/images/svg/help_black.svg">
                            </a>
                        </li>
                        <!-- <li><a href="#"><img src="/templates/home/styles/images/svg/bell_black.svg" width="24" alt=""><span class="num">19</span></a></li> -->
                        <li class="search-click"><a href="#"><img src="/templates/home/styles/images/svg/search.svg" alt=""></a></li>
                        <!-- <li><a href="#"><img src="/templates/home/styles/images/svg/message02.svg" width="24" alt=""><span class="num num2">19</span></a></li> -->
                        <li class="ico-nav">
                        <div class="drawer-hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        </li>
                    </ul>
                    <div class="input-search hidden">
                        <?php $this->load->view('search/home/input-search');?>
                    </div>
                    <nav class="sm-gnav">
                    <?php if (isset($currentuser) && $currentuser) { ?>
                        <div class="dropdowninfo-show-login">
                            <p class="list">
                                <a class="giohang" href="<?php echo azibai_url() .'/v-checkout' ?>">
                                    <img src="/templates/home/styles/images/svg/cart02.svg" width="24" alt="">
                                    <span class="num cartNum"><?php echo $azitab['cart_num']; ?></span> Giỏ hàng
                                </a>
                            </p>
                            <p>Trang của bạn</p>
                            <p class="list">
                                <a target="_blank" href="<?php echo ($currentuser->website ? 'http://'.$currentuser->website : azibai_url() . '/profile/' . $currentuser->use_id)?>">
                                    <img src="<?php echo $avatar; ?>" alt="" width="32" class="mr15 icon-avata">Trang cá nhân
                                </a>
                            </p>
                            <p class="list">
                                <a href="<?php echo $myshop_url ?>">
                                    <img src="<?php echo $avatar_shop; ?>" alt="" width="32" class="mr15 icon-avata">Trang doanh nghiệp
                                </a>
                            </p>
                            <p class="list">
                                <a href="<?php echo $myshop_url . '/shop' ?>">
                                    <img src="<?php echo $avatar_shop; ?>" alt="" width="32" class="mr15 icon-avata">Tiệm shop
                                </a>
                            </p>
                            <p class="list"><a href="<?= azibai_url() ?>/account/edit"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Quản lý chung</a></p>
                            <?php if(in_array($this->session->userdata('sessionGroup'), [AffiliateStoreUser, BranchUser])) {?>
                            <p class="list">
                                <a href="<?= azibai_url('/page-business') . ($this->session->userdata('sessionGroup') == BranchUser ? '/'.$this->session->userdata('sessionUser') : ''); ?>">
                                    <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Quản lý trang
                                </a>
                            </p>
                            <?php }?>
                            <?php if($this->session->userdata('affiliate_level') > 0) { ?>
                            <p class="list"><a href="<?= azibai_url() ?>/affiliate"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Đối tác</a></p>
                            <?php } ?>
                            <p class="list"><a href="<?= azibai_url() ?>/shop/service"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Dịch vụ</a></p>
                            <p class="list"><a href="<?=azibai_url('/manager/order')?>"><img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a></p>
                            <p class="list"><a href="<?php echo $myshop_url . '/shop/collection'?>">
                                <img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập
                            </a></p>
                            <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/vi.svg" alt="" width="24" >Ví điện tử</a></p>
                            <p class="list"><a href=""><img src="/templates/home/styles/images/svg/2user.svg" alt="" width="24" >Người bán hàng</a></p>
                            <p class="list"><a href=""><img src="/templates/home/styles/images/svg/dola_circle.svg" alt="" width="24" >Cộng tác viên</a></p>
                            <p class="list"><a href=""><img src="/templates/home/styles/images/svg/headphone.svg" alt="" width="24" >Trợ giúp</a></p> -->
                            <p class="mt10 f18"><a href="<?php echo azibai_url() . '/logout' ?>">Đăng xuất</a></p>
                        </div>
                    <?php } else { ?>
                        <div class="dropdowninfo-show-nologin">
                            <!-- <p>Trang của bạn</p> -->
<!--                            <p><a href="--><?php //echo base_url() . 'login' ?><!--"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" ><strong>Đăng nhập</strong></a></p>-->
                            <p class="list"><a href="/login"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" ><strong>Đăng nhập</strong></a></p>
                            <p class="list"><a href="<?php echo azibai_url() . '/register/verifycode' ?>"><img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký</a></p>
                            <p class="list">
                                <a class="giohang" href="<?php echo azibai_url() .'/v-checkout' ?>">
                                    <img src="/templates/home/styles/images/svg/cart02.svg" width="24" alt="">
                                    <span class="num cartNum"><?php echo $azitab['cart_num']; ?></span> Giỏ hàng
                                </a>
                            </p>
                            <p class="kiemtradonhang list"><img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng</p>
                            <div class="kiemtradonhang-show">
                                <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                                <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                            </div>
                        </div>
                    <?php } ?>
                    </nav>
                </div>
                <!-- <div class="header-sp-search">
                    <div class="search"><input type="text" placeholder="Tìm kiếm tin tức"><img
                                src="/templates/home/styles/images/svg/search.svg" class="icon-img" alt=""></div>
                    <div class="sm">
                        <div class="show-info-number mr00"><img class="icon-img"
                                                                src="/templates/home/styles/images/svg/message.svg"
                                                                alt="message"></div>
                    </div>
                </div> -->
                
            </div>
        </header>