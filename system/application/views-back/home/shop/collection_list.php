<?php 
$this->load->view('home/common/header_new');
?>

<body>
    <main class="trangcuatoi">      
      <section class="main-content">
        <div class="container">
          <div class="cover-content">
            <div class="cover-part">
              <img src="/templates/home/styles\images\cover\cover_me.jpg" alt="">
              <?php if ($is_owner) {?>
              <div class="button-chinh-sua">
                <img src="/templates/home/styles/images/svg/pen.svg" alt=""><span>Chỉnh sửa</span>
              </div>
              <?php } ?>
            </div>
            <div class="avata-part">
              <div class="avata-part-left">
                <div class="avata-img">
                <?php if($info_public['avatar']){
                    $info_public_avatar_path = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $info_public['avatar'];
                } else {
                    $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                } ?>
                  <img src="<?php echo $info_public_avatar_path; ?>" alt="">
                  <div class="edit"><span><img src="/templates/home/styles/images/svg/pen.svg" alt=""></span></div>
                </div>
                <div class="avata-title">
                  <span>Trang của <?php echo $info_public['use_fullname']; ?></span><br>@<?php echo $info_public['use_fullname']; ?>
                </div>
              </div>
              <div class="avata-part-right">
                <div class="chinh-sua"><img src="/templates/home/styles/images/svg/chinhsua.svg" alt=""><span>Chỉnh sửa</span></div>
                <div class="chinh-sua"><img src="/templates/home/styles/images/svg/bosuutap.svg" alt=""><span>Bộ sưu tập</span></div>
                <div class="xemthem"><img src="/templates/home/styles/images/svg/3dot_white.svg" alt=""></div>
              </div>
            </div>
          </div>
        </div>
        <div class="container bosuutap">
          <div class="bosuutap-header">
            <div class="back-trangcanhan md"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site ?>"><img src="/templates/home/styles/images/svg/back.svg" alt="">Trang cá nhân</a></div>
            <div class="bosuutap-header-tabs">
              <ul class="bosuutap-tab-content">
                <li><a href="<?php echo base_url() . 'shop/collection/' . $uid;?>">Tất cả </a></li>
                <li class="is-active"><a href="<?php echo base_url() . 'shop/collection/' . $uid . '/select';?>">Bộ sưu tập</a></li>
              </ul>
            </div>
            <div class="bosuutap-header-select md">
              <h3>Tất cả</h3>
              <ul>
               <li>
                  <label class="checkbox-style">
                  <input type="radio" name="category" value="aaa" checked="checked"><span>Sắp xếp tùy chọn</span>
                  </label>
               </li>
               <li >
                  <label class="checkbox-style">
                  <input type="radio" name="category" value="Bài viết"><span>Mới nhất </span>
                  </label>
               </li>
               <li>
                  <label class="checkbox-style">
                  <input type="radio" name="category" value="Sản phẩm"><span>Cũ nhất</span>
                  </label>
               </li>
               <li>
                  <label class="checkbox-style">
                  <input type="radio" name="category" value="Sản phẩm"><span>Xếp từ A đến Z</span>
                  </label>
               </li>
              </ul>
            </div>
            <div class="bosuutap-header-loaihienthi">
              <ul class="loai-hien-thi">
                <li><img src="/templates/home/styles/images/svg/danhsach_on.svg" alt=""></li>
                <li><img src="/templates/home/styles/images/svg/xemluoi_off.svg" alt=""></li>
              </ul>
            </div> 
          </div>
          <div class="bosuutap-content">
            <div class="bosuutap-content-detail">
              <!-- <h3 class="tit">78 Mục đã lưu</h3> -->
              <div class="text-center">
                <div class="bosuutap-header-select sm">
                  <h3>Tất cả</h3>
                  <ul>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="aaa" checked="checked"><span>Tất cả</span>
                      </label>
                   </li>
                   <li >
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Bài viết"><span>Bài viết</span>
                      </label>
                   </li>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Sản phẩm"><span>Sản phẩm</span>
                      </label>
                   </li>
                  </ul>
                </div>
              </div>
              <div class="noidung-loai-hien-thi">
                <div class="bosuutap-tabbosuutap-timbosuutap sm"><img src="/templates/home/styles/images/svg/search.svg" alt=""><input type="text" placeholder="Tìm bộ sưu tập..."></div>

                <div class="bosuutap-tabbosuutap">
                   <div class="danhsach-tatcabosuutap md">
                     <p>Mục đã lưu</p>
                     <p class="search"><input type="text" placeholder="Tìm kiếm mục đã lưu..."><img src="/templates/home/styles/images/svg/search.svg" alt=""></p>
                     <h3>Bộ sưu tập của tôi</h3>
                     <ul class="list">
                       <?php foreach ($collection as $key => $value) { ?>
                       <li><a href="<?php echo base_url(). 'shop/collection/1694/select/' . $value->id?>"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar; ?>" alt=""><?php echo $value->name; ?></a> <span class="number"><?php echo $value->total; ?></span></li>
                       <?php } ?>
                     </ul>
                   </div>
                   <div class="bosuutap-tabbosuutap-01">
                      <div class="taobosuutap-sp">
                          <input type="file" name="file" id="file" class="inputfile" />
                            <label for="file">Tạo bộ sưu tập mới<img src="/templates/home/styles/images/svg/add_circle.svg" alt=""></label>
                      </div>
                      <div class="bosuutap-tabbosuutap-danhsach">
                        <!-- <div class="item md">
                          <div class="taobaosutapmoi image">
                            <input type="file" name="file" id="file" class="inputfile" />
                            <label for="file"><img src="/templates/home/styles/images/svg/add_circle.svg" alt=""></label>
                          </div>
                          <div class="descript">Tạo bộ sưu tập mới</div>
                        </div> -->
                        <div class="item sm taobosuutap-sp">
                          <input type="file" name="file" id="file" class="inputfile" />
                            <label for="file">Tạo bộ sưu tập mới<img src="/templates/home/styles/images/svg/add_circle.svg" alt=""></label>
                        </div>

                        <?php foreach ($collection as $key => $value) { ?>
                        <div class="item">
                          <div class="image">
                            <ul class="many-image <?php if($value->total < 2) echo 'one-image';?>">
                              <?php if($value->total > 0){ ?>
                                <?php foreach ($value->content as $k => $v) { ?>
                                <li><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $v->not_dir_image . '/thumbnail_3_' . $v->not_image; ?>" alt=""></li>
                                <?php } ?>
                              <?php } else {?>
                                <li><img src="/templates/home/styles/images/svg/default-img-error.svg" alt=""></li>
                              <?php } ?>
                            </ul>
                          </div>
                          <div class="descript"><?php echo $value->name; ?><br><span><?php echo $value->total . 'mục' ?></span>
                          <div class="button-chinh-sua">
                            <img src="/templates/home/styles/images/svg/pen.svg" alt="">
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                        
                      </div>
                   </div>
                </div>
              </div>
              <div class="noidung-loai-hien-thi hidden">
                 <div class="bosuutap-tabbosuutap-timbosuutap sm"><img src="/templates/home/styles/images/svg/search.svg" alt=""><input type="text" placeholder="Tìm bộ sưu tập..."></div>
                <div class="bosuutap-tabbosuutap">
                   <div class="danhsach-tatcabosuutap md">
                     <p>Mục đã lưu</p>
                     <p class="search"><input type="text" placeholder="Tìm kiếm mục đã lưu..."><img src="/templates/home/styles/images/svg/search.svg" alt=""></p>
                     <h3>Bộ sưu tập của tôi</h3>
                     <ul class="list">
                       <?php foreach ($collection as $key => $value) { ?>
                       <li><a href="<?php echo base_url(). 'shop/collection/1694/select/' . $value->id?>"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar; ?>" alt=""><?php echo $value->name; ?></a> <span class="number"><?php echo $value->total; ?></span></li>
                       <?php } ?>
                     </ul>
                   </div>
                   <div class="bosuutap-tabbosuutap-xemluoi">
                     
                     <div class="taobosuutap-sp">
                       <input type="file" name="file" id="file" class="inputfile" />
                        <label for="file">Tạo bộ sưu tập mới<img src="/templates/home/styles/images/svg/add_circle.svg" alt=""></label>
                     </div>
                     <div class="list-items">

                      <?php foreach ($collection as $key => $value) { ?>
                       <div class="item">
                         <div class="image"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar; ?>" alt=""></div>
                         <div class="text">
                           <div class="name"><?php echo $value->name; ?></div>
                           <div class="edit">
                             <?php echo $value->total . 'mục' ?>
                            <div class="button-chinh-sua">
                             <img src="/templates/home/styles/images/svg/pen.svg" alt="">
                            </div>
                           </div>
                         </div>
                       </div>
                       <?php } ?>

                     </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
    </main>
    <footer id="footer"> </footer>
     <div class="drawer-overlay drawer-toggle"></div>
      <div class="model-content" id="modal_0">
        <div class="wrapp-model">
          <div class="content-model">
            <div class="contents bosuutap-popup">
              <div class="btn-back js-back"><a href="#"><img src="/templates/home/styles/images/svg/close_black.svg"></a></div>
              <ul class="bosuutap-popup-danhsach-hientai">
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa" checked="checked"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
              </ul>
              <div class="bosuutap-popup-taomoi">
                <div class="title" >
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" id="taomoi" value="aaa"><span>Tạo bộ sưu tập mới</span>      
                  </label>
                </div>
                <div class="content" style="display: none;">
                  <div class="nhap-ten">
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="input"><input type="text" placeholder="nhap ten"></div>
                  </div>
                  <div class="nut-xacnhan buttons-group">
                    <button class="btn-bg-white">Hủy</button>
                    <button class="btn-bg-gray">Tạo</button>
                  </div>
                </div>
              </div>
              
              <div class="nut-xacnhan buttons-group">
                <button class="btn-bg-white">Hủy</button>
                <button class="btn-bg-gray">Tạo</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="model-content" id="modal_1">
        <div class="wrapp-model">
          <div class="content-model">
            <div class="contents bosuutap-popup">
              <div class="btn-back js-back"><a href="#"><img src="/templates/home/styles/images/svg/close_black.svg"></a></div>
              <ul class="bosuutap-popup-danhsach-hientai">
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa" checked="checked"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
                <li>
                  <label class="checkbox-style">
                    <input type="checkbox" name="category" value="aaa"><span></span>                  
                    <div class="photo">
                      <img src="/templates/home/styles/images/product/shop/img01.jpg" alt="">
                    </div>
                    <div class="name">Tên bộ sưu tập Tên bộ sưu tập</div>
                  </label>
                </li>
              </ul>
              
              <div class="nut-xacnhan buttons-group">
                <button class="btn-bg-white">Hủy</button>
                <button class="btn-bg-gray">Gỡ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="model-content" id="modal_2">
        <div class="wrapp-model">
          <div class="content-model">
            <div class="contents bosuutap-popup">
              <div class="btn-back js-back"><a href="#"><img src="/templates/home/styles/images/svg/close_black.svg"></a></div>
              <ul class="bosuutap-popup-danhsach-hientai">
                <li></li>
                <li>Gỡ khỏi bộ sưu tập</li>
                <li>Xóa </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
  </div>
  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>  
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
  <script src="/templates/home/styles/js/popup_dangtin.js"></script>
  <script type="text/javascript">
    $('.bosuutap-header-select h3').click(function(){
      $(this).toggleClass('opened');
      if ($(this).hasClass('opened')) {
        $(this).next().css("display", "block")
      } else {
        $(this).next().css("display", "none")
      }
    });
    $("#taomoi").change( function() {
      var isCheck = $(this).is(":checked");
      if (isCheck) {
        $('.bosuutap-popup-taomoi .content').slideDown();
      } else {
        $('.bosuutap-popup-taomoi .content').slideUp();
      }
    });
  </script>
</body>