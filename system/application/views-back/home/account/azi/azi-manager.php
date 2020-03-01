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
                Azi-manager( giải pháp quản lý hoạt động kinh doanh )
            </h2>
            <form name = "frmAccountSendContact" method = "post">
                <div class = "bs-docs-section">
                    <div class = "bs-callout bs-callout-info" id = "callout-progress-animation-css3">
                        <h4>Giới thiệu về công cụ Azi-manager( giải pháp quản lý hoạt động kinh doanh )</h4>
                        <p>
                         Đây là những công cụ giúp bạn quản lý được nhân viên của bạn từ xa. Bạn có thể giao việc cho họ, có thể trao đổi công việc và kiểm tra được tình trạng công việc bạn đã giao cho nhân viên.
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-danger">
                        <h4 id = "callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                            Đây là những công cụ giúp bạn quản lý được nhân viên của bạn từ xa. Bạn có thể giao việc cho họ, có thể trao đổi công việc và kiểm tra được tình trạng công việc bạn đã giao cho nhân viên.
                        </p>
                    </div>
                    <div class = "bs-callout bs-callout-warning" id = "callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                        <p>
                            Bạn click vào menu <strong>Phân công công việc</strong> (Đây là một nhóm công cụ giúp bạn quản lý nhân viên).
                            <br>
                                - Để thêm một nhân viên mới thì bạn click vào : <strong>Thêm nhân viên</strong>
                            <br>
                                - Xem danh sách nhân viên thì bạn click vào : <strong>Danh sách Nhân viên</strong>
                            <br>
                                - Phân công cho Nhân viên thì bạn click vào : <strong>Phân công cho Nhân viên</strong>
                            <br>
                                - Để kiểm tra Tình trạng công việc Nhân viên thì bạn click vào : <strong>Tình trạng công việc Nhân viên</strong>
                            <br>
                                - Để kiểm tra công việc cấp trên giao thì bạn click vào: <strong>Bảng công việc từ Cấp trên</strong>

                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
