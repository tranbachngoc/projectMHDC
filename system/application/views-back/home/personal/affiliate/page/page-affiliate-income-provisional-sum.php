<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php $this->load->view('home/personal/affiliate/element/element-subtab-page-affiliate-income');?>

<div class="affiliate-content">
  <div class="affiliate-content-income affiliate-content-orders">
    <div class="income-mess">Tổng số dư tạm tính:&nbsp;
      <span class="text-bold f16 text-red"> <?=$data_aff['iAmount'] > 0 ? number_format($data_aff['iAmount'], 0, ',', '.') : 0?> VNĐ</span>
    </div>
    <div class="affiliate-content-orders js-append-data">
      <?php foreach ($data_aff['aListOrder'] as $key => $item) {
        $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-income-provisional-sum', ['item'=>$item]);
      } ?>
    </div>
  </div>
</div>

<?=$pagination?>