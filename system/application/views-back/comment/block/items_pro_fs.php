<?php 
$random1 = rand(0, 99);
$random2 = rand(100, 999);
$sub_id = $random1 * $random2;
$is_fsale = false;
?>
<div class="flash-sale">
  <span class="flash-sale-pagingInfo" id="flash-sale-pagingInfo_<?=$sub_id?>"></span>
  <div class="slider flash-sale-slider" id="flash-sale-slider_<?=$sub_id?>">
    <?php foreach ($products as $key => $value) { ?>
      <?php if($value->pro_saleoff == 1 && $value->end_date_sale != '' && $value->end_date_sale >= time() && $value->begin_date_sale <= time())  {
        $is_fsale = true;
      }?>
    <div class="flash-sale-content">
      <a href="#">
        <div class="img">
          <img src="<?=$value->pro_image?>" alt="">
          <?php if ($is_fsale == true) { ?>
            <span class="icon-flas">
              <img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt="">
            </span>
          <?php } ?>
        </div>
        <div class="info">
          <div class="settime-ctv">
            <?php if ($is_fsale == true) { ?>
              <div class="settime" id="flash-sale_<?=$sub_id?>"></div>
            <?php } ?>
          </div>
          <p class="txt"><?=$value->pro_name?></p>
          <div class="price">
            <?php if($is_fsale == true) {
                if($value->pro_saleoff == 1) { // giảm theo %
                    $sale = $value->pro_cost - ($value->pro_cost * $value->pro_saleoff_value / 100);
                    } else {
                    $sale = $value->pro_cost - $value->pro_saleoff_value;
                    } ?>
                
                <!-- <span class="dong">đ</span> -->
                <span class="price-main"><?php echo number_format($value->pro_cost, 0, ",", ".")?></span>
                <span class="price-sale"><?php echo number_format($sale, 0, ",", ".") . ' ' . $value->pro_currency ?></span>
            <?php } else { ?>
                <span class="price-sale"><?php echo number_format($value->pro_cost, 0, ",", ".") . ' ' . $value->pro_currency ?></span>
            <?php }?>
          </div>
        </div>
      </a>
    </div>
      <?php if ($is_fsale == true) {?>
        <script>
          cd_time(<?php echo $value->end_date_sale * 1000 ; ?>,<?php echo $sub_id?>);
        </script>
      <?php } ?>
    <?php } ?>
  </div>
</div>
<script>slider_fs(<?php echo $sub_id?>);</script>