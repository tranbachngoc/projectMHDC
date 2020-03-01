<div class="col-md-3 col-sm-6 col-xs-6">
    <div class="product-item text-center">
        <?php
        $af = isset($afLink) ? $afLink : '';
        $filename = 'media/images/product/'.$product->pro_dir.'/'. show_thumbnail($product->pro_dir, $product->pro_image, 3);
        if(!file_exists($filename) || $product->pro_image == ',,,' || $product->pro_image == ''){
            $filename = 'media/images/noimage.png';
        }
        ?>
        <div class="thumbox">
            <a href="<?php echo $mainURL.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af; ?>">
                <img src="<?php echo $URLRoot.$filename; ?>"
                     onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                     id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                     alt="<?php echo($product->pro_name); ?>"
                />

            </a>
        </div>
        <h4 class="pro_name"><a href="<?php echo $mainURL.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af; ?>"><?php echo sub($product->pro_name, 50); ?> </a></h4>
        <?php  if ($product->pro_saleoff_value!=0) : ?>
            <div class="saleoff">
                <img src="<?php echo $URLRoot; ?>templates/shop/default/images/saleoff.png"/>
            </div>
        <?php endif;?>
        <?php if(false):?>
            <p class="pro_descr">
                <?php echo sub($product->pro_descr,250); ?>
            </p>
        <?php endif;?>
        <div class="price">
            <?php  if ($product->pro_saleoff_value!=0) { ?>
                <?php
               // $tien_giam=$product->pro_cost-($product->pro_cost - (($product->pro_cost * $product->pro_saleoff_value) / 100));
				if($product->pro_type_saleoff == 1){ 
													
					$promotion_price = $product->pro_cost - ($product->pro_cost*($product->pro_saleoff_value/100));
														
				} else {
														
					$promotion_price = $product->pro_cost - $product->pro_saleoff_value;
				}
                ?>
                <span
                    class="sale-price"><?php echo number_format($promotion_price, 0, ',', ',');?></span>
                <span
                    class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
            <?php } else { ?>
                <span
                    class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
            <?php } ?>
        </div>
        <div class="button-group" id="bt_<?php echo $product->pro_id?>">
            <button class="btn btn-default  addToCart" type="button" title=""
                    onclick="addCart(<?php echo $product->pro_id?>);"><i class="fa fa-cart-plus"></i>&nbsp;
            </button>
            <button class="btn btn-default  wishlist" type="button" title=""
                    onclick="wishlist(<?php echo $product->pro_id?>);"><i class="fa fa-heart-o"></i>&nbsp;
            </button>
            <a class="btn btn-default  quickview"  href="<?php echo $mainURL.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af; ?>"><i class="fa fa-eye"></i>&nbsp;</a>
            <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" />
            <?php
            $hiddenAf = '';
            if($afLink != ''){
                $af = explode('=', $afLink);
                $hiddenAf = $af[1];
            }
            ?>
            <input type="hidden" name="af_id" value="<?php echo $hiddenAf; ?>" />
            <input type="hidden" name="qty" value="1" />
        </div>
    </div>
</div>