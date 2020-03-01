<?php
foreach ($province as $item) {
    if ($item->pre_id == $siteGlobal->sho_province) {
        $siteGlobal->sho_province = $item->pre_name;
    }
}
$call_number = !empty($siteGlobal->sho_mobile) ? $siteGlobal->sho_mobile : $siteGlobal->sho_phone;
?>
<div class="container">
<br>          
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div style="text-transform: uppercase"><?php if ($siteGlobal->sho_name) { ?><?php echo $siteGlobal->sho_name ?><?php } ?></div>
            <div>
                <?php if ($siteGlobal->sho_address) { ?><i class="fa fa-map-marker fa-fw"></i> <?php echo $siteGlobal->sho_address . ', ' . $siteGlobal->sho_district . ', ' . $siteGlobal->sho_province ?><?php } ?>                       
                <br>
                <?php if ($siteGlobal->sho_mobile) { ?><i class="fa fa-mobile fa-fw"></i> <?php echo $siteGlobal->sho_mobile ?> <?php } ?>
                <?php if ($siteGlobal->sho_phone) { ?> &nbsp; <i class="fa fa-phone fa-fw"></i> <?php echo $siteGlobal->sho_phone ?> <?php } ?>
                <?php if ($siteGlobal->shop_fax) { ?> &nbsp; <i class="fa fa-fax fa-fw"></i> <?php echo $siteGlobal->shop_fax ?> <?php } ?>
                <br>
                <?php if ($siteGlobal->sho_email) { ?><i class="fa fa-envelope-o fa-fw"></i> <?php echo $siteGlobal->sho_email ?> <?php } ?>             
                <?php if ($siteGlobal->sho_website) { ?><i class="fa fa-globe fa-fw"></i> <?php echo $siteGlobal->sho_website ?> <?php } ?>
            </div>        
        </div>        
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="followus">Kết nối trên: <br>
                <a href="<?php echo $siteGlobal->sho_facebook ?>"><i class="fa fa-facebook  fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_twitter ?>"><i class="fa fa-twitter fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_google_plus?>"><i class="fa fa-google-plus fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_youtube ?>"><i class="fa fa-youtube fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_vimeo ?>"><i class="fa fa-vimeo fa-fw"></i></a>&nbsp;
            <br>Bản quyền &copy; 2015 - <?php echo $siteGlobal->sho_link ?>
            <br> Phát triển bởi Azibai.com</div>            
        </div>
    </div>
</div>
