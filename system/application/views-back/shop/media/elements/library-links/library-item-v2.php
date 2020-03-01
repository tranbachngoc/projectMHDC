<?php
$link     = '';
$type_tbl = '';

if($item['type_tbl'] == LINK_TABLE_LIBRARY){
    $link       = 'library-link/';
    $type_tbl   = 'library-link';
    $type_share = ($item['sho_id'] > 0) ? TYPESHARE_DETAIL_SHOPLIBLINK : TYPESHARE_DETAIL_PRFLIBLINK;
}
if($item['type_tbl'] == LINK_TABLE_CONTENT){
    $link       = 'content-link/';
    $type_tbl   = 'content-link';
    $type_share = ($item['sho_id'] > 0) ? TYPESHARE_DETAIL_SHOPLINK_CONTENT : TYPESHARE_DETAIL_PRFLINK_CONTENT;
}
if($item['type_tbl'] == LINK_TABLE_IMAGE){
    $link       = 'image-link/';
    $type_tbl   = 'image-link';
    $type_share = ($item['sho_id'] > 0) ? TYPESHARE_DETAIL_SHOPLINK_IMG : TYPESHARE_DETAIL_PRFLINK_IMG;
}
?>
<div class="item js_library-link-item js_library-link-item-<?php echo $item['id'] ?>">
    <div class="detail">
        <div class="img-link">
            <?php
            if($item['image']) {
                $image = $server_media . $item['image'];
            }else{
                $image = $item['link_image'];
            }
            ?>
            <a target="_blank" href="<?php echo $url_item . $link . $item['id'] ?>">
                <?php
                if($item['video']) {
                    $btn_play_video  = 'btn_play_link_' . $item['id'];
                    $video_target    = 'content_link_' . $item['id'];
                    ?>
                    <div class="wrap-video-item-single">
                        <video class="detail-video"
                               preload="none"
                               id="<?php echo $video_target ?>"
                               playsinline
                               data-target_video="#<?php echo $video_target ?>"
                               data-target_btn_volume=".js_btn-volume-<?php echo $item['id']?>"
                               data-target_btn_play=".<?php echo $btn_play_video ?>"
                               muted
                               poster="<?php echo $image;?>">
                            <source src="<?=  $server_media . $item['video'] ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div data-video-id="<?php echo $video_target ?>"
                             data-target_video="#<?php echo $video_target ?>"
                             data-target_btn_play=".<?php echo $btn_play_video ?>"
                             class="btn-pause js_btn-pause <?php echo $btn_play_video ?>">
                            <img class="js_img-play" src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
                        </div>
                    </div>
                <?php } else { ?>
                    <img onerror="image_error(this)"
                         src="<?php echo $image; ?>"
                         alt="<?php echo htmlspecialchars($item['link_title']) ?>">
                <?php } ?>
            </a>
            <?php if(!$item['is_public']) { ?>
                <img src="/templates/home/styles/images/svg/key.svg" class="icon-key">
            <?php } ?>
        </div>
        <div class="text" data-test="<?php echo $image; ?>">
            <a ref="nofollow" target="_blank" href="<?php echo $item['link']?>">
                <h3 class="link one-line">Nguồn: <?php echo $item['host']?></h3>
                <h3 class="one-line"><?php echo $item['link_title']?></h3>
                <p class="link"><?php echo $item['host']?></p>
            </a>
            <div class="thaotac">
                <span class="xemthem js_library-link-show-more"
                      data-id="<?php echo $item['id'] ?>"
                      data-link="<?php echo $item['link'] ?>"
                      data-type="<?php echo $type_tbl ?>"
                      data-value="<?php echo $url_item . $link . $item['id'] ?>"
                      data-name="<?php echo $item['link_title'] ?>"
                      data-type_share="<?php echo $type_share ?>">
                    <img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more">
                </span>
            </div>
        </div>
    </div>
</div>