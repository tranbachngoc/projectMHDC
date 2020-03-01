<?php
$arr_icon_permission = [
    "1" => "congkhai.svg",
    "2" => "banbe2.svg",
    "3" => "chiminhtoi.svg",
];
?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKlKWh6p3jVp3aL8i7Y-ail6R8F-Tj0KQ" type="text/javascript"></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> -->
<!-- <script src="/templates/home/boostrap/js/popper.min.js"></script> -->

<style type="text/css">
  .slug_url {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  span.t {
    display: inline-block;
    width: 140px;
  }
  input.use_slug.ten-bst-input {
    width: 75%;
  }
  .form-group-hastypepost .typepost-now {
    float: right;
  }
</style>

<script>window.jQuery || document.write('<script src="./js/jquery-3.3.1.min.js"><\/script>')</script>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/" type="text/css" rel="stylesheet"/>

<style type="text/css">
    .item.col-md-5 {
        display: inline-block;
    }
    textarea, .txt-introduct{
        width: 100%;
        height: 350px;
        border: none;
    }
    .txt-introduct{
        overflow-y: scroll;
    }
    textarea::-webkit-scrollbar, .txt-introduct::-webkit-scrollbar{
        background: rgba(199, 195, 195, 0.4);
        border-radius: 8px;
        width: 5px;
    }
    textarea::-webkit-scrollbar-thumb, .txt-introduct::-webkit-scrollbar-thumb{
        background: rgba(162, 154, 154, 0.75);
        border-radius: 10px;
    }
    textarea::-webkit-scrollbar-thumb:hover, .txt-introduct::-webkit-scrollbar-thumb:hover{
        cursor: pointer !important;
        background: #000;
    }
    .input-time {
        position: relative;
    }
    i.fa.fa-plus-circle.js-add-time {
        right: 0;
        top: 0;
        font-size: 20px;
    }
    .block02.md .box-table {
        height: 215px;
    }

    .js-year .slick-prev:before, .js-year .slick-next:before{
        color: #908c8c;
    }

    p.readmore {
        float: right;
    }

    p.video_tag video {
        width: 100%;
    }

    p.img_tag img {
        width: 100%;
    }
    p.note_urlvideo{
        font-size: 12px;
    }

    .embed-video{
        width: 100%;
        height: 450px;
    }

    .text{
        overflow: hidden;
    }

    #modal_cusvideo video{
        width: 100%;
    }
    .modal input[type="file"] {
        height: auto;
    }
    .box-table {
        height: 250px;
    }
    .box-table .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
        background-color: rgba(162, 154, 154, 0.75);
    }
    .box-table .mCSB_scrollTools .mCSB_draggerRail {
        background-color: rgba(148, 143, 143, 0.4);
    }
    .bst-modal .modal-body{
        overflow-y: auto;
    }
</style>

