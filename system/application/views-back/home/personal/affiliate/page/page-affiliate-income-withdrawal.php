<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-content">
  <div class="affiliate-content-withdrawing">
    <p class="mt20 mb20">
      <a href="<?=azibai_url('/affiliate/income?member=1')?>">
        <i class="fa fa-angle-left f18 mr05" aria-hidden="true"></i>Rút tiền</a>
    </p>
    <div class="withdrawing-content">
      <div class="tit">
        <img src="/templates/home/styles/images/svg/user04.svg" alt="">Thông tin số dư tài khoản</div>
      <p class="ml30">Số dư khả dụng: <?=number_format($data_aff['money_draw'], 0, ',', '.')?> VNĐ</p>
      <?php if($data_aff['money_draw'] < (100000 + $data_aff['money_fee'])) { ?>
      <p class="ml30"><span class="text-bold text-red">Số dư khả dụng phải tổi thiếu: <?=number_format((100000 + $data_aff['money_fee']), 0, ',', '.') . ' VNĐ'?></span></p>
      <?php } ?>
      <div class="tit">
        <img src="/templates/home/styles/images/svg/phuongthuc.svg" alt="">Phương thức nhận tiền</div>
      <div class="accordion js-accordion">
        <?php if(!empty($data_aff['momos']) || !empty($data_aff['banks'])) { ?>
          <?php if(!empty($data_aff['momos'])) { ?>
          <div class="accordion-item mb10">
            <div class="pl30">
              <label class="checkbox-style-circle">
                <input type="radio" name="withdraw_type" value="1">
                <span>Chuyển vào ví Momo</span>
              </label>
            </div>
            <div class="panel-withdraw">
              <table class="withdrawing-table">
                <tr>
                  <th>Tài khoản: </th>
                  <td>
                    <select name="bank_id" class="form-control">
                      <?php foreach ($data_aff['momos'] as $key => $item) { ?>
                        <option value="<?=$item['id']?>"><?=$item['account_name']?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Số tiền cần rút:</th>
                  <td>
                    <div class="flex">
                      <input type="number" name="bank_money" value="100000" min="100000" class="form-control" placeholder="Nhập số tiền">&#12288;
                      <span class="text-nowrap">VNĐ</span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th>Phí chuyển khoản:</th>
                  <td class="f16"><?=number_format($data_aff['money_fee'], 0, ',', '.')?> VNĐ</td>
                </tr>
                <tr>
                  <th class="f16 text-bold">Tổng rút tiền:</th>
                  <td class="f16 text-red js-total_draw"><?=number_format(100000, 0, ',', '.')?> VNĐ</td>
                </tr>
              </table>
              <?php if($data_aff['money_draw'] >= 100000 ) { ?>
              <a class="btn-continue btn-pink js-withdraw" href="javascript:void(0)">Rút tiền</a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>

          <?php if(!empty($data_aff['banks'])) { ?>
          <div class="accordion-item">
            <div class="pl30">
              <label class="checkbox-style-circle">
                <input type="radio" name="withdraw_type" value="0">
                <span>Chuyển khoản ngân hàng</span>
              </label>
            </div>
            <div class="panel-withdraw">
              <table class="withdrawing-table">
                <tr>
                  <th>Ngân hàng: </th>
                  <td>
                    <select name="bank_id" id="" class="form-control">
                      <?php foreach ($data_aff['banks'] as $key => $item) { ?>
                        <option value="<?=$item['id']?>"><?=$item['bank_name']?></option>
                      <?php } ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Số tiền cần rút:</th>
                  <td>
                    <div class="flex">
                      <input type="number" name="bank_money" value="110000" min="110000" class="form-control" placeholder="Nhập số tiền">&#12288;
                      <span class="text-nowrap">VNĐ</span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th>Phí chuyển khoản:</th>
                  <td class="f16"><?=number_format($data_aff['money_fee'], 0, ',', '.')?> VNĐ</td>
                </tr>
                <tr>
                  <th class="f16 text-bold">Tổng rút tiền:</th>
                  <td class="f16 text-red js-total_draw"><?=number_format((100000 + $data_aff['money_fee']), 0, ',', '.')?> VNĐ</td>
                </tr>
              </table>
              <?php if($data_aff['money_draw'] >= (100000 + $data_aff['money_fee'])) { ?>
              <a class="btn-continue btn-pink js-withdraw" href="javascript:void(0)">Rút tiền</a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
        <?php } else { ?>
          <p class="ml30 mb10">Bạn chưa cập nhật tài khoản nhận tiền,<a href="<?=azibai_url("/affiliate/income-payment")?>" class="text-bold text-red">Vào đây</a> để thêm tài khoản.</p>
        <?php } ?>
      </div>
      <div class="note">
        <p class="f16 text-bold">Lưu ý:</p>
        <p>- Số tiền rút phải lớn hơn hoặc bằng
          <span class="text-bold">100.000 VNĐ + phí giao dịch</span> và nhỏ hơn hoặc bằng <span class="text-bold">10.000.000 VNĐ + phí giao dịch.</span></p>
        <p>-
          <span class="text-bold">Các thông tin về ngân hàng phải chính xác.</span> Nếu bạn điền sai thông tin mà chúng tôi đã thực hiện lệnh chuyển
          tiền thì bạn phải chịu phí chuyển tiền</p>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('home/personal/affiliate/popup/popup-confirm') ?>

<script>
  $('.panel-withdraw').hide();

  $('input[name="withdraw_type"]').on('change', function () {
    if($(this).is(':checked')){
      var $element = $(this).closest('.accordion-item').find('.panel-withdraw');
      $('.panel-withdraw').hide('3000');
      $element.show('3000');
    }
  });

  var bank_id = 0;
  var money = 0;
  var money_fee = 0;
  var max_money = <?=$data_aff['money_draw'] > 10000000 ? 10000000 : $data_aff['money_draw']?>;
  var min_money = 100000;

  $('input[name="withdraw_type"]').on('click', function() {
    if($(this).val() == 0) {
      money_fee = <?=$data_aff['money_fee']?>;
    } else {
      money_fee = 0;
    }
  })

  $('input[name="bank_money"]').on('change', function(){
    var _total = 0;
    if($(this).val() < (min_money + money_fee) ) {
      _total = min_money + money_fee;
      $(this).val( _total );
    } else if($(this).val() > (max_money - money_fee) ) {
      _total = max_money;
      $(this).val( max_money - money_fee);
    } else {
      _total = parseInt($(this).val())+ money_fee;
    }

    $(this).closest('.panel-withdraw').find('.js-total_draw').text(formatMoney(_total) + ' VNĐ');
  })

  $('.js-withdraw').on('click', function () {
    var $element = $(this).prev('table');
    bank_id = $element.find('select[name="bank_id"] option:selected').val();
    money = $element.find('input[name="bank_money"]').val();

    var html_mess = '<p>Số tiền rút là: <span class="text-bold text-red">'+formatMoney(money)+' VNĐ</span></p>';
    html_mess += '<p>Phí rút tiền: <span class="text-bold text-red">'+formatMoney(money_fee)+' VNĐ</span></p>';
    html_mess += '<p>Tổng tiền rút: <span class="text-bold text-red">'+formatMoney(parseInt(money)+ parseInt(money_fee))+' VNĐ</span></p>'
    $('#js-alert-popup .js-popup-mess').html(html_mess);
    $('#js-alert-popup').modal('show');
  })

  $('.js-popup-process').on('click', function () {
    if( (parseInt(money) + parseInt(money_fee)) < (min_money + parseInt(money_fee))
    || (parseInt(money) + parseInt(money_fee)) > (max_money + parseInt(money_fee))
    || bank_id == 0) {
      return false;
    } else {
      $.ajax({
        type: "POST",
        url: "<?=azibai_url('/affiliate/withdrawal/process')?>",
        data: {bank_id: bank_id, money: (parseInt(money)+ parseInt(money_fee))},
        dataType: "json",
        beforeSend: function () {
          $('#js-alert-popup').modal('hide');
          var html_mess = '<p><span class="text-bold text-red">Hệ thống đang xử lý vui lòng đợi !</span></p>';
          $('#js-msg .js-popup-mess').html(html_mess);
          $('#js-msg').modal('show');
        },
        success: function (response) {
          if(response.err == false) {
            var link = "<?=azibai_url('/affiliate/withdrawal-confirm/')?>" + response.id_transfer;
            window.location.href = link;
          } else {
            $('#js-msg').modal('hide');
            var html_mess = '<p><span class="text-bold text-red">'+response.msg+'</span></p>';
            $('#js-msg .js-popup-mess').html(html_mess);
            $('#js-msg').modal('show');
          }
        }
      });
    }
  })
</script>