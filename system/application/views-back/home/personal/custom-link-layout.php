<?php
$this->load->view('home/common/header_new');
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
$cover_path = 'home/personal/elements/cover_not_login';
if (!empty($is_owner)) {
    $cover_path = 'home/personal/elements/cover_login';
}
if(!isset($color_icon)){
    $color_icon = isset($isMobile) && $isMobile ? 'white' : '';
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">
<?php
/*block css css_tags*/
if (!empty($css_tags)){
    foreach ($css_tags as $tag) {
        echo $tag;
    }
}
?>

<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>

<?php
/*block script script_prioritize_tags*/
if (!empty($script_prioritize_tags)){
    foreach ($script_prioritize_tags as $tag) {
        echo $tag;
    }
}
?>
<main class="trangcuatoi tindoanhnghiep bg-white">
    <section class="main-content <?php echo empty($page_current) ? 'bg-purple-black' : '' ?>">
        <?php
        $this->load->view('home/personal/elements/personal_header', [
            'cover_path'        => $cover_path,
            'color_icon'        => $color_icon,
            'profile_url'       => $current_profile['profile_url'],
            'profile_shop_url'  => $profile_shop_url,
        ]);
        ?>
        <div class="container liet-ke-hinh-anh bosuutap">
            <?php echo $layout_extend ?>
        </div>
    </section>
</main>
<?php $this->load->view('home/report/popup-report'); ?>
<?php $this->load->view('home/common/load_wrapp'); ?>
<?php $this->load->view('home/personal/elements-library/media-footer') ?>

<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>

<script src="/templates/home/styles/js/shop/shop-common.js"></script>

</div>
</body>
<!--block script tags-->
<?php
if (!empty($script_tags)){
    foreach ($script_tags as $tag) {
        echo $tag;
    }
}
?>
</html>
