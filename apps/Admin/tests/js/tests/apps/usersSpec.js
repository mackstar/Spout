'use strict';

describe('Users App', function () {

  var scope,
    httpBackend,
    UsersCtrl;

  describe('Index', function () {

    beforeEach(function () {
      angular.mock.module('Application');
      inject(
        function ($rootScope, $controller) {
          var users = [{"id":1,"name":"tester"},{"id":2,"name":"tester2"}],
             roles = [{"id": 1, "name": "Admin"},{"id": 2, "name": "Contributor"}];
          scope = $rootScope.$new();
          UsersCtrl = $controller('UsersCtrl', {$scope: scope, users: users, roles: roles});

        }
      );
    });

    it('should receive a list of users on load', function () {
      expect(scope.users.length).toBe(2);
    });

  });

});
