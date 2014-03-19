'use strict';

app.config(['$stateProvider', function($stateProvider) {
    $stateProvider.state('resource-types', {
        url: "/resource/types",
        templateUrl: '/js/templates/resources/types/index.html',
        controller: 'ResourceTypesCtrl',
        resolve: {
          types: ['Restangular', function (Restangular) {
            return Restangular.all('resources/types').getList()
          }]
        }
    })
    .state('resource-types.resolve', {
      url: "/resolve",
      template: "<div ui-view></div>",
      controller: 'ResourceTypesResolveCtrl',
      resolve: {
        fieldtypes: ['Restangular', function (Restangular) {
          return Restangular.all('resources/fieldtypes').getList();
        }]
      }
    })
    .state('resource-types.resolve.add', {
        url: "/add",
        controller: 'ModalCtrl',
        resolve: {
            options: function () {
                return {
                    templateUrl: "/js/templates/resources/types/add.html",
                    controller: 'ResourceTypesAddCtrl',
                    onComplete: 'resource-types'
                }
            }
        }
    })
}]);

app.controller('ResourceTypesResolveCtrl', function($scope, fieldtypes) {
    $scope.fieldtypes = fieldtypes;
});
app.controller('ResourceTypesCtrl', function($scope, $rootScope, types) {
    $scope.types = types;
    $scope.delete = function (type) {
      type.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'Type removed successfully', type: "success"});
        $rootScope.$emit('types.reload', true);
      });
    };
});
app.controller('ResourceTypesAddCtrl', function($scope, Restangular, $rootScope, $modalInstance) {


    $scope.form = {};
    $scope.type = {
        title_label: 'Title'
    };


    $scope.type.resource_fields = [];

    $scope.addField = function (field) {
        $scope.type.resource_fields.push({
            field_type: field,
            multiple: 0,
            weight: ($scope.type.resource_fields.length + 1)
        });
    }

    $scope.removeField = function (index) {
        $scope.type.resource_fields.splice(index, 1);
    }

    $scope.close = function() {
        $modalInstance.close();
    }

    $scope.submit = function () {
        Restangular.all('resources/types').post($scope.type).then(function () {
            console.log($scope.type.resource_fields);
            
        });
    };
});