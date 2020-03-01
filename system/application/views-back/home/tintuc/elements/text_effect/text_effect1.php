<?php 
    $iCountText = count( (array) $aListText);
    $rand = 'text_class_'.rand();
?>
<?php if(!empty($aListText)) { ?>
    <?php foreach ($aListText as $iKTextKey => $sText) { ?>
            <div class="effect1 text_<?=$iKTextKey?> <?=$rand?>" style="opacity: 0">
                <?php 
                    if(isset($isMobile) && $isMobile == 1) {
                        if($sText != '') {
                            foreach (cut_string($sText,4) as $k => $val) {
                                echo '<span class="text-wrapper">';
                                    echo '<span class="lines line1"></span>';
                                    echo '<span class="letters">'.$val.'</span>';
                                    echo '<span class="lines line2"></span>';
                                echo '</span>';
                            }
                        }
                    }else {
                        if($sText != '') {
                            foreach (cut_string($sText,5) as $k => $val) {
                                echo '<span class="text-wrapper">';
                                    echo '<span class="lines line1"></span>';
                                    echo '<span class="letters">'.$val.'</span>';
                                    echo '<span class="lines line2"></span>';
                                echo '</span>';
                            }
                        }
                    }
                ?>
                
            </div>
    <?php } ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.effect1 .letters').each(function(){
                $(this).html($(this).text().replace(/([^\x00-\x80]|\w|\,|\.|\%|\!|\:|\/)/g, "<span class='letter'>$&</span>"));
            });
            var effect = anime.timeline({loop:true});
            for (var i = 0; i < <?=$iCountText?>; i++) {
                effect.add({
                    targets: '.effect1.text_'+i+'.<?=$rand?>',
                    opacity: 1,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 0
                }).add({
                    targets: '.effect1.text_'+i+'.<?=$rand?> .letter',
                    scale: [0.3,1],
                    opacity: [0,1],
                    translateZ: 0,
                    easing: "easeOutExpo",
                    duration: 600,
                    delay: function(el, i) {
                      return 70 * (i+1)
                    }
                }).add({
                    targets: '.effect1.text_'+i+'.<?=$rand?> .lines',
                    scaleX: [0,1],
                    opacity: [0.5,1],
                    easing: "easeOutExpo",
                    duration: 700,
                    offset: '-=875',
                    delay: function(el, i, l) {
                      return 80 * (l - i);
                    }
                }).add({
                    targets: '.effect1.text_'+i+'.<?=$rand?>',
                    opacity: 0,
                    duration: 1000,
                    easing: "easeOutExpo",
                    delay: 1000
                });
            }
        });
                                
    </script>
<?php } ?>