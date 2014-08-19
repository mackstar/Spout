'use strict';

app.directive('spFileDropzone', function(Restangular, $rootScope) {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      var checkSize, isTypeValid, processDragOverOrEnter, validMimeTypes;

      scope.folder = 0;
      processDragOverOrEnter = function(event) {
        if (event != null) {
          event.preventDefault();
        }
        event.dataTransfer.effectAllowed = 'copy';
        return false;
      };
      validMimeTypes = attrs.spFileDropzone;
      checkSize = function(size) {
        var _ref;
        if (((_ref = attrs.maxFileSize) === (void 0) || _ref === '') || (size / 1024) / 1024 < attrs.maxFileSize) {
          return true;
        } else {
          alert("File must be smaller than " + attrs.maxFileSize + " MB");
          return false;
        }
      };
      isTypeValid = function(type) {
        if ((validMimeTypes === (void 0) || validMimeTypes === '') || validMimeTypes.indexOf(type) > -1) {
          return true;
        } else {
          alert("Invalid file type.  File must be one of following types " + validMimeTypes);
          return false;
        }
      };
      element.bind('dragover', processDragOverOrEnter);
      element.bind('dragenter', processDragOverOrEnter);

      $rootScope.$on('sp.media.folder-change', function(event, data) {
        scope.folder = data.folder;
      });

      return element.bind('drop', function(event) {
        var file, name, reader, size, type;

        scope.uploading = true;
        if (event != null) {
          event.preventDefault();
        }
        reader = new FileReader();
        reader.onload = function(evt) {
          if (checkSize(size) && isTypeValid(type)) {
            return scope.$apply(function() {
              scope.file = evt.target.result;
              if (angular.isString(scope.fileName)) {
                return scope.fileName = name;
              }
            });
          }
        };
        file = event.dataTransfer.files[0];
        name = file.name;
        type = file.type;
        size = file.size;
        reader.readAsDataURL(file);

        var formData = new FormData();
        formData.append('folder', scope.folder);
        formData.append('name', file.name);
        formData.append('file', file);


        Restangular.all('media')
          .withHttpConfig({transformRequest: angular.identity})
          .customPOST(formData, 'index', undefined, {'Content-Type': undefined}).then(function(mediaItem) {
            mediaItem.route = "media/index";
            mediaItem.selected = true;
            scope.media.unshift(mediaItem);
            scope.uploading = false;
          });
        return false;
      });
    }
  };
});

app.directive('spThumbnail', function (Restangular) {
  return {
    restrict: 'E',
    template: "<img src='/spout-admin/img/spinner.gif' ng-click='select()' />",
    scope: { media: "=media"},
    replace: true,
    link: function(scope, element, attrs) {

      var src = '/uploads/media/' + scope.media.directory + '/140x140_' + scope.media.file,
        img = new Image();

      function loadImage() {
        element[0].src = src;
      }

      scope.select = function () {
        if (!scope.media.selected) {
          scope.media.selected = true;
          return;
        }
        scope.media.selected = false;
      };

      scope.$watch('media.selected', function (selected, previouslySelected) {
        if (selected) {
          element.parent().addClass("selected");
          scope.$parent.$emit("sp.media-selected", scope.media);
        }
        if (!selected && previouslySelected) {
          element.parent().removeClass("selected");
          scope.$parent.$emit("sp.media-deselected", scope.media);
        }
      });

      img.src = src;
      img.onerror = function() {
        Restangular.all('media/resize').post({media: scope.media, height: 140, width: 140}).then(function() {
          loadImage();
        });
      };
      img.onload = function() {
        scope.$apply(function() {
          loadImage();
        });
      };
    }
  }
});

app.directive('spMediaItems', function ($state, $stateParams, Restangular, $rootScope) {
  return {
    restrict: 'E',
    scope: { media: "=media", folders: "=folders" },
    templateUrl: '/spout-admin/js/templates/media/media-items.html',
    replace: true,
    link: function(scope, element, attrs) {

      scope.folder = 0;

      scope.breadcrumbs = [{folder: 0, name: 'Top'}];

      scope.changeFolder = function (folder) {
        var params = {folder: folder.id};
        scope.folder = folder.id;

        $rootScope.$emit('sp.media.folder-change', params);


        angular.forEach(scope.breadcrumbs, function(breadcrumb, index) {
          if (breadcrumb.id === folder.id) {
            scope.breadcrumbs.splice(index, scope.breadcrumbs.length - index);
          }
        });

        scope.breadcrumbs.push(folder);

        params = angular.extend($stateParams, params);
        scope.folders.getList({parent: $stateParams.folder}).then(function (folders) {
          scope.folders = folders;
        });
        scope.media.getList({folder: $stateParams.folder}).then(function (media) {
          $rootScope.$emit('sp.media.updated', media);
        });
      }
      if (attrs.spHideAddFolders !== undefined) {
        scope.hideAddFolder = true;
      }
    }
  };
});