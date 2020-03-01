<div class="bosuutap-content page-scroll-to-lvl2">
    <div class="bosuutap-content-detail">
        <div class="modal-show-detail bosuutap-content-detail-modal">
            <div class="container">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-7 popup-image-sm">
                            <div class="text-center">
                                <div class="big-img">
                                    <div class="tag position-tag">
                                        <?php
                                        $image = $link['image'];
                                        if($link['image_path']) {
                                            $image =  $link['image_path'];
                                        }
                                        $poster = 'poster="'.$image.'"';
                                        ?>
                                        <?php if($link['media_type'] ==  'video' && $link['video_path'] != '') { ?>
                                            <video <?php echo $isMobile == 1 ? 'muted' : '' ?> <?=$poster?> autoplay="true" playsinline preload="none" controls>
                                                <source src="<?= $link['video_path'] ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php } elseif ($link['media_type'] == 'image' && $link['image_path'] != '') { ?>
                                            <img onerror="image_error(this)" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($link['title']) ?>">
                                        <?php } else { ?>
                                            <img onerror="image_error(this)" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($link['title']) ?>">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5" data-image="<?php echo $image ?>">
                            <div class="post">
                                <div>
                                    <div class="info-product">
                                        <div class="descrip">
                                            <a ref="nofollow" href="<?php echo $link['save_link'] ?>" target="_blank">
                                                <p>
                                                    <strong class="f16">Nguồn: </strong> <?php echo $link['host'] ?>
                                                </p>
                                            </a>
                                            <p>
                                                <a ref="nofollow" href="<?php echo $link['save_link'] ?>" target="_blank">
                                                    <strong class="f16"><?php echo $link['title'] ?></strong>
                                                </a>
                                                <?php echo $link['description'] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="info-user">
                                        <div class="name">
                                            <div class="img">
                                                <img onerror="image_error(this)" src="<?php echo $avatar_owner_link ?>" alt="<?php echo htmlspecialchars($name_owner_link) ?>">
                                            </div>
                                            <h3 class="two-lines"><?php echo $name_owner_link ?></h3>
                                        </div>
                                        <div class="new-comment">
                                            <?php echo $link['detail'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="action">
                                    <?php
                                    $data_textlike = '';
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

                                    $arr = array(
                                        'data_backwhite' => 1,
                                        'data_shr' => 1,
                                        'data_class_countact' => 'js-countact-link-'.$link['id'],
                                        'data_jsclass' => 'js-like-link js-like-link-'.$link['id'],
                                        'data_classshow' => $show_link,
                                        'data_url' => $share_url,
                                        'data_title' => $share_name,
                                        'data_user' => $current_profile['use_id'],
                                        'data_typeshare' => $type_share,
                                        'data_id' => $link['id'],
                                        'data_imglike' => $imgLike,
                                        'data_numlike' => $numlike,
                                        'data_lishare' => 1,
                                        'data_textlike' => $data_textlike,
                                        'data_typelink' => ' data-type_url="'.$type_link.'"');
                                    $this->load->view('home/share/bar-btn-share', $arr);
                                    
                                    // $this->load->view('home/share/bar-btn-share', array('data_backwhite' => 1, 'data_shr' => 1, 'data_jsclass' => 'js-like-link', 'data_url' => $share_url, 'data_title' => $share_name, 'data_id' => $link['id'], 'data_imglike' => $imgLike, 'data_numlike' => 0, 'data_lishare' => 1));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="noi-dung-tuong-tu">
                        <?php $flag_tab_active = false; ?>
                        <div class="tab-recent">
                            <?php if(!empty($links_news)){ ?>
                                <div class="item active">Liên kết cùng tin</div>
                                <?php $flag_tab_active = true; ?>
                            <?php } ?>
                            <?php if(!empty($links_collection)){ ?>
                                <div class="item <?php echo !$flag_tab_active ? 'active' : '' ?>">Liên kết cùng BST</div>
                                <?php $flag_tab_active = true; ?>
                            <?php } ?>
                            <?php if(!empty($links_category)){ ?>
                                <div class="item <?php echo !$flag_tab_active ? 'active' : '' ?>">Liên kết cùng CHUYÊN MỤC</div>
                                <?php $flag_tab_active = true; ?>
                            <?php } ?>
                        </div>
                        <div class="tab-recent-content">
                            <?php if(!empty($links_news)){ ?>
                                <div class="liet-ke-hinh-anh tab-1">
                                    <div class="grid">
                                        <?php foreach ($links_news as $item) {
                                            $this->load->view('shop/media/elements/library-links/custom-link-item', [
                                                'item'      => $item,
                                                'is_owns'   => $is_owns
                                            ]);
                                        } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($links_collection)){ ?>
                                <div class="liet-ke-hinh-anh tab-2">
                                    <div class="grid">
                                        <?php foreach ($links_collection as $item) {
                                            $this->load->view('shop/media/elements/library-links/custom-link-item', [
                                                'item'      => $item,
                                                'is_owns'   => $is_owns
                                            ]);
                                        } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($links_category)){ ?>
                                <div class="liet-ke-hinh-anh tab-3">
                                    <div class="grid">
                                        <?php foreach ($links_category as $item) {
                                            $this->load->view('shop/media/elements/library-links/custom-link-item', [
                                                'item'        => $item,
                                                'is_owns'     => $is_owns
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

<?php
$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => $is_owns]);

block_js([
    '<script type="text/javascript" src="/templates/home/styles/js/clipboard.min.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-custom-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-link-detail.js"></script>',
]);

?>