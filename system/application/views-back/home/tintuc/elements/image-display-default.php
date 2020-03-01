<?php
    $oImageOption = json_decode($oImage->style);

    // Lấy chữ trên hình
    $text_images =  (array) @$oImageOption->text_list;
    // Hình nền
    $sBackgroundImage = '';
    $have_bg = 0;
    $sClass = '';
    if(isset($oImageOption->type_show) && $oImageOption->type_show == 'backgroundimage') {
        $sBackgroundImage = 'background-image: url('.$item->sLinkFolderImage.$oImage->image.')';
        $sClass = 'has-bg has-bg-img bg-overlay';
        $have_bg = 1;
    }

    if(isset($oImageOption->background) && $oImageOption->background != '') {
        if(strlen($oImageOption->background) > 7) {
            $oImageOption->background = '#'.substr($oImageOption->background,3,9);
        }

        if(!preg_match('/^#.+/im', $oImageOption->background)){
            $oImageOption->background = '#'. $oImageOption->background;
        }

        $sBackgroundImage = 'background:' . $oImageOption->background . '; color: ' . $oImageOption->color;
        $sClass = 'has-bg has-bg-color';
        if($oImageOption->background != '#ffffff' && $oImageOption->background != '#FFFFFF') {
            $have_bg = 1;
        }
    }
    $aListIconImage = '';
    if(property_exists($oImageOption, 'caption2') && $oImageOption->caption2) {
        $aListIconImage = $oImageOption->caption2;
    }
    
    $imgeffect = property_exists($oImageOption, 'imgeffect') ? $oImageOption->imgeffect : '';
    $sClassAnimated = '';
    if(isset($oImageOption->texteffect) && $oImageOption->imgeffect != '') {
        $sClassAnimated = 'animated hiding';
    }
    // Text effect

    $texteffect = property_exists($oImageOption, 'texteffect') ? $oImageOption->texteffect : '';
    $sClasstextA = '';
    if(isset($oImageOption->texteffect) && $oImageOption->texteffect != '') {
        $sClasstextA = 'animated hiding';
    }

    // Tag
    $aTags = $oImage->tags;

    $rand_id = rand();
    if(!isset($share_name)){
        $share_name = '';
    }
    if(!isset($share_url)){
        $share_url = '';
    }
?>

