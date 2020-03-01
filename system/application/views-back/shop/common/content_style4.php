<!-- content style_4 -->
<?php
$shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
$select = '*';
$start = 0;
$limit = 8;
$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
if ($shop_af->use_group == 2) {
    $stopslide = '';
    $affiliate_products = $this->product_model->getAFProductsByCat((int)$siteGlobal->sho_user);
    $afbyCat = array();
    if (!empty($affiliate_products)) {
        foreach ($affiliate_products as $item) {
            if (!isset($afbyCat[$item->cat])) {
                $afbyCat[$item->cat] = array();
            }
            array_push($afbyCat[$item->cat], $item);
        }
    }
    $cats = array_keys($afbyCat);
    if (!empty($cats)) {
        $cats = $this->product_model->getCategoryInfo($cats);
    }

} else {
    $stopslide = 'data-interval="false"';
    $this->db->order_by("pro_order","asc");
    $new_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 0 ", "pro_id", "DESC", $start, $limit);
    $new_service = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 1 ", "pro_id", "DESC", $start, $limit);
    $new_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 2 ", "pro_id", "DESC", $start, $limit);
    $this->db->order_by("pro_order","asc");
    $sale_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1  AND pro_saleoff = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 ))", "pro_id", "DESC", $start, $limit);
    if(isset($af_id) && !empty($af_id)){
        $af = "?af_id=".$af_id;
    }else{
        $af = "";
    }
}

$shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);
$boxId = 'AdminAf_';
?>

