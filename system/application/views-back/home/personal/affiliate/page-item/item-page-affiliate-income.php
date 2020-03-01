<div class="item">
  <div class="orders-code">
    <div class="left">
      <a class="number" href="<?=azibai_url('/affiliate/order/').$item['order_id']?>">#<?=$item['order_id']?></a>
      <div class="time"><?=$item['created_date']?></div>
    </div>
    <div class="right"><?=$item['sPaymentStatus']?></div>
  </div>
  <div class="orders-detail">
    <div class="left">
      <div class="img">
        <a class="number" href="<?=azibai_url('/affiliate/order/').$item['order_id']?>">
          <img src="/templates/home/styles/images/svg/bg_dichvu.png" alt="">
        </a>
      </div>
      <div class="text">
        <h4 class="tt"><?=$item['name']?></h4>
        <p>Bán bởi: &nbsp;
          <span class="saleby"><?=$item['user_seller']?></span>
        </p>
        <p>Tổng tiền: &nbsp;
          <span class="price"><?=number_format($item['amount'], 0, ',', '.');?>
            <span class="f12">VNĐ</span>
          </span>
        </p>
        <p class="sm">Thu nhập: &nbsp;
          <span class="text-red text-bold f16"><?=number_format($item['income'], 0, ',', '.');?>
            <span class="f14">VNĐ</span>
          </span>
        </p>
      </div>
    </div>
    <div class="right md">
      <p>Thu nhập: &nbsp;
        <span class="text-red text-bold f16"><?=number_format($item['income'], 0, ',', '.');?>
          <span class="f14">VNĐ</span>
        </span>
      </p>
    </div>
  </div>
</div>