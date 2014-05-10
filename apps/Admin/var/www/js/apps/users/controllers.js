'use strict';

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