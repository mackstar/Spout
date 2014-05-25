'use strict';

var app = angular.module('spout', ['ngRoute', 'restangular', 'ngAnimate', 'ui.bootstrap', 'ui.router']);

app.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{[').endSymbol(']}');
});

app.run(function(Restangular, $rootScope) {
  Restangular.setBaseUrl('/api');
  Restangular.configuration.getIdFromElem = function() {
    return null;
  };

  Restangular.setResponseInterceptor(function(data) {
    if (data.message) {
      $rootScope.$emit('message', {message: data.message});
    }
    if (data._model && data._pager) {
      data[data._model]._pager = data._pager;
    }
    if (data._model) {
      return data[data._model];
    }
    return data;
  });

  Restangular.setErrorInterceptor(function(response) {
    if (response.status && response.data.title) {
      $rootScope.$emit('sp.message', {title: response.data.title, message: response.data.message, type: "danger"});
    }
    return response;
  });

});

app.directive('errorWindow', function($rootScope, $timeout) {
  return {
    restrict: 'E',
    template: '<div class="panel-container row sp-float animate-show" ng-show="show">' +
    '<div class="col-md-8 col-md-offset-2 panel sp-panel panel-{{type}}">' +
        '<div class="panel-heading">' +
            '<h4 class="panel-title"><span class="glyphicon glyphicon-warning-sign"></span> {{title}}</h4>' +
        '</div>' +
        '<div class="panel-body" ng-show="message">' +
            '<p>{{message}}</p>' +
        '</div>' +
    '</div>' +
'</div>',
    link: function(scope) {

      function restore() {
        scope.$apply(function() {
          scope.show = false;
        });
      }

      $rootScope.$on('sp.message', function(obj, options) {
        scope.show = true;
        scope.title = options.title;
        scope.message = options.message;
        scope.type = options.type;
        $timeout(restore, 3000);
      });
    }
  };
});

app.service('parseFormErrors', function() {
  return function (data, form) {
    for(property in data.errors) {
      form[property].$dirty = true;
      form[property].$invalid = true;
      form[property].$message = data.errors[property];
    }
  };
});

app.directive('formfieldErrorMsg', function() {

  return {
    restrict: 'E',
    replace: true,
    transclude: false,
    scope: { field: '=' },

    template: '<p class="help-block" ng-show="showMessage()">{{getMessage()}}</p>',
    link: function(scope, element, attrs) {
      var form = attrs.field.split(".")[0],
        property = attrs.field.split(".")[1];

      scope.message = attrs.msg;
      scope.showMessage = function () {
        return scope.field.$dirty && scope.field.$invalid;
      };

      scope.getMessage = function() {
        if (!scope.field || !scope.field.$message) {
          return scope.message;
        }
        return scope.field.$message;
      };

    }
  };
});

/*
 * A directive that creates a slug from a given title.
 */
app.directive('spSlugTitle', function() {

  return {
    restrict: 'A',
    replace: false,
    transclude: false,
    scope: {model: '='},
    link: function(scope, element, attrs) {
      var stop = false,
          slug,
          src = attrs.spSlugTitle || 'title';

      scope.$watch('model.' + src, function() {
        if (stop || typeof scope.model === 'undefined' || typeof scope.model[src] === 'undefined') return;
        slug = scope.model[src].toLowerCase().replace(/[^a-z0-9]/g, "-");
        scope.model.slug = slug;
      });

      scope.$watch('model.slug', function() {
        if(typeof scope.model !== 'undefined' && scope.model.slug !== slug) {
          stop = true;
        }
      });

    }
  };
});

app.controller('ModalCtrl', function($scope, params, $modal, $state, $rootScope) {

  var onCompleteOptions = params.onCompleteOptions || {},
    options = {backdrop: 'static', reload: true, scope: $scope, keyboard: false};
  angular.extend(options, params);
  options.scope.form = {};

  $modal.open(options).result.then(function(result) {
    if (result && result.emit) {
      $rootScope.$emit(result.emit.name, result.emit.data);
    }
    return $state.go(options.onComplete, onCompleteOptions, {reload:options.reload});

  });

});

app.filter('findById', function() {
  return function(input, id) {
    var i = 0,
        length = input.length;
    for (; i<length; i++) {
      if (+input[i].id === +id) {
        return input[i];
      }
    }
    return null;
  };
});

app.directive('spLoadingSpinner', function ($rootScope) {

  return {
    restrict: 'E',
    replace: true,
    scope: {},
    template: '<div style="padding-top: 10px"><img src="/img/spinner.gif" ng-show="loading" /></div>',
    link: function(scope) {

      scope.loading = false;

      $rootScope.$on('spout.loading', function(event, options){
        scope.loading = options.status;
      });
      $rootScope.$on('$stateChangeStart', function(){
        scope.loading = true;
      });
      $rootScope.$on('$stateChangeSuccess', function(){
        scope.loading = false;
      });
    }
  };
});