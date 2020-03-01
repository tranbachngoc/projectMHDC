<?php
// dd($product);die;
// dd($product->pro_type);die;
$this->load->view('home/common/header_new');
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
$currentuser = !empty($azitab['user']) ? $azitab['user'] : '';
// if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale >= time() && $product->begin_date_sale <= time())  {
//     if($product->pro_type_saleoff == 1) { // giảm theo %
//       $sale = $product->pro_cost - ($product->pro_cost * $product->pro_saleoff_value / 100);
//     } else {
//       $sale = $product->pro_cost - $product->pro_saleoff_value;
//     }
// }
if($product->pro_minsale < 1) {//số lượng bán tối thiểu
  $product->pro_minsale = 1;
}
$giasale = $product->priceSale * $product->pro_minsale;
?>
<style type="text/css">
.sanphamchitiet-content-gallery .show-number-action.version02 {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 10px 0;
}

ul.action-left-listaction.version01 li span {
    display: none;
}
.theodoi-ctv {display: flex;align-content: center;align-items: center;}
.theodoi-ctv .is-follow-shop {
    display: flex;
    align-content: center;
    align-items: center;
}

.theodoi-ctv .is-follow-shop img {
    margin-right: 5px;
}
.hoahong-ctv {
    margin-left: 20px;
}

.button-chinh-sua.sm {
    right: 20px;
    top: 6px;
}
.sanphamchitiet-recent-slider li.item-li .image:hover .action {
    z-index: 0;
}

.sanphamchitiet-recent-slider li.item-li .image {
    text-align: center;
}
</style>
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
<!-- <script type="text/javascript" src="/templates/home/js/Image-Zoom-Hover-Magnifier/image-magnifier.js"></script> -->


