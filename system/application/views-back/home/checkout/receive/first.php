<div class="delivery-address">
  <h3 class="tit">Thông tin người nhận</h3>
  <form class="firstOrderaddress form-info-delivery" action="" method="post">
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
        <input type="checkbox" name="active" value="1" checked="checked"><span>Đặt làm địa chỉ mặc định</span>
      </label>
    </div>  
    <div class="button-save">
        <button type="button" class="btn-save-db btn-submit">Lưu</button>
    </div>      
  </form>
</div>
<script src="/templates/home/styles/js/receive.js"></script>