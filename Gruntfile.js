var mackstar = {}
mackstar.build  = {}
mackstar.build.getPhpFileFilter = function(name) {

  name = name.split('Test.php')[0];
  name = name.split('.php')[0];
  if (name.indexOf("/") !== -1) {
    dirs = name.split('/');
    name = dirs[dirs.length -1];
  }
  return name;
}


module.exports = function(grunt) {

  var env = grunt.option('env') || 'development',
    name;

  grunt.initConfig({
    php: {
      filter: ""
    },
    watch: {
      admin: {
        files: ['apps/Admin/**/*.php'],
        tasks: ['shell:phpunit_admin'],
        options: {
          nospawn: true
        }
      },
      base: {
        files: ['src/**/*.php', 'tests/**/*.php'],
        tasks: ['shell:phpunit_base'],
        options: {
          nospawn: true
        }
      }
    },

    shell: {
      options: {
        stdout: true
      },
      migrate: {
        command: "vendor/robmorgan/phinx/bin/phinx --configuration=config.php migrate -e" + env,
        create: {
          command: "vendor/robmorgan/phinx/bin/phinx --configuration=config.php -e" + env + " create " + name
        }
      },
      phpunit_admin: {
        command: "cd apps/Admin && phpunit <%= php.filter %>"
      },
      phpunit_base: {
        command: "phpunit <%= php.filter %>"
      },
      phpunit: {
        command: "phpunit && cd apps/Admin && phpunit"
      }
    },
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
    }
  });

  // grunt.loadNpmTasks('grunt-contrib-uglify');
  // grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-karma');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('migrate', function() {
    grunt.task.run("shell:migrate");
  });
  grunt.event.on('watch', function(action, filepath) {
    filter = mackstar.build.getPhpFileFilter(filepath);
    console.log(filter);
    //grunt.config(['php', 'filter'], '--filter ' + filter);
    grunt.config(['php', 'filter'], "--filter " + filter);

  });
  grunt.registerTask('default', ['karma']);
  grunt.registerTask('js', ['karma:unit']);
  grunt.registerTask('phpunit', ['shell:phpunit']);


};