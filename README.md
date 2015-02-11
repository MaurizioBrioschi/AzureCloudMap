# AzureCloudMap
PHP Utilities for Azure cloud API filesystem for Laravel 4.2

Permit to inteface with Microsoft Azure cloud using same function sintax similar in PHP.

## Install

Add to your laravel application composer:
```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ridesoft/AzureCloudMap.git" 
        }
     ],
"require": {
        "ridesoft/AzureCloudMap": "0.2.*"
    },
```
Type composer install or composer update.

In your app/config/app.php add in array providers:
```
'ridesoft\AzureCloudMap\AzureCloudMapServiceProvider'
```
and in array aliases:
```
'AzureIO'           => 'ridesoft\AzureCloudMap\Facades\AzureIO'
```

now publish your configuration with:
```
php artisan config:publish ridesoft/azurecloudmap
```

## Use
To list blob in a container:
```
AzureIO::scandir('pdf')
```







