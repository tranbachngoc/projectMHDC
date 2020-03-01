<?php 
	$iCountText = count( (array) $aListText);
?>
<?php if(!empty($aListText)) { ?>
    <div class="effect11 text_<?=$TextKey?>">
        <?php foreach ($aListText as $TextKey => $sText) { ?>
            <span class="frame"><?=$sText?></span>
        <?php } ?>
    </div>
    <script type="text/javascript">

        var count_animation = $('.effect11 .frame').length;
        var loop_animation = 0;
        var loop = 1;
        var delay = 5;
        function effect11 () {
          $('.effect11 .frame').each(function(index, item){
            var count = loop_animation + index*delay;
            var animation = {
              '-webkit-animation-delay' : count +'s',
              '-moz-animation-delay' : count +'s',
              '-ms-animation-delay' : count +'s',
              'animation-delay' : count +'s',
            }
            $(this).css(animation);
          });
          loop_animation = count_animation*loop*delay;
          setTimeout(function(){
            loop++;
            effect11();
          },(count_animation*delay)*1000);
          
        }

    	$(document).ready(function(){
    		effect11();
    	});
                                
    </script>
<?php } ?>