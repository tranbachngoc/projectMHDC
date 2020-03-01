<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div><span class="text-uppercase">
                <?php if ($siteGlobal->sho_name){ ?><?php echo $siteGlobal->sho_name ?>
            </span><br><?php } ?>	    
            <?php if ($siteGlobal->sho_address) { ?><i class="fa fa-map-marker fa-fw"></i> <?php echo $siteGlobal->sho_address.', '.$siteGlobal->sho_district.', '.$siteGlobal->sho_province; ?> &nbsp;<br><?php } ?>
            <?php if ($siteGlobal->sho_mobile) { ?><i class="fa fa-tablet fa-fw"></i> <?php echo $siteGlobal->sho_mobile ?> &nbsp;<?php } ?>
            <?php if ($siteGlobal->sho_phone) { ?><i class="fa fa-phone fa-fw"></i> <?php echo $siteGlobal->sho_phone ?> &nbsp;<?php } ?>
            <?php if ($siteGlobal->shop_fax) { ?><i class="fa fa-fax fa-fw"></i> <?php echo $siteGlobal->shop_fax ?> &nbsp;<?php } ?><br>
            <?php if ($siteGlobal->sho_email) { ?><i class="fa fa-envelope-o fa-fw"></i> <?php echo $siteGlobal->sho_email ?> &nbsp;<?php } ?>
            <?php if ($siteGlobal->sho_website) { ?><i class="fa fa-globe fa-fw"></i> <?php echo $siteGlobal->sho_website ?> &nbsp;<?php } ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">            
            <div class="followus"> Kết nối với chúng tôi:<br>
                <a href="<?php echo $siteGlobal->sho_facebook ?>"><i class="fa fa-facebook fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_twitter ?>"><i class="fa fa-twitter fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_google_plus?>"><i class="fa fa-google-plus fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_youtube ?>"><i class="fa fa-youtube fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_vimeo ?>"><i class="fa fa-vimeo fa-fw"></i></a>&nbsp;
            </div>
            <div>
                Bản quyền <i class="fa fa-copyright fa-fw"></i> 2015 - <span class="text-uppercase"><?php echo $siteGlobal->sho_link ?></span><br> Thiết kế và phát triển bởi <span class="text-uppercase">Azibai</span>
            </div>
        </div>
    </div>
</div>
<div id="aziload"  style="display: none;">
    <span class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
</div>
