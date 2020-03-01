<!-- content style_default -->
<?php
$urlRoot = $URLRoot;
$select = '*';
$where = '';
$start = 0;
$limit = 8;
$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
$shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
if ($shop_af->use_group == 2) {
    $stopslide = '';
    $where .= '(pro_user = '. $shopId .' OR pro_id IN ("'. $li_pro_id .'")) AND is_product_affiliate = 1 AND pro_status = 1';
} else {
    $stopslide = 'data-interval="false"';
    $where .= 'pro_user = '. $shopId .' AND pro_status = 1';
}

//SP mới nhất
//$new_products = $this->product_model->fetch($select . DISCOUNT_QUERY, $where.' AND pro_type = 0', 'pro_id', "DESC", $start, $limit);
$new_products = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 0 GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	

//DV mới nhất
//$new_service = $this->product_model->fetch($select . DISCOUNT_QUERY, $where." AND pro_type = 1 ", 'pro_id', "DESC", $start, $limit);
$new_service = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 1 GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
//CP mới nhất
//$new_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, $where." AND pro_type = 2 ", 'pro_id', "DESC", $start, $limit);

$new_coupon = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 2 GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
$this->db->order_by("pro_order","asc");
// Khuyen mai
//$sale_products = $this->product_model->fetch($select . DISCOUNT_QUERY, $where. " AND pro_saleoff = 1 AND pro_type = 0", 'pro_id', "DESC", $start, $limit);
//$sale_service = $this->product_model->fetch($select . DISCOUNT_QUERY, $where. " AND pro_saleoff = 1 AND pro_type = 1", 'pro_id', "DESC", $start, $limit);
//$sale_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, $where. " AND pro_saleoff = 1 AND pro_type = 2", 'pro_id', "DESC", $start, $limit);

$sale_products = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 0 AND pro_saleoff = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
$sale_service = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 1 AND pro_saleoff = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
$sale_coupon = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 2 AND pro_saleoff = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	

$azibai_products = array();
$affiliate_products = array();
if ($shop_af->use_group == 2) {
    $azibai_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "is_product_affiliate = 1 AND is_asigned_by_admin = 1 AND id_shop_cat = {$siteGlobal->sho_category} AND  pro_status = 1 ", "rand()", "DESC", $start, $limit);
    $affiliate_products = $this->product_model->fetchAF('tbtt_product.*' . DISCOUNT_QUERY, array('pro_status' => 1, 'tbtt_product_affiliate_user.use_id' => (int)$siteGlobal->sho_user), "rand()", "DESC", $start, $limit);
    $shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);

    // Get product by category
    $cat_products = $this->product_model->getProductsByCat((int)$siteGlobal->sho_user);
    $probyCat = array();
    if (!empty($cat_products)) {
        foreach ($cat_products as $item) {
            if (!isset($probyCat[$item->cat])) {
                $probyCat[$item->cat] = array();
            }
            array_push($probyCat[$item->cat], $item);
        }
    }
    $cats = array_keys($probyCat);
    if (!empty($cats)) {
        $cats = $this->product_model->getCategoryInfo($cats);
    }
}
?>

<?php if ($cat_products) { ?>
    <div class="products affiliate_products">
        <?php
        $mycount = 0;
        foreach ($cats as $cat){ ?>
            <h3><span class="modtitle"><i class="fa fa-cubes"></i>
                <a href="<?php echo '/afproduct/cat/'.$cat['cat_id'].'-'.RemoveSign($cat['cat_name']) ; ?>"><?php echo $cat['cat_name']; ?></a></span>
            </h3>
            <div>
            <?php $link = $urlRoot . 'afproduct';
                $this->load->view('shop/common/item', array('products' => $probyCat[$cat['cat_id']]));
            ?>
            </div>
        <?php } ?>
    </div>
    <hr/>
<?php } ?>

<?php if ($new_products) { ?>
    <div class = "products new_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Sản phẩm mới nhất </span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $new_products)); ?>
    </div>
<?php } ?>

<?php if ($new_service  && serviceConfig == 1) { ?>
    <div class = "products new_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Dịch vụ mới nhất </span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $new_service)); ?>
    </div>
<?php } ?>

<?php if ($new_coupon) { ?>
    <div class = "products new_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Coupon mới nhất </span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $new_coupon)); ?>
    </div>
<?php } ?>

<?php if ($featured_products) { ?>
    <div class = "products featured_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Sản phẩm nổi bật	</span>
        </h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $featured_products)); ?>
    </div>
<?php } ?>

<?php if ($sale_products) { ?>
    <div class = "products sale_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Sản phẩm khuyến mãi</span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $sale_products)); ?>
    </div>
<?php } ?>

<?php if ($sale_service  && serviceConfig == 1) { ?>
    <div class = "products sale_services">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Dịch vụ khuyến mãi</span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $sale_service)); ?>
    </div>
<?php } ?>

<?php if ($sale_coupon) { ?>
    <div class = "products sale_coupons">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Coupon khuyến mãi</span></h3>
        <?php $this->load->view('shop/common/product_item', array('products' => $sale_coupon)); ?>
    </div>
<?php } ?>

<?php if ($affiliate_products) { ?>
    <div class = "products affiliate_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Sản phẩm khuyến mãi liên kết</span></h3>
        <?php
        $link = $urlRoot . 'afproduct';
        $this->load->view('shop/common/item', array('products' => $affiliate_products, 'link' => $link, 'afLink' => $shopAfLink));
        ?>
    </div>
<?php } ?>

<?php if ($azibai_products) { ?>
    <div class = "products azibai_products">
        <h3><span class = "modtitle"><i class = "fa fa-cubes"></i> Sản phẩm từ azibai</span></h3>
        <?php $this->load->view('shop/common/item', array('products' => $azibai_products)); ?>
    </div>
    <hr/>
<?php } ?>
