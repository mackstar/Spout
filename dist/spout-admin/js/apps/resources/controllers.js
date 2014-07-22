'use strict';

app.controller('ResourcesCtrl', function($scope, resources, types, $state, $stateParams, $rootScope) {
  $scope.types = types;
  $scope.resources = resources;

  $scope.$watch('resources._pager.current', function(page){
    if (page !== undefined && $stateParams.start !== page) {
      $state.go('resources', {start: page});
    }
  });

  $scope.delete = function(resource) {
    if (!confirm("Are you sure?")) {
      return;
    }
    resource.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'Resource removed successfully', type: "success"});
        $state.go('resources', {start: $stateParams.start}, {reload:true});
    });
  };
});

app.controller('ResourceCtrl', function($scope, resource) {
  $scope.resource = resource;
});

app.controller('ResourceMediaAddCtrl', function($scope, media, $modalInstance, field) {
  $scope.close = $modalInstance.close;
  $scope.submit = function() {
    var selectedMedia = [];
    angular.forEach($scope.media, function(mediaItem) {
      if (mediaItem.selected) {
        selectedMedia.push(mediaItem);
      }
    });
    $modalInstance.close({emit: { name: 'sp.media.selected', data: {field: field, selection: selectedMedia}}});
  };
  media.getList().then(function(data){
    $scope.media = data;
  });
});

app.controller('ResourceAddCtrl', function($scope, Restangular, $modalInstance, $rootScope, type) {
  $scope.type = type;
  $scope.close = $modalInstance.close;
  $scope.resource = { fields: {}};
  $scope.submit = function () {
    $scope.resource.type = $scope.type;
    Restangular.all('resources/index').post($scope.resource).then(function () {
      $scope.close();
      $rootScope.$emit('sp.message', {title: 'Resource added successfully', type: "success"});
    });
  };
});

app.controller('ResourceEditCtrl', function($scope, type, $modalInstance, $rootScope, resource) {
  $scope.type = type;
  $scope.close = $modalInstance.close;

  $scope.resource = resource;
  parseResourceObject($scope.resource);

  $scope.submit = function () {
    $scope.resource.type = $scope.type;
    $scope.resource.route = 'resources/index';
    $scope.resource.put().then(function () {
      $scope.close();
      $rootScope.$emit('sp.message', {title: 'Resource edited successfully', type: "success"});
    });
  };
});

function parseResourceObject(resource) {
  angular.forEach(resource.fields, function(object, key) {
    if (object && typeof object.value === 'string') {
      resource.fields[key] = object.value;
    }
    if (object && object.values) {
      resource.fields[key] = object.values;
    }
  });
  console.log(resource);
}