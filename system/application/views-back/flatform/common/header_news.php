<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $descrSiteGlobal; ?>" />
        <meta name="keywords" content="<?php echo $keywordsSiteGlobal; ?>" />
        <meta property="og:url" content="<?php echo $ogurl; ?>" />
        <meta property="og:type" content="<?php echo $ogtype; ?>" />
        <meta property="og:title" content="<?php echo $ogtitle; ?>" />
        <meta property="og:description" content="<?php echo $ogdescription; ?>" />
        <meta property="og:image" content="<?php echo $ogimage; ?>" />
        <title><?php echo $this->lang->line('title_detail_global'); ?><?php echo $siteGlobal->sho_name; ?></title>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="/templates/home/css/font-awesome.min.css" />        
        <link type="text/css" rel="stylesheet" href="/templates/shop/style-news.css" />            
        <link type="text/css" rel="stylesheet" href="/templates/home/owlcarousel/owl.carousel.min.css" />
        <link type="text/css" rel="stylesheet" href="/templates/home/lightgallery/dist/css/lightgallery.css" />
        <link type="text/css" rel="stylesheet" href="/templates/engine1/style.css" /> 
	<link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/> 
        <script  src="/templates/home/js/jquery.min.js"></script>
        <script  src="/templates/home/js/jquery-migrate-1.2.1.js"></script>
        <script  src="/templates/home/js/bootstrap.min.js"></script>  
        <script  src="/templates/home/js/jquery.validate.js"></script>
        <script  src="/templates/home/owlcarousel/owl.carousel.js"></script>            
        <script  src="/templates/home/lightgallery/dist/js/lightgallery.js"></script>
        <script  src="/templates/home/lightgallery/js/lg-video.js"></script>                   
        <script  src="/templates/home/js/clipboard.min.js"></script>
        <script  src="/templates/home/js/jquery-scrolltofixed-min.js"></script>
        <script async src="/templates/engine1/wowslider.js"></script>
        <script async src="/templates/engine1/script.js"></script>      
        <script  src="/templates/home/js/jquery.touchSwipe.min.js"></script>
        <script  src="/templates/home/js/newsfeeds.js"></script>         
	<script src="/templates/home/lazy/jquery.lazy.min.js"></script>
	<script  src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
	<script  src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>
    </head>    
    <body>
	<?php if ($isMobile == 0) { ?>
		<style>
                    ul.menu-top-right {margin:0}
                    ul.menu-top-right li { float: left; list-style: none; margin:4px;position: relative; }
                    ul.menu-top-right li a { display:block; padding:4px; }
                    ul.menu-top-right ul > li { float: none;  margin:0px; padding:0 4px; }
                    ul.menu-top-right .cartNum { position: absolute; top: 0; right: -5px; font-size: 11px; color: white; background: red; width: 16px; text-align: center; border-radius: 10px; font-weight: bold; }
                </style>
    	<div id="header_news" class="header_fixed hidden-xs" style="padding:10px;">               
    	    
    		<div class="row">
    		    <div class="col-lg-2 col-md-3 col-sm-3 text-center">
			<?php 
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			?>
    			<a class="logo" href="<?php echo getAliasDomain(); ?>">
    			    <img style="max-height: 34px; margin: auto;" class="img-responsive" src="/images/logo-azibai-white.png" alt="logo-azibai">
    			</a>
    		    </div>
    		    <div class="col-lg-5 col-md-4 col-sm-4">
    			<form id="formsearch_home" name="formsearch_home" class="form-horizontal" action="/flatform/news/search" method="post">
    			    <div class="input-group">
    				<input name="keyword" id="keyword1" class="form-control" type="text" value="" placeholder="Tìm kiếm tin tức">
    				<div class="input-group-btn">
    				    <button type="submit" class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
    				</div>
    			    </div>
    			</form>
    		    </div>
    		    <div class="col-lg-5 col-md-5 col-sm-5">
    			<div class="pull-left">
				<?php
				if (isset($currentuser) && $currentuser) {
				    if ($currentuser->avatar != '') {
					$avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
				    } else {
					$avatar = site_url('media/images/avatar/default-avatar.png');
				    }
				    ?>
				    <div class="pull-left">					
					<img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:34px; height:34px">  
					<?php echo $this->session->userdata('sessionUsername'); ?>					
				    </div>
                                <?php } else { ?>
                                    <div class="pull-left">                                        					
					<img class="img-circle" src="<?php echo site_url('media/images/avatar/default-avatar.png'); ?>" alt="account" style="width:34px; height:34px">  
					khách					
				    </div>
                                <?php } ?>
    			</div>
    			<ul class="menu-top-right navbar-right">
    			    <li class="">
    				<a href="/flatform/product" 
    				   data-toggle="tooltip" data-placement="bottom" title="Trang sản phẩm">
    				    <img src="/templates/home/icons/white/icon-store.png" style="height:20px" alt="Sản phẩm">
    				</a>
    			    </li>

    			    <li>
    				<a  href="/checkout" title="Xem giỏ hàng"
    				    data-toggle="tooltip" data-placement="bottom" title="Xem giỏ hàng">
    				    <img src="/templates/home/icons/white/icon-cart.png" style="height:20px" alt="Giỏ hàng">
    				    <span class="cartNum"><?php echo $azitab['cart_num'] ?></span>
    				</a>
    			    </li>
				<?php if ((int) $this->session->userdata('sessionUser') > 0) { ?>
				    <li class="dropdown">
					<a id="dLabel" data-target="#" href="<?php echo site_url(); ?>" data-toggle="dropdown"
					   role="button" aria-haspopup="true" aria-expanded="false">
					    <img src="<?php echo site_url('templates/home/icons/white/icon-bars.png'); ?>"
						 style="height:20px" alt="icon-bars"/>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
					    <li>
						<a href="//<?php echo domain_site . '/account/edit'; ?>"
						   data-toggle="tooltip" data-placement="bottom" title="Tài khoản">
						    <img src="<?php echo site_url('templates/home/icons/black/icon-user.png'); ?>"
							 style="height:20px" alt="icon-user"/>&nbsp; Thông tin cá nhân
						</a>
					    </li>

					    <li>
						<a href="//<?php echo domain_site . '/account'; ?>"
						   data-toggle="tooltip" data-placement="bottom" title="Quản trị">
						    <img src="<?php echo site_url('templates/home/icons/black/icon-store.png'); ?>"
							 style="height:20px" alt="icon-store"/>&nbsp; Quản trị
						</a>
					    </li>                                            
					    <li>
						<form action="/logout" method="post" class="" >
						    <button type="submit" class="btn-logout" style="" title="Đăng xuất">
							Đăng xuất
						    </button>
						    <input type="hidden" name="grt" value="flatform/news">
						</form>
						<?php //echo site_url('logout') ?>
					    </li>
					</ul>
				    </li>
				<?php } else { ?>
				    <li>
<!--					<form action="/login" method="post" class="" >
					    <button type="submit" class="btn-login" style="" title="Đăng nhập">
						
					    </button>
					    <input type="hidden" name="linkreturn" value="flatform/news">
					</form>-->
<!--					<a href="<?php echo site_url('flatform/login') ?>"
					   data-toggle="tooltip" data-placement="bottom" title="Đăng nhập"
					   title="Đăng nhập">-->
					<a class="hint--left" data-hint="Đăng nhập" href="#myLogin" data-toggle="modal" title="Đăng nhập">
					    <img src="<?php echo site_url('templates/home/icons/white/icon-login.png'); ?>"
						 style="height:20px" alt="icon-login"/>
					</a>
				    </li>
				<?php } ?>



    			</ul>
    		    </div>   
    		</div>   
    	       
    	</div>    		   
	<?php } else { ?> 
	    <?php $this->load->view('flatform/common/menu-mobile'); ?>
	<?php } ?>			
	<?php if ( !$this->session->userdata('sessionUser') ) { ?>
	    <?php $this->load->view('flatform/common/login-model'); ?>
	<?php } ?>        