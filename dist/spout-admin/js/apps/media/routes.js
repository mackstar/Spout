'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
  $stateProvider.state('media', {
    url: "/media/:folder",
    authenticate: true,
    templateUrl: '/spout-admin/js/templates/media/index.html',
    controller: 'MediaCtrl',
    params: {
      folder: { value: 0 }
    },
    resolve: {
      media: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.all('media/listing').getList({folder: $stateParams.folder });
      }],
      folders: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.all('media/folders').getList({parent: $stateParams.folder});
      }]
    }
  })
  .state('media.add-folder', {
    url: "/add-folder",
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
