<?php $class_default_sidebar = !isset($info_public) ? 'sidebar-right' : ''?>
<?php 
    $avatar_link        = DOMAIN_CLOUDSERVER . 'media/images/avatar/';
    $sLinkFolderImage   = DOMAIN_CLOUDSERVER . 'media/images/content/';
    $linkshop = ($item->domain != '') ? 'http://' . $item->domain : '//' . $item->sho_link . '.' . domain_site;
?>
<div class="<?php echo $class_default_sidebar ?>">
    <div class="list-related-detail">
        <h2 class="title">TIN LIÊN QUAN</h2>
        <?php if(isset($list_related) && !empty($list_related)) { ?>
            <?php foreach ($list_related as $iKeyNewRe => $oNewRe) { ?>
                <?php
                    $domain_use_related = shop_url($oNewRe);
                    if (!empty($_REQUEST['af_id'])) {
                        $afkey = '?af_id=' . $_REQUEST['af_id'];
                    }else {
                        $afkey= '';
                    }
                    //http://azibai.xxx/tintuc/detail/2922/dang-tin
                    if(empty($oNewRe->show_shop)){
                        $item_link = base_url() . explode('/',$_SERVER['REQUEST_URI'])[1] .'/detail/' . $oNewRe->not_id . '/' . RemoveSign($oNewRe->not_title) . $afkey;
                    }else{
                        $shopdomain = $oNewRe->domain ? 'http://'. $oNewRe->domain : 'http://' . $oNewRe->sho_link .'.'. domain_site;
                        $item_link = $shopdomain . '/news/detail/' . $item->not_id . '/' . RemoveSign($oNewRe->not_title) . $afkey;
                    }

                    $item_logo = site_url('templates/home/styles/images/product/avata/default-avatar.png');
                    if ($oNewRe->sho_logo) {
                        $item_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $oNewRe->sho_dir_logo . '/' . $oNewRe->sho_logo;
                    }
                ?>
                <div class="related-item">
                    
                    <?php
                    $check_img = explode(':', $oNewRe->not_image)[0];
                    if($check_img == 'http' || $check_img == 'https'){
                        $image = $oNewRe->not_image;
                    }else{
                        $image = $sLinkFolderImage.$oNewRe->not_dir_image.'/'.$oNewRe->not_image;
                    }
                    ?>
                    <img class="image-main" src="<?=$image?>">
                    <div class="related-item-header">
                        <div class="user-deatail">
                            <a href="<?php echo $domain_use_related ?>">
                                <img src="<?=$item_logo?>">
                                <span><?=$oNewRe->use_fullname?></span>
                            </a>
                        </div>
                        <?php
                        if($oNewRe->follow == 1){
                            $isFollow = '';
                            $noFollow = ' hidden';
                        }else{
                            $isFollow = ' hidden';
                            $noFollow = '';
                        }
                        if ($oNewRe->sho_user != $this->session->userdata('sessionUser')) {
                        ?>
                        <div class="cursor-pointer isFollow-<?php echo $oNewRe->sho_id; ?><?php echo $isFollow;?>">
                            <div class="new-deatail-follow ketban-btn cancel-follow-shop" data-id="<?php echo $oNewRe->sho_id; ?>">
                                <img src="<?=base_url()?>templates/home/styles/images/svg/botheodoi.svg">
                                <span><strong>Đang theo dõi</strong></span>
                            </div>
                        </div>
                        <div class="cursor-pointer noFollow-<?php echo $oNewRe->sho_id; ?><?php echo $noFollow;?>">
                            <div class="new-deatail-follow is-follow-shop" data-id="<?php echo $oNewRe->sho_id; ?>">
                                <img src="<?=base_url()?>templates/home/styles/images/svg/theodoi.svg">
                                <span><strong>Theo dõi</strong></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <h3><a href="<?php echo $item_link; ?>"><?=$oNewRe->not_title?></a></h3>
                    <div class="content-expert">
                        <?= cutStringContent($oNewRe->not_detail,100);?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>