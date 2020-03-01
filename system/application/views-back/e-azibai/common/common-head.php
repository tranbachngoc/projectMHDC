<meta charset="UTF-8">
<title>Azibai</title>
<meta name="description" content="<?php echo isset($descrSiteGlobal) ? $descrSiteGlobal : settingDescr; ?>"/>
<meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
<meta name="robots" content="INDEX,FOLLOW">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=1" id="viewport">
<meta name="og_url" property="og:url" content="<?php echo (isset($ogurl) ? $ogurl : ''); ?>"/>
<meta name="og_type" property="og:type" content="<?php echo (isset($ogtype)) ? $ogtype : ''; ?>"/>
<meta name="og_title" property="og:title" content="<?php echo (isset($ogtitle)) ? $ogtitle : settingTitle; ?>"/>
<meta name="og_description" property="og:description" content="<?php echo (isset($ogdescription)) ? $ogdescription : settingDescr; ?>"/>
<meta name="og_image" property="og:image" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>"/>
<meta name="og_image_alt" property="og:image:alt" content="<?php echo (isset($ogtitle)) ? $ogtitle : '' ?>"/>
<meta property="og:image:secure_url" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : ((getAliasDomain() != '') ? getAliasDomain().'templates/home/images/logoshare.png' : site_url('templates/home/images/logoshare.png')); ?>" /> 
<meta property="og:image:width" content="500" /> 
<meta property="og:image:height" content="500" />
<meta name="fb_app_id" property="fb:app_id" content="<?php echo app_id ?>" /> 
<meta name="HandheldFriendly" content="True">
<meta http-equiv="X-UA-Compatible" , content="IE=edge">
<!--[if IE]><meta http-equiv="cleartype" content="on"><![endif]-->

<!-- CSS -->
<link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap.css">
<link href="/templates/home/styles/css/reset.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/base.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/top.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/slick.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/slick-theme.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/sanazibai.css" rel="stylesheet" type="text/css">
<!-- <link href="https://fonts.googleapis.com/css?family=KoHo:400,500,700" rel="stylesheet"> -->
<link rel="stylesheet" href="/templates/home/css/font-awesome.css">
<!-- JS -->
<script src="/templates/home/js/jquery.min.js"></script>
<script src="/templates/home/boostrap/js/popper.min.js"></script>
<script src="/templates/home/boostrap/js/bootstrap.js"></script>

<script src="/templates/home/styles/js/countdown.js"></script>

<script>
  var urlFile = siteUrl = '<?=azibai_url()?>/';
</script>