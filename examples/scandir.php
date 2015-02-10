<?php
require __DIR__.'/../vendor/autoload.php';

use ridesoft\Azure\AzureIO;

$config = require_once 'src/config/config.php';
$azure = new AzureIO($config['azure']['connectionstring']);
echo var_dump($azure->scandir('pdf'));