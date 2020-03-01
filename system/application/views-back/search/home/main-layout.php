<?php
if(!isset($hook_shop)){
  $hook_shop = MY_Loader::$static_data['hook_shop'];
}
if(!isset($user_login)){
  $user_login = MY_Loader::$static_data['hook_user'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="UTF-8">
  <title>Azibai</title>
  <meta name="description" content="<?=SEO_DESCRIPTION?>">
  <meta name="Keywords" content="<?=SEO_KEYWORDS?>">
  <meta name="robots" content="INDEX,FOLLOW">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0" id="viewport">
  <meta name="HandheldFriendly" content="True">
  <meta http-equiv="X-UA-Compatible" , content="IE=edge">
  <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">

  <!-- CSS -->
  <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
  <link rel="stylesheet" href="/templates/home/boostrap/css/animate.min.css">
  <link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/top.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/slick.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
  <link href="/templates//home/styles/fontawesome/all.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/search.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
  <!-- JS -->
  <script src="/templates/home/js/jquery.min.js"></script>
  <script src="/templates/home/boostrap/js/popper.min.js"></script>
  <script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <script src="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.js"></script>
  <script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php $this->load->view('search/home/header-layout');?>
    <?php $this->load->view('search/home/body-layout');?>
    <?php $this->load->view('search/home/footer-layout');?>
  </div>

<?php $this->load->view('search/home/js/common-js');?>

<script type="text/javascript">
  $('.sm-btn-show').click(function () {
    var parent = $(this).closest('.item');
    parent.toggleClass('show-action');
    if (parent.hasClass('show-action')) {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_close.svg');
    } else {
      $(this).find('img').attr('src', '/templates/home/styles/images/svg/shop_icon_add.svg');
    }
  });

  $('.js-shop-product-items').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 2,
    arrows: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1.5,
          slidesToScroll: 1,
          arrows: false
        }
      }
    ]
  });
  $('.js-list-videos').slick({
    dots: false,
    infinite: false,
    slidesToShow: 2.2,
    slidesToScroll: 2,
    arrows: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2.2,
          slidesToScroll: 1,
          arrows: false
        }
      }
    ]
  });
</script>

</body>

</html>