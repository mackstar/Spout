'use strict';

app.config(['$stateProvider', function ($stateProvider) {
  $stateProvider.state('users', {
    url: "/users",
    templateUrl: '/js/templates/users/index.html',
    authenticate: true,
    controller: 'UsersCtrl',
    resolve: {
      users: ['Restangular', function (Restangular) {
        return Restangular.all('users/index').getList();
      }],
      roles: ['Restangular', function (Restangular) {
        return Restangular.all('users/roles').getList();
      }]
    }
  }).state('users.user', {
    url: "/user/:email",
    template: "<div ui-view></div>",
    authenticate: true,
    controller: 'UserCtrl',
    resolve: {
      user: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
        return Restangular.one("users/index").get({email: $stateParams.email});
      }]
    }
  })
    .state('users.user.edit', {
      url: "/edit",
      controller: 'ModalCtrl',
      authenticate: true,
      resolve: {
        params: function () {
          return {
            templateUrl: "/js/templates/users/edit.html",
            controller: 'UserEditCtrl',
            onComplete: 'users'
          };
        }
      }
    }).state('users.add', {
      url: "/add",
      controller: 'ModalCtrl',
      authenticate: true,
      resolve: {
        params: function () {
          return {
            templateUrl: "/js/templates/users/edit.html",
            controller: 'UserAddCtrl',
            onComplete: 'users'
          };
        }
      }
    });
}]);
