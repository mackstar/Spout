'use strict';

var app = angular.module('Application', ['restangular']);

app.controller('MainCtrl', function($scope) {
    $scope.text = 'Hello World!';
});
 
