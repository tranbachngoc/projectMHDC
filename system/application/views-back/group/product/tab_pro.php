<div class="rowitem">
        <div class="row">
        <?php
        if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
            $user_login = $this->user_model->get('af_key', "use_id = " . (int)$this->session->userdata('sessionUser'));
            $af_id = $user_login->af_key;
        }
        $afSelect = false;
        if ($af_id != '' && $product->is_product_affiliate == 1) {
            $afSelect = true;
        }
        if(count($products) > 0){
            foreach ($products as $keys => $item) {
                if ($keys > 0 && $keys % 8 == 0) {
		    echo '</div></div><div class="rowitem"><div class="row">';
		}
                $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect);
                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/thumbnail_2_' . explode(',', $item->pro_image)[0];
                $type = 'product';
		if ($item->pro_type == 2) {
		    $type = 'coupon';
		}
		$a = '/grtshop/' . $type . '/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name);
                $a = ($af_id != '') ? $a.'?af_id='.$af_id : $a;
		?>
		<div class="col-xs-6 col-sm-3 product-item">                                        
		    <div class="product-item-info">
			<div class="product-item-photo" id="bt_<?php echo $item->pro_id ?>">
			    <div class="fix1by1">
				<div class="c">
                                    <div class="like <?php if(!in_array($item->pro_id, $list_favorite)){ echo 'hidden'; } ?>" onclick="delheart(<?php echo $item->pro_id ?>,'<?php if($this->uri->segment(2) == 'favorites'){ echo "favorites"; } ?>');"></div>
				    <img class="img-responsive" src="<?php echo $filename ?>" alt="<?php echo $item->pro_name ?>"/>
				</div>
			    </div>
                            <div class="product-item-button">
                                <div class="text-center">
                                    <a href="#addCart" onclick="addCart(<?php echo $item->pro_id ?>);" class="btn btn-default" title="Thêm vào giỏ hàng">
                                        <i class="fa fa-cart-plus"></i>
                                    </a>	
                                    <a href="#wishlist" onclick="wishlist(<?php echo $item->pro_id ?>);" class="btn btn-default <?php if(in_array($item->pro_id, $list_favorite) || $this->uri->segment(2) == 'favorites'){ echo 'hidden'; } ?> addheart_<?php echo $item->pro_id ?>" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                    <a href="<?php echo $a ?>"  class="btn btn-default" title="Chi tiết sản phẩm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <input type="hidden" name="product_showcart" value="<?php echo $item->pro_id; ?>">
                                    <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $item->dp_id; ?>">
                                    <input type="hidden" name="qty" value="<?php echo $item->pro_minsale?>">
                                    <input type="hidden" name="gr_id" value="<?php echo $siteGlobal->grt_id; ?>">
                                    <input type="hidden" name="gr_saler" value="<?php echo $guser; ?>">
                                </div>
                            </div>
			</div>
                        <?php
                        if(count($parrams)>0 || isset($keyword)){
                            if(isset($parrams)){
                                $keyw = $parrams['q'];
                            }else{
                                $keyw = $keyword;
                            }
                            $arr = explode(' ', $item->pro_name);
                            $name = array();
                            foreach ($arr as $key=>$value){
                                $keyword = khongdau(mb_strtolower($keyw));
                                $str = khongdau(mb_strtolower($value));
                                if(strpos($str, $keyword)>= 0 && strpos($str, $keyword) !== false){
                                    $name[] = '<span class="hight_light">'.$value.'</span>';
                                }else{
                                    $name[] = $value; 
                                }
                            }
                            $pro_name = implode(' ', $name);
                        }else{
                            $pro_name = $item->pro_name;
                        }
                        ?>
			<div class="product-item-detail text-center">
			    <span class="product-item-name"><a href="<?php echo $a ?>" title="<?php echo $item->pro_name ?>"><?php echo $pro_name ?></a></span>					
			    <div class="product-item-price">
				<div class="price">
				    <?php
				    if ($discount['salePrice'] < $item->pro_cost) {
					?>
	    			    <span class="sale-price-amount">
                                        <?php echo lkvUtil::formatPrice($discount['salePrice'], '') ?> <span class="currencySymbol">đ</span>
	    			    </span>
	    			    <span class="cost-price-amount">
                                        <?php echo lkvUtil::formatPrice($item->pro_cost, '') ?> <span class="currencySymbol">đ</span>
	    			    </span>
				    <?php } else { ?>
	    			    <span class="sale-price-amount">
                                        <?php echo lkvUtil::formatPrice($discount['salePrice'], '') ?> <span class="currencySymbol">đ</span>
	    			    </span>
				    <?php } ?>
				</div>
			    </div>
			</div>
		    </div>	
		</div>               
	    <?php
            }
        }else{
            echo '<div class="box_nopro">Không có dữ liệu</div>';
        }//endforeach;?>
    </div>
</div>