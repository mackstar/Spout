'use strict';

app.directive('spField', function() {

  var fieldTemplate =
    '<div sp-string-field ng-if="isType(\'string\')"></div>' +
    '<div sp-text-field ng-if="isType(\'text\')"></div>' +
    '<div sp-media-field ng-if="isType(\'media\')"></div>';

  return {
    replace: true,
    transclude: false,
    template: function() {
      return '<div class="form-group" ng-class="{\'has-error\': form.resource[{[field.slug]}].$invalid}">' +
        '<label for="name">{[field.label]}</label>' +
        '<div ng-switch="showMultiple">' +
          '<div ng-switch-when="true">' +
            '<div ng-repeat="key in keys" class="multiple">' +
              fieldTemplate +
            '</div>' +
          '</div>' +
          '<div ng-switch-default>' +
            fieldTemplate +
          '</div>' +
        '</div>' +
        '<label ng-show="showMultiple" class="multiple-buttons">' +
          '<span class="glyphicon glyphicon-minus-sign" ng-show="showMinusButton()" ng-click="removeField()"></span> ' +
          '<span class="glyphicon glyphicon-plus-sign" ng-click="addField()"></span>' +
        '</label>' +
      '</div>';
    },
    link: function(scope) {

      var i;

      scope.isType = function (fieldType) {
        return fieldType === scope.field.field_type;
      };

      scope.showMultiple = (scope.field.multiple === "1" && !scope.isType('media'));

      if (scope.field.multiple === "0") {
        return;
      }
      scope.keys = [0];

      if (!Array.isArray(scope.resource.fields[scope.field.slug])) {
        scope.resource.fields[scope.field.slug] = [];
      }

      for (i=1; i < scope.resource.fields[scope.field.slug].length; i++) {
        scope.keys.push(i);
      }

      scope.showMinusButton = function () {
        return (scope.keys.length > 1);
      };

      scope.removeField = function () {
        var fieldCount = scope.keys.length - 1;
        scope.resource.fields[scope.field.slug].splice(fieldCount, 1);
        scope.keys.splice(fieldCount, 1);
      };

      scope.addField = function () {
        console.log(scope.keys);
        scope.keys.push(scope.keys.length);
      };
    }
  };
});

app.directive('multipleField', function() {
  return {
    replace: true,
    scope: {model: "=model"}
  }
});

app.directive('spStringField', function() {
  return {
    replace: true,
    transclude: true,
    template: '<div ng-switch="field.multiple">' +
      '<input type="text" ng-model="resource.fields[field.slug][key]" class="form-control" ng-switch-when="1" />' +
      '<input type="text" ng-model="resource.fields[field.slug]" class="form-control" ng-switch-default required />' +
    '</div>'
  };
});

app.directive('spTextField', function() {
  return {
    replace: true,
    transclude: true,
    template: '<textarea class="form-control" ng-model="resource.fields[field.slug]" rows="6" ></textarea>'
  };
});

app.directive('spMediaField', function($rootScope) {
  return {
    replace: true,
    transclude: true,
    template: '<div><button class="btn" ui-sref=".media({field: field.slug})">Select Media</button>' +
      '<div class="panel-body" ng-show="displayMedia.length"><sp-media-items media="displayMedia"></sp-media-items></div>' +
      '</div>',
    link: function(scope) {
      scope.displayMedia = [];
      if (scope.resource.fields[scope.field.slug].length) {
        scope.displayMedia = scope.resource.fields[scope.field.slug];
      }
      $rootScope.$on('sp.media.selected', function (obj, data) {
        if (scope.field.slug === data.field) {
          scope.displayMedia = data.selection;
          scope.resource.fields[scope.field.slug] = (scope.field.multiple === "1")? data.selection : data.selection[0];
        }
      });
    }
  };
});