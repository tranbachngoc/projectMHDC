<div class="loc-san-pham">
  <ul class="loc-san-pham-left">
    <li>
      <select class="style-select-box filter-item" name="select-price" id="">
        <option value="price-0">Tất cả giá</option>
        <option value="price-1">Dưới 1.000.000VND</option>
        <option value="price-13">1.000.000VND -> 3.000.000VND</option>
        <option value="price-35">3.000.000VND -> 5.000.000VND</option>
        <option value="price-510">5.000.000VND -> 10.000.000VND</option>
        <option value="price-10">Trên 10.000.000VND</option>
      </select>
    </li>
    <li>
      <select class="style-select-box filter-item" name="select-decreased" id="">
        <option value="decreased-0">Tất cả sản phẩm</option>
        <option value="decreased-5">Giảm 5% và nhiều hơn</option>
        <option value="decreased-15">Giảm 15% và nhiều hơn</option>
        <option value="decreased-25">Giảm 25% và nhiều hơn</option>
        <option value="decreased-35">Giảm 35% và nhiều hơn</option>
      </select>
    </li>
  </ul>
  <ul class="loc-san-pham-right">
    <li>Hiển thị tất cả sản phẩm
      <strong id="sp-total">
        <?=$total?>
      </strong>
    </li>
    <li>
      <select class="style-select-box sort-item" name="select-sort" id="">
        <option value="sort-new">Mới nhất</option>
        <option value="sort-old">Cũ nhất</option>
        <option value="sort-asc">Giá sản phẩm tăng dần</option>
        <option value="sort-desc">Giá sản phẩm giảm dần</option>
        <option value="sort-az">Tên sản phẩm A --> Z</option>
        <option value="sort-za">Tên sản phẩm Z --> A</option>
      </select>
    </li>
  </ul>
</div>
<div class="chosen-list">
  <p data-action="price-0" data-detect="price">
    <span>Tất cả giá
      <img class="ico-close" src="/templates/home/styles/images/svg/close_black.svg" alt="">
    </span>
  </p>
  <p data-action="decreased-0" data-detect="decreased">
    <span>Tất cả sản phẩm
      <img class="ico-close" src="/templates/home/styles/images/svg/close_black.svg" alt="">
    </span>
  </p>
  <p data-action="sort-new" data-detect="sort">
    <span>Mới nhất
      <img class="ico-close" src="/templates/home/styles/images/svg/close_black.svg" alt="">
    </span>
  </p>
</div>

