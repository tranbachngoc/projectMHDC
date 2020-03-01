<!-- content style_3 -->
<?php 
$shop_af = $this->user_model->get('*', 'use_id = ' . (int)$siteGlobal->sho_user . ' AND use_status = 1');
$select = '*';
$where = '';
$start = 0;
$limit = 8;
$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

if ($shop_af->use_group == AffiliateUser) {
    $stopslide = '';    
    $affiliate_products = $this->product_model->getAFProductsByCat((int)$siteGlobal->sho_user, (int)$shop_af->parent_id);
    $where .= 'pro_user = '. $shopId .' AND is_product_affiliate = 1 AND pro_status = 1';    
    $af_products_parent = $this->product_model->fetch('tbtt_product.*'. DISCOUNT_QUERY, $where, 'pro_id', "DESC", $start, $limit);

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

    $azibai_products = $this->product_model->getAzibaiProduct($select . DISCOUNT_QUERY, ','. (int)$siteGlobal->sho_user .',');
} else {
    $stopslide = 'data-interval="false"';
    $this->db->order_by("pro_order", "asc");
    $new_products = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 0 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
    $new_service = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 1 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
    $new_coupon = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 2 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
    $this->db->order_by("pro_order", "asc");
    $sale_products = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 0 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
    $sale_service = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
    $sale_coupon = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 2 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
}
$shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);
?>

