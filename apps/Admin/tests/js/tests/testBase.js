'use strict';

var app = angular.module('Application', ['restangular', 'ui.router']);

app.controller('MainCtrl', function($scope) {
    $scope.text = 'Hello World!';
});
 
