/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


angular.module('limoApp').controller('CreateDriverCtrl', function ($scope, employeeService) {
  $scope.checkLicense = function (value) {
    console.log(value);
  }
  var vm = this;
  vm.person = {};
  vm.person.selected = undefined;
  
  vm.people = [

  ];
  vm.searchEmployee = function ($select) {
    if ($select) {

      return employeeService.search({keywords: $select.search}).then(function (response) {
        vm.people = response;
      });
    } else {
      return [];
    }
  }
})