<hr/>
<?php if ($new_products) { ?>
    <div class="products new_products">
        <h3>
	    <span class="modtitle">Sản phẩm mới nhất </span>
	    <a class="btn btn-default btn-left" href="#new_products" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
		<span class="sr-only">Prev</span>
	    </a>
	    <a class="btn btn-default  btn-right" href="#new_products" role="button" data-slide="next">
		<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	    </a>
	</h3>
        <div id="new_products" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $new_products)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($new_service && serviceConfig == 1) { ?>
    <div class="products new_service">
        <h3>
    	    <span class="modtitle"><i class="fa fa-cubes"></i> Dịch vụ mới nhất </span>
    	    <a class="btn btn-default btn-left pull-left" href="#new_service" role="button" data-slide="prev">
    		<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
    		<span class="sr-only">Prev</span>
    	    </a>
    	    <a class="btn btn-default  btn-right pull-right" href="#new_service" role="button" data-slide="next">
    		<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
    		<span class="sr-only">Next</span>
    	    </a>
    	</h3>
        <div id="new_service" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $new_service)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($new_coupon) { ?>
    <div class="products new_coupon">
        <h3><span class="modtitle">Coupon mới nhất</span>
    	    <a class="btn btn-default btn-left" href="#new_coupon" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
    	    </a>
    	    <a class="btn btn-default  btn-right" href="#new_coupon" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
    	    </a>
    	</h3>
        <div id="new_coupon" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $new_coupon)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($featured_products) { ?>
    <div class="products featured_products">
        <h3>
    	    <span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm nổi bật	</span>
    	    <a class="btn btn-default btn-left" href="#featured_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
    	    <a class="btn btn-default btn-right" href="#featured_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</h3>
        <div id="featured_products" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $featured_products)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($sale_products) { ?>
    <div class="products sale_products">
		<h3>
			<span class="modtitle">Sản phẩm khuyến mãi</span>
			<a class="btn btn-default btn-left" href="#sale_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#sale_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</h3>
        <div id="sale_products" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $sale_products)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($sale_service && serviceConfig == 1) { ?>
    <div class="products sale_service">
        <h3><span class="modtitle"><i class="fa fa-cubes"></i> Dịch vụ khuyến mãi</span>
            
			<a class="btn btn-default btn-left" href="#sale_service" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                <span class="sr-only">Prev</span>
            </a>
			<a class="btn btn-default btn-right" href="#sale_service" role="button" data-slide="next">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
		
        </h3>
        <div id="sale_service" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $sale_service)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<?php if ($sale_coupon) { ?>
    <div class="products sale_coupon">
        <h3><span class="modtitle"><i class="fa fa-cubes"></i> Coupon khuyến mãi</span>
            
			<a class="btn btn-default btn-left" href="#sale_coupon" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                <span class="sr-only">Prev</span>
            </a>
			<a class="btn btn-default btn-right" href="#sale_coupon" role="button" data-slide="next">
                <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
		
        </h3>
        <div id="sale_coupon" class="carousel slide" data-ride="carousel" <?php echo $stopslide; ?>>
            <div class="carousel-inner" role="listbox">
                <?php $this->load->view('shop/common/product_item', array('products' => $sale_coupon)); ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>

<!-- BEGIN:: SP CUA AFFILIATE -->
<?php if ($shop_af->use_group == AffiliateUser) { ?>
    <?php if ($af_products_parent) { ?>
        <div class="row text-center">
            <?php $this->load->view('shop/advertise/468x60af'); ?>
        </div>
        <h3><span class="modtitle"><i class="fa fa-cubes"></i><a href="#"> Sản phẩm từ gian hàng</a></span></h3>
        <div class="products affiliate_products">
            <div>
                <?php 
                $link = $URLRoot .'afproduct';
                $this->load->view('shop/common/af_parent_item', array('products' => $af_products_parent, 'afLink' => '?af_id='. $shop_af->af_key));
                ?>
            </div>
        </div>
        <hr/>
    <?php } ?>
<?php } ?>
<!-- END:: SP CUA AFFILIATE -->

<?php if ($shop_af->use_group == AffiliateUser) { ?>
    <div class="row">
        <div class="col-lg-9 text-center">
            <?php $this->load->view('shop/advertise/728x90af'); ?>
        </div>
        <div class="col-lg-3 text-center">
            <?php $this->load->view('shop/advertise/220x90af'); ?>
        </div>
    </div>
    <?php
    //la danh sach san pham,chưa xử lí câu truy vấn ,tạm thời gán tạm bởi biến $azibai_products
    $where = array();
    $where['tbtt_package_daily_content.content_type'] = 'product';
    $where['tbtt_package_daily_content.begin_date'] = date('Y-m-d');
    $where['tbtt_package_daily_content.p_type'] = '08';
    $where['tbtt_package_daily_user.package_id'] = '11';
    $where['tbtt_product.pro_status'] = '1';
    $start = 0;
    $limit = 16;
    $list_sp_moi_nhat = $this->product_model->fetchPickupProduct($select . DISCOUNT_QUERY, $where, 'pro_id', "DESC", $start, $limit);
    $where['tbtt_package_daily_user.package_id'] = '12';
    $list_sp_khuyen_mai = $this->product_model->fetchPickupProduct($select . DISCOUNT_QUERY, $where, 'pro_id', "DESC", $start, $limit);
    $where['tbtt_package_daily_user.package_id'] = '12';
    $list_sp_muanhieu = $this->product_model->fetchPickupProduct($select . DISCOUNT_QUERY, $where, 'pro_id', "DESC", $start, $limit);
    $new_affiliate_products = $this->product_model->fetchAF('tbtt_product.*, tbtt_product_affiliate_user.homepage' . DISCOUNT_QUERY, array('pro_status' => 1, 'pro_type' => 0, 'tbtt_product_affiliate_user.use_id' => (int)$siteGlobal->sho_user, 'tbtt_product_affiliate_user.homepage' => 1), "date_added", "DESC", $start, $limit);
    $new_affiliate_coupons = $this->product_model->fetchAF('tbtt_product.*, tbtt_product_affiliate_user.homepage' . DISCOUNT_QUERY, array('pro_status' => 1, 'pro_type' => 2, 'tbtt_product_affiliate_user.use_id' => (int)$siteGlobal->sho_user, 'tbtt_product_affiliate_user.homepage' => 1), "date_added", "DESC", $start, $limit);
    ?>
    <?php if (count($new_affiliate_products) > 0) { ?>
        <div class="products affiliate_products">
            <h3><span class="modtitle"><i class="fa fa-cubes"></i>Sản phẩm mới nhất</h3>
            <div>
                <?php $this->load->view('shop/common/af_parent_item', array('products' => $new_affiliate_products, 'afLink' => '?af_id=' . $shop_af->af_key)); ?>
            </div>
        </div>
    <?php } ?>

    <?php if (count($new_affiliate_coupons) > 0) { ?>
        <div class="products affiliate_products">
            <h3><span class="modtitle"><i class="fa fa-cubes"></i>Coupon mới nhất</h3>
            <div>
                <?php $this->load->view('shop/common/af_parent_item', array('products' => $new_affiliate_coupons, 'afLink' => '?af_id=' . $shop_af->af_key)); ?>
            </div>
        </div>
    <?php } ?>

    <!-- san pham moi nhat,khuyen mai,mua nhieu-->
    <div id="exTab2" class="container" style="padding-left: 0px; display:none;">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#moinhat" data-toggle="tab">SẢN PHẨM MỚI NHẤT</a></li>
            <li><a href="#khuyenmai" data-toggle="tab">KHUYẾN MÃI</a></li>
            <li><a href="#muanhieu" data-toggle="tab">MUA NHIỀU</a></li>
        </ul>
        <div class="tab-content ">
            <div class="tab-pane active" id="moinhat">
                <?php if (count($new_affiliate_products) > 0) { ?>
                    <!-- san pham moi nhat-->
                    <div class="row products">
                        <?php foreach ($new_affiliate_products as $k => $product) { ?>
                            <?php $this->load->view('shop/common/item_pro_tab', array('product' => $product)); ?>
                        <?php } ?>
                    </div>
                    <!-- end san pham moi nhat-->
                <?php } else { ?>
                    <p class="text-center">Không có sản phẩm</p>
                <?php } ?>
            </div>
            <div class="tab-pane " id="khuyenmai">
                <?php if (count($list_sp_khuyen_mai) > 0) { ?>
                    <!-- khuyen mai-->
                    <div class="row products">
                        <?php foreach ($list_sp_khuyen_mai as $k => $product) { ?>
                            <?php $this->load->view('shop/common/item_pro_tab', array('product' => $product)); ?>
                        <?php } ?>
                    </div>
                    <!-- end-->
                <?php } else { ?>
                    <p class="text-center">Không có sản phẩm</p>
                <?php } ?>
            </div>

            <div class="tab-pane" id="muanhieu">
                <?php if (count($list_sp_muanhieu) > 0) { ?>
                    <!-- mua nhieu-->
                    <div class="row products">
                        <?php foreach ($list_sp_muanhieu as $k => $product) { ?>
                            <?php $this->load->view('shop/common/item_pro_tab', array('product' => $product)); ?>
                        <?php } ?>
                    </div>
                    <!-- end-->
                <?php } else { ?>
                    <p class="text-center">Không có sản phẩm</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- end san pham moi nhat,khuyen mai,mua nhieu-->
<?php } ?>