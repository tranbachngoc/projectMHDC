<?php
$this->load->view('home/common/header_new');
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
?>
<link rel="stylesheet" href="/templates/home/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/templates/home/styles/css/coupon.css" rel="stylesheet" type="text/css">
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="/templates/home/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>



<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>  
<script src="/templates/home/styles/js/countdown.js"></script>
<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/styles/js/fixed_sidebar.js"></script>
<style type="text/css">
  .error_all_data {display: none; color: red}
  .thongso {
      padding-top: 0 !important;
  }
  .thongso .title {
      font-weight: bold;
      font-size: 16px;
      display: flex;
      align-items: center;
      padding-top: 7px;
  }
  .pro-qc-content {
      padding-top: 10px;
  }
</style>

<main class="sanphamchitiet add_product">      
    <section class="main-content">
      <div class="container">
          <div class="sanphamchitiet-content">
            <div class="col-md-5">
              <div class="sanphamchitiet-content-gallery">
                <div class="show-photo">
                  <div class="show-photo-nav">
              <ul id="gallery_01" class="slider gallery_01">
                <li class="">
                  <a class="is-active" href="#">
                    <img src="/templates/home/styles/images/default/error_image_400x400.jpg" />
                  </a>
                </li>
                <li>
                  <a class="" href="#">
                    <img src="/templates/home/styles/images/default/error_image_400x400.jpg" />
                  </a>
                </li>
                <li>
                  <a class="" href="#">
                    <img src="/templates/home/styles/images/default/error_image_400x400.jpg" />
                  </a>
                </li>
                <li>
                  <a class="" href="#">
                    <img src="/templates/home/styles/images/default/error_image_400x400.jpg" />
                  </a>
                </li>
              </ul>
              <div class="btn-video-img">
                <p class="video-img video">
                  <img src="/templates/home/styles/images/svg/pause.svg" alt=""><br>
                  <label class="sm">Video</label>
                </p>
                <p class="video-img video gallery_add_product">
                  <a href="#">
                    <img src="/templates/home/styles/images/svg/thuvienanh.svg" class="" alt="">
                    <label class="sm">Thư viện ảnh</label>
                  </a>
                </p>
              </div>

                  </div>
                  <div class="show-photo-main">
                    <img id="zoom_03" src="/templates/home/styles/images/default/error_image_400x400.jpg" alt="">
                    <div class="popup-image-list hover-add">
                      <img  src="/templates/home/styles/images/svg/add_circle.svg" alt="">
                    </div>
                  </div>
                </div>
                <div class="show-info-product">
                  <div class="action">
                    <div class="action-left show-number-action">
                      <ul class="action-left-listaction">
                        <li class="like">
                          <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like">
                        </li>
                        <li class="comment">
                          <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                        </li>
                        <li class="share">
                          <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                        </li>
                      </ul>
                    </div>
                    <div class="action-right">
                      <ul>
                        <li>
                          <img class="icon-img" src="/templates/home/styles/images/svg/bookmark.svg" alt="bookmark">
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- <div class="show-number-action">
                    <ul>
                      <li>43<p class="md"> lượt thích</p></li>
                      <li>15<p class="md"> bình luận</p></li>
                      <li>5<p class="md"> chia sẻ</p></li>
                    </ul>
                  </div> -->

                </div>
              </div>
            </div>
            <div class="col-md-7">
                <div class="sanphamchitiet-content-detail">
            <div style="text-align: right;">
              <button type="button" class="update-product btn btn-success">Lưu <?php echo $result->text; ?></button>
            </div>
                  <!-- thông tin chung -->
                  <div class="thong-tin-chung">
                    <div class="error_all_data">Bạn vui lòng nhập đầy đủ thông tin (*)</div>
                      <div class="button-chinh-sua modal-pro-basic">
                        <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                      </div>
                      <?php
                      if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale >= time() && $product->begin_date_sale <= time())  {
                        ?> 
                      <div class="flash-sale product-detail"><img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt=""><span class="time-flash-sale" id="flash-sale_0">
                        <script>cd_time(<?php echo $product->end_date_sale * 1000 ; ?>,0);</script>
                      </span></div>
                      <?php } ?>
                      <h3 class="tit style-no-value">Áo thun màu T23456 - Hàng Chính Hãng</h3>
                      <p class="small-text style-no-value">
                        <span>Thương hiệu: no brand</span>
                        <span>Mã <?php echo $result->text ?>: R6543156</span>
                      </p>
                      <ul class="list-number">
                        <li class="style-no-value">
                          <img src="/templates/home/styles/images/svg/gioxach.svg" width="11" alt="">23
                        </li>
                        <li class="style-no-value">
                          <img src="/templates/home/styles/images/svg/eyes.svg" width="15" alt="">1092
                        </li>
                        <li class="style-no-value">
                          <img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt="">
                          <span class="baocao">Báo cáo</span>
                        </li>
                      </ul>
                      <div class="price style-no-value">
                        <div class="no-sale">
                          <strong class="dong">đ</strong>
                          <span>1.000.000</span>
                        </div>
                        <div class="sale">
                          <strong class="dong">đ</strong>850.000
                        </div>
                        <p>Bộ</p>
                      </div>
                      <div class="style-no-value">
                        <div class="gia-uu-dai" data-toggle="modal" data-target="#muasi">
                          <img src="/templates/home/styles/images/svg/dola_den.svg" class="mr10" alt="">
                            Giá ưu đãi khi mua số lượng
                        </div>
                      </div>
                  </div>
                  <!-- end thông tin chung -->

                  <!-- CTV -->
                  <?php
                  if( !empty($checkPackageAff))
                  {
                  ?>
                  <div class="thongso">
                    <div class="title">
                      <p>Bán qua cộng tác viên</p>
                      <div class="button-chinh-sua modal-pro-ctv">
                        <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                      </div>
                    </div>
                  </div>
                  <?php
                  }
                  ?>
                  <!-- End CTV -->

                  <!-- thông tin quy cách -->
                  <div class="thongso">
                    <div class="title">
                      <p>Phân loại sản phẩm (Màu sắc, kích thước, chất liệu)</p>
                      <div class="button-chinh-sua modal-pro-qc">
                        <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                      </div>
                    </div>
                    <div class="pro-qc-content">
                      <dl class="style-no-value">
                        <dt>
                          <span class="dot">&#9679;</span>
                          Màu sắc
                        </dt>
                        <dl></dl>
                      </dl>
                      <dl class="style-no-value">
                        <dt>
                          <span class="dot">&#9679;</span>
                          Chất liệu
                        </dt>
                        <dl></dl>
                      </dl>
                      <dl class="style-no-value">
                        <dt>
                          <span class="dot">&#9679;</span>
                          Kích thước
                        </dt>
                        <dl></dl>
                      </dl>
                    </div>
                  </div>
                  <!-- end thông tin quy cách -->

                  <div class="thong-tin-cua-hang">

                      <div class="title">
                        <h3>THÔNG TIN CỬA HÀNG</h3>
                        <ul class="right">
                          <li><img src="/templates/home/styles/images/svg/shop.svg" width="24 alt="Cửa hàng azibai "></li>
                          <li><img src="/templates/home/styles/images/svg/tel.svg" width="15" alt=""></li>
                          <li><img src="/templates/home/styles/images/svg/message.svg" width="15" alt=""></li>
                        </ul>
                      </div>

                      <div class="info">
                        <?php if (!empty($pro_type) && $pro_type == 2){ ?>
                            <div class="item">
                              <div class="button-chinh-sua modal-pro-info">
                                <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                              </div>
                              <!-- Condition Voucher -->
                              <!-- <div class="thongso">
                                <div class="title"> -->
                                  <h4>Điều kiện sử dụng dịch vụ</h4>
                                  <div class="button-chinh-sua modal-pro-condition">
                                    <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                                  </div>
                                <!-- </div>
                              </div> -->
                              <!-- Condition Voucher -->
                          </div>
                        <?php } ?>

                <!-- thông tin <?php echo $result->text ?> -->
                        <div class="item">
                            <div class="button-chinh-sua modal-pro-info">
                              <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                            </div>
                            <h4>Thông tin <?php echo $result->text ?></h4>
                            <table class="table01 template-info">
                              <tr>
                                <th class="style-no-value">Danh mục</th>
                                <td class="style-no-value">azibai   Thời trang nữ    áo thun </td>
                              </tr>
                              <tr>
                                <th class="style-no-value">VAT</th>
                                <td class="style-no-value">Đã có VAT</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Tình trạng</th>
                                <td class="style-no-value">Mới</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Xuất xứ</th>
                                <td class="style-no-value">Hàng công ty Trung Quốc</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Nhà sản xuất</th>
                                <td class="style-no-value">Bitis China</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Sản xuất tại</th>
                                <td class="style-no-value">Trung Quốc</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Bảo hành</th>
                                <td class="style-no-value">12 tháng</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Bảo hộ người mua</th>
                                <td class="style-no-value">Có <img src="/templates/home/styles/images/svg/icon_question.svg" alt=""></td>
                              </tr>
                            </table>
                        </div>
                        <!-- end thông tin <?php echo $result->text ?> -->

                <!-- đặc điểm kỹ thuật -->
                        <div class="item">
                            <div class="button-chinh-sua modal-pro-specification">
                              <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                            </div>
                            <h4>Đặc điểm kỹ thuật</h4>
                            <table class="table01 table02 template-specification">
                              <tr>
                                <th class="style-no-value">Đặc điểm kĩ thuật</th>
                                <td class="style-no-value">áo co giãn abc</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Mã <?php echo $result->text ?> SKU</th>
                                <td class="style-no-value">MS_msp12</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Kích thước</th>
                                <td class="style-no-value">S, M, L, XL, XXL</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Trọng lượng</th>
                                <td class="style-no-value">500 gram</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Model</th>
                                <td class="style-no-value">2018</td>
                              </tr>
                              <tr>
                                <th class="style-no-value">Phụ kiện đi kèm</th>
                                <td class="style-no-value">cài áo</td>
                              </tr>                      
                            </table>
                        </div>
                <!-- end đặc điểm kỹ thuật -->
                
                <!-- mô tả chi tiết -->
                        <div class="item">
                            <div class="button-chinh-sua modal-pro-detail">
                              <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                            </div>
                            <h4>Mô tả chi tiết</h4>
                  <div class="add-product-detail">
                    <ul class="mo-ta-chi-tiet">
                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Lợi ích
                                </li>

                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Bảo hành - bảo quản
                                </li>

                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Khác biệt
                                </li>

                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Chứng nhận
                                </li>

                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Kết quả <?php echo $result->text ?>
                                </li>

                                <li class="style-no-value">
                                  <span class="dot">&#9679;</span>Hướng dẫn sử dụng
                                </li>
                              </ul>
                  </div>
                            
                        </div>
                        <!-- end mô tả chi tiết -->
                    </div>
                        
                  </div>

                    <!-- <?php echo $result->text ?> mua kèm -->
                  <div class="san-pham-mua-kem ">
                      <div class="button-chinh-sua modal-pro-attach">
                        <img src="/templates/home/styles/images/svg/pen.svg" class="mr00" alt="">
                      </div>
                      <h3><?php echo $result->text ?> thường mua kèm</h3>
                      
                      <div class="default-style style-no-value mt20">
                          <div class="san-pham-mua-kem-slider">
                        </div>  
                      </div>
                      
                  </div>
              </div>
          </div>
              <!-- end <?php echo $result->text ?> mua kèm -->
            </div>
        </div>
  </section>
      
</main>

<?php $this->load->view('home/product/popup/popup-edit-product', array()); ?>
<?php $this->load->view('home/product/popup/popup-edit-gallegy', array()); ?>
<?php $this->load->view('home/common/load_wrapp', array()); ?>
<script type="text/javascript">
  $(function() {
   // $('.gallery_01').slick({
   //     autoplay: true,
   //    arrows: false,
   //    dots: false,
   //    slidesToShow: 4,
   //    speed: 1000,
   //    infinite: false,
   //    vertical:true,
   //    verticalSwiping:true,
   //    responsive: [
   //    {
   //      breakpoint: 768,
   //      settings: {
   //        speed: 300,
   //        slidesToShow: 1,
   //        slidesToScroll: 1,
   //        vertical: false,
   //        verticalSwiping:false,
   //        dots: true,
   //        infinite: true,
   //      }
   //    },
   //    ]
   //  });
 });
</script>