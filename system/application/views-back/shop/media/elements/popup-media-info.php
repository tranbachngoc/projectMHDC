<link href="/templates/home/css/addnews-v2.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/addnews-preview-v2.js"></script>
<script src="/templates/home/jR3DCarousel/jR3DCarousel.js"></script>
<style type="text/css">
	#modal-show-detail-img .action { display: block; }
	.modal-show-detail  .btn-custom-css {
		border: 1px solid #c4c4c4;
	    padding: 5px 10px;
	    border-radius: 5px;
	    color: #fff;
	    background: unset;
	    font-weight: unset;
    	top: -2px;
	}

	.modal-show-detail  .btn-custom-css img {
		filter: invert(100%);
		font-weight: bold;
	}
	.big-img .az-volume {
	    position: absolute;
	    right: 5px;
	    top: 5px;
	    z-index: 99;
	    cursor: pointer;
	    width: 32px !important;
	    height: auto !important;
	}

	@media (max-width: 768px) {
		.jR3DCarouselGallery .previous.controls { display: none !important}
		.jR3DCarouselGallery .next.controls { display: none !important }
	}
	.position-tag .tag-number-selected.is-active {
	  border: 2px solid #fff;
	}	
	#modal-show-detail-img .tieude-sm { width: 100% }
	.pop-descrip-title .read-more { display: none; }
	.image_main_tag { cursor: pointer; }
	.tag-photo-home-2.tag-selecting.is-active {
	 /* background: rgba(255, 255, 255, 0.6);*/
	  background: rgba(235, 237, 237, 0.6);
	  border: 2px solid #fff;
	}

	.taggd__wrapper.position-tag .tag-photo-home-2 {
	  animation-duration: 2.5s;
	  animation-name: mytwopop;
	    
	}

	.taggd__wrapper.position-tag .tag-photo-home-2 img {
	  animation-duration: 2s;
	  animation-name: myfirstpop;
	    
	}


	.fs-gal-view-detail .current-price {
	  color: white;
	}
	.have-read-more .clearfix{
	  display: none;
	}

	.have-read-more .clearfix:first-child {
	  display: block !important;
	}

	@keyframes myfirstpop {
	    0%   {
	      /*background: rgba(235, 237, 237, 0.8);*/
	      -webkit-transform:  rotate(6deg); /* Safari */
	      -moz-transform:rotate(6deg); /* Firefox 3.6 Firefox 4 */
	      -ms-transform: rotate(6deg); /* IE9 */
	      -o-transform:  rotate(6deg); /* Opera */
	      transform: rotate(6deg); /* W3C */  
	      -webkit-transform-origin: top right;
	      -moz-transform-origin: top right;
	      -ms-transform-origin: top right;
	      -o-transform-origin: top right;
	      transform-origin: top right;
	    }
	    
	    40%  {
	      /*background: rgba(235, 237, 237, 0.5);*/
	      -webkit-transform:  rotate(-6deg); /* Safari */
	      -moz-transform:rotate(-6deg); /* Firefox 3.6 Firefox 4 */
	      -ms-transform: rotate(-6deg); /* IE9 */
	      -o-transform:  rotate(-6deg); /* Opera */
	      transform: rotate(-6deg); /* W3C */  
	      -webkit-transform-origin: top right;
	      -moz-transform-origin: top right;
	      -ms-transform-origin: top right;
	      -o-transform-origin: top right;
	      transform-origin: top right;
	    }

	    80%  {
	      /*background: rgba(235, 237, 237, 0.5);*/
	      -webkit-transform:  rotate(6deg); /* Safari */
	      -moz-transform:rotate(6deg); /* Firefox 3.6 Firefox 4 */
	      -ms-transform: rotate(6deg); /* IE9 */
	      -o-transform:  rotate(6deg); /* Opera */
	      transform: rotate(6deg); /* W3C */  
	      -webkit-transform-origin: top right;
	      -moz-transform-origin: top right;
	      -ms-transform-origin: top right;
	      -o-transform-origin: top right;
	      transform-origin: top right;
	    }

	    100% {
	      /*background: rgba(235, 237, 237, 0);*/
	      -webkit-transform:  rotate(0deg); /* Safari */
	      -moz-transform:rotate(0deg); /* Firefox 3.6 Firefox 4 */
	      -ms-transform: rotate(0deg); /* IE9 */
	      -o-transform:  rotate(0deg); /* Opera */
	      transform: rotate(0deg); /* W3C */  
	      -webkit-transform-origin: top right;
	      -moz-transform-origin: top right;
	      -ms-transform-origin: top right;
	      -o-transform-origin: top right;
	      transform-origin: top right;
	    }
	}


	@keyframes mytwopop {
	    0%   {
	      background: rgba(235, 237, 237, 0.8);
	    }
	    
	    66%  {
	      background: rgba(235, 237, 237, 0.5);
	      
	    }
	    100% {
	      background: rgba(235, 237, 237, 0);
	    }
	}
