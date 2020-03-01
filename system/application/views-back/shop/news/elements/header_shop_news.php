<?php
if(!isset($hook_shop)){
    $hook_shop = MY_Loader::$static_data['hook_shop'];
}
if(!isset($user_login)){
    $user_login = MY_Loader::$static_data['hook_user'];
}

$protocol  = get_server_protocol();
$siteUrl   = getAliasDomain();
$azibaiUrl = azibai_url();
$shop_url  = @$hook_shop->shop_url;
$shop_logo = @$hook_shop->logo;
$library_media = [
    'image'     => $shop_url . 'library/images',
    'video'     => $shop_url . 'library/videos',
    'coupon'    => $shop_url . 'library/coupons',
    'product'   => $shop_url . 'library/products',
    'link'      => $shop_url . 'library/links',
];

$ogdescription = isset($ogdescription) ? str_replace('"','“',strip_tags($ogdescription)) : settingDescr;
$ogtitle = isset($ogtitle) ? str_replace('"','“',strip_tags($ogtitle)) : settingTitle;

?> 
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
        echo (isset($ogtitle)) ? strip_tags($ogtitle) : settingTitle;
        ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="robots" content=""/>
    <meta name="description" content="<?php echo $ogdescription; ?>"/>
    <meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
    <meta name="og_url" property="og:url" content="<?php echo(isset($ogurl) ? $ogurl : ''); ?>"/>
    <meta name="og_type" property="og:type" content="<?php echo (isset($ogtype)) ? $ogtype : ''; ?>"/>
    <meta name="og_title" property="og:title" content="<?php echo $ogtitle ?>"/>
    <meta name="og_description" property="og:description" content="<?php echo $ogdescription; ?>"/>
    <meta name="og_image" property="og:image" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain() . 'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>"/>
    <meta name="og_image_alt" property="og:image:alt" content="<?php echo $ogtitle ?>"/>
    <meta property="og:image:secure_url" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain() . 'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>"/>
    <meta property="og:image:width" content="1500"/>
    <meta property="og:image:height" content="1500"/>
    <meta name="fb_app_id" property="fb:app_id" content="<?php echo app_id ?>"/>
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="X-UA-Compatible" , content="IE=edge">
    <!--[if IE]>
    <meta http-equiv="cleartype" content="on">
    <![endif]-->

    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
    <link rel="stylesheet" href="/templates/home/styles/css/reset.css">
    <link rel="stylesheet" href="/templates/home/styles/css/base.css">
    <link rel="stylesheet" href="/templates/home/styles/css/top.css">
    <link rel="stylesheet" href="/templates/home/styles/css/supperDefault.css">
    <link rel="stylesheet" href="/templates/home/styles/css/slick.css">
    <link rel="stylesheet" href="/templates/home/styles/css/slick-theme.css">
    <link rel="stylesheet" href="/templates/home/css/comment.css">
    <link rel="stylesheet" href="/templates/home/styles/css/content.css">
    <link rel="stylesheet" href="/templates/home/styles/css/modal-show-details.css">
    <link rel="stylesheet" href="/templates/home/styles/css/mixin.css">
    <link rel="stylesheet" href="/templates/home/styles/css/variable.css">
    <link rel="stylesheet" href="/templates/home/styles/css/additions.css">
    <link rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css">
    <link rel="stylesheet" href="/templates/home/css/default.css">
    <link rel="stylesheet" href="/templates/home/styles/css/cart.css">

    <?php
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
    <!-- JS -->
    <script src="/templates/home/js/jquery.min.js"></script>
    <script src="/templates/home/boostrap/js/popper.min.js"></script>
    <script type="text/javascript" defer src="/templates/home/js/lottie.js"></script>
    <script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
    <script>
        default_image_error_path = '<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>';
        function image_error(img) {
            img.setAttribute('src', default_image_error_path);
            img.className += ' error-image';
        }
        var urlFile = siteUrl = website_url='<?php echo $siteUrl; ?>';
        var SERVER_OPTIMIZE_URL = '<?php echo SERVER_OPTIMIZE_URL ?>';
        var DOMAIN_SITE = '<?php echo $protocol . domain_site ?>';
        var DOMAIN_SHOP = '<?php echo isset($shop_url) ? $shop_url : "" ?>';
    </script>
