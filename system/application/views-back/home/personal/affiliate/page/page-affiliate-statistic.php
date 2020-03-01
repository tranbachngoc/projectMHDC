<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-category">
  <ul>
    <li class="<?=$_REQUEST['view'] == 'general' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/statistic?view=general')?>">Tổng quan</a>
    </li>
    <li class="<?=$_REQUEST['view'] == 'person' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/statistic?view=person')?>">Cá nhân</a>
    </li>
    <li class="<?=$_REQUEST['view'] == 'system' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/statistic?view=system')?>">Hệ thống</a>
    </li>
  </ul>
</div>
<div class="affiliate-content">
  <form method="POST" id="frmSearch">
  <div class="affiliate-content-member">
    <div class="search">
      <div class="search-category">
        <input autocomplete="off" type="text" value="<?=$from_date?>" name="start" id="startdate" class="form-control datepicker" placeholder="Chọn ngày">
      </div>
      <div class="search-category search-state">
        Đến
        <input autocomplete="off" type="text" value="<?=$to_date?>" name="end" id="enddate" class="form-control datepicker" placeholder="Chọn ngày">
      </div>
      <div class="btn-search js-submit-search">Tìm kiếm</div>
    </div>
  </div>
  </form>

  <div class="affiliate-content-statis">
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="item">
          <img src="/templates/home/styles/images/svg/affiliate_statis01.svg" alt="">
          <div class="text">
            <div class="price"><?=number_format($statistic['success_thu_nhap'], 0, ',', '.')?>
              <span class="f16">VND</span>
            </div>
            <div class="small-text">Thu nhập <?=(empty($from_date) && empty($to_date) ? 'hôm nay' : '')?></div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="item">
          <img src="/templates/home/styles/images/svg/affiliate_statis01.svg" alt="">
          <div class="text">
            <div class="price"><?=number_format($statistic['success_doanh_thu'], 0, ',', '.')?>
              <span class="f16">VND</span>
            </div>
            <div class="small-text">Doanh thu <?=(empty($from_date) && empty($to_date) ? 'hôm nay' : '')?></div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="item">
          <img src="/templates/home/styles/images/svg/affiliate_statis01.svg" alt="">
          <div class="text">
            <div class="price"><?=$statistic['total_order']?>
              <!-- <span class="f16">VND</span> -->
            </div>
            <div class="small-text">Đơn hàng <?=(empty($from_date) && empty($to_date) ? 'hôm nay' : '')?></div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="item">
          <img src="/templates/home/styles/images/svg/affiliate_statis01.svg" alt="">
          <div class="text">
            <div class="price"><?=$statistic['total_user']?></div>
            <div class="small-text">Thành viên <?=(empty($from_date) && empty($to_date) ? 'hôm nay' : '')?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<script type="text/javascript">
  $(".datepicker").datepicker({
    format: 'dd-mm-yyyy',
    endDate: new Date(),
  });
  $('#enddate').attr('disabled', true);

  $("#startdate").change(function () {
    var startdate = $(this).val();
    var days = 0;
    var start_date_1 = moment(startdate, 'DD-MM-YYYY').add(days, 'd').format('DD-MM-YYYY');

    if(startdate == '' || startdate > $('#enddate').val('')) {
      $('#enddate').val('');
      $('#enddate').attr('disabled', true);
    } else {
      $('#enddate').datepicker("setStartDate", start_date_1);
      $('#enddate').attr('data-date', start_date_1);
      $('#enddate').attr('disabled', false);
    }
  })

  $('.js-submit-search').on('click', function (e) {
    $('#frmSearch').submit();
  })
</script>