<div class="col-xl-5 col-md-12">
  <div class="item">
    <div class="orders-code">
      <div class="left">
        <a class="number" href="<?=azibai_url('/affiliate/order/') . $item['order_id']?>">#<?=$item['order_id']?></a>
        <div class="time"><?=date('d/m/Y H:i:s', strtotime($item['dCreated_date']))?></div>
      </div>
      <div class="right"><?=$item['iPaymentStatus'] == 1 ? "Đã thanh toán" : "Chưa thanh toán"?></div>
    </div>
    <div class="orders-detail">
      <div class="left">
        <div class="img">
          <a href="<?=azibai_url('/affiliate/order/') . $item['order_id']?>">
            <img src="<?=$item['sImage']?>" alt="">
          </a>
        </div>
        <div class="text">
          <h4 class="tt"><a href="<?=azibai_url('/affiliate/order/') . $item['order_id']?>"><?=$item['name']?></a></h4>
          <p>Bán bởi: &nbsp;
            <span class="saleby"><?=$item['sUserFullName']?></span>
          </p>
          <p>Tổng tiền: &nbsp;
            <span class="price"><?=number_format(($item['amount'] * $item['limited']), 0, ',', '.');?>
              <span class="f12">VNĐ</span>
            </span>
          </p>
          <p>Thu nhập: &nbsp;
            <span class="text-red text-bold f16"><?=number_format(($item['affiliate_price_rate'] * $item['limited']), 0, ',', '.');?>
              <span class="f14">VNĐ</span>
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>