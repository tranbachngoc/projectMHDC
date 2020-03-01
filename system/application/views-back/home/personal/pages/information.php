<?php
$arr_icon_permission = [
  "1" => "congkhai.svg",
  "2" => "banbe2.svg",
  "3" => "chiminhtoi.svg",
]
?>
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

<div class="row">
  <div class="col-md-4">
    <div class="tranggioithieu-left user-data" data-id="<?php echo $info_public['use_id'] ?>">
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit"><img src="/templates/home/styles/images/svg/thongtinlienhe.svg" class="mr10"><span class="tit">Thông tin & liên hệ</span></h3>
          <?php
          if($this->session->userdata('sessionUser') == $current_profile['use_id'])
          {
          ?>
          <p class="edit edit-info-user cursor-pointer" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/pen_black.svg"></p>
          <?php
          }
          ?>
        </div>
        <div class="text">
          <p><b>Giới tính:</b> <?php echo ($info_public['use_sex'] == 1) ? 'Nam' : 'Nữ'; ?></p>
          <p><b>Ngày sinh:</b> <?php echo ($info_public['use_birthday'] != '') ? $info_public['use_birthday'] : 'Chưa cập nhật'; ?></p>
          <p><b>Tôn giáo:</b> <?php echo ($info_public['use_religion'] != '') ? $info_public['use_religion'] : 'Chưa cập nhật'; ?></p>
          <p><b>Nơi sinh:</b> <?php echo ($info_public['use_home_town'] != '') ? $info_public['use_home_town'] : 'Chưa cập nhật'; ?></p>
          <?php
          $use_address = ($info_public['use_address'] != '') ? $info_public['use_address'] : '';
          if($use_address != ''){
            $use_address .= ', ';
          }
          if($quan_huyen != ''){
            $use_address .= $quan_huyen;
          }
          if($use_address != ''){
            $use_address .= ', ';
          }
          if($tinh_thanh != ''){
            $use_address .= $tinh_thanh;
          }
          ?>
          <p><b>Nơi sống:</b> <?php echo ($use_address != '') ? $use_address : 'Chưa cập nhật'; ?></p>
        </div>

        <div class="text">
          <?php if($info_public['permission_email'] == 1 || ($info_public['permission_email'] == 2 && isset($info_public['is_friend']) && $info_public['is_friend'] == true) || $info_public['use_id'] == $this->session->userdata('sessionUser')) { ?>
          <p><b>Email:</b> <?php echo ($info_public['use_email'] != '') ? $info_public['use_email'] : 'Chưa cập nhật'; ?></p>
          <?php } ?>
          <?php if($info_public['permission_mobile'] == 1 || ($info_public['permission_mobile'] == 2 && isset($info_public['is_friend']) && $info_public['is_friend'] == true) || $info_public['use_id'] == $this->session->userdata('sessionUser')) { ?>
          <p><b>Số điện thoại:</b> <?php echo ($info_public['use_mobile'] != '') ? $info_public['use_mobile'] : 'Chưa cập nhật'; ?></p>
          <?php } ?>
          <p><b>Website:</b> 
            <?php echo ($info_public['website'] != '') ? '<a href="'.$info_public['website'].'" target="_blank" class="text-red">'.$info_public['website'].'</a>' : 'Chưa cập nhật'; ?>
          </p>
          <p>
            <b><span class="text-black">Liên kết trong azibai:</span></b>
            <br>
            <a href="<?php echo ($link_shop != '') ? $link_shop : '#'; ?>" class="text-red">
              <?php echo ($link_shop != '') ? $link_shop : 'Chưa cập nhật'; ?>
            </a>
            <br>
            <a href="<?php echo ($link_shop != '') ? $link_shop.'/affiliate/product' : '#'; ?>" class="text-red">
              <?php echo ($link_shop != '') ? $link_shop.'/affiliate/product' : 'Chưa cập nhật'; ?>
            </a>
          </p>
        </div>
      </div>

      <div class="item">
          <div class="item-head">
            <h3 class="item-head-tit"><img src="/templates/home/styles/images/svg/tinhtranghonnhan.svg" class="mr10"><span class="tit">Tình trạng hôn nhân  </span></h3>
            <?php
            if($this->session->userdata('sessionUser') == $current_profile['use_id'])
            {
            ?>
            <p class="edit edit-maritals-user cursor-pointer" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/pen_black.svg"></p>
            <?php
            }
            ?>
          </div>
          <?php

          if(!empty($user_maritals))
          {
            if($user_maritals->marital_status == 1){
              $marital_status = 'Độc thân';
            }
            else{
              if($user_maritals->marital_status == 2){
                $marital_status = 'Đã kết hôn';
              }else{
                if($user_maritals->marital_status == 3){
                  $marital_status = 'Đang tìm hiểu';
                }
              }
            }

            if($user_maritals->hobby == 1){
              $hobby = 'Nam';
            }
            else{
              if($user_maritals->hobby == 2){
                $hobby = 'Nữ';
              }else{
                if($user_maritals->hobby == 3){
                  $hobby = 'Cả nam và nữ';
                }
              }
            }

            if($user_maritals->want_to_marry == 1){
              $want_to_marry = 'Có';
            }
            else{
              $want_to_marry = 'Không';
            }

            if($user_maritals->has_children == 1){
              $has_children = 'Có';
            }
            else{
              $has_children = 'Không';
            }
          }else{
            $marital_status = $hobby = $want_to_marry = $has_children = 'Chưa cập nhật';
          }
          ?>
        <div class="text">
          <p><b>Tình trạng hôn nhân:</b> <?php echo $marital_status; ?></p>
          <p><b>Thích:</b> <?php echo $hobby; ?></p>
          <!-- <p>Mong muốn kết hôn: <?php //echo $want_to_marry; ?></p> -->
          <p><b>Đã có con:</b> <?php echo $has_children; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="tranggioithieu-right">
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit"><span class="tit"><img src="/templates/home/styles/images/svg/motabanthan.svg" class="mr10">Mô tả bản thân</span><a href="" class="seeCV">Xem CV</a></h3>
          <?php
          if($this->session->userdata('sessionUser') == $current_profile['use_id'])
          {
          ?>
          <p class="edit edit-detail-user cursor-pointer" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/pen_black.svg"><span class="md">Chỉnh sửa</span></p>
          <?php
          }
          ?>
        </div>
        <div class="text">
          <p><?php echo ($user_detail->description != '') ? $user_detail->description : 'Chưa cập nhật'; ?></p>
        </div>
      </div>
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit">
            <span class="tit"><img src="/templates/home/styles/images/svg/sothich.svg" class="mr10">Sở thích</span>
          </h3>
        </div>
        <div class="text">
          <p><?php echo ($user_detail->hobby != '') ? $user_detail->hobby : 'Chưa cập nhật'; ?></p>
        </div>
      </div>
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit">
            <span class="tit"><img src="/templates/home/styles/images/svg/caunoiyeuthich.svg" class="mr10">Câu nói yêu thích</span>
          </h3>
        </div>
        <div class="text">
          <p><?php echo ($user_detail->sayings != '') ? $user_detail->sayings : 'Chưa cập nhật'; ?></p>
        </div>
      </div>
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit"><span class="tit"><img src="/templates/home/styles/images/svg/kynang.svg" class="mr10">Kỹ năng</span></h3>
        </div>
        <div class="text">
          <?php
          if(!empty($user_detail->skills))
          {
            $skills = explode(',', str_replace(array('[', ']', '"'), '', $user_detail->skills));
            
            foreach ($skills as $key => $value) {
              echo '<p>'.$value.'</p>';
            }
          }
          else
            echo 'Chưa cập nhật';
          ?>
        </div>
      </div>
      
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit"><span class="tit"><img src="/templates/home/styles/images/svg/congviec.svg" class="mr10">Công việc</span>
            <?php
            if($this->session->userdata('sessionUser') == $current_profile['use_id'])
            {
            ?>
            <span class="work-experience md ml20 mb00 add-jobs-user" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr10">Thêm kinh nghiệm làm việc</span>
            <?php
            }
            ?>
            </h3>
        </div>
        <div class="text">
          <?php
          if(!empty($user_jobs))
          {
            foreach ($user_jobs as $key => $value)
            {
          ?>
          <div class="company">
            <!-- <div class="logo"><img src="asset/images/hinhanh/01.jpg" alt=""></div> -->
            <div class="name">
              <?php
              if($value->company_name != '')
              {
                $to = $value->to;
                if($value->to == '' || $value->to == null){
                  $to = 'hiện tại';
                }
              ?>
                <?php echo ($value->company_name != '') ? $value->company_name : ''; ?>
                <br/>
                <?php echo ($value->position != '') ? $value->position : ''; ?>
                <br/>
                <?php echo ($value->from != '') ? $value->from.' đến '.$to : ''; ?>
                <br/>
                <?php echo ($value->address_job != '') ? $value->address_job : ''; ?>
              <?php
              }
              else{
                echo 'Chưa cập nhật';
              }
              ?>
              </div>
              <?php
              if($this->session->userdata('sessionUser') == $current_profile['use_id'])
              {
              ?>
              <p class="edit edit-jobs-user cursor-pointer" data-id="<?php echo $value->id?>" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/pen_black.svg"><span class="md">Chỉnh sửa</span></p>
              <?php
              }
              ?>
          </div>
          <?php
            }
          }
            ?>
        </div>
      </div>

      <!-- 
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit">
            <span class="tit"><img src="/templates/home/styles/images/svg/hocvan.svg" class="mr10">Học vấn</span>
          </h3>
        </div>
        <div class="text">
          <?php
          if($this->session->userdata('sessionUser') == $current_profile['use_id'])
          {
          ?>
          <p>
            <span class="work-experience add-edu-user" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr10">Thêm học vấn trung học</span>
          </p>
          <?php
          }
          ?>
          <div class="company">
            <div class="name"><strong><i class="fa fa-angle-double-right" aria-hidden="true"></i> Trung học phổ thông</strong><br>THPT Trần Khai Nguyên<br>2004 - 2007<br>Thành phố Hồ Chí Minh</div>
            <?php
            if($this->session->userdata('sessionUser') == $current_profile['use_id'])
            {
            ?>
            <p class="edit" data-toggle="modal" data-target="#editAddSchool"><img src="/templates/home/styles/images/svg/pen_black.svg"><span class="md">Chỉnh sửa</span></p>
            <?php
            }
            ?>
          </div>
          <?php
          if($this->session->userdata('sessionUser') == $current_profile['use_id'])
          {
          ?>
          <p>
            <span class="work-experience add-edu-user" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr10">Thêm học vấn đại học</span>
          </p>
          <?php
          }
          ?>
          <div class="company">
            <div class="name"><strong><i class="fa fa-angle-double-right" aria-hidden="true"></i> Đại học</strong><br>Công nghệ thông tin<br>2007-2011<br>Thành phố Hồ Chí Minh</div>
            <?php
            if($this->session->userdata('sessionUser') == $current_profile['use_id'])
            {
            ?>
            <p class="edit" data-toggle="modal" data-target="#editAddSchool"><img src="/templates/home/styles/images/svg/pen_black.svg"><span class="md">Chỉnh sửa</span></p>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
      <div class="item">
        <div class="item-head">
          <h3 class="item-head-tit"><span class="tit"><img src="/templates/home/styles/images/svg/cacnhomthamgia.svg" class="mr10">Các nhóm tham gia</span></h3>
          <p class="edit" data-toggle="modal" data-target="#introduce-info"><img src="/templates/home/styles/images/svg/pen_black.svg"><span class="md">Chỉnh sửa</span></p>
        </div>
        <div class="text">
          <ul class="ds-nhom">
            <li>
              <img src="asset/images/hinhanh/02.jpg" alt="">
              Nhóm kinh doanh sỉ
            </li>
            <li>
              <img src="asset/images/hinhanh/23.jpg" alt="">
              Nhóm kinh doanh lẻ
            </li>
          </ul>
        </div>
      </div> -->
    </div>
    
  </div>
</div>

<script id="js-edit-info" type="text/template">
  <form action="">
    <div class="form-group">
      <label class="col-form-label">* Họ & tên</label>
      <input type="text" autocomplete="off" name="use_fullname" class="use_fullname ten-bst-input" maxlength="150" value="<?php echo $info_public['use_fullname']; ?>">
    </div>
    <div class="form-group">
      <label class="col-form-label">* Giới tính</label>
      <p class="mt10 mb20">
        <label class="checkbox-style-circle">
          <input type="radio" name="use_sex" value="1" <?php echo ($info_public['use_sex'] == 1) ? 'checked' : ''; ?>><span>Nam</span>
        </label>
        <label class="checkbox-style-circle ml20">
          <input type="radio" name="use_sex" value="0" <?php echo ($info_public['use_sex'] == 0) ? 'checked' : ''; ?>><span>Nữ</span>
        </label>
      </p>
    </div>
    <div class="form-group form-group-hastypepost">
      <label class="col-form-label">* Ngày sinh</label>
      <input type="date" autocomplete="off" name="use_birthday" class="use_birthday ten-bst-input" placeholder="" value="<?php echo $info_public['use_birthday']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Tôn giáo</label>
      <input type="text" autocomplete="off" name="use_religion" class="use_religion ten-bst-input" maxlength="50" placeholder="" value="<?php echo $info_public['use_religion']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Nơi sinh</label>
      <input type="text" autocomplete="off" name="use_home_town" class="use_home_town ten-bst-input" maxlength="200" placeholder="" value="<?php echo $info_public['use_home_town']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Địa chỉ</label>
      <input type="text" autocomplete="off" name="use_address" class="use_address ten-bst-input" maxlength="200" placeholder="" value="<?php echo $info_public['use_address']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <select name="use_province" id="use_province" class="use_province select-category">
        <option value="">Chọn Tỉnh/Thành</option>
        <?php foreach ($province as $vals):?>
            <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $info_public['use_province'])?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
        <?php endforeach;?>
      </select>
    </div>
    <div class="form-group  form-group-hastypepost">
      <select name="user_district" id="user_district" class="user_district select-category">
        <option value="">Chọn Quận/Huyện</option>
        <?php foreach ($district as $vals): ?>
            <option value="<?php echo $vals->id; ?>" <?php echo ($vals->id == $info_public['user_district'])?"selected='selected'":""; ?> ><?php echo $vals->DistrictName; ?></option>
        <?php endforeach;?>
      </select>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Email</label>
      <input type="text" autocomplete="off" name="use_email" class="use_email ten-bst-input" maxlength="50" placeholder="" value="<?php echo $info_public['use_email']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/<?=$arr_icon_permission[$info_public['permission_email']]?>" class="mr10 js-image-choose-radio"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_email" value="1" <?=($info_public['permission_email'] == 1) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_email" value="2" <?=($info_public['permission_email'] == 2) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_email" value="3" <?=($info_public['permission_email'] == 3) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Số điện thoại</label>
      <input type="text" autocomplete="off" name="use_mobile" class="use_mobile ten-bst-input" maxlength="20" placeholder="" value="<?php echo $info_public['use_mobile']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/<?=$arr_icon_permission[$info_public['permission_mobile']]?>" class="mr10 js-image-choose-radio"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_mobile" value="1" <?=($info_public['permission_mobile'] == 1) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_mobile" value="2" <?=($info_public['permission_mobile'] == 2) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost_mobile" value="3" <?=($info_public['permission_mobile'] == 3) ? 'checked' : '';?>><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">* Mã liên kết</label>
      <div class="slug_url">
        <span class="t"><?php echo domain_site.'/profile/'?></span>
        <input type="text" autocomplete="off" name="use_slug" class="use_slug ten-bst-input" maxlength="100" placeholder="" value="<?php echo $info_public['use_slug']; ?>">
      </div>
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost hidden">
      <label class="col-form-label">* website</label>
      <input type="text" autocomplete="off" name="website" class="website ten-bst-input" placeholder="" value="<?php echo $info_public['website']; ?>">
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
  </form>
