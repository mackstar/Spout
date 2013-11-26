module.exports = function(grunt) {

  grunt.initConfig({
    karma: {
      unit: {
        configFile: 'apps/Admin/tests/js/karma.conf.js',
        reporters: ['dots']
      },
      ci: {
        configFile: 'apps/Admin/tests/js/karma.conf.js',
        reporters: ['junit', 'dots'],
        singleRun: true
      },
    },

  });

  // grunt.loadNpmTasks('grunt-contrib-uglify');
  // grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-karma');


  grunt.registerTask('default', ['karma']);
  grunt.registerTask('js', ['karma:unit']);


};