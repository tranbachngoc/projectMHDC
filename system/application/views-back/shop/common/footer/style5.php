<?php
$call_number = !empty($siteGlobal->sho_mobile) ? $siteGlobal->sho_mobile : $siteGlobal->sho_phone;
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12 ">
	    <div style="padding: 20px 0 0">
		<?php if ($siteGlobal->sho_name){ ?>
		    <i class="fa fa-home fa-fw"></i> <span class="text-uppercase"><?php echo $siteGlobal->sho_name ?></span><br>
		<?php } ?>
		<?php if ($siteGlobal->sho_address) { ?><i class="fa fa-map-marker fa-fw"></i> <?php echo $siteGlobal->sho_address . ', ' . $siteGlobal->sho_district . ', ' . $siteGlobal->sho_province ?> &nbsp;<br><?php } ?>
		<?php if ($siteGlobal->sho_phone) { ?><i class="fa fa-phone fa-fw"></i> <?php echo $siteGlobal->sho_phone ?> &nbsp;<?php } ?>
		<?php if ($siteGlobal->sho_mobile) { ?><i class="fa fa-tablet fa-fw"></i> <?php echo $siteGlobal->sho_mobile ?> &nbsp;<?php } ?>
		<?php if ($siteGlobal->shop_fax) { ?><i class="fa fa-fax fa-fw"></i> <?php echo $siteGlobal->shop_fax ?> &nbsp;<?php } ?>
		<?php if ($siteGlobal->sho_email) { ?><i class="fa fa-envelope-o fa-fw"></i> <?php echo $siteGlobal->sho_email ?> &nbsp;<?php } ?>
		<?php if ($siteGlobal->sho_website) { ?><i class="fa fa-globe fa-fw"></i> <?php echo $siteGlobal->sho_website ?> &nbsp;<?php } ?><br>
		<i class="fa fa-copyright fa-fw"></i> Bản quyền 2015 - <span class="text-uppercase"><?php echo $siteGlobal->sho_link ?></span>. Thiết kế và phát triển web bởi <span class="text-uppercase">Azibai.com</span>.
	    </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-left">
            <div style="padding: 20px 0 0">
		<p>Chúng tôi trên:</p>
		<p class="followus">		    
		    <a href="<?php echo $siteGlobal->sho_facebook ?>"><i class="fa fa-facebook-square fa-2x fa-fw"></i></a>&nbsp;
		    <a href="<?php echo $siteGlobal->sho_twitter ?>"><i class="fa fa-twitter-square fa-2x fa-fw"></i></a>&nbsp;
		    <a href="<?php echo $siteGlobal->sho_google_plus?>"><i class="fa fa-google-plus-square fa-2x fa-fw"></i></a>&nbsp;
		    <a href="<?php echo $siteGlobal->sho_youtube ?>"><i class="fa fa-youtube-square fa-2x fa-fw"></i></a>&nbsp;
		    <a href="<?php echo $siteGlobal->sho_vimeo ?>"><i class="fa fa-vimeo-square fa-2x fa-fw"></i></a>&nbsp;
		</p>
	    </div>
        </div>
    </div>
</div>
