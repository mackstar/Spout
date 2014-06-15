'use strict';

angular.module('mackstar.autocomplete', [])

  .directive('autoCompleteOptions', function() {
    return {
      restrict:'EA',
      replace: true,
      template: '<div class="list-group">' +
        '<a ng-click="select(option)" class="list-group-item" ng-repeat="option in options">'+
          '<h4 class="list-group-item-heading">{[option.title]}</h4>'+
          '<p class="list-group-item-text">Type: {[option.type]}, Slug: {[option.slug]}</p>'+
        '</a>'+
      '</div>',
      link: function(scope) {

        scope.select = function (option) {
          option.display = option.title;
          scope.currentField = angular.extend(option, scope.currentField);
          scope.options = [];
        };
      }
    };
  })

  .directive('autoComplete', function($compile, $http) {
    return {
      restrict:'EA',
      replace: false,
      scope: {
        ngModel: '=',
        currentField: '='
      },
      link: function (scope, element) {
        var el = $compile("<div auto-complete-options style='position: absolute'></div>")(scope);
        element.parent().append(el);

        scope.$watch('ngModel', function (search) {
          if (!search) {
            return;
          }
          $http({method: 'GET', url: '/api/resources/search', params: {q: search, type: scope.currentField.type}}).success(function(data) {
            scope.options = data['resources'];
          });
        });
      }
    };
  });