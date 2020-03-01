<?php
$disabled = true;
$is_set_avatar = false;
if($item->not_id == 0 && $item->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $item->img_library_dir . '/' . $item->name;
  $image_title       = trim($item->img_library_title);
  $disabled = false;
} else {
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->name;
  $image_title       = $item->title != '' ? trim($item->title) : trim($item->not_title);
}

if(strcmp($album_info->album_image, $item->name) == 0) {
  $is_set_avatar = true;
}

$css_select = 'style="border: 1px solid red; border-radius: 5px"';
$css_not_select = 'style="border: none; border-radius: none"';
?>
<div class="col-item">
  <div class="item">
    <div class="img" <?=$is_set_avatar == true ? $css_select : $css_not_select?>>
      <img src="<?=$image_url?>" class="up-img data-image-upload" alt=""
      data-editId = "<?=$item->id?>"
      data-editDetectLib = "<?=$item->img_up_detect?>"
      data-editImageUpload = "false"
      data-editIndex = "false">
      <div class="action">
        <p class="act-setavatar" style="display: <?=$is_set_avatar == true ? 'block': 'none'?>" 
          data-editAvatar="<?=$item->id?>" 
          data-editFrom="library" 
          data-editSetavatar="<?=$is_set_avatar == true ? 'true' : 'false'?>">
          <img src="/templates/home/styles/images/svg/album_ico_setting.svg" alt="">
        </p>
        <p class="act-close" style="display: <?=$is_set_avatar == true ? 'none': 'block'?>">
          <img src="/templates/home/styles/images/svg/album_ico_close.svg" alt="">
        </p>
      </div>
    </div>
    <div class="txt">
      <div class="form-group">
        <textarea <?=$disabled == true ? 'disabled' : ''?> class="form-control" rows="2" placeholder="Tiêu đề (tùy chọn)"><?=$image_title?></textarea>
      </div>
    </div>
  </div>
</div>
<?php if($is_set_avatar == true) { ?>
  <script>
    id_image_avatar = '<?=$item->id?>';
  </script>
<?php } ?>