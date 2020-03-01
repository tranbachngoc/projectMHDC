<div class="sanazibai-header">
  <div class="container">
    <ul class="sanazibai-header-item">
      <li>
        <a class="sanazibai-header-item-link" href="<?=azibai_url('/shop/products')?>">
          <img class="icon" src="/templates/home/styles/images/svg/dssp.svg" alt="">
          <p class="tit">Sản phẩm</p>
        </a>
      </li>
      <li>
        <a class="sanazibai-header-item-link" href="<?=azibai_url('/shop/coupons')?>">
          <img class="icon" src="/templates/home/styles/images/svg/pmh.svg" alt="">
          <p class="tit">Phiếu mua
            <span class="md">&nbsp;hàng</span>
          </p>
        </a>
      </li>
      <li>
        <a class="sanazibai-header-item-link" href="javascript:void(0)">
          <img class="icon" src="/templates/home/styles/images/svg/spdx.svg" alt="">
          <p class="tit md">
            <span>Sản phẩm bạn đã xem</span>
          </p>
          <p class="tit sm">
            <span>Đã xem</span>
          </p>
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
        </a>
      </li>
    </ul>
  </div>
</div>

<div class="shop-product">
  <div class="container">
    <div class="banner-shop">
      <div class="js-banner-shop">
        <div class="items">
          <img src="/templates/home/styles/images/product/sanazibai/banner01.jpg" alt="">
        </div>
        <div class="items">
          <img src="/templates/home/styles/images/product/sanazibai/banner02.jpg" alt="">
        </div>
        <div class="items">
          <img src="/templates/home/styles/images/product/sanazibai/banner03.jpg" alt="">
        </div>
      </div>
    </div>
    
    <?php $this->load->view('e-azibai/category/html-breadcrumb');?>

    <?=$pagination?>
    <!-- <nav class="nav-pagination pagination-style">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link page-prev" href="#" aria-label="Previous">
            <i class="fa fa-chevron-left"></i>
          </a>
        </li>
        <li class="page-item active">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">...</a>
        </li>
        <li class="page-item">
          <a class="page-link page-next" href="#" aria-label="Next">
            <i class="fa fa-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav> -->
  </div>
</div>