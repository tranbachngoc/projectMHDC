<?php $this->load->view('flatform/common/header_news');?>

        <div class="container-fluid" role="main">
            <div class="row">
                
                <div class="col-sm-2 hidden-xs" style="position: static">
                    <?php $this->load->view('flatform/common/menu'); ?>                    
                </div>
                
                <div class="col-sm-5 col-xs-12">
                    <div class="shop_boxes">
                        <div class="shop_banner text-center">
                            <div class="fix16by9">
                                <div class="c" style="background: #fff url('<?php echo DOMAIN_CLOUDSERVER.'/media/images/flatform/'.$head_footer->fl_dir_banner.'/'.$head_footer->fl_banner ?>') no-repeat center / cover"></div>
                            </div>
                        </div>
                        <div class="shop_logo text-center">
                            <div style="vertical-align: middle; display: table-cell; width:100px; height:100px;">            
                                <a href="/flatform/product" style=" border: 1px solid #f9f9f9; display: block; height:100%; background: url('<?php echo DOMAIN_CLOUDSERVER.'/media/images/flatform/'.$head_footer->fl_dir_logo.'/'.$head_footer->fl_logo ?>') no-repeat center / 100% auto"></a>
                            </div>
                        </div>
                        <div class="shop_name text-center">
                            <h1 style="font-size:18px; margin: 20px 0;">
                                <a href="/flatform/product"><?php echo $head_footer->fl_name ?></a>
                            </h1>
                        </div>
                        <div class="shop_bar" style="border-top: 1px solid #ddd;">
                            <ul class="menu-justified dropdown" style="font-size:12px;">
                                <li class="">
                                    <a id="dLabel" data-target="#" href="/" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="/templates/home/icons/black/icon-hand.png" alt=""><br>Loại tin
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                                        <li>
                                            <a href="/flatform/news/hot"><img src="/templates/home/icons/black/icon-coupon.png" alt=""> &nbsp; Tin tức hot </a>
                                        </li>
                                        <li>
                                            <a href="/flatform/news/sale"><img src="/templates/home/icons/black/icon-gift.png" alt=""> &nbsp; Tin khuyến mãi </a>
                                        </li>
                                        <li>
                                            <a href="/flatform/news/view"><img src="/templates/home/icons/black/cubes.png" alt=""> &nbsp; Tin xem nhiều </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="">
                                    <a href="tel:<?php echo $head_footer->fl_mobile ?>" onclick="_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);">
					<img src="/templates/home/icons/black/icon-call.png" alt=""><br>Gọi ngay
				    </a>
                                </li>
				
				<?php
				if ($head_footer->fl_facebook) {
				    $face = explode("https://www.facebook.com/", $head_footer->fl_facebook);
				    $facebook_id = str_replace('profile.php?id=', '', $face[1]);
				    ?>
    				<li class="">
    				    <a target="_blank" href="https://www.messenger.com/t/<?php echo $facebook_id ?>"><img src="/templates/home/icons/black/icon-comment.png" alt=""><br>Nhắn tin</a>
    				</li>
				<?php } else { ?>
    				<li class="">
    				    <a target="_blank" href="sms:<?php echo $head_footer->fl_mobile ?>"><img src="/templates/home/icons/black/icon-comment.png" alt=""><br>Nhắn tin</a>
    				</li>
				<?php } ?>

                                <li class="">
                                    <a id="dLabel" data-target="#" href="<?php echo $ogurl ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="/templates/home/icons/black/share-outline.png" alt=""><br>Chia sẻ
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                                        <li>
                                            <div class="social">
                                                <a href="javascript:void(0)" onclick=" window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $ogurl ?>&app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=600,height=450'); return false;">
                                                    <img src="/templates/home/icons/icon-facebook.png" alt=""/>
                                                </a> &nbsp;
                                                <a href="javascript:void(0)" onclick="window.open('http://twitter.com/share?text=<?php echo $head_footer->fl_name ?>&url=<?php echo $ogurl ?>', 'twitter-share-dialog', 'width=600,height=450'); return false;">
                                                    <img src="/templates/home/icons/icon-twitter.png" alt=""/>
                                                </a> &nbsp;
                                                <a href="javascript:void(0)" onclick="window.open('http://plus.google.com/share?url=<?php echo $ogurl ?>', 'google-share-dialog', 'width=600,height=450');return false;">
                                                    <img src="/templates/home/icons/icon-google-plus.png" alt=""/>
                                                </a>
                                                <a href="mailto:someone@example.com?Subject=<?php echo $head_footer->fl_name ?>&Body=<?php echo $head_footer->fl_desc ?> - <?php echo $ogurl ?>">
                                                    <img src="/templates/home/icons/black/icon-email.png" alt=""/>
                                                </a> &nbsp;
                                            </div>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="copylink('<?php echo $ogurl ?>')">
                                                <img src="/templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                            </ul>
                        </div>
                    </div>
		    <?php if(count($listNews)>0) { ?> 
                    <div class="newfeeds">
                    <?php foreach ($listNews as $k => $item) { ?>                 
                        <?php $this->load->view('flatform/news/item', array('item' => $item)); ?>
                    <?php } ?> 
                    </div>
		    <?php } else { ?> 
		    <div class="alert alert-success" role="alert">
			Chưa có tin tức nào.
		    </div>
		    <?php } ?>
                    
                </div>
               
                <div class="col-sm-3 hidden-xs" style="position: static">
                    <div class="panel panel-default fixtoscroll">
                        <div class="panel-heading">      
                            <div class="input-group">
                                <input id="keySearch" type="text" class="form-control" placeholder="Tìm gian hàng" aria-describedby="basic-addon1" onkeyup="myFunction();">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                            </div>
                        </div>    
                        <div class="panel-body" style="height:calc(100vh - 148px); overflow: auto;">        
                            <ul id="listSearch" class="listshop list-unstyled">
                                <?php
                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
				foreach ($listShop as $value) {
                                    if ($value->domain != '') {
                                        $linktoshop = $protocol . $value->domain;
                                    } else {
                                        $linktoshop = $protocol . $value->sho_link . '.' . domain_site;
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo $linktoshop ?>/shop">
                                            <span>
                                                <span>
                                                    <img src="<?php echo DOMAIN_CLOUDSERVER . '/media/shop/logos/' . $value->sho_dir_logo . '/' . $value->sho_logo ?>" alt="logo"/> 
                                                </span> 
                                            </span>                                  
                                            <?php echo $value->sho_name ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <script>
                        function myFunction() {
                            var input, filter, ul, li, a, i;
                            input = document.getElementById("keySearch");
                            filter = input.value.toUpperCase();
                            ul = document.getElementById("listSearch");
                            li = ul.getElementsByTagName("li");
                            for (i = 0; i < li.length; i++) {
                                a = li[i].getElementsByTagName("a")[0];
                                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                    li[i].style.display = "";
                                } else {
                                    li[i].style.display = "none";
                                }
                            }
                        }
                    </script>
                </div>
                
                
<?php if ($this->session->userdata('sessionUser') != 0) { ?>
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
        <div class="modal-dialog" role="document">
    	<div class="modal-content">
    	    <form id="frmReport" name="frmReport" action="/home/tintuc/report" method="post" class="form" enctype="multipart/form-data">   
    		<div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		    <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo bài viết</h4>
    		</div>
    		<div class="modal-body">
    		    <input id="reportpost" name="not_id" type="hidden" value="">
    		    <input id="reportlink" name="not_link" type="hidden" value="">
			<?php foreach ($listreports as $key => $value) { ?>
			    <div class="radio">
				<label>
				    <input type="radio" name="rp_id" id="optionsReport" value="<?php echo $value->rp_id ?>" <?php echo $key == 0 ? 'checked' : '' ?> >
				    <?php echo $value->rp_desc ?>
				</label>
			    </div>			
			<?php } ?>
                    <textarea type="text" name="rpd_reason" id="rpd_reason" placeholder="Nhập nội dung báo cáo" class="" style="display: none; resize: none; width: 100%; padding: 5px;"/></textarea>
                </div>
    		<div class="modal-footer">
    		    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
    		    <button type="submit" class="btn btn-primary">Gửi báo cáo</button>
    		</div>
    	    </form>
    	</div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('input[name=rp_id]').each(function(){
                $(this).change(function () {
                    if ($(this).val() == '6' && $(this).is(':checked')) {
                        $('#rpd_reason').fadeIn(400);
                        $('#rpd_reason').attr('required','required');
                    }else{
                        $('#rpd_reason').fadeOut(0);
                        $('#rpd_reason').removeAttr('required');
                    }
                });
            });
        });
    
        $('.report').click(function () {
            $('#reportpost').attr('value', $(this).data('id'));
            $('#reportlink').attr('value', $(this).data('link'));
        });
        
        var frm = $('#frmReport');
        frm.submit(function (e) {
    	e.preventDefault();
    	$.ajax({
    	    type: frm.attr('method'),
    	    url: frm.attr('action'),
    	    data: frm.serialize(),
    	    success: function (data) {
    		var mes = '';
    		$('#reportModal').modal('hide');
    		if (data == '0') {
    		    mes = 'Bạn đã gửi báo cáo bài viết này rồi. Cảm ơn bạn!';
    		} else if (data == '1') {
    		    mes = 'Gửi báo cáo bài viết thành công. Cảm ơn bạn!';
    		}
    		$.jAlert({
    		    'title': 'Thông báo',
    		    'content': mes,
    		    'theme': 'default',
    		    'btns': {
    			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
    			    e.preventDefault();
                            location.reload();
    			    return false;
    			}
    		    }
    		});
    	    },
    	    error: function (data) {
    		$('#reportModal').modal('show');
    	    }
    	});
        });
    </script> 
