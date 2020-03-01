<?php $this->load->view('home/common/header'); ?>
<style>
    /*  .step a{*/
    /*    background: url("*/
    <?php //echo base_url(); ?> /*templates/home/images/discovery/bg-Prite-home.png")  no-repeat;*/
    /*  }*/
    .fixed {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        min-height: 65px;
        padding: 10px 0;
        background-color: #353535;
        box-shadow: 0px 2px 10px 0px rgba(97, 92, 97, 0.5);
        z-index: 999;
    }

    #popup_mod .col-lg-4 .item-tpl {
        border: solid 3px transparent;
        padding: 5px;
        margin-bottom: 15px;
    }

    #popup_mod .col-lg-4.active .item-tpl, #popup_mod .col-lg-4:hover .item-tpl {
        border-color: #006633;
    }
</style>
<script>
    //  $(window).scroll(function(){
    //    var sticky = $('.txt-btn'),
    //        scroll = $(window).scrollTop();
    //    if (scroll >= 100) sticky.addClass('fixed');
    //    else sticky.removeClass('fixed')
    //  });
</script>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
            <div class="box1">
                <div class="txt-btn"><a href="#" class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i
                            class="fa fa-shopping-basket"></i> Mở shop ngay</a></div>
                <div class="col-sm-12 col-xs-12">
                    <h3>Azibai.com là tất cả những gì bạn cần để bán hàng</h3>
                </div>
                <div class="col-lg-3">
                    <a href="#Modal01" data-toggle="modal"><img
                            src="<?php echo base_url(); ?>templates/home/images/discovery/img-1.png" width="100%"
                            border="0"/>
                    </a>

                </div>
                <div id="Modal01" class="modal fade in" style="padding-left: 0px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Giải pháp quản lý thông tin</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/Boo3bLi7QT8?list=PLaUbMsdTLfdwuUX5aQJGtcY2I5YtfaAi2"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <a href="#Modal02" data-toggle="modal"><img
                            src="<?php echo base_url(); ?>templates/home/images/discovery/img-2.png" width="100%"
                            border="0"/></a>

                </div>
                <div id="Modal02" class="modal fade in" style="padding-left: 0px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Giải pháp tiếp thị - marketing</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/mH4OkXNwbHI?list=PLaUbMsdTLfdwuUX5aQJGtcY2I5YtfaAi2"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <a href="#Modal03" data-toggle="modal"><img
                            src="<?php echo base_url(); ?>templates/home/images/discovery/img-3.png" width="100%"
                            border="0"/></a>

                </div>
                <div id="Modal03" class="modal fade in" style="padding-left: 0px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Giải pháp bán hàng</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/4PR8zwPRNJM?list=PLaUbMsdTLfdwuUX5aQJGtcY2I5YtfaAi2"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <a href="#Modal04" data-toggle="modal"><img
                            src="<?php echo base_url(); ?>templates/home/images/discovery/img-4.png" width="100%"
                            border="0"/></a>

                </div>
                <div id="Modal04" class="modal fade in" style="padding-left: 0px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Giải pháp quản lý hoạt động kinh doanh</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/8T-BZ73H4UA?list=PLaUbMsdTLfdwuUX5aQJGtcY2I5YtfaAi2"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- bat dau cac muc tieu -->

            <div class="row ">
                <div class="text-center title-target col-sm-12 col-xs-12">
                    <h3>Azibai giúp doanh nghiệp của bạn đạt được các mục tiêu</h3>
                    <hr/>
                </div>
                <div class="text-center">
                    <!-- Feature Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6 feature-item wow animated fadeInUp animated"
                         data-wow-delay=".5s"
                         style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                        <img class="imageicon"
                             src="<?php echo base_url() ?>templates/home/images/register/icon-mt-5.png">
                        <p class="feature-item-title margin-top">Tăng doanh thu</p>
                    </div>
                    <!-- End Feature Item -->

                    <!-- Feature Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6 feature-item wow animated fadeInUp animated"
                         data-wow-delay=".75s"
                         style="visibility: visible; animation-delay: 0.75s; animation-name: fadeInUp;">
                        <img class="imageicon"
                             src="<?php echo base_url() ?>templates/home/images/register/icon-mt-6.png">
                        <p class="feature-item-title margin-top">Giảm chi phí</p>
                    </div>
                    <!-- End Feature Item -->

                    <!-- Feature Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6 feature-item wow animated fadeInUp animated"
                         data-wow-delay="1s"
                         style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                        <img class="imageicon"
                             src="<?php echo base_url() ?>templates/home/images/register/icon-mt-7.png">
                        <p class="feature-item-title margin-top">Tăng lợi nhuận</p>
                    </div>
                    <!-- End Feature Item -->
                    <!-- Feature Item -->
                    <div class="col-md-3 col-sm-6 col-xs-6 feature-item wow animated fadeInUp animated"
                         data-wow-delay="1s"
                         style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                        <img class="imageicon"
                             src="<?php echo base_url() ?>templates/home/images/register/icon-mt-8.png">
                        <p class="feature-item-title margin-top">Tăng thị phần, thương hiệu</p>
                    </div>
                    <!-- End Feature Item -->
                </div>
            </div>
            <!-- ket thuc cac muc tieu -->
            <!--bat dau chien luoc tang doanh thu-->

            <div id="box-db" class="row">
                <div class="col-sm-12 text-center col-sm-12 col-xs-12"><h3>CHIẾN LƯỢC TĂNG DOANH THU</h3></div>
                <!-- </div>
                <div class="row"> -->

                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-1.png"
                                           alt="">
                    <a href="#Modal1" data-toggle="modal" title="">Mở thêm cơ sở chi nhánh kinh doanh trực tuyến</a>
                </div>

                <div id="Modal1" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Mở thêm cơ sở chi nhánh kinh doanh trực tuyến</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/ky1aQoQN0yE?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-2.png"
                                           alt="">
                    <a href="#Modal2" data-toggle="modal" title="">Tăng doanh thu bình quân của hệ thống cộng tác viên
                        online</a></div>
                <div id="Modal2" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tăng doanh thu bình quân của hệ thống cộng tác viên online</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/qRuYAWtTUzk?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-3.png"
                                           alt="">
                    <a href="#Modal3" data-toggle="modal" title="">Xây dựng đội ngũ nhân viên kinh doanh không trả
                        lương</a></div>

                <div id="Modal3" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Xây dựng đội ngũ nhân viên kinh doanh không trả lương</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/Q4dSrvd9bxU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-4.png"
                                           alt="">
                    <a href="#Modal4" data-toggle="modal" title="">Tăng doanh thu bình quân của nhân viên kinh doanh
                        hiện có</a></div>
                <div id="Modal4" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tăng doanh thu bình quân của nhân viên kinh doanh hiện có</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/bMriCQJrPUU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-5.png"
                                           alt="">
                    <a href="#Modal5" data-toggle="modal" title="">Tạo ra thêm được kênh kinh doanh mới</a></div>
                <div id="Modal5" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Tạo ra thêm được kênh kinh doanh mới</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/3qTw7rNYtug?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-6.png"
                                           alt="">
                    <a href="#Modal6" data-toggle="modal" title="">Giữ khách hàng cũ. Nâng cao chất lượng chăm sóc khách
                        hàng</a></div>
                <div id="Modal6" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Giữ khách hàng cũ. Nâng cao chất lượng chăm sóc khách hàng</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/wcuRxC9e1BA?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-7.png"
                                           alt="">
                    <a href="#Modal7" data-toggle="modal" title="">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người tiêu
                        dùng</a></div>

                <div id="Modal7" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người tiêu dùng</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/00pZdj7KCfU?list=PLaUbMsdTLfdwI7Wa7OmhQlvcNp6mD8KHA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"><img class="fa_border"
                                           src="<?php echo base_url() ?>templates/home/images/register/icon-8.png"
                                           alt="">
                    <a href="#Modal8" data-toggle="modal" title="">Tính khả thi cao</a></div>
                <div id="Modal8" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Đa dạng hóa sản phẩm. Tiếp cận gần hơn đến người tiêu dùng</h4>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="315"
                                        src="https://www.youtube.com/embed/yt8M8nyV428?list=PLaUbMsdTLfdx90ihpfyFkKrnv1N32c9DA"
                                        frameborder="0" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--ket thuc chien luoc tang doanh thu-->
            <!-- Chiến luực giảm chi phí -->
            <div id="box-db-2" class="row">
                <div class="col-md-12"><h2 class="text-center">Chiến lược giảm chi phí tăng lợi nhuận</h2></div>
                <hr>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12 text-center mg-6">
                            <img class="text-center"
                                 src="<?php echo base_url() ?>templates/home/images/register/icon-4-2.png">
                            <p> Cắt giảm tiết kiệm tối đa chi phí nhân sự kinh doanh</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center mg-6">
                            <img class="text-center"
                                 src="<?php echo base_url() ?>templates/home/images/register/icon-8.png">
                            <p>Tăng doanh thu bình quân của nhân viên kinh doanh hiện có</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12 text-center mg-6">
                            <img class="text-center"
                                 src="<?php echo base_url() ?>templates/home/images/register/icon-4-3.png">
                            <p> Cắt giảm tiết kiệm tối đa chi phí mặt bằng kinh doanh</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center mg-6">
                            <img class="text-center"
                                 src="<?php echo base_url() ?>templates/home/images/register/icon-4-4.png">
                            <p> Giảm chi phí giá vốn hàng mua đầu vào, tăng được giá bán hàng đầu ra</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ket thuc Chiến lược giảm chi phí -->
            <div class="row steps-shop">
                <div class="col-md-12"><h2>Mở Shop trong 4 bước đơn giản</h2>
                    <hr>
                </div>
                <div class="col-lg-3 step step1">
                    <img src="<?php echo base_url(); ?>images/icon-72/1_07.gif" alt="">
                    <p class="txt-title">Đăng ký</p>
                </div>
                <div class="col-lg-3 step step2">
                    <img src="<?php echo base_url(); ?>images/icon-72/1_08.gif" alt="">
                    <p class="txt-title">Nhập thông tin</p>
                </div>
                <div class="col-lg-3 step step3">
                    <img src="<?php echo base_url(); ?>images/icon-72/1_09.gif" alt="">
                    <p class="txt-title">Kích hoạt shop</p>
                </div>
                <div class="col-lg-3 step step4">
                    <img src="<?php echo base_url(); ?>images/icon-72/1_10.gif" alt="">
                    <p class="txt-title">Đăng sản phẩm</p>
                </div>
            </div>
            <?php /*
    <div class="steps-sale-online">
      <h2 class="text-center">Các bước bán hàng Online thật dễ dàng</h2>
        <div class="col-lg-4 text-center">
          <img src="<?php echo base_url(); ?>templates/home/images/discovery/open-shop.gif" width="100%" alt="Mở shop">
          <p>Mở shop</p>
        </div>
        <div class="col-lg-4 text-center">
          <img src="<?php echo base_url(); ?>templates/home/images/discovery/order.gif" width="100%" alt="Quản lý Sản phẩm
">
          <p>Quản lý Sản phẩm</p>
        </div>
        <div class="col-lg-4 text-center">
          <img src="<?php echo base_url(); ?>templates/home/images/discovery/delivery.gif" width="100%" alt="Giao hàng  &amp; Nhận tiền
">
          <p>Giao hàng  &amp; Nhận tiền</p>
        </div>
    </div>

    <div class="des-buying">
      <h2 class="text-center">Giải pháp bán hàng toàn diện</h2>
      <div class="col-lg-6 text-right">Hoàn toàn chủ động quản lí sản phẩm  <img src="<?php echo base_url();?>images/icon-72/1_24.gif" alt=""></div>
      <div class="col-lg-6"><img src="<?php echo base_url();?>images/icon-72/1_26.gif" alt=""> Cung cấp dịch vụ vận chuyển thanh toán từ A-Z</div>
      <div class="col-lg-6 text-right">Bảo vệ hàng hóa tiền  của bạn  <img src="<?php echo base_url();?>images/icon-72/1_25.gif" alt=""></div>
      <div class="col-lg-6"><img src="<?php echo base_url();?>images/icon-72/1_29.gif" alt=""> Trung tâm Chăm sóc Khách hàng luôn sẵn sàng khi bạn cần</div>
    </div>
 */ ?>
            <div class="col-sm-12 text-center">
                <div class="txt-btn"><a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#myModal"><i class="fa fa-shopping-basket"></i> Mở shop ngay</a>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg  mCustomScrollbar" data-mcs-theme="minimal-dark">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                        class="fa fa-times-circle text-danger"></i></button>
                                Mở shop với Azibai
                            </h2>
                        </div>
                        <div id="popup_mod" class="modal-body">
                            <p>Bạn được tặng và sở hữu website trên Azibai! Hãy bắt đầu công việc kinh doanh của mình
                                tại Azibai! Chúc bạn thành công!</p>
                            <p><b>Lưu ý:</b> bạn cần chỉnh sửa thông tin và post mặt hàng của mình chính xác để tăng uy
                                tin cho gian hàng của bạn. Nếu thông tin không chỉnh sửa, sau 1 tháng chúng tôi sẽ tự
                                động xóa trang web này.</p>
                            <div class="title-template"><b>Chọn Template gian hàng và click vào nút "Mở shop ngay" phía
                                    dưới</b></div>
                            <?php for ($i = 0; $i < 5; $i++) {
                                if ($i == 0) {
                                }
                                ?>
                                <div class="col-lg-4">
                                    <div class="item-tpl"
                                         onclick=" jQuery('input.style_id').prop('checked', false); jQuery(this).find('input').prop('checked', true);">
                                        <div class="tpl-img"><a href="#"><img width="100%"
                                                                              src="<?php echo base_url(); ?>templates/home/images/templates/<?php if ($i == 0) {
                                                                                  echo 'default';
                                                                              } else {
                                                                                  echo 'style' . $i;
                                                                              } ?>.png"/></a></div>
                                        <div class="checkbox">
                                            <div class="col-lg-7 col-xs-7"><label><input id="style_<?php echo $i; ?>"
                                                                                         name="template" type="checkbox"
                                                                                         class="style_id"
                                                                                         value="<?php if ($i == 0) {
                                                                                             echo 'default';
                                                                                         } else {
                                                                                             echo $i;
                                                                                         } ?>"/>
                                                    <?php if ($i == 0) echo "Gian hàng 1";
                                                    if ($i == 1) echo "Gian hàng 2";
                                                    if ($i == 2) echo "Giải trí";
                                                    if ($i == 3) echo "Nhà hàng";
                                                    if ($i == 4) echo "Khách sạn";
                                                    ?></label></div>
                                            <div class="col-lg-1 col-xs-1"><a target="_blank" title="Xem demo"
                                                                              href="<?php echo base_url(); ?>shoponline?style=<?php echo $i; ?>"><i
                                                        class="fa fa-eye"></i></a></div>
                                            <div class="col-lg-1 col-xs-1"></div>
                                            <div class="col-lg-1 col-xs-1"><a href="#" title="Xem hình ảnh lớn"
                                                                              data-toggle="modal"
                                                                              data-target="#myImg<?php echo $i; ?>"><i
                                                        class="fa fa-search-plus"></i></a></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="modal-footer" style="clear:both">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button type="button" class="btn btn-azibai btn-lg btn-block"
                                            onclick="registerStore('<?php echo base_url(); ?>');">MỞ SHOP NGAY
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--   Modal Imager-->
                <?php for ($i = 0; $i < 5; $i++) { ?>
                    <div id="myImg<?php echo $i; ?>" class="modal fade modal_chil" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close_chil"><i
                                            class="fa fa-times-circle text-danger"></i></button>
                                    <div class="checkbox"><h3><label>
                                                <?php if ($i == 0) echo "Gian hàng 1";
                                                if ($i == 1) echo "Gian hàng 2";
                                                if ($i == 2) echo "Nhà hàng";
                                                if ($i == 3) echo "Khách sạn";
                                                if ($i == 4) echo "Giải trí";

                                                ?></label></h3></div>
                                </div>
                                <div class="modal-body">
                                    <img
                                        src="<?php echo base_url(); ?>templates/home/images/templates/<?php if ($i == 0) {
                                            echo 'default';
                                        } else {
                                            echo 'style' . $i;
                                        } ?>.png" width="100%" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!--    End Modal Imager-->
            </div>

        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
