<?php
$this->load->view('home/common/header_new');
if($is_owns){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>
    <link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
    <link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
    <main class="trangcuatoi">
      <section class="main-content">
        <div class="container">
            <div class="cover-content">
                <?php $this->load->view($cover_path);  ?>
            </div>
        </div>
        <div class="container bosuutap">
          
          <?php $this->load->view('shop/collection/common/menu_sidebar'); ?>

          <div class="bosuutap-header">
            <div class="button-back"><a href="<?=$shop_url;?>"><img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg"
                  alt=""> Quay lại</a></div>
            <div class="bosuutap-header-right">
              <div class="bosuutap-header-select">
                <h3><img src="/templates/home/styles/images/svg/sapxep.svg" alt=""></h3>
                <ul>
                  <!-- <li>
                    <label class="checkbox-style">
                      <input type="radio" name="sortBy" value="aaa" checked="checked"><span>Sắp xếp tùy chọn</span>
                    </label>
                  </li> -->
                  <li>
                    <label class="checkbox-style">
                      <input type="radio" name="sortBy" value="new" checked="checked"><span>Mới nhất </span>
                    </label>
                  </li>
                  <li>
                    <label class="checkbox-style">
                      <input type="radio" name="sortBy" value="old"><span>Cũ nhất</span>
                    </label>
                  </li>
                  <li>
                    <label class="checkbox-style">
                      <input type="radio" name="sortBy" value="a-z"><span>Xếp từ A đến Z</span>
                    </label>
                  </li>
                </ul>
              </div>
              <div class="bosuutap-header-loaihienthi">
                <ul class="loai-hien-thi">
                  <li class="xem-dang-danh-sach"><img src="/templates/home/styles/images/svg/xemluoi_on.svg" alt=""></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="bosuutap-content">
            <div class="bosuutap-content-detail">
              <div class="noidung-loai-hien-thi ">
                <div class="bosuutap-tabbosuutap">
                  <div class="danhsach-tatcabosuutap">
                    <?php if ($is_owner) {?>
                    <div class="taobosuutap-sp createCollection">
                      <input type="button" class="inputfile" />
                      <label for="file"><img src="/templates/home/styles/images/svg/add_circle.svg" class="mr10" alt="">Thêm BST sản phẩm</label>
                    </div>
                    <?php }?>
                    <div class="danhsach-tatcabosuutap-items md">
                      <p class="tit">Mục đã lưu</p>
                      <p class="search"><input type="text" placeholder="Tìm kiếm mục đã lưu..."><img src="/templates/home/styles/images/svg/search.svg"
                          alt=""></p>
                      <h3>Bộ sưu tập của tôi</h3>
                      <ul class="list">
                      <?php foreach ($collection as $key => $value) { ?>
                        <a href="<?php echo $shop_url. 'shop/collection-product/select/'. $value->id; ?>"><li><img src="<?php echo $value->avatar_path_full; ?>" alt=""><?php echo $value->name; ?> <span
                            class="number"><?php echo $value->total; ?></span></li></a>
                      <?php } ?>
                      </ul>
                    </div>
                  </div>
                  <div class="bosuutap-tabbosuutap-01">
                    <div class="bosuutap-tabbosuutap-xemluoi">
                    <?php foreach ($collection as $key => $value) { ?>
                      <div class="item moreBox" style="display:none" data-index="<?=$key?>" data-char="<?=substr($value->name, 0, 1)?>">
                        <div class="image">
                          <a href="<?php echo $shop_url. 'shop/collection-product/select/'. $value->id?>">
                            <ul class="many-image <?php if($value->total < 2) echo 'one-image';?>">
                              <!-- xem list -->
                              <li class="img-danhsach"><img src="<?php echo $value->avatar_path_full; ?>" alt=""></li>
                              <!-- end xem list -->
                              <!-- xem grid -->
                            <?php if($value->total > 0){ ?>
                              <?php foreach ($value->product as $k => $v) { ?>
                                <li><img src="<?php echo DOMAIN_CLOUDSERVER.'media/images/product/'.$v->pro_dir.'/'. array_shift(explode(',',$v->pro_image))?>" alt=""></li>
                              <?php } ?>
                              <?php if($value->total < 4 && !($value->total < 2) ) { 
                                for ($i=0; $i < (4 - $value->total); $i++) { ?>
                                <li><img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt=""></li>
                              <?php } } ?>

                            <?php } else {?>
                              <li><img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt=""></li>
                            <?php } ?>
                              <!-- end xem grid -->
                            </ul>
                          </a>
                        </div>
                        <div class="descript">
                          <a href="<?=$sl_tab == 'product' ? $shop_url. 'shop/collection-product/select/'. $value->id : $shop_url. 'shop/collection-coupon/select/'. $value->id?>"><?php echo $value->name; ?><br><span><?php echo $value->total . ' mục' ?></span></a>
                          <?php if ($is_owner) {?>
                          <div class="button-chinh-sua editCollection" data-key="<?=$value->id?>" data-img="<?=$value->avatar_path_full?>" data-title="<?=$value->name?>" data-pub="<?=$value->isPublic?>">
                            <img src="/templates/home/styles/images/svg/pen.svg" alt="">
                          </div>
                          <?php } ?>
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

    <footer id="footer"></footer>

  </div>
  <script>
    var type_collection = <?=$sl_tab == 'product' ? COLLECTION_PRODUCT : COLLECTION_COUPON?>;
  </script>
  <?php $this->load->view('shop/collection/popup-collection/popup-create-collection'); ?>
  <?php $this->load->view('shop/collection/popup-collection/popup-edit-collection'); ?>
  <?php $this->load->view('home/common/overlay_waiting'); ?>

  <script src="/templates/home/styles/js/common.js"></script>
  <script src="/templates/home/styles/js/slick.js"></script>
  <script src="/templates/home/styles/js/slick-slider.js"></script>
  <script src="/templates/home/styles/js/countdown.js"></script>
  <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
  <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
  <script src="/templates/home/styles/js/popup_dangtin.js"></script>
  <script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>
  
  <script>
  $( document ).ready(function () {
		$(".moreBox").slice(0, 10).show();
    
    var loading = true;
    $(window).scroll(function() {
      if(loading == true){
        if( $(window).scrollTop() + $(window).height() >= $('.bosuutap-tabbosuutap-xemluoi').height()){
          loading = false;
          $(".moreBox:hidden").slice(0, 3).slideDown(function(){
            loading = true;
          });
        }
      }
    });
  });
  
  // data get default is sort by DESC by create time
  var currentArr = null;
  $('.checkbox-style').find('input[name="sortBy"]').change(function(){
    var key = $(this).val();

    switch (key) {
      case 'new':
        $(".moreBox").hide();
        if(currentArr === null){
          currentArr = $(".moreBox").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          if( $(a).attr('data-index') < $(b).attr('data-index') ) { return -1; } // ASC
          if( $(a).attr('data-index') > $(b).attr('data-index') ) { return 1; } // DESC
          return 0;
        });
        $(".bosuutap-tabbosuutap-xemluoi").html(arr);
        $(".moreBox").slice(0, 10).show();
        break;

      case 'old':
        $(".moreBox").hide();
        if(currentArr === null){
          currentArr = $(".moreBox").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          if( $(a).attr('data-index') < $(b).attr('data-index') ) { return 1; } // DESC
          if( $(a).attr('data-index') > $(b).attr('data-index') ) { return -1; } // ASC
          return 0;
        });
        $(".bosuutap-tabbosuutap-xemluoi").html(arr);
        $(".moreBox").slice(0, 10).show();
        break;

      case 'a-z':
        $(".moreBox").hide();
        if(currentArr === null){
          currentArr = $(".moreBox").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          if( $(a).attr('data-char').toLowerCase() < $(b).attr('data-char').toLowerCase() ) { return -1; } // DESC
          if( $(a).attr('data-char').toLowerCase() > $(b).attr('data-char').toLowerCase() ) { return 1; } // ASC
          return 0;
        });
        $(".bosuutap-tabbosuutap-xemluoi").html(arr);
        $(".moreBox").slice(0, 10).show();
        break;

      default:
        break;
    }
  });

  // console.log($(".moreBox").get());
  </script>
</body>

</html>