</script>
<script>
  $("body").on("change","input[name='typepost_email'], input[name='typepost_mobile']",function (event) {
    img = $(this).next().find("img").attr("src");
    $(this).closest(".typepost").find("p .js-image-choose-radio").attr("src",img);
  })
</script>

<script id="js-edit-maritals" type="text/template">
  <form action="">
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">Tình trạng hôn nhân</label>
      <select name="marital_status" id="" class="marital_status form-control w80pc">
        <option value="1" <?php echo ($user_maritals->marital_status == 1) ? 'selected' : ''; ?>>Độc thân</option>
        <option value="2" <?php echo ($user_maritals->marital_status == 2) ? 'selected' : ''; ?>>Đã kết hôn</option>
        <option value="3" <?php echo ($user_maritals->marital_status == 3) ? 'selected' : ''; ?>>Đang tìm hiểu</option>
      </select>
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>              
    <div class="form-group form-group-hastypepost">
      <label class="col-form-label">Đã có con</label>
      <p class="mt10 mb20">
        <label class="checkbox-style-circle">
          <input type="radio" name="has_children" class="has_children" value="1" <?php echo ($user_maritals->has_children == 1) ? 'checked="checked"' : ''; ?>><span>Có</span>
        </label>
        <label class="checkbox-style-circle ml20">
          <input type="radio" name="has_children" class="has_children" value="0" <?php echo ($user_maritals->has_children == 0) ? 'checked="checked"' : ''; ?>><span>Không</span>
        </label>
      </p>
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group  form-group-hastypepost">
      <label class="col-form-label">Thích</label>
      <select name="hobby" id="" class="maritals-hobby form-control w80pc">
        <option value="1" <?php echo ($user_maritals->hobby == 1) ? 'selected' : ''; ?>>Nam</option>
        <option value="2" <?php echo ($user_maritals->hobby == 2) ? 'selected' : ''; ?>>Nữ</option>
        <option value="3" <?php echo ($user_maritals->hobby == 3) ? 'selected' : ''; ?>>Cả nam và nữ</option>
      </select>
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div> 
  </form>
