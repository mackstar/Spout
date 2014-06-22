'use strict';

app.controller('MenusCtrl', function($scope, $state, menus) {
  $scope.menus = menus;

  $scope.remove = function(menu) {
    var index = $scope.menus.indexOf(menu);
    if (confirm("Are you sure you want to destroy this menu?")) {
      $scope.menus[index].remove({slug: menu.slug}).then(function() {
        $scope.menus.splice(index, 1);
      });
    }
  }
});

app.controller('MenusAddCtrl', function($scope, $rootScope) {
  $scope.menu = {};

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

app.controller('MenuLinksCtrl', function ($scope, $stateParams, $rootScope, links) {

  var i = links.length - 1;

  if ($stateParams.parent) {
    for (; i >= 0; i--) {
      if (links[i].parent_id !== $stateParams.parent) {
        links.splice(i, 1);
      }
    }
  }

  if (!$stateParams.parent) {
    for (; i >= 0; i--) {
      if (links[i].parent_id && links[i].parent_id != 0) {
        links.splice(i, 1);
      }
    }
  }

  $scope.links = links;

  var items = window.document.getElementById("go-list");
  new Sortable(items, {
      group: "go-list",
      onUpdate: function (evt) {
          var reorderedLinks = [];
          angular.forEach(items.getElementsByTagName("li"), function(li, index) {
              var id = li.getAttribute("data-link-id");
              angular.forEach($scope.links, function(link) {
                if(link.id === id) {
                    reorderedLinks.push({
                        id: id,
                        weight: +index
                    });
                }
              });
          });
          $rootScope.$emit('spout.loading', {status: true});
          $scope.links.customPUT({links: reorderedLinks}, 'reorder').then(function() {
            $rootScope.$emit('spout.loading', {status: false});
          });
      }
  });
  angular.forEach($scope.menus, function (menu) {
    if (menu.slug === $stateParams.slug) {
      $scope.menu = menu;
    }
  });

  $scope.delete = function(link) {
    var index = $scope.links.indexOf(link);
    if (confirm("Are you sure you want to remove this link?")) {
      link.remove().then(function() {
        $scope.links.splice(index, 1);
      });
    }
  };
});

app.controller('MenuEditLinkCtrl', function($scope, $modalInstance, $rootScope, $filter, $stateParams) {
  $scope.close = $modalInstance.close;
  $scope.link = $filter('findById')($scope.links, $stateParams.id);

  $scope.submit = function() {
    if ($scope.form.link.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'Form not yet complete.', type: "danger"});
      return;
    }
    $scope.link.put().then(function () {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Link Updated.', type: "success"});
      $scope.close();
    });
  };
});

app.controller('MenuAddLinkCtrl', function($scope, $modalInstance, $rootScope, $stateParams) {
  $scope.close = $modalInstance.close;
  $scope.link = {
    menu: $scope.menu.slug,
    type: 'url',
    parent_id: $stateParams.parent || 0,
    weight: 999
  };

  $scope.submit = function() {
    if ($scope.form.link.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'Form not yet complete.', type: "danger"});
      return;
    }
    $scope.links.post($scope.link).then(function () {
      $scope.links.push($scope.link);
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Menu added.', type: "success"});
      $scope.close();
    });

  };
});
