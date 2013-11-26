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
	    'tests/**/*.js'
    ],

    logLevel: config.LOG_INFO,

    //logLevel: config.LOG_DEBUG,

    autoWatch : true,
    colors : true,
    port : 9877,
    runnerPort : 9101,

    browsers : ['PhantomJS'],

    reporters: ['progress'],

    junitReporter : {
      outputFile : 'test_out/unit.xml',
      suite      : 'unit'
      //...
    }
  });
}


// frameworks = ["jasmine"]

// files = [
//   '../../var/www/*.js',
//   'tests/*.js'
// ];

// exclude = [];

// // web server port
// port = 9877;


// // cli runner port
// runnerPort = 9101;

// colors = true;

// //logLevel = karma.LOG_INFO;

// singleRun = false;

// captureTimeout = 60000;

// browsers = ['PhantomJS'];


// // Karma configuration
// // Generated on Thu Sep 12 2013 10:07:56 GMT+0100 (BST)

// module.exports = function(config) {
//   config.set({

//     // base path, that will be used to resolve files and exclude
//     basePath: '',


//     // frameworks to use
//     frameworks: ['jasmine'],


//     // list of files / patterns to load in the browser
//     files: [
//       'templates/*.js',
//       'tests/*.js'
//     ],


//     // list of files to exclude
//     exclude: [
      
//     ],


//     // test results reporter to use
//     // possible values: 'dots', 'progress', 'junit', 'growl', 'coverage'
//     reporters: ['progress'],


//     // web server port
//     port: 9876,


//     // enable / disable colors in the output (reporters and logs)
//     colors: true,


//     // level of logging
//     // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
//     logLevel: config.LOG_INFO,


//     // enable / disable watching file and executing tests whenever any file changes
//     autoWatch: true,


//     // Start these browsers, currently available:
//     // - Chrome
//     // - ChromeCanary
//     // - Firefox
//     // - Opera
//     // - Safari (only Mac)
//     // - PhantomJS
//     // - IE (only Windows)
//     browsers: ['PhantomJS'],


//     // If browser does not capture in given timeout [ms], kill it
//     captureTimeout: 60000,


//     // Continuous Integration mode
//     // if true, it capture browsers, run tests and exit
//     singleRun: false
//   });
// };
