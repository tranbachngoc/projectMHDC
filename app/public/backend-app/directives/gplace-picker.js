/*global google*/
'use strict';

angular.module('limoApp')
.directive('gplacePicker', function() {
    return {
        restrict: 'AE',
        scope: {
            place: '=ngModel',
            location: '=location',
            onChangePlace: '=ngChange',
        },
        link: function(scope, elem) {
            /**
             * ============== INIT =============== 
             */
            var marker = null;
            var map = null;
            _initMap();

            scope.$watch('location', _locationChange);

            /**
             * ============ PRIVATE FUNCTION ==================
             */
            
            function _initMap() {
                map = new google.maps.Map(elem[0], {
                      center: {lat: 10.7751366, lng: 106.6800455},
                      zoom: 14
                });

                _initEvent(map);
            }

            function _initEvent(map) {
                google.maps.event.addListener(map, 'click', function(event) {
                    if (event.placeId) {
                        var location = {
                            latLng: event.latLng,
                            placeId: event.placeId,
                            placeLat: event.latLng.lat(),
                            placeLng: event.latLng.lng()
                        };
                        _getPlace(event.placeId, map, function (place) {
                            if (place) {
                                location.address = place.formatted_address;
                                location.placeName = place.name;
                                location.placeType = place.types.length ? place.types[0] : null;
                                return _addMarker(location, map);        
                            }
                            _addMarker(location, map);
                        });
                    }
                });
            }

            function _locationChange() {
                if (scope.location) {
                    var place = new google.maps.LatLng(scope.location.centerLat, scope.location.centerLng);
                    map.setZoom(12);
                    map.setCenter(place);
                    scope.place = null;
                    if (marker) {
                        marker.setMap(null);
                    }
                }
            }

            // Adds a marker to the map.
            function _addMarker(location, map) {
                if (marker) {
                    marker.setMap(null);
                }

                scope.$apply(function () {
                    scope.place = location;
                    if (scope.onChangePlace) {
                        scope.onChangePlace(location);
                    }
                });

                marker = new google.maps.Marker({
                  position: location.latLng,
                  label: location.placeType ? location.placeType[0].toUpperCase() : "P",
                  map: map
                });                
            }

            /**
             * ========== PLACE SERVICES ==============
             */
            
            function _getPlace(placeId, map, cb) {
                var service = new google.maps.places.PlacesService(map);
                service.getDetails({
                  placeId: placeId
                }, function(place, status) {
                    cb(place);
                });
            }
        }
    };
});
