<?php 
	$iCountText = count( (array) $aListText);
    if(!isset($num)) {
        $detect = new Mobile_Detect();  
        $num = 5; 
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
            $num = 4;
        }
    }
?>
<?php if(!empty($aListText)) { ?>
    <?php foreach ($aListText as $TextKey => $sText) { ?>
        <div class="effect4 text_<?=$TextKey?>">
            <span class="letters letters-<?=$TextKey?>"><?=$sText?></span>
        </div>
    <?php } ?>
    <script type="text/javascript">
    	$(document).ready(function(){
    		var effect4 = {};
            effect4.opacityIn = [0,1];
            effect4.scaleIn = [0.2, 1];
            effect4.scaleOut = 3;
            effect4.durationIn = 800;
            effect4.durationOut = 600;
            effect4.delay = 500;

            var effect = anime.timeline({loop: true});
    		for (var i = 0; i < <?=$iCountText?>; i++) {
    			effect.add({
                    targets: '.effect4 .letters-'+i,
                    opacity: effect4.opacityIn,
                    scale: effect4.scaleIn,
                    duration: effect4.durationIn
                }).add({
                    targets: '.effect4 .letters-'+i,
                    opacity: 0,
                    scale: effect4.scaleOut,
                    duration: effect4.durationOut,
                    easing: "easeInExpo",
                    delay: effect4.delay
                });
    		}
            effect.add({
                targets: '.effect4',
                opacity: 0,
                duration: 500,
                delay: 500
            });               
    	});
        function countText(string, num) {
            if(string.split(" ").length > num) {
                var iCount = Math.ceil(string.split(" ").length / num);
                if(iCount == 2) {
                  return num;
                }
                return countText(string,parseInt(num+1));
            }else {
                return num;
            } 
        }
    </script>
<?php } ?>