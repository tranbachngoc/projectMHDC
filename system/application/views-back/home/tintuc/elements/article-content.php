<div class="trangtinchitiet-content-item <?=$item->sClassBackgroundTwo?>" style="<?=$item->sBackgroundTwo;?>">
    <div class="item-content">
        <div class="text main-image">
            <h3><?php echo $item->not_title ?></h3>
            <div class="description">
                <?php echo $item->not_detail; ?>
            </div>
            <!--load additional icons-->
            <?php
            if(!empty($item->not_additional) && is_array($item->not_additional)) {
                foreach ($item->not_additional as $keyIcon => $icon) {
                    $this->load->view('home/tintuc/elements/item-icon', [
                        'icon'      => $icon,
                        'keyIcon'   => $keyIcon,
                        'image_dir' => $item->not_dir_image,
                        'domain_use' => $domain_use,
                    ]);
                }
            }
            ?>
        </div>
        <?php if(!empty($item->not_customlink)) { ?>
            <?php
            $iNumberLink = count($item->not_customlink);
            $type_slider = 'three-sliders';
            $class_no_image_video =  empty($has_image_video) && !$item->not_video_url1 ? 'version02' : 'has-video-image';

            if($item->type_show != STYLE_2_SHOW_CONTENT && $class_no_image_video == 'has-video-image'){
                $class_no_image_video = '';
            }

            if($iNumberLink == 1){
                $type_slider = 'one-slider';
            } elseif($iNumberLink == 2){
                $type_slider = 'two-sliders';
                if($class_no_image_video == 'version02'){
                    $type_slider = 'three-sliders';
                }
            }
            $rand = uniqid();

            ?>
            <div class="addlinkthem addlinkthem-detail <?php echo $type_slider !== 'one-slider' ? ' addlinkthem-detail-v3' : ''; ?> version01 <?php echo $class_no_image_video; ?>" id="addlinkthem-detail_01">
                <ul class="slider addlinkthem-slider <?php echo $type_slider; ?> " id="addlinkthem-slider_<?php echo $rand; ?>">
                    <?php foreach ($item->not_customlink as $kLink => $oLink) {
                        $this->load->view('home/tintuc/item-link-v2', [
                            'kLink'      => $kLink,
                            'link_v2'    => $oLink,
                            'domain_use' => $domain_use,
                        ]);
                    } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>
<div class="hr-main-content"></div>