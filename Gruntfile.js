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
    name = grunt.option('name') || undefined;

  grunt.initConfig({
    php: {
      filter: ""
    },
    watch: {
      base: {
        files: ['src/**/*.php', 'tests/**/*.php'],
        tasks: ['shell:phpunit_base'],
        options: {
          nospawn: true
        }
      },
      admin: {
        files: ['dist/**/*'],
        tasks: ['shell:copy_admin_assets'],
        options: {
          nospawn: true
        }
      },
      css: {
        files: ['*/**/*.less'],
        tasks: ['shell:css'],
        options: {
          nospawn: true
        }
      }
    },

    shell: {
      options: {
        stdout: true
      },
      css: {
        command: "lessc lib/less/bootstrap.less > dist/spout-admin/css/bootstrap.min.css --compress"
      },
      migrate: {
        command: "vendor/robmorgan/phinx/bin/phinx --configuration=config.php migrate -e" + env
      },
      phpunit_base: {
        command: "phpunit <%= php.filter %>"
      },
      copy_admin_assets: {
        command: "cp -R dist/spout-admin/* ../../../var/www/spout-admin/"
      }
    },
    karma: {
      unit: {
        configFile: 'tests/js/karma.conf.js',
        reporters: ['dots']
      },
      ci: {
        configFile: 'tests/js/karma.conf.js',
        reporters: ['junit', 'dots'],
        singleRun: true
      },
    }
  });


  grunt.loadNpmTasks('grunt-karma');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('migrate', function() {
    grunt.task.run("shell:migrate");
  });
  grunt.registerTask('migrate:create', function() {
    grunt.task.run("shell:migrate_create");
  });
  grunt.registerTask('migrate:rollback', function() {
    grunt.task.run("shell:migrate_rollback");
  });
  grunt.event.on('watch', function(action, filepath) {
    filter = mackstar.build.getPhpFileFilter(filepath);
    grunt.config(['php', 'filter'], "--filter " + filter);

  });
  grunt.registerTask('default', ['karma']);
  grunt.registerTask('js', ['karma:unit']);
  grunt.registerTask('css', ['shell:css']);
  grunt.registerTask('phpunit', ['shell:phpunit']);

  grunt.registerTask('build', ['karma:ci']);


};