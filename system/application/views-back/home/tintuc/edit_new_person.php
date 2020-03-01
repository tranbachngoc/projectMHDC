<?php
$this->load->view('home/common/header_new');
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
$link_server_image = $this->config->item('library_link_config')['cloud_server_show_path'];
?>
<link href="https://fonts.googleapis.com/css?family=Asap|Barlow+Condensed|Chakra+Petch|Charm|Cormorant+Upright|Cousine|Dancing+Script|Jura|Lemonada|Oswald|Pacifico|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">
<link href="/templates/engine1/style.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/home_news.js"></script>
<link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css" />
<script src="/templates/home/owlcarousel/owl.carousel.js"></script>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script src="/templates/engine1/script.js" type="text/javascript"></script>
<script src="/templates/engine1/wowslider.js" type="text/javascript"></script>
<link href="/templates/home/css/addnews.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/shop/shop-news.js"></script>
<script src="/templates/home/js/addnews-preview-person.js?ver=<?=time();?>"></script>
<script src="/templates/home/js/addnews-video.js?ver=<?=time();?>"></script>
<script src="/templates/home/js/addnews-person-images.js?ver=<?=time();?>"></script>
<script src="/templates/home/js/addnews-validate.js?ver=<?=time();?>"></script>
<script src="/templates/home/js/addnews-function.js?ver=<?=time();?>"></script>


<link href="/templates/home/css/addnews-v2.css" type="text/css" rel="stylesheet" />
<!--js edit link-->
<script>
    var type_link_template = 'content_index';
    var domain_use         = '<?php echo @$domain_use; ?>';
    var link_server_image  = '<?php echo @$link_server_image; ?>';
    var api_common_audio_post = '<?php echo $api_common_audio_post ?>';
    var api_common_video_post = '<?php echo $api_common_video_post ?>';
    var token = '<?php echo $token ?>';
    var audios_images = '';
    var audios_url = '';
    var audios_azibai_preview = '';
    var audios_preview_url = '';
    var DOMAIN_CLOUDSERVER = '<?php echo DOMAIN_CLOUDSERVER ?>';
</script>
<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>
<!--/end js edit link-->
<script src="/templates/home/js/addnews-preview-v2.js"></script>

