<!DOCTYPE html>
<html lang="vi">
    <head>
	<link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>   
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="google-site-verification" content="Cxcxfz0Wn9LQGLgWXQ0cRQu61dZGZ-LFyups_lTM4O8" />
	<meta name="revisit-after" content="1 days"/>
	<meta name="description" content="<?php echo $descrSiteGlobal ? $descrSiteGlobal : settingDescr; ?>"/>
	<meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta property="og:url" content="<?php echo $ogurl; ?>"/>
	<meta property="og:type" content="<?php echo $ogtype; ?>"/>
	<meta property="og:title" content="<?php echo $ogtitle ? $ogtitle : settingTitle; ?>"/>
	<meta property="og:description" content="<?php echo $ogdescription ? $ogdescription : settingDescr; ?>"/>
	<meta property="og:image" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : site_url('templates/home/images/logoshare.png'); ?>"/>
	<meta property="og:image:alt" content="<?php echo $ogtitle ?>"/>
	<meta property="fb:app_id" content="<?php echo app_id ?>" />	
	<?php if ($isMobile == 1) { ?> 
    	<meta property="al:android:url" content="sharesample://store/apps/details?id=com.azibai.android">
    	<meta property="al:android:package" content="com.azibai.android">
    	<meta property="al:android:app_name" content="Azibai">	
    	<meta property="al:ios:url" content="https://azibai.com" />
    	<meta property="al:ios:app_name" content="azibai" />
    	<meta property="al:ios:app_store_id" content="1284773842" />
    	<meta property="al:web:should_f" allback content="false"/>
	<?php } ?>
	<title>
	    <?php
	    if (isset($titleSiteGlobal)) {
		echo $this->lang->line('title_detail_header') . $titleSiteGlobal;
	    } else {
		echo settingTitle;
	    }
	    ?> 
	</title>
	<?php echo (isset($css)) ? $css : ''; ?>

	<script src="/templates/home/js/jquery.min.js"></script>
    </head>
    <body>
	<div id="all">
		<?php 
		$arrUrl = explode('.', $_SERVER['HTTP_HOST']);
	        if (count($arrUrl) === 3) {
	            $linkreturn = '/shop/product';
	        } else {
	            $linkreturn = '/shop/products';
	        }
		?>
	    <div id="header" class="header_fixed">		   

		<?php if ($isMobile == 0) { ?>
    		<div class="header-news" class="hidden-xs" style="padding:10px;">
    		    <div class="row">
    			<div class="col-lg-2 col-md-3 col-sm-3 text-center">
    			    <a href="<?php echo base_url() ?>">
    				<img style="max-height: 34px; margin: auto;" class="img-responsive" src="/images/logo-azibai-white.png" alt="logo-azibai"/>
    			    </a>
    			</div>
    			<div class="col-lg-5 col-md-4 col-sm-4">
				
    			</div>
    			<div class="col-lg-5 col-md-5 col-sm-5">		    
			    
    			    <ul class="menu-top-right pull-right">
    				<li class="">
    				    <a title="Mua sắm" href="<?php echo $linkreturn; ?>" title="Mua sắm" >
    					<i class="azicon icon-store white"></i>    					     
    				    </a>
    				</li>    				
    				<li>
    				    <a  title="Xem giỏ hàng" href="/checkout">
    					<i class="azicon icon-cart white"></i>
    					<span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
    				    </a>
    				</li>
    				<li>
    				    <a  title="Đăng nhập" href="<?php echo site_url('login') ?>">
    					<i class="azicon icon-login white"></i>
    				    </a>
    				</li>
    			    </ul>
    			</div>
    		    </div>   
    		</div>
		<?php } else { ?>
    		<div class="visible-xs">		
    		    <ul class="menu-azinet-top"> 
    			<li class="azibaihome">
    			    <a href="<?php echo getAliasDomain() ?>">
    				<i class="azicon icon-azibai"></i>
    			    </a>
    			</li>			
    			<li>
    			    <a href="<?php echo getAliasDomain($linkreturn); ?>">
    				<i class="azicon icon-store"></i>
    			    </a>
    			</li>    			
			<li>
    			    <a href="<?php echo getAliasDomain('checkout'); ?>">
    				<i class="azicon icon-cart"></i>
    			    </a>
    			</li>			
			<li class="dropdown"> 
			    <a id="dropdown_3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<i class="azicon icon-bars"></i>
			    </a>
			    <div class="dropdown-menu" style="width:100%; margin: 0; overflow: auto;">
				<ul class="nav nav-child-1">
				    <li>
					<a href="<?php echo getAliasDomain('register'); ?>">
					    <i class="azicon icon-user-key"></i> &nbsp; Đăng ký thành viên				
					</a>
				    </li>
				    <li>
					<a href="<?php echo getAliasDomain('login'); ?>">
					    <i class="azicon icon-login"></i> &nbsp; Đăng nhập				
					</a>
				    </li>
				</ul>
			    </div>
			</li>
		    </ul>	
		</div>
	    <?php } ?>
	</div>
	<a id="toTop" href="#"><i class="fa fa-chevron-up fa-fw"></i></a>