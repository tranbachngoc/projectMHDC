<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
$page_media = true;
//if visit from azibai show menu azibai
if(isset($visited_azibai) && $visited_azibai == date('Y-m-d')){
    $this->load->view('home/common/header_new');
}else{
    $this->load->view('shop/news/elements/header_shop_news', ['body_class' => 'trangtinchitiet']);
}
/*block css css_tags*/
if (!empty($css_tags)){
    foreach ($css_tags as $tag) {
        echo $tag;
    }
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">

<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>

<?php
/*block script script_prioritize_tags*/
if (!empty($script_prioritize_tags)){
    foreach ($script_prioritize_tags as $tag) {
        echo $tag;
    }
}
if(!isset($color_icon)){
    $color_icon = isset($isMobile) && $isMobile ? 'white' : '';
}

if(!empty($is_owns)){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>
<main class="trangcuatoi tindoanhnghiep bg-white">
    <section class="main-content <?php echo empty($page_current) ? 'bg-purple-black' : '' ?>">
        <div class="container">
            <div class="cover-content">
                <?php $this->load->view($cover_path, ['color_icon' => $color_icon]);  ?>
            </div>
            <div class="sidebarsm">
                <div class="gioithieu">
                    <?php $this->load->view('shop/news/elements/menu_left_items') ?>
                </div>
            </div>
        </div>
        <div class="container liet-ke-hinh-anh bosuutap">
            <?php echo $layout_extend ?>
        </div>
    </section>
</main>

<footer id="footer">
    <div id="loadding-more" class="text-center hidden">
        <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
    </div>
</footer>

<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<?php $this->load->view('home/common/load_wrapp'); ?>
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
