<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-content">
  <div class="affiliate-content-income">                
    <div class="row">
      <div class="col-lg-3">
        <div class="infor-account">
          <div class="tit">Thông tin tài khoản</div>
          <div class="income-mess">
            Tổng số dư khả dụng<br>
            <span class="text-bold f20"> <?=number_format($data_aff['dashboard']['iTotalMoney'], 0, ',', '.')?> <span class="f14">VNĐ</span></span><br>
            <a href="<?=azibai_url('/affiliate/withdrawal')?>" class="btn-withdrawing">Rút tiền</a>
          </div>
          <div class="income-mess">
            Số tiền đang yêu cầu rút<br>
            <span class="text-bold f20 text-red"> <?=number_format($data_aff['dashboard']['iMoneyTransfer'], 0, ',', '.')?> </span><span class="f14">VNĐ</span>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="statistic-index">
          <div class="row">
            <div class="col-xl-4">
              <div class="item">
                <div class="tt">Tổng số lượng đơn hàng</div>
                <div class="detail">
                  <div class="number"><?=number_format($data_aff['dashboard']['iTotalOrder'], 0, ',', '.')?></div>
                  <p>đơn</p>
                  <a href="<?=azibai_url('/affiliate/order?type=0')?>" class="btn-detail">Chi tiết</a>
                </div>
              </div>
            </div>
            <div class="col-xl-4">
              <div class="item">
                <div class="tt">Tổng số lượng thành viên</div>
                <div class="detail">
                  <div class="number"><?=number_format($data_aff['dashboard']['iTotalUser'], 0, ',', '.')?></div>
                  <p>Người</p>
                  <a href="<?=azibai_url('/affiliate/user?affiliate=all')?>" class="btn-detail">Chi tiết</a>
                </div>
              </div>
            </div>
            <div class="col-xl-4">
              <div class="item">
                <div class="tt">Tổng thu nhập</div>
                <div class="detail">
                  <div class="number"><?=number_format($data_aff['dashboard']['iMoneyMonth'], 0, ',', '.')?></div>
                  <p>VND</p>
                  <a href="<?=azibai_url('/affiliate/income')?>" class="btn-detail">Chi tiết</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="gross-sales">
          <p>Tổng doanh thu</p>
          <div class="price"><?=number_format($data_aff['dashboard']['iOrderAmount'], 0, ',', '.')?><span class="f14">VND</span></div>
        </div>
      </div>
    </div>
  </div>
</div>