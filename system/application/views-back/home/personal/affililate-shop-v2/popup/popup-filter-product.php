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
<div class="modal coupondisplayFilter" id="productFilter">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <form id="filter_form_product">
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
            <h2>Tình trạng</h2>
            <ul class="coupondisplayFilter-types">
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_quality" value="" <?=!isset($_REQUEST["pro_quality"]) || $_REQUEST["pro_quality"] === "" ? "checked" : ""?>>
                  <span>Tất cả</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_quality" value="0" <?=@$_REQUEST["pro_quality"] === 0 || $_REQUEST["pro_quality"] === "0" ? "checked" : ""?>>
                  <span>Mới</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_quality" value="1" <?=@$_REQUEST["pro_quality"] === 1 || $_REQUEST["pro_quality"] === "1" ? "checked" : ""?>>
                  <span>Đã qua sử dụng</span>
                </label>
              </li>
            </ul>
          </div>
          <div class="coupondisplayFilter-content-item">
            <h2>Giảm giá theo</h2>
            <ul class="coupondisplayFilter-types">
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_saleoff" value="" <?=!isset($_REQUEST["pro_saleoff"]) || $_REQUEST["pro_saleoff"] === "" ? "checked" : ""?>>
                  <span>Tất cả</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_saleoff" value="2" <?=@$_REQUEST["pro_saleoff"] == 2 ? "checked" : ""?>>
                  <span>Bán sỉ</span>
                </label>
              </li>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="pro_saleoff" value="1" <?=@$_REQUEST["pro_saleoff"] == 1 ? "checked" : ""?>>
                  <span>Đang khuyến mãi</span>
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
        </div>
      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle" type="button">Hủy</button>
            <button class="btn-share" type="submit">Lọc</button>
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

  $("#filter_form_product").on("submit", function (event) {
    event.preventDefault();
    url = "<?=$info_public['profile_url']."affiliate-shop/$type_path/search{$af_key}"?>" + "&"+encodeURI($(this).serialize());
    window.location.href = url;
  })
</script>