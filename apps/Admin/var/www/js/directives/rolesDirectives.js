app.directive(
    'rolesSelector',
    ['Restangular',
        function (Restangular) {
            return {
                restrict: 'E',
                replace: true,

                template: "<select ng-model='user.role' class='form-control' ng-show='roles' ng-options='role.name for role in roles'></select>",
                link: function ($scope) {

                        selectedRole = $scope.roles[0].id;
                        $scope.user.role = _.where($scope.roles, {id: selectedRole})[0];


                }
            };
        }
    ]
);