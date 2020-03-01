            <div id="footer">
                <div class="container">
                    <div class="text-center">                        
                        <br/>
                        <p>
                            <strong class="text-uppercase"><?php echo $get_grt->grt_name; ?></strong> - <?php echo $get_grt->grt_desc; ?><br>	    
                            <i class="fa fa-map-marker fa-fw"></i> <?php echo $get_grt->grt_address .', '.$get_grt->district.', '.$get_grt->province ?><br>
                            <i class="fa fa-phone fa-fw"></i> <?php echo $get_grt->grt_phone; ?> &nbsp;
                            <i class="fa fa-tablet fa-fw"></i> <?php echo $get_grt->grt_mobile; ?> &nbsp;
                            <i class="fa fa-envelope-o fa-fw"></i> <?php echo $get_grt->grt_email; ?><br>
                            Bản quyền 2017 - <span class="text-uppercase"><?php echo $get_grt->grt_name; ?></span>. Thiết kế và phát triển bởi <span class="text-uppercase">Azibai.com</span>.
                        </p>                 
                    </div>
                </div>
            </div>            
        </div>
	<?php
	if (isset($js)) {
	    echo $js;
	} else {
	    echo '<script type="text/javascript" defer src="' . loadJs(array(
		'home/js/jquery-migrate-1.2.1.js',
		'home/js/bootstrap.min.js',
		'home/js/wow.min.js',
		'home/js/jAlert-master/jAlert-v3.min.js',
		'home/js/jAlert-master/jAlert-functions.min.js',
		'home/js/jquery.validate.js'
		), 'asset/home/grtnews.min.js') . '"></script>';
	}
	?>
    </body>
</html>
