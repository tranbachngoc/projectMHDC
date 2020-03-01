            <div id="footer">
                <div class="container">
                    <div class="row text-center">                        
                        <br/>
                        <p>
                            <strong class="text-uppercase">AZIBAI - CỘNG ĐỒNG DOANH NGHIỆP KINH DOANH ONLINE</strong><br>	    
                            <i class="fa fa-map-marker fa-fw"></i> <?php if(isset($siteGlobal) && $siteGlobal->grt_address != ''){echo $siteGlobal->grt_address; } ?><?php if(isset($siteGlobal) && $siteGlobal->district != ''){echo ', '.$siteGlobal->district; } ?><?php if(isset($siteGlobal) && $siteGlobal->province != ''){echo ', '.$siteGlobal->province; } ?> &nbsp;<br>                           
                            <?php if(isset($siteGlobal)) { ?>
                                <?php if($siteGlobal->grt_phone != '') { ?>
                                    <i class="fa fa-phone fa-fw"></i><?php echo $siteGlobal->grt_phone; ?> &nbsp;
                                <?php } ?>
                                <?php if($siteGlobal->grt_mobile != '') { ?>
                                    <i class="fa fa-tablet fa-fw"></i><?php echo $siteGlobal->grt_mobile; ?> &nbsp;
                                <?php } ?>
                                <?php if($siteGlobal->grt_email != '') { ?>
                                    <i class="fa fa-envelope-o fa-fw"></i><?php echo $siteGlobal->grt_email; ?><br>
                                <?php } ?>
                             <?php } ?>                           
                            Bản quyền 2017 - <span class="text-uppercase"><?php if(isset($siteGlobal)){echo $siteGlobal->grt_name; } ?></span>. Thiết kế và phát triển bởi <span class="text-uppercase">Azibai.com</span>.
                        </p>                 
                    </div>
                </div>
            </div>            
        </div>
    </body>
</html>
