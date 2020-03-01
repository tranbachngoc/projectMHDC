<!-- content style_2 -->
<?php
$shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
$select = '*';
$start = 0;
$limit = 9;
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
    $new_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 0 ", pro_id, "DESC", $start, $limit);
    $new_service = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 1 ", pro_id, "DESC", $start, $limit);
    $new_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 2 ", pro_id, "DESC", $start, $limit);

    $featured_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 0 ", pro_view, "DESC", $start, $limit);
    $featured_service = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 1 ", pro_view, "DESC", $start, $limit);
    $featured_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1 AND pro_type = 2 ", pro_view, "DESC", $start, $limit);

    $sale_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1  AND pro_saleoff = 1 AND pro_type = 0 ", pro_id, "DESC", $start, $limit);
    $sale_service = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1  AND pro_saleoff = 1 AND pro_type = 1 ", pro_id, "DESC", $start, $limit);
    $sale_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, "pro_user = " . (int)$siteGlobal->sho_user . " AND pro_status = 1  AND pro_saleoff = 1 AND pro_type = 2 ", pro_id, "DESC", $start, $limit);

    $azibai_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "is_product_affiliate = 1 AND is_asigned_by_admin = 1 AND id_shop_cat = {$siteGlobal->sho_category} AND pro_status = 1 ", "rand()", "DESC", $start, $limit);

    $affiliate_products = $this->product_model->fetchAF('tbtt_product.*' . DISCOUNT_QUERY, array('pro_status' => 1, 'tbtt_product_affiliate_user.use_id' => (int)$siteGlobal->sho_user), "rand()", "DESC", $start, 16);

    if(isset($af_id) && !empty($af_id)){
        $af = "?af_id=".$af_id;
    }else{
        $af = "";
    }
}

$shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);

?>

