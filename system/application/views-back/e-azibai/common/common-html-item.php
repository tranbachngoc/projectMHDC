<?php
$num = rand(0,10000);
// hình
if($item->dp_id > 0){
  $img = DOMAIN_CLOUDSERVER.'media/images/product/'.$item->pro_dir.'/'. $item->dp_images;
}else{
  $img = DOMAIN_CLOUDSERVER.'media/images/product/'.$item->pro_dir.'/'. explode(',',$item->pro_image)[0];
}

// link đến chi tiết sản phẩm
$link_item = azibai_url().'/'.$item->pro_category.'/'.$item->pro_id.'/'. str_replace(' ','-',RemoveSign($item->pro_name)); 
if(!empty($af_id)){
  $link_item .= "?af_id=$af_id";
}

// sp có đang sale hay ko + giá show sp
if($item->pro_saleoff == 1 && $item->end_date_sale != '' && $item->end_date_sale >= time() && $item->begin_date_sale <= time())  { 
  $item->is_selling = true;
  // if($item->pro_type_saleoff == 1) { // giảm theo %
  //   $sale = $item->pro_cost - ($item->pro_cost * $item->pro_saleoff_value / 100);
  // } else {
  //   $sale = $item->pro_cost - $item->pro_saleoff_value;
  // }
}else{
  $item->is_selling = false;
  // $sale = $item->pro_cost;
}
// $price = $item->pro_cost;

if($has_af_key == true && $item->is_product_affiliate == 1){
  // if($item->af_dc_amt > 0){
  //   // $price = $price - $item->af_dc_amt;
  //   $sale = $sale - $item->af_dc_amt;
  // } else if($item->af_dc_rate > 0){
  //   // $price = $price - ($price * $item->af_dc_rate / 100);
  //   $sale = $sale - ($sale * $item->af_dc_rate / 100);
  // }
}

$price = $item->hoahong['price'];
$price = number_format($price, 0, ",", ".");
$sale = ($item->hoahong['price_aff'] > 0) ? $item->hoahong['price_aff'] : $item->hoahong['priceSaleOff'];
$sale = number_format($sale, 0, ",", ".");

//data check CTV select sp
$user_id = (int)$this->session->userdata('sessionUser');
$group_id = (int)$this->session->userdata('sessionGroup');
$show_CTV = false;
$is_selected_af_pro = false;
$is_like = false;
$pro_affiliate_value = '';

if( $group_id && $user_id
    && $user_id != $item->pro_user
    && $item->is_product_affiliate == 1
    && $group_id != StaffStoreUser
    && !($group_id == AffiliateUser && $azitab['user']->parent_id == $item->pro_user)
    && !($azitab['user']->parent_shop == $item->pro_user))
  {
    !in_array($item->pro_id, $currentuser->arr_pro_af) ? $is_select_af_pro = true : $is_select_af_pro = false;
    in_array($item->pro_id, $currentuser->arr_pro_like) ? $is_like = true : $is_like = false;
  }
?>

<div class="item <?='item-'.$item->pro_id?>" id="bt_<?=$item->pro_id .$num?>">
  <div class="img hovereffect">
    <img onerror="error_image(this)" class="img-responsive" src="<?=$img?>" alt="">
    <div class="action">
      <p class="js-like-product" data-id="<?=$item->pro_id?>">
        <a href="javascript:void(0)">
          <img  src="<?=$is_like == true ? '/templates/home/styles/images/svg/like_pink.svg' : '/templates/home/styles/images/svg/like_white.svg' ?>" alt=""
          data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
          data-notlike-icon="/templates/home/styles/images/svg/like_white.svg"
          data-change-all-proid="<?=$item->pro_id?>">
        </a>
      </p>
      <?php $this->load->view('home/common/temp_hoahong', array('item' => $item, 'af_id' => $_REQUEST['af_id'])); ?>
    </div>

    <?php if ($item->is_selling == 1) { ?>
    <div class="flash">
      <!-- <img src="/templates/home/styles/images/svg/flashsale_pink.svg" class="md" alt=""> -->
      <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
      <div class="time" id='flash-sale_<?= $item->pro_id .$num ?>'>
        <script>cd_time(<?=$item->end_date_sale * 1000 ?>,<?=$item->pro_id . $num?>);</script>
      </div>
    </div>
    <?php } ?>
  </div>

  <div class="text">
    <a href="<?=$link_item?>" target="_blank">
      <p class="tensanpham two-lines"><?=$item->pro_name?></p>

      <?php if ($item->is_selling == true && $item->have_num_tqc == 0) { ?>
        <div class="giadasale"><span class="dong">đ</span><?=$sale?></div>
        <div class="giachuasale"><?=$price?></div>
      <?php } else if ($item->is_selling == false && $item->have_num_tqc == 0) { ?>
        <div class="giadasale"><span class="dong">đ</span><?=$sale?></div>
      <?php } else if ($item->have_num_tqc > 0) { ?>
        <div class="giadasale">Sản phẩm giá theo lựa chọn</div>
      <?php } ?>
    </a>
    <div class="sm-btn-show sm"><img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt=""></div>
  </div>

  <input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
	<input type="hidden" name="qty" value="<?php echo !empty($item->pro_minsale) ? $item->pro_minsale : 1 ?>" />
	<input type="hidden" name="product_showcart" value="<?php echo $item->pro_id; ?>" />
	<input type="hidden" name="dp_id" value="<?php echo $item->dp_id; ?>" />
</div>