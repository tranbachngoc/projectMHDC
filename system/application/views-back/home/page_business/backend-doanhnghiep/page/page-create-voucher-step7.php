<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 6;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 6;
  unset($request_tmp['price']);
  unset($request_tmp['discount_type']);
  unset($request_tmp['price_percent']);
  unset($request_tmp['price_discount']);
  unset($request_tmp['affiliate_type']);
  unset($request_tmp['affiliate_value_1']);
  unset($request_tmp['affiliate_value_2']);
  unset($request_tmp['affiliate_value_3']);
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}
?>


<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Xem lại mã giảm giá</a>
</div>
<div class="coupon-content">
  <div class="row preview-coupon">
    <div class="col-xl-4 col-md-6">
      <div class="preview-coupon-img">
        <div class="img">
          <img src="/templates/home/styles/images/svg/bg_dichvu.png" alt="" class="ava_voucher">
        </div>
        <div class="group-action-likeshare">
          <!-- <div class="show-number-action version02">
            <ul>
              <li data-toggle="modal" data-target="#luotthich">
                <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">48</li>
              <li>15 bình luận</span>
              </li>
              <li>5 chia sẻ</span>
              </li>
            </ul>
          </div>
          <div class="action">
            <div class="action-left">
              <ul class="action-left-listaction">
                <li class="like">
                  <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like">
                </li>
                <li class="comment">
                  <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                </li>
                <li class="share-click">
                  <span>
                    <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                  </span>
                </li>
                <li>
                  <img src="/templates/home/styles/images/svg/bookmark.svg" alt="">
                </li>
              </ul>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="col-xl-8 col-md-6">
      <div class="preview-coupon-detail">
        <ul>
          <li>
            <p class="tt">Mã giảm giá</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control"
                value="<?=$_REQUEST['voucher_type'] == 1 ? $_REQUEST['value'] . '%'
                : ($_REQUEST['voucher_type'] == 2 ? number_format($_REQUEST['value'], 0, ',' , '.') . ' VNĐ' : '')?>">
              <span class="unit js-edit-step2">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <?php if($_REQUEST['product_type'] == 1 && $_REQUEST['price_rank'] > 0) { ?>
          <li>
            <p class="tt">Áp dụng cho tất cả sản phẩm</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" name="price_rank" value="<?=@$_REQUEST['price_rank'] ? 'Giá trị đơn hàng tối thiểu: '.number_format($_REQUEST['price_rank'], 0, ',' , '.') . ' VNĐ' : ''?>">
              <span class="unit js-edit-step1">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <?php } else if($_REQUEST['count_item'] > 0) { ?>
          <li>
            <p class="tt">Áp dụng cho <?=$_REQUEST['count_item'] ? $_REQUEST['count_item'] : 0?> sản phẩm</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" value="Danh sách sản phẩm được áp dụng">
              <span class="unit js-edit-step1">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <?php } ?>
          <li>
            <p class="tt">Thời gian áp dụng</p>
            <label class="has-unit">
              <input type="text" placeholder="Vui lòng nhập thông tin" disabled class="form-control" value="<?=@$_REQUEST['time_start'] && @$_REQUEST['time_end'] ? "{$_REQUEST['time_start']} đến {$_REQUEST['time_end']}" : ''?>">
              <span class="unit js-edit-step4">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Số lượng</p>
            <label class="has-unit">
              <input type="text" placeholder="Vui lòng nhập thông tin" disabled class="form-control" value="<?=@$_REQUEST['quantily'] ? number_format($_REQUEST['quantily'], 0, ',' , '.') : ''?>">
              <span class="unit js-edit-step3">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Bán hộ</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập thông tin"
              value="<?=$_REQUEST['apply'] == 1 ? 'Cho phép tất cả'
              : ($_REQUEST['apply'] == 3 ? 'Chỉ cho hệ thống cộng tác viên của azibai bán'
              : ($_REQUEST['apply'] == 2 ? 'Chỉ cho hệ thống cộng tác viên của tôi bán' : ''))?>" >
              <span class="unit js-edit-step5">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Giá niêm yết </p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập giá" value="<?=@$_REQUEST['price'] ? number_format($_REQUEST['price'], 0, ',' , '.') . ' VNĐ': ''?>">
              <span class="unit js-edit-step6">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Ưu đãi</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập giá"
              value="<?=$_REQUEST['discount_type'] == 1 ? $_REQUEST['price_percent'] . '%'
              : ($_REQUEST['discount_type'] == 2 ? number_format($_REQUEST['price_discount'], 0, ',' , '.') .' VNĐ': '')?>">
              <span class="unit js-edit-step6">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Hoa hồng cho nhà phân phối</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập giá"
              value="<?=$_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_1'] . '%'
              : ($_REQUEST['affiliate_type'] == 2 ? number_format($_REQUEST['affiliate_value_1'], 0, ',' , '.') .' VNĐ' : '')?>">
              <span class="unit js-edit-step6">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Hoa hồng cho tổng đại lý</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập giá"
              value="<?=$_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_2'] . '%'
              : ($_REQUEST['affiliate_type'] == 2 ? number_format($_REQUEST['affiliate_value_2'], 0, ',' , '.') .' VNĐ' : '')?>">
              <span class="unit js-edit-step6">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
          <li>
            <p class="tt">Hoa hồng cho đại lý</p>
            <label class="has-unit">
              <input type="text" disabled class="form-control" placeholder="Vui lòng nhập giá"
              value="<?=$_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_3'] . '%'
              : ($_REQUEST['affiliate_type'] == 2 ? number_format($_REQUEST['affiliate_value_3'], 0, ',' , '.').' VNĐ' : '')?>">
              <span class="unit js-edit-step6">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </span>
            </label>
          </li>
        </ul>
        <?php if($show_submit == true) { ?>
        <div class="text-center">
          <div class="btn-post-coupon js-submit">Đăng mã giảm giá</div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script>
  <?php
  // $_REQUEST['skip'] = 0;
  $qstring = http_build_query($_REQUEST);
  ?>
  var url = '<?=azibai_url("/page-business/create-voucher/{$user_id}?")?>';
  $('.js-edit-step1, .js-edit-step2, .js-edit-step3, .js-edit-step4, .js-edit-step5, .js-edit-step6').on('click', function () {
    // var qstring = window.location.search.slice(1);
    var qstring = '<?=$qstring?>';
    qstring = qstring + '&is_review=1'

    if($(this).hasClass('js-edit-step1')) {
      qstring = qstring.replace("step=7","step=1");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

    if($(this).hasClass('js-edit-step2')) {
      qstring = qstring.replace("step=7","step=2");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

    if($(this).hasClass('js-edit-step3')) {
      qstring = qstring.replace("step=7","step=3");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

    if($(this).hasClass('js-edit-step4')) {
      qstring = qstring.replace("step=7","step=4");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

    if($(this).hasClass('js-edit-step5')) {
      qstring = qstring.replace("step=7","step=5");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

    if($(this).hasClass('js-edit-step6')) {
      qstring = qstring.replace("step=7","step=6");
      var rd_url = url + qstring;
      window.location.href = rd_url;
      return false;
    }

  })
    $('.ava_voucher').attr('src', localStorage.getItem("voucher_avatar"));
</script>

<?php if($show_submit == true) { ?>
<script>
  $('.js-submit').click(function () {
    var url_ajax = '<?=azibai_url() ."/home/api_affiliate/create_voucher/{$user_id}?". http_build_query($_REQUEST) ?>';
    $.ajax({
      type: "POST",
      url: url_ajax,
      dataType: "JSON",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        if(response.status == 1) {
          var data = response.data
          var show = '<?=azibai_url("/page-business/create-voucher/{$user_id}?view=")?>' + data.voucher_id;
          <?php if(@$_REQUEST['back'] == 1) { ?>
            show += '&back=1';
          <?php } ?>
          window.location.replace(show);
          return false;
        } else {
          $('.load-wrapp').hide();
          alert('Lỗi dữ liệu!!!')
        }
      },
      error: function () {
        $('.load-wrapp').hide();
      }
    });
  });
</script>
<?php } ?>