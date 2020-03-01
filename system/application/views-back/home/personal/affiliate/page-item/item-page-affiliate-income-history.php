<div class="item">
  <div class="orders-code">
    <div class="left">
      <a class="number" href="javascript:void(0)"># <?=$item['money_id']?></a>
      <div class="time"><?=$item['created_date']?></div>
    </div>
    <div class="right completed"><?=$item['status']?></div>
  </div>
  <div class="orders-detail">
    <div class="left">
      <p class="f16">Chuyển tiền từ đơn hàng
        <a class="text-blue" href="<?=azibai_url('/affiliate/order/').$item['order_id']?>">#<?=$item['order_id']?></a>
      </p>
    </div>
    <div class="right">
      <p>
        <span class="text-red text-bold f16"><?=number_format($item['amount'], 0, ',', '.')?>
          <span class="f14">VNĐ</span>
        </span>
      </p>
    </div>
  </div>
</div>