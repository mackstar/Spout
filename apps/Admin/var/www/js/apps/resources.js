'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/resources/types/add', { 
            templateUrl: '/js/templates/users/edit.html', 
            controller: 'UserAddCtrl'
        })
        .when('/resources/edit/:type/:slug/:id', { 
            templateUrl: '/js/templates/resources/add.html', 
            controller: 'ResourceEditCtrl'
        });
}]);

app.controller('ResourcesCtrl', function($scope, Restangular, $rootScope, $location) {
    var current;
    function load(page) {
      console.log("load", page);
      current = parseInt(page);
      Restangular.all('resources/index').getList({'_start': page}).then(function (resources) {
        $scope.resources = resources;
      });
    }
    load(1);

    $scope.edit = function (resource) {
      $location.path('/resources/edit/' + resource.type + '/' + resource.slug + '/' + resource.id);
    };
    $scope.$watch('resources._pager.current', function(page){
        console.log("watch", page);
        if (current !== parseInt(page) && page !== undefined) {
            load(page);
        }
    });

    $scope.delete = function(resource) {
      if (!confirm("Are you sure?")) {
        return;
      }
      resource.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'Resource removed successfully', type: "success"});
        console.log($scope.resources._pager.current);
        load($scope.resources._pager.current);
      });
    }

}).controller('ResourceTypesCtrl', function($scope, Restangular, $rootScope, $location) {

    $scope.resourceTypes = window.Spout.resourceTypes;
   
}).controller('ResourceAddCtrl', function($scope, Restangular, $routeParams, $location, $rootScope) {
    $rootScope.$emit('modal.open', true);

    $scope.resource = { fields: {} };

    $scope.close = function() {
        $rootScope.$emit('modal.close', true);
        $location.path('/resources');
    }

    Restangular.one('resources/types').get({slug:$routeParams.slug}).then(function (resourceType) {
        $scope.resourceType = resourceType;
        $scope.ready = function() {
            return true;
        }
    });

    $scope.submit = function () {
        $scope.resource.type = $scope.resourceType;
        Restangular.all('resources/index').post($scope.resource).then(function () {
            $rootScope.$emit('sp.message', {title: 'User added successfully', type: "success"});
            $rootScope.$emit('modal.close', true);
            $rootScope.$emit('resources.reload', true);
        });
    };
   
}).controller('ResourceEditCtrl', function($scope, Restangular, $routeParams, $location, $rootScope) {
    $rootScope.$emit('modal.open', true);

    Restangular.one('resources/types').get({slug:$routeParams.type}).then(function (resourceType) {
        $scope.resourceType = resourceType;
        $scope.ready = function() {
            return true;
        }
    });

    $scope.resource = { fields: {} };

    $scope.close = function() {
        $rootScope.$emit('modal.close', true);
        $location.path('/resources');
    }


    Restangular.one('resources/detail').get({id:$routeParams.id}).then(function (resource) {
        //$scope.resourceType = resourceType;
        console.log(resource);

        $scope.resource = resource;
    });

    $scope.submit = function () {
        $scope.resource.type = $scope.resourceType;
        Restangular.all('resources/index').post($scope.resource).then(function () {
            $rootScope.$emit('sp.message', {title: 'User added successfully', type: "success"});
            $rootScope.$emit('modal.close', true);
            $rootScope.$emit('resources.reload', true);
        });
    };
   
});;
app.directive('spField', function($compile) {

  var fieldTemplate = 
    '<div sp-string-field ng-if="isType(\'string\')"></div>' +
    '<div sp-text-field ng-if="isType(\'text\')"></div>';

  return {
    replace: true,
    transclude: false,
    template: function() {
        return '<div class="form-group" ng-class="{\'has-error\': resourceForm[{[field.slug]}].$invalid}">' +
        '<label for="name">{[field.label]}</label>' +
    fieldTemplate +
    '<label ng-show="field.multiple" class="multiple-buttons"><span class="glyphicon glyphicon-minus-sign" ng-show="showMinusButton()" ng-click="removeField()"></span> <span class="glyphicon glyphicon-plus-sign" ng-click="addField()"></span></label>' +
    '</div>'; },
    link: function(scope, element, attrs) {
        scope.isType = function (fieldType) {
            if (fieldType === scope.field.field_type) {
                return true;
            }
            return false;
        }
        if (scope.field.multiple === "0") {
            return;
        };

        scope.keys = [0];
        scope.resource.fields[scope.field.slug] = [];

        scope.showMinusButton = function () {
            return (scope.keys.length > 1);
        }

        scope.removeField = function () {
            scope.keys.splice(scope.keys.length - 1, 1);
        }

        scope.addField = function () {
            scope.keys.push(scope.keys.length);
        }


    }
  }
});

app.directive('spStringField', function() {

  return {
    replace: true,
    transclude: true,
    template: '<div ng-switch="field.multiple">' + 
    '<div ng-switch-when="1"><div ng-repeat="key in keys" class="multiple">' + 
        '<input type="text" ng-model="resource.fields[field.slug][key]" class="form-control" />' +
    '</div></div>' +
    '<input type="text" ng-model="resource.fields[field.slug]" class="form-control" ng-switch-default required />' +
    '</div>',
    link: function(scope, element, attrs) {
    }
  }
});

app.directive('spTextField', function() {

  return {
    replace: true,
    transclude: true,
    template: '<textarea class="form-control" ng-model="resource.fields[field.slug]" rows="6" ></textarea>',
    link: function(scope, element, attrs) {
    }
  }
});