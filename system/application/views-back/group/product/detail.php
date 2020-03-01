<?php $this->load->view('group/product/common/header'); ?>
<link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />
<!--START Center-->
<?php if (isset($siteGlobal)) { ?>
<?php
$guser = '';
if($_REQUEST['gr_saler'] && $_REQUEST['gr_saler'] != ''){
    $guser = $_REQUEST['gr_saler'];
}
?>
    <div id="main" class="container">
        <ol class="breadcrumb">
            <li><a href="/grtshop">Cửa hàng</a></li>
            <li><a href="/grtshop/<?php echo $this->uri->segment(2)?>"><?php echo $ptype; ?></a></li>
            <li><a href="/grtshop/<?php echo $this->uri->segment(2)?>/cat/<?php echo $category->cat_id; ?>-<?php echo RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a></li>
            <li class="active"><?php echo $product->pro_name ?></li>
        </ol>
        <div class="row">
            <div class="col-xs-12 col-sm-12">

                <div class="group-products" style="background: #fff;">
                    <div class="row product">
                        <div class="col-xs-12 col-sm-5">

                            <?php $listimages = explode(',', $product->pro_image); ?>
                            <?php
                            if ($product->pro_show == 0) {
                                $img = 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image); ?>
                                <div class="imagepro">
                                    <div id="carousel-ligghtgallery" class="owl-carousel owl-theme">
                                        <?php
                                        foreach ($listimages as $k => $image):
                                            $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_' . $image;
                                            ?>
                                            <div class="fix1by1 item">
                                                <?php if ($image != '') { //file_exists($imgsrc) && ?>
                                                    <a class="c image" href="<?php echo $imgsrc ?>">
                                                        <img src="<?php echo $imgsrc ?>" alt="...">
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="c image"
                                                       href="<?php echo base_url() . 'images/noimage.jpg' ?>">
                                                        <img src="<?php echo base_url() . 'images/noimage.jpg' ?>"
                                                             alt="...">
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php } ?>

                            <br/>
                            <p class="text-center">Chia sẻ sản phẩm này:</p>
                            <div class="btn-group btn-group-justified" style="margin-bottom:20px;">
                                <div class="btn-group" role="group">
                                    <a data-original-title="Share at Facebook"
                                       href="http://www.facebook.com/sharer.php?u=<?php echo $ogurl; ?>"
                                       class="btn btn-default"> <span class="fa fa-facebook"></span></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a data-original-title="Share at Tweet"
                                       href="http://twitter.com/home?status=<?php echo $ogurl; ?>"
                                       class="btn btn-default"><span class="fa fa-twitter"></span></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a data-original-title="Share at Google+"
                                       href="http://plus.google.com/share?url=<?php echo $ogurl; ?>"
                                       class="btn btn-default"> <span class="fa fa-google-plus"></span></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a data-original-title="Share at LinkedIn"
                                       href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $ogurl; ?>"
                                       class="btn btn-default"> <span class="fa fa-linkedin"></span></a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a data-original-title="Share via Email"
                                       href="mailto:?subject=<?php echo $product->pro_name; ?>&amp;body=<?php echo $ogurl; ?>"
                                       class="btn btn-default"> <span class="fa fa-envelope-o"></span></a>
                                </div>
                            </div>
                        </div>

                        <?php
                        $af_id = ($_REQUEST['af_id'] != "") ? $_REQUEST['af_id'] : '';
                        if ($af_id != '') {
                            $this->session->set_userdata('af_id', $af_id);
                        }
                        else if (($af_id == "") && ($this->session->userdata('af_id') != "")) {
                            $af_id = $this->session->userdata('af_id');
                        }

                        $afSelect = false;
                        if ($af_id != '' && $product->is_product_affiliate == 1) {
                            $this->load->model('user_model');
                            $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
                            if ($userObject->use_id > 0) {
                                $afSelect = true;
                            }
                        }
                        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                        ?>
                        <div class="col-xs-12 col-sm-7">
                            <h2 style="margin-top:0"><?php echo $product->pro_name; ?></h2>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $product->pro_buy; ?>
                                <i class="fa fa-eye"></i> <?php echo $product->pro_view; ?>
                            </div>
                            <?php if($product->pro_user != $this->session->userdata('sessionUser')){ ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                                <a href="#" style="border:none;" class="report text-center" style="width: 100px" data-id="<?php echo $product->pro_id ?>" data-toggle="modal" data-target="#reportdetailModal">
                                    <i class="fa fa-exclamation-triangle"></i> Báo cáo
                                </a>
                            </div>
                            <?php } ?>

                            <div class="product-price col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row cost-price">
                                    <div class="col-xs-4 col-sm-3 text-muted">Giá gốc</div>
                                    <div class="col-xs-8 col-sm-9 text-danger">
                                        <p>
                                            <?php if ((int)$product->pro_cost == 0) { ?>
                                                <?php echo $this->lang->line('call_main'); ?>
                                            <?php } else {
                                                $today_date = time() - 84000;
                                                if ($product->begin_date_sale < $today_date && $product->end_date_sale > $today_date) {
                                                    $promotion_status = 1;
                                                } else {
                                                    $promotion_status = 0;
                                                }
                                                ?>
                                                <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                                                    <span class="cost-price"
                                                          id="show-cost"><?php echo lkvUtil::formatPrice($product->pro_cost, 'vnđ'); ?></span>
                                                <?php } else { ?>
                                                    <strong class="sale-price"
                                                            id="show-cost"><?php echo lkvUtil::formatPrice($product->pro_cost, 'vnđ'); ?></strong>
                                                <?php } ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>

                                <?php if ($product->off_amount > 0) { ?>
                                    <div class="row cost-price">
                                        <div class="col-xs-4 col-sm-3 text-muted">Khuyến mãi:</div>
                                        <?php 
                                        if($product->off_rate > 0){ 
                                            $saleoff = $product->off_rate . '%'; 
                                        }else { 
                                            $saleoff = number_format($product->off_amount) . ' vnđ';
                                        } ?>
                                        <div class="col-xs-8 col-sm-9 text-danger">
                                            <p>
                                                <strong class="sale-price detail <?php if ($discount['af_off'] > 0) {
                                                    echo 'cost-price-line';
                                                } ?>" id="cost-save"><?php echo number_format($discount['off_sale'], 0, ",", "."); ?></strong> vnđ
                                                <span class="label label-success" style="float:right; padding: 5px ;font-size: 14px ">Tiết kiệm: 
                                                    <b><?php echo $saleoff; ?></b>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                                

                                <?php if ($discount['af_off'] > 0): ?>
                                <div class="row cost-price">
                                    <div class="col-xs-4 col-sm-3 text-muted">Giá mua qua CTV:</div>
                                    <div class="col-xs-8 col-sm-9 text-danger">
                                        <p>
                                            <span class="sale-price" id="cost-save-af"><?php echo number_format($discount['af_sale'], 0, ",", "."); ?> vnđ</span>
                                            <span class="label label-success" style="float:right; padding: 5px ;font-size: 14px ">Tiết kiệm thêm: 
                                                <?php echo ($product->af_rate > 0) ? $product->af_rate . '%' : number_format($discount['af_off'], 0, ",", ".") . ' vnđ'; ?>
                                            </span>
                                        </p> 
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ($promotions): ?>
                                    <p class="cost-price text-muted">Giảm giá sỉ:</p>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Mua từ</th>
                                            <th>Mua tới</th>
                                            <th>Được giảm</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($promotions as $promotion): ?>
                                            <tr>
                                                <?php if ($promotion['limit_type'] == 2): ?>
                                                    <?php
                                                    $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' vnđ';
                                                    if ($promotion['limit_from'] == 0) {
                                                        echo '<td>' . number_format($promotion['limit_to']) . ' vnđ </td><td> </td><td> ' . $pDiscount . '</td>';
                                                    } elseif ($promotion['limit_to'] == 0) {
                                                        echo '<td>' . number_format($promotion['limit_from']) . ' vnđ </td><td>  </td><td> ' . $pDiscount . '</td>';
                                                    } else {
                                                        echo '<td>' . number_format($promotion['limit_from']) . ' vnđ  </td><td>' . number_format($promotion['limit_to']) . ' vnđ </td><td> ' . $pDiscount . '</td>';
                                                    } ?>
                                                <?php else: ?>
                                                    <?php
                                                    $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' vnđ';
                                                    if ($promotion['limit_from'] == 0) {
                                                        echo '<td>Mua dưới ' . $promotion['limit_to'] . ' sản phẩm </td><td> </td><td>' . $pDiscount . '</td>';
                                                    } elseif ($promotion['limit_to'] == 0) {
                                                        echo '<td>Mua trên ' . $promotion['limit_from'] . ' sản phẩm  </td><td>  </td><td>' . $pDiscount . '</td>';
                                                    } else {
                                                        echo '<td>' . $promotion['limit_from'] . ' sản phẩm </td><td> ' . $promotion['limit_to'] . ' sản phẩm </td><td> ' . $pDiscount . '</td>';
                                                    } ?>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>

                                <?php if ($product->pro_made_from != 0 && $product->pro_type == 0) { ?>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-3 text-muted">Xuất xứ</div>
                                        <div class="col-xs-8 col-sm-9"><?php if ($product->pro_made_from == 1) echo "Chính hãng";
                                            if ($product->pro_made_from == 2) echo "Xách tay";
                                            if ($product->pro_made_from == 3) echo "Hàng công ty";
                                            if ($product->pro_made_from == 0) echo "Chưa cập nhật"; ?></p></div>
                                    </div>
                                <?php } ?>
                                <?php if ($product->pro_warranty_period != 0 && $product->pro_type == 0) { ?>

                                    <div class="row">
                                        <div class="col-xs-4 col-sm-3  text-muted">Bảo hành</div>
                                        <div class="col-xs-8 col-sm-9">
                                            <p>
                                                <?php
                                                if ($product->pro_warranty_period == 0) {
                                                    echo "Không bảo hành";
                                                } else {
                                                    echo $product->pro_warranty_period . " tháng";
                                                } ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($product->pro_vat != 0) { ?>
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-3  text-muted">Thuế Vat</div>
                                        <div class="col-xs-8 col-sm-9"><p><?php if ($product->pro_vat == 1) echo "Đã có VAT";
                                                if ($product->pro_vat == 2) echo "Không có VAT";
                                                if ($product->pro_vat == 0) echo "Chưa cập nhật"; ?></p></div>
                                    </div>
                                <?php }?>
                                <div class="row">
                                    <?php $a = $shop->sho_link.'.'.domain_site; if($shop->domain != ''){ $a = $shop->domain; } ?>
                                    <div class="col-xs-4 col-sm-3 text-muted">Gian hàng</div>
                                    <div class="col-xs-8 col-sm-9 text-primary"><p><a href="http://<?php echo $a ?>/shop"><?php echo $shop->sho_name ?></a></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-3 text-muted">Danh mục</div>
                                    <div class="col-xs-8 col-sm-9 text-primary">
                                        <p>
                                            <?php
                                            if ((int)$category->cat_status == 1) {
                                            if ($category->cate_type == 0) {
                                                $linkt = 'product';
                                            } elseif ($category->cate_type == 1) {
                                                $linkt = 'services';
                                            } else {
                                                $linkt = 'coupon';
                                            }
                                            $link_cat = '/grtshop/' . $linkt . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name);
                                            ?>
                                            <a class="menu_1" href="<?php echo $link_cat; ?>"
                                               alt="<?php echo $category->cat_descr; ?>" target="_blank">
                                                <?php } ?>
                                                <?php echo $category->cat_name; ?>
                                                <?php if ((int)$category->cat_status == 1) { ?>
                                            </a>
                                        <?php } ?>&nbsp;
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-3 text-muted">Ngày đăng</div>
                                    <div class="col-xs-8 col-sm-9 "><p><?php echo date('d-m-Y', $product->pro_begindate); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php
                                    if ($product->pro_video != '') { ?>
                                        <div class="col-xs-4 col-sm-3 text-muted">Video</div>
                                        <div class="col-xs-8 col-sm-9">
                                            <p>
                                                <a class="" href="#"><i class="fa fa-film fa-fw"></i>
                                                    <?php $arrayYoutubeLink = explode("?v=", $product->pro_video);
                                                    if ($arrayYoutubeLink[1] != '') { ?>
                                                        <a class="btn btn-link" data-toggle="modal"
                                                           data-target="#youtubeModal"> Xem video </a>
                                                        <div class="modal fade" id="youtubeModal" tabindex="-1"
                                                             role="dialog" aria-labelledby="youtubeModalLabel">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="video">
                                                                            <iframe
                                                                                src="https://www.youtube.com/embed/<?php echo $arrayYoutubeLink[1]; ?>"
                                                                                allowfullscreen="" frameborder="0"
                                                                                height="450" width="800"></iframe>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </a>
                                            </p>
                                        </div>
                                    <?php } ?>
                                </div>

                                
                                <?php if ($product->pro_instock <= 0): ?>
                                    <div class="order_messsage">Sản phẩm hết hàng</div>
                                <?php endif; ?>

                                <?php if ($product->pro_instock > 0) {
                                    // BEGIN:: STYLE PRODUCT
                                    if (isset($list_style)) {
                                        //co mau
                                        if (isset($ar_color) && !empty($ar_color)) {
                                            $hiddenColor = '';
                                            if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') {
                                                $hiddenSize = '';
                                                $hiddenMaterial = ' hidden';
                                            } else {
                                                $hiddenSize = ' hidden';
                                                if (isset($ar_material) && !empty($ar_material) && $ar_material[0] != '') {
                                                    $hiddenMaterial = '';
                                                } else {
                                                    $hiddenMaterial = ' hidden';
                                                }
                                            }
                                        } //k co mau
                                        else {
                                            $hiddenColor = ' hidden';
                                            if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') {
                                                $hiddenSize = '';
                                                $hiddenMaterial = ' hidden';
                                            } else {
                                                $hiddenSize = ' hidden';
                                                if (isset($ar_material) && !empty($ar_material) && $ar_material[0] != '') {
                                                    $hiddenMaterial = '';
                                                } else {
                                                    $hiddenMaterial = ' hidden';
                                                }
                                            }
                                        }
                                        $vowels = array(".", " ", ",", "/");
                                        ?>
                                        <div class="row">
                                            <?php if (isset($ar_color) && !empty($ar_color)) { ?>
                                                <div class="row col-xs-12 ar_color<?php echo $hiddenColor ?>">
                                                    <div class="col-xs-4 col-sm-3 text-muted" style="float: left"> Màu sắc: </div>
                                                    <div class="col-xs-8">
                                                        <?php
                                                        $t1 = 0;
                                                        foreach ($ar_color as $k1 => $v1) {
                                                            $t1++;
                                                            if ($k1 == 0) {
                                                                $sel_color = $v1;
                                                            }
                                                            $st_color = str_replace($vowels, "_", $v1);
                                                            ?>
                                                            <div class="pull-left" style="margin:0 5px">
                                                                <button id="mausac_<?php echo $t1; ?>"
                                                                        class="style-group "
                                                                        onclick="ClickColor('<?php echo $st_color; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></button>
                                                                <!--<span class="style-group "  onclick="SeletColorStyle('<?php echo $v1; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></span>-->
                                                                <input type="hidden"
                                                                       id="<?php echo 'st_color_' . $st_color; ?>"
                                                                       name="<?php echo 'st_color_' . $st_color; ?>"
                                                                       value="<?php echo $v1; ?>">
                                                            </div>
                                                        <?php } ?>
                                                        <span class="note" style="display: none;"> Bạn phải chọn màu sắc</span>
                                                        <input type="hidden" name="_selected_color" id="_selected_color"/>
                                                    </div>
                                                </div>
                                                <span class="hidden" id="prompt_select_color">Bạn phải chọn màu sắc.</span>
                                            <?php } ?>
                                            <div class="row ar_size<?php echo $hiddenSize ?>">
                                                <div class="col-xs-12">
                                                    <div class="dropdown">
                                                        <a id="dLabel" style="color: #777" data-target="#" href="#" data-toggle="dropdown"
                                                           role="button" aria-haspopup="true" aria-expanded="false">
                                                            <div class="col-xs-4 col-sm-3">Chọn kích thước <span class="caret"></span></div>
                                                            <span class="st_size_value"></span>
                                                            <span class="hidden qcalert" id="prompt_select_size">Bạn phải chọn kích thước.</span>
                                                        </a>
                                                        <ul class="dropdown-menu list-inline list_ar_size" style="padding: 5px;" aria-labelledby="dLabel">
                                                            <?php
                                                            $t2 = 0;
                                                            foreach ($ar_size as $k2 => $v2) {
                                                                $t2++;
                                                                if ($k2 == 0) {
                                                                    $sel_size = $v2;
                                                                }
                                                                $st_size = str_replace($vowels, "_", $v2);
                                                                ?>
                                                                <li style="cursor: pointer; padding: 5px; border: 1px solid #ccc;">
                                                                    <span id="kichthuoc_<?php echo $t2; ?>" onclick="ClickSize('<?php echo $st_size; ?>','<?php echo $t2; ?>');"><?php echo $v2; ?></span>
                                                                    <input type="hidden" id="<?php echo 'st_size_' . $st_size; ?>" name="<?php echo 'st_size_' . $st_size; ?>" value="<?php echo $v2; ?>"/>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" name="_selected_size" id="_selected_size"/>
                                                </div>
                                            </div>
                                            <p></p>
                                            <div class="row ar_material<?php echo $hiddenMaterial ?>" id="ar_material">
                                                <div class="col-xs-12">
                                                    <div class="dropdown">
                                                        <a id="dLabel" style="color: #777" data-target="#" href="#" data-toggle="dropdown"
                                                           role="button" aria-haspopup="true" aria-expanded="false">
                                                            <div class="col-xs-4 col-sm-3">Chọn chất liệu <span class="caret"></span></div>
                                                            <span class="st_material_value text-primary"></span>
                                                            <span class="hidden qcalert" id="prompt_select_material">Bạn phải chọn chất liệu.</span>
                                                        </a>
                                                        <ul class="dropdown-menu list-inline list_ar_material" style="padding: 5px;" aria-labelledby="dLabel">
                                                            <?php
                                                            $t3 = 0;
                                                            foreach ($ar_material as $k3 => $v3) {
                                                                $t3++;
                                                                if ($k3 == 0) {
                                                                    $sel_material = $v3;
                                                                }
                                                                $st_material = str_replace($vowels, "_", $v3);
                                                                ?>
                                                                <li style="cursor: pointer;">
                                                                    <span id="chatlieu_<?php echo $t3; ?>" onclick="ClickMaterial('<?php echo $st_material; ?>','<?php echo $t3; ?>');"><?php echo $v3; ?></span>
                                                                    <input type="hidden" id="<?php echo 'st_material_' . $st_material; ?>" name="<?php echo 'st_material_' . $st_material; ?>" value="<?php echo $v3; ?>">
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" name="_selected_material" id="_selected_material"/>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                    <?php } ?>
                                        <!-- END:: STYLE PRODUCT -->

                                <div class="row">
                                    <div class="col-xs-4 col-sm-3 text-muted">Số lượng</div>
                                    <div class="col-xs-8 col-sm-9">
                                        <?php $pty_min = $shop->shop_type >= 1 ? $product->pro_minsale : 1; ?>
                                        <span class="qty_group" id="mes_<?php echo $product->pro_id; ?>">
                                            <span class="minus" onclick="update_qty(<?php echo $product->pro_id; ?>, -1);"> - </span>
                                            <input class="quantity" id="qty_<?php echo $product->pro_id; ?>" name="qty"
                                                   onkeypress="return isNumberKey(event)" autofocus="autofocus"
                                                   autocomplete="off" type="text" min="1" max="9999" class="inpt-qty"
                                                   required="" value="<?php echo $pty_min; ?>" size="3"/>
                                            <span class="plus" onclick="update_qty(<?php echo $product->pro_id; ?>, 1);"> + </span>
                                        </span>
                                        <?php 
                                        $pro_favorite = $this->product_favorite_model->fetch_join('prf_id','','','','prf_product = '.(int)$product->pro_id.' AND prf_user = '.(int)$this->session->userdata('sessionUser'));
                                        if(count($pro_favorite)>0){
                                            //echo '<span class="pull-right" style="color:#f00;"><i class="fa fa-heart-o fa-fw like_db"></i> Đã thích</span>';
                                        }
                                        else{
                                        ?>
<!--                                                <button class="btn btn-link pull-right" onclick="wishlist(<?php echo $product->pro_id; ?>);">
                                            <i class="fa fa-heart-o fa-fw like_db"></i> Yêu thích
                                        </button> -->
                                        <?php } ?>

                                        <?php
                                        $list_favorite = array();
                                        foreach ($favorite as $key => $item){
                                            $list_favorite[] = $item->prf_product;
                                        } 

                                        if(in_array($product->pro_id, $list_favorite)){
                                        ?>
                                            <a href="#like" class="pull-right delheart_<?php echo $product->pro_id ?>" style="color:#f00;" onclick="delheart(<?php echo $product->pro_id ?>);" title="Bỏ thích">
                                                <i class="fa fa-heartbeat"></i> Đã thích
                                            </a>
                                            <button class="btn btn-link pull-right addheart_<?php echo $product->pro_id ?> hidden" onclick="wishlist(<?php echo $product->pro_id ?>);" title="Thêm vào yêu thích">
                                                <i class="fa fa-heart-o"></i> Yêu thích
                                            </button>
                                        <?php } else{ ?>
                                            <button class="btn btn-link pull-right addheart_<?php echo $product->pro_id ?>" onclick="wishlist(<?php echo $product->pro_id ?>);" title="Thêm vào yêu thích">
                                                <i class="fa fa-heart-o like_db"></i> Yêu thích
                                            </button>
                                            <a href="#like" class="pull-right delheart_<?php echo $product->pro_id ?> hidden" style="color:#f00;" onclick="delheart(<?php echo $product->pro_id ?>);" title="Bỏ thích">
                                                <i class="fa fa-heartbeat like_db"></i> Đã thích
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div id="bt_<?php echo $product->pro_id; ?>"
                                             class="add_to_cart_button set_in_footer cart_db">
                                            <div class="btn-group btn-group-justified" role="group">
                                                <div class="btn-group" role="group">
                                                    <button
                                                        onclick="addCartQty(<?php echo $product->pro_id; ?>);"
                                                        type="button" class="btn btn-primary btn-lg addToCart addToCart_detail">
                                                        <i class="fa fa-cart-plus fa-fw"></i>&nbsp;<span
                                                            class="">Thêm vào giỏ</span>
                                                    </button>
                                                </div>
                                                <div class="btn-group" role="group">
                                                    <button
                                                        onclick="buyNowQty(<?php echo $product->pro_id; ?>);"
                                                        type="button" class="btn btn-danger btn-lg wishlist buyNow_detail"><i
                                                            class="fa fa-check fa-fw"></i> Mua ngay
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="product_showcart" id="product_showcart"
                                                   value="<?php echo $product->pro_id; ?>"/>
                                            <input type="hidden" name="af_id" id="af_id" value="<?php echo $_REQUEST['af_id']; ?>"/>
                                            <input type="hidden" name="qty_min"
                                                   value="<?php echo $pty_min; ?>" id="qty_min"/>
                                            <input type="hidden" name="qty_max"
                                                   value="<?php echo $product->pro_instock; ?>" id="qty_max"/>
                                            <input type="hidden" name="dp_id"
                                                   value="<?php echo $product->id; ?>" id="dp_id">
                                            <input type="hidden" name="gr_id"
                                                   value="<?php echo $siteGlobal->grt_id; ?>">
                                            <input type="hidden" name="gr_saler" value="<?php echo $guser; ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php if ($product->pro_type != 0) { ?>
                                    <div class="text-warning" style="margin-top:10px;">
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <b>Sản phẩm này được bán dưới hình thức E-coupon. <a target="_blank" href="<?php echo getAliasDomain() . 'content/398'; ?>">Click để tìm hiểu thêm.</a></b></div>
                                <?php } ?>
                            <?php } else { ?>
                                    <div id="bt_<?php echo $product->pro_id; ?>" class="add_to_cart_button">
                                        <button title="Hết hàng" id="buynow-login" class="btn btn-danger sm"
                                                type="button"> Hết hàng
                                        </button>
                                        <button onclick="wishlist(<?php echo $product->pro_id; ?>);" type="button"
                                                class="btn btn-link  wishlist"><i class="fa fa-heart fa-fw"></i>&nbsp;Yêu thích
                                        </button>
                                        <input type="hidden" name="product_showcart" id="product_showcart" value="<?php echo $product->pro_id; ?>"/>
                                        <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <?php
                                $group_id = (int)$this->session->userdata('sessionGroup');
                                if ($group_id == AffiliateUser) {
                                    if ($product->is_product_affiliate == 1) {
                                        if ($product->af_amt > 0) {
                                            $pro_affiliate_value = number_format($product->af_amt, 0, ',', '.') . ' vnđ';
                                            $pro_type_affiliate = 2;
                                        } else {
                                            $pro_affiliate_value = $product->aff_rate . ' %';
                                            $pro_type_affiliate = 1;
                                        }
                                    } else {
                                        $pro_affiliate_value = '0 VNĐ';
                                    }
                                    ?>
                                    <?php if ($product->is_product_affiliate == 1) { ?>
                                        <div class="col-xs-12 col-sm-8" style="text-transform: uppercase;font-size: small;padding: 5px; font-weight: bold;">Hoa hồng Cộng tác viên được hưởng khi bán sản phẩm này:</div>
                                        <div class="col-xs-6 col-sm-2" style="text-align: center; padding: 5px; color: #f00;"><p><?php echo $pro_affiliate_value; ?></p></div>
                                        <div class="col-xs-6 col-sm-2" style="text-align: center;">
                                        <?php if ($selected_sale != true) { ?>
                                            <button class="btn btn-default"
                                                    onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $product->pro_id; ?>);">
                                                <i class="fa fa-check fa-fw"></i> Chọn bán
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-default"><i class="fa fa-check fa-fw"></i> Đã chọn bán
                                            </button>
                                        <?php } ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">                            
                        <div class="product-detail">
                            <h4 class="title_"><span>Thông tin chi tiết</span></h4>
                            <?php echo html_entity_decode($product->pro_detail); ?>
                        </div>
                    </div>	
                    <?php if(count($categoryProduct)>0){ ?>
                    <div class="col-xs-12 col-sm-12">
                        <div class="product-in-category">
                            <h4 class="title_"><span>Cùng danh mục</span></h4>
                            <hr/>
                            <div class="row products">	
                                <!--<div class="product-owl-carousel-2 owl-carousel">-->	
                                <?php 
                                    $this->load->view('group/product/tab_pro', array('products' => $categoryProduct));					    
                                 ?>
                                <!--</div>-->
                            </div>
                        <div class="row text-center">
                             <div class="linkPage"><?php echo $linkPage; ?></div>              
                        </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Begin:: Modal thông báo dịch vụ -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true"
     style="top:50%; margin-top: -40px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- End:: Modal thông báo dịch vụ -->

<?php $this->load->view('group/common/footer-group'); ?>
<!--END Center-->
<script src="/templates/home/lightgallery/dist/js/lightgallery.js"></script>
<script src="/templates/home/js/owl.carousel.js"></script>
<script async src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
        $('.share').click(function () {
            var NWin = window.open($(this).prop('href'), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
            if (window.focus) {
                NWin.focus();
            }
            return false;
        });
    });
</script>
<style>
.style-group.actived {
    border: none;
}
.list_ar_material, .list_ar_size {
    padding: 5px;
}
.list_ar_material li, .list_ar_size li {
    padding: 5px;
    border: 1px solid #ccc;
    margin: 2px 4px;
}
</style>
<script language="javascript">
    jQuery(function ($) {
        $('#carousel-ligghtgallery').lightGallery({selector: '.image', download: false});
        $('.owl-carousel').owlCarousel({
            loop: false, margin: 0, nav: false, items: 1
        })
    });

    function SubmitVote() {
        document.frmVote.submit();
    }

    function ChangeStyle(div, action) {
        switch (action) {
            case 1:
                document.getElementById(div).style.border = "1px #2F97FF solid";
                break;
            case 2:
                document.getElementById(div).style.border = "1px #CCC solid";
                break;
            default:
                document.getElementById(div).style.border = "1px #2F97FF solid";
        }
    }


    function TrimInput(e) {
        if (e != "") {
            while (e.substring(0, 1) == " ") {
                e = e.substring(1, e.length)
            }
            while (e.substring(e.length - 1, e.length) == " ") {
                e = e.substring(0, e.length - 1)
            }
            return e
        }
    }

    function CheckBlank(e) {
        if (TrimInput(e) == "" || e == "") {
            return true
        } else {
            return false
        }
    }

    function CheckInput_Reply(e) {
        if (e == "1") {
            if (CheckBlank(document.getElementById("title_reply").value)) {
                alert("Bạn chưa nhập tiêu đề!");
                document.getElementById("title_reply").focus();
                return false
            }
            if (CheckBlank(document.getElementById("content_reply").value)) {
                alert("Bạn chưa nhập nội dung!");
                document.getElementById("content_reply").focus();
                return false
            }
            if (CheckBlank($('.inputcaptcha_form').val())) {
                alert("Bạn chưa nhập mã xác nhận!");
                $('.inputcaptcha_form').focus();
                return false;
            }
            document.frmReplyProGroup.submit();
        } else {
            return false;
        }
    }

    function update_qty(pro_id, num) {
        var qty = parseInt($('input#qty_' + pro_id).val(), 10);
        var meg = '';
        var qty_min = parseInt($('#bt_' + pro_id + ' input[name="qty_min"]').val(), 10);
        var qty_max = parseInt($('#bt_' + pro_id + ' input[name="qty_max"]').val(), 10);
        var qty_new = qty + num;
        if (qty_new <= qty_min) {
            qty_new = qty_min;
            meg = 'Bạn phải mua tối thiểu ' + qty_min + ' sản phẩm';
        }
        if (qty_new >= qty_max) {
            qty_new = qty_max;
            meg = 'Xin lỗi, chúng tôi chỉ có ' + qty_max + ' sẩn phẩm trong kho';
        }
        $('input#qty_' + pro_id).val(qty_new);
        if ($('#mes_' + pro_id + ' + .qty_message').length == 0) {
            $('#mes_' + pro_id).after('<span class="qty_message"></span>');
        }
        if (meg != '') {
            $('#mes_' + pro_id + ' + .qty_message').text(meg).show();
        } else {
            $('#mes_' + pro_id + ' + .qty_message').hide();
        }
    }

    //Quy cach

    var n1 = <?php echo $t1 ? $t1 : 0; ?>;
    var n2 = <?php echo $t2 ? $t2 : 0; ?>;
    var n3 = <?php echo $t3 ? $t3 : 0; ?>;
    var pro_id = $('#product_showcart').val();
    var sl_color = '<?php echo $sel_color ? $sel_color : ""; ?>';
    var sl_size = '<?php echo $sel_size ? $sel_size : ""; ?>';
    var sl_material = '<?php echo $sel_material ? $sel_material : ""; ?>';

    $(document).ready(function () {
        if ($('.ar_size').attr('class') == 'row ar_size hidden' && $('.ar_material').attr('class') == 'row ar_material hidden') {
            $('.addToCart_detail').attr('disabled', 'disabled');
            $('.addToCart_detail').css('cursor', 'auto');
            $('.addToCart_detail').attr('title', 'Bạn phải chọn màu sắc');
            $('.buyNow_detail').attr('disabled', 'disabled');
            $('.buyNow_detail').css('cursor', 'auto');
            $('.buyNow_detail').attr('title', 'Bạn phải chọn màu sắc');
            $('.note').css('display', 'block');
        }
        else {
            $('#mausac_1').click();
            $('#kichthuoc_1').addClass('actived');
            $('#chatlieu_1').addClass('actived');
        }
        $('#_selected_color').val($('#mausac_1').text());
    });

    function SelectProSales(siteUrl, id) {
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "home/affiliate/ajax_select_pro_sales",
            dataType: 'json',
            data: {proid: id},
            success: function (data) {
                console.log(data);
                if (data == '1') {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }

    function ClickColor(name, no, e) {
        var a = $('#st_color_' + name).val();
        if (a) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo getAliasDomain(); ?>" + "home/product/select_style_pro_1?id=" + pro_id + "&color=" + a,
                data: {id: pro_id, color: a, size: sl_size, material: sl_material},
                success: function (result) {
                    for (var i = 1; i <= n1; i++) {
                        if (i != no) {
                            $('#mausac_' + i).removeClass('actived');
                        } else {
                            $('#mausac_' + i).addClass('actived');
                        }
                    }
                    var text = $('#chatlieu_1').text();
                    if (text != '') {
                        $("#ar_material").addClass('hidden');
                    }
                    $('.pull-left').each(function () {
                    });
                    if (result.error == false) {
                        $(".qty_message").text('');
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        $("#_selected_size").val("");
                        $("#_selected_material").val("");
                        sl_color = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            //$("#bt_" + pro_id).addClass('hidden');
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save);
                            $("#cost-save-af").text(money_save_af + ' vnđ');
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $("span.st_size_value").text("");
                            $("span.st_material_value").text("");
                            $('#_selected_color').val($('#mausac_' + no).text());
                            $(".qty_row").removeClass('hidden');
                            $("#bt_" + pro_id).removeClass('hidden');
                            $("#carousel-ligghtgallery .owl-item.active .item img").attr("src", function () {
                                return "<?php echo getAliasDomain() . 'media/images/product/'; ?>" + result.pro_dir + "/" + result.pro_images;
                            });
                            $("#dp_id").val(result.pro_id);
                        }
                        if (result.ar_size == '' && result.ar_material == '') {
                            $('.addToCart_detail').removeAttr('disabled');
                            $('.addToCart_detail').css('cursor', 'pointer');
                            $('.addToCart_detail').removeAttr('title');
                            $('.buyNow_detail').removeAttr('disabled');
                            $('.buyNow_detail').css('cursor', 'pointer');
                            $('.buyNow_detail').removeAttr('title');
                            $('.note').css('display', 'none');
                            var str = result.pro_images;
                            var arr_img = str.split(',');
                            var str_price = result.pro_prices;
                            var str_offamount = result.offamount_arr;
                            var str_offaff = result.offaff_arr;

                            var str_max = result.pro_max;
                            var str_id = result.pro_id;
                            var arr_id = str_id.split(',');
                            var arr_max = str_max.split(',');
                            if (arr_id.length > 1) {
                                $("#dp_id").val(arr_id[0]);
                                $("#qty_max").val(arr_max[0]);
                            }
                            getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);

                        } else {
                            var data = {pro_id: pro_id, color: a};
                            if (result.ar_size != '') {
                                load_size(data);
                            } else {
                                $('#_selected_size').val('');
                                load_chatlieu(data);
                            }
                        }
                    } else {
                        alert('error: true');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra.');
                }
            });
        }
    }

    function load_size(datajs){
        $.ajax({
            url:  '<?php echo getAliasDomain(); ?>home/product/load_size',
            type: "POST",
            data: datajs,
            dataType: "json",
            beforeSend: function () {
                $(this).disabled = true;
            },
            success: function (response) {
                $('.list_ar_size').disabled = false;
                var text = $('#kichthuoc_1').text();
                if(response != null && response.li != null){
                    $('.list_ar_size').html(response.li);
                    var text = $('#kichthuoc_1').text();
                    if (response.li != '') {
                        $(".ar_size").removeClass('hidden');
                    }
                    $('.st_size_value').text('');
                }
                hideLoading();
            },
            error: function () {
                alert('Khong load duoc mau sac');
            }
        });
    }
    
    function ClickSize(name, no) {
        var b = $('#st_size_' + name).val();
        if (b) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo getAliasDomain(); ?>" + "home/product/product_style_azibai",
                data: {id: pro_id, color: sl_color, size: b, material: sl_material},
                success: function (result) {
                    for (var i = 1; i <= n2; i++) {
                        if (i != no) {
                            $('#kichthuoc_' + i).removeClass('actived');
                        } else {
                            $('#kichthuoc_' + i).addClass('actived');
                        }
                    }
                    if (result.error == false) {
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        $(".qty_message").text('');
                        sl_size = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            $("#bt_" + pro_id).addClass('hidden');
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var text = $('#chatlieu_1').text();
                            if (text == '') {
                                var money = parseInt(result.pro_prices);
                                var money_save = money - parseInt(result.off_amount);
                                var money_save_af = money_save - parseInt(result.af_off);
                                money = money.toLocaleString();
                                money_save = money_save.toLocaleString();
                                money_save_af = money_save_af.toLocaleString();
                                $("#show-cost").text(money + ' vnđ');
                                $("#cost-save").text(money_save);
                                $("#cost-save-af").text(money_save_af + ' vnđ');
                            }

                            if (text != '') {
                                $("#ar_material").removeClass('hidden');
                            }

                            $("span.st_material_value").text("");
                            $("#_selected_material").val("");
                            $("#prompt_select_size").addClass('hidden');
                            $('#_selected_size').val($('#kichthuoc_' + no).text());
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            var active_cl = false;
                            $("#bt_" + pro_id).removeClass('hidden');
                            for (var i = 1; i <= n3; i++) {
                                if ($('#chatlieu_' + i).attr('class') == 'active') {
                                    active_cl = true;
                                }
                            }
                            //$("#dp_id").val(result.pro_id);

                            if (text == '') {

                                var str = result.pro_images;
                                var arr_img = str.split(',');
                                var str_price = result.pro_prices;
                                var str_offamount = result.offamount_arr;
                                var str_offaff = result.offaff_arr;

                                var str_max = result.pro_max;
                                var str_id = result.pro_id;
                                var arr_id = str_id.split(',');
                                var arr_max = str_max.split(',');
                                if (arr_id.length > 1) {
                                    $("#dp_id").val(arr_id[0]);
                                    $("#qty_max").val(arr_max[0]);
                                }
                                getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);
                            }
                        }
                    }
                },
                error: function () {
                }
            });
        }
        $('.st_size_value').html(b);
        var data = {pro_id: pro_id, color: $('#st_color_'+sl_color).val(), size: b};
        load_chatlieu(data);
    }
    
    function load_chatlieu(datajs){
        $.ajax({
            url:  '<?php echo getAliasDomain(); ?>home/product/load_chatlieu',
            type: "POST",
            data: datajs,
            dataType: "json",
            beforeSend: function () {
                $(this).disabled = true;
            },
            success: function (response) {
                console.log(response);
                $('.list_ar_material').disabled = false;
                var text = $('#chatlieu_1').text();
                if(response != null && response.li != null){
                    $('.list_ar_material').html(response.li);
                    var text = $('#chatlieu_1').text();
                    if (response.li != '') {
                        $("#ar_material").removeClass('hidden');
                    }
                    $('.st_material_value').text('');
                }
                hideLoading();
            },
            error: function () {
                alert('Khong load duoc chat lieu');
            }
        });
    }
    
    function ClickMaterial(name, no) {
        var b = $('#_selected_size').val();
        var c = $('#st_material_' + name).val();
        var size = '';
        var url = '';
        if (b == '') {
            size = '';
        } else {
            size = "&size=" + b;
        }
        if (c) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo getAliasDomain(); ?>" + "home/product/product_style_azibai",
                data: {id: pro_id, color: sl_color, size: sl_size, material: c},
                success: function (result) {
                    for (var i = 1; i <= n3; i++) {
                        if (i != no) {
                            $('#chatlieu_' + i).removeClass('actived');
                        } else {
                            $('#chatlieu_' + i).addClass('actived');
                        }
                    }
                    if (result.error == false) {
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        $(".qty_message").text('');
                        sl_material = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            $("#bt_" + pro_id).addClass('hidden');
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save);
                            $("#cost-save-af").text(money_save_af + ' vnđ');
                            $("#prompt_select_material").addClass('hidden');
                            $('#_selected_material').val($('#chatlieu_' + no).text());
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_" + pro_id).removeClass('hidden');

                            $("#dp_id").val(result.pro_id);
                            var str = result.pro_images;
                            var arr_img = str.split(',');
                            var str_price = result.pro_prices;
                            var str_offamount = result.offamount_arr;
                            var str_offaff = result.offaff_arr;

                            var str_max = result.pro_max;
                            var str_id = result.pro_id;
                            var arr_id = str_id.split(',');
                            var arr_max = str_max.split(',');
                            if (arr_id.length > 1) {
                                $("#dp_id").val(arr_id[0]);
                                $("#qty_max").val(arr_max[0]);
                            }
                            getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);
                        }
                    }
                },
                error: function () {
                }
            });
        }

        $('.st_material_value').html(c);
    }

    function getdata(str, pro_dir, arr_img, str_price, str_max, str_id, str_off_amount, str_af_off) {
        $('.imagepro').load("<?php echo getAliasDomain(); ?>" + "home/product/slide_img?arr_img=" + str + '&dir_img=' + pro_dir, function (response, status, xhr) {
            if (status != 'error') {
                var el = $('.owl-stage .owl-item'), elW = 0;
                el.each(function () {
                    elW += $(this).width();
                });
                $('.owl-stage').css('width', elW);
                $('#carousel-ligghtgallery').lightGallery({
                    selector: '.image',
                    download: false
                });
                $('.owl-carousel').owlCarousel({
                    loop: false, margin: 0, nav: false, items: 1
                });
                if (arr_img.length > 1) {
                    set_price(str_price, str_max, str_id, str_off_amount, str_af_off);
                }
                else {
                    var price_tp = parseInt(str_price).toLocaleString();
                    $("#show-cost").text(price_tp + ' vnđ');
                    $("#qty_max").val(str_max);
                    $("#dp_id").val(str_id);
                }
            } else {
                alert('error');
            }
        });
    }

    function set_price(str_price, str_max, str_id, str_off_amount, str_af_off) {
        var arr_price = str_price.split(',');
        var arr_affamount = str_off_amount.split(',');
        var arr_afoff = str_af_off.split(',');

        var arr_max = str_max.split(',');
        var id = str_id.split(',');
        if (arr_price.length > 1) {
            $('.owl-carousel').on('changed.owl.carousel', function (event) {
                var index = event.item.index;
                if (index == null) {
                    $("#show-cost").text(arr_price + ' vnđ');
                } else {
                    var money = parseInt(arr_price[index]);
                    var money_save = money - parseInt(arr_affamount[index]);
                    var money_save_af = money_save - parseInt(arr_afoff[index]);
                    money = money.toLocaleString();
                    money_save = money_save.toLocaleString();
                    money_save_af = money_save_af.toLocaleString();
                    $("#show-cost").text(money + ' vnđ');
                    $("#cost-save").text(money_save);
                    $("#cost-save-af").text(money_save_af + ' vnđ');
                    $("#qty_max").val(arr_max[index]);
                    $("#dp_id").val(id[index]);
                }
            });
        }
    }

    function tooltipPicture(e, t) {
        jQuery(e).tooltip({
            delay: 100,
            bodyHandler: function () {
                width = 350;
                height = 350;
                if (typeof jQuery(this).attr("tooltipWidth") != "undefined") {
                    width = parseInt(jQuery(this).attr("tooltipWidth"))
                }
                if (typeof jQuery(this).attr("tooltipHeight") != "undefined") {
                    height = parseInt(jQuery(this).attr("tooltipHeight"))
                }
                jQuery("#tooltip").css("width", width + "px");
                picturePath = jQuery("#image-" + t).val();
                strReturn = "";
                strReturn += '<div class="name">' + jQuery("#name-" + t).val() + "</div>";
                strReturn += '<div class="margin">Giá:<b class="price">' + jQuery("#price-" + t).text() + "</b>    (Lượt xem: " + jQuery("#view-" + t).val() + ")</div>";
                strReturn += '<div class="margin">Tại gian hàng:<b><span class="company">' + jQuery("#shop-" + t).val() + "</b></div>";
                strReturn += '<div class="margin">Vị trí:<b>' + jQuery("#pos-" + t).val() + "</b></div>";
                strReturn += '<div class="margin">Bình chọn:<b>' + jQuery("#danhgia-" + t).html() + "</b></div>";
                strReturn += '<div class="picture_only">' + resizeImageSrc(picturePath, jQuery(this).width(), jQuery(this).height(), width, height) + "</div>";
                return strReturn
            },
            track: true,
            showURL: false,
            extraClass: "tooltip_product"
        })
    }
