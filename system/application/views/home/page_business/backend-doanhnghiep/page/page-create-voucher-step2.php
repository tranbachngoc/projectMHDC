<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 1;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 1;
  unset($request_tmp['product_type']);
  unset($request_tmp['price_rank']);
  unset($request_tmp['list_product']);
  unset($request_tmp['count_item']);
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}
?>


<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Chọn loại mã giảm giá</a>
</div>
<div class="coupon-stepdot">
  <ul>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
  </ul>
</div>
<div class="coupon-content">
  <div class="coupon-content-creat">
    <div class="accordion js-accordion">
      <div class="accordion-item creat-item js-box-item" data-type="1">
        <div class="accordion-toggle creat-item-title js-box-item-click js-class-1">
          Giảm giá theo tỷ lệ phần trăm
        </div>
        <div class="accordion-panel creat-item-content">
          <div class="apply-for-all">
            <input type="text" class="form-control js-dc-percent" placeholder="Nhập số" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['voucher_type'] == 1 ? $_REQUEST['value'] : ''?>">
          </div>
        </div>
      </div>
      <div class="accordion-item creat-item js-box-item" data-type="2">
        <div class="accordion-toggle creat-item-title js-box-item-click js-class-2">
          Giảm giá theo số tiền
        </div>
        <div class="accordion-panel creat-item-content">
          <div class="apply-for-all">
            <input type="text" class="form-control js-dc-price" placeholder="Số tiền được giảm" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['voucher_type'] == 2 ? $_REQUEST['value'] : ''?>">
          </div>
        </div>
      </div>
    </div>
    <div class="text-center js-next-step-3" style="display:none">
      <a href="javascript:void(0)" class="btn-continue">Tiếp tục</a>
    </div>
  </div>
</div>

<script>
  var type = <?=$_REQUEST['voucher_type'] ? $_REQUEST['voucher_type'] : 0?>;
  var value = <?=$_REQUEST['value'] ? $_REQUEST['value'] : 0?>;
  var flag = false;
  $('.js-box-item > .js-box-item-click').on('click', function () {
    type = value = 0;
    flag = false;

    $element = $(this).closest('.js-box-item');
    type = parseInt($($element).attr('data-type'));
    // if(type === 1) {
    //   $('.js-dc-price').val('');
    // }
    // if(type === 2) {
    //   $('.js-dc-percent').val('');
    // }
    if(!$($element).hasClass('is-open')) {
      flag = true;
      $('.js-next-step-3').show();
    } else {
      flag = false;
      $('.js-next-step-3').hide();
    }
  })

  $('.js-dc-percent, .js-dc-price').on('change', function () {
    value = parseInt($(this).val());

    if($(this).hasClass('js-dc-percent') && (value < 1 || value > 100 || isNaN(value)) ){
      $(this).val('');
      value = 0;
    } else if($(this).hasClass('js-dc-price') && (value < 1 || isNaN(value)) ){
      $(this).val('');
      value = 0;
    } else {
      $(this).val(value);
    }
  });


  <?php if($is_review == 1) { ?>
    $(document).ready(function(){
      setTimeout(function(){
        var className = "<?=$_REQUEST['is_review'] == 1 && $_REQUEST['voucher_type'] == 1 ? '.js-class-1' : '.js-class-2'?>";
        $(className).trigger('click');
        value = <?=$_REQUEST['value']?>;
        type = <?=$_REQUEST['voucher_type']?>;
      }, 500);

      $('.js-next-step-3 > a').click(function () {
        if(type === 1) {
          value = parseInt($('.js-dc-percent').val());
          value > 0 && value <= 100 ? flag = true : flag = false;
        }
        if(type === 2) {
          value = parseInt($('.js-dc-price').val());
          value > 0 ? flag = true : flag = false;
        }

        if(flag === true && value !== 0) {
          <?php
          $_REQUEST['step'] = 3;
          unset($_REQUEST['value']);
          unset($_REQUEST['voucher_type']);
          $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
          ?>
          var url  = '<?=$url?>'
          + '&voucher_type=' + type
          + '&value=' + value;

          window.location.href = url;
          return false;
        }
      })
    });

  <?php } else { ?>
    $('.js-next-step-3 > a').click(function () {
      <?php
      $_REQUEST['step'] = 3;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>';

      if(type === 1) {
        value = parseInt($('.js-dc-percent').val());
        value > 0 && value <= 100 ? flag = true : flag = false;
      }
      if(type === 2) {
        value = parseInt($('.js-dc-price').val());
        value > 0 ? flag = true : flag = false;
      }

      if(flag === true && value !== 0) {
        url = url + '&voucher_type=' + type + '&value=' + value;
        window.location.href = url;
        return false;
      }
    });
  <?php } ?>
</script>