<?php $haveAdvertise = false; ?>
<?php foreach($advertise as $advertiseArray){ ?>
<?php if((int)$advertiseArray->adv_position == 7){ ?>
<tr>
	<td align="center">
	    <a href="<?php echo prep_url($advertiseArray->adv_link); ?>" target="_blank">
	        <?php if(strtolower(substr($advertiseArray->adv_banner, -4)) == '.swf'){ ?>
	        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" class="advertise_bottom_flash" id="FlashID_<?php echo $advertiseArray->adv_id; ?>" title="<?php echo $advertiseArray->adv_title; ?>">
			  <param name="movie" value="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" />
			  <param name="quality" value="high" />
			  <param name="wmode" value="opaque" />
			  <param name="swfversion" value="6.0.65.0" />
			  <param name="expressinstall" value="<?php echo base_url(); ?>templates/home/images/expressInstall.swf" />
			  <!--[if !IE]>-->
			  <object type="application/x-shockwave-flash" data="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" class="advertise_bottom_flash">
			    <!--<![endif]-->
			    <param name="quality" value="high" />
			    <param name="wmode" value="opaque" />
			    <param name="swfversion" value="6.0.65.0" />
			    <param name="expressinstall" value="<?php echo base_url(); ?>templates/home/images/expressInstall.swf" />
			    <div>
			      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
			      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
			    </div>
			    <!--[if !IE]>-->
			  </object>
			  <!--<![endif]-->
			</object>
			<script type="text/javascript">
			<!--
			swfobject.registerObject("FlashID_<?php echo $advertiseArray->adv_id; ?>");
			//-->
			</script>
	        <?php }else{ ?>
			<img border="0" class="banner-advertisement" width="562" src="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" />
			<?php } ?>
		</a>
	</td>
</tr>
<?php $haveAdvertise = true; ?>
<?php } ?>
<?php } ?>
<?php if($haveAdvertise == false){ ?>
<tr>
	<td height="5"></td>
</tr>
<?php } ?>