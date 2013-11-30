'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/test', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserEditCtrl'
    });
}]);

app.controller('UsersCtrl', function($scope, Restangular) {

  	Restangular.all('users/index').getList().then(function (data) {
  		$scope.users = data.users;
  	});
});


app.controller('UserEditCtrl', function($scope, $rootScope) {

	$scope.stuff = "Hi Stuff!";
	$rootScope.$emit('modal.open', true);
});


