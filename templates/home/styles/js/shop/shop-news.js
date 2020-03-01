/* sài chung với home azibai, home shop, home personal*/
var volume_btn_on = "/templates/home/styles/images/svg/icon-volume-on.svg";
var volume_btn_off = "/templates/home/styles/images/svg/icon-volume-off.svg";

function video_handle_event_play(event)
{
    var target = event.target || event.srcElement;

    $(target).removeClass("video-pause").addClass("video-play");
    if($($(target).data('target_btn_play')).length){
        $($(target).data('target_btn_play')).addClass('hide_0');
    }
}

function video_handle_event_pause(event)
{
    var target = event.target || event.srcElement;
    $(target).removeClass("video-play").addClass("video-pause");
    if($($(target).data('target_btn_play')).length){
        $($(target).data('target_btn_play')).removeClass('hide_0');
    }
}

function video_handle_event_volume(event)
{
    var target = event.target || event.srcElement;
    
    if(!$(target).prop('muted')){
        $('video.video-play' + ':not(#'+ target.id  +')').prop('muted', true);
        $($(target).data('target_btn_volume')).attr("src",volume_btn_on);
    }else{
        $($(target).data('target_btn_volume')).attr("src",volume_btn_off);
    }
}

function isElementInViewport (el)
{
    //special bonus for those using jQuery
    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }
    var rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        //rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) /*or $(window).height() */
        //rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
    );
}

$(document).ready(function() {
    $(document).on('click', '.js_az-volume', function (event) {
        console.log('templates/home/styles/js/shop/shop-news.js:53');
        event.preventDefault();
        var target_video = $(this).data('target_video');
        if($(target_video).prop('muted')){
            $(target_video).prop('muted', false);
        }else{
            $(target_video).prop('muted', true);
        }
    });

    $(document).on('click', 'img.js_btn-pause', function(event) {
        event.preventDefault();
        console.log('templates/home/styles/js/shop/shop-news.js:59');
        console.log('js_btn-pause', $(this).data('target_video'));
        $('video.video-play').trigger('pause');
        $('.vjs-playing video').trigger('pause');
        $($(this).data('target_video')).trigger('play');
    });
});