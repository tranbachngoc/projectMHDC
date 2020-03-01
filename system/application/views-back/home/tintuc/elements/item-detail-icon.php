<div class="highlightsIconPage-detail-item">
    <div class="media-wrap">
        <?php if($type == ICON_TYPE_IMAGE && $icon->image_path){ ?>
            <img  class="object-fit-cover"
                  src="<?php echo @$this->config->item('image_path_content') . $image_dir .DIRECTORY_SEPARATOR. $icon->image_path; ?>"
                  alt="<?php echo $icon->title?>">
        <?php } ?>
        <?php if($type == ICON_TYPE_VIDEO && $icon->video_path){ ?>
            <?php $poster = $icon->video_thumb ? ($this->config->item('image_path_content') . $image_dir .DIRECTORY_SEPARATOR. $icon->video_thumb) : ''; ?>
            <video class="object-fit-cover" id="video_<?php echo uniqid();?>"
                   poster="<?php echo $poster ?>"
                   playsinline preload="metadata"
                   muted
                   autoplay
                   controls="controls">
                <source src="<?php echo $this->config->item('video_path') . $icon->video_path ?>" type="video/mp4">
            </video>
        <?php } ?>
    </div>
    <div class="text">
        <h3 class="sub-tit"><?php echo $icon->title?></h3>
        <?php if($icon->desc){ ?>
            <p class="txt"><?php echo $icon->desc ?></p>
        <?php } ?>
    </div>
</div>