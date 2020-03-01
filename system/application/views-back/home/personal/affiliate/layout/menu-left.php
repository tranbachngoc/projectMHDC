<?php 
    $slug_profile     = 'profile/' . $current_profile['use_id'];
?>
<div class="tranggioithieu-left">
    <div class="item">
        <h3 class="tit">THÔNG TIN CƠ BẢN</h3>
        <div class="text">
            <p><strong>Tên người dùng : </strong><?=$user_infomation['use_fullname'];?></p>
            <p><strong>Điện thoại: </strong><?=$user_infomation['use_mobile'];?></p>
            <p><strong>Email: </strong><?=$user_infomation['use_email'];?></p>
            <p><strong>Địa chỉ: </strong><?=$user_infomation['use_address'];?></p>
            <p><strong>Affiliate Level: </strong><?=$user_infomation['affiliate_level'];?></p>
        </div>
    </div>
    <?php if(isset($show_affiliate_menu) && $show_affiliate_menu == 1) { ?>
        <div class="item">
            <h3 class="tit">Danh sách thành viên</h3>
            <div class="text">
                <p><a href="<?php echo base_url().$slug_profile . '/affiliate/user?affiliate=0'; ?>">Danh sách thành viên thường</a></p>
                <?php if($user_infomation['affiliate_level'] == 1 ) { ?>
                    <p><a href="<?php echo base_url().$slug_profile . '/affiliate/user?affiliate=2'; ?>">Danh sách tổng đại lý</a></p>
                    <p><a href="<?php echo base_url().$slug_profile . '/affiliate/user?affiliate=3'; ?>">Danh sách đại lý</a></p>
                <?php } else { ?>
                    <p><a href="<?php echo base_url().$slug_profile . '/affiliate/user?affiliate=3'; ?>">Danh sách đại lý</a></p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    
    <div class="item">
        <h3 class="tit">Danh sách Affiliate</h3>
        <div class="text">
            <p><a href="<?php echo base_url().$slug_profile . '/affiliate/list'; ?>">Mã giảm giá của Azibai</a></p>
            <p><a href="<?php echo base_url().'shop/coupons'.'?af_id='.$user_infomation['af_key']?>">Mã giảm giá của hệ thống</a></p>
        </div>
    </div>
    <div class="item">
        <h3 class="tit">Thống kê</h3>
        <div class="text">
            <p><a href="<?php echo base_url().$slug_profile . '/affiliate/order'; ?>">Đơn hàng dịch vụ Azibai</a></p>
        </div>
    </div>
</div>