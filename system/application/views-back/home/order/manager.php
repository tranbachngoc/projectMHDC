<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/admin.css">
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/ordersmanager.css">
    <main class="ordersmanager">
      <section class="main-content">
        <div class="breadcrumb">
          <div class="container">
            <ul>
              <li><a href="">Trang chủ <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="ml10 mt05" alt=""></a></li>
              <li><a href="">Quản lý đơn hàng</a></li>
            </ul>
          </div>
        </div>
        <div class="container">
          <div class="affiliate-menupage">
            <ul>
              <li class="active">
                <a href="index.html">
                  <span class="icon"><img src="/templates/home/styles/images/svg/affiliate_newest_on.svg" alt=""></span><br>
                  <span class="tit">Mới nhất</span>
                </a>
              </li>
              <li>
                <a href="magiamgia.html">
                  <span class="icon"><img src="/templates/home/styles/images/svg/affiliate_coupon.svg" alt=""></span><br>
                  <span class="tit">Mã giảm giá</span>
                </a>
              </li>
              <li>
                <a href="donhang.html">
                  <span class="icon"><img src="/templates/home/styles/images/svg/affiliate_product.svg" alt=""></span><br>
                  <span class="tit">Sản phẩm</span>
                </a>
              </li>
              <li>
                <a href="thunhap.html">
                  <span class="icon"><img src="/templates/home/styles/images/svg/affiliate_pmh.svg" alt=""></span><br>
                  <span class="tit">Phiếu mua hàng</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="ordersmanager-content">
            <div class="administrator-bussinesspost ordersmanager-content-newest">
              <div class="search">
                <div class="search-date">
                  <div class="from">
                    <input type="text" class="form-control datepicker" placeholder="Chọn ngày">
                  </div>
                  <p class="txt">Đến</p>
                  <div class="to">
                    <input type="text" class="form-control datepicker" placeholder="Chọn ngày">
                  </div>
                </div>
                <div class="search-category">
                  <select name="" id="" class="form-control">
                    <option value="">Trạng thái đơn hàng</option>
                    <?php
                    foreach ($order_status as $key => $value) {
                    echo '<option value="'.$value->id.'">'.$value->text.'</option>';
                    }
                    ?>
                  </select>
                </div>
                <a class="btn-search">Tìm kiếm</a>                  
                <div class="search-input">
                  <img src="/templates/home/styles/images/svg/search.svg" alt="">
                  <input type="text" class="form-control" placeholder="Nhập từ khóa">
                </div>
              </div>
              <div class="bussinesspost-table">
                <table>
                  <tr class="sm-none">
                    <th>Ngày mua</th>
                    <th>Mã đơn hàng</th>
                    <th>Tên sản phẩm</th>
                    <th>Người mua</th>
                    <th>Tổng cộng</th>
                    <th>Nhà vân chuyện</th>
                    <th>Trạng thái</th>
                    <th>Nhắn tin</th>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>                    
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn"  data-target="#displayInformation" data-toggle="modal"><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></td>
                    <td class="sm-none" data-target="#displayInformation" data-toggle="modal"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt="" data-toggle="tooltip" title="Chưa được thông báo"></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/close_gray.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/close_gray.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/close_gray.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                  <tr>
                    <td class="id sm-none">123</td>
                    <td class="title">
                      <div class="text">Neymar mưu trở lại Barca: Cuộc đoàn tụ lý tưởng hay vết xe đổ Fabregas?</div>
                      <div class="sm">
                        <div class="small-txt">
                          <span>Thể thao</span>
                          <span>Fc Barcelona Viet Nam</span>
                          <span>17/07/2019</span>
                        </div>
                        <div class="small-btn">
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg" class="mr05" alt="">Kích hoạt</button>
                          <button class="btn" href=""><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
                          <button class="btn bg-gray" href=""><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
                        </div>
                      </div>
                    </td>
                    <td class="sm-none">Thể thao</td>
                    <td class="sm-none">Fc Barcelona Viet Nam</td>
                    <td class="sm-none">17/07/2019</td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/close_gray.svg" alt=""></td>
                    <td class="sm-none"><img src="/templates/home/styles/images/svg/infor_gray.svg" alt=""></td>
                    <td class="sm-none"><a href="#settingInformation" data-toggle="modal" class="setting">Cài đặt</a></td>
                  </tr>
                </table>
              </div>
              <nav aria-label="Page navigation example">
                <ul class="pagination pagination-center-style justify-content-center">
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true"><</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div> 
          </div>
        </div>
      </section>
    </main>
    <footer id="footer"> </footer>
  </div>
  <script src="../asset/boostrap/js/popper.min.js"></script>
  <script src="../asset/boostrap/js/bootstrap.min.js"></script>
  <script src="../asset/styles/js/common.js"></script>
  <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>
</body>
</html>