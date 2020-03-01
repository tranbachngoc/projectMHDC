<?php
$list_branch = $shop_current->list_branch;
?>
<div class="cover-part">
    <?php
    $path_banner_img = '/templates/home/images/cover/cover_me.jpg';
    if($siteGlobal->sho_dir_banner && $siteGlobal->sho_banner){
        $path_banner_img = $this->config->item('banner_shop_config')['cloud_server_show_path'] . '/' .$siteGlobal->sho_dir_banner.'/'.$siteGlobal->sho_banner;
    }
    ?>
    <img onerror="error_image_cover(this)" src="<?php echo $path_banner_img ?>" alt="<?php echo htmlspecialchars($siteGlobal->sho_name); ?>">
</div>
<div class="avata-part avata-part-tindoanhnghiep">
    <div class="avata-part-left">
        <div class="avata-img">
            <?php
            $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
            if($siteGlobal->sho_dir_logo && $siteGlobal->sho_logo){
                $info_public_avatar_path = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' .$siteGlobal->sho_dir_logo.'/'.$siteGlobal->sho_logo;
            }
            ?>
            <img class="img-circle" src="<?php echo $info_public_avatar_path ?>" alt="<?php echo htmlspecialchars($siteGlobal->sho_name) ?>">
        </div>
        <div class="avata-title">
            <span><?php echo $siteGlobal->sho_name; ?></span>
        </div>
    </div>
    <div class="avata-part-right">
        <div class="ketban">
            <?php
            if(isset($follow) && $follow == 1){
                $isFollow = '';
                $noFollow = ' hidden';
            }else{
                $isFollow = ' hidden';
                $noFollow = '';
            }
            ?>
            <div class="isFollow-<?php echo $sho_id; ?><?php echo $isFollow;?>">
                <div class="ketban-btn" data-id="<?php echo $sho_id; ?>">
                    <span class="theodoi">Đang theo dõi</span>
                </div>
                <div class="ketban-mess">
                    <p><a class="cancel-follow-shop" data-id="<?php echo $sho_id; ?>">Bỏ theo dõi</a></p>
                </div>
            </div>
            <div class="noFollow-<?php echo $sho_id; ?><?php echo $noFollow;?>">
                <div class="ketban-btn is-follow-shop" data-id="<?php echo $sho_id; ?>">
                    <span class="theodoi">Theo dõi</span>
                </div>
            </div>
        </div>
        <div class="danhsach-chinh-sua">
            <div class="chinh-sua sm-bg-gray js_tel">
                <a href="tel:<?php echo $siteGlobal->sho_mobile ? $siteGlobal->sho_mobile : ($siteGlobal->sho_phone ? $siteGlobal->sho_phone : '') ?>">
                    <img src="/templates/home/styles/images/svg/tel_white.svg" class="icon md">
                    <img src="/templates/home/styles/images/svg/tel<?php echo isset($color_icon) && $color_icon == 'white' ? '_white' : '' ?>.svg" class="icon sm">
                    <span class="tablet-none">Gọi điện</span>
                </a>
            </div>
            <div class="chinh-sua sm-bg-gray js_message">
                <img src="/templates/home/styles/images/svg/comment_3dot_white.svg" class="icon md" alt="">
                <img src="/templates/home/styles/images/svg/comment_3dot<?php echo isset($color_icon) && $color_icon == 'white' ? '_white' : '' ?>.svg" class="icon sm" alt="">
                <span class="tablet-none">Tin nhắn</span>
            </div>
            <div class="chinh-sua sm-bg-gray">
                <a class="share-click text-white" data-toggle="modal" data-value="<?=$share_url;?>" data-name="<?=$share_name;?>" data-type="<?php echo $type_share; ?>" data-item_id="">
                    <img class="icon md" src="/templates/home/styles/images/svg/share_white01.svg">
                    <img class="icon sm" src="/templates/home/styles/images/svg/share<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg">
                    <span class="md">Chia sẻ</span>
                </a>
            </div>
            <div class="xemthem sm-bg-gray">
                <a href="#">
                    <img class="icon md" src="/templates/home/styles/images/svg/3dot_doc_white.svg">
                    <img class="icon sm" src="/templates/home/styles/images/svg/3dot_doc<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg">
                </a>
            </div>
            <?php if(!empty($list_branch) && $shop_current->group_user == AffiliateStoreUser) { ?>
            <div class="xemthem sm-bg-gray icon-show-list-branchs">
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
            <?php } ?>
        </div>
    </div>
</div>