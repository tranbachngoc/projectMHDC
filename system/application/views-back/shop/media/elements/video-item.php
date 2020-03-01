<?php
$video_title_xss   = ($video->title ? $video->title : $video->not_title);
$video_caption_xss = strip_tags($video->description ? $video->description : $video->not_detail);
$video_url         = DOMAIN_CLOUDSERVER . 'video/' . $video->name;
$image_url         = $video->thumbnail ? (DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $video->thumbnail) : DEFAULT_IMAGE_ERROR_PATH;
$element_index     = $index + $start;
$video_name_old    = str_replace('.', '', $video->not_video_url1);
$btn_play_video    = 'btn_play_video_' . $video_name_old .'_'. $video->not_id;
$video_target      = 'content_video_' . $video_name_old .'_'. $video->not_id;
$news_link = $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title);
$title_alt = str_replace('"', "", $video_title_xss);
$title_ = htmlspecialchars_decode($video_title_xss);
$title = convert_percent_encoding($title_);
?>
<div class="item item-id-<?php echo $video->id ?> item-index-<?php echo $element_index; ?> js_gallery_pop_image js-detect-item-viewport video video-item bg-opacity"
     data-index="<?php echo $element_index ?>">
    <div class="detail"
         data-id="<?php echo $video->id ?>"
         data-type="video"
         data-title="<?php echo htmlspecialchars($video_title_xss) ?>"
         data-video="<?php echo $video->name ?>"
         data-tags='<?php echo json_encode([]) ?>'
         data-not_begindate='<?php echo date('d/m/Y', $video->not_begindate) ?>'
         data-video_url="<?php echo $video_url ?>"
         data-image_url="<?php echo $image_url ?>"
         data-content_url="<?php echo $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title) ?>"
         data-index="<?php echo $element_index ?>"
         data-image_size='<?php echo json_encode(['width' => $video->width, 'height' => $video->height]) ?>'
         data-news_id="<?php echo $video->not_id ?>"
         data-caption="<?php echo htmlspecialchars($video_caption_xss) ?>"
         data-key="<?php echo $video->id  ?>"
         data-shopid="<?php echo $shop_current->sho_id; ?>"
         data-shopname="<?php echo $shop_current->sho_name; ?>"
         data-linkpro_shop="<?php echo shop_url($shop_current); ?>"
         data-avatar="<?php echo DOMAIN_CLOUDSERVER.'media/shop/logos/'.$shop_current->sho_dir_logo.'/'.$shop_current->sho_logo; ?>"
         >
        
        <?php if (!empty($siteGlobal)) { ?>
        <!-- <div class="name-account">
            <div class="name-account-avata">
                <a href="<?php echo !empty($siteGlobal->shop_url) ?  $siteGlobal->shop_url: '' ?>">
                <?php
                $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                if($siteGlobal->sho_dir_logo && $siteGlobal->sho_logo){
                    $info_public_avatar_path = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' .$siteGlobal->sho_dir_logo.'/'.$siteGlobal->sho_logo;
                }
                ?>
                    <img class="avatar-personal js_avatar-personal img-circle" src="<?php echo $info_public_avatar_path ?>" alt="<?php echo htmlspecialchars( $siteGlobal->sho_name) ?>">
                </a>
            </div>
            <div class="name-account-text">
                <div class="tt one-line">
                    <a href="<?php echo !empty($siteGlobal->shop_url) ?  $siteGlobal->shop_url: '' ?>"><?php echo $siteGlobal->sho_name; ?></a>
                </div>
                <div class="small">
                    <div class="date"><?php echo date('d/m/Y', $video->not_begindate) ?></div>
                    <div class="view">
                        <img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt="">8K
                    </div>
                </div>
            </div>
        </div> -->
        <?php } ?>
        <div class="name-account">
            <div class="name-account-avata">
                <a href="<?php echo shop_url($video) ?>">
                <?php
                $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                if($video->sho_dir_logo && $video->sho_logo){
                    $info_public_avatar_path = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' .$video->sho_dir_logo.'/'.$video->sho_logo;
                }
                ?>
                    <img class="avatar-personal js_avatar-personal img-circle" src="<?php echo $info_public_avatar_path ?>" alt="<?php echo htmlspecialchars( $siteGlobal->sho_name) ?>">
                </a>
            </div>
            <div class="name-account-text">
                <div class="tt one-line">
                    <a href="<?php echo shop_url($video) ?>"><?php echo $video->sho_name; ?></a>
                </div>
                <div class="small">
                    <div class="date"><?php echo date('d/m/Y', $video->not_begindate) ?></div>
                    <div class="view">
                        <img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt="">8K
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap-video-item js_action-play-popup" data-id="<?php echo $video->id ?>" data-news_id="<?php echo $video->not_id ?>" data-ref="<?php echo $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title) ?>" data-title="<?php echo $title ?>" data-type="<?php echo TYPESHARE_DETAIL_SHOPVIDEO ?>">
            <video class="detail-video <?php echo ($index == 0 && isset($auto_play)) ? 'autoplay' : '' ?>" preload="none"
                   data-id="<?php echo $video->id  ?>"
                   data-index="<?php echo $element_index ?>"
                   id="<?php echo $video_target ?>"
                   playsinline
                   data-target_video="#<?php echo $video_target ?>"
                   data-target_btn_volume=".js_btn-volume-<?php echo $video->id ?>"
                   data-target_btn_play=".<?php echo $btn_play_video ?>"
                   muted
                   poster="<?php echo $image_url;?>">
                <source src="<?php echo $video_url; ?>" type="video/mp4">
            </video>
            <img data-video-id="<?php echo $video_target ?>"
                 data-id="<?php echo $video->id ?>"
                 data-target_video="#<?php echo $video_target ?>"
                 class="btn-volume js_az-volume js_btn-volume-<?php echo $video->id ?>"
                 src="/templates/home/styles/images/svg/icon-volume-off.svg" width="32">
            <div data-video-id="<?php echo $video_target ?>"
                 data-target_video="#<?php echo $video_target ?>"
                 data-target_btn_play=".<?php echo $btn_play_video ?>"
                 class="pause js_btn-pause <?php echo $btn_play_video ?>">
                <img class="js_img-play" src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
            </div>
        </div>

        <?php if (!empty($video_title_xss)) { ?>
        <div class="text">
            <!-- <h3 class="js_action-play-popup" data-id="<?php echo $video->id ?>" data-news_id="<?php echo $video->not_id ?>" data-ref="<?php echo $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title) ?>" data-title="<?php echo $title ?>"><?php echo limit_the_string($video_title_xss) ?></h3> -->
            <div class="thaotac">
                <!-- <span class="xemthem js-open-menu-item">
                    <img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more">
                </span> -->
                <!-- <div class="show-more">
                    <ul class="show-more-detail">
                        <li><a href="JavaScript:Void(0);">Gửi dưới dạng tin nhắn</a></li>
                        <li><a href="JavaScript:Void(0);">Lưu ảnh</a></li>
                        <li><a href="JavaScript:Void(0);">Báo cáo ảnh</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
        <?php } ?>

        <div class="infor-account">
        <?php 
        $video_caption_xss_raw = strip_tags(trim($video_caption_xss));
        $video_caption_xss_process = strip_tags(trim($video_caption_xss));
        $String_data = $video_caption_xss_process != '' ? $video_caption_xss_process : '';
        $chars = preg_split('//u', $String_data, null, PREG_SPLIT_NO_EMPTY);
        $flag_process_string = false;
        $js_name_show = '';

        if ($isMobile == 0) {
            if(count($chars) > 150) {
                $offset = 0;
                $new_string = array_slice($chars, $offset, 150);
                $video_caption_xss_process = implode('', $new_string);
                $flag_process_string = true;
                $js_name_show = 'js-show-more_'.$video->id;
            }
        }

        if ($isMobile == 1) {
            if(count($chars) > 65) {
                $offset = 0;
                $new_string = array_slice($chars, $offset, 80);
                $video_caption_xss_process = implode('', $new_string);
                $flag_process_string = true;
                $js_name_show = 'js-show-more_'.$video->id;
            }
        }

        ?>
            <div class="infor-account-tt"><?php echo limit_the_string($video_title_xss); ?></div>
            <div class="infor-account-des js-viewport-get">
                <?php echo $video_caption_xss_process . ($flag_process_string == true ? '<span class="'.$js_name_show.'">... xem thêm</span>' : ''); ?>
            </div>
            <div class="like-share-cmt sm">
                <?php
                $show_video = $data_textlike = '';
                $numlike = $numshare = 0;
                if(!empty($video->likes)){
                    $show_video = ' js-show-like-video';
                    $numlike = $video->likes;
                }

                if (!empty($video->is_like)) { 
                    $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >';
                    $data_textlike = 'Bỏ thích';
                } else {
                    $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">';
                }
                
                if($video->not_id > 0) {
                    $li_shr = 1;
                }else{
                    $li_shr = 0;
                }

                if($video->total_share > 0){
                    $numshare = $video->total_share;
                }

                $arr = array(
                    'data_backblack' => 1,
                    'data_shr' => 1,
                    'data_class_countact' => 'js-countact-video-'.$video->id,
                    'data_jsclass' => 'js-like-video js-like-image-'.$video->id,
                    'data_classshow' => $show_video,
                    'data_url' => $news_link,
                    'data_title' => $title,
                    'data_id' => $video->id,
                    'data_imglike' => $imgLike,
                    'data_numlike' => $numlike,
                    'data_classshare' => 'js-list-share-video',
                    'data_numshare' => $numshare,
                    'data_lishare' => $li_shr,
                    'data_textlike' => $data_textlike,
                    'data_type' => TYPESHARE_DETAIL_SHOPVIDEO,
                    'data_tag' => "video"
                );

                $this->load->view('home/share/bar-btn-share', $arr); ?>
            </div>
        </div>

        
    </div>
