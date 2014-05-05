'use strict';

describe('Roles Directive', function () {

  var scope,
    $element;


  beforeEach(function () {
    module('Application');
    angular.mock.inject(
      function ($rootScope, $compile, $httpBackend) {
        var element = angular.element('<roles-selector></roles-selector>');
        scope = $rootScope;
        scope.user = {};
        scope.roles = [{"id": 1, "name": "Admin"},{"id": 2, "name": "Contributor"}];
        $compile(element)(scope);
        scope.$digest();
        $element = $(element);
      }
    );
  });



  it('should have a select menu', function () {

    expect($element.prop("tagName")).toEqual('SELECT');
    expect($element.find("option").length).toBe(2);
  });
  
});