var app = angular.module('spout', ['ngRoute', 'restangular', 'ngAnimate']);

app.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{[').endSymbol(']}');
});

app.run(function(Restangular, $rootScope) {
  Restangular.setBaseUrl('/api');
  //Restangular.setResponseInterceptor(function(data, operation, what, request, response) {
  //   if (data.message) {
  //     $rootScope.$emit('message', {message: data.message});
  //   }
  //   return data;
  // });
  Restangular.setErrorInterceptor(function(response) {
    if (response.status) {

      console.log("emit");
      $rootScope.$emit('sp.message', {title: "Something was wrong", message: "Something was wrong", type: "danger"});
    }
    return response;
  });
  // Restangular.setFullRequestInterceptor(function(element, operation, route, url, headers, params) {
  //     return {
  //       element: element,
  //       params: params,
  //       headers: headers
  //     };
  // });

});

app.directive('errorWindow', function($rootScope, $timeout) {
  return {
    restrict: 'E',
    template: '<div class="row sp-float animate-show" ng-show="show">' +
    '<div class="col-md-8 col-md-offset-2 panel sp-panel panel-danger">' +
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

      scope.show = true;
      scope.title = "There was a validation error";
      scope.message = "This is what went wrong.";

      $rootScope.$on('sp.message', function(obj, options) {
        scope.show = true;
        scope.title = options.title;
        scope.message = options.message;
        scope.type = options.type;
        $timeout(restore, 3000);
      });
    }
  }
});

app.controller('ModalCtrl', function($rootScope, $element) {
  console.log("modal controller");
  $rootScope.$on('modal.open', function(){
    console.log("open");
    $($element).modal('show');
  });
    
});