</style>

<?php 

$show_vol = true;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'ipod') !== false || stripos($ua,'iphone') !== false || stripos($ua,'ipad') !== false ) {
	$show_vol = false;
}

?>

<div class="modal modal-show-detail main-content" id="modal-show-detail-img"  tabindex="-1" role="dialog" aria-hidden="true">

	<a data-dismiss="modal" title="Đóng" class="back btn-chitiettin back mt10 mr10" style="width: 80px; color: #000"><img src="/templates/home/styles/images/svg/prev.svg" class="ml00">&nbsp;Đóng</a>

	<!-- <a class="back">
		<img src="/templates/home/styles/images/svg/back02.svg"" data-dismiss="modal" alt="Close gallery" title="Quay lại">
	</a> -->
  	<div class="modal-dialog modal-lg modal-show-detail-dialog" role="document">
      <!-- Modal Header -->
        <!-- <div class="modal-header"></div> -->
      <!-- Modal body -->
      <div class="modal-content container">
	    <div class="modal-body content-posts">
	        <div class="row post-detail">
	            <div class="col-lg-7 popup-image-sm">
					<div class="">						
						<div class="jR3DCarouselGallery">
							<div class="jR3DCarouselCustomSlide">
					          <div class="big-img">
						        <div class="tag position-tag">
						            <img class="image_main_tag" src="asset/images/hinhanh/02.jpg" alt="">
						            <div class="tag-number-selected">
						              <img src="/templates/home/icons/boxaddnew/tag.svg" alt="" >
						              <span class="number">0</span>
						            </div> 
						        </div>   
					          </div>     
					        </div>
						</div>

					</div>

					
		            <div class="action md">
		            	<?php 
		            	$this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 1, 'show_md_5' => 0, 'show_sm' => 0));
		            	?>
		            </div>
					<div class="all-slider md">
	                    <div class="tag-list-product hidden">
	                      <img src="/templates/home/styles/images/svg/close_.svg" alt="" class="closebox">
	                      <ul class="slider tag-list-product-slider"></ul>
	                    </div>

	                    <div class="luot-xem-tin sm">
	                    	<img src="/templates/home/styles/images/svg/up_white.svg" class="mr05" alt="">Lướt xem
	                    </div>

	                    <div class="list-image-recent">
	                      	<div class="sm text-center mb05 dong-luot-xem-tin">
					          <img src="/templates/home/styles/images/svg/down_1.svg" alt="">
					        </div>
							<ul class="style-weblink list-image-recent-slider"></ul>
	                    </div>
	                </div>
					<!--  -->
		        </div>

	            <!-- info -->
	            <div class="col-lg-5 md">
	              <div class="post">
	                <div class="post-head">
	                  <div class="post-head-name">
	                    <div class="avata">
	                      <img class="pop_shop_img" src="asset/images/product/avata/oppo.png" alt="oppo">
	                    </div>
	                    <div class="title">
	                      <span class="pop_shop_name"></span>
	                      <br>
	                      <span class="pop_new_date"></span>
	                      <span>
	                        <img class="mr10 ml20 mt05" src="/templates/home/styles/images/svg/quadiacau.svg" width="14" alt="">
	                      </span>
	                      <span style="color: #737373; font-weight: normal; border-left: 1px solid #c4c4c4" class="pl10">
	                        <img class="mt10" src="/templates/home/styles/images/svg/eye_gray.svg" width="16" alt=""> 8K
	                      </span>
	                    </div>
	                  </div>

	                  <div class="post-head-more">
	                    <span>
	                      <img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt="more">
	                    </span>

	                    <div class="show-more hidden">
	                      <p class="save-post"><img class="icon-img" src="/templates/home/styles/images/svg/savepost.svg" alt="">Lưu bài viết</p>
	                      <ul class="show-more-detail">
	                        <li><a href="#">Chỉnh sửa bài viết</a></li>
	                        <li><a href="#">Thay đổi ngày</a></li>
	                        <li><a href="#">Tắt thông báo cho bài viết này</a></li>
	                        <li><a href="#">Ẩn khỏi dòng thời gian</a></li>
	                        <li><a href="#">Xóa </a></li>
	                        <li><a href="#">Tắt tính năng dịch</a></li>
	                        <li><a href="#">Kiểm duyệt bình luận</a></li>
	                      </ul>
	                    </div>
	                  </div>

	                </div>

	                <div class="info-product">
	                  <div class="descrip">
	                    <p class="pop-descrip">
	                      <!-- <span class="seemore">Xem tiếp</span> -->
	                    </p>

	                    <div class="hagtag"></div>
	                  </div>
	                </div>
	                <div class="action">
	                	<?php 
		            	$this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 0, 'show_md_5' => 1, 'show_sm' => 0));
		            	?>
	                  <!-- <div class="create-new-comment">
	                     <div class="avata-user"><img src="asset/images/product/avata/mi.svg" alt=""></div>
	                     <div class="area-comment"><textarea name="" id="" ></textarea></div>
	                     <p class="icon-sendmess"><img class="icon-img" src="/templates/home/styles/images/svg/sendmess.svg" alt=""></p>
	                     <div class="list-add-icon">
	                      <button><img class="icon-img" src="/templates/home/styles/images/svg/takephoto.svg" alt=""></button>
	                      <button><img class="icon-img" src="/templates/home/styles/images/svg/sticker.svg" alt=""></button>
	                    </div>
	                   </div>
	                  <div class="show-list-comments">
	                    <div class="dropdown">
	                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cũ nhất
	                      <span class="caret"></span></button>
	                      <ul class="dropdown-menu">
	                      </ul>
	                    </div>
	                    <p class="xembinhluankhac">Xem các bình luận khác...</p>
	                    <div class="comment">
	                      <dl>
	                        <dt><img src="/frontend/asset/images/product/avata/nikon.jpg" alt=""></dt>
	                        <dd>
	                          <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop.
	                        </dd>
	                      </dl>
	                      <div class="action-comment">
	                        <p><a href="">Thích</a></p>
	                        <p><a href="">Trả lời</a></p>
	                        <p>1giờ trước</p>
	                      </div>
	                    </div>
	                    <div class="comment">
	                      <dl>
	                        <dt><img src="/frontend/asset/images/product/avata/nikon.jpg" alt=""></dt>
	                        <dd>
	                          <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop. Tai nghe tốt, giá hợp lý. cảm ơn shop
	                        </dd>
	                      </dl>
	                      <div class="action-comment">
	                        <p><a href="">Thích</a></p>
	                        <p><a href="">Trả lời</a></p>
	                        <p>1giờ trước</p>
	                      </div>
	                    </div>
	                  </div> -->
	                </div>
	              </div>
	            </div>
	            <!-- info -->
	        </div>
	        
	    </div>
      </div>
    </div>

    <div class="sm content-posts">
    	<div class="sm tieude-sm">
	        <div class="tieude-sm-head">
	          <div class="avata">
	          	<a href="#" class="pop_shop_avatar">
		          <img  class="pop_shop_img" src="" alt=""><span class="pop_shop_name"></span>
		        </a>
	          </div>
	          <div class="time">
	          	<!-- <img src="/templates/home/styles/images/svg/check_blue.svg" width="15" class="mr10" alt=""> -->
	          	<span class="pop_new_date"></span>
	          </div>
	          <a href="" class="btn-chitiettin btn-chitiettin-js mt10 mr10">Chi tiết tin <img src="/templates/home/styles/images/svg/next.svg" style="filter: invert(100%);"></a>
	        </div>
	        <h3 class="pop-descrip-title"></h3>
	    </div>
	    <div class="action post-detail">
	    	<?php 
        	$this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 0, 'show_md_5' => 0, 'show_sm' => 1));
        	?>
        </div>
		<div class="all-slider">
            <div class="tag-list-product hidden">
              <img src="/templates/home/styles/images/svg/close_.svg" alt="" class="closebox">
              <ul class="slider tag-list-product-slider"></ul>
            </div>

            <div class="luot-xem-tin sm">
            	<img src="/templates/home/styles/images/svg/up_white.svg" class="mr05" alt="">Lướt xem
            </div>

            <div class="list-image-recent">
              	<div class="sm text-center mb05 dong-luot-xem-tin">
		          <img src="/templates/home/styles/images/svg/down_1.svg" alt="">
		        </div>
				<ul class="style-weblink list-image-recent-slider"></ul>
            </div>
        </div>
    </div>

