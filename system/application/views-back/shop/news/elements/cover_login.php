<?php
$list_branch = $shop_current->list_branch;
?>
<div class="cover-part cover-login">
    <?php
    $path_banner_img = '/templates/home/images/cover/cover_me.jpg';
    if($siteGlobal->sho_dir_banner && $siteGlobal->sho_banner){
        $path_banner_img = $this->config->item('banner_shop_config')['cloud_server_show_path'] . '/' .$siteGlobal->sho_dir_banner.'/'.$siteGlobal->sho_banner;
    }
    ?>
    <div class="wrap-edit-cover-part">
        <img class="js_image-cover-show" onerror="error_image_cover(this)" src="<?php echo $path_banner_img ?>" data-src-img-old="<?php echo $path_banner_img ?>" alt="<?php echo htmlspecialchars( $siteGlobal->sho_name) ?>">
    </div>

    <div class="wrap-edit-cover-image">
        <div class="button-modify js-button-change-cover">
            <img src="/templates/home/images/svg/pen.svg">Chỉnh sửa
        </div>
        <div class="button-modify js-button-save-cover hidden">
            <img class="filter" src="/templates/home/styles/images/svg/apply.svg">Lưu
        </div>
        <div class="button-modify js-button-cancel-cover hidden">
            <img class="filter" src="/templates/home/styles/images/svg/cancel.svg">Hủy
        </div>
    </div>

    <form class="js-submit-form-upload-image" method="post" enctype="multipart/form-data">
        <input type="file" name="banner_res" class="hidden js-personal-change-cover">
    </form>
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
            <img class="avatar-personal js_avatar-personal img-circle" src="<?php echo $info_public_avatar_path ?>" alt="<?php echo htmlspecialchars( $siteGlobal->sho_name) ?>">
            <div class="edit">
                <span class="wrap-icon-edit js_open-pop-edit-avatar"><img  src="/templates/home/styles/images/svg/pen.svg" alt=""></span>
                <form class="js-submit-form-upload-avatar" method="post" enctype="multipart/form-data">
                    <input type="file" name="logo_res" class="hidden js-personal-change-avatar">
                </form>
            </div>

        </div>
        <div class="avata-title">
            <span><?php echo $siteGlobal->sho_name; ?></span>
        </div>
    </div>
    <div class="avata-part-right">
        <div></div>
        <div class="danhsach-chinh-sua">
            <div class="chinh-sua sm-bg-gray hide_0">
                <img class="icon md" src="/templates/home/styles/images/svg/chinhsua.svg">
                <img class="icon sm" src="/templates/home/styles/images/svg/chinhsua_gray.svg">
                <span class="md">Chỉnh sửa</span>
            </div>
            <div class="chinh-sua sm-bg-gray hide_0">
                <a href="">
                    <img src="/templates/home/styles/images/svg/comment_3dot_white.svg" class="icon md">
                    <img src="/templates/home/styles/images/svg/comment_3dot.svg" class="icon sm">
                </a>
            </div>
            <?php
            $data_itemid = '';
            if(isset($itemid_shr)){
                $data_itemid = $itemid_shr;
            }
            ?>
            <div class="chinh-sua sm-bg-gray">
                <a class="share-click text-white" data-toggle="modal" data-value="<?php echo $share_url;?>" data-name="<?= $share_name;?>" data-type="<?php echo $type_share; ?>" data-item_id="<?php echo $data_itemid; ?>" data-url_page="<?php echo $share_url; ?>" data-permission="<?php echo ($this->session->userdata('sessionUser') == $sho_user) ? 1 : '';?>">
                    <img class="icon md" src="/templates/home/styles/images/svg/share_white01.svg">
                    <img class="icon sm" src="/templates/home/styles/images/svg/share<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg">
                    <span class="md">Chia sẻ</span>
                </a>
            </div>
            <div class="xemthem sm-bg-gray">
                <a href="javascript:void(0)" class="js-shortcut-menu-shop" data-toggle="modal" data-target="#js-modal-shortcut-menu-shop">
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
    <?php echo $this->load->view('/home/personal/elements/popup_edit_avatar'); ?>
    <?php echo $this->load->view('/home/personal/elements/popup_menu_shortcut')?>
</div>