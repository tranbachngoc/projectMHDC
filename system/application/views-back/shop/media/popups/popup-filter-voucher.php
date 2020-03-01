<link href="/templates/home/boostrap/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">

<script src="/templates/home/boostrap/js/bootstrap-datepicker.js"></script>
<script src="/templates/home/boostrap/js/moment.js"></script>

<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
}
?>

<!-- The Modal -->
<div class="modal coupondisplayFilter" id="coupondisplayFilter">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <form id="filter_form" method="GET">
      <div class="modal-header">
        <h4 class="modal-title">Tìm kiếm</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="coupondisplayFilter-content">
          <div class="coupondisplayFilter-content-item inputKey">
            <input type="text" name="search" class="form-control" value="<?=@$_REQUEST["search"]?>" autocomplete="off" >
          </div>
          <div class="coupondisplayFilter-content-item">
            <h2>Loại mã giảm giá</h2>
            <ul class="coupondisplayFilter-types">
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="product_type" value="" <?=!isset($_REQUEST["product_type"]) || $_REQUEST["product_type"] === "" || $_REQUEST["product_type"] === 0 ? "checked" : ""?>>
                  <span>Tất cả</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="product_type" value="1" <?=@$_REQUEST["product_type"] == 1 ? "checked" : ""?>>
                  <span>Áp dụng cho tất cả sản phẩm</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="product_type" value="2" <?=@$_REQUEST["product_type"] == 2 ? "checked" : ""?>>
                  <span>Áp dụng cho từng sản phẩm</span>
                </label>
              </li>
            </ul>
          </div>
          <div class="coupondisplayFilter-content-item">
            <h2>Giảm giá theo</h2>
            <ul class="coupondisplayFilter-types">
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="voucher_type" value="" <?=!isset($_REQUEST["voucher_type"]) || $_REQUEST["voucher_type"] === "" || @$_REQUEST["voucher_type"] === 0 ? "checked" : ""?>>
                  <span>Tất cả</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="voucher_type" value="1" <?=@$_REQUEST["voucher_type"] == 1 ? "checked" : ""?>>
                  <span>Theo phần trăm</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="voucher_type" value="2" <?=@$_REQUEST["voucher_type"] == 2 ? "checked" : ""?>>
                  <span>Theo số tiền</span>
                </label>
              </li>
            </ul>
          </div>
          <div class="coupondisplayFilter-content-item">
            <h2>Giá tiền</h2>
            <div class="price-form">
              <input type="text" name="price_from" class="form-control" value="<?=@$_REQUEST["price_from"]?>" autocomplete="off" >
              <p class="ml10 mr10">đến</p>
              <input type="text" name="price_to" class="form-control" value="<?=@$_REQUEST["price_to"]?>" autocomplete="off" >
            </div>
          </div>
          <div class="coupondisplayFilter-content-item">
            <h2>Ngày áp dụng</h2>
            <div class="price-form">
              <input type="text" name="time_start" id="startdate" class="form-control" value="<?=@$_REQUEST["time_start"]?>" autocomplete="off" >
              <p class="ml10 mr10">đến</p>
              <input type="text" name="time_end" id="enddate" class="form-control" value="<?=@$_REQUEST["time_end"]?>" autocomplete="off" >
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle">Hủy</button>
            <button class="btn-share">Lọc</button>
          </div>
        </div>
      </div>
      </form>
      <!-- End modal-footer -->
    </div>
  </div>
</div>
<!-- End The Modal -->

<script>
  // $('.datepicker').datepicker({
  //   format: 'dd-mm-yyyy',
  //   startDate: '0d'
  // });

  $("#startdate").datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
    }).on('changeDate', function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $('#enddate').datepicker('setStartDate', minDate);
    });

    $("#enddate").datepicker({format: 'dd-mm-yyyy'})
      .on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#startdate').datepicker('setEndDate', maxDate);
      });


  $("input[name='price_from'], input[name='price_to']").on("input", function (event) {
    value = parseInt($(this).val());
    if(isNaN(value)) {
      $(this).val("");
      return false;
    } else {
      $(this).val(value);
      return false;
    }
  })

  $("#filter_form").on("submit", function (event) {
    event.preventDefault();
    url = "<?=base_url()."library/vouchers/search{$af_key}"?>" + "&"+encodeURI($(this).serialize());
    window.location.href = url;
  })
</script>