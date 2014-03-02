'use strict';

app.config(['$routeProvider', function($routeProvider) {
    $routeProvider
        .when('/resources/types/add', { 
            templateUrl: '/js/templates/resources/types/add.html', 
            controller: 'TypesAddCtrl'
        });
}]);

app.controller('TypesCtrl', function($scope, Restangular, $rootScope, $location) {
    function load() {
      Restangular.all('resources/types').getList().then(function (types) {
        $scope.types = types;
      });
    }
    load();
    $rootScope.$on('types.reload', function() {
        load();
    });
    $scope.delete = function (type) {
      type.remove().then(function() {
        $rootScope.$emit('sp.message', {title: 'Type removed successfully', type: "success"});
        $rootScope.$emit('types.reload', true);
      });
    };

}).controller('TypesAddCtrl', function($scope, Restangular, $routeParams, $location, $rootScope) {

    $rootScope.$emit('modal.open', true);
    $scope.type = {
        title_label: 'Title'
    };
    $scope.type.resource_fields = [];

    Restangular.one('resources/fieldtypes').get({slug:$routeParams.slug}).then(function (fieldtypes) {
        $scope.fieldtypes = fieldtypes;
    });

    $scope.addField = function (field) {

        $scope.type.resource_fields.push({
            field_type: field,
            multiple: 0,
            weight: ($scope.type.resource_fields.length + 1)
        });
    }

    $scope.removeField = function (index) {
        $scope.resource_fields.splice(index, 1);
    }

    $scope.submit = function () {
        Restangular.all('resources/types').post($scope.type).then(function () {
            console.log($scope.resource_fields);
            
        });
    };
});