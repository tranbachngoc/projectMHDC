<div class="sidebar-left trangcuatoi-sidebar-left">
    <div class="gioithieu hide_0">
        <h3><img src="/templates/home/images/svg/quadiacau.svg" alt="" class="icon-img">Giới thiệu</h3>
        <ul>
            <?php if($info_public['use_about']){ ?>
                <li><?php echo $info_public['use_about']; ?></li>
            <?php } ?>
            <?php if($info_public['use_address']){ ?>
                <li><?php echo $info_public['use_address']; ?></li>
            <?php } ?>
            <?php if($info_public['use_birthday']){ ?>
                <li><?php echo format_date($info_public['use_birthday']); ?></li>
            <?php } ?>
            <?php if($info_public['province']){ ?>
                <li>Đến từ: <?php echo $info_public['province']['pre_name']; ?></li>
            <?php } ?>

        </ul>
        <div class="docthem"><a href="/profile/<?php echo $info_public['use_id']; ?>/about">Xem thêm</a></div>
        <div class="follow">
            <p>Bạn bè   <strong>0</strong></p>
            <p>Người theo dõi  <strong>0</strong></p>
        </div>
    </div>
    <?php if (!empty($products)) { ?>
        <div class="group-galary hide_0">
            <a href="<?php echo $profile_url . '/library/products'; ?>">
                <h3><img src="/templates/home/styles/images/svg/sanpham.svg" alt="" class="icon-img">Sản phẩm</h3>
            </a>
            <ul class="list-img js_gallery-products">
                <?php
                foreach ($products as $key => $product) {
                    if($key >= 4){
                        break;
                    }
                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                    if ($product->pro_image) {
                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . explode(',', $product->pro_image)[0];
                    }
                    $pro_name_xss  = htmlspecialchars($product->pro_name);
                    echo '<li class="js_product-item"  href="'.str_replace('thumbnail_2_', '', $filename).'">';
                    echo '  <a title="' . $pro_name_xss . '" href="'.$profile_url . '/library/products" target="_blank">';
                    echo '      <img  onerror="image_error(this)" src="' . $filename . '" alt="' . $pro_name_xss . '" data-title="' . $pro_name_xss . '">';
                    echo '  </a>';
                    echo '</li>';

                }?>
            </ul>
        </div>
    <?php } ?>
    <?php if (!empty($coupons)) { ?>
        <div class="group-galary hide_0">
            <a href="<?php echo $profile_url . '/library/coupons'; ?>" target="_blank">
                <h3><img src="/templates/home/styles/images/svg/dichvu.svg" alt="" class="icon-img">Dịch vụ</h3>
            </a>
            <ul class="list-img js_gallery-coupons">
                <?php foreach ($coupons as $key => $coupon) {
                    if($key >= 4){
                        break;
                    }
                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                    if ($coupon->pro_image) {
                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $coupon->pro_dir . '/thumbnail_2_' . explode(',', $coupon->pro_image)[0];
                    }
                    $coupon_name_xss  = htmlspecialchars($coupon->pro_name);
                    echo '<li class="js_coupon-item"  href="'.str_replace('thumbnail_2_', '', $filename).'">';
                    echo '  <a title="' . $coupon_name_xss . '" href="'.$profile_url . '/library/coupons" target="_blank">';
                    echo '      <img  onerror="image_error(this)" src="' . $filename . '" alt="' . $coupon_name_xss . '" data-title="' . $coupon_name_xss . '">';
                    echo '  </a>';
                    echo '</li>';
                }?>
            </ul>
        </div>
    <?php } ?>
</div>