<?php
	$oText = $text_images;
	$iCountText = count( (array) $oText['list_text_content']);

	$sStyle = '';
	$sClass = '';
	if($oText['text_color'] != '') {
		$sStyle .= 'color:'.$oText['text_color'].';';
	}
	if(!empty($oText['text_bg'])) {
		if(strlen($oText['text_bg']) > 7) {
            $oText['text_bg'] = '#'.substr($oText['text_bg'],3,9);
        }
		$sStyle .= 'background-color:'.$oText['text_bg'].';';
		if(isset($oText['overlay_bg']) && $oText['overlay_bg'] != '') {
			$sStyle .= 'opacity:'.$oText['overlay_bg'].';';
		}
	}

	if($oText['text_font'] != '') {
		$sStyle .= 'font-family:'.$oText['text_font'].';';
	}

	if($oText['align_vertical'] != '') {
		$sClass .= $oText['align_vertical'];
	}

	$aListEffect = array(
		'effect1',
		'effect2',
		'effect3',
		'effect4',
		'effect5',
		'effect6',
		'effect7',
		'effect8',
		'effect9',
		'effect10',
		'effect11',
		'effect12',
		'effect13',
	);

	if($oText['effect'] == '' || !in_array($oText['effect'], $aListEffect)) {
		$oText['effect'] = 'effect1';
	}
?>
<div style="vertical-align: middle">
    <div id="slider_text_<?=$iImageId;?>" class="slider-text-item <?=$sClass?>" style="<?=$sStyle?>">
        <div class="textonimg">
            <?php
            	if(!empty($oText['list_text_content'])) {
            		if(isset($oText['effect']) && $oText['effect'] != '') {
                        $sTextView = 'home/tintuc/elements/text_effect/text_'.$oText['effect'];
            		    if(file_exists(APPPATH.'views/'. $sTextView .'.php')){
                           echo $this->load->view(
                               $sTextView,
                               array(
                                   'aListText' 	=> $oText['list_text_content'],
                                   'iImageId' 	=> $iImageId
                               )
                           );
                        }
            		}
				}

			 ?>
        </div>                                  
    </div>                                                            
</div>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#slider_text_<?=$iImageId;?>').hasClass('middle')) {
	        var image_height    = $('img#image_<?=$iImageId;?>').height();
	        var element_height  = $('#slider_text_<?=$iImageId;?>').height();
	        var top = (image_height/2) - (element_height/2);
	        $('#slider_text_<?=$iImageId;?>').css('top',top);
	    }
	});
</script>