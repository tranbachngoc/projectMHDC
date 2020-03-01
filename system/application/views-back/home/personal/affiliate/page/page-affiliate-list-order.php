<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-category">
  <ul>
    <li class="<?=$_REQUEST['type'] == 0 ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/order?type=0')?>">Tất cả (<span class="text-bold"><?=$data_aff['total_all']?></span>)</a>
    </li>
    <li class="<?=$_REQUEST['type'] == 1 ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/order?type=1')?>">Tôi bán (<span class="text-bold"><?=$data_aff['total_self']?></span>)</a>
    </li>
    <li class="<?=$_REQUEST['type'] == 2 ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/order?type=2')?>">Thành viên bán (<span class="text-bold"><?=$data_aff['total_ctv']?></span>)</a>
    </li>
  </ul>
</div>
<div class="affiliate-content">
  <div class="affiliate-content-member">
  <form id="frmSearch" method="POST">
    <div class="search">
      <div class="search-input">
        <input type="text" name="search" value="<?=$search?>" class="form-control" placeholder="Nhập mã đơn" autocomplete="off">
        <img src="/templates/home/styles/images/svg/search.svg" class="icon-search" alt="">
      </div>
      <div class="search-category">
        <input type="text" name="start" value="<?=$from_date ? $from_date : ''?>" id="startdate" class="form-control datepicker" placeholder="Chọn ngày" autocomplete="off">
      </div>
      <div class="search-category search-state">
        Đến&nbsp;&nbsp;<input type="text" name="end" value="<?=$to_date ? $to_date : ''?>" id="enddate" class="form-control datepicker" placeholder="Chọn ngày" autocomplete="off">
      </div>
      <div class="btn-search js-submit-search">Tìm kiếm</div>
    </div>
    </form>
  </div>

  <div class="affiliate-content-orders">
    <div class="row justify-content-between js-append-data">
      <?php if(isset($data_aff['orders']) && !empty($data_aff['orders'])) {
        foreach ($data_aff['orders'] as $key => $order) {
          $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-order', ['item'=>$order]);
        }
      } else {
        echo
        "<div class='col-xl-5 col-md-12'>
          <div class='item'>
            Chưa phát sinh đơn hàng
          </div>
        </div>";
      }?>
    </div>
  </div>
</div>

<?=$pagination?>

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
    $('#frmSearch').attr('action', '<?=azibai_url()."/affiliate/order?type=".$_REQUEST["type"]."&page=1"?>');
    $('#frmSearch').submit();
  })
</script>