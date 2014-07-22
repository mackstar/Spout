'use strict';

app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

  $stateProvider.state('menus', {
    url: "/menus",
    templateUrl: '/spout-admin/js/templates/menus/index.html',
    authenticate: true,
    controller: 'MenusCtrl',
    resolve: {
      menus: ['Restangular', function (Restangular) {
        return Restangular.all('menus/index').getList();
      }]
    }
  }).state('menus.links', {
    url: "/links/:slug/:parent",
    templateUrl: '/spout-admin/js/templates/menus/links.html',
    authenticate: true,
    controller: 'MenuLinksCtrl',
    resolve: {
      links: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.all('menus/links').getList({menu:$stateParams.slug});
      }]
    }
  }).state('menus.links.edit', {
    url: "/edit/:id",
    authenticate: true,
    controller: 'ModalCtrl',
    resolve: {
      params: ['$stateParams', function ($stateParams) {
        return {
          templateUrl: "/spout-admin/js/templates/menus/url-form.html",
          controller: 'MenuEditLinkCtrl',
          onComplete: 'menus.links',
          onCompleteOptions: { slug: $stateParams.slug }
        };
      }]
    }
  }).state('menus.links.add', {
    url: "/add",
    controller: 'ModalCtrl',
    resolve: {
      params: ['$stateParams', function ($stateParams) {
        return {
          templateUrl: "/spout-admin/js/templates/menus/url-form.html",
          controller: 'MenuAddLinkCtrl',
          onComplete: 'menus.links',
          onCompleteOptions: { slug: $stateParams.slug }
        };
      }]
    }
  });
}]);