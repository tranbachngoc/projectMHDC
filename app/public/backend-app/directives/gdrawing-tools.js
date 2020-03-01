'use strict';

angular.module('limoApp')
.directive('gdrawingTools', function() {
    return {
        restrict: 'AE',
        scope: {
            selectedShape: '=ngModel',
            location: '=location',
        },
        link: function(scope, elem) {
            /**
             * ============== INIT =============== 
             */
            
            scope.selectedShape = null;
            var selectedShape = null;
            var map = null;
            
            _initMap();

            scope.$watch('location', _locationChange);

            /**
             * ============ PRIVATE FUNCTION ==================
             */
            
            function _initMap() {
                map = new google.maps.Map(elem[0], {
                      center: {lat: 10.7751366, lng: 106.6800455},
                      zoom: 14,
                });

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.MARKER,
                    drawingControl: true,
                    drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon', 'rectangle']
                    },
                    markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
                    circleOptions: {
                        fillColor: '#ffff00',
                        fillOpacity: 1,
                        strokeWeight: 5,
                        clickable: false,
                        editable: true,
                        zIndex: 1
                    }
                });

                drawingManager.setMap(map);
                _initEvent(drawingManager);
            }

            function _initEvent(drawingManager, map) {
                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                    if (event.type == 'marker') {
                        return event.overlay.setMap(null);
                    }
                    _setSelection(event.overlay, event.type, map);
                });
            }

            function _locationChange() {
                if (scope.location) {
                    var place = new google.maps.LatLng(scope.location.centerLat, scope.location.centerLng);
                    map.setZoom(12);
                    map.setCenter(place);
                    scope.selectedShape = null;
                    _deleteSelectedShape();
                }
            }

            function _setSelection(shape, type, map) {
                _deleteSelectedShape();
                selectedShape = shape;
                
                var value = "";
                switch (type){
                    case "polygon":
                        value = _parsePoint(shape.getPath().getArray());
                        break;
                    case "rectangle":
                        value = _getPointsForRectangle(shape);
                        break;
                }
                value.push(value[0]); // close polygon
                
                scope.$apply(function () {
                    scope.selectedShape = _formatPolygon(value);
                });
            }

            function _deleteSelectedShape() {
                if (selectedShape) {
                  selectedShape.setMap(null);
                }
            }

            /**
             * ======= Utils==================
             */
            
            function _formatPolygon(array) {
                var value = '(';
                array.map(function (item, k) {
                    value +='(' + item.lng + ',' + item.lat + ')';
                    if (k != array.length -1) {
                        value +=',';
                    }
                });
                value +=')';
                return value;
            }

            function _getPointsForRectangle(shape) {
                var bounds = shape.getBounds();
                var start = bounds.getNorthEast();
                var end = bounds.getSouthWest();
                var list = [];
                list.push(start);
                list.push({
                    lat: bounds.getSouthWest().lat,
                    lng: bounds.getNorthEast().lng,
                });
                list.push(end);
                list.push({
                    lat: bounds.getNorthEast().lat,
                    lng: bounds.getSouthWest().lng,
                });
                

                return _parsePoint(list);
            }

            function _parsePoint(list) {
                return list.map(function (item) {
                    return {
                        lat: item.lat(), 
                        lng: item.lng()
                    };
                });
            }
        }
    };
});
