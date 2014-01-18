BEAR.Skeleton
=============================

BEAR.Skeleton relies on BEAR.Package which can be downloaded [here](http://github.com/koriym/BEAR.Package).

This is a skeleton app which can be used a base for your own BEAR.Sunday applications. You can build the app by entering the following command.

    $ cd bear/apps
    $ composer create-project bear/skeleton ./{yourAppName}
    // Console
    $ php web.php get /
    // Web
    $ php -S localhost:8090 web.php

Structure
----------------------------

This is an example meaning that you can change any part of it to how you like to for your application. But this bear bones example is a good place to start.

Where to start
----------------------------

First lets try to have a basic understanding of how the bootstrap process works. There are 3 default entry points for development, api usage and production use these are `bootstrap/contexts/prod.php`, `dev.php` and `api.php` respectively.

The app is then booted procedurally, you can manipulate this bootstrap process in anyway you please by either adding or editing scripts in the `bootstrap/contexts` directory and any of the entry point script files you may be using.

Modules
----------------------------

Although the procedural bootstrap process offers flexibility in setting up your application BEAR.Sunday's real power starts to kick in through wiring dependencies together. This all takes place in the `Modules` directory. A number of defaults for the `App` and several runtime *modes* are available to you here. These can also be edited or added to at will.

Configuration
----------------------------

Even though there is a `config` folder with several runtime modes catered for, here you can add database settings and the like. But please do not be fooled that a configuration with an idea of state is how a BEAR.Sunday application works.

The values in here are injected by the relevant module.


Page and App Resources
----------------------------

`page` and `app` resources are added in the resources directory along with any template views that you may choose to add.

Other
----------------------------

Other custom classes you may want to add can be added freely, some predefined namespaces such as `Annotation`, `Params` and `Interceptor` have been prepared for you. Tests should be added to the tests directory in an appropriate namespace.
