<?php 



$linktoproduct = azibai_url() . '/' . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $afkey;

$pro_price = ($product->hoahong['price_aff'] > 0) ? $product->hoahong['price_aff'] : $product->hoahong['priceSaleOff'];

?>
<div class="flash-sale-content js_product-item-<?php echo  $product->pro_id?>" style="display: -webkit-flex;">
    <a href="<?php echo $linktoproduct ?>">
        <div class="img">
            <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image); ?>">
            <!-- has flash sale-->
            <?php if($is_fsale == true)  {
            ?>
            <span class="icon-flas"><img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt=""></span>
            <?php } ?>

            <!-- <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . show_image($value->pro_image); ?>"> -->
        </div>
    </a>
    <div class="info">
        <div class="settime-ctv">
            <?php if ($is_fsale == true) { ?>
            <div class="settime" id="flash-sale_<?php echo $idFlash?>"></div>
            <?php } ?>
            <div class="ctv">
                <?php $this->load->view('home/common/temp_hoahong', array('item' => $product, 'af_id' => $_REQUEST['af_id'])); ?>
            </div>
        </div>
        <?php

        if (
            $group_id == BranchUser
            || $group_id == AffiliateUser
            || ($group_id == AffiliateStoreUser && $user_id != $product->pro_user && $product->is_product_affiliate == 1)
        ) {
            if ($product->is_product_affiliate == 1) {
                if ($product->af_amt > 0) {
                    $pro_affiliate_value = formatNumber($product->af_amt) . ' VNĐ';
                    $pro_type_affiliate = 2;
                } else {
                    $pro_affiliate_value = $product->aff_rate . ' %';
                    $pro_type_affiliate = 1;
                }
            } ?>
            <?php if (!empty($pro_affiliate_value)){ ?>
                <!-- <div class="ctv js_get-pop-commission" 
                     data-product="<?php echo $value->pro_id ?>"
                     data-commission="<?php echo $pro_affiliate_value ?>"
                     data-domain="<?php echo getAliasDomain() ?>"
                     data-select="<?php echo !empty($value->selected_sale)? 'true' : 'false'?>">
                    <img src="/templates/home/styles/images/svg/CTV<?php echo !empty($value->selected_sale)? '_add' : '' ?>.svg" title="<?php echo $pro_affiliate_value ?>">
                </div> -->
            <?php } ?>
        <?php } ?>
        <a href="<?php echo $linktoproduct ?>">
            <p class="txt"><?php echo $value->pro_name ?></p>
        </a>
        <div class="price">
            <?php
            if ($product->have_num_tqc > 0)
            {
            ?>
              <span class="price-sale">Sản phẩm giá theo lựa chọn</span>
            <?php
            }
            else
            {
                ?>
            <?php if($is_fsale == true) {
                // if($value->pro_type_saleoff == 1) { // giảm theo %
                //     $sale = $value->pro_cost - ($value->pro_cost * $value->pro_saleoff_value / 100);
                //     } else {
                //     $sale = $value->pro_cost - $value->pro_saleoff_value;
                //     }
                    ?>
                
                <!-- <span class="dong">đ</span> -->
                <span class="price-main"><?php echo number_format($product->pro_cost, 0, ",", ".")?></span>
                <span class="price-sale"><?php echo number_format($pro_price, 0, ",", ".") . ' ' . $product->pro_currency ?></span>
            <?php } else { ?>
                <span class="price-sale"><?php echo number_format($product->pro_cost, 0, ",", ".") . ' ' . $product->pro_currency ?></span>
            <?php }
            }
            ?>
        </div>
    </div>
</div>
<?php if ($is_fsale == true && $slider_pro != true) {?>
<script>
    cd_time(<?php echo $product->end_date_sale * 1000 ; ?>,<?php echo $content->not_id . $random . $k?>);
</script>
<?php } ?>