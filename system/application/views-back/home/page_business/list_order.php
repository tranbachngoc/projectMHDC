<?php
$this->load->view('home/common/header_new');
?>
<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<link href="/templates/landing_page/css/font-awesome.css" rel="stylesheet">
<link href="/templates/home/styles/css/admin.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/ordersmanager.css" rel="stylesheet" type="text/css">
<link href="/templates/home/boostrap/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/supperDefault.css" rel="stylesheet" type="text/css">

<script src="/templates/home/boostrap/js/bootstrap-datepicker.js"></script>
<script src="/templates/home/boostrap/js/moment.js"></script>
<script src="/templates/home/styles/js/common.js"></script>

<main class="ordersmanager">
  <section class="main-content">
    <div class="breadcrumb control-board">
      <div class="container">
        <ul>
          <li>
            <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Quản lý đơn hàng</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="affiliate-menupage">
        <ul>
          <li class="<?=!isset($_REQUEST['pro_type']) || $_REQUEST['pro_type'] === '' ? 'active' : ''?>">
            <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}")?>">
              <span class="icon">
                <img src="/templates/home/styles/images/svg/affiliate_newest<?=!isset($_REQUEST['pro_type']) || $_REQUEST['pro_type'] === '' ? '_on' : ''?>.svg" alt="">
              </span>
              <br>
              <span class="tit">Mới nhất</span>
            </a>
          </li>
          <li class="<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '3' ? 'active' : ''?>">
            <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}?pro_type=3")?>">
              <span class="icon">
                <img src="/templates/home/styles/images/svg/affiliate_coupon<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '3' ? '_on' : ''?>.svg" alt="">
              </span>
              <br>
              <span class="tit">Mã giảm giá</span>
            </a>
          </li>
          <li class="<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '0' ? 'active' : ''?>">
            <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}?pro_type=0")?>">
              <span class="icon">
                <img src="/templates/home/styles/images/svg/affiliate_product<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '0' ? '_on' : ''?>.svg" alt="">
              </span>
              <br>
              <span class="tit">Sản phẩm</span>
            </a>
          </li>
          <li class="<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '2' ? 'active' : ''?>">
            <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}?pro_type=2")?>">
              <span class="icon">
                <img src="/templates/home/styles/images/svg/affiliate_pmh<?=isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] === '2' ? '_on' : ''?>.svg" alt="">
              </span>
              <br>
              <span class="tit">Phiếu mua hàng</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="ordersmanager-content">
        <div class="administrator-bussinesspost ordersmanager-content-newest">
          <form method="get">
          <div class="search">
            <div class="search-date md">
              <input type="hidden" class="form-control" name="pro_type" value="<?=$_REQUEST['pro_type']?>" autocomplete="off">
              <div class="from">
                <input type="text" class="form-control datepicker" name="start_date" id="start_date" value="<?=$_REQUEST['start_date']?>" placeholder="Chọn ngày" autocomplete="off">
              </div>
              <p class="txt">Đến</p>
              <div class="to">
                <input type="text" class="form-control datepicker" name="end_date" id="end_date" value="<?=$_REQUEST['end_date']?>" placeholder="Chọn ngày" autocomplete="off">
              </div>
            </div>
            <div class="search-category md">
              <input type="text" class="form-control" name="order_id" value="<?=$_REQUEST['order_id']?>" placeholder="Mã đơn hàng" autocomplete="off">
            </div>
            <div class="search-category md">
              <input type="text" class="form-control" name="customer_name" value="<?=$_REQUEST['customer_name']?>" placeholder="Tên khách hàng" autocomplete="off">
            </div>
            <div class="search-category md">
              <input type="text" class="form-control" name="pro_name" value="<?=$_REQUEST['pro_name']?>" placeholder="Tên sản phẩm" autocomplete="off">
            </div>
            <div class="search-category md">
              <select name="order_status" id="order_status" class="form-control">
                <option value=''>Chọn thái đơn hàng</option>
                <?php foreach ($list_status as $key => $value) {
                  echo "<option value='{$value['status_id']}'".($_REQUEST['order_status'] == $value['status_id'] ? 'selected' : '').">{$value['text']}</option>";
                } ?>
              </select>
            </div>
            <button class="btn-search md" type="submit">Tìm kiếm</button>

            <div class="sm">
              <a class="btn-search btn-search-sm mr00" href="#search-modal-sm" data-toggle="modal">Tìm kiếm</a>
            </div>
          </div>
          </form>

          <div class="buyer-title sm">Đơn hàng</div>
          <div class="ordersmanager-table">
            <table>
              <tr class="sm-none">
                <th>Ngày mua</th>
                <th>Mã đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Người mua</th>
                <th>Tổng cộng</th>
                <th>Nhà vận chuyển</th>
                <th>Trạng thái</th>
                <th>Nhắn tin</th>
              </tr>
              <?php foreach ($orders as $key => $item) { //dd($item);?>
              <?php
                $_date = date("d-m-Y", $item['date']);
                $_time = date("h:i:s", $item['date']);
                $_order_img = $item['order_details'][0]['product']['main_img_full'];
                $_order_name = $item['order_details'][0]['product']['pro_name'] . (count($item['order_details']) > 1 ? ' và '.count($item['order_details']). ' sản phẩm khác' : '');
              ?>
              <tr>
                <td class="id sm-none"><?=$_date?><br><?=$_time?></td>
                <td class="sm-none"><a class="text-red" href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}/view/{$item['id']}?pro_type={$item['product_type']}")?>">#<?=$item['id']?></a></td>
                <td class="title">
                  <div class="sm">
                    <div class="info">
                      <div class="left">
                        <div class="code"><a class="text-red" href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}/view/{$item['id']}?pro_type={$item['product_type']}")?>">#<?=$item['id']?></a></div>
                        <div class="time"><?="{$_date} {$_time}"?></div>
                      </div>
                      <div class="status"><?=$item['status']['text']?></div>
                    </div>
                  </div>
                  <div class="product">
                    <img src="<?=$_order_img?>" alt="" class="avata">
                    <div class="tt"><?=$_order_name?></div>
                  </div>
                  <div class="sm">
                    <div class="text">
                      <p><span>Mua bởi: </span><?=$item['user_receive']['ord_sname']?></p>
                      <p><span>Tổng tiền: </span><?=number_format($item['order_total'],0,',','.')?> VND</p>
                      <p><span>Nhà vận chuyển: </span><?=$item['shipping_method']?></p>
                      <p><span>Trạng thái: </span><?=$item['status']['text']?></p>
                      <p><span>Nhắn tin: </span><a href="javacript:void(0)"><img src="/templates/home/styles/images/svg/message04.svg" alt=""></a></p>
                    </div>
                  </div>
                </td>
                <td class="sm-none"><?=$item['user_receive']['ord_sname']?></td>
                <td class="sm-none"><?=number_format($item['order_total'],0,',','.')?> VND</td>
                <td class="sm-none"><?=$item['shipping_method']?></td>
                <td class="sm-none"><?=$item['status']['text']?></td>
                <td class="sm-none"><a href="javacript:void(0)" class="mess-icon"><img src="/templates/home/styles/images/svg/message04.svg" alt=""></a></td>
              </tr>
              <?php }?>
            </table>
          </div>
          <?=$pagination?>
        </div>
      </div>
    </div>
  </section>
