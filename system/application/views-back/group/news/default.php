<?php $this->load->view('group/news/common/header'); ?>
<link href="https://fonts.googleapis.com/css?family=Anton|Arsenal|Exo|Francois+One|Muli|Nunito+Sans|Open+Sans+Condensed:300|Oswald|Pattaya|Roboto+Condensed|Saira+Condensed|Saira+Extra+Condensedsubset=latin-ext,vietnamese" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="/templates/home/lightgallery/dist/css/lightgallery.css" />

<div id="main" class="container-fluid">
    <div class="row rowmain">          
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/menu-left'); ?>            
        </div>   
        <div class="col-xs-12 col-sm-5">            
            <?php $this->load->view('group/news/common/group-top'); ?>
            <?php $this->load->view('group/news/common/block-about'); ?>
            <?php $this->load->view('group/news/common/block-product'); ?>
            <?php $this->load->view('group/news/common/block-video'); ?>
            
            <div class="group-news">
		<div id="content" class="newfeeds" data-type="<?php echo $this->uri->segment(2); ?>">                                      
		 <?php foreach ($list_news as $item) { ?>
		     <?php $this->load->view('group/news/item', array('item' => $item)); ?>		    
		 <?php } ?>
		 </div>          
		 <div class="text-center">
		     <i class="fa fa-spinner fa-spin" id="loadding" style="font-size:24px;"></i>
		 </div>
            </div>
        </div> 
        <div class="col-xs-12 col-sm-3 hidden-xs"> 
                    <div class="panel panel-default fixtoscroll">                
                        <div class="panel-heading"><strong>Sản phẩm mới</strong></div>
                        <div class="panel-body">                     
                            <?php foreach ($products as $key => $item) { $images = explode(',', $item->pro_image);?>
			    <div class="media"> 
                                    <div class="media-left">
					<div style="width:100px; height:100px;">
					    <a href="<?php echo site_url('grtshop/product/detail/'.$item->pro_id.'/'. RemoveSign($item->pro_name));?>">
						<img class="media-object img-responsive img-thumbnail" alt="" style="width:100px; height:100px;"
						     src="<?php
						     if ($item->pro_image!="") {
							 echo DOMAIN_CLOUDSERVER.'media/images/product/' . $item->pro_dir . '/thumbnail_1_' . $images[0];
						     } else {
							 echo site_url('media/images/no_photo_icon.png');
						     }
						     ?>"/>
					    </a>
					</div>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <a href="<?php echo site_url('grtshop/product/detail/'.$item->pro_id.'/'. RemoveSign($item->pro_name));?>">
                                                <?php echo $item->pro_name ?>
                                            </a>
                                        </div> 
                                        <!--<div class="price"><strong class="text-danger"><?php echo number_format($item->pro_cost) ?> đ</strong> </div>-->
                                    </div> 
                                </div>
                            <?php } ?>

                        </div>                
                    </div>  
                
           
        </div>      
         <div class="col-xs-12 col-sm-2 hidden-xs">
             <?php $this->load->view('group/news/common/ads-right'); ?>               
        </div> 
    </div> 
    
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
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script>
function copylink(link) { clipboard.copy(link); }  
jQuery(function($){
	$('#pictures_gallery .owl-carousel, #videos_gallery .owl-carousel').owlCarousel({loop: false, margin: 10, nav: true, dots: false, autoplay:true, autoplayTimeout:3000, autoplayHoverPause:true, responsive:{ 0:{ items:2 }, 1300:{ items:3 } } })
	$('#pictures_gallery, #videos_gallery').lightGallery({ selector: '.item', download: false });
	$('.fixtoscroll').scrollToFixed({ marginTop: function () { var marginTop = $(window).height() - $(this).outerHeight(true) - 0; if (marginTop >= 0) return 75; return marginTop; }, limit: function () { var limit = 0; limit = $('#footer').offset().top - $(this).outerHeight(true) - 0; return limit; } });  
	
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
				url         : '/home/grouptrade/getmoreindex',
				data        : {page : page, type: $element.attr('data-type')},
				
				success     : function (result)
				{  
					if(result == '')
					{
						stopped = true;
						$loadding.addClass('hidden');
					}
					$element.append(result);
					$('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
					$('.rowpro .owl-carousel').owlCarousel({ loop: true, margin: 5, nav: true, dots: false, responsive:{ 0:{ items:1 }, 600:{ items:2 } } });
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
	
	$('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
	$('.rowpro .owl-carousel').owlCarousel({ loop: true, margin: 5, nav: true, dots: false, responsive:{ 0:{ items:1 }, 600:{ items:2 } } });
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
}); 
</script>
<?php $this->load->view('group/news/common/footer'); ?>   
