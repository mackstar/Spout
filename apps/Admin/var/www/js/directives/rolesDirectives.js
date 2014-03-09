app.directive(
    'rolesSelector',
    ['Restangular',
        function (Restangular) {
            return {
                restrict: 'E',
                transclude: true,
                replace: true,

                template: "<select ng-model='user.role' class='form-control' ng-show='roles' ng-options='role.name for role in roles'></select>",
                link: function ($scope) {

                    // $scope.selectedRole = 0;

                    // $scope.selectRole = function(id) {
                    //     if (id) {
                    //         $scope.selectedRole = id;
                    //     }
                    //     if (!$scope.roles) {
                    //         return;
                    //     }
                    //     if ($scope.selectedRole === 0) {
                    //         $scope.selectedRole = $scope.roles[0].id;
                    //     }
                    //     $scope.user = $scope.user || {};
                    //     $scope.user.role = _.where($scope.roles, {id: $scope.selectedRole})[0];
                    // }            
                }
            };
        }
    ]
);