</main>

<footer id="footer"></footer>
<script src="/templates/home/js/page_business.js"></script>

<!-- The Modal -->
<div class="modal affiliate-modal" id="search-modal-sm">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <form method="get">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tìm kiếm đơn hàng sản phẩm</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="ordersmanager-content">
          <div class="search">
            <input type="hidden" class="form-control" name="pro_type" value="<?=$_REQUEST['pro_type']?>" autocomplete="off">
            <div class="search-date">
              <div class="from">
                <input type="text" class="form-control datepicker" name="start_date" id="start_date_pu" value="<?=$_REQUEST['start_date']?>" placeholder="Chọn ngày" autocomplete="off">
              </div>
              <p class="txt">Đến</p>
              <div class="to">
                <input type="text" class="form-control datepicker" name="end_date" id="end_date_pu" value="<?=$_REQUEST['end_date']?>" placeholder="Chọn ngày" autocomplete="off">
              </div>
            </div>
            <div class="search-category">
              <input type="text" class="form-control" name="order_id" value="<?=$_REQUEST['order_id']?>" placeholder="Mã đơn hàng" autocomplete="off">
            </div>
            <div class="search-category">
              <input type="text" class="form-control" name="customer_name" value="<?=$_REQUEST['customer_name']?>" placeholder="Tên khách hàng" autocomplete="off">
            </div>
            <div class="search-category">
              <input type="text" class="form-control" name="pro_name" value="<?=$_REQUEST['pro_name']?>" placeholder="Tên sản phẩm" autocomplete="off">
            </div>
            <div class="search-category">
              <select name="order_status" class="form-control">
                <option value="">Chọn trạng thái</option>
                <?php foreach ($list_status as $key => $value) {
                  echo "<option value='{$value['status_id']}'".($_REQUEST['order_status'] == $value['status_id'] ? 'selected' : '').">{$value['text']}</option>";
                } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle">Hủy</button>
            <button class="btn-share" type="submit">Tìm kiếm</button>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->       
    </div>
    </form>
  </div>
  <script>
  $("#start_date_pu").datepicker({format: 'dd-mm-yyyy'});
  $("#end_date_pu").datepicker({format: 'dd-mm-yyyy'});
  $(document).ready(function () {
    var startdate_pu = $("#start_date_pu").val();
    if(startdate_pu == '') {
      $('#end_date_pu').val('');
    } else {
      $('#end_date_pu').datepicker("setStartDate", startdate_pu);
      $('#end_date_pu').attr('data-date', startdate_pu);
    }
  });

  $("#start_date_pu").change(function () {
    startdate_pu = $(this).val();

    if(startdate_pu == '' || startdate_pu > $('#end_date_pu').val('')) {
      $('#end_date_pu').val('');
    } else {
      $('#end_date_pu').datepicker("setStartDate", startdate_pu);
      $('#end_date_pu').attr('data-date', startdate_pu);
    }
  })
</script>
</div>
<!-- End The Modal -->

<script>
  $("#start_date").datepicker({format: 'dd-mm-yyyy'});
  $("#end_date").datepicker({format: 'dd-mm-yyyy'});
  $(document).ready(function () {
    var startdate = $("#start_date").val();
    if(startdate == '') {
      $('#end_date').val('');
    } else {
      $('#end_date').datepicker("setStartDate", startdate);
      $('#end_date').attr('data-date', startdate);
    }
  });

  $("#start_date").change(function () {
    startdate = $(this).val();

    if(startdate == '' || startdate > $('#end_date').val('')) {
      $('#end_date').val('');
    } else {
      $('#end_date').datepicker("setStartDate", startdate);
      $('#end_date').attr('data-date', startdate);
    }
  })

  $('input[name="order_id"]').on('keyup', function () {
    value = parseInt($(this).val());
    if(isNaN(value)) {
      $(this).val('');
    } else {
      $(this).val(value);
    }
  });
</script>