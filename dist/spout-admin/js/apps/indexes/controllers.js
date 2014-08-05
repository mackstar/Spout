'use strict';

app.controller('IndexesCtrl', function($scope, $rootScope, indexes) {
  $scope.form = {};
  $scope.indexes = indexes;
  $scope.index = {};

  $rootScope.$on('spout.index-selected', function(event, index){ 
    if (toParams) {
      $scope.index = index;
    }
  });

  $scope.submit = function () {
    $scope.indexes.post($scope.index).then(function(response) {
      $scope.indexes.push(response['index']);
    });
  };
});

app.controller('IndexesUrisCtrl', function($scope, $rootScope, index, uris) {
  $scope.index = index;
  $scope.uris = uris;
  $scope.uri = {
    index: index.slug 
  }

  $scope.select = function (uri) {
    if ($scope.uri.id != uri.id) {
        $scope.uri = uri;
    } else {
        $scope.uri = {
            index: $scope.uri.index 
        };
    }
  }

  $scope.form = {};

    $scope.remove = function() {
      $scope.uris.remove({id: $scope.uri.id}).then(function() {
        delete $scope.index.uris[$scope.uri.key];
        $scope.uri = {
          index: $scope.uri.index 
        };
        $scope.form.uri.$setPristine();
        $rootScope.$emit('sp.message', {message: 'URI removed.', type: "success"});
      });
   }

   $scope.submit = function() {
      var action = ($scope.uri.id)? 'customPUT' : 'post';
      $scope.uris[action]($scope.uri).then(function(response) {
        var uri = $scope.uri;

        uri.id = response.id;

        $scope.index.uris[uri.key] = uri;
        $scope.uri = {
            index: $scope.uri.index 
        };
        $scope.form.uri.$setPristine();
        $rootScope.$emit('sp.message', {title: 'Yeah!', message: 'URI posted.', type: "success"});
      });
   }

});