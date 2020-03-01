<?php
$pro_name_slug = RemoveSign($product->pro_name);
$pro_name_xss = htmlspecialchars($product->pro_name);
$pro_image = explode(',', $product->pro_image);
$product_url =  azibai_url() . '/' . $product->pro_category . '/' . $product->pro_id . '/' . $pro_name_slug;
?>
<div class="item">
    <div class="detail">
        <a href="<?php echo $product_url ?>" target="_blank">
            <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . @$pro_image[0] ; ?>"
                 alt="<?php echo $pro_name_xss ?>"
                 class="lazyload"
                 title="<?php echo $pro_name_xss ?>"
                 onerror="image_error(this)">
        </a>
        <div class="text">
            <h3>
                <a href="<?php echo $product_url ?>" title="<?php echo $pro_name_xss ?>" target="_blank">
                    <?php echo limit_the_string($pro_name_xss) ?>
                </a>
            </h3>
            <div class="thaotac hidden">
                <span class="xemthem">
                    <img class="mt05" src="/templates/home/styles/images/svg/3dot_small_gray.svg" alt="more">
                </span>
                <div class="show-more">
                    <ul class="show-more-detail">
                        <li><a href="JavaScript:Void(0);">Gửi dưới dạng tin nhắn</a></li>
                        <li><a href="JavaScript:Void(0);">Lưu ảnh</a></li>
                        <li><a href="JavaScript:Void(0);">Báo cáo ảnh</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>