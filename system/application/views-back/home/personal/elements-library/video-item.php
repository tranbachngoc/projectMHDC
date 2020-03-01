<?php
$video_title_xss   = ($video->title ? $video->title : $video->not_title);
$video_caption_xss = strip_tags($video->description ? $video->description : $video->not_detail);
$video_url         = DOMAIN_CLOUDSERVER . 'video/' . $video->name;
$image_url         = $video->thumbnail ? (DOMAIN_CLOUDSERVER . 'video/thumbnail/' . $video->thumbnail) : DEFAULT_IMAGE_ERROR_PATH;
$element_index     = $index + $start;
$video_name_old    = str_replace('.', '', $video->not_video_url1);
$btn_play_video    = 'btn_play_video_' . $video_name_old .'_'. $video->not_id;
$video_target      = 'content_video_' . $video_name_old .'_'. $video->not_id;
$news_link = $current_profile['profile_url'] . 'news/detail/' . $video->not_id;// . '/' . RemoveSign($video->not_title)

// if($video->not_id > 0){
//     $linkpro_shop = shop_url($video->shop);
//     $avatar = DOMAIN_CLOUDSERVER.'media/shop/logos/'.$video->shop->sho_dir_logo.'/'.$video->shop->sho_logo;
//     $sho_name = $video->shop->sho_name;
// }else{
    $avatar = '/templates/home/styles/avatar/default-avatar.png';
    if(!empty($current_profile['avatar'])){
        $avatar = $current_profile['avatar_url'];
    }
    $linkpro_shop = $current_profile['profile_url'];
    $sho_name = $current_profile['use_fullname'];
// }
$tit = $video_title_xss;
if($video_title_xss == ''){
    $tit = strip_tags($video_caption_xss);
}

$title_alt = str_replace('"', "", $tit);
$title_ = html_entity_decode($tit);
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
         data-content_url="<?php echo $news_link; ?>"
         data-index="<?php echo $element_index ?>"
         data-image_size='<?php echo json_encode(['width' => $video->width, 'height' => $video->height]) ?>'
         data-news_id="<?php echo $video->not_id ?>"
         data-caption="<?php echo htmlspecialchars($video_caption_xss) ?>"
         data-key="<?php echo $video->id  ?>"
         data-shopid="<?php echo $video->shop->sho_id; ?>"
         data-shopname="<?php echo $sho_name; ?>"
         data-linkpro_shop="<?php echo $linkpro_shop; ?>"
         data-avatar="<?php echo $avatar; ?>"
         >

        <?php if (!empty($current_profile)) { ?>
        <div class="name-account">
            <div class="name-account-avata">
                <a href="<?php echo !empty($current_profile->profile_url) ?  $current_profile->profile_url: '' ?>">
                <?php
                $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                if (!empty($current_profile['avatar_url'])) 
                {
                    $info_public_avatar_path = $current_profile['avatar_url'];
                }
                ?>
                    <img class="avatar-personal js_avatar-personal img-circle" src="<?php echo $info_public_avatar_path ?>" alt="<?php echo htmlspecialchars( $current_profile['use_fullname']) ?>">
                </a>
            </div>
            <div class="name-account-text">
                <div class="tt one-line">
                    <a href="<?php echo !empty($current_profile['profile_url']) ?  $current_profile['profile_url']: '' ?>"><?php echo $current_profile['use_fullname']; ?></a>
                </div>
                <div class="small">
                    <div class="date"><?php echo date('d/m/Y', $video->not_begindate) ?></div>
                    <div class="view">
                        <img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt="">8K
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="wrap-video-item js_action-play-popup" data-id="<?php echo $video->id ?>" data-news_id="<?php echo $video->not_id ?>" data-ref="<?php echo $news_link; ?>" data-title="<?php echo $title ?>" data-type="<?php echo TYPESHARE_DETAIL_PRFVIDEO ?>">
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
            <!-- <h3 class="js_action-play-popup" data-id="<?php echo $video->id ?>" data-news_id="<?php echo $video->not_id ?>" data-ref="<?php echo $current_profile['profile_url'] . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title) ?>" data-title="<?php echo $title ?>"><?php echo limit_the_string($video_title_xss) ?></h3> -->
            <div class="thaotac">
                <!-- <span class="xemthem">
                    <img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more">
                </span>
                <div class="show-more">
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
        $video_title_xss_raw = strip_tags(trim($video_title_xss));
        $video_title_xss_process = strip_tags(trim($video_title_xss));

        $String_data = $video_title_xss_process != '' ? $video_title_xss_process : '';
        $chars = preg_split('//u', $String_data, null, PREG_SPLIT_NO_EMPTY);
        $flag_process_string = false;
        $js_name_show = '';

        if ($isMobile == 0) {
            if(count($chars) > 150) {
                $offset = 0;
                $new_string = array_slice($chars, $offset, 150);
                $video_title_xss_process = implode('', $new_string);
                $flag_process_string = true;
                $js_name_show = 'js-show-more_'.$video->id;
            }
        }

        if ($isMobile == 1) {
            if(count($chars) > 65) {
                $offset = 0;
                $new_string = array_slice($chars, $offset, 80);
                $video_title_xss_process = implode('', $new_string);
                $flag_process_string = true;
                $js_name_show = 'js-show-more_'.$video->id;
            }
        }
        
        ?>
            <div class="infor-account-des js-viewport-get"><?php echo $video_title_xss_process . ($flag_process_string == true ? '<span class="'.$js_name_show.'">... xem thêm</span>' : ''); ?></div>
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
                        'data_type' => TYPESHARE_DETAIL_PRFVIDEO,
                        'data_tag' => "video"
                    );
                    $this->load->view('home/share/bar-btn-share', $arr); 
                ?>
            </div>
        </div>


    </div>
</div>

<script>
    $('body').on('click', '.js-show-more_<?=$video->id?>', function () {
        var video_caption_raw = <?php echo json_encode(htmlspecialchars($video_title_xss_raw))?>;
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