<script>
  var currentArr = null; // chứa data sản phẩm lần đầu tiên load view + chứa data dùng để sort current items

  var is_filter = false; // dùng ở load more
  var price_from = 0; // dùng ở load more
  var price_to = 0; // dùng ở load more
  var decreased = 0; // dùng ở load more
  var sort = 'sort-new'; // dùng ở load more

  var _filter = {
    filter : false,
		price_from : 0,
		price_to : 0,
    decreased : 0,
    page : 0, //filter thì load lại sp từ đầu
    sort : 'sort-new'
  };
  // console.log('_filter',_filter);

	$('select.filter-item').change(function(){
    if(_filter.filter == false){
      var filter = $(this).children("option:selected").val();
      var filter_name = $(this).children("option:selected").text();
      __action_filter(filter,filter_name);
    }
  });
  function __action_filter(filter,filter_name){
    var data_detect = '';
    var data_filter = filter;
    if(filter.indexOf('decreased') != -1){
      filter = +filter.match(/\d+/).map(n => parseInt(n));
      _filter.decreased = decreased = filter;
      _filter.filter = is_filter = true;
      data_detect = 'decreased';
      page = 1; // xài ở show more
    }else if(filter.indexOf('price') != -1){
      filter = +filter.match(/\d+/).map(n => parseInt(n));
      _filter.filter = is_filter = true;
      data_detect = 'price';
      page = 1; // xài ở show more
      switch (filter) {
        case 1:
          _filter.price_from = price_from = 0;
          _filter.price_to = price_to = 999999;
          break;
        case 13:
          _filter.price_from = price_from = 1000000;
          _filter.price_to = 3000000;
          break;
        case 35:
          _filter.price_from = price_from = 3000000;
          _filter.price_to = 5000000;
          break;
        case 510:
          _filter.price_from = price_from = 5000000;
          _filter.price_to = price_to = 10000000;
          break;
        case 10:
          _filter.price_from = price_from = 10000000;
          _filter.price_to = price_to = 0;
          break;

        default:
          _filter.price_from = price_from = 0;
          _filter.price_to = price_to = 0;
          break;
      }
    }
    // console.log('_filter',_filter);
    // console.log('filter',filter);

    if(_filter.filter == true){
      console.log('_filter',_filter);
      $('.load-wrapp').show();
      $.ajax({
      type: 'post',
      dataType: 'html',
      url: window.location.href,
      data: _filter,
      success: function (result) {
        result = JSON.parse(result);
        if(result.html){
          $('.shop-product-items').html(result.html).fadeIn('slow');
          currentArr = $(".shop-product-items .item").get(); // lấy sản phẩm sau khi filter lưu vào currentArr dùng để sort
          $('#sp-total').html(result.total);
        } else {
          $('.shop-product-items').html("<div>Không có kết quả lọc phù hợp</div>");
          currentArr = []; // clear data trong currentArr
          $('#sp-total').html(0);
        }

        // thêm tag chosen
        var html = '';
        html += '<p data-action="'+data_filter+'" data-detect="'+data_detect+'">';
          html += '<span>';
            html += filter_name;
            html += '<img class="ico-close" src="/templates/home/styles/images/svg/close_black.svg" alt="">';
          html += '</span>';
        html += '</p>';
        $('.chosen-list p[data-detect="'+data_detect+'"]').remove();
        $('.chosen-list').append(html);
        $('.load-wrapp').hide();
      }
      }).always(function() {
          _filter.filter = false;
      });
      return false;
    }
  }

  // data get default is sort by DESC by create time
  $('select.sort-item').change(function(){
    var key = $(this).children("option:selected").val()
    var filter_name = $(this).children("option:selected").text();
    _filter.sort = sort = key; // dùng để load more data theo sort
    __action_sort(key,filter_name);
  });
  function __action_sort(key,filter_name){
    switch (key) {
      case 'sort-new':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          return ( parseInt($(a).attr('data-index')) - parseInt($(b).attr('data-index')) );
        });
        $('.shop-product-items').html(arr);
        break;

      case 'sort-old':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          return ( parseInt($(b).attr('data-index')) - parseInt($(a).attr('data-index')) );
        });
        $('.shop-product-items').html(arr);
        break;

      case 'sort-asc':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          return ( parseInt($(a).attr('data-price')) - parseInt($(b).attr('data-price')) );
        });
        $('.shop-product-items').html(arr);
        break;

      case 'sort-desc':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          return ( parseInt($(b).attr('data-price')) - parseInt($(a).attr('data-price')) );
        });
        $('.shop-product-items').html(arr);
        break;

      case 'sort-az':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          if( $(a).attr('data-char').toLowerCase() < $(b).attr('data-char').toLowerCase() ) { return -1; }
          if( $(a).attr('data-char').toLowerCase() > $(b).attr('data-char').toLowerCase() ) { return 1; }
          return 0;
        });
        $('.shop-product-items').html(arr);
        break;

      case 'sort-za':
        if(currentArr === null){
          currentArr = $(".shop-product-items .item").get();
        }
        var arr = currentArr;
        var arr = arr.sort(function(a, b){
          if( $(a).attr('data-char').toLowerCase() > $(b).attr('data-char').toLowerCase() ) { return -1; }
          if( $(a).attr('data-char').toLowerCase() < $(b).attr('data-char').toLowerCase() ) { return 1; }
          return 0;
        });
        $('.shop-product-items').html(arr);
        break;
    }

    // thêm tag chosen
    var html = '';
        html += '<p data-action="'+key+'" data-detect="sort">';
          html += '<span>';
            html += filter_name;
            html += '<img class="ico-close" src="/templates/home/styles/images/svg/close_black.svg" alt="">';
          html += '</span>';
        html += '</p>';
    $('.chosen-list p[data-detect="sort"]').remove();
    $('.chosen-list').append(html);
  }

  $('body').on('click', '.chosen-list p', function(){
    var chosen = $(this).attr('data-action');
    if(chosen.indexOf('price') != -1 && chosen != 'price-0'){
      $('.chosen-list p[data-detect="price"]').remove();
      chosen = 'price-0';
      chosen_name = 'Tất cả giá';
      __action_filter(chosen,chosen_name);
      $('select.filter-item[name="select-price"] option:first').attr('selected','selected');
    }
    if(chosen.indexOf('decreased') != -1 && chosen != 'decreased-0'){
      $('.chosen-list p[data-detect="decreased"]').remove();
      chosen = 'decreased-0';
      chosen_name = 'Tất cả sản phẩm';
      __action_filter(chosen,chosen_name);
      $('select.filter-item[name="select-decreased"] option:first').attr('selected','selected');
    }
    if(chosen.indexOf('sort') != -1 && chosen != 'sort-new'){
      $('.chosen-list p[data-detect="sort"]').remove();
      chosen = 'sort-new';
      chosen_name = 'Mới nhất';
      __action_sort(chosen,chosen_name);
      $('select.sort-item option:first').attr('selected','selected');
    }
  });
</script>