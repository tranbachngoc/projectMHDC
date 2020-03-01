<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php $this->load->view('home/personal/affiliate/element/element-subtab-page-affiliate-income');?>

<div class="affiliate-content">
  <div class="affiliate-content-income">
    <div class="row">
      <div class="col-lg-3">
        <div class="infor-account">
          <div class="tit">Thông tin tài khoản</div>
          <div class="income-mess">
            Tổng số dư khả dụng<br>
            <span class="text-bold f20"> <?=number_format($data_aff['iTotalMoney'], 0, ',', '.');?> <span class="f14">VNĐ</span></span><br>
            <a href="<?=azibai_url('/affiliate/withdrawal')?>" class="btn-withdrawing">Rút tiền</a>
          </div>
          <div class="income-mess">
            Số tiền đang yêu cầu rút<br>
            <span class="text-bold f20 text-red"> <?=number_format($data_aff['iMoneyTransfer'], 0, ',', '.');?> </span><span class="f14">VNĐ</span>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <p class="text-bold mb10">Thu nhập từ</p>
        <div class="affiliate-content-orders js-append-data">
          <?php if(isset($data_aff['aListOrder']) && !empty($data_aff['aListOrder'])) {
            foreach ($data_aff['aListOrder'] as $key => $income) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-income', ['item'=>$income]);
            }
          } else {
            echo 
            "<div class='item'>
              <div class='orders-code'>
                Chưa có dữ liệu
              </div>
            </div>";
          }?>
        </div>
      </div>
    </div>
  </div>
</div>

<?=$pagination?>