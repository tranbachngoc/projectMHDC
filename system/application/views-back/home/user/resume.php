<!DOCTYPE html>
<html lang="vi-VN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo $resume->fullname .' | '. $resume->company_name; ?>"/>
        <meta name="keywords" content="<?php echo $resume->fullname; ?>"/>
        <meta property="og:url" content="<?php echo current_url().'&app_id='.app_id ?>"/>
        <meta property="og:title" content="<?php echo $resume->fullname .' | '. $resume->company_name; ?>"/>
        <meta property="og:description" content="<?php echo $resume->fullname .' | '. $resume->company_name . ' | Giới tính: ' . ($resume->sex==1? 'Nam' : 'Nữ')  . ' | Ngày sinh: ' . date('d/m/Y', $resume->birthday). ' | Tôn giáo: ' . $resume->religion. ' | Điện thoại: ' . $resume->mobile . ' | Email: ' . $resume->email . ' | Học vấn: ' . $resume->education . ' | Nơi sống: ' . $resume->accommodation . ' | Sở thích: ' . $resume->favorites ?>"/>
        <?php if($resume->banner) { ?>
        <meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$resume->banner;?>"/>
        <?php } else { ?>
        <meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg';?>"/>
        <?php } ?>
        <link href="/templates/resume/resume_files/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/home/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/resume/resume_files/resume.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/group/css/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/group/css/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/home/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css"/>
        <!--<link href="/templates/resume/resume_files/animate.css" rel="stylesheet" type="text/css"/>-->
        <title><?php echo $resume->fullname .' | '. $resume->company_name ?></title>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>        
        <style>
            #home {
                <?php if($resume->banner) { ?> 
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/'.$resume->banner; ?>) no-repeat center center;
                <?php } else { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/default/banner.jpg'?>) no-repeat center center;
                <?php } ?>                
                background-attachment: fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .quotes {
                <?php if($resume->slogan_bg) { ?> 
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/'.$resume->slogan_bg; ?>) no-repeat center;
                <?php } else { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/default/bg1.jpg';?>) no-repeat center;
                <?php } ?>
                background-attachment: fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            #statistics {
                <?php if($resume->statistic_bg) { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/'.$resume->statistic_bg ?>) no-repeat center center;
                <?php } else { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/default/bg2.jpg';?>) no-repeat center center;
                <?php } ?>
                background-attachment: fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .testimonials {
                <?php if($resume->customer_bg) { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/'.$resume->customer_bg;?>) no-repeat center center;
                <?php } else { ?>
                background: url(<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/default/bg3.jpg';?>) no-repeat center center;
                <?php } ?>
                background-attachment: fixed;                
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }            
        </style>        
    </head>
    <body class="home">        
        <header id="header" class="page-head clearfix">
            <div class="container">
                <div class="site-logo">
                    <a id="logo" href="#">
                        <?php if($resume->logo) { ?>
                        <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$resume->logo; ?>" alt=""/>
                        <?php } else { ?>
                        <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/logo.jpg'; ?>" alt=""/>
                        <?php } ?>
                    </a>
                </div>
                <nav>
                    <ul class="main-nav">
                        <li class="nav-control">
                            <a id="nav-toggle" href="#non" class="">
                                <i class="fa fa-bars"></i>
                            </a>
                            <ul class="inner-nav">
                                <li id="menu-item-1" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#home" class="nav-active">
                                        <i class="fa-fw fa fa-home"></i>
                                        <span>TRANG CHỦ</span>
                                    </a>
                                </li>
                                <li id="menu-item-2" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#about" class="">
                                        <i class="fa-fw fa fa-credit-card"></i>
                                        <span>GIỚI THIỆU</span>
                                    </a>
                                </li>
				
                                <?php if($resume->show_service==1) { ?>
                                <li id="menu-item-3" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#services" class="">
                                        <i class="fa-fw fa fa-thumbs-o-up"></i>
                                        <span>DỊCH VỤ</span>
                                    </a>
                                </li>  
				<?php } ?>
                                
                               <?php if($resume->show_product==1) { ?>
                                <li id="menu-item-4" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#portfolio" class="">
                                        <i class="fa-fw fa fa-cubes"></i>
                                        <span>SẢN PHẨM</span>
                                    </a>
                                </li>
                                <?php } ?>
                                
                                <?php if($resume->show_customer==1) { ?>
                                <li id="menu-item-5" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#testimonials" class="">
                                        <i class="fa-fw fa fa-users"></i>
                                        <span>KHÁCH HÀNG</span>
                                    </a>
                                </li> 
                                <?php } ?>
                                
                                <?php if($resume->show_certification==1) { ?>
                                <li id="menu-item-6" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#certification" class="">
                                        <i class="fa-fw fa fa-certificate"></i>
                                        <span>CHỨNG NHẬN</span>
                                    </a>
                                </li>
                                <?php } ?>
                                
                                <?php if($resume->show_history==1) { ?>
                                <li id="menu-item-7" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#blog">
                                        <i class="fa-fw fa fa-pencil"></i>
                                        <span>HOẠT ĐỘNG</span>
                                    </a>
                                </li>   
                                <?php } ?>
                                <?php if($resume->show_contactUs==1) { ?>
                                <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#contact">
                                        <i class="fa-fw fa fa-envelope-o"></i>
                                        <span>LIÊN HỆ</span>
                                    </a>
                                </li>
				
                                <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#google-map-address">
                                        <i class="fa-fw fa fa-map-marker"></i>
                                        <span>BẢN ĐỒ</span>
                                    </a>
                                </li>
				<?php } ?>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>        
        <div id="home" class="home section">            
            <div class="overlay">
                <header class="big-title hd_home_1">
                    <h2 class="big-head">
                        <span>
                            <span class="fullname"><?php echo $resume->fullname ? $resume->fullname : 'Họ & Tên'; ?></span>                             
                            <span class="career">                                
                                    <?php 
                                        if( $resume->career ) { 
                                            echo $resume->career;
                                        } else {
                                            echo 'Chưa nhập ngành nghề';
                                        }                                            
                                    ?>                                            
                            </span>                           
                        </span>
                    </h2>
                </header>
                <div class="learn-more">
                    <a href="#about" data-toggle="modal" data-target=".learn-more-modal">
                        <div class="text">Xem thêm thông tin về tôi</div>
                        <div class="icon">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                </div>
                <span class="cp-load-after-post"></span>
            </div>                
        </div>
        
        <div id="about" class="about section">
            <div class="container">
                <div class="modal fade learn-more-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <?php if($resume->avatar !="") { ?><p class="text-center"><img class="img-circle" style="width:120px;height: 120px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/avatar/'.$resume->avatar; ?>"/></p><?php } ?>
                            <?php if($resume->fullname !="") { ?><div><em class="pull-left">Họ & Tên</em> <p style="margin-left:90px;"><?php echo $resume->fullname;?></p></div><?php } ?>
                            <?php if($resume->sex !="") { ?><div><em class="pull-left">Giới tính</em> <p style="margin-left:90px;"><?php echo $resume->sex==1?'Nam':'Nữ';?></p></div><?php } ?>
                            <?php if($resume->birthday !="") { ?><div><em class="pull-left">Ngày sinh</em> <p style="margin-left:90px;"><?php echo date('d/m/Y', strtotime($resume->birthday)) ?></p></div><?php } ?>
                            <?php if($resume->religion !="") { ?><div><em class="pull-left">Tôn giáo</em> <p style="margin-left:90px;"><?php echo $resume->religion ?></p></div><?php } ?>
                            <?php if($resume->mobile !="") { ?><div><em class="pull-left">Điện thoại</em> <p style="margin-left:90px;"><a href="tel:<?php echo $resume->mobile; ?>"><?php echo $resume->mobile ?></a></p></div><?php } ?>
                            <?php if($resume->email !="") { ?><div><em class="pull-left">Email</em> <p style="margin-left:90px;"><a href="mailto:<?php echo $resume->email; ?>"><?php echo $resume->email ?></a></p></div><?php } ?>
                            <?php if($resume->education !="") { ?><div><em class="pull-left">Học vấn</em> <p style="margin-left:90px;"><?php echo $resume->education ?></p></div><?php } ?>
                            <?php if($resume->accommodation !="") { ?><div><em class="pull-left">Nơi sống</em> <p style="margin-left:90px;"><?php echo $resume->accommodation ?></p></div><?php } ?>
                            <?php if($resume->marriage !="") { ?><div><em class="pull-left">Hôn nhân</em> <p style="margin-left:90px;"><?php echo $resume->marriage ?></p></div><?php } ?>
                            <?php if($resume->favorites !="") { ?><div><em class="pull-left">Sở thích</em> <p style="margin-left:90px;"><?php echo $resume->favorites ?></p></div><?php } ?>
                            <?php if($resume->sayings !="") { ?><div><em class="pull-left">Câu nói<br>yêu thích</em> <p style="margin-left:90px;"><?php echo $resume->sayings ?></p></div><?php } ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>                            
                        </div>
                    </div>
                  </div>
                </div>                
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="row-fullwidth box-shadow">
                            <strong>PHÒNG BAN</strong>
                            <br><?php echo $resume->department ? $resume->department : 'Chưa cập nhật'; ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="row-fullwidth box-shadow">
                            <strong>ĐIỆN THOẠI</strong>
                            <br> <a href="tel:<?php echo $resume->mobile; ?>"><?php echo $resume->mobile; ?></a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="row-fullwidth box-shadow">
                            <strong>EMAIL</strong>
                            <br> <a href="mailto:<?php echo $resume->email;?>"><?php echo $resume->email ?></a>
                        </div>
                    </div>                    
                </div>             
            </div>
            <div class="row-fullwidth box-shadow" style="border-top: 2px #eee solid;"></div>
        </div>
	<?php if($resume->show_company == 1) { ?>
        <div id="company" class="company section">           
            <div class="container">
                <header class="heading hd_about_2">
                    <h2>CÔNG TY <span class="small"> / <?php echo $resume->company_name ? $resume->company_name : 'Chưa cập nhật';?></span></h2>
                </header>
                <div class="row">
                    <div class="col-md-4 col-sm-4 wow fadeIn" style="margin-bottom:30px;">
                        <div class="icon_box icon_top">
                            <?php if($resume->company_image) { 
                                $srclogo = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$resume->company_image;
                            } else { 
                                $srclogo = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/about.jpg';
                            } ?>
                            <p><img class="img-responsive" src="<?php echo $srclogo ?>"/></p>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 wow fadeIn" style="margin-bottom:30px;">
                        <?php if($resume->company_intro) {
                            $s = preg_replace('/(?<!href="|">)(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $resume->company_intro);
                            echo $s = '<p>' . str_replace("\n", "</p><p>", $s) . '</p>';
                        } else {
                            echo '<p>Chưa cập nhật nội dung giới thiệu. </p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <span class="cp-load-after-post"></span>
        </div>
	<?php } ?>
        <?php if($resume->show_slogan == 1) { ?>
	<div id="quotes" class="quotes section">
            <div class="overlay">
                <div class="container">
                    <div class="sr_quote">
                        <p>
                            <i class="fa fa-quote-left"></i><?php echo $resume->slogan ? $resume->slogan : 'Chưa cập nhật câu slogan.  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'; ?>
                            <i class="fa fa-quote-right"></i>
                        </p>
                        <div class="sr_quote-author">- <?php echo $resume->slogan_by ? $resume->slogan_by : 'Chưa cập nhật' ?> -</div>
                    </div>
                </div>
                <span class="cp-load-after-post"></span>
            </div>
        </div>
	<?php } ?>
	<?php if($resume->show_service == 1) { ?>
        <div id="services" class="services section">
            <div class="container">
                <header class="heading hd_services_4">
                    <h2>DỊCH VỤ <span class="small"> / <?php echo $resume->title_service ?> </span></h2>                    
                </header>
                <div class="row-fullwidth box-shadow" style="margin-bottom: 40px;">
                    <p style="text-align: justify;">
                        <?php echo $resume->service_desc ? $resume->service_desc : 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'; ?>
                    </p>
                </div>
            
                <?php 
                    $services = array(
                        json_decode($resume->service_0),                
                        json_decode($resume->service_1),
                        json_decode($resume->service_2), 
                        json_decode($resume->service_3), 
                        json_decode($resume->service_4), 
                        json_decode($resume->service_5) 
                    );
                ?>
            
                <div class="row fixdisplay">
                <?php foreach ($services as $key => $value) { ?>
                    <?php if($key>0&&$key%3==0) echo '</div><div class="row fixdisplay">'; ?>
                    <?php if($value->image && $value->title && $value->desc) { ?>
                    <div class="col-md-4 col-sm-4 wow fadeIn" style="margin-bottom: 30px;">
                            <div style="border: 1px #b2b2b2 solid; height: 100%;">
                                <div class="icon_box icon_top">
                                    <?php if($value->image){ ?>
                                    <img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image; ?>" alt="placeholder-img">
                                    <?php } else { ?>
                                    <img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';?>" alt="placeholder-img">
                                    <?php } ?>                                    

                                    <div class="ib_content">
                                        <h4 class="ib_title">
                                            <?php echo $value->title ? $value->title : 'Tên dịch vụ'; ?>
                                        </h4>
                                        <div class="ib_description" style="padding: 10px 20px;">
                                            <p>
                                                <?php echo $value->desc ? $value->desc : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.';?>
                                            </p>
                                            <p class="text-center"><a target="blank" href="<?php echo $value->url ? $value->url : '#'; ?>" class="btn btn-default">Xem chi tiết</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php } ?>
                <?php } ?>  
                </div>
            </div>            
        </div>
        <?php } ?>
	<?php if($resume->show_statistic == 1 ){ ?>
        <div id="statistics" class="statistics section text-center">
            <div class="overlay">
                <div class="container">
                    <header class="heading">
                        <h2>THỐNG KÊ</h2>
                    </header>
                    <div class="icon_box icon_top">
                        <div class="ib_icon">
                            <i class="fa fa-quote-left"></i>
                        </div>
                    </div>
                    <div class="row">
                        <?php $statistic = json_decode($resume->statistic);?>
                        <?php foreach ($statistic as $key => $value) { ?>
                            <div class="col-md-3 col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                                <div class="statistic_number">
                                    <span class="num"><?php echo $value->number ?></span>
                                    <span><?php echo $value->label ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>                
            </div>
        </div> 
        <?php } ?>
        <?php if($resume->show_product == 1){ ?>
        <div id="portfolio" class="portfolio sections">
            <div class="container" style="margin-bottom:20px;">
                <header class="heading">
                    <h2 class="h_tit">SẢN PHẨM <span class="small"> / <?php echo $resume->title_product ?></span></h2>                    
                </header>
                <div class="row-fullwidth box-shadow" style="margin-bottom: 40px;">
                    <?php echo $resume->product_desc ? $resume->product_desc : 'Chưa cập nhật mô tả cho danh mục sản phẩm.'; ?>
                </div>
                <?php 
                    $product_cat = json_decode($resume->product_cat);
		    if($resume->product_list_0!=""){ $product_list_0 = json_decode($resume->product_list_0);}                  
                    if($resume->product_list_1!=""){ $product_list_1 = json_decode($resume->product_list_1);}
                    if($resume->product_list_2!=""){ $product_list_2 = json_decode($resume->product_list_2);}
		    if($resume->product_list_3!=""){ $product_list_3 = json_decode($resume->product_list_3);}
                    $product_list_all = array_merge($product_list_0,$product_list_1,$product_list_2,$product_list_3);
                ?>
                <ul class="tabfilter list-inline text-center" role="tablist">
                    <li role="presentation" class="active"><a href="#all" class="" aria-controls="all" role="tab" data-toggle="tab">Tất cả</a></li>
                    <?php foreach ($product_cat as $key => $value) { 
                        if($value!=""){ ?>
                    <li role="presentation"><a href="#tab<?php echo $key + 1 ?>" class="" aria-controls="<?php echo RemoveSign($value) ?>" role="tab" data-toggle="tab"><?php echo $value ?></a></li>
                    <?php }/*endif*/ } /*endforeach*/ ?>
                </ul>
                <div class="tab-content" style="padding: 10px">
                    <div role="tabpanel" class="row tab-pane fade in active" id="all">
                    <?php foreach ($product_list_all as $key => $value) { ?>
                        <?php if($value->image!='') { ?>
                        <div class="item <?php echo RemoveSign($value->cat) ?> col-xs-12 col-sm-6 col-md-3" style="padding:5px">
                            <?php if($value->image){
                                $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                            } else { 
                                $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                            } ?>
                            <figure>
                                <div class="fix4x3">
                                    <div class="c" style="background: url('<?php echo $imgsrc; ?>') no-repeat center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
                                </div>
                                <div class="zoomex2">
                                    <a href="<?php echo $imgsrc; ?>" class="prettyPhoto zoomlink1">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="<?php echo $value->url ?>" class="zoomlink2">
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </figure>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    </div>                   
                    <div role="tabpanel" class="row tab-pane fade" id="tab1">
                        <?php foreach ($product_list_0 as $key => $value) { ?>
                            <?php if($value->image!='') { ?>
                            <div class="item <?php echo RemoveSign($value->cat) ?> col-xs-12 col-sm-6 col-md-3" style="padding:5px">

                                <?php if($value->image){
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                                } else { 
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                } ?>
                                <figure>
                                    <div class="fix4x3">
                                        <div class="c" style="background: url('<?php echo $imgsrc; ?>') no-repeat center ;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
                                    </div>
                                    <div class="zoomex2">
                                        <a href="<?php echo $imgsrc; ?>" class="prettyPhoto zoomlink1">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="<?php echo $value->url ?>" class="zoomlink2">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </figure>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div role="tabpanel" class="row tab-pane fade" id="tab2">
                        <?php foreach ($product_list_1 as $key => $value) { ?>
                            <?php if($value->image!='') { ?>
                            <div class="item <?php echo RemoveSign($value->cat) ?> col-xs-12 col-sm-6 col-md-3" style="padding:5px">

                                <?php if($value->image){
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                                } else { 
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                } ?>
                                <figure>
                                    <div class="fix4x3">
                                        <div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
                                    </div>
                                    <div class="zoomex2">
                                        <a href="<?php echo $imgsrc; ?>" class="prettyPhoto zoomlink1">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="<?php echo $value->url ?>" class="zoomlink2">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </figure>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div role="tabpanel" class="row tab-pane fade" id="tab3">
                        <?php foreach ($product_list_2 as $key => $value) { ?>
                            <?php if($value->image!='') { ?>
                            <div class="item <?php echo RemoveSign($value->cat) ?> col-xs-12 col-sm-6 col-md-3" style="padding:5px">

                                <?php if($value->image){
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                                } else { 
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                } ?>
                                <figure>
                                    <div class="fix4x3">
                                        <div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
                                    </div>
                                    <div class="zoomex2">
                                        <a href="<?php echo $imgsrc; ?>" class="prettyPhoto zoomlink1">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="<?php echo $value->url ?>" class="zoomlink2">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </figure>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div role="tabpanel" class="row tab-pane fade" id="tab4">
                        <?php foreach ($product_list_3 as $key => $value) { ?>
                            <?php if($value->image!='') { ?>
                            <div class="item <?php echo RemoveSign($value->cat) ?> col-xs-12 col-sm-6 col-md-3" style="padding:5px">

                                <?php if($value->image){
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                                } else { 
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                } ?>
                                <figure>
                                    <div class="fix4x3">
                                        <div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
                                    </div>
                                    <div class="zoomex2">
                                        <a href="<?php echo $imgsrc; ?>" class="prettyPhoto zoomlink1">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        <a href="<?php echo $value->url ?>" class="zoomlink2">
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </figure>
                            </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>                
            </div>            
        </div>
        <?php } ?>
        
        <?php if($resume->show_customer == 1){ ?>
        <div id="testimonials" class="testimonials section">
            <?php 
                $customers = array(
                    json_decode($resume->customer_0),
                    json_decode($resume->customer_1),
                    json_decode($resume->customer_2),
                    json_decode($resume->customer_3)
                );                
            ?>
            <div class="overlay">
                <div class="container" style="padding-top: 65px; padding-bottom: 65px;">
                    <header class="heading_2 hd_testimonials_13">
                        <h2 class="h_tit"><?php echo $resume->title_customer !='' ? $resume->title_customer : 'Ý KIẾN KHÁCH HÀNG' ?></h2>
                    </header>                    
                    <div id="owl_testimonials" class="owl-carousel owl-theme">                        
                    <?php foreach ($customers as $key => $value) { ?>  
                        <?php if($value->image && $value->say && $value->name) { ?>
                            <div>
                                <br>
                                <p>
                                    <?php if($value->url!='') { ?>
                                    <a class="video" href="<?php echo $value->url ?>" target="_blank" style="color: #fff;">
                                    <?php } ?>
                                            
                                    <?php if($value->image) { ?>
                                    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;?>" />
                                    <?php } else { ?>
                                    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/default-avatar.png' ;?>" />
                                    <?php } ?>
                                    
                                    <?php if($value->url!='') { ?>
                                        <br>
                                        Xem video
                                    </a>
                                    <?php } ?>                                    
                                </p>                                
                                <p><i class="fa fa-quote-left"></i> <?php echo $value->say ? $value->say : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.' ?> <i class="fa fa-quote-right"></i> </p><br/>
                                <strong><?php echo $value->name ? $value->name : 'Tên khách hàng'; ?></strong>                                       
                            </div>
                        <?php } ?>
                    <?php } ?>                            
                    </div>                    
                </div>
                <span class="cp-load-after-post"></span>
            </div>
        </div>
        <?php } ?>
        
        <?php if($resume->show_certification == 1){ ?>
        <div id="certification" class="certification section">
            <div class="container">
                <header class="heading hd_testimonials_13">
                    <h2 class="h_tit text-center"><?php echo $resume->title_certification ?></h2>
                </header>
                <?php
                    $certification = json_decode($resume->certification); 
                ?>
                <div id="owl_certification" class="owl-carousel">                        
                    <?php foreach ($certification as $key => $value) { if($value != '') { ?>  
                    <a class="itemcer" href="<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/'.$value ;?>">
                        <img src="<?php echo DOMAIN_CLOUDSERVER.'media/images/profiles/'.$resume->userid.'/thumbnail_'.$value ;?>"/>
                    </a>
                    <?php } /*endif; */ } /*endforeach;*/?>                            
                </div> 
            </div>
        </div>
        <?php } ?>  
        <?php if($resume->show_history == 1){ ?>
        <div id="blog" class="blog section">
            <div class="timeline container">
                <header class="heading hd_blog_18">
                   <h2>HOẠT ĐỘNG <span class="small"> / <?php echo $resume->title_history ?></span></h2>                   
                </header>
                <?php 
                    $history_0 = json_decode($resume->history_0);
                    $history_1 = json_decode($resume->history_1); 
                    $history_2 = json_decode($resume->history_2); 
                    $history_3 = json_decode($resume->history_3); 
                    $history_4 = json_decode($resume->history_4); 
                    $history_5 = json_decode($resume->history_5); 
                    $history_6 = json_decode($resume->history_6); 
                    $history_7 = json_decode($resume->history_7); 
                    $history_8 = json_decode($resume->history_8); 
                    $history_9 = json_decode($resume->history_9); 
                     
                    $historys = array($history_0,$history_1,$history_2,$history_3,$history_4,$history_5,$history_6,$history_7,$history_8,$history_9);
                ?>
                <div class="timeline-top"> <strong style="display: inline-block; padding: 10px 20px; background: black; color: white;">&nbsp;</strong> </div>
                    <div class="timeline">  
                    <?php foreach ($historys as $key => $value) { ?>
                        <?php if($value->image && $value->title) { ?>
                        <div class="timeline-container wow <?php echo $key%2==0?'timeline-left fadeIn':'timeline-right fadeIn';?>">
                            <div class="content">
                                <?php if($value->youtube) {  ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo get_youtube_id_from_url($value->youtube) ?>?rel=0" frameborder="0" allowfullscreen=""></iframe>
                                </div>                                
                                <?php } else { ?>
                                    <?php if($value->image) {
                                        $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$value->image;
                                    } else { 
                                        $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
                                    } ?>                                    
                                    <div class="fix16x9">
                                        <a class="c" href="<?php echo $value->url ? $value->url: '#' ?>"
                                           style="background:url('<?php echo $imgsrc ?>') no-repeat center;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
                                        </a>
                                    </div>
                                <?php } ?>
                                <div style="padding: 10px 20px;">
                                    <h4 class="timeline-title"><?php echo $value->title ? $value->title : 'Chưa cập nhật hoạt động';?></h4>
                                    <p><small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?php echo $value->date ? $value->date : date("Y/m/d") ;?></small></p>

                                    <p><?php echo $value->text ? $value->text : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.';?></p>                                    
                                    <p class="text-center"><a href="<?php echo $value->url ? $value->url: '#' ?>" class="btn btn-default">Xem thêm</a></p>                                
                                </div>                        
                            </div>                        
                        </div>                        
                        <?php } ?>   
                    <?php } ?> 
                </div>                
                <div class="timeline-bot"> <strong style="display: inline-block; padding: 10px 20px; background: black; color: white;">&nbsp;</strong> </div>
            </div>
        </div>
        <?php } ?>
	<?php if($resume->show_contactUs==1) { ?>        
        <div id="contact" class="contact section">
            <div class="container">
                <header class="heading hd_contact_19">
                    <h2>LIÊN HỆ <span class="small"> / Hãy liên lạc với tôi</span></h2>                    
                </header>
                <div class="wow fadeInUpBig">
                    <?php if ($successContact==true) { ?>
                        <div class="alert alert-success" role="alert">
			    Quý khách đã gửi email liên hệ thành công. Chúng tôi sẽ tiếp nhận và phản hồi lai Quý khách nhanh nhất có thể. 
			    Trường hợp cần liên hệ hoặc hỗ trợ nhanh, xin vui lòng liên hệ trực tiếp với tôi qua số điện thoại: <strong><?php echo $resume->mobile ?></strong>			    
			</div>
                    <?php } else { ?>
                        <form action="/resume/<?php echo $resume->userid ?>/<?php echo RemoveSign($resume->fullname) ?>/#contact" method="post" class="contact-form" id="contact-contact-formform">                        
                            <div class="row">
                                <div class="inputs col-md-6 col-sm-6">
                                    <?php echo form_error('name_contact'); ?>
                                    <div class="form-group">
                                        <input type="text" name="name_contact" value="<?php echo $name_contact ?>" size="40" class="form-control input-lg" id="name"  placeholder="HỌ VÀ TÊN">
                                    </div>
                                </div>
                                <div class="inputs col-md-6 col-sm-6">
                                    <?php echo form_error('email_contact'); ?>
                                    <div class="form-group">
                                        <input type="email" name="email_contact" value="<?php echo $email_contact ?>" size="40" class="form-control input-lg" id="email"  placeholder="EMAIL">
                                    </div>
                                </div>
                                <div class="inputs col-md-12 col-sm-12 col-xs-12">
                                    <?php echo form_error('subject_contact'); ?>
                                    <div class="form-group">
                                        <input type="text" name="subject_contact" value="<?php echo $subject_contact ?>" size="40" class="form-control input-lg" id="subject"  placeholder="TIÊU ĐỀ">
                                    </div>
                                </div>                                
                                <div class="inputs col-md-12 col-sm-12 col-xs-12">                                    
                                    <?php echo form_error('content_contact'); ?>
                                    <div class="form-group">
                                        <textarea name="content_contact" cols="40" rows="10" class="form-control input-lg" id="message"><?php echo $content_contact ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="inputs contact-submit text-center">
                                <button type="submit" data-text="GỬI TIN NHẮN" class="btn btn-default btn-lg">
                                    <span>GỬI TIN NHẮN</span>
                                </button>  
                                <input type="hidden" name="submitconntact" value="submitconntact">                                    
                            </div>                            
                        </form>
                    <?php } ?>                    
                </div>
            </div>
        </div>
        <div id="google-map-address" class="google-map-address section">            
            <div class="close-footer">
                <i class="fa fa-map-marker"></i>
            </div>            
            <div class="footer-contact">
                <div class="footer-content">
                    <div class="footer-active" id="close-footer">
                        <div class="container">
                            <div class="contact-details">
                                <p><a class="contact-mobile" href="tel:<?php echo $resume->mobile ?>"><?php echo $resume->mobile ?></a></p>
                                <p><a class="contact-email"href="mailto:<?php echo $resume->email ?>"><?php echo $resume->email ?></a></p>                                
                                <h2><?php echo $resume->fullname ? $resume->fullname : 'Chưa cập nhật họ tên'; ?></h2>
                                <p><?php echo $resume->company_name ? $resume->company_name : 'Chưa cập nhật tên công ty'; ?></p>
                                <div class="folowme">
                                    <a href="<?php echo $resume->facebook ?>" class="btn btn-primary"><i class="fa fa-facebook fa-fw"></i></a> &nbsp;
                                    <a href="<?php echo $resume->twitter ?>" class="btn btn-info"><i class="fa fa-twitter fa-fw"></i></a> &nbsp;
                                    <a href="<?php echo $resume->google ?>" class="btn btn-danger"><i class="fa fa-google-plus fa-fw"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="my-contact-map">
                    <div class="contact-map">
                        <?php echo $headerjs . $headermap . $onload . $map ; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
	<footer id="footer" class="page-foot clearfix">
            <div class="container">
                <p class="copyright text-center">Bản quyền © 2017 <?php echo $resume->fullname ?>. Phát triển bởi <a style="color: #fff" href="https://azibai.com">azibai.com</a></p>                
            </div>
        </footer> 
        <?php if($resume->use_message!='') { ?>
        <a target="_blank" href="<?php echo str_replace("facebook.com/messages","messenger.com",$resume->use_message); ?>" id="message" style="position: fixed; bottom:20px; left: 15px; z-index: 9999">
            <img src="/templates/resume/resume_files/private-message-on-facebook.png" style="width:40px;"/>
        </a>
        <?php } ?>
        <a href="javascript:" id="return-to-top" style="display: none;"> <i class="fa fa-chevron-up"></i> </a>
        <script src="/templates/home/js/jquery.min.js" type="text/javascript"></script>
        <script src="/templates/resume/resume_files/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/templates/resume/resume_files/owl.carousel.js" type="text/javascript"></script>
        <script src="/templates/home/lightgallery/dist/js/lightgallery.min.js" type="text/javascript"></script>
        <script src="/templates/home/lightgallery/js/lg-video.min.js" type="text/javascript"></script>
        <!--<script src="/templates/resume/resume_files/wow.min.js" type="text/javascript"></script>-->
        <script src="/templates/resume/resume_files/resume.js" type="text/javascript"></script>        
    </body>
</html>