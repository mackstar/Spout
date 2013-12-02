describe('Roles Directive', function() {

    var scope,
        element,
        $element;

    beforeEach(angular.mock.module('Application'));
    beforeEach(function () {

        inject(
            function ($rootScope, $compile, _$httpBackend_) {
                var element = angular.element('<div roles-selector></div>');
                scope = $rootScope;
                scope = $rootScope;
                $compile(element)(scope);
                scope.$digest();
                $element = $(element);

            }
        );
    });

    it('should have a select menu', function() {
        expect($element.prop("tagName")).toEqual('SELECT');
    });
});