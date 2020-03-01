<!DOCTYPE html>
<html lang="vi-VN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $resume->fullname . ' | ' . $resume->company_name; ?>"/>
        <meta name="keywords" content="<?php echo $resume->fullname; ?>"/>
        <meta property="og:url" content="<?php echo current_url() . '&app_id=' . app_id ?>"/>
        <meta property="og:title" content="<?php echo $resume->fullname . ' | ' . $resume->company_name; ?>"/>
        <meta property="og:description" content="<?php echo $resume->fullname . ' | ' . $resume->company_name . ' | Giới tính: ' . ($resume->sex == 1 ? 'Nam' : 'Nữ') . ' | Ngày sinh: ' . date('d/m/Y', strtotime($resume->birthday)) . ' | Tôn giáo: ' . $resume->religion . ' | Điện thoại: ' . $resume->mobile . ' | Email: ' . $resume->email . ' | Học vấn: ' . $resume->education . ' | Nơi sống: ' . $resume->accommodation . ' | Sở thích: ' . $resume->favorites ?>"/>
        <?php if ($resume->banner) { ?>
            <meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->banner; ?>"/>
        <?php } else { ?>
            <meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg'; ?>"/>
        <?php } ?>
        <title><?php echo $resume->fullname . ' | ' . $resume->company_name ?></title>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>        
        <link href="/templates/resume/resume_files/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- OWL CAROSEL CSS -->    
        <link href="/templates/resume/css/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/resume/css/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/home/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css"/>
        <!-- MAGNIFIC CSS -->
        <link href="/templates/resume/css/magnific-popup.css" rel="stylesheet" />
        <!-- Circliful CSS -->
        <link href="/templates/resume/css/jquery.circliful.css" rel="stylesheet" />
        <!--icon css-->
        <link href="/templates/home/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/templates/resume/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />
        <!--animate-->
        <link href="/templates/resume/css/animate.css" rel="stylesheet" type="text/css" />
        <link href="/templates/resume/css/simpletextrotator.css" rel="stylesheet" type="text/css" />
        <!-- Other CSS -->
        <link href="/templates/resume/css/bookblock.css" rel="stylesheet" type="text/css" />
        <!-- Custom CSS -->
        <link href="/templates/resume/css/style.css" rel="stylesheet" type="text/css" />        
        <!-- Color CSS -->
        <?php $this->load->view('home/user/profile/css'); ?>
        <!-- PreLoader -->
        <script src="/templates/resume/js/modernizr.custom.js"></script>
        <script src="/templates/resume/js/pace.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]--> 
    </head>
    <body  data-spy="scroll" data-target="#nav-top">
        <!-- Hides the complete page until window loads -->
        <div class="cover"></div>
        <header>
            <!-- Main company header -->
            <nav class="navbar navbar-default" role="navigation">

                <div class="row">
                    <div class="col-xs-5 col-md-2">
                        <!-- START LOGO -->
                        <div class="logo">
                            <a href="<?php echo current_url(); ?>">
                                <?php if ($resume->logo) { ?>
                                    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->logo; ?>" alt="Brand" style="height:40px;"/>
                                <?php } else { ?>
                                    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/logo-white.png'; ?>" alt="Brand" style="height:40px;"/>
                                <?php } ?>
                            </a>
                        </div>
                        <!-- END LOGO -->
                    </div>
                    <div class="col-xs-7 col-md-10">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-top">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>


                            <!-- Top navigation buttons, visible only in extra small mode -->
                            <a class="visible-xs bb-nav-prev navbar-brand navbar-brand-pagination" href="#"><i class="fa fa-angle-left"></i></a>
                            <a class="visible-xs bb-nav-next navbar-brand navbar-brand-pagination" href="#"><i class="fa fa-angle-right"></i></a>
                            <!-- /Top navigation buttons -->

                        </div>
                        <div  class="collapse navbar-collapse" id="nav-top">
                            <ul class="nav navbar-nav navbar-right" id="menu">
                                <?php $i = 1; ?>
                                <li><a href="#" data-page="<?php echo $i++ ?>">Giới thiệu</a></li>
                                
                                <?php if ($resume->show_company == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Công ty</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_slogan == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Slogan</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_service == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Dịch vụ</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_statistic == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Thống kê</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_product == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Sản phẩm</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_customer == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Khách hàng</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_certification == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Chứng nhận</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_history == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Hoạt động</a></li>
                                <?php } ?>
                                    
                                <?php if ($resume->show_contactUs == 1) { ?>
                                    <li><a href="#" data-page="<?php echo $i++ ?>">Liên hệ</a></li>
                                <?php } ?>
                            </ul>
                        </div><!-- /navbar-collapse -->
                    </div>
                </div><!--/row-->

            </nav><!--/nav-->
        </header>


        <!-- container -->
        <div class="container-fluid">				
            <div class="bb-custom-wrapper">
                <div id="bb-bookblock" class="bb-bookblock">
                   <?php $j = 1; ?>
                    <div class="bb-item" id="page-<?php echo $j++ ?>">
                        <div class="bb-custom-side">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="header-text text-center">
                                                    <?php if ($resume->avatar != "") { ?><img class="img-circle" style="width:150px;height: 150px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $resume->avatar; ?>"/><?php } ?>
                                                    <h2><?php echo $resume->fullname ?></h2>
                                                    <p><?php echo $resume->career ?></p>
                                                    <div class="social-links header-links">
                                                        <ul>
                                                            <li><a href="<?php echo $resume->facebook ?>"><i class="fa fa-facebook facebook"></i></a></li>
                                                            <li><a href="<?php echo $resume->twitter ?>"><i class="fa fa-twitter twitter"></i></a></li>
                                                            <li><a href="<?php echo $resume->google ?>"><i class="fa fa-google-plus google-plus"></i></a></li>                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--/row-->
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="presonal-inform">
                                                    <div class="fix1x1">
                                                        <div class="c" style="
                                                        <?php if ($resume->banner) { ?> 
                                                                 background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->banner; ?>) no-repeat center center;
                                                             <?php } else { ?>
                                                                 background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg' ?>) no-repeat center center;
                                                             <?php } ?>
                                                             -webkit-background-size: cover;
                                                             -moz-background-size: cover;
                                                             -o-background-size: cover;
                                                             background-size: cover;">                                                            
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="presonal-inform">
                                                    <ul class="list-unstyled">
                                                        <?php if ($resume->fullname != "") { ?><li><em class="pull-left"><i class="fa fa-user fa-fw"></i> Họ & Tên</em> <div style="margin-left:120px;"><?php echo $resume->fullname; ?></div></li><?php } ?>
                                                        <?php if ($resume->sex != "") { ?><li><em class="pull-left"><i class="fa fa-venus-mars fa-fw"></i> Giới tính</em> <div style="margin-left:120px;"><?php echo $resume->sex == 1 ? 'Nam' : 'Nữ'; ?></div></li><?php } ?>
                                                        <?php if ($resume->birthday != "") { ?><li><em class="pull-left"><i class="fa fa-calendar-o fa-fw"></i> Ngày sinh</em> <div style="margin-left:120px;"><?php echo date('d/m/Y', strtotime($resume->birthday)) ?></div></li><?php } ?>
                                                        <?php if ($resume->religion != "") { ?><li><em class="pull-left"><i class="fa fa-flag-o fa-fw"></i> Tôn giáo</em> <div style="margin-left:120px;"><?php echo $resume->religion ?></div></li><?php } ?>
                                                        <?php if ($resume->mobile != "") { ?><li><em class="pull-left"><i class="fa fa-mobile fa-fw"></i> Điện thoại</em> <div style="margin-left:120px;"><a href="tel:<?php echo $resume->mobile; ?>"><?php echo $resume->mobile ?></a></div></li><?php } ?>
                                                        <?php if ($resume->email != "") { ?><li><em class="pull-left"><i class="fa fa-envelope-o fa-fw"></i> Email</em> <div style="margin-left:120px;"><a href="mailto:<?php echo $resume->email; ?>"><?php echo $resume->email ?></a></div></li><?php } ?>
                                                        <?php if ($resume->education != "") { ?><li><em class="pull-left"><i class="fa fa-leanpub fa-fw"></i> Học vấn</em> <div style="margin-left:120px;"><?php echo $resume->education ?></div></li><?php } ?>
                                                        <?php if ($resume->accommodation != "") { ?><li><em class="pull-left"><i class="fa fa-map-marker fa-fw"></i> Nơi sống</em> <div style="margin-left:120px;"><?php echo $resume->accommodation ?></div></li><?php } ?>
                                                        <?php if ($resume->marriage != "") { ?><li><em class="pull-left"><i class="fa fa-link fa-fw"></i> Hôn nhân</em> <div style="margin-left:120px;"><?php echo $resume->marriage ?></div></li><?php } ?>
                                                        <?php if ($resume->favorites != "") { ?><li><em class="pull-left"><i class="fa fa-heart-o fa-fw"></i> Sở thích</em> <div style="margin-left:120px;"><?php echo $resume->favorites ?></div></li><?php } ?>
                                                        <?php if ($resume->sayings != "") { ?><li><em class="pull-left"><i class="fa fa-comment-o fa-fw"></i> Câu nói<br>yêu thích</em> <div style="margin-left:120px;"><?php echo $resume->sayings ?></div></li><?php } ?>
                                                    </ul> 
                                                </div>  		
                                            </div>  
                                        </div><!--/row-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <?php if ($resume->show_company == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="section-title">
                                                            <h2 class="">CÔNG TY</h2>
                                                            <div class="title-border"></div>
                                                            <h3><?php echo $resume->company_name ? $resume->company_name : 'Bạn chưa cập nhật tên công ty.'; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 wow fadeIn" style="margin-bottom:30px;">
                                                        <div class="icon_box icon_top">
                                                            <?php
                                                            if ($resume->company_image) {
                                                                $srclogo = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->company_image;
                                                            } else {
                                                                $srclogo = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/about.jpg';
                                                            }
                                                            ?>
                                                            <p><img class="img-responsive" src="<?php echo $srclogo ?>"/></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 wow fadeIn" style="margin-bottom:30px;">
                                                        <?php
                                                        if ($resume->company_intro) {
                                                            $s = preg_replace('/(?<!href="|">)(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $resume->company_intro);
                                                            echo $s = '<p>' . str_replace("\n", "</p><p>", $s) . '</p>';
                                                        } else {
                                                            echo '<p>Chưa cập nhật nội dung giới thiệu. </p>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($resume->show_slogan == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box bgslogan" style="
                                            <?php if ($resume->slogan_bg) { ?> 
                                                     background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->slogan_bg; ?>) no-repeat center center;
                                                 <?php } else { ?>
                                                     background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg3.jpg' ?>) no-repeat center center;
                                                 <?php } ?>						   
                                                 ">									
                                                <div class="row">
                                                    <div class="col-sm-12">													  					   
                                                        <div class="text-center" style="position: relative">
                                                            <div class="sr_quote-text">
                                                                <i class="fa fa-quote-left"></i>
                                                                <?php echo $resume->slogan ? $resume->slogan : 'Chưa cập nhật câu slogan !'; ?>
                                                                <i class="fa fa-quote-right"></i>
                                                            </div>
                                                            <div class="sr_quote-author">-- <em><?php echo $resume->slogan_by ? $resume->slogan_by : 'Chưa cập nhật' ?> </em>--</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($resume->show_service == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="section-title">
                                                            <h2 class="">DỊCH VỤ</h2>
                                                            <div class="title-border"></div>
                                                            <h3><?php echo $resume->title_service ?></h3>
                                                        </div>
                                                    </div>
                                                </div><!--/row-->
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <p style="text-align: justify;">
                                                            <?php echo $resume->service_desc ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <br>
                                                <?php $services = json_decode($resume->list_service); ?>
                                                <div class="row">
                                                    <?php foreach ($services as $key => $value) { ?>			    
                                                        <?php if ($value->image && $value->title && $value->desc) { ?>			    
                                                            <div class="col-sm-12 col-sm-6 col-md-4 text-center">
                                                                <?php if ($value->image) { ?>
                                                                    <img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>" alt="placeholder-img">
                                                                <?php } else { ?>
                                                                    <img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png'; ?>" alt="placeholder-img">
                                                                <?php } ?>
                                                                <div class="ib_content">	    					
                                                                    <div class="ib_description" style="padding: 10px 20px;">
                                                                        <h3 class="ib_title">
                                                                            <?php echo $value->title ? $value->title : 'Tên dịch vụ'; ?>
                                                                        </h3>
                                                                        <p>
                                                                            <?php echo $value->desc ? $value->desc : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.'; ?>
                                                                        </p>
                                                                        <p class="text-center"><a target="blank" href="<?php echo $value->url ? $value->url : '#'; ?>" class="btn btn-primary">Xem chi tiết</a></p>
                                                                    </div>
                                                                </div>	    				
                                                            </div>			     
                                                        <?php } ?>
                                                    <?php } ?>  
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <?php } ?>

                    <?php if ($resume->show_statistic == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="section-title">
                                                            <h2>THỐNG KÊ</h2>
                                                            <div class="title-border"></div>
                                                        </div>
                                                    </div>
                                                </div><!--/row-->

                                                <div class="row text-center">
                                                    <?php $statistic = json_decode($resume->statistic); ?>
                                                    <?php foreach ($statistic as $key => $value) { ?>
                                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                                            <div class="statistic">
                                                                <div class="statistic_number"><div><?php echo $value->number ?></div></div>
                                                                <div class="statistic_label"><?php echo $value->label ?></div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>                                                
                                                </div><!--/row -->

                                            </div>
                                        </div>
                                    </div> 
                                </div>                                            
                            </div>
                        </div>
                    <?php } ?> 

                    <?php if ($resume->show_product == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box" id="work">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="section-title">
                                                            <h2 class=""><?php echo $resume->title_product ? $resume->title_product : 'SẢN PHẨM' ?></h2>
                                                            <div class="title-border"></div>
                                                        </div>
                                                    </div>
                                                </div>											
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <p><?php echo $resume->product_desc ? $resume->product_desc : 'Chưa cập nhật mô tả cho mục sản phẩm nổi bật.'; ?></p>
                                                    </div>
                                                </div>
                                                <?php
                                                $product_cat = json_decode($resume->product_cat);
                                                if ($resume->product_list_0 != "") {
                                                    $product_list_0 = json_decode($resume->product_list_0);
                                                }
                                                if ($resume->product_list_1 != "") {
                                                    $product_list_1 = json_decode($resume->product_list_1);
                                                }
                                                if ($resume->product_list_2 != "") {
                                                    $product_list_2 = json_decode($resume->product_list_2);
                                                }
                                                if ($resume->product_list_3 != "") {
                                                    $product_list_3 = json_decode($resume->product_list_3);
                                                }
                                                $product_list_all = array_merge($product_list_0, $product_list_1, $product_list_2, $product_list_3);
                                                ?>


                                                <div class="text-center" style="overflow: auto; white-space: nowrap;">
                                                    <button class="btn btn-primary fil-cat"  data-rel="all">Tất cả</button>
                                                    <?php
                                                    foreach ($product_cat as $key => $value) {
                                                        if ($value != "") {
                                                            ?>
                                                            <button class="btn btn-default fil-cat" data-rel="<?php echo RemoveSign($value) ?>"><?php echo $value ?></button>
                                                            <?php
                                                        }
                                                    }
                                                    ?>                                               
                                                </div>
                                                <br>   
                                                <div id="portfolio">
                                                    <?php foreach ($product_list_all as $key => $value) { ?>
                                                        <?php if ($value->image != '') { ?>
                                                            <?php
                                                            if ($value->image) {
                                                                $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
                                                            } else {
                                                                $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                                            }
                                                            ?>
                                                            <div class="tile scale-anm <?php echo RemoveSign($value->cat) ?> all">
                                                                <img src="<?php echo $imgsrc ?>" alt="" />
                                                                <span class="zoomex">
                                                                    <a href="<?php echo $imgsrc; ?>" class="zoomlink1">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                    <a href="<?php echo $value->url ?>" class="zoomlink2" target="blank">
                                                                        <i class="fa fa-arrow-right"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div style="clear:both;"></div> 
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 

                    <?php if ($resume->show_customer == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box" id="customers">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="section-title">
                                                            <h2 class="">KHÁCH HÀNG</h2>
                                                            <div class="title-border"></div>
                                                            <h3><?php echo $resume->title_customer != '' ? $resume->title_customer : 'KHÁCH HÀNG NÓI GÌ VỀ CHÚNG TÔI' ?></h3>
                                                        </div>
                                                    </div>
                                                </div> <!--end row-->					    
                                                <?php $customers = json_decode($resume->list_customer); ?>
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div id="owl_customers" class="owl-carousel">                        
                                                            <?php foreach ($customers as $key => $value) { ?>  
                                                                <?php if ($value->image && $value->say && $value->name) { ?>
                                                                    <div class="item text-center">

                                                                        <div class="customer-say">
                                                                            <p class="lead"><i class="fa fa-quote-left fa-fw"></i> &nbsp;
                                                                                <?php echo $value->say ? $value->say : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.' ?> 
                                                                                &nbsp; <i class="fa fa-quote-right fa-fw"></i></p> 								    

                                                                            <p>
                                                                                <?php if ($value->image) { ?>
                                                                                    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>" />
                                                                                <?php } else { ?>
                                                                                    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/default-avatar.png'; ?>" />
                                                                                <?php } ?>                                                                               
                                                                            </p>

                                                                            <p>
                                                                                <strong><?php echo $value->name ? $value->name : 'Tên khách hàng'; ?></strong>
                                                                            </p>

                                                                            <p>
                                                                                <?php if ($value->url != '') { ?>
                                                                                    <a class="video" href="<?php echo $value->url ?>" target="_blank" >
                                                                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Xem video <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                                                                    </a>
                                                                                <?php } ?>                                    
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>                            
                                                        </div> 
                                                    </div>    
                                                </div> <!--end row-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 

                    <?php if ($resume->show_certification == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box" id="">
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="section-title">
                                                            <h2 class=""><?php echo $resume->title_certification ? $resume->title_certification : 'CHỨNG NHẬN' ?></h2>
                                                            <div class="title-border"></div>                                                      
                                                        </div>
                                                    </div>
                                                </div> <!--end row-->
                                                <?php
                                                $certification = json_decode($resume->certification);
                                                ?>
                                                <div id="owl_certification" class="owl-carousel owl-theme">                  
                                                    <?php
                                                    foreach ($certification as $key => $value) {
                                                        if ($value != '') {
                                                            ?> 

                                                            <div>
                                                                <a class="itemcer" href="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>">
                                                                    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>"/>
                                                                </a>
                                                            </div>

                                                            <?php
                                                        }
                                                    }
                                                    ?>                            
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 

                    <?php if ($resume->show_history == 1) { ?>
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">                            
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="section-title">
                                                            <h2>HOẠT ĐỘNG</h2>
                                                            <div class="title-border"></div>
                                                            <p><?php echo $resume->title_history ?></p>

                                                        </div>
                                                    </div>
                                                </div><!--/row-->

                                                <?php $historys = json_decode($resume->list_history); ?>                                            

                                                <div class="time-line"> 
                                                    <?php foreach ($historys as $key => $value) { ?>

                                                        <?php if ($value->image && $value->title) { ?>                                                        
                                                            <div class="row">
                                                                <div class="col-sm-6 <?php echo $key % 2 == 0 ? 'pull-right rex-right' : 'pull-left rex-left'; ?>">
                                                                    <div class="colam">
                                                                        <div class="rs-round <?php echo $key % 2 == 0 ? '' : 'second'; ?>">
                                                                            <i class="pe-7s-diamond"></i>
                                                                        </div>
                                                                        <div class="rex-item">
                                                                            <?php if ($value->date) { ?><h3><i class="fa fa-clock-o fa-fw"></i> <?php echo $value->date ?></h3><?php } ?>
                                                                            <h4><?php echo $value->title ?></h4>
                                                                            <?php if ($value->youtube) { ?>
                                                                                <div class="embed-responsive embed-responsive-16by9">
                                                                                    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo get_youtube_id_from_url($value->youtube) ?>?rel=0" frameborder="0" allowfullscreen=""></iframe>
                                                                                </div>                                
                                                                                <?php
                                                                            } else {
                                                                                $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
                                                                                ?>									                                        
                                                                                <div class="fix16x9">
                                                                                    <?php if ($value->url) { ?> 
                                                                                        <a class="c" href="<?php echo $value->url ?>" target="blank"
                                                                                           style="background:url('<?php echo $imgsrc ?>') no-repeat center;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
                                                                                        </a>
                                                                                    <?php } else { ?>
                                                                                        <div class="c"
                                                                                             style="background:url('<?php echo $imgsrc ?>') no-repeat center;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <div style="padding: 10px 20px; margin-bottom: 30px; border-style: solid; border-width: 0px 1px 1px 1px; border-color: #ddd;">
                                                                                <p><?php echo $value->text ?></p>                                                                            
                                                                                <?php if ($value->url) { ?> 
                                                                                    <p><a target="blank" href="<?php echo $value->url ?>" class="btn btn-default">Xem chi tiết</a></p> 
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!--/row-->
                                                        <?php } ?>  

                                                    <?php } ?>                
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 

                    <?php if ($resume->show_contactUs == 1) { ?>    
                        <div class="bb-item" id="page-<?php echo $j++ ?>">
                            <div class="bb-custom-side">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="section-title">
                                                            <h2>LIÊN HỆ</h2>                                                        
                                                            <div class="title-border"></div>
                                                            <p>Nếu quý khách có thắc mắc hay ý kiến phản hồi, đóng góp xin vui lòng điền vào Form dưới đây và gửi cho chúng tôi. Xin chân thành cảm ơn</p>
                                                        </div>
                                                    </div>
                                                </div><!--/row-->
                                                <div class="row">

                                                    <?php if ($primaryContact == true) { ?>
                                                        <div class="alert alert-primary" role="alert">Bạn đã gửi liên hệ thành công.</div>
                                                    <?php } else { ?>
                                                        <form action="" method="post" class="contact-form" id="contact-contact-formform">                        
                                                            <div class="col-sm-4">
                                                                <?php echo form_error('name_contact'); ?>
                                                                <div class="form-group">
                                                                    <input type="text" name="name_contact" value="<?php echo $name_contact ?>" size="40" class="form-control" id="name"  placeholder="Nhập họ và tên">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php echo form_error('email_contact'); ?>
                                                                <div class="form-group">
                                                                    <input type="email" name="email_contact" value="<?php echo $email_contact ?>" size="40" class="form-control" id="email"  placeholder="Nhập email">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php echo form_error('subject_contact'); ?>
                                                                <div class="form-group">
                                                                    <input type="text" name="subject_contact" value="<?php echo $subject_contact ?>" size="40" class="form-control" id="subject"  placeholder="Nhập tiêu đề">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <?php echo form_error('content_contact'); ?>
                                                                <div class="form-group">
                                                                    <textarea name="content_contact" cols="40" rows="12" class="form-control" id="message" placeholder="Nhập nội dung liên hệ"><?php echo $content_contact ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group text-center">
                                                                    <button type="submit" data-text="GỬI EMAIL" class="btn btn-primary">
                                                                        <span>GỬI EMAIL</span>
                                                                    </button>  
                                                                    <input type="hidden" name="submitconntact" value="submitconntact">                                    
                                                                </div>                            
                                                            </div>                            
                                                        </form>


                                                    <?php } ?>                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="social-links text-center">
                                                            <p>Kết nối với tôi qua mạng xã hội</p>
                                                            <ul>
                                                                <li><a href="<?php echo $resume->facebook ?>"><i class="fa fa-facebook facebook"></i></a></li>
                                                                <li><a href="<?php echo $resume->twitter ?>"><i class="fa fa-twitter twitter"></i></a></li>
                                                                <li><a href="<?php echo $resume->google ?>"><i class="fa fa-google-plus google-plus"></i></a></li>                                                            
                                                            </ul>
                                                        </div>                                                        

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    <?php } ?>  



                </div><!--/bb-bookblock-->	
            </div><!--/bb-custom-wrapper-->
        </div>
        <!-- /container -->

        <?php if ($resume->use_message != '') { ?>
            <a target="_blank" href="<?php echo str_replace("facebook.com/messages", "messenger.com", $resume->use_message); ?>" id="message" style="position: fixed; bottom:20px; left: 15px; z-index: 9999">
                <img src="/templates/resume/resume_files/private-message-on-facebook.png" style="width:40px;"/>
            </a>
        <?php } ?>

        <!-- jQuery -->
        <script src="/templates/resume/js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/templates/resume/js/bootstrap.min.js"></script>

        <!-- Other JavaScript -->
        <script src="/templates/resume/js/jquery.bookblock.js"></script>
        <script src="/templates/resume/js/jquery.tabSlideOut.v1.3.js"></script>
        <script src="/templates/resume/js/jquery.mixitup.js"></script>
        <!--gallary-->
        <script src="/templates/resume/js/gallery.js"></script>
        <script src="/templates/resume/js/mansory.js"></script>
        <!-- OWL CAROUSEL JS  -->
        <script src="/templates/resume/js/owl.carousel.js"></script>
        <!-- PARALLAX JS -->
        <script src="/templates/resume/js/jquery.stellar.min.js"></script>
        <!-- Switcher script for demo only -->
        <script src="/templates/resume/js/switcher.js"></script>
        <!-- MAGNIFICANT JS -->
        <script src="/templates/resume/js/jquery.magnific-popup.min.js"></script>
        <!-- EasyPieChart -->
        <script src="/templates/resume/js/jquery.circliful.min.js"></script>
        <script src="/templates/home/lightgallery/dist/js/lightgallery.min.js"></script>
        <script src="/templates/home/lightgallery/js/lg-video.min.js"></script>
        <!-- app JS -->
        <script src="/templates/resume/js/app.js"></script>
        <script>
            Page.init();
            UltraApp.init();
            $('.fil-cat').click(function () {
                $(this).removeClass('btn-default').addClass('btn-primary');
                $('.fil-cat').not(this).removeClass('btn-primary').addClass('btn-default');
            })
            $(function () {
                var selectedClass = "";
                $(".fil-cat").click(function () {
                    selectedClass = $(this).attr("data-rel");
                    $("#portfolio").fadeTo(100, 0.1);
                    $("#portfolio div").not("." + selectedClass).fadeOut().removeClass('scale-anm');
                    setTimeout(function () {
                        $("." + selectedClass).fadeIn().addClass('scale-anm');
                        $("#portfolio").fadeTo(300, 1);
                    }, 300);

                });
            });

            $('#owl_customers').lightGallery({selector: '.video', download: false});
            $('#portfolio').lightGallery({selector: '.zoomlink1', download: false});
            $('#owl_certification').lightGallery({selector: '.itemcer', download: false});
            $('#owl_customers').owlCarousel({loop: false, margin: 0, nav: true, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true, items: 1});
            //$('#owl_history').owlCarousel({loop: false, margin: 30, nav: false, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true, responsiveClass: true, responsive: {0: {items: 1}, 600: {items: 2}, 1000: {items: 2}}});
            $('#owl_certification').owlCarousel({loop: false, margin: 30, nav: true, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true, responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,

                    },
                    600: {
                        items: 2,

                    },
                    1000: {
                        items: 4,

                    }
                }});
        </script>  
    </body>
</html>