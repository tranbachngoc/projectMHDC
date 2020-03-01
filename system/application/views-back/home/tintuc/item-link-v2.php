<?php
$url_server_media_link = $this->config->item('library_link_config')['cloud_server_show_path'];
$link     = '';
$type_tbl = '';
if(empty($link_v2['use_id'])){
    $link_v2['use_id'] = $link_v2['user_id'];
}
if($link_v2['type_tbl'] == LINK_TABLE_LIBRARY){
    $link       = 'library-link/';
    $type_tbl   = 'library-link';
}
if($link_v2['type_tbl'] == LINK_TABLE_CONTENT){
    $link       = 'content-link/';
    $type_tbl   = 'content-link';
}
if($link_v2['type_tbl'] == LINK_TABLE_IMAGE){
    $link       = 'image-link/';
    $type_tbl   = 'image-link';
}
?>
<li class="wrap-item-content-link js_action-tools js_wrap-content-link-<?php echo $link_v2['id'] ?> js-play-video"
    data-domain-use="<?php echo $domain_use ?>"
    data-type="<?php echo $type_tbl ?>"
    data-id="<?php echo $link_v2['id'] ?>">
    <?php
    /*get mode image link*/
    if($link_v2['image']){
        $link_image = $url_server_media_link . '/' . $link_v2['image'];
    }else{
        if(!empty($link_v2['link_img_ext'])){
            $prefix_image = get_mode_image($link_v2['link_img_ext'], (!isset($mode) ? 'pc' : $mode));
            $link_image   = $url_server_media_link .'/'. $link_v2['link_img_path'] .'/'. ($prefix_image ? $prefix_image .'/' : '') . $link_v2['link_img_name'];
        }else{
            $link_image = $link_v2['link_image'];
        }
    }

    if (($is_owner = !empty($user_login) && check_owner($user_login['use_id'], $user_login['my_shop']['sho_id'], $link_v2['use_id'], $link_v2['sho_id']))){ ?>
        <div class="edit_customlink js_action-link-edit">
            <img class="icon-img" src="/templates/home/styles/images/svg/pen_black.svg" alt="Chỉnh sửa link">
        </div>

        <em class="edit_customlink right js_action-link-remove" data-num="<?php echo $kLink ?>">
            <img class="icon-img" src="<?php echo base_url() . 'templates/home/styles/images/svg/x.svg' ?>">
        </em>
    <?php } ?>

    <a href="<?= $domain_use .'/'. $type_tbl .'/'. $link_v2['id'] ?>" target="_blank" id="custom_link_inner_<?= $link_v2['id'] ?>">
        <?php
        if($link_v2['video']) {?>
            <?php
            $video_attr_id    = 'link_video_' . $link_v2['id'];
            $btn_play_video   = 'link_btn_play_' . $link_v2['id'];
            $btn_volume_video = 'link_btn-volume-' . $link_v2['id'];

            $attr_video  = ' data-target_btn_volume=".' . $btn_volume_video . '" ';
            $attr_video .= ' data-target_btn_play=".' . $btn_play_video . '" ';
            $attr_video .= ' onplay="video_handle_event_play(event)" 
                             onpause="video_handle_event_pause(event)" 
                             onvolumechange="video_handle_event_volume(event)" ';
            ?>
            <p class="video img">
                <video muted
                       data-position="<?= isset($kLink) && $kLink == 0 ? '1' : '0' ?>"
                       data-video-type="link"
                       id="<?php echo $video_attr_id ?>"
                       playsinline
                       preload="none"
                       <?php echo $attr_video; ?>
                       <?php echo 'poster="'. $link_image .'"' ?>>
                    <source src="<?= $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link_v2['video']?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <?php if($link_v2['video']) { ?>
                    <img class="play_video_customlink play_video_customlink_bigger js_btn-pause <?= isset($kLink) && $kLink == 0 ? 'active' : '' ?> <?php echo $btn_play_video ?>"
                         data-target_video="#<?php echo $video_attr_id ?>"
                         src="/templates/home/styles/images/svg/play_video.svg"
                         alt="pause" data-id="video_customlink_<?=$link_v2['id']?>">
                    <?php if(!$is_owner){ ?>
                        <img class="custom-link-volume custom-link-volume-bigger js_az-volume <?php echo $btn_volume_video ?>"
                             data-id="video_customlink_<?=$link_v2['id']?>"
                             data-target_video="#<?php echo $video_attr_id ?>"
                             src="/templates/home/styles/images/svg/icon-volume-off.svg">
                    <?php } ?>
                <?php } ?>
            </p>
        <?php } else { ?>
            <p class="img">
                <img id="image_link_<?= $link_v2['id'] ?>"
                     onerror="error_image(this)"
                     data-lazy="<?= $link_image ?>"
                     src="<?= $link_image ?>">
            </p>
        <?php } ?>
        <div class="text">
            <div class="bg-text-blur" style="background: url('<?php echo $link_image ?>')"></div>
            <a href="<?= $link_v2['link'] ?>" ref="nofollow" target="_blank">
                <h3 class="one-line"><?= $link_v2['title'] ? $link_v2['title'] : $link_v2['link_title'] ?></h3>
                <p><?= $link_v2['host'] ?></p>
            </a>
        </div>
    </a>
</li>