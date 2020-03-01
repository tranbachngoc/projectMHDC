<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php $this->load->view('home/personal/affiliate/element/element-subtab-page-affiliate-income');?>

<div class="affiliate-content">
  <div class="affiliate-content-income">
    <ul class="nav nav-tabs income-tabs-bank" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link <?=$_REQUEST['type'] == 'bank' ? 'active' : '' ?>" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="true">Tài khoản ngân hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?=$_REQUEST['type'] == 'momo' ? 'active' : '' ?>" id="momo-tab" data-toggle="tab" href="#momo" role="tab" aria-controls="momo" aria-selected="false">Tài khoản Momo</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade <?=$_REQUEST['type'] == 'bank' ? 'show active' : '' ?>" id="bank" role="tabpanel" aria-labelledby="bank-tab">
        <div class="income-add-bank">
          <p class="text-red text-bold f16">Thêm mới thẻ/ tài khoản ngân hàng</p>
          <div class="note">
            <p class="f16 text-bold">Lưu ý:</p>
            <p>- <span class="text-bold">Các thông tin về ngân hàng phải chính xác.</span> Nếu bạn điền sai thông tin mà chúng tôi đã thực hiện lệnh chuyển tiền thì bạn phải chịu phí chuyển tiền của ngân hàng.</p>
          </div>
          <form method="POST">
            <table class="withdrawing-table">
              <tr>
                <th>* Tên ngân hàng </th>
                <td>
                  <select name="bank_name" class="form-control">
                    <?php foreach ($list_bank as $key => $value) { ?>
                      <option value="<?=$value?>"><?=$value?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>* Chi nhánh</th>
                <td><input autocomplete="off" type="text" name="aff" class="form-control" onkeypress="blockSpecialChars(event)"></td>
              </tr>
              <tr>
                <th>* Số tài khoản ngân hàng</th>
                <td><input autocomplete="off" type="text" name="account_number" class="form-control" onkeypress="allowNumeric(event)"></td>
              </tr>
              <tr>
                <th>* Tên chủ tài khoản ngân hàng</th>
                <td><input autocomplete="off" type="text" name="account_name" class="form-control" onkeypress="blockSpecialChars(event)"></td>
              </tr>
              <input autocomplete="off" type="hidden" value="0" name="type_bank" class="form-control">
            </table>
            <div class="mt20 js-submit-form"><a href="javascript:void(0)" class="btn-continue">Thêm</a></div>
          </form>
        </div>
      </div>
      <div class="tab-pane fade <?=$_REQUEST['type'] == 'momo' ? 'show active' : '' ?>" id="momo" role="tabpanel" aria-labelledby="momo-tab">
        <div class="income-add-bank">
          <p class="text-red text-bold f16">Thêm mới thẻ MOMO</p>
          <div class="note">
            <p class="f16 text-bold">Lưu ý:</p>
            <p>- <span class="text-bold">Các thông tin về MOMO phải chính xác.</span> Nếu bạn điền sai thông tin mà chúng tôi đã thực hiện lệnh chuyển tiền thì bạn phải chịu phí chuyển tiền của MOMO.</p>
          </div>
          <form method="POST">
            <table class="withdrawing-table">
              <tr>
                <th>* Tên tài khoản </th>
                <td>
                  <input autocomplete="off" type="text" class="form-control" name="account_name" onkeypress="blockSpecialChars(event)">
                </td>
              </tr>
              <tr>
                <th>* Số điện thoại</th>
                <td><input autocomplete="off" type="text" class="form-control" name="account_number" onkeypress="allowNumeric(event)"></td>
              </tr>
              <input autocomplete="off" type="hidden" class="form-control" name="bank_name" value="momo">
              <input autocomplete="off" type="hidden" class="form-control" name="aff" value="momo">
              <input autocomplete="off" type="hidden" class="form-control" name="type_bank" value="1">
            </table>
            <div class="mt20 js-submit-form"><a href="javascript:void(0)" class="btn-continue">Thêm</a></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('.js-submit-form').on('click', function () {
    var $form = $(this).closest('form');
    var inputs = $form.find('input');
    for (var index = 0; index < inputs.length; index++) {
      var element = inputs[index];
      if($(element).val().trim().length == 0) {
       alert('Vui lòng điền đầy đủ thông tin')
       return false;
      }
    }

    if($form.find('input[name="type_bank"]').val() == 0) {
      if($form.find('input[name="account_number"]').val().length < 8) {
        alert('Số tài khoản ngân hàng không hợp lệ');
        return false;
      }
      if($form.find('input[name="account_number"]').val().length > 16) {
        alert('Số tài khoản ngân hàng không hợp lệ');
        return false;
      }
      if($form.find('input[name="account_name"]').val().length > 130) {
        alert('Tên chủ tài khoản ngân hàng không được nhập quá 130 kí tự');
        return false;
      }
    }

    if($form.find('input[name="type_bank"]').val() == 1) {
      var regex_symbols = /^0[0-9]*$/;
      if([10,11].indexOf($form.find('input[name="account_number"]').val().length) == -1) {
        alert('Số điện thoại Momo chỉ gồm 10 - 11 số');
        return false;
      }
      if(!regex_symbols.test($form.find('input[name="account_number"]').val())) {
        alert('Số điện thoại Momo không hợp lệ');
        return false;
      }
    }

    $form.attr('action', '<?=azibai_url('/affiliate/income-payment-account/create')?>');
    $form.submit();
  })
</script>