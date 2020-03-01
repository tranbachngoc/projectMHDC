<?php
$this->load->view('home/common/header_new');
?>

<link rel="stylesheet" href="/templates/home/boostrap/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="/templates/home/boostrap/js/bootstrap-datetimepicker.min.js"></script>


<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>  
<script src="/templates/home/styles/js/countdown.js"></script>
<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/styles/js/fixed_sidebar.js"></script>
<script src='/templates/home/styles/plugins/elevatezoom-master/jquery.elevatezoom.js'></script>


<script src="/templates/home/js/general_ver2.js"></script>
<script async src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>
<link rel="stylesheet" href="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.css">
<style type="text/css">
  .sale {
    margin-bottom: 10px;
  }
  li.btn-buyadd button{
    border: 1px solid #ccc;
    border-radius: 5px;
    background: transparent;
    color: #ccc;
    padding: 3px 8px;
  }

  .modal-show-detail.modal-gallegy .popup-image-sm {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    display: -webkit-flex;
    /* Safari */
    display: -moz-flex;
    /* Firefox */
    display: -ms-flex;
    /* IE */
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    -ms-justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    -ms-align-items: center; }
  .modal-show-detail.modal-gallegy .action {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    display: -webkit-flex;
    /* Safari */
    display: -moz-flex;
    /* Firefox */
    display: -ms-flex;
    /* IE */
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    -ms-justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-align-items: center;
    -moz-align-items: center;
    -ms-align-items: center; }
  .modal-show-detail.modal-gallegy .tieude-md {
    padding: 35px 2% 10px;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 22;
    background: rgba(0, 0, 0, 0.5); }
    .modal-show-detail.modal-gallegy .tieude-md-head {
      margin-top: 20px;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      display: -webkit-flex;
      /* Safari */
      display: -moz-flex;
      /* Firefox */
      display: -ms-flex;
      /* IE */
      -webkit-box-pack: start;
      -ms-flex-pack: start;
      justify-content: flex-start;
      -webkit-justify-content: flex-start;
      -moz-justify-content: flex-start;
      -ms-justify-content: flex-start;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-align-items: center;
      -moz-align-items: center;
      -ms-align-items: center; }
      .modal-show-detail.modal-gallegy .tieude-md-head .img-avt {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        display: -webkit-flex;
        /* Safari */
        display: -moz-flex;
        /* Firefox */
        display: -ms-flex;
        /* IE */
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-justify-content: center;
        -moz-justify-content: center;
        -ms-justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-align-items: center;
        -moz-align-items: center;
        -ms-align-items: center;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        border: 1px solid #ccc;
        overflow: hidden; }
  .modal-show-detail.modal-gallegy .tieude-md-head .shop-name span.pop_new_date {
        font-size: 12px;
        color: #ccc;
        clear: both; 
  }
  .modal-show-detail.modal-gallegy .ctv_gallery {
    background: #fff;
    color: #000; }

  .border-link {
    padding: 4px 10px;
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background: none;
    color: #fff;
    cursor: pointer;
  }
  .sale {
    color: #ff2462;
    font-weight: bold;
  }
  .sale .tong_gia {
    font-size: 18px;
  }
  .slick-slide img {
    display: inline-block;
  }

</style>
<main class="trangcuatoi tindoanhnghiep">    
  <section class="main-content">
    <div class="container liet-ke-hinh-anh gallery-product">
      <div class="dieuhuong">
        <div class="button-back">
          <?php 
            $link_af_id = '';
            $af_id = (isset($af) && $af != '') ? $af : $_REQUEST['af_id'];
            if ($af_id != '') {
              $link_af_id = '?af_id=' . $af_id;
            }
          ?>
          <a href="<?php echo base_url() . $product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name) . $link_af_id;?>">
            <img class="mr10" src="/templates/home/styles/images/svg/prev_bold.svg" alt=""> Quay lại
          </a>
        </div>
        <div class="sm">
          <span class="xem-dang-danh-sach js-xem-dang-danh-sach">
            <img src="/templates/home/styles/images/svg/xemluoi_on.svg" alt="">
          </span>
        </div>
      </div>
      <?php if(!empty($galleries)){?>
      <div class="product-tabs js-product-tabs">
        <ul class="nav nav-tabs">
          <?php 
          foreach ($galleries as $key => $value) { 
            if($key == 0){
              $ac = 'active';
            }else{
              $ac = '';
            }
          ?>
          <li class="">
            <a data-toggle="tab" data-key="<?php echo $key; ?>" href="#tab_<?php echo $key; ?>" class="<?php echo $ac;?>">
              <?php echo $value['name']; ?>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>   
      <div class="tab-content product-tabs-content">
        <div id="bt_<?php echo $product->pro_id; ?>">
          <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>">
          <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
          <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
          <input type="hidden" name="qty" value="<?php echo $product->pro_minsale; ?>" id="qty_min"> 
        </div>
        <?php if($af_id != ''){$af_id = '?af_id='.$af_id;} ?>
        <?php foreach ($galleries as $key => $value) { ?>
          <!-- <div class="list-slider" data-id="<?php echo $item->not_id . $random; ?>">
          <div class="slider slider-for"> -->
          <div id="tab_<?php echo $key; ?>" class="tab-pane <?php echo ($key == 0) ? 'active' : '' ?>">
            <div class="grid grid_<?php echo $key; ?> slider slider-for">
                <?php 
                  if (!empty($value['detail'])) {
                    foreach ($value['detail'] as $k => $v) {
                ?>

                <div class="item">
                  <div class="detail">
                    <a> 
                      <img data-id="<?php echo $v->id?>" data-value="<?php echo base_url().'product/gallegy/'.$product->pro_id.'/'. RemoveSign($product->pro_name).$af_id;?>" data-name="<?php echo $value['name']; ?>" data-tab="<?php echo $key ?>" data-key="<?php echo $k ?>" class="popup-detail-image" alt="" data-width="<?php echo $v->detail_w?>" data-heigth="<?php echo $v->detail_h?>" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/galleries/' . $v->img_dir . '/'. $v->link ?>" data-caption="<?php echo $v->caption; ?>">
                    </a>                    
                    <!-- <div class="text">
                       <div class="gallery-product-action">
                          <div class="like-share">
                            <a href=""><img src="/templates/home/styles/images/svg/like.svg" alt=""></a>
                            <a href=""><img src="/templates/home/styles/images/svg/share.svg" alt=""></a>
                          </div>
                          <div class="muangay"><button onclick="addGalleryCart(<?php echo $product->pro_id; ?>);">Mua ngay</button></div>
                       </div>
                     </div> -->
                  </div>
                </div>
                
                <?php } } ?>
            </div>
          </div>
        <!-- </div>
          </div> -->
          <?php } ?>
      </div>
      <?php } ?>
    </div>
  </section>
</main>
<!-- Popup thu vien anh -->
<link href="/templates/home/css/addnews-v2.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/js/addnews-preview-v2.js"></script>
<script src="/templates/home/jR3DCarousel/jR3DCarousel.js"></script>

    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/owl.carousel.js"></script>
    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/wowslider.js"></script>
    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/script.js"></script>

<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/style.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/owl.carousel.min.css" />

<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>

<?php 

$show_vol = true;
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($ua,'ipod') !== false || stripos($ua,'iphone') !== false || stripos($ua,'ipad') !== false ) {
  $show_vol = false;
}

?>

<script type="text/javascript">
jQuery(document).ready(function(){
    

});
</script>

<div class="modal modal-show-detail main-content" id="myModal2"  tabindex="-1" role="dialog" aria-hidden="true">
  <a href="" class="btn-chitiettin back mt10 mr10" data-dismiss="modal"><img class="ml00" src="/templates/home/styles/images/svg/prev.svg" alt="">&nbsp;Đóng</a>
  <div class="modal-dialog modal-lg modal-show-detail-dialog" role="document">
    <div class="modal-content container">          
      <!-- Modal body -->
      <div class="modal-body content-posts">
          <div class="row post-detail">
            <div class="col-lg-7 popup-image-sm">
              <ul class="js-shop-slider popup-galery"></ul>
            </div>
            <div class="col-lg-5 md">
            <div class="post">
              <div class="post-head">
                <div class="post-head-name">
                  <div class="avata">
                    <?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
                    <a href="<?php echo ($getshop->domain != '') ? $protocol . $getshop->domain : $protocol . $getshop->sho_link . '.' . domain_site; ?>" class="pop_shop_avatar">
                      <img class="pop_shop_img" src="<?php echo DOMAIN_CLOUDSERVER.'media/shop/logos/'.$getshop->sho_dir_logo.'/'.$getshop->sho_logo?>" alt="oppo">
                    </a>
                  </div>
                  <div class="title">
                    <a href="#" class="pop_shop_avatar">
                      <span class="pop_shop_name"><?php echo $getshop->sho_name?></span>
                      </a>
                    <br>
                    <span class="pop_new_date"><?php echo date('d/m/Y',$getshop->sho_enddate)?></span>
                    <span>
                      <img class="mr10 ml20 mt05" src="/templates/home/styles/images/svg/quadiacau.svg" width="14" alt="">
                    </span>
                    <span style="color: #737373; font-weight: normal; border-left: 1px solid #c4c4c4" class="pl10">
                      <img class="mt10" src="/templates/home/styles/images/svg/eye_gray.svg" width="16" alt=""> 8K
                    </span>
                  </div>
                </div>

                <div class="post-head-more">
                  <span>
                    <img class="icon-img" src="/templates/home/styles/images/svg/3dot.svg" alt="more">
                  </span>

                  <div class="show-more hidden">
                    <p class="save-post"><img class="icon-img" src="/templates/home/styles/images/svg/savepost.svg" alt="">Lưu bài viết</p>
                    <ul class="show-more-detail">
                      <li><a href="#">Chỉnh sửa bài viết</a></li>
                      <li><a href="#">Thay đổi ngày</a></li>
                      <li><a href="#">Tắt thông báo cho bài viết này</a></li>
                      <li><a href="#">Ẩn khỏi dòng thời gian</a></li>
                      <li><a href="#">Xóa </a></li>
                      <li><a href="#">Tắt tính năng dịch</a></li>
                      <li><a href="#">Kiểm duyệt bình luận</a></li>
                    </ul>
                  </div>
                </div>

              </div>

              <div class="info-product">
                <div class="descrip">
                  <p class="pop-descrip">
                    <!-- <span class="seemore">Xem tiếp</span> -->
                  </p>

                  <div class="hagtag"></div>
                </div>
              </div>
              <div class="action">
                <?php $this->load->view('home/share/bar-btn-share-js', array('show_bar_gallery' => 1)); ?>
                <input class="url_pro hidden" value="<?php echo base_url() . $product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name) . $link_af_id;?>" />
                <!-- <ul class="action-left-listaction">
                  <li class="like js-like-gallery" data-id="">
                    <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                  </li>

                  <li class="comment">
                    <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                  </li>
                  <li class="share">
                    <span class="share-click-image" data-toggle="modal">
                      <img class="icon-img" src="/templates/home/styles/images/svg/share_01_white.svg" alt="share">
                    </span>
                    <div class="show-more hidden">
                      <p class="show-more-social">
                        <a href="">
                          <img class="icon-img" src="/templates/home/styles/images/svg/facebook.svg" alt="">
                        </a>
                        <a href="">
                          <img class="icon-img" src="/templates/home/styles/images/svg/twister.svg" alt="">
                        </a>
                        <a href="">
                          <img class="icon-img" src="/templates/home/styles/images/svg/google.svg" alt="">
                        </a>
                      </p>
                      <p>
                        <a href="">
                          <img class="icon-img" src="/templates/home/styles/images/svg/savepost.svg" alt="">
                          Sao chép liên kết
                        </a>
                      </p>
                  </div>
                  </li>
                </ul>
                <div class="show-number-action">
                  <ul>
                    <li class="list-like-js js-show-like-gallery" data-id="">
                      <span class="count-like js-count-like"></span>
                      <span class="md">lượt thích</span>
                    </li>
                    <li>15 <span class="md">bình luận</span></li>
                    <li>5 <span class="md">chia sẻ</span></li>
                  </ul>
                  <ul class="sanpham-lienket">
                    <li><a href="">Chi tiết</a></li>
                    <li><a href=""> Liên kết</a></li>
                  </ul>

                  <a class="btn-chitiettin btn-chitiettin-js" href="<?php echo base_url() . $product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name) . $link_af_id;?>" class="btn-chitiettin mt10 mr10">Chi tiết sản phẩm <img src="/templates/home/styles/images/svg/next.svg" alt=""></a>
                 
                </div> -->
                <!-- <div class="create-new-comment">
                   <div class="avata-user"><img src="/templates/home/styles/images/default/error_image_400x400.jpg" alt=""></div>
                   <div class="area-comment"><textarea name="" id="" ></textarea></div>
                   <p class="icon-sendmess"><img class="icon-img" src="/templates/home/styles/images/svg/sendmess.svg" alt=""></p>
                   <div class="list-add-icon">
                    <button><img class="icon-img" src="/templates/home/styles/images/svg/takephoto.svg" alt=""></button>
                    <button><img class="icon-img" src="/templates/home/styles/images/svg/sticker.svg" alt=""></button>
                  </div>
                 </div>
                <div class="show-list-comments">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Cũ nhất
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    </ul>
                  </div>
                  <p class="xembinhluankhac">Xem các bình luận khác...</p>
                  <div class="comment">
                    <dl>
                      <dt><img src="/frontend/asset/images/product/avata/nikon.jpg" alt=""></dt>
                      <dd>
                        <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop.
                      </dd>
                    </dl>
                    <div class="action-comment">
                      <p><a href="">Thích</a></p>
                      <p><a href="">Trả lời</a></p>
                      <p>1giờ trước</p>
                    </div>
                  </div>
                  <div class="comment">
                    <dl>
                      <dt><img src="/frontend/asset/images/product/avata/nikon.jpg" alt=""></dt>
                      <dd>
                        <span class="name-user">nicknamdg</span>Tai nghe tốt, giá hợp lý. cảm ơn shop. Tai nghe tốt, giá hợp lý. cảm ơn shop
                      </dd>
                    </dl>
                    <div class="action-comment">
                      <p><a href="">Thích</a></p>
                      <p><a href="">Trả lời</a></p>
                      <p>1giờ trước</p>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          </div>
      </div>
      
    </div>
  </div>
  <div class="sm">
    <div class="sm tieude-sm">
      <!-- <div class="tieude-sm-head">
        <div class="avata">
          <?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
          <a href="<?php echo ($getshop->domain != '') ? $protocol . $getshop->domain : $protocol . $getshop->sho_link . '.' . domain_site; ?>" class="pop_shop_avatar">
            <img src="<?php echo DOMAIN_CLOUDSERVER.'media/shop/logos/'.$getshop->sho_dir_logo.'/'.$getshop->sho_logo?>" alt=""><?php echo $getshop->sho_name?>
          </a>
        </div>
        <div class="time">
          <span class="pop_new_date"><?php echo date('d/m/Y',$getshop->sho_enddate)?></span>
        </div>
      </div> -->
      
      <a href="<?php echo base_url() . $product->pro_category.'/'.$product->pro_id.'/'. RemoveSign($product->pro_name) . $link_af_id;?>" class="btn-chitiettin mt10 mr10">Chi tiết sản phẩm <img src="/templates/home/styles/images/svg/next.svg" alt=""></a>
    </div>
    <div class="action">
      <div class="action-left">
        <?php
        if($product->pro_saleoff == 1)  {
          if($product->pro_type_saleoff == 1) { // giảm theo %
            $sale = $product->pro_cost - ($product->pro_cost * $product->pro_saleoff_value / 100);
          } else {
            $sale = $product->pro_cost - $product->pro_saleoff_value;
          }
        }
        ?>
        <?php
        if(isset($sale)){
          $tonggia = $sale * $product->pro_minsale;
        }
        else{
          $tonggia = $product->pro_cost * $product->pro_minsale;
        }
        ?>
        
        <div class="sale">
          <strong class="dong">đ</strong>
          <span class="tong_gia">
            <?php echo number_format($tonggia, 0, ",", "."); ?>
            </span>
        </div>
        <ul class="action-left-listaction">
          <li>
            <button class="border-link" onclick="addGalleryCart(<?php echo $product->pro_id; ?>, 'checkout');">Thêm vào giỏ
            </button>
          </li>
          <li>
            <button class="border-link" onclick="addGalleryCart(<?php echo $product->pro_id; ?>, '');">Mua ngay</button>
          </li>
          <?php
          if($this->session->userdata('sessionUser') && $product->is_product_affiliate > 0){
            
            /*$afSelect = false;
            $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
            
            $gia = $product->pro_cost;
            if ($product->pro_cost > $discount['salePrice']) {
              $gia = $discount['salePrice'];
            }*/
            if($product->aff_rate > 0){
              $pthoahong = $product->aff_rate .'%';
              $hoahong = $tonggia * ($pthoahong/100);
            }else{
              $pthoahong = $product->af_amt .'đ';
              $hoahong = $pthoahong;
            }
            ?>
          <li class="ctv">
            <a href="#">
              <img class="icon-img" 
                src="/templates/home/styles/images/svg/ctv_sm.svg" data-toggle="modal" 
                data-target="#myModal_ctv" 
                data-key="<?php echo $hoahong;?>"
                data-valuea="<?php echo $product->aff_rate;?>"
                data-valueb="<?php echo $product->af_amt;?>" 
                alt="share" style="margin-top: -5px">
            </a>
          </li>
          <?php } ?>
          <li class="share-click-image" data-toggle="modal">
            <img class="icon-img" src="/templates/home/styles/images/svg/share_01_white.svg" alt="share">
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="myModal_ctv">
  <div class="modal-dialog modal-lg modal-mess ">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <?php
      $hoahong_ = 0;
      if(isset($hoahong) && $hoahong > 0){
        $hoahong_ = number_format($hoahong, 0, ",", ".");
      }
      ?>
      <!-- Modal body -->
      <div class="modal-body">
        <p>Tỉ lệ hoa hồng thông thường: <span class="tilehoahong"><?php echo $pthoahong;?></span></p>
        <b>Hoa hồng ước tính <span class="uoctinh"><?php echo $hoahong_.'đ';?></span></b>
        <p>Bằng việc chia sẻ, bạn đồng ý chấp nhận các <a href="">Quy tắc</a> của chúng tôi</p>
        <br>
        <p>Tiền hoa hồng ước tính </p>
        <div class="tien-share">
          <b><span class="uoctinh"><?php echo $hoahong_ .'đ';?></span></b>
          <label class="btn-share">
            <a href="javascript:void(0)" onclick="copylink('<?php echo azibai_url().'/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name) ?>')">Chia sẻ</a>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>

<!-- End popup thu vien anh -->
<script src="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>

<script type="text/javascript">
  var masonryOptions = {
    itemSelector: '.item',
    horizontalOrder: true
  }
  var list_grid = $('.grid');
  var list_masonry = [];
  if ($(list_grid).length > 0) {
    $.each(list_grid, function( index, value ) {
      list_masonry[index] = $('.grid_' + index).masonry( masonryOptions );
      list_masonry[index].imagesLoaded().progress( function() {
        list_masonry[index].masonry('layout');
      });   
    });
  }


  $('.js-product-tabs a[data-toggle=tab]').each(function () {
    var $this = $(this);
    var key_gallegy = $(this).attr('data-key');
    $this.on('shown.bs.tab', function () {
      list_masonry[key_gallegy].imagesLoaded().progress( function() {
          list_masonry[key_gallegy].masonry('layout');
      }); 
    });
  });


  function addGalleryCart(pro_id, checkout) {
    
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize(),
        success: function (result) {
            if (result.pro_type != 0 && result.error == false) {
                location.href = siteUrl + 'checkout/v2/' + result.pro_user + '/' + result.pro_type;
            }
            if (result.error == true) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': result.message,
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                        }
                    }
                });
            } else {
                if ($(checkout) = '') {
                  window.location = siteUrl + 'checkout';
                } else {
                  $.jAlert({
                    'title': 'Thông báo',
                    'content': result.message,
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                        }
                    }
                  });
                }
            }
        },
        error: function () {
        }
    });
}

