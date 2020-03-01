<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-content">
  <div class="affiliate-content-withdrawing">
    <p class="mt20 mb20">
      <a href="<?=azibai_url('/affiliate/withdrawal')?>">
        <i class="fa fa-angle-left f18 mr05" aria-hidden="true"></i>Xác nhận rút tiền</a>
    </p>
    <div class="withdrawing-content">
      <div class="affiliate-verifycode">
        <p>Nhập mã xác nhận</p>
        <p class="inputcode">
          <input type="text" name="code_transfer" class="form-control">
        </p>
        <button class="btn-pink js-sumbit-transfer">Xác nhận</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('home/personal/affiliate/popup/popup-confirm') ?>

<script>
  var id = '<?=$id_payment_transfer?>';
  $('.js-sumbit-transfer').click(function () {
    var code = $('input[name="code_transfer"]').val();
    $.ajax({
      type: "POST",
      url: "<?=azibai_url('/home/api_affiliate/confirm_transfer_money')?>",
      data: {id: id, code: code},
      dataType: "json",
      beforeSend: function () {
        var html_mess = '<p><span class="text-bold text-red">Hệ thống đang xử lý vui lòng đợi !</span></p>';
        $('#js-msg .js-popup-mess').html(html_mess);
        $('#js-msg').modal('show');
      },
      success: function (response) {
        console.log(response);
        if(response.status == 1) {
          var html_mess = '<p><span class="text-bold text-red">Thành công !</span></p>';
          $('#js-msg .js-popup-mess').html(html_mess);
          window.location.replace('<?=azibai_url("/affiliate/income")?>');
        } else {
          $('input[name="code_transfer"]').val('');
          var html_mess = '<p><span class="text-bold text-red">Mã xác nhận không hợp lệ !</span></p>';
          $('#js-msg .js-popup-mess').html(html_mess);
        }
      }
    });
  });
</script>