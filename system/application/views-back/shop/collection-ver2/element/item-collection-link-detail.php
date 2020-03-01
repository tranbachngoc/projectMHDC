<?php
$type_tbl = $item['tbl'] == 'tbtt_lib_links' ? 'library-link' 
            : ($item['tbl'] == 'tbtt_content_links' ? 'content-link' 
            : ($item['tbl'] == 'tbtt_content_image_links' ? 'image-link' : '' ));
$__link = $shop_url . $type_tbl . '/' . $item['id'];
?>
<div class="item">
  <div class="detail">
    <?php if(!empty($item['video_path'])) { ?>
    <div class="img-link">
      <a href="<?php echo $shop_url . $type_tbl . '/' . $item['id'] ?>">
        <div class="wrap-video-item-single">
          <video poster="<?=$item['full_image_path']?>" onerror="error_video(this)" playsinline="" preload="none">
            <source src="<?=$item['full_video_path']?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <div class="btn-pause">
              <img src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
          </div>
        </div>
      </a>
      <!-- <img src="/templates/home/styles/images/svg/key.svg" class="icon-key" alt=""> -->
    </div>
    <?php } else { ?>
    <div class="img-link">
      <a href="<?php echo $shop_url . $type_tbl . '/' . $item['id'] ?>">
        <img src="<?=$item['full_image_path'] ? $item['full_image_path'] : $item['image']?>" onerror="error_image(this)" alt="">
      </a>
      <!-- <img src="/templates/home/styles/images/svg/key.svg" class="icon-key" alt=""> -->
    </div>
    <?php } ?>

    <div class="text">
      <a href="<?=$item['save_link']?>">
        <h3 class="link one-line">Nguồn: <?=$item['host']?></h3>
        <h3 class="one-line"><?=$item['title']?></h3>
      </a>
      <div class="thaotac js-menu-open-user"
        data-user_id="<?=$item['user_id']?>"
        data-id="<?=$item['id']?>"
        data-link_url="<?=$__link?>"
        data-link_type="<?=$item['link_type']?>">
        <span class="xemthem">
          <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more">
        </span>
      </div>
    </div>
  </div>
</div>