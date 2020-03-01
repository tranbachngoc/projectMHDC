 'use strict';

angular.module('limoApp')
.directive('confirmbox', function ($uibModal) {
    return {
            restrict: 'AE',
            scope: {
                control: '='
            },
            controller: _controller
        };

	    function _controller($scope, $filter) {
	    	
	    	$scope.control.confirmbox = function (msg, event, data) {
	    		var modalInstance = $uibModal.open({
	    			templateUrl: window.BACKEND_PUPLIC_URL + '/backend-app/views/confirm-box.html',
	    			controller: function ($scope, modalTitle, $rootScope) {

	    				$scope.msg = msg;

	    				$scope.cancel = function () {
	    					modalInstance.dismiss('cancel');
	    				}
	    				$scope.agree = function () {
	    					$rootScope.$broadcast(event, {model: data});
	    					modalInstance.dismiss('cancel');
	    				}
	    			},
	    			animation: true,
	    			backdrop: true,
	    			size: 'md',
	    			resolve: {
	    				modalTitle: function () {
	    					return angular.copy('Xác Nhận');
	    				}
	    			}
	    		});
	    	}
	    }   	
});