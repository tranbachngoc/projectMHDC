<?php
if (!empty($image->sho_logo)) {
    $shop_image = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $image->sho_dir_logo . '/' . $image->sho_logo;
} else {
    $shop_image = '/templates/home/styles/avatar/default-avatar.png';
}

$image_caption_xss = strip_tags($image->content ? $image->content : $image->not_detail);
if($image->not_id == 0 && $image->img_up_detect == IMAGE_UP_DETECT_LIBRARY){
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/album/' . $image->img_library_dir . '/' . $image->name;
  $image_title       = trim($image->img_library_title);
  $image_title_xss   = $image->img_library_title;
} else {
  $image_url         = DOMAIN_CLOUDSERVER . 'media/images/content/' . $image->not_dir_image . '/' . $image->name;
  $image_title       = trim($image->not_title);
  $image_title_xss   = ($image->title ? $image->title : $image->not_title);
}

$element_index     = $index + $start;
$btn_play_video    = 'btn_play_image_' . $image->id;
$image_target      = 'content_image_' . $image->id;

$element_index = $index + $start;

$news_link = $shop_url . 'news/detail/' . $image->not_id . '/' . RemoveSign($image_title);

if(isset($album)){
    $share_name_img = $album->album_name;
}else{
    $share_name_img = $share_name;
}
$title_alt = str_replace('"', "", $image_title_xss);
$title_ = html_entity_decode($image_title_xss);
$title = convert_percent_encoding($title_);
?>
<div class="item item-id-<?php echo $image->id ?> item-index-<?php echo $element_index; ?> item-element-parent js_gallery_pop_image">
    <div class="detail"
         data-id="<?php echo $image->id ?>"
         data-type="image"
         data-title="<?php echo $this->filter->injection_html($image_title_xss); ?>"
         data-image="<?php echo $image->name ?>"
         data-tags='<?php echo json_encode([]) ?>'
         data-not_begindate='<?php echo date('d/m/Y', $image->not_begindate) ?>'
         data-image_url="<?php echo $image_url ?>"
         data-content_url="<?php echo $shop_url . 'news/detail/' . $image->not_id . '/' . RemoveSign($image_title) ?>"
         data-index="<?php echo $element_index ?>"
         data-image_size='<?php echo json_encode(['width' => $image->img_w, 'height' => $image->img_h]) ?>'
         data-news_id="<?php echo $image->not_id ?>"
         data-caption="<?php echo htmlspecialchars($image_caption_xss) ?>"
         data-key="<?php echo $image->id  ?>"
         data-shopid="<?php echo $shop_current->sho_id; ?>"
         data-shopname="<?php echo $shop_current->sho_name; ?>"
         data-linkpro_shop="<?php echo shop_url($shop_current); ?>"
         data-avatar="<?php echo DOMAIN_CLOUDSERVER.'media/shop/logos/'.$shop_current->sho_dir_logo.'/'.$shop_current->sho_logo; ?>"
         data-has_in_news="<?php echo ($image->img_up_detect == IMAGE_UP_DETECT_LIBRARY) ? 'false' : 'true'  ?>">
        <a href="<?php echo $news_link ?>"
            data-news_id="<?php echo $image->not_id ?>"
           class="js_action-play-popup"
           title="<?php echo $title_alt; ?>"
           target="_blank" data-id="<?php echo $image->id ?>" data-ref="<?php echo $news_link ?>" data-title="<?php echo $title;//$this->filter->injection_html($image_title_xss); ?>" data-value="<?=$share_url;?>" data-name="<?= $share_name_img ?>" data-type="<?php echo TYPESHARE_DETAIL_SHOPIMG ?>">
            <img src="<?php echo $image_url ?>"
                 alt="<?php echo $title_alt ?>"
                 class="lazyload detail-img"
                 title="<?php echo $title_alt ?>"
                 data-ori="<?=$image->orientation?>">
            <?php if($image->user_id != $sho_user) { ?><img class="avt" src="<?=$shop_image?>" alt=""><?php } ?>
        </a>
        <div class="text">
            <!-- <h3 class="js_action-play-popup" data-news_id="<?php echo $image->not_id ?>" data-ref="<?php echo $news_link ?>" data-title="<?php echo $this->filter->injection_html($image_title_xss); ?>" data-value="<?=$share_url;?>" data-name="<?=$share_name?>">
                <a href="<?php echo $news_link ?>"
                   title="<?php echo $title_alt ?>"
                   target="_blank"><?php echo limit_the_string($image_title_xss) ?></a>
            </h3> -->
            <?php if($is_owns == true && $this->session->userdata('sessionUser')) { ?>
            <div class="thaotac js-thao-tac">
                <span class="xemthem"><img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more"></span>
                <div class="hidden">
                <!-- <div class="show-more"> -->
                    <ul class="show-more-detail">
                        <li class="js-create-album" data-id="<?=$image->id?>"><a href="JavaScript:Void(0);">Tạo Album</a></li>
                        <li class="js-ghim-album" data-id="<?=$image->id?>"><a href="JavaScript:Void(0);">Lưu vào Album</a></li>
                        <?php
                        if($image->not_id > 0) {
                        ?>
                        <li class="share-click-image" data-toggle="modal" data-value="<?php echo $news_link ?>" data-name="<?php echo $title;?>" data-id="<?=$image->id;?>" data-type_imgvideo="<?php echo TYPESHARE_DETAIL_SHOPIMG ?>" data-tag="image">Chia sẻ</li>
                        <?php
                        }
                        ?>
                        <?php if($image->img_up_detect == IMAGE_UP_DETECT_LIBRARY) { ?>
                        <li class="js-delete-img-upload" data-id="<?=$image->id?>"><a href="JavaScript:Void(0);">Xóa ảnh trong thư viện</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } else if($is_owns == false) { ?>
            <div class="thaotac js-thao-tac">
                <span class="xemthem"><img class="mt05" src="/templates/home/styles/images/svg/3dot_doc.svg" alt="more"></span>
                <div class="hidden">
                <!-- <div class="show-more"> -->
                    <ul class="show-more-detail" data-id="<?php echo $image->id; ?>">
                        <?php
                        if($image->not_id > 0) {
                        ?>
                        <li class="share-click-image" data-toggle="modal" data-value="<?php echo $news_link ?>" data-name="<?php echo $title;?>" data-id="<?=$image->id;?>" data-type_imgvideo="<?php echo TYPESHARE_DETAIL_SHOPIMG ?>" data-tag="image">Chia sẻ</li>
                        <?php } ?>
                        <li>
                            <a href="#" style="border:none;" class="report-popup" data-rpd_type="3" data-media_id="<?php echo $image->not_id ?>" data-link="<?php echo $news_link.'?pop='.$image->id; ?>" data-rpd_image="<?php echo $image_url;?>" data-toggle="modal" data-target="#reportpopup">Báo cáo</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>
        
        <div class="like-share-cmt sm">
            <?php
            $show_image = $data_textlike = '';
            $numlike = $numshare = 0;
            if(!empty($image->likes)){
                $show_image = ' js-show-like-image';
                $numlike = $image->likes;
            }

            if (!empty($image->is_like)) { 
                $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >';
                $data_textlike = 'Bỏ thích';
            } else {
                $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">';
            }
            
            if($image->not_id > 0) {
                $li_shr = 1;
            }else{
                $li_shr = 0;
            }

            if($image->total_share > 0){
                $numshare = $image->total_share;
            }

            $arr = array(
                'data_backblack' => 1,
                'data_shr' => 1,
                'data_class_countact' => 'js-countact-image-'.$image->id,
                'data_jsclass' => 'js-like-image js-like-image-'.$image->id,
                'data_classshow' => $show_image,
                'data_url' => $news_link,
                'data_title' => $title,
                'data_id' => $image->id,
                'data_imglike' => $imgLike,
                'data_numlike' => $numlike,
                'data_classshare' => 'js-list-share-img',
                'data_numshare' => $numshare,
                'data_lishare' => $li_shr,
                'data_textlike' => $data_textlike,
                'data_type' => TYPESHARE_DETAIL_SHOPIMG
            );

            $this->load->view('home/share/bar-btn-share', $arr); ?>
        </div>
    </div>
</div>