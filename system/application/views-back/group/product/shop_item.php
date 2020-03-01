<?php $true = ''; if($favofite){ $true = ",'true'"; } ?>
<div class="rowitem">
    <div class="row">
    <?php
    if(count($products) > 0){
        $list_favorite = array();
        foreach ($favorite as $key => $item){
            $list_favorite[] = $item->prf_product;
        } 
        foreach($products as $keys => $product)
        {    
            if ($keys > 0 && $keys % 8 == 0) {
                echo '</div></div><div class="rowitem"><div class="row">';
            }
            $afSelect = false;
                                        
            $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);

            if($product->pro_type == 0){
                    $tlink = 'product';
            } else {
                    $tlink = 'coupon';	
            }

            $image = '/media/images/no_photo_icon.png';
            $_img = explode(',', $product->pro_image);
            $have_img = DOMAIN_CLOUDSERVER . 'media/images/product/'. $product->pro_dir . '/thumbnail_2_'. $_img[0];
            if($product->pro_image != ''){ //&& file_exists($have_img)
                $image = $have_img;
            }

            $link = getAliasDomain() .'grtshop/'. $tlink . '/detail/'. $product->pro_id .'/'. RemoveSign($product->pro_name);

            if($this->session->userdata('sessionUser') > 0){        
                $user = $this->user_model->get('af_key', 'use_id = '. (int)$this->session->userdata('sessionUser'));
                $ukey = ($user->af_key != '') ? $user->af_key : '';
                $gr_saler = ($ukey != '') ? ('?gr_saler='. $ukey) : '';
            }

            $link = $link . $gr_saler;
 ?>
        <div class="item col-xs-6 col-sm-4 col-md-3">
            <div class="product-item sBtn" style="background: #fff;">
                <div class="product-item-photo product-item-info fix1by1">
                    <div class="c">
                        <!--<a href="<?php echo $link; ?>">-->
                            <img src="<?php echo $image; ?>" id="<?php echo $product->pro_id; ?>" class="" alt="<?php echo $product->pro_name; ?>">
                        <!--</a>-->
                    </div>

                 <div class="list-container">
                    <div class="product-item-button button-group text-center" id="bt_<?php echo $product->pro_id; ?>">
                        <a href="#" class="btn btn-default" type="button" title="Thêm vào giỏ hàng" onclick="addCart(<?php echo $product->pro_id?>);">
                            <i class="fa fa-cart-plus fa-fw"></i>
                        </a>
                        <?php
                        if(in_array($product->pro_id, $list_favorite)){
                        ?>
                            <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id.$true ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?>" title="Bỏ thích">
                                <i class="fa fa-heartbeat"></i>
                            <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?> hidden" title="Thêm vào yêu thích">
                                <i class="fa fa-heart-o"></i>
                            </a>
                        <?php } else{ ?>
                            <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?>" title="Thêm vào yêu thích">
                                <i class="fa fa-heart-o"></i>
                            </a>
                        <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id.$true ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?> hidden" title="Bỏ thích">
                                <i class="fa fa-heartbeat"></i>
                            </a>
                        <?php } ?>
                        <a class="btn btn-default" href="<?php echo $link; ?>" title="Xem chi tiết">
                            <i class="fa fa-eye fa-fw"></i>
                        </a>

                        <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>">
                        <input type="hidden" name="af_id" value="<?php echo $af ?>">
                        <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
                        <input type="hidden" name="qty" value="1">
                    </div>
                 </div>
                </div>
                <div class="new" style="position: absolute; top: 15px; left: 15px;">
                    <img src="/templates/shop/default/images/new.png">
                </div>
                <style> 
                    .hight_light{ color: #000; font-weight: bold}
                    a:hover .hight_light, a:focus .hight_light{ color: #39f; font-weight: bold}
                </style>
                <?php
                if(isset($parrams) || isset($keyword)){
                    if(isset($parrams)){
                        $keyw = $parrams['q'];
                    }else{
                        $keyw = $keyword;
                    }
                    $arr = explode(' ', $product->pro_name);
                    $name = array();
                    foreach ($arr as $key=>$item){
                        $keyword = khongdau(mb_strtolower($keyw));
                        $str = khongdau(mb_strtolower($item));
                        if(strpos($str, $keyword) !== false){
                            $name[] = '<span class="hight_light">'.$item.'</span>';
                        }else{
                            $name[] = $item; 
                        }
                    }
                    $pro_name = implode(' ', $name);
                }else{
                    $pro_name = $product->pro_name;
                }
                ?>
                <div style="padding: 0px 10px 10px;">
                    <h5 class="pro-name text-center" style="height:30px;">
                        <a href="<?php echo $link; ?>"><?php echo $pro_name;//; //$newstring ?></a>

                    </h5>
                    <p class="content_price text-center">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            <span class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
                            <span class="cost-price text-muted" style="text-decoration:line-through"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
                        <?php } else { ?>
                            <span class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
                        <?php } ?>                                      
                    </p>
                </div>
            </div>
        </div> 
    <?php 
        }
    }
    else{
            echo '<div style="margin: 0 10px 20px; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">Không có sản phẩm</div>';
        }
    ?>     
    </div>
</div>