<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Trang cộng tác viên của người dùng</title>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/libraries.css" />
        <link type="text/css" rel="stylesheet" href="/templates/home/css/azinews.css" />
        <link type="text/css" rel="stylesheet" href="/templates/home/css/affiliateshop.css" />
        
        <script src="/templates/home/js/jquery.min.js"></script>        
        <script src="/templates/home/js/bootstrap.min.js"></script>			
		<?php 
		$segment2 = $this->uri->segment(2);
		if($segment2 != 'news'){ ?>
			<script language="javascript"> var siteUrl = '<?php echo base_url(); ?>'; </script> 
			<script async src="/templates/shop/js/general.js"></script>
		<?php } else { ?>
			<link type="text/css" rel="stylesheet" href="/templates/home/owlcarousel/owl.carousel.min.css" />
			<script  src="/templates/home/owlcarousel/owl.carousel.js"></script> 
			<script async src="/templates/home/lazy/jquery.lazy.min.js"></script>
			<script async src="/templates/home/js/clipboard.min.js"></script> 
			<script async src="/templates/home/js/jquery-scrolltofixed-min.js"></script>
			
			<script> 
				function copylink(link) { clipboard.copy(link); } 
				jQuery(function(){		
					$('.scrollfixcolume').scrollToFixed( { 
						marginTop: function() { 
							var marginTop = $(window).height() - $(this).outerHeight(true) - 20; 
							if (marginTop >= 0) return 20; 
							return marginTop; 
						},
						limit: function() { 
							var limit = 0; 
							limit = $('#footer').offset().top - $(this).outerHeight(true); 
							return limit;
						}			
					});		
				});
			</script>	
		<?php } ?>		
    </head>
    <body>
        <div id="header">    
            <div class="container">    
                <div class="row">
                    <div class="col-md-5 col-xs-12 text-left">
                        <br>
                        <!-- Single button -->
                        <div class="btn-group">
                           <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Danh mục Sản phẩm <span class="caret"></span>
                           </button>
                            <ul class="dropdown-menu">
                                <?php 
                                $countpr = 0;
                                if(count($category_list) > 0){
                                    foreach($category_list as $key => $item){
                                        if($item->cate_type == 0){
                                            $countpr++;
                                            $class = '';
                                            if($catid_header == $item->cat_id){ $class = 'action';}
                                            echo '<li class="'. $class .'"><a href="/affiliate/product/cat/' . $item->cat_id .'-'. RemoveSign($item->cat_name) .'">'. $item->cat_name .'</a></li>';
                                        }
                                    }
                                    if($countpr == 0){
                                        echo '<li><a href="#">Không có dữ liệu</a></li>';
                                    }
                                }
                                else{
                                    echo '<li><a href="#">Không có dữ liệu</a></li>';
                                } ?> 
                            </ul> 
                        </div>
                        <!-- Single button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Danh mục Coupon <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                                <?php 
                                $countcp = 0;
                                if(count($category_list) > 0){
                                    foreach($category_list as $key => $item){
                                        if($item->cate_type == 2){
                                            $countcp++;
                                            $class = '';
                                            if($catid_header == $item->cat_id){ $class = 'action';}
                                            echo '<li class="'. $class .'"><a href="/affiliate/coupon/cat/'. $item->cat_id .'-'. RemoveSign($item->cat_name) .'">'. $item->cat_name .'</a></li>';
                                        }
                                    }
                                    if($countcp == 0){
                                       echo '<li><a href="#">Không có dữ liệu</a></li>'; 
                                    }
                                }
                                else{
                                    echo '<li><a href="#">Không có dữ liệu</a></li>'; 
                                }
                                ?>
                            </ul>
                        </div>
                        
                    </div>  
                    <div class="col-md-2 col-xs-12 text-center">          
                        <a id="brand" href="/" >                        
                            <img src="<?php echo DOMAIN_CLOUDSERVER .'media/images/avatar/'. $shop->avatar; ?>" border="0" style="max-height:70px;" />
                        </a>                
                    </div>
                    <div class="col-md-5 col-xs-12 text-right">
                        <br>
                        <?php
                        if ($this->session->userdata('sessionUser') > 0) {
                            if ($this->session->userdata('sessionUser') != $siteGlobal->sho_user) {
                                ?>
                                    Chào <?php echo $this->session->userdata('sessionUsername'); ?>,
                                    <a href="/logout">Thoát</a>
                                <?php } else { ?>
                                    <a target="_blank" href="<?php echo $mainURL ?>account"><i class="fa fa-external-link fa-fw"></i> Quản trị</a>
                                <?php } ?>
                        <?php } else { ?>
                                    <a href="#" data-toggle="modal" data-target="#myLogin" class="btn btn-link"><i class="fa fa-user fa-fw"></i> Đăng nhập</a>
                        <?php } ?>
                       
                        <a href="/affiliate/checkout/" class="btn btn-link"><i class="fa fa-shopping-cart fa-fw"></i> Giỏ hàng (<span class="cartNum"><?php echo $azitab['cart_num']; ?></span>)</a>
                    </div>
                </div>
            </div>
        </div>