'use strict';

angular.module('limoApp', [
    'btford.socket-io',
    'ui.bootstrap',
    'angular-growl',
    'ui.select', 
    'ngSanitize'
], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
})
.run(function(socket, growl, $window) {
    //init the socket component
    socket.socketIo.on('urgent-alert', function(message) {
        var alertMsg = 'Tài xế ' + message.driver.name + ' tại vị trí (' + [message.data.lat, message.data.lng].join(',') +')';
        alertMsg += '<br/>Điện thoại: ' + message.driver.phone;
        alertMsg += '<br/><a href="' + $window.BACKEND_URL + '/alerts/' + message.data.id + '">Xem vị trí tại đây</a>';
        growl.error(alertMsg, {
            title: 'Tin nhắn khẩn từ driver'
        });
    });
}).config(['growlProvider', function(growlProvider) {
    growlProvider.globalTimeToLive(5000);
}]);