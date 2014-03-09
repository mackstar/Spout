
'use strict';

app.config(['$stateProvider', function($stateProvider) {
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
    }).state('users.edit', {
      url: "/edit/:email",
      templateUrl: '/js/templates/users/edit.html',
      controller: 'UserEditCtrl',
      resolve: {
        user: ['Restangular', '$stateParams', function (Restangular, $stateParams) {
          return Restangular.one("users/index").get({email: $stateParams.email})
        }]
      }
    }).state('users.add', {
      url: "/add",
      templateUrl: '/js/templates/users/edit.html',
      controller: 'UserAddCtrl'
    })
    .state('users.test', {
      url: "/test",
      onEnter: function($stateParams, $state, $modal) {
        $modal.open({
            templateUrl: "/js/templates/users/edit.html",
            controller: 'UserAddCtrl'
        }).result.then(function(route) {
          return $state.transitionTo(route);
        });
    }
    });
}]);



app.controller('UsersCtrl', function($scope, $location, users, roles) {
    $scope.users = users;
    $scope.edit = function (user) {
      $location.path('/users/edit/' + user.email);
    };
    
    $scope.delete = function(user) {
      if (!confirm("Are you sure?")) {
        return;
      }
      user.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'User removed successfully', type: "success"});
        $rootScope.$emit('users.reload', true);
      });
    }
    $scope.close = function() {
      $rootScope.$emit('modal.close', true);
      $location.path('/users');
    }
});


var ModalInstanceCtrl = function ($scope, $modalInstance, items) {

  $scope.items = items;
  $scope.selected = {
    item: $scope.items[0]
  };

  $scope.ok = function () {
    $modalInstance.close($scope.selected.item);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
};


app.controller('UserEditCtrl', function($scope, parseFormErrors, user, Restangular) {
      $scope.user = user;

      $scope.submit = function() {
        if ($scope.userForm.$invalid) {
          $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
          return;
        }
        user.put().then(function() {
          $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'User saved successfully', type: "success"});
          $rootScope.$emit('users.reload', true);
          $rootScope.$emit('modal.close', true);
          $location.path('/users');
        }, function(response) {
          parseFormErrors(response.data, $scope.userForm);
        });
      };
});

app.controller('UserAddCtrl', function($scope, Restangular, parseFormErrors, $location, $modalInstance) {

  $scope.addMode = true;

  $scope.user = {
    email: '',
    password: '',
    name: ''
  }

  $scope.close = function() {
    $modalInstance.close("users");
  }

  $scope.submit = function() {
    if ($scope.userForm.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }

    Restangular.all('users/index').post($scope.user).then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'User saved successfully', type: "success"});
      $rootScope.$emit('users.reload', true);
      $rootScope.$emit('modal.close', true);
      $location.path('/users');
    }, function(response) {
      parseFormErrors(response.data, $scope.userForm);
    });
  }
});