<?php
$this->load->view('home/common/header_new');
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
$page_media = true;
$color_icon = (isset($page_view) && $page_view == 'video-page' && isset($view_type) && $view_type == 'list') ? 'white' : '';
$cover_path = 'home/personal/elements/cover_not_login';
if (!empty($is_owner)) {
    $cover_path = 'home/personal/elements/cover_login';
}

if(explode('/',$_SERVER['REQUEST_URI'])[1] == 'library' && explode('?', explode('/',$_SERVER['REQUEST_URI'])[2])[0] == 'images')
{
    $background = 'bg-white';
}else{
    $background = isset($view_type) && $view_type == 'list' ? 'bg-black' : 'bg-white';
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/templates/home/boostrap/css/animate.min.css">

<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/personal/personal_handle_image.js"></script>

<main class="trangcuatoi tindoanhnghiep <?php echo $background; ?>">
    <section class="main-content">
        <?php
        $this->load->view('home/personal/elements/personal_header', [
            'cover_path'        => $cover_path,
            'color_icon'        => $color_icon,
            'profile_url'       => $current_profile['profile_url'],
            'profile_shop_url'  => $profile_shop_url,
        ]);
        ?>
        <div class="container liet-ke-hinh-anh <?php echo (!empty($page_view) && $page_view == 'video-page') ? 'liet-ke-video' : '' ?>">
            <?php echo $layout_extend ?>
        </div>
    </section>
</main>
<script>
    var PAGE_VIEW = '<?php echo @$page_view; ?>';
    var VIEW_TYPE = '<?php echo $view_type == 'list' ? 'grid-view' : 'list-view' ?>';
</script>

<?php $this->load->view('home/personal/elements-library/media-footer') ?>

<?php $this->load->view('shop/media/elements/popup-gallery-image', [
    'url'  => $current_profile['profile_url'],
    'name' => $current_profile['use_fullname'],
    'logo' => $current_profile['avatar_url'],
]); ?>

<?php $this->load->view('home/personal/elements/popup_edit_avatar'); ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<?php //$this->load->view('home/common/overlay_waiting'); ?>
<?php $this->load->view('home/report/popup-report'); ?>
<?php $this->load->view('home/common/load_wrapp'); ?>

<script src="/templates/home/styles/js/shop/shop-gallery.js"></script>
<script src="/templates/home/styles/js/shop/shop-gallery-pop-image.js"></script>
<script src="/templates/home/styles/js/shop/shop-common.js"></script>
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
