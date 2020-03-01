<div class="item js_library-link-item js_library-link-item-<?php echo $item['id'] ?>">
    <div class="detail">
        <div class="img-link">
            <a target="_blank" href="<?php echo $url_item . 'custom-links/' . $item['id'] ?>">
                <?php if($item['image_path']) {
                    $image = DOMAIN_CLOUDSERVER . 'media/custom_link/' .  $item['image_path'];
                }else{
                    $image = $item['image'];
                }
                if($item['media_type'] ==  'video' && $item['video_path'] != '') { ?>
                    <div class="wrap-video-item-single">
                        <video poster="<?php echo $image ?>" playsinline preload="none">
                            <source src="<?=  DOMAIN_CLOUDSERVER . 'media/custom_link/' .  $item['video_path'] ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="btn-pause">
                            <img src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
                        </div>
                    </div>
                <?php } else { ?>
                    <img onerror="image_error(this)" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($item['title']) ?>">
                <?php } ?>
            </a>
        </div>
        <div class="text">
            <a ref="nofollow" target="_blank" href="<?php echo $item['save_link']?>">
                <h3 class="link one-line">Nguồn: <?php echo $item['host']?></h3>
                <h3 class="one-line"><?php echo $item['title']?></h3>
                <p class="link"><?php echo $item['host']?></p>
            </a>
            <div class="thaotac">
                <span class="xemthem js_library-link-show-more" data-id="<?php echo $item['id'] ?>" data-save_link="<?php echo $item['save_link'] ?>" data-value="<?php echo $url_item . 'custom-links/' . $item['id'] ?>" data-name="<?php echo $item['title'] ?>">
                    <img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more">
                </span>
            </div>
        </div>
    </div>
</div>