<div class="introduce-business-block block01">
    <div class="item">
        <div class="tit">
            <h4>Giới thiệu</h4>
            <?php
            if($user_id == $shop->sho_user){
                echo '<div class="edit popup-introduct" data-toggle="modal" data-target="#introduct">Chỉnh sửa</div>';
            }
            ?>
        </div>
        <div class="detail" style="height: 85%;">
            <div class="txt-introduct">
                <?php
                if(!empty($shop->sho_introduction)){
                    echo nl2br($shop->sho_introduction);
                    ?>
                    <script type="text/javascript">
                    $(document).ready(function(){
                        if($(window).width() < 1024){
                            var height = $('.txt-introduct textarea').height(0)[0].scrollHeight;
                            if(height >= 350){
                                $('.txt-introduct textarea').removeAttr('style');
                            }else{
                                $('.txt-introduct textarea').css('height', height+'px');
                            }
                        }
                    });
                    </script>
                    <?php
                }else{
                    echo 'Chưa cập nhật';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="item">
        <div class="tit">
            <h4>LIÊN HỆ</h4>
            <?php
            if($user_id == $shop->sho_user){
                echo '<div class="edit popup-contact" data-toggle="modal" data-target="#contact">Chỉnh sửa</div>';
            }
            ?>
        </div>
        <div class="detail">
            <table>
                <tbody>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            <?php echo ($shop->sho_address != '') ? $shop->sho_address.', '.$siteGlobal->distin['DistrictName'] : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tỉnh/thành phố</td>
                        <td>
                            <?php echo ($siteGlobal->distin['ProvinceName'] != '') ? $siteGlobal->distin['ProvinceName'] : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <?php if($shop->permission_mobile == 1 || ($shop->permission_mobile == 2 && property_exists($shop, 'is_follow_shop') && $shop->is_follow_shop == true) || $shop->sho_user == $this->session->userdata('sessionUser')) { ?>
                    <tr>
                        <td>Di động</td>
                        <td>
                            <?php echo ($shop->sho_mobile != '') ? $shop->sho_mobile : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($shop->permission_phone == 1 || ($shop->permission_phone == 2 && property_exists($shop, 'is_follow_shop') && $shop->is_follow_shop == true) || $shop->sho_user == $this->session->userdata('sessionUser')) { ?>
                    <tr>
                        <td>Điện thoại bàn</td>
                        <td>
                            <?php echo ($shop->sho_phone != '') ? $shop->sho_phone : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Fax</td>
                        <td>
                            <?php echo ($shop->shop_fax != '') ? $shop->shop_fax : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <?php if($shop->permission_email == 1 || ($shop->permission_email == 2 && property_exists($shop, 'is_follow_shop') && $shop->is_follow_shop == true) || $shop->sho_user == $this->session->userdata('sessionUser')) { ?>
                    <tr>
                        <td>Email</td>
                        <td>
                            <?php echo ($shop->sho_email != '') ? $shop->sho_email : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>Website</td>
                        <td>
                            <?php echo ($shop->sho_website != '') ? $shop->sho_website : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <tr>
                        <td>Năm thành lập</td>
                        <td>
                            <?php echo ($shop->sho_establish != '') ? $shop->sho_establish : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                    <tr>
                        <td>Mã số thuế</td>
                        <td>
                            <?php echo ($shop->sho_taxcode != '') ? $shop->sho_taxcode : 'Chưa cập nhật';?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="introduce-business-block block02">
    <!-- <div class="item col-md-12"> -->
    <iframe src="https://www.google.com/maps?q=<?php echo ($shop->sho_address != '') ? $shop->sho_address.', '.$district_name.','.$province_name : 'Hồ Chí Minh';?>&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
        
    <!-- </div> -->
    <div class="timeworks md">
        <div class="tit">
            <h4>GIỜ LÀM VIỆC</h4>
            <?php
            if($user_id == $shop->sho_user){
                echo '<div class="edit popup-timework" data-toggle="modal" data-target="#timework">Chỉnh sửa</div>';
            }
            ?>
        </div>
        <div class="detail">
        <?php
        if(!empty($time_work))
        {
            if($time_work->type == 1){
        ?>
            <div class="box-table mCustomScrollbar _mCS_1">
                <table>
                    <tbody>
                    <?php
                    foreach ($time_work as $key => $value)
                    {
                        if($key != 'type')
                        {
                            if($key == 0 || $key == 'Mon'){
                                $thu = 'Thứ 2';
                            }
                            if($key == 1 || $key == 'Tue'){
                                $thu = 'Thứ 3';
                            }
                            if($key == 2 || $key == 'Wed'){
                                $thu = 'Thứ 4';
                            }
                            if($key == 3 || $key == 'Thu'){
                                $thu = 'Thứ 5';
                            }
                            if($key == 4 || $key == 'Fri'){
                                $thu = 'Thứ 6';
                            }
                            if($key == 5 || $key == 'Sat'){
                                $thu = 'Thứ 7';
                            }
                            if($key == 6 || $key == 'Sun'){
                                $thu = 'Chủ nhật';
                            }
                        ?>
                        <tr>
                            <td><?php echo $thu; ?></td>
                            <td>
                                <?php
                                    if($value->on == 0){
                                        echo 'Nghỉ';
                                    }
                                    else{
                                        if(!empty($value->am)){
                                            echo $value->am->start.' - '.$value->am->end.'<br/>';
                                        }
                                        if(!empty($value->pm)){
                                            echo $value->pm->start.' - '.$value->pm->end;
                                        }
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        <?php
            }else{
                if($time_work->type == 2){
                    echo 'Luôn mở cửa';
                }else{
                    echo 'Đóng cửa tạm thời hoặc vĩnh viễn';
                }
            }
        }else{
            echo 'Chưa cập nhật';
        }
        ?>
        </div>
    </div>
</div>

<div class="introduce-business-block block02 sm">
    <div class="item" style="width: 100%">
        <div class="tit">
            <h4>Giờ làm việc</h4>
            <?php
            if($user_id == $shop->sho_user){
                echo '<div class="edit popup-timework" data-toggle="modal" data-target="#timework">Chỉnh sửa</div>';
            }
            ?>
        </div>
        <div class="detail">
        <?php
            if(!empty($time_work))
            {
                if($time_work->type == 1){
            ?>
                <div class="">
                    <table>
                        <tbody>
                        <?php
                        foreach ($time_work as $key => $value)
                        {
                            if($key != 'type')
                            {
                                if($key == 0 || $key == 'Mon'){
                                    $thu = 'Thứ 2';
                                }
                                if($key == 1 || $key == 'Tue'){
                                    $thu = 'Thứ 3';
                                }
                                if($key == 2 || $key == 'Wed'){
                                    $thu = 'Thứ 4';
                                }
                                if($key == 3 || $key == 'Thu'){
                                    $thu = 'Thứ 5';
                                }
                                if($key == 4 || $key == 'Fri'){
                                    $thu = 'Thứ 6';
                                }
                                if($key == 5 || $key == 'Sat'){
                                    $thu = 'Thứ 7';
                                }
                                if($key == 6 || $key == 'Sun'){
                                    $thu = 'Chủ nhật';
                                }
                            ?>
                            <tr>
                                <td><?php echo $thu; ?></td>
                                <td>
                                    <?php
                                        if($value->on == 0){
                                            echo 'Nghỉ';
                                        }
                                        else{
                                            if(!empty($value->am)){
                                                echo $value->am->start.' - '.$value->am->end.'<br/>';
                                            }
                                            if(!empty($value->pm)){
                                                echo $value->pm->start.' - '.$value->pm->end;
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php
                }else{
                    if($time_work->type == 2){
                        echo 'Luôn mở cửa';
                    }else{
                        echo 'Đóng cửa tạm thời hoặc vĩnh viễn';
                    }
                }
            }else{
                echo 'Chưa cập nhật';
            }
        ?>
        </div>
    </div>
</div>

<div class="introduce-business-block block03">
    <?php
    $width = $hide_team = $hide_certify = '';
    if(!empty($company_team) && !empty($certify)){
    }else{
        if($user_id != $shop->sho_user){
            $width = 'width: 100%';
            if(empty($company_team)){
                $hide_team = ' hidden';
            }
            if(empty($certify)){
                $hide_certify = ' hidden';
            }
        }
    }
    ?>
    <div class="item<?=$hide_team?>" style="<?php echo $width;?>">
        <div class="tit">
            <h4>Đội ngũ công ty</h4>
            <?php
                if($user_id == $shop->sho_user){
                    echo '<div class="edit add-team" data-toggle="modal" data-target="#company_team">Thêm mới</div>';
                }
            ?>
        </div>
        <div class="detail">
            <div class="slider js-customer-comment customer-comment">
            <?php
            if(!empty($company_team)){
                foreach ($company_team as $key => $value) {
            ?>
            <div class="slide">
                <div class="avata"><img src="<?= ($value->team_avatar != '') ? $value->team_avatar : '/templates/home/images/svg/user_signin.svg'; ?>" alt=""></div>
                <div class="name">
                    <h5><?= $value->team_name?></h5>
                    <div class="position"><?= $value->team_role?></div>
                    <div class="more"><?= $value->team_desc?></div>
                    <div class="link-socials">
                    <?php
                    if($value->team_facebook != '')
                    {
                    ?>
                        <a href="<?php echo $value->team_facebook; ?>">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    <?php
                    }
                    if($value->team_linkedin != '')
                    {
                    ?>
                        <a href="<?php echo $value->team_linkedin; ?>">
                            <i class="fa fa-linkedin" aria-hidden="true"></i>
                        </a>
                    <?php
                    }
                    if($value->team_instagram != '')
                    {
                    ?>
                        <a href="<?php echo $value->team_instagram;?>">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    <?php
                    }
                    if($value->team_azibai != '')
                    {
                    ?>
                        <a href="<?php echo $value->team_azibai; ?>">
                            <img src="/templates/home/images/svg/a.svg" alt="">
                        </a>
                    <?php
                    }
                    ?>
                    </div>
                    <?php
                    if($user_id == $shop->sho_user){
                        echo '<div class="text-right"><a href="" class="btn-edit edit-team" data-toggle="modal" data-target="#company_team" data="'.$value->id.'">Chỉnh sửa</a></div>';
                    }
                    ?>
                </div>
            </div>
            <?php
                }
            }else{
                echo 'Bạn chưa cập nhật đội ngũ công ty';
            }
            ?>
        </div>
      </div>
    </div>

    <div class="item<?=$hide_certify?>" style="<?php echo $width;?>">
      <div class="tit">
        <h4>chứng nhận đạt được</h4>
        <?php
            if($user_id == $shop->sho_user){
                echo '<div class="edit add-certify" data-toggle="modal" data-target="#certify">Thêm mới</div>';
            }
        ?>
        <!-- <div class="edit" data-toggle="modal" data-target="#editCertifyResults">Thêm mới</div> -->
      </div>
      <div class="detail">
        <div class="slider js-customer-comment customer-comment certify">
            <?php
            if(!empty($certify)){
                foreach ($certify as $key => $value) {
            ?>
            <div class="slide">
                <div class="avata"><img src="<?= ($value->certify_avatar != '') ? $value->certify_avatar : '/templates/home/images/svg/user_signin.svg'; ?>" alt=""></div>
                <div class="name">
                    <h5><?= $value->certify_name?></h5>
                    <div class="position"><?= $value->certify_year?></div>
                    <div class="more"><?= $value->certify_released?></div>
                    <?php
                    if($user_id == $shop->sho_user){
                        echo '<div class="text-right"><a href="" class="btn-edit edit-certify" data-toggle="modal" data-target="#certify" data="'.$value->id.'">Chỉnh sửa</a></div>';
                    }
                    ?>
                </div>
            </div>
            <?php
                }
            }else{
                echo 'Bạn chưa cập nhật chứng nhận';
            }
            ?>
        </div>
      </div>
    </div>
</div>

<div class="introduce-business-block block04">
    <?php
    if((!empty($customer) && $user_id != $shop->sho_user) || ($user_id == $shop->sho_user)){
    ?>
    <div class="item<?=$hide_team?>" style="<?php echo $width;?>">
        <div class="tit">
            <h4>Khách hàng nói</h4>
            <?php
                if($user_id == $shop->sho_user){
                    echo '<div class="edit add-customer" data-toggle="modal" data-target="#customer">Thêm mới</div>';
                }
            ?>
        </div>
        <div class="detail">
            <div class="slider js-customer-comment customer-comment">
            <?php
            if(!empty($customer)){
                foreach ($customer as $key => $value) {
            ?>
            <div class="slide">
                <div class="avata"><img src="<?= ($value->customer_avatar != '') ? $value->customer_avatar : '/templates/home/images/svg/user_signin.svg'; ?>" alt=""></div>
                <div class="name">
                    <h5><?= $value->customer_name?></h5>
                    <?php if($value->customer_video != ''){?>
                    <div class="position watch_customer" data-src="<?= $value->customer_video?>" data-toggle="modal" data-target="#modal_cusvideo">Xem video</div>
                    <?php }//https://cdn1.azibai.com/video/156035285934641400.mp4?>
                    <div class="more"><?= $value->customer_quote?></div>
                    <?php
                    if($user_id == $shop->sho_user){
                        echo '<div class="text-right"><a href="" class="btn-edit edit-customer" data-toggle="modal" data-target="#customer" data="'.$value->id.'">Chỉnh sửa</a></div>';
                    }
                    ?>
                </div>
            </div>
            <?php
                }
            }else{
                if($user_id == $shop->sho_user){
                    echo 'Bạn chưa cập nhật ý kiến khách hàng';
                }
            }
            ?>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<?php
if((!empty($active) && $user_id != $shop->sho_user) || ($user_id == $shop->sho_user)){
?>
<div class="introduce-business-block block05">
    <div class="tit">
        <h4>HOẠT ĐỘNG</h4>
        <?php
        $per = '';
        if($user_id == $shop->sho_user){
            echo '<div class="edit add-active" data-toggle="modal" data-target="#active">Thêm mới</div>';
            $per = 1;
        }
        ?>
    </div>
    <div class="detail">
      <?php
        if(!empty($active))
        {
        ?>
        <div class="once-a-year">
            <div class="year">
                <span class="an-year slider js-year" data-permission="<?php echo $per; ?>" style="width: 100px;">
                <?php
                foreach ($active_year as $key => $value) {
                ?>
                <p><?php echo $value->active_year; ?></p>
                <?php } ?>
                </span>
            </div>
            <div class="item-year">
                <?php
                    foreach ($active as $key => $value) {
                ?>
                <!-- <div class="item-row <?php echo ($value->active_at == 1) ? 'right' : 'left'; ?>">  -->
                    <div class="item-year-item">
                        <div class="item-year-item-title"><?php echo $value->active_title; ?></div>
                        <div class="item-year-item-content">
                            <div class="smal-text">
                                <div class="date"><?php echo $value->active_date; ?></div>
                                <?php
                                if($user_id == $shop->sho_user){
                                    echo '<div class="edit edit-active" data="'.$value->id.'" data-toggle="modal" data-target="#active">Chỉnh sửa</div>';
                                }
                                ?>
                            </div>
                            <div class="box-text">
                                <div class="text">
                                    <p>
                                    <?php echo $value->active_desc; ?>
                                    </p>
                                    <?php if($value->active_url != ''){ ?>
                                        <p class="readmore cursor-pointer">
                                            <a href="<?php echo $value->active_url; ?>" target="_blank">Xem thêm</a>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="text slider js-slider-active">
                                    <?php
                                    if($value->active_video != ''){
                                    ?>
                                    <p class="video_tag">
                                        <video controls="controls" class="up-video">
                                            <source src="<?php echo $value->active_video; ?>" type="video/mp4">
                                        </video>
                                    </p>
                                    <?php
                                    }else{
                                        if($value->active_urlvideo != ''){
                                            $url_video = $value->active_urlvideo;
                                    ?>
                                    <p class="frame_video">
                                        <iframe class="embed-video" src="<?php echo $url_video; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </p>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <p class="img_tag"><img src="<?php echo $value->active_avatar; ?>" alt=""></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
                <?php
                    }
                ?>
            </div>
        </div>
        <?php
        }else{
            echo 'Bạn chưa cập nhật hoạt động của doanh nghiệp';
        }
        ?>
    </div>
</div>
<?php
}
?>
<!-- MODAL -->

<div class="modal bst-modal" id="introduct">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cập nhật mô tả gian hàng</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php
                    $introduct = '';
                    if(!empty($shop->sho_introduction)){
                        $introduct = htmlspecialchars_decode($shop->sho_introduction);
                    }
                ?>
                <p class="note"></p>
                <form method="post">
                    <textarea name="sho_introduction" class="sho_introduction mt10" data-id="<?php echo $shop->sho_id;?>" placeholder="Nhập mô tả gian hàng"><?php echo $introduct; ?></textarea>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer buttons-group">
                <div class="bst-group-button">  
                  <div class="left"></div>
                  <div class="right">
                    <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                    <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal bst-modal" id="contact">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Cập nhật thông tin liên hệ</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p class="note"></p>
                <form method="post">
                    <input class="hidden" name="sho_id" value="<?php echo $shop->sho_id;?>"/>
                    <div class="form-group">
                        <label class="col-form-label">Tên gian hàng</label>
                        <input name="sho_name" class="sho_name ten-bst-input" value="<?php echo ($shop->sho_name != '') ? $shop->sho_name : '';?>" placeholder="Tên gian hàng" maxlength="150"/>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mô tả SEO</label>
                        <input type="text" autocomplete="off" name="sho_description" class="ten-bst-input" value="<?php echo ($shop->sho_description != '') ? $shop->sho_description : '';?>" placeholder="Mô tả SEO" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Từ khóa SEO</label>
                        <input type="text" autocomplete="off" name="sho_keywords" class="ten-bst-input" value="<?php echo ($shop->sho_keywords != '') ? $shop->sho_keywords : '';?>" placeholder="Từ khóa SEO" maxlength="150">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Liên kết của cửa hàng</label>
                        <div class="form-group">
                            <input type="text" autocomplete="off" name="sho_link" class="ten-bst-input" value="<?php echo ($shop->sho_link != '') ? $shop->sho_link : '';?>" placeholder="Liên kết của cửa hàng" style="width: 80%;" maxlength="100">
                            <label class="col-form-label"><?php echo '.'.domain_site;?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Địa chỉ & phường xã</label>
                        <input type="text" autocomplete="off" name="sho_address" class="ten-bst-input" value="<?php echo ($shop->sho_address != '') ? $shop->sho_address : '';?>" placeholder="Địa chỉ & phường xã" maxlength="100">
                    </div>
                    
                    <div class="form-group">
                        <!-- <div class="col-md-4">Tỉnh/thành phố</div>
                        <div class="col-md-6"> -->
                            <select name="sho_province" id="shop_provice" class="select-category">
                                <option value="">Chọn Tỉnh/Thành</option>
                                <?php foreach ($province as $vals):?>
                                    <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $shop->sho_province)?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
                                <?php endforeach;?>
                            </select>
                        <!-- </div> -->
                    </div>
                    
                    <div class="form-group">
                        <!-- <div class="col-md-4">Quận/huyện</div>
                        <div class="col-md-6"> -->
                            <select name="sho_district" id="shop_district" class="select-category">
                                <option value="">Chọn Quận/Huyện</option>
                                <?php foreach ($district as $vals): ?>
                                    <option value="<?php echo $vals->DistrictCode; ?>" <?php echo ($vals->DistrictCode == $shop->sho_district)?"selected='selected'":""; ?> ><?php echo $vals->DistrictName; ?></option>
                                <?php endforeach;?>
                            </select>
                        <!-- </div> -->
                    </div>

                    <div class="form-group">
                        <label class="col-form-label cursor-pointer">
                        <input type="checkbox" name="check_kho" autocomplete="off" class="check_kho" value="1">
                        Đánh dấu nhanh nếu địa chỉ công ty trùng địa chỉ kho</label>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Địa chỉ kho</label>
                        <input type="text" autocomplete="off" name="sho_kho_address" class="ten-bst-input" value="<?php echo ($shop->sho_kho_address != '') ? $shop->sho_kho_address : '';?>" placeholder="Địa chỉ kho" maxlength="255">
                    </div>
                    
                    <div class="form-group">
                        <!-- <div class="col-md-4">Tỉnh/thành phố</div>
                        <div class="col-md-6"> -->
                            <select name="sho_kho_province" id="sho_kho_province" class="select-category">
                                <option value="">Chọn Tỉnh/Thành</option>
                                <?php foreach ($province as $vals):?>
                                    <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $shop->sho_kho_province)?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
                                <?php endforeach;?>
                            </select>
                        <!-- </div> -->
                    </div>
                    
                    <div class="form-group">
                        <!-- <div class="col-md-4">Quận/huyện</div>
                        <div class="col-md-6"> -->
                            <select name="sho_kho_district" id="sho_kho_district" class="select-category">
                                <option value="">Chọn Quận/Huyện</option>
                                <?php foreach ($district_kho as $vals): ?>
                                    <option value="<?php echo $vals->DistrictCode; ?>" <?php echo ($vals->DistrictCode == $shop->sho_kho_district)?"selected='selected'":""; ?> ><?php echo $vals->DistrictName; ?></option>
                                <?php endforeach;?>
                            </select>
                        <!-- </div> -->
                    </div>
                    
                    <div class="form-group form-group-hastypepost">
                        <label class="col-form-label">Di động cửa hàng</label>
                        <input type="text" autocomplete="off" name="sho_mobile" class="ten-bst-input" value="<?php echo ($shop->sho_mobile != '') ? $shop->sho_mobile : '';?>" placeholder="Di động cửa hàng" maxlength="11">
                        <div class="typepost">
                            <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/<?=$arr_icon_permission[$shop->permission_mobile]?>" class="mr10 js-image-choose-radio"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
                            <ul class="dropdown-menu typepost-select dropdown-menu-right">
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_mobile" value="1" <?=($shop->permission_mobile == 1) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_mobile" value="2" <?=($shop->permission_mobile == 2) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Theo dõi</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_mobile" value="3" <?=($shop->permission_mobile == 3) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
                                </label>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group form-group-hastypepost">
                        <label class="col-form-label">Điện thoại bàn</label>
                        <input type="text" autocomplete="off" name="sho_phone" class="ten-bst-input" value="<?php echo ($shop->sho_phone != '') ? $shop->sho_phone : '';?>" placeholder="Điện thoại bàn" maxlength="20">
                        <div class="typepost">
                            <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/<?=$arr_icon_permission[$shop->permission_phone]?>" class="mr10 js-image-choose-radio"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
                            <ul class="dropdown-menu typepost-select dropdown-menu-right">
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_phone" value="1" <?=($shop->permission_phone == 1) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_phone" value="2" <?=($shop->permission_phone == 2) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Theo dõi</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_phone" value="3" <?=($shop->permission_phone == 3) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
                                </label>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Fax</label>
                        <input type="text" autocomplete="off" name="shop_fax" class="ten-bst-input" value="<?php echo ($shop->shop_fax != '') ? $shop->shop_fax : '';?>" placeholder="Fax" maxlength="25">
                    </div>
                    <div class="form-group form-group-hastypepost">
                        <label class="col-form-label">Email công ty</label>
                        <input type="text" autocomplete="off" name="sho_email" class="ten-bst-input" value="<?php echo ($shop->sho_email != '') ? $shop->sho_email : '';?>" placeholder="Email công ty" maxlength="50">
                        <div class="typepost">
                            <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/<?=$arr_icon_permission[$shop->permission_email]?>" class="mr10 js-image-choose-radio"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
                            <ul class="dropdown-menu typepost-select dropdown-menu-right">
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_email" value="1" <?=($shop->permission_email == 1) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_email" value="2" <?=($shop->permission_email == 2) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Theo dõi</span>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-style-circle">
                                <input type="radio" name="typepost_email" value="3" <?=($shop->permission_email == 3) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
                                </label>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Website công ty</label>
                        <input type="text" autocomplete="off" name="sho_website" class="ten-bst-input" value="<?php echo ($shop->sho_website != '') ? $shop->sho_website : '';?>" placeholder="Website công ty" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Năm thành lập công ty</label>
                        <input type="date" autocomplete="off" name="sho_establish" class="ten-bst-input" value="<?php echo ($shop->sho_establish != '') ? $shop->sho_establish : '';?>" placeholder="Năm thành lập công ty" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Liên kết facebook</label>
                        <input type="text" autocomplete="off" name="sho_facebook" class="ten-bst-input" value="<?php echo ($shop->sho_facebook != '') ? $shop->sho_facebook : '';?>" placeholder="Liên kết facebook" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Liên kết kênh youtube</label>
                        <input type="text" autocomplete="off" name="sho_youtube" class="ten-bst-input" value="<?php echo ($shop->sho_youtube != '') ? $shop->sho_youtube : '';?>" placeholder="Liên kết kênh youtube" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Liên kết kênh vimeo</label>
                        <input type="text" autocomplete="off" name="sho_vimeo" class="ten-bst-input" value="<?php echo ($shop->sho_vimeo != '') ? $shop->sho_vimeo : '';?>" placeholder="Liên kết kênh vimeo" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Mã số thuế doanh nghiệp</label>
                        <input type="text" autocomplete="off" name="sho_taxcode" class="ten-bst-input" value="<?php echo ($shop->sho_taxcode != '') ? $shop->sho_taxcode : '';?>" placeholder="Mã số thuế doanh nghiệp" maxlength="25">
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer buttons-group">
                <div class="bst-group-button">  
                  <div class="left"></div>
                  <div class="right">
                    <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                    <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $("body").on("change","input[name='typepost_email'], input[name='typepost_mobile'], input[name='typepost_phone']",function (event) {
        img = $(this).next().find("img").attr("src");
        $(this).closest(".typepost").find("p .js-image-choose-radio").attr("src",img);
    })
    </script>
</div>

<div class="modal bst-modal" id="timework">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Giờ làm việc</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body editTimeworks">
            <form>
              <ul class="editTimeworks-select-option">
                <li>
                  <label class="checkbox-style-circle">
                  <input type="radio" name="status_time" value="1" class="select_time" <?php echo ((!empty($time_work) && $time_work->type == 1) || empty($time_work)) ? 'checked' : ''; ?>><span>Tùy chọn</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                  <input type="radio" name="status_time" value="2" class="always_open" <?php echo (!empty($time_work) && $time_work->type == 2) ? 'checked' : ''; ?>><span>Luôn mở cửa</span>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style-circle">
                  <input type="radio" name="status_time" value="0" class="shop_close" <?php echo (!empty($time_work) && $time_work->type == 0) ? 'checked' : ''; ?>><span>Đóng cửa vĩnh viễn hoặc tạm thời</span>
                  </label>
                </li>
              </ul>

              <?php
                if((!empty($time_work) && $time_work->type == 1) || empty($time_work))
                {
                    $class = '';
                }else{
                    $class = 'hidden';
                }
              ?>
                <ul class="editTimeworks-input-time <?= $class ?>">
                <?php
                $arr_date = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                foreach ($arr_date as $key => $value) {
                    if($key == 6){
                        $thu = 'Chủ nhật';
                    }else{
                        $num = $key + 2;
                        $thu = 'Thứ '.$num;
                    }

                    $index = '';
                    if($key == 0){
                        $index = 'monday';
                    }
                    if($key == 1){
                        $index = 'tuesday';
                    }
                    if($key == 2){
                        $index = 'wednesday';
                    }
                    if($key == 3){
                        $index = 'thursday';
                    }
                    if($key == 4){
                        $index = 'friday';
                    }
                    if($key == 5){
                        $index = 'saturday';
                    }
                    if($key == 6){
                        $index = 'sunday';
                    }
                    $checked = '';
                    $value_am_start = $value_am_end = $value_pm_start = $value_pm_end = '';
                    if(!empty($time_work) && $time_work->type == 1){

                        if($time_work->$value->on == 1){
                            $checked = 'checked';
                            $value_am_start = $time_work->$value->am->start;
                            $value_am_end = $time_work->$value->am->end;
                            $value_pm_start = $time_work->$value->pm->start;
                            $value_pm_end = $time_work->$value->pm->end;
                        }
                    }
                ?>
                    <li>
                        <label class="checkbox-style">
                            <input type="checkbox" name="check_<?= $index ?>" value="check" class="<?= $index ?>" <?php echo $checked; ?>><span><?php echo $thu; ?></span>
                        </label>
                        <div class="input-time input-time-<?= $index ?>">
                            <div class="input-time-form" data-name="<?php echo $index?>">
                                <div class="form-group clock-<?php echo $index?>-am0">
                                    <div class="box-clock"></div>
                                    <input name="<?php echo $index?>[am][0]" type="time" class="form-control a-clockpicker" data="<?php echo $index?>-am0" data-index="0" value="<?php echo $value_am_start;?>">
                                </div>
                                <div class="mr20">-</div>
                                <div class="form-group clock-<?php echo $index?>-am1">
                                    <div class="box-clock"></div>
                                    <input name="<?php echo $index?>[am][1]" type="time" class="form-control a-clockpicker" data="<?php echo $index?>-am1" data-index="1" value="<?php echo $value_am_end;?>">
                                </div>
                                <?php
                                if($value_pm_start == ''){   
                                    echo '<i class="fa fa-plus-circle js-add-time" data="'.$index.'" aria-hidden="true"></i>';
                                }?>
                            </div>

                            <?php
                            if($value_pm_start != ''){
                            ?>
                            <div class="input-time-form" data-name="<?php echo $index?>">
                                <div class="form-group clock-<?php echo $index?>-pm0">
                                    <div class="box-clock"></div>
                                    <input name="<?php echo $index?>[pm][0]" type="time" class="form-control a-clockpicker" data="<?php echo $index?>-pm0" data-index="0" value="<?php echo $value_pm_start;?>">
                                </div>
                                <div class="mr20">-</div>
                                <div class="form-group clock-<?php echo $index?>-pm1">
                                    <div class="box-clock"></div>
                                    <input name="<?php echo $index?>[pm][1]" type="time" class="form-control a-clockpicker" data="<?php echo $index?>-pm1" data-index="1" value="<?php echo $value_pm_end;?>">
                                </div>
                                <?php
                                    echo '<i class="fa fa-times-circle js-remove-time js-remove-time-'.$index.'" data="'.$index.'" aria-hidden="true"></i>';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </li>
                <?php
                }
                ?>
                </ul>

            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="modal bst-modal" id="company_team">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Đội ngũ công ty</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <!-- Modal body -->
          <div class="modal-body edit-coll avata-team">
            <form action="">
              <div class="form-group text-center">
                <!-- <div class="col-for-label f13 mt10"> -->
                
                <!-- </div> -->
                <div id="crop-zone">
                    <img class="avatar_team text-center" id="" src="/templates/home/images/svg/add_avata.svg">
                </div>
                <!-- <label class="col-for-label f13 mt10"> -->
                    
                  <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                    
                    <label class="col-form-label f13 mt10"> Thêm ảnh / thay đổi
                        <input type="file" class="form-control" accept="image/*" id="reviewImg" style="display:none">
                    </label>
                  </span>
                <!-- </label> -->
              </div>
              <div class="form-group">
                <label class="col-form-label">Tên thành viên công ty</label>
                <input type="text" autocomplete="off" name="team_name" class="ten-bst-input" placeholder="Tên thành viên công ty" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Chức danh</label>
                <input type="text" autocomplete="off" name="team_role" class="ten-bst-input" placeholder="Chức danh" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Mô tả về năng lực</label>
                <input type="text" autocomplete="off" name="team_desc" class="ten-bst-input" placeholder="Mô tả về năng lực" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Liên kết đến Facebook</label>
                <input type="text" autocomplete="off" name="team_facebook" class="ten-bst-input" placeholder="Liên kết đến Facebook" maxlength="250">
              </div>
              <!-- <div class="form-group">
                <input type="text" autocomplete="off" name="team_twitter" class="ten-bst-input" placeholder="Liên kết đến Twitter">
              </div> -->
              <div class="form-group">
                <label class="col-form-label">Liên kết đến Linkedin</label>
                <input type="text" autocomplete="off" name="team_linkedin" class="ten-bst-input" placeholder="Liên kết đến Linkedin" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Liên kết đến Instagram</label>
                <input type="text" autocomplete="off" name="team_instagram" class="ten-bst-input" placeholder="Liên kết đến Instagram" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Liên kết đến trang azibai</label>
                <input type="text" autocomplete="off" name="team_azibai" class="ten-bst-input" placeholder="Liên kết đến trang azibai" maxlength="250">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="modal bst-modal" id="certify">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Chứng nhận</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <!-- Modal body -->
          <div class="modal-body edit-coll box-certify">
            <form action="">
              <div class="form-group text-center">
                <!-- <div id="crop-zone">
                    <img class="avatar_team text-center" id="" src="/templates/home/images/svg/add_avata.svg">
                </div> -->
                <div id="certify_avatar">
                    <img class="img-certify text-center" id="" src="/templates/home/images/svg/add_avata.svg">
                </div>
                  <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                    <label class="col-form-label f13 mt10"> Thêm ảnh / thay đổi
                        <input type="file" class="form-control" accept="image/*" id="reviewImg_certify" style="display:none">
                    </label>
                  </span>
              </div>
              <div class="form-group">
                <label class="col-form-label">Tên chứng nhận</label>
                <input type="text" autocomplete="off" name="certify_name" class="ten-bst-input" placeholder="Tên chứng nhận" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Người cấp/đơn vị/hãng,công ty</label>
                <input type="text" autocomplete="off" name="certify_released" class="ten-bst-input" placeholder="Người cấp/đơn vị/hãng,công ty" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Năm</label>
                <input type="date" autocomplete="off" name="certify_year" id="" class="ten-bst-input" placeholder="Năm" maxlength="20">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="modal bst-modal" id="customer">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Khách hàng chia sẻ</h4>
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <!-- Modal body -->
          <div class="modal-body edit-coll box-customer">
            <form action="" method="post">
              <div class="form-group text-center">
                <!-- <div class="col-for-label f13 mt10"> -->
                
                <!-- </div> -->
                <div id="crop-zone">
                    <img class="img-customer text-center" id="" src="/templates/home/images/svg/add_avata.svg">
                </div>
                  <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                    <label class="col-form-label f13 mt10"> Thêm ảnh / thay đổi
                        <input type="file" class="form-control" accept="image/*" id="reviewImg_customer" style="display:none">
                    </label>
                  </span>
              </div>
              <div class="form-group">
                <label class="col-form-label">Tên khách hàng</label>
                <input type="text" autocomplete="off" name="customer_name" class="ten-bst-input" placeholder="Tên khách hàng" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Trích dẫn từ khách hàng</label>
                <input type="text" autocomplete="off" name="customer_quote" class="ten-bst-input" placeholder="Trích dẫn từ khách hàng" maxlength="250">
              </div>
              <div class="form-group">
                <label class="col-form-label">Video cảm nhận khách hàng</label>
                <p class="cusvideo"></p>
                <input type="file" name="customer_video" id="customer_video" accept="video/*" multiple="true">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="modal bst-modal" id="modal_cusvideo">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm modal-lg">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <!-- <h4 class="modal-title">Khách hàng chia sẻ</h4> -->
            <button type="button" class="close" data-dismiss="modal">×</button>
          </div>
          <!-- Modal body -->
          <!-- Modal body -->
          <div class="modal-body edit-coll">
            <video controls="controls">
                <source src="" type="video/mp4">
            </video>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>

<div class="modal bst-modal" id="active"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hoạt động</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body edit-coll box-active">
            <form action="">
                <div class="form-group text-center">                  
                    <div id="crop-zone">
                      <img class="img-active text-center" id="" src="/templates/home/images/svg/add_avata.svg">
                    </div>
                    <label class="col-form-label f13 mt10">Thêm ảnh / thay đổi
                      <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                        <input type="file" class="form-control" name="" accept="image/video" id="reviewImg_active" style="display:none">
                      </span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Tiêu đề / Tên sự kiện</label>
                    <input type="text" autocomplete="off" name="active_title" class="ten-bst-input" placeholder="Tiêu đề / Tên sự kiện" maxlength="250">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Ngày - Tháng - năm</label>
                    <input type="date" autocomplete="off" name="active_date" id="" class="ten-bst-input hasDatepicker" placeholder="Ngày - Tháng - năm" maxlength="20">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Mô tả</label>
                    <input type="text" autocomplete="off" name="active_desc" class="ten-bst-input" placeholder="Mô tả" maxlength="250">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Video</label>
                </div>
                <div class="form-group">
                    <label><input type="radio" name="select_video" id="select_urlvideo" value="0"> Nhập liên kết video</label>
                    <label><input type="radio" name="select_video" id="select_video" value="1"> Upload video</label>
                </div>
                <div class="form-group active_urlvideo hidden">
                    <input type="text" autocomplete="off" name="active_urlvideo" class="ten-bst-input" placeholder="Liên kết video" maxlength="250">
                    <div class="">
                        <label class="show_urlvideo">Xem liên kết nhúng video cho phép</label>
                        <p class="hidden note_urlvideo">
                            <br/><b>1: https://www.youtube.com/embed/id video youtube</b>
                            <br/>VD: https://www.youtube.com/watch?v=JobxY7q35R0
                            <br>(Link nhúng: https://www.youtube.com/embed/JobxY7q35R0)

                            <br/><b>2: https://player.vimeo.com/video/id video vimeo</b>
                            <br/>VD1: https://vimeo.com/345922827, id video video là 345922827
                            <br>(Link nhúng: https://player.vimeo.com/video/345922827)

                            <br/>VD2: https://vimeo.com/channels/299027/14482320
                            <br>(Link nhúng: https://player.vimeo.com/video/14482320)

                            <br/><b>3: https://player.twitch.tv/?channel=tên kênh twitch</b>
                            <br/>VD: https://www.twitch.tv/beyondthesummit, tên kênh là beyondthesummit
                            <br>(Link nhúng: https://player.twitch.tv/?channel=beyondthesummit)

                            <br/><b>4: https://player.twitch.tv/?video=id video twitch</b>
                            <br/>VD: https://www.twitch.tv/videos/451329098
                            <br>(Link nhúng: https://player.twitch.tv/?video=451329098)

                            <br/><b>5: https://clips.twitch.tv/embed?clip=tên clip</b>
                            <br/>VD: https://clips.twitch.tv/TallTubularYogurtPeteZaroll
                            <br>(Link nhúng: https://clips.twitch.tv/embed?clip=TallTubularYogurtPeteZaroll)
                        </p>
                    </div>    
                </div>
                <div class="form-group active_video hidden">
                    <input type="file" name="active_video" id="active_video" accept="video/*" multiple="true">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Liên kết ngoài</label>
                    <input type="text" autocomplete="off" name="active_url" class="ten-bst-input" placeholder="Liên kết ngoài" maxlength="250">
                </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer buttons-group">
            <div class="bst-group-button">  
              <div class="left"></div>
              <div class="right">
                <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
                <button type="button" class="btn btn-border-pink" data-dismiss="modal">Hủy</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- END MODAL -->
<?php $this->load->view('home/common/load_wrapp'); ?>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('.js-customer-comment').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      arrows: false
    });

    function emptySelectBoxById(eid, value) {
        if (value) {
            var text = "";
            $.each(value, function (k, v) {
                //display the key and value pair
                if (k != "") {
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
            });
            document.getElementById(eid).innerHTML = text;
            delete text;
        }
    }

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    if($(window).width() < 1024){
        $('.introduct-page .bst-modal').on('shown.bs.modal', function(){
            var height_window = $(window).height();
            var modal_header = $('.bst-modal .modal-header').outerHeight();
            var modal_footer = $('.bst-modal .modal-footer').outerHeight();
            height_body = height_window - (modal_header+modal_footer);
            $('.bst-modal .modal-body').css('height',height_body+'px');
            $('#introduct textarea').css('height',height_body+'px');
        });
    }

    $('body').on('click','#introduct .btn_save', function(){
        $('.load-wrapp').show();
        var sho_introduct = $('.sho_introduction').val();
        $.ajax({
            url: siteUrl + 'home/shop/edit_introduct',
            data: {sho_introduct: sho_introduct},
            type: 'post',
            dataType : 'json',
            success: function(result){
                if(result.error == true){
                    alert('Lưu thông tin thất bại');
                    $('.load-wrapp').hide();
                }else{
                    location.reload();
                }
            },
            error: function(){
            }
        });
    });

    $('input[name="sho_address"]').on('keyup', function () {
        $('.check_kho').prop('checked', false);
    });

    $("#shop_provice").change(function () {
        if ($("#shop_provice").val()) {
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#shop_provice").val()},
                cache: true,
                success: function (response) {
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('shop_district', json, "");
                        delete json;
                        $('.check_kho').prop('checked', false);
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
    });

    $("#shop_district").change(function () {
        $('.check_kho').prop('checked', false);
    });

    $("#sho_kho_province").change(function () {
        $('.check_kho').prop('checked', false);
        if ($("#sho_kho_province").val()) {
            var package = '<?php echo $sho_package['id']?>';
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#sho_kho_province").val()},
                cache: true,
                success: function (response) {
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('sho_kho_district', json, "");
                        delete json;
                    } else {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                },
                error: function () {
                    alert("Lỗi! Vui lòng thử lại");
                }
            });
        }
    });

    $("#sho_kho_district").change(function () {
        $('.check_kho').prop('checked', false);
    });

    $('body').on('click', '.check_kho', function(){
        var sho_address = $('input[name="sho_address"]').val();
        var province = $('#shop_provice').val();
        var district = $('#shop_district').val();
        var province_kho = $('#sho_kho_province').val();
        if(province != ''){
            if($('.check_kho').prop('checked') == true){
                $('input[name="sho_kho_address"]').val(sho_address);
                $('#sho_kho_province option').each(function(){
                    if(province_kho == ''){
                        $(this).attr('selected', false);
                    }
                    if($(this).val() == province){
                        $(this).attr('selected', true);
                    }else{
                        $(this).attr('selected', false);
                    }
                });
                $.ajax({
                    async: false,
                    url: siteUrl + 'home/showcart/getDistrict',
                    type: "POST",
                    data: {user_province_put: province},
                    cache: true,
                    success: function (response) {
                        if (response) {
                            var json = JSON.parse(response);
                            emptySelectBoxById('sho_kho_district', json, "");
                            delete json;
                        } else {
                            alert("Lỗi! Vui lòng thử lại");
                        }
                    },
                    error: function () {
                        alert("Lỗi! Vui lòng thử lại");
                    }
                });

                $('#sho_kho_district option').attr('selected', false);

                $('#sho_kho_district option').each(function(){
                    if($(this).val() == district){
                        $(this).attr('selected', true);
                    }
                });
            }
        }else{
            $('.check_kho').prop('checked', false);
            alert('Bạn chưa chọn tỉnh/thành của công ty');
        }
    });

    $('body').on('click','#contact .btn_save', function(e){
        var error = false;
        var sho_name = $('input[name="sho_name"]').val();
        var sho_link = $('input[name="sho_link"]').val();
        var sho_address = $('input[name="sho_address"]').val();
        var province = $('#shop_provice').val();
        var district = $('#shop_district').val();
        var sho_kho_address = $('input[name="sho_kho_address"]').val();
        var sho_kho_province = $("#sho_kho_province").val();
        var sho_kho_district = $("#sho_kho_district").val();
        var sho_mobile = $('input[name="sho_mobile"]').val();
        var sho_phone = $('input[name="sho_phone"]').val();
        var shop_fax = $('input[name="shop_fax"]').val();
        var sho_email = $('input[name="sho_email"]').val();
        var sho_website = $('input[name="sho_website"]').val();
        var sho_taxcode = $('input[name="sho_taxcode"]').val();
        var sho_facebook = $('input[name="sho_facebook"]').val();
        var sho_youtube = $('input[name="sho_youtube"]').val();
        var sho_vimeo = $('input[name="sho_vimeo"]').val();

        if(sho_name == ''){
            error = true;
            alert("Bạn phải nhập tên của gian hàng");
            $('input[name="sho_name"]').focus();
            e.preventdefault();
        }

        if(sho_link == ''){
            error = true;
            alert("Bạn phải nhập liên kết của gian hàng");
            $('input[name="sho_link"]').focus();
            e.preventdefault();
        }else{
            var str = /[\W_]/;
            if(str.test(sho_link) == true){
                error = true;
                alert("Liên kết gian hàng chỉ chứa ký tự 0-9, a-z");
                $('input[name="sho_link"]').focus();
                e.preventdefault();
            }
        }

        if(sho_address == ''){
            error = true;
            alert("Bạn phải nhập địa chỉ của gian hàng");
            $('input[name="sho_address"]').focus();
            e.preventdefault();
        }
        if(province == ''){
            error = true;
            alert("Bạn chưa chọn tỉnh/thành của gian hàng");
            $("#shop_provice").focus();
            e.preventdefault();
        }
        if(district == ''){
            error = true;
            alert("Bạn chưa chọn quận/huyện của gian hàng");
            $("#shop_district").focus();
            e.preventdefault();
        }

        // if($('.check_kho').prop('checked') == true){
        if(sho_kho_address == ''){
            error = true;
            alert("Bạn phải nhập địa chỉ kho của gian hàng");
            $('input[name="sho_kho_address"]').focus();
            e.preventdefault();
        }
        if(sho_kho_province == ''){
            error = true;
            alert("Bạn chưa chọn tỉnh/thành kho của gian hàng");
            $('#sho_kho_province').focus();
            e.preventdefault();
        }
        if(sho_kho_district == ''){
            error = true;
            alert("Bạn chưa chọn quận/huyện kho của gian hàng");
            $('#sho_kho_district').focus();
            e.preventdefault();
        }
        // }

        if(sho_mobile != ''){
            var str = /\D/;
            if(sho_mobile.length != 10 || str.test(sho_mobile) == true){
                error = true;
                alert("Số điện thoại di động phải gồm 10 kí tự số từ 0-9");
                $('input[name="sho_mobile"]').focus();
                e.preventdefault();
            }
        }

        if(sho_phone != ''){
            var strphone = /\D/;
            if((sho_phone.length != 10 && sho_phone.length != 11) || strphone.test(sho_phone) == true){
                error = true;
                alert("Số điện thoại bàn phải gồm 10-11 kí tự số từ 0-9");
                $('input[name="sho_phone"]').focus();
                e.preventdefault();
            }
        }

        if(shop_fax != ''){
            var strfax = /\D/;
            if(strfax.test(shop_fax) == true){
                error = true;
                alert("Số fax chỉ chứa số từ 0-9");
                $('input[name="shop_fax"]').focus();
                e.preventdefault();
            }
        }

        if(sho_email != ''){
            if(isEmail(sho_email) == false){
                error = true;
                alert("Email không hợp lệ");
                $('input[name="sho_email"]').focus();
                e.preventdefault();
            }
        }

        if(sho_website != ''){
            if(sho_website.indexOf('http://') == 0 || sho_website.indexOf('https://') == 0){
            }else{
                error = true;
                alert('Website công ty bạn nhập phải có http:// hoặc https://');
                $('input[name="sho_website"]').focus();
                e.preventdefault();
            }
        }

        if(sho_facebook != ''){
            var check_fb = sho_facebook.split('/');
            if(/ /.test(sho_facebook) == false && ((check_fb[0] == 'http:' || check_fb[0] == 'https:') && (check_fb[2] == 'fb.com' || check_fb[2] == 'www.fb.com' || check_fb[2] == 'www.facebook.com' || check_fb[2] == 'facebook.com'))){
            }else{
                error = true;
                var mss = '***Lưu ý: \n- Liên kết facebook không được chứa khoảng trắng.';
                mss += '\n- Cấu trúc liên kết facebook hợp lệ: \n1. http://fb.com/ (hoặc https://fb.com/)';
                mss += '\n2. http://www.fb.com/ (hoặc https://www.fb.com/)';
                mss += '\n3. http://facebook.com/ (hoặc https://facebook.com/)';
                mss += '\n4. http://www.facebook.com/ (hoặc https://www.facebook.com/)';
                alert(mss);
                $('input[name="sho_facebook"]').focus();
                e.preventdefault();
            }
        }

        if(sho_youtube != ''){
            var check_yt = sho_youtube.split('/');
            if(/ /.test(sho_youtube) == false && ((check_yt[0] == 'http:' || check_yt[0] == 'https:') && (check_yt[2] == 'youtube.com' || check_yt[2] == 'www.youtube.com') && check_yt[3] == 'channel'))
            {
            }else{
                error = true;
                var mss = '***Lưu ý: \n- Liên kết kênh youtube không được chứa khoảng trắng.';
                mss += '\n- Cấu trúc liên kết kênh youtube hợp lệ: \n1. http://youtube.com/channel/ (hoặc https://youtube.com/channel/)';
                mss += '\n2. http://www.youtube.com/channel/ (hoặc https://www.youtube.com/channel/)';
                alert(mss);
                $('input[name="sho_youtube"]').focus();
                e.preventdefault();
            }
        }

        if(sho_vimeo != ''){
            var check_vm = sho_vimeo.split('/');
            if(/ /.test(sho_vimeo) == false && ((check_vm[0] == 'http:' || check_vm[0] == 'https:') && check_vm[2] == 'vimeo.com'))
            {
            }else{
                error = true;
                var mss = '***Lưu ý: \n- Liên kết kênh vimeo không được chứa khoảng trắng.';
                mss += '\n- Cấu trúc liên kết kênh vimeo hợp lệ: \nhttp://vimeo.com/ (hoặc https://vimeo.com/)';
                alert(mss);
                $('input[name="sho_vimeo"]').focus();
                e.preventdefault();
            }
        }

        if(sho_taxcode != ''){
            var strshotax = /\D/;
            if((sho_taxcode.length != 10 && sho_taxcode.length != 13) || strshotax.test(sho_taxcode) == true)
            {
                error = true;
                alert("Mã số thuế gồm 10 hoặc 13 chữ số từ 0-9");
                $('input[name="sho_taxcode"]').focus();
                e.preventdefault();
            }
        }

        if(error == false){
            $('.load-wrapp').show();
            $.ajax({
                url: siteUrl + 'home/shop/edit_contact',
                data: $('#contact form').serialize(),
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        if(result.message != ''){
                            $('.load-wrapp').hide();
                            alert(result.message);
                        }else{
                            var host = window.location.host;
                            var check = host.includes('<?php echo domain_site ?>');
                            if(check == true){
                                window.location.href = 'http://'+sho_link+'<?php echo '.'.domain_site ?>/shop/introduct';
                            }else{
                                location.reload();
                            }
                        }
                    }
                },
                error: function(){
                }
            });
        }
    });

    //Time work
    $('body').on('click','.hide_timework', function(){
        // $('.box-table').css('height','auto');
        $('.box-table').fadeOut();
        $('.box-table table').fadeOut();
        $(this).attr('class','sm text-right show_timework cursor-pointer');
        $(this).html('<b>Hiển thị</b>');
    });

    $('body').on('click','.show_timework', function(){
        // $('.box-table').css('height','245px');
        $('.box-table').fadeIn();
        $('.box-table table').fadeIn();
        $(this).attr('class','sm text-right hide_timework cursor-pointer');
        $(this).html('<b>Ẩn</b>');
    });

    var select_type_time = $('ul.editTimeworks-select-option input[type="radio"]').val();
    $('body').on('click','ul.editTimeworks-select-option input[type="radio"]', function(){
        var select = $(this).val();
        select_type_time = select;
        if(select == 1){
            $('.editTimeworks-input-time').show();
            $('.editTimeworks-input-time').removeClass(' hidden');
        }else{
            $('.editTimeworks-input-time').hide();
        }
    });

    $('body').on('click','.a-clockpicker', function(){
        var id = $(this).attr('data');
        var index = $(this).attr('data-index');
        var parent = $(this).parent().parent().attr('data-name');
        var at = '';
        var place = '';
        var is_read = $(this).attr('readonly');
        if(index == 0){
            at = 'left';
        }else{
            at = 'right';
        }

        if(parent == 'friday' || parent == 'saturday' || parent == 'sunday'){
            place = 'top';
        }else{
            place = 'bottom';
        }

        if($(this).attr('readonly') == undefined){
            if($( window ).width() > 1024){
                $(this).clockpicker({
                    placement: place,
                    align: at,
                    autoclose: true,
                    'default': 'now'
                });
            }
            $(".popover").addClass(parent);
        }else{
            $(".popover."+parent).css('display', 'none');
        }
    });

    $('#timework').scroll(function() {
        $(".popover").css('display','none');
    });

    $('body').on('click','#timework .btn_save', function(){
        var error = false;
        var sho_id = $('.sho_introduction').data('id');
        var sho_introduct = $('.sho_introduction').val();
        var form_time = new FormData();
        var check_time = false;
        
        form_time.append('status_time',select_type_time);

        if(select_type_time == 1){
            var check_weekday = $('.checkbox-style input[type="checkbox"]');
            check_weekday.each(function(index, value){
                if($(this).prop('checked') == true){
                    var length = $(this).parent().parent().find('input[type="time"]');
                    length.each(function(at, item){
                        if($(this).val() == ''){
                            error = true;
                        }
                    });
                    check_time = true;
                }else{
                    $(this).parent().parent().find('input[type="time"]').attr('readonly',true);
                }
            });

            if(check_time == false){
                alert('Bạn phải chọn ít nhất 1 ngày trong tuần để nhập thời gian làm việc');
            }else{

                var monday_am_start = '';
                var monday_am_end = '';
                var monday_pm_start = '';
                var monday_pm_end = '';
                if($('input[name="check_monday"]').prop('checked') == true){
                    $('input[name^="monday"]').each(function(at, item) {
                        if(at <= 1){
                            // monday_am.push($(this).val());
                            if(at % 2 == 0){
                                monday_am_start = $(this).val();
                            }else{
                                monday_am_end = $(this).val();
                            }
                        }else{
                            // monday_pm.push($(this).val());
                            if(at % 2 == 0){
                                monday_pm_start = $(this).val();
                            }else{
                                monday_pm_end = $(this).val();
                            }
                        }
                    });

                    form_time.append('monday[on]', 1);
                    form_time.append('monday[am][start]', monday_am_start);
                    form_time.append('monday[am][end]', monday_am_end);
                    if(monday_pm_start != ''){
                        form_time.append('monday[pm][start]', monday_pm_start);
                        form_time.append('monday[pm][end]', monday_pm_end);
                    }
                }
                else{
                    form_time.append('monday[on]', 0);
                }

                var tuesday_am_start = '';
                var tuesday_am_end = '';
                var tuesday_pm_start = '';
                var tuesday_pm_end = '';
                if($('input[name="check_tuesday"]').prop('checked') == true){
                    $('input[name^="tuesday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                tuesday_am_start = $(this).val();
                            }else{
                                tuesday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                tuesday_pm_start = $(this).val();
                            }else{
                                tuesday_pm_end = $(this).val();
                            }
                        }
                    });

                    form_time.append('tuesday[am][start]', tuesday_am_start);
                    form_time.append('tuesday[am][end]', tuesday_am_end);
                    form_time.append('tuesday[on]', 1);
                    if(tuesday_pm_start != ''){
                        form_time.append('tuesday[pm][start]', tuesday_pm_start);
                        form_time.append('tuesday[pm][end]', tuesday_pm_end);
                    }
                }else{
                    form_time.append('tuesday[on]', 0);
                }

                var wednesday_am_start = '';
                var wednesday_am_end = '';
                var wednesday_pm_start = '';
                var wednesday_pm_end = '';

                if($('input[name="check_wednesday"]').prop('checked') == true){
                    $('input[name^="wednesday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                wednesday_am_start = $(this).val();
                            }else{
                                wednesday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                wednesday_pm_start = $(this).val();
                            }else{
                                wednesday_pm_end = $(this).val();
                            }
                        }
                    });
                    form_time.append('wednesday[am][start]', wednesday_am_start);
                    form_time.append('wednesday[am][end]', wednesday_am_end);
                    form_time.append('wednesday[on]', 1);
                    if(wednesday_pm_start != ''){
                        form_time.append('wednesday[pm][start]', wednesday_pm_start);
                        form_time.append('wednesday[pm][end]', wednesday_pm_end);
                    }
                }else{
                    form_time.append('wednesday[on]', 0);
                }

                var thursday_am_start = '';
                var thursday_am_end = '';
                var thursday_pm_start = '';
                var thursday_pm_end = '';
                if($('input[name="check_thursday"]').prop('checked') == true){
                    $('input[name^="thursday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                thursday_am_start = $(this).val();
                            }else{
                                thursday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                thursday_pm_start = $(this).val();
                            }else{
                                thursday_pm_end = $(this).val();
                            }
                        }
                    });

                    form_time.append('thursday[am][start]', thursday_am_start);
                    form_time.append('thursday[am][end]', thursday_am_end);
                    form_time.append('thursday[on]', 1);
                    if(thursday_pm_start != ''){
                        form_time.append('thursday[pm][start]', thursday_pm_start);
                        form_time.append('thursday[pm][end]', thursday_pm_end);
                    }
                }else{
                    form_time.append('thursday[on]', 0);
                }

                var friday_am_start = '';
                var friday_am_end = '';
                var friday_pm_start = '';
                var friday_pm_end = '';
                if($('input[name="check_friday"]').prop('checked') == true){
                
                    $('input[name^="friday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                friday_am_start = $(this).val();
                            }else{
                                friday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                friday_pm_start = $(this).val();
                            }else{
                                friday_pm_end = $(this).val();
                            }
                        }
                    });

                    form_time.append('friday[am][start]', friday_am_start);
                    form_time.append('friday[am][end]', friday_am_end);
                    form_time.append('friday[on]', 1);
                    if(friday_pm_start != ''){
                        form_time.append('friday[pm][start]', friday_pm_start);
                        form_time.append('friday[pm][end]', friday_pm_end);
                    }
                }else{
                    form_time.append('friday[on]', 0);
                }

                var saturday_am_start = '';
                var saturday_am_end = '';
                var saturday_pm_start = '';
                var saturday_pm_end = '';
                if($('input[name="check_saturday"]').prop('checked') == true){
                    $('input[name^="saturday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                saturday_am_start = $(this).val();
                            }else{
                                saturday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                saturday_pm_start = $(this).val();
                            }else{
                                saturday_pm_end = $(this).val();
                            }
                        }
                    });
                    form_time.append('saturday[am][start]', saturday_am_start);
                    form_time.append('saturday[am][end]', saturday_am_end);
                    form_time.append('saturday[on]', 1);
                    if(saturday_pm_start != ''){
                        form_time.append('saturday[pm][start]', saturday_pm_start);
                        form_time.append('saturday[pm][end]', saturday_pm_end);
                    }
                }else{
                    form_time.append('saturday[on]', 0);
                }
                
                var sunday_am_start = '';
                var sunday_am_end = '';
                var sunday_pm_start = '';
                var sunday_pm_end = '';
                if($('input[name="check_sunday"]').prop('checked') == true){
                
                    $('input[name^="sunday"]').each(function(at, item) {
                        if(at <= 1){
                            if(at % 2 == 0){
                                sunday_am_start = $(this).val();
                            }else{
                                sunday_am_end = $(this).val();
                            }
                        }else{
                            if(at % 2 == 0){
                                sunday_pm_start = $(this).val();
                            }else{
                                sunday_pm_end = $(this).val();
                            }
                        }
                    });
                    form_time.append('sunday[am][start]', sunday_am_start);
                    form_time.append('sunday[am][end]', sunday_am_end);
                    form_time.append('sunday[on]', 1);
                    if(sunday_pm_start != ''){
                        form_time.append('sunday[pm][start]', sunday_pm_start);
                        form_time.append('sunday[pm][end]', sunday_pm_end);
                    }
                }else{
                    form_time.append('sunday[on]', 0);
                }
            }
        }
        else{
            check_time = true;
        }

        if(check_time == true){
            if(error == false){
                $.ajax({
                    url: siteUrl + 'home/shop/edit_timework',
                    data: form_time,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    success: function(result){
                        if(result.error == true){
                            alert('Lưu thông tin thất bại');
                        }else{
                            location.reload();
                        }
                    },
                    error: function(){
                    }
                });
            }else{
                if(select_type_time == 1){
                    alert('Bạn không được để trống thời gian làm việc');
                }
            }
        }
    });

    $('body').on('click','.js-add-time', function(){
        var id = $(this).attr('data');
        var html;
        html = '<div class="input-time-form clockpicker-'+id+'" data-name="'+id+'">';
        html += '<div class="form-group clock-'+id+'-pm0">';
        html += '<input name="'+id+'[pm][0]" type="time" class="form-control a-clockpicker" data="'+id+'-pm0" data-index="0">';
        html += '</div>';
        html += '<div class="mr20">-</div>';
        html += '<div class="form-group clock-'+id+'-pm1">';
        html += '<input name="'+id+'[pm][1]" type="time" class="form-control a-clockpicker" data="'+id+'-pm1" data-index="1">';
        html += '</div>';
        html += '<i class="fa fa-times-circle js-remove-time js-remove-time-'+id+'" data="'+id+'" aria-hidden="true"></i>';
        html += '</div>';
        $(this).parent().parent().append(html);
        $(this).remove();
        $('.clockpicker-'+id+' input[type="time"]').trigger('click');
    });

    $('body').on('click','.js-remove-time', function(){
        var id = $(this).attr('data');
        $(this).parent('.input-time-form').remove();
        $('.input-time-'+id+' .input-time-form').append('<i class="fa fa-plus-circle js-add-time" data="'+id+'" aria-hidden="true"></i>');
    });

    $('#timework').on('show.bs.modal', function(){
        var check_weekday = $('.checkbox-style input[type="checkbox"]');
        check_weekday.each(function(index, value){
            if($(this).attr('checked') == undefined){
                $('.editTimeworks-input-time li').eq(index).find('input[type="time"]').attr('readonly',true);
                $('.editTimeworks-input-time li').eq(index).find('i.fa').css('display','none');
            }
        });
        check_weekday.on("click", function(){
            if($(this).prop('checked') == true){
                $(this).parent().parent().find('input[type="time"]').attr('readonly',false);
                $(this).parent().parent().find('i.fa').css('display','block');
                $(this).parent().parent().find('input[type="time"]').trigger('click');
            } else {
                var get_class = $(this).attr('class');
                $('.popover.'+get_class).css('display', 'none');//.remove();//
                $(this).parent().parent().find('input[type="time"]').attr('readonly',true);
                $(this).parent().parent().find('i.fa').css('display','none');
                $(this).parent().parent().find('input[type="time"]')
            }
        });

        $('input[type="time"]').each(function(at, item){
            $(this).trigger('click');
        });
    });

    //End time work

    //company team
    var new_src = null;

    $(document).on('change','#reviewImg', function(){
        if(this.files && this.files.length > 0){
            // $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $('#crop-zone').empty().append('<img class="reviewImg text-center" id="reviewImg" src="">');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $('.avata-team').width();
                            $('#reviewImg').attr('src', e.target.result);

                            var dkrm = new Darkroom('#reviewImg', {
                                maxWidth: getWidth,
                                minHeight: 450,
                                plugins: {
                                    save: false,
                                    crop: {
                                        ratio: 1
                                    }
                                },
                                initialize: function() {
                                    var cropPlugin = this.plugins['crop'];
                                    cropPlugin.selectZone(50, 50, 600, 600);
                                    var images_crop = this;
                                    $('.avata-team').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                    $('.avata-team').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                                    $('.avata-team .darkroom-button-group').eq(0).addClass(' reload');
                                    $('.darkroom-button-group.reload .darkroom-button').eq(1).hide();
                                    
                                    this.addEventListener('core:transformation', function() {
                                        newImage = images_crop.sourceImage.toDataURL();
                                        
                                        $('.avata-team').find('.darkroom-toolbar .luu_image').show();
                                        $('.avata-team').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                        $('.avata-team .darkroom-button-group').eq(2).addClass(' crop');
                                        
                                        $('body').on('click', '.darkroom-button-group.reload, .darkroom-button-group.crop', function(){
                                            $('.avata-team').find('.darkroom-toolbar .luu_image').hide();
                                            $('.avata-team').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                        });
                                        
                                        new_src = newImage;
                                    });
                                }
                            });
                        }
                    };
                };
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $(document).on('click','.avata-team .luu_image',function(){
        var newImage = new_src;
        $('.avata-team #crop-zone').html('<img class="avatar_team text-center" id="" src="'+newImage+'">');
        if($('.avata-team .team_avatar').length > 0){
            $('.avata-team .team_avatar').val(newImage);
        }else{
            $('form').append('<input class="team_avatar hidden" name="team_avatar" value="'+newImage+'"/>');
        }
    });

    $('.add-team').on('click', function(){
        $('#company_team').attr('class','modal bst-modal add-team');
    });

    $('body').on('click','.add-team .btn_save', function(e){
        var error = false;

        if($('.avata-team input[name="team_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập họ tên thành viên công ty");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_role"]').val() == ''){
            error = true;
            alert("Bạn phải nhập chức danh/vị trí của thành viên công ty");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_facebook"]').val() != ''){
            var _this = $('.avata-team input[name="team_facebook"]').val();

            if(_this == 'https://www.facebook.com' || _this.indexOf('https://www.facebook.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của facebook:\nhttps://www.facebook.com/....');
                e.preventdefault();
            }
        }

        if($('.avata-team input[name="team_linkedin"]').val() != ''){
            var _this = $('.avata-team input[name="team_linkedin"]').val();

            if(_this == 'https://www.linkedin.com' || _this.indexOf('https://www.linkedin.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của linkedin:\nhttps://www.linkedin.com/....');
                e.preventdefault();
            }
            
        }

        if($('.avata-team input[name="team_instagram"]').val() != ''){
            var _this = $('.avata-team input[name="team_instagram"]').val();

            if(_this == 'https://www.instagram.com' || _this.indexOf('https://www.instagram.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của instagram:\nhttps://www.instagram.com/....');
                e.preventdefault();
            }
        }

        if($('.avata-team input[name="team_azibai"]').val() != ''){
            var url = $('.avata-team input[name="team_azibai"]').val();
            error= true;
            if(url.indexOf('http://') == 0 || url.indexOf('https://') == 0){
                $.ajax({
                    async: false,
                    url: siteUrl + 'home/shop/check_azi',
                    data: {url: url},
                    type: 'post',
                    dataType : 'json',
                    success: function(result){
                        if(result.check == false){
                            alert('Liên kết đến trang azibai không đúng');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    },
                    error: function(){
                    }
                });
            }else{
                alert('Liên kết đến trang azibai phải có http:// hoặc https://');
                e.preventdefault();
            }
        }

        if(error == false){
            $('.load-wrapp').show();
            $.ajax({
                url: siteUrl + 'home/shop/add_team',
                data: $('#company_team form').serialize(),
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('.edit-team').on('click', function(){
        var team_id = $(this).attr('data');
        var modal = '#company_team';
        $(modal).attr('class','modal bst-modal edit-team');
        $(modal+' .btn_save').attr('data',team_id);
        $(modal+' .bst-group-button .left').html('<button type="button" class="btn btn-border-pink btn_delete" data="'+team_id+'">Xóa</button>');

        $.ajax({
            url: siteUrl + 'home/shop/info_team',
            data: {team_id: team_id},
            type: 'post',
            dataType : 'json',
            success: function(result){
                $('.avatar_team').attr('src',result.team_avatar);
                $('input[name="team_name"]').val(result.team_name);
                $('input[name="team_role"]').val(result.team_role);
                $('input[name="team_desc"]').val(result.team_desc);
                $('input[name="team_facebook"]').val(result.team_facebook);
                // $('input[name="team_twitter"]').val(result.team_twitter);
                $('input[name="team_linkedin"]').val(result.team_linkedin);
                $('input[name="team_instagram"]').val(result.team_instagram);
                $('input[name="team_azibai"]').val(result.team_azibai);
                $(modal+' form').append('<input class="hidden" name="team_id" value="'+team_id+'"/>');
                $(modal+' form').append('<input class="team_avatar hidden" name="team_avatar" value="'+result.team_avatar+'"/>');
            },
            error: function(){
            }
        });
    });

    $('body').on('click','.edit-team .btn_save', function(e){
        var error = false;
        var team_id = $(this).attr('data');
        if($('.avata-team input[name="team_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập họ tên thành viên công ty");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_role"]').val() == ''){
            error = true;
            alert("Bạn phải nhập chức danh/vị trí của thành viên công ty");
            e.preventdefault();
        }

        if($('.avata-team input[name="team_facebook"]').val() != ''){
            var _this = $('.avata-team input[name="team_facebook"]').val();

            if(_this == 'https://www.facebook.com' || _this.indexOf('https://www.facebook.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của facebook:\nhttps://www.facebook.com/....');
                e.preventdefault();
            }
        }

        if($('.avata-team input[name="team_linkedin"]').val() != ''){
            var _this = $('.avata-team input[name="team_linkedin"]').val();

            if(_this == 'https://www.linkedin.com' || _this.indexOf('https://www.linkedin.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của linkedin:\nhttps://www.linkedin.com/....');
                e.preventdefault();
            }
            
        }

        if($('.avata-team input[name="team_instagram"]').val() != ''){
            var _this = $('.avata-team input[name="team_instagram"]').val();

            if(_this == 'https://www.instagram.com' || _this.indexOf('https://www.instagram.com/') == 0){
            }else{
                alert('Bạn phải nhập đúng đường dẫn của instagram:\nhttps://www.instagram.com/....');
                e.preventdefault();
            }
        }

        if($('.avata-team input[name="team_azibai"]').val() != ''){
            var url = $('.avata-team input[name="team_azibai"]').val();
            error= true;
            if(url.indexOf('http://') == 0 || url.indexOf('https://') == 0){
                $.ajax({
                    async: false,
                    url: siteUrl + 'home/shop/check_azi',
                    data: {url: url},
                    type: 'post',
                    dataType : 'json',
                    success: function(result){
                        if(result.check == false){
                            alert('Liên kết đến trang azibai không đúng');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    },
                    error: function(){
                    }
                });
            }else{
                alert('Liên kết đến trang azibai phải có http:// hoặc https://');
                e.preventdefault();
            }
        }

        if(error == false){
            $('.load-wrapp').show();
            $.ajax({
                url: siteUrl + 'home/shop/update_team',
                data: $('#company_team form').serialize(),
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click','.edit-team .btn_delete', function(e){
        var error = false;
        var team_id = $(this).attr('data');

        if(error == false){
            $.ajax({
                url: siteUrl + 'home/shop/delete_team',
                data: {team_id : team_id},
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        alert('Xóa thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('#company_team').on('hidden.bs.modal', function(){
        $('img.avatar_team').attr('src','/templates/home/images/svg/add_avata.svg');
        $('input[name="team_name"]').val('');
        $('input[name="team_role"]').val('');
        $('input[name="team_desc"]').val('');
        $('input[name="team_facebook"]').val('');
        // $('input[name="team_twitter"]').val('');
        $('input[name="team_linkedin"]').val('');
        $('input[name="team_instagram"]').val('');
        $('input[name="team_azibai"]').val('');
        $('input[name="team_id"]').remove();
        $('input[name="team_avatar"]').remove();
        $('#company_team .btn_delete').remove();
    });

    //certify

    var src_certify = null;

    $(document).on('change','#reviewImg_certify', function(){
        if(this.files && this.files.length > 0){
            // $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $('#certify_avatar').empty().append('<img class="text-center" id="reviewImg_certify" src="">');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $('.box-certify').width();
                            $('#reviewImg_certify').attr('src', e.target.result);
                            src_certify = e.target.result;
                        }
                    };
                };
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $('.add-certify').on('click', function(){
        $('#certify').attr('class','modal bst-modal add-certify');
    });

    $('body').on('click','.add-certify .btn_save', function(e){

        var newImage = src_certify;

        var error = false;

        if(newImage == null){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }else{
            $('#certify form').append('<input class="certify_avatar hidden" name="certify_avatar" value="'+newImage+'"/>');
        }

        if($('.box-certify input[name="certify_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập tên chứng nhận");
            e.preventdefault();
        }

        if($('.box-certify input[name="certify_released"]').val() == ''){
            error = true;
            alert("Bạn phải Người cấp/đơn vị/hãng,công ty");
            e.preventdefault();
        }

        if($('.box-certify input[name="certify_year"]').val() == ''){
            error = true;
            alert("Bạn phải chọn năm chứng nhận được cấp");
            e.preventdefault();
        }

        if(error == false){
            $('.load-wrapp').show();
            $.ajax({
                url: siteUrl + 'home/shop/add_certify',
                data: $('#certify form').serialize(),
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('.edit-certify').on('click', function(){
        var certify_id = $(this).attr('data');
        var modal = '#certify';
        $(modal).attr('class','modal bst-modal edit-certify');
        $(modal+' .btn_save').attr('data',certify_id);
        $(modal+' .bst-group-button .left').html('<button type="button" class="btn btn-border-pink btn_delete" data="'+certify_id+'">Xóa</button>');

        $.ajax({
            url: siteUrl + 'home/shop/info_certify',
            data: {certify_id: certify_id},
            type: 'post',
            dataType : 'json',
            success: function(result){
                $('.img-certify').attr('src',result.certify_avatar);
                $('input[name="certify_name"]').val(result.certify_name);
                $('input[name="certify_released"]').val(result.certify_released);
                $('input[name="certify_year"]').val(result.certify_year);
                $(modal+' form').append('<input class="hidden" name="certify_id" value="'+certify_id+'"/>');
                $(modal+' form').append('<input class="certify_avatar hidden" name="certify_avatar" value="'+result.certify_avatar+'"/>');
            },
            error: function(){
            }
        });
    });

    $('body').on('click','.edit-certify .btn_save', function(e){
        var error = false;
        var certify_id = $(this).attr('data');
        var newImage = src_certify;
        // $('form').append('<input class="hidden" name="certify_id" value="'+certify_id+'"/>');
        if(newImage){
            if(newImage == null){
                error = true;
                alert("Bạn phải upload ảnh");
                e.preventdefault();
            }else{
                $('.box-certify input[name="certify_avatar"]').val(newImage);
            }
        }

        if($('.box-certify input[name="certify_avatar"]').length == false){
            //error = true;
        }

        if($('.box-certify input[name="certify_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập tên chứng nhận");
            e.preventdefault();
        }

        if($('.box-certify input[name="certify_released"]').val() == ''){
            error = true;
            alert("Bạn phải Người cấp/đơn vị/hãng,công ty");
            e.preventdefault();
        }

        if($('.box-certify input[name="certify_year"]').val() == ''){
            error = true;
            alert("Bạn phải chọn năm chứng nhận được cấp");
            e.preventdefault();
        }

        if(error == false){
            $('.load-wrapp').show();
            $.ajax({
                url: siteUrl + 'home/shop/update_certify',
                data: $('#certify form').serialize(),
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click','.edit-certify .btn_delete', function(e){
        var error = false;
        var certify_id = $(this).attr('data');

        if(error == false){
            $.ajax({
                url: siteUrl + 'home/shop/delete_certify',
                data: {certify_id : certify_id},
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        alert('Xóa thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('#certify').on('hidden.bs.modal', function(){
        $('img.img-certify').attr('src','/templates/home/images/svg/add_avata.svg');
        $('input[name="certify_name"]').val('');
        $('input[name="certify_released"]').val('');
        $('input[name="certify_year"]').val('');
        $('input[name="certify_id"]').remove();
        $('input[name="certify_avatar"]').remove();
        $('#certify .btn_delete').remove();
    });

    //customer-------------------------------------------------------------------------
    var new_src = null;

    $(document).on('change','#reviewImg_customer', function(){
        if(this.files && this.files.length > 0){
            var box = '.box-customer';
            var img_review = '#reviewImg_customer';
            // $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $(box+' #crop-zone').empty().append('<img class="reviewImg text-center" id="reviewImg_customer" src="">');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $(box).width();
                            $(img_review).attr('src', e.target.result);

                            var dkrm = new Darkroom(img_review, {
                                maxWidth: getWidth,
                                minHeight: 450,
                                plugins: {
                                    save: false,
                                    crop: {
                                        ratio: 1
                                    }
                                },
                                initialize: function() {
                                    var cropPlugin = this.plugins['crop'];
                                    cropPlugin.selectZone(50, 50, 600, 600);
                                    var images_crop = this;
                                    $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                    $(box).find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                                    $(box+' .darkroom-button-group').eq(0).addClass(' reload');
                                    $('.darkroom-button-group.reload .darkroom-button').eq(1).hide();
                                    
                                    this.addEventListener('core:transformation', function() {
                                        newImage = images_crop.sourceImage.toDataURL();
                                        
                                        $(box).find('.darkroom-toolbar .luu_image').show();
                                        $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                        $(box+' .darkroom-button-group').eq(2).addClass(' crop');
                                        
                                        $('body').on('click', '.darkroom-button-group.reload, .darkroom-button-group.crop', function(){
                                            $(box).find('.darkroom-toolbar .luu_image').hide();
                                            $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                        });
                                        
                                        new_src = newImage;
                                    });
                                }
                            });
                        }
                    };
                };
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $(document).on('click','.box-customer .luu_image',function(){
        var newImage = new_src;
        $('.box-customer #crop-zone').html('<img class="img-customer text-center" id="" src="'+newImage+'">');
        if($('.box-customer .customer_avatar').length > 0){
            $('.box-customer .customer_avatar').val(newImage);
        }else{
            $('#customer form').append('<input class="customer_avatar hidden" name="customer_avatar" value="'+newImage+'"/>');
        }
    });

    var file;
    var up_video = false;

    $(document).on('change','#customer_video', function(){
        file = this.files[0];
        var fileReader = new FileReader();
        if(this.files[0].name != ''){
            up_video = true;
        }
    });

    $('.add-customer').on('click', function(){
        $('#customer').attr('class','modal bst-modal add-customer');
    });

    $('body').on('click','.add-customer .btn_save', function(e){
        var error = false;

        if($('.box-customer input[name="customer_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($('.box-customer input[name="customer_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập họ tên khách hàng");
            e.preventdefault();
        }

        if($('.box-customer input[name="customer_quote"]').val() == '' && $('.box-customer input[name="customer_video"]').val() == ''){
            error = true;
            alert("Bạn phải nhập trích dẫn hoặc upload video");
            e.preventdefault();
        }

        if(error == false){
            $('.load-wrapp').show();
            var customer_name = $('input[name="customer_name"]').val();
            var customer_quote = $('input[name="customer_quote"]').val();
            var customer_avatar = $('input[name="customer_avatar"]').val();

            var form = new FormData();
            if(up_video == true){
                form.append('customer_video', file);
            }
            form.append('customer_id', $(this).attr('data'));
            form.append('customer_name', customer_name);
            form.append('customer_quote', customer_quote);
            form.append('customer_avatar', customer_avatar);

            $.ajax({
                url: siteUrl + 'home/shop/add_customer',
                data: form,
                type: 'post',
                processData: false,
                contentType: false,
                success: function(message){
                    if(message != ''){
                        $('.load-wrapp').hide();
                        alert('Lưu thông tin thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('.edit-customer').on('click', function(){
        var customer_id = $(this).attr('data');
        var modal = '#customer';
        $(modal).attr('class','modal bst-modal edit-customer');
        $(modal+' .btn_save').attr('data',customer_id);
        $(modal+' .bst-group-button .left').html('<button type="button" class="btn btn-border-pink btn_delete" data="'+customer_id+'">Xóa</button>');

        $.ajax({
            url: siteUrl + 'home/shop/info_customer',
            data: {customer_id: customer_id},
            type: 'post',
            dataType : 'json',
            success: function(result){
                // customer_id = result.customer_id;
                $('.img-customer').attr('src',result.customer_avatar);
                $('input[name="customer_name"]').val(result.customer_name);
                $('input[name="customer_quote"]').val(result.customer_quote);
                $(modal+' form').append('<input class="customer_avatar hidden" name="customer_avatar" value="'+result.customer_avatar+'"/>');
                if(result.customer_video != '' && result.customer_video != null){
                    var html_video = '';
                    html_video += '<video width="100px" height="50px">';
                    html_video +=     '<source src="'+result.customer_video+'" type="video/mp4">';
                    html_video += '</video> <a href="#" class="delete_customer_video" data="'+customer_id+'">Gỡ video</a>';
                }
                $(modal+' .cusvideo').html(html_video);
            },
            error: function(){
            }
        });
    });

    $('body').on('click','.edit-customer .btn_save', function(e){
        var error = false;
        if($('.box-customer input[name="customer_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($('.box-customer input[name="customer_name"]').val() == ''){
            error = true;
            alert("Bạn phải nhập họ tên khách hàng");
            e.preventdefault();
        }

        if($('.box-customer input[name="customer_quote"]').val() == '' && $('.box-customer input[name="customer_video"]').val() == ''){
            error = true;
            alert("Bạn phải nhập trích dẫn hoặc upload video");
            e.preventdefault();
        }

        if(error == false){
            $('.load-wrapp').show();
            var customer_name = $('input[name="customer_name"]').val();
            var customer_quote = $('input[name="customer_quote"]').val();
            var customer_avatar = $('input[name="customer_avatar"]').val();

            var form = new FormData();
            if(up_video == true){
                form.append('customer_video', file);
            }
            form.append('customer_id', $(this).attr('data'));
            form.append('customer_name', customer_name);
            form.append('customer_quote', customer_quote);
            form.append('customer_avatar', customer_avatar);

            $.ajax({
                url: siteUrl + 'home/shop/update_customer',
                data: form,
                type: 'post',
                processData: false,
                contentType: false,
                success: function(message){
                    if(message != ''){
                        $('.load-wrapp').hide();
                        alert(message);
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click','.edit-customer .btn_delete', function(e){
        var error = false;
        var customer_id = $(this).attr('data');

        if(error == false){
            $.ajax({
                url: siteUrl + 'home/shop/delete_customer',
                data: {customer_id : customer_id},
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        alert('Xóa thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click','.edit-customer .delete_customer_video', function(e){
        var error = false;
        var customer_id = $(this).attr('data');
        if($('.box-customer input[name="customer_quote"]').val() == '' && $('.box-customer input[name="customer_video"]').val() == ''){
            error = true;
            alert("Bạn phải nhập trích dẫn hoặc upload video khác trước khi xóa video");
            e.preventdefault();
        }

        if(error == false){
            $('.load-wrapp').show();
            var customer_quote = $('input[name="customer_quote"]').val();
            $.ajax({
                url: siteUrl + 'home/shop/delete_customer_video',
                data: {customer_id : customer_id, customer_quote: customer_quote},
                type: 'post',
                dataType : 'json',
                success: function(result){
                    if(result.error == true){
                        $('.load-wrapp').hide();
                        alert('Xóa thất bại');
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('#customer').on('hidden.bs.modal', function(){
        $('img.img-customer').attr('src','/templates/home/images/svg/add_avata.svg');
        $('input[name="customer_name"]').val('');
        $('input[name="customer_quote"]').val('');
        $('input[name="customer_id"]').remove();
        $('input[name="customer_avatar"]').remove();
        $('#customer .btn_delete').remove();
        $('#customer .cusvideo').html('');
    });

    $('body').on('click','.watch_customer', function(){
        var height = $(window).height();
        var url_video = $(this).data('src');
        var video = '<video controls="controls">';
            video +=     '<source src="'+url_video+'" type="video/mp4">';
            video += '</video>';
        $('#modal_cusvideo .modal-body').html(video);
        // $('#modal_cusvideo').modal('show');
    });

    $('#modal_cusvideo').on('hidden.bs.modal', function(){
        $('.modal-backdrop').remove();
        $("#modal_cusvideo video").attr('src','');
    });

    //END customer

    //Active

    $('.js-year').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      arrows: true
    });

    var width_video = $('.box-text').width();
    var height_ = width_video / 2;
    var top = height_/2;

    $('.embed-video').css({'height': height_, 'margin-top' : top+'px'});
    $('.js-slider-active video').css({'margin-top' : top+'px'});

    $('.js-year').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        var year = $('.js-year .slick-current.slick-active').text();
        var permission = $(this).data('permission');
        var style = 'height: '+height_+'px; margin-top: '+top+'px';

        var height_tagvideo = width_video * 0.55;
        var top_video = height_tagvideo/2;
        var style_video = 'margin-top: '+top_video+'px';
        $('.load-wrapp').show();

        $.ajax({
            url: siteUrl + 'home/shop/slider_activities',
            data: {active_year: year},
            type: 'post',
            dataType : 'json',
            success: function(result){
                var temp_slide = '';

                $('.item-year').html('');
                $(result).each(function(at, item){
                    temp_slide += '<div class="item-year-item">';
                        temp_slide += '<div class="item-year-item-title">'+item.active_title+'</div>';
                        temp_slide += '<div class="item-year-item-content">';
                            temp_slide += '<div class="smal-text">';
                                temp_slide += '<div class="date">'+item.active_date+'</div>';
                                if(permission == 1){
                                    temp_slide += '<div class="edit edit-active" data="'+item.id+'" data-toggle="modal" data-target="#active">Chỉnh sửa</div>';
                                }
                            temp_slide += '</div>';
                            temp_slide += '<div class="text">';
                                temp_slide += '<p>'+item.active_desc+'</p>';
                                temp_slide += '<div class="text js-load-video">';
                                    if(item.active_video != '' && item.active_video != null){
                                        temp_slide += '<video controls="controls" class="video-'+item.id+'" style="'+style_video+'" data="'+item.id+'">';
                                            temp_slide += '<source src="'+item.active_video+'" type="video/mp4"></source>';
                                        temp_slide += '</video>';
                                    }else{
                                        if(item.active_urlvideo != '' && item.active_urlvideo != null){
                                            temp_slide += '<iframe class="embed-video" src="'+item.active_urlvideo+'" style="'+style+'"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>';
                                            temp_slide += '</iframe>';
                                        }
                                    }
                                    temp_slide += '<p><img src="'+item.active_avatar+'" alt=""></p>';
                                temp_slide += '</div>';
                            temp_slide += '</div>';
                        temp_slide += '</div>';
                    temp_slide += '</div>';
                });

                $('.item-year').html(temp_slide);

                $('.js-load-video').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false
                });

                $('.js-load-video').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
                    var tag_name = slick.$slides[currentSlide].tagName;
                    if(tag_name != 'VIDEO'){
                        var this_vd = slick.$slides[0].classList[0];
                        var src = $('video.'+this_vd+' source').attr('src');
                        $('video.'+this_vd).trigger("pause");
                    }
                });
                $('.load-wrapp').hide();
            },
            error: function(){
            }
        });
        
    });

    $('.js-slider-active').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      arrows: false
    });
    
    $('label.show_urlvideo').click(function(){
        $('.note_urlvideo').show();
    });

    function onchange_slider(id){
        $('.video-'+id+' source').attr('src', $(this).attr('src'));
    }
    // $( "#datepicker" ).datepicker(function(){
    //     $(this).val();
    // });

    var new_src = null;

    $(document).on('change','#reviewImg_active', function(){
        if(this.files && this.files.length > 0){
            var box = '.box-active';
            var img_review = '#reviewImg_active';
            // $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $(box+' #crop-zone').empty().append('<img class="reviewImg text-center" id="reviewImg_active" src="">');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $(box).width();
                            $(img_review).attr('src', e.target.result);

                            var dkrm = new Darkroom(img_review, {
                                maxWidth: getWidth,
                                minHeight: 450,
                                plugins: {
                                    save: false,
                                    crop: {
                                        ratio: 1
                                    }
                                },
                                initialize: function() {
                                    var cropPlugin = this.plugins['crop'];
                                    cropPlugin.selectZone(50, 50, 600, 600);
                                    var images_crop = this;
                                    $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                    $(box).find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                                    $(box+' .darkroom-button-group').eq(0).addClass(' reload');
                                    $('.darkroom-button-group.reload .darkroom-button').eq(1).hide();
                                    
                                    this.addEventListener('core:transformation', function() {
                                        newImage = images_crop.sourceImage.toDataURL();
                                        
                                        $(box).find('.darkroom-toolbar .luu_image').show();
                                        $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                        $(box+' .darkroom-button-group').eq(2).addClass(' crop');
                                        
                                        $('body').on('click', '.darkroom-button-group.reload, .darkroom-button-group.crop', function(){
                                            $(box).find('.darkroom-toolbar .luu_image').hide();
                                            $(box).find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                        });
                                        
                                        new_src = newImage;
                                    });
                                }
                            });
                        }
                    };
                };
                reader.readAsDataURL(this.files[0]);
            }
        }
    });

    $(document).on('click','.box-active .luu_image',function(){
        var newImage = new_src;
        $('.box-active #crop-zone').html('<img class="img-active text-center" id="" src="'+newImage+'">');
        if($('.box-active .active_avatar').length > 0){
            $('.box-active .active_avatar').val(newImage);
        }else{
            $('form').append('<input class="active_avatar hidden" name="active_avatar" value="'+newImage+'"/>');
        }
    });

    var file_actvideo;
    var up_actvideo = false;

    $(document).on('change','#active_video', function(){
        file_actvideo = this.files[0];
        var fileReader = new FileReader();
        if(this.files[0].name != ''){
            up_actvideo = true;
        }
    });

    $('.add-active').on('click', function(){
        $('#select_urlvideo').trigger('click');
        $('#active').attr('class','modal bst-modal add-active');
    });

    var sl_video = '';
    $('body').on('click','input[name="select_video"]', function(e){
        if($(this).val() == 1){
            $('.active_video').removeClass(' hidden');
            $('.active_urlvideo').attr('class','form-group active_urlvideo hidden');
        }else{
            $('.active_urlvideo').removeClass(' hidden');
            $('.active_video').attr('class','form-group active_video hidden');
        }
        sl_video = $(this).val();
    });

    $('body').on('click','.add-active .btn_save', function(e){
        var error = false;
        var box = '.box-active';
        if($(box+' input[name="active_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($(box+' input[name="active_title"]').val() == ''){
            error = true;
            alert("Bạn phải nhập tiêu đề hoạt động");
            e.preventdefault();
        }

        if($(box+' input[name="active_date"]').val() == ''){
            error = true;
            alert("Bạn chưa chọn ngày diễn ra hoạt động");
            e.preventdefault();
        }

        if($(box+' input[name="active_desc"]').val() == ''){
            error = true;
            alert("Bạn phải nhập mô tả hoạt động");
            e.preventdefault();
        }

        if(sl_video == 1){
            if($(box+' input[name="active_video"]').val() == '')
            {
                error = true;
                alert("Bạn phải upload video");
                e.preventdefault();
            }
        }else{
            if($(box+' input[name="active_urlvideo"]').val() == ''){
                error = true;
                alert("Bạn phải nhập liên kết video");
                e.preventdefault();
            }else{
                var is_youtube = 'https://www.youtube.com/embed/';
                var is_vimeo = 'https://player.vimeo.com/video/';
                var is_twitch_channel = 'https://player.twitch.tv/?channel=';
                var is_twitch_video = 'https://player.twitch.tv/?video=';
                // var is_twitch_coll = 'https://player.twitch.tv/?collection=';
                var is_twitch_clip = 'https://clips.twitch.tv/embed?clip=';
                var act_urlvideo = $(box+' input[name="active_urlvideo"]').val();

                if(act_urlvideo.indexOf(is_youtube) == 0 || act_urlvideo.indexOf(is_vimeo) == 0 || act_urlvideo.indexOf(is_twitch_channel) == 0 || act_urlvideo.indexOf(is_twitch_video) == 0 || act_urlvideo.indexOf(is_twitch_clip) == 0){

                    error = true;
                    if(act_urlvideo.indexOf(is_youtube) == 0){
                        var arr_youtube = act_urlvideo.split('/');
                        if(arr_youtube[4] == '' || arr_youtube[4].indexOf(' ') >= 0){
                            alert('Id video của youtube phải được nhập và không được chứa khoảng trắng.\nVd: https://www.youtube.com/watch?v=GDV6xfwFOmE , id video là GDV6xfwFOmE\nLiên kết đúng: https://www.youtube.com/embed/GDV6xfwFOmE');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_vimeo) == 0){
                        var arr_vimeo = act_urlvideo.split('/');
                        if(arr_vimeo[4] == '' || arr_vimeo[4].indexOf(' ') >= 0){
                            alert('Id video của videmo phải được nhập và không được chứa khoảng trắng.\nVd: https://vimeo.com/237924280 , id video là 237924280\nLiên kết đúng: https://player.vimeo.com/video/237924280');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_channel) == 0){
                        var arr_channel = act_urlvideo.split('=');
                        if(arr_channel[1] == '' || arr_channel[1].indexOf(' ') >= 0){
                            alert('channel phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://player.twitch.tv/?channel=rush');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_video) == 0){
                        var arr_video = act_urlvideo.split('=');
                        if(arr_video[1] == '' || arr_video[1].indexOf(' ') >= 0){
                            alert('id video phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://player.twitch.tv/?video=v40464143');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_clip) == 0){
                        var arr_clip = act_urlvideo.split('=');
                        if(arr_clip[1] == '' || arr_clip[1].indexOf(' ') >= 0){
                            alert('Tên clip phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://clips.twitch.tv/embed?clip=TallTubularYogurtPeteZaroll');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }
                }else{
                    error= true;
                    alert('Cấu trúc liên kết video của bạn không hợp lệ, xem lại cấu trúc liên kết video cho phép');
                    e.preventdefault();
                }
            }
        }

        if($(box+' input[name="active_url"]').val() != ''){
            var url_act = $(box+' input[name="active_url"]').val();
            error= true;
            if(url_act.indexOf('http://') == 0 || url_act.indexOf('https://') == 0){
                error= false;
            }else{
                alert('Liên kết ngoài bạn nhập phải có http:// hoặc https://');
                e.preventdefault();
            }
        }

        if(error == false){
            $('.load-wrapp').show();
            var active_title = $('input[name="active_title"]').val();
            var active_date = $('input[name="active_date"]').val();
            var active_avatar = $('input[name="active_avatar"]').val();
            var active_desc = $('input[name="active_desc"]').val();
            var active_urlvideo = $('input[name="active_urlvideo"]').val();
            var active_url = $('input[name="active_url"]').val();

            var form_act = new FormData();
            if(sl_video == 1 && up_actvideo == true){
                form_act.append('active_video', file_actvideo);
            }else{
                form_act.append('active_urlvideo', active_urlvideo);
            }

            form_act.append('active_avatar', active_avatar);
            form_act.append('active_title', active_title);
            form_act.append('active_date', active_date);
            form_act.append('active_desc', active_desc);
            form_act.append('active_url', active_url);

            $.ajax({
                url: siteUrl + 'home/shop/add_activities',
                data: form_act,
                type: 'post',
                processData: false,
                contentType: false,
                success: function(message){
                    if(message != ''){
                        $('.load-wrapp').hide();
                        alert(message);
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click', '.detail .edit-active', function(){
        var active_id = $(this).attr('data');
        var modal = '#active';
        $(modal).attr('class','modal bst-modal edit-active');
        $(modal+' .btn_save').attr('data',active_id);
        $(modal+' .bst-group-button .left').html('<button type="button" class="btn btn-border-pink btn_delete" data="'+active_id+'">Xóa</button>');

        $.ajax({
            async: false,
            url: siteUrl + 'home/shop/info_activities',
            data: {active_id: active_id},
            type: 'post',
            dataType : 'json',
            success: function(result){
                if(result.active_video != '' && result.active_video != null){;
                    $('.active_video').removeClass(' hidden');
                    $('#select_video').attr('checked', true);
                    sl_video = 1;
                }else{
                    $('#select_urlvideo').attr('checked', true)
                    sl_video = 0;
                    $('.active_urlvideo').removeClass(' hidden');
                }
                $('img.img-active').attr('src',result.active_avatar);
                $('input[name="active_title"]').val(result.active_title);
                $('input[name="active_desc"]').val(result.active_desc);
                $('input[name="active_urlvideo"]').val(result.active_urlvideo);
                $('input[name="active_url"]').val(result.active_url);
                $('input[name="active_date"]').val(result.active_date);
                $('input[name="active_at"]').val(result.active_at);
                $(modal+' form').append('<input class="hidden" name="active_id" value="'+active_id+'"/>');
                $(modal+' form').append('<input class="active_avatar hidden" name="active_avatar" value="'+result.active_avatar+'"/>');
                if(result.active_video != ''){
                    $(modal+' form').append('<input class="hidden" name="active_videoup" value="'+result.active_video+'"/>');
                }
            },
            error: function(){
            }
        });
    });

    $('body').on('click','.edit-active .btn_save', function(e){
        var error = false;
        var team_id = $(this).attr('data');
        var box = '.box-active';

        if($(box+' input[name="active_avatar"]').length == false){
            error = true;
            alert("Bạn phải upload ảnh");
            e.preventdefault();
        }

        if($(box+' input[name="active_title"]').val() == ''){
            error = true;
            alert("Bạn phải nhập tiêu đề hoạt động");
            e.preventdefault();
        }

        if($(box+' input[name="active_desc"]').val() == ''){
            error = true;
            alert("Bạn phải nhập mô tả hoạt động");
            e.preventdefault();
        }

        if(sl_video == 1){
            if($(box+' input[name="active_video"]').val() == '' && $(box+' input[name="active_videoup"]').length == 0){
                error = true;
                alert("Bạn phải upload video");
                e.preventdefault();
            }
        }else{
            if($(box+' input[name="active_urlvideo"]').val() == ''){
                error = true;
                alert("Bạn phải nhập liên kết video");
                e.preventdefault();
            }else{
                var is_youtube = 'https://www.youtube.com/embed/';
                var is_vimeo = 'https://player.vimeo.com/video/';
                var is_twitch_channel = 'https://player.twitch.tv/?channel=';
                var is_twitch_video = 'https://player.twitch.tv/?video=';
                // var is_twitch_coll = 'https://player.twitch.tv/?collection=';
                var is_twitch_clip = 'https://clips.twitch.tv/embed?clip=';
                var act_urlvideo = $(box+' input[name="active_urlvideo"]').val();

                if(act_urlvideo.indexOf(is_youtube) == 0 || act_urlvideo.indexOf(is_vimeo) == 0 || act_urlvideo.indexOf(is_twitch_channel) == 0 || act_urlvideo.indexOf(is_twitch_video) == 0 || act_urlvideo.indexOf(is_twitch_clip) == 0){

                    error = true;
                    if(act_urlvideo.indexOf(is_youtube) == 0){
                        var arr_youtube = act_urlvideo.split('/');
                        if(arr_youtube[4] == '' || arr_youtube[4].indexOf(' ') >= 0){
                            alert('Id video của youtube phải được nhập và không được chứa khoảng trắng.\nVd: https://www.youtube.com/watch?v=GDV6xfwFOmE , id video là GDV6xfwFOmE\nLiên kết đúng: https://www.youtube.com/embed/GDV6xfwFOmE');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_vimeo) == 0){
                        var arr_vimeo = act_urlvideo.split('/');
                        if(arr_vimeo[4] == '' || arr_vimeo[4].indexOf(' ') >= 0){
                            alert('Id video của vimeo phải được nhập và không được chứa khoảng trắng.\nVd: https://vimeo.com/237924280 , id video là 237924280\nLiên kết đúng: https://player.vimeo.com/video/237924280');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_channel) == 0){
                        var arr_channel = act_urlvideo.split('=');
                        if(arr_channel[1] == '' || arr_channel[1].indexOf(' ') >= 0){
                            alert('channel phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://player.twitch.tv/?channel=rush');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_video) == 0){
                        var arr_video = act_urlvideo.split('=');
                        if(arr_video[1] == '' || arr_video[1].indexOf(' ') >= 0){
                            alert('id video phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://player.twitch.tv/?video=v40464143');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }else
                    if(act_urlvideo.indexOf(is_twitch_clip) == 0){
                        var arr_clip = act_urlvideo.split('=');
                        if(arr_clip[1] == '' || arr_clip[1].indexOf(' ') >= 0){
                            alert('Tên clip phải được nhập và không được chứa khoảng trắng.\nVd cho liên kết đúng:\nhttps://clips.twitch.tv/embed?clip=TallTubularYogurtPeteZaroll');
                            e.preventdefault();
                        }else{
                            error = false;
                        }
                    }
                }else{
                    error= true;
                    alert('Cấu trúc liên kết video của bạn không hợp lệ, xem lại cấu trúc liên kết video cho phép');
                    e.preventdefault();
                }
            }
        }

        if($(box+' input[name="active_url"]').val() != ''){
            var url_act = $(box+' input[name="active_url"]').val();
            error = true;
            if(url_act.indexOf('http://') == 0 || url_act.indexOf('https://') == 0){
                error = false;
            }else{
                alert('Liên kết ngoài bạn nhập phải có http:// hoặc https://');
                e.preventdefault();
            }
        }

        if(error == false){
            $('.load-wrapp').show();
            var active_title = $('input[name="active_title"]').val();
            var active_date = $('input[name="active_date"]').val();
            var active_avatar = $('input[name="active_avatar"]').val();
            var active_desc = $('input[name="active_desc"]').val();
            var active_urlvideo = $('input[name="active_urlvideo"]').val();
            var active_url = $('input[name="active_url"]').val();

            var form_act = new FormData();
            if(sl_video == 1 && up_actvideo == true){
                form_act.append('active_video', file_actvideo);
            }else{
                form_act.append('active_urlvideo', active_urlvideo);
            }

            form_act.append('active_id', $(this).attr('data'));
            form_act.append('active_avatar', active_avatar);
            form_act.append('active_title', active_title);
            form_act.append('active_date', active_date);
            form_act.append('active_desc', active_desc);
            form_act.append('active_url', active_url);
            form_act.append('select_video', sl_video);

            $.ajax({
                url: siteUrl + 'home/shop/update_activities',
                data: form_act,
                type: 'post',
                processData: false,
                contentType: false,
                success: function(message){
                    if(message != ''){
                        $('.load-wrapp').hide();
                        alert(message);
                    }else{
                        location.reload();
                    }
                },
                error: function(){
                }
            });
        }
    });

    $('body').on('click','.edit-active .btn_delete', function(e){
        var error = false;
        var active_id = $(this).attr('data');
        var box = '.box-active';

        $.ajax({
            url: siteUrl + 'home/shop/delete_activities',
            data: {active_id: active_id},
            type: 'post',
            dataType: 'json',
            success: function(result){
                if(result.error == true){
                    if(result.message != ''){
                        alert(result.message);
                    }else{
                        alert('Lưu thông tin thất bại');
                    }
                }else{
                    location.reload();
                }
            },
            error: function(){
            }
        });
    });

    $('#active').on('hidden.bs.modal', function(){
        $('img.img-active').attr('src','/templates/home/images/svg/add_avata.svg');
        $('input[name="active_title"]').val('');
        $('input[name="active_desc"]').val('');
        $('input[name="active_urlvideo"]').val('');
        $('input[name="active_url"]').val('');
        $('input[name="active_date"]').val('');
        $('input[name="active_at"]').val('');
        $('input[name="active_id"]').remove();
        $('input[name="active_avatar"]').remove();
        $('#active .btn_delete').remove();
        $('.note_urlvideo').hide();
    });
});
/*
function showResult(result) {
    alert(result.geometry.location.lat());
    alert(result.geometry.location.lng());
}

function getLatitudeLongitude(callback, address) {
    // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
    // address = address || 'Ferrol, Galicia, Spain';
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0]);
            }
        });
    }
}

var button = document.getElementById('btn');

$('body').on("click", function () {
    var address = '262 Huỳnh Văn Bánh, phường 11, quận Phú Nhuận, Hồ Chí Minh';//document.getElementById('address').value;
    //getLatitudeLongitude(showResult, address);
});*/
</script>