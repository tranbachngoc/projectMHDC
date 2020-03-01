<div class="cover-part">
    <?php
    $path_cover_img = '/templates/home/images/cover/cover_me.jpg';
    if($current_profile['use_cover']){
        $path_cover_img = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $current_profile['use_id'] . '/' . $current_profile['use_cover'];
    }
    ?>
    <div class="wrap-edit-cover-part">
        <img class="js_image-cover-show" src="<?php echo $path_cover_img ?>" data-src-img-old="<?php echo $path_cover_img ?>" alt="<?php echo htmlspecialchars( $current_profile['use_fullname']) ?>" onerror="error_image_cover(this)">
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
        <input type="file" name="cover_res" class="hidden js-personal-change-cover">
        <input type="submit" value="Tải lên" id="upload_btn" class="hidden">
    </form>
</div>
<div class="avata-part avata-part-trangcanhan">
    <div class="avata-part-left">
        <div class="avata-img">
            <?php
            $current_profile_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
            if(!empty($current_profile['avatar'])){
                $current_profile_avatar_path = $current_profile['avatar_url'];
            } ?>
            <img class="avatar-personal js_avatar-personal" onerror="image_error(this)" src="<?php echo $current_profile_avatar_path ?>" alt="<?php echo htmlspecialchars($current_profile['use_fullname']) ?>">
            <div class="edit">
                <span class="wrap-icon-edit js_open-pop-edit-avatar">
                    <img  src="/templates/home/styles/images/svg/pen.svg" alt="">
                </span>
                <form class="js-submit-form-upload-avatar" method="post" enctype="multipart/form-data">
                    <input type="file" name="avatar_res" class="hidden js-personal-change-avatar">
                </form>
            </div>

        </div>
        <div class="avata-title">
            <span><?php echo $current_profile['use_fullname']; ?></span>
            <?php if($show_sub_aff == true) {
                $affiliate_parent = $this->session->userdata('affiliate_parent');
                if(!empty($affiliate_parent)) {
                    $lv = $affiliate_parent['affiliate_level'];
                }elseif ($this->session->userdata('sessioniAFLevel')) {
                    $lv = $this->session->userdata('sessioniAFLevel');
                }
                
                $names = [
                    0 => 'Thành viên thường',
                    1 => 'Nhà phân phối',
                    2 => 'Tổng đại lý',
                    3 => 'Đại lý',
                ];
                echo "<span> | {$names[$lv]}</span>";
            }?>
        </div>
    </div>
    <div class="avata-part-right __part-right-personal">
        <?php if($show_sub_aff == true) { ?>

        <div></div>
        <div class="danhsach-chinh-sua">
            <div class="chinh-sua btn-border-gray" style="cursor: pointer;">
              <img class="icon mr05" src="/templates/home/styles/images/svg/settings.svg" alt="">
              <span id="chose_parent">Hệ thống của <?= isset($is_parent['name']) ? $is_parent['name'] : 'Azibai' ?></span>
            </div>
            <?php if(isset($show_affiliate_menu) && $show_affiliate_menu == 1) {?>
                <a class="chinh-sua btn-border-gray mr00" href="<?=azibai_url('/affiliate-invite')?>">
                    <img class="icon mr05" src="/templates/home/styles/images/svg/circle-plus-gray.svg" alt="">
                    <span>Mời thành viên</span>
                </a>
            <?php } ?>
        </div>

        <?php } else { ?>

        <div></div>
<!--        <div class="danhsach-chinh-sua">-->
<!--            <div class="chinh-sua mr15 sm-bg-gray">-->
<!--                <img class="icon md" src="/templates/home/styles/images/svg/chinhsua.svg">-->
<!--                <img class="icon sm" src="/templates/home/styles/images/svg/chinhsua_gray.svg">-->
<!--                <span class="tablet-none">Chỉnh sửa</span>-->
<!--            </div>-->
<!--        </div>-->
        <?php
        $data_itemid = '';
        if(isset($itemid_shr)){
            $data_itemid = $itemid_shr;
        }
        ?>
        <div class="chinh-sua sm-bg-gray">
            <a class="share-click" data-toggle="modal" data-name="<?php echo $share_name; ?>" data-value="<?php echo $share_url; ?>" data-type="<?php echo $type_share; ?>" data-item_id="<?php echo $data_itemid; ?>" data-url_page="<?php echo $share_url; ?>" data-permission="<?php echo ($this->session->userdata('sessionUser') == $current_profile['use_id']) ? 1 : '';?>">
                <img class="icon md" src="/templates/home/styles/images/svg/share_white01.svg">
                <img class="icon sm" src="/templates/home/styles/images/svg/share<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg">
                <span class="md">Chia sẻ</span>
            </a>
        </div>
        <div class="danhsach-chinh-sua">
            <div class="xemthem sm-bg-gray">
                <img src="/templates/home/styles/images/svg/3dot_doc_white.svg" class="md">
                <img src="/templates/home/styles/images/svg/3dot_doc<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg" class="sm">
            </div>
        </div>

        <?php } ?>
    </div>
</div>

<?php echo $this->load->view('home/personal/elements/popup-edit-info-profile.php') ?>