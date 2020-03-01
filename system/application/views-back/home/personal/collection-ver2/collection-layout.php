<?php
$this->load->view('home/common/header_new');
if (!empty($is_owner)) {
    $cover_path = 'home/personal/elements/cover_login';
} else {
    $cover_path = 'home/personal/elements/cover_not_login';
}
$class_default_sidebar = '';
$profile_shop_url   = shop_url($shop);
?>

<!-- Loading font google -->
<link href="https://fonts.googleapis.com/css?family=Anton|Asap|Bangers|Barlow+Condensed|Chakra+Petch|Charm|Cousine|Dancing+Script|Francois+One|Jura|Oswald|Pacifico|Pattaya|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/css/animate_new.css?ver=<?=time();?>" rel="stylesheet" type="text/css" />
<link href="/templates/home/styles/css/personal.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/tintuc/popup-info-detail.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/css/bootstrap-confirm-delete.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">

<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/personal/personal_handle_image.js"></script>

<script>
    var public_id = '<?php echo $info_public['use_id'];  ?>';
    var url_ajax = '<?php echo $profile_url;  ?>';
</script>

<main class="trangcuatoi tindoanhnghiep collection-version02">
  <section class="main-content <?=$has_black_version ? 'bg-purple-black' : ''?>">
    <div class="container liet-ke-hinh-anh <?=$has_black_version ? 'bg-black-container' : ''?>">
      <div class="cover-content">
        <?php echo $this->load->view($cover_path, ['color_icon' => @$color_icon]); ?>
      </div>
      <div class="sidebarsm">
        <div class="gioithieu">
          <?php echo $this->load->view('home/personal/elements/personal_menu_left_items', ['profile_url' => $info_public['profile_url']]) ?>
        </div>
      </div>
    </div>
    <div class="container bosuutap liet-ke-hinh-anh">
      <div class="bosuutap-header-tabs">
        <ul class="bosuutap-header-tabs-content">
          <li class="active">
            <a href="<?=$info_public['profile_url'] . 'collection/link'?>">BST liên kết</a>
          </li>
        </ul>
      </div>
      <?php echo $layout_extend ?>
    </div>
  </section>
</main>

<footer id="footer"></footer>
<div class="back-to-top sm" id="goTop"><span><i class="fa fa-arrow-up mr05" aria-hidden="true"></i> Lên đầu trang</span></div>

<div id="loadding-more" class="text-center hidden">
  <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
</div>

<?php $this->load->view('home/common/overlay_waiting'); ?>

</div>
<?php $this->load->view('home/personal/elements/popup_edit_avatar'); ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>

<!--block script tags-->
<?php
if (!empty($script_tags)){
    foreach ($script_tags as $tag) {
        echo $tag;
    }
}
?>

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