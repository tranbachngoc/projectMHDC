<div class="container bosuutap">
    <div class="bosuutap-content page-scroll-to-lvl2 content-posts">
        <div class="bosuutap-content-detail post-detail">
            <div class="modal-show-detail bosuutap-content-detail-modal">
                <div class="container liet-ke-hinh-anh bosuutap">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7 popup-image-sm">
                                <div class="text-center">
                                    <div class="big-img">
                                        <div class="tag position-tag">
                                            <?php
                                            if($link['image']) {
                                                $image = $link['image_url'];
                                            }else{
                                                $image = $link['link_image'];
                                            }

                                            if($link['video']) { ?>
                                                <video <?php echo $isMobile == 1 ? 'muted' : '' ?> poster="<?php echo $image ?>" autoplay="true" playsinline preload="none" controls>
                                                    <source src="<?= $link['video_url'] ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php } else { ?>
                                                <img onerror="image_error(this)" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($link['title']) ?>">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="post">
                                    <div class="">
                                        <div class="info-product">
                                            <div class="descrip">
                                                <a ref="nofollow" href="<?php echo $link['link'] ?>" target="_blank">
                                                    <p><strong class="f16">Nguồn: </strong> <?php echo $link['host'] ?></p>
                                                </a>
                                                <p>
                                                    <a ref="nofollow" href="<?php echo $link['link'] ?>" target="_blank">
                                                        <strong class="f16"><?php echo $link['link_title'] ?></strong>
                                                    </a>
                                                    <br>
                                                    <?php echo $link['link_description'] ?>
                                                </p>
                                            </div>
                                            <div class="sm btn-seelink">
                                                <a ref="nofollow" href="<?php echo $link['link'] ?>" target="_blank">Xem liên kết</a>
                                            </div>
                                        </div>
                                        <div class="info-user">
                                            <div class="name">
                                                <div class="img">
                                                    <a href="<?php echo @$url_owner_link ?>">
                                                        <img onerror="image_error(this)" src="<?php echo @$avatar_owner_link ?>" alt="<?php echo @htmlspecialchars($name_owner_link) ?>">
                                                    </a>
                                                </div>
                                                <h3 class="two-lines"><a href="<?php echo @$url_owner_link ?>"><?php echo @$name_owner_link ?></a></h3>
                                            </div>
                                            <div class="new-comment">
                                                <?php echo $link['description'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="action">
                                    <?php
                                    $data_textlike = 'Thích';
                                    if (!empty($link['is_like'])) {
                                        $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg" >';
                                        $data_textlike = 'Bỏ thích';
                                    }
                                    else{
                                        $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">';
                                    }

                                    $show_link = '';
                                    $numlike = 0;
                                    if(!empty($link['likes']))
                                    {
                                        $numlike = $link['likes'];
                                        $show_link = ' js-show-like-link';
                                    }

                                    if($link['total_share'] > 0)
                                    {
                                        $numshare = $link['total_share'];
                                    }

                                    $arr = array(
                                        'data_backwhite' => 1,
                                        'data_shr' => 1,
                                        'data_class_countact' => 'js-countact-link-'.$link['id'],
                                        'data_jsclass' => 'js-like-link js-like-link-'.$link['id'],
                                        'data_classshow' => $show_link,
                                        'data_url' => $share_url,
                                        'data_title' => $share_name,
                                        'data_user' => $link['user_id'],
                                        'data_typeshare' => $type_share,
                                        'data_id' => $link['id'],
                                        'data_imglike' => $imgLike,
                                        'data_numlike' => $numlike,
                                        'data_classshare' => 'js-list-share-link',
                                        'data_numshare' => $numshare,
                                        'data_lishare' => 1,
                                        'data_textlike' => $data_textlike,
                                        'data_typelink' => ' data-type_url="'.$type_link.'"',
                                        'data_tag' => 'link'
                                    );
                                    $this->load->view('home/share/bar-btn-share', $arr);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="noi-dung-tuong-tu list-link-content">
                            <?php $flag_tab_active = false; ?>
                            <div class="tab-recent">
                                <?php if(!empty($link['links_news'])){ ?>
                                    <div class="text-dark item active">Liên kết cùng tin</div>
                                    <?php $flag_tab_active = true; ?>
                                <?php } ?>
                                <?php if(!empty($link['links_collection'])){ ?>
                                    <div class="text-dark item <?php echo !$flag_tab_active ? 'active' : '' ?>">Liên kết cùng BST</div>
                                    <?php $flag_tab_active = true; ?>
                                <?php } ?>
                                <?php if(!empty($link['links_category'])){ ?>
                                    <div class="text-dark item <?php echo !$flag_tab_active ? 'active' : '' ?>">Liên kết cùng CHUYÊN MỤC</div>
                                    <?php $flag_tab_active = true; ?>
                                <?php } ?>
                            </div>
                            <div class="tab-recent-content">
                                <?php if(!empty($link['links_news'])){ ?>
                                    <div class="liet-ke-hinh-anh tab-1">
                                        <div class="grid">
                                            <?php foreach ($link['links_news'] as $item) {
                                                $this->load->view('home/links/item_link', [
                                                    'item'          => $item,
                                                    'server_media'  => $server_media,
                                                    'url_item'      => $domain_url,
                                                ]);
                                            } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(!empty($link['links_collection'])){ ?>
                                    <div class="liet-ke-hinh-anh tab-2">
                                        <div class="grid">
                                            <?php foreach ($link['links_collection'] as $item) {
                                                $this->load->view('home/links/item_link', [
                                                    'item'          => $item,
                                                    'server_media'  => $server_media,
                                                    'url_item'      => $domain_url,
                                                ]);
                                            } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if(!empty($link['links_category'])){ ?>
                                    <div class="liet-ke-hinh-anh tab-3">
                                        <div class="grid">
                                            <?php foreach ($link['links_category'] as $item) {
                                                $this->load->view('home/links/item_link', [
                                                    'item'          => $item,
                                                    'server_media'  => $server_media,
                                                    'url_item'      => $domain_url,
                                                ]);
                                            } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
/******* trang lien kiet của bạn bè ********/
if(!empty($user_login)){
    $params = [
        'title_popup' => 'Lưu liên kết'
    ];
    if (!empty($user_login['my_shop'])){
        $params['sho_id']       = $user_login['my_shop']['sho_id'];
        $params['default_shop'] = true;
    }
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', $params);
}

$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => false]);
$this->load->view('home/links/popup-common-link');

/* include script file into bottom layout extend*/
block_css([
    '<link rel="stylesheet" href="/templates/home/styles/font/font-awesome-4.7.0/css/font-awesome.css">',
    '<link rel="stylesheet" href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css">',
    '<link rel="stylesheet" href="/templates/home/styles/css/shop/shop-media.css">',
]);
block_js([
    '<script src="/templates/home/styles/js/azibai-links/azibai-hidden-error-images.js"></script>',
    '<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>',
    '<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js" type="text/javascript"></script>',
    '<script src="/templates/home/styles/js/clipboard.min.js" type="text/javascript"></script>',
    '<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>',
    '<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>',
], 'script_prioritize_tags');
block_js([
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>',
    '<script src="/templates/home/styles/js/azibai-links/azibai-link.js"></script>',
    '<script src="/templates/home/styles/js/azibai-links/azibai-library-link-detail.js"></script>',
]);
?>