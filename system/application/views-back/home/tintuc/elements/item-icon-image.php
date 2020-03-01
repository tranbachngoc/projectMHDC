<div class="media-wrap">
    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $image->image; ?>" class="object-fit-cover">
    <div class="detail">
        <h3 class="three-lines"><?php echo $image->title ? $image->title : $item->title ?></h3>
        <p class="three-lines"><?php echo $image->detail ? $image->detail : $item->not_detail ?></p>
    </div>
</div>