<main>
    <section class="main-content previewnews">
        <div class="container clearfix">
            <div class="sidebar md">
                <div class="sidebar-left"></div>
                <div class="sidebar-right">
                    <div id="preview_content">
                        <div class="title-preview">
                            <h3>XEM TRƯỚC KẾT QUẢ</h3>
                        </div>
                        <div id="prevideo"></div>
                        <div id="pretitlecontent">
                            <div class="r-text"><?= $this->filter->reinjection($item->not_detail); ?></div>
                            <?php if (isset($not_additional) && !empty($not_additional)) { ?>
                                <?php foreach ($not_additional as $iKIcon => $oIconContent) { ?>
                                    <div id="icon_featured<?= $iKIcon ?>"
                                         class="icon-item-featured <?= $oIconContent->position ?>">
                                        <div class="image">
                                            <img src="<?= $oIconContent->icon_url ?>">
                                        </div>
                                        <div class="infomation">
                                            <div class="title"><?= $oIconContent->title ?></div>
                                            <div class="des"><?= $oIconContent->desc ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div id="prelistimagegallery">
                            <?php if (isset($aListImage) && !empty($aListImage)) { ?>
                                <?php foreach ($aListImage as $iKImage => $oImage) { ?>
                                    <div id="<?= $oImage->image_id ?>" class="icon-item-featured-wappar">
                                        <div class="boxaddimagegallerybox" data-id="<?= $oImage->image_id ?>"
                                             style="background-image: url(<?= $oImage->image_url ?>)">
                                            <div class="backgroundfillter"></div>
                                            <button class="setbackground" data-id="<?= $oImage->image_id ?>"></button>
                                            <button class="editimagegallary" data-id="<?= $oImage->image_id ?>"
                                                    data-url="<?= $oImage->image_url ?>"></button>
                                            <button class="deleteimagegallary"
                                                    data-id="<?= $oImage->image_id ?>"></button>
                                        </div>
                                        <p class="title-image"><?= $oImage->title ?></p>
                                        <p class="des-image"><?= $oImage->content ?></p>
                                        <div id="icon_featuredaddimage<?= $oImage->image_id ?>">
                                            <?php if (isset($oImage->icon_list) && !empty($oImage->icon_list)) { ?>
                                                <?php foreach ($oImage->icon_list as $iKIconI => $oIconI) { ?>
                                                    <div id="icon_featured<?= $oImage->image_id . $iKIconI ?>"
                                                         class="icon-item-featured <?= $oIconI->position ?>">
                                                        <div class="image">
                                                            <img src="<?= $oIconI->icon_url ?>">
                                                        </div>
                                                        <div class="infomation">
                                                            <div class="title"><?= $oIconI->title ?></div>
                                                            <div class="des"><?= $oIconI->desc ?></div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <?php if (isset($not_ad) && count((array)$not_ad) > 0) { ?>
                            <div id="preads"
                                 style="background-image: url('<?= $sLinkFolderImage . $not_ad->ad_image ?>');">
                                <?php if ($not_ad->ad_display == 1) { ?>
                                    <div class="boxaddlinkadsdetailfunctioninner">
                                        <div class="overlay_bg" style=""></div>
                                        <div class="slider">
                                            <?php if (isset($not_ad->ad_content) && !empty($not_ad->ad_content)) { ?>
                                                <div id="postadpre" class="owl-carousel">
                                                    <?php foreach ($not_ad->ad_content as $iKAds => $oAds) { ?>
                                                        <div class="adtext text-center">
                                                            <h2 class="text-uppercase"
                                                                style="margin-bottom:20px;"><?= $oAds->title ?></h2>
                                                            <p style="font-size:16px;margin-top: 0px;"><?= $oAds->desc ?></p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="adsshowprew">
                                            <section class="anaclock">
                                                <div class="clock">
                                                    <div class="hour"></div>
                                                    <div class="minute"></div>
                                                    <div class="second"></div>
                                                    <div class="center"></div>
                                                </div>
                                                <div class="textclock" class="text-center">Thời gian còn lại</div>
                                                <div class="countdown" class="text-center"></div>
                                            </section>
                                        </div>
                                        <div class="text-center">
                                            <button class="readmore">Xem chi tiết</button>
                                        </div>
                                    </div>
                                    <script type="text/javascript">

                                        var $h = $(".boxaddlinkadsdetailfunctioninner .hour"),
                                            $m = $(".boxaddlinkadsdetailfunctioninner .minute"),
                                            $s = $(".boxaddlinkadsdetailfunctioninner .second");
                                        $('#postadpre').owlCarousel({
                                            animateOut: 'fadeOutDown',
                                            animateIn: 'zoomIn',
                                            items: 1,
                                            loop: true,
                                            margin: 0,
                                            nav: false,
                                            dots: false,
                                            autoplay: true,
                                            autoplayTimeout: 3000,
                                            autoplayHoverPause: true
                                        });

                                        // Set đồng hồ

                                        $('#preads .countdown,#preads .countdown2').countdown(<?=$not_ad->ad_time?>, function (event) {
                                            $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
                                        });

                                        setUpFace();
                                        computeTimePositions($h, $m, $s);
                                        $("#preads section").on("resize", setSize).trigger("resize");
                                        var ads = {
                                            ad_display: '<?=$not_ad->ad_display?>',
                                            ad_link: '<?=$not_ad->ad_link?>',
                                            ad_time: '<?=$not_ad->ad_time?>',
                                            image: '<?=$sLinkFolderImage . $not_ad->ad_image?>',
                                            image_name: '<?=$not_ad->ad_image?>',
                                            ad_content: JSON.stringify(<?= json_encode((object)$not_ad->ad_content)?>)
                                        }
                                        formData.set('ads', JSON.stringify(ads));
                                    </script>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div id="preads"></div>
                        <?php } ?>

                        <?php if (isset($statistic) && !empty($statistic)) { ?>
                            <div id="prestatic"
                                 style="background-image: url(<?= ($statistic['image'] != '') ? $statistic['image'] : '' ?>)">
                                <div class="boxaddtimeadsdetailfunctioninner">
                                    <?php foreach ($statistic['aStatic'] as $iKStatic => $oStatic) { ?>
                                        <div class="textaddstatic-item">
                                            <p class="number"><?= $oStatic->num ?></p>
                                            <strong><?= $oStatic->title ?></strong>
                                            <span class="description"><?= $oStatic->description ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var data_static = {
                                    image: '<?=$statistic['image_name']?>',
                                    image_url: '<?=$statistic['image']?>',
                                    image_path: '<?=$item->not_dir_image?>',
                                    data_content: <?=json_encode($statistic['aStatic'])?>
                                };

                                formData.set('static', JSON.stringify(data_static));
                            </script>
                        <?php } ?>

                        <?php if (isset($not_customer) && count((array)$not_customer) > 0) { ?>
                            <?php
                            $sBackground = 'background: #808080;';
                            $sColor      = 'color: #ffffff;';
                            if ($not_customer->cus_background != '') {
                                $sBackground = 'background: #' . $not_customer->cus_background . ';';
                            }
                            if ($not_customer->cus_color != '') {
                                $sColor = 'color: #' . $not_customer->cus_color . ';';
                            }
                            $sStyle = $sBackground . $sColor;
                            ?>
                            <div id="prerelative" style="<?= $sStyle ?>">
                                <div id="preRelatedSlider" class="owl-carousel">
                                    <?php foreach ($not_customer->cus_list as $iKC => $oCustomer) { ?>
                                        <div class="relative-item">
                                            <div style="width:100px; margin: 20px auto;">
                                                <?php if (isset($oCustomer->cus_link) && $oCustomer->cus_link != '') { ?>
                                                    <a href="<?= $oCustomer->cus_link ?>" target="_blank">
                                                        <img class="img-responsive img-circle"
                                                             src="<?= $sLinkFolderImage . $oCustomer->cus_avatar ?>"
                                                             alt="<?= $oCustomer->cus_text1 ?>">
                                                    </a>
                                                <?php } else { ?>
                                                    <img class="img-responsive img-circle"
                                                         src="<?= $sLinkFolderImage . $oCustomer->cus_avatar ?>"
                                                         alt="<?= $oCustomer->cus_text1 ?>">
                                                <?php } ?>
                                            </div>
                                            <p class="cus_text1"><strong><?= $oCustomer->cus_text1 ?></strong></p>
                                            <p style="color:red;word-break: break-word;height:20px;overflow:hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;"><?= $oCustomer->cus_text2 ?></p>
                                            <p style="font-size:small; height: 76px; overflow: hidden;word-break: break-word;"><?= $oCustomer->cus_text3 ?></p>
                                            <p style="margin-bottom:20px;">
                                                <button class="btn btn-sm btn-link" style="">&nbsp; Xem thêm &nbsp;
                                                </button>
                                            </p>
                                            <?php if ($oCustomer->cus_facebook != '' || $oCustomer->cus_twitter != '' || $oCustomer->cus_google != '') { ?>
                                                <div class="social">
                                                    <?php if ($oCustomer->cus_facebook != '') { ?>
                                                        <a href="<?= $oCustomer->cus_facebook ?>" target="_blank">
                                                            <img style="padding: 5px;" class="social-icon"
                                                                 src="<?= base_url() ?>templates/home/images/svg/icon_facebook.svg"
                                                                 alt="facebook">
                                                        </a>
                                                    <?php } else { ?>
                                                        <img style="padding: 5px;" class="social-icon"
                                                             src="<?= base_url() ?>templates/home/images/svg/icon_facebook.svg"
                                                             alt="facebook">
                                                    <?php } ?>

                                                    <?php if ($oCustomer->cus_twitter != '') { ?>
                                                        <a href="<?= $oCustomer->cus_twitter ?>" target="_blank">
                                                            <img style="padding: 5px;" class="social-icon"
                                                                 src="<?= base_url() ?>templates/home/images/svg/icon_twitter.svg"
                                                                 alt="twitter">
                                                        </a>
                                                    <?php } else { ?>
                                                        <img style="padding: 5px;" class="social-icon"
                                                             src="<?= base_url() ?>templates/home/images/svg/icon_twitter.svg"
                                                             alt="twitter">
                                                    <?php } ?>
                                                    <?php if ($oCustomer->cus_google != '') { ?>
                                                        <a href="'<?= $oCustomer->cus_google ?>" target="_blank">
                                                            <img style="padding: 5px;" class="social-icon"
                                                                 src="<?= base_url() ?>templates/home/images/svg/icon_google.svg"
                                                                 alt="google">
                                                        </a>
                                                    <?php } else { ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php foreach ($not_customer->cus_list as $iKC => $oCustomer) { ?>
                                    <script type="text/javascript">
                                        formData.append('relative_item', JSON.stringify(<?= json_encode($oCustomer)?>));
                                    </script>
                                <?php } ?>
                            </div>
                            <script type="text/javascript">
                                formData.set('relative_title', '<?=$not_customer->cus_title?>');
                                formData.set('related_background', '<?=$not_customer->cus_background?>');
                                formData.set('related_color', '<?=$not_customer->cus_color?>');
                                formData.set('related_style', '<?=$not_customer->cus_type?>');
                                $('#preRelatedSlider').owlCarousel({
                                    animateOut: 'fadeOutDown',
                                    animateIn: 'zoomIn',
                                    items: 2,
                                    loop: true,
                                    margin: 10,
                                    nav: false,
                                    dots: false,
                                    autoplay: false,
                                    autoplayTimeout: 3000,
                                    autoplayHoverPause: true
                                });
                            </script>
                        <?php } ?>

                        <div class="preview-content-footer">
                            <button type="button" class="cancel">Xóa</button>
                            <button type="button" id="buttonaddnews" class="save">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="blockdangtin">
                    <?php
                    $group_id = (int)$this->session->userdata('sessionGroup');
                    $user_id  = (int)$this->session->userdata('sessionUser');
                    if (isset($currentuser) && $currentuser) {
                        $avatar = site_url('media/images/avatar/default-avatar.png');
                        if ($currentuser->avatar) {
                            $avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $currentuser->use_id . '/' . $currentuser->avatar;
                        }
                    }

                    ?>
                    <?php if (isset($currentuser) && $currentuser) { ?>
                        <div id="addNewsFrontEnd">
                            <div class="blockdangtin-buttontaobaiviet">
                                <p class="taobaiviet is-active">Tạo bài viết</p>
                                <p class="hr-ver"></p>
                                <p>Tạo album</p>
                            </div>
                            <div class="blockdangtin-nhaptin">
                                <img class="img-circle" src="<?php echo $avatar; ?>" alt="account"
                                     style="width:48px; height:48px">
                                <textarea class="bandangnghigi" name="" id="addtitlecontent"
                                          placeholder="Bạn đăng tin gì hôm nay?"></textarea>
                            </div>
                            <div id="boxaddimagegallery" data-num="0">
                                <?php if (!empty($video)) { ?>
                                    <div class="boxaddimagegallerybox"
                                         style="background-image: url(<?= DOMAIN_CLOUDSERVER .'video/thumbnail/'.$video['thumbnail'] ?>)">
                                        <div class="backgroundfillter"></div>
                                        <button class="editvideogallary">
                                            <img src="<?= base_url() ?>/templates/home/styles/images/svg/play_video.svg"/>
                                        </button>
                                        <button class="deletevideo" data-id="<?= $video['name'] ?>"></button>
                                    </div>
                                    <script type="text/javascript">
                                        formData.set('have_video', 1);
                                        formData.set('not_video', '<?=$video['name']?>');
                                        formData.set('not_video_thumb', '<?=$video['thumbnail']?>');
                                    </script>
                                    <?php if(!empty($video['title'])){ ?>
                                        <script type="text/javascript">
                                            formData.set('video_title', '<?=$video['title']?>');
                                        </script>
                                    <?php } ?>
                                    <?php if(!empty($video['description'])){ ?>
                                        <script type="text/javascript">
                                            formData.set('video_content', '<?=$video['description']?>');
                                        </script>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (isset($aListImage) && !empty($aListImage)) { ?>
                                    <?php foreach ($aListImage as $iKImage => $oImage) { ?>
                                        <div class="boxaddimagegallerybox" data-id="<?= $oImage->image_id ?>"
                                             style="background-image: url(<?= $oImage->image_url ?>)">
                                            <div class="backgroundfillter"></div>
                                            <button class="setbackground" data-id="<?= $oImage->image_id ?>"></button>
                                            <button class="editimagegallary" data-id="<?= $oImage->image_id ?>"
                                                    data-url="<?= $oImage->image_url ?>"></button>
                                            <button class="deleteimagegallary" data-id="<?= $oImage->image_id ?>"></button>
                                        </div>
                                        <script type="text/javascript">
                                            formData.set('have_image', <?=count($aListImage);?>);
                                            formData.append('list_image_id[]', <?=$oImage->image_id?>);
                                            formData.set('images[<?=$oImage->image_id?>]', JSON.stringify(<?=json_encode($oImage)?>));
                                        </script>
                                    <?php } ?>
                                <?php } ?>
                                <?php if(!empty($images) || !empty($video)){ ?>
                                    <script type="text/javascript">
                                        $('#boxaddimagegallery').css('display', 'block');
                                    </script>
                                <?php } ?>
                                <div class="boxaddmoreimage">
                                    <input accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv, image/*"
                                           multiple="true" name="composer_photo" title="Chọn file để tải lên"
                                           display="inline-block" type="file" class="buttonAddImage"
                                           id="add-more-images">
                                </div>

                            </div>
                            <div class="blockdangtin-dangtinby">
                                <button class="addvideonews">
                                    <img src="<?= base_url() ?>templates/home/images/svg/camera.svg" alt="Video">Ảnh/Video
                                    <input type="file" class="buttonAddImage" name="video"
                                           accept="video/*,  video/x-m4v, video/webm, video/x-ms-wmv, video/x-msvideo, video/3gpp, video/flv, video/x-flv, video/mp4, video/quicktime, video/mpeg, video/ogv, .ts, .mkv,image/*"
                                           multiple="true">
                                </button>
                                <button data-toggle="modal" data-target="#typeDisplayNewsdetail">
                                    <img src="/templates/home/styles/images/svg/typenewdetail.svg"
                                         alt="Hiển thị chi tiết tin">Hiển thị chi tiết tin
                                </button>
                                <button class="more" id="buttonaddfunction">
                                    <img src="<?= base_url() ?>templates/home/images/svg/3dot.svg" alt="">
                                </button>
                            </div>
                            <div class="boxaddnew" data-satus="closed">
                                <textarea name="not_detail" required placeholder="Nội dung tin (bắt buộc)"
                                          rows="5"><?= $item->not_detail; ?></textarea>
                            </div>
                            <div id="tabdescontentlinkmain" class="tabdescontentlink">
                                <div class="addlinkthem addlinkthem-detail no-slider-for version01" id="addlinkthem">
                                    <ul class="edit-news slider addlinkthem-slider">
                                        <?php if (isset($not_customlink) && !empty($not_customlink)) { ?>
                                            <?php foreach ($not_customlink as $iKCustomLink => $oCustomLink) { ?>
                                                <?php
                                                $this->load->view('home/tintuc/item-link-v2', [
                                                    'kLink'      => $iKCustomLink,
                                                    'link_v2'    => $oCustomLink,
                                                    'domain_use' => $domain_use,
                                                ]); ?>
                                                <script type="text/javascript">
                                                    formData.set('num_customlink', <?=count($not_customlink)?>);
                                                    formData.append('not_customlink[<?=$iKCustomLink?>]', JSON.stringify(<?= json_encode($oCustomLink)?>));
                                                </script>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div id="boxaddfunction"></div>
                            <div id="boxaddnewsexample">
                                <?php if (isset($not_additional) && !empty($not_additional)) { ?>
                                    <?php foreach ($not_additional as $iKIcon => $oIconContent) { ?>
                                        <div class="icon-item-featured <?= $oIconContent->position ?>">
                                            <div class="image">
                                                <img src="<?= $oIconContent->icon_url ?>">
                                                <button type="button" class="close remove-icon-item"
                                                        data-icon="<?= $iKIcon ?>">×
                                                </button>
                                            </div>
                                            <div class="infomation">
                                                <div class="title"><?= $oIconContent->title ?></div>
                                                <div class="des"><?= $oIconContent->desc ?></div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            formData.append('icon_list', JSON.stringify(<?=json_encode($oIconContent)?>));
                                        </script>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="morefooter list-checkbox">
                                <div class="morefooter-row">
                                    <div class="morefooter-left checkbox-style">
                                        <label>
                                            <input type="checkbox" name="category" value="1">
                                            <span class="checkbox"></span>
                                        </label>
                                        <img class="img-circle" src="<?php echo $avatar; ?>" alt="account"
                                             style="width:32px; height:32px">
                                        <span>Bảng tin</span>
                                    </div>
                                    <div class="morefooter-right">
                                        <button class="public-type">Công khai</button>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="morefooter-row">
                                    <div class="morefooter-left checkbox-style">
                                        <label>
                                            <input type="checkbox" name="category" value="2">
                                            <span class="checkbox"></span>
                                        </label>
                                        <img class="img-circle" src="<?php echo $avatar; ?>" alt="account"
                                             style="width:32px; height:32px">
                                        <span>Tin của bạn</span>
                                    </div>
                                    <div class="morefooter-right">
                                        <button class="public-type">Bạn bè</button>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="morefooter-row">
                                    <button class="readmoreboxnew">Xem thêm</button>
                                    <button id="submitnews">Đăng tin</button>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div id="boxwork"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
    formData.set('urlupdate', '<?=$url?>');
    formData.set('action', 'update');
    formData.set('dir', '<?=$item->not_dir_image?>');
    formData.set('sLinkFolderImage', '<?=$sLinkFolderImage?>');
    // Link image 
    var sLinkFolderImage = '<?=$sLinkFolderImage?>';

    // Set not_description
    <?php if($item->not_keywords != '') { ?>
    formData.set('not_keywords', '<?=$item->not_keywords?>');
    <?php } ?>

    // Set not_pro_cat_id
    <?php if($item->not_pro_cat_id != '') { ?>
    formData.set('not_pro_cat_id', '<?=$item->not_pro_cat_id?>');
    <?php } ?>

</script>
<!-- popup -->
<?php $this->load->view('home/tintuc/popup-tag', array()); ?>
<!-- end popup -->

<!-- Popup Icon -->
<?php
$this->load->helper('directory');
$icons = directory_map('./images/icons');
?>
<div class="drawer-overlay drawer-toggle" data-popup=""></div>
<div id="myIconModal" class="model-content">
    <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back">
                    <a href="#">
                        <img src="<?= base_url() ?>templates/home/images/svg/close.svg">
                    </a>
                </div>
                <div class="row list-icon" style="height:450px; overflow: auto">
                    <?php
                    if (isset($icons)) {
                        foreach ($icons as $image) {
                            $imglink = base_url() . 'images/icons/' . $image;
                            ?>
                            <div class="icon-item chooseimage" style="cursor:pointer;"
                                 data-image-url="<?= $imglink ?>"
                                 data-image="<?= $image ?>" title="<?= $image ?>">
                                <?php echo '<img class="aicon img-responsive" src="' . base_url() . 'images/icons/' . $image . '"/>'; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="footer-popup">
                    <button type="button" class="btn btn-primary insertimage">Chọn icon</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Icon option -->
<div id="myIconOption" class="model-content">
    <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back">
                    <a href="#">
                        <img src="<?= base_url() ?>templates/home/images/svg/close.svg">
                    </a>
                </div>
                <div class="content-icon-option"></div>
                <div class="footer-popup">
                    <button type="button" class="btn btn-primary inserticon">Chèn icon</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup error -->
<div id="myError" class="model-content">
    <div class="wrapp-model">
        <div class="content-model">
            <div class="contents">
                <div class="btn-back js-back">
                    <a href="#">
                        <img src="<?= base_url() ?>templates/home/images/svg/close.svg">
                    </a>
                </div>
                <div class="content-icon-option"></div>
            </div>
        </div>
    </div>
</div>

<?php
/*popup edit link*/
$this->load->view('shop/media/elements/library-links/popup-custom-link-create', [
    'sho_id'        => @(int)$user_login['my_shop']['sho_id'],
    'default_shop'  => false
]);
?>

<?php $this->load->view('home/tintuc/popup/pop-style-show-content', ['type_show' => $item->type_show]); ?>
