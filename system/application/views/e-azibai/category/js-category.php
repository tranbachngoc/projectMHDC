<script type="text/javascript">

  $('.js-danh-sach-danh-muc').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 9,
    slidesToScroll: 3,
    // arrows: true,
    responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      }
    ]
  });

  $(document).ready(function () {
    function setBoundries(slick, state) {
      if (state === 'default') {
        slick.find('ul.slick-dots li').eq(2).addClass('n-small-1');
      }
    }

    // Slick Selector.
    var slickSlider = $('.js-banner-shop');
    var maxDots = 3;
    var transformXIntervalNext = -18;
    var transformXIntervalPrev = 18;

    slickSlider.on('init', function (event, slick) {

      console.log(number);
      $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
      $(this).find('ul.slick-dots li').each(function (index) {
        $(this).addClass('dot-index-' + index);
      });
      $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
      setBoundries($(this), 'default');
      var number = $(this).find('ul.slick-dots li').length;
      if (number <= 2) {
        $(this).find('.slick-dots-container').addClass("lessthanfour");
      }
    });

    var transformCount = 0;
    slickSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      var totalCount = $(this).find('.slick-dots li').length;
      if (totalCount > maxDots) {
        if (nextSlide > currentSlide) {
          if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('n-small-1')) {
            if (!$(this).find('ul.slick-dots li:last-child').hasClass('n-small-1')) {
              transformCount = transformCount + transformXIntervalNext;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('n-small-1');
              var nextSlidePlusOne = nextSlide + 1;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('n-small-1');
              $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
              var pPointer = nextSlide - 1;
              var pPointerMinusOne = pPointer - 1;
              $(this).find('ul.slick-dots li').eq(pPointerMinusOne).removeClass('p-small-1');
              $(this).find('ul.slick-dots li').eq(pPointer).addClass('p-small-1');
            }
          }
        }
        else {
          if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('p-small-1')) {
            if (!$(this).find('ul.slick-dots li:first-child').hasClass('p-small-1')) {
              transformCount = transformCount + transformXIntervalPrev;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('p-small-1');
              var nextSlidePlusOne = nextSlide - 1;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('p-small-1');
              $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
              var nPointer = currentSlide + 1;
              var nPointerMinusOne = nPointer - 1;
              $(this).find('ul.slick-dots li').eq(nPointer).removeClass('n-small-1');
              $(this).find('ul.slick-dots li').eq(nPointerMinusOne).addClass('n-small-1');
            }
          }
        }
      }
    });

    $('.js-banner-shop').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      focusOnSelect: true,
      infinite: false
    });
    // $('button').on('click', function()  {
    //     $('.slider-for').slick('slickGoTo', 5);
    //   // gallery.slick('slickGoTo', parseInt(slideIndex));
    // });
  });

  $('#js-xem-dang-luoi').on('click', function () {
    $(this).toggleClass("show-onebyone-item");
    if ($(this).hasClass("show-onebyone-item")) {
      $('body').find('.catalogue-product-items').addClass('just-one-item');
      $(this).attr("src", "/templates/home/styles/images/svg/danhsach_on.svg");
    } else {
      $('body').find('.catalogue-product-items').removeClass('just-one-item');
      $(this).attr("src", "/templates/home/styles/images/svg/xemluoi_on.svg");
    }
  });
</script>

<!-- Filter -->
<script type="text/javascript">
  var quality = percentage = price_from = price_to = 0;
  var sort = 'sort-new';
  var current_page = 1;
  var price_from = price_to = 0;
  var af_id = '<?=$af_id?>';
  console.log(af_id);
  var link_filter_default = siteUrl + '<?=$category['categoryRoot']->cat_id.'/'.RemoveSign($category['categoryRoot']->cat_name)?>';

  $('.js-filter-submit a').on('click', function () {
    var __quality = __percentage = __sort = __price_from = __price_to = '';
    __quality = parseInt($("input[name='filter_quality']:checked").val());
    __percentage = parseInt($("input[name='filter_percentage']:checked").val());
    __price_from = parseInt($("input[name='filter_from']").val());
    __price_to = parseInt($("input[name='filter_to']").val());
    __sort = $('.js-filter-sort select[name="select-sort"] option:selected').val();

    if(__price_from > 0 && __price_to > 0 && __price_to > __price_from){
      if(af_id != ''){
        var link_process = link_filter_default +
                      '/' + current_page +
                      '?af_id=' + af_id +
                      '&quality=' + __quality +
                      '&percentage=' + __percentage +
                      '&sort='+ __sort +
                      '&price_f='+ __price_from +
                      '&price_t='+ __price_to;
      }else{
        var link_process = link_filter_default +
                      '/' + current_page +
                      '?quality=' + __quality +
                      '&percentage=' + __percentage +
                      '&sort='+ __sort +
                      '&price_f='+ __price_from +
                      '&price_t='+ __price_to;
      }
    } else if(__price_from < __price_to) {
      alert('Nhập giá sai, xin hãy kiểm tra lại');
      return false;
    } else {
      if(af_id != ''){
        var link_process = link_filter_default +
                      '/' + current_page +
                      '?af_id=' + af_id +
                      '&quality=' + __quality +
                      '&percentage=' + __percentage +
                      '&sort='+ __sort +
                      '&price_f='+ 0 +
                      '&price_t='+ 0;
      }else{
        var link_process = link_filter_default +
                      '/' + current_page +
                      '?quality=' + __quality +
                      '&percentage=' + __percentage +
                      '&sort='+ __sort +
                      '&price_f='+ 0 +
                      '&price_t='+ 0;
      }
    }
    // console.log('link_process',link_process);
    window.location.replace(link_process);
  });

  $('.js-filter-sort select[name="select-sort"]').on('change', function () {
    __sort = $(this).find('option:selected').val();
    if(af_id != ''){
      var link_process = link_filter_default +
                      '/' + current_page +
                      '?af_id=' + af_id +
                      '&quality=' + '<?=$_REQUEST["quality"] ? $_REQUEST["quality"] : 0?>' +
                      '&percentage=' + '<?=$_REQUEST["percentage"] ? $_REQUEST["percentage"] : 0?>' +
                      '&sort='+ __sort +
                      '&price_f='+ '<?=$_REQUEST["price_f"] ? $_REQUEST["price_f"] : 0?>' +
                      '&price_t='+ '<?=$_REQUEST["price_t"] ? $_REQUEST["price_t"] : 0?>';
    }else{
      var link_process = link_filter_default +
                      '/' + current_page +
                      '?quality=' + '<?=$_REQUEST["quality"] ? $_REQUEST["quality"] : 0?>' +
                      '&percentage=' + '<?=$_REQUEST["percentage"] ? $_REQUEST["percentage"] : 0?>' +
                      '&sort='+ __sort +
                      '&price_f='+ '<?=$_REQUEST["price_f"] ? $_REQUEST["price_f"] : 0?>' +
                      '&price_t='+ '<?=$_REQUEST["price_t"] ? $_REQUEST["price_t"] : 0?>';
    }
    console.log('link_process',link_process);
    window.location.replace(link_process);
  });
</script>