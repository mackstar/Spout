'use strict';

app.controller('MediaCtrl', function($scope, $rootScope, media) {

  $scope.form = {};
  $scope.media = media;
  $scope.selectedMedia = null;

  $scope.$on('sp.media-selected', function (event, mediaItem) {
    if ($scope.selectedMedia) {
      $scope.selectedMedia.selected = false;
    }
    $scope.selectedMedia = mediaItem;
  });

  $scope.$on('sp.media-deselected', function (event, mediaItem) {
    if ($scope.selectedMedia == mediaItem) {
      $scope.selectedMedia = null;
    }
  });



  $scope.remove = function () {
    $scope.selectedMedia.remove().then(function() {
      var index = $scope.media.indexOf($scope.selectedMedia);
      $scope.media.splice(index, 1);
      $scope.selectedMedia = null;
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Media deleted.', type: "success"});
    });
  }

  $scope.submit = function () {
    if ($scope.media.$invalid) {
      $rootScope.$emit('sp.message', {title: 'Oops', message: 'The title is blank...', type: "danger"});
      return;
    }
    $scope.selectedMedia.put().then(function() {
      $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'Media updated.', type: "success"});
    });
  };
});