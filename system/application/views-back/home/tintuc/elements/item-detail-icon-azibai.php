<?php
/*luc thi posi luc thi position bo chym*/
$position      = property_exists($icon, 'posi') && $icon->posi ? $icon->posi : null;
if(!$position){
    $position  = property_exists($icon, 'position') && $icon->position ? $icon->position : 'left';
}
?>
<div class="icon_featured  clearfix mb10 mb30" data-animation="" data-delay="500">
    <div class="wrap-caption-icon <?php echo 'f-'.$position ?>">
        <?php if((!$type || $type == ICON_TYPE_ICON ) && $icon->icon){ ?>
            <div class="icon border-black <?php echo 'f-'.$position ?>">
                <img src="<?php echo $this->config->item('icon_path') . $icon->icon; ?>" class="icon-inserted">
            </div>
        <?php } ?>
        <?php if($type == ICON_TYPE_ANIMATION && $icon->icon_url){ ?>
            <div class="icon border-black <?php echo 'f-'.$position ?>">
                <div class="image-json" id="json_image_<?=$index?>"></div>
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        bodymovin.loadAnimation({
                            container: document.getElementById('json_image_<?=$index?>'),
                            renderer: 'svg',
                            loop: true,
                            autoplay: true,
                            path: '<?php echo $this->config->item('icon_path') . $icon->icon; ?>'
                        });
                    });
                </script>
            </div>
        <?php } ?>
        <?php if($type == ICON_TYPE_AUDIO && $icon->audio_path){ ?>
            <div class="icon border-black <?php echo 'f-'.$position ?>">
                <img src="/templates/home/styles/images/default/music_pause.png"
                     class="icon-inserted music-play cursor-poin js_audio"
                     data-target-audio="<?php echo $taget_aidio = uniqid(); ?>">
                <audio class="hide_0 <?php echo $taget_aidio?> js_audio_icon">
                    <source src="<?php echo $this->config->item('audio_path'). $icon->audio_path; ?>">
                    Your browser does not support the audio tag.
                </audio>
            </div>
        <?php } ?>
    </div>
    <div class="infomation <?php echo 'text-'.$position ?>">
        <p class="title"><?php echo $icon->title ?></p>
        <p class="desc"><?php echo $icon->desc ?></p>
    </div>
</div>