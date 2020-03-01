/*global google*/
'use strict';

angular.module('limoApp')
.directive('userStatusChanged', function(socket) {
    return {
        restrict: 'A',
        scope: {
            data: '=',
            type: '@'
        },
        link: function(scope, elem) {
            scope.type = scope.type || 'customer';
            //only listen driver location event if id is passed
            if (scope.data.id) {
                socket.ready(function() {
                    //subscribe driver room
                    socket.socketIo.emit('joinStatusRoom', {
                        id: scope.data.id,
                        type: scope.type
                    });
                });

                socket.socketIo.on('joinStatusRoomSuccess', function(data) {
                    console.log(data);
                    if (data.id === scope.data.id && data.type == scope.type) {
                        _showOnline(data.isOnline);
                    }
                });

                socket.socketIo.on('userStatusChanged', function(data) {
                    if (data.id === scope.data.id && data.type == scope.type) {
                        _showOnline(data.isOnline);
                    }
                });
            }


            function _showOnline(isOnline) {
                if (isOnline){
                    elem.html('<span class="badge badge-empty badge-success"></span>');
                } else {
                    elem.html('<span class="badge badge-empty badge-danger"></span>');
                }
            }
        }
    };
});
