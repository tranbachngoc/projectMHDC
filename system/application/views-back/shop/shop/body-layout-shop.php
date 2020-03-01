<main>
  <section class="main-content">
    <div class="container">

      <?php $this->load->view('shop/shop/common/shop_banner');?>

      <div class="sidebarsm">
          <div class="gioithieu">
            <?php // $this->load->view('shop/shop/common/sidebar_menu');?>
            <?php $this->load->view('shop/news/elements/menu_left_items') ?>
        </div>
      </div>
      <div class="list-title-bst">
        <?php if(!empty($collection_product)) { ?>
          <p class="show-cc-sp active">
            <a href="javascript:void(0)">bộ sưu tập sản phẩm</a>
          </p>
        <?php } ?>
        <?php if(!empty($collection_coupon)) { ?>
        <p class="show-cc-cp <?=!empty($collection_product) ? '' : 'active'?>">
          <a href="javascript:void(0)">bộ sưu tập coupon</a>
        </p>
        <?php } ?>
      </div>
    </div>

    <!-- danh sach collection product -->
    <?php $this->load->view('shop/shop/element/slider_collection_product');?>
    <!-- end -->
    <!-- danh sach collection coupon -->
    <?php $this->load->view('shop/shop/element/slider_collection_coupon');?>
    <!-- end -->

    <!-- danh sach san pham sale -->
    <?php if(count($product_sale) > 0 || count($coupon_sale) > 0) $this->load->view('shop/shop/element/shop_item_flashsale');?>
    <!-- end -->

    <!-- danh sach san pham sale -->
    <?php //$this->load->view('shop/shop/element/shop_category');?>
    <!-- end -->

    <!-- danh sach san pham new -->
    <?php if(count($product_new) > 0 || count($coupon_new) > 0) $this->load->view('shop/shop/element/shop_item_new');?>
    <!-- end -->

  </section>
</main>