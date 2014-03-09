describe('Roles Directive', function() {

    var scope,
        $element,
        httpBackend;

    beforeEach(function () {
        angular.mock.module('Application');
        inject(
            function ($rootScope, $compile, $injector) {
                var element = angular.element('<roles-selector />');
                httpBackend = $injector.get('$httpBackend');

                httpBackend.whenGET('/users/roles').respond(
                    '{"roles": [{"id": 1, "name": "Admin"},{"id": 2, "name": "Contributor"}], "_model": "roles"}'
                );
                scope = $rootScope;
                $compile(element)(scope);
                scope.$digest();
                $element = $(element);
            }
        );
        httpBackend.flush();
    });

    it('should have a select menu', function() {
        

        expect($element.prop("tagName")).toEqual('SELECT');
        expect($element.find("option").length).toBe(2);
    });
});