<div class="module featured_products">
    <?php
    $boxId = 'AdminAf_';
    $shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user); ?>
    <?php if (count($featured_products) > 0): ?>
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Sản phẩm nổi bật</span></h3>
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
                
                $link = '/shop/product/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name); 
                $link = (isset($af) && $af != "") ? $link.$af : $link;
            ?>               
                
                <div class="col-sm-4 col-xs-12 text-center">
                    <?php
                    $filename = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0);
                    ?>
                    <div class="thumbox">
                    <a href="<?php echo $link; ?>">                       
                        <?php if (file_exists($filename)) { ?>
                            <img src="<?php echo 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0); ?>"
                                    onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                    id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                    alt="<?php echo($product->pro_name); ?>"/>
                        <?php } else { ?>
                            <img src="/media/images/noimage.png" alt="Không có hình ảnh" />
                        <?php } ?>
                       
                    </a>
                    </div>
                    <h4 class="pro_name" title="<?php echo $product->pro_name; ?>">
                        <a href="<?php echo $link ?>"><?php echo sub($product->pro_name, 30); ?></a>
                    </h4>
                    <p class="pro_descr">
                        <?php echo $product->pro_descr; ?>
                    </p>

                    <?php if (false): ?>
                        <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star1.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star0.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <b>[<?php echo $product->pro_vote; ?>]</b>
                        </div>
                    <?php endif; ?>
                    <?php if ($discount['saleOff'] > 0): ?>
                        <div class="saleoff">
                            <img
                                src="<?php echo $URLRoot; ?>templates/shop/default/images/saleoff.png"/>
                        </div>
                    <?php endif; ?>
                    <p class="price">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($discount['salePrice']) ; ?></span> <?php echo $product->pro_currency; ?>
                            Giá gốc: <span
                                class="cost-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } else { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } ?>
                    </p>
                   
                    <div style="margin-bottom: 30px;">
                        <a class="btn btn-primary"
                           href="<?php echo $link; ?>">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            <?php } ?>
        </div>
    <?php endif; ?>

    <?php if (count($featured_products) > 0 && serviceConfig == 1): ?>
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Dịch vụ nổi bật</span></h3>
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

                $link = '/shop/services/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link; 
            ?>                
                
                <div class="col-sm-4 col-xs-12 text-center">
                    <?php
                    $filename = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0);
                    ?>
                    <div class="thumbox">
                        <a href="<?php echo $link ?>">                       
                            <?php if (file_exists($filename)) { ?>
                                <img
                                    src="<?php echo  'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0); ?>"
                                    onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                    id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                    alt="<?php echo($product->pro_name); ?>"/>
                            <?php } else { ?>
                                <img src="/media/images/noimage.png"
                                     alt="Không có hình ảnh">
                            <?php } ?>                       
                        </a>
                    </div>
                    <h4 class="pro_name" title="<?php echo $product->pro_name ?>">
                        <a href="<?php echo $link ?>"><?php echo sub($product->pro_name, 30); ?></a>
                    </h4>
                    <p class="pro_descr">
                        <?php echo $product->pro_descr ?>
                    </p>

                    <?php if (false): ?>
                        <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star1.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star0.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <b>[<?php echo $product->pro_vote; ?>]</b>
                        </div>
                    <?php endif; ?>
                    <?php if ($discount['saleOff'] > 0): ?>
                        <div class="saleoff">
                            <img
                                src="<?php echo $URLRoot; ?>templates/shop/default/images/saleoff.png"/>
                        </div>
                    <?php endif; ?>
                    <p class="price">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($discount['salePrice']) ; ?></span> <?php echo $product->pro_currency; ?>
                            Giá gốc: <span
                                class="cost-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } else { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } ?>
                    </p>
                    <!--p>
                        <span class="up_date">Cập nhật: <?php echo $product->up_date ?></span> &nbsp;
                        <span class="up_date">Lượt xem: <?php echo $product->pro_view ?></span> &nbsp;
                        <span class="up_date">Lượt mua: <?php echo $product->pro_buy ?></span> &nbsp;
                    </p-->
                    <div style="margin-bottom: 30px;">
                        <a class="btn btn-primary"
                           href="<?php echo $link; ?>">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            <?php } ?>
        </div>
    <?php endif; ?>

    <?php if (count($new_coupon) > 0): ?>
        <h3 class="text-center"><span><i class="fa fa-cubes fa-fw"></i> Coupon nổi bật</span></h3>
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
                $link = '/shop/coupon/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                $link = (isset($af) && $af != "") ? $link.$af : $link;

                ?>               
                
                <div class="col-sm-4 col-xs-12 text-center">
                    <?php
                    $filename = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0);
                    ?>
                    <div class="thumbox">
                        <a href="<?php echo $link ?>">                       
                            <?php if (file_exists($filename)) { ?>
                                <img
                                    src="<?php echo  'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image, 0); ?>"
                                    onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')"
                                    id="<?php echo $product->pro_id; ?>" class="image_boxpro"
                                    alt="<?php echo($product->pro_name); ?>"/>
                            <?php } else { ?>
                                <img src="/media/images/noimage.png"
                                     alt="Không có hình ảnh">
                            <?php } ?>
                        </a>
                    </div>
                    
                    <h4 class="pro_name" title="<?php echo $product->pro_name ?>">
                        <a href="<?php echo $link ?>"><?php echo sub($product->pro_name, 30); ?></a>
                    </h4>
                    <p class="pro_descr">
                        <?php echo $product->pro_descr ?>
                    </p>

                    <?php if (false): ?>
                        <div style="display:none;" id="danhgia-<?php echo $product->pro_id; ?>">
                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star1.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                <img src="<?php echo $URLRoot; ?>templates/home/images/star0.gif" border="0"
                                     alt=""/>
                            <?php } ?>
                            <b>[<?php echo $product->pro_vote; ?>]</b>
                        </div>
                    <?php endif; ?>
                    <?php if ($discount['saleOff'] > 0): ?>
                        <div class="saleoff">
                            <img
                                src="<?php echo $URLRoot; ?>templates/shop/default/images/saleoff.png"/>
                        </div>
                    <?php endif; ?>
                    <p class="price">
                        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($discount['salePrice']) ; ?></span> <?php echo $product->pro_currency; ?>
                            Giá gốc: <span
                                class="cost-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } else { ?>
                            Giá bán: <span
                                class="sale-price"><?php echo number_format($product->pro_cost); ?></span> <?php echo $product->pro_currency; ?>
                        <?php } ?>
                    </p>
                    <div style="margin-bottom: 30px;">
                        <a class="btn btn-primary"
                           href="<?php echo $link; ?>">
                            Xem chi tiết
                        </a>
                    </div>

                </div>
            <?php } ?>
        </div>
    <?php endif; ?>
</div>