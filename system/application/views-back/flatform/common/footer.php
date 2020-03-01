<div id="footer">
    <div class="container">
	    <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="text-uppercase"><strong><?php echo $head_footer->fl_name ?></strong></div>
                <div>Email: <?php echo $head_footer->fl_email ?></div>
                <div>Mobile: <?php echo $head_footer->fl_mobile ?><?php echo $head_footer->fl_hotline != '' ? ' | Hotline: '.$head_footer->fl_hotline : ''; ?></div>
                <div>Địa chỉ: <?php echo $head_footer->fl_address ?>, <?php echo $head_footer->fl_district ?>, <?php echo $head_footer->fl_province ?></div>
                <ul class="list-inline">
                    <li><a <?php echo ($head_footer->fl_facebook != '') ? 'target="_blank" href="'.$head_footer->fl_facebook.'"' : '' ?> class="facebook"><i class="fa fa-facebook-square fa-2x"></i></a></li>
                    <li><a <?php echo ($head_footer->fl_twitter != '') ? 'target="_blank" href="'.$head_footer->fl_twitter.'"' : '' ?> class="twitter"><i class="fa fa-twitter-square fa-2x"></i></a></li>
                    <li><a <?php echo ($head_footer->fl_youtube != '') ? 'target="_blank" href="'.$head_footer->fl_youtube.'"' : '' ?> class="youtube"><i class="fa fa-youtube-square fa-2x"></i></a></li>
                    <li><a <?php echo ($head_footer->fl_google_plus != '') ? 'target="_blank" href="'.$head_footer->fl_google_plus.'"' : '' ?> class="google-plus"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
                </ul>
            </div>
        </div>
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
        <style>
            .alert {
                margin-bottom: 0px;
            }
            #toTop { position: fixed; bottom:30px; right:30px; z-index: 999; padding:4px 6px; display: none; color:#999;border: 1px solid #999; border-radius: 50%; }
        </style>
</div>
<a id="toTop" href="#"><i class="fa fa-angle-up fa-fw"></i></a>
</body>
</html>