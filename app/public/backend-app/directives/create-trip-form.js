/*global google*/
'use strict';

angular.module('limoApp')
.directive('createTripForm', function ($http, $window) {
    return {
        restrict: 'A',
        scope: {
            data: '='
        },
        link: function (scope, elem) {
            var service = $(elem).find('#serviceId');
            var pickup = $(elem).find('#pickup');
            var dropoff = $(elem).find('#dropoff');
            var pickupPlaceId = $(elem).find('#pickupPlaceId');
            var pickupLat = $(elem).find('#pickupLat');
            var pickupLng = $(elem).find('#pickupLng');
            var dropoffPlaceId = $(elem).find('#dropoffPlaceId');
            var dropoffLat = $(elem).find('#dropoffLat');
            var dropoffLng = $(elem).find('#dropoffLng');
            var distance = $(elem).find('#distance');
            var distanceText = $(elem).find('#distance-text');
            var distanceTextInput = $(elem).find('#distanceText');
            var duration = $(elem).find('#duration');
            var durationText = $(elem).find('#durationText');
            var etaTimeText = $(elem).find('#estimate-time-text');
            var etaPrice = $(elem).find('#estimate-price');
            var etaFeePerKm = $(elem).find('#estimateFeePerKm');
            var mapDiv = $(elem).find('#map');
            var defaultLatlng = new google.maps.LatLng(10.7751366, 106.6800455); //TODO - get default by location in the backend
            //more in docs https://developers.google.com/maps/documentation/javascript/reference#DirectionsRendererOptions
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            var geocoder = new google.maps.Geocoder();

            var map = new google.maps.Map(mapDiv[0], {
                zoom: 15,
                center: defaultLatlng
            });

            var dropoffMarker = new google.maps.Marker({
                map: map,
                position: defaultLatlng,
                draggable: true,
                icon: 'http://maps.google.com/mapfiles/ms/icons/red.png'
            });

            var pickupMarker = new google.maps.Marker({
                map: map,
                position: defaultLatlng,
                draggable: true,
                icon: 'http://maps.google.com/mapfiles/ms/icons/green.png'
                        //TODO - change icon for marker
            }); 

            directionsDisplay.setMap(map);

            function toHHMMSS(sec) {
                var sec_num = parseInt(sec, 10); // don't forget the second param
                var hours   = Math.floor(sec_num / 3600);
                var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                var seconds = sec_num - (hours * 3600) - (minutes * 60);

                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                return hours+':'+minutes+':'+seconds;
            }

            function estimateTrip(data) {
                scope.estimating = true;
                $http.post($window.BACKEND_URL + '/trips/estimate', data).then(function(resp) {
                    var data = resp.data;
                    console.log(data);
                    etaPrice.val(data.estimatePrice);
                    etaFeePerKm.val(data.feePerKm);
                    scope.estimating = false;
                }, function(err) {
                    alert(err.data.msg);
                    scope.estimating = false;
                });
            }

            function calculateAndDisplayRoute(start, dest) {
                directionsService.route({
                    origin: start,
                    destination: dest,
                    travelMode: 'DRIVING'
                }, function (response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                        var d = 0;
                        var eta = 0;
                        for (var i = 0; i < response.routes[0].legs.length; i++) {
                            d += response.routes[0].legs[i].distance.value;
                            eta += response.routes[0].legs[i].duration.value;
                        }
                        distance.val(d);
                        distanceText.html(d/1000);
                        distanceTextInput.val(distanceText + ' km');
                        etaTimeText.html(toHHMMSS(eta));
                        duration.val(eta);
                        durationText.val(toHHMMSS(eta));
                        estimateTrip({
                            pickupPlaceId: pickupPlaceId.val(),
                            pickupLat: start.lat(),
                            pickupLng: start.lng(),
                            dropoffLat: dest.lat(),
                            dropoffLng: dest.lng(),
                            serviceId: service.val()
                        });
                    } else {
                        window.alert('Không thể tìm được đường đi!');
                    }
                });
            }

            function geocodePosition(pos, cb) {
                geocoder.geocode({
                    latLng: pos
                }, function (responses) {
                    console.log(responses[0]);
                    if (responses && responses.length > 0) {
                        cb(null, responses[0].formatted_address, responses[0].place_id);
                    } else {
                        window.alert('Không tìm được địa chỉ');
                        cb('Không tìm được địa chỉ');
                    }
                });
            }

            var pickupAutocomplete = new google.maps.places.Autocomplete(pickup[0], {
                componentRestrictions: {country: 'vn'}
            });
            pickupAutocomplete.addListener('place_changed', function () {
                var place = pickupAutocomplete.getPlace();
                pickupLat.val(place.geometry.location.lat());
                pickupLng.val(place.geometry.location.lng());
                pickupPlaceId.val(place.place_id);
                //change marker
                map.panTo(place.geometry.location);
                map.setCenter(place.geometry.location);
                pickupMarker.setPosition(place.geometry.location);

                calculateAndDisplayRoute(pickupMarker.position, dropoffMarker.position);
            });

            var dropoffAutocomplete = new google.maps.places.Autocomplete(dropoff[0], {
                componentRestrictions: {country: 'vn'}
            });
            dropoffAutocomplete.addListener('place_changed', function () {
                var place = dropoffAutocomplete.getPlace();
                dropoffLat.val(place.geometry.location.lat());
                dropoffLng.val(place.geometry.location.lng());
                dropoffPlaceId.val(place.place_id);

                map.panTo(place.geometry.location);
                map.setCenter(place.geometry.location);
                dropoffMarker.setPosition(place.geometry.location);
                calculateAndDisplayRoute(pickupMarker.position, dropoffMarker.position);
            });

            pickupMarker.addListener('dragend', function () {
                //update address
                geocodePosition(pickupMarker.position, function(err, address, place_id) {
                    if (!err) {
                        pickup.val(address);
                        pickupPlaceId.val(place_id);
                        calculateAndDisplayRoute(pickupMarker.position, dropoffMarker.position);
                    }
                });
            });
            dropoffMarker.addListener('dragend', function () {
                calculateAndDisplayRoute(pickupMarker.position, dropoffMarker.position);
                geocodePosition(dropoffMarker.position, function(err, address, place_id) {
                    if (!err) {
                        dropoff.val(address);
                        dropoffPlaceId.val(place_id);
                    }
                });
            });
        }
    };
});
