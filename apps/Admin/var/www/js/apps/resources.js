'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/resources/types/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
        })
        .when('/edit/:slug', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserEditCtrl'
        });
}]);

app.controller('ResourcesCtrl', function($scope, Restangular, $rootScope, $location) {
    function load() {
      Restangular.all('resources/index').getList().then(function (resources) {
        $scope.resources = resources;
      });
    }
    load();
    $scope.edit = function (resource) {
      $location.path('/edit/' + resource.id);
    };
}).controller('ResourceTypesCtrl', function($scope, Restangular, $rootScope, $location) {

    Restangular.all('resources/types').getList().then(function (resourceTypes) {
        $scope.resourceTypes = resourceTypes;
    });
   
});