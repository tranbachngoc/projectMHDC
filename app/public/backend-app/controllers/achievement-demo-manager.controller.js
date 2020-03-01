/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('limoApp').controller('achievementDemoManagerCtrl', ['$scope', 'growl', 'achievementService', '$element', '$uibModal', '$location', function ($scope, growl, achievementService, $element, $uibModal, $location) {

    var vm = this;
    $scope.EVENT_START_EVENT = 'event-start-achievement';
    $scope.EVENT_START_EVENT_MESSAGE = 'Bạn muốn chạy thành tích này?';

    /**
    * =========================== LISTEN EVENT ========================
    */

    $scope.$on($scope.EVENT_START_EVENT, _start);

    
    /**
     * ============================ PRIVATE FUNCTION =====================
     */
    
    function _onChangeTrip(event, modal) {
        location.reload();
    }

    function _start() {
        console.log('started');
        achievementService.demoStart().then(function () {
            growl.info('', {
                title: 'Bắt đầu chạy thành tích.'
            });
            location.reload();
        }).catch(function (error) {
            growl.error('', {
                title: error.data ? error.data.msg : 'Lỗi hệ thống'
            });
        });
    }
}]);