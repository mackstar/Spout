var app = angular.module('myApp', ['restangular', 'ui.router']);

app.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{[').endSymbol(']}');
});

app.run(function(Restangular, $rootScope) {
  Restangular.setBaseUrl('/api');
  // Restangular.setResponseInterceptor(function(data, operation, what, request, response) {
  //   if (data.message) {
  //     $rootScope.$emit('message', {message: data.message});
  //   }
  //   return data;
  // });
  // Restangular.setErrorInterceptor(function(response) {
  //   if (response.status === 403) {
  //     window.location.href = "/login/";
  //   }
  //   if (response.data && response.data.message) {
  //     $rootScope.$emit('message', {message: response.data.message, status: response.status})
  //   }
  // });
  // Restangular.setFullRequestInterceptor(function(element, operation, route, url, headers, params) {
  //     return {
  //       element: element,
  //       params: params,
  //       headers: headers
  //     };
  // });

});

