<?php 
$this->load->view('home/common/header_new');
?>

<body>
    <main class="trangcuatoi bosuutap-chitiet">      
      <section class="main-content">
        <div class="container">
          <div class="cover-content">
            <div class="cover-part">
              <img src="/templates/home/styles\images\cover\cover_me.jpg" alt="">
              <div class="avata-img">
                <?php if($info_public['avatar']){
                    $info_public_avatar_path = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $info_public['avatar'];
                } else {
                    $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                } ?>
                <img src="<?php echo $info_public_avatar_path; ?>" alt="">
                <div class="edit"><span><img src="/templates/home/styles/images/svg/pen.svg" alt=""></span></div>
              </div>
            </div>            
          </div>
        </div>
        <div class="container bosuutap">
          <div class="bosuutap-header">
            <div class="back-trangcanhan md"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site . '/shop/collection/' . $uid; ?>"><img src="/templates/home/styles/images/svg/back.svg" alt="">Về trang trước</a></div>
            <div class="bosuutap-chitiet-tieude">
              <div class="ten"><?php echo $coll_selected->name;?> <br><span><?php echo $coll_selected->total . ' mục';?> </span></div>
              <div class="icons">
                <div class="okhoa"><img src="/templates/home/styles/images/svg/okhoa.svg" alt=""></div>
                <div class="icon"><img src="/templates/home/styles/images/svg/add_circle.svg" alt=""></div>
                <div class="icon"><img src="/templates/home/styles/images/svg/pen_black.svg" alt=""></div>
                <div class="icon"><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""></div>
              </div>
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
              <div class="noidung-loai-hien-thi">
                <div class="bosuutap-tabbosuutap">
                   <div class="danhsach-tatcabosuutap md">
                     <p>Mục đã lưu</p>
                     <p class="search"><input type="text" placeholder="Tìm kiếm mục đã lưu..."><img src="/templates/home/styles/images/svg/search.svg" alt=""></p>
                     <h3>Bộ sưu tập của tôi</h3>
                     <ul class="list">
                     <?php foreach ($collection as $key => $value) { ?>
                       <li><a href="<?php echo base_url(). 'shop/collection/'.$uid.'/select/' . $value->id?>"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar; ?>" alt=""><?php echo $value->name; ?></a> <span class="number"><?php echo $value->total; ?></span></li>
                      <?php } ?>
                     </ul>
                   </div>
                   <div class="bosuutap-tabbosuutap-danhsach">
                     <?php foreach ($collection_content as $key => $value) { ?>
                     <div class="item">
                       <div class="image">
                        <ul class="many-image one-image">
                          <li>
                            <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_3_' . $value->not_image; ?>" alt="">
                            <ul class="action">

                              <?php if ($is_owner) {?>
                              <li class="btn-show-comment-customer" data-id="modal_0" onclick="loadCollectionPopup(<?php echo $value->not_id; ?>)">
                                <span class="image-sub"><img src="/templates/home/styles/images/svg/ghim.svg" alt=""></span>
                              </li>
                              <?php } ?>

                              <li>
                                <span class="image-sub"><img src="/templates/home/styles/images/svg/3dot_white.svg" alt=""></span>
                                <div class="hover-action">
                                  <!-- <p class="btn-show-comment-customer" data-id="modal_1">Gỡ khỏi bộ sưu tập</p>
                                  <p class="btn-show-comment-customer" data-id="modal_1">Xóa</p> -->
                                  <p onclick="copyLink(<?php echo $value->not_id; ?>)">Sao chép liên kết</p>
                                  <p><a href="<?php echo base_url() . 'tintuc/detail/' . $value->not_id; ?>" target="_blank">Xem nội dung</a></p>
                                </div>
                              </li>
                              <li class="btn-show-comment-customer" data-id="modal_2">
                                <span class="image-sub"><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""></span>
                                <div class="hover-action">
                                  <p class="btn-show-comment-customer" data-id="modal_1">Gửi dưới dạng tin nhắn</p>
                                  <p class="btn-show-comment-customer" data-id="modal_1">Chia sẻ trên trang cá nhân</p>
                                  <p class="btn-show-comment-customer" data-id="modal_1">Chia sẻ trong nhóm</p>
                                  <p class="btn-show-comment-customer" data-id="modal_1">Liên kết ngoài</p>
                                </div>
                              </li>
                            </ul>  
                          </li>
                        </ul>
                       </div>
                       <div class="descript"><?php echo $value->name;?></div>
                     </div>
                     <?php } ?>
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
                      <li><a href="<?php echo base_url(). 'shop/collection/'.$uid.'/select/' . $value->id?>"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' .$value->avatar; ?>" alt=""><?php echo $value->name; ?></a> <span class="number"><?php echo $value->total; ?></span></li>
                      <?php } ?>
                     </ul>
                   </div>
                   <div class="bosuutap-tabbosuutap-xemluoi">
                     
                     <div class="list-items">
                     <?php foreach ($collection_content as $key => $value) { ?>
                       <div class="item">
                         <div class="image"><img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_3_' . $value->not_image; ?>" alt=""></div>
                         <div class="text">
                           <div class="name"><?php echo $value->name;?></div>
                           <div class="edit">
                            <?php echo $value->total;?>
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
              <!-- append data modal -->
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

    function copyLink(nid) {
      var textArea = document.createElement("textarea");
      textArea.value = "<?php echo base_url(); ?>tintuc/detail/"+nid;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("Copy");
      textArea.remove();
    }
    
    $('.bosuutap-header-select h3').click(function(){
      $(this).toggleClass('opened');
      if ($(this).hasClass('opened')) {
        $(this).next().css("display", "block")
      } else {
        $(this).next().css("display", "none")
      }
    });

    function loadCollectionPopup(nid){
      $("#modal_0 .bosuutap-popup").empty();
      var url = "<?= base_url() ?>collection/ajax_loadCollection/"+nid;
      $.ajax({
        type: 'POST',
        url: url,
        success: function(data) {
          
          $("#modal_0 .bosuutap-popup").append(data);
          $('.btn-show-comment-customer').toggleClass('opened');
          var modal = $('.btn-show-comment-customer').attr("data-id")
          if ($('.btn-show-comment-customer').hasClass('opened')) {
            $('#'+modal).addClass('is-open');
            $('.wrapper').addClass('drawer-open');
          } else {
            $('#'+modal).removeClass('is-open');
            $('.wrapper').removeClass('drawer-open');
          }
          return false;
        }
      });
    }
  </script>
</body>