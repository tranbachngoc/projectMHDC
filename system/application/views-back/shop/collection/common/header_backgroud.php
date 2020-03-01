<?php
if($info_public['avatar']){
  $info_public_avatar_path = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $info_public['avatar'];
} else {
  $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
}
?>

<div class="cover-content">
  <div class="cover-part">
    <img src="/templates/home/styles/images/cover/cover_me.jpg" alt="">
    <?php if ($is_owner) { ?>
    <div class="button-chinh-sua">
      <img src="/templates/home/styles/images/svg/pen.svg" alt=""><span>Chỉnh sửa</span>
    </div>
    <?php } ?>
  </div>
  <div class="avata-part">
    <div class="avata-part-left">
      <div class="avata-img">
        <img src="<?= $info_public_avatar_path ?>" alt="">
        <?php if ($is_owner) { ?>
        <div class="edit"><span><img src="/templates/home/styles/images/svg/pen.svg" alt=""></span></div>
        <?php } ?>
      </div>
      <div class="avata-title">
        <span><?php echo $info_public['use_fullname']; ?></span><br>@<?php echo $info_public['use_fullname']; ?>
      </div>
    </div>
    <div class="avata-part-right">
      <div class="chinh-sua"><a href="tel:<?=$info_public['use_mobile']?>"><img src="/templates/home/styles/images/svg/tel_white.svg" alt=""><span>Liên hệ</span></a></div>
      <div class="chinh-sua" onClick="copyUrlPage()"><a href="javascript:void(0)" class="text-white"><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""><span>Chia sẻ</span></a></div>
      <?php if ($is_owner) { ?><div class="chinh-sua"><img src="/templates/home/styles/images/svg/chinhsua.svg" alt=""><span>Chỉnh sửa</span></div><?php } ?>
      <!-- <div class="chinh-sua"><a href="<?= $shop_url . 'shop/collection' ?>"><img src="/templates/home/styles/images/svg/bosuutap.svg" alt=""><span>Bộ sưu tập</span></a></div> -->
      <div class="xemthem"><img src="/templates/home/styles/images/svg/3dot_doc_white.svg" alt=""></div>
    </div>
  </div>
</div>

<script>
function copyUrlPage() {
  var textArea = document.createElement("textarea");
  var link = window.location.href;
  textArea.value = link;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("Copy");
  textArea.remove();
}
</script>