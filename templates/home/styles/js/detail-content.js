$(document).ready(function() {
    $(document).on('click', '.js_audio', function (event) {
        event.preventDefault();
        var el = '.' + $(this).data('target-audio');
        if ($(el)[0].paused == false) {
            $(el).trigger('pause');
        } else {
            $(el).trigger('play');
        }
    });
    $(document).on('play', '.js_audio_icon', function () {
        $(this).prev('img.js_audio').attr('src', '/templates/home/styles/images/default/music_play.gif');
    });
    $(document).on('pause', '.js_audio_icon', function () {
        $(this).prev('img.js_audio').attr('src', '/templates/home/styles/images/default/music_pause.png');
    });
    $('.js_audio_icon').on('ended', function () {
        $(this).prev('img.js_audio').attr('src', '/templates/home/styles/images/default/music_pause.png');
    });
});