</div>


<script id="js-list-3d-tag" type="text/template">
	<div class="jR3DCarouselCustomSlide" data-index={{KEY_INDEX}}>
      <div class="big-img">
        <div class="tag position-tag">
            <img class="image_main_tag slider_check_main" src="{{IMAGE_LINK_TAG}}" alt="" data-id="{{KEY_INDEX}}">
            <div class="tag-number-selected {{HIDE_SHOW}}">
              <img src="/templates/home/icons/boxaddnew/tag.svg" alt="">
              <span class="number">{{TOTAL_TAG}}</span>
            </div>
            {{LIST_TAG}}
      </div>     
    </div>
</script>

<script id="js-link-photo-tag" type="text/template">
  <li>
      <a href="{{LINK_TAG}}" target="_blank">
        <div class="images">
          <img src="{{IMAGE_LINK_TAG}}" alt="">
        </div>
        <div class="text">  
          <p style="color: white">{{TITLE_LINK_TAG}}</p>
          <div class="sale-price">{{DOMAIN_TAG}}</div>
        </div>
      </a>
  </li>
</script>

<script id="js-list-3d-video" type="text/template">
	<div class="jR3DCarouselCustomSlide" data-index={{KEY_INDEX}}>
      <div class="big-img">
        <div class="tag position-tag video">
        	<?php if($show_vol == true) { ?>
			<img class="az-volume" src="/templates/home/styles/images/svg/icon-volume-off.svg" width="32">
			<?php } ?>
            <video data-id="{{KEY_INDEX}}" id="video_popup_{{KEY_INDEX}}" data-index="{{KEY_INDEX}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls" class="slider_check_main">
	            <source src="{{VIDEO_URL}}" type="video/mp4">
	        </video>
      </div>     
    </div>
