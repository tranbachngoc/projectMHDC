
        <div id="footer"  style="background:#ff9900; color: #fff">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">    
                        <div class="text-center">                            
                            <div style="font-size:small; padding:15px 15px 0;">
                                <strong class="text-uppercase"><?php echo $shop->sho_name ?></strong><br>
                                <i class="fa fa-map-marker fa-fw"></i> Địa chỉ: <?php echo $shop->sho_address .', '. $shop->sho_district .', '. $shop->sho_province ?><br/>
                                <i class="fa fa-phone fa-fw"></i> Điện thoại: <?php echo $shop->sho_phone; ?> &nbsp;<i class="fa fa-mobile fa-fw"></i>Hotline: <?php echo $shop->sho_mobile; ?><br/>
                                <i class="fa fa-envelope fa-fw"></i> Email: <?php echo $shop->sho_email?$shop->sho_email:'Đang cập nhật'; ?> <br/>
                            </div>
                        </div>
                        <div class="text-center">
                            <div style="font-size:small; padding:15px 15px 15px;">
                                <a class="btn btn-danger" href="<?php echo $shop->sho_facebook?$shop->sho_facebook:'#footer' ?>"><i class="fa fa-facebook fa-fw"></i></a>
                                <a class="btn btn-danger" href="<?php echo $shop->sho_twitter?$shop->sho_twitter:'#footer' ?>"><i class="fa fa-twitter fa-fw"></i></a>
                                <a class="btn btn-danger" href="<?php echo $shop->sho_youtube?$shop->sho_youtube:'#footer' ?>"><i class="fa fa-youtube fa-fw"></i></a>
                                <a class="btn btn-danger" href="<?php echo $shop->sho_google_plus?$shop->sho_google_plus:'#footer' ?>"><i class="fa fa-google-plus fa-fw"></i></a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>      
        </div>
        <!-- footer -->

    </div>   


</html>