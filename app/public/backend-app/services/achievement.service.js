angular.module('limoApp')
.factory('achievementService', function ($http) {
  return {
    /**
     * update status driver
     *
     * @param  {interger}   id
     * @return {Promise}
     */
    demoStart: function (data) {
      return $http.get(window.BACKEND_URL + '/achievements/demo/start');
    }
  };
});