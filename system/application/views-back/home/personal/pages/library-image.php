<?php if($this->uri->segment(5) != 'view-album'){?>
<!-- <ul class="danhsach-album style-weblink hidden"> -->
<ul class="danhsach-album style-weblink">
    <?php if($is_owner == true) { ?>
    <li class="add js-open-pop-img"><a href="javascript:void(0)"><img class="icon-add" src="/templates/home/styles/images/svg/add_circle.svg" alt=""></br><span>Tạo album</span></a></li>
    <?php }?>
    <?php foreach ($albums as $key => $album) { ?>
    <li>
        <div class="img">
        <a href="<?=azibai_url('/profile/'.$current_profile['use_id'].'/library/images/view-album/'.$album->album_id)?>" target="_blank">
            <img src="<?=$album->album_path_full?>" alt="" class="mCS_img_loaded">
        </a>
        </div>
        <div class="txt">
            <div class="tit two-lines">(<?=$album->total ?>) <?=$album->album_name?></div>
            <div class="icon js-menu-album"
                data-albumId="<?=$album->album_id?>"
                data-offset="<?=$album->album_offset_top?>">
                <img src="/templates/home/styles/images/svg/3dot_doc_white.svg" alt="" class="mCS_img_loaded">
            </div>
        </div>
    </li>
    <?php } ?>
</ul>
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
                <img src="/templates/home/styles/images/svg/danhsach_on.svg" alt="">
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
<?php } else {?>
<div class="dieuhuong">
    <div class="button-back">
        <a href="<?=azibai_url('/profile/'.$current_profile['use_id'].'/library/images')?>"><img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg" alt=""><?=$album->album_name . ' ('.$album_total.')'?></a>
    </div>
    <div class="sm view-control w20pc text-right">
        <?php $view_type = isset($view_type) && $view_type == 'list' ? 'list' : 'grid'; ?>
        <!-- <span class="js_view-action text-center<?php echo $view_type == 'list' ? 'grid-view' : 'list-view' ?>">
            <img src="/templates/home/styles/images/svg/<?php echo $view_type == 'list' ? 'xemluoi_white_on.svg' : 'danhsach_on.svg' ?>" alt="Hiển thị">
        </span> -->
        
        <div class="list-icons-grid">
            <?php if ($view_type == 'list') { ?>
            <span class="js_view-action js-new-button js-see-haftwidth">
                <img src="/templates/home/styles/images/svg/xemluoi_off.svg" alt="">
            </span>
            <span class="js_view-action js-new-button js-see-fullwidth">
                <img src="/templates/home/styles/images/svg/danhsach_on.svg" alt="">
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
<?php }?>

<div class="grid
    <?php echo @$page_view; ?>
    <?php echo preg_match("/\/library\/videos/", $_SERVER['REQUEST_URI']) ? 'grid_video' : '';?>
    <?php echo isset($view_type) && $view_type == 'list' ? 'xemluoi' : '' ?>">
    <?php if (!empty($images)){ ?>
        <?php foreach ($images as $index => $image) {?>
            <?php $this->load->view('home/personal/elements-library/image-item', ['image' => $image, 'index' => $index]) ?>
        <?php } ?>
    <?php } ?>
</div>

<?php  $this->load->view('home/personal/album/image/popup-album-image') ?>
<?php  $this->load->view('home/personal/album/image/js-popup-album-image') ?>