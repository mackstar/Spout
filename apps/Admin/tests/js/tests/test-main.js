//var tests = Object.keys(window.__karma__.files).filter(function (file) {
//      return /Spec\.js$/.test(file);
//});
//
define('live-experience/config', function() {
    var config = {
        istatsUrl: 'http://sa.bbc.co.uk/bbc/live-experience/s?name=',
        staticPrefix: 'http://static.bbc.co.uk/live-experience',
        isUk: '1',
        counterName: 'example.counter.name'
    };
    return config;
});

define('live-experience/defaults', function () {
    return {
        'session-image': 'http://example.com/test-image.jpg'
    };
});

define('live-experience/coverage', function () {
    return false;
});

define('live-experience/services', function () {
    return {};
});

define('bump-3', function () {
    return function(){
        this.config = {};
        return {
            player: function(configs) {
                var config = configs;
                return {
                    play: function() {},
                    load: function() {},
                    bind: function() {},
                    getConfig: function() {
                        return config;
                    }
                }
            }
        }
    };
});

define('live-experience/historyData', [], function () {
    return {};
});

define('istats-1', function () {
    return {
        log: function () {
        }
    };
});

define('jquery-1.9', ['jquery'], function ($) {
    return $;
});

var tests = Object.keys(window.__karma__.files).filter(function (file) {
    return /Spec\.js$/.test(file);
});

requirejs.config({
    baseUrl: '/base/src',

    paths: {
        'jquery': '../lib/jjquery-1.91',
        'angular': '../lib/angular',
        'lodash': '../lib/lodash-1.2.1',
        'sinon': '../lib/sinon',
        'MomentDateUtility': '../lib/moment.min',
        'MomentMock': '../test/live-experience/mocks/moments_mock',
        'iStatsMock': '../test/live-experience/mocks/istats_mock',
        'linkUtilityMock': '../test/live-experience/mocks/link_utility_mock'
    },

    shim: {
        angular: {
            exports: 'angular'
        },
        sinon: {
            exports: 'sinon'
        },
        MomentDateUtility : {
            exports: 'moment'
        }
    },

    // ask Require.js to load these files (all our tests)
    deps: tests,

    // start test run, once Require.js is done
    callback: window.__karma__.start
});