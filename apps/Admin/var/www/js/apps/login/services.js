'use strict';

app.factory('CurrentUserService', [function() {
  var userState = {
    isLoggedIn: (window && window.sp && window.sp.user)? true : false,
    user: (window && window.sp && window.sp.user)? window.sp.user : null
  };
  return userState;
}]);

app.run(function ($rootScope, $state, CurrentUserService) {
    $rootScope.$on("$stateChangeStart", function(event, toState){
      if (toState.authenticate && !CurrentUserService.isLoggedIn){
        // User isn’t authenticated
        $state.transitionTo("login");
        event.preventDefault();
      }
    });
});
