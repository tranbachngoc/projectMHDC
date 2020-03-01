<?php
$protocol = get_server_protocol();
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="UTF-8">
    <title>
      <?php echo (isset($ogtitle)) ? strip_tags($ogtitle) : settingTitle; ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="" />
    <meta name="description" content="<?php echo isset($descrSiteGlobal) ? $descrSiteGlobal : settingDescr; ?>"/>
    <meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
    <meta property="og:url" content="<?php echo $ogurl; ?>" />
    <meta property="og:type" content="<?php echo $ogtype; ?>" />
    <meta property="og:title" content="<?php echo $ogtitle; ?>" />
    <meta property="og:description" content="<?php echo $ogdescription; ?>" />
    <meta property="og:image" content="<?php echo $ogimage; ?>" />
    <meta property="og:image:secure_url" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>" /> 
    <meta property="og:image:width" content="1500" /> 
    <meta property="og:image:height" content="1500" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="X-UA-Compatible", content="IE=edge">
    <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->

    <!-- CSS -->
    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
    <link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/top.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/slick.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/slick-theme.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/additions.css" rel="stylesheet" type="text/css">
    <!-- JS -->
    <script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="./js/jquery-3.3.1.min.js"><\/script>')</script>

    <script src="/templates/home/js/general_ver2.js"></script>
    <script src="/templates/home/styles/js/countdown.js"></script>
  <script>
      default_image_error_path = '<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>';
      function image_error(img)
      {
          img.setAttribute('src', default_image_error_path);
          img.className += ' error-image';
      }
  </script>

  </head>
<body class="trangcuahang <?php echo isset($body_class) ? $body_class : ''?>">
  <div class="wrapper">
    <header>
      <div class="container">

        <div class="drawer-hamburger sm">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <nav class="header-nav-left sm-gnav">
          <ul>
            <li class="<?php echo @$menuSelected == 'home' ? 'active' : '' ?>"><a href="<?=base_url(); ?>">Trang chủ</a></li>
            <li class="<?php echo @$menuSelected == 'introduct' ? 'active' : '' ?>"><a href="<?=base_url() .'shop/introduct'; ?>">Giới thiệu</a></li>
            <li class="<?php echo @$menuSelected == 'shop' ? 'active' : '' ?>"><a href="<?=base_url() .'shop'; ?>">Cửa hàng</a></li>
            <li class="<?php echo @$menuSelected == 'product' ? 'active' : '' ?>"><a href="<?=base_url() .'shop/product'; ?>">Sản phẩm </a></li>
            <li class="<?php echo @$menuSelected == 'coupon' ? 'active' : '' ?>"><a href="<?=base_url() .'shop/coupon'; ?>">Coupon </a></li>
            <!-- <li class="<?php // echo @$menuSelected == 'warranty' ? 'active' : '' ?>"><a href="<?= // base_url() .'shop/warranty'; ?>">Chính sách</a></li> -->
            <li class="<?php echo @$menuSelected == 'contact' ? 'active' : '' ?>"><a href="<?=base_url() .'shop/contact'; ?>">Liên hệ</a></li>
            <li><a href="<?=$protocol . domain_site; ?>">Azibai</a></li>
          </ul>
        </nav>
        <nav class="header-nav-right">
          <div class="dienthoai"><a href="tel:<?=$siteGlobal->sho_mobile;?>"><img src="/templates/home/styles/images/svg/ico_tel.svg" alt="" class="mr05"><?=$siteGlobal->sho_mobile;?></a></div>
          <a class="giohang" href="/v-checkout" target="_blank">
              <img src="/templates/home/styles/images/svg/bag.svg" height="24" alt="">
              <span class="num cartNum"><?php echo $azitab['cart_num']; ?></span>
          </a>
          <ul class="header-avata">
            <?php if (isset($currentuser) && $currentuser) {
              if ($currentuser->avatar) {
                  $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->use_id . '/' . $currentuser->avatar;
              } else {
                  $avatar = site_url('media/images/avatar/default-avatar.png');
              }
              ?>
            <li class="avata">
              <a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site ?>">
                <img src="<?=$avatar?>" alt="cart">
              </a>
            </li> 
            <li class="dropdowninfo">
              <div class="dropdowninfo-arrow "><a href="#"></a></div>
              <div class="dropdowninfo-show-login">
                <p>Trang của bạn</p>
                <p class="list"><a href="Javascript:void(0)"><img src="<?php echo $avatar; ?>" alt="" width="32" >Trang cá nhân</a></p>
                <p class="list"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site ?>"><img src="<?php echo $avatar; ?>" alt="" width="32" >Trang doanh nghiệp</a></p>
                <p class="list"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site . '/shop'?>"><img src="<?php echo $avatar; ?>" alt="" width="32" >Tiệm shop</a></p>
                <p class="list"><a href="<?php echo $protocol . domain_site . '/account/edit'?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Thông tin chung</a></p>
                <p class="list"><a href="<?php echo $protocol . domain_site . '/manager/order'?>"><img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a></p>
                <p class="list"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site . '/shop/collection/all' ?>"><img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập</a></p>
                <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/vi.svg" alt="" width="24" >Ví điện tử</a></p> -->
                <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/2user.svg" alt="" width="24" >Người bán hàng</a></p> -->
                <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/dola_circle.svg" alt="" width="24" >Cộng tác viên</a></p> -->
                <!-- <p class="list"><a href=""><img src="/templates/home/styles/images/svg/headphone.svg" alt="" width="24" >Trợ giúp</a></p> -->
                <p class="mt10 f18"><a href="<?php echo base_url() .'logout' ?>">Đăng xuất</a></p>
              </div>
            </li>
            <?php } else { ?>
            <li class="avata"><a href="/login"><img class="img-circle"src="/templates/home/styles/images/product/avata/default-avatar.png"alt="account"></a></li>
            <li>
              <div class="dropdowninfo-arrow "><a href="#"></a></div>
              <div class="dropdowninfo-show-nologin">
                <p class="list"><a href="<?php echo base_url() .'login' ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" ><strong>Đăng nhập</strong></a></p>
                <p class="list"><a href="<?php echo base_url() .'register/verifycode' ?>"><img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký</a></p>
                <p class="kiemtradonhang list"><img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng</p>
                <div class="kiemtradonhang-show">
                  <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                  <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                </div>
              </div>
            </li>
            <?php } ?>
          </ul>
        </nav> 
      </div>
    </header>
    <script>
    var siteUrl = '<?php echo base_url();?>';
    </script>


