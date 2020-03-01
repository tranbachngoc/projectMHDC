<form class="addOrderaddress" action="" method="post">
  <div class="delivery-address">
    <h3 class="tit">Thông tin người nhận</h3>
    <div class="form-info-delivery">
      <input type="hidden" name="key_order" class="key_order form-control" value="<?php echo !empty($_REQUEST['key']) ? $_REQUEST['key'] : ''; ?>">
      <p class="form-group note"></p>
      <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Nhập tên người nhận" required maxlength="255">
      </div>
      <div class="double-input">
        <div class="form-group">
          <input type="text" name="phone" pattern="^\d{10}$" maxlength="10" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>
        <div class="form-group">
          <input type="email" name="semail" maxlength="255" class="form-control" placeholder="Email" required>
        </div>
      </div>
      <div class="form-group">
        <input type="text" name="address" maxlength="500" class="form-control" placeholder="Nhập địa chỉ đường" required>
      </div>
      <div class="double-input">
        <div class="form-group">
          <select class="form-control js-province" required name="province">
            <option value="">Chọn Tỉnh/Thành</option>
            <?php 
              if (!empty($province)) {
                foreach ($province as $key => $value) {
                  echo '<option value="' .$value['pre_id']. '">' .$value['pre_name']. '</option>';
                }
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <select class="form-control js-district" required name="district">
            <option value="">Chọn Quận/Huyện</option>
          </select>
        </div>
      </div>
      <div class="form-group mt20">
        <label class="checkbox-style">
          <input type="checkbox" name="receiver_other" class="js-receiver-other" value="1"><span>Người nhận là người khác.</span>
        </label>
      </div>
    </div>
  </div>

  <div class="delivery-address show-receiver-other hidden">
    <h3 class="tit">Thông tin người mua</h3>
    <div class="form-info-delivery">
      <p class="form-group note_buy"></p>
      <div class="form-group">
        <input type="text" name="name_buy" class="form-control" placeholder="Nhập tên người mua" required maxlength="255">
      </div>
      <div class="double-input">
        <div class="form-group">
          <input type="text" name="phone_buy" pattern="^\d{10}$" maxlength="10" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>
      </div>      
    </div>
  </div>

  <div class="delivery-address">
    <div class="form-info-delivery border-none p00">
      <div class="button-save">
        <button type="button" class="btn-save-db">Tiếp</button>
      </div>
    </div>
  </div>
</form>


<!-- Modal -->
<div class="modal" id="phone-creat">
  <div class="modal-dialog modal-dialog-centered modal-mess ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Chúng tôi sẽ tạo tài khoản mới ngay khi bạn hoàn tất đơn hàng</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>          
      <!-- Modal body -->
      <div class="modal-body">
        <div class="phone-existed-modal">
          <p class="mb20">Nhập mã xác thực vừa được gởi đến số điện thoại <strong class="phone_number"></strong></p>
          <p class="mb10">
            <input type="text" class="enter-phone-area w100pc ml00 input-border-bottom" id="js-sms-verify" placeholder="Nhập mã xác thực">
            <span class="ml05 text-red js-sms-verify-error">Sai mã kích hoạt. Vui lòng kiểm tra lại và nhập lại mã khác!</span>
          </p>
          

          <p class="mb10">
            <input type="password" class="w100pc ml00 input-border-bottom" name="password" placeholder="Mật khẩu">
            <span class="ml05 text-red js-password-error"></span>
          </p>
          
          <p class="mb10">
            <input type="password" class="w100pc ml00 input-border-bottom" name="repassword" placeholder="Nhập lại mật khẩu">
            <span class="ml05 text-red js-repassword-error"></span>
          </p>
          
          <button class="btn-code-verify js-btn-code-verify">Xác nhận</button>
          <div class="text-center mt20 mb20 js-sms-verify-again">Không nhận được mã?</div>
          <p>Bằng việc nhận mã xác thực, bạn đã đồng ý với các điều khoản và điều kiện, chính sách quyền riêng tư của azibai.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end Modal -->
<script src="/templates/home/styles/js/receive.js"></script>