</script>

<script id="js-edit-detail" type="text/template">
  <form action="" class="introduce-info form-user-detail">
    <div class="form-group form-group-hastypepost">
        <label class="col-form-label">* Mô tả bản thân</label>
        <input type="text" autocomplete="off" name="description" class="description ten-bst-input" value="<?php echo $user_detail->description; ?>">
        <div class="typepost">
          <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
          <ul class="dropdown-menu typepost-select dropdown-menu-right">
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
              </label>
            </li>
          </ul>
        </div>
      </div>
      <div class="form-group form-group-hastypepost">
        <label class="col-form-label">* Câu nói yêu thích</label>
        <input type="text" autocomplete="off" name="sayings" class="sayings ten-bst-input" placeholder="" value="<?php echo $user_detail->sayings; ?>">
        <div class="typepost">
          <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
          <ul class="dropdown-menu typepost-select dropdown-menu-right">
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
              </label>
            </li>
          </ul>
        </div>
      </div>
      <div class="form-group form-group-hastypepost">
        <label class="col-form-label">* Sở thích</label>
        <input type="text" autocomplete="off" name="hobby" class="hobby ten-bst-input" placeholder="" value="<?php echo $user_detail->hobby; ?>">
        <div class="typepost">
          <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
          <ul class="dropdown-menu typepost-select dropdown-menu-right">
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
              </label>
            </li>
          </ul>
        </div>
      </div>
      <div class="form-group form-group-hastypepost js-skills">
        <label class="col-form-label">* Kỹ năng</label>
        <?php
          if(!empty($user_detail->skills))
          {
            $skills = explode(',', str_replace(array('[', ']', '"'), '', $user_detail->skills));
            
            foreach ($skills as $key => $value) {
              echo '<input type="text" autocomplete="off" name="skills[]" class="skills ten-bst-input" placeholder="" value="'.$value.'">';
            }
          }
          else
            echo '<input type="text" autocomplete="off" name="skills[]" class="skills ten-bst-input" placeholder="" value="">';
          ?>
        <div class="typepost">
          <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
          <ul class="dropdown-menu typepost-select dropdown-menu-right">
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
              </label>
            </li>
          </ul>
        </div>
      </div>
    <div class="add-detail-user cursor-pointer"><img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr10">Thêm một kỹ năng</div>
  </form>
