<?php 
	$iCountText = count( (array) $aListText);
  $rand = rand();
?>
<?php if(!empty($aListText)) { ?>
    <div class="<?=$rand?> effect13">
      <marquee id="effect13_scroll" behavior="scroll" scrolldelay="300" direction="up">
        <?php foreach ($aListText as $TextKey => $sText) { ?>
            <p><?=$sText?></p>
        <?php } ?>
      </marquee>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        var height = $('#image_<?=$iImageId;?>').height();
        $('#slider_text_'+<?=$iImageId;?>+' .textonimg').css('height',height);
        $('#effect13_scroll').css('height',height);
      });
    </script>
<?php } ?>