'use strict';

app.controller('LoginCtrl', function($scope, $rootScope, authentication, $state, CurrentUserService, Restangular) {
  $scope.login = {};
  $scope.form = {};
  $scope.submit = function () {
    if ($scope.form.login.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }
    authentication.post($scope.login).then(function(user) {
      CurrentUserService.isLoggedIn = true;
      CurrentUserService.user = Restangular.stripRestangular(user);
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'You have successfully logged in', type: "success"});
      $state.go("dashboard");
    });
  };
});

app.controller('LogoutCtrl', function(authenticate, $state, CurrentUserService) {
  authenticate.remove().then(function() {
    CurrentUserService.isLoggedIn = false;
    CurrentUserService.user = null;
    $state.go('login');
  });
});

app.controller('DashboardCtrl', function($scope) {
});