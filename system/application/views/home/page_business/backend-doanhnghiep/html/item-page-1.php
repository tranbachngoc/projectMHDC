<?php
$check = false;

if($checking_all == 1 && $list_product == '') {
  $check = true;
} else
if(is_array($list_product) && count($list_product) > 0 && $product_type == 2 && in_array($item['pro_id'], $list_product)) {
  $check = true;
} else
if(is_array($list_product) && count($list_product) > 0 && $product_type == 1 && !in_array($item['pro_id'], $list_product)) {
  $check = true;
}
?>


<div class="item">
  <div class="img">
    <img src="<?=array_shift(explode(',',$item['pro_image']))?>" alt="">
    <label class="checkbox-style">
      <input type="checkbox" name="select-all" value="<?=$item['pro_id']?>" <?=$check == 1 ? 'checked' : ''?> class="js-checkitem">
      <span></span>
    </label>
  </div>
  <div class="tit">
    <?=$item['pro_name']?>
  </div>
</div>

<script>
  localStorage.setItem("avatar_<?=$item['pro_id']?>", "<?=array_shift(explode(',',$item['pro_image']))?>");
</script>