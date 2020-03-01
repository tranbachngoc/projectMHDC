<?php $this->load->view('home/common/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <div class="col-md-9 col-sm-8 col-xs-12">
                <h4 class="page-header" style="margin-top:10px;text-transform: uppercase;">Hủy tài khoản cộng tác viên của tôi</h4>
                <p class="">Bạn có chắc chắn muốn hủy tài khoản cộng tác viên này không? <br/>Tác vụ này <b>không thể hoàn tác</b> vì vậy nếu đã chắc chắn thì check vào ô "Chắc chắn xóa tài khoản" và click nút xóa.
                    <br/>Sau khi tài khoản của bạn được xóa thành công trang sẽ chuyển hướng về trang chủ <?php echo domain_site ?></p>
                <form method="POST" action="/account/delete">
                    <div class="col-sm-3">
                        <label style="font-weight: 100 !important;"><input type="checkbox" name="dongy" value="1"> Chắc chắn xóa tài khoản</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" name="btn_unactive" value="Xóa tài khoản" class="btn btn-primary btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--END LEFT-->

<?php $this->load->view('home/common/footer'); ?>