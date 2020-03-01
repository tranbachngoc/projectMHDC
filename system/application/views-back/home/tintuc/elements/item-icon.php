<?php
$effectcontent = property_exists($icon, 'effect') ? $icon->effect : '';
$classIcon     = $effectcontent ? 'animated hiding' : '';
$type          = property_exists($icon, 'type') && $icon->type ? $icon->type : null;
$kicon         = property_exists($icon, 'key') && $icon->key ? $icon->key : null;
/*luc thi posi luc thi position bo chym*/
$position      = property_exists($icon, 'posi') && $icon->posi ? $icon->posi : null;
if(!$position){
    $position  = property_exists($icon, 'position') && $icon->position ? $icon->position : 'left';
}
$link_icon = '#';
if($kicon){
    $link_icon = $domain_use .'/news/'. $item->not_id .'/'. $kicon . (!empty($af_id) ? '?af_id=' . $af_id : '');
}

?>
<div class="additional-item<?= $effectcontent ? ' animated hiding' : '' ?><?php echo ' f-'.$position ?>"
    data-animation="<?=$effectcontent;?>" data-delay="500">
    <div class="icon">
        <?php if((!$type || $type == ICON_TYPE_ICON ) && $icon->icon){ ?>
            <img src="<?php echo $this->config->item('icon_path') . $icon->icon; ?>" class="icon-inserted" alt="icon highlight">
        <?php } ?>
        <?php if($type == ICON_TYPE_IMAGE && $icon->image_path){ ?>
            <a href="<?php echo $link_icon ?>">
                <img src="<?php echo $this->config->item('image_path_content') . $image_dir .DIRECTORY_SEPARATOR. $icon->image_path; ?>"
                     class="icon-inserted" alt="icon highlight">
            </a>
        <?php } ?>
        <?php if($type == ICON_TYPE_VIDEO && $icon->video_path){ ?>
            <?php $poster = $icon->video_thumb ? ($this->config->item('image_path_content') . $image_dir .DIRECTORY_SEPARATOR. $icon->video_thumb) : ''; ?>
            <a href="<?php echo $link_icon ?>">
                <img src="/templates/home/styles/images/svg/play_video.svg" class="icon-pause">
                <video class="icon-inserted" muted autoplay poster="<?php echo $poster ?>">
                    <source src="<?php echo $this->config->item('video_path') . $icon->video_path ?>" type="video/mp4">
                </video>
            </a>
        <?php } ?>
        <?php if($type == ICON_TYPE_AUDIO && $icon->audio_path){ ?>
            <div class="wrap-audio-icon">
                <img src="/templates/home/styles/images/default/music_pause.png"
                     class="icon-inserted music-play cursor-poin js_audio"
                     data-target-audio="<?php echo $taget_aidio = uniqid(); ?>">
                <audio class="hide_0 <?php echo $taget_aidio?> js_audio_icon">
                    <source src="<?php echo $this->config->item('audio_path'). $icon->audio_path; ?>">
                    Your browser does not support the audio tag.
                </audio>
            </div>
        <?php } ?>
        <?php if($type == ICON_TYPE_ANIMATION && $icon->icon_url){ ?>
            <div class="image-json" id="json_image_<?=$keyIcon?>"></div>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    bodymovin.loadAnimation({
                        container: document.getElementById('json_image_<?=$keyIcon?>'),
                        renderer: 'svg',
                        loop: true,
                        autoplay: true,
                        path: '<?php echo $this->config->item('icon_path') . $icon->icon; ?>'
                    });
                });
            </script>
        <?php } ?>
    </div>
    <div class="infomation <?php echo ' text-'.$position ?>">
        <div class="title"><?=$icon->title?></div>
        <div class="des"><?=$icon->desc?></div>
    </div>
</div>