</script>

<script type="text/javascript">
  
  (function($) {
    $.fn.swipeDetail = function(options) {

        // Default thresholds & swipe functions
        var defaults = {
            threshold: {
                x: 30,
                y: 30
            },
            swipeLeft: function() { 
               $('#modal-show-detail-img .next.controls').click();
            },
            swipeRight: function() { 
              $('#modal-show-detail-img .previous.controls').click();
            }
        };

        var options = $.extend(defaults, options);

        if (!this) return false;

        return this.each(function() {

            var me = $(this)

            // Private variables for each element
            var originalCoord = { x: 0, y: 0 }
            var finalCoord = { x: 0, y: 0 }
            var start_M = false;
            

            // Store coordinates as finger is swiping
            function touchMove(event) {
                if (start_M == true) {
                    event.preventDefault();
                    if (event.targetTouches !== undefined) {
                        var touches = event.targetTouches[0];
                    }
                    finalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                    finalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;
                }
            }

            // Done Swiping
            // Swipe should only be on X axis, ignore if swipe on Y axis
            // Calculate if the swipe was left or right
            function touchEnd(event) {

                if (start_M == true) {
                    var changeY = originalCoord.y - finalCoord.y;
                    
                    swipeLength = Math.round(Math.sqrt(
                    Math.pow(finalCoord.x - originalCoord.x, 2)));

                    if (swipeLength > 20) {
                      xDist = originalCoord.x - finalCoord.x;
                      yDist = originalCoord.y - finalCoord.y;
                      r = Math.atan2(yDist, xDist);

                      swipeAngle = Math.round(r * 180 / Math.PI);
                      if (swipeAngle < 0) {
                          swipeAngle = 360 - Math.abs(swipeAngle);
                      }
                      if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
                          defaults.swipeLeft()
                      }
                      if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
                          defaults.swipeLeft()
                      }
                      if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
                          defaults.swipeRight()
                      }
                    }

                    
                    start_M = false;
                }
            }

            // Swipe was started
            function touchStart(event) {
                start_M = true;
                if (event.targetTouches !== undefined) {
                    var touches = event.targetTouches[0];
                }
                originalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                originalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;

                finalCoord.x = originalCoord.x
                finalCoord.y = originalCoord.y
            }

            // Add gestures to all swipable areas
            // this.addEventListener("touchstart", touchStart, false);
            // this.addEventListener("touchmove", touchMove, false);
            // this.addEventListener("touchend", touchEnd, false);
            // this.addEventListener("touchcancel", touchEnd, false);

            this.addEventListener("mousedown", touchStart, false);
            this.addEventListener("mousemove", touchMove, false);
            this.addEventListener("mouseup", touchEnd, false);
            this.addEventListener("mouseleave", touchEnd, false);

        });
    };
})(jQuery);


  $( document ).ready(function() {
  	var link_href = '';
    var info_popup = {};
    var tags_pop = [];
    var full_text = '';
    var key_id = 0;
    var myCarousel;
    var ratio_3d = -1;
    var new_id = 0;
    var click_show_tags = 0;
    $('#modal-show-detail-img .jR3DCarouselGallery').swipeDetail();

    function showTagHomeTwo(key_tags, tags) {
    	var str = '';
    	tags_pop[key_tags] = {};
      	tags_pop[key_tags] = JSON.parse(tags);
      	if (tags_pop[key_tags].length > 0) {
	        $.each(tags_pop[key_tags], function( index, value ) {
	          var positionStyle = getPositionStyle(value.x, value.y);
	          var wrapperElement = '<div style="display:none; left: '+positionStyle.left+'; top: '+positionStyle.top+'" class="taggd__wrapper position-tag">';
	          wrapperElement += '<div class="tag-photo-home-2 tag-selecting" data-id="'+ index +'" data-key="'+ key_tags +'"><img style="" src="/templates/home/icons/boxaddnew/tag.svg"></div>';
	          wrapperElement += '</div>';	          
	           str += wrapperElement; 
	        });
      	}
      	return str;
    }

    $('body').on('click', '#modal-show-detail-img .tag-number-selected', function(){
    	if($(this).hasClass('is-active')) {
    		var parent_id = $(this).parents('.jR3DCarouselCustomSlide');
    		$(parent_id).find('.taggd__wrapper').hide();
    		$(this).removeClass('is-active');
    	} else {
    		var parent_id = $(this).parents('.jR3DCarouselCustomSlide');
    		$(parent_id).find('.taggd__wrapper').show();
    		$(this).addClass('is-active');
    	}
    });

    function show_detail_two(_key_id) {
        $('#modal-show-detail-img .jR3DCarouselGallery').empty();

        // slider bottom img
  	  	if($('#modal-show-detail-img .list-image-recent-slider').hasClass('slick-initialized')){
	        $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('unslick');
	    }
	    $('#modal-show-detail-img .list-image-recent-slider').removeClass('slick-initialized slick-slider');
	    $('#modal-show-detail-img .list-image-recent-slider').html('');

      	if (info_popup.listImg !== undefined) {
      	  	$.each(info_popup.listImg, function( index, value ) {
	      	  	//  tags
	      	  	if (value.type == 'img') {
	      	  		var template_img = $('#js-list-3d-tag').html();
		      	  	template_img = template_img.replace(/{{IMAGE_LINK_TAG}}/g, info_popup.info.path_img + 'full_'+value.image);
		      	  	template_img = template_img.replace(/{{KEY_INDEX}}/g, index);
		      	  	
		      	  	if (value.tags !== undefined && value.tags !== null) {
		      	  		template_img = template_img.replace(/{{TOTAL_TAG}}/g, value.tags.length);
		      	  		var str = showTagHomeTwo(index,JSON.stringify(value.tags));
		      	  		template_img = template_img.replace(/{{LIST_TAG}}/g, str);
		      	  		template_img = template_img.replace(/{{HIDE_SHOW}}/g, '');
		      	  		
		            }else {
		            	template_img = template_img.replace(/{{TOTAL_TAG}}/g, 0);
		            	template_img = template_img.replace(/{{LIST_TAG}}/g, '');
		            	template_img = template_img.replace(/{{HIDE_SHOW}}/g, 'hide_0');
		            }
		      	  	$('#modal-show-detail-img .jR3DCarouselGallery').append(template_img);

		      	  	var slider_img = '<li href="'+info_popup.info.path_img + 'full_'+value.image+'">';
	      	  		slider_img += '<img src="'+info_popup.info.path_img + 'full_'+value.image+'" alt="" data-title="'+value.title+'">';
	      	  		slider_img += '<p class="sub-tit">'+value.title+'</p>';
	      	  		slider_img += '</li>';
	      			$('#modal-show-detail-img .list-image-recent-slider').append(slider_img);
	      	  	}
	      	  	
	      	  	if (value.type == 'video') { 
	      	  		var template_video = $('#js-list-3d-video').html();
		      	  	template_video = template_video.replace(/{{VIDEO_URL}}/g, value.link);
		      	  	template_video = template_video.replace(/{{KEY_INDEX}}/g, index);
		      	  	$('#modal-show-detail-img .jR3DCarouselGallery').append(template_video);

		      	  	var slider_img = '<li href="'+value.link+'">';
		      	  		slider_img += '<video playsinline="" muted="1" autoplay="false" preload="metadata" controls="controls">';
                        	slider_img += '<source src="'+value.link+'" type="video/mp4">';
                        slider_img += '</video>';
		      	  		slider_img += '</li>';
		      	  	$('#modal-show-detail-img .list-image-recent-slider').append(slider_img);
	      	  	}

	      	  	var get_ratio_3d = value.image_size.width/value.image_size.height;
	      		if (ratio_3d == -1 || ratio_3d > get_ratio_3d) {
	      			ratio_3d = get_ratio_3d;
	      		}
				
      	  	});
      	  	$('body').find('#modal-show-detail-img .list-image-recent-slider').slick({
		        slidesToShow: 3,
		        slidesToScroll: 1,
		        arrows: true,
		        dots: false,
		        infinite: false,
		        speed: 300,
		        variableWidth: true,
		        responsive: [
		          {
		            breakpoint: 768,
		            settings: {
		              slidesToShow: 2.5,
		              slidesToScroll: 1,
		              arrows: false,
		            }
		          }
		        ]
	      	});
	      	$('body').find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', _key_id);
	      	$('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+_key_id+'"]').addClass('is-active');
      }
      $('.tag-list-product .tag-list-product-slider').html('');
    }

    $('body').on('click', '#modal-show-detail-img .read-more', function() { 
        var element = $('#modal-show-detail-img .pop-descrip');
        var _key_id = $(this).attr('data-id');
        if ($( element ).hasClass( "have-read-more" )) {
          $( element ).removeClass( "have-read-more" );
          $( element ).find('.read-more').remove();
        } 
        if (info_popup.listImg[_key_id] !== undefined) {
          info_popup.listImg[_key_id].show_full_text = full_text;
        }
        $('#modal-show-detail-img .pop-descrip').html(full_text);
        // $('#modal-show-detail-img .pop-descrip-title').html(full_text);
    });

    $('body').on('click', '.popup-detail-image', function() {
    	var _this = $(this);
        new_id = $(this).attr('data-news-id');
        key_id = parseInt($(this).attr('data-key'));
        link_href = $(this).parents('.post-detail').find('.info-product .descrip .seemore > a').attr('href');
        var info_video = {};
        var get_video = $(this).parents('.item-element-parent').find('.popup-detail-video');
        click_show_tags = 0;
        if($(this).hasClass('fs-gal')) {
        	click_show_tags = 1;
        }
        else if (get_video.length == 1) {
        	info_video = {
				link: $(get_video).attr('data-video-link') + '#t=' + $(get_video).get(0).currentTime ,
				shop_link: $(get_video).attr('data-shop-link'),
				clientHeight: $(get_video)[0].clientHeight,
				clientWidth: $(get_video)[0].clientWidth,
			}
        }
        
        
        $.ajax({
          url: siteUrl + 'tintuc/getDetailImg',
          type: "POST",
          data: {new_id: new_id, key_id:key_id, info_video: info_video },
          dataType: "json",
          beforeSend: function () {
             info_popup = {};
          },
          success: function (response) {
            info_popup = response;
            ratio_3d = -1;
            if (response.info) {
              $('#modal-show-detail-img .pop_shop_name').text(response.info.sho_name);
              $('#modal-show-detail-img .pop_shop_img').attr('src', response.info.shop_logo);
              $('#modal-show-detail-img .pop_new_date').text(response.info.not_begindate);
            }

            if (get_video.length == 1 && !$(_this).hasClass('popup-detail-video')) {
            	key_id = parseInt(key_id)  + 1;
            }
            
            show_detail_two(key_id);

            if ($(_this).hasClass('popup-detail-video')) {
            	$('#video_popup_0').prop('muted', false);
            	$('#video_popup_0').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
            	$('#video_popup_0').prev('.az-volume').addClass("volume_off");
            }

            $('#modal-show-detail-img').modal('show');
            if (info_popup.listImg.length > 1) {
            	
            	if (ratio_3d != -1) {
            		var height = 650/ratio_3d;
            		myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
				        width: 650, // largest allowed width
				         height: height, // largest allowed height
				        slideClass: 'jR3DCarouselCustomSlide', 
				        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
				        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
				        animationCurve: 'ease',
				        animationDuration: 800,
				        animationInterval: 800,
				        autoplay: false,
				        onSlideShow: shown3d, // callback when Slide show event occurs
				        // navigation: 'circles'
				        controls: true,
				      });
            	} else {
            		myCarousel = $('#modal-show-detail-img').find('.jR3DCarouselGallery').jR3DCarousel({
				        width: 650, // largest allowed width
				        // height: 400, // largest allowed height
				        slideClass: 'jR3DCarouselCustomSlide', 
				        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
				        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
				        animationCurve: 'ease',
				        animationDuration: 800,
				        animationInterval: 800,
				        autoplay: false,
				        onSlideShow: shown3d, // callback when Slide show event occurs
				        // navigation: 'circles'
				        controls: true,
				      });	
            	}

            	
            	myCarousel.showSlide(key_id);
            } else {
            	$('#modal-show-detail-img').find('.jR3DCarouselGallery').attr('style', '');
            	showDetail();
            	$('#modal-show-detail-img').find('.tag-number-selected').trigger('click');
            }

            $('body').find('video').each(function() {
            	$(this).trigger("pause");
	        });
            if(key_id == 0 && get_video.length == 1) {
            	$('#modal-show-detail-img').find('#video_popup_0').trigger("play");
            }

          },
          error: function () {}
        });
    });

    function shown3d(slide) {

    	if (click_show_tags == 1) {
    		slide.find('.tag-number-selected').trigger('click');
    	}

    	// console.log("Slide shown: ", slide.find('.slider_check_main').attr('data-id'));
    	key_id = slide.find('img.image_main_tag').attr('data-id');
    	$('#modal-show-detail-img').find('video').each(function() {
        	$(this).trigger("pause");
        });
    	if (key_id == undefined) {
    		key_id = slide.find('video').attr('data-id');
    		$('#modal-show-detail-img').find('#video_popup_0').trigger("play");
    	}
    	key_id = parseInt(key_id);
    	$('.tag-list-product .closebox').click();
    	showDetail();
    }

    function showDetail() {
    	if (info_popup.listImg[key_id] !== undefined) {
    		 $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide').removeClass('is-active');
    		 $('body').find('#modal-show-detail-img .list-image-recent-slider').slick('slickGoTo', key_id);
	      	 $('body').find('#modal-show-detail-img .list-image-recent-slider .slick-slide[data-slick-index="'+key_id+'"]').addClass('is-active');

              var data_add = info_popup.listImg[key_id];
              $('#modal-show-detail-img .sanpham_link').hide();
              $('#modal-show-detail-img .lienket_link').hide();
              if (data_add.pro_link != undefined && data_add.pro_link != '' && data_add.type == 'img') {
                  $('#modal-show-detail-img .sanpham_link').attr('href', data_add.pro_link);
                  $('#modal-show-detail-img .sanpham_link').show();
              }
              //  wait Duc check
              if (data_add.lienket_link != undefined && data_add.lienket_link != '' && data_add.type == 'img') {
                  $('#modal-show-detail-img .lienket_link').attr('href', data_add.lienket_link);
                  $('#modal-show-detail-img .lienket_link').show();
              }

              $('#modal-show-detail-img .pop-descrip').html('');
              $('#modal-show-detail-img .pop-descrip-title').html('');
              if (data_add.type == 'img') {
	              if (data_add.show_full_text === undefined) {
	                  var str = '';
	                  if (data_add.title != '') {
	                    str += '<h3 class="tit">' + data_add.title + '</h3>';
	                  }

	                  full_text = str;
	                  if (data_add.caption != '') {
	                    str += '<p class="mb10">' + data_add.caption;
	                    full_text += '<p class="mb10">' + data_add.caption + '</p>';
	                  }
	                  
	                  if (str.split(' ').length > 100 ) {
	                      $("#modal-show-detail-img .pop-descrip").html(str.split(' ').slice(0,100).join(' ') + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span></p>');
	                  } else if (str.split(' ').length < 100 && data_add.icon_caption != '') {
	                    $('#modal-show-detail-img .pop-descrip').html(str + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span></p>');
	                  } else if (str.split(' ').length < 100 && data_add.icon_caption == '') {
	                    $('#modal-show-detail-img .pop-descrip').html(str);
	                  }

	                  if (str.split(' ').length > 20 ) {
	                    $("#modal-show-detail-img .pop-descrip-title").html(str.split(' ').slice(0,20).join(' ') + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>');
	                    info_popup.listImg[key_id].show_top_text = str.split(' ').slice(0,20).join(' ') + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>';
	                  } else if (str.split(' ').length < 20 && data_add.icon_caption != '') {
	                    $('#modal-show-detail-img .pop-descrip-title').html(str + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>');
	                    info_popup.listImg[key_id].show_top_text = str + '...<a class="seemore read-more" data-id="'+key_id+'">Xem thêm</a></p>';
	                  } else if (str.split(' ').length < 20 && data_add.icon_caption == '') {
	                    $('#modal-show-detail-img .pop-descrip-title').html(str);
	                    info_popup.listImg[key_id].show_top_text = str;
	                  }
	                  

	                  if (data_add.icon_caption != '' && data_add.icon_caption !== undefined) {
	                    if (str == '') {
	                      $('#modal-show-detail-img .pop-descrip').addClass('have-read-more');
	                      $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption);
	                      var length_icon = $('#modal-show-detail-img .pop-descrip').find('.clearfix.mb10').length

	                      if (length_icon > 1) {
	                        $('#modal-show-detail-img .pop-descrip').html(data_add.icon_caption + '...<span class="seemore read-more" data-id="'+key_id+'">Xem tiếp</span>');
	                      }
	                    }                    
	                    full_text += data_add.icon_caption;
	                  }
	              } else {
	                $('#modal-show-detail-img .pop-descrip').html(data_add.show_full_text);
	                $('#modal-show-detail-img .pop-descrip-title').html(data_add.show_top_text);
	              }
	          }

              if (link_href != undefined) {
              	if (data_add.type == 'img') {
	              	$('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
	              	$('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href +'#block_image_'+data_add.id);
              	} else {
              		$('#modal-show-detail-img .btn-chitiettin-js').attr('target', '_bank');
	              	$('#modal-show-detail-img .btn-chitiettin-js').attr('href', link_href +'#video_'+new_id);
              	}
              	
              } else {
              	$('#modal-show-detail-img .btn-chitiettin-js').attr('target', '');
              	$('#modal-show-detail-img .btn-chitiettin-js').attr('href','');
              }
              
              
        }
    }

    $('body').on('click','#modal-show-detail-img .list-image-recent-slider .slick-slide', function(){
    	key_id = parseInt($(this).attr('data-slick-index'));
    	if (myCarousel != undefined) {
    		var get_current = myCarousel.getCurrentSlide();
    		var key_current = get_current.find('.slider_check_main').attr('data-id');
    		myCarousel.showSlide(key_id);
    	}
    });
    

    $('body').on('click','#modal-show-detail-img .tag-photo-home-2', function(){
      var id_tag = $(this).attr('data-id');
      var key_tag = $(this).attr('data-key');
      $('.tag-photo-home-2').removeClass('is-active');
      $(this).addClass('is-active');
      if($('.tag-list-product .tag-list-product-slider').hasClass('slick-initialized')){
        $('body').find('.tag-list-product .tag-list-product-slider').slick('unslick');
      }
      $('.tag-list-product .tag-list-product-slider').removeClass('slick-initialized slick-slider');
      $('.tag-list-product .tag-list-product-slider').html('');
      $('.image-tag-recs-close').show();
      $('.tag-list-product').show();
      $('.luot-xem-tin').removeClass('opened');

      var option_slick = {
              dots: false,
              infinite: false,
              speed: 300,
              slidesToShow: 2.5,
              slidesToScroll: 1,
              variableWidth: true,
              responsive: [
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1.5,
                    slidesToScroll: 1
                  }
                }
              ]
            };
      // show loadding

      if (tags_pop[key_tag] !== undefined && tags_pop[key_tag][id_tag] !== undefined) {
        // link
        if(tags_pop[key_tag][id_tag].list_link.length > 0 ) {
          $.each(tags_pop[key_tag][id_tag].list_link, function( key_link, value_link ) {

            var template_link = $('#js-link-photo-tag').html();
            template_link = template_link.replace(/{{IMAGE_LINK_TAG}}/g, value_link.image);
            template_link = template_link.replace(/{{TITLE_LINK_TAG}}/g, value_link.title);
            template_link = template_link.replace(/{{LINK_TAG}}/g, value_link.save_link);
            template_link = template_link.replace(/{{DOMAIN_TAG}}/g, value_link.host);
            $('.tag-list-product .tag-list-product-slider').append(template_link);
          });

          $('body').find('.tag-list-product-slider').slick(option_slick);

        } else {

          $.ajax(
          {
            type        : 'post',
            dataType    : 'json',
            url         : siteUrl + 'product/getProChoose',
            data        : {product: tags_pop[key_tag][id_tag].list_pro, type:'pro_tag' },
            success     : function (result)
            { 
              if (result.list_product != "") {
                $('.tag-list-product .tag-list-product-slider').html(result.list_product);
              } 
            }
          })
          .always(function()
          { 
            $('body').find('.tag-list-product-slider').slick(option_slick);
            // remove loadding
          });

        }
      }
    });


    $('body').on('click', '#modal-show-detail-img .prev-img-detail', function(){
        var key_id = $('#modal-show-detail-img').find('.image_main_tag').attr('data-id');
        var key_count = parseInt(key_id) - 1;
        if (key_count != -1) {
          show_detail(key_count);
        }else {
          show_detail(0);
        }
        
    });

    $('body').on('click', '#modal-show-detail-img .next-img-detail', function(){
        var key_id = $('#modal-show-detail-img').find('.image_main_tag').attr('data-id');
        var key_count = parseInt(key_id) + 1;
        
        if (info_popup.listImg != undefined) {
            if(key_count >= info_popup.listImg.length) {
              show_detail(info_popup.listImg.length);
            } else {
              show_detail(key_count);
            }
        }
    });


    $('.tag-selecting').click(function(){
	    if (window.matchMedia("(max-width: 767px)").matches) {
	      $(this).toggleClass('is-active');
	      if ($(this).hasClass('is-active')) {
	        $('.tag-list-product').css('left', '0');
	        $('.tag-list-product').show();
	        $('.tag-list-product-slider').get(0).slick.setPosition();
	      } else {      
	        $('.tag-list-product').css('left', '100%');
	        $('.tag-list-product').hide();
	        $(this).removeClass('is-active');
	      }
	    } else {
	      $(this).toggleClass('is-active');
	      if ($(this).hasClass('is-active')) {
	        // $('.tag-list-product').css('left', '0');
	        $('.tag-list-product').show();
	        $('.tag-list-product-slider').get(0).slick.setPosition();
	      } else {      
	        // $('.tag-list-product').css('left', '100%');
	        $('.tag-list-product').hide();
	        $(this).removeClass('is-active');
	      }
	    }   
	});

	$('.closebox').click(function(){
		// $('.tag-list-product').css('left', '100%');
		$('.tag-list-product').hide();
		$('.tag-selecting').removeClass('is-active');
	});

	$('.luot-xem-tin').click(function(){
		$(this).addClass('opened');
	});

	$('.dong-luot-xem-tin').click(function(){
		$('.luot-xem-tin').removeClass('opened');
	});

	$("#modal-show-detail-img").on('hidden.bs.modal', function () {
	  	$('#modal-show-detail-img').find('video').each(function() {
        	$(this).trigger("pause");
        });

        if ($('#video_popup_0').length == 1) {
        	var link_video = $('#video_popup_0').get(0).currentTime;
    		$('#video_'+ new_id).get(0).currentTime =  link_video;
        }
	  	
    	
	  	$('video').each(function() {
          if(isElementInViewport($(this))) {
            if ($(this).parents('.list-image-recent-slider').length == 0){
              $(this).trigger("play");
            }
          }else {
              $(this).trigger("pause");
          }
        });

        $('#video_popup_0').prop('muted', true);
    	$('#video_popup_0').prev('.az-volume').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
    	$('#video_popup_0').prev('.az-volume').removeClass("volume_off");
	});
    
  });
</script>