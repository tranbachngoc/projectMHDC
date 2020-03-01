var playing_img     = '/templates/home/styles/images/svg/play_video.svg',
    pause_img       = '/templates/home/styles/images/svg/pause_video.svg',
    volume_btn_on   = '/templates/home/styles/images/svg/icon-volume-on.svg',
    volume_btn_off  = '/templates/home/styles/images/svg/icon-volume-off.svg',
    timeout_status_btn_play;

function isElementInViewport (el)
{
    if (typeof jQuery === "function" && el instanceof jQuery) {
        el = el[0];
    }
    var rect = el.getBoundingClientRect();
    var offset = 0;
    if(rect.height < 100){
        offset = 100 - rect.height;
    }
    return (rect.top >= 0 && (rect.bottom + offset) <= (window.innerHeight || document.documentElement.clientHeight));
}

function video_handle_event_play(event)
{
    video_handle_controls(event.target, 'hidden');
    $(event.target).removeClass('pause-video').addClass('play-video');
}

function video_handle_event_pause(event)
{
    clearTimeout(timeout_status_btn_play);
    $(event.target).removeClass('play-video').addClass('pause-video');
    video_handle_controls(event.target, 'show');
}

function video_handle_event_volume(event)
{
    event = event || window.event;
    var target = event.target || event.srcElement;
    if(!$(target).prop('muted')){
        $($(target).data('target_btn_volume')).attr("src",volume_btn_on);
    }else{
        $($(target).data('target_btn_volume')).attr("src",volume_btn_off);
    }
}

function video_handle_controls(target, status)
{
    clearTimeout(timeout_status_btn_play);
    if(status === 'show'){
        if($(target).hasClass('play-video')){
            //đang play mà click vào màn hình video thì hiện button pause auto hidden 2,5s nếu ko click vào.
            $(target).get(0).controls = true;
            $($(target).data('target_btn_play')).removeClass('hidden').find('.js_img-play').attr('src', pause_img);
            timeout_status_btn_play = setTimeout(function () {
                $(target).get(0).controls = false;
                $($(target).data('target_btn_play')).addClass('hidden').find('.js_img-play').attr('src', playing_img);
            }, 2500);
        }else{
            $(target).get(0).controls = false;
            $($(target).data('target_btn_play')).removeClass('hidden').find('.js_img-play').attr('src', playing_img);
        }
    }else{
        $(target).get(0).controls = true;
        $($(target).data('target_btn_play')).addClass('hidden').find('.js_img-play').attr('src', playing_img);
    }
}


function video_add_eventlisten(target)
{
    if(!$(target).parent('.wrap-video-item-single').hasClass('js_add-event-video')){
        $(target).get(0).addEventListener("play", video_handle_event_play);
        $(target).get(0).addEventListener("pause", video_handle_event_pause);
        $(target).get(0).addEventListener("volumechange", video_handle_event_volume);
        $(target).parent('.wrap-video-item-single').addClass('js_add-event-video');
    }
}

$(document).ready(function() {
    var flag_pause = false;
    $(window).scroll(function() {
        $('.display-sm video').each(function() {
            if(isElementInViewport($(this))) {
                if(!$(this).hasClass('autoplay')){
                    video_add_eventlisten(this);
                    $(this).trigger("play");
                }else{
                    // trước khi scroll qua first video thì ko pause nó
                    flag_pause = true;
                }
            }else{
                if ($(this).hasClass('play-video')) {
                    if (!$(this).hasClass('autoplay')) {
                        $(this).trigger("pause");
                    } else if (flag_pause) {
                        //sau khi đã scroll qua first video thì pause và trả lại mặc định.
                        $(this).removeClass('autoplay').trigger("pause");
                    }
                }
            }
        });
    });

    // $(document).on('click', '.display-sm video.detail-video', function (event) {
    //     console.log('123');
    //     event.preventDefault();
    //     var target = $(this).data('target_video');//tag video
    //     if($(target).parent('.wrap-video-item-single').hasClass('js_add-event-video') === false){
    //         video_add_eventlisten(target);
    //         $('video.video-play').trigger('pause');
    //         $(target).trigger('play');
    //     }else if($(target).hasClass('play-video')){
    //         video_handle_controls(target, 'show');
    //     }else if($(target).hasClass('pause-video')){
    //         $('video.video-play').trigger('pause');
    //         $(target).trigger('play');
    //     }
    // });

    $(document).on('click', '.display-sm .js_btn-pause', function (event) {
        event.preventDefault();
        var target = $(this).data('target_video');//tag video
        if($(target).parent('.wrap-video-item-single').hasClass('js_add-event-video') === false){
            video_add_eventlisten(target);
            $('video.video-play').trigger('pause');
            $(target).trigger('play');
        }else if($(target).hasClass('play-video')){
            $(target).trigger('pause');
        }else if($(target).hasClass('pause-video')){
            $('video.video-play').trigger('pause');
            $(target).trigger('play');
        }
    });
});