<div class="dieuhuong">
    <div class="sm view-control w100pc text-center">
        <?php $view_type = isset($view_type) && $view_type == 'list' ? 'list' : 'grid'; ?>
        <span class="js_view-action <?php echo $view_type == 'list' ? 'grid-view' : 'list-view' ?>">
            <img src="/templates/home/styles/images/svg/<?php echo $view_type == 'list' ? 'xemluoi_white_on.svg' : 'danhsach_on.svg' ?>" alt="Hiển thị">
        </span>
    </div>
</div>
<!-- <ul class="danhsach-album style-weblink hidden">
    <li class="add"><a href=""><img src="/templates/home/styles/images/svg/add_album.png" alt=""><span>Tạo album</span></a></li>
    <li><a href=""><img src="/templates/home/styles/images/hinhanh/01.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
    <li><a href=""><img src="/templates/home/styles/images/hinhanh/21.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
    <li><a href=""><img src="/templates/home/styles/images/hinhanh/22.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
    <li><a href=""><img src="/templates/home/styles/images/hinhanh/12.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
    <li><a href=""><img src="/templates/home/styles/images/hinhanh/11.jpg" alt=""><span>Ảnh đại diện (29)</span></a></li>
</ul> -->
<div class="grid
    <?php echo @$page_view; ?>
    <?php echo preg_match("/\/library\/videos/", $_SERVER['REQUEST_URI']) ? 'grid_video' : '';?>
    <?php echo isset($view_type) && $view_type == 'list' ? 'xemluoi' : '' ?>">
    <?php if (!empty($products)){ ?>
        <?php foreach ($products as $product) {?>
            <?php $this->load->view('shop/media/elements/product-item', ['product' => $product]) ?>
        <?php } ?>
    <?php } ?>
</div>