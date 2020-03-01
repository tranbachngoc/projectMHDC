<?php $this->load->view('home/personal/affiliate/element/element-css-js')?>

<style type="text/css">
  ul.action-left-listaction.version01 li {
    margin-right: 20px !important;
  }
</style>
<div class="affiliate-content content-posts">
  <div class="affiliate-content-coupondetail">
    <div class="coupondetail-tit">
      <a href="<?=azibai_url("/affiliate/list?type_sv={$_REQUEST['type_sv']}&af_id={$current_profile['af_key']}")?>">
        <i class="fa fa-angle-left f18 mr05" aria-hidden="true"></i>
        <?=$service['name']?>
      </a>
    </div> 
    <div class="coupondetail-content post-detail">
      <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-12">
          <div class="img">
            <img src="<?=$service['sImage']?>" class="main-img" alt="">
          </div>
          <?php

          $data_textlike = 'Thích';
          if (!empty($is_like)) {
              $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg" >';
              $data_textlike = 'Bỏ thích';
          }
          else{
              $imgLike = '<img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">';
          }

          $show_like = '';
          $numlike = 0;
          if(!empty($list_likes))
          {
              $numlike = $list_likes;
              $show_like = ' js-show-like-service';
          }
          $type_share = '';
          $arr = array(
              'data_backwhite' => 1,
              'data_shr' => 1,
              'data_class_countact' => 'js-countact-service-'.$service['id'],
              'data_jsclass' => 'js-like-service js-like-service-'.$service['id'],
              'data_classshow' => $show_like,
              'data_url' => $share_url,
              'data_title' => $share_name,
              'data_user' => '',
              'data_typeshare' => $type_share,
              'data_id' => $service['id'],
              'data_imglike' => $imgLike,
              'data_numlike' => $numlike,
              'data_lishare' => 1,
              'data_textlike' => $data_textlike
              // 'data_typelink' => ' data-type_url="'.$type_link.'"'
            );
          $this->load->view('home/share/bar-btn-share', $arr);
          ?>
        </div>
        <div class="col-xl-8 col-lg-6 col-md-12">
          <div class="coupondetail-content-detail">
            <div class="tit"><?=$service['name']?></div>
            <?php if(empty($service['iDiscountPrice'])) { ?>
            <div class="price">
              <p class="price-after">Giá gốc:&#12288;
                <span><?=number_format($service['iPrice'], 0, ',', '.');?> VNĐ</span>
              </p>
            </div>
            <?php } else { ?>
            <div class="price">
              <p class="price-before">Giá gốc:&#12288;
                <span><?=number_format($service['iPrice'], 0, ',', '.');?> VNĐ</span>
              </p>
              <p class="price-after">Giá giảm:&#12288;
                <span><?=number_format($service['iDiscountPrice'], 0, ',', '.');?> VNĐ</span>
              </p>
            </div>
            <?php } ?>
            <div class="group-btn">
              <button class="btn-buynow" id="add_service">Mua ngay</button>
              <!-- <button class="btn-addcart">
                <img src="/templates/home/styles/images/svg/cart_pink.svg" class="mr05" alt="">Thêm vào giỏ hàng</button> -->
            </div>
            <div class="infor-coupon">
              <div class="infor-coupon-tit">Thông tin dịch vụ</div>
              <div class="infor-coupon-text">
                <?=$service['desc']?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('shop/service/popup-payment-service', ['service'=>$service_payment, 'iUserId'=>$service_payment['iUserId']], FALSE); ?>