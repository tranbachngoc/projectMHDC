<div  class="item_pro_asign">
    <a  href="<?php echo replaceAliasDomain($product['link']);?>" target="_blank">
        <img width="80" src="<?php echo replaceImage($product['image']);?>" alt="">
        <?php echo sub($product['pro_name'], 50); ?>
        <p>Số lượng: <span class="badge"><?php echo $product['qty'];?></span></p>
        <p class="text-danger">
            Thành tiền: <?php echo lkvUtil::formatPrice($product['pro_price'] * $product['qty'], 'đ'); ?>
        </p>
    </a>
</div>