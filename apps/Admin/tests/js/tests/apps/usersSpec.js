'use strict';

describe('Users App', function () {

  var scope,
    httpBackend,
    UsersCtrl;

  describe('Index', function () {

    beforeEach(function () {
      angular.mock.module('Application');
      inject(
        function ($rootScope, $controller, _$httpBackend_) {

          scope = $rootScope.$new();
          httpBackend = _$httpBackend_;
          httpBackend.whenGET('/users/index').respond(
            '{"users": [{"id":1,"name":"tester"},{"id":2,"name":"tester2"}], "_model": "users"}'
          );
          UsersCtrl = $controller('UsersCtrl', {$scope: scope});
        }
      );
    });

    it('should receive a list of users on load', function () {
      httpBackend.flush();
      expect(scope.users.length).toBe(2);
    });

  });

});
