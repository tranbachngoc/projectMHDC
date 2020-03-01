$(function() {

  $('.bandangnghigi').click(function(){
  	$(this).toggleClass('opened');
  	if ($(this).hasClass('opened')) {
  		$('.model-content').addClass('is-open');
      	$('.wrapper').addClass('drawer-open');
  	} else {
  		$('.model-content').removeClass('is-open');
      	$('.wrapper').removeClass('drawer-open');
  	}
  	return false;
  });

  $('.btn-popup-tag').click(function(){
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
      $('#popup-tag').addClass('is-open');
        $('.wrapper').addClass('drawer-open');
    } else {
      $('#popup-tag').removeClass('is-open');
        $('.wrapper').removeClass('drawer-open');
    }
    return false;
  });

  $('.btn-show-comment-customer').click(function(){
    $(this).toggleClass('opened');
    var modal = $(this).attr("data-id")
    console.log(modal);
    if ($(this).hasClass('opened')) {
      $('#'+modal).addClass('is-open');
        $('.wrapper').addClass('drawer-open');
    } else {
      $('#'+modal).removeClass('is-open');
        $('.wrapper').removeClass('drawer-open');
    }
    return false;
  });

  $('.drawer-overlay, .js-back').on('click', function() {
    $('.btn-popup-tag').removeClass('opened');
    $('.bandangnghigi').removeClass('opened');
    $('.btn-show-comment-customer').removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    return false;
  });


  $('.popup-tag .title-tabs li').click(function () {
    var num =  $('.popup-tag .title-tabs li').index(this);
    $(".popup-tag .content-sanpham-items").hide();
    $(".popup-tag .content-sanpham-items").eq(num).show();
    $(".popup-tag .title-tabs li").removeClass('is-active');
    $(this).addClass('is-active');
  });

  $(".danhmucsanpham .tit").click(function() {
    $(".danhmucsanpham .tit").removeClass('opened');
    $(".danhmucsanpham-parent").hide();
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
      $(this).next('.danhmucsanpham-parent').slideDown();    
    } else {
      $(this).next('.danhmucsanpham-parent').slideUp();    
    }
    
    return false;
  });

  $(".danhmucsanpham-child-title").click(function() {
    $(this).toggleClass('opened').next('.danhmucsanpham-child-content').slideToggle(); 
    
    return false;
  });
});
