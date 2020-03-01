<script src="/templates/home/jR3DCarousel/jR3DCarousel.js"></script>
<style type="text/css">
	@media (max-width: 768px) {
		.jR3DCarouselGallery .previous.controls { display: none !important}
		.jR3DCarouselGallery .next.controls { display: none !important }
	}
	.position-tag .tag-number-selected.is-active {
	  border: 2px solid #fff;
	}	
	#modal-show-detail-video .tieude-sm { width: 100% }
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
<div class="modal modal-show-detail" id="modal-show-detail-video"  tabindex="-1" role="dialog" aria-hidden="true">
  <a class="back">
  	<img src="/templates/home/styles/images/svg/back02.svg" data-dismiss="modal" alt="Close gallery" title="Quay lại">
  </a>
  <div class="modal-dialog modal-lg modal-show-detail-dialog" role="document">
      <!-- Modal Header -->
        <!-- <div class="modal-header"></div> -->
      <!-- Modal body -->
      <div class="modal-content container">
	      <div class="modal-body">
	          <div class="row">
	            <div class="col-lg-7 popup-image-sm">
					<div class="">
						<div class="sm tieude-sm">
					        <div class="tieude-sm-head">
					          <div class="avata">
					          	<img  class="pop_shop_img" src="asset/images/hinhanh/22.jpg" alt=""><span class="pop_shop_name"></span>
	                      
					          </div>
					          <div class="time">
					          	<img src="/templates/home/styles/images/svg/check_blue.svg" width="15" class="mr10" alt=""><span class="pop_new_date"></span>
					          </div>
					        </div>
					        <h3 class="pop-descrip-title"></h3>
					    </div>
						
						<div class="jR3DCarouselGallery">
							<div class="jR3DCarouselCustomSlide">
					          <div class="big-img">
						        <div class="tag position-tag">
						        </div>   
					          </div>     
					        </div>
						</div>

					</div>


		            <div class="action">
		            	<?php $this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 1, 'show_md_5' => 0, 'show_sm' => 0)); ?>
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
	                	<?php $this->load->view('home/share/bar-btn-share-js', array('show_md_7' => 0, 'show_md_5' => 1, 'show_sm' => 0)); ?>
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
  </div>
</div>

<script id="js-list-3d-video" type="text/template">
	<div class="jR3DCarouselCustomSlide" data-index={{KEY_INDEX}}>
      <div class="big-img">
        <div class="tag position-tag">
            <video data-index="{{KEY_INDEX}}" playsinline="" muted="false" autoplay="true" preload="metadata" controls="controls">
	            <source src="{{VIDEO_URL}}" type="video/mp4">
	        </video>
      </div>     
    </div>
</script>

