'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
    });
}]);

app.controller('UsersCtrl', function($scope, Restangular) {
  	Restangular.all('users/index').getList().then(function (data) {
  		$scope.users = data.users;
  	});
});


app.controller('UserEditCtrl', function($scope, $rootScope) {

	$rootScope.$emit('modal.open', true);
});

app.controller('UserAddCtrl', function($scope, $rootScope, Restangular, parseFormErrors) {
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
      console.log("Object saved OK");
    }, function(response) {
      parseFormErrors(response.data, $scope.userForm);
    });
  }
});


