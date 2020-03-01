<?php 
$this->load->view('home/common/header_new'); 
$protocol = get_server_protocol();
if($is_owns){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>

<style>
  .text h1,h2,h3,h4,p{
    width: 100%;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
</style>
    <link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
    <main class="trangcuatoi">
      <section class="main-content">
        <div class="container">
            <div class="cover-content">
                <?php $this->load->view($cover_path);  ?>
            </div>
        </div>
        <div class="container bosuutap bg-black-container">
          <?php $this->load->view('shop/collection/common/menu_sidebar'); ?>
          <div class="bosuutap-header tieude-chinhsua">
            <div class="button-back"><a href="<?=$shop_url;?>"><img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg" alt=""> Quay lại</a></div>
            <div class="bosuutap-chitiet-tieude">
              <div class="ten"><?=$coll_selected->name ?> <br><span><?=$coll_selected->total?> mục </span></div>
              <div class="icons">
                <?php if ($is_owner) { ?>
                <div class="okhoa"><img src="/templates/home/styles/images/svg/okhoa.svg" alt=""></div>
                <!-- <div class="icon add-lk"><img src="/templates/home/styles/images/svg/add_circle_black.svg" alt=""></div> -->
                <!-- <div class="icon"><img src="/templates/home/styles/images/svg/lienket.svg" alt=""></div> -->
                <div class="icon editCollection" data-key="<?=$coll_selected->id?>" data-img="<?=$coll_selected->avatar_path_full?>" data-title="<?=$coll_selected->name?>" data-pub="<?=$coll_selected->isPublic?>">
                  <img src="/templates/home/styles/images/svg/pen_black.svg" alt="">
                </div>
                <?php } ?>
                <div class="icon share-click shr-bosuutap" data-toggle="modal" data-value="<?=$share_url;?>" data-name="<?=$share_name;?>"><img src="/templates/home/styles/images/svg/share.svg" alt=""></div>
                <div class="icon sm js-xem-dang-danh-sach <?php echo ($is_owner == false ? 'ml00' : '') ?>"><img src="/templates/home/styles/images/svg/xemluoi_on.svg" alt=""></div>
                <div class="bosuutap-header-select sm">
                  <h3 class="icon"><img src="/templates/home/styles/images/svg/sapxep.svg" alt=""></h3>
                  <ul>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Bài viết" checked="checked"><span>Mới nhất </span>
                      </label>
                   </li>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Sản phẩm"><span>Cũ nhất</span>
                      </label>
                   </li>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Bài viết"><span>Xếp từ A đến Z</span>
                      </label>
                   </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tim-bosuutap sm">
              <p class="search"><input type="text" placeholder="Tìm kiếm mục đã lưu..."><img src="/templates/home/styles/images/svg/search.svg" alt=""></p>
            </div>
            <div class="bosuutap-header-right md">
              <div class="bosuutap-header-select">
                <h3><img src="/templates/home/styles/images/svg/sapxep.svg" alt=""></h3>
                <ul>
                 <li >
                    <label class="checkbox-style">
                    <input type="radio" name="sortBy" value="Bài viết" checked="checked"><span>Mới nhất </span>
                    </label>
                 </li>
                 <li>
                    <label class="checkbox-style">
                    <input type="radio" name="sortBy" value="Sản phẩm"><span>Cũ nhất</span>
                    </label>
                 </li>
                 <li >
                    <label class="checkbox-style">
                    <input type="radio" name="sortBy" value="Bài viết"><span>Xếp từ A đến Z</span>
                    </label>
                 </li>
                </ul>
              </div>
            </div>            
          </div>
          <div class="liet-ke-hinh-anh">
            <div class="grid">
              <?php foreach ($collection_content as $key => $value) {?>
                <?php $this->load->view('shop/collection/common/item_content', ['item'=>$value]); ?>
              <?php } ?>         
            </div> 
          </div>
        </div>
      </section>
       
    </main>
    <footer id="footer">
      <div id="loadding-more" class="text-center hidden">
        <img src="/templates/home/styles/images/loading-dot.gif" alt="loading">
      </div>
    </footer>
  </div>
  <script>
    var type_collection = 1 // type collection_content = 1
  </script>
  <?php if ($is_owner) {?>
  <?php $this->load->view('shop/collection/popup-collection/popup-edit-collection'); ?>
  <?php $this->load->view('shop/collection/popup-collection/popup-pin-node-to-other-collection'); ?>
  <?php }?>
  <?php $this->load->view('home/common/overlay_waiting'); ?>

  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>  
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
  <script src="/templates/home/styles/js/popup_dangtin.js"></script>
  <script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>

  <script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="/templates/home/styles/plugins/masonry/masonry.pkgd.min.js"></script>

  <script type="text/javascript">
    var masonryOptions = {
      itemSelector: '.item',
      horizontalOrder: true
    }
    var $grid = $('.grid').masonry( masonryOptions );
    $grid.imagesLoaded().progress( function() {
      $grid.masonry('layout');
    });

    var isActive = true;    
    $('.js-xem-dang-danh-sach').click(function() {
      $(this).toggleClass('danhsach');
      if ($(this).hasClass('danhsach')) {
        $grid.masonry('destroy');
        $(this).find('img').attr("src","/templates/home/styles/images/svg/danhsach_white_on.svg");
        $('.liet-ke-hinh-anh').find('.grid').addClass('style-xem-dang-danh-sach');
        $('body').find('.main-content').addClass('bg-black');
      } else {
        $('.liet-ke-hinh-anh').find('.grid').removeClass('style-xem-dang-danh-sach');
        $(this).find('img').attr("src","/templates/home/styles/images/svg/xemluoi_on.svg");
        $grid.masonry( masonryOptions );
        $('body').find('.main-content').removeClass('bg-black');
      }
    });

    var is_busy = false;
    var page = 1;
    var stopped = false;
    $(window).scroll(function(event) {
      $element = $('.wrapper');
      $loadding = $('#loadding-more');
      if($(window).scrollTop() + $(window).height() >= $element.height() - 200) {
          if (is_busy == true){
              event.stopPropagation();
              return false;
          }
          if (stopped == true){
              event.stopPropagation();
              return false;
          }
          $loadding.removeClass('hidden');
          is_busy = true;
          page++;

          $.ajax({
            type: 'post',
            dataType: 'html',
            url: window.location.href,
            data: {page: page},
            success: function (result) {
                $loadding.addClass('hidden');
                if(result == '') {
                    stopped = true;
                }
                if(result){
                    var $content = $(result);
                    $grid.append( $content ).masonry('appended', $content);
                    $grid.imagesLoaded().progress( function() {
                      $grid.masonry('layout');
                    });
                }
            }
          }).always(function() {
              is_busy = false;
          });
        return false;
      }
    });
  </script>
  <script>
    var domain = '<?php echo $protocol . domain_site ?>';
    function copyLink(id) {
      var textArea = document.createElement("textarea");
      var link = domain + "/tintuc/detail/" + id; 
      textArea.value = link;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("Copy");
      textArea.remove();
    }
  </script>
</body>
</html>