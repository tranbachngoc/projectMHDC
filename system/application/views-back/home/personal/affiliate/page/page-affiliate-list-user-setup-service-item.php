<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>
<?php
$back_link = !empty($_REQUEST['href']) ? $_REQUEST['href'] : azibai_url('/affiliate/user?affiliate=0');
?>
<p class="f16 mb20 mt20">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left f18 mr05" aria-hidden="true"></i> Cấu hình hoa hồng cho <?=$_REQUEST['name']?></a>
</p>

<div class="affiliate-category">
  <ul>
    <li class="<?=$_REQUEST['type_sv'] == 1 ? 'active' : ''?>">
      <a href="<?=azibai_url("/affiliate/user/{$id}?type_sv=1&href={$back_link}&af_id=").$current_profile['af_key']?>">azibai</a>
    </li>
    <li class="<?=$_REQUEST['type_sv'] == 2 ? 'active' : ''?>">
      <a href="<?=azibai_url("/affiliate/user/{$id}?type_sv=2&href={$back_link}&af_id=").$current_profile['af_key']?>">Doanh nghiệp</a>
    </li>
  </ul>
</div>

<div class="affiliate-content">
  <div class="affiliate-content-orders affiliate-content-orders-setting">
    <?php foreach ($data_aff['services'] as $key => $service) {
      $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-user-setup-service-item', ['item'=>$service, 'id'=>$id], FALSE);
    } ?>
  </div>
</div>

<?=$pagination?>

<?php $this->load->view('home/personal/affiliate/popup/popup-page-affiliate-list-user-setup-service-item');?>