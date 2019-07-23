# Doctrine4Legacy

## Simple wrapper for both Doctrine's DBAL and ORM for legacy apps.

Every day I have to work with legacy PHP 5.6 monolithic apps based on the custom-made framework. If you have some experience with Doctrine in Symfony framework, then you probably know how Doctrine's EntityManager eases the daily dev's life by simplifying everything.

This library provides a simple wrapper, so you can focus on developing your legacy app - but with the benefit of Doctrine technologies. Use it if you're fed up with your custom framework's DB abstraction level. No more deprecated mysql_connect errors, notices, warnings etc. Start building your database from the Doctrine CLI. After few years the move to any other proper framework relying on Doctrine will be much less troublesome.

Currently supports:
* Multiple database instances
* DB schema generated from Entities annotations

As a PHP developer I'm still a beginner, but feel free to criticize the code.

## How to use?

1. Install with Composer
```
composer require ckuran/doctrine4legacy
```
2. Copy .env.dist, cli-config.php to your root directory
3. Rename .env.dist to .env
4. Edit .env file and provide the access to a single or multiple databases via custom prefixes
5. Create bootstrap.php file in your script or include this code somewhere near loading the composer dependencies
```php
define('ROOT', __DIR__ . '/');

if (file_exists(ROOT . '.env')) {
    $env = new Dotenv();
    $env->load(ROOT . '.env');
}
```
6. You can add the wrappers to bootstrap.php or use it anywhere in your script:

Obtain the default DB with:
```php
$em   = DoctrineWrapper::getEntityManager();
$dbal = DoctrineWrapper::getConnection();
```

Obtain custom prefixed DB with:  
```php
$em   = DoctrineWrapper::getEntityManager('customPrefix');
$dbal = DoctrineWrapper::getConnection('customPrefix');
```
