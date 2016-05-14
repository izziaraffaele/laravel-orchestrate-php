Laravel Orchestrate client
======

A service provider to use Orchestrate DBaas in your Laravel applications. Read the [full client documentation](https://github.com/andrefelipe/orchestrate-php) for more usage informations.

Requirements:
- PHP must be 5.5 or higher.
- [orchestrate-php](https://github.com/andrefelipe/orchestrate-php).
- [Guzzle 6](https://github.com/guzzle/guzzle) as HTTP client.
- [JMESPath](https://github.com/jmespath/jmespath.php).


## Instalation

Use [Composer](http://getcomposer.org).

Run this Composer command to install the latest stable version of the client:

```bash
composer require izziaraffaele/laravel-orchestrate-php
```

Register the Service provider in your `config/app.php` file

```bash
  'providers' => [
    IRWeb\Orchestrate\Provider::class,
  ]
```

Publish the configuration file running the command `php artisan vendor:publish` and add your API_KEY in the file `config/orchestrate.php`
