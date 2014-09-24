'use strict';

app.controller('IndexesCtrl', function($scope, $rootScope, $state, indexes) {
  $scope.form = {};
  $scope.indexes = indexes;
  $scope.index = {};

  $rootScope.$on('sp.index-selected', function(event, index) {
    $scope.index = index;
  });

  $scope.select = function(index) {
    if (index.slug == $scope.index.slug) {
      $state.go('^');
      $scope.index = {};
      return;
    }
    $state.go('indexes.uris', {slug: index.slug});

  };

  $scope.remove = function () {
    if (!confirm("Are you sure?")) {
      return false;
    }
    $scope.indexes.remove({slug: $scope.index.slug}).then(function() {
      angular.forEach($scope.indexes, function(index, key) {
        if ($scope.index.slug == index.slug) {
          $scope.indexes.splice(key, 1);
        }
        
      });
      $scope.index = {};
      $rootScope.$emit('sp.message', {message: 'Index removed.', type: "success"});
      $state.go('^');
    });
    
  };

  $scope.submit = function () {
    var action = ($scope.index.id)? 'customPUT' : 'post';
    $scope.indexes[action]($scope.index).then(function(response) {
      $rootScope.$emit('sp.message', {message: 'Index saved.', type: "success"});
      $state.go('indexes.uris', {slug: $scope.index.slug}, {reload: true});
    });
  };
});

app.controller('IndexesUrisCtrl', function($scope, $rootScope, index, uris) {
  $scope.index = index;
  $scope.uris = uris;
  $scope.form = {};
  $scope.uri = {
    index: index.slug 
  }
  $rootScope.$emit('sp.index-selected', index);

  $scope.select = function (uri) {
    if ($scope.uri.id != uri.id) {
        $scope.uri = uri;
    } else {
        $scope.uri = {
            index: $scope.uri.index 
        };
    }
  }

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