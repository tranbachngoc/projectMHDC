<?php
$protocol = get_server_protocol();
?>

<div class="sidebarsm">
  <div class="gioithieu">
    <?php $this->load->view('shop/news/elements/menu_left_items') ?>
  </div>
</div>
<div class="bosuutap-header-tabs">
  <ul class="bosuutap-header-tabs-content">
    <!-- <li><a href="<?=$shop_url . 'shop/collection/all'?>">TẤT CẢ</a></li> -->
    <li <?=($sl_tab == 'content' ? 'class="active"' : '') ?>><a href="<?=$shop_url . 'shop/collection'?>">BST Tin</a></li>
    <li <?=($sl_tab == 'product' ? 'class="active"' : '') ?>><a href="<?=$shop_url . 'shop/collection-product'?>">BST sản phẩm</a></li>
    <li <?=($sl_tab == 'coupon' ? 'class="active"' : '') ?>><a href="<?=$shop_url . 'shop/collection-coupon'?>">BST coupon</a></li>
    <li <?=($sl_tab == 'link' ? 'class="active"' : '') ?> ><a href="<?=$shop_url . 'shop/collection-link'?>">BST liên kết</a></li>
  </ul>
</div>

<script src="/templates/home/styles/js/shop/shop-common.js"></script>