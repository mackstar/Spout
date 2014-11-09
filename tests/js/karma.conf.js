module.exports = function (config) {
  config.set({
    basePath : '',

    frameworks : ["jasmine"],

    files : [

      '../../dist/spout-admin/js/lib/jquery.js',
      '../../dist/spout-admin/js/lib/lodash.underscore.min.js',
      '../../dist/spout-admin/js/lib/angular.js',
      '../../dist/spout-admin/js/lib/angular-route.js',
      '../../dist/spout-admin/js/lib/angular-ui-router.js',
      '../../dist/spout-admin/js/lib/angular-mocks.js',
      '../../dist/spout-admin/js/lib/restangular.min.js',
      'tests/testBase.js',
      '../../dist/spout-admin/js/apps/**/*.js',
      '../../dist/spout-admin/js/directives/**/*.js',
      'tests/**/*.js'
    ],

    exclude: [
      '../../dist/spout-admin/js/apps/**/routes.js',
    ],

    logLevel: config.LOG_INFO,

    autoWatch : true,
    colors : true,
    port : 9877,
    runnerPort : 9101,

    browsers : ['PhantomJS'],

    reporters: ['progress'],

    junitReporter : {
      outputFile : 'test_out/unit.xml',
      suite      : 'unit'
    }
  });
}