describe('Users App', function() {

  var scope,
    httpBackend,
    UsersCtrl;
 
  describe('Index', function() {

    beforeEach(function () {
        angular.mock.module('Application');
        inject(
            function ($rootScope, $controller, _$httpBackend_) {

                scope = $rootScope.$new();
                httpBackend = _$httpBackend_;
                httpBackend.whenGET('/users/index').respond(
                    '{"users": [{"id":1,"name":"tester"},{"id":2,"name":"tester2"}], "_model": "users"}'

                    //'{[{"id":1, "name": "Admin"},{"id":2, "name": "Contributor"}], "_model": "roles"}'
                );
                UsersCtrl = $controller('UsersCtrl', {$scope: scope});
            }
        );
    });
 
    it('should recieve a list of users on load', function() {
        httpBackend.flush();
        expect(scope.users.length).toBe(2);
    });

  });

});
