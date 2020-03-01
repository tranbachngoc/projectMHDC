<?php 
if($item['isfollow'] == 0) {
  $image_follow = '/templates/home/styles/images/svg/theodoi.svg'; 
}
if($item['isfollow'] == 1) {
  $image_follow = '/templates/home/styles/images/svg/dangtheodoi.svg';
}
if($item['isfollow'] == 2) {
  $image_follow = '/templates/home/styles/images/svg/favorite.svg';
}
$shop = [
  'sho_link'  => $item['shop_link'],
  'domain'    => $item['domain'],
];
$shop_url = shop_url($shop);
?>

<div class="item">
  <div class="group">
    <div class="group-left">
      <div class="avata">
        <a href="<?=$shop_url?>">
          <img src="<?=$item['shop_image']?>" onerror="error_image(this)" alt="">
        </a>
      </div>
      <div class="name">
        <a href="<?=$shop_url?>">
          <h4 class="two-lines"><?=$item['shop_name']?></h4>
        </a>
        <p class="text-small"><?=$item['shop_category_name']?>
          <br><?=$item['product_follow']?> sản phẩm, <?=$item['article_follow']?> bài viết
          <br><?=$item['name_province']?>, <?=$item['shop_follow']?> người theo dõi </p>
      </div>
    </div>
    <div class="group-right">
      <?php if($this->session->userdata('sessionUser')) { ?>
      <span class="favorite">
        <!-- <img src="<?=$image_follow?>" alt=""> -->
      </span>
      <?php } ?>
      <span class="icon-3dot">
        <!-- <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt=""> -->
      </span>
    </div>
  </div>
  <!-- <div class="financed">Được tài trợ</div> -->
</div>