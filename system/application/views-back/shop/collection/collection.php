<?php 
$this->load->view('home/common/header_new'); 
$protocol = get_server_protocol();
if($is_owns || $is_owner){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">

<main class="trangcuatoi">
<section class="main-content">
    <div class="container">
        <div class="cover-content">
            <?php $this->load->view($cover_path);  ?>
        </div>
    </div>
    <div class="container bosuutap">
        <div class="bosuutap-header">
            <div class="back-trangcanhan md"><a href="<?php echo ($myshop->domain) ? 'http://' . $myshop->domain : '//' . $myshop->sho_link . '.' . domain_site ?>"><img src="/templates/home/styles/images/svg/back.svg" alt="">Trang cá nhân</a></div>
            <div class="bosuutap-header-tabs">
            <ul class="bosuutap-tab-content">
                <li class="is-active"><a href="<?php echo getAliasDomain() .'shop/collection/all'; ?>">Tất cả </a></li>
                <li><a href="<?php echo getAliasDomain() . 'shop/collection'; ?>">Bài viết</a></li>
                <li><a href="<?php echo getAliasDomain() . 'shop/collection-link'; ?>">Link liên kết</a></li>
            </ul>
            </div>
            <div class="bosuutap-header-select md">
            <!-- <h3>Tất cả</h3>
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
            </ul> -->
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
            <h3 class="tit"><?php echo $total; ?> Mục đã lưu</h3>
            <div class="text-center">
                <!-- <div class="bosuutap-header-select sm">
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
                </div> -->
            </div>
            <div class="noidung-loai-hien-thi">
                <div class="bosuutap-all-items">

                <?php foreach ($collection_content as $key => $value) { ?>
                <div class="item">
                    <div class="image">
                      <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_3_' . $value->not_image; ?>" alt="">
                    <ul class="action">

                        <?php if ($is_owner) {?>
                        <li class="btn-show-comment-customer" data-id="modal_0" onclick="loadCollectionPopup(<?php echo $value->not_id; ?>)">
                        <span class="image"><img src="/templates/home/styles/images/svg/ghim.svg" alt=""></span>
                        </li>
                        <?php } ?>

                        <li>
                        <span class="image"><img src="/templates/home/styles/images/svg/3dot_white.svg" alt=""></span>
                        <div class="hover-action">
                            <p onclick="copyLink(<?php echo $value->not_id; ?>)">Sao chép liên kết</p>
                            <p><a href="<?php echo $protocol . domain_site . '/tintuc/detail/' . $value->not_id; ?>" target="_blank">Xem nội dung</a></p>
                        </div>
                        </li>
                        <!-- <li class="btn-show-comment-customer" data-id="modal_2">
                          <span class="image"><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""></span>
                          <div class="hover-action">
                              <p class="btn-show-comment-customer" data-id="modal_1">Gửi dưới dạng tin nhắn</p>
                              <p class="btn-show-comment-customer" data-id="modal_1">Chia sẻ trên trang cá nhân</p>
                              <p class="btn-show-comment-customer" data-id="modal_1">Chia sẻ trong nhóm</p>
                              <p class="btn-show-comment-customer" data-id="modal_1">Liên kết ngoài</p>
                          </div>
                        </li> -->
                    </ul> 
                    </div>
                    <div class="text">
                    <p><?php echo $value->not_title; ?></p>
                    <span class="tablet"><img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt=""></span>
                    <div class="hover-action sp tablet">

                      <?php if ($is_owner) {?>
                        <p class="btn-show-comment-customer" data-id="modal_0" onclick="loadCollectionPopup(<?php echo $value->not_id; ?>)">Thêm/xóa vào bộ sưu tập</p>
                      <?php } ?>

                        <!-- <p class="btn-show-comment-customer" data-id="modal_1">Chia sẻ</p> -->
                        <p onclick="copyLink(<?php echo $value->not_id; ?>)">Sao chép liên kết</p>
                        <p><a href="<?php echo $protocol . domain_site . '/tintuc/detail/' . $value->not_id; ?>" target="_blank">Xem nội dung</a></p>
                    </div>
                    </div>
                </div>
                <?php } ?>

                </div>
            </div>
            <div class="noidung-loai-hien-thi hidden">
                <div class="bosuutap-xemluoi">

                <?php foreach ($collection_content as $key => $value) { ?>
                <div class="item">
                    <div class="detail">
                    <div class="left">
                        <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_3_' . $value->not_image; ?>" alt="">
                    </div>
                    <div class="right">
                        <h3><?php echo $value->not_title; ?></h3>
                        <p><span class="tablet-none">Bài viết </span><span class="dot">&#9679;</span> Đã lưu vào  
                          <?php if(count($value->name) == 1) {?>
                            <span class="bg-gray"><?php echo $value->name; ?></span>
                          <?php } else {?>
                          <?php foreach ($value->name as $k => $v) { ?>
                            <span class="bg-gray"><?php echo $v; ?></span>
                          <?php } }?>
                        </p>
                        <ul class="list-action">
                        <!-- <li><img src="/templates/home/styles/images/svg/share_01_white.svg" alt=""><span class="tablet-none">Chia sẻ</span></li> -->
                        <?php if ($is_owner) {?><li onclick="loadCollectionPopup(<?php echo $value->not_id; ?>)"><img src="/templates/home/styles/images/svg/ghim_01.svg" alt=""><span class="tablet-none">Thêm/xóa vào bộ sưu tập</span></li><?php } ?>
                        <!-- <li><img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt=""></li> -->
                        <li>
                          <span class="xemthem "><img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt="more"></span>
                          <div class="show-more">
                            <ul class="show-more-detail">
                              <li><p onclick="copyLink(<?php echo $value->not_id; ?>)">Sao chép liên kết</p></li>
                              <li><p><a href="<?php echo $protocol . domain_site . '/tintuc/detail/' . $value->not_id; ?>" target="_blank">Xem nội dung</a></p></li>
                            </ul>
                          </div>
                        </li>
                        </ul>
                    </div>
                    </div>
                    <!-- <div class="da-luu-tu">
                    <img src="/templates/home/styles/images/product/avata/mi.svg" alt="">Đã lưu từ <span>bài viết của bạn</span>
                    </div> -->
                </div>
                <?php } ?>

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
  <script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>
  <script src="/templates/home/styles/js/shop/shop-common.js"></script>
  <script type="text/javascript">
    function copyLink(nid) {
      var textArea = document.createElement("textarea");
      textArea.value = "<?php echo $protocol . domain_site; ?>/tintuc/detail/"+nid;
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
      var url = "<?= $shop_url ?>collection/ajax_loadCollection/"+nid+"/"+1;
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