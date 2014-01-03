'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
    });
}]);

app.controller('UsersCtrl', function($scope, Restangular, $rootScope) {
    function loadUsers() {
        Restangular.all('users/index').getList().then(function (data) {
        $scope.users = data.users;
      });
    }
    $rootScope.$on('reload.users', function() {
        loadUsers();
    });
    loadUsers();
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
    }
    Restangular.all('users/index').post($scope.user).then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'User saved successfully', type: "success"});
      $location.path('/users');
    }, function(response) {
      parseFormErrors(response.data, $scope.userForm);
    });
  }
});


