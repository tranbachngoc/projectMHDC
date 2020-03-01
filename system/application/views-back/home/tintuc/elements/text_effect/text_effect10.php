<?php 
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
        <div class="effect10 text_<?=$TextKey?>">
            <span class="text-wrapper">
                
                <span class="letters"><?=$sText?></span>
            </span>
        </div>
    <?php } ?>
    <script type="text/javascript">
    	$(document).ready(function(){
            var iCountText = 0;
            $('.effect10 .letters').each(function(){
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
    		for (var j = 0; j < iCountText; j++) {
    			effect.add({
                    targets: '.effect10.text_'+j+' .letter',
                    opacity: [0,1],
                    easing: "easeOutExpo",
                    duration: 1000,
                    offset: '-=775',
                    delay: function(el, i) {
                      return 100 * (i+1)
                    }
                }).add({
                    targets: '.effect10.text_'+j,
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