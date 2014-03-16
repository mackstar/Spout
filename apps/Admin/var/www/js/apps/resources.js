'use strict';

app.config(['$stateProvider', function($stateProvider) {
    $stateProvider.state('resources', {
        url: "/resources/:start",
        templateUrl: '/js/templates/resources/index.html',
        controller: 'ResourcesCtrl',
        resolve: {
          resources: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
            return Restangular.all('resources/index').getList({_start:$stateParams.start});
          }],
          types: ['Restangular', function (Restangular) {
            return Restangular.all('resources/types').getList();
          }]
        }
    })
    .state('resources.type', {
      url: "/type/:type",
      template: "<div ui-view></div>",
      controller: 'ResourceTypeCtrl',
      resolve: {
        type: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
          return Restangular.one("resources/types").get({slug: $stateParams.type})
        }]
      }
    })
    .state('resources.type.add', {
        url: "/add",
        controller: 'ModalCtrl',
        resolve: {
            options: function () {
                return {
                    templateUrl: "/js/templates/resources/add.html",
                    controller: 'ResourceAddCtrl',
                    onComplete: 'resources'
              }
            }
        }
    })
    .state('resources.type.resource', {
        url: "/resource/:slug/:id",
        template: "<div ui-view></div>",
        controller: 'ResourceCtrl',
        resolve: {
            resource: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
                return Restangular.one("resources/types").get({slug: $stateParams.id})
            }]
        }
    })
    .state('resources.type.resource.edit', {
        url: "/edit",
        controller: 'ModalCtrl',
        resolve: {
            options: function () {
                return {
                    templateUrl: "/js/templates/resources/add.html",
                    controller: 'ResourceEditCtrl',
                    onComplete: 'resources'
                }
            }
        }
    })

    //Restangular.one('resources/detail').get({id:$routeParams.id}).then(function (resource)
    ;
}]);

app.controller('ResourcesCtrl', function($scope, resources, types, $state) {
    var current;
    $scope.types = types;
    $scope.resources = resources;

    $scope.$watch('resources._pager.current', function(page){
        if (current !== parseInt(page) && page !== undefined) {
            $state.go('resources', {start: page})
        }
    });

    $scope.delete = function(resource) {
      if (!confirm("Are you sure?")) {
        return;
      }
      resource.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'Resource removed successfully', type: "success"});
        load($scope.resources._pager.current);
      });
    }

}).controller('ResourceCtrl', function($scope, resource) {
    $scope.resource = resource;
}).controller('ResourceTypeCtrl', function($scope, type) {
    $scope.type = type;
}).controller('ResourceAddCtrl', function($scope, Restangular, $modalInstance, $rootScope) {

    $scope.close = $modalInstance.close;

    $scope.resource = { fields: {}};

    $scope.submit = function () {
        $scope.resource.type = $scope.type;
        Restangular.all('resources/index').post($scope.resource).then(function () {
            $scope.close();
            $rootScope.$emit('sp.message', {title: 'Resource added successfully', type: "success"});
        });
    };

}).controller('ResourceEditCtrl', function($scope, Restangular, $modalInstance, $rootScope, $timeout) {


    $scope.close = $modalInstance.close;


    //            parseResourceObject(resource);


    // $timeout(function() {
    //     Restangular.one('resources/detail').get({id:$routeParams.id}).then(function (resource) {
    //         //$scope.resourceType = resourceType;
    //         console.log(resource);
    //         $scope.resource = resource;
    //     });
    // }, 0);


    $scope.submit = function () {
        $scope.resource.type = $scope.resourceType;
        Restangular.all('resources/index').post($scope.resource).then(function () {
            $rootScope.$emit('sp.message', {title: 'User added successfully', type: "success"});
            $rootScope.$emit('resources.reload', true);
        });
    };
   
});

function parseResourceObject(resource) {
    angular.forEach(resource.fields, function(object, key) {
        if (object && typeof object.value === 'string') {
            resource.fields[key] = object.value;
        }
        if (object && object.values) {
            resource.fields[key] = object.values;
        }
        console.log(typeof resource.fields[key]);
    });
}

app.directive('spField', function($compile) {

  var fieldTemplate = 
    '<div sp-string-field ng-if="isType(\'string\')"></div>' +
    '<div sp-text-field ng-if="isType(\'text\')"></div>';

  return {
    replace: true,
    transclude: false,
    template: function() {
        return '<div class="form-group" ng-class="{\'has-error\': form.resource[{[field.slug]}].$invalid}">' +
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