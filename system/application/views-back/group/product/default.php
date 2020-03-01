<?php $this->load->view('group/product/common/header'); ?>
<?php
$guser = '';
if($_REQUEST['gr_saler'] && $_REQUEST['gr_saler'] != ''){
    $guser = $_REQUEST['gr_saler'];
}
?>
<div class="fullwidth-template" style="background:#ffffff; padding-bottom:30px;">             
    <div class="container">
        <?php $slides = json_decode($siteGlobal->grt_banner_slide); ?>		
        <div class="block-banner">
            <div class="banner-owl-carousel owl-carousel">							
                <?php foreach ($slides as $key => $value) { ?>
                    <div class="fix3x1">
                        <a class="c" href="<?php echo  $value->url ?>" 
                           style="background:url('<?php echo  DOMAIN_CLOUDSERVER . 'media/group/banners/' . $siteGlobal->grt_dir_banner . '/' . $value->image ?>') no-repeat center / 100% auto;">					
                        </a>
                    </div>
                <?php } ?>
            </div>                    
        </div>
        <div class="block-service">
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <div><i class="fa fa-send-o fa-3x pull-left"></i> MIỄN PHÍ VẬN CHUYỄN<br><small>Đơn hàng từ 1.000.000 đ</small></div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div><i class="fa fa-clock-o fa-3x pull-left"></i> 30 NGÀY ĐỔI TRẢ<br><small>Bảo đảm hoàn lại tiền</small></div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div><i class="fa fa-support fa-3x pull-left"></i> HỖ TRỢ 24/7<br><small>Hỗ trợ trực tuyến</small></div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div><i class="fa fa-umbrella fa-3x pull-left"></i> MUA SẮM AN TOÀN<br><small>Bảo đảm mua sắm an toàn</small></div>
                </div>
            </div>
        </div>
    <?php if($sale_products){ ?>
        <div id="floor_0" class="block-product ">
            <div class="block-title">
                <strong class="title text-uppercase">Sản phẩm khuyến mãi </strong>  <span class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y') ?></span>                      
            </div>                
            <div class="block-content">                             
                <div class="product-owl-carousel owl-carousel">
                <?php 
                if($this->session->userdata('sessionGroup') == 2){
                    $user_login = $this->user_model->get('af_key', "use_id = " . (int)$this->session->userdata('sessionUser'));
                    $af_id = $user_login->af_key;
                }
                $afSelect = false;
                if ($af_id != '' && $product->is_product_affiliate == 1) {
                    $afSelect = true;
                }
                foreach ($sale_products as $key => $item) {
                    $pro_type = 'product';
                    if($item->pro_type == 2){
                        $pro_type = 'coupon';
                    }
                    $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect);
                    $product_detail = getAliasDomain(). 'grtshop/' . $pro_type . '/detail/'. $item->pro_id .'/'. RemoveSign($item->pro_name);
                    // if($siteGlobal->grt_domain != ''){
                    //     $product_detail = $protocol . $siteGlobal->grt_domain .'/grtshop/' . $pro_type . '/detail/'. $item->pro_id .'/'. RemoveSign($item->pro_name);
                    // }
                    $product_detail = ($af_id != '') ? $product_detail.'?af_id='.$af_id : $product_detail;
                    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $item->pro_dir .'/thumbnail_2_'. explode(',', $item->pro_image)[0];
                ?> 
                    <div class="product-item text-center">
                        <div class="product-item-info">
                            <div class="product-item-photo sBtn" id="bt_<?php echo  $item->pro_id ?>">
                                
                                <div class="like <?php if(!in_array($item->pro_id, $list_favorite)){ echo 'hidden'; } ?>" onclick="delheart(<?php echo  $item->pro_id ?>);"></div>
                               
                                <!--<a class="thumb-link" href="<?php echo $product_detail?>">-->
                                    <img src="<?php echo $filename?>" alt="<?php echo  $item->pro_name?>"/>
                                <!--</a>-->   
                                <div class="list-container">
                                    <div class="product-item-button">
                                        <a href="#" onclick="addCart(<?php echo  $item->pro_id ?>);" class="btn btn-default" title="Thêm vào giỏ hàng">
                                            <i class="fa fa-cart-plus"></i>
                                        </a>
                                        <a href="#wishlist" onclick="wishlist(<?php echo  $item->pro_id ?>);" class="btn btn-default <?php if(in_array($item->pro_id, $list_favorite)){ echo 'hidden'; } ?> addheart_<?php echo  $item->pro_id ?>" title="Thêm vào yêu thích">
                                            <i class="fa fa-heart-o"></i>
                                        </a>
                                        <a href="<?php echo  $product_detail ?>" class="btn btn-default" title="Chi tiết sản phẩm">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <input type="hidden" name="product_showcart" id="product_showcart" value="<?php echo $item->pro_id; ?>">
                                        <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
                                        <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $item->dp_id; ?>">
                                        <input type="hidden" name="qty" id="qty_<?php echo $item->pro_id; ?>" value="<?php echo  $item->pro_minsale?>">
                                        <input type="hidden" name="gr_id"
                                                   value="<?php echo $siteGlobal->grt_id; ?>">
                                        <input type="hidden" name="gr_saler" value="<?php echo $guser; ?>">
                                    </div> 
                                </div>                                      
                            </div>
                            <div class="product-item-detail">
                                <strong class="product-item-name"><a href="<?php echo  $product_detail?>"><?php echo  $item->pro_name?></a></strong>					
                                <div class="product-item-price">
                                    <span class="price">
                                        <span class="sale-price-amount">
                                            <?php echo  lkvUtil::formatPrice($discount['salePrice'],'') ?> <span class="currencySymbol">đ</span>
                                        </span>
                                        <span class="cost-price-amount">
                                            <?php echo  lkvUtil::formatPrice($item->pro_cost,'') ?> <span class="currencySymbol">đ</span>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div> 
        <?php } ?>                
    </div>
