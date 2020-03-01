<?php
$video_title = $video_title_xss = ($video->title ? $video->title : $video->not_title);
$video_caption_xss = strip_tags($video->description ? $video->description : $video->not_detail);
$video_url         = DOMAIN_CLOUDSERVER . 'video/' . $video->name;
$image_url         = trim($video->thumbnail) ? (DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $video->thumbnail) : DEFAULT_IMAGE_ERROR_PATH;
$btn_play_video     = 'btn_play_video_'.$video->id;
$btn_volume_video   = 'js_hrz-btn-volume-'.$video->id;
$video_target       = 'content_hrz_video_'.$video->id;
$start              = !isset($start) ? 0 : $start;
$element_index      =  $k + $start;

$video_des = '';
$check_profile = explode('/', $url_news);
if($check_profile[3] == 'profile'){
    $video_des = $info_public['use_fullname'].' - '.cut_string_unicodeutf8(strip_tags(html_entity_decode($video->not_detail)), 150);
    $url_news = base_url() . 'profile/' . $check_profile[4] . '/news/detail/' . $video->not_id;
}
?>
<li class="item_video item_video_<?php echo $video->id ?> detail js_item-detect-video-action"
    data-id="<?php echo $video->id ?>"
    data-type="video"
    data-title="<?php echo str_replace('"', '&quot;', $video_title_xss) ?>"
    data-video="<?php echo $video->name ?>"
    data-tags='<?php echo json_encode([]) ?>'
    data-not_begindate='<?php echo date('d/m/Y', $video->not_begindate) ?>'
    data-video_url="<?php echo $video_url ?>"
    data-image_url="<?php echo $image_url ?>"
    data-content_url="<?php echo $url_news ?>"
    data-index="<?php echo $element_index ?>"
    data-image_size='<?php echo json_encode(['width' => $video->width, 'height' => $video->height]) ?>'
    data-news_id="<?php echo $video->not_id ?>"
    data-caption="<?php echo str_replace('"', '&quot;', $video_caption_xss) ?>"
    data-key="<?php echo $video->id  ?>"
    data-des="<?php echo htmlspecialchars($video_des) ?>"
    data-type_shrvideo="<?php echo TYPESHARE_DETAIL_SHOPVIDEO ?>">
    <div class="box-video js_news-video-content video">
        <video data-id="<?php echo $video->id ?>"
               data-video-id="<?php echo $video->id ?>"
               data-news_id="<?php echo $video->not_id ?>"
               id="<?php echo $video_target ?>"
               class="no-autoplay videoautoplay"
               data-index="<?php echo $element_index ?>"
               onplay="video_handle_event_play(event)"
               onpause="video_handle_event_pause(event)"
               onvolumechange="video_handle_event_volume(event)"
               data-target_btn_volume=".<?php echo $btn_volume_video ?>"
               data-target_btn_play=".<?php echo $btn_play_video ?>"
               playsinline muted <?php echo $k == 0 ? 'autoplay' : '' ?>
               poster="<?php echo $image_url  ?>">
            <source src="<?php echo DOMAIN_CLOUDSERVER . 'video/' . $video->name ?>" type="video/mp4">
        </video>
    </div>
    <div class="list-video-text js_news-video-content" data-index="<?php echo $element_index ?>" data-id="<?php echo $video->id ?>">
        <h3><?php echo $video_title ?></h3>
        <p class="hidden">I love you babyI love you baby</p>
    </div>
    <img data-video-id="<?php echo $video_target ?>"
         data-id="<?php echo $video->id ?>"
         data-target_video="#<?php echo $video_target ?>"
         class="btn-volume js_az-volume <?php echo $btn_volume_video ?>"
         src="/templates/home/styles/images/svg/icon-volume-off.svg" width="32">
    <div data-video-id="<?php echo $video_target ?>"
         data-target_video="#<?php echo $video_target ?>"
         data-id="<?php echo $video->id ?>"
         data-news_id="<?php echo $video->not_id ?>"
         data-index="<?php echo $element_index ?>"
         class="pause js_btn-pause <?php echo $btn_play_video ?> <?php echo $k == 0 ? 'hidden' : '' ?>">
        <img src="/templates/home/styles/images/svg/play_video.svg" alt="pause">
    </div>
</li>