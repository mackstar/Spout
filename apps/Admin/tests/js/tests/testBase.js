'use strict';

var app = angular.module('Application', ['ngRoute', 'restangular', 'ui.router']);

app.controller('MainCtrl', function($scope) {
    $scope.text = 'Hello World!';
});
 
