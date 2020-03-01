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
                Azi- Cộng tác viên online
            </h2>
            <form name = "frmAccountSendContact" method = "post">
                <div class = "bs-docs-section">
                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                        <h4>Giới thiệu về Cộng tác viên online</h4>
                        <p>
                            Cộng tác viên online là một chương trình tiếp thị, nơi bạn có thể nhận được tiền hoa hồng từ một gian hàng bằng cách bán hàng cho họ.
                            Gian hàng sẽ cung cấp cho bạn tất cả các công cụ quảng cáo mà bạn cần chẳng hạn như banner, liên kết và mã theo dõi để bạn đặt trên các trang web của mình, trong email của bạn hoặc các nguồn khác.
                            Khi một người truy cập vào trang web của bạn hoặc nhấp chuột vào một trong các quảng cáo, liên kết và đến trang web của gian hàng để tiến hành giao dịch, giao dịch này sẽ được theo dõi.
                            Nếu kết quả giao dịch này bán được hàng cho gian hàng, bạn được trả một khoản tiền hoa hồng quy định trước. Thật đơn giản!
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-danger">
                        <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                            Cộng tác viên online là một chương trình tiếp thị, nơi bạn có thể nhận được tiền hoa hồng từ một gian hàng bằng cách bán hàng cho họ.
                            Gian hàng sẽ cung cấp cho bạn tất cả các công cụ quảng cáo mà bạn cần chẳng hạn như banner, liên kết và mã theo dõi để bạn đặt trên các trang web của mình, trong email của bạn hoặc các nguồn khác.
                            Khi một người truy cập vào trang web của bạn hoặc nhấp chuột vào một trong các quảng cáo, liên kết và đến trang web của gian hàng để tiến hành giao dịch, giao dịch này sẽ được theo dõi.
                            Nếu kết quả giao dịch này bán được hàng cho gian hàng, bạn được trả một khoản tiền hoa hồng quy định trước. Thật đơn giản!
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                        <p>Bạn hãy click vào menu <strong>Cộng tác viên online</strong> -> <strong>Giới thiệu mở Cộng tác viên online</strong>. Bạn sẽ nhận được 1 đường link để giới thiệu mở Cộng tác viên online cho gian hàng.
                            Bạn chỉ cần click vào nút <strong>Coppy link</strong> và chia sẽ cho những ai mà bạn muốn!
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
