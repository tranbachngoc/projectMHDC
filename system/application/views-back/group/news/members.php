<?php $this->load->view('group/news/common/header'); ?>

<script type="text/javascript" src="/templates/home/js/clipboard.min.js"></script>
<script> function copylink(link) { clipboard.copy(link); } </script>
<div id="main" class="container-fluid">
    <div class="row">    
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/menu-left'); ?>
        </div>
        <style>
            .user-name a:hover {
                cursor: default;
                color: #000;
            }
        </style>
        <div class="col-xs-12 col-sm-5">
            <?php $this->load->view('group/news/common/group-top'); ?>
            <?php
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'];
            $arrUrl = explode('.', $domainName);
            if (count($arrUrl) === 3) {
                $url = '';
                $url = $arrUrl[1] . '.' . $arrUrl[2];
            } else {
                $url = $domainName;
            }
            $arr_member = explode(',', $list_member);
            $group = $this->session->userdata('sessionGroup');
            if(($group == AffiliateStoreUser || $group == BranchUser) && (in_array($this->session->userdata('sessionUser'),$arr_member))) {     
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Gian hàng</strong>
                    <?php
                    $count_gh = 0;
                    foreach ($member as $key => $item) {
                        if ($item->use_group == AffiliateStoreUser) {
                            $count_gh++;
                        }
                    }
                    
                    ?>
                    <span class="badge pull-right"><?php echo $count_gh?></span>
                </div>
                <div class="panel-body" style="padding: 5px">
                    <?php
                    if($count_gh >0 ) {
                        foreach ($member as $key => $item) {
                            $shlink = $protocol.($item->domain?$item->domain:$item->sho_link.'.'.domain_site);
                            if ($item->use_group == AffiliateStoreUser) {
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-3" style="padding: 15px;">
                                    <div class="user-avatar" style="width:60px; margin:0 auto">
                                        <?php
                                            $filename = $protocol . $url . '/media/images/avatar/' . $item->avatar;
                                            if(file_exists('media/images/avatar/'.$item->avatar) && $item->avatar != ''){ //file_exists($filename) &&
                                                $avatar = $filename;
                                            } else {
                                                $avatar = '/media/group/logos/default/default_avatar.jpg';
                                            }
                                        ?>
                                        <div class="fix1by1">
                                            <a class="c img-circle" href="<?php echo $shlink ?>"
                                                 style="background: gray url(<?php echo $avatar ?>) no-repeat center / auto 100%;"></a>
                                            <?php ?>
                                        </div>
                                    </div>
                                    <?php $title = 'Tài khoản: '.$item->use_username; if($item->use_fullname != ''){ $title .= ', Họ tên: '.$item->use_fullname;}else{$title .= ', Họ tên: Chưa Cập Nhật'; } ?>
                                    <div class="user-name" title="<?php echo $title ?>">
                                        <!--<a href="<?php echo ''//$protocol . $url .'/user/profile/'.$item->use_id?>" target="" title="<?php echo $title ?>">-->
                                            <?php echo $item->use_username ?>
                                        <!--</a>-->
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                    else{
                        echo 'Không có gian hàng nào trong nhóm';
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Chi nhánh</strong>
                    <?php
                    $count_cn = 0;
                    foreach ($member as $key => $item) {
                        if ($item->use_group == BranchUser) {
                            $count_cn++;
                        }
                    }
                    ?>
                    <span class="badge pull-right"><?php echo $count_cn?></span>
                </div>
                <div class="panel-body" style="padding: 5px">
                    <?php
                    if($count_cn >0 ) {
                        foreach ($member as $key => $item) {
                            $shlink = $protocol.($item->domain?$item->domain:$item->sho_link.'.'.domain_site);
                            if ($item->use_group == BranchUser) {
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-3" style="padding: 15px;">
                                    <div class="user-avatar" style="width:60px; margin:0 auto">
                                        <div class="fix1by1">
                                            <?php
                                            $filename = $protocol . $url . '/media/images/avatar/' . $item->avatar;
                                            if(file_exists('media/images/avatar/'.$item->avatar) && $item->avatar != ''){ //file_exists($filename) &&
                                                $avatar = $filename;
                                            } else {
                                                $avatar = '/media/group/logos/default/default_avatar.jpg';
                                            }
                                            ?>
                                            <a class="c img-circle" href="<?php echo $shlink ?>"
                                                 style="background: gray url(<?php echo $avatar ?>) no-repeat center / auto 100%;"></a>
                                            <?php ?>
                                        </div>
                                    </div>
                                    <?php $title = 'Tài khoản: '.$item->use_username; if($item->use_fullname != ''){ $title .= ', Họ tên: '.$item->use_fullname;}else{$title .= ', Họ tên: Chưa Cập Nhật'; } ?>
                                    <div class="user-name" title="<?php echo $title ?>">
                                        <!--<a href="<?php echo ''//$protocol . $url .'/user/profile/'.$item->use_id?>" target="" title="<?php echo $title ?>">-->
                                            <?php echo $item->use_username ?>
                                        <!--</a>-->
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                    else{
                        echo 'Không có chi nhánh nào trong nhóm';
                    }
                    ?>
                </div>
            </div>
            <?php } else { 
                //echo '<pre>'; print_r($member); echo '</pre>';  
            ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Người bán</strong>
                    <?php
                    $count_gh = 0;
                    foreach ($member as $key => $item) {
                        if ($item->use_group == AffiliateStoreUser  || $item->use_group == BranchUser) {
                            $count_gh++;
                        }
                    }                    
                    ?>
                    <span class="badge pull-right"><?php echo $count_gh?></span>
                </div>
                <div class="panel-body" style="padding: 5px">
                    <?php
                    if($count_gh > 0 ) {
                        foreach ($member as $key => $item) {
                            $shlink = $protocol.($item->domain?$item->domain:$item->sho_link.'.'.domain_site);
                            if ($item->use_group == AffiliateStoreUser  || $item->use_group == BranchUser) {                                
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-3" style="padding: 15px;">
                                    <div class="user-avatar" style="width:60px; margin:0 auto;">
                                        <div class="fix1by1">
                                            <?php
                                            $filename = $protocol . $url . '/media/images/avatar/' . $item->avatar;
                                            if(file_exists('media/images/avatar/'.$item->avatar) && $item->avatar != ''){ //file_exists($filename) &&
                                                $avatar = $filename;
                                            } else {
                                                $avatar = '/media/group/logos/default/default_avatar.jpg';
                                            }
                                            ?>
                                            <a class="c img-circle" href="<?php echo $shlink ?>"
                                                 style="background: gray url(<?php echo $avatar ?>) no-repeat center / auto 100%; border: 1px solid #eee"></a>
                                            <?php ?>
                                        </div>
                                    </div>
                                    <?php $title = 'Tài khoản: '.$item->use_username; if($item->use_fullname != ''){ $title .= ', Họ tên: '.$item->use_fullname;}else{$title .= ', Họ tên: Chưa Cập Nhật'; } ?>
                                    <div class="user-name" title="<?php echo $title ?>">
                                        <!--<a href="<?php echo ''//$protocol . $url .'/user/profile/'.$item->use_id?>" target="" title="<?php echo $title ?>">-->
                                            <?php echo $item->use_username ?>
                                        <!--</a>-->
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                    else{
                        echo 'Không có người bán nào nào trong nhóm';
                    }
                    ?>
                </div>
            </div>
             <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Cộng tác viên</strong>
                    <?php
                    $count_ctv = 0;
                    foreach ($member as $key => $item) {
                        if ($item->use_group == AffiliateUser) {
                            $count_ctv++;
                        }
                    }
                    ?>
                    <span class="badge pull-right"><?php echo $count_ctv?></span>
                </div>
                <div class="panel-body" style="padding: 5px">
                    <?php
                    if($count_ctv >0 ) {
                        foreach ($member as $key => $item) {
                            $shlink = $protocol.($item->domain?$item->domain:$item->sho_link.'.'.domain_site);
                            if ($item->use_group == AffiliateUser) {
                                ?>
                                <div class="col-xs-6 col-sm-4 col-md-3" style="padding: 15px;">
                                    <div class="user-avatar" style="width:60px; margin:0 auto">
                                        <div class="fix1by1">
                                            <?php
                                            $filename = $protocol . $url . '/media/images/avatar/' . $item->avatar;
                                            if(file_exists('media/images/avatar/'.$item->avatar) && $item->avatar != ''){ //file_exists($filename) &&
                                                $avatar = $filename;
                                            } else {
                                                $avatar = '/media/group/logos/default/default_avatar.jpg';
                                            }
                                            ?>
                                            <a class="c img-circle" href="<?php echo $shlink ?>"
                                                 style="background: gray url(<?php echo $avatar ?>) no-repeat center / auto 100%;"></a>
                                            <?php ?>
                                        </div>
                                    </div>
                                    <?php $title = 'Tài khoản: '.$item->use_username; if($item->use_fullname != ''){ $title .= ', Họ tên: '.$item->use_fullname;}else{$title .= ', Họ tên: Chưa Cập Nhật'; } ?>
                                    <div class="user-name" title="<?php echo $title ?>">
                                        <!--<a href="<?php echo ''//$protocol . $url .'/user/profile/'.$item->use_id?>" target="" title="<?php echo $title ?>">-->
                                            <?php echo $item->use_username ?>
                                        <!--</a>-->
                                    </div>
                                </div>
                            <?php }
                        }
                    }
                    else{
                        echo 'Không có cộng tác viên nào trong nhóm';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">

            <div class="panel panel-default panel-about">
                <div class="panel-heading">Sản phẩm mới</div>
                <div class="panel-body">
                    <?php foreach ($products as $key => $item) { ?>
                        <div class="media">
                            <div class="media-left">
                                <div class="fix1by1" style="width:70px">
                                    <div class="c">
                                        <a href="<?php echo site_url('grtshop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name)); ?>">
                                            <?php
                                            $fileimg = 'media/images/product/' . $item->pro_dir . '/' . show_thumbnail($item->pro_dir, $item->pro_image, 1);
                                            ?>
                                            <img class="media-object" alt=""
                                                 src="<?php
                                                 if (file_exists($fileimg)) {
                                                     echo base_url() . $fileimg;
                                                 } else {
                                                     echo base_url() . 'media/images/no_photo_icon.png';
                                                 }
                                                 ?>"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?php echo site_url('grtshop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name)); ?>">
                                        <?php echo $item->pro_name ?>
                                    </a>
                                </h4>
                                <div class="price"><strong
                                        class="text-danger"><?php echo number_format($item->pro_cost) ?></strong> đ
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>


        </div>
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/ads-right'); ?>
        </div>
    </div>

</div>

<?php $this->load->view('group/common/footer-group'); ?>