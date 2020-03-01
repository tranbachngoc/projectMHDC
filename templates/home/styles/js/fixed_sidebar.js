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
            return $('#footer').offset().top;
        }
    });
});