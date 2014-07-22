app.directive('spDraggable', ['$rootScope', function($rootScope) {
  return {
    restrict: 'A',
    link: function(scope, el, attrs, controller) {
      angular.element(el).attr("draggable", "true");

      el.bind("dragstart", function(e) {
        $rootScope.$emit("LVL-DRAG-START");
      });

      el.bind("dragend", function(e) {
        $rootScope.$emit("LVL-DRAG-END");
      });
    }
  }
}]);
app.directive('spDropTarget', ['$rootScope', function($rootScope) {
  return {
    restrict: 'A',
    scope: {
      onDrop: '&'
    },
    link: function(scope, el, attrs, controller) {

      el.bind("dragover", function(e) {
        if (e.preventDefault) {
          e.preventDefault(); // Necessary. Allows us to drop.
        }

        e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
        return false;
      });

      el.bind("dragenter", function(e) {
        // this / e.target is the current hover target.
        console.log("drag enter");
        angular.element(e.target).addClass('lvl-over');

      });

      el.bind("dragleave", function(e) {
        angular.element(e.target).removeClass('lvl-over');  // this / e.target is previous target element.
      });

      el.bind("drop", function(e) {
        console.log("drop");
        if (e.preventDefault) {
          e.preventDefault(); // Necessary. Allows us to drop.
        }

        if (e.stopPropogation) {
          e.stopPropogation(); // Necessary. Allows us to drop.
        }

        scope.onDrop({});
      });

      $rootScope.$on("LVL-DRAG-START", function() {
        angular.element(el).addClass("lvl-target");
      });

      $rootScope.$on("LVL-DRAG-END", function() {
        angular.element(el).removeClass("lvl-target");
        angular.element(el).removeClass("lvl-over");
      });
    }
  };
}]);