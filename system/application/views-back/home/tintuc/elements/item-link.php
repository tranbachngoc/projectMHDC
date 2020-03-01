<?php
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
<div class="item-link-custom js_action-tools js_wrap-content-link-<?php echo $link_v2['id'] ?>"
    data-domain-use="<?php echo $domain_use ?>"
    data-type="<?php echo $type_tbl ?>"
    data-id="<?php echo $link_v2['id'] ?>">
    <?php
    $link_image = $link_v2['link_image'];
    if($link_v2['image']){
        $link_image = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' . $link_v2['image'];
    }

    if (
        !empty($user_login)
        && check_owner($user_login['use_id'], $user_login['my_shop']['sho_id'], $link_v2['use_id'], $link_v2['sho_id'])
    ){ ?>
        <div class="edit_customlink js_action-link-edit">
            <img class="icon-img" src="/templates/home/styles/images/svg/pen_black.svg" alt="Chỉnh sửa link">
        </div>
    <?php } ?>

    <a href="<?= $domain_use .'/'. $type_tbl .'/'. $link_v2['id'] ?>" target="_blank" id="custom_link_inner_<?= $link_v2['id'] ?>">
        <?php
        if($link_v2['video']) {?>
            <p class="video img">
                <video id="video_customlink_<?=$link_v2['id']?>"
                    <?= 'poster="'. $link_image .'"' ?>
                    <?= isset($kLink) && $kLink == 0 ? 'autoplay="true"' : '' ?>
                       playsinline muted preload="none">
                    <source src="<?= $this->config->item('library_link_config')['cloud_server_show_path'] .'/'. $link_v2['video']?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </p>
        <?php } else { ?>
            <p class="img">
                <img id="image_link_<?= $link_v2['id'] ?>"
                     data-lazy="<?= $link_image ?>"
                     src="<?= $link_image ?>">
            </p>
        <?php } ?>
        <div class="text">
            <a href="<?= $link_v2['link'] ?>" ref="nofollow" target="_blank">
                <h3 class="two-lines"><?= $link_v2['title'] ? $link_v2['title'] : $link_v2['link_title'] ?></h3>
                <p><?= $link_v2['host'] ?></p>
            </a>
        </div>
    </a>
    <?php if($link_v2['video']) { ?>
        <img class="play_video_customlink <?= isset($kLink) && $kLink == 0 ? 'active' : '' ?>"
             src="/templates/home/styles/images/svg/play_video.svg"
             alt="pause" data-id="video_customlink_<?=$link_v2['id']?>">
        <img class="custom-link-volume volume_off"
             data-id="video_customlink_<?=$link_v2['id']?>"
             src="/templates/home/styles/images/svg/icon-volume-off.svg">
    <?php } ?>
</div>