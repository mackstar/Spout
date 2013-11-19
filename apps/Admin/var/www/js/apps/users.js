var app = angular.module('app', ['restangular', 'ui.router', 'ui.bootstrap']);

app.controller('usersCtrl', function($scope, $rootScope, Restangular) {

  Restangular.all('users').getList().then(function (data) {
    $scope.users = data.users;
  });
});