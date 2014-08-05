'use strict';

app.config(['$stateProvider', function ($stateProvider) {
  $stateProvider.state('indexes', {
    url: "/indexes",
    templateUrl: '/spout-admin/js/templates/indexes/index.html',
    authenticate: true,
    controller: 'IndexesCtrl',
    resolve: {
      indexes: ['Restangular', function (Restangular) {
        return Restangular.all('indexes/index').getList();
      }]
    }
  }).state('indexes.uris', {
    url: "/:slug",
    templateUrl: "/spout-admin/js/templates/indexes/uris.html",
    authenticate: true,
    controller: 'IndexesUrisCtrl',
    resolve: {
      index: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.one("indexes/index").get({slug: $stateParams.slug});
      }],
      uris: ['Restangular', function (Restangular) {
        return Restangular.all("indexes/uris");
      }]
    }
  });
}]);