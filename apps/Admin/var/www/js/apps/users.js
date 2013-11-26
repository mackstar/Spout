'use strict';

app.controller('UsersCtrl', function($scope, Restangular) {

  	Restangular.all('users/index').getList().then(function (data) {
  		$scope.users = data.users;
  		$scope.data = "Added";
  	});
});

