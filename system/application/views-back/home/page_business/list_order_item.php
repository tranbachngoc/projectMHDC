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
          <li><a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}") . (isset($_REQUEST['pro_type']) ? "?pro_type={$_REQUEST['pro_type']}" : "")?>">
            <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Quản lý đơn hàng</li></a>
          <li>
            <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="mr10" alt="">Chi tiết đơn hàng</li>
        </ul>
        <?php $this->load->view('home/page_business/common/menu_left'); ?>
      </div>
    </div>
    <div class="container">
      <div class="ordersmanager-content">
        <div class="ordersmanager-content-detail">
          <div class="tt">
            <div class="left">
              <div class="code item">Mã đơn hàng
                <span># <?=$order['id']?></span>
              </div>
              <div class="time item"><?="Ngày mua " . date("d-m-Y", $order['date'])?></div>
              <div class="time item"><?=$order['change_status_date'] ? "Ngày {$order['status']['text']} " . date("d-m-Y", $order['change_status_date']) : ''?></div>
              <div class="status item"><?=$order['status']['text']?></div>
            </div>
            <div class="right">
              <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}") . (isset($_REQUEST['pro_type']) ? "?pro_type={$_REQUEST['pro_type']}" : "")?>">Quay về danh sách</a>
            </div>
          </div>
          <div class="info">
            <div class="item">
              <table>
                <tr>
                  <th>Cộng tác viên</th>
                  <td>
                    <a href="javascript:void(0)" class="text-red"><?=$order['user_aff']['use_fullname']?></a>
                  </td>
                </tr>
                <tr>
                  <th>Hình thức thanh toán</th>
                  <td><?=$order['payment_method']?></td>
                </tr>
                <tr>
                  <th>Tình trạng thanh toán</th>
                  <td><?=$order['payment_status'] == 1 ? "Đã thanh toán" : "Chưa thanh toán"?></td>
                </tr>
                <tr>
                  <th>Nhà vận chuyển</th>
                  <td><?=$order['shipping_method']?></td>
                </tr>
                <tr>
                  <th>Trạng thái đơn hàng</th>
                  <td><?=$order['status']['text']?></td>
                </tr>
              </table>
            </div>
            <div class="item">
              <table>
                <tr>
                  <th>Người nhận</th>
                  <td>
                    <a href="javascript:void(0)" class="text-red"><?=$order['user_receive']['ord_sname']?></a>
                  </td>
                </tr>
                <tr>
                  <th>Điện thoại </th>
                  <td><?=$order['user_receive']['ord_smobile']?></td>
                </tr>
                <tr>
                  <th>Địa chỉ nhận </th>
                  <td><?=$order['user_receive']['ord_saddress']?></td>
                </tr>
                <tr>
                  <th>Tỉnh/Thành</th>
                  <td><?=$order['user_receive']['district']['ProvinceName']?></td>
                </tr>
                <tr>
                  <th>Quận/Huyện</th>
                  <td><?=$order['user_receive']['district']['DistrictName']?></td>
                </tr>
              </table>
            </div>
            <div class="item">
              <table>
                <tr>
                  <th>Người mua</th>
                  <td>
                    <a href="javascript:void(0)" class="text-red"><?=$order['user']['use_fullname']?></a>
                  </td>
                </tr>
                <tr>
                  <th>Điện thoại </th>
                  <td><?=$order['user']['use_mobile']?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="administrator-bussinesspost">
          <div class="ordersmanager-table detail">
            <table>
              <tr>
                <th>Sản phẩm</th>
                <th class="sm-none">Giá bán</th>
                <th class="sm-none">Số lượng</th>
                <th class="sm-none">Khuyến mãi</th>
                <th class="sm-none">Giảm qua ctv</th>
                <th class="sm-none">Giảm sỉ</th>
                <th class="sm-none">Thành tiền</th>
              </tr>
              <?php foreach ($order['order_details'] as $key => $item) { ?>
              <?php // uu tien rate 
                $price_original = number_format($item['pro_price_original'],0,',','.') . " VNĐ"; //Giá bán
                $price_discount = $item['pro_price_rate'] > 0 ? number_format($item['pro_price_rate'],0,',','.') . " %" : number_format($item['pro_price_amt'],0,',','.') . " VNĐ"; //khuyuen mai pro_price_rate // pro_price_amt
                $discount_ctv = $item['affiliate_discount_rate'] > 0 ? number_format($item['affiliate_discount_rate'],0,',','.') . " %" : number_format($item['affiliate_discount_amt'],0,',','.') . " VNĐ"; // giam ctv affiliate_discount_rate // affiliate_discount_amt
                $discount_em =  number_format($item['em_discount'],0,',','.') . " VNĐ"; // giam si // em_discount
                $price_total_product = number_format($item['shc_total'],0,',','.') . " VNĐ"; // tong tien pro_price x shc_quantity - em_discount
              ?>
              <tr>
                <td class="title">
                  <div class="product">
                    <img src="<?=$item['product']['main_img_full']?>" alt="" class="avata">
                    <div class="tt"><?=$item['product']['pro_name']?></div>
                  </div>
                  <div class="info">
                    <?php if($item['qc_product']['dp_color'] != '') { ?>
                    <p>
                      <span class="tit">Màu</span><?=$item['qc_product']['dp_color']?></p>
                    <?php } ?>
                    <?php if($item['qc_product']['dp_size'] != '') { ?>
                    <p>
                      <span class="tit">Kích thước</span>
                      <span class="size"><?=$item['qc_product']['dp_size']?></span>
                    </p>
                    <?php } ?>
                    <?php if($item['qc_product']['dp_material'] != '') { ?>
                    <p>
                      <span class="tit">Chất liệu</span><?=$item['qc_product']['dp_material']?></p>
                    <?php } ?>
                    <p class="sm">
                      <span class="tit">Giá bán</span><?=$price_original?></p>
                    <p class="sm">
                      <span class="tit">Số lượng</span><?=$item['shc_quantity']?></p>
                    <p class="sm">
                      <span class="tit">Khuyến mãi</span><?=$price_discount?></p>
                    <p class="sm">
                      <span class="tit">Giảm qua ctv</span><?=$discount_ctv?></p>
                    <p class="sm">
                      <span class="tit">Giảm sỉ</span><?=$discount_em?></p>
                    <p class="sm">
                      <span class="tit">Thành tiền</span><?=$price_total_product?></p>
                  </div>
                </td>
                <td class="sm-none"><?=$price_original?></td>
                <td class="sm-none"><?=$item['shc_quantity']?></td>
                <td class="sm-none"><?=$price_discount?></td>
                <td class="sm-none"><?=$discount_ctv?></td>
                <td class="sm-none"><?=$discount_em?></td>
                <td class="sm-none"><?=$price_total_product?></td>
              </tr>
              <?php } ?>
            </table>
            <div class="ordersmanager-sumprice">
              <p>Tổng giá sản phẩm
                <span class="sum"><?=number_format($order['order_total_no_shipping_fee'],0,',','.') . " VNĐ"?></span>
              </p>
              <p>Phí vận chuyển
                <span class="sum"><?=number_format($order['shipping_fee'],0,',','.') . " VNĐ"?></span>
              </p>
              <p>Tổng cộng
                <span class="sum"><?=number_format(($order['order_total_no_shipping_fee'] + $order['shipping_fee']),0,',','.') . " VNĐ"?></span>
              </p>
            </div>
            
            <div class="ordersmanager-buttons">
              <?php if(in_array($order['order_status'], ['01','03','04']) && isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] != '' &&  in_array($_REQUEST['pro_type'],[0,2])) { ?>
              <button class="btn-cancle js-cancel-order">Hủy đơn hàng</button>
              <?php } ?>
              <?php if($order['order_status'] == '01' && isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] != '' &&  in_array($_REQUEST['pro_type'],[0,2])) { ?>
              <button class="btn-agree js-accept-order">Xác nhận</button>
              <?php } ?>
              <?php if($order['order_status'] != '03' && isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] != '' &&  in_array($_REQUEST['pro_type'],[3])) { ?>
              <button class="btn-agree js-accept-order">Xác nhận đã sử dụng</button>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<footer id="footer">
  <?php $this->load->view('home/common/overlay_waiting')?>
</footer>
<script src="/templates/home/js/page_business.js"></script>

<script>
  var data = {
    order_id: <?=$order['id']?>,
    user_id: <?=$order['shop']['sho_user']?>,
    type: <?=$order['product_type']?>,
  };
  <?php if(in_array($order['order_status'], ['01','03','04'])) { ?>
  $('.js-cancel-order').click(function () {
    data.order_status = '12';
    $.ajax({
      type: "post",
      url: "<?=azibai_url("/home/api_affiliate/update_status_branch_get_order_detail")?>",
      data: data,
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert(response.msg);
        }
      },
      error: function () {
        $('.load-wrapp').hide();
        alert("Lỗi kết nối!!!");
      }
    });
  });
  <?php } ?>

  <?php if($order['order_status'] == '01' && isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] != '' &&  in_array($_REQUEST['pro_type'],[0,2])) { ?>
  $('.js-accept-order').click(function () {
    data.order_status = '04';
    $.ajax({
      type: "post",
      url: "<?=azibai_url("/home/api_affiliate/update_status_branch_get_order_detail")?>",
      data: data,
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert(response.msg);
        }
      },
      error: function () {
        $('.load-wrapp').hide();
        alert("Lỗi kết nối!!!");
      }
    });
  });
  <?php } ?>

  <?php if($order['order_status'] != '03' && isset($_REQUEST['pro_type']) && $_REQUEST['pro_type'] != '' &&  in_array($_REQUEST['pro_type'],[3])) { ?>
  $('.js-accept-order').click(function () {
    data.order_status = '03';
    $.ajax({
      type: "post",
      url: "<?=azibai_url("/home/api_affiliate/update_status_branch_get_order_detail")?>",
      data: data,
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          window.location.reload();
        } else {
          $('.load-wrapp').hide();
          alert(response.msg);
        }
      },
      error: function () {
        $('.load-wrapp').hide();
        alert("Lỗi kết nối!!!");
      }
    });
  });
  <?php } ?>


</script>