<?php } else { ?>
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
        <div class="modal-dialog" role="document">
    	<div class="modal-content">
    	    <div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		<h4 class="modal-title" id="reportModalLabel">Gửi báo cáo bài viết</h4>
    	    </div>
    	    <div class="modal-body">
    		<div class="alert alert-warning" role="alert">
    		    Bạn chưa đăng nhập, vui lòng <a href="/login">đăng nhập</a> vào để sử dụng tính năng này!
    		</div>
    	    </div>
    	    <div class="modal-footer">
    		<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>			
    	    </div>		
    	</div>
        </div>
    </div>
<?php } ?>

                
                <div class="col-sm-2  hidden-xs" style="position: static">
                    <?php $this->load->view('flatform/common/ads'); ?>
                </div>
               
            </div>
            <div class="row"></div>
        </div><!-- /container -->
	<script> 
	    function copylink(link) { clipboard.copy(link); }    
		jQuery(function($){
		    $('.fixtoscroll').scrollToFixed( { 
				marginTop: function() { 
					var marginTop = $(window).height() - $(this).outerHeight(true) - 0; 
					if (marginTop >= 0) return 75; 
					return marginTop; 
				},
				limit: function() {
					var limit = 0;
					limit = $('#footer').offset().top - $(this).outerHeight(true) - 0;
					return limit;
				}            
			});
		    $('.lazy').lazy();
		    $('.owl-carousel').owlCarousel({
			 loop: false,
			 margin: 10,
			 nav: true,
			 dots: false,	  
			 responsive:{
			     0:{
				 items: 1
			     },
			     600:{
				 items: 2
			     }
			 }
		    });	
		    var w = $( window ).width();
		    var h = $( window ).height();        
		    if(w >= 1180){
			$('.quangcao').scrollToFixed( { 
			    marginTop: function() { 
				var marginTop = $(window).height() - $(this).outerHeight(true) - 0; 
				if (marginTop >= 0) return 75; 
				return marginTop; 
			    },
			    limit: function() {
				var limit = 0;
				limit = $('#footer').offset().top - $(this).outerHeight(true) - 0;
				return limit;
			    } 
			});
		    }

		    var itempost = $('.wowslider-container');
		    var tolerancePixel = 300;          
		    function checkMedia(){
			var scrollTop = $(window).scrollTop() + tolerancePixel;
			var scrollBottom = $(window).scrollTop() + $(window).height() - tolerancePixel;                
			itempost.each(function(index, el) {
			    var yTopMedia = $(this).offset().top;
			    var yBottomMedia = $(this).height() + yTopMedia;
			    if(scrollTop < yBottomMedia && scrollBottom > yTopMedia){ 
				itempost.swipe( {                               
				    swipeLeft:function(event, direction, distance, duration, fingerCount) {
					$(this).find(".ws_play").click();                            
				    },
				    swipeRight:function(event, direction, distance, duration, fingerCount) {
					$(this).find(".ws_play").click();                      
				    },                                
				    threshold:100
				});                    
			    } else {                    
				$(this).find(".ws_pause").click();                    
			    }
			});
		    }        
		    $(document).on('scroll', checkMedia);
	    });
	</script>
<?php $this->load->view('flatform/common/footer');?>

        
