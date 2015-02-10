<?php
require __DIR__.'/../vendor/autoload.php';

use ridesoft\Azure\AzureIO;

$config = require_once 'src/config/config.php';
$azure = new AzureIO($config['azure']['connectionstring']);

$azure->copy('pdf', 'e3e50cf02910fe819538030ce2dd498f/test.pdf', '/var/www/html/test/vol_07_sat.pdf');
echo var_dump($azure->scandir('pdf'));
