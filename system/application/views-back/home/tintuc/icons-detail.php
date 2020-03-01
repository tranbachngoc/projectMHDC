<?php
if (!isset($user_login)) {
    $user_login = MY_Loader::$static_data['hook_user'];
}
if (!empty($af_id)) {
    $afkey = '?af_id=' . $af_id;
}
$azibai_url = azibai_url();
$item_logo  = site_url('templates/home/styles/images/product/avata/default-avatar.png');
$item_link  = $protocol . $domainname . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
$title      = $item->not_title;
$domain_use = $protocol . $domainname;
if($item->sho_id) {
    $owner_name = $item->sho_name;
    if (!empty($item->sho_logo)) {
        $item_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
    }
}
if($item->not_user && !$item->sho_id){
    if($domain_use == $azibai_url){
        $domain_use = $azibai_url . '/profile/' . $item->not_user;
    }
    $owner_name = $item->use_fullname;
    if (!empty($item->avatar)) {
        $item_logo = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $item->use_id . '/' . $item->avatar;
    }
}

$title_ = $item->use_fullname.' - '.html_entity_decode($item->not_detail);
if($item->sho_id){
    $title_ = $item->not_title;
}
$title_     = convert_percent_encoding($title_);
$body_class = ' trangtinchitiet trangtinchitiet-v2 highlightsIconPage ';

$this->load->view('home/common/header_new', ['body_class' => $body_class]);
//$this->load->view('shop/news/elements/header_shop', ['body_class' => $body_class, 'link_back' => $item_link]);

?>
<!-- Loading font google -->
<link href="https://fonts.googleapis.com/css?family=Anton|Asap|Bangers|Barlow+Condensed|Chakra+Petch|Charm|Cousine|Dancing+Script|Francois+One|Jura|Oswald|Pacifico|Pattaya|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/owl.carousel.min.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/style.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/lightgallery/css/lightgallery.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/css/animate_new.css?ver=<?=time();?>" />
<link href="/templates/home/css/new-detail.css?ver=<?=time();?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/templates/home/styles/js/countdown.js"></script>
<script type="text/javascript" src="/templates/home/js/text.min.js?ver=<?=time();?>"></script>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<script src="/templates/home/styles/js/shop/shop-news.js"></script>
<!--js edit link-->
<script>
    var type_link_template = 'content_index';
</script>
<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>
<!--/end js edit link-->
<script type="text/javascript" src="/templates/home/styles/js/common.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/slick.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/slick-slider.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/fixed_sidebar.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/popup_dangtin.js"></script>
<script type="text/javascript" src="/templates/home/styles/plugins/wowslider/owl.carousel.js"></script>
<script type="text/javascript" src="/templates/home/styles/plugins/wowslider/wowslider.js"></script>
<script type="text/javascript" src="/templates/home/styles/plugins/wowslider/script.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/commission-aft.js"></script>
<script type="text/javascript" src="/templates/home/styles/js/home-news.js"></script>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/detail-content.js"></script>

<main>
    <section class="main-content">
        <div class="container">
            <div class="highlightsIconPage-content row justify-content-md-center">
                <div class="col-lg-6">
                    <?php
                    $result_icon = null;
                    if(!empty($item->not_additional) && is_array($item->not_additional)) {
                        $result_icon = $this->load->view('home/tintuc/elements/item-detail-icons', [
                            'icons'      => $item->not_additional,
                            'domain_use' => $domain_use,
                        ], true);
                    }

                    $html_images = '';
                    if(!empty($listImg)){
                        foreach ($listImg as $img) {
                            $html_images .= $this->load->view('home/tintuc/elements/item-icon-image', [
                                'image' => $img
                            ], true);

                            if(empty($result_icon) && $img->style){
                                $img->style = @json_decode($img->style);
                                if(property_exists($img->style, 'caption2') && !empty($img->style->caption2)){
                                    $result_icon = $this->load->view('home/tintuc/elements/item-detail-icons', [
                                        'icons'      => $img->style->caption2,
                                        'domain_use' => $domain_use,
                                    ], true);
                                }

                            }
                            if(!empty($img->content_image_links)){
                                foreach ($img->content_image_links as $image_link) {
                                    $html_images .= $this->load->view('home/tintuc/elements/item-icon-link', [
                                        'link'       => $image_link,
                                        'domain_use' => $domain_use,
                                    ], true);
                                }
                            }
                        }
                    }

                    ?>
                    <div class="highlightsIconPage-title">
                        <div class="left">
                            <a class="back" href=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                            <div class="name">
                                <img src="<?php echo $item_logo ?>" alt="avatar" class="avata">
                                <h3 class="tt two-lines"><?php echo $title ? $title : $owner_name; ?></h3>
                            </div>
                        </div>
                        <div class="right">
                            <a class="btn-detail" href="<?php echo $item_link ?>">Chi tiết tin</a>
                        </div>
                    </div>
                    <?php if($result_icon){ ?>
                        <div class="highlightsIconPage-detail">
                            <?php echo $result_icon; ?>
                        </div>
                    <?php } ?>
                    <?php  if($html_images){ ?>
                        <div class="highlightsIconPage-detail-item">
                            <?php echo $html_images ?>
                        </div>
                    <?php } ?>
                    <?php
                    $show_video = '';
                    $numlike = $numshare = 0;
                    if(!empty($item->likes_content)){
                        $show_video = ' js-show-like';
                        $numlike = $item->likes_content;
                    }
                    if($item->total_share > 0){
                        $numshare = $item->total_share;
                    }

                    $permission = $this->session->userdata('sessionUser') && $this->session->userdata('sessionUser') == $item->not_user ? 1 : 0;
                    ?>
                    <div class="bg-gray-blue">
                        <div class="show-number-action version02 js-countact-video-4380">
                            <ul>
                                <li class="list-like-js-4380" data-id="4380">
                                    <img class="icon-img" src="/templates/home/styles/images/svg/liked.svg" alt="">
                                    <span class="count-like color-gray14 js-count-like-<?php echo $item->not_id; ?>"><?php echo $numlike; ?></span>
                                </li>
                                <li class="cursor-pointer">0 bình luận</li>
                                <li class="cursor-pointer js-total-image"><?php echo $numshare; ?> chia sẻ</li>
                            </ul>
                        </div>
                        <div class="action ">
                            <div class="action-left show-number-action">
                                <ul class="action-left-listaction version01">
                                    <li class="like cursor-pointer js-like-content" data-id="<?php echo $item->not_id ?>">
                                        <?php if (!empty($item->is_like_content)) { ?>
                                            <img class="icon-img"
                                                 src="/templates/home/styles/images/svg/like_pink.svg" alt="like"
                                                 data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                                 data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                        <?php } else { ?>
                                            <img class="icon-img" src="/templates/home/styles/images/svg/like.svg"
                                                 alt="like"
                                                 data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                                 data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                        <?php } ?>
                                        <span class="md color-gray14">Thích</span>
                                    </li>
                                    <li class="comment">
                                        <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                                        <span class="md color-gray14">Bình luận</span>
                                    </li>
                                    <li>
                                        <div class="img share-click shr-content" data-toggle="modal"
                                             data-value="<?= $share_url; ?>" data-name="<?= $title_ ?>"
                                             data-type="<?= $type_share ?>" data-item_id="<?= $item->not_id ?>"
                                             data-url_page="<?= $share_url; ?>" data-permission="<?= $permission ?>"
                                             data-tag="content">
                                            <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                                            <span class="md color-gray14">Chia sẻ</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <ul class="detail-more"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</div>
</body>
</html>