Mackstar.Spout
=======
The resource centric CMS written in BEAR.Sunday and Angular.js

Why do we need another PHP CMS? How is Spout Different?
---------------------------------------------

* A resource centric CMS.
* Pages, blog posts, menus and blocks available as resources.
* Create your own custom resource types.
* Angular.JS based single page admin app is provided.
* The admin app merely is a consumer of the RESTful API that is powering your app.
* Overriding of core CMS simply by using DI and AOP and adding your own resources.
* A modern PHP developer friendly setup.
* Embed content into any PHP app (Laravel, Symfony, Zend Framework etc) All welcome!
* To maximise integration with other composer based PHP libraries.
* Everything is a resource, you can manipulate anything in any REST client.

Contributing
---------------------------------------------

I am looking for others to work with me on this app. Please send your pull requests in!

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
 * Apache - (will add NGINX examples soon).

Getting started
---------------

## Installation

To install Spout you need to checkout [the example app](https://github.com/mackstar/Spout-Site)

```
git clone git@github.com:mackstar/Spout-Site.git {yourapp}
cd {yourapp}
composer install
```

### Contexts

There are various contexts that can be implemented and you may have for example both production and api. You can add any contexts as you wish the default included contexts are as follows:

* api
* dev
* test
* production

### Database Config

Edit database configuration files in `conf/contexts/{context}.php` to match up the context to your database. The context would usually be (dev|test|production). Default base config files are added at `conf/defaults.php`


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

### Installation command

From inside your site run ./vendor/bin/spout install -e {ENV}

### Apache

Set your `DocumentRoot` to `"{DOCUMENT_ROOT}/var/www"`

### Contexts


### Routes

Default routing is based on Aura Router

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
 $ ./vendor/bin/spout migrate -p php -c config.php -e development
```

### Rollback
```
$ ./vendor/bin/spout rollback -e testing -c config.php -t 0
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
