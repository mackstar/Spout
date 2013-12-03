app.directive(
    'rolesSelector',
    ['Restangular',
        function (Restangular) {
            return {
                restrict: 'E',
                transclude: true,
                replace: true,
                template: "<select ng-model='role' ng-options='role.name for role in roles'></select>",
                link: function ($scope) {
                    Restangular.all('users/roles').getList().then(function (data) {
                        $scope.roles = data.roles;
                        $scope.role = $scope.roles[0];
                    });                    
                }
            };
        }
    ]
);