</div>
<div class="fullwidth-template" style="background:#ffffff; padding-bottom:30px;">            
    <div class="container">
    <?php
    $bannerfloor = json_decode($siteGlobal->grt_banner_floor);
    if (isset($catlevel0) && count($catlevel0) > 0) {
        foreach ($catlevel0 as $t => $value) {
            $catlist = implode(',', $cat[$value->cat_id]);
    ?>
        <div id="floor_<?php echo $t ?>" class="block-floor">
            <div class="block-title">
                <div class="row"> 
                    <div class="col-sm-3">				
                        <div class="title">				    
                            <a href="#cat" class="dropdown-toggle" onclick="show_menubox('#category_<?php echo $value->cat_id; ?>')">
                                <i class="fa fa-bars fa-fw"></i>
                            </a>
                            <a href="#grt" class="catid" attr="<?php echo $value->cat_id; ?>"><strong><?php echo $value->cat_name ?></strong></a>
                            <ul class="dropdown-menu category_" id="category_<?php echo $value->cat_id; ?>">
                                <?php 
                                foreach ($menu[$value->cat_id] as $index => $item){
                                    echo '<li class="category" style="display: inline-block;"><a href="/grtshop/product/cat/'.$item['cat_id'].'-'.RemoveSign($item['cat_name']).'">'.$item['cat_name'].'</a>';
                                    echo ' <span class="caret" onclick="show_cat(this,'.$item['cat_id'].','."'". implode(',', $cat2[$item['cat_id']])."'".');" id="i_'.$item['cat_id'].'"></span></li>';
                                }?>
                            </ul>				    
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="action">
                            <a class="tofloor" href="#floor_<?php echo $t-1 ?>"><i class="fa fa-angle-up fa-fw"></i></a>
                            <br>
                            <a class="tofloor"  href="#floor_<?php echo $t+1 ?>"><i class="fa fa-angle-down fa-fw"></i></a>
                        </div>
                        <div class="link">				    				    
                            <ul class="list-inline">					
                                <li class="active"><a href="#latest_<?php echo $value->cat_id?>"  role="tab" data-toggle="tab">Mới nhất</a></li>
                                <li><a href="#sales_<?php echo $value->cat_id?>" role="tab" data-toggle="tab" onclick="showsale($(this),<?php echo $value->cat_id?>,'<?php echo $favorite;?>')">Khuyến mãi</a></li>
                                <li><a href="#views_<?php echo $value->cat_id?>" role="tab" data-toggle="tab" onclick="showsale($(this),<?php echo $value->cat_id?>,'<?php echo $favorite;?>')">Mua nhiều</a></li>
                            </ul>
                        </div>
                    </div>
                </div>                                                        
            </div>                    
            <div class="block-content">
                <div class="row row-custom">
                    <div class="col2 col-xs-12"> 
                        <div class="banner-cat-right" style="position: relative; height: 100%;">
                            <?php if($bannerfloor[$t]->image != "") { ?>
                                <img class="img-responsive" src="<?php echo  DOMAIN_CLOUDSERVER.'media/group/banners/'.$siteGlobal->grt_dir_banner.'/'.$bannerfloor[$t]->image ?>" alt=""/>
                            <?php } else { ?>
                                <img class="img-responsive" src="https://www.certifiedfolder.com/assets/cfdsusa/wms/300x600-OceansideCVB02-i961.gif" alt=""/>
                            <?php } ?>

                            <div style="height: 170px; background: #390; text-align: center; color:#fff;padding:20px;">
                                <p><?php echo  $bannerfloor[$t]->title ?></p>
                                <p><a href="<?php echo  $bannerfloor[$t]->url ?>" class="btn btn-danger">Xem thêm</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col8 col-xs-12">                               
                        <div class="tab-content" style="padding-top:20px">
                            <div role="tabpanel fade in" class="tab-pane active" id="latest_<?php echo $value->cat_id?>">
                            <?php 
                            //SP mới nhất
                            $new_products = $this->product_model->fetch_join1($select,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 0 AND pro_category IN('.$catlist.') GROUP BY pro_id', 'pro_id', "DESC", '', 24);	
                            if (count($new_products) > 0) {
                                $this->load->view('group/product/tab_sale', array('products' => $new_products,'list_favorite' => $list_favorite, 'af_id' => $af, 'afSelect' => $afSelect, 'guser' => $guser));
                             }else{ ?>
                                <div><span>Không có sản phẩm</span></div>
                            <?php } ?>
                            </div>
                            
                            <div role="tabpanel fade" class="tab-pane" id="sales_<?php echo $value->cat_id?>"></div>
                            <input type="hidden" class="wheresaleoff_<?php echo $value->cat_id?>" value="<?php echo  $list_join.'_' .$_bl_pro. '_'.$catlist.'_'.$af ?>">
                            
                            <div role="tabpanel fade" class="tab-pane" id="views_<?php echo $value->cat_id?>"></div>
                            <input type="hidden" class="wheresalemul_<?php echo $value->cat_id?>" value="<?php echo  $list_join.'_' .$_bl_pro. '_'.$catlist.'_'.$af ?>">
                        </div>                          
                    </div>
                </div>
            </div>
        </div> 
        <?php }
        }?>
    </div>
</div>
<?php $this->load->view('group/common/footer-group'); ?>
<script>
    close_outside('.title','.category_');
</script>
    