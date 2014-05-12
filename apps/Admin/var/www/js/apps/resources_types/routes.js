'use strict';

app.config(['$stateProvider', function ($stateProvider) {
  $stateProvider.state('resource-types', {
    url: "/resource/types",
    templateUrl: '/js/templates/resources/types/index.html',
    controller: 'ResourceTypesCtrl',
    authenticate: true,
    resolve: {
      types: ['Restangular', function (Restangular) {
        return Restangular.all('resources/types').getList();
      }]
    }
  })
    .state('resource-types.resolve', {
      url: "/resolve",
      template: "<div ui-view></div>",
      controller: 'ResourceTypesResolveCtrl',
      authenticate: true,
      resolve: {
        fieldtypes: ['Restangular', function (Restangular) {
          return Restangular.all('resources/fieldtypes').getList();
        }]
      }
    })
    .state('resource-types.resolve.add', {
      url: "/add",
      controller: 'ModalCtrl',
      authenticate: true,
      resolve: {
        options: function () {
          return {
            templateUrl: "/js/templates/resources/types/form.html",
            controller: 'ResourceTypesAddCtrl',
            onComplete: 'resource-types'
          };
        }
      }
    });
}]);