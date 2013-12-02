app.directive(
    'rolesSelector',
    ['Restangular',
        function (Restangular) {
            return {
                restrict: 'AC',
                transclude: true,
                replace: true,
                template: "<select><options></options></select>",
                link: function (element, attributes) {
                    

                }
            };
        }
    ]
);