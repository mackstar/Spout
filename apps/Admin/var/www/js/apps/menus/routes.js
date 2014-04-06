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
  }).state('menus.links', {
    url: "/links/:slug",
    templateUrl: '/js/templates/menus/links.html',
    authenticate: true,
    controller: 'MenuLinksCtrl'
//    resolve: {
//      links: ['Restangular', function (Restangular, $stateParams) {
//        return Restangular.all('menus/links').getList({menu:$stateParams});
//      }]
//    }
  }).state('menus.links.add-url', {
    url: "/add/url",
    controller: 'ModalCtrl',
    resolve: {
      options: ['$stateParams', function ($stateParams) {
        return {
          templateUrl: "/js/templates/menus/url-form.html",
          controller: 'MenuAddUrlLinkCtrl',
          onComplete: 'menus.links',
          onCompleteOptions: { slug: $stateParams.slug }
        };
      }]
    }
  });
}]);