'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider, Restangular) {

  $urlRouterProvider.otherwise('/resources/1');

  $stateProvider.state('login', {
      url: "/login",
      controller: 'LoginCtrl',
      templateUrl: '/js/templates/login/index.html',
      resolve: {
        authentication: ['Restangular', function (Restangular) {
          return Restangular.all('users/authenticate');
        }]
      }
    })
    .state('dashboard', {
      url: "/dashboard",
      controller: "DashboardCtrl",
      authenticate: true,
      templateUrl: "/js/templates/login/dashboard.html"
    })
    .state('logout', {
      url: "/logout",
      controller: "LogoutCtrl",
      resolve: {
        authenticate: ['Restangular', function (Restangular) {
          return Restangular.all('users/authenticate');
        }]
      }
    });
}]);