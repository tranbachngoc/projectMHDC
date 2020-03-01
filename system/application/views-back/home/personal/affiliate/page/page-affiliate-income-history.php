<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php $this->load->view('home/personal/affiliate/element/element-subtab-page-affiliate-income');?>

<div class="affiliate-content">
  <div class="affiliate-content-income affiliate-content-orders">
    <ul class="nav nav-tabs income-tabs">
      <li class="nav-item">
        <a class="nav-link <?=$_REQUEST['view'] == 'all' ? 'active' : ''?>"
          href="<?=azibai_url('/affiliate/income-history?view=all')?>"
        >Tất cả</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?=$_REQUEST['view'] == 1 ? 'active' : ''?>"
          href="<?=azibai_url('/affiliate/income-history?view=1')?>"
        >Tiền vào</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?=$_REQUEST['view'] == 2 ? 'active' : ''?>"
          href="<?=azibai_url('/affiliate/income-history?view=2')?>"
        >Tiền ra</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="income-items">
        <div class="affiliate-content-orders js-append-data">
          <?php if($data_aff['orders'] && !empty($data_aff['orders'])) {
            foreach ($data_aff['orders'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-income-history', ['item'=>$item]);
            }
          } else {
            echo 
            "<div class='item'>
              <div class='orders-code'>
                Không có dữ liệu
              </div>
            </div>";
          }?>
        </div>
      </div>
    </div>
  </div>
</div>

<?=$pagination?>