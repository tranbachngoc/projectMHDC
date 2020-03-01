<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>
        <title><?php echo $siteGlobal->grt_title ?></title>
        <link href="/templates/home/css/bootstrap.css" rel="stylesheet">
        <link href="/templates/group/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="/templates/group/css/group-template.css" rel="stylesheet">
	<link href="/templates/home/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/group/css/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/group/css/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
        <script src="/templates/group/js/ie-emulation-modes-warning.js"></script>        
        <!--[if lt IE 9]>
	  <script src="/templates/group/js/ie8-responsive-file-warning.js"></script>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header id="header" class="site-header">
            
            <div class="header-gtop">
                <div class="container">
                    <!-- hotline -->
                    <ul id="menu-top-bar-left-menu" class="top-bar-menu hotline nav-left">
                        <li class="menu-item"><a title="<?php echo $siteGlobal->grt_mobile ?>" href="#"><i class="icon fa fa-phone "></i><?php echo $siteGlobal->grt_mobile ?></a></li>
                        <li class="menu-item"><a title="Liên hệ ngay !" href="/grtshop/contact"><i class="icon fa fa-envelope-o "></i>Liên hệ ngay !</a></li>
                    </ul>
		    <!-- hotline -->
                    <!-- heder links -->
                    <ul id="menu-top-bar-right-menu" class="top-bar-menu links nav-right">    
                        <li><a href="#">Chăm sóc khách hàng</a></li>
                        <li><a href="#">Đăng nhập</a></li>                        
			<!--li class="dropdown pull-right" style="z-index:9999">
			    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chào <strong>Hoàng Việt</strong> <span class="caret"></span></a>
			    <div class="dropdown-menu">
				<ul class="nav nav-child">
				    <li><a href="#">Thông tin cá nhân</a></li>
				    <li><a href="#">Thông tin profile</a></li>
				    <li><a href="#">Kiểm tra đơn hàng</a></li>
				    <li><a href="#">Đăng xuất</a></li>
				</ul>
			    </div>
			</li-->
                    </ul>
                </div>
            </div>
            
            <div class="header-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3  col-sm-12 col-xs-12 col-ts-12 nav-left" style="margin:20px 0;">
			    <div class="logo">
                                <a href="/">
                                    <img height="76" alt="<?php echo $siteGlobal->grt_logo ?>" src="<?php echo DOMAIN_CLOUDSERVER.'media/group/logos/'.$siteGlobal->grt_dir_logo.'/'.$siteGlobal->grt_logo ?>"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-8 col-xs-9 col-ts-9 nav-mind" style="margin:20px 0;">
                            <br>   
                            <form method="get" action="#" class="block-search">
                                <input type="hidden" name="post_type" value="product">            
                                <input type="hidden" name="taxonomy" value="product_cat">
                                <div class="block-content">
                                    <!--div class="categori-search">                
                                        <select name="product_cat" id="1350327380" class="categori-search-option" tabindex="-1" style="display: none;">
                                            <option value="0">All Categories</option>
                                            <option class="level-0" value="accessories">Accessories</option>
                                            <option class="level-1" value="bags">&nbsp;&nbsp;&nbsp;Bags</option>
                                            <option class="level-1" value="watches">&nbsp;&nbsp;&nbsp;Watches</option>
                                            <option class="level-0" value="jewelry">Jewelry</option>
                                            <option class="level-1" value="earring">&nbsp;&nbsp;&nbsp;Earring</option>
                                            <option class="level-1" value="men-watches">&nbsp;&nbsp;&nbsp;Men Watches</option>
                                            <option class="level-1" value="necklaces">&nbsp;&nbsp;&nbsp;Necklaces</option>
                                            <option class="level-1" value="wedding-rings">&nbsp;&nbsp;&nbsp;Wedding Rings</option>
                                            <option class="level-0" value="sports">Sports</option>
                                            <option class="level-0" value="shoes">Shoes</option>
                                            <option class="level-0" value="camera">Camera</option>
                                            <option class="level-0" value="batteries-chargers">Batteries &amp; Chargers</option>
                                            <option class="level-0" value="clothing">Clothing</option>
                                            <option class="level-1" value="hoodies">&nbsp;&nbsp;&nbsp;Hoodies</option>
                                            <option class="level-1" value="t-shirts">&nbsp;&nbsp;&nbsp;T-shirts</option>
                                            <option class="level-0" value="digital">Digital</option>
                                            <option class="level-1" value="imac">&nbsp;&nbsp;&nbsp;iMac</option>
                                            <option class="level-1" value="ipad">&nbsp;&nbsp;&nbsp;iPad</option>
                                            <option class="level-1" value="smartphone">&nbsp;&nbsp;&nbsp;smartphone</option>
                                            <option class="level-1" value="television">&nbsp;&nbsp;&nbsp;Television</option>
                                            <option class="level-0" value="electronics">Electronics</option>
                                            <option class="level-0" value="fashion">Fashion</option>
                                            <option class="level-0" value="featured">Featured</option>
                                            <option class="level-0" value="furniture">Furniture</option>
                                            <option class="level-0" value="headphone-headset">Headphone &amp; Headset</option>
                                            <option class="level-0" value="mobile">Mobile</option>
                                            <option class="level-0" value="music">Music</option>
                                            <option class="level-0" value="network-computer">Network &amp; Computer</option>
                                        </select>
                                        <div class="chosen-container chosen-container-single" style="width: 160px;" title="" id="1350327380_chosen">
                                            <a class="chosen-single" tabindex="-1"><span>All Categories</span><div><b></b></div></a>
                                            <div class="chosen-drop">
                                                <div class="chosen-search">
                                                    <input type="text" autocomplete="off" tabindex="1">
                                                </div>
                                                <ul class="chosen-results"></ul>
                                            </div>
                                        </div>
                                    </div-->                        
                                    <div class="form-search">                                 
                                        <div class="input-group">                   
                                            <input type="text" class="form-control" name="s" value="" placeholder="Search here...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default1" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
                                            </span>                                              
                                        </div>            
                                    </div>        
                                </div>    
                            </form>
			   
			</div>
                        <div class="col-md-3 col-sm-4 col-xs-3 text-right" style="margin:20px 0;">
                           <br>
			    <div class="btn-group">
                                <a href="#" class="btn btn-default link-wishlist"><i class="fa fa-heart"></i> <span class="favorites">0</span></a>
                                <a href="#" class="btn btn-default link-shopcart"><i class="fa fa-shopping-cart"></i> <span class="products">0</span></a>
                            </div>    
			   
                        </div>
                    </div>                    
                </div>
            </div>
            
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
                            <a class="navbar-brand hidden" href="#">Brand</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-1">
                            <ul class="nav navbar-nav">				
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-bars fa-fw"></i> &nbsp; Danh mục sản phẩm
				    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li> 
				<li><a href="#"><i class="fa fa-cubes fa-fw"></i> &nbsp; Sản phẩm</a></li>
				<li><a href="#"><i class="fa fa-tags fa-fw"></i> &nbsp; Coupon</a></li>
				<li><a href="#"><i class="fa fa-tag fa-fw"></i> &nbsp; Khuyễn mãi</a></li>
				<li><a href="#"><i class="fa fa-send-o fa-fw"></i> &nbsp; Bán chạy</a></li>
				<li><a href="#"><i class="fa fa-eye fa-fw"></i> &nbsp; Xem nhiều</a></li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#">Link</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tải App <span class="caret"></span></a>
                                    <div class="dropdown-menu">
					<div class="text-center text-uppercase">Tải ứng dụng ngay</div>
					<div><img src="/templates/group/images/tai-ung-dung.jpg"/></div>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container -->
                </nav>            
        </header>    

        <div class="fullwidth-template" style="background:#ffffff; padding-bottom:30px;">             
            <div class="container">
		<?php $slides = []; $slides[0] = $siteGlobal->grt_banner; $slides[1] = $siteGlobal->grt_banner; $slides[2] = $siteGlobal->grt_banner; ?>
                <div class="block-banner">
                    <div class="banner-owl-carousel owl-carousel">							
                        <?php foreach ($slides as $key => $value) { ?>
                            <div class="fix3x1">
                                <div class="c" style="background:url('<?php echo DOMAIN_CLOUDSERVER . 'media/group/banners/' . $siteGlobal->grt_dir_banner . '/' . $value ?>') no-repeat center / 100% auto;">					
                                </div>
                            </div>
                        <?php } ?>
                    </div>                    
                </div>
                
                <div class="block-service">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
			    <div><i class="fa fa-send-o fa-3x pull-left"></i> MIỄN PHÍ VẬN CHUYỂN<br><small>Đơn hàng từ 500.000 vnđ</small></div>
			</div>
                        <div class="col-sm-3 col-xs-12">
			    <div><i class="fa fa-clock-o fa-3x pull-left"></i> 30-NGÀY ĐỔI TRẢ<br><small>Đảm bảo hoàn lại tiền</small></div>
			</div>
                        <div class="col-sm-3 col-xs-12">
			    <div><i class="fa fa-support fa-3x pull-left"></i> HỖ TRỢ 24/7<br><small>Tư vấn trực tuyến</small></div>
			</div>
                        <div class="col-sm-3 col-xs-12">
			    <div><i class="fa fa-umbrella fa-3x pull-left"></i> MUA SẮM AN TOÀN<br><small>Bảo đảm Mua sắm an toàn</small></div>
			</div>
                    </div>
                </div>
        <?php

	?>
            <?php if($sale_products){ ?>
                <div id="floor_0" class="block-pdoduct ">
                    <div class="block-title ">
                        <div class="title text-uppercase">Sản phẩm khuyến mãi <span class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y') ?></span></div>                        
                    </div>                
                    <div class="block-content">
                             
                        <div class="product-owl-carousel owl-carousel">
			    <?php foreach ($sale_products as $key => $item) { ?>
                            <?php //for($i=0;$i<20;$i++) { ?>
                            <?php 
                                $afSelect = false;
                                $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect);
                                $product_detail = getAliasDomain(). 'grtshop/' . $url_type . '/detail/'. $item->pro_id .'/'. RemoveSign($item->pro_name);
                                if($siteGlobal->grt_domain != ''){
                                    $product_detail = $protocol . $siteGlobal->grt_domain .'/grtshop/' . $url_type . '/detail/'. $item->pro_id .'/'. RemoveSign($item->pro_name);
                                }
                                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $item->pro_dir .'/thumbnail_2_'. explode(',', $item->pro_image)[0];
                                
                             ?> 
                            <div class="product-item">
                                <div class="product-item-info">
                                   <div class="product-item-photo">
                                        <a class="thumb-link" href="#">
                                            <img src="<?php echo $filename?>" alt="<?php echo $item->pro_name?>"/>
                                        </a>
                                        <a href="#" data-quantity="1" data-product_id="678" data-product_sku="61234563" class="btn btn-cart btn-block">
                                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                        </a>
                                    </div>
                                    <div class="product-item-detail">
                                        <strong class="product-item-name"><a href="<?php echo $product_detail?>"><?php echo $item->pro_name?></a></strong>					
                                        <div class="product-item-price">
                                            <span class="price">
                                                    <span class="sale-price-amount">
                                                    <?php echo lkvUtil::formatPrice($discount['salePrice'],'') ?> <span class="currencySymbol">đ</span>
                                                </span>
						<span class="cost-price-amount">
                                                    <?php echo lkvUtil::formatPrice($item->pro_cost,'') ?> <span class="currencySymbol">đ</span>
                                                </span>
                                            </span>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <?php } ?>
                        
			</div>
                </div>
            <?php } ?>
                
            </div> 
        </div>
        </div> 
        <style>
                ul {
                    list-style:  none;
                }
                ul.dropdown-menu li {
                    position:  relative;
                    padding: 3px;
                    text-transform: initial;
                    white-space: nowrap;
                }
                ul.dropdown-menu li ul{
                    position: absolute;
                    left: 100%;
                    background:  #fff;
                    /*width:  100%;*/
                    display:  none;    
                    top: -10%;
                    box-shadow: 1px 1px 3px 0px #ccc;
                }
                

                ul.dropdown-menu li ul li{
                    position:  relative;
                }

                ul.dropdown-menu li ul li ul{
                    display:  none;  
                }
                ul.dropdown-menu li:hover ul.cap1, ul.cap1 li:hover ul.cap2, ul.cap2 li:hover .cap3{
                    display:  block;
                }
                </style>
                
        <div class="fullwidth-template" style="background:#ffffff; padding-bottom:30px;">            
            <div class="container">
                <?php
                if (isset($catlevel0) && count($catlevel0) > 0) {
                    foreach ($catlevel0 as $t => $value) {
                        $catlist = implode(',', $cat[$value->cat_id]);
                        
                ?>
                <div id="floor_<?php echo $t ?>" class="block-floor">
                    <div class="block-title">
                        <div class="row"> 
                            <div class="col-sm-3">				
                                <div class="title">				    
				    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-bars fa-fw"></i>
				    </a>
				    <a href="#"><strong><?php echo $value->cat_name ?></strong></a>
				    <ul class="dropdown-menu">
                                        <?php 
                                        foreach ($menu[$value->cat_id] as $cap1=>$item1){
                                            if($item1->cat_name != ''){
                                                echo '<li><a href="#">'.$item1->cat_name.'</a>';
                                                    echo '<ul class="cap1">';
                                                    foreach ($menu[$value->cat_id][$item1->cat_id] as $cap2=>$item2){
                                                        if($item2->cat_name != ''){
                                                            if(!empty($menu[$value->cat_id][$item1->cat_id][$item2->cat_id])){
                                                                echo '<li>> <a href="#">'.$item2->cat_name.'</a>';
                                                                echo '<ul class="cap2">';
                                                                foreach ($menu[$value->cat_id][$item1->cat_id][$item2->cat_id] as $cap3=>$item3){
                                                                    if($item3->cat_name != ''){
                                                                        if(!empty($menu[$value->cat_id][$item1->cat_id][$item2->cat_id][$item3->cat_id])){
                                                                            echo '<li>>> <a href="#">'.$item3->cat_name.'</a>';
                                                                            echo '<ul class="cap3">';
                                                                            foreach ($menu[$value->cat_id][$item1->cat_id][$item2->cat_id][$item3->cat_id] as $cap4=>$item4){
                                                                                if($item4->cat_name != ''){
                                                                                    echo '<li><a href="/grtshop/product/cat/'.$item4->cat_id.'-'.RemoveSign($item4->cat_name).'">'.$item4->cat_name.'</a>';
                                                                                }
                                                                            }
                                                                            echo '</ul>';
                                                                        }else{
                                                                            echo '<li><a href="/grtshop/product/cat/'.$item3->cat_id.'-'.RemoveSign($item3->cat_name).'">'.$item3->cat_name.'</a>';
                                                                        }
                                                                    }
                                                                }
                                                                echo '</ul>';
                                                            }else{
                                                                echo '<li><a href="/grtshop/product/cat/'.$item2->cat_id.'-'.RemoveSign($item2->cat_name).'">'.$item2->cat_name.'</a>';
                                                            }
                                                        }
                                                    }
                                                    echo '</ul>';
                                                echo '</li>';
                                            }
                                        } ?>
                                        
<!--					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>					
					<li><a href="#">Separated link</a></li>
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>					
					<li><a href="#">Separated link</a></li>
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>					
					<li><a href="#">Separated link</a></li>-->
				    </ul>				    
                                </div>				
                            </div>
                            <div class="col-sm-9">
				<div class="action">
				    <a class="tofloor" href="#floor_<?php echo $t-1 ?>"><i class="fa fa-angle-up fa-fw"></i></a>
				    <br>
				    <a class="tofloor"  href="#floor_<?php echo $t+1 ?>"><i class="fa fa-angle-down fa-fw"></i></a>
				</div>
				<div class="link">				    				    
				    <ul class="list-inline">					
					<li class="active"><a href="#latest_<?php echo $value->cat_id?>"  role="tab" data-toggle="tab">Mới nhất</a></li>
					<li><a href="#sales_<?php echo $value->cat_id?>" role="tab" data-toggle="tab">Khuyến mãi</a></li>
					<li><a href="#views_<?php echo $value->cat_id?>" role="tab" data-toggle="tab">Mua nhiều</a></li>
				    </ul>
				</div>
                            </div>
                                                                               
                        </div>                                                        
                    </div>                    
                    <div class="block-content">
                        <div class="row row-custom">
			    <div class="col2 col-xs-12"> 
                                <div class="banner-cat-right" style="position: relative; height: 100%;">
				    <img style="width: 100%;" src="https://www.certifiedfolder.com/assets/cfdsusa/wms/300x600-OceansideCVB02-i961.gif"/>
				    <div style="height: 170px; background: #390; text-align: center; color:#fff;padding:15px;">
					<p>CƠ HỘI NHẬN 1 CHỈ VÀNG SJC KHI MUA HÀNG</p>
					<p><a class="btn btn-danger">Xem thêm</a></p>
				    </div>
                                </div>
                            </div>
                            <div class="col8 col-xs-12">                               
                                <div class="tab-content" style="padding-top:20px">
                                    <div role="tabpanel fade in" class="tab-pane active" id="latest_<?php echo $value->cat_id?>">
                                        <?php 
                                            //SP mới nhất
                                            $new_products = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 0 AND pro_category IN('.$catlist.') GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
                                            if (count($new_products) > 0) {
                                        ?>
                                            <div class="product-owl-carousel-2 owl-carousel" id="<?php echo $value->cat_id?>">					
                                                <?php 
                                                    $this->load->view('group/product/tab_pro', array('products' => $new_products)); 
                                                ?>
                                            </div>
                                        <?php 
                                            }else{
                                        ?>
                                            <div><span>Không có sản phẩm</span></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div role="tabpanel fade" class="tab-pane" id="sales_<?php echo $value->cat_id?>">
                                        <?php 
                                            //SP mới nhất
                                            $sale_products = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','dp_pro_id = pro_id', $where . " AND pro_category IN(".$catlist.") AND (".time()." >= tbtt_product.pro_begindate AND ".time()." <= tbtt_product.pro_enddate) AND pro_saleoff = 1 AND pro_type = 0 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);	
                                            if (count($sale_products) > 0) {
                                        ?>
                                            <div class="product-owl-carousel-2 owl-carousel" id="<?php echo $value->cat_id?>">					
                                                <?php 
                                                    $this->load->view('group/product/tab_pro', array('products' => $sale_products)); 
                                                ?>
                                            </div>
                                        <?php 
                                            }else{
                                        ?>
                                            <div><span>Không có sản phẩm</span></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <div role="tabpanel fade" class="tab-pane" id="views_<?php echo $value->cat_id?>">
                                        
                                        <?php 
                                            //SP mua nhiều, sum(shc_quantity) as cart
                                            $muanhieu = $this->showcart_model->fetch_join($select . 'shc_id, shc_product', "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", 'LEFT','tbtt_detail_product','dp_pro_id = pro_id', $where." AND pro_type = 0 AND tbtt_product.pro_category IN(".$catlist.") GROUP by shc_id", 'pro_buy','DESC', $start, $limit);//sum(shc_quantity)
                                            if (count($muanhieu) > 0) {
                                        ?>
                                            <div class="product-owl-carousel-2 owl-carousel" id="<?php echo $value->cat_id?>">					
                                                <?php 
                                                    $this->load->view('group/product/tab_pro', array('products' => $muanhieu)); 
                                                ?>
                                            </div>
                                        <?php 
                                            }else{
                                        ?>
                                            <div><span>Không có sản phẩm</span></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>                          
                            </div>  
                            
                        </div>
                    </div>
            </div> 
                <?php }
                }?>
            </div> 
        </div> 
            
        <footer id="footer">
	    <div class="container">
		<div class="row">
		    <div class="col-sm-3"> 
			<h4>VỀ CHÚNG TÔI</h4>
			<ul>
			    <li><a href="/grtshop/introduction">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			    <li><a href="#">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			</ul>
		    </div>
		    <div class="col-sm-3"> 
			<h4>DÀNH CHO NGƯỜI MUA</h4>
			<ul>
			    <li><a href="#">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			    <li><a href="#">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			</ul>
		    </div>		    
		    <div class="col-sm-3"> 
			<h4>DÀNH CHO NGƯỜI BÁN</h4>
			<ul>
			    <li><a href="#">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			    <li><a href="#">Giới thiệu nhóm</a></li>
			    <li><a href="#">Quy chế hoạt động</a></li>
			</ul>
		    </div>
		    <div class="col-sm-3"> 
			<h4>TẢI APP AZIBAI</h4>
			<a href="#"><img class="img-responsive" src="/templates/group/images/tai-ung-dung.jpg" alt="TẢI APP AZIBAI"/></a>
			
		    </div>
		</div>
		<hr/>
		<div class="row">
		    <div class="col-sm-3">
			<h4>CÁCH THỨC THANH TOÁN</h4>
			<ul class="list-inline footer-payment">
			    <li><img src="/templates/group/images/footer-payment.png" alt="footer-payment" height="40"/></li>		
			</ul>					
		    </div>
		    <div class="col-sm-6">
			<h4>ĐỐI TÁC VẬN CHUYỂN</h4>
			<ul class="list-inline footer-transport">
			    <li><img src="/templates/group/images/footer-transpost-1.jpg" alt="footer-transpost-1" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-2.jpg" alt="footer-transpost-2" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-3.jpg" alt="footer-transpost-3" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-4.jpg" alt="footer-transpost-4" height="40"/></li>
			</ul>						
		    </div>
		    <div class="col-sm-3">
			<h4>CHỨNG NHẬN</h4>
			<ul class="list-inline footer-certificate">
			    <li><img src="/images/dadangky.png" height="39"/></li>
			    <li><img src="/images/dathongbao.png" height="39"/></li>
			</ul>			
		    </div>
		</div>
		<hr/>
		<div class="footer-copyright text-center" style="font-size:small;">
                    <h4>CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI</h4>
                    <i class="fa fa-map-marker fa-fw"></i> Trụ sở: <?php echo settingAddress_1; ?><br/>
                    <i class="fa fa-phone fa-fw"></i> Điện thoại: <?php echo settingPhone; ?> &nbsp;<i class="fa fa-mobile fa-fw"></i>Hotline: <?php echo settingMobile; ?><br/>
                    <i class="fa fa-envelope fa-fw"></i> Email: <?php echo settingEmail_1; ?> <br/>
                    Giấy chứng nhận đăng ký kinh doanh số 0314300068 do Sở Kế hoạch và Đầu tư Tp. Hồ Chí Minh cấp ngày 24/03/2017.                   
                </div>
	    </div>
        </footer>
        <a id="scrolltop" href="#" class="fa fa-angle-up fa-2x fa-fw" style="display: none; color:black; border: 2px solid; padding: 2px 8px; position: fixed; bottom: 30px; right: 30px; border-radius: 50%;"></a>
        <script src="/templates/home/js/jquery.min.js" type="text/javascript"></script>
        <script src="/templates/home/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/templates/group/js/owl.carousel.js" type="text/javascript"></script>
        <script src="/templates/group/js/ie10-viewport-bug-workaround.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="/templates/group/js/general.js"></script>
        <script>
            $('.banner-owl-carousel').owlCarousel({ loop:true, responsiveClass:true, items:1, nav:true, dots:false });
            $('.product-owl-carousel').owlCarousel({ loop:false, responsiveClass:true, nav:true, responsive:{ 0:{ items:2, margin:5 }, 600:{ items:3, margin:10 }, 1000:{ items:5, margin:20 } } });
            $('.product-owl-carousel-2').owlCarousel({ loop:true, responsiveClass:true, nav:true, responsive:{ 0:{ items:1, margin:0 }, 600:{ items:1, margin:0 }, 1000:{ items:1, margin:0 } } });
            $('.tofloor').click(function(e){ e.preventDefault(); var aTag = $(this).attr('href'); $('html,body').animate({scrollTop: $(aTag).offset().top},'slow'); });
            $('#scrolltop').click(function(e){ e.preventDefault(); $('html,body').animate({scrollTop: 0},'slow'); });
	    $(window).scroll(function() {    
		var scroll = $(window).scrollTop();
		if (scroll >= 500) {
		    $('#scrolltop').fadeIn();		    
		} else {
		    $('#scrolltop').fadeOut();
		}
	    });
	    
	    var w = $(window).width();
	    if(w<768){
		$('.collapse').removeClass('in')
	    } else {
		$('.collapse').addClass('in');
	    }
	    var cl = 0;
	    $('.showmorecat').click(function(){ 
		$(this).prev().slideToggle('fast');
		if(cl == 0){
		    $(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up'); cl = 1;
		}else{
		    $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down'); cl = 0;
		};		
	    })
	    $(".dropdown").hover(
		function() { $('.dropdown-menu', this).fadeIn("fast");
		},
		function() { $('.dropdown-menu', this).fadeOut("fast");
	    });
            $('.owl-carousel').on('changed.owl.carousel', function (event) {
                var index = event.item.index;
                var item = $('.owl-item').attr('class');
                var id = $(this).attr('id');
                var length = $('#'+id+' .owl-item').length-3;
                //alert(index + ', ' +length);
                //alert($('#'+id+' .active').children().length);
                //alert($('.owl-item').eq(length).children().attr('class'));
                //$('.owl-item').eq(length).remove();
                //$('.owl-item:nth-child('+length+')').css('display','none');
                $('#'+id+' .owl-item').each(function(){
                    alert($(this).attr('class')+', '+$(this).length);
                    //if($(this).)
                });
            });
        </script>
    
        <script>
            $(document).ready(function(){
//                alert($('.product-owl-carousel-2').length);
//                $('.product-owl-carousel-2').each(function(){
//                    alert($(this).attr('id'));
//                });
            })
        </script>
            
    
    </body>
</html>