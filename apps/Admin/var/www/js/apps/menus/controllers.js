'use strict';

app.controller('MenusCtrl', function($scope, menus) {
  $scope.menus = menus;
});

app.controller('MenusAddCtrl', function($scope) {
  $scope.menu = {};
  $scope.form = {};

  $scope.submit = function () {
    console.log("submit");
    $scope.menus.post($scope.model);
  };


});