</script>

<script id="js-edit-jobs" type="text/template">
  <form action="">
    <div class="form-group form-group-hastypepost">
      <label class="col-form-label"></label>
      <div class="typepost">
        <p class="typepost-now" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
        <ul class="dropdown-menu typepost-select dropdown-menu-right">
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa" checked="checked"><span><img src="/templates/home/styles/images/svg/congkhai.svg" class="mr10">Công khai</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/banbe2.svg" class="mr10">Bạn bè</span>
            </label>
          </li>
          <li>
            <label class="checkbox-style-circle">
              <input type="radio" name="typepost" value="aaa"><span><img src="/templates/home/styles/images/svg/chiminhtoi.svg" class="mr10">Chỉ mình tôi</span>
            </label>
          </li>
        </ul>
      </div>
    </div>
    <div class="form-group">
      <label class="col-form-label">* Tên công ty</label>
      <input type="text" autocomplete="off" name="" class="ten-bst-input company_name" maxlength="150" placeholder="" value="<?php echo $user_detail->company_name; ?>">
    </div>
    <div class="form-group">
      <label class="col-form-label">* Chức vụ</label>
      <input type="text" autocomplete="off" name="" class="ten-bst-input position" maxlength="150" placeholder="" value="<?php echo $user_detail->company_name; ?>">
    </div>
    <div class="form-group">
      <label class="col-form-label">* Tỉnh/thành phố</label>
      <select name="province_id" id="province_id" class="province_id select-category">
        <option value="">Chọn Tỉnh/Thành</option>
        <?php foreach ($province as $vals):?>
            <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $user_detail->province_id)?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
        <?php endforeach;?>
      </select>
    </div>
    <div class="form-group">
      <label class="col-form-label">* Thời gian</label>
      <p>Từ</p>
      <input type="date" autocomplete="off" name="" class="from ten-bst-input datepicker" placeholder="" value="<?php echo ($user_detail->from != '') ? $user_detail->from : date('Y-m-d', time()); ?>">
      <p class="mt10">
        Đến
        <label class="ml20">
          <input type="checkbox" class="date_to" name="to_present" <?php echo ($user_detail->to_present == 1) ? 'checked="checked"' : ''; ?> class="mr10" value="1">
          <span>Hiện nay</span>
        </label>
      </p>

      <input type="date" autocomplete="off" name="to" class="to ten-bst-input datepicker <?php echo ($user_detail->to_present == 1) ? 'hidden' : ''; ?>" placeholder="" value="<?php echo ($user_detail->to_present != '') ?  $user_detail->to_present : date('Y-m-d', time()); ?>">
    </div>
  </form>
