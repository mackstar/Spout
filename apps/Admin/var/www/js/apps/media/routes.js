'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
  $stateProvider.state('media', {
    url: "/media",
    templateUrl: '/js/templates/media/index.html',
    authenticate: true,
    controller: 'MediaCtrl',
    resolve: {
      media: ['Restangular', function (Restangular) {
         return Restangular.all('media/index').getList();;
       }
      ]
    }
  });
}]);