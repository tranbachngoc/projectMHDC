<?php
foreach ($province as $item) {
    if ($item->pre_id == $siteGlobal->sho_province) {
        $siteGlobal->sho_province = $item->pre_name;
    }
}
$call_number = !empty($siteGlobal->sho_mobile) ? $siteGlobal->sho_mobile : $siteGlobal->sho_phone;
?>
<br/>
<div class="container">
<br>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
            <p><span class="text-uppercase">
                <?php if ($siteGlobal->sho_name){ ?><i class="fa fa-home fa-fw"></i> <?php echo $siteGlobal->sho_name ?></span><br><?php } ?>
                <?php if ($siteGlobal->sho_address) { ?><i class="fa fa-map-marker fa-fw"></i> <?php echo $siteGlobal->sho_address . ', ' . $siteGlobal->sho_district . ', ' . $siteGlobal->sho_province ?> &nbsp;<?php } ?>
                <?php if ($siteGlobal->sho_mobile) { ?><br><i class="fa fa-tablet fa-fw"></i> <?php echo $siteGlobal->sho_mobile ?> &nbsp;<?php } ?>
                <?php if ($siteGlobal->sho_phone) { ?><i class="fa fa-phone fa-fw"></i> <?php echo $siteGlobal->sho_phone ?> &nbsp;<?php } ?>
                <?php if ($siteGlobal->shop_fax) { ?><i class="fa fa-fax fa-fw"></i> <?php echo $siteGlobal->shop_fax ?> &nbsp;<?php } ?>
                <?php if ($siteGlobal->sho_email) { ?><br><i class="fa fa-envelope-o fa-fw"></i> <?php echo $siteGlobal->sho_email ?> &nbsp;<?php } ?>
                <?php if ($siteGlobal->sho_website) { ?><i class="fa fa-globe fa-fw"></i> <?php echo $siteGlobal->sho_website ?> &nbsp;<?php } ?>
            </p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <p class="followus">Kết nối trên: 
                <a href="<?php echo $siteGlobal->sho_facebook ?>"><i class="fa fa-facebook fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_twitter ?>"><i class="fa fa-twitter fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_google_plus?>"><i class="fa fa-google-plus fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_youtube ?>"><i class="fa fa-youtube fa-fw"></i></a>&nbsp;
                <a href="<?php echo $siteGlobal->sho_vimeo ?>"><i class="fa fa-vimeo fa-fw"></i></a></p>
            <p>
                Bản quyền &copy; 2015 - <span class="text-uppercase"><?php echo $siteGlobal->sho_link ?></span><br>Phát triển web bởi <span class="text-uppercase">Azibai.com</span>
            </p>
        </div>
    </div>
</div>

