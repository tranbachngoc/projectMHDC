<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 5;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 5;
  unset($request_tmp['apply']);
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}

// next step review
$params_review = $_REQUEST;
$params_review['step'] = 7;
$params_review['skip'] = 1;
unset($params_review['is_review']);
$link_review = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($params_review);
?>

<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Cho phép cộng tác viên bán hộ</a>
  <a href="<?=$link_review?>">
    <p class="previous"><img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt=""><span class="md">Xem trước</span></p>
  </a>
</div>
<div class="coupon-stepdot">
  <ul>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
  </ul>
</div>
<div class="coupon-content">
  <div class="ctv-content">
    <div class="ctv-content-item">
      <h3 class="tt">Giá niêm yết</h3>
      <div class="text">
        <label class="has-unit">
          <input type="text" class="form-control js-price" placeholder="Nhập số" value="<?=$_REQUEST['is_review'] == 1 ? $_REQUEST['price'] : ''?>">
          <span class="unit">VND</span>
        </label>
        <p class="small-text">Giá niêm yết là giá bán trực tiếp từ người bán</p>
      </div>
    </div>
    <div class="ctv-content-item">
      <h3 class="tt">Giá ưu đãi qua hệ thống bán hộ</h3>
      <div class="text">
        <div class="accordion js-accordion special-price">
          <div class="accordion-item special-price-item js-box1-item" data-type="1">
            <div class="accordion-toggle special-price-title js-box1-item-click js-class-1">
              Ưu đãi theo phần trăm
            </div>
            <div class="accordion-panel special-price-text">
              <label class="has-unit">
                <input type="text" class="form-control js-discount_value" placeholder="Nhập số từ 0 đến 100" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['discount_type'] == 1 ? $_REQUEST['price_percent'] : ''?>">
                <span class="unit">%</span>
              </label>
              <p class="small-text">Giá niêm yết là giá bán trực tiếp từ người bán</p>
            </div>
          </div>
          <div class="accordion-item special-price-item js-box1-item" data-type="2">
            <div class="accordion-toggle special-price-title js-box1-item-click js-class-2">
              Ưu đãi theo giá tiền
            </div>
            <div class="accordion-panel special-price-text">
              <label class="has-unit">
                <input type="text" class="form-control js-discount_value" placeholder="Nhập số tiền ưu đãi nhỏ hơn hoặc bằng giá niêm yết" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['discount_type'] == 2 ? $_REQUEST['price_discount'] : ''?>">
                <span class="unit">VND</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ctv-content-item">
      <h3 class="tt">Hoa hồng cho hệ thống bán hộ</h3>
      <div class="text">
        <div class="accordion js-accordion02 special-price">
          <div class="accordion-item02 special-price-item js-box2-item" data-type="1">
            <div class="accordion-toggle02 special-price-title js-box2-item-click js-class-3">
              Hưởng phần trăm trên mỗi đơn hàng
            </div>
            <div class="accordion-panel02 special-price-text">
              <div class="flex-center">
                <p class="txt">Hoa hồng cho nhà phân phối</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_1" placeholder="Nhập số từ 0 đến 100" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_1'] : ''?>">
                  <span class="unit">%</span>
                </label>
              </div>
              <div class="flex-center">
                <p class="txt">Hoa hồng cho tổng đại lý</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_2" placeholder="" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_2'] : ''?>" <?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_value_2'] ? '' : 'disabled'?>>
                  <span class="unit">%</span>
                </label>
              </div>
              <div class="flex-center">
                <p class="txt">Hoa hồng cho đại lý</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_3" placeholder="" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 1 ? $_REQUEST['affiliate_value_3'] : ''?>" <?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_value_3'] ? '' : 'disabled'?>>
                  <span class="unit">%</span>
                </label>
              </div>
            </div>
          </div>
          <div class="accordion-item02 special-price-item js-box2-item" data-type="2">
            <div class="accordion-toggle02 special-price-title js-box2-item-click js-class-4">
              Hưởng số tiền trên mỗi đơn hàng
            </div>
            <div class="accordion-panel02 special-price-text">
              <div class="flex-center">
                <p class="txt">Hoa hồng cho nhà phân phối</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_1" placeholder="" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 2 ? $_REQUEST['affiliate_value_1'] : ''?>" <?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_value_1'] ? '' : 'disabled'?>>
                  <span class="unit">VND</span>
                </label>
              </div>
              <div class="flex-center">
                <p class="txt">Hoa hồng cho tổng đại lý</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_2" placeholder="" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 2 ? $_REQUEST['affiliate_value_2'] : ''?>" <?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_value_2'] ? '' : 'disabled'?>>
                  <span class="unit">VND</span>
                </label>
              </div>
              <div class="flex-center">
                <p class="txt">Hoa hồng cho đại lý</p>
                <label class="has-unit">
                  <input type="text" class="form-control js-affiliate_value_3" placeholder="" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 2 ? $_REQUEST['affiliate_value_3'] : ''?>" <?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_value_3'] ? '' : 'disabled'?>>
                  <span class="unit">VND</span>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center js-next-step-7" style="display:none">
    <a href="javascript:void(0)" class="btn-continue">Tiếp tục</a>
  </div>
