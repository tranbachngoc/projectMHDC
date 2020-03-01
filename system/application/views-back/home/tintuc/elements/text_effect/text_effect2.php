<?php 
	$iCountText        = count( (array) $aListText);
    $iCountTextChild   = 0;
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
       <div class="effect2 text_<?=$TextKey?>"><?=trim($sText)?></div>
    <?php } ?>
    <script type="text/javascript">
    	$(document).ready(function(){
            var iCountText = 0;
            $('.effect2').each(function(){
                iCountText  = parseInt(iCountText+$(this).text().split(" ").length);
                var num  = countText($(this).text(),<?=$num?>);
                var aList   = $(this).text().split(" ");
                var limit   = parseInt(num - 1) ;
                var html    = '';
                for (var i = 0; i < 2; i++) {
                    var start = parseInt(num*i);
                    var text = '';
                    for (j=start; j <= limit + start; j++) {
                        if(aList[j] != undefined) {
                            text += " "+aList[j];
                        }
                    }
                    html += '<div>'+text.replace(/([^\x00-\x80]|\w|\,|\.|\%|\!|\:)/g, "<span class='letter'>$&</span>")+'</div>';
                }

                $(this).html(html);
            });
    
            var effect = anime.timeline({loop: true});

            for (var i = 0; i < iCountText; i++) {
                effect.add({
                    targets: '.effect2.text_'+i+' .letter',
                    scale: [4,1],
                    opacity: [0,1],
                    translateZ: 0,
                    easing: "easeOutExpo",
                    duration: 950,
                    delay: function(el, i) {
                      return 70*i;
                    }
                }).add({
                    targets: '.effect2.text_'+i,
                    opacity: 0,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000
                });
            }
            
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