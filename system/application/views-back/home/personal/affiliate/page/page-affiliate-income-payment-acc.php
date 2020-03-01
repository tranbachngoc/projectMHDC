<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php $this->load->view('home/personal/affiliate/element/element-subtab-page-affiliate-income');?>

<div class="affiliate-content">
  <div class="affiliate-content-income">
    <ul class="nav nav-tabs income-tabs-bank" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="true">Tài khoản ngân hàng</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="momo-tab" data-toggle="tab" href="#momo" role="tab" aria-controls="momo" aria-selected="false">Tài khoản Momo</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active" id="bank" role="tabpanel" aria-labelledby="bank-tab">
        <div class="income-banks">
          <a class="add-bank mb10" href="<?=azibai_url('/affiliate/income-payment-account?type=bank')?>">
            <img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr05" width="20" alt="">Thêm tài khoản ngân hàng</a>
          <div class="row">
            <?php if($data_aff['banks'] && !empty($data_aff['banks'])) {
              foreach ($data_aff['banks'] as $key => $item) {
                $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-income-payment-acc-bank', ['item'=>$item]);
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="momo" role="tabpanel" aria-labelledby="momo-tab">
        <div class="income-banks">
          <a class="add-bank mb10" href="<?=azibai_url('/affiliate/income-payment-account?type=momo')?>">
            <img src="/templates/home/styles/images/svg/add_circle_black02.svg" class="mr05" width="20" alt="">Thêm tài khoản Momo</a>
          <div class="row">
            <?php if($data_aff['momos'] && !empty($data_aff['momos'])) {
              foreach ($data_aff['momos'] as $key => $item) {
                $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-income-payment-acc-momo', ['item'=>$item]);
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('home/personal/affiliate/popup/popup-confirm');?>

<script>
  $('.js-edit-bank').click(function () {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    window.location.href = "<?=azibai_url('/affiliate/income-payment-account-edit/')?>"+id+"?type="+type;
  })

  $('.js-delete-bank').click(function () {
    var id = $(this).attr('data-id');

    var html = $(this).closest('.item').find('p').html();
    var $element = $('#js-alert-popup');
    $element.find('.modal-title').html("Xóa tài khoản rút tiền");
    $element.find('.js-popup-mess').html(html);
    $element.find('.js-popup-process').attr('data-id', id);
    $element.modal('show');
  })

  $('#js-alert-popup .js-popup-process').on('click', function () {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      url: "<?=azibai_url('/home/api_affiliate/delete_payment_account_income')?>",
      dataType: 'json',
      data: {bank_id: id},
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          window.location.reload();
        }else {
          $('.load-wrapp').hide();
          alert("Lỗi kết nối!");
        }
      }
    });
  });
</script>