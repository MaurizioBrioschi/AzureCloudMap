<?php
require __DIR__.'/../vendor/autoload.php';

use ridesoft\Azure\AzureIO;

$config = require_once 'src/config/config.php';
$azure = new AzureIO($config['azure']['connectionstring']);

$azure->copy('pdf', 'e3e50cf02910fe819538030ce2dd498f/vol_07_sat.pdf', '/var/www/html/static.paperapp.local/e3e50cf02910fe819538030ce2dd498f/tmp/vol_07_sat.pdf');
echo var_dump($azure->scandir('pdf/e3e50cf02910fe819538030ce2dd498f'));
