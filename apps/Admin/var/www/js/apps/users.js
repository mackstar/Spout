'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
    })
}]);

app.controller('UsersCtrl', function($scope, Restangular, $rootScope) {
    function load() {
      Restangular.all('users/index').getList().then(function (data) {
        $scope.users = data.users;
      });
    }
    $rootScope.$on('users.reload', function() {
      load();
    });
    load();
    $scope.delete = function(user) {
      Restangular.all("users/index").remove({id: user.id}).then(function() {
        $rootScope.$emit('sp.message', {title: 'User removed successfully', type: "success"});
        $rootScope.$emit('users.reload', true);
      });
    }
});


app.controller('UserEditCtrl', function($scope, $rootScope) {
    $rootScope.$emit('modal.open', true);
});

app.controller('UserAddCtrl', function($scope, $rootScope, Restangular, parseFormErrors, $location) {
  $rootScope.$emit('modal.open', true);

  $scope.user = {
    email: '',
    password: '',
    name: ''
  }
  $scope.submit = function() {

    if ($scope.userForm.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }
    Restangular.all('users/index').post($scope.user).then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'User saved successfully', type: "success"});
      $rootScope.$emit('users.reload', true);
      $rootScope.$emit('modal.close', true);
      $location.path('/users');
    }, function(response) {
      parseFormErrors(response.data, $scope.userForm);
    });
  }
});


