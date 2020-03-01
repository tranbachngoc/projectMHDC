<?php
$image = $item['image'] ? ($server_media. $item['image']) : $item['link_image'];
$link     = '';
$type_tbl = '';

if($item['type_tbl'] == LINK_TABLE_LIBRARY){
    $type_tbl   = 'library-link';
}
if($item['type_tbl'] == LINK_TABLE_CONTENT){
    $type_tbl   = 'content-link';
}
if($item['type_tbl'] == LINK_TABLE_IMAGE){
    $type_tbl   = 'image-link';
}
$selector_category_item = 'js_library-category-item-'. $item['id'];
?>
<div class="list-link-content <?php echo @$category['class_bg_color'] ?>">
    <div class="wrap-newest-post <?php echo $selector_category_item ?>">
        <div class="newest-post">
            <a title="<?php echo htmlspecialchars($item['link_title']); ?>" target="_blank" href="<?php echo $url_item . '/links/'. $type_tbl .'/'. $item['id'] ?>">
                <?php
                if($item['video']) {
                    $btn_play_video  = 'btn_play_link_' . $item['id'];
                    $video_target     = 'content_link_' . $item['id'];
                    ?>
                    <div class="wrap-video-item-single block_video">
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
                    <div class="img">
                        <img src="<?php echo $image ?>"
                             onerror="image_error(this, '.<?php echo $selector_category_item ?>')"
                             alt="<?php echo htmlspecialchars($item['link_title']); ?>">
                    </div>
                <?php } ?>
            </a>
            <div class="head">
                <p class="tit"><?php echo ucfirst($category['name']) ?></p>
                <a href="<?php echo ($link_view_all = $domain_url .'/links/'. $category['slug']) ?>">Xem tất cả</a>
            </div>
            <div class="text">
                <a target="_blank" ref="nofollow" href="<?php echo $item['link']?>">
                    <p class="text-bold">Nguồn: <?php echo $item['host'] ?></p>
                </a>
                <a target="_blank" ref="nofollow" href="<?php echo $item['link']?>">
                    <h3 class="one-line"><?php echo $item['link_title'] ?></h3>
                </a>
            </div>
            <div class="newest-post-edit">
                <div class="main">
                    <div class="p-2 cursor-pointer icon js_library-link-show-more"
                          data-id="<?php echo $item['id'] ?>"
                          data-link="<?php echo $item['link'] ?>"
                          data-type="<?php echo $type_tbl ?>"
                          data-link_id="<?php echo $item['link_id'] ?>"
                          data-value="<?php echo $url_item . '/links/'. $type_tbl .'/'. $item['id'] ?>"
                          data-name="<?php echo $item['link_title'] ?>">
                        <img src="/templates/home/styles/images/svg/3dot_doc.svg">
                    </div>
                </div>
            </div>
        </div>
        <div class="socials-logos js-scroll-x mb-3">
            <div class="tag-column-parent">
                <?php echo $html_submenu; ?>
            </div>
        </div>
    </div>
    <?php
        $view_type_class = '';
        if($view_type == 'line'){
            $view_type_class = 'haftwidth youtubelayer';
        }else if ($view_type == 'grid'){
            $view_type_class = 'haftwidth';
        }else if ($view_type == 'list'){
            $view_type_class = 'haftwidth fullwidth';
        }
    ?>
    <div class="grid haftwidth <?php echo $view_type_class ?>">
        <div class="js-youtubelayer-slider">
            <?php echo $html_item; ?>
        </div>
        <?php if($html_item){ ?>
            <a class="link-see-more" href="<?php echo $link_view_all ?>">Xem tất cả</a>
        <?php } ?>
    </div>
</div>