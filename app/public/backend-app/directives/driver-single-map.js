/*global google*/
'use strict';

angular.module('limoApp')
.directive('driverSingleMap', function(socket) {
    return {
        restrict: 'A',
        scope: {
            data: '='
        },
        link: function(scope, elem) {
            var uluru = {
                lat: parseFloat(scope.data.lat) || 0,
                lng: parseFloat(scope.data.lng) || 0
            };
            var map = new google.maps.Map(elem[0], {
              zoom: 17,
              center: uluru
            });

            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });

            //only listen driver location event if id is passed
            if (scope.data.id) {
                socket.ready(function() {
                    //subscribe driver room
                    socket.socketIo.emit('joinDriverRoom', {
                        driverId: scope.data.id
                    });
                });

                socket.socketIo.on('driverLocationChange', function(data) {
                    if (data.driverId === scope.data.id) {
                        var myLatLng = new google.maps.LatLng(data.lat, data.lng);
                        marker.setPosition(myLatLng);
                        map.panTo(myLatLng);
                        map.setCenter(myLatLng);
                    }
                });
            }
        }
    };
});
