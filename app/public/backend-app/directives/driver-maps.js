/*global google*/
'use strict';

angular.module('limoApp')
.directive('driverMaps', function(socket) {
    return {
        restrict: 'A',
        scope: {
            data: '=',
            services: '='
        },
        link: function(scope, elem) {
            var uluru = {
                lat: 10.7751366,
                lng: 106.6800455
            };

            var joined = [];
            var emited = [];
            var markers = {};
            var map = null;
            var markerCluster = null;

            _init();
            _initEvent();
            scope.$watch('data', _dataObserver);

            /**
             * =========== Init Maps 
             */
            function _init() {
                map = new google.maps.Map(elem[0], {
                  zoom: 8,
                  center: uluru
                });

                // create marker clusterer to manage the markers.
                markerCluster = new MarkerClusterer(map, [], {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
            }

            function _initEvent() {
                socket.socketIo.on('driverLocationChange', function(data) {
                    if (joined.indexOf(data.driverId) != -1) {
                        var myLatLng = new google.maps.LatLng(data.lat, data.lng);
                        if (markers[data.driverId]) {
                            markers[data.driverId].setPosition(myLatLng);
                        };
                    }
                });
            }

            function _dataObserver() {
                socket.ready(function() {
                    //subscribe driver rooms
                    joined = [];
                    scope.data.forEach(function (item) {
                        joined.push(item._source.id);
                        if (emited.indexOf(item._source.id) != -1) {
                            return;    
                        }
                        
                        _createMarker(item._source);
                        emited.push(item._source.id);
                        socket.socketIo.emit('joinDriverRoom', {
                            driverId: item._source.id
                        });
                    });
                });
            }

            function _createMarker(driver) {
                if (markers[driver.id]) {
                    return;
                }
                var myLatLng = new google.maps.LatLng(driver.geoLocation.lat, driver.geoLocation.lon);
                markers[driver.id] = new google.maps.Marker({
                    map: map,
                    position: myLatLng,
                    draggable: false,
                    icon: {
                        url: _findIconFromService(driver.serviceId),
                        scaledSize: new google.maps.Size(50, 50)
                    },
                    title: driver.name
                });

                markerCluster.addMarker(markers[driver.id]);
            }

            function _findIconFromService(serviceId) {
                for (var i = 0; i < scope.services.length; i++) {
                    var item = scope.services[i];
                    if (item.id == serviceId) {
                        return window.BACKEND_PUPLIC_URL+item.markerIcon; 
                    }
                }
                return window.BACKEND_PUPLIC_URL+'/images/taxi-red.png';
            }
        }
    };
});
