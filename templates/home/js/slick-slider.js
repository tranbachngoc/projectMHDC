$(function() {
  $('.addlinkthem-slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
  });
});

$(function() {
  var $status = $('#pagingInfo1');
  var $slickElement = $('#slider-for1');
  $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
  });
  $slickElement.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '#slider-nav1',
    dots: false,
    centerMode: true,
  });
  $('#slider-nav1').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '#slider-for1',
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    arrows: false,
  });
});

$(function() {
  var $status = $('#pagingInfo2');
  var $slickElement = $('#slider-for2');
  $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
  });
  $slickElement.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '#slider-nav2',
    dots: false,
  });
  $('#slider-nav2').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '#slider-for2',
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    arrows: false,
  });
});

$(function() {
  var $status = $('.flash-sale-pagingInfo');
  var $slickFlashsale = $('.flash-sale-slider');
  $slickFlashsale.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.text(i + '/' + slick.slideCount);
  });
  $slickFlashsale.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
  });
});
  

$(function () {
  $('.lazy').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
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
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
  });
})