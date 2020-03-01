<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 3;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 3;
  unset($request_tmp['quantily']);
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}

// next step review
$params_review = $_REQUEST;
$params_review['step'] = 7;
$params_review['skip'] = 1;
unset($params_review['is_review']);
$link_review = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($params_review);
?>

<link href="/templates/home/boostrap/css/bootstrap-datetimepicker.aff.min.css" rel="stylesheet" type="text/css">
<script src="/templates/home/boostrap/js/bootstrap-datetimepicker.aff.min.js"></script>
<script src="/templates/home/boostrap/js/moment.js"></script>

<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Chọn thời gian giảm giá</a>
  <a href="<?=$link_review?>">
    <p class="previous"><img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt=""><span class="md">Xem trước</span></p>
  </a>
</div>
<div class="coupon-stepdot">
  <ul>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
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
  </ul>
</div>
<div class="coupon-content">
  <div class="coupon-content-creat">
    <div class="">
      <div class="creat-item">
        <div class="creat-item-title">
          Thời gian bắt đầu
        </div>
        <div class="creat-item-content">
          <div class="apply-for-all">
            <input type="text" autocomplete="off" class="form-control datetimepicker1" id="startdate" placeholder="Chọn ngày" value="<?=$_REQUEST['is_review'] == 1 ? $_REQUEST['time_start'] : ''?>">
          </div>
        </div>
      </div>
      <div class="creat-item">
        <div class="creat-item-title">
          Thời gian kết thúc
        </div>
        <div class="creat-item-content">
          <div class="apply-for-all">
            <input type="text" autocomplete="off" class="form-control datetimepicker1" id="enddate" placeholder="Chọn ngày" value="<?=$_REQUEST['is_review'] == 1 ? $_REQUEST['time_end'] : ''?>"
            <?=$_REQUEST['is_review'] == 1 ? '' : 'disabled'?>>
          </div>
        </div>
      </div>
    </div>
    <p class="small-text">Thời gian bắt đầu là ngày mã giảm giá có hiệu lực, thời gian kết thúc là ngày hết hiệu lực của mã giảm giá.</p>
    <div class="text-center js-next-step-5" style="display:none">
      <a href="javascipt:void(0)" class="btn-continue">Tiếp tục</a>
    </div>
  </div>
</div>

<script>
  $("#startdate").datetimepicker({format: 'hh:ii dd-mm-yyyy'});
  $("#enddate").datetimepicker({format: 'hh:ii dd-mm-yyyy'});

  $("#startdate").change(function () {
    var startdate = $(this).val();
    var minutes = 5;
    // var start_date_5 = moment(startdate).add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss');
    var start_date_5 = moment(startdate, 'HH:mm DD-MM-YYYY').add(minutes, 'm').format('HH:mm DD-MM-YYYY');

    $('.js-next-step-5').hide();
    if(startdate == '' || startdate > $('#enddate').val('')) {
      $('#enddate').val('');
      $('#enddate').attr('disabled', true);
    } else {
      $('#enddate').datetimepicker("setStartDate", start_date_5);
      $('#enddate').attr('data-date', start_date_5);
      $('#enddate').attr('disabled', false);
    }
  })

  $("#enddate").change(function () {
    if($('#enddate').val() != '') {
      $('.js-next-step-5').show();
    } else {
      $('.js-next-step-5').hide();
    }
  })


  <?php if($is_review == 1 && @$_REQUEST['time_start'] && @$_REQUEST['time_end']) { ?>
    $(document).ready(function(){
      $('.js-next-step-5').show();
      $('.js-next-step-5 > a').click(function () {
        <?php
        $_REQUEST['step'] = 5;
        unset($_REQUEST['time_start']);
        unset($_REQUEST['time_end']);
        $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
        ?>
        url = '<?=$url?>'

        var time_start = $('#startdate').val();
        var time_end = $('#enddate').val();
        if (time_start != '' && time_end != '') {
          url = url + '&time_start=' + time_start + '&time_end=' + time_end;
          window.location.href = url;
          return false;
        }
      });
    });
  <?php } else { ?>
    $('.js-next-step-5 > a').click(function () {
      <?php
      $_REQUEST['step'] = 5;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>'

      var time_start = $('#startdate').val();
      var time_end = $('#enddate').val();
      if (time_start != '' && time_end != '') {
        url = url + '&time_start=' + time_start + '&time_end=' + time_end;
        window.location.href = url;
        return false;
      }
    });
  <?php } ?>
</script>