<div id="block_image_<?=$oImage->id;?>"
     class="trangtinchitiet-content-item <?=$sClassAnimated?> item04 block-image <?=$sClass?>"
     style="<?=$sBackgroundImage?>"
     data-animation="<?=$imgeffect;?>"
     data-delay="500">
    <?php if (property_exists($oImageOption,'audio') && $oImageOption->audio) {
        $url_audio = $oImageOption->audio;
        if(!filter_var($oImageOption->audio, FILTER_VALIDATE_URL)) {
            $url_audio = DOMAIN_CLOUDSERVER . 'media/musics/' . $oImageOption->audio;
        }?>
        <audio preload="false" id="audio<?php echo $oImage->id ?>" src="<?php echo $url_audio; ?>"></audio>
        <img id="volume_audio<?php echo $oImage->id ?>"
             data-id="audio<?php echo $oImage->id ?>"
             class="az-volume" src="/templates/home/styles/images/svg/icon-volume-off.svg" data-status="off"/>
    <?php } ?>
    <div class="item-content">
        <?php if (property_exists($oImage,'product') && $oImage->product && $this->session->userdata('sessionUser') != '' && $this->session->userdata('sessionUser') == $sho_user) : ?>
            <div class="button-chinh-sua">
                <a href="<?php echo base_url() . 'tintuc/editnewhome/' . $item->not_id; ?>"
                   target="_blank">
                    <img src="/templates/home/styles/images/svg/pen.svg" alt="">Chỉnh sửa
                </a>
            </div>

        <?php endif; ?>
        <div class="image position-tag">
            <!-- Check hình gif -->
            <img id="image_<?=$oImage->id;?>"
                 data-id="<?=$oImage->id;?>"
                 src="<?php echo $item->sLinkFolderImage.$oImage->image; ?>"
                 class="popup-detail-image <?=in_array($oImage->orientation, [-90, 270]) ? 'rotate-l-90' : ($oImage->orientation == 90 ? 'rotate-r-90' : ($oImage->orientation == 180 ? 'rotate-180' : '') )?>"
                 data-news-id="<?php echo $item->not_id ?>"
                 data-key="<?php echo $key_img; ?>"
                 src="<?php echo $image_url ?>" data-name="<?php echo $share_name; ?>" data-value="<?php echo $share_url; ?>" data-type="<?php echo $type_shrimg; ?>">
            <!-- tags photo -->
            <?php
                if(isset($aTags) && !empty($aTags)) { 
                    $count_tags = count($aTags);
                } else {
                    $count_tags = 0;
                } 
            ?>
            <div class="popup-detail-image  fs-gal hide_<?php echo $count_tags ?> tag-number-selected"
                 data-parent="<?php echo $item->not_id . $random; ?>"
                 data-url="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $oImage->image ?>"
                 data-tags="<?php echo $count_tags > 0 ? htmlspecialchars(json_encode($aTags)): '{}'; ?>"
                 data-news-id="<?php echo $item->not_id; ?>"
                 data-key="<?php echo $key_img ?>" data-name="<?php echo $share_name; ?>" data-value="<?php echo $share_url; ?>" data-type="<?php echo $type_shrimg; ?>">
                    <img src="<?php echo base_url() .'templates/home/icons/boxaddnew/tag.svg'; ?>" alt="" style="max-width: 32px">
                    <span class="number"><?php echo $count_tags; ?></span>
            </div>
            <!-- tags photo -->
            <?php
                if(!empty($text_images)){
                    $this->load->view('home/tintuc/elements/text-in-image', [
                        'text_images' => $text_images,
                        'iImageId'    => $oImage->id
                    ]);
                }
            ?>
            
        </div>
        <div class="text">
            <?php
            $title_shr = '';
            if(isset($oImage->title) && $oImage->title !='')
            {
                $title_shr = convert_percent_encoding(html_entity_decode($oImage->title));
            ?>
                <h3 class="tit <?=$sClasstextA?>" data-animation="<?=$texteffect;?>" data-delay="500"><?php echo html_entity_decode($oImage->title) ?></h3>
            <?php
            }
            else{
                if(isset($oImage->caption) && $oImage->caption !='') {
                    $title_shr = convert_percent_encoding(html_entity_decode(htmlspecialchars_decode($oImage->caption)));
                }
            }
            ?>
            <?php if(isset($oImage->caption) && $oImage->caption !='') { ?>
                <p class="mb10 <?=$sClasstextA?>" data-animation="<?=$texteffect;?>" data-delay="500"><?php echo html_entity_decode(nl2br($oImage->caption)); ?></p>
            <?php } ?>
            <?php
            if(!empty($aListIconImage)) {
                foreach ($aListIconImage as $keyIcon => $icon) {
                    $this->load->view('home/tintuc/elements/item-icon', [
                        'icon'      => $icon,
                        'keyIcon'   => $keyIcon,
                        'image_dir' => $item->not_dir_image,
                        'domain_use' => $domain_use
                    ]);
                }
            }
            ?>
        </div>
        <?php if(!empty($oImage->content_image_links)) { ?>
            <?php
            $iNumberLink = count($oImage->content_image_links);
            $type_slider = 'three-sliders';
            if($iNumberLink == 1){
                $type_slider = 'one-slider';
            } elseif($iNumberLink == 2){
                $type_slider = 'two-sliders';
            }
            $rand_id = rand();
            ?>
            <div class="root-images" style="position: relative">
                <div class="addlinkthem addlinkthem-detail <?php echo $type_slider !== 'one-slider' ? 'addlinkthem-detail-v3' : ''; ?> <?php echo $item->type_show == STYLE_2_SHOW_CONTENT ? 'has-video-image' : '' ?> version01">
                    <ul class="slider addlinkthem-slider <?php echo $type_slider;?> <?php echo $item->type_show == STYLE_2_SHOW_CONTENT ? 'has-video-image' : '' ?>"
                        id="addlinkthem-slider_<?php echo $rand_id; ?>">
                        <?php foreach ($oImage->content_image_links as $kLink => $oLink) {
                            $this->load->view('home/tintuc/item-link-v2', [
                                'kLink'      => $kLink,
                                'link_v2'    => $oLink,
                                'domain_use' => $domain_use
                            ]);
                        } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <?php 
            //phần comment phía dưới
            $product = array();
            $afkey = $afkey ? $afkey : '';
            if (!empty($oImage->product)) {
                $product    = $oImage->product;
            }
            $external_link = '';
            if(property_exists($oImage, 'detail') && $oImage->detail != ''){
                $external_link  = $oImage->detail;
            }
            $this->load->view('home/tintuc/elements/news_actions', [
                'product'       => $product,
                'afkey'         => $afkey,
                'external_link' => $external_link,
                'have_bg'       => $have_bg,
                'title_shr' => $title_shr,
                'type_shr_imgvideo' => $type_shrimg
            ]);
        ?>
    </div>
</div>
