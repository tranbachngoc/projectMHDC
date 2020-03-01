<?php 
	$iCountText = count( (array) $aListText);
  $rand = rand();
?>
<?php if(!empty($aListText)) { ?>
    <div class="<?=$rand?> effect12">
      <?php foreach ($aListText as $TextKey => $sText) { ?>
        <div class="type-js <?=$TextKey?>">
          <span class="text-js"><?=$sText?></span>
        </div>
      <?php } ?>
    </div>
    <script type="text/javascript">

      function autoType(elementClass, typingSpeed){
        var thhis = $(elementClass);
        thhis.css({
          "display": "inline-block"
        });
        // if(thhis.find('.cursor').length > 0) {
        //   thhis.find('.cursor').remove();
        // }
        // thhis.prepend('<div class="cursor" style="right: initial; left:0;"></div>');
        thhis = thhis.find(".text-js");
        var text = thhis.text().trim().split('');
        var amntOfChars = text.length;
        var newString = "";
        // thhis.text("|");
        setTimeout(function(){
          thhis.css("opacity",1);
          thhis.prev().removeAttr("style");
          thhis.text("");
          for(var i = 0; i < amntOfChars; i++){
            (function(i,char){
              setTimeout(function() {       
                newString += char;
                thhis.text(newString);
                if(i == amntOfChars) {
                  setTimeout(function() {    
                    $(elementClass).css('display','none');
                  },180);
                }
              },i*typingSpeed);
            })(i+1,text[i]);
          }
        },1000);
      }

      $(document).ready(function(){
        var loop = 0;
        effect12();
        function effect12() {
          var delay = 0;
          $('.<?=$rand?>.effect12 .type-js').each(function(index, item){
            thhis = $(this).find(".text-js");
            var text = thhis.text().trim().split('');
            var amntOfChars = text.length;
            if(index == 0) {
              autoType(".<?=$rand?>.effect12 .type-js."+index,200);
            }else {
              setTimeout(function() {        
                autoType(".<?=$rand?>.effect12 .type-js."+index,200);
              },delay);
            }
            var count = (amntOfChars*200)+1000;
            delay = count + delay;
            loop = loop + count;
          });
        }
        
        if(loop) {
          setInterval(function(){ 
            effect12();
          }, loop);
        }
      });
                                
    </script>
<?php } ?>