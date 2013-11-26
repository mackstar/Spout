'use strict';

describe('Users App', function() {

  var scope, httpBackend, UsersCtrl;
 
  describe('Index', function() {

    beforeEach(angular.mock.module('Application'));
    //mock the controller for the same reason and include $rootScope and $controller
    beforeEach(angular.mock.inject(function($rootScope, $controller, _$httpBackend_){
        scope = $rootScope.$new();
        httpBackend = _$httpBackend_;
        httpBackend.whenGET('/users/index').respond(
            '{"users":[{"name":"tester"},{"name":"tester2"}]}'
        );
        UsersCtrl = $controller('UsersCtrl', {$scope: scope});
    }));
 
    it('should recieve a list of users on load', function() {

    
    	httpBackend.flush();
        expect(scope.users.length).toBe(2);

    });
  });
});
