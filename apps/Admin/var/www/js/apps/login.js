'use strict';

app.controller('LoginCtrl', function($scope, Restangular) {
    $scope.login = {};
    console.log("loaded");
    $scope.submitForm = function() {
        console.log("click");
        Restangular.all('users/authenticate').post($scope.login).then(function (response) {
            if (response.user) {
                // do a yes action here
            }
        });
    }
});