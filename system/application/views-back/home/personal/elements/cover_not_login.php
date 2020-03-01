<div class="cover-part">
    <?php
    $path_cover_img = '/templates/home/images/cover/cover_me.jpg';
    if($current_profile['use_cover']){
        $path_cover_img = $this->config->item('cover_user_config')['cloud_server_show_path'] . '/' . $current_profile['use_id'] . '/' . $current_profile['use_cover'];
    }
    ?>
    <img src="<?php echo $path_cover_img ?>" alt="<?php echo htmlspecialchars( $current_profile['use_fullname']) ?>">
</div>
<div class="avata-part avata-part-trangcanhan">
    <div class="avata-part-left">
        <div class="avata-img">
            <?php
            $current_profile_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
            if(!empty($current_profile['avatar'])){
                $current_profile_avatar_path = $current_profile['avatar_url'];
            } ?>
            <img src="<?php echo $current_profile_avatar_path ?>" onerror="error_image_cover(this)" alt="<?php echo htmlspecialchars($current_profile['use_fullname']) ?>">
        </div>
        <div class="avata-title">
            <span><?php echo $current_profile['use_fullname']; ?></span>
        </div>
    </div>
    <div class="avata-part-right __part-right-friend">
        <?php if($show_sub_aff == true) { ?>

        <div></div>
        <div class="danhsach-chinh-sua">
            <a class="chinh-sua btn-border-gray mr00" href="<?=azibai_url('/affiliate-invite')?>">
                <img class="icon md" src="/templates/home/styles/images/svg/circle-plus-gray.svg" alt="">
                <img class="icon sm" src="/templates/home/styles/images/svg/circle-plus.svg" alt="">
                <span>Mời thành viên</span>
            </a>
        </div>

        <?php } else { ?>

        <div class="add-friends">
            <?php
            if(!empty($userBlock)){
            ?>
            <div class="ketban">
                <div class="ketban-btn">
                    <span class="cancel-block cancel-block-<?php echo $current_profile['use_id']; ?>" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Bỏ chặn
                    </span>
                </div>
            </div>
            <?php
            }else
            {
            ?>
            <div class="ketban">
                <?php

                if(isset($IsFriend) && $IsFriend == 1){
                    $Friend = '';
                    $noFriend = ' hidden';
                }else{
                    $Friend = ' hidden';
                    $noFriend = '';
                }

                $removeFoll = ' hidden';
                if(isset($add_friend) && $add_friend == 1){
                    $removeFoll = ' ketban-mess';
                }
                ?>
                <div class="banbe<?php echo $Friend;?>">
                    <div class="ketban-btn">
                        <span>Bạn bè</span>
                        <img src="/templates/home/styles/images/svg/down_1.svg" class="ico-down md" alt="">
                    </div>
                    <div class="ketban-mess">
                        <p><label class="unfriend" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Hủy bạn bè</label></p>
                        <p><label class="block-friend block-friend-<?php echo $current_profile['use_id']; ?>" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Chặn</label></p>
                    </div>
                </div>
                <div class="choxacnhan<?php echo $noFriend;?>">
                    <div class="ketban-btn btn-friend-<?php echo $current_profile['use_id']; ?><?php echo $jsclass_ ?>" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">
                        <!-- <img src=""> -->
                        <span class=""><?php echo $statusFriend ?></span>
                    </div>
                    <div class="xoaloimoi<?php echo $removeFoll;?>">
                        <p><label class="js-removefollow-user" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Xóa lời mời kết bạn</label></p>
                    </div>
                    <?php
                    if(isset($isaddFriend) && $isaddFriend == 1){
                        ?>
                        <div class="ketban-mess xacnhanFollow">
                            <p><label class="confirm-friend" data-id="<?php echo $current_profile['use_id']; ?>">Xác nhận</label></p>
                            <p><label class="js-deletefollow-user" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Xóa yêu cầu kết bạn</label></p>
                            <p><label class="block-friend block-friend-<?php echo $current_profile['use_id']; ?>" data-id="<?php echo $current_profile['use_id']; ?>" data-name="<?php echo $current_profile['use_fullname']; ?>">Chặn</label></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="ketban">
                <?php
                $isFollow = ' hidden';
                $noFollow = '';

                if (isset($getFollow) && !empty($getFollow))
                {
                    if($getFollow[0]->hasFollow == 1){
                        $isFollow = '';
                        $noFollow = ' hidden';
                    }

                    if($getFollow[0]->priority == 1){
                        $priority = 1;
                    }
                }
                ?>
                <div class="isFollow<?php echo $isFollow;?>">
                    <div class="ketban-btn" data-id="<?php echo $current_profile['use_id']; ?>">
                        <span class="theodoi">Đang theo dõi</span>
                    </div>
                    <div class="ketban-mess">
                        <p>
                            <?php
                            if($priority == 1){
                            ?>
                            <a class="cancel-priority-follow cancel-priority-follow-<?php echo $current_profile['use_id']; ?>" data-id="<?php echo $current_profile['use_id']; ?>">Bỏ ưu tiên theo dõi</a>
                            <?php
                            }else{
                            ?>
                            <a class="priority-follow priority-follow-<?php echo $current_profile['use_id']; ?>" data-id="<?php echo $current_profile['use_id']; ?>">Ưu tiên theo dõi</a>
                            <?php
                            }
                            ?>
                        </p>
                        <p><a class="cancel-follow" data-id="<?php echo $current_profile['use_id']; ?>">Bỏ theo dõi</a></p>
                    </div>
                </div>
                <div class="noFollow<?php echo $noFollow;?>">
                    <div class="ketban-btn is-follow" data-id="<?php echo $current_profile['use_id']; ?>">
                        <span class="theodoi">Theo dõi</span>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <div class="danhsach-chinh-sua">
            <div class="chinh-sua mr15 sm-bg-gray">
                <img src="/templates/home/styles/images/svg/message_white.svg" class="icon md">
                <img src="/templates/home/styles/images/svg/comment<?php echo isset($color_icon) && $color_icon == 'white' ? '_white' : '' ?>.svg" class="icon sm">
                <span class="tablet-none">Tin nhắn</span>
            </div>
        </div>
        <div class="chinh-sua sm-bg-gray">
            <a class="share-click" data-toggle="modal" data-name="<?php echo $share_name; ?>" data-value="<?php echo $share_url; ?>">
                <img class="icon md" src="/templates/home/styles/images/svg/share_white01.svg">
                <img class="icon sm" src="/templates/home/styles/images/svg/share<?php echo isset($color_icon) && $color_icon == 'white' ? '_white01' : '' ?>.svg">
                <span class="md">Chia sẻ</span>
            </a>
        </div>
        <div class="danhsach-chinh-sua">
            <div class="xemthem sm-bg-gray">
                <img src="/templates/home/styles/images/svg/3dot_doc_white.svg" class="md">
                <img src="/templates/home/styles/images/svg/3dot_doc<?php echo isset($color_icon) && $color_icon == 'white' ? '_white' : '' ?>.svg" class="sm">
            </div>
        </div>

        <?php } ?>
    </div>
</div>