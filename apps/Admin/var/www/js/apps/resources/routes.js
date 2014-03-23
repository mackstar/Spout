'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/resources/1');

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
      controller: 'ResourceTypeResolveCtrl',
      resolve: {
        type: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
          return Restangular.one("resources/types").get({slug: $stateParams.type});
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
          };
        }
      }
    })
    .state('resources.type.resource', {
      url: "/resource/:slug/:id",
      template: "<div ui-view></div>",
      controller: 'ResourceCtrl',
      resolve: {
        resource: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
          return Restangular.one("resources/detail").get({id:$stateParams.id});
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
          };
        }
      }
    });
}]);