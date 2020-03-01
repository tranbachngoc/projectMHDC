videojs.hook('beforesetup', function(videoEl, options) {
    options.controlBar = {
        pictureInPictureToggle: false,
        volumeMenuButton: {
            inline: true,
            vertical: false
        }
    };
    return options;
});

var clearTime = false;

videojs.hook('setup', function(player) {

    player.controlBar.on(['click','tap','touchend', 'hover'], function (e) {
        if(clearTime){
            player.player_.clearTimeout(clearTime);
        }
        player.bigPlayButton.hide();
        if(player.bigPlayButton.hasClass('vjs-fade-out')){
            player.bigPlayButton.removeClass('vjs-fade-out');
        }
    });

    player.on(['click','tap'], function (e) {
        if (player.isFullscreen() && window.isVisible(player.player_.bigPlayButton.el())) {
            player.player_.bigPlayButton.hide();
        }
    });

    player.bigPlayButton.on(['click','tap'], function (event) {
        console.log('bigPlayButton');
        if (!player.isFullscreen()) {
            if (this.player_.paused() === true) {
                this.player_.bigPlayButton.hide();
            } else {
                this.player_.bigPlayButton.show();
            }
        }
    });

    player.textTrackDisplay.on(['click'], function (event) {
        console.log('textTrackDisplay');
        if(clearTime){
            this.player_.clearTimeout(clearTime);
        }
        if (!player.isFullscreen() && window.isVisible(this.player_.controlBar.el())) {
            this.player_.bigPlayButton.show();
            this.player_.addClass('popup-detail-image');
            if (this.player_.paused() === false) {
                this.player_.pause();
            }
            this.player_.setTimeout(function () {
                this.player_.removeClass('popup-detail-image');
            }.bind(this), 1000);
        }
    });

    player.posterImage.on(['click','tap'], function (event) {
        player.addClass('popup-detail-image');
        player.setTimeout(function () {
            player.removeClass('popup-detail-image');
        }, 1000);
        if (this.player_.paused() === false) {
            player.pause();
        }
    });

    player.on('play', function (e) {
        this.player_.clearTimeout(clearTime);
        clearTime = this.player_.setTimeout(function () {
            this.player_.textTrackDisplay.removeClass('vjs-hidden');
            this.player_.bigPlayButton.hide();
        }.bind(this));

    });

    player.on('pause', function (e) {
        this.player_.bigPlayButton.show();
    });

    player.on('ended', function() {
        this.player_.controlBar.addClass('vjs-fade-out');
        this.player_.bigPlayButton.show();
    });

});
