<div class="item_pro_asign" >
    <?php if ($product->pro_type == 2){ ?>
        <div class="tag_coupon"><i class="fa fa-tags"></i> Coupon</div>
    <?php } ?>
    <a href="<?php echo getAliasDomain().$product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name);?>" target="_blank">
        <?php
        $img1 = explode(',', $product->pro_image);
        $fileimg = 'media/images/product/'. $product->pro_dir.'/'. show_thumbnail($product->pro_dir, $img1[0], 1);
        if($img1[0] != "" && file_exists($fileimg)){?>
            <img width="80" src="<?php echo getAliasDomain().'media/images/product/'. $product->pro_dir.'/'. show_thumbnail($product->pro_dir, $img1[0], 1);?>" alt="" />
        <?php }else {?>
            <img src="<?php echo getAliasDomain() . 'images/img_not_available.png'?>" alt="">
        <?php }?>
        <?php echo  $product->pro_name;?>
        <p class="text-danger">Giá bán: <b><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ');?></b></p>
    </a>
</div>