<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url("/page-business/{$user_id}");
if(@$_REQUEST['back'] == 1) {
  $back_link = azibai_url("/page-business/list-voucher/{$user_id}");
}

if($is_review === 1) {
  // $request_tmp = $_REQUEST;
  // $request_tmp['step'] = 7;
  // unset($request_tmp['is_review']);
  // $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}
?>


<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Tạo mã giảm giá</a>
</div>
<div class="coupon-stepdot">
  <ul>
    <li class="active">
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
  </ul>
</div>

<div class="coupon-content">
  <div class="coupon-content-creat">
    <div class="accordion js-accordion">
      <div class="accordion-item creat-item js-box-item" data-type="1">
        <div class="accordion-toggle creat-item-title js-box-item-click js-class-1">
          Áp dụng cho tất cả sản phẩm
        </div>
        <div class="accordion-panel creat-item-content">
          <div class="apply-for-all">
            <input type="text" class="form-control js-price_rank" placeholder="Số tiền" value="<?=$_REQUEST['is_review'] == 1 && $_REQUEST['product_type'] == 1 ? $_REQUEST['price_rank'] : ''?>">
            <p class="small-text">Mã giảm giá chỉ áp dụng cho đơn hàng có tổng giá trị từ
              <span class="text-red">"Số tiền nhập từ phía trên"</span> VND</p>
          </div>
        </div>
      </div>
      <div class="accordion-item creat-item js-box-item" data-type="2">
        <div class="accordion-toggle creat-item-title js-box-item-click js-class-2">
          Áp dụng cho từng sản phẩm
        </div>
        <div class="accordion-panel creat-item-content">
          <div class="apply-for-product">
            <!-- <p>10 sản phẩm đã được chọn</p> -->
            <div class="search">
              <input type="text" class="form-control js-search-keyword" placeholder="Tìm kiếm theo tên">
              <img src="/templates/home/styles/images/svg/search.svg" alt="">
            </div>
            <div class="show-result">
              <div class="tt">
                Sản phẩm (<?=$list_product_voucher['total'] ? $list_product_voucher['total'] : 0?>)
                <label class="checkbox-style ml30">
                  <input type="checkbox" name="select-all" value="all" class="js-checkall">
                  <span>Chọn tất cả</span>
                </label>
              </div>
              <div class="show-result-list data-append">
                <?php foreach ($list_product_voucher['items'] as $key => $item) {
                  $this->load->view('home/page_business/backend-doanhnghiep/html/item-page-1', ['item'=>$item], FALSE);
                } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center js-next-step-2" style="display:none">
      <a href="javascript:void(0)" class="btn-continue">Tiếp tục</a>
    </div>
  </div>
</div>

<script>
  $('.js-search-keyword').on('keypress', function (e) {
    if(e.which == 13) { // enter
      __is_busy = false;
      __stopped = false;
      __page = 1;
      __keyword = $(this).val();

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: window.location.href,
        data: { page: __page, checking_all: checking_all, product_type: type, list_product: list_product, search: __keyword},
        success: function (result) {
          $('.data-append').html(result);

          items = $('.data-append').find('.js-checkitem');
          if(has_one_checkall == 1) {
            //list_cancel
            $(items).prop('checked', true);
            $.each($(items), function (i, e) {
              id = $(e).val();
              index = list_cancel.indexOf(id);
              if (index > -1) {
                $(e).prop('checked', false);
              }
            })
          }
          if(has_one_checkall == 0) {
            //list_accept
            $.each($(items), function (i, e) {
              id = $(e).val();
              index = list_accept.indexOf(id);
              if (index > -1) {
                $(e).prop('checked', true);
              }
            })
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  })
</script>

<script>
  // scroll append data pop library
  var __is_busy = false;
  var __stopped = false;
  var __page = 1;
  var __keyword = '';
  $('.data-append').scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.item').height() >= $(this).height() - 50) {
      if (__is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__stopped == true) {
        event.stopPropagation();
        return false;
      }
      __is_busy = true;
      __page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: window.location.href,
        data: { page: __page, checking_all: checking_all, product_type: type, list_product: list_product, search: __keyword},
        success: function (result) {
          if (result == '') {
            __stopped = true;
          }
          if (result) {
            $('.data-append').append(result);
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  });


  var type = price_rank = 0;
  var list_product = '';
  var has_one_checkall = checking_all = 0;
  var list_accept = [];
  var list_cancel = [];
  var total_item = <?=$list_product_voucher['total'] ? $list_product_voucher['total'] : 0?>;
  var count_item = 0;
  var flag = false;

  localStorage.setItem("avatar_0", "<?=MY_Loader::$static_data['hook_user']['my_shop']['logo']?>");
  localStorage.setItem("voucher_avatar", "<?=MY_Loader::$static_data['hook_user']['my_shop']['logo']?>");

  $('.js-box-item > .js-box-item-click').on('click', function () {
    type = 0;
    list_product = '';
    flag = false;

    $element = $(this).closest('.js-box-item');
    type = parseInt($($element).attr('data-type'));
    // if(type === 1) {
    //   $('.js-checkall').attr('checked', false);
    //   $.each($('.js-checkitem'), function (i, e) {
    //     $(e).attr('checked', false);
    //   })
    // }
    // if(type === 2) {
    //   $('.js-price_rank').val('');
    // }
    if(!$($element).hasClass('is-open')) {
      flag = true;
      $('.js-next-step-2').show();
    } else {
      flag = false;
      $('.js-next-step-2').hide();
    }
  })

  $('.js-price_rank').on('change', function () {
    price_rank = parseInt($(this).val());

    if(price_rank < 0 || isNaN(price_rank)) {
      $(this).val(0);
      price_rank = 0;
    } else {
      $(this).val(price_rank);
    }
  });

  $('body').on('click', '.js-checkall',function () {
    if($(this).is(':checked')) {
      $.each($('.js-checkitem'), function (i, e) {
        $(e).prop('checked', true);
      })
      type = 1;
      checking_all = 1;
      count_item = total_item;
      has_one_checkall = 1;
      list_cancel = [];
      list_accept = [];
    } else {
      $.each($('.js-checkitem'), function (i, e) {
        $(e).prop('checked', false);
      })
      type = 2;
      checking_all = 0;
      count_item = 0;
      has_one_checkall = 0;
      list_cancel = [];
      list_accept = [];
    }
  });

  $('body').on('click', '.js-checkitem', function () {
    // TH1: check all -> bỏ check 1 sản phẩm
    if(checking_all == 1 && count_item == total_item && $(this).is(':checked') == false) {
      $('.js-checkall').prop('checked', false);
      list_cancel = [];
      list_accept = [];
      count_item = total_item - 1;
      checking_all = 0;
      has_one_checkall = 1;
      list_cancel.push($(this).val());
    } else

    // TH2: uncheck all -> check 1 sản phẩm còn lại chưa check
    if(checking_all == 0 && count_item == (total_item - 1) && $(this).is(':checked') == true) {
      $('.js-checkall').prop('checked', true);
      count_item = total_item;
      checking_all = 1;
      list_cancel = [];
      list_accept = [];
    } else
    // Th4: check và uncheck bình thường
    // 4.1 has_one_checkall = 1 // check all lần 1 => add item id vào list_cancel
    if(has_one_checkall == 1) {
      if($(this).is(':checked') == true) { // chua check
        count_item = count_item + 1;
        var index = list_cancel.indexOf($(this).val());
        if (index > -1) {
          list_cancel.splice(index, 1);
        }
      } else if($(this).is(':checked') == false) { // da check
        count_item = count_item - 1;
        var index = list_cancel.indexOf($(this).val());
        if (index == -1) {
          list_cancel.push($(this).val());
        }
      }
    } else
    // 4.2 has_one_checkall = 0 // chưa check all => add item id vào list_accept
    if(has_one_checkall == 0) {
      if($(this).is(':checked') == true) { // chua check
        count_item = count_item + 1;
        var index = list_accept.indexOf($(this).val());
        if (index == -1) {
          list_accept.push($(this).val());
        }

      } else if($(this).is(':checked') == false) { // da check
        count_item = count_item - 1;
        var index = list_accept.indexOf($(this).val());
        if (index > -1) {
          list_accept.splice(index, 1);
        }
      }
    }
  })


  <?php if($is_review == 1) { ?>
    $(document).ready(function(){
      setTimeout(function(){
        var className = "<?=($_REQUEST['is_review'] == 1 && $_REQUEST['product_type'] == 1 && $_REQUEST['price_rank'] > 0) ? '.js-class-1'
        : ($_REQUEST['is_review'] && $_REQUEST['count_item'] > 0 ? '.js-class-2' : '')?>";

        $(className).trigger('click');
        flag = true;
        price_rank = <?=$_REQUEST['price_rank'] ? $_REQUEST['price_rank'] : 0?>;
        type = <?=$_REQUEST['product_type']?>;
        list_product = "<?=$_REQUEST['list_product'] ? $_REQUEST['list_product'] : ''?>";
        count_item = <?=$_REQUEST['count_item'] ? $_REQUEST['count_item'] : 0?>;

        if(className === '.js-class-2' && count_item == total_item) {
          checking_all = 1;
          $('.js-checkall').trigger('click');
        } else if(className === '.js-class-2' && count_item > 0 && type == 2){
          // chọn sản phẩm xài voucher
          has_one_checkall = 0;
          list_product = JSON.parse("[" + list_product + "]");
          if(list_product == []) {
            list_accept = []
          } else {
            list_accept = list_product;
            list_product.forEach(function(id){
              $('.js-checkitem[value="'+id+'"]').prop('checked', true);
            });
          }
        } else if(className === '.js-class-2' && count_item > 0 && type == 1){
          // chọn sản phẩm ko xài voucher
          has_one_checkall = 1;
          $('.js-checkitem').prop('checked', true);
          list_product = JSON.parse("[" + list_product + "]");
          if(list_product == []) {
            list_cancel = [];
          } else {
            list_cancel = list_product;
            list_product.forEach(function(id){
              $('.js-checkitem[value="'+id+'"]').prop('checked', false);
            });
          }
        }
      }, 500);

      $('.js-next-step-2 > a').click(function () {
        <?php
          $_REQUEST['step'] = 2;
          unset($_REQUEST['price_rank']);
          unset($_REQUEST['product_type']);
          unset($_REQUEST['list_product']);
          unset($_REQUEST['count_item']);
          $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
        ?>
        var url  = '<?=$url?>';

        if(type === 1 && flag === true && price_rank > 0) {
          var _i = 0;
          localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
          url = url + '&product_type=' + type + '&price_rank=' + price_rank;
          window.location.href = url;
          return false;
        } else

        if(type === 1 && flag === true && checking_all == 1) {
          var _i = 0;
          localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
          list_product = '';
          url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
          window.location.href = url;
        } else

        if(type === 2 || type === 1 && flag === true) {
          if(has_one_checkall == 1 && list_cancel.toString() != '') {   // day list cancel
            // if()
            var _i = $($('.js-checkitem:checked')[0]).val();
            localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
            list_product = list_cancel.toString();
            url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
            window.location.href = url;
          }
          if(has_one_checkall == 0 && list_accept.toString() != '') {   // day list accept
            var _i = Math.min.apply(null, list_accept);
            localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
            list_product = list_accept.toString();
            url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
            window.location.href = url;
          }
        }
      });
    })

  <?php } else { ?>
    $('.js-next-step-2 > a').click(function () {
      <?php
      $_REQUEST['step'] = 2;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>';
      if(type === 1 && flag === true && price_rank > 0) {
        var _i = 0;
        localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
        url = url + '&product_type=' + type + '&price_rank=' + price_rank;
        window.location.href = url;
        return false;
      } else

      if(type === 1 && flag === true && checking_all == 1) {
        var _i = 0;
        localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
        list_product = '';
        url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
        window.location.href = url;
      } else

      if(type === 2 || type === 1 && flag === true) {
        if(has_one_checkall == 1 && list_cancel.toString() != '') { // day list cancel
          var _i = $($('.js-checkitem:checked')[0]).val();
          localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
          list_product = list_cancel.toString();
          url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
          window.location.href = url;
        }
        if(has_one_checkall == 0 && list_accept.toString() != '') { // day list accept
          var _i = Math.min.apply(null, list_accept);
          localStorage.setItem("voucher_avatar", localStorage.getItem("avatar_"+_i));
          list_product = list_accept.toString();
          url = url + '&product_type=' + type + '&list_product=' + list_product + '&count_item=' + count_item;
          window.location.href = url;
        }
      }
    });
  <?php } ?>

</script>