'use strict';

app.controller('ResourceTypesResolveCtrl', function ($scope, fieldtypes) {
  $scope.fieldtypes = fieldtypes;
});

app.controller('ResourceTypesCtrl', function ($scope, $rootScope, types) {
  $scope.types = types;
  $scope.delete = function (type) {
    type.remove().then(function () {
      $rootScope.$emit('sp.message', {title: 'Type removed successfully', type: "success"});
      $rootScope.$emit('types.reload', true);
    });
  };
});

app.controller('ResourceTypesAddCtrl', function ($scope, Restangular, $rootScope, $modalInstance) {

  $scope.form = {};
  $scope.type = {
    title_label: 'Title'
  };
  $scope.type.resource_fields = [];

  $scope.addField = function (field) {
    $scope.type.resource_fields.push({
      field_type: field,
      multiple: 0,
      weight: ($scope.type.resource_fields.length + 1)
    });
  };

  $scope.removeField = function (index) {
    $scope.type.resource_fields.splice(index, 1);
  };

  $scope.close = $modalInstance.close;

  $scope.submit = function () {

    if ($scope.form['resource-types'].$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The form is not yet complete', type: "danger"});
      return;
    }

    Restangular.all('resources/types').post($scope.type).then(function () {
      $scope.close();
      $rootScope.$emit('sp.message', {title: 'Added resource type successfully', type: "success"});
    });
  };
});