/*global google*/
'use strict';

angular.module('limoApp')
.directive('gplaceAutocomplete', function() {
    return {
        restrict: 'A',
        scope: {
            options: '=options',
            place: '=ngData'
        },
        link: function(scope, elem) {
            var autocomplete = new google.maps.places.Autocomplete(elem[0]);
            autocomplete.addListener('place_changed', function() {
                console.log(autocomplete.getPlace());
                var place = autocomplete.getPlace();
                if (scope.options && scope.options.cb) {
                    scope.options.cb(place);
                }

                scope.$apply(function () {
                    scope.place = {
                        address: place.formatted_address,
                        placeId: place.place_id,
                        placeName: place.name,
                        placeLat: place.geometry.location.lat(),
                        placeLng: place.geometry.location.lng(),
                        placeType: place.types.length ? place.types[0] : null
                    }
                });
            });
        }
    };
});