</div>

<script type="text/javascript">
  var $accordion = $(".js-accordion02");
  var $allPanels = $(".accordion-panel02").hide();
  var $allItems = $(".accordion-item02");

  // Event listeners
  $accordion.on("click", ".accordion-toggle02", function () {
    // Toggle the current accordion panel and close others
    $allPanels.slideUp();
    $allItems.removeClass("is-open");
    if (
      $(this)
        .next()
        .is(":visible")
    ) {
      $(".accordion-panel02").slideUp();
    } else {
      $(this)
        .next()
        .slideDown()
        .closest(".accordion-item02")
        .addClass("is-open");
    }
    return false;
  });
</script>

<script>
  var price = null;
  var discount_type = null;
  var discount_value = null;
  var affiliate_type = null;
  var affiliate_value_1 = null;
  var affiliate_value_2 = null;
  var affiliate_value_3 = null;
  var price_compare = 0;

  $('.js-price').change(function () {
    price = null;
    price = parseInt($(this).val());

    if(price < 1 || isNaN(price)) {
      $(this).val('');
      $(this).trigger('focus');
      price = null;
      if(affiliate_type === 2) { // Hưởng số tiền trên mỗi đơn hàng
        $('.js-affiliate_value_1, .js-affiliate_value_2, .js-affiliate_value_3').attr('disabled', true);
        $('.js-affiliate_value_1, .js-affiliate_value_2, .js-affiliate_value_3').val('');
      }
      // check next
      check_show_next();
    } else {
      $(this).val(price);
      if(affiliate_type === 2) { // Hưởng số tiền trên mỗi đơn hàng
        $('.js-affiliate_value_1').attr('disabled', false);
      }

      // check 2 fiel price sau khi nhập, chỉnh sữa input price
      if(price < discount_value) {
        if(discount_type === 2) {
          var div_discount = $('.js-box1-item')[1];
          $(div_discount).find('.js-discount_value').val('');
          $(div_discount).find('.js-discount_value').trigger('focus');
        }
      } else {
        if(discount_type === 2) {
          var div_discount = $('.js-box1-item')[1];
          $(div_discount).find('.js-discount_value').trigger('change');
        }
      }
      // check next
      check_show_next();
    }
  });

  $('.js-box1-item > .js-box1-item-click').on('click', function () {
    discount_type = discount_value = null;
    element = $(this).closest('.js-box1-item');
    if(!$(element).hasClass('is-open')) { // open
      discount_type = parseInt($(element).attr('data-type'));
      if(price === null) {
        discount_type = discount_value = null;
        $('.js-price').trigger('focus');
        return false;
      } else {
        $(element).find('.js-discount_value').attr('disabled', false);
        $(element).find('.js-discount_value').trigger('change');
      }
      // check next
      check_show_next();
    } else { // close
      // $('.js-discount_value').val('');
      // check next
      check_show_next();
    }
  })

  $('.js-discount_value').change(function () {
    discount_value = null;
    price_compare = 0;
    if(discount_type === 1 || discount_type === 2) {
      discount_value = parseInt($(this).val());
      if( (discount_type === 1 && discount_value > 0 && discount_value <= 100 && !isNaN(discount_value))
      || (discount_type === 2 && (discount_value > 0 && !isNaN(discount_value)) && discount_value <= price)
      ) {
        $(this).val(discount_value);

        discount_type === 1 ? price_compare = price - (price * discount_value)/100 : (discount_type === 2 ? price_compare = price - discount_value : 0);
        $($('.js-box2-item')[1]).find('.js-affiliate_value_1').attr('placeholder', 'Nhập số tiền nhỏ hơn hoặc bằng ' + price_compare);
        $($('.js-box2-item')[0]).find('.js-affiliate_value_1').attr('placeholder', 'Từ 0 đến 100 ');

        //affiliate_type = 2::  check discount_value có data sau khi thay đổi data thì affiliate_value còn đúng hay không
        if(affiliate_type == 2 && affiliate_value_1 > price_compare) { // affiliate_value_1 data không còn đúng
          var div_discount = $('.js-box2-item')[1];
          $(div_discount).find('.js-affiliate_value_1').trigger('change');
        }
        // check next
        check_show_next();

      } else {
        $(this).val('');
        $(this).trigger('focus');
        discount_value = null;
        $($('.js-box2-item')[1]).find('.js-affiliate_value_1').attr('placeholder', 'Nhập số tiền nhỏ hơn hoặc bằng ' + price_compare);
        $($('.js-box2-item')[0]).find('.js-affiliate_value_1').attr('placeholder', 'Từ 0 đến 100 ');
        // check next
        check_show_next();
      }
    }
  });

  $('.js-box2-item > .js-box2-item-click').on('click', function (event) {
    affiliate_type = null;
    // aff_type_tmp = 2; // aff về tiền VND
    element = $(this).closest('.js-box2-item');
    if(!$(element).hasClass('is-open')) { // open -> element chưa có class is-open
      affiliate_type = parseInt($(element).attr('data-type'));
      if(price === null) { // check price đã có chưa
        $('.js-price').trigger('focus');
        return false;
      } else if(discount_value === null) { // check discount_value đã có chưa
        if(discount_type === null || discount_type === 1) {
          var div_discount = $('.js-box1-item')[0];
          if(!$(div_discount).hasClass('is-open')) {
            $(div_discount).find('.js-box1-item-click').trigger('click');
          }
          $(div_discount).find('.js-discount_value').trigger('focus');
          return false;
        } else if (discount_type === 2) {
          var div_discount = $('.js-box1-item')[1];
          if(!$(div_discount).hasClass('is-open')) {
            $(div_discount).find('.js-box1-item-click').trigger('click');
          }
          $(div_discount).find('.js-discount_value').trigger('focus');
          return false;
        }
      } else {
        $(element).find('.js-affiliate_value_1').attr('disabled', false);
        // if(aff_type_tmp === affiliate_type && check_show_next()) {
          $(element).find('.js-affiliate_value_1').trigger('change');
          $(element).find('.js-affiliate_value_2').trigger('change');
          $(element).find('.js-affiliate_value_3').trigger('change');
        // }
      }
      // check next
      check_show_next();
    } else { // close
      $('.js-affiliate_value_1').attr('disabled', true);
      $('.js-affiliate_value_2').attr('disabled', true);
      $('.js-affiliate_value_3').attr('disabled', true);
      // check next
      check_show_next();
    }
  })

  $('.js-affiliate_value_1').change(function () {
    affiliate_value_1 = null;
    if(affiliate_type === 1 || affiliate_type === 2) {
      affiliate_value_1 = parseInt($(this).val());
      console.log('affiliate_value_1',affiliate_value_1);

      if( (affiliate_type === 1 && (affiliate_value_1 < 0 || affiliate_value_1 > 100 || isNaN(affiliate_value_1)))
      || (affiliate_type === 2 && ((affiliate_value_1 < 0 || isNaN(affiliate_value_1) || affiliate_value_1 > price_compare)))
      ) {
        $(this).val('');
        affiliate_value_1 = null;
        if(affiliate_type === 1) {
          var div_discount = $('.js-box2-item')[0];
          $(div_discount).find('.js-affiliate_value_2, .js-affiliate_value_3').attr('disabled', true).attr('placeholder', '').val('');
        }
        if(affiliate_type === 2) {
          var div_discount = $('.js-box2-item')[1];
          $(div_discount).find('.js-affiliate_value_2, .js-affiliate_value_3').attr('disabled', true).attr('placeholder', '').val('');
        }
        // check next
        check_show_next();
      } else {
        $(this).val(affiliate_value_1);
        var element = $(this).closest('.js-box2-item');
        var input = $(element).find('.js-affiliate_value_2');
        $(input).attr('disabled', false);
        if(affiliate_type === 1) {
          $(input).attr('placeholder', 'Nhập từ 0 đến ' + affiliate_value_1);
        }
        if(affiliate_type === 2) {
          $(input).attr('placeholder', 'Nhập số tiền nhỏ hơn hoặc bằng ' + affiliate_value_1);
        }
        $(input).trigger('focus');
      }
    }
  });

  $('.js-affiliate_value_2').change(function () {
    affiliate_value_2 = null;
    if(affiliate_type === 1 || affiliate_type === 2) {
      affiliate_value_2 = parseInt($(this).val());
      // console.log('affiliate_value_2',affiliate_value_2);
      if( (affiliate_type === 1 && (affiliate_value_2 < 0 || affiliate_value_2 > 100 || isNaN(affiliate_value_2)))
      || (affiliate_type === 2 && ((affiliate_value_2 < 0 || isNaN(affiliate_value_2) || affiliate_value_2 > affiliate_value_1)))
      || affiliate_value_2 > affiliate_value_1 || affiliate_value_2 < affiliate_value_3
      ) {
        $(this).val('');
        affiliate_value_2 = null;
        if(affiliate_type === 1) {
          var div_discount = $('.js-box2-item')[0];
          $(div_discount).find('.js-affiliate_value_3').attr('disabled', true).attr('placeholder', '').val('');
        }
        if(affiliate_type === 2) {
          var div_discount = $('.js-box2-item')[1];
          $(div_discount).find('.js-affiliate_value_3').attr('disabled', true).attr('placeholder', '').val('');
        }
        // check next
        check_show_next();
      } else {
        $(this).val(affiliate_value_2);
        var element = $(this).closest('.js-box2-item');
        var input = $(element).find('.js-affiliate_value_3');
        $(input).attr('disabled', false);
        if(affiliate_type === 1) {
          $(input).attr('placeholder', 'Nhập từ 0 đến ' + affiliate_value_2);
        }
        if(affiliate_type === 2) {
          $(input).attr('placeholder', 'Nhập số tiền nhỏ hơn hoặc bằng ' + affiliate_value_2);
        }
        $(input).trigger('focus');
      }
    }
  });

  $('.js-affiliate_value_3').change(function () {
    affiliate_value_3 = null;
    if(affiliate_type === 1 || affiliate_type === 2) {
      affiliate_value_3 = parseInt($(this).val());
      // console.log('affiliate_value_1',affiliate_value_1);
      if( (affiliate_type === 1 && (affiliate_value_3 < 0 || affiliate_value_3 > 100 || isNaN(affiliate_value_3)))
      || (affiliate_type === 2 && ((affiliate_value_3 < 0 || isNaN(affiliate_value_3) || affiliate_value_3 > affiliate_value_2)))
      || (affiliate_value_3 > affiliate_value_2)
      ) {
        $(this).val('');
        affiliate_value_3 = null;
        // check next
        check_show_next();
      } else {
        $(this).val(affiliate_value_3);
        // check next
        check_show_next();
      }
    }
  });

  <?php if($is_review == 1 && @$_REQUEST['price'] && (@$_REQUEST['price_percent'] ||@ $_REQUEST['price_discount']) && @$_REQUEST['discount_type'] && @$_REQUEST['affiliate_type'] &&@ $_REQUEST['affiliate_value_1'] && @$_REQUEST['affiliate_value_2'] && @$_REQUEST['affiliate_value_3']) { ?>
    setTimeout(function(){
      price = <?=$_REQUEST['price']?>;

      var className1 = "<?=$_REQUEST['is_review'] == 1 && $_REQUEST['discount_type'] == 1 ? '.js-class-1' : '.js-class-2'?>";
      $(className1).trigger('click');
      discount_value = <?=$_REQUEST['price_percent'] != '' ? $_REQUEST['price_percent'] : ($_REQUEST['price_discount'] != '' ? $_REQUEST['price_discount'] : '')?>;
      discount_type = <?=$_REQUEST['discount_type']?>;

      var className2 = "<?=$_REQUEST['is_review'] == 1 && $_REQUEST['affiliate_type'] == 1 ? '.js-class-3' : '.js-class-4'?>";
      $(className2).trigger('click');
      affiliate_type = <?=$_REQUEST['affiliate_type']?>;
      affiliate_value_1 = <?=$_REQUEST['affiliate_value_1']?>;
      affiliate_value_2 = <?=$_REQUEST['affiliate_value_2']?>;
      affiliate_value_3 = <?=$_REQUEST['affiliate_value_3']?>;

      check_show_next();
    }, 500);

    $('.js-next-step-7 > a').click(function () {
      var flag = check_show_next();
      if(flag === true) {
        <?php
        $_REQUEST['step'] = 7;
        unset($_REQUEST['is_review']);
        unset($_REQUEST['price']);
        unset($_REQUEST['discount_type']);
        unset($_REQUEST['price_percent']);
        unset($_REQUEST['price_discount']);
        unset($_REQUEST['affiliate_type']);
        unset($_REQUEST['affiliate_value_1']);
        unset($_REQUEST['affiliate_value_2']);
        unset($_REQUEST['affiliate_value_3']);
        $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
        ?>
        if(discount_type == 1) {
          url = '<?=$url?>'
          + '&price=' + price
          + '&discount_type=' + discount_type
          + '&price_percent=' + discount_value
          + '&affiliate_type=' + affiliate_type
          + '&affiliate_value_1=' + affiliate_value_1
          + '&affiliate_value_2=' + affiliate_value_2
          + '&affiliate_value_3=' + affiliate_value_3;
        } else {
          url = '<?=$url?>'
          + '&price=' + price
          + '&discount_type=' + discount_type
          + '&price_discount=' + discount_value
          + '&affiliate_type=' + affiliate_type
          + '&affiliate_value_1=' + affiliate_value_1
          + '&affiliate_value_2=' + affiliate_value_2
          + '&affiliate_value_3=' + affiliate_value_3;
        }

        window.location.href = url;
        return false;
      }
    })
  <?php } else { ?>
    $('.js-next-step-7 > a').click(function () {
      var flag = check_show_next();
      if(flag === true) {
        <?php
        $_REQUEST['step'] = 7;
        $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
        ?>
        if(discount_type == 1) {
          url = '<?=$url?>'
          + '&price=' + price
          + '&discount_type=' + discount_type
          + '&price_percent=' + discount_value
          + '&affiliate_type=' + affiliate_type
          + '&affiliate_value_1=' + affiliate_value_1
          + '&affiliate_value_2=' + affiliate_value_2
          + '&affiliate_value_3=' + affiliate_value_3;
        } else {
          url = '<?=$url?>'
          + '&price=' + price
          + '&discount_type=' + discount_type
          + '&price_discount=' + discount_value
          + '&affiliate_type=' + affiliate_type
          + '&affiliate_value_1=' + affiliate_value_1
          + '&affiliate_value_2=' + affiliate_value_2
          + '&affiliate_value_3=' + affiliate_value_3;
        }
        window.location.href = url;
        return false;
      }
    })
  <?php } ?>

  function check_show_next() {
    discount_type === 1 ? price_compare = price - (price * discount_value)/100 : (discount_type === 2 ? price_compare = price - discount_value : 0);

    if( price > 0
    && ( (discount_type === 1 && discount_value >= 0 && discount_value <= 100)
          ||
          (discount_type === 2 && discount_value >= 0 && discount_value <= price)
        )
    && ( (affiliate_type === 1 && affiliate_value_1 <= 100 && affiliate_value_2 <= 100 && affiliate_value_3 <= 100)
          ||
          (affiliate_type === 2 && affiliate_value_1 <= price_compare && affiliate_value_2 <= affiliate_value_1 && affiliate_value_3 <= affiliate_value_2)
        )
    && (affiliate_value_1 >= 0 && affiliate_value_2 >= 0 && affiliate_value_3 >= 0 && affiliate_value_1 != null && affiliate_value_2 != null && affiliate_value_3 != null && discount_value !== null)
    ) {
      $('.js-next-step-7').show();
      return true;
    } else {
      $('.js-next-step-7').hide();
      return false;
    }
  }

</script>