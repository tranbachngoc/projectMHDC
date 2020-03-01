<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
if (!isset($user_login)) {
    $user_login = MY_Loader::$static_data['hook_user'];
}
$this->load->view('home/common/header_new', [
    'user_login' => $user_login,
    'user_id'    => $user_id,
    'group_id'   => $group_id,
]);
/*block css css_tags*/
if (!empty($css_tags)){
    foreach ($css_tags as $tag) {
        echo $tag;
    }
}
?>
<script src="/templates/home/styles/plugins/boostrap/js/popper.min.js"></script>
<script src="/templates/home/styles/plugins/boostrap/js/bootstrap.min.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<main class="tindoanhnghiep">
    <section class="main-content">
        <?php
        /*block script script_prioritize_tags*/
        if (!empty($script_prioritize_tags)){
            foreach ($script_prioritize_tags as $tag) {
                echo $tag;
            }
        }
        echo @$layout_extend;
        ?>
    </section>
</main>
<footer id="footer">
    <div id="loadding-more" class="text-center hidden">
        <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
    </div>
</footer>
</div>
</body>
<?php
/*block script script_tags*/
if (!empty($script_tags)){
    foreach ($script_tags as $tag) {
        echo $tag;
    }
} ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
</html>