<script src="/templates/home/js/general_ver2.js"></script>
<script async src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<!-- <script async src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script> -->
<script src="/templates/home/js/home_news.js"></script>
<div class="trangchitietsp">
  <main class="sanphamchitiet">      
      <section class="main-content">
        <div class="breadcrumb md">
          <div class="container">
            <ul>
              <li><a href="<?php echo base_url() . 'shop/products' ?>">Azibai</a> > </li>
              <?php if(count($category) > 0){ ?>
              <li>
                <?php
                  $cat = '';
                  for($i=count($category)-1;$i>=0; $i--){
                    $item = explode(':',$category[$i]);
                    $cat .= '<a href="'.base_url() . $item[0] . '/' . RemoveSign($item[1]).'">'.$item[1].'</a>';
                    if($i != 0 && $i != count($category)){
                      $cat .= ' > ';
                    }
                  }
                  echo $cat;
                ?>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <?php 

        if($shop->domain != ''){
          $sholink = 'http://'.$shop->domain;
        }else{
          $sholink = get_server_protocol() . $shop->sho_link.'.'.domain_site;
        }

        ?>
        <div class="container">
          <div class="info-shop">
            <div class="left">
              <!-- <div class="sm back">
                <a href="#"><img src="/templates/home/styles/images/svg/back_new.svg" onclick="goback();" alt=""></a>
              </div> -->
              <div class="logo">
                <a href="<?php echo $sholink; ?>">
                  <?php
                    $shoplogo = DOMAIN_CLOUDSERVER."images/logo-home.png";
                    if ($shop->sho_logo) {
                        $shoplogo = DOMAIN_CLOUDSERVER.'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                    }
                  ?>
                  <img src="<?php echo $shoplogo?>" alt="">
                </a>
              </div>
              <div class="name">
                <h3>
                  <a href="<?php echo $sholink; ?>"><?php echo $shop->sho_name ?></a>
                  <br>
                  <span class="hidden">Online 15 phút trước</span>
                </h3>
                <p class="md"><strong>456</strong> Người theo dõi</p>
              </div>
            </div>
            <div class="right sm">
              <?php
              if($this->session->userdata('sessionUser') && $product->is_product_affiliate > 0 && $hoahong['showIcon'] == true){ ?>
                <?php
                // $afSelect = false;
                // $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                
                // $gia = $product->pro_cost;
                // if ($product->pro_cost > $discount['salePrice']) {
                //   $gia = $discount['salePrice'];
                // }
                // if($product->aff_rate > 0){
                //   $pthoahong = $product->aff_rate;
                //   $hoahongdetail = $gia * ($pthoahong/100);
                // }else{
                //   $hoahongdetail = $product->af_amt;
                // }
                $hoahongdetail = $hoahong['hoahongaff'];
                ?>
                <div class="btn-selectsale-<?=$product->pro_id?> hidden">
                  <?php if (isset($selected_sale) && count($selected_sale) > 0) { ?>
                    <button class="btn btn-default mr10">
                      <i class="fa fa-check fa-fw"></i> Đã chọn bán
                    </button>
                  <?php } else { ?>
                    <button class="btn btn-default mr10" onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $product->pro_id; ?>);">
                        <i class="fa fa-check fa-fw"></i> Chọn bán
                    </button>
                  <?php } ?>
                </div>
                <a href="#javascript:void();" class="cart">
                  <img src="/templates/home/styles/images/svg/ctv_sm.svg"
                  class="img-popup-ctv-qc"
                  data-toggle="modal" data-target="#myModal_ctv_<?php echo $product->pro_id; ?>"
                  data-url="<?php echo base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af_key; ?>"
                  data-product="<?php echo $product->pro_id; ?>"
                  data-key="<?php echo $hoahongdetail;?>"
                  data-valuea="<?php echo $product->aff_rate;?>"
                  data-valueb="<?php echo $product->af_amt;?>" alt="">
                </a>
              <?php } ?>
              <!-- <div class="cart"> -->
                <!-- <a href="<?php echo azibai_url().'/checkout' ?>" class="cart">
                  <img src="/templates/home/styles/images/svg/cartpink.svg" alt="">
                  <span class="num cartNum"><?php echo $azitab['cart_num']; ?></span>
                </a> -->
                <a href="" data-toggle="modal" data-target="#myModal_menu">
                  <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
                </a>
              <!-- </div> -->
            </div>
            <div class="right md">
              <div class="theodoi-ctv">
              <?php
                if($follow == 1){
                    $isFollow = '';
                    $noFollow = ' hidden';
                }else{
                    $isFollow = ' hidden';
                    $noFollow = '';
                }
                if ($product->sho_user != $this->session->userdata('sessionUser')) {
                ?>
                <div class="cursor-pointer isFollow-<?php echo $shop->sho_id; ?><?php echo $isFollow;?>">
                    <div class="new-deatail-follow cancel-follow-shop" data-id="<?php echo $shop->sho_id; ?>">
                        <img src="<?=base_url()?>templates/home/styles/images/svg/dangtheodoi.svg">
                        <span><strong>Đang theo dõi</strong></span>
                    </div>
                </div>
                <div class="cursor-pointer noFollow-<?php echo $shop->sho_id; ?><?php echo $noFollow;?>">
                    <div class="new-deatail-follow is-follow-shop" data-id="<?php echo $shop->sho_id; ?>">
                        <img src="<?=base_url()?>templates/home/styles/images/svg/theodoi.svg">
                        <span><strong>Theo dõi</strong></span>
                    </div>
                </div>
                <?php } ?>
              <div class="hoahong-ctv">
                <?php $this->load->view('home/common/temp_hoahong', array('item' => $product, 'af_id' => $_REQUEST['af_id'])); ?>
              </div>
            </div>
              <ul class="sanpham-danhgia">
                <li><span>29</span><br>Sản phẩm</li>
                <li><span>4.5</span><br>Đánh giá</li>
              </ul>
            </div>
          </div>
          <div class="sanphamchitiet-content box-detailpro row content-posts">
            <div class="col-md-5">
              <?php if ($this->session->userdata('sessionUser') == $product->pro_user) : ?>
                  <div class="button-chinh-sua sm hidden">
                      <?php
                      if($product->pro_type == 2)
                      {
                        $urlEdit = base_url().'coupon/edit/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                      }
                      else{
                        $urlEdit = base_url().'product/edit/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                      }
                      ?>
                        <a href="<?php echo $urlEdit ?>"
                         target="_blank">
                          <img src="/templates/home/styles/images/svg/pen.svg" alt="">Chỉnh sửa
                      </a>
                  </div>
              <?php endif; ?>

              <div class="sanphamchitiet-content-gallery">
                <div class="show-photo">
                  <div class="show-photo-nav list-slider" data-id="333">
                    <ul class="slider gallery_01"><!-- slider-for   id="slider-for_333"-->
                    <?php 
                        $pro_image = explode(',', $product->pro_image);
                        if(isset($arr_dp_image) && !empty($arr_dp_image)){
                          $pro_image = $arr_dp_image;
                        }
                        foreach ($pro_image as $key => $value) {
                          $class_act = '';
                          $class_tqc = $text_qc = $id_qc = '';
                          if($key == 0){
                            $class_act = 'class="is-active"';
                          }
                          $id_qc = $arr_dp[$key]['id'];
                          if(isset($arr_dp) && !empty($arr_dp)){
                            $class_tqc = $arr_dp[$key]['type'];
                            if(isset($arr_dp[$key]['color'])){
                              $color = $arr_dp[$key]['color'];
                            }
                            if(isset($arr_dp[$key]['size'])){
                              $size = $arr_dp[$key]['size'];
                            }
                            if(isset($arr_dp[$key]['material'])){
                              $material = $arr_dp[$key]['material'];
                            }
                          }
                        ?>
                      <li class="" data-dp1="<?php echo $color;?>" data-dp2="<?php echo $size;?>" data-dp3="<?php echo $material;?>">
                        <a data-image="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . $value;?>" data-zoom-image="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . $value;?>" <?php echo $class_act; ?>>
                            <img src="<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/' . $value;?>" alt="" data-tab="<?php echo $key ?>" data-key="<?php echo $key ?>" class="popup-detail-image" alt="">              
                        </a>
                      </li>
                      <?php } ?>
                    </ul>
                    <div class="slider_sm sm"></div>
                    <div class="btn-video-img">
                    <?php if(!empty($product->pro_video)) { ?>
                      <p class="video-img video">
                        <a href="#" style="border:none;" class="" data-id="<?php echo $product->pro_id ?>" data-toggle="modal" data-target="#videopopup">
                          <img src="/templates/home/styles/images/svg/pause.svg" class="" alt=""><label class="sm">Video</label>
                        </a>
                      </p>
                    <?php } ?>
                    <!-- <p class="sizeguide">SIZE GUIDE</p> -->
                      
                      <!-- <p class="video sm click-show-img hidden">
                        <img src="/templates/home/styles/images/svg/img.svg" alt="">
                        HÌNH ẢNH
                      </p> -->

                      <?php 
                      if (!empty($cate_galleries)){
                          $link_af_id = '';
                          if ($af_id != '') {
                            $link_af_id = '?af_id=' . $af_id;
                          }
                      ?>
                        <p class="video-img video">
                          <a href="<?php echo base_url() . 'product/gallegy/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $link_af_id; ?>">
                          <img src="/templates/home/styles/images/svg/thuvienanh.svg" class="" alt=""><label class="sm">Thư viện ảnh</label>
                        </a>
                      </p>
                      <?php } ?>
                    </div>
                  </div>
                  <?php
                  $img_pro = $pro_image[0];
                  if(isset($arr_dp_image) && !empty($arr_dp_image)){
                    $img_pro = $arr_dp_image[0];
                  }
                  ?>
                  <div class="show-photo-main">
                    <img id="zoom_03" src="<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/' . $img_pro;?>" data-zoom-image="<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/' . $img_pro;?>" alt="">
                  </div>
                </div>
                <div class="show-info-product">
                  <div class="action">
                    <?php
                      $data_textlike = '';
                      if (!empty($product->is_like)) {
                        $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg" >';
                        $data_textlike = 'Bỏ thích';
                      }
                      else{
                        $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">';
                      }
                      $check_bookmark = 0;
                      if($this->session->userdata('sessionUser')) {
                        $check_bookmark = 1;
                        // if (!empty()) {
                          // $imgBookmark = '<img class="icon-img" src="/templates/home/styles/images/svg/bookmark_gray.svg" alt="bookmark"';
                        // }
                        // else{
                          $imgBookmark = '<img class="icon-img" src="/templates/home/styles/images/svg/bookmark.svg" alt="bookmark">';
                        // }
                      }
                      

                      $show_product = '';
                      $numlike = 0;
                      if(!empty($product->likes))
                      {
                         $numlike = $product->likes;
                          $show_product = ' js-show-like-product';
                      }

                      $arr = array(
                        'data_backwhite' => 1,
                        'data_shr' => 1,
                        'data_class_countact' => 'js-countact-product-'.$product->pro_id,
                        'data_jsclass' => 'js-like-product js-like-product-'.$product->pro_id,
                        'data_classshow' => $show_product,
                        'data_url' => base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name)."?af_id=".$af_id,
                        'data_title' => $product->pro_name,
                        'data_id' => $product->pro_id,
                        'data_imglike' => $imgLike,
                        'data_numlike' => $numlike,
                        'data_lishare' => 1,
                        'data_textlike' => $data_textlike,
                        'data_bookmark' => $check_bookmark,
                        'data_imgBookmark' => $imgBookmark,
                        'data_user' => $product->pro_user,
                        'data_typeshare' => $type_share
                      );

                      $this->load->view('home/share/bar-btn-share', $arr);
                      ?>
                  </div>
                  <?php

                  // if(isset($sale)){
                  //   $giasale = $sale * $product->pro_minsale;
                  // }
                  // else{
                  //   $giasale = $product->pro_cost * $product->pro_minsale;
                  // }
                  if($_REQUEST['af_id'] != ''){
                    // if($product->is_product_affiliate == 1){
                    //   if($product->af_dc_rate > 0){
                    //     $giasale = $giasale*(1-($product->af_dc_rate/100));
                    //   }else{
                    //     $giasale = $giasale - $product->af_dc_amt;
                    //   }
                    // }
                  ?>

                  <input class="af_dc_rate" type="hidden" value="<?php echo $product->af_dc_rate; ?>">
                  <input class="af_dc_amt" type="hidden" value="<?php echo $product->af_dc_amt; ?>">
                  <?php } ?>
                  <div class="add-minus-product md" id="bt_<?php echo $product->pro_id; ?>">
                    <p>Số lượng</p>
                    <div class="add-form">
                      <button type="button" id="sub" class="sub">-</button>
                      <input type="number" id="qty_<?php echo $product->pro_id; ?>" value="<?php echo $product->pro_minsale; ?>" min="1" max="3"/>
                      <button type="button" id="add" class="add">+</button>
                      <input type="hidden" class="proprice" value="<?php echo $giasale; ?>"/>
                    </div>
                    <p><span class="pro_number"><?php echo $product->pro_instock;?></span> sản phẩm có sẵn</p>
                  </div>
                  <div class="button-buy-product md">
                    <p class="alert-warning">Chọn mua ít nhất: <?php echo $product->pro_minsale?> sản phẩm</p>
                    <div class="sum-price">Tổng giá: <span><span class="dong">đ</span><span class="tong_gia"><?php echo number_format($giasale, 0, ",", "."); ?></span></span></div>
                    <p>*Phụ thuộc vào thuộc tính của sản phẩm bạn chọn</p>
                    <div class="buttons-group">
                      <button class="btn-bg-white" onclick="addCartQty(<?php echo $product->pro_id; ?>);">Thêm vào giỏ</button>
                      <button class="btn-bg-gray" onclick="buyNowQty(<?php echo $product->pro_id; ?>,<?=$product->pro_type?>);">Mua ngay</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <?php if ($this->session->userdata('sessionUser') == $product->pro_user) : ?>
                  <div class="button-chinh-sua md">
                      <?php
                      if($product->pro_type == 2)
                      {
                        $urlEdit = base_url().'coupon/edit/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                      }
                      else{
                        $urlEdit = base_url().'product/edit/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
                      }
                      ?>
                      <a href="<?php echo $urlEdit ?>"
                         target="_blank">
                          <img src="/templates/home/styles/images/svg/pen.svg" alt="">Chỉnh sửa
                      </a>
                  </div>
              <?php endif; ?>
              <div class="sanphamchitiet-content-detail">
                <?php if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale >= time() && $product->begin_date_sale <= time())  { ?> 
                <div class="flash-sale product-detail"><img src="/templates/home/styles/images/svg/flashsale_pink.svg" alt=""><span class="time-flash-sale" id="flash-sale_0">
                  <script>cd_time(<?php echo $product->end_date_sale * 1000 ; ?>,0);</script>
                </span></div>
                <?php } ?>
                <h3 class="tit"><?php echo $product->pro_name;?></h3>
                <p class="small-text"><span>Thương hiệu: <?php echo $product->pro_brand;?></span><span>Mã sản phẩm: <?php echo $product->pro_sku;?></span></p>
                <ul class="list-number" data-id="<?php echo $product->pro_id; ?>">
                  <li><img src="/templates/home/styles/images/svg/gioxach.svg" width="11" alt=""><?php echo $product->pro_buy; ?></li>
                  <li><img src="/templates/home/styles/images/svg/eyes.svg" width="15" alt=""><?php echo $product->pro_view; ?></li>
                  <?php
                  if($this->session->userdata('sessionUser') && $this->session->userdata('sessionUser') != $product->pro_user)
                  {
                  ?>
                  <li>
                    <?php
                    if(!empty($is_report))
                    {
                    ?>
                      <img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt=""><span class="baocao">Đã báo cáo</span>
                    <?php
                    }
                    else
                    {
                      ?>
                      <a href="#" style="border:none;" class="report-popup" data-rpd_type="2" data-toggle="modal" data-target="#reportpopup">
                        <img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt=""><span class="baocao">Báo cáo</span>
                      </a>
                      <?php
                    }
                    ?>
                  </li>
                  <?php
                  }
                  ?>
                </ul>
                <?php
                if($product->pro_saleoff == 1 && $product->end_date_sale > strtotime(date("Y-m-d"))) {
                  $giagoc = $product->pro_cost * $product->pro_minsale;
                ?>
                <div class="price">
                  <div class="no-sale md"><strong class="dong">đ</strong><span class="giagoc"><?php echo number_format( ($giagoc), 0, ",", "."); ?></span></div>
                  <div class="sale"><strong class="dong">đ</strong><span class="tong_gia"><?php echo number_format( $giasale, 0, ",", "."); ?></span></div>
                  <p class="donvi"><?php echo $product->pro_unit; ?></p>
                  <lable class="note-uudai sm">*Giá ưu đãi cho thành viên</lable>
                  <div class="no-sale sm"><strong class="dong">đ</strong><span class="giagoc"><?php echo number_format( ($giagoc), 0, ",", "."); ?></span></div>
                </div>
                <?php } else {
                ?>
                <div class="price">
                  <div class="sale"><strong class="dong">đ</strong><span class="tong_gia"><?php echo number_format( $giasale , 0, ",", "."); ?></span></div>
                  <p><?php echo $product->pro_unit; ?></p>
                </div>
                <?php } ?>
                <?php
                if(count($promotions) > 0){
                ?>
                <div class="gia-uu-dai" data-toggle="modal" data-target="#muasi">
                  <img src="/templates/home/styles/images/svg/dola_den.svg" class="mr10" alt="">
                    Giá ưu đãi khi mua số lượng
                </div>
                <?php } ?>
                <?php if( isset($list_style) ) { ?>
                <div class="thongso clearfix mt15" id="thongso">
                  <?php if( !in_array('',$ar_color) && count($ar_color) > 0){?>
                  <dl id="dp_color">

                    <dt>
                      <div>
                        <span class="dot md">&#9679;</span> 
                        <span class="txt_color">Màu sắc</span>
                      </div>
                      <span class="dot sm">
                        <img class="menu-drop" src="/templates/home/styles/images/svg/up.svg">
                      </span>
                    </dt>
                    <dd>
                      <ul class="buttons">
                        <?php foreach ($ar_color as $key => $value) { ?>
                          <li class="tqc1 <?php if($value == $product_check_TQC->dp_color) echo 'is-active' ?> tqc1_<?php echo $product_check_TQC->id; ?>" data-id="<?php echo $product_check_TQC->id; ?>"><?php echo $value; ?></li>
                        <?php } ?>
                      </ul>
                    </dd>
                  </dl>
                  <?php }?>
                  <?php if( !in_array('',$ar_size) ){?>
                  <dl id="dp_size">
                    <dt>
                      <div>
                        <span class="dot md">&#9679;</span> 
                        <span class="txt_size">Kích thước</span>
                      </div>
                      <span class="dot sm">
                        <img class="menu-drop" src="/templates/home/styles/images/svg/up.svg">
                      </span>
                    </dt>
                    <dd>
                      <ul class="buttons">
                        <?php foreach ($ar_size as $key => $value) { ?>
                          <li class="tqc2 <?php if($value == $product_check_TQC->dp_size) echo 'is-active' ?> tqc2_<?php echo $product_check_TQC->id; ?>" data-id="<?php echo $product_check_TQC->id; ?>"><?php echo $value; ?></li>
                        <?php } ?>
                        <!-- <li class="is-active">S</li>
                        <li>M</li> -->
                      </ul>
                    </dd>
                  </dl>
                  <?php }?>
                  <?php if( !in_array('',$ar_material) ){?>
                  <dl id="dp_meterial">
                    <dt>
                      <div>
                        <span class="dot md">&#9679;</span> 
                        <span class="txt_material">Chất liệu</span>
                      </div>
                      <span class="dot sm">
                        <img class="menu-drop" src="/templates/home/styles/images/svg/up.svg">
                      </span>
                    </dt>
                    <dd>
                      <ul class="buttons">
                        <?php foreach ($ar_material as $key => $value) { ?>
                          <li class="tqc3 <?php if($value == $product_check_TQC->dp_material) echo 'is-active' ?> tqc3_<?php echo $product_check_TQC->id; ?>" data-id="<?php echo $product_check_TQC->id; ?>"><?php echo $value; ?></li>
                        <?php } ?>
                        <!-- <li class="is-active">Voan</li>
                        <li>Cotton</li> -->
                      </ul>
                    </dd>
                  </dl>
                  <?php }?>
                </div>
                <?php } ?>
                <div class="show-info-product ml00 mb20 sm">
                  <div class="add-minus-product pl10" id="bt_<?php echo $product->pro_id; ?>">
                    <p class="sl">Số lượng</p>
                    <div class="add-form">
                      <button type="button" id="sub" class="sub">-</button>
                      <input type="number" id="qty_<?php echo $product->pro_id; ?>" value="<?php echo $product->pro_minsale; ?>" min="1" max="3"/>
                      <button type="button" id="add" class="add">+</button>
                    </div>
                    <p class="sanco"><span class="pro_number"><?php echo $product->pro_instock; ?></span> có sẵn</p>
                  </div>
                  <!-- <div class="button-buy-product sm">
                    <div class="buttons-group">
                      <button class="btn-bg-white" onclick="addCartQty(<?php echo $product->pro_id; ?>);">Thêm vào giỏ</button>
                      <button class="btn-bg-gray" onclick="buyNowQty(<?php echo $product->pro_id; ?>,<?=$product->pro_type?>);">Mua ngay</button>
                    </div>
                  </div> -->
                </div>
                <div class="thong-tin-cua-hang">
                  <div class="title">
                    <h3>THÔNG TIN CỬA HÀNG</h3>
                    <ul class="right">
                      <li><img src="/templates/home/styles/images/svg/shop.svg" width="24" alt="Cửa hàng azibai "><span class="md">
                        <?php // echo $shop->sho_name ?></span></li>
                      <li><a href="tel:<?php echo $shop->sho_mobile ?>"><img src="/templates/home/styles/images/svg/tel.svg" width="15" alt=""></a></li>
                      <li class="md"><img src="/templates/home/styles/images/svg/message.svg" width="15" alt=""></li>
                    </ul>
                  </div>
                  <ul class="sanpham-danhgia sm">
                    <li><span>456</span><br>Người theo dõi</li>
                    <li><span>29</span><br>Sản phẩm</li>
                    <li><span>4.5</span><br>Đánh giá</li>
                  </ul>
                  <div class="info">
                    <?php 
                    if($product->pro_type == COUPON_TYPE) {
                    $condition = json_decode($product->condition_use, true);?>
                    <div class="item">
                      <h4>Điều kiện sử dụng dịch vụ</h4>
                      <table class="table01">
                        <?php if(@$condition['time'] > 0) { ?>
                        <tr>
                          <th>Thời gian hiệu lực:</th>
                          <td>
                            <?=$condition['time']?> ngày
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(@$condition['duration'] > 0 && @$condition['type_duration'] > 0) { 
                          $text_duration = [
                            1 => "năm",
                            2 => "tháng",
                            3 => "ngày",
                            4 => "giờ",
                          ];
                          ?>
                        <tr>
                          <th>Thời lượng dịch vụ:</th>
                          <td>
                            <?=$condition['duration'] . " " . $text_duration[$condition['type_duration']]?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(@$condition['not_apply'] != "") { ?>
                        <tr>
                          <th>Không áp dụng:</th>
                          <td>
                            <?=$condition['not_apply']?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(@$condition['apply'] != "") { ?>
                        <tr>
                          <th>Áp dụng:</th>
                          <td>
                            <?=$condition['apply']?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(count(@$condition['address']) > 0) {?>
                        <tr>
                          <th style="vertical-align: text-top;">Địa chỉ sử dụng:</th>
                          <td><ul>
                          <?php foreach ($condition['address'] as $_k => $_txt) { ?>
                            <li>- <?=$_txt?></li>
                          <?php } ?>
                          </ul></td>
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                    <?php } ?>
                    <div class="item">
                      <h4>Thông tin sản phẩm</h4>
                      <table class="table01">
                        <?php if(count($category) > 0 ) {
                        ?>
                        <tr>
                          <th>Danh mục</th>
                          <td>
                          <?php
                            echo $cat;
                          ?>
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php if($product->pro_vat) { ?>
                        <tr>
                          <th>VAT</th>
                          <td>
                            <?php
                              if ($product->pro_vat == 0)
                                echo "Chưa cập nhật";
                              if ($product->pro_vat == 1)
                                echo "Đã có VAT";
                              if ($product->pro_vat == 2)
                                echo "Chưa có VAT";
                            ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if($product->pro_quality) { ?>
                        <tr>
                          <th>Tình trạng</th>
                          <td>
                            <?php
                              if ($product->pro_quality == -1)
                                echo "Chưa cập nhật";
                              if ($product->pro_quality == 0)
                                echo "Mới";
                              if ($product->pro_quality == 1)
                                echo "Cũ";
                            ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if($product->pro_made_from) { ?>
                        <tr>
                          <th>Xuất xứ</th>
                          <td>
                            <?php
                              if ($product->pro_made_from == 0)
                                echo "Chưa cập nhật";
                              if ($product->pro_made_from == 1)
                                echo "Chính hãng";
                              if ($product->pro_made_from == 2)
                                echo "Xách tay";
                              if ($product->pro_made_from == 3)
                                echo "Hàng công ty";
                            ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if (Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id) != '' && $product->pro_type == 0) { ?>
                        <tr>
                          <th>Nhà sản xuất</th>
                          <td><?php echo Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id); ?></td>
                        </tr>
                        <?php } ?>
                        <?php if($product->pro_made_in) { ?>
                        <tr>
                          <th>Sản xuất tại</th>
                          <td>
                            <?php echo $product->pro_made_in;?>
                          </td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <th>Bảo hành</th>
                          <td>
                            <?php
                              if ($product->pro_warranty_period == 0) {
                                  echo "Không bảo hành";
                              } else {
                                  echo $product->pro_warranty_period . " tháng";
                              }
                            ?>
                          </td>
                        </tr>
                        <?php if($product->pro_protection) { ?>
                        <tr>
                          <th>Bảo hộ người mua</th>
                          <td><?php if($product->pro_protection == 1) echo 'Có'; else echo 'Không';?> <img src="/templates/home/styles/images/svg/icon_question.svg" alt=""></td>
                        </tr>
                        <?php } ?>
                      </table>
                    </div>
                    <?php
                      if(!empty($product->pro_specification) && $product->pro_specification != 'null') { 
                    ?>
                    <div class="item">
                      <h4>Đặc điểm kỹ thuật</h4>
                      <table class="table01 table02">
                        <?php 
                            $pro_specification = json_decode($product->pro_specification);
                            foreach ($pro_specification as $key => $value) {
                        ?>
                        <tr>
                          <th><?php echo $value[0]; ?></th>
                          <td><?php echo $value[1]; ?></td>
                        </tr>
                        <?php } ?>             
                      </table>
                    </div>
                  <?php } ?>
                    <div class="item">
                      <h4>Mô tả chi tiết</h4>
                      <div class="content-pro" id="content-pro">
                      <?php
                        $vovel = array("&curren;");
                        echo html_entity_decode(str_replace($vovel, "#", $product->pro_detail));
                      ?>
                      </div>
                      <!-- <ul class="mo-ta-chi-tiet"> -->
                        <?php //echo $product->pro_detail; ?>
                        <!-- <li><span class="dot">&#9679;</span>Lợi ích</li>
                        <li><span class="dot">&#9679;</span>Bảo hành - bảo quản</li>
                        <li><span class="dot">&#9679;</span>Khác biệt</li>
                        <li><span class="dot">&#9679;</span>Chứng nhận</li>
                        <li><span class="dot">&#9679;</span>Kết quả sản phẩm</li>
                        <li><span class="dot">&#9679;</span>Hướng dẫn sử dụng</li> -->
                      <!-- </ul> -->
                    </div>
                  </div>
                </div>
                <div class="fix-thieudiv-1">
                  <?php if($product->pro_attach != 'null' && $product->pro_attach != null) {?>
                  <div class="san-pham-mua-kem">
                    <h3>Sản phẩm thường mua kèm</h3>
                    <div class="san-pham-mua-kem-slider">
                      <?php foreach ($product_attached as $key => $value) {
                      $img_name = explode(',', $value->pro_image)[0];
                      $pro_price = ($value->hoahong['price_aff'] > 0) ? $value->hoahong['price_aff'] : $value->hoahong['priceSaleOff'];
                      ?>
                      <div class="item">
                        <div class="image">
                          <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/thumbnail_3_' . $img_name ?>" alt="">
                          <div class="check">
                            <label class="checkbox-style">
                            <input type="checkbox" name="pro_attach_list" value="<?php echo $value->pro_id ?>"><span></span>
                            </label>
                          </div>

                        </div>
                        <div class="text">
                          <div class="tit"><?php $value->pro_name ?></div>
                          <?php
                          // if($value->pro_saleoff == 1)  {
                          //     if($value->pro_type_saleoff == 1) { // giảm theo %
                          //       $value->pro_cost = $value->pro_cost - ($value->pro_cost * $value->pro_saleoff_value / 100);
                          //     } else {
                          //       $value->pro_cost = $value->pro_cost - $value->pro_saleoff_value;
                          //     }
                          // }
                          ?>
                          <div class="price"><span class="dong">đ</span><?php echo number_format($value->pro_cost, 0, ",", "."); ?></div>
                          <?php
                          if ($value->have_num_tqc > 0)
                          {
                          ?>
                            <span class="price-sale">Sản phẩm giá theo lựa chọn</span>
                          <?php
                          }
                          else
                          {
                          ?>
                              <div class="price"><span class="dong">đ</span><?php echo number_format($value->pro_cost, 0, ",", "."); ?></div>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="buttons-group" style="display:none;" id="attach_pro"><button class="btn-bg-gray" type="button" onclick="add_cart_attach()">Thêm vào giỏ</button></div>
                  <?php } ?>
                  
                  <?php // $this->load->view('home/product/module_rate_customer', $data); ?>
                  <!-- <div class="comment-customer <?php echo (ENVIRONMENT == 'development')? '':'hidden'; ?> ">
                    <div class="product-customer">
                      <div class="product-customer-title">
                        <h3>Khách hàng nhận xét</h3>
                        <div class="show-number md">
                          <span>4/5</span><br>(1028 nhận xét)
                        </div>
                        <div class="show-number-sm sm">
                          <p class="rating"><span>4/5</span><br>
                            <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                            <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                            <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                            <img src="/templates/home/styles/images/svg/favorite.svg" alt="">
                          </p>
                          <p>
                            <span>18</span><br>Đơn đặt hàng
                          </p>
                          <p>
                            <span>18</span><br>Lượt xem
                          </p>
                        </div>
                        <div class="product-customer-comment tablet mt20">
                          <button><a href="#" style="border:none;" class="nhanxet" data-id="" data-toggle="modal" data-target="#nhanxetpopup">Viết nhận xét</a></button>
                        </div>
                      </div>
                      <div class="product-customer-rating md">
                        <div class="item rate-5">
                            <span class="rating-num">5 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 100%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="item rate-4">
                            <span class="rating-num">4 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 80%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="rating-num-total"></span>
                        </div>
                        <div class="item rate-3">
                            <span class="rating-num">3 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 50%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="rating-num-total"></span>
                        </div>
                        <div class="item rate-2">
                            <span class="rating-num">2 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 40%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="rating-num-total"></span>
                        </div>
                        <div class="item rate-1">
                            <span class="rating-num">1 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" style="width: 10%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <span class="rating-num-total"></span>
                        </div>
                      </div>
                      <div class="product-customer-comment tablet-none">
                        <button><a href="#" style="border:none;" class="nhanxet" data-id="" data-toggle="modal" data-target="#nhanxetpopup">Viết nhận xét</a></button>
                      </div>
                    </div>
                    <div class="product-review-content">
                      <div class="review-filter">
                        <p>Chọn xem nhận xét</p>
                        <div class="select-by">
                          Tiêu chí
                          <select name="" id="">
                            <option value="">Giá cả</option>
                            <option value="">Giá cả</option>
                            <option value="">Giá cả</option>
                            <option value="">Giá cả</option>
                          </select>
                        </div>
                      </div>
                      <div class="review-list">
                        <div class="item">
                          <div class="avata"><img src="/templates/home/styles/images/product/avata/mi.svg" alt=""></div>
                          <div class="info">
                            <p class="name">thaoxuxu0878</p>
                            <div class="rating">5 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></div>
                            <div class="comment">Đóng gói sản phẩm đẹp. rất đáng tiền. sản phẩm giao nhanh.</div>
                            <div class="time">2018-11-05&#12288;19:28
                              <span class="border-left">đã mua hàng</span>
                              <span class="like">2<img src="/templates/home/styles/images/svg/like.svg" width="15" alt=""></span>
                              <span class="like">1<img src="/templates/home/styles/images/svg/comment.svg" width="15" alt=""></span>
                            </div>
                          </div>                    
                        </div>
                        <div class="item">
                          <div class="avata"><img src="/templates/home/styles/images/product/avata/mi.svg" alt=""></div>
                          <div class="info">
                            <p class="name">thaoxuxu0878</p>
                            <div class="rating">5 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></div>
                            <div class="comment"></div>
                            <div class="time">2018-11-05&#12288;19:28
                              <span class="border-left">đã mua hàng</span>
                              <span class="like">2<img src="/templates/home/styles/images/svg/like.svg" width="15" alt=""></span>
                              <span class="like">1<img src="/templates/home/styles/images/svg/comment.svg" width="15" alt=""></span>
                            </div>
                          </div>                    
                        </div>
                        <div class="item">
                          <div class="avata"><img src="/templates/home/styles/images/product/avata/mi.svg" alt=""></div>
                          <div class="info">
                            <p class="name">thaoxuxu0878</p>
                            <div class="rating">5 <img src="/templates/home/styles/images/svg/favorite.svg" width="15" class="ml05" alt=""></div>
                            <div class="comment">Đóng gói sản phẩm đẹp. rất đáng tiền. sản phẩm giao nhanh.</div>
                            <div class="time">2018-11-05&#12288;19:28
                              <span class="border-left">đã mua hàng</span>
                              <span class="like">2<img src="/templates/home/styles/images/svg/like.svg" width="15" alt=""></span>
                              <span class="like">1<img src="/templates/home/styles/images/svg/comment.svg" width="15" alt=""></span>
                            </div>
                          </div>                    
                        </div>
                      </div>
                    </div>
                  </div>

                  <nav class="nav-pagination <?php echo (ENVIRONMENT == 'development')? '':'hidden'; ?>">
                    <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <img src="/templates/home/styles/images/svg/prev.svg" width="10" alt="">
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <img src="/templates/home/styles/images/svg/next.svg" width="10" alt="">
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav> -->

                </div> 
              </div>
            </div>
          </div>

          <div class="fix-thieudiv-2">
            <?php
            if(!empty($product->pro_video)) {
              function determineVideoUrlType($url) {
                $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
                $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);
                $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
                $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);
                //Then we want the video id which is:
                if($has_match_youtube) {
                    $video_id = $yt_matches[5]; 
                    $type = 'youtube';
                }
                elseif($has_match_vimeo) {
                    $video_id = $vm_matches[5];
                    $type = 'vimeo';
                }
                else {
                    $video_id = DOMAIN_CLOUDSERVER . $url;
                    $type = 'azibai';
                }
                $data['video_id'] = $video_id;
                $data['video_type'] = $type;

                return $data;
              }


              $video_check = determineVideoUrlType($product->pro_video);
              $link_iframe = '';
              if ($video_check['video_type'] == 'youtube') 
              {
                $link_iframe = 'https://www.youtube.com/embed/'.$video_check['video_id'];
              } 
              else if ($video_check['video_type'] == 'vimeo') 
              {
                $link_iframe = 'https://player.vimeo.com/video/'.$video_check['video_id'];
              }
            ?>
            <div class="modal" id="videopopup" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body" id="iframevideo">
                  <?php if ($video_check['video_type'] == 'azibai') { ?>
                  <video style="max-width: 100%; height: auto;" class="video-js videoautoplay popup-detail-video vjs-custom-skin vjs-16-9" muted="muted" autoplay controls>
                    <source src="<?php echo $video_check['video_id']; ?>" type="video/mp4">
                    Your browser does not support HTML5 video.
                  </video>
                  <?php } else { ?>
                  <p>Đang load video vui lòng chờ...</p>
                  <iframe id="iframe-video" width="" height="" src="<?php echo $link_iframe ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php if (count($productShop) > 0) { ?>
            <div class="sanphamchitiet-recent">
              <div class="sanphamchitiet-recent-title">
                <h3>SẢN PHẨM LIÊN QUAN</h3>
                <?php
                  $idDiv = 1;
                  $shop_link = shop_url($productShop[0]);
                  // if($productShop[0]->domain != ''){
                  //   $shop_link = $productShop[0]->domain;
                  // }else{
                  //   $shop_link = $productShop[0]->sho_link.'.'.domain_site;
                  // }
                ?>
                <a href="<?php echo $shop_link; ?>">Xem tất cả</a>
              </div>
              <div class="sanphamchitiet-recent-slider">
                <ul class="slider recent-slider">
                  <?php
                  $idDiv = 1;
                  foreach ($productShop as $item_pro) {
                    $afSelect = false;
                    $discount = lkvUtil::buildPrice($item_pro, $this->session->userdata('sessionGroup'), $afSelect);
                    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$item_pro->pro_dir.'/thumbnail_2_'. explode(',', $item_pro->pro_image)[0];

                    $link = '/'.$item_pro->pro_category.'/'.$item_pro->pro_id.'/'.RemoveSign($item_pro->pro_name)."?af_id=".$af_id;
                    $gia = $item_pro->pro_cost;
                    if ($item_pro->pro_cost > $discount['salePrice']) {
                      $gia = $discount['salePrice'];
                    }
                  ?>
                      
                  <li class="item-li">
                    <div class="image">
                      <a class="btn btn-default" href="<?php echo $link; ?>" title="<?php echo $item_pro->pro_name; ?>" alt="<?php echo $item_pro->pro_name; ?>">
                        <img src="<?php echo $filename; ?>" alt="" class="sp">
                      </a>
                      <div class="ctv-flash">
                        <?php $this->load->view('home/common/temp_hoahong', array('item' => $item_pro)); ?>
                        <?php
                        if ($this->session->userdata('sessionUser') && $item_pro->is_product_affiliate == 1)
                        {
                          ?>
                        <span class="ctv" style="z-index:3">
                        <?php
                        if($item_pro->aff_rate > 0){
                          $pthoahong = $item_pro->aff_rate;
                          $hoahong = $gia * ($pthoahong/100);
                        }else{
                          $hoahong = $item_pro->af_amt;
                        }
                        if ($item_pro->have_num_tqc > 0) {
                          $hoahong = '';
                        }
                        ?>
                          <!-- <div class="btn-selectsale-<?=$item_pro->pro_id?> hidden">
                            <?php if (isset($selected_sale_arr)) { ?>
                              <?php if ($selected_sale_arr[$item_pro->pro_id] > 0) { ?>
                              <button class="btn btn-default mr10">
                                <i class="fa fa-check fa-fw"></i> Đã chọn bán
                              </button>
                            <?php } else { ?>
                                <button class="btn btn-default mr10" onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $item_pro->pro_id; ?>);">
                                    <i class="fa fa-check fa-fw"></i> Chọn bán
                                </button>
                              <?php } ?>
                            <?php } ?>
                          </div>
                          <a href="#javascript:void();">
                            <img src="/templates/home/styles/images/svg/CTV.svg" class="img-popup-ctv" data-toggle="modal" data-key="<?php echo $hoahong;?>"
                            data-url="<?php echo base_url().$item_pro->pro_category.'/'.$item_pro->pro_id.'/'.RemoveSign($item_pro->pro_name).$af_key; ?>" data-product="<?php echo $item_pro->pro_id; ?>"
                            data-valuea="<?php echo $item_pro->aff_rate;?>"
                            data-valueb="<?php echo $item_pro->af_amt;?>"
                            data-target="#myModal_ctv_<?php echo $item_pro->pro_id;?>" height="24" alt="">
                          </a> -->
                        </span>
                        <?php } ?>
                        <?php
                        if($item_pro->end_date_sale >= time()){
                        ?>
                        <div class="flash">
                          <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
                          <div class="time" id="flash-sale_<?php echo $item_pro->pro_id?>">
                            <script>
                            cd_time(<?php echo $item_pro->end_date_sale * 1000?>,<?php echo $item_pro->pro_id?>);
                            </script>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="action">
                        <p class="like js-like-product" data-id="<?php echo $item_pro->pro_id; ?>">
                        <?php if (!empty($item_pro->is_like)) { ?>
                            <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >
                           <?php } else { ?>
                            <img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
                        <?php } ?>
                        </p>
                        <!-- <p><img src="/templates/home/styles/images/svg/bag_white.svg" alt="" onclick="addCart(<?php //echo $item_pro->pro_id; ?>);"></p> -->
                        <!-- <p><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></p> -->
                      </div>
                    </div>
                    <div class="text">
                      <p class="pro-name">
                        <a class="btn btn-default" href="<?php echo $link; ?>" title="<?php echo $item_pro->pro_name; ?>" alt="<?php echo $item_pro->pro_name; ?>"><?php echo sub($item_pro->pro_name, 25); ?></a>
                      </p>
                      <p class="price">
                        <?php
                        if ($item_pro->have_num_tqc > 0)
                        {
                        ?>
                          <span class="giadasale">Sản phẩm giá theo lựa chọn</span>
                        <?php
                        }
                        else
                        {
                          if($item_pro->pro_saleoff == 1 && $item_pro->end_date_sale > strtotime(date("Y-m-d")) || $item_pro->pro_cost > $discount['salePrice'] && $item_pro->is_product_affiliate == 1)
                          {
                            $khuyenmai = false;
                            if($item_pro->pro_saleoff == 1 && $item_pro->end_date_sale > strtotime(date("Y-m-d")))
                            {
                              $khuyenmai = true;
                              if($item_pro->pro_type_saleoff == 1) { // giảm theo %
                                $sale_itempro = $item_pro->pro_cost * (1 - $item_pro->pro_saleoff_value / 100);
                              } else {
                                $sale_itempro = $item_pro->pro_cost - $item_pro->pro_saleoff_value;
                              }
                            }
                            if ($item_pro->pro_cost > $discount['salePrice'] && $item_pro->is_product_affiliate == 1)
                            {
                              $sale_itempro = $discount['salePrice'];
                            }
                          ?>
                              <label class="sale">
                                <span class="dong">đ</span>
                                <b><?php echo lkvUtil::formatPrice($sale_itempro, ''); ?></b>
                              </label>
                              <br/>
                              <?php
                              if($khuyenmai == true)
                              {
                              ?>
                                <span class="sale-price"><?php echo lkvUtil::formatPrice($item_pro->pro_cost, ''); ?></span>
                              <?php
                              }
                              ?>
                            <?php
                          }
                          else
                          {
                            
                            // else
                            // { ?>
                                <span class="dong">đ</span>
                                <?php echo lkvUtil::formatPrice($item_pro->pro_cost, ''); ?>
                              <?php
                            // }
                          }
                        }
                        ?>

                      </p>
                      <div class="sm-btn-show sm">
                        <img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt="">
                      </div>
                    </div>
                    <div class="text-right" id="bt_<?php echo $item_pro->pro_id?>">
                      <input type="hidden" name="product_showcart" value="<?php echo $item_pro->pro_id; ?>">
                      <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
                      <input type="hidden" name="dp_id" value="<?php echo $item_pro->dp_id; ?>">
                      <input type="hidden" name="qty" value="<?php echo !empty($item_pro->pro_minsale) ? $item_pro->pro_minsale : 1 ?>" id="qty_min">
                    </div>
                  </li>
                  <?php $idDiv++; ?>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
            <?php if (count($categoryProduct) > 0) { ?>                
            
            <div class="sanphamchitiet-recent">
              <div class="sanphamchitiet-recent-title">
                <h3>SẢN PHẨM TƯƠNG TỰ</h3>
                <a href="">Xem tất cả </a>
              </div>
              <div class="sanphamchitiet-recent-slider">
                <ul class="slider recent-slider">
                  <?php
                  $idDiv = 1;
                  foreach ($categoryProduct as $item_pro) {
                    $afSelect = false;
                    $discount = lkvUtil::buildPrice($item_pro, $this->session->userdata('sessionGroup'), $afSelect);
                    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$item_pro->pro_dir.'/thumbnail_2_'. explode(',', $item_pro->pro_image)[0];
                    $link = '/'.$item_pro->pro_category.'/'.$item_pro->pro_id.'/'.RemoveSign($item_pro->pro_name)."?af_id=".$af_id;

                    $gia = $item_pro->pro_cost;
                    if ($item_pro->pro_cost > $discount['salePrice']) {
                      $gia = $discount['salePrice'];
                    }
                    if($item_pro->aff_rate > 0){
                      $pthoahong = $item_pro->aff_rate;
                      $hoahong = $gia * ($pthoahong/100);
                    }else{
                      $hoahong = $item_pro->af_amt;
                    }
                    if ($item_pro->have_num_tqc > 0) {
                      $hoahong = '';
                    }
                  ?>
                  
                  <li class="item-li">
                    <div class="image">
                      <a class="btn btn-default" href="<?php echo $link; ?>" title="<?php echo $item_pro->pro_name; ?>" alt="<?php echo $item_pro->pro_name; ?>">
                        <img src="<?php echo $filename; ?>" alt="" class="sp">
                      </a>
                      <div class="ctv-flash">
                        <?php $this->load->view('home/common/temp_hoahong', array('item' => $item_pro)); ?>
                        <?php if($this->session->userdata('sessionUser') && $item_pro->is_product_affiliate == 1){ ?>
                          <!-- <div class="btn-selectsale-<?=$item_pro->pro_id?> hidden">
                            <?php if (isset($selected_sale_arr)) { ?>
                              <?php if ($selected_sale_arr[$item_pro->pro_id] > 0) { ?>
                              <button class="btn btn-default mr10">
                                <i class="fa fa-check fa-fw"></i> Đã chọn bán
                              </button>
                            <?php } else { ?>
                                <button class="btn btn-default mr10" onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $item_pro->pro_id; ?>);">
                                    <i class="fa fa-check fa-fw"></i> Chọn bán
                                </button>
                              <?php } ?>
                            <?php } ?>
                          </div> -->
                        <!-- <span class="ctv" style="z-index:3">
                          <a href="#javascript:void();">
                            <img src="/templates/home/styles/images/svg/CTV.svg" class="img-popup-ctv" data-toggle="modal" data-target="#myModal_ctv_<?php echo $item_pro->pro_id; ?>" data-key="<?php echo $hoahong;?>"
                            data-url="<?php echo base_url().$item_pro->pro_category.'/'.$item_pro->pro_id.'/'.RemoveSign($item_pro->pro_name).$af_key; ?>" data-product="<?php echo $item_pro->pro_id; ?>"
                            data-valuea="<?php echo $item_pro->aff_rate;?>"
                            data-valueb="<?php echo $item_pro->af_amt;?>" height="24" alt="">
                          </a>
                        </span> -->
                        <?php } ?>
                        <?php
                        if($item_pro->end_date_sale >= time()){
                        ?>
                        <div class="flash">
                          <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
                          <div class="time" id="flash-sale_1<?php echo $item_pro->pro_id?>">
                            <script>
                            cd_time(<?php echo $item_pro->end_date_sale * 1000?>,1<?php echo $item_pro->pro_id?>);
                            </script>
                          </div>
                        </div>
                        <?php
                          }
                        ?>
                      </div>
                      <div class="action">
                        <p class="like js-like-product" data-id="<?php echo $item_pro->pro_id; ?>">
                        <?php if (!empty($item_pro->is_like)) { ?>
                            <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >
                           <?php } else { ?>
                            <img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
                        <?php } ?>
                        </p>
                        <!-- <p><img src="/templates/home/styles/images/svg/bag_white.svg" alt="" onclick="addCart(<?php echo $item_pro->pro_id; ?>);"></p> -->
                        <p><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></p>
                      </div>
                    </div>
                    <div class="text">
                      <p class="pro-name"><a class="btn btn-default" href="<?php echo $link; ?>" title="<?php echo $item_pro->pro_name; ?>" alt="<?php echo $item_pro->pro_name; ?>"><?php echo sub($item_pro->pro_name, 25); ?></a></p>
                      <p class="price">
                        <?php
                        if ($item_pro->have_num_tqc > 0)
                        {
                        ?>
                          <span class="giadasale">Sản phẩm giá theo lựa chọn</span>
                        <?php
                        }
                        else
                        {
                          if($item_pro->pro_saleoff == 1 && $item_pro->end_date_sale > strtotime(date("Y-m-d")) || $item_pro->pro_cost > $discount['salePrice'] && $item_pro->is_product_affiliate == 1)
                          {
                            $khuyenmai = false;
                            if($item_pro->pro_saleoff == 1 && $item_pro->end_date_sale > strtotime(date("Y-m-d")))
                            {
                              $khuyenmai = true;
                              if($item_pro->pro_type_saleoff == 1) { // giảm theo %
                                $sale_itempro = $item_pro->pro_cost * (1 - $item_pro->pro_saleoff_value / 100);
                              } else {
                                $sale_itempro = $item_pro->pro_cost - $item_pro->pro_saleoff_value;
                              }
                            }
                            if ($item_pro->pro_cost > $discount['salePrice'] && $item_pro->is_product_affiliate == 1)
                            {
                              $sale_itempro = $discount['salePrice'];
                            }
                          ?>
                              <label class="sale">
                                <span class="dong">đ</span>
                                <b><?php echo lkvUtil::formatPrice($sale_itempro, ''); ?></b>
                              </label>
                              <br/>
                              <?php
                              if($khuyenmai == true)
                              {
                              ?>
                                <span class="sale-price"><?php echo lkvUtil::formatPrice($item_pro->pro_cost, ''); ?></span>
                              <?php
                              }
                              ?>
                            <?php
                          }
                          else
                          {
                            
                            // else
                            // { ?>
                                <span class="dong">đ</span>
                                <?php echo lkvUtil::formatPrice($item_pro->pro_cost, ''); ?>
                              <?php
                            // }
                          }
                        }
                        ?>

                      </p>
                      <div class="sm-btn-show sm">
                        <img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt="">
                      </div>
                    </div>
                    <div class="text-right" id="bt_<?php echo $item_pro->pro_id?>">
                      <input type="hidden" name="product_showcart" value="<?php echo $item_pro->pro_id; ?>">
                      <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
                      <input type="hidden" name="dp_id" value="<?php echo $item_pro->dp_id; ?>">
                      <input type="hidden" name="qty" value="<?php echo !empty($item_pro->pro_minsale) ? $item_pro->pro_minsale : 1 ?>" id="qty_min">
                    </div>
                  </li>
                  <?php $idDiv++; ?>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <?php } ?>
            <div class="fix-gnav-sm sm">
              <div class="icon addCart"><a href="#" onclick="addCartQty(<?php echo $product->pro_id; ?>);"><img src="/templates/home/styles/images/svg/addCart.svg" alt=""></a></div>
              <div class="buttons-group"><button class="btn-bg-gray" onclick="buyNowQty(<?php echo $product->pro_id; ?>,<?=$product->pro_type?>);">Mua ngay</button></div>
              <div class="icon"><a href="#"><img src="/templates/home/styles/images/svg/chat_new.svg" alt=""></a></div>
            </div>
          </div>
        </div>
      </section>
      <!-- Modal -->

      
      <div class="modal mess-bg" id="myModal_menu">
        <div class="modal-dialog modal-lg modal-mess ">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
              <ul class="show-more-detail">
                <a href="<?php echo $sholink; ?>"><li>Đến trang của gian hàng</li></a>
                <a href="tel:<?php echo $shop->sho_mobile ?>"><li>Gọi ngay</li></a>
                <?php if($shop->sho_email) {?>
                <a target="_blank" href="mailto:<?php echo $shop->sho_email ?>"><li>Gửi tin nhắn</li></a>
                <?php } ?>
                <a href="javascript:void(0)" onclick="copylink('<?php echo $sholink ?>')"><li>Sao chép liên kết gian hàng</li></a>
                <a href="javascript:void(0)" onclick="copylink('<?php echo get_server_protocol().domain_site.$_SERVER['REQUEST_URI'] ?>')"><li>Sao chép liên kết sản phẩm</li></a>
                <?php
                if($this->session->userdata('sessionUser') && $this->session->userdata('sessionUser') != $product->pro_user)
                {
                  if(!empty($is_report))
                  {
                ?>
                  <a href="#" style="border:none;"><span class="baocao"><li>Đã báo cáo</li></span></a>
                <?php
                  }
                  else
                  {
                ?>
                  <a href="#" style="border:none;" class="report" data-id="" data-toggle="modal" data-target="#reportpopup">
                    <span class="baocao"><li>Báo cáo sản phẩm</li></span>
                  </a>
                    <?php
                  }
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- BEGIN::POPUP NHAN XET  -->
      <!-- <div class="userpopup modal fade" id="nhanxetpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            
            <div class="modal-body" id="">
              <div class="title">Nhận xét của khách hàng</div>
              
              <div class="close-popup">
                <img src="/templates/home/styles/images/svg/close_.svg" data-dismiss="modal">
              </div>

              <form class="report">
                <label>Nhận xét của bạn về sản phẩm này</label>
                <label><input type="radio" name="idreport" class="radiobc"></input><p>Giá bán</p></label>
                <label><input type="radio" name="idreport" class="radiobc"></input><p>Chất lượng</p></label>
                <label><input type="radio" name="idreport" class="radiobc"></input><p>Mẫu mã</p></label>
                <label><input type="radio" name="idreport" class="radiobc"></input><p>Phục vụ</p></label>
                <label><b>Nhận xét của bạn về sản phẩm này</b></label>
                <label><textarea class="noidungnx" placeholder="Nhận xét của bạn"></textarea>
                </label>
                <div class="button-report">
                  <button class="btn-report btn-close" data-dismiss="modal">Đóng</button>
                  <button class="btn-report btn-send">Nhận xét</button>
                </div>
                <p class="note">* Để nhận xét được duyệt, quý khách lưu ý tham khảo <a href="">Tiêu chí duyệt nhận xét</a></p>
              </form>
            </div>

          </div>
        </div>
      </div> -->
      
      <div class="modal mess-bg" id="nhanxetpopup">
        <div class="modal-dialog modal-lg modal-mess ">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title modal-title-style">Nhận xét khách hàng</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
              <div class="product-comment">
                <div class="rating-box">Đánh giá của bạn về sản phẩm này:  
                  <form class="rating">
                    <label>
                      <input type="radio" name="stars" value="1" />
                      <span class="icon">★</span>
                    </label>
                    <label>
                      <input type="radio" name="stars" value="2" />
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                    </label>
                    <label>
                      <input type="radio" name="stars" value="3" />
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>   
                    </label>
                    <label>
                      <input type="radio" name="stars" value="4" />
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                    </label>
                    <label>
                      <input type="radio" name="stars" value="5" />
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                      <span class="icon">★</span>
                    </label>
                  </form>
                </div>
                <h3>Tiêu đề của nhận xét</h3>
                <ul>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="aaa" checked="checked"><span>Giá bán</span>
                      </label>
                   </li>
                   <li >
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Bài viết"><span>Chất lượng</span>
                      </label>
                   </li>
                   <li>
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Sản phẩm"><span>Mẫu mã</span>
                      </label>
                   </li>
                   <li >
                      <label class="checkbox-style">
                      <input type="radio" name="category" value="Bài viết"><span>Phục vụ</span>
                      </label>
                   </li>
                  </ul>
                <h3 class="mt20">Viết nhận xét của bạn vào bên dưới</h3>
                <div class="textarea">
                  <textarea name="" id="" rows="5" placeholder="Nhận xét của bạn về sản phẩm này"></textarea>
                </div>
                <div class="text-right">
                  <button>Gửi nhận xét</button>
                </div>
                <p>* Để nhận xét được duyệt, quý khách lưu ý tham khảo <a href="">Tiêu chí duyệt nhận xét</a></p>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <!-- END::POPUP NHAN XET  -->
      <?php 
        $pro_image = explode(',', $product->pro_image);
        if($product->pro_image != '' && count($pro_image) > 0) { 
      ?>
      <div class="modal modal-show-detail modal-gallery-img" id="modal-show-detail-img" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="sm">
          <div class="sm tieude-sm">
            <div class="tieude-sm-head mt10">
              <div class="avata">
                <a href="#" class="pop_shop_avatar">
                <img class="pop_shop_img" src="<?php echo $shoplogo; ?>" alt="<?php if(isset($getshop->sho_name)) echo $getshop->sho_name?>">
                <span class="pop_shop_name"><?php echo $shop->sho_name; ?></span>
              </a>
              </div>
              <div class="time">
                <span class="pop_new_date"><?php echo date('d/m/Y',$shop->sho_enddate)?></span>
              </div>
            </div>
            <h3 class="pop-descrip-title"></h3>
          </div>
          <div class="action sanphamchitiet-content-detail">
            <div class="action-left price">
              <div class="sale">
                <strong class="dong">đ</strong>
                <span class="tong_gia">
                  <?php
                  echo number_format($giasale, 0, ",", ".");
                  // if(isset($sale)) echo number_format( ($sale * $product->pro_minsale), 0, ",", ".");
                  // else echo number_format( ($product->pro_cost * $product->pro_minsale), 0, ",", "."); ?>
                </span>
              </div>
              <ul class="action-left-listaction">
                <li class="btn-buyadd">
                  <button class="btn-bg-white" onclick="addCartQty(<?php echo $product->pro_id; ?>);">Thêm vào giỏ</button>
                </li>
                <li class="btn-buyadd">
                    <button class="btn-bg-gray" onclick="buyNowQty(<?php echo $product->pro_id; ?>,<?=$product->pro_type?>);">Mua ngay</button>
                </li>
                <?php
                if($this->session->userdata('sessionUser') && $product->is_product_affiliate > 0){
                  
                  $afSelect = false;
                  $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                  
                  $gia = $product->pro_cost;
                  if ($product->pro_cost > $discount['salePrice']) {
                    $gia = $discount['salePrice'];
                  }
                  if($product->aff_rate > 0){
                    $pthoahong = $product->aff_rate;
                    $hoahongdetail = $gia * ($pthoahong/100);
                  }else{
                    $hoahongdetail = $product->af_amt;
                  }
                ?>
                <li class="ctv">
                  <a href="#javascript:void();">
                    <img src="/templates/home/styles/images/svg/ctv_sm.svg"
                    class="icon-img img-popup-ctv-qc"
                    data-toggle="modal" data-target="#myModal_ctv_<?php echo $product->pro_id; ?>"
                    data-url="<?php echo base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af_key; ?>"
                    data-key="<?php echo $hoahongdetail;?>"
                    data-valuea="<?php echo $product->aff_rate;?>"
                    data-valueb="<?php echo $product->af_amt;?>" alt="">
                  </a>
                </li>
                <?php } ?>
                <li class="share-click shr-product" data-toggle="modal" data-value="<?php echo base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name)."?af_id=".$af_id;?>" data-name="<?php echo $product->pro_name; ?>" data-type="<?php echo $type_share; ?>" data-item_id="<?php echo $product->pro_id; ?>" data-permission="<?php echo ($this->session->userdata('sessionUser') == $product->pro_user) ? 1 : '';?>">
                  <span><img class="icon-img" src="/templates/home/styles/images/svg/share_01_white.svg" alt="share"></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <a data-dismiss="modal" title="Đóng" class="back back-prodetail btn-chitiettin mt10 mr10" style="width: 80px"><img style="filter: invert(100%);" src="/templates/home/styles/images/svg/prev.svg" class="ml00">&nbsp;Đóng</a>
        <div class="modal-dialog modal-lg modal-show-detail-dialog popup-detail-img" role="document">
          <div class="modal-content container">
            <div class="modal-body">
              <div class="row">                    
                <div class="col-lg-12 list-slider popup-image-sm" data-id="333">
                  <ul id="slider-for_333" class="slider sliderpro">
                    <?php 
                      $pro_image = explode(',', $product->pro_image);
                      foreach ($pro_image as $key => $value) { ?>
                    <li>
                      <a href="#" data-image="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . $value;?>" data-zoom-image="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . $value;?>">
                        <p class="big-img">
                        <img src="<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/' . $value;?>" alt="" data-tab="<?php echo $key ?>" data-key="<?php echo $key ?>" class="popup-detail-image" alt="" onclick="popupslider()">
                        </p>               
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                  <div class="action md hidden">
                    <div class="action-left">
                      <ul class="action-left-listaction">
                        <li class="btn-buyadd">
                          <button class="btn-bg-white" onclick="addCartQty(<?php echo $product->pro_id; ?>);">Thêm vào giỏ</button>
                        </li>
                        <li class="btn-buyadd">
                            <button class="btn-bg-gray" onclick="buyNowQty(<?php echo $product->pro_id; ?>,<?=$product->pro_type?>);">Mua ngay</button>
                        </li>
                        <li class="ctv">
                          <a href="#javascript:void();">
                            <img src="/templates/home/styles/images/svg/ctv_sm.svg"
                             data-toggle="modal" data-target="#myModal_ctv"
                             data-key="<?php echo $hoahongdetail;?>"
                          data-valuea="<?php echo $product->aff_rate;?>"
                          data-valueb="<?php echo $product->af_amt;?>" alt="ctv">
                          </a>
                        </li>
                        <li class="share-click shr-product" data-toggle="modal" data-value="<?php echo base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name)."?af_id=".$af_id;?>" data-name="<?php echo $product->pro_name; ?>" data-type="<?php echo $type_share; ?>" data-item_id="<?php echo $product->pro_id; ?>" data-permission="<?php echo ($this->session->userdata('sessionUser') == $product->pro_user) ? 1 : '';?>">
                          <span><img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share"></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <?php
                $img_shop = '';
                $sho_name = '';
                $sho_enddate = '';
                if(isset($getshop)) {
                  $img_shop = DOMAIN_CLOUDSERVER.'media/shop/logos/'.$getshop->sho_dir_logo.'/'.$getshop->sho_logo;
                  $sho_name = $getshop->sho_name;
                  $sho_enddate = date('d/m/Y',$getshop->sho_enddate);
                }
                ?>
                <div class="col-lg-5 md hidden">
                  <div class="post">
                    <div class="post-head">
                      <div class="post-head-name">
                        <div class="avata">
                          <a href="#" class="pop_shop_avatar">
                            <img class="pop_shop_img" src="<?php echo $img_shop; ?>" alt="<?php echo $sho_name; ?>">
                          </a>
                        </div>
                        <div class="title">
                          <a href="#" class="pop_shop_avatar">
                            <span class="pop_shop_name"><?php echo $sho_name ?></span>
                            </a>
                          <br>
                          <span class="pop_new_date"><?php echo $sho_enddate;?></span>
                          <span>
                            <img class="mr10 ml20 mt05" src="/templates/home/styles/images/svg/quadiacau.svg" width="14" alt="">
                          </span>
                          <span style="color: #737373; font-weight: normal; border-left: 1px solid #c4c4c4" class="pl10">
                            <img class="mt10" src="/templates/home/styles/images/svg/eye_gray.svg" width="16" alt="">
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php
      if(count($promotions) > 0 && $promotions != ''){
      ?>
      <div class="userpopup modal fade" id="muasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="title">Ưu đãi khi mua sỉ</div>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="">
              <table border="1">
                <thead>
                  <tr>
                  <th>Mua từ</th>
                  <th>Mua đến</th>
                  <th>Được giảm</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($promotions as $promotion):
                  if ($promotion['limit_type'] == 2):
                    $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                    ?>
                    <tr>
                      <?php
                        if ($promotion['limit_from'] == 0) {
                          echo '<td>Tổng tiền dưới ' . number_format($promotion['limit_to']) . ' đ</td><td></td><td>' . $pDiscount . '</td>';
                        } elseif ($promotion['limit_to'] == 0) {
                          echo '<td></td><td>Tổng tiền ' . number_format($promotion['limit_from']) . ' đ</td><td>' . $pDiscount . '</td>';
                        } else {
                          echo '<td>Tổng tiền ' . number_format($promotion['limit_from']) . ' đ</td><td>Tổng tiền ' . number_format($promotion['limit_to']) . ' đ </td><td>' . $pDiscount . '</td>';
                        }
                      ?>
                    </tr>
                    <?php else: ?>
                    <tr>
                    <?php
                      $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                      if ($promotion['limit_from'] == 0) {
                        echo '<td>dưới ' . $promotion['limit_to'] . ' sản phẩm </td><td></td> <td>' . $pDiscount . '</td>';
                      } elseif ($promotion['limit_to'] == 0) {
                        echo '<td></td><td>trên ' . $promotion['limit_from'] . ' sản phẩm</td><td>' . $pDiscount . '</td>';
                      } else {
                        echo '<td>' . $promotion['limit_from'] . ' sản phẩm </td><td>' . $promotion['limit_to'] . ' sản phẩm </td><td>' . $pDiscount . '</td>';
                      }
                    ?>
                    </tr>
                  <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
  </main>
</div>
<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
</footer>
<?php $this->load->view('e-azibai/common/common-popup-af-commission'); ?>
<p style="display:none" id="dp_id"><?php echo $product->id; ?></p>
<p style="display:none" id="af_id"><?php echo $_REQUEST['af_id']; ?></p>
<p style="display:none" id="minsale"><?php echo $product->pro_minsale; ?></p>

<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<?php $this->load->view('home/report/popup-report'); ?>
<?php $this->load->view('home/common/load_wrapp');?>

<script>var type_collection = <?=$product->pro_type == 0 ? COLLECTION_PRODUCT : COLLECTION_COUPON ?>;</script>
<?php $this->load->view('shop/collection/popup-collection/popup-pin-node-to-other-collection'); ?>
<script src="/templates/home/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/js/commission-aft.js"></script>
<!-- Modal -->
<script type="text/javascript">
  var slider_show = 4;
  if ($(window).width() < 768) {
    slider(333);
    slider(444);
  }
  function copylink(link) { clipboard.copy(link); }
  $(function() {

    $('.san-pham-mua-kem-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      infinite: false,
      variableWidth: true,
      responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2
        }
      },
      ]
    });
      
    $('.recent-slider').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      infinite: false,
      responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 4,
          arrows: false,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          arrows: false,
        }
      }
      ]
    });
    <?php //if(isset($sale)) { ?>
      var cost = <?php echo $giasale; ?>
    <?php //} else { ?>
      // var cost = <?php echo $product->pro_cost; ?>
    <?php //} ?>

    $('input#qty_' + <?php echo $product->pro_id;?>).change(function(){
      var sl = $(this).val();
      $('.tong_gia').text( formatNumber(cost * sl) );
      $('.proprice').attr('value',cost * sl);
    });
    
    $('.add').click(function () {
      if ($(this).prev().val() < <?php echo $product->pro_instock;?>) { // sl sp trong kho
        $(this).prev().val(+$(this).prev().val() + 1 );
        var sl = $(this).prev().val();
        var pricesale = cost * sl;
        // if($('.af_dc_rate').length > 0 && $('.af_dc_rate').val() > 0){
        //   pricesale = pricesale * (1- ($('.af_dc_rate').val()/100));
        // }else{
        //   if($('.af_dc_amt').length > 0 && $('.af_dc_amt').val() > 0){
        //     pricesale = (cost - $('.af_dc_amt').val()) * sl;
        //   }
        // }

        $('.tong_gia').text( formatNumber(pricesale) );
        $('.proprice').attr('value',pricesale);
      }
    });
    $('.sub').click(function () {
      if ($(this).next().val() > <?php echo $product->pro_minsale; ?> ) { // sl mua toi thieu
        $(this).next().val(+$(this).next().val() - 1 );
        var sl = $(this).next().val();
        var pricesale = cost * sl;
        // if($('.af_dc_rate').length > 0 && $('.af_dc_rate').val() > 0){
        //   pricesale = pricesale * (1- ($('.af_dc_rate').val()/100));
        // }else{
        //   if($('.af_dc_amt').length > 0 && $('.af_dc_amt').val() > 0){
        //     pricesale = pricesale - $('.af_dc_amt').val();
        //   }
        // }

        $('.tong_gia').text( formatNumber(pricesale) );
        $('.proprice').attr('value',pricesale);
      }
    });

    //Click show menu
    $('.thongso dt').click(function (){
      var countdt = $('.thongso dt').length;
      var index_p = $(this).parent().index();
      var className = $('dl').eq(index_p).find('dd').attr('class');

      for(var i = 0; i < countdt; i++){
        if(i != index_p || className == 'opened'){
          $('dl').eq(i).find('dd').removeClass('opened');
          $('dl').eq(i).find('span.dot img').css('transform','rotate(0deg)');
        }else{
          $('dl').eq(index_p).find('dd').addClass('opened');
          $('dl').eq(index_p).find('span.dot img').css('transform','rotate(180deg)');
        }
      }
    });

    var countdl = $('.thongso dl').length;
    if(countdl == 1){
      $('.thongso dl').css('width','100%');
    }
    
    var $win = $(window);
    var $box = $(".thongso");
    $win.on("click.Bst", function(event){   
     if ($box.has(event.target).length == 0 && !$box.is(event.target)){
        $('dl').find('dd').removeClass('opened');
        $('dl').find('span.dot img').css('transform','rotate(0deg)');
     }
    });
    //end menu

    $('input[name="pro_attach_list"]').click(function() {
      if($(this).prop("checked") == true){
        $('#attach_pro').show();
      } else {
        if($('input[name="pro_attach_list"]:checked').size() < 1){
          $('#attach_pro').hide();
        }
      }
    });

    $('.click-show-video').click(function() {
      $(this).hide();
      $('.click-show-img').show();
      $('#sliderpro').css({"opacity": "0", "z-index": "1"});
      $('.show-video').css({"opacity": "1", "z-index": "2"});
    });

    $('.click-show-img').click(function() {
      $('.click-show-video').show();
      $(this).hide();
      $('#sliderpro').css({"opacity": "1", "z-index": "2"});
      $('.show-video').css({"opacity": "0", "z-index": "1"});
    });
  });

  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
  }

  function add_cart_attach() {
    var arr = [];
    var target = $('.san-pham-mua-kem').find('input[name="pro_attach_list"]:checked');
    $.each(target, function(index, value){
      data = {
        'product_showcart' : $(value).val(),
        'af_id' : $('#af_id').text()
      };
      arr.push( data );
    })
    // var a = JSON.stringify(arr);
    if(arr.length > 0) {
      arr = JSON.stringify(arr);
      $.ajax({
        dataType : 'text',
        type: 'post',
        url: siteUrl + 'home/showcart/add_to_cart_by_attach',
        data: {'data': arr},
        success: function(result){
          $('#dialog_mess').modal('show');
          $('#mess_detail').empty();

          result = JSON.parse(result);
          $.each(result, function(i, v){
            if (v.error == false) {
              $('.cartNum').text(v.num);
            }
            var type = v.error == true ? 'alert-danger' : 'alert-success';
            $('#mess_detail').append('<p class="'+type+'">' + v.message + '</p>');
          });

        },
        error: function(res){
          alert('error connect');
        }
      });
    }
  }

  $('body').on('click', '#thongso li', function() {
  // $('body').find('#thongso li').click(function (){
    var pro_id = <?php echo $product->pro_id; ?>;
    var pro_user = <?php echo $product->pro_user; ?>;
    var apply = <?php echo $product->apply; ?>;
    var is_aff = <?php echo $product->is_product_affiliate; ?>;
    var pro_type_saleoff = <?php echo $product->pro_type_saleoff; ?>;
    var pro_saleoff = <?php echo $product->pro_saleoff; ?>;
    var product = <?php echo json_encode($product); ?>;
    var af_id = '<?php echo $_REQUEST['af_id']; ?>';

    var text = $(this).text();
    var pro_min_sale = <?php echo $product->pro_minsale; ?>;
    var tqc = 0;
    var call_ajax = false;
    var text_color = text_size = '';
    if($(this).hasClass('tqc1') && !$(this).hasClass('is-active')){
      tqc = 1;
      if($('#thongso .tqc1').length > 1) {
        call_ajax = true;
      }
    }
    if($(this).hasClass('tqc2')){
      tqc = 2;
      if($('#thongso .tqc1').length > 0) {
        text_color = $('#thongso .tqc1.is-active').text();
      }
      if($('#thongso .tqc2').length > 1) {
        call_ajax = true;
      }
    }
    if($(this).hasClass('tqc3')){
      tqc = 3
      if($('#thongso .tqc1').length > 0) {
        text_color = $('#thongso .tqc1.is-active').text();
      }
      if($('#thongso .tqc2').length > 0) {
        text_size = $('#thongso .tqc2.is-active').text();
      }
      if($('#thongso .tqc3').length > 1) {
        call_ajax = true;
      }
    }
    var data = {
      'pro_id' : pro_id,
      'text'  : text,
      'text_color'  : text_color,
      'text_size'  : text_size,
      'tqc' : tqc,
      'af_id' : af_id,
      'product' : product,
    };
    data = JSON.stringify(data);

    if(call_ajax == false) {
      return false;
    }

    if($(window).width() < 750){
      $('.gallery_01').addClass('md');
      $('.gallery_02').addClass('md');
    }

    $.ajax({
      dataType : 'text',
      type: 'post',
      url: siteUrl + 'home/product/getTQC',
      data: {'data': data},
      success: function(result){
        result = JSON.parse(result);
        var selected = result.tqc_select;
        var arr_tqc = result.arr;
        if(tqc == 1){
          $('.tqc1').removeClass("is-active");
          $('.tqc1').each(function(){
            if($(this).text() == selected.dp_color){
              $(this).addClass("is-active");
            }
          });
          // $('.tqc1:contains("'+selected.dp_color+'")').addClass("is-active");
          if($(window).width() < 768){
            $('dl#dp_color dt .txt_color').text($('.tqc1.is-active').text());
          }
          // process tqc
          var html = '';
          var arr_size_dup = []; //array size duplicate
          var arr_meterial_dup = []; //array meterial duplicate
          $.each(arr_tqc, function(i, val){
            if(i != 'material'){
              arr_size_dup.push(val.size);
              arr_meterial_dup.push(val.material);
            }
          });
          // change tqc 2
          if(selected.dp_size.toString() != ''){
            var arr_size = []; //remove dup
            $.each(arr_size_dup, function(i, val){
                if($.inArray(val, arr_size) === -1) arr_size.push(val);
            });
            $.each(arr_size, function(i, val){
              if(selected.dp_size.toString() == val.toString()) {
                html += '<li class="tqc2 is-active">'+val+'</li>';
                if($('body').width() < 768){
                  $('dl#dp_size dt .txt_size').text(val);
                }
              } else {
                html += '<li class="tqc2">'+val+'</li>';
              }
            });
            $('#dp_size ul').html(html);
            html = '';
          }

          // change tqc 3
          if(selected.dp_material.toString() != ''){
            var arr_meterial = arr_tqc['material'];
            $.each(arr_meterial, function(i, val){
              if(selected.dp_material.toString() == val.toString()){
                html += '<li class="tqc3 is-active">'+val+'</li>';
                if($(window).width() < 768){
                  $('dl#dp_meterial dt .txt_material').text(val);
                }
              }else{
                html += '<li class="tqc3">'+val+'</li>';
              }
            });
            $('#dp_meterial ul').html(html);
          }
        }
        if(tqc == 2){

          $('.tqc2').removeClass("is-active");
          $('.tqc2').each(function(){
            if($(this).text() == selected.dp_size){
              $(this).addClass("is-active");
            }
          });
          // $('.tqc2:contains("'+selected.dp_size+'")').addClass("is-active");

          if($(window).width() < 768){
            $('dl#dp_size dt .txt_size').text($('.tqc2.is-active').text());
          }
          // change tqc 3
          var html = '';
          if(selected.dp_material.toString() != ''){
            $.each(arr_tqc, function(i, val){
              if(selected.dp_material.toString() == val.material.toString() || arr_tqc.length == 1){
                html += '<li class="tqc3 is-active">'+val.material+'</li>';
                if($('body').width() < 768){
                  $('dl#dp_meterial dt .txt_material').text(val.material);
                }
              }else{
                html += '<li class="tqc3">'+val.material+'</li>';
              }
            });
            $('#dp_meterial ul').html(html);
          }
        }

        if(tqc == 3){
          $('.tqc3').removeClass("is-active");
          $('.tqc3').each(function(){
            if($(this).text() == selected.dp_material){
              $(this).addClass("is-active");
            }
          });

          if($(window).width() < 768){
            $('dl#dp_meterial dt .txt_material').text($('.tqc3.is-active').text());
          }
        }
        //change id TQC selected
        $('#dp_id').text(selected.id);
        var price = selected.dp_cost;
        $('.giagoc').text(formatNumber(price));
        <?php
        if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale > strtotime(date("Y-m-d"))) { ?>
          <?php if($product->pro_type_saleoff == 1) { // giảm theo % ?>
            price = price - (price * <?php echo $product->pro_saleoff_value / 100 ?>);
          <?php } else { ?>
            price = price - (<?php echo $product->pro_saleoff_value ?>);
          <?php } ?>
        <?php } ?>
        price = price * pro_min_sale;

        $('.proprice').attr('value',price);
        price = formatNumber(price);

        $('.pro_number').text(selected.dp_instock);
        $('.tong_gia').text(price);
        $('input#qty_' + pro_id).val(<?php echo $product->pro_minsale ?>);
        $('#zoom_03').attr('src',"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images);
        $('#zoom_03').attr('data-zoom-image',"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images);
        $('.zoomWindow').css('background-image', "url(<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images+")");

        var class_gall = '.gallery_01';
        if($('.gallery_02').length > 0){
          class_gall = '.gallery_02';
        }
        $(class_gall + ' li').find('a').removeClass('is-active');

        $(class_gall + ' li').each(function(e){
          var src_img = $(this).find('a img').attr('src');
          var imgzoom = "<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images;
          var first_act = $('.gallery_01 li.slick-active').first().index();

          if(src_img == imgzoom){
            $(this).find('a').addClass('is-active');
            if($(class_gall + ' li').length / slider_show !== 0 && $(this).index() >= first_act){
              $(class_gall).slick('slickGoTo', $(this).index() - 1);
            }else
              $(class_gall).slick('slickGoTo', $(this).index());
          }else{
            $(this).find('a').removeClass('is-active');
          }

          if ($(window).width() < 770) {
            var ulsm = '<ul><li><img src="'+"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images+'"></li></ul>';
            $('.slider_sm').html(ulsm);
            $('.gallery_01').addClass('md');
          }

        });
        $('.js-ctv.js_get-pop-commission').attr('data-commission', selected.hoahong.hoahongLogin);
      },
      error: function(res){
        alert('error connect');
      }
    });
  });

  $('.popup-detail-image').click(function(){
    if($(window).width() > 750)
    {
      var this_parent = $(this).parents('li');
      var parent_index = $(this).parents('li').index();
      var txt_color = $(this_parent).attr('data-dp1');
      var txt_size = $(this_parent).attr('data-dp2');
      var txt_material = $(this_parent).attr('data-dp3');

      var length_color = $('#dp_color').length;
      var length_size = $('#dp_size').length;
      var length_material = $('#dp_meterial').length;
      var product = <?php echo json_encode($product); ?>;
      var af_id = '<?php echo $_REQUEST['af_id']; ?>';

      if($('.thongso').length > 0){
        var text_qc = class_ = '';
        var index_tqc = index_tqc2 = tqc = 0;
        var call_ajax = false;

        if(length_material > 0){
          text_qc = txt_material;
          call_ajax = true;
          tqc = 3;
        }

        if(length_size > 0){
          text_qc = txt_size;
          call_ajax = true;
          tqc = 2;
        }

        if(length_color > 0){
          text_qc = txt_color;
          call_ajax = true;
          tqc = 1;
        }
        var pro_id = <?php echo $product->pro_id; ?>;
        var text = text_qc;
        var pro_min_sale = <?php echo $product->pro_minsale; ?>;
        var data = {
          'pro_id' : pro_id,
          'text'  : text,
          'text_color'  : txt_color,
          'text_size'  : txt_size,
          'txt_material'  : txt_material,
          'tqc' : tqc,
          'af_id' : af_id,
          'product' : product
        };
        data = JSON.stringify(data);

        if(call_ajax == false) {
          return false;
        }

        var class_gall = '.gallery_01';
        if($('.gallery_02').length > 0){
          class_gall = '.gallery_02';
        }

        var first_act = $(class_gall+' li.slick-active').first().index();
        var last_act = $(class_gall+' li.slick-active').last().index();
        if(parent_index == first_act || parent_index == last_act){
            if(parent_index == first_act){
              parent_index = parseInt(parent_index - 1);
            }
        }

        $(class_gall).slick('slickGoTo', parseInt(parent_index));
        $(class_gall+' li').removeClass('slick-current');
        $(this_parent).addClass('slick-current');
        $(class_gall+' li').find('a').removeClass('is-active');
        $(this).parent('a').addClass('is-active');

        $.ajax({
          dataType : 'text',
          type: 'post',
          url: siteUrl + 'home/product/getTQC',
          data: {'data': data},
          success: function(result){
            result = JSON.parse(result);
            var selected = result.tqc_select;
            var arr_tqc = result.arr;
            if(tqc == 1){
              $('.tqc1').removeClass("is-active");
              $('.tqc1').each(function(){
                if($(this).text() == selected.dp_color){
                  $(this).addClass("is-active");
                }
              });
              // $('.tqc1:contains("'+selected.dp_color+'")').addClass("is-active");
              if($(window).width() < 768){
                $('dl#dp_color dt .txt_color').text($('.tqc1.is-active').text());
              }
              // process tqc
              var html = '';
              var arr_size_dup = []; //array size duplicate
              var arr_meterial_dup = []; //array meterial duplicate
              $.each(arr_tqc, function(i, val){
                if(i != 'material'){
                  arr_size_dup.push(val.size);
                  arr_meterial_dup.push(val.material);
                }
              });

              // change tqc 2
              if(selected.dp_size.toString() != ''){
                var arr_size = []; //remove dup
                $.each(arr_size_dup, function(i, val){
                    if($.inArray(val, arr_size) === -1) arr_size.push(val);
                });
                $.each(arr_size, function(i, val){
                  if(txt_size == val.toString()) {
                    html += '<li class="tqc2 is-active">'+val+'</li>';
                    if($('body').width() < 768){
                      $('dl#dp_size dt .txt_size').text(val);
                    }
                  } else {
                    html += '<li class="tqc2">'+val+'</li>';
                  }
                });
                $('#dp_size ul').html(html);
                html = '';
              }

              // change tqc 3
              if(selected.dp_material.toString() != ''){
                var arr_meterial = arr_tqc['material'];
                $.each(arr_meterial, function(i, val){
                  if(txt_material == val.toString()){
                    html += '<li class="tqc3 is-active">'+val+'</li>';
                    if($(window).width() < 768){
                      $('dl#dp_meterial dt .txt_material').text(val);
                    }
                  }else{
                    html += '<li class="tqc3">'+val+'</li>';
                  }
                });
                $('#dp_meterial ul').html(html);
              }
            }
            if(tqc == 2){

              $('.tqc2').removeClass("is-active");
              $('.tqc2').each(function(){
                if($(this).text() == selected.dp_size){
                  $(this).addClass("is-active");
                }
              });
              // $('.tqc2:contains("'+selected.dp_size+'")').addClass("is-active");

              if($(window).width() < 768){
                $('dl#dp_size dt .txt_size').text($('.tqc2.is-active').text());
              }
              // change tqc 3
              var html = '';
              if(selected.dp_material.toString() != ''){
                $.each(arr_tqc, function(i, val){
                  if(txt_material == val.material.toString() || arr_tqc.length == 1){
                    html += '<li class="tqc3 is-active">'+val.material+'</li>';
                    if($('body').width() < 768){
                      $('dl#dp_meterial dt .txt_material').text(val.material);
                    }
                  }else{
                    html += '<li class="tqc3">'+val.material+'</li>';
                  }
                });
                $('#dp_meterial ul').html(html);
              }
            }

            if(tqc == 3){
              $('.tqc3').removeClass("is-active");
              $('.tqc3').each(function(){
                if($(this).text() == selected.dp_material){
                  $(this).addClass("is-active");
                }
              });

              if($(window).width() < 768){
                $('dl#dp_meterial dt .txt_material').text($('.tqc3.is-active').text());
              }
            }
            //change id TQC selected
            $('#dp_id').text(selected.id);
            var price = selected.dp_cost;
            $('.giagoc').text(formatNumber(price));
            <?php
            if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale > strtotime(date("Y-m-d"))) { ?>
              <?php if($product->pro_type_saleoff == 1) { // giảm theo % ?>
                price = price - (price * <?php echo $product->pro_saleoff_value / 100 ?>);
              <?php } else { ?>
                price = price - (<?php echo $product->pro_saleoff_value ?>);
              <?php } ?>
            <?php } ?>
            price = price * pro_min_sale;

            $('.proprice').attr('value',price);
            price = formatNumber(price);

            $('.pro_number').text(selected.dp_instock);
            $('.tong_gia').text(price);
            $('input#qty_' + pro_id).val(<?php echo $product->pro_minsale ?>);
            $('#zoom_03').attr('src',"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images);
            $('#zoom_03').attr('data-zoom-image',"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images);
            $('.zoomWindow').css('background-image', "url(<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images+")");

            // if ($(window).width() < 770) {
              var ulsm = '<ul><li><img src="'+"<?php echo DOMAIN_CLOUDSERVER .'media/images/product/' . $product->pro_dir . '/';?>"+selected.dp_images+'"></li></ul>';
              $('.slider_sm').html(ulsm);
              $('.gallery_01').addClass('md');
            // }
            $('.js-ctv.js_get-pop-commission').attr('data-commission', selected.hoahong.hoahongLogin);
          },
          error: function(res){
            alert('error connect');
          }
        });
      }
    }
  });

  function goback(){
    window.history.back();
  }
  if ($('body').width() > 780) {
    if($('.thongso').length == 0){
      $('.gallery_01').attr('id', 'slider-for_333');
    }
    $("#zoom_03").elevateZoom({gallery:'slider-for_333', cursor: 'pointer', galleryActiveClass: 'is-active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});
    $("#zoom_03").css({'height':'100%','width':'100%'});
    
    $("#zoom_03").bind("click", function(e) {  
      var ez =   $('#zoom_03').data('elevateZoom'); 
      $.fancybox(ez.getGalleryList());
      return false;
    });
  }

  function slick_gall01(){
    if($('.gallery_01').hasClass('slick-slider') === true){
      // $('.gallery_01').slick('unslick');
    }
    $('.gallery_01').slick({
      autoplay: false,
      arrows: false,
      dots: false,
      slidesToShow: slider_show,
      slidesToScroll: 2,
      speed: 1000,
      infinite: false,
      vertical:true,
      verticalSwiping:true,
      responsive: [
      {
        breakpoint: 768,
        settings: {
          speed: 300,
          slidesToShow: 1,
          slidesToScroll: 1,
          vertical: false,
          verticalSwiping:false,
          dots: true,
          infinite: true,
        }
      },
      ]
    });
  }

  function slick_gall02(){
    if($('.gallery_02').hasClass('slick-slider') === true && $(window).width() < 750){
      $('.gallery_02').slick('unslick');
    }
    $('.gallery_02').slick({
      autoplay: false,
      arrows: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
      vertical: false,
      verticalSwiping:false,
      dots: true,
      infinite: true
      /*responsive: [
      {
        breakpoint: 768,
        settings: {
          speed: 300,
          slidesToShow: 1,
          slidesToScroll: 1,
          vertical: false,
          verticalSwiping:false,
          dots: true,
          infinite: true,
        }
      },
      ]*/
    });
  }

  slick_gall01();
  if ($(window).width() > 750) {
    $('.button-chinh-sua.sm').addClass('hidden');
  }else{
    $('.button-chinh-sua.sm').removeClass('hidden');
    if($('.thongso').length > 0){
      $('.show-photo-nav .gallery_01').removeClass('md');
      $('.gallery_01').addClass('gallery_02').removeClass('gallery_01');
      slick_gall02();
    }
  }

  $(window).scroll(function(){
    if ($(window).width() > 750) {
      var height_header = $('.header.md').innerHeight();
      var height_breadcrumb = $('.breadcrumb.md').innerHeight();
      var height_infoshop = $('.info-shop').innerHeight();
      var mrtop_ctcontent = parseInt($('.sanphamchitiet-content').css('margin-top'));
      var height_top = height_header + height_breadcrumb + height_infoshop;
      var heigh_content = $('.sanphamchitiet-content-detail').height() - height_top - 150;
      var top = $(this).scrollTop();
      var div_content = $('.sanphamchitiet-content').width();
      var col_md5 = $('.sanphamchitiet-content .col-md-5').width();
      var show_photo_nav = $('.sanphamchitiet-content .show-photo-nav').width();
      var col_gallery = $('.sanphamchitiet-content-gallery').innerWidth();

      if(top >= height_top && top <= heigh_content){
        $('.sanphamchitiet-content').css('position:relative');
        $('.sanphamchitiet-content-gallery').css({'position':'fixed','top': height_header+'px'});
        if($(window).width() >= 1024){
          $('.sanphamchitiet-content-gallery').css('width',col_gallery+'px');
        }else{
         $('.sanphamchitiet-content-gallery').css('width', 'unset');
        }
      }else{
        $('.sanphamchitiet-content').removeAttr('style');
        $('.sanphamchitiet-content-gallery').removeAttr('style');
      }
      $('.button-chinh-sua.sm').addClass('hidden');
      $('.sliderpro li img').removeAttr('onclick');
    }else{
      $('.button-chinh-sua.sm').removeClass('hidden');
      $('.sanphamchitiet-content').removeAttr('style');
      $('.sanphamchitiet-content-gallery').removeAttr('style');
    }
  });

  $(window).resize(function() {
    $(window).scrollTop(0);
    var length_color = $('#dp_color').length;
    var length_size = $('#dp_size').length;
    var length_material = $('#dp_meterial').length;
    var img_big = $('#zoom_03').attr('src');

    if ($(window).width() > 750) {
      $('.button-chinh-sua.sm').addClass('hidden');

      if($('.thongso').length > 0){
        if(length_color > 0){
          $('#dp_color .txt_color').text('Màu sắc');
        }
        if(length_size > 0){
          $('#dp_size .txt_size').text('Kích thước');
        }
        if(length_material > 0){
          $('#dp_meterial .txt_material').text('Chất liệu');
        }
        
        // $('.gallery_02').addClass('gallery_01').removeClass('gallery_02');
        if($('.gallery_02').length > 0){
          $('.gallery_02').slick('unslick');
          $('.gallery_02').addClass('gallery_01').removeClass('gallery_02');
          // $('.gallery_01').slick('reinit');
          slick_gall01();
        }
        // slick_gall01();
        
        $('.slider_sm').addClass('sm');

        var class_gall = '.gallery_01';
        if($('.gallery_02').length > 0){
          class_gall = '.gallery_02';
        }
        $(class_gall+' li.slick-cloned').remove();
      }
    }else{
      $('.button-chinh-sua.sm').removeClass('hidden');
      if($('.thongso').length > 0){
        // $('.show-photo-nav .gallery_01').addClass('gallery_02').removeClass('gallery_01');
        $('.zoomContainer').addClass('md');
        
        if(img_big != ''){
          $('.slider_sm').html('<ul><li><img src="'+img_big+'"></li></ul>');
          $('.gallery_02').addClass('md');
          $('.show-photo-nav .gallery_01').addClass('md');

          if(length_color > 0){
            $('#dp_color .txt_color').text($('.tqc1.is-active').text());
          }
          if(length_size > 0){
            $('#dp_size .txt_size').text($('.tqc2.is-active').text());
          }
          if(length_material > 0){
            $('#dp_meterial .txt_material').text($('.tqc3.is-active').text());
          }
        }else{
          slick_gall02();
          $('.gallery_02 .slick-track ul.slick-dots').remove();
        }
      }
    }
  });

  //iframe-video
  $( window ).on( "orientationchange", function( event ) {
    if ($(window).width() >= 1024) {
      $('#videopopup .modal-dialog').css('max-width','62%');
      $("#iframe-video").css({'height':'450px', 'width':'800px'});
    }
    else{
      $('.sanphamchitiet-content').removeAttr('style');
      $('.sanphamchitiet-content-gallery').removeAttr('style');
      var width_window = $( window ).innerHeight();
      width_video = width_window * 0.9;
      height_video = width_video*0.9 / 1.78;
      $("#iframe-video").css({'width':width_video+'px','height':height_video+'px'});
    }
  });
  
  $(document).ready(function()
  {

    var $win = $(window);
    var $box = $("#iframe-video");
    $win.on("click.Bst", function(event){
      if ($box.has(event.target).length == 0 && !$box.is(event.target)){
        $box.attr('src', $box.attr('src'));
      }
    });
    if ($('body').width() >= 1024) {
      $('#videopopup .modal-dialog').css('max-width','62%');
      $("#iframe-video").css({'height':'450px', 'width':'800px'});
    }
    else{
      var width_window = $( window ).innerWidth();
      width_video = width_window * 0.9;
      height_video = width_video*0.9 / 1.78;
      $("#iframe-video").css({'width':width_video+'px','height':height_video+'px'});
    }
    //khi user up ndsp thieu </div>
    $('.fix-thieudiv-1').insertAfter($('.thong-tin-cua-hang'));
    $('.fix-thieudiv-2').insertAfter($('.box-detailpro'));

  });

  /*function xemthem(){
    $('.content-pro').css('height','auto');
    $('.xemthem').text('Rút gọn');
    $('.xemthem').attr('onclick','rutgon()');
  }

  function rutgon(){
    $('.content-pro').css('height','450px');
    $('.xemthem').text('Xem thêm');
    $('.xemthem').attr('onclick','xemthem()');
  }*/

  function popupslider(key){
    var width_window = $( window ).innerHeight();
    var listImg = $('.show-photo-nav .slick-track li');
    if (listImg.length > 0) {
      $('.modal-show-detail').modal('show');
      var width_img = $('.modal-gallery-img #slider-for_333').innerWidth();
      $('.modal-gallery-img #slider-for_333 .slick-track').css('width',width_img+'px');
      $('.modal-gallery-img #slider-for_333 li.slick-slide').eq(key).css('width',width_img+'px');
      $('.modal-gallery-img #slider-for_333').slick('slickGoTo', parseInt(key));
    }
  }

  function SelectProSales(siteUrl, id) {
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "home/affiliate/ajax_select_pro_sales",
            dataType: 'json',
            data: {proid: id},
            success: function (data) {
                //console.log(data);
                if (data == '1') {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }
  //get thong tin hoa hong popup ctv
  $('body').on('click','.img-popup-ctv',function(){
    var copy_link = $(this).attr('data-url');
    var product_id = $(this).attr('data-product');
    var uoctinh = $(this).attr('data-key');
    var phantram = $(this).attr('data-valuea');
    var tien = $(this).attr('data-valueb');
    var html = $('.btn-selectsale-'+product_id).html();
    if(phantram > 0){
      $('.ptramhoahong').removeClass('hidden');
      $('#myModal_ctv .tilehoahong').text(phantram+'%');
    }else{
      $('.ptramhoahong').addClass('hidden');
      $('#myModal_ctv .tilehoahong').text(formatNumber(tien));
    }
    if(uoctinh != ''){
      $('#myModal_ctv .uoctinh').text(formatNumber(uoctinh));
    }else{
      $('#myModal_ctv .uoctinh').text(phantram+'% x giá lựa chọn');
    }
    $('#myModal_ctv').modal('show');
    html += '<button type="button" class="btn-bg-gray cursor-pointer btn-copy">Sao chép liên kết</button>';
    // onclick="copy_text('+"'"+copy_link+"'"+')"
    $('.btn-footer').html(html);
    copy_text(copy_link);
  });

  $('body').on('click','.img-popup-ctv-qc',function(){
    var phantram = $(this).attr('data-valuea');
    if(phantram > 0){
      $('#myModal_ctv .tilehoahong').text(phantram+'%');
      var tien = $('.proprice').attr('value');
      uoctinh = tien*(phantram/100);
      $('.ptramhoahong').removeClass('hidden');
    }else{
      var tien = $(this).attr('data-valueb');
      var uoctinh = $(this).attr('data-key');
      $('#myModal_ctv .tilehoahong').text(formatNumber(tien));
      $('.ptramhoahong').addClass('hidden');
    }
    $('#myModal_ctv .uoctinh').text(formatNumber(uoctinh));
    $('#myModal_ctv').modal('show');
  });
  //end get thong tin hoa hong popup ctv
  $('.sm-btn-show').click(function(){
    var parent = $(this).closest('.item-li');
    parent.toggleClass('show-action');
    if (parent.hasClass('show-action')) {
      $(this).find('img').attr('src','/templates/home/styles/images/svg/shop_icon_close.svg');
    } else {
      $(this).find('img').attr('src','/templates/home/styles/images/svg/shop_icon_add.svg');
    }
  });

  // $('.content-pro').find('div').attr('class','');
  $('.content-pro').find('p').attr('class','');

  $('.content-pro p').each(function() {
   var $this = $(this);
   if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
      $this.remove();
  });

</script>