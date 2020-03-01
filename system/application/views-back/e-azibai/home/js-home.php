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

  var page = 1;
  $('.load-more-item').on('click', function(event){
    $('.load-wrapp').show();
    page++;
    $.ajax({
      type: 'post',
      dataType: 'html',
      url: window.location.href,
      data: {page: page},
      success: function (result) {
				if(result != ''){
          $('.wrap-product-more').append(result);
        }else{
          $(this).removeClass('load-more-item');
        }
        $('.load-wrapp').hide();
      }
    }).always(function() {

    });
    return false;
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
</script>