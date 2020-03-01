<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="<?php echo $descrSiteGlobal ? $descrSiteGlobal : settingDescr; ?>"/>
        <meta name="keywords" content="<?php echo $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
        <meta property="og:url" content="<?php echo $ogurl; ?>"/>
        <meta property="og:type" content="<?php echo $ogtype; ?>"/>
        <meta property="og:title" content="<?php echo $ogtitle; ?>"/>
        <meta property="og:description" content="<?php echo $ogdescription ? $ogdescription : settingDescr; ?>" />
        <meta property="og:image" content="<?php echo $ogimage ? $ogimage : '/templates/home/images/logoshare.jpg'; ?>" /> 
        <title><?php echo $pagetitle ?></title>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/bootstrap.css"/> 
        <link type="text/css" rel="stylesheet" href="/templates/home/css/font-awesome.min.css"/>
        <link type="text/css" rel="stylesheet" href="/templates/group/css/group-shop.css"/>        
        <link type="text/css" rel="stylesheet" href="/templates/group/css/owl.carousel.min.css"/>        
        <link type="text/css" rel="stylesheet" href="/templates/group/css/owl.theme.default.min.css"/>        
        <link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/>
        
    </head>

    <body>
        <div id="all">
        <?php if($isMobile == 0) {?>    
	    <header id="header" class="site-header">
		<div class="header-gtop">
		    <nav class="navbar navbar-default navbar-static-top">		     
			<div class="container">  
			    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-bar-menu" aria-expanded="false">
				  <span class="sr-only">Toggle navigation</span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				  <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand visible-xs" href="#">Menu</a>			    
			    </div>		    
			    <div class="collapse navbar-collapse" id="top-bar-menu">                  
				<ul class="nav navbar-nav">
				    <li><a href="tel:<?php echo $siteGlobal->grt_mobile ?>"><i class="icon fa fa-phone fa-fw"></i> <?php echo $siteGlobal->grt_mobile ?></a></li>
				    <li><a href="mailto:<?php echo $siteGlobal->grt_email ?>"><i class="icon fa fa-envelope-o fa-fw"></i> <?php echo $siteGlobal->grt_email ?></a></li>

				    <li><a href="#download"><i class="icon fa fa-download fa-fw"></i>  Tải app azibai</a></li>
				    <li><a href="#customer"><i class="icon fa fa-support fa-fw"></i>  Chăm sóc khách hàng</a></li>			
				    <li class="dropdown">
					<a href="#checkorder" data-toggle="modal" data-target="#checkorderModal">
					    <i class="icon fa fa-check-square-o fa-fw"></i> Kiểm tra đơn hàng
					</a>				    			    
				    </li>
				</ul>

				<?php if ($this->session->userdata('sessionUser')) { ?>			    
				    <form action="/logout" method="post" class="navbar-form navbar-right" >
					Chào  <a href="/grtshop/#customer-care"><?php echo $this->session->userdata('sessionUsername') ?></a> &nbsp;
					<button type="submit" class="btn btn-default" style="" title="Đăng xuất">
					    Đăng xuất
					</button>
					<input type="hidden" name="grt" value="grtnews">
				    </form>
				<?php } else { ?>
				    <ul class="nav navbar-nav navbar-right">				    
					<li><a href="#myLogin" data-toggle="modal"><i class="icon fa fa-sign-in fa-fw"></i> Đăng nhập</a></li>
				    </ul>
				<?php } ?>
			    </div>
			</div>
		    </nav>
		</div>
		<div class="header-content">
		    <div class="container">
			<div class="row">
			    <div class="col-md-4 col-sm-12 col-xs-12 col-ts-12 nav-left" style="margin:20px 0;">
				<div class="logo block-top-1">
				    <a href="/grtshop">
					<img height="76" alt="<?php echo $siteGlobal->grt_logo ?>" src="<?php echo DOMAIN_CLOUDSERVER.'media/group/logos/'.$siteGlobal->grt_dir_logo.'/'.$siteGlobal->grt_logo ?>"/>
				    </a>
				</div>
			    </div>
			    <div class="col-md-5 col-sm-8 col-xs-12">

				<form method="post" action="/grtshop/search" class="block-top-2">
				    <div class="block-content">
					<div class="input-group"> 
					    <input type="text" value="<?php echo $keyword ?>" name="keyword" id="searchproduct" class="form-control keyword" placeholder="Từ khóa tìm kiếm">
					    <span class="input-group-btn">
						<button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
					    </span>                                              
					</div> 
				    </div>
				</form>			   
			    </div>
			    <div class="col-md-3 col-sm-4 col-xs-12">

				<div class="block-top-3">
				    <div class="btn-group">
                                        <a href="#" class="btn btn-default link-wishlist favorite" onclick="checklogin('<?php echo $this->session->userdata('sessionUser'); ?>')">
					    <i class="fa fa-heart fa-fw"></i> <span class="hidden">Yêu thích</span> (<span class="favorites"><?php echo $total_favorite ?></span>)
					</a>
					<a href="/checkout" class="btn btn-default link-shopcart">                                    
					    <i class="fa fa-shopping-cart fa-fw"></i> <span class="hidden">Giỏ hàng</span> (<span class="cartNum"><?php echo $azitab['cart_num']; ?></span>)
					</a>
				    </div>    
				</div>    

			    </div>
			</div>                    
		    </div>
		</div>
		<div class="header-menu">
		    <nav class="navbar navbar-inverse navbar-static-top">
			<div class="container">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand visible-xs" href="#">Menu</a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav">
				    <li class="<?php echo $menuSelected == 'grtshop' ? 'active' : '' ?>"><a href="/grtshop"><i class="fa fa-home fa-fw"></i> Cửa hàng</a></li>
				    <li class="<?php echo $menuSelected == 'introduction' ? 'active' : '' ?>"><a href="/grtshop/introduction"><i class="fa fa-info-circle fa-fw"></i> Giới thiệu</a></li>
                                    <li class="dropdown menu_" style="position: static;" onclick="show_menubox('.danhmuc_pro')">
                                        <a href="#product" onclick="load_danhmuc(0,'<?php echo $_lshop?>','<?php echo $_lpro?>')">
                                             <!-- class="dropdown-toggle"data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"-->
					    <i class="fa fa-cubes fa-fw"></i> Sản phẩm <span class="caret"></span>
					</a>
					<div class="dropdown-menu mega-dropdown-menu danhmuc_pro">
					    <div style="white-space: nowrap; overflow: auto; overflow-y: hidden;" id="scrollbar">  
                                                <ul style="display: inline-block; vertical-align: top;" id="cap1" class="menu_0">
							
						</ul>
					    </div>
					</div>
				    </li>
				    <li class="dropdown menu_" style="position: static;" onclick="show_menubox('.danhmuc_coupon')">
					<a href="#coupon" onclick="load_danhmuc(2,'<?php echo $_lshop?>','<?php echo $_lpro?>')">
                                             <!-- class="dropdown-toggle"data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"-->
					    <i class="fa fa-tags fa-fw"></i> Coupon <span class="caret"></span>
					</a>
					<div class="dropdown-menu mega-dropdown-menu danhmuc_coupon">
					    <div style="white-space: nowrap; overflow: auto; overflow-y: hidden;" id="scrollbar">
                                                <ul id="cap1" class="menu_0">

                                                </ul>
					    </div>
					</div>
				    </li>
				    <li><a title="Tin tức" href="/grtnews"><i class="fa fa-newspaper-o fa-fw"></i> Tin tức</a></li>
				    <li><a title="Liên hệ" href="/grtshop/contact"><i class="icon fa fa-envelope-o fa-fw"></i> Liên hệ</a></li>                    
				</ul>

				<ul class="nav navbar-nav navbar-right">
				    <li><a href="#"><i class="fa fa-arrow-right fa-fw"></i> azibai</a></li>
				    <!--<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tải App <span class="caret"></span></a>
					<div class="dropdown-menu">
					    <div class="text-center text-uppercase">Tải ứng dụng ngay</div>
					    <div><img src="/templates/group/images/tai-ung-dung.jpg"/></div>
					</div>
				    </li>-->
				</ul>
			    </div><!-- /.navbar-collapse -->
			</div><!-- /.container -->
		    </nav>            
		</div>
	    </header>
	<?php } else { ?> 
	    
	    <ul class="menu-mobile dropdown visible-xs">
                <li><a href="<?php echo $mainURL; ?>"><img src="/templates/home/icons/black/icon-azibai.png" style="height:20px"/></a></li>
                <li>
                    <a href="/grtnews/">
                        <img src="/templates/home/icons/black/icon-newspaper.png" alt="">                                           
                    </a>
                </li>
                <li>
		    <a href="/checkout">
                        <img src="/templates/home/icons/black/icon-cart.png" style="height:20px"/>                                            
                        <span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
                    </a>
                </li>
		<li>
                    <a href="#" class="favorite" onclick="checklogin('<?php echo $this->session->userdata('sessionUser'); ?>');">
                        <img src="/templates/home/icons/black/icon-favorite.png" style="height:20px"/>                                            
                        <span class="favorites"><?php echo $total_favorite ?></span>
                    </a>
                </li>
                <li role="presentation" class="show_menubar1">
                    <a href="#" class="dropdown-toggle" id="drop1" onclick="show_menubox('drop1')"> 
                        <img src="/templates/home/icons/black/icon-search.png" style="height:20px"/>
                    </a>
		    <div class="dropdown-menu drop1" aria-labelledby="drop1" style="left: 0; right: 0;">
			<ul class="nav">
			    <li style="padding: 10px 15px;">
				<form method="post" action="/grtshop/search" class="block-top-2">				
				    <div class="input-group"> 
					<input type="text" value="<?php echo $keyword ?>" name="keyword" id="searchproduct" class="form-control keyword" placeholder="Từ khóa tìm kiếm">
					<span class="input-group-btn">
					    <button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
					</span>                                              
				    </div> 				
				</form>
			    </li>
			</ul>
		    </div>
                </li>
                <li role="presentation" class="show_menubar2">
                    <a href="#on" class="dropdown-toggle" id="drop2" onclick="show_menubox('drop2')"> 
                         <!--data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"-->
                        <img src="/templates/home/icons/black/icon-bars.png" style="height:20px"/>
                    </a>
		    <div class="dropdown-menu drop2" aria-labelledby="drop2" style="left: 0; right: 0;">
			<ul class="nav">
			    <?php if ($this->session->userdata('sessionUser')) { ?>
			    <li>
				<a href="<?php echo $mainURL . 'account' ?>"> 
				    <?php if ($this->session->userdata('sessionAvatar')) { ?>
					<img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER.'media/images/avatar/' . $this->session->userdata('sessionAvatar'); ?>"  style="width:50px; height:50px;"/>
				    <?php } else { ?>
					<img class="img-circle" src="<?php echo site_url('media/images/avatar/default-avatar.png'); ?>"  style="width:50px; height:50px;"/>
				    <?php } ?>    
				    &nbsp; <?php echo $this->session->userdata('sessionUsername'); ?>
				</a>
			    </li>			    
			    <?php } else { ?>			    
			    <li>
				<a href="#myLogin" data-toggle="modal">
				    <img src="/templates/home/icons/black/icon-login.png" style="height:20px"/> &nbsp; Đăng nhập
				</a>
			    </li>
			    <?php } ?>
			    <li><a href="#download"><img src="/templates/home/icons/black/downloads.png" style="height:20px"/> &nbsp; Tải app azibai</a></li>
			    <li><a href="#customer"><img src="/templates/home/icons/black/icon-support.png" style="height:20px"/> &nbsp; Chăm sóc khách hàng</a></li>			
			    <li>
				<a href="#checkorder" data-toggle="modal" data-target="#checkorderModal">
				    <img src="/templates/home/icons/black/icon-check.png" style="height:20px"/> &nbsp; Kiểm tra đơn hàng 
				</a> 
			    </li>
			    <li><a href="/grtshop/introduction/"><img src="/templates/home/icons/black/bookmarks.png" style="height:20px"/> &nbsp; Giới thiệu</a></li>
			    <li><a href="/grtshop/"><img src="/templates/home/icons/black/icon-store.png" style="height:20px"/> &nbsp; Cửa hàng</a></li>

			    <li class="dropdown menu_" style="" onclick="show_menubox('danhmuc_pro')">
                                <!--<a href="/grtshop/product/"><img src="/templates/home/icons/black/cubes.png" style="height:20px"/> &nbsp; Sản phẩm</a>-->
                                <a href="#product" onclick="load_danhmuc(0,'<?php echo $_lshop?>','<?php echo $_lpro?>')">
                                    <img src="/templates/home/icons/black/cubes.png" style="height:20px"/> &nbsp; Sản phẩm <span class="caret"></span>
                               </a>
                                <div class="mega-dropdown-menu danhmuc_pro" style="display:none">
                                   <div style="white-space: nowrap; overflow: auto; overflow-y: hidden;" id="scrollbar">  
                                       <ul style="display: inline-block; vertical-align: top;" id="cap1" class="menu_0">

                                       </ul>
                                   </div>
                               </div>
                            </li>
			    <li class="dropdown menu_" style="position: static;" onclick="show_menubox('danhmuc_coupon')">
<!--                                <a href="/grtshop/coupon/">
                                    <img src="/templates/home/icons/black/icon-coupon.png" style="height:20px"/> &nbsp; Coupon
                                </a>-->
                                <a href="#product" onclick="load_danhmuc(2,'<?php echo $_lshop?>','<?php echo $_lpro?>')">
                                    <img src="/templates/home/icons/black/cubes.png" style="height:20px"/> &nbsp; Coupon <span class="caret"></span>
                               </a>
                                <div class="mega-dropdown-menu danhmuc_coupon" style="display:none">
                                   <div style="white-space: nowrap; overflow: auto; overflow-y: hidden;" id="scrollbar">  
                                       <ul style="display: inline-block; vertical-align: top;" id="cap1" class="menu_0">

                                       </ul>
                                   </div>
                               </div>
                            </li>

			    <li><a href="/grtshop/contact"><img src="/templates/home/icons/black/icon-email.png" style="height:20px"/> &nbsp; Liên hệ</a></li>                                         
			    <?php if ($this->session->userdata('sessionUser')) { ?>
			    <li>
				<form action="/logout" method="post" style="margin-left:-2px;">
				    <button type="submit" class="btn btn-link btn-block" style="color: #333;text-decoration: none; text-align: left; padding: 6px 15px;">
					<img src="/templates/home/icons/black/icon-logout.png" style="height:20px"/> &nbsp; Đăng xuất 
				    </button>
				    <input type="hidden" name="grt" value="grtshop">
				</form>
			    </li>
			    <?php } ?>
			</ul>
		    </div>
                </li>

            </ul>
	     
	<div class="group-top">
	    <div class="group-banner">
		<div class="fix16by9" style="
		     background: url(<?php echo DOMAIN_CLOUDSERVER.'media/group/banners/'.$siteGlobal->grt_dir_banner.'/'.$siteGlobal->grt_banner ?>) no-repeat center center; 
		    -webkit-background-size: cover;
		    -moz-background-size: cover;
		    -o-background-size: cover;
		    background-size: cover;
		    ">
		</div>
	    </div>
	    <div class="group-logo">
		<div class="img-circle">
		    <img src="<?php echo DOMAIN_CLOUDSERVER.'media/group/logos/'.$siteGlobal->grt_dir_logo.'/'.$siteGlobal->grt_logo ?>" style="max-width: 100%; max-height: 100%"/>
		</div>
	    </div>
	    <div class="group-title text-center">
		<?php echo $siteGlobal->grt_name ?>
	    </div>    
	</div>
	<?php } ?>
	     
	<?php if ( !$this->session->userdata('sessionUser') ) { ?>
	    <?php $this->load->view('group/common/login-model'); ?>
	<?php } ?>
	<div class="modal fade" tabindex="-1" role="dialog" id="checkorderModal" >
	    <div class="modal-dialog" role="document">
		<form method="post">
		    <div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			    <h4 class="modal-title">Kiểm tra đơn hàng</h4>
			</div>
			<div class="modal-body">
			    <div class="form-group">
				<input class="form-control" name="code" placeholder="Nhập mã đơn hàng">
			    </div>
			    <div class="form-group">
				<input class="form-control" name="email" placeholder="Nhập email của bạn">
			    </div>						    
			</div>
			<div class="modal-footer">
			    <button type="submit" class="btn btn-primary">Kiểm tra</button>
			    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			</div>
		    </div>
		</form>
	    </div>
	</div>