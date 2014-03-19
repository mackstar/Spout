'use strict';

app.controller('LoginCtrl', function ($scope, Restangular) {
  $scope.login = {};
  $scope.submitForm = function () {
    Restangular.all('users/authenticate').post($scope.login).then(function (response) {
      if (response.user) {
        // do a yes action here
      }
    });
  };
});