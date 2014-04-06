'use strict';

app.controller('MenusCtrl', function($scope, $state, menus) {
  $scope.menus = menus;

  $scope.remove = function(menu) {
    var index = $scope.menus.indexOf( menu );
    if (confirm("Are you sure you want to destroy this menu?")) {
      $scope.menus[index].remove({slug: menu.slug}).then(function() {
        $scope.menus.splice(index, 1);
      });
    }
  }
});

app.controller('MenusAddCtrl', function($scope, $rootScope) {
  $scope.menu = {};
  $scope.form = {};

  $scope.submit = function () {
    if ($scope.form.menu.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'Form not yet complete.', type: "danger"});
      return;
    }
    $scope.menus.post($scope.menu).then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Menu added.', type: "success"});
      $scope.menus.push($scope.menu);
      $scope.form.menu.$setPristine();
      $scope.menu = {};
    });
  };
});

app.controller('MenuLinksCtrl', function ($scope, $stateParams) {
  angular.forEach($scope.menus, function (menu) {
    if (menu.slug === $stateParams.slug) {
      $scope.menu = menu;
    }
  });

});

app.controller('MenuAddUrlLinkCtrl', function($scope, $modalInstance) {
  $scope.close = $modalInstance.close;
  $scope.link = {
    menu: $scope.menu.slug,
    type: 'url'
  }
});