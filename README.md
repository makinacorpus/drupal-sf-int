# Symfony better integration for Drupal 8

This module brings some Symfony missing bits to Drupal 8, as long as a few
helpers to work with Symfony code into Drupal.

It's the Drupal 8 version of https://github.com/makinacorpus/drupal-sf-dic
module. It exists in a different repository since Drupal 8 brings some of the
Symfony components by itself.

This module is work-in-progess althought it should stable enought.

# Features

 - brings an event driven API based upon symfony/event-dispatcher component
   for building node access ACLs,

 - brings event driven API that replaces Drupal hooks for entities,

 - brings a basic integration of symfony/property-info and
   symfony/property-access components if they are present in vendor
   dependencies,

 - brings almost complete symfony/security component integration, for using
   voters and other niceties such as the authorization checker and the
   is_granted() method, both in code and twig.

And a lot more to come!

# Install and use

You need your Drupal installation to be fully composed-based.
Just install it using composer, then enable the module.

# Set-up the autoloader

Write the ``/path/to/webroot/autolaod.php`` file:

```php
return include dirname(__DIR__) . '/vendor/autoload.php';
```

Then the ``/path/to/webroot/index.php`` file:

```php
use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;
$loader = require_once dirname(__DIR__) . '/vendor/autoload.php';
$kernel = new DrupalKernel('dev', $loader);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
```

For the rest, it's up to you and your Drupal 8 configuration that should just
work gracefully on top of those two files (Drush and Drupal Console included).
