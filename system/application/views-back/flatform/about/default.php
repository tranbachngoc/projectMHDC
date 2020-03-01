<?php $this->load->view('flatform/common/header_shop'); ?>

<div class="container" role="main">
    <br>
    <h1><span>Giới thiệu</span></h1>
    <br>
    <div class="row">
	<div class="col-xs-12 col-sm-6" style="margin-bottom: 20px">	    
	    <h2 style="margin-top: 0"><?php echo $head_footer->fl_name ?></h2>
	    <p><?php echo $head_footer->fl_desc ?></p>
	    <p><i class="fa fa-envelope-o fa-fw"></i> <?php echo $head_footer->fl_email ?></p>
	    <p><i class="fa fa-mobile fa-fw"></i> <?php echo $head_footer->fl_mobile ?></p>
            <?php echo ($head_footer->fl_hotline != '') ? '<p><i class="fa fa-phone fa-fw"></i> '.$head_footer->fl_hotline.'</p>' : ''; ?>
            <?php echo ($head_footer->fl_address != '') ? '<p><i class="fa fa-map-marker fa-fw"></i> '.$head_footer->fl_address.', '.$head_footer->fl_district. ', ' .$head_footer->fl_province.'</p>' : ''; ?>
	    <ul class="list-inline">
		<li><a <?php echo ($head_footer->fl_facebook != '') ? 'target="_blank" href="'.$head_footer->fl_facebook.'"' : '#' ?>  class="facebook"><i class="fa fa-facebook-square fa-2x"></i></a></li>
		<li><a <?php echo ($head_footer->fl_twitter != '') ? 'target="_blank" href="'.$head_footer->fl_twitter.'"' : '#' ?> class="twitter"><i class="fa fa-twitter-square fa-2x"></i></a></li>
		<li><a <?php echo ($head_footer->fl_youtube != '') ? 'target="_blank" href="'.$head_footer->fl_youtube.'"' : '#' ?>  class="youtube"><i class="fa fa-youtube-square fa-2x"></i></a></li>
		<li><a <?php echo ($head_footer->fl_google_plus != '') ? 'target="_blank" href="'.$head_footer->fl_google_plus.'"' : '#' ?>  class="google-plus"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
	    </ul>
	</div>	    
	<div class="col-xs-12 col-sm-6" style="margin-bottom: 20px">	    
	    <div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $head_footer->fl_video ?>"></iframe>
	    </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12" style="margin-bottom: 20px">
            <?php 
            $s = preg_replace('/(?<!href="|">)(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $head_footer->fl_introduction);
            echo $s = '<p>' . str_replace("\n", "</p><p>", $s) . '</p>';
            ?> 
	</div>
    </div>
</div>

<?php $this->load->view('flatform/common/footer'); ?>