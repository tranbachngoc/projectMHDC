<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="http://azibai.com/templates/home/images/favicon.png" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <title>Azibai - Sàn thương mại điện tử, giải pháp kinh doanh trực tuyến</title>
    <meta name="Azibai, sàn thương mại điện tử, kinh doanh online, giải pháp kinh doanh trực tuyến" /> 
    <meta name="description" content="Azibai là nhà cung cấp giải pháp kinh doanh trực tuyến. Chúng tôi giúp cho các doanh nghiệp đạt mục tiêu tăng doanh thu, tăng lợi nhuận và giảm chi phí bán hàng." />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	 <meta content="Azibai - sàn thương mại điện tử, giải pháp kinh doanh trực tuyến" property="og:title"/>
     <meta content="Azibai là nhà cung cấp giải pháp kinh doanh trực tuyến. Chúng tôi giúp cho các doanh nghiệp đạt mục tiêu tăng doanh thu" property="og:description"/>
     <meta content="http://azibai.com/dich-vu/images/azibai-solutions.jpg" property="og:image"/>  
    <link href="css/css.css" rel="stylesheet" type="text/css"/>   
    <link href="css/font-awesome.min.css" rel="stylesheet"/>	
    <link rel="stylesheet" href="assets/stylesheet/lib/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/stylesheet/lib/bootstrap-theme.min.css" />  
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="css/owl.theme.css" />
	<link rel="stylesheet" href="assets/stylesheet/style.css" />	
    </head>
<body class="green-color">
<!-- Header -->
    <header id="header" class="gray">       
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-4 col-xs-4">
                        <!-- Logo -->
                        <h1 class="logo"><a href="/"><img src="img/logo-azibai.png" alt="Azibai giải pháp kinh doanh trực tuyến"/></a></h1>
                        <!-- End Logo -->
                    </div>
                    <!-- Social Media Share -->
                    <div class="col-md-6 col-sm-8 col-xs-8 social">
                        <a href="https://www.twitter.com/azibaiglobal" class="wow animated bounceIn icon-t" data-wow-delay=".75s"><i class="fa fa-twitter"></i></a>
						<a href="https://www.facebook.com/azibai" class="wow animated bounceIn" data-wow-delay=".75s"><i class="fa fa-facebook"></i></a>
                        <a href="https://www.google.com/+azibaiglobal" class="wow animated bounceIn" data-wow-delay="1s">
                        <i class="fa fa-google-plus" aria-hidden="true"></i></a>
                    </div>
                    <!-- End Social Media Share -->
                </div>                        
                <!-- Subscription --> 
            </div>
        </div>
			 <div id="main-banner" class="container">
				<!-- Header Content Start -->
				<div class="header_content">
					<h1>Sàn thương mại điện tử azibai</h1>
					<h4>Giải pháp kinh doanh trực tuyến toàn diện.</h4>
				</div>
            <!-- Header Content End -->
			</div>
    </header> <br/>
<?php

		define('BASEPATH', '');
		
		$product_ids = "1135,1161,698,607,578,983,602,695,469,378,278,1125,304,534,940,1059,874,138,282,142,1243,87,76,32,35,38,46,44,1233,1013,1205,741,500,
						815,561,586,928,512,398,597,214,434,619,908,113,399,1070,54,17,1233,1108,994,620,689,428,622,1284";

		require_once('../system/application/config/database.php');
		require_once('functions.php');
		$data = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

		if ($data->connect_error) {
			die("Connection failed");
		}
		mysqli_set_charset( $data, 'utf8'); 
		//pro_user=2012 --giaiphap
		/*
		$sql = "SELECT pro_id, pro_name, pro_cost, pro_currency, pro_category, pro_user, pro_image, pro_dir, pro_saleoff_value, pro_type_saleoff, pro_saleoff 
				FROM tbtt_product WHERE pro_status=1 AND pro_user IN (1482,1465,1483,1466,1527,1496,1546,1547,1429,1559,1680,1681,2064,1596,1765,1592,1504,1471,1868,1534) 
				GROUP BY pro_user ORDER BY pro_user DESC, pro_id DESC LIMIT 50 ";
		*/		
       $sql_product = "SELECT pro_id, pro_name, pro_cost, pro_currency, pro_category, pro_user, pro_image, pro_dir, pro_saleoff_value, pro_type_saleoff, pro_saleoff 
				FROM tbtt_product WHERE pro_status=1 AND pro_id IN (".$product_ids.") 
				ORDER BY pro_id DESC";
				$result = $data->query($sql_product);
				//$rows = $result->fetch_assoc();	echo $rows["pro_name"];	
				while($row = $result->fetch_array())
					{
						$rows[] = $row;
					}	
