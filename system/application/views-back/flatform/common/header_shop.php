<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $sitedesc ?>">
        <meta name="keyword" content="<?php echo $sitekeyword ?>">
        <meta name="author" content="azibai">	
        <meta property="fb:app_id" content="<?php echo app_id ?>" />
        <meta property="og:type" content="<?php echo $ogtype ?>"/>
        <meta property="og:url" content="<?php echo $ogurl ?>"/>
        <meta property="og:title" content="<?php echo $ogtitle ?>"/>
        <meta property="og:image" content="<?php echo $ogimage ?>"/>
        <meta property="og:description" content="<?php echo $ogdescription ?>"/>
        <meta property="og:image:alt" content="<?php echo $ogtitle ?>"/>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>
        <title><?php echo $head_footer->fl_name ?></title>
        <!-- Bootstrap core CSS -->
        <link type="text/css" rel="stylesheet" href="/templates/home/css/bootstrap.css"/>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/newsfeed.css">
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="https://getbootstrap.com/docs/3.3/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet"/>
        <link href="/templates/home/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
        <link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />
        <link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
        <!-- Custom styles for this template -->
        <link href="/templates/flatform/style.css" rel="stylesheet" type="text/css"/>
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/templates/home/js/jquery.min.js"></script>
        <script src="/templates/home/js/bootstrap.min.js"></script>
	<!--<script src="/templates/engine1/swfobject.js"></script>
	<script src="/templates/engine1/wowslider.js"></script>-->
        <script src="/templates/home/lightgallery/dist/js/lightgallery.js"></script>
        <script src="/templates/home/js/jquery-scrolltofixed-min.js"></script>
        <script src="/templates/home/js/owl.carousel.js"></script><script language="javascript">
            var siteUrl = '/';
        </script>
        <script language="javascript" src="/templates/flatform/js/general.js"></script>
    </head>

    <body>
	<?php if ($isMobile == 0) { ?>
    	<div id="header_shop"> 
	    <div style="height:95px;"></div>
    	    <nav class="navbar navbar-fixed-top" style="padding: 20px 0; background: #f7f8f9;border-color: lightgray; ">
    		<div class="container">
    		    <div class="navbar-header">
    			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
    			    <span class="sr-only">Toggle navigation</span>
    			    <span class="icon-bar"></span>
    			    <span class="icon-bar"></span>
    			    <span class="icon-bar"></span>
    			</button>
    			<a class="navbar-brand" href="#" style="width: 200px; height:54px; background: url('<?php echo DOMAIN_CLOUDSERVER . '/media/images/flatform/' . $head_footer->fl_dir_logo . '/' . $head_footer->fl_logo ?>') no-repeat center center / auto 100%"></a>
    		    </div>
    		    <div id="navbar" class="navbar-collapse collapse">
    			<ul class="nav navbar-nav">
    			    <li <?php if ($menuactive == 'about') echo 'class="active"'; ?>><a href="/flatform/about">Giới thiệu</a></li>    
                            <?php 
                            $ss = (int)$this->session->userdata('sessionUser');
                            if($ss && $ss > 0){ 
                            ?>
                            <li <?php if ($menuactive == 'product') echo 'class="active"'; ?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				    Sản phẩm <i class="fa fa-angle-down fa-fw"></i>
				</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/flatform/product">Danh sách sản phẩm</a></li>
                                    <li><a href="/flatform/favorite_pro">Sản phẩm đã yêu thích</a></li>
                                </ul>
                            </li>
                            <li <?php if ($menuactive == 'coupon') echo 'class="active"'; ?>>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				Coupon <i class="fa fa-angle-down fa-fw"></i>
				</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/flatform/coupon">Danh sách coupon</a></li>
                                    <li><a href="/flatform/favorite_cou">Coupon đã yêu thích</a></li>
                                </ul>
                            </li>
                            <?php } else{ ?>                                                        
			    <li <?php if ($menuactive == 'product') echo 'class="active"'; ?>><a href="/flatform/product">Sản phẩm</a></li>
			    <li <?php if ($menuactive == 'coupon') echo 'class="active"'; ?>><a href="/flatform/coupon">Coupon</a></li>
                            <?php
                            }
                            ?>
    			    <li <?php if ($menuactive == 'news') echo 'class="active"'; ?>><a href="/flatform/news">Tin tức</a></li>
    			    <li <?php if ($menuactive == 'contact') echo 'class="active"'; ?>><a href="/flatform/contact">Liên hệ</a></li>
    			    <li><a href="//<?php echo domain_site?>">Azibai</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
				<li <?php if ($menuactive == 'cart') echo 'class="active"'; ?>><a href="/checkout">Giỏ hàng (<span class="ordernum" style="color:#f00"><?php echo $azitab['cart_num'] ?></span>)</a></li> 
				<?php if ($this->session->userdata('sessionUser') != "") { ?>
				    <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					    <i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('sessionUsername') ?>
					</a>
					<ul class="dropdown-menu">
					    <li><a href="<?php echo '//' . domain_site . '/account' ?>"><i class="fa fa-dashboard fa-fw"></i> Quản trị</a></li>       
					    <!--<li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a></li>-->
					    <form action="/logout" method="post" class="">
						    <button type="submit" class="btn btn-link" style="" title="Đăng xuất">
							<i class="fa fa-sign-out fa-fw"></i> Đăng xuất
						    </button>
						    <input name="grt" value="flatform/product" type="hidden">
						</form>
					</ul>
				    </li>    
				<?php } else { ?>
				    <li>
					<a class="hint--left" data-hint="Đăng nhập" href="#myLogin" data-toggle="modal" title="Đăng nhập">
					Đăng nhập</a>
				    </li>
				<?php } ?>
    			</ul>
    		    </div>
    		</div>
    	    </nav>
    	</div>
	    <?php if ($menuactive != 'contact') { ?>
		<div class="shop_banner text-center">
		    <div class="fix3by1">
			<div class="c" style="background: #fff url('<?php echo DOMAIN_CLOUDSERVER . 'media/images/flatform/' . $head_footer->fl_dir_banner . '/' . $head_footer->fl_banner ?>') no-repeat center / cover"></div>
		    </div>
		</div>
	    <?php } ?>
	<?php } else { ?> 
	<?php $this->load->view('flatform/common/menu-mobile'); ?>
    	<div class="shop_banner text-center">
    	    <div class="fix16by9">
    		<div class="c" style="background: #fff url('<?php echo DOMAIN_CLOUDSERVER . 'media/images/flatform/' . $head_footer->fl_dir_banner . '/' . $head_footer->fl_banner ?>') no-repeat center / cover"></div>
    	    </div>
    	</div>
	<?php } ?>
			
	<?php if ( !$this->session->userdata('sessionUser') ) { ?>
	    <?php $this->load->view('flatform/common/login-model'); ?>
	<?php } ?>  
