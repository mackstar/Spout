var app = angular.module('spout', ['restangular', 'ui.router']);

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
    if (response.status && response.data.message) {
      $rootScope.$emit('message', {message: response.data.message, status: response.status});
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

app.directive('errorWindow', function() {
  return {
    restrict: 'E',
    template: '<div class="row sp-float" ng-show="title">' +
    '<div class="col-md-8 col-md-offset-2 panel sp-panel panel-danger">' +
        '<div class="panel-heading">' +
            '<h4 class="panel-title"><span class="glyphicon glyphicon-warning-sign"></span> {{title}}</h4>' +
        '</div>' +
        '<div class="panel-body">' +
            '<p>{{message}}</p>' +
        '</div>' +
    '</div>' +
'</div>',
    link: function(scope) {
      setTimeout(function() {
        scope.$apply(function() {
          scope.title = 'Body padding required';
        });
      }, 3000);
      scope.message = 'This is moment content';
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