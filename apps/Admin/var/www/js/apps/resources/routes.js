'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $urlRouterProvider.otherwise('/resources/2');

  $stateProvider.state('resources', {
    url: "/resources/:start",
    templateUrl: '/js/templates/resources/index.html',
    authenticate: true,
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

  .state('resources.add', {
    url: "/type/:type/add",
    authenticate: true,
    controller: 'ModalCtrl',
    template: "<div ui-view></div>",
    resolve: {
      params: function () {
        return {
          templateUrl: "/js/templates/resources/add.html",
          controller: 'ResourceAddCtrl',
          onComplete: '^',
          resolve: {
            type: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
              return Restangular.one("resources/types").get({slug: $stateParams.type});
            }]
          }
        };
      }
    }
  })
  .state('resources.add.media', {
      url: "/media",
      authenticate: true,
      controller: 'ModalCtrl',
      resolve: {
        params: function () {
          return {
            windowClass: "sp-modal__double",
            templateUrl: "/js/templates/resources/media.html",
            controller: 'ResourceMediaAddCtrl',
            onComplete: '^',
            reload: false,
            resolve: {
              media: ['Restangular', function (Restangular) {
                return Restangular.all('media/index').getList()
              }]
            }
          };
        }
      }
    })
  .state('resources.edit', {
    url: "/edit",
    authenticate: true,
    controller: 'ModalCtrl',
    resolve: {
      options: function () {
        return {
          templateUrl: "/js/templates/resources/add.html",
          controller: 'ResourceEditCtrl',
          onComplete: 'resources',
          resolve: {
            resource: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
              return Restangular.one("resources/detail").get({id:$stateParams.id});
            }]
          }
        };
      }
    }
  });
}]);