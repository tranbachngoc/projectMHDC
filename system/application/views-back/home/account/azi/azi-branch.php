<?php $this->load->view('home/common/header'); ?>
<div class = "container">
    <div class = "row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <SCRIPT TYPE = "text/javascript">
            function SearchContact(baseUrl) {
                product_name = '';
                if (document.getElementById('keyword_account').value != '')
                    product_name = document.getElementById('keyword_account').value;
                window.location = baseUrl + 'account/contact/search/title/keyword/' + product_name + '/';
            }
        </SCRIPT>
        <div class = "col-lg-9 col-md-9 col-sm-8 col-xs-12 db_table">
            <h2 class="page-title text-uppercase">
                Azi-Branch ( Mở chi nhánh trực tuyến)
            </h2>
            <form name = "frmAccountSendContact" method = "post">
                <div class = "bs-docs-section">
                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                        <h4>Giới thiệu về Azi-Branch (Mở chi nhánh trực tuyến)</h4>
                        <p>Mở chi nhánh trức tuyến là chức năng cho phép bạn mở rộng thêm phạm vi kinh doanh của mình(Tùy vào gói dịch vụ bạn mua mà bạn có thể được phép mở chi nhánh trong khu vực đó)
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-danger">
                        <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                          Đây là tính năng rất tiện lợi và hữu ích, bạn có thể mở chi nhánh ở bất kỳ nơi đâu bạn muốn với chỉ vài cú click chuột.
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                        <p>
                            Bạn hãy click vào menu <strong>Gian hàng</strong> -> vào tiếp <strong>Cập nhật gian hàng</strong> và bạn tìm đến dòng <strong>Azi-Branch - Mở chi nhánh trực tuyến</strong>.
                            Ở đây chúng tôi đã liệt kê ra những tỉnh thành mà bạn được phép mở chi nhánh. Bạn hãy chọn những tỉnh thành mà bạn muốn mở hoặc chọn hết.
                            Sau đó bạn chỉ cần lưu lại là shop của bạn đã có chi nhánh ở những tỉnh thành mà bạn đã chọn.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
