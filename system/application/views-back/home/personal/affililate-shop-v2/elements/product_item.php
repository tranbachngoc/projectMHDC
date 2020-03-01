<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
}
$link = azibai_url("/{$item['pro_category']}/{$item['pro_id']}/") . RemoveSign($item['pro_name']) . $af_key;
$date = new DateTime();
$cur_date = $date->getTimestamp();

// dd($cur_date);
// dd($item);
?>
<div class="item">
  <div class="img hovereffect">
    <img class="img-responsive" src="<?=$item['pro_image']?>" alt="">
    <div class="action">
      <!-- <p><a href=""><img src="/templates/home/styles/images/svg/like_white.svg" alt=""></a></p>
      <p><a href=""><img src="/templates/home/styles/images/svg/bag_white.svg" alt=""></a></p>
      <p><a href=""><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></a></p> -->
      <?php if($item['pro_aff'] == 1) {?>
      <!-- <div class="ctv"  data-toggle="modal" data-target="#congtacvien">
        <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
        <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
      </div> -->
      <?php } ?>
    </div>
    <?php if($item['start_date'] <= $cur_date && $cur_date <= $item['end_date']) { ?>
    <div class="flash">
      <img src="/templates/home/styles/images/svg/flashsale_pink_sm.png" alt="">
      <div class="time" id="flash-sale_<?=$item['pro_id']?>"><?=$item['pro_id']?></div>
      <script>cd_time(<?=$item['end_date'] * 1000?>,<?=$item['pro_id']?>)</script>
    </div>
    <?php } ?>
  </div>
  <div class="text">
    <a href="<?=$link?>">
      <p class="tensanpham two-lines">
        <!-- <img src="/templates/home/styles/images/hinhanh/01.jpg" class="avt" alt=""> -->
        <?=$item['pro_name']?></p>
      <div class="giadasale"><span class="dong">đ</span><?=number_format($item['pro_dis'],0,'.',',')?></div>
      <div class="giachuasale"><?=number_format($item['pro_cost'],0,'.',',')?></div>
    </a>
    <div class="sm-btn-show sm"><img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt=""></div>
  </div>
</div>