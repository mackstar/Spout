Mackstar.Spout
=======
The resource centric CMS written in BEAR.Sunday and Angular.js

Why do we need another PHP CMS?
---------------------------------------------

* To create an resource centric CMS
* To make all pages, blog posts, menus and blocks available as resources
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

## Installation

Edit database configuration files in `apps/Admin/var/conf/{environment}.php` to match up to your database.

### Database

####SQLite

```
<?php

$config = [
    'driver' => 'pdo_sqlite',
    'path' => '../../test_db.sqlite3', // sets DB location to root path
    'charset' => 'UTF8'
];

return [
    'master_db' => $config,
    'slave_db' => $config
];
```

####MySql

My `production.php` file looks something like this:

```
// @Named($key) => instance
$config = [
    // database
    'master_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => $id,
        'password' => $password,
        'charset' => 'UTF8'
    ],
    'slave_db' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'spout',
        'user' => $slaveId,
        'password' => $slavePassword,
        'charset' => 'UTF8'
    ],
    // constants
    'app_name' => __NAMESPACE__,
    'tmp_dir' => "{$appDir}/var/tmp",
    'log_dir' => "{$appDir}/var/log",
    'lib_dir' => "{$appDir}/var/lib",
    'upload_dir' => "{$appDir}/var/www/uploads"
];


return $config;
```

### Apache

Set your `DocumentRoot` to `"/Users/MackstarMBA/Sites/Mackstar.Spout/apps/Admin/var/www"`

### Command line - from project root.

```
$ composer install
$ sudo npm install -g grunt-cli
$ npm install
$ grunt migrate -env={environment} // By default this is development
$ grunt phpunit // to run PHP tests
$ grunt karma // to run Javascript tests
```

### Create Admin user - only able to do when no user is available

```
curl -XPOST 'http://localdomain/api/users/index' -d '{
    "email": "richard.mackstar@gmail.com",
    "password": "secret",
    "name": "Richard McIntyre",
    "role": {
        "id": "1",
        "name": "Admin"
    }
}';
```

### Admin Access

You can access the control panel at
```
http://localdomain/spoutadmin
```


### Migration
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
