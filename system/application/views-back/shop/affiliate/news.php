<?php $this->load->view('shop/affiliate/header'); ?>
<?php $segment = $this->uri->segment(2); ?>
<?php 
    $suffix = !empty($shop->user_af_key) ?  '?af_id='. $shop->user_af_key : '';
?>
<style> img.lazy { display: block; }</style>
<div class="container">    
    <div class="row">    
	<div class="col-md-3 col-sm-3 col-xs-12" style="position: static">
	    <br/>
	    <div class="scrollfixcolume">
		<div class="panel panel-default">
		    <div class="panel-heading">Tin khuyến mãi</div>
		    <div class="panel-body" style="">
			<ul class="list-unstyled">
			    <?php foreach ($news_sale as $key => $item) { ?>
				<?php
                                    $shopdomain = $item->domain ? $protocol . $item->domain :  $protocol . $item->sho_link .'.'. domain_site;  
                                    $item_link = $shopdomain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $suffix;                                    
				    
				    if (strlen($item->not_image)>10){
                                        $item_image =  DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;              
				    } else {
                                        $item_image = '/media/images/noimage.png';
                                    }
				?>
				<div class="media clearfix">
				    <div class="media-left" >
						<a href="<?php echo $item_link ?>">							
							<img class="lazy media-object" style="width:70px; height:70px;" data-src="<?php echo $item_image ?>" alt="<?php echo $item->not_title ?>">
						</a>
				    </div>
				    <div class="media-body">
					<div class="media-heading" style="height: 70px; overflow: hidden;">
					    <a href="<?php echo $item_link ?>"><?php echo $item->not_title ?></a>
					</div>
				    </div>
				</div>
			    <?php } ?>
			</ul>
		    </div>
		    <!--<div class="panel-footer"><a href="/affiliate/product">→ Xem tất cả</a></div>-->
		</div>
		<div class="panel panel-default">
		    <div class="panel-heading">Tin nổi bật</div>
		    <div class="panel-body" style="">

			<ul class="list-unstyled">
			    <?php foreach ($news_hot as $key => $item) { ?>
				<?php				   
                                    $shopdomain = $item->domain ? $protocol . $item->domain :  $protocol . $item->sho_link .'.'. domain_site;  
                                    $item_link = $shopdomain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $suffix; 
				    
                                    if (strlen($item->not_image)>10){
                                        $item_image =  DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;              
				    } else {
                                        $item_image = '/media/images/noimage.png';
                                    }
				?>

				<div class="media clearfix">
				    <div class="media-left" >
						<a href="<?php echo $item_link ?>">							
							<img class="lazy media-object" style="width:70px; height:70px;" data-src="<?php echo $item_image ?>" alt="<?php echo $item->not_title ?>">
						</a>
				    </div>
				    <div class="media-body">
					<div class="media-heading" style="height: 70px; overflow: hidden;">
					    <a href="<?php echo $item_link ?>"><?php echo $item->not_title ?></a>
					</div>
				    </div>
				</div>

			    <?php } ?>
			</ul>
		    </div>
		    <!--<div class="panel-footer"><a href="/affiliate/product">→ Xem tất cả</a></div>-->
		</div>
	    </div>
	</div>
        <div class="col-md-6 col-sm-6 col-xs-12">	
            <br/>
            <div class="newfeeds" id="content">
                <?php foreach ($list_news as $k => $item) { ?>                 
                    <?php $this->load->view('shop/affiliate/item_news', array('item' => $item)); ?>
                <?php } ?> 

                <?php if (!isset($oloadding)) { ?>
                <div class="text-center"></div>
                <?php } ?>
            </div>
            <?php if (isset($oloadding)) { ?>
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin" id="loadding" style="font-size:24px;"></i>
                </div>
            <?php } ?>            
	</div>
        <div class="col-md-3 col-sm-3 col-xs-12" style="position: static">
	    <br/>
	    <div class="scrollfixcolume">
		<div class="panel panel-default">
		    <div class="panel-heading">Top sản phẩm</div>
                    <?php 
                    if(count($products) > 0){
                    ?>
                        <div class="panel-body" style="">
                            <?php
                                foreach($products as $key => $item){
                                    $a = getAliasDomain().'affiliate/product/detail/'.$item->pro_id.'/'.RemoveSign($item->pro_name);                                    
                                    if ($item->domain != '') {
                                       // $a = $protocol . $item->domain .'/affiliate/product/detail/'.$item->pro_id.'/'.RemoveSign($item->pro_name);
                                       $a =  $protocol . $item->domain . '/shop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
                                    } else if ($item->sho_link != '') { 
                                        $a =  $protocol . $item->sho_link . '.' . domain_site . '/shop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
                                    }
                                    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$item->pro_dir.'/thumbnail_2_'. explode(',', $item->pro_image)[0];
                                    if(!empty($item->pro_image)){
                                    }else{
                                        $filename = base_url(). 'media/images/no_photo_icon.png';
                                    }
                                    $afSelect = false;
                                    if ($af_id != '' && $item->is_product_affiliate == 1) {
                                        $this->load->model('user_model');
                                        $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }
                                    $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), true);

                            ?>    
                                <div class="media clearfix">
                                    <div class="media-left" >
                                        <a href="<?php echo $a; ?>">           
                                            <img class="media-object" style="width:70px; height:70px;" src="<?php echo $filename; ?>" id="<?php echo $item->pro_id; ?>" alt="<?php echo $item->pro_name; ?>"/>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading" style="height: 43px; overflow: hidden;">
                                            <a href="<?php echo $a; ?>"><?php echo $item->pro_name; ?></a>					
                                        </div>
                                        <?php if ($item->pro_cost > $discount['salePrice']){ ?>
                                            <span class="sale-price" style="font-size: 16px;"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
                                            <span class="cost-price"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                                        <?php } else { ?>
                                            <span class="sale-price" style="font-size: 16px;"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default btn-sm btn-block" href="/affiliate/product"><i class="fa fa-angle-double-right"></i> Xem tất cả</a>
                        </div>
                    <?php
                    }
                    else{
                        echo '<div class="panel-body" style="">Không có dữ liệu</div>';
                    }
                    ?>
		</div>
		
		<div class="panel panel-default">
		    <div class="panel-heading">Top phiếu mua hàng</div>
                    <?php 
                    if(count($coupons) > 0){
                    ?>
                        <div class="panel-body" style="">
                            <?php
                                foreach($coupons as $key => $item){
                                    $a = getAliasDomain().'affiliate/coupon/detail/'.$item->pro_id.'/'.RemoveSign($item->pro_name);                                    
                                    if ($item->domain != '') {
                                       $a =  $protocol . $item->domain . '/shop/coupon/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
                                    } else if ($item->sho_link != '') { 
                                        $a =  $protocol . $item->sho_link . '.' . domain_site . '/shop/coupon/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
                                    }



                                    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $item->pro_dir .'/thumbnail_2_'. explode(',', $item->pro_image)[0];
                                    if(!empty($item->pro_image)){
                                    }else{
                                        $filename = base_url(). 'media/images/no_photo_icon.png';
                                    }
                                    $afSelect = false;
                                    if ($af_id != '' && $item->is_product_affiliate == 1) {
                                        $this->load->model('user_model');
                                        $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }
                                    $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect);
                                    ?>    
                                <div class="media clearfix">
                                    <div class="media-left" >
                                        <a href="<?php echo $a; ?>">           
                                            <img class="media-object" style="width:70px; height:70px;" src="<?php echo $filename; ?>" id="<?php echo $item->pro_id; ?>" alt="<?php echo $item->pro_name; ?>"/>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading" style="height: 43px; overflow: hidden;">
                                            <a href="<?php echo $a; ?>"><?php echo $item->pro_name; ?></a>					
                                        </div>
                                        <?php if ($item->pro_cost > $discount['salePrice']){ ?>
                                        <span class="sale-price" style="font-size: 16px;"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
                                            <span class="cost-price"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                                        <?php } else { ?>
                                            <span class="sale-price" style="font-size: 16px;"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-default btn-sm btn-block" href="/affiliate/coupon"><i class="fa fa-angle-double-right"></i> Xem tất cả</a>
                        </div>
                    <?php
                    }
                    else{
                        echo '<div class="panel-body" style="">Không có dữ liệu</div>';
                    }
                    ?>
		</div>
		
		<div style="margin-bottom:20px">
		    <a target="blank" href="#">
			<img style="width: 100%;" alt="azibai QC" src="/media/banners/default/banner-hanh-trinh-ket-noi-yeu-thuong-2018.jpg">
                    </a>
		</div>            
		 
	    
	    </div>
	</div>
    </div>
</div>
<script src="/templates/home/js/jquery.countdown.min.js"></script> 
<script> 
jQuery(function($) {
    $('.fixtoscroll').scrollToFixed({ marginTop: function () { var marginTop = $(window).height() - $(this).outerHeight(true) - 0; if (marginTop >= 0) return 75; return marginTop; }, limit: function () { var limit = 0; limit = $('#footer').offset().top - $(this).outerHeight(true) - 0; return limit; } });
    $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
    $('.rowpro .owl-carousel').owlCarousel({ loop: false, margin: 5, nav: true, dots: false, responsive:{ 0:{ items:1 }, 600:{ items:2 } } });    
    $('.lazy').lazy(); 
    var itempost = $('.embed-responsive');
    var tolerancePixel = 200;
    function checkMedia() {
        var scrollTop = $(window).scrollTop() - 170;
                    var scrollBottom = $(window).scrollTop() + $(window).height() + 100;
        itempost.each(function (index, el) {
            var yTopMedia = $(this).offset().top;
            var yBottomMedia = $(this).height() + yTopMedia;
            if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) {
                $(this).find("video").trigger('play');
            } else {
                $(this).find("video").trigger('pause');
            }
        });
    }
    $(document).on('scroll', checkMedia);
    <?php if (isset($oloadding)) { ?>
        var is_busy = false;
        var page = 1;
        var stopped = false;
        $(window).scroll(function() 
        {  
            $element = $('#content');
            $loadding = $('#loadding');
            if($(window).scrollTop() + $(window).height() >= $element.height() - 200) 
            {
                if (is_busy == true){
                    return false;
                }
                if (stopped == true){
                    return false;
                }
                is_busy = true;
                page++;

                $.ajax(
                {
                    type        : 'post',
                    dataType    : 'text',
                    url         : '/home/shop/getListSelect',
                    data        : {page : page},
                    success     : function (result)
                    {   
                        if($.trim(result) == '')
                        {
                            stopped = true;
                            $loadding.addClass('hidden');
                        }
                        $element.append(result);
                        $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
                        $('.rowpro .owl-carousel').owlCarousel({ loop: false, margin: 5, nav: true, dots: false, responsive:{ 0:{ items:1 }, 600:{ items:2 } } });
                        $('.lazy').lazy();
                        var itempost = $('.embed-responsive');
                        var tolerancePixel = 200;
                        function checkMedia() {
                            var scrollTop = $(window).scrollTop() - 170;
                                                            var scrollBottom = $(window).scrollTop() + $(window).height() + 100;
                            itempost.each(function (index, el) {
                                var yTopMedia = $(this).offset().top;
                                var yBottomMedia = $(this).height() + yTopMedia;
                                if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) {
                                    $(this).find("video").trigger('play');
                                } else {
                                    $(this).find("video").trigger('pause');
                                }
                            });
                        }
                        $(document).on('scroll', checkMedia);
                    }
                })
                .always(function()
                { 
                    is_busy = false;
                });
                return false;
            }
        });
    <?php } ?>
}); 
</script>
<?php $this->load->view('shop/affiliate/footer'); ?>
