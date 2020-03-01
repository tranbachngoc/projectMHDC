<?php $this->load->view('home/common/header'); ?>
<?php //$this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<script >
jQuery(document).ready(function(){
	hiddenProductViaResolutionCategory('showCateGoRyScren');	 
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});	
	var isCtrl = false; 
	jQuery(document).keyup(function (e) { 
		if(window.event)
        {
             key = window.event.keyCode;     //IE
             if(window.event.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
        else
        {
             key = e.which;     //firefox
             if(e.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
		if(isCtrl){
			if(key == 109 || key == 189)
			{
				// zoom out
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
			if(key == 107 || key == 187)
			{
				// zoom in
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
		}
	});
});
</script>


<div id="main" class="container">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url()?>">Azibai</a></li>
		<li><span>Gian hàng bách hóa</span></li>
	</ol>
	
	<!--div class="page-title">
		<h1>Danh mục sản phẩm</h1>
	</div-->
	<?php if(count($reliableProduct) > 0){ ?>
	<h2><?php echo $this->lang->line('title_reliable_category'); ?></h2>
	<?php } ?>

		<div id="logoCarousel" class="carousel slide" data-ride="carousel">
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<?php for($i=0;$i<6;$i++){?>
						<img src="<?php echo base_url()?>images/banner/logo-pn<?php echo $i ?>.jpg"/>
					<?php }?>
				</div>

				<div class="item">
					<?php for($i=0;$i<6;$i++){?>
						<img src="<?php echo base_url()?>images/banner/logo-pn<?php echo $i ?>.jpg"/>
					<?php }?>
				</div>

				<div class="item">
					<?php for($i=0;$i<6;$i++){?>
						<img src="<?php echo base_url()?>images/banner/logo-pn<?php echo $i ?>.jpg"/>
					<?php }?>
				</div>

				<div class="item">
					<?php for($i=0;$i<6;$i++){?>
						<img src="<?php echo base_url()?>images/banner/logo-pn<?php echo $i ?>.jpg"/>
					<?php }?>
				</div>
			</div>

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#logoCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#logoCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>


	<div class="row">
	<script>
		$(document).ready(function() {
			 $('.down,.up').click(function (){
				var targetDiv = $(this).attr('href');
				$('html, body').animate({
					scrollTop: $(targetDiv).offset().top
				}, 1000);				
			 });			 
		});
	</script>
	
	<?php foreach($categoryViewPage as $category) { ?> 
		<?php if($category->levelQ == 0 ) { ?>
			<div id="tang_<?php echo $category->cat_id ?>" style="padding:15px;">
				<div class="tang">
					<div class="">
					Tầng <?php echo $category->cat_id ?><span class="pull-right"><a href="#tang_<?php echo $category->cat_id - 1 ?>" class="up"><i class="fa fa-chevron-up fa-fw "></i></a> <a href="#tang_<?php echo $category->cat_id + 1 ?>" class="down"><i class="fa fa-chevron-down fa-fw "></i></a></span>
					</div>
					<?php if($category->levelQ == 1)  {?>
					<div><?php echo $category->cat_name; ?></div>
					<?php }?>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-4" style="height:600px; padding:15px;">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">			
									<img src=" <?php echo base_url().'images/icon/icon'.$category->cat_id.'.png'?>"/> <?php echo $category->cat_name; ?>
								</a>
							</div>
							<div class="panel-body">
								<ul class="supcategory" style="height:266px; overflow:hidden;">
									<?php foreach($categoryViewPage as $category) { ?>	
										<?php if($category->levelQ == 1 ) { ?>
											<li><?php echo $category->cat_name; ?></li>
										<?php } ?>
									<?php } ?>
								</ul>
								<div class="logobrand">
									<img src="<?php echo base_url()?>images/banner/logobrand.png" class="img-responsive"/>
								</div>
							</div>	
						</div>						
					</div>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<div class="col-md-6" style="height:600px; overflow:hidden;">
								<div class="row">
								
									<div class="col-sm-6" style="padding:15px">
										<div class="product-item">
											<div><a href="<?php echo base_url()?>bigphone2/product/detail/696/samsung-galaxy-note-3-samsung-sm-n9002-galaxy-note-iii-57-inch-phablet-16gb.html">
											<img src="<?php echo base_url()?>media/images/product/30122015/7f0fa2c382173305f38816271dbfaf25.jpg" id="690" class="img-responsive" alt="Samsung Galaxy Note 3 (Samsung SM-N9002/ Galaxy Note III) 5.7 inch Phablet 16GB">
											<span  class="pro_name">Samsung Galaxy Note 3 (Samsung SM-N9002/ Galaxy Note III) 5.7 inch Phablet 16GB</span>
											</a></div>	
											<div class="sale-price">6,500,000 VND</div>
										</div>
									</div>	
										
									<div class="col-sm-6" style="padding:15px">
										<div class="product-item">
											<div><a href="<?php echo base_url()?>bigphone2/product/detail/690/apple-iphone-4s-16gb-black-ban-quoc-te-cu.html">
											<img src="<?php echo base_url()?>/media/images/product/30122015/aa768de696d700b51ef310c0de79ff27.png" id="690" class="img-responsive" alt="Apple iPhone 4S 16GB Black (Bản quốc tế) (Cũ) ">
											<span  class="pro_name">Apple iPhone 4S 16GB Black (Bản quốc tế) (Cũ) </span>
											</a></div>	
											<div class="sale-price">2,500,000 VND</div>
										</div>
									</div>
									
									<div class="col-sm-6" style="padding:15px">
										<div class="product-item">
											<div><a href="<?php echo base_url()?>bigphone2/product/detail/691/apple-iphone-4s-16gb-white-ban-quoc-te-cu.html">
											<img src="<?php echo base_url()?>media/images/product/30122015/9fd253c508bb92b6d9eda532951e661b.jpg" id="690" class="img-responsive" alt="Apple iPhone 4S 16GB White (Bản quốc tế) (Cũ) ">
											<span  class="pro_name">Apple iPhone 4S 16GB White (Bản quốc tế) (Cũ) </span>
											</a></div>	
											<div class="sale-price">3,500,000 VND</div>
										</div>
									</div>
									
									<div class="col-sm-6" style="padding:15px">
										<div class="product-item">
											<div><a href="<?php echo base_url()?>bigphone2/product/detail/692/apple-iphone-5-16gb-black-ban-quoc-te-cu.html">
											<img src="<?php echo base_url()?>media/images/product/30122015/aa768de696d700b51ef310c0de79ff27.png" id="690" class="img-responsive" alt="Apple iPhone 5 16GB Black (Bản quốc tế) (Cũ) ">
											<span  class="pro_name">Apple iPhone 5 16GB Black (Bản quốc tế) (Cũ) </span>
											</a></div>	
											<div class="sale-price">3,790,000</div>
										</div>
									</div>
								
								</div>
							</div>
							<div class="col-md-6" style="height:600px; overflow:hidden;">
								<div class="row">									
									<div style="float:left; width:50%; height:50%;">
										<div style="padding:15px">
										<img src="<?php echo base_url()?>/images/banner/bach-hoa-2-1.png" class="img-responsive">
										</div>
									</div>
									<div style="float:left; width:50%; height:50%;">
										<div style="padding:15px">
										<img src="<?php echo base_url()?>images/banner/bach-hoa-2-2.jpg" class="img-responsive"/>
										</div>
										<div style="padding:15px">
										<img src="<?php echo base_url()?>images/banner/bach-hoa-2-3.png" class="img-responsive"/>
										</div>
									</div>									
								</div>
							</div>
						</div>
						
					</div>
				</div>	
			</div>
		<?php } ?>
	<?php } ?>
	</div>
</div>
<!-- END CENTER-->
<div id="sidebar">
	<?php $this->load->view('home/common/left_tintuc'); ?>
</div>

<?php //$this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>
