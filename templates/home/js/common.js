var app = app || {};

var spBreak = 767;

app.init = function() {
  app.menu();
  app.click_like();
  app.switch_signup();
  app.top_more_detail_post();
  app.share_click();
  app.dongmolienket();
};

app.isMobile = function() {

  return window.matchMedia('(max-width: ' + spBreak + 'px)').matches;

};

app.isOldIE = function() {

  return $('html.ie9').length || $('html.ie10').length;

};

app.menu = function() {
  $('.drawer-hamburger').on('click', function() {
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $('.sm-gnav').addClass('is-open');
    } else {
      $('.sm-gnav').removeClass('is-open');
    }
  });
};

app.click_like = function() {
  $('.like').on('click', function() {
    $(this).toggleClass('liked');
  });
};

app.switch_signup = function () {
  $('.tabs-list li').click(function () {
    var num =  $('.tabs-list li').index(this);
    $(".show-form").hide();
    $(".show-form").eq(num).show();
    $(".tabs-list li").removeClass('is-active');
    $(this).addClass('is-active');
  });
}

app.top_more_detail_post = function () {
  $('.post-head-more .icon-more').click(function () {
    $(this).toggleClass('opening');
    if ($(this).hasClass('opening')) {
      $(this).next().slideDown();
    } else {
      $(this).next().slideUp();
    }
  });
}

// app.share_click = function () {
//   $('.share-click').click(function () {
//     $(this).toggleClass('opening');
//     if ($(this).hasClass('opening')) {
//       $(this).next().slideDown();
//     } else {
//       $(this).next().slideUp();
//     }
//   });
// }

app.dongmolienket = function () {
  // Dong mo lien ket
  $('.open-close-link').click(function () {
    var parent = $(this).closest('.list-slider');
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
      parent.find('.addlinkthem').addClass('is-active');
      $(this).text('Đóng liên kết');
    } else {
      $(this).text('Mở liên kết');
      parent.find('.addlinkthem').removeClass('is-active');
    }
  });
}
$(function() {

  app.init();

});
