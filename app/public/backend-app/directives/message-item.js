'use strict';

angular.module('limoApp')
.directive('messageItem', function() {
    return {
        restrict: 'AE',
        templateUrl: window.BACKEND_PUPLIC_URL + 'backend-app/views/message-item.html',
        scope: {
            message: '@',
            ownerName: '@',
            createdAt: '@',
            type: '@',
            avatarUrl: '@'
        },
        link: function(scope, elem) {
            console.log("DEMO");
        }
    }
});