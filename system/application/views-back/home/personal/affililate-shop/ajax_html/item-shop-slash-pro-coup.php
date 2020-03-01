<?php
$pro_image = explode(',', $item->pro_image)[0];
$src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/' . $pro_image;
// $price_filter dùng để filter
$price = $item->pro_cost;
if ($item->is_selling == 1) {
	if ($item->pro_saleoff_type == 1) { // giảm theo %
    $price_filter = $sale = $item->pro_cost - ($item->pro_cost * $item->pro_saleoff_value / 100);
	} else {
		$price_filter = $sale = $item->pro_cost - $item->pro_saleoff_value;
	}
} else {
  $sale = $item->pro_cost;
  $price_filter = $item->pro_cost;
}
if($has_af_key == true && $item->is_product_affiliate == 1 || $for_shop_af == true){
	if($item->af_dc_amt > 0){
	  $price = $price - $item->af_dc_amt;
	  $sale = $sale - $item->af_dc_amt;
	} else if($item->af_dc_rate > 0){
	  $price = $price - ($price * $item->af_dc_rate / 100);
	  $sale = $sale - ($sale * $item->af_dc_rate / 100);
	}
}
$price = number_format($price, 0, ",", ".");
$sale = number_format($sale, 0, ",", ".");

$link_item = azibai_url() . '/' . $item->pro_category . '/' . $item->pro_id . '/' . RemoveSign($item->pro_name);
if (!empty($af_id)) {
	$link_item .= "?af_id=$af_id";
}
?>
<div class="item" id="bt_<?=$item->pro_id?>" 
  data-index="<?=$item->index_item ? $item->index_item : $index_item?>"
  data-price="<?=$price_filter?>"
  data-char="<?=substr(RemoveSign($item->pro_name),0,1)?>">
	<div class="img hovereffect">
		<img class="img-responsive" src="<?=$src?>" alt="">
		<div class="action">
			<p class="like js-like-product" data-id="<?php echo $item->pro_id; ?>">
            <?php if (!empty($item->is_like)) { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >
               <?php } else { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
            <?php } ?>
            </p>
            <!-- <p>
				<img src="/templates/home/styles/images/svg/bag_white.svg" onclick="addCart(<?=$item->pro_id?>)" alt="">
			</p> -->
			<p>
				<img src="/templates/home/styles/images/svg/bookmark_white.svg" alt="">
			</p>
		</div>
		<?php if ($item->is_selling == 1) { ?>
		<div class="flash">
			<!-- <img src="/templates/home/styles/images/svg/flashsale_pink.svg" class="md" alt=""> -->
			<img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
			<div class="time" id='flash-sale_<?= $item->pro_id ?>'>
				<script>cd_time(<?=$item->end_date_sale * 1000 ?>,<?=$item->pro_id?>);</script>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="text">
		<a href="<?=$link_item?>" target="_blank">
			<p class="tensanpham two-lines">
				<?=$item->pro_name?>
			</p>
			<?php if ($item->is_selling == 1) { ?>
			<div class="giadasale">
				<span class="dong">đ</span>
				<?=$sale?>
			</div>
			<div class="giachuasale">
				<?=$price?>
			</div>
			<?php } else { ?>
			<div class="giadasale">
				<span class="dong">đ</span>
				<?=$sale?>
			</div>
			<?php } ?>
    </a>
    <div class="sm-btn-show sm"><img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt=""></div>
	</div>
	<input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
	<input type="hidden" name="qty" value="<?php echo !empty($item->pro_minsale) ? $item->pro_minsale : 1 ?>" />
	<input type="hidden" name="product_showcart" value="<?php echo $item->pro_id; ?>" />
	<input type="hidden" name="dp_id" value="<?php echo $item->dp_id; ?>" />
</div>