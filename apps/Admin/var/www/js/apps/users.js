
app.controller('usersCtrl', function($scope, $rootScope, Restangular) {

  Restangular.all('users/index').getList().then(function (data) {
    $scope.users = data.users;
  });
});