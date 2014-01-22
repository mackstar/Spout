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
      Restangular.all('resources/index').getList().then(function (reources) {
        $scope.resources = resources;
      });
    }
    load();
    $scope.edit = function (resource) {
      $location.path('/edit/' + resource.id);
    };
});