<div class="modal fade" id="js-modal-shortcut-menu-shop">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="show-more-detail js-popup-mess">
        <ul class="show-more-detail">
          <a href="<?=azibai_url("/product/add/{$this->session->userData('sessionUser')}")?>" target="_blank"><li>Đăng sản phẩm</li></a>
          <a href="<?=azibai_url("/page-business/create-voucher/{$this->session->userData('sessionUser')}?step=1")?>" target="_blank"><li>Tạo mã giảm giá</li></a>
          <a href="<?=azibai_url("/account/user_order/product")?>" target="_blank"><li>Quản lý đơn hàng</li></a>
          <!-- <a href="" target="_blank"><li>Thống kê</li></a> -->
          <a href="<?=azibai_url("/page-business/listaffiliate?affiliate=all")?>" target="_blank"><li>Quản lý cộng tác viên</li></a>
        </div>
      </div>
    </div>
  </div>
</div>