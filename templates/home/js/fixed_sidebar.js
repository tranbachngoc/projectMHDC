jQuery(function($)
{
  $('.fixtoscroll').scrollToFixed({ 
    marginTop: function () { 
      var marginTop = $(window).height() - $(this).outerHeight(true) - 0; 
      if (marginTop >= 0) 
        return 75; 
      return marginTop; 
    }, 
    limit: function () { 
      var limit = 0; 
      limit = $('#footer').offset().top - $(this).outerHeight(true) - 0; 
      // limit = $('.cover-content').offset().top - $(this).outerHeight(true) - 0; 
      return limit; 
    } 
  });


});