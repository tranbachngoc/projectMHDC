<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id = (int)$this->session->userdata('sessionUser');

//if visit from azibai show menu azibai
if (isset($visited_azibai) && $visited_azibai == date('Y-m-d')) {
  $this->load->view('home/common/header_new');
} else {
  $this->load->view('shop/news/elements/header_shop_news', ['body_class' => 'trangtinchitiet']);
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/styles/css/slick.css">
<link rel="stylesheet" href="/templates/home/styles/css/slick-theme.css">

<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>

<?php
if (!empty($is_owns)) {
  $cover_path = 'shop/news/elements/cover_login';
} else {
  $cover_path = 'shop/news/elements/cover_not_login';
}
?>
<main class="trangcuatoi collection-version02">
  <section class="main-content <?=$has_black_version ? 'bg-purple-black' : ''?>">
    <div class="container liet-ke-hinh-anh <?=$has_black_version ? 'bg-black-container' : ''?>">
      <div class="cover-content">
        <?php $this->load->view($cover_path); ?>
      </div>
      <div class="sidebarsm">
        <div class="gioithieu">
          <?php $this->load->view('shop/news/elements/menu_left_items') ?>
        </div>
      </div>
    </div>
    <div class="container bosuutap liet-ke-hinh-anh">
      <div class="bosuutap-header-tabs">
        <ul class="bosuutap-header-tabs-content">
          <li class=""><a href="<?=$shop_url . 'shop/collection'?>">BST Tin</a></li>
          <li class=""><a href="<?=$shop_url . 'shop/collection-product'?>">BST sản phẩm</a></li>
          <li class=""><a href="<?=$shop_url . 'shop/collection-coupon'?>">BST coupon</a></li>
          <li class="active"><a href="<?=$shop_url . 'shop/collection-link'?>">BST liên kết</a></li>
        </ul>
      </div>
      <?php echo $layout_extend ?>
    </div>
  </section>
</main>

<!-- <footer id="footer">

</footer> -->
<div class="back-to-top sm" id="goTop"><span><i class="fa fa-arrow-up mr05" aria-hidden="true"></i> Lên đầu trang</span></div>

<div id="loadding-more" class="text-center hidden">
  <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
</div>

<?php $this->load->view('home/common/overlay_waiting'); ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<script src="/templates/home/styles/js/shop/shop-common.js"></script>

</div>
</body>

</html>

<script>
  $(document).ready(function(){ 
    $(window).scroll(function(){ 
      if ($(this).scrollTop() > 100) { 
        $('#goTop').fadeIn(); 
      } else { 
        $('#goTop').fadeOut(); 
      } 
    }); 
    $('#goTop').click(function(){ 
      $("html, body").animate({ scrollTop: 0 }, 600); 
      return false; 
    }); 
  });
</script>