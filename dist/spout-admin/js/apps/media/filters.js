'use strict';
app.filter('mediaFileName', function () {
  return function (media) {
    if (!media) {
      return;
    }
    return media.file.replace(media.uuid + "_", "");
  };
});