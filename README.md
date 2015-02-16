[![Latest Stable Version](https://poser.pugx.org/ridesoft/azurecloudmap/v/stable.svg)](https://packagist.org/packages/ridesoft/azurecloudmap) [![Total Downloads](https://poser.pugx.org/ridesoft/azurecloudmap/downloads.svg)](https://packagist.org/packages/ridesoft/azurecloudmap) [![Latest Unstable Version](https://poser.pugx.org/ridesoft/azurecloudmap/v/unstable.svg)](https://packagist.org/packages/ridesoft/azurecloudmap) [![License](https://poser.pugx.org/ridesoft/azurecloudmap/license.svg)](https://packagist.org/packages/ridesoft/azurecloudmap)
# AzureCloudMap

PHP Utility library to interface with Microsoft Azure Cloud API filesystem that works as in Laravel 4.2 as in pure php.

## Use it in Laravel

### Install

Add to your laravel application composer:
```
"require": {
        "ridesoft/azurecloudmap": "0.4.*"
    },
```
**Due to  microsoft/windowsazure dependency you must put your minimun stability to dev**
```
    "minimum-stability": "dev"
```
Type composer install or composer update.

In your app/config/app.php add in array providers:
```
'ridesoft\AzureCloudMap\AzureCloudMapServiceProvider'
```
and in array aliases:
```
'AzureIO'           => 'ridesoft\AzureCloudMap\Facades\AzureIO',
'AzureUrl'          => 'ridesoft\AzureCloudMap\Facades\AzureUrl'
```

now publish your configuration with:
```
php artisan config:publish ridesoft/azurecloudmap
```

Set your Azure parameters

## Use it pure PHP
### Install

Add to your laravel application composer:
```
"require": {
        "ridesoft/azurecloudmap": "0.4.*"
    },
```
Type composer install or composer update.

or

just download or clone this library

## Functions and API
All function are documented in the Api, inside the folder API

### Laravel

For laravel run function from Ioc Container:

For function in filesystem style, in example:
```
AzureIO::scandir($dir);
```
or for function url style:
```
AzureUrl::download($url);
```

### Pure Php
```
<?php
require __DIR__.'/../vendor/autoload.php';
use ridesoft\AzureCloudMap\AzureIO;
$config = require_once 'src/config/config.php';
$azure = new AzureIO($config);
echo var_dump($azure->scandir('pdf'));
```

You can find similar examples in *examples* folder
