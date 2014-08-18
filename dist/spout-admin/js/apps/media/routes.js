'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
  $stateProvider.state('media', {
    url: "/media",
    authenticate: true,
    templateUrl: '/spout-admin/js/templates/media/index.html',
    controller: 'MediaCtrl',
    resolve: {
      media: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.all('media/listing').getList({folder: 0 });
      }],
      folders: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.all('media/folders').getList({parent: 0 });
      }]
    }
  })
  .state('media.add-folder', {
    url: "/add-folder/:folder",
    authenticate: true,
    controller: 'ModalCtrl',
    resolve: {
      params: function () {
        return {
          templateUrl: "/spout-admin/js/templates/media/edit-folder.html",
          controller: 'MediaAddCtrl',
          onComplete: '^',
          resolve: {
            folders: ['Restangular', function (Restangular) {
              return Restangular.all('media/folders');
            }]
          }
        };
      }
    }
  });
}]);
