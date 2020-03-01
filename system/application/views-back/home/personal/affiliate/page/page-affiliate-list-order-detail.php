<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-content">
  <div class="affiliate-content-orders-detail">
    <p><a href="<?=azibai_url('/affiliate/order?type=0')?>"><i class="fa fa-angle-left f18 mr05" aria-hidden="true"></i>Chi tiết đơn hàng</a></p>
    <div class="detail-box">
      <div class="row">
        <div class="col-md-6">
          <div class="infor-order">
            <table class="infor-order-table">
              <tr>
                <th>Mã đơn hàng:</th>
                <td><span class="text-blue">#<?=$order['order_id']?></span></td>
              </tr>
              <tr>
                <th>Hình thức thanh toán</th>
                <td><?=$order['payment_type']?></td>
              </tr>
              <tr>
                <th>Người mua</th>
                <td><?=$order['use_fullname']?></td>
              </tr>
              <tr>
                <th>Điện thoại</th>
                <td><?=$order['use_mobile']?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?=$order['use_email']?></td>
              </tr>
              <tr>
                <th>Địa chỉ</th>
                <td><?=$order['use_address']?></td>
              </tr>
              <tr>
                <th>Bán bởi</th>
                <td><?=$order['use_seller']?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6">
          <div class="infor-order-detail">
            <div class="img"><img src="<?=$order['sImage']?>" alt=""></div>
            <div class="text">
              <h4 class="tt"><?=$order['service_name']?></h4>
              <?php if(empty($order['iDiscountPrice'])) { ?>
              <div class="price">
                <p class="price-after">Giá gốc:&nbsp;<span><?=number_format($order['iPrice'], 0, ',', '.')?> VNĐ</span></p>
              </div>
              <?php } else { ?>
              <div class="price">
                <p class="price-before">Giá gốc:&nbsp;<span><?=number_format($order['iPrice'], 0, ',', '.')?> VNĐ</span></p>
                <p class="price-after">Giá giảm:&nbsp;<span><?=number_format($order['iDiscountPrice'], 0, ',', '.')?> VNĐ</span></p>
              </div>
              <?php } ?>
              <p>Số lượng:&nbsp;<span class="f16"><?=$order['limited']?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>