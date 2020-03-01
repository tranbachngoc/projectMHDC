/**
 * Author: Tim Vervoort - info@timvervoort.com
 * Licence: Free for commercial use
 * Last update: 2nd May 2018 - v1.2.3
 */
var fs_gal_preloads = new Array();

(function($) {
    $.fn.swipe = function(options) {

        // Default thresholds & swipe functions
        var defaults = {
            threshold: {
                x: 30,
                y: 30
            },
            swipeLeft: function() { 
              $('.fs-gal-view .fs-gal-next').click(); // Next img
            },
            swipeRight: function() { 
              $('.fs-gal-view .fs-gal-prev').click(); // Previous img
            }
        };

        var options = $.extend(defaults, options);

        if (!this) return false;

        return this.each(function() {

            var me = $(this)

            // Private variables for each element
            var originalCoord = { x: 0, y: 0 }
            var finalCoord = { x: 0, y: 0 }
            var start_M = false;
            

            // Store coordinates as finger is swiping
            function touchMove(event) {
                if (start_M == true) {
                    event.preventDefault();
                    if (event.targetTouches !== undefined) {
                        var touches = event.targetTouches[0];
                    }
                    finalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                    finalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;
                }
            }

            // Done Swiping
            // Swipe should only be on X axis, ignore if swipe on Y axis
            // Calculate if the swipe was left or right
            function touchEnd(event) {

                if (start_M == true) {
                    var changeY = originalCoord.y - finalCoord.y;
                    
                    swipeLength = Math.round(Math.sqrt(
                    Math.pow(finalCoord.x - originalCoord.x, 2)));

                    if (swipeLength > 20) {
                      xDist = originalCoord.x - finalCoord.x;
                      yDist = originalCoord.y - finalCoord.y;
                      r = Math.atan2(yDist, xDist);

                      swipeAngle = Math.round(r * 180 / Math.PI);
                      if (swipeAngle < 0) {
                          swipeAngle = 360 - Math.abs(swipeAngle);
                      }
                      if ((swipeAngle <= 45) && (swipeAngle >= 0)) {
                          defaults.swipeLeft()
                      }
                      if ((swipeAngle <= 360) && (swipeAngle >= 315)) {
                          defaults.swipeLeft()
                      }
                      if ((swipeAngle >= 135) && (swipeAngle <= 225)) {
                          defaults.swipeRight()
                      }
                    }

                    
                    start_M = false;
                }
            }

            // Swipe was started
            function touchStart(event) {
                start_M = true;
                if (event.targetTouches !== undefined) {
                    var touches = event.targetTouches[0];
                }
                originalCoord.x = touches !== undefined ? event.targetTouches[0].pageX : event.clientX;
                originalCoord.y = touches !== undefined ? event.targetTouches[0].pageY : event.clientY;

                finalCoord.x = originalCoord.x
                finalCoord.y = originalCoord.y
            }

            // Add gestures to all swipable areas
            this.addEventListener("touchstart", touchStart, false);
            this.addEventListener("touchmove", touchMove, false);
            this.addEventListener("touchend", touchEnd, false);
            this.addEventListener("touchcancel", touchEnd, false);

            this.addEventListener("mousedown", touchStart, false);
            this.addEventListener("mousemove", touchMove, false);
            this.addEventListener("mouseup", touchEnd, false);
            this.addEventListener("mouseleave", touchEnd, false);

        });
    };
})(jQuery);

$('document').ready(function() {

  $('.fs-gal-view-img').swipe();
  
  // Set gallery to flex
  $('.fs-gal-view').css("display", "flex")
                   .hide();

  // Make gallery objects clickable
  $('body').on('click','.fs-gal', function() {
    fsGal_DisplayImage($(this));
  });
  
  // Display gallery
  function fsGal_DisplayImage(obj) {

    // Clear navigation buttons
    $('.fs-gal-view .fs-gal-prev').fadeOut();
    $('.fs-gal-view .fs-gal-next').fadeOut();

    $('.image-tag-recs-close').hide();
    $('.fs-gal-view-detail').hide();

    // Set current image
    title = obj.attr('title');
    alt = obj.attr('alt');
    imgElem = $('.fs-gal-main');
    imgElem.attr('title', title);
    imgElem.attr('alt', alt);
    imgElem.attr('src', obj.attr('data-url'));
    // Create buttons
    var current = $('.fs-gal[data-parent="'+obj.attr('data-parent')+'"]').index(obj);
    var list_slide = $('.fs-gal[data-parent="'+obj.attr('data-parent')+'"]').length;

    $('.fs-gal-view .fs-gal-prev').attr('data-parent', obj.attr('data-parent'));
    $('.fs-gal-view .fs-gal-next').attr('data-parent', obj.attr('data-parent'));

    var prev = current - 1;
    var next = current + 1;
    if (prev >= 0) {
      $('.fs-gal-view .fs-gal-prev').attr('data-img-index', prev);
      $('.fs-gal-view .fs-gal-prev').fadeIn();
    }
    if (next < list_slide) {
      $('.fs-gal-view .fs-gal-next').attr('data-img-index', next);
      $('.fs-gal-view .fs-gal-next').fadeIn();
    }
    $('.fs-gal-view').show();
    if (current == list_slide - 1 && list_slide != 1)  { 
       $('.fs-gal-view .fs-gal-prev').fadeIn();
    }
    else if (current == 0  && list_slide != 1)  {
        $('.fs-gal-view .fs-gal-next').fadeIn();
    }
    showTagHome(obj.attr('data-tags'));
  }
  // Gallery navigation
  $('.fs-gal-view .fs-gal-nav').click(function(e) {
    e.stopPropagation();
    var index = $(this).attr('data-img-index');
    var parent = $(this).attr('data-parent');
    var img = $($('.fs-gal[data-parent="'+parent+'"]').get(index));
    fsGal_DisplayImage(img);
  });

  // Close gallery
  $('.fs-gal-close').click(function(e){
      $('.fs-gal-view').fadeOut();
  });

  $('.image-tag-recs-close').click(function(e){
      $('.tag-photo-home').removeClass('is-active');
      $('.fs-gal-view-detail').hide();
      $('.image-tag-recs-close').hide();
  }); 
  

  $('.fs-gal-main').click(function(e) {
      e.stopPropagation();
  });

  // Keyboard navigation
  $('body').keydown(function(e) {
    if (e.keyCode == 37) {
      $('.fs-gal-view .fs-gal-prev').click(); // Left arrow
    }
    else if(e.keyCode == 39) { // right
      $('.fs-gal-view .fs-gal-next').click(); // Right arrow
    }
    else if(e.keyCode == 27) { // right
      $('.fs-gal-view .fs-gal-close').click(); // ESC
    }
  });

  $('.fs-gal-view').on('swipeleft', function() {
    $('.fs-gal-view .fs-gal-next').click(); // Next img
  });
  $('.fs-gal-view').on('swiperight', function() {
    $('.fs-gal-view .fs-gal-prev').click(); // Previous img
  });
  $('.fs-gal-view').on('swipedown', function() {
    $('.fs-gal-view .fs-gal-close').click(); // Close gallery
  });
  $('.fs-gal-view').on('swipeup', function() {
    $('.fs-gal-view .fs-gal-close').click(); // Close gallery
  });

});