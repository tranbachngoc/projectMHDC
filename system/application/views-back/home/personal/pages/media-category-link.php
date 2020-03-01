<?php $server_media = $this->config->item('library_link_config')['cloud_server_show_path'] . '/'; ?>
<div class="bosuutap-header-tabs js-scroll-x">
    <ul class="bosuutap-header-tabs-content ">
        <li class="active"><a href="#">Liên kết</a></li>
        <li><a href="/shop/collection-link">BST Liên kết</a></li>
    </ul>
</div>
<?php if(!empty($is_owns)){ ?>
    <div class="icon-add">
        <div class="icon-add-logo" data-toggle="dropdown">
            <img src="/templates/home/styles/images/svg/sanazibai_add.svg">
        </div>
        <div class="icon-add-hover dropdown-menu">
            <p data-toggle="modal" data-target="#popup-crawl-custom-link">Thêm liên kết</p>
            <p id="creatNewCollectionLinks">Thêm BST liên kết</p>
            <p data-toggle="modal" data-target="#addBookmarkLinks">Thêm lối tắt</p>
        </div>
    </div>
<?php } ?>
<div class="socials-logos ">
    <?php if(!empty($bookmarks)){
        $this->load->view('shop/media/elements/library-links/bookmark-item', ['bookmarks' => $bookmarks]);
    } ?>
    <div class="tag-column">
        <!--category parent-->
        <?php if(!empty($categories)){
            $this->load->view('shop/media/elements/library-links/library-link-category-parent', [
                'categories' => $categories
            ]);
        } else { ?>
            <!-- chưa có danh mục nào có link-->
            <div class="js-scroll-x">
                <div class="tag-column-parent">
                    <span class="is-active">Tất cả</span>
                </div>
            </div>
        <?php } ?>
        <!--category child-->
        <?php if(!empty($categories_child)){
            $this->load->view('shop/media/elements/library-links/library-link-category-child', [
                'categories_child' => $categories_child
            ]);
        } ?>
    </div>
    <!-- thanh điều hướng -->
    <?php $this->load->view('shop/media/elements/library-links/library-direction', [
        'view_type'          => $view_type,
        'category_link_page' => true,
    ]);
    ?>
</div>
<div class="group-list-link-content">
    <?php if(!empty($items)){ ?>
    <?php
    $item_cat  = $items[0];
    $image     = $item_cat['image'] ? ($server_media. $item_cat['image']) : $item_cat['link_image'];
    $type_tbl  = '';
    $type_share_link  = '';

    if($item_cat['type_tbl'] == LINK_TABLE_LIBRARY){
        $type_tbl   = 'library-link';
        $type_share_link  = TYPESHARE_DETAIL_PRFLIBLINK;
    }
    if($item_cat['type_tbl'] == LINK_TABLE_CONTENT){
        $type_tbl   = 'content-link';
        $type_share_link  = TYPESHARE_DETAIL_PRFLINK_CONTENT;
    }
    if($item_cat['type_tbl'] == LINK_TABLE_IMAGE){
        $type_tbl   = 'image-link';
        $type_share_link  = TYPESHARE_DETAIL_PRFLINK_IMG;
    }
    $selector_category_item = 'js_library-category-item-'. $item_cat['id'];
    ?>
    <div class="list-link-content <?php echo (!empty($category_parent) ? $category_parent['class_bg_color'] : '') ?>">
        <div class="wrap-newest-post">
            <div class="newest-post">
                <a title="<?php echo htmlspecialchars($item_cat['link_title']); ?>" target="_blank" href="<?php echo $url_item . $type_tbl .'/'. $item_cat['id'] ?>">
                    <?php
                    if($item_cat['video']) {
                        $btn_play_video  = 'btn_play_link_' . $item_cat['id'];
                        $video_target    = 'content_link_' . $item_cat['id'];
                        ?>
                        <div class="wrap-video-item-single block_video">
                            <video class="detail-video"
                                   preload="none"
                                   id="<?php echo $video_target ?>"
                                   playsinline
                                   data-target_video="#<?php echo $video_target ?>"
                                   data-target_btn_volume=".js_btn-volume-<?php echo $item_cat['id']?>"
                                   data-target_btn_play=".<?php echo $btn_play_video ?>"
                                   muted
                                   poster="<?php echo $image;?>">
                                <source src="<?=  $server_media . $item_cat['video'] ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div data-video-id="<?php echo $video_target ?>"
                                 data-target_video="#<?php echo $video_target ?>"
                                 data-target_btn_play=".<?php echo $btn_play_video ?>"
                                 class="btn-pause js_btn-pause <?php echo $btn_play_video ?>">
                                <img class="js_img-play" src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="img">
                            <img src="<?php echo $image ?>"
                                 onerror="image_error(this)"
                                 alt="<?php echo htmlspecialchars($item_cat['link_title']); ?>">
                        </div>
                    <?php } ?>
                </a>
                <div class="head">
                    <p class="tit"><?php echo $slug == 'moi-nhat' ? 'Mới nhất' : ucfirst($category_current['name']) ?></p>
                </div>
                <div class="text">
                    <a target="_blank" ref="nofollow" href="<?php echo $item_cat['link']?>">
                        <p class="text-bold">Nguồn: <?php echo $item_cat['host'] ?></p>
                    </a>
                    <a target="_blank" ref="nofollow" href="<?php echo $item_cat['link']?>">
                        <h3 class="one-line"><?php echo $item_cat['link_title'] ?></h3>
                    </a>
                </div>
                <div class="newest-post-edit">
                    <div class="main">
                        <div class="p-2 cursor-pointer icon js_library-link-show-more"
                             data-id="<?php echo $item_cat['id'] ?>"
                             data-link="<?php echo $item_cat['link'] ?>"
                             data-type="<?php echo $type_tbl ?>"
                             data-link_id="<?php echo $item_cat['link_id'] ?>"
                             data-value="<?php echo $url_item . $type_tbl .'/'. $item_cat['id'] ?>"
                             data-name="<?php echo $item_cat['link_title'] ?>"
                             data-type_share="<?php echo $type_share_link ?>">
                            <img src="/templates/home/styles/images/svg/3dot_doc.svg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid">
            <?php foreach ($items as $index => $item) {
                $this->load->view('shop/media/elements/library-links/library-item-v2', [
                    'item'          => $item,
                    'is_owns'       => $is_owns,
                    'server_media'  => $server_media,
                    'type_sharelink_prf' => $type_share_link
                ]);
            } ?>
        </div>
    </div>
    <?php } ?>
</div>

<!--popup item-->
<?php
if(!empty($is_owns)) {
    $this->load->view('shop/media/elements/library-links/popup-bookmark-link');
    $this->load->view('shop/media/elements/library-links/popup-create-collection-link', ['sho_id' => $shop['sho_id']]);
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', ['sho_id' => $shop['sho_id']]);
}

/******* trang lien kiet của bạn bè ********/
if(empty($is_owns) && !empty($user_login)){
    $params = [
        'title_popup' => 'Lưu liên kết'
    ];
    if (!empty($user_login['my_shop'])){
        $params['sho_id']       = $user_login['my_shop']['sho_id'];
        $params['custom_class'] = ' js_action-link-save-clone ';
    }
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', $params);
}

$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => $is_owns]);

block_js([
    '<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-category-library-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/popup-create-collection-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>',
]);
?>
