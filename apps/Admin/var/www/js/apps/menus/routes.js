'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $stateProvider.state('menus', {
    url: "/menus",
    templateUrl: '/js/templates/menus/index.html',
    authenticate: true,
    controller: 'MenusCtrl',
    resolve: {
      menus: ['Restangular', function (Restangular) {
        return Restangular.all('menus/index').getList();
      }]
    }
  });
}]);