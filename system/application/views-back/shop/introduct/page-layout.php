<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
//if visit from azibai show menu azibai
if(isset($visited_azibai) && $visited_azibai == date('Y-m-d')){
    $this->load->view('home/common/header_new');
}else{
    $this->load->view('shop/news/elements/header_shop_news', ['body_class' => 'trangtinchitiet']);
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<!-- <link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css"> -->
<!-- <link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css"> -->
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">

<script src="/templates/home/styles/js/common.js"></script>
<!-- <script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script> -->
<!-- <script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script> -->
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- <script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script> -->
<!-- <script src="/templates/home/js/jquery.appear.js"></script> -->
<script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>
<!-- <link href="/templates/home/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
if($is_owns){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>
<main class="trangcuatoi tindoanhnghiep <?php echo isset($view_type) && $view_type == 'list' ? 'bg-black' : 'bg-white'; ?>">
    <section class="main-content">
        <div class="container">
            <div class="cover-content">
                <?php echo $this->load->view($cover_path);  ?>
            </div>
            <div class="sidebarsm">
                <div class="gioithieu">
                    <?php $this->load->view('shop/news/elements/menu_left_items') ?>
                </div>
            </div>
        </div>
        <div class="container introduce-business introduct-page">
            <?php echo $layout_extend ?>
        </div>
    </section>
</main>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>

<script>
    var PAGE_VIEW = '<?php echo @$page_view; ?>';
    var VIEW_TYPE = '<?php echo $view_type == 'list' ? 'grid-view' : 'list-view' ?>';
</script>

<?php $this->load->view('shop/common/footer'); ?>
<?php 
// $this->load->view('shop/media/elements/popup-gallery-image', [
//     'url'  => $shop_current->shop_url,
//     'name' => $shop_current->sho_name,
//     'logo' => $shop_current->logo,
// ]);
?>

<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<?php $this->load->view('home/common/modal-mess'); ?>
<!-- <script src="/templates/home/styles/js/shop/shop-gallery.js"></script>
<script src="/templates/home/styles/js/shop/shop-gallery-pop-image.js"></script> -->
<!-- <script src="/templates/home/styles/js/shop/shop-common.js"></script> -->
<?php //$this->load->view('home/common/overlay_waiting'); ?>

<!--block script tags-->
<?php
// if (!empty($script_tags)){
//     foreach ($script_tags as $tag) {
//         echo $tag;
//     }
// }
?>

</div>
</body>
</html>
