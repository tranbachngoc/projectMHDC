<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="<?php echo $descrSiteGlobal ? $descrSiteGlobal : settingDescr; ?>"/>
        <meta name="keywords" content="<?php echo $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
        <meta property="og:url" content="<?php echo $ogurl; ?>" />
        <meta property="og:type" content="<?php echo $ogtype; ?>" />
        <meta property="og:title" content="<?php echo $ogtitle; ?>" />
        <meta property="og:description" content="<?php echo $ogdescription ? $ogdescription : settingDescr; ?>" />
        <meta property="og:image" content="<?php echo $ogimage ? $ogimage : '/templates/home/images/logoshare.jpg'; ?>" /> 
        <title><?php echo $pagetitle ?></title>	


	<?php
	if (isset($css)) {
	    echo $css;
	} else {
	    $css = loadCss(
		    array(
		'home/css/libraries.css',
		'home/css/azinews.css',
		'group/css/group-news.css',
		'home/js/jAlert-master/jAlert-v3.css',
		'home/owlcarousel/owl.carousel.min.css',
		'engine1/style.css',
		'home/css/animate.min.css',
		    ), 'asset/home/grtnews.min.css'
	    );
	    echo '<style>' . $css . '</style>';
	}
	?>
	<script src="/templates/home/js/jquery.min.js"></script> 
	<script src="/templates/home/owlcarousel/owl.carousel.js"></script>	
    </head>	
    <body>
	<script src="/templates/home/js/home_news.js"></script>
	<?php if ($isMobile == 0) { ?>
    	<div id="header" class="header_fixed" style="display: block;">			 			
            <div class="header-news">
                <div class="container-fluid">
                    <div class="row"> 						
                        <div class="col-sm-2 col-xs-12 text-center">
                            <a href="/grtnews">
                                <img style="max-height: 34px;" class="" src="/images/logo-azibai-white.png">
                            </a>
                        </div>                            
                        <div class="col-sm-5 col-xs-12">
                            <form class="formSearch" id="formSearch1" action="/grtnews/search" method="post">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tin tức" aria-describedby="basic-addon" value="<?php echo $keyword ?>">
                                        <span class="input-group-addon" id="basic-addon" onclick="document.getElementById('formSearch1').submit();"><i class="fa fa-search"></i></span>
                                </div>
                            </form>
                        </div>							
                        <div class="col-sm-5 col-xs-12">
                            <div class="pull-left">

                                    <?php if ($this->session->userdata('sessionUser')) { ?>

                                        <a class="username" href="/account"> 
                                            <?php if ($this->session->userdata('sessionAvatar')) { ?>
                                            <img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $this->session->userdata('sessionAvatar'); ?>"  style="width:34px; height:34px; margin-right: 10px; "/>
                                            <?php } else { ?>
                                            <img class="img-circle" src="<?php echo site_url('media/images/avatar/default-avatar.png'); ?>"  style="width:34px; height:34px; margin-right: 10px;"/>
                                            <?php } ?>    
                                            <?php echo $this->session->userdata('sessionUsername'); ?>
                                        </a>

                                    <?php } else { ?>

                                        <a class="username" href="/login"> 
                                            <img class="img-circle" src="<?php echo site_url('media/images/avatar/default-avatar.png'); ?>"  style="width:34px; height:34px; margin-right: 10px;"/>
                                            Khách
                                        </a>

                                    <?php } ?>

                            </div> 

                            <ul class="menu-top-right pull-right">
                                <li class="">
                                    <a href="/grtshop" title="Mua sắm" id="quick_view" class="hint--left">                    
                                        <i class="azicon icon-store white"></i>                       
                                    </a>
                                </li>
                                <li>
                                    <a href="/checkout" title="Xem giỏ hàng">
                                        <i class="azicon icon-cart white"></i>
                                        <span class="cartNum">0</span>
                                    </a>
                                </li>
                                <?php if ($this->session->userdata('sessionUser')) { ?>                                   
                                <li>
                                    <a title="Đăng xuất" href="/logout">
                                        <i class="azicon icon-logout white"></i> 
                                    </a>
                                </li>
                                <?php } else { ?>
                                    <li>
                                        <a href="#myLogin" data-toggle="modal">
                                            <i class="azicon icon-login white"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div> 			
                </div>	
            </div>	
    	</div>	
	<?php } else { ?>
    	<div id="header" class="header_fixed" style="display: block;">	
    	    <ul class="menu-mobile dropdown">
    		<li><a href="<?php echo $mainURL; ?>">
    			<i class="azicon icon-azibai"></i>
    		    </a>
    		</li>

    		<li><a href="/grtshop">
    			<i class="azicon icon-store"></i>
    		    </a>
    		</li>
    		<li class="cart">
    		    <a href="/checkout">
    			<i class="azicon icon-cart"></i>                                       
    			<span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
    		    </a>
    		</li>
    		<li class="cart">
    		    <a href="/grtshop/favorites/">
    			<i class="azicon icon-favorite"></i>                                          
    			<span class="favorites"><?php echo $total_favorite ?></span>
    		    </a>
    		</li>
    		<li role="presentation" class="">
    		    <a href="#" class="dropdown-toggle" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
    			<i class="azicon icon-search"></i>
    		    </a>
    		    <ul class="dropdown-menu" aria-labelledby="drop1" style="left: 0; right: 0;">
    			<li style="padding: 10px 15px;">
    			    <form class="formSearch" id="formSearch2" action="/grtnews/search" method="post">				
    				<div class="input-group"> 
    				    <input type="text" value="<?php echo $keyword ?>" name="keyword" id="searchproduct" class="form-control keyword" placeholder="Từ khóa tìm kiếm">
    					<span class="input-group-btn">
    					    <button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
    					</span>                                              
    				</div> 				
    			    </form>                                                
    			</li>
    		    </ul>
    		</li>
    		<li role="presentation" class="">
    		    <a href="#" class="dropdown-toggle" id="drop2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
    			<i class="azicon icon-bars"></i>
    		    </a>
    		    <ul class="nav dropdown-menu" aria-labelledby="drop2" style="left: 0; right: 0;">
			    <?php if ($this->session->userdata('sessionUser')) { ?>
				<li> 
				    <a href="<?php echo $mainURL . 'account' ?>"> 
					<?php if ($this->session->userdata('sessionAvatar') && file_exists('media/images/avatar/' . $this->session->userdata('sessionAvatar'))) { ?>
	    				<img src="<?php echo site_url('media/images/avatar/' . $this->session->userdata('sessionAvatar')); ?>"  style="width:20px; height:20px;"/>
					<?php } else { ?>
	    				<img src="<?php echo site_url('media/images/avatar/default-avatar.png'); ?>"  style="width:20px; height:20px;"/>
					<?php } ?>    
					&nbsp; <?php echo $this->session->userdata('sessionUsername'); ?>
				    </a>                                                        
				</li>
				<li>
				    <form action="/logout" method="post" style="margin-left:-2px;">
					<button type="submit" class="btn btn-link btn-block" style="text-decoration: none; text-align: left; padding: 6px 15px;">
					    <img src="/templates/home/icons/black/icon-logout.png" style="height:20px"/> &nbsp; Đăng xuất 
					</button>
					<input type="hidden" name="grt" value="grtnews">
				    </form>
				</li>
			    <?php } else { ?>
				<li>
				    <a href="#myLogin" data-toggle="modal">
					<img src="/templates/home/icons/black/icon-login.png" style="height:20px"/> &nbsp; Đăng nhập
				    </a>
				</li>                                                
			    <?php } ?> 
    		    </ul>
    		</li>

    	    </ul>
    	    <script>
    		$('.bars').click(function () {
    		    $('.panel-mobile').slideToggle();
    		});
    	    </script>	
    	</div>
	<?php } ?>
        
	<?php if (!$this->session->userdata('sessionUser')) { ?>
	    <?php $this->load->view('group/common/login-model'); ?>
	<?php } ?>