<?php $this->load->view('home/common/header'); ?>
<div class = "container">
    <div class = "row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->

        <div class = "col-lg-9 col-md-9 col-sm-8 col-xs-12 db_table">
            <h2 class="page-title text-uppercase">
                Email Marketing ( Công cụ chăm sóc khách hàng qua Email)
            </h2>
            <form name = "frmAccountSendContact" method = "post">
                <div class = "bs-docs-section">
                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                        <h4>Giới thiệu về Email Marketing</h4>
                        <p>Email marketing, một kênh bán hàng, chăm sóc khách hàng hiệu quả.
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-danger">
                        <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                          Đang cập nhật
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                        <p>
                            Bạn hãy click vào link <a class="text-primary" href="http://emailapp.azibai.com" target="_blank">Azibai Email Markeing</a> để đăng nhập vào công cụ Email marketing và sử dụng những tính năng tuyệt vời của Email Marketing Azibai.
                        </p>

                        <a href="http://emailapp.azibai.com" target="_blank"><button type="button" class="btn btn-default1">Truy cập Azibai Email Markeing</button></a>
                        <a href="<?php echo base_url();?>account/tool-marketing/access-email-marketing" target="_blank"><button type="button" class="btn btn-default1">Tạo thành viên</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
