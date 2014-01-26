'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/resources/types/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
        })
        .when('/resources/add/:slug', { 
            templateUrl: '/js/templates/resources/add.html', 
            controller: 'ResourceAddCtrl'
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

    $scope.resourceTypes = window.Spout.resourceTypes;
   
}).controller('ResourceAddCtrl', function($scope, Restangular, $routeParams, $location, $rootScope) {
    $rootScope.$emit('modal.open', true);

    $scope.resource = { fields: {} };

    Restangular.one('resources/types').get({slug:$routeParams.slug}).then(function (resourceType) {
        $scope.resourceType = resourceType;
        $scope.ready = function() {
            return true;
        }
    });

    $scope.submit = function () {
      console.log($scope.resource);
    };

   
});
app.directive('spField', function() {

  return {
    replace: true,
    transclude: false,
    scope: { field: '=', resource: '=' },
    template: '<div class="form-group" ng-class="{\'has-error\': resourceForm[{[field.slug]}].$invalid}">' +
    '<label for="name">{[field.label]}</label>' +
    '<div sp-string-field field="field" resource="resource" ng-if="isType(\'string\')"></div>' +
    '<div sp-text-field field="field" resource="resource" ng-if="isType(\'text\')"></div>' +
    '</div>',
    link: function(scope, element, attrs) {
            scope.isType = function (fieldType) {
            if (fieldType === scope.field.field_type) {
                return true;
            }
            return false;
        }
    }
  }
});

app.directive('spStringField', function() {

  return {
    replace: true,
    transclude: true,
    scope: { field: '=', resource: '=' },
    template: '<input type="text" ng-model="resource.fields[field.slug]" class="form-control" name="{[field.slug]}" required />',
    link: function(scope, element, attrs) {
        console.log(scope.field);
        console.log(scope.resource);
    }
  }
});

app.directive('spTextField', function() {

  return {
    replace: true,
    transclude: true,
    scope: { field: '=', resource: '=' },
    template: '<textarea class="form-control" name="{[field.slug]}" rows="6"></textarea>',
    link: function(scope, element, attrs) {
        console.log(scope.field);
    }
  }
});