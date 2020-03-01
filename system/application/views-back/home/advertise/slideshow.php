<?php $k=1; foreach($advertise as $advertiseArray){ ?>
<?php if((int)$advertiseArray->adv_position == 9 ){ ?>	    
	        <?php if(strtolower(substr($advertiseArray->adv_banner, -4)) == '.swf'){ ?>
	        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" class="advertise_top_flash" id="FlashID_<?php echo $advertiseArray->adv_id; ?>" title="<?php echo $advertiseArray->adv_title; ?>">
			  <param name="movie" value="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" />
			  <param name="quality" value="high" />
			  <param name="wmode" value="opaque" />
			  <param name="swfversion" value="6.0.65.0" />
			  <param name="expressinstall" value="<?php echo base_url(); ?>templates/home/images/expressInstall.swf" />
			  <!--[if !IE]>-->
			  <object type="application/x-shockwave-flash" data="<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>" class="advertise_top_flash">
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
                        
			
			<?php } ?>
		

<?php $k++;  } ?>
<?php }

//echo  $k; 
?>
 <div id="simplegallery2" >
 </div>
 
 
 <script type="text/javascript" language="javascript">
//<![CDATA[
	var widthScreen=jQuery(window).width();
	if(widthScreen<=1024){
		var width1024=454;
		
	}
	else
	{
		var width1024=560;
	}
		
	var mygallery2=new simpleGallery({	
	wrapperid: "simplegallery2", //ID of main gallery container,	
	dimensions: [width1024, 230], //width/height of gallery in pixels. Should reflect dimensions of the images exactly	
	imagearray: [
	<?php $imageArray=array();$j=0; foreach($advertise as $advertiseArray){ ?>
	<?php if(((int)$advertiseArray->adv_position == 9 )&&(strtolower(substr($advertiseArray->adv_banner, -4)) != '.swf')){ ?>
	<?php $imageArray[$j]=$advertiseArray;?>
	<?php $j++;?>
	<?php }}?>
<?php foreach($imageArray as $advertiseArray){ ?>
<?php if($advertiseArray==end($imageArray)){ ?> ["<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>", "<?php echo prep_url($advertiseArray->adv_link); ?>", "_new", ""] <?php }else{ ?>
["<?php echo base_url(); ?>media/banners/<?php echo $advertiseArray->adv_dir; ?>/<?php echo $advertiseArray->adv_banner; ?>", "<?php echo prep_url($advertiseArray->adv_link); ?>", "_new", ""] ,
<?php } ?>
<?php } ?>

		
	],
	autoplay: [true, 1, 1000], //[auto_play_boolean, delay_btw_slide_millisec, cycles_before_stopping_int]
	persist: true,
	fadeduration: 3000, //transition duration (milliseconds)
	oninit:function(){ //event that fires when gallery has initialized/ ready to run
	},
	onslide:function(curslide, i){ //event that fires after each slide is shown
		//curslide: returns DOM reference to current slide's DIV (ie: try alert(curslide.innerHTML)
		//i: integer reflecting current image within collection being shown (0=1st image, 1=2nd etc)
	}
});
//]]
</script>


<?php /*?> <script type="text/javascript">
    if(!window.slider) var slider={};slider.data=[<?php $j=1; foreach($advertise as $advertiseArray){ ?>
<?php if((int)$advertiseArray->adv_position == 9 && trim($advertiseArray->adv_page) != '' && stristr($advertiseArray->adv_page, $advertisePage)){ ?>

<?php if($j==$k-1){ ?> {"id":"slide-img-<?php echo $j; ?>","client":"","desc":""} <?php }else{ ?>
{"id":"slide-img-<?php echo $j; ?>","client":"","desc":""},
<?php } ?>

<?php $j++; } ?>
<?php } ?>];
   </script><?php */?>
