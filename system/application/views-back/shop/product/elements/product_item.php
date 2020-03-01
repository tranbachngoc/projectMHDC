<?php
$protocol = get_server_protocol();
$pro_name_slug = RemoveSign($item->pro_name);
$pro_name_xss = htmlspecialchars($item->pro_name);
?>
<div class="item">
    <div class="image">
        <?php $pro_image = explode(',', $item->pro_image); ?>
        <a title="<?php echo $pro_name_xss ?>"
           href="<?php echo $protocol . domain_site . '/' . $item->pro_category . '/' . $item->pro_id . '/' . $pro_name_slug;  ?>">
            <img onerror="image_error(this)" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/' . @$pro_image[0] ; ?>"
                 alt="<?php echo $pro_name_xss ?>"
                 title="<?php echo $pro_name_xss ?>">
        </a>
    </div>
    <div class="text">
        <p><a title="<?php echo $pro_name_xss ?>"
              href="<?php echo $protocol . domain_site . '/' . $item->pro_category . '/' . $item->pro_id . '/' . $pro_name_slug;  ?>"><?php echo $item->pro_name ?></a></p>

        <?php if ($item->pro_saleoff == 1): ?>
            <?php $sale = $item->pro_cost - ($item->pro_cost * $item->pro_saleoff_value / 100); ?>
            <div class="price">
                <p><span class="dong">đ</span><span class="chuasale"><?php echo number_format($item->pro_cost, 0, ",", "."); ?></span></p>
                <p class="dasale"><?php echo number_format($sale, 0, ",", "."); ?></p>
            </div>
        <?php else: ?>
            <div class="price">
                <p class="dasale no-margin">
                    <span class="dong">đ</span>
                    <?php echo number_format($item->pro_cost, 0, ",", "."); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <div class="icon">
        <p onclick='addCartQtyAtShop(<?php echo $item->pro_id?>)'><a href="JavaScript:Void(0);">
            <img src="/templates/home/styles/images/svg/cart03.svg" width="24" alt=""></a>
        </p>
<!--        <p><a href="JavaScript:Void(0);"><img src="/templates/home/styles/images/svg/like.svg" width="24" alt=""></a></p>-->
<!--        <p><a href="JavaScript:Void(0);"><img src="/templates/home/styles/images/svg/bookmark.svg" width="24" alt=""></a></p>-->
    </div>
</div>