</script>

<!-- GUI BAO CAO SAN PHAM -->

<?php if($this->session->userdata('sessionUser') > 0) { ?>
<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="frmReport" name="frmReport" action="/home/grouptrade/report" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="sho_name" id="" value="<?php echo $shop->sho_name ?>">
            <input type="hidden" name="sho_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/shop/'; ?>">
            <input type="hidden" name="pro_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/shop/'. $linkt .'/detail/'. $product->pro_id .'/'. RemoveSign($product->pro_name); ?>">
            <input type="hidden" name="pro_name" id="" value="<?php echo $product->pro_name ?>">
            <input id="reportpost" name="pro_id" type="hidden" value="<?php echo $product->pro_id ?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
            </div>
            <div class="modal-body">
                <?php foreach ($listreports as $key => $value) { ?>
                        <div class="radio">
                          <label>
                                <input type="radio" name="rp_id" id="optionsReport" value="<?php echo $value->rp_id ?>" <?php echo $key == 0 ? 'checked': '' ?> >
                                <?php echo $value->rp_desc ?>
                          </label>
                        </div>			
                <?php } ?>
                <textarea type="text" name="rpd_reason" id="rpd_reason" placeholder="Nhập nội dung báo cáo" class="" style="display: none; resize: none; width: 100%; padding: 5px;"/></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" name="sendReport" class="btn btn-primary">Gửi báo cáo</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {
    $('input[name=rp_id]').each(function(){
        $(this).change(function () {
            if ($(this).val() == '11' && $(this).is(':checked')) {
                $('#rpd_reason').fadeIn(400);
                $('#rpd_reason').attr('required','required');
            }else{
                $('#rpd_reason').fadeOut(0);
                $('#rpd_reason').removeAttr('required');
            }
        });
    });
});

    
$('.report').click(function(){			
    $('#reportpost').attr('value', $(this).data('id'));
});
var frm = $('#frmReport');
frm.submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
            var mes = '';
            $('#reportdetailModal').modal('hide');
            if (data == '0') {
                mes = 'Bạn đã gửi báo cáo cho sản phẩm này rồi. Cám ơn bạn!';
            } else if (data == '1') {
                mes = 'Gửi báo cáo sản phẩm thành công. Cảm ơn bạn!';
            }
            $.jAlert({
                'title': 'Thông báo',
                'content': mes,
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        location.reload();
                        return false;
                    }
                }
            });	
        },
        error: function (data) {					
            $('#reportdetailModal').modal('show');				
        }
    });
});
</script> 
<?php } else { ?>
<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-warning" role="alert">
                    Bạn chưa đăng nhập, vui lòng <a href="/login">đăng nhập</a> vào để sử dụng tính năng này!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>			
        </div>		
    </div>
  </div>
</div>
<?php } ?>
<!-- GUI BAO CAO SAN PHAM -->
