module.exports = function (config) {
  config.set({
    basePath : '',

    frameworks : ["jasmine"],

    files : [
      '../../var/www/js/lib/jquery.js',
      '../../var/www/js/lib/lodash.underscore.min.js',
      '../../var/www/js/lib/angular.min.js',
      '../../var/www/js/lib/angular-ui-router.js',
      '../../var/www/js/lib/angular-mocks.js',
      '../../var/www/js/lib/restangular.min.js',
      'tests/testBase.js',
      '../../var/www/js/apps/**/*.js',
      '../../var/www/js/directives/**/*.js',
	    'tests/**/*.js'
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
