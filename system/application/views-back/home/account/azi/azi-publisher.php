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
                Azi- Publisher ( Làm Cộng tác viên Online )
            </h2>
            <form name = "frmAccountSendContact" method = "post">
                <div class = "bs-docs-section">
                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                        <h4>Giới thiệu về Azi- Publisher( Làm Cộng tác viên Online )</h4>
                        <p>
                            Affiliate là một chương trình tiếp thị, nơi bạn có thể trả tiền hoa hồng để người khác bán hàng cho bạn.
                            Bạn sẽ cung cấp cho họ tất cả các công cụ quảng cáo mà họ cần chẳng hạn như banner, liên kết và mã theo dõi để họ đặt trên các trang web của họ, trong email của họ hoặc các nguồn khác.
                            Nếu kết quả giao dịch này bán được hàng cho bạn, bạn sẽ phải trả một khoản tiền hoa hồng mà bạn đã quy định trước!
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-danger">
                        <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                          Tính năng này giúp bạn tạo ra một mạng lưới bán hàng rộng rãi mà bạn không phải tốn tiền thuê nhân viên bán hàng. Bạn sẽ tiết kiệm được rất nhiều chi phí để sản phẩm của bạn có giá cạnh tranh và hiệu quả bán hàng cũng rất tốt!
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                        <p>Bạn có thể đăng ký thêm 1 tài khoản Affiliate để mở rộng hoạt động kinh doanh!
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