</div>

<script>
    $('body').on('click', '.js-show-more_<?=$video->id?>', function () {
        var video_caption_raw = <?php echo json_encode(htmlspecialchars($video_caption_xss_raw))?>;
        var element = $(this).closest('.infor-account-des');
        $(element).html(video_caption_raw);
    })

    $('.js-detect-item-viewport').each(function () {
        var description = $(this).find('.js-viewport-get');
        var data_collapse = $(description).html();
        $(description).attr('data-showed', data_collapse);
    });
    $(window).on('resize scroll', function() {
        $('body').find('.js-detect-item-viewport').each(function () {
            var description = $(this).find('.js-viewport-get');
            // nếu chưa có data-showed thì add vào
            if($(this).attr('data-showed') == '') {
                var data_collapse = $(description).html();
                $(description).attr('data-showed', data_collapse);
            } else {
                // element has been scroll over
                if (!$(this).isInViewport()) {
                    var data_return = $(description).attr('data-showed');
                    $(description).html(data_return);
                }
            }
        });
    });

    // collapse seemore
    $.fn.isInViewport = function() {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).outerHeight();
        var viewportTop = $(window).scrollTop();
        var viewportBottom = viewportTop + $(window).height();
        return elementBottom > viewportTop && elementTop < viewportBottom;
    };
</script>