</head>
<body class="trangcuahang <?php echo isset($body_class) ? $body_class : '' ?>">
    <div class="temp-share">
    <?php
    $this->load->view('home/share/popup-btn-share');
    ?>
    </div>
    <?php $this->load->view('home/common/modal-mess'); ?>
    <div class="wrapper">
        <header>
            <div class="header02">
                <div class="container js-fixed-header-sm">
                    <nav class="header-nav-left <?php echo empty($user_login) ? 'no-login' : '' ?>">
                        <div class="search">
                            <input type="text" placeholder="Tìm kiếm">
                            <img src="/templates/home/styles/images/svg/search.svg" class="icon" alt="">
                        </div>
                    </nav>
                    <nav class="header-nav-right">
                        <?php if (!empty($user_login)) { ?>
                            <ul class="header-avata">
                                <li class="avata md">
                                    <a href="#">
                                        <img src="<?php echo $user_login['avatar_url'] ?>" alt="cart">
                                    </a>
                                </li>
                                <li class="drawer-hamburger dropdowninfo-drawer-hamburger dropdowninfo-arrow sm">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </li>
                                <li class="dropdowninfo">
                                    <div class="dropdowninfo-arrow md"><a href="#"></a></div>
                                    <div class="dropdowninfo-show-nologin">
                                        <p class="list">
                                            <a href="<?php echo azibai_url(); ?>">
                                                <img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai
                                            </a>
                                        </p>
                                        <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang mb-4">
                                            <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
                                            <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
                                        </a>
                                        <p>Trang của bạn</p>
                                        <p class="list">
                                            <a target="_blank" href="<?php echo $user_login['profile_url'] ?>">
                                                <img src="<?php echo $user_login['avatar_url'] ?>" alt="" width="32" class="mr15 icon-avata">Trang cá nhân
                                            </a>
                                        </p>
                                        <!-- <p class="list">
                                            <a target="_blank" href="<?php echo $user_login['profile_url'] . 'affiliate-shop' ?>">
                                                <img src="<?php echo $user_login['avatar_url'] ?>" alt="" width="32" class="mr15 icon-avata">Shop cá nhân
                                            </a>
                                        </p> -->
                                        <p class="list">
                                            <a href="<?php echo $user_login['my_shop']['shop_url'] ?>">
                                                <img src="<?php echo $user_login['my_shop']['logo'] ?>"
                                                     alt="<?php echo htmlspecialchars($user_login['my_shop']['sho_name']) ?>"
                                                     width="32" class="mr15 icon-avata">Trang doanh nghiệp
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?php echo $user_login['my_shop']['shop_url'] . 'shop' ?>">
                                                <img src="<?php echo $user_login['my_shop']['logo']; ?>"
                                                     alt="<?php echo htmlspecialchars($user_login['my_shop']['sho_name']) ?>"
                                                     width="32" class="mr15 icon-avata">Shop doanh nghiệp
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?= azibai_url('/account/edit'); ?>">
                                                <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Thông tin chung
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?= azibai_url('/shop/service'); ?>">
                                                <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Dịch vụ
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?=azibai_url('/manager/order')?>">
                                                <img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?php echo $user_login['my_shop']['shop_url'] . 'shop/collection'; ?>">
                                                <img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập
                                            </a>
                                        </p>
                                        <p class="mt10 f18"><a href="<?php echo $siteUrl .'logout' ?>">Đăng xuất</a></p>
                                    </div>
                                </li>
                            </ul>
                        <?php } else { ?>
                            <ul class="header-avata">
                                <li class="avata md">
                                    <a href="#">
                                        <img class="img-circle" src="/templates/home/styles/images/product/avata/default-avatar.png" alt="account">
                                    </a>
                                </li>
                                <li class="drawer-hamburger dropdowninfo-drawer-hamburger dropdowninfo-arrow sm">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </li>
                                <li class="dropdowninfo">
                                    <div class="dropdowninfo-arrow md"><a href="#"></a></div>
                                    <div class="dropdowninfo-show-nologin">
                                        <p class="list">
                                            <a href="/login">
                                                <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Đăng nhập
                                            </a>
                                        </p>
                                        <p class="list">
                                            <a href="<?php echo azibai_url() .'/register/verifycode' ?>">
                                                <img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký
                                            </a>
                                        </p>
                                        <p class="kiemtradonhang list">
                                            <img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng
                                        </p>
                                        <div class="kiemtradonhang-show">
                                            <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                                            <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                                        </div>
                                        <p class="list">
                                            <a href="<?php echo azibai_url() ?>">
                                                <img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai
                                            </a>
                                        </p>
                                        <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang">
                                            <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
                                            <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        <?php } ?>
                    </nav>
                </div>
            </div>
        </header>



