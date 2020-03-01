<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<div class="affiliate-category">
  <ul>
    <?php if($is_parent['type_affiliate'] == 1 ) {?>
    <li class="<?=$_REQUEST['type_sv'] == 1 ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/list?type_sv=1&af_id=').$current_profile['af_key']?>">azibai</a>
    </li>
    <?php } ?>
    <li class="<?=in_array($_REQUEST['type_sv'], [2,3,4,5]) ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/list?type_sv=3&af_id=').$current_profile['af_key']?>">Doanh nghiệp</a>
    </li>
  </ul>
</div>
<div class="affiliate-content">
  <?php if(in_array($_REQUEST['type_sv'], [2,3,4,5])) { ?>
  <div class="coupondisplay-listServices">
    <div class="item"><a href="<?=azibai_url("/affiliate/list?type_sv=2&af_id={$current_profile['af_key']}")?>">
      <img src="/templates/home/styles/images/svg/magiamgia.svg"><br>Mã giảm giá
    </a></div>
    <div class="item"><a href="<?=azibai_url("/affiliate/list?type_sv=4&af_id={$current_profile['af_key']}")?>">
      <img src="/templates/home/styles/images/svg/sanpham02.svg"><br>Sản phẩm
    </div>
    <div class="item"><a href="<?=azibai_url("/affiliate/list?type_sv=5&af_id={$current_profile['af_key']}")?>">
      <img src="/templates/home/styles/images/svg/dichvu02.svg"><br>Dịch vụ
    </div>
    <!-- <div class="item"><a href="javascript:void(0)">
      <img src="/templates/home/styles/images/svg/danhmuc02.svg"><br>Danh mục
    </div>
    <div class="item"><a href="javascript:void(0)">
      <img src="/templates/home/styles/images/svg/shop02.svg"><br>Shop
    </div> -->
  </div>
  <!-- <div class="coupondisplay-category">
    <a class="item" href="">Mới nhất</a>
    <a class="item" href="javascript:void(0)">Bán chạy</a>
    <a class="item filter" href="javascript:void(0)"><img src="/templates/home/styles/images/svg/filter.svg"><span class="md ml05">Bộ lọc</span></a>
  </div> -->
  <?php } ?>

  <?php if($_REQUEST['type_sv'] == 1) { ?>
  <div class="affiliate-content-coupon">
    <div class="row">
      <?php if(isset($data_aff['services']) && !empty($data_aff['services'])) {
          foreach($data_aff['services'] as $key => $item) { 
            $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
          }
      } ?>
    </div>
  </div>
  <?php } ?>

  <?php if($_REQUEST['type_sv'] == 2) { ?>
  <div class="coupondisplay-content trangcuahang-ver2">
    <div class="coupondisplay-content-item">
      <div class="tit">
        <!-- <h3 class="sub-tt one-line">Mã giảm giá</h3>
        <a href="javascript:void(0)" class="seemore">Xem tất cả</a> -->
      </div>
      <div class="detail">
        <div class="row">
          <?php if(isset($data_aff['services']) && !empty($data_aff['services'])) {
            foreach($data_aff['services'] as $key => $item) { 
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_voucher', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php if($_REQUEST['type_sv'] == 3) { //dd($data_aff['services']);?>
  <div class="coupondisplay-content trangcuahang-ver2">
    <div class="coupondisplay-content-item">
      <div class="tit">
        <h3 class="sub-tt one-line">Mã giảm giá</h3>
        <a href="<?=azibai_url("/affiliate/list?type_sv=2&af_id={$current_profile['af_key']}")?>" class="seemore">Xem tất cả</a>
      </div>
      <div class="detail">
        <div class="row">
          <?php if(isset($data_aff['services']['aListVoucher']) && !empty($data_aff['services']['aListVoucher'])) {
            foreach($data_aff['services']['aListVoucher'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_voucher', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
    <div class="coupondisplay-content-item">
      <div class="tit">
        <h3 class="sub-tt one-line">Sản phẩm</h3>
        <a href="<?=azibai_url("/affiliate/list?type_sv=4&af_id={$current_profile['af_key']}")?>" class="seemore">Xem tất cả</a>
      </div>
      <div class="detail shop-product">
        <div class="shop-product-items">
          <!-- item-page-affiliate-list-service_type_product -->
          <?php if(isset($data_aff['services']['aListProduct']) && !empty($data_aff['services']['aListProduct'])) {
            foreach($data_aff['services']['aListProduct'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_product', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
    <div class="coupondisplay-content-item">
      <div class="tit">
        <h3 class="sub-tt one-line">Dịch vụ</h3>
        <a href="<?=azibai_url("/affiliate/list?type_sv=5&af_id={$current_profile['af_key']}")?>" class="seemore">Xem tất cả</a>
      </div>
      <div class="detail shop-product">
        <div class="shop-product-items">
          <!-- item-page-affiliate-list-service_type_product -->
          <?php if(isset($data_aff['services']['aListCoupon']) && !empty($data_aff['services']['aListCoupon'])) {
            foreach($data_aff['services']['aListCoupon'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_product', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php if($_REQUEST['type_sv'] == 4) { //dd($data_aff['services']);?>
  <div class="coupondisplay-content trangcuahang-ver2">
    <div class="coupondisplay-content-item">
      <div class="tit">
        <h3 class="sub-tt one-line">Sản phẩm</h3>
        <!-- <a href="javascript:void(0)" class="seemore">Xem tất cả</a> -->
      </div>
      <div class="detail shop-product">
        <div class="shop-product-items">
          <!-- item-page-affiliate-list-service_type_product -->
          <?php if(isset($data_aff['services']) && !empty($data_aff['services'])) {
            foreach($data_aff['services'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_product', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

  <?php if($_REQUEST['type_sv'] == 5) { //dd($data_aff['services']);?>
  <div class="coupondisplay-content trangcuahang-ver2">
    <div class="coupondisplay-content-item">
      <div class="tit">
        <h3 class="sub-tt one-line">Dịch vụ</h3>
        <!-- <a href="javascript:void(0)" class="seemore">Xem tất cả</a> -->
      </div>
      <div class="detail shop-product">
        <div class="shop-product-items">
          <!-- item-page-affiliate-list-service_type_product -->
          <?php if(isset($data_aff['services']) && !empty($data_aff['services'])) {
            foreach($data_aff['services'] as $key => $item) {
              $this->load->view('home/personal/affiliate/page-item/item-page-affiliate-list-service_type_product', ['item'=>$item, 'user_infomation'=>$user_infomation], FALSE);
            }
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<?php $this->load->view('home/personal/affiliate/popup/popup-page-affiliate-list-service-setup-all');?>

<div class="modal affiliate-modal" id="copy_link">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Copy Link</h4 >
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="buttons-direct">
            <button class="btn-cancle" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?=$pagination?>

<script>
  
</script>