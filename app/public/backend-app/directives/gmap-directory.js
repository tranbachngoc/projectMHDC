/*global google*/
'use strict';

angular.module('limoApp')
    .directive('gmapDirectory', function ($http, $window,$location, socket) {
      return {
        restrict: 'A',
        scope: {
          data: '='
        },
        link: function (scope, elem) {
          var mapDiv = document.getElementById("map");

          var pickupLatLng = new google.maps.LatLng(scope.data.pickupLat,scope.data.pickupLng);
          var dropoffLatLng = new google.maps.LatLng(scope.data.dropoffLat, scope.data.dropoffLng);
        
          //more in docs https://developers.google.com/maps/documentation/javascript/reference#DirectionsRendererOptions
          var directionsService = new google.maps.DirectionsService;
          var directionsDisplay = new google.maps.DirectionsRenderer({
            suppressMarkers: true
          });
          var map = new google.maps.Map(mapDiv, {
            zoom: 15,
            center: pickupLatLng
          });
         
          var pickupMarker = new google.maps.Marker({
            map: map,
            position: pickupLatLng,
            draggable: false,
            icon: window.BACKEND_PUPLIC_URL+'/images/taxi-red.png'
          });

          var dropoffMarker = new google.maps.Marker({
            map: map,
            position: dropoffLatLng,
            draggable: false,
            icon: window.BACKEND_PUPLIC_URL +'/images/taxi-green.png'
                //TODO - change icon for marker
          });

          scope.data.meta.locations = scope.data.meta.locations || [];

          var waypoints = [];
          scope.data.meta.locations.forEach(function (item) {
            waypoints.push({
              stopover: true,
              location: {
                placeId: item.placeId
              }
            });
          });

          directionsDisplay.setMap(map);
          
          _calculateAndDisplayRoute(pickupMarker.position, dropoffMarker.position, waypoints);

          if (scope.data.status === 'picked') {
            _joinDriverRoom();
          }
          
          /*
           * ================== PRIVATE FUNCTION ====================
           */

          function _joinDriverRoom() {
              var uluru = {
                lat: parseFloat(scope.data.lat) || 0,
                lng: parseFloat(scope.data.lng) || 0
              };

              var marker = new google.maps.Marker({
                position: uluru,
                map: map
              });

              //only listen driver location event if id is passed
              if (scope.data.driverId) {
                socket.ready(function() {
                      //subscribe driver room
                      socket.socketIo.emit('joinDriverRoom', {
                        driverId: scope.data.driverId
                      });
                });

                socket.socketIo.on('driverLocationChange', function(data) {
                  if (data.driverId === scope.data.driverId) {
                    var myLatLng = new google.maps.LatLng(data.lat, data.lng);
                    marker.setPosition(myLatLng);
                    map.panTo(myLatLng);
                    map.setCenter(myLatLng);
                  }
                });

                socket.socketIo.on('joinDriverRoomSuccess', function(data) {
                  if (data.driver.id === scope.data.driverId) {
                    var myLatLng = new google.maps.LatLng(data.lat, data.lng);
                    marker.setPosition(myLatLng);
                    map.panTo(myLatLng);
                    map.setCenter(myLatLng);
                  }
                });
              }
          }

          function _calculateAndDisplayRoute(start, dest, waypoints) {
            directionsService.route({
              origin: start,
              destination: dest,
              waypoints: waypoints,
              optimizeWaypoints: true,
              travelMode: 'DRIVING'
            }, function (response, status) {
              if (status === 'OK') {
                directionsDisplay.setDirections(response);
              } else {
                window.alert('Không thể tìm được đường đi!');
              }
            });
          }
        }
      };
    });
