<?php
if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
  $image_title       = trim($item->img_library_title);
} else {
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->name;
  $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
}
$checked = false;
if( count($key_imgs) > 0 && in_array($item->id,$key_imgs) ) {
  $checked = true;
}
list($width, $height) = getimagesize($image_url);
$class_css = $width > $height ? "img-vertical" : "img-horizontal";
?>
<div class="col-item js-item-click-check" 
  data-check="<?=$item->id?>" 
  data-selected="<?=$checked == true ? 'true' : 'false'?>" 
  data-img="<?=$image_url?>"
  data-imgtitle="<?=$image_title?>"
  data-imgupdetect="<?=$item->img_up_detect?>">
  <div class="item">
    <div class="img">
      <img src="<?=$image_url?>" class="up-img <?=$class_css?>"
        alt="">
      <div class="icon-checked">
        <?php if($checked == true) { ?>
          <img src="/templates/home/styles/images/svg/checked.svg" alt="">
        <?php } else { ?>
          <img src="/templates/home/styles/images/svg/check.svg" alt="">
        <?php }?>
      </div>
    </div>
  </div>
</div>