</script>

<div class="modal bst-modal" id="introduce-info">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        
      </div>
      <div class="modal-footer buttons-group">
        <div class="bst-group-button">  
          <div class="left"></div>
          <div class="right">
            <button type="button" class="btn btn-delete btn-border-pink hidden">Xóa</button>
            <button type="button" class="btn btn-save btn-bg-gray">Xong</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function() {

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    function isPlace(str) {
      var regex = /\S/;
      return regex.test(str);
    }

    $('body').on('click', '.edit-info-user', function(){
      var class_save = 'save-info-user';
      var html_detail = $('#js-edit-info').html();
      $('#introduce-info h4.modal-title').html('<img src="/templates/home/styles/images/svg/thongtinlienhe.svg" class="mr10">Thông tin cơ bản và liên hệ');
      $('#introduce-info .modal-body').html(html_detail);
      $('#introduce-info .btn-save').addClass(class_save);
    });

    $('body').on('click', '.save-info-user', function(e){
      var error = false;
      var use_fullname = $('.use_fullname').val();
      var use_birthday = $('.use_birthday').val();
      var use_address = $('.use_address').val();
      var use_province = $('.use_province').val();
      var user_district = $('.user_district').val();
      var use_email = $('.use_email').val();
      var use_mobile = $('.use_mobile').val();
      var use_slug = $('.use_slug').val();

      if(use_fullname == '' || isPlace(use_fullname) == false){
        error = true;
        alert("Bạn phải nhập họ tên cá nhân");
        e.preventdefault();
      }
      if(use_birthday == ''){
          error = true;
          alert("Bạn phải chọn ngày sinh");
          e.preventdefault();
      }
      if(use_address == ''){
          error = true;
          alert("Bạn phải nhập địa chỉ");
          e.preventdefault();
      }
      if(use_province == ''){
          error = true;
          alert("Bạn chưa chọn tỉnh/thành");
          e.preventdefault();
      }
      if(user_district == ''){
          error = true;
          alert("Bạn chưa chọn quận/huyện");
          e.preventdefault();
      }

      if(use_email != ''){
          if(isEmail(use_email) == false){
              error = true;
              alert("Email không hợp lệ");
              e.preventdefault();
          }
      }

      if(use_mobile == '' || isPlace(use_mobile) == false){
        error = true;
        alert("Bạn chưa nhập số điện thoại di dộng");
        e.preventdefault();
      }
      else
      {
          var check_shomobile = true;
          var str = "0123456789";
          for (var i = 0; i < use_mobile.length; i++) {
              if (str.indexOf(use_mobile.charAt(i)) == -1){
                  check_shomobile = false;
              }
          }
          if(use_mobile.length != 10 || check_shomobile == false){
              error = true;
              alert("Số điện thoại di động phải gồm 10 kí tự số từ 0-9");
              e.preventdefault();
          }else{
              if(use_mobile.charAt(0) != 0){
                  error = true;
                  alert("Số điện thoại di động không hợp lệ");
                  e.preventdefault();
              }
          }
      }

      if(use_slug == ''){
        error = true;
        alert("Bạn phải nhập mã liên kết cá nhân");
        e.preventdefault();
      }else{
        var str = /[\W_]/;
        if(str.test(use_slug) == true || use_slug.length > 30){
            error = true;
            alert("Mã liên kết chứa tối đa 30 ký tự 0-9, a-z");
            e.preventdefault();
        }
      }

      if(error == false){
        var form_info_user = new FormData();
        form_info_user.append('user_id', $('.user-data').data('id'));
        form_info_user.append('use_fullname', use_fullname);
        form_info_user.append('use_sex', $('input[name="use_sex"]:checked').val());
        form_info_user.append('use_birthday', $('.use_birthday').val());
        form_info_user.append('use_religion', $('.use_religion').val());
        form_info_user.append('use_home_town', $('.use_home_town').val());
        form_info_user.append('use_address', use_address);
        form_info_user.append('use_province', use_province);
        form_info_user.append('user_district', user_district);
        form_info_user.append('use_email', use_email);
        form_info_user.append('use_mobile', use_mobile);
        form_info_user.append('use_slug', use_slug);

        //up permission
        form_info_user.append('permission_email', $("input[name='typepost_email']:checked").val());
        form_info_user.append('permission_mobile', $("input[name='typepost_mobile']:checked").val());

        $('.load-wrapp').show();
        $.ajax({
          url: siteUrl + 'profile/edit_info_user',
          data: form_info_user,
          type: 'POST',
          processData: false,
          contentType: false,
          success:function(message){
            if(message != ''){
              var mess = 'Lưu thông tin thất bại';
              $('.load-wrapp').hide();
              $('#modal_mess').modal('show');
              $('#modal_mess .modal-body p').html(message);
              $('.use_slug').css({'border-bottom':'1px solid #f30505', 'color' : '#f30505'});
            }else{
              var hostname = window.location.hostname;
              var check = hostname.includes('<?php echo domain_site ?>');
              if(check == true){
                window.location.href = 'http://<?php echo domain_site ?>/profile/'+use_slug+'/about';
              }else{
                location.reload();
              }
            }
          }
        });
      }
    });

    $('#introduce-info').on('show.bs.modal', function(){
      $("#use_province").change(function () {
        if ($("#use_province").val()) {
          $.ajax({
              url: siteUrl + 'ajax_district',
              type: "POST",
              data: {province_id: $("#use_province").val()},
              success: function (response) {
                if (response) {
                  var json = JSON.parse(response);
                  var html_option = '';
                  $(json).each(function(at, item){
                    html_option += '<option value="'+item.id+'">'+item.DistrictName+'</option>';
                  });
                  $('#user_district').html(html_option);
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
    });

    //tinh trang hon nhan
    $('body').on('click', '.edit-maritals-user', function(){
      var class_save = 'save-maritals-user';
      var html_detail = $('#js-edit-maritals').html();
      $('#introduce-info h4.modal-title').html('<img src="/templates/home/styles/images/svg/tinhtranghonnhan.svg" class="mr10 mt02">Tình trạng hôn nhân');
      $('#introduce-info .modal-body').html(html_detail);
      $('#introduce-info .btn-save').addClass(class_save);
    });

    $('body').on('click', '.save-maritals-user', function(){
      var form_maritals_user = new FormData();
      form_maritals_user.append('user_id', $('.user-data').data('id'));
      form_maritals_user.append('marital_status', $('.marital_status').val());
      form_maritals_user.append('hobby', $('.maritals-hobby').val());
      form_maritals_user.append('want_to_marry', $('.want_to_marry').val());
      form_maritals_user.append('has_children', $('input[name="has_children"]:checked').val());

      $('.load-wrapp').show();
      $.ajax({
        url: siteUrl + 'profile/edit_maritals_user',
        data: form_maritals_user,
        type: 'POST',
        processData: false,
        contentType: false,
        success:function(result){
          if(result.error == true){
            $('.load-wrapp').hide();
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html('Lưu thông tin thất bại');
          }else{
            location.reload();
          }
        }
      });
    });

    //mo ta ban than
    $('body').on('click', '.edit-detail-user', function(){
      var class_save = 'save-detail-user';
      var html_detail = $('#js-edit-detail').html();
      $('#introduce-info h4.modal-title').html('<img src="/templates/home/styles/images/svg/motabanthan.svg" class="mr10">Giới thiệu về bản thân');
      $('#introduce-info .modal-body').html(html_detail);
      $('#introduce-info .btn-save').addClass(class_save);
    });

    $('body').on('click', '.save-detail-user', function(){
      var form_detail_user = new FormData();
      form_detail_user.append('user_id', $('.user-data').data('id'));
      form_detail_user.append('description', $('.description').val());
      form_detail_user.append('sayings', $('.sayings').val());
      form_detail_user.append('hobby', $('.hobby').val());

      var skills = [];
      $('.skills').each(function(){
        if($(this).val() != ''){
          skills.push('"'+$(this).val()+'"');
        }
      })
      form_detail_user.append('skills', skills);
      $('.load-wrapp').show();
      $.ajax({
        url: siteUrl + 'profile/edit_detail_user',
        data: form_detail_user,
        type: 'POST',
        processData: false,
        contentType: false,
        success:function(result){
          if(result.error == true){
            $('.load-wrapp').hide();
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html('Lưu thông tin thất bại');
          }else{
            location.reload();
          }
        }
      });
    });

    $('body').on('click', '.add-detail-user', function(){
      $('.js-skills').append('<input type="text" autocomplete="off" name="skills[]" class="skills ten-bst-input">');
    });

    //cong viec
    $('body').on('click', '.add-jobs-user, .edit-jobs-user', function(){
      var class_save = 'save-jobs-user';
      var html_detail = $('#js-edit-jobs').html();
      $('#introduce-info h4.modal-title').html('<img src="/templates/home/styles/images/svg/congviec.svg" class="mr10">Công việc mới');
      $('#introduce-info .modal-body').html(html_detail);
      $('#introduce-info .btn-save').addClass(class_save);
      if($(this).data('id') > 0){
        $('#introduce-info .btn-save').attr('data-id', $(this).data('id'));
        $('#introduce-info .btn-delete').attr('data-id', $(this).data('id'));
        $('#introduce-info .btn-delete').removeClass('hidden');
        $('#introduce-info .btn-delete').addClass('btn-delete-jobs');
        $.ajax({
          url: siteUrl + 'profile/get_jobs_user',
          data: {id: $(this).data('id'), user_id: $('.user-data').data('id')},
          type: 'POST',
          dataType: 'json',
          success:function(result){
            $('.company_name').val(result.company_name);
            $('.position').val(result.position);
            $('.province_id option').each(function(){
              if($(this).val() == result.province_id){
                $(this).attr('selected', true);
              }
            });
            $('.from').val(result.from);
            if(result.to_present == 1){
              $('.date_to').prop('checked', true);
              $('.to').addClass('hidden');
            }else{
              $('.to').val(result.to);
            }
          }
        });
      }
    });

    $('body').on('click', '.date_to', function(){
      var type = $(this).val();
      if($(this).prop('checked') == true){
        $('input[name="to"]').addClass('hidden');
      }else{
        $('input[name="to"]').removeClass('hidden');
      }
    });

    $('body').on('click', '.save-jobs-user, .save-editjobs-user', function(e){
      var error = false;
      var company_name = $('.company_name').val();
      var position = $('.position').val();
      var province_id = $('.province_id').val();
      var from = $('.from').val();
      var to = $('.to').val();
      var type = 0;

      if(company_name == '' || isPlace(company_name) == false){
        error = true;
        alert("Bạn chưa nhập tên công ty");
        e.preventdefault();
      }
      if(position == '' || isPlace(position) == false){
          error = true;
          alert("Bạn chưa nhập vị trí làm việc");
          e.preventdefault();
      }
      if(province_id == ''){
          error = true;
          alert("Bạn chưa chọn tỉnh/thành");
          e.preventdefault();
      }
      if(from == ''){
          error = true;
          alert("Bạn chưa chọn thời gian bắt đầu công việc");
          e.preventdefault();
      }

      if($("input[name='to_present']:checked").val() == 1){
        type = 1;
      }else{
        if(to == ''){
          error = true;
          alert("Bạn chưa chọn thời gian kết thúc công việc");
          e.preventdefault();
        }else{
          if(to <= from){
            error = true;
            alert("Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
            e.preventdefault();
          }
        }
      }

      if(error == false){
        var form_jobs_user = new FormData();
        form_jobs_user.append('user_id', $('.user-data').data('id'));
        form_jobs_user.append('company_name', company_name);
        form_jobs_user.append('province_id', province_id);
        form_jobs_user.append('position', position);
        form_jobs_user.append('from', from);
        form_jobs_user.append('to', to);
        form_jobs_user.append('to_present', type);

        url = 'profile/add_jobs_user';
        if($(this).data('id') > 0){
          url = 'profile/edit_jobs_user';
          form_jobs_user.append('id', $(this).data('id'));
        }
        $('.load-wrapp').show();
        $.ajax({
          url: siteUrl + url,
          data: form_jobs_user,
          type: 'POST',
          processData: false,
          contentType: false,
          success:function(result){
            if(result.error == true){
              $('.load-wrapp').hide();
              $('#modal_mess').modal('show');
              $('#modal_mess .modal-body p').html('Lưu thông tin thất bại');
            }else{
              location.reload();
            }
          }
        });
      }
    });

    $('body').on('click', '.btn-delete-jobs', function(){
      showConfirm({
        'callbackYes': delete_jobs_user,
        'callbackYesAgument': $(this).data('id')
      });
    });

    function delete_jobs_user(id){
      $('.load-wrapp').show();
      $.ajax({
        url: siteUrl + 'profile/delete_jobs_user',
        data: {id: id, user_id: $('.user-data').data('id')},
        type: 'POST',
        dataType: 'json',
        success:function(result){
          if(result.error == true){
            $('.load-wrapp').hide();
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html('Xóa dữ liệu thất bại');
          }else{
            location.reload();
          }
        }
      });
    }

    $('#introduce-info').on('hide.bs.modal', function(){
      $('#introduce-info .btn-delete').attr('class', 'btn btn-delete btn-border-pink hidden');
      $('#introduce-info .btn-save').attr('class', 'btn btn-save btn-bg-gray').removeAttr('data-id');
    });


  });
</script>