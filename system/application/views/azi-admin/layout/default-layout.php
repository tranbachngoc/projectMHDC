<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Azibai</title>
    <link rel="shortcut icon" href="/templates/home/styles/images/favicon.png" type="image/x-icon">
    <meta name="description" content="<?=SEO_DESCRIPTION?>">
    <meta name="Keywords" content="<?=SEO_KEYWORDS?>">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="HandheldFriendly" content="True">
    <meta http-equiv="X-UA-Compatible", content="IE=edge">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->
    
    <!-- CSS -->
    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
    <link href="/templates/home/styles/css/slick.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/slick-theme.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/admin.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/templates/home/css/font-awesome.min.css">
    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">

    <!-- JS -->    
    <script src="/templates/home/js/jquery.min.js"></script>
    <script src="/templates/home/boostrap/js/popper.min.js"></script>
    <script type="text/javascript" src="/templates/home/boostrap/js/bootstrap.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="/templates/home/boostrap/js/bootstrap-datetimepicker.min.js"></script>
    
    <link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap-datepicker.css">
    <script src="/templates/home/boostrap/js/bootstrap-datepicker.js"></script>

    <script src="/templates/home/styles/js/slick.js"></script>
    <script src="/templates/home/styles/js/slick-slider.js"></script>
  </head>
<body>
  <script type="text/javascript">
    var siteUrl = '<?=base_url()?>';
    var SERVER_OPTIMIZE_URL = '<?php echo SERVER_OPTIMIZE_URL ?>';
    var server_load = '<?php echo $_SERVER['SERVER_ADDR'] ; ?>';
    var PROTOCOL = '<?php echo get_server_protocol() ?>';
    default_image_error_path = '<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>';
    var api_common_audio_post = '<?php  echo $api_common_audio_post ? $api_common_audio_post : '' ?>';
    var api_common_video_post = '<?php echo $api_common_video_post ? $api_common_video_post : '' ?>';
    var token = '<?php echo $token ? $token : '' ?>';
  </script>
  <div class="wrapper">
    <!-- header -->
    <?php $this->load->view('azi-admin/layout/header'); ?>
    <?php $this->load->view('azi-admin/entertainment-link/element/template-item')?>
    <main class="administrator" id="main-notification">
      <!-- left menu -->
      <?php $this->load->view('azi-admin/layout/left-menu'); ?>

      <!-- content -->
      <?php echo @$layout_extend; ?>
    </main>
  </div>
  
  <?php $this->load->view('home/common/modal-mess'); ?>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/js/azi-notification.js"></script>
</body>
</html>