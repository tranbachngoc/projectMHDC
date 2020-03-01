/* global io */
'use strict';

angular.module('limoApp')
.factory('socket', function ($window, socketFactory) {
    // socket.io now auto-configures its connection when we ommit a connection url
    var ioSocket = io($window.SOCKET_URL, {
        // Send auth token on connection, you will need to DI the Auth service above
        query: 'token=' + $window.TOKEN,
        path: '/socket.io'
    });

    var isReady = false;
    var socket = socketFactory({ioSocket: ioSocket});
    socket.on('connect', function () {
        socket.emit('context', {});
    });

    socket.on('reconnect', function() {
        socket.emit('context', {});
    });

    //socket.on('disconnect', cleaner);
    socket.on('_success', function (data) {
        if (data.event === 'context') {
            isReady = true;
        }
    });

    return {
        socketIo: socket,
        ready: function (cb) {
            if (isReady) {
                return cb();
            }

            function timeoutCheck(cb) {
                if (isReady) {
                    cb();
                } else {
                    setTimeout(function() {
                        timeoutCheck(cb);
                    }, 100);
                }
            }

            timeoutCheck(cb);
            //TODO - add cancel?
        }
    };
});
