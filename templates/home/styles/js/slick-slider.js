function slider(id){
  var $status = $('.list-slider').find('#pagingInfo_'+id);
  var $slickElement = $('.list-slider').find('#slider-for_'+id);
  // console.log($slickElement);
  $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
  });

  ///////////////////
  function setBoundries(slick, state) {
    if (state === 'default') {
      slick.find('ul.slick-dots li').eq(2).addClass('n-small-1');
    }
  }

  // Slick Selector.
  var slickSlider = $('.list-slider').find('#slider-for_'+id);
  var maxDots = 3;
  var transformXIntervalNext = -18;
  var transformXIntervalPrev = 18;

  slickSlider.on('init', function (event, slick) {
    if(slick.slideCount === 1){
      $('#pagingInfo_' + $(this).data('id')).addClass('hide_0');
    }
    $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
    $(this).find('ul.slick-dots li').each(function (index) {
      $(this).addClass('dot-index-' + index);
    });
    $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
    setBoundries($(this),'default');
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

  $(slickSlider).slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: true,
    focusOnSelect: true,
    arrows: true,
    infinite: false,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        }
      }
    ]
  });

  // $('button').on('click', function()  {
  //     $('.slider-for').slick('slickGoTo', 5);
  //   // gallery.slick('slickGoTo', parseInt(slideIndex));
  // });
  /////////////////////
  
};

function slider_fs(id){
  var $status = $('.flash-sale').find('#flash-sale-pagingInfo_'+id);
  var $slickFlashsale = $('.flash-sale').find('#flash-sale-slider_'+id);
  $slickFlashsale.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
  });
  $slickFlashsale.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 100,
    arrows: false,
    lazyLoad: 'ondemand',
  });
};

function load_slider_sharelink(id){
    $('body').find('#addlinkthem-slider_'+id).slick({
      lazyLoad: 'ondemand',
      slidesToShow: 3,
    slidesToScroll: 2,
    arrows: true,
    dots: false,
    infinite: false,
    speed: 300,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2.5,
          slidesToScroll: 2,
          arrows: false,
        }
      }
    ]
  });
}
function load_slider_sharelink_v2(id){
  $('body').find('#addlinkthem-slider_'+id).slick({
    lazyLoad: 'ondemand',
    arrows: true,
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1.1,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
        }
      }
    ]
  });
}

function load_goiy(id){
  $('body').find('#lazy_'+id).slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    infinite: false,
    responsive: [
    {
      breakpoint: 1025,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2.5,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
  });
}

function slider_sharelink(id) {
  // Dong mo lien ket
  var a = $('body').find('#open-close-link_'+id);
  var parent = a.parent('.list-slider');
  if (!a.hasClass('opened')) {
    a.toggleClass('opened');
    if(a.find('.text').length > 0) {
      a.find('.text').text("Đóng liên kết")
    } else {
      a.text("Đóng liên kết")
    }
    parent.find('.addlinkthem').addClass('is-active').removeClass('no-active');
  } else {
    if(a.find('.text').length > 0) {
      a.find('.text').text("Mở liên kêt")
    } else {
      a.text("Mở liên kêt")
    }
    parent.find('.opened').removeClass('opened');
    parent.find('.addlinkthem').removeClass('is-active').addClass('no-active');
  }
}