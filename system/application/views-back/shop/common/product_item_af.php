<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/8/2016
 * Time: 13:23 PM
 */
//print_r($products);
$boxId = 'AdminAf_';

if (!empty($products)):?>
<div class="row" style="height: 30px; line-height: 30px">
    <div class="col-lg-6">
        <h3><i class="fa fa-link"></i> Sản phẩm Khuyến mãi</h3>
    </div>
	<div class="col-lg-6 text-right">
      <h3><a class="btn btn-primary" href="<?php echo $link;?>">Xem tất cả</a></h3>
	</div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <!-- Nav tabs -->
            <ul id="item-page-pro" class="nav nav-tabs pull-right" role="tablist">
                <li role="presentation" class="active"><a href="#page1" aria-controls="home" role="tab" data-toggle="tab">1</a></li>
                <?php if(count($products) > 4){ ?><li role="presentation"><a href="#page2" aria-controls="profile" role="tab" data-toggle="tab">2</a></li> <?php } ?>
            </ul>
        <div class="clearfix"></div>
            <!-- Tab panes -->
            <div class="row tab-content">
                <div role="tabpanel" class="tab-pane active" id="page1">
                    <?php for($i=0; $i<=3; $i++){
                        if( $products[$i]->pro_id <= 0 ) continue; ?>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="<?php echo $boxId.$k;?>">
                            <div class="product-item text-center">
                                <h4>
                                    <a  class="tooltips" target="_blank" href="<?php echo $mainURL; ?><?php echo $products[$i]->pro_category; ?>/<?php echo $products[$i]->pro_id; ?>/<?php echo RemoveSign($products[$i]->pro_name)?>" title="<?php echo $products[$i]->pro_name; ?>">
                                        <input type="hidden" id="name-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pro_name;?>"/>
                                        <input type="hidden" id="view-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pro_view;?>"/>
                                        <input type="hidden" id="shop-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->sho_name;?>"/>
                                        <input type="hidden" id="pos-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pre_name;?>"/>
                                        <input type="hidden" id="date-<?php echo $products[$i]->pro_id;?>" value="<?php echo date('d/m/Y',$products[$i]->sho_begindate);?>"/>
                                        <input type="hidden" id="image-<?php echo $products[$i]->pro_id;?>" value="<?php echo $mainURL ?>media/images/product/<?php echo $products[$i]->pro_dir; ?>/<?php echo show_image($products[$i]->pro_image); ?>"/>
                                        <div style="display:none" id="danhgia-<?php echo $products[$i]->pro_id;?>">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                            <b>[0]</b></div>
                                        <img alt="<?php echo $products[$i]->pro_name;?>" src="<?php echo $mainURL ?>media/images/product/<?php echo $products[$i]->pro_dir; ?>/<?php echo show_thumbnail($products[$i]->pro_dir, $products[$i]->pro_image,3); ?>" onmouseover="tooltipPicture(this,'<?php echo $products[$i]->pro_id;?>')" id="<?php echo $products[$i]->pro_id;?>"  class="img-responsive"/>
                                        <div class="name_showbox_1"><span id="DivName_DivInterestBox_0"><?php echo $products[$i]->pro_name;?></span></div>
                                    </a>
                                </h4>
                                <div class="price"><span class="sale-price" id="DivCost_DivInterestBox_0"><?php echo number_format($products[$i]->pro_cost,0,'.',',');?></span>&nbsp;VND</div>
                                <div class="button-group"><button class="btn btn-default  addtocart" type="button" title="Thêm vào giỏ" onclick="#"><i class="fa fa-cart-plus"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  wishlist" type="button" title="Yêu thích" onclick="#"><i class="fa fa-heart-o"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  compare" type="button" title="So sánh" onclick="#"><i class="fa fa-exchange"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  quickview" type="button" title="Xem nhanh" onclick="#"><i class="fa fa-eye"></i>&nbsp;</button></div>
                            </div>
                        </div>

                    <?php } ?>
                </div>

                <div role="tabpanel" class="tab-pane" id="page2">
                    <?php for($i=4; $i < count($products); $i++){
                        if( $products[$i]->pro_id <= 0 ) continue; ?>
                            <div class="col-lg-3 col-md-3 col-sm-4" id="<?php echo $boxId.$k;?>">
                                <div class="product-item text-center">
                                    <h4>
                                        <a  class="tooltips" target="_blank" href="<?php echo $mainURL; ?><?php echo $products[$i]->pro_category; ?>/<?php echo $products[$i]->pro_id; ?>/<?php echo RemoveSign($products[$i]->pro_name)?>" title="<?php echo $products[$i]->pro_name; ?>">
                                            <input type="hidden" id="name-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pro_name;?>"/>
                                            <input type="hidden" id="view-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pro_view;?>"/>
                                            <input type="hidden" id="shop-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->sho_name;?>"/>
                                            <input type="hidden" id="pos-<?php echo $products[$i]->pro_id;?>" value="<?php echo $products[$i]->pre_name;?>"/>
                                            <input type="hidden" id="date-<?php echo $products[$i]->pro_id;?>" value="<?php echo date('d/m/Y',$products[$i]->sho_begindate);?>"/>
                                            <input type="hidden" id="image-<?php echo $products[$i]->pro_id;?>" value="<?php echo $mainURL ?>media/images/product/<?php echo $products[$i]->pro_dir; ?>/<?php echo show_image($products[$i]->pro_image); ?>"/>
                                            <div style="display:none" id="danhgia-<?php echo $products[$i]->pro_id;?>">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <img src="http://azibaiproject.kom/templates/home/images/star0.gif" border="0" alt="">
                                                <b>[0]</b></div>
                                            <img alt="<?php echo $products[$i]->pro_name;?>" src="<?php echo $mainURL ?>media/images/product/<?php echo $products[$i]->pro_dir; ?>/<?php echo show_thumbnail($products[$i]->pro_dir, $products[$i]->pro_image,3); ?>" onmouseover="tooltipPicture(this,'<?php echo $products[$i]->pro_id;?>')" id="<?php echo $products[$i]->pro_id;?>"  class="img-responsive"/>
                                            <div class="name_showbox_1"><span id="DivName_DivInterestBox_0"><?php echo $products[$i]->pro_name;?></span></div>
                                        </a>
                                    </h4>
                                    <div class="price"><span class="sale-price" id="DivCost_DivInterestBox_0"><?php echo number_format($products[$i]->pro_cost,0,'.',',');?></span>&nbsp;VND</div>
                                    <div class="button-group"><button class="btn btn-default  addtocart" type="button" title="Thêm vào giỏ" onclick="#"><i class="fa fa-cart-plus"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  wishlist" type="button" title="Yêu thích" onclick="#"><i class="fa fa-heart-o"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  compare" type="button" title="So sánh" onclick="#"><i class="fa fa-exchange"></i>&nbsp;</button>&nbsp;<button class="btn btn-default  quickview" type="button" title="Xem nhanh" onclick="#"><i class="fa fa-eye"></i>&nbsp;</button></div>
                                </div>
                            </div>
                    <?php } ?>
                </div>
        </div>
        </div>
    </div>
<?php endif; ?>