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
<link href="/templates/home/css/person-affiliate.css" rel="stylesheet" type="text/css" />
<link href="/templates/home/styles/css/personal.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/tintuc/popup-info-detail.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/css/bootstrap-confirm-delete.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">


<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/styles/js/fixed_sidebar.js"></script>
<script src="/templates/home/js/affiliate.js"></script>
<script src="/templates/home/js/bootstrap-confirm-delete.js"></script>

<main class="trangcuatoi tindoanhnghiep">
    <section class="main-content">
        <?php $this->load->view('home/personal/elements/personal_header', [
                'cover_path'        => $cover_path,
                'profile_url'       => $info_public['profile_url'],
                'profile_shop_url'  => $profile_shop_url,
            ]); ?>
        <div class="container clearfix">
            <?php echo $layout_extend ?>
        </div>
    </section>
</main>
<footer id="footer"></footer>
</div>

<?php $this->load->view('home/report/popup-report'); ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<script>
    var public_id = '<?php echo $info_public['use_id'];  ?>';
</script>

<script src="/templates/home/styles/js/shop/shop-common.js"></script>

<!--block script tags-->
<?php
if (!empty($script_tags)){
    foreach ($script_tags as $tag) {
        echo $tag;
    }
}
?>
</body>
</html>
