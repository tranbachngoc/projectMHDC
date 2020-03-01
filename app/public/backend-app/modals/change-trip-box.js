 'use strict';

angular.module('limoApp')
.directive('changeTripBox', function ($uibModal) {
    return {
            restrict: 'AE',
            scope: {
                control: '='
            },
            controller: _controller
        };

	    function _controller($scope, $filter, tripService, growl) {
	    	
	    	$scope.control.changeTrip = function (event, trip) {

	    		var modalInstance = $uibModal.open({
	    			templateUrl: window.BACKEND_PUPLIC_URL + '/backend-app/views/change-trip-box.html',
	    			controller: function ($scope, modalTitle, $rootScope) {

	    				$scope.cancel = function () {
	    					modalInstance.dismiss('cancel');
	    				}

	    				$scope.fn = {};

	    				$scope.loading = false;

	    				$scope.fn.cb = function (data) {
	    					$scope.hash = null;
	    					$scope.loading = true;
	    					tripService.estimateChange({
				    			tripId: trip.id,
				    			dropoffPlaceId: data.place_id,
				    			dropoffAddress: data.formatted_address,
				    			dropoffLat: data.geometry.location.lat(),
				    			dropoffLng: data.geometry.location.lng()
				    		}).then(function (response) {
				    			$scope.loading = false;
				    			$scope.hash = response.data.hash;
				    			$scope.estimatePrice = response.data.estimatePrice;	
				    		}).catch(function (err) {
				    			$scope.loading = false;
				    			growl.error('', {
					            	title: err.data.msg
					          	});
				    		});
	    				}

	    				$scope.agree = function () {
	    					$scope.loading = true;
	    					tripService.change(trip.id, $scope.hash).then(function (response) {
	    						$scope.loading = false;
	    						growl.info('', {
					            	title: 'Chuyển hướng thành công.'
					          	});
				    			$rootScope.$broadcast(event);
	    						modalInstance.dismiss('cancel');	
				    		}).catch(function (err) {
				    			$scope.loading = false;
				    			growl.error('', {
					            	title: err.data.msg
					          	});
				    		});
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