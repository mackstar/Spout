'use strict';

app.directive('spField', function() {

  var fieldTemplate =
    '<div sp-string-field ng-if="isType(\'string\')"></div>' +
    '<div sp-text-field ng-if="isType(\'text\')"></div>' +
    '<div sp-media-field ng-if="isType(\'media\')"></div>' +
    '<div sp-boolean-field ng-if="isType(\'boolean\')"></div>' +
    '<div sp-resource-field ng-if="isType(\'resource\')"></div>'+
    '<div sp-date-field ng-if="isType(\'date\')"></div>'+
    '<div sp-time-field ng-if="isType(\'time\')"></div>';

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
    template: '<div ng-switch="field.multiple">' +
      '<textarea class="form-control" ng-model="resource.fields[field.slug][key]" rows="6" ng-switch-when="1"></textarea>' +
      '<textarea class="form-control" ng-model="resource.fields[field.slug]" rows="6" ng-switch-default></textarea>' +
    '</div>'
  };
});

app.directive('spBooleanField', function() {
  return {
    replace: true,
    transclude: true,
    template: '<div><div class="radio">' +
      '<label>' +
      '<input type="radio" ng-model="resource.fields[field.slug]" ng-value="1">' +
      'True' +
      '</label>' +
    '</div><div class="radio">' +
      '<label>' +
      '<input type="radio" ng-model="resource.fields[field.slug]" ng-value="0">' +
      'False' +
      '</label>' +
    '</div></div>'
  };
});

app.directive('spDateField', function($filter) {
  return {
    replace: true,
    transclude: true,
    template: '<p class="input-group">'+
      '<input type="text" class="form-control" '+
          'datepicker-popup '+
          'ng-model="currentField" '+
          'is-open="opened" '+
          'datepicker-options="{[dateOptions]}" />'+
      '<span class="input-group-btn">'+
        '<button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>'+
      '</span>'+
    '</p>',
    link: function ($scope) {
        $scope.currentField = $scope.resource.fields[$scope.field.slug];

        $scope.today = function() {
          $scope.currentField = new Date();
        };
        if (!$scope.currentField) {
          $scope.today();
        }

        $scope.$watch('currentField', function (date) {
          $scope.resource.fields[$scope.field.slug] = $filter('date')(date, 'yyyy-MM-dd');
        });

        $scope.clear = function () {
          $scope.currentField = null;
        };

        $scope.open = function($event) {
          $event.preventDefault();
          $event.stopPropagation();
          $scope.opened = true;
        };
        $scope.dateOptions = {
          formatYear: 'yy',
          startingDay: 1,
          showWeeks: false,
          ngModel: 'currentField'
        };
    },
  };
});

app.directive('spTimeField', function($filter) {
  return {
    replace: true,
    template: '<div class="input-group">'+
      ' <timepicker ng-model="currentTime" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian"></timepicker>'+
    '</div>',
    link: function ($scope) {

      var roundedTime = function() {
        var time = 1000 * 60 * 5,
          date = new Date();
          
        return new Date(Math.round(date.getTime() / time) * time);

      },
      timeFromValue = function(time) {
        var values = time.split(':'),
          date = new Date();

        date.setHours(values[0]);
        date.setMinutes(values[1]);
        return date;

      }
      $scope.hstep = 1;
      $scope.mstep = 5;

      if (!$scope.resource.fields[$scope.field.slug]) {
        $scope.currentTime = roundedTime();
      } else {
        $scope.currentTime = timeFromValue($scope.resource.fields[$scope.field.slug]);
      }

      $scope.$watch('currentTime', function (time) {
        $scope.resource.fields[$scope.field.slug] = $filter('date')(time, 'HH:mm:ss');
      });

    }

  };
});

app.directive('spResourceField', function() {
  return {
    template:'<div class="input-group" ng-show="!currentField.title">' +
      '<div class="input-group-btn">' +
        '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Resource Type <span class="caret"></span></button>' +
        '<ul class="dropdown-menu">' +
          '<li ng-repeat="type in types"><a ng-click="selectType(type)">{[type.name]}</a></li>' +
        '</ul>' +
      '</div><!-- /btn-group -->' +
      '<span class="input-group-addon" ng-show="currentField.type_name">{[currentField.type_name]}</span>' +
        '<input ng-show="currentField.type" type="text" ng-model="currentField.search" current-field="currentField" class="form-control" auto-complete />' +
    '</div><!-- /input-group -->' +
    '<div class="alert alert-success alert-dismissable" ng-show="currentField.title">' +
      '<button type="button" class="close" ng-click="remove()">&times;</button>' +
      '{[currentField.type_name]}: {[currentField.title]}' +
    '</div>',
    link: function (scope) {

      scope.currentField = { search: '' };

      scope.selectType = function (type) {
        scope.currentField.type = type.slug;
        scope.currentField.type_name = type.name;
      };

      if (scope.resource.fields[scope.field.slug]) {
        scope.currentField = scope.resource.fields[scope.field.slug].value;
        scope.selectType(scope.currentField.type);
      }

      scope.$watch('currentField', function (field) {
        scope.resource.fields[scope.field.slug] = field;
      }, true);

      scope.remove = function () {
        scope.currentField = { search: '', type: scope.currentField.type, type_name: scope.currentField.type_name };
      };

      scope.select = function(object) {
        scope.options = [];
        scope.ngModel = object.title;
      };

    }
  }
});

app.directive('spMediaField', function($rootScope) {
  return {
    replace: true,
    transclude: true,
    template: '<div><button class="btn" ui-sref=".media({field: field.slug, folder: 0})">Select Media</button>' +
      '<div class="panel-body" ng-show="displayMedia.length"><sp-media-items media="displayMedia" sp-hide-add-folders sp-hide-media-breadcrumbs></sp-media-items></div>' +
      '</div>',
    link: function(scope) {
      var images = scope.resource.fields[scope.field.slug];
      scope.displayMedia = [];


      if (!angular.isArray(images) && images) {
        images = [images.value];
      }

      if (!angular.isArray(images)) {
        images = [];
      }

      scope.resource.fields[scope.field.slug] = (scope.field.multiple === "1")? images : images[0];

      if (images.length) {
        scope.displayMedia = images;
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

