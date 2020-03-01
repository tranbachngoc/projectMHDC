        <footer id="footer">
	    <div class="container">
		<div class="row footer-row-2">
		    <div class="col-xs-12 col-sm-3">
			<h4>CÁCH THỨC THANH TOÁN</h4>
			<ul class="list-inline footer-payment">
			    <li><img src="/templates/group/images/footer-payment.png" alt="footer-payment" height="40"/></li>		
			</ul>					
		    </div>
		    <div class="col-xs-12 col-sm-6">
			<h4>ĐỐI TÁC VẬN CHUYỂN</h4>
			<ul class="list-inline footer-transport">
			    <li><img src="/templates/group/images/footer-transpost-1.jpg" alt="footer-transpost-1" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-2.jpg" alt="footer-transpost-2" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-3.jpg" alt="footer-transpost-3" height="40"/></li>
			    <li><img src="/templates/group/images/footer-transpost-4.jpg" alt="footer-transpost-4" height="40"/></li>
			</ul>						
		    </div>
		    <div class="col-xs-12 col-sm-3">
			<h4>CHỨNG NHẬN</h4>
			<ul class="list-inline footer-certificate">
			    <li><img src="/images/dadangky.png" height="39"/></li>
			    <li><img src="/images/dathongbao.png" height="39"/></li>
			</ul>			
		    </div>
		</div>
                <hr/>
		<div class="footer-copyright text-center" style="font-size:small;">
                    <h4><?php echo $siteGlobal->grt_name; ?></h4>
                    <?php echo $siteGlobal->grt_desc; ?><br/>
                    <i class="fa fa-map-marker fa-fw"></i> Trụ sở: <?php echo $siteGlobal->grt_address .', '.$siteGlobal->district.', '.$siteGlobal->province; ?><br/>
                    <i class="fa fa-phone fa-fw"></i> Điện thoại: <?php echo $siteGlobal->grt_phone; ?> &nbsp;<i class="fa fa-mobile fa-fw"></i>Hotline: <?php echo $siteGlobal->grt_mobile; ?><br/>
                    <i class="fa fa-envelope fa-fw"></i> Email: <?php echo $siteGlobal->grt_email; ?>                  
                </div>
	    </div>
        </footer>
        <a id="scrolltop" href="#" class="fa fa-angle-up fa-2x fa-fw" style="display: none; color:black; border: 2px solid; padding: 2px 8px; position: fixed; bottom: 30px; right: 30px; border-radius: 50%;"></a>
        <script src="/templates/home/js/jquery.min.js" ></script>
        <script src="/templates/home/js/bootstrap.min.js" ></script>    
        <script src="/templates/group/js/owl.carousel.js" ></script>
	
        <script src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
        <script src="/templates/home/js/check_email.js"></script>
        <script src="/templates/home/js/select2.full.min.js"></script>
        <script src="/templates/group/js/ie10-viewport-bug-workaround.js" ></script>
        <script>
            var siteUrl = "<?php echo getAliasDomain(); ?>"
        </script>
	<script type="text/javascript" language="javascript" src="/templates/group/js/general.js"></script>
        <script>
        jQuery(function($){
            $('.banner-owl-carousel').owlCarousel({loop:true, responsiveClass:true, items:1, nav:true, dots:false,autoplay:true, autoplayTimeout:3000, autoplayHoverPause:true });
            $('.product-owl-carousel').owlCarousel({ loop:false, responsiveClass:true, nav:true, responsive:{ 0:{ items:2, margin:5 }, 600:{ items:3, margin:10 }, 1000:{ items:5, margin:20 } } });
            $('.product-owl-carousel-2').owlCarousel({ loop:true, responsiveClass:true, nav:true, responsive:{ 0:{ items:1, margin:0 }, 600:{ items:1, margin:0 }, 1000:{ items:1, margin:0 } } });
            $('.tofloor').click(function(e){ e.preventDefault(); var aTag = $(this).attr('href'); $('html,body').animate({scrollTop: $(aTag).offset().top},'slow'); });
            $('#scrolltop').click(function(e){ e.preventDefault(); $('html,body').animate({scrollTop: 0},'slow'); });
	    $(window).scroll(function() { var scroll = $(window).scrollTop(); if (scroll >= 500) { $('#scrolltop').fadeIn(); } else { $('#scrolltop').fadeOut(); } });
	    
	    var w = $(window).width();
	    if(w<768){
		$('.collapse').removeClass('in')
	    } else {
		$('.collapse').addClass('in');
	    }
	    var cl = 0;
	    $('.showmorecat').click(function(){ 
		$(this).prev().slideToggle('fast');
		if(cl == 0){
		    $(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up'); cl = 1;
		}else{
		    $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down'); cl = 0;
		};		
	    })
	    
//	    $(".dropdown").hover(
//		function() { $('.dropdown-menu', this).fadeIn("fast");
//		},
//		function() { $('.dropdown-menu', this).fadeOut("fast");
//	    });
        });
        </script>
        <script>
              $(document).ready(function()
                {
                    close_outside('.menu_','.mega-dropdown-menu');
                    close_outside('li.show_menubar1','li.show_menubar1 .dropdown-menu');
                    close_outside('li.show_menubar2','li.show_menubar2 .dropdown-menu');
                });
        </script>
</div>

        
        
        <!-- Begin:: Modal thông báo dịch vụ -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true"
             style="top:50%; margin-top: -40px;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <!-- End:: Modal thông báo dịch vụ -->
    </body>
</html>