var $grid = $('.grid').masonry( masonryOptions );
var isActive = true;

$('.js-xem-dang-danh-sach').click(function() {
  $(this).toggleClass('danhsach');
  if ($(this).hasClass('danhsach')) {
    $grid.masonry('destroy');
    $(this).find('img').attr("src","asset/images/svg/danhsach_on.svg");
    $('.liet-ke-hinh-anh').find('.grid').addClass('style-xem-dang-danh-sach');
    $('body').find('.main-content').addClass('bg-black');
  } else {
    $('.liet-ke-hinh-anh').find('.grid').removeClass('style-xem-dang-danh-sach');
    $(this).find('img').attr("src","asset/images/svg/xemluoi_on.svg");
    $grid.masonry( masonryOptions );
    $('body').find('.main-content').removeClass('bg-black');
  }
});

(function($){
  $(window).on("load",function(){
    $(".js-product-tabs").mCustomScrollbar({
      axis:"x",
      theme:"dark-thin",
      autoExpandScrollbar:true,
      advanced:{autoExpandHorizontalScroll:true}
    });
  });
})(jQuery);

$('.popup-galery').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  dots: false
  // variableWidth: true
});
function escapeSpecialChars(jsonString) {
      return jsonString
          .replace(/\n/g, "<br>")
          .replace(/\r/g, "<br>")
          .replace(/\t/g, "<br>")
          .replace(/'/g, "\\'")
          .replace(/"/g, '\\"')
          // .replace(/\f/g, "\\f");

  }

$('body').on('click', '.gallery-product .popup-detail-image', function(){
  $('.modal-show-detail').modal('show');
    var key = $(this).attr('data-key');
    var tab = $(this).attr('data-tab');
    var parent = $('#tab_'+ tab);
    var listImg = $(parent).find('img.popup-detail-image');
    var caption = $(this).attr('data-caption');
    var text_tabs = $.trim($('.gallery-product .nav-tabs a.active').text());
    $('.popup-galery').html('');
    $('.popup-galery').slick('destroy');
    var li = '';
    if (listImg.length > 0) {
      $( listImg ).each(function( index ) {
        li += '<li data-id="'+$(this).attr('data-id')+'" data-tabname="'+$(this).attr('data-tabname')+'"><div class="big-img"><img data-caption="'+escapeSpecialChars($(this).attr('data-caption'))+'" src="'+$(this).attr('src')+'"><p class="popup-galery-caption sm"><strong>'+escapeSpecialChars(text_tabs) + '</strong><br/>' +escapeSpecialChars($(this).attr('data-caption'))+'</p></div></li>';
      });

      $('.popup-galery').html(li);
      $('.popup-galery').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        dots: false,
        initialSlide: parseInt(key)
        // variableWidth: true
      });

      $('.modal-show-detail .pop-descrip').html(escapeSpecialChars(caption));
      var id_gallery = $('li.slick-current.slick-active').attr('data-id');
      var name_gallery = $('li.slick-current.slick-active').attr('data-tabname');
      var url_pro = $('.url_pro').val();
      active_like(id_gallery);
      $('a.btn-chitietsp-js').attr('href', url_pro);
      //share(id_gallery,name_gallery);
      $('.share-click-image').attr('data-id',id_gallery);
      $('.share-click-image').attr('data-name',$(this).data('name'));
      $('.share-click-image').attr('data-value',$(this).data('value'));
      $('.modal-show-detail').modal('show');
    }
});

