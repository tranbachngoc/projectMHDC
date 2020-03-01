<?php
$video_attr_id    = 'video_' . $item->not_id;
$btn_play_video   = 'tintuc_btn_play_video_' . $item->not_id;
$btn_volume_video = 'tintuc_btn-volume-' . $item->not_id;
$video_target     = 'tintuc_video_' . $item->not_id;

$attr_video  = ' controls="true" ';
$is_home = 0;
if(isset($home_page)){
    $is_home = 1;
}
$data_name = str_replace('"', 'quot;', $data_name);
$data_name = str_replace("'", '&apos;', $data_name);
$video_data = array(
    'attr_video'        => $attr_video,
    'video_attr_id'     => $video_attr_id,
    'poster'            => $item->poster,
    'is_home'           => $home_page,
    'video_target'      => $video_target,
    'data_id'           => $item->not_id,
    'data_cat'          => $item->not_pro_cat_id,
    'data_shop_name'    => $owner_name,
    'data_shop_date'    => date('d/m/Y', $item->not_begindate),
    'data_shop_link'    => $domain_use,
    'data_shop_avatar'  => $logo,
    'data_video_link'   => DOMAIN_CLOUDSERVER . 'video/' . $item->not_video_url1,
    'data_news_id'      => $item->not_id,
    'data_video_id'     => @$item->video_id,
    'data_name'         => $data_name,
    'data_value'        => $data_value,
    'data_typeshrvideo'        => TYPESHARE_DETAIL_SHOPVIDEO
);
?>
<div class="video"  data-video='<?=json_encode($video_data,  JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);?>' data-target_video="<?php echo $video_attr_id ?>">
    <?php //if ($show_vol == true) { ?>
    <?php //} ?>
    <div class="video-inner">
        <img class="poster-video" src="<?php echo $item->poster; ?>">
        <button class="vjs-big-play-button btn-add-video" type="button" title="Play Video" aria-disabled="false">
            <img class="height-unset" src="/templates/home/styles/plugins/videojs/images/play_video.svg">
        </button>
    </div>
</div>