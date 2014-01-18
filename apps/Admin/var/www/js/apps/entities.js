'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
        })
        .when('/edit/:slug', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserEditCtrl'
        });
}]);

app.controller('EntitiesCtrl', function($scope, Restangular, $rootScope, $location) {
    function load() {
      Restangular.all('entities/index').getList().then(function (entities) {
        $scope.entities = entities;
      });
    }
    load();
    $scope.edit = function (user) {
      $location.path('/edit/' + user.email);
    };
});