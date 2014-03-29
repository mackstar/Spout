'use strict';

app.config(['$stateProvider', function ($stateProvider) {
  $stateProvider.state('users', {
    url: "/users",
    templateUrl: '/js/templates/users/index.html',
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
      resolve: {
        options: function () {
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
      resolve: {
        options: function () {
          return {
            templateUrl: "/js/templates/users/edit.html",
            controller: 'UserAddCtrl',
            onComplete: 'users'
          };
        }
      }
    });
}]);

app.controller('UsersCtrl', function ($scope, $location, users, roles, $rootScope) {

  $scope.roles = roles;
  $scope.users = users;
  $scope.edit = function (user) {
    $location.path('/users/user/' + user.email + '/edit');
  };

  $scope.delete = function (user) {
    if (!confirm("Are you sure?")) {
      return;
    }
    user.remove().then(function () {
      $rootScope.$emit('sp.message', {title: 'User removed successfully', type: "success"});
      $rootScope.$emit('users.reload', true);
    });
  };
});

app.controller('UserCtrl', function ($scope, user) {
  $scope.user = user;
});


app.controller('UserEditCtrl', function ($scope, parseFormErrors, $modalInstance, $rootScope) {

  $scope.form = {};

  $scope.close = $modalInstance.close;

  $scope.submit = function () {
    if ($scope.form.user.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }
    $scope.user.put().then(function () {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'User saved successfully', type: "success"});
      $modalInstance.close();
    }, function (response) {
      parseFormErrors(response.data, $scope.form.user);
    });
  };
});

app.controller('UserAddCtrl', function ($scope, Restangular, parseFormErrors, $modalInstance, $rootScope) {
  $scope.addMode = true;
  $scope.form = {};

  console.log("controller");


  $scope.user = {
    email: '',
    password: '',
    name: ''
  };

  $scope.close = $modalInstance.close;

  $scope.submit = function () {
    console.log("submit");
    if ($scope.form.user.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }

    Restangular.all('users/index').post($scope.user).then(function () {
      $modalInstance.close("users");
    }, function (response) {
      parseFormErrors(response.data, $scope.userForm);
    });
  };
});