<script type="text/javascript">
	
	(function($) {
    $.fn.swipeDetailVideo = function(options) {

        // Default thresholds & swipe functions
        var defaults = {
            threshold: {
                x: 30,
                y: 30
            },
            swipeLeft: function() { 
               $('#modal-show-detail-video .next.controls').click();
            },
            swipeRight: function() { 
              $('#modal-show-detail-video .previous.controls').click();
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
    	var list_video = [];
    	var ratio_video_3d = -1;
    	var key_id_video = 0;
    	var myCarouselVideo;
    	$('#modal-show-detail-video .jR3DCarouselGallery').swipeDetailVideo();
  		$('body').on('click', '.popup-detail-video', function() {
  			list_video = [];
  			var id_video = $(this).attr('data-id');
  			var cat_video = $(this).attr('data-cat');
  			if (cat_video == 0) {
  				var link_video 	= $(this).attr('data-video-link');
  					// link_video  = link_video.replace("t=1", "");
  				var shop_avatar = $(this).attr('data-shop-avatar');
  				var shop_name 	= $(this).attr('data-shop-name');
  				var shop_date 	= $(this).attr('data-shop-date');
  				var shop_link 	= $(this).attr('data-shop-link');
  				var info_video = {
  					link: link_video,
  					key_video: id_video,
  					shop_avatar: shop_avatar,
  					shop_name: shop_name,
  					shop_date: shop_date,
  					shop_link: shop_link,
  					clientHeight: $(this)[0].clientHeight,
  					clientWidth: $(this)[0].clientWidth
  				}
  				list_video.push(info_video);	
  			} else {
  				var get_list_video = $('.popup-detail-video[data-cat="'+cat_video+'"]');
  				if (get_list_video.length > 0) {
  					$.each(get_list_video, function( index, value ) {
			          	var link_video 	= $(value).attr('data-video-link');
		  				var shop_avatar = $(value).attr('data-shop-avatar');
		  				var shop_name 	= $(value).attr('data-shop-name');
		  				var shop_date 	= $(value).attr('data-shop-date');
		  				var shop_link 	= $(value).attr('data-shop-link');
		  				var id_video    = $(value).attr('data-id');
		  				var info_video = {
		  					link: link_video,
		  					key_video: id_video,
		  					shop_avatar: shop_avatar,
		  					shop_name: shop_name,
		  					shop_date: shop_date,
		  					shop_link: shop_link,
		  					clientHeight: $(value)[0].clientHeight,
  							clientWidth: $(value)[0].clientWidth
		  				}
		  				list_video.push(info_video);	
			        });
  				}
  			}
  			show_detail_video_two(id_video);
  			$('#modal-show-detail-video').find('video').each(function() {
  				if ($(this).attr('data-index') == key_id_video) {
  					$(this).trigger("play");
  				}else {
  					$(this).trigger("pause");
  				}
	          	
	        });
  			$('#modal-show-detail-video').modal('show');
  			if (list_video.length > 1) {
            	
            	if (ratio_video_3d != -1) {
            		var height = 650/ratio_video_3d;
            		myCarouselVideo = $('#modal-show-detail-video').find('.jR3DCarouselGallery').jR3DCarousel({
				        width: 650, // largest allowed width
				        height: height, // largest allowed height
				        slideClass: 'jR3DCarouselCustomSlide', 
				        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
				        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
				        animationCurve: 'ease',
				        animationDuration: 800,
				        animationInterval: 800,
				        autoplay: false,
				        onSlideShow: shown3dVideo, // callback when Slide show event occurs
				        // navigation: 'circles'
				        controls: true,
				      });
            	} else {
            		myCarouselVideo = $('#modal-show-detail-video').find('.jR3DCarouselGallery').jR3DCarousel({
				        width: 650, // largest allowed width
				        // height: 400, // largest allowed height
				        slideClass: 'jR3DCarouselCustomSlide', 
				        slideLayout: 'contain', // "contain" (fit according to aspect ratio), "fill" (stretches object to fill) and "cover" (overflows box but maintains ratio)
				        animation: 'slide3D', // slide | slide3D | scroll | scroll3D | fade
				        animationCurve: 'ease',
				        animationDuration: 800,
				        animationInterval: 800,
				        autoplay: false,
				        onSlideShow: shown3dVideo, // callback when Slide show event occurs
				        // navigation: 'circles'
				        controls: true,
				      });	
            	}
            	myCarouselVideo.showSlide(key_id_video);
            } else {
            	$('#modal-show-detail-video').find('.jR3DCarouselGallery').attr('style', '');
            }

  		});

  		$('body').on('click','#modal-show-detail-video .list-image-recent-slider .slick-slide', function(){
	    	key_id_video = $(this).attr('data-slick-index');
	    	if (myCarouselVideo != undefined) {
	    		myCarouselVideo.showSlide(key_id_video);
	    	}
	    });

  		function shown3dVideo(slide) {
  			key_id_video = slide.find('video').attr('data-index');
    		$('.tag-list-product .closebox').click();
    		showDetailVideo();
  		}

  		function showDetailVideo() {
	    	if (list_video[key_id_video] !== undefined) {
	    		$('body').find('#modal-show-detail-video .list-image-recent-slider .slick-slide').removeClass('is-active');
	    		$('body').find('#modal-show-detail-video .list-image-recent-slider').slick('slickGoTo', key_id_video);
		      	$('body').find('#modal-show-detail-video .list-image-recent-slider .slick-slide[data-slick-index="'+key_id_video+'"]').addClass('is-active');

	            var data_add = list_video[key_id_video];
	            $('#modal-show-detail-video .pop_shop_name').text(data_add.shop_name);
			    $('#modal-show-detail-video .pop_shop_img').attr('src', data_add.shop_avatar);
			    $('#modal-show-detail-video .pop_new_date').text(data_add.shop_date);
	        }
	        $('#modal-show-detail-video').find('video').each(function() {
  				if ($(this).attr('data-index') == key_id_video) {
  					$(this).trigger("play");
  				}else {
  					$(this).trigger("pause");
  				}
	        });
	    }

  		function show_detail_video_two(id_video) {

	         $('#modal-show-detail-video .jR3DCarouselGallery').empty();

	        // slider bottom img
	  	  	if($('#modal-show-detail-video .list-image-recent-slider').hasClass('slick-initialized')){
		        $('body').find('#modal-show-detail-video .list-image-recent-slider').slick('unslick');
		    }
		    $('#modal-show-detail-video .list-image-recent-slider').removeClass('slick-initialized slick-slider');
		    $('#modal-show-detail-video .list-image-recent-slider').html('');
		    key_id_video = 0;
	      	if (list_video !== undefined && list_video.length > 0) {
	      	  	$.each(list_video, function( index, value ) {
		      	  	if (value.key_video == id_video) {
		      	  		key_id_video = index;
		      	  		$('#modal-show-detail-video .pop_shop_name').text(value.shop_name);
		                $('#modal-show-detail-video .pop_shop_img').attr('src', value.shop_avatar);
		                $('#modal-show-detail-video .pop_new_date').text(value.shop_date);
		      	  	}
		      	  	var template_video = $('#js-list-3d-video').html();
		      	  	template_video = template_video.replace(/{{VIDEO_URL}}/g, value.link);
		      	  	template_video = template_video.replace(/{{KEY_INDEX}}/g, index);
		      	  	$('#modal-show-detail-video .jR3DCarouselGallery').append(template_video);

		      	  	var slider_img = '<li href="'+value.link+'">';
		      	  		slider_img += '<video playsinline="" muted="false" autoplay="false" preload="metadata" controls="controls">';
                        	slider_img += '<source src="'+value.link+'" type="video/mp4">';
                        slider_img += '</video>';
		      	  		slider_img += '</li>';

		      	  	var get_ratio_3d = value.clientWidth/value.clientHeight;
		      		if (ratio_video_3d == -1 || ratio_video_3d > get_ratio_3d) {
		      			ratio_video_3d = get_ratio_3d;
		      		}
					$('#modal-show-detail-video .list-image-recent-slider').append(slider_img);
	      	  	});
	      	  	$('body').find('#modal-show-detail-video .list-image-recent-slider').slick({
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
		      	$('body').find('#modal-show-detail-video .list-image-recent-slider').slick('slickGoTo', key_id_video);
		      	$('body').find('#modal-show-detail-video .list-image-recent-slider .slick-slide[data-slick-index="'+key_id_video+'"]').addClass('is-active');
	      }
	    }
    });
</script>