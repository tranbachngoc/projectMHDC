<?php
$link_item = azibai_url("/{$item['pro_category']}/{$item['pro_id']}") . "/" . str_replace(' ','-',RemoveSign($item['pro_name']));
if($has_af_key == true) {
  if(!empty($af_id)){
    $link_item .= "?af_id={$_REQUEST['af_id']}";
  }
}
?>

<div class="item">
  <div class="img hovereffect">
    <img class="img-responsive" src="<?=$item['pro_image']?>" onerror="error_image(this)" alt="">
    <!-- <div class="action">
      <p>
        <a href="">
          <img src="/templates/home/styles/images/svg/like_white.svg" alt="">
        </a>
      </p>
      <p>
        <a href="">
          <img src="/templates/home/styles/images/svg/bag_white.svg" alt="">
        </a>
      </p>
      <p>
        <a href="">
          <img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
        </a>
      </p>
      <div class="ctv">
        <a href="">
          <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
          <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
        </a>
      </div>
    </div> -->
    <!-- <div class="flash">
      <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
      <div class="time">99 ngày 21:03:00</div>
    </div> -->
  </div>
  <div class="text">
    <a href="<?=$link_item?>">
      <p class="tensanpham two-lines"><?=$item['pro_name']?></p>
      <div class="giadasale">
        <span class="dong">đ</span><?=number_format($item['pro_cost'], 0, ",", ".");?></div>
      <!-- <div class="giachuasale">150.000.000</div> -->
    </a>
    <!-- <div class="sm-btn-show sm">
      <img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt="">
    </div> -->
  </div>
</div>