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

app.controller('UserAddCtrl', function($scope, $rootScope, Restangular) {
  $rootScope.$emit('modal.open', true);
  $scope.submit = function() {
    console.log($scope.user.role);
    var user = $scope.user;
    user.name = "Richard";
    user.email = "richard.mackstar@gmail.com";
    user.password = "password";
    Restangular.all('users/index').post(user).then(function() {
      console.log("Object saved OK");
    });
  }
});


