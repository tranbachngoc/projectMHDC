<html dir="ltr" lang="en">

<head>
  <meta charset="UTF-8">
  <title>
    <?php echo (isset($ogtitle)) ? strip_tags($ogtitle) : settingTitle; ?>
  </title>
  <meta name="description" content="<?php echo isset($descrSiteGlobal) ? $descrSiteGlobal : settingDescr; ?>"/>
  <meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
  <meta name="robots" content="INDEX,FOLLOW">
  <meta property="og:url" content="<?php echo $ogurl; ?>" />
  <meta property="og:type" content="<?php echo $ogtype; ?>" />
  <meta property="og:title" content="<?php echo (isset($ogtitle)) ? $this->filter->injection_html(strip_tags($ogtitle)) : settingTitle; ?>" />
  <meta property="og:description" content="<?php echo (isset($ogdescription)) ? $this->filter->injection_html(strip_tags($ogdescription)) : settingDescr; ?>" />
  <meta property="og:image" content="<?php echo $ogimage; ?>" />
  <meta property="og:image:secure_url" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>" /> 
  <meta property="og:image:width" content="1500" /> 
  <meta property="og:image:height" content="1500" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
  <meta name="HandheldFriendly" content="True">
  <meta http-equiv="X-UA-Compatible" , content="IE=edge">
  <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->

  <!-- CSS -->
  <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
  <link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/top.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/slick.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
  <!-- JS -->
  <script src="/templates/home/styles/plugins/jquery.min.js"></script>
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/js/general_ver2.js"></script>
  <script src="/templates/home/js/clipboard.min.js"></script>
</head>
<?php
  if (!class_exists('utilSlv')) {
      $this->load->library('utilSlv');
  }
  $util = utilSlv::getInstance(getAliasDomain());

  $sHeader = $util->getData();
  ?>
<script type="text/javascript">
  var urlFile = '<?php echo $sHeader['url']; ?>'
</script>
<?php //dd($shop_current);die;?>
<?php $this->load->view('home/personal/affililate-shop/body-layout'); ?>

<?php $this->load->view('home/personal/affililate-shop/footer-layout'); ?>

<!-- POPUP-->
<?php $this->load->view('home/personal/affililate-shop/popup/popup-alert'); ?>

<div class="temp-share">
  <?php $this->load->view('home/share/popup-btn-share'); ?>
</div>

<?php $this->load->view('home/common/modal-mess'); ?>

<script src="/templates/home/boostrap/js/popper.min.js"></script>
<script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script type="text/javascript">

  if($('.show-cc-sp').hasClass('active')){
    $('.shop-slider').eq(0).show();
  }
  if($('.show-cc-cp').hasClass('active')){
    $('.shop-slider').eq(1).show();
  }

  var siteUrl = '<?=$shop_url?>';
  var options = {
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows: true,
      dots: false,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            centerMode: true,
            centerPadding: '60px',
          }
        }
      ]
      // variableWidth: true
    };

  $('.list-collection-coupon').slick(options);

  $('.list-collection-product').slick(options);

  $('.js-danh-muc-san-pham-slider').slick({
		slidesToShow: 5,
		slidesToScroll: 4,
		arrows: true,
		dots: false,
		responsive: [
			{
				breakpoint: 1025,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1.5,
					slidesToScroll: 1,
				}
			}
		]
		// variableWidth: true
	});

  $('.sm-btn-show').click(function(){
    var parent = $(this).closest('.item');
    parent.toggleClass('show-action');
    if (parent.hasClass('show-action')) {
      $(this).find('img').attr('src','/templates/home/styles/images/svg/shop_icon_close.svg');
    } else {
      $(this).find('img').attr('src','/templates/home/styles/images/svg/shop_icon_add.svg');
    }
  });

  $('.show-cc-sp').click(function(){
    $(this).addClass('active');
    $('.show-cc-cp').removeClass('active');
    $('.shop-slider').eq(0).show();
    $('.shop-slider').eq(1).hide();
    $('.list-collection-product').slick('unslick');
    $('.list-collection-product').slick(options);
  });

  $('.show-cc-cp').click(function(){
    $(this).addClass('active');
    $('.show-cc-sp').removeClass('active');
    $('.shop-slider').eq(1).show();
    $('.shop-slider').eq(0).hide();
    $('.list-collection-coupon').slick('unslick');
    $('.list-collection-coupon').slick(options);
  });

  // $('.js-shop-list').slick({
  //   slidesToShow: 3,
  //   slidesToScroll: 3,
  //   arrows: true,
  //   dots: false,
  //   infinite: false,
  //   responsive: [
  //     {
  //       breakpoint: 768,
  //       settings: {
  //         slidesToShow: 1,
  //         slidesToScroll: 1,
  //         arrows: false,
  //         // dots: true,
  //       }
  //     }
  //   ]
  //   // variableWidth: true
  // });

</script>



</html>