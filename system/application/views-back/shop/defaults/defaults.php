<?php $this->load->view('shop/common/header'); ?>
<?php 
$protocol = get_server_protocol();
if ($siteGlobal->sho_logo != "") {
  $sho_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $siteGlobal->sho_dir_logo . '/' . $siteGlobal->sho_logo;
} else {
  $sho_logo = '';
}

if ($isAffiliate == TRUE && $siteGlobal->sho_banner == "") {
  $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $Pa_Shop_Global->sho_dir_banner . '/' . $Pa_Shop_Global->sho_banner;
} else {
  $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $siteGlobal->sho_dir_banner . '/' . $siteGlobal->sho_banner;
}

?>
<main>
  <div class="container">
    <div class="gioithieucuahang">
      <div class="gioithieucuahang-left">
        <div class="hinhdaidien">
          <img src="<?= $sho_logo ?>" alt="">
        </div>
        <div class="tenshop">
          <p><?php echo $siteGlobal->sho_name ?><br><span>Online 15 phút trước</span></p>
          <p><img src="/templates/home/styles/images/svg/CTV_add.svg" alt=""></p>
        </div>
      </div>
      <div class="gioithieucuahang-right">
        <div class="nguoitheodoi">
          <p>Người theo dõi <span>567</span></p>
          <p class="btn-bosuutap"><a href="<?php echo base_url() . 'shop/collection';?>"><img src="/templates/home/styles/images/svg/bookmark.svg" width="20" class="mr10" alt="">Bộ sưu tập</a></p>
        </div>
        <div class="nhantin-theodoi">
          <?php if($use_id == $this->session->userdata('sessionUser')) { ?>
          <p><img src="/templates/home/styles/images/svg/bag.svg" width="15" class="mr10" alt="">Đơn hàng</p>
          <p><img src="/templates/home/styles/images/svg/sanpham.svg" width="19" class="mr10" alt="">Sản phẩm</p>
          <?php } else { ?>
          <p><a href="mailto:<?=$id_user->use_email;?>"><img src="/templates/home/styles/images/svg/icon_mail.svg" width="24" class="mr10" alt="">Nhắn tin</a></p>
          <p><img src="/templates/home/styles/images/svg/add.svg" width="24" class="mr10" alt="">Theo dõi</p>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="banner">
      <ul class="banner-slider">
        <li><img src="<?=$srcbanner?>" alt=""></li>
        <!-- <li><img src="/templates/home/styles/images/cover/slide01.jpg" alt=""></li> -->
      </ul>
      <!-- <ul class="banner-images">
        <li><img src="/templates/home/styles/images/product/shop/img01.jpg" alt=""></li>
        <li><img src="/templates/home/styles/images/product/shop/img01.jpg" alt=""></li>
        <li><img src="/templates/home/styles/images/product/shop/img01.jpg" alt=""></li>
        <li class="tablet-none "><img src="/templates/home/styles/images/product/shop/img01.jpg" alt=""></li>
      </ul> -->
    </div>
    <?php if($product_sale || $coupon_sale) { ?>
    <div class="danhsachsanpham">
      <div class="danhsachsanpham-tieude">
        <div class="danhsachsanpham-tieude-left">Khuyến mãi</div>
        <div class="danhsachsanpham-tieude-right">
          <ul>
            <?php if($product_sale) { ?><li class="active" id="p_sale"><a href="JavaScript:Void(0);">sản phẩm</a></li><?php } ?>
            <?php if($coupon_sale) { ?><li id="c_sale" <?php echo( count($product_sale) > 0 ? 'class=""' : 'class="active"') ?>><a href="JavaScript:Void(0);">coupon</a></li><?php } ?>
          </ul>
        </div>
      </div>
      <div class="danhsachsanpham-chitiet">
        <?php if($product_sale) { ?>
        <ul class="danhsachsanpham-chitiet-slider" id="p_sale_show">
          <?php foreach ($product_sale as $key => $value) { ?>
          <?php 
            $pro_image = explode(',', $value->pro_image)[0];
            $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          ?>
          <li>
            <div class="hinh">
              <a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><img src="<?=$src?>" alt=""></a>
              <!-- <span class="giohang"><img src="/templates/home/styles/images/svg/bag_white.svg" width="24" alt=""></span> -->
              <!-- <span class="ctv"><img src="/templates/home/styles/images/svg/CTV.svg" alt=""></span> -->
              <div class="flashsale">
                <h2>Flash sale</h2>
                <div class="info" id='flash-sale_<?php echo $value->pro_id . $key ?>'>
                  <script>
                  cd_time(<?php echo $value->end_date_sale * 1000 ; ?>,<?php echo $value->pro_id . $key ?>);
                  </script>
                </div>
                <button onclick='addCartQtyAtShop(<?php echo $value->pro_id?>)'>Thêm vào giỏ</button>
              </div>
            </div>
            <div class="thongtin">
              <h3><a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><?=$value->pro_name?></a></h3>
              <div class="gia">
                <p class="chuagiam">
                  <span class="dong">đ</span><span style="text-decoration: line-through;"><?php echo number_format($value->pro_cost, 0, ",", "."); ?></span>
                </p>
                <?php 
                if($value->pro_saleoff == 1) { // giảm theo %
                  $sale = $value->pro_cost - ($value->pro_cost * $value->pro_saleoff_value / 100);
                } else {
                  $sale = $value->pro_cost - $value->pro_saleoff_value;
                }
                ?>
                <p class="dagiam"><span class="dong">đ</span><?php echo number_format($sale, 0, ",", "."); ?></p>
              </div>
            </div>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
        <?php if($coupon_sale) { ?>
        <ul class="danhsachsanpham-chitiet-slider" id="c_sale_show" <?php echo( count($product_sale) > 0 ? 'style="display:none"' : 'style="display:block"') ?> >
          <?php foreach ($coupon_sale as $key => $value) { ?>
          <?php 
            $pro_image = explode(',', $value->pro_image)[0];
            $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          ?>
          <li>
            <div class="hinh">
              <a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><img src="<?=$src?>" alt=""></a>
              <!-- <span class="giohang"><img src="/templates/home/styles/images/svg/bag_white.svg" width="24" alt=""></span> -->
              <!-- <span class="ctv"><img src="/templates/home/styles/images/svg/CTV.svg" alt=""></span> -->
              <div class="flashsale">
                <h2>Flash sale</h2>
                <div class="info" id='flash-sale_<?php echo $value->pro_id . $key ?>'>
                  <script>
                  cd_time(<?php echo $value->end_date_sale * 1000 ; ?>,<?php echo $value->pro_id . $key ?>);
                  </script>
                </div>
                <button onclick='addCartQtyAtShop(<?php echo $value->pro_id?>)'>Thêm vào giỏ</button>
              </div>
            </div>
            <div class="thongtin">
              <h3><a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><?=$value->pro_name?></a></h3>
              <div class="gia">
                <p class="chuagiam">
                  <span class="dong">đ</span><span style="text-decoration: line-through;"><?php echo number_format($value->pro_cost, 0, ",", "."); ?></span>
                </p>
                <?php 
                if($value->pro_saleoff == 1) { // giảm theo %
                  $sale = $value->pro_cost - ($value->pro_cost * $value->pro_saleoff_value / 100);
                } else {
                  $sale = $value->pro_cost - $value->pro_saleoff_value;
                }
                ?>
                <p class="dagiam"><span class="dong">đ</span><?php echo number_format($sale, 0, ",", "."); ?></p>
              </div>
            </div>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php if($product_sale) {?>
        <div>
          <div class="text-center xemthem-sale"><a href="<?php echo base_url() . 'shop/product' ?>"><button class="xemthem">Xem thêm</button></a></div>
          <div class="text-center xemthem-sale" style="display:none"><a href="<?php echo base_url() . 'shop/coupon' ?>"><button class="xemthem">Xem thêm</button></a></div>        
        </div>
      <?php } else { 
        if($coupon_sale) { ?>
        <div>
          <div class="text-center xemthem-sale" style="display:none"><a href="<?php echo base_url() . 'shop/product' ?>"><button class="xemthem">Xem thêm</button></a></div>
          <div class="text-center xemthem-sale"><a href="<?php echo base_url() . 'shop/coupon' ?>"><button class="xemthem">Xem thêm</button></a></div>        
        </div>
      <?php }
      } ?>
    </div>
    <?php } ?>

    <?php if($product_new || $coupon_new) { ?>
    <div class="danhsachsanpham">
      <div class="danhsachsanpham-tieude">
        <div class="danhsachsanpham-tieude-left">Mẫu mới</div>
        <div class="danhsachsanpham-tieude-right">
          <ul>
            <?php if($product_new) { ?><li class="active" id="p_new"><a href="JavaScript:Void(0);">sản phẩm</a></li><?php } ?>
            <?php if($coupon_new) { ?><li id="c_new" <?php echo( count($product_new) > 0 ? 'class=""' : 'class="active"') ?>><a href="JavaScript:Void(0);">coupon</a></li><?php } ?>
          </ul>
        </div>
      </div>
      <div class="danhsachsanpham-chitiet">
        <?php if($product_new) { ?>
        <ul class="danhsachsanpham-chitiet-slider" id="p_new_show">
          <?php foreach ($product_new as $key => $value) { ?>
          <?php 
            $pro_image = explode(',', $value->pro_image)[0];
            $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          ?>
          <li>
            <div class="hinh">
              <a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><img src="<?=$src?>" alt=""></a>
            </div>
            <div class="thongtin">
              <h3><a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><?=$value->pro_name?></a></h3>
              <div class="gia">
                <!-- <p class="chuagiam">
                  <span class="dong">đ</span><span style="text-decoration: line-through;">950.000.000</span>
                </p> -->
                <p class="dagiam"><span class="dong">đ</span><?php echo number_format($value->pro_cost, 0, ",", "."); ?></p>
                <!-- <p class="bo">Bộ</p> -->
              </div>
            </div>
            <div class="hanhdong">
              <p><button onclick='addCartQtyAtShop(<?php echo $value->pro_id?>)'>Thêm vào giỏ </button></p>
            </div>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
        <?php if($coupon_new) { ?>
        <ul class="danhsachsanpham-chitiet-slider" id="c_new_show" <?php echo( count($product_new) > 0 ? 'style="display:none"' : 'style="display:block"') ?>>
          <?php foreach ($coupon_new as $key => $value) { ?>
          <?php 
            $pro_image = explode(',', $value->pro_image)[0];
            $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          ?>
          <li>
            <div class="hinh">
              <a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><img src="<?=$src?>" alt=""></a>
            </div>
            <div class="thongtin">
              <h3><a href="<?php echo $protocol . domain_site . '/' . $value->pro_category . '/' . $value->pro_id . '/' . $value->pro_name;  ?>"><?=$value->pro_name?></a></h3>
              <div class="gia">
                <!-- <p class="chuagiam">
                  <span class="dong">đ</span><span style="text-decoration: line-through;">950.000.000</span>
                </p> -->
                <p class="dagiam"><span class="dong">đ</span><?php echo number_format($value->pro_cost, 0, ",", "."); ?></p>
                <!-- <p class="bo">Bộ</p> -->
              </div>
            </div>
            <div class="hanhdong">
              <p><button onclick='addCartQtyAtShop(<?php echo $value->pro_id?>)'>Thêm vào giỏ </button></p>
            </div>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php if($product_new) {?>
        <div>
          <div class="text-center xemthem-new"><a href="<?php echo base_url() . 'shop/product' ?>"><button class="xemthem">Xem thêm</button></a></div>
          <div class="text-center xemthem-new" style="display:none"><a href="<?php echo base_url() . 'shop/coupon' ?>"><button class="xemthem">Xem thêm</button></a></div>        
        </div>
      <?php } else { 
        if($coupon_new) { ?>
        <div>
          <div class="text-center xemthem-new" style="display:none"><a href="<?php echo base_url() . 'shop/product' ?>"><button class="xemthem">Xem thêm</button></a></div>
          <div class="text-center xemthem-new"><a href="<?php echo base_url() . 'shop/coupon' ?>"><button class="xemthem">Xem thêm</button></a></div>        
        </div>
      <?php }
      } ?>
      
    </div>
    <?php } ?>
  </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="dialog_mess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body" id="mess_detail">

      </div>
      
    </div>
  </div>
</div>

<script src="/templates/home/boostrap/js/popper.min.js"></script>
<script src="/templates/home/boostrap/js/bootstrap.min.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script type="text/javascript">
  $('.banner-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    dots: true
  });
  $('.danhsachsanpham-chitiet-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    arrows: true,
    responsive: [{
        breakpoint: 1025,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          arrows: false,
        }
      }
    ]
  });
</script>
<script type="text/javascript">
  $('#p_new').click(function(){
    if( $(this).hasClass( 'active' ) == false) {
      $(this).addClass( 'active' );
      $('#c_new').removeClass( 'active' );
      $('#c_new_show').hide();
      $('#p_new_show').show(0,function(){
        $('.xemthem-new').first().show();
        $('.xemthem-new').last().hide();
        $('.danhsachsanpham-chitiet-slider').slick('unslick');
        $('.danhsachsanpham-chitiet-slider').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          responsive: [{
              breakpoint: 1025,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              }
            }
          ]
        });
      });
    };
  });

  $('#c_new').click(function(){
    if( $(this).hasClass( 'active' ) == false) {
      $(this).addClass( 'active' );
      $('#p_new').removeClass( 'active' );
      $('#p_new_show').hide();
      $('#c_new_show').show(0,function(){
        $('.xemthem-new').first().hide();
        $('.xemthem-new').last().show();
        $('.danhsachsanpham-chitiet-slider').slick('unslick');
        $('.danhsachsanpham-chitiet-slider').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          responsive: [{
              breakpoint: 1025,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              }
            }
          ]
        });

      });
    };
  });

  $('#p_sale').click(function(){
    if( $(this).hasClass( 'active' ) == false) {
      $(this).addClass( 'active' );
      $('#c_sale').removeClass( 'active' );
      $('#c_sale_show').hide();
      $('#p_sale_show').show(0,function(){
        $('.xemthem-sale').first().show();
        $('.xemthem-sale').last().hide();
        $('.danhsachsanpham-chitiet-slider').slick('unslick');
        $('.danhsachsanpham-chitiet-slider').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          responsive: [{
              breakpoint: 1025,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              }
            }
          ]
        });
      });
    };
  });

  $('#c_sale').click(function(){
    if( $(this).hasClass( 'active' ) == false) {
      $(this).addClass( 'active' );
      $('#p_sale').removeClass( 'active' );
      $('#p_sale_show').hide();
      $('#c_sale_show').show(0,function(){
        $('.xemthem-sale').first().hide();
        $('.xemthem-sale').last().show();
        $('.danhsachsanpham-chitiet-slider').slick('unslick');
        $('.danhsachsanpham-chitiet-slider').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          arrows: true,
          responsive: [{
              breakpoint: 1025,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              }
            }
          ]
        });

      });
    };
  });

</script>

<?php $this->load->view('shop/common/footer'); ?>