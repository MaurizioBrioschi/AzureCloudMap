<?php
require __DIR__.'/../vendor/autoload.php';
use ridesoft\AzureCloudMap\AzureIO;
$config = require_once 'src/config/config.php';
$azure = new AzureIO($config);
echo var_dump($azure->scandir('pdf'));

