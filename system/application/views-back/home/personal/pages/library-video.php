<div class="hidden">
    <ul class="danhsach-album style-weblink hidden">
        <li class="add"><a href=""><img src="/templates/home/styles/images/svg/add_album.png" alt=""><span>Tạo album</span></a></li>
        <li><a href=""><img src="/templates/home/styles/images/hinhanh/01.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
        <li><a href=""><img src="/templates/home/styles/images/hinhanh/21.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
        <li><a href=""><img src="/templates/home/styles/images/hinhanh/22.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
        <li><a href=""><img src="/templates/home/styles/images/hinhanh/12.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
        <li><a href=""><img src="/templates/home/styles/images/hinhanh/11.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
    </ul>
</div>
<div class="dieuhuong">
    <div class="sm view-control w100pc text-center">
        <?php $view_type = isset($view_type) && $view_type == 'list' ? 'list' : 'grid'; ?>
        <!-- <span class="js_view-action <?php echo $view_type == 'list' ? 'grid-view' : 'list-view' ?>">
            <img src="/templates/home/styles/images/svg/<?php echo $view_type == 'list' ? 'xemluoi_white_on.svg' : 'danhsach_on.svg' ?>" alt="Hiển thị">
        </span> -->

        <div class="list-icons-grid">
            <?php if ($view_type == 'list') { ?>
            <span class="js_view-action js-new-button js-see-haftwidth">
                <img src="/templates/home/styles/images/svg/xemluoi_off.svg" alt="">
            </span>
            <span class="js_view-action js-new-button js-see-fullwidth">
                <img src="/templates/home/styles/images/svg/danhsach_white_on.svg" alt="">
            </span>
            <?php } else { ?>
            <span class="js_view-action js-new-button js-see-haftwidth">
                <img src="/templates/home/styles/images/svg/xemluoi_on.svg" alt="">
            </span>
            <span class="js_view-action js-new-button js-see-fullwidth">
                <img src="/templates/home/styles/images/svg/danhsach_off.svg" alt="">
            </span>
            <?php } ?>
        </div>
    </div>
</div>
<div class="grid
    <?php echo @$page_view; ?>
    <?php echo preg_match("/\/library\/videos/", $_SERVER['REQUEST_URI']) ? 'grid_video' : '';?>
    <?php echo isset($view_type) && $view_type == 'list' ? 'xemluoi' : '' ?>">
    <?php if (!empty($videos)){ ?>
        <?php foreach ($videos as $index => $video) {?>
            <?php $this->load->view('home/personal/elements-library/video-item', [
                'video'     => $video,
                'index'     => $index,
                'auto_play' => true
            ]) ?>
        <?php } ?>
    <?php } ?>
</div>

<?php
block_js([
    '<script src="/templates/home/styles/js/shop/shop-media-video.js"></script>',
]);
?>