<?php if (!empty($featured_products)): ?>
    <div class="module featured_products">
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Sản phẩm nổi bật</span></h3>
        <div class="row">
            <?php foreach ($featured_products as $k => $product) {
                // Added
                // by le van son
                // Calculation discount amount
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                if ($shop_af->use_group == 2) {
                    $id_gr = 8;
                } else {
                    $id_gr = 4;
                }

                //$link = '/'. $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                $link = '/shop/product/detail/'. $product->pro_id . '/' . RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link;
                ?>
                <div class="col-sm-4 <?php echo $k >= 4 ? '' : ''; ?>" >
                    <div class="thumbnail">
                        <?php
                        $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_'. explode(',', $product->pro_image)[0];
                        ?>
                        <a href="<?php echo  $link; ?>">

                            <?php if ($product->pro_image != '') { //file_exists($filename)?>
                                <img
                                    src="<?php echo $filename; ?>"
                                    onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                    id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                    alt="<?php echo($product->pro_name); ?>"/>
                            <?php } else { ?>
                                <img width="100%" src="/media/images/noimage.png"
                                     alt="Not Image">
                            <?php } ?>
                        </a>
                    </div>

                    <h4 class="pro_name"><a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 30); ?></a></h4>
                    <?php if (false): ?>
                        <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="/templates/home/images/star1.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="/templates/home/images/star0.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <b>[<?php echo $product->pro_vote; ?>]</b>
                        </div>
                    <?php endif; ?>
                    <?php if ($discount['saleOff'] > 0): ?>
                        <div class="saleoff">
                            <img
                                src="/templates/shop/default/images/saleoff.png"/>
                        </div>
                    <?php endif; ?>
                    <div class="price">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($discount['salePrice']) . ' ' . $product->pro_currency; ?></span>
                            Giá gốc: <span
                                class="cost-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                        <?php } else { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                        <?php } ?>
                    </div>
                    <p class="pro_descr">
                        <?php echo $product->pro_descr ?>
                    </p>
                    <div>
                        <a class="btn btn-primary" href="<?php echo $link; ?>">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($new_products)): ?>
    <div class="module new_products">
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Sản phẩm mới</span></h3>
        <div class="row">
            <?php foreach ($new_products as $k => $product) {
                // Added
                // by le van son
                // Calculation discount amount
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                if ($shop_af->use_group == 2) {
                    $id_gr = 8;
                } else {
                    $id_gr = 4;
                }
                $link = '/shop/product/detail/'. $product->pro_id . '/' . RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link;
                $shop_info = $this->shop_model->get('sho_link','sho_user = '.$product->pro_user);
                ?>
            <div class="col-sm-4 col-xs-6" style="margin:10px 0">
                    <div class="pro-item">
                    <div class="thumbox">
                            <?php
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_'. explode(',', $product->pro_image)[0];
                            ?>
                        <a href="<?php echo $link; ?>">
                            <?php if ($product->pro_image != '') { //file_exists($filename)?>
                                <img src="<?php echo $filename; ?>"
                                    onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                    id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                    alt="<?php echo($product->pro_name); ?>"/>
                            <?php } else { ?>
                                <img width="100%" src="/media/images/noimage.png" alt="Not Image" />
                            <?php } ?>
                        </a>
                    </div>

                    <h4 class="pro_name"><a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 30); ?></a></h4>
                    <?php if (false): ?>
                        <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="/templates/home/images/star1.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="/templates/home/images/star0.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <b>[<?php echo $product->pro_vote; ?>]</b>
                        </div>
                    <?php endif; ?>
                    <?php if ($discount['saleOff'] > 0): ?>
                        <div class="saleoff">
                            <img
                                src="/templates/shop/default/images/saleoff.png"/>
                        </div>
                    <?php endif; ?>
                    <div class="price">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($discount['salePrice']) . ' ' . $product->pro_currency; ?></span>
                            Giá gốc: <span
                                class="cost-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                        <?php } else { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                        <?php } ?>
                    </div>
                    <p class="pro_descr">
                        <?php echo $product->pro_descr ?>
                    </p>
                    <div>
                        <a class="read_more" href="<?php echo $link; ?>">
                            &rarr; Xem chi tiết
                        </a>
                    </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($new_service)  && serviceConfig == 1): ?>
    <div class="module new_products">
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Dịch vụ mới</span></h3>
        <div class="row">
            <?php foreach ($new_service as $k => $product) {
                // Added
                // by le van son
                // Calculation discount amount
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                if ($shop_af->use_group == 2) {
                    $id_gr = 8;
                } else {
                    $id_gr = 4;
                }
                $link = '/shop/services/detail/'. $product->pro_id . '/' . RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link;

                $shop_info = $this->shop_model->get('sho_link','sho_user = '.$product->pro_user);
                ?>
                <div class="col-sm-4 col-xs-6" >
                    <div class="pro-item">
                        <div class="thumbox">
                            <?php
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_'. explode(',', $product->pro_image)[0];
                            ?>
                            <a href="<?php echo $link; ?>">

                                <?php if ($product->pro_image != '') { //file_exists($filename) ?>
                                    <img
                                        src="<?php echo $filename; ?>"
                                        onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                        id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                        alt="<?php echo($product->pro_name); ?>"/>
                                <?php } else { ?>
                                    <img width="100%" src="/media/images/noimage.png"
                                         alt="Not Image">
                                <?php } ?>
                            </a>
                        </div>

                        <h4 class="pro_name"><a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 30); ?></a></h4>
                        <?php if (false): ?>
                            <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                                <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                    <img src="</templates/home/images/star1.gif" border="0"
                                         alt=""/>
                                <?php } ?>
                                <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                    <img src="/templates/home/images/star0.gif" border="0"
                                         alt=""/>
                                <?php } ?>
                                <b>[<?php echo $product->pro_vote; ?>]</b>
                            </div>
                        <?php endif; ?>
                        <?php if ($discount['saleOff'] > 0): ?>
                            <div class="saleoff">
                                <img
                                    src="/templates/shop/default/images/saleoff.png"/>
                            </div>
                        <?php endif; ?>
                        <div class="price">
                            <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                                Giá bán: <span
                                    class="sale-price"><?php echo number_format($discount['salePrice']) . ' ' . $product->pro_currency; ?></span>
                                Giá gốc: <span
                                    class="cost-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                            <?php } else { ?>
                                Giá bán: <span
                                    class="sale-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                            <?php } ?>
                        </div>
                        <p class="pro_descr">
                            <?php echo $product->pro_descr ?>
                        </p>
                        <div>
                            <a class="read_more" href="<?php echo $link; ?>">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($new_coupon)): ?>
    <div class="module new_products">
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Coupon mới</span></h3>
        <div class="row">
            <?php foreach ($new_coupon as $k => $product) {
                // Added
                // by le van son
                // Calculation discount amount
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                if ($shop_af->use_group == 2) {
                    $id_gr = 8;
                } else {
                    $id_gr = 4;
                }

                $link = '/shop/coupon/detail/'. $product->pro_id . '/' . RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link;
                $shop_info = $this->shop_model->get('sho_link','sho_user = '.$product->pro_user);
                ?>
                <div class="col-sm-4 col-xs-6" >
                    <div class="pro-item">
                        <div class="thumbox">
                            <?php
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_'. explode(',', $product->pro_image)[0];
                            ?>
                            <a href="<?php echo $link; ?>">

                                <?php if ($product->pro_image != '') { //file_exists($filename)?>
                                    <img
                                        src="<?php echo $filename; ?>"
                                        onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                        id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                        alt="<?php echo($product->pro_name); ?>"/>
                                <?php } else { ?>
                                    <img width="100%" src="/media/images/noimage.png"
                                         alt="Not Image">
                                <?php } ?>
                            </a>
                        </div>

                        <h4 class="pro_name"><a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 30); ?></a></h4>
                        <?php if (false): ?>
                            <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                                <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                    <img src="/templates/home/images/star1.gif" border="0"
                                         alt=""/>
                                <?php } ?>
                                <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                    <img src="/templates/home/images/star0.gif" border="0"
                                         alt=""/>
                                <?php } ?>
                                <b>[<?php echo $product->pro_vote; ?>]</b>
                            </div>
                        <?php endif; ?>
                        <?php if ($discount['saleOff'] > 0): ?>
                            <div class="saleoff">
                                <img
                                    src="/templates/shop/default/images/saleoff.png"/>
                            </div>
                        <?php endif; ?>
                        <div class="price">
                            <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                                Giá bán: <span
                                    class="sale-price"><?php echo number_format($discount['salePrice']) . ' ' . $product->pro_currency; ?></span>
                                Giá gốc: <span
                                    class="cost-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                            <?php } else { ?>
                                Giá bán: <span
                                    class="sale-price"><?php echo number_format($product->pro_cost) . ' ' . $product->pro_currency; ?></span>
                            <?php } ?>
                        </div>
                        <p class="pro_descr">
                            <?php echo $product->pro_descr ?>
                        </p>
                        <div>
                            <a class="read_more" href="<?php echo $link; ?>">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
<?php endif; ?>