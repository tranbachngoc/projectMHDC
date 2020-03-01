<div class="sanazibai-header">
  <div class="container">
    <ul class="sanazibai-header-item">
      <li <?=$this->uri->segment(2) == 'products' ? 'class="is-active"' : ''?>>
        <a class="sanazibai-header-item-link" href="<?=azibai_url('/shop/products'.($af_id != '' ? "?af_id=$af_id" : ""))?>">
          <img class="icon" src="/templates/home/styles/images/svg/dssp.svg" alt="">
          <p class="tit">Sản phẩm</p>
        </a>
      </li>
      <!-- <li <?=$this->uri->segment(2) == 'coupons' ? 'class="is-active"' : ''?>>
        <a class="sanazibai-header-item-link" href="<?=azibai_url('/shop/coupons'.($af_id != '' ? "?af_id=$af_id" : ""))?>">
          <img class="icon" src="/templates/home/styles/images/svg/pmh.svg" alt="">
          <p class="tit">Phiếu mua
            <span class="md">&nbsp;hàng</span>
          </p>
        </a>
      </li> -->
      <li>
        <a class="sanazibai-header-item-link" href="javascript:void(0)">
          <img class="icon" src="/templates/home/styles/images/svg/spdx.svg" alt="">
          <p class="tit md">
            <span>Sản phẩm bạn đã xem</span>
          </p>
          <p class="tit sm">
            <span>Đã xem</span>
          </p>
          <!-- <img class="down" src="/templates/home/styles/images/svg/down_1.svg" alt=""> -->
        </a>
      </li>
      <li>
        <a class="sanazibai-header-item-link" href="javascript:void(0)">
          <img class="icon" src="/templates/home/styles/images/svg/kpch.svg" alt="">
          <p class="tit">
            <span>Khám phá
              <span class="md">cửa hàng</span>
            </span>
          </p>
          <!-- <img class="down" src="/templates/home/styles/images/svg/down_1.svg" alt=""> -->
        </a>
      </li>
    </ul>
  </div>

</div>
<div class="danh-sach-danh-muc">
  <div class="container">
    <div class="js-danh-sach-danh-muc danh-sach-danh-muc-content">
      <?php
      $category = array_chunk($category,2); 
      foreach ($category as $key => $item) { ?>
      <div class="item">
        <?php foreach ($item as $k => $v) {
          $href = '/'.$v->cat_id.'/'. RemoveSign($v->cat_name) . ($af_id != '' ? "?af_id=$af_id" : "");?>
        <a href="<?=azibai_url($href)?>" class="box-link">
          <span class="img">
            <img src="<?=DOMAIN_CLOUDSERVER.'media/images/categories/'.$v->cat_image?>" alt="">
          </span>
          <p class="text two-lines"><?=$v->cat_name?></p>
        </a>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>

<div class="shop-product">
  <div class="container">
    <div class="banner-shop">
      <div class="js-banner-shop">
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-1.jpg" alt="">
        </div>
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-2.jpg" alt="">
        </div>
      </div>
    </div>
    <div class="shop-tit">
      <h3>SẢN PHẨM Khuyến mãi</h3>
    </div>
    <div class="shop-product-items">
      <?php if(!empty($items_sale)){
        foreach ($items_sale as $key => $item) {
          $this->load->view('e-azibai/common/common-html-item', ['item'=>$item,'has_af_key'=>$has_af_key]);
        }
      }?>
    </div>
    <div class="icon-add bg-white">
      <span>
        <img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
      </span>
    </div>
  </div>
</div>


<div class="shop-product">
  <div class="container">
    <div class="banner-shop">
      <div class="js-banner-shop">
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-2.jpg" alt="">
        </div>
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-3.jpg" alt="">
        </div>
      </div>
    </div>
    <div class="shop-tit">
      <h3>SẢN PHẨM bán chạy</h3>
    </div>
    <div class="shop-product-items">
      <?php if(!empty($items_order)){
        foreach ($items_order as $key => $item) {
          $this->load->view('e-azibai/common/common-html-item', ['item'=>$item,'has_af_key'=>$has_af_key]);
        }
      }?>
    </div>
    <div class="icon-add bg-white">
      <span>
        <img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
      </span>
    </div>
  </div>
</div>


<div class="shop-product">
  <div class="container">
    <div class="banner-shop">
      <div class="js-banner-shop">
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-3.jpg" alt="">
        </div>
        <div class="items">
          <img src="/templates/home/styles/images/sanazibai/banner-1.jpg" alt="">
        </div>
      </div>
    </div>
    <div class="shop-tit">
      <h3>SẢN PHẨM nên xem</h3>
    </div>
    <div class="shop-product-items wrap-product-more">
      <?php if(!empty($items_new)){
        foreach ($items_new as $key => $item) {
          $this->load->view('e-azibai/common/common-html-item', ['item'=>$item,'has_af_key'=>$has_af_key]);
        }
      }?>
    </div>
    <div class="icon-add bg-white load-more-item">
      <span>
        <img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
      </span>
    </div>
  </div>
</div>