?>	
	<div class="container">
		   <div class="gallery-wrapper">
		    <div class="gallery-head"><h3>Sản phẩm xem nhiều</h3></div>
				<!--  Start -->
			<div id="gallery">
        	   <div class="container gallery_wrapp">                   
                <!-- Screenshot Slider Start -->  
                 <div class="screenshot_slider_wrapp">
                    <div id="screenshot_slider" class="brand_slider hidden-buttons">
                        <div class="slider-items slider-width-col6">
						 <?php 
						 
							foreach($rows as $product) { 
							//echo $product["pro_type_saleoff"];
							 $img_thumb = explode(',', $product["pro_image"]);
							 /*
								 if (file_exists('/media/images/product/'. $product["pro_dir"].'/thumbnail_3_'.$img_thumb[0])){
									
									$img_file = '/media/images/product/'. $product["pro_dir"].'/thumbnail_3_'.$img_thumb[0];		
									 
								 } else {
									 
									$img_file = '/media/images/no_photo_icon.png'; 
								 }
						      */
						 ?>
                            <div class="item">
                                <div class="col-item">
                                    <div class="item-inner">
                                        <div class="product-wrapper">
                                            <div class="thumb-wrapper">
											   <div class="img-box">
													<a href="/<?php echo $product["pro_category"].'/'.$product["pro_id"].'/'. clean_url($product["pro_name"]);?>">
														<img src="<?php echo '/media/images/product/'. $product["pro_dir"].'/thumbnail_3_'.$img_thumb[0]; ?>" alt="<?php echo $product["pro_name"];?>" />																											
													</a>
												</div>
												     <a href="/<?php echo $product["pro_category"].'/'.$product["pro_id"].'/'. clean_url($product["pro_name"]);?>">
														<h4><?php echo $product["pro_name"];?></h4>													
													</a>	
												<div><span class="<?php if($product["pro_saleoff"]){ echo "promotion"; } else { echo "product-price";}?>"><?php echo number_format($product["pro_cost"],'0','','.');?> đ</span>
												<span class="promotion-price">
												<?php 
												    if($product["pro_type_saleoff"]==1){ 
													
														$promotion_price = $product["pro_cost"] - ($product["pro_cost"]*($product["pro_saleoff_value"]/100));
														
													} else {
														
														$promotion_price = $product["pro_cost"] - $product["pro_saleoff_value"];
													}
													
													if($product["pro_saleoff"] >0 && $promotion_price > 0 ){ echo number_format($promotion_price,'0','','.')." đ"; }
												?></span></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
						 <?php } 
							mysqli_close($data);
						 ?>													 
                        </div>
                    </div>
               </div>
                <!-- Screenshot Slider End -->
            </div>
        </div>
<!-- Screenshot End -->	
			</div>
	  </div> 
       <section id="content">
        <div class="container">
            <div class="row">            
            <div class="col-md-12 col-xs-12"><br /><h3 class="head-user"><i class="fa fa-hand-o-right"></i> Bạn muốn tham gia azibai.com với vai trò</h3>             
                 <div class="col-md-4 col-xs-11 new-user">
                        <a href="/register" class="fa fa-angle-right" data-smoothscroll="true"> Người mua hàng </a>
                </div>
                <div class="col-md-4 col-xs-11 new-user">
                        <a href="/discovery" class="fa fa-angle-right" data-smoothscroll="true"> Người bán hàng </a>
                </div>
                <div class="col-md-4 col-xs-11  new-user">
                        <a href="/register/affiliate" class="fa fa-angle-right" data-smoothscroll="true"> Đại lý bán lẻ online </a>
                </div>                            
            </div>
            </div><br /><br /><br />
			<div class="col-md-12 col-xs-12"><i class="fa fa-user"></i> Đã có tài khoản trên azibai.com? <a href="/login">Click vào đây để đăng nhập...</a><br /><br /><br /></div>
        </div>
    </section>   
     
       
    <!-- Footer -->
    <footer>
        <div class="container wow animated fadeInUp">
            <div class="col-lg-3 col-md-4 col-sm-5 social">
                <p><strong>Kết nối với Azibai</strong></p>
                <a href="https://www.twitter.com/azibaiglobal"><i class="fa fa-twitter-square"></i></a>
                <a href="https://www.facebook.com/azibai"><i class="fa fa-facebook-square"></i></a>   
                <a href="https://www.google.com/+azibaiglobal"><i class="fa fa-google-plus-square"></i></a>
             </div>
            <div class="col-lg-5 col-md-4 col-sm-6 blog">
                <span><strong>CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI</strong></span><br />
                <span><strong>Địa chỉ:</strong>  92 Trần Quốc Toản, Phường 8, Quận 3, Tp HCM</span>
                <br/>
                <span><strong>Mã số thuế:</strong> 0314 300068</span>  
               <br/>
                <span><strong>Điện thoại:</strong> 0919575925</span>
                <br />
                <span><strong>Email:</strong> <?=settingEmail_1?></span>              
            </div>                  
            <div class="col-lg-3 col-md-4 col-sm-5" style="margin:10px 0px;"><a href="http://online.gov.vn/WebsiteDisplay.aspx?DocId=32369" target="_blank"><img class="img-responsive" src="/images/dadangky.png" /></a></div>
            <div class="col-md-12 copyright"><hr />
                <span>&copy; 2016 Azibai.com. All rights reserved.</span>               
            </div>
        </div>       
    </footer>
    <!-- End Footer -->
	<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/owl.carousel.min.js"></script>  
    <script type="text/javascript" src="js/js-functions.js"></script>

</body>
</html>