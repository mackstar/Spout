Mackstar.Spout
=======
A fast developer happy CMS written in BEAR.Sunday and Angular.js

Why do we need another PHP CMS?
---------------------------------------------

* To create an resource centric CMS
* To integrate Angular.js for a better experience
* To have a fully responsive CMS
* To create a CMS with more speed
* To allow overriding of core CMS activity using DI and AOP
* To provide a platform that modern PHP developers are more comfortable developing in
* To maximise integration with othor composer based PHP libraries
* Everything is resource, you can manipulate anything in any REST client.

Contributing
---------------------------------------------

This project will be hard to get off the ground without some of you pitching in! It is about writing a CMS framework that can be extended but one that developers will love using. Spout has been designed to be easy to test and is very much 'Test driven'. 

Other tools
---------------------------------------------

 * phpunit.xml for [phpunit](http://phpunit.de/manual/current/en/index.html)
 * .travis.yml for [Travis CI](https://travis-ci.org/)
 * Grunt
 * Angular.js
 * Karma
 * Jasmine
 * Twitter Bootstrap

Requirements
------------
 * PHP 5.4+

Getting started
---------------

### Install project
```
 $ vendor/robmorgan/phinx/bin/phinx migrate -p php -c config.php -e development
```

### Rollback
```
$ vendor/robmorgan/phinx/bin/phinx rollback -e testing -c config.php -t 0
```

### Environments
* development
* testing
* production

### CSS
CSS files live in `apps/Admin/var/lib/less` and you can compile the css by running
```
grunt css
```