function active_like(id_image){
  $('.action-left-listaction li.like.js-like-gallery').attr('data-id',id_image);
  $('.list-like-js').attr('data-id',id_image);
  $('.count-like').attr('class','count-like js-count-like-'+id_image);
  var _this = $('.action-left-listaction li.like.js-like-gallery');
  //add div box count like, comment, share
  $('.modal-show-detail .show-number-action.version02').addClass('js-countact-gallery-'+id_image);
  $.ajax({
    type: 'POST',
    url: urlFile +'like/active_like_gallery',
    dataType: 'json',
    data: {id_image: id_image},
    success: function(result){
      if (result.error == false)
      {
        var img_like = $(_this).find('img');
        if (result.count > 0) {
          $(img_like).attr('src', $(img_like).attr('data-like-icon'));
        }
        else
        {
          $('.col-lg-5 .js-like-gallery img').attr('src', '/templates/home/styles/images/svg/like.svg');
          $('.col-lg-7 .js-like-gallery img').attr('src', '/templates/home/styles/images/svg/like_white.svg');
          // $(img_like).attr('src', $(img_like).attr('data-notlike-icon'));
        }
      }
      $('.js-count-like-'+id_image).text(result.total);
      if(result.total == 0){
        $('.list-like-js').attr('class','list-like-js');
        $('.bg-gray-blue .show-number-action.version02').css('display',' none');
      }else{
        $('.list-like-js').attr('class','list-like-js js-show-like-gallery');
        $('.bg-gray-blue .show-number-action.version02').attr('style','');
      }
    }
  });
}

$('.popup-galery').on('afterChange', function(event, slick, currentSlide, nextSlide){
  var caption = $('.js-shop-slider .slick-current').find('img').attr("data-caption");
  $('.modal-show-detail .pop-descrip').html(caption);
  var id_gallery = $('li.slick-current.slick-active').attr('data-id');
  var name_gallery = $('li.slick-current.slick-active').attr('data-tabname');
  active_like(id_gallery);
  $('.share-click-image').attr('data-id',id_gallery);
  $('.share-click-image').attr('data-name',$(this).data('name'));
  $('.share-click-image').attr('data-value',$(this).data('value'));
  //share(id_gallery,name_gallery);
});

$('body').on('click','.back',function(){
  $('#gallery_01').removeClass();
  $('#gallery_01').addClass('slider gallery_01');
});
</script>




