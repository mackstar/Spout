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

From inside your site run ./vendor/bin/spout install -e {CONTEXT}

### Apache

Set your `DocumentRoot` to `"{DOCUMENT_ROOT}/var/www"`

### Apps

You can make your website up of more than one Spout app. The other apps you have will be installed via composer. The app settings live in `conf/apps.php`

The example app has been added as `bobscars` and lives in the local `src` directory as the PSR-4 namespace `Bob\BobsCars`.

If for example Bob's cars was reliant on another Spout app called `Bob\BobsCarStock` you can add that the config would look like:

```
return [
    'site' => 'Bobs Cars',
    'apps' => [
        'bobscars' => ['namespace' => 'Bob\\BobsCars'],
        'bobsstock' => ['namespace' => 'Bob\\BobsCarStock']

		
    ],
    'default' => 'bobscars'
];
```

*** Note: JS, CSS and the `www` webroot will not be shared. You will need to arrange the copying of these yourself.***

Resources, Interceptors and Routes will all be available to you normally.


### Routes

Default routing is based on Aura Router. Example routes have been added to `conf/routes.php`

```
$routes->add('bobscars', [
    ['home', '/', 'index'],
    ['blog-index', '/blog/', 'blog/index', ['tokens' => ['slug' => '[^/]+']]],
    ['blog-detail', '/blog/{slug}', 'blog/detail', ['tokens' => ['slug' => '[^/]+']]],
    ['cardetail', '/cardetail/{id}', 'cars/detail'],
    ['car_resource', '/api/cardetail/{slug}', 'resources/detail', [
            'tokens' => ['slug' => '[^/]+'],
            'values' => ['type' => 'cars']
        ]
    ]
]);
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
http://{YOURDOMAIN}/spoutadmin
```


### Migration
```
 $ ./vendor/bin/spout migrate -e {CONTEXT}
```

### Rollback
```
$ ./vendor/bin/spout rollback -e {CONTEXT} -t 0
```
