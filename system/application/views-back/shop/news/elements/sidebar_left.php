<div class="sidebar-left trangcuatoi-sidebar-left">
    <?php if (!empty($list_products)) { ?>
        <div class="group-galary mt00">
            <a href="<?php echo $shop_url . 'library/products' ?>" target="_blank">
                <h3><span class="title-border"><img src="/templates/home/styles/images/svg/sanpham.svg" width="24" alt="" class="icon-img">Sản phẩm <span>(<?php echo formatNumber($product_total['total']) ?>)</span></span></h3>
            </a>
            <ul class="list-img js_gallery-products">
                <?php
                foreach ($list_products as $key => $product) {
                    if ($key > 3) {
                        break;
                    }
                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                    if ($product->pro_image) {
                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . explode(',', $product->pro_image)[0];
                    }
                    $pro_name_xss  = htmlspecialchars($product->pro_name);
                    echo '<li class="js_product-item"  href="'.str_replace('thumbnail_2_', '', $filename).'">';
                    echo '  <a title="' . $pro_name_xss . '" href="'.$shop_url .'library/products" target="_blank">';
                    echo '      <img  onerror="image_error(this)" src="' . $filename . '" alt="' . $pro_name_xss . '" data-title="' . $pro_name_xss . '">';
                    echo '  </a>';
                    echo '</li>';
                } ?>
            </ul>
        </div>
    <?php } ?>

    <?php if (!empty($coupons)) { ?>
        <div class="group-galary">
            <a href="<?php echo $shop_url . 'library/coupons' ?>" target="_blank">
                <h3><span class="title-border"><img src="/templates/home/styles/images/svg/dichvu.svg" alt="" class="icon-img">Dịch vụ <span>(<?php echo formatNumber($coupon_total['total']) ?>)</span></span></h3>
            </a>
            <ul class="list-img js_gallery-coupns">
                <?php foreach ($coupons as $coupon) {
                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                    if ($coupon->pro_image) {
                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $coupon->pro_dir . '/thumbnail_2_' . explode(',', $coupon->pro_image)[0];
                    }
                    $coupon_name_xss  = htmlspecialchars($coupon->pro_name);
                    echo '<li class="js_coupon-item"  href="'.str_replace('thumbnail_2_', '', $filename).'">';
                    echo '  <a title="' . $coupon_name_xss . '" href="'.$shop_url . 'library/coupons" target="_blank">';
                    echo '      <img  onerror="image_error(this)" src="' . $filename . '" alt="' . $coupon_name_xss . '" data-title="' . $coupon_name_xss . '">';
                    echo '  </a>';
                    echo '</li>';
                } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="sidebar-right tablet">
        <?php echo $this->load->view('shop/news/elements/sidebar_right') ?>
    </div>
<!--    right-->
</div>