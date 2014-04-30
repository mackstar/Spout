'use strict';

app.controller('MediaCtrl', function($scope, $rootScope, media) {

  $scope.menu = {};
  $scope.form = {};
  $scope.media = media;
  $scope.selectedMedia = null;

  $scope.select = function (mediaItem) {
    if ($scope.selectedMedia) {
      $scope.selectedMedia.selected = false;
    }
    $scope.selectedMedia = mediaItem;
    mediaItem.selected = true;
  };

  $scope.submit = function (media) {

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