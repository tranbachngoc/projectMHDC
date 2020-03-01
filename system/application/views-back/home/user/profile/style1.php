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
        <meta property="og:description" content="<?php echo $resume->fullname . ' | ' . $resume->company_name . ' | Giới tính: ' . ($resume->sex == 1 ? 'Nam' : 'Nữ') . ' | Ngày sinh: ' . date('d/m/Y', $resume->birthday) . ' | Tôn giáo: ' . $resume->religion . ' | Điện thoại: ' . $resume->mobile . ' | Email: ' . $resume->email . ' | Học vấn: ' . $resume->education . ' | Nơi sống: ' . $resume->accommodation . ' | Sở thích: ' . $resume->favorites ?>"/>
	<?php if ($resume->banner) { ?>
    	<meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->banner; ?>"/>
	<?php } else { ?>
    	<meta property="og:image" content="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg'; ?>"/>
	<?php } ?>
        <link href="/templates/resume/resume_files/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/home/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/resume/resume_files/resume_style_1.css" rel="stylesheet" type="text/css"/>
        <link href="/templates/resume/resume_files/owl.carousel.min.css" rel="stylesheet" type="text/css"/>

        <link href="/templates/home/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet" type="text/css"/>
        <!--<link href="/templates/resume/resume_files/animate.css" rel="stylesheet" type="text/css"/>-->
        <title><?php echo $resume->fullname . ' | ' . $resume->company_name ?></title>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>        
        <style>
           
	    #about {
		<?php if ($resume->banner) { ?> 
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->banner; ?>) no-repeat center;
		<?php } else { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/banner.jpg' ?>) no-repeat center;
		<?php } ?>                
                background-attachment: scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            #quotes {
		<?php if ($resume->slogan_bg) { ?> 
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->slogan_bg; ?>) no-repeat center;
		<?php } else { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg1.jpg'; ?>) no-repeat center;
		<?php } ?>
                background-attachment: scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            #statistics {
		<?php if ($resume->statistic_bg) { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->statistic_bg ?>) no-repeat center;
		<?php } else { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg2.jpg'; ?>) no-repeat center;
		<?php } ?>
                background-attachment: scroll;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            #testimonials {
		<?php if ($resume->customer_bg) { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $resume->customer_bg; ?>) no-repeat center;
		<?php } else { ?>
    		background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/bg3.jpg'; ?>) no-repeat center;
		<?php } ?>
                background-attachment: scroll;                
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }  
	    
	    
        </style>        
    </head>




    <body>
	<div id="header">
	    <div class="container">
		<button class="pull-right btn btn-default" onclick="openNav()"><i class="fa fa-bars"></i></button>
               
		<a id="logo" href="#">
		    <?php if($resume->logo) { ?>
		    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/'.$resume->userid.'/'.$resume->logo; ?>" alt=""/>
		    <?php } else { ?>
		    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/logo.jpg'; ?>" alt=""/>
		    <?php } ?>
		</a>
                
		<div id="mySidenav" class="sidenav">
		    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>		    
		    <ul class="main-nav">
                                
                                <li id="menu-item-2" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#about" class="">
                                        <i class="fa-fw fa fa-user"></i>
                                        <span>GIỚI THIỆU</span>
                                    </a>
                                </li>
								<?php if($resume->show_company==1) { ?>
								<li id="menu-item-1" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#company" class="nav-active">
                                        <i class="fa-fw fa fa-university"></i>
                                        <span>CÔNG TY</span>
                                    </a>
                                </li>
								<?php } ?>
								<?php if($resume->show_slogan==1) { ?>
								<li id="menu-item-1" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#quotes" class="nav-active">
                                        <i class="fa-fw fa fa-file"></i>
                                        <span>LOGAN</span>
                                    </a>
                                </li>
								<?php } ?>
                                <?php if($resume->show_service==1) { ?>
                                <li id="menu-item-3" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#services" class="">
                                        <i class="fa-fw fa fa-list"></i>
                                        <span>DỊCH VỤ</span>
                                    </a>
                                </li>  
								<?php } ?>
                                <?php if($resume->show_statistic==1) { ?>
                                <li id="menu-item-3" class="menu-item menu-item-type-post_type menu-item-object-page">
                                    <a href="#statistics" class="">
                                        <i class="fa-fw fa fa-line-chart"></i>
                                        <span>THỐNG KÊ</span>
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
                                        <i class="fa-fw fa fa-pencil-square-o"></i>
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
				<?php } ?>
                            </ul>
		</div>
                
            </div>
	</div>
 
    <div id="about" class="section about">            
            <div class="overlay text-center">              
				    
		<h1 class="fullname">
		    <span><?php echo $resume->fullname ? $resume->fullname : 'Họ & Tên'; ?></span>
		    <br>
		    <span class="career">                                
			<?php
			if ($resume->career) {
			    echo $resume->career;
			} else {
			    echo 'Chưa nhập ngành nghề';
			}
			?>                                            
		    </span> 
                </h1>
		<br>
		<div class="folowme">
		    <a href="<?php echo $resume->facebook ?>" class="btn btn-primary"><i class="fa fa-facebook fa-fw"></i></a> &nbsp;
		    <a href="<?php echo $resume->twitter ?>" class="btn btn-info"><i class="fa fa-twitter fa-fw"></i></a> &nbsp;
		    <a href="<?php echo $resume->google ?>" class="btn btn-danger"><i class="fa fa-google-plus fa-fw"></i></a>
		</div>
		<br>
                <div class="learn-more">
                    <a href="#about" data-toggle="modal" data-target=".learn-more-modal">
                        <div class="text">Xem thêm thông tin về tôi</div>
                        <div class="icon">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </a>
                </div>                
            </div>                
        </div>
        <div class="modal fade learn-more-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	    <div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-body">
			<?php if ($resume->avatar != "") { ?><p class="text-center"><img class="img-circle" style="width:120px;height: 120px" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $resume->avatar; ?>"/></p><?php } ?>
			<?php if ($resume->fullname != "") { ?><div><em class="pull-left">Họ & Tên</em> <p style="margin-left:90px;"><?php echo $resume->fullname; ?></p></div><?php } ?>
			<?php if ($resume->sex != "") { ?><div><em class="pull-left">Giới tính</em> <p style="margin-left:90px;"><?php echo $resume->sex == 1 ? 'Nam' : 'Nữ'; ?></p></div><?php } ?>
			<?php if ($resume->birthday != "") { ?><div><em class="pull-left">Ngày sinh</em> <p style="margin-left:90px;"><?php echo date('d/m/Y', strtotime($resume->birthday)) ?></p></div><?php } ?>
			<?php if ($resume->religion != "") { ?><div><em class="pull-left">Tôn giáo</em> <p style="margin-left:90px;"><?php echo $resume->religion ?></p></div><?php } ?>
			<?php if ($resume->mobile != "") { ?><div><em class="pull-left">Điện thoại</em> <p style="margin-left:90px;"><a href="tel:<?php echo $resume->mobile; ?>"><?php echo $resume->mobile ?></a></p></div><?php } ?>
			<?php if ($resume->email != "") { ?><div><em class="pull-left">Email</em> <p style="margin-left:90px;"><a href="mailto:<?php echo $resume->email; ?>"><?php echo $resume->email ?></a></p></div><?php } ?>
			<?php if ($resume->education != "") { ?><div><em class="pull-left">Học vấn</em> <p style="margin-left:90px;"><?php echo $resume->education ?></p></div><?php } ?>
			<?php if ($resume->accommodation != "") { ?><div><em class="pull-left">Nơi sống</em> <p style="margin-left:90px;"><?php echo $resume->accommodation ?></p></div><?php } ?>
			<?php if ($resume->marriage != "") { ?><div><em class="pull-left">Hôn nhân</em> <p style="margin-left:90px;"><?php echo $resume->marriage ?></p></div><?php } ?>
			<?php if ($resume->favorites != "") { ?><div><em class="pull-left">Sở thích</em> <p style="margin-left:90px;"><?php echo $resume->favorites ?></p></div><?php } ?>
			<?php if ($resume->sayings != "") { ?><div><em class="pull-left">Câu nói<br>yêu thích</em> <p style="margin-left:90px;"><?php echo $resume->sayings ?></p></div><?php } ?>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>                            
		    </div>
		</div>
	    </div>
	</div>
	<?php if ($resume->show_company == 1) { ?>
    	<div id="company" class="section company">  
    	    <div class="overlay">  
    		<div class="container">
    		    <header class="heading text-center">
    			<h2><span class="title">CÔNG TY</span> <br> <span class="small"> <?php echo $resume->company_name ? $resume->company_name : 'Chưa cập nhật công ty'; ?></span></h2>
    		    </header>
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
	<?php } ?>

	<?php if ($resume->show_slogan == 1) { ?>
    	<div id="quotes" class="section quotes">
    	    <div class="overlay" style="padding: 100px 0">
    		<div class="container">
    		    <div class="sr_quote text-center">
					<p class="lead">
						<i class="fa fa-quote-left"></i>
						<?php echo $resume->slogan ? $resume->slogan : 'Chưa cập nhật câu slogan !'; ?>
						<i class="fa fa-quote-right"></i>
					</p>
					<div class="sr_quote-author">-- <?php echo $resume->slogan_by ? $resume->slogan_by : 'Chưa cập nhật' ?> --</div>
    		    </div>
    		</div>
    	    </div>
    	</div>
	<?php } ?>

	<?php if ($resume->show_service == 1) { ?>
    	<div id="services" class="section services">
    	    <div class="overlay">           
    		<div class="container">
    		    <header class="heading text-center">
					<h2><span class="title"><?php echo $resume->title_service ? $resume->title_service : 'DỊCH VỤ' ?></span></h2>                    
    		    </header>
				<?php if($resume->service_desc) { ?>
    		    <div class="row-fullwidth box-shadow" style="margin-bottom: 40px;">
					<p style="text-align: justify;">
						<?php echo $resume->service_desc ?>
					</p>
    		    </div>
				 <?php } ?>
				<?php $services = json_decode($resume->list_service); ?>
				<div id="owl_service" class="owl-carousel">
				<?php foreach ($services as $key => $value) { ?>			    
					<?php if ($value->image && $value->title && $value->desc) { ?>			    
					<div class="text-center">
						<?php if ($value->image) { ?>
						<img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>" alt="placeholder-img">
						<?php } else { ?>
						<img style="margin:0 auto;" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png'; ?>" alt="placeholder-img">
						<?php } ?>
						<div class="ib_content">	    					
						<div class="ib_description" style="padding: 10px 20px;">
							<h4 class="ib_title">
							<?php echo $value->title ? $value->title : 'Tên dịch vụ'; ?>
							</h4>
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
	<?php } ?>

	<?php if ($resume->show_statistic == 1) { ?>
    	<div id="statistics" class="statistics section">
    	    <div class="overlay">
    		<div class="container">
    		    <header class="heading text-center">
    			<h2><span class="title">THỐNG KÊ</span></h2>
    		    </header>
    		    <br>
    		    <div class="row">
			    <?php $statistic = json_decode($resume->statistic); ?>
			    <?php foreach ($statistic as $key => $value) { ?>
				<div class="col-md-3 col-sm-3 col-xs-6" style="margin-bottom: 30px;">
				    <div class="statistic_number">
					<span class="number"><?php echo $value->number ?></span>
					<div><?php echo $value->label ?></div>
				    </div>
				</div>
			    <?php } ?>
    		    </div>
    		</div>                
    	    </div>
    	</div> 
	<?php } ?>

	<?php if ($resume->show_product == 1) { ?>
    	<div id="portfolio" class="section portfolio">
    	    <div class="overlay">           
    		<div class="container">
    		    <header class="heading text-center">
					<h2><span class="title"><?php echo $resume->title_product ? $resume->title_product : 'SẢN PHẨM' ?></span></h2>
    		    </header>
				<?php if($resume->product_desc) { ?>
					<div class="desc" style="margin-bottom: 40px;">
						<?php echo $resume->product_desc ?>
					</div>
				<?php } ?>				
    		    
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
    		    <ul class="tabfilter list-inline text-center" role="tablist">
			<li role="presentation" class="active"><a href="#all" class="" aria-controls="all" role="tab" data-toggle="tab">Tất cả</a></li>
		    <?php
		    foreach ($product_cat as $key => $value) {
			if ($value != "") {
			    ?>
			<li role="presentation"><a href="#tab<?php echo $key + 1 ?>" class="" aria-controls="<?php echo RemoveSign($value) ?>" role="tab" data-toggle="tab"><?php echo $value ?></a></li>
			    <?php
			}
		    }
		    ?>
    		    </ul>
    		    <div class="tab-content" style="padding: 10px">
    			<div role="tabpanel" class="row tab-pane fade in active" id="all">
				<?php foreach ($product_list_all as $key => $value) { ?>
				    <?php if ($value->image != '') { ?>
	    			    <div class="proitem <?php echo RemoveSign($value->cat) ?> col-xs-6 col-sm-4 col-md-3" style="padding:5px">
					    <?php
					    if ($value->image) {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					    } else {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					    }
					    ?>
					    <div class="fix4x3">
	    					<div class="c" style="background: url('<?php echo $imgsrc; ?>') no-repeat center ;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	    				    </div>
					    	    				    	    				    
					    <div class="zoomex">
						<a href="<?php echo $imgsrc; ?>" class="zoomlink1">
						    <i class="fa fa-plus"></i>
						</a>

						<a href="<?php echo $value->url ?>" class="zoomlink2">
						    <i class="fa fa-link"></i>
						</a>
					    </div>
	    			    </div>
				    <?php } ?>
				<?php } ?>
    			</div>                   
    			<div role="tabpanel" class="row tab-pane fade" id="tab1">
				<?php foreach ($product_list_0 as $key => $value) { ?>
				    <?php if ($value->image != '') { ?>
	    			    <div class="proitem <?php echo RemoveSign($value->cat) ?> col-xs-6 col-sm-4 col-md-3" style="padding:5px">

					    <?php
					    if ($value->image) {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					    } else {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					    }
					    ?>
	    				<figure>
	    				    <div class="fix4x3">
	    					<div class="c" style="background: url('<?php echo $imgsrc; ?>') no-repeat center ;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	    				    </div>
	    				    <div class="zoomex">
	    					<a href="<?php echo $imgsrc; ?>" class="zoomlink1">
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
				    <?php if ($value->image != '') { ?>
	    			    <div class="proitem <?php echo RemoveSign($value->cat) ?> col-xs-6 col-sm-4 col-md-3" style="padding:5px">

					    <?php
					    if ($value->image) {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					    } else {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					    }
					    ?>
	    				<figure>
	    				    <div class="fix4x3">
	    					<div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	    				    </div>
	    				    <div class="zoomex">
	    					<a href="<?php echo $imgsrc; ?>" class="zoomlink1">
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
				    <?php if ($value->image != '') { ?>
	    			    <div class="proitem <?php echo RemoveSign($value->cat) ?> col-xs-6 col-sm-4 col-md-3" style="padding:5px">

					    <?php
					    if ($value->image) {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					    } else {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					    }
					    ?>
	    				<figure>
	    				    <div class="fix4x3">
	    					<div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	    				    </div>
	    				    <div class="zoomex">
	    					<a href="<?php echo $imgsrc; ?>" class="zoomlink1">
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
				    <?php if ($value->image != '') { ?>
	    			    <div class="proitem <?php echo RemoveSign($value->cat) ?> col-xs-6 col-sm-4 col-md-3" style="padding:5px">

					    <?php
					    if ($value->image) {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					    } else {
						$imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					    }
					    ?>
	    				<figure>
	    				    <div class="fix4x3">
	    					<div class="c" style="background: url('<?php echo $imgsrc; ?>') center no-repeat;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"></div>
	    				    </div>
	    				    <div class="zoomex">
	    					<a href="<?php echo $imgsrc; ?>" class="zoomlink1">
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
    	</div>
	<?php } ?>

	<?php if ($resume->show_customer == 1) { ?>
    	<div id="testimonials" class="testimonials section">
            <?php $customers = json_decode($resume->list_customer); ?>
    	    <div class="overlay">
    		<div class="container">
    		    <header class="heading">
					<h2 class="text-center">
						<span class="title"><?php echo $resume->title_customer != '' ? $resume->title_customer : 'Ý KIẾN KHÁCH HÀNG' ?></span>			    
					</h2>
    		    </header>                    
    		    <div id="owl_testimonials" class="owl-carousel">                        
			<?php foreach ($customers as $key => $value) { ?>  
			    <?php if ($value->image && $value->say && $value->name) { ?>
			    <div class="item text-center">	    			  
				<p>
				    <?php if ($value->url != '') { ?>
				    <a class="video" href="<?php echo $value->url ?>" target="_blank" style="color: #fff;">
					<?php } ?>

					<?php if ($value->image) { ?>
					    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>" />
					<?php } else { ?>
					    <img class="img-circle" style="width:150px; margin: 0 auto;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/default/default-avatar.png'; ?>" />
					<?php } ?>

					<?php if ($value->url != '') { ?>
					<br>
					Xem video
				    </a>
				    <?php } ?>                                    
				</p>                                
				<p>
				    <i class="fa fa-quote-left fa-fw"></i> &nbsp;
					<?php echo $value->say ? $value->say : 'Lorem Ipsum đã được sử dụng như một văn bản chuẩn cho ngành công nghiệp in ấn từ những năm 1500, khi một họa sĩ vô danh ghép nhiều đoạn văn bản với nhau để tạo thành một bản mẫu văn bản.' ?> 
				    &nbsp; <i class="fa fa-quote-right fa-fw"></i> 
				</p>
				<p>
				    <strong><?php echo $value->name ? $value->name : 'Tên khách hàng'; ?></strong>
				</p>
			    </div>
			    <?php } ?>
			<?php } ?>                            
    		    </div>                    
    		</div>
    	    </div>
    	</div>
	<?php } ?>

	<?php if ($resume->show_certification == 1) { ?>
    	<div id="certification" class="section">
    	    <div class="overlay">           
    		<div class="container">
    		    <header class="heading text-center">
					<h2><span class="title"><?php echo $resume->title_certification ? $resume->title_certification : 'CHỨNG NHẬN' ?></span></h2>
    		    </header>
    		    <br>
			<?php
			$certification = json_decode($resume->certification);
			?>
		    <div id="owl_certification" class="owl-carousel">                        
			    <?php
			    foreach ($certification as $key => $value) {
				if ($value->image != '') {
				    ?> 
				    <div class="item">
											
					<a class="itemcer" href="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>">
					     <img class="img-responsive" style="margin: auto" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image; ?>"/>
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
	<?php } ?>  


	<?php if ($resume->show_history == 1) { ?>
    	<div id="blog" class="blog section">
    	    <div class="overlay">           
    		<div class="container">
    		    <header class="heading text-center">
    			<h2><span class="title"><?php echo $resume->title_history ? $resume->title_history : 'HOẠT ĐỘNG NỔI BẬT' ?></span></h2>                   
    		    </header>
    		    <br>
                    <?php $historys = json_decode($resume->list_history); ?>
		    <div  id="owl_history" class="owl-carousel">
			<?php foreach ($historys as $key => $value) { ?>
			    <?php if ($value->image && $value->title) { ?>	    			
			    <div class="item">
				    <?php if ($value->youtube) { ?>
					<div class="embed-responsive embed-responsive-16by9">
					    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo get_youtube_id_from_url($value->youtube) ?>?rel=0" frameborder="0" allowfullscreen=""></iframe>
					</div>                                
				    <?php } else { ?>
					<?php
					if ($value->image) {
					    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $resume->userid . '/' . $value->image;
					} else {
					    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/profiles/default/noimage.png';
					}
					?>                                    
					<div class="fix16x9">
					    <?php if($value->url) { ?>
                                                <a target="blank"  class="c" href="<?php echo $value->url ? $value->url : '#' ?>"
                                                   style="background:url('<?php echo $imgsrc ?>') no-repeat center;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
                                                </a>
                                            <?php } else { ?>
                                                <div class="c"
                                                   style="background:url('<?php echo $imgsrc ?>') no-repeat center;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
                                                </div>    
                                            <?php } ?>
					</div>
				    <?php } ?>
				<div style="padding: 10px 20px; margin-bottom: 30px; border-style: solid; border-width: 0px 1px 1px 1px; border-color: #ddd; background:#fff;">
                                    <h4 class="timeline-title"><?php echo $value->title ? $value->title : 'Chưa cập nhật hoạt động'; ?></h4>
				    <?php if($value->date) { ?>  
                                    <p><small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> <?php echo $value->date ?></small></p>
                                    <?php } ?>
				    <p><?php echo $value->text ?></p>
                                    <?php if($value->url) { ?>
                                        <p class="text-center"><a target="blank" href="<?php echo $value->url ?>" class="btn btn-primary">Xem chi tiết</a></p>                                
                                    <?php } ?>   
                                </div>                        
			    </div>                       
			    <?php } ?>   
			<?php } ?>
		    </div>
		    
		</div>
	    </div>
    	</div>
	<?php } ?>
	<?php if ($resume->show_contactUs == 1) { ?>        
    	<div id="contact" class="contact section">
    	    <div class="overlay">
    		<div class="container">
    		    <header class="heading text-center">
    			<h2><span class="title">LIÊN HỆ</span> <br> <span class="small">Nếu quý khách có thắc mắc hay ý kiến phản hồi, đóng góp xin vui lòng điền vào mẫu dưới đây và gửi cho chúng tôi.</span></h2>                    
    		    </header>
    		    <br>
    		    			
						<?php if ($successContact == true) { ?>
						<div class="alert alert-success" role="alert">Bạn đã gửi liên hệ thành công.</div>
						<?php } else { ?>
						<form action="" method="post" class="contact-form" id="contact-contact-formform">                        
							<div class="row">
								<div class="col-sm-4"> 									
									<?php echo form_error('name_contact'); ?>
									<div class="form-group">
									<input type="text" name="name_contact" value="<?php echo $name_contact ?>" size="40" class="form-control input-lg" id="name"  placeholder="Nhập họ và tên">
									</div>
								</div>							
								<div class="col-sm-4">	
									<?php echo form_error('email_contact'); ?>
									<div class="form-group">
									<input type="email" name="email_contact" value="<?php echo $email_contact ?>" size="40" class="form-control input-lg" id="email"  placeholder="Nhập email">
									</div>
								</div>							
								<div class="col-sm-4">	
									<?php echo form_error('subject_contact'); ?>
									<div class="form-group">
										<input type="text" name="subject_contact" value="<?php echo $subject_contact ?>" size="40" class="form-control input-lg" id="subject"  placeholder="Nhập tiêu đề">
									</div>
								</div>
								<div class="col-sm-12">
									<?php echo form_error('content_contact'); ?>
									<div class="form-group">
										<textarea name="content_contact" cols="40" rows="10" class="form-control input-lg" id="message" placeholder="Nhập nội dung liên hệ"><?php echo $content_contact ?></textarea>
									</div>									
								</div>
								<div class="col-sm-4 col-sm-offset-4">
									<div class="form-group text-center">
										<button type="submit" data-text="GỬI EMAIL" class="btn btn-primary btn-block">
											<span>GỬI EMAIL</span>
										</button>  
										<input type="hidden" name="submitconntact" value="submitconntact">                                    
									</div>
								</div>
							</div>	
						</form>
						<?php } ?>                    
					</div>
					
		    </div>
		</div>
	    </div>
	</div>
	
	
	
	
	<?php } ?>
	<footer id="footer" class="page-foot clearfix">
            <div class="container">
                <div class="copyright text-center">Bản quyền © 2017 <?php echo $resume->fullname ?>. Phát triển bởi <a style="color: #fff" href="https://azibai.com">azibai.com</a></div>                
            </div>
        </footer> 
	<?php if ($resume->use_message != '') { ?>
    	<a target="_blank" href="<?php echo str_replace("facebook.com/messages", "messenger.com", $resume->use_message); ?>" id="message" style="position: fixed; bottom:20px; left: 15px; z-index: 9999">
    	    <img src="/templates/resume/resume_files/private-message-on-facebook.png" style="width:40px;"/>
    	</a>
	<?php } ?>

        <!--<a href="javascript:" id="return-to-top" style="display: none;"> <i class="fa fa-chevron-up"></i> </a>-->

        <script src="/templates/home/js/jquery.min.js" type="text/javascript"></script>
        <script src="/templates/resume/resume_files/owl.carousel.js" type="text/javascript"></script>
        <script src="/templates/resume/resume_files/bootstrap.min.js" type="text/javascript" ></script>
        <script src="/templates/home/lightgallery/dist/js/lightgallery.min.js" type="text/javascript"></script>
        <script src="/templates/home/lightgallery/js/lg-video.min.js" type="text/javascript"></script>
        <script>
	    jQuery(function($){
		$('ul.main-nav > li > a').click(function(e){ 
		    e.preventDefault(); 
		    var aTag = $(this).attr('href'); 
		    $('html,body').animate({scrollTop: $(aTag).offset().top - 50},'slow');
		});
		
		$('.learn-more a').click(function(e){ e.preventDefault(); var aTag = $('#company'); $('html,body').animate({scrollTop: $(aTag).offset().top - 50},'slow'); });

	
		$('#owl_testimonials').lightGallery({selector: '.video', download: false }); 
		
		$('#all, #tab1, #tab2, #tab3').lightGallery({selector: '.zoomlink1', download: false });		

		$('#owl_certification').lightGallery({selector: '.video', download: false });  		
		
                $('#owl_certification').lightGallery({selector: '.itemcer', download: false });  		
		
		$('#owl_certification').owlCarousel({ 
		    loop: false, nav: false, dots: true, autoplay:false, autoplayTimeout:3000, autoplayHoverPause:true, 
                    responsive : { 
			0: {items: 1, margin: 0},
			768: {items: 2, margin: 20},
			1000: {items: 4, margin: 20}
		    }	    
		});
		$('#owl_service').owlCarousel({ 
		    loop: false, nav: true, dots: false, autoplay:false, autoplayTimeout:3000, autoplayHoverPause:true,
		    responsive : { 
			0: {items: 1, margin: 0},
			600: {items: 2, margin: 20},
			1000: {items: 3, margin: 20}
		    }
		    	    
		});
		$('#owl_history').owlCarousel({ 
		    loop: false, nav: true, dots: false, autoplay:false, autoplayTimeout:3000, autoplayHoverPause:true,
		    responsive : { 
			0: {items: 1, margin: 0},
			768: {items: 2, margin: 20}
		    }
		    	    
		});
		$('#owl_testimonials').owlCarousel({ 
		    loop: false, nav: false, dots: true, autoplay:false, autoplayTimeout:3000, autoplayHoverPause:true, items: 1		    
		});
	    });

	    function openNav() {
		document.getElementById("mySidenav").style.right = "0";
	    }
	    function closeNav() {
		document.getElementById("mySidenav").style.right = "-200px";
	    }

</script>
    </body>
</html>