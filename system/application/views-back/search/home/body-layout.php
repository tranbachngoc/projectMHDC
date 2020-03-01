<main class="search-page">
  <section class="main-content">
    <div class="container">
      <div class="sm icon-filter" data-toggle="modal" data-target="#modalFilter">
        <img src="/templates/home/styles/images/svg/filter02.svg" alt="">
      </div>
      <div class="js-scroll-x set-width-category">
        <div class="category-search">
          <div class="item <?=$this->uri->segment(1) == "search" ? 'is-active' : ''?>">
            <a href="<?=$url_tab['all']?>">Tất cả</a>
          </div>
          <div class="item <?=$this->uri->segment(1) == "search-article" ? 'is-active' : ''?>">
            <a href="<?=$url_tab['article']?>">Bài viết</a>
          </div>
          <div class="item <?=$this->uri->segment(1) == "search-personal" ? 'is-active' : ''?>">
            <a href="<?=$url_tab['personal']?>">Cá nhân</a>
          </div>
          <div class="item <?=$this->uri->segment(1) == "search-company" ? 'is-active' : ''?>">
            <a href="<?=$url_tab['company']?>">Doanh nghiệp</a>
          </div>
          <div class="item <?=$this->uri->segment(1) == "search-image" ? 'is-active' : ''?>">
            <a href="<?=$url_tab['image']?>">Ảnh</a>
          </div>
          <!-- <div class="item">
            <a href="timkiem_sanpham.html">Sản phẩm</a>
          </div>
          <div class="item">
            <a href="timkiem_coupon.html">Coupon</a>
          </div>
          <div class="item">
            <a href="timkiem_lienket.html">Liên kết</a>
          </div>
          <div class="item">
            <a href="timkiem_video.html">Video</a>
          </div>
          <div class="item">
            <a href="timkiem_nhom.html">Nhóm</a>
          </div>
          <div class="item">
            <a href="timkiem_bosuutap.html">Bộ sưu tập</a>
          </div>
          <div class="item">
            <a href="timkiem_diadiem.html">Địa điểm</a>
          </div> -->
        </div>
      </div>
      <div class="row search-page-content js-scroll-search">
        <?php echo $layout_extend ;